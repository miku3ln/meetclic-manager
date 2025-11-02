//BUSINESS-MANAGER-COMPONENT-JS--ProductParentByPackageParams

Vue.component('product_parent_by_package_params-component', {

    components: {}, template: '#product_parent_by_package_params-template', directives: {},
    props: {
        params: {
            type: Object,
        },
        'processData': {
            type: Object,
        }
    }, created: function () {
        var dataCurrent = this.params.managerSteps.two.body.tabs.two.table.data;
        this.dataManager = dataCurrent;
        this.dataManagerAux = JSON.stringify(dataCurrent);
        var keyCurrentProcess = this.process_table + '_data';

        var dataSetAttributes = [];
        $.each(dataCurrent, function (key, value) {
            var setPush = {
                id: value.id,
                name: value.name,
                type_param: value.type_param,
                limit_one: value.limit_one,
                limit_two: value.limit_two,
                product_parent_by_prices_id_data: value.product_parent_by_prices_id_data,
                product_parent_id:value.product_parent_id,
            };
            dataSetAttributes.push(setPush);

        });
        this.model.attributes[keyCurrentProcess] = dataSetAttributes;
        this.product_parent_id = this.params.managerSteps.process.parent_id;


        var dataParentPricesAll = this.params.managerSteps.two.body.tabs.one.table.data;
        var dataParentPricesManager = this.getDataPricesManager({haystack: dataParentPricesAll});
        this.dataParentPricesAll = dataParentPricesAll;
        this.setDataPricesManager(dataParentPricesManager);
        this.initEmmitFromComponents();
        componentThisPackageParams = this;

    }, beforeMount: function () {

    }, mounted: function () {
        this.onModalEvents();
        this.watchProperties();
    },
    beforeDestroy: function () {
        this.destroyEmmitFromComponents();
    },
    validations: function () {
        var attributes = null;
        var keyCurrentProcess = this.process_table + '_data';
        attributes = {
            [keyCurrentProcess]: {
                required, minLength: minLength(1), $each: {
                    id: {
                        required
                    }, name: {
                        required
                    }, type_param: {
                        required
                    }, limit_one: {
                        required,
                    },
                    limit_two: {required},
                    product_parent_id: {
                        required,
                    },
                    product_parent_by_prices_id_data: {
                        required,
                    }
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
            product_parent_id: null,
            managerCurrentDeleteData: {},
            dataManager: [],
            dataManagerAux: '',
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            }, formConfig: {
                nameModel: "ProductParentByPackageParams"
            },
            managerModalConfig: {
                selector: '#modal-delete-product_parent_by_package_params',
                selectorTitle: '.modal-delete-product_parent_by_package_params__title',
                selectorBody: '.modal-delete-product_parent_by_package_params__body',
                selectorFooterDismiss: '.modal-delete-product_parent_by_package_params__btn-close',
                selectorFooterRegister: '.modal-delete-product_parent_by_package_params__btn-accept',

            },
            process_table: 'product_parent_by_package_params',
            product_parent_by_prices_id_data_default: 0,
            type_param_data: [
                {id: 0, text: 'Igual a'},
                {id: 1, text: 'Mayor y menor a'},
                {id: 2, text: 'Mayor o igual a'},

            ],
            data_prices: [],
            dataParentPricesAll: {},
            dataParentPrices: {},
            typeParamsData: {
                TYPE_EQUAL_TO: 0,
                GREATER_AND_LESS_THAN: 1,
                GREATER_THAN_OR_EQUAL_TO: 2
            },
            managerInformation: {
                isCreate: true,
                dataParent: null
            },
        };
        return dataManager;
    }, methods: {
        initEmmitFromComponents: function () {
            this.$parent.$on('message-to-' + this.process_table, this.handleMessageFromParent);
        },
        destroyEmmitFromComponents: function () {
            this.$parent.$off('message-to-' + this.process_table, this.handleMessageFromParent);
        },
        handleMessageFromParent: function (params) {
            if (params.type == 'onSaveModelComponent') {
                this.product_parent_id = params.data.information['ProductParent'].id;
            }
        },
        ...$methodsFormValid,
        watchProperties: function () {
            var keyView = this.process_table + '_data';
            var watchCurrent = "model.attributes." + keyView;
            this.$watch(watchCurrent, (newValue, oldValue) => {
                console.log('Se ha producido un cambio en el objeto formData.');
                console.log('Nuevo valor:', newValue);
                console.log('Valor anterior:', oldValue);

                // Aquí puedes agregar la lógica que necesites para manejar los cambios en el objeto formData
            }, {deep: true});
            this.$watch('dataParentPricesAll', (newValue, oldValue) => {
                console.log('Se ha producido dataParentPrices');
                var dataParentPricesManager = this.getDataPricesManager({haystack: newValue});
                this.setDataPricesManager(dataParentPricesManager);

            }, {deep: true});
            this.$watch('params.managerSteps.two.body.tabs.one', (newValue, oldValue) => {
                console.log('Se ha producido params.managerSteps.two.body.tabs.one');
            }, {deep: true});
        },
        setDataPricesManager: function (dataParentPricesManager) {
            this.dataParentPrices = dataParentPricesManager.data;
            if (dataParentPricesManager.keyDefaultData == null) {
                this.product_parent_by_prices_id_data_default = null;
            } else {
                this.product_parent_by_prices_id_data_default = dataParentPricesManager.keyDefaultData.id;

            }
        },
        getDataPricesManager: function (params) {
            var result = {
                data: [],
                keyDefaultData: null,
            };
            var data = [];
            var keyDefaultData = null;
            $.each(params.haystack, function (key, value) {
                if (keyDefaultData == null) {
                    keyDefaultData = {
                        id: value.id,
                        text: value.description,
                    };
                }
                var setPush = {
                    id: value.id,
                    text: value.description,

                };
                data.push(setPush);
            });

            result.data = data;
            result.keyDefaultData = keyDefaultData;

            return result;

        },
        getViewDataProcess: function () {
            var keyManager = this.process_table + '_data';

            var haystack = this.$v.model.attributes[keyManager].$each.$iter;
            var result = Object.keys(haystack).length > 0;
            return result;
        }, getClassErrorForm: function (nameElement, objValidate) {

            var result = null;
            result = {
                "form-group--error": objValidate.$error,
                'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
            };

            return result;
        }, getLabelForm: function (nameId, model) {


            var labelName;
            if (model) {
                labelName = model['structure'][nameId].label + (model['structure'][nameId].required.allow ? "<span class='form__label--required'>*</span>" : "");

            } else {
                labelName = this.model.structure[nameId].label + (this.model.structure[nameId].required.allow ? "<span class='form__label--required'>*</span>" : "");

            }
            return labelName;

        }, getNameAttributeData: function (index, name) {
            var result = this.formConfig.nameModel + "[" + index + "][" + name + "]";
            return result;
        },
        getStructureForm: function () {
            var result = {

                name: {
                    id: "name", name: "name", label: "Nombre del Paquete", required: {
                        allow: true, msj: "Campo requerido.", error: false
                    }
                }, type_param: {
                    id: "type_param", name: "type_param", label: "Parametro", required: {
                        allow: true, msj: "Campo requerido.", error: false
                    }
                }, limit_one: {
                    id: "limit_one", name: "limit_one", label: "Limite", required: {
                        allow: true, msj: "Campo requerido.", error: false
                    }
                }, limit_two: {
                    id: "limit_two", name: "limit_two", label: "Limite", required: {
                        allow: true, msj: "Campo requerido.", error: false
                    }
                }, product_parent_by_prices_id_data: {
                    id: "product_parent_by_prices_id_data",
                    name: "product_parent_by_prices_id_data",
                    label: "Precio",
                    required: {
                        allow: true, msj: "Campo requerido.", error: false
                    }
                }

            };

            return result;
        },
        getAttributesForm: function () {
            var keyManager = this['processData'].name + '_data';
            var result = {

                [keyManager]: [],

            };
            return result;
        },
        getRowAttributePush: function (params) {
            var product_parent_by_prices_id_data_default = this.product_parent_by_prices_id_data_default;
            var keyManager = this.process_table + '_data';
            var priceNumber = this.model.attributes[keyManager].length + 1;
            var id = -1;
            var description = 'Paquete ';
            if (params.isCreate) {
                description = description + ' ' + priceNumber;
            }
            var result = {

                id: id,
                name: description,
                type_param: 0,
                limit_one: 1,
                limit_two: 0,
                product_parent_by_prices_id_data: product_parent_by_prices_id_data_default,
                product_parent_id: this.product_parent_id,

            };
            return result;
        },
        _setValueFormData: function (name, value, position = null, model = null) {

            if (name == 'type_param') {
                console.log(this.$v.model.attributes.product_parent_by_package_params_data.$each.$iter[position]['limit_two'])

                if (value == this.typeParamsData.GREATER_AND_LESS_THAN) {
                    //    this.$v.model.attributes.product_parent_by_package_params_data.$each.$iter[position]['limit_two'].required = false;

                } else {
                    this.$v.model.attributes.product_parent_by_package_params_data.$each.$iter[position]['limit_two'].$model = 0;
                }

                console.log(this.$v.model.attributes.product_parent_by_package_params_data.$each.$iter[position]['limit_two'])


            }
            model["$model"] = value;
            model.$touch();
            this.onChangeRowSave({
                name: name,
                value: value,
                position: position,
                model: model,

            });
        },
        getDataRowByIndexSave: function (params) {
            var position = params.index;
            var dataManagerAux = JSON.parse(this.dataManagerAux);
            var keyView = this.process_table + '_data';
            var haystack = this.$v.model.attributes[keyView].$each.$iter;
            var needle = haystack[position];
            var elementsCurrentValidate = needle['$model'];
            var isValidAll = true;
            return {
                setPush: elementsCurrentValidate,
                needle: needle,
                haystack: haystack,
                dataManagerAux: dataManagerAux
            };
        },
        onChangeRowSave: function (params) {
            const _this = this;
            const managerRowData = this.getDataRowByIndexSave({
                index: params.position
            });
            var name = params.name;
            var value = params.value;
            var position = params.position;
            var model = params.model;
            var dataManagerAux = managerRowData.dataManagerAux;
            var keyView = this.process_table + '_data';
            var haystack = managerRowData.haystack;
            var needle = managerRowData.needle;
            var elementsCurrentValidate = needle['$model'];
            var isValidAll = true;
            var setPush = {};
            $.each(elementsCurrentValidate, function (key, value) {
                var keyCurrent = key;
                if ('product_parent_by_prices_id' == key) {
                    keyCurrent = key + "_data";
                }
                $invalid = needle[keyCurrent].$invalid;
                if ($invalid) {
                    isValidAll = false;
                }
            });
            if (isValidAll) {
                setPush = elementsCurrentValidate;
                this.dataManagerSave(
                    {
                        index: position,
                        isCreate: false,
                        setPush: setPush,
                    }
                );
            } else {
                setPush = dataManagerAux[position];
                $.each(setPush, function (key, value) {
                    _this.$v.model.attributes[keyView].$each.$iter[position][key].$model = value;
                });
            }

        },
        setManagerToSave: function (params) {
            var setPush = params['setPush'];
            var keyManager = this.process_table + '_data';
            if (params.type == 'onUpdateData') {

            } else {
                this.model.attributes[keyManager].push(setPush);

            }
            this.onSendEventsParent({
                'type': params['type'],
                'process': this.process_table,
                'data': {
                    rows: this.model.attributes[keyManager],
                    managerInformation: this.managerInformation

                }
            });
        },
        dataManagerSave: function (params) {
            var _this = this;
            var setPush = params.setPush;
            var isCreate = params.isCreate;
            var blockElement = '#modal-delete-' + this.process_table;
            if (!isCreate) {
                blockElement = '#id-manager-'+ this.process_table +"-"+ params.index;
            }

            var urlCurrent = $('#action-' + this.process_table + '-saveData').val();
            var dataSend = setPush;
            var loading_message = isCreate ? 'Registrando...' : 'Actualizando.....';
            var error_message = 'Error al guardar.!';
            var success_message = isCreate ? 'Datos guardados con exito!' : 'Datos actualizados con exito!';
            ajaxRequest(urlCurrent, {
                type: 'POST',
                data: dataSend,
                blockElement: blockElement,
                loading_message: loading_message,
                error_message: error_message,
                success_message: success_message,
                success_callback: function (response) {
                    var dataCurrent = response;//
                    if (dataCurrent.success) {
                        var type = 'onAddData';
                        if (isCreate) {
                            setPush['id'] = dataCurrent['data']['ProductParentByPackageParams']['id'];
                        } else {
                            type = 'onUpdateData';
                        }
                        _this.setManagerToSave({
                            type: type,
                            setPush: setPush,
                            'ProductParentByPackageParams': dataCurrent['data']['ProductParentByPackageParams']
                        });

                    } else {

                    }
                },
                errorCallback: function (response) {

                }
            });

        },
        onAddData: function () {
            var setPush = this.getRowAttributePush({isCreate: true});

            this.dataManagerSave(
                {
                    isCreate: true,
                    setPush: setPush,
                }
            );

        }, setDataModalDelete: function (params) {
            var _this = this;
            var valueCurrent = _this.managerCurrentDeleteData.value.$model;
            $(_this.managerModalConfig.selectorTitle).html("");
            var setHtmlCurrent = ['Paquete :  ' + valueCurrent.name];
            setHtmlCurrent = setHtmlCurrent.join('');
            $(_this.managerModalConfig.selectorTitle).html(setHtmlCurrent);
            setHtmlCurrent = ['<span class="message-information">Esta seguro que desea eliminar este registro , si es un paquete nuevo se realizara pero si existe registros con este paquete no se podra realizar.!</span> '];
            setHtmlCurrent = setHtmlCurrent.join('');
            $(_this.managerModalConfig.selectorBody).html(setHtmlCurrent);
            $(_this.managerModalConfig.selectorFooterDismiss).html('Cancelar');
            $(_this.managerModalConfig.selectorFooterRegister).html('Eliminar');

        },
        deleteManagerSave: function (params) {
            var _this = this;
            var setPush = params.setPush;
            var blockElement = '#' + this.process_table;
            var urlCurrent = $('#action-' + this.process_table + '-deleteData').val();
            var dataSend = setPush;
            var loading_message = 'Eliminando...';
            var error_message = 'Error al guardar.!';
            var success_message = 'Dato Eliminado con exito!';
            ajaxRequest(urlCurrent, {
                type: 'POST',
                data: dataSend,
                blockElement: blockElement,//opcional: es para bloquear el elemento
                loading_message: loading_message,
                error_message: error_message,
                success_message: success_message,
                success_callback: function (response) {
                    if (response.success) {
                        _this.deleteData(params);
                    }
                },
                errorCallback: function (response) {

                }
            });

        },
        onDeleteData: function (params) {
            this.managerCurrentDeleteData = params;
            this.setDataModalDelete(params);
            $(this.managerModalConfig.selector).modal('show');

        },
        deleteData: function (params) {
            var _this = this;
            var keyManager = this.process_table + '_data';
            _this.model.attributes[keyManager].splice(params.index, 1);
            $(_this.managerModalConfig.selector).modal('hide');
            _this.onSendEventsParent({
                'type': 'onDeleteData', 'process': _this.process_table, 'data': {
                    rows: _this.model.attributes[keyManager],
                    managerInformation: _this.managerInformation
                }
            });
        },
        onModalEvents: function () {
            var _this = this;
            $(this.managerModalConfig.selector).on('shown.bs.modal', function () {

                $(_this.managerModalConfig.selectorFooterRegister).on('click', function () {
                    var params = _this.managerCurrentDeleteData;
                    var managerRowData = _this.getDataRowByIndexSave({
                        index: params.index
                    });
                    params.setPush = managerRowData.setPush;
                    _this.deleteManagerSave(params);
                });

            });
            $(this.managerModalConfig.selector).on('hidden.bs.modal', function () {
                console.log('Modal cerrado');
                $(_this.managerModalConfig.selectorFooterRegister).off('click');
            });
        },
        onSendEventsParent: function (params) {

            this.$emit('on-send-events-by-component-to-parent', params);
        }
    }

});
