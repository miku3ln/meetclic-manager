<script id="manager-directives-vue">
    // src/directives/formText.js

    Vue.directive('initS2Manager',{
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
            function apply() {
                var vm = vnode.context;

                var dict =
                    (vm && $dataManagerPage && $dataManagerPage.formLanguageManagement) || {};

                var params = binding.value;
                if (typeof params === "string") params = { key: params };
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
                                matches.push({ path: full, value: v });
                            }
                        });
                    }

                    walk(obj, []);
                    if (!matches.length) return undefined;
                    if (matches.length === 1) return matches[0].value;

                    for (var i = 0; i < preferredPrefixes.length; i++) {
                        var pref = preferredPrefixes[i];
                        var pick = matches.find(function (m) { return m.path.indexOf(pref) === 0; });
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

                function setValue(text) {
                    var target = params.target || "text"; // text|placeholder|value|attr|html|auto
                    var attr = params.attr;

                    if (target === "auto") {
                        var tag = (el.tagName || "").toLowerCase();
                        target = (tag === "input" || tag === "textarea") ? "value" : "text";
                    }

                    if (target === "placeholder") el.setAttribute("placeholder", text);
                    else if (target === "value") el.value = text;
                    else if (target === "html") el.innerHTML = text;
                    else if (target === "attr") { if (attr) el.setAttribute(String(attr), text); }
                    else el.textContent = text;
                }

                var key = params.key || binding.value;
                setValue(resolveText(key));
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
