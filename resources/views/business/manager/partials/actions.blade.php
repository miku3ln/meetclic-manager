{{--CONFIG ACTIONS-VM-007--}}

{{--BUSINESS-MANAGER-ACTIONS-CRUD--}}

@php

    $managerProcessNameData=explode('manager',$configPartial['typeManager']);
    $managerProcessName=$managerProcessNameData[1];
    $character='/';

@endphp

<input id="action_getDataInteraction" type="hidden"
       value="{{ route("getDataInteraction",app()->getLocale()) }}"/>

<input id="action_load_products" type="hidden"
       value="{{ action("Products\ProductController@getAdminBusiness") }}"/>

<input id="action_business_save" type="hidden"
       value="{{ action("Business\BusinessController@saveBusiness") }}"/>
<!--SCHEDULE-->
<input id="action_business_by_schedule_save" type="hidden"
       value="{{ action("Business\BusinessByScheduleController@saveSchedules") }}"/>

<input id="action_business_schedule_by_breakdown_delete" type="hidden"
       value="{{ action("Business\BusinessByScheduleController@deleteSchedule") }}"/>


<input id="action_products_admin" type="hidden"
       value="{{ action("Products\ProductController@getAdminProductsBusiness") }}"/>


<input id="action_upload_resource" type="hidden"
       value="{{ action("Multimedia\MultimediaController@uploadMultimedia") }}"/>

{{--ROUTES--}}
<input id="action_routes_admin" type="hidden"
       value="{{ action("Routes\BusinessByRoutesMapController@getAdminBusiness") }}"/>
<input id="action_routes_save" type="hidden"
       value="{{ action("Routes\BusinessByRoutesMapController@saveBusiness") }}"/>

<input id="uploadResourceBusiness" type="hidden"
       value="{{ action("Multimedia\MultimediaController@uploadResourceBusiness") }}"/>

<input id="actionListMarker" type="hidden"
       value="{{ action("Routes\RoutesMapByRoutesDrawingController@getListSelect2") }}"/>
{{--PANORAMA--}}
<input id="action_panorama_admin" type="hidden"
       value="{{ action("Panorama\BusinessByPanoramaController@getAdminBusiness") }}"/>
<input id="action_panorama_save" type="hidden"
       value="{{ action("Panorama\BusinessByPanoramaController@saveToBusiness") }}"/>

{{--GALLERY--}}
<input id="action_gallery_admin" type="hidden"
       value="{{ action("Gallery\BusinessByGalleryController@getAdminBusiness") }}"/>
<input id="action_gallery_save" type="hidden"
       value="{{ action("Gallery\BusinessByGalleryController@saveBusiness") }}"/>

{{--Lodging--}}
<input id="action_lodging_admin" type="hidden"
       value="{{ action("Housing\LodgingController@getAdminBusiness") }}"/>
<input id="action_lodging_save" type="hidden"
       value="{{ action("Housing\LodgingController@saveBusiness") }}"/>
<input id="action_lodging_delivery_save" type="hidden"
       value="{{ action("Housing\LodgingController@delivery") }}"/>

<input id="action_customer_getListSelect2NotLodging" type="hidden"
       value="{{ action("Crm\CustomerController@getListSelect2NotLodging") }}"/>

<input id="action-customer-getListAllInformationAddress" type="hidden"
       value="{{ action("Crm\CustomerController@getListAllInformationAddress") }}"/>
<input id="action_lodging_statistical_data_results" type="hidden"
       value="{{ action("Housing\LodgingController@results") }}"/>

{{--Lodging By Payment--}}
<input id="action_lodging_by_payment_save" type="hidden"
       value="{{ action("Housing\LodgingByPaymentController@savePayment") }}"/>

{{--Lodging By Arrived--}}
<input id="action_lodging_by_arrived_save" type="hidden"
       value="{{ action("Housing\LodgingByArrivedController@saveArrived") }}"/>
{{--Business By Lodging By Price--}}
<input id="action_business_by_lodging_by_price_getListRooms" type="hidden"
       value="{{ action("Housing\BusinessByLodgingByPriceController@getListRooms") }}"/>

{{--lodging_by_type_of_room--}}
<input id="action_lodging_by_type_of_room_save" type="hidden"
       value="{{ action("Housing\LodgingByTypeOfRoomController@saveRoomsLodging")}}"/>

{{--LODGINGTYPEROOM--}}

<input id="action_lodging_type_of_room_save" type="hidden"
       value="{{ action("Housing\LodgingTypeOfRoomController@saveData") }}"/>
<input id="action_lodging_type_of_room_admin" type="hidden"
       value="{{ action("Housing\LodgingTypeOfRoomController@getAdmin") }}"/>
<input id="action_lodging_type_of_room_getListSelect2" type="hidden"
       value="{{ action("Housing\LodgingTypeOfRoomController@getListSelect2") }}"/>

{{--LEVELS--}}
<input id="action_lodging_room_levels_save" type="hidden"
       value="{{ action("Housing\LodgingRoomLevelsController@saveData") }}"/>
<input id="action_lodging_room_levels_admin" type="hidden"
       value="{{ action("Housing\LodgingRoomLevelsController@getAdmin") }}"/>
<input id="action_lodging_room_levels_getListSelect2" type="hidden"
       value="{{ action("Housing\LodgingRoomLevelsController@getListSelect2") }}"/>


{{--LODGINGTYPEROOM BY PRICE--}}

<input id="action_lodging_type_of_room_by_price_save" type="hidden"
       value="{{ action("Housing\LodgingTypeOfRoomByPriceController@saveData") }}"/>
<input id="action_lodging_type_of_room_by_price_saveReception" type="hidden"
       value="{{ action("Housing\LodgingTypeOfRoomByPriceController@saveDataReception") }}"/>
<input id="action_lodging_type_of_room_by_price_admin" type="hidden"
       value="{{ action("Housing\LodgingTypeOfRoomByPriceController@getAdmin") }}"/>
<input id="action_lodging_type_of_room_by_price_adminReception" type="hidden"
       value="{{ action("Housing\LodgingTypeOfRoomByPriceController@getAdminReception") }}"/>


{{--FEATURES--}}
<input id="action-lodging-room-features-save" type="hidden"
       value="{{ action("Housing\LodgingRoomFeaturesController@saveData") }}"/>
<input id="action-lodging-room-features-admin" type="hidden"
       value="{{ action("Housing\LodgingRoomFeaturesController@getAdmin") }}"/>
<input id="action-lodging-room-features-getListSelect2" type="hidden"
       value="{{ action("Housing\LodgingRoomFeaturesController@getListSelect2") }}"/>
{{--EDUCATIONAL INSTITUTION--}}
<input id="action-educational-institution-askwer-type-saveData" type="hidden"
       value="{{action("EducationalInstitution\EducationalInstitutionAskwerTypeController@saveData")}}"/>

<input id="action-educational-institution-askwer-type-getAdmin" type="hidden"
       value="{{action("EducationalInstitution\EducationalInstitutionAskwerTypeController@getAdmin")}}"/>

<input id="action-educational-institution-by-business-saveData" type="hidden"
       value="{{action("EducationalInstitution\EducationalInstitutionByBusinessController@saveData")}}"/>

