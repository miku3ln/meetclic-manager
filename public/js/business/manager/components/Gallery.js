var componentThisGallery;
var galleryComponent = Vue.component('gallery-component', {
    template: '#gallery-template',
    props: {
        parentData: {
            type: String,
            default: function () {
                return '';
            }
        },
        title: {
            type: String
        },
        messageParent: {
            type: String
        },
        params: {
            type: Object,
        },
        titleEvent: {
            type: String
        }
    }, beforeMount: function () {
        this.configParams = this.params;
        this.businessId = this.configParams.business_id;

    },
    created: function () {

    },
    mounted: function () {
        componentThisGallery = {this: this};
        this.initCurrentComponent();
        removeClassNotView();
    },
    validations: {
        modelGallery: {
            attributes: {
                description: {},
                src: {
                    required
                },
                position: {},
                type: {},
                config: {},
                status: {},
                title: {
                    required
                },
                subtitle: {},
            }
        },

    },

    data: function () {

        var dataManager = {
            message: 'hello!',
            configParams: {},
            //uploads
            uploadConfig: {
                uploadElementsSelectors: {
                    image: "#file_upload_gallery"
                },
                labelsButtons: {
                    image: "Subir Imagen.",

                },
                viewUpload: {
                    image: "#preview-gallery-src"
                }
            },
            lblBtnSave: "Guardar",
            lblBtnClose: "Cerrar",
            modelGallery: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#tab-gallery',
            processName: "Galería Empresa",
            formConfig: {
                nameSelector: "#business-by-gallery-form",
                url: $('#action_gallery_save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ' + this.processName,
                successMessage: 'La imagen  se guardo correctamente.',
                nameModel:'Gallery'
            },
            gridSelectorCurrent: "#gallery-grid",
            submitStatus: "no",
            showManager: false,
            businessId: null,
            optionsShortcut: getDataShortCut(),
            /*    ----GRID ----*/
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null,
                rowData: []
            }
        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        onSlideStart: function (slide) {
            this.sliding = true;
        },
        onSlideEnd: function (slide) {
            this.sliding = false;
        },
        _viewManager: _viewManager,
        /*  EVENTS*/
        _setValueOfParent: function (params) {
            var type = params.type;
            var dataGet = params.dataSend;
            var modelBusiness = dataGet.modelData;
            this.initCurrentComponent();
        },
        _dataChildren: function () {
            /* this.params.titleEvent = "Cambio evento";*/
            /*EVENT BUS*/
            if (false) {
                appInit.$emit('_updateTitleEvents', 'Vue data title');
            } else {

                this.$emit('_data-components-children', {
                    nameEvent: "_dataChildren",
                    nameComponent: "Routes",
                    response: this._data
                });
            }
            this.params.titleEvent = "Hola Cambiado";

        },
        /*FORM*/
        _submitForm: function (e) {
            console.log(e);
        },
        getAttributesForm: function () {
            var result = {
                description: null,
                src: null,
                change: false,
                position: 0,
                type: 0,
                config: "",
                status: true,
                title: null,
                subtitle: null
            };

            return result;
        },
        getStructureForm: function () {
            var result = {
                description:
                    {
                        id: "description",
                        name: "description",
                        label: "Descripción",
                        required:
                            {
                                allow: false,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                src: {
                    name: "src",
                    label: "Imagen ",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },

                title: {
                    name: "title",
                    label: "Titulo",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                subtitle: {
                    name: "subtitle",
                    label: "Subtitulo",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                status: {
                    name: "status",
                    label: "Estado",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },

            };

            return result;
        },
        getItemsCurrent: function () {

            var result = treeData;
            return result;
        },

        getLabelForm: function (nameId) {

            var labelName = viewGetLabelForm(nameId,this.modelGallery);
            return labelName;
        },

        /* validations*/
        hasErrorElement: function (nameElement, valueModel) {
            var msj = "";
            var hasError = false;
            if (!this.modelGallery.init) {

                switch (nameElement) {
                    case 'title':
                        valueModel = valueModel ? valueModel : "";
                        var validationResult = Validator.value(valueModel).required();
                        msj = "";
                        if (Object.keys(validationResult["_messages"]).length) {
                            var msjCurrent = validationResult["_messages"];
                            msj = msjCurrent[0];
                            hasError = true;
                        } else {
                            hasError = false;
                        }
                        this.modelGalleryValidations[nameElement].required.error = hasError;
                        break;
                }

            } else {
                hasError = false;
            }
            return !hasError;
        },
        getViewErrorElement: function (nameElement, objValidate) {
            var notView = true;
            if (objValidate.$dirty) {

                if (nameElement == "title") {
                    if (!objValidate.required) {
                        notView = false;
                    }
                    if (!objValidate.minLength) {
                        notView = false;

                    }
                }
            } else {
                notView = true;
            }
            return notView;//false=view,true=not-view
        },
        _setValueForm: function (name, value) {

            this.modelGallery.attributes[name] = value;
            this.$v["modelGallery"]["attributes"][name].$touch();
            this._valuesForm();
        },
        getClassErrorForm: function (nameElement, objValidate) {

            var result = {
                "form-group--error": objValidate.$error,
                'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
            }

            return result;
        },
        _saveGallery: function () {
            var dataSend = {
                id: this.modelGallery.attributes.id,
                description: this.modelGallery.attributes.description,
                src: this.modelGallery.attributes.src,
                position: this.modelGallery.attributes.position,
                type: this.modelGallery.attributes.type,
                config: this.modelGallery.attributes.config,
                business_id: this.businessId,
                status: this.modelGallery.attributes.status ? "ACTIVE" : "INACTIVE",
                title: this.modelGallery.attributes.title,
                subtitle: this.modelGallery.attributes.subtitle,
                change: this.modelGallery.attributes.change
            };
            var _this = this;
            _this.$v.$touch();
            if (this.$v.$invalid) {
                _this.submitStatus = 'error';

            } else {

                ajaxRequest(this.formConfig.url, {
                    type: 'POST',
                    data: dataSend,
                    blockElement: _this.tabCurrentSelector,//opcional: es para bloquear el elemento
                    loading_message: _this.formConfig.loadingMessage,
                    error_message: _this.formConfig.errorMessage,
                    success_message: _this.formConfig.successMessage,
                    success_callback: function (response) {

                        if (response.success) {
                            _this.resetForm(true);
                            $(_this.gridSelectorCurrent).bootgrid("reload");
                            _this._viewManager(2);
                        }
                    }
                }, true);
            }
        },
        resetForm: function (save) {
            this.modelGallery = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm()
            };
            this.$v.modelGallery.attributes.title.$model = null;
            this.$v.modelGallery.attributes.description.$model = null;
            this.$v.modelGallery.attributes.subtitle.$model = null;
            this.$v.modelGallery.attributes.type.$model = 0;
            this.$v.modelGallery.attributes.position.$model = 0;
            this.modelGallery.attributes.id = null;
            this.modelGallery.attributes.config = null;
            this.modelGallery.attributes.status = true;
            this.modelGallery.attributes.change = false;
            this.modelGallery.attributes.src = null;
            var srcImage = $notImageUrl;
            $(this.uploadConfig.viewUpload.image).attr("src", srcImage);
            $(this.uploadConfig.uploadElementsSelectors.image).val("");
            this.$v.$reset();
            if (save) {
                this._resetManagerGrid();
            }
        },
        _valuesForm: function (event) {
            this.modelGallery.init = false;
            this.validateForm();
        },
        validateForm: function () {
            var currentAllow = true;
            if (!this.modelGallery.attributes.title || !this.modelGallery.attributes.src) {
                currentAllow = false;

            }
            return currentAllow;
        },
        //MANAGER PROCESS
        _managerRowGrid: function (params) {
            this._viewManager(1);
            var rowCurrent = params.row;
            var rowId = params.id;
            this.modelGallery.attributes["change"] = false;
            var srcImage = rowCurrent.src == 'nothing' ? $notImageUrl : rowCurrent.src;
            $(this.uploadConfig.viewUpload.image).attr("src", $resourceRoot + srcImage);

            this.$v.modelGallery.attributes.title.$model = rowCurrent.title;
            this.$v.modelGallery.attributes.description.$model = (rowCurrent.description !== "null" && rowCurrent.description) ? rowCurrent.description : "";
            this.$v.modelGallery.attributes.subtitle.$model = (rowCurrent.subtitle !== "null" && rowCurrent.subtitle) ? rowCurrent.subtitle : "";
            this.$v.modelGallery.attributes.type.$model = rowCurrent.type;
            this.$v.modelGallery.attributes.position.$model = rowCurrent.position;
            this.$v.modelGallery.attributes.config.$model = rowCurrent.config;
            this.$v.modelGallery.attributes.status.$model = rowCurrent.status == "ACTIVE" ? true : false;

            this.modelGallery.attributes.id = rowId;
            this.modelGallery.attributes.config = rowCurrent.config;
            this.modelGallery.attributes.status = rowCurrent.status == "ACTIVE" ? true : false;
            this.modelGallery.attributes.change = false;
            this.modelGallery.attributes["src"] = srcImage;


        },
        getMenuConfigGridRow: function (params) {
            $configModelEntityGallery = {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        "manager-type": "update"
                    }
                ]
            };
            var buttonsManagements = $configModelEntityGallery["buttonsManagements"];
            var result = [];
            $.each(buttonsManagements, function (key, value) {
                var setPush = {
                    title: value["title"],
                    "data-placement": value["data-placement"],
                    icon: value["i-class"],
                    data: value,
                    rowId: params.rowId,
                    managerType: value["manager-type"],
                    params: params
                }
                result.push(setPush);
            });
            return result;
        },
        /*---------GRID--------*/
        _managerMenuGrid: function (key, menu) {
            if (menu.managerType == "update") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);

                this._managerRowGrid({
                    row: menu.params["rowData"],
                    id: menu.rowId
                });
                this.managerMenuConfig.view = false;

            }

        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridSelectorCurrent;
            var urlCurrent = $("#action_gallery_admin").val();
            var business_id = this.businessId;
            var paramsFilters = {
                business_id: business_id
            };
            let gridId = $(gridName);
            gridId.bootgrid({
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
                        var subtitle = row.subtitle ? [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Subtitulo:</span><span class='content-description__value'>" + (row.subtitle) + "</span>",
                            "</div>",

                        ] : [];
                        subtitle = subtitle.join("");
                        var description = (row.description !== "null" && row.description) ? [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Description:</span><span class='content-description__value'>" + (row.description) + "</span>",
                            "</div>",

                        ] : [];
                        description = description.join("");


                        var result = [
                            "<div    class='content-description'>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Estado:</span><span class='content-description__value'>" + (row.status == "ACTIVE" ? "ACTIVO" : "INACTIVO") + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Titulo:</span><span class='content-description__value'>" + (row.title) + "</span>",
                            "</div>",
                            subtitle,
                            description,
                            "<div class='content-description__information'>",
                            "   <img class='content-description__image' src='" + $resourceRoot + row.src + "'>",
                            "</div>",
                            "</div>"
                        ];
                        return result.join("");
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function () {
                vmCurrent._resetManagerGrid();
                vmCurrent._gridManager(gridId, vmCurrent);
            });
        },
        _resetManagerGrid: function () {
            this.managerMenuConfig = {
                view: false,
                menuCurrent: [],
                rowId: null,
                rowData: []
            };
        },
        _destroyTooltip: function (selector) {
            $(selector).tooltip('hide');
        },
        _gridManager: function (elementSelect, vmCurrent) {
            var paramsGrid = {
                gridCurrentSelector: vmCurrent.gridSelectorCurrent
            };

            var selectorIdGrid = $(elementSelect).attr("id");
            var selectorCurrentTrManager = "#" + selectorIdGrid + " tbody tr";
            elementSelect.find("tbody tr").on("click", function (e) {
                var self = $(this);
                var dataRowId = $(self[0]).attr("data-row-id");
                var rowId = dataRowId;
                var currentRowSelector;
                if (dataRowId) {
                    var instance_data_rows = $(paramsGrid.gridCurrentSelector).bootgrid("getCurrentRows");
                    var rowData = searchElementJson(instance_data_rows, 'id', dataRowId);//asi s obtiene los valores del registro en funcion d su id
                    currentRowSelector = selectorCurrentTrManager + "[data-row-id='" + rowId + "']";
                    $(currentRowSelector).removeClass("selected");
                    var newEventRow = false;
                    rowData = rowData[0];
                    if (vmCurrent.managerMenuConfig.rowId) {//ready selected
                        var removeRowId = vmCurrent.managerMenuConfig.rowId;
                        if (dataRowId == removeRowId) {
                            currentRowSelector = selectorCurrentTrManager + "[data-row-id='" + removeRowId + "']";
                            $(currentRowSelector).removeClass("selected");
                            vmCurrent._resetManagerGrid();
                        } else {
                            currentRowSelector = selectorCurrentTrManager + "[data-row-id='" + removeRowId + "']";
                            $(currentRowSelector).removeClass("selected");
                            newEventRow = true;
                        }
                    } else {
                        newEventRow = true;
                    }
                    if (newEventRow) {

                        currentRowSelector = selectorCurrentTrManager + "[data-row-id='" + rowId + "']";
                        $(currentRowSelector).addClass("selected");
                        vmCurrent.managerMenuConfig = {
                            view: true,
                            menuCurrent: vmCurrent.getMenuConfigGridRow({rowData: rowData, rowId: dataRowId}),
                            rowId: dataRowId
                        };


                    }

                }

            });
        },
        /*---MODAL CURRENT--*/
        _closeModal: function () {
            closeModal();
        },
        initCurrentComponent: function () {
            this._initEventsUpload();
            this.initGridManager(this);

        },

        //upload image
        _uploadDataImage: function (event) {
            $(this.uploadConfig.uploadElementsSelectors.image).click();
            event.stopPropagation();
        },
        _initEventsUpload: function () {
            var _this = this;
            var progress = document.querySelector('.percent');
//------------GESTION DE SUBIDA D IMAGENS---
            $(this.uploadConfig.uploadElementsSelectors.image).change(function () {
                var file = $(this)[0].files[0];
                if (file) {
                    if (file.type == "image/png" || file.type == "image/jpeg" || file.type == "image/svg+xml") {//format kml
                        var srcSource = window.URL.createObjectURL(file);
                        $(_this.uploadConfig.viewUpload.image).attr("src", srcSource);
                        _this.modelGallery.attributes.src = file;
                        if (_this.modelGallery.attributes.id) {
                            _this.modelGallery.attributes.change = true;

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
                    progress.style.width = '100%';
                    progress.textContent = '100%';

                } else if (event.type === "loadend") {

                } else if (event.type === "abort") {

                } else if (event.type === "loadstart") {
                    document.getElementById('progress_bar').className = 'loading';

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
                    ;
                } else if (event.type === "progress") {
                    if (event.lengthComputable) {
                        var percentLoaded = Math.round((event.loaded / event.total) * 100);
                        // Increase the progress bar length.
                        if (percentLoaded < 100) {
                            progress.style.width = percentLoaded + '%';
                            progress.textContent = percentLoaded + '%';
                        }
                    }
                }
            }

        }
    },

});

