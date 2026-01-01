{{-- BUSINESS DETAILS--VIEW  --}}
@extends('layouts.cityBook')
@section('additional-styles')
    @include('cityBook.web.partials.businessPullkay.assets.css.grid-style',array())

    <style>
        .pagination > .active > a {
            color: #e4e4e4;
            background-color: #f08124 !important;
            border-color: #f08124 !important;
        }

        .section--full-img {
            padding: 0 0;
        }

        h1.title {
            float: left;
            width: 100%;
            text-align: center;
            color: #4db7fe;
            font-size: 34px;
            font-weight: 700;
        }

        img.img-svg-full {
            width: 88%;
        }





        .btn {
            color: #f08124 !important;
        }

        .text-left {

            font-size: 26px;
            text-align: left;
        }

        .text-left a {
            color: #4d4c4c !important;
        }

        .form-group {
            text-align: left;

        }

        select#typeDictionary {
            font-size: 21px;
        }

        label.form__label {
            color: #225278;
            font-size: 24px;
        }

        .bootgrid-footer--fixed {
            padding-right: 7% !important;
            padding-left: 6% !important;
            width: 80%;
            position: fixed;
            top: 77%;
        }

        ul.pagination li {
            cursor: pointer;
        }

        a {

            text-decoration: none !important;
        }

        span.content-description__title {
            color: #4d4c4c;
            font-size: 22px;
            font-weight: bold;
        }

        span.word--fonetic {
            color: #f08124;
        }

        input.search-field.form-control {
            height: calc(1.5em + 2.75rem + 2px);
            /* width: 100%; */
        }

        .search {
            width: 45% !important;;
        }

        .container--manager-dictionary {

            width: 100%;
            padding: 0 10% 0 10%;
            position: relative;
            z-index: 5;
        }

        .custom-scroll-admin-grid {
            height: 450px;
            overflow-y: scroll;
            overflow-x: hidden;
        }

        .input-group-addon {
            font-size: 26px !important;
            color: #fff !important;;
            background-color: #f08124 !important;
            border: 0 solid #f08124 !important;;
            border-radius: 0 !important;;
        }

        @media screen and (min-width: 300px) and (max-width: 768px) {
            .table-responsive {

                border: 0 solid #ddd !important;
                overflow-y: unset !important;
            }

            .search {
                width: 100% !important;
            }

            .bootgrid-footer .search, .bootgrid-header .search {
                margin: 0 20px 13px 0 !important;
            }

            .intro-item.fl-wrap {
                padding-top: 35% !important;
            }

            .infoBar {
                margin-top: 54px !important;
                padding-right: 0 !important;
                padding-left: 0 !important;
                position: initial !important;
            }

            .pagination a {
                width: 30px !important;
                height: 30px !important;
            }

            .hero-section .intro-item h2 {
                font-size: 54px !important;

            }


            span.content-description__title {

                font-size: 11px !important;

            }

            .word--description {
                display: block !important;
                align-items: center !important;
            }

            img.content-description__photos--img {
                height: 70px !important;
                width: 70px !important;
            }

            .content {
                height: auto !important;
            }
        }


        table#product-grid {
            width: 100%;
        }

    </style>


    <link href="{{ asset($resourcePathServer."plugins/bootgrid-2024/bootstrap.css") }}" rel="stylesheet"
          type="text/css">
    <link href="{{ asset($resourcePathServer."plugins/bootgrid-2024/jquery.bootgrid.min.css") }}" rel="stylesheet"
          type="text/css">
    <link type="text/css" rel="stylesheet"
          href="{{ URL::asset($resourcePathServer . 'libs/metis-menu/metisMenu.min.css') }}">
    <link type="text/css" rel="stylesheet"
          href="{{ asset($resourcePathServer . 'plugins/whatsapp-chat-support/whatsapp-chat-support.css') }}">
    <link rel="stylesheet" href="{{asset($resourcePathServer.'plugins/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset($resourcePathServer.'plugins/slick/slick-theme.css')}}">
    <link rel="stylesheet"
          href="{{asset($resourcePathServer.'plugins/jquery-confirm/jquery-confirm.min.css')}}">
    @include('partials.plugins.resourcesCss',['bootgrid'=>true])
    @include('partials.plugins.resourcesCss',['toast'=>true])
   <style>


        .btn-sm {
            padding: 5px 10px !important;
            font-size: 12px !important;;
            line-height: 1.5 !important;;
            border-radius: 3px !important;;
        }
        img.content-description__photos--img {
            height: 140px;
            width: 140px;
        }

        .content-description {
            padding-top: 9px;
            padding-bottom: 9px;
        }

        .btn {
            color: #445ef2 !important;
        }

        .bootgrid-footer--fixed {
            padding-right: 7% !important;
            padding-left: 6% !important;
            width: 80%;
            position: fixed;
            top: 77%;
        }

        ul.pagination li {
            cursor: pointer;
        }

        a {

            text-decoration: none !important;
        }

        .content-description__information {
            display: flex; /* Hace que los elementos hijos se muestren en línea horizontalmente */
            align-items: center; /* Alinea los elementos verticalmente */
        }

        .content-description__title {
            margin-right: 10px; /* Espacio entre el título y el contenido */
        }

        .word--description {
            display: flex; /* Para que el contenido dentro también se muestre en línea horizontal */
            align-items: center; /* Alinea el contenido verticalmente */
        }

        .word--fonetic {
            margin-right: 5px; /* Espacio entre el fonético y el texto */
        }

        .word--description p {
            margin: 0; /* Elimina el margen predeterminado del párrafo */
        }

        span.content-description__title {
            color: #445ef2;
            font-size: 22px;
            font-weight: bold;
        }

        span.word--fonetic {
            color: #e5bf4e;
        }

        input.search-field.form-control {
            height: calc(1.5em + 2.75rem + 2px);
            /* width: 100%; */
        }

        .search{
            width: 45% !important; ;
        }

        .container--manager-dictionary {

            width: 100%;
            padding: 0 10% 0 10%;
            position: relative;
            z-index: 5;
        }

        .custom-scroll-admin-grid {
            height: 450px;
            overflow-y: scroll;
            overflow-x: hidden;
        }
        @media screen and (min-width: 300px) and (max-width: 768px){
            .table-responsive {
                width: 100% !important;
                margin-bottom: 0px !important;
                overflow-y: unset !important;
            }
            .search.form-group {
                width: 100% !important;
            }
            .hero-section .intro-item h2 {
                font-size: 54px !important;

            }
            .intro-item.fl-wrap {
                padding-top: 35% !important;
            }
            .infoBar {
                margin-top: 54px !important;
                padding-right: 0 !important;
                padding-left: 0 !important;
                position: initial !important;
            }
            span.content-description__title {

                font-size: 11px !important;

            }
            .word--description {
                display: block !important;
                align-items: center !important;
            }
            img.content-description__photos--img {
                height: 70px !important;
                width: 70px !important;
            }
            .nav-button-wrap {

                margin-right: -27% !important;
            }
        }
    </style>

