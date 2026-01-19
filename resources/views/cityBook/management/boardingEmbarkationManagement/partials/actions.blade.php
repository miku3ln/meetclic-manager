<!--BUSINESS-->
<input id="action-management-admin" type="hidden"
       value="{{ route("maritimeVesselsAdmin") }}"/>

<input id="action-management-save" type="hidden"
       value="{{ route("saveMaritimeVesselApi")}}"/>
<input id="action-management-getDataPaymentsManagement" type="hidden"
       value="{{ route("getDataPaymentsManagement")}}"/>

<input id="action-management-listS2Customer" type="hidden"
       value="{{ route("listS2Customer")}}"/>

<input id="action-management-listS2CustomerResponsibles" type="hidden"
       value="{{ route("listS2CustomerResponsibles")}}"/>


<input id="action-management-vesselTypesList" type="hidden"
       value="{{ route("vesselTypesList")}}"/>

<input id="action-management-consultarCedula" type="hidden"
       value="{{ route("consultarCedula")}}"/>


<input id="action-management-reports" type="hidden"
       value="{{ route("maritimeDeparturesReports")}}"/>
<input id="action-management-business-by-maritime" type="hidden"
       value="{{ route("businessManager")}}"/>
<input id="action-management-business-by-vessel" type="hidden"
       value="{{ route("maritimeDeparturesVesselList")}}"/>

<input id="action-management-reports-download" type="hidden"
       value="{{ route('maritimeDeparturesReportsDownload', ['dateFrom' => "dateFrom", 'dateTo' => 'dateTo', 'businessId' => 'businessId'])}}"/>

<input id="action-management-responsibles-admin" type="hidden"
       value="{{ route("maritimeVesselsResposiblesAdmin") }}"/>
<input id="action-management-responsibles-save" type="hidden"
       value="{{ route("saveMaritimeVesselResponsiblesApi")}}"/>
