@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
    $sourcesRoot = $resourcePathServer . 'frontend/businessOwner/mikuy-yachak';

@endphp
@extends('layouts.bootstrap5')
@section('additional-styles')
    <style>
        /* Estado oculto de elementos marcados */
        .not-view {
            display: none !important;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif;
            background: #111;
            color: #eee;
        }

        #map {
            position: fixed;
            inset: 0;
        }

        .not-view {
            display: none !important;
        }

        .d-none {
            display: none !important;
        }

        .controls {
            position: fixed;
            inset: 0;
            pointer-events: none;
        }

        .controls .container--custom {
            height: 100%;
            pointer-events: none;
        }

        #fallback {
            pointer-events: auto;
            padding: 8px;
        }

        #hint {
            position: fixed;
            left: 12px;
            bottom: 12px;
            background: rgba(0, 0, 0, .65);
            color: #fff;
            padding: 8px 12px;
            border-radius: 10px;
            z-index: 10001;
            font-size: 14px;
        }

        /* Retícula */
        #reticle-overlay.hidden {
            display: none;
        }

        #reticle-overlay {
            position: fixed;
            inset: 0;
            display: grid;
            place-items: center;
            z-index: 10000;
            pointer-events: auto;
            background: transparent;
        }

        .reticle__ring {
            width: 120px;
            height: 120px;
            border: 2px dashed #fff;
            border-radius: 50%;
            box-shadow: 0 0 12px rgba(255, 255, 255, .35) inset;
        }

        .reticle__dot {
            width: 6px;
            height: 6px;
            background: #fff;
            border-radius: 50%;
            margin-top: -60px;
        }

        .reticle__hint {
            color: #fff;
            margin-top: 12px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, .6);
            font-weight: 500;
        }

        /* Botón volver */
        #btn-back-map {
            position: fixed;
            top: 12px;
            left: 12px;
            z-index: 10001;
            padding: 8px 12px;
            border-radius: 10px;
            border: none;
            background: #222;
            color: #fff;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .35);
        }

        #btn-back-map:hover {
            background: #2c2c2c;
        }

        /* Popup BEM */
        .popup-card {
            width: 280px;
            font-size: 14px;
            color: #222;
        }

        .popup-card__header {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .popup-card__img {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: 8px;
        }

        .popup-card__titles {
            display: flex;
            flex-direction: column;
        }

        .popup-card__title {
            margin: 0;
            font-size: 16px;
        }

        .popup-card__subtitle {
            margin: 2px 0 0;
            font-size: 12px;
            color: #666;
        }

        .popup-card__body {
            margin-top: 8px;
            color: #333;
        }

        .popup-card__description {
            margin: 0;
        }

        .popup-card__footer {
            margin-top: 10px;
            display: flex;
            gap: 8px;
        }

        .popup-card__btn {
            padding: 8px 10px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .popup-card__btn--primary {
            background: #4c4cff;
            color: #fff;
        }

        .popup-card__btn--ghost {
            background: #f1f1f1;
            color: #333;
        }

        /* model-viewer */
        model-viewer {
            width: 100%;
            height: 70vh;
            background: #000;
            border-radius: 12px;
        }

        /* loader */
        .spinner-border {
            width: 4rem;
            height: 4rem;
            border: .35rem solid rgba(255, 255, 255, .25);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        #btn-capture {
            position: fixed;
            top: 12px;
            right: 12px;
            z-index: 10001;
            padding: 8px 12px;
            border-radius: 10px;
            border: none;
            background: #2f8;
            color: #000;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .35);
            font-weight: 600;
        }

        #btn-capture:hover {
            filter: brightness(0.95);
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
    <script src="https://unpkg.com/html2canvas@1.4.1/dist/html2canvas.min.js" crossorigin="anonymous"></script>
    <script>
        /* =========================================================
         * AR + Fallback con inicio inmediato, retícula tras primer pose,
         * linterna, captura, eventos de sesión y retorno automático al mapa.
         * Dependencias ya cargadas en la página: Leaflet, THREE + GLTFLoader,
         * <model-viewer> (opcional), y html2canvas (opcional).
         * Elementos DOM requeridos:
         *   #map, .container--custom, #ar-loading, #hint,
         *   #reticle-overlay (.reticle__hint opcional),
         *   #btn-back-map, #btn-capture, #btn-torch,
         *   #fallback > #mv
         * ========================================================= */

        /* ============== Platform ================================= */
        class Platform {
            static get ua() {
                return navigator.userAgent || navigator.vendor || "";
            }

            static get isAndroid() {
                return /Android/i.test(this.ua);
            }

            static get isIOS() {
                return /iPhone|iPad|iPod/i.test(this.ua) || (navigator.platform === "MacIntel" && navigator.maxTouchPoints > 1);
            }

            static get isSecure() {
                return location.protocol === "https:" || location.hostname === "localhost";
            }

            static async canUseAR() {
                if (!this.isAndroid || !this.isSecure || !('xr' in navigator)) return false;
                try {
                    return await navigator.xr.isSessionSupported('immersive-ar');
                } catch {
                    return false;
                }
            }
        }

        /* ============== UIManager ================================= */
        class UIManager {
            init() {
                this.$loading = document.getElementById("ar-loading");
                this.$fallback = document.getElementById("fallback");
                this.$mv = document.getElementById("mv");
                this.$hint = document.getElementById("hint");
                this.$container = document.querySelector(".container--custom");
                this.$reticle = document.getElementById("reticle-overlay");
                this.$retHint = this.$reticle?.querySelector(".reticle__hint");
                this.$map = document.getElementById("map");
                this.$btnBack = document.getElementById("btn-back-map");
                this.$btnCapture = document.getElementById("btn-capture");
                this.$btnTorch = document.getElementById("btn-torch");
            }

            setHint(m) {
                if (this.$hint) this.$hint.textContent = m;
            }

            setReticleText(m) {
                if (this.$retHint) this.$retHint.textContent = m;
            }

            showLoading() {
                this.$loading?.classList.remove("d-none");
            }

            hideLoading() {
                this.$loading?.classList.add("d-none");
            }

            showFallback() {
                this.$fallback?.classList.remove("d-none");
            }

            hideFallback() {
                this.$fallback?.classList.add("d-none");
            }

            revealContainer() {
                this.$container?.classList.remove("not-view");
            }

            showReticle() {
                this.$reticle?.classList.remove("hidden");
            }

            hideReticle() {
                this.$reticle?.classList.add("hidden");
            }

            showMap() {
                this.$map?.classList.remove("not-view");
                this.$btnBack?.classList.add("d-none");
            }

            hideMap() {
                this.$map?.classList.add("not-view");
                this.$btnBack?.classList.remove("d-none");
            }

            showCapture() {
                this.$btnCapture?.classList.remove("d-none");
            }

            hideCapture() {
                this.$btnCapture?.classList.add("d-none");
            }

            showTorch() {
                this.$btnTorch?.classList.remove("d-none");
            }

            hideTorch() {
                this.$btnTorch?.classList.add("d-none");
            }

            hideAllControls() {
                this.hideReticle();
                this.hideCapture();
                this.hideTorch();
            }

            get mv() {
                return this.$mv;
            }

            get btnBack() {
                return this.$btnBack;
            }

            get btnCapture() {
                return this.$btnCapture;
            }

            get btnTorch() {
                return this.$btnTorch;
            }

            get reticle() {
                return this.$reticle;
            }
        }

        const UI = new UIManager();

        /* ============== Torch (linterna) ========================== */
        class Torch {
            static _stream = null;
            static _track = null;

            static async on() {
                if (!navigator.mediaDevices?.getUserMedia) return false;
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({video: {facingMode: {ideal: "environment"}}});
                    const track = stream.getVideoTracks()[0];
                    const caps = track.getCapabilities?.() || {};
                    if (!caps.torch) {
                        stream.getTracks().forEach(t => t.stop());
                        return false;
                    }
                    await track.applyConstraints({advanced: [{torch: true}]});
                    this._stream = stream;
                    this._track = track;
                    return true;
                } catch {
                    return false;
                }
            }

            static off() {
                try {
                    this._stream?.getTracks().forEach(t => t.stop());
                } catch {
                }
                this._stream = null;
                this._track = null;
            }
        }

        /* ============== Download & Stats ========================== */
        class DownloadUtils {
            static saveDataURL(filename, dataUrl) {
                const a = document.createElement('a');
                a.href = dataUrl;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
            }

            static saveBlob(filename, blob) {
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(url);
            }
        }

        class StatsUtils {
            static computeModelStats(root) {
                if (!root) return null;
                const box = new THREE.Box3().setFromObject(root), size = new THREE.Vector3();
                box.getSize(size);
                let meshes = 0, tris = 0;
                root.traverse(o => {
                    if (o.isMesh && o.geometry) {
                        meshes++;
                        const g = o.geometry;
                        tris += Math.floor(g.index ? g.index.count / 3 : (g.attributes?.position ? g.attributes.position.count / 3 : 0));
                    }
                });
                return {
                    meshes,
                    triangles: tris,
                    bbox: {x: +size.x.toFixed(4), y: +size.y.toFixed(4), z: +size.z.toFixed(4)}
                };
            }
        }

        /* ============== ModelViewerController ===================== */
        class ModelViewerController {
            constructor(mvEl, hooks = {}) {
                this.mv = mvEl;
                this.hooks = hooks;
                this._bound = false;
            }

            bindOnce() {
                if (this._bound || !this.mv) return;
                this._bound = true;
                this._onARStatus = (ev) => {
                    const st = ev?.detail?.status;
                    if (st === "session-started") this.hooks.onEnter && this.hooks.onEnter({mode: "ios/web-ar"});
                    if (st === "not-presenting") this.hooks.onExit && this.hooks.onExit({
                        reason: "ar-status",
                        status: st
                    });
                };
                this._onCameraChange = () => {
                    const orbit = this.mv.getCameraOrbit?.();
                    this.hooks.onRotate && this.hooks.onRotate({rotY: orbit?.theta ?? 0, rotX: orbit?.phi ?? 0});
                    this.hooks.onScale && this.hooks.onScale({scale: orbit?.radius ?? 0});
                };
                this._onLoad = () => UI.setHint("Modelo cargado en visor 3D.");
                this._onError = () => UI.setHint("Error al cargar en visor 3D.");
                this.mv.addEventListener("ar-status", this._onARStatus);
                this.mv.addEventListener("camera-change", this._onCameraChange);
                this.mv.addEventListener("load", this._onLoad);
                this.mv.addEventListener("error", this._onError);
            }

            async setSource({glbUrl, usdzUrl}) {
                if (!this.mv) return;
                UI.showFallback();
                this.mv.src = glbUrl || "";
                if (usdzUrl) this.mv.setAttribute("ios-src", usdzUrl); else this.mv.removeAttribute("ios-src");
                await new Promise((res, rej) => {
                    const ok = () => {
                        this.mv.removeEventListener('load', ok);
                        res();
                    };
                    const ko = () => {
                        this.mv.removeEventListener('error', ko);
                        rej();
                    };
                    this.mv.addEventListener('load', ok, {once: true});
                    this.mv.addEventListener('error', ko, {once: true});
                });
            }

            destroy() {
                if (!this.mv) return;
                this.mv.removeEventListener("ar-status", this._onARStatus);
                this.mv.removeEventListener("camera-change", this._onCameraChange);
                this.mv.removeEventListener("load", this._onLoad);
                this.mv.removeEventListener("error", this._onError);
                this.mv.src = "";
                this.mv.removeAttribute("ios-src");
                this._bound = false;
            }
        }

        /* ============== AndroidWebXRController ==================== */
        class AndroidWebXRController {
            constructor(hooks = {}) {
                this.hooks = hooks;
                this.renderer = null;
                this.scene = null;
                this.camera = null;
                this.session = null;
                this.model = null;
                this._refSpace = null;

                this._distanceMeters = 1.2;
                this._loop = this._onXRFrame.bind(this);
                this._onResize = this._handleResize.bind(this);

                // tracking / tiempos
                this._sessionStartMs = 0;
                this._firstPoseSeen = false;
                this._noPoseSinceMs = 0;
                this._graceMs = 1800;
                this._noPoseWarnMs = 900;

                // luces / estimación
                this._headlamp = null;
                this._lightProbe = null;

                // flags cierre
                this._isStopping = false;

                // handlers
                this._onEnd = this._onVis = this._onInputs = null;
                this._onSelectStart = this._onSelectEnd = this._onSelect = null;
                this._onSqueezeStart = this._onSqueezeEnd = this._onSqueeze = null;
            }

            async startFromGesture(glbUrl) {
                // 1) requestSession dentro del gesto
                this.session = await navigator.xr.requestSession("immersive-ar", {
                    requiredFeatures: ["local"],
                    optionalFeatures: ["dom-overlay", "light-estimation"],
                    domOverlay: {root: document.body}
                });

                // estados tracking
                this._sessionStartMs = performance.now();
                this._firstPoseSeen = false;
                this._noPoseSinceMs = this._sessionStartMs;

                // 2) renderer/escena y sesión
                this._setupRenderer();
                this._setupScene();
                this.renderer.xr.setReferenceSpaceType("local");
                await this.renderer.xr.setSession(this.session);
                this._refSpace = this.renderer.xr.getReferenceSpace();

                // 3) eventos sesión
                this._onEnd = () => this.hooks.onExit && this.hooks.onExit({reason: "session-end"});
                this._onVis = () => {
                    const s = this.session?.visibilityState;
                    if (s === "hidden" || s === "visible-blurred") {
                        this.hooks.onExit && this.hooks.onExit({reason: "visibility", state: s});
                    }
                };
                this._onInputs = e => console.log("[xr] inputsourceschange", e.added, e.removed);
                this._onSelectStart = e => console.log("[xr] selectstart", e.inputSource);
                this._onSelectEnd = e => console.log("[xr] selectend", e.inputSource);
                this._onSelect = e => console.log("[xr] select", e.inputSource);
                this._onSqueezeStart = e => console.log("[xr] squeezestart", e.inputSource);
                this._onSqueezeEnd = e => console.log("[xr] squeezeend", e.inputSource);
                this._onSqueeze = e => console.log("[xr] squeeze", e.inputSource);

                this.session.addEventListener("end", this._onEnd);
                this.session.addEventListener("visibilitychange", this._onVis);
                this.session.addEventListener("inputsourceschange", this._onInputs);
                this.session.addEventListener("selectstart", this._onSelectStart);
                this.session.addEventListener("selectend", this._onSelectEnd);
                this.session.addEventListener("select", this._onSelect);
                this.session.addEventListener("squeezestart", this._onSqueezeStart);
                this.session.addEventListener("squeezeend", this._onSqueezeEnd);
                this.session.addEventListener("squeeze", this._onSqueeze);

                // 4) light estimation
                try {
                    if (this.session.requestLightProbe) {
                        this._lightProbe = await this.session.requestLightProbe({type: 'spherical-harmonics'});
                    }
                } catch (e) {
                    console.warn("[xr] light estimation no disponible", e);
                }

                // 5) cargar modelo
                await this._loadModel(glbUrl);

                // 6) feedback
                UI.setHint("Abriendo cámara...");

                // 7) gestos
                this._bindGestures();

                // 8) eventos ventana
                window.addEventListener("resize", this._onResize);
                this.hooks.onEnter && this.hooks.onEnter({mode: "android-webxr"});
            }

            async setSource({glbUrl}) {
                await this._disposeModel();
                await this._loadModel(glbUrl);
            }

            placeInFront() {
                this._placeInFront();
            }

            async stop() {
                if (this._isStopping) return;
                this._isStopping = true;
                try {
                    window.removeEventListener("resize", this._onResize);
                } catch {
                }
                try {
                    this.renderer?.setAnimationLoop(null);
                } catch {
                }
                await this._disposeModel();

                if (this.session) {
                    try {
                        await this.session.end();
                    } catch {
                    }
                    try {
                        this.session.removeEventListener("end", this._onEnd);
                        this.session.removeEventListener("visibilitychange", this._onVis);
                        this.session.removeEventListener("inputsourceschange", this._onInputs);
                        this.session.removeEventListener("selectstart", this._onSelectStart);
                        this.session.removeEventListener("selectend", this._onSelectEnd);
                        this.session.removeEventListener("select", this._onSelect);
                        this.session.removeEventListener("squeezestart", this._onSqueezeStart);
                        this.session.removeEventListener("squeezeend", this._onSqueezeEnd);
                        this.session.removeEventListener("squeeze", this._onSqueeze);
                    } catch {
                    }
                }
                if (this.renderer?.domElement?.parentNode) this.renderer.domElement.parentNode.removeChild(this.renderer.domElement);
                try {
                    this.renderer?.dispose?.();
                } catch {
                }
                this.renderer = this.scene = this.camera = this.session = null;
                this._refSpace = null;
                this._headlamp = this._lightProbe = null;
                this._firstPoseSeen = false;
                this._isStopping = false;
            }

            /* ---------- setup ---------- */
            _setupRenderer() {
                if (this.renderer) return;
                this.renderer = new THREE.WebGLRenderer({
                    antialias: true,
                    alpha: true,
                    powerPreference: 'high-performance'
                });
                this.renderer.xr.enabled = true;
                this.renderer.outputEncoding = THREE.sRGBEncoding;
                this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
                this.renderer.toneMappingExposure = 1.2;
                this.renderer.physicallyCorrectLights = true;
                this.renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
                this._handleResize();
                this.renderer.setClearAlpha(0);
                document.body.appendChild(this.renderer.domElement);
            }

            _setupScene() {
                this.scene = new THREE.Scene();
                this.camera = new THREE.PerspectiveCamera(60, Math.max(innerWidth, 1) / Math.max(innerHeight, 1), 0.01, 20);
                this.scene.add(this.camera);

                const hemi = new THREE.HemisphereLight(0xffffff, 0x404040, 0.8);
                const dir = new THREE.DirectionalLight(0xffffff, 0.8);
                dir.position.set(0, 1, -1);
                this._headlamp = new THREE.PointLight(0xffffff, 1.3, 12, 2.0);
                this.camera.add(this._headlamp);
                this.scene.add(hemi, dir);

                this.renderer.setAnimationLoop(this._loop);
            }

            async _loadModel(glbUrl) {
                if (!glbUrl) return;
                UI.showLoading();
                await new Promise((res, rej) => {
                    const loader = new THREE.GLTFLoader();
                    loader.load(glbUrl, (gltf) => {
                        this.model = gltf.scene;
                        const box = new THREE.Box3().setFromObject(this.model), size = new THREE.Vector3();
                        box.getSize(size);
                        const s = 1 / (Math.max(size.x, size.y, size.z) || 1);
                        this.model.scale.setScalar(s);
                        this.model.traverse(o => {
                            if (o.isMesh) {
                                o.frustumCulled = false;
                                const m = o.material;
                                (Array.isArray(m) ? m : [m]).forEach(mm => {
                                    if (mm) {
                                        mm.side = THREE.DoubleSide;
                                        mm.needsUpdate = true;
                                    }
                                });
                            }
                        });
                        UI.hideLoading();
                        res();
                    }, undefined, (err) => {
                        UI.hideLoading();
                        UI.setHint("Error al cargar modelo.");
                        rej(err);
                    });
                });
            }

            /* ---------- placement ---------- */
            _placeInFront() {
                if (!this.model || !this.camera) return;
                const fwd = new THREE.Vector3(0, 0, -1).applyQuaternion(this.camera.quaternion).normalize();
                const pos = new THREE.Vector3().copy(this.camera.position).add(fwd.multiplyScalar(this._distanceMeters));
                this.model.position.copy(pos);
                this.model.position.y -= 0.1;
                this.model.lookAt(this.camera.position.x, this.model.position.y, this.camera.position.z);
                if (!this.model.parent) this.scene.add(this.model);
                UI.setHint("Modelo colocado.");
            }

            /* ---------- gestos táctiles ---------- */
            _pixelsToMetersAtDistance(distMeters) {
                const hMeters = 2 * Math.tan(THREE.MathUtils.degToRad(this.camera.fov * 0.5)) * distMeters;
                return hMeters / Math.max(1, this.renderer.getSize(new THREE.Vector2()).y);
            }
// ====== SOLO MÓVIL: gestos rápidos y responsivos ======
            _bindGestures(){
                const dom = this.renderer.domElement;
                // Evita scroll/zoom de la página y elimina el retardo táctil
                dom.style.touchAction = 'none';

                // Estado mínimo para gestos
                const st = {
                    mode: 'none',         // 'one' | 'two'
                    lastX: 0, lastY: 0,
                    lastDist: 0,
                    lastCx: 0, lastCy: 0,
                };

                // Sensibilidades (ajusta si quieres más/menos “nervioso”)
                const ROT_S  = 0.012;   // rotación por px horizontal
                const ZOOM_S = 0.004;   // factor de zoom vertical por px
                const clampScale = (s) => THREE.MathUtils.clamp(s, 0.2, 3.0);

                // Acumuladores y rAF para aplicar de forma fluida
                let rafId = null, dRot = 0, dZoom = 1, panDX = 0, panDY = 0;
                const apply = () => {
                    rafId = null;
                    if (!this.model) return;

                    if (dRot) { this.model.rotation.y += dRot; dRot = 0; }

                    if (dZoom !== 1) {
                        const s = clampScale(this.model.scale.x * dZoom);
                        this.model.scale.setScalar(s);
                        dZoom = 1;
                    }

                    if (panDX || panDY) {
                        const dCam = this.camera.position.distanceTo(this.model.position);
                        const px2m = this._pixelsToMetersAtDistance(Math.max(0.01, dCam));
                        const right = new THREE.Vector3(1,0,0).applyQuaternion(this.camera.quaternion);
                        const up    = new THREE.Vector3(0,1,0).applyQuaternion(this.camera.quaternion);
                        this.model.position.addScaledVector(right, panDX * px2m);
                        this.model.position.addScaledVector(up,   -panDY * px2m);
                        panDX = panDY = 0;
                    }
                };
                const queue = () => { if (!rafId) rafId = requestAnimationFrame(apply); };

                // 1) touchstart
                const onStart = (e) => {
                    if (e.touches.length === 1) {
                        st.mode = 'one';
                        st.lastX = e.touches[0].clientX;
                        st.lastY = e.touches[0].clientY;
                    } else if (e.touches.length >= 2) {
                        st.mode = 'two';
                        const [a,b] = e.touches;
                        st.lastDist = Math.hypot(a.clientX - b.clientX, a.clientY - b.clientY);
                        st.lastCx   = (a.clientX + b.clientX) * 0.5;
                        st.lastCy   = (a.clientY + b.clientY) * 0.5;
                    }
                };

                // 2) touchmove (pasivo=false para poder preventDefault y bajar lag)
                const onMove = (e) => {
                    if (!this.model) return;
                    e.preventDefault();

                    // 1 dedo: rotar (dx) + zoom vertical (dy)
                    if (st.mode === 'one' && e.touches.length === 1) {
                        const t  = e.touches[0];
                        const dx = t.clientX - st.lastX;      // izquierda ↔ derecha
                        const dy = t.clientY - st.lastY;      // arriba ↕ abajo

                        dRot  -= dx * ROT_S;                  // gira Y
                        dZoom *= (1 - dy * ZOOM_S);           // arriba agranda, abajo reduce

                        st.lastX = t.clientX; st.lastY = t.clientY;
                        queue();
                        return;
                    }

                    // 2 dedos: pinch + pan
                    if (st.mode === 'two' && e.touches.length >= 2) {
                        const [a,b] = e.touches;

                        // pinch
                        const dist   = Math.hypot(a.clientX - b.clientX, a.clientY - b.clientY);
                        const factor = dist / Math.max(1, st.lastDist);
                        dZoom *= factor;
                        st.lastDist = dist;

                        // pan (centro del gesto)
                        const cx = (a.clientX + b.clientX) * 0.5;
                        const cy = (a.clientY + b.clientY) * 0.5;
                        panDX += (cx - st.lastCx);
                        panDY += (cy - st.lastCy);
                        st.lastCx = cx; st.lastCy = cy;

                        queue();
                        return;
                    }
                };

                // 3) touchend / cancel
                const onEnd = () => { st.mode = 'none'; };

                dom.addEventListener('touchstart', onStart, { passive: true  });
                dom.addEventListener('touchmove',  onMove,  { passive: false }); // importante
                dom.addEventListener('touchend',   onEnd,   { passive: true  });
                dom.addEventListener('touchcancel',onEnd,   { passive: true  });
            }

            _bindGestures2() {
                const dom = this.renderer.domElement;
                const st = {touches: [], mode: 'none', lastX: 0, lastY: 0, lastDist: 0, lastCx: 0, lastCy: 0};

                const onStart = (e) => {
                    st.touches = [...e.touches];
                    if (st.touches.length === 1) {
                        st.mode = 'rotate';
                        st.lastX = st.touches[0].clientX;
                        st.lastY = st.touches[0].clientY;
                    } else if (st.touches.length >= 2) {
                        st.mode = 'pinch-pan';
                        const [a, b] = st.touches;
                        st.lastDist = Math.hypot(a.clientX - b.clientX, a.clientY - b.clientY);
                        st.lastCx = (a.clientX + b.clientX) * 0.5;
                        st.lastCy = (a.clientY + b.clientY) * 0.5;
                    }
                };
                const onMove = (e) => {
                    if (!this.model) return;
                    st.touches = [...e.touches];
                    if (st.mode === 'rotate' && st.touches.length === 1) {
                        const t = st.touches[0];
                        const dx = t.clientX - st.lastX;
                        this.model.rotation.y -= dx * 0.01;
                        st.lastX = t.clientX;
                        st.lastY = t.clientY;
                        return;
                    }
                    if (st.mode === 'pinch-pan' && st.touches.length >= 2) {
                        const [a, b] = st.touches;
                        const cx = (a.clientX + b.clientX) * 0.5, cy = (a.clientY + b.clientY) * 0.5;
                        const dist = Math.hypot(a.clientX - b.clientX, a.clientY - b.clientY);
                        const factor = dist / Math.max(1, st.lastDist);
                        const newScale = THREE.MathUtils.clamp(this.model.scale.x * factor, 0.2, 3.0);
                        this.model.scale.setScalar(newScale);
                        st.lastDist = dist;
                        const dx = cx - st.lastCx, dy = cy - st.lastCy;
                        st.lastCx = cx;
                        st.lastCy = cy;
                        const dCam = this.camera.position.distanceTo(this.model.position);
                        const px2m = this._pixelsToMetersAtDistance(dCam);
                        const right = new THREE.Vector3(1, 0, 0).applyQuaternion(this.camera.quaternion);
                        const up = new THREE.Vector3(0, 1, 0).applyQuaternion(this.camera.quaternion);
                        this.model.position.addScaledVector(right, dx * px2m);
                        this.model.position.addScaledVector(up, -dy * px2m);
                    }
                };
                const onEnd = () => {
                    st.touches = [];
                    st.mode = 'none';
                };

                dom.addEventListener('touchstart', onStart, {passive: true});
                dom.addEventListener('touchmove', onMove, {passive: true});
                dom.addEventListener('touchend', onEnd, {passive: true});
                dom.addEventListener('touchcancel', onEnd, {passive: true});
            }

            /* ---------- frame loop ---------- */
            _onXRFrame(time, frame) {
                if (!frame || !this._refSpace) {
                    this.renderer.render(this.scene, this.camera);
                    return;
                }

                const now = performance.now();
                const pose = frame.getViewerPose(this._refSpace);

                if (!pose) {
                    if (now - this._sessionStartMs < this._graceMs) {
                        UI.setHint("Abriendo cámara...");
                        return;
                    }
                    if (now - this._noPoseSinceMs > this._noPoseWarnMs) {
                        UI.setHint("Muy oscuro o sin textura. Aumenta la luz o activa la linterna.");
                        UI.showTorch();
                        this._noPoseSinceMs = now;
                    }
                    return;
                }

                if (!this._firstPoseSeen) {
                    this._firstPoseSeen = true;
                    UI.hideTorch();
                    UI.setHint("Cámara lista. Toca la retícula para colocar el modelo.");
                    UI.setReticleText("Toca para colocar el modelo");
                    UI.showReticle();
                }

                if (this._lightProbe) {
                    try {
                        const est = frame.getLightEstimate(this._lightProbe);
                        if (est?.primaryLightIntensity) {
                            const i = Math.max(0.7, Math.min(2.0, est.primaryLightIntensity.x));
                            if (this._headlamp) this._headlamp.intensity = i;
                        }
                    } catch {
                    }
                }
                this.renderer.render(this.scene, this.camera);
            }

            /* ---------- utils ---------- */
            _handleResize() {
                if (!this.renderer) return;
                const w = Math.max(innerWidth, 1), h = Math.max(innerHeight, 1);
                this.renderer.setSize(w, h);
                if (this.camera && h > 0) {
                    this.camera.aspect = w / h;
                    this.camera.updateProjectionMatrix();
                }
            }

            async _disposeModel() {
                if (!this.model) return;
                this.scene?.remove(this.model);
                this.model.traverse(o => {
                    if (o.isMesh) {
                        o.geometry?.dispose?.();
                        const m = o.material;
                        Array.isArray(m) ? m.forEach(mm => mm?.dispose?.()) : m?.dispose?.();
                    }
                });
                this.model = null;
            }

            getCanvas() {
                return this.renderer?.domElement || null;
            }

            getModelStats() {
                return StatsUtils.computeModelStats(this.model);
            }
        }

        /* ============== StaleGuard ================================= */
        class StaleGuard {
            static async onResume() {
                const st = Viewer.state;
                const staleXR = st.mode === 'android-webxr' && st.controller && !st.controller.session;
                const staleMV = st.mode !== 'android-webxr' && st.controller && !UI.mv?.src;
                if (staleXR || staleMV) {
                    await Viewer.destroy();
                    if (st.lastSource?.glb) await Viewer.onMarkerSourceSelected(st.lastSource.glb);
                }
            }

            static onSuspend() {
            }
        }

        /* ============== Mapa (Leaflet) ============================== */
        class MapController {
            constructor(cfg) {
                this.cfg = cfg;
                this.map = null;
                this.layer = null;
                this.markersById = {};
            }

            init(items) {
                this.map = L.map('map', {zoomControl: true}).setView(this.cfg.position, this.cfg.zoom);
                L.tileLayer(this.cfg.tileUrl, {
                    maxZoom: this.cfg.maxZoom,
                    attribution: this.cfg.tileAttribution
                }).addTo(this.map);
                this.layer = L.layerGroup().addTo(this.map);
                this.render(items);
                this.map.on('popupopen', (e) => {
                    // 1) Primero enlazamos handlers dentro del popup
                    this._bindPopup(e);

                    // 2) Luego centramos (después de enlazar) para no perder listeners
                    const mk = e.popup._source;
                    if (mk) {
                        requestAnimationFrame(() => {
                            this.map.flyTo(mk.getLatLng(), Math.max(this.cfg.zoom, 17), { duration: 0.35 });
                        });
                    }
                });
            }

            render(items) {
                this.layer.clearLayers();
                this.markersById = {};
                const bounds = [];
                items.forEach(item => {
                    const icon = L.icon({
                        iconUrl: item.sources.img,
                        iconSize: [60, 60],
                        iconAnchor: [60, 60],
                        popupAnchor: [0, -40]
                    });
                    const mk = L.marker([item.position.lat, item.position.lng], {icon, title: item.title})
                        .bindPopup(this._popupHTML(item), {maxWidth: 320, autoPan: true, keepInView: true});
                    mk.addTo(this.layer);
                    // Centrar al tocar el ícono del marker
                    mk.on('click', () => {
                        this.map.flyTo(mk.getLatLng(), Math.max(this.cfg.zoom, 17), {duration: 0.35});
                        mk.openPopup();
                    });

                    this.markersById[item.id] = mk;
                    bounds.push([item.position.lat, item.position.lng]);

                });
                if (bounds.length) this.map.fitBounds(bounds, {padding: [40, 40]});
            }

            flyTo(id, zoom = 17) {
                const mk = this.markersById[id];
                if (!mk) return;
                const ll = mk.getLatLng();
                this.map.flyTo(ll, zoom, {duration: 0.8});
                mk.openPopup();
            }

            _popupHTML(item) {
                return `
      <article class="popup-card" data-popup-id="${item.id}">
        <header class="popup-card__header">
          <img class="popup-card__img" src="${item.sources.img}" alt="${item.title}" loading="lazy">
          <div class="popup-card__titles">
            <h4 class="popup-card__title">${item.title}</h4>
            <p class="popup-card__subtitle">${item.subtitle}</p>
          </div>
        </header>
        <section class="popup-card__body"><p class="popup-card__description">${item.description}</p></section>
        <footer class="popup-card__footer">
          <button class="popup-card__btn popup-card__btn--primary not-view" data-action="center" data-id="${item.id}">Centrar aquí</button>
          <a class="popup-card__btn popup-card__btn--ghost" source="${item.sources.glb}" rel="noopener noreferrer">Ver en 3D</a>
        </footer>
      </article>`;
            }
            _bindPopup(e) {
                const root = e.popup.getElement();
                if (!root) return;

                // Evita que el mapa “se coma” clicks y scroll dentro del popup
                L.DomEvent.disableClickPropagation(root);
                L.DomEvent.disableScrollPropagation(root);

                // Botón "Centrar aquí"
                const centerBtn = root.querySelector('.popup-card__btn[data-action="center"]');
                centerBtn?.addEventListener('click', (ev) => {
                    ev.preventDefault();
                    this.flyTo(centerBtn.getAttribute('data-id'));
                }, { once: true });

                // Delegación: funciona aunque Leaflet refluya el DOM durante flyTo/autopan
                const onClick = (ev) => {
                    const btn = ev.target.closest('.popup-card__btn--ghost');
                    if (!btn) return;
                    ev.preventDefault();
                    ev.stopPropagation();

                    const src = btn.getAttribute('data-source')
                        || btn.getAttribute('source')
                        || btn.getAttribute('href') || '';
                    if (!src) { UI.setHint("No hay fuente GLB/USDZ."); return; }

                    // Pequeño defer para no pelear con el auto-pan y mantener user-activation
                    setTimeout(() => {
                        Viewer.beginARFromUserGesture(src);
                    }, 0);
                };

                root.addEventListener('click', onClick, { passive: false });

                // Limpieza al cerrar el popup (evita handlers colgando)
                e.popup._rootClickHandler = onClick;
                this.map.once('popupclose', (evClose) => {
                    if (evClose.popup === e.popup) {
                        root.removeEventListener('click', onClick);
                    }
                });
            }
        }

        /* ============== Viewer (Orquestador) ======================= */
        class ViewerOrchestrator {
            constructor() {
                this._state = {mode: null, controller: null, pendingSource: null, arState: 'idle', lastSource: null};
            }

            get state() {
                return this._state;
            }

            isActive() {
                return !!this._state.controller;
            }

            async _ensureMotionPermission() {
                const need = typeof DeviceMotionEvent !== 'undefined' && typeof DeviceMotionEvent.requestPermission === 'function';
                if (!need) return;
                try {
                    await DeviceMotionEvent.requestPermission();
                } catch {
                }
            }

            async beginARFromUserGesture(glbUrl) {
                await this._ensureMotionPermission();
                const usdzUrl = glbUrl?.endsWith?.('.glb') ? glbUrl.replace(/\.glb$/i, '.usdz') : '';
                this._state.lastSource = {glb: glbUrl, usdz: usdzUrl};

                if (this.isActive() && this._state.mode === 'android-webxr') {
                    await this._state.controller.setSource({glbUrl});
                    UI.setHint('Modelo actualizado (AR).');
                    return;
                }

                UI.revealContainer();
                UI.hideMap();
                UI.hideFallback();

                if (Platform.isAndroid && Platform.isSecure && 'xr' in navigator) {
                    try {
                        this._state.controller = new AndroidWebXRController({
                            onEnter: ({mode}) => UI.setHint(`Cámara iniciada (${mode}).`),
                            onExit: async ({reason, state, status}) => {
                                UI.setHint(`Sesión finalizada (${reason || status || state || "desconocido"}).`);
                                await Viewer.destroy(); // retorno automático al mapa + limpieza
                            }
                        });
                        await this._state.controller.startFromGesture(glbUrl);
                        this._state.mode = 'android-webxr';
                        this._state.arState = 'sessionReady';
                        UI.showCapture();
                        return;
                    } catch (e) {
                        console.warn('AR no inició; fallback', e);
                    }
                }

                // Fallback <model-viewer>
                const mvCtrl = new ModelViewerController(UI.mv, {onEnter: ({mode}) => UI.setHint(`AR activo (${mode}).`)});
                mvCtrl.bindOnce();
                await mvCtrl.setSource({glbUrl, usdzUrl});
                this._state.controller = mvCtrl;
                this._state.mode = Platform.isIOS ? 'ios-quicklook' : 'web-fallback';
                this._state.arState = 'idle';
                UI.showCapture();
                UI.hideReticle();
            }

            async onMarkerSourceSelected(glbUrl) {
                await this._ensureMotionPermission();
                const usdzUrl = glbUrl?.endsWith?.('.glb') ? glbUrl.replace(/\.glb$/i, '.usdz') : '';
                this._state.lastSource = {glb: glbUrl, usdz: usdzUrl};

                if (this.isActive()) {
                    if (this._state.mode === 'android-webxr') {
                        await this._state.controller.setSource({glbUrl});
                        UI.setHint('Modelo actualizado (AR).');
                    } else {
                        await this._state.controller.setSource({glbUrl, usdzUrl});
                        UI.setHint('Modelo actualizado (visor).');
                    }
                    return;
                }
                if (await Platform.canUseAR()) return this.beginARFromUserGesture(glbUrl);

                UI.revealContainer();
                UI.hideMap();
                UI.showFallback();
                const mvCtrl = new ModelViewerController(UI.mv, {onEnter: ({mode}) => UI.setHint(`AR activo (${mode}).`)});
                mvCtrl.bindOnce();
                await mvCtrl.setSource({glbUrl, usdzUrl});
                this._state.controller = mvCtrl;
                this._state.mode = Platform.isIOS ? 'ios-quicklook' : 'web-fallback';
                this._state.arState = 'idle';
                UI.showCapture();
            }

            async handleReticleTap() {
                if (this._state.arState === 'sessionReady' && this._state.mode === 'android-webxr') {
                    this._state.controller.placeInFront();
                    UI.hideReticle();
                    this._state.arState = 'idle';
                }
            }

            async destroy() {
                if (this._state.controller) {
                    if (this._state.mode === 'android-webxr') await this._state.controller.stop();
                    else this._state.controller.destroy();
                }
                this._state.controller = null;
                this._state.mode = null;
                this._state.pendingSource = null;
                this._state.arState = 'idle';
                Torch.off();
                UI.hideFallback();
                UI.hideAllControls();
                UI.showMap();
                UI.setHint("");
            }

            async capture() {
                console.log('[CAPTURE] start');

                // helpers ----------
                const supportsTabCapture = () => {
                    return !!(navigator.mediaDevices?.getDisplayMedia || navigator.getDisplayMedia);
                };
                const askTabCapture = async () => {
                    // intenta spec moderna y legacy
                    if (navigator.mediaDevices?.getDisplayMedia) {
                        return navigator.mediaDevices.getDisplayMedia({ video: { preferCurrentTab: true }, audio: false });
                    }
                    if (navigator.getDisplayMedia) {
                        return navigator.getDisplayMedia({ video: true, audio: false });
                    }
                    throw new Error('No getDisplayMedia impl');
                };
                const saveBlob = (blob, filename) => {
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a'); a.href = url; a.download = filename;
                    document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
                };
                const hideUiForScreenshot = (ms=2000) => new Promise(res=>{
                    try {
                        // Oculta controles para que no salgan en la foto del sistema
                        UI.hideCapture(); UI.hideTorch(); UI.hideReticle();
                        setTimeout(()=>{ UI.showCapture(); /* no mostramos torch/reticle salvo que toque */ res(); }, ms);
                    } catch { res(); }
                });

                if (!this.isActive()) {
                    console.warn('[CAPTURE] no active view');
                    UI.setHint('No hay vista activa para capturar.');
                    return;
                }

                const ts = new Date().toISOString().replace(/[:.]/g,'-');
                const filename = `captura-${ts}.png`;

                // 1) Intento “ideal”: capturar pestaña (mezcla cámara+modelo)
                if (supportsTabCapture()) {
                    try {
                        console.log('[CAPTURE] trying getDisplayMedia');
                        const stream = await askTabCapture();
                        const track  = stream.getVideoTracks()[0];
                        // Método 1: ImageCapture.grabFrame()
                        try {
                            const imageCapture = new ImageCapture(track);
                            const bitmap = await imageCapture.grabFrame();
                            if (!bitmap || !bitmap.width || !bitmap.height) throw new Error('bitmap vacío');
                            const c = document.createElement('canvas');
                            c.width = bitmap.width; c.height = bitmap.height;
                            c.getContext('2d').drawImage(bitmap, 0, 0);
                            const blob = await new Promise(res => c.toBlob(res, 'image/png'));
                            if (!blob) throw new Error('toBlob falló');
                            saveBlob(blob, filename);
                            UI.setHint('✅ Captura guardada (cámara + modelo).');
                            stream.getTracks().forEach(t=>t.stop());
                            return;
                        } catch (grabErr) {
                            console.warn('[CAPTURE] grabFrame falló, probando vía <video>…', grabErr);
                            // Método 2: drawImage desde <video>
                            const v = document.createElement('video');
                            v.srcObject = stream;
                            await v.play();
                            await new Promise(r => {
                                const to = setTimeout(r, 180);
                                v.onloadeddata = () => { clearTimeout(to); r(); };
                            });
                            const w = v.videoWidth || innerWidth;
                            const h = v.videoHeight || innerHeight;
                            if (!w || !h) throw new Error('video sin dimensiones');
                            const c = document.createElement('canvas');
                            c.width = w; c.height = h;
                            c.getContext('2d').drawImage(v, 0, 0, w, h);
                            const blob = await new Promise(res => c.toBlob(res, 'image/png'));
                            if (!blob) throw new Error('toBlob falló');
                            saveBlob(blob, filename);
                            UI.setHint('✅ Captura guardada (cámara + modelo).');
                            stream.getTracks().forEach(t=>t.stop());
                            return;
                        }
                    } catch (e) {
                        console.error('[CAPTURE] getDisplayMedia falló o denegado:', e);
                        // Continua a fallbacks
                    }
                } else {
                    console.warn('[CAPTURE] getDisplayMedia no soportado en este navegador / WebView.');
                }

                // 2) Fallback: canvas 3D (solo modelo) si estamos en WebXR
                try {
                    if (this._state?.mode === 'android-webxr' && typeof this._state.controller.getCanvas === 'function') {
                        console.log('[CAPTURE] fallback canvas 3D');
                        const cnv = this._state.controller.getCanvas();
                        if (cnv) {
                            const blob = await new Promise(res => cnv.toBlob(res, 'image/png'));
                            if (blob) {
                                saveBlob(blob, `solo-3d-${filename}`);
                                UI.setHint('📸 Captura guardada (solo modelo 3D).');
                                return;
                            }
                        }
                    }
                } catch (e) {
                    console.error('[CAPTURE] error canvas 3D:', e);
                }

                // 3) Fallback: html2canvas para <model-viewer> (no mezcla cámara real)
                try {
                    if (UI.mv && window.html2canvas) {
                        console.log('[CAPTURE] fallback html2canvas model-viewer');
                        const node = UI.$fallback || UI.mv;
                        const cnv  = await window.html2canvas(node, { useCORS: true, backgroundColor: '#000' });
                        const blob = await new Promise(res => cnv.toBlob(res, 'image/png'));
                        if (!blob) throw new Error('toBlob falló en html2canvas');
                        saveBlob(blob, `fallback-${filename}`);
                        UI.setHint('📸 Captura guardada (visor 3D).');
                        return;
                    } else {
                        console.warn('[CAPTURE] html2canvas no disponible');
                    }
                } catch (e) {
                    console.error('[CAPTURE] error html2canvas:', e);
                }

                // 4) Sin soporte de captura → guía para screenshot del sistema (mezcla cámara+modelo)
                console.warn('[CAPTURE] sin soporte de mezcla en este navegador. Sugerir captura del sistema.');
                UI.setHint('Tu navegador no permite mezclar cámara+modelo. Usa captura del sistema (Power+Vol ↓). Ocultando UI 2s…');
                await hideUiForScreenshot(2000);
            }

        }

        const Viewer = new ViewerOrchestrator();

        /* ============== DeviceObservers ============================ */
        class DeviceObservers {
            static attach() {
                // Salir inmediatamente si la pestaña/app se oculta (bloqueo)
                document.addEventListener('visibilitychange', async () => {
                    if (document.visibilityState === 'hidden') {
                        if (Viewer.state.mode === 'android-webxr') await Viewer.destroy();
                    } else if (document.visibilityState === 'visible') {
                        StaleGuard.onResume();
                    }
                });
                window.addEventListener('pageshow', () => StaleGuard.onResume());
                window.addEventListener('pagehide', () => StaleGuard.onSuspend());
                if (screen.orientation?.addEventListener) screen.orientation.addEventListener('change', () => console.log('[orientation]', screen.orientation.type, screen.orientation.angle));
                window.addEventListener('orientationchange', () => console.log('[orientation-legacy]', window.orientation));
                window.addEventListener('online', () => console.log('[net] online'));
                window.addEventListener('offline', () => console.log('[net] offline'));
                window.addEventListener('resize', () => console.log('[resize]', innerWidth, innerHeight));
                visualViewport?.addEventListener('resize', () => console.log('[vv]', visualViewport.width, visualViewport.height, visualViewport.offsetTop));
                document.addEventListener('fullscreenchange', () => console.log('[fullscreen]', !!document.fullscreenElement));
            }
        }

        /* ============== Datos (ejemplo) ============================ */
        const itemsSources = [
            {
                id: "taita", title: "Taita Imbabura – El Abuelo que todo lo ve", subtitle: "Ñawi Hatun Yaya",
                description: "Sabio y protector, guardián del viento y ciclos de la tierra.",
                position: {lat: 0.20477, lng: -78.20639},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/taita-imbabura-toon-1.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/taita-imbabura.png'
                }
            },
            {
                id: "cerro-cusin", title: "Cusin – El guardián del paso fértil", subtitle: "Allpa ñampi rikchar",
                description: "Cusin camina con paso firme cuidando las chacras y senderos.",
                position: {lat: 0.20435, lng: -78.20688},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/cusin.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/elcusin.png'
                }
            },
            {
                id: "mojanda", title: "Mojanda – El susurro del páramo", subtitle: "Sachayaku mama",
                description: "Entre neblinas y lagunas, hilos del agua fría que purifica.",
                position: {lat: 0.20401, lng: -78.20723},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/mojanda.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/mojanda.png'
                }
            },
            {
                id: "mama-cotacachi",
                title: "Mama Cotacachi – Madre de la Pachamama",
                subtitle: "Allpa mama- Warmi Rasu",
                description: "Dulce y poderosa, cuida los ciclos de la vida.",
                position: {lat: 0.20369, lng: -78.20759},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/mama-cotacachi.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/warmi-razu.png'
                }
            },
            {
                id: "coraza", title: "El Coraza – Espíritu de la celebración", subtitle: "Kawsay Taki",
                description: "Orgullo y memoria viva de lucha y honor.",
                position: {lat: 0.20349, lng: -78.20779},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/coraza-one.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/elcoraza.png'
                }
            },
            {
                id: "lechero", title: "El Lechero – Árbol del Encuentro y los Deseos", subtitle: "Kawsay ranti",
                description: "Testigo de promesas, abrazos y despedidas.",
                position: {lat: 0.20316, lng: -78.20790},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/lechero.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/lechero.png'
                }
            },
            {
                id: "lago-san-pablo", title: "Yaku Mama – La Laguna Viva", subtitle: "Yaku Mama – Kawsaycocha",
                description: "Sus aguas te abrazan con calma, reflejando tu esencia.",
                position: {lat: 0.20284, lng: -78.20802},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/lago-san-pablo.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/yaku-mama.png'
                }
            },
            {
                id: "ayahuma-pacha", title: "Ayahuma", subtitle: "Aya huma",
                description: "Ayahuma.",
                position: {lat: 0.20184, lng: -78.20902},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/pacha/ayahuma.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/pacha/images/ayahuma.jpeg'
                }
            }, {
                id: "corazon-pacha", title: "Corazon Pacha", subtitle: "Corazon Pacha",
                description: "Corazon Pacha.",
                position: {lat: 0.20084, lng: -78.21002},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/pacha/corazon.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/pacha/images/corazon.jpeg'
                }
            },
        ];

        /* ============== Bootstrap ================================= */
        window.addEventListener('DOMContentLoaded', () => {
            UI.init();
            DeviceObservers.attach();

            // Mapa
            const MAP_CONFIG = Object.freeze({
                zoom: 14, maxZoom: 25,
                position: [0.20830, -78.22798],
                tileUrl: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                tileAttribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contribuyentes'
            });
            const mapCtl = new MapController(MAP_CONFIG);
            mapCtl.init(itemsSources);

            // Retícula: solo para COLOCAR (la cámara se abre en el click del popup)
            UI.reticle?.addEventListener('click', async () => {
                await Viewer.handleReticleTap();
            });

            // Botones de control
            UI.btnBack?.addEventListener('click', async () => {
                await Viewer.destroy();
            });
            UI.btnCapture?.addEventListener('click', async () => {
                await Viewer.capture();
            });
            UI.btnTorch?.addEventListener('click', async () => {
                const ok = await Torch.on();
                UI.setHint(ok ? 'Linterna activada.' : 'No se pudo activar la linterna en este dispositivo.');
            });
        });
    </script>

@endsection
@section('content')
    <div id="hint">Estado: listo</div>

    <div class="controls">
        <div class="container--custom not-view">
            <div id="ar-loading"
                 class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-75 d-flex justify-content-center align-items-center d-none"
                 style="z-index:9999;">
                <div class="spinner-border text-light" role="status" style="width: 4rem; height: 4rem;"></div>
            </div>
            <!-- Fallback cuando no hay WebXR -->
            <div id="fallback" class="d-none">
                <model-viewer id="mv" src="" ios-src=""
                              ar ar-modes="scene-viewer quick-look webxr"
                              camera-controls environment-image="neutral"
                              style="width:100%;height:60vh;background:#000">
                </model-viewer>
            </div>
        </div>
    </div>

    <!-- Retícula (tap aquí para iniciar/colocar SIEMPRE) -->
    <div id="reticle-overlay" class="hidden" aria-hidden="true">
        <div class="reticle__ring"></div>
        <div class="reticle__dot"></div>
        <div class="reticle__hint">Toca la retícula para colocar</div>
    </div>

    <button id="btn-back-map" class="d-none">← Volver al mapa</button>
    <button id="btn-capture" class="d-none" title="Capturar vista">📸 Capturar</button>

    <div id="map"></div>
@endsection
