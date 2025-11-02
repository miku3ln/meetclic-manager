<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@section('content')
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                    <i class="fa fa-shopping-cart"></i>
                    </span>
                    <h3 class="m-portlet__head-text m--font-brand">
                        Productos por Distribuidor
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="form-group m-form__group row">
                <label class="col-md-1 col-form-label">
                    Distribuidor:
                </label>
                <div class="col-md-5">
                    <select class="form-control m-select2" id="select_dealer">
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div id="products_list" style="display: none" class="row">
        <div class="col-md-6">
            @include('partials.admin_view',[
        'title'=>'Productos Asignados',
        'icon'=>'<i class="fa fa-cart-arrow-down"></i>',
        'id_table'=>'assigned_products',
        'action_buttons'=>[
                [
                'label'=>'Eliminar',
                'icon'=>'<i class=" far fa-trash-alt"></i>',
                'handler_js'=>'saveProductsByDealer(0)',
                'color'=>'btn-danger'
                ],
              ]
        ])
        </div>
        <div class="col-md-6">
            @include('partials.admin_view',[
        'title'=>'Productos',
        'icon'=>'<i class="fa fa-cart-plus"></i>',
        'id_table'=>'products',
        'action_buttons'=>[
                [
                'label'=>'Agregar',
                'icon'=>'<i class="la la-check"></i>',
                'handler_js'=>'saveProductsByDealer(1)',
                'color'=>'btn-success'
                ],
              ]
        ])
        </div>
    </div>
    <input id="action_save_productsByDealer" type="hidden" value="{{ action("Dealers\ProductByDealerController@postSave") }}"/>
    <input id="action_load_products" type="hidden"
           value="{{ action("Dealers\ProductByDealerController@getListProductsByDealer") }}"/>
    <input id="action_load_dealers_select2" type="hidden"
           value="{{ action("Dealers\DealerController@getListSelect2") }}"/>
@endsection
@section('additional-scripts')
    <script src="{{ asset($resourcePathServer.'js/productByDealer/index.js') }}" type="text/javascript"></script>
@endsection
