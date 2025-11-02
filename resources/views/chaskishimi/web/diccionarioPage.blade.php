{{-- NONE CMS-TEMPLATE --}}
@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

        $assetsRoot = $resourcePathServer . 'assets/chaskishimi/';

@endphp
@extends('layouts.chaskishimi')
@section('additional-styles')
    <style>
        .pagination > .active > a {
            color: #e4e4e4;
            background-color: #f08124 !important;
            border-color: #f08124 !important;
        }

        .section--full-img {
            padding: 0 0;
        }

        h1.title {
            float: left;
            width: 100%;
            text-align: center;
            color: #4db7fe;
            font-size: 34px;
            font-weight: 700;
        }

        img.img-svg-full {
            width: 88%;
        }


        .btn-sm {
            padding: 5px 10px !important;
            font-size: 12px !important;;
            line-height: 1.5 !important;;
            border-radius: 3px !important;;
        }

        img.content-description__photos--img {
            height: 140px;
            width: 140px;
        }

        .content-description {
            padding-top: 9px;
            padding-bottom: 9px;
        }

        .btn {
            color: #f08124 !important;
        }

        .text-left {

            font-size: 26px;
            text-align: left;
        }

        .text-left a {
            color: #4d4c4c !important;
        }

        .form-group {
            text-align: left;

        }

        select#typeDictionary {
            font-size: 21px;
        }

        label.form__label {
            color: #225278;
            font-size: 24px;
        }

        .bootgrid-footer--fixed {
            padding-right: 7% !important;
            padding-left: 6% !important;
            width: 80%;
            position: fixed;
            top: 77%;
        }

        ul.pagination li {
            cursor: pointer;
        }

        a {

            text-decoration: none !important;
        }

        .content-description__information {
            /* display: flex; /* Hace que los elementos hijos se muestren en línea horizontalmente */
            align-items: center; /* Alinea los elementos verticalmente */
        }

        .content-description__title {
            margin-right: 10px; /* Espacio entre el título y el contenido */
        }

        .word--description {
            /*  display: flex; /* Para que el contenido dentro también se muestre en línea horizontal */
            align-items: center; /* Alinea el contenido verticalmente */
        }

        .word--fonetic {
            margin-right: 5px; /* Espacio entre el fonético y el texto */
        }

        .word--description p {
            margin: 0; /* Elimina el margen predeterminado del párrafo */
        }

        span.content-description__title {
            color: #4d4c4c;
            font-size: 22px;
            font-weight: bold;
        }

        span.word--fonetic {
            color: #f08124;
        }

        input.search-field.form-control {
            height: calc(1.5em + 2.75rem + 2px);
            /* width: 100%; */
        }

        .search {
            width: 45% !important;;
        }

        .container--manager-dictionary {

            width: 100%;
            padding: 0 10% 0 10%;
            position: relative;
            z-index: 5;
        }

        .custom-scroll-admin-grid {
            height: 450px;
            overflow-y: scroll;
            overflow-x: hidden;
        }

        .input-group-addon {
            font-size: 26px !important;
            color: #fff !important;;
            background-color: #f08124 !important;
            border: 0 solid #f08124 !important;;
            border-radius: 0 !important;;
        }

        @media screen and (min-width: 300px) and (max-width: 768px) {
            .table-responsive {

                border: 0 solid #ddd !important;
                overflow-y: unset !important;
            }

            .search {
                width: 100% !important;
            }

            .bootgrid-footer .search, .bootgrid-header .search {
                margin: 0 20px 13px 0 !important;
            }

            .intro-item.fl-wrap {
                padding-top: 35% !important;
            }

            .infoBar {
                margin-top: 54px !important;
                padding-right: 0 !important;
                padding-left: 0 !important;
                position: initial !important;
            }

            .pagination a {
                width: 30px !important;
                height: 30px !important;
            }

            .hero-section .intro-item h2 {
                font-size: 54px !important;

            }


            span.content-description__title {

                font-size: 11px !important;

            }

            .word--description {
                display: block !important;
                align-items: center !important;
            }

            img.content-description__photos--img {
                height: 70px !important;
                width: 70px !important;
            }

            .content {
                height: auto !important;
            }
        }
        .word-card:hover {
            box-shadow: 0 -5px 2px rgb(240 129 36);
            transform: translateY(-4px);
        }

        /* Identificador visual */
        .word-card__header h2::before {
            content: "📘 ";
        }

        .word-card {
            background: #fff;
            border: 2px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            max-width: 100%;
            font-family: 'Segoe UI', sans-serif;
            margin: 20px auto;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        }

        .word-card__header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            border-bottom: 1px solid #e2e2e2;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .word-card__base {
            font-size: 32px;
            font-weight: bold;
            color: #2c3e50;
        }
        .word-card__translation {
            display: inline-block;
            margin-left: 12px;
            padding: 2px 8px;
            font-size: 23px;
            font-weight: 600;
            color: #2a2a2a;
            background-color: #f0f8ff; /* color suave */
            border-left: 4px solid #3b82f6; /* azul destacado */
            border-radius: 4px;
            transition: background-color 0.3s;

        }

        .word-card:hover .word-card__translation {
            background-color: #e0f2ff;
        }

        .word-card__section {
            margin-bottom: 18px;
        }

        .word-card__subtitle {
            font-size: 18px;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .word-card__list {
            list-style: none;
            padding-left: 0;
        }

        .word-card__item {
            padding: 6px 0;
            font-size: 15px;
            color: #2c3e50;
        }

        .word-card__phonetic {
            font-weight: 500;
            margin-right: 6px;
            color: #2980b9;
        }

        .word-card__notation {
            font-style: italic;
            color: #7f8c8d;
        }

        .word-card__text {
            color: #444;
            font-size: 15px;
            line-height: 1.6;
        }

        table#dictionary_by_words-grid {
            width: 100%;
        }
        /* Aplica SOLO al tbody */
        #dictionary_by_words-grid > tbody {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); /* 3 columnas en PC, 1 columna móvil */
            gap: 20px;
            padding: 20px;
        }

        /* Los tr deben "desaparecer" como filas */
        #dictionary_by_words-grid > tbody > tr {
            display: contents; /* Para que los <td> (las word-card) floten directamente como ítems del grid */
        }

        /* Aseguramos que el td se comporte como bloque libre */
        #dictionary_by_words-grid > tbody > tr > td {
            margin: 0;
            padding: 0;
        }
    </style>


    <link href="{{ asset($resourcePathServer."plugins/bootgrid-2024/bootstrap.css") }}" rel="stylesheet"
          type="text/css">
    <link href="{{ asset($resourcePathServer."plugins/bootgrid-2024/jquery.bootgrid.min.css") }}" rel="stylesheet"
          type="text/css">
