<script>
    const UI = (function () {
        let $refs = {};
        const pctText = p => (Math.max(0, Math.min(1, p || 0)) * 100).toFixed(0) + '%';

        function bind() {
            $refs.loading = document.getElementById('ar-loading');
            $refs.loadingPct = document.getElementById('ar-loading-percent');
            $refs.loadingLbl = document.getElementById('ar-loading-label');
            $refs.fallback = document.getElementById('fallback');
            $refs.mv = document.getElementById('mv');
            $refs.hint = document.getElementById('hint');
            $refs.container = document.querySelector('.container--custom');
            $refs.reticle = document.getElementById('reticle-overlay');
            $refs.retHint = $refs.reticle?.querySelector('.reticle__hint');
            $refs.map = document.getElementById('map');
            $refs.back = document.getElementById('btn-back-map');
            $refs.capture = document.getElementById('btn-capture');
            $refs.upDown = document.getElementById('btn-up-down');
            $refs.rightLeft = document.getElementById('btn-right-left');


        }

        const show = el => el && el.classList.remove('d-none');
        const hide = el => el && el.classList.add('d-none');

        return {
            bind,
            setHint(m) {
                if ($refs.hint) $refs.hint.textContent = m || '';
            },
            setReticleText(m) {
                if ($refs.retHint) $refs.retHint.textContent = m || '';
            },

            showLoading(label = 'Cargando:') {
                if ($refs.loadingLbl) $refs.loadingLbl.textContent = label;
                if ($refs.loadingPct) $refs.loadingPct.textContent = '0%';
                show($refs.loading);
            },
            hideLoading(type = -1) {
                hide($refs.loading);
                console.log(type);
                if (type == 420) {

                    UI.showCapture(type);
                }
            },
            resetLoadingProgress(label = 'Cargando:') {
                if ($refs.loadingLbl) $refs.loadingLbl.textContent = label;
                if ($refs.loadingPct) $refs.loadingPct.textContent = '0%';
            },
            updateLoadingProgress(p) {
                const t = pctText(p);
                if ($refs.loadingPct) $refs.loadingPct.textContent = t;
                if ($refs.loadingLbl) $refs.loadingLbl.textContent = `Cargando modelo:`;
            },
            finishLoadingProgress() {
                if ($refs.loadingPct) $refs.loadingPct.textContent = '100%';
                if ($refs.loadingLbl) $refs.loadingLbl.textContent = 'Modelo cargado.';
            },

            showFallback() {
                show($refs.fallback);
            },
            hideFallback() {
                hide($refs.fallback);
            },

            revealContainer() {
                $refs.container?.classList.remove('not-view');
            },
            showReticle() {
                $refs.reticle?.classList.remove('hidden');
            },
            hideReticle() {
                $refs.reticle?.classList.add('hidden');
            },

            hideMap() {
                $refs.map?.classList.add('not-view');
                $refs.back?.classList.remove('d-none');
            },
            showMap() {
                $refs.map?.classList.remove('not-view');
                $refs.back?.classList.add('d-none');
            },

            showCapture(type) {
                console.log("showCapture type",type)
                $refs.capture?.classList.remove('d-none');
                if (type == 420) {
                    window.enableJoystick();

                }
            },
            hideCapture() {
                $refs.capture?.classList.add('d-none');

            },

            get mv() {
                return $refs.mv;
            },
            get $fallback() {
                return $refs.fallback;
            },
            get $reticle() {
                return $refs.reticle;
            },
            get $back() {
                return $refs.back;
            },
            get $capture() {
                return $refs.capture;
            },
            get $upDown() {
                return $refs.upDown;
            },
            get $rightLeft() {
                return $refs.rightLeft;
            },


        };
    })();

</script>
