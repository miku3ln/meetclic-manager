{{-- NONE CMS-TEMPLATE --}}
@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

        $assetsRoot = $resourcePathServer . 'assets/chaskishimi/';

@endphp
@extends('layouts.chaskishimi')
@section('additional-styles')
    <style>
        :root {
            --primary-color: #445EF2;
            --secondary-color: #f08124;
            --third-color: #225278;
            --font-size: 16px;
        }
        .pagination > .active > a {
            color: #e4e4e4;
            background-color:var(--secondary-color)!important;
            border-color: var(--secondary-color) !important;
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
            color: var(--secondary-color) !important;
        }

        .text-left {

            font-size: 26px;
            text-align: left;
        }

        .text-left a {
            color:var(--third-color) !important;
            font-size: 28px;
            font-weight: bold;
        }

        .form-group {
            text-align: left;

        }

        select#typeDictionary {
            font-size: 21px;
        }

        label.form__label {
            color: var(--third-color) ;
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
            overflow-x: hidden !important;
        }

        .input-group-addon {
            font-size: 26px !important;
            color: #fff !important;
            background-color: var(--secondary-color) !important;
            border: 0 solid var(--secondary-color) !important;;
            border-radius: 0 !important;;
        }




        img.content-description__photos--img-row {
            margin-top: 69px;
            height: 90px;
            width: 100px;
        }

        .content-description__information-img {
            width: 8% !important;
        }

        .img-full {
            width: 70%;
        }


        .form-view-header {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1rem;
            border-bottom: 1px solid #dee2e6;
            border-top-left-radius: calc(.3rem - 1px);
            border-top-right-radius: calc(.3rem - 1px);
        }

        .form-view-title {
            margin-bottom: 0;
            line-height: 1.5;
        }

        .form-view-header .btn-close {
            padding: .5rem .5rem;
            margin: -.5rem -.5rem -.5rem auto;
        }

        .btn-close {
            box-sizing: content-box;
            width: 4em;
            height: 4em;
            padding: .25em .25em;
            color: #000;
            border: 0;
            border-radius: .25rem;
            opacity: .5;
        }

        span.btn-close__icon {
            color: var(--secondary-color);
            font-size: 35px;
            font-weight: bold;
        }

        .form-view-title {
            color: var(--secondary-color);
            font-weight: bold;
            font-size: 25px;
            margin-bottom: 0;
            line-height: 1.5;
        }


        .text-left {
            padding-bottom: 19px;

        }

        table#dictionary_by_words-grid {
            width: 100%;
        }
        table.manager-information {
            width: 100%;
        }
        tr.manager-information__tr {
            width: 100%;
        }
        .manager-information__td-information-title {
            font-size: 20px;
            font-weight: bold;
            color: #707070;
        }
        .manager-information__td-information-description {
            font-size: 14px;

            color: #8A8A8A;
        }
        td.manager-information__td-img {
            width: 9%;
        }
        td.manager-information__td-information {
            border-bottom: 2px solid #C8C8C8;
            padding-bottom: 1%;
        }
        @media screen and (min-width: 300px) and (max-width: 768px) {
            .table-responsive {

                border: 0 solid #ddd !important;
                overflow-y: unset !important;
            }

            .search{
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
            .manager-information__td-information-title {
                font-size: 14px;
            }
            .manager-information__td-information-description {
                font-size: 10px;

            }
            img.content-description__photos--img-row {
                margin-top: 28px;
            }
            .img-full {
                width: 100%;
            }
            .form-view-title {

                font-size: 18px;
            }
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
                            url: $("#action-language_course_by_section-getAdmin").val()
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
                        managerRow: {
                            data: null,
                            view: true
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
                            dictionary_language_id: entity_manager_id
                        };
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
                    },
                    closeDataRow: function () {
                        this.managerRow.data = null;
                        this.managerRow.view = true;

                    },
                    getUrlSource: function (params) {
                        var sourceCurrent = $publicAsset + params.source;
                        return sourceCurrent;
                    }
                }
            })
        ;

    </script>
@endsection
@section('content')

    <div id="app-management">

        <div class="manager-modal" v-if="!managerRow.view">
            <div class="form-view-content">
                <div class="form-view-header">
                    <h5 class="form-view-title"><?php echo '{{managerRow.data.value}}' ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            v-on:click="closeDataRow()"><span class="btn-close__icon">X</span></button>
                </div>
                <div class="form-view-body">
                    <div v-if="managerRow.data.type==0">
                        <section class="section--full-img">
                            <img class="img-full" v-bind:src="getUrlSource({source:managerRow.data.source})" alt="">

                        </section>
                    </div>
                </div>

            </div>

        </div>
        <input id="action-language_course_by_section-getAdmin" type="hidden"
               value="{{route('getApuntesAdmin',app()->getLocale())}}"/>
        <section id="sec2" v-show="managerRow.view">
            <div class="container--manager-dictionary">
                <div class="row not-view">
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
                                    <th data-column-id="value" data-formatter="value">Apuntes</th>

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