@endsection
@section('additional-scripts')
    <script src="{{ asset($resourcePathServer."plugins/bootgrid-2024/bootstrap.min.js") }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer."plugins/bootgrid-2024/jquery.bootgrid.min.js") }}"
            type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.3/jquery.scrollTo.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function () {

            $('.header-search').show();
        })
    </script>
    <script>

        var $currentApp;
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
                        }
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
                        var gridName = this.gridConfig.selectorCurrent;
                        var urlCurrent = this.gridConfig.url;
                        var $scope = this;
                        var structure = vmCurrent.model.structure;

                        var formatters = {
                            'value': function (column, row) {

                                var classStatus = "badge-success";
                                if (row.status == "INACTIVE") {
                                    classStatus = "badge-warning"
                                }
                                var photosData = [];
                                if (row.photos) {
                                    photosData.push("<div class='content-description__photos'>");
                                    $.each(row.photos, function (i, v) {
                                        var sourceCurrent = $publicAsset + v.source;
                                        var photoCurrent = [

                                            '<img  class=" content-description__photos--img" src="' + sourceCurrent + '" alt="">'

                                        ];
                                        photosData.push(photoCurrent.join(""));
                                    });

                                    photosData.push("</div>");

                                }

                                var audioData = [];
                                var allowPlayMain = false;
                                var idPlayMain = false;
                                var playStructure = [];
                                if (row.audios) {
                                    audioData.push("<div class='content-description__audios'>");
                                    var countMain = 0;
                                    $.each(row.audios, function (i, v) {
                                        if (countMain == 0) {

                                            allowPlayMain = true;
                                            playStructure = [
                                                '  <a  class="btn btn-default btn-sm btn--manager-sound" audio-player="' + v.id + '">',
                                                ' <span class="glyphicon glyphicon-play"></span>',
                                                'Play ', '</a>'
                                            ];
                                        }
                                        var sourceCurrent = $publicAsset + v.source;
                                        var setCurrent = [

                                            '<audio id="audioPlayer' + v.id + '" controls  class="not-view">',
                                            '<source src="' + sourceCurrent + '" type="audio/mpeg">',
                                            '</audio>',

                                        ];
                                        audioData.push(setCurrent.join(""));
                                        countMain++;
                                    });

                                    audioData.push("</div>");

                                }

                                let itemsExamples = [];
                                let languageRoot = "";
                                let languageTo = "";
                                const resultado = $scope.dataTypeDictionary.find(item => item.id === $scope.modelFilters.typeDictionary);
                                const languages = resultado["text"].split("-");
                                languageRoot = languages[0];
                                languageTo = languages[1];

                                console.log("resultado", resultado)
                                $.each(row.examples, function (i, v) {
                                    var value = v.value;
                                    var description = v.description;
                                    var setValue = [

                                        '      <li class="word-card__item">',
                                        '        <strong>' + languageRoot + ':</strong> ' + value + '.<br/>',
                                        '        <strong>' + languageTo + ':</strong> ' + description,
                                        '      </li>',
                                    ];
                                    itemsExamples.push(setValue.join(""));
                                });
                                let exampleData = itemsExamples.length > 0 ? [
                                    '  <div class="word-card__section word-card__section--examples">',
                                    '    <h3 class="word-card__subtitle"><i class="glyphicon glyphicon-comment"></i> Ejemplos</h3>',
                                    '    <ul class="word-card__list">',
                                    itemsExamples.join(""),
                                    '    </ul>',
                                    '  </div>'

                                ] : [];

                                let itemsPhonetic = [];
                                $.each(row.pronunciations, function (i, v) {
                                    var phoneticValue = v.phonetic_value;
                                    var notationType = v.notation_type;
                                    var setValue = [

                                        '      <li class="word-card__item">',
                                        '        <span class="word-card__phonetic">' + phoneticValue + '</span>',
                                        '        <span class="word-card__notation">(' + notationType + ')</span>',
                                        '      </li>',
                                    ];
                                    itemsPhonetic.push(setValue.join(""));
                                });
                                let itemsGrammaticalClass = [];
                                itemsGrammaticalClass.push([
                                    '      <li class="word-card__item">' + row.dictionary_grammatical_class_name + '</li>',
                                ]);

                                let phoneticData = itemsPhonetic.length > 0 ? [
                                    '  <div class="word-card__section word-card__section--pronunciations">',
                                    '    <h3 class="word-card__subtitle"><i class="glyphicon glyphicon-volume-up"></i> Pronuciación</h3>',
                                    '    <ul class="word-card__list">',
                                    itemsPhonetic.join(""),
                                    '    </ul>',
                                    '  </div>'

                                ] : [];


                                let grammaticalData = itemsGrammaticalClass.length > 0 ? [
                                    '  <div class="word-card__section word-card__section--grammar">',
                                    '    <h3 class="word-card__subtitle"><i class="glyphicon glyphicon-book"></i>Clases Gramaticales</h3>',
                                    '    <ul class="word-card__list">',
                                    itemsGrammaticalClass.join(""),
                                    '    </ul>',
                                    '  </div>'

                                ] : [];

                                var result = [
                                    '<div class="word-card">',
                                    '  <div class="word-card__header">',
                                    '    <h2 class="word-card__base">' + row.value + '</h2>',
                                    '    <span class="word-card__translation">' + row.translation_value + '</span>',
                                    '  </div>',

                                    phoneticData.join(""),

                                    grammaticalData.join(""),
                                    exampleData.join(""),
                                    '  <div class="word-card__section word-card__section--detail">',
                                    '    <h3 class="word-card__subtitle"><i class="glyphicon glyphicon-info-sign"></i>Detalles Adicionales</h3>',
                                    '    <p class="word-card__text">',
                                    row.description, " <br>" + row.usage_context,
                                    '    </p>',
                                    '  </div>',
                                    '</div>'
                                ];


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
                            gridNameSelector: gridName,
                            paramsFilters: paramsFilters,
                            formatters: formatters,
                            'urlCurrent': urlCurrent,
                            'iconRefresh': 'glyphicon glyphicon-refresh',
                            'labels': {search: 'Buscar'},
                            overWritePost: overWritePost

                        });

                        gridInit.on("loaded.rs.jquery.bootgrid", function () {
                            vmCurrent._resetManagerGrid();
                            vmCurrent._gridManager(gridInit);
                            var fieldsViewObject = $('.actions.btn-group').find('.dropdown')[1];
                            $(fieldsViewObject).hide();
                            $('.btn--manager-sound').off('click');

                            $('.btn--manager-sound').on('click', function () {
                                console.log('--------------------------------------');
                                var audioPlayerId = $(this).attr('audio-player');
                                var selectorCurrent = 'audioPlayer' + audioPlayerId;
                                var audio = document.getElementById(selectorCurrent);
                                audio.play();
                            });
                        });
                    },
                    onSetValuesForm: function (type, value) {
                        $(this.gridConfig.selectorCurrent).bootgrid("reload");

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
        </section>

    </div>
@endsection

