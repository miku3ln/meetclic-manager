<script>

    class CameraOverlayComposer {
        constructor() {
            this.video = null;
            this.stream = null;
            this.canvas3D = null;
            this.composite = null;
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

            this.stream = await navigator.mediaDevices.getUserMedia({
                video: {facingMode, width, height},
                audio: false
            });

            this.video = document.createElement('video');
            this.video.playsInline = true;
            this.video.muted = true;
            this.video.autoplay = true;
            this.video.srcObject = this.stream;

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

            await new Promise((res, rej) => {
                const onMeta = () => {
                    cleanup();
                    res();
                };
                const onErr = (e) => {
                    cleanup();
                    rej(e);
                };
                const cleanup = () => {
                    this.video.removeEventListener('loadedmetadata', onMeta);
                    this.video.removeEventListener('error', onErr);
                };
                this.video.addEventListener('loadedmetadata', onMeta, {once: true});
                this.video.addEventListener('error', onErr, {once: true});
            });

            try {
                await this.video.play();
            } catch {
            }

            await new Promise((res) => {
                if (this.video.videoWidth > 0 && this.video.videoHeight > 0) return res();
                const onPlaying = () => {
                    cleanup();
                    res();
                };
                const onLoadedData = () => {
                    if (this.video.videoWidth > 0 && this.video.videoHeight > 0) {
                        cleanup();
                        res();
                    }
                };
                const cleanup = () => {
                    this.video.removeEventListener('playing', onPlaying);
                    this.video.removeEventListener('loadeddata', onLoadedData);
                };
                this.video.addEventListener('playing', onPlaying, {once: true});
                this.video.addEventListener('loadeddata', onLoadedData);
                setTimeout(() => {
                    cleanup();
                    res();
                }, 500);
            });

            this.composite = document.createElement('canvas');
            this._resizeToVideo();
            this.ctx = this.composite.getContext('2d');
            this.composite.style.display = 'none';
            document.body.appendChild(this.composite);

            this._running = true;
            const tick = () => {
                if (!this._running) return;

                if (this.composite.width !== this.video.videoWidth ||
                    this.composite.height !== this.video.videoHeight) {
                    this._resizeToVideo();
                }

                this.ctx.drawImage(this.video, 0, 0, this.composite.width, this.composite.height);

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

        async snapshotToBlob({type = 'image/jpeg', quality = 0.95} = {}) {
            if (!this.composite) return null;

            if (!this.video || this.video.videoWidth === 0 || this.video.videoHeight === 0) {
                await new Promise(r => requestAnimationFrame(r));
                await new Promise(r => requestAnimationFrame(r));
                if (!this.video || this.video.videoWidth === 0 || this.video.videoHeight === 0) {
                    console.warn('[CameraOverlayComposer] video sin medidas aún');
                    return null;
                }
                this._resizeToVideo();
            }

            await new Promise(r => requestAnimationFrame(r));

            return await new Promise(res => this.composite.toBlob(res, type, quality));
        }

        async stop() {
            this._running = false;
            cancelAnimationFrame(this._raf);
            this._raf = 0;

            try {
                this.stream?.getTracks()?.forEach(t => t.stop());
            } catch {
            }
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
</script>
