<?php
$urlRouteBusiness= route('businessDetails', app()->getLocale());
$urlRouteUser= route('authorSingle', app()->getLocale());

?>
@include('partials.bootstrap-05',["allowJs"=>true])
<script>
    (function (global, $) {
        'use strict';

        // =========================================================
        // Helpers
        // =========================================================

        function toNumber(value, fallback = null) {
            const n = Number(value);
            return Number.isFinite(n) ? n : fallback;
        }

        function buildResult({
                                 success = false,
                                 lat = null,
                                 lng = null,
                                 type = 'unknown',
                                 message = '',
                                 accuracy = null,
                                 timestamp = null,
                                 rawError = null
                             } = {}) {
            return {
                success: !!success,
                lat: toNumber(lat),
                lng: toNumber(lng),
                type: type || 'unknown', // gps | default | fallback | denied | timeout | unsupported | error
                message: message || '',
                accuracy: accuracy != null ? toNumber(accuracy) : null,
                timestamp: timestamp || new Date().toISOString(),
                rawError: rawError || null
            };
        }

        function mapGeoError(error) {
            // https://developer.mozilla.org/en-US/docs/Web/API/GeolocationPositionError
            if (!error) {
                return { type: 'error', message: 'Error desconocido al obtener ubicación.' };
            }

            switch (error.code) {
                case 1: // PERMISSION_DENIED
                    return { type: 'denied', message: 'Permiso denegado para acceder a la ubicación.' };
                case 2: // POSITION_UNAVAILABLE
                    return { type: 'error', message: 'Ubicación no disponible (señal GPS o red).' };
                case 3: // TIMEOUT
                    return { type: 'timeout', message: 'Tiempo de espera agotado al obtener ubicación.' };
                default:
                    return { type: 'error', message: 'Error inesperado al obtener ubicación.' };
            }
        }

        function hasGeolocationSupport() {
            return !!(navigator && navigator.geolocation);
        }

        // =========================================================
        // 1) Obtener una sola vez (async/await)
        // =========================================================
        async function getBrowserCoordinatesAsync(options = {}) {
            const cfg = $.extend(
                true,
                {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 0,

                    // fallback (si deseas devolver algo aun cuando falle)
                    fallbackLat: null,
                    fallbackLng: null
                },
                options
            );

            if (!hasGeolocationSupport()) {
                // si tienes fallback, lo usamos
                if (cfg.fallbackLat != null && cfg.fallbackLng != null) {
                    return buildResult({
                        success: true,
                        lat: cfg.fallbackLat,
                        lng: cfg.fallbackLng,
                        type: 'fallback',
                        message: 'Geolocalización no soportada. Se usó ubicación por defecto.'
                    });
                }

                return buildResult({
                    success: false,
                    type: 'unsupported',
                    message: 'Tu navegador no soporta geolocalización.'
                });
            }

            // Promise wrapper para geolocation.getCurrentPosition
            const position = await new Promise((resolve) => {
                navigator.geolocation.getCurrentPosition(
                    (pos) => resolve({ ok: true, pos }),
                    (err) => resolve({ ok: false, err }),
                    {
                        enableHighAccuracy: !!cfg.enableHighAccuracy,
                        timeout: cfg.timeout,
                        maximumAge: cfg.maximumAge
                    }
                );
            });

            if (position.ok) {
                const coords = position.pos.coords || {};
                // type: si accuracy es buena, lo consideramos gps, si no, default
                const accuracy = coords.accuracy ?? null;
                const type = accuracy != null && accuracy <= 100 ? 'gps' : 'default';

                return buildResult({
                    success: true,
                    lat: coords.latitude,
                    lng: coords.longitude,
                    accuracy: accuracy,
                    type: type,
                    message: 'Ubicación obtenida correctamente.'
                });
            }

            // error
            const mapped = mapGeoError(position.err);

            // si tienes fallback, úsalo
            if (cfg.fallbackLat != null && cfg.fallbackLng != null) {
                return buildResult({
                    success: true,
                    lat: cfg.fallbackLat,
                    lng: cfg.fallbackLng,
                    type: 'fallback',
                    message: mapped.message + ' Se usó ubicación por defecto.',
                    rawError: position.err
                });
            }

            return buildResult({
                success: false,
                type: mapped.type,
                message: mapped.message,
                rawError: position.err
            });
        }

        // =========================================================
        // 2) Escuchar cambios (watchPosition)
        // =========================================================

        let _watchId = null;

        function startLocationWatcher(params = {}) {
            const cfg = $.extend(
                true,
                {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 0,

                    // callbacks
                    onChange: function (_result) {},
                    onError: function (_result) {},

                    // fallback opcional si quieres reportar algo aun si falla
                    fallbackLat: null,
                    fallbackLng: null
                },
                params
            );

            if (!hasGeolocationSupport()) {
                const res = (cfg.fallbackLat != null && cfg.fallbackLng != null)
                    ? buildResult({
                        success: true,
                        lat: cfg.fallbackLat,
                        lng: cfg.fallbackLng,
                        type: 'fallback',
                        message: 'Geolocalización no soportada. Se usó ubicación por defecto.'
                    })
                    : buildResult({
                        success: false,
                        type: 'unsupported',
                        message: 'Tu navegador no soporta geolocalización.'
                    });

                // reportar como error (o change si es fallback)
                if (res.success) cfg.onChange(res);
                else cfg.onError(res);

                return { started: false, watchId: null, message: res.message };
            }

            // si ya existe watcher, lo reiniciamos
            if (_watchId != null) {
                navigator.geolocation.clearWatch(_watchId);
                _watchId = null;
            }

            _watchId = navigator.geolocation.watchPosition(
                function (pos) {
                    const coords = pos.coords || {};
                    const accuracy = coords.accuracy ?? null;
                    const type = accuracy != null && accuracy <= 100 ? 'gps' : 'default';

                    const res = buildResult({
                        success: true,
                        lat: coords.latitude,
                        lng: coords.longitude,
                        accuracy: accuracy,
                        type: type,
                        message: 'Cambio de ubicación detectado.'
                    });

                    cfg.onChange(res);
                },
                function (err) {
                    const mapped = mapGeoError(err);

                    // fallback si quieres
                    if (cfg.fallbackLat != null && cfg.fallbackLng != null) {
                        const res = buildResult({
                            success: true,
                            lat: cfg.fallbackLat,
                            lng: cfg.fallbackLng,
                            type: 'fallback',
                            message: mapped.message + ' Se usó ubicación por defecto.',
                            rawError: err
                        });
                        cfg.onChange(res);
                        return;
                    }

                    const res = buildResult({
                        success: false,
                        type: mapped.type,
                        message: mapped.message,
                        rawError: err
                    });

                    cfg.onError(res);
                },
                {
                    enableHighAccuracy: !!cfg.enableHighAccuracy,
                    timeout: cfg.timeout,
                    maximumAge: cfg.maximumAge
                }
            );

            return { started: true, watchId: _watchId, message: 'Watcher iniciado.' };
        }

        function stopLocationWatcher() {
            if (_watchId != null && hasGeolocationSupport()) {
                navigator.geolocation.clearWatch(_watchId);
                _watchId = null;
                return { stopped: true, message: 'Watcher detenido.' };
            }
            return { stopped: false, message: 'No había watcher activo.' };
        }

        // =========================================================
        // Export global
        // =========================================================
        global.GeoManager = {
            getBrowserCoordinatesAsync,
            startLocationWatcher,
            stopLocationWatcher
        };

    })(window, window.jQuery);

