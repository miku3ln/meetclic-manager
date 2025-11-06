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
        :root{
            --bg: #0a0a0a;
            --fg: #f5f5f5;
            --muted: #b9bcc4;
            --primary: #2ecc71;
            --ring: rgba(255,255,255,0.9);
            --dot:  rgba(255,255,255,0.95);
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
        /* Loading transparente (no bloquea interacción) */
        .loading {
            position: fixed; inset: 0;
            background: transparent;
            pointer-events: none;
            display: grid; place-items: center;
            z-index: 9998;
        }
        .loading__center { display:flex; flex-direction:column; align-items:center; }
        .spinner {
            width: 56px; height: 56px; border-radius: 50%;
            border: 6px solid rgba(255,255,255,0.25);
            border-top-color: rgba(255,255,255,0.9);
            animation: spin 1s linear infinite;
        }
        .loading__text { margin-top: 10px; text-align:center; color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,0.5); }
        .loading__text strong { display:block; margin-bottom: 4px; }
        @keyframes spin { to { transform: rotate(360deg); } }

        .reticle {
            position: fixed; inset: 0; display: grid; place-items: center; z-index: 4;
            pointer-events: auto;
        }
        .reticle.hidden { display: none; }
        .reticle__ring {
            width: 160px; height: 160px; border-radius: 50%;
            border: 4px solid var(--ring);
            box-shadow: 0 0 16px rgba(255,255,255,0.35);
        }
        .reticle__dot {
            position:absolute; width: 10px; height: 10px;
            border-radius: 50%; background: var(--dot);
        }
        .reticle__hint {
            position: absolute; top: calc(50% + 110px); left: 50%; transform: translateX(-50%);
            font-size: 14px; color: var(--muted);
            background: rgba(0,0,0,0.5); padding: 6px 8px; border-radius: 6px;
            backdrop-filter: blur(6px);
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
        :root{
            --bg:#0a0a0a; --fg:#f5f5f5; --muted:#b9bcc4;
            --ring:rgba(255,255,255,0.9); --dot:rgba(255,255,255,0.95);
            --btn:#222; --btn-h:#2c2c2c; --accent:#2f8;
        }

        *{ box-sizing:border-box; }
        html,body{ margin:0; padding:0; height:100%; background:var(--bg); color:var(--fg); font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Helvetica Neue,Arial; }

        .hint{
            position:fixed; left:12px; bottom:12px;
            background:rgba(0,0,0,.65); color:#fff;
            padding:8px 12px; border-radius:10px; z-index:10001; font-size:14px;
        }
        .btn{
            position:fixed; z-index:10001; padding:8px 12px;
            border-radius:10px; border:none; cursor:pointer; font-weight:600;
            box-shadow:0 2px 8px rgba(0,0,0,.35);
        }
        #btn-back-map{ top:12px; left:12px; background:var(--btn); color:#fff; }
        #btn-back-map:hover{ background:var(--btn-h); }
        #btn-capture{ top:12px; right:12px; background:var(--accent); color:#000; }
        #btn-capture:hover{ filter:brightness(.95); }

        .map{ position:fixed; inset:0; }
        .not-view{ display:none !important; }
        .d-none{ display:none !important; }

        .container--custom{ position:relative; z-index:2; }

        /* Loading transparente */
        .loading{
            position:fixed; inset:0; background:transparent; pointer-events:none;
            display:grid; place-items:center; z-index:9998;
        }
        .loading__center{ display:flex; flex-direction:column; align-items:center; }
        .spinner{
            width:56px; height:56px; border-radius:50%;
            border:6px solid rgba(255,255,255,.25); border-top-color:rgba(255,255,255,.9);
            animation:spin 1s linear infinite;
        }
        .loading__text{ margin-top:10px; text-align:center; color:#fff; text-shadow:0 1px 2px rgba(0,0,0,.5); }
        .loading__text strong{ display:block; margin-bottom:4px; }
        @keyframes spin{ to{ transform:rotate(360deg);} }

        /* Retícula */
        .reticle{ position:fixed; inset:0; display:grid; place-items:center; z-index:4; pointer-events:auto; }
        .reticle.hidden{ display:none; }
        .reticle__ring{ width:160px; height:160px; border-radius:50%; border:4px solid var(--ring); box-shadow:0 0 16px rgba(255,255,255,.35); }
        .reticle__dot{ position:absolute; width:10px; height:10px; border-radius:50%; background:var(--dot); }
        .reticle__hint{
            position:absolute; top:calc(50% + 110px); left:50%; transform:translateX(-50%);
            font-size:14px; color:var(--muted); background:rgba(0,0,0,.5); padding:6px 8px; border-radius:6px; backdrop-filter:blur(6px);
        }

        /* Popup (Leaflet) */
        .leaflet-container a{ color:#1da1f2; }
        .popup-card{ color:#111; font-family:inherit; width:280px; }
        .popup-card__header{ display:flex; gap:10px; align-items:center; }
        .popup-card__img{ width:56px; height:56px; border-radius:10px; object-fit:cover; }
        .popup-card__title{ margin:0; font-size:16px; color:#111; }
        .popup-card__subtitle{ margin:0; font-size:12px; color:#444; }
        .popup-card__body{ margin-top:8px; color:#333; }
        .popup-card__footer{ display:flex; gap:8px; margin-top:10px; }
        .popup-card__btn{ padding:6px 10px; border-radius:8px; border:1px solid #ddd; background:#fff; cursor:pointer; text-decoration:none; color:#111; }
        .popup-card__btn--primary{ background:#111; color:#fff; border-color:#111; }
        .popup-card__btn--ghost{ background:#fff; }

        /* model-viewer */
        model-viewer{ width:100%; height:70vh; background:#000; border-radius:12px; }

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
        /* ===========================================================
 * Plataforma + capacidades
 * =========================================================== */
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

        /* ===========================================================
         * UI Manager (con % de carga)
         * =========================================================== */
        const UI = (() => {
            let $ = {};
            const pctText = p => (Math.max(0, Math.min(1, p||0)) * 100).toFixed(0) + '%';

            function bind(){
                $.loading = document.getElementById('ar-loading');
                $.loadingPct = document.getElementById('ar-loading-percent');
                $.loadingLbl = document.getElementById('ar-loading-label');
                $.fallback = document.getElementById('fallback');
                $.mv = document.getElementById('mv');
                $.hint = document.getElementById('hint');
                $.container = document.querySelector('.container--custom');
                $.reticle = document.getElementById('reticle-overlay');
                $.retHint = $.reticle?.querySelector('.reticle__hint');
                $.map = document.getElementById('map');
                $.back = document.getElementById('btn-back-map');
                $.capture = document.getElementById('btn-capture');
            }
            const show = el => el && el.classList.remove('d-none');
            const hide = el => el && el.classList.add('d-none');

            return {
                bind,
                setHint(m){ $.hint && ($.hint.textContent = m||''); },
                setReticleText(m){ $.retHint && ($.retHint.textContent = m||''); },

                showLoading(label='Cargando…'){ $.loadingLbl&&( $.loadingLbl.textContent=label ); $.loadingPct&&( $.loadingPct.textContent='0%' ); show($.loading); },
                hideLoading(){ hide($.loading); },
                resetLoadingProgress(label='Cargando modelo… 0%'){ $.loadingLbl&&( $.loadingLbl.textContent=label ); $.loadingPct&&( $.loadingPct.textContent='0%'); },
                updateLoadingProgress(p){ const t=pctText(p); $.loadingPct&&( $.loadingPct.textContent=t ); $.loadingLbl&&( $.loadingLbl.textContent=`Cargando modelo… ${t}` ); },
                finishLoadingProgress(){ $.loadingPct&&( $.loadingPct.textContent='100%'); $.loadingLbl&&( $.loadingLbl.textContent='Modelo cargado.'); },

                showFallback(){ show($.fallback); },
                hideFallback(){ hide($.fallback); },

                revealContainer(){ $.container?.classList.remove('not-view'); },
                showReticle(){ $.reticle?.classList.remove('hidden'); },
                hideReticle(){ $.reticle?.classList.add('hidden'); },

                hideMap(){ $.map?.classList.add('not-view'); $.back?.classList.remove('d-none'); },
                showMap(){ $.map?.classList.remove('not-view'); $.back?.classList.add('d-none'); },

                showCapture(){ $.capture?.classList.remove('d-none'); },
                hideCapture(){ $.capture?.classList.add('d-none'); },

                get mv(){ return $.mv; },
                get $fallback(){ return $.fallback; },
                get $reticle(){ return $.reticle; },
                get $back(){ return $.back; },
                get $capture(){ return $.capture; }
            };
        })();

        /* ===========================================================
         * Utilidades descarga / stats
         * =========================================================== */
        const DownloadUtils = {
            saveBlob(filename, blob){
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a'); a.href=url; a.download=filename;
                document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
            }
        };
        const StatsUtils = {
            compute(root){
                if (!root) return null;
                const box = new THREE.Box3().setFromObject(root);
                const size = new THREE.Vector3(); box.getSize(size);
                let meshes=0, tris=0;
                root.traverse(o=>{
                    if (o.isMesh && o.geometry){
                        meshes++;
                        const g=o.geometry; const t = g.index ? (g.index.count/3) : (g.attributes?.position ? g.attributes.position.count/3 : 0);
                        tris += Math.floor(t);
                    }
                });
                return { meshes, triangles:tris, bbox:{ x:+size.x.toFixed(4), y:+size.y.toFixed(4), z:+size.z.toFixed(4) } };
            }
        };

        /* ===========================================================
         * Fallback <model-viewer> con % de progreso
         * =========================================================== */
        class ModelViewerController {
            constructor(mvEl, hooks={}){ this.mv=mvEl; this.hooks=hooks; this._bound=false; }
            bindOnce(){
                if (this._bound||!this.mv) return; this._bound=true;

                this._onARStatus = ev => {
                    const st = ev?.detail?.status;
                    if (st==='session-started') this.hooks.onEnter && this.hooks.onEnter({mode:'ios/web-ar'});
                    if (st==='not-presenting') this.hooks.onExit && this.hooks.onExit({reason:'ar-status', status:st});
                };
                this._onCameraChange = () => {
                    const o=this.mv.getCameraOrbit?.();
                    this.hooks.onRotate && this.hooks.onRotate({ rotY:o?.theta??0, rotX:o?.phi??0 });
                    this.hooks.onScale  && this.hooks.onScale({ scale:o?.radius??0 });
                };
                this._onLoad = () => { UI.finishLoadingProgress(); UI.hideLoading(); UI.setHint('Modelo cargado en visor 3D.'); };
                this._onError= () => { UI.hideLoading(); UI.setHint('Error al cargar en visor 3D.'); };
                this._onProgress = ev => {
                    const p = ev?.detail?.totalProgress;
                    if (typeof p==='number') UI.updateLoadingProgress(p);
                };

                this.mv.addEventListener('ar-status', this._onARStatus);
                this.mv.addEventListener('camera-change', this._onCameraChange);
                this.mv.addEventListener('load', this._onLoad);
                this.mv.addEventListener('error', this._onError);
                this.mv.addEventListener('progress', this._onProgress);
            }
            async setSource({ glbUrl, usdzUrl }){
                if (!this.mv) return;
                UI.showFallback(); UI.showLoading(); UI.resetLoadingProgress();
                this.mv.src = glbUrl || '';
                if (usdzUrl) this.mv.setAttribute('ios-src', usdzUrl); else this.mv.removeAttribute('ios-src');
                await new Promise((res,rej)=>{
                    const ok = ()=>{ this.mv.removeEventListener('load',ok); res(); };
                    const er = ()=>{ this.mv.removeEventListener('error',er); rej(); };
                    this.mv.addEventListener('load', ok, {once:true});
                    this.mv.addEventListener('error', er, {once:true});
                });
            }
            destroy(){
                if (!this.mv) return;
                this.mv.removeEventListener('ar-status', this._onARStatus);
                this.mv.removeEventListener('camera-change', this._onCameraChange);
                this.mv.removeEventListener('load', this._onLoad);
                this.mv.removeEventListener('error', this._onError);
                this.mv.removeEventListener('progress', this._onProgress);
                this.mv.src=''; this.mv.removeAttribute('ios-src'); this._bound=false;
            }
        }

        /* ===========================================================
         * Android WebXR (sin hit-test): abre cámara primero; GLB después
         * Gestos móviles: 1 dedo rotar+vertical, 2 dedos pinch+pan
         * =========================================================== */
        class AndroidWebXRController {
            constructor(hooks={}) {
                this.hooks=hooks;
                this.renderer=null; this.scene=null; this.camera=null; this.session=null; this.model=null; this._refSpace=null;

                this._distanceMeters=1.2;
                this._loop=this._onXRFrame.bind(this);
                this._onResize=this._handleResize.bind(this);

                // Primer frame de cámara ⇒ mostrar retícula
                this._firstFrameSeen=false;
                this._firstFrameResolve=null;
                this.ready = new Promise(res => (this._firstFrameResolve = res));

                // eventos sesión
                this._onEnd=this._onVis=null;

                // light
                this._lightProbe=null; this._headlamp=null;
            }

            // Abre SOLO la cámara (sesión). No carga GLB aquí.
            async startSessionFromGesture(){
                this.session = await navigator.xr.requestSession('immersive-ar', {
                    requiredFeatures:['local'],
                    optionalFeatures:['dom-overlay','light-estimation'],
                    domOverlay:{ root: document.body }
                });

                this._setupRenderer();
                this._setupScene();
                this.renderer.xr.setReferenceSpaceType('local');
                await this.renderer.xr.setSession(this.session);
                this._refSpace = this.renderer.xr.getReferenceSpace();

                // sesión hooks
                this._onEnd = () => this.hooks.onExit && this.hooks.onExit({reason:'session-end'});
                this._onVis = () => {
                    const s=this.session?.visibilityState;
                    if (s==='hidden' || s==='visible-blurred') this.hooks.onExit && this.hooks.onExit({reason:'visibility', state:s});
                };
                this.session.addEventListener('end', this._onEnd);
                this.session.addEventListener('visibilitychange', this._onVis);

                // light-probe
                try{ if (this.session.requestLightProbe) this._lightProbe = await this.session.requestLightProbe({type:'spherical-harmonics'}); }catch{}

                // gestos
                this._bindGesturesMobile();

                window.addEventListener('resize', this._onResize);
                this.hooks.onEnter && this.hooks.onEnter({mode:'android-webxr'});
            }

            // Carga el modelo con % y lo deja listo (no se muestra hasta placeInFront)
            async loadModel(glbUrl){
                await this._disposeModel();
                if (!glbUrl) return;

                UI.showLoading(); UI.resetLoadingProgress();

                await new Promise((res, rej)=>{
                    const loader = new THREE.GLTFLoader();
                    loader.load(
                        glbUrl,
                        (gltf)=>{
                            this.model = gltf.scene;
                            // Escala ≈1m
                            const box = new THREE.Box3().setFromObject(this.model);
                            const size = new THREE.Vector3(); box.getSize(size);
                            const s = 1/(Math.max(size.x,size.y,size.z)||1);
                            this.model.scale.setScalar(s);

                            this.model.traverse(o=>{
                                if (o.isMesh){
                                    o.frustumCulled=false;
                                    const m=o.material; (Array.isArray(m)?m:[m]).forEach(mm=>{ if(mm){ mm.side=THREE.DoubleSide; mm.needsUpdate=true; }});
                                }
                            });

                            UI.finishLoadingProgress(); UI.hideLoading(); res();
                        },
                        (xhr)=>{
                            if (xhr && xhr.lengthComputable) {
                                const p = xhr.total ? (xhr.loaded / xhr.total) : 0;
                                UI.updateLoadingProgress(p);
                            }
                        },
                        (err)=>{ UI.hideLoading(); UI.setHint('Error al cargar modelo.'); rej(err); }
                    );
                });
            }

            placeInFront(){ this._placeInFront(); }

            async stop(){
                try{ window.removeEventListener('resize', this._onResize); }catch{}
                try{ this.renderer?.setAnimationLoop(null); }catch{}
                await this._disposeModel();

                if (this.session){
                    try{ await this.session.end(); }catch{}
                    try{ this.session.removeEventListener('end', this._onEnd); this.session.removeEventListener('visibilitychange', this._onVis);}catch{}
                }
                if (this.renderer?.domElement?.parentNode) this.renderer.domElement.parentNode.removeChild(this.renderer.domElement);
                try{ this.renderer?.dispose?.(); }catch{}
                this.renderer=this.scene=this.camera=this.session=this._refSpace=null;
                this._firstFrameSeen=false;
                this.ready = new Promise(res => (this._firstFrameResolve = res));
            }

            /* ---------- setup ---------- */
            _setupRenderer(){
                if (this.renderer) return;
                this.renderer = new THREE.WebGLRenderer({ antialias:true, alpha:true, powerPreference:'high-performance' });
                this.renderer.xr.enabled = true;
                this.renderer.outputEncoding = THREE.sRGBEncoding;
                this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
                this.renderer.toneMappingExposure = 1.2;
                this.renderer.physicallyCorrectLights = true;
                this.renderer.setPixelRatio(Math.min(window.devicePixelRatio||1, 2));
                this._handleResize();
                this.renderer.setClearAlpha(0);
                Object.assign(this.renderer.domElement.style, { position:'fixed', inset:'0', width:'100%', height:'100%', zIndex:'1', touchAction:'none' });
                document.body.appendChild(this.renderer.domElement);
            }
            _setupScene(){
                this.scene = new THREE.Scene();
                const aspect = Math.max(innerWidth,1)/Math.max(innerHeight,1);
                this.camera = new THREE.PerspectiveCamera(60, aspect, 0.01, 20);
                const hemi = new THREE.HemisphereLight(0xffffff, 0x404040, 0.8);
                const dir  = new THREE.DirectionalLight(0xffffff, 0.8); dir.position.set(0,1,-1);
                this._headlamp = new THREE.PointLight(0xffffff, 1.3, 12, 2.0);
                this.camera.add(this._headlamp);
                this.scene.add(this.camera, hemi, dir);
                this.renderer.setAnimationLoop(this._loop);
            }

            _onXRFrame(time, frame){
                if (!frame || !this._refSpace){ this.renderer.render(this.scene, this.camera); return; }
                const pose = frame.getViewerPose(this._refSpace);

                if (!this._firstFrameSeen && pose){
                    this._firstFrameSeen=true;
                    try{ this._firstFrameResolve && this._firstFrameResolve(); }catch{}
                    UI.setHint('Cámara lista. Toca la retícula para colocar el modelo.');
                    UI.setReticleText('Toca para colocar el modelo');
                    UI.showReticle();
                }

                if (this._lightProbe){
                    try{
                        const est = frame.getLightEstimate(this._lightProbe);
                        if (est?.primaryLightIntensity){
                            const i = Math.max(0.7, Math.min(2.0, est.primaryLightIntensity.x));
                            this._headlamp.intensity = i;
                        }
                    }catch{}
                }

                this.renderer.render(this.scene, this.camera);
            }

            _handleResize(){
                if (!this.renderer) return;
                const w=Math.max(innerWidth,1), h=Math.max(innerHeight,1);
                this.renderer.setSize(w,h);
                if (this.camera && h>0){ this.camera.aspect = w/h; this.camera.updateProjectionMatrix(); }
            }

            async _disposeModel(){
                if (!this.model) return;
                this.scene?.remove(this.model);
                this.model.traverse(o=>{
                    if (o.isMesh){
                        o.geometry?.dispose?.();
                        const m=o.material; (Array.isArray(m)?m:[m]).forEach(mm=>mm?.dispose?.());
                    }
                });
                this.model=null;
            }

            _placeInFront(){
                if (!this.model || !this.camera) return;
                const fwd = new THREE.Vector3(0,0,-1).applyQuaternion(this.camera.quaternion).normalize();
                const pos = new THREE.Vector3().copy(this.camera.position).add(fwd.multiplyScalar(this._distanceMeters));
                this.model.position.copy(pos);
                this.model.position.y -= 0.1;
                this.model.lookAt(this.camera.position.x, this.model.position.y, this.camera.position.z);
                if (!this.model.parent) this.scene.add(this.model);
                UI.setHint('Modelo colocado.');
            }

            /* ---------- Gestos móviles ---------- */
            _pixelsToMetersAtDistance(d){ const h=2*Math.tan(THREE.MathUtils.degToRad(this.camera.fov*0.5))*d; return h/Math.max(1,this.renderer.getSize(new THREE.Vector2()).y); }
            _bindGesturesMobile(){
                const dom=this.renderer.domElement; dom.style.touchAction='none';
                const st={ mode:'none', lastX:0, lastY:0, lastDist:0, lastCx:0, lastCy:0 };
                const ROT_S=0.012, ZOOM_S=0.004, clamp=(s)=>THREE.MathUtils.clamp(s,0.2,3.0);
                let raf=null, dRot=0, dZoom=1, panDX=0, panDY=0;
                const apply=()=>{ raf=null; if(!this.model) return;
                    if(dRot){ this.model.rotation.y += dRot; dRot=0; }
                    if(dZoom!==1){ const s=clamp(this.model.scale.x*dZoom); this.model.scale.setScalar(s); dZoom=1; }
                    if(panDX||panDY){
                        const dCam=this.camera.position.distanceTo(this.model.position), px2m=this._pixelsToMetersAtDistance(Math.max(0.01,dCam));
                        const right=new THREE.Vector3(1,0,0).applyQuaternion(this.camera.quaternion);
                        const up=new THREE.Vector3(0,1,0).applyQuaternion(this.camera.quaternion);
                        this.model.position.addScaledVector(right, panDX*px2m);
                        this.model.position.addScaledVector(up,   -panDY*px2m);
                        panDX=panDY=0;
                    }
                };
                const queue=()=>{ if(!raf) raf=requestAnimationFrame(apply); };

                const onStart=e=>{
                    if(e.touches.length===1){ st.mode='one'; st.lastX=e.touches[0].clientX; st.lastY=e.touches[0].clientY; }
                    else if(e.touches.length>=2){ st.mode='two'; const[a,b]=e.touches; st.lastDist=Math.hypot(a.clientX-b.clientX,a.clientY-b.clientY); st.lastCx=(a.clientX+b.clientX)*.5; st.lastCy=(a.clientY+b.clientY)*.5; }
                };
                const onMove=e=>{
                    if(!this.model) return; e.preventDefault();
                    if(st.mode==='one' && e.touches.length===1){
                        const t=e.touches[0], dx=t.clientX-st.lastX, dy=t.clientY-st.lastY;
                        dRot += -dx*ROT_S;          // izquierda↔derecha rota
                        dZoom*= (1 - dy*ZOOM_S);    // arriba agranda / abajo reduce
                        st.lastX=t.clientX; st.lastY=t.clientY; queue(); return;
                    }
                    if(st.mode==='two' && e.touches.length>=2){
                        const[a,b]=e.touches;
                        const dist=Math.hypot(a.clientX-b.clientX,a.clientY-b.clientY); dZoom*= dist/Math.max(1,st.lastDist); st.lastDist=dist;
                        const cx=(a.clientX+b.clientX)*.5, cy=(a.clientY+b.clientY)*.5; panDX += (cx-st.lastCx); panDY += (cy-st.lastCy); st.lastCx=cx; st.lastCy=cy;
                        queue(); return;
                    }
                };
                const onEnd=()=>{ st.mode='none'; };

                dom.addEventListener('touchstart', onStart, {passive:true});
                dom.addEventListener('touchmove',  onMove,  {passive:false});
                dom.addEventListener('touchend',   onEnd,   {passive:true});
                dom.addEventListener('touchcancel',onEnd,   {passive:true});
            }

            getCanvas(){ return this.renderer?.domElement || null; }
            getModelStats(){ return StatsUtils.compute(this.model)||{}; }
        }

        /* ===========================================================
         * Viewer (Orquestador) — flujo exacto solicitado
         * =========================================================== */
        class ViewerOrchestrator {
            constructor(){ this._state={ mode:null, controller:null, pendingGLB:null, arReady:false, lastSource:null }; }
            get state(){ return this._state; }
            isActive(){ return !!this._state.controller; }

            // 1) Click en “Ver en 3D” ⇒ abre cámara (sin GLB)
            async onMarkerSourceSelected(glbUrl){
                this._state.lastSource = { glb: glbUrl, usdz: glbUrl?.endsWith?.('.glb') ? glbUrl.replace(/\.glb$/i,'.usdz') : '' };

                UI.revealContainer(); UI.hideMap(); UI.hideFallback();

                if (await canUseAR()){
                    try{
                        UI.showLoading('Abriendo cámara…');
                        const ctrl = new AndroidWebXRController({
                            onEnter: ()=> UI.setHint('Cámara iniciada.'),
                            onExit:  async ({reason}) => { UI.setHint(`Sesión finalizada (${reason||'desconocido'}).`); await this.destroy(); }
                        });
                        await ctrl.startSessionFromGesture(); // SOLO cámara
                        this._state.mode='android-webxr'; this._state.controller=ctrl; this._state.pendingGLB=glbUrl;

                        // espera primer frame ⇒ mostramos retícula
                        await ctrl.ready;
                        UI.hideLoading();
                        UI.showReticle();
                        UI.setHint('Toca la retícula para colocar.');
                        UI.showCapture();
                        return;
                    }catch(e){
                        console.warn('No se pudo iniciar WebXR, uso fallback', e);
                    }
                }

                // Fallback <model-viewer>
                UI.showFallback(); UI.showLoading(); UI.resetLoadingProgress();
                const mvCtrl = new ModelViewerController(UI.mv, { onEnter:({mode})=>UI.setHint(`AR activo (${mode}).`) });
                mvCtrl.bindOnce();
                await mvCtrl.setSource({ glbUrl, usdzUrl:this._state.lastSource.usdz });
                this._state.mode = Platform.isIOS ? 'ios-quicklook' : 'web-fallback';
                this._state.controller = mvCtrl;
                this._state.pendingGLB = null;
                UI.showCapture();
                UI.hideLoading();
            }

            // 2) Click en retícula ⇒ carga GLB con % y coloca
            async handleReticleTap(){
                if (this._state.mode!=='android-webxr' || !this._state.controller) return;
                const glb = this._state.pendingGLB;
                if (!glb){ UI.setHint('No hay modelo seleccionado.'); return; }

                UI.showLoading('Cargando modelo…'); UI.resetLoadingProgress();
                try{
                    await this._state.controller.loadModel(glb);
                    this._state.controller.placeInFront();
                    UI.hideLoading(); UI.hideReticle(); UI.setHint('Modelo colocado.');
                    this._state.pendingGLB = null;
                }catch{
                    UI.hideLoading(); UI.setHint('Error al cargar el modelo.');
                }
            }

            // 4) Salir siempre al mapa y limpiar
            async destroy(){
                try{
                    if (this._state.controller){
                        if (this._state.mode==='android-webxr') await this._state.controller.stop();
                        else this._state.controller.destroy();
                    }
                }catch{}
                this._state={ mode:null, controller:null, pendingGLB:null, arReady:false, lastSource:this._state.lastSource };
                UI.hideFallback(); UI.hideReticle(); UI.hideCapture(); UI.showMap(); UI.setHint('');
            }

            // Captura: pestaña (si se puede) o solo 3D
            async capture(){
                if (!this.isActive()){ UI.setHint('No hay vista activa para capturar.'); return; }
                const ts=new Date().toISOString().replace(/[:.]/g,'-'), name=`captura-${ts}.png`;
                const save = (b)=>DownloadUtils.saveBlob(name,b);

                const supportsTab = !!(navigator.mediaDevices?.getDisplayMedia || navigator.getDisplayMedia);
                if (supportsTab){
                    try{
                        const getDM = navigator.mediaDevices?.getDisplayMedia
                            ? ()=>navigator.mediaDevices.getDisplayMedia({video:{preferCurrentTab:true},audio:false})
                            : ()=>navigator.getDisplayMedia({video:true,audio:false});
                        const stream = await getDM();
                        const track = stream.getVideoTracks()[0];
                        try{
                            const cap=new ImageCapture(track), bmp=await cap.grabFrame();
                            const c=document.createElement('canvas'); c.width=bmp.width; c.height=bmp.height;
                            c.getContext('2d').drawImage(bmp,0,0);
                            const blob = await new Promise(res=>c.toBlob(res,'image/png'));
                            save(blob); stream.getTracks().forEach(t=>t.stop()); UI.setHint('✅ Captura (cámara + modelo).'); return;
                        }catch{
                            const v=document.createElement('video'); v.srcObject=stream; await v.play();
                            await new Promise(r=>{ const to=setTimeout(r,180); v.onloadeddata=()=>{clearTimeout(to); r();}; });
                            const w=v.videoWidth||innerWidth,h=v.videoHeight||innerHeight;
                            const c=document.createElement('canvas'); c.width=w; c.height=h; c.getContext('2d').drawImage(v,0,0,w,h);
                            const blob=await new Promise(res=>c.toBlob(res,'image/png')); save(blob); stream.getTracks().forEach(t=>t.stop());
                            UI.setHint('✅ Captura (cámara + modelo).'); return;
                        }
                    }catch(e){ console.warn('getDisplayMedia falló/denegado', e); }
                }

                if (this._state.mode==='android-webxr' && this._state.controller?.getCanvas){
                    const cnv=this._state.controller.getCanvas();
                    const blob=await new Promise(res=>cnv.toBlob(res,'image/png'));
                    save(blob); UI.setHint('📸 Captura (solo modelo 3D).'); return;
                }

                if (UI.mv && window.html2canvas){
                    const cnv = await window.html2canvas(UI.$fallback||UI.mv, { useCORS:true, backgroundColor:'#000' });
                    const blob=await new Promise(res=>cnv.toBlob(res,'image/png'));
                    save(blob); UI.setHint('📸 Captura (fallback 3D).'); return;
                }

                UI.setHint('Tu navegador no permite mezcla cámara+modelo. Usa captura del sistema.');
            }
        }

        /* ===========================================================
         * Mapa (Leaflet) — abre cámara al click en “Ver en 3D”
         * =========================================================== */
        class MapController {
            constructor(cfg){ this.cfg=Object.assign({
                zoom:14, maxZoom:25, position:[0.20830,-78.22798],
                tileUrl:'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                tileAttribution:'&copy; OpenStreetMap contribuyentes'
            }, cfg||{}); this.map=null; this.layer=null; this.byId={}; }

            init(items){
                this.map = L.map('map',{zoomControl:true}).setView(this.cfg.position, this.cfg.zoom);
                L.tileLayer(this.cfg.tileUrl,{maxZoom:this.cfg.maxZoom, attribution:this.cfg.tileAttribution}).addTo(this.map);
                this.layer = L.layerGroup().addTo(this.map);
                this.render(items);

                this.map.on('popupopen', (e)=>{
                    this._bindPopup(e);
                    const mk=e.popup._source;
                    if (mk){ requestAnimationFrame(()=> this.map.flyTo(mk.getLatLng(), Math.max(this.cfg.zoom,17), {duration:0.35}) ); }
                });
            }

            render(items){
                this.layer.clearLayers(); this.byId={};
                const bounds=[];
                items.forEach(it=>{
                    const icon=L.icon({ iconUrl:it.sources.img, iconSize:[60,60], iconAnchor:[60,60], popupAnchor:[0,-40] });
                    const mk=L.marker([it.position.lat,it.position.lng],{icon, title:it.title})
                        .bindPopup(this._popupHTML(it), { maxWidth:320, autoPan:true, keepInView:true });
                    mk.addTo(this.layer);
                    mk.on('click', ()=>{ this.map.flyTo(mk.getLatLng(), Math.max(this.cfg.zoom,17), {duration:0.35}); mk.openPopup(); });
                    this.byId[it.id]=mk; bounds.push([it.position.lat,it.position.lng]);
                });
                if (bounds.length) this.map.fitBounds(bounds,{padding:[40,40]});
            }

            _popupHTML(item){
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

            _bindPopup(e){
                const root=e.popup.getElement(); if(!root) return;
                L.DomEvent.disableClickPropagation(root); L.DomEvent.disableScrollPropagation(root);

                const centerBtn = root.querySelector('.popup-card__btn[data-action="center"]');
                centerBtn?.addEventListener('click', (ev)=>{ ev.preventDefault(); const id=centerBtn.getAttribute('data-id'); this.flyTo(id); }, {once:true});

                const onClick = (ev)=>{
                    const btn = ev.target.closest('.popup-card__btn--ghost'); if(!btn) return;
                    ev.preventDefault(); ev.stopPropagation();
                    const src = btn.getAttribute('data-source') || btn.getAttribute('source') || btn.getAttribute('href') || '';
                    if (!src){ UI.setHint('No hay fuente GLB/USDZ.'); return; }
                    setTimeout(()=> window.Viewer.onMarkerSourceSelected(src), 0); // abre cámara ya
                };
                root.addEventListener('click', onClick, {passive:false});
                this.map.once('popupclose', (evClose)=>{ if (evClose.popup===e.popup) root.removeEventListener('click', onClick); });
            }

            flyTo(id, zoom=17){ const mk=this.byId[id]; if(!mk) return; const ll=mk.getLatLng(); this.map.flyTo(ll,zoom,{duration:0.35}); mk.openPopup(); }
        }

        /* ===========================================================
         * Eventos de dispositivo / ciclo de vida
         * =========================================================== */
        class DeviceEvents {
            static attach(){
                document.addEventListener('visibilitychange', async ()=>{
                    if (document.hidden){ await window.Viewer?.destroy(); }
                });
                window.addEventListener('pagehide', ()=> window.Viewer?.destroy());
                // (logs opcionales)
                window.addEventListener('orientationchange', ()=>console.log('[orientationchange]'));
                window.addEventListener('resize', ()=>console.log('[resize]', innerWidth, innerHeight));
            }
        }

        /* ===========================================================
         * Datos de ejemplo
         * =========================================================== */
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


        /* ===========================================================
         * Bootstrap
         * =========================================================== */
        document.addEventListener('DOMContentLoaded', ()=>{
            UI.bind();
            window.Viewer = new ViewerOrchestrator();

            const mapCtl = new MapController({});
            mapCtl.init(itemsSources);

            DeviceEvents.attach();

            UI.$reticle?.addEventListener('click', async ()=>{ await window.Viewer.handleReticleTap(); });
            UI.$back?.addEventListener('click', async ()=>{ await window.Viewer.destroy(); });
            UI.$capture?.addEventListener('click', async ()=>{ await window.Viewer.capture(); });
        });

    </script>

@endsection
@section('content')
    <!-- Mensajes de estado -->
    <div id="hint" class="hint">Estado: listo</div>

    <!-- Controles principales -->
    <button id="btn-back-map" class="btn d-none">← Volver al mapa</button>
    <button id="btn-capture" class="btn d-none">📸 Capturar</button>

    <!-- Contenedor de AR/Fallback -->
    <div class="container--custom not-view">
        <!-- Loading transparente con % -->
        <div id="ar-loading" class="loading d-none">
            <div class="loading__center">
                <div class="spinner"></div>
                <div class="loading__text">
                    <strong id="ar-loading-label">Cargando…</strong>
                    <span id="ar-loading-percent">0%</span>
                </div>
            </div>
        </div>

        <!-- Fallback: <model-viewer> -->
        <div id="fallback" class="d-none">
            <model-viewer id="mv"
                          ar ar-modes="scene-viewer quick-look webxr"
                          camera-controls
                          environment-image="neutral"
                          style="width:100%;height:60vh;background:#000">
            </model-viewer>
        </div>
    </div>

    <!-- Retícula (tap aquí para colocar) -->
    <div id="reticle-overlay" class="reticle hidden" aria-hidden="true">
        <div class="reticle__ring"></div>
        <div class="reticle__dot"></div>
        <div class="reticle__hint">Toca la retícula para colocar</div>
    </div>

    <!-- Mapa -->
    <div id="map" class="map"></div>
@endsection
