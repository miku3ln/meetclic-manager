<!--BUSINESS-->
<input id="action_business_save" type="hidden"
       value="{{ action("Business\BusinessController@saveData") }}"/>

<input id="action_business_admin" type="hidden"
       value="{{route("getBusinessManagerFrontend")}}"/>


<input id="action-business-amenities-listSelect2" type="hidden"
       value="{{ action("Business\BusinessAmenitiesController@getListSelect2") }}"/>

<input id="action-business-view" type="hidden"
       value="{{route('businessDetails', app()->getLocale())}}"/>
<input id="action-business-manager" type="hidden"
       value="{{route('managerBusiness')}}"/>