@endsection

@section('additional-scripts')
    <script src="{{ asset($resourcePathServer."plugins/bootgrid-2024/bootstrap.min.js") }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer."plugins/bootgrid-2024/jquery.bootgrid.min.js") }}"
            type="text/javascript"></script>
    <!--CONFIRM-->
    @include('partials.plugins.resourcesJs',['summerNote'=>true])
    <script src="{{ asset($resourcePathServer . 'plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>

    <script>
        function getDataStructure(params) {
            var type = params['type'];
            var result = {};
            if (type == 0) {
                result = {
                    managerLoading: {
                        data: {
                            view: true
                        },
                        page: {
                            view: true
                        }
                    },
                    managerData: {},
                    businessData: [],
                    configGridAdmin: {
                        html: '',
                        isEmpty: false,
                        msj: {
                            empty: '<h1>No existe Datos</h1>',
                        }
                    },
                    configPagination: {
                        items: [],
                        itemActive: 0,
                        totalData: 0,
                        rowCountPerPage: 0,
                        currentPage: 0,
                        html: '',
                        view: {
                            init: 0,
                            to: 0,
                        }
                    },
                    model: {
                        review: {
                            attributes: {
                                'rating': null,
                                'user_id': 1,
                                'name_full': '',
                                'email': '',
                                'description': '',
                            }
                        },
                        search: {
                            needle: ''
                        }

                    },
                    networkShares: [{
                        type: 0,
                        icon: 'share-icon share-icon-facebook',
                        allow: true
                    },
                        {
                            type: 1,
                            icon: 'share-icon share-icon-twitter',
                            allow: false
                        },
                        {
                            type: 2,
                            icon: 'share-icon share-icon-googleplus',
                            allow: false
                        },
                        {
                            type: 3,
                            icon: 'share-icon fa fa-whatsapp',
                            allow: false
                        },
                    ],
                    configModalManagementFormDetailsProduct: {
                        viewAllow: false,
                        data: {}
                    },
                    configModalManagementFormShare: {
                        viewAllow: false,
                        data: {}
                    }
                };
            } else if (type == 1) {
                result = {
                    managerLoading: {
                        data: {
                            view: true
                        },
                        page: {
                            view: true
                        }
                    },
                    managerData: {},
                    businessData: [],
                    configGridAdmin: {
                        html: '',
                        isEmpty: false,
                        msj: {
                            empty: '<h1>No existe Datos</h1>',
                        }
                    },
                    configPagination: {
                        items: [],
                        itemActive: 0,
                        totalData: 0,
                        rowCountPerPage: 0,
                        currentPage: 0,
                        html: '',
                        view: {
                            init: 0,
                            to: 0,
                        }
                    },
                    model: {
                        review: {
                            attributes: {
                                'rating': null,
                                'user_id': 1,
                                'name_full': '',
                                'email': '',
                                'description': '',
                            }
                        },
                        search: {
                            needle: ''
                        }

                    },
                    networkShares: [{
                        type: 0,
                        icon: 'share-icon share-icon-facebook',
                        allow: true
                    },
                        {
                            type: 1,
                            icon: 'share-icon share-icon-twitter',
                            allow: false
                        },
                        {
                            type: 2,
                            icon: 'share-icon share-icon-googleplus',
                            allow: false
                        },
                        {
                            type: 3,
                            icon: 'share-icon fa fa-whatsapp',
                            allow: true
                        },
                    ],

                    configModalManagementFormDetailsProduct: {
                        viewAllow: false,
                        data: {}
                    },

                    filtersData: {
                        'categories': [],
                        'subcategories': [],

                    },
                    niceConfigAllow: {
                        subcategories: false,
                        subcategoryImage: false
                    },
                    configFilters: {
                        subcatetory: {
                            img: null,
                            'title': '',
                        }
                    },
                    configModalManagementFormShare: {
                        viewAllow: false,
                        data: {}
                    }
                };
            }

            return result;
        }

        function _eventsProfile() {
            $scope = this;
            $('#whatsapp-contact-profile').on('click', function () {
                /*   $hrefCurrent = $scope.getUrlContact();
                   window.open($hrefCurrent);
                   $('#whatsapp-contact-profile').attr('link-current', $hrefCurrent);*/

            });
        }

        var $dataManagerPage = <?php echo json_encode($dataManagerPage); ?>;

        function getDataShare() {
            var businessData = $dataManagerPage['business'];
            var hrefCurrent = businessData.hasOwnProperty('urlBusiness') ? businessData
                .urlBusiness : 'meetclic.com';

            var result = {
                title: businessData.information.category + '-' + businessData.information.title,
                description: businessData.aboutUs.hasOwnProperty('description') ? businessData
                    .aboutUs.description : 'Not Description.',
                quote: "Comparte,Gana muchos premios con meetclic.",
                hashtags: "meetclic,products,migu3ln",
                'twitter-user': "vuejs",
                method: 'share',
                href: hrefCurrent,
                picture: businessData.information.srcMain,
                caption: businessData.information.category,
            };
            return result;
        }


        function getUrlContact() {

            var params = {
                dataParams: {
                    phone: $dataManagerPage.business['contactUs']['phone'],
                    text: 'Informacion sobre sus productos o Servicios by Meetclic.',


                }
            };
            var typeSmarth = getMobileOperatingSystem();
            var urlRoot = '';
            switch (typeSmarth) {
                case 'unknown':
                    urlRoot = 'https://web.whatsapp.com/send?';
                    break;

                case 'Android':

                    params = {
                        dataParams: {
                            text: 'Informacion sobre sus productos o Servicios by Meetclic.',
                        }
                    };
                    urlRoot = 'https://wa.me/' + $dataManagerPage.business['contactUs']['phone'] + '?';

                    break;
                case 'iOS':

                    params = {
                        dataParams: {
                            text: 'Informacion sobre sus productos o Servicios by Meetclic.',
                        }
                    };
                    urlRoot = 'https://wa.me/' + $dataManagerPage.business['contactUs']['phone'] + '?';
                    break;

            }
            var urlCurrent = urlRoot + getStringParamsGet(params);
            var result = urlCurrent;
            return result;
        }

        function _shareType(network) {

            var paramsShare = this.getDataShare();
            if (network.type == 0) {
                FB.ui(
                    paramsShare,
                    // callback
                    function (response) {
                        if (response && !response.error_message) {
                            var textManager = 'Se compartio con exito.';
                            $.NotificationApp.send({
                                heading: "Informacion!",
                                text: textManager,
                                position: 'bottom-left',
                                loaderBg: '#53BF82',
                                icon: 'success',
                                hideAfter: 5000

                            });
                        } else {
                            console.log('Error while posting.');
                        }
                    }
                );
            } else if (network.type == 3) {
                var dataCurrent = {
                    id: 1
                };
                this.configModalManagementFormShare.viewAllow = true;
                this.configModalManagementFormShare.data = dataCurrent;
            }

        }

        function _managementProductDetails() {

            var dataCurrent = JSON.parse($('#management-product-details').attr('row-data'));
            this.configModalManagementFormDetailsProduct.viewAllow = true;
            this.configModalManagementFormDetailsProduct.data = dataCurrent;
        }

        function _searchData(searchData) {
            if (searchData.length > 2) {
                $(selectorGrid).bootgrid("search", searchData);
            } else if (searchData.length == 0) {
                $(selectorGrid).bootgrid("search", '');

            }
        }

        function initGridShop(params) {
            var elementInit = params.elementInit;
            console.log('initGridShop');
            InitGridManager();
            initEventsFilters();
        }

        function initShareWhatsapp($scope) {
            $hrefCurrent = $scope.getUrlContact();
            $('#whatsapp-contact__a').attr('href', $hrefCurrent);
            var dataSupport = {
                'data-number': $dataManagerPage.business['contactUs']['phone']
            };
            var defaultMsg = "Informacion sobre sus productos o Servicios by Meetclic http://meetclic.com/";
            $(".wcs_popup_input").attr('data-number', dataSupport['data-number']);

            $('#example_4').whatsappChatSupport({
                defaultMsg: defaultMsg,
            });

        }


        var componentThisManagementFormShare;
        Vue.component('management-form-share-component', {
            template: '#management-form-share-template',
            directives: {},
            props: {
                params: {
                    type: Object,
                }
            },
            created: function () {
                this.initDataComponent(this.params);
            },
            beforeMount: function () {
                console.log('beforeMount');

            },
            mounted: function () {
                console.log('mounted');
                componentThisManagementFormShare = this;
                this.initCurrentComponent();


            },
            validations: function () {
                var attributes = {
                    "number_phone": {
                        required
                    },

                };

                var result = {
                    model: { //change
                        attributes: attributes
                    },
                };
                return result;

            },
            data: function () {

                var dataManager = {
                    model_id: null,
                    /*  ----MANAGER ENTITY---*/
                    configParams: {},
                    labelsConfig: {
                        "title": "Compartir en Whatsapp",
                        "event": "",

                        buttons: {
                            return: "Regresar",
                            verify: "Verificar",
                            manager: "Compartir."
                        },
                        msg: {
                            'loading': "Cargando....."
                        }
                    },
                    tabCurrentSelector: '#modal-management-form-share',
                    processName: "Registro Acción.",
                    model: {
                        attributes: this.getAttributesForm(),
                        structure: this.getStructureForm(),
                    },
                    modelAux: [],
                    modelView: [],
                    managementViews: {
                        previewLoading: true,
                        managementForm: false,
                        managementType: 0,
                        data: {}
                    }

                };


                return dataManager;
            },
            methods: {
                onListenElementsForm: onListenElementsForm,
                initDataComponent: function (params) {
                    this.modelAux = params;
                    this.configParams = params;
                    var dataCurrent = params['data'];
                    this.managementViews.managementForm = true;
                },

                initCurrentComponent: function () {

                    this.initDataModal();
                    this.$refs.refManagementFormShareModal.show();
                },

                /*modal events*/
                _resetComponent: function () {
                    this._emitToParent({
                        type: 'resetComponent',
                        'componentName': 'configModalManagementFormShare'
                    });
                },
                _showModal: function () {
                    /*    this.resetForm();*/

                },
                _hideModal: function () {
                    this._resetComponent();

                },

                _cancel: function () {
                    this.$refs.refManagementFormShareModal.hide();
                    this._resetComponent();

                },
                initDataModal: function () {
                    var rowCurrent = this.configParams.data;
                    var managementType = this.managementViews.managementType;
                },
                _setValueOfParent: function (params) {
                    if (params.type == "openModal") {
                        this.configParams = params.data;
                        this.initDataModal();
                        this.$refs.refManagementFormShareModal.show();

                    }
                },
                _emitToParent: function (params) {
                    this.$root.$emit('_productRowGrid', params);
                },

                //EVENTS OF CHILDREN
                _managerTypes: function (emitValues) {
                    if (emitValues.type == "rebootGrid") {


                    }
                },

                managementData: function (params) {

                },
                //MANAGER PROCESS

                //FORM CONFIG
                getValuesSave: function () {

                    var result = {

                        "number_phone": this.$v.model.attributes.number_phone.$model,


                    };


                    return result;
                },
                _setValueForm: _setValueForm,
                validateForm: function () {
                    var currentAllow = this.getValidateForm();
                    return currentAllow.success;
                },
                getValidateForm: getValidateForm,
                resetForm: resetForm,
                _saveModel: function () {

                    var businessData = $dataManagerPage['business'];
                    var hrefCurrent = businessData.hasOwnProperty('urlBusiness') ? businessData
                        .urlBusiness : 'meetclic.com';
                    var phoneCurrent = this.model.attributes.number_phone;
                    var textCurrent = 'Informacion Empresa ' + '"' + hrefCurrent + '"';
                    var params = {
                        dataParams: {
                            phone: phoneCurrent,
                            text: textCurrent
                        }
                    };
                    console.log(params);
                    var typeSmarth = getMobileOperatingSystem();
                    var urlRoot = '';
                    switch (typeSmarth) {
                        case 'unknown':
                            urlRoot = 'https://web.whatsapp.com/send?';
                            break;

                        case 'Android':

                            params = {
                                dataParams: {
                                    text: textCurrent,
                                }
                            };
                            urlRoot = 'https://wa.me/' + phoneCurrent + '?';

                            break;
                        case 'iOS':

                            params = {
                                dataParams: {
                                    text: textCurrent,
                                }
                            };
                            urlRoot = 'https://wa.me/' + phoneCurrent + '?';
                            break;

                    }
                    var urlCurrent = urlRoot + getStringParamsGet(params);
                    var result = urlCurrent;

                    window.open(result);

                },
                getViewErrorForm: function (objValidate) {
                    var result = false
                    if (!objValidate.$dirty) {
                        result = objValidate.$dirty ? (!objValidate.$error) : false;
                    } else {
                        result = objValidate.$error;
                    }
                    return result;
                },
                _submitForm: function (e) {
                    console.log(e);
                },
                getStructureForm: function () {
                    var result = {

                        number_phone: {
                            id: "number_phone",
                            name: "number_phone",
                            label: "Numero de Celular",
                            required: {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }

                        },


                    };
                    return result;
                },
                getAttributesForm: function () {
                    var result = {
                        "number_phone": '',


                    };
                    return result;
                },

                getNameAttribute: function (name) {
                    var result = name;
                    return result;
                },
                getLabelForm: viewGetLabelForm,

                getClassErrorForm: function (nameElement, objValidate) {
                    var result = null;
                    result = {
                        "form-group--error": objValidate.$error,
                        'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
                    };

                    return result;
                }
            }
        });

    </script>

    <script>
        $productDetailsRoute = "{{ route('productDetails', ['id' => 'change', 'language' => app()->getLocale()]) }}";

        function initEvents() {
            $(".fa-whatsapp--set").on("click", function () {
                $(".fa.fa-play.icon-hover").click();
            });
        }

        $(function () {
            initEvents();
            $(".container").addClass("container__full");
        });
    </script>
    <script src="{{ asset($resourcePathServer . 'libs/vue-bootstrap/vue-bootstrap.min.js') }}"></script>
    <script src="{{ asset($resourcePathServer . 'js/vue/directives/main.js') }}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer . 'js/vue/components/main.js') }}" type='text/javascript'></script>
    @include('partials.plugins.resourcesJs',['bootgrid'=>true])
    @include('partials.plugins.resourcesJs',['toast'=>true])


    <script src="{{ URL::asset($resourcePathServer . 'assets/js/pages/toastr.init.js') }}"></script>
    <script src="{{ URL::asset($resourcePathServer . 'js/cityBook/web/businessDetails/shop.js') }}"></script>

    <script src="{{ URL::asset($resourcePathServer . 'libs/metis-menu/metismenu.js') }}"></script>
    <script src="{{ asset($resourcePathServer . 'js/frontend/web/ManagementFormDetailsProduct.js') }}"></script>

    @include('layouts.partials.managementFormShare',array())
    @include('cityBook.web.partials.businessPullkay.assets.js.typeOne',array())


    <script src="{{ asset($resourcePathServer . 'plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset($resourcePathServer . 'plugins/moment/moment-timezone-with-data-10-year-range.min.js') }}">
    </script>

    <script src="{{ asset($resourcePathServer . 'plugins/whatsapp-chat-support/whatsapp-chat-support.js') }}"></script>
