{{--ACTIONS MODEL--}}
<input id="action-product-ice-types-saveData" type="hidden"
value="{{action("Products\ProductIceTypesController@saveData")}}"/>

<input id="action-product-ice-types-getAdmin" type="hidden"
value="{{action("Products\ProductIceTypesController@getAdmin")}}"/>

{{--
ROUTES SET CONFIG routes
--}}
{{--
Route::post("productIceTypes/save","Products\ProductIceTypesController@saveData");

Route::post("productIceTypes/admin","Products\ProductIceTypesController@getAdmin");

Route::get("productIceTypes/listSelect2","Products\ProductIceTypesController@getListSelect2");

Route::get("productIceTypes/manager","Products\ProductIceTypesController@getManager");
--}}

