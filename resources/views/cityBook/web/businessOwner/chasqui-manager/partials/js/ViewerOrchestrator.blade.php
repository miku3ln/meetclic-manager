<script>
    class ViewerOrchestrator {
        constructor() {
            this._state = {
                mode: null,
                controller: null,
                pendingGLB: null,
                arReady: false,
                lastSource: null
            };
        }

        get state() {
            return this._state;
        }

        isActive() {
            return !!this._state.controller;
        }

        async captureCameraFrameBlob() {
            const st = this._state;
            if (st.mode !== 'android-webxr' || !st.controller) {
                UI.setHint('Cámara: no hay sesión AR activa.');
                return null;
            }

            const composer = new CameraOverlayComposer();

            const hadModel = !!st.controller.model;
            const saved = hadModel ? {
                pos: st.controller.model.position.clone(),
                quat: st.controller.model.quaternion.clone(),
                scl: st.controller.model.scale.clone()
            } : null;

            try {
                await st.controller.endXRButKeepScene();

                await composer.start({includeCanvas3D: false});
                await new Promise(r => setTimeout(r, 250));

                const camBlob = await composer.snapshotToBlob({type: 'image/jpeg', quality: 0.95});
                console.log("camBlob", camBlob);
                return camBlob || null;
            } catch (e) {
                console.error('[captureCameraFrameBlob] error', e);
                return null;
            } finally {
                try {
                    await composer.stop();
                } catch {
                }
                try {
                    await st.controller.restartXRAfterCamera({rePlaceModel: true});
                } catch {
                }
                if (hadModel && saved) {
                    st.controller.model.position.copy(saved.pos);
                    st.controller.model.quaternion.copy(saved.quat);
                    st.controller.model.scale.copy(saved.scl);
                }
            }
        }

        async captureModelFrameBlob() {
            const st = this._state;
            if (st.mode === 'android-webxr' && typeof st.controller?.capture === 'function') {
                const {blob} = await st.controller.capture({
                    type: 'image/png',
                    quality: 1.0,
                    background: null,
                    download: false
                });
                return blob || null;
            }

            if (st.mode !== 'android-webxr' && UI.mv?.shadowRoot) {
                const cnv = UI.mv.shadowRoot.querySelector('canvas');
                if (cnv && cnv.width && cnv.height) {
                    const tmp = document.createElement('canvas');
                    tmp.width = cnv.width;
                    tmp.height = cnv.height;
                    const ctx = tmp.getContext('2d');
                    ctx.clearRect(0, 0, tmp.width, tmp.height);
                    ctx.drawImage(cnv, 0, 0);
                    const blob = await new Promise(res => tmp.toBlob(res, 'image/png', 1.0));
                    return blob || null;
                }
            }
            return null;
        }

        rotateModelRight(degrees = 15) {
            const st = this._state;
            const ctrl = st.controller;
            ctrl.rotateModelLeft(-degrees);
        }

        rotateModelLeft(degrees = 15) {
            const st = this._state;
            const ctrl = st.controller;
            ctrl.rotateModelLeft(degrees);
        }

        rotateModelDown(degrees = 15) {
            const st = this._state;

            const ctrl = st.controller;
            ctrl.rotateModelUpDown(degrees);
        }

        rotateModelUp(degrees = 15) {
            const st = this._state;

            const ctrl = st.controller;
            ctrl.rotateModelUpDown(-degrees);
        }

        async onCaptureGpu() {
            const st = this._state;
            const ctrl = st.controller;

            if (!ctrl || typeof ctrl.captureWithVideoTextureQuad !== 'function') {
                UI.setHint('No hay sesión AR activa.');
                return;
            }

            UI.setHint('Capturando…');

            try {
                const blob = await ctrl.captureWithVideoTextureQuad({
                    facingMode: 'environment',
                    type: 'image/jpeg',
                    quality: 0.95,
                    download: true,
                    includeCamera: true // cámara + AR
                });

                UI.setHint(blob ? 'Captura guardada.' : 'No se pudo capturar.');
            } catch (error) {
                console.error('[onCaptureGpu] Error al capturar', error);
                UI.setHint('Ocurrió un error al capturar.');
            }
        }

        async captureScreenFrame({
                                     type = 'image/jpeg',
                                     quality = 0.95,
                                     download = true,
                                     filename
                                 } = {}) {
            const caps = canScreenCapture?.() || {ok: false, reason: 'desconocido'};
            if (!caps.ok) {
                UI.setHint(`ScreenCapture no disponible: ${caps.reason || 'permiso/HTTPS'}`);
                return null;
            }

            const st = this._state;
            const ctrl = st.controller;
            const wasXR = (st.mode === 'android-webxr');

            let stream = null;
            let video = null;

            const hadModel = !!ctrl?.model;
            const saved = hadModel ? {
                pos: ctrl.model.position.clone(),
                quat: ctrl.model.quaternion.clone(),
                scl: ctrl.model.scale.clone()
            } : null;

            try {
                UI.setHint('Selecciona la pantalla para capturar…');

                stream = await navigator.mediaDevices.getDisplayMedia({
                    video: {frameRate: 30}, audio: false
                });

                video = document.createElement('video');
                video.playsInline = true;
                video.muted = true;
                video.autoplay = true;
                video.srcObject = stream;
                Object.assign(video.style, {
                    position: 'fixed',
                    left: '-9999px',
                    top: '-9999px',
                    width: '1px',
                    height: '1px'
                });
                document.body.appendChild(video);

                await new Promise((res, rej) => {
                    const ok = () => {
                        cleanup();
                        res();
                    };
                    const er = (e) => {
                        cleanup();
                        rej(e);
                    };
                    const cleanup = () => {
                        video.removeEventListener('loadedmetadata', ok);
                        video.removeEventListener('error', er);
                    };
                    video.addEventListener('loadedmetadata', ok, {once: true});
                    video.addEventListener('error', er, {once: true});
                });
                try {
                    await video.play();
                } catch {
                }

                const w = Math.max(1, video.videoWidth || screen.width || 1280);
                const h = Math.max(1, video.videoHeight || screen.height || 720);
                const cnv = document.createElement('canvas');
                cnv.width = w;
                cnv.height = h;
                const ctx = cnv.getContext('2d', {willReadFrequently: false});
                ctx.drawImage(video, 0, 0, w, h);

                const blob = await new Promise(res => cnv.toBlob(res, type, quality));
                if (blob && download) {
                    const ext = (type === 'image/png') ? 'png' : (type === 'image/webp' ? 'webp' : 'jpg');
                    const id = st.lastSource?.id || 'screen';
                    const t = new Date();
                    const p = n => String(n).padStart(2, '0');
                    const name = filename || `${id}-${t.getFullYear()}${p(t.getMonth() + 1)}${p(t.getDate())}-${p(t.getHours())}${p(t.getMinutes())}${p(t.getSeconds())}.${ext}`;
                    DownloadUtils.saveBlob(name, blob);
                }

                UI.setHint('Captura de pantalla lista.');
                return blob || null;

            } catch (e) {
                console.error('[captureScreenFrame] error', e);
                UI.setHint('No se pudo capturar la pantalla.');
                return null;

            } finally {
                try {
                    stream?.getTracks()?.forEach(t => t.stop());
                } catch {
                }
                if (video?.parentNode) video.parentNode.removeChild(video);

                if (wasXR && ctrl && typeof ctrl.restartXRAfterCamera === 'function') {
                    try {
                        await ctrl.restartXRAfterCamera({rePlaceModel: true});
                    } catch {
                    }
                    if (hadModel && saved) {
                        ctrl.model.position.copy(saved.pos);
                        ctrl.model.quaternion.copy(saved.quat);
                        ctrl.model.scale.copy(saved.scl);
                    }
                }
            }
        }

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
            const cnv = (typeof OffscreenCanvas !== 'undefined')
                ? new OffscreenCanvas(W, H)
                : Object.assign(document.createElement('canvas'), {width: W, height: H});
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
                let modelBlob = null;
                let cameraBlob = null;

                // cameraBlob = await this.captureCameraFrameBlob();
                // modelBlob = await this.captureModelFrameBlob();
                // De momento desactivado para no mezclar 2 flows pesados

                if (!cameraBlob && !modelBlob) {
                    UI.setHint('No se pudo capturar cámara ni modelo.');
                    return;
                }

                console.log("cameraBlob", cameraBlob, "modelBlob", modelBlob);
                const all = false;
                if (cameraBlob && modelBlob && all) {
                    const merged = await this.mergeCameraAndModelBlobs({
                        cameraBlob,
                        modelBlob,
                        outType: 'image/jpeg',
                        quality: 0.95,
                        cameraMode: 'cover',
                        modelMode: 'contain',
                        modelOpacity: 1.0,
                        background: '#ffffff'
                    });
                    if (merged) {
                        DownloadUtils.saveBlob(filename, merged);
                        UI.setHint('Imagen (cámara+modelo) guardada.');
                        return;
                    }
                }

                if (cameraBlob) {
                    DownloadUtils.saveBlob(filename, cameraBlob);
                    UI.setHint('Imagen (solo cámara) guardada.');
                    return;
                }
                if (modelBlob) {
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

        async initACR(input) {
            let id = null;
            let raw = null;

            // ============================================
            // 1. IDENTIFICAR EL MODELO
            // ============================================

            if (typeof input === 'string') {
                raw = input;

                const match = ItemsStore.getItems()
                    .find(i => i.sources?.glb === input);

                id = match?.id ?? null;

            } else {
                id = input?.id ?? null;
                raw = input?.glbUrl ?? input?.sources?.glb ?? '';
            }

            // Recuperar todos los datos existentes del tótem.
            const dataTotem = id != null
                ? ItemsStore.getItemById(id)
                : null;

            const originalUrl = dataTotem?.sources?.glb || null;

            // Mantener la URL original para WebXR y otros visores.
            const glbUrl = originalUrl || raw;

            if (!glbUrl) {
                UI.setHint('No hay fuente GLB disponible.');
                return;
            }

            // ============================================
            // 2. RESOLVER CACHÉ
            // ============================================

            const cachedBlobUrl = AssetPreloader.getBlobURL(glbUrl);

            const cacheStatus = id != null
                ? ItemsStore.getCacheStatus(id)
                : (cachedBlobUrl ? 'hot' : 'cold');

            const isCached =
                !!cachedBlobUrl || cacheStatus === 'hot';

            const usdzUrl = (
                !glbUrl.startsWith('blob:') &&
                /\.glb$/i.test(glbUrl)
            )
                ? glbUrl.replace(/\.glb$/i, '.usdz')
                : '';

            // Guardar información para todos los modos.
            this._state.lastSource = {
                id,
                glb: glbUrl,
                usdz: usdzUrl,
                dataTotem
            };

            console.log('[ViewerOrchestrator] Modelo seleccionado', {
                id,
                title: dataTotem?.title,
                position: dataTotem?.position,
                glbUrl,
                isCached,
                cacheStatus
            });

            UI.revealContainer();
            UI.hideMap();
            UI.hideFallback();

            // ============================================
            // 3. PRIMER MODO: WEBXR ORIGINAL
            // ============================================

            console.log('[ViewerOrchestrator] Verificando WebXR');

            let webXRSupported = false;

            try {
                webXRSupported = await canUseAR();

            } catch (error) {
                console.warn(
                    '[ViewerOrchestrator] Error verificando WebXR',
                    error
                );
            }

            if (webXRSupported) {
                let ctrl = null;

                try {
                    UI.showLoading(
                        isCached
                            ? 'Abriendo cámara (modelo precargado)…'
                            : 'Abriendo cámara…'
                    );

                    ctrl = new AndroidWebXRController({
                        onEnter: () => {
                            UI.setHint('Cámara AR iniciada.');
                        },

                        onExit: async ({reason}) => {
                            console.log(
                                '[ViewerOrchestrator] Sesión WebXR finalizada',
                                reason
                            );

                            if (
                                this._state.mode === 'android-webxr' &&
                                this._state.controller === ctrl
                            ) {
                                UI.setHint(
                                    `Sesión finalizada (${reason || 'desconocido'}).`
                                );

                                await this.destroy();

                                window.disableJoystick?.();
                            }
                        }
                    });

                    console.log(
                        '[ViewerOrchestrator] Solicitando sesión WebXR'
                    );

                    // Verificación real: intentar crear la sesión.
                    await ctrl.startSessionFromGesture();

                    this._state.mode = 'android-webxr';
                    this._state.controller = ctrl;
                    this._state.pendingGLB = glbUrl;

                    await ctrl.ready;

                    UI.hideLoading();
                    UI.showReticle();

                    UI.setHint('Toca la retícula para colocar.');

                    console.log('[ViewerOrchestrator] WebXR activo', {
                        id,
                        title: dataTotem?.title
                    });

                    return;

                } catch (error) {
                    console.warn(
                        '[ViewerOrchestrator] WebXR no disponible. ' +
                        'Iniciando cámara Three.js.',
                        error
                    );

                    try {
                        await ctrl?.stop();
                    } catch (cleanupError) {
                        console.warn(
                            '[ViewerOrchestrator] Error limpiando WebXR',
                            cleanupError
                        );
                    }

                    if (this._state.controller === ctrl) {
                        this._state.controller = null;
                        this._state.mode = null;
                        this._state.pendingGLB = null;
                    }

                    UI.hideLoading();
                    UI.hideReticle();
                }
            }

        }



        async onMarkerSourceSelected(input) {

            let id = null;
            let raw = null;

            // ============================================
            // 1. IDENTIFICAR EL MODELO
            // ============================================

            if (typeof input === 'string') {

                raw = input;

                const match = ItemsStore.getItems()
                    .find(item => item.sources?.glb === input);

                id = match?.id ?? null;

            } else {

                id = input?.id ?? null;

                raw =
                    input?.glbUrl ??
                    input?.sources?.glb ??
                    '';
            }

            // ============================================
            // 2. RECUPERAR DATOS DEL TÓTEM
            // ============================================

            const dataTotem = id != null
                ? ItemsStore.getItemById(id)
                : null;

            const originalUrl =
                dataTotem?.sources?.glb || null;

            const glbUrl = originalUrl || raw;

            if (!glbUrl) {

                UI.setHint(
                    'No hay fuente GLB disponible.'
                );

                return;
            }

            // ============================================
            // 3. VERIFICAR CACHÉ
            // ============================================

            const cachedBlobUrl =
                AssetPreloader.getBlobURL(glbUrl);

            const cacheStatus = id != null
                ? ItemsStore.getCacheStatus(id)
                : (cachedBlobUrl ? 'hot' : 'cold');

            const isCached =
                !!cachedBlobUrl ||
                cacheStatus === 'hot';

            // ============================================
            // 4. GUARDAR FUENTE SELECCIONADA
            // ============================================

            this._state.lastSource = {
                id,
                glb: glbUrl,
                dataTotem
            };

            console.log(
                '[ViewerOrchestrator] Modelo seleccionado',
                {
                    id,
                    title: dataTotem?.title,
                    glbUrl,
                    isCached,
                    cacheStatus
                }
            );

            // ============================================
            // 5. PREPARAR INTERFAZ
            // ============================================

            UI.revealContainer();
            UI.hideMap();
            UI.hideFallback();
            UI.hideReticle();

            // ============================================
            // 6. LIMPIAR CONTROLADOR ANTERIOR
            // ============================================

            if (this._state.controller) {

                const previousController =
                    this._state.controller;

                try {

                    await previousController.stop?.();

                } catch (error) {

                    console.warn(
                        '[ViewerOrchestrator] Error cerrando visor anterior',
                        error
                    );
                }

                this._state.controller = null;
                this._state.mode = null;
                this._state.pendingGLB = null;
            }

            // ============================================
            // 7. VERIFICAR CÁMARA THREE.JS
            // ============================================

            const canUseCamera =
                window.isSecureContext &&
                !!navigator.mediaDevices?.getUserMedia &&
                typeof CameraThreeController !== 'undefined';

            if (!canUseCamera) {

                console.error(
                    '[ViewerOrchestrator] Cámara Three.js no disponible'
                );

                UI.setHint(
                    'La cámara necesita HTTPS o localhost y un navegador compatible.'
                );

                return;
            }

            // ============================================
            // 8. CREAR CAMERA THREE CONTROLLER
            // ============================================

            let cameraCtrl = null;

            try {

                // Mostrar indicador general solamente
                // mientras se inicia la cámara.
                UI.showLoading(
                    'Iniciando cámara trasera…'
                );

                cameraCtrl = new CameraThreeController({

                    dataTotem,

                    onEnter: () => {

                        UI.setHint(
                            'Cámara 3D iniciada.'
                        );
                        $("#companyPanelHeader").addClass("not-view");
                        $("#btn-capture").addClass("not-view");

                    },

                    onExit: ({ reason }) => {
                        $("#companyPanelHeader").removeClass("not-view");
                        $("#btn-capture").removeClass("not-view");

                        console.log(
                            '[CameraThree] Sesión finalizada:',
                            reason
                        );

                        const container = document.querySelector('.container--custom');

                        if (container) {
                            Object.assign(container.style, {
                                position: 'relative',
                                zIndex: '0'
                            });
                        }
                    }
                });

                // ========================================
                // 9. INICIAR CÁMARA TRASERA
                // ========================================

                await cameraCtrl.start();

                this._state.mode = 'camera-three';
                this._state.controller = cameraCtrl;
                this._state.pendingGLB = null;

                // ========================================
                // 10. OCULTAR LOADER GENERAL
                // ========================================

                // El controlador utiliza su propio indicador
                // de descarga, bytes y tiempo transcurrido.
                UI.hideLoading();
                UI.hideReticle();

                UI.setHint(
                    isCached
                        ? 'Preparando personaje precargado…'
                        : 'Descargando personaje 3D…'
                );

                // ========================================
                // 11. CARGAR PERSONAJE GLB
                // ========================================

                await cameraCtrl.loadModel(
                    glbUrl,
                    id
                );

                // ========================================
                // 12. ACTIVAR JOYSTICK
                // ========================================

                // El joystick ya está integrado en
                // CameraThreeController.
                // Solo controla la rotación del personaje.

                cameraCtrl.enableJoystick?.();

                // ========================================
                // 13. MOSTRAR CONTROLES
                // ========================================

                UI.hideLoading();
                UI.hideReticle();
                UI.showCapture();

                UI.setHint(
                    'Gira el personaje con el joystick. ' +
                    'Arrástralo para moverlo y pellizca ' +
                    'para cambiar su profundidad.'
                );

                // ========================================
                // 14. CONFIRMAR MODO ACTIVO
                // ========================================

                console.log(
                    '[ViewerOrchestrator] Cámara Three.js activa',
                    {
                        mode: this._state.mode,
                        id,
                        title: dataTotem?.title,
                        glbUrl,

                        isCached,
                        cacheStatus,

                        joystickEnabled:
                        cameraCtrl.joystick?.enabled,

                        trackingEnabled:
                        cameraCtrl._trackingEnabled,

                        orientationReceived:
                        cameraCtrl._hasOrientation,

                        modelPosition:
                            cameraCtrl.modelRoot?.position.toArray()
                    }
                );

                return;

            } catch (error) {

                console.error(
                    '[ViewerOrchestrator] Error iniciando cámara Three.js',
                    error
                );

                // ========================================
                // 15. LIMPIAR EN CASO DE ERROR
                // ========================================

                try {

                    await cameraCtrl?.stop();

                } catch (cleanupError) {

                    console.warn(
                        '[ViewerOrchestrator] Error limpiando cámara',
                        cleanupError
                    );
                }

                if (
                    this._state.controller === cameraCtrl
                ) {

                    this._state.controller = null;
                    this._state.mode = null;
                    this._state.pendingGLB = null;
                }

                UI.hideLoading();
                UI.hideReticle();

                UI.setHint(
                    'No se pudo iniciar la cámara o cargar el personaje 3D.'
                );
            }
        }




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

        async destroy() {
            try {
                if (this._state.controller) {
                    if (this._state.mode === 'android-webxr' ||
                        this._state.mode === 'camera-three') await this._state.controller.stop();
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

</script>
