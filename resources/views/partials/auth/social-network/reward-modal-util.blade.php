<script>

    class YapitaRewardModalUtil {

        static modalId = 'yapitaRewardModal';

        static reloadOnClose = false;

        // ==========================================
        // MOSTRAR RECOMPENSA
        // ==========================================

        static show(response) {

            const user = response?.data?.user;

            const gamification = response?.data?.gamification;

            const rewardData = gamification?.data;

            const rewardInformation = rewardData?.rewardInformation;

            const process = rewardInformation?.process;

            const points = rewardInformation?.points;

            if (!user || !process) {
                console.warn(
                    '[Yapita] No existe información de recompensa.'
                );

           window.location.reload();
                return;
            }

            // ==========================================
            // ASIGNAR INFORMACIÓN
            // ==========================================

            $('#yapitaRewardUser').text(
                user.name || 'Usuario'
            );

            $('#yapitaRewardTitle').text(
                process.title || '¡Ganaste Yapitas!'
            );

            $('#yapitaRewardSubtitle').text(
                process.subtitle || ''
            );

            $('#yapitaRewardPoints').text(
                points?.points ?? rewardData?.points ?? 0
            );

            // ==========================================
            // IMAGEN
            // ==========================================

            if (process.source) {

                const imageUrl = new URL(
                    process.source,
                    window.location.origin
                ).href;

                $('#yapitaRewardImage')
                    .attr('src', imageUrl)
                    .show();

            } else {

                $('#yapitaRewardImage').hide();

            }
           this.showModal();
        }
static showModal(){

    // ==========================================
    // ABRIR MODAL
    // ==========================================

    const modalElement = document.getElementById(
        this.modalId
    );

    if (!modalElement) {
        window.location.reload();
        return;
    }

    this.reloadOnClose = true;

    const modal = bootstrap.Modal.getOrCreateInstance(
        modalElement
    );

    modal.show();
}
        // ==========================================
        // INICIALIZAR EVENTOS
        // ==========================================

        static init() {

            const modalElement = document.getElementById(
                this.modalId
            );

            if (!modalElement) return;

            $(modalElement)
                .off('hidden.bs.modal.yapitaReward')
                .on('hidden.bs.modal.yapitaReward', () => {

                    if (this.reloadOnClose) {

                        this.reloadOnClose = false;

                        window.location.reload();
                    }
                });
        }
    }
    window.SocialNetworkLoginUtil=YapitaRewardModalUtil;

    </script>
