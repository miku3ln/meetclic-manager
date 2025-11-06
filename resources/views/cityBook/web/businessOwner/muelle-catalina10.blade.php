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


        /* ===== Popup BEM ===== */
        .popup-card {
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            color: #1f2937;
        }

        .popup-card__header {
            display: grid;
            grid-template-columns: 100px 1fr;
            gap: 10px;
            align-items: center;
            margin-bottom: 8px;
        }

        .popup-card__img {
            width: 100px;
            height: auto;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
        }

        .popup-card__titles {
            min-width: 0;
        }

        .popup-card__title {
            font-size: 14px;
            line-height: 1.2;
            margin: 0 0 4px 0;
            font-weight: 700;
        }

        .popup-card__subtitle {
            font-size: 12px;
            opacity: .7;
            margin: 0;
        }

        .popup-card__body {
            margin: 8px 0 10px;
        }

        .popup-card__description {
            margin: 0 0 8px 0;
            font-size: 12px;
            line-height: 1.35;
        }

        .popup-card__meta {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 4px;
            font-size: 11px;
        }

        .popup-card__meta-item {
            display: flex;
            gap: 6px;
        }

        .popup-card__meta-key {
            opacity: .7;
        }

        .popup-card__meta-value {
            font-weight: 600;
        }

        .popup-card__footer {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .popup-card__btn {
            appearance: none;
            border: 1px solid #d1d5db;
            background: #ffffff;
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            color: #111827;
        }

        .popup-card__btn--primary {
            background: #4C4CFF; /* azulClic */
            border-color: #4C4CFF;
            color: #fff;
        }

        .popup-card__btn--ghost:hover,
        .popup-card__btn--primary:hover {
            filter: brightness(0.95);
        }


        /* Retícula overlay (iOS/Web y como pista visual en Android) */
        .reticle {
            position: fixed;
            inset: 0;
            display: grid;
            place-items: center;
            pointer-events: none;
            z-index: 9998;
        }
        .reticle.hidden { display: none; }
        .reticle__ring {
            width: 120px; height: 120px; border-radius: 50%;
            border: 3px solid rgba(0,229,255,.95);
            animation: pulse 1.2s ease-in-out infinite;
            box-shadow: 0 0 10px rgba(0,229,255,.6);
        }
        .reticle__dot {
            position: absolute;
            width: 14px; height: 14px; border-radius: 50%;
            background: rgba(0,229,255,1);
            box-shadow: 0 0 8px rgba(0,229,255,.6);
        }
        .reticle__hint {
            position: absolute; top: calc(50% + 90px);
            background: rgba(0,0,0,.55);
            padding: 6px 10px; border-radius: 8px;
            font: 13px/1.2 system-ui, Arial, sans-serif;
            color: #fff;
        }
        @keyframes pulse {
            0% { transform: scale(0.95); }
            50% { transform: scale(1.05); }
            100% { transform: scale(0.95); }
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
        const Platform = (() => {
            const ua = navigator.userAgent || navigator.vendor || "";
            const isAndroid = /Android/i.test(ua);
            const isIOS = /iPhone|iPad|iPod/i.test(ua) ||
                (navigator.platform === "MacIntel" && navigator.maxTouchPoints > 1);
            const isSecure = location.protocol === "https:" || location.hostname === "localhost";

            async function webxrAvailable() {
                if (!isSecure || !("xr" in navigator)) return false;
                try { return await navigator.xr.isSessionSupported("immersive-ar"); }
                catch { return false; }
            }

            async function decideMode() {
                if (isAndroid && await webxrAvailable()) return "android-webxr";
                if (isIOS) return "ios-quicklook";
                return "web-fallback";
            }

            return { isAndroid, isIOS, isSecure, decideMode };
        })();

        /* ==============================
         * UI helpers
         * ============================== */
        const UI = (() => {
            const $loading = document.getElementById("ar-loading");
            const $fallback = document.getElementById("fallback");
            const $mv = document.getElementById("mv");
            const $hint = document.getElementById("hint");
            const container = document.querySelector(".container--custom");
            const $reticle = document.getElementById("reticle-overlay");

            const show = el => el && el.classList.remove("d-none");
            const hide = el => el && el.classList.add("d-none");

            function setHint(msg){ if ($hint) $hint.textContent = msg; }
            function showLoading(){ $loading?.classList.remove("d-none"); }
            function hideLoading(){ $loading?.classList.add("d-none"); }
            function showFallback(){ show($fallback); }
            function hideFallback(){ hide($fallback); }
            function revealContainer(){ container?.classList.remove("not-view"); }

            function showReticle(){ $reticle?.classList.remove("hidden"); }
            function hideReticle(){ $reticle?.classList.add("hidden"); }

            return { setHint, showLoading, hideLoading, showFallback, hideFallback, revealContainer, showReticle, hideReticle, $mv, container };
        })();

        /* ==============================
         * Fallback <model-viewer>
         * ============================== */
        class ModelViewerController {
            constructor(mvEl, hooks = {}) {
                this.mv = mvEl;
                this.hooks = hooks;
                this._bind();
            }

            _bind() {
                if (!this.mv) return;

                // Entrar / salir AR (Quick Look / Scene Viewer)
                this._arStatusHandler = (ev) => {
                    const st = ev?.detail?.status; // 'session-started' | 'object-placed' | 'not-presenting'
                    if (st === "session-started") { UI.hideReticle(); this.hooks.onEnter && this.hooks.onEnter({ mode: "ios/web-ar" }); }
                    if (st === "not-presenting") { UI.showReticle(); this.hooks.onExit && this.hooks.onExit({ reason: "ar-status", status: st }); }
                };
                this.mv.addEventListener("ar-status", this._arStatusHandler);

                // Cambios de cámara (rota/zoom)
                this._cameraChangeHandler = () => {
                    const orbit = this.mv.getCameraOrbit?.();
                    this.hooks.onRotate && this.hooks.onRotate({ rotY: orbit?.theta ?? 0, rotX: orbit?.phi ?? 0 });
                    this.hooks.onScale && this.hooks.onScale({ scale: orbit?.radius ?? 0 });
                };
                this.mv.addEventListener("camera-change", this._cameraChangeHandler);

                // Click en visor
                this._clickHandler = () => {
                    this.hooks.onModelClick && this.hooks.onModelClick({ modo: "fallback", punto: null });
                };
                this.mv.addEventListener("click", this._clickHandler);

                // Carga/errores
                this._loadHandler = () => UI.setHint("Modelo cargado en visor 3D.");
                this._errorHandler = () => UI.setHint("Error al cargar en visor 3D.");
                this.mv.addEventListener("load", this._loadHandler);
                this.mv.addEventListener("error", this._errorHandler);
            }

            setSource({ glbUrl, usdzUrl }) {
                if (!this.mv) return;
                this.mv.src = glbUrl || "";
                if (usdzUrl) this.mv.setAttribute("ios-src", usdzUrl);
                else this.mv.removeAttribute("ios-src");
                // Mostrar retícula en modo visor
                UI.showReticle();
            }

            async launchARIfPossible() {
                if (!this.mv) return;
                try {
                    if (typeof this.mv.activateAR === "function") {
                        this.hooks.onEnter && this.hooks.onEnter({ mode: "ios-quicklook" });
                        UI.hideReticle(); // al saltar a AR nativa
                        this.mv.activateAR();
                    }
                } catch {}
            }

            destroy() {
                if (!this.mv) return;
                this.mv.removeEventListener("ar-status", this._arStatusHandler);
                this.mv.removeEventListener("camera-change", this._cameraChangeHandler);
                this.mv.removeEventListener("click", this._clickHandler);
                this.mv.removeEventListener("load", this._loadHandler);
                this.mv.removeEventListener("error", this._errorHandler);
                this.mv.src = "";
                this.mv.removeAttribute("ios-src");
                UI.hideReticle();
            }
        }

        /* ==============================
         * Android WebXR SIN hit-test
         * - retícula 3D centrada a distancia fija
         * - coloca al tocar (o auto-coloca tras un delay)
         * ============================== */
        class AndroidWebXRController {
            constructor(options = {}) {
                this.container = options.container || document.body;
                this.hooks = options;

                this.renderer = null;
                this.scene = null;
                this.camera = null;
                this.session = null;
                this.model = null;

                this._distanceMeters = 1.2;
                this._reticle3D = null;
                this._placed = false;
                this._autoPlaceDelayMs = 900; // si no toca, autocolocar luego de ~0.9s

                this._loop = this._onXRFrame.bind(this);
                this._onResize = this._handleResize.bind(this);

                // Gestos
                this._drag = { active:false, id:null, lastX:0, lastY:0 };
                this._pinch = { active:false, id1:null, id2:null, startDist:0, startScale:1 };
                this._activePointers = new Map();
            }

            async start({ glbUrl }) {
                await this._setupRenderer();
                await this._startSession();
                await this._setupScene();

                await this._loadModel(glbUrl);

                // Mostrar retícula al inicio
                UI.showReticle();
                this._ensureReticle3D();

                // Si el usuario toca, colocar; si no, autocolocar tras un breve delay
                this._bindCanvasGestures();
                setTimeout(() => { if (!this._placed) this._placeModelAtReticle(); }, this._autoPlaceDelayMs);

                window.addEventListener("resize", this._onResize);
                this.hooks.onEnter && this.hooks.onEnter({ mode: "android-webxr" });
            }

            async setSource({ glbUrl }) {
                this._disposeModel();
                this._placed = false;
                await this._loadModel(glbUrl);
                UI.showReticle();
                this._ensureReticle3D();
            }

            async stop() {
                this._unbindCanvasGestures();
                try { window.removeEventListener("resize", this._onResize); } catch {}
                try { this.renderer?.setAnimationLoop(null); } catch {}

                this._disposeModel();
                if (this._reticle3D) { this.scene?.remove(this._reticle3D); this._reticle3D.geometry?.dispose?.(); this._reticle3D.material?.dispose?.(); this._reticle3D = null; }

                if (this.session) {
                    try { await this.session.end(); } catch {}
                    this.session.removeEventListener("end", this._onSessionEnd);
                    this.session.removeEventListener("visibilitychange", this._onVisibility);
                }

                if (this.renderer?.domElement?.parentNode) {
                    this.renderer.domElement.parentNode.removeChild(this.renderer.domElement);
                }
                try { this.renderer?.dispose?.(); } catch {}

                this.renderer = null;
                this.scene = null;
                this.camera = null;
                this.session = null;
                UI.hideReticle();
            }

            /* ---------- internos ---------- */
            async _setupRenderer() {
                if (this.renderer) return;
                this.renderer = new THREE.WebGLRenderer({ antialias:true, alpha:true });
                this.renderer.xr.enabled = true;
                this.renderer.setPixelRatio(Math.min(window.devicePixelRatio||1, 2));
                this._fit();
                this.container.appendChild(this.renderer.domElement);
            }

            async _startSession() {
                this.session = await navigator.xr.requestSession("immersive-ar", {
                    requiredFeatures: ["local"],
                    optionalFeatures: ["dom-overlay"],
                    domOverlay: { root: this.container }
                });
                this.renderer.xr.setReferenceSpaceType("local");
                await this.renderer.xr.setSession(this.session);

                // salida / blur
                this._onSessionEnd = () => {
                    this.hooks.onExit && this.hooks.onExit({ reason:"session-end" });
                    UI.showReticle();
                };
                this._onVisibility = () => {
                    const state = this.session?.visibilityState; // 'visible' | 'visible-blurred' | 'hidden'
                    if (state === "hidden" || state === "visible-blurred") {
                        this.hooks.onExit && this.hooks.onExit({ reason:"visibility", state });
                        UI.showReticle();
                    }
                };
                this.session.addEventListener("end", this._onSessionEnd);
                this.session.addEventListener("visibilitychange", this._onVisibility);
            }

            async _setupScene() {
                this.scene = new THREE.Scene();
                const aspect = Math.max(innerWidth,1)/Math.max(innerHeight,1);
                this.camera = new THREE.PerspectiveCamera(60, aspect, 0.01, 20);

                const hemi = new THREE.HemisphereLight(0xffffff, 0x404040, 1.0);
                const dir = new THREE.DirectionalLight(0xffffff, 0.8);
                dir.position.set(0,1,-1);
                this.scene.add(hemi, dir);

                this.renderer.setAnimationLoop(this._loop);
            }

            _ensureReticle3D() {
                if (this._reticle3D) return;
                const ringGeo = new THREE.RingGeometry(0.09, 0.12, 48);
                ringGeo.rotateX(-Math.PI/2);
                const ringMat = new THREE.MeshBasicMaterial({ color: 0x00e5ff, transparent: true, opacity: 0.96 });
                const ring = new THREE.Mesh(ringGeo, ringMat);

                const dotGeo = new THREE.CircleGeometry(0.028, 24);
                dotGeo.rotateX(-Math.PI/2);
                const dotMat = new THREE.MeshBasicMaterial({ color: 0x00e5ff, transparent: true, opacity: 1.0 });
                const dot = new THREE.Mesh(dotGeo, dotMat);
                dot.position.set(0, 0.002, 0);
                ring.add(dot);

                ring.visible = true;
                this._reticle3D = ring;
                this.scene.add(this._reticle3D);
            }

            _updateReticlePose() {
                if (!this._reticle3D || !this.camera) return;
                const fwd = new THREE.Vector3(0,0,-1).applyQuaternion(this.camera.quaternion).normalize();
                const pos = new THREE.Vector3().copy(this.camera.position).add(fwd.multiplyScalar(this._distanceMeters));
                this._reticle3D.position.copy(pos);
                this._reticle3D.quaternion.copy(this.camera.quaternion);
            }

            async _loadModel(glbUrl) {
                if (!glbUrl) return;
                UI.showLoading();
                await new Promise((res, rej) => {
                    new THREE.GLTFLoader().load(glbUrl, (gltf)=>{
                        this.model = gltf.scene;
                        this._prepareModel(this.model);
                        // NO colocar aún: esperamos al toque o al autoplacement
                        UI.setHint("Listo para colocar (toca para fijar).");
                        UI.hideLoading();
                        res();
                    }, undefined, (err)=>{ UI.hideLoading(); UI.setHint("Error al cargar modelo."); rej(err); });
                });
            }

            _prepareModel(root) {
                root.traverse(o=>{
                    if (!o.isMesh) return;
                    o.frustumCulled = false;
                    const m = o.material;
                    if (m) {
                        if (Array.isArray(m)) m.forEach(mm=> mm.side = THREE.DoubleSide);
                        else m.side = THREE.DoubleSide;
                    }
                });
                root.scale.set(1,1,1);
            }

            _placeModelAtReticle() {
                if (this._placed || !this.model || !this._reticle3D) return;
                this.model.position.copy(this._reticle3D.position);
                // orientar a la cámara pero manteniendo nivelado
                const look = new THREE.Vector3().copy(this.camera.position);
                this.model.lookAt(look.x, this.model.position.y, look.z);
                this.scene.add(this.model);
                this._placed = true;
                UI.hideReticle();
                UI.setHint("Modelo colocado.");
                // click de “modelo” simulado en esa posición (evento externo)
                this.hooks.onModelClick && this.hooks.onModelClick({ modo:"webxr", punto: this.model.position.clone() });
            }

            _onXRFrame() {
                // Actualiza postura de la retícula centrada
                this._updateReticlePose();
                this.renderer.render(this.scene, this.camera);
            }

            _fit() {
                if (!this.renderer) return;
                const w = Math.max(innerWidth,1), h = Math.max(innerHeight,1);
                this.renderer.setSize(w, h);
                if (this.camera && h>0) {
                    this.camera.aspect = w / h;
                    this.camera.updateProjectionMatrix();
                }
            }
            _handleResize(){ this._fit(); }

            _disposeModel() {
                if (!this.model) return;
                this.scene?.remove(this.model);
                this.model.traverse(o=>{
                    if (o.isMesh) {
                        o.geometry?.dispose?.();
                        const m = o.material;
                        if (Array.isArray(m)) m.forEach(mm=> mm?.dispose?.());
                        else m?.dispose?.();
                    }
                });
                this.model = null;
                this._placed = false;
            }

            /* -------- Gestos -------- */
            _bindCanvasGestures() {
                const cvs = this.renderer?.domElement;
                if (!cvs) return;

                this._down = (e)=>{
                    this._activePointers.set(e.pointerId, {x:e.clientX, y:e.clientY, type:e.pointerType});

                    // Si aún no está colocado, el primer toque fija el modelo en la retícula
                    if (!this._placed) { this._placeModelAtReticle(); return; }

                    // Si ya está colocado, permite interacción
                    this._drag.active = true; this._drag.id = e.pointerId; this._drag.lastX = e.clientX; this._drag.lastY = e.clientY;

                    // Inicial pinch
                    if (e.pointerType === "touch") {
                        if (!this._pinch.active && this._pinch.id1===null) this._pinch.id1 = e.pointerId;
                        else if (!this._pinch.active && this._pinch.id2===null) {
                            this._pinch.id2 = e.pointerId; this._pinch.active = true; this._pinch.startDist = 0; this._pinch.startScale = this.model?.scale?.x ?? 1;
                        }
                    }

                    // “click” aproximado (raycast) si ya hay modelo
                    const hit = this._raycastFromPointer(e);
                    if (hit) {
                        this.hooks.onModelClick && this.hooks.onModelClick({ modo:"webxr", punto: hit.point || null });
                        this.hooks.onDragStart && this.hooks.onDragStart({evt:e, hit});
                    }
                };

                this._move = (e)=>{
                    this._activePointers.set(e.pointerId, {x:e.clientX, y:e.clientY, type:e.pointerType});
                    if (!this._placed || !this.model) return;

                    // pinch scale
                    if (this._pinch.active && (e.pointerId === this._pinch.id1 || e.pointerId === this._pinch.id2)) {
                        const p1 = this._activePointers.get(this._pinch.id1);
                        const p2 = this._activePointers.get(this._pinch.id2);
                        if (p1 && p2) {
                            const dx = p1.x - p2.x, dy = p1.y - p2.y;
                            const dist = Math.sqrt(dx*dx + dy*dy);
                            if (this._pinch.startDist === 0) this._pinch.startDist = dist || 1;
                            else if (dist > 0) {
                                const delta = (dist - this._pinch.startDist) * 0.005;
                                const next = Math.max(0.2, Math.min(10.0, (this._pinch.startScale || 1) + delta));
                                this.model.scale.set(next,next,next);
                                this.hooks.onScale && this.hooks.onScale({ scale: next });
                            }
                        }
                        return;
                    }

                    // drag -> rotación
                    if (this._drag.active && e.pointerId === this._drag.id) {
                        const dx = e.clientX - this._drag.lastX;
                        const dy = e.clientY - this._drag.lastY;
                        this._drag.lastX = e.clientX; this._drag.lastY = e.clientY;

                        this.model.rotation.y += dx * 0.015;
                        this.model.rotation.x = THREE.MathUtils.clamp(this.model.rotation.x - dy * 0.010, -Math.PI/2, Math.PI/2);
                        this.hooks.onRotate && this.hooks.onRotate({ rotY: this.model.rotation.y, rotX: this.model.rotation.x });
                        this.hooks.onDrag && this.hooks.onDrag({ dx, dy });
                    }
                };

                this._up = (e)=>{
                    this._activePointers.delete(e.pointerId);

                    // pinch off
                    if (this._pinch.active && (e.pointerId === this._pinch.id1 || e.pointerId === this._pinch.id2)) {
                        if (e.pointerId === this._pinch.id1) this._pinch.id1 = null;
                        if (e.pointerId === this._pinch.id2) this._pinch.id2 = null;
                        if (this._pinch.id1 == null || this._pinch.id2 == null) {
                            this._pinch.active = false; this._pinch.startDist = 0;
                        }
                    }

                    // drag off
                    if (this._drag.active && e.pointerId === this._drag.id) {
                        this._drag.active = false; this._drag.id = null;
                        this.hooks.onDragEnd && this.hooks.onDragEnd({ evt:e });
                    }
                };

                cvs.addEventListener("pointerdown", this._down, {passive:true});
                cvs.addEventListener("pointermove", this._move, {passive:true});
                cvs.addEventListener("pointerup", this._up, {passive:true});
                cvs.addEventListener("pointercancel", this._up, {passive:true});
            }

            _unbindCanvasGestures() {
                const cvs = this.renderer?.domElement;
                if (!cvs) return;
                cvs.removeEventListener("pointerdown", this._down);
                cvs.removeEventListener("pointermove", this._move);
                cvs.removeEventListener("pointerup", this._up);
                cvs.removeEventListener("pointercancel", this._up);
            }

            _raycastFromPointer(e) {
                if (!this.model || !this.camera || !this.renderer) return null;
                const rect = this.renderer.domElement.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 2 - 1;
                const y = -((e.clientY - rect.top) / rect.height) * 2 + 1;
                const ndc = new THREE.Vector2(x,y);
                const rc = new THREE.Raycaster();
                rc.setFromCamera(ndc, this.camera);
                const hits = rc.intersectObject(this.model, true);
                return (hits && hits.length) ? hits[0] : null;
            }
        }

        /* ==============================
         * Orquestador / API pública
         * ============================== */
        const Viewer = (() => {
            let mode = null;
            let controller = null;

            async function init({ glbUrl, usdzUrl, hooks = {} }) {
                mode = await Platform.decideMode();
                UI.revealContainer();

                if (mode === "android-webxr") {
                    UI.hideFallback();
                    controller = new AndroidWebXRController({
                        container: document.body,
                        ...hooks
                    });
                    await controller.start({ glbUrl });
                } else {
                    UI.showFallback();
                    controller = new ModelViewerController(UI.$mv, { ...hooks });
                    controller.setSource({ glbUrl, usdzUrl });
                    // En visor mostramos la retícula overlay
                    UI.showReticle();
                    if (Platform.isIOS && usdzUrl) setTimeout(()=> controller.launchARIfPossible(), 150);
                }
                UI.setHint(`Modo: ${mode}`);
            }

            async function setSource({ glbUrl, usdzUrl }) {
                if (!controller) return;
                if (mode === "android-webxr") {
                    await controller.setSource({ glbUrl });
                } else {
                    controller.setSource({ glbUrl, usdzUrl });
                    UI.showReticle();
                }
            }

            async function destroy() {
                if (!controller) return;
                if (mode === "android-webxr") await controller.stop();
                else controller.destroy();
                controller = null; mode = null;
                UI.hideFallback();
                UI.hideReticle();
                UI.setHint("Listo.");
            }

            return { init, setSource, destroy };
        })();

        /* ==============================
         * Enlaces globales
         * ============================== */
        async function initViewAr(params) {
            const { glbUrl = "", usdzUrl = "" } = params || {};
            const hooks = {
                onEnter: ({ mode }) => UI.setHint(`Cámara iniciada (${mode}).`),
                onExit: ({ reason, state, status }) => {
                    UI.showFallback();  // al salir, volver al visor 3D
                    UI.showReticle();   // y mostrar retícula overlay
                    UI.setHint(`Sesión finalizada (${reason || status || state || "desconocido"}).`);
                },
                onModelClick: ({ modo, punto }) => {
                    const p = punto ? `${p.x?.toFixed?.(2)}, ${p.y?.toFixed?.(2)}, ${p.z?.toFixed?.(2)}` : "—";
                    UI.setHint(`Click sobre modelo (${modo}) en ${p}`);
                },
                onDragStart: () => UI.setHint("Arrastre iniciado."),
                onDrag: ({ dx, dy }) => UI.setHint(`Arrastrando dx=${dx} dy=${dy}`),
                onDragEnd: () => UI.setHint("Arrastre finalizado."),
                onScale: ({ scale }) => UI.setHint(`Escala: ${Number(scale).toFixed(2)}`),
                onRotate: ({ rotY, rotX }) => UI.setHint(`Rotación Y=${Number(rotY).toFixed(2)} X=${Number(rotX).toFixed(2)}`)
            };
            await Viewer.init({ glbUrl, usdzUrl, hooks });
        }

        async function viewerSetSource(params) {
            const { glbUrl = "", usdzUrl = "" } = params || {};
            await Viewer.setSource({ glbUrl, usdzUrl });
        }

        async function destroyViewAr() {
            await Viewer.destroy();
        }
        // Exponer para extensiones si es necesario


        /* =======================
         * Bootstrap de la app
         * ======================= */
        let itemsSources = [{
            id: "taita",
            title: "Taita Imbabura – El Abuelo que todo lo ve",
            subtitle: "Ñawi Hatun Yaya",
            description: "Sabio y protector, es el guardián del viento y de los ciclos de la tierra. Desde su cima, observa en silencio el camino que estás por recorrer.",
            position: {lat: 0.20477, lng: -78.20639},
            sources: {
                glb: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/taita-imbabura-toon-1.glb',
                img: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/images/taita-imbabura.png'
            }
        },
            {
                id: "cerro-cusin",
                title: "Cusin – El guardián del paso fértil",
                subtitle: "Allpa ñampi rikchar",
                description: "Alegre y trabajador, Cusin camina con paso firme cuidando las chacras y senderos que alimentan la vida.",
                position: {lat: 0.20435, lng: -78.20688},

                sources: {
                    glb: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/cusin.glb',
                    img: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/images/elcusin.png'
                }
            },
            {
                id: "mojanda",
                title: "Mojanda – El susurro del páramo",
                subtitle: "Sachayaku mama",
                description: "Entre neblinas y lagunas, Mojanda teje los hilos del agua fría que purifica y renueva. Su silencio es fuerza.",
                position: {lat: 0.20401, lng: -78.20723},

                sources: {
                    glb: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/taita-imbabura-otro.glb',
                    img: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/images/mojanda.png'

                }
            },
            {
                id: "mama-cotacachi",
                title: "Mama Cotacachi – Madre de la Pachamama",
                subtitle: "Allpa mama- Warmi Rasu",
                description: "Dulce y poderosa, Mama Cotacachi cuida los ciclos de la vida. Su calma abraza a quien camina con respeto.",
                position: {lat: 0.20369, lng: -78.20759},

                sources: {
                    glb: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/mama-cotacachi.glb',
                    img: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/images/warmi-razu.png'

                }
            },
            {
                id: "coraza",
                title: "El Coraza – Espíritu de la celebración",
                subtitle: "Kawsay Taki",
                description: "Representa el orgullo y la dignidad de su pueblo. Su danza no es solo alegría, es memoria viva de lucha y honor.",
                position: {lat: 0.20349, lng: -78.20779},

                sources: {
                    glb: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/coraza-one.glb',
                    img: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/images/elcoraza.png'

                }
            },
            {
                id: "lechero",
                title: "El Lechero – Árbol del Encuentro y los Deseos",
                subtitle: "Kawsay ranti",
                description: "Testigo de promesas, abrazos y despedidas. Desde sus ramas, el mundo parece un sueño.",
                position: {lat: 0.20316, lng: -78.20790},

                sources: {
                    glb: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/other.glb',
                    img: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/images/lechero.png'

                }
            },
            {
                id: "lago-san-pablo",
                title: "Yaku Mama – La Laguna Viva",
                subtitle: "Yaku Mama – Kawsaycocha",
                description: "Aquí termina el camino, pero comienza la conexión. Sus aguas te abrazan con calma, reflejando tu propia esencia.",
                position: {lat: 0.20284, lng: -78.20802},

                sources: {
                    glb: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/lago-san-pablo.glb',
                    img: window.$dataManagerPage['public-root'] + '/simi-rura/muelle-catalina/images/yaku-mama.png'

                }
            },


        ];

        $(function () {


            initMap();
        });
        // ===============================
        // Estado global (mínimo y explícito)
        // ===============================
        let map;
        let markerLayer;
        let markersAllInit = [];   // Clicks libres del usuario
        let markersAll = [];       // Todos los L.Marker creados (items + ad hoc)
        let markersById = {};      // Acceso rápido: id -> L.Marker

        // ===============================
        // Configuración del mapa
        // ===============================
        const MAP_CONFIG = Object.freeze({
            zoom: 14,
            maxZoom: 25,
            position: [0.20830, -78.22798],
            tileUrl: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            tileAttribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contribuyentes'
        });

        // ===============================
        // Utilidades de Marker
        // ===============================
        function createMarkerIcon(item) {
            return L.icon({
                iconUrl: item.sources.img,  // 🔑 usa la imagen del item
                iconSize: [44, 44],
                iconAnchor: [22, 44],
                popupAnchor: [0, -40]
            });
        }

        function createPopupContent(item) {
            // BEM: popup-card como bloque, elementos __img, __title, etc.
            // Usa todas las partes del array: id, title, subtitle, description, sources (img/glb)
            return `
    <article class="popup-card" data-popup-id="${item.id}">
      <header class="popup-card__header">
        <img class="popup-card__img" src="${item.sources.img}" alt="${item.title}" loading="lazy">
        <div class="popup-card__titles">
          <h4 class="popup-card__title">${item.title}</h4>
          <p class="popup-card__subtitle">${item.subtitle}</p>
        </div>
      </header>

      <section class="popup-card__body">
        <p class="popup-card__description">${item.description}</p>
        <ul class="popup-card__meta not-view">
          <li class="popup-card__meta-item">
            <span class="popup-card__meta-key">ID:</span>
            <span class="popup-card__meta-value">${item.id}</span>
          </li>
          <li class="popup-card__meta-item">
            <span class="popup-card__meta-key">Lat:</span>
            <span class="popup-card__meta-value">${item.position.lat}</span>
          </li>
          <li class="popup-card__meta-item">
            <span class="popup-card__meta-key">Lng:</span>
            <span class="popup-card__meta-value">${item.position.lng}</span>
          </li>
        </ul>
      </section>

      <footer class="popup-card__footer">
        <button class="popup-card__btn popup-card__btn--primary not-view"
                data-action="center"
                data-id="${item.id}">
          Centrar aquí
        </button>
        <a class="popup-card__btn popup-card__btn--ghost"
           source="${item.sources.glb}"  rel="noopener noreferrer">
          Ver en 3D
        </a>
      </footer>
    </article>
  `;
        }

        // ===============================
        // Render de marcadores (itemsSources)
        // ===============================
        function renderItemsMarkers(items) {
            if (!map) return;

            // Crea/limpia la capa de marcadores
            if (!markerLayer) {
                markerLayer = L.layerGroup().addTo(map);
            } else {
                markerLayer.clearLayers();
            }

            markersAll = [];
            markersById = {};

            const bounds = [];

            items.forEach((item) => {
                const {lat, lng} = item.position;

                const marker = L
                    .marker([lat, lng], {icon: createMarkerIcon(item), title: item.title})
                    .bindPopup(createPopupContent(item), {maxWidth: 320});

                marker.addTo(markerLayer);

                markersAll.push(marker);
                markersById[item.id] = marker;
                bounds.push([lat, lng]);

                // Tooltip (opcional)
                marker.bindTooltip(item.id, {direction: 'top'});
            });

            if (bounds.length) map.fitBounds(bounds, {padding: [40, 40]});
        }

        // ===============================
        // Helpers públicos
        // ===============================
        function flyToItem(id, zoom = 17) {
            const mk = markersById[id];
            if (!mk) return;
            const latLng = mk.getLatLng();
            map.flyTo(latLng, zoom, {duration: 0.8});
            mk.openPopup();
        }

        function clearItemsMarkers() {
            if (markerLayer) markerLayer.clearLayers();
            markersAll = [];
            markersById = {};
        }

        // ===============================
        // Inicialización del mapa (eventos + clicks ad hoc)
        // ===============================
        function initMap() {
            map = L.map('map', {zoomControl: true}).setView(MAP_CONFIG.position, MAP_CONFIG.zoom);

            L.tileLayer(MAP_CONFIG.tileUrl, {
                maxZoom: MAP_CONFIG.maxZoom,
                attribution: MAP_CONFIG.tileAttribution
            }).addTo(map);

            // Click libre: agrega marcador simple y guarda coordenadas
            map.on('click', (e) => {
                if (true) {
                    const {lat, lng} = e.latlng;
                    const mk = L.marker([lat, lng]).addTo(map)
                        .bindPopup(`Nuevo marcador:<br><code>${lat.toFixed(5)}, ${lng.toFixed(5)}</code>`)
                        .openPopup();

                    markersAllInit.push({lat, lng});
                    markersAll.push(mk);
                }
            });

            // Eventos de zoom (limpios)
            map.on('zoomstart', () => {
                console.log('[zoomstart] zoom actual:', map.getZoom());
            });
            map.on('zoomend', () => {
                const z = map.getZoom();
                console.log('[zoomend] nuevo zoom:', z, 'center:', map.getCenter());
                if (window.jQuery) $('#zoom-info').text(`Zoom: ${z}`);
            });

            // Delegación: acciones dentro de popups (BEM)
            map.on('popupopen', (e) => {
                const root = e.popup.getElement();
                if (!root) return;

                const centerBtn = root.querySelector('.popup-card__btn[data-action="center"]');
                if (centerBtn) {
                    centerBtn.addEventListener('click', () => {
                        const id = centerBtn.getAttribute('data-id');
                        flyToItem(id);
                    });
                }


                const viewBtn = root.querySelector('.popup-card__btn--ghost');
                if (!viewBtn) return;

                // Adjuntar handler
                viewBtn.addEventListener('click', (ev) => {
                    ev.preventDefault(); // evita saltar al "#"
                    const src = viewBtn.getAttribute('data-source')
                        || viewBtn.getAttribute('source');
                    console.log("ver data source",src);
                  //  reinitViewAr({ glbUrl: src });
                   // await   destroyViewAr();
                    initViewAr({ glbUrl:src, usdzUrl: src });
                    $("#map").addClass("not-view");

                }, { once: true });
            });

            // Render inicial
            renderItemsMarkers(itemsSources);

        }
        function initModel(){
            $(".popup-card__btn--ghost").on("click",function(){
                console.log(this.attr("source"));

                //       managerViewer.cfg.glbUr=
            })

        }





    </script>
@endsection
@section('content')
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
    <div id="reticle-overlay" class="reticle hidden" aria-hidden="true">
        <div class="reticle__ring"></div>
        <div class="reticle__dot"></div>
        <div class="reticle__hint">Apunta y toca para colocar</div>
    </div>
    <div id="map"></div>
@endsection
