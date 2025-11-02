@extends('layouts.cityBook')
<?php
//CMS-TEMPLATE-AUTHOR-SINGLE-ALL
$urlRoute = route('businessDetails', app()->getLocale());
$allowContact = false;


?>
@section('additional-styles')
    <style>


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
            color: #445ef2 !important;
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
            display: flex; /* Hace que los elementos hijos se muestren en línea horizontalmente */
            align-items: center; /* Alinea los elementos verticalmente */
        }

        .content-description__title {
            margin-right: 10px; /* Espacio entre el título y el contenido */
        }

        .word--description {
            display: flex; /* Para que el contenido dentro también se muestre en línea horizontal */
            align-items: center; /* Alinea el contenido verticalmente */
        }

        .word--fonetic {
            margin-right: 5px; /* Espacio entre el fonético y el texto */
        }

        .word--description p {
            margin: 0; /* Elimina el margen predeterminado del párrafo */
        }

        span.content-description__title {
            color: #445ef2;
            font-size: 22px;
            font-weight: bold;
        }

        span.word--fonetic {
            color: #e5bf4e;
        }

        input.search-field.form-control {
            height: calc(1.5em + 2.75rem + 2px);
            /* width: 100%; */
        }

        .search{
            width: 45% !important; ;
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
      @media screen and (min-width: 300px) and (max-width: 768px){
          .table-responsive {
              width: 100% !important;
              margin-bottom: 0px !important;
              overflow-y: unset !important;
          }
          .search.form-group {
              width: 100% !important;
          }
          .hero-section .intro-item h2 {
              font-size: 54px !important;

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
          .nav-button-wrap {

              margin-right: -27% !important;
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

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function () {

            $('.show-search-button').show();
        })

        $(document).ready(function () {
            $(window).scroll(function () {
                var scrollTop = $(window).scrollTop();
                $('.bootgrid-footer').removeClass('bootgrid-footer--fixed');
                if (scrollTop > 200) {
                    //  $('.bootgrid-footer').addClass('bootgrid-footer--fixed');
                } else {

                }
            });
        });
    </script>
    <script type="text/javascript" src="{{URL::asset($resourcePathServer.'libs/vue/pagination/index.js')}}"></script>
    <script>

        var $dataProcess =<?php echo json_encode($dataManagerPage['dataProcess']) ?>;
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
                    initGridManager: function (vmCurrent) {
                        var gridName = this.gridConfig.selectorCurrent;
                        var urlCurrent = this.gridConfig.url;
                        var entity_manager_id = $dataProcess['dictionaryLanguageId'];
                        var paramsFilters = {

                            entity_manager_id: entity_manager_id


                        };
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


                                var result = [
                                    "<div class='content-description'>",
                                    "  <div class='content-description__information'>",
                                    "   <span class='content-description__title'>" + row.value + playStructure.join('') + ":</span>" + row.description + "",
                                    "  </div>",
                                    photosData.join(''),
                                    audioData.join(''),
                                    "</div>"];

                                return result.join("");
                            }
                        };

                        let gridInit = initGridManager({
                            gridNameSelector: gridName,
                            paramsFilters: paramsFilters,
                            formatters: formatters,
                            'urlCurrent': urlCurrent,
                            'iconRefresh': 'glyphicon glyphicon-refresh',
                            'labels': {}
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

                }
            })
        ;

    </script>

@endsection
@section('content-manager')

    <input id="action-dictionary_by_words-getAdmin" type="hidden"
           value="{{route('getDictionaryKichwaToCastilianAdmin',app()->getLocale())}}"/>
    <div class="content full-height fs-slider-wrap">
        <!--section -->
        <section class="hero-section no-dadding full-height {{"hero-section--item" }}" id="sec1">
            <div class="slider-container-wrap full-height fs-slider fl-wrap">
                <div class="slider-container">


                    <div class="slider-item fl-wrap">
                        <div class="bg"
                             data-bg="{{$dataManagerPage['dataProcess']['backgroundData']['url']}}"></div>
                        <div class="overlay"></div>
                        <div class="hero-section-wrap fl-wrap">
                            <div class="container">
                                <div class="intro-item fl-wrap">
                                    <h2 class="intro-item__title"> {{$dataManagerPage['dataProcess']['backgroundData']['title']}} </h2>
                                    <h3 class="intro-item__subtitle "> {{$dataManagerPage['dataProcess']['backgroundData']['subtitle']}} </h3>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
                @if(false)
                    <div class="swiper-button-prev sw-btn"><i class="fa fa-long-arrow-left"></i></div>
                    <div class="swiper-button-next sw-btn"><i class="fa fa-long-arrow-right"></i></div>
                @endif
            </div>
            <div class="header-sec-link">
                <div class="container">
                    <a href="#sec2" class="custom-scroll-link">{{__('page.initSection.button')}}</a>
                </div>
            </div>
        </section>

    </div>

@endsection

@section('content')
    <div id="app-management">
        <section id="sec2">
            <div class="container--manager-dictionary">
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
