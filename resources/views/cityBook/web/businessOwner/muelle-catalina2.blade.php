@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
    $sourcesRoot = $resourcePathServer . 'frontend/businessOwner/mikuy-yachak';

@endphp
@extends('layouts.bootstrap5')
@section('additional-styles')
    <style>
        /* Estado oculto de elementos marcados */
        .not-view {
            display: none;
        }

        /* Posición de la barra de botones cuando la cámara está activa */
        .manager-buttons.manager-buttons--view-control-cam {
            position: fixed;
            bottom: 3%;
        }

        /* Normaliza body para canvas XR a pantalla completa */
        body {
            margin: 0;
            overflow: hidden;
        }

        /* El contenedor arranca oculto hasta verificar modo */
        .container--custom.not-view {
            opacity: 1;
        }

        /* Layout de la botonera */
        .manager-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
        }

        /* Forzamos visibilidad de botones AR durante la vista de cámara */
        .manager-buttons--view-control-cam .not-view {
            display: inline-block !important;
        }

        /* Auxiliar específico de items marcados como not-view */
        .manager-buttons__item.not-view {
            display: none;
        }

        #map {
            height: 100vh;
            width: 100%;
        }

        .controls {
            position: fixed;
            z-index: 1000;
            top: 12px;
            left: 12px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 8px 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
            font: 14px/1.2 system-ui, sans-serif;
        }

        .controls button {
            margin-right: 6px;
        }
    </style>
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""
    />
@endsection

