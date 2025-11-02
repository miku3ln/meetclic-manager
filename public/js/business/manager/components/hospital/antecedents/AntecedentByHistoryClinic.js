var componentThisAntecedent;
Vue.component('antecedent-by-history-clinic-component', {
    template: '#antecedent-by-history-clinic-template',
    directives: {},
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var $scope = this;


    },
    beforeMount: function () {
        this.configParams = this.params;
        var antecedents = this.configParams.data.antecedents;
        this.history_clinic_id = this.configParams.data.historyClinic.id;
        this.initDataManagement({
            antecedents: antecedents,
            history_clinic_id: this.history_clinic_id,

        });
    },
    mounted: function () {

    },
    data: function () {
        var result = {
            selected: [], // Must be an array reference!
            selectedAux: [], // Must be an array reference!
            options: [],
            optionsDescriptions: [],
            configParams: null,
            history_clinic_id: null,
            selectedManagement: [], // Must be an array reference!
            isNew: false,
            managerEquals: 'antecedent_id',
            labelsConfig: {
                "title": "Administracion de Informacion",
                buttons: {
                    create: "Guardar",
                    update: "Actualizar",
                    cancel: "Cancelar"
                }
                , titles: {
                    'one': 'ANTECEDENTES PATOLÓGICOS',
                    'two': 'ANTECEDENTES PATOLÓGICOS',

                }
            },

        };

        return result;
    },

    methods: {
        ...$methodsFormValid,

        initDataManagement: function (params) {
            var antecedentsManagement = [];
            var managementAux = [];
            var selectedInit = [];
            var selectedInitAux = [];
            var optionsDescriptions = [];
            $.each(params.antecedents, function (index, value) {
                var setPush = value;
                setPush['text'] = value.antecedent;
                var description = setPush['description'];
                description = value.description == null ? 'not description' : value.description;

                setPush['value'] = value.antecedent_id;
                antecedentsManagement.push(
                    setPush
                );
                var isNew = value.id == null ? true : false;
                setPush['isNew'] = isNew;
                setPush['selected'] = false;
                if (!isNew) {
                    setPush['isNew'] = false;
                    selectedInitAux.push(value.antecedent_id);
                    selectedInit.push(value.antecedent_id);
                    setPush['delete'] = false;
                    setPush['selected'] = true;

                }
                managementAux.push(setPush);
                setPush = description;
                optionsDescriptions.push(setPush)
            });
            this.options = antecedentsManagement;
            this.selectedManagement = managementAux;
            this.selected = selectedInit;
            this.selectedAux = selectedInitAux;
            this.isNew = selectedInit.length > 0 ? false : true;
        },
        _antecedent: function (selected) {

            var $scope = this;
            var selectedManagement = this.selectedManagement;
            //RESET ALL
            $.each(selectedManagement, function (indexSelect, valueRowSelect) {
                selectedManagement[indexSelect]['selected'] = false;
                if (valueRowSelect.isNew) {
                    selectedManagement[indexSelect]['delete'] = false;
                }
            });
            if (selected.length > 0) {
                $.each(selected, function (indexRow, valueRow) {
                    $.each(selectedManagement, function (indexSelect, valueRowSelect) {
                        if (valueRowSelect[$scope.managerEquals] == valueRow) {
                            selectedManagement[indexSelect]['selected'] = true;
                        }
                    });
                });
                var selectAuxAdd = [];
                var managementAuxInit = this.selectedAux;
                $.each(managementAuxInit, function (indexRow, valueRow) {

                    var needleSearch = $scope.searchSelected({
                        haystack: selected,
                        'needle': valueRow
                    });
                    if (!needleSearch) {//delete
                        $.each(selectedManagement, function (indexSelect, valueRowSelect) {
                            if (!valueRowSelect.isNew) {
                                if (valueRow == valueRowSelect[$scope.managerEquals]) {
                                    selectedManagement[indexSelect]['delete'] = true;
                                }
                            }
                        });
                    }

                })
                ;
            } else {
                if (!this.isNew) {
                    $.each(selectedManagement, function (indexSelect, valueRowSelect) {
                        selectedManagement[indexSelect]['selected'] = false;
                        if (!valueRowSelect.isNew) {
                            selectedManagement[indexSelect]['delete'] = true;
                        }
                    });
                }
            }
            this.selectedManagement = selectedManagement;
            console.log(selectedManagement);
        },
        _antecedentOther: function () {
console.log(this.selected);
        },
        searchSelected: function (params) {
            var result = false;
            $.each(params.haystack, function (indexSelect, valueRowSelect) {
                    if (valueRowSelect == params.needle) {
                        result = true;
                        return result;

                    }
                }
            );
            return result;
        },
        getValuesSave: function () {


            var result = {
                //user
                history_clinic_id: this.history_clinic_id,
                data: this.selectedManagement,
            };


            return result;
        },
        validateForm: function () {
            var result = true;
            if (this.isNew) {
                var $scope = this;
                var selectedManagement = this.selectedManagement;
                //RESET ALL
                result = false;
                $.each(selectedManagement, function (indexSelect, valueRowSelect) {

                    if (valueRowSelect['selected']) {
                        result = true;
                    }
                });
            }

            return result;
        },
        _saveModel: function () {
            var allowSave = true;
            if (!this.isNew) {//update

            } else {//create

            }
            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var $scope = this;
            ajaxRequestManager($scope.configParams.urlManager.createUpdate, {
                type: 'POST',
                data: dataSend,
                blockElement: $scope.configParams.contentManagement,//opcional: es para bloquear el elemento
                loading_message: $scope.configParams.msg.management,
                error_message: $scope.configParams.msg.error,
                success_message: $scope.configParams.msg.success,
                success_callback: function (response) {
                    if (response.success) {
                        var dataManager = response.data;
                        var antecedents = dataManager.antecedents.data;
                        $scope.initDataManagement({
                            antecedents: antecedents,
                            history_clinic_id: $scope.history_clinic_id,

                        });
                    }
                }
            });
        },
    }
})
;
