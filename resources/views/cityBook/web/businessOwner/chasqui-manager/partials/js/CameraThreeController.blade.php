
<script>
    class CameraThreeController {

        constructor({
                        dataTotem = null,
                        onEnter = null,
                        onExit = null
                    } = {}) {

            this.dataTotem = dataTotem;
            this.hooks = { onEnter, onExit };

            // ==========================================
            // DOM Y CÁMARA
            // ==========================================

            this.container = null;
            this.video = null;
            this.stream = null;

            // ==========================================
            // THREE.JS
            // ==========================================

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

            // ==========================================
            // GESTOS TÁCTILES
            // ==========================================

            this._pointers = new Map();
            this._gesture = null;

            this._onResize = this.resize.bind(this);
            this._onPointerDown = this.onPointerDown.bind(this);
            this._onPointerMove = this.onPointerMove.bind(this);
            this._onPointerUp = this.onPointerUp.bind(this);
            this._onWheel = this.onWheel.bind(this);

            // ==========================================
            // JOYSTICK INTEGRADO
            // ==========================================

            this.joystick = {
                manager: null,
                zone: null,
                controls: null,

                enabled: false,
                mode: 'move',

                x: 0,
                y: 0,

                deadZone: 0.20,

                moveSpeed: 0.65,
                depthSpeed: 0.90,
                rotationSpeed: 65,

                lastTime: null,
                raf: null
            };

            this._updateJoystick =
                this.updateJoystick.bind(this);

            // ==========================================
            // POSICIÓN INICIAL
            // ==========================================

            this.initialModelPosition = new THREE.Vector3(
                0,
                -0.6,
                -2.5
            );

            this.geoPosition = dataTotem?.position || null;
        }

        // ==========================================
        // 1. INICIAR CÁMARA Y ESCENARIO
        // ==========================================

        async start() {

            if (this._running) return;

            if (!navigator.mediaDevices?.getUserMedia) {
                throw new Error(
                    'La API de cámara no está disponible.'
                );
            }

            this.container = document.querySelector(
                '.container--custom'
            );

            if (!this.container) {
                throw new Error(
                    'No existe .container--custom'
                );
            }

            try {

                this.container.classList.add(
                    'camera-three-active'
                );

                this.stream =
                    await navigator.mediaDevices.getUserMedia({
                        audio: false,
                        video: {
                            facingMode: {
                                ideal: 'environment'
                            },
                            width: { ideal: 1280 },
                            height: { ideal: 720 }
                        }
                    });

                this.createVideo();

                await this.waitForVideo();

                this.createThreeScene();

                this.bindEvents();

                this.createJoystick();

                this._running = true;

                this.clock.start();

                this.animate();

                this.hooks.onEnter?.({
                    mode: 'camera-three'
                });

                console.log(
                    '[CameraThree] Cámara iniciada'
                );

            } catch (error) {

                await this.stop();

                throw error;
            }
        }

        // ==========================================
        // 2. VIDEO DE CÁMARA TRASERA
        // ==========================================

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

            if (
                this.video.videoWidth &&
                this.video.videoHeight
            ) {
                return;
            }

            await new Promise((resolve, reject) => {

                const timeout = setTimeout(() => {
                    cleanup();

                    reject(
                        new Error(
                            'La cámara no entregó vídeo.'
                        )
                    );
                }, 10000);

                const onLoaded = () => {

                    if (!this.video.videoWidth) return;

                    cleanup();
                    resolve();
                };

                const onError = () => {
                    cleanup();

                    reject(
                        new Error(
                            'Error al reproducir la cámara.'
                        )
                    );
                };

                const cleanup = () => {
                    clearTimeout(timeout);

                    this.video.removeEventListener(
                        'loadedmetadata',
                        onLoaded
                    );

                    this.video.removeEventListener(
                        'error',
                        onError
                    );
                };

                this.video.addEventListener(
                    'loadedmetadata',
                    onLoaded
                );

                this.video.addEventListener(
                    'error',
                    onError
                );
            });
        }

        // ==========================================
        // 3. CREAR ESCENARIO THREE.JS
        // ==========================================

        getSize() {

            return {
                width: Math.max(
                    1,
                    this.container?.clientWidth ||
                    window.innerWidth
                ),

                height: Math.max(
                    1,
                    this.container?.clientHeight ||
                    window.innerHeight
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

            this.camera.lookAt(0, 0, -1);

            this.renderer = new THREE.WebGLRenderer({
                alpha: true,
                antialias: true,
                preserveDrawingBuffer: true
            });

            this.renderer.setPixelRatio(
                Math.min(
                    window.devicePixelRatio || 1,
                    2
                )
            );

            this.renderer.setSize(width, height);

            this.renderer.setClearColor(
                0x000000,
                0
            );

            this.renderer.outputEncoding =
                THREE.sRGBEncoding;

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

            // Iluminación ambiental.
            const ambient = new THREE.HemisphereLight(
                0xffffff,
                0x666666,
                2
            );

            this.scene.add(ambient);

            // Iluminación direccional.
            const directional =
                new THREE.DirectionalLight(
                    0xffffff,
                    1.5
                );

            directional.position.set(2, 4, 3);

            this.scene.add(directional);
        }

        // ==========================================
        // 4. CARGAR MODELO GLB
        // ==========================================

        async loadModel(glbUrl, id = null) {

            if (!this.scene) {
                throw new Error(
                    'Inicializa la cámara antes del GLB.'
                );
            }

            await this.disposeModel();

            const cachedUrl =
                typeof AssetPreloader !== 'undefined'
                    ? AssetPreloader.getBlobURL(glbUrl)
                    : null;

            const resolved = cachedUrl || glbUrl;

            const gltf = await new Promise(
                (resolve, reject) => {

                    new THREE.GLTFLoader().load(
                        resolved,
                        resolve,
                        undefined,
                        reject
                    );
                }
            );

            this.model = gltf.scene;

            this.modelId = id;
            this.modelUrl = glbUrl;

            // Crear raíz independiente.
            this.modelRoot = new THREE.Group();

            this.modelRoot.name =
                'CameraThreeModelRoot';

            // Calcular tamaño del GLB.
            const bounds =
                new THREE.Box3().setFromObject(
                    this.model
                );

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

            const scale = 1 / maxDimension;

            this.model.scale.setScalar(scale);

            // Centrar el personaje.
            this.model.position.set(
                -center.x * scale,
                -bounds.min.y * scale,
                -center.z * scale
            );

            this.modelRoot.add(this.model);

            // Posición fija inicial.
            this.modelRoot.position.copy(
                this.initialModelPosition
            );

            this.scene.add(this.modelRoot);

            // Animaciones GLB.
            if (gltf.animations?.length) {

                this.mixer =
                    new THREE.AnimationMixer(this.model);

                gltf.animations.forEach(animation => {
                    this.mixer.clipAction(
                        animation
                    ).play();
                });
            }

            // Activar joystick después de cargar.
            this.enableJoystick();

            this.emit('viewer:model:loaded', {
                id: this.modelId,
                glbUrl: this.modelUrl,
                dataTotem: this.dataTotem,
                position:
                    this.modelRoot.position.toArray()
            });

            console.log(
                '[CameraThree] Modelo cargado',
                {
                    id,
                    glbUrl,
                    position:
                        this.modelRoot.position.toArray()
                }
            );
        }

        // ==========================================
        // 5. ANIMACIÓN
        // ==========================================

        animate() {

            if (!this._running) return;

            this._raf = requestAnimationFrame(
                () => this.animate()
            );

            const delta = this.clock.getDelta();

            this.mixer?.update(delta);

            this.renderer.render(
                this.scene,
                this.camera
            );
        }

        resize() {

            if (
                !this.renderer ||
                !this.camera ||
                !this.container
            ) {
                return;
            }

            const { width, height } = this.getSize();

            this.camera.aspect = width / height;

            this.camera.updateProjectionMatrix();

            this.renderer.setSize(
                width,
                height
            );
        }

        // ==========================================
        // 6. CREAR JOYSTICK CON NIPPLEJS
        // ==========================================

        createJoystick() {

            if (
                typeof nipplejs === 'undefined'
            ) {
                console.warn(
                    '[CameraThree] nipplejs no está disponible'
                );

                return;
            }

            // Evitar duplicados.
            this.destroyJoystick();

            // Contenedor principal.
            const zone = document.createElement('div');

            zone.id = 'camera-three-joystick-zone';

            zone.className =
                'camera-three-joystick-zone';

            Object.assign(zone.style, {
                position: 'absolute',
                left: '20px',
                bottom: '24px',
                width: '140px',
                height: '140px',
                zIndex: '35',
                touchAction: 'none',
                display: 'none'
            });

            this.container.appendChild(zone);

            this.joystick.zone = zone;

            // ======================================
            // BOTONES DE MODO
            // ======================================

            const controls =
                document.createElement('div');

            controls.className =
                'camera-three-joystick-controls';

            Object.assign(controls.style, {
                position: 'absolute',
                left: '20px',
                bottom: '178px',
                display: 'flex',
                gap: '6px',
                flexWrap: 'wrap',
                zIndex: '36'
            });

            const modes = [
                { value: 'move', text: 'Mover' },
                { value: 'depth', text: 'Profundidad' },
                { value: 'rotate', text: 'Girar' }
            ];

            modes.forEach(mode => {

                const button =
                    document.createElement('button');

                button.type = 'button';
                button.textContent = mode.text;

                button.dataset.mode = mode.value;

                Object.assign(button.style, {
                    border: 'none',
                    borderRadius: '8px',
                    padding: '8px 10px',
                    background: '#303750',
                    color: '#fff',
                    fontSize: '12px',
                    cursor: 'pointer'
                });

                button.addEventListener(
                    'click',
                    event => {
                        event.preventDefault();
                        event.stopPropagation();

                        this.setJoystickMode(
                            mode.value
                        );
                    }
                );

                controls.appendChild(button);
            });

            this.container.appendChild(controls);

            this.joystick.controls = controls;

            // ======================================
            // INSTANCIA NIPPLEJS
            // ======================================

            const manager = nipplejs.create({
                zone,
                mode: 'static',
                position: {
                    left: '50%',
                    top: '50%'
                },
                size: 120,
                color: '#4C4CFF',
                restOpacity: 0.8,
                lockX: false,
                lockY: false
            });

            this.joystick.manager = manager;

            // ======================================
            // EVENTO MOVE
            // ======================================

            manager.on('move', (event, data) => {

                if (!this.joystick.enabled) {
                    return;
                }

                if (!this.modelRoot) {
                    return;
                }

                if (!data?.vector) {
                    return;
                }

                const force = Math.min(
                    Math.max(data.force || 0, 0),
                    1
                );

                if (
                    force < this.joystick.deadZone
                ) {
                    this.stopJoystickMovement();
                    return;
                }

                const intensity =
                    (force - this.joystick.deadZone) /
                    (1 - this.joystick.deadZone);

                this.joystick.x =
                    data.vector.x * intensity;

                this.joystick.y =
                    data.vector.y * intensity;

                this.startJoystickMovement();
            });

            // ======================================
            // EVENTO END
            // ======================================

            manager.on('end', () => {

                this.stopJoystickMovement();

                this.emit('viewer:joystick:end', {
                    id: this.modelId,
                    position:
                        this.modelRoot?.position.toArray()
                });
            });

            this.setJoystickMode('move');

            console.log(
                '[CameraThree] Joystick creado'
            );
        }

        // ==========================================
        // 7. ACTIVAR JOYSTICK
        // ==========================================

        enableJoystick() {

            if (!this.joystick.manager) {
                return;
            }

            this.joystick.enabled = true;

            if (this.joystick.zone) {
                this.joystick.zone.style.display =
                    'block';
            }

            if (this.joystick.controls) {
                this.joystick.controls.style.display =
                    'flex';
            }

            this.emit('viewer:joystick:enabled', {
                id: this.modelId
            });
        }

        // ==========================================
        // 8. DESACTIVAR JOYSTICK
        // ==========================================

        disableJoystick() {

            this.joystick.enabled = false;

            this.stopJoystickMovement();

            if (this.joystick.zone) {
                this.joystick.zone.style.display =
                    'none';
            }

            if (this.joystick.controls) {
                this.joystick.controls.style.display =
                    'none';
            }
        }

        // ==========================================
        // 9. CAMBIAR MODO DEL JOYSTICK
        // ==========================================

        setJoystickMode(mode) {

            const allowed = [
                'move',
                'depth',
                'rotate'
            ];

            if (!allowed.includes(mode)) {
                return;
            }

            this.stopJoystickMovement();

            this.joystick.mode = mode;

            // Marcar visualmente el modo activo.
            this.joystick.controls
                ?.querySelectorAll('[data-mode]')
                .forEach(button => {

                    const active =
                        button.dataset.mode === mode;

                    button.style.background =
                        active
                            ? '#4C4CFF'
                            : '#303750';
                });

            this.emit('viewer:joystick:mode', {
                id: this.modelId,
                mode
            });
        }

        // ==========================================
        // 10. INICIAR MOVIMIENTO CONTINUO
        // ==========================================

        startJoystickMovement() {

            if (
                !this.joystick.enabled ||
                !this.modelRoot
            ) {
                return;
            }

            if (this.joystick.raf !== null) {
                return;
            }

            this.joystick.lastTime = null;

            this.joystick.raf =
                requestAnimationFrame(
                    this._updateJoystick
                );
        }

        // ==========================================
        // 11. ACTUALIZAR JOYSTICK
        // ==========================================

        updateJoystick(timestamp) {

            this.joystick.raf = null;

            if (
                !this.joystick.enabled ||
                !this.modelRoot ||
                !this._running
            ) {
                this.stopJoystickMovement();
                return;
            }

            if (this.joystick.lastTime === null) {
                this.joystick.lastTime = timestamp;
            }

            const delta = Math.min(
                (timestamp - this.joystick.lastTime) /
                1000,
                0.05
            );

            this.joystick.lastTime = timestamp;

            const x = this.joystick.x;
            const y = this.joystick.y;

            const mode = this.joystick.mode;

            if (mode === 'move') {

                this.moveModel(
                    x *
                    this.joystick.moveSpeed *
                    delta,

                    y *
                    this.joystick.moveSpeed *
                    delta,

                    0
                );

            } else if (mode === 'depth') {

                this.moveModel(
                    0,
                    0,

                    -y *
                    this.joystick.depthSpeed *
                    delta
                );

            } else if (mode === 'rotate') {

                const rotationX =
                    x *
                    this.joystick.rotationSpeed *
                    delta;

                const rotationY =
                    y *
                    this.joystick.rotationSpeed *
                    delta;

                if (rotationX > 0) {
                    this.rotateModelRight(rotationX);
                } else if (rotationX < 0) {
                    this.rotateModelLeft(
                        Math.abs(rotationX)
                    );
                }

                if (rotationY > 0) {
                    this.rotateModelUp(rotationY);
                } else if (rotationY < 0) {
                    this.rotateModelDown(
                        Math.abs(rotationY)
                    );
                }
            }

            this.joystick.raf =
                requestAnimationFrame(
                    this._updateJoystick
                );
        }

        // ==========================================
        // 12. DETENER MOVIMIENTO
        // ==========================================

        stopJoystickMovement() {

            this.joystick.x = 0;
            this.joystick.y = 0;
            this.joystick.lastTime = null;

            if (this.joystick.raf !== null) {

                cancelAnimationFrame(
                    this.joystick.raf
                );

                this.joystick.raf = null;
            }
        }

        // ==========================================
        // 13. DESTRUIR JOYSTICK
        // ==========================================

        destroyJoystick() {

            this.disableJoystick();

            if (this.joystick.manager) {
                this.joystick.manager.destroy();

                this.joystick.manager = null;
            }

            this.joystick.zone?.remove();
            this.joystick.controls?.remove();

            this.joystick.zone = null;
            this.joystick.controls = null;
        }

        // ==========================================
        // 14. MOVER MODELO X/Y/Z
        // ==========================================

        moveModel(x = 0, y = 0, z = 0) {

            if (!this.modelRoot) return;

            this.modelRoot.position.x += x;
            this.modelRoot.position.y += y;
            this.modelRoot.position.z += z;

            this.emit('viewer:model:move', {
                id: this.modelId,
                position:
                    this.modelRoot.position.toArray(),
                dataTotem: this.dataTotem
            });
        }

        setModelPosition(x, y, z) {

            if (!this.modelRoot) return;

            this.modelRoot.position.set(
                x,
                y,
                z
            );

            this.emit('viewer:model:move', {
                id: this.modelId,
                position:
                    this.modelRoot.position.toArray()
            });
        }

        resetModelPosition() {

            if (!this.modelRoot) return;

            this.modelRoot.position.copy(
                this.initialModelPosition
            );

            this.modelRoot.rotation.set(0, 0, 0);
            this.modelRoot.scale.setScalar(1);

            this.emit('viewer:model:reset', {
                id: this.modelId,
                position:
                    this.modelRoot.position.toArray()
            });
        }

        // ==========================================
        // 15. ROTACIONES
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
                this.rotateModelDown(
                    Math.abs(degrees)
                );
            }
        }

        emitRotate(direction, degrees) {

            this.emit('viewer:model:rotate', {
                id: this.modelId,
                direction,
                degrees,
                rotation:
                    this.modelRoot.rotation
                        .toArray()
                        .slice(0, 3)
            });
        }

        // ==========================================
        // 16. ESCALA
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

            this.setScale(
                this.modelRoot.scale.x * factor
            );
        }

        // ==========================================
        // 17. EVENTOS TÁCTILES
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

            window.addEventListener(
                'resize',
                this._onResize
            );
        }

        getPointerCoordinates(event) {

            const rect =
                this.renderer.domElement
                    .getBoundingClientRect();

            this.pointer.x =
                ((event.clientX - rect.left) /
                    rect.width) * 2 - 1;

            this.pointer.y =
                -((event.clientY - rect.top) /
                    rect.height) * 2 + 1;

            return this.pointer;
        }

        hitTest(event) {

            if (!this.model || !this.camera) {
                return null;
            }

            this.getPointerCoordinates(event);

            this.raycaster.setFromCamera(
                this.pointer,
                this.camera
            );

            const intersections =
                this.raycaster.intersectObject(
                    this.model,
                    true
                );

            return intersections[0] || null;
        }

        onPointerDown(event) {

            if (!this.modelRoot) return;

            this._pointers.set(
                event.pointerId,
                {
                    x: event.clientX,
                    y: event.clientY
                }
            );

            this.renderer.domElement
                .setPointerCapture?.(
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
                    hit,
                    initialScale:
                    this.modelRoot.scale.x
                };
            }

            if (this._pointers.size === 2) {

                const points =
                    [...this._pointers.values()];

                this._gesture = {
                    type: 'pinch',

                    distance: Math.hypot(
                        points[0].x - points[1].x,
                        points[0].y - points[1].y
                    ),

                    initialScale:
                    this.modelRoot.scale.x
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

            if (
                !this.modelRoot ||
                !this._pointers.has(
                    event.pointerId
                )
            ) {
                return;
            }

            this._pointers.set(
                event.pointerId,
                {
                    x: event.clientX,
                    y: event.clientY
                }
            );

            // Zoom con dos dedos.
            if (this._pointers.size === 2) {

                const points =
                    [...this._pointers.values()];

                const distance = Math.hypot(
                    points[0].x - points[1].x,
                    points[0].y - points[1].y
                );

                if (
                    this._gesture?.type === 'pinch' &&
                    this._gesture.distance > 0
                ) {

                    const factor =
                        distance /
                        this._gesture.distance;

                    this.setScale(
                        this._gesture.initialScale *
                        factor
                    );
                }

                return;
            }

            if (
                !this._gesture ||
                !this._gesture.hit
            ) {
                return;
            }

            const dx =
                event.clientX -
                this._gesture.lastX;

            const dy =
                event.clientY -
                this._gesture.lastY;

            const totalDistance = Math.hypot(
                event.clientX -
                this._gesture.startX,

                event.clientY -
                this._gesture.startY
            );

            if (totalDistance > 5) {
                this._gesture.dragging = true;
            }

            if (this._gesture.dragging) {

                const rect =
                    this.renderer.domElement
                        .getBoundingClientRect();

                const distance =
                    this.camera.position
                        .distanceTo(
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
                    visibleHeight *
                    this.camera.aspect;

                this.moveModel(
                    dx / rect.width *
                    visibleWidth,

                    -dy / rect.height *
                    visibleHeight,

                    0
                );
            }

            this._gesture.lastX =
                event.clientX;

            this._gesture.lastY =
                event.clientY;
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
                        meshName:
                        hit.object.name,
                        point:
                            hit.point.toArray(),
                        position:
                            this.modelRoot.position
                                .toArray()
                    });

                } else {

                    this.emit('viewer:scene:click', {
                        id: this.modelId,
                        x: event.clientX,
                        y: event.clientY
                    });
                }
            }

            this._pointers.delete(
                event.pointerId
            );

            if (this._pointers.size === 0) {
                this._gesture = null;
            }
        }

        onWheel(event) {

            if (!this.modelRoot) return;

            event.preventDefault();

            this.scaleModel(
                event.deltaY > 0
                    ? 0.9
                    : 1.1
            );
        }

        // ==========================================
        // 18. CAPTURAR FOTOGRAFÍA
        // ==========================================

        async capturePhotoBlob() {

            if (!this.video || !this.renderer) {
                throw new Error(
                    'La cámara no está iniciada.'
                );
            }

            const width =
                this.renderer.domElement.width;

            const height =
                this.renderer.domElement.height;

            const canvas =
                document.createElement('canvas');

            canvas.width = width;
            canvas.height = height;

            const ctx =
                canvas.getContext('2d');

            const vw = this.video.videoWidth;
            const vh = this.video.videoHeight;

            if (!vw || !vh) {
                throw new Error(
                    'No existe un fotograma disponible.'
                );
            }

            const scale = Math.max(
                width / vw,
                height / vh
            );

            const sourceWidth =
                width / scale;

            const sourceHeight =
                height / scale;

            const sx =
                (vw - sourceWidth) / 2;

            const sy =
                (vh - sourceHeight) / 2;

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

            this.renderer.render(
                this.scene,
                this.camera
            );

            ctx.drawImage(
                this.renderer.domElement,
                0,
                0,
                width,
                height
            );

            return new Promise(
                (resolve, reject) => {

                    canvas.toBlob(
                        blob => blob
                            ? resolve(blob)
                            : reject(
                                new Error(
                                    'No se pudo generar PNG.'
                                )
                            ),
                        'image/png'
                    );
                }
            );
        }

        async savePhoto() {

            const blob =
                await this.capturePhotoBlob();

            const url =
                URL.createObjectURL(blob);

            const link =
                document.createElement('a');

            link.href = url;

            link.download =
                `maskana-${this.modelId || 'modelo'}-${Date.now()}.png`;

            document.body.appendChild(link);

            link.click();
            link.remove();

            setTimeout(
                () => URL.revokeObjectURL(url),
                30000
            );

            this.emit('viewer:photo:saved', {
                id: this.modelId,
                size: blob.size
            });

            return blob;
        }

        // ==========================================
        // 19. EMITIR EVENTOS
        // ==========================================

        emit(name, detail = {}) {

            window.dispatchEvent(
                new CustomEvent(
                    name,
                    { detail }
                )
            );
        }

        // ==========================================
        // 20. LIBERAR MODELO
        // ==========================================

        async disposeModel() {

            if (!this.model) return;

            this.scene?.remove(
                this.modelRoot
            );

            this.model.traverse(object => {

                if (!object.isMesh) return;

                object.geometry?.dispose();

                const materials =
                    Array.isArray(object.material)
                        ? object.material
                        : [object.material];

                materials.forEach(material => {

                    if (!material) return;

                    Object.keys(material).forEach(
                        key => {

                            const value =
                                material[key];

                            if (value?.isTexture) {
                                value.dispose();
                            }
                        }
                    );

                    material.dispose();
                });
            });

            this.mixer?.stopAllAction();

            this.mixer = null;
            this.model = null;
            this.modelRoot = null;
        }

        // ==========================================
        // 21. CERRAR TODO
        // ==========================================

        async stop() {

            this._running = false;

            if (this._raf !== null) {
                cancelAnimationFrame(
                    this._raf
                );

                this._raf = null;
            }

            // Destruir joystick integrado.
            this.destroyJoystick();

            window.removeEventListener(
                'resize',
                this._onResize
            );

            const canvas =
                this.renderer?.domElement;

            if (canvas) {

                canvas.removeEventListener(
                    'pointerdown',
                    this._onPointerDown
                );

                canvas.removeEventListener(
                    'pointermove',
                    this._onPointerMove
                );

                canvas.removeEventListener(
                    'pointerup',
                    this._onPointerUp
                );

                canvas.removeEventListener(
                    'pointercancel',
                    this._onPointerUp
                );

                canvas.removeEventListener(
                    'wheel',
                    this._onWheel
                );
            }

            await this.disposeModel();

            this.stream?.getTracks()
                .forEach(track => track.stop());

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

            this.container?.classList.remove(
                'camera-three-active'
            );

            this.hooks.onExit?.({
                reason: 'stop'
            });

            console.log(
                '[CameraThree] Recursos liberados'
            );
        }
    }
</script>
