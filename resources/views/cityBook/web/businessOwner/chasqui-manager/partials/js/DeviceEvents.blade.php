<script>
    class DeviceEvents {
        static attach() {
            document.addEventListener('visibilitychange', async () => {
                if (document.hidden) {
                    await window.Viewer?.destroy();
                }
            });
            window.addEventListener('pagehide', () => window.Viewer?.destroy());
            window.addEventListener('orientationchange', () => console.log('[orientationchange]'));
            window.addEventListener('resize', () => console.log('[resize]', innerWidth, innerHeight));
        }
    }
</script>
