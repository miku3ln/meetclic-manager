var componentThisTemplateAboutUs;
var initClick = false;

Vue.component('template-contact-us-component', {
    template: '#contact-us-template',
    directives: {}
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {

        var vmCurrent = this;
        var $this = this;

        this.$root.$on("_updateParentByChildren", function (paramsGet) {
            vmCurrent._managerTypes(paramsGet);
        });

        this.$root.$on("_updateValuesMap", function (paramsGet) {
            var position = {lat: 0, lng: 0};
            var options_map = null;
            if (paramsGet.typeEvent == 'click' || paramsGet.typeEvent == 'dragend' || paramsGet.typeEvent == 'zoom_changed_map') {
                if (paramsGet.typeEvent == 'click') {


                    $this.managerTemplateContactUs({
                        data: paramsGet.data
                    });

                } else if (paramsGet.typeEvent == 'dragend') {
                    position = {lat: paramsGet.data.position.lat(), lng: paramsGet.data.position.lng};
                } else if (paramsGet.typeEvent == 'zoom_changed_map') {


                }
                options_map = $this.$refs.refMap.getOptionsMap();
                console.log(options_map, position);
                $this.$refs.refBusinessInformation._setManagerMap({
                    latLng:options_map.center,
                    options_map:options_map,

                });

            }

        });
        this.$root.$on("_updateInformationSocialNetwork", function (paramsGet) {
            if (paramsGet.type == 'saveNew' || paramsGet.type == 'update' || paramsGet.type == 'delete') {
                var information_social_network = paramsGet.data.information_social_network;
                vmCurrent.configDataInformationSocialNetwork = information_social_network;
                vmCurrent.configDataInformationSocialNetwork.model_id = $this.model_id;
                vmCurrent.configDataInformationSocialNetwork.business_id = $this.business_id;
                $this.$refs.refInformationSocialNetwork.setManagerCurrent({data: vmCurrent.configDataInformationSocialNetwork})
            }
        });

    },
    beforeMount: function () {
        this.configParams = this.params;
        this.model_id = this.configParams.model_id;
        this.business_id = $modelDataManager.business_id;
        this.getInitDataManager();
    },
    mounted: function () {
        componentThisTemplateAboutUs = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    validations: function () {
        var attributes = {};

        var result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;

    },

    data: function () {

        var dataManager = {
            model_id: null,
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {},
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
            configParams: {},
            labelsConfig: {buttons: {'create': 'Crear', 'update': 'Actualizar'}},
            tabCurrentSelector: '#tab-template-contact-us',
            processName: "Registro Acción.",
            submitStatus: "no",
            showManager: false,
            managerType: null,
            configDataMap: {},
            initManager: false,
            configDataContactUs: null,
            configDataBusinessInformation: null,
            configDataInformationSocialNetwork: [],
            configDataTemplateConfigMailingByEmails: [],
            managerTemplateContactUsData: {
                infWindow: null
            },
            configDataTemplateChatApi: {},
            managerMap: {
                'source': null,
                'view': false,
                'isValid': true
            }
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        managerTemplateContactUs: function (paramsGet) {
            var position = {lat: paramsGet.data.marker.position.lat(), lng: paramsGet.data.marker.position.lng()};
            var mapCurrent = paramsGet.data.map;
            var marker = paramsGet.data.marker;
            var latLng = position;
            var div = document.createElement('div');
            var infWindow;
            var myVar;
            var $this = this;
            div.innerHTML = [
                '<div class="manager-buttons">    ',
                '       <div class="content-box-preview upload-manager"  >',
                '         <div id="container_selector_imagen">',
                '           <img class="content-box-image__preview upload-manager preview-source-marker" id="preview-source" style="display:none;">',
                '           <input  type="file" id="file_source"   >',
                '         </div>    ',
                '           <div class="progress-gallery-image not-view">',
                '              <div class="progress__bar"></div>',
                '              <div class="progress__percent">0%</div>',
                '            </div>',
                '       </div>    ',
                '</div>    '


            ].join("");
            if (this.managerTemplateContactUsData.infWindow == null) {
                infWindow = new google.maps.InfoWindow();
            } else {
                infWindow = this.managerTemplateContactUsData.infWindow;

            }

            if (infWindow.getMap()) {
                infWindow.close();

            } else {
                var contactUs = $this.configDataContactUs.template_contact_us;
                infWindow.setContent(div);
                infWindow.setPosition(latLng);
                infWindow.open(mapCurrent);
                myVar = setTimeout(function () {
                    $this._initEventsUpload(
                        {
                            'selectorUpload': "#file_source",
                            'selectorPreview': "#preview-source",
                            'selectorAuxUpload': ".upload-manager",
                            'source': contactUs ? contactUs.source : null,
                            marker: marker
                        }
                    );
                    clearTimeout(myVar);
                }, 1000);

            }

            this.managerTemplateContactUsData.infWindow = infWindow;
            this.managerTemplateContactUsData.timer = myVar;
        },
        _initEventsUpload: function (params) {

            var selectorAuxUpload = params.selectorAuxUpload;
            var $this = this;
            var allowClick = false;
            var selectorUpload = params['selectorUpload'];
            var selectorPreview = params['selectorPreview'];
            var srcSource = params.source;
            if (srcSource) {
                $(selectorPreview).attr("src",  $resourceRoot+srcSource);
                $(selectorPreview).css({display: 'block'});
            }
            var contactUs = $this.configDataContactUs.template_contact_us;

            $(selectorUpload).change(function () {
                var srcSourceManager = $.UploadUtil.upload({
                    typeUpload: 'image',
                    generateManager: 'uploadImage',
                    'fileElement': $(this)[0].files,
                    'idSelectorUpload': selectorUpload.split("#")[1],
                    managerContentImage: "#container_selector_imagen",
                    managerUploadSelector: ".progress-gallery-image",
                    'blockElement': '#tab-template-contact-us',
                    sourceSet: '/uploads/frontend/contact-us/iconMap',
                    url: $("#action-template-contact-us-uploadImage").val(),
                    dataSend: {
                        template_information_id: $this.model_id,
                        id: contactUs ? contactUs.id : null,
                        business_id: $this.business_id
                    }

                });
                if (srcSourceManager.success) {
                    var data = srcSourceManager.result.data;
                    var template_contact_us = data.template_contact_us;
                    var srcSource = template_contact_us.source;

                    $(selectorPreview).attr("src",  $resourceRoot+srcSource);
                    $(selectorPreview).css({display: 'block'});


                    var urlIcon = srcSource;
                    var width = 30, height = 40;
                    var iconCurrent = {
                        url: urlIcon,
                        scaledSize: new google.maps.Size(width, height), // scaled size
                        origin: new google.maps.Point(0, 0), // origin
                        anchor: new google.maps.Point(0, 0) // anchor
                    };
                    params.marker.setIcon(iconCurrent);
                    $this.configDataContactUs.template_contact_us = template_contact_us;
                } else {
                    $(selectorPreview).css({display: 'none'});
                }
                allowClick = false;
                initClick = false;
                return false;
            });


        },
        initCurrentComponent: function () {


        },
        getInitDataManager: function () {

            var dataSend = {
                filters: {
                    business_id: this.business_id,
                    template_information_id: this.model_id,
                }
            };
            var urlCurrent = $('#action-template-contact-us-getContactUsData').val();
            $this = this;
            ajaxRequest(urlCurrent, {
                type: 'POST',
                data: dataSend,
                blockElement: ('#tab-template-contact-us'),//opcional: es para bloquear el elemento
                loading_message: '',
                error_message: 'Error al obtener Informacion.',
                success_message: '',
                success_callback: function (response) {
                    $this.configDataContactUs = {};
                    if (response.success) {
                        $this.setManagerLoadImgMap(response);
                    } else {


                    }

                }
            });
        },

        setManagerLoadImgMap: function (response) {
            var $this = this;
            var configDataContactUs = response;
            var contactUs = configDataContactUs.template_contact_us;
            var icon = contactUs ?  $resourceRoot+contactUs.source : null;
            if (icon) {
                $.ajax({
                    url: icon,
                    statusCode: {
                        404: function () {

                            configDataContactUs.template_contact_us['source'] = null;
                            $this.initManager = true;
                            $this.setValuesManager(configDataContactUs);
                        },
                        200: function () {
                            $this.initManager = true;
                            $this.setValuesManager(configDataContactUs);
                        }
                    },

                });
            } else {
                $this.initManager = true;
                $this.setValuesManager(configDataContactUs);
            }

        },
        setValuesManager: function (response) {
            var $this = this;
            $this.configDataContactUs = response;
            var contactUs = $this.configDataContactUs.template_contact_us;

            var businessData = response.business;
            var options_map = null;
            if (businessData.options_map && businessData.options_map != '') {
                var options_mapCurrent = jQuery.parseJSON(businessData.options_map);

                options_map = {
                    zoom: options_mapCurrent.zoom,
                    center: options_mapCurrent.center,
                };
            }
            $this.configDataMap = {
                'id': businessData.id,
                latLng: {
                    lat: businessData.street_lat,
                    lng: businessData.street_lng,
                },
                'title': businessData.title,
                'description': businessData.description,
                'options_map': options_map,
                "template_information_id": $this.model_id,
                "icon": contactUs ? contactUs.source : null,


            };
            $this.configDataBusinessInformation = {
                model: {
                    attributes: {
                        'email': businessData.email,
                        'id': businessData.id,
                        'street_1': businessData.street_1,
                        'street_2': businessData.street_2,
                        'phone_value': businessData.phone_value,
                        'street_lat': businessData.street_lat,
                        'street_lng': businessData.street_lng
                    },

                },
                "template_information_id": $this.model_id,
            };

            var information_social_network = response.information_social_network;
            $this.configDataInformationSocialNetwork = information_social_network;
            $this.configDataInformationSocialNetwork.model_id = $this.model_id;
            $this.configDataInformationSocialNetwork.business_id = $this.business_id;
            $this.configDataInformationSocialNetwork.createUpdate = true;


            var template_config_mailing_by_emails = response.template_config_mailing_by_emails ? response.template_config_mailing_by_emails : {};
            $this.configDataTemplateConfigMailingByEmails = template_config_mailing_by_emails;
            $this.configDataTemplateConfigMailingByEmails.model_id = $this.model_id;
            $this.configDataTemplateConfigMailingByEmails.business_id = $this.business_id;
            $this.configDataTemplateConfigMailingByEmails.createUpdate = true;

            var chatConfig = response.chat;
            $this.configDataTemplateChatApi.filters = {business_id: $this.business_id, model_id: $this.model_id};
            $this.configDataTemplateChatApi.data = chatConfig;


        },
//EVENTS OF CHILDREN
        _managerTypes: function (paramsGets) {
            if (paramsGets.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

            }
        },
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
        makeToast: function (params) {
            var $msjCurrent = params.msj;
            var $titleCurrent = params.title;
            var $typeCurrent = params.type;

            this.$notify({
                type: $typeCurrent,
                title: $titleCurrent,
                duration: 0,
                content: $msjCurrent,

            }).then(() => {
// resolve after dismissed
                console.log('dismissed');
            });
        },
//MANAGER PROCESS
        /*---------GRID--------*/
        _saveModel: function () {
            var dataSendResult = {};
            var dataSend = dataSendResult;
            var vCurrent = this;
            vCurrent.$v.$touch();
            var validateCurrent = this.validateForm();
            if (!validateCurrent) {
                vCurrent.submitStatus = 'error';

            } else {
                ajaxRequest(this.formConfig.url, {
                    type: 'POST',
                    data: dataSend,
                    blockElement: vCurrent.tabCurrentSelector,//opcional: es para bloquear el elemento
                    loading_message: vCurrent.formConfig.loadingMessage,
                    error_message: vCurrent.formConfig.errorMessage,
                    success_message: vCurrent.formConfig.successMessage,
                    success_callback: function (response) {

                        if (response.success) {
                            vCurrent._resetManagerGrid();
                            vCurrent.resetForm();
                            $(vCurrent.gridConfig.selectorCurrent).bootgrid("reload");
                            vCurrent._viewManager(2);
                        }
                    }
                }, true);
            }
        },

    }
})
;




