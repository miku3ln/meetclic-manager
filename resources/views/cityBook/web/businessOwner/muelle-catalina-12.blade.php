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
        /* ==============================
     * Plataforma
     * ============================== */
        const Platform = (() => {
            const ua = navigator.userAgent || navigator.vendor || "";
            const isAndroid = /Android/i.test(ua);
            const isIOS = /iPhone|iPad|iPod/i.test(ua) || (navigator.platform === "MacIntel" && navigator.maxTouchPoints > 1);
            const isSecure = location.protocol === "https:" || location.hostname === "localhost";
            return { isAndroid, isIOS, isSecure };
        })();

        async function canUseAR() {
            if (!Platform.isAndroid || !Platform.isSecure || !('xr' in navigator)) return false;
            try { return await navigator.xr.isSessionSupported('immersive-ar'); }
            catch { return false; }
        }

        /* ==============================
         * UI helpers
         * ============================== */
        const UI = (() => {
            const $loading = function (){return  document.getElementById("ar-loading")};
            const $fallback = function (){return document.getElementById("fallback")};
            const $mv = function (){return document.getElementById("mv")};
            const $hint = function (){return document.getElementById("hint")};
            const container = function (){return document.querySelector(".container--custom")};
            const $reticle = function (){return document.getElementById("reticle-overlay")};
            const $map = function (){return document.getElementById("map")};
            const $btnBack = function (){return document.getElementById("btn-back-map")};
            const $btnCapture = function (){return document.getElementById("btn-capture")};

            const show = el => el && el.classList.remove("d-none");
            const hide = el => el && el.classList.add("d-none");

            function setHint(msg){ if ($hint()) $hint().textContent = msg; }
            function showLoading(){ $loading()?.classList.remove("d-none"); }
            function hideLoading(){ $loading()?.classList.add("d-none"); }
            function showFallback(){ show($fallback()); }
            function hideFallback(){ hide($fallback()); }
            function revealContainer(){ container()?.classList.remove("not-view"); }
            function showReticle(){ $reticle()?.classList.remove("hidden"); }
            function hideReticle(){ $reticle()?.classList.add("hidden"); }
            function hideMap(){ $map()?.classList.add("not-view"); $btnBack().classList.remove("d-none"); }
            function showMap(){ $map()?.classList.remove("not-view"); $btnBack()?.classList.add("d-none"); }
            function showCapture(){ $btnCapture()?.classList.remove("d-none"); }
            function hideCapture(){ $btnCapture()?.classList.add("d-none"); }

            return {
                setHint, showLoading, hideLoading, showFallback, hideFallback, revealContainer,
                showReticle, hideReticle, hideMap, showMap, showCapture, hideCapture,
                $mv, $btnCapture
            };
        })();

        /* ==============================
         * Utilidades descarga + stats
         * ============================== */
        function downloadDataUrl(filename, dataUrl){
            const a = document.createElement('a');
            a.href = dataUrl; a.download = filename;
            document.body.appendChild(a); a.click(); a.remove();
        }
        function downloadBlob(filename, blob){
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url; a.download = filename;
            document.body.appendChild(a); a.click(); a.remove();
            URL.revokeObjectURL(url);
        }
        function computeModelStats(root){
            if (!root) return null;
            const box = new THREE.Box3().setFromObject(root);
            const size = new THREE.Vector3(); box.getSize(size);
            let meshes = 0, tris = 0;
            root.traverse(o=>{
                if (o.isMesh && o.geometry){
                    meshes++;
                    const geo = o.geometry;
                    const triCount = geo.index ? (geo.index.count/3)
                        : (geo.attributes?.position ? geo.attributes.position.count/3 : 0);
                    tris += Math.floor(triCount);
                }
            });
            return {
                nodes: root.children?.length ?? 0,
                meshes,
                triangles: tris,
                bbox: { x: +size.x.toFixed(4), y: +size.y.toFixed(4), z: +size.z.toFixed(4) }
            };
        }

        /* ==============================
         * Fallback <model-viewer>
         * ============================== */
        class ModelViewerController {
            constructor(mvEl, hooks = {}) {
                this.mv = mvEl;
                this.hooks = hooks;
                this._bound = false;
            }
            bindOnce(){
                if (this._bound || !this.mv) return;
                this._bound = true;

                this._onARStatus = (ev) => {
                    const st = ev?.detail?.status;
                    if (st === "session-started") this.hooks.onEnter && this.hooks.onEnter({ mode: "ios/web-ar" });
                    if (st === "not-presenting") this.hooks.onExit && this.hooks.onExit({ reason: "ar-status", status: st });
                };
                this.mv.addEventListener("ar-status", this._onARStatus);

                this._onCameraChange = () => {
                    const orbit = this.mv.getCameraOrbit?.();
                    this.hooks.onRotate && this.hooks.onRotate({ rotY: orbit?.theta ?? 0, rotX: orbit?.phi ?? 0 });
                    this.hooks.onScale && this.hooks.onScale({ scale: orbit?.radius ?? 0 });
                };
                this.mv.addEventListener("camera-change", this._onCameraChange);

                this._onLoad = () => UI.setHint("Modelo cargado en visor 3D.");
                this._onError = () => UI.setHint("Error al cargar en visor 3D.");
                this.mv.addEventListener("load", this._onLoad);
                this.mv.addEventListener("error", this._onError);
            }
            async setSource({ glbUrl, usdzUrl }) {
                if (!this.mv) return;
                UI.showFallback();
                this.mv.src = glbUrl || "";
                if (usdzUrl) this.mv.setAttribute("ios-src", usdzUrl);
                else this.mv.removeAttribute("ios-src");

                await new Promise((res, rej)=>{
                    const onLoad = () => { this.mv.removeEventListener('load', onLoad); res(); };
                    const onErr  = () => { this.mv.removeEventListener('error', onErr); rej(); };
                    this.mv.addEventListener('load', onLoad, { once:true });
                    this.mv.addEventListener('error', onErr, { once:true });
                });
            }
            async activateARIfAny(){
                try{ if (typeof this.mv.activateAR === "function") this.mv.activateAR(); }catch{}
            }
            destroy(){
                if (!this.mv) return;
                this.mv.removeEventListener("ar-status", this._onARStatus);
                this.mv.removeEventListener("camera-change", this._onCameraChange);
                this.mv.removeEventListener("load", this._onLoad);
                this.mv.removeEventListener("error", this._onError);
                this.mv.src = ""; this.mv.removeAttribute("ios-src");
                this._bound = false;
            }
        }

        /* ==============================
         * Android WebXR (sin hit-test)
         * ============================== */
        class AndroidWebXRController {
            constructor(hooks = {}) {
                this.hooks = hooks;
                this.renderer = null;
                this.scene = null;
                this.camera = null;
                this.session = null;
                this.model = null;

                this._distanceMeters = 1.2;
                this._loop = this._onXRFrame.bind(this);
                this._onResize = this._handleResize.bind(this);
            }

            // DENTRO del tap a la retícula
            async startFromGesture(glbUrl){
                try{
                    this.session = await navigator.xr.requestSession("immersive-ar", {
                        requiredFeatures: ["local"],
                        optionalFeatures: ["dom-overlay"],
                        domOverlay: { root: document.body }
                    });
                }catch(e){ throw e; }

                this._setupRenderer();
                this._setupScene();
                this.renderer.xr.setReferenceSpaceType("local");
                await this.renderer.xr.setSession(this.session);

                this._onEnd = () => this.hooks.onExit && this.hooks.onExit({ reason: "session-end" });
                this._onVis = () => {
                    const s = this.session?.visibilityState;
                    if (s === "hidden" || s === "visible-blurred") {
                        this.hooks.onExit && this.hooks.onExit({ reason: "visibility", state: s });
                    }
                };
                this.session.addEventListener("end", this._onEnd);
                this.session.addEventListener("visibilitychange", this._onVis);

                await this._loadModel(glbUrl);
                this._bindGestures();

                window.addEventListener("resize", this._onResize);
                this.hooks.onEnter && this.hooks.onEnter({ mode:"android-webxr" });
            }

            async setSource({ glbUrl }){
                await this._disposeModel();
                await this._loadModel(glbUrl);
                this.placeInFront();
            }

            placeInFront(){ this._placeInFront(); }

            async stop(){
                try { window.removeEventListener("resize", this._onResize); } catch {}
                try { this.renderer?.setAnimationLoop(null); } catch {}
                await this._disposeModel();

                if (this.session){
                    try { await this.session.end(); } catch {}
                    this.session.removeEventListener("end", this._onEnd);
                    this.session.removeEventListener("visibilitychange", this._onVis);
                }
                if (this.renderer?.domElement?.parentNode) {
                    this.renderer.domElement.parentNode.removeChild(this.renderer.domElement);
                }
                try { this.renderer?.dispose?.(); } catch {}
                this.renderer = null; this.scene = null; this.camera = null; this.session = null;
            }

            _setupRenderer(){
                if (this.renderer) return;
                this.renderer = new THREE.WebGLRenderer({ antialias:true, alpha:true, powerPreference:'high-performance' });
                this.renderer.xr.enabled = true;
                this.renderer.outputEncoding = THREE.sRGBEncoding;
                this.renderer.setPixelRatio(Math.min(window.devicePixelRatio||1, 2));
                this._fit();
                document.body.appendChild(this.renderer.domElement);
            }
            _setupScene(){
                this.scene = new THREE.Scene();
                const aspect = Math.max(innerWidth,1)/Math.max(innerHeight,1);
                this.camera = new THREE.PerspectiveCamera(60, aspect, 0.01, 20);
                const hemi = new THREE.HemisphereLight(0xffffff, 0x404040, 1.0);
                const dir = new THREE.DirectionalLight(0xffffff, 0.85); dir.position.set(0,1,-1);
                this.scene.add(hemi, dir);
                this.renderer.setAnimationLoop(this._loop);
            }
            async _loadModel(glbUrl){
                if (!glbUrl) return;
                UI.showLoading();
                await new Promise((res, rej)=>{
                    const loader = new THREE.GLTFLoader();
                    loader.load(glbUrl, (gltf)=>{
                        this.model = gltf.scene;
                        // Normalizar escala ≈1m
                        const box = new THREE.Box3().setFromObject(this.model);
                        const size = new THREE.Vector3(); box.getSize(size);
                        const maxDim = Math.max(size.x, size.y, size.z) || 1;
                        const scale = 1 / maxDim;
                        this.model.scale.setScalar(scale);

                        this.model.traverse(o=>{
                            if (o.isMesh){
                                o.frustumCulled = false;
                                const m=o.material;
                                if (m){ Array.isArray(m)?m.forEach(mm=>mm.side=THREE.DoubleSide):m.side=THREE.DoubleSide; }
                            }
                        });
                        UI.hideLoading();
                        UI.setHint("Modelo listo. Toca la retícula para colocar.");
                        res();
                    }, undefined, (err)=>{ UI.hideLoading(); UI.setHint("Error al cargar modelo."); rej(err); });
                });
            }
            _placeInFront(){
                if (!this.model || !this.camera) return;
                const fwd = new THREE.Vector3(0,0,-1).applyQuaternion(this.camera.quaternion).normalize();
                const pos = new THREE.Vector3().copy(this.camera.position).add(fwd.multiplyScalar(this._distanceMeters));
                this.model.position.copy(pos);
                this.model.position.y -= 0.1;
                this.model.lookAt(this.camera.position.x, this.model.position.y, this.camera.position.z);
                if (!this.model.parent) this.scene.add(this.model);
                UI.setHint("Modelo colocado.");
            }
            _bindGestures(){
                let lastX=0, lastY=0, touching=false;
                const onMove = (dx,dy)=>{
                    if (!this.model) return;
                    this.model.rotation.y -= dx * 0.01;
                    this._distanceMeters = Math.min(3, Math.max(0.3, this._distanceMeters + dy * 0.002));
                    this._placeInFront();
                };
                const dom = this.renderer.domElement;
                dom.addEventListener('touchstart', e=>{ touching=true; lastX=e.touches[0].clientX; lastY=e.touches[0].clientY; }, {passive:true});
                dom.addEventListener('touchmove',  e=>{ if(!touching) return; const x=e.touches[0].clientX, y=e.touches[0].clientY; onMove(x-lastX, y-lastY); lastX=x; lastY=y; }, {passive:true});
                dom.addEventListener('touchend',  ()=> touching=false);
            }
            _onXRFrame(){ this.renderer.render(this.scene, this.camera); }
            _fit(){
                if (!this.renderer) return;
                const w = Math.max(innerWidth,1), h = Math.max(innerHeight,1);
                this.renderer.setSize(w, h);
                if (this.camera && h>0){ this.camera.aspect = w/h; this.camera.updateProjectionMatrix(); }
            }
            _handleResize(){ this._fit(); }

            async _disposeModel(){
                if (!this.model) return;
                this.scene?.remove(this.model);
                this.model.traverse(o=>{
                    if (o.isMesh){ o.geometry?.dispose?.(); const m=o.material; Array.isArray(m)?m.forEach(mm=>mm?.dispose?.()):m?.dispose?.(); }
                });
                this.model=null;
            }

            // === Para captura ===
            getCanvas(){ return this.renderer?.domElement || null; }
            getModelStats(){ return computeModelStats(this.model); }
        }

        /* ==============================
         * Orquestador / API
         * ============================== */
        const Viewer = (()=> {
            let mode = null;          // 'android-webxr' | 'web-fallback' | 'ios-quicklook' | null
            let controller = null;    // AndroidWebXRController | ModelViewerController
            let pendingSource = null; // { glbUrl, usdzUrl }

            function isActive(){ return !!controller; }

            async function onMarkerSourceSelected(glbUrl){
                const usdzUrl = glbUrl?.endsWith?.('.glb') ? glbUrl.replace(/\.glb$/i,'.usdz') : '';

                // Si ya hay sesión, actualiza
                if (isActive()) {
                    if (mode === 'android-webxr') {
                        await controller.setSource({ glbUrl });
                        UI.revealContainer(); UI.hideMap();
                    } else {
                        await controller.setSource({ glbUrl, usdzUrl });
                        UI.showFallback(); UI.revealContainer(); UI.hideMap();
                    }
                    UI.setHint('Modelo actualizado.');
                    return;
                }

                // Android con WebXR: usar retícula (user activation)
                if (await canUseAR()) {
                    pendingSource = { glbUrl, usdzUrl };
                    UI.showReticle();
                    UI.hideMap();
                    UI.setHint('Fuente lista. Toca la retícula para colocar.');
                    return;
                }

                // Fallback inmediato (web/iOS)
                UI.revealContainer();
                UI.hideMap();
                UI.showFallback();

                const mvCtrl = new ModelViewerController(UI.$mv(), {
                    onEnter: ({mode}) => UI.setHint(`AR activo (${mode}).`)
                });
                mvCtrl.bindOnce();
                await mvCtrl.setSource({ glbUrl, usdzUrl });

                controller = mvCtrl;
                mode = Platform.isIOS ? "ios-quicklook" : "web-fallback";
                UI.showCapture();
                UI.setHint('Modelo listo en visor 3D.');
            }

            async function handleReticleTap(){
                if (!pendingSource) return;
                UI.hideReticle();
                UI.revealContainer();
                UI.hideMap();

                const { glbUrl, usdzUrl } = pendingSource;
                pendingSource = null;

                if (await canUseAR()) {
                    try {
                        controller = new AndroidWebXRController({
                            onEnter: ({mode}) => UI.setHint(`Cámara iniciada (${mode}).`),
                            onExit: ({reason,state,status}) => {
                                UI.showFallback(); UI.showMap();
                                UI.setHint(`Sesión finalizada (${reason||status||state||"desconocido"}).`);
                            }
                        });
                        await controller.startFromGesture(glbUrl);
                        mode = "android-webxr";
                        controller.placeInFront();
                        UI.showCapture();
                        return;
                    } catch(e){
                        // caer a fallback
                    }
                }

                // Fallback si falla/ no soporta
                UI.showFallback();
                const mvCtrl = new ModelViewerController(UI.$mv(), {
                    onEnter: ({mode}) => UI.setHint(`AR activo (${mode}).`)
                });
                mvCtrl.bindOnce();
                await mvCtrl.setSource({ glbUrl, usdzUrl });
                controller = mvCtrl;
                mode = Platform.isIOS ? "ios-quicklook" : "web-fallback";
                UI.showCapture();
            }

            async function destroy(){
                if (controller){
                    if (mode === "android-webxr") await controller.stop();
                    else controller.destroy();
                }
                controller=null; mode=null;
                UI.hideFallback(); UI.hideReticle(); UI.hideCapture(); UI.showMap(); UI.setHint("Listo.");
            }

            // === Captura unificada ===
            async function capture(){
                if (!isActive()) { UI.setHint('No hay vista activa para capturar.'); return; }
                const ts = new Date().toISOString().replace(/[:.]/g,'-');

                if (mode === 'android-webxr' && typeof controller.getCanvas === 'function') {
                    const canvas = controller.getCanvas();
                    if (canvas) {
                        const dataUrl = canvas.toDataURL('image/png');
                        downloadDataUrl(`captura-ar-${ts}.png`, dataUrl);
                        // stats
                        const stats = controller.getModelStats?.() || {};
                        const blob = new Blob([JSON.stringify({ mode, stats, when: new Date().toISOString() }, null, 2)], { type: 'application/json' });
                        downloadBlob(`captura-ar-${ts}.json`, blob);
                        UI.setHint('Captura guardada (solo capa 3D; el feed de cámara no puede capturarse en WebXR).');
                        return;
                    }
                }

                // Fallback: usa html2canvas si está disponible
                if (UI.$mv() && window.html2canvas) {
                    const canvas = await window.html2canvas(UI.$mv(), { useCORS: true, backgroundColor: '#000' });
                    const dataUrl = canvas.toDataURL('image/png');
                    downloadDataUrl(`captura-fallback-${ts}.png`, dataUrl);
                    UI.setHint('Captura guardada del visor 3D.');
                    return;
                }

                UI.setHint('No fue posible capturar esta vista (falta html2canvas o canvas no disponible).');
            }

            return { handleReticleTap, onMarkerSourceSelected, destroy, isActive, capture };
        })();

        /* ==============================
         * Items / Mapa
         * ============================== */
        let map, markerLayer, markersAllInit = [], markersAll = [], markersById = {};
        const MAP_CONFIG = Object.freeze({
            zoom: 14, maxZoom: 25,
            position: [0.20830, -78.22798],
            tileUrl: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            tileAttribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contribuyentes'
        });

        function createMarkerIcon(item) {
            return L.icon({
                iconUrl: item.sources.img,
                iconSize: [60, 60],
                iconAnchor: [60, 60],
                popupAnchor: [0, -40]
            });
        }
        function createPopupContent(item) {
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
    </section>
    <footer class="popup-card__footer">
      <button class="popup-card__btn popup-card__btn--primary not-view"
              data-action="center" data-id="${item.id}">
        Centrar aquí
      </button>
      <a class="popup-card__btn popup-card__btn--ghost"
         source="${item.sources.glb}" rel="noopener noreferrer">
        Ver en 3D
      </a>
    </footer>
  </article>`;
        }
        function renderItemsMarkers(items) {
            if (!map) return;
            if (!markerLayer) markerLayer = L.layerGroup().addTo(map);
            else markerLayer.clearLayers();

            markersAll = []; markersById = {};
            const bounds = [];

            items.forEach((item) => {
                const {lat, lng} = item.position;
                const marker = L.marker([lat, lng], {icon: createMarkerIcon(item), title: item.title})
                    .bindPopup(createPopupContent(item), {maxWidth: 320});
                marker.addTo(markerLayer);
                markersAll.push(marker);
                markersById[item.id] = marker;
                bounds.push([lat, lng]);
                marker.bindTooltip(item.id, {direction: 'top'});
            });

            if (bounds.length) map.fitBounds(bounds, {padding: [40, 40]});
        }
        function flyToItem(id, zoom = 17) {
            const mk = markersById[id];
            if (!mk) return;
            const latLng = mk.getLatLng();
            map.flyTo(latLng, zoom, {duration: 0.8});
            mk.openPopup();
        }
        function initMap() {
            map = L.map('map', {zoomControl: true}).setView(MAP_CONFIG.position, MAP_CONFIG.zoom);

            L.tileLayer(MAP_CONFIG.tileUrl, {
                maxZoom: MAP_CONFIG.maxZoom,
                attribution: MAP_CONFIG.tileAttribution
            }).addTo(map);

            // Click libre: agrega marcador simple
            map.on('click', (e) => {
                const {lat, lng} = e.latlng;
                const mk = L.marker([lat, lng]).addTo(map)
                    .bindPopup(`Nuevo marcador:<br><code>${lat.toFixed(5)}, ${lng.toFixed(5)}</code>`)
                    .openPopup();
                markersAllInit.push({lat, lng});
                markersAll.push(mk);
            });

            // Delegación: acciones dentro de popups
            map.on('popupopen', (e) => {
                const root = e.popup.getElement();
                if (!root) return;
                const centerBtn = root.querySelector('.popup-card__btn[data-action="center"]');
                if (centerBtn) {
                    centerBtn.addEventListener('click', () => {
                        const id = centerBtn.getAttribute('data-id');
                        flyToItem(id);
                    }, { once:true });
                }
                const viewBtn = root.querySelector('.popup-card__btn--ghost');
                if (!viewBtn) return;
                viewBtn.addEventListener('click', async (ev) => {
                    ev.preventDefault();
                    const src = viewBtn.getAttribute('data-source') ||
                        viewBtn.getAttribute('source') ||
                        viewBtn.getAttribute('href') || '';
                    if (!src){ UI.setHint("No hay fuente GLB/USDZ."); return; }
                    await Viewer.onMarkerSourceSelected(src);
                }, { once:false });
            });

            renderItemsMarkers(itemsSources);
        }

        /* ==============================
         * Bootstrap
         * ============================== */
        const itemsSources = [
            {
                id: "taita",
                title: "Taita Imbabura – El Abuelo que todo lo ve",
                subtitle: "Ñawi Hatun Yaya",
                description: "Sabio y protector, guardián del viento y ciclos de la tierra.",
                position: {lat: 0.20477, lng: -78.20639},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/taita-imbabura-toon-1.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/taita-imbabura.png'
                }
            },
            {
                id: "cerro-cusin",
                title: "Cusin – El guardián del paso fértil",
                subtitle: "Allpa ñampi rikchar",
                description: "Cusin camina con paso firme cuidando las chacras y senderos.",
                position: {lat: 0.20435, lng: -78.20688},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/cusin.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/elcusin.png'
                }
            },
            {
                id: "mojanda",
                title: "Mojanda – El susurro del páramo",
                subtitle: "Sachayaku mama",
                description: "Entre neblinas y lagunas, hilos del agua fría que purifica.",
                position: {lat: 0.20401, lng: -78.20723},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/taita-imbabura-otro.glb',
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
                id: "coraza",
                title: "El Coraza – Espíritu de la celebración",
                subtitle: "Kawsay Taki",
                description: "Orgullo y memoria viva de lucha y honor.",
                position: {lat: 0.20349, lng: -78.20779},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/coraza-one.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/elcoraza.png'
                }
            },
            {
                id: "lechero",
                title: "El Lechero – Árbol del Encuentro y los Deseos",
                subtitle: "Kawsay ranti",
                description: "Testigo de promesas, abrazos y despedidas.",
                position: {lat: 0.20316, lng: -78.20790},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/other.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/lechero.png'
                }
            },
            {
                id: "lago-san-pablo",
                title: "Yaku Mama – La Laguna Viva",
                subtitle: "Yaku Mama – Kawsaycocha",
                description: "Sus aguas te abrazan con calma, reflejando tu esencia.",
                position: {lat: 0.20284, lng: -78.20802},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/lago-san-pablo.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/yaku-mama.png'
                }
            }
        ];

        $(function () {
            initMap();
            /* ==============================
 * Eventos globales
 * ============================== */
            document.getElementById("reticle-overlay")?.addEventListener("click", async () => {
                await Viewer.handleReticleTap();
            });
            document.getElementById("btn-back-map")?.addEventListener("click", async () => {
                await Viewer.destroy();
            });
            UI.$btnCapture()?.addEventListener('click', async () => {
                await Viewer.capture();
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
