<script>
    const ItemsStore = (function () {
        let _items = [];

        function _withCacheShape(item) {
            return {
                ...item,
                dataCache: {
                    glbBlobUrl: item?.dataCache?.glbBlobUrl || null,
                    lastWarmAt: item?.dataCache?.lastWarmAt || null,
                    bytes: item?.dataCache?.bytes || null,
                }
            };
        }

        function setItems(list) {
            _items = Array.isArray(list) ? list.map(_withCacheShape) : [];
        }

        function getItems() {
            return _items.map(i => ({...i, dataCache: {...i.dataCache}}));
        }

        function getItemById(id) {
            return _items.find(i => i.id == id) || null;
        }

        function updateItem(id, patch) {
            const idx = _items.findIndex(i => i.id === id);
            if (idx === -1) return false;
            const current = _items[idx];
            const next = _withCacheShape({...current, ...patch});
            if (!patch?.dataCache?.glbBlobUrl && current.dataCache?.glbBlobUrl) {
                next.dataCache.glbBlobUrl = current.dataCache.glbBlobUrl;
            }
            _items[idx] = next;
            return true;
        }

        function replaceAll(newItems) {
            setItems(newItems);
            return getItems();
        }

        function markCache(id, {glbBlobUrl, bytes} = {}) {
            const it = getItemById(id);
            if (!it) return false;
            it.dataCache.glbBlobUrl = glbBlobUrl ?? it.dataCache.glbBlobUrl ?? null;
            it.dataCache.lastWarmAt = new Date().toISOString();
            if (typeof bytes === 'number') it.dataCache.bytes = bytes;
            return true;
        }

        function getBestGlbUrl(id) {
            const it = getItemById(id);
            if (!it) return null;
            return it.dataCache?.glbBlobUrl || it.sources?.glb || null;
        }

        async function warmById(id) {
            const it = getItemById(id);
            if (!it?.sources?.glb) return false;
            try {
                await AssetPreloader.warm(it.sources.glb);
                const blobUrl = AssetPreloader.getBlobURL(it.sources.glb);
                if (blobUrl) {
                    markCache(id, {glbBlobUrl: blobUrl});
                    return true;
                }
            } catch (e) {
                console.warn('[ItemsStore] warmById error', id, e);
            }
            return false;
        }

        async function warmAll({ids = null, concurrency = 3} = {}) {
            const urls = (ids
                    ? _items.filter(i => ids.includes(i.id))
                    : _items
            ).map(i => i.sources?.glb).filter(Boolean);

            await AssetPreloader.warmMany(urls, {concurrency});

            for (const it of _items) {
                const u = it.sources?.glb;
                if (!u) continue;
                const blob = AssetPreloader.getBlobURL(u);
                if (blob) markCache(it.id, {glbBlobUrl: blob});
            }
        }

        /**
         * Estado resumido de caché de un ítem:
         * - "hot": en memoria con blob listo
         * - "warming": se está precargando
         * - "cold": sin precarga
         * - "missing": sin URL GLB
         */
        function getCacheStatus(id) {
            const it = getItemById(id);
            if (!it?.sources?.glb) return 'missing';
            const url = it.sources.glb;
            const hasMem = AssetPreloader.has(url);
            const warming = AssetPreloader.isWarming(url);
            if (hasMem) return 'hot';
            if (warming) return 'warming';
            return 'cold';
        }

        /**
         * Info detallada por item para depuración/log.
         */
        async function getCacheInfo(id) {
            const it = getItemById(id);
            if (!it?.sources?.glb) return null;
            const base = await AssetPreloader.check(it.sources.glb);
            return {
                id: it.id,
                title: it.title,
                subtitle: it.subtitle,
                ...base,
                lastWarmAt: it.dataCache?.lastWarmAt || null,
                bytes: it.dataCache?.bytes || null
            };
        }

        return {
            setItems, getItems, replaceAll, updateItem, getItemById,
            markCache, getBestGlbUrl,
            warmById, warmAll,
            getCacheStatus, getCacheInfo,
        };
    })();
</script>
