<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@php
    $managerOptions=[
    'pageTitle'=>'Administracion',
             'menuParentName'=>'Administracion',
           'menuName'=>'Piezas Referencia',
                      'menuName'=>'Piezas Referencia',
'title'=>'Piezas Referencia',
 'icon'=>'<i class="flaticon-cogwheel-2"></i>',
    'id_table'=>'patient_table',
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
@include('partials.mangerMDataTablesJs')
@include('partials.mangerMDataTablesCss')



@section('content')
    @include('partials.admin_view',[
    'title'=>'Administración de '.$name_manager."s",
    'icon'=>'<i class="'.$icon_manager.'"></i>',
    'id_table'=>$model_entity.'_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newRegister()',
        'color'=>'btn-primary'
        ],
      ]
    ])
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

    @foreach ($actions as $key => $action)
        <input id="{{$key}}"  type="hidden" value="{{action($action)}}"  />
    @endforeach

@endsection
@section('after-additional-scripts')
    <script  type="text/javascript">
        var model_entity="{{$model_entity}}";
        var name_manager="{{$name_manager}}";
    </script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/index.js') }}" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/css/bootstrap-colorpicker.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/js/bootstrap-colorpicker.min.js"></script>
@endsection
