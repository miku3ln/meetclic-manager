var componentThisEducationalInstitutionByBusiness;
var business_id;
var btn_save_entidad;//
var entidad_data_id;
var modelAskwer;
var data_new = true;
var form_element = '#askwer-form-form';
var $modelAskwerInit;


AskwerUtilManager = function () {

    this.getStructureFormSave = function (paramsData) {
        var haystack = paramsData.haystack;
        var result;
        var radioButtonsValidations = paramsData.radioButtonsValidations;
        var checkButtonsValidations = paramsData.checkButtonsValidations;
        $.each(radioButtonsValidations, function (keySection, valueSection) {
            $.each(valueSection, function (keyField, valueField) {
                $.each(valueField, function (keyOption, valueOption) {

                    if (valueOption.required) {
                        var keysInfo = valueOption.keysInfo;
                        var keysArray = keysInfo.split(',');
                        var section_id = keysArray[0].split(":")[1];
                        var field_type = keysArray[1].split(":")[1];
                        var field_row_id = keysArray[2].split(":")[1];
                        var comment_value = valueOption.model;
                        var answer_key = field_row_id + "_" + field_type;
                        var valueSelect = haystack[section_id][answer_key];
                        var stringObj = "'option_id':" + valueSelect + ",'comment_value':" + comment_value;
                        haystack[section_id][answer_key] = stringObj;

                    }
                });
            });
        });

        $.each(checkButtonsValidations, function (keySection, valueSection) {
            console.log("keySection", keySection);


            $.each(valueSection, function (keyField, valueFields) {
                console.log("keyField", keyField);
                var lucky = [];
                $.each(valueFields, function (keyOption, valueOption) {
                    if (valueOption.required) {
                        var setLucky = {
                            keysInfo: valueOption.keysInfo,
                            model: valueOption.model,
                            required: valueOption.required,
                            option_id: keyOption
                        };

                        lucky.push(setLucky);
                    }
                });
                var cont = lucky.length - 1;
                var contAux = 0;
                var field_type = null;
                var field_row_id = null;
                var section_id = null;

                //string seteo
                var stringResult = "";
                $.each(lucky, function (keyOption, valueOption) {
                    var keysInfo = valueOption.keysInfo;
                    var keysArray = keysInfo.split(',');
                    console.log(keysArray);
                    field_type = keysArray[1].split(":")[1];
                    section_id = keysArray[0].split(":")[1];
                    field_row_id = keysArray[2].split(":")[1];
                    var comment_value = valueOption.model;

                    if (contAux < cont) {
                        stringResult += "'option_id':" + valueOption.option_id + "/'comment_value':" + comment_value + ",";
                    } else {
                        stringResult += "'option_id':" + valueOption.option_id + "/'comment_value':" + comment_value;
                    }
                    contAux++;
                });
                var answer_key = field_row_id + "_" + field_type;
                if (lucky.length > 0) {

                    haystack[section_id][answer_key] = stringResult;
                }

            });
        });
        result = haystack;
        return result;
    };

    this.generateAskwerFormFields = function (dataAskwer) {
        var modelInstitucionHasAskwer = dataAskwer.InstitucionHasAskwer;
        var AskwerForm = {
            id: dataAskwer["AskwerForm"]["id"],
            description: dataAskwer["AskwerForm"]["description"],
        };

        var sections = dataAskwer.AskwerForm.sections;
        var result = getDataAskwerForm(sections);
        solutions = {};
        sections = {};
        radioButtonsValidations = {};
        checkButtonsValidations = {};
        solutions = result.solutions;
        sections = result.sections;
        radioButtonsValidations = result.radioButtonsValidations;
        checkButtonsValidations = result.checkButtonsValidations;

        return result;


    };
    getDataAskwerForm = function (sections) {
        var fieldType = 2;
        var resultSectionsAllow = getSectionsAskwer(sections, fieldType);
        var radioButtonsValidations = [];
        if (resultSectionsAllow.success) {
            var stringSections = getObjSectionAskwer(resultSectionsAllow.data);

            radioButtonsValidations = JSON.parse(stringSections);
        }

        fieldType = 3;
        var resultSectionsAllow = getSectionsAskwer(sections, fieldType);
        var checkButtonsValidations = [];
        if (resultSectionsAllow.success) {
            var stringSections = getObjSectionAskwer(resultSectionsAllow.data);

            checkButtonsValidations = JSON.parse(stringSections);
        }

        var sectionsResult = {};
        var info = "";
        var count = sections.length - 1;
        var countAux = 0;

        $.each(sections, function (key, value) {
            var section_id = value.id;
            if (countAux < count) {

                info += '"' + section_id + '"' + ":" + "{}" + ",";
            } else {
                info += '"' + section_id + '"' + ":" + "{}";

            }
            countAux++;
        });
        var info = "{" + info + "}";

        var solutions = JSON.parse(info);
        sectionsResult = sections;

        var result = {
            sections: sectionsResult,
            solutions: solutions,
            checkButtonsValidations: checkButtonsValidations,
            radioButtonsValidations: radioButtonsValidations

        }
        return result;

    };
    getObjSectionAskwer = function (data, fieldType) {
        var stringData = "";
        var stringDataResult = "";
        var countSections = data.length - 1;
        var countSectionsAux = 0;

        $.each(data, function (key, value) {
            var dataFields = value.dataFields;
            var section_id = value.section_id;
            var stringFields = dataFields;
            if (countSectionsAux < countSections) {
                stringData += '"' + section_id + '"' + ":" + "{" + stringFields + "}" + ",";
            } else {
                stringData += '"' + section_id + '"' + ":" + "{" + stringFields + "}";
            }
            countSectionsAux++;
        });
        stringDataResult = "{" + stringData + "}";
        return stringDataResult;
    };
    getSectionsAskwer = function (sections, fieldType) {
        var resultCurrent = {success: false, data: []};
        $.each(sections, function (key, value) {
            var section_id = value.id;
            var result = getFieldsAskwer(value.fields, fieldType);
            if (result.success) {//basta uno
                resultCurrent.success = true;
                var dataSection = {dataFields: result.data, section_id: section_id};
                resultCurrent.data.push(dataSection);

            }
        });
        return resultCurrent;
    };
    getFieldsAskwer = function (fields, fieldType) {
        var result = {
            success: false,
            data: []
        }
        var lucky = fields.filter(function (value) {
            return fieldType == value.field_type && value.comment_allow == 1;
        });
        var countAux = 0;
        var count = lucky.length - 1;
        var info = "";
        $.each(lucky, function (key, valueFields) {
            var field_id = valueFields.id;
            var fieldOptions = getValuesOptionsAskwer(valueFields.fieldOptions);
            if (countAux < count) {

                info += '"' + field_id + '"' + ":" + "{" + fieldOptions + "}" + ",";
            } else {
                info += '"' + field_id + '"' + ":" + "{" + fieldOptions + "}";

            }
            countAux++;
        });
        result.success = lucky.length > 0 ? true : false;
        result.data = info;

        return result;
    };
    getValuesOptionsAskwer = function (fieldOptions) {
        var info = "";
        var count = fieldOptions.length - 1;
        var countAux = 0;
        $.each(fieldOptions, function (key, valueFields) {
            var option_id = valueFields.id;

            if (countAux < count) {

                info += '"' + option_id + '"' + ":" + '{"required":false}' + ",";
            } else {
                info += '"' + option_id + '"' + ":" + '{"required":false}';

            }
            countAux++;
        });
        return info;
    };


}


