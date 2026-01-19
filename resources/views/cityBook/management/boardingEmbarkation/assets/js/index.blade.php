<?php

$allowShop = 0;

if ($dataManagerPage['shopConfig']['allow'] == true) {
    $allowShop = 1;
}
?>
@include('partials.mangerVueJS')
@include('partials.plugins.resourcesJs',['bootgrid'=>true])
<script type="text/javascript">var pathDevelopers = '{{asset($resourcePathServer.'wulpy/developers')}}/';</script>
<script type="text/javascript">var $resourcesCustom = '{{asset($resourcePathServer.'images')}}/';</script>


<script
    src="{{ asset($resourcePathServer.'plugins/higcharts-2024/highcharts.js') }}"
    type="text/javascript"></script>
<script
    src="{{ asset($resourcePathServer.'plugins/higcharts-2024/modules/data.js') }}"
    type="text/javascript"></script>
<script
    src="{{ asset($resourcePathServer.'plugins/higcharts-2024/modules/annotations.js') }}"
    type="text/javascript"></script>
<script
    src="{{ asset($resourcePathServer.'plugins/higcharts-2024/modules/exporting.js') }}"
    type="text/javascript"></script>
<script
    src="{{ asset($resourcePathServer.'plugins/higcharts-2024/modules/export-data.js') }}"
    type="text/javascript"></script>
<script
    src="{{ asset($resourcePathServer.'plugins/higcharts-2024/modules/accessibility.js') }}"
    type="text/javascript"></script>

<script type="text/javascript">
    function formatDateTimeDMY(datetimeStr) {
        if (!datetimeStr) return '';

        var parts = datetimeStr.split(' ');
        var datePart = parts[0]; // 2025-08-06
        var timePart = parts[1] || '';

        var d = datePart.split('-'); // [2025, 08, 06]

        return d[2] + '/' + d[1] + '/' + d[0] + (timePart ? ' ' + timePart : '');
    }

    var $configPartial = <?php echo json_encode($configPartial) ?>;
    var $allowAllInOne = '<?php echo env('allowAllInOne') ? '1' : '0' ?>';
    var $buttonsConfig = {
        "names": {
            "one": "{{__('config.buttons.one')}}",
            "two": "{{__('config.buttons.two')}}",
            "three": "{{__('config.buttons.three')}}",
            "four": "{{__('config.buttons.four')}}",
            "five": "{{__('config.buttons.five')}}",

        },
    };
    var $allowShop = '{{$allowShop}}';

    function formatDateTimeForDB(dateObj) {
        var d = dateObj instanceof Date ? dateObj : new Date(dateObj);

        var yyyy = d.getFullYear();
        var mm = String(d.getMonth() + 1).padStart(2, '0');
        var dd = String(d.getDate()).padStart(2, '0');

        var HH = String(d.getHours()).padStart(2, '0');
        var ii = String(d.getMinutes()).padStart(2, '0');
        var ss = String(d.getSeconds()).padStart(2, '0');

        return yyyy + "-" + mm + "-" + dd + " " + HH + ":" + ii + ":" + ss;
    }
</script>

@include('cityBook.management.'.$managementNameProcess.'.assets.js.templateVue')
@include('partials.plugins.resourcesJs',['blockUi'=>true])


<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
        integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
        crossorigin="anonymous"></script>
@include('partials.plugins.resourcesJs',['toast'=>true])

<script src="{{ asset($resourcePathServer.'js/developers/UtilCustom.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/Utils.js')}}" type='text/javascript'></script>

<!--NEWS-->
@include('partials.plugins.resourcesJs',['croppie'=>true])

@include('partials.plugins.resourcesJs',['select2'=>true])

<script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>

<script>

    var $methodsProcessCurrent = {
        managerSaveBoarding: function (e) {
            console.log(e);
        }
    };
</script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/ManagementFormEventDetails.js') }}"
        type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/Main.js') }}"
        type="text/javascript"></script>
