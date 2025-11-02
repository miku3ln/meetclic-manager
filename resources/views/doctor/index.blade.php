<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@php
    $managerOptions=[
    'pageTitle'=>'Administracion',
             'menuParentName'=>'Administracion',
           'menuName'=>'Doctores',
                      'menuName'=>'Doctores',
'title'=>'Doctores',
 'icon'=>'<i class="flaticon-cogwheel-2"></i>',
    'id_table'=>'patient_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newDoctor()',
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
    'title'=>'Administración de Doctores',
    'icon'=>'<i class="flaticon-users"></i>',
    'id_table'=>'doctor_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newDoctor()',
        'color'=>'btn-primary'
        ],
      ]
    ])
    @include('partials.modal',[
    'title'=>'Nuevo Doctor',
    'id'=>'modal',
    'action_buttons'=>[
        [
        'type'=>'submit',
        'form'=>'doctor_form',
        'id'=>'btn_save',
        'label'=>'Guardar',
        'color'=>'btn-primary'
        ],
     ]
    ])
    <input id="action_get_form" type="hidden" value="{{ action("Hospital\DoctorController@getFormDoctor") }}"/>
    <input id="action_validate_document" type="hidden"
           value="{{ action("Hospital\DoctorController@postIsDocumentValid") }}"/>
    <input id="action_save_doctor" type="hidden" value="{{ action("Hospital\DoctorController@postSave") }}"/>
    <input id="action_load_doctors" type="hidden"
           value="{{ action("Hospital\DoctorController@getListDoctors") }}"/>
@endsection
@section('script')
    <script src="{{ asset($resourcePathServer.'js/doctor/index.js') }}" type="text/javascript"></script>
    <script
        src="https://maps.google.com/maps/api/js?key=AIzaSyAy7FfEU_fOeVTrJKxENPLxAor4cL6_d88&libraries=places"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js" type="text/javascript"></script>


@endsection

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" rel="stylesheet"
          type="text/css">
@endsection
