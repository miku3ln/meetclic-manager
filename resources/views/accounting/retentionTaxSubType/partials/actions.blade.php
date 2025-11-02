{{--ACTIONS MODEL--}}
<input id="action-retention-tax-sub-type-saveData" type="hidden"
value="{{action("Accounting\RetentionTaxSubTypeController@saveData")}}"/>

<input id="action-retention-tax-sub-type-getAdmin" type="hidden"
value="{{action("Accounting\RetentionTaxSubTypeController@getAdmin")}}"/>

{{-- ACTIONS RELATIONS--}}
<input id="action-retention-tax-type-getListSelect2" type="hidden"
value="{{action("Accounting\RetentionTaxTypeController@getListSelect2")}}"/>
<input id="action-accounting-account-getListSelect2" type="hidden"
value="{{action("Accounting\AccountingAccountController@getListSelect2")}}"/>
{{-- ACTIONS RELATIONS CONFIG SET--}}
{{--
Route::get("retentionTaxType/listSelect2","Accounting\RetentionTaxTypeController@getListSelect2");

Route::get("accountingAccount/listSelect2","Accounting\AccountingAccountController@getListSelect2");
--}}
