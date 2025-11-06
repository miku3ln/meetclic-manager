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

        /* Retícula (overlay 2D para gating del TOQUE) */
        #reticle-overlay {
            position: fixed;
            inset: 0;
            display: grid;
            place-items: center;
            pointer-events: auto;
            z-index: 9998;
            background: transparent;
        }

        #reticle-overlay.hidden {
            display: none;
        }

        .reticle__ring {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid rgba(0, 229, 255, .95);
            animation: pulse 1.2s ease-in-out infinite;
            box-shadow: 0 0 10px rgba(0, 229, 255, .6);
        }

        .reticle__dot {
            position: absolute;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: rgba(0, 229, 255, 1);
            box-shadow: 0 0 8px rgba(0, 229, 255, .6);
        }

        .reticle__hint {
            position: absolute;
            top: calc(50% + 90px);
            background: rgba(0, 0, 0, .55);
            padding: 6px 10px;
            border-radius: 8px;
            font: 13px/1.2 system-ui, Arial;
            color: #fff;
        }

        @keyframes pulse {
            0% {
                transform: scale(.95)
            }
            50% {
                transform: scale(1.05)
            }
            100% {
                transform: scale(.95)
            }
        }

        /* Hint */
        #hint {
            padding: 8px;
            background: #111;
            color: #fff;
            font: 14px/1.2 system-ui;
        }

        /* Botón volver */
        #btn-back-map {
            position: fixed;
            left: 12px;
            top: 12px;
            z-index: 10000;
            padding: .5rem .75rem;
            border: 0;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
        }

        /* Mapa */
        #map {
            width: 100%;
            height: 60vh;
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
        /* ==============================
      * Plataforma
      * ============================== */
        const Platform = (() => {
            const ua = navigator.userAgent || navigator.vendor || "";
            const isAndroid = /Android/i.test(ua);
            const isIOS = /iPhone|iPad|iPod/i.test(ua) ||
                (navigator.platform === "MacIntel" && navigator.maxTouchPoints > 1);
            const isSecure = location.protocol === "https:" || location.hostname === "localhost";
            return { isAndroid, isIOS, isSecure };
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
            const $map = document.getElementById("map");
            const $btnBack = document.getElementById("btn-back-map");

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
            function hideMap(){ $map?.classList.add("not-view"); $btnBack?.classList.remove("d-none"); }
            function showMap(){ $map?.classList.remove("not-view"); $btnBack?.classList.add("d-none"); }

            return {
                setHint, showLoading, hideLoading, showFallback, hideFallback, revealContainer,
                showReticle, hideReticle, hideMap, showMap, $mv
            };
        })();

        /* ==============================
         * Fallback <model-viewer> (gating por retícula)
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
                    const st = ev?.detail?.status; // 'session-started'|'object-placed'|'not-presenting'
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
            setSource({ glbUrl, usdzUrl }) {
                if (!this.mv) return;
                this.mv.src = glbUrl || "";
                if (usdzUrl) this.mv.setAttribute("ios-src", usdzUrl);
                else this.mv.removeAttribute("ios-src");
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
         * Coloca el modelo frente a la cámara SOLO tras tap en retícula
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

            // IMPORTANTE: se llama DENTRO del tap a la retícula (user activation)
            async startFromGesture(glbUrl){
                // 1) Solicitar sesión primero (sin awaits previos que rompan activación)
                try{
                    this.session = await navigator.xr.requestSession("immersive-ar", {
                        requiredFeatures: ["local"],
                        optionalFeatures: ["dom-overlay"],
                        domOverlay: { root: document.body }
                    });
                }catch(e){
                    throw e; // que el caller haga fallback
                }

                // 2) Setup renderer/escena
                this._setupRenderer();      // no async
                this._setupScene();         // no async
                this.renderer.xr.setReferenceSpaceType("local");
                await this.renderer.xr.setSession(this.session);

                // gestionar salidas
                this._onEnd = () => this.hooks.onExit && this.hooks.onExit({ reason: "session-end" });
                this._onVis = () => {
                    const s = this.session?.visibilityState;
                    if (s === "hidden" || s === "visible-blurred") {
                        this.hooks.onExit && this.hooks.onExit({ reason: "visibility", state: s });
                    }
                };
                this.session.addEventListener("end", this._onEnd);
                this.session.addEventListener("visibilitychange", this._onVis);

                // 3) Cargar modelo
                await this._loadModel(glbUrl);

                window.addEventListener("resize", this._onResize);
                this.hooks.onEnter && this.hooks.onEnter({ mode:"android-webxr" });
            }

            async setSource({ glbUrl }){
                await this._disposeModel();
                await this._loadModel(glbUrl);
            }

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
                this.renderer = new THREE.WebGLRenderer({ antialias:true, alpha:true });
                this.renderer.xr.enabled = true;
                this.renderer.setPixelRatio(Math.min(window.devicePixelRatio||1, 2));
                this._fit();
                document.body.appendChild(this.renderer.domElement);
            }
            _setupScene(){
                this.scene = new THREE.Scene();
                const aspect = Math.max(innerWidth,1)/Math.max(innerHeight,1);
                this.camera = new THREE.PerspectiveCamera(60, aspect, 0.01, 20);
                const hemi = new THREE.HemisphereLight(0xffffff, 0x404040, 1.0);
                const dir = new THREE.DirectionalLight(0xffffff, 0.8); dir.position.set(0,1,-1);
                this.scene.add(hemi, dir);
                this.renderer.setAnimationLoop(this._loop);
            }
            async _loadModel(glbUrl){
                if (!glbUrl) return;
                UI.showLoading();
                await new Promise((res, rej)=>{
                    new THREE.GLTFLoader().load(glbUrl, (gltf)=>{
                        this.model = gltf.scene;
                        this.model.traverse(o=>{
                            if (o.isMesh){ o.frustumCulled=false; const m=o.material;
                                if (m){ Array.isArray(m)?m.forEach(mm=>mm.side=THREE.DoubleSide):m.side=THREE.DoubleSide; } }
                        });
                        // NO colocamos aún: solo tras tap en retícula
                        UI.hideLoading();
                        UI.setHint("Modelo listo para colocar. Toca la retícula.");
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
            _onXRFrame(){
                // No auto-place: solo render
                this.renderer.render(this.scene, this.camera);
            }
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
        }

        /* ==============================
         * Orquestador / API
         * ============================== */
        const Viewer = (()=>{
            let mode = null;
            let controller = null;
            let pendingSource = null; // {glbUrl, usdzUrl} que llega desde el popup

            // Tap en RETÍCULA: único punto donde arrancamos AR/mostrar fallback
            async function handleReticleTap(){
                if (!pendingSource) return;
                UI.hideReticle();
                UI.revealContainer();
                UI.hideMap();

                const { glbUrl, usdzUrl } = pendingSource;
                pendingSource = null;

                // ¿Android WebXR disponible?
                if (Platform.isAndroid && Platform.isSecure && "xr" in navigator) {
                    try {
                        controller = new AndroidWebXRController({
                            onEnter: ({mode}) => UI.setHint(`Cámara iniciada (${mode}).`),
                            onExit: ({reason,state,status}) => {
                                UI.showFallback(); UI.showMap(); UI.setHint(`Sesión finalizada (${reason||status||state||"desconocido"}).`);
                            }
                        });
                        await controller.startFromGesture(glbUrl); // requestSession se ejecuta DENTRO de este tap
                        mode = "android-webxr";
                        // Colocación aquí MISMA, porque el usuario ya tocó la retícula
                        controller._placeInFront();
                        return;
                    } catch(e){
                        // Fallback
                    }
                }

                // Fallback <model-viewer> (incluye iOS)
                UI.showFallback();
                const mvCtrl = new ModelViewerController(UI.$mv, {
                    onEnter: ({mode}) => UI.setHint(`AR activo (${mode}).`)
                });
                mvCtrl.bindOnce();
                mvCtrl.setSource({ glbUrl, usdzUrl });
                controller = mvCtrl; mode = Platform.isIOS ? "ios-quicklook" : "web-fallback";
                // En iOS podemos abrir Quick Look inmediatamente si quieres:
                // await mvCtrl.activateARIfAny();
            }

            // Se llama desde popup del marker (NO inicia AR aún, solo prepara source + muestra retícula)
            function prepareFromMarkerSource(glbUrl){
                const usdzUrl = glbUrl?.endsWith?.(".glb") ? glbUrl.replace(/\.glb$/i, ".usdz") : "";
                pendingSource = { glbUrl, usdzUrl };
                UI.setHint("Fuente lista. Toca la retícula para colocar.");
                UI.showReticle();
            }

            async function setSource({ glbUrl, usdzUrl }){
                if (!controller){
                    // Si no hay sesión, preparar gating por retícula
                    pendingSource = { glbUrl, usdzUrl };
                    UI.showReticle();
                    return;
                }
                if (mode === "android-webxr") await controller.setSource({ glbUrl });
                else controller.setSource({ glbUrl, usdzUrl });
            }

            async function destroy(){
                if (controller){
                    if (mode === "android-webxr") await controller.stop();
                    else controller.destroy();
                }
                controller=null; mode=null;
                UI.hideFallback(); UI.hideReticle(); UI.showMap(); UI.setHint("Listo.");
            }

            return { handleReticleTap, prepareFromMarkerSource, setSource, destroy };
        })();

        /* ==============================
         * Eventos globales
         * ============================== */
        document.getElementById("reticle-overlay")?.addEventListener("click", async ()=>{
            // Este TAP es la user activation principal
            await Viewer.handleReticleTap();
        });

        document.getElementById("btn-back-map")?.addEventListener("click", async ()=>{
            await Viewer.destroy();
        });
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
                iconSize: [60, 60],
                iconAnchor: [60, 60],
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

                    const src = viewBtn.getAttribute('data-source') || viewBtn.getAttribute('source') || viewBtn.getAttribute('href') || '';
                    if (!src){ UI.setHint("No hay fuente GLB/USDZ."); return; }

                    // 1) Prepara la fuente del marker (NO inicia aún)
                    Viewer.prepareFromMarkerSource(src);
                    // 2) Oculta mapa y muestra retícula. SOLO al tocar la retícula se verá el modelo.
                    UI.hideMap();
                    UI.setHint("Fuente lista. Toca la retícula para colocar.");
                }, {once: false});
            });

            // Render inicial
            renderItemsMarkers(itemsSources);

        }


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

    <div id="map"></div>
@endsection