</script>

<script>
    function buildLimitationsBadgesUI(params) {
        params = params || {};
        var type = (params.frequency_limit_type || 'NONE').toUpperCase();
        var val = params.frequency_limit_value;
        var validFrom = params.valid_from || null;
        var validUntil = params.valid_until || null;
        function escHtml(str) {
            return String(str)
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
        function toDateOnly(d) {
            if (!d) return null;
            // acepta "YYYY-MM-DD" o "YYYY-MM-DD HH:mm:ss"
            var s = String(d).trim();
            return s.split(' ')[0];
        }
        function isEmptyDate(d) {
            return d === null || d === undefined || String(d).trim() === '';
        }
        function normalizeValue(v) {
            // si no viene valor, por UX asumimos 1 cuando corresponde
            if (v === null || v === undefined || v === '') return 1;
            var n = parseInt(v, 10);
            return isNaN(n) || n <= 0 ? 1 : n;
        }
        // 1) Vigencia
        var vigText = '';
        var vigBadge = 'badge'; // BS3
        if (isEmptyDate(validFrom) && isEmptyDate(validUntil)) {
            vigText = ' {{__('gamification.always_available')}}';
            vigBadge += ' limitations__badge limitations__badge--ok';
        } else if (!isEmptyDate(validFrom) && isEmptyDate(validUntil)) {
            vigText = ' {{__('gamification.available_from')}}' + escHtml(toDateOnly(validFrom));
            vigBadge += ' limitations__badge limitations__badge--info';
        } else if (isEmptyDate(validFrom) && !isEmptyDate(validUntil)) {
            vigText = ' {{__('gamification.available_until')}}' + escHtml(toDateOnly(validUntil));
            vigBadge += ' limitations__badge limitations__badge--warn';
        } else {
            vigText =' {{__('gamification.available_between')}}' + escHtml(toDateOnly(validFrom)) + ' al ' + escHtml(toDateOnly(validUntil));
            vigBadge += ' limitations__badge limitations__badge--info';
        }

        // 2) Repetición / Cuántas veces
        var repText = '';
        var repBadge = 'badge';
        var repIcon = 'fa-refresh';
        if (type === 'NONE') {
            repText ='   {{__('gamification.unlimited')}}';
            repBadge += ' limitations__badge limitations__badge--ok';
            repIcon = 'fa-infinity'; // si no existe en tu FA, cambia a fa-refresh
        } else if (type === 'ONCE') {
            repText = '  {{__('gamification.only_once')}}';
            repBadge += ' limitations__badge limitations__badge--danger';
            repIcon = 'fa-lock';
        } else if (type === 'DAILY') {
            var v1 = normalizeValue(val);
            repText = v1 +'  {{__('gamification.per_day')}}';
            repBadge += ' limitations__badge limitations__badge--info';
            repIcon = 'fa-sun-o';
        } else if (type === 'WEEKLY') {
            var v2 = normalizeValue(val);
            repText = v2 + '  {{__('gamification.per_week')}}';
            repBadge += ' limitations__badge limitations__badge--info';
            repIcon = 'fa-calendar';
        } else if (type === 'MONTHLY') {
            var v3 = normalizeValue(val);
            repText = v3 + '  {{__('gamification.per_month')}}';
            repBadge += ' limitations__badge limitations__badge--info';
            repIcon = 'fa-calendar-o';
        } else if (type === 'TOTAL_LIMIT') {
            var v4 = normalizeValue(val);
            repText = 'Máximo ' + v4 + '  {{__('gamification.total_limit')}}';
            repBadge += ' limitations__badge limitations__badge--warn';
            repIcon = 'fa-flag-checkered';
        } else {
            repText = '  {{__('gamification.not_defined')}}';
            repBadge += ' limitations__badge limitations__badge--danger';
            repIcon = 'fa-exclamation-triangle';
        }
        // HTML final (BS3)
        var html = ''
            + '<div class="limitations">'
            + '  <div class="limitations__row">'
            + '    <i class="fa fa-calendar limitations__icon" aria-hidden="true"></i>'
            + '    <span class="' + vigBadge + '">' + escHtml(vigText) + '</span>'
            + '  </div>'
            + '  <div class="limitations__row">'
            + '    <i class="fa ' + escHtml(repIcon) + ' limitations__icon" aria-hidden="true"></i>'
            + '    <span class="' + repBadge + '">' + escHtml(repText) + '</span>'
            + '  </div>'
            + '</div>';

        return html;
    }
    function mcParseTaskDescriptionUI(descriptionText) {
        if (!descriptionText) return '';

        // Normaliza: convierte <br> a \n, limpia \r
        var raw = String(descriptionText)
            .replace(/<br\s*\/?>/gi, '\n')
            .replace(/\r/g, '')
            .trim();

        // Helpers
        function mcFindMetaByIcon(icon, iconMap) {
            for (var i = 0; i < iconMap.length; i++) {
                if (iconMap[i].icon === icon) return iconMap[i];
            }
            return null;
        }

        // Mapa de íconos => etiqueta UI + badge
        // Incluye nuevos: 🎁 (gain), ⚙️ (validation), ⚠️ (rules/warn)
        // Nota: ⚠️ a veces llega como "⚠" sin variante emoji
        var iconMap = [
            { icon: '🟢', key: 'do',         label: '{{__('gamification.what_to_do')}}',           bs: 'label-success' },
            { icon: '🎁', key: 'gain',       label: '{{__('gamification.what_you_get')}}',         bs: 'label-primary' },
            { icon: '🟡', key: 'why',        label: '{{__('gamification.what_is_it_for')}}',      bs: 'label-warning' },
            { icon: '⚙️', key: 'validation', label: '{{__('gamification.validation')}}',          bs: 'label-info' },
            { icon: '⚠️', key: 'rules',      label: '{{__('gamification.rules')}}',               bs: 'label-danger' },
            { icon: '⚠',  key: 'rules',      label: '{{__('gamification.rules')}}',               bs: 'label-danger' },

            // Opcionales legacy (si aún existen descripciones viejas)
            { icon: '🔴', key: 'avoid',      label: '{{__('gamification.avoid')}}',               bs: 'label-danger' },
            { icon: '🔵', key: 'note',       label: '{{__('gamification.note')}}',                bs: 'label-info' },
            { icon: '🟣', key: 'tip',        label: '{{__('gamification.tip')}}',                 bs: 'label-info' }
        ];

        // Para Regex: escapar iconos
        var iconsPattern = iconMap
            .map(function (x) { return x.icon.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); })
            .join('|');

        // Captura: (inicio o salto de línea) + icono + resto hasta el siguiente icono o fin
        var re = new RegExp(
            '(^|\\n)(' + iconsPattern + ')\\s*([^\\n]*)([\\s\\S]*?)(?=(\\n(' + iconsPattern + ')\\s*)|$)',
            'g'
        );

        var items = [];
        var match;

        // Limpieza de encabezados típicos (si vienen escritos)
        // Incluye nuevos: Validación, Reglas, Importante
        function stripKnownPrefixes(text) {
            return String(text)
                .replace(/^(qué\s*hacer|para\s*qué\s*sirve|qué\s*ganas|validaci[oó]n|reglas|importante|nota|tip|evita)\s*:\s*/i, '')
                .trim();
        }

        while ((match = re.exec(raw)) !== null) {
            var icon = (match[2] || '').trim();
            var head = (match[3] || '').trim();
            var tail = (match[4] || '').trim();

            // Une cabecera + cola
            var content = (head + '\n' + tail).trim();

            // Normaliza espacios pero conserva saltos de línea para reglas con bullets
            // (1) colapsa espacios múltiples
            content = content.replace(/[ \t]+/g, ' ').trim();

            // Limpia prefijo textual si ya viene "Qué hacer:"
            content = stripKnownPrefixes(content);

            // Si reglas viene con bullets, intenta formatear bonito (separar por saltos)
            // - Acepta: "•", "-", "*"
            if (icon === '⚠️' || icon === '⚠') {
                // Si todo viene en una sola línea con puntos, intenta partir por ". "
                // Solo si NO hay bullets.
                var hasBullets = /(^|\n)\s*(•|-|\*)\s+/.test(content);
                if (!hasBullets && content.indexOf('. ') > -1) {
                    content = content.split('. ').join('.\n');
                }
            }

            var meta = mcFindMetaByIcon(icon, iconMap) || { icon: icon, label: 'Info', bs: 'label-default' };

            items.push({
                icon: meta.icon,
                label: meta.label,
                bs: meta.bs,
                text: content
            });
        }

        // Si NO encontró íconos, devuelve bloque simple
        if (!items.length) {
            return mcEscapeHtml(raw);
        }

        // Orden recomendado (tu nuevo template)
        var order = { 'do': 1, 'gain': 2, 'why': 3, 'validation': 4, 'rules': 5, 'avoid': 6, 'note': 7, 'tip': 8 };

        // Asigna key para ordenar (si hay duplicados se respeta aparición)
        for (var k = 0; k < items.length; k++) {
            var metaK = mcFindMetaByIcon(items[k].icon, iconMap);
            items[k]._order = metaK && order[metaK.key] ? order[metaK.key] : 99;
            items[k]._idx = k;
        }

        // Ordena: primero por template, luego por orden original
        items.sort(function (a, b) {
            if (a._order === b._order) return a._idx - b._idx;
            return a._order - b._order;
        });

        // Construye HTML con <br> entre items
        var html = '';
        for (var j = 0; j < items.length; j++) {
            var it = items[j];

            // Si el contenido tiene saltos (reglas), convertir a <br> interno
            var safeText = mcEscapeHtml(it.text).replace(/\n/g, '<br>');

            html += [
                '<span class="', it.bs, '" style="display:inline-block;margin-right:6px;">',
                mcEscapeHtml(it.icon),
                '</span>',
                '<strong>',
                mcEscapeHtml(it.label),
                ':</strong> ',
                safeText
            ].join('');

            if (j < items.length - 1) html += '<br>'; // separador entre bloques
        }

        return html;
    }
    function mcEscapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
    var $configManagerMap = {
        markers: [],
        managerCluster: null,
    };
    var  $urlRouteBusiness = " <?php echo $urlRouteBusiness; ?>";
    var  $urlRouteUser = " <?php echo $urlRouteUser; ?>";

