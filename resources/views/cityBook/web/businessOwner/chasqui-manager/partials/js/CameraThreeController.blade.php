
<script>
    class CameraThreeController {

        constructor({
                        dataTotem = null,
                        onEnter = null,
                        onExit = null
                    } = {}) {
            this.dataTotem = dataTotem;
            this.hooks = { onEnter, onExit };

            this.container = null;
            this.video = null;
            this.stream = null;

            this.scene = null;
            this.camera = null;
            this.renderer = null;

            this.model = null;
            this.modelRoot = null;
            this.modelId = null;
            this.modelUrl = null;
            this.mixer = null;

            this.clock = new THREE.Clock();
            this.raycaster = new THREE.Raycaster();
            this.pointer = new THREE.Vector2();

            this._running = false;
            this._raf = null;

            this._pointers = new Map();
            this._gesture = null;
            this._selected = false;

            this._trackingEnabled = false;
            this._hasOrientation = false;
            this._initialQuaternion = null;
            this._deviceQuaternion = new THREE.Quaternion();
            this._orientationQuaternion = new THREE.Quaternion();

            this._zee = new THREE.Vector3(0, 0, 1);
            this._q0 = new THREE.Quaternion();
            this._q1 = new THREE.Quaternion(
                -Math.sqrt(0.5), 0, 0, Math.sqrt(0.5)
            );

            this._onResize = this.resize.bind(this);
            this._onOrientation = this.onDeviceOrientation.bind(this);
            this._onOrientationChange = this.onOrientationChange.bind(this);

            this._onPointerDown = this.onPointerDown.bind(this);
            this._onPointerMove = this.onPointerMove.bind(this);
            this._onPointerUp = this.onPointerUp.bind(this);
            this._onWheel = this.onWheel.bind(this);

            this.geoPosition = dataTotem?.position
                ? {
                    lat: Number(dataTotem.position.lat),
                    lng: Number(dataTotem.position.lng)
                }
                : null;

            this.userLocation = null;
            this.worldPosition = null;

            this._baseScale = 1;
        }

        // ==========================================
        // INICIALIZACIÓN
        // ==========================================

        async start() {
            if (this._running) return;

            if (!navigator.mediaDevices?.getUserMedia) {
                throw new Error('La cámara no está disponible.');
            }

            this.container = document.querySelector('.container--custom');

            if (!this.container) {
                throw new Error('No existe .container--custom');
            }

            try {
                this.container.classList.add('camera-three-active');

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

        // ==========================================
        // THREE.JS
        // ==========================================

        getSize() {
            return {
                width: Math.max(
                    1,
                    this.container?.clientWidth || window.innerWidth
                ),
                height: Math.max(
                    1,
                    this.container?.clientHeight || window.innerHeight
                )
            };
        }

        createThreeScene() {
            const { width, height } = this.getSize();

            this.scene = new THREE.Scene();

            this.camera = new THREE.PerspectiveCamera(
                55,
                width / height,
                0.01,
                1000
            );

            this.camera.position.set(0, 0, 0);
            this.camera.quaternion.identity();

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

            const ambient = new THREE.HemisphereLight(
                0xffffff,
                0x666666,
                2
            );

            this.scene.add(ambient);

            const directional = new THREE.DirectionalLight(
                0xffffff,
                1.5
            );

            directional.position.set(2, 4, 3);
            this.scene.add(directional);
        }

        async loadModel(glbUrl, id = null) {
            if (!this.scene) {
                throw new Error('Primero debes iniciar la cámara.');
            }

            await this.disposeModel();

            const resolved =
                AssetPreloader.getBlobURL(glbUrl) || glbUrl;

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

            // Contenedor para mover, girar y escalar
            // sin alterar el centrado interno del GLB.
            this.modelRoot = new THREE.Group();
            this.modelRoot.name = 'CameraThreeModelRoot';

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

            this._baseScale = 1 / maxDimension;

            this.model.scale.setScalar(this._baseScale);

            // Mantener los pies aproximadamente en Y=0
            // y centrar horizontalmente.
            this.model.position.set(
                -center.x * this._baseScale,
                -bounds.min.y * this._baseScale,
                -center.z * this._baseScale
            );

            this.modelRoot.add(this.model);

            // Ubicación inicial fija en el mundo virtual.
            // La cámara virtual comienza en el origen.
            this.modelRoot.position.set(0, -0.6, -2.5);

            this.scene.add(this.modelRoot);

            if (gltf.animations?.length) {
                this.mixer = new THREE.AnimationMixer(this.model);

                gltf.animations.forEach(animation => {
                    this.mixer.clipAction(animation).play();
                });
            }

            this.emit('viewer:model:loaded', {
                id: this.modelId,
                glbUrl: this.modelUrl,
                dataTotem: this.dataTotem,
                position: this.modelRoot.position.toArray()
            });

            console.log('[CameraThree] Modelo cargado:', glbUrl);
        }

        animate() {
            if (!this._running) return;

            this._raf = requestAnimationFrame(() => this.animate());

            const delta = this.clock.getDelta();

            this.mixer?.update(delta);

            if (this._trackingEnabled && this._hasOrientation) {
                this.camera.quaternion.slerp(
                    this._orientationQuaternion,
                    Math.min(1, delta * 12)
                );
            }

            this.renderer.render(this.scene, this.camera);
        }

        resize() {
            if (!this.renderer || !this.camera || !this.container) {
                return;
            }

            const { width, height } = this.getSize();

            this.camera.aspect = width / height;
            this.camera.updateProjectionMatrix();

            this.renderer.setSize(width, height);
        }

        // ==========================================
        // ORIENTACIÓN DEL TELÉFONO
        // ==========================================

        async enableOrientation() {
            if (typeof DeviceOrientationEvent === 'undefined') {
                console.warn('[CameraThree] Sin sensores de orientación.');
                return false;
            }

            if (
                typeof DeviceOrientationEvent.requestPermission === 'function'
            ) {
                const permission =
                    await DeviceOrientationEvent.requestPermission();

                if (permission !== 'granted') {
                    return false;
                }
            }

            window.removeEventListener(
                'deviceorientation',
                this._onOrientation
            );

            window.addEventListener(
                'deviceorientation',
                this._onOrientation,
                true
            );

            window.addEventListener(
                'orientationchange',
                this._onOrientationChange
            );

            this._trackingEnabled = true;

            this.emit('viewer:tracking:enabled', {
                id: this.modelId
            });

            return true;
        }

        onDeviceOrientation(event) {
            if (
                event.alpha == null ||
                event.beta == null ||
                event.gamma == null
            ) {
                return;
            }

            const alpha = THREE.MathUtils.degToRad(event.alpha);
            const beta = THREE.MathUtils.degToRad(event.beta);
            const gamma = THREE.MathUtils.degToRad(event.gamma);

            const orient = THREE.MathUtils.degToRad(
                screen.orientation?.angle ||
                window.orientation ||
                0
            );

            // Convención usada por DeviceOrientationControls
            // de Three.js para orientación del dispositivo.
            const euler = new THREE.Euler(
                beta,
                alpha,
                -gamma,
                'YXZ'
            );

            this._deviceQuaternion.setFromEuler(euler);

            this._deviceQuaternion.multiply(this._q1);

            this._deviceQuaternion.multiply(
                this._q0.setFromAxisAngle(this._zee, -orient)
            );

            if (!this._initialQuaternion) {
                this._initialQuaternion =
                    this._deviceQuaternion.clone();

                // Recalibrar respecto a la orientación inicial.
                this.emit('viewer:tracking:calibrated', {
                    id: this.modelId
                });
            }

            this._orientationQuaternion.copy(
                this._initialQuaternion
            ).invert().multiply(this._deviceQuaternion);

            this._hasOrientation = true;
        }

        onOrientationChange() {
            this._initialQuaternion = null;
        }

        recenter() {
            this._initialQuaternion = null;
            this._orientationQuaternion.identity();

            if (this.camera) {
                this.camera.quaternion.identity();
            }

            this.emit('viewer:tracking:recenter', {
                id: this.modelId
            });
        }

        disableOrientation() {
            this._trackingEnabled = false;
            this._hasOrientation = false;

            window.removeEventListener(
                'deviceorientation',
                this._onOrientation,
                true
            );

            window.removeEventListener(
                'orientationchange',
                this._onOrientationChange
            );
        }

        // ==========================================
        // EVENTOS TÁCTILES
        // ==========================================

        bindEvents() {
            const canvas = this.renderer.domElement;

            canvas.addEventListener(
                'pointerdown',
                this._onPointerDown
            );

            canvas.addEventListener(
                'pointermove',
                this._onPointerMove
            );

            canvas.addEventListener(
                'pointerup',
                this._onPointerUp
            );

            canvas.addEventListener(
                'pointercancel',
                this._onPointerUp
            );

            canvas.addEventListener(
                'wheel',
                this._onWheel,
                { passive: false }
            );

            window.addEventListener('resize', this._onResize);
        }

        getPointerCoordinates(event) {
            const rect =
                this.renderer.domElement.getBoundingClientRect();

            this.pointer.x =
                ((event.clientX - rect.left) / rect.width) * 2 - 1;

            this.pointer.y =
                -((event.clientY - rect.top) / rect.height) * 2 + 1;

            return this.pointer;
        }

        hitTest(event) {
            if (!this.model || !this.camera) return null;

            this.getPointerCoordinates(event);

            this.raycaster.setFromCamera(
                this.pointer,
                this.camera
            );

            const intersections = this.raycaster.intersectObject(
                this.model,
                true
            );

            return intersections[0] || null;
        }

        onPointerDown(event) {
            if (!this.modelRoot) return;

            this._pointers.set(event.pointerId, {
                x: event.clientX,
                y: event.clientY
            });

            this.renderer.domElement.setPointerCapture?.(
                event.pointerId
            );

            const hit = this.hitTest(event);

            if (this._pointers.size === 1) {
                this._gesture = {
                    startX: event.clientX,
                    startY: event.clientY,
                    lastX: event.clientX,
                    lastY: event.clientY,
                    dragging: false,
                    hit: hit,
                    initialScale: this.modelRoot.scale.x
                };
            }

            if (this._pointers.size === 2) {
                const points = [...this._pointers.values()];

                this._gesture = {
                    type: 'pinch',
                    distance: Math.hypot(
                        points[0].x - points[1].x,
                        points[0].y - points[1].y
                    ),
                    initialScale: this.modelRoot.scale.x
                };
            }

            this.emit('viewer:pointer:down', {
                id: this.modelId,
                x: event.clientX,
                y: event.clientY,
                onModel: !!hit
            });
        }

        onPointerMove(event) {
            if (!this.modelRoot || !this._pointers.has(event.pointerId)) {
                return;
            }

            this._pointers.set(event.pointerId, {
                x: event.clientX,
                y: event.clientY
            });

            if (this._pointers.size === 2) {
                const points = [...this._pointers.values()];

                const distance = Math.hypot(
                    points[0].x - points[1].x,
                    points[0].y - points[1].y
                );

                if (
                    this._gesture?.type === 'pinch' &&
                    this._gesture.distance > 0
                ) {
                    const factor =
                        distance / this._gesture.distance;

                    this.setScale(
                        this._gesture.initialScale * factor
                    );
                }

                return;
            }

            if (!this._gesture || !this._gesture.hit) return;

            const dx = event.clientX - this._gesture.lastX;
            const dy = event.clientY - this._gesture.lastY;

            const totalDistance = Math.hypot(
                event.clientX - this._gesture.startX,
                event.clientY - this._gesture.startY
            );

            if (totalDistance > 5) {
                this._gesture.dragging = true;
            }

            if (this._gesture.dragging) {
                const rect =
                    this.renderer.domElement.getBoundingClientRect();

                const distance = this.camera.position.distanceTo(
                    this.modelRoot.position
                );

                const visibleHeight =
                    2 *
                    Math.tan(
                        THREE.MathUtils.degToRad(
                            this.camera.fov / 2
                        )
                    ) *
                    distance;

                const visibleWidth =
                    visibleHeight * this.camera.aspect;

                // Movimiento alineado con la orientación
                // actual de la cámara.
                const right = new THREE.Vector3(1, 0, 0)
                    .applyQuaternion(this.camera.quaternion);

                const up = new THREE.Vector3(0, 1, 0)
                    .applyQuaternion(this.camera.quaternion);

                this.modelRoot.position.addScaledVector(
                    right,
                    dx / rect.width * visibleWidth
                );

                this.modelRoot.position.addScaledVector(
                    up,
                    -dy / rect.height * visibleHeight
                );

                this.emitMove();
            }

            this._gesture.lastX = event.clientX;
            this._gesture.lastY = event.clientY;
        }

        onPointerUp(event) {
            const gesture = this._gesture;

            if (
                this._pointers.size === 1 &&
                gesture &&
                !gesture.dragging &&
                gesture.type !== 'pinch'
            ) {
                const hit = this.hitTest(event);

                if (hit) {
                    this.emit('viewer:model:click', {
                        id: this.modelId,
                        dataTotem: this.dataTotem,
                        meshName: hit.object.name,
                        point: hit.point.toArray(),
                        position: this.modelRoot.position.toArray()
                    });
                } else {
                    this.emit('viewer:scene:click', {
                        id: this.modelId,
                        x: event.clientX,
                        y: event.clientY
                    });
                }
            }

            this._pointers.delete(event.pointerId);

            if (this._pointers.size === 0) {
                this._gesture = null;
            } else if (this._pointers.size === 1) {
                const point = [...this._pointers.values()][0];

                this._gesture = {
                    type: 'resume',
                    startX: point.x,
                    startY: point.y,
                    lastX: point.x,
                    lastY: point.y,
                    dragging: false,
                    hit: null
                };
            }

            this.emit('viewer:pointer:up', {
                id: this.modelId
            });
        }

        onWheel(event) {
            if (!this.modelRoot) return;

            event.preventDefault();

            this.scaleModel(event.deltaY > 0 ? 0.9 : 1.1);
        }

        // ==========================================
        // MOVIMIENTO X / Y / Z
        // ==========================================

        moveModel(x = 0, y = 0, z = 0) {
            if (!this.modelRoot) return;

            this.modelRoot.position.x += x;
            this.modelRoot.position.y += y;
            this.modelRoot.position.z += z;

            this.emitMove();
        }

        setModelPosition(x, y, z) {
            if (!this.modelRoot) return;

            this.modelRoot.position.set(x, y, z);
            this.emitMove();
        }

        emitMove() {
            this.emit('viewer:model:move', {
                id: this.modelId,
                position: this.modelRoot.position.toArray(),
                dataTotem: this.dataTotem
            });
        }

        // ==========================================
        // ROTACIONES
        // ==========================================

        rotateModelLeft(degrees = 15) {
            if (!this.modelRoot) return;

            this.modelRoot.rotation.y +=
                THREE.MathUtils.degToRad(degrees);

            this.emitRotate('left', degrees);
        }

        rotateModelRight(degrees = 15) {
            if (!this.modelRoot) return;

            this.modelRoot.rotation.y -=
                THREE.MathUtils.degToRad(degrees);

            this.emitRotate('right', degrees);
        }

        rotateModelUp(degrees = 15) {
            if (!this.modelRoot) return;

            this.modelRoot.rotation.x +=
                THREE.MathUtils.degToRad(degrees);

            this.emitRotate('up', degrees);
        }

        rotateModelDown(degrees = 15) {
            if (!this.modelRoot) return;

            this.modelRoot.rotation.x -=
                THREE.MathUtils.degToRad(degrees);

            this.emitRotate('down', degrees);
        }

        rotateModelUpDown(degrees = 15) {
            if (degrees >= 0) {
                this.rotateModelUp(degrees);
            } else {
                this.rotateModelDown(Math.abs(degrees));
            }
        }

        emitRotate(direction, degrees) {
            this.emit('viewer:model:rotate', {
                id: this.modelId,
                direction,
                degrees,
                rotation: this.modelRoot.rotation.toArray().slice(0, 3)
            });
        }

        // ==========================================
        // ESCALA
        // ==========================================

        setScale(value) {
            if (!this.modelRoot) return;

            const scale = THREE.MathUtils.clamp(
                value,
                0.1,
                8
            );

            this.modelRoot.scale.setScalar(scale);

            this.emit('viewer:model:scale', {
                id: this.modelId,
                scale
            });
        }

        scaleModel(factor = 1.1) {
            if (!this.modelRoot) return;

            this.setScale(this.modelRoot.scale.x * factor);
        }

        // ==========================================
        // GPS Y COORDENADAS
        // ==========================================

        geoToWorld(origin, target) {
            if (!origin || !target) return null;

            const earthRadius = 6378137;
            const toRad = value => value * Math.PI / 180;

            const originLat = toRad(origin.lat);
            const targetLat = toRad(target.lat);

            const deltaLat = targetLat - originLat;
            const deltaLng = toRad(target.lng - origin.lng);

            return {
                x: earthRadius *
                    deltaLng *
                    Math.cos((originLat + targetLat) / 2),

                y: 0,

                z: -earthRadius * deltaLat
            };
        }

        async getUserLocation() {
            if (!navigator.geolocation) {
                throw new Error('Geolocalización no disponible.');
            }

            return new Promise((resolve, reject) => {
                navigator.geolocation.getCurrentPosition(
                    position => resolve({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                        altitude: position.coords.altitude,
                        accuracy: position.coords.accuracy
                    }),
                    reject,
                    {
                        enableHighAccuracy: true,
                        timeout: 15000,
                        maximumAge: 5000
                    }
                );
            });
        }

        async initializeWorldPosition() {
            if (!this.geoPosition) return null;

            const userLocation = await this.getUserLocation();

            const worldPosition = this.geoToWorld(
                userLocation,
                this.geoPosition
            );

            this.userLocation = userLocation;
            this.worldPosition = worldPosition;

            this.emit('viewer:geo:position', {
                id: this.modelId,
                userLocation,
                targetLocation: this.geoPosition,
                worldPosition
            });

            return worldPosition;
        }

        // ==========================================
        // FOTOGRAFÍA
        // ==========================================

        async capturePhotoBlob() {
            if (!this.video || !this.renderer) {
                throw new Error('La cámara no está iniciada.');
            }

            const width = this.renderer.domElement.width;
            const height = this.renderer.domElement.height;

            const canvas = document.createElement('canvas');
            canvas.width = width;
            canvas.height = height;

            const ctx = canvas.getContext('2d');

            const vw = this.video.videoWidth;
            const vh = this.video.videoHeight;

            if (!vw || !vh) {
                throw new Error('No existe un fotograma disponible.');
            }

            // Equivalente a object-fit: cover.
            const scale = Math.max(width / vw, height / vh);

            const sourceWidth = width / scale;
            const sourceHeight = height / scale;

            const sx = (vw - sourceWidth) / 2;
            const sy = (vh - sourceHeight) / 2;

            ctx.drawImage(
                this.video,
                sx,
                sy,
                sourceWidth,
                sourceHeight,
                0,
                0,
                width,
                height
            );

            // Renderizar GLB con transparencia.
            this.renderer.render(this.scene, this.camera);

            ctx.drawImage(
                this.renderer.domElement,
                0,
                0,
                width,
                height
            );

            return new Promise((resolve, reject) => {
                canvas.toBlob(
                    blob => blob
                        ? resolve(blob)
                        : reject(new Error('No se pudo generar PNG.')),
                    'image/png'
                );
            });
        }

        async savePhoto() {
            const blob = await this.capturePhotoBlob();

            const url = URL.createObjectURL(blob);

            const link = document.createElement('a');

            link.href = url;
            link.download = `maskana-${this.modelId || 'modelo'}-${Date.now()}.png`;

            document.body.appendChild(link);
            link.click();
            link.remove();

            setTimeout(() => URL.revokeObjectURL(url), 30000);

            this.emit('viewer:photo:saved', {
                id: this.modelId,
                size: blob.size
            });

            return blob;
        }

        // ==========================================
        // EVENTOS
        // ==========================================

        emit(name, detail = {}) {
            window.dispatchEvent(
                new CustomEvent(name, { detail })
            );
        }

        // ==========================================
        // LIBERACIÓN DE RECURSOS
        // ==========================================

        async disposeModel() {
            if (!this.model) return;

            this.scene?.remove(this.modelRoot);

            this.model.traverse(object => {
                if (!object.isMesh) return;

                object.geometry?.dispose();

                const materials = Array.isArray(object.material)
                    ? object.material
                    : [object.material];

                materials.forEach(material => {
                    if (!material) return;

                    // Liberar texturas del modelo.
                    Object.keys(material).forEach(key => {
                        const value = material[key];

                        if (value?.isTexture) {
                            value.dispose();
                        }
                    });

                    material.dispose();
                });
            });

            this.mixer?.stopAllAction();

            this.mixer = null;
            this.model = null;
            this.modelRoot = null;
        }

        async stop() {
            this._running = false;

            if (this._raf !== null) {
                cancelAnimationFrame(this._raf);
                this._raf = null;
            }

            this.disableOrientation();

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

            if (this.video) {
                this.video.srcObject = null;
                this.video.remove();
            }

            this.video = null;

            this.renderer?.domElement.remove();
            this.renderer?.dispose();

            this.renderer = null;
            this.scene = null;
            this.camera = null;

            this._pointers.clear();
            this._gesture = null;

            this.container?.classList.remove('camera-three-active');

            this.hooks.onExit?.({ reason: 'stop' });

            console.log('[CameraThree] Recursos liberados');
        }
    }
</script>
