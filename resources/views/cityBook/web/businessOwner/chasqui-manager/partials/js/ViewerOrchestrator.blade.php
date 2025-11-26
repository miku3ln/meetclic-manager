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

        async onMarkerSourceSelected(input) {
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

            // Siempre usamos el URL original como clave de caché
            const cachedBlobUrl = AssetPreloader.getBlobURL(raw);
            const cacheStatus = id ? ItemsStore.getCacheStatus(id) : (cachedBlobUrl ? 'hot' : 'cold');
            const isCached = !!cachedBlobUrl || cacheStatus === 'hot';
            const glbUrl = raw;

            const usdzUrl = (!glbUrl?.startsWith('blob:') && glbUrl?.endsWith?.('.glb'))
                ? glbUrl.replace(/\.glb$/i, '.usdz')
                : '';

            this._state.lastSource = {id, glb: glbUrl, usdz: usdzUrl};

            console.log('[ViewerOrchestrator] onMarkerSourceSelected cache', {
                id,
                glbUrl,
                isCached,
                cacheStatus
            });

            UI.revealContainer();
            UI.hideMap();
            UI.hideFallback();

            if (await canUseAR()) {
                try {
                    UI.showLoading(isCached ? 'Abriendo cámara (modelo precargado)…' : 'Abriendo cámara…');
                    const ctrl = new AndroidWebXRController({
                        onEnter: () => UI.setHint('Cámara iniciada.'),
                        onExit: async ({reason}) => {
                            UI.setHint(`Sesión finalizada (${reason || 'desconocido'}).`);
                            await this.destroy();
                            window.disableJoystick();
                        }
                    });

                    await ctrl.startSessionFromGesture();
                    this._state.mode = 'android-webxr';
                    this._state.controller = ctrl;
                    this._state.pendingGLB = glbUrl;

                    await ctrl.ready;
                    UI.hideLoading();
                    UI.showReticle();
                    UI.setHint('Toca la retícula para colocar.');
                    return;
                } catch (e) {
                    console.warn('No se pudo iniciar WebXR, usando fallback', e);
                    // ⚠️ IMPORTANTE: si falla WebXR, ocultamos el loading que se quedó activo
                    UI.hideLoading();
                }
            }

            // Fallback <model-viewer>
            const mvCtrl = new ModelViewerController(UI.mv, {
                onEnter: ({mode}) => UI.setHint(`AR activo (${mode}).`)
            });
            mvCtrl.bindOnce();

            try {
                await mvCtrl.setSource({glbUrl, usdzUrl});
                this._state.mode = Platform.isIOS ? 'ios-quicklook' : 'web-fallback';
                this._state.controller = mvCtrl;
                this._state.pendingGLB = null;

                UI.showCapture();
            } catch (err) {
                console.error('Error en fallback model-viewer', err);
                UI.setHint('No se pudo cargar el modelo en fallback.');
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

</script>