<input id="action-educational-institution-by-business-getAdmin" type="hidden"
       value="{{action("EducationalInstitution\EducationalInstitutionByBusinessController@getAdmin")}}"/>
<input id="action-educational-institution-askwer-type-getDataAskwer" type="hidden"
       value="{{ action("EducationalInstitution\EducationalInstitutionByBusinessController@getDataAskwer") }}"/>
<input id="action-educational-institution-askwer-type-getListSelect2" type="hidden"
       value="{{ action("EducationalInstitution\EducationalInstitutionAskwerTypeController@getListSelect2") }}"/>

<input id="action-askwer-field-value-getDataAskwerResults" type="hidden"
       value="{{ action("Askwer\AskwerFieldValueController@getDataAskwerResults") }}"/>

<input id="action-educational-institution-by-business-getDataAskwerForm" type="hidden"
       value="{{ action("EducationalInstitution\EducationalInstitutionByBusinessController@getDataAskwerForm") }}"/>

<input id="action-askwer-form-saveAskwer" type="hidden"
       value="{{ action("Askwer\AskwerFormController@saveAskwer") }}"/>
<input id="action-askwer-form-getDataSolutionsAskwer" type="hidden"
       value="{{ action("Askwer\AskwerFormController@getDataSolutionsAskwer") }}"/>

{{--INFORMATION CUSTOMER--}}
<input id="action-information-mail-saveData" type="hidden"
       value="{{action("Information\InformationMailController@saveData")}}"/>

<input id="action-information-mail-getAdmin" type="hidden"
       value="{{action("Information\InformationMailController@getAdmin")}}"/>

<input id="action-information-mail-type-getListSelect2" type="hidden"
       value="{{action("Information\InformationMailTypeController@getListSelect2")}}"/>
{{--SOCIAL NETWORKS--}}
<input id="action-information-social-network-saveData" type="hidden"
       value="{{action("Information\InformationSocialNetworkController@saveData")}}"/>

<input id="action-information-social-network-getAdmin" type="hidden"
       value="{{action("Information\InformationSocialNetworkController@getAdmin")}}"/>
<input id="action-information-social-network-type-getListSelect2" type="hidden"
       value="{{action("Information\InformationSocialNetworkTypeController@getListSelect2")}}"/>

{{--PHONE--}}
<input id="action-information-phone-saveData" type="hidden"
       value="{{action("Information\InformationPhoneController@saveData")}}"/>

<input id="action-information-phone-getAdmin" type="hidden"
       value="{{action("Information\InformationPhoneController@getAdmin")}}"/>
<input id="action-information-phone-operator-getListSelect2" type="hidden"
       value="{{action("Information\InformationPhoneOperatorController@getListSelect2")}}"/>
<input id="action-information-phone-type-getListSelect2" type="hidden"
       value="{{action("Information\InformationPhoneTypeController@getListSelect2")}}"/>

<input id="action-information-address-saveData" type="hidden"
       value="{{action("Information\InformationAddressController@saveData")}}"/>
<input id="action-information-address-getAdmin" type="hidden"
       value="{{action("Information\InformationAddressController@getAdmin")}}"/>
<input id="action-information-address-type-getListSelect2" type="hidden"
       value="{{action("Information\InformationAddressTypeController@getListSelect2")}}"/>

{{--DELIVERI--}}
<input id="action-delivery-by-business-manager-getUniqueNumberInvoice" type="hidden"
       value="{{action("DeliveryByBusinessManager\DeliveryByBusinessManagerController@getUniqueNumberInvoice")}}"/>
<input id="action-delivery-by-business-manager-saveData" type="hidden"
       value="{{action("DeliveryByBusinessManager\DeliveryByBusinessManagerController@saveData")}}"/>

<input id="action-delivery-by-business-manager-getAdmin" type="hidden"
       value="{{action("DeliveryByBusinessManager\DeliveryByBusinessManagerController@getAdmin")}}"/>
<input id="action-delivery-by-business-manager-getListCustomer" type="hidden"
       value="{{action("DeliveryByBusinessManager\DeliveryByBusinessManagerController@getListCustomer")}}"/>
<input id="action-delivery-by-business-manager-getListAddressByCustomer" type="hidden"
       value="{{action("DeliveryByBusinessManager\DeliveryByBusinessManagerController@getListAddressByCustomer")}}"/>
<input id="action-delivery-by-business-manager-getListPhoneByCustomer" type="hidden"
       value="{{action("DeliveryByBusinessManager\DeliveryByBusinessManagerController@getListPhoneByCustomer")}}"/>





{{--EVENTS TRAILS--}}
<input id="action-events-trails-project-saveData" type="hidden"
       value="{{action("EventsTrails\EventsTrailsProjectController@saveData")}}"/>

<input id="action-events-trails-project-getAdmin" type="hidden"
       value="{{action("EventsTrails\EventsTrailsProjectController@getAdmin")}}"/>

<input id="action-events-trails-types-getListSelect2" type="hidden"
       value="{{action("EventsTrails\EventsTrailsTypesController@getListSelect2")}}"/>


{{--FRONTEND--}}
<input id="action-template-information-saveData" type="hidden"
       value="{{action("Frontend\TemplateInformationController@saveData")}}"/>

<input id="action-template-information-getAdmin" type="hidden"
       value="{{action("Frontend\TemplateInformationController@getAdmin")}}"/>

<input id="action-tax-by-business-saveData" type="hidden"
       value="{{action("Tax\TaxByBusinessController@saveData")}}"/>
<input id="action-tax-by-business-getAdmin" type="hidden"
       value="{{action("Tax\TaxByBusinessController@getAdmin")}}"/>
<input id="action-tax-getListSelect2" type="hidden"
       value="{{action("Tax\TaxController@getListSelect2")}}"/>


{{--ORDERS SALES--}}

<input id="action-order-payments-manager-getAdmin" type="hidden"
       value="{{action("Orders\OrderPaymentsManagerController@getAdmin")}}"/>
<input id="action-order-payments-manager-deliverOrder" type="hidden"
       value="{{action("Orders\OrderPaymentsManagerController@deliverOrder")}}"/>

<input id="action-order-payments-manager-deliverOrder" type="hidden"
       value="{{action("Orders\OrderPaymentsManagerController@deliverOrder")}}"/>
<input id="action-order-payments-manager-changeStateBankOrder" type="hidden"
       value="{{action("Orders\OrderPaymentsManagerController@changeStateBankOrder")}}"/>

<input id="action-repair-product-by-business-saveData" type="hidden"
       value="{{action("Fix\RepairProductByBusinessController@saveData")}}"/>
<input id="action-repair-product-by-business-getAdmin" type="hidden"
       value="{{action("Fix\RepairProductByBusinessController@getAdmin")}}"/>

<!--FIX-->
<input id="action-repair-saveData" type="hidden"
       value="{{action("Fix\RepairController@saveData")}}"/>
<input id="action-repair-getAdmin" type="hidden"
       value="{{action("Fix\RepairController@getAdmin")}}"/>
<input id="action-customer-saveDataFix" type="hidden"
       value="{{ action("Crm\CustomerController@saveDataFix") }}"/>

