/*---------CUSTOM CRUD------------*/
function initS2Entity($scope) {
    $scope.initS2TypeEntidad = function (element) {
        var element_id = $(element).attr("id");
        var urlGet = "";
        var placeholder = "";
        var type = "get";
        var dataType = "json";
        if (element_id == "type_ruc_id") {
            placeholder = "Seleccione";
            urlGet = baseUrl + "contabilidad/typeRuc/entityS2";
        }
        element.select2({
            initSelection: function (element, callback) {
                if ($(element).val()) {
                    var data = {id: element.val(), text: $(element).attr('selected-text')};
                    callback(data);
                }
            },
            placeholder: placeholder,
            ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                url: urlGet,
                type: type,
                dataType: dataType,
                data: function (term, page) {
                    var params = {
                        search_value: term,
                        entidad_data_id: entidad_id,
                    };
                    return params;
                },
                results: function (data, page) {
                    return {results: data};
                }
            },
            allowClear: true
        })
            .on("change", function (e) {
                // mostly used event, fired to the original element when the value changes
                $scope.logData(element_id + "change val=" + e.val);
            })
            .on("select2-opening", function () {
                $scope.logData("opening");
            })
            .on("select2-open", function () {
                // fired to the original element when the dropdown opens
                $scope.logData(element_id + " open");

            })
            .on("select2-close", function () {
                // fired to the original element when the dropdown closes
                $scope.logData(element_id + " close");
                $scope.addErrorElementS2(element);
                //
            })
            .on("select2-highlight", function (e) {
                $scope.logData(element_id + " highlighted val=" + e.val + " choice=" + e.choice.text);
            })
            .on("select2-selecting", function (e) {
                $scope.logData(element_id + " selecting val=" + e.val + " choice=" + e.object.text);
            })
            .on("select2-removed", function (e) {
                $scope.addErrorElementS2(element);
            })
            .on("select2-loaded", function (e) {
                $scope.logData(element_id + " loaded (data property omitted for brevitiy)");
            })
            .on("select2-focus", function (e) {
                $scope.logData(element_id + " focus");
            });

    }
    $scope.logData = function (data) {
//        console.log(data);
    }
    $scope.setDataS2Form = function (element_gestion, touched, error, dataSelect2) {
        $scope.gestion_data_frm[element_gestion].$touched = touched;
        $scope.gestion_data_frm[element_gestion].$error = error;
        var key_data_name = element_gestion + "_data";
        $scope.gestion_data[key_data_name] = dataSelect2;
        $scope.gestion_data[element_gestion] = dataSelect2;

    }
    $scope.addErrorElementS2 = function (element) {
        var element_id = $(element).attr("id");
        var element_gestion = element_id;
        if (element_id === "type_ruc_id") {

        }
        if (element.select2("data")) {
            $scope.setDataS2Form(element_gestion, false, {}, element.select2("data"));
            $scope.$apply();
        } else {
            $scope.setDataS2Form(element_gestion, true, {required: true}, null);
            $scope.$apply();
        }
    }
//    Programmatic access :https://select2.github.io/examples.html
    $scope.eventsS2 = function (element, type, data) {
        switch (type) {
            case "destroy":
                element.select2("destroy");
                break;
            case "open":
                element.select2("open");
                break;
            case "close":
                element.select2("close");
                break;
            case "trigger":
                element.val(null).trigger("change");
                break;
            case "data":
                element.select2("data", data);
                break;
            case "getdata":
                return element.select2("data");
                break;
        }


    }
}
