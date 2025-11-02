
@php
    $templateRoot='presentationCard';
@endphp
@extends('layouts.cityBook')
@section('additional-styles')
    <link href="{{ asset($resourcePathServer . 'css/bootgridManager.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset($resourcePathServer . 'css/bootstrapManager.css') }}" rel="stylesheet" type="text/css">

    <link type="text/css" rel="stylesheet"
          href="{{ URL::asset($resourcePathServer . 'libs/metis-menu/metisMenu.min.css') }}">

    <link type="text/css" rel="stylesheet"
          href="{{ asset($resourcePathServer . 'plugins/whatsapp-chat-support/whatsapp-chat-support.css') }}">

    <link rel="stylesheet" href="{{asset($resourcePathServer.'plugins/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset($resourcePathServer.'plugins/slick/slick-theme.css')}}">

    <link rel="stylesheet" href="{{asset($resourcePathServer.'plugins/jquery-confirm/jquery-confirm.min.css')}}">


    @include('partials.plugins.resourcesCss',['bootgrid'=>true])
    @include('partials.plugins.resourcesCss',['toast'=>true])

    <style>
        .slick-dots li button:before {
            color: #a9a9a900 !important;
        }

        .slick-dots li.slick-active button:before {

            color: #a9a9a900 !important;
        }

        .slick-prev:before, .slick-next:before {
            font-size: 27px;
            color: #445ef2;
        }

        #product-grid thead {
            display: none;
        }

        .modal-header {
            display: none !important;
        }

        #product-grid > tbody > tr {
            background-color: #ffffff;
        }

        .single-sidebar-widget__title {
            text-align: left;
        }

        .manager-input-data input {
            border: none;
            height: 40px;
            line-height: 40px;
            padding: 0 20px;
            float: left;
            width: 130px;
        }

        .header-search-select-item .header-search-select-item--shop {
            float: right;
        }

        .manager-input-data input {

            width: 50% !important;
        }

        }
        *

        /
        .modal-open .modal {

            max-height: 735px;
        }

        .d-inline-block {
            display: inline-block !important;
        }

        [class^="pe-7s-"],
        [class*=" pe-7s-"] {
            display: inline-block;
            font-family: 'Pe-icon-7-stroke';
            speak: none;
            font-style: normal;
            font-weight: 400;
            font-variant: normal;
            text-transform: none;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .pro-qty input {

            width: 54px;

        }

        .product-content {
            text-align: left;
        }

        .product-content p {
            line-height: 1.6;
            margin: 1em 0;
        }

        .product-content div.product-content__management {
            margin-top: 1%;
        }

        .price .main-price.discounted {
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 20px;
            font-weight: 600;
            line-height: 48px;
            text-decoration: line-through;
            color: #aaa;
        }

        .price .main-price {
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 30px;
            font-weight: 600;
            line-height: 48px;
            color: #d92523;
        }

        .price .discounted-price {
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 30px;
            font-weight: 600;
            line-height: 48px;
            color: #d92523;
        }

        .product__title {
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 28px;
            font-weight: 600;
            line-height: 28px;
            color: #111;
        }

        .slick-dots li button {
            background: #445EF2 !important;
        }

        div#management-options-business #details {
            padding-top: 25px !important;
            margin-top: 25px !IMPORTANT;
        }

        .listing-carousel-data.slick-dots {
            bottom: 75% !important;
        }

        .slick-slide {

            height: auto !important;

        }

        .slick-arrow i {
            margin-top: 33%;
        }

        div#row-categories {
            padding-top: 3%;
            /* position: relative; */
            padding-bottom: 2%;
        }

        section.shop-content-wrapper {
            padding: 0px 0 !important;
        }


        .listing-carousel-data__content-img img {

            width: 111px !important;
            height: 111px !important;
            border-radius: 50%;
            margin-left: auto;
            margin-right: auto;
        }

        .card-listing .listing-carousel-data__listing {
            border: 0px solid #eee !important;
        }

        .card-listing .listing-carousel-data__listing {
            overflow: hidden !important;
            border-radius: 10px !important;
            border: 0px solid #eee !important;
        }

        h3.listing-carousel-data__title {
            font-size: 21px;
            color: #445EF2 !important;
            margin-top: 9%;

        }


        section {

            background: #F5F5F5 !important;
        }

        .slick-slide-item {
            cursor: pointer;
        }

        .slick-active.slick-active-current .listing-carousel-data__title {
            font-weight: bold;
        }


        .custom-form-search-shop-type-one input {
            border: 2px solid #fff;
            border-radius: 25px;

            height: 40px;
            line-height: 40px;
            padding: 0 20px;
            float: left;
            width: 100%;
        }

        .custom-form-search-shop-type-one div.header-search-select-item--shop {
            width: 100% !important;

        }

        .gray-section {
            background: #F5F5F5 !important;
        }

        .slick-slide img {
            display: block;
            width: 100%;
        }

        .select2-container {
            width: 100% !important;
        }

        img.shop-products-wrap__image {
            width: 70%;
            height: auto;
        }

        h1.content-manager-products-services__title-subcategory {
            text-align: left;
            padding-bottom: 16px;
            font-size: 35px;
            color: #445EF2 !important;

            font-weight: bold;
            padding-left: 18px;
        }

        .no-results {

            font-size: 31px;
        }

        .xywer-tbl-admin > tbody > tr:hover {
            color: #445ef2 !important;

        }

        section#shop {
            padding-top: 42px;
        }

        .xywer-tbl-admin > tbody > tr {
            background-color: #F5F5F5 !important;


        }

        .single-list-product .product-hover-icon-wrapper .single-icon a {

            color: #C9C9C9 !important;
        }

    </style>
    @if ($dataManagerPage['inventory-config']['type'] == 0)
        <style>
            .single-icon a i.fa {
                margin-top: 14px !important;
            }

        </style>
    @elseif(($dataManagerPage['inventory-config']['type']==1))
        <style>
            .header-search-select-item {
                background: none !important;
                border-left: 0px solid #eee !important;
            }

            .select2-container--default .select2-selection--single {

                border-radius: 13px !important;
                height: 42px !important;
                border: 0px solid #aaa !important;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                font-size: 18px;
                text-align: left;
                padding-top: 5px;
                color: #445ef2 !important;
                padding-left: 17px !important;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow b {
                border-color: #445EF2 transparent transparent transparent !important;

                border-width: 11px 9px 0 9px !important;
                margin-left: -19px !important;
                margin-top: 2px !important;
            }

            .single-list-product .product-hover-icon-wrapper .single-icon {
                height: 30px !important;

            }

            .single-list-product .product-hover-icon-wrapper .single-icon--add-to-cart {

                width: 40px;
                border: 2px solid #C9C9C9 !important;
            }

            span.single-icon {
                border: 2px solid #C9C9C9 !important;
                margin-left: 2%;
            }

            .single-list-product .product-hover-icon-wrapper .single-icon:hover .single-icon a {
                color: #445EF2 !important
            }

            .single-icon:hover .single-icon a {
                color: #445EF2 !important
            }

            .single-list-product .product-hover-icon-wrapper .single-icon {
                background-color: #445ef200 !important;
            }

            .single-list-product .product-hover-icon-wrapper .single-icon--add-to-cart i {
                display: block !important;
            }

            .price .discounted-price {
                color: #445ef2 !important;
            }

            .price .main-price {
                color: #445ef2 !important;

            }

            .single-icon i {
                margin-top: 7px;
            }

            .img-fluid--type-two {

                width: 25% !important;
            }

            .custom-scroll-admin-grid {
                height: calc(70% - 40px - 40px) !important;

            }

            .product-price-data-wrapper {

                padding-right: 22%;
            }

            span.single-icon.add-wish-list--admin {
                width: 40px;
            }

            .not-view {
                display: none !important;
            }

        </style>
        @include('partials.plugins.resourcesCss',['select2'=>true])

    @endif
@endsection

@section('additional-scripts')
    <!--CONFIRM-->
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

        function initMapCurrent() {

            function singleMap() {
                var myLatLng = {
                    lng: $('#singleMap').data('longitude'),
                    lat: $('#singleMap').data('latitude'),
                };
                var titleMarker = $('#singleMap').data('data-mapTitle');
                var single_map = new google.maps.Map(document.getElementById('singleMap'), {
                    zoom: 14,
                    center: myLatLng,
                    scrollwheel: false,
                    zoomControl: false,
                    mapTypeControl: false,
                    scaleControl: false,
                    panControl: false,
                    navigationControl: false,
                    streetViewControl: false,
                    styles: [{
                        "featureType": "landscape",
                        "elementType": "all",
                        "stylers": [{
                            "color": "#f2f2f2"
                        }]
                    }]
                });
                var markerIcon2 = {
                    url: $resourceRoot + 'images/marker.png',
                }
                var marker = new google.maps.Marker({
                    position: myLatLng,
                    draggable: false,
                    map: single_map,
                    icon: markerIcon2,
                    title: titleMarker
                });
                var zoomControlDiv = document.createElement('div');
                var zoomControl = new ZoomControl(zoomControlDiv, single_map);

                function ZoomControl(controlDiv, single_map) {
                    zoomControlDiv.index = 1;
                    single_map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(zoomControlDiv);
                    controlDiv.style.padding = '5px';
                    var controlWrapper = document.createElement('div');
                    controlDiv.appendChild(controlWrapper);
                    var zoomInButton = document.createElement('div');
                    zoomInButton.className = "mapzoom-in";
                    controlWrapper.appendChild(zoomInButton);
                    var zoomOutButton = document.createElement('div');
                    zoomOutButton.className = "mapzoom-out";
                    controlWrapper.appendChild(zoomOutButton);
                    google.maps.event.addDomListener(zoomInButton, 'click', function () {
                        single_map.setZoom(single_map.getZoom() + 1);
                    });
                    google.maps.event.addDomListener(zoomOutButton, 'click', function () {
                        single_map.setZoom(single_map.getZoom() - 1);
                    });
                }

                google.maps.event.addListener(marker, 'dragend', function (event) {
                    /* document.getElementById("lat").value = event.latLng.lat();
                     document.getElementById("long").value = event.latLng.lng();*/
                });

                var greyStyleMap = new google.maps.StyledMapType($greyscale_style, {
                    name: "Greyscale"
                });
                single_map.mapTypes.set('greyscale_style', greyStyleMap);
                single_map.setMapTypeId('greyscale_style');
            }

            var single_map = document.getElementById('singleMap');
            if (typeof (single_map) != 'undefined' && single_map != null) {
                google.maps.event.addDomListener(window, 'load', singleMap);
            }
            this._eventsMapCurrent();

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
            console.log('initGridShop--------');
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
    @include('layouts.partials.shop.managementFormDetailsProduct',array())
    @include('layouts.partials.managementFormShare',array())
    @if ($dataManagerPage['inventory-config']['type'] == 0)
        @include($templateRoot.'.web.partials.businessDetails.assets.js.typeDefault',array())
    @elseif(($dataManagerPage['inventory-config']['type']==1))
        @include($templateRoot.'.web.partials.businessDetails.assets.js.typeOne',array())
        @include('partials.plugins.resourcesJs',['select2'=>true])

    @endif

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
        <input id="action-manager-business" class="businessDetails" type="hidden"
               value="{{ route('managerProductBusiness', app()->getLocale()) }}"/>

        @if (isset($dataManagerPage['type']))
            @if ($dataManagerPage['type'] == 2)
                @include($templateRoot.'.web.listingView.single2')

            @endif
        @endif

        @endsection
    </div>
    @section('buttonsManagerFooter')

        <div class="whatsapp_chat_support wcs_fixed_right" id="example_4">
            <div class="wcs_button">
                <span class="fa fa-whatsapp"></span> Questions?
            </div>

            <div class="wcs_popup">
                <div class="wcs_popup_close">
                    <span class="fa fa-close"></span>
                </div>
                <div class="wcs_popup_header">
                    <span class="fa fa-whatsapp"></span>
                    <strong>Customer Support</strong>

                    <div class="wcs_popup_header_description">Need Help?
                        {{ __('frontend.business-details.contact-us.chat-button') }}
                    </div>
                </div>
                <div class="wcs_popup_input" data-number="528123861273">
                    <input type="text" placeholder="Ask anything!"/>
                    <i class="fa fa-play"></i>
                </div>
                <div class="wcs_popup_avatar">
                    <img src="{{ asset($resourcePathServer . 'plugins/whatsapp-chat-support/img/person_4.jpg') }}"
                         alt="">
                </div>
            </div>
        </div>

    @endsection