<!--LANGUAGE-->
<input id="action-business-by-language-saveData" type="hidden"
       value="{{action("Language\BusinessByLanguageController@saveData")}}"/>
<input id="action-business-by-language-getAdmin" type="hidden"
       value="{{action("Language\BusinessByLanguageController@getAdmin")}}"/>
<input id="action-language-getListSelect2" type="hidden"
       value="{{action("Language\LanguageController@getListSelect2")}}"/>


<input id="action-language-product-saveData" type="hidden"
       value="{{action("Language\LanguageProductController@saveData")}}"/>
<input id="action-language-product-getAdmin" type="hidden"
       value="{{action("Language\LanguageProductController@getAdmin")}}"/>
<input id="action-language-product-setDelete" type="hidden"
       value="{{action("Language\LanguageProductController@setDelete")}}"/>


<input id="action-product-sizes-listSelect2" type="hidden"
       value="{{ action("Products\ProductSizesController@getListSelect2") }}"/>
<input id="action-product-color-listSelect2" type="hidden"
       value="{{ action("Products\ProductColorController@getListSelect2") }}"/>


<input id="action-business-by-discount-saveData" type="hidden"
       value="{{action("Discounts\BusinessByDiscountController@saveData")}}"/>
<input id="action-business-by-discount-getAdmin" type="hidden"
       value="{{action("Discounts\BusinessByDiscountController@getAdmin")}}"/>

<input id="action-discount-by-products-adminProducts" type="hidden"
       value="{{action("Discounts\DiscountByProductsController@getAdminProducts")}}"/>

<input id="action-discount-by-products-detailsProducts" type="hidden"
       value="{{action("Discounts\DiscountByProductsController@getDetailsProducts")}}"/>


<input id="action-business-by-shipping-rate-saveData" type="hidden"
       value="{{action("ShippingRate\BusinessByShippingRateController@saveData")}}"/>

<input id="action-business-by-shipping-rate-getAdmin" type="hidden"
       value="{{action("ShippingRate\BusinessByShippingRateController@getAdmin")}}"/>
<input id="action-shipping-rate-business-getListSelect2" type="hidden"
       value="{{action("ShippingRate\ShippingRateBusinessController@getListSelect2")}}"/>

<!--GAMIFICATION-->

<input id="action-business-by-gamification-saveData" type="hidden"
       value="{{action("Gamification\BusinessByGamificationController@saveData")}}"/>

<input id="action-business-by-gamification-getAdmin" type="hidden"
       value="{{action("Gamification\BusinessByGamificationController@getAdmin")}}"/>

<input id="action-gamification-type-activity-saveData" type="hidden"
       value="{{action("Gamification\GamificationTypeActivityController@saveData")}}"/>
<input id="action-gamification-type-activity-getAdmin" type="hidden"
       value="{{action("Gamification\GamificationTypeActivityController@getAdmin")}}"/>

<input id="action-gamification-by-process-saveData" type="hidden"
       value="{{action("Gamification\GamificationByProcessController@saveData")}}"/>
<input id="action-gamification-by-process-getAdmin" type="hidden"
       value="{{action("Gamification\GamificationByProcessController@getAdmin")}}"/>

<input id="action-gamification-type-activity-getListSelect2" type="hidden"
       value="{{action("Gamification\GamificationTypeActivityController@getListSelect2")}}"/>

<input id="action-gamification-by-rewards-saveData" type="hidden"
       value="{{action("Gamification\GamificationByRewardsController@saveData")}}"/>
<input id="action-gamification-by-rewards-getAdmin" type="hidden"
       value="{{action("Gamification\GamificationByRewardsController@getAdmin")}}"/>

<input id="action-services-getBusinessServicesListSelect2" type="hidden"
       value="{{action("Products\ProductController@getBusinessServicesListSelect2")}}"/>
<input id="action-products-getBusinessProductsListSelect2" type="hidden"
       value="{{action("Products\ProductController@getBusinessProductsListSelect2")}}"/>
<input id="action-products-getBusinessProductsServicesListSelect2" type="hidden"
       value="{{route("getBusinessProductsServicesListSelect2")}}"/>

<!--HOSPITAL-->
<input id="action-allergies-saveData" type="hidden"
       value="{{action("Hospital\AllergiesController@saveData")}}"/>
<input id="action-allergies-getAdmin" type="hidden"
       value="{{action("Hospital\AllergiesController@getAdmin")}}"/>


<input id="action-habits-saveData" type="hidden"
       value="{{action("Hospital\HabitsController@saveData")}}"/>
<input id="action-habits-getAdmin" type="hidden"
       value="{{action("Hospital\HabitsController@getAdmin")}}"/>


<input id="action-patient-saveData" type="hidden"
       value="{{action("Hospital\HistoryClinicController@saveDataProfilePatient")}}"/>
<input id="action-patient-getAdmin" type="hidden"
       value="{{action("Hospital\HistoryClinicController@getAdmin")}}"/>


<input id="action-antecedent-by-history-clinic-saveData" type="hidden"
       value="{{action("Hospital\AntecedentByHistoryClinicController@saveData")}}"/>
<input id="action-antecedent-by-history-clinic-getAdmin" type="hidden"
       value="{{action("Hospital\AntecedentByHistoryClinicController@getAdmin")}}"/>


<input id="action-medical-consultation-by-patient-saveData" type="hidden"
       value="{{action("Hospital\MedicalConsultationByPatientController@saveData")}}"/>
<input id="action-medical-consultation-by-patient-getAdmin" type="hidden"
       value="{{action("Hospital\MedicalConsultationByPatientController@getAdmin")}}"/>

<input id="action-history-clinic-getDataHistoryClinicLog" type="hidden"
       value="{{action("Hospital\HistoryClinicController@getDataHistoryClinicLog")}}"/>


{{--Product SERVICES--}}
<input id="action-product-saveDataService" type="hidden"
       value="{{action("Products\ProductController@saveDataService")}}"/>
<input id="action-product-getAdminService" type="hidden"
       value="{{action("Products\ProductController@getAdminService")}}"/>


<!--TREATMENT-->
<input id="action-treatment-by-patient-saveData" type="hidden"
       value="{{action("Hospital\TreatmentByPatientController@saveData")}}"/>
<input id="action-treatment-by-patient-getAdmin" type="hidden"
       value="{{action("Hospital\TreatmentByPatientController@getAdmin")}}"/>
<input id="action-product-getProductService" type="hidden"
       value="{{action("Products\ProductController@getProductService")}}"/>


<input id="action-treatment-by-indebtedness-paying-init-getAdmin" type="hidden"
       value="{{action("Hospital\TreatmentByIndebtednessPayingInitController@getAdmin")}}"/>
<input id="action-treatment-by-indebtedness-paying-init-saveData" type="hidden"
       value="{{action("Hospital\TreatmentByIndebtednessPayingInitController@saveData")}}"/>
<input id="action-treatment-by-indebtedness-paying-init-getManagement" type="hidden"
       value="{{action("Hospital\TreatmentByIndebtednessPayingInitController@getManagement")}}"/>


<input id="action-treatment-by-payment-getAdmin" type="hidden"
       value="{{action("Hospital\TreatmentByPaymentController@getAdmin")}}"/>
