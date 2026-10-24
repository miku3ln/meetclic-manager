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
