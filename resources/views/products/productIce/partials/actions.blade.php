{{--ACTIONS MODEL--}}
<input id="action-product-ice-saveData" type="hidden"
value="{{action("Products\ProductIceController@saveData")}}"/>

<input id="action-product-ice-getAdmin" type="hidden"
value="{{action("Products\ProductIceController@getAdmin")}}"/>

{{-- ACTIONS RELATIONS--}}
<input id="action-product-ice-types-getListSelect2" type="hidden"
value="{{action("Products\ProductIceTypesController@getListSelect2")}}"/>
