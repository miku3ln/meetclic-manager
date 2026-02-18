<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>
<script>
    var $configSentenceData = {}
    var $configSentenceMethods = {
        _managerS2Action: function (params) {
            var el = params.objSelector;

            function setValueConjugation(paramsConjugation) {
                var result = null;
                if (paramsConjugation.word.value == "") {
                    result = {
                        html: [

                            '<div class="empty-manager">',
                            '  <h2  class="empty-manager__title">No ha seleccionado un verbo.</h2>',
                            ' </div>',
                        ].join("")
                    };
                } else {
                    result = $.mcConjugate({
                        ...paramsConjugation,
                        timeType: ["PRESENTE", "FUTURO", "PASADO"]
                    });
                }
                $('.response-conjugation').html(result.html);
            }

            var dataCurrent = [];
            var _this = this;
            var elementInit = $(el).select2({
                dropdownParent: $('#mcPanel'),// tu offcanvas o modal
                allow: true,
                placeholder: "Busca en kichwa o en español el verbo.!",
                data: dataCurrent,
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action-getListS2DictionaryKichwaToCastilianAdmin").val(),
                    type: "get",
                    dataType: 'json',
                    data: function (term, page) {
                        var paramsFilters = {
                            term: term, page: page
                        };

                        return paramsFilters;
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    }
                },
                allowClear: true,
                multiple: false,
                width: '100%'
            });
            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                var translation_value_data = data.translation_value.split(",");
                var translation_value=translation_value_data[0];
                var word = {
                    translation_value: translation_value,
                    dictionary_grammatical_class_name: data.dictionary_grammatical_class_name,
                    value: data.value
                };
                setValueConjugation({word: word});

            }).on("select2:unselecting", function (e) {
                var word = {
                    translation_value: "",
                    dictionary_grammatical_class_name: "",
                    value: ""
                };
                setValueConjugation({word: word});
            });

        }
    }
    var $configNumberKichwaData = {
        modelChange: {value: "", type: "numeric"},
        isLoading: false,
        lastResponse: null
    };
    var $configNumberKichwaComputed = {
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
    }
    var $configNumberKichwaMethods = {
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
    var $configApuntesData = {
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
            attributes: {
                "id": null,
                "value": null,
                "description": null,
                "status": "ACTIVE",
                "diccionary_language_id": null,
                "letters_of_the_alphabet": null,

            },
            structure: {
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
            },
        },
        gridConfig: {
            selectorCurrent: "#dictionary_by_words-grid",
            url: $("#action-language_course_by_section-getAdmin").val()
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
        managerRow: {
            data: null,
            view: true
        },
    };
    var $configApuntesMethods = {
        getTypeDictionary: function () {
            var entity_manager_id = this.modelFilters.typeDictionary;
            return {
                dictionary_language_id: entity_manager_id
            };
        },
        getMenuConfig: getMenuConfig,
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
        initCurrentGridApuntesComponent: function (params) {
            this.initGridManager(this);
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;

            var structure = vmCurrent.model.structure;

            var formatters = {
                'value': function (column, row) {

                    var sourceCurrent = $publicAsset + row.source;
                    var imageCurrent = '<img  class=" content-description__photos--img-row" src="' + sourceCurrent + '" alt="">'


                    var result = [
                        "<table class='manager-information'>",
                        "<tbody>",
                        "     <tr class='manager-information__tr'>",
                        "          <td  class='manager-information__td-img'>",
                        imageCurrent,
                        "         </td>",
                        "       <td class='manager-information__td-information'>",

                        "        <div class='manager-information__td-information-title'>" + row.value + "</div> ",
                        "            <div class='manager-information__td-information-description'>" + row.description + "<div>",
                        "        </td>",
                        "     </tr>",
                        "</tbody>",
                        "</table>"];

                    return result.join("");
                }
            };
            var $scope = this;
            var paramsFilters = $scope.getTypeDictionary();
            var overWritePost = function (request) {
                var paramsFilters = $scope.getTypeDictionary();
                request.filters = paramsFilters;
                return request;
            };


            let gridInit = initGridManager({
                typeBS: "bs5",
                gridNameSelector: gridName,
                paramsFilters: paramsFilters,
                formatters: formatters,
                //templates:$templatesbs5Bootgrid,
                'urlCurrent': urlCurrent,
                'iconRefresh': 'bi bi-arrow-clockwise',
                'labels': {search: 'Buscar'},
                overWritePost: overWritePost

            });

            gridInit.on("loaded.rs.jquery.bootgrid", function () {
                vmCurrent._resetManagerGrid();
                vmCurrent._gridManager(gridInit);
                var fieldsViewObject = $('.actions.btn-group').find('.dropdown')[1];
                $(fieldsViewObject).hide();
                gridInit.find("tbody tr").on("click", function (e) {
                    console.log('click', this);
                    var dataRowId = $(this).attr('data-row-id');
                    var instance_data_rows = $(gridName).bootgrid("getCurrentRows");
                    var rowData = searchElementJson(instance_data_rows, 'id', dataRowId);//asi s obtiene los valores del registro en funcion d su id
                    var params = {id: dataRowId, rowData: rowData[0]};
                    vmCurrent.onClickRow(params);
                });

            });
        },
        onSetValuesForm: function (type, value) {
            $(this.gridConfig.selectorCurrent).bootgrid("reload");

        },
        onClickRow: function (params) {

            this.managerRow.data = null;
            this.managerRow.data = params.rowData;
            this.managerRow.view = false;
            if (!$("#btn-return-process").hasClass("not-view")) {

                $("#btn-return-process").addClass("not-view");
            }
            if (!$(".btn-close--canvas").hasClass("not-view")) {

                $(".btn-close--canvas").addClass("not-view");
            }

        },
        closeDataRow: function () {
            this.managerRow.data = null;
            this.managerRow.view = true;
            if ($("#btn-return-process").hasClass("not-view")) {

                $("#btn-return-process").removeClass("not-view");
            }

        },

        getUrlSource: function (params) {
            var sourceCurrent = $publicAsset + params.source;
            return sourceCurrent;
        }
    }
    var $courseManagementData = {
        hub: {
            "active_process": {
                data: null,
                key: null
            },
            search: "",
            activeTab: "person-conjugation",
            tabs: [
                {id: "person-conjugation", label: "Search", icon: "bi bi-search"},
                {id: "system-numeric", label: "History", icon: "bi bi-clock"},
                {id: "structure-morphemic", label: "Bookmarks", icon: "bi bi-bookmark"},
                {id: "exploration-themes", label: "Recent", icon: "bi bi-arrow-repeat"},
            ],

            // tus 6 botones (cards)
            cards: [
                {
                    id: "chaski-idioma",
                    title: "🌬 Wayra – La Voz Ancestral",
                    subtitle: "La historia, el canto y la fuerza sonora del Kichwa viven en el viento del Chasqui.",
                    icon: $resources.icons["chaski-idioma"],
                    tab: "chaski-idioma",
                    bookmarked: true,
                    dataView: ["Trabalenguas", "Canciones", "Nuestro Idioma (historia oral)"],
                },
                {
                    id: "chaski-apuntes",
                    title: "🌊 Yaku – El Flujo del Conocimiento",
                    subtitle: "Aprende la lengua paso a paso como el agua que forma su camino.",
                    icon: $resources.icons["chaski-apuntes"],
                    tab: "chaski-apuntes",
                    bookmarked: true, style: {
                        background: "#7BD3FF"
                    }
                },
                {
                    id: "chaski-diccionario",
                    title: "🌱 Allpa – Raíz de la Palabra",
                    subtitle: "Cada palabra nace de la tierra y guarda memoria ancestral.",
                    icon: $resources.icons["chaski-diccionario"],
                    tab: "chaski-diccionario",
                    bookmarked: true
                },

                {
                    id: "chaski-trabalenguas",
                    title: "🔥 Nina – Energía del Randi Randi",
                    subtitle: "El intercambio despierta comunidad y transforma el valor en energía.",
                    icon: $resources.icons["chaski-trabalenguas"],
                    tab: "chaski-trabalenguas",
                    bookmarked: true
                },


            ],

            onSearchInput: function () { /* opcional: debounce */
            }
        },
    };
    var $courseManagementToolsMethods = {
        refreshHubGrid: function () {
            this.hub.filteredCards = this.hubFilteredCards;
        },

        setHubTab: function (tabId) {
            this.hub.activeTab = tabId;
            this.refreshHubGrid();
        },

        openFilters: function () {
            // aquí puedes abrir tu offcanvas/modal de filtros
            console.log("openFilters()");
        },

        openCard: function (card) {
            // aquí decides qué pantalla abrir (offcanvas / route / modal)
            this.canvasManager.data.title = card.title;
            this.canvasManager.data.subtitle = "";

            console.log("openCard", card.id);
            this.hub.active_process.data = card;
            this.hub.active_process.key = card.id;
            if (!$(".btn-close--canvas").hasClass("not-view")) {

                $(".btn-close--canvas").addClass("not-view");
            }
        },
        returnMainProcess: function () {
            this.hub.active_process.key = null;
            this.hub.active_process.data = null;
            var titlesManager = this.getTitleMain();
            this.canvasManager.data = {
                ...titlesManager
            };

            if ($(".btn-close--canvas").hasClass("not-view")) {

                $(".btn-close--canvas").removeClass("not-view");
            }
        }
    }
</script>
