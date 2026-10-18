
<script>

    async function diagnoseARSession() {
        const info = {
            userAgent: navigator.userAgent,
            secure: window.isSecureContext,
            hasWebXR: !!navigator.xr,
            supported: false,
            sessionStarted: false,
            errorName: null,
            errorMessage: null
        };

        console.table(info);

        if (!navigator.xr || !window.isSecureContext) {
            return info;
        }

        try {
            info.supported =
                await navigator.xr.isSessionSupported('immersive-ar');

            console.log('[AR] Soporte:', info.supported);
        } catch (error) {
            console.error('[AR] Error de compatibilidad:', error);
        }

        // Esta llamada debe ejecutarse desde el clic del usuario.
        try {
            const session = await navigator.xr.requestSession('immersive-ar');

            info.sessionStarted = true;

            console.log('[AR] Sesión básica iniciada');

            await session.end();
        } catch (error) {
            info.errorName = error.name;
            info.errorMessage = error.message;

            console.error('[AR] Falló la sesión básica:', error);
        }

        console.table(info);

        return info;
    }

    const Platform = (() => {
        const ua = navigator.userAgent || navigator.vendor || "";

        const isAndroid = /Android/i.test(ua);

        const isIOS =
            /iPhone|iPad|iPod/i.test(ua) ||
            (navigator.platform === "MacIntel" &&
                navigator.maxTouchPoints > 1);

        const isSecure = window.isSecureContext;

        const hasWebXR =
            typeof navigator.xr !== "undefined" &&
            typeof navigator.xr.isSessionSupported === "function";

        const hasCamera =
            !!navigator.mediaDevices?.getUserMedia;

        return {
            isAndroid,
            isIOS,
            isSecure,
            hasWebXR,
            hasCamera
        };
    })();

    async function canUseAR() {
        if (!Platform.isAndroid) {
            console.warn("[AR] Dispositivo no Android");
            return false;
        }

        if (!Platform.isSecure) {
            console.warn("[AR] Requiere HTTPS o contexto seguro");
            return false;
        }

        if (!Platform.hasWebXR) {
            console.warn("[AR] WebXR no disponible");
            return false;
        }

        try {
            const supported =
                await navigator.xr.isSessionSupported("immersive-ar");

            console.log("[AR] Compatibilidad:", supported);

            return supported;
        } catch (error) {
            console.error("[AR] Error:", error);
            return false;
        }
    }
</script>
