<script>
    function canScreenCapture() {
        const isSecure = location.protocol === 'https:' || location.hostname === 'localhost';
        const hasAPI = !!(navigator.mediaDevices?.getDisplayMedia || navigator.getDisplayMedia);
        const inIframe = window.self !== window.top;
        const isWV = /\bwv\b/i.test(navigator.userAgent);

        return {
            ok: isSecure && hasAPI && !isWV,
            reason: !isSecure ? 'No HTTPS' :
                !hasAPI ? 'API no disponible' :
                    isWV ? 'WebView limita captura' :
                        inIframe ? 'Iframe sin permisos (display-capture)' :
                            'Desconocido',
            hasAPI, isSecure, inIframe, isWV
        };
    }
</script>
