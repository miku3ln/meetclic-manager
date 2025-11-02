(function () {
    /**
     * Ajuste decimal de un número.
     *
     * @param {String}  tipo  El tipo de ajuste.
     * @param {Number}  valor El numero.
     * @param {Integer} exp   El exponente (el logaritmo 10 del ajuste base).
     * @returns {Number} El valor ajustado.
     */
    function decimalAdjust(type, value, exp) {
        // Si el exp no está definido o es cero...
        if (typeof exp === 'undefined' || +exp === 0) {
            return Math[type](value);
        }
        value = +value;
        exp = +exp;
        // Si el valor no es un número o el exp no es un entero...
        if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
            return NaN;
        }
        // Shift
        value = value.toString().split('e');
        value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
        // Shift back
        value = value.toString().split('e');
        return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
    }

    // Decimal round
    if (!Math.round10) {
        Math.round10 = function (value, exp) {
            return decimalAdjust('round', value, exp);
        };
    }
    // Decimal floor
    if (!Math.floor10) {
        Math.floor10 = function (value, exp) {
            return decimalAdjust('floor', value, exp);
        };
    }
    // Decimal ceil
    if (!Math.ceil10) {
        Math.ceil10 = function (value, exp) {
            return decimalAdjust('ceil', value, exp);
        };
    }
})();
function UtilInvoice(params) {
    var $scope=params['$scope'];
    $scope.regularPhraseNumberInvoice = /^(?:\D*\d){3}\D*$/;//number of tres digitos
    $scope.regularDigits = /^([0-9])*$/;
    $scope.validateNumberInvoiceType = function ($params) {
        var valueCurrent = $params["value"];
        var typeCurrent = $params["type"];
        var isValid = false;
        var regularPhrase = $scope.regularPhraseNumberInvoice;// 3 digitos y diferente de 000
        if (regularPhrase.test(valueCurrent)) {
            if (parseInt(valueCurrent) == 0) {
                isValid = false;
            } else {
                isValid = true;

            }
        } else {
            isValid = false;

        }
        return isValid;
    }
    $scope.validateDigits = function ($params) {
        var valueCurrent = $params["value"];
        var typeCurrent = $params["type"];
        var isValid = false;
        var regularPhrase = $scope.regularDigits;// 3 digitos y diferente de 000
        if (regularPhrase.test(valueCurrent)) {
            if (parseInt(valueCurrent) == 0) {
                isValid = false;
            } else {
                isValid = true;

            }
        } else {
            isValid = false;

        }
        return isValid;
    }
    $scope.viewDataFixed = function (value) {

        var result = $scope.getValueCustomer(value);
        return result;
    }
    $scope.getDateStringCurrentByFormat = function (params) {
        var format = params["format"];
        var dateArray = $dataDateCurrent.format.split("-");
        var result = "";
        var year = dateArray[0];
        var month = dateArray[1];
        var dayHoursArray = dateArray[2].split(" ");
        var day = dayHoursArray[0];
        var hours = dayHoursArray[0];

        if (format == "Y-M-D") {
            result = year + "-" + month + "-" + day;
        } else if (format == "M-D-Y") {
            result = month + "-" + day + "-" + year;

        } else if (format == "Y/M/D") {
            result = year + "/" + month + "/" + day;
        } else if (format == "M/D/Y") {
            result = month + "/" + day + "/" + year;

        }

        return result;

    }
    $scope.getValueCustomer = function (value) {

        var result = 0;
        if (value) {
            result = Math.round10(value, -2);
        }
        return result;
    }
    $scope.getValueCustomerUpDown = function (value, upDown, type = "decimal") {

        var result = 0;
        if (type == "floor") {

            if (value) {
                result = Math.floor10(value, upDown);
            }
        } else {
            if (value) {
                result = Math.round10(value, upDown);
            }
        }
        return result;
    }
    $scope.getResultFormatValue = function (value) {
        var result = 0;
        if (value) {
            result = Math.round10((value), -2);
        }
        return result;
    };
    $scope.searchDataByParams = function (params) {//aguja en un pajar
        var haystack = params.haystack;
        var needle = params.needle;
        var keySearch = params.keySearch;
        var result = [];
        angular.forEach(haystack, function (value) {
            if (needle == value[keySearch]) {
                result.push(value);
            }

        });
        return result;
    };
    $scope.sortByParams = function (params) {
        var orderByKey = params["orderByKey"];
        var haystack = params["haystack"];

        var sortData = haystack.sort(function (a, b) {
            if (a[orderByKey] > b[orderByKey]) {
                return 1;
            }
            if (a[orderByKey] < b[orderByKey]) {
                return -1;
            }
            // a must be equal to b
            return 0;
        });

        return sortData;
    };
    $scope.getStateInitialSituationDate = function () {
        var dateInit = "";
        if (Object.keys($dateManagerESI).length) {

            $dateCurrentState = $dateManagerESI["format"].split("-");
            dateInit = toDate($dateCurrentState[2] + "-" + $dateCurrentState[1] + "-" + $dateCurrentState[0], "-");
        } else {
            $dateCurrentState = $dataDateCurrent["format"].split("-");
            var stringDate = $dateCurrentState[2].split(" ")[0] + "-" + $dateCurrentState[1] + "-" + $dateCurrentState[0];
            dateInit = toDate(stringDate, "-");
        }

        return dateInit;
    }
}
