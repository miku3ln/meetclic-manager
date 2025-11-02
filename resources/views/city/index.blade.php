<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>
@php
    $managerOptions=[
    'pageTitle'=>'Administracion',
             'menuParentName'=>'Administracion',
           'menuName'=>'Ciudades',
                      'menuName'=>'Paises',
'title'=>'Ciudades',
 'icon'=>'<i class="flaticon-cogwheel-2"></i>',
    'id_table'=>'patient_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newCity()',
        'color'=>'btn-primary'
        ],
      ],

   ];
@endphp
@extends('layouts.masterMinton')

@section('breadcrumb')
    @include('partials.breadcrumb',$managerOptions)
@endsection


@include('partials.mangerMDataTablesJs')


@include('partials.mangerMDataTablesCss')
@section('content')
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                    <i class="flaticon-map-location"></i>
                    </span>
                    <h3 class="m-portlet__head-text m--font-brand">
                        Ciudades
                    </h3>

                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="form-group m-form__group ">
                <div class="row">
                    <div class="col col-md-4">
                        <label class="col-lg-12 col-form-label">
                            País:
                        </label>
                        <div class="col-lg-12">
                            <select class="form-control m-select2" id="select_country">
                            </select>
                        </div>
                    </div>
                    <div class="col col-md-4">
                        <label class="col-lg-12 col-form-label">
                            Provincia:
                        </label>
                        <div class="col-lg-12">
                            <select class="form-control m-select2" id="select_province" name="param">
                            </select>
                        </div>
                    </div>

                    <div class="col col-md-4">
                        <button type="button" onclick="newCity()" class="btn  btn-success not-view" id="add-city">
                            Nuevo
                        </button> <!---->


                    </div>
                </div>


            </div>
        </div>
    </div>
    <div id="city_list" style="display: none">
        @include('partials.admin_view',[
        'title'=>'Administración de ciudades',
        'icon'=>'<i class="flaticon-cogwheel-2"></i>',
        'id_table'=>'city_table',
        'action_buttons'=>[
            [
            'label'=>'Crear',
            'icon'=>'<i class="la la-plus"></i>',
            'handler_js'=>'newCity()',
            'color'=>'btn-primary'
            ],
          ]
        ])
    </div>
    @include('partials.modal',[
    'title'=>'Crear ciudad',
    'id'=>'modal',
    'size'=>'modal-lg',
    'action_buttons'=>[
        [
        'type'=>'submit',
        'form'=>'city_form',
        'id'=>'btn_save',
        'label'=>'Guardar',
        'color'=>'btn-primary'
        ],
     ]
    ])
    <input id="action_get_form" type="hidden" value="{{ action("Geography\CityController@getFormCity") }}"/>
    <input id="action_unique_name" type="hidden"
           value="{{ action("Geography\CityController@postIsNameUnique") }}"/>
    <input id="action_save_city" type="hidden" value="{{ action("Geography\CityController@postSave") }}"/>
    <input id="action_load_cities" type="hidden"
           value="{{ action("Geography\CityController@getListCities") }}"/>
    <input id="action_load_countries_select2" type="hidden"
           value="{{ action("Geography\CountryController@getListSelect2") }}"/>
    <input id="action_load_provinces_select2" type="hidden"
           value="{{ action("Geography\ProvinceController@getListSelect2") }}"/>
@endsection
@section('after-additional-scripts')

    <script src="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}"></script>

    <script src="{{ asset($resourcePathServer.'js/plugins/gmaps/gmaps.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/city/index.js') }}" type="text/javascript"></script>

@endsection