@section('additional-scripts')

    <script src="https://unpkg.com/three@0.147.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.147.0/examples/js/controls/OrbitControls.js"></script>
    <script src="https://unpkg.com/three@0.147.0/examples/js/loaders/GLTFLoader.js"></script>
    <!-- Fallback: model-viewer (para iOS/Safari o navegadores sin WebXR) -->
    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
    <script
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""
    ></script>

    <script>
        /* ============================================================
     * AR Viewer — SIN HIT TEST
     *   - Retícula a distancia fija frente a la cámara (simula hit).
     *   - Flujo: Colocar → Explorar → Posición nueva.
     *   - Mantiene tus botones, gestos, autorrotación y fallback.
     * ============================================================ */

        /* ===== Gestor de eventos (igual que el tuyo, sin cambios funcionales) ===== */
        class GestorEventosModelo {
            constructor(viewer, opciones = {}) {
                this.viewer = viewer;
                const porDefecto = {
                    autorrotacion: {activa: true, velocidadRadSeg: 0.8, pausaAlInteractuar: true},
                    clicks: {habilitar: true, umbralXR_metros: 0.25},
                    gestures: {
                        habilitar: true,
                        rotacionFactor: 0.015,
                        rotacionFactorX: 0.010,
                        escalaMin: 0.2,
                        escalaMax: 10.0,
                        pinchFactor: 0.005
                    },
                    onModelClick: null, onDragStart: null, onDrag: null, onDragEnd: null, onScale: null, onRotate: null
                };
                this.cfg = Object.assign({}, porDefecto, opciones);
                if (typeof this.cfg.onModelClick !== 'function') {
                    this.cfg.onModelClick = ({modo, punto}) => {
                        const p = punto ? `${punto.x.toFixed(3)}, ${punto.y.toFixed(3)}, ${punto.z.toFixed(3)}` : '—';
                        console.log('[AR][onModelClick][default]', modo, p);
                        try {
                            window.dispatchEvent(new CustomEvent('ar-model-click', {detail: {modo, punto}}));
                        } catch {
                        }
                    };
                }
                this._raycaster = new THREE.Raycaster();
                this._ndc = new THREE.Vector2();
                this._escuchandoCanvas = false;
                this._escuchandoModelViewer = false;
                this._autorrotacionActiva = !!this.cfg.autorrotacion.activa;
                this._velocidadRadSeg = Number(this.cfg.autorrotacion.velocidadRadSeg || 0.8);
                this._boundingSphere = null;
                this._drag = {activo: false, pointerId: null, lastX: 0, lastY: 0};
                this._pinch = {activo: false, id1: null, id2: null, startDist: 0, startScale: 1};
                this._activePointers = new Map();
            }

            iniciar() {
                this._instalarOyentesCanvas();
                this._instalarOyentesModelViewer();
            }

            aplicarAlModelo(modelo) {
                if (!modelo) return;
                const box = new THREE.Box3().setFromObject(modelo);
                const sphere = new THREE.Sphere();
                box.getBoundingSphere(sphere);
                this._boundingSphere = sphere;
                if (this._autorrotacionActiva) this.viewer.setStatus(this.viewer.msg('eventos.autorrotacion_activada', {vel: this._velocidadRadSeg.toFixed(2)}));
            }

            onFrame(delta) {
                if (!this._autorrotacionActiva) return;
                const m = this.viewer.model;
                if (!m) return;
                m.rotation.y += this._velocidadRadSeg * delta;
            }

            activarAutorrotacion() {
                this._autorrotacionActiva = true;
                this.viewer.setStatus(this.viewer.msg('eventos.autorrotacion_activada', {vel: this._velocidadRadSeg.toFixed(2)}));
            }

            desactivarAutorrotacion() {
                this._autorrotacionActiva = false;
                this.viewer.setStatus(this.viewer.msg('eventos.autorrotacion_desactivada'));
            }

            toggleAutorrotacion() {
                this._autorrotacionActiva ? this.desactivarAutorrotacion() : this.activarAutorrotacion();
            }

            setVelocidadAutorrotacion(v) {
                v = Number(v);
                if (!isFinite(v) || v <= 0) return;
                this._velocidadRadSeg = v;
                if (this._autorrotacionActiva) this.viewer.setStatus(this.viewer.msg('eventos.autorrotacion_actualizada', {vel: this._velocidadRadSeg.toFixed(2)}));
            }

            habilitarClicks() {
                this.cfg.clicks.habilitar = true;
                this.viewer.setStatus(this.viewer.msg('eventos.clicks_habilitados'));
            }

            deshabilitarClicks() {
                this.cfg.clicks.habilitar = false;
                this.viewer.setStatus(this.viewer.msg('eventos.clicks_deshabilitados'));
            }

            habilitarGestos() {
                this.cfg.gestures.habilitar = true;
                this.viewer.setStatus('Gestos habilitados.');
            }

            deshabilitarGestos() {
                this.cfg.gestures.habilitar = false;
                this.viewer.setStatus('Gestos deshabilitados.');
            }

            habilitarInteraccionesModelo() {
                this.habilitarGestos();
                this.habilitarClicks();
            }

            deshabilitarInteraccionesModelo() {
                this.deshabilitarGestos();
                this.deshabilitarClicks();
            }

            _instalarOyentesCanvas() {
                const canvas = this.viewer?.renderer?.domElement;
                if (!canvas || this._escuchandoCanvas) return;
                const toNdc = (evt) => {
                    const r = canvas.getBoundingClientRect();
                    this._ndc.set(((evt.clientX - r.left) / r.width) * 2 - 1, -((evt.clientY - r.top) / r.height) * 2 + 1);
                };
                const onPointer = (evt) => {
                    if (!this.cfg.clicks.habilitar) return;
                    const inXR = !!this.viewer?.renderer?.xr?.isPresenting;
                    if (inXR) return;
                    toNdc(evt);
                    this._raycaster.setFromCamera(this._ndc, this.viewer.camera);
                    if (this.viewer.model) {
                        const inter = this._raycaster.intersectObject(this.viewer.model, true);
                        if (inter && inter.length > 0) {
                            const p = inter[0].point || null;
                            this._emitirClickModelo('visor', p);
                            if (this.cfg.autorrotacion.pausaAlInteractuar && this._autorrotacionActiva) this.desactivarAutorrotacion();
                        }
                    }
                };
                const getIntersectionsModel = (evt) => {
                    toNdc(evt);
                    this._raycaster.setFromCamera(this._ndc, this.viewer.camera);
                    return this.viewer.model ? this._raycaster.intersectObject(this.viewer.model, true) : [];
                };
                const onPointerDown = (evt) => {
                    if (!this.cfg.gestures?.habilitar) return;
                    if (this.viewer?.renderer?.xr?.isPresenting) return;
                    this._activePointers.set(evt.pointerId, {x: evt.clientX, y: evt.clientY});
                    if (evt.pointerType === 'touch') {
                        if (!this._pinch.activo && this._pinch.id1 === null) {
                            this._pinch.id1 = evt.pointerId;
                        } else if (!this._pinch.activo && this._pinch.id2 === null) {
                            this._pinch.id2 = evt.pointerId;
                            this._pinch.activo = true;
                            this._pinch.startDist = 0;
                            this._pinch.startScale = this.viewer?.model?.scale?.x ?? 1;
                        }
                    }
                    const hits = getIntersectionsModel(evt);
                    if (hits.length > 0 && !this._drag.activo) {
                        this._drag.activo = true;
                        this._drag.pointerId = evt.pointerId;
                        this._drag.lastX = evt.clientX;
                        this._drag.lastY = evt.clientY;
                        try {
                            this.cfg.onDragStart && this.cfg.onDragStart({evt, hit: hits[0]});
                        } catch {
                        }
                        if (this.cfg.autorrotacion?.pausaAlInteractuar && this._autorrotacionActiva) {
                            this.desactivarAutorrotacion();
                        }
                    }
                };
                const onPointerMove = (evt) => {
                    if (!this.cfg.gestures?.habilitar) return;
                    if (this.viewer?.renderer?.xr?.isPresenting) return;
                    this._activePointers.set(evt.pointerId, {x: evt.clientX, y: evt.clientY});
                    if (this._pinch.activo && (evt.pointerId === this._pinch.id1 || evt.pointerId === this._pinch.id2)) {
                        if (this._pinch.id1 != null && this._pinch.id2 != null && this._activePointers.has(this._pinch.id1) && this._activePointers.has(this._pinch.id2)) {
                            const p1 = this._activePointers.get(this._pinch.id1),
                                p2 = this._activePointers.get(this._pinch.id2);
                            const dx = p1.x - p2.x, dy = p1.y - p2.y;
                            const dist = Math.sqrt(dx * dx + dy * dy);
                            if (this._pinch.startDist === 0) {
                                this._pinch.startDist = dist || 1;
                            } else if (dist > 0 && this.viewer?.model) {
                                const delta = (dist - this._pinch.startDist) * (this.cfg.gestures.pinchFactor || 0.005);
                                const base = this._pinch.startScale || 1;
                                const next = THREE.MathUtils.clamp(base + delta, this.cfg.gestures.escalaMin, this.cfg.gestures.escalaMax);
                                this.viewer.setUniformScale(next);
                                try {
                                    this.cfg.onScale && this.cfg.onScale({scale: next});
                                } catch {
                                }
                            }
                        }
                        return;
                    }
                    if (this._drag.activo && evt.pointerId === this._drag.pointerId && this.viewer?.model) {
                        const dx = evt.clientX - this._drag.lastX, dy = evt.clientY - this._drag.lastY;
                        this._drag.lastX = evt.clientX;
                        this._drag.lastY = evt.clientY;
                        const fy = this.cfg.gestures.rotacionFactor || 0.015,
                            fx = this.cfg.gestures.rotacionFactorX || 0.010;
                        this.viewer.model.rotation.y += dx * fy;
                        this.viewer.model.rotation.x = THREE.MathUtils.clamp(this.viewer.model.rotation.x - dy * fx, -Math.PI / 2, Math.PI / 2);
                        try {
                            this.cfg.onRotate && this.cfg.onRotate({
                                rotY: this.viewer.model.rotation.y,
                                rotX: this.viewer.model.rotation.x
                            });
                            this.cfg.onDrag && this.cfg.onDrag({dx, dy});
                        } catch {
                        }
                    }
                };
                const onPointerUpCancel = (evt) => {
                    if (!this.cfg.gestures?.habilitar) return;
                    if (this.viewer?.renderer?.xr?.isPresenting) return;
                    this._activePointers.delete(evt.pointerId);
                    if (this._pinch.activo && (evt.pointerId === this._pinch.id1 || evt.pointerId === this._pinch.id2)) {
                        if (evt.pointerId === this._pinch.id1) this._pinch.id1 = null;
                        if (evt.pointerId === this._pinch.id2) this._pinch.id2 = null;
                        if (this._pinch.id1 == null || this._pinch.id2 == null) {
                            this._pinch.activo = false;
                            this._pinch.startDist = 0;
                        }
                    }
                    if (this._drag.activo && evt.pointerId === this._drag.pointerId) {
                        this._drag.activo = false;
                        this._drag.pointerId = null;
                        try {
                            this.cfg.onDragEnd && this.cfg.onDragEnd({evt});
                        } catch {
                        }
                    }
                };
                canvas.addEventListener('pointerdown', onPointerDown, {passive: true});
                canvas.addEventListener('pointermove', onPointerMove, {passive: true});
                canvas.addEventListener('pointerup', onPointerUpCancel, {passive: true});
                canvas.addEventListener('pointercancel', onPointerUpCancel, {passive: true});
                canvas.addEventListener('pointerdown', onPointer, {passive: true});
                this._escuchandoCanvas = true;
            }

            _instalarOyentesModelViewer() {
                if (this._escuchandoModelViewer) return;
                const mvSel = this.viewer?.cfg?.ui?.modelViewer;
                if (!mvSel) return;
                const mv = document.querySelector(mvSel);
                if (!mv) return;
                const onClick = () => {
                    if (!this.cfg.clicks.habilitar) return;
                    this._emitirClickModelo('fallback', null);
                    if (this.cfg.autorrotacion.pausaAlInteractuar && this._autorrotacionActiva) {
                        this.desactivarAutorrotacion();
                    }
                };
                mv.addEventListener('click', onClick, {passive: true});
                this._escuchandoModelViewer = true;
            }

            onSelectXR(reticleMat) {
                if (!this.cfg.clicks.habilitar) return;
                if (!this.viewer?.model || !this._boundingSphere) return;
                const centro = this._boundingSphere.center.clone().applyMatrix4(this.viewer.model.matrixWorld);
                const posRet = new THREE.Vector3();
                posRet.setFromMatrixPosition(reticleMat);
                const dist = posRet.distanceTo(centro);
                if (dist <= this.cfg.clicks.umbralXR_metros) {
                    this._emitirClickModelo('xr', posRet);
                    if (this.cfg.autorrotacion.pausaAlInteractuar && this._autorrotacionActiva) {
                        this.desactivarAutorrotacion();
                    }
                }
            }

            _emitirClickModelo(modo, punto) {
                const px = punto ? punto.x.toFixed(3) : '—', py = punto ? punto.y.toFixed(3) : '—',
                    pz = punto ? punto.z.toFixed(3) : '—';
                this.viewer.setStatus(this.viewer.msg('eventos.click_modelo', {modo, x: px, y: py, z: pz}));
                try {
                    this.cfg.onModelClick({modo, punto});
                } catch {
                }
            }
        }

        /* =======================
         * Viewer principal (SIN HIT TEST)
         *   Cambios clave:
         *   - Se elimina toda la lógica de hit-test.
         *   - Retícula se posiciona a distancia fija (placeDist) frente a la cámara cada frame.
         *   - Colocación usa esa retícula “simulada”.
         * ======================= */
        class JQueryArViewer {
            constructor(options = {}) {
                const defaults = {
                    glbUrl: '',
                    usdzUrl: '',
                    ui: {
                        hint: '#hint', fallback: '#fallback', modelViewer: '#mv',
                        enterBtn: '#btn-enter-ar', resetBtn: '#btn-reset',
                        zoomInBtn: '#btn-zoom-in', zoomOutBtn: '#btn-zoom-out',
                        scale1xBtn: '#btn-scale-1x', scale2xBtn: '#btn-scale-2x',
                        rotLeftBtn: '#btn-rot-left', rotRightBtn: '#btn-rot-right',
                        rotUpBtn: '#btn-rot-up', rotDownBtn: '#btn-rot-down',
                        exploreBtn: '#btn-explore', newPosBtn: '#btn-new-pos'
                    },
                    reticle: {
                        innerRadius: 0.08,
                        outerRadius: 0.10,
                        segments: 32,
                        color: 0x00ffaa,
                        innerDot: true,
                        pulse: true,
                        pulseMin: 0.95,
                        pulseMax: 1.05
                    },
                    model: {
                        initialScale: 1.0,
                        minScale: 0.2,
                        maxScale: 10.0,
                        zoomFactor: 1.10,
                        rotationStepY: 0.15,
                        rotationStepX: 0.10
                    },
                    camera: {fov: 60, near: 0.01, far: 20, toneMapping: THREE.ACESFilmicToneMapping, toneExposure: 1.2},
                    lighting: {
                        useLightEstimation: false,
                        hemiSky: 0xffffff,
                        hemiGround: 0x404060,
                        hemiIntensity: 1.1,
                        dirColor: 0xffffff,
                        dirIntensity: 0.6
                    },
                    xr: {
                        requiredFeatures: ['local'],
                        optionalFeatures: ['dom-overlay', 'unbounded'],
                        domOverlayRoot: () => document.body
                    },
                    // NUEVO: parámetros de “simulación de hit”
                    fixedPlacement: {placeDist: 1.2, smoothFactor: 0.35, lockHorizontal: true},
                    uiBehavior: {
                        disableDuring: {sessionStart: true, modelLoad: true},
                        lockCursor: true,
                        include: null,
                        exclude: ['hint', 'fallback', 'modelViewer']
                    },
                    events: {
                        autorrotacion: {activa: true, velocidadRadSeg: 0.8, pausaAlInteractuar: true},
                        clicks: {habilitar: true, umbralXR_metros: 0.25},
                        gestures: {habilitar: true, rotacionFactor: 0.015, rotacionFactorX: 0.010, pinchFactor: 0.005},
                        onModelClick: null,
                        onDragStart: null,
                        onDrag: null,
                        onDragEnd: null,
                        onScale: null,
                        onRotate: null
                    },
                    i18n: {
                        locale: 'es', textos: {
                            etiquetas: {botonVer: 'Entrar', verEnAr: 'Ver en AR'},
                            estado: {
                                listo: 'Listo. Toca “Entrar en AR”. (requiere HTTPS)',
                                ios_quicklook: 'iOS: pulsa “Ver en AR” para Quick Look.',
                                ios_sin_usdz: 'iOS: sin USDZ, se mostrará el visor 3D.',
                                visor_3d: 'Modo visor 3D. La Realidad Aumentada no está disponible en este dispositivo.',
                                iniciado: 'AR iniciada.',
                                // sin_reticula ya no aplica con fixed, pero lo mantenemos por compatibilidad
                                sin_reticula: 'Retícula no disponible.',
                                modelo_movido: 'Modelo movido.',
                                cargando_modelo: 'Cargando modelo…',
                                progreso_carga: 'Cargando {porcentaje}%…',
                                colocado: 'Modelo cargado y colocado.',
                                reiniciado: 'Modelo reiniciado. Toca para colocarlo nuevamente.',
                                no_modelo_reiniciar: 'No hay modelo para reiniciar.',
                                sesion_finalizada: 'Sesión de AR finalizada.',
                                fallback_activo: 'Fallback activo. Usa “Ver en AR” si está disponible.',
                                visor_reiniciando: 'Reiniciando visor AR…',
                                visor_reiniciado: 'Visor reiniciado por completo.',
                                escala: 'Escala: {valor}',
                                rotY: 'Rotación Y: {valor}',
                                rotX: 'Rotación X: {valor}',
                                ios_visor_activo: 'iOS: visor 3D activo. Provee USDZ para Quick Look.',
                                visor_3d_activo: 'Visor 3D activo.',
                                colocar_primero: 'Ajusta el encuadre y pulsa en el controlador para colocar.',
                                explorar_habilitado: 'Explorar habilitado.',
                                explorar_deshabilitado: 'Explorar deshabilitado.',
                                recolocar_listo: 'Posición nueva: apunta y confirma.',
                                toque_fuera_reticula: 'Toca el controlador para colocar.',
                                recolocado: 'Modelo recolocado. Puedes pulsar Explorar.'
                            },
                            eventos: {
                                autorrotacion_activada: 'Autorrotación activada (vel: {vel} rad/s).',
                                autorrotacion_desactivada: 'Autorrotación desactivada.',
                                autorrotacion_actualizada: 'Velocidad de autorrotación actualizada a {vel} rad/s.',
                                clicks_habilitados: 'Captura de clics habilitada.',
                                clicks_deshabilitados: 'Captura de clics deshabilitada.',
                                callback_configurado: 'Callback onModelClick configurado.',
                                click_modelo: 'Click sobre el modelo ({modo}) en ({x}, {y}, {z}).'
                            },
                            error: {
                                init: 'Falló la inicialización.',
                                modo: 'Falló la selección del modo de operación.',
                                iniciar_ar: 'No se pudo iniciar la Realidad Aumentada.',
                                cargar_glb: 'No se pudo cargar el modelo GLB.',
                                colocar_modelo: 'Error inesperado al colocar el modelo.',
                                frame: 'Error durante el frame de AR.',
                                mostrar_fallback: 'No se pudo mostrar el visor de respaldo.',
                                reset_total: 'Falló el reinicio completo del visor.',
                                deshabilitar_ui: 'Falló el cambio de estado de la UI.'
                            },
                            consola: {prefijo: '[AR]'}
                        }
                    }
                };
                this.cfg = Object.assign({}, defaults, options);

                this.platform = JQueryArViewer.detectPlatform();

                // Estados Three/XR
                this.renderer = null;
                this.scene = null;
                this.camera = null;
                this.session = null;
                this.referenceSpace = null;
                this.viewerSpace = null;
                this.reticle = null;
                this.model = null;

                // Estado retícula “fija”
                this._reticleState = null; // {pos,quat,scl}
                this._smoothFactor = this.cfg.fixedPlacement.smoothFactor ?? 0.35;

                // jQuery cache
                this.$win = window.jQuery ? jQuery(window) : {
                    on: () => {
                    }
                };
                this.$hint = window.jQuery ? jQuery(this.cfg.ui.hint) : null;

                // Gestor eventos
                this.eventos = new GestorEventosModelo(this, this.cfg.events);

                // Delta
                this._lastTs = null;

                // Política de colocación (mantenemos compatibilidad)
                this.placeOnlyWhenReticleHit = false; // con fixed no necesitamos gate por “anillo”

                // Flujo UI
                this.uiState = {inPlacementMode: false, hasPlaced: false, exploring: false};
            }

            static detectPlatform() {
                const ua = navigator.userAgent || navigator.vendor || window.opera || '';
                const isAndroid = /Android/i.test(ua);
                const isIOS = /iPhone|iPad|iPod/i.test(ua) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
                return {isAndroid, isIOS};
            }

            async decideMode() {
                const {isAndroid, isIOS} = this.platform;
                if (isIOS) return 'ios-fallback';
                if (isAndroid) {
                    const supported = await this.isImmersiveArAvailable();
                    return supported ? 'android-webxr' : 'fallback';
                }
                return 'fallback';
            }

            _get(obj, path) {
                if (!obj || !path) return undefined;
                const parts = String(path).split('.');
                let cur = obj;
                for (const p of parts) {
                    if (cur && Object.prototype.hasOwnProperty.call(cur, p)) cur = cur[p]; else return undefined;
                }
                return cur;
            }

            _fmt(tpl, params = {}) {
                if (typeof tpl !== 'string') return tpl;
                return tpl.replace(/\{(\w+)\}/g, (_, k) => {
                    const v = params[k];
                    return v == null ? '' : String(v);
                });
            }

            msg(key, params = {}) {
                const base = this.cfg.i18n?.textos || {};
                const val = this._get(base, key);
                return this._fmt(val || key, params);
            }

            setStatus(m) {
                const prefix = this.msg('consola.prefijo');
                console.log(prefix, m);
                this.$hint && this.$hint.text(m);
            }

            logError(key, params = {}, errorObj = null) {
                const prefix = this.msg('consola.prefijo');
                if (errorObj) console.error(prefix, this.msg(key, params), errorObj); else console.error(prefix, this.msg(key, params));
                this.setStatus(this.msg(key));
            }

            /* ===== API ===== */
            init() {
                try {
                    this.bindUi();
                    this.setStatus(this.msg('estado.listo'));
                    this.eventos.iniciar();
                    this._initByMode();
                } catch (err) {
                    this.logError('error.init', {}, err);
                }
            }

            async _initByMode() {
                try {
                    const mode = await this.decideMode();
                    if (mode === 'android-webxr') {
                        if (window.jQuery) jQuery(this.cfg.ui.fallback).addClass('d-none');
                        if (window.jQuery) jQuery(this.cfg.ui.enterBtn).text(this.msg('etiquetas.botonVer'));
                    } else if (mode === 'ios-fallback') {
                        this.showFallback();
                        if (window.jQuery) jQuery(this.cfg.ui.enterBtn).off('click');
                        this.setStatus(this.cfg.usdzUrl ? this.msg('estado.ios_quicklook') : this.msg('estado.ios_sin_usdz'));
                        this._hideArControlsExcept(['hint', 'fallback', 'modelViewer']);
                    } else {
                        this.showFallback();
                        if (window.jQuery) {
                            jQuery(this.cfg.ui.enterBtn).off('click').addClass('disabled').attr('aria-disabled', 'true');
                        }
                        this.setStatus(this.msg('estado.visor_3d'));
                        this._hideArControlsExcept(['hint', 'fallback', 'modelViewer']);
                    }
                } catch (err) {
                    this.logError('error.modo', {}, err);
                    this.showFallback();
                    this._hideArControlsExcept(['hint', 'fallback', 'modelViewer']);
                }
            }

            _hideArControlsExcept(keys = []) {
                if (!window.jQuery) return;
                const entries = Object.entries(this.cfg.ui || {});
                entries.forEach(([key, sel]) => {
                    if (!sel) return;
                    if (keys.includes(key)) return;
                    const $el = jQuery(sel);
                    if ($el.length) {
                        $el.addClass('d-none').prop('disabled', true).attr('aria-disabled', 'true').css('pointer-events', 'none');
                    }
                });
            }

            configureCamera(opts = {}) {
                Object.assign(this.cfg.camera, opts);
                if (this.camera) {
                    this.camera.fov = this.cfg.camera.fov;
                    this.camera.near = this.cfg.camera.near;
                    this.camera.far = this.cfg.camera.far;
                    this.camera.updateProjectionMatrix();
                }
                if (this.renderer) {
                    this.renderer.toneMapping = this.cfg.camera.toneMapping;
                    this.renderer.toneMappingExposure = this.cfg.camera.toneExposure;
                }
            }

            configureFixedPlacement(opts = {}) {
                Object.assign(this.cfg.fixedPlacement, opts);
                this._smoothFactor = this.cfg.fixedPlacement.smoothFactor ?? 0.35;
            }

            configureReticle(opts = {}) {
                Object.assign(this.cfg.reticle, opts);
                if (this.reticle?.material?.color) this.reticle.material.color.setHex(this.cfg.reticle.color);
            }

            async startAr() {
                try {
                    if (this._starting) return;
                    this._starting = true;
                    const available = await this.isImmersiveArAvailable();
                    if (!available) {
                        this._starting = false;
                        return this.showFallback();
                    }
                    if (this.cfg.uiBehavior?.disableDuring?.sessionStart) this.disableUI(true);
                    this.initThreeIfNeeded();
                    this.session = await navigator.xr.requestSession('immersive-ar', {
                        requiredFeatures: this.cfg.xr.requiredFeatures, optionalFeatures: this.cfg.xr.optionalFeatures,
                        domOverlay: {root: this.cfg.xr.domOverlayRoot()}
                    });
                    await this.onSessionStarted(this.session);
                    if (this.cfg.uiBehavior?.disableDuring?.sessionStart) this.disableUI(false);
                } catch (err) {
                    this.logError('error.iniciar_ar', {}, err);
                    this.resetEverything();
                    this.showFallback();
                } finally {
                    this._starting = false;
                }
            }

            exitAr() {
                try {
                    if (this.session) this.session.end(); else this.resetEverything();
                } catch {
                    this.resetEverything();
                }
            }

            reset() {
                try {
                    if (!this.model) return this.setStatus(this.msg('estado.no_modelo_reiniciar'));
                    this.scene.remove(this.model);
                    this.disposeObject(this.model);
                    this.model = null;
                    this.setStatus(this.msg('estado.reiniciado'));
                } catch (err) {
                    this.logError('error.reset_total', {}, err);
                }
            }

            zoomIn() {
                if (this.model) this.setUniformScale(this.model.scale.x * this.cfg.model.zoomFactor);
            }

            zoomOut() {
                if (this.model) this.setUniformScale(this.model.scale.x / this.cfg.model.zoomFactor);
            }

            setScale(v) {
                if (this.model) this.setUniformScale(v);
            }

            rotateY(d) {
                if (!this.model) return;
                this.model.rotation.y += d;
                this.setStatus(this.msg('estado.rotY', {valor: this.model.rotation.y.toFixed(2)}));
            }

            rotateX(d) {
                if (!this.model) return;
                this.model.rotation.x = this.clamp(this.model.rotation.x + d, -Math.PI / 2, Math.PI / 2);
                this.setStatus(this.msg('estado.rotX', {valor: this.model.rotation.x.toFixed(2)}));
            }

            initThreeIfNeeded() {
                if (this.renderer) return;
                this.renderer = new THREE.WebGLRenderer({antialias: true, alpha: true});
                this.renderer.xr.enabled = true;
                this.renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
                this.renderer.toneMapping = this.cfg.camera.toneMapping ?? THREE.ACESFilmicToneMapping;
                this.renderer.toneMappingExposure = Number(this.cfg.camera.toneExposure ?? 1.2);
                this.fitToWindow();
                document.body.appendChild(this.renderer.domElement);

                if (this.eventos && typeof this.eventos._instalarOyentesCanvas === 'function') this.eventos._instalarOyentesCanvas();

                this.scene = new THREE.Scene();
                const aspect = Math.max(window.innerWidth, 1) / Math.max(window.innerHeight, 1);
                this.camera = new THREE.PerspectiveCamera(Number(this.cfg.camera.fov ?? 60), aspect, Number(this.cfg.camera.near ?? 0.01), Number(this.cfg.camera.far ?? 20));

                this.addLights(this.scene);
                this.reticle = this.createReticle();
                this.scene.add(this.reticle);

                this.renderer.setAnimationLoop(this.onXrFrame.bind(this));
                if (this.$win.on) this.$win.on('resize', this.fitToWindow.bind(this));
            }

            addLights(scene) {
                const hemi = new THREE.HemisphereLight(this.cfg.lighting.hemiSky, this.cfg.lighting.hemiGround, this.cfg.lighting.hemiIntensity);
                scene.add(hemi);
                const dir = new THREE.DirectionalLight(this.cfg.lighting.dirColor, this.cfg.lighting.dirIntensity);
                dir.position.set(0, 0, -1);
                this._cameraDirLight = dir;
                scene.add(dir);
            }

            createReticle() {
                const r = this.cfg.reticle;
                const g = new THREE.RingGeometry(r.innerRadius, r.outerRadius, r.segments);
                g.rotateX(-Math.PI / 2);
                const mat = new THREE.MeshBasicMaterial({color: r.color, transparent: true, opacity: 0.96});
                const ring = new THREE.Mesh(g, mat);
                ring.matrixAutoUpdate = false;
                ring.visible = false;
                if (r.innerDot) {
                    const dGeo = new THREE.CircleGeometry(r.innerRadius * 0.3, 24);
                    dGeo.rotateX(-Math.PI / 2);
                    const dMat = new THREE.MeshBasicMaterial({color: r.color, transparent: true, opacity: 1});
                    const dot = new THREE.Mesh(dGeo, dMat);
                    dot.position.set(0, 0.001, 0);
                    ring.add(dot);
                    ring._dot = dot;
                }
                if (r.pulse) ring._pulse = {t: 0, min: r.pulseMin ?? 0.95, max: r.pulseMax ?? 1.05};
                return ring;
            }

            fitToWindow() {
                if (!this.renderer) return;
                const w = Math.max(window.innerWidth, 1), h = Math.max(window.innerHeight, 1);
                this.renderer.setSize(w, h);
                if (this.camera && h > 0) {
                    this.camera.aspect = w / h;
                    this.camera.updateProjectionMatrix();
                }
            }

            async isImmersiveArAvailable() {
                const secure = location.protocol === 'https:' || location.hostname === 'localhost';
                if (!secure || !navigator.xr) return false;
                try {
                    return await navigator.xr.isSessionSupported('immersive-ar');
                } catch {
                    return false;
                }
            }

            async onSessionStarted(session) {
                this.renderer.xr.setReferenceSpaceType('local');
                await this.renderer.xr.setSession(session);
                session.addEventListener('end', this.onSessionEnded.bind(this));
                this.referenceSpace = await session.requestReferenceSpace('local');
                this.viewerSpace = await session.requestReferenceSpace('viewer');

                this.attachController();
                this.setStatus(this.msg('estado.iniciado'));
                this.initViewUICam();

                // Estado inicial: modo colocación con retícula visible
                this.uiState.inPlacementMode = true;
                this.uiState.hasPlaced = false;
                this.uiState.exploring = false;
                if (window.jQuery) {
                    jQuery(this.cfg.ui.exploreBtn).prop('disabled', true).addClass('disabled');
                    jQuery(this.cfg.ui.newPosBtn).prop('disabled', true).addClass('disabled');
                }
                this.setStatus(this.msg('estado.colocar_primero'));
            }

            onSessionEnded() {
                this.setStatus(this.msg('estado.sesion_finalizada'));
                this.resetEverything();
                this.disableUI(false);
            }

            attachController() {
                const controller = this.renderer.xr.getController(0);
                controller.addEventListener('select', this.onXrSelect.bind(this));
                this.scene.add(controller);
            }

            // En fixed no verificamos impacto exacto sobre anillo; basta confirmar input
            onXrSelect() {
                try {
                    if (this.uiState.inPlacementMode) {
                        const ret = this.reticle;
                        if (!ret || !ret.visible || !ret.matrixWorld) {
                            this.setStatus(this.msg('estado.sin_reticula'));
                            return;
                        }
                        this.placeOrMoveModelAtReticle();
                        if (this.eventos && typeof this.eventos.onSelectXR === 'function') this.eventos.onSelectXR(this.reticle.matrixWorld);
                        this.uiState.hasPlaced = true;
                        this._enterLockedAfterPlacement();
                        return;
                    }
                    if (this.uiState.exploring && this.eventos?.cfg?.clicks?.habilitar) {
                        const hit = this._intersectControllerWithModel();
                        if (hit) {
                            this.eventos._emitirClickModelo('xr', hit.point || null);
                            if (this.eventos?.cfg?.autorrotacion?.pausaAlInteractuar && this.eventos._autorrotacionActiva) this.eventos.desactivarAutorrotacion();
                        } else {
                            this.setStatus('Apunta al modelo para interactuar.');
                        }
                        return;
                    }
                    this.setStatus('Pulsa “Posición nueva” o “Explorar”.');
                } catch (err) {
                    this.logError('error.frame', {}, err);
                }
            }

            _enterLockedAfterPlacement() {
                this.uiState.inPlacementMode = false;
                this.uiState.exploring = false;
                if (window.jQuery) {
                    jQuery(this.cfg.ui.exploreBtn).prop('disabled', false).removeClass('disabled');
                    jQuery(this.cfg.ui.newPosBtn).prop('disabled', false).removeClass('disabled');
                }
                this.setStatus(this.msg('estado.colocado') + ' ' + this.msg('estado.explorar_habilitado'));
            }

            enterExploreMode() {
                this.eventos?.habilitarInteraccionesModelo?.();
                this.uiState.exploring = true;
                if (window.jQuery) {
                    jQuery(this.cfg.ui.exploreBtn).prop('disabled', true).addClass('disabled');
                    jQuery(this.cfg.ui.newPosBtn).prop('disabled', false).removeClass('disabled');
                }
                this.setStatus('Explorar activo. Gestos y clicks habilitados.');
            }

            enterPlacementMode() {
                this.eventos?.deshabilitarInteraccionesModelo?.();
                this.uiState.exploring = false;
                this.uiState.inPlacementMode = true;
                if (window.jQuery) {
                    jQuery(this.cfg.ui.exploreBtn).prop('disabled', true).addClass('disabled');
                    jQuery(this.cfg.ui.newPosBtn).prop('disabled', true).addClass('disabled');
                }
                this.setStatus(this.msg('estado.recolocar_listo'));
            }

            placeOrMoveModelAtReticle() {
                const mat = new THREE.Matrix4().copy(this.reticle.matrix);
                if (this.model) {
                    this.applyMatrixToModel(this.model, mat);
                    return this.setStatus(this.msg('estado.modelo_movido'));
                }
                try {
                    this.setStatus(this.msg('estado.cargando_modelo'));
                    if (this.cfg.uiBehavior?.disableDuring?.modelLoad) this.disableUI(true);
                    this.showLoading();
                    const loader = new THREE.GLTFLoader();
                    loader.load(this.cfg.glbUrl, (gltf) => {
                            this.model = gltf.scene;
                            this.hardenModel(this.model);
                            this.setUniformScale(this.cfg.model.initialScale);
                            this.applyMatrixToModel(this.model, mat);
                            this.scene.add(this.model);
                            this.eventos.aplicarAlModelo(this.model);
                            this.hideLoading();
                            if (this.cfg.uiBehavior?.disableDuring?.modelLoad) this.disableUI(false);
                            this.setStatus(this.msg('estado.colocado'));
                        }, (xhr) => {
                            const pct = Math.round((xhr.loaded / xhr.total) * 100);
                            if (isFinite(pct)) this.setStatus(this.msg('estado.progreso_carga', {porcentaje: pct}));
                        },
                        (err) => {
                            this.hideLoading();
                            if (this.cfg.uiBehavior?.disableDuring?.modelLoad) this.disableUI(false);
                            this.logError('error.cargar_glb', {}, err);
                        });
                } catch (err) {
                    this.logError('error.colocar_modelo', {}, err);
                    this.hideLoading();
                    if (this.cfg.uiBehavior?.disableDuring?.modelLoad) this.disableUI(false);
                }
            }

            onXrFrame(tsMs) {
                let delta = 0.016;
                if (typeof tsMs === 'number') {
                    if (this._lastTs == null) this._lastTs = tsMs;
                    delta = Math.max(0, (tsMs - this._lastTs) / 1000);
                    this._lastTs = tsMs;
                }
                try {
                    // 1) Actualizar retícula “simulada” a distancia fija
                    if (this.referenceSpace && this.renderer?.xr?.isPresenting) {
                        const m = this._computeFixedReticleMatrix();
                        this._smoothReticleUpdate(m);
                        // visible SOLO en modo colocación
                        if (this.reticle) this.reticle.visible = !!this.uiState.inPlacementMode;
                        if (this.reticle && this.reticle.visible && this.reticle._pulse) {
                            const p = this.reticle._pulse;
                            p.t += 0.02;
                            const s = p.min + (p.max - p.min) * (0.5 + 0.5 * Math.sin(p.t));
                            this.reticle.scale.set(s, 1, s);
                        }
                    }
                    // 2) Luz ligada a cámara (igual que antes)
                    if (this._cameraDirLight && this.camera) {
                        this._cameraDirLight.position.copy(this.camera.position);
                        const fwd = new THREE.Vector3(0, 0, -1).applyQuaternion(this.camera.quaternion);
                        if (!this._cameraDirLight.target?.parent) this.scene.add(this._cameraDirLight.target);
                        this._cameraDirLight.target.position.copy(this.camera.position.clone().add(fwd));
                    }
                } catch (frameErr) {
                    this.logError('error.frame', {}, frameErr);
                }

                try {
                    this.eventos.onFrame(delta);
                } catch {
                }
                if (this.renderer && this.camera) this.renderer.render(this.scene, this.camera);
            }

            // Matriz de retícula a distancia fija PLACE DIST frente a cámara
            _computeFixedReticleMatrix() {
                const placeDist = Number(this.cfg.fixedPlacement.placeDist ?? 1.2);
                const xrCam = this.renderer.xr.getCamera(this.camera);
                const pos = new THREE.Vector3().copy(xrCam.position);
                const forward = new THREE.Vector3(0, 0, -1).applyQuaternion(xrCam.quaternion).normalize();
                const targetPos = pos.addScaledVector(forward, placeDist);
                const quat = new THREE.Quaternion();
                // lockHorizontal: retícula plana y=constante
                if (this.cfg.fixedPlacement.lockHorizontal) {
                    quat.setFromEuler(new THREE.Euler(-Math.PI / 2, 0, 0));
                } else {
                    quat.copy(xrCam.quaternion);
                }
                const scl = new THREE.Vector3(1, 1, 1);
                const m = new THREE.Matrix4();
                m.compose(targetPos, quat, scl);
                return m;
            }

            _smoothReticleUpdate(targetMatrix) {
                if (!this.reticle) return;
                if (!this._reticleState) {
                    const p = new THREE.Vector3(), q = new THREE.Quaternion(), sc = new THREE.Vector3();
                    targetMatrix.decompose(p, q, sc);
                    this._reticleState = {pos: p.clone(), quat: q.clone(), scl: sc.clone()};
                    this.reticle.matrix.compose(this._reticleState.pos, this._reticleState.quat, this._reticleState.scl);
                    this.reticle.matrixAutoUpdate = false;
                    this.reticle.updateMatrixWorld(true);
                    return;
                }
                const tPos = new THREE.Vector3(), tQuat = new THREE.Quaternion(), tScl = new THREE.Vector3();
                targetMatrix.decompose(tPos, tQuat, tScl);
                const s = this._smoothFactor ?? 0.35;
                this._reticleState.pos.lerp(tPos, s);
                this._reticleState.scl.lerp(tScl, s);
                this._reticleState.quat.slerp(tQuat, s);
                this.reticle.matrix.compose(this._reticleState.pos, this._reticleState.quat, this._reticleState.scl);
                this.reticle.matrixAutoUpdate = false;
                this.reticle.updateMatrixWorld(true);
            }

            hardenModel(root) {
                root.traverse(o => {
                    if (!o.isMesh) return;
                    o.frustumCulled = false;
                    const m = o.material;
                    if (m) {
                        if (Array.isArray(m)) m.forEach(mm => mm.side = THREE.DoubleSide); else m.side = THREE.DoubleSide;
                    }
                });
            }

            applyMatrixToModel(model, mat4) {
                model.position.setFromMatrixPosition(mat4);
                model.quaternion.setFromRotationMatrix(mat4);
                model.updateMatrixWorld(true);
            }

            setUniformScale(value) {
                const s = this.clamp(value, this.cfg.model.minScale, this.cfg.model.maxScale);
                this.model.scale.set(s, s, s);
                this.setStatus(this.msg('estado.escala', {valor: s.toFixed(2)}));
            }

            disposeObject(root) {
                root.traverse(o => {
                    if (!o.isMesh) return;
                    if (o.geometry && o.geometry.dispose) o.geometry.dispose();
                    const m = o.material;
                    if (!m) return;
                    if (Array.isArray(m)) m.forEach(mm => mm && mm.dispose && mm.dispose()); else m.dispose && m.dispose();
                });
            }

            bindUi() {
                const $ = window.jQuery ? jQuery : null;
                if (!$) return;
                $(this.cfg.ui.enterBtn).on('click', async () => {
                    const mode = await this.decideMode();
                    if (mode === 'android-webxr') return this.startAr();
                    if (mode === 'ios-fallback') {
                        const mv = document.querySelector(this.cfg.ui.modelViewer);
                        if (mv && this.cfg.usdzUrl) {
                            try {
                                if (typeof mv.activateAR === 'function') {
                                    mv.activateAR();
                                    return;
                                }
                            } catch {
                            }
                        }
                        this.setStatus(this.msg('estado.ios_visor_activo'));
                        return;
                    }
                    this.setStatus(this.msg('estado.visor_3d_activo'));
                });
                $(this.cfg.ui.resetBtn).on('click', () => this.reset());
                $(this.cfg.ui.zoomInBtn).on('click', () => this.zoomIn());
                $(this.cfg.ui.zoomOutBtn).on('click', () => this.zoomOut());
                $(this.cfg.ui.scale1xBtn).on('click', () => this.setScale(1));
                $(this.cfg.ui.scale2xBtn).on('click', () => this.setScale(2));
                $(this.cfg.ui.rotLeftBtn).on('click', () => this.rotateY(-this.cfg.model.rotationStepY));
                $(this.cfg.ui.rotRightBtn).on('click', () => this.rotateY(+this.cfg.model.rotationStepY));
                $(this.cfg.ui.rotUpBtn).on('click', () => this.rotateX(+this.cfg.model.rotationStepX));
                $(this.cfg.ui.rotDownBtn).on('click', () => this.rotateX(-this.cfg.model.rotationStepX));
                $(this.cfg.ui.exploreBtn).on('click', () => {
                    if (!this.uiState.hasPlaced) return;
                    this.enterExploreMode();
                });
                $(this.cfg.ui.newPosBtn).on('click', () => {
                    this.enterPlacementMode();
                });
            }

            handleError(error, key = 'error.colocar_modelo') {
                this.logError(key, {}, error);
            }

            clamp(v, min, max) {
                return Math.min(max, Math.max(min, v));
            }

            showLoading() {
                if (window.jQuery) jQuery('#ar-loading').removeClass('d-none');
            }

            hideLoading() {
                if (window.jQuery) jQuery('#ar-loading').addClass('d-none');
            }

            showFallback() {
                try {
                    if (window.jQuery) jQuery(this.cfg.ui.fallback).removeClass('d-none');
                    const mv = document.querySelector(this.cfg.ui.modelViewer);
                    if (!mv) return;
                    mv.src = this.cfg.glbUrl || '';
                    if (this.cfg.usdzUrl) mv.setAttribute('ios-src', this.cfg.usdzUrl);
                    mv.setAttribute('ar', '');
                    mv.setAttribute('ar-modes', 'webxr scene-viewer quick-look');
                    mv.setAttribute('camera-controls', '');
                    mv.setAttribute('environment-image', 'neutral');
                    this.setStatus(this.msg('estado.fallback_activo'));
                    this.eventos?._instalarOyentesModelViewer();
                } catch (err) {
                    this.logError('error.mostrar_fallback', {}, err);
                }
            }

            resetEverything() {
                this.session = null;
                this.disableUI(false);
                if (window.jQuery) {
                    jQuery(this.cfg.ui.hint).text(this.msg('estado.listo'));
                }
                this.setStatus(this.msg('estado.visor_reiniciando'));
                if (this.reticle) this.reticle.visible = false;
                try {
                    if (this.renderer) this.renderer.setAnimationLoop(null);
                    if (this.model) {
                        this.disposeObject(this.model);
                        this.model = null;
                    }
                    if (this.scene) {
                        this.scene.traverse(o => {
                            if (o.isMesh && o.geometry) o.geometry.dispose();
                            const m = o.material;
                            if (m) {
                                if (Array.isArray(m)) m.forEach(mm => mm.dispose && mm.dispose()); else m.dispose && m.dispose();
                            }
                        });
                        this.scene = null;
                    }
                    this._cameraDirLight = null;
                    if (this.renderer?.domElement?.parentNode) {
                        this.renderer.domElement.parentNode.removeChild(this.renderer.domElement);
                    }
                    this.renderer?.dispose?.();
                    this.renderer = null;
                    this.camera = null;
                    this.reticle = null;
                    this._reticleState = null;
                    this.uiState = {inPlacementMode: false, hasPlaced: false, exploring: false};
                    if (window.jQuery) {
                        jQuery(this.cfg.ui.exploreBtn).prop('disabled', true).addClass('disabled');
                        jQuery(this.cfg.ui.newPosBtn).prop('disabled', true).addClass('disabled');
                    }
                    this.disableUI(false);
                    if (window.jQuery) {
                        jQuery(this.cfg.ui.hint).text(this.msg('estado.listo'));
                    }
                    this.setStatus(this.msg('estado.visor_reiniciado'));
                    this.removeViewUICam();
                } catch (err) {
                    this.logError('error.reset_total', {}, err);
                }
            }

            initViewUICam() {
                if (!window.jQuery) return;
                jQuery(".manager-buttons").removeClass("manager-buttons--view-control-cam").addClass("manager-buttons--view-control-cam");
                jQuery("#btn-reset,#btn-zoom-in,#btn-zoom-out,#btn-scale-1x,#btn-scale-2x,#btn-rot-left,#btn-rot-right,#btn-rot-up,#btn-rot-down,#btn-explore,#btn-new-pos").removeClass("not-view");
                jQuery(".controls").addClass("controls--ui-cam");
                jQuery("#map").addClass("not-view");
            }

            removeViewUICam() {
                if (!window.jQuery) return;
                jQuery(".manager-buttons").removeClass("manager-buttons--view-control-cam");
                jQuery("#btn-reset,#btn-zoom-in,#btn-zoom-out,#btn-scale-1x,#btn-scale-2x,#btn-rot-left,#btn-rot-right,#btn-rot-up,#btn-rot-down,#btn-explore,#btn-new-pos").addClass("not-view");
                jQuery("#map").removeClass("not-view");
                jQuery(".controls").removeClass("controls--ui-cam");
            }

            disableUI(disabled = true, opts = {}) {
                try {
                    if (!window.jQuery) return;
                    const behavior = this.cfg.uiBehavior || {};
                    const lockCursor = ('lockCursor' in behavior) ? behavior.lockCursor : true;
                    const include = (opts.include !== undefined) ? opts.include : behavior.include;
                    const exclude = (opts.exclude !== undefined) ? opts.exclude : (behavior.exclude || ['hint', 'fallback', 'modelViewer']);
                    let entries = Object.entries(this.cfg.ui || {});
                    entries = entries.filter(([key]) => {
                        if (include && Array.isArray(include)) return include.includes(key);
                        return !exclude.includes(key);
                    });
                    entries.forEach(([_, sel]) => {
                        if (!sel) return;
                        const $el = jQuery(sel);
                        if (!$el.length) return;
                        $el.prop('disabled', disabled).toggleClass('disabled', disabled).attr('aria-disabled', disabled ? 'true' : 'false').css('pointer-events', disabled ? 'none' : '');
                    });
                    if (lockCursor) document.body.style.cursor = disabled ? 'progress' : '';
                    const mvSel = this.cfg.ui?.modelViewer;
                    if (mvSel) {
                        const mv = document.querySelector(mvSel);
                        if (mv && !document.querySelector(this.cfg.ui.fallback)?.classList.contains('d-none')) {
                            mv.style.pointerEvents = disabled ? 'none' : '';
                            const arBtn = mv.querySelector('[slot="ar-button"]');
                            if (arBtn) {
                                arBtn.disabled = !!disabled;
                                arBtn.classList.toggle('disabled', !!disabled);
                                arBtn.setAttribute('aria-disabled', disabled ? 'true' : 'false');
                                arBtn.style.pointerEvents = disabled ? 'none' : '';
                            }
                        }
                    }
                } catch (err) {
                    this.logError('error.deshabilitar_ui', {}, err);
                }
            }

            _intersectControllerWithModel() {
                if (!this.model) return null;
                const ctrl = this.renderer?.xr?.getController(0);
                if (!ctrl) return null;
                const origin = new THREE.Vector3().setFromMatrixPosition(ctrl.matrixWorld);
                const dir = new THREE.Vector3(0, 0, -1).applyQuaternion(ctrl.quaternion).normalize();
                const rc = new THREE.Raycaster();
                rc.set(origin, dir);
                const hits = rc.intersectObject(this.model, true);
                return (hits && hits.length) ? hits[0] : null;
            }
        }

        /* ===== Exponer clase ===== */
        window.JQueryArViewer = JQueryArViewer;

        /* =======================
         * Bootstrap de la app
         * ======================= */
        let itemsSources = [
            {
                id: "taita",
                tex: "Taita Imbabura",
                sources: {glb: window.$dataManagerPage?.['public-root'] + '/simi-rura/muelle-catalina/taita-imbabura-toon-1.glb'}
            },
            {
                id: "coraza",
                tex: "El Coraza",
                sources: {glb: window.$dataManagerPage?.['public-root'] + '/simi-rura/muelle-catalina/coraza-one.glb'}
            },
            {
                id: "mama-cotacachi",
                tex: "Mama Cotacachi",
                sources: {glb: window.$dataManagerPage?.['public-root'] + '/simi-rura/muelle-catalina/mama-cotacachi.glb'}
            },
            {
                id: "lago-san-pablo",
                tex: "Lago San Pablo",
                sources: {glb: window.$dataManagerPage?.['public-root'] + '/simi-rura/muelle-catalina/lago-san-pablo.glb'}
            },
            {
                id: "cerro-cusin",
                tex: "Cerro Cusin",
                sources: {glb: window.$dataManagerPage?.['public-root'] + '/simi-rura/muelle-catalina/cusin.glb'}
            },
            {
                id: "taita-imbabura-one",
                tex: "Taita Imbabura 2",
                sources: {glb: window.$dataManagerPage?.['public-root'] + '/simi-rura/muelle-catalina/taita-imbabura-otro.glb'}
            },
            {
                id: "other",
                tex: "Other",
                sources: {glb: window.$dataManagerPage?.['public-root'] + '/simi-rura/muelle-catalina/other.glb'}
            }
        ];

        $(function () {

            const viewer = new JQueryArViewer({
                glbUrl: itemsSources[6].sources.glb,
                events: {
                    autorrotacion: {activa: true, velocidadRadSeg: 1.2, pausaAlInteractuar: true},
                    clicks: {habilitar: true, umbralXR_metros: 0.25},
                    gestures: {habilitar: true, rotacionFactor: 0.015, rotacionFactorX: 0.010, pinchFactor: 0.005},
                    onModelClick: ({modo, punto}) => {
                        const p = punto ? `${punto.x.toFixed(2)}, ${punto.y.toFixed(2)}, ${punto.z.toFixed(2)}` : '—';
                        viewer.setStatus(`Click sobre modelo (${modo}) en ${p}`);
                    },
                    onDragStart: () => viewer.setStatus('Arrastre iniciado'),
                    onDrag: ({dx, dy}) => viewer.setStatus(`Arrastrando dx=${dx} dy=${dy}`),
                    onDragEnd: () => viewer.setStatus('Arrastre finalizado'),
                    onScale: ({scale}) => viewer.setStatus(`Escala: ${scale.toFixed(2)}`),
                    onRotate: ({rotY, rotX}) => viewer.setStatus(`Rotación Y=${rotY.toFixed(2)} X=${rotX.toFixed(2)}`)
                },
                i18n: {textos: {etiquetas: {botonVer: 'Entrar'}}}
            });

            window.viewer = viewer; // útil para depurar en consola

            viewer.init();

            // Ajustes recomendados
            viewer.configureCamera({toneExposure: 1.4});
            viewer.configureSensitivity({
                stableFramesRequired: 3,
                offsetRayDown: 0.25,
                upDotMin: 0.78,
                minDistance: 0.15
            });
            viewer.configureReticle({color: 0x00e5ff});

            // Política: colocar solo si el tap cae en el anillo de la retícula
            viewer.placeOnlyWhenReticleHit = true;

            // Mostrar contenedor tras verificación rápida del modo
            (async function verifyMode() {
                const mode = await viewer.decideMode();
                console.log('mode:', mode);
                $(".container--custom").removeClass("not-view");
            })();
            initMap();
        });

        function initMap() {
            const map = L.map('map', {
                zoomControl: true
            }).setView([-1.8312, -78.1834], 6);

            // 2) Capa base OSM (gratuita). Mantén la atribución visible.
            const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution:
                    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contribuyentes'
            }).addTo(map);

            // 3) Marcador de ejemplo
            const marker = L.marker([-0.1807, -78.4678]).addTo(map)
                .bindPopup('<b>Quito</b><br>Marcador inicial.');

            // 4) Clic en el mapa para agregar marcador donde toques
            map.on('click', function (e) {
                const {lat, lng} = e.latlng;
                L.marker([lat, lng]).addTo(map)
                    .bindPopup(`Nuevo marcador:<br><code>${lat.toFixed(5)}, ${lng.toFixed(5)}</code>`)
                    .openPopup();
            });

            // 5) Controles simples con jQuery
            $('#btn-zoom-quito').on('click', function () {
                map.setView([-0.1807, -78.4678], 12);
            });
            $('#btn-zoom-otavalo').on('click', function () {
                map.setView([0.2346, -78.2664], 13);
            });
        }
    </script>
