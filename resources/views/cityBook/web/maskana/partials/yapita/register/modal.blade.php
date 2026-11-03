
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


@include('partials.auth.modals.reward-modal')

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