@endsection
@section('content')
    <div id="app-management">
        <button id="management-product-details" class="not-view"></button>

        <div id="management-product-details">
            <div v-if="configModalManagementFormDetailsProduct.viewAllow">


                <management-form-details-product-component ref="refManagementFormDetailsProduct"
                                                           :params="configModalManagementFormDetailsProduct"></management-form-details-product-component>
            </div>
        </div>
        <div id="management-share-type">
            <div v-if="configModalManagementFormShare.viewAllow">

                <management-form-share-component ref="refManagementFormShare" :params="configModalManagementFormShare">
                </management-form-share-component>
            </div>
        </div>
        <input id="action-manager-business-gamification" type="hidden"
               value="{{ route('getAdminGamificationFrontend') }}"/>


        @include('cityBook.web.partials.businessPullkay.registers')

        <!--section -->
        @if (!Auth::check())
            @include('layouts.partials.cityBook.join')
        @endif



        @endsection
    </div>
    @section('buttonsManagerFooter')

        <div class="whatsapp_chat_support wcs_fixed_right" id="example_4">
            <div class="wcs_button">
                <span class="fa fa-whatsapp"></span> {{__("frontend.business-details.support.chat.questions")}}
            </div>

            <div class="wcs_popup">
                <div class="wcs_popup_close">
                    <span class="fa fa-close"></span>
                </div>
                <div class="wcs_popup_header">
                    <span class="fa fa-whatsapp fa-whatsapp--set"></span>
                    <strong>{{__("frontend.business-details.support.chat.customer-support")}}</strong>

                    <div class="wcs_popup_header_description">

                        {{__("frontend.business-details.support.chat.need-help")}}

                    </div>
                </div>
                <div class="wcs_popup_input" data-number="528123861273">
                    <input type="text" placeholder="Ask anything!"/>
                    <i class="fa fa-play icon-hover"></i>
                </div>
                <div class="wcs_popup_avatar">
                    <img src="{{ asset($resourcePathServer . 'plugins/whatsapp-chat-support/img/person_4.jpg') }}"
                         alt="">
                </div>
            </div>
        </div>

    @endsection