var askwerUtil = new AskwerUtilManager;
Vue.component('educational-institution-by-business-component', {
    components: {
        'star-rating': VueRateIt.StarRating//https://craigh411.github.io/vue-rate-it/#/docs/stars
    },
    template: '#educational-institution-by-business-template',
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var vmCurrent = this;
        this.$root.$on("_updateParentByChildren", function (emitValue) {
            vmCurrent._managerTypes(emitValue);
        });
    },
    beforeMount: function () {
        this.configParams = this.params;
        this.business_id =  $businessManager.id;//this.configParams.business_id;
        business_id = this.business_id;
    },
    mounted: function () {
        componentThisEducationalInstitutionByBusiness = this;
        this.initCurrentComponent();
        removeClassNotView();

    },
    computed: {},
    data: function () {

        var dataManager = {
            business_id: null,
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        "managerType": "updateEntity"
                    },
                    {
                        "title": "Ver formularios",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-ruler",
                        "managerType": "viewEntity"
                    },
                    {
                        "title": "Resultados",
                        "data-placement": "top",
                        "i-class": "fa fa fa-list",
                        "managerType": "viewResults"
                    }
                ]
            },
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
            configParams: {},
            labelsConfig: {buttons: {'create': 'Crear', 'update': 'Actualizar'}},
            tabCurrentSelector: '#tab-educational-institution-by-business',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#educational-institution-by-business-form",
                url: $('#action-educational-institution-by-business-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el EducationalInstitutionByBusiness.',
                successMessage: 'El EducationalInstitutionByBusiness se guardo correctamente.',
                nameModel: "EducationalInstitutionByBusiness"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#educational-institution-by-business-grid",
                url: $("#action-educational-institution-by-business-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            viewsManager: {
                form: false,
                admin: true,
                results: false,
                managerForm: false,
            },
            askwerManager: {
                nameFormManager: 'managerForm',
                sections: [],
                checkbox: [],
                checkButtonsValidations: [],
                radioButtonsValidations: [],
                modelsSolutions: [],
                sectionsValidations: [],
                managerFilters: {},
                resultsAnswers: [],
                managerAskwer: {}
            },
            rating: 3,
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {
            this.initGridManager(this);

        },
//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
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
        _destroyTooltip: function (selector) {
         /*   $(selector).tooltip('hide');*/
        },
        _resetManagerGrid: function () {
            this.managerMenuConfig = {
                view: false,
                menuCurrent: [],
                rowId: null
            };
        },
        _managerMenuGrid: function (index, menu) {
            var params = {managerType: menu.managerType, id: menu.rowId, row: menu.params.rowData};
            this._managerRowGrid(params);
        },
        getMenuConfig: function (params) {
            var result = [];
            $.each(this.configModelEntity["buttonsManagements"], function (key, value) {
                var setPush = {
                    title: value["title"],
                    "data-placement": value["data-placement"],
                    icon: value["i-class"],
                    data: value, rowId: params.rowId,
                    managerType: value["managerType"],
                    params: params
                }
                result.push(setPush);
            });
            return result;
        },
        _gridManager: function (elementSelect) {
            var vmCurrent = this;
            var selectorGrid = vmCurrent.gridConfig.selectorCurrent;
            elementSelect.find("tbody tr").on("click", function (e) {
                var self = $(this);
                var dataRowId = $(self[0]).attr("data-row-id");
                var selectorRow;
                if (dataRowId) {
                    var instance_data_rows = $(selectorGrid).bootgrid("getCurrentRows");
                    var rowData = searchElementJson(instance_data_rows, 'id', dataRowId);//asi s obtiene los valores del registro en funcion d su id
                    elementSelect.find("tr.selected").removeClass("selected");
                    var newEventRow = false;
                    if (vmCurrent.managerMenuConfig.rowId) {//ready selected
                        var removeRowId = vmCurrent.managerMenuConfig.rowId;
                        if (dataRowId == removeRowId) {
                            selectorRow = selectorGrid + " tr[data-row-id='" + removeRowId + "']";
                            $(selectorRow).removeClass("selected");
                            vmCurrent._resetManagerGrid();
                        } else {

                            newEventRow = true;
                        }
                    } else {
                        newEventRow = true;
                    }
                    if (newEventRow) {
                        selectorRow = selectorGrid + " tr[data-row-id='" + dataRowId + "']";
                        $(selectorRow).addClass("selected");
                        vmCurrent.managerMenuConfig = {
                            view: true,
                            menuCurrent: vmCurrent.getMenuConfig({rowData: rowData[0], rowId: dataRowId}),
                            rowId: dataRowId
                        };
                    }

                }
            });
        },
        _managerRowGrid: function (params) {
            var _this = this;
            var rowCurrent = params.row;
            var rowId = params.id;
            var dataSend;
            if (params.managerType == "updateEntity") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                dataSend = {
                    EducationalInstitutionByBusiness: {
                        id: rowId
                    },
                };
                ajaxRequest($('#action-educational-institution-askwer-type-getDataAskwer').val(), {
                    type: 'POST',
                    data: dataSend,
                    blockElement: this.tabCurrentSelector,//
                    loading_message: 'Cargando...',
                    error_message: 'Error al cargar informacion.',
                    success_message: 'Informacion Cargada.',
                    success_callback: function (response) {

                        if (response.success) {
                            var dataResponse = response.data;
                            dataResponse['AskwerForm']['educational_institution_askwer_type_id'] = rowCurrent.educational_institution_askwer_type_id;
                            dataResponse['AskwerForm']['educational_institution_askwer_type'] = rowCurrent.educational_institution_askwer_type;
                            $modelAskwerInit.setDataManager(dataResponse);
                            _this._viewManager(3, rowId);
                        } else {
                            var errorsCurrent = response.msj;

                        }

                    }
                });

            } else if (params.managerType == "viewEntity") {
                dataSend = {
                    EducationalInstitutionByBusiness: {
                        id: rowId
                    },
                };
                ajaxRequest($('#action-educational-institution-by-business-getDataAskwerForm').val(), {
                    type: 'POST',
                    data: dataSend,
                    blockElement: this.tabCurrentSelector,//
                    loading_message: 'Cargando...',
                    error_message: 'Error al cargar informacion.',
                    success_message: 'Informacion Cargada.',
                    success_callback: function (response) {

                        if (response.success) {
                            var dataResponse = response.data;
                            _this.askwerManager.sections = dataResponse.AskwerForm.sections;
                            var managerModels = _this.getStructureAskwerManager();
                            _this.askwerManager.checkButtonsValidations = managerModels['checkButtonsValidations'];
                            _this.askwerManager.radioButtonsValidations = managerModels['radioButtonsValidations'];
                            _this.askwerManager.checkbox = managerModels['checkbox'];
                            _this.askwerManager.modelsSolutions = managerModels['modelsSolutions'];
                            _this.askwerManager.sectionsValidations = managerModels['sectionsValidations'];
                            _this.askwerManager.managerFilters = {
                                AskwerForm: {
                                    id: dataResponse.AskwerForm.id,

                                },
                                EducationalInstitutionByBusiness: dataResponse.EducationalInstitutionByBusiness
                            };


                            _this._viewManager(4, rowId);
                        } else {
                            var errorsCurrent = response.msj;

                        }

                    }
                });
            } else if (params.managerType == "viewResults") {
                dataSend = {
                    EducationalInstitutionByBusiness: rowCurrent,
                };
                ajaxRequest($('#action-askwer-form-getDataSolutionsAskwer').val(), {
                    type: 'POST',
                    data: dataSend,
                    blockElement: this.tabCurrentSelector,//
                    loading_message: 'Cargando...',
                    error_message: 'Error al cargar informacion.',
                    success_message: 'Informacion Cargada.',
                    success_callback: function (response) {

                        if (response.success) {
                            var dataResponse = response.data;
                            console.log(dataResponse);
                            _this.askwerManager.resultsAnswers = dataResponse;
                            _this.askwerManager.managerAskwer = rowCurrent;
                            _this._viewManager(5);
                        } else {
                            var errorsCurrent = response.msj;

                        }

                    }
                });
            }
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {
                business_id: this.business_id
            };
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
                        var result = [
                            " <div class = 'content-description' > ",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Tipo Formulario:</span><span class='content-description__value'>" + row.educational_institution_askwer_type + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Nombre Formulario:</span><span class='content-description__value'>" + row.askwer_form + "</span>",
                            "</div>",
                            "</div>",
                        ];

                        return result.join("");

                    }

                }
            }).on("loaded.rs.jquery.bootgrid", function () {
                vmCurrent._resetManagerGrid();
                vmCurrent._gridManager(gridInit);
            });
        },
        /*Manager FORMS-AND VIEWS*/
        _viewManager: function (typeView, rowId) {
            this.viewsManager = {
                form: false,
                admin: false,
                results: false,
                managerForm: false,
            };
            if (typeView == 1) {//create
                this.showManager = true;
                this.managerMenuConfig.view = false;
                $(this.gridConfig.selectorCurrent + "-header").hide();
                $(this.gridConfig.selectorCurrent + "-footer").hide();
                this.managerType = 1;
                this.viewsManager.form = true;
                initS2Types({
                    objSelector: ('#AskwerForm_educational_institution_askwer_type_id_data'),
                    data: []
                });
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
                this.viewsManager.admin = true;
            } else if (typeView == 3) {//FORM
                this.showManager = true;
                $(this.gridConfig.selectorCurrent + "-footer").hide();
                $(this.gridConfig.selectorCurrent + "-header").hide();
                this.managerMenuConfig.view = false;
                this.managerType = 3;
                this.viewsManager.form = true;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            } else if (typeView == 4) {//update

                $(this.gridConfig.selectorCurrent + "-footer").hide();
                $(this.gridConfig.selectorCurrent + "-header").hide();
                this.managerMenuConfig.view = false;
                this.managerType = 4;
                this.viewsManager.managerForm = true;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            } else if (typeView == 5) {//FORM results
                this.showManager = true;
                $(this.gridConfig.selectorCurrent + "-footer").hide();
                $(this.gridConfig.selectorCurrent + "-header").hide();
                this.managerMenuConfig.view = false;
                this.managerType = 5;
                this.viewsManager.results = true;

            }
        },
        _submitForm: function (e) {
            console.log(e);
        },
        getValuesByFieldType: function (fieldData) {
            var resultHtml = "";
            var log = [];
            var field_type = fieldData.field_type;
            if (field_type == "3") {
                var countAux = fieldData.data.length;
                var count = 0;
                var data = fieldData.data;
                $.each(data, function (key, value) {
                    if (fieldData.comment_allow == 1) {

                        if (count == countAux - 1) {
                            resultHtml += "<span class='span-title-select-label'>Opcion Seleccionada</span>:<span class='span-title-select-value'>" + value.label + "</span>,<span class='span-title-comment-label'>Cantidad</span>:<span class='span-title-comment-value'>" + value.option_comment + "</span>";
                        } else {
                            resultHtml += "<span class='span-title-select-label'>Opcion Seleccionada</span>:<span class='span-title-select-value'>" + value.label + "</span>,<span class='span-title-comment-label'>Cantidad</span>:<span class='span-title-comment-value'>" + value.option_comment + "</span>" + ",";

                        }
                        count++;

                    } else {
                        if (count == countAux - 1) {
                            resultHtml += value.label;
                        } else {
                            resultHtml += value.label + ",";

                        }
                        count++;
                    }
                });
            } else if (field_type == "2") {
                if (fieldData.comment_allow == 1) {
                    resultHtml = "<span class='span-title-select-label'>Seleccionado</span>:" + fieldData.label + ", <span class='span-title-comment-label'>Cantidad:</span>" + fieldData.option_comment;
                } else {
                    resultHtml = fieldData.label;

                }

            } else {
                resultHtml = fieldData.label;

            }

            return resultHtml;
        },