<input id="action-treatment-by-payment-saveData" type="hidden"
       value="{{action("Hospital\TreatmentByPaymentController@saveData")}}"/>
<input id="action-treatment-by-payment-getManagement" type="hidden"
       value="{{action("Hospital\TreatmentByPaymentController@getManagement")}}"/>

<input id="action-treatment-by-breakdown-payment-getListSelect2" type="hidden"
       value="{{action("Hospital\TreatmentByBreakdownPaymentController@getListSelect2")}}"/>


<!--ODONTOGRAM-->
<input id="action-odontogram-by-patient-saveData" type="hidden"
       value="{{action("Hospital\OdontogramByPatientController@saveData")}}"/>
<input id="action-odontogram-by-patient-getAdmin" type="hidden"
       value="{{action("Hospital\OdontogramByPatientController@getAdmin")}}"/>

<input id="action-reference-piece-getListSelect2" type="hidden"
       value="{{action("Odontogram\ReferencePieceController@getListSelect2")}}"/>
<input id="action-dental-piece-by-odontogram-getDataDentalPieceByOdontogramId" type="hidden"
       value="{{action("Odontogram\DentalPieceByOdontogramController@getDataDentalPieceByOdontogramId")}}"/>


<!--MAILING-->

<input id="action-mailing-template-saveData" type="hidden"
       value="{{action("Mailing\MailingTemplateController@saveData")}}"/>

<input id="action-mailing-template-getAdmin" type="hidden"
       value="{{action("Mailing\MailingTemplateController@getAdmin")}}"/>
<input id="action-mailing-template-getListSelect2" type="hidden"
       value="{{action("Mailing\MailingTemplateController@getListSelect2")}}"/>


<input id="action-business-by-history-saveData" type="hidden"
       value="{{action("Business\BusinessByHistoryController@saveData")}}"/>
<input id="action-business-by-history-getAdmin" type="hidden"
       value="{{action("Business\BusinessByHistoryController@getAdmin")}}"/>
<input id="action-business-history-by-data-saveData" type="hidden"
       value="{{action("Business\BusinessHistoryByDataController@saveData")}}"/>
<input id="action-business-history-by-data-getAdmin" type="hidden"
       value="{{action("Business\BusinessHistoryByDataController@getAdmin")}}"/>


<input id="action-business-by-menu-management-frontend-save" type="hidden"
       value="{{ action("Business\BusinessByMenuManagementFrontendController@saveData") }}"/>
<input id="action-business-by-menu-management-frontend-admin" type="hidden"
       value="{{ action("Business\BusinessByMenuManagementFrontendController@getAdmin") }}"/>
<input id="action-business-by-menu-management-frontend-listActionsParent" type="hidden"
       value="{{ action("Business\BusinessByMenuManagementFrontendController@getListActionsParent") }}"/>


<input id="action-business-by-academic-offerings-institution-saveData" type="hidden"
       value="{{route('businessByAcademicOfferingsInstitutionSaveData')}}"/>
<input id="action-business-by-academic-offerings-institution-getAdmin" type="hidden"
       value="{{route('businessByAcademicOfferingsInstitutionGetAdmin')}}"/>

<input id="action-business-by-academic-offerings-saveData" type="hidden"
       value="{{route('businessByAcademicOfferingsSaveData')}}"/>
<input id="action-business-by-academic-offerings-getAdmin" type="hidden"
       value="{{route('businessByAcademicOfferingsGetAdmin')}}"/>


<input id="action-business-academic-offerings-by-data-saveData" type="hidden"
       value="{{route('businessAcademicOfferingsByDataSaveData')}}"/>
<input id="action-business-academic-offerings-by-data-getAdmin" type="hidden"
       value="{{route('businessAcademicOfferingsByDataGetAdmin')}}"/>

<input id="action-business-academic-offerings-data-by-information-saveData" type="hidden"
       value="{{route('businessAcademicOfferingsDataByInformationSaveData')}}"/>
<input id="action-business-academic-offerings-data-by-information-getAdmin" type="hidden"
       value="{{route('businessAcademicOfferingsDataByInformationGetAdmin')}}"/>

<input id="action-business-by-partner-companies-saveData" type="hidden"
       value="{{action("Business\BusinessByPartnerCompaniesController@saveData")}}"/>
<input id="action-business-by-partner-companies-getAdmin" type="hidden"
       value="{{action("Business\BusinessByPartnerCompaniesController@getAdmin")}}"/>


<input id="action-business-by-information-custom-saveData" type="hidden"
       value="{{action("Business\BusinessByInformationCustomController@saveData")}}"/>
<input id="action-business-by-information-custom-getAdmin" type="hidden"
       value="{{action("Business\BusinessByInformationCustomController@getAdmin")}}"/>

<input id="action-business-counter-custom-saveData" type="hidden"
       value="{{action("Business\BusinessCounterCustomController@saveData")}}"/>
<input id="action-business-counter-custom-getAdmin" type="hidden"
       value="{{action("Business\BusinessCounterCustomController@getAdmin")}}"/>
<input id="action-business-counter-custom-by-data-saveData" type="hidden"
       value="{{action("Business\BusinessCounterCustomByDataController@saveData")}}"/>
<input id="action-business-counter-custom-by-data-getAdmin" type="hidden"
       value="{{action("Business\BusinessCounterCustomByDataController@getAdmin")}}"/>


<input id="action-business-by-inventory-management-saveData" type="hidden"
       value="{{route("businessByInventoryManagementSaveData")}}"/>
<input id="action-business-by-inventory-management-getDataProfileBusiness" type="hidden"
       value="{{route("businessByInventoryManagementGetDataProfileBusiness")}}"/>


<input id="action-business-by-inventory-management-subcategory-saveData" type="hidden"
       value="{{route("businessByInventoryManagementSubcategorySaveData")}}"/>
<input id="action-business-by-inventory-management-subcategory-getAdmin" type="hidden"
       value="{{route("businessByInventoryManagementSubcategoryGetAdmin")}}"/>
<input id="action-product-subcategory-getListSelect2Config" type="hidden"
       value="{{route("productSubcategoryGetListSelect2Config")}}"/>


<input id="action-business-by-frequent-question-saveData" type="hidden"
       value="{{route("businessByFrequentQuestionSaveData")}}"/>
<input id="action-business-by-frequent-question-getAdmin" type="hidden"
       value="{{route("businessByFrequentQuestionGetAdmin")}}"/>


<input id="action-business-by-requirements-saveData" type="hidden"
       value="{{route("businessByRequirementsSaveData")}}"/>
<input id="action-business-by-requirements-getAdmin" type="hidden"
       value="{{route("businessByRequirementsGetAdmin")}}"/>




@if($configPartial['typeManager']=='managerMailingTemplate')

