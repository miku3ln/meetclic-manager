<?php
$url_path_plugins = "metronic/plugins/";
?>
<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
{{----- PLUGINS--}}
{{--BOOTGRID--}}
<script src="{{ asset($resourcePathServer.$url_path_plugins."bootgrid/js/jquery.bootgrid.js") }}" type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.$url_path_plugins."bootgrid/js/jquery.bootgrid.fa.js") }}" type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.$url_path_plugins."tooltip/js/tooltip.min.js") }}" type="text/javascript"></script>


{{--ALERTS--}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
{{--scripts GESTION--}}
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/Grids.js') }}" type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/_form.js') }}" type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/_formStep2.js') }}" type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/_wizard.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    var model_entity = "{{$model_entity}}";
    var name_manager = "{{$name_manager}}";
</script>
<!-- Maps -->
<script src="https://maps.google.com/maps/api/js?key=AIzaSyAy7FfEU_fOeVTrJKxENPLxAor4cL6_d88&libraries=places"></script>

<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase.js"></script>
<script src="{{ asset($resourcePathServer.'plugins/vue-fire/vuefire.js')}}"></script>

<script src="https://maps.google.com/maps/api/js?key=AIzaSyAy7FfEU_fOeVTrJKxENPLxAor4cL6_d88&libraries=places"></script>

{{--<!-- Add additional services you want to use -->--}}
{{--<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-auth.js"></script>--}}
{{--<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-database.js"></script>--}}
{{--<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-firestore.js"></script>--}}
{{--<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-messaging.js"></script>--}}
{{--<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-functions.js"></script>--}}

<!-- Comment out (or don't include) services you don't want to use -->
<!-- <script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-storage.js"></script> -->

<script type="text/javascript">
    var model_entity = "{{$model_entity}}";
    var name_manager = "{{$name_manager}}";

</script>

{{------RENDER FUNCTIONS----}}
<script type="text/x-template" id="businessManagament">
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">

                    <span class="m-portlet__head-icon">
<i class="m-menu__link-icon flaticon-map-location"></i>
                    </span>

                    <h3 class="m-portlet__head-text m--font-brand">
                        Administracion de Negocios
                    </h3>
                </div>
            </div>

            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <btn-create-component></btn-create-component>
                </ul>
            </div>

        </div>
        <div class="m-portlet__body">
            <business-table-component :business="business">

            </business-table-component>

            <div class="checkbox-wrapper" @click="check">
                <div :class="{ checkbox: true, checked: checked }"></div>
                <div class="title"></div>
            </div>
        </div>
    </div>
</script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'googleMaps.js') }}" type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'firebase.js') }}" type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'index.js') }}" type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'app.js') }}" type="text/javascript"></script>
