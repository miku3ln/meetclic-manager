@section('content')
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                    <i class=" fas fa-money-bill-alt"></i>
                    </span>
                    <h3 class="m-portlet__head-text m--font-brand">
                        Precio de Productos
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
    <div id="price_list" style="display: none">
        @include('partials.admin_view',[
        'title'=>'Administración de precios',
        'icon'=>'<i class="flaticon-cogwheel-2"></i>',
        'id_table'=>'price_table',
        'form_id'=>'price_by_zone_form',
        'method'=>'POST',
        'action_buttons'=>[
                [
                'label'=>'Actualizar',
                'icon'=>'<i class="la la-check"></i>',
                'handler_js'=>'savePrices()',
                'color'=>'btn-primary'
                ],
              ]
        ])
    </div>
    <input id="action_get_zones" type="hidden" value="{{ action("Geography\ZoneController@getListZonesMap") }}"/>
    <input id="action_save_prices" type="hidden" value="{{ action("Products\PriceByZoneController@postSave") }}"/>
    <input id="action_load_prices" type="hidden"
           value="{{ action("Products\PriceByZoneController@getListPrices") }}"/>
    <input id="action_load_countries_select2" type="hidden"
           value="{{ action("Geography\CountryController@getListSelect2") }}"/>
    <input id="action_load_provinces_select2" type="hidden"
           value="{{ action("Geography\ProvinceController@getListSelect2") }}"/>
    <input id="action_load_cities_select2" type="hidden"
           value="{{ action("Geography\CityController@getListSelect2") }}"/>
@endsection
@section('additional-scripts')
    <script src="{{ asset('js/priceByZone/index.js') }}" type="text/javascript"></script>
@endsection
