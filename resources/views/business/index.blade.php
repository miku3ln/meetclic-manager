<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';

?>
@php
    $managerOptions=[
    'pageTitle'=>'Administracion',
             'menuParentName'=>'Administracion',
           'menuName'=>'Empresas',
                      'menuName'=>'Empresas',
'title'=>'Empresas',
 'icon'=>'<i class="flaticon-cogwheel-2"></i>',
    'id_table'=>'user_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newRegister()',
        'color'=>'btn-primary'
        ],
      ],
      'modal'=>[
    'title'=>'Crear Usuario',
    'id'=>'modal',
    'size'=>'modal-lg',
    'action_buttons'=>[
        [
        'id'=>'btn_save',
        'label'=>'Guardar',
        'handler_js'=>'saveUser()',
        'color'=>'btn-primary'
        ],
     ]
    ]
   ];
@endphp
@extends('layouts.masterMinton')

@section('breadcrumb')
    @include('partials.breadcrumb',$managerOptions)
@endsection

@section('headerMenuManagerLeft')
    <li class="dropdown d-none d-lg-block">
        <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button"
           aria-haspopup="false" aria-expanded="false">
            Gestion
            <i class="mdi mdi-chevron-down"></i>
        </a>
        <div class="dropdown-menu">
            <!-- item-->
            <a href="javascript:{{$managerOptions['action_buttons'][0]['handler_js']}}" class="dropdown-item">
                <i class="fas fa-pen-alt"></i>
                <span>Creacion</span>
            </a>

        </div>
    </li>
@endsection
@section('content')
    <div id="app-management">
        <input id="action_get_form" type="hidden" value="{{action("Business\BusinessController@getFormBusiness")}}"/>
        <input id="action_load_businesss" type="hidden"
               value="{{action("Business\BusinessController@getListBusiness")}}"/>
        <input id="action_save_business" type="hidden" value="{{action("Business\BusinessController@saveFB")}}"/>
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
    <script src="{{ asset($resourcePathServer.'libs//vue-fire/vuefire.js')}}"></script>
    <script src="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}"></script>

    <script type="text/javascript">
        var model_entity = "{{$model_entity}}";
        var name_manager = "{{$name_manager}}";


    </script>

    {{------RENDER FUNCTIONS----}}
    <script type="text/x-template" id="businessManagament">
        <div>
            <div class="manager-business">

                <table style="width:100%">

                    <tr v-for="row in business" :info="row">
                        <td> <?php echo "{{row.title}}"?></td>
                        <td><?php echo "{{row.description}}"?></td>
                        <td><?php echo "{{row.phone_value}}"?></td>
                        <td><?php echo "{{row.street_1}}"?></td>
                        <td><?php echo "{{row.description}}"?></td>
                        <td>

                            <span style="overflow: visible; width: 110px;">
                                <div class="tabledit-toolbar btn-toolbar"
                                     style="text-align: left;">
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            @click="editRow(row)"
                                            type="button"
                                            class="tabledit-edit-button btn btn-success active"
                                            style="float: none;">
                                            <span class="mdi mdi-pencil">

                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </span>


                        </td>

                    </tr>
                </table>

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
