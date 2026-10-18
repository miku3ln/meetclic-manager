<script>
    /** Camera + Three.js r147 + nipplejs. No positional AR tracking. */
    class CameraThreeController {
        constructor({ dataTotem = null, onEnter = null, onExit = null } = {}) {
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
            this._loadToken = 0;
            this._loadStart = 0;
            this._loading = false;
            this._progressEl = null;
            this._progressTimer = null;
            this._progress = { phase: 'idle', loaded: 0, total: 0 };
            this._initialPosition = new THREE.Vector3(0, -0.6, -2.5);
            this._trackingEnabled = false;
            this._hasOrientation = false;
            this._deviceQuaternion = new THREE.Quaternion();
            this._targetQuaternion = new THREE.Quaternion();
            this._referenceInverse = new THREE.Quaternion();
            this._initialQuaternion = null;
            this._zee = new THREE.Vector3(0, 0, 1);
            this._q0 = new THREE.Quaternion();
            this._q1 = new THREE.Quaternion(-Math.sqrt(0.5), 0, 0, Math.sqrt(0.5));
            this._sensorSamples = 0;
            this._sensorWaiter = null;
            this._sensorTimeout = null;
            this._onResize = this.resize.bind(this);
            this._onOrientation = this.onDeviceOrientation.bind(this);
            this._onOrientationChange = this.recenter.bind(this);
            this._onPointerDown = this.onPointerDown.bind(this);
            this._onPointerMove = this.onPointerMove.bind(this);
            this._onPointerUp = this.onPointerUp.bind(this);
            this._onWheel = this.onWheel.bind(this);
            this.joystick = { manager: null, zone: null, enabled: false, debug: false, x: 0, y: 0,
                deadZone: 0.18, rotationSpeed: 75, raf: null, lastTime: null };
            this._joystickFrame = this.updateJoystick.bind(this);
        }

        updateJoystick(timestamp) {

            // El frame actual ya está ejecutándose.
            this.joystick.raf = null;

            if (
                !this.joystick.enabled ||
                !this._running ||
                !this.modelRoot
            ) {
                this.stopJoystickMovement();
                return;
            }

            const x = this.joystick.x;
            const y = this.joystick.y;

            // Si no existe movimiento, detener.
            if (
                Math.abs(x) < 0.001 &&
                Math.abs(y) < 0.001
            ) {
                this.stopJoystickMovement();
                return;
            }

            // ============================================
            // 1. CALCULAR DELTA TIME
            // ============================================

            const previous = this.joystick.lastTime;

            this.joystick.lastTime = timestamp;

            const dt = previous == null
                ? 0
                : Math.min(
                    0.05,
                    Math.max(0, (timestamp - previous) / 1000)
                );

            // ============================================
            // 2. CALCULAR ROTACIONES
            // ============================================

            const speed = this.joystick.rotationSpeed;

            const yaw = x * speed * dt;
            const pitch = y * speed * dt;

            // ============================================
            // 3. EJE HORIZONTAL
            // ============================================

            // Conservamos tu orientación original:
            // DERECHA   -> rotateModelLeft()
            // IZQUIERDA -> rotateModelRight()

            if (yaw > 0) {

                this.rotateModelLeft(yaw);

            } else if (yaw < 0) {

                this.rotateModelRight(
                    Math.abs(yaw)
                );
            }

            // ============================================
            // 4. EJE VERTICAL
            // ============================================

            // ARRIBA -> rotateModelUp()
            // ABAJO  -> rotateModelDown()

            if (pitch > 0) {

                this.rotateModelUp(pitch);

            } else if (pitch < 0) {

                this.rotateModelDown(
                    Math.abs(pitch)
                );
            }

            // ============================================
            // 5. CONTINUAR MOVIMIENTO
            // ============================================

            this.joystick.raf = requestAnimationFrame(
                this._joystickFrame
            );
        }

        emit(name, detail = {}) {
            window.dispatchEvent(new CustomEvent(name, { detail }));
        }

        getSize() {
            return {
                width: Math.max(1, this.container?.clientWidth || window.innerWidth),
                height: Math.max(1, this.container?.clientHeight || window.innerHeight)
            };
        }

        async start() {
            if (this._running) return;
            if (!navigator.mediaDevices?.getUserMedia) throw new Error('Cámara no disponible. Utiliza HTTPS o localhost.');
            this.container = document.querySelector('.container--custom');
            if (!this.container) throw new Error('No existe .container--custom');
            // Solicitar orientación antes del primer await para conservar el gesto de usuario (iOS).
            // Si no hay permisos/sensores, la cámara 3D seguirá funcionando sin seguimiento.
            const orientationRequest = this.enableOrientation().catch(error => {
                console.warn('[CameraThree] Orientación no autorizada:', error);
                return false;
            });
            try {
                this.container.classList.add('camera-three-active');
                if (getComputedStyle(this.container).position === 'static') this.container.style.position = 'relative';
                this.stream = await navigator.mediaDevices.getUserMedia({
                    audio: false, video: { facingMode: { ideal: 'environment' }, width: { ideal: 1280 }, height: { ideal: 720 } }
                });
                this.createVideo();
                await this.waitForVideo();
                this.createThreeScene();
                this.bindEvents();
                this.createJoystick();
                this.createProgressUI();
                this.createCaptureButton();
                const orientationEnabled = await orientationRequest;
                if (!orientationEnabled) {
                    this.emit('viewer:tracking:unavailable', { reason: 'permission-or-sensor' });
                    console.warn('[CameraThree] Sin orientación: el GLB no reaccionará a giros del teléfono.');
                } else {
                    setTimeout(() => {
                        if (this._running && !this._hasOrientation) {
                            this.emit('viewer:tracking:unavailable', { reason: 'no-sensor-events' });
                            console.warn('[CameraThree] No llegaron datos de deviceorientation.');
                        }
                    }, 2500);
                }
                this._running = true;
                this.clock.start();
                this.animate();
                this.hooks.onEnter?.({ mode: 'camera-three' });
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
                position: 'absolute', inset: '0', width: '100%', height: '100%',
                objectFit: 'cover', zIndex: '1', pointerEvents: 'none'
            });
            this.container.appendChild(this.video);
        }

        async waitForVideo() {
            await this.video.play();
            if (this.video.videoWidth && this.video.videoHeight) return;
            await new Promise((resolve, reject) => {
                const cleanup = () => {
                    clearTimeout(timeout);
                    this.video.removeEventListener('loadedmetadata', loaded);
                    this.video.removeEventListener('error', failed);
                };
                const loaded = () => { if (this.video.videoWidth) { cleanup(); resolve(); } };
                const failed = () => { cleanup(); reject(new Error('Error reproduciendo la cámara.')); };
                const timeout = setTimeout(() => { cleanup(); reject(new Error('La cámara no entregó video.')); }, 10000);
                this.video.addEventListener('loadedmetadata', loaded);
                this.video.addEventListener('error', failed);
            });
        }

        createThreeScene() {
            const { width, height } = this.getSize();
            this.scene = new THREE.Scene();
            this.camera = new THREE.PerspectiveCamera(55, width / height, 0.01, 1000);
            this.camera.position.set(0, 0, 0);
            this.camera.quaternion.identity();
            this.renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true, preserveDrawingBuffer: true });
            this.renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
            this.renderer.setSize(width, height);
            this.renderer.setClearColor(0x000000, 0);
            this.renderer.outputEncoding = THREE.sRGBEncoding;
            const canvas = this.renderer.domElement;
            canvas.id = 'camera-three-canvas';
            Object.assign(canvas.style, {
                position: 'absolute', inset: '0', width: '100%', height: '100%',
                zIndex: '2', touchAction: 'none'
            });
            this.container.appendChild(canvas);
            this.scene.add(new THREE.HemisphereLight(0xffffff, 0x666666, 2));
            const light = new THREE.DirectionalLight(0xffffff, 1.5);
            light.position.set(2, 4, 3);
            this.scene.add(light);
        }

        createProgressUI() {
            const el = document.createElement('div');
            el.id = 'camera-three-progress';
            Object.assign(el.style, {
                position: 'absolute', left: '50%', top: '15%', transform: 'translateX(-50%)',
                width: 'min(88vw, 340px)', padding: '12px 14px', borderRadius: '12px',
                background: 'rgba(15,20,35,.88)', color: 'white', font: '13px system-ui,sans-serif',
                zIndex: '45', pointerEvents: 'none', display: 'none', textAlign: 'center'
            });
            el.innerHTML = '<div data-label>Cargando personaje…</div><div style="height:7px;background:#566078;border-radius:6px;margin:9px 0;overflow:hidden"><div data-bar style="height:100%;width:0;background:#4C4CFF;transition:width .15s"></div></div><div data-info>0 s</div>';
            this.container.appendChild(el);
            this._progressEl = el;
        }

        updateProgress(phase, loaded = 0, total = 0) {
            this._progress = { phase, loaded, total };
            const el = this._progressEl;
            if (!el) return;
            const seconds = ((performance.now() - this._loadStart) / 1000).toFixed(1);
            const label = el.querySelector('[data-label]');
            const bar = el.querySelector('[data-bar]');
            const info = el.querySelector('[data-info]');
            if (phase === 'download') {
                const mb = bytes => (bytes / 1048576).toFixed(2);
                const percent = total > 0 ? Math.min(100, Math.round(loaded / total * 100)) : null;
                label.textContent = percent === null ? 'Descargando GLB…' : `Descargando GLB: ${percent}%`;
                bar.style.width = percent === null ? '100%' : `${percent}%`;
                bar.style.opacity = percent === null ? '.3' : '1';
                info.textContent = `${mb(loaded)} MB${total > 0 ? ' / ' + mb(total) + ' MB' : ' (tamaño total desconocido)'} · ${seconds} s`;
            } else {
                label.textContent = phase === 'processing' ? 'Procesando geometría, texturas y animaciones…' : 'Preparando personaje…';
                bar.style.width = '100%';
                bar.style.opacity = '.35';
                info.textContent = `${seconds} s transcurridos`;
            }
            this.emit('viewer:model:progress', { id: this.modelId, phase, loaded, total, seconds: Number(seconds), percent: total > 0 && phase === 'download' ? Math.round(loaded / total * 100) : null });
        }

        async loadModel(glbUrl, id = null) {
            if (!this.scene) throw new Error('Primero inicia la cámara.');
            this.disableJoystick();
            await this.disposeModel();
            const token = ++this._loadToken;
            this.modelId = id;
            this.modelUrl = glbUrl;
            this._loadStart = performance.now();
            this._loading = true;
            if (this._progressEl) this._progressEl.style.display = 'block';
            this.updateProgress('download', 0, 0);
            this._progressTimer = setInterval(() => {
                if (this._loading) this.updateProgress(this._progress.phase, this._progress.loaded, this._progress.total);
            }, 100);
            try {
                const cached = typeof AssetPreloader !== 'undefined' ? AssetPreloader.getBlobURL(glbUrl) : null;
                const url = cached || glbUrl;
                const gltf = await new Promise((resolve, reject) => {
                    new THREE.GLTFLoader().load(url, resolve, event => {
                        if (token !== this._loadToken) return;
                        this.updateProgress('download', event.loaded || 0, event.total || 0);
                    }, reject);
                });
                if (token !== this._loadToken || !this.scene) {
                    gltf.scene.traverse(object => { if (object.geometry) object.geometry.dispose(); });
                    return;
                }
                this.updateProgress('processing', this._progress.loaded, this._progress.total);
                this.model = gltf.scene;
                this.modelRoot = new THREE.Group();
                this.modelRoot.name = 'CameraThreeModelRoot';
                const box = new THREE.Box3().setFromObject(this.model);
                const size = new THREE.Vector3();
                const center = new THREE.Vector3();
                box.getSize(size);
                box.getCenter(center);
                const scale = 1 / Math.max(size.x, size.y, size.z, 0.0001);
                this.model.scale.setScalar(scale);
                this.model.position.set(-center.x * scale, -box.min.y * scale, -center.z * scale);
                this.modelRoot.add(this.model);
                this.modelRoot.position.copy(this._initialPosition);
                this.scene.add(this.modelRoot);
                if (gltf.animations?.length) {
                    this.mixer = new THREE.AnimationMixer(this.model);
                    gltf.animations.forEach(clip => this.mixer.clipAction(clip).play());
                }
                this.enableJoystick();
                this.emit('viewer:model:loaded', { id, glbUrl, dataTotem: this.dataTotem, position: this.modelRoot.position.toArray(), seconds: (performance.now() - this._loadStart) / 1000 });
            } finally {
                this._loading = false;
                clearInterval(this._progressTimer);
                this._progressTimer = null;
                if (this._progressEl) this._progressEl.style.display = 'none';
            }
        }

        animate() {
            if (!this._running) return;
            this._raf = requestAnimationFrame(() => this.animate());
            const dt = this.clock.getDelta();
            this.mixer?.update(dt);
            if (this._trackingEnabled && this._hasOrientation) {
                this.camera.quaternion.slerp(this._targetQuaternion, Math.min(1, dt * 12));
            }
            this.renderer.render(this.scene, this.camera);
        }

        resize() {
            if (!this.camera || !this.renderer) return;
            const { width, height } = this.getSize();
            this.camera.aspect = width / height;
            this.camera.updateProjectionMatrix();
            this.renderer.setSize(width, height);
            this.recenter();
        }

        /** Must be invoked from a user gesture on iOS when permission is required. */
        async enableOrientation() {
            if (typeof DeviceOrientationEvent === 'undefined') return false;
            if (typeof DeviceOrientationEvent.requestPermission === 'function') {
                const permission = await DeviceOrientationEvent.requestPermission();
                if (permission !== 'granted') return false;
            }
            this.disableOrientation();
            this._trackingEnabled = true;
            this._hasOrientation = false;
            this._sensorSamples = 0;
            this._initialQuaternion = null;
            window.addEventListener('deviceorientation', this._onOrientation, true);
            window.addEventListener('orientationchange', this._onOrientationChange);
            this.emit('viewer:tracking:enabled', { id: this.modelId });
            return true;
        }

        onDeviceOrientation(event) {
            if (!this._trackingEnabled || event.alpha == null || event.beta == null || event.gamma == null) return;
            const alpha = THREE.MathUtils.degToRad(event.alpha);
            const beta = THREE.MathUtils.degToRad(event.beta);
            const gamma = THREE.MathUtils.degToRad(event.gamma);
            const angle = THREE.MathUtils.degToRad(screen.orientation?.angle ?? window.orientation ?? 0);
            this._deviceQuaternion.setFromEuler(new THREE.Euler(beta, alpha, -gamma, 'YXZ'));
            this._deviceQuaternion.multiply(this._q1);
            this._deviceQuaternion.multiply(this._q0.setFromAxisAngle(this._zee, -angle));
            if (!this._initialQuaternion) {
                this._initialQuaternion = this._deviceQuaternion.clone();
                this._referenceInverse.copy(this._initialQuaternion).invert();
                this._targetQuaternion.identity();
                this.camera?.quaternion.identity();
            }
            this._targetQuaternion.copy(this._referenceInverse).multiply(this._deviceQuaternion).normalize();
            this._hasOrientation = true;
            this._sensorSamples++;
            if (this._sensorWaiter) {
                this._sensorWaiter(true);
                this._sensorWaiter = null;
            }
        }

        recenter() {
            this._initialQuaternion = null;
            this._hasOrientation = false;
            this._targetQuaternion.identity();
            this.camera?.quaternion.identity();
            this.emit('viewer:tracking:recenter', { id: this.modelId });
        }

        disableOrientation() {
            this._trackingEnabled = false;
            this._hasOrientation = false;
            window.removeEventListener('deviceorientation', this._onOrientation, true);
            window.removeEventListener('orientationchange', this._onOrientationChange);
            if (this._sensorWaiter) { this._sensorWaiter(false); this._sensorWaiter = null; }
        }

        // Joystick existente en el HTML: #joystick-zone.
        // Nunca creamos ni eliminamos el div: solo administramos nipplejs y clases.
        createJoystick() {
            if (typeof nipplejs === 'undefined') {
                throw new Error('Falta cargar nipplejs antes de CameraThreeController.');
            }

            const zone = document.getElementById('joystick-zone-camera');
            if (!zone) {
                throw new Error('No existe el div #joystick-zone en el HTML.');
            }

            this.destroyJoystick();
            this.joystick.zone = zone;
            this.joystick.x = 0;
            this.joystick.y = 0;
            this.joystick.lastTime = null;

            // El div es del usuario: no se crea ni se mueve de contenedor.
            zone.classList.remove('joystick--enabled');
            zone.classList.add('joystick--disabled');

            // Evitar que el canvas o los gestos del navegador intercepten el joystick.
            Object.assign(zone.style, {
                touchAction: 'none',
                pointerEvents: 'none',
                userSelect: 'none',
                WebkitUserSelect: 'none',
                position: getComputedStyle(zone).position === 'static'
                    ? 'relative'
                    : getComputedStyle(zone).position,
                zIndex: '1000'
            });

            const manager = nipplejs.create({
                zone,
                mode: 'static',
                position: { left: '50%', top: '50%' },
                size: 120,
                color: '#4C4CFF',
                restOpacity: 0.8,
                lockX: false,
                lockY: false,
                multitouch: false,
                maxNumberOfNipples: 1
            });

            this.joystick.manager = manager;

            manager.on('start', () => {
                if (!this.joystick.enabled || !this.modelRoot) return;
                this.stopJoystickMovement();
            });

            manager.on('move', (_event, data) => {
                if (!this.joystick.enabled || !this._running || !this.modelRoot) return;
                if (!data?.vector) return;

                // force puede ser mayor que 1. Se limita la intensidad, NO la dirección.
                const force = Math.min(1, Math.max(0, Number(data.force) || 0));
                const deadZone = this.joystick.deadZone;
                if (force <= deadZone) {
                    this.stopJoystickMovement();
                    return;
                }

                const intensity = (force - deadZone) / (1 - deadZone);
                const x = Number(data.vector.x) || 0;
                const y = Number(data.vector.y) || 0;

                // Ambos ejes actúan simultáneamente: las diagonales funcionan.
                this.joystick.x = THREE.MathUtils.clamp(x, -1, 1) * intensity;
                this.joystick.y = THREE.MathUtils.clamp(y, -1, 1) * intensity;

                if (this.joystick.raf === null) {
                    this.joystick.lastTime = null;
                    this.joystick.raf = requestAnimationFrame(this._joystickFrame);
                }

                if (this.joystick.debug) {
                    console.debug('[CameraThree] joystick', {
                        angle: data.angle?.degree,
                        force,
                        x: this.joystick.x,
                        y: this.joystick.y
                    });
                }
            });

            manager.on('end', () => this.stopJoystickMovement());

            console.log('[CameraThree] nipplejs conectado a #joystick-zone');
        }

        enableJoystick() {
            const zone = this.joystick.zone;
            if (!zone || !this.joystick.manager) return;

            this.joystick.enabled = true;
            zone.classList.remove('joystick--disabled');
            zone.classList.add('joystick--enabled');
            zone.style.pointerEvents = 'auto';
        }

        disableJoystick() {
            this.joystick.enabled = false;
            this.stopJoystickMovement();

            const zone = this.joystick.zone;
            if (!zone) return;
            zone.classList.remove('joystick--enabled');
            zone.classList.add('joystick--disabled');
            zone.style.pointerEvents = 'none';
        }

        destroyJoystick() {
            this.disableJoystick();
            this.joystick.manager?.destroy();
            this.joystick.manager = null;
            // No eliminar #joystick-zone: es un elemento preexistente del HTML.
            this.joystick.zone = null;
        }

        bindEvents() {
            const canvas = this.renderer.domElement;
            canvas.addEventListener('pointerdown', this._onPointerDown);
            canvas.addEventListener('pointermove', this._onPointerMove);
            canvas.addEventListener('pointerup', this._onPointerUp);
            canvas.addEventListener('pointercancel', this._onPointerUp);
            canvas.addEventListener('wheel', this._onWheel, { passive: false });
            window.addEventListener('resize', this._onResize);
        }

        getPointerCoordinates(event) {
            const rect = this.renderer.domElement.getBoundingClientRect();
            this.pointer.set(
                (event.clientX - rect.left) / rect.width * 2 - 1,
                -(event.clientY - rect.top) / rect.height * 2 + 1
            );
            return this.pointer;
        }

        hitTest(event) {
            if (!this.model || !this.camera) return null;
            this.raycaster.setFromCamera(this.getPointerCoordinates(event), this.camera);
            return this.raycaster.intersectObject(this.model, true)[0] || null;
        }

        onPointerDown(event) {
            if (!this.modelRoot) return;
            this._pointers.set(event.pointerId, { x: event.clientX, y: event.clientY });
            try { this.renderer.domElement.setPointerCapture(event.pointerId); } catch (_) {}
            if (this._pointers.size === 1) {
                this._gesture = {
                    type: 'drag', hit: this.hitTest(event),
                    startX: event.clientX, startY: event.clientY,
                    lastX: event.clientX, lastY: event.clientY, dragging: false
                };
            } else if (this._pointers.size === 2) {
                const [a, b] = [...this._pointers.values()];
                this._gesture = {
                    type: 'pinch',
                    distance: Math.hypot(a.x - b.x, a.y - b.y),
                    initialZ: this.modelRoot.position.z
                };
            }
        }

        onPointerMove(event) {
            if (!this.modelRoot || !this._pointers.has(event.pointerId)) return;
            this._pointers.set(event.pointerId, { x: event.clientX, y: event.clientY });
            if (this._pointers.size === 2 && this._gesture?.type === 'pinch') {
                const [a, b] = [...this._pointers.values()];
                const distance = Math.hypot(a.x - b.x, a.y - b.y);
                // Pinch out -> move model closer (less negative z).
                const z = this._gesture.initialZ + (distance - this._gesture.distance) * 0.012;
                this.modelRoot.position.z = THREE.MathUtils.clamp(z, -30, -0.35);
                this.emitMove();
                return;
            }
            if (this._pointers.size !== 1 || this._gesture?.type !== 'drag') return;
            const gesture = this._gesture;
            const dx = event.clientX - gesture.lastX;
            const dy = event.clientY - gesture.lastY;
            if (Math.hypot(event.clientX - gesture.startX, event.clientY - gesture.startY) > 5) gesture.dragging = true;
            if (gesture.dragging && gesture.hit) {
                const rect = this.renderer.domElement.getBoundingClientRect();
                const distance = Math.max(0.35, this.modelRoot.position.distanceTo(this.camera.position));
                const visibleHeight = 2 * Math.tan(THREE.MathUtils.degToRad(this.camera.fov / 2)) * distance;
                const right = new THREE.Vector3(1, 0, 0).applyQuaternion(this.camera.quaternion);
                const up = new THREE.Vector3(0, 1, 0).applyQuaternion(this.camera.quaternion);
                this.modelRoot.position.addScaledVector(right, dx / rect.width * visibleHeight * this.camera.aspect);
                this.modelRoot.position.addScaledVector(up, -dy / rect.height * visibleHeight);
                this.emitMove();
            }
            gesture.lastX = event.clientX;
            gesture.lastY = event.clientY;
        }

        onPointerUp(event) {
            const gesture = this._gesture;
            if (this._pointers.size === 1 && gesture?.type === 'drag' && !gesture.dragging) {
                const hit = this.hitTest(event);
                if (hit) this.emit('viewer:model:click', {
                    id: this.modelId, dataTotem: this.dataTotem,
                    meshName: hit.object.name, point: hit.point.toArray(),
                    position: this.modelRoot.position.toArray()
                });
            }
            this._pointers.delete(event.pointerId);
            if (this._pointers.size === 0) this._gesture = null;
            else this._gesture = { type: 'resume' };
        }

        onWheel(event) {
            if (!this.modelRoot) return;
            event.preventDefault();
            this.modelRoot.position.z = THREE.MathUtils.clamp(
                this.modelRoot.position.z + (event.deltaY < 0 ? 0.2 : -0.2), -30, -0.35
            );
            this.emitMove();
        }

        emitMove() {
            if (!this.modelRoot) return;
            this.emit('viewer:model:move', { id: this.modelId, position: this.modelRoot.position.toArray(), dataTotem: this.dataTotem });
        }

        moveModel(x = 0, y = 0, z = 0) {
            if (!this.modelRoot) return;
            this.modelRoot.position.add(new THREE.Vector3(x, y, z));
            this.emitMove();
        }

        setModelPosition(x, y, z) {
            if (!this.modelRoot) return;
            this.modelRoot.position.set(x, y, z);
            this.emitMove();
        }

        rotateModelLeft(degrees = 1) {
            if (!this.modelRoot) return;

            this.modelRoot.rotation.y +=
                THREE.MathUtils.degToRad(degrees);
        }

        rotateModelRight(degrees = 1) {
            if (!this.modelRoot) return;

            this.modelRoot.rotation.y -=
                THREE.MathUtils.degToRad(degrees);
        }

        rotateModelUp(degrees = 1) {
            if (!this.modelRoot) return;

            this.modelRoot.rotation.x +=
                THREE.MathUtils.degToRad(degrees);
        }

        rotateModelDown(degrees = 1) {
            if (!this.modelRoot) return;

            this.modelRoot.rotation.x -=
                THREE.MathUtils.degToRad(degrees);
        }

        stopJoystickMovement() {//w

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
        rotateModel(axis, degrees, direction) {
            if (!this.modelRoot) return;
            this.modelRoot.rotation[axis] += THREE.MathUtils.degToRad(degrees);
            this.emit('viewer:model:rotate', {
                id: this.modelId, direction, degrees,
                rotation: this.modelRoot.rotation.toArray().slice(0, 3)
            });
        }

        setScale(value) {
            if (!this.modelRoot) return;
            const scale = THREE.MathUtils.clamp(value, 0.1, 8);
            this.modelRoot.scale.setScalar(scale);
            this.emit('viewer:model:scale', { id: this.modelId, scale });
        }
        scaleModel(factor = 1.1) {
            if (this.modelRoot) this.setScale(this.modelRoot.scale.x * factor);
        }

        async capturePhotoBlob() {
            if (!this.video || !this.renderer) throw new Error('La cámara no está iniciada.');
            const width = this.renderer.domElement.width;
            const height = this.renderer.domElement.height;
            const canvas = document.createElement('canvas');
            canvas.width = width;
            canvas.height = height;
            const ctx = canvas.getContext('2d');
            const vw = this.video.videoWidth;
            const vh = this.video.videoHeight;
            if (!vw || !vh) throw new Error('No existe fotograma de cámara.');
            const scale = Math.max(width / vw, height / vh);
            const sw = width / scale, sh = height / scale;
            ctx.drawImage(this.video, (vw - sw) / 2, (vh - sh) / 2, sw, sh, 0, 0, width, height);
            this.renderer.render(this.scene, this.camera);
            ctx.drawImage(this.renderer.domElement, 0, 0, width, height);
            return new Promise((resolve, reject) => canvas.toBlob(blob => blob ? resolve(blob) : reject(new Error('No se pudo generar PNG.')), 'image/png'));
        }


        createCaptureButton() {

            // ============================================
            // 1. ELIMINAR BOTÓN ANTERIOR SI EXISTE
            // ============================================

            const existingButton = document.getElementById(
                'camera-three-capture'
            );

            if (existingButton) {
                existingButton.remove();
            }

            this.captureButton = null;

            if (!this.container) return;

            // ============================================
            // 2. CREAR BOTÓN
            // ============================================

            const button = document.createElement('button');

            button.id = 'camera-three-capture';
            button.type = 'button';
            button.innerHTML = '<i class="bi bi-camera-fill"></i> Capturar foto';

            Object.assign(button.style, {
                position: 'absolute',
                bottom: '30px',
                left: '50%',
                transform: 'translateX(-50%)',
                zIndex: '1100',
                padding: '14px 24px',
                border: 'none',
                borderRadius: '50px',
                background: '#435cf0',
                color: '#fff',
                fontSize: '15px',
                fontWeight: '600',
                cursor: 'pointer',
                touchAction: 'manipulation',
                display: this.modelRoot && !this._loading ? 'block' : 'none'
            });

            // ============================================
            // 3. EVENTO CLICK
            // ============================================

            button.addEventListener('click', async (event) => {
                event.preventDefault();
                event.stopPropagation();

                if (
                    !this.modelRoot ||
                    this._loading ||
                    button.disabled
                ) {
                    return;
                }

                button.disabled = true;

                try {
                    await this.savePhoto();

                } catch (error) {
                    console.error(
                        '[CameraThree] Error al capturar:',
                        error
                    );

                    this.emit('viewer:photo:error', {
                        id: this.modelId,
                        message: error.message
                    });

                } finally {
                    button.disabled = false;
                }
            });

            // ============================================
            // 4. AGREGAR AL CONTENEDOR
            // ============================================

            this.container.appendChild(button);

            this.captureButton = button;
        }

        async savePhoto() {
            if (!this.video || !this.renderer || !this.modelRoot) {
                throw new Error('La cámara o el modelo 3D no están disponibles.');
            }

            const blob = await this.capturePhotoBlob();

            const filename = `maskana-${this.modelId || 'modelo'}-${Date.now()}.png`;

            const file = new File([blob], filename, {
                type: 'image/png'
            });

            // En dispositivos compatibles, permitir guardar o compartir
            // la fotografía mediante el sistema del celular.
            if (
                navigator.share &&
                navigator.canShare?.({ files: [file] })
            ) {
                try {
                    await navigator.share({
                        files: [file],
                        title: 'Fotografía Maskana'
                    });

                    this.emit('viewer:photo:saved', {
                        id: this.modelId,
                        filename,
                        size: blob.size,
                        method: 'share'
                    });

                    return blob;

                } catch (error) {
                    if (error.name === 'AbortError') {
                        return blob;
                    }

                    console.warn(
                        '[CameraThree] No se pudo compartir:',
                        error
                    );
                }
            }

            // Descarga tradicional
            const url = URL.createObjectURL(blob);

            const link = document.createElement('a');

            link.href = url;
            link.download = filename;
            link.style.display = 'none';

            document.body.appendChild(link);

            link.click();
            link.remove();

            setTimeout(() => {
                URL.revokeObjectURL(url);
            }, 30000);

            this.emit('viewer:photo:saved', {
                id: this.modelId,
                filename,
                size: blob.size,
                method: 'download'
            });

            return blob;
        }


        async disposeModel() {
            this.mixer?.stopAllAction();
            this.mixer = null;
            if (!this.model) return;
            this.scene?.remove(this.modelRoot);
            this.model.traverse(object => {
                if (!object.isMesh) return;
                object.geometry?.dispose();
                const materials = Array.isArray(object.material) ? object.material : [object.material];
                materials.forEach(material => {
                    if (!material) return;
                    Object.values(material).forEach(value => { if (value?.isTexture) value.dispose(); });
                    material.dispose();
                });
            });
            this.model = null;
            this.modelRoot = null;
        }

        async stop() {
            this._running = false;
            ++this._loadToken;
            if (this._raf !== null) cancelAnimationFrame(this._raf);
            this._raf = null;
            this.disableOrientation();
            this.destroyJoystick();
            clearInterval(this._progressTimer);
            this._progressTimer = null;
            this._progressEl?.remove();
            this._progressEl = null;
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
            if (this.video) { this.video.srcObject = null; this.video.remove(); }
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
        }
    }
</script>
