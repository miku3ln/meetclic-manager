{{--ACTIONS MODEL--}}
<input id="action-accounting-account-type-saveData" type="hidden"
value="{{action("Accounting\AccountingAccountTypeController@saveData")}}"/>

<input id="action-accounting-account-type-getAdmin" type="hidden"
value="{{action("Accounting\AccountingAccountTypeController@getAdmin")}}"/>

{{--
ROUTES SET CONFIG routes
--}}
{{--
Route::post("accountingAccountType/save","Accounting\AccountingAccountTypeController@saveData");

Route::post("accountingAccountType/admin","Accounting\AccountingAccountTypeController@getAdmin");

Route::get("accountingAccountType/listSelect2","Accounting\AccountingAccountTypeController@getListSelect2");

Route::get("accountingAccountType/manager","Accounting\AccountingAccountTypeController@getManager");
--}}

