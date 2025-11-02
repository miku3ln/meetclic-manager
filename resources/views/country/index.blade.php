<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@php
    $managerOptions=[
    'pageTitle'=>'Administracion',
             'menuParentName'=>'Administracion',
           'menuName'=>'Paises',
                      'menuName'=>'Paises',
'title'=>'Paises',
 'icon'=>'<i class="flaticon-cogwheel-2"></i>',
    'id_table'=>'patient_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newCountry()',
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
    'title'=>'Administración de paises',
    'icon'=>'<i class="flaticon-cogwheel-2"></i>',
    'id_table'=>'country_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newCountry()',
        'color'=>'btn-primary'
        ],
      ]
    ])
    @include('partials.modal',[
    'title'=>'Crear Pais',
    'id'=>'modal',
    'action_buttons'=>[
        [
        'type'=>'submit',
        'form'=>'country_form',
        'id'=>'btn_save',
        'label'=>'Guardar',
        'color'=>'btn-primary'
        ],
     ]
    ])
    <input id="action_get_form" type="hidden" value="{{ action("Geography\CountryController@getFormCountry") }}"/>
    <input id="action_unique_name" type="hidden" value="{{ action("Geography\CountryController@postIsNameUnique") }}"/>
    <input id="action_save_country" type="hidden" value="{{ action("Geography\CountryController@postSave") }}"/>
    <input id="action_load_countries" type="hidden"
           value="{{ action("Geography\CountryController@getListCountries") }}"/>
@endsection
@section('after-additional-scripts')
    <script src="{{ asset($resourcePathServer.'js/country/index.js') }}" type="text/javascript"></script>
@endsection
