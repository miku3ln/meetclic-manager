// Overall viewmodel for this screen, along with initial state
var ko_data_user;
var fields_data_user;

function AskwerViewModel(params) {
    var self = this;
    ko_data_user = $("#AskwerForm_ko_data");
    fields_data_user = $("#created_fields");

//    ------------PARA RELIZAR L UPDATE VARIABLES---
    self.view_msj = ko.observable(0);
    self.myMessage = ko.observable("Errores");
    self.infoTitle = ko.observable("Advertencia!");
    self.data_new = ko.observable(data_new);//para saber si es nuevo o update
    self.sections = ko.observableArray([new Section({name: 'Nueva Seccion', weight: 0})]);
    self.deletedSections = ko.observableArray();
    self.createdFields = ko.observableArray();
    self.selectedSection = ko.observable();
//-------------VALORES DEL FORMULARIO-*--- this.code = ko.observable();
//    this.name.extend({required: true});
    self.id = ko.observable("");
    self.iha_id = ko.observable("");
    var business_id = params.business_id;
    self.business_id = ko.observable(business_id);
    self.name = ko.observable("");
    self.educational_institution_askwer_type_id_data = ko.observable(0).extend({
        required: true,
    });
    self.welcome_msg = ko.observable();
    self.leave_msg = ko.observable();
    self.description = ko.observable("").extend({
        required: true,

        /*minLength: 2,
        maxLength: 30,
        pattern: {
            message: 'Please only enter letters in your name',
            params: '^[a-zA-Z]+$'
        }*/
    });
    // Operations
    self.updateSectionPosition = function () {
        var i = 0;
        ko.utils.arrayForEach(self.sections(), function (section) {
            section.weight(i++);
        });
    }
    self.addSection = function () {
        self.sections.push(new Section({name: 'New Section'}));
        self.updateSectionPosition();
    }
    self.removeSection = function (section) {

        $.confirm({
            title: 'Confirm!',
            content: 'Do you really want to delete this section?',
            buttons: {
                confirm: function () {
                    self.sections.remove(section);
                    if (section.id) {//si tiene id es porq es una section nueva
                        self.deletedSections.push(section);
                    }
                    self.updateSectionPosition();
                },
                cancel: function () {

                },

            }
        });


    }
    self.setValues = function (params) {
        var namePosition = params['nameAttributes'];
        var value = params['valueAttributes'];
        self[namePosition] = value;
    }
    self.getValues = function (params) {
        var namePosition = params['nameAttributes'];
        return self[namePosition];
    }
    self.selectSection = function (section) {
        self.selectedSection(section);
        $('#show-preloaded-fields').trigger('click');
    }
    self.addPreloadedField = function (field) {
        $.fancybox.close();
        self.selectedSection().fields.push(field);
        self.selectedSection().updateFieldPosition();
        ocultarRating();
    }

    // Load initial state from server, convert it to Sections instances, then populate self.sections
    if (ko_data_user.val()) {
        var ko_data = $.parseJSON(ko_data_user.val());
        self.sections($.map(ko_data['sections'], function (item) {
            var section = new Section(item);
            section.fields($.map(item.fields, function (item) {
                var field = new Field(item);
                field.fieldOptions($.map(item.fieldOptions, function (item) {
                    return new Option(item);
                }));
                return field;
            }));
            return section;
        }));
    }

    // Load available fields to load
    if (fields_data_user.val()) {
        var created_fields = $.parseJSON(fields_data_user.val());
        self.createdFields($.map(created_fields, function (item) {
            var field = new Field(item);
            field.fieldOptions($.map(item.fieldOptions, function (item) {
                return new Option(item);
            }));
            return field;
        }));
    }
    self.getExistRequired = function (haystack) {
        var result = false;
        $.each(haystack, function (key, value) {

            if (value == "required") {
                result = true

            }
        });
        return result;
    }
    /*  https://codepen.io/NickMcBurney/pen/ZWdgMR
    * https://codepen.io/dmoojunk/pen/zxqYbb
    * */
    self.doSubmit = function () {
        var thisCurrent = this;
        var form_ok = $(form_element).valid();
        var fieldsErrors = true;//true esta todo ok
        var fieldsEmpty = true;
        var fieldsOptionsEmpty = true;
        var sectionsEmpty = true;
        var dataSections = self.sections();
        var existQuestionsRequired = true;
        var existQuestionsRequiredCount = 0;
        var allowOptionsScore = true;
        var allowOptionsScoreCount = 0;

        if (dataSections.length > 0) {//verificar q por lo menos agrege una seccion
            ko.utils.arrayForEach(dataSections, function (section) {
                var fieldsObject = section.fields();
                if (fieldsObject.length > 0) {
                    ko.utils.arrayForEach(fieldsObject, function (field) {
                        var value_label = field.label();
                        var validationsCurrent = field.validations()
                        var requiredExist = thisCurrent.getExistRequired(validationsCurrent);
                        if (requiredExist) {
                            existQuestionsRequiredCount++;
                        }
                        var allowOptions = field.allowOptions;
                        if (allowOptions) {
                            if (!value_label) {
                                fieldsErrors = false;
                            }
                            var optionsData = field.fieldOptions();
                            if (optionsData.length == 0) {//por lomenos una opcion agregar
                                fieldsOptionsEmpty = false;
                            } else {
                                ko.utils.arrayForEach(optionsData, function (option) {
                                    if (parseFloat(option.option_score()) < 0) {
                                        allowOptionsScoreCount++;
                                    }
                                });
                            }
                        }

                    });
                } else {
                    fieldsEmpty = false;//no agrega ningun fields
                }
            });
        } else {
            sectionsEmpty = false;
        }
        existQuestionsRequired = false;
        if (fieldsEmpty) {

            existQuestionsRequired = existQuestionsRequiredCount == 0 ? false : true;
        }
        allowOptionsScore = false;
        if (fieldsOptionsEmpty) {

            allowOptionsScore = allowOptionsScoreCount == 0 ? true : false;
        }

//----------GUARDADO D INFORMACION VALIDACIONES-----------
        if (form_ok && fieldsErrors && fieldsEmpty && sectionsEmpty && fieldsOptionsEmpty && existQuestionsRequired && allowOptionsScore) {//solo guardar x via ajax si esta bien la informacion
            var data_gestion = $(form_element).serialize();
            self.view_msj(0);
//            -----GUARDADO D INFORMACION----
            var data_gestion = data_gestion;
            var url_gestion = url_gestion;
            var dataSend = data_gestion;
            ajaxRequest(componentThisEducationalInstitutionByBusiness.formConfig.url, {
                type: 'POST',
                data: dataSend,
                blockElement: componentThisEducationalInstitutionByBusiness.tabCurrentSelector,//opcional: es para bloquear el elemento
                loading_message: componentThisEducationalInstitutionByBusiness.formConfig.loadingMessage,
                error_message: componentThisEducationalInstitutionByBusiness.formConfig.errorMessage,
                success_message: componentThisEducationalInstitutionByBusiness.formConfig.successMessage,
                success_callback: function (response) {

                    if (response.success) {
                        $(componentThisEducationalInstitutionByBusiness.gridConfig.selectorCurrent).bootgrid("reload");
                        componentThisEducationalInstitutionByBusiness._viewManager(2);
                        componentThisEducationalInstitutionByBusiness._resetManagerGrid();
                        self.view_msj(0);
                    } else {
                        var errorsCurrent = response.msj;

                        self.view_msj(1);
                        self.infoTitle("Advertencia!");
                        self.myMessage(errorsCurrent);
                    }

                }
            });


        } else {//mostrar los errores
            self.view_msj(0);//reseteo d mensaje mostrar
            if (!fieldsErrors) {

            } else if (!fieldsEmpty) {
                self.view_msj(1);
                self.myMessage("Agrege por lo menos una pregunta en las Secciones creadas.");
                self.infoTitle("Advertencia!");
            } else if (!sectionsEmpty) {
                self.view_msj(1);
                self.myMessage("Agrege por lo menos una Seccion en la creación del Formulario.");
                self.infoTitle("Advertencia!");
            } else if (!fieldsOptionsEmpty) {
                self.view_msj(1);
                self.myMessage("Agrege por lo menos una Opcion.");
                self.infoTitle("Advertencia!");
            } else if (!existQuestionsRequired) {
                self.view_msj(1);
                self.myMessage("Agrege por lo menos una pregunta requerida.");
                self.infoTitle("Advertencia!");
            } else if (!allowOptionsScore) {
                self.view_msj(1);
                self.myMessage("Uno de los Puntajes es negativo");
                self.infoTitle("Advertencia!");
            }

        }

    };

//    ---RESETEA TODA LA INFORMACION DEL FORMULARIO---
    self.resetAll = function () {
        self.view_msj(0);
        self.sections([new Section({name: 'New Section', weight: 0})]);
        self.deletedSections([]);
        self.createdFields([]);
        self.selectedSection("");
        data_new = false;
        self.data_new(data_new);//para saber si es nuevo o update
        self.name("");
        self.educational_institution_askwer_type_id_data(0);
        create_update = true;//true es para crear
        data_askwer_form = {};
        self.iha_id("");
        self.id("");
        self.welcome_msg("");
        self.leave_msg("");
        self.description("");
        $("#AskwerForm_form_structure").val("");
        $('#AskwerForm_educational_institution_askwer_type_id').val(null);

    };
//--------REMUEVE LA SECTION COMPLETA-----
//-------------METODOS PARA UPDATE--------
    self.setDataManager = function (data) {

        var sections = data.AskwerForm.sections;
        var dataFormAskwer = data.AskwerForm;
        var dataEducationalInstitutionByBusiness = data.EducationalInstitutionByBusiness;
        self.sections($.map(sections, function (item) {
            var section = new Section(item);
            section.fields($.map(item.fields, function (item) {
                console.log(item);
                var field = new Field(item);
                field.fieldOptions($.map(item.fieldOptions, function (item) {
                    return new Option(item);
                }));
                return field;
            }));
            return section;
        }));
        self.name(dataFormAskwer.name);
        self.welcome_msg(dataFormAskwer.welcome_msg);
        self.leave_msg(dataFormAskwer.leave_msg);
        self.description(dataFormAskwer.description);
//        ---Institucion Askwer --
        var dataType = {
            id: dataFormAskwer.educational_institution_askwer_type_id,
            text: dataFormAskwer.educational_institution_askwer_type
        };
        initS2Types({
            objSelector: ('#AskwerForm_educational_institution_askwer_type_id_data'),
            data: [dataType]
        });
        self.educational_institution_askwer_type_id_data(dataFormAskwer.educational_institution_askwer_type_id);
        self.iha_id(dataEducationalInstitutionByBusiness.id);
        self.id(dataFormAskwer.id);
        $('#AskwerForm_educational_institution_askwer_type_id').val(dataFormAskwer.educational_institution_askwer_type_id);
    };
    self.getDataAll = function () {
        var dataSections = self.sections();
        ko.utils.arrayForEach(dataSections, function (section) {
            var fieldsObject = section.fields();
            if (fieldsObject.length) {
                ko.utils.arrayForEach(fieldsObject, function (field) {
                    var value_label = field.label();
//                    var field_type = field.field_type();
                    console.log(field);
                    if (!value_label) {
                        fieldsErrors = false;
                    }
//                    if (!field_type) {
//
//                    }

                });
            } else {
                fieldsEmpty = false;//no agrega ningun fields
            }
        });
    };

}