@elseif($configPartial['typeManager']=='managerProduct')

    <input id="action-product-saveData" type="hidden"
           value="{{action("Products\ProductController@saveData")}}"/>
    <input id="action-product-getAdmin" type="hidden"
           value="{{action("Products\ProductController@getAdmin")}}"/>

    <input id="action-product-trademark-getListSelect2" type="hidden"
           value="{{action("Products\ProductTrademarkController@getListSelect2")}}"/>
    <input id="action-product-category-getListSelect2" type="hidden"
           value="{{action("Products\ProductCategoryController@getListSelect2")}}"/>
    <input id="action-product-subcategory-getListSelect2" type="hidden"
           value="{{action("Products\ProductSubcategoryController@getListSelect2")}}"/>
    <input id="action-product-measure-type-getListSelect2" type="hidden"
           value="{{action("Products\ProductMeasureTypeController@getListSelect2")}}"/>

    <input id="action-product-by-multimedia-saveData" type="hidden"
           value="{{action("Products\ProductByMultimediaController@saveData")}}"/>
    <input id="action-product-by-multimedia-getAdmin" type="hidden"
           value="{{action("Products\ProductByMultimediaController@getAdmin")}}"/>

    <input id="action-product-save-data-input-output-saveData" type="hidden"
           value="{{route("productSaveDataInputOutput")}}"/>

    <input id="action-product-by-route-map-saveData" type="hidden"
           value="{{action("Products\ProductByRouteMapController@saveData")}}"/>

    <input id="action-routes-map-getListSelect2" type="hidden"
           value="{{action("Routes\BusinessByRoutesMapController@getListSelect2")}}"/>
    <input id="action-product-by-route-map-getRouteProduct" type="hidden"
           value="{{action("Products\ProductByRouteMapController@getRouteProduct")}}"/>
    <input id="action-product-by-route-map-deleteRouteProduct" type="hidden"
           value="{{action("Products\ProductByRouteMapController@deleteRouteProduct")}}"/>
@elseif($configPartial['typeManager']=='managerProductManager') <!--BUSINESS-MANAGER-ACTIONS-CRUD--PRODUCT-MANAGER--->

{{--Products--}}
<input id="action-product-manager-saveData" type="hidden"
       value="{{route("productParentSave")}}"/>
<input id="action-product-manager-getAdmin" type="hidden"
       value="{{route("productParentGetAdmin")}}"/>

<input id="action-product_parent_by_product_manager-getAdmin" type="hidden"
       value="{{route("productParentByProductGetAdmin")}}"/>

<input id="action-product_parent_by_product-saveData" type="hidden"
       value="{{route("productParentByProductSave")}}"/>
<input id="action-product_by_multimedia-addMultimedia" type="hidden"
       value="{{route("productByMultimediaAddMultimedia")}}"/>

<input id="action-product_by_multimedia-removeMultimedia" type="hidden"
       value="{{route("productByMultimediaRemoveMultimedia")}}"/>


<input id="action-product_parent_by_package_params-saveData" type="hidden"
       value="{{route("productParentByPackageParamsSave")}}"/>
<input id="action-product_parent_by_package_params-deleteData" type="hidden"
       value="{{route("productParentByPackageParamsSaveDelete")}}"/>
<input id="action-product_parent_by_prices-saveData" type="hidden"
       value="{{route("productParentByPricesSave")}}"/>
<input id="action-product_parent_by_prices-deleteData" type="hidden"
       value="{{route("productParentByPricesSaveDelete")}}"/>


<input id="action-product_by_log_inventory-saveData" type="hidden"
       value="{{route("productByLogInventorySave")}}"/>
<input id="action-product_by_meta_data-saveData" type="hidden"
       value="{{route("productByMetaDataSave")}}"/>

<input id="action-product-trademark-getListSelect2" type="hidden"
       value="{{action("Products\ProductTrademarkController@getListSelect2")}}"/>
<input id="action-product-category-getListSelect2" type="hidden"
       value="{{action("Products\ProductCategoryController@getListSelect2")}}"/>
<input id="action-product-subcategory-getListSelect2" type="hidden"
       value="{{action("Products\ProductSubcategoryController@getListSelect2")}}"/>
<input id="action-product-measure-type-getListSelect2" type="hidden"
       value="{{action("Products\ProductMeasureTypeController@getListSelect2")}}"/>

<input id="action-product-by-multimedia-saveData" type="hidden"
       value="{{action("Products\ProductByMultimediaController@saveData")}}"/>
<input id="action-product-by-multimedia-getAdmin" type="hidden"
       value="{{action("Products\ProductByMultimediaController@getAdmin")}}"/>

<input id="action-product-manager-save-data-input-output-saveData" type="hidden"
       value="{{route("productSaveDataInputOutput")}}"/>

<input id="action-product-by-route-map-saveData" type="hidden"
       value="{{action("Products\ProductByRouteMapController@saveData")}}"/>

<input id="action-routes-map-getListSelect2" type="hidden"
       value="{{action("Routes\BusinessByRoutesMapController@getListSelect2")}}"/>
<input id="action-product-by-route-map-getRouteProduct" type="hidden"
       value="{{action("Products\ProductByRouteMapController@getRouteProduct")}}"/>
<input id="action-product-by-route-map-deleteRouteProduct" type="hidden"
       value="{{action("Products\ProductByRouteMapController@deleteRouteProduct")}}"/>


@elseif($configPartial['typeManager']=='managerPointOfSale')


@elseif($configPartial['typeManager']=='managerDashboard')
@elseif($configPartial['typeManager']=='managerBusinessByShippingRate')
@elseif($configPartial['typeManager']=='managerPointOfSale')
    <!--SALES-->
    {{--POINT OF SALES--}}
    <input id="action-customer-getListCustomers" type="hidden"
           value="{{route("getListCustomersPointOfSales")}}"/>
    <input id="action-products-getListProductServicesPointOfSales" type="hidden"
           value="{{route("getListProductServicesPointOfSales")}}"/>

    <input id="action-invoice-sales-getValidateInvoiceExistPointOfSales" type="hidden"
           value="{{route("getValidateInvoiceExistPointOfSales")}}"/>
    <input id="action-invoice-sales-getValidateInvoiceExistPointOfSales" type="hidden"
           value="{{route("getValidateInvoiceExistPointOfSales")}}"/>

    <input id="action-invoice-sales-saveInvoicePointOfSales" type="hidden"
           value="{{route("saveInvoicePointOfSales")}}"/>

    <input id="action-retention-tax-type-getTypeRetentionsByTaxPointOfSales" type="hidden"
           value="{{route("getTypeRetentionsByTaxPointOfSales")}}"/>

    <input id="action-retention-tax-sub-type-getListSubTRIPointOfSales" type="hidden"
           value="{{route("getListSubTRIPointOfSales")}}"/>
@elseif($configPartial['typeManager']=='managerInvoiceSale')

    <input id="action-invoice-sales-getInvoiceSaleAdmin" type="hidden"
           value="{{route("getInvoiceSaleAdmin")}}"/>
    <input id="action-invoice-sales-saveAnnulmentBilling" type="hidden"
           value="{{route("saveAnnulmentBilling")}}"/>

    <input id="action-invoice-sales-saveIndebtednessInit" type="hidden"
           value="{{route("saveIndebtednessInit")}}"/>

    <!--    PAYMENTS PAGOS BY  INIT-->
    <input id="action-invoiceSaleByPayment-getAdminPayments" type="hidden"
           value="{{route("getAdminPayments")}}"/>

    <!--    PAYMENTS-->
    <input id="action-invoiceSaleByPayment-savePaymentInvoiceDebit" type="hidden"
           value="{{route("savePaymentInvoiceDebit")}}"/>
    <input id="action-invoiceSaleByBreakDownPayment-getPaymentsCurrentS2" type="hidden"
           value="{{route("getPaymentsCurrentS2")}}"/>
    <input id="action-typesPayments-getPaymentsCurrentS2" type="hidden"
           value="{{route("getTypesPaymentsS2")}}"/>
    <input id="action-typesPaymentsByAccount-getAccountingPaymentsS2" type="hidden"
           value="{{route("getAccountingPaymentsS2")}}"/>