<script>
    function buildCedulaDefaultResponse() {
        return {
            success: false,
            message: "",
            data: {
                full_name: null,
                last_name: null,
                name: null,
                document: null
            }
        };
    }

    function normalizeDigits(value) {
        return String(value || "").replace(/\D/g, "");
    }

    function isCedulaEC(value) {
        var cedula = normalizeDigits(value);
        if (cedula.length !== 10) return false;

        var prov = parseInt(cedula.substring(0, 2), 10);
        if (prov < 1 || prov > 24) return false;

        var third = parseInt(cedula.charAt(2), 10);
        if (third < 0 || third > 5) return false;

        var total = 0;
        for (var i = 0; i < 9; i++) {
            var d = parseInt(cedula.charAt(i), 10);
            if (i % 2 === 0) {
                d = d * 2;
                if (d > 9) d -= 9;
            }
            total += d;
        }

        var check = (10 - (total % 10)) % 10;
        return check === parseInt(cedula.charAt(9), 10);
    }

    var registerFormComponent = null;
    Vue.component('register-form-component', {
        components: {},
        template: '#register-form-template',
        directives: {
            'init-grid-filters': {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    paramsInput.initMethod({
                        objSelector: el
                    });

                },
            },
        },
        props: {
            params: {
                type: Object,
            }
        },
        created: function () {
            var vmCurrent = this;
            this.$root.$on("_pointsSales", function (emitValue) {
                vmCurrent._managerTypes(emitValue);
            });
            registerFormComponent = vmCurrent;

        },
        beforeMount: function () {
            this.configParams = this.params;

        },
        mounted: function () {
            componentThisEventsTrailsProject = this;
            this.managerCurrentBusiness = this.params.data;
            this.startClockInterval();
        },
        beforeDestroy: function () {
            // Importante para no dejar intervalos vivos
            this.stopClockInterval();
        },
        computed: {},
        validations: function () {
            var attributes = null;

            attributes = {

                people: {
                    required,
                    minLength: minLength(1),
                    $each: {
                        last_name: {
                            required
                        },
                        full_name: {
                            required
                        },
                        name: {
                            required
                        },
                        document_number: {
                            required,
                        },
                        age: {
                            required,
                            minValue: minValue(0),
                        },

                    }
                }
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
                formConfig: {
                    nameSelector: "#business-by-lodging-form",
                    url: $('#action-management-save').val(),
                    loadingMessage: 'Guardando...',
                    errorMessage: 'Error al guardar el ' + this.processName,
                    successMessage: 'La tarjeta de registro se guardo correctamente.',
                    nameModel: "Lodging"
                },
                labelsConfig: {
                    buttons: {
                        cancel: "Cancelar",
                        create: "Cancelar",
                        update: "Cancelar",
                        delete: "Cancelar",

                    },

                },
                lblBtnSave: "Guardar",
                lblBtnClose: "Cerrar",
                model: {
                    attributes: this.getAttributesForm(),
                    structure: this.getStructureForm(),
                },
                managerCurrentBusiness: null,
                clockIntervalId: null,
            };

            dataManager.apiCedula = {cache: {}, inflight: {}, timers: {}};

            return dataManager;
        },
        watch: {
            'model.attributes.people': {
                deep: true,
                handler: function (people) {
                    console.log("people", people);
                    var vm = this;
                    people = people || [];

                }
            }
        },

        methods: {
            ...$methodsFormValid,
            _removePeople: function (index, vModel) {
                this.model.attributes.people.splice(index, 1);

            },


            _updateClockNow: function () {
                var now = new Date();

                // Fecha: DD/MM/YYYY
                var dd = String(now.getDate()).padStart(2, '0');
                var mm = String(now.getMonth() + 1).padStart(2, '0');
                var yyyy = now.getFullYear();
                this.managerCurrentBusiness.time.date = dd + "/" + mm + "/" + yyyy;

                // Hora: hh:mm AM/PM
                var hours = now.getHours();
                var minutes = String(now.getMinutes()).padStart(2, '0');
                var ampm = hours >= 12 ? "PM" : "AM";

                hours = hours % 12;
                hours = hours ? hours : 12; // 0 -> 12
                var hh = String(hours).padStart(2, '0');

                this.managerCurrentBusiness.time.hour = hh + ":" + minutes + " " + ampm;
            },

            startClockInterval: function () {
                // 1) actualiza inmediatamente
                this._updateClockNow();

                // 2) limpia si ya existía
                if (this.clockIntervalId) clearInterval(this.clockIntervalId);

                // 3) actualiza cada X ms (ej: 1000 = 1s, 60000 = 1min)
                this.clockIntervalId = setInterval(() => {
                    this._updateClockNow();
                }, 1000);
            },

            stopClockInterval: function () {
                if (this.clockIntervalId) {
                    clearInterval(this.clockIntervalId);
                    this.clockIntervalId = null;
                }
            },
            getValueViewAddAllow: function () {
                var mainAddAllow = false;
                if (!this.$v.model.attributes.people.required) {
                    mainAddAllow = false;
                } else {

                }
                return mainAddAllow;

            },
            _lockGuestRow: function (index) {
                var idRow = this.getIdManagerGuest(index);
                $("#" + idRow + "-full_name").addClass("row-loading");
                $("#" + idRow + "-document_number").addClass("row-loading");


            },

            _unlockGuestRow: function (index) {
                var idRow = this.getIdManagerGuest(index);


                $("#" + idRow + "-full_name").removeClass("row-loading");
                $("#" + idRow + "-document_number").removeClass("row-loading");

            },
            getIdManagerGuest: function (index, v) {
                var result = "manager-information-" + index;
                return result;
            },
            getClassGuest: function (modelData) {
                var result = "secondary";
                return result;
            },
            getLabelTitleGuest: function (index, modelData) {
                var result = this.labelsConfig.manager.guest + "" + index + "";
                return result;
            },
            getLabelForm: viewGetLabelForm,

            getViewPeopleProcess: function () {
                var haystack = this.$v.model.attributes.people.$each.$iter;
                var result = Object.keys(haystack).length > 0
                return result;
            },
            getStructureForm: function () {
                var result = {
                    last_name: {
                        id: "last_name",
                        name: "last_name",
                        label: "Nombres Completos",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    full_name: {
                        id: "full_name",
                        name: "full_name",
                        label: "Nombres Completos",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },

                    name: {
                        id: "name",
                        name: "name",
                        label: "Nombres",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    type_document: {
                        id: "type_document",
                        name: "type_document",
                        label: "Tipo de Identificación",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    document_number: {
                        id: "document_number",
                        name: "document_number",
                        label: "Identificacion",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                    age: {
                        id: "age",
                        name: "age",
                        label: "Edad",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },


                };

                return result;
            },

            getAttributesForm: function () {
                var result = {
                    people: [],
                };
                let valuesPeople = this.getValueInitPeople();
                result.people = valuesPeople;
                return result;
            },
            validateForm: function () {
                var currentAllow = this.getValidateForm();
                return currentAllow.success;
            },
            getValidatePeopleAll: function (haystack) {
                var $peopleErrors = [];
                var setPush = {};
                var allEmptyRows = true;
                if (Object.keys(haystack).length > 0) {
                    allEmptyRows = false;
                    $.each(haystack, function (indexRow, valueRow) {
                        if (valueRow.last_name.$invalid || valueRow.age.$invalid || valueRow.document_number.$invalid) {
                            if (valueRow.last_name.$invalid) {
                                setPush = {
                                    index: indexRow,
                                    inputName: "last_name",
                                    "type": "row"
                                }
                                $peopleErrors.push(setPush);
                            }
                            if (valueRow.age.$invalid) {
                                setPush = {
                                    index: indexRow,
                                    inputName: "age",
                                    "type": "row"
                                }
                                $peopleErrors.push(setPush);
                            }
                            if (valueRow.document_number.$invalid) {
                                setPush = {
                                    index: indexRow,
                                    inputName: "document_number",
                                    "type": "row"
                                }
                                $peopleErrors.push(setPush);
                            }


                        }

                    });
                } else {
                    setPush = {
                        "type": "row_all"
                    }
                    $peopleErrors.push(setPush);
                }
                var success = Object.keys($peopleErrors).length == 0 ? false : true;
                var result = {
                    success: success,
                    errors: $peopleErrors,
                    empty: allEmptyRows
                }
                return result;
            },
            getValidateForm: function () {
                var success = true;
                var attributeCurrent = "";

                var errors = [];
                var $peopleInValid = false;

                var $peopleValidate = this.getValidatePeopleAll(this.$v.model.attributes.people.$each.$iter);
                if ($peopleValidate.success) {
                    $peopleInValid = true;
                    errors.push(
                        {
                            "type": "people", "fields": $peopleValidate.errors
                        }
                    );
                }

                if (
                    $peopleInValid


                ) {

                    success = false;

                }
                var result = {
                    success: success,
                    errors: errors
                };
                return result;
            },
            getValuesPeopleAll: function (haystack) {
                var result = [];
                $.each(haystack, function (indexRow, valueRow) {
                    var modelCurrent = valueRow.$model;
                    // Normalizar age a número
                    var ageNum = parseInt(modelCurrent.age, 10);
                    console.log(valueRow)
                    var type = null;
                    if (!isNaN(ageNum)) {
                        if (ageNum <= 2) type = 'INFANT';
                        else if (ageNum >= 3 && ageNum <= 17) type = 'CHILD';
                        else if (ageNum >= 18 && ageNum <= 64) type = 'ADULT';
                        else type = 'SENIOR';
                    }

                    var setPush = {
                        last_name: modelCurrent.last_name,
                        name: modelCurrent.name,
                        age: modelCurrent.age,
                        document_number: modelCurrent.document_number,

                        type: type
                    };

                    result.push(setPush);

                });
                return result;
            },
            getValuesSave: function () {

                var People = this.getValuesPeopleAll(this.$v.model.attributes.people.$each.$iter);
                var data = this.managerCurrentBusiness;
                console.log("data", data);
                var result = {
                    MaritimeDepartures: {
                        business_id: this.managerCurrentBusiness.maritimeInformation.business_id,
                        maritime_vessels_id: this.managerCurrentBusiness.maritimeInformation.maritime_vessels_id,
                        arrival_time: formatDateTimeForDB(new Date()),
                        responsible_name: this.managerCurrentBusiness.responsible.fullName,
                    },
                    Customers: People,
                };

                return result;
            },
            _saveModel: function () {
                var dataSendResult = this.getValuesSave();
                var dataSend = dataSendResult;
                var vCurrent = this;
                vCurrent.$v.$touch();
                var validateCurrent = this.validateForm();
                if (!validateCurrent) {
                    vCurrent.submitStatus = 'error';

                } else {
                    ajaxRequestManager(this.formConfig.url, {
                        type: 'POST',
                        data: dataSend,
                        blockElement: vCurrent.tabCurrentSelector,//opcional: es para bloquear el elemento
                        loading_message: vCurrent.formConfig.loadingMessage,
                        error_message: vCurrent.formConfig.errorMessage,
                        success_message: vCurrent.formConfig.successMessage,
                        success_callback: function (response) {
                            if (response.success) {
                                vCurrent.resetForm();
                            }
                        }
                    });
                }
            },
            _fetchCedula: function (cedula) {
                var vm = this;
                var url = $("#action-management-consultarCedula").val();

                return new Promise(function (resolve) {
                    // defaults
                    var result = buildCedulaDefaultResponse();

                    if (!url) {
                        result.message = "URL de consulta no configurada.";
                        return resolve(result);
                    }

                    $.ajax({
                        url: url,
                        method: "GET",
                        data: {cedula: cedula}
                    })
                        .done(function (res) {
                            // Si tu backend ya devuelve exactamente {success,message,data} lo respetamos,
                            // pero garantizamos que exista data con las llaves correctas.
                            var out = buildCedulaDefaultResponse();

                            out.success = (res && res.success === true);
                            out.message = (res && res.message) ? String(res.message) : "";

                            // Normaliza data
                            var d = (res && res.data) ? res.data : null;

                            out.data.full_name = d && d.full_name ? d.full_name : null;
                            out.data.last_name = d && d.last_name ? d.last_name : null;
                            out.data.name = d && d.name ? d.name : null;
                            out.data.document = d && d.document ? String(d.document) : cedula;

                            // Si el backend dijo success true pero no trajo data útil, lo bajamos a false.
                            if (out.success === true && !out.data.document) {
                                out.success = false;
                                out.message = out.message || "Respuesta inválida: sin documento.";
                            }

                            resolve(out);
                        })
                        .fail(function () {
                            result.message = "Error al consultar la cédula.";
                            resolve(result); // ✅ nunca reject
                        });
                });
            },
            _setValueForm: async function (name, value, position = null, model = null) {

                var isPeopleField =
                    ("full_name" == name || "last_name" == name || "main" == name || "name" == name ||
                        "people_nationality_id" == name || "people_profession_id" == name ||
                        "type_document" == name || "document_number" == name ||
                        "age" == name || "gender" == name || "mail" == name ||
                        "postal_code" == name || "phone" == name || "mobile" == name ||
                        "has_information_additional" == name);

                // ✅ Fields dentro de people
                if (isPeopleField && position !== null) {
                    // 1) Set Vuelidate
                    model["$model"] = value;
                    model.$touch();
                    // 2) Set DATA real
                    if (this.model.attributes.people[position]) {
                        this.$set(this.model.attributes.people[position], name, value);
                    }

                    // 3) SOLO document_number: validar cédula aquí y nada más
                    if (name === "document_number") {
                        var cedula = String(value || "").replace(/\D/g, "");

                        // ✅ si NO es cédula válida -> no hace nada
                        if (!isCedulaEC(cedula)) {

                        } else {
                            this._lockGuestRow(position);

                            try {
                                var apiRes = await this._onPeopleDocumentChanged(position, cedula);

                                if (apiRes.success === true) {
                                    var d = apiRes.data;

                                    // apellidos
                                    this.$set(this.model.attributes.people[position], "last_name", d.last_name);
                                    this.$set(this.model.attributes.people[position], "name", d.name);
                                    this.$set(this.model.attributes.people[position], "full_name", d.full_name);
                                    // nombres
                                }

                            } finally {
                                // ✅ desbloquear pase lo que pase
                                this._unlockGuestRow(position);
                            }

                        }


                    } else if (name == "full_name") {

                        var document_number = this.model.attributes.people[position].document_number;
                        if (!isCedulaEC(document_number)) {
                            this.$set(this.model.attributes.people[position], "last_name",value);
                            this.$set(this.model.attributes.people[position], "name",value);
                        }
                    }

                    return;
                } else {

                    // ✅ Fields fuera de people
                    this.model.attributes[name] = value;
                    this.$v["model"]["attributes"][name].$model = value;
                    this.$v["model"]["attributes"][name].$touch();
                }

            },
            _onPeopleDocumentChanged: async function (index, value) {
                var cedula = String(value || "").replace(/\D/g, "");
                var result = buildCedulaDefaultResponse();
                result.data.document = cedula || null;

                // 1) Debe tener 10 dígitos
                if (cedula.length !== 10) {
                    result.message = "Documento incompleto (se requieren 10 dígitos).";
                    return result;
                }

                // 2) Debe pasar algoritmo de cédula EC
                if (!isCedulaEC(cedula)) {
                    result.message = "Cédula ecuatoriana no válida.";
                    return result;
                }

                // 3) Cache (si ya consultaste esa cédula, retornas el mismo shape)
                if (this.apiCedula && this.apiCedula.cache && this.apiCedula.cache[cedula]) {
                    return this.apiCedula.cache[cedula];
                }

                // 4) Evitar duplicados en vuelo
                if (this.apiCedula && this.apiCedula.inflight && this.apiCedula.inflight[cedula]) {
                    result.message = "Consulta en proceso.";
                    return result;
                }
                if (this.apiCedula && this.apiCedula.inflight) this.apiCedula.inflight[cedula] = true;

                // 5) Consultar API
                var apiRes = await this._fetchCedula(cedula);

                // ✅ asegurar que SIEMPRE sea shape correcto
                if (!apiRes || typeof apiRes !== "object") apiRes = buildCedulaDefaultResponse();

                // cachear siempre (incluso fallos, opcional). Yo cacheo solo éxitos:
                if (apiRes.success === true && this.apiCedula && this.apiCedula.cache) {
                    this.apiCedula.cache[cedula] = apiRes;
                }

                // liberar inflight
                if (this.apiCedula && this.apiCedula.inflight) this.apiCedula.inflight[cedula] = false;

                return apiRes;
            },

            getNameAttributePeople: function (index, name) {
                var result = this.formConfig.nameModel + "[" + index + "][" + name + "]";
                return result;
            },
            getClassErrorForm: getClassErrorForm,
            getViewErrorForm: function (nameElement, objValidate) {
                let resultValidate = getClassErrorForm(nameElement, objValidate);
                let result = resultValidate["form-group--error"];
                return result;
            },

            resetForm: function () {
                deleteData = [];
                this.$v.$reset();
                this.model = {
                    attributes: this.getAttributesForm(),
                    structure: this.getStructureForm()
                };
                this.model.attributes.id = null;


            },
            _addPeople: function () {
                let initValue = this.getModelInitPeople();
                this.model.attributes.people.push(initValue);
            },
            getModelInitPeople: function () {
                return {
                    last_name: null,
                    name: null,
                    type_document: null,
                    document_number: null,
                    age: null,
                    gender: null,
                    phone: null,
                    mobile: null,

                };
            },
            getValueInitPeople: function () {
                let result = [];

                result.push(this.getModelInitPeople());
                result.push(this.getModelInitPeople());
                result.push(this.getModelInitPeople());
                return result;

            },
            _submitForm: function (e) {
                console.log(e);
            },

        }
    })

</script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/App.js') }}" type="text/javascript"></script>


<script id="reports">
    var reportData = {
        success: false, data: []
    };


</script>
