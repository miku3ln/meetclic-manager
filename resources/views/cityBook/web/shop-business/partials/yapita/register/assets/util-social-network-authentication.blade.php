@include('partials.auth.social-network.social-network')
<script>

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
