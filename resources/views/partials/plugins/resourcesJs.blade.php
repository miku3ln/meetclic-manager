<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>

<?php
$url_path_plugins = "libs/";

?>
@if(isset($bootgrid))
    {{-- BOOTGRID--}}
    <script src="{{ asset($resourcePathServer.$url_path_plugins.'bootgrid1.3.1/bootgrid1.3.1.min.js')}}"></script>

@elseif(isset($googleMaps))

    <!-------GOOGLE-------------->
    <script
        src="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}"></script>
    <script
        src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>

@elseif(isset($geoxml3))
    <script src="{{ asset($resourcePathServer.'libs/geoxml3/geoxml3.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/blitz-gmap-editor/blitz-gmap-editor.min.js')}}"></script>
@elseif(isset($threeJs))
    <script src="{{ asset($resourcePathServer.'libs/threejs/three.min.js')}}"></script>
    {{-- <script src="{{ asset($resourcePathServer.'libs/threejs/modules/controls/DeviceOrientationControls.js')}}"></script>--}}
    <script src="{{ asset($resourcePathServer.'libs/threejs/modules/controls/DragControls.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/threejs/modules/controls/EditorControls.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/threejs/modules/controls/FirstPersonControls.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/threejs/modules/controls/FlyControls.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/threejs/modules/controls/MapControls.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/threejs/modules/controls/OrbitControls.js')}}"></script>
    <script
        src="{{ asset($resourcePathServer.'libs/threejs/modules/controls/OrthographicTrackballControls.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/threejs/modules/controls/PointerLockControls.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/threejs/modules/controls/TrackballControls.js')}}"></script>
@elseif(isset($highcharts))
    <script src="{{ asset($resourcePathServer.'libs/highcharts/highcharts.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/pdfmaker/pdfmake.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/pdfmaker/vfs_fonts.js')}}"></script>
@elseif(isset($sweetAlert))
    <script src="{{ asset($resourcePathServer.'libs/sweetalert/sweetalert.min.js')}}"></script>

@elseif(isset($croppie))
    <script src="{{ asset($resourcePathServer.'libs/croppie/croppie.js')}}"></script>
@elseif(isset($axios))
    <script src="{{ asset($resourcePathServer.'libs/vue/axios/axios.min.js')}}"></script>

@elseif(isset($select2))
    <script src="{{ URL::asset($resourcePathServer.'libs/jquery-select2/jquery-select2.min.js') }}"></script>

@elseif(isset($toast))
    <script src="{{ URL::asset($resourcePathServer.'libs/toast/jquery.toast.min.js') }}"
            type='text/javascript'></script>

@elseif(isset($blockUi))

    <script src="{{ URL::asset($resourcePathServer.'libs/blockui/blockui.min.js') }}"></script>

@elseif(isset($datepickerBootstrap))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"
            type="text/javascript"></script>
@elseif(isset($jqueryValidation))
    <script src="{{ URL::asset($resourcePathServer.'libs/jquery-validation/jquery-validation.min.js') }}"
            type="text/javascript"></script>
@elseif(isset($googleMaps))
    <script
        src="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}"></script>
@elseif(isset($dataGridVue))
    <script src="//cdn.rawgit.com/Sphinxxxx/vue-simple-datagrid/v1.0/src/vue-simple-datagrid.js"></script>

@elseif(isset($bootstrapColorpicker))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/js/bootstrap-colorpicker.min.js"></script>

@elseif(isset($summerNote))
    <script src="{{ asset('public/assets/libs/summernote/summernote.min.js')}}"></script>
@endif
