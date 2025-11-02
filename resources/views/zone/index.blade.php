<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@include('partials.mangerMDataTablesJs')



@include('partials.mangerMDataTablesCss')
@section('css')
    <link href="{{ asset($resourcePathServer.'js/plugins/colorselector/bootstrap-colorselector.min.css') }}" rel="stylesheet"
          type="text/css">
@endsection
@section('content')
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                    <i class="flaticon-map-location"></i>
                    </span>
                    <h3 class="m-portlet__head-text m--font-brand">
                        Zonas
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="form-group m-form__group row">
                <label class="col-md-1 col-form-label">
                    País:
                </label>
                <div class="col-md-3">
                    <select class="form-control m-select2" id="select_country">
                    </select>
                </div>
                <label class="col-md-1 col-form-label">
                    Provincia:
                </label>
                <div class="col-md-3">
                    <select class="form-control m-select2" id="select_province" name="param">
                    </select>
                </div>
                <label class="col-md-1 col-form-label">
                    Ciudad:
                </label>
                <div class="col-md-3">
                    <select class="form-control m-select2" id="select_city">
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div id="zone_list" style="display: none">
        @include('partials.admin_view',[
        'title'=>'Administración de zonas',
        'icon'=>'<i class="flaticon-cogwheel-2"></i>',
        'id_table'=>'zone_table',
        'action_buttons'=>null
        ])
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                    <i class="flaticon-map-location"></i>
                    </span>
                        <h3 class="m-portlet__head-text m--font-brand">
                            Mapa de Zonas
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" id="save_button"
                               class="m-portlet__nav-link btn btn-primary m-btn m-btn--pill m-btn--air">
                                <span><i class="fa fa-check"></i> Guardar Cambios</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label class="col-md-1 col-form-label">
                        Color:
                    </label>
                    <div class="col-md-3">
                        <select id="select_color">
                            <option value="1" data-color="#e5bedd"></option>
                            <option value="2" data-color="#ffa8b8"></option>
                            <option value="3" data-color="#dcd9f8"></option>
                            <option value="4" data-color="#f7d8c3"></option>
                            <option value="5" data-color="#ffc8c3"></option>
                            <option value="6" data-color="#bccef4"></option>
                            <option value="7" data-color="#b5dcf9"></option>
                            <option value="8" data-color="#a9e5e3"></option>
                            <option value="9" data-color="#a2edce"></option>
                            <option value="10" data-color="#a0d995"></option>
                            <option value="11" data-color="#c5d084"></option>
                            <option value="12" data-color="#d2c897"></option>
                            <option value="13" data-color="#fae187"></option>
                            <option value="14" data-color="#e8ba86"></option>
                            <option value="15" data-color="#d3bead"></option>
                        </select>
                    </div>
                </div>
                {{--This commented section is used to display data zones, coordinates, names and more. Don't delete it.--}}
                {{--<div id="savedata">--}}
                {{--<pre></pre>--}}
                {{--</div>--}}
                <div class="form-group m-form__group row">
                    <div class="col-md-12">
                        <div style="width:auto;height: 400px;" id="zones_map">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.modal',[
    'title'=>'Editar Zona',
    'id'=>'modal',
    'size'=>'modal-md',
    'action_buttons'=>[
        [
        'type'=>'submit',
        'form'=>'zone_form',
        'id'=>'btn_save',
        'label'=>'Guardar',
        'color'=>'btn-primary'
        ],
     ]
    ])
    <input id="action_get_form" type="hidden" value="{{ action("Geography\\ZoneController@getFormZone") }}"/>
    <input id="action_unique_name" type="hidden"
           value="{{ action("Geography\\ZoneController@postIsNameUnique") }}"/>
    <input id="action_save_zones" type="hidden" value="{{ action("Geography\\ZoneController@postSaveZones") }}"/>
    <input id="action_save_zone" type="hidden" value="{{ action("Geography\\ZoneController@postSave") }}"/>
    <input id="action_load_zones" type="hidden"
           value="{{ action("Geography\ZoneController@getListZones") }}"/>
    <input id="action_load_zones_map" type="hidden"
           value="{{ action("Geography\ZoneController@getListZonesMap") }}"/>
    <input id="action_load_countries_select2" type="hidden"
           value="{{ action("Geography\CountryController@getListSelect2") }}"/>
    <input id="action_load_provinces_select2" type="hidden"
           value="{{ action("Geography\ProvinceController@getListSelect2") }}"/>
    <input id="action_load_cities_select2" type="hidden"
           value="{{ action("Geography\CityController@getListSelect2") }}"/>
@endsection
@section('after-additional-scripts')

    <script src="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}"></script>
    <script src="{{ asset($resourcePathServer.'js/plugins/gmaps/gmaps.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/plugins/colorselector/bootstrap-colorselector.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/zone/index.js') }}" type="text/javascript"></script>
@endsection
