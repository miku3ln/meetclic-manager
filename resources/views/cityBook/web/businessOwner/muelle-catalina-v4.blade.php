@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
    $sourcesRoot = $resourcePathServer . 'frontend/businessOwner/mikuy-yachak';

@endphp
@extends('layouts.bootstrap5')
@section('additional-styles')
    <style>
        .not-view {
            display: none;
        }
    </style>

@endsection

@section('additional-scripts')

    <script src="https://unpkg.com/three@0.147.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.147.0/examples/js/controls/OrbitControls.js"></script>
    <script src="https://unpkg.com/three@0.147.0/examples/js/loaders/GLTFLoader.js"></script>
    <!-- Fallback: model-viewer (para iOS/Safari o navegadores sin WebXR) -->
    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
    <script>
        window.$dataManagerPage = window.$dataManagerPage || { 'public-root': '.' };

        class JQueryArViewer {
            /** Build with options. Only glbUrl is required. */
            constructor(options = {}) {
                const defaults = {
                    // Activos
                    glbUrl: '',               // REQUERIDO: URL del GLB
                    usdzUrl: '',              // Opcional (iOS Quick Look)

                    // Selectores UI
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
                        rotDownBtn: '#btn-rot-down'
                    },

                    // Retícula
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

                    // Transformaciones del modelo
                    model: {
                        initialScale: 1.0,
                        minScale: 0.2,
                        maxScale: 10.0,
                        zoomFactor: 1.10,
                        rotationStepY: 0.15, // radianes izquierda/derecha
                        rotationStepX: 0.10  // radianes arriba/abajo (pitch)
                    },

                    // Cámara y tono
                    camera: {
                        fov: 60,
                        near: 0.01,
                        far: 20,
                        toneMapping: THREE.ACESFilmicToneMapping,
                        toneExposure: 1.2
                    },

                    // Sensibilidad de retícula
                    reticleSensitivity: {
                        smoothFactor: 0.35,      // 0..1
                        stableFramesRequired: 5, // frames consecutivos válidos para mostrar
                        minDistance: 0.25,       // m
                        maxDistance: 4.0,        // m
                        upDotMin: 0.85,          // cos(θ) ~31°
                        offsetRayDown: 0.15      // inclinación del rayo hacia el piso
                    },

                    // Luces
                    lighting: {
                        useLightEstimation: true, // requiere optionalFeature 'light-estimation'
                        hemiSky: 0xffffff,
                        hemiGround: 0x404060,
                        hemiIntensity: 1.1,
                        dirColor: 0xffffff,
                        dirIntensity: 0.6
                    },

                    // XR features
                    xr: {
                        requiredFeatures: ['hit-test', 'local'],
                        optionalFeatures: ['dom-overlay', 'unbounded', 'light-estimation'],
                        domOverlayRoot: () => document.body
                    },

                    // Comportamiento UI
                    uiBehavior: {
                        disableDuring: {
                            sessionStart: true,  // deshabilita UI al abrir cámara (requestSession)
                            modelLoad: true      // deshabilita UI mientras se carga el GLB
                        },
                        lockCursor: true,
                        include: null,
                        exclude: ['hint', 'fallback', 'modelViewer']
                    },

                    // Catálogo i18n centralizado (ES por defecto)
                    i18n: {
                        locale: 'es',
                        textos: {
                            etiquetas: {
                                botonVer: 'Entrar',
                                verEnAr: 'Ver en AR'
                            },
                            estado: {
                                listo: 'Listo. Toca “Entrar en AR”. (requiere HTTPS)',
                                ios_quicklook: 'iOS: pulsa “Ver en AR” para Quick Look.',
                                ios_sin_usdz: 'iOS: sin USDZ, se mostrará el visor 3D.',
                                visor_3d: 'Modo visor 3D. La Realidad Aumentada no está disponible en este dispositivo.',
                                iniciado: 'AR iniciada. Apunta al suelo y toca para colocar o mover el modelo.',
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
                                visor_3d_activo: 'Visor 3D activo. La Realidad Aumentada no está disponible en este dispositivo.'
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
                            consola: {
                                prefijo: '[AR]'
                            }
                        }
                    }
                };

                this.cfg = $.extend(true, {}, defaults, options);

                // Política: solo botón “Entrar” inicia la cámara
                this._requireButtonToStart = true;

                // Plataforma
                this.platform = JQueryArViewer.detectPlatform();

                // Estado
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

                // Estados de suavizado/estabilidad
                this._reticleState = null;
                this._stableCount = 0;
                this._smoothFactor = this.cfg.reticleSensitivity.smoothFactor;
                this._stableFramesRequired = this.cfg.reticleSensitivity.stableFramesRequired;
                this.hitFilter = {
                    minDistance: this.cfg.reticleSensitivity.minDistance,
                    maxDistance: this.cfg.reticleSensitivity.maxDistance,
                    upDotMin: this.cfg.reticleSensitivity.upDotMin
                };

                // jQuery cacheado
                this.$win = $(window);
                this.$hint = $(this.cfg.ui.hint);
            }

            /* ==============================
             * Utilidades i18n y formato
             * ============================== */
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

            _fmt(template, params = {}) {
                if (typeof template !== 'string') return template;
                return template.replace(/\{(\w+)\}/g, (_, k) => {
                    const v = params[k];
                    return v === undefined || v === null ? '' : String(v);
                });
            }

            msg(key, params = {}) {
                const base = this.cfg.i18n?.textos || {};
                const val = this._get(base, key);
                return this._fmt(val || key, params);
            }

            logInfo(key, params = {}) {
                const prefix = this.msg('consola.prefijo');
                console.log(prefix, this.msg(key, params));
            }

            logError(key, params = {}, errorObj = null) {
                const prefix = this.msg('consola.prefijo');
                if (errorObj) console.error(prefix, this.msg(key, params), errorObj);
                else console.error(prefix, this.msg(key, params));
            }

            /* ==============================
             * Plataforma / Modo
             * ============================== */
            static detectPlatform() {
                const ua = navigator.userAgent || navigator.vendor || window.opera || '';
                const isAndroid = /Android/i.test(ua);
                const isIOS =
                    /iPhone|iPad|iPod/i.test(ua) ||
                    (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
                return { isAndroid, isIOS };
            }

            /** Decide el modo efectivo según plataforma y capacidades. */
            async decideMode() {
                const { isAndroid, isIOS } = this.platform;
                if (isIOS) return 'ios-fallback';
                if (isAndroid) {
                    const supported = await this.isImmersiveArAvailable();
                    return supported ? 'android-webxr' : 'fallback';
                }
                return 'fallback';
            }

            /* ==============================
             * API Pública
             * ============================== */

            /** Inicializa: enlaza UI y estado inicial. */
            init() {
                try {
                    this.bindUi();
                    this.setStatus(this.msg('estado.listo'));

                    // Sin autostart: solo botón “Entrar” puede iniciar cámara
                    if (!this._requireButtonToStart) {
                        this._startOnFirstTap = async () => {
                            if (this._starting || this.session) return;
                            await this.startAr();
                            window.removeEventListener('pointerdown', this._startOnFirstTap, true);
                            this._startOnFirstTap = null;
                        };
                        window.addEventListener('pointerdown', this._startOnFirstTap, true);
                    }

                    // Decide modo
                    this._initByMode();
                } catch (err) {
                    this.handleError(err, 'error.init');
                }
            }

            async _initByMode() {
                try {
                    const mode = await this.decideMode(); // 'android-webxr' | 'ios-fallback' | 'fallback'

                    if (mode === 'android-webxr') {
                        $(this.cfg.ui.fallback).addClass('d-none');
                        $(this.cfg.ui.enterBtn).text(this.msg('etiquetas.botonVer'));
                        // El usuario deberá pulsar “Entrar” para abrir la cámara
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
                    this.handleError(err, 'error.modo');
                    this.showFallback();
                    this._hideArControlsExcept(['hint', 'fallback', 'modelViewer']);
                }
            }

            /** Oculta o deshabilita botones AR dejando solo los permitidos. */
            _hideArControlsExcept(keysToKeep = []) {
                const entries = Object.entries(this.cfg.ui || {});
                entries.forEach(([key, sel]) => {
                    if (!sel) return;
                    if (keysToKeep.includes(key)) return;
                    const $el = $(sel);
                    if ($el.length) {
                        $el
                            .addClass('d-none')
                            .prop('disabled', true)
                            .attr('aria-disabled', 'true')
                            .css('pointer-events', 'none');
                    }
                });
            }

            // Configuración en caliente
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
                if (this.reticle?.material?.color) {
                    this.reticle.material.color.setHex(this.cfg.reticle.color);
                }
            }

            /** Inicia la sesión AR o muestra fallback. */
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
                        domOverlay: { root: this.cfg.xr.domOverlayRoot() }
                    });

                    await this.onSessionStarted(this.session);

                    if (this.cfg.uiBehavior?.disableDuring?.sessionStart) this.disableUI(false);
                } catch (err) {
                    this.handleError(err, 'error.iniciar_ar');
                    this.resetEverything();
                    this.showFallback();
                } finally {
                    this._starting = false;
                }
            }

            exitAr() {
                try {
                    if (this.session) {
                        this.session.end();
                    } else {
                        this.resetEverything();
                    }
                } catch {
                    this.resetEverything();
                }
            }

            /** Reinicia y elimina el modelo de la escena. */
            reset() {
                try {
                    if (!this.model) return this.setStatus(this.msg('estado.no_modelo_reiniciar'));
                    this.scene.remove(this.model);
                    this.disposeObject(this.model);
                    this.model = null;
                    this.setStatus(this.msg('estado.reiniciado'));
                } catch (err) {
                    this.handleError(err, 'error.reset_total');
                }
            }

            /** Acercar. */
            zoomIn() {
                try {
                    if (!this.model) return;
                    this.setUniformScale(this.model.scale.x * this.cfg.model.zoomFactor);
                } catch (err) { this.handleError(err, 'error.reset_total'); }
            }

            /** Alejar. */
            zoomOut() {
                try {
                    if (!this.model) return;
                    this.setUniformScale(this.model.scale.x / this.cfg.model.zoomFactor);
                } catch (err) { this.handleError(err, 'error.reset_total'); }
            }

            /** Establece escala exacta. */
            setScale(value) {
                try {
                    if (!this.model) return;
                    this.setUniformScale(value);
                } catch (err) { this.handleError(err, 'error.reset_total'); }
            }

            /** Rotación Y. Positivo = derecha, negativo = izquierda. */
            rotateY(deltaRadians) {
                try {
                    if (!this.model) return;
                    this.model.rotation.y += deltaRadians;
                    this.setStatus(this.msg('estado.rotY', { valor: this.model.rotation.y.toFixed(2) }));
                } catch (err) { this.handleError(err, 'error.reset_total'); }
            }

            /** Rotación X. Positivo = arriba, negativo = abajo. */
            rotateX(deltaRadians) {
                try {
                    if (!this.model) return;
                    this.model.rotation.x = this.clamp(this.model.rotation.x + deltaRadians, -Math.PI / 2, Math.PI / 2);
                    this.setStatus(this.msg('estado.rotX', { valor: this.model.rotation.x.toFixed(2) }));
                } catch (err) { this.handleError(err, 'error.reset_total'); }
            }

            /* ==============================
             * Internos — Three.js / XR
             * ============================== */

            /** Init three.js scene and reticle once (idempotent). */
            initThreeIfNeeded() {
                if (this.renderer) return;

                this.renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
                this.renderer.xr.enabled = true;
                this.renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
                this.renderer.toneMapping = this.cfg.camera.toneMapping ?? THREE.ACESFilmicToneMapping;
                this.renderer.toneMappingExposure = Number(this.cfg.camera.toneExposure ?? 1.2);

                this.fitToWindow();
                document.body.appendChild(this.renderer.domElement);

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

            /** Luz hemisférica + direccional tipo linterna. */
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

            /** Retícula anular visible en baja luz. */
            createReticle() {
                const r = this.cfg.reticle;

                const g = new THREE.RingGeometry(r.innerRadius, r.outerRadius, r.segments);
                g.rotateX(-Math.PI / 2);
                const mat = new THREE.MeshBasicMaterial({ color: r.color, transparent: true, opacity: 0.96 });
                const ring = new THREE.Mesh(g, mat);
                ring.matrixAutoUpdate = false;
                ring.visible = false;

                if (r.innerDot) {
                    const dotGeo = new THREE.CircleGeometry(r.innerRadius * 0.3, 24);
                    dotGeo.rotateX(-Math.PI / 2);
                    const dotMat = new THREE.MeshBasicMaterial({ color: r.color, transparent: true, opacity: 1.0 });
                    const dot = new THREE.Mesh(dotGeo, dotMat);
                    dot.position.set(0, 0.001, 0);
                    ring.add(dot);
                    ring._dot = dot;
                }

                if (r.pulse) {
                    ring._pulse = { t: 0, min: r.pulseMin ?? 0.95, max: r.pulseMax ?? 1.05 };
                }

                return ring;
            }

            /** Resize renderer a pantalla completa. */
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

            /** Verifica soporte immersive-ar. */
            async isImmersiveArAvailable() {
                const secure = location.protocol === 'https:' || location.hostname === 'localhost';
                if (!secure || !navigator.xr) return false;
                try { return await navigator.xr.isSessionSupported('immersive-ar'); }
                catch { return false; }
            }

            /** Configura sesión: espacios, hit-test, controlador. */
            async onSessionStarted(session) {
                this.renderer.xr.setReferenceSpaceType('local');
                await this.renderer.xr.setSession(session);

                session.addEventListener('end', this.onSessionEnded.bind(this));
                this.referenceSpace = await session.requestReferenceSpace('local');
                this.viewerSpace = await session.requestReferenceSpace('viewer');

                // Hit-test con offsetRay si es posible
                let hitSource = null;
                try {
                    let downRay = null;
                    try {
                        downRay = new XRRay(
                            { x: 0, y: 0, z: 0 },
                            { x: 0, y: -this.cfg.reticleSensitivity.offsetRayDown, z: -1 }
                        );
                    } catch { downRay = null; }

                    if (downRay) {
                        hitSource = await session.requestHitTestSource({
                            space: this.viewerSpace,
                            offsetRay: downRay
                        });
                    } else {
                        hitSource = await session.requestHitTestSource({ space: this.viewerSpace });
                    }
                } catch {
                    try { hitSource = await session.requestHitTestSource({ space: this.viewerSpace }); }
                    catch { hitSource = null; }
                }
                this.hitTestSource = hitSource;
                this.hitReady = !!this.hitTestSource;

                // Light estimation opcional
                this._lightProbe = null;
                if (this.cfg.lighting.useLightEstimation && typeof session.requestLightProbe === 'function') {
                    try { this._lightProbe = await session.requestLightProbe(); } catch { this._lightProbe = null; }
                }

                this.attachController();
                this.setStatus(this.msg('estado.iniciado'));
            }

            /** Limpia estado XR al finalizar sesión. */
            onSessionEnded() {
                this.setStatus(this.msg('estado.sesion_finalizada'));
                this.resetEverything();
                this.disableUI(false);
            }

            /** Escucha “select” del controlador XR. */
            attachController() {
                const controller = this.renderer.xr.getController(0);
                controller.addEventListener('select', this.onXrSelect.bind(this));
                this.scene.add(controller);
            }

            /** Tap: coloca o mueve modelo en la pose de la retícula. */
            onXrSelect() {
                if (!this.reticle.visible) return this.setStatus(this.msg('estado.sin_reticula'));
                this.placeOrMoveModelAtReticle();
            }

            /** Crea o mueve el modelo sobre la pose de retícula. */
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

                            this.hideLoading();
                            if (this.cfg.uiBehavior?.disableDuring?.modelLoad) this.disableUI(false);
                            this.setStatus(this.msg('estado.colocado'));
                        },
                        (xhr) => {
                            const pct = Math.round((xhr.loaded / xhr.total) * 100);
                            if (isFinite(pct)) this.setStatus(this.msg('estado.progreso_carga', { porcentaje: pct }));
                        },
                        (err) => {
                            this.hideLoading();
                            if (this.cfg.uiBehavior?.disableDuring?.modelLoad) this.disableUI(false);
                            this.handleError(err, 'error.cargar_glb');
                        }
                    );
                } catch (err) {
                    this.handleError(err, 'error.colocar_modelo');
                    this.hideLoading();
                    if (this.cfg.uiBehavior?.disableDuring?.modelLoad) this.disableUI(false);
                }
            }

            /** XR Frame: actualiza retícula desde hit-test y renderiza. */
            onXrFrame(_t, frame) {
                try {
                    const xrSession = this.renderer?.xr?.getSession?.();
                    if (xrSession && frame && this.hitReady && this.referenceSpace && this.hitTestSource) {
                        const hits = frame.getHitTestResults(this.hitTestSource);

                        let show = false;
                        if (hits.length) {
                            const pose = hits[0].getPose(this.referenceSpace);
                            if (pose) {
                                const m = new THREE.Matrix4().fromArray(pose.transform.matrix);

                                // Descomponer para filtros
                                const pos = new THREE.Vector3();
                                const quat = new THREE.Quaternion();
                                const scl = new THREE.Vector3();
                                m.decompose(pos, quat, scl);

                                // Filtro por orientación “hacia arriba”
                                const up = new THREE.Vector3(0, 1, 0).applyQuaternion(quat);
                                const dot = up.dot(new THREE.Vector3(0, 1, 0)); // 1 = horizontal arriba
                                const upOk = dot >= this.hitFilter.upDotMin;

                                // Filtro por distancia a cámara
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

                        this.reticle.visible = !!show;

                        // Pulso de retícula
                        if (this.reticle && this.reticle.visible && this.reticle._pulse) {
                            const p = this.reticle._pulse;
                            p.t += 0.02;
                            const s = p.min + (p.max - p.min) * (0.5 + 0.5 * Math.sin(p.t));
                            this.reticle.scale.set(s, 1, s);
                        }

                        // Luz direccional ligada a cámara
                        if (this._cameraDirLight && this.camera) {
                            this._cameraDirLight.position.copy(this.camera.position);
                            const fwd = new THREE.Vector3(0, 0, -1).applyQuaternion(this.camera.quaternion);
                            if (!this._cameraDirLight.target?.parent) {
                                this.scene.add(this._cameraDirLight.target);
                            }
                            this._cameraDirLight.target.position.copy(this.camera.position.clone().add(fwd));
                        }

                        // Light estimation si está disponible
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
                    // Evita que una excepción por frame congele todo el bucle
                    this.handleError(frameErr, 'error.frame');
                }

                if (this.renderer && this.camera) {
                    this.renderer.render(this.scene, this.camera);
                }
            }

            /* ==============================
             * Internos — Operaciones Modelo
             * ============================== */

            /** Materiales robustos para móvil. */
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

            /** Aplica matrix XR al transform del modelo. */
            applyMatrixToModel(model, mat4) {
                model.position.setFromMatrixPosition(mat4);
                model.quaternion.setFromRotationMatrix(mat4);
            }

            /** Escalado uniforme con límites. */
            setUniformScale(value) {
                const s = this.clamp(value, this.cfg.model.minScale, this.cfg.model.maxScale);
                this.model.scale.set(s, s, s);
                this.setStatus(this.msg('estado.escala', { valor: s.toFixed(2) }));
            }

            /** Libera geometrías/materiales. */
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

            /* ==============================
             * Internos — UI y helpers
             * ============================== */

            /** Enlaza botones a acciones (defensivo). */
            bindUi() {
                // Botón principal “Entrar”
                $(this.cfg.ui.enterBtn).on('click', async () => {
                    if (!this._requireButtonToStart) return;
                    const mode = await this.decideMode();

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
                            } catch {}
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
            }

            /** Estado + consola */
            setStatus(msg) {
                const prefix = this.msg('consola.prefijo');
                console.log(prefix, msg);
                this.$hint && this.$hint.text(msg);
            }

            /** Manejador centralizado de errores. */
            handleError(error, key = 'error.colocar_modelo') {
                this.logError(key, {}, error);
                this.setStatus(this.msg(key));
            }

            /** Math clamp helper. */
            clamp(v, min, max) {
                return Math.min(max, Math.max(min, v));
            }

            showLoading() { $('#ar-loading').removeClass('d-none'); }
            hideLoading() { $('#ar-loading').addClass('d-none'); }

            // Suavizado y estabilidad
            _smoothReticleUpdate(targetMatrix) {
                if (!this._reticleState) {
                    const p = new THREE.Vector3(), q = new THREE.Quaternion(), sc = new THREE.Vector3();
                    targetMatrix.decompose(p, q, sc);
                    this._reticleState = { pos: p.clone(), quat: q.clone(), scl: sc.clone() };
                    this.reticle.matrix.compose(this._reticleState.pos, this._reticleState.quat, this._reticleState.scl);
                    this.reticle.matrixAutoUpdate = false;
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
            }

            _reticleStabilityGate(validHit) {
                const N = this._stableFramesRequired ?? 5;
                this._stableCount = validHit ? (this._stableCount || 0) + 1 : 0;
                return this._stableCount >= N;
            }

            /** Muestra <model-viewer> fallback o Quick Look en iOS. */
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
                } catch (err) {
                    this.handleError(err, 'error.mostrar_fallback');
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
                    if (this.renderer) {
                        this.renderer.setAnimationLoop(null);
                    }

                    if (this.model) {
                        this.disposeObject(this.model);
                        this.model = null;
                    }

                    if (this.scene) {
                        this.scene.traverse(o => {
                            if (o.isMesh && o.geometry) {
                                o.geometry.dispose();
                            }
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

                    this.disableUI(false);
                    $(this.cfg.ui.hint).text(this.msg('estado.listo'));

                    this.setStatus(this.msg('estado.visor_reiniciado'));
                } catch (err) {
                    this.handleError(err, 'error.reset_total');
                }
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

                    if (lockCursor) {
                        $('body').css('cursor', disabled ? 'progress' : '');
                    }

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
                    this.handleError(err, 'error.deshabilitar_ui');
                }
            }
        }

        (function ($) { window.JQueryArViewer = JQueryArViewer; })(jQuery);

        // Inicialización
        $(function () {
            const viewer = new JQueryArViewer({
                glbUrl: $dataManagerPage['public-root'] + '/simi-rura/examples/HORNET.glb',
                usdzUrl: $dataManagerPage['public-root'] + '/simi-rura/examples/HORNET.usdz',
                // Ejemplo de personalización rápida de textos:
                i18n: {
                    textos: {
                        etiquetas: { botonVer: 'Entrar' } // cambia el texto del botón si lo deseas
                    }
                }
            });
            viewer.init();

            // Recomendado para visibilidad y sensibilidad
            viewer.configureCamera({ toneExposure: 1.4 });
            viewer.configureSensitivity({
                stableFramesRequired: 3,
                offsetRayDown: 0.25,
                upDotMin: 0.78,
                minDistance: 0.15
            });
            viewer.configureReticle({ color: 0x00e5ff });
        });
    </script>
@endsection
@section('content')
    <div class="container--custom">
        <div id="ar-loading"
             class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-75 d-flex justify-content-center align-items-center d-none"
             style="z-index:9999;">
            <div class="spinner-border text-light" role="status" style="width: 4rem; height: 4rem;"></div>
        </div>

        <div id="hint" class="alert alert-dark py-2 px-3 small mb-2">Ready. Tap “Enter AR”.</div>

        <!-- Controles (Bootstrap 5) -->
        <div class="d-flex flex-wrap gap-2 mb-3">
            <button id="btn-enter-ar" class="btn btn-primary btn-sm">Ver</button>
            <button id="btn-reset" class="btn btn-outline-secondary btn-sm">Reset</button>
            <button id="btn-zoom-in" class="btn btn-outline-success btn-sm">Zoom +</button>
            <button id="btn-zoom-out" class="btn btn-outline-success btn-sm">Zoom −</button>
            <button id="btn-scale-1x" class="btn btn-outline-info btn-sm">Scale 1×</button>
            <button id="btn-scale-2x" class="btn btn-outline-info btn-sm">Scale 2×</button>
            <div class="vr"></div>
            <button id="btn-rot-left" class="btn btn-outline-warning btn-sm">⟲ Left</button>
            <button id="btn-rot-right" class="btn btn-outline-warning btn-sm">⟳ Right</button>
            <button id="btn-rot-up" class="btn btn-outline-warning btn-sm">↑ Up</button>
            <button id="btn-rot-down" class="btn btn-outline-warning btn-sm">↓ Down</button>
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
@endsection
