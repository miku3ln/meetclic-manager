var componentThisManagementFormEvent;
Vue.component('management-form-event-component', {
    template: '#management-form-event-template',
    directives: {
        initS2: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var paramsSet = paramsInput;
                paramsSet['objSelector'] = el
                paramsInput.method(paramsSet);
            }
        }

    }
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {


    },
    beforeMount: function () {
        this.configParams = this.params;
        console.log(this.configParams);

    },
    mounted: function () {
        componentThisManagementFormEvent = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var minLengthCurrent = 0;

        var team_id = this.model.attributes.team_id;
        var haystack = this.optionsTeams;
        $.each(haystack, function (k, v) {
            if (v.value == team_id) {
                minLengthCurrent = v.quantity;
            }
        });
        this.managerCustomers = minLengthCurrent;
        var attributes = {
            team_id: {required},
            distance_id: {required},
            people: {
                required,
                minLength: minLength(minLengthCurrent),
                $each: {
                    user_id: {required},
                    category_id: {required},
                    kits: {required},

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
            model_id: null,
            /*  ----MANAGER ENTITY---*/
            configParams: {},
            labelsConfig: {
                "title": "Formulario de Registro",
                "event": "",

                buttons: {
                    return: "Regresar",
                    verify: "Verificar",
                    manager: "Agregar al Carrito."
                },
                msg: {
                    customers_user: "Si no aparece tu nombre de usuario,Registrate o registra a tus amigos para poder seguir con los pasos de inscripcion."
                }
            },

//form config
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#modal-management-form-event',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#management-form-event-form",
                url: $('#action-management-form-event-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ManagementFormEvent.',
                successMessage: 'El ManagementFormEvent se guardo correctamente.',
                nameModel: "ManagementFormEvent"
            },

            submitStatus: "no",
            showManager: false,
            managerType: null,
            managerCustomers: null,
            optionsTeams: [],
            optionsCategories: [],
            optionsSizes: [],
            optionsColors: [],
            optionsDistances: [],
            optionsManagementDistances: [],
            optionsManagementKits: [],
            modelAux: [],
            modelView: [],
            managementViews: {
                preview: false,
                management: true
            },
            preview: false
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        initCurrentComponent: function () {
            this.initDataModal();
            this.$refs.refManagementFormEventModal.show();
        },

        /*modal events*/
        _resetComponent: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalManagementFormEvent'
            });
        },
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._resetComponent();

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing

            // Trigger submit handler
            var distance = this.getDistanceCurrent({needle: this.model.attributes.distance_id});
            this.modelView = this.setManagementView();
            var sale_price = distance.price;
            var tax_value = 12;
            var tax_percentage = 12;
            var is_service = 0;
            var code_product = '12';
            var product = {
                id: this.configParams.data.id,
                description: this.configParams.data.description,
                name: this.configParams.data.name,
                sale_price: sale_price,
                tax_value: tax_value,
                tax_percentage: tax_percentage,
                'source': this.configParams.data.source,
                is_service: is_service,
                code_product: code_product,
                code: '',
                'team': this.modelView.team,
                'team_id': this.modelView.team_id,
                'distance': this.modelView.distance,
                'distance_id': this.modelView.distance_id,
                'people': this.model["attributes"]['people']
            };
            var amount = 1;
            product['count'] = amount;
            var price_before = sale_price;
            var price_discount = 0;
            var allow_discount = 0;
            var promotion_id = null;
            var priceCurrent = sale_price;
            var measure_id = -1;
            var measure = "";
            priceCurrent = parseFloat(product['sale_price']);
            product['price'] = priceCurrent;
            var sale_not_tax = priceCurrent;
            product['sale_not_tax'] = sale_not_tax;
            product['measure_id'] = measure_id;
            product['measure'] = measure;
            product['price_before'] = price_before;
            product['price_discount'] = price_discount;
            product['allow_discount'] = allow_discount;
            product['promotion_id'] = promotion_id;
            product['has_tax'] = 0;
            _setItemShop(product);
            this._hideModal();
            var msg = 'Evento agregado correctamente.';
            $.NotificationApp.send({
                heading: "Informacion!",
                text: msg,
                position: 'bottom-left',
                loaderBg: '#bf5c15',
                icon: 'info',
                hideAfter: 5000
            });
            bvModalEvt.preventDefault();
        },
        _cancel: function () {
            this.$refs.refManagementFormEventModal.hide();
            this._resetComponent();

        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
            this.model_id = rowCurrent.id;
            this.labelsConfig.event = rowCurrent.name;
            var result = allowManagementTakePart({data: rowCurrent});
            var allowProcess = result.allowProcess;
            var allowCurrent = $.inArray('teams', allowProcess);
            if (allowCurrent != -1) {
                var haystack = rowCurrent.teams;
                var haystackSet = [];
                $.each(haystack, function (k, v) {
                    var setPush = {value: v.id, text: v.value, quantity: v.quantity};
                    haystackSet.push(setPush)
                });
                this.optionsTeams = haystackSet;
            }
            allowCurrent = $.inArray('distances', allowProcess);
            if (allowCurrent != -1) {
                haystack = rowCurrent.distances;
                var haystackSet = [];
                $.each(haystack, function (k, v) {
                    var setPush = {
                        value: v.id,
                        text: v.value + ' - ' + v.events_trails_type_teams + ' - ' + v.price,
                        distance: v.value,

                        events_trails_type_teams_id: v.events_trails_type_teams_id,
                        price: v.price,
                    };
                    haystackSet.push(setPush)
                });
                this.optionsManagementDistances = haystackSet;
            }
            allowCurrent = $.inArray('kits', allowProcess);
            if (allowCurrent != -1) {
                haystack = rowCurrent.kits;
                var haystackSet = [];
                $.each(haystack, function (k, v) {
                    var has_size = v.sizes.length > 0;
                    var has_color = v.colors.length > 0;
                    var colors = v.colors;
                    var sizes = v.sizes;
                    var modelColor = has_color ? colors[0]['id'] : null;
                    var modelSize = has_size ? sizes[0]['id'] : null;
                    var setPush = {
                        value: v.entity_id,
                        text: v.name,
                        has_size: has_size,
                        has_color: has_color,
                        colors: {data: colors, model: modelColor},
                        sizes: {data: sizes, model: modelSize},


                    };
                    haystackSet.push(setPush)
                });
                this.optionsManagementKits = haystackSet;
            }

            allowCurrent = $.inArray('categories', allowProcess);
            if (allowCurrent != -1) {
                haystack = rowCurrent.categories;
                var haystackSet = [];
                $.each(haystack, function (k, v) {
                    var setPush = {
                        value: v.id,
                        text: v.value + ' Limite  ' + v.init_limit + ' - ' + v.end_limit + ' años.',
                    };
                    haystackSet.push(setPush)
                });
                this.optionsCategories = haystackSet;
            }
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.initDataModal();
                this.$refs.refManagementFormEventModal.show();

            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_carouselEvents', params);
        },

