

<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>

@section('content')
    <div id="app-management">
        @foreach ($actions as $key => $action)
            <input id="{{$key}}" type="hidden" value="{{action($action)}}"/>
        @endforeach
        <business-management-component :business="business">
        </business-management-component>

    </div>
    @include('partials.modal',[
     'title'=>'Crear '.$name_manager,
     'id'=>'modal',
     'action_buttons'=>[
         [
         'type'=>'submit',
         'form'=>$model_entity.'_form',
         'id'=>'btn_save',
         'label'=>'Guardar',
         'color'=>'btn-primary'
         ],
      ]
     ])
@endsection
@section('script')
    <script src="https://www.gstatic.com/firebasejs/5.0.4/firebase.js"></script>
    <script src="{{ asset($resourcePathServer.'plugins/vue-fire/vuefire.js')}}"></script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyAy7FfEU_fOeVTrJKxENPLxAor4cL6_d88&libraries=places"></script>
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
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/googleMaps.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/firebase.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/index.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/app.js') }}" type="text/javascript"></script>

@endsection


