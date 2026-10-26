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


    /**
     * Yapita Registration Modal
     * UI validation and interactions.
     */
    const YapitaRegisterModal = (() => {

        const selectors = {
            modal: '#yapitaRegisterModal',
            form: '#yapitaRegisterForm',
            email: '#yapitaRegisterEmail',
            password: '#yapitaRegisterPassword',
            submit: '#yapitaRegisterSubmit',
            feedback: '#yapitaRegisterFeedback',
            passwordToggle: '.yapita-register-form__toggle-password',
            group: '.yapita-register-form__group',
            openTrigger: '.yapita-register__content'
        };

        const state = {
            isSubmitting: false
        };

        function validateEmail(value) {
            const email = value.trim();

            if (!email) {
                return 'Ingresa tu correo electrónico.';
            }

            if (email.length > 254) {
                return 'El correo electrónico es demasiado largo.';
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailPattern.test(email)) {
                return 'Ingresa un correo electrónico válido.';
            }

            return '';
        }

        function validatePassword(value) {
            if (!value) {
                return 'Ingresa una contraseña.';
            }

            if (value.length < 8) {
                return 'La contraseña debe tener mínimo 8 caracteres.';
            }

            if (value.length > 128) {
                return 'La contraseña no puede superar 128 caracteres.';
            }

            return '';
        }

        function setFieldState($input, error, showError = true) {
            const $group = $input.closest(selectors.group);
            const $error = $group.find('.yapita-register-form__error');

            const hasValue = $input.val().length > 0;
            const isValid = !error;

            $group
                .toggleClass('yapita-register-form__group--valid', isValid && hasValue)
                .toggleClass('yapita-register-form__group--invalid', Boolean(error) && showError);

            $input.attr(
                'aria-invalid',
                Boolean(error) && showError ? 'true' : 'false'
            );

            $error.text(showError ? error : '');
        }

        function validateForm(showErrors = false) {
            const $email = $(selectors.email);
            const $password = $(selectors.password);

            const emailError = validateEmail($email.val());
            const passwordError = validatePassword($password.val());

            setFieldState(
                $email,
                emailError,
                showErrors || $email.data('touched') === true
            );

            setFieldState(
                $password,
                passwordError,
                showErrors || $password.data('touched') === true
            );

            const isValid = !emailError && !passwordError;

            $(selectors.submit).prop(
                'disabled',
                !isValid || state.isSubmitting
            );

            return isValid;
        }

        function togglePassword() {
            const $password = $(selectors.password);
            const $button = $(selectors.passwordToggle);
            const $icon = $button.find('i');

            const isVisible = $password.attr('type') === 'text';

            $password.attr('type', isVisible ? 'password' : 'text');

            $icon.toggleClass('bi-eye', isVisible);
            $icon.toggleClass('bi-eye-slash', !isVisible);

            $button.attr({
                'aria-label': isVisible ? 'Mostrar contraseña' : 'Ocultar contraseña',
                'aria-pressed': String(!isVisible)
            });
        }

        function open() {
            const modalElement = document.querySelector(selectors.modal);

            if (!modalElement) return;

            bootstrap.Modal.getOrCreateInstance(modalElement).show();
        }

        function handleSubmit(event) {
            event.preventDefault();

            if (state.isSubmitting || !validateForm(true)) {
                return;
            }

            $(selectors.feedback).text(
                'Formulario válido. Pendiente conectar el servicio de registro.'
            );

            // Aquí conectaremos posteriormente el endpoint Laravel.
        }

        function bindEvents() {
            $(document).on('click', selectors.openTrigger, function (event) {
                event.preventDefault();
                open();
            });

            $(document).on('input', `${selectors.email}, ${selectors.password}`, function () {
                $(this).data('touched', true);
                validateForm();
            });

            $(document).on('blur', `${selectors.email}, ${selectors.password}`, function () {
                $(this).data('touched', true);
                validateForm();
            });

            $(document).on('click', selectors.passwordToggle, togglePassword);

            $(document).on('submit', selectors.form, handleSubmit);

            $(document).on('hidden.bs.modal', selectors.modal, function () {
                $(selectors.form)[0]?.reset();

                $(selectors.email).removeData('touched');
                $(selectors.password).removeData('touched');

                $(selectors.feedback).empty();

                $(selectors.password).attr('type', 'password');

                $(selectors.passwordToggle)
                    .attr({
                        'aria-label': 'Mostrar contraseña',
                        'aria-pressed': 'false'
                    })
                    .find('i')
                    .removeClass('bi-eye-slash')
                    .addClass('bi-eye');

                validateForm(false);
            });
        }

        function init() {
            bindEvents();
            validateForm(false);
        }

        return {
            init,
            open,
            validateForm
        };

    })();


</script>
