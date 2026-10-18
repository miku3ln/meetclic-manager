
<script>
    class CameraThreeController {
        constructor({ onEnter = null, onExit = null } = {}) {
            this.hooks = { onEnter, onExit };

            this.container = null;
            this.video = null;
            this.stream = null;

            this.scene = null;
            this.camera = null;
            this.renderer = null;
            this.model = null;

            this.modelId = null;
            this.modelUrl = null;

            this._running = false;
            this._raf = null;
            this._onResize = this.resize.bind(this);

            this.raycaster = new THREE.Raycaster();
            this.pointer = new THREE.Vector2();
            this.clock = new THREE.Clock();

            this.mixer = null;
            this._pointerStart = null;
            this._dragging = false;
            this._pinchDistance = null;

            this._onPointerDown = this.onPointerDown.bind(this);
            this._onPointerMove = this.onPointerMove.bind(this);
            this._onPointerUp = this.onPointerUp.bind(this);
            this._onWheel = this.onWheel.bind(this);
        }

        async start() {
            if (this._running) return;

            if (!navigator.mediaDevices?.getUserMedia) {
                throw new Error('La API de cámara no está disponible.');
            }

            this.container = document.querySelector('.container--custom');

            if (!this.container) {
                throw new Error('No existe .container--custom');
            }

            try {
                this.stream = await navigator.mediaDevices.getUserMedia({
                    audio: false,
                    video: {
                        facingMode: { ideal: 'environment' },
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    }
                });

                this.createVideo();
                await this.waitForVideo();
                this.createThreeScene();
                this.bindEvents();

                this._running = true;
                this.clock.start();
                this.animate();

                this.hooks.onEnter?.({ mode: 'camera-three' });

                console.log('[CameraThree] Cámara iniciada');
            } catch (error) {
                await this.stop();
                throw error;
            }
        }

        createVideo() {
            this.video = document.createElement('video');

            this.video.id = 'camera-three-video';
            this.video.autoplay = true;
            this.video.muted = true;
            this.video.playsInline = true;
            this.video.srcObject = this.stream;

            Object.assign(this.video.style, {
                position: 'absolute',
                inset: '0',
                width: '100%',
                height: '100%',
                objectFit: 'cover',
                zIndex: '1',
                pointerEvents: 'none'
            });

            this.container.style.position = 'relative';
            this.container.style.overflow = 'hidden';
            this.container.appendChild(this.video);
        }

        async waitForVideo() {
            await this.video.play();

            if (this.video.videoWidth && this.video.videoHeight) {
                return;
            }

            await new Promise((resolve, reject) => {
                const timeout = setTimeout(() => {
                    cleanup();
                    reject(new Error('La cámara no entregó vídeo.'));
                }, 10000);

                const onLoaded = () => {
                    if (!this.video.videoWidth) return;
                    cleanup();
                    resolve();
                };

                const onError = () => {
                    cleanup();
                    reject(new Error('Error al reproducir la cámara.'));
                };

                const cleanup = () => {
                    clearTimeout(timeout);
                    this.video.removeEventListener('loadedmetadata', onLoaded);
                    this.video.removeEventListener('error', onError);
                };

                this.video.addEventListener('loadedmetadata', onLoaded);
                this.video.addEventListener('error', onError);
            });
        }

        createThreeScene() {
            const width = this.container.clientWidth || window.innerWidth;
            const height = this.container.clientHeight || window.innerHeight;

            console.log('[CameraThree] Dimensiones:', {
                width,
                height,
                containerWidth: this.container.clientWidth,
                containerHeight: this.container.clientHeight
            });

            this.scene = new THREE.Scene();

            this.camera = new THREE.PerspectiveCamera(
                55,
                width / height,
                0.01,
                100
            );

            this.camera.position.set(0, 0, 0);
            this.camera.lookAt(0, 0, -1);

            this.renderer = new THREE.WebGLRenderer({
                alpha: true,
                antialias: true,
                preserveDrawingBuffer: true
            });

            this.renderer.setPixelRatio(
                Math.min(window.devicePixelRatio || 1, 2)
            );

            this.renderer.setSize(width, height);
            this.renderer.setClearColor(0x000000, 0);

            this.renderer.outputEncoding = THREE.sRGBEncoding;

            const canvas = this.renderer.domElement;
            canvas.id = 'camera-three-canvas';

            Object.assign(canvas.style, {
                position: 'absolute',
                inset: '0',
                width: '100%',
                height: '100%',
                zIndex: '2',
                touchAction: 'none'
            });

            this.container.appendChild(canvas);

            this.scene.add(
                new THREE.HemisphereLight(
                    0xffffff,
                    0x666666,
                    2
                )
            );

            const directional = new THREE.DirectionalLight(
                0xffffff,
                1.5
            );

            directional.position.set(2, 4, 3);
            this.scene.add(directional);
        }

        async loadModel(glbUrl, id = null) {
            if (!this.scene) {
                throw new Error('Inicializa la cámara antes del GLB.');
            }

            await this.disposeModel();

            const resolved = AssetPreloader.getBlobURL(glbUrl) || glbUrl;

            const gltf = await new Promise((resolve, reject) => {
                new THREE.GLTFLoader().load(
                    resolved,
                    resolve,
                    undefined,
                    reject
                );
            });

            this.model = gltf.scene;
            this.modelId = id;
            this.modelUrl = glbUrl;

            // Normalizar tamaño del modelo.
            const bounds = new THREE.Box3().setFromObject(this.model);
            const size = new THREE.Vector3();
            const center = new THREE.Vector3();

            bounds.getSize(size);
            bounds.getCenter(center);

            const maxDimension = Math.max(
                size.x,
                size.y,
                size.z,
                0.0001
            );

            const scale = 0.9 / maxDimension;

            this.model.scale.setScalar(scale);

            // Centrar geometría sin perder el objeto raíz.
            this.model.position.set(
                -center.x * scale,
                -center.y * scale,
                -1.8 - center.z * scale
            );

            this.scene.add(this.model);

            if (gltf.animations?.length) {
                this.mixer = new THREE.AnimationMixer(this.model);

                gltf.animations.forEach(animation => {
                    this.mixer.clipAction(animation).play();
                });
            }

            this.emit('viewer:model:loaded', {
                id: this.modelId,
                glbUrl: this.modelUrl
            });

            console.log('[CameraThree] Modelo cargado:', glbUrl);
        }

        animate() {
            if (!this._running) return;

            this._raf = requestAnimationFrame(() => this.animate());

            const delta = this.clock.getDelta();
            this.mixer?.update(delta);

            this.renderer.render(this.scene, this.camera);
        }

        resize() {
            if (!this.renderer || !this.camera || !this.container) {
                return;
            }

            const width = this.container.clientWidth || window.innerWidth;
            const height = this.container.clientHeight || window.innerHeight;

            if (width <= 0 || height <= 0) return;

            this.camera.aspect = width / height;
            this.camera.updateProjectionMatrix();

            this.renderer.setSize(width, height);

            console.log('[CameraThree] Resize:', width, height);
        }

        bindEvents() {
            const canvas = this.renderer.domElement;

            canvas.addEventListener('pointerdown', this._onPointerDown);
            canvas.addEventListener('pointermove', this._onPointerMove);
            canvas.addEventListener('pointerup', this._onPointerUp);
            canvas.addEventListener('pointercancel', this._onPointerUp);
            canvas.addEventListener('wheel', this._onWheel, {
                passive: false
            });

            window.addEventListener('resize', this._onResize);
        }

        onPointerDown(event) {
            if (!this.model) return;

            this.renderer.domElement.setPointerCapture?.(event.pointerId);

            this._pointerStart = {
                x: event.clientX,
                y: event.clientY
            };

            this._dragging = false;

            this.emit('viewer:pointer:down', {
                id: this.modelId,
                x: event.clientX,
                y: event.clientY
            });
        }

        onPointerMove(event) {
            if (!this.model || !this._pointerStart) return;

            const dx = event.clientX - this._pointerStart.x;
            const dy = event.clientY - this._pointerStart.y;

            if (Math.abs(dx) + Math.abs(dy) > 4) {
                this._dragging = true;
            }

            // Desplazamiento en el plano X/Y.
            const distance = Math.abs(this.model.position.z);
            const visibleHeight =
                2 * Math.tan(THREE.MathUtils.degToRad(
                    this.camera.fov / 2
                )) * distance;

            const visibleWidth = visibleHeight * this.camera.aspect;

            const rect = this.renderer.domElement.getBoundingClientRect();

            this.model.position.x += dx / rect.width * visibleWidth;
            this.model.position.y -= dy / rect.height * visibleHeight;

            this._pointerStart = {
                x: event.clientX,
                y: event.clientY
            };

            this.emit('viewer:model:move', {
                id: this.modelId,
                position: this.model.position.toArray()
            });
        }

        onPointerUp(event) {
            if (!this.model || !this._pointerStart) return;

            if (!this._dragging) {
                this.emit('viewer:model:click', {
                    id: this.modelId,
                    position: this.model.position.toArray()
                });
            }

            this._pointerStart = null;
            this._dragging = false;
        }

        onWheel(event) {
            if (!this.model) return;

            event.preventDefault();

            const factor = event.deltaY > 0 ? 0.9 : 1.1;

            this.model.scale.multiplyScalar(factor);

            this.emit('viewer:model:scale', {
                id: this.modelId,
                scale: this.model.scale.toArray()
            });
        }

        rotateModelLeft(degrees = 15) {
            if (!this.model) return;

            this.model.rotation.y += THREE.MathUtils.degToRad(degrees);
        }

        rotateModelUpDown(degrees = 15) {
            if (!this.model) return;

            this.model.rotation.x += THREE.MathUtils.degToRad(degrees);
        }

        emit(name, detail = {}) {
            window.dispatchEvent(
                new CustomEvent(name, { detail })
            );
        }

        async disposeModel() {
            if (!this.model) return;

            this.scene?.remove(this.model);

            this.model.traverse(object => {
                if (!object.isMesh) return;

                object.geometry?.dispose();

                const materials = Array.isArray(object.material)
                    ? object.material
                    : [object.material];

                materials.forEach(material => {
                    material?.dispose();
                });
            });

            this.mixer?.stopAllAction();
            this.mixer = null;
            this.model = null;
        }

        async stop() {
            this._running = false;

            if (this._raf !== null) {
                cancelAnimationFrame(this._raf);
                this._raf = null;
            }

            window.removeEventListener('resize', this._onResize);

            const canvas = this.renderer?.domElement;

            if (canvas) {
                canvas.removeEventListener('pointerdown', this._onPointerDown);
                canvas.removeEventListener('pointermove', this._onPointerMove);
                canvas.removeEventListener('pointerup', this._onPointerUp);
                canvas.removeEventListener('pointercancel', this._onPointerUp);
                canvas.removeEventListener('wheel', this._onWheel);
            }

            await this.disposeModel();

            this.stream?.getTracks().forEach(track => track.stop());
            this.stream = null;

            this.video?.pause();
            this.video?.remove();
            this.video = null;

            this.renderer?.domElement.remove();
            this.renderer?.dispose();

            this.renderer = null;
            this.scene = null;
            this.camera = null;

            this.hooks.onExit?.({ reason: 'stop' });
        }
    }
</script>
