var componentThisBusiness;

Vue.component('business-component', {
    template: '#business-template',
    directives: {
        'init-grid-filters': {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.initMethod({
                    objSelector: el
                });


            },
        },
        initSummerNote: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var initMethod = paramsInput['initMethod'];
                initMethod({
                    elementInit: el
                });

            }
        },
        initS2: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._managerS2Action({
                    objSelector: el, model: paramsInput.model

                });
            },
        },
        initCrop: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.initMethod({
                    objSelector: el, model: paramsInput.model
                });
            },

        },
        resetModel: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._resetModel(paramsInput.model);


            },
        },
        "_upload-resource": {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._initEventsUpload({
                    objSelector: el
                });

            },
            bind: function (el, binding, vnode, vm, arg) {


            }
        },
        initImg: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var url = paramsInput.url;
                if (url) {
                    $(el).attr("src", url);
                }

            }
        },
    },
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var $scope = this;
        this.$root.$on("_updateParentByChildren", function (emitValue) {
            $scope._managerTypes(emitValue);

        });
        this.countriesData = $configPartial["dataCatalogue"]['locationData'];
        if (this.countriesData.hasOwnProperty('18')) {
            this.provincesData = this.countriesData['18']['data'];
            if (this.provincesData.hasOwnProperty('15')) {
                this.citiesData = this.provincesData['15']['data'];
                if (this.citiesData.hasOwnProperty('1')) {
                    this.zonesData = this.citiesData['1']['data'];
                }

            }
        }
        this.bankData = $configPartial["dataCatalogue"]['bankData'];
    },
    beforeMount: function () {
        this.configParams = this.params;
    },
    mounted: function () {
        componentThisBusiness = this;
        this.initCurrentComponent();
    },

    validations: function () {
        var attributes = {
            id: {},
            description: {required},
            title: {required},
            page_url: {},
            phone_value: {required},
            street_1: {required},
            street_2: {required},
            street_lat: {required},
            street_lng: {required},
            business_subcategories_id: {required},
            countries_id: {required},
            provinces_id: {required},
            cities_id: {required},
            zones_id: {required},
            source: {required},
            change: {},
            email: {required},
            has_document: {},
            has_about: {},
            has_service_delivery: {},
            type_business: {required},
            type_manager_payment: {},
            business_disbursement_id: {},
            bank_id: {required},
            account_number: {required},
            type_account: {required},
            business_location_id: {},
            "business_by_amenities_data": {},
        };

        var result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;

    },
    data: function () {
        var dataManager = {
//**Modal*
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": typeof ($frontend) == 'undefined' ? " fas fa-pencil-alt" : 'fa fa-pencil-square-o',
                        "managerType": "updateEntity"
                    },
                    {
                        "title": "Administrar Empresa",
                        "data-placement": "top",
                        "i-class": "fa  fa-building",
                        "managerType": "managerBusiness",
                        "isUrl": true,
                        "url": $('#action-business-manager').val() + "/"
                    },

                    {
                        "title": "Ver Empresa",
                        "data-placement": "top",
                        "i-class": typeof ($frontend) == 'undefined' ? "fas fa-eye" : 'fa fa-eye',
                        "managerType": "previewBusiness",
                        "isUrl": true,
                        "url": $('#action-business-view').val() + "/"
                    },

                ]
            },
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
            configParams: {},
            labelsConfig: {},
            lblBtnSave: "Guardar",
            lblBtnClose: "Cerrar",
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            search: {
                needle: ''
            },
            tabCurrentSelector: '#tab-business',
            processName: "Registro Empresa.",
            formConfig: {
                nameSelector: "#business-form",
                url: $('#action_business_save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Empresa.',
                successMessage: 'La empresa se guardo correctamente.',
                nameModel: "Business"
            },
            gridConfig: {
                selectorCurrent: "#business-grid",
                url: $("#action_business_admin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            businessSubcategoriesData: $configPartial["dataCatalogue"]["subcategories"],
            countriesData: [],
            provincesData: [],
            citiesData: [],
            zonesData: [],
            banksData: [],
            typeBusinessData: [
                {
                    id: 0,
                    value: 'Productos',

                },
                {
                    id: 1,
                    value: 'Servicios',

                },
                {
                    id: 2,
                    value: 'Productos/Servicios',

                }
            ],
            typeAccount: [
                {
                    id: 0,
                    value: 'Ahorros',

                },
                {
                    id: 1,
                    value: 'Corriente',

                }

            ],
            bankData: [],
            /*---UPLOADS--*/
            uploadConfig: {
                uploadElementsSelectors: {
                    file: "#file_upload_img"

                },
            },
            lblUploadName: "Subir Imagen.",
            initDataRows: {
                count: 0,
            },
            businessCreate: false,

        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

    _search: function (params) {
        $scope = this;
        var selectorGrid = $scope.gridConfig.selectorCurrent;
        $(params.objSelector).on('change', function () {

        }).keyup(function () {
            searchData = $(this).val();
            if (searchData.length > 2) {
                $(selectorGrid).bootgrid("search", searchData);
            } else if (searchData.length == 0) {
                $(selectorGrid).bootgrid("search", '');

            }
        }).keydown(function () {

        }).keypress(function () {


        });

        $('#sort-by').on('change', function () {
            var sortConfig = new Object;
            var sortCurrent = 'asc';
            var sortId = $('#sort-by').val();
            var selectorCurrent = null;
            var nameKey = '';
            var titleOption = '';
            if (sortId == 0) {
                selectorCurrent = '#nameSort';
                sortCurrent = $(selectorCurrent).attr('order');
                titleOption = 'Empresa ';
                nameKey = 'title';
            } else if (sortId == 1) {
                selectorCurrent = '#emailSort';
                sortCurrent = $(selectorCurrent).attr('order');
                nameKey = 'email';
                titleOption = 'Email ';

            } else if (sortId == 2) {
                selectorCurrent = '#categorySort';
                sortCurrent = $(selectorCurrent).attr('order');
                nameKey = 'product_category';
                titleOption = 'Categoria ';

            } else if (sortId == 3) {
                selectorCurrent = '#subcategorySort';
                sortCurrent = $(selectorCurrent).attr('order');
                nameKey = 'business_subcategory';
                titleOption = 'Categoria ';

            } else if (sortId == 4) {
                selectorCurrent = '#stateProvinceSort';
                sortCurrent = $(selectorCurrent).attr('order');
                nameKey = 'business_state_province';
                titleOption = 'Estado/Provincia ';

            } else if (sortId == 5) {
                selectorCurrent = '#citySort';
                sortCurrent = $(selectorCurrent).attr('order');
                nameKey = 'business_city';
                titleOption = 'Ciudad ';

            } else if (sortId == 6) {
                selectorCurrent = '#subcategorySort';
                sortCurrent = $(selectorCurrent).attr('order');
                nameKey = 'business_subcategory';
                titleOption = 'Subcategoria ';

            }


            if (sortCurrent == 'asc') {
                titleOption += ' ASC';
                $(selectorCurrent).attr('order', 'desc');
            } else {
                titleOption += ' DESC';
            }
            sortConfig[nameKey] = sortCurrent;
            $(selectorCurrent).html('');
            $(selectorCurrent).html(titleOption);
            if (sortId == -1) {
                sortConfig = {};
            }
            $(selectorGrid).bootgrid("sort", sortConfig);
            $('.chosen-select').niceSelect('update');
        });
    },
    initCropBusiness: function (params) {
        var $scope = this;
        var countAux = 0;

        function initSetManagementImage() {
            this.getResultImage({type: 'rawcanvas'}).then(result => {
                var inputFileManager = $($scope.managerCrop.selectorManagerInput)[0].files[0];
            var filename = 'anyone';

            var type = 'image/jpeg';
            if (typeof (inputFileManager) != 'undefined') {//create
                filename = inputFileManager.name;
                type = inputFileManager.type;
            }
            var urlCurrent = result.toDataURL();
            var mimeType = type;
            if (countAux > 3) {
                if (filename == 'anyone') {//create
                    urlToFile(urlCurrent, filename, mimeType).then(result => {
                        var fileCurrent = result;
                    $scope.model.attributes.source = fileCurrent;
                    if ($scope.businessCreate) {
                        $scope.model.attributes.change = true;
                    }
                    $scope.managerCrop.initLoadFirst = true;
                });
                } else {//update
                    urlToFile(urlCurrent, filename, mimeType).then(result => {
                        var fileCurrent = result;
                    $scope.model.attributes.source = fileCurrent;
                    if ($scope.businessCreate) {
                        $scope.model.attributes.change = true;
                    }
                    $scope.managerCrop.initLoadFirst = true;
                })
                    ;
                }

            }

        });
        };
        var paramsConfig = {
            'selector': '#upload-demo',
            'selectorContainerMain': '.upload-demo',
            'selectorManagerInput': "#file-upload-business",
            '_onLoadImage': function (params) {
                console.log('onload', params);

            },
            '_onUpdate': function (params) {
                console.log(params);
                if ($scope.managerCrop.initLoadFirst == false) {
                    initSetManagementImage();
                } else {
                    initSetManagementImage();

                }
                countAux++;
            },
        };

        this.managerCrop = {
            selector: paramsConfig.selector,
            selectorContainerMain: paramsConfig.selectorContainerMain,
            selectorManagerInput: paramsConfig.selectorManagerInput,
            initLoadFirst: false

        };


        if ($scope.businessCreate) {
            paramsConfig['imageInit'] = $scope.model.attributes.source;
        }
        initUploadCrop(paramsConfig);
    },

    //EVENTS OF CHILDREN
    _managerTypes: function (emitValues) {
        if (emitValues.type == "rebootGrid") {
            $(this.gridConfig.selectorCurrent).bootgrid("reload");

        }
    },
    /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
    initCurrentComponent: function () {
        this.initGridManager(this);

    },
    /*---MODAL CURRENT--*/
    _closeModal: function () {
        closeModal();
    },
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
    })
        ;
    },
    //MANAGER PROCESS
    /*---------GRID--------*/
    _destroyTooltip: function (selector) {
        $(selector).tooltip('hide');
    },
    _resetManagerGrid: function () {
        this.managerMenuConfig = {
            view: false,
            menuCurrent: [],
            rowId: null
        };
    },
    initGridManager: function ($scope) {
        var gridName = this.gridConfig.selectorCurrent;
        var urlCurrent = this.gridConfig.url;
        var structure = this.model.structure;

        var paramsFilters = {};
        let gridInit = $(gridName);
        gridInit.bootgrid({
            ajaxSettings: {
                method: "POST"
            },
            ajax: true,
            post: function () {
                return {
                    grid_id: gridName,
                    filters: paramsFilters
                };
            },
            url: urlCurrent,
            labels: {
                loading: "Cargando...",
                noResults: "Sin Resultados!",
                infos: "Mostrando {{ctx.start}} - {{ctx.end}} de {{ctx.total}} resultados"
            },
            css: getCSSCurrentBootGrid(),
            formatters: {
                'description': function (column, row) {
                    var variantAmenities = row.amenities;
                    var dataCurrentGet = variantAmenities;
                    var variantAmenitiesHtml = [];
                    $.each(dataCurrentGet, function (key, value) {
                        variantAmenitiesHtml.push(value.text);
                    });
                    variantAmenitiesHtml = variantAmenitiesHtml.join(",");
                    variantAmenitiesHtml = variantAmenitiesHtml != "" ? "<span class='content-description__information'><span class='content-description__title'>" + structure.business_by_amenities_data.label + '</span>:<span class=\'content-description__value\'>' + variantAmenitiesHtml + ".</span></div>" : "";

                    var description = (row.title !== "null" && row.title) ? [

                        "<div class='content-description__information'>",
                        "   <img class='content-description__image' src='" + $publicAsset + row.source + "'> ",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Nombre:</span><span class='content-description__value'>" + (row.title) + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Email:</span><span class='content-description__value'>" + (row.email) + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Teléfono:</span><span class='content-description__value'>" + (row.phone_value) + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Dirección:</span><span class='content-description__value'>" + (row.street_1 + " y " + row.street_2) + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Categoría:</span><span class='content-description__value'>" + (row.business_subcategories) + "</span>",
                        "</div>",
                        variantAmenitiesHtml,
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>País :</span><span class='content-description__value'>" + (row.countries) + "</span>",
                        "</div>"
                    ] : [];
                    description = description.join("");
                    var result = [
                        description,
                    ];
                    return result.join("");
                }

            }
        }).on("loaded.rs.jquery.bootgrid", function () {
            $scope._resetManagerGrid();
            $scope._gridManager(gridInit);
        });
    },
    _gridManager: function (elementSelect) {
        var $scope = this;
        var selectorGrid = $scope.gridConfig.selectorCurrent;
        elementSelect.find("tbody tr").on("click", function (e) {
            var self = $(this);
            var dataRowId = $(self[0]).attr("data-row-id");
            var selectorRow;
            if (dataRowId) {
                var instance_data_rows = $(selectorGrid).bootgrid("getCurrentRows");
                var rowData = searchElementJson(instance_data_rows, 'id', dataRowId);//asi s obtiene los valores del registro en funcion d su id
                elementSelect.find("tr.selected").removeClass("selected");
                var newEventRow = false;
                if ($scope.managerMenuConfig.rowId) {//ready selected
                    var removeRowId = $scope.managerMenuConfig.rowId;
                    if (dataRowId == removeRowId) {
                        selectorRow = selectorGrid + " tr[data-row-id='" + removeRowId + "']";
                        $(selectorRow).removeClass("selected");
                        $scope._resetManagerGrid();
                    } else {

                        newEventRow = true;
                    }
                } else {
                    newEventRow = true;
                }
                if (newEventRow) {
                    selectorRow = selectorGrid + " tr[data-row-id='" + dataRowId + "']";
                    $(selectorRow).addClass("selected");
                    $scope.managerMenuConfig = {
                        view: true,
                        menuCurrent: $scope.getMenuConfig({rowData: rowData[0], rowId: dataRowId}),
                        rowId: dataRowId
                    };
                }

            }
        });
    },
    getMenuConfig: function (params) {
        var result = [];
        $.each(this.configModelEntity["buttonsManagements"], function (key, value) {

            if (value.managerType !== 'previewBusiness' && typeof ($allowAllInOne) != 'undefined' && $allowAllInOne) {

                var setPush = {
                    title: value["title"],
                    "data-placement": value["data-placement"],
                    icon: value["i-class"],
                    url: value["isUrl"] ? (value["url"] + params.rowId) : "",
                    isUrl: value["isUrl"] ? true : false,
                    data: value, rowId: params.rowId,
                    managerType: value["managerType"],
                    params: params
                }
                result.push(setPush);
            }
        });
        return result;
    },
    _managerMenuGrid: function (index, menu) {
        var params = {managerType: menu.managerType, id: menu.rowId, row: menu.params.rowData};
        this._managerRowGrid(params);
    },
    _managerRowGrid: function (params) {
        var rowCurrent = params.row;
        var rowId = params.id;
        if (params.managerType == "updateEntity") {
            var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
            this._destroyTooltip(elementDestroy);
            this.managerMenuConfig.view = false;
            this.resetForm();
            this.model.attributes.id = rowCurrent.id;
            this.model.attributes.description = rowCurrent.description;
            this.model.attributes.title = rowCurrent.title;
            this.model.attributes.email = rowCurrent.email;
            this.model.attributes.page_url = rowCurrent.page_url;
            this.model.attributes.phone_value = rowCurrent.phone_value;
            this.model.attributes.street_1 = rowCurrent.street_1;
            this.model.attributes.street_2 = rowCurrent.street_2;

            this.model.attributes.street_lat = rowCurrent.street_lat;
            this.model.attributes.street_lng = rowCurrent.street_lng;

            this.model.attributes.business_subcategories_id = rowCurrent.business_subcategories_id;
            this.model.attributes.countries_id = null;

            if (this.countriesData.hasOwnProperty(rowCurrent.countries_id)) {
                this.model.attributes.countries_id = rowCurrent.countries_id;
            }

            this.model.attributes.provinces_id = rowCurrent.hasOwnProperty('provinces_id') ? rowCurrent.provinces_id : null;
            this.model.attributes.cities_id = rowCurrent.hasOwnProperty('cities_id') ? rowCurrent.cities_id : null;
            this.model.attributes.zones_id = rowCurrent.hasOwnProperty('zones_id') ? rowCurrent.zones_id : null;
            this.model.attributes.source = rowCurrent.source;


            if (rowCurrent.hasOwnProperty('has_document')) {
                this.model.attributes.has_document = rowCurrent.has_document == 1 ? true : false;
            }
            if (rowCurrent.hasOwnProperty('has_about')) {
                this.model.attributes.has_about = rowCurrent.has_about == 1 ? true : false;
            }
            if (rowCurrent.hasOwnProperty('type_manager_payment')) {
                this.model.attributes.type_manager_payment = rowCurrent.type_manager_payment;
            }
            if (rowCurrent.hasOwnProperty('business_disbursement_id')) {
                this.model.attributes.business_disbursement_id = rowCurrent.business_disbursement_id;
            }
            if (rowCurrent.hasOwnProperty('bank_id')) {
                this.model.attributes.bank_id = rowCurrent.bank_id;
            }
            if (rowCurrent.hasOwnProperty('account_number')) {
                this.model.attributes.account_number = rowCurrent.account_number;
            }
            if (rowCurrent.hasOwnProperty('type_account')) {
                this.model.attributes.type_account = rowCurrent.type_account;
            }
            if (rowCurrent.hasOwnProperty('business_location_id')) {
                this.model.attributes.business_location_id = rowCurrent.business_location_id;
            }
            if (rowCurrent.hasOwnProperty('type_business')) {
                this.model.attributes.type_business = rowCurrent.type_business;
            }
            if (rowCurrent.hasOwnProperty('has_service_delivery')) {
                this.model.attributes.has_service_delivery = rowCurrent.has_service_delivery == 1 ? true : false;
            }
            $(".content-box-image__preview").attr("src", $resourceRoot + rowCurrent.source);
            this._viewManager(3, rowId);

            this.model.attributes.business_by_amenities_data = rowCurrent['amenities'];


        }
    },
    /*  EVENTS*/
    _viewManager: function (typeView, rowId) {

        if (typeView == 1) {//create
            this.showManager = true;
            this.managerMenuConfig.view = false;
            $(this.gridConfig.selectorCurrent + "-header").hide();
            $(this.gridConfig.selectorCurrent + "-footer").hide();
            this.resetForm();
            this.managerType = 1;
            this.model.attributes.street_lng = myLatlng.lng;
            this.model.attributes.street_lat = myLatlng.lat;
            this.onInitEventClickTimerForm();//CHANGE-FORM

        } else if (typeView == 2) {//admin
            this.showManager = false;
            $(this.gridConfig.selectorCurrent + "-footer").show();
            $(this.gridConfig.selectorCurrent + "-header").show();
            if (this.managerType == 1) {
                this.managerMenuConfig.view = false;
                this.managerType = null;

            } else {
                this.managerMenuConfig.view = true;
            }
        } else if (typeView == 3) {//update
            this.showManager = true;
            $(this.gridConfig.selectorCurrent + "-footer").hide();
            $(this.gridConfig.selectorCurrent + "-header").hide();
            this.managerMenuConfig.view = false;
            this.managerType = 3;
            this.businessCreate = true;
            this.onInitEventClickTimerForm();//CHANGE-FORM
        }
    },
    /*FORM*/
    getViewErrorForm: function (objValidate) {
        var result = false
        if (!objValidate.$dirty) {
            result = objValidate.$dirty ? (!objValidate.$error) : false;
        } else {
            result = objValidate.$error;
        }

        return result;
    },
    managerViewUpload: function () {

    },
    _setValueSelect: function (field, value) {
        if (field == 'countries_id') {
            this._setValueForm('provinces_id', null);
            this._setValueForm('cities_id', null);
            this._setValueForm('zones_id', null);
            this.provincesData = this.countriesData[value]['data'];
            this.citiesData = [];
            this.zonesData = [];
        } else if (field == 'provinces_id') {
            var dataSet = [];
            if (value != undefined) {
                dataSet = this.provincesData[value]['data'];
            }
            this.citiesData = dataSet;
            this.zonesData = [];

            this._setValueForm('cities_id', null);
            this._setValueForm('zones_id', null);


        } else if (field == 'cities_id') {
            var dataSet = [];
            if (value != undefined) {
                dataSet = this.citiesData[value]['data'];
            }
            this._setValueForm('zones_id', null);
            this.zonesData = dataSet;
        } else if (field == 'zones_id') {

        }


        this._setValueForm(field, value);
    },
    _initEventsUpload: function () {
        var $scope = this;
        $(this.uploadConfig.uploadElementsSelectors.file).change(function () {
            var file = $(this)[0].files[0];
            if (file) {
                if (file.type == "image/png" || file.type == "image/jpeg" || file.type == "image/svg+xml") {//format kml

                    srcSource = window.URL.createObjectURL(file);
                    $(".content-box-image__preview").attr("src", srcSource);
                    $scope.model.attributes.source = file;
                    if ($scope.businessCreate) {
                        $scope.model.attributes.change = true;
                    }
                } else {
                    alert("No es una imagen.");
                }
            }
            return false;
        });

        function _addListenerReaderUpload(reader) {
            reader.addEventListener('loadstart', _readerUpload);
            reader.addEventListener('load', _readerUpload);
            reader.addEventListener('loadend', _readerUpload);
            reader.addEventListener('progress', _readerUpload);
            reader.addEventListener('error', _readerUpload);
            reader.addEventListener('abort', _readerUpload);
        }

        function _readerUpload(event) {

            if (event.type === "load") {
                console.log(" ready", event.target.result);
            } else if (event.type === "loadend") {

            } else if (event.type === "abort") {
                console.log("abort");
            } else if (event.type === "loadstart") {
                console.log("loadstart");

            } else if (event.type === "error") {
                switch (event.target.error.code) {
                    case event.target.error.NOT_FOUND_ERR:
                        alert('File Not Found!');
                        break;
                    case event.target.error.NOT_READABLE_ERR:
                        alert('File is not readable');
                        break;
                    case event.target.error.ABORT_ERR:
                        break; // noop
                    default:
                        alert('An error occurred reading this file.');
                }
            } else if (event.type === "progress") {

                console.log("progress", event.loaded);
                if (event.lengthComputable) {
                    var percentLoaded = Math.round((event.loaded / event.total) * 100);
                    // Increase the progress bar length.
                    if (percentLoaded < 100) {

                    }
                }
            }
        }

    },
    _submitForm: function (e) {
        console.log(e);
    },
    getStructureForm: function () {
        var result = {

            description: {
                id: "description",
                name: "description",
                label: "Descripción",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            title: {
                id: "title",
                name: "title",
                label: "Nombre Empresa",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            email: {
                id: "email",
                name: "email",
                label: "Email",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            page_url: {
                id: "page_url",
                name: "page_url",
                label: "Web",
                required:
                    {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            phone_value: {
                id: "phone_value",
                name: "phone_value",
                label: "Teléfono",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            street_1: {
                id: "street_1",
                name: "street_1",
                label: "Calle Principal",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            street_2: {
                id: "street_2",
                name: "street_2",
                label: "Calle Secundaria",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            business_subcategories_id: {
                id: "business_subcategories_id",
                name: "business_subcategories_id",
                label: "Categoria",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            countries_id: {
                id: "countries_id",
                name: "countries_id",
                label: "País",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            provinces_id: {
                id: "provinces_id",
                name: "provinces_id",
                label: "Estado/Provincia",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            cities_id: {
                id: "cities_id",
                name: "cities_id",
                label: "Ciudad",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            zones_id: {
                id: "zones_id",
                name: "zones_id",
                label: "Zona",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            source: {
                id: "source",
                name: "source",
                label: "Imagen",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            has_document: {
                id: "has_document",
                name: "has_document",
                label: "Documento Informacion",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            has_about: {
                id: "has_about",
                name: "has_about",
                label: "Quienes Somos Titulo",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            has_service_delivery: {
                id: "has_service_delivery",
                name: "has_service_delivery",
                label: "Desea Servicio Delivery?",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            type_business: {
                id: "type_business",
                name: "type_business",
                label: "Tipo de Negocio",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            type_manager_payment: {
                id: "type_manager_payment",
                name: "type_manager_payment",
                label: "Formas de Pagos",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            bank_id: {
                id: "bank_id",
                name: "bank_id",
                label: "Banco",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            account_number: {
                id: "account_number",
                name: "account_number",
                label: "# Cuenta",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            type_account: {
                id: "type_account",
                name: "type_account",
                label: "Tipo de Cuenta",
                required:
                    {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
            },
            business_by_amenities_data: {
                id: "business_by_amenities_data",
                name: "business_by_amenities_data",
                label: "Comodidas",
                required: {
                    allow: false,
                    msj: "Campo requerido.",
                    error: false
                },
            },
        };

        return result;
    },
    getAttributesForm: function () {
        var allowSetDefaultRefund = typeof ($allowAllInOne) == 'undefined' ? false : true;
        var result = {
            description: null,
            title: null,
            email: null,
            page_url: null,
            phone_value: null,
            street_1: null,
            street_2: null,
            street_lat: null,
            street_lng: null,
            business_subcategories_id: null,
            countries_id: 18,//ecuador
            provinces_id: 15,//imbabura
            cities_id: 1,//otavalo
            zones_id: 5,//san luis
            source: null,
            change: false,
            has_document: false,
            has_about: false,
            has_service_delivery: false,
            type_business: 0,//only products
            type_manager_payment: 1,//0=OWNER PAYMENTE EFECTIVE 1=COLMENA SE ENCARGA
            business_disbursement_id: null,

            bank_id: allowSetDefaultRefund ? 1 : null,
            account_number: allowSetDefaultRefund ? '00096' : null,
            type_account: 1,//ahorros
            business_location_id: null,
            "business_by_amenities_data": null,

        };

        return result;
    },
    getNameAttribute: function (name) {
        var result = this.formConfig.nameModel + "[" + name + "]";
        return result;
    },
        _initSummerNote: function (params) {
            var elementInit = params['elementInit'];
            var fieldCurrent = $(elementInit).attr('id');
            var $this = this;
            if (this.model.attributes.id) {
                var htmlSet = this.model.attributes[fieldCurrent];
                $(elementInit).html(htmlSet);
            }
            $(elementInit).summernote({
                height: 250,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: false,              // set focus to editable area after initializing summernote
                callbacks: {
                    onChange: function (contents, $editable) {

                        if ('<p><br></p>' == contents || '' == contents) {
                            $this.$v.model.attributes[fieldCurrent].$model = null;
                        } else {
                            $this.$v.model.attributes[fieldCurrent].$model = contents;
                        }
                    }
                }
            });


        },
    getLabelForm: viewGetLabelForm,
    _setValueForm: function (name, value) {
        this.model.attributes[name] = value;
        this.$v["model"]["attributes"][name].$model = value;
        this.$v["model"]["attributes"][name].$touch();
    },
    getClassErrorForm: function (nameElement, objValidate) {

        var result = null;
        result = {
            "form-group--error": objValidate.$error,
            'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
        };

        return result;
    },
    getErrorHas: function (model, type) {

        var result = (model.$model == undefined || model.$model == "") ? true : false;
        return result;
    },
    getViewError: function (model) {
        var result = (model.$dirty == true) ? true : false;
        return result;
    },
//Manager Model
    getValuesSave: function () {
        var dataCurrentKeys = [];
        var dataCurrentGet = this.$v.model.attributes.business_by_amenities_data.$model;
        $.each(dataCurrentGet, function (key, value) {
            var setPush = value.id;
            dataCurrentKeys.push(setPush);
        });
        dataCurrentKeys = dataCurrentKeys.join(',');
        var business_by_amenities_data = dataCurrentKeys;
        var result = {

            id: this.model.attributes.id ? this.model.attributes.id : -1,
            description: this.$v.model.attributes.description.$model,
            title: this.$v.model.attributes.title.$model,
            email: this.$v.model.attributes.email.$model,
            page_url: this.$v.model.attributes.page_url.$model,
            phone_value: this.$v.model.attributes.phone_value.$model,
            street_1: this.$v.model.attributes.street_1.$model,
            street_2: this.$v.model.attributes.street_2.$model,
            street_lat: this.$v.model.attributes.street_lat.$model,
            street_lng: this.$v.model.attributes.street_lng.$model,
            business_subcategories_id: this.$v.model.attributes.business_subcategories_id.$model,
            countries_id: this.$v.model.attributes.countries_id.$model,
            provinces_id: this.$v.model.attributes.provinces_id.$model,
            cities_id: this.$v.model.attributes.cities_id.$model,
            zones_id: this.$v.model.attributes.zones_id.$model,
            business_location_id: this.model.attributes.business_location_id,
            source: this.$v.model.attributes.source.$model,
            change: this.$v.model.attributes.change.$model,
            has_document: this.$v.model.attributes.has_document.$model ? 1 : 0,
            has_about: this.$v.model.attributes.has_about.$model ? 1 : 0,
            has_service_delivery: this.$v.model.attributes.has_service_delivery.$model ? 1 : 0,
            type_business: this.$v.model.attributes.type_business.$model,
            type_manager_payment: this.$v.model.attributes.type_manager_payment.$model,

            //disbursement
            business_disbursement_id: this.model.attributes.business_disbursement_id,
            bank_id: this.$v.model.attributes.bank_id.$model,
            account_number: this.$v.model.attributes.account_number.$model,
            type_account: this.$v.model.attributes.type_account.$model,
            "business_by_amenities_data": business_by_amenities_data,


        };
        return result;
    },
    _saveModel: function () {
        var dataSendResult = this.getValuesSave();
        var dataSend = dataSendResult;
        var $scope = this;
        $scope.$v.$touch();
        var validateCurrent = this.validateForm();
        if (!validateCurrent) {
            $scope.submitStatus = 'error';

        } else {

            ajaxRequestManager(this.formConfig.url, {
                type: 'POST',
                data: dataSend,
                blockElement: $scope.tabCurrentSelector,//opcional: es para bloquear el elemento
                loading_message: $scope.formConfig.loadingMessage,
                error_message: $scope.formConfig.errorMessage,
                success_message: $scope.formConfig.successMessage,
                success_callback: function (response) {

                    if (response.success) {
                        $scope._resetManagerGrid();
                        $scope._viewManager(2);
                        $($scope.gridConfig.selectorCurrent).bootgrid("reload");
                        $scope.resetForm();
                    }
                }
            }, true);
        }
    },
    resetForm: function () {

        this.$v.$reset();
        this.model = {
            attributes: this.getAttributesForm(),
            structure: this.getStructureForm()
        };
        this.model.attributes.id = null;
        $(".content-box-image__preview").attr("src", "");
        this.businessCreate = false;

    },
    _valuesForm: function (event) {
        this.model.init = false;
        this.validateForm();
    },
    validateForm: function () {
        var currentAllow = this.getValidateForm();
        return currentAllow.success;
    },
    getValidateForm: getValidateForm,
    _resetModel: function (model) {
        model.$reset();

    },
    /*  ---UPLOAD---*/

    _uploadData: function (event) {
        $(this.uploadConfig.uploadElementsSelectors.file).click();
        event.stopPropagation();

    },
    setConfigurationMap: function (valuesCurrent = null, createUpdate) {
        var currentLtLng;
        var $scope = this;
        var marker_object;
        if (!createUpdate) {//update
            this.initDataRows.count = 1;
            var title = valuesCurrent.title;
            var lat = valuesCurrent.street_lat;
            var lng = valuesCurrent.street_lng;
            var business_subcategories_id = valuesCurrent.business_subcategories_id;
            var subcategory = getSubCategory(business_subcategories_id);
            var urlIcon = "";
            if (!subcategory) {
                urlIcon = "https://furtaev.ru/preview/user_on_map.png";

            } else {
                urlIcon = subcategory.marker;
            }
            var content = "<div>" + title + "</div>";
            var width = 30, height = 40;

            var iconCurrent = {
                url: urlIcon,
                scaledSize: new google.maps.Size(width, height), // scaled size
                origin: new google.maps.Point(0, 0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
            marker_object = new google.maps.Marker({
                draggable: false,
                title: title,
                animation: google.maps.Animation.DROP,
                position: new google.maps.LatLng(lat, lng),
                icon: iconCurrent,
                content: content
            });
            var params_data = {map: map, marker: marker_object, content: content};
            currentWulpy.addMarker(params_data);
            $scope._markersCurrent(marker_object);
            var index = valuesCurrent.index;
            $scope.model.attributes = valuesCurrent;
            $scope.model.attributes["keyRef"] = index;
            myLatlng = {lat: parseFloat(lat), lng: parseFloat(lng)};
            currentLtLng = new google.maps.LatLng(lat, lng);
            map.setCenter(myLatlng);

        } else {
            this.initDataRows.count = 0;
            var title = "Mueva el marker";
            var lat = myLatlng.lat;
            var lng = myLatlng.lng;
            var width = 30, height = 40;
            var iconCurrent = {
                url: "https://furtaev.ru/preview/user_on_map.png",
                scaledSize: new google.maps.Size(width, height), // scaled size
                origin: new google.maps.Point(0, 0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
            var content = "<div>" + title + "</div>";
            marker_object = new google.maps.Marker({
                draggable: false,
                title: title,
                animation: google.maps.Animation.tweeners,
                position: new google.maps.LatLng(lat, lng),
                icon: iconCurrent,
                content: content
            });
            var params_data = {map: map, marker: marker_object, content: content};
            currentWulpy.addMarker(params_data);
            $scope._markersCurrent(marker_object);
            currentLtLng = new google.maps.LatLng(lat, lng);

        }

        this.mapCurrent.setCenter(currentLtLng);
        var mapCurrent = this.mapCurrent;
        var paramsAutocomplete = {mapCurrent: mapCurrent, marker: marker_object};
        this._initAutocomplete(paramsAutocomplete);
    },
    _initAutocomplete: function (params) {
        // Create the autocomplete object, restricting the search predictions to
        // geographical location types.

        var elementId = 'search-map-current';
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById(elementId), {types: ['geocode']});
        var mapCurrent = params['mapCurrent'];
        var mapInit = mapCurrent;
        var markerInit = params.marker;
        // Avoid paying for data that you don't need by restricting the set of
        // place fields that are returned to just the address components.
        autocomplete.setFields(['address_component', 'geometry', 'icon', 'name']);
        autocomplete.bindTo('bounds', mapInit);
        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
        var $scope = this;
        autocomplete.addListener('place_changed', function () {
            $scope.fillInAddress({
                autocomplete: this,
                map: mapInit,
                marker: markerInit
            });
        });
    },
    fillInAddress: function (params) {
        var map = params.map;
        var marker = params.marker;
        var autocomplete = params.autocomplete;

        // Get each component of the address from the place details,
        // and then fill-in the corresponding field on the form.
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
        }
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

    },
    setPositionMapCenter: function (currentLtLng) {
        currentLtLng = new google.maps.LatLng(parseFloat(currentLtLng.lat), parseFloat(currentLtLng.lng));
        this.mapCurrent.setCenter(currentLtLng);
    },
    initMapCurrent: function () {
        markers = [];
        if(currentWulpy.initMap){
            this.mapCurrent = currentWulpy.initMap("#map");
            var dataMarker = null;
            var createUpdate = !this.businessCreate;
            var currentLtLng;
            if (!createUpdate) {
                currentLtLng = {lat: this.model.attributes.street_lat, lng: this.model.attributes.street_lng};
                dataMarker = this.model.attributes;
            } else {
                currentLtLng = {lat: myLatlng.lat, lng: myLatlng.lng};
            }
            this._mapCurrent({
                mapCurrent: this.mapCurrent,
                initMarker: {data: dataMarker, createUpdate: createUpdate}
            });


            this.setPositionMapCenter(currentLtLng);
            $.each(markers, function (key, value) {
                value.setMap(null);
            });
            this.setConfigurationMap(dataMarker, createUpdate);
        }



    },
    /*MAPS*/
    _mapCurrent: function (params) {

        mapCurrent = params.mapCurrent;
        var $scope = this;
        var geocoder = new google.maps.Geocoder();
        mapCurrent.addListener('idle', function () {

        });
//----clic en l map---
        google.maps.event.addListener(mapCurrent, 'click', function (e) {
            cont_fi = 0;
            lat = e.latLng.lat();
            lng = e.latLng.lng();
            var timestamp = new Date().getTime()
            params = {
                data: {lat: lat, lng: lng, timestamp: timestamp, cont_fi: cont_fi},
                bdd_node: "coordenadas"
            };


            geocoder.geocode({'latLng': e.latLng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        console.log(results[1].formatted_address);
                        console.log(results);

                    }
                } else {
                    alert("Geocoder failed due to: " + status);
                }
            });

        });
        google.maps.event.addListener(mapCurrent, 'dblclick', function (e) {
            console.log("addListener map_data dblclick");

        });


        google.maps.event.addListener(mapCurrent, 'mouseup', function (e) {
//            console.log("addListener map_data mouseup");

        });
        google.maps.event.addListener(mapCurrent, 'mousedown', function (e) {
//            console.log("addListener map_data mousedown");

        });
        google.maps.event.addListener(mapCurrent, 'mouseover', function (e) {
//            console.log("addListener map_data mouseover");

        });
        google.maps.event.addListener(mapCurrent, 'mouseout', function (e) {
//            console.log("addListener map_data mouseout");

        });
        mapCurrent.addListener('zoom_changed', function () {

        });
        mapCurrent.addListener('drag', function (e) {


        });
        mapCurrent.addListener('center_changed', function () {

            var centerCurrent = mapCurrent.getCenter();

            if (markers.length) {

                markers[0].setPosition(mapCurrent.getCenter());

                $scope._setManagerPosition(mapCurrent.getCenter());

            }
        });
    },
    _setManagerPosition: function (position) {
        this.latLngCurrent = {lng: position.lng(), lat: position.lat()};
        currentLtLng = this.latLngCurrent;
        this.model.attributes.street_lng = currentLtLng.lng;
        this.model.attributes.street_lat = currentLtLng.lat;

    },
    _markersCurrent: function (marker) {
        var $scope = this;
        // Add dragging event listeners.
        google.maps.event.addListener(marker, 'dragstart', function () {
            console.log("dragstart");
//            updateMarkerAddress('Dragging...');

        });

        google.maps.event.addListener(marker, 'drag', function () {
            $scope._setManagerPosition(marker.getPosition());
        });

        google.maps.event.addListener(marker, 'dragend', function () {

        });
        google.maps.event.addListener(marker, 'click', function () {
            if (false) {

                var infoWindowOptions = {
                    content: marker.content
                };
                var infoWindow = new google.maps.InfoWindow(infoWindowOptions);
                infoWindow.open(map, marker);
            }

            $scope.latLngCurrent = {lng: marker.getPosition().lng(), lat: marker.getPosition().lat()};

            $scope._viewModalManager({lng: marker.getPosition().lng(), lat: marker.getPosition().lat()});

            currentLtLng = $scope.latLngCurrent;

            window.setTimeout(function () {
                $scope.setPositionMapCenter(currentLtLng);
            }, 1000);
        });
    },
    _viewModalManager: function () {

    },
    setCurrentLatLngForm: function (latLngCurrent) {
        var element = $("#business_street_lat");
        element.val(latLngCurrent.lat);
        element = $("#business_street_lng");
        element.val(latLngCurrent.lng);
    },
    //S2
    _managerS2Amenities: function (params) {
        var el = params.objSelector;
        var dataCurrent = [];
        var $scope = this;
        var modelId = params.modelId;
        var businessId = modelId;
        var attributeModel = 'business_by_amenities_data';

        function getFilters(params) {
            var term = params.term;
            var page = params.page;
            var subcategory_id = $scope.model.attributes.business_subcategories_id;
            var result = {
                filters: {
                    search_value: term,
                    business_id: businessId,
                    subcategory_id: subcategory_id,

                }
            };
            return result;
        }

        var elementInit = $(el).select2({
            allow: true,
            placeholder: "Seleccione",
            ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                url: $("#action-business-amenities-listSelect2").val(),
                type: "get",
                dataType: 'json',
                data: function (term, page) {
                    var paramsFilters = getFilters({term: term, page: page});
                    return paramsFilters;
                },
                processResults: function (data, page) {
                    return {results: data};
                }
            },
            allowClear: true,
            multiple: true,
            width: '100%',


        });
        elementInit.on("change", function (e) {
            var dataCurrent = elementInit.select2('data');
            if (dataCurrent.length != 0) {
                $scope.model.attributes[attributeModel] = dataCurrent;
            } else {
                $scope.model.attributes[attributeModel] = null;
                $scope._setValueForm(attributeModel, null);
            }
        });

        if (modelId) {
            $scope.setValuesS2Multiple({
                modelId: modelId,
                elementS2: $(el),
                attributeModel: attributeModel,
                'types': 'sizes'
            });
        }

    },
    setValuesS2Multiple: function (params) {
        var modelId = params['modelId'];//id
        var elementS2 = params['elementS2'];
        var attributeModel = params['attributeModel'];
        var modelData = this.model.attributes[attributeModel];
        if (typeof (modelData) != 'undefined' && modelData.length) {
            dataCurrent = modelData;
            $.each(dataCurrent, function (key, value) {
                var option = new Option(value.text, value.id, true, true);
                elementS2.append(option).trigger('change');
            });
            var dataCurrent = elementS2.select2('data');
            this.model.attributes[attributeModel] = dataCurrent;
        }

    }
    ,

}
})
;

