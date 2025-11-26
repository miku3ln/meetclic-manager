<script>
    const Platform = (function () {
        const ua = navigator.userAgent || navigator.vendor || "";
        const isAndroid = /Android/i.test(ua);
        const isIOS = /iPhone|iPad|iPod/i.test(ua) || (navigator.platform === "MacIntel" && navigator.maxTouchPoints > 1);
        const isSecure = location.protocol === "https:" || location.hostname === "localhost";
        return {isAndroid, isIOS, isSecure};
    })();

    async function canUseAR() {
        if (!Platform.isAndroid || !Platform.isSecure || !('xr' in navigator)) return false;
        try {
            return await navigator.xr.isSessionSupported('immersive-ar');
        } catch {
            return false;
        }
    }
</script>
