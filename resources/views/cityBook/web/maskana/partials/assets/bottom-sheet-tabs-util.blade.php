<script>

    /**
     * ================================================
     * MASKANA - BOTTOM SHEET TABS UTIL
     * ================================================
     *
     * Tabs:
     * - filters
     * - prizes
     *
     * Events:
     * - maskana:sheet:tab:changed
     * - maskana:sheet:tab:filters
     * - maskana:sheet:tab:prizes
     */

    class MaskanaBottomSheetTabsUtil {

        static selector = '#maskana-bottom-sheet';

        static activeTab = 'filters';

        static isInitialized = false;

        // ==========================================
        // INITIALIZATION
        // ==========================================

        static init() {

            const $sheet = $(this.selector);

            if (!$sheet.length) {
                return false;
            }

            if (this.isInitialized) {
                return true;
            }

            this.isInitialized = true;

            this.bindEvents();

            this.show('filters', false);

            return true;
        }

        // ==========================================
        // EVENTS
        // ==========================================

        static bindEvents() {

            $(document)
                .off(
                    'click.maskanaSheetTabs',
                    '[data-maskana-tab]'
                )
                .on(
                    'click.maskanaSheetTabs',
                    '[data-maskana-tab]',
                    (event) => {

                        event.preventDefault();

                        const tab = $(event.currentTarget)
                            .attr('data-maskana-tab');

                        this.show(tab);
                    }
                );

            // Keyboard navigation between tabs.
            $(document)
                .off(
                    'keydown.maskanaSheetTabs',
                    '[data-maskana-tab]'
                )
                .on(
                    'keydown.maskanaSheetTabs',
                    '[data-maskana-tab]',
                    (event) => {

                        if (
                            event.key !== 'ArrowLeft' &&
                            event.key !== 'ArrowRight' &&
                            event.key !== 'Home' &&
                            event.key !== 'End'
                        ) {
                            return;
                        }

                        event.preventDefault();

                        const tabs = ['filters', 'prizes'];

                        const currentIndex = tabs.indexOf(
                            $(event.currentTarget)
                                .attr('data-maskana-tab')
                        );

                        let nextIndex = currentIndex;

                        if (event.key === 'ArrowRight') {
                            nextIndex = (currentIndex + 1) % tabs.length;
                        }

                        if (event.key === 'ArrowLeft') {
                            nextIndex = (currentIndex - 1 + tabs.length) % tabs.length;
                        }

                        if (event.key === 'Home') {
                            nextIndex = 0;
                        }

                        if (event.key === 'End') {
                            nextIndex = tabs.length - 1;
                        }

                        this.show(tabs[nextIndex]);

                        $(this.selector)
                            .find(`[data-maskana-tab="${tabs[nextIndex]}"]`)
                            .trigger('focus');
                    }
                );
        }

        // ==========================================
        // SHOW TAB
        // ==========================================

        static show(tab, emitEvent = true) {

            if (!['filters', 'prizes'].includes(tab)) {
                return false;
            }

            const $sheet = $(this.selector);

            if (!$sheet.length) {
                return false;
            }

            const previousTab = this.activeTab;

            this.activeTab = tab;

            $sheet.attr('data-active-tab', tab);

            // --------------------------------------
            // UPDATE TABS
            // --------------------------------------

            $sheet.find('[data-maskana-tab]').each(
                function () {

                    const $button = $(this);

                    const isActive =
                        $button.attr('data-maskana-tab') === tab;

                    $button
                        .toggleClass(
                            'maskana-sheet__tab--active',
                            isActive
                        )
                        .attr('aria-selected', String(isActive))
                        .attr('tabindex', isActive ? '0' : '-1');
                }
            );

            // --------------------------------------
            // UPDATE PANELS
            // --------------------------------------

            $sheet.find('[data-maskana-panel]').each(
                function () {

                    const $panel = $(this);

                    const isActive =
                        $panel.attr('data-maskana-panel') === tab;

                    $panel.toggleClass(
                        'maskana-sheet__panel--active',
                        isActive
                    );

                    $panel.prop('hidden', !isActive);
                }
            );

            // --------------------------------------
            // RESET BODY SCROLL
            // --------------------------------------

            $sheet.find('.maskana-sheet__body')
                .scrollTop(0);

            // --------------------------------------
            // EMIT EVENTS
            // --------------------------------------

            if (emitEvent && previousTab !== tab) {

                const detail = {
                    activeTab: tab,
                    previousTab: previousTab
                };

                $(document).trigger(
                    'maskana:sheet:tab:changed',
                    [detail]
                );

                $(document).trigger(
                    `maskana:sheet:tab:${tab}`,
                    [detail]
                );
            }

            return true;
        }

        // ==========================================
        // GET ACTIVE TAB
        // ==========================================

        static getActiveTab() {
            return this.activeTab;
        }

        // ==========================================
        // DESTROY
        // ==========================================

        static destroy() {

            $(document).off(
                '.maskanaSheetTabs'
            );

            this.isInitialized = false;
            this.activeTab = 'filters';
        }
    }

    window.MaskanaBottomSheetTabsUtil =
        MaskanaBottomSheetTabsUtil;
</script>
