{{--ACTIONS MODEL--}}
<input id="action-product-sizes-saveData" type="hidden"
value="{{action("Products\ProductSizesController@saveData")}}"/>

<input id="action-product-sizes-getAdmin" type="hidden"
value="{{action("Products\ProductSizesController@getAdmin")}}"/>

{{--
ROUTES SET CONFIG routes
--}}
{{--
Route::post("productSizes/save","Products\ProductSizesController@saveData");

Route::post("productSizes/admin","Products\ProductSizesController@getAdmin");

Route::get("productSizes/listSelect2","Products\ProductSizesController@getListSelect2");

Route::get("productSizes/manager","Products\ProductSizesController@getManager");
--}}

