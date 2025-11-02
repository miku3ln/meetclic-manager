<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$url_path_plugins = 'libs/';
$configPartial = $dataManagerPage['viewData']['configPartial'];
$partials = $configPartial['moduleMain'] . '.' . $configPartial['moduleFolder'] . '.partials';
$pathCurrent = $dataManagerPage['viewData']['pathCurrent'];
$user = $dataManagerPage['viewData']['user'];
$model_entit = $dataManagerPage['viewData']['model_entity'];
$dataRoute= $dataManagerPage['viewData']['dataRoute'];
$paramsUser= $dataManagerPage['viewData']['paramsUser'];

$name_manager = $dataManagerPage['viewData']['name_manager'];
$model_entity = $dataManagerPage['viewData']['model_entity'];
$dataBusiness = $dataManagerPage['viewData']['dataBusiness'];
$dataResourcesPanorama = $dataManagerPage['viewData']['dataResourcesPanorama'];
$wizards_route = $partials . ".assets.css.info";
$paramsWizard = [
    "model_entity" => $model_entity,
    "pathCurrent" => $pathCurrent,
    "user" => $user,
    "configPartial" => $configPartial,
    "dataBusiness" => $dataBusiness,
    'resourcePathServer' => $resourcePathServer
];
?>
@extends('layouts.chasqui')
@section('additional-styles')
@endsection
@section('additional-scripts')
    <script
        src="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}"></script>
    <script
        src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="{{ asset($resourcePathServer.'js/Utils.js') }}" type="text/javascript"></script>

    <script src="{{ asset($resourcePathServer.'plugins/vue-bootstrap/bootstrap-vue.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'plugins/vue-select/vue-select.js')}}"></script>
    <script type="text/javascript">

        var $dataBusiness = <?php echo json_encode($dataBusiness)?>;
        var $dataResourcesPanorama = <?php echo json_encode($dataResourcesPanorama)?>;
        var $dataRoute = <?php echo json_encode($dataRoute)?>;
        var $paramsUser = <?php echo json_encode($paramsUser)?>;
    </script>
    <script type="text/x-template" id="view-marker-information-template">

        <div>
            <panorama-component
                ref="_emitParentToPanorama"

            ></panorama-component>

        </div>

    </script>
    <script type="text/x-template" id="panorama-template">
        <div>

            <div class="tooltip-view"></div>
        </div>
    </script>


    <script type="text/x-template" id="view-information-template">
        <div>


            <div class="content-view-information-title">
                <div class="content-view-information-title__margin">
                    <h1><?php echo "{{title}}"?></h1>
                </div>
                <div class="adventure-types">
                    <adventure-type-component

                        :paramsData="configDataAdventureType"
                        ref="_emitParentToLegendInformation"

                    ></adventure-type-component>
                </div>
            </div>
            <div class="content-view-information-description">
                <div class="content-view-information-description__margin">

                    <div v-html="description"></div>
                </div>
            </div>
        </div>
    </script>
    <script type="text/x-template" id="routes-drawing-template">
        <div>
            <div class="content-routes-drawing" v-if="view">

                <div class="content-routes-drawing__carousel">
                    <b-carousel
                        id="carousel-1"
                        v-model="slide"
                        :interval="4000"
                        controls
                        indicators
                        background="#ababab"

                        style="text-shadow: 1px 1px 2px #333;"
                        @sliding-start="onSlideStart"
                        @sliding-end="onSlideEnd"
                    >
                        <!-- Text slides with image -->
                        <b-carousel-slide
                            caption="First slide"
                            text="Nulla vitae elit libero, a pharetra augue mollis interdum."
                            img-src="https://picsum.photos/1024/480/?image=52"
                        ></b-carousel-slide>

                        <!-- Slides with custom text -->
                        <b-carousel-slide img-src="https://picsum.photos/1024/480/?image=54">
                            <h1>Hello world!</h1>
                        </b-carousel-slide>

                        <!-- Slides with image only -->
                        <b-carousel-slide img-src="https://picsum.photos/1024/480/?image=58"></b-carousel-slide>

                        <!-- Slides with img slot -->
                        <!-- Note the classes .d-block and .img-fluid to prevent browser default image alignment -->
                        <b-carousel-slide>
                            <img
                                slot="img"
                                class="d-block img-fluid w-100"
                                width="1024"
                                height="480"
                                src="https://picsum.photos/1024/480/?image=55"
                                alt="image slot"
                            >
                        </b-carousel-slide>


                    </b-carousel>
                </div>

                <div class="content-routes-drawing__description">

                </div>
            </div>

        </div>
    </script>
    <script type="text/x-template" id="legend-information-template">
        <div>

            <div class="content-toolkit-data">
                <div class="content-toolkit-title"><h1> <?php echo "{{title}}"?></h1></div>
                <div class="content-toolkit-legend">
                    <div v-for="(legend, index)  in dataLegend">
                        <div class="content-legend-type">
                            <div class="content-legend-type__title">
                                <h2>
                                    <?php echo "{{legend.title}}"?>
                                </h2>
                            </div>

                            <table class="content-legend-type__tbl">

                                <tbody>

                                <tr v-for="(legendType, index)  in legend.data">
                                    <th v-bind:class="{'image--th':legendType.type==0,'icon--th':legendType.type==1}">
                                        <div class="content-legend" v-if="legendType.type==0">

                                            <i v-bind:class="legendType.icon" class="icon-legend inline"></i>

                                        </div>
                                        <div class="content-legend" v-if="legendType.type==1">

                                            <img
                                                class="inline img-legend"
                                                v-bind:src="legendType.icon">

                                        </div>
                                    </th>
                                    <th class="content-legend-type__tbl--title">
                                        <span class="title-legend "><?php echo "{{legendType.title}}" ?></span>

                                    </th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </script>
    <script type="text/x-template" id="adventure-type-template">
        <div>

            <div class="content-toolkit-data-adventure-type" v-if="allowView">
                <div class="content-toolkit-adventure-type-title"><h1> <?php echo "{{title}}"?></h1></div>
                <div class="content-toolkit-adventure-type-legend">

                    <div class="content-legend-adventure-type">

                        <table class="content-legend-adventure-type__tbl">

                            <tbody>
                            <tr v-for="(adventure, index)  in data">
                                <th v-for="(adventureCols, indexCol)  in adventure.data"
                                    class="content-image-adventure--th">

                                    <img class="image-adventure--th"
                                         v-bind:src="adventureCols.src">

                                    <span class="name-adventure--th"> <?php echo "{{adventureCols.adventure_adventure_type_text}}"?> </span>
                                </th>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </script>
    <script src="{{ asset($resourcePathServer.'plugins/threejs/three.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'plugins/TweenLite/TweenLite.js')}}"></script>

    <script src="{{ asset($resourcePathServer.'plugins/threejs/modules/controls/OrbitControls.js')}}"></script>

    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/Components/Configuration.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/Components/Panorama.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/Components/ContentViewInformation.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/Components/RoutesDrawing.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/Components/ViewMarkerInformation.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/Components/LegendInformation.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/Components/AdventureType.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/googleMaps.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/App.js') }}" type="text/javascript"></script>


@endsection
@section('content')

    <div id="app-management" class="wide-layout-map section-space">


        <div class="box-layout-map-container">
            <div class="google-map google-map--style-2" id="map"></div>
        </div>
        <div class="container">
            <div class="row">
                <view-information-component

                    :params-data="configDataInformation"
                    ref="_emitParentToViewInformation"

                ></view-information-component>
                <legend-information-component
                    :params-data="configDataLegend"
                    ref="_emitParentToLegendInformation"
                >
                </legend-information-component>

                <div class="preview-demo" id="container-data"

                >
                    <div class="content-close-btn">
                        <button type="button" aria-label="Close" class="close" v-on:click="_hideModal()">×</button>
                    </div>
                    <view-marker-information-component

                        :params-data="configDataViewMarkerInformation"
                        ref="_emitParentToViewMarkerInformation"

                    ></view-marker-information-component>


                </div>

                <routes-drawing-component
                    :params-data="configDataRoutesDrawing"
                    ref="_emitParentToRoutesDrawing"
                >
                </routes-drawing-component>

            </div>
        </div>

    </div>

    <link href="{{asset($resourcePathServer.'css/'.$pathCurrent.'/index.css')}}" rel="stylesheet"
          type="text/css">
    <style>

    </style>
@endsection