//ASKWER
        getStructureAskwerManager: function () {
            var result = {};
            var radioButtonsValidations = new Object();
            var checkButtonsValidations = new Object();
            var checkbox = new Object();
            var modelsSolutions = new Object();
            var sectionsValidations = new Object();

            var sectionsCurrent = this.askwerManager.sections;
            $.each(sectionsCurrent, function (key, section) {
                var fields = section['fields'];
                var sectionId = section['id'];
                modelsSolutions[sectionId] = new Object();
                sectionsValidations[sectionId] = new Object();

                radioButtonsValidations[sectionId] = new Object();
                checkButtonsValidations[sectionId] = new Object();
                checkbox[sectionId] = new Object();

                $.each(fields, function (keyField, field) {
                    var name = field.name_parent;
                    var field_type = field.field_type;
                    var validate = field.validate;

                    var field_id = field.id;
                    var nameCurrent;
                    var widget_type = field.widget_type;
                    nameCurrent = field_id + "_" + field_type;
                    if (widget_type == 1 || widget_type == 7) {

                    } else if (widget_type == 2 || widget_type == 3) {

                        if (widget_type == 2) {
                            radioButtonsValidations[sectionId][field_id] = new Object();
                        } else {
                            checkButtonsValidations[sectionId][field_id] = new Object();
                            checkbox[sectionId]['checkbox_' + field_id] = new Object();
                        }
                        var options = field.fieldOptions;
                        $.each(options, function (keyOption, option) {
                            var optionId = option.id;
                            if (widget_type == 2) {
                                radioButtonsValidations[sectionId][field_id][optionId] = new Object();
                                radioButtonsValidations[sectionId][field_id][optionId]['model'] = null;
                                radioButtonsValidations[sectionId][field_id][optionId]['keysInfo'] = null;
                                radioButtonsValidations[sectionId][field_id][optionId]['required'] = null;
                            } else if (widget_type == 3) {
                                checkButtonsValidations[sectionId][field_id][optionId] = new Object();
                                checkButtonsValidations[sectionId][field_id][optionId]['model'] = null;
                                checkButtonsValidations[sectionId][field_id][optionId]['keysInfo'] = null;
                                checkbox[sectionId]['checkbox_' + field_id][optionId] = null;
                            }


                        });
                    }
                    var valueSolution = null;
                    var invalid = true;
                    if (widget_type == 4) {
                        valueSolution = false;
                        invalid = false;
                    }
                    modelsSolutions[sectionId][nameCurrent] = valueSolution;
                    sectionsValidations[sectionId][nameCurrent] = new Object();
                    sectionsValidations[sectionId][nameCurrent]['required'] = validate;
                    sectionsValidations[sectionId][nameCurrent]['init'] = false;
                    sectionsValidations[sectionId][nameCurrent]['invalid'] = invalid;

                });

            });
            result = {
                checkbox: checkbox,
                checkButtonsValidations: checkButtonsValidations,
                radioButtonsValidations: radioButtonsValidations,
                modelsSolutions: modelsSolutions,
                sectionsValidations: sectionsValidations,


            };
            return result;
        },
        _changeValues: function (sectionId, field, value, type) {
            var currentValidation = field.id + "_" + field.field_type;
            if (type == 1) {
            } else if (type == 2) {

            }
            if (currentValidation != '') {
                var invalid = false;
                if ((typeof (value) == 'string' && value == '') || (typeof (value) == 'number' && value < 0) && !(typeof (value) == 'boolean') || value == null) {
                    invalid = true;
                }
                this.askwerManager.sectionsValidations[sectionId][currentValidation].init = true;
                this.askwerManager.sectionsValidations[sectionId][currentValidation].invalid = invalid;
            }
        },
        _selectedCheckbox: function (section_id, option, field) {
            var option_id = option.id;
            var field_row_id = field.id;
            var field_type = field.field_type;
            var comment_allow = field.comment_allow;
            let selectionsList = [];
            var _this = this;
            elementsCurrentCheck = $('.group-checklist-' + section_id + '-' + field_row_id);
            $.each(elementsCurrentCheck, function (key, value) {
                var current_option_id = $(value).attr('option_id');
                if ($(value).prop('checked')) {
                    _this.askwerManager.checkbox[section_id]['checkbox' + '_' + field_row_id][current_option_id] = true;
                } else {
                    _this.askwerManager.checkbox[section_id]['checkbox' + '_' + field_row_id][current_option_id] = false;

                }
            });
            $.each(_this.askwerManager.checkbox[section_id]['checkbox' + '_' + field_row_id], function (key, value) {
                if (value) {//true
                    selectionsList.push(key);
                    if (comment_allow == 1) {
                        _this.askwerManager.checkButtonsValidations[section_id][field_row_id][key].required = true;
                    }
                } else {
                    if (comment_allow == 1) {
                        _this.askwerManager.checkButtonsValidations[section_id][field_row_id][key].required = false;
                        _this.askwerManager.checkButtonsValidations[section_id][field_row_id][key].model = null;
                    }
                }
            });
            this.askwerManager.modelsSolutions[section_id][field_row_id + '_' + field_type] = selectionsList;
            var valueSetAux = 1;
            if (selectionsList.length == 0) {
                valueSetAux = null;
                this.askwerManager.modelsSolutions[section_id][field_row_id + '_' + field_type] = null;
            }
            if (comment_allow == 1) {
                this.askwerManager.checkButtonsValidations[section_id][field_row_id][option_id]["keysInfo"] = "section_id:" + section_id + "," + "field_type:" + field_type + "," + "field_row_id:" + field_row_id;

            }
            this._changeValues(section_id, field, valueSetAux, 2);
        },
        _selectedRadio: function (section_id, option, field) {
            var _this = this;
            var option_id = option.id;
            var field_row_id = field.id;
            var field_type = field.field_type;
            $.each(_this.askwerManager.radioButtonsValidations[section_id][field_row_id], function (key, value) {
                _this.askwerManager.radioButtonsValidations[section_id][field_row_id][key]["model"] = null;
                _this.askwerManager.radioButtonsValidations[section_id][field_row_id][key]["keysInfo"] = null;


            });
            $.each(_this.askwerManager.radioButtonsValidations[section_id][field_row_id], function (key, value) {
                _this.askwerManager.radioButtonsValidations[section_id][field_row_id][key]["required"] = false;
            });
            this.askwerManager.radioButtonsValidations[section_id][field_row_id][option_id].required = true;
            var valueKeysSet = "section_id:" + section_id + "," + "field_type:" + field_type + "," + "field_row_id:" + field_row_id;
            this.askwerManager.radioButtonsValidations[section_id][field_row_id][option_id]["keysInfo"] = valueKeysSet;

            this._changeValues(section_id, field, valueKeysSet, 2);

        },
        getNumberStars: function (number) {
            return parseInt(number);
        },
        hasErrorModel: function (sectionId, fieldId, widgetType) {
            var currentValidation = fieldId + '_' + widgetType;
            var elementManagerAttributes = this.askwerManager.sectionsValidations[sectionId][currentValidation];
            var result = null;
            if (elementManagerAttributes.init) {
                if (elementManagerAttributes.required) {
                    result = elementManagerAttributes.invalid;

                }
            }

            return result;

        },
        getClassErrorModel: function (sectionId, field) {
            var fieldId = field.id;
            var widgetType = field.widget_type;

            var resultError = this.hasErrorModel(sectionId, fieldId, widgetType);
            var result = null;
            result = {
                "form-group--error": resultError == null ? false : resultError,
                'form-group--success': resultError == null ? false : !resultError
            };

            return result;
        },
        validateFormAskwer: function () {
            var result = true;
            var dataValidations = this.askwerManager.sectionsValidations;
            $.each(dataValidations, function (keySection, valueSection) {
                $.each(valueSection, function (keyQuestion, valueQuestion) {

                    if (valueQuestion.invalid && valueQuestion.required) {
                        result = false;
                        return;
                    }
                });
            });
            return result;
        },
        _saveAskwerSolution: function () {
            var _this = this;
            let solutionsCurrent = this.askwerManager.modelsSolutions;
            var dataManagement = {
                radioButtonsValidations: this.askwerManager.radioButtonsValidations,
                checkButtonsValidations: this.askwerManager.checkButtonsValidations,
                haystack: solutionsCurrent
            };
            var allowSave = false;
            let solutionsCurrentSave = askwerUtil.getStructureFormSave(dataManagement);
            var dataSend = {
                EducationalInstitutionByBusiness: this.askwerManager.managerFilters.EducationalInstitutionByBusiness,
                AskwerForm: {
                    solutions: solutionsCurrentSave
                }
            };
            ajaxRequest($('#action-askwer-form-saveAskwer').val(), {
                type: 'POST',
                data: dataSend,
                blockElement: this.tabCurrentSelector,//
                loading_message: 'Cargando...',
                error_message: 'Error al guardar informacion.',
                success_message: 'Informacion guardada.',
                success_callback: function (response) {

                    if (response.success) {
                        _this._viewManager(2);
                    } else {
                        var errorsCurrent = response.msj;

                    }

                }
            });
        }


    }
});