@elseif($configPartial['typeManager']=='managerInformation')
@elseif($configPartial['typeManager']=='managerBusinessByLanguage')
@elseif($configPartial['typeManager']=='managerBusinessByHistory')
@elseif($configPartial['typeManager']=='managerBusinessByMenuManagementFrontend')
@elseif($configPartial['typeManager']=='managerBusinessByAcademicOfferings')
@elseif($configPartial['typeManager']=='managerBusinessByAcademicOfferingsInstitution')
@elseif($configPartial['typeManager']=='managerBusinessByInformationCustom')
@elseif($configPartial['typeManager']=='managerBusinessCounterCustom')
@elseif($configPartial['typeManager']=='managerBusinessByFrequentQuestion')
@elseif($configPartial['typeManager']=='managerBusinessByRequirements')
@elseif($configPartial['typeManager']=='managerBusinessByPartnerCompanies')
@elseif($configPartial['typeManager']=='managerTaxByBusiness')
@elseif($configPartial['typeManager']=='managerEventsTrailsProject')
@elseif($configPartial['typeManager']=='managerOrderPaymentsManager')
@elseif($configPartial['typeManager']=='managerTemplateInformation')
@elseif($configPartial['typeManager']=='managerProductService')
@elseif($configPartial['typeManager']=='managerBusinessByDiscount')
@elseif($configPartial['typeManager']=='managerBusinessBySchedule')
@elseif($configPartial['typeManager']=='managerGallery')
@elseif($configPartial['typeManager']=='managerRoutes')
@elseif($configPartial['typeManager']=='managerPanorama')

@elseif($configPartial['typeManager']=='managerHumanResourcesScheduleType')

    <input id="action-human-resources-permission-type-admin" type="hidden"
           value="@php
 $controlUrl="PayRoll".'/'.$managerProcessName.'Controller'.'@'.'getAdmin';
 $controlUrl= str_replace("/", '\**', $controlUrl);
 $controlUrl= str_replace("**", '', $controlUrl);

 echo action($controlUrl)
  @endphp "/>

    <input id="action-human-resources-permission-type-save" type="hidden"
           value="@php
 $controlUrl="PayRoll".'/'.$managerProcessName.'Controller'.'@'.'saveData';
 $controlUrl= str_replace("/", '\**', $controlUrl);
 $controlUrl= str_replace("**", '', $controlUrl);
 echo action($controlUrl)
  @endphp "/>

@elseif($configPartial['typeManager']=='managerHumanResourcesPermissionType')

    <input id="action-human-resources-permission-type-admin" type="hidden"
           value="@php
 $controlUrl="PayRoll".'/'.$managerProcessName.'Controller'.'@'.'getAdmin';
 $controlUrl= str_replace("/", '\**', $controlUrl);
 $controlUrl= str_replace("**", '', $controlUrl);

 echo action($controlUrl)
  @endphp "/>

    <input id="action-human-resources-permission-type-save" type="hidden"
           value="@php
 $controlUrl="PayRoll".'/'.$managerProcessName.'Controller'.'@'.'saveData';
 $controlUrl= str_replace("/", '\**', $controlUrl);
 $controlUrl= str_replace("**", '', $controlUrl);
 echo action($controlUrl)
  @endphp "/>


@elseif($configPartial['typeManager']=='managerHelpDeskTypes')

    <input id="action-help-desk-types-saveData" type="hidden"
           value="{{action("Helpdesk\HelpdeskTypesController@saveData") }}"/>
    <input id="action-human-resources-organizational-chart-area-admin" type="hidden"
           value="{{action("Helpdesk\HelpdeskTypesController@getAdmin") }}"/>
@elseif($configPartial['typeManager']=='managerWorkPlanningHeader')
    <input id="action-work-planning-header-admin" type="hidden"
           value="{{ action("WorkPlanning\WorkPlanningHeaderController@getAdmin") }}"/>
    <input id="action-work-planning-header-save" type="hidden"
           value="{{ action("WorkPlanning\WorkPlanningHeaderController@saveData") }}"/>

    <input id="action-work-planning-header-by-resources-admin" type="hidden"
           value="{{ action("WorkPlanning\WorkPlanningHeaderByResourcesController@getAdmin") }}"/>
    <input id="action-work-planning-header-by-resources-save" type="hidden"
           value="{{ action("WorkPlanning\WorkPlanningHeaderByResourcesController@saveData") }}"/>
@elseif($configPartial['typeManager']=='managerProjectHeader')
    <input id="action-project-header-admin" type="hidden"
           value="{{ action("Projects\ProjectHeaderController@getAdmin") }}"/>
    <input id="action-project-header-save" type="hidden"
           value="{{ action("Projects\ProjectHeaderController@saveData") }}"/>

    <input id="action-project-header-by-resources-admin" type="hidden"
           value="{{ action("Projects\ProjectHeaderByResourcesController@getAdmin") }}"/>
    <input id="action-project-header-by-resources-save" type="hidden"
           value="{{ action("Projects\ProjectHeaderByResourcesController@saveData") }}"/>

    <input id="action-country-getListS2Countries" type="hidden"
           value="{{ action("Geography\CountryController@getListS2Countries") }}"/>
    <input id="action-human-resources-employee-profile-getFullNameListDataAreaAll" type="hidden"
           value="{{ action("HumanResources\HumanResourcesEmployeeProfileController@getFullNameListDataAreaAll") }}"/>

@elseif($configPartial['typeManager']=='managerHumanResourcesOrganizationalChartArea')
    {{----}}
    <input id="action-human-resources-organizational-chart-area-admin" type="hidden"
           value="{{ action("HumanResources\HumanResourcesOrganizationalChartAreaController@getAdmin") }}"/>
    <input id="action-human-resources-organizational-chart-area-save" type="hidden"
           value="{{ action("HumanResources\HumanResourcesOrganizationalChartAreaController@saveData") }}"/>
    <input id="action_actions_listActionsParent" type="hidden"
           value="{{ action("HumanResources\HumanResourcesOrganizationalChartAreaController@getListActionsParent") }}"/>

    <input id="action-human-resources-employee-profile-getFullNameListDataAreaAll" type="hidden"
           value="{{ action("HumanResources\HumanResourcesEmployeeProfileController@getFullNameListDataAreaAll") }}"/>




    <input id="action-human-resources-organizational-chart-area-by-manager-save" type="hidden"
           value="{{ action("HumanResources\HumanResourcesOrganizationalChartAreaByManagerController@saveData") }}"/>
    <input id="action-human-resources-organizational-chart-area-by-manager-getResponsible" type="hidden"
           value="{{ action("HumanResources\HumanResourcesOrganizationalChartAreaByManagerController@getResponsible") }}"/>

    <input id="action-human-resources-department-by-organizational-chart-area-save" type="hidden"
           value="{{ action("HumanResources\HumanResourcesDepartmentByOrganizationalChartAreaController@saveData") }}"/>
    <input id="action-human-resources-department-by-organizational-chart-area-getDataByChartArea" type="hidden"
           value="{{ action("HumanResources\HumanResourcesDepartmentByOrganizationalChartAreaController@getDataByChartArea") }}"/>
    <input id="action-human-resources-department-listAllArea" type="hidden"
           value="{{ action("HumanResources\HumanResourcesDepartmentController@getListAllArea") }}"/>

