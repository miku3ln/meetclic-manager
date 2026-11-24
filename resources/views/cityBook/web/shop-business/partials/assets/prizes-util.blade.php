<script>
    /**
     * ================================================
     * MASKANA - PRIZES UTIL
     * ================================================
     *
     * Events:
     * - maskana:prize:opened
     * - maskana:prize:closed
     *
     * Bootstrap 5 Modal
     */

    class MaskanaPrizesUtil {

        static modalSelector = '#maskana-prize-modal';
        static cardSelector = '.maskana-prizes__card';
        static buttonSelector = '[data-maskana-prize-view]';

        static isInitialized = false;
        static currentPrize = null;

        // ==========================================
        // INITIALIZATION
        // ==========================================

        static init() {

            if (this.isInitialized) {
                return true;
            }

            if (!$(this.modalSelector).length) {
                return false;
            }

            if (
                typeof bootstrap === 'undefined' ||
                !bootstrap.Modal
            ) {
                return false;
            }

            this.bindEvents();

            this.isInitialized = true;

            return true;
        }

        // ==========================================
        // BIND EVENTS
        // ==========================================

        static bindEvents() {

            const self = this;

            // Toda la tarjeta es clicable
            $(document)
                .off('click.maskanaPrizes', this.cardSelector)
                .on(
                    'click.maskanaPrizes',
                    this.cardSelector,
                    function (event) {

                        // No interferir con otros controles
                        // interactivos independientes.
                        const $target = $(event.target);

                        const $interactive = $target.closest(
                            'a, button, input, select, textarea'
                        );

                        if (
                            $interactive.length &&
                            !$interactive.is(self.buttonSelector) &&
                            !$interactive.closest(self.buttonSelector).length
                        ) {
                            return;
                        }

                        event.preventDefault();

                        self.open($(this));
                    }
                );

            // Soporte para botones independientes
            // que no estén dentro de una tarjeta.
            $(document)
                .off('click.maskanaPrizes', this.buttonSelector)
                .on(
                    'click.maskanaPrizes',
                    this.buttonSelector,
                    function (event) {

                        // Si pertenece a una tarjeta,
                        // el evento de la tarjeta lo gestiona.
                        if ($(this).closest(self.cardSelector).length) {
                            return;
                        }

                        event.preventDefault();

                        self.open($(this));
                    }
                );

            // ======================================
            // MODAL HIDDEN
            // ======================================

            $(this.modalSelector)
                .off('hidden.bs.modal.maskanaPrizes')
                .on(
                    'hidden.bs.modal.maskanaPrizes',
                    () => {

                        const prize = this.currentPrize;

                        this.currentPrize = null;

                        $(document).trigger(
                            'maskana:prize:closed',
                            [prize]
                        );
                    }
                );
        }

        // ==========================================
        // RESOLVE PRIZE ELEMENT
        // ==========================================

        static resolvePrizeElement($element) {

            if (!$element?.length) {
                return $();
            }

            const $card = $element.is(this.cardSelector)
                ? $element
                : $element.closest(this.cardSelector);

            if (!$card.length) {
                return $element;
            }

            return $card;
        }

        // ==========================================
        // GET PRIZE DATA
        // ==========================================

        static getPrizeData($element) {

            const $card = this.resolvePrizeElement($element);

            if (!$card.length) {
                return null;
            }

            // Compatibilidad:
            // los atributos pueden estar en la tarjeta
            // o en el botón interno.

            const $button = $card.is(this.buttonSelector)
                ? $card
                : $card.find(this.buttonSelector).first();

            const getAttribute = (attribute) => {

                const cardValue = $card.attr(attribute);

                if (
                    cardValue !== undefined &&
                    cardValue !== null
                ) {
                    return cardValue;
                }

                if ($button.length) {

                    const buttonValue = $button.attr(attribute);

                    if (
                        buttonValue !== undefined &&
                        buttonValue !== null
                    ) {
                        return buttonValue;
                    }
                }

                return '';
            };

            return {
                id: getAttribute('data-prize-id'),
                name: getAttribute('data-prize-name'),
                business: getAttribute('data-prize-business'),
                description: getAttribute('data-prize-description'),
                image: getAttribute('data-prize-image'),
                start: getAttribute('data-prize-start'),
                end: getAttribute('data-prize-end'),
                status: getAttribute('data-prize-status')
                    .toUpperCase()
            };
        }

        // ==========================================
        // OPEN MODAL
        // ==========================================

        static open($element) {

            if (!$element?.length) {
                return false;
            }

            if (
                typeof bootstrap === 'undefined' ||
                !bootstrap.Modal
            ) {
                return false;
            }

            const modalElement = document.querySelector(
                this.modalSelector
            );

            if (!modalElement) {
                return false;
            }

            const prize = this.getPrizeData($element);

            if (!prize) {
                return false;
            }

            this.currentPrize = prize;

            // ======================================
            // MODAL INFORMATION
            // ======================================

            $('#maskana-prize-modal-title')
                .text(prize.name);

            $('#maskana-prize-modal-business')
                .text(prize.business);

            $('#maskana-prize-modal-description')
                .text(prize.description);

            $('#maskana-prize-modal-start')
                .text(prize.start);

            $('#maskana-prize-modal-end')
                .text(prize.end);

            // ======================================
            // MODAL IMAGE
            // ======================================

            const $image = $('#maskana-prize-modal-image');

            if (prize.image) {

                $image
                    .attr({
                        src: prize.image,
                        alt: prize.name || 'Premio'
                    })
                    .show();

            } else {

                $image
                    .removeAttr('src')
                    .attr('alt', '')
                    .hide();
            }

            // ======================================
            // STATUS
            // ======================================

            const statusLabels = {
                ACTIVE: 'Premio vigente',
                UPCOMING: 'Próximamente',
                EXPIRED: 'Premio vencido'
            };

            const statusClasses = {
                ACTIVE: 'maskana-prize-modal__status--active',
                UPCOMING: 'maskana-prize-modal__status--upcoming',
                EXPIRED: 'maskana-prize-modal__status--expired'
            };

            const $status = $('#maskana-prize-modal-status');

            $status
                .removeClass(
                    Object.values(statusClasses).join(' ')
                )
                .text(
                    statusLabels[prize.status] ||
                    'Sin información'
                );

            if (statusClasses[prize.status]) {

                $status.addClass(
                    statusClasses[prize.status]
                );
            }

            // ======================================
            // SHOW MODAL
            // ======================================

            const modal = bootstrap.Modal.getOrCreateInstance(
                modalElement
            );

            modal.show($element[0]);

            // ======================================
            // EVENT OPENED
            // ======================================

            $(document).trigger(
                'maskana:prize:opened',
                [prize]
            );

            return true;
        }

        // ==========================================
        // CLOSE MODAL
        // ==========================================

        static close() {

            const modalElement = document.querySelector(
                this.modalSelector
            );

            if (
                !modalElement ||
                typeof bootstrap === 'undefined' ||
                !bootstrap.Modal
            ) {
                return false;
            }

            const modal = bootstrap.Modal.getInstance(
                modalElement
            );

            if (!modal) {
                return false;
            }

            modal.hide();

            return true;
        }

        // ==========================================
        // GET CURRENT PRIZE
        // ==========================================

        static getCurrentPrize() {

            return this.currentPrize;
        }

        // ==========================================
        // DESTROY
        // ==========================================

        static destroy() {

            $(document).off('.maskanaPrizes');

            $(this.modalSelector).off(
                '.maskanaPrizes'
            );

            this.currentPrize = null;
            this.isInitialized = false;
        }
    }

    window.MaskanaPrizesUtil = MaskanaPrizesUtil;
</script>
