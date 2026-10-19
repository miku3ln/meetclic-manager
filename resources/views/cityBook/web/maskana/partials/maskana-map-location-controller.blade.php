<script>

    class MaskanaMapLocationController {

        constructor(map, options = {}) {

            this.map = map;

            this.options = {
                zoom: 17,
                ...options
            };

            this.button = document.getElementById(
                'maskana-location-button'
            );

            this.marker = null;
            this.accuracyCircle = null;

            this.permission = 'unknown';
            this.loading = false;
            this.visible = false;

            this._onPermissionChange = event => {
                this.setPermission(event.detail.permission);
            };

            this._onLocationChange = event => {
                if (this.visible) {
                    this.updateMarker(event.detail.current);
                }
            };

            this._onLocationCleared = () => {
                this.removeMarker();
            };

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


        updateMarker(location) {

            if (!location || !this.map) return;

            const latitude = Number(location.latitude);
            const longitude = Number(location.longitude);

            // ==========================================
            // VALIDAR COORDENADAS
            // ==========================================

            if (
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

            // ==========================================
            // CREAR MARCADOR DE CALABAZA
            // ==========================================

            if (!this.marker) {

                const icon = L.divIcon({
                    className: 'maskana-user-location-marker',

                    html: `
                <div class="maskana-user-pumpkin">

                    <span class="maskana-user-pumpkin__pulse"></span>

                    <span class="maskana-user-pumpkin__emoji">
                        🎃
                    </span>

                    <span class="maskana-user-pumpkin__label">
                        Estás aquí
                    </span>

                </div>
            `,

                    iconSize: [64, 64],
                    iconAnchor: [32, 32],
                    popupAnchor: [0, -30]
                });

                this.marker = L.marker(latlng, {
                    icon: icon,
                    interactive: true,
                    keyboard: false,
                    draggable: false,
                    zIndexOffset: 1000
                }).addTo(this.map);

                this.marker.bindPopup(`
            <div style="text-align:center;">
                <strong>🎃 ¡Estás aquí!</strong>
                <div>
                    Sigue explorando Maskana
                    y descubre los dulces cercanos.
                </div>
            </div>
        `);

            } else {

                // ======================================
                // ACTUALIZAR UBICACIÓN DEL MARCADOR
                // ======================================

                this.marker.setLatLng(latlng);
            }

            // ==========================================
            // CÍRCULO DE PRECISIÓN GPS
            // ==========================================

            const accuracy = Number(location.accuracy);

            if (
                location.accuracy !== null &&
                location.accuracy !== undefined &&
                Number.isFinite(accuracy) &&
                accuracy >= 0
            ) {

                if (!this.accuracyCircle) {

                    this.accuracyCircle = L.circle(latlng, {
                        radius: accuracy,

                        color: '#f97316',
                        weight: 1,
                        opacity: 0.65,

                        fillColor: '#f97316',
                        fillOpacity: 0.08,

                        interactive: false
                    }).addTo(this.map);

                } else {

                    // Actualizar centro y precisión.
                    this.accuracyCircle.setLatLng(latlng);
                    this.accuracyCircle.setRadius(accuracy);
                }

            } else if (this.accuracyCircle) {

                // Eliminar círculo si no hay precisión válida.
                this.accuracyCircle.remove();
                this.accuracyCircle = null;
            }
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
