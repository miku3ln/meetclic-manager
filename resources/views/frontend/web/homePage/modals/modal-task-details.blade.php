
<div
    class="modal fade yapita-task-modal"
    id="yapita-task-modal"
    tabindex="-1"
    aria-labelledby="yapita-task-modal-title"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content yapita-task-modal__content">

            <!-- HEADER -->
            <header class="yapita-task-modal__header">

                <span
                    class="yapita-task-modal__handle"
                    aria-hidden="true"
                ></span>

                <button
                    type="button"
                    class="yapita-task-modal__close"
                    data-bs-dismiss="modal"
                    aria-label="Cerrar"
                >
                    <i class="bi bi-x-lg"></i>
                </button>

            </header>

            <!-- SCROLLABLE BODY -->
            <div class="modal-body yapita-task-modal__body">

                <!-- TASK SUMMARY -->
                <section class="yapita-task-modal__overview">

                    <div class="yapita-task-modal__media">

                        <img
                            id="yapita-task-modal-image"
                            class="yapita-task-modal__image"
                            alt=""
                        >

                    </div>

                    <div class="yapita-task-modal__information">

                        <div class="yapita-task-modal__badges">

                            <span
                                id="yapita-task-modal-channel"
                                class="yapita-task-modal__channel"
                            ></span>

                            <span
                                id="yapita-task-modal-points"
                                class="yapita-task-modal__points"
                            ></span>

                        </div>

                        <h2
                            id="yapita-task-modal-title"
                            class="yapita-task-modal__title"
                        ></h2>

                    </div>

                </section>

                <!-- BUSINESS -->
                <section class="yapita-task-modal__business">

                    <div class="yapita-task-modal__business-icon">
                        <i class="bi bi-shop-window"></i>
                    </div>

                    <div class="yapita-task-modal__business-info">

                        <strong
                            id="yapita-task-modal-business-name"
                            class="yapita-task-modal__business-name"
                        ></strong>

                        <span
                            id="yapita-task-modal-business-category"
                            class="yapita-task-modal__business-category"
                        ></span>

                    </div>

                    <button
                        type="button"
                        class="yapita-task-modal__business-action"
                        data-yapita-modal-action="business"
                        aria-label="Ver empresa"
                    >
                        <i class="bi bi-chevron-right"></i>
                    </button>

                </section>

                <!-- DESCRIPTION -->
                <p
                    id="yapita-task-modal-description"
                    class="yapita-task-modal__description"
                ></p>

                <!-- STEPS -->
                <section class="yapita-task-modal__steps">

                    <h3 class="yapita-task-modal__section-title">
                        <i class="bi bi-card-checklist"></i>
                        Pasos para completar la tarea
                    </h3>

                    <ol
                        id="yapita-task-modal-steps"
                        class="yapita-task-modal__steps-list"
                    ></ol>

                </section>

                <!-- EXTRA DETAILS -->
                <div
                    id="yapita-task-modal-extra"
                    class="yapita-task-modal__extra"
                    hidden
                >

                    <section
                        id="yapita-task-modal-tips-section"
                        class="yapita-task-modal__extra-section"
                        hidden
                    >
                        <h3>
                            <i class="bi bi-lightbulb"></i>
                            Consejos
                        </h3>

                        <ul id="yapita-task-modal-tips"></ul>
                    </section>

                    <section
                        id="yapita-task-modal-validation-section"
                        class="yapita-task-modal__extra-section"
                        hidden
                    >
                        <h3>
                            <i class="bi bi-check2-circle"></i>
                            Validación
                        </h3>

                        <p id="yapita-task-modal-validation"></p>
                    </section>

                    <section
                        id="yapita-task-modal-rules-section"
                        class="yapita-task-modal__extra-section"
                        hidden
                    >
                        <h3>
                            <i class="bi bi-shield-check"></i>
                            Reglas
                        </h3>

                        <ul id="yapita-task-modal-rules"></ul>
                    </section>

                </div>

                <!-- FREQUENCY / VALIDITY / STATUS -->
                <section class="yapita-task-modal__metadata">

                    <div class="yapita-task-modal__metadata-item">
                        <i class="bi bi-arrow-repeat"></i>

                        <div>
                            <span>Frecuencia</span>

                            <strong id="yapita-task-modal-frequency"></strong>
                        </div>
                    </div>

                    <div class="yapita-task-modal__metadata-item">
                        <i class="bi bi-calendar3"></i>

                        <div>
                            <span>Vigencia</span>

                            <strong id="yapita-task-modal-validity"></strong>
                        </div>
                    </div>

                    <div class="yapita-task-modal__metadata-item">
                        <i class="bi bi-clock-history"></i>

                        <div>
                            <span>Estado</span>

                            <strong
                                id="yapita-task-modal-status"
                                class="yapita-task-modal__status"
                            ></strong>
                        </div>
                    </div>

                </section>

                <!-- QUICK ACTIONS -->
                <section class="yapita-task-modal__quick">

                    <h3 class="yapita-task-modal__section-title">
                        <i class="bi bi-lightning-charge-fill"></i>
                        Acciones
                    </h3>

                    <div class="yapita-task-modal__quick-grid">

                        <button
                            type="button"
                            class="yapita-task-modal__quick-button"
                            data-yapita-modal-action="details"
                        >
                            <i class="bi bi-card-text"></i>
                            <span>Ver detalle</span>
                        </button>

                        <button
                            type="button"
                            id="yapita-task-modal-map-shortcut"
                            class="yapita-task-modal__quick-button"
                            data-yapita-modal-action="map"
                        >
                            <i class="bi bi-geo-alt"></i>
                            <span>Cómo llegar</span>
                        </button>

                        <button
                            type="button"
                            class="yapita-task-modal__quick-button"
                            data-yapita-modal-action="status"
                        >
                            <i class="bi bi-check-circle"></i>
                            <span id="yapita-task-modal-status-label">
                                Ver estado
                            </span>
                        </button>

                    </div>

                </section>

            </div>

            <!-- FOOTER -->
            <footer class="yapita-task-modal__footer">

                <button
                    type="button"
                    id="yapita-task-modal-primary"
                    class="yapita-task-modal__button yapita-task-modal__button--primary"
                >
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>Cómo llegar</span>
                </button>

                <button
                    type="button"
                    id="yapita-task-modal-secondary"
                    class="yapita-task-modal__button yapita-task-modal__button--secondary"
                    data-yapita-modal-action="participate"
                >
                    <i class="bi bi-info-circle"></i>
                    <span>Cómo participar</span>
                </button>

            </footer>

        </div>

    </div>
</div>
