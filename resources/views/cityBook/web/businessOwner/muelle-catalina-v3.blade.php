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
        window.$dataManagerPage = window.$dataManagerPage || {'public-root': '.'};

        class JQueryArViewer {
            /** Build with options. Only glbUrl is required. */
            constructor(options = {}) {
                const defaults = {
                    // Assets
                    glbUrl: '',               // REQUIRED: GLB URL
                    usdzUrl: '',              // Optional (iOS Quick Look)

                    // UI selectors
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

                    // Reticle visuals
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

                    // Model transforms
                    model: {
                        initialScale: 1.0,
                        minScale: 0.2,
                        maxScale: 10.0,
                        zoomFactor: 1.10,
                        rotationStepY: 0.15, // radians for left/right
                        rotationStepX: 0.10  // radians for up/down (pitch)
                    },

                    // Cámara y tono para baja/alta luz
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

                    // Luces base y “linterna”
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
                    uiBehavior: {
                        disableDuring: {
                            sessionStart: true,  // deshabilita UI al abrir la cámara (requestSession)
                            modelLoad:    true   // deshabilita UI mientras se carga el GLB
                        },
                        lockCursor: true,
                        include: null,
                        exclude: ['hint', 'fallback', 'modelViewer']
                    }
                };

                this.cfg = $.extend(true, {}, defaults, options);

                // Política: solo botón “Ver” inicia la cámara
                this._requireButtonToStart = true;

                // Plataforma
                this.platform = JQueryArViewer.detectPlatform();

                // State
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

                // Estados internos de suavizado/estabilidad
                this._reticleState = null;
                this._stableCount = 0;
                this._smoothFactor = this.cfg.reticleSensitivity.smoothFactor;
                this._stableFramesRequired = this.cfg.reticleSensitivity.stableFramesRequired;
                this.hitFilter = {
                    minDistance: this.cfg.reticleSensitivity.minDistance,
                    maxDistance: this.cfg.reticleSensitivity.maxDistance,
                    upDotMin:    this.cfg.reticleSensitivity.upDotMin
                };

                // Cached jQuery
                this.$win = $(window);
                this.$hint = $(this.cfg.ui.hint);
            }

            /* ==============================
             * Plataforma / Modo
             * ============================== */
            static detectPlatform() {
                const ua = navigator.userAgent || navigator.vendor || window.opera || "";
                const isAndroid = /Android/i.test(ua);
                const isIOS = /iPhone|iPad|iPod/i.test(ua) ||
                    (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
                return { isAndroid, isIOS };
            }

            /** Decide el modo efectivo según plataforma y capacidades. */
            async decideMode() {
                const { isAndroid, isIOS } = this.platform;

                if (isIOS) {
                    return 'ios-fallback'; // preferimos Quick Look con USDZ a WebXR
                }
                if (isAndroid) {
                    const supported = await this.isImmersiveArAvailable();
                    return supported ? 'android-webxr' : 'fallback';
                }
                return 'fallback';
            }

            /* ==============================
             * Public API
             * ============================== */

            /** Initialize the viewer: wire UI, initial status. */
            init() {
                try {
                    this.bindUi();
                    this.setStatus('Ready. Tap "Enter AR". (HTTPS required)');

                    // Sin autostart: solo botón “Ver” puede iniciar cámara
                    if (!this._requireButtonToStart) {
                        this._startOnFirstTap = async () => {
                            if (this._starting || this.session) return;
                            await this.startAr();
                            window.removeEventListener('pointerdown', this._startOnFirstTap, true);
                            this._startOnFirstTap = null;
                        };
                        window.addEventListener('pointerdown', this._startOnFirstTap, true);
                    }

                    // Decide modo de operación
                    this._initByMode();
                } catch (err) {
                    this.handleError(err, 'Initialization failed.');
                }
            }

            async _initByMode() {
                try {
                    const mode = await this.decideMode(); // 'android-webxr' | 'ios-fallback' | 'fallback'

                    if (mode === 'android-webxr') {
                        $(this.cfg.ui.fallback).addClass('d-none');
                        $(this.cfg.ui.enterBtn).text('Ver');
                        // El usuario deberá pulsar “Ver” para abrir la cámara
                    } else if (mode === 'ios-fallback') {
                        this.showFallback();
                        $(this.cfg.ui.enterBtn).off('click');
                        this.setStatus(this.cfg.usdzUrl ?
                            'iOS: pulsa “Ver en AR” para Quick Look.' :
                            'iOS: sin USDZ, se muestra visor 3D.');
                        this._hideArControlsExcept(['hint','fallback','modelViewer']);
                    } else {
                        this.showFallback();
                        $(this.cfg.ui.enterBtn).off('click');
                        $(this.cfg.ui.enterBtn).addClass('disabled').attr('aria-disabled','true');
                        this.setStatus('Modo visor 3D. AR no disponible en este dispositivo.');
                        this._hideArControlsExcept(['hint','fallback','modelViewer']);
                    }
                } catch (err) {
                    this.handleError(err, 'Initialization mode selection failed.');
                    this.showFallback();
                    this._hideArControlsExcept(['hint','fallback','modelViewer']);
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
                        $el.addClass('d-none')
                            .prop('disabled', true)
                            .attr('aria-disabled','true')
                            .css('pointer-events','none');
                    }
                });
            }

            // Configuraciones en caliente
            configureCamera(opts = {}) {
                Object.assign(this.cfg.camera, opts);
                if (this.camera) {
                    this.camera.fov  = this.cfg.camera.fov;
                    this.camera.near = this.cfg.camera.near;
                    this.camera.far  = this.cfg.camera.far;
                    this.camera.updateProjectionMatrix();
                }
                if (this.renderer) {
                    this.renderer.toneMapping = this.cfg.camera.toneMapping;
                    this.renderer.toneMappingExposure = this.cfg.camera.toneExposure;
                }
            }

            configureSensitivity(opts = {}) {
                Object.assign(this.cfg.reticleSensitivity, opts);
                this._smoothFactor         = this.cfg.reticleSensitivity.smoothFactor;
                this._stableFramesRequired = this.cfg.reticleSensitivity.stableFramesRequired;
                this.hitFilter = {
                    minDistance: this.cfg.reticleSensitivity.minDistance,
                    maxDistance: this.cfg.reticleSensitivity.maxDistance,
                    upDotMin:    this.cfg.reticleSensitivity.upDotMin
                };
            }

            configureReticle(opts = {}) {
                Object.assign(this.cfg.reticle, opts);
                if (this.reticle?.material?.color) {
                    this.reticle.material.color.setHex(this.cfg.reticle.color);
                }
            }

            /** Start the AR session (or fallback if unavailable). */
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
                    this.handleError(err, 'Start AR failed');
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
                } catch (e) {
                    this.resetEverything();
                }
            }

            /** Reset and remove the model from the scene. */
            reset() {
                try {
                    if (!this.model) return this.setStatus('No model to reset.');
                    this.scene.remove(this.model);
                    this.disposeObject(this.model);
                    this.model = null;
                    this.setStatus('Model reset. Tap to place again.');
                } catch (err) {
                    this.handleError(err, 'Reset failed.');
                }
            }

            /** Zoom in (scale up). */
            zoomIn() {
                try {
                    if (!this.model) return;
                    this.setUniformScale(this.model.scale.x * this.cfg.model.zoomFactor);
                } catch (err) { this.handleError(err, 'Zoom in failed.'); }
            }

            /** Zoom out (scale down). */
            zoomOut() {
                try {
                    if (!this.model) return;
                    this.setUniformScale(this.model.scale.x / this.cfg.model.zoomFactor);
                } catch (err) { this.handleError(err, 'Zoom out failed.'); }
            }

            /** Set exact scale (uniform). */
            setScale(value) {
                try {
                    if (!this.model) return;
                    this.setUniformScale(value);
                } catch (err) { this.handleError(err, 'Set scale failed.'); }
            }

            /** Rotate around Y (left/right). Positive = right, negative = left. */
            rotateY(deltaRadians) {
                try {
                    if (!this.model) return;
                    this.model.rotation.y += deltaRadians;
                    this.setStatus('Rotate Y: ' + this.model.rotation.y.toFixed(2));
                } catch (err) { this.handleError(err, 'Rotate Y failed.'); }
            }

            /** Rotate around X (up/down). Positive = up, negative = down. */
            rotateX(deltaRadians) {
                try {
                    if (!this.model) return;
                    this.model.rotation.x = this.clamp(
                        this.model.rotation.x + deltaRadians,
                        -Math.PI / 2, Math.PI / 2
                    );
                    this.setStatus('Rotate X: ' + this.model.rotation.x.toFixed(2));
                } catch (err) { this.handleError(err, 'Rotate X failed.'); }
            }

            /* ==============================
             * Internals — Three.js / XR
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

                this.scene  = new THREE.Scene();

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

            /** Add a hemisphere + directional "flashlight". */
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

            /** Create a ring-shaped reticle mesh (visible in low light). */
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

            /** Resize renderer to full window. */
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

            /** Check immersive-ar availability (HTTPS, XR). */
            async isImmersiveArAvailable() {
                const secure = location.protocol === 'https:' || location.hostname === 'localhost';
                if (!secure || !navigator.xr) return false;
                try { return await navigator.xr.isSessionSupported('immersive-ar'); }
                catch { return false; }
            }

            /** Configure session: spaces, hit-test source, controller. */
            async onSessionStarted(session) {
                this.renderer.xr.setReferenceSpaceType('local');
                await this.renderer.xr.setSession(session);

                session.addEventListener('end', this.onSessionEnded.bind(this));
                this.referenceSpace = await session.requestReferenceSpace('local');
                this.viewerSpace    = await session.requestReferenceSpace('viewer');

                // Hit-test seguro con offsetRay si es posible
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
                this.setStatus('AR started. Aim at floor, tap to place/move.');
            }

            /** Cleanup XR state on session end. */
            onSessionEnded() {
                this.setStatus('AR session ended.');
                this.resetEverything();
                this.disableUI(false);
            }

            /** Listen for XR controller "select" (tap) to place/move. */
            attachController() {
                const controller = this.renderer.xr.getController(0);
                controller.addEventListener('select', this.onXrSelect.bind(this));
                this.scene.add(controller);
            }

            /** Handle AR tap: place or move model at the reticle pose. */
            onXrSelect() {
                if (!this.reticle.visible) return this.setStatus('No reticle. Aim at a flat surface.');
                this.placeOrMoveModelAtReticle();
            }

            /** Create/move the model on the reticle pose. */
            placeOrMoveModelAtReticle() {
                const mat = new THREE.Matrix4().copy(this.reticle.matrix);

                if (this.model) {
                    this.applyMatrixToModel(this.model, mat);
                    return this.setStatus('Model moved.');
                }

                try {
                    this.setStatus('Loading model…');

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
                            this.setStatus('Model loaded and placed.');
                        },
                        (xhr) => {
                            const pct = Math.round((xhr.loaded / xhr.total) * 100);
                            if (isFinite(pct)) this.setStatus(`Loading ${pct}%…`);
                        },
                        (err) => {
                            this.hideLoading();
                            if (this.cfg.uiBehavior?.disableDuring?.modelLoad) this.disableUI(false);
                            this.handleError(err, 'Failed to load GLB.');
                        }
                    );
                } catch (err) {
                    this.handleError(err, 'Unexpected error while placing model.');
                    this.hideLoading();
                    if (this.cfg.uiBehavior?.disableDuring?.modelLoad) this.disableUI(false);
                }
            }

            /** XR Frame: update reticle from hit-test & render scene. */
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
                                const pos  = new THREE.Vector3();
                                const quat = new THREE.Quaternion();
                                const scl  = new THREE.Vector3();
                                m.decompose(pos, quat, scl);

                                // Filtro por orientación “hacia arriba”
                                const up = new THREE.Vector3(0, 1, 0).applyQuaternion(quat);
                                const dot = up.dot(new THREE.Vector3(0, 1, 0)); // 1 = horizontal arriba
                                const upOk = dot >= this.hitFilter.upDotMin;

                                // Filtro por distancia a cámara
                                const camPos = this.camera?.position ?? new THREE.Vector3(0,0,0);
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
                    this.handleError(frameErr, 'AR frame error.');
                }

                if (this.renderer && this.camera) {
                    this.renderer.render(this.scene, this.camera);
                }
            }

            /* ==============================
             * Internals — Model ops
             * ============================== */

            /** Robust materials for mobile (no frustum culling, double-sided). */
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

            /** Apply XR matrix to model transform. */
            applyMatrixToModel(model, mat4) {
                model.position.setFromMatrixPosition(mat4);
                model.quaternion.setFromRotationMatrix(mat4);
            }

            /** Uniform scale with clamping. */
            setUniformScale(value) {
                const s = this.clamp(value, this.cfg.model.minScale, this.cfg.model.maxScale);
                this.model.scale.set(s, s, s);
                this.setStatus('Scale: ' + s.toFixed(2));
            }

            /** Dispose geometries/materials to free memory. */
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
             * Internals — UI & helpers
             * ============================== */

            /** Wire Bootstrap buttons to actions (defensive if missing). */
            bindUi() {
                // Botón principal “Ver”
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
                        this.setStatus('iOS: visor 3D activo. Provee USDZ para Quick Look.');
                        return;
                    }

                    this.setStatus('Visor 3D activo. AR no disponible en este dispositivo.');
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

            /** Status + console (success/info). */
            setStatus(msg) {
                console.log('[AR]', msg);
                this.$hint && this.$hint.text(msg);
            }

            /** Centralized error handler with UX message. */
            handleError(error, friendlyMsg = 'Unexpected error.') {
                console.error('[AR] Error:', error);
                this.setStatus(friendlyMsg);
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

                const tPos  = new THREE.Vector3();
                const tQuat = new THREE.Quaternion();
                const tScl  = new THREE.Vector3();
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

            /** Show <model-viewer> fallback for non-WebXR browsers or iOS Quick Look. */
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

                    this.setStatus('Fallback activo. Usa “Ver en AR” si está disponible.');
                } catch (err) {
                    this.handleError(err, 'Could not show fallback viewer.');
                }
            }

            resetEverything() {
                this.hitReady = false;
                this.hitTestSource = null;
                this.session = null;
                this.disableUI(false);
                $(this.cfg.ui.hint).text('Ready. Tap "Enter AR". (HTTPS required)');
                this.setStatus('Viewer fully reset.');
                if (this.reticle) this.reticle.visible = false;
                try {
                    this.setStatus('Resetting AR viewer…');

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
                    $(this.cfg.ui.hint).text('Ready. Tap "Enter AR". (HTTPS required)');

                    this.setStatus('Viewer fully reset.');
                } catch (err) {
                    this.handleError(err, 'ResetEverything failed');
                }
            }

            disableUI(disabled = true, opts = {}) {
                try {
                    const behavior = this.cfg.uiBehavior || {};
                    const lockCursor = ('lockCursor' in behavior) ? behavior.lockCursor : true;

                    const include = (opts.include !== undefined) ? opts.include : behavior.include;
                    const exclude = (opts.exclude !== undefined) ? opts.exclude : (behavior.exclude || ['hint','fallback','modelViewer']);

                    let entries = Object.entries(this.cfg.ui || {});
                    entries = entries.filter(([key]) => {
                        if (include && Array.isArray(include)) return include.includes(key);
                        return !exclude.includes(key);
                    });

                    entries.forEach(([_, sel]) => {
                        if (!sel) return;
                        const $el = $(sel);
                        if (!$el.length) return;

                        $el.prop('disabled', disabled)
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
                    this.handleError(err, 'disableUI failed.');
                }
            }
        }

        (function ($) { window.JQueryArViewer = JQueryArViewer; })(jQuery);

        // Inicialización
        $(function () {
            const viewer = new JQueryArViewer({
                glbUrl: $dataManagerPage['public-root'] + "/simi-rura/examples/HORNET.glb",
                // Proporciona USDZ si deseas Quick Look en iOS
                usdzUrl: $dataManagerPage['public-root'] + "/simi-rura/examples/HORNET.usdz"
            });
            viewer.init();

            // Recomendado para buena visibilidad y sensibilidad
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
