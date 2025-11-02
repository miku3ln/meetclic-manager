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
     * AR Viewer con flujo: Explorar / Posición nueva
     * ============================================================ */

        /* =======================
         * Clase de eventos del modelo
         * ======================= */
        class GestorEventosModelo {
            /**
             * @param {JQueryArViewer} viewer
             * @param {object} opciones
             */
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
                    onModelClick: null,
                    onDragStart: null,
                    onDrag: null,
                    onDragEnd: null,
                    onScale: null,
                    onRotate: null
                };

                this.cfg = $.extend(true, {}, porDefecto, opciones);

                if (typeof this.cfg.onModelClick !== 'function') {
                    this.cfg.onModelClick = ({modo, punto}) => {
                        const p = punto ? `${punto.x.toFixed(3)}, ${punto.y.toFixed(3)}, ${punto.z.toFixed(3)}` : '—';
                        console.log('[AR][onModelClick][default]', modo, p);
                        try {
                            const ev = new CustomEvent('ar-model-click', {detail: {modo, punto}});
                            window.dispatchEvent(ev);
                        } catch {
                        }
                    };
                }

                // Estado interno
                this._raycaster = new THREE.Raycaster();
                this._ndc = new THREE.Vector2();
                this._escuchandoCanvas = false;
                this._escuchandoModelViewer = false;

                this._autorrotacionActiva = !!this.cfg.autorrotacion.activa;
                this._velocidadRadSeg = Number(this.cfg.autorrotacion.velocidadRadSeg || 0.8);
                this._boundingSphere = null;

                // Gestos
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

                if (this._autorrotacionActiva) {
                    this.viewer.setStatus(this.viewer.msg('eventos.autorrotacion_activada', {
                        vel: this._velocidadRadSeg.toFixed(2)
                    }));
                }
            }

            onFrame(deltaSeg) {
                if (!this._autorrotacionActiva) return;
                const m = this.viewer.model;
                if (!m) return;
                m.rotation.y += this._velocidadRadSeg * deltaSeg;
            }

            activarAutorrotacion() {
                this._autorrotacionActiva = true;
                this.viewer.setStatus(this.viewer.msg('eventos.autorrotacion_activada', {
                    vel: this._velocidadRadSeg.toFixed(2)
                }));
            }

            desactivarAutorrotacion() {
                this._autorrotacionActiva = false;
                this.viewer.setStatus(this.viewer.msg('eventos.autorrotacion_desactivada'));
            }

            toggleAutorrotacion() {
                if (this._autorrotacionActiva) this.desactivarAutorrotacion();
                else this.activarAutorrotacion();
            }

            setVelocidadAutorrotacion(radPorSeg) {
                const v = Number(radPorSeg);
                if (!isFinite(v) || v <= 0) return;
                this._velocidadRadSeg = v;
                if (this._autorrotacionActiva) {
                    this.viewer.setStatus(this.viewer.msg('eventos.autorrotacion_actualizada', {
                        vel: this._velocidadRadSeg.toFixed(2)
                    }));
                }
            }

            habilitarClicks() {
                this.cfg.clicks.habilitar = true;
                this.viewer.setStatus(this.viewer.msg('eventos.clicks_habilitados'));
            }

            deshabilitarClicks() {
                this.cfg.clicks.habilitar = false;
                this.viewer.setStatus(this.viewer.msg('eventos.clicks_deshabilitados'));
            }

            // NUEVO: helpers de gestos/interacciones para el flujo
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

            /* ===== Listeners de canvas y fallback ===== */
            _instalarOyentesCanvas() {
                const canvas = this.viewer?.renderer?.domElement;
                if (!canvas || this._escuchandoCanvas) return;

                const toNdc = (evt) => {
                    const rect = canvas.getBoundingClientRect();
                    const x = ((evt.clientX - rect.left) / rect.width) * 2 - 1;
                    const y = -((evt.clientY - rect.top) / rect.height) * 2 + 1;
                    this._ndc.set(x, y);
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
                            if (this.cfg.autorrotacion.pausaAlInteractuar && this._autorrotacionActiva) {
                                this.desactivarAutorrotacion();
                            }
                        }
                    }
                };

                const getIntersectionsModel = (evt) => {
                    toNdc(evt);
                    this._raycaster.setFromCamera(this._ndc, this.viewer.camera);
                    return this.viewer.model
                        ? this._raycaster.intersectObject(this.viewer.model, true)
                        : [];
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

                    // PINCH
                    if (this._pinch.activo && (evt.pointerId === this._pinch.id1 || evt.pointerId === this._pinch.id2)) {
                        if (this._pinch.id1 != null && this._pinch.id2 != null &&
                            this._activePointers.has(this._pinch.id1) && this._activePointers.has(this._pinch.id2)) {

                            const p1 = this._activePointers.get(this._pinch.id1);
                            const p2 = this._activePointers.get(this._pinch.id2);
                            const dx = p1.x - p2.x, dy = p1.y - p2.y;
                            const dist = Math.sqrt(dx * dx + dy * dy);

                            if (this._pinch.startDist === 0) {
                                this._pinch.startDist = dist || 1;
                            } else if (dist > 0 && this.viewer?.model) {
                                const delta = (dist - this._pinch.startDist) * (this.cfg.gestures.pinchFactor || 0.005);
                                const base = this._pinch.startScale || 1;
                                const next = THREE.MathUtils.clamp(
                                    base + delta,
                                    this.cfg.gestures.escalaMin,
                                    this.cfg.gestures.escalaMax
                                );
                                this.viewer.setUniformScale(next);
                                try {
                                    this.cfg.onScale && this.cfg.onScale({scale: next});
                                } catch {
                                }
                            }
                        }
                        return;
                    }

                    // DRAG ROTACIÓN
                    if (this._drag.activo && evt.pointerId === this._drag.pointerId && this.viewer?.model) {
                        const dx = evt.clientX - this._drag.lastX;
                        const dy = evt.clientY - this._drag.lastY;
                        this._drag.lastX = evt.clientX;
                        this._drag.lastY = evt.clientY;

                        const fy = this.cfg.gestures.rotacionFactor || 0.015;
                        const fx = this.cfg.gestures.rotacionFactorX || 0.010;
                        this.viewer.model.rotation.y += dx * fy;
                        this.viewer.model.rotation.x = THREE.MathUtils.clamp(
                            this.viewer.model.rotation.x - dy * fx,
                            -Math.PI / 2, Math.PI / 2
                        );

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

                // Click puntual (no-XR)
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
                const px = punto ? punto.x.toFixed(3) : '—';
                const py = punto ? punto.y.toFixed(3) : '—';
                const pz = punto ? punto.z.toFixed(3) : '—';
                this.viewer.setStatus(this.viewer.msg('eventos.click_modelo', {modo, x: px, y: py, z: pz}));
                try {
                    this.cfg.onModelClick({modo, punto});
                } catch {
                }
            }
        }

        /* =======================
         * Viewer principal
         * ======================= */
        class JQueryArViewer {
            constructor(options = {}) {
                const defaults = {
                    glbUrl: '',
                    usdzUrl: '',
                    ui: {
                        hint: '#hint',
                        fallback: '#fallback',
                        modelViewer: '#mv',
                        enterBtn: '#btn-enter-ar',
                        resetBtn: '#btn-reset',
                        zoomInBtn: '#btn-zoom-in',
                        zoomOutBtn: '#btn-zoom-out',
                        scale1xBtn: '#btn-scale-1x',
                        scale2xBtn: '#btn-scale-2x',
                        rotLeftBtn: '#btn-rot-left',
                        rotRightBtn: '#btn-rot-right',
                        rotUpBtn: '#btn-rot-up',
                        rotDownBtn: '#btn-rot-down',
                        // NUEVOS
                        exploreBtn: '#btn-explore',
                        newPosBtn: '#btn-new-pos'
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
                    camera: {
                        fov: 60,
                        near: 0.01,
                        far: 20,
                        toneMapping: THREE.ACESFilmicToneMapping,
                        toneExposure: 1.2
                    },
                    reticleSensitivity: {
                        smoothFactor: 0.35,
                        stableFramesRequired: 5,
                        minDistance: 0.25,
                        maxDistance: 4.0,
                        upDotMin: 0.85,
                        offsetRayDown: 0.15
                    },
                    lighting: {
                        useLightEstimation: true,
                        hemiSky: 0xffffff,
                        hemiGround: 0x404060,
                        hemiIntensity: 1.1,
                        dirColor: 0xffffff,
                        dirIntensity: 0.6
                    },
                    xr: {
                        requiredFeatures: ['hit-test', 'local'],
                        optionalFeatures: ['dom-overlay', 'unbounded', 'light-estimation'],
                        domOverlayRoot: () => document.body
                    },
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
                        locale: 'es',
                        textos: {
                            etiquetas: {botonVer: 'Entrar', verEnAr: 'Ver en AR'},
                            estado: {
                                listo: 'Listo. Toca “Entrar en AR”. (requiere HTTPS)',
                                ios_quicklook: 'iOS: pulsa “Ver en AR” para Quick Look.',
                                ios_sin_usdz: 'iOS: sin USDZ, se mostrará el visor 3D.',
                                visor_3d: 'Modo visor 3D. La Realidad Aumentada no está disponible en este dispositivo.',
                                iniciado: 'AR iniciada.',
                                sin_reticula: 'Sin retícula. Apunta hacia una superficie plana.',
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
                                // NUEVOS
                                colocar_primero: 'Apunta al suelo y toca la retícula para colocar el modelo.',
                                explorar_habilitado: 'Explorar habilitado.',
                                explorar_deshabilitado: 'Explorar deshabilitado.',
                                recolocar_listo: 'Posición nueva: toca la retícula para recolocar.',
                                toque_fuera_reticula: 'Toca exactamente sobre la retícula para colocar.',
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

                this.cfg = $.extend(true, {}, defaults, options);

                // Plataforma
                this.platform = JQueryArViewer.detectPlatform();

                // Estado Three/XR
                this.renderer = null;
                this.scene = null;
                this.camera = null;
                this.session = null;
                this.referenceSpace = null;
                this.viewerSpace = null;
                this.hitTestSource = null;
                this.hitReady = false;
                this.reticle = null;
                this.model = null;

                // Retícula
                this._reticleState = null;
                this._stableCount = 0;
                this._smoothFactor = this.cfg.reticleSensitivity.smoothFactor;
                this._stableFramesRequired = this.cfg.reticleSensitivity.stableFramesRequired;
                this.hitFilter = {
                    minDistance: this.cfg.reticleSensitivity.minDistance,
                    maxDistance: this.cfg.reticleSensitivity.maxDistance,
                    upDotMin: this.cfg.reticleSensitivity.upDotMin
                };

                // jQuery cache
                this.$win = $(window);
                this.$hint = $(this.cfg.ui.hint);

                // Gestor eventos
                this.eventos = new GestorEventosModelo(this, this.cfg.events);

                // Delta
                this._lastTs = null;

                // Política: colocar solo con tap en retícula
                this.placeOnlyWhenReticleHit = true;

                // Estado del flujo Explorar / Posición nueva
                this.uiState = {
                    inPlacementMode: false, // retícula activa
                    hasPlaced: false,       // ya se colocó
                    exploring: false        // gestos/clicks activos
                };
            }

            static detectPlatform() {
                const ua = navigator.userAgent || navigator.vendor || window.opera || '';
                const isAndroid = /Android/i.test(ua);
                const isIOS = /iPhone|iPad|iPod/i.test(ua) ||
                    (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
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
                    if (cur && Object.prototype.hasOwnProperty.call(cur, p)) cur = cur[p];
                    else return undefined;
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
                if (errorObj) console.error(prefix, this.msg(key, params), errorObj);
                else console.error(prefix, this.msg(key, params));
                this.setStatus(this.msg(key));
            }

            /* ============ API pública ============ */
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
                        $(this.cfg.ui.fallback).addClass('d-none');
                        $(this.cfg.ui.enterBtn).text(this.msg('etiquetas.botonVer'));
                    } else if (mode === 'ios-fallback') {
                        this.showFallback();
                        $(this.cfg.ui.enterBtn).off('click');
                        this.setStatus(this.cfg.usdzUrl ? this.msg('estado.ios_quicklook') : this.msg('estado.ios_sin_usdz'));
                        this._hideArControlsExcept(['hint', 'fallback', 'modelViewer']);
                    } else {
                        this.showFallback();
                        $(this.cfg.ui.enterBtn).off('click');
                        $(this.cfg.ui.enterBtn).addClass('disabled').attr('aria-disabled', 'true');
                        this.setStatus(this.msg('estado.visor_3d'));
                        this._hideArControlsExcept(['hint', 'fallback', 'modelViewer']);
                    }
                } catch (err) {
                    this.logError('error.modo', {}, err);
                    this.showFallback();
                    this._hideArControlsExcept(['hint', 'fallback', 'modelViewer']);
                }
            }

            _hideArControlsExcept(keysToKeep = []) {
                const entries = Object.entries(this.cfg.ui || {});
                entries.forEach(([key, sel]) => {
                    if (!sel) return;
                    if (keysToKeep.includes(key)) return;
                    const $el = $(sel);
                    if ($el.length) {
                        $el.addClass('d-none')
                            .prop('disabled', true)
                            .attr('aria-disabled', 'true')
                            .css('pointer-events', 'none');
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

            configureSensitivity(opts = {}) {
                Object.assign(this.cfg.reticleSensitivity, opts);
                this._smoothFactor = this.cfg.reticleSensitivity.smoothFactor;
                this._stableFramesRequired = this.cfg.reticleSensitivity.stableFramesRequired;
                this.hitFilter = {
                    minDistance: this.cfg.reticleSensitivity.minDistance,
                    maxDistance: this.cfg.reticleSensitivity.maxDistance,
                    upDotMin: this.cfg.reticleSensitivity.upDotMin
                };
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
                        requiredFeatures: this.cfg.xr.requiredFeatures,
                        optionalFeatures: this.cfg.xr.optionalFeatures,
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
                    if (this.session) this.session.end();
                    else this.resetEverything();
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

            setScale(value) {
                if (this.model) this.setUniformScale(value);
            }

            rotateY(deltaRadians) {
                if (!this.model) return;
                this.model.rotation.y += deltaRadians;
                this.setStatus(this.msg('estado.rotY', {valor: this.model.rotation.y.toFixed(2)}));
            }

            rotateX(deltaRadians) {
                if (!this.model) return;
                this.model.rotation.x = this.clamp(this.model.rotation.x + deltaRadians, -Math.PI / 2, Math.PI / 2);
                this.setStatus(this.msg('estado.rotX', {valor: this.model.rotation.x.toFixed(2)}));
            }

            /* ===== Three/XR internos ===== */
            initThreeIfNeeded() {
                if (this.renderer) return;

                this.renderer = new THREE.WebGLRenderer({antialias: true, alpha: true});
                this.renderer.xr.enabled = true;
                this.renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
                this.renderer.toneMapping = this.cfg.camera.toneMapping ?? THREE.ACESFilmicToneMapping;
                this.renderer.toneMappingExposure = Number(this.cfg.camera.toneExposure ?? 1.2);

                this.fitToWindow();
                document.body.appendChild(this.renderer.domElement);

                // Instalar oyentes ahora que existe canvas
                if (this.eventos && typeof this.eventos._instalarOyentesCanvas === 'function') {
                    this.eventos._instalarOyentesCanvas();
                }

                this.scene = new THREE.Scene();

                const aspect = Math.max(window.innerWidth, 1) / Math.max(window.innerHeight, 1);
                this.camera = new THREE.PerspectiveCamera(
                    Number(this.cfg.camera.fov ?? 60),
                    aspect,
                    Number(this.cfg.camera.near ?? 0.01),
                    Number(this.cfg.camera.far ?? 20)
                );

                this.addLights(this.scene);
                this.reticle = this.createReticle();
                this.scene.add(this.reticle);

                this.renderer.setAnimationLoop(this.onXrFrame.bind(this));
                this.$win.on('resize', this.fitToWindow.bind(this));
            }

            addLights(scene) {
                const hemi = new THREE.HemisphereLight(
                    this.cfg.lighting.hemiSky,
                    this.cfg.lighting.hemiGround,
                    this.cfg.lighting.hemiIntensity
                );
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
                    const dotGeo = new THREE.CircleGeometry(r.innerRadius * 0.3, 24);
                    dotGeo.rotateX(-Math.PI / 2);
                    const dotMat = new THREE.MeshBasicMaterial({color: r.color, transparent: true, opacity: 1.0});
                    const dot = new THREE.Mesh(dotGeo, dotMat);
                    dot.position.set(0, 0.001, 0);
                    ring.add(dot);
                    ring._dot = dot;
                }

                if (r.pulse) ring._pulse = {t: 0, min: r.pulseMin ?? 0.95, max: r.pulseMax ?? 1.05};
                return ring;
            }

            fitToWindow() {
                if (!this.renderer) return;
                const w = Math.max(window.innerWidth, 1);
                const h = Math.max(window.innerHeight, 1);
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

                // Hit test
                let hitSource = null;
                try {
                    let downRay = null;
                    try {
                        downRay = new XRRay({x: 0, y: 0, z: 0}, {
                            x: 0,
                            y: -this.cfg.reticleSensitivity.offsetRayDown,
                            z: -1
                        });
                    } catch {
                        downRay = null;
                    }
                    hitSource = downRay
                        ? await session.requestHitTestSource({space: this.viewerSpace, offsetRay: downRay})
                        : await session.requestHitTestSource({space: this.viewerSpace});
                } catch {
                    try {
                        hitSource = await session.requestHitTestSource({space: this.viewerSpace});
                    } catch {
                        hitSource = null;
                    }
                }
                this.hitTestSource = hitSource;
                this.hitReady = !!this.hitTestSource;

                // Light estimation opcional
                this._lightProbe = null;
                if (this.cfg.lighting.useLightEstimation && typeof session.requestLightProbe === 'function') {
                    try {
                        this._lightProbe = await session.requestLightProbe();
                    } catch {
                        this._lightProbe = null;
                    }
                }

                this.attachController();
                this.setStatus(this.msg('estado.iniciado'));
                this.initViewUICam();

                // Estado inicial del flujo
                this.uiState.inPlacementMode = true;   // retícula visible
                this.uiState.hasPlaced = false;
                this.uiState.exploring = false;
                $(this.cfg.ui.exploreBtn).prop('disabled', true).addClass('disabled');
                $(this.cfg.ui.newPosBtn).prop('disabled', true).addClass('disabled');
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

            _getControllerRay() {
                const controller = this.renderer?.xr?.getController(0);
                if (!controller) return null;
                const origin = new THREE.Vector3().setFromMatrixPosition(controller.matrixWorld);
                const dir = new THREE.Vector3(0, 0, -1).applyQuaternion(controller.quaternion).normalize();
                return {origin, dir};
            }

            _isRayOnReticle(ray) {
                if (!this.reticle) return false;

                const center = new THREE.Vector3();
                this.reticle.getWorldPosition(center);

                const normal = new THREE.Vector3(0, 1, 0)
                    .applyQuaternion(this.reticle.getWorldQuaternion(new THREE.Quaternion()))
                    .normalize();

                const plane = new THREE.Plane().setFromNormalAndCoplanarPoint(normal, center);
                const t = plane.distanceToPoint(ray.origin) / -plane.normal.dot(ray.dir);
                if (!isFinite(t) || t < 0) return false;

                const hitPoint = new THREE.Vector3().copy(ray.origin).addScaledVector(ray.dir, t);
                const dx = hitPoint.x - center.x;
                const dz = hitPoint.z - center.z;
                const r = Math.hypot(dx, dz);

                const R = (this.cfg.reticle?.outerRadius ?? 0.10) * (this.reticle.scale?.x ?? 1) * 1.05;
                return r <= R;
            }

            onXrSelect() {
                try {
                    // 1) Modo COLOCACIÓN: requiere retícula visible y tap sobre la retícula
                    if (this.uiState.inPlacementMode) {
                        const ret = this.reticle;
                        if (!ret || !ret.visible || !ret.matrixWorld) {
                            this.setStatus(this.msg('estado.sin_reticula'));
                            return;
                        }

                        if (this.placeOnlyWhenReticleHit) {
                            const ray = this._getControllerRay();
                            if (!ray || !this._isRayOnReticle(ray)) {
                                this.setStatus(this.msg('estado.toque_fuera_reticula'));
                                return;
                            }
                        }

                        this.placeOrMoveModelAtReticle();

                        // Notifica “click” de proximidad tras colocar
                        if (this.eventos && typeof this.eventos.onSelectXR === 'function') {
                            this.eventos.onSelectXR(this.reticle.matrixWorld);
                        }

                        this.uiState.hasPlaced = true;
                        this._enterLockedAfterPlacement(); // oculta retícula y habilita botones
                        return;
                    }

                    // 2) Modo EXPLORAR: no hay retícula; permitimos click sobre el modelo
                    if (this.uiState.exploring && this.eventos?.cfg?.clicks?.habilitar) {
                        const hit = this._intersectControllerWithModel();
                        if (hit) {
                            // dispara el callback de click sobre modelo en XR
                            this.eventos._emitirClickModelo('xr', hit.point || null);

                            // pausamos autorrotación si procede
                            if (this.eventos?.cfg?.autorrotacion?.pausaAlInteractuar && this.eventos._autorrotacionActiva) {
                                this.eventos.desactivarAutorrotacion();
                            }
                        } else {
                            // sin impacto en la malla
                            this.setStatus('Apunta al modelo para interactuar.');
                        }
                        return;
                    }

                    // 3) Fuera de colocación y sin explorar: no hace nada
                    this.setStatus('Pulsa “Posición nueva” o “Explorar”.');
                } catch (err) {
                    this.logError('error.frame', {}, err);
                }
            }

            _enterLockedAfterPlacement() {
                this.uiState.inPlacementMode = false; // oculta retícula por gating
                this.uiState.exploring = false;

                // UI: habilita Explorar y Posición nueva
                $(this.cfg.ui.exploreBtn).prop('disabled', false).removeClass('disabled');
                $(this.cfg.ui.newPosBtn).prop('disabled', false).removeClass('disabled');

                this.setStatus(this.msg('estado.colocado') + ' ' + this.msg('estado.explorar_habilitado'));
            }

            enterExploreMode() {
                this.eventos?.habilitarInteraccionesModelo?.();
                this.uiState.exploring = true;

                $(this.cfg.ui.exploreBtn).prop('disabled', true).addClass('disabled');
                $(this.cfg.ui.newPosBtn).prop('disabled', false).removeClass('disabled');

                this.setStatus('Explorar activo. Gestos y clicks habilitados.');
            }

            enterPlacementMode() {
                this.eventos?.deshabilitarInteraccionesModelo?.();
                this.uiState.exploring = false;

                this.uiState.inPlacementMode = true;
                $(this.cfg.ui.exploreBtn).prop('disabled', true).addClass('disabled');
                $(this.cfg.ui.newPosBtn).prop('disabled', true).addClass('disabled');

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
                    loader.load(
                        this.cfg.glbUrl,
                        (gltf) => {
                            this.model = gltf.scene;
                            this.hardenModel(this.model);
                            this.setUniformScale(this.cfg.model.initialScale);
                            this.applyMatrixToModel(this.model, mat);
                            this.scene.add(this.model);

                            this.eventos.aplicarAlModelo(this.model);

                            this.hideLoading();
                            if (this.cfg.uiBehavior?.disableDuring?.modelLoad) this.disableUI(false);
                            this.setStatus(this.msg('estado.colocado'));
                        },
                        (xhr) => {
                            const pct = Math.round((xhr.loaded / xhr.total) * 100);
                            if (isFinite(pct)) this.setStatus(this.msg('estado.progreso_carga', {porcentaje: pct}));
                        },
                        (err) => {
                            this.hideLoading();
                            if (this.cfg.uiBehavior?.disableDuring?.modelLoad) this.disableUI(false);
                            this.logError('error.cargar_glb', {}, err);
                        }
                    );
                } catch (err) {
                    this.logError('error.colocar_modelo', {}, err);
                    this.hideLoading();
                    if (this.cfg.uiBehavior?.disableDuring?.modelLoad) this.disableUI(false);
                }
            }

            onXrFrame(tsMs, frame) {
                let delta = 0.016;
                if (typeof tsMs === 'number') {
                    if (this._lastTs == null) this._lastTs = tsMs;
                    delta = Math.max(0, (tsMs - this._lastTs) / 1000);
                    this._lastTs = tsMs;
                }

                try {
                    const xrSession = this.renderer?.xr?.getSession?.();
                    if (xrSession && frame && this.hitReady && this.referenceSpace && this.hitTestSource) {
                        const hits = frame.getHitTestResults(this.hitTestSource);
                        let show = false;

                        if (hits.length) {
                            const pose = hits[0].getPose(this.referenceSpace);
                            if (pose) {
                                const m = new THREE.Matrix4().fromArray(pose.transform.matrix);
                                const pos = new THREE.Vector3();
                                const quat = new THREE.Quaternion();
                                const scl = new THREE.Vector3();
                                m.decompose(pos, quat, scl);

                                const up = new THREE.Vector3(0, 1, 0).applyQuaternion(quat);
                                const dot = up.dot(new THREE.Vector3(0, 1, 0));
                                const upOk = dot >= this.hitFilter.upDotMin;

                                const camPos = this.camera?.position ?? new THREE.Vector3(0, 0, 0);
                                const d = pos.distanceTo(camPos);
                                const distOk = d >= this.hitFilter.minDistance && d <= this.hitFilter.maxDistance;

                                if (upOk && distOk) {
                                    this._smoothReticleUpdate(m);
                                    show = this._reticleStabilityGate(true);
                                } else {
                                    show = this._reticleStabilityGate(false);
                                }
                            } else {
                                show = this._reticleStabilityGate(false);
                            }
                        } else {
                            show = this._reticleStabilityGate(false);
                        }

                        // Gating por estado: solo visible en modo colocación
                        this.reticle.visible = this.uiState.inPlacementMode && !!show;

                        if (this.reticle && this.reticle.visible && this.reticle._pulse) {
                            const p = this.reticle._pulse;
                            p.t += 0.02;
                            const s = p.min + (p.max - p.min) * (0.5 + 0.5 * Math.sin(p.t));
                            this.reticle.scale.set(s, 1, s);
                        }

                        if (this._cameraDirLight && this.camera) {
                            this._cameraDirLight.position.copy(this.camera.position);
                            const fwd = new THREE.Vector3(0, 0, -1).applyQuaternion(this.camera.quaternion);
                            if (!this._cameraDirLight.target?.parent) this.scene.add(this._cameraDirLight.target);
                            this._cameraDirLight.target.position.copy(this.camera.position.clone().add(fwd));
                        }

                        if (this._lightProbe && typeof frame.getLightEstimate === 'function') {
                            const est = frame.getLightEstimate(this._lightProbe);
                            if (est && this._cameraDirLight) {
                                const primary = est.primaryLightIntensity;
                                const base = Array.isArray(primary) ? primary[0] : (primary?.x ?? 1.0);
                                const intensity = THREE.MathUtils.clamp(base, 0.4, 2.0);
                                this._cameraDirLight.intensity = intensity * this.cfg.lighting.dirIntensity;
                            }
                        }
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

            hardenModel(root) {
                root.traverse(obj => {
                    if (!obj.isMesh) return;
                    obj.frustumCulled = false;
                    if (obj.material) {
                        if (Array.isArray(obj.material)) obj.material.forEach(m => m.side = THREE.DoubleSide);
                        else obj.material.side = THREE.DoubleSide;
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
                    if (Array.isArray(m)) m.forEach(mat => mat && mat.dispose && mat.dispose());
                    else m.dispose && m.dispose();
                });
            }

            bindUi() {
                $(this.cfg.ui.enterBtn).on('click', async () => {
                    console.log("CLICK this.cfg.ui.enterBtn");
                    const mode = await this.decideMode();
                    console.log("mode ", mode);

                    if (mode === 'android-webxr') {
                        return this.startAr();
                    }
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

                // NUEVO: flujo de los dos botones
                $(this.cfg.ui.exploreBtn).on('click', () => {
                    let hasPlaced = this.uiState.hasPlaced;
                    this.setStatus(this.msg('CLICK EXPLORAR :' + hasPlaced));
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
                $('#ar-loading').removeClass('d-none');
            }

            hideLoading() {
                $('#ar-loading').addClass('d-none');
            }

            _smoothReticleUpdate(targetMatrix) {
                if (!this._reticleState) {
                    const p = new THREE.Vector3(), q = new THREE.Quaternion(), sc = new THREE.Vector3();
                    targetMatrix.decompose(p, q, sc);
                    this._reticleState = {pos: p.clone(), quat: q.clone(), scl: sc.clone()};
                    this.reticle.matrix.compose(this._reticleState.pos, this._reticleState.quat, this._reticleState.scl);
                    this.reticle.matrixAutoUpdate = false;
                    this.reticle.updateMatrixWorld(true);
                    return;
                }

                const tPos = new THREE.Vector3();
                const tQuat = new THREE.Quaternion();
                const tScl = new THREE.Vector3();
                targetMatrix.decompose(tPos, tQuat, tScl);

                const s = this._smoothFactor ?? 0.35;

                this._reticleState.pos.lerp(tPos, s);
                this._reticleState.scl.lerp(tScl, s);
                if (typeof this._reticleState.quat.slerpQuaternions === 'function') {
                    this._reticleState.quat.slerpQuaternions(this._reticleState.quat, tQuat, s);
                } else {
                    this._reticleState.quat.slerp(tQuat, s);
                }

                this.reticle.matrix.compose(this._reticleState.pos, this._reticleState.quat, this._reticleState.scl);
                this.reticle.matrixAutoUpdate = false;
                this.reticle.updateMatrixWorld(true);
            }

            _reticleStabilityGate(validHit) {
                const N = this._stableFramesRequired ?? 5;
                this._stableCount = validHit ? (this._stableCount || 0) + 1 : 0;
                return this._stableCount >= N;
            }

            showFallback() {
                try {
                    $(this.cfg.ui.fallback).removeClass('d-none');

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
                this.hitReady = false;
                this.hitTestSource = null;
                this.session = null;
                this.disableUI(false);
                $(this.cfg.ui.hint).text(this.msg('estado.listo'));
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
                                if (Array.isArray(m)) m.forEach(mat => mat.dispose && mat.dispose());
                                else m.dispose && m.dispose();
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
                    this.hitTestSource = null;
                    this.referenceSpace = null;
                    this.viewerSpace = null;
                    this.reticle = null;
                    this.hitReady = false;
                    this._reticleState = null;

                    // Reinicio del flujo de UI
                    this.uiState = {inPlacementMode: false, hasPlaced: false, exploring: false};
                    $(this.cfg.ui.exploreBtn).prop('disabled', true).addClass('disabled');
                    $(this.cfg.ui.newPosBtn).prop('disabled', true).addClass('disabled');

                    this.disableUI(false);
                    $(this.cfg.ui.hint).text(this.msg('estado.listo'));
                    this.setStatus(this.msg('estado.visor_reiniciado'));
                    this.removeViewUICam();
                } catch (err) {
                    this.logError('error.reset_total', {}, err);
                }
            }

            _animateScaleTo(target, ms = 200) {
                if (!this.model) return;
                const start = this.model.scale.x;
                const end = this.clamp(target, this.cfg.model.minScale, this.cfg.model.maxScale);
                const t0 = performance.now();
                const tick = (t) => {
                    const k = Math.min(1, (t - t0) / ms);
                    const s = start + (end - start) * k;
                    this.model.scale.set(s, s, s);
                    if (k < 1) requestAnimationFrame(tick);
                    else this.setStatus(this.msg('estado.escala', {valor: end.toFixed(2)}));
                };
                requestAnimationFrame(tick);
            }

            initViewUICam() {
                $(".manager-buttons").removeClass("manager-buttons--view-control-cam");
                $(".manager-buttons").addClass("manager-buttons--view-control-cam");
                $("#btn-reset,#btn-zoom-in,#btn-zoom-out,#btn-scale-1x,#btn-scale-2x,#btn-rot-left,#btn-rot-right,#btn-rot-up,#btn-rot-down,#btn-explore,#btn-new-pos").removeClass("not-view");

                $(".controls").addClass("controls--ui-cam");
                $("#map").addClass("not-view");

            }

            removeViewUICam() {
                $(".manager-buttons").removeClass("manager-buttons--view-control-cam");
                $("#btn-reset,#btn-zoom-in,#btn-zoom-out,#btn-scale-1x,#btn-scale-2x,#btn-rot-left,#btn-rot-right,#btn-rot-up,#btn-rot-down,#btn-explore,#btn-new-pos").addClass("not-view");
                $("#map").removeClass("not-view");

                $(".controls").removeClass("controls--ui-cam");


            }

            disableUI(disabled = true, opts = {}) {
                try {
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
                        const $el = $(sel);
                        if (!$el.length) return;

                        $el
                            .prop('disabled', disabled)
                            .toggleClass('disabled', disabled)
                            .attr('aria-disabled', disabled ? 'true' : 'false')
                            .css('pointer-events', disabled ? 'none' : '');
                    });

                    if (lockCursor) $('body').css('cursor', disabled ? 'progress' : '');

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

        // Exponer para extensiones si es necesario
        window.JQueryArViewer = JQueryArViewer;

        /* =======================
         * Bootstrap de la app
         * ======================= */
        let itemsSources = [{
            id: "taita",
            title: "Taita Imbabura – El Abuelo que todo lo ve",
            subtitle: "Ñawi Hatun Yaya",
            description: "Sabio y protector, es el guardián del viento y de los ciclos de la tierra. Desde su cima, observa en silencio el camino que estás por recorrer.",
            position: {},
            sources: {
                glb: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/taita-imbabura-toon-1.glb',
                img: ""
            }
        },
            {
                id: "cerro-cusin",
                title: "Cusin – El guardián del paso fértil",
                subtitle: "Allpa ñampi rikchar",
                description: "Alegre y trabajador, Cusin camina con paso firme cuidando las chacras y senderos que alimentan la vida.",
                position: {},
                sources: {
                    glb: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/cusin.glb',
                    img: ""
                }
            },
            {
                id: "mojanda",
                title: "Mojanda – El susurro del páramo",
                subtitle: "Sachayaku mama",
                description: "Entre neblinas y lagunas, Mojanda teje los hilos del agua fría que purifica y renueva. Su silencio es fuerza.",
                position: {},
                sources: {
                    glb: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/taita-imbabura-otro.glb',
                    img: ""
                }
            },
            {
                id: "mama-cotacachi",
                title: "Mama Cotacachi – Madre de la Pachamama",
                subtitle: "Allpa mama- Warmi Rasu",
                description: "Dulce y poderosa, Mama Cotacachi cuida los ciclos de la vida. Su calma abraza a quien camina con respeto.",
                position: {},
                sources: {
                    glb: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/mama-cotacachi.glb',
                    img: ""
                }
            },
            {
                id: "coraza",
                title: "El Coraza – Espíritu de la celebración",
                subtitle: "Kawsay Taki",
                description: "Representa el orgullo y la dignidad de su pueblo. Su danza no es solo alegría, es memoria viva de lucha y honor.",
                position: {},
                sources: {
                    glb: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/coraza-one.glb',
                    img: ""
                }
            },
            {
                id: "lechero",
                title: "El Lechero – Árbol del Encuentro y los Deseos",
                subtitle: "Kawsay ranti",
                description: "Testigo de promesas, abrazos y despedidas. Desde sus ramas, el mundo parece un sueño.",
                position: {},
                sources: {
                    glb: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/other.glb',
                    img: ""
                }
            },
            {
                id: "lago-san-pablo",
                title: "Yaku Mama – La Laguna Viva",
                subtitle: "Yaku Mama – Kawsaycocha",
                description: "Aquí termina el camino, pero comienza la conexión. Sus aguas te abrazan con calma, reflejando tu propia esencia.",
                position: {},
                sources: {
                    glb: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/lago-san-pablo.glb',
                    img: ""
                }
            },



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
        let markersAllInit = [];
        let markersAll = [];

        function initMap() {
            let configMap = {
                zoom: 14,
                position: [0.20830, -78.22798]
            };
            const map = L.map('map', {
                zoomControl: true
            }).setView(configMap.position, configMap.zoom);

            // 2) Capa base OSM (gratuita). Mantén la atribución visible.
            const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: configMap.zoom,
                attribution:
                    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contribuyentes'
            }).addTo(map);

            map.on('click', function (e) {
                const {lat, lng} = e.latlng;
                let positionCurrent = [{lat: lat, lng: lng}];
                L.marker([lat, lng]).addTo(map)
                    .bindPopup(`Nuevo marcador:<br><code>${lat.toFixed(5)}, ${lng.toFixed(5)}</code>`)
                    .openPopup();

                markersAllInit.push(positionCurrent)
            });
            map.on('zoomstart', (e) => {
                console.log('[zoomstart] zoom actual:', map.getZoom());
            });

            // Opcional: se dispara muchas veces durante la animación
            map.on('zoom', (e) => {
                // Si quieres saber si vino de rueda/gesto, algunos navegadores incluyen e.originalEvent
                // console.log('[zoom] paso intermedio. originalEvent?', !!e.originalEvent);
            });

            map.on('zoomend', (e) => {
                const z = map.getZoom();
                const center = map.getCenter();
                const bounds = map.getBounds();
                console.log('[zoomend] nuevo zoom:', z, 'center:', center, 'bounds:', bounds);
                $('#zoom-info').text(`Zoom: ${z}`);
            });

        }
    </script>
@endsection
@section('content')
    <div class="controls">

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
