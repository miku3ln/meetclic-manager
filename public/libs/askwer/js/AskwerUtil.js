function AskwerUtil($scope) {
    AskwerFormManager($scope);
    $scope.saveAnswersUpdate = function () {
        var url_gestion = "askwer/askwerForm/saveAnswersInspectionUpdate";
        var solutionsCurrent = $scope.solutionsManagement;
        var dataManagement = {
            radioButtonsValidations: $scope.radioButtonsValidationsManagement,
            checkButtonsValidations: $scope.checkButtonsValidationsManagement
        };
        var allowSave = false;
        angular.forEach($scope.solutionsManagement, function (valueSection, keySection) {

            if (Object.keys(valueSection).length) {
                allowSave = true;
            }
        });
        if (allowSave) {
            solutionsCurrent = $scope.getStructureFormSave(dataManagement, $scope.solutionsManagement);
            var dataAnswers = $scope.resultsAsnwers[0].answers;
            var dataSolutions = solutionsCurrent;
            dataSolutions = $scope.getFomatUpdateSave(dataAnswers, dataSolutions);
            dataSolutions = JSON.parse(dataSolutions);
            solutionsCurrent = dataSolutions;
            var data_gestion = {
                data_save_params: $scope.modelInstitucionHasAskwer,
                soluciones: solutionsCurrent,
                type: "vehicle",
                id: $scope.manager_id,
                state: $("#aprobado-update").prop("checked") ? 'APROBADO' : "NO APROBADO",
                state_cierre: $("#cierre-update").prop("checked") ? 'LOCAL CERRADO' : "",
                business_size_id: $scope.business_size_idCreate
            };
            var params_gestion = {
                async: true,
                url: url_gestion, //accion dond vamos a realizar la gestion
                data: data_gestion, //paramatros para realizar l proceso
                beforeCall: function () {//funcion antes d ejecutarse el procesos
                    //ocultar ,bloquear botones,etc
                    //          ----ocultar l contenedor main---
                    var gestion_view = {object_gestion: $("#managent_entity"), view_object: false};
                    viewInformacion(gestion_view);
//            ---MOSTRAR EL LOADING---
                    var gestion_view = {object_gestion: $("#loading-content"), view_object: true};
                    viewInformacion(gestion_view);
                },
                successCall: function (data) {
                    //            ---ocultar EL LOADING---
                    var gestion_view = {object_gestion: $("#loading-content"), view_object: false};
                    viewInformacion(gestion_view);
                    if (data.success) {
                        var $params = {
                            title: "Registro. ",
                            color: getColorsCustom("success"),
                            icon: "fa fa-info",
                            content: "Realizado Correctamente."
                        };
                        msjSystem($params);

                    } else {
                        var $params = {
                            title: "Registro. ",
                            color: getColorsCustom("danger"),
                            icon: "fa fa-info",
                            content: data.msj
                        };
                        msjSystem($params);
                    }
                    $($scope.bootgrid_main).bootgrid("reload");
                    $scope.viewData(6);
                    $scope.$apply();

                },
                errorCall: function (data) {
                    var statusText = data.statusText;
                    var status = data.status;
                    //            ---ocultar EL LOADING---
                    var gestion_view = {object_gestion: $("#loading-content"), view_object: false};
                    viewInformacion(gestion_view);
                    //          ----ocultar l contenedor main---
                    var gestion_view = {object_gestion: $("#managent_entity"), view_object: true};
                    viewInformacion(gestion_view);
                    var $params = {
                        title: "Registro. ",
                        color: getColorsCustom("danger"),
                        icon: "fa fa-info",
                        content: statusText
                    };
                    msjSystem($params);
                    $scope.viewData(6);
                },
            };
            gestionInformacion(params_gestion);
        } else {
            var $params = {
                title: "Información. ",
                color: getColorsCustom("warning"),
                icon: "fa fa-info",
                content: "Conteste una pregunta por lo menos."
            };
            msjSystem($params);
        }
    };

    AskwerCustomUtil($scope);
    /*  ------ASKWER-----*/
    $scope.saveAnswers = function () {
        var url_gestion = "askwer/askwerForm/saveAnswersInspection";
        var solutionsCurrent = $scope.solutions;
        var dataManagement = {
            radioButtonsValidations: $scope.radioButtonsValidations,
            checkButtonsValidations: $scope.checkButtonsValidations
        };
        var allowSave = false;
        angular.forEach($scope.solutions, function (valueSection, keySection) {

            if (Object.keys(valueSection).length) {
                allowSave = true;
            }
        });
        if (allowSave) {
            solutionsCurrent = $scope.getStructureFormSave(dataManagement, $scope.solutions);
            var data_gestion = {
                data_save_params: $scope.modelInstitucionHasAskwer,
                soluciones: solutionsCurrent,
                type: "vehicle",
                id: $scope.manager_id,
                state: $("#aprobado-create").prop("checked") ? 'APROBADO' : "NO APROBADO",
                state_cierre: $("#cierre-create").prop("checked") ? 'LOCAL CERRADO' : "",
                business_size_id: $scope.business_size_idCreate
            };
            var params_gestion = {
                async: true,
                url: url_gestion, //accion dond vamos a realizar la gestion
                data: data_gestion, //paramatros para realizar l proceso
                beforeCall: function () {//funcion antes d ejecutarse el procesos
                    //ocultar ,bloquear botones,etc
                    //          ----ocultar l contenedor main---
                    var gestion_view = {object_gestion: $("#registro_update_entidad"), view_object: false};
                    viewInformacion(gestion_view);
//            ---MOSTRAR EL LOADING---
                    var gestion_view = {object_gestion: $("#loading-content"), view_object: true};
                    viewInformacion(gestion_view);
                    /*                resetData();*/

//
                },
                successCall: function (data) {
                    //            ---ocultar EL LOADING---
                    var gestion_view = {object_gestion: $("#loading-content"), view_object: false};
                    viewInformacion(gestion_view);
                    if (data.success) {
                        var $params = {
                            title: "Registro. ",
                            color: getColorsCustom("success"),
                            icon: "fa fa-info",
                            content: "Realizado Correctamente."
                        };
                        msjSystem($params);

                    } else {
                        var $params = {
                            title: "Registro. ",
                            color: getColorsCustom("danger"),
                            icon: "fa fa-info",
                            content: data.msj
                        };
                        msjSystem($params);
                    }
                    $($scope.bootgrid_main).bootgrid("reload");
                    $scope.viewData(4);
                    $scope.$apply();
                    $("#state").val(state);
                },
                errorCall: function (data) {
                    var statusText = data.statusText;
                    var status = data.status;
                    //            ---ocultar EL LOADING---
                    var gestion_view = {object_gestion: $("#loading-content"), view_object: false};
                    viewInformacion(gestion_view);
                    //          ----ocultar l contenedor main---
                    var gestion_view = {object_gestion: $("#registro_update_entidad"), view_object: true};
                    viewInformacion(gestion_view);
                    var $params = {
                        title: "Registro. ",
                        color: getColorsCustom("danger"),
                        icon: "fa fa-info",
                        content: statusText
                    };
                    msjSystem($params);
                    $scope.viewData(4);
                },
            };
            gestionInformacion(params_gestion);
        } else {
            var $params = {
                title: "Información. ",
                color: getColorsCustom("warning"),
                icon: "fa fa-info",
                content: "Conteste una pregunta por lo menos."
            };
            msjSystem($params);
        }
    };
    $scope.enabled = true;
    $scope.onOff = true;
    $scope.yesNo = true;
    $scope.disabled = true;
//    ---------CREACION DE FORMULARIO VER---

    $scope.checkbox = {};
    $scope.radioButtonsValidations = [];
    $scope.nameForm = "managerFormCurrent";
    $scope.solutions = {};
    $scope.ratings = 1;
    $scope.sections = {};
    $scope.isReadonly = true;
    $scope.formats = ['dd/MM/yyyy', 'yyyy/MM/dd', 'dd-MMMM-yyyy', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[0];
    $scope.altInputFormats = ['M!/d!/yyyy'];
//https://www.adictosaltrabajo.com/tutoriales/formularios-en-angularjs-componentes-y-validacion/
    $scope.items = [{
        inlineChecked: false,
        question: "",
        questionPlaceholder: "",
        text: "",
        required: "required"
    }];
    eventsFormElements($scope);
    /*----------MANAGEMENT--------------*/
    /* UPDATE*/
    $scope.checkboxManagement = {};
    $scope.radioButtonsValidationsManagement = [];
    $scope.name_formManagement = "askwerFormManagement";
    $scope.solutionsManagements = {};
    $scope.sectionsManagement = {};
    $scope.resultsAsnwers = {};

    $scope.getRequiredElement = function (value) {

        if (value) {
            return "required";
        }

        return "";
    }
}

function getDayClass(data) {
    var date = data.date,
        mode = data.mode;
    if (mode === 'day') {
        var dayToCheck = new Date(date).setHours(0, 0, 0, 0);

        for (var i = 0; i < $scope.events.length; i++) {
            var currentDay = new Date($scope.events[i].date).setHours(0, 0, 0, 0);

            if (dayToCheck === currentDay) {
                return $scope.events[i].status;
            }
        }
    }
    return '';
}

function eventsFormElements($scope) {
    //    ---Seleccionar Fecha*----
    $scope.setDate = function (year, month, day) {
        $scope.dt = new Date(year, month, day);
    };
    $scope.check = function (section_id, field_row_id, option_id, field_type, comment_allow) {
        var selecionados = [];
        angular.forEach($scope.checkbox[section_id]['checkbox' + '_' + field_row_id], function (selected, id) {
            if (selected) {//true
                selecionados.push(id);
                if (comment_allow == 1) {
                    $scope.checkButtonsValidations[section_id][field_row_id][id].required = true;
                }
            } else {
                if (comment_allow == 1) {
                    $scope.checkButtonsValidations[section_id][field_row_id][id].required = false;
                    $scope.checkButtonsValidations[section_id][field_row_id][id].model = null;
                }
            }
        });
        $scope.solutions[section_id][field_row_id + '_' + field_type] = selecionados;
        if (selecionados.length == 0) {
            $scope.solutions[section_id][field_row_id + '_' + field_type] = null;
        }
        if (comment_allow == 1) {
            $scope.checkButtonsValidations[section_id][field_row_id][option_id]["keysInfo"] = "section_id:" + section_id + "," + "field_type:" + field_type + "," + "field_row_id:" + field_row_id;

        }

    }
    $scope.selectRadio = function (section_id, field_row_id, option_id, field_type, fieldOptions) {

        angular.forEach($scope.radioButtonsValidations[section_id][field_row_id], function (value, key) {
            $scope.radioButtonsValidations[section_id][field_row_id][key]["model"] = null;
            $scope.radioButtonsValidations[section_id][field_row_id][key]["keysInfo"] = null;


        });
        angular.forEach($scope.radioButtonsValidations[section_id][field_row_id], function (value, key) {
            $scope.radioButtonsValidations[section_id][field_row_id][key]["required"] = false;
        });
        $scope.radioButtonsValidations[section_id][field_row_id][option_id].required = true;
        $scope.radioButtonsValidations[section_id][field_row_id][option_id]["keysInfo"] = "section_id:" + section_id + "," + "field_type:" + field_type + "," + "field_row_id:" + field_row_id;

    }

    $scope.rateFunction = function (rating, section_id, field_id, field_type) {

    };
    $scope.setRating = function () {
//        setRating
        return 0;
    };
    $scope.setRatingMax = function (data) {
        var max = parseInt(data[0].label);
        return max;
    };
    $scope.onChange = function (newValue, oldValue) {
        alert(newValue, oldValue);
    };


    $scope.onClick = function () {
        alert("ada", $objeto_total_scope.perrin);
    }
    /*-----------MANAGEMENT--------------*/
    $scope.checkManagement = function (section_id, field_row_id, option_id, field_type, comment_allow) {
        var selecionados = [];
        angular.forEach($scope.checkboxManagement[section_id]['checkbox' + '_' + field_row_id], function (selected, id) {
            if (selected) {//true
                selecionados.push(id);
                if (comment_allow == 1) {
                    $scope.checkButtonsValidationsManagement[section_id][field_row_id][id].required = true;
                }
            } else {
                if (comment_allow == 1) {
                    $scope.checkButtonsValidationsManagement[section_id][field_row_id][id].required = false;
                    $scope.checkButtonsValidationsManagement[section_id][field_row_id][id].model = null;
                }
            }
        });
        $scope.solutionsManagement[section_id][field_row_id + '_' + field_type] = selecionados;
        if (selecionados.length == 0) {
            $scope.solutionsManagement[section_id][field_row_id + '_' + field_type] = null;
        }
        if (comment_allow == 1) {
            $scope.checkButtonsValidationsManagement[section_id][field_row_id][option_id]["keysInfo"] = "section_id:" + section_id + "," + "field_type:" + field_type + "," + "field_row_id:" + field_row_id;

        }

    }
    $scope.selectRadioManagement = function (section_id, field_row_id, option_id, field_type, fieldOptions) {

        angular.forEach($scope.radioButtonsValidationsManagement[section_id][field_row_id], function (value, key) {
            $scope.radioButtonsValidationsManagement[section_id][field_row_id][key]["model"] = null;
            $scope.radioButtonsValidationsManagement[section_id][field_row_id][key]["keysInfo"] = null;


        });
        angular.forEach($scope.radioButtonsValidationsManagement[section_id][field_row_id], function (value, key) {
            $scope.radioButtonsValidationsManagement[section_id][field_row_id][key]["required"] = false;
        });
        $scope.radioButtonsValidationsManagement[section_id][field_row_id][option_id].required = true;
        $scope.radioButtonsValidationsManagement[section_id][field_row_id][option_id]["keysInfo"] = "section_id:" + section_id + "," + "field_type:" + field_type + "," + "field_row_id:" + field_row_id;

    }
}

function AskwerCustomUtil($scope) {

    $scope.resetViewAskwer = function () {
        $scope.resetForm($scope.askwerForm);
        $scope.radioButtonsValidations = {};
        $scope.solutions = {};
        $scope.checkbox = {};
        $scope.sections = {};
        $scope.checkButtonsValidations = {};
        $scope.radioButtonsValidations = {};
    }

    $scope.resetViewAskwerManagement = function () {
        $scope.resetForm($scope.askwerFormManagement);
        $scope.radioButtonsValidationsManagement = {};
        $scope.solutionsManagement = {};
        $scope.checkboxManagement = {};
        $scope.sectionsManagement = {};
        $scope.resultsAsnwers = {};
        $scope.checkButtonsValidationsManagement = {};
        $scope.radioButtonsValidationsManagement = {};
        $scope.tipo_detalle = 0;
        $scope.radioModel = "results";
        $scope.viewResults = true;

    }


    $scope.generateDate = function () {
        $('.field-date').datetimepicker();
    }
    //    ----BUSCA un valor dentro de un objeto tipo array...
    $scope.getStringRequired = function (data) {
        var result = "";
        if (data == true) {
            result = "required";
        }
        return result;
    }

    $scope.getDataAskwerForm = function (sections) {
        var fieldType = 2;
        var resultSectionsAllow = $scope.getSectionsAskwer(sections, fieldType);
        var radioButtonsValidations = [];
        if (resultSectionsAllow.success) {
            var stringSections = $scope.getObjSectionAskwer(resultSectionsAllow.data);

            radioButtonsValidations = JSON.parse(stringSections);
        }

        fieldType = 3;
        var resultSectionsAllow = $scope.getSectionsAskwer(sections, fieldType);
        var checkButtonsValidations = [];
        if (resultSectionsAllow.success) {
            var stringSections = $scope.getObjSectionAskwer(resultSectionsAllow.data);

            checkButtonsValidations = JSON.parse(stringSections);
        }

        var sectionsResult = {};
        var info = "";
        var count = sections.length - 1;
        var countAux = 0;

        angular.forEach(sections, function (value) {
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

    }

    $scope.questionsAnswer = [];
    /*----------ASNWER----------*/
    $scope.initManagementAnswer = function (data) {
        $scope.resultsAsnwers = data.result;

        var dataConvert = $scope.resultsAsnwers[0];
        var sectionsData = dataConvert["answers"];
        var resultAnswer = dataConvert["resultAnswer"];
        var sections = [];
        angular.forEach(sectionsData, function (sectionCurrent, key) {
            var askwer_form_id = 1;
            var fields = [];
            var id = sectionCurrent.section_id;
            var name = sectionCurrent.section_name;
            var fieldsCurrent = sectionCurrent.fields;
            angular.forEach(fieldsCurrent, function (field, keyField) {

                var allowOptions = field.allowOptions;
                var availableValidations = field.availableValidations
                var availableWidgets = field.availableWidgets;
                var comment_allow = field.comment_allow;

                var answer = field.answer;
                var dataOptions = field.dataOptions;
                var field_id = field.field_id;
                var field_type = field.field_type;
                var field_type_name = field.field_type_name;
                var name = field.name;
                var widget_type = field.widget_type;
                var validate = field.validate;
                var validations = field.validations;
                var name_parent = field.name_parent;
                var widget_type_name = field.widget_type_name;

                var fieldCurrent = {
                    allowOptions: allowOptions,
                    anskwer_section_id: id,
                    availableValidations: availableValidations,
                    availableWidgets: availableWidgets,
                    comment_allow: comment_allow,
                    fieldOptions: dataOptions,
                    field_type: field_type,
                    id: field_id,
                    label: name,
                    type: widget_type_name,
                    validate: validate,
                    validations: validations,
                    widget_type: widget_type,
                    name_parent: name_parent,
                    answer: answer
                };
                fields.push(fieldCurrent);
            });


            var section = {askwer_form_id: askwer_form_id, fields: fields, id: id, name: name, weight: "0"};
            sections.push(section);
        });
        /*$scope.sectionsManagement = sections;*/


        var result = $scope.getDataAskwerForm(sections);
        $scope.solutionsManagement = {};
        $scope.solutionsManagement = result.solutions;
        $scope.sectionsManagement = {};
        $scope.sectionsManagement = result.sections;
        $scope.radioButtonsValidationsManagement = {};
        $scope.radioButtonsValidationsManagement = result.radioButtonsValidations;
        $scope.checkButtonsValidationsManagement = {};
        $scope.checkButtonsValidationsManagement = result.checkButtonsValidations;

        var resultData = $scope.getFormatSolutionsAnswer(sectionsData);
        $scope.solutionsManagement = JSON.parse(resultData.solutions);
        var dataOptionsSections = resultData.dataOptionsSections;
        $scope.dataOptionsSections = dataOptionsSections;
        var fieldType = "3";
        var checkboxSections = $scope.getSectionsByFieldTypeAnswer(dataOptionsSections, fieldType);
        if (checkboxSections.success) {
            var checkboxSectionsSolutions = $scope.getValuesSectionsAnswer(checkboxSections.data, fieldType);
            $scope.checkboxManagement = JSON.parse(checkboxSectionsSolutions.data);
        }
        fieldType = "2";
        var radioButtonsSections = $scope.getSectionsByFieldTypeAnswer(dataOptionsSections, fieldType);
        if (radioButtonsSections.success) {
            var radioButtonsSectionsSolutions = $scope.getValuesSectionsAnswer(radioButtonsSections.data, fieldType);
            /*  $scope.radioButtonsSections = JSON.parse(checkboxSectionsSolutions.data);*/
        }

    }

    /*------------ANSWER-----------*/
    /*----------SAVE DATA STRUCTURE-------*/


    $scope.getFomatUpdateSave = function (dataAnswers, dataSolutions) {


        var count = Object.keys(dataSolutions).length - 1;
        var countAux = 0;
        var resultSections = "";
        angular.forEach(dataSolutions, function (valueSection, keySection) {
            var sectionId = keySection;

            var countFields = Object.keys(valueSection).length - 1;
            var countAuxFields = 0;
            var resultFields = "";

            angular.forEach(valueSection, function (field, keyfield) {
                var keysManager = keyfield.split("_");
                var fielId = keysManager[0];
                var fielType = keysManager[1];

                var resultSearch = $scope.answerManagement(dataAnswers, sectionId, fielId);
                var valueSet = JSON.stringify(field);
                var askwer_field_value_id = resultSearch.askwer_field_value_id;
                var keyName = fielId + "_" + fielType + "_" + askwer_field_value_id;
                if (countAuxFields < countFields) {
                    resultFields += '"' + keyName + '"' + ":" + valueSet + ",";
                } else {
                    resultFields += '"' + keyName + '"' + ":" + valueSet;

                }
                countAuxFields++;
            });

            if (countAux < count) {
                resultSections += '"' + sectionId + '"' + ":" + "{" + resultFields + "}" + ",";
            } else {
                resultSections += '"' + sectionId + '"' + ":" + "{" + resultFields + "}";

            }
            countAux++;

        });
        return resultSections = "{" + resultSections + "}";
    }

    $scope.answerManagement = function (answers, sectionId, fielId) {

        var result = {
            success: false,
            askwer_field_value_id: null
        };
        angular.forEach(answers, function (valueSection, keySection) {
            var section_id = valueSection.section_id;
            var fields = valueSection.fields;
            angular.forEach(fields, function (field, keyfield) {
                var answer = field.answer;
                var manager_id = field.manager_id;
                var field_id = field.field_id;
                if (sectionId == section_id && fielId == field_id && answer) {
                    result = {askwer_field_value_id: manager_id, success: true};

                }


            });
        });
        return result;

    }


    $scope.getSolutionFieldsAnswer = function (fieldsCurrent) {

        var lucky = fieldsCurrent.filter(function (value) {
            return value.answer == true;
        });
        var count = lucky.length - 1
        var countAux = 0;
        var result = "";
        var dataOptionsResultCurrent = [];
        angular.forEach(lucky, function (field, keyField) {

            var allowOptions = field.allowOptions;
            var availableValidations = field.availableValidations
            var availableWidgets = field.availableWidgets;
            var comment_allow = field.comment_allow;

            var answer = field.answer;
            var dataOptions = field.dataOptions;

            var field_id = field.field_id;
            var field_type = field.field_type;
            var field_type_name = field.field_type_name;
            var name = field.name;
            var widget_type = field.widget_type;
            var validate = field.validate;
            var validations = field.validations;
            var name_parent = field.name_parent;
            var widget_type_name = field.widget_type_name;
            var resultSetCustomer = "";
            switch (field_type) {
                case "3"://checkbox
                    var dataOptionsResult = field.data;
                    var optionsResult = [];
                    angular.forEach(dataOptionsResult, function (option, keyOption) {
                        optionsResult.push(option.id);
                    });
                    var optionsResultString = JSON.stringify(optionsResult);
                    resultSetCustomer = optionsResultString;
                    dataOptionsResultCurrent.push({
                        field_id: field_id,
                        field_type: field_type,
                        data: dataOptionsResult
                    });
                    break;
                case "1"://text
                    resultSetCustomer = '"' + field.label + '"';
                    break;
                case "2"://radio button

                    var dataOptionsResult = field.data;
                    var optionsResult = [];
                    optionsResult.push(dataOptionsResult.id);
                    var optionsResultString = JSON.stringify(optionsResult);
                    resultSetCustomer = optionsResultString;
                    dataOptionsResultCurrent.push({
                        field_id: field_id,
                        field_type: field_type,
                        data: [dataOptionsResult]
                    });

                    break;
                case "4"://toogle yes
                    var valueSet = field.label == "SI" ? true : false;
                    resultSetCustomer = valueSet;
                    break;
                case "5"://fecha
                    resultSetCustomer = '"' + field.label + '"';
                    break;
                case "6"://estrella
                    resultSetCustomer = field.label;
                    break;

                case "7"://textarea
                    resultSetCustomer = '"' + field.label + '"';
                    break;
            }


            if (countAux < count) {
                result += '"' + field_id + "_" + field_type + '"' + ":" + resultSetCustomer + ",";
            } else {
                result += '"' + field_id + "_" + field_type + '"' + ":" + resultSetCustomer;
            }
            countAux++;
        });
        return {
            success: lucky.length > 0 ? true : false,
            data: result,
            dataOptions: dataOptionsResultCurrent
        };

    }

    $scope.getFormatSolutionsAnswer = function (sectionsDataCustom) {
        var countFields = 0;
        var objString = '{';
        var objSection = '';
        var count = sectionsDataCustom.length - 1;
        var countAux = 0;
        var result = "";
        var dataOptionsAll = [];
        angular.forEach(sectionsDataCustom, function (sectionCurrent, key) {
            var askwer_form_id = 1;
            var fields = [];
            var id = sectionCurrent.section_id;
            var name = sectionCurrent.section_name;
            var fieldsCurrent = sectionCurrent.fields;
            var resultFields = $scope.getSolutionFieldsAnswer(fieldsCurrent);
            var dataOptionsFieldsOptions = resultFields.dataOptions;
            var resultSetCustomer = resultFields.success ? resultFields.data : "";
            if (dataOptionsFieldsOptions.length) {
                dataOptionsAll.push({section_id: id, data: dataOptionsFieldsOptions});
            }
            if (countAux < count) {
                result += '"' + id + '"' + ":" + "{" + resultSetCustomer + "}" + ",";
            } else {
                result += '"' + id + '"' + ":" + "{" + resultSetCustomer + "}";
            }
            countAux++;
        });

        return {solutions: "{" + result + "}", dataOptionsSections: dataOptionsAll};
    }


    $scope.getSectionsByFieldTypeAnswer = function (data, fieldType) {
        var sections = [];
        angular.forEach(data, function (section, key) {
            var fields = section.data;
            var section_id = section.section_id;
            var lucky = fields.filter(function (value) {
                return value.field_type == fieldType;
            });
            if (lucky.length) {
                sections.push({section_id: section_id, data: lucky});
            }

        });
        return {success: sections.length > 0, data: sections};
    }
    $scope.getValuesSectionsAnswer = function (sections, fieldType) {
        var info = "";
        var count = sections.length - 1;
        var countAux = 0;
        angular.forEach(sections, function (section, key) {
            var section_id = section.section_id;
            var fields = section.data;
            var resultFields = $scope.getValuesFieldsAnswer(fields, fieldType, section_id);
            if (resultFields.success) {
                var data = resultFields.data;
                if (countAux < count) {
                    var valuesSet = "";
                    info += '"' + section_id + '"' + ":" + "{" + data + "}" + ",";
                } else {
                    info += '"' + section_id + '"' + ":" + "{" + data + "}";


                }
                countAux++;
            }
        });

        return {success: sections.length > 0, data: '{' + info + '}'};
    }
    $scope.getValuesFieldsAnswer = function (data, fieldType, sectionId) {
        var info = "";
        var count = data.length - 1;
        var countAux = 0;
        var keyName = "";
        if (fieldType == "3") {
            keyName = "checkbox"
        }
        angular.forEach(data, function (value, key) {
            var field_id = value.field_id;
            var fieldOptions = value.data;

            var resultOptions = $scope.getValuesOptionsAnswer(value, sectionId);
            if (countAux < count) {
                var valuesSet = "";
                info += '"' + keyName + "_" + field_id + '"' + ":" + "{" + resultOptions + "}" + ",";
            } else {
                info += '"' + keyName + "_" + field_id + '"' + ":" + "{" + resultOptions + "}";


            }
            countAux++;
        });
        return {success: data.length > 0, data: info};
    }
    $scope.getValuesOptionsAnswer = function (field, sectionId) {
        var info = "";
        var countAux = 0;
        var data = field.data;
        var count = data.length - 1;
        var fieldType = field.field_type;
        var field_id = field.field_id;

        angular.forEach(data, function (value, key) {
            var option_id = value.id;
            var option_comment = value.option_comment;

            if (countAux < count) {

                info += '"' + option_id + '"' + ":" + 'true' + ",";
            } else {
                info += '"' + option_id + '"' + ":" + 'true';

            }
            if (fieldType == "3") {
                if (option_comment) {
                    $scope.checkButtonsValidationsManagement[sectionId][field_id][option_id]['required'] = true;
                    $scope.checkButtonsValidationsManagement[sectionId][field_id][option_id]['model'] = option_comment;
                    var keysInfo = "section_id:" + sectionId + ",field_type:" + fieldType + ",field_row_id:" + field_id;
                    $scope.checkButtonsValidationsManagement[sectionId][field_id][option_id]['keysInfo'] = keysInfo;


                }
            } else if (fieldType == "2") {
                if (option_comment) {
                    $scope.radioButtonsValidationsManagement[sectionId][field_id][option_id]['required'] = true;
                    $scope.radioButtonsValidationsManagement[sectionId][field_id][option_id]['model'] = option_comment;
                    var keysInfo = "section_id:" + sectionId + ",field_type:" + fieldType + ",field_row_id:" + field_id;
                    $scope.radioButtonsValidationsManagement[sectionId][field_id][option_id]['keysInfo'] = keysInfo;

                }
            }
            countAux++;
        });
        return info;
    }
    /*-----------ASKWER-------*/
    $scope.getConfigurationInformationSection = function () {
        /*-------------    fields.name_parent-----------*/
        /*    "3"://checkbox ,  "formData.parentCheckChekee" . $fieldId;
           "1"://text  "n" . $fieldId . '_' . $fieldType
        "2"://radio button   "formData2.parentCheckChekee" . $fieldId;
        "4"://toogle yes   'formDataboolean.parentCheckChekee' . $fieldId;
        "5"://fecha  "solutions.n" . $fieldId . '_' . $fieldType;
        "6"://estrella  'formDatastart.parentCheckChekee' . $fieldId;*/

    }
    $scope.getTitleSection = function (section) {

        var numberQuiestions = section.fields.length;
        var html = section.name + "  " + "N° Preguntas <span class='section-content__title badge bg-color-orange' >" + numberQuiestions + "</span>";

        return html;
    }
    $scope.spanQuestions = function (section) {
        console.log(section)
    }
    $scope.getValuesOptionsAskwer = function (fieldOptions) {
        var info = "";
        var count = fieldOptions.length - 1;
        var countAux = 0;
        angular.forEach(fieldOptions, function (valueFields) {
            var option_id = valueFields.id;

            if (countAux < count) {

                info += '"' + option_id + '"' + ":" + '{"required":false}' + ",";
            } else {
                info += '"' + option_id + '"' + ":" + '{"required":false}';

            }
            countAux++;
        });
        return info;
    }

    $scope.getFieldsAskwer = function (fields, fieldType) {
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
        angular.forEach(lucky, function (valueFields) {
            var field_id = valueFields.id;
            var fieldOptions = $scope.getValuesOptionsAskwer(valueFields.fieldOptions);
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
    }

    $scope.getSectionsAskwer = function (sections, fieldType) {
        var resultCurrent = {success: false, data: []};
        angular.forEach(sections, function (value) {
            var section_id = value.id;
            var result = $scope.getFieldsAskwer(value.fields, fieldType);
            if (result.success) {//basta uno
                resultCurrent.success = true;
                var dataSection = {dataFields: result.data, section_id: section_id};
                resultCurrent.data.push(dataSection);

            }
        });
        return resultCurrent;
    }


    $scope.getObjSectionAskwer = function (data, fieldType) {
        var stringData = ""
        var stringDataResult = "";
        var countSections = data.length - 1;
        var countSectionsAux = 0;
        angular.forEach(data, function (value) {
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
    }

    /*
    --------Functions othera---------
    */
    $scope.searchData = function (buscar_aguja, data) {//aguja en un pajar
        var buscar_aguja = buscar_aguja;
        var array_paja = data;
        var encontrado = false;
        angular.forEach(array_paja, function (value) {
            // aquí pones todo el código que quieras para este único paralelo de
            // esta única materia.
            if (buscar_aguja == value) {
                encontrado = true;
                return encontrado;
            }

        });
        return encontrado;
    }
    $scope.ArrayListReady = function (data) {
        var max = data;
        var array_list = [];
        var aux_max = max;
        for (i = 0; i < max; i++) {
            array_list.push({value: aux_max});
            aux_max--;
        }
        return array_list;

    }
    $scope.resetForm = function (form) {
        if (form) {
            form.$setPristine();
            form.$setUntouched();
        }
    }
}


function AskwerFormManager($scope) {
    var radioButtonsTypeField = 2;
    var checkBoxTypeField = 3;


    /*  --CREATE----*/
    $scope.generateAskwerFormFields = function (dataAskwer) {
        $scope.modelInstitucionHasAskwer = dataAskwer.InstitucionHasAskwer;
        $scope.AskwerForm = {
            id: dataAskwer["AskwerForm"]["id"],
            description: dataAskwer["AskwerForm"]["description"],
        };

        var sections = dataAskwer.AskwerForm.sections;
        var result = $scope.getDataAskwerForm(sections);
        $scope.solutions = {};
        $scope.sections = {};
        $scope.radioButtonsValidations = {};
        $scope.checkButtonsValidations = {};
        $scope.solutions = result.solutions;
        $scope.sections = result.sections;
        $scope.radioButtonsValidations = result.radioButtonsValidations;
        $scope.checkButtonsValidations = result.checkButtonsValidations;
    }
    $scope.getValuesSendSave = function () {
        var allowSave = $scope.getAllowResultAskwerForm();
        var result = [];
        if (allowSave) {
            var solutionsCurrent = $scope.solutions;
            var dataManagement = {
                radioButtonsValidations: $scope.radioButtonsValidations,
                checkButtonsValidations: $scope.checkButtonsValidations
            };
            solutionsCurrent = $scope.getStructureFormSave(dataManagement, $scope.solutions);
            result = {
                InstitucionHasAskwer: $scope.modelInstitucionHasAskwer,
                AskwerForm: $scope.AskwerForm,
                solutions: solutionsCurrent
            };
        }

        return result;

    }
    $scope.getAllowResultAskwerForm = function () {
        var allowSave = false;
        angular.forEach($scope.solutions, function (valueSection, keySection) {

            if (Object.keys(valueSection).length) {
                allowSave = true;
            }
        });

        return allowSave;

    }

    $scope.getStructureFormSave = function (paramsData, pajar) {
        var result;
        var radioButtonsValidations = paramsData.radioButtonsValidations;
        var checkButtonsValidations = paramsData.checkButtonsValidations
        angular.forEach(radioButtonsValidations, function (valueSection, keySection) {
            angular.forEach(valueSection, function (valueField, keyField) {
                angular.forEach(valueField, function (valueOption, keyOption) {

                    if (valueOption.required) {
                        var keysInfo = valueOption.keysInfo;
                        var keysArray = keysInfo.split(',');
                        var section_id = keysArray[0].split(":")[1];
                        var field_type = keysArray[1].split(":")[1];
                        var field_row_id = keysArray[2].split(":")[1];
                        var comment_value = valueOption.model;
                        var answer_key = field_row_id + "_" + field_type;
                        var valueSelect = pajar[section_id][answer_key];
                        var stringObj = "'option_id':" + valueSelect + ",'comment_value':" + comment_value;
                        pajar[section_id][answer_key] = stringObj;

                    }
                });
            });
        });

        angular.forEach(checkButtonsValidations, function (valueSection, keySection) {
            console.log("keySection", keySection);


            angular.forEach(valueSection, function (valueFields, keyField) {
                console.log("keyField", keyField);


                var lucky = [];

                angular.forEach(valueFields, function (valueOption, keyOption) {
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
                angular.forEach(lucky, function (valueOption, keyOption) {
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

                    pajar[section_id][answer_key] = stringResult;
                }

            });
        });
        result = pajar;
        return result;
    }

    /*  --VIEW RESULTS----*/
    $scope.scoreManager = {
        score: 0
    };
    $scope.resultScoreByTypeField = function (field) {
        var scoreResult = 0;
        var field_type = field.field_type;
        if (field_type == checkBoxTypeField) {
            var data = field.data;
            angular.forEach(data, function (value, key) {
                scoreResult += parseFloat(value.option_puntaje);
            });
        } else if (field_type == radioButtonsTypeField) {
            var data = field.data;
            scoreResult += parseFloat(data.option_puntaje);

        }

        $scope.scoreManager.score = $scope.scoreManager.score + scoreResult;
    }
    $scope.getResultScore = function (resultsAsnwers) {
        angular.forEach(resultsAsnwers, function (section, keySection) {
            angular.forEach(section.fields, function (field, keyField) {

                $scope.resultScoreByTypeField(field);
            });
        });
    };
    $scope.getValuesByFieldType = function (fieldData) {
        var resultHtml = "";
        var log = [];
        var field_type = fieldData.field_type;
        if (field_type == checkBoxTypeField) {
            var countAux = fieldData.data.length;
            var count = 0;
            var data = fieldData.data;
            angular.forEach(data, function (value, key) {
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
            }, log);
        } else if (field_type == radioButtonsTypeField) {
            if (fieldData.comment_allow == 1) {
                resultHtml = "<span class='span-title-select-label'>Seleccionado</span>:" + fieldData.label + ", <span class='span-title-comment-label'>Cantidad:</span>" + fieldData.option_comment;
            } else {
                resultHtml = fieldData.label;

            }

        } else {
            resultHtml = fieldData.label;

        }

        return resultHtml;
    }
}

function starRating() {
    return {
        restrict: 'EA',
        template:
            '<ul class="star-rating" ng-class="{readonly: readonly}">' +
            '  <li ng-repeat="star in stars" class="star" ng-class="{filled: star.filled}" ng-click="toggle($index)">' +
            '    <i class="fa fa-star"></i>' + // or &#9733
            '  </li>' +
            '</ul>',
        scope: {
            ratingValue: '=ngModel',
            max: '=?', // optional (default is 5)
            onRatingSelect: '&?',
            readonly: '=?'
        },
        link: function (scope, element, attributes) {
//            console.log("scope", scope, "elemento", element, "atributo", attributes);
            if (scope.max == undefined) {
                scope.max = 5;
            }

            function updateStars() {
                scope.stars = [];
                for (var i = 0; i < scope.max; i++) {
                    scope.stars.push({
                        filled: i < scope.ratingValue
                    });
                }
            }
            ;
            scope.toggle = function (index) {
                if (scope.readonly == undefined || scope.readonly === false) {
                    scope.ratingValue = index + 1;
                    scope.onRatingSelect({
                        rating: index + 1
                    });
                }
            };
            scope.$watch('ratingValue', function (oldValue, newValue) {
                if (newValue) {
                    updateStars();
                }
            });
        }
    };
}