//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {


            }
        },

        managementData: function (params) {

        },
//MANAGER PROCESS

//FORM CONFIG
        getViewErrorForm: function (objValidate) {
            var result = false
            if (!objValidate.$dirty) {
                result = objValidate.$dirty ? (!objValidate.$error) : false;
            } else {
                result = objValidate.$error;
            }
            return result;
        },
        _submitForm: function (e) {
            console.log(e);
        },
        getStructureForm: function () {
            var result = {

                team_id: {
                    id: "team_id",
                    name: "team_id",
                    label: "Equipo",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        },
                    data: []
                },
                distance_id: {
                    id: "distance_id",
                    name: "distance_id",
                    label: "Distancia/Precio",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                kit_id: {
                    id: "kit_id",
                    name: "kit_id",
                    label: "Kit",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }

                },
                user_id: {
                    id: "user_id",
                    name: "user_id",
                    label: "Nombre de Usuario",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                size_id: {
                    id: "size_id",
                    name: "size_id",
                    label: "Talla",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                color_id: {
                    id: "color_id",
                    name: "color_id",
                    label: "Color",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                category_id: {
                    id: "category_id",
                    name: "category_id",
                    label: "Categoria",
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
                team_id: null,
                distance_id: null,
                people: []

            };
            return result;
        },

        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,

        _setValueFormItem: function (index, name, value) {


            this.model.attributes['people'][index][name] = value;
            this.$v["model"]["attributes"]['people'].$model[index][name] = value;
            this.$v["model"]["attributes"]['people'].$each['$iter'][index][name].$touch();
            if (this.modelAux[index]) {

                this.modelAux[index][name] = value;
            }
        },
        _setValueFormItemKit: function (index, indexKit, name, value) {
            this.modelAux[index]['kits'][indexKit][name]['model'] = value;
        },

        _setValueForm: function (name, value) {

            if (name == 'team_id') {
                var haystack = this.optionsManagementDistances;
                var haystackSet = [];
                this.optionsDistances = [];
                if (this.$v["model"]["attributes"]['distance_id'].$dirty) {
                    this.$v["model"]["attributes"]['distance_id'].$model = null;
                    this.$v["model"]["attributes"]['distance_id'].$touch();
                }
                $.each(haystack, function (k, v) {
                    if (v.events_trails_type_teams_id == value) {
                        haystackSet.push(v);
                    }
                });
                var quantity = 0;
                var team_id = value;
                var haystack = this.optionsTeams;
                $.each(haystack, function (k, v) {
                    if (v.value == team_id) {
                        quantity = v.quantity;
                    }

                });
                this.$v["model"]["attributes"]['people'].$model = [];
                this.managerCustomers = null;
                this.modelAux = [];
                for (var i = 0; i < quantity; i++) {
                    let optionsManagementKits = this.optionsManagementKits;
                    var kits = optionsManagementKits;
                    var setPush = {
                        category_id: null,
                        kits: kits,
                        'user_id': null
                    }

                    this.$v["model"]["attributes"]['people'].$model.push(setPush);
                }

                this.optionsDistances = haystackSet;
                for (var i = 0; i < quantity; i++) {
                    $('#user_id_' + i).val(null).trigger('change');
                    let haystack = this.optionsManagementKits;
                    var kits = [];
                    $.each(haystack, function (k, v) {
                        kits.push(v);
                    });
                    var setPush = {
                        category_id: null,
                        kits: kits,
                        'user_id': null

                    };
                    this.modelAux.push(setPush)
                }
                this.managerCustomers = quantity;
            }
            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();

        },
        getClassErrorForm: function (nameElement, objValidate) {
            var result = null;
            result = {
                "form-group--error": objValidate.$error,
                'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
            };

            return result;
        }
        ,
//Manager Model

        getValuesSave: function () {

            var result = {
                ManagementFormEvent:
                    {}
            };

            return result;
        }
        ,

        resetForm: function () {

            this.$v.$reset();
            this.model = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm()
            };
            this.model.attributes.id = null;
        }
        ,
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        }
        ,
        validateForm: function () {
            var currentAllow = this.getValidateForm();
            var currentAllowKits = this.validateKits();
            var validateKits = currentAllowKits.success;
            return currentAllow.success && validateKits;
        },
        validateKits: function () {
            var haystack = this.modelAux;
            var success = Object.keys(haystack).length > 0;
            $.each(haystack, function (k, v) {
                var kits = v.kits;
                $.each(kits, function (kKit, vKit) {
                    var has_size = vKit.has_size;
                    var has_color = vKit.has_color;
                    if (has_size) {
                        if (!vKit.sizes.model) {
                            success = false;
                        }
                    }
                    if (has_color) {
                        if (!vKit.colors.model) {
                            success = false;
                        }
                    }

                });

            });
            var result = {
                success: success
            };
            return result;

        },
        getValidateForm: getValidateForm,

//others functions

        getDistanceCurrent: function (params) {
            var needle = params['needle'];
            var haystack = this.optionsDistances;
            var result = null;
            $.each(haystack, function (k, v) {
                if (v.value == needle) {
                    result = v;
                    return result;
                }
            });

            return result;
        },
        getTeamCurrent: function (params) {
            var needle = params['needle'];
            var haystack = this.optionsTeams;
            var result = null;
            $.each(haystack, function (k, v) {
                if (v.value == needle) {
                    result = v;
                    return result;
                }
            });

            return result;
        },
        getCategoryCurrent: function (params) {
            var needle = params['needle'];
            var haystack = this.optionsCategories;
            var result = null;
            $.each(haystack, function (k, v) {
                if (v.value == needle) {
                    result = v;
                    return result;
                }
            });

            return result;
        },
        getDataCurrent: function (params) {
            var needle = params['needle'];
            var haystack = params['haystack'];
            var result = null;
            $.each(haystack, function (k, v) {
                if (v.id == needle) {
                    result = v;
                    return result;
                }
            });

            return result;
        },
        setManagementView: function () {
            var haystack = this.modelAux;
            var people = [];

            var $scope = this;
            $.each(haystack, function (k, v) {
                var category_id = v.category_id;
                var categoryData = $scope.getCategoryCurrent({
                    needle: category_id
                });
                var kits = v.kits;
                var kitCurrent = [];
                $.each(kits, function (kKit, vKit) {
                    var has_size = vKit.has_size;
                    var has_color = vKit.has_color;
                    var nameKit = vKit.text;
                    var kitVariants = [];
                    if (has_size) {
                        var keyId = vKit.sizes.model;
                        var sizeData = $scope.getDataCurrent({
                            needle: keyId,
                            haystack: vKit.sizes.data
                        });
                        var setPushKit = 'Talla:' + sizeData.text;
                        kitVariants.push(setPushKit);

                    }
                    if (has_color) {
                        var keyId = vKit.colors.model;
                        var colorData = $scope.getDataCurrent({
                            needle: keyId,
                            haystack: vKit.colors.data
                        });
                        var setPushKit = 'Color:' + colorData.text;
                        kitVariants.push(setPushKit);
                    }

                    if (Object.keys(kitVariants).length > 0) {
                        nameKit = nameKit + ' - ' + kitVariants.join(',') + '<br>';
                    } else {
                        nameKit = nameKit + '<br>';

                    }
                    kitCurrent.push(nameKit);
                });

                var setPush = {

                    'one': {
                        'label': 'Participante Nro ' + (k + 1) + ' :',
                        'value': v.user_id.full_name,
                        'id': v.user_id.id
                    },
                    'two': {
                        'label': 'Tipo Doc :',
                        'value': '',
                    },
                    'three': {
                        'label': 'Nro Documento :',
                        'value': '',
                    },
                    'four': {
                        'label': 'Fecha de Nacimiento :',
                        'value': '',
                    },
                    'five': {
                        'label': 'Telefono :',
                        'value': '',
                    },
                    'six': {
                        'label': 'Correo Electronico',
                        'value': '',
                    },
                    'seven': {
                        'label': 'Genero',
                        'value': '',
                    },
                    'eight': {
                        'label': 'Categoria :',
                        'value': categoryData.text,
                    },
                    'nine': {
                        'label': 'Kit :',
                        'value': kitCurrent.join(''),
                        'data': kits
                    },


                };
                people.push(setPush);


            });
            var team = this.getTeamCurrent({needle: this.model.attributes.team_id});
            var distance = this.getDistanceCurrent({needle: this.model.attributes.distance_id});
            var result = {
                team: team.text,
                team_id: team.value,
                distance: distance.distance,
                distance_id: distance.value,
                people: people,
            };

            return result;
        },
        _verify: function (allow) {
            this.managementViews.management = false;
            this.managementViews.preview = false;
            if (allow) {
                this.managementViews.preview = true;
                this.modelView = this.setManagementView();
            } else {

                this.managementViews.management = true;

            }
        },
        _managerS2Users: function (params) {
            var el = params.objSelector;
            var paramsCurrent = params['params'];
            var index = paramsCurrent.index;
            var $scope = this;
            var businessId = null;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action-users-listAllRoutes").val(),
                    type: "get",
                    dataType: 'json',
                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: businessId
                            }
                        };
                        return paramsFilters;
                    },
                    processResults: function (data, page) {

                        return {results: data};
                    }
                },
                allowClear: true,
                multiple: true,
                maximumSelectionLength: 1,

                width: '100%'
            });
            elementInit.on("change", function (e) {
                var dataCurrent = elementInit.select2('data');
                if (dataCurrent.length != 0) {
                    $scope._setValueFormItem(index, 'user_id', dataCurrent[0]);

                } else {
                    $scope.model.attributes.user_id = null;
                    $scope._setValueFormItem(index, 'user_id', null);
                }
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });


        },

    }
})
;




