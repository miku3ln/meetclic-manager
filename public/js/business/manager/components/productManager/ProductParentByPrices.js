//BUSINESS-MANAGER-COMPONENT-JS--ProductParentByPrices

Vue.component('product_parent_by_prices-component', {

    components: {}, template: '#product_parent_by_prices-template', directives: {},
    props: {
        params: {
            type: Object,
        },
        'processData': {
            type: Object,
        },
    }, created: function () {
        var dataCurrent = this.params.managerSteps.two.body.tabs.one.table.data;
        this.dataManager = dataCurrent;
        this.dataManagerAux = JSON.stringify(dataCurrent);
        var keyCurrentProcess = this.process_table + '_data';
        this.model.attributes[keyCurrentProcess] = dataCurrent;
        this.product_parent_id = this.params.managerSteps.process.parent_id;
        this.initEmmitFromComponents();
        componentThisPrices = this;
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
                    }, price: {
                        required
                    }, priority: {
                        required
                    }, utility: {
                        required,
                    }, type_price: {}, measurement_type: {}, manager_equivalence_id: {
                        required
                    }, type_of_income: {
                        required
                    }, description: {
                        required
                    }, product_parent_id: {
                        required,
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
            product_parent_id: null,
            managerCurrentDeleteData: {},
            dataManager: [],
            dataManagerAux: '',
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            }, formConfig: {
                nameModel: "ProductParentByPrices"
            },
            managerModalConfig: {
                selector: '#modal-delete-product_parent_by_prices',
                selectorTitle: '.modal-delete-product_parent_by_prices__title',
                selectorBody: '.modal-delete-product_parent_by_prices__body',
                selectorFooterDismiss: '.modal-delete-product_parent_by_prices__btn-close',
                selectorFooterRegister: '.modal-delete-product_parent_by_prices__btn-accept',

            },
            process_table: 'product_parent_by_prices',
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
            console.log('Change data Prices', newValue);
    },
        {
            deep: true
        }
    )
        ;
    },
    getViewDataProcess: function () {
        var keyManager = this.process_table + '_data';
        var haystack = this.$v.model.attributes[keyManager].$each.$iter;
        return Object.keys(haystack).length > 0;
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

    },
    getStructureForm: function () {
        var result = {

            price: {
                id: "price", name: "price", label: "Precio", required: {
                    allow: true, msj: "Campo requerido.", error: false
                }
            }, priority: {
                id: "priority", name: "priority", label: "Prioridad", required: {
                    allow: true, msj: "Campo requerido.", error: false
                }
            }, utility: {
                id: "utility", name: "utility", label: "Utilidad", required: {
                    allow: true, msj: "Campo requerido.", error: false
                }
            }, type_price: {
                id: "type_price", name: "type_price", label: "Tipo de Precio", required: {
                    allow: false, msj: "Campo requerido.", error: false
                }
            }, measurement_type: {
                id: "measurement_type", name: "measurement_type", label: "Tipo de Medida Configurada", required: {
                    allow: false, msj: "Campo requerido.", error: false
                }
            }, manager_equivalence_id: {
                id: "manager_equivalence_id", name: "manager_equivalence_id", label: "Equivalencia", required: {
                    allow: false, msj: "Campo requerido.", error: false
                }
            }, type_of_income: {
                id: "type_of_income", name: "type_of_income", label: "Tipo de Ingreso", required: {
                    allow: false, msj: "Campo requerido.", error: false
                }
            }, description: {
                id: "description", name: "description", label: "Nombre", required: {
                    allow: true, msj: "Campo requerido.", error: false
                }
            }, product_parent_id: {
                id: "product_parent_id", name: "product_parent_id", label: "Producto Parent", required: {
                    allow: false, msj: "Campo requerido.", error: false
                }
            },

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
    getNewName: function (params) {
        for (var i = 0; i < haystack.length; i++) {
            var newName = this.getNewName(haystack[i].description);

        }

        // Si el nombre no está en el conjunto de nombres, devolverlo
        if (namesSetData.indexOf(name) === -1) {
            return name;
        } else {
            // Si el nombre ya está presente, obtener su frecuencia y devolverlo con la frecuencia incrementada en uno
            var frequency = 1;
            while (namesSetData.indexOf(name + ' ' + frequency) !== -1) {
                frequency++;
            }
            return name + ' ' + frequency;
        }
    },
    managerPushData: function (params) {
        var namesSetData = ['Precio General', 'Precio por Mayor', 'Precio por Docena'];
        var keyManager = this.process_table + '_data';

        var haystack = this.model.attributes[keyManager];
        var isCreate = params.isCreate;
        var foundValue = '';
        var newElement = null; // Variable para almacenar el nuevo elemento
        var repetitionCount = 1; // Contador de repeticiones

// Recorremos los elementos de namesSetData
        var nothingIs = false;
        var newData = false;
        var countAll = 0;
        var countAllData = [];


        for (var i = 0; i < namesSetData.length; i++) {
            var name = namesSetData[i];
            // Verificamos si el nombre está presente en haystack
            var found = haystack.find(function (item) {
                return item.description === name;
            });

            if (!found) {
                // Si no se encuentra en haystack, almacenamos el nombre y terminamos el ciclo
                newElement = name;
                newData = true;
                break;
            } else {

            }

        }
        if (newData) {
            foundValue=newElement;
        }
        else {

// Array para almacenar los nombres y sus contadores
            var resultArray = [];

// Iterar sobre cada nombre en namesSetData
            namesSetData.forEach(function (name) {
                // Verificar cuántas veces aparece el nombre en haystack
                var regex = new RegExp("\\b" + name + "\\b", "gi"); // Expresión regular para buscar el nombre
                var count = 0;
                haystack.forEach(function (item) {
                    if (item.description.match(regex)) {
                        count++;
                    }
                });
                // Crear un objeto con el nombre y su contador
                var entry = { name: name, count: count };
                // Agregar el objeto al array de resultados
                resultArray.push(entry);
            });


            var randomNumber = Math.random();
            var min=0;
            var max=namesSetData.length;
            // Escala y desplaza el número aleatorio para que esté dentro del rango deseado
            var scaledNumber = Math.floor(randomNumber * (max - min) + min);
            // Devuelve el número aleatorio dentro del rango especificado
            foundValue= resultArray[scaledNumber].name+" "+resultArray[scaledNumber].count;
        }

        return foundValue;

    },
    getRowAttributePush: function (params) {
        var keyManager = this.process_table + '_data';
        var id = this.model.attributes[keyManager].length + 1;
        var setPushParams = params;
        var description = this.managerPushData(setPushParams);

        var result = {

            id: -1,
            price: 1,
            priority: 1,
            utility: 1,
            type_price: 0,
            measurement_type: 0,
            manager_equivalence_id: 1,
            type_of_income: 0,
            description: description,
            product_parent_id: this.product_parent_id,

        };
        return result;
    },
    getNameAttributeData: function (index, name) {
        var result = this.formConfig.nameModel + "[" + index + "][" + name + "]";
        return result;
    }, _setValueFormData: function (name, value, position = null, model = null) {

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
            $invalid = needle[key].$invalid;
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
            blockElement = '#id-manager-' + this.process_table + "-" + params.index;

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
                        setPush['id'] = dataCurrent['data']['ProductParentByPrices']['id'];
                    } else {
                        type = 'onUpdateData';
                    }
                    _this.setManagerToSave({
                        type: type,
                        setPush: setPush,
                        'ProductParentByPrices': dataCurrent['data']['ProductParentByPrices']
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
        var setHtmlCurrent = ['Precio ' + valueCurrent.description];
        setHtmlCurrent = setHtmlCurrent.join('');
        $(_this.managerModalConfig.selectorTitle).html(setHtmlCurrent);
        setHtmlCurrent = ['<span class="message-information">Esta seguro que desea eliminar este registro , si es un precio nuevo se realizara pero si existe registros con este precio no se podra realizar.!</span> '];
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

        this.$emit('on-send-events-by-component-to-parent', params);//BUSINESS-MANAGER-COMPONENT-JS-SEND-PARENT-DATA--ProductParentByPrices
    }
}

})
;
