<script id="manager-directives-vue">
    Vue.directive('rec', {
        inserted(el, binding, vnode) {
            initRecorder(el, binding, vnode);
        },

        componentUpdated(el, binding) {
            const $root = $(el);
            const state = $root.data('rec-state');
            if (!state) return;

            const config = binding.value || {};

            const file = (config.existingFiles && config.existingFiles.length)
                ? config.existingFiles[0]
                : null;

            state.setExisting(file);
        },

        unbind(el) {
            const $root = $(el);
            $root.removeData('rec-state');
        }
    });

    function initRecorder(el, binding, vnode) {

        const $root = $(el);
        let config = binding.value || {};

        let mediaRecorder = null;
        let mediaStream = null;
        let audioChunks = [];
        let audioBlob = null;

        // 🔥 SOLO 1 archivo
        let existing = (config.existingFiles && config.existingFiles.length)
            ? config.existingFiles[0]
            : null;

        let newFile = null;

        // -------------------------
        // TEMPLATE
        // -------------------------
        const template = `
        <div class="rec__header">
            <div class="rec__title">${config.label || 'Grabación'}</div>
        </div>

        <div class="rec__controls">
            <button type="button" class="rec__btn rec__btn--rec">🎙️ Grabar</button>
            <button type="button" class="rec__btn rec__btn--stop" disabled>⏹️ Detener</button>
            <button type="button" class="rec__btn rec__btn--save" disabled>➕ Guardar</button>
        </div>

        <div class="rec__preview"></div>

        <div class="rec__actions">
            <button type="button" class="rec__btn rec__btn--upload" style="display:none;">⬆️ Subir</button>
            <button type="button" class="rec__btn rec__btn--delete" style="display:none;">❌ Eliminar</button>
        </div>
    `;

        $root.html(template);

        const $btnRec = $root.find('.rec__btn--rec');
        const $btnStop = $root.find('.rec__btn--stop');
        const $btnSave = $root.find('.rec__btn--save');
        const $btnUpload = $root.find('.rec__btn--upload');
        const $btnDelete = $root.find('.rec__btn--delete');
        const $preview = $root.find('.rec__preview');

        // -------------------------
        // RENDER
        // -------------------------
        function render() {
            $preview.empty();

            if (existing) {
                const url = config.baseUrl
                    ? config.baseUrl + "/" + existing.url
                    : existing.url;

                $preview.html(`<audio controls src="${url}"></audio>`);

                $btnDelete.show();
                $btnUpload.hide();
            }

            if (newFile) {
                const url = URL.createObjectURL(newFile);

                $preview.html(`<audio controls src="${url}"></audio>`);

                $btnUpload.show();
                $btnDelete.hide();
            }
        }

        // -------------------------
        // GRABAR
        // -------------------------
        $btnRec.on('click', async () => {
            try {
                mediaStream = await navigator.mediaDevices.getUserMedia({ audio: true });

                let options = {};
                if (MediaRecorder.isTypeSupported('audio/webm')) {
                    options.mimeType = 'audio/webm';
                }

                mediaRecorder = new MediaRecorder(mediaStream, options);
                audioChunks = [];

                mediaRecorder.start();

                mediaRecorder.ondataavailable = e => audioChunks.push(e.data);

                mediaRecorder.onstop = () => {
                    audioBlob = new Blob(audioChunks, {
                        type: mediaRecorder.mimeType || 'audio/webm'
                    });

                    $btnSave.prop('disabled', false);
                };

                $btnRec.prop('disabled', true);
                $btnStop.prop('disabled', false);

            } catch (e) {
                alert("No se pudo acceder al micrófono");
                console.error(e);
            }
        });

        // -------------------------
        // DETENER
        // -------------------------
        $btnStop.on('click', () => {
            if (mediaRecorder) mediaRecorder.stop();

            if (mediaStream) {
                mediaStream.getTracks().forEach(t => t.stop());
                mediaStream = null;
            }

            $btnRec.prop('disabled', false);
            $btnStop.prop('disabled', true);
        });

        // -------------------------
        // GUARDAR (crear file)
        // -------------------------
        $btnSave.on('click', () => {
            if (!audioBlob) return;

            const mime = audioBlob.type || 'audio/webm';
            const ext = mime.includes('mp4') ? 'mp4' : 'webm';

            newFile = new File(
                [audioBlob],
                `audio_${Date.now()}.${ext}`,
                { type: mime }
            );

            existing = null; // reemplaza

            audioBlob = null;

            $btnSave.prop('disabled', true);

            render();
        });

        // -------------------------
        // SUBIR
        // -------------------------
        $btnUpload.on('click', () => {
            if (!newFile) return;

            const fd = new FormData();
            fd.append('files[]', newFile);

            if (config.extraData) {
                const extra = typeof config.extraData === 'function'
                    ? config.extraData()
                    : config.extraData;

                Object.keys(extra || {}).forEach(k => {
                    fd.append(`data[${k}]`, extra[k]);
                });
            }

            $.ajax({
                url: config.uploadUrl,
                method: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                headers: config.headers,
                success(res) {
                    const file = res?.data?.uploaded?.[0] || res?.uploaded?.[0];

                    existing = file;
                    newFile = null;

                    render();

                    if (config.onUploaded) config.onUploaded(file, res);
                },
                error(xhr) {
                    console.error(xhr.responseText);
                    alert("Error subiendo audio");
                }
            });
        });

        // -------------------------
        // ELIMINAR
        // -------------------------
        $btnDelete.on('click', () => {
            if (!existing) return;

            if (!confirm("¿Eliminar audio?")) return;

            $.ajax({
                url: config.deleteUrl,
                method: 'POST',
                data: { id: existing.id },
                headers: config.headers,
                success(res) {
                    const removed = existing;
                    existing = null;

                    render();

                    if (config.onDeleted) config.onDeleted(removed, res);
                }
            });
        });

        // -------------------------
        // STATE (🔥 CLAVE)
        // -------------------------
        $root.data('rec-state', {
            setExisting(file) {
                existing = file;
                newFile = null;
                render();
            }
        });

        // init
        render();
    }
    Vue.directive('uploadManager', {
        inserted(el, binding, vnode) {
            initUploadManager(el, binding, vnode);
        },
        componentUpdated(el, binding) {
            const $root = $(el);
            const state = $root.data('upm-state');
            if (!state) return;

            // actualiza config reactivo (si cambia uploadUrl/existingFiles)
            const newConfig = buildConfig(binding.value || {});
            state.setConfig(newConfig); // ✅ actualiza config real (closure)

            // si existingFiles cambió, refresca
            if (Array.isArray(state.config.existingFiles)) {
                state.existing = [...state.config.existingFiles];
                state.render();
            }
        },
        unbind(el) {
            const $root = $(el);
            const state = $root.data('upm-state');
            if (!state) return;

            // limpiar eventos con namespace
            state.$input && state.$input.off('.upm');
            state.$btnUpload && state.$btnUpload.off('.upm');
            state.$btnClear && state.$btnClear.off('.upm');
            $root.off('.upm');

            $root.removeData('upm-state');
            $root.removeData('upm-initialized');
        }
    });

    function buildConfig(params) {
        return {
            nameKey: params.nameKey || 'files_ids',
            label: params.label || 'Archivos',
            uploadUrl: params.uploadUrl || '',
            deleteUrl: params.deleteUrl || '',
            downloadBaseUrl: params.downloadBaseUrl || '',
            baseUrl: params.baseUrl || '',
            headers: params.headers || {},
            multiple: params.multiple !== false,
            accept: params.accept || '',
            maxFiles: params.maxFiles || 20,
            maxMb: params.maxMb || 50,
            existingFiles: Array.isArray(params.existingFiles) ? params.existingFiles : [],
            onDeleted: typeof params.onDeleted === 'function' ? params.onDeleted : null,
            onUploaded: typeof params.onUploaded === 'function' ? params.onUploaded : null,
            onChanged: typeof params.onChanged === 'function' ? params.onChanged : null,
            _setValueForm: typeof params._setValueForm === 'function' ? params._setValueForm : null,
            fieldName: params.fieldName || 'files[]',
            rowId: params.rowId ?? null,
            // ✅ NUEVO: data externa opcional
            extraDataKey: params.extraDataKey || 'data', // manda data[word_id], etc.
            extraData: params.extraData ?? null,         // objeto o function(ctx)->obj
        };
    }

    function resolveExtraData(config, ctx) {
        try {
            if (typeof config.extraData === 'function') {
                const out = config.extraData({ctx, config});
                return (out && typeof out === 'object') ? out : {};
            }
            return (config.extraData && typeof config.extraData === 'object') ? config.extraData : {};
        } catch (e) {
            console.warn('[uploadManager] extraData error', e);
            return {};
        }
    }

    function appendObjectToFormData(fd, key, obj) {
        if (!obj || typeof obj !== 'object') return;
        Object.keys(obj).forEach(k => {
            const val = obj[k];
            if (val === undefined || val === null) return;
            fd.append(`${key}[${k}]`, String(val));
        });
    }
