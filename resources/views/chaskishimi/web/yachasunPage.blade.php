{{-- NONE CMS-TEMPLATE --}}
@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$assetsRoot = $resourcePathServer . 'assets/chaskishimi/';
$resources=[
    'header'=>URL::asset($assetsRoot.'yachasun/header.svg')
];
$url_path_plugins = "libs/";
@endphp
@extends('layouts.chaskishimi')
@section('additional-styles')
    <style>
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

        .manager-header {
            padding-top: 10px;
        }

        div#content-render-data-odontogram-inferior, div#content-render-data-odontogram-superior {
            width: 100%;
            /* height: 210px;*/
            height: 160px;

        }

        #svg {
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;
            border: solid 2px #ccc;
            width: 300px;
            height: 300px;
            float: left;
            margin-right: 10px;
            font: 1em source-sans-pro, Source Sans Pro, Helvetica, sans-serif;
        }

        .svg-full-width {
            width: 100%;

        }

        @media screen and (min-width: 300px) and (max-width: 768px) {
            .section--full-img {
                padding: 6% 0;
            }
            img.img-svg-full {
                width: 95%;
            }
            .img-svg-full-coming-soon {
                width: 70%;
                height: auto;
                padding-top: 0 !important;
                padding-bottom: 43%;
            }
            .content {
                height: auto !important;
            }
        }
    </style>
@endsection
@section('additional-scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.3/jquery.scrollTo.min.js"></script>
    <script src="{{ asset($resourcePathServer.$url_path_plugins."snap-svg/0-5-1/snap.svg-min.js") }}"
            type="text/javascript"></script>
    <script>

        var $resources = <?php echo json_encode($resources) ?>;

        var appThis = null;
        var appInit = new Vue(
            {

                mounted: function () {
                    this.initCurrentComponent();
                    appThis = this;
                    this.initSVGManager();
                },
                el: '#app-management',
                created: function () {

                },
                beforeMount: function () {
                    this.configParams = this.params;
                    var $scope = this;
                    $(window).resize(function () {
                        $scope.resizeSVG();
                    });

                },
                data: {
                    //MENU
                    levels: {
                        one: {
                            'title': 'Viento',
                            'subtitle': 'wayra',

                        },
                        two: {
                            'title': 'Agua',
                            'subtitle': 'yaku',

                        },
                        three: {
                            'title': 'Tierra',
                            'subtitle': 'allpa',

                        },
                        four: {
                            'title': 'Fuego',
                            'subtitle': 'nina',

                        },
                    },
                    managerHeader: {
                        data: null,
                        'selector': '#svg-full-width',
                        'manager-selector-container': '#section--full-img',
                        'source': $resources.header,

                    }

                },
                methods: {
                    initCurrentComponent: function () {

                    }, initManagement: function () {
                        console.log("init app");
                    },

                    initSVGManager: function () {

                        var elementCurrent = this.managerHeader.selector;
                        var selectorMain = Snap(elementCurrent);
                        var _this = this;
                        Snap.load(_this.managerHeader.source, function (f) {
                            selectorMain.append(f);
                        });
                    },
                    resizeSVG: function (params) {
                        adjustment();
                    }
                }
            })
        ;
        appInit.initManagement();

        function adjustment() {
            var contenedorAncho = document.getElementById("app-management").offsetWidth; // Obtener el ancho del contenedor
            var nuevoAncho = contenedorAncho * 0.96; // Reducir el ancho al 96% del ancho del contenedor
            var nuevoAlto = (nuevoAncho / 1840) * 750; // Calcular el nuevo alto manteniendo la proporción original

            // Asignar los nuevos valores de ancho y alto al elemento SVG
            document.getElementById("svg-full-width").setAttribute("width", nuevoAncho);
            document.getElementById("svg-full-width").setAttribute("height", nuevoAlto);
        }

        $(function () {
            var widthManager = $('#app-management').width() - 80;
            var contenedorAncho = document.getElementById("app-management").offsetWidth; // Obtener el ancho del contenedor
            var nuevoAncho = contenedorAncho * 0.96; // Reducir el ancho al 96% del ancho del contenedor
            var nuevoAlto = (nuevoAncho / 1840) * 750; // Calcular el nuevo alto manteniendo la proporción original

            $('#svg-full-width').attr('width', widthManager);
            $('#svg-full-width').attr('height', nuevoAlto);


            $('.header-search').show();
        })
    </script>
@endsection
@section('content')
    <div id="app-management">
        <section class="section--full-img" >
            <img class="img-svg-full" src="{{ URL::asset($assetsRoot.'yachasun/header.svg')}}" alt="">

        </section>

        <div class="manager-header"></div>
        <svg id="svg-full-width" width="150" height="850" class="not-view">

        </svg>
        <section class="section--full-img" id="arawi">
            <img class="img-svg-full-coming-soon" src="{{ URL::asset($assetsRoot.'/coming-soon.jpg')}}" alt="">

        </section>
        <section class="section-courses not-view">
            <div class="row">
                <div class="col-md-3"><?php echo '{{levels.one.title}}' ?></div>
                <div class="col-md-3"><?php echo '{{levels.two.title}}' ?></div>
                <div class="col-md-3"><?php echo '{{levels.three.title}}' ?></div>
                <div class="col-md-3"> <?php echo '{{levels.four.title}}' ?></div>

            </div>
        </section>
    </div>
@endsection

