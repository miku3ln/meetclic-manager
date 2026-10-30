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
        YapitaRewardModalUtil.init();
        // ==========================================
        // AUTH SUCCESS
        // ==========================================
// ==========================================
// YAPITA - SOCIAL AUTH SUCCESS
// ==========================================

        $(document)
            .off('social:auth:success.maskana')
            .on('social:auth:success.maskana', function (event, detail) {

                const { provider, response } = detail || {};

                // ==========================================
                // 1. VALIDAR AUTENTICACIÓN
                // ==========================================

                if (response?.success !== true) {
                    return;
                }

                console.log(
                    '[Social Login] Autenticación correcta:',
                    provider,
                    response
                );

                // ==========================================
                // 2. OBTENER INFORMACIÓN
                // ==========================================

                const user = response?.data?.user;

                const gamification = response?.data?.gamification;

                const isCreate = user?.isCreate === true;

                const rewardSuccess =
                    gamification?.success === true &&
                    gamification?.data?.reward?.success === true;

                // ==========================================
                // 3. USUARIO EXISTENTE
                // ==========================================

                if (!isCreate || !rewardSuccess) {

                    window.location.reload();
                    return;
                }

                // ==========================================
                // 4. CERRAR MODAL DE REGISTRO
                // ==========================================

                const registerModalElement = document.getElementById(
                    'yapitaRegisterModal'
                );

                if (!registerModalElement) {

                    YapitaRewardModalUtil.show(response);

                    return;
                }

                const registerModal = bootstrap.Modal.getInstance(
                    registerModalElement
                );

                // ==========================================
                // 5. ESPERAR CIERRE DEL MODAL ANTERIOR
                // ==========================================

                if (
                    registerModal &&
                    registerModalElement.classList.contains('show')
                ) {

                    $(registerModalElement)
                        .one('hidden.bs.modal', function () {

                            YapitaRewardModalUtil.show(response);

                        });

                    registerModal.hide();

                } else {

                    YapitaRewardModalUtil.show(response);

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
    function initFilters(){
        MaskanaBottomSheetUtil.init();
        MaskanaBottomSheetTabsUtil.init();
        MaskanaPrizesUtil.init();

        // Cuando abre
        $(document).on('maskana:sheet:opened', function (event, detail) {
            console.log('[Maskana Sheet] Abierto', detail);
        });

        // Cuando cierra
        $(document).on('maskana:sheet:closed', function (event, detail) {
            console.log('[Maskana Sheet] Cerrado', detail);
        });
    }
    $(document).ready(function () {
        initFilters();
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