@elseif($configPartial['typeManager']=='managerHumanResourcesDepartment')
    {{--Human Resources --}}
    <input id="action-human-resources-department-admin" type="hidden"
           value="{{ action("HumanResources\HumanResourcesDepartmentController@getAdmin") }}"/>
    <input id="action-human-resources-department-save" type="hidden"
           value="{{ action("HumanResources\HumanResourcesDepartmentController@saveData") }}"/>

    <input id="action-human-resources-department-by-manager-save" type="hidden"
           value="{{ action("HumanResources\HumanResourcesDepartmentByManagerController@saveData") }}"/>
    <input id="action-human-resources-department-by-manager-getResponsible" type="hidden"
           value="{{ action("HumanResources\HumanResourcesDepartmentByManagerController@getResponsible") }}"/>
    <input id="action-human-resources-organizational-chart-area-listAll" type="hidden"
           value="{{ action("HumanResources\HumanResourcesOrganizationalChartAreaController@getListData") }}"/>

    <input id="action-human-resources-employee-profile-getFullNameListDataDepartmentAll" type="hidden"
           value="{{ action("HumanResources\HumanResourcesEmployeeProfileController@getFullNameListDataDepartmentAll") }}"/>

@elseif($configPartial['typeManager']=='managerHumanResourcesEmployeeProfile')
    {{--
 BUSINESS USER EMPLOYEE--}}
    {{--PROFILE EMPLOYEE--}}
    <input id="action-human-resources-employee-profile-admin" type="hidden"
           value="{{ action("HumanResources\HumanResourcesEmployeeProfileController@getAdmin") }}"/>
    <input id="action-human-resources-employee-profile-save" type="hidden"
           value="{{ action("HumanResources\HumanResourcesEmployeeProfileController@saveData") }}"/>
    <input id="action-human-resources-department-listAll" type="hidden"
           value="{{ action("HumanResources\HumanResourcesDepartmentController@getListByAreaAll") }}"/>
    <input id="action-business-by-employee-profile-save" type="hidden"
           value="{{ action("HumanResources\BusinessByEmployeeProfileController@saveData") }}"/>
    <input id="action-roles-listAll" type="hidden"
           value="{{ action("Users\RoleController@getListAll") }}"/>
    {{--USERS--}}
    <input id="action-users-uniqueUserName" type="hidden"
           value="{{ action("Users\UserController@uniqueUserName") }}"/>
    <input id="action-users-uniqueUserEmail" type="hidden"
           value="{{ action("Users\UserController@uniqueUserEmail") }}"/>
    <input id="action-users-equalsUserPassword" type="hidden"
           value="{{ action("Users\UserController@equalsUserPassword") }}"/>

    <input id="action-human-resources-schedule-type-listAll" type="hidden"
           value="{{ action("PayRoll\HumanResourcesScheduleTypeController@getListData") }}"/>

    <input id="action-human-resources-organizational-chart-area-listAll" type="hidden"
           value="{{ action("HumanResources\HumanResourcesOrganizationalChartAreaController@getListData") }}"/>
@elseif($configPartial['typeManager']=='managerCustomer')

    {{--CRM--}}
    <input id="action-customer-save" type="hidden"
           value="{{ action("Crm\CustomerController@saveData") }}"/>
    <input id="action-customer-getAdmin" type="hidden"
           value="{{ action("Crm\CustomerController@getAdmin") }}"/>
    <input id="action-customer-getListS2InformationAddress" type="hidden"
           value="{{ action("Crm\CustomerController@getListS2InformationAddress") }}"/>

    <input id="action-mailing-by-data-send-saveDataSend" type="hidden"
           value="{{action("Mailing\MailingByDataSendController@saveDataSend")}}"/>
    <input id="action-customer-getAdminEmails" type="hidden"
           value="{{ action("Crm\CustomerController@getAdminEmails") }}"/>
@elseif($configPartial['typeManager']=='managerCustomerPresentation')

    {{--BUSINESS-MANAGER-CRM-CUSTOMER-PRESENTATION-ACTIONS--}}
    <input id="action-{{$configProcess['entity-process-down']}}-save" type="hidden"
           value="{{ route($configProcess['entityCamel'].'Save') }}"/>
    <input id="action-{{$configProcess['entity-process-down']}}-getAdmin" type="hidden"
           value="{{route($configProcess['entityCamel'].'Admin') }}"/>

    <input id="action-customer-getListS2Customer" type="hidden"
           value="{{ action("Crm\CustomerController@getListS2Customer") }}"/>

    <input id="action-customer-save" type="hidden"
           value="{{ route("customerDataSave") }}"/>
@elseif($configPartial['typeManager']=='managerCustomerData')

    {{--CRM--}}
    <input id="action-customer-save" type="hidden"
           value="{{ route("customerDataSave") }}"/>
    <input id="action-customer-getAdmin" type="hidden"
           value="{{ route("customerDataGetAdmin") }}"/>
    <input id="action-customer-getListS2InformationAddress" type="hidden"
           value="{{ action("Crm\CustomerController@getListS2InformationAddress") }}"/>

    <input id="action-mailing-by-data-send-saveDataSend" type="hidden"
           value="{{route("saveDataSendData")}}"/>
    <input id="action-customer-getAdminEmails" type="hidden"
           value="{{ route("getAdminEmailsRegisters") }}"/>


    <input id="action-event-by-assistance-saveData" type="hidden"
           value="{{route("saveDataAssistance")}}"/>
    <input id="action-event-by-assistance-getAdmin" type="hidden"
           value="{{ route("getEventsAssistanceAdmin") }}"/>


@elseif($configPartial['typeManager']=='managerRepairProductByBusiness')
@elseif($configPartial['typeManager']=='managerRepair')
@elseif($configPartial['typeManager']=='managerLodgingTypeOfRoom')
@elseif($configPartial['typeManager']=='managerLodgingRoomLevels')
@elseif($configPartial['typeManager']=='managerLodgingRoomFeatures')
@elseif($configPartial['typeManager']=='managerLodgingTypeOfRoomByPrice')
@elseif($configPartial['typeManager']=='managerLodgingStatisticalData')
@elseif($configPartial['typeManager']=='managerLodging')
@elseif($configPartial['typeManager']=='managerEducationalInstitutionAskwerType')
@elseif($configPartial['typeManager']=='managerEducationalInstitutionByBusiness')
@elseif($configPartial['typeManager']=='managerBusinessByGamification')
@elseif($configPartial['typeManager']=='managerGamificationTypeActivity')
@elseif($configPartial['typeManager']=='managerAntecedent')
@elseif($configPartial['typeManager']=='managerClinicalExam')
@elseif($configPartial['typeManager']=='managerAllergies')
@elseif($configPartial['typeManager']=='managerHabits')

