{{--ACTIONS MODEL--}}
<input id="action-accounting-config-modules-account-by-account-saveData" type="hidden"
value="{{action("Accounting\AccountingConfigModulesAccountByAccountController@saveData")}}"/>

<input id="action-accounting-config-modules-account-by-account-getAdmin" type="hidden"
value="{{action("Accounting\AccountingConfigModulesAccountByAccountController@getAdmin")}}"/>

{{--
ROUTES SET CONFIG routes
--}}
{{--
--}}

{{-- ACTIONS RELATIONS--}}
<input id="action-accounting-account-getListSelect2" type="hidden"
value="{{action("Accounting\AccountingAccountController@getListSelect2")}}"/>
<input id="action-accounting-config-modules-types-getListSelect2" type="hidden"
value="{{action("Accounting\AccountingConfigModulesTypesController@getListSelect2")}}"/>
{{-- ACTIONS RELATIONS CONFIG SET--}}
{{--
Route::get("accountingAccount/listSelect2","Accounting\AccountingAccountController@getListSelect2");

Route::get("accountingConfigModulesTypes/listSelect2","Accounting\AccountingConfigModulesTypesController@getListSelect2");
--}}