<!--BUSINESS-->
<input id="action-management-admin" type="hidden"
       value="{{ route("adminPointsSales",app()->getLocale()) }}"/>

<input id="action-management-save" type="hidden"
       value="{{ route("executePaymentCashEvents")}}"/>
<input id="action-management-getDataPaymentsManagement" type="hidden"
       value="{{ route("getDataPaymentsManagement")}}"/>
