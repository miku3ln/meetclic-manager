{{--ACTIONS MODEL--}}
<input id="action-business-amenities-saveData" type="hidden"
value="{{action("Business\BusinessAmenitiesController@saveData")}}"/>

<input id="action-business-amenities-getAdmin" type="hidden"
value="{{action("Business\BusinessAmenitiesController@getAdmin")}}"/>

{{--
ROUTES SET CONFIG routes
--}}
{{--
Route::post("businessAmenities/save","Business\BusinessAmenitiesController@saveData");

Route::post("businessAmenities/admin","Business\BusinessAmenitiesController@getAdmin");

Route::get("businessAmenities/listSelect2","Business\BusinessAmenitiesController@getListSelect2");

Route::get("businessAmenities/manager","Business\BusinessAmenitiesController@getManager");
--}}

{{-- ACTIONS RELATIONS--}}
<input id="action-business-subcategories-getListSelect2" type="hidden"
value="{{action("Business\BusinessSubcategoriesController@getListSelect2")}}"/>
{{-- ACTIONS RELATIONS CONFIG SET--}}
{{--
Route::get("businessSubcategories/listSelect2","Business\BusinessSubcategoriesController@getListSelect2");
--}}