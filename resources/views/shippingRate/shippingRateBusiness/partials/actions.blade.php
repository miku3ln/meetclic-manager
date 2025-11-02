{{--ACTIONS MODEL--}}
<input id="action-shipping-rate-business-saveData" type="hidden"
value="{{action("ShippingRate\ShippingRateBusinessController@saveData")}}"/>

<input id="action-shipping-rate-business-getAdmin" type="hidden"
value="{{action("ShippingRate\ShippingRateBusinessController@getAdmin")}}"/>




<input id="action-shipping-rate-services-saveData" type="hidden"
       value="{{action("ShippingRate\ShippingRateServicesController@saveData")}}"/>
<input id="action-shipping-rate-services-getAdmin" type="hidden"
       value="{{action("ShippingRate\ShippingRateServicesController@getAdmin")}}"/>




<input id="action-shipping-rate-business-by-conversion-factor-saveData" type="hidden"
       value="{{action("ShippingRate\ShippingRateBusinessByConversionFactorController@saveData")}}"/>
<input id="action-shipping-rate-business-by-conversion-factor-getAdmin" type="hidden"
       value="{{action("ShippingRate\ShippingRateBusinessByConversionFactorController@getAdmin")}}"/>
{{-- ACTIONS RELATIONS--}}
<input id="action-shipping-rate-services-getListSelect2" type="hidden"
       value="{{action("ShippingRate\ShippingRateServicesController@getListSelect2")}}"/>
<input id="action-shipping-rate-kinds-of-way-getListSelect2" type="hidden"
       value="{{action("ShippingRate\ShippingRateKindsOfWayController@getListSelect2")}}"/>
<input id="action-product-measure-type-getListSelect2" type="hidden"
       value="{{action("Products\ProductMeasureTypeController@getListSelect2")}}"/>
<input id="action-shipping-rate-business-getListSelect2" type="hidden"
       value="{{action("ShippingRate\ShippingRateBusinessController@getListSelect2")}}"/>
