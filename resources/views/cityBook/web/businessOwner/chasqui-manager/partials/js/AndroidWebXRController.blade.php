<script>
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

            this._firstFrameSeen = false;
            this._firstFrameResolve = null;
            this.ready = new Promise(res => (this._firstFrameResolve = res));

            this._onEnd = this._onVis = null;

            this._lightProbe = null;
            this._headlamp = null;

            this._snapCanvas = null;
            this._snapCtx = null;
            this._recorder = null;
            this._recChunks = [];
            this._recStream = null;

            this._mirrorRenderer = null;
            this._mirrorCam = null;
            this._mirrorEnabled = true;
            this._gesturesBound = false;

        }

        rotateModelLeft(degrees = 15) {
            if (!this.model) return;

            // Convertimos grados a radianes
            const radians = THREE.MathUtils.degToRad(degrees);

            // Rotamos alrededor del eje Y (arriba/abajo)
            // Positivo = izquierda (desde la perspectiva de la cámara)
            this.model.rotation.y += radians;
        }

        rotateModelUpDown(degrees = 15) {
            if (!this.model) return;

            const radians = THREE.MathUtils.degToRad(degrees);

            // Rotar en el eje X (pitch)
            // Positivo = inclinar hacia arriba
            // Negativo = inclinar hacia abajo
            this.model.rotation.x += radians;
        }

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

            this._onEnd = () => this.hooks.onExit && this.hooks.onExit({reason: 'session-end'});
            this._onVis = () => {
                const s = this.session?.visibilityState;
                if (s === 'hidden' || s === 'visible-blurred') {
                    this.hooks.onExit && this.hooks.onExit({reason: 'visibility', state: s});
                }
            };
            this.session.addEventListener('end', this._onEnd);
            this.session.addEventListener('visibilitychange', this._onVis);

            try {
                if (this.session.requestLightProbe) {
                    this._lightProbe = await this.session.requestLightProbe({type: 'spherical-harmonics'});
                }
            } catch {
            }

            this._bindGesturesMobile();
            this._ensureSnapCanvas();

            window.addEventListener('resize', this._onResize);
            this.hooks.onEnter && this.hooks.onEnter({mode: 'android-webxr'});
        }

        async loadModel(glbUrl) {
            await this._disposeModel();
            if (!glbUrl) return;

            const resolved = AssetPreloader.getBlobURL(glbUrl) || glbUrl;

            UI.showLoading('Cargando modelo…');
            UI.resetLoadingProgress();

            await new Promise((res, rej) => {
                const loader = new THREE.GLTFLoader();

                loader.load(
                    resolved,
                    (gltf) => {
                        this.model = gltf.scene;
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
                        UI.hideLoading(420);
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

            if (this._snapCanvas && this._snapCanvas.id !== 'snap-canvas' && this._snapCanvas.parentNode) {
                this._snapCanvas.parentNode.removeChild(this._snapCanvas);
            }
            this._snapCanvas = null;
            this._snapCtx = null;

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

        _setupRenderer() {
            if (this.renderer) return;

            this.renderer = new THREE.WebGLRenderer({
                antialias: true,
                alpha: true,
                powerPreference: 'high-performance',
                preserveDrawingBuffer: true
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

            this._mirrorRenderer = new THREE.WebGLRenderer({
                antialias: true,
                alpha: true,
                preserveDrawingBuffer: true
            });
            this._mirrorRenderer.setClearAlpha(0);
            this._mirrorRenderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));

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

        _onXRFrame(time, frame) {
            if (!frame || !this._refSpace) {
                this.renderer.render(this.scene, this.camera);

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

            this.renderer.render(this.scene, this.camera);

            if (this._mirrorEnabled) {
                const xrCam = this.renderer.xr.getCamera(this.camera);
                this._renderMirror(xrCam);
                this._copyToSnapCanvasFrom(this._mirrorRenderer.domElement);
            }
        }

        _renderMirror(srcCam) {
            if (!this._mirrorRenderer || !this._mirrorCam) return;

            this._mirrorCam.matrixWorld.copy(srcCam.matrixWorld);
            this._mirrorCam.matrixWorldInverse.copy(srcCam.matrixWorldInverse);
            this._mirrorCam.projectionMatrix.copy(srcCam.projectionMatrix);
            if (srcCam.projectionMatrixInverse) {
                this._mirrorCam.projectionMatrixInverse = srcCam.projectionMatrixInverse.clone();
            } else {
                this._mirrorCam.projectionMatrixInverse = this._mirrorCam.projectionMatrix.clone().invert();
            }
            this._mirrorCam.position.setFromMatrixPosition(this._mirrorCam.matrixWorld);
            this._mirrorCam.quaternion.setFromRotationMatrix(this._mirrorCam.matrixWorld);
            this._mirrorCam.updateMatrixWorld(true);

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

        _handleResize() {
            if (!this.renderer) return;
            const w = Math.max(innerWidth, 1), h = Math.max(innerHeight, 1);
            this.renderer.setSize(w, h);
            if (this.camera && h > 0) {
                this.camera.aspect = w / h;
                this.camera.updateProjectionMatrix();
            }

            if (this._mirrorRenderer && this._mirrorCam) {
                this._mirrorRenderer.setSize(w, h);
                this._mirrorCam.aspect = w / h;
                this._mirrorCam.updateProjectionMatrix();
            }

            if (this._snapCanvas) {
                this._snapCanvas.width = w;
                this._snapCanvas.height = h;
            }
        }

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

        _pixelsToMetersAtDistance(d) {
            const h = 2 * Math.tan(THREE.MathUtils.degToRad(this.camera.fov * 0.5)) * d;
            return h / Math.max(1, this.renderer.getSize(new THREE.Vector2()).y);
        }

        _bindGesturesMobile() {
            const dom = this.renderer?.domElement;
            if (!dom) return;

            // Evitar registrar eventos más de una vez
            if (this._gesturesBound) return;
            this._gesturesBound = true;

            // Desactivar gestos por defecto del navegador (scroll, zoom, etc.)
            dom.style.touchAction = 'none';

            // ================== ESTADO DE GESTOS ==================
            const st = {
                mode: 'none',   // 'one' | 'two'
                lastX: 0,
                lastY: 0,
                lastDist: 0
            };

            const clampScale = (s) => THREE.MathUtils.clamp(s, 0.2, 3.0);

            let raf = null;
            let dZoom = 1;    // factor acumulado de zoom
            let panDX = 0;    // desplazamiento acumulado X (px)
            let panDY = 0;    // desplazamiento acumulado Y (px)

            // Para detectar doble tap
            let lastTapTime = 0;
            let lastTapX = 0;
            let lastTapY = 0;
            const DOUBLE_TAP_MS = 300;
            const DOUBLE_TAP_MAX_DIST = 25; // px

            const apply = () => {
                raf = null;
                if (!this.model || !this.camera) return;

                // 1) Zoom (2 dedos)
                if (dZoom !== 1) {
                    const newScale = clampScale(this.model.scale.x * dZoom);
                    this.model.scale.setScalar(newScale);
                    dZoom = 1;
                }

                // 2) Pan (1 dedo)
                if (panDX || panDY) {
                    const dCam = this.camera.position.distanceTo(this.model.position);
                    const px2m = (typeof this._pixelsToMetersAtDistance === 'function')
                        ? this._pixelsToMetersAtDistance(Math.max(0.01, dCam))
                        : dCam * 0.001; // fallback

                    const right = new THREE.Vector3(1, 0, 0).applyQuaternion(this.camera.quaternion);
                    const up = new THREE.Vector3(0, 1, 0).applyQuaternion(this.camera.quaternion);

                    // izquierda/derecha/arriba/abajo
                    this.model.position.addScaledVector(right, panDX * px2m);
                    this.model.position.addScaledVector(up, -panDY * px2m);

                    panDX = 0;
                    panDY = 0;
                }
            };

            const queue = () => {
                if (!raf) raf = requestAnimationFrame(apply);
            };

            const onStart = (e) => {
                if (!this.model) return;

                const n = e.touches.length;

                if (n === 1) {
                    // 1 dedo → MOVER
                    st.mode = 'one';
                    st.lastX = e.touches[0].clientX;
                    st.lastY = e.touches[0].clientY;

                } else if (n === 2) {
                    // 2 dedos → ZOOM
                    st.mode = 'two';
                    const [a, b] = e.touches;
                    st.lastDist = Math.hypot(
                        a.clientX - b.clientX,
                        a.clientY - b.clientY
                    );
                } else {
                    // 3+ dedos: ignoramos (sin giros)
                    st.mode = 'none';
                }
            };

            const onMove = (e) => {
                if (!this.model) return;

                // Necesario para evitar scroll/zoom del navegador
                e.preventDefault();

                const n = e.touches.length;

                // ===== 1 dedo: PAN =====
                if (st.mode === 'one' && n === 1) {
                    const t = e.touches[0];
                    const dx = t.clientX - st.lastX;
                    const dy = t.clientY - st.lastY;

                    panDX += dx;
                    panDY += dy;

                    st.lastX = t.clientX;
                    st.lastY = t.clientY;

                    queue();
                    return;
                }

                // ===== 2 dedos: ZOOM =====
                if (st.mode === 'two' && n >= 2) {
                    const [a, b] = e.touches;
                    const dist = Math.hypot(
                        a.clientX - b.clientX,
                        a.clientY - b.clientY
                    );

                    const ratio = dist / Math.max(1, st.lastDist);
                    dZoom *= ratio;
                    st.lastDist = dist;

                    queue();
                    return;
                }
            };

            const resetPose = () => {
                // Si tienes un método propio mejor usarlo:
                if (typeof this.resetModelPose === 'function') {
                    this.resetModelPose();
                    return;
                }

                // Reset genérico: ajusta a tus defaults
                this.model.position.set(0, 0, 0);
                this.model.rotation.set(0, 0, 0);
                this.model.scale.setScalar(1);
            };

            const onEnd = (e) => {
                const now = performance.now();

                // Detectar doble tap cuando se levanta el último dedo
                if (e.touches.length === 0 && e.changedTouches.length === 1) {
                    const t = e.changedTouches[0];
                    const dt = now - lastTapTime;
                    const dist = Math.hypot(t.clientX - lastTapX, t.clientY - lastTapY);

                    if (dt < DOUBLE_TAP_MS && dist < DOUBLE_TAP_MAX_DIST) {
                        // Doble tap → resetear modelo
                        resetPose();
                        lastTapTime = 0;
                    } else {
                        lastTapTime = now;
                        lastTapX = t.clientX;
                        lastTapY = t.clientY;
                    }
                }

                st.mode = 'none';
            };

            dom.addEventListener('touchstart', onStart, {passive: true});
            dom.addEventListener('touchmove', onMove, {passive: false});
            dom.addEventListener('touchend', onEnd, {passive: true});
            dom.addEventListener('touchcancel', onEnd, {passive: true});
        }


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
                // Usar canvas externo, pero SIEMPRE oculto
                this._snapCanvas = external;
            } else {
                // Crear uno nuevo, también oculto
                this._snapCanvas = document.createElement('canvas');
                document.body.appendChild(this._snapCanvas);
            }

            // 🔹 AQUI lo importante: SIEMPRE oculto
            Object.assign(this._snapCanvas.style, {
                display: 'none',
                position: 'fixed',
                inset: '0',
                pointerEvents: 'none',
                opacity: '0',
                zIndex: '-1'
            });

            this._snapCtx = this._snapCanvas.getContext('2d', {willReadFrequently: false});

            const w = Math.max(innerWidth, 1);
            const h = Math.max(innerHeight, 1);
            this._snapCanvas.width = w;
            this._snapCanvas.height = h;
        }


        _timestamp() {
            const p = (n, s = 2) => String(n).padStart(s, '0');
            const d = new Date();
            return `${d.getFullYear()}${p(d.getMonth() + 1)}${p(d.getDate())}-${p(d.getHours())}${p(d.getMinutes())}${p(d.getSeconds())}`;
        }

        async capture({
                          type = 'image/jpeg',
                          quality = 0.95,
                          background = '#ffffff',
                          filename,
                          download = true
                      } = {}) {
            if (!this._snapCanvas) this._ensureSnapCanvas();
            if (!this._snapCanvas || !this._snapCtx) throw new Error('Snap canvas no disponible');

            await new Promise(r => requestAnimationFrame(r));

            const src = this._mirrorRenderer?.domElement;
            if (!src || !src.width || !src.height) throw new Error('Espejo no disponible');

            if (this._snapCanvas.width !== src.width) this._snapCanvas.width = src.width;
            if (this._snapCanvas.height !== src.height) this._snapCanvas.height = src.height;

            const w = this._snapCanvas.width, h = this._snapCanvas.height;

            if (background) {
                this._snapCtx.fillStyle = background;
                this._snapCtx.fillRect(0, 0, w, h);
            } else {
                this._snapCtx.clearRect(0, 0, w, h);
            }

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

            return {blob, url};
        }


        async captureWithVideoTextureQuad({
                                              facingMode = 'environment',
                                              type = 'image/png',   // ⬅️ PNG por defecto para no degradar color
                                              quality = 0.95,
                                              download = true,
                                              filename,
                                              includeCamera = true
                                          } = {}) {
            const srcAR =
                (this._mirrorRenderer && this._mirrorRenderer.domElement) ||
                (this.renderer && this.renderer.domElement);

            if (!srcAR) {
                console.warn('[captureWithVideoTextureQuad] No hay canvas AR disponible');
                return null;
            }

            // Helper para descargar
            const getExtension = (mimeType) => {
                if (mimeType === 'image/png') return 'png';
                if (mimeType === 'image/webp') return 'webp';
                return 'jpg';
            };

            const downloadBlob = (blob, prefix) => {
                if (!blob || !download) return;

                const ext = getExtension(type);
                const label = prefix || 'capture';
                const ts = (typeof this._timestamp === 'function')
                    ? (this._timestamp() || Date.now())
                    : Date.now();

                const name = filename || `${label}-${ts}.${ext}`;
                const url = URL.createObjectURL(blob);

                const a = document.createElement('a');
                a.href = url;
                a.download = name;
                document.body.appendChild(a);
                a.click();
                a.remove();

                setTimeout(() => URL.revokeObjectURL(url), 1000);
            };

            // Asegurar un frame fresco del AR
            await new Promise((resolve) => requestAnimationFrame(resolve));

            // ================= SOLO AR (sin cámara extra) =================
            if (!includeCamera) {
                const blob = await new Promise((resolve) =>
                    srcAR.toBlob(resolve, type, quality)
                );
                downloadBlob(blob, 'ar-only');
                return blob || null;
            }

            // ================= CÁMARA + AR (composite) =================
            let stream = null;
            let video = null;

            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {facingMode, width: 1280, height: 720},
                    audio: false
                });

                video = document.createElement('video');
                video.playsInline = true;
                video.muted = true;
                video.autoplay = true;
                video.srcObject = stream;

                Object.assign(video.style, {
                    position: 'fixed',
                    width: '1px',
                    height: '1px',
                    opacity: '0',
                    pointerEvents: 'none',
                    zIndex: '-1',
                    left: '0',
                    top: '0'
                });

                document.body.appendChild(video);

                // Esperar metadata
                await new Promise((resolve, reject) => {
                    const onLoadedMetadata = () => {
                        cleanup();
                        resolve();
                    };
                    const onError = (e) => {
                        cleanup();
                        reject(e);
                    };
                    const cleanup = () => {
                        video.removeEventListener('loadedmetadata', onLoadedMetadata);
                        video.removeEventListener('error', onError);
                    };
                    video.addEventListener('loadedmetadata', onLoadedMetadata, {once: true});
                    video.addEventListener('error', onError, {once: true});
                });

                try {
                    await video.play();
                } catch (_) {
                }
                await new Promise((resolve) => setTimeout(resolve, 120));
                await new Promise((resolve) => requestAnimationFrame(resolve));

                const targetWidth = Math.max(1, srcAR.width);
                const targetHeight = Math.max(1, srcAR.height);

                // ⬅️ Intentamos forzar sRGB cuando el navegador lo soporte
                const compositeCanvas = document.createElement('canvas');
                compositeCanvas.width = targetWidth;
                compositeCanvas.height = targetHeight;

                const ctx = compositeCanvas.getContext('2d', {
                    willReadFrequently: false,
                    colorSpace: 'srgb'
                }) || compositeCanvas.getContext('2d');

                const videoWidth = video.videoWidth || 1280;
                const videoHeight = video.videoHeight || 720;

                const videoAspect = videoWidth / videoHeight;
                const canvasAspect = targetWidth / targetHeight;

                let sx, sy, sWidth, sHeight;

                if (videoAspect > canvasAspect) {
                    sHeight = videoHeight;
                    sWidth = sHeight * canvasAspect;
                    sx = (videoWidth - sWidth) / 2;
                    sy = 0;
                } else {
                    sWidth = videoWidth;
                    sHeight = sWidth / canvasAspect;
                    sx = 0;
                    sy = (videoHeight - sHeight) / 2;
                }

                // 1) Fondo: cámara (suave, con suavizado)
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';
                ctx.filter = 'none';
                ctx.drawImage(
                    video,
                    sx, sy, sWidth, sHeight,
                    0, 0, targetWidth, targetHeight
                );

                // 2) AR encima 1:1, con un ligero ajuste para bajar saturación/brillo
                //    (ajústalo si lo ves necesario: p.ej. 'saturate(0.9) brightness(0.95)')
                ctx.imageSmoothingEnabled = false;
                ctx.filter = 'saturate(0.9) brightness(0.97)';
                ctx.drawImage(srcAR, 0, 0, targetWidth, targetHeight);
                ctx.filter = 'none';

                const blob = await new Promise((resolve) =>
                    compositeCanvas.toBlob(resolve, type, quality)
                );

                downloadBlob(blob, 'ar-composite');
                return blob || null;

            } catch (error) {
                console.error('[captureWithVideoTextureQuad] error', error);
                return null;

            } finally {
                try {
                    stream?.getTracks()?.forEach(track => track.stop());
                } catch (_) {
                }
                if (video?.parentNode) {
                    video.parentNode.removeChild(video);
                }
            }
        }


        async restartXRAfterCamera({rePlaceModel = true} = {}) {
            let prevDist = null;
            const hadModel = !!this.model;

            try {
                if (this.model && this.camera) {
                    prevDist = this.camera.position.distanceTo(this.model.position);
                }
            } catch {
            }

            // 1) Volver a crear la sesión XR
            await this._resumeXRSessionInternal();
            await this.afterResumeXR?.();

            // 2) Si queremos recolocar el modelo frente a la cámara (otros flujos)
            if (rePlaceModel && this.model && this.camera &&
                typeof prevDist === 'number' && isFinite(prevDist) && prevDist > 0.05) {
                try {
                    const fwd = new THREE.Vector3(0, 0, -1)
                        .applyQuaternion(this.camera.quaternion)
                        .normalize();
                    const pos = new THREE.Vector3()
                        .copy(this.camera.position)
                        .addScaledVector(fwd, prevDist);
                    this.model.position.copy(pos);
                    this.model.lookAt(
                        this.camera.position.x,
                        this.model.position.y,
                        this.camera.position.z
                    );
                    if (!this.model.parent) this.scene.add(this.model);
                } catch {
                }
            }

            // 3) Si YA había modelo, no queremos que se active el flow de "primer frame"
            if (hadModel && this.model) {
                // Evita que _onXRFrame vuelva a mostrar la retícula y "Toca para colocar…"
                this._firstFrameSeen = true;
                try {
                    this._firstFrameResolve && this._firstFrameResolve();
                } catch {
                }

                // Aseguramos que la UI quede en modo "modelo ya colocado"
                UI.hideReticle();
                UI.setHint('Modelo listo.');
            }

        }


        async _resumeXRSessionInternal() {
            try {
                this.renderer?.setAnimationLoop(null);
            } catch {
            }

            this.session = await navigator.xr.requestSession('immersive-ar', {
                requiredFeatures: ['local'],
                optionalFeatures: ['dom-overlay', 'light-estimation'],
                domOverlay: {root: document.body}
            });

            this.renderer.xr.enabled = true;
            this.renderer.xr.setReferenceSpaceType('local');
            await this.renderer.xr.setSession(this.session);
            this._refSpace = this.renderer.xr.getReferenceSpace();

            this._onEnd = () => this.hooks.onExit && this.hooks.onExit({reason: 'session-end'});
            this._onVis = () => {
                const s = this.session?.visibilityState;
                if (s === 'hidden' || s === 'visible-blurred') {
                    this.hooks.onExit && this.hooks.onExit({reason: 'visibility', state: s});
                }
            };
            this.session.addEventListener('end', this._onEnd);
            this.session.addEventListener('visibilitychange', this._onVis);

            this._lightProbe = null;
            try {
                if (this.session.requestLightProbe) {
                    this._lightProbe = await this.session.requestLightProbe({type: 'spherical-harmonics'});
                }
            } catch {
            }

            this.renderer.setAnimationLoop(this._loop);

            this._firstFrameSeen = false;
            this.ready = new Promise(res => (this._firstFrameResolve = res));

            // 🔹 IMPORTANTE: re-asegurar gestos sobre el canvas
            this._bindGesturesMobile();
        }


        async afterResumeXR() {
            if (!this.renderer) return;

            try {
                this._handleResize();
            } catch {
            }

            await new Promise(r => requestAnimationFrame(r));

            try {
                if (this.session) this.renderer.setAnimationLoop(this._loop);
            } catch {
            }

            try {
                this.renderer.render(this.scene, this.camera);
            } catch {
            }
            await new Promise(r => requestAnimationFrame(r));
            try {
                this.renderer.render(this.scene, this.camera);
            } catch {
            }
        }

        async endXRButKeepScene() {
            if (!this.session) return;

            try {
                this.session.removeEventListener('end', this._onEnd);
                this.session.removeEventListener('visibilitychange', this._onVis);
            } catch {
            }
            this._onEnd = this._onVis = null;

            try {
                this.renderer?.setAnimationLoop(null);
            } catch {
            }

            try {
                await this.session.end();
            } catch {
            }

            this.session = null;
            this._refSpace = null;

            if (this.renderer) {
                this.renderer.setClearAlpha(0);
            }
        }

        startRecording({fps = 30, mimeType = 'video/webm;codecs=vp9'} = {}) {
            if (!this._mirrorRenderer) return false;
            if (this._recorder && this._recorder.state === 'recording') return true;

            const canvas = this._mirrorRenderer.domElement;
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
</script>
