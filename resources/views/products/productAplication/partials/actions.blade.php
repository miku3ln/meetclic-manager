{{--ACTIONS MODEL--}}
<input id="action-product-aplication-saveData" type="hidden"
value="{{action("Products\ProductAplicationController@saveData")}}"/>

<input id="action-product-aplication-getAdmin" type="hidden"
value="{{action("Products\ProductAplicationController@getAdmin")}}"/>

{{--
ROUTES SET CONFIG routes
--}}
{{--
Route::post("productAplication/save","Products\ProductAplicationController@saveData");

Route::post("productAplication/admin","Products\ProductAplicationController@getAdmin");

Route::get("productAplication/listSelect2","Products\ProductAplicationController@getListSelect2");

Route::get("productAplication/manager","Products\ProductAplicationController@getManager");
--}}

