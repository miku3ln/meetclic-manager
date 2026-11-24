<script>

    class MaskanaMapLocationController {

        constructor(map, options = {}) {

            this.map = map;

            // ==========================================
            // CONFIGURACIÓN CENTRALIZADA
            // ==========================================

            this.config = $.extend(
                true,
                {},
                YapitaMapConfig.userLocation,
                options
            );

            // Compatibilidad con los métodos anteriores.
            this.options = this.config;

            // ==========================================
            // BOTÓN DE UBICACIÓN
            // ==========================================

            this.button = document.getElementById(
                this.config.buttonId
            );

            // ==========================================
            // INSTANCIAS LEAFLET
            // ==========================================

            this.marker = null;
            this.accuracyCircle = null;

            // ==========================================
            // ESTADOS
            // ==========================================

            this.permission = 'unknown';
            this.loading = false;
            this.visible = false;

            // ==========================================
            // EVENTO: CAMBIO DE PERMISOS
            // ==========================================

            this._onPermissionChange = event => {

                this.setPermission(
                    event.detail.permission
                );

            };

            // ==========================================
            // EVENTO: CAMBIO DE UBICACIÓN
            // ==========================================

            this._onLocationChange = event => {

                if (this.visible) {

                    this.updateMarker(
                        event.detail.current
                    );

                }

            };

            // ==========================================
            // EVENTO: ELIMINAR UBICACIÓN
            // ==========================================

            this._onLocationCleared = () => {

                this.removeMarker();

            };

            // ==========================================
            // EVENTO: BOTÓN GPS
            // ==========================================

            this._onButtonClick = () => {

                this.locate();

            };

        }

        // ==========================================
        // INICIALIZAR
        // ==========================================

        async init() {

            if (!this.map || !this.button) {
                console.warn('Mapa o botón no disponible.');
                return;
            }

            document.addEventListener(
                'maskana:location:permission',
                this._onPermissionChange
            );

            document.addEventListener(
                'maskana:location:changed',
                this._onLocationChange
            );

            document.addEventListener(
                'maskana:location:cleared',
                this._onLocationCleared
            );

            this.button.addEventListener(
                'click',
                this._onButtonClick
            );

            const permission =
                await maskanaLocation.checkPermission();

            this.setPermission(permission);
        }

        // ==========================================
        // ESTADO DEL PERMISO
        // ==========================================

        setPermission(permission) {

            this.permission = permission;

            if (!this.button) return;

            this.button.classList.remove(
                'is-denied',
                'is-pending',
                'is-granted'
            );

            const icon = this.button.querySelector('i');

            if (permission === 'denied') {

                this.button.classList.add('is-denied');
                this.button.disabled = true;
                this.button.title = 'Ubicación bloqueada';

                if (icon) {
                    icon.className = 'bi bi-lock-fill';
                }

                this.removeMarker();

            } else if (permission === 'granted') {

                this.button.classList.add('is-granted');
                this.button.disabled = false;
                this.button.title = 'Ver mi ubicación';

                if (icon) {
                    icon.className = 'bi bi-crosshair';
                }

            } else if (permission === 'prompt' ||
                permission === 'unknown') {

                this.button.classList.add('is-pending');
                this.button.disabled = false;
                this.button.title = 'Permitir ubicación';

                if (icon) {
                    icon.className = 'bi bi-geo-alt';
                }

            } else {

                this.button.classList.add('is-denied');
                this.button.disabled = true;
                this.button.title = 'Ubicación no disponible';

                if (icon) {
                    icon.className = 'bi bi-lock-fill';
                }
            }
        }

        // ==========================================
        // LOCALIZAR USUARIO
        // ==========================================

        async locate() {

            if (this.loading ||
                this.permission === 'denied') {
                return;
            }

            this.loading = true;

            this.button.disabled = true;
            this.button.classList.add('is-loading');

            try {

                // Solicita posición actual.
                // Si el permiso está pendiente,
                // el navegador puede pedir autorización.
                const location =
                    await maskanaLocation.request();

                this.visible = true;

                this.updateMarker(location);

                this.map.setView(
                    [
                        location.latitude,
                        location.longitude
                    ],
                    this.options.zoom,
                    {
                        animate: true
                    }
                );

            } catch (error) {

                console.warn(
                    'No se pudo obtener ubicación:',
                    error
                );

                await maskanaLocation.checkPermission();

            } finally {

                this.loading = false;

                this.button.classList.remove('is-loading');

                this.setPermission(
                    maskanaLocation.permission
                );
            }
        }

        // ==========================================
        // CREAR / ACTUALIZAR MARCADOR
        // ==========================================

        buildMarkerIcon() {

            const marker = this.config.marker;

            const appearance = marker.appearance || {};
            const bounce = marker.bounce || {};
            const pulse = marker.pulse || {};
            const label = marker.label || {};

            const size = marker.size ?? 64;

            // ==========================================
            // TIPO DE ICONO
            // ==========================================

            const iconType = marker.iconType ??
                (marker.isIcon ? 'bootstrap' : 'emoji');

            const fallback = escapeHtml(
                marker.fallbackIcon || marker.icon || '📍'
            );

            let iconHtml = '';

            switch (iconType) {

                case 'image':

                    iconHtml = marker.image
                        ? `
                    <img
                        class="maskana-user-pumpkin__image"
                        src="${escapeHtml(marker.image)}"
                        alt=""
                        draggable="false"
                        onerror="
                            this.hidden = true;
                            this.nextElementSibling.hidden = false;
                        "
                    >

                    <span
                        class="maskana-user-pumpkin__fallback"
                        hidden
                    >
                        ${fallback}
                    </span>
                `
                        : fallback;

                    break;

                case 'bootstrap':

                    iconHtml = `
                <i
                    class="bi ${escapeHtml(marker.icon)}"
                    aria-hidden="true"
                ></i>
            `;

                    break;

                case 'emoji':

                default:

                    iconHtml = escapeHtml(
                        marker.icon || '📍'
                    );

                    break;

            }

            // ==========================================
            // CLASES DINÁMICAS
            // ==========================================

            const classes = [
                'maskana-user-pumpkin'
            ];

            if (bounce.enabled) {
                classes.push('maskana-user-pumpkin--bounce');
            }

            if (pulse.enabled) {
                classes.push('maskana-user-pumpkin--pulse');
            }

            // ==========================================
            // VARIABLES CSS DINÁMICAS
            // ==========================================

            const styles = {

                // DIMENSIONES

                '--user-marker-size':
                    `${size}px`,

                '--user-marker-icon-size':
                    `${marker.iconSize ?? 32}px`,

                '--user-marker-color':
                    marker.color ?? '#4354eb',

                // APARIENCIA

                '--user-marker-background':
                    appearance.background ?? 'transparent',

                '--user-marker-border-color':
                    appearance.borderColor ?? 'transparent',

                '--user-marker-border-width':
                    `${appearance.borderWidth ?? 0}px`,

                '--user-marker-border-radius':
                    appearance.borderRadius ?? '50%',

                '--user-marker-shadow':
                    appearance.shadow ?? 'none',

                '--user-marker-object-fit':
                    appearance.objectFit ?? 'contain',

                // REBOTE

                '--user-marker-bounce-duration':
                    `${bounce.duration ?? 1200}ms`,

                '--user-marker-bounce-height':
                    `${bounce.height ?? 8}px`,

                '--user-marker-bounce-timing':
                    bounce.timingFunction ?? 'ease-in-out',

                // PULSO

                '--user-marker-pulse-color':
                    pulse.color ?? marker.color ?? '#4354eb',

                '--user-marker-pulse-duration':
                    `${pulse.duration ?? 1800}ms`,

                '--user-marker-pulse-scale':
                    pulse.scale ?? 1.8,

                '--user-marker-pulse-border-width':
                    `${pulse.borderWidth ?? 2}px`,

                '--user-marker-pulse-opacity':
                    pulse.opacity ?? 0.65,

                '--user-marker-pulse-timing':
                    pulse.timingFunction ?? 'ease-out',

                // ETIQUETA

                '--user-marker-label-background':
                    label.background ?? '#ffffff',

                '--user-marker-label-color':
                    label.color ?? '#172033',

                '--user-marker-label-font-size':
                    `${label.fontSize ?? 11}px`,

                '--user-marker-label-font-weight':
                    label.fontWeight ?? 600,

                '--user-marker-label-padding':
                    label.padding ?? '4px 10px',

                '--user-marker-label-border-radius':
                    label.borderRadius ?? '20px',

                '--user-marker-label-shadow':
                    label.shadow ?? 'none'

            };

            const styleHtml = Object.entries(styles)
                .map(([key, value]) => `${key}:${value}`)
                .join(';');

            // ==========================================
            // ONDAS DE PULSO
            // ==========================================

            let pulseHtml = '';

            if (pulse.enabled) {

                const waves = Math.max(
                    0,
                    Math.min(
                        10,
                        Math.floor(Number(pulse.waves ?? 2) || 0)
                    )
                );

                const delay = Math.max(
                    0,
                    Number(pulse.delay ?? 900) || 0
                );

                for (let index = 0; index < waves; index++) {

                    pulseHtml += `
                <span
                    class="maskana-user-pumpkin__pulse"
                    style="
                        --user-marker-pulse-wave-delay:
                        ${index * delay}ms;
                    "
                    aria-hidden="true"
                ></span>
            `;

                }

            }

            // ==========================================
            // ETIQUETA DE UBICACIÓN
            // ==========================================

            const labelHtml = label.enabled
                ? `
            <span class="maskana-user-pumpkin__label">
                ${escapeHtml(label.text ?? '')}
            </span>
        `
                : '';

            // ==========================================
            // GENERAR MARCADOR LEAFLET
            // ==========================================

            return L.divIcon({

                className: 'maskana-user-location-marker',

                html: `
            <div
                class="${classes.join(' ')}"
                style="${escapeHtml(styleHtml)}"
            >

                ${pulseHtml}

                <span class="maskana-user-pumpkin__emoji">

                    ${iconHtml}

                </span>

                ${labelHtml}

            </div>
        `,

                iconSize: [
                    size,
                    size
                ],

                iconAnchor: [
                    size / 2,
                    size / 2
                ],

                popupAnchor: [
                    0,
                    -(size / 2)
                ]

            });

        }
        updateMarker(location) {

            if (!location || !this.map) return;

            const latitude = Number(location.latitude);
            const longitude = Number(location.longitude);

            // ==========================================
            // VALIDAR COORDENADAS
            // ==========================================

            if (
                location.latitude == null ||
                location.longitude == null ||
                String(location.latitude).trim() === '' ||
                String(location.longitude).trim() === '' ||
                !Number.isFinite(latitude) ||
                !Number.isFinite(longitude) ||
                latitude < -90 ||
                latitude > 90 ||
                longitude < -180 ||
                longitude > 180
            ) {

                console.warn(
                    '[Maskana] Coordenadas GPS inválidas:',
                    location
                );

                return;
            }

            const latlng = [latitude, longitude];

            const markerConfig = this.config.marker;

            // ==========================================
            // CREAR MARCADOR DINÁMICO
            // ==========================================

            if (!this.marker) {

                const icon = this.buildMarkerIcon();

                this.marker = L.marker(latlng, {

                    icon: icon,

                    interactive:
                        markerConfig.interactive ?? true,

                    keyboard:
                        markerConfig.keyboard ?? false,

                    draggable:
                        markerConfig.draggable ?? false,

                    zIndexOffset:
                        markerConfig.zIndexOffset ?? 1000

                }).addTo(this.map);

                // ======================================
                // CONFIGURAR POPUP
                // ======================================

                this.updateMarkerPopup();

            } else {

                // ======================================
                // ACTUALIZAR UBICACIÓN EXISTENTE
                // ======================================

                this.marker.setLatLng(latlng);

            }

            // ==========================================
            // ACTUALIZAR PRECISIÓN GPS
            // ==========================================

            this.updateAccuracyCircle(
                latlng,
                location.accuracy
            );

        }
        updateMarkerPopup() {

            if (!this.marker) return;

            const popup = this.config.marker.popup || {};

            // ==========================================
            // DESACTIVAR POPUP
            // ==========================================

            if (!popup.enabled) {

                this.marker.unbindPopup();

                return;
            }

            // ==========================================
            // GENERAR CONTENIDO
            // ==========================================

            const html = this.buildMarkerPopup();

            // ==========================================
            // ACTUALIZAR O CREAR POPUP
            // ==========================================

            if (this.marker.getPopup()) {

                this.marker.setPopupContent(html);

            } else {

                this.marker.bindPopup(html);

            }

        }
        buildMarkerPopup() {

            const popup = this.config.marker.popup || {};

            return `

        <div class="maskana-user-location-popup">

            <strong
                class="maskana-user-location-popup__title"
            >

                ${escapeHtml(popup.title ?? '')}

            </strong>

            <div
                class="maskana-user-location-popup__description"
            >

                ${escapeHtml(popup.description ?? '')}

            </div>

        </div>

    `;

        }
        // ==========================================
        // ELIMINAR MARCADOR
        // ==========================================

        removeMarker() {

            if (this.marker) {
                this.marker.remove();
                this.marker = null;
            }

            if (this.accuracyCircle) {
                this.accuracyCircle.remove();
                this.accuracyCircle = null;
            }

            this.visible = false;
        }

        // ==========================================
        // DESTRUIR CONTROLADOR
        // ==========================================

        destroy() {

            document.removeEventListener(
                'maskana:location:permission',
                this._onPermissionChange
            );

            document.removeEventListener(
                'maskana:location:changed',
                this._onLocationChange
            );

            document.removeEventListener(
                'maskana:location:cleared',
                this._onLocationCleared
            );

            this.button?.removeEventListener(
                'click',
                this._onButtonClick
            );

            this.removeMarker();
        }
    }

    window.MaskanaMapLocationController = MaskanaMapLocationController;

</script>
