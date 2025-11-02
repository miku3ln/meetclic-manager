{{--ACTIONS MODEL--}}
<input id="action-shipping-rate-kinds-of-way-saveData" type="hidden"
value="{{action("ShippingRate\ShippingRateKindsOfWayController@saveData")}}"/>

<input id="action-shipping-rate-kinds-of-way-getAdmin" type="hidden"
value="{{action("ShippingRate\ShippingRateKindsOfWayController@getAdmin")}}"/>

{{--
ROUTES SET CONFIG routes
--}}
{{--
Route::post("shippingRateKindsOfWay/save","ShippingRate\ShippingRateKindsOfWayController@saveData");

Route::post("shippingRateKindsOfWay/admin","ShippingRate\ShippingRateKindsOfWayController@getAdmin");

Route::get("shippingRateKindsOfWay/listSelect2","ShippingRate\ShippingRateKindsOfWayController@getListSelect2");

Route::get("shippingRateKindsOfWay/manager","ShippingRate\ShippingRateKindsOfWayController@getManager");
--}}