@endsection
@section('content')
    <div class="controls">
        <button id="btn-zoom-quito">Ir a Quito</button>
        <button id="btn-zoom-otavalo">Ir a Otavalo</button>
        <span style="margin-left:6px;color:#666">Haz clic en el mapa para agregar un marcador.</span>
        <!-- UI contenedora -->
        <div class="container--custom not-view">
            <!-- Overlay de carga -->
            <div id="ar-loading"
                 class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-75 d-flex justify-content-center align-items-center d-none"
                 style="z-index:9999;">
                <div class="spinner-border text-light" role="status" style="width: 4rem; height: 4rem;"></div>
            </div>

            <!-- Mensajes de estado -->
            <div id="hint" class="alert alert-dark py-2 px-3 small mb-2">Ready. Tap “Enter AR”.</div>

            <!-- Barra de controles -->
            <div class="d-flex flex-wrap gap-2 mb-3">
                <div class="manager-buttons">
                    <button id="btn-enter-ar" class="btn btn-primary btn-sm manager-buttons__item">Ver</button>

                    <button id="btn-reset" class="btn btn-outline-secondary btn-sm manager-buttons__item not-view">Reset
                    </button>
                    <button id="btn-zoom-in" class="btn btn-outline-success btn-sm manager-buttons__item not-view">Zoom
                        +
                    </button>
                    <button id="btn-zoom-out" class="btn btn-outline-success btn-sm manager-buttons__item not-view">Zoom
                        −
                    </button>
                    <button id="btn-scale-1x" class="btn btn-outline-info btn-sm manager-buttons__item not-view">Scale
                        1×
                    </button>
                    <button id="btn-scale-2x" class="btn btn-outline-info btn-sm manager-buttons__item not-view">Scale
                        2×
                    </button>
                    <div class="vr"></div>
                    <button id="btn-rot-left" class="btn btn-outline-warning btn-sm manager-buttons__item not-view">⟲
                        Left
                    </button>
                    <button id="btn-rot-right" class="btn btn-outline-warning btn-sm manager-buttons__item not-view">⟳
                        Right
                    </button>
                    <button id="btn-rot-up" class="btn btn-outline-warning btn-sm manager-buttons__item not-view">↑ Up
                    </button>
                    <button id="btn-rot-down" class="btn btn-outline-warning btn-sm manager-buttons__item not-view">↓
                        Down
                    </button>

                    <!-- NUEVOS -->
                    <button id="btn-explore" class="btn btn-success btn-sm manager-buttons__item not-view" disabled>
                        Explorar
                    </button>
                    <button id="btn-new-pos" class="btn btn-outline-primary btn-sm manager-buttons__item not-view"
                            disabled>
                        Posición nueva
                    </button>
                </div>
            </div>

            <!-- Fallback cuando no hay WebXR -->
            <div id="fallback" class="d-none">
                <model-viewer id="mv" src="" ios-src=""
                              ar ar-modes="scene-viewer quick-look webxr"
                              camera-controls environment-image="neutral"
                              style="width:100%;height:60vh;background:#000">
                    <button slot="ar-button"
                            class="btn btn-primary btn-sm position-absolute start-50 translate-middle-x bottom-0 mb-2">
                        Ver en AR
                    </button>
                </model-viewer>
            </div>
        </div>
    </div>
    <div id="map"></div>

@endsection
