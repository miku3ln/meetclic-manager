{{--ACTIONS MODEL--}}
<input id="action-{{$configPartial["modelNameAction"]}}-saveData" type="hidden"
value="{{action("People\PeopleProfessionController@saveData")}}"/>

<input id="action-{{$configPartial["modelNameAction"]}}-getAdmin" type="hidden"
value="{{action("People\PeopleProfessionController@getAdmin")}}"/>

{{--
ROUTES SET CONFIG routes
--}}
{{--
Route::post("peopleGender/save","People\PeopleGenderController@saveData");

Route::post("peopleGender/admin","People\PeopleGenderController@getAdmin");

Route::get("peopleGender/listSelect2","People\PeopleGenderController@getListSelect2");

Route::get("peopleGender/manager","People\PeopleGenderController@getManager");
--}}

