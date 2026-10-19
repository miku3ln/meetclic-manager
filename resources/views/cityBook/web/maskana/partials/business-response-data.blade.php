<script>

    class BusinessResponseData {

        constructor(config = {}) {

            this.config = {
                containerId: 'business-response-data',
                ...config
            };

            this.container = document.getElementById(
                this.config.containerId
            );

            if (!this.container) {
                console.warn(
                    '[BusinessResponseData] Contenedor no encontrado.'
                );
            }
        }

        /**
         * Mostrar indicación para visualizar los resultados en el mapa.
         */
        renderMapHint() {

            if (!this.container) return;

            // Evitar duplicar el mensaje.
            if (this.container.querySelector('.response-data__hint')) {
                return;
            }

            const hint = document.createElement('div');

            hint.className = [
                'response-data__hint',
                'd-flex',
                'align-items-start',
                'gap-2',
                'mt-3'
            ].join(' ');

            hint.innerHTML = `
        <div class="response-data__hint-icon flex-shrink-0">
            <i class="bi bi-info-circle-fill"
               aria-hidden="true"></i>
        </div>

        <div class="response-data__hint-info">
            <div class="response-data__hint-title">`
                + MaskanaTranslations['frontend.maskana.filter.view_map_question'] +
                `  </div>

            <p class="response-data__hint-message mb-0">`
                + MaskanaTranslations['frontend.maskana.filter.view_map_description'] +
                ` </p>
        </div>
    `;

            this.container.appendChild(hint);
        }

        /**
         * Mostrar resultado de empresas.
         *
         * @param {Array} businesses
         */
        render(businesses = []) {

            if (!this.container) return;

            const data = Array.isArray(businesses)
                ? businesses
                : [];

            const total = data.length;

            if (total === 0) {
                this.renderEmpty();
                return;
            }

            this.renderSuccess(total);
        }

        /**
         * Mostrar cantidad de empresas.
         */
        renderSuccess(total) {

            const label = total === 1
                ? MaskanaTranslations['frontend.maskana.filter.business_found']
                : MaskanaTranslations['frontend.maskana.filter.businesses_found'];

            this.container.innerHTML = `
            <div class="response-data__content
                        response-data__content--success
                        d-flex align-items-center gap-3">

                <div class="response-data__icon
                            response-data__icon--success
                            flex-shrink-0">
                    <i class="bi bi-geo-alt-fill"
                       aria-hidden="true"></i>
                </div>

                <div class="response-data__info flex-grow-1">

                    <div class="response-data__count">
                        ${total.toLocaleString('es-EC')}
                    </div>

                    <div class="response-data__message">
                        ${label}
                    </div>

                </div>

                <i class="bi bi-check-circle-fill
                          response-data__status-icon"
                   aria-hidden="true"></i>

            </div>
        `;
        }

        /**
         * Mostrar mensaje sin resultados.
         */
        renderEmpty() {

            this.container.innerHTML = `
            <div class="response-data__content
                        response-data__content--empty
                        d-flex align-items-center gap-3">

                <div class="response-data__icon
                            response-data__icon--empty
                            flex-shrink-0">
                    <i class="bi bi-search"
                       aria-hidden="true"></i>
                </div>

                <div class="response-data__info flex-grow-1">

                    <div class="response-data__title">`
                + MaskanaTranslations['frontend.maskana.business.no_information'] +
                ` </div>

                    <div class="response-data__message">`
                + MaskanaTranslations['frontend.maskana.business.try_changing_filters'] +
                `</div>

                </div>

            </div>
        `;
        }

        /**
         * Limpiar el contenedor.
         */
        clear() {
            if (!this.container) return;

            this.container.replaceChildren();
        }
    }

    window.BusinessResponseData = BusinessResponseData;

</script>
