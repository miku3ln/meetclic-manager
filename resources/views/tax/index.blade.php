<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@extends('layouts.masterMinton')
@include('partials.mangerMDataTablesCss')
@php
    $managerOptions=[
    'pageTitle'=>'Administracion',
             'menuParentName'=>'Administracion',
           'menuName'=>'Tax',
                      'menuName'=>'Tax',
'title'=>'Tax',
 'icon'=>'<i class="flaticon-cogwheel-2"></i>',
    'id_table'=>'tax_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newTax()',
        'color'=>'btn-primary'
        ],
      ],
      'modal'=>[
    'title'=>'Crear impuesto',
    'id'=>'modal',
    'action_buttons'=>[
        [
        'type'=>'submit',
        'form'=>'tax_form',
        'id'=>'btn_save',
        'label'=>'Guardar',
        'color'=>'btn-primary'
        ],
     ]
    ]
   ];
@endphp
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
            <a href="javascript:newTax()" class="dropdown-item">
                <i class="fas fa-pen-alt"></i>
                <span>Creacion</span>
            </a>

        </div>
    </li>
@endsection


@section('additional-styles')
    <style>
        .detail-cities {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    @include('partials.admin_view',$managerOptions)
    @include('partials.modal',$managerOptions['modal'])

    @include('partials.modal',[
    'title'=>'Detalle ciudades',
    'id'=>'modal-detail-cities',
    'action_buttons' => [],
    'static_content' => '<div id="tax_cities_table" class="datatable"></div>'
    ])

    <input id="action_get_form" type="hidden" value="{{ action("Taxes\TaxController@getFormTax") }}"/>
    <input id="action_unique_name" type="hidden" value="{{ action("Taxes\TaxController@postIsNameUnique") }}"/>
    <input id="action_save_tax" type="hidden" value="{{ action("Taxes\TaxController@postSave") }}"/>
    <input id="action_load_taxes" type="hidden" value="{{ action("Taxes\TaxController@getListTaxes") }}"/>
    <input id="action_load_cities" type="hidden"
           value="{{ action("Geography\CityController@getListSelect2") }}"/>
    <input id="action_load_province" type="hidden"
           value="{{ action("Geography\ProvinceController@getListSelect2") }}"/>
    <input id="action_load_countries_select2" type="hidden"
           value="{{ action("Geography\CountryController@getListSelect2") }}"/>
    <input id="action_details_cities" type="hidden" value="{{ action("Taxes\TaxController@getListCitiesByTax") }}"/>

@endsection

@include('partials.mangerMDataTablesJs')
@section('after-additional-scripts')
    <script src="{{ asset($resourcePathServer.'js/tax/index.js') }}" type="text/javascript"></script>
@endsection
