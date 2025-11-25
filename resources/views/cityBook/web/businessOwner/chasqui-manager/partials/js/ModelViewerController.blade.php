<script>
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
                UI.hideLoading(420);
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
            UI.showLoading('Cargando modelo…');
            UI.resetLoadingProgress();

            const resolved = AssetPreloader.getBlobURL(glbUrl) || glbUrl || '';
            this.mv.src = resolved;

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
</script>
