<script>

    class MaskanaBottomSheetUtil {

        static selector = '#maskana-bottom-sheet';

        static isInitialized = false;

        static isExpanded = false;

        // ==========================================
        // INITIALIZATION
        // ==========================================

        static init() {
            if (this.isInitialized) return;

            const $sheet = $(this.selector);

            if (!$sheet.length) return;

            this.isInitialized = true;

            this.bindEvents();

            this.close(false);
        }

        // ==========================================
        // EVENTS
        // ==========================================

        static bindEvents() {
            $(document)
                .off('click.maskanaSheet', '#maskana-sheet-toggle')
                .on(
                    'click.maskanaSheet',
                    '#maskana-sheet-toggle',
                    (event) => {
                        event.preventDefault();

                        this.toggle();
                    }
                );
        }

        // ==========================================
        // OPEN
        // ==========================================

        static open(emitEvent = true) {
            if (this.isExpanded) return;

            const $sheet = $(this.selector);

            if (!$sheet.length) return;

            this.isExpanded = true;

            $sheet
                .removeClass('maskana-sheet--collapsed')
                .addClass('maskana-sheet--expanded')
                .attr('data-state', 'expanded');

            $('#maskana-sheet-toggle')
                .attr({
                    'aria-expanded': 'true',
                    'aria-label': 'Ocultar filtros'
                });

            $('#maskana-sheet-content')
                .removeAttr('inert');

            if (emitEvent) {
                this.emit('maskana:sheet:opened', {
                    expanded: true,
                    element: $sheet[0]
                });
            }
        }

        // ==========================================
        // CLOSE
        // ==========================================

        static close(emitEvent = true) {
            const $sheet = $(this.selector);

            if (!$sheet.length) return;

            const wasExpanded = this.isExpanded;

            this.isExpanded = false;

            $sheet
                .removeClass('maskana-sheet--expanded')
                .addClass('maskana-sheet--collapsed')
                .attr('data-state', 'collapsed');

            $('#maskana-sheet-toggle')
                .attr({
                    'aria-expanded': 'false',
                    'aria-label': 'Mostrar filtros'
                });

            $('#maskana-sheet-content')
                .attr('inert', '');

            if (emitEvent && wasExpanded) {
                this.emit('maskana:sheet:closed', {
                    expanded: false,
                    element: $sheet[0]
                });
            }
        }

        // ==========================================
        // TOGGLE
        // ==========================================

        static toggle() {
            if (this.isExpanded) {
                this.close();
            } else {
                this.open();
            }
        }

        // ==========================================
        // UPDATE HEADER
        // ==========================================

        static setHeader({
                             title,
                             image,
                             count
                         } = {}) {

            if (title !== undefined) {
                $('#maskana-sheet-title').text(title);
            }

            if (image !== undefined) {
                $('#maskana-sheet-image').attr('src', image);
            }

            if (count !== undefined) {
                $('#maskana-sheet-business-count').text(
                    `${count} ${Number(count) === 1 ? 'empresa' : 'empresas'}`
                );
            }
        }

        // ==========================================
        // CUSTOM EVENTS
        // ==========================================

        static emit(eventName, detail = {}) {
            $(document).trigger(eventName, [detail]);
        }
    }

    window.MaskanaBottomSheetUtil = MaskanaBottomSheetUtil;

</script>
