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

        :root {
            --bg: #0a0a0a;
            --fg: #f5f5f5;
            --muted: #b9bcc4;
            --primary: #2ecc71;
            --ring: rgba(255, 255, 255, 0.9);
            --dot: rgba(255, 255, 255, 0.95);
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
            position: fixed;
            inset: 0;
            background: transparent;
            pointer-events: none;
            display: grid;
            place-items: center;
            z-index: 9998;
        }

        .loading__center {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .spinner {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            border: 6px solid rgba(255, 255, 255, 0.25);
            border-top-color: rgba(255, 255, 255, 0.9);
            animation: spin 1s linear infinite;
        }

        .loading__text {
            margin-top: 10px;
            text-align: center;
            color: #fff;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        .loading__text strong {
            display: block;
            margin-bottom: 4px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .reticle {
            position: fixed;
            inset: 0;
            display: grid;
            place-items: center;
            z-index: 4;
            pointer-events: auto;
        }

        .reticle.hidden {
            display: none;
        }

        .reticle__ring {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            border: 4px solid var(--ring);
            box-shadow: 0 0 16px rgba(255, 255, 255, 0.35);
        }

        .reticle__dot {
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--dot);
        }

        .reticle__hint {
            position: absolute;
            top: calc(50% + 110px);
            left: 50%;
            transform: translateX(-50%);
            font-size: 14px;
            color: var(--muted);
            background: rgba(0, 0, 0, 0.5);
            padding: 6px 8px;
            border-radius: 6px;
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

        :root {
            --bg: #0a0a0a;
            --fg: #f5f5f5;
            --muted: #b9bcc4;
            --ring: rgba(255, 255, 255, 0.9);
            --dot: rgba(255, 255, 255, 0.95);
            --btn: #222;
            --btn-h: #2c2c2c;
            --accent: #2f8;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: var(--bg);
            color: var(--fg);
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Helvetica Neue, Arial;
        }

        .hint {
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

        .btn {
            position: fixed;
            z-index: 10001;
            padding: 8px 12px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .35);
        }

        #btn-back-map {
            top: 12px;
            left: 12px;
            background: var(--btn);
            color: #fff;
        }

        #btn-back-map:hover {
            background: var(--btn-h);
        }

        #btn-capture {
            top: 12px;
            right: 12px;
            background: var(--accent);
            color: #000;
        }

        #btn-capture:hover {
            filter: brightness(.95);
        }

        .map {
            position: fixed;
            inset: 0;
        }

        .not-view {
            display: none !important;
        }

        .d-none {
            display: none !important;
        }

        .container--custom {
            position: relative;
            z-index: 2;
        }

        /* Loading transparente */
        .loading {
            position: fixed;
            inset: 0;
            background: transparent;
            pointer-events: none;
            display: grid;
            place-items: center;
            z-index: 9998;
        }

        .loading__center {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .spinner {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            border: 6px solid rgba(255, 255, 255, .25);
            border-top-color: rgba(255, 255, 255, .9);
            animation: spin 1s linear infinite;
        }

        .loading__text {
            margin-top: 10px;
            text-align: center;
            color: #fff;
            text-shadow: 0 1px 2px rgba(0, 0, 0, .5);
        }

        .loading__text strong {
            display: block;
            margin-bottom: 4px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Retícula */
        .reticle {
            position: fixed;
            inset: 0;
            display: grid;
            place-items: center;
            z-index: 4;
            pointer-events: auto;
        }

        .reticle.hidden {
            display: none;
        }

        .reticle__ring {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            border: 4px solid var(--ring);
            box-shadow: 0 0 16px rgba(255, 255, 255, .35);
        }

        .reticle__dot {
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--dot);
        }

        .reticle__hint {
            position: absolute;
            top: calc(50% + 110px);
            left: 50%;
            transform: translateX(-50%);
            font-size: 14px;
            color: var(--muted);
            background: rgba(0, 0, 0, .5);
            padding: 6px 8px;
            border-radius: 6px;
            backdrop-filter: blur(6px);
        }

        /* Popup (Leaflet) */
        .leaflet-container a {
            color: #1da1f2;
        }

        .popup-card {
            color: #111;
            font-family: inherit;
            width: 280px;
        }

        .popup-card__header {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .popup-card__img {
            width: 56px;
            height: 56px;
            border-radius: 10px;
            object-fit: cover;
        }

        .popup-card__title {
            margin: 0;
            font-size: 16px;
            color: #111;
        }

        .popup-card__subtitle {
            margin: 0;
            font-size: 12px;
            color: #444;
        }

        .popup-card__body {
            margin-top: 8px;
            color: #333;
        }

        .popup-card__footer {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .popup-card__btn {
            padding: 6px 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background: #fff;
            cursor: pointer;
            text-decoration: none;
            color: #111;
        }

        .popup-card__btn--primary {
            background: #111;
            color: #fff;
            border-color: #111;
        }

        .popup-card__btn--ghost {
            background: #fff;
        }

        /* model-viewer */
        model-viewer {
            width: 100%;
            height: 70vh;
            background: #000;
            border-radius: 12px;
        }

        /* Oculto por defecto */
        .d-none {
            display: none;
        }

        /* Vista mini flotante opcional (quita d-none para previsualizar) */
        .snap-canvas {
            position: fixed;
            right: 12px;
            bottom: 12px;
            width: 240px; /* tamaño de vista previa; la resolución real la pone JS */
            height: 135px; /* relación 16:9; ajusta a gusto */
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 8px;
            background: transparent;
            z-index: 3; /* encima del mapa y debajo de UI si quieres */
            box-shadow: 0 6px 18px rgba(0, 0, 0, .2);
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
        class CameraOverlayComposer {
            constructor() {
                this.video = null;         // <video> con getUserMedia
                this.stream = null;        // MediaStream
                this.canvas3D = null;      // canvas 3D (opcional)
                this.composite = null;     // canvas 2D donde se pinta
                this.ctx = null;
                this._raf = 0;
                this._running = false;
                this._include3D = false;
            }

            async start({
                            canvas3D = null,
                            facingMode = 'environment',
                            width = 1280,
                            height = 720,
                            includeCanvas3D = false
                        } = {}) {
                if (this._running) return;
                this.canvas3D = canvas3D || null;
                this._include3D = !!includeCanvas3D;

                // 1) pedir cámara (HTTPS!)
                this.stream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode, width, height },
                    audio: false
                });

                // 2) crear <video>, ponerlo EN EL DOM y esperar eventos clave
                this.video = document.createElement('video');
                this.video.playsInline = true;
                this.video.muted = true;
                this.video.autoplay = true;
                this.video.srcObject = this.stream;

                // tiene que estar en el DOM (algunos móviles no actualizan frames si no está)
                Object.assign(this.video.style, {
                    position: 'fixed',
                    width: '1px',
                    height: '1px',
                    opacity: '0',
                    pointerEvents: 'none',
                    zIndex: '-1',
                    left: '0',
                    top: '0'
                });
                document.body.appendChild(this.video);

                // Esperar metadatos para tener videoWidth / videoHeight
                await new Promise((res, rej) => {
                    const onMeta = () => { cleanup(); res(); };
                    const onErr = (e) => { cleanup(); rej(e); };
                    const cleanup = () => {
                        this.video.removeEventListener('loadedmetadata', onMeta);
                        this.video.removeEventListener('error', onErr);
                    };
                    this.video.addEventListener('loadedmetadata', onMeta, { once: true });
                    this.video.addEventListener('error', onErr, { once: true });
                });

                // Forzar play y esperar a que realmente esté produciendo frames
                try { await this.video.play(); } catch {}
                await new Promise((res) => {
                    // Si ya tenemos dimensiones válidas, seguimos
                    if (this.video.videoWidth > 0 && this.video.videoHeight > 0) return res();
                    const onPlaying = () => { cleanup(); res(); };
                    const onLoadedData = () => {
                        if (this.video.videoWidth > 0 && this.video.videoHeight > 0) { cleanup(); res(); }
                    };
                    const cleanup = () => {
                        this.video.removeEventListener('playing', onPlaying);
                        this.video.removeEventListener('loadeddata', onLoadedData);
                    };
                    this.video.addEventListener('playing', onPlaying, { once: true });
                    this.video.addEventListener('loadeddata', onLoadedData);
                    // fallback por si no llega playing/loadeddata
                    setTimeout(() => { cleanup(); res(); }, 500);
                });

                // 3) canvas compuesto (ajustar al tamaño REAL del video)
                this.composite = document.createElement('canvas');
                this._resizeToVideo(); // usa videoWidth/Height reales
                this.ctx = this.composite.getContext('2d');

                // Puedes dejarlo fuera del DOM (no es necesario mostrarlo)
                // pero si quieres, lo agregas oculto:
                this.composite.style.display = 'none';
                document.body.appendChild(this.composite);

                // 4) loop de composición
                this._running = true;
                const tick = () => {
                    if (!this._running) return;

                    // si cambian dimensiones del stream (raro, pero pasa), reajusta
                    if (this.composite.width !== this.video.videoWidth ||
                        this.composite.height !== this.video.videoHeight) {
                        this._resizeToVideo();
                    }

                    // fondo: cámara
                    this.ctx.drawImage(this.video, 0, 0, this.composite.width, this.composite.height);

                    // encima: 3D (si se pidió)
                    if (this._include3D && this.canvas3D && this.canvas3D.width && this.canvas3D.height) {
                        this.ctx.drawImage(this.canvas3D, 0, 0, this.composite.width, this.composite.height);
                    }

                    this._raf = requestAnimationFrame(tick);
                };
                this._raf = requestAnimationFrame(tick);
            }

            _resizeToVideo() {
                const w = Math.max(1, this.video.videoWidth || 1280);
                const h = Math.max(1, this.video.videoHeight || 720);
                this.composite.width = w;
                this.composite.height = h;
            }

            async snapshotToBlob({ type = 'image/jpeg', quality = 0.95 } = {}) {
                if (!this.composite) return null;

                // Asegurar que el video está listo y con tamaño válido
                if (!this.video || this.video.videoWidth === 0 || this.video.videoHeight === 0) {
                    // espera un par de frames y reintenta
                    await new Promise(r => requestAnimationFrame(r));
                    await new Promise(r => requestAnimationFrame(r));
                    if (!this.video || this.video.videoWidth === 0 || this.video.videoHeight === 0) {
                        console.warn('[CameraOverlayComposer] video sin medidas aún');
                        return null;
                    }
                    this._resizeToVideo();
                }

                // Espera un frame para que el último drawImage se complete
                await new Promise(r => requestAnimationFrame(r));

                return await new Promise(res => this.composite.toBlob(res, type, quality));
            }

            async stop() {
                this._running = false;
                cancelAnimationFrame(this._raf);
                this._raf = 0;

                try { this.stream?.getTracks()?.forEach(t => t.stop()); } catch {}
                this.stream = null;

                if (this.video?.parentNode) this.video.parentNode.removeChild(this.video);
                if (this.composite?.parentNode) this.composite.parentNode.removeChild(this.composite);

                this.video = null;
                this.composite = null;
                this.ctx = null;
                this.canvas3D = null;
                this._include3D = false;
            }
        }


        /* ===========================================================
 * Plataforma + capacidades
 * =========================================================== */
        const Platform = (() => {
            const ua = navigator.userAgent || navigator.vendor || "";
            const isAndroid = /Android/i.test(ua);
            const isIOS = /iPhone|iPad|iPod/i.test(ua) || (navigator.platform === "MacIntel" && navigator.maxTouchPoints > 1);
            const isSecure = location.protocol === "https:" || location.hostname === "localhost";
            return {isAndroid, isIOS, isSecure};
        })();

        async function canUseAR() {
            if (!Platform.isAndroid || !Platform.isSecure || !('xr' in navigator)) return false;
            try {
                return await navigator.xr.isSessionSupported('immersive-ar');
            } catch {
                return false;
            }
        }

        /* ===========================================================
         * UI Manager (con % de carga)
         * =========================================================== */
        const UI = (() => {
            let $ = {};
            const pctText = p => (Math.max(0, Math.min(1, p || 0)) * 100).toFixed(0) + '%';

            function bind() {
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
                setHint(m) {
                    $.hint && ($.hint.textContent = m || '');
                },
                setReticleText(m) {
                    $.retHint && ($.retHint.textContent = m || '');
                },

                showLoading(label = 'Cargando:') {
                    $.loadingLbl && ($.loadingLbl.textContent = label);
                    $.loadingPct && ($.loadingPct.textContent = '0%');
                    show($.loading);
                },
                hideLoading() {
                    hide($.loading);
                },
                resetLoadingProgress(label = 'Cargando:') {
                    $.loadingLbl && ($.loadingLbl.textContent = label);
                    $.loadingPct && ($.loadingPct.textContent = '0%');
                },
                updateLoadingProgress(p) {
                    const t = pctText(p);
                    $.loadingPct && ($.loadingPct.textContent = t);
                    $.loadingLbl && ($.loadingLbl.textContent = `Cargando modelo:`);
                },
                finishLoadingProgress() {
                    $.loadingPct && ($.loadingPct.textContent = '100%');
                    $.loadingLbl && ($.loadingLbl.textContent = 'Modelo cargado.');
                },

                showFallback() {
                    show($.fallback);
                },
                hideFallback() {
                    hide($.fallback);
                },

                revealContainer() {
                    $.container?.classList.remove('not-view');
                },
                showReticle() {
                    $.reticle?.classList.remove('hidden');
                },
                hideReticle() {
                    $.reticle?.classList.add('hidden');
                },

                hideMap() {
                    $.map?.classList.add('not-view');
                    $.back?.classList.remove('d-none');
                },
                showMap() {
                    $.map?.classList.remove('not-view');
                    $.back?.classList.add('d-none');
                },

                showCapture() {
                    $.capture?.classList.remove('d-none');
                },
                hideCapture() {
                    $.capture?.classList.add('d-none');
                },

                get mv() {
                    return $.mv;
                },
                get $fallback() {
                    return $.fallback;
                },
                get $reticle() {
                    return $.reticle;
                },
                get $back() {
                    return $.back;
                },
                get $capture() {
                    return $.capture;
                }
            };
        })();

        /* ===========================================================
         * Utilidades descarga / stats
         * =========================================================== */
        const DownloadUtils = {
            saveBlob(filename, blob) {
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(url);
            }
        };
        const StatsUtils = {
            compute(root) {
                if (!root) return null;
                const box = new THREE.Box3().setFromObject(root);
                const size = new THREE.Vector3();
                box.getSize(size);
                let meshes = 0, tris = 0;
                root.traverse(o => {
                    if (o.isMesh && o.geometry) {
                        meshes++;
                        const g = o.geometry;
                        const t = g.index ? (g.index.count / 3) : (g.attributes?.position ? g.attributes.position.count / 3 : 0);
                        tris += Math.floor(t);
                    }
                });
                return {
                    meshes,
                    triangles: tris,
                    bbox: {x: +size.x.toFixed(4), y: +size.y.toFixed(4), z: +size.z.toFixed(4)}
                };
            }
        };

        /* ===========================================================
         * Fallback <model-viewer> con % de progreso
         * =========================================================== */
        class ModelViewerController {
            constructor(mvEl, hooks = {}) {
                this.mv = mvEl;
                this.hooks = hooks;
                this._bound = false;
            }

            bindOnce() {
                if (this._bound || !this.mv) return;
                this._bound = true;

                this._onARStatus = ev => {
                    const st = ev?.detail?.status;
                    if (st === 'session-started') this.hooks.onEnter && this.hooks.onEnter({mode: 'ios/web-ar'});
                    if (st === 'not-presenting') this.hooks.onExit && this.hooks.onExit({
                        reason: 'ar-status',
                        status: st
                    });
                };
                this._onCameraChange = () => {
                    const o = this.mv.getCameraOrbit?.();
                    this.hooks.onRotate && this.hooks.onRotate({rotY: o?.theta ?? 0, rotX: o?.phi ?? 0});
                    this.hooks.onScale && this.hooks.onScale({scale: o?.radius ?? 0});
                };
                this._onLoad = () => {
                    UI.finishLoadingProgress();
                    UI.hideLoading();
                    UI.setHint('Modelo cargado en visor 3D.');
                };
                this._onError = () => {
                    UI.hideLoading();
                    UI.setHint('Error al cargar en visor 3D.');
                };
                this._onProgress = ev => {
                    const p = ev?.detail?.totalProgress;
                    if (typeof p === 'number') UI.updateLoadingProgress(p);
                };

                this.mv.addEventListener('ar-status', this._onARStatus);
                this.mv.addEventListener('camera-change', this._onCameraChange);
                this.mv.addEventListener('load', this._onLoad);
                this.mv.addEventListener('error', this._onError);
                this.mv.addEventListener('progress', this._onProgress);
            }

            async setSource({glbUrl, usdzUrl}) {
                if (!this.mv) return;

                UI.showFallback();
                UI.showLoading();
                UI.resetLoadingProgress();

                const resolved = AssetPreloader.getBlobURL(glbUrl) || glbUrl || '';
                this.mv.src = resolved;

                // Quick Look NO acepta blob:, solo setear ios-src si es URL http/https
                if (usdzUrl && !resolved.startsWith('blob:')) {
                    this.mv.setAttribute('ios-src', usdzUrl);
                } else {
                    this.mv.removeAttribute('ios-src');
                }

                await new Promise((res, rej) => {
                    const ok = () => {
                        this.mv.removeEventListener('load', ok);
                        res();
                    };
                    const er = () => {
                        this.mv.removeEventListener('error', er);
                        rej();
                    };
                    this.mv.addEventListener('load', ok, {once: true});
                    this.mv.addEventListener('error', er, {once: true});
                });
            }


            destroy() {
                if (!this.mv) return;
                this.mv.removeEventListener('ar-status', this._onARStatus);
                this.mv.removeEventListener('camera-change', this._onCameraChange);
                this.mv.removeEventListener('load', this._onLoad);
                this.mv.removeEventListener('error', this._onError);
                this.mv.removeEventListener('progress', this._onProgress);
                this.mv.src = '';
                this.mv.removeAttribute('ios-src');
                this._bound = false;
            }
        }

        /* ===========================================================
         * Android WebXR (sin hit-test): abre cámara primero; GLB después
         * Gestos móviles: 1 dedo rotar+vertical, 2 dedos pinch+pan
         * =========================================================== */
        class AndroidWebXRController {
            async afterResumeXR() {
                if (!this.renderer) return;

                // Asegura tamaños correctos (al volver de la cámara el viewport suele cambiar)
                try { this._handleResize(); } catch {}

                // Espera un frame del browser
                await new Promise(r => requestAnimationFrame(r));

                // Re-asegura el loop de XR
                try {
                    if (this.session) this.renderer.setAnimationLoop(this._loop);
                } catch {}

                // Fuerza 1–2 renders “en frío” para que ARCore re-tome el swapchain
                try { this.renderer.render(this.scene, this.camera); } catch {}
                await new Promise(r => requestAnimationFrame(r));
                try { this.renderer.render(this.scene, this.camera); } catch {}

                // Si quieres volver a esperar “primer frame XR”:
                // this._firstFrameSeen = false;
                // this.ready = new Promise(res => (this._firstFrameResolve = res));
            }
            async endXRButKeepScene() {
                // Si no hay sesión, nada que hacer
                if (!this.session) return;

                // Quitar listeners de sesión
                try {
                    this.session.removeEventListener('end', this._onEnd);
                    this.session.removeEventListener('visibilitychange', this._onVis);
                } catch {}
                this._onEnd = this._onVis = null;

                // Detener animación de THREE controlada por XR
                try { this.renderer?.setAnimationLoop(null); } catch {}

                // Finalizar XR (esto hace que renderer.xr deje de estar «presenting»)
                try { await this.session.end(); } catch {}

                // Limpia punteros de XR; la escena/renderer/cámara quedan vivas
                this.session = null;
                this._refSpace = null;

                // Asegura renderer transparente para overlay
                if (this.renderer) {
                    this.renderer.setClearAlpha(0);
                }
            }
            constructor(hooks = {}) {
                this.hooks = hooks;
                this.renderer = null;        // Renderer principal (XR)
                this.scene = null;
                this.camera = null;
                this.session = null;
                this.model = null;
                this._refSpace = null;

                this._distanceMeters = 1.2;
                this._loop = this._onXRFrame.bind(this);
                this._onResize = this._handleResize.bind(this);

                // Primer frame de cámara ⇒ mostrar retícula
                this._firstFrameSeen = false;
                this._firstFrameResolve = null;
                this.ready = new Promise(res => (this._firstFrameResolve = res));

                // eventos sesión
                this._onEnd = this._onVis = null;

                // light
                this._lightProbe = null;
                this._headlamp = null;

                // Snapshot / video
                this._snapCanvas = null;
                this._snapCtx = null;
                this._recorder = null;
                this._recChunks = [];
                this._recStream = null;

                // ESPEJO (mirror) no-XR
                this._mirrorRenderer = null;
                this._mirrorCam = null;
                this._mirrorEnabled = true; // si quieres, ponlo en false y actívalo solo al capturar
            }

            /* ========================= Sesión ========================= */
            async startSessionFromGesture() {
                this.session = await navigator.xr.requestSession('immersive-ar', {
                    requiredFeatures: ['local'],
                    optionalFeatures: ['dom-overlay', 'light-estimation'],
                    domOverlay: {root: document.body}
                });

                this._setupRenderer();
                this._setupScene();
                this.renderer.xr.setReferenceSpaceType('local');
                await this.renderer.xr.setSession(this.session);
                this._refSpace = this.renderer.xr.getReferenceSpace();

                // hooks de sesión
                this._onEnd = () => this.hooks.onExit && this.hooks.onExit({reason: 'session-end'});
                this._onVis = () => {
                    const s = this.session?.visibilityState;
                    if (s === 'hidden' || s === 'visible-blurred') {
                        this.hooks.onExit && this.hooks.onExit({reason: 'visibility', state: s});
                    }
                };
                this.session.addEventListener('end', this._onEnd);
                this.session.addEventListener('visibilitychange', this._onVis);

                // light-probe
                try {
                    if (this.session.requestLightProbe) {
                        this._lightProbe = await this.session.requestLightProbe({type: 'spherical-harmonics'});
                    }
                } catch {
                }

                // gestos
                this._bindGesturesMobile();

                // canvas snapshot (usa #snap-canvas si existe; si no, crea uno oculto)
                this._ensureSnapCanvas();

                window.addEventListener('resize', this._onResize);
                this.hooks.onEnter && this.hooks.onEnter({mode: 'android-webxr'});
            }

            async loadModel(glbUrl) {
                await this._disposeModel();
                if (!glbUrl) return;

                const resolved = AssetPreloader.getBlobURL(glbUrl) || glbUrl;

                UI.showLoading();
                UI.resetLoadingProgress();
                await new Promise((res, rej) => {
                    const loader = new THREE.GLTFLoader();
                    // if (loader.setCrossOrigin) loader.setCrossOrigin('anonymous'); // activar si usas texturas cross-origin

                    loader.load(
                        resolved,
                        (gltf) => {
                            this.model = gltf.scene;

                            // Escala ≈1m
                            const box = new THREE.Box3().setFromObject(this.model);
                            const size = new THREE.Vector3();
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

                            UI.finishLoadingProgress();
                            UI.hideLoading();
                            res();
                        },
                        (xhr) => {
                            if (xhr && xhr.lengthComputable) {
                                const p = xhr.total ? (xhr.loaded / xhr.total) : 0;
                                UI.updateLoadingProgress(p);
                            }
                        },
                        (err) => {
                            UI.hideLoading();
                            UI.setHint('Error al cargar modelo.');
                            rej(err);
                        }
                    );
                });
            }

            placeInFront() {
                this._placeInFront();
            }

            async stop() {
                try {
                    window.removeEventListener('resize', this._onResize);
                } catch {
                }
                try {
                    this.renderer?.setAnimationLoop(null);
                } catch {
                }
                await this._disposeModel();

                // detener grabación si estaba activa
                try {
                    if (this._recorder && this._recorder.state !== 'inactive') this._recorder.stop();
                } catch {
                }
                this._recorder = null;
                this._recChunks = [];
                this._recStream = null;

                if (this.session) {
                    try {
                        await this.session.end();
                    } catch {
                    }
                    try {
                        this.session.removeEventListener('end', this._onEnd);
                        this.session.removeEventListener('visibilitychange', this._onVis);
                    } catch {
                    }
                }

                if (this.renderer?.domElement?.parentNode) this.renderer.domElement.parentNode.removeChild(this.renderer.domElement);
                try {
                    this.renderer?.dispose?.();
                } catch {
                }

                // limpiar snap canvas si lo agregaste al DOM (solo si se creó dinámico)
                if (this._snapCanvas && this._snapCanvas.id !== 'snap-canvas' && this._snapCanvas.parentNode) {
                    this._snapCanvas.parentNode.removeChild(this._snapCanvas);
                }
                this._snapCanvas = null;
                this._snapCtx = null;

                // espejo
                try {
                    this._mirrorRenderer?.dispose?.();
                } catch {
                }
                this._mirrorRenderer = null;
                this._mirrorCam = null;

                this.renderer = this.scene = this.camera = this.session = this._refSpace = null;
                this._firstFrameSeen = false;
                this.ready = new Promise(res => (this._firstFrameResolve = res));
            }

            /* ========================= Setup ========================= */
            _setupRenderer() {
                if (this.renderer) return;

                // Renderer principal (XR)
                this.renderer = new THREE.WebGLRenderer({
                    antialias: true,
                    alpha: true,
                    powerPreference: 'high-performance',
                    preserveDrawingBuffer: true // necesario para snapshots consistentes
                });
                this.renderer.xr.enabled = true;
                this.renderer.outputEncoding = THREE.sRGBEncoding;
                this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
                this.renderer.toneMappingExposure = 1.2;
                this.renderer.physicallyCorrectLights = true;
                this.renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
                this._handleResize();
                this.renderer.setClearAlpha(0);
                Object.assign(this.renderer.domElement.style, {
                    position: 'fixed',
                    inset: '0',
                    width: '100%',
                    height: '100%',
                    zIndex: '1',
                    touchAction: 'none'
                });
                document.body.appendChild(this.renderer.domElement);

                // === MIRROR: renderer secundario NO XR (oculto) ===
                this._mirrorRenderer = new THREE.WebGLRenderer({
                    antialias: true,
                    alpha: true,
                    preserveDrawingBuffer: true
                });
                this._mirrorRenderer.setClearAlpha(0);
                this._mirrorRenderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
                // Si quieres ver el espejo para debug, descomenta:
                // Object.assign(this._mirrorRenderer.domElement.style, { position:'fixed', right:'8px', bottom:'8px', width:'200px', height:'120px', zIndex:'2', border:'1px solid #fff3' });
                // document.body.appendChild(this._mirrorRenderer.domElement);

                // Cámara espejo
                this._mirrorCam = new THREE.PerspectiveCamera(60, 1, 0.01, 20);
            }

            _setupScene() {
                this.scene = new THREE.Scene();
                const aspect = Math.max(innerWidth, 1) / Math.max(innerHeight, 1);
                this.camera = new THREE.PerspectiveCamera(60, aspect, 0.01, 20);
                const hemi = new THREE.HemisphereLight(0xffffff, 0x404040, 0.8);
                const dir = new THREE.DirectionalLight(0xffffff, 0.8);
                dir.position.set(0, 1, -1);
                this._headlamp = new THREE.PointLight(0xffffff, 1.3, 12, 2.0);
                this.camera.add(this._headlamp);
                this.scene.add(this.camera, hemi, dir);
                this.renderer.setAnimationLoop(this._loop);
            }

            /* ========================= Frame loop ========================= */
            _onXRFrame(time, frame) {
                if (!frame || !this._refSpace) {
                    // Render normal (fuera de XR)
                    this.renderer.render(this.scene, this.camera);

                    // ESPEJO fuera de XR
                    if (this._mirrorEnabled) {
                        this._renderMirror(this.camera);
                        this._copyToSnapCanvasFrom(this._mirrorRenderer.domElement);
                    }
                    return;
                }

                const pose = frame.getViewerPose(this._refSpace);

                if (!this._firstFrameSeen && pose) {
                    this._firstFrameSeen = true;
                    try {
                        this._firstFrameResolve && this._firstFrameResolve();
                    } catch {
                    }
                    UI.setHint('Cámara lista. Toca la retícula para colocar el modelo.');
                    UI.setReticleText('Toca para colocar el modelo');
                    UI.showReticle();
                }

                if (this._lightProbe) {
                    try {
                        const est = frame.getLightEstimate(this._lightProbe);
                        if (est?.primaryLightIntensity) {
                            const i = Math.max(0.7, Math.min(2.0, est.primaryLightIntensity.x));
                            this._headlamp.intensity = i;
                        }
                    } catch {
                    }
                }

                // Render principal en XR layer (lo que ve el usuario)
                this.renderer.render(this.scene, this.camera);

                // ESPEJO cada frame (no-XR) para poder copiar píxeles
                if (this._mirrorEnabled) {
                    const xrCam = this.renderer.xr.getCamera(this.camera); // cámara compuesta XR
                    this._renderMirror(xrCam);
                    this._copyToSnapCanvasFrom(this._mirrorRenderer.domElement);
                }
            }

            _renderMirror(srcCam) {
                if (!this._mirrorRenderer || !this._mirrorCam) return;

                // Copiar pose/proyección
                this._mirrorCam.matrixWorld.copy(srcCam.matrixWorld);
                this._mirrorCam.matrixWorldInverse.copy(srcCam.matrixWorldInverse);
                this._mirrorCam.projectionMatrix.copy(srcCam.projectionMatrix);
                if (srcCam.projectionMatrixInverse) {
                    this._mirrorCam.projectionMatrixInverse = srcCam.projectionMatrixInverse.clone();
                } else {
                    // @ts-ignore
                    this._mirrorCam.projectionMatrixInverse = this._mirrorCam.projectionMatrix.clone().invert();
                }
                this._mirrorCam.position.setFromMatrixPosition(this._mirrorCam.matrixWorld);
                this._mirrorCam.quaternion.setFromRotationMatrix(this._mirrorCam.matrixWorld);
                this._mirrorCam.updateMatrixWorld(true);

                // Render escena en renderer espejo (NO XR)
                this._mirrorRenderer.render(this.scene, this._mirrorCam);
            }

            _copyToSnapCanvasFrom(srcCanvas) {
                if (!this._snapCanvas || !this._snapCtx || !srcCanvas) return;
                const w = srcCanvas.width, h = srcCanvas.height;
                if (!w || !h) return;

                if (this._snapCanvas.width !== w) this._snapCanvas.width = w;
                if (this._snapCanvas.height !== h) this._snapCanvas.height = h;

                this._snapCtx.clearRect(0, 0, w, h);
                this._snapCtx.drawImage(srcCanvas, 0, 0, w, h);
            }

            // compat si en algún lado llamas sin args
            _copyToSnapCanvas() {
                if (this._mirrorRenderer) this._copyToSnapCanvasFrom(this._mirrorRenderer.domElement);
            }

            _handleResize() {
                if (!this.renderer) return;
                const w = Math.max(innerWidth, 1), h = Math.max(innerHeight, 1);
                this.renderer.setSize(w, h);
                if (this.camera && h > 0) {
                    this.camera.aspect = w / h;
                    this.camera.updateProjectionMatrix();
                }
                // espejo
                if (this._mirrorRenderer && this._mirrorCam) {
                    this._mirrorRenderer.setSize(w, h);
                    this._mirrorCam.aspect = w / h;
                    this._mirrorCam.updateProjectionMatrix();
                }
                // snap
                if (this._snapCanvas) {
                    this._snapCanvas.width = w;
                    this._snapCanvas.height = h;
                }
            }

            /* ========================= Colocar modelo ========================= */
            _placeInFront() {
                if (!this.model || !this.camera) return;
                const fwd = new THREE.Vector3(0, 0, -1).applyQuaternion(this.camera.quaternion).normalize();
                const pos = new THREE.Vector3().copy(this.camera.position).add(fwd.multiplyScalar(this._distanceMeters));
                this.model.position.copy(pos);
                this.model.position.y -= 0.1;
                this.model.lookAt(this.camera.position.x, this.model.position.y, this.camera.position.z);
                if (!this.model.parent) this.scene.add(this.model);
                UI.setHint('Modelo colocado.');
            }

            async _disposeModel() {
                if (!this.model) return;
                this.scene?.remove(this.model);
                this.model.traverse(o => {
                    if (o.isMesh) {
                        o.geometry?.dispose?.();
                        const m = o.material;
                        (Array.isArray(m) ? m : [m]).forEach(mm => mm?.dispose?.());
                    }
                });
                this.model = null;
            }

            /* ========================= Gestos móviles ========================= */
            _pixelsToMetersAtDistance(d) {
                const h = 2 * Math.tan(THREE.MathUtils.degToRad(this.camera.fov * 0.5)) * d;
                return h / Math.max(1, this.renderer.getSize(new THREE.Vector2()).y);
            }

            _bindGesturesMobile() {
                const dom = this.renderer.domElement;
                dom.style.touchAction = 'none';
                const st = {mode: 'none', lastX: 0, lastY: 0, lastDist: 0, lastCx: 0, lastCy: 0};
                const ROT_S = 0.012, ZOOM_S = 0.004, clamp = (s) => THREE.MathUtils.clamp(s, 0.2, 3.0);
                let raf = null, dRot = 0, dZoom = 1, panDX = 0, panDY = 0;
                const apply = () => {
                    raf = null;
                    if (!this.model) return;
                    if (dRot) {
                        this.model.rotation.y += dRot;
                        dRot = 0;
                    }
                    if (dZoom !== 1) {
                        const s = clamp(this.model.scale.x * dZoom);
                        this.model.scale.setScalar(s);
                        dZoom = 1;
                    }
                    if (panDX || panDY) {
                        const dCam = this.camera.position.distanceTo(this.model.position),
                            px2m = this._pixelsToMetersAtDistance(Math.max(0.01, dCam));
                        const right = new THREE.Vector3(1, 0, 0).applyQuaternion(this.camera.quaternion);
                        const up = new THREE.Vector3(0, 1, 0).applyQuaternion(this.camera.quaternion);
                        this.model.position.addScaledVector(right, panDX * px2m);
                        this.model.position.addScaledVector(up, -panDY * px2m);
                        panDX = panDY = 0;
                    }
                };
                const queue = () => {
                    if (!raf) raf = requestAnimationFrame(apply);
                };

                const onStart = e => {
                    if (e.touches.length === 1) {
                        st.mode = 'one';
                        st.lastX = e.touches[0].clientX;
                        st.lastY = e.touches[0].clientY;
                    } else if (e.touches.length >= 2) {
                        st.mode = 'two';
                        const [a, b] = e.touches;
                        st.lastDist = Math.hypot(a.clientX - b.clientX, a.clientY - b.clientY);
                        st.lastCx = (a.clientX + b.clientX) * .5;
                        st.lastCy = (a.clientY + b.clientY) * .5;
                    }
                };
                const onMove = e => {
                    if (!this.model) return;
                    e.preventDefault();
                    if (st.mode === 'one' && e.touches.length === 1) {
                        const t = e.touches[0], dx = t.clientX - st.lastX, dy = t.clientY - st.lastY;
                        dRot += -dx * ROT_S;          // izquierda↔derecha rota
                        dZoom *= (1 - dy * ZOOM_S);   // arriba agranda / abajo reduce
                        st.lastX = t.clientX;
                        st.lastY = t.clientY;
                        queue();
                        return;
                    }
                    if (st.mode === 'two' && e.touches.length >= 2) {
                        const [a, b] = e.touches;
                        const dist = Math.hypot(a.clientX - b.clientX, a.clientY - b.clientY);
                        dZoom *= dist / Math.max(1, st.lastDist);
                        st.lastDist = dist;
                        const cx = (a.clientX + b.clientX) * .5, cy = (a.clientY + b.clientY) * .5;
                        panDX += (cx - st.lastCx);
                        panDY += (cy - st.lastCy);
                        st.lastCx = cx;
                        st.lastCy = cy;
                        queue();
                        return;
                    }
                };
                const onEnd = () => {
                    st.mode = 'none';
                };

                dom.addEventListener('touchstart', onStart, {passive: true});
                dom.addEventListener('touchmove', onMove, {passive: false});
                dom.addEventListener('touchend', onEnd, {passive: true});
                dom.addEventListener('touchcancel', onEnd, {passive: true});
            }

            /* ========================= API util ========================= */
            getCanvas() {
                return this.renderer?.domElement || null;
            }

            getModelStats() {
                return StatsUtils.compute(this.model) || {};
            }

            _ensureSnapCanvas() {
                if (this._snapCanvas) return;
                const external = document.getElementById('snap-canvas');
                if (external) {
                    this._snapCanvas = external;
                    this._snapCtx = this._snapCanvas.getContext('2d', {willReadFrequently: false});
                } else {
                    this._snapCanvas = document.createElement('canvas');
                    this._snapCtx = this._snapCanvas.getContext('2d', {willReadFrequently: false});
                    this._snapCanvas.style.display = 'none';
                    document.body.appendChild(this._snapCanvas);
                }
                const w = Math.max(innerWidth, 1), h = Math.max(innerHeight, 1);
                this._snapCanvas.width = w;
                this._snapCanvas.height = h;
            }

            _timestamp() {
                const p = (n, s = 2) => String(n).padStart(s, '0');
                const d = new Date();
                return `${d.getFullYear()}${p(d.getMonth() + 1)}${p(d.getDate())}-${p(d.getHours())}${p(d.getMinutes())}${p(d.getSeconds())}`;
            }

            // Captura con config y defaults de alta calidad
            async capture({
                              type = 'image/jpeg',
                              quality = 0.95,
                              background = '#ffffff',
                              filename,
                              download = true
                          } = {}) {
                // OPCIÓN: activar espejo solo en la captura (ahorra batería):
                // const prev = this._mirrorEnabled; this._mirrorEnabled = true;

                if (!this._snapCanvas) this._ensureSnapCanvas();
                if (!this._snapCanvas || !this._snapCtx) throw new Error('Snap canvas no disponible');

                // forzar un frame antes de capturar para asegurar espejo actualizado
                await new Promise(r => requestAnimationFrame(r));

                const src = this._mirrorRenderer?.domElement;
                if (!src || !src.width || !src.height) throw new Error('Espejo no disponible');

                // sincroniza tamaños
                if (this._snapCanvas.width !== src.width) this._snapCanvas.width = src.width;
                if (this._snapCanvas.height !== src.height) this._snapCanvas.height = src.height;

                const w = this._snapCanvas.width, h = this._snapCanvas.height;

                if (background) {
                    this._snapCtx.fillStyle = background;
                    this._snapCtx.fillRect(0, 0, w, h);
                } else {
                    this._snapCtx.clearRect(0, 0, w, h);
                }

                // copiar render espejo (solo 3D; la cámara real NO se incluye en WebXR)
                this._snapCtx.drawImage(src, 0, 0, w, h);

                await new Promise(r => requestAnimationFrame(r));

                const blob = await new Promise(res => this._snapCanvas.toBlob(res, type, quality));
                if (!blob) throw new Error('No se pudo generar la imagen');

                let url = null;
                if (download) {
                    url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    const ext = type === 'image/png' ? 'png' : (type === 'image/webp' ? 'webp' : 'jpg');
                    a.href = url;
                    a.download = filename || `ar-frame-${this._timestamp()}.${ext}`;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    setTimeout(() => URL.revokeObjectURL(url), 1000);
                }

                // this._mirrorEnabled = prev; // si activaste espejo “solo para capturar”
                return {blob, url};
            }

            /* ========================= Grabación video (solo 3D) ========================= */
            startRecording({fps = 30, mimeType = 'video/webm;codecs=vp9'} = {}) {
                if (!this._mirrorRenderer) return false;
                if (this._recorder && this._recorder.state === 'recording') return true;

                const canvas = this._mirrorRenderer.domElement; // grabamos el espejo (no-XR)
                this._recStream = canvas.captureStream(fps);
                try {
                    this._recorder = new MediaRecorder(this._recStream, {mimeType});
                } catch {
                    this._recorder = new MediaRecorder(this._recStream);
                }

                this._recChunks = [];
                this._recorder.ondataavailable = e => {
                    if (e.data && e.data.size) this._recChunks.push(e.data);
                };
                this._recorder.onstop = () => {
                    this._recStream = null;
                };
                this._recorder.start();
                return true;
            }

            async stopRecordingAndGetBlob() {
                if (!this._recorder || this._recorder.state === 'inactive') return null;
                const done = new Promise(resolve => {
                    this._recorder.onstop = () => {
                        const blob = new Blob(this._recChunks, {type: this._recorder.mimeType || 'video/webm'});
                        this._recChunks = [];
                        this._recStream = null;
                        resolve(blob);
                    };
                });
                this._recorder.stop();
                return await done;
            }

            async stopRecordingAndDownload(filename = 'ar-capture.webm') {
                const blob = await this.stopRecordingAndGetBlob();
                if (!blob) return false;
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(url);
                return true;
            }
        }


        /* ===========================================================
         * Viewer (Orquestador) — flujo exacto solicitado
         * =========================================================== */
        class ViewerOrchestrator {
            // 1) Capturar SOLO CÁMARA → Blob
            async captureCameraFrameBlob() {
                const st = this._state;
                if (st.mode !== 'android-webxr' || !st.controller) {
                    UI.setHint('Cámara: no hay sesión AR WEBactiva.');
                    return null;
                }

                const composer = new CameraOverlayComposer();

                // Guardar si hay modelo y su transform (por si acaso)
                const hadModel = !!st.controller.model;
                const saved = hadModel ? {
                    pos: st.controller.model.position.clone(),
                    quat: st.controller.model.quaternion.clone(),
                    scl: st.controller.model.scale.clone()
                } : null;

                try {
                    // Pausar XR sin destruir escena
                    await st.controller.endXRButKeepScene();

                    // NO necesitamos render 3D para cámara sola, pero si quieres mantener vista, puedes:
                    // st.controller.startOverlayRenderLoop();  // opcional para ver el 3D, aquí NO lo usamos

                    // Arrancar cámara (solo cámara, sin 3D)
                    await composer.start({includeCanvas3D: false});

                    // Estabilizar
                    await new Promise(r => setTimeout(r, 250));

                    // Foto
                    const camBlob = await composer.snapshotToBlob({type: 'image/jpeg', quality: 0.95});
                    console.log("camBlob",camBlob);
                    return camBlob || null;
                } catch (e) {
                    console.error('[captureCameraFrameBlob] error', e);
                    return null;
                } finally {
                    try {
                        await composer.stop();
                    } catch {
                    }
                    // st.controller.stopOverlayRenderLoop(); // si lo activaste
                    // Reanudar XR y restaurar modelo
                    try {
                        await st.controller.resumeXRSession();


                    } catch {
                    }
                    if (hadModel && saved) {
                        st.controller.model.position.copy(saved.pos);
                        st.controller.model.quaternion.copy(saved.quat);
                        st.controller.model.scale.copy(saved.scl);
                    }
                }
            }

// 2) Capturar SOLO MODELO → Blob (tu propio capture, sin descargar)
            async captureModelFrameBlob() {
                const st = this._state;
                if (st.mode === 'android-webxr' && typeof st.controller?.capture === 'function') {
                    const {blob} = await st.controller.capture({
                        type: 'image/png',        // PNG mantiene alfa del modelo (ideal para overlay)
                        quality: 1.0,
                        background: null,         // IMPORTANTE: sin fondo para conservar transparencia
                        download: false
                    });
                    return blob || null;
                }

                // Fallback <model-viewer>
                if (st.mode !== 'android-webxr' && UI.mv?.shadowRoot) {
                    const cnv = UI.mv.shadowRoot.querySelector('canvas');
                    if (cnv && cnv.width && cnv.height) {
                        const tmp = document.createElement('canvas');
                        tmp.width = cnv.width;
                        tmp.height = cnv.height;
                        const ctx = tmp.getContext('2d');
                        ctx.clearRect(0, 0, tmp.width, tmp.height); // sin fondo → alfa
                        ctx.drawImage(cnv, 0, 0);
                        const blob = await new Promise(res => tmp.toBlob(res, 'image/png', 1.0));
                        return blob || null;
                    }
                }
                return null;
            }

// 3) Flujo completo: cámara (fondo) + modelo (encima) → merge → guardar
            async captureCameraPlusModelAndSave() {
                const st = this._state;
                if (!st.controller) {
                    UI.setHint('No hay sesión activa para capturar.');
                    return;
                }

                const id = st.lastSource?.id || 'snapshot';
                const t = new Date(), pad = n => String(n).padStart(2, '0');
                const filename = `${id}-${t.getFullYear()}${pad(t.getMonth() + 1)}${pad(t.getDate())}-${pad(t.getHours())}${pad(t.getMinutes())}${pad(t.getSeconds())}.jpg`;

                try {


                    // 2) modelo después (Blob con alfa)
                    const modelBlob = await this.captureModelFrameBlob();
                    // 1) cámara primero (Blob)
                    const cameraBlob = await this.captureCameraFrameBlob();
                    if (!cameraBlob && !modelBlob) {
                        UI.setHint('No se pudo capturar cámara ni modelo.');
                        return;
                    }

                    // 3) merge (cámara=fondo, modelo=encima)
                    console.log("cameraBlob",cameraBlob ,"modelBlob", modelBlob);
                    if (cameraBlob && modelBlob) {
                        const merged = await this.mergeCameraAndModelBlobs({
                            cameraBlob,
                            modelBlob,
                            outType: 'image/jpeg',
                            quality: 0.95,
                            cameraMode: 'cover',
                            modelMode: 'contain',
                            modelOpacity: 1.0,
                            background: '#ffffff' // aplana alfa del modelo sobre blanco
                        });
                        if (merged) {
                            DownloadUtils.saveBlob(filename, merged);
                            UI.setHint('Imagen (cámara+modelo) guardada.');
                            return;
                        }
                    }

                    // Si solo tenemos uno, guarda el disponible
                    if (cameraBlob) {
                        DownloadUtils.saveBlob(filename, cameraBlob);
                        UI.setHint('Imagen (solo cámara) guardada.');
                        return;
                    }
                    if (modelBlob) {
                        // Si guardas PNG mantienes alfa
                        const namePNG = filename.replace(/\.jpg$/i, '.png');
                        DownloadUtils.saveBlob(namePNG, modelBlob);
                        UI.setHint('Imagen (solo modelo) guardada.');
                        return;
                    }
                } catch (e) {
                    console.error('[captureCameraPlusModelAndSave] error', e);
                    UI.setHint('Error al capturar.');
                }
            }

            constructor() {
                this._state = {mode: null, controller: null, pendingGLB: null, arReady: false, lastSource: null};
            }

            get state() {
                return this._state;
            }


            isActive() {
                return !!this._state.controller;
            }

            // 1) Click en “Ver en 3D” ⇒ abre cámara (sin GLB) o fallback
            async onMarkerSourceSelected(input) {
                // Soporta string (legacy) o { id, glbUrl }
                let id = null;
                let raw = null;

                if (typeof input === 'string') {
                    raw = input;
                    const match = ItemsStore.getItems().find(i => i.sources?.glb === input);
                    id = match?.id ?? null;
                } else {
                    id = input?.id ?? null;
                    raw = input?.glbUrl ?? '';
                }

                // Si hay blob precargado, úsalo; si no, usa el URL original
                const blob = AssetPreloader.getBlobURL(raw);
                const glbUrl = blob || raw;

                // Quick Look no soporta blob: genera .usdz solo si no es blob
                const usdzUrl = (!glbUrl?.startsWith('blob:') && glbUrl?.endsWith?.('.glb'))
                    ? glbUrl.replace(/\.glb$/i, '.usdz')
                    : '';

                this._state.lastSource = {id, glb: glbUrl, usdz: usdzUrl};

                UI.revealContainer();
                UI.hideMap();
                UI.hideFallback();

                if (await canUseAR()) {
                    try {
                        UI.showLoading('Abriendo cámara…');
                        const ctrl = new AndroidWebXRController({
                            onEnter: () => UI.setHint('Cámara iniciada.'),
                            onExit: async ({reason}) => {
                                UI.setHint(`Sesión finalizada (${reason || 'desconocido'}).`);
                                await this.destroy();
                            }
                        });

                        await ctrl.startSessionFromGesture(); // SOLO cámara
                        this._state.mode = 'android-webxr';
                        this._state.controller = ctrl;
                        this._state.pendingGLB = glbUrl; // diferido: carga en tap

                        // Espera primer frame ⇒ mostramos retícula
                        await ctrl.ready;
                        UI.hideLoading();
                        UI.showReticle();
                        UI.setHint('Toca la retícula para colocar.');
                        UI.showCapture();
                        return;
                    } catch (e) {
                        console.warn('No se pudo iniciar WebXR, usando fallback', e);
                    }
                }

                // Fallback <model-viewer>
                UI.showFallback();
                UI.showLoading();
                UI.resetLoadingProgress();

                const mvCtrl = new ModelViewerController(UI.mv, {
                    onEnter: ({mode}) => UI.setHint(`AR activo (${mode}).`)
                });
                mvCtrl.bindOnce();

                await mvCtrl.setSource({glbUrl: glbUrl, usdzUrl});
                this._state.mode = Platform.isIOS ? 'ios-quicklook' : 'web-fallback';
                this._state.controller = mvCtrl;
                this._state.pendingGLB = null;

                UI.showCapture();
                UI.hideLoading();
            }


            // 2) Click en retícula ⇒ carga GLB con % y coloca
            async handleReticleTap() {
                if (this._state.mode !== 'android-webxr' || !this._state.controller) return;
                const glb = this._state.pendingGLB;
                if (!glb) {
                    UI.setHint('No hay modelo seleccionado.');
                    return;
                }

                UI.showLoading('Cargando modelo…');
                UI.resetLoadingProgress();
                try {
                    await this._state.controller.loadModel(glb);
                    this._state.controller.placeInFront();
                    UI.hideLoading();
                    UI.hideReticle();
                    UI.setHint('Modelo colocado.');
                    this._state.pendingGLB = null;
                } catch {
                    UI.hideLoading();
                    UI.setHint('Error al cargar el modelo.');
                }
            }

// Ajusta cómo encajar cada imagen en el lienzo final: "cover" o "contain"
            _fitRect(srcW, srcH, dstW, dstH, mode = 'cover') {
                const sr = srcW / srcH, dr = dstW / dstH;
                let w, h;
                if (mode === 'cover' ? (sr > dr) : (sr < dr)) {
                    h = dstH;
                    w = h * sr;
                } else {
                    w = dstW;
                    h = w / sr;
                }
                return {x: (dstW - w) * .5, y: (dstH - h) * .5, w, h};
            }


            async mergeCameraAndModelBlobs({
                                               cameraBlob, modelBlob,
                                               outType = 'image/jpeg', quality = 0.95,
                                               width, height,
                                               cameraMode = 'cover', modelMode = 'contain',
                                               modelOpacity = 1.0, background = '#ffffff'
                                           } = {}) {
                if (!cameraBlob || !modelBlob) throw new Error('merge: faltan blobs.');
                const camBmp = await createImageBitmap(cameraBlob, {imageOrientation: 'from-image'}).catch(() => null);
                const mdlBmp = await createImageBitmap(modelBlob, {imageOrientation: 'from-image'}).catch(() => null);
                if (!camBmp || !mdlBmp) throw new Error('merge: decode falló.');

                const W = width || camBmp.width || 1280;
                const H = height || camBmp.height || 720;
                const cnv = (typeof OffscreenCanvas !== 'undefined') ? new OffscreenCanvas(W, H) : Object.assign(document.createElement('canvas'), {
                    width: W,
                    height: H
                });
                if (!('width' in cnv)) {
                    cnv.width = W;
                    cnv.height = H;
                }
                const ctx = cnv.getContext('2d');

                if (background) {
                    ctx.fillStyle = background;
                    ctx.fillRect(0, 0, W, H);
                } else {
                    ctx.clearRect(0, 0, W, H);
                }

                const rc = this._fitRect(camBmp.width, camBmp.height, W, H, cameraMode);
                ctx.drawImage(camBmp, rc.x, rc.y, rc.w, rc.h);

                const rm = this._fitRect(mdlBmp.width, mdlBmp.height, W, H, modelMode);
                const prev = ctx.globalAlpha;
                ctx.globalAlpha = Math.max(0, Math.min(1, modelOpacity));
                ctx.drawImage(mdlBmp, rm.x, rm.y, rm.w, rm.h);
                ctx.globalAlpha = prev;

                const toBlob = (canvas, type, q) => new Promise(res => {
                    if (canvas.convertToBlob) canvas.convertToBlob({type, quality: q}).then(res).catch(() => res(null));
                    else canvas.toBlob(res, type, q);
                });
                const out = await toBlob(cnv, outType, quality);
                try {
                    camBmp.close?.();
                    mdlBmp.close?.();
                } catch {
                }
                return out;
            }

            // 4) Salir siempre al mapa y limpiar
            async destroy() {
                try {
                    if (this._state.controller) {
                        if (this._state.mode === 'android-webxr') await this._state.controller.stop();
                        else this._state.controller.destroy();
                    }
                } catch {
                }
                this._state = {
                    mode: null,
                    controller: null,
                    pendingGLB: null,
                    arReady: false,
                    lastSource: this._state.lastSource
                };
                UI.hideFallback();
                UI.hideReticle();
                UI.hideCapture();
                UI.showMap();
                UI.setHint('');
            }

        }

        /* ===========================================================
         * Mapa (Leaflet) — abre cámara al click en “Ver en 3D”
         * =========================================================== */
        class MapController {
            constructor(cfg) {
                this.cfg = Object.assign({
                    zoom: 14, maxZoom: 25, position: [0.20830, -78.22798],
                    tileUrl: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                    tileAttribution: '&copy; OpenStreetMap contribuyentes'
                }, cfg || {});
                this.map = null;
                this.layer = null;
                this.byId = {};
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
                    this._bindPopup(e);
                    const mk = e.popup._source;
                    if (mk) {
                        requestAnimationFrame(() => this.map.flyTo(mk.getLatLng(), Math.max(this.cfg.zoom, 17), {duration: 0.35}));
                    }
                });
            }

            render(items) {
                this.layer.clearLayers();
                this.byId = {};
                const bounds = [];
                items.forEach(it => {
                    const icon = L.icon({
                        iconUrl: it.sources.img,
                        iconSize: [60, 60],
                        iconAnchor: [60, 60],
                        popupAnchor: [0, -40]
                    });
                    const mk = L.marker([it.position.lat, it.position.lng], {icon, title: it.title})
                        .bindPopup(this._popupHTML(it), {maxWidth: 320, autoPan: true, keepInView: true});
                    mk.addTo(this.layer);
                    mk.on('click', () => {
                        this.map.flyTo(mk.getLatLng(), Math.max(this.cfg.zoom, 17), {duration: 0.35});
                        mk.openPopup();
                    });
                    this.byId[it.id] = mk;
                    bounds.push([it.position.lat, it.position.lng]);
                });
                if (bounds.length) this.map.fitBounds(bounds, {padding: [40, 40]});
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
        <a class="popup-card__btn popup-card__btn--ghost"
           data-action="view3d"
           data-id="${item.id}"
           rel="noopener noreferrer">Ver en 3D</a>
      </footer>
    </article>`;
            }


            _bindPopup(e) {
                const root = e.popup.getElement();
                if (!root) return;

                L.DomEvent.disableClickPropagation(root);
                L.DomEvent.disableScrollPropagation(root);

                const centerBtn = root.querySelector('.popup-card__btn[data-action="center"]');
                centerBtn?.addEventListener('click', (ev) => {
                    ev.preventDefault();
                    const id = centerBtn.getAttribute('data-id');
                    this.flyTo(id);
                }, {once: true});

                // Precarga “amable” del GLB al abrir el popup (no bloquea UI)
                const idForWarm = root.querySelector('[data-action="view3d"]')?.dataset?.id;
                if (idForWarm) {
                    ItemsStore.warmById(idForWarm).catch(() => {
                    });
                }

                const onClick = (ev) => {
                    const btn = ev.target.closest('[data-action="view3d"]');
                    if (!btn) return;
                    ev.preventDefault();
                    ev.stopPropagation();

                    const id = btn.dataset.id;
                    const best = ItemsStore.getBestGlbUrl(id)
                        || ItemsStore.getItemById(id)?.sources?.glb
                        || '';

                    if (!best) {
                        UI.setHint('No hay fuente GLB/USDZ.');
                        return;
                    }

                    // Llama al visor pasando { id, glbUrl } para que él resuelva blob/URL
                    setTimeout(() => window.Viewer.onMarkerSourceSelected({id, glbUrl: best}), 0);
                };

                root.addEventListener('click', onClick, {passive: false});
                this.map.once('popupclose', (evClose) => {
                    if (evClose.popup === e.popup) root.removeEventListener('click', onClick);
                });
            }


            flyTo(id, zoom = 17) {
                const mk = this.byId[id];
                if (!mk) return;
                const ll = mk.getLatLng();
                this.map.flyTo(ll, zoom, {duration: 0.35});
                mk.openPopup();
            }
        }

        /* ===========================================================
         * Eventos de dispositivo / ciclo de vida
         * =========================================================== */
        class DeviceEvents {
            static attach() {
                document.addEventListener('visibilitychange', async () => {
                    if (document.hidden) {
                        await window.Viewer?.destroy();
                    }
                });
                window.addEventListener('pagehide', () => window.Viewer?.destroy());
                // (logs opcionales)
                window.addEventListener('orientationchange', () => console.log('[orientationchange]'));
                window.addEventListener('resize', () => console.log('[resize]', innerWidth, innerHeight));
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

        function initPreCache(params) {
            // 2) Cargar items (inyecta dataCache por ítem)
            ItemsStore.setItems(itemsSources);

            // 3) Mapa
            const MAP_CONFIG = Object.freeze({
                zoom: 14, maxZoom: 25,
                position: [0.20830, -78.22798],
                tileUrl: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                tileAttribution: '&copy; OpenStreetMap contrib.'
            });

            // Usa la copia “segura” de ItemsStore para pintar
            params.mapCtl.init(ItemsStore.getItems());
            // 4) Precarga (cuando la pestaña esté visible e “idle”)
            const startWarm = async () => {
                // Evita precargar en redes lentas: ya lo maneja AssetPreloader, pero puedes filtrar extra aquí
                try {
                    await ItemsStore.warmAll({concurrency: 3}); // descarga, cachea y sincroniza blob:URL por ítem
                    console.log('[preload] OK: blobs listos');
                } catch (e) {
                    console.warn('[preload] fallo o cancelado', e);
                }
            };

            // Lanza la precarga de forma amable
            const warmWhenVisible = () => {
                if (document.visibilityState !== 'visible') {
                    document.addEventListener('visibilitychange', function onVis() {
                        if (document.visibilityState === 'visible') {
                            document.removeEventListener('visibilitychange', onVis);
                            queueWarm();
                        }
                    });
                    return;
                }
                queueWarm();
            };

            const queueWarm = () => {
                // Si existe requestIdleCallback, mejor; si no, usa setTimeout corto
                if ('requestIdleCallback' in window) {
                    requestIdleCallback(() => startWarm(), {timeout: 2000});
                } else {
                    setTimeout(() => startWarm(), 300);
                }
            };

            warmWhenVisible();
        }

        /* ===========================================================
         * Bootstrap
         * =========================================================== */
        document.addEventListener('DOMContentLoaded', () => {
            console.log("DOMContentLoaded");
            UI.bind();
            window.Viewer = new ViewerOrchestrator();
            const mapCtl = new MapController({});
            initPreCache({
                mapCtl: mapCtl
            });
            DeviceEvents.attach();

            UI.$reticle?.addEventListener('click', async () => {
                await window.Viewer.handleReticleTap();
            });
            UI.$back?.addEventListener('click', async () => {
                await window.Viewer.destroy();
            });
            const camComposer = new CameraOverlayComposer();
            UI.$capture?.addEventListener('click', async () => {
                console.log("adaodaodaodm")
                await window.Viewer.captureCameraPlusModelAndSave();


            });


        });

        function canScreenCapture() {
            const isSecure = location.protocol === 'https:' || location.hostname === 'localhost';
            const hasAPI = !!(navigator.mediaDevices?.getDisplayMedia || navigator.getDisplayMedia);
            const inIframe = window.self !== window.top;
            const isWV = /\bwv\b/i.test(navigator.userAgent); // Android WebView

            return {
                ok: isSecure && hasAPI && !isWV,
                reason: !isSecure ? 'No HTTPS' :
                    !hasAPI ? 'API no disponible' :
                        isWV ? 'WebView limita captura' :
                            inIframe ? 'Iframe sin permisos (display-capture)' :
                                'Desconocido',
                hasAPI, isSecure, inIframe, isWV
            };
        }

        /* ===========================================================
 * AssetPreloader: precarga .glb en memoria y (opcional) CacheStorage
 * - Guarda ArrayBuffer en RAM (Map) y opcionalmente en CacheStorage.
 * - Expone getBlobURL(url) para que GLTFLoader/ModelViewer usen blob: URL.
 * - Evita duplicar descargas con un pool de Promises.
 * =========================================================== */
        const AssetPreloader = (() => {
            const mem = new Map();        // url -> { buffer:ArrayBuffer, blobUrl:string }
            const inflight = new Map();   // url -> Promise<void>
            const CACHE_NAME = 'glb-precache-v1';

            const canCacheStorage = 'caches' in window;

            async function _fetchToBuffer(url) {
                const r = await fetch(url, {credentials: 'omit', mode: 'cors'});
                if (!r.ok) throw new Error(`Preload fail ${r.status} ${url}`);
                return await r.arrayBuffer();
            }

            async function _putInCache(url, buffer) {
                if (!canCacheStorage) return;
                try {
                    const cache = await caches.open(CACHE_NAME);
                    const resp = new Response(buffer, {
                        headers: {'Content-Type': 'model/gltf-binary', 'Content-Length': String(buffer.byteLength)}
                    });
                    await cache.put(url, resp);
                } catch { /* ignore */
                }
            }

            async function _fromCache(url) {
                if (!canCacheStorage) return null;
                try {
                    const cache = await caches.open(CACHE_NAME);
                    const resp = await cache.match(url);
                    if (!resp) return null;
                    return await resp.arrayBuffer();
                } catch {
                    return null;
                }
            }

            async function warm(url) {
                if (!url) return;
                if (mem.has(url)) return;               // ya en RAM
                if (inflight.has(url)) {
                    await inflight.get(url);
                    return;
                } // ya descargando

                const job = (async () => {
                    // 1) intenta cache storage
                    let buf = await _fromCache(url);
                    // 2) si no está en cache, descarga
                    if (!buf) {
                        // política: solo precargar si red es buena
                        const goodNet = !('connection' in navigator) ||
                            ['wifi', 'ethernet', '4g'].includes(navigator.connection.effectiveType || '4g');
                        if (!goodNet) return; // evita precargas agresivas en 2g/3g
                        buf = await _fetchToBuffer(url);
                        _putInCache(url, buf).catch(() => {
                        });
                    }
                    // 3) construye blob URL y guarda en RAM
                    if (buf && !mem.has(url)) {
                        const blobUrl = URL.createObjectURL(new Blob([buf], {type: 'model/gltf-binary'}));
                        mem.set(url, {buffer: buf, blobUrl});
                    }
                })().finally(() => inflight.delete(url));

                inflight.set(url, job);
                await job;
            }

            function warmMany(urls = [], {concurrency = 3} = {}) {
                // cola simple con concurrencia limitada
                let idx = 0, active = 0;
                return new Promise((resolve) => {
                    const next = () => {
                        while (active < concurrency && idx < urls.length) {
                            active++;
                            warm(urls[idx++]).finally(() => {
                                active--;
                                next();
                            });
                        }
                        if (active === 0 && idx >= urls.length) resolve();
                    };
                    next();
                });
            }

            /** Devuelve blob:URL si está precargado, si no null */
            function getBlobURL(url) {
                return mem.get(url)?.blobUrl || null;
            }

            /** Limpia blob URLs (si salen muchos modelos) */
            function dispose(url) {
                const obj = mem.get(url);
                if (obj?.blobUrl) URL.revokeObjectURL(obj.blobUrl);
                mem.delete(url);
            }

            return {warm, warmMany, getBlobURL, dispose};
        })();
        /* ===========================================================
         * ItemsStore: administra itemsSources + cache por ítem
         *  - Añade key dataCache a cada item
         *  - Lee/escribe (sobrescribe) el array completo
         *  - Actualiza/mergea un ítem por id
         *  - Lanza precarga con AssetPreloader y guarda blob:URL en dataCache
         *  - Expone getters para MapController / Viewer
         * =========================================================== */
        const ItemsStore = (() => {
            /** estado interno */
            let _items = [];

            /** Normaliza el objeto item para garantizar dataCache */
            function _withCacheShape(item) {
                return {
                    ...item,
                    dataCache: {
                        glbBlobUrl: item?.dataCache?.glbBlobUrl || null, // blob: URL si está precargado
                        lastWarmAt: item?.dataCache?.lastWarmAt || null, // timestamp ISO
                        bytes: item?.dataCache?.bytes || null,       // tamaño opcional
                    }
                };
            }

            /** Inicializa o sobrescribe toda la lista */
            function setItems(list) {
                _items = Array.isArray(list) ? list.map(_withCacheShape) : [];
            }

            /** Obtiene copia “inmutable” del array */
            function getItems() {
                return _items.map(i => ({...i, dataCache: {...i.dataCache}}));
            }

            /** Obtiene referencia de solo lectura a un ítem */
            function getItemById(id) {
                return _items.find(i => i.id === id) || null;
            }

            /** Hace merge parcial sobre un ítem por id (sin perder dataCache) */
            function updateItem(id, patch) {
                const idx = _items.findIndex(i => i.id === id);
                if (idx === -1) return false;
                const current = _items[idx];
                const next = _withCacheShape({...current, ...patch});
                // preserva blobUrl si el patch no lo trae
                if (!patch?.dataCache?.glbBlobUrl && current.dataCache?.glbBlobUrl) {
                    next.dataCache.glbBlobUrl = current.dataCache.glbBlobUrl;
                }
                _items[idx] = next;
                return true;
            }

            /** Reemplaza TODO el array (sobrescritura) y devuelve copia */
            function replaceAll(newItems) {
                setItems(newItems);
                return getItems();
            }

            /** Marca manualmente el cache de un ítem (si lo precargaste tú) */
            function markCache(id, {glbBlobUrl, bytes} = {}) {
                const it = getItemById(id);
                if (!it) return false;
                it.dataCache.glbBlobUrl = glbBlobUrl ?? it.dataCache.glbBlobUrl ?? null;
                it.dataCache.lastWarmAt = new Date().toISOString();
                if (typeof bytes === 'number') it.dataCache.bytes = bytes;
                return true;
            }

            /** Devuelve el URL “óptimo” para GLTFLoader/model-viewer (blob si existe) */
            function getBestGlbUrl(id) {
                const it = getItemById(id);
                if (!it) return null;
                return it.dataCache?.glbBlobUrl || it.sources?.glb || null;
            }

            /** Precarga un ítem por id usando AssetPreloader y guarda blob:URL en dataCache */
            async function warmById(id) {
                const it = getItemById(id);
                if (!it?.sources?.glb) return false;
                try {
                    await AssetPreloader.warm(it.sources.glb);
                    const blobUrl = AssetPreloader.getBlobURL(it.sources.glb);
                    if (blobUrl) {
                        markCache(id, {glbBlobUrl: blobUrl});
                        return true;
                    }
                } catch (e) {
                    console.warn('[ItemsStore] warmById error', id, e);
                }
                return false;
            }

            /** Precarga varios/ todos con concurrencia limitada */
            async function warmAll({ids = null, concurrency = 3} = {}) {
                const urls = (ids
                        ? _items.filter(i => ids.includes(i.id))
                        : _items
                ).map(i => i.sources?.glb).filter(Boolean);

                await AssetPreloader.warmMany(urls, {concurrency});

                // sincroniza blob:URL en dataCache
                for (const it of _items) {
                    const u = it.sources?.glb;
                    if (!u) continue;
                    const blob = AssetPreloader.getBlobURL(u);
                    if (blob) markCache(it.id, {glbBlobUrl: blob});
                }
            }

            return {
                /** CRUD del arreglo */
                setItems, getItems, replaceAll, updateItem, getItemById,
                /** cache por ítem */
                markCache, getBestGlbUrl,
                /** precarga */
                warmById, warmAll,
            };
        })();


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
    <canvas id="snap-canvas" class="snap-canvas d-none"></canvas>

@endsection