var initS2TypesData = false;

function initS2Types(params) {

    var el = params.objSelector;
    var data = params.data;
    var dataCurrent = [];
    if (data.length > 0) {
        dataCurrent = data;
    }
    if (initS2TypesData) {
        $(el).select2('destroy');
        initS2TypesData = false;
    }
    var elementInit = $(el).select2({
        allow: true,
        placeholder: "Seleccione Aplicacion",
        data: dataCurrent,
        ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
            url: $("#action-educational-institution-askwer-type-getListSelect2").val(),
            type: "get",
            dataType: 'json',
            data: function (term, page) {
                var paramsFilters = {filters: {search_value: term, business_id: business_id}};
                return paramsFilters;
            },
            processResults: function (data, page) {
                return {results: data};
            }
        },
        allowClear: true,
        multiple: false,
        width: '100%'
    });
    elementInit.on('select2:select', function (e) {
        var data = e.params.data;
        /*_this.model.attributes.lodging_type_of_room_id_data = data;*/

        $modelAskwerInit.setValues({
            nameAttributes: 'educational_institution_askwer_type_id_data',
            valueAttributes: data,

        });
        $('#AskwerForm_educational_institution_askwer_type_id').val(data.id);
    }).on("select2:unselecting", function (e) {
        $modelAskwerInit.setValues({
            nameAttributes: 'educational_institution_askwer_type_id_data',
            valueAttributes: null,

        });
        $('#AskwerForm_educational_institution_askwer_type_id').val(null);

    });
    initS2TypesData = true;

}

function initManagerKO() {
    $.fn.editable.defaults.mode = 'inline';
    $modelAskwerInit = new AskwerViewModel({business_id: business_id});
    ko.applyBindings($modelAskwerInit);
    $('textarea').autosize();
    $('#askwer-form-form').validate();
    $('a#show-preloaded-fields').fancybox({'hideOnOverlayClick': false, 'showCloseButton': false});
    validacionCampoMaximoRating();
}

$(function () {
    initManagerKO();
});
