{{--ACTIONS MODEL--}}
<input id="action-accounting-account-saveData" type="hidden"
value="{{action("Accounting\AccountingAccountController@saveData")}}"/>

<input id="action-accounting-account-getAdmin" type="hidden"
value="{{action("Accounting\AccountingAccountController@getAdmin")}}"/>

{{--
ROUTES SET CONFIG routes
--}}
{{--
Route::post("accountingAccount/save","Accounting\AccountingAccountController@saveData");

Route::post("accountingAccount/admin","Accounting\AccountingAccountController@getAdmin");

Route::get("accountingAccount/listSelect2","Accounting\AccountingAccountController@getListSelect2");

Route::get("accountingAccount/manager","Accounting\AccountingAccountController@getManager");
--}}

{{-- ACTIONS RELATIONS--}}
<input id="action-accounting-account-type-getListSelect2" type="hidden"
value="{{action("Accounting\AccountingAccountTypeController@getListSelect2")}}"/>
<input id="action-accounting-level-getListSelect2" type="hidden"
value="{{action("Accounting\AccountingLevelController@getListSelect2")}}"/>
{{-- ACTIONS RELATIONS CONFIG SET--}}
{{--
Route::get("accountingAccountType/listSelect2","Accounting\AccountingAccountTypeController@getListSelect2");

Route::get("accountingLevel/listSelect2","Accounting\AccountingLevelController@getListSelect2");
--}}
