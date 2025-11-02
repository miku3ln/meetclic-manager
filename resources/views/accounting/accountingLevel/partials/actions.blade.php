{{--ACTIONS MODEL--}}
<input id="action-accounting-level-saveData" type="hidden"
value="{{action("Accounting\AccountingLevelController@saveData")}}"/>

<input id="action-accounting-level-getAdmin" type="hidden"
value="{{action("Accounting\AccountingLevelController@getAdmin")}}"/>

{{--
ROUTES SET CONFIG routes
--}}
{{--
Route::post("accountingLevel/save","Accounting\AccountingLevelController@saveData");

Route::post("accountingLevel/admin","Accounting\AccountingLevelController@getAdmin");

Route::get("accountingLevel/listSelect2","Accounting\AccountingLevelController@getListSelect2");

Route::get("accountingLevel/manager","Accounting\AccountingLevelController@getManager");
--}}

