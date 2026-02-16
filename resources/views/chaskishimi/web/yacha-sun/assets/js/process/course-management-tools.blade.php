<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>
<script>
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
            console.log(params);
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
            const cssBs5Bootgrid = {
                actions: "actions btn-group",
                dropDownMenu: "dropdown btn-group",
                dropDownMenuText: "dropdown-text",
                dropDownMenuItems: "dropdown-menu dropdown-menu-end",
                dropDownItem: "dropdown-item",
                dropDownItemButton: "dropdown-item-button",
                dropDownItemCheckbox: "dropdown-item-checkbox",

                pagination: "pagination mb-0",
                paginationButton: "page-link",

                search: "search",
                searchField: "search-field form-control",

                infos: "infos",

                // icon system
                iconSearch: "bi bi-search",
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
            if(!  $("#btn-return-process").hasClass("not-view")){

            $("#btn-return-process").addClass("not-view");
            }
            if(!  $(".btn-close--canvas").hasClass("not-view")){

                $(".btn-close--canvas").addClass("not-view");
            }

        },
        closeDataRow: function () {
            this.managerRow.data = null;
            this.managerRow.view = true;
            if( $("#btn-return-process").hasClass("not-view")){

                $("#btn-return-process").removeClass("not-view");
            }
            if( $(".btn-close--canvas").hasClass("not-view")){

                $(".btn-close--canvas").removeClass("not-view");
            }
        },
        returnMainGridProcess: function () {
            this.closeDataRow();
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
                    title: "Nuestro Idioma",
                    subtitle: "El Chasqui transmite palabras vivas que unen corazón y Pachamama.",
                    icon: $resources.icons["chaski-idioma"],
                    tab: "chaski-idioma",
                    bookmarked: true
                },
                {
                    id: "chaski-apuntes",
                    title: "Apuntes del Chasqui",
                    subtitle: "Reflexiones que el Chasqui recoge en su caminar diario.",
                    icon: $resources.icons["chaski-apuntes"],
                    tab: "chaski-apuntes",
                    bookmarked: true
                },
                {
                    id: "chaski-diccionario",
                    title: "Diccionario Vivo",
                    subtitle: "El Chasqui siembra palabras que nacen de la Pachamama.",
                    icon: $resources.icons["chaski-diccionario"],
                    tab: "chaski-diccionario",
                    bookmarked: true
                },

                {
                    id: "chaski-trabalenguas",
                    title: "Trabalenguas",
                    subtitle: "El Chasqui fortalece su voz para llevar mensajes con claridad.",
                    icon: $resources.icons["chaski-trabalenguas"],
                    tab: "chaski-trabalenguas",
                    bookmarked: true
                },

                {
                    id: "chaski-canciones",
                    title: "Canciones",
                    subtitle: "El Chasqui armoniza su paso con el canto de la naturaleza.",
                    icon: $resources.icons["chaski-canciones"],
                    tab: "chaski-canciones",
                    bookmarked: true
                },
                {
                    id: "chaski-cosmovision",
                    title: "Cosmovisión y Yapitas",
                    subtitle: "El Chasqui comprende la energía del intercambio y el valor en comunidad.",
                    icon: $resources.icons["chaski-cosmovision"],
                    tab: "chaski-cosmovision",
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
            console.log("openCard", card.id);
            this.hub.active_process.data = card;
            this.hub.active_process.key = card.id;
            if( !$(".btn-close--canvas").hasClass("not-view")){

                $(".btn-close--canvas").addClass("not-view");
            }
        },
        returnMainProcess: function () {
            this.hub.active_process.key = null;
            this.hub.active_process.data = null;
            this.canvasManager.data.title="PRINCIPAL";


            if( $(".btn-close--canvas").hasClass("not-view")){

                $(".btn-close--canvas").removeClass("not-view");
            }
        }
    }
</script>
