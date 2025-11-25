<script>
    function initPreCache(params) {


        const MAP_CONFIG = Object.freeze({
            zoom: 14, maxZoom: 25,
            position: [0.20830, -78.22798],
            tileUrl: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            tileAttribution: '&copy; OpenStreetMap contrib.'
        });

        params.mapCtl.init(ItemsStore.getItems());

        const startWarm = async () => {
            try {
                await ItemsStore.warmAll({concurrency: 3});
                console.log('[preload] OK: blobs listos');
            } catch (e) {
                console.warn('[preload] fallo o cancelado', e);
            }
        };

        const warmWhenVisible = () => {
            if (document.visibilityState !== 'visible') {
                document.addEventListener('visibilitychange', function onVis() {
                    if (document.visibilityState === 'visible') {
                        document.removeEventListener('visibilitychange', onVis);
                        queueWarm();
                    }
                });
                return;
            }
            queueWarm();
        };

        const queueWarm = () => {
            if ('requestIdleCallback' in window) {
                requestIdleCallback(() => startWarm(), {timeout: 2000});
            } else {
                setTimeout(() => startWarm(), 300);
            }
        };

        warmWhenVisible();
    }
</script>
