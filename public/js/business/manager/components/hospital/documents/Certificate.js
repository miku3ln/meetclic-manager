var componentThisCertificate;
Vue.component('certificate-component', {
    template: '#certificate-template',
    directives: {},
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var $scope = this;
        /*     this.$root.$on("_updateParentByChildren", function (emitValue) {
                 $scope._managerTypes(emitValue);
             });
           */

    },
    beforeMount: function () {
        this.configParams = this.params;
        console.log(this.configParams);

    },
    mounted: function () {
        componentThisCertificate = this;
        this.initCurrentComponent(this.configParams);

    },
    validations: function () {
        var attributes = {

            type: {required},
            date: {required},
            full_name: {required},
            document: {required},
            description: {required},
            diagnosis: {required},
            recommendations: {required},
            gender: {},
            full_name_doctor: {required},
            name_profession: {required},
            preview: {},


        };
        if (this.model.attributes.type == 1) {
            attributes['diagnosis'] = {};
        }
        if (this.model.attributes.type == 2) {
            attributes['type'] = {};
            attributes['date'] = {};
            attributes['full_name'] = {};
            attributes['document'] = {};
            attributes['description'] = {};
            attributes['diagnosis'] = {};
            attributes['recommendations'] = {};
            attributes['gender'] = {};
            attributes['full_name_doctor'] = {};
            attributes['name_profession'] = {};


        }

        var result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;


    },
    data: function () {

        var dataManager = {
            manager_id: null,
            manager_key_name: 'business_id',
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
            configParams: {},
            labelsConfig: {
                "title": "Administracion de Informacion",
                buttons: {
                    save: "Guardar",
                    update: "Actualizar",
                    cancel: "Cancelar"
                }
            },

//form config
            model: {
                attributes: {
                    type: 0,
                    date: null,
                    full_name: null,
                    document: null,
                    description: null,
                    diagnosis: null,
                    recommendations: null,
                    gender: null,
                    full_name_doctor: 'Dr. Edwin Chinde Chamorro',
                    name_profession: 'Odontólogo',
                    preview: false,

                },
                labels: {
                    type: {
                        name: 'Tipo de Documentos *',
                        "options": [
                            {value: 0, text: 'Certificado de Seguro'},
                            {value: 1, text: 'Certificado de  Paciente'},
                            {value: 2, text: 'Historial de Paciente'},

                        ]
                    },
                    date: {
                        name: 'Fecha Emision *',

                    },
                    full_name: {
                        name: 'Nombre Paciente *',

                    },
                    document: {
                        name: 'Identificacion *',

                    },
                    description: {
                        name: 'Descripcion *',

                    },
                    diagnosis: {
                        name: 'Diagnostico *',

                    },
                    recommendations: {
                        name: 'Recomendaciones *',

                    },
                    gender: {
                        name: 'Genero *',

                    },
                    full_name_doctor: {
                        name: 'Nombre del Dr *',

                    },
                    name_profession: {
                        name: 'Profesion *',

                    },
                    preview: {
                        name: 'Ver Documento',

                    },
                }


            },
            tabCurrentSelector: '.content-form',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#certificate-form",
                url: $('#action-certificate-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el certificate.',
                successMessage: 'El certificate se guardo correctamente.',
                nameModel: "certificate"
            },

            managerViews: {
                createUpdate: false,
                admin: true,

            },
            managerType: null,
            managerCreate: false,
            rowData: null,
            configDataCertificate: {},
            allowAll: false,
            history_clinic_id: null

        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function (params) {
            var dataManagement = params['data'];
            var historyClinic = dataManagement['historyClinic'];
            var customer = {
                gender: historyClinic.gender,
                full_name: historyClinic['first_name'] + ' ' + historyClinic['last_name'],
                identification: historyClinic['identification'],

            };

            this.initValuesCertificate({
                customer: customer
            });
            this.initValuesCustomer({
                customer: customer
            });
            this.allowAll = true;
        },
        initValuesCertificate: function (params) {
            /*   {value: 0, text: "HOMBRE"},
               {value: 1, text: "MUJER"},
               {value: 2, text: "LGBTI"},
               {value: 3, text: "OTROS"}*/
            var customer = params['customer'];
            var seven = customer.gender == 0 ? 'Faculto al interesado hacer uso del presente documento para los fines que considere pertinentes. ' : 'Faculto a la interesada hacer uso del presente documento para los fines que considere pertinentes. ';
            var data = {
                'header': {
                    'title': 'Tulcan,'
                },
                'title': 'CERTIFICADO',
                'body': {
                    'one': 'Por el medio del presente , CERTIFICO que :',
                    'two': 'portador de la C.I.',
                    'three': 'N°',
                    'four': 'se realizó un tratamiento odontológico, ',
                    'five': 'Diagnóstico: ',
                    'six': 'Se recomienda: ',
                    'seven': seven,


                },

            };
            this.configDataCertificate = data;
        },
        initValuesCustomer: function (params) {
            var customer = params['customer'];
            this.model.attributes.full_name = customer.full_name;
            this.model.attributes.document = customer.identification;

        },
        makeToast: makeToast,
        validateForm: validateForm,
        getValidateForm: getValidateForm,
        getClassErrorForm: getClassErrorForm,
        _setValueFormPreview: function (value) {
            var $scope = this;
            if (value) {
                if (this.model.attributes.type == 0 || this.model.attributes.type == 1) {
                    this._generateDocument({type: 0})

                } else {

                    var history_clinic_id = this.configParams.data['historyClinic']['id'];
                    var dataSend = {
                        'filters': {
                            'history_clinic_id': history_clinic_id
                        }
                    };

                    ajaxRequestManager($('#action-history-clinic-getDataHistoryClinicLog').val(), {
                        type: 'POST',
                        data: dataSend,
                        blockElement: '.manager-process',//opcional: es para bloquear el elemento
                        loading_message: 'Cargando Informacion......',
                        error_message: 'Error Al cargar.',
                        success_message: 'Datos Cargados.',
                        success_callback: function (response) {
                            if (response.success) {
                                var dataManager = response.data;
                                $scope.initDataContent(dataManager);
                            }
                        }
                    });
                }
            }
        },
        getDataContent: function (management) {
            var content = [];
            var historyClinic = this.configParams.data['historyClinic'];
            var textSet = 'Historia # ' + historyClinic.id;
            var setPush = {
                text: textSet,
                style: 'introTitle'
            };
            content.push(setPush);
            var year = historyClinic['birthdate'].split('-')[0];
            var ageCurrent = calcAge(year);
            var address = historyClinic['street_one'] + ' y ' + historyClinic['street_two'];
            setPush = {
                style: 'tbl-information',
                table: {
                    widths: [100, '*', 100, '*'],
                    body: [
                        ['Nombres:', historyClinic['first_name'] + ' ' + historyClinic['last_name'], '# Identificacion', historyClinic['identification']],
                        ['Fecha Nacimiento:', historyClinic['birthdate'], '# Edad', ageCurrent],
                        ['Direccion:', address, 'Telefono', historyClinic['information_phone_value']],

                    ]
                }
            };
            content.push(setPush);
            var haystack = management['antecedents']['one'];
            if (Object.keys(haystack).length > 0) {

                var textSet = 'Antecedentes:';
                setPush = {
                    text: textSet,
                    style: 'antecedent-title'
                };
                content.push(setPush);
                var bodyTable = [];
                $.each(haystack, function (key, value) {
                    textSet = value['antecedent'] + ' : ' + value['description'];
                    var setPushCurrent = [textSet];
                    bodyTable.push(setPushCurrent);

                });
                setPush = {
                    style: 'tbl-antecedents',
                    table: {
                        widths: ['*'],
                        body: bodyTable
                    }
                };
                content.push(setPush);
            }
            haystack = management['treatments'];
            if (Object.keys(haystack).length > 0) {

                var textSet = 'Tratamientos';
                setPush = {
                    text: textSet,
                    style: 'treatment-title'
                };
                content.push(setPush);

                bodyTable = [
                    ['#', 'Fecha', 'Descripcion']
                ];
                $.each(haystack, function (key, value) {
                    var textSetOne = value['id'];
                    var textSetTwo = value['invoice_date'];
                    var textSetThree = 'Sin especificacion del sistema.';
                    var textSetFour = value['observations'];
                    var setPushCurrent = [textSetOne, textSetTwo, textSetFour];
                    bodyTable.push(setPushCurrent);

                });
                setPush = {
                    style: 'tbl-treatments',
                    table: {
                        widths: ['*', '*', '*', '*'],
                        body: bodyTable
                    }
                };
                content.push(setPush);
            }
            var docDefinition = {
                content: content,
                styles: {
                    introTitle: {

                        margin: [0, 35, 0, 15]

                    },
                    paragraphOneStyle: {
                        alignment: 'justify',
                        fontSize: 14,
                        margin: [0, 0, 0, 35]

                    },
                    'tbl-antecedents': {
                        /*[left, top, right, bottom]*/
                        margin: [0, 5, 0, 15]

                    },
                    'tbl-treatments': {
                        /*[left, top, right, bottom]*/
                        margin: [0, 5, 0, 15]

                    },
                    'treatment-title': {
                        /*[left, top, right, bottom]*/
                        margin: [0, 5, 0, 10]
                    },
                    'antecedent-title': {
                        /*[left, top, right, bottom]*/
                        margin: [0, 5, 0, 10]
                    },
                }

            };
            return docDefinition;
        },
        initDataContent: function (management) {
            var docDefinition = this.getDataContent(management);
            this._generateDocument({type: 1, docDefinition: docDefinition});

        },
//Manager Model


        _generateDocument: function (params) {
            var type = params['type'];
            var $scope = this;
            var docDefinition = {};
            if (type == 0) {
                var textOne = ($scope.configDataCertificate.header.title + '' + $scope.model.attributes.date);
                var textTwo = $scope.configDataCertificate.title;
                var paragraphOne = this.configDataCertificate.body.one + ' ' + this.model.attributes.full_name + ' ' + this.configDataCertificate.body.two + '' + this.model.attributes.document + ' ' + this.model.attributes.description;
                var paragraphTwo = this.configDataCertificate.body.five + '' + this.model.attributes.diagnosis;
                var paragraphThree = this.configDataCertificate.body.six + '' + this.model.attributes.recommendations;
                var paragraphFour = this.configDataCertificate.body.seven;
                var paragraphFive = 'Atentamente,';
                var paragraphSix = '________________________';
                var paragraphSeven = this.model.attributes.full_name_doctor;
                var paragraphEight = this.model.attributes.name_profession;
                var content = [
                    {
                        text: textOne,
                        style: 'rightTitle'
                    },
                    {text: textTwo, style: 'centerTitle'}
                ];
                var paragraphOneSet = {
                    text: paragraphOne, style: 'paragraphOneStyle'
                };
                content.push(paragraphOneSet);
                if (this.$v.model.attributes.type.$model == 0) {

                    var paragraphTwoSet = {
                        text: paragraphTwo, style: 'paragraphTwoStyle'
                    };
                    content.push(paragraphTwoSet);
                }

                var paragraphThreeSet = {
                    text: paragraphThree, style: 'paragraphThreeStyle'
                };
                content.push(paragraphThreeSet);

                var paragraphFourSet = {
                    text: paragraphFour, style: 'paragraphFourStyle'
                };
                content.push(paragraphFourSet);

                var paragraphFiveSet = {
                    text: paragraphFive, style: 'paragraphFiveStyle'
                };
                content.push(paragraphFiveSet);

                var paragraphSixSet = {text: paragraphSix, style: 'paragraphSixStyle'};
                content.push(paragraphSixSet);

                var paragraphSevenSet = {
                    text: paragraphSeven, style: 'paragraphSevenStyle'
                };
                content.push(paragraphSevenSet);

                var paragraphEightSet = {
                    text: paragraphEight, style: 'paragraphEightStyle'
                };

                content.push(paragraphEightSet);
                docDefinition = {
                    content: content,
                    styles: {
                        paragraphOneStyle: {
                            alignment: 'justify',
                            fontSize: 14,
                            margin: [0, 0, 0, 35]

                        },
                        paragraphTwoStyle: {
                            alignment: 'justify',
                            fontSize: 14,
                            margin: [0, 0, 0, 35]

                        },
                        paragraphThreeStyle: {
                            alignment: 'justify',
                            fontSize: 14,
                            margin: [0, 0, 0, 35]

                        },
                        paragraphFourStyle: {
                            alignment: 'justify',
                            fontSize: 14,
                            margin: [0, 0, 0, 35]

                        },
                        paragraphFiveStyle: {
                            alignment: 'center',
                            fontSize: 14,
                            margin: [0, 0, 0, 35]

                        },
                        paragraphSixStyle: {
                            alignment: 'center',
                            fontSize: 14,
                        },
                        paragraphSevenStyle: {
                            alignment: 'center',
                            fontSize: 14,


                        },
                        paragraphEightStyle: {
                            alignment: 'center',
                            fontSize: 14,


                        },
                        rightTitle: {
                            alignment: 'right',
                            fontSize: 14,
                            margin: [0, 35, 0, 35]
                        },
                        centerTitle: {
                            alignment: 'center',
                            fontSize: 18,
                            bold: true,
                            /*[left, top, right, bottom]*/
                            margin: [0, 40, 0, 40]
                        },

                    }

                };
            } else {
                docDefinition = params['docDefinition'];
            }


            pdfObjectInit = pdfMake.createPdf(docDefinition);
            pdfObjectInit.getDataUrl().then(data => {
                $('#iframe-pdf').attr('src', data);

            });

        }

    }
})
;

