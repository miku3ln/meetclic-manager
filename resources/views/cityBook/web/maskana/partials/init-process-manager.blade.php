<script>
    async function initSocialNetwork(params) {
        SocialNetworkLoginUtil.init(
            window.SocialNetworkConfig
        );

        if (window.SocialNetworkConfig?.facebook?.enabled) {
            try {
                await SocialNetworkLoginUtil.initializeFacebook();
            } catch (error) {
                console.error('[Facebook SDK]', error.message);
            }
        }
    }
    function initSocialLoginEvents() {

        // ==========================================
        // AUTH SUCCESS
        // ==========================================
        $(document)
            .off('social:auth:success.maskana')
            .on('social:auth:success.maskana', function (event, detail) {

                const { provider, response } = detail;

                if (response?.success === true) {

                    console.log(
                        '[Social Login] Autenticación correcta:',
                        provider
                    );

                    // Recargar para actualizar la sesión,
                    // menú, usuario y permisos de la página.
                    window.location.reload();
                }
            });


        // ==========================================
        // AUTH ERROR
        // ==========================================
        $(document)
            .off('social:auth:error.maskana')
            .on('social:auth:error.maskana', function (event, detail) {

                console.error('[Social Login] Error:', detail);

                alert(
                    detail.message ||
                    'No se pudo iniciar sesión. Inténtalo nuevamente.'
                );
            });
    }
    $(document).ready(function () {
        initSocialLoginEvents();
        initSocialNetwork();
        $(document).on('click', '.yapita-register__content', function (event) {
            event.preventDefault();

            openYapitaRegisterModal();
        });
        initModalYapita();
        initFiltersRoutes();
        BusinessMapHtmlUtil.initDetailInteractions();
        document.addEventListener(
            'business:marker:dragend',
            async function (event) {
                const data = event.detail;
                console.log('data:', data);
                console.log('business: bmz_manager_id', data.business.bmz_manager_id);
                console.log('Empresa:', data.business_id);
                console.log('Latitud:', data.latitude);
                console.log('Longitud:', data.longitude);
                if ($isLoggedIn) {
                    await updateLocationBusinessMaskana({
                        business_id: data.business_id,
                        latitude: data.latitude,
                        longitude: data.longitude,
                        bmz_manager_id: data.business.bmz_manager_id
                    });
                }

            }
        );

        const businessResponseData = new window.BusinessResponseData();
        initManager();
        initBusinessCategoriesSelect2();
        initManagerFilters({
            onApply: function (params) {
                console.log(params);

            }
        });

        Object.defineProperty(managerBusiness, 'data', {
            get() {
                return this._data;
            },

            set(newData) {
                if (this._data === newData) return;
                const oldData = this._data;
                this._data = newData;
                $(document).trigger('managerBusiness:dataChanged', [
                    newData,
                    oldData
                ]);
            },

            enumerable: true,
            configurable: true
        });


        $(document).on(
            'managerBusiness:dataChanged.businessMap',
            function (event, newData, oldData) {

                businessResponseData.render(newData);
                businessResponseData.renderMapHint();
            }
        );


    });
</script>
