
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


        static async authenticate(provider, credentials) {

            // ==========================================
            // 1. PREVENT DUPLICATE REQUESTS
            // ==========================================

            if (this.isAuthenticating) return null;

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
            // 3. AUTHENTICATION STATE
            // ==========================================

            this.isAuthenticating = true;

            // Google already started its flow on button click.
            // Only create one if it does not exist.
            if (!this.activeFlow) {
                this.startFlow(provider);
            }

            // Keep the loading active during the AJAX request.
            this.markProcessing(provider);

            this.emit('social:auth:loading', {
                provider
            });

            // ==========================================
            // 4. AJAX REQUEST
            // ==========================================

            try {
                const response = await $.ajax({
                    url: config.endpoint,
                    method: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $(
                            'meta[name="csrf-token"]'
                        ).attr('content'),
                        'Accept': 'application/json'
                    },
                    data: credentials,
                    timeout: 30000
                });

                // ======================================
                // 5. VALIDATE BACKEND RESPONSE
                // ======================================

                if (!response.success) {
                    throw new Error(
                        response.msg ||
                        response.message ||
                        'No se pudo iniciar sesión.'
                    );
                }

                // ======================================
                // 6. AUTHENTICATION SUCCESS
                // ======================================

                this.emit('social:auth:success', {
                    provider,
                    response
                });

                return response;

            } catch (error) {

                // ======================================
                // 7. AUTHENTICATION ERROR
                // ======================================

                const response = error.responseJSON || {};

                const message =
                    response.errors?.credential?.[0] ||
                    response.errors?.access_token?.[0] ||
                    response.msg ||
                    response.message ||
                    error.message ||
                    'Error durante la autenticación.';

                this.emit('social:auth:error', {
                    provider,
                    message,
                    code: response.error?.code || 'AUTH_ERROR',
                    step: response.error?.step || null,
                    status: error.status || null
                });

                return null;

            } finally {

                // ======================================
                // 8. RELEASE AUTHENTICATION STATE
                // ======================================

                this.isAuthenticating = false;

                // Remove loading and unblock the selected button.
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

        static bindEvents() {
            $(document)
                .off('click.socialLogin', '[data-social-login="facebook"]')
                .on(
                    'click.socialLogin',
                    '[data-social-login="facebook"]',
                    event => {
                        event.preventDefault();
                        this.loginFacebook();
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
