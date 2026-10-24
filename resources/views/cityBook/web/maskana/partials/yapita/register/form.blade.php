<form
    id="yapitaRegisterForm"
    class="yapita-register-form"
    novalidate
>
    @csrf

    <!-- EMAIL -->
    <div class="yapita-register-form__group">

        <div class="yapita-register-form__field">

            <i class="bi bi-envelope yapita-register-form__icon"></i>

            <div class="yapita-register-form__input-wrapper">
                <label
                    for="yapitaRegisterEmail"
                    class="yapita-register-form__label"
                >
                    Correo electrónico
                </label>

                <input
                    type="email"
                    id="yapitaRegisterEmail"
                    name="email"
                    class="yapita-register-form__input"
                    placeholder="tucorreo@ejemplo.com"
                    autocomplete="email"
                    maxlength="254"
                    required
                    aria-describedby="yapitaRegisterEmailError"
                >
            </div>

            <i class="bi bi-check-circle-fill yapita-register-form__valid-icon"></i>

        </div>

        <span
            id="yapitaRegisterEmailError"
            class="yapita-register-form__error"
            role="status"
            aria-live="polite"
        ></span>

    </div>

    <!-- PASSWORD -->
    <div class="yapita-register-form__group">

        <div class="yapita-register-form__field">

            <i class="bi bi-lock yapita-register-form__icon"></i>

            <div class="yapita-register-form__input-wrapper">

                <label
                    for="yapitaRegisterPassword"
                    class="yapita-register-form__label"
                >
                    Contraseña
                </label>

                <input
                    type="password"
                    id="yapitaRegisterPassword"
                    name="password"
                    class="yapita-register-form__input"
                    placeholder="Mínimo 8 caracteres"
                    autocomplete="new-password"
                    minlength="8"
                    maxlength="128"
                    required
                    aria-describedby="yapitaRegisterPasswordError"
                >

            </div>

            <button
                type="button"
                class="yapita-register-form__toggle-password"
                aria-label="Mostrar contraseña"
                aria-pressed="false"
            >
                <i class="bi bi-eye"></i>
            </button>

        </div>

        <span
            id="yapitaRegisterPasswordError"
            class="yapita-register-form__error"
            role="status"
            aria-live="polite"
        ></span>

    </div>

    <!-- SUBMIT -->
    <button
        type="submit"
        id="yapitaRegisterSubmit"
        class="yapita-register-form__submit"
        disabled
    >
        <span>Crear mi cuenta y participar</span>
        <i class="bi bi-arrow-right"></i>
    </button>

    <div
        id="yapitaRegisterFeedback"
        class="yapita-register-form__feedback"
        role="status"
        aria-live="polite"
    ></div>

</form>
