<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@section('content')




    <div id="app-management">

        <div class="row content-manager-map">
            <div class="col-md-12">
                <div id="map">

                </div>
            </div>
        </div>

        <div class="row content-manager-panorama">
            <div class="col-md-12">
                <div id="content-panorama">
                    <panorama-component

                    ></panorama-component>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="row content-manager-schedules">
            <div class="col-md-12">
                HOla listo
            </div>
        </div>
        <div class="tooltip-view"></div>
    </div>
    <style>
        #map {

            height: 250px;

        }

        .business-data {
            display: none;
        }

        .modal-mask {
            position: fixed;
            z-index: 9998;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .5);
            display: table;
            transition: opacity .3s ease;
        }

        .modal-wrapper {
            display: table-cell;
            vertical-align: middle;
        }

        .modal-container {
            width: 98%;
            margin: 0px auto;
            padding: 20px 30px;
            background-color: #fff;
            border-radius: 2px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
            transition: all .3s ease;
            font-family: Helvetica, Arial, sans-serif;
        }

        .modal-header h3 {
            margin-top: 0;
            color: #42b983;
        }

        .modal-body {
            margin: 20px 0;
        }

        .modal-default-button {
            float: right;
        }

        /*
         * The following styles are auto-applied to elements with
         * transition="modal" when their visibility is toggled
         * by Vue.js.
         *
         * You can easily play with the modal transition by editing
         * these styles.
         */

        .modal-enter {
            opacity: 0;
        }

        .modal-leave-active {
            opacity: 0;
        }

        .modal-enter .modal-container,
        .modal-leave-active .modal-container {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }

        .not-view {
            display: none;
        }

        /*
        -------MANAGER-----*/
        label.label--schedule {
            width: 38%;
        }

        .remove--schedule-day {
            position: absolute;
            /* top: 66px; */
            right: 0px;
        }

        .info_details.price_infobox {
            margin-top: -306px;
        }

        div#container-data canvas {
            width: 100% !important;
            height: 100% !important;
        }

        div#container-data {
            height: 450px;
        }

        .tooltip-view {
            background-color: #fff;
            top: 0;
            left: 0;
            padding: 10px;
            opacity: 0;
            position: absolute;
            transform: translate3d(-50%, -100%, 0);
            transition: opacity .3s, transform .3s;
        }

        .tooltip-view.is-active {
            opacity: 1;
            transform: translate3d(-50%, calc(-100% - -20px), 0);

        }
    </style>
@endsection
@section('script')

    <script type="text/x-template" id="panorama-template">
        <div>


            <div class="container-data" nx-geometry id="container-data">


            </div>


        </div>
    </script>
    <script src="{{ asset($resourcePathServer.'plugins/threejs/three.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'plugins/TweenLite/TweenLite.js')}}"></script>

    <script src="{{ asset($resourcePathServer.'plugins/threejs/modules/controls/OrbitControls.js')}}"></script>

    <script type="text/javascript">
            <?php
            $name_manager = "wulpyView";
            ?>
        var model_entity = "{{$model_entity}}";
        var name_manager = "{{$name_manager}}";

    </script>
    <script type="text/javascript">

        var $dataBusiness = <?php echo json_encode($dataBusiness)?>;
        var $dataResourcesPanorama = <?php echo json_encode($dataResourcesPanorama)?>;

    </script>


    <script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/googleMaps.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/app.js') }}" type="text/javascript"></script>

@endsection
