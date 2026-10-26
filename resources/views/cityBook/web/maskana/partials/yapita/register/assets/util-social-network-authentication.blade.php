
<script>

    class SocialNetworkLoginUtil {

        static config = null;
        static googleInitialized = false;
        static facebookInitialized = false;
        static facebookPromise = null;
        static isAuthenticating = false;
        static activeFlow = null;
        static flowSequence = 0;
        static focusListenerInitialized = false;
        // ==========================================
        // CONFIGURATION
        // ==========================================

        static init(config = {}) {
            this.config = config;

            this.bindEvents();

            return this;
        }

        /**
         * Update the visual loading state of a provider.
         */
        static setLoading(provider, loading) {
            const $target = $(
                `[data-social-loading-target="${provider}"]`
            );

            $target
                .toggleClass('is-social-loading', loading)
                .attr('aria-busy', String(loading));

            // Native buttons can also be disabled.
            $target.filter('button').prop('disabled', loading);

            this.emit('social:auth:state', {
                provider,
                loading
            });
        }

        /**
         * Begin the authentication flow.
         *
         * State:
         * selecting -> processing -> finished
         */
        static startFlow(provider) {
            if (this.activeFlow) {
                return null;
            }

            const flow = {
                id: ++this.flowSequence,
                provider,
                state: 'selecting',
                hadWindowBlur: false,
                cancelTimer: null,
                safetyTimer: null
            };

            this.activeFlow = flow;

            this.setLoading(provider, true);

            this.emit('social:auth:started', {
                provider,
                flowId: flow.id
            });

            // Safety fallback for interrupted popup flows.
            flow.safetyTimer = setTimeout(() => {
                if (
                    this.activeFlow?.id === flow.id &&
                    this.activeFlow.state === 'selecting'
                ) {
                    this.cancelFlow(provider, flow.id);
                }
            }, 90000);

            return flow;
        }

        /**
         * Move to backend processing.
         */
        static markProcessing(provider) {
            const flow = this.activeFlow;

            if (!flow || flow.provider !== provider) {
                return false;
            }

            flow.state = 'processing';

            if (flow.cancelTimer) {
                clearTimeout(flow.cancelTimer);
                flow.cancelTimer = null;
            }

            if (flow.safetyTimer) {
                clearTimeout(flow.safetyTimer);
                flow.safetyTimer = null;
            }

            return true;
        }

        /**
         * Finish a flow and release the interface.
         */
        static finishFlow(provider) {
            const flow = this.activeFlow;

            if (!flow || flow.provider !== provider) {
                return;
            }

            clearTimeout(flow.cancelTimer);
            clearTimeout(flow.safetyTimer);

            this.activeFlow = null;
            this.setLoading(provider, false);
        }

        /**
         * Cancel provider selection.
         */
        static cancelFlow(provider, flowId = null) {
            const flow = this.activeFlow;

            if (!flow || flow.provider !== provider) return;

            if (flowId !== null && flow.id !== flowId) return;

            // Never cancel while Laravel is processing.
            if (flow.state === 'processing') return;

            this.finishFlow(provider);

            this.emit('social:auth:cancelled', {
                provider
            });
        }

        /**
         * Best-effort detection when the Google popup
         * closes and focus returns to the page.
         *
         * This is a heuristic, not an official
         * Google cancellation callback.
         */
        static initFocusDetection() {
            if (this.focusListenerInitialized) return;

            this.focusListenerInitialized = true;

            window.addEventListener('blur', () => {
                const flow = this.activeFlow;

                if (
                    flow?.provider === 'google' &&
                    flow.state === 'selecting'
                ) {
                    flow.hadWindowBlur = true;
                }
            });

            window.addEventListener('focus', () => {
                const flow = this.activeFlow;

                if (
                    !flow ||
                    flow.provider !== 'google' ||
                    flow.state !== 'selecting' ||
                    !flow.hadWindowBlur
                ) {
                    return;
                }

                const flowId = flow.id;

                clearTimeout(flow.cancelTimer);

                flow.cancelTimer = setTimeout(() => {
                    const current = this.activeFlow;

                    if (
                        current?.id === flowId &&
                        current.state === 'selecting'
                    ) {
                        this.cancelFlow('google', flowId);
                    }
                }, 1500);
            });
        }

        static getProviderConfig(provider) {
            const config = this.config?.[provider];

            if (!config || !config.enabled) {
                throw new Error(
                    `El proveedor ${provider} no está habilitado.`
                );
            }

            return config;
        }

        // ==========================================
        // GOOGLE
        // ==========================================

        static async initializeGoogle() {
            if (this.googleInitialized) return;

            const config = this.getProviderConfig('google');

            if (!config.clientId) {
                throw new Error('Google Client ID no configurado.');
            }

            await this.waitForGoogle();

            google.accounts.id.initialize({
                client_id: config.clientId,
                callback: response => {
                    this.handleGoogleCredential(response);
                },
                ux_mode: 'popup',
                auto_select: false,
                cancel_on_tap_outside: true
            });

            this.googleInitialized = true;
        }

        static waitForGoogle(timeout = 10000) {
            return new Promise((resolve, reject) => {
                const start = Date.now();

                const check = () => {
                    if (window.google?.accounts?.id) {
                        resolve();
                        return;
                    }

                    if (Date.now() - start >= timeout) {
                        reject(new Error(
                            'No se pudo cargar Google Identity Services.'
                        ));
                        return;
                    }

                    setTimeout(check, 100);
                };

                check();
            });
        }

        static async renderGoogleButton(
            containerSelector,
            options = {}
        ) {
            await this.initializeGoogle();

            const container = document.querySelector(
                containerSelector
            );

            if (!container) {
                throw new Error(
                    `Contenedor no encontrado: ${containerSelector}`
                );
            }

            container.replaceChildren();

            google.accounts.id.renderButton(container, {
                type: 'standard',
                theme: 'outline',
                size: 'large',
                text: 'continue_with',
                shape: 'pill',
                logo_alignment: 'left',
                width: Math.min(container.clientWidth || 300, 360),
                ...options
            });
        }

        static async handleGoogleCredential(response) {
            const credential = response?.credential;

            if (!credential) {
                this.finishFlow('google');

                this.emitError(
                    'google',
                    'No se recibieron las credenciales de Google.'
                );

                return;
            }

            // Google finished account selection.
            // Keep loading until Laravel responds.
            if (!this.markProcessing('google')) {
                this.startFlow('google');
                this.markProcessing('google');
            }

            await this.authenticate('google', {
                credential
            });
        }

        // ==========================================
        // FACEBOOK
        // ==========================================

        static initializeFacebook() {
            if (this.facebookInitialized) {
                return Promise.resolve();
            }

            if (this.facebookPromise) {
                return this.facebookPromise;
            }

            const config = this.getProviderConfig('facebook');

            if (!config.appId || !config.apiVersion) {
                return Promise.reject(new Error(
                    'Facebook App ID o versión del SDK no configurados.'
                ));
            }

            this.facebookPromise = new Promise((resolve, reject) => {
                const timeout = setTimeout(() => {
                    reject(new Error(
                        'No se pudo cargar Facebook SDK.'
                    ));
                }, 10000);

                window.fbAsyncInit = () => {
                    try {
                        FB.init({
                            appId: config.appId,
                            cookie: true,
                            xfbml: false,
                            version: config.apiVersion
                        });

                        clearTimeout(timeout);

                        this.facebookInitialized = true;
                        resolve();

                    } catch (error) {
                        clearTimeout(timeout);
                        reject(error);
                    }
                };

                if (!document.getElementById('facebook-jssdk')) {
                    const script = document.createElement('script');

                    script.id = 'facebook-jssdk';
                    script.src =
                        'https://connect.facebook.net/es_LA/sdk.js';
                    script.async = true;
                    script.onerror = () => {
                        clearTimeout(timeout);
                        reject(new Error(
                            'Error al descargar Facebook SDK.'
                        ));
                    };

                    document.head.appendChild(script);
                }
            }).catch(error => {
                this.facebookPromise = null;
                throw error;
            });

            return this.facebookPromise;
        }

        static loginFacebook() {
            if (this.isAuthenticating) return;

            if (!this.facebookInitialized || !window.FB) {
                this.emitError(
                    'facebook',
                    'Facebook todavía no está preparado.'
                );
                return;
            }

            // Llamar directamente desde el clic del usuario.
            FB.login(response => {

                if (!response?.authResponse?.accessToken) {
                    this.emit('social:auth:cancelled', {
                        provider: 'facebook'
                    });
                    return;
                }

                this.authenticate('facebook', {
                    access_token: response.authResponse.accessToken
                });

            }, {
                scope: 'public_profile,email',
                return_scopes: true
            });
        }

        // ==========================================
        // BACKEND AUTHENTICATION
        // ==========================================


        // ==========================================
// BACKEND AUTHENTICATION
// GOOGLE | FACEBOOK | SERVER
// ==========================================

        static async authenticate(provider, credentials = {}) {

            // ==========================================
            // 1. PREVENT DUPLICATE REQUESTS
            // ==========================================

            if (this.isAuthenticating) {
                return null;
            }

            let config;

            try {

                config = this.getProviderConfig(provider);

            } catch (error) {

                this.finishFlow(provider);

                this.emitError(provider, error.message);

                return null;
            }

            // ==========================================
            // 2. VALIDATE ENDPOINT
            // ==========================================

            if (!config.endpoint) {

                this.finishFlow(provider);

                this.emitError(
                    provider,
                    'No existe un endpoint configurado.'
                );

                return null;
            }

            // ==========================================
            // 3. VALIDATE ACTIVE FLOW
            // ==========================================

            // No permitir iniciar otro proveedor
            // mientras existe un flujo activo diferente.

            if (
                this.activeFlow &&
                this.activeFlow.provider !== provider
            ) {

                this.emitError(
                    provider,
                    'Existe otro proceso de autenticación en curso.'
                );

                return null;
            }

            // ==========================================
            // 4. AUTHENTICATION STATE
            // ==========================================

            this.isAuthenticating = true;

            // Google puede iniciar su flujo antes de recibir
            // las credenciales desde su SDK.
            //
            // Server y Facebook pueden iniciar directamente
            // cuando el usuario envía sus credenciales.

            if (!this.activeFlow) {

                this.startFlow(provider);
            }

            // Mantener el loading mientras Laravel responde.

            this.markProcessing(provider);

            this.emit('social:auth:loading', {
                provider
            });

            // ==========================================
            // 5. AJAX REQUEST
            // ==========================================

            try {

                const csrfToken =
                    $('meta[name="csrf-token"]').attr('content') ||
                    $('input[name="_token"]').first().val();

                const response = await $.ajax({

                    url: config.endpoint,

                    method: 'POST',

                    dataType: 'json',

                    headers: {
                        'X-CSRF-TOKEN': csrfToken || '',
                        'Accept': 'application/json'
                    },

                    data: credentials,

                    timeout: 30000
                });

                // ======================================
                // 6. VALIDATE BACKEND RESPONSE
                // ======================================

                if (!response || response.success !== true) {

                    const backendError = new Error(
                        response?.msg ||
                        response?.message ||
                        'No se pudo completar la autenticación.'
                    );

                    // Conservar la respuesta para el catch.
                    backendError.responseJSON = response || {};

                    throw backendError;
                }

                // ======================================
                // 7. AUTHENTICATION SUCCESS
                // ======================================

                this.emit('social:auth:success', {
                    provider,
                    response
                });

                return response;

            } catch (error) {

                // ======================================
                // 8. AUTHENTICATION ERROR
                // ======================================

                const response = error.responseJSON || {};

                // Laravel puede retornar errores mediante:
                //
                // response.errors
                // response.error.details
                //
                // Compatible con Google, Facebook y Server.

                const validationErrors = {
                    ...(response.errors || {}),
                    ...(response.error?.details || {})
                };

                // Obtener el primer mensaje de validación,
                // independientemente del campo o proveedor.

                const firstValidationError = Object.values(
                    validationErrors
                ).flat(Infinity).find(value =>
                    typeof value === 'string' && value.length > 0
                );

                const message =
                    firstValidationError ||
                    response.msg ||
                    response.message ||
                    error.message ||
                    'Error durante la autenticación.';

                const errorCode =
                    response.error?.code ||
                    response.code ||
                    'AUTH_ERROR';

                const errorStep =
                    response.error?.step ||
                    null;

                const status =
                    error.status ||
                    null;

                // ======================================
                // EMIT GENERIC ERROR
                // ======================================

                this.emit('social:auth:error', {

                    provider,

                    message,

                    code: errorCode,

                    step: errorStep,

                    status,

                    details: validationErrors,

                    response
                });

                return null;

            } finally {

                // ======================================
                // 9. RELEASE AUTHENTICATION STATE
                // ======================================

                this.isAuthenticating = false;

                this.finishFlow(provider);

                this.emit('social:auth:finished', {
                    provider
                });
            }
        }


        // ==========================================
        // EVENTS
        // ==========================================

        static emit(eventName, detail = {}) {
            $(document).trigger(eventName, [detail]);
        }

        static emitError(provider, message) {
            this.emit('social:auth:error', {
                provider,
                message
            });
        }

// ==========================================
// EVENTS
// ==========================================

        static bindEvents() {

            // ======================================
            // 1. FACEBOOK
            // ======================================

            $(document)
                .off(
                    'click.socialLogin',
                    '[data-social-login="facebook"]'
                )
                .on(
                    'click.socialLogin',
                    '[data-social-login="facebook"]',
                    event => {

                        event.preventDefault();

                        this.loginFacebook();
                    }
                );

            // ======================================
            // 2. SERVER - INPUT VALIDATION
            // ======================================

            $(document)
                .off(
                    'input.socialServer',
                    '#yapitaRegisterEmail, #yapitaRegisterPassword'
                )
                .on(
                    'input.socialServer',
                    '#yapitaRegisterEmail, #yapitaRegisterPassword',
                    () => {

                        this.validateServerForm();

                        $('#yapitaRegisterFeedback').text('');
                    }
                );

            // ======================================
            // 3. SERVER - FORM SUBMIT
            // ======================================

            $(document)
                .off(
                    'submit.socialServer',
                    '#yapitaRegisterForm'
                )
                .on(
                    'submit.socialServer',
                    '#yapitaRegisterForm',
                    async event => {

                        event.preventDefault();

                        await this.registerServer();
                    }
                );

            // ======================================
            // 4. SERVER - PASSWORD VISIBILITY
            // ======================================

            $(document)
                .off(
                    'click.socialServer',
                    '.yapita-register-form__toggle-password'
                )
                .on(
                    'click.socialServer',
                    '.yapita-register-form__toggle-password',
                    function () {
console.log("adad")
                        const $button = $(this);

                        const $input = $('#yapitaRegisterPassword');

                        const isVisible =
                            $input.attr('type') === 'text';

                        $input.attr(
                            'type',
                            isVisible ? 'password' : 'text'
                        );

                        $button.attr(
                            'aria-pressed',
                            String(!isVisible)
                        );

                        $button.attr(
                            'aria-label',
                            isVisible
                                ? 'Mostrar contraseña'
                                : 'Ocultar contraseña'
                        );

                        $button.find('i')
                            .toggleClass('bi-eye', isVisible)
                            .toggleClass('bi-eye-slash', !isVisible);
                    }
                );
        }

        // ==========================================
        // LOGOUT GOOGLE STATE
        // ==========================================

        static disableGoogleAutoSelect() {
            if (window.google?.accounts?.id) {
                google.accounts.id.disableAutoSelect();
            }
        }

        // ==========================================
// SERVER - FORM VALIDATION
// ==========================================

        static validateServerForm() {

            const email = String(
                $('#yapitaRegisterEmail').val() || ''
            ).trim();

            const password = String(
                $('#yapitaRegisterPassword').val() || ''
            );

            const emailValid =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email) &&
                email.length <= 255;

            const passwordValid =
                password.length >= 8 &&
                password.length <= 128;

            const valid = emailValid && passwordValid;

            const isBusy =
                this.isAuthenticating ||
                this.activeFlow !== null;

            $('#yapitaRegisterSubmit').prop(
                'disabled',
                !valid || isBusy
            );

            return {
                valid,
                email,
                password,
                emailValid,
                passwordValid
            };
        }
        // ==========================================
