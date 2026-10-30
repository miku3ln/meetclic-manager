
<!-- ================================================
     MASKANA - PRIZE DETAIL MODAL
     Outside bottom sheet
================================================ -->

<div
    class="modal fade maskana-prize-modal"
    id="maskana-prize-modal"
    tabindex="-1"
    aria-labelledby="maskana-prize-modal-title"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">

        <div class="modal-content maskana-prize-modal__content">

            <!-- HEADER -->
            <div class="modal-header maskana-prize-modal__header">

                <div>
                    <span class="maskana-prize-modal__eyebrow">
                        <i class="bi bi-gift-fill"></i>
                        PREMIO YAPITA
                    </span>

                    <h2
                        class="modal-title maskana-prize-modal__title"
                        id="maskana-prize-modal-title"
                    >
                        Detalle del premio
                    </h2>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Cerrar"
                ></button>

            </div>

            <!-- BODY -->
            <div class="modal-body maskana-prize-modal__body">

                <div class="maskana-prize-modal__image-wrapper">

                    <img
                        id="maskana-prize-modal-image"
                        class="maskana-prize-modal__image"
                        src=""
                        alt=""
                    >

                </div>

                <div class="maskana-prize-modal__information">

                    <span
                        id="maskana-prize-modal-business"
                        class="maskana-prize-modal__business"
                    ></span>

                    <p
                        id="maskana-prize-modal-description"
                        class="maskana-prize-modal__description"
                    ></p>

                    <div class="maskana-prize-modal__dates">

                        <div class="maskana-prize-modal__date">
                            <i class="bi bi-calendar-check"></i>

                            <div>
                                <small>Disponible desde</small>
                                <strong id="maskana-prize-modal-start"></strong>
                            </div>
                        </div>

                        <div class="maskana-prize-modal__date">
                            <i class="bi bi-calendar-x"></i>

                            <div>
                                <small>Válido hasta</small>
                                <strong id="maskana-prize-modal-end"></strong>
                            </div>
                        </div>

                    </div>

                    <span
                        id="maskana-prize-modal-status"
                        class="maskana-prize-modal__status"
                    ></span>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer maskana-prize-modal__footer">

                <button
                    type="button"
                    class="maskana-prize-modal__close"
                    data-bs-dismiss="modal"
                >
                    Cerrar
                </button>

            </div>

        </div>

    </div>

</div>


<!-- ==========================================
     YAPITA - MODAL RECOMPENSA DE BIENVENIDA
========================================== -->

<div class="modal fade"
     id="yapitaRewardModal"
     tabindex="-1"
     aria-labelledby="yapitaRewardModalLabel"
     aria-hidden="true"
     data-bs-backdrop="static"
     data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content yapita-reward-modal">

            <!-- BOTÓN CERRAR -->
            <button type="button"
                    class="btn-close yapita-reward-close"
                    data-bs-dismiss="modal"
                    aria-label="Cerrar">
            </button>

            <!-- IMAGEN DE RECOMPENSA -->
            <div class="yapita-reward-image-container">

                <img id="yapitaRewardImage"
                     src=""
                     alt="Recompensa Yapita"
                     class="yapita-reward-image">

            </div>

            <!-- CONTENIDO -->
            <div class="modal-body text-center">

                <div class="yapita-reward-badge">
                    🎉 ¡Bienvenido a Yapita!
                </div>

                <!-- NOMBRE USUARIO -->
                <h2 id="yapitaRewardUser"
                    class="yapita-reward-user">
                </h2>

                <!-- TÍTULO TAREA -->
                <h3 id="yapitaRewardTitle"
                    class="yapita-reward-title">
                </h3>

                <!-- SUBTÍTULO -->
                <p id="yapitaRewardSubtitle"
                   class="yapita-reward-subtitle">
                </p>

                <!-- PUNTOS -->
                <div class="yapita-reward-points">

                    <span class="yapita-reward-points-label">
                        HAS GANADO
                    </span>

                    <div class="yapita-reward-points-value">
                        +<span id="yapitaRewardPoints">0</span>
                    </div>

                    <span class="yapita-reward-points-text">
                        Yapitas
                    </span>

                </div>

                <!-- BOTÓN -->
                <button type="button"
                        class="btn yapita-reward-button"
                        data-bs-dismiss="modal">

                    ¡Genial! Continuar

                </button>

            </div>

        </div>

    </div>

</div>

<div
    class="modal fade yapita-register-modal"
    id="yapitaRegisterModal"
    tabindex="-1"
    aria-labelledby="yapitaRegisterModalTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content yapita-register-modal__content">

            <button
                type="button"
                class="yapita-register-modal__close"
                data-bs-dismiss="modal"
                aria-label="Cerrar"
            >
                <i class="bi bi-x-lg"></i>
            </button>

            <div class="modal-body yapita-register-modal__body">
                @include('cityBook.web.maskana.partials.yapita.register.hero')
                @include('cityBook.web.maskana.partials.yapita.register.benefits')
                @include('cityBook.web.maskana.partials.yapita.register.form')
                @include('cityBook.web.maskana.partials.yapita.register.social')
                @include('cityBook.web.maskana.partials.yapita.register.footer')


            </div>

        </div>
    </div>
</div>
