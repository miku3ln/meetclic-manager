

<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>

@section('content')
    @include('partials.admin_view',[
    'title'=>'Administración de productos',
    'icon'=>'<i class="flaticon-cogwheel-2"></i>',
    'id_table'=>'product_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newProduct()',
        'color'=>'btn-primary'
        ],
      ]
    ])
    @include('partials.modal',[
    'title'=>'Crear Producto',
    'id'=>'modal',
    'size' =>'modal-lg',
    'action_buttons'=>[
        [
        'type'=>'submit',
        'form'=>'product_form',
        'id'=>'btn_save',
        'label'=>'Guardar',
        'color'=>'btn-primary'
        ],
     ]
    ])
    <input id="action_get_form" type="hidden" value="{{ action("Products\ProductController@getFormProduct") }}"/>
    <input id="action_unique_name" type="hidden" value="{{ action("Products\ProductController@postIsNameUnique") }}"/>
    <input id="action_save_product" type="hidden" value="{{ action("Products\ProductController@postSave") }}"/>
    <input id="action_load_products" type="hidden" value="{{ action("Products\ProductController@getListProducts") }}"/>
    <input id="action_upload_image" type="hidden" value="{{ action("Products\ImageController@postUpload") }}"/>
    <input id="action_delete_image" type="hidden" value="{{ action("Products\ImageController@deleteImage") }}"/>
    <input id="action_load_categories_select2" type="hidden" value="{{ action("Products\CategoryController@getListSelect2") }}"/>

@endsection
@section('script')
    <script src="{{ asset($resourcePathServer.'js/product/index.js') }}" type="text/javascript"></script>
@endsection