</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    function isDesktopOnly() {
        const width = window.innerWidth;
        const ua = navigator.userAgent.toLowerCase();
        const isMobileOrTablet =
            /android|iphone|ipad|ipod|mobile|tablet/.test(ua);
        return width >= 1025 && !isMobileOrTablet;
    }
    async function reverseGeocodeNominatim(paramsCurrent) {
        var {lat, lng}=paramsCurrent;
        const targetUrl =
            "https://nominatim.openstreetmap.org/reverse" +
            `?format=jsonv2&lat=${encodeURIComponent(lat)}` +
            `&lon=${encodeURIComponent(lng)}` +
            `&accept-language=en`;

        const proxyUrl = "https://api.allorigins.win/raw?url=" + encodeURIComponent(targetUrl);

        try {
            const res = await fetch(proxyUrl);
            if (!res.ok) {
                return { success: false, data: null, error: { status: res.status, message: res.statusText } };
            }

            const response = await res.json();
            const address = response.address || {};

            const data = {
                country: address.country || "",
                state: address.state || address.region || "",
                city: address.city || address.town || address.village || "",
                district: address.suburb || address.neighbourhood || address.city_district || "",
                street: address.road || "",
                houseNumber: address.house_number || "",
                formattedAddress: response.display_name || ""
            };

            return { success: true, data, error: null };
        } catch (e) {
            const data = {
                country:"S/N",
                state:  "S/N",
                city:  "S/N",
                district: "S/N",
                street: "S/N",
                houseNumber: "S/N",
                formattedAddress: "S/N"
            };
            return { success: false, data: data, error: { status: 0, message: "Network/CORS error" } };
        }
    }

</script>
@include('frontend.web.'.$managementNameProcess.'.assets.js.templateVue')
@include('frontend.web.'.$managementNameProcess.'.assets.js.process.manager-map')
@include('frontend.web.'.$managementNameProcess.'.assets.js.process.filters-categories')
@include('frontend.web.'.$managementNameProcess.'.assets.js.process.app')
