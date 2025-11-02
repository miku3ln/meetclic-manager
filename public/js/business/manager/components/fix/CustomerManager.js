var controllerCustomer = null;

function CustomerManager($scope, $uibModalInstance, params) {
    controllerCustomer = $scope;
    $scope.loadData = false;
    $scope.htmlTitle = '<h1>Creacion de Cliente</h1>'
    $uibModalInstance.rendered.then(function () {
        $scope.loadData = true;
        $scope.resetForm();
    });
    $scope.dataCurrent = params['data'];
    $scope.resultSaveModel = {customer_id_data: null, type: 'CustomerFix'};
    $scope._close = function () {
        $uibModalInstance.close(
            $scope.resultSaveModel);
    }

    $scope.model = null;
    $scope.defaultTypeIdentification = '2';
    $scope.defaultRucType = '4';
    $scope.defaultNationality = '71';
    $scope.defaultProfession = '1';
    $scope.defaultGender = '0';

    $scope.getDataModel = function () {

        var result = {
            id: null,

            business_id: this.business_id,
            customer_by_information_id: null,
            identification_document: null,//
            people_type_identification_id_data: $scope.defaultTypeIdentification,//
            people_id_data: null,
            business_name: null,
            business_reason: null,
            ruc_type_id_data: $scope.defaultRucType,//
            //PEOPLE
            last_name: null,//
            name: null,//
            birthdate: null,//
            gender_data: $scope.defaultGender,//
            // CUSTOMER INFORMATION
            people_nationality_id_data: $scope.defaultNationality,//
            people_profession_id_data: $scope.defaultProfession,//

            /*Address Information*/
            "information_address_id": null,
            "street_one": null,
            "street_two": null,
            "reference": null,
            "state": null,
            "entity_id": null,
            "main": null,
            "entity_type": null,
            "information_address_type_id_data": null,
            "has_location": null,
            "options_map": null,
            'information_address_location_current': null,
            "phone": null,

        };
        return result;
    };
    $scope.genderData = [
        {value: 0, text: "HOMBRE"},
        {value: 1, text: "MUJER"},
        {value: 2, text: "LGBTI"},
        {value: 3, text: "OTROS"}
    ];
    $scope.resetForm = function () {
        $scope.formManager.$setUntouched();
        $scope.formManager.$setPristine();
        $scope.model = {
            attributes: $scope.getDataModel(),
        };

    };

    $scope.peopleNationalityData = $configPartial["dataCatalogue"]["peopleNationality"];
    $scope.peopleProfessionData = $configPartial["dataCatalogue"]["peopleProfession"];
    $scope.peopleTypeIdentificationData = $configPartial["dataCatalogue"]["peopleTypeIdentification"];
    $scope.rucTypeData = $configPartial["dataCatalogue"]["rucType"];

    $scope.getErrorForm = function (attribute) {
        var hasError =
            $scope.formManager[attribute].$error.required &&
            $scope.formManager[attribute].$touched;

        var result = {
            "has-error": hasError,
            "has-success": !hasError
        };

        return result;
    };
    $scope.validateForm = function () {
        var currentAllow = !$scope.formManager.$invalid;
        return currentAllow;
    };
    $scope.business = $modelDataManager["business"][0];
    $scope.business_id = $scope.business.id;
    $scope.tabCurrentSelector = ".modal-dialog";
    $scope.processName = "Registro Cliente.";
    $scope.formConfig = {
        nameSelector: "#repair-form",
        url: $("#action-customer-saveDataFix").val(),
        loadingMessage: "Guardando...",
        errorMessage: "Error al guardar el Orden.",
        successMessage: "La Orden se guardo correctamente.",
        nameModel: "Customer"
    };
    $scope.managerInformationAddress = {
        allow: false
    };
    $scope.getValuesSave = function () {

        var result = {
            Customer: $scope.managerInformationAddress.allow ? {
                    //CUSTOMER
                    id: $scope.model.attributes.id ? $scope.model.attributes.id : -1,
                    identification_document: $scope.model.attributes.identification_document,
                    people_type_identification_id: $scope.model.attributes.people_type_identification_id_data,
                    people_id: $scope.model.attributes.people_id_data,
                    business_name: $scope.model.attributes.business_name,
                    business_reason: $scope.model.attributes.business_reason,
                    ruc_type_id: $scope.model.attributes.ruc_type_id_data,
                    //CUSTOMER INFORMATION
                    customer_id: $scope.model.attributes.customer_id ? $scope.model.attributes.customer_id : -1,
                    people_nationality_id: $scope.model.attributes.people_nationality_id_data,
                    people_profession_id: $scope.model.attributes.people_profession_id_data,
                    //PEOPLE
                    last_name: $scope.model.attributes.last_name,
                    name: $scope.model.attributes.name,
                    birthdate: moment($scope.model.attributes.birthdate).format("YYYY-MM-DD"),
                    gender: $scope.model.attributes.gender_data,
                    business_id: $scope.business_id,
                    age: 0,
                    customer_by_information_id: $scope.model.attributes.customer_by_information_id ? $scope.model.attributes.customer_by_information_id : -1,
                    "information_address_type_id": 1,
                    "information_address_id": $scope.model.attributes.information_address_id ? $scope.model.attributes.information_address_id : -1,
                    "street_one": $scope.model.attributes.street_one,
                    "reference": $scope.model.attributes.reference,
                    "street_two": $scope.model.attributes.street_two,
                    "has_location": 1,
                    "options_map": $scope.model.attributes.options_map,
                    "information_address_location_current": $scope.model.attributes.information_address_location_current,
                    'phone': $scope.model.attributes.phone

                } :
                {
                    //CUSTOMER
                    id: $scope.model.attributes.id ? $scope.model.attributes.id : -1,
                    identification_document: $scope.model.attributes.identification_document,
                    people_type_identification_id: $scope.model.attributes.people_type_identification_id_data,
                    people_id: $scope.model.attributes.people_id_data,
                    business_name: $scope.model.attributes.business_name,
                    business_reason: $scope.model.attributes.business_reason,
                    ruc_type_id: $scope.model.attributes.ruc_type_id_data,
                    //CUSTOMER INFORMATION
                    customer_id: $scope.model.attributes.customer_id ? $scope.model.attributes.customer_id : -1,
                    people_nationality_id: $scope.model.attributes.people_nationality_id_data,
                    people_profession_id: $scope.model.attributes.people_profession_id_data,
                    //PEOPLE
                    last_name: $scope.model.attributes.last_name,
                    name: $scope.model.attributes.name,
                    birthdate: moment($scope.model.attributes.birthdate).format("YYYY-MM-DD"),
                    gender: $scope.model.attributes.gender_data,
                    business_id: $scope.business_id,
                    age: 0,
                    customer_by_information_id: $scope.model.attributes.customer_by_information_id ? $scope.model.attributes.customer_by_information_id : -1,
                    'phone': $scope.model.attributes.phone
                }

        };
        result['Filters'] = $scope.dataCurrent;
        return result;
    };
    $scope._saveModel = function () {
        var dataSendResult = $scope.getValuesSave();
        var dataSend = dataSendResult;
        var vCurrent = $scope;
        var validateCurrent = $scope.validateForm();
        if (!validateCurrent) {
            vCurrent.submitStatus = 'error';

        } else {
            ajaxRequest($scope.formConfig.url, {
                type: 'POST',
                data: dataSend,
                blockElement: vCurrent.tabCurrentSelector,//opcional: es para bloquear el elemento
                loading_message: vCurrent.formConfig.loadingMessage,
                error_message: vCurrent.formConfig.errorMessage,
                success_message: vCurrent.formConfig.successMessage,
                success_callback: function (response) {

                    if (response.success) {
                        var attributes = response.data;
                        $scope.resultSaveModel['customer_id_data'] = attributes;
                        $scope._close();
                        $scope.$apply();
                    } else {
                        showAlert('warning', 'Error al registrar Cliente.');
                    }
                }
            });
        }
    };
}