// SERVER - REGISTER USER
// ==========================================

        static async registerServer() {

            // ======================================
            // 1. PREVENT DUPLICATE REQUESTS
            // ======================================

            if (this.isAuthenticating || this.activeFlow) {
                return null;
            }

            // ======================================
            // 2. VALIDATE FORM
            // ======================================

            const form = this.validateServerForm();

            $('#yapitaRegisterEmailError').text('');
            $('#yapitaRegisterPasswordError').text('');
            $('#yapitaRegisterFeedback').text('');

            if (!form.emailValid) {

                $('#yapitaRegisterEmailError')
                    .text('Ingresa un correo electrónico válido.');

                return null;
            }

            if (!form.passwordValid) {

                $('#yapitaRegisterPasswordError')
                    .text('La contraseña debe tener entre 8 y 128 caracteres.');

                return null;
            }

            // ======================================
            // 3. SEND TO BACKEND
            // ======================================

            return await this.authenticate('server', {
                email: form.email,
                password: form.password
            });
        }
    }
    window.SocialNetworkLoginUtil=SocialNetworkLoginUtil;

    async function initGoogleLoginButton() {
        try {
            await SocialNetworkLoginUtil.renderGoogleButton(
                '#yapita-google-login',
                {
                    type: 'standard',
                    theme: 'outline',
                    size: 'large',
                    text: 'continue_with',
                    shape: 'pill',
                    logo_alignment: 'left'
                }
            );

            console.log('[Yapita] Google listo');

        } catch (error) {
            console.error('[Yapita] Error Google:', error);
        }
    }
    function initSocialLoginModal() {

        $(document)
            .off('shown.bs.modal.yapitaSocial', '#yapitaRegisterModal')
            .on(
                'shown.bs.modal.yapitaSocial',
                '#yapitaRegisterModal',
                async function () {

                    try {
                        await SocialNetworkLoginUtil.renderGoogleButton(
                            '#google-login-button'
                        );

                    } catch (error) {
                        console.error(
                            '[Yapita Google Login]',
                            error.message
                        );

                        $('#social-login-error')
                            .text(error.message)
                            .removeClass('d-none');
                    }
                }
            );
    }

</script>