@elseif($configPartial['typeManager']=='managerPatient')

@elseif($configPartial['typeManager']=='managerMikrotikRateLimit')
    <input id="action-mikrotik-rate-limit-saveData" type="hidden"
           value="{{action("Mikrotik\MikrotikRateLimitController@saveData")}}"/>

    <input id="action-mikrotik-rate-limit-getAdmin" type="hidden"
           value="{{action("Mikrotik\MikrotikRateLimitController@getAdmin")}}"/>
@elseif($configPartial['typeManager']=='managerMikrotikTypeConection')
    <input id="action-mikrotik-type-conection-saveData" type="hidden"
           value="{{action("Mikrotik\MikrotikTypeConectionController@saveData")}}"/>

    <input id="action-mikrotik-type-conection-getAdmin" type="hidden"
           value="{{action("Mikrotik\MikrotikTypeConectionController@getAdmin")}}"/>
@elseif($configPartial['typeManager']=='managerMikrotikByCustomerEngagement')
    <input id="action-mikrotik-by-customer-engagement-saveData" type="hidden"
           value="{{action("Mikrotik\MikrotikByCustomerEngagementController@saveData")}}"/>
    <input id="action-mikrotik-by-customer-engagement-getAdmin" type="hidden"
           value="{{action("Mikrotik\MikrotikByCustomerEngagementController@getAdmin")}}"/>

    <input id="action-customer-getListSelect2" type="hidden"
           value="{{route("getListCustomersMikrotiks")}}"/>

    <input id="action-invoice-sale-getListSelect2" type="hidden"
           value="{{route("getInvoiceList")}}"/>
    <input id="action-mikrotik-rate-limit-getListSelect2" type="hidden"
           value="{{action("Mikrotik\MikrotikRateLimitController@getListSelect2")}}"/>
    <input id="action-mikrotik-dhcp-server-getListSelect2" type="hidden"
           value="{{action("Mikrotik\MikrotikDhcpServerController@getListSelect2")}}"/>

    <input id="action-mikrotik-by-customer-engagement-managerDisabledEnabledCustomer" type="hidden"
           value="{{route("managerDisabledEnabledCustomer")}}"/>
@elseif($configPartial['typeManager']=='managerMikrotikDhcpServer')
    <input id="action-mikrotik-dhcp-server-saveData" type="hidden"
           value="{{action("Mikrotik\MikrotikDhcpServerController@saveData")}}"/>
    <input id="action-mikrotik-dhcp-server-getAdmin" type="hidden"
           value="{{action("Mikrotik\MikrotikDhcpServerController@getAdmin")}}"/>
    <input id="action-mikrotik-type-conection-getListSelect2" type="hidden"
           value="{{action("Mikrotik\MikrotikTypeConectionController@getListSelect2")}}"/>

@endif
<?php
$actionUpdate = action("Housing\LodgingController@updateBusiness");
$urlAction = action("Housing\LodgingController@updateBusiness");
$accessAction = $actionUpdate;
$allowAction = true;
$updateConfig = array(
    'url' => $urlAction,
    'i-class' => " fas fa-pencil-alt",
    'title' => "Actualizar",
    "allow" => $allowAction,
    "data-toggle" => "tooltip", 'data-placement' => "top",
    "command-class" => 'btn a-meet-update btn-xs',
    'button-class' => "btn-warning",
    'managerType' => "updateEntity",
    "viewManager" => false,
    "managerButton" => true,
);

$actionUpdate = action("Housing\LodgingByPaymentController@savePayment");
$urlAction = action("Housing\LodgingByPaymentController@savePayment");
$accessAction = $actionUpdate;
$allowAction = true;
$paymentConfig = array(
    'url' => $urlAction,
    'i-class' => " fas fa-money-bill-alt",
    'title' => "Gestion Pagos",
    "allow" => $allowAction,
    "data-toggle" => "tooltip", 'data-placement' => "top",
    "command-class" => 'btn a-meet-update btn-xs',
    'button-class' => "btn-warning",
    'managerType' => "paymentEntity",
    "viewManager" => false,
    "managerButton" => true,
);

$action = action("Housing\LodgingByArrivedController@saveArrived");
$urlAction = action("Housing\LodgingByArrivedController@saveArrived");
$accessAction = $action;
$allowAction = true;
$arrivedConfig = array(
    'url' => $urlAction,
    'i-class' => " fab fa-speakap",
    'title' => "Recopilación Informativa",
    "allow" => $allowAction,
    "data-toggle" => "tooltip", 'data-placement' => "top",
    "command-class" => 'btn  btn-xs',
    'button-class' => "btn-warning",
    'managerType' => "arrivedEntity",
    "viewManager" => false,
    "managerButton" => true,
);

$action = action("Housing\BusinessByLodgingByPriceController@getListRooms");
$urlAction = action("Housing\BusinessByLodgingByPriceController@getListRooms");
$accessAction = $action;
$allowAction = true;
$roomsEntityConfig = array(
    'url' => $urlAction,
    'i-class' => "fa fa-building",
    'title' => "Asignación de Habitaciones ",
    "allow" => $allowAction,
    "data-toggle" => "tooltip", 'data-placement' => "top",
    "command-class" => 'btn  btn-xs',
    'button-class' => "btn-warning",
    'managerType' => "roomsEntity",
    "viewManager" => false,
    "managerButton" => true,
);

$action = action("Housing\LodgingController@delivery");
$urlAction = action("Housing\LodgingController@delivery");
$accessAction = $action;
$allowAction = true;
$deliveryConfig = array(
    'url' => $urlAction,
    'i-class' => "fa fa-thumbs-up",
    'title' => "Entregar Habitaciones ",
    "allow" => $allowAction,
    "data-toggle" => "tooltip", 'data-placement' => "top",
    "command-class" => 'btn  btn-xs',
    'button-class' => "btn-warning",
    'managerType' => "delivery",
    "viewManager" => false,
    "managerButton" => true,
);
$EntityInfoData = array();
$EntityButtons["actions"]["update"] = $updateConfig;
$EntityButtons["actions"]["paymentEntity"] = $paymentConfig;
$EntityButtons["actions"]["arrivedEntity"] = $arrivedConfig;
$EntityButtons["actions"]["roomsEntity"] = $roomsEntityConfig;
$EntityButtons["actions"]["deliveryConfig"] = $deliveryConfig;

$buttonsManagements = array();
foreach ($EntityButtons["actions"] as $key => $value) {

    if ($value['allow']) {
        if (isset($value['managerButton'])) {
            $buttonsManagements[] = $value;

        }
    }
}
$configModelEntity["buttonsManagements"] = $buttonsManagements;
$configModelEntity["EntityInfoData"] = $EntityInfoData;


?>
<script>
    var $configModelEntityLodging = <?php
                                    echo
                                    json_encode($configModelEntity);
                                    ?>;
</script>
