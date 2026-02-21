{{-- NONE CMS-TEMPLATE --}}
@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

        $assetsRoot = $resourcePathServer . 'assets/chaskishimi/';

@endphp
@extends('layouts.chaskishimi')
@section('additional-styles')
    @include('utils.number-kichwa.assets.css.number-convert')
    @include('utils.dictionary.assets.css.config-grid-manager')

    <link href="{{ asset($resourcePathServer."plugins/bootgrid-2024/bootstrap.css") }}" rel="stylesheet"
          type="text/css">
    <link href="{{ asset($resourcePathServer."plugins/bootgrid-2024/jquery.bootgrid.min.css") }}" rel="stylesheet"
          type="text/css">
@endsection
@section('additional-scripts')
    @include('utils.dictionary.assets.js.config-grid-manager')
    <script src="{{ asset($resourcePathServer."plugins/bootgrid-2024/bootstrap.min.js") }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer."plugins/bootgrid-2024/jquery.bootgrid.min.js") }}"
            type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.3/jquery.scrollTo.min.js"></script>
    @include('utils.number-kichwa.assets.js.number-convert')
    <script>
        var servicePronuciation = null;


    </script>

    <script>
        var $dataManagerPage = <?php echo json_encode($dataManagerPage) ?>;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function () {

            $('.header-search').show();
        })
        var servicePronuciation = null;


    </script>
    <script>

        var $currentApp;
        var $dictionaryCountsNumbersManagement = $dataManagerPage.dictionaryCountsNumbersManagement;
        var $pronunciationPayManagement = $dataManagerPage.pronunciationPayManagement;
        var serviceConverLanguage = initConvertLanguage();
        var service = new DictionaryCountsNumbersService($dictionaryCountsNumbersManagement);
        const app = new Vue(
            {
                directives: {
                    'init-listing-items': {
                        mounted: function () {
                            componentThisLanguage = this;
                            this.initCurrentComponent();
                        },
                        inserted: function (el, binding, vnode, vm, arg) {
                            var paramsInput = binding.value;
                            var initMethod = paramsInput['initMethod'];
                            initMethod({
                                elementInit: el,
                                params: paramsInput
                            });
                        }
                    },


                },
                el: '#app-management',
                created: function () {
                    $currentApp = this;
                    var $scope = this;

                    $(function () {
                        $scope.initManagement();
                    });
                },
                computed: {
                    placeholderText: function () {
                        return (this.modelChange.type === "numeric")
                            ? "Ej: 235"
                            : "Ej: ishkay pachak kimsa chunka pichka";
                    },
                    cardTitleWord: function () {
                        console.log("cardTitleWord", this.lastResponse);
                        if (!this.lastResponse || !this.lastResponse.success) return "";
                        var d = this.lastResponse.data;

                        // si entró numeric -> mostrar palabra kichwa
                        if (d.input.type === "numeric") return d.result.kichwa_word;

                        // si entró kichwa -> mostrar la misma palabra
                        return d.result.number_value;
                    },
                    cardSubInfo: function () {
                        if (!this.lastResponse || !this.lastResponse.success) return "";
                        var d = this.lastResponse.data;

                        if (d.input.type === "numeric") return "resultado en kichwa";
                        return "resultado en número";
                    },
                    cardResultText: function () {
                        if (!this.lastResponse || !this.lastResponse.success) return "";
                        var d = this.lastResponse.data;

                        if (d.input.type === "numeric") return "Número: " + d.result.number_value;
                        return "Número: " + d.result.number_value;
                    },
                    pronunciations: function () {
                        if (!this.lastResponse || !this.lastResponse.success) return [];
                        return (this.lastResponse.data.pronunciations || []);
                    },
                    didacticText: function () {
                        if (!this.lastResponse || !this.lastResponse.success) return "";
                        return (this.lastResponse.data.didactic && this.lastResponse.data.didactic.explanation) ? this.lastResponse.data.didactic.explanation : "—";
                    },
                    didacticScopeText: function () {
                        if (!this.lastResponse || !this.lastResponse.success) return "";
                        var s = (this.lastResponse.data.didactic && this.lastResponse.data.didactic.scope) ? this.lastResponse.data.didactic.scope : null;
                        if (!s) return "—";
                        return s.title_es + " (" + s.code + ")";
                    }
                },
                mounted: function () {

                    this.initCurrentComponent();
                },
                data: function () {
                    return {
                        configModelEntity: {
                            "buttonsManagements": [
                                {
                                    "title": "Actualizar",
                                    "data-placement": "top",
                                    "i-class": " fas fa-pencil-alt",
                                    "managerType": "updateEntity"
                                }
                            ]
                        },
                        model: {
                            attributes: this.getAttributesForm(),
                            structure: this.getStructureForm(),
                        },
                        gridConfig: {
                            selectorCurrent: "#dictionary_by_words-grid",
                            url: $("#action-dictionary_by_words-getAdmin").val()
                        },
                        managerMenuConfig: {
                            view: false,
                            menuCurrent: [],
                            rowId: null
                        },
                        dataTypeDictionary: [{
                            id: 1, text: 'Kichwa - Castellano'
                        },
                            {
                                id: 2, text: 'Castellano - Kichwa'
                            }
                        ],
                        modelFilters: {
                            typeDictionary: 1
                        },
                        modelChange: {value: "", type: "numeric"},
                        isLoading: false,
                        lastResponse: null
                    };
                },
                methods: {
                    ...$methodsFormValid,
                    ...$shareManager,
                    getAttributesForm: function () {
                        var result = {
                            "id": null,
                            "value": null,
                            "description": null,
                            "status": "ACTIVE",
                            "diccionary_language_id": null,
                            "letters_of_the_alphabet": null,

                        };
                        return result;
                    },
                    getStructureForm: function () {
                        var result = {
                            value: {
                                id: "value",
                                name: "value",
                                label: "Palabra",
                                required: {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                                maxLength: {
                                    msj: "# Carecteres Excedidos a 150.",
                                },
                            },
                            description: {
                                id: "description",
                                name: "description",
                                label: "Palabra",
                                required: {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                                maxLength: {
                                    msj: "# Carecteres Excedidos a 150.",
                                },
                            },
                            status: {
                                id: "status",
                                name: "status",
                                label: "Estado",
                                required: {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                                maxLength: {
                                    msj: "# Carecteres Excedidos a 150.",
                                },
                            },
                            diccionary_language_id: {
                                id: "diccionary_language_id",
                                name: "diccionary_language_id",
                                label: "Estado",
                                required: {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                                maxLength: {
                                    msj: "# Carecteres Excedidos a 150.",
                                },
                            },
                            dictionary_language_text: {
                                id: "dictionary_language_text",
                                name: "dictionary_language_text",
                                label: "Diccionario Tipo",
                                required: {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                                maxLength: {
                                    msj: "# Carecteres Excedidos a 150.",
                                },
                            },
                        };
                        return result;
                    },
                    getMenuConfig: getMenuConfig,

                    initManagement: function () {
                    },
                    _element: function (e) {
                        console.log(e);
                    },
                    _resetManagerGrid: function () {
                        this.managerMenuConfig = {
                            view: false,
                            menuCurrent: [],
                            rowId: null
                        };
                    },
                    _gridManager: function (elementSelect) {
                        var vmCurrent = this;
                        var selectorGrid = vmCurrent.gridConfig.selectorCurrent;
                        _gridManagerRows({
                            thisCurrent: vmCurrent,
                            elementSelect: elementSelect,

                        });
                    },
                    initCurrentComponent: function () {

                        this.initGridManager(this);
                    },
                    getTypeDictionary: function () {
                        var entity_manager_id = this.modelFilters.typeDictionary;
                        return {
                            entity_manager_id: entity_manager_id
                        };
                    },
                    initGridManager: function (vmCurrent) {
                        var $scope = this;
                        var gridName = this.gridConfig.selectorCurrent;
                        var urlCurrent = this.gridConfig.url;
                        initGridManagementDictionary({
                            typeBS:"",
                            $scope: vmCurrent,
                            gridName: gridName,
                            urlCurrent: urlCurrent,
                            vmCurrent: vmCurrent
                        });
                    },
                    onSetValuesForm: function (type, value) {
                        $(this.gridConfig.selectorCurrent).bootgrid("reload");

                    },
                    setType: function (type) {
                        this.modelChange.type = type;
                        this.lastResponse = null; // limpia card al cambiar modo
                    },
                    onConvertNumbersKichwa: function () {
                        var value = String(this.modelChange.value || "").trim().toLowerCase();
                        if (!value) {
                            this.lastResponse = {
                                success: false,
                                message: "Ingresa un valor para convertir.",
                                data: null
                            };
                            return;
                        }

                        this.isLoading = true;

                        try {
                            // ✅ Contrato final: (string, "numeric" | "kichwa")
                            var resp = serviceConvertNumbers.convert(value, this.modelChange.type);
                            this.lastResponse = resp;
                        } catch (e) {
                            this.lastResponse = {
                                success: false,
                                message: (e && e.message) ? e.message : "Error inesperado.",
                                data: null
                            };
                        } finally {
                            this.isLoading = false;
                        }
                    }

                }
            })
        ;


    </script>
@endsection
@section('content')

    <div id="app-management">
        <input id="action-dictionary_by_words-getAdmin" type="hidden"
               value="{{route('getDictionaryKichwaToCastilianAdmin',app()->getLocale())}}"/>
        <section id="sec2">
            <div class="container--manager-dictionary">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form__label "
                            >
                                Diccionario
                            </label>

                            <div class="content-element-form">
                                <select
                                    v-model.trim="modelFilters.typeDictionary"
                                    id="typeDictionary"
                                    name="typeDictionary"
                                    class="form-control m-input form-select"
                                    @change="onSetValuesForm('typeDictionary', modelFilters.typeDictionary)"
                                >
                                    <option
                                        v-for="(row,index) in dataTypeDictionary"
                                        v-bind:value="row.id"><?php echo '{{row.text}}' ?>
                                    </option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="content-manager-grid">

                        <div class="custom-scroll-admin-grid table-responsive">
                            <table id="dictionary_by_words-grid"
                                   class=""

                            >
                                <thead>
                                <tr>
                                    <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                                    <th data-column-id="value" data-formatter="value">Palabras</th>

                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @include('utils.number-kichwa.assets.template')

        </section>

    </div>
@endsection