//upload data
    function initUploadManager(el, binding, vnode) {
        const ctx = vnode.context;

        ctx.$nextTick(function () {
            function applyConfig() {
                $hidden.attr('name', config.nameKey);
                if (config.accept) $input.attr('accept', config.accept);
                else $input.removeAttr('accept');
            }

            const $root = $(el);
            if ($root.data('upm-initialized')) return;
            $root.data('upm-initialized', true);

            // limpia contenido por si algo había
            $root.empty();

            // config
            let config = buildConfig(binding.value || {});

            // ✅ CREA EL TEMPLATE INTERNAMENTE (sin repetir HTML)
            const template = `
      <div class="upm__header">
        <div class="upm__title">${escapeHtml(config.label)}</div>
      </div>

      <input type="file" class="upm__input" ${config.multiple ? 'multiple' : ''} />

      <div class="upm__actions">
        <button type="button" class="upm__btn upm__btn--upload">Subir</button>
        <button type="button" class="upm__btn upm__btn--clear">Limpiar nuevos</button>
      </div>

      <div class="upm__list"></div>

      <input type="hidden" class="upm__hidden" />
    `;
            $root.append(template);

            // state
            let existing = [...config.existingFiles];
            let toDeleteIds = [];
            let newFiles = [];

            // nodes (scoped al root => múltiples instancias OK)
            const $input = $root.find('.upm__input');
            const $list = $root.find('.upm__list');
            const $hidden = $root.find('.upm__hidden');
            const $btnUpload = $root.find('.upm__btn--upload');
            const $btnClear = $root.find('.upm__btn--clear');

            // hidden name dinámico (único)
            $hidden.attr('name', config.nameKey);

            // accept
            if (config.accept) $input.attr('accept', config.accept);

            function syncHidden() {
                const ids = existing.map(x => x.id).filter(Boolean);
                $hidden.val(ids.join(','));

                if (config._setValueForm) config._setValueForm(config.nameKey, ids);

                if (config.onChanged) config.onChanged({ids, existing, newFiles, toDeleteIds});
            }

            function getKind({mime, name}) {
                const m = (mime || '').toLowerCase();
                const ext = (name || '').split('.').pop().toLowerCase();
                if (m.startsWith('image/') || ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].includes(ext)) return 'image';
                if (m.startsWith('audio/') || ['mp3', 'wav', 'ogg', 'm4a'].includes(ext)) return 'audio';
                if (m.startsWith('video/') || ['mp4', 'webm', 'mov', 'mkv'].includes(ext)) return 'video';
                return 'doc';
            }

            function toMb(bytes) {
                if (!bytes) return '';
                return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
            }

            function buildPreview(kind, url, name) {
                if (kind === 'image') return `<img class="upm__thumb" src="${url}" alt="${escapeHtml(name)}" />`;
                if (kind === 'audio') return `<audio class="upm__media" controls src="${url}"></audio>`;
                if (kind === 'video') return `<video class="upm__media upm__media--video" style="width:220px;height:80px;min-height: 0px !important;" controls src="${url}"></video>`;
                return `<div class="upm__doc">📄</div>`;
            }

            function buildDownloadUrl(file) {
                console.log("buildDownloadUrl", file);
                var url = "";
                if (file.id != null) {
                    if (config.baseUrl) {
                        url = config.baseUrl + "/" + file.url;
                    } else {
                        url =file.url;

                    }
                } else {
                    if (file.url) {
                        return file.url;
                    } else {
                        url = "-1";
                    }
                }


                return url;
            }

            function validateNew(files) {
                const total = existing.length + newFiles.length + files.length;
                if (total > config.maxFiles) {
                    alert(`Máximo ${config.maxFiles} archivos. Estás intentando ${total}.`);
                    return false;
                }
                const maxBytes = config.maxMb * 1024 * 1024;
                for (const f of files) {
                    if (f.size > maxBytes) {
                        alert(`Archivo muy grande: ${f.name}. Máximo ${config.maxMb} MB`);
                        return false;
                    }
                }
                return true;
            }

            function render() {
                $list.empty();

                // existing
                existing.forEach(file => {
                    const kind = getKind({mime: file.mime, name: file.name});
                    const url = buildDownloadUrl(file);
                    const size = file.size ? toMb(file.size) : '';
                    const preview = url ? buildPreview(kind, url, file.name) : `<div class="upm__doc">📄</div>`;

                    $list.append(`
          <div class="upm__item" data-existing-id="${file.id}">
            <div class="upm__preview">${preview}</div>
            <div class="upm__meta">
              <div class="upm__name">${escapeHtml(file.name)}</div>
              <div class="upm__info">${kind}${size ? ' • ' + size : ''}</div>
              <div class="upm__links">
                ${url ? `<a class="upm__link" href="${url}" target="_blank" rel="noopener">Abrir / Descargar</a>` : ''}
              </div>
            </div>
            <button type="button" class="upm__remove upm__remove--existing">Quitar</button>
          </div>
        `);
                });

                // new
                newFiles.forEach((f, idx) => {
                    const kind = getKind({mime: f.type, name: f.name});
                    const url = URL.createObjectURL(f);
                    const preview = buildPreview(kind, url, f.name);

                    $list.append(`
          <div class="upm__item" data-new-index="${idx}">
            <div class="upm__preview">${preview}</div>
            <div class="upm__meta">
              <div class="upm__name">${escapeHtml(f.name)}</div>
              <div class="upm__info">${kind} • ${toMb(f.size)}</div>
            </div>
            <button type="button" class="upm__remove upm__remove--new">Quitar</button>
          </div>
        `);
                });

                syncHidden();
// ✅ mostrar botones SOLO si hay archivos NUEVOS (pendientes de subir)
                $btnUpload.toggle(newFiles.length > 0);
                $btnClear.toggle(newFiles.length > 0);

// ✅ input SIEMPRE visible
                $input.show();
            }

            function ajaxUpload() {
                if (!config.uploadUrl) {
                    console.warn('[uploadManager] uploadUrl vacío', config);
                    alert('No hay URL de upload configurada.');
                    return;
                }
                if (!newFiles.length) {
                    alert('No hay archivos nuevos para subir.');
                    return;
                }

                const fd = new FormData();
                newFiles.forEach(f => fd.append('files[]', f, f.name)); // 👈 fuerza nombre

                // ✅ tu row_id si aplica
                if (config.rowId != null) fd.append('row_id', config.rowId);

                // ✅ data externa
                const extra = resolveExtraData(config, ctx);
                appendObjectToFormData(fd, config.extraDataKey, extra);

                $.ajax({
                    url: config.uploadUrl,
                    method: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    headers: config.headers,
                    success(res) {
                        const uploaded = res?.data?.uploaded || res?.uploaded || [];
                        uploaded.forEach(f => existing.push(f));
                        newFiles = [];
                        render();

                        if (config.onUploaded) config.onUploaded(uploaded, res);
                    },
                    error(xhr) {
                        console.error('[uploadManager] upload error', xhr.responseText || xhr);
                        alert('Error al subir archivos (revisa consola).');
                    }
                });
            }

            function ajaxDeleteExisting(fileId) {
                if (!config.deleteUrl) {
                    alert('No hay URL de delete configurada.');
                    return;
                }

                const url = config.deleteUrl.includes('-1')
                    ? config.deleteUrl.replace('-1', fileId)
                    : config.deleteUrl;

                // payload base
                const payload = config.deleteUrl.includes('-1') ? {} : {id: fileId};

                // ✅ NUEVO: adjunta data externa también en delete (si backend lo requiere)
                const extra = resolveExtraData(config, ctx);
                if (extra && typeof extra === 'object') {
                    payload[config.extraDataKey] = extra; // manda data: {word_id:..}
                }

                $.ajax({
                    url,
                    method: 'POST',
                    data: payload,
                    headers: config.headers,
                    success(res) {
                        const removed = existing.find(x => x.id === fileId);
                        existing = existing.filter(x => x.id !== fileId);
                        toDeleteIds.push(fileId);
                        render();

                        if (config.onDeleted) config.onDeleted(removed || {id: fileId}, res);
                    },
                    error(xhr) {
                        console.error('[uploadManager] delete error', xhr.responseText || xhr);
                        alert('Error al eliminar archivo.');
                    }
                });
            }

            // events (namespace upm)
            $input.on('change.upm', function () {
                const files = Array.from(this.files || []);
                if (!files.length) return;

                if (!validateNew(files)) {
                    this.value = '';
                    return;
                }

                files.forEach(f => {
                    const exists = newFiles.some(x => x.name === f.name && x.size === f.size);
                    if (!exists) newFiles.push(f);
                });

                this.value = '';
                render();
            });

            $btnClear.on('click.upm', function () {
                newFiles = [];
                render();
            });

            $btnUpload.on('click.upm', function () {
                ajaxUpload();
            });

            $root.on('click.upm', '.upm__remove--new', function () {
                const idx = Number($(this).closest('.upm__item').data('new-index'));
                if (Number.isFinite(idx)) {
                    newFiles.splice(idx, 1);
                    render();
                }
            });

            $root.on('click.upm', '.upm__remove--existing', function () {
                const id = $(this).closest('.upm__item').data('existing-id');
                if (!id) return;
                if (!confirm('¿Eliminar este archivo?')) return;
                ajaxDeleteExisting(id);
            });

            render();

            // state persistente para updates
            $root.data('upm-state', {
                get config() {
                    return config;
                },
                setConfig: (newCfg) => {
                    config = newCfg;      // ✅ actualiza closure
                    applyConfig();        // ✅ actualiza hidden name/accept
                },
                config,
                existing,
                newFiles,
                toDeleteIds,
                $input,
                $list,
                $hidden,
                $btnUpload,
                $btnClear,
                render
            });
        });
    }

    function escapeHtml(str) {
        return String(str || '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", "&#039;");
    }


    Vue.directive('initS2Manager', {
        inserted: function (el, binding, vnode) {
            var paramsInput = binding.value || {};
            var ctx = vnode.context;

            // espera a que el DOM esté estable
            ctx.$nextTick(function () {
                // evita doble init si el nodo se reusa
                var $el = $(el);
                if ($el.hasClass("select2-hidden-accessible")) {
                    $el.select2("destroy");
                }

                if (typeof paramsInput._initS2Manager === "function") {
                    paramsInput._initS2Manager({
                        objSelector: el,
                        rowId: paramsInput.rowId
                    });
                } else {
                    console.warn("initS2Manager: _initS2Manager no es función", paramsInput);
                }
            });
        },
        unbind: function (el) {
            var $el = $(el);
            if ($el.hasClass("select2-hidden-accessible")) {
                $el.select2("destroy");
            }
        }
    });


    Vue.directive('form-text', {
        inserted: function (el, binding, vnode) {

            var params = null;
            var valueAdd = "";

            function getValue() {
                var addTitle = "";
                var key = "";

                if (binding.value.hasOwnProperty('key') && binding.value.hasOwnProperty('addTitle')) {
                    key = binding.value.key;
                    addTitle = binding.value.addTitle;

                } else {
                    key = binding.value;

                }

                return {addTitle: addTitle, key: key}
            }

            function apply() {


                var params = null;
                var valueAdd = "";
                var resultManager = getValue();
                params = resultManager.key;
                var vm = vnode.context;
                var dict =
                    (vm && $dataManagerPage && $dataManagerPage.formLanguageManagement) || {};


                if (typeof params === "string") params = {key: params};
                params = params || {};

                var preferredPrefixes = params.prefer || [
                    "form.actions.",
                    "form.messages.",
                    "form.titles.",
                    "validations."
                ];

                function getByPath(obj, path) {
                    return String(path || "").split(".").reduce(function (acc, k) {
                        return (acc && typeof acc === "object" && k in acc) ? acc[k] : undefined;
                    }, obj);
                }

                function deepFindByFinalKey(obj, keyFinal) {
                    var matches = [];

                    function walk(node, pathArr) {
                        if (!node || typeof node !== "object") return;

                        Object.keys(node).forEach(function (k) {
                            var v = node[k];
                            var newPath = pathArr.concat(k);

                            if (v && typeof v === "object") return walk(v, newPath);
                            if (typeof v !== "string") return;

                            var full = newPath.join(".");
                            var last = k.indexOf(".") >= 0 ? k.split(".").pop() : k;

                            if (last === keyFinal || full.endsWith("." + keyFinal)) {
                                matches.push({path: full, value: v});
                            }
                        });
                    }

                    walk(obj, []);
                    if (!matches.length) return undefined;
                    if (matches.length === 1) return matches[0].value;

                    for (var i = 0; i < preferredPrefixes.length; i++) {
                        var pref = preferredPrefixes[i];
                        var pick = matches.find(function (m) {
                            return m.path.indexOf(pref) === 0;
                        });
                        if (pick) return pick.value;
                    }

                    return matches[0].value;
                }

                function resolveText(key) {
                    var k = String(key || "").trim();
                    if (!k) return "";

                    if (k.indexOf(".") >= 0) {
                        var exact = getByPath(dict, k);
                        if (typeof exact === "string") return exact;

                        if (k.indexOf("form.") !== 0) {
                            var formTry = getByPath(dict, "form." + k);
                            if (typeof formTry === "string") return formTry;
                        }
                    }

                    var byFinal = deepFindByFinalKey(dict, k);
                    if (typeof byFinal === "string") return byFinal;

                    return k;
                }

                function setValue(text, valueAdd) {
                    var setText = valueAdd == "" ? text : text + " " + valueAdd;
                    var target = params.target || "text"; // text|placeholder|value|attr|html|auto
                    var attr = params.attr;

                    if (target === "auto") {
                        var tag = (el.tagName || "").toLowerCase();
                        target = (tag === "input" || tag === "textarea") ? "value" : "text";
                    }

                    if (target === "placeholder") el.setAttribute("placeholder", setText);
                    else if (target === "value") el.value = setText;
                    else if (target === "html") el.innerHTML = setText;
                    else if (target === "attr") {
                        if (attr) el.setAttribute(String(attr), setText);
                    } else el.textContent = setText;
                }

                var resultManager = getValue();


                setValue(resolveText(resultManager.key), resultManager.addTitle);
            }

            // ✅ Guardas el handler en el elemento para usarlo en update()
            el.__formTextApply__ = apply;
            apply();
        },

        update: function (el, binding, vnode) {
            // ✅ aquí YA NO uses this.inserted(...)
            if (el.__formTextApply__) {
                el.__formTextApply__();
            }
        },

        unbind: function (el) {
            delete el.__formTextApply__;
        }
    });


</script>
