<script>
    const AssetPreloader = (() => {

        /** =============================
         *  Normalización estable de URLs
         * ============================== */
        function normalizeUrl(url) {
            if (!url) return '';

            try {
                const u = new URL(url, location.origin);
                u.hash = '';                 // Sin hash
                u.search = '';               // Sin querystring
                return u.toString();
            } catch {
                // Caso: rutas relativas locales
                return url.replace(location.origin, '')
                    .replace(/#.*$/, '')
                    .replace(/\?.*$/, '');
            }
        }

        /** =============================
         *  Memoria interna
         * ============================== */
        const mem = new Map();   // normalizedUrl -> { buffer, blobUrl }
        const inflight = new Map();
        const CACHE_NAME = 'glb-precache-v1';
        const canCacheStorage = ('caches' in window);


        /** =============================
         *  Fetch directo
         * ============================== */
        async function _fetchToBuffer(urlN) {
            const r = await fetch(urlN, {credentials: 'omit', mode: 'cors'});
            if (!r.ok) throw new Error(`Fetch failed (${r.status}) ${urlN}`);
            return await r.arrayBuffer();
        }

        /** =============================
         *  CacheStorage: guardar
         * ============================== */
        async function _putInCache(urlN, buffer) {
            if (!canCacheStorage) return;

            try {
                const cache = await caches.open(CACHE_NAME);
                const resp = new Response(buffer, {
                    headers: {
                        'Content-Type': 'model/gltf-binary',
                        'Content-Length': String(buffer.byteLength)
                    }
                });

                await cache.put(urlN, resp);
            } catch {
            }
        }

        /** =============================
         *  CacheStorage: leer
         * ============================== */
        async function _fromCache(urlN) {
            if (!canCacheStorage) return null;

            try {
                const cache = await caches.open(CACHE_NAME);
                const resp = await cache.match(urlN);
                if (!resp) return null;
                return await resp.arrayBuffer();
            } catch {
                return null;
            }
        }

        /** =============================
         *  Preload individual
         * ============================== */
        async function warm(url) {
            if (!url) return;

            const urlN = normalizeUrl(url);

            if (mem.has(urlN)) return;

            if (inflight.has(urlN)) {
                await inflight.get(urlN);
                return;
            }

            const job = (async () => {
                let buf = await _fromCache(urlN);

                if (!buf) {
                    const goodNet =
                        !('connection' in navigator) ||
                        ['wifi', 'ethernet', '4g']
                            .includes(navigator.connection.effectiveType || '4g');

                    if (!goodNet) return;

                    buf = await _fetchToBuffer(urlN);
                    _putInCache(urlN, buf).catch(() => {
                    });
                }

                if (buf && !mem.has(urlN)) {
                    const blobUrl = URL.createObjectURL(
                        new Blob([buf], {type: 'model/gltf-binary'})
                    );
                    mem.set(urlN, {buffer: buf, blobUrl});
                }
            })().finally(() => inflight.delete(urlN));

            inflight.set(urlN, job);
            await job;
        }


        /** =============================
         *  Preload múltiple
         * ============================== */
        function warmMany(urls = [], {concurrency = 3} = {}) {
            const list = urls.map(u => normalizeUrl(u));
            let idx = 0, active = 0;

            return new Promise(resolve => {
                const next = () => {
                    while (active < concurrency && idx < list.length) {
                        const urlN = list[idx++];
                        active++;

                        warm(urlN).finally(() => {
                            active--;
                            next();
                        });
                    }
                    if (active === 0 && idx >= list.length) resolve();
                };
                next();
            });
        }


        /** =============================
         *  Obtener blob: URL real
         * ============================== */
        function getBlobURL(url) {
            const urlN = normalizeUrl(url);
            return mem.get(urlN)?.blobUrl || null;
        }

        /** =============================
         *  Verificador simple de memoria
         * ============================== */
        function has(url) {
            const urlN = normalizeUrl(url);
            return mem.has(urlN);
        }

        function isWarming(url) {
            const urlN = normalizeUrl(url);
            return inflight.has(urlN);
        }

        /**
         * Verificador detallado: memoria + CacheStorage
         * Devuelve un objeto útil para debug/log:
         * {
         *   urlOriginal, urlNormalized,
         *   inMemory, inCacheStorage, hasBlobUrl
         * }
         */
        async function check(url) {
            const urlN = normalizeUrl(url);
            const inMemory = mem.has(urlN);
            const hasBlobUrl = !!mem.get(urlN)?.blobUrl;

            let inCacheStorage = false;
            if (canCacheStorage) {
                try {
                    const cache = await caches.open(CACHE_NAME);
                    const resp = await cache.match(urlN);
                    inCacheStorage = !!resp;
                } catch {
                    inCacheStorage = false;
                }
            }

            return {
                urlOriginal: url,
                urlNormalized: urlN,
                inMemory,
                inCacheStorage,
                hasBlobUrl
            };
        }

        /** =============================
         *  Liberar
         * ============================== */
        function dispose(url) {
            const urlN = normalizeUrl(url);
            const obj = mem.get(urlN);

            if (obj?.blobUrl) URL.revokeObjectURL(obj.blobUrl);

            mem.delete(urlN);
        }


        /** =============================
         *  API pública
         * ============================== */
        return {
            warm,
            warmMany,
            getBlobURL,
            dispose,
            normalizeUrl,
            has,
            isWarming,
            check
        };
    })();
</script>
