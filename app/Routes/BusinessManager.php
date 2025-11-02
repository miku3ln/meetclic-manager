<?php
//CPP-012
namespace App\Routes;

use Route;

class BusinessManager
{
    public function __construct(array $attributes = [])
    {

        $this->initRoutes([]);
    }

    public function initRoutes($params)//BUSINESS-MANAGER-TEMPLATE-ROUTES
    {

        Route::group(['middleware' => ['auth', 'auth.business']], function () {

            Route::get('mintonPages/eccomerceProducts', 'MintonPages\MintonPagesController@getEccomerceProducts'); //


            Route::get('dashboardManager', 'HomeController@index')->name('dashboardManager');

            /*    Route::get('home', 'DashboardController@index');*/
            Route::get('/dashboardManager', 'HomeController@index')->name('dashboardManager');
            /*
             * Roles y Usuarios
             */
            Route::get('user', 'Users\UserController@getIndex'); //
            Route::get('user/list', 'Users\UserController@getListUsers'); //
            Route::get('user/form', 'Users\UserController@getFormUser'); //
            Route::get('user/form/{id?}', 'Users\UserController@getFormUser'); //
            Route::post('user/unique-email', 'Users\UserController@postIsEmailUnique'); //
            Route::post('user/unique-username', 'Users\UserController@postIsUsernameUnique'); //
            Route::post('user/save', 'Users\UserController@postSave'); //
            Route::post('user/check-password-old', 'Users\UserController@postCheckPasswordOld'); //

            Route::post('user/unique/username', 'Users\UserController@uniqueUserName'); //
            Route::post('user/unique/email', 'Users\UserController@uniqueUserEmail'); //
            Route::post('user/equals/password', 'Users\UserController@equalsUserPassword'); //
            Route::post('user/equals/changePassword', 'Users\UserController@equalsUserChangePassword'); //
            Route::post('user/save/changePassword', 'Users\UserController@userSaveChangePassword');
            Route::get('role', 'Users\RoleController@getIndex'); //
            Route::get('role/list', 'Users\RoleController@getListRoles'); //
            Route::get('role/list/select', 'Users\RoleController@getListSelect2'); //

            Route::get('role/form', 'Users\RoleController@getFormRole'); //
            Route::get('role/form/{id?}', 'Users\RoleController@getFormRole'); //
            Route::post('role/unique-name', 'Users\RoleController@postIsNameUnique'); //
            Route::post('role/save', 'Users\RoleController@postSave'); //

            Route::post('actions/save', 'Users\ActionsController@saveData'); //
            Route::post('actions/admin', 'Users\ActionsController@getAdmin'); //
            Route::get('actions/manager', 'Users\ActionsController@getManager'); //
            Route::get('actions/listActionsParent', 'Users\ActionsController@getListActionsParent'); //


            /*
             * Location
             */
            Route::get('country', 'Geography\CountryController@index'); //
            Route::get('country/form', 'Geography\CountryController@getFormCountry'); //
            Route::get('country/form/{id?}', 'Geography\CountryController@getFormCountry'); //
            Route::get('country/list', 'Geography\CountryController@getListCountries'); //
            Route::get('country/list/select', 'Geography\CountryController@getListSelect2'); //
            Route::post('country/unique-name', 'Geography\CountryController@postIsNameUnique'); //
            Route::post('country/save', 'Geography\CountryController@postSave'); //
            Route::get('country/list/select2', 'Geography\CountryController@getListS2Countries'); //

            Route::get('province', 'Geography\ProvinceController@index'); //
            Route::get('province/form', 'Geography\ProvinceController@getFormProvince'); //
            Route::get('province/form/{id?}', 'Geography\ProvinceController@getFormProvince'); //
            Route::get('province/list', 'Geography\ProvinceController@getListProvinces');
            Route::get('province/list/select', 'Geography\ProvinceController@getListSelect2'); //
            Route::post('province/unique-name', 'Geography\ProvinceController@postIsNameUnique'); //
            Route::post('province/save', 'Geography\ProvinceController@postSave'); //

            Route::get('city', 'Geography\CityController@index'); //
            Route::get('city/form', 'Geography\CityController@getFormCity'); //
            Route::get('city/form/{id?}', 'Geography\CityController@getFormCity'); //
            Route::get('city/list', 'Geography\CityController@getListCities'); //
            Route::get('city/list/select', 'Geography\CityController@getListSelect2'); //
            Route::post('city/unique-name', 'Geography\CityController@postIsNameUnique'); //
            Route::post('city/save', 'Geography\CityController@postSave'); //

            Route::get('zone', 'Geography\ZoneController@index'); //
            Route::get('zone/form/{id?}', 'Geography\ZoneController@getFormZone'); //
            Route::get('zone/list', 'Geography\ZoneController@getListZones'); //
            Route::get('zone/list/map', 'Geography\ZoneController@getListZonesMap'); //
            Route::post('zone/save', 'Geography\ZoneController@postSave'); //
            Route::post('zone/unique-name', 'Geography\ZoneController@postIsNameUnique'); //
            Route::post('zone/save/zones', 'Geography\ZoneController@postSaveZones');

            /*
             * Products
             */
            Route::get('product', 'Products\ProductController@index'); //
            Route::get('product/list', 'Products\ProductController@getListProducts'); //
            Route::get('product/form', 'Products\ProductController@getFormProduct'); //
            Route::get('product/form/{id?}', 'Products\ProductController@getFormProduct'); //
            Route::post('product/unique-name', 'Products\ProductController@postIsNameUnique'); //
            Route::post('product/save', 'Products\ProductController@postSave'); //
            Route::post('image/upload', 'Products\ImageController@postUpload'); //
            Route::post('image/delete/{id?}', 'Products\ImageController@deleteImage'); //


            Route::post('productParent/save', 'ProductDistributions\ProductParentController@saveData')->name('productParentSave');
            Route::post('productParent/getAdmin', 'ProductDistributions\ProductParentController@getAdmin')->name('productParentGetAdmin'); //


            Route::post('productParentByPrices/save', 'ProductDistributions\ProductParentByPricesController@saveData')->name('productParentByPricesSave');
            Route::post('productParentByPrices/saveDelete', 'ProductDistributions\ProductParentByPricesController@saveDataDelete')->name('productParentByPricesSaveDelete');

            Route::post('productParentByPackageParams/save', 'ProductDistributions\ProductParentByPackageParamsController@saveData')->name('productParentByPackageParamsSave');
            Route::post('productParentByPackageParams/saveDelete', 'ProductDistributions\ProductParentByPackageParamsController@saveDataDelete')->name('productParentByPackageParamsSaveDelete');

            Route::post('productParentByProduct/save', 'ProductDistributions\ProductParentByProductController@saveData')->name('productParentByProductSave');
            Route::post('productParentByProduct/getAdmin', 'ProductDistributions\ProductParentByProductController@getAdmin')->name('productParentByProductGetAdmin');

            Route::post('productByLogInventory/save', 'ProductDistributions\ProductByLogInventoryController@saveData')->name('productByLogInventorySave');
            Route::post('productByMetaData/save', 'ProductDistributions\ProductByMetaDataController@saveData')->name('productByMetaDataSave');
            Route::post('productByMultimedia/addMultimedia/{id?}', 'Products\ProductByMultimediaController@addMultimedia')->name('productByMultimediaAddMultimedia');
            Route::post('productByMultimedia/removeMultimedia/{id?}', 'Products\ProductByMultimediaController@removeMultimedia')->name('productByMultimediaRemoveMultimedia');


            Route::get('category', 'Products\CategoryController@index'); //
            Route::get('category/form', 'Products\CategoryController@getFormCategory'); //
            Route::get('category/form/{id?}', 'Products\CategoryController@getFormCategory'); //
            Route::get('category/list', 'Products\CategoryController@getListCategories'); //
            Route::get('category/list/select', 'Products\CategoryController@getListSelect2'); //
            Route::post('category/unique-name', 'Products\CategoryController@postIsNameUnique'); //
            Route::post('category/save', 'Products\CategoryController@postSave'); //

            /*
             * Price By Zone
             */
            Route::get('price', 'Products\PriceByZoneController@index'); //
            Route::get('price/list', 'Products\PriceByZoneController@getListPrices'); //
            Route::post('price/save', 'Products\PriceByZoneController@postSave'); //


            /*
             * taxes
             */
            Route::get('tax', 'Taxes\TaxController@index'); //
            Route::get('tax/form', 'Taxes\TaxController@getFormTax'); //
            Route::get('tax/form/{id?}', 'Taxes\TaxController@getFormTax'); //
            Route::get('tax/list', 'Taxes\TaxController@getListTaxes'); //
            Route::get('tax/list/select', 'Taxes\TaxController@getListSelect2'); //
            Route::get('tax/cities/{id?}', 'Taxes\TaxController@getListCitiesByTax'); //
            Route::post('tax/unique-name', 'Taxes\TaxController@postIsNameUnique'); //
            Route::post('tax/save', 'Taxes\TaxController@postSave'); //

            /* CLINICAL DENTAL*/

            /*
             * Patient
             * */
            Route::get('patient', 'Hospital\PatientController@index'); //
            Route::get('patient/form', 'Hospital\PatientController@getFormPatient'); //
            Route::get('patient/form-modal', 'Hospital\PatientController@getFormPatientModal'); //
            Route::get('patient/form/{id?}', 'Hospital\PatientController@getFormPatient'); //
            Route::get('patient/form-modal/{id?}', 'Hospital\PatientController@getFormPatientModal'); //
            Route::get('patient/list', 'Hospital\PatientController@getListPatients'); //
            Route::get('patient/details/{id?}', 'Hospital\PatientController@getDetailsPatient'); //
            Route::get('patient/details/step1/{id?}', 'Hospital\PatientController@getDetailsPatientStep1'); //
            Route::get('patient/list/select', 'Hospital\PatientController@getListSelect2'); //
            Route::post('patient/save', 'Hospital\PatientController@postSave'); //
            Route::post('patient/valid-document', 'Hospital\PatientController@postIsDocumentValid'); //
            Route::get('patient/management/{id?}', 'Hospital\PatientController@getManagament'); //
            Route::get('patient/clinical-docs/{id?}', 'Hospital\PatientController@getClinicalDocuments'); //

            /*
             * Doctors
             * */
            Route::get('doctor', 'Hospital\DoctorController@index'); //
            Route::get('doctor/form', 'Hospital\DoctorController@getFormDoctor'); //
            Route::get('doctor/form/{id?}', 'Hospital\DoctorController@getFormDoctor'); //
            Route::get('doctor/list', 'Hospital\DoctorController@getListDoctors'); //
            Route::get('doctor/details/{id?}', 'Hospital\DoctorController@getDetailsDoctors'); //
            Route::post('doctor/save', 'Hospital\DoctorController@postSave'); //
            Route::post('doctor/valid-document', 'Hospital\DoctorController@postIsDocumentValid'); //
            /*
                * Antecedents
                * */
            Route::get('antecedent', 'Hospital\AntecedentController@index'); //
            Route::get('antecedent/form', 'Hospital\AntecedentController@getFormAntecedent'); //
            Route::get('antecedent/form/{id?}', 'Hospital\AntecedentController@getFormAntecedent'); //
            Route::get('antecedent/list', 'Hospital\AntecedentController@getListAntecedents'); //
            Route::get('antecedent/details/{id?}', 'Hospital\AntecedentController@getDetailsAntecedents'); //
            Route::post('antecedent/save', 'Hospital\AntecedentController@postSave'); //
            Route::get('antecedent/list/select', 'Hospital\AntecedentController@getListSelect2'); //

            /*
            * Clinical Exam
            * */
            Route::get('clinicalExam', 'Hospital\ClinicalExamController@index'); //
            Route::get('clinicalExam/form', 'Hospital\ClinicalExamController@getFormClinicalExam'); //
            Route::get('clinicalExam/form/{id?}', 'Hospital\ClinicalExamController@getFormClinicalExam'); //
            Route::get('clinicalExam/list', 'Hospital\ClinicalExamController@getListClinicalExams'); //
            Route::get('clinicalExam/details/{id?}', 'Hospital\ClinicalExamController@getDetailsClinicalExams'); //
            Route::post('clinicalExam/save', 'Hospital\ClinicalExamController@postSave'); //
            Route::get('clinicalExam/list/select', 'Hospital\ClinicalExamController@getListSelect2'); //
            /*
           * Medical Consultation has Patient
           * */
            Route::get('medicalConsultation', 'Hospital\MedicalConsultationByPatientController@index'); //
            Route::get('medicalConsultation/form', 'Hospital\MedicalConsultationByPatientController@getFormMedicalConsultationByPatient'); //
            Route::get('medicalConsultation/wizard', 'Hospital\MedicalConsultationByPatientController@getFormWizard'); //
            Route::get('medicalConsultation/form/{id?}', 'Hospital\MedicalConsultationByPatientController@getFormMedicalConsultationByPatient'); //
            Route::get('medicalConsultation/wizard/{id?}', 'Hospital\MedicalConsultationByPatientController@getFormWizard'); //
            Route::get('medicalConsultation/list-admin', 'Hospital\MedicalConsultationByPatientController@getListMedicalConsultationByPatientsAdmin'); //
            Route::get('medicalConsultation/list', 'Hospital\MedicalConsultationByPatientController@getListMedicalConsultationByPatients'); //
            Route::get('medicalConsultation/list-admin/{id?}', 'Hospital\MedicalConsultationByPatientController@getListMedicalConsultationByPatientsAdmin'); //
            Route::get('medicalConsultation/list/{id?}', 'Hospital\MedicalConsultationByPatientController@getListMedicalConsultationByPatients');
            Route::get('medicalConsultation/details/{id?}', 'Hospital\MedicalConsultationByPatientController@getDetailsMedicalConsultationByPatients'); //
            Route::post('medicalConsultation/save', 'Hospital\MedicalConsultationByPatientController@postSave'); //
            Route::get('medicalConsultation/list/{id?}', 'Hospital\MedicalConsultationByPatientController@getListMedicalConsultationByPatients'); //
            /*
        * Treatment
        * */
            Route::get('treatment', 'Hospital\TreatmentController@index'); //
            Route::get('treatment/form', 'Hospital\TreatmentController@getFormTreatment'); //
            Route::get('treatment/form/{id?}', 'Hospital\TreatmentController@getFormTreatment'); //
            Route::get('treatment/list', 'Hospital\TreatmentController@getListTreatments'); //
            Route::get('treatment/details/{id?}', 'Hospital\TreatmentController@getDetailsTreatment'); //
            Route::post('treatment/save', 'Hospital\TreatmentController@postSave'); //

            /**
             * Treatment plan by Patient
             */
            Route::get('treatmentPlanByPatient/form', 'Hospital\TreatmentPlanByPatientController@getFormTreatmentPlanByPatient'); //
            Route::get('treatmentPlanByPatient/form/{id?}', 'Hospital\TreatmentPlanByPatientController@getTreatmentPlanByPatient'); //
            Route::post('treatmentPlanByPatient/save', 'Hospital\TreatmentPlanByPatientController@postSaveByConsultation'); //
            Route::post('treatmentPlanByPatient/list', 'Hospital\TreatmentPlanByPatientController@getListTreatmentPlanByPatients'); //
            Route::get('treatmentPlanByPatient/managementByPatient/{id?}', 'Hospital\TreatmentPlanByPatientController@getManagementByPatient'); //
            Route::get('treatmentPlanByPatient/managementByPatientForm/{id?}/{treatment_plan_by_patient_id?}', 'Hospital\TreatmentPlanByPatientController@getManagementByPatientForm'); //

            /**
             * Antecedent By History Clinic
             */
            Route::get('antecedentByHistoryClinic/form', 'Hospital\AntecedentByHistoryClinicController@getFormAntecedentByHistoryClinic'); //
            Route::get('antecedentByHistoryClinic/form/{id?}', 'Hospital\AntecedentByHistoryClinicController@getAntecedentByHistoryClinic'); //
            Route::post('antecedentByHistoryClinic/saveOther', 'Hospital\AntecedentByHistoryClinicController@postSaveByConsultation'); //
            Route::get('antecedentByHistoryClinic/list', 'Hospital\AntecedentByHistoryClinicController@getListAntecedentByHistoryClinics'); //
            Route::get('antecedentByHistoryClinic/list/{id?}', 'Hospital\AntecedentByHistoryClinicController@getListAntecedentByHistoryClinics'); //

            /**
             * Clinical By History Clinic
             */
            Route::get('clinicalByHistoryClinic/form', 'Hospital\ClinicalByHistoryClinicController@getFormClinicalByHistoryClinic'); //
            Route::get('clinicalByHistoryClinic/form/{id?}', 'Hospital\ClinicalByHistoryClinicController@getFormClinicalByHistoryClinic'); //
            Route::post('clinicalByHistoryClinic/save', 'Hospital\ClinicalByHistoryClinicController@postSaveByConsultation'); //
            Route::get('clinicalByHistoryClinic/list', 'Hospital\ClinicalByHistoryClinicController@getListClinicalByHistoryClinics'); //
            Route::get('clinicalByHistoryClinic/list/{id?}', 'Hospital\ClinicalByHistoryClinicController@getListClinicalByHistoryClinics'); //

            /**
             * Odontogram by Patient
             */
            Route::get('odontogramByPatient/form', 'Hospital\OdontogramByPatientController@getFormOdontogramByPatient'); //
            Route::get('odontogramByPatient/form/{id?}', 'Hospital\OdontogramByPatientController@getOdontogramByPatient'); //
            //Route::post('odontogramByPatient/save', 'Hospital\OdontogramByPatientController@postSaveByConsultation'); //
            Route::post('odontogramByPatient/list', 'Hospital\OdontogramByPatientController@getListOdontogramByPatients'); //
            Route::get('odontogramByPatient/managementByPatient/{id?}', 'Hospital\OdontogramByPatientController@getManagementByPatient'); //

            /**
             * Dental piece by odontogram
             */

            Route::get('dentalPieceByOdontogram/form', 'Odontogram\DentalPieceByOdontogramController@getFormDentalPieceByOdontogram'); //
            Route::get('dentalPieceByOdontogram/form/{id?}', 'Odontogram\DentalPieceByOdontogramController@getDentalPieceByOdontogram'); //
            Route::post('dentalPieceByOdontogram/save', 'Odontogram\DentalPieceByOdontogramController@postSaveByConsultation'); //
            Route::post('dentalPieceByOdontogram/list', 'Odontogram\DentalPieceByOdontogramController@getListDentalPieceByOdontograms'); //
            Route::post('dentalPieceByOdontogram/list/byOdontogramodontogramId', 'Odontogram\DentalPieceByOdontogramController@getDataDentalPieceByOdontogramId'); //

            /*---------CATALOGS ---*/
            /*
        * Dental Piece
        * */
            Route::get('dentalPiece', 'Odontogram\DentalPieceController@index'); //
            Route::get('dentalPiece/form', 'Odontogram\DentalPieceController@getFormDentalPiece'); //
            Route::get('dentalPiece/form/{id?}', 'Odontogram\DentalPieceController@getFormDentalPiece'); //
            Route::get('dentalPiece/list', 'Odontogram\DentalPieceController@getListDentalPieces'); //
            Route::get('dentalPiece/details/{id?}', 'Odontogram\DentalPieceController@getDetailsDentalPieces'); //
            Route::post('dentalPiece/save', 'Odontogram\DentalPieceController@postSave'); //
            Route::get('dentalPiece/list/select', 'Odontogram\DentalPieceController@getListSelect2'); //
            /*
        * Reference Piece Position
        * */
            Route::get('referencePiecePosition', 'Odontogram\ReferencePiecePositionController@index'); //
            Route::get('referencePiecePosition/form', 'Odontogram\ReferencePiecePositionController@getFormReferencePiecePosition'); //
            Route::get('referencePiecePosition/form/{id?}', 'Odontogram\ReferencePiecePositionController@getFormReferencePiecePosition'); //
            Route::get('referencePiecePosition/list', 'Odontogram\ReferencePiecePositionController@getListReferencePiecePositions'); //
            Route::get('referencePiecePosition/details/{id?}', 'Odontogram\ReferencePiecePositionController@getDetailsReferencePiecePositions'); //
            Route::post('referencePiecePosition/save', 'Odontogram\ReferencePiecePositionController@postSave'); //
            Route::get('referencePiecePosition/list/select', 'Odontogram\ReferencePiecePositionController@getListSelect2'); //

            /*
        * Reference Piece
        * */
            Route::get('referencePiece', 'Odontogram\ReferencePieceController@index'); //
            Route::get('referencePiece/form', 'Odontogram\ReferencePieceController@getFormReferencePiece'); //
            Route::get('referencePiece/form/{id?}', 'Odontogram\ReferencePieceController@getFormReferencePiece'); //
            Route::get('referencePiece/list', 'Odontogram\ReferencePieceController@getListReferencePieces'); //
            Route::get('referencePiece/details/{id?}', 'Odontogram\ReferencePieceController@getDetailsReferencePieces'); //
            Route::post('referencePiece/save', 'Odontogram\ReferencePieceController@postSave'); //
            Route::get('referencePiece/list/select', 'Odontogram\ReferencePieceController@getListSelect2'); //

            /*
        * Reference Piece Type
        * */
            Route::get('referencePieceType', 'Odontogram\ReferencePieceTypeController@index'); //
            Route::get('referencePieceType/form', 'Odontogram\ReferencePieceTypeController@getFormReferencePieceType'); //
            Route::get('referencePieceType/form/{id?}', 'Odontogram\ReferencePieceTypeController@getFormReferencePieceType'); //
            Route::get('referencePieceType/list', 'Odontogram\ReferencePieceTypeController@getListReferencePieceTypes'); //
            Route::get('referencePieceType/details/{id?}', 'Odontogram\ReferencePieceTypeController@getDetailsReferencePieceTypes'); //
            Route::post('referencePieceType/save', 'Odontogram\ReferencePieceTypeController@postSave'); //
            Route::get('referencePieceType/list/select', 'Odontogram\ReferencePieceTypeController@getListSelect2'); //

            /*Accounting*/
            Route::post('rucType/save', 'Accounting\RucTypeController@saveData'); //
            Route::post('rucType/admin', 'Accounting\RucTypeController@getAdmin'); //
            Route::get('rucType/manager', 'Accounting\RucTypeController@getManager'); //
            Route::post("bank/save", "Accounting\BankController@saveData");
            Route::post("bank/admin", "Accounting\BankController@getAdmin");
            Route::get("bank/listSelect2", "Accounting\BankController@getListSelect2");
            Route::get("bank/manager", "Accounting\BankController@getManager");
            /*---NEW--*/
            Route::post("accountingConfigModulesTypes/save", "Accounting\AccountingConfigModulesTypesController@saveData")->name('saveAccountingConfigModulesTypesSave'); //
            Route::post("accountingConfigModulesTypes/admin", "Accounting\AccountingConfigModulesTypesController@getAdmin"); //
            Route::get("accountingConfigModulesTypes/listSelect2", "Accounting\AccountingConfigModulesTypesController@getListSelect2"); //
            Route::get("accountingConfigModulesTypes/manager", "Accounting\AccountingConfigModulesTypesController@getManager"); //


            Route::post("accountingLevel/save", "Accounting\AccountingLevelController@saveData"); //
            Route::post("accountingLevel/admin", "Accounting\AccountingLevelController@getAdmin"); //
            Route::get("accountingLevel/listSelect2", "Accounting\AccountingLevelController@getListSelect2"); //
            Route::get("accountingLevel/manager", "Accounting\AccountingLevelController@getManager"); //

            Route::post("accountingAccountType/save", "Accounting\AccountingAccountTypeController@saveData"); //
            Route::post("accountingAccountType/admin", "Accounting\AccountingAccountTypeController@getAdmin"); //
            Route::get("accountingAccountType/listSelect2", "Accounting\AccountingAccountTypeController@getListSelect2"); //
            Route::get("accountingAccountType/manager", "Accounting\AccountingAccountTypeController@getManager"); //

            Route::post("accountingAccount/save", "Accounting\AccountingAccountController@saveData"); //
            Route::post("accountingAccount/admin", "Accounting\AccountingAccountController@getAdmin"); //
            Route::get("accountingAccount/listSelect2", "Accounting\AccountingAccountController@getListSelect2"); //
            Route::get("accountingAccount/manager", "Accounting\AccountingAccountController@getManager"); //

            Route::post("accountingConfigModulesAccountByAccount/save", "Accounting\AccountingConfigModulesAccountByAccountController@saveData"); //
            Route::post("accountingConfigModulesAccountByAccount/admin", "Accounting\AccountingConfigModulesAccountByAccountController@getAdmin"); //
            Route::get("accountingConfigModulesAccountByAccount/listSelect2", "Accounting\AccountingConfigModulesAccountByAccountController@getListSelect2"); //
            Route::get("accountingConfigModulesAccountByAccount/manager", "Accounting\AccountingConfigModulesAccountByAccountController@getManager"); //

            //    PEOPLE

            Route::post('peopleNationality/save', 'People\PeopleNationalityController@saveData'); //
            Route::post('peopleNationality/admin', 'People\PeopleNationalityController@getAdmin'); //
            Route::get('peopleNationality/manager', 'People\PeopleNationalityController@getManager'); //


            Route::post('peopleTypeIdentification/save', 'People\PeopleTypeIdentificationController@saveData'); //
            Route::post('peopleTypeIdentification/admin', 'People\PeopleTypeIdentificationController@getAdmin'); //
            Route::get('peopleTypeIdentification/manager', 'People\PeopleTypeIdentificationController@getManager'); //

            Route::post('peopleProfession/save', 'People\PeopleProfessionController@saveData'); //
            Route::post('peopleProfession/admin', 'People\PeopleProfessionController@getAdmin'); //
            Route::get('peopleProfession/manager', 'People\PeopleProfessionController@getManager'); //

            Route::post("peopleGender/save", "People\PeopleGenderController@saveData");
            Route::post("peopleGender/admin", "People\PeopleGenderController@getAdmin");
            Route::get("peopleGender/listSelect2", "People\PeopleGenderController@getListSelect2");
            Route::get("peopleGender/manager", "People\PeopleGenderController@getManager");
            /**
             * Business
             */
            Route::get('business', 'Business\BusinessController@index'); //
            Route::get('business/form/{id?}', 'Business\BusinessController@getFormBusiness'); //
            Route::get('business/list', 'Business\BusinessController@getListBusiness'); //

            Route::post("businessAmenities/save", "Business\BusinessAmenitiesController@saveData");
            Route::post("businessAmenities/admin", "Business\BusinessAmenitiesController@getAdmin");
            Route::get("businessAmenities/listSelect2", "Business\BusinessAmenitiesController@getListSelect2");
            Route::get("businessAmenities/manager", "Business\BusinessAmenitiesController@getManager");
            Route::post('business/admin', 'Business\BusinessController@getAdmin')->name('getBusinessManagerFrontend'); //
            Route::post('business/adminEmployer', 'Business\BusinessController@getAdminEmployer'); //

            Route::get('business/manager', 'Business\BusinessController@getManager'); //BUSINESS 1
            Route::post('business/saveBusiness', 'Business\BusinessController@saveBusiness'); //
            Route::post('business/saveDataFrontend', 'Business\BusinessController@saveDataFrontend'); //


            Route::get('managerBusiness/{id?}/{typeManager?}', 'Business\BusinessManagerController@managerBusiness')->name('managerBusiness'); //BUSINESS-MANAGER-PROCESS-ROOT
            Route::post('business/save', 'Business\BusinessController@saveData'); //
            Route::post('business/saveFB', 'Business\BusinessController@saveFB'); //


            Route::post('businessByInventoryManagement/saveData', 'Business\BusinessByInventoryManagementController@saveData')->name('businessByInventoryManagementSaveData');
            Route::post('businessByInventoryManagement/admin', 'Business\BusinessByInventoryManagementController@getAdmin')->name('businessByInventoryManagementGetDataProfileBusiness');

            Route::post('businessByInventoryManagementSubcategory/saveData', 'Business\BusinessByInventoryManagementSubcategoryController@saveData')->name('businessByInventoryManagementSubcategorySaveData');
            Route::post('businessByInventoryManagementSubcategory/getAdmin', 'Business\BusinessByInventoryManagementSubcategoryController@getAdmin')->name('businessByInventoryManagementSubcategoryGetAdmin');


            Route::post("businessCategories/save", "Business\BusinessCategoriesController@saveData");
            Route::post("businessCategories/admin", "Business\BusinessCategoriesController@getAdmin");
            Route::get("businessCategories/listSelect2", "Business\BusinessCategoriesController@getListSelect2");
            Route::get("businessCategories/manager", "Business\BusinessCategoriesController@getManager");

            Route::post("businessSubcategories/save", "Business\BusinessSubcategoriesController@saveData");
            Route::post("businessSubcategories/admin", "Business\BusinessSubcategoriesController@getAdmin");
            Route::get("businessSubcategories/listSelect2", "Business\BusinessSubcategoriesController@getListSelect2");
            /* ----manager--*/
            /*------PRODUCTS BUSINESS----*/
            Route::get('business/product/admin', 'Products\ProductController@getAdminBusiness'); //
            Route::post('business/businessBySchedules/saveSchedules', 'Business\BusinessByScheduleController@saveSchedules'); //
            Route::post('business/businessBySchedules/deleteSchedule', 'Business\BusinessByScheduleController@deleteSchedule'); //

            Route::post('business/product/adminProductsBusiness', 'Products\ProductController@getAdminProductsBusiness'); //
            Route::post('multimedia/uploadResource', 'Multimedia\MultimediaController@uploadMultimedia'); //
            Route::post('multimedia/uploadImage', 'Multimedia\MultimediaController@uploadImage'); //


            /*ROUTES BUSINESS*/
            Route::post('business/routes/adminBusiness', 'Routes\BusinessByRoutesMapController@getAdminBusiness'); //
            Route::post('business/routes/saveBusiness', 'Routes\BusinessByRoutesMapController@saveBusiness'); //
            Route::post('business/multimedia/uploadResourceBusiness', 'Multimedia\MultimediaController@uploadResourceBusiness'); //
            Route::get('business/routes/markers/select', 'Routes\RoutesMapByRoutesDrawingController@getListSelect2'); //
            /* PANORAMA MANAGER*/
            Route::post('business/panorama/adminBusiness', 'Panorama\BusinessByPanoramaController@getAdminBusiness'); //
            Route::post('business/panorama/saveToBusiness', 'Panorama\BusinessByPanoramaController@saveToBusiness'); //
            /*GALLERY BUSINESS*/
            Route::post('business/gallery/adminBusiness', 'Gallery\BusinessByGalleryController@getAdminBusiness'); //
            Route::post('business/gallery/saveBusiness', 'Gallery\BusinessByGalleryController@saveBusiness'); //

            /*Housing*/
            /*Lodging*/
            Route::post('business/lodging/adminBusiness', 'Housing\LodgingController@getAdminBusiness'); //
            Route::post('business/lodging/saveBusiness', 'Housing\LodgingController@saveBusiness');//BUSINESS-LODGING-RECEPTION
            Route::post('business/lodging/updateBusiness', 'Housing\LodgingController@updateBusiness'); //
            Route::post('business/lodging/delivery', 'Housing\LodgingController@delivery'); //
            Route::post('business/lodging/results', 'Housing\LodgingController@results'); //
            /*Lodging By Payment*/
            Route::post('business/lodgingByPayment/savePayment', 'Housing\LodgingByPaymentController@savePayment'); //
            /*Lodging By Arrived*/
            Route::post('business/lodgingByArrived/saveArrived', 'Housing\LodgingByArrivedController@saveArrived'); //
            /*BusinessByLodgingByPrice*/
            Route::post('business/housing/getListRooms', 'Housing\BusinessByLodgingByPriceController@getListRooms'); //
            /* Lodging By Type of room*/
            Route::post('business/lodgingByTypeOfRoom/saveBusiness', 'Housing\LodgingByTypeOfRoomController@saveRoomsLodging'); //

            /* Lodging Type of room */
            Route::post('business/lodgingTypeOfRoom/admin', 'Housing\LodgingTypeOfRoomController@getAdmin'); //
            Route::post('business/lodgingTypeOfRoom/save', 'Housing\LodgingTypeOfRoomController@saveData'); //
            Route::get('business/lodgingTypeOfRoom/listSelect2', 'Housing\LodgingTypeOfRoomController@getListSelect2'); //
            /*LEVELS*/
            Route::post('business/lodgingRoomLevels/admin', 'Housing\LodgingRoomLevelsController@getAdmin'); //
            Route::post('business/lodgingRoomLevels/save', 'Housing\LodgingRoomLevelsController@saveData'); //
            Route::get('business/lodgingRoomLevels/listSelect2', 'Housing\LodgingRoomLevelsController@getListSelect2'); //
            /*FEATURES*/
            Route::post('business/lodgingRoomFeatures/admin', 'Housing\LodgingRoomFeaturesController@getAdmin'); //
            Route::post('business/lodgingRoomFeatures/save', 'Housing\LodgingRoomFeaturesController@saveData'); //
            Route::get('business/lodgingRoomFeatures/listSelect2', 'Housing\LodgingRoomFeaturesController@getListSelect2'); //

            /* Lodging Type of room  by price*/
            Route::post('business/lodgingTypeOfRoomByPrice/admin', 'Housing\LodgingTypeOfRoomByPriceController@getAdmin'); //
            Route::post('business/lodgingTypeOfRoomByPrice/save', 'Housing\LodgingTypeOfRoomByPriceController@saveData'); //
            Route::post('business/lodgingTypeOfRoomByPrice/admin', 'Housing\LodgingTypeOfRoomByPriceController@getAdmin'); //
            Route::post('business/lodgingTypeOfRoomByPrice/saveReception', 'Housing\LodgingTypeOfRoomByPriceController@saveDataReception'); //
            Route::post('business/lodgingTypeOfRoomByPrice/adminReception', 'Housing\LodgingTypeOfRoomByPriceController@getAdminReception'); //


            //CUSTOMER
            Route::get('business/customer/manager', 'Crm\CustomerController@getManager');
            Route::post('business/customer/save', 'Crm\CustomerController@saveData')->name('customerDataSave');
            Route::post('business/customer/saveFix', 'Crm\CustomerController@saveDataFix');
            Route::post('business/customer/admin', 'Crm\CustomerController@getAdmin');
            Route::post('business/customer/adminEmails', 'Crm\CustomerController@getAdminEmails'); //NEW

            Route::get('business/customer/listS2InformationAddress', 'Crm\CustomerController@getListS2InformationAddress'); //--
            Route::post('business/customer/listAllInformationAddress', 'Crm\CustomerController@getListAllInformationAddress'); //--
            Route::get('business/customer/listRepair', 'Crm\CustomerController@getListRepair'); //--
            Route::get('business/customer/listRepairs', 'Crm\CustomerController@getListRepair'); //--

            /* Lodging Customers*/
            Route::get('business/customer/listSelect2NotLodging', 'Crm\CustomerController@getListSelect2NotLodging');

            /*Scheduling*/
            Route::get('business/scheduling/exampleDiaryData', 'Scheduling\DiaryController@getExampleDiaryData');
            /*Human Resources*/
            /*Departments*/
            Route::post('business/humanResourcesDepartment/save', 'HumanResources\HumanResourcesDepartmentController@saveData');
            Route::get('business/humanResourcesDepartment/listAll', 'HumanResources\HumanResourcesDepartmentController@getListAll');
            Route::get('business/humanResourcesDepartment/listAllArea', 'HumanResources\HumanResourcesDepartmentController@getListAllArea');
            Route::get('business/humanResourcesDepartment/listByAreaAll', 'HumanResources\HumanResourcesDepartmentController@getListByAreaAll');

            Route::post('business/humanResourcesDepartment/admin', 'HumanResources\HumanResourcesDepartmentController@getAdmin');
            /*Employed Profile*/
            Route::post('business/humanResourcesEmployeeProfile/save', 'HumanResources\HumanResourcesEmployeeProfileController@saveData');
            Route::post('business/humanResourcesEmployeeProfile/admin', 'HumanResources\HumanResourcesEmployeeProfileController@getAdmin');
            Route::get('business/humanResourcesEmployeeProfile/getFullNameListDataAreaAll', 'HumanResources\HumanResourcesEmployeeProfileController@getFullNameListDataAreaAll');
            Route::get('business/humanResourcesEmployeeProfile/getFullNameListDataDepartmentAll', 'HumanResources\HumanResourcesEmployeeProfileController@getFullNameListDataDepartmentAll');

            /*Employee Profile Business*/
            Route::post('business/businessByEmployeeProfile/save', 'HumanResources\BusinessByEmployeeProfileController@saveData');
            Route::get('business/roles/listAll', 'Users\RoleController@getListAll');

            /*INFORMATION*/
            Route::post("informationMailType/save", "Information\InformationMailTypeController@saveData"); //
            Route::post("informationMailType/admin", "Information\InformationMailTypeController@getAdmin"); //
            Route::get("informationMailType/listSelect2", "Information\InformationMailTypeController@getListSelect2"); //
            Route::get("informationMailType/manager", "Information\InformationMailTypeController@getManager"); //

            Route::post("informationSocialNetworkType/save", "Information\InformationSocialNetworkTypeController@saveData");
            Route::post("informationSocialNetworkType/admin", "Information\InformationSocialNetworkTypeController@getAdmin");
            Route::get("informationSocialNetworkType/listSelect2", "Information\InformationSocialNetworkTypeController@getListSelect2");
            Route::get("informationSocialNetworkType/manager", "Information\InformationSocialNetworkTypeController@getManager");

            Route::post("informationPhoneOperator/save", "Information\InformationPhoneOperatorController@saveData");
            Route::post("informationPhoneOperator/admin", "Information\InformationPhoneOperatorController@getAdmin");
            Route::get("informationPhoneOperator/listSelect2", "Information\InformationPhoneOperatorController@getListSelect2");
            Route::get("informationPhoneOperator/manager", "Information\InformationPhoneOperatorController@getManager");

            Route::post("informationPhoneType/save", "Information\InformationPhoneTypeController@saveData");
            Route::post("informationPhoneType/admin", "Information\InformationPhoneTypeController@getAdmin");
            Route::get("informationPhoneType/listSelect2", "Information\InformationPhoneTypeController@getListSelect2");
            Route::get("informationPhoneType/manager", "Information\InformationPhoneTypeController@getManager");

            Route::post("informationAddressType/save", "Information\InformationAddressTypeController@saveData");
            Route::post("informationAddressType/admin", "Information\InformationAddressTypeController@getAdmin");
            Route::get("informationAddressType/listSelect2", "Information\InformationAddressTypeController@getListSelect2");
            Route::get("informationAddressType/manager", "Information\InformationAddressTypeController@getManager");

            Route::post("business/informationSocialNetwork/save", "Information\InformationSocialNetworkController@saveData");
            Route::post("business/informationSocialNetwork/admin", "Information\InformationSocialNetworkController@getAdmin");
            Route::get("business/informationSocialNetwork/listSelect2", "Information\InformationSocialNetworkController@getListSelect2");
            Route::post("informationSocialNetwork/saveFrontend", "Information\InformationSocialNetworkController@saveDataFrontend");
            Route::post("informationSocialNetwork/deleteFrontend", "Information\InformationSocialNetworkController@deleteFrontend");


            Route::post("business/informationPhone/save", "Information\InformationPhoneController@saveData");
            Route::post("business/informationPhone/admin", "Information\InformationPhoneController@getAdmin");
            Route::get("business/informationPhone/listSelect2", "Information\InformationPhoneController@getListSelect2");

            Route::post("business/informationAddress/save", "Information\InformationAddressController@saveData");
            Route::post("business/informationAddress/admin", "Information\InformationAddressController@getAdmin");
            Route::get("business/informationAddress/listSelect2", "Information\InformationAddressController@getListSelect2");

            Route::post("business/informationMail/save", "Information\InformationMailController@saveData");
            Route::post("business/informationMail/admin", "Information\InformationMailController@getAdmin");
            Route::get("business/informationMail/listSelect2", "Information\InformationMailController@getListSelect2");
            /*EDUCATIONAL INSTITUTION*/
            Route::post("business/educationalInstitutionAskwerType/save", "EducationalInstitution\EducationalInstitutionAskwerTypeController@saveData");
            Route::post("business/educationalInstitutionAskwerType/admin", "EducationalInstitution\EducationalInstitutionAskwerTypeController@getAdmin");
            Route::get("business/educationalInstitutionAskwerType/listSelect2", "EducationalInstitution\EducationalInstitutionAskwerTypeController@getListSelect2");

            Route::post("business/educationalInstitutionByBusiness/save", "EducationalInstitution\EducationalInstitutionByBusinessController@saveData");
            Route::post("business/educationalInstitutionByBusiness/admin", "EducationalInstitution\EducationalInstitutionByBusinessController@getAdmin");
            Route::get("business/educationalInstitutionByBusiness/listSelect2", "EducationalInstitution\EducationalInstitutionByBusinessController@getListSelect2");
            Route::post("business/educationalInstitutionByBusiness/dataAskwer", "EducationalInstitution\EducationalInstitutionByBusinessController@getDataAskwer");
            Route::post("business/educationalInstitutionByBusiness/dataAskwerForm", "EducationalInstitution\EducationalInstitutionByBusinessController@getDataAskwerForm");
            Route::post("business/askwerFieldValue/dataAskwerResults", "Askwer\AskwerFieldValueController@getDataAskwerResults");

            Route::post("business/askwerForm/saveAskwer", "Askwer\AskwerFormController@saveAskwer");
            Route::post("business/askwerForm/getDataSolutionsAskwer", "Askwer\AskwerFormController@getDataSolutionsAskwer");

            //EVENTS TRAILS
            Route::post("eventsTrailsTypes/save", "EventsTrails\EventsTrailsTypesController@saveData");
            Route::post("eventsTrailsTypes/admin", "EventsTrails\EventsTrailsTypesController@getAdmin");
            Route::get("eventsTrailsTypes/listSelect2", "EventsTrails\EventsTrailsTypesController@getListSelect2");
            Route::get("eventsTrailsTypes/manager", "EventsTrails\EventsTrailsTypesController@getManager");

            Route::post("eventsTrailsProject/save", "EventsTrails\EventsTrailsProjectController@saveData");
            Route::post("eventsTrailsProject/admin", "EventsTrails\EventsTrailsProjectController@getAdmin");
            Route::get("eventsTrailsProject/listSelect2", "EventsTrails\EventsTrailsProjectController@getListSelect2");
            Route::get("eventsTrailsProject/manager/{id?}/{typeManager?}", "EventsTrails\EventsTrailsProjectController@manager");


            Route::post("eventsTrailsTypeOfCategories/save", "EventsTrails\EventsTrailsTypeOfCategoriesController@saveData");
            Route::post("eventsTrailsTypeOfCategories/admin", "EventsTrails\EventsTrailsTypeOfCategoriesController@getAdmin");
            Route::get("eventsTrailsTypeOfCategories/listSelect2", "EventsTrails\EventsTrailsTypeOfCategoriesController@getListSelect2");


            Route::post("eventsTrailsDistances/save", "EventsTrails\EventsTrailsDistancesController@saveData");
            Route::post("eventsTrailsDistances/admin", "EventsTrails\EventsTrailsDistancesController@getAdmin");
            Route::get("eventsTrailsDistances/listSelect2", "EventsTrails\EventsTrailsDistancesController@getListSelect2");

            Route::post("eventsTrailsTypeTeams/save", "EventsTrails\EventsTrailsTypeTeamsController@saveData");
            Route::post("eventsTrailsTypeTeams/admin", "EventsTrails\EventsTrailsTypeTeamsController@getAdmin");
            Route::get("eventsTrailsTypeTeams/listSelect2", "EventsTrails\EventsTrailsTypeTeamsController@getListSelect2");


            Route::post("eventsTrailsByKit/save", "EventsTrails\EventsTrailsByKitController@saveData");
            Route::post("eventsTrailsByKit/admin", "EventsTrails\EventsTrailsByKitController@getAdmin");
            Route::get("eventsTrailsByKit/listSelect2", "EventsTrails\EventsTrailsByKitController@getListSelect2");

            Route::get("eventsTrailsByKit/listSelect2PiecesClothes", "EventsTrails\EventsTrailsByKitController@getListSelect2PiecesClothes");

            Route::post("eventsTrailsRegistrationPoints/save", "EventsTrails\EventsTrailsRegistrationPointsController@saveData");
            Route::post("eventsTrailsRegistrationPoints/admin", "EventsTrails\EventsTrailsRegistrationPointsController@getAdmin");
            Route::get("eventsTrailsRegistrationPoints/listSelect2", "EventsTrails\EventsTrailsRegistrationPointsController@getListSelect2");

            Route::post("eventsTrailsByProfile/save", "EventsTrails\EventsTrailsByProfileController@saveData");
            Route::post("eventsTrailsByProfile/admin", "EventsTrails\EventsTrailsByProfileController@getAdmin");
            Route::get("eventsTrailsByProfile/listSelect2", "EventsTrails\EventsTrailsByProfileController@getListSelect2");


            Route::get("customer/manager/{typeManagerSuccess?}/{typeManagerMsj?}", "Crm\CustomerController@manager")->name('customer');
            Route::get("business/managementBusinessEvents", "Business\BusinessController@getManagementBusinessEvents");


            /*  FRONTEND BACKEND*/
            Route::get('frontend/manager/{id?}/{typeManager?}', 'Frontend\FrontendController@manager')->name('frontendManagerBackend'); //

            Route::post("templateInformation/save", "Frontend\TemplateInformationController@saveData");
            Route::post("templateInformation/admin", "Frontend\TemplateInformationController@getAdmin");
            Route::get("templateInformation/listSelect2", "Frontend\TemplateInformationController@getListSelect2");

            Route::post("templateSlider/save", "Frontend\TemplateSliderController@saveData");
            Route::post("templateSlider/admin", "Frontend\TemplateSliderController@getAdmin");
            Route::post("templateSlider/saveActivitiesGamification", "Frontend\TemplateSliderController@saveDataActivitiesGamification");
            Route::post("templateSlider/adminActivitiesGamification", "Frontend\TemplateSliderController@getAdminActivitiesGamification");
            Route::post("templateSlider/saveRewardsGamification", "Frontend\TemplateSliderController@saveDataRewardsGamification");
            Route::post("templateSlider/adminRewardsGamification", "Frontend\TemplateSliderController@getAdminRewardsGamification");

            Route::get("templateSlider/listSelect2", "Frontend\TemplateSliderController@getListSelect2");

            Route::post("templateSliderByImages/save", "Frontend\TemplateSliderByImagesController@saveData");
            Route::post("templateSliderByImages/admin", "Frontend\TemplateSliderByImagesController@getAdmin");
            Route::post("templateSliderByImages/saveActivitiesGamification", "Frontend\TemplateSliderByImagesController@saveDataActivitiesGamification");
            Route::post("templateSliderByImages/adminActivitiesGamification", "Frontend\TemplateSliderByImagesController@getAdminActivitiesGamification");
            Route::post("templateSliderByImages/saveRewardsGamification", "Frontend\TemplateSliderByImagesController@saveDataRewardsGamification");
            Route::post("templateSliderByImages/adminRewardsGamification", "Frontend\TemplateSliderByImagesController@getAdminRewardsGamification");
            Route::get("templateSliderByImages/listSelect2", "Frontend\TemplateSliderByImagesController@getListSelect2");

            Route::post("templateAboutUs/save", "Frontend\TemplateAboutUsController@saveData");
            Route::post("templateAboutUs/admin", "Frontend\TemplateAboutUsController@getAdmin");
            Route::get("templateAboutUs/listSelect2", "Frontend\TemplateAboutUsController@getListSelect2");

            Route::post("templatePolicies/save", "Frontend\TemplatePoliciesController@saveData");
            Route::post("templatePolicies/admin", "Frontend\TemplatePoliciesController@getAdmin");
            Route::get("templatePolicies/listSelect2", "Frontend\TemplatePoliciesController@getListSelect2");

            Route::post("templateAboutUsByData/save", "Frontend\TemplateAboutUsByDataController@saveData");
            Route::post("templateAboutUsByData/admin", "Frontend\TemplateAboutUsByDataController@getAdmin");
            Route::get("templateAboutUsByData/listSelect2", "Frontend\TemplateAboutUsByDataController@getListSelect2");

            Route::post("templateServicesByData/save", "Frontend\TemplateServicesByDataController@saveData");
            Route::post("templateServicesByData/admin", "Frontend\TemplateServicesByDataController@getAdmin");
            Route::get("templateServicesByData/listSelect2", "Frontend\TemplateServicesByDataController@getListSelect2");

            Route::post("templateServices/save", "Frontend\TemplateServicesController@saveData");
            Route::post("templateServices/admin", "Frontend\TemplateServicesController@getAdmin");
            Route::get("templateServices/listSelect2", "Frontend\TemplateServicesController@getListSelect2");


            Route::post("templateNewsByData/save", "Frontend\TemplateNewsByDataController@saveData");
            Route::post("templateNewsByData/admin", "Frontend\TemplateNewsByDataController@getAdmin");
            Route::get("templateNewsByData/listSelect2", "Frontend\TemplateNewsByDataController@getListSelect2");

            Route::post("templateNews/save", "Frontend\TemplateNewsController@saveData");
            Route::post("templateNews/admin", "Frontend\TemplateNewsController@getAdmin");
            Route::get("templateNews/listSelect2", "Frontend\TemplateNewsController@getListSelect2");


            //News Actions
            Route::post("businessByAcademicOfferingsInstitution/save", "Business\BusinessByAcademicOfferingsInstitutionController@saveData")->name('businessByAcademicOfferingsInstitutionSaveData');
            Route::post("businessByAcademicOfferingsInstitution/admin", "Business\BusinessByAcademicOfferingsInstitutionController@getAdmin")->name('businessByAcademicOfferingsInstitutionGetAdmin');


            Route::post("businessByAcademicOfferings/save", "Business\BusinessByAcademicOfferingsController@saveData")->name('businessByAcademicOfferingsSaveData');
            Route::post("businessByAcademicOfferings/admin", "Business\BusinessByAcademicOfferingsController@getAdmin")->name('businessByAcademicOfferingsGetAdmin');


            Route::post("businessAcademicOfferingsDataByInformation/save", "Business\BusinessAcademicOfferingsDataByInformationController@saveData")->name('businessAcademicOfferingsDataByInformationSaveData');
            Route::post("businessAcademicOfferingsDataByInformation/admin", "Business\BusinessAcademicOfferingsDataByInformationController@getAdmin")->name('businessAcademicOfferingsDataByInformationGetAdmin');


            Route::post("businessAcademicOfferingsByData/save", "Business\BusinessAcademicOfferingsByDataController@saveData")->name('businessAcademicOfferingsByDataSaveData');
            Route::post("businessAcademicOfferingsByData/admin", "Business\BusinessAcademicOfferingsByDataController@getAdmin")->name('businessAcademicOfferingsByDataGetAdmin');


            Route::post('businessByMenuManagementFrontend/save', 'Business\BusinessByMenuManagementFrontendController@saveData'); //
            Route::post('businessByMenuManagementFrontend/admin', 'Business\BusinessByMenuManagementFrontendController@getAdmin'); //
            Route::get('businessByMenuManagementFrontend/manager', 'Business\BusinessByMenuManagementFrontendController@getManager'); //
            Route::get('businessByMenuManagementFrontend/listActionsParent', 'Business\BusinessByMenuManagementFrontendController@getListActionsParent'); //


            Route::post("businessByHistory/save", "Business\BusinessByHistoryController@saveData")->name('businessByHistorySaveData');
            Route::post("businessByHistory/admin", "Business\BusinessByHistoryController@getAdmin")->name('businessByHistoryGetAdmin');
            Route::get("businessByHistory/listSelect2", "Business\BusinessByHistoryController@getListSelect2")->name('businessByHistoryGetListSelect2');

            Route::post("businessByHistoryByData/save", "Business\BusinessHistoryByDataController@saveData")->name('businessByHistoryByDataSaveData');
            Route::post("businessByHistoryByData/admin", "Business\BusinessHistoryByDataController@getAdmin")->name('businessByHistoryByGetAdmin');
            Route::get("businessByHistoryByData/listSelect2", "Business\BusinessHistoryByDataController@getListSelect2")->name('businessByHistoryByDataGetListSelect2');

            Route::post("businessCounterCustom/save", "Business\BusinessCounterCustomController@saveData");
            Route::post("businessCounterCustom/admin", "Business\BusinessCounterCustomController@getAdmin");
            Route::get("businessCounterCustom/listSelect2", "Business\BusinessCounterCustomController@getListSelect2");

            Route::post("businessByRequirements/save", "Business\BusinessByRequirementsController@saveData")->name('businessByRequirementsSaveData');
            Route::post("businessByRequirements/admin", "Business\BusinessByRequirementsController@getAdmin")->name('businessByRequirementsGetAdmin');
            Route::get("businessByRequirements/listSelect2", "Business\BusinessByRequirementsController@getListSelect2");

            Route::post("businessByFrequentQuestion/save", "Business\BusinessByFrequentQuestionController@saveData")->name('businessByFrequentQuestionSaveData');
            Route::post("businessByFrequentQuestion/admin", "Business\BusinessByFrequentQuestionController@getAdmin")->name('businessByFrequentQuestionGetAdmin');
            Route::get("businessByFrequentQuestion/listSelect2", "Business\BusinessByFrequentQuestionController@getListSelect2");


            Route::post("businessCounterCustomByData/save", "Business\BusinessCounterCustomByDataController@saveData");
            Route::post("businessCounterCustomByData/admin", "Business\BusinessCounterCustomByDataController@getAdmin");
            Route::get("businessCounterCustomByData/listSelect2", "Business\BusinessCounterCustomByDataController@getListSelect2");

            Route::post("businessByPartnerCompanies/save", "Business\BusinessByPartnerCompaniesController@saveData");
            Route::post("businessByPartnerCompanies/admin", "Business\BusinessByPartnerCompaniesController@getAdmin");
            Route::get("businessByPartnerCompanies/listSelect2", "Business\BusinessByPartnerCompaniesController@getListSelect2");


            Route::post("businessByInformationCustom/save", "Business\BusinessByInformationCustomController@saveData");
            Route::post("businessByInformationCustom/admin", "Business\BusinessByInformationCustomController@getAdmin");
            Route::get("businessByInformationCustom/listSelect2", "Business\BusinessByInformationCustomController@getListSelect2");


            Route::post("templateContactUs/save", "Frontend\TemplateContactUsController@saveData");
            Route::post("templateContactUs/admin", "Frontend\TemplateContactUsController@getAdmin");
            Route::get("templateContactUs/listSelect2", "Frontend\TemplateContactUsController@getListSelect2");
            Route::post("templateContactUs/getContactUsData", "Frontend\TemplateContactUsController@getContactUsData");
            Route::post('templateContactUs/uploadImage', 'Frontend\TemplateContactUsController@uploadImage'); //


            Route::post("templateContactUsByRoutesMap/save", "Frontend\TemplateContactUsByRoutesMapController@saveData");
            Route::post("templateContactUsByRoutesMap/admin", "Frontend\TemplateContactUsByRoutesMapController@getAdmin");
            Route::get("templateContactUsByRoutesMap/listSelect2", "Frontend\TemplateContactUsByRoutesMapController@getListSelect2");


            Route::post("templateChatApi/save", "Frontend\TemplateChatApiController@saveData");
            Route::post("templateChatApi/admin", "Frontend\TemplateChatApiController@getAdmin");
            Route::get("templateChatApi/listSelect2", "Frontend\TemplateChatApiController@getListSelect2");
            Route::get("templateChatApi/getChatsTypesData", "Frontend\TemplateChatApiController@getChatsTypesData");


            Route::post("templateConfigMailingByEmails/save", "Frontend\TemplateConfigMailingByEmailsController@saveData");
            Route::post("templateConfigMailingByEmails/admin", "Frontend\TemplateConfigMailingByEmailsController@getAdmin");
            Route::get("templateConfigMailingByEmails/listSelect2", "Frontend\TemplateConfigMailingByEmailsController@getListSelect2");
            Route::post("templateConfigMailingByEmails/deleteFrontend", "Frontend\TemplateConfigMailingByEmailsController@deleteFrontend");

            Route::post("templateBySource/save", "Frontend\TemplateBySourceController@saveData");
            Route::post("templateBySource/admin", "Frontend\TemplateBySourceController@getAdmin");
            Route::get("templateBySource/listSelect2", "Frontend\TemplateBySourceController@getListSelect2");
            Route::post("templateBySource/getSourcesTypesData", "Frontend\TemplateBySourceController@getSourcesTypesData");

            Route::post("templateWishListByUser/save", "Frontend\TemplateWishListByUserController@saveData");
            Route::post("templateWishListByUser/admin", "Frontend\TemplateWishListByUserController@getAdmin");
            Route::get("templateWishListByUser/listSelect2", "Frontend\TemplateWishListByUserController@getListSelect2");

            Route::post("templatePayments/save", "Frontend\TemplatePaymentsController@saveData");
            Route::post("templatePayments/admin", "Frontend\TemplatePaymentsController@getAdmin");
            Route::get("templatePayments/listSelect2", "Frontend\TemplatePaymentsController@getListSelect2");


            /*PRODUCTS*/
            Route::post("productCategory/save", "Products\ProductCategoryController@saveData");
            Route::post("productCategory/admin", "Products\ProductCategoryController@getAdmin");
            Route::get("productCategory/listSelect2", "Products\ProductCategoryController@getListSelect2");
            Route::get("productCategory/manager", "Products\ProductCategoryController@getManager");

            Route::post("productSubcategory/save", "Products\ProductSubcategoryController@saveData");
            Route::post("productSubcategory/admin", "Products\ProductSubcategoryController@getAdmin");
            Route::get("productSubcategory/manager", "Products\ProductSubcategoryController@getManager");
            Route::get("productSubcategory/listSelect2Config", "Products\ProductSubcategoryController@getListSelect2Config")->name('productSubcategoryGetListSelect2Config');
            Route::get("productSubcategory/listSelect2", "Products\ProductSubcategoryController@getListSelect2");

            Route::post("productTrademark/save", "Products\ProductTrademarkController@saveData");
            Route::post("productTrademark/admin", "Products\ProductTrademarkController@getAdmin");
            Route::get("productTrademark/listSelect2", "Products\ProductTrademarkController@getListSelect2");
            Route::get("productTrademark/manager", "Products\ProductTrademarkController@getManager");

            Route::post("productMeasureType/save", "Products\ProductMeasureTypeController@saveData");
            Route::post("productMeasureType/admin", "Products\ProductMeasureTypeController@getAdmin");
            Route::get("productMeasureType/listSelect2", "Products\ProductMeasureTypeController@getListSelect2");
            Route::get("productMeasureType/manager", "Products\ProductMeasureTypeController@getManager");

            Route::post("productMeasureBySubtype/save", "Products\ProductMeasureBySubtypeController@saveData");
            Route::post("productMeasureBySubtype/admin", "Products\ProductMeasureBySubtypeController@getAdmin");
            Route::get("productMeasureBySubtype/listSelect2", "Products\ProductMeasureBySubtypeController@getListSelect2");
            Route::get("productMeasureBySubtype/manager", "Products\ProductMeasureBySubtypeController@getManager");

            Route::post("productMeasurementSubtype/save", "Products\ProductMeasurementSubtypeController@saveData");
            Route::post("productMeasurementSubtype/admin", "Products\ProductMeasurementSubtypeController@getAdmin");
            Route::get("productMeasurementSubtype/listSelect2", "Products\ProductMeasurementSubtypeController@getListSelect2");
            Route::get("productMeasurementSubtype/manager", "Products\ProductMeasurementSubtypeController@getManager");

            Route::post("product/save", "Products\ProductController@saveData");
            Route::post("product/saveDataInputOutput", "Products\ProductController@saveDataInputOutput")->name('productSaveDataInputOutput');

            Route::post("product/admin", "Products\ProductController@getAdmin");
            Route::get("product/listSelect2", "Products\ProductController@getListSelect2");
            Route::get("business/products/listSelect2", "Products\ProductController@getBusinessProductsListSelect2");
            Route::get("business/productsServices/listSelect2", "Products\ProductController@getBusinessProductsServicesListSelect2")->name('getBusinessProductsServicesListSelect2');

            Route::get("business/services/listSelect2", "Products\ProductController@getBusinessServicesListSelect2");

            /*SERVICES*/

            Route::post("productService/admin", "Products\ProductController@getAdminService");
            Route::post("productService/save", "Products\ProductController@saveDataService");

            Route::post("productColor/save", "Products\ProductColorController@saveData");
            Route::post("productColor/admin", "Products\ProductColorController@getAdmin");
            Route::get("productColor/listSelect2", "Products\ProductColorController@getListSelect2");
            Route::get("productColor/manager", "Products\ProductColorController@getManager");

            Route::post("productSizes/save", "Products\ProductSizesController@saveData");
            Route::post("productSizes/admin", "Products\ProductSizesController@getAdmin");
            Route::get("productSizes/listSelect2", "Products\ProductSizesController@getListSelect2");
            Route::get("productSizes/manager", "Products\ProductSizesController@getManager");

            Route::post("productIce/save", "Products\ProductIceController@saveData");
            Route::post("productIce/admin", "Products\ProductIceController@getAdmin");
            Route::get("productIce/listSelect2", "Products\ProductIceController@getListSelect2");
            Route::get("productIce/manager", "Products\ProductIceController@getManager");

            Route::post("productByMultimedia/save", "Products\ProductByMultimediaController@saveData");
            Route::post("productByMultimedia/admin", "Products\ProductByMultimediaController@getAdmin");
            Route::get("productByMultimedia/listSelect2", "Products\ProductByMultimediaController@getListSelect2");
            //ORDERS
            Route::post("orderPaymentsManager/save", "Orders\OrderPaymentsManagerController@saveData");
            Route::post("orderPaymentsManager/admin", "Orders\OrderPaymentsManagerController@getAdmin");
            Route::post("orderPaymentsManager/adminCustomers", "Orders\OrderPaymentsManagerController@getAdminCustomers");

            Route::get("orderPaymentsManager/listSelect2", "Orders\OrderPaymentsManagerController@getListSelect2");
            Route::post("orderPaymentsManager/deliverOrder", "Orders\OrderPaymentsManagerController@deliverOrder");
            Route::post("orderPaymentsManager/changeStateBankOrder", "Orders\OrderPaymentsManagerController@changeStateBankOrder");


            Route::post("orderShoppingCart/save", "Orders\OrderShoppingCartController@saveData");
            Route::post("orderShoppingCart/admin", "Orders\OrderShoppingCartController@getAdmin");
            Route::get("orderShoppingCart/listSelect2", "Orders\OrderShoppingCartController@getListSelect2");

            Route::post("orderShoppingByCustomerDelivery/save", "Orders\OrderShoppingByCustomerDeliveryController@saveData");
            Route::post("orderShoppingByCustomerDelivery/admin", "Orders\OrderShoppingByCustomerDeliveryController@getAdmin");
            Route::get("orderShoppingByCustomerDelivery/listSelect2", "Orders\OrderShoppingByCustomerDeliveryController@getListSelect2");

            Route::post("orderShoppingCartByDetails/save", "Orders\OrderShoppingCartByDetailsController@saveData");
            Route::post("orderShoppingCartByDetails/admin", "Orders\OrderShoppingCartByDetailsController@getAdmin");
            Route::get("orderShoppingCartByDetails/listSelect2", "Orders\OrderShoppingCartByDetailsController@getListSelect2");

            Route::post("orderPaymentsDocument/save", "Frontend\OrderPaymentsDocumentController@saveData");
            Route::post("orderPaymentsDocument/admin", "Frontend\OrderPaymentsDocumentController@getAdmin");
            Route::get("orderPaymentsDocument/listSelect2", "Frontend\OrderPaymentsDocumentController@getListSelect2");


            /*    TAX*/
            Route::post("tax/save", "Tax\TaxController@saveData");
            Route::post("tax/admin", "Tax\TaxController@getAdmin");
            Route::get("tax/listSelect2", "Tax\TaxController@getListSelect2");
            Route::get("tax/manager", "Tax\TaxController@getManager");

            Route::post("taxByBusiness/save", "Tax\TaxByBusinessController@saveData");
            Route::post("taxByBusiness/admin", "Tax\TaxByBusinessController@getAdmin");
            Route::get("taxByBusiness/listSelect2", "Tax\TaxByBusinessController@getListSelect2");


            Route::post("addWishListProduct", "Frontend\FrontendController@addWishListProduct");


            Route::post("businessByLanguage/save", "Language\BusinessByLanguageController@saveData");
            Route::post("businessByLanguage/admin", "Language\BusinessByLanguageController@getAdmin");
            Route::get("businessByLanguage/listSelect2", "Language\BusinessByLanguageController@getListSelect2");

            //SHOP
            Route::post("language/save", "Language\LanguageController@saveData");
            Route::post("language/admin", "Language\LanguageController@getAdmin");
            Route::get("language/listSelect2", "Language\LanguageController@getListSelect2");
            Route::get("language/manager", "Language\LanguageController@getManager");

            Route::post("languageProductCategory/save", "Language\LanguageProductCategoryController@saveData");
            Route::post("languageProductCategory/admin", "Language\LanguageProductCategoryController@getAdmin");
            Route::get("languageProductCategory/listSelect2", "Language\LanguageProductCategoryController@getListSelect2");
            Route::post("languageProductCategory/delete", "Language\LanguageProductCategoryController@setDelete");

            Route::post("languageProductSubcategory/save", "Language\LanguageProductSubcategoryController@saveData");
            Route::post("languageProductSubcategory/admin", "Language\LanguageProductSubcategoryController@getAdmin");
            Route::get("languageProductSubcategory/listSelect2", "Language\LanguageProductSubcategoryController@getListSelect2");
            Route::post("languageProductSubcategory/delete", "Language\LanguageProductSubcategoryController@setDelete");

            Route::post("languageProductTrademark/save", "Language\LanguageProductTrademarkController@saveData");
            Route::post("languageProductTrademark/admin", "Language\LanguageProductTrademarkController@getAdmin");
            Route::get("languageProductTrademark/listSelect2", "Language\LanguageProductTrademarkController@getListSelect2");
            Route::post("languageProductTrademark/delete", "Language\LanguageProductTrademarkController@setDelete");

            Route::post("languageProductMeasureType/save", "Language\LanguageProductMeasureTypeController@saveData");
            Route::post("languageProductMeasureType/admin", "Language\LanguageProductMeasureTypeController@getAdmin");
            Route::get("languageProductMeasureType/listSelect2", "Language\LanguageProductMeasureTypeController@getListSelect2");
            Route::post("languageProductMeasureType/delete", "Language\LanguageProductMeasureTypeController@setDelete");

            Route::post("languageProduct/save", "Language\LanguageProductController@saveData");
            Route::post("languageProduct/admin", "Language\LanguageProductController@getAdmin");
            Route::get("languageProduct/listSelect2", "Language\LanguageProductController@getListSelect2");
            Route::post("languageProduct/delete", "Language\LanguageProductController@setDelete");

            Route::post("languageTemplateAboutUs/save", "Language\LanguageTemplateAboutUsController@saveData");
            Route::post("languageTemplateAboutUs/admin", "Language\LanguageTemplateAboutUsController@getAdmin");
            Route::get("languageTemplateAboutUs/listSelect2", "Language\LanguageTemplateAboutUsController@getListSelect2");
            Route::post("languageTemplateAboutUs/delete", "Language\LanguageTemplateAboutUsController@setDelete");

            Route::post("languageTemplateAboutUs/save", "Language\LanguageTemplateAboutUsController@saveData");
            Route::post("languageTemplateAboutUs/admin", "Language\LanguageTemplateAboutUsController@getAdmin");
            Route::get("languageTemplateAboutUs/listSelect2", "Language\LanguageTemplateAboutUsController@getListSelect2");
            Route::post("languageTemplateAboutUs/delete", "Language\LanguageTemplateAboutUsController@setDelete");

            Route::post("languageTemplateAboutUsByData/save", "Language\LanguageTemplateAboutUsByDataController@saveData");
            Route::post("languageTemplateAboutUsByData/admin", "Language\LanguageTemplateAboutUsByDataController@getAdmin");
            Route::get("languageTemplateAboutUsByData/listSelect2", "Language\LanguageTemplateAboutUsByDataController@getListSelect2");
            Route::post("languageTemplateAboutUsByData/delete", "Language\LanguageTemplateAboutUsByDataController@setDelete");

            Route::post("languageTemplateServices/save", "Language\LanguageTemplateServicesController@saveData");
            Route::post("languageTemplateServices/admin", "Language\LanguageTemplateServicesController@getAdmin");
            Route::get("languageTemplateServices/listSelect2", "Language\LanguageTemplateServicesController@getListSelect2");
            Route::post("languageTemplateServices/delete", "Language\LanguageTemplateServicesController@setDelete");

            Route::post("languageTemplateServicesByData/save", "Language\LanguageTemplateServicesByDataController@saveData");
            Route::post("languageTemplateServicesByData/admin", "Language\LanguageTemplateServicesByDataController@getAdmin");
            Route::get("languageTemplateServicesByData/listSelect2", "Language\LanguageTemplateServicesByDataController@getListSelect2");
            Route::post("languageTemplateServicesByData/delete", "Language\LanguageTemplateServicesByDataController@setDelete");

            Route::post("languageTemplatePolicies/save", "Language\LanguageTemplatePoliciesController@saveData");
            Route::post("languageTemplatePolicies/admin", "Language\LanguageTemplatePoliciesController@getAdmin");
            Route::get("languageTemplatePolicies/listSelect2", "Language\LanguageTemplatePoliciesController@getListSelect2");
            Route::post("languageTemplatePolicies/delete", "Language\LanguageTemplatePoliciesController@setDelete");

            Route::post("languageProductColor/save", "Language\LanguageProductColorController@saveData");
            Route::post("languageProductColor/admin", "Language\LanguageProductColorController@getAdmin");
            Route::get("languageProductColor/listSelect2", "Language\LanguageProductColorController@getListSelect2");
            Route::post("languageProductColor/delete", "Language\LanguageProductColorController@setDelete");

            Route::post("languageTemplateSliderByImages/save", "Language\LanguageTemplateSliderByImagesController@saveData");
            Route::post("languageTemplateSliderByImages/admin", "Language\LanguageTemplateSliderByImagesController@getAdmin");
            Route::post("languageTemplateSliderByImages/saveActivitiesGamification", "Language\LanguageTemplateSliderByImagesController@saveDataActivitiesGamification");
            Route::post("languageTemplateSliderByImages/adminActivitiesGamification", "Language\LanguageTemplateSliderByImagesController@getAdminActivitiesGamification");
            Route::post("languageTemplateSliderByImages/saveRewardsGamification", "Language\LanguageTemplateSliderByImagesController@saveDataRewardsGamification");
            Route::post("languageTemplateSliderByImages/adminRewardsGamification", "Language\LanguageTemplateSliderByImagesController@getAdminRewardsGamification");
            Route::get("languageTemplateSliderByImages/listSelect2", "Language\LanguageTemplateSliderByImagesController@getListSelect2");
            Route::post("languageTemplateSliderByImages/delete", "Language\LanguageTemplateSliderByImagesController@setDelete");
            Route::post("languageTemplateSliderByImages/deleteRewardsGamification", "Language\LanguageTemplateSliderByImagesController@setDeleteRewardsGamification");
            Route::post("languageTemplateSliderByImages/deleteActivitiesGamification", "Language\LanguageTemplateSliderByImagesController@setDeleteActivitiesGamification");

            Route::post("repairProductByBusiness/save", "Fix\RepairProductByBusinessController@saveData");
            Route::post("repairProductByBusiness/admin", "Fix\RepairProductByBusinessController@getAdmin");
            Route::get("repairProductByBusiness/listSelect2", "Fix\RepairProductByBusinessController@getListSelect2")->name("repairProductByBusinessListSelect2");

            Route::post("repair/save", "Fix\RepairController@saveData");
            Route::post("repair/admin", "Fix\RepairController@getAdmin");
            Route::post("repair/getResults", "Fix\RepairController@getResults");
            Route::get("repair/listSelect2", "Fix\RepairController@getListSelect2");

            Route::post("businessByDiscount/save", "Discounts\BusinessByDiscountController@saveData");
            Route::post("businessByDiscount/admin", "Discounts\BusinessByDiscountController@getAdmin");
            Route::get("businessByDiscount/listSelect2", "Discounts\BusinessByDiscountController@getListSelect2");


            Route::post("discountByProducts/save", "Discounts\DiscountByProductsController@saveData");
            Route::post("discountByProducts/admin", "Discounts\DiscountByProductsController@getAdmin");
            Route::get("discountByProducts/listSelect2", "Discounts\DiscountByProductsController@getListSelect2");
            Route::post("discountByProducts/adminProducts", "Discounts\DiscountByProductsController@getAdminProducts");
            Route::post("discountByProducts/detailsProducts", "Discounts\DiscountByProductsController@getDetailsProducts");


            Route::post("discountByCustomers/save", "Discounts\DiscountByCustomersController@saveData");
            Route::post("discountByCustomers/admin", "Discounts\DiscountByCustomersController@getAdmin");
            Route::get("discountByCustomers/listSelect2", "Discounts\DiscountByCustomersController@getListSelect2");

            //shippingRate

            Route::post("shippingRateBusiness/save", "ShippingRate\ShippingRateBusinessController@saveData");
            Route::post("shippingRateBusiness/admin", "ShippingRate\ShippingRateBusinessController@getAdmin");
            Route::get("shippingRateBusiness/listSelect2", "ShippingRate\ShippingRateBusinessController@getListSelect2");
            Route::get("shippingRateBusiness/manager", "ShippingRate\ShippingRateBusinessController@getManager");

            Route::post("shippingRateKindsOfWay/save", "ShippingRate\ShippingRateKindsOfWayController@saveData");
            Route::post("shippingRateKindsOfWay/admin", "ShippingRate\ShippingRateKindsOfWayController@getAdmin");
            Route::get("shippingRateKindsOfWay/listSelect2", "ShippingRate\ShippingRateKindsOfWayController@getListSelect2");
            Route::get("shippingRateKindsOfWay/manager", "ShippingRate\ShippingRateKindsOfWayController@getManager");

            Route::post("shippingRateServices/save", "ShippingRate\ShippingRateServicesController@saveData");
            Route::post("shippingRateServices/admin", "ShippingRate\ShippingRateServicesController@getAdmin");
            Route::get("shippingRateServices/listSelect2", "ShippingRate\ShippingRateServicesController@getListSelect2");
            Route::get("shippingRateServices/manager", "ShippingRate\ShippingRateServicesController@getManager");

            Route::post("shippingRateBusinessByMinWeight/save", "ShippingRate\ShippingRateBusinessByMinWeightController@saveData");
            Route::post("shippingRateBusinessByMinWeight/admin", "ShippingRate\ShippingRateBusinessByMinWeightController@getAdmin");
            Route::get("shippingRateBusinessByMinWeight/listSelect2", "ShippingRate\ShippingRateBusinessByMinWeightController@getListSelect2");

            Route::post("shippingRateServices/save", "ShippingRate\ShippingRateServicesController@saveData");
            Route::post("shippingRateServices/admin", "ShippingRate\ShippingRateServicesController@getAdmin");
            Route::get("shippingRateServices/listSelect2", "ShippingRate\ShippingRateServicesController@getListSelect2");

            Route::post("shippingRateBusinessByConversionFactor/save", "ShippingRate\ShippingRateBusinessByConversionFactorController@saveData");
            Route::post("shippingRateBusinessByConversionFactor/admin", "ShippingRate\ShippingRateBusinessByConversionFactorController@getAdmin");
            Route::get("shippingRateBusinessByConversionFactor/listSelect2", "ShippingRate\ShippingRateBusinessByConversionFactorController@getListSelect2");


            Route::post("businessByShippingRate/save", "ShippingRate\BusinessByShippingRateController@saveData");
            Route::post("businessByShippingRate/admin", "ShippingRate\BusinessByShippingRateController@getAdmin");
            Route::get("businessByShippingRate/listSelect2", "ShippingRate\BusinessByShippingRateController@getListSelect2");


            Route::post("businessByGamification/save", "Gamification\BusinessByGamificationController@saveData");
            Route::post("businessByGamification/admin", "Gamification\BusinessByGamificationController@getAdmin");
            Route::get("businessByGamification/listSelect2", "Gamification\BusinessByGamificationController@getListSelect2");

            Route::post("gamificationTypeActivity/save", "Gamification\GamificationTypeActivityController@saveData");
            Route::post("gamificationTypeActivity/admin", "Gamification\GamificationTypeActivityController@getAdmin");
            Route::get("gamificationTypeActivity/listSelect2", "Gamification\GamificationTypeActivityController@getListSelect2");

            Route::post("gamificationByProcess/save", "Gamification\GamificationByProcessController@saveData");
            Route::post("gamificationByProcess/admin", "Gamification\GamificationByProcessController@getAdmin");
            Route::get("gamificationByProcess/listSelect2", "Gamification\GamificationByProcessController@getListSelect2");

            Route::post("gamificationByRewards/save", "Gamification\GamificationByRewardsController@saveData");
            Route::post("gamificationByRewards/admin", "Gamification\GamificationByRewardsController@getAdmin");
            Route::get("gamificationByRewards/listSelect2", "Gamification\GamificationByRewardsController@getListSelect2");


            Route::post('customerProfile/save', 'Crm\CustomerController@saveDataProfile');//CMS-TEMPLATE-MY-PROFILE-ROUTE

            /*hospital*/
            Route::post("allergies/save", "Hospital\AllergiesController@saveData");
            Route::post("allergies/admin", "Hospital\AllergiesController@getAdmin");
            Route::get("allergies/listSelect2", "Hospital\AllergiesController@getListSelect2");

            Route::post("habits/save", "Hospital\HabitsController@saveData");
            Route::post("habits/admin", "Hospital\HabitsController@getAdmin");
            Route::get("habits/listSelect2", "Hospital\HabitsController@getListSelect2");

            Route::post("historyClinic/saveDataProfilePatient", "Hospital\HistoryClinicController@saveDataProfilePatient");
            Route::post("historyClinic/admin", "Hospital\HistoryClinicController@getAdmin");
            Route::get("historyClinic/listSelect2", "Hospital\HistoryClinicController@getListSelect2");

            Route::post("antecedentByHistoryClinic/save", "Hospital\AntecedentByHistoryClinicController@saveData");
            Route::post("antecedentByHistoryClinic/admin", "Hospital\AntecedentByHistoryClinicController@getAdmin");
            Route::get("antecedentByHistoryClinic/listSelect2", "Hospital\AntecedentByHistoryClinicController@getListSelect2");

            Route::post("medicalConsultationByPatient/save", "Hospital\MedicalConsultationByPatientController@saveData");
            Route::post("medicalConsultationByPatient/admin", "Hospital\MedicalConsultationByPatientController@getAdmin");
            Route::get("medicalConsultationByPatient/listSelect2", "Hospital\MedicalConsultationByPatientController@getListSelect2");

            /*TREATMENT*/
            Route::post("treatmentByPatient/save", "Hospital\TreatmentByPatientController@saveData");
            Route::post("treatmentByPatient/admin", "Hospital\TreatmentByPatientController@getAdmin");
            Route::get("treatmentByPatient/listSelect2", "Hospital\TreatmentByPatientController@getListSelect2");

            Route::get("typesPaymentsByAccount/listSelect2", "Hospital\TypesPaymentsByAccountController@getListSelect2");
            Route::get("treatmentByBreakdownPayment/listSelect2", "Hospital\TreatmentByBreakdownPaymentController@getListSelect2");


            Route::get("product/getProductService", "Products\ProductController@getProductService");


            Route::post("treatmentByAdvance/save", "Hospital\TreatmentByAdvanceController@saveData");
            Route::post("treatmentByAdvance/admin", "Hospital\TreatmentByAdvanceController@getAdmin");
            Route::get("treatmentByAdvance/listSelect2", "Hospital\TreatmentByAdvanceController@getListSelect2");


            Route::post("treatmentByIndebtednessPayingInit/save", "Hospital\TreatmentByIndebtednessPayingInitController@saveData");
            Route::post("treatmentByIndebtednessPayingInit/admin", "Hospital\TreatmentByIndebtednessPayingInitController@getAdmin");
            Route::get("treatmentByIndebtednessPayingInit/listSelect2", "Hospital\TreatmentByIndebtednessPayingInitController@getListSelect2");
            Route::post("treatmentByIndebtednessPayingInit/getManagement", "Hospital\TreatmentByIndebtednessPayingInitController@getManagement");


            Route::post("treatmentByPayment/save", "Hospital\TreatmentByPaymentController@saveData");
            Route::post("treatmentByPayment/admin", "Hospital\TreatmentByPaymentController@getAdmin");
            Route::get("treatmentByPayment/listSelect2", "Hospital\TreTreatmentByPaymentControlleratmentByPayment@getListSelect2");
            Route::post("treatmentByPayment/getManagement", "Hospital\TreatmentByPaymentController@getManagement");


            Route::post("odontogramByPatient/save", "Hospital\OdontogramByPatientController@saveData");
            Route::post("odontogramByPatient/admin", "Hospital\OdontogramByPatientController@getAdmin");
            Route::get("odontogramByPatient/listSelect2", "Hospital\OdontogramByPatientController@getListSelect2");

            Route::post("historyClinic/getDataHistoryClinicLog", "Hospital\HistoryClinicController@getDataHistoryClinicLog");


            Route::get("product/events/getProductService", "Products\ProductController@getEventsProductService");


            Route::post("executePaymentCashEvents", "Payment\PaymentController@executePaymentCashEvents")->name('executePaymentCashEvents');

            Route::post("getDataPaymentsManagement", "EventsTrails\EventsTrailsRegistrationPaymentsByBusinessController@getDataPaymentsManagement")->name('getDataPaymentsManagement');
            Route::post("getDataPaymentsManagementEvent", "EventsTrails\EventsTrailsRegistrationPaymentsByBusinessController@getDataPaymentsManagement")->name('getDataPaymentsManagementEvent');


            Route::post("eventsTrailsRegistrationPoints/deletePointSale", "EventsTrails\EventsTrailsRegistrationPointsController@deletePointSale")->name('deletePointSale');


            Route::post("productByRouteMap/save", "Products\ProductByRouteMapController@saveData");
            Route::post("productByRouteMap/getRouteProduct", "Products\ProductByRouteMapController@getRouteProduct");
            Route::post("productByRouteMap/deleteRouteProduct", "Products\ProductByRouteMapController@deleteRouteProduct");

            Route::get("routesMap/listSelect2", "Routes\BusinessByRoutesMapController@getListSelect2");


            Route::post("mailingTemplate/save", "Mailing\MailingTemplateController@saveData");
            Route::post("mailingTemplate/admin", "Mailing\MailingTemplateController@getAdmin");
            Route::get("mailingTemplate/listSelect2", "Mailing\MailingTemplateController@getListSelect2");

            Route::post('mailingByDataSend/saveDataSend', 'Mailing\MailingByDataSendController@saveDataSend');

            Route::get('documents/generatePdf', 'Documents\ElectronicSignatureController@generatePdf')->name('generatePdf');

//SALES
            Route::post("cajaTipoBillete/save", "AccountingCash\CajaTipoBilleteController@saveData");
            Route::post("cajaTipoBillete/admin", "AccountingCash\CajaTipoBilleteController@getAdmin");
            Route::get("cajaTipoBillete/listSelect2", "AccountingCash\CajaTipoBilleteController@getListSelect2");
            Route::get("cajaTipoBillete/manager", "AccountingCash\CajaTipoBilleteController@getManager");

            Route::post("cajaCatalogoBillete/save", "AccountingCash\CajaCatalogoBilleteController@saveData");
            Route::post("cajaCatalogoBillete/admin", "AccountingCash\CajaCatalogoBilleteController@getAdmin");
            Route::get("cajaCatalogoBillete/listSelect2", "AccountingCash\CajaCatalogoBilleteController@getListSelect2");
            Route::get("cajaCatalogoBillete/manager", "AccountingCash\CajaCatalogoBilleteController@getManager");

            Route::post("cajaCatalogoTipoFraccion/save", "AccountingCash\CajaCatalogoTipoFraccionController@saveData");
            Route::post("cajaCatalogoTipoFraccion/admin", "AccountingCash\CajaCatalogoTipoFraccionController@getAdmin");
            Route::get("cajaCatalogoTipoFraccion/listSelect2", "AccountingCash\CajaCatalogoTipoFraccionController@getListSelect2");
            Route::get("cajaCatalogoTipoFraccion/manager", "AccountingCash\CajaCatalogoTipoFraccionController@getManager");

            Route::post("entityPlans/save", "Accounting\EntityPlansController@saveData");
            Route::post("entityPlans/admin", "Accounting\EntityPlansController@getAdmin");
            Route::get("entityPlans/listSelect2", "Accounting\EntityPlansController@getListSelect2");
            Route::get("entityPlans/manager", "Accounting\EntityPlansController@getManager");

            Route::post("entityPositionFiscal/save", "Accounting\EntityPositionFiscalController@saveData");
            Route::post("entityPositionFiscal/admin", "Accounting\EntityPositionFiscalController@getAdmin");
            Route::get("entityPositionFiscal/listSelect2", "Accounting\EntityPositionFiscalController@getListSelect2");
            Route::get("entityPositionFiscal/manager", "Accounting\EntityPositionFiscalController@getManager");


            Route::post("allowProcessesThreads/save", "AllowProcessesThreads\AllowProcessesThreadsController@saveData");
            Route::post("allowProcessesThreads/admin", "AllowProcessesThreads\AllowProcessesThreadsController@getAdmin");
            Route::get("allowProcessesThreads/listSelect2", "AllowProcessesThreads\AllowProcessesThreadsController@getListSelect2");
            Route::get("allowProcessesThreads/manager", "AllowProcessesThreads\AllowProcessesThreadsController@getManager");

            Route::post("typesPayments/save", "Accounting\TypesPaymentsController@saveData");
            Route::post("typesPayments/admin", "Accounting\TypesPaymentsController@getAdmin");
            Route::get("typesPayments/listSelect2", "Accounting\TypesPaymentsController@getListSelect2");
            Route::get("typesPayments/manager", "Accounting\TypesPaymentsController@getManager");

            Route::get("crm/customer/listCustomers", "Crm\CustomerController@getListCustomers")->name('getListCustomersPointOfSales');

            Route::get("products/product/getListProductServices", "Products\ProductController@getListProductServices")->name('getListProductServicesPointOfSales');
            Route::post("invoiceSales/validateInvoiceExist", "Invoices\InvoiceSaleController@getValidateInvoiceExist")->name('getValidateInvoiceExistPointOfSales');


            Route::post("invoiceSales/saveInvoicePointOfSales", "Invoices\InvoiceSaleController@saveInvoicePointOfSales")->name('saveInvoicePointOfSales');
            Route::post("invoiceSales/saveInvoicePointOfSales", "Invoices\InvoiceSaleController@saveInvoicePointOfSales")->name('saveInvoiceRentalProduct');

            Route::get("invoices/getInvoiceList", "Invoices\InvoiceSaleController@getInvoiceList")->name('getInvoiceList');


            Route::post("invoiceSalesRetentions/validateInvoiceExist", "Invoices\InvoiceSaleByRetentionController@getValidateInvoiceExist")->name('getValidateInvoiceRetentionExistPointOfSales');


            Route::post("retentionTaxSubType/save", "Accounting\RetentionTaxSubTypeController@saveData");
            Route::post("retentionTaxSubType/admin", "Accounting\RetentionTaxSubTypeController@getAdmin");
            Route::get("retentionTaxSubType/listSelect2", "Accounting\RetentionTaxSubTypeController@getListSelect2");
            Route::get("retentionTaxSubType/manager", "Accounting\RetentionTaxSubTypeController@getManager");
            Route::get("retentionTaxSubType/getListSubTRI", "Accounting\RetentionTaxSubTypeController@getListSubTRI")->name('getListSubTRIPointOfSales');
            Route::get("retentionTaxSubType/getListSubTRI", "Accounting\RetentionTaxSubTypeController@getListSubTRI")->name('getListSubTRIRentalProduct');

            Route::post("retentionTaxType/save", "Accounting\RetentionTaxTypeController@saveData");
            Route::post("retentionTaxType/admin", "Accounting\RetentionTaxTypeController@getAdmin");
            Route::get("retentionTaxType/listSelect2", "Accounting\RetentionTaxTypeController@getListSelect2");
            Route::get("retentionTaxType/manager", "Accounting\RetentionTaxTypeController@getManager");
            Route::get("retentionTaxType/typeRetentionsByTax", "Accounting\RetentionTaxTypeController@getTypeRetentionsByTaxPointOfSales")->name('getTypeRetentionsByTaxPointOfSales');
            Route::get("retentionTaxType/typeRetentionsByTax", "Accounting\RetentionTaxTypeController@getTypeRetentionsByTaxPointOfSales")->name('getTypeRetentionsByTaxRentalProduct');


            Route::post("voucherType/save", "Accounting\VoucherTypeController@saveData");
            Route::post("voucherType/admin", "Accounting\VoucherTypeController@getAdmin");
            Route::get("voucherType/listSelect2", "Accounting\VoucherTypeController@getListSelect2");
            Route::get("voucherType/manager", "Accounting\VoucherTypeController@getManager");


            Route::post("invoiceSale/admin", "Invoices\InvoiceSaleController@getInvoiceSaleAdmin")->name('getInvoiceSaleAdmin');
            Route::post("invoiceSale/saveAnnulmentBilling", "Invoices\InvoiceSaleController@saveAnnulmentBilling")->name('saveAnnulmentBilling');


            Route::post("invoiceSaleByIndebtednessPayingInit/saveIndebtedness", "Invoices\InvoiceSaleByIndebtednessPayingInitController@saveIndebtedness")->name('saveIndebtednessInit');


            Route::post("invoiceSaleByPayment/savePayment", "Invoices\InvoiceSaleByPaymentController@savePaymentInvoiceDebit")->name('savePaymentInvoiceDebit');
            Route::post("invoiceSaleByPayment/adminPayments", "Invoices\InvoiceSaleByPaymentController@getAdminPayments")->name('getAdminPayments');

            Route::get("invoicesSaleByBreakdownPayment/getPaymentsCurrentS2", "Invoices\InvoiceSaleByBreakdownPaymentController@getPaymentsCurrentS2")->name('getPaymentsCurrentS2');
            Route::get("typesPayments/getTypesPaymentsS2", "Accounting\TypesPaymentsController@getTypesPaymentsS2")->name('getTypesPaymentsS2');


            Route::get("typesPaymentsByAccount/getAccountingPaymentsS2", "Accounting\TypesPaymentsByAccountController@getAccountingPaymentsS2")->name('getAccountingPaymentsS2');


            Route::get("mikrotik/managerEvents", "Mikrotik\MikrotikController@getManagerEvents")->name('managerEventsMikrotik');
            Route::post("mikrotik/managerEventResults", "Mikrotik\MikrotikController@getManagerEventResults")->name('managerEventResultsMikrotik');


            Route::post("mikrotikRateLimit/save", "Mikrotik\MikrotikRateLimitController@saveData");
            Route::post("mikrotikRateLimit/admin", "Mikrotik\MikrotikRateLimitController@getAdmin");
            Route::get("mikrotikRateLimit/listSelect2", "Mikrotik\MikrotikRateLimitController@getListSelect2");

            Route::post("mikrotikTypeConection/save", "Mikrotik\MikrotikTypeConectionController@saveData");
            Route::post("mikrotikTypeConection/admin", "Mikrotik\MikrotikTypeConectionController@getAdmin");
            Route::get("mikrotikTypeConection/listSelect2", "Mikrotik\MikrotikTypeConectionController@getListSelect2");

            Route::post("mikrotikDhcpServer/save", "Mikrotik\MikrotikDhcpServerController@saveData");
            Route::post("mikrotikDhcpServer/admin", "Mikrotik\MikrotikDhcpServerController@getAdmin");
            Route::get("mikrotikDhcpServer/listSelect2", "Mikrotik\MikrotikDhcpServerController@getListSelect2");

            Route::post("mikrotikByCustomerEngagement/save", "Mikrotik\MikrotikByCustomerEngagementController@saveData");

            Route::post("mikrotikByCustomerEngagement/admin", "Mikrotik\MikrotikByCustomerEngagementController@getAdmin");
            Route::get("mikrotikByCustomerEngagement/listSelect2", "Mikrotik\MikrotikByCustomerEngagementController@getListSelect2");
            Route::post("mikrotikByCustomerEngagement/managerDisabledEnabledCustomer", "Mikrotik\MikrotikByCustomerEngagementController@managerDisabledEnabledCustomer")->name("managerDisabledEnabledCustomer");


            Route::post("businessByInvoiceSaleRental/admin", "RentalProducts\BusinessByInvoiceSaleRentalController@getAdmin");
            Route::get("businessByInvoiceSaleRental/listSelect2", "RentalProducts\BusinessByInvoiceSaleRentalController@getListSelect2");
            Route::post("businessByInvoiceSaleRental/managerDisabledEnabledCustomer", "RentalProducts\BusinessByInvoiceSaleRentalController@managerDisabledEnabledCustomer")->name("managerDisabledEnabledCustomer");


            Route::post("business/deliveryByBusinessManager/save", "DeliveryByBusinessManager\DeliveryByBusinessManagerController@saveData");
            Route::post("business/deliveryByBusinessManager/admin", "DeliveryByBusinessManager\DeliveryByBusinessManagerController@getAdmin");
            Route::get("business/deliveryByBusinessManager/getListCustomer", "DeliveryByBusinessManager\DeliveryByBusinessManagerController@getListCustomer");
            Route::get("business/deliveryByBusinessManager/getListAddressByCustomer", "DeliveryByBusinessManager\DeliveryByBusinessManagerController@getListAddressByCustomer");
            Route::get("business/deliveryByBusinessManager/getListPhoneByCustomer", "DeliveryByBusinessManager\DeliveryByBusinessManagerController@getListPhoneByCustomer");
            Route::post('business/deliveryByBusinessManager/uniqueNumberInvoice', 'DeliveryByBusinessManager\DeliveryByBusinessManagerController@getUniqueNumberInvoice'); //

//ACTIONS MANAGER

            Route::post('humanResourcesOrganizationalChartArea/save', 'HumanResources\HumanResourcesOrganizationalChartAreaController@saveData'); //
            Route::post('humanResourcesOrganizationalChartArea/admin', 'HumanResources\HumanResourcesOrganizationalChartAreaController@getAdmin'); //
            Route::get('humanResourcesOrganizationalChartArea/listActionsParent', 'HumanResources\HumanResourcesOrganizationalChartAreaController@getListActionsParent'); //
            Route::get('humanResourcesOrganizationalChartArea/listData', 'HumanResources\HumanResourcesOrganizationalChartAreaController@getListData'); //


            Route::post('helpdeskTypes/save', 'Helpdesk\HelpdeskTypesController@saveData')->name("HelpdeskTypesSaveData"); //
            Route::post('helpdeskTypes/admin', 'Helpdesk\HelpdeskTypesController@getAdmin')->name("HelpdeskTypesAdmin"); //


            Route::post('workPlanningHeader/save', 'WorkPlanning\WorkPlanningHeaderController@saveData'); //
            Route::post('workPlanningHeader/admin', 'WorkPlanning\WorkPlanningHeaderController@getAdmin'); //
            Route::get('workPlanningHeader/listData', 'WorkPlanning\WorkPlanningHeaderController@getListData'); //

            Route::post('workPlanningHeaderByResources/save', 'WorkPlanning\WorkPlanningHeaderByResourcesController@saveData'); //
            Route::post('workPlanningHeaderByResources/admin', 'WorkPlanning\WorkPlanningHeaderByResourcesController@getAdmin'); //
            Route::get('workPlanningHeaderByResources/listData', 'WorkPlanning\WorkPlanningHeaderByResourcesController@getListData'); //


            Route::post('projectHeader/save', 'Projects\ProjectHeaderController@saveData'); //
            Route::post('projectHeader/admin', 'Projects\ProjectHeaderController@getAdmin'); //
            Route::get('projectHeader/listData', 'Projects\ProjectHeaderController@getListData'); //

            Route::post('projectHeaderByResources/save', 'Projects\ProjectHeaderByResourcesController@saveData'); //
            Route::post('projectHeaderByResources/admin', 'Projects\ProjectHeaderByResourcesController@getAdmin'); //
            Route::get('projectHeaderByResources/listData', 'Projects\ProjectHeaderByResourcesController@getListData'); //

            Route::post('humanResourcesOrganizationalChartAreaByManager/save', 'HumanResources\HumanResourcesOrganizationalChartAreaByManagerController@saveData'); //
            Route::post('humanResourcesOrganizationalChartAreaByManager/getResponsible', 'HumanResources\HumanResourcesOrganizationalChartAreaByManagerController@getResponsible'); //

            Route::post('humanResourcesDepartmentByManager/save', 'HumanResources\HumanResourcesDepartmentByManagerController@saveData'); //
            Route::post('humanResourcesDepartmentByManager/getResponsible', 'HumanResources\HumanResourcesDepartmentByManagerController@getResponsible'); //

            Route::post('humanResourcesDepartmentByOrganizationalChartArea/save', 'HumanResources\HumanResourcesDepartmentByOrganizationalChartAreaController@saveData'); //
            Route::post('humanResourcesDepartmentByOrganizationalChartArea/getDataByChartArea', 'HumanResources\HumanResourcesDepartmentByOrganizationalChartAreaController@getDataByChartArea'); //


            //PAYROLL
            Route::post('humanResourcesShift/save', 'PayRoll\HumanResourcesShiftController@saveData'); //
            Route::post('humanResourcesShift/admin', 'PayRoll\HumanResourcesShiftController@getAdmin'); //
            Route::get('humanResourcesShift/listData', 'PayRoll\HumanResourcesShiftController@getListData'); //

            Route::post('humanResourcesScheduleType/save', 'PayRoll\HumanResourcesScheduleTypeController@saveData'); //
            Route::post('humanResourcesScheduleType/admin', 'PayRoll\HumanResourcesScheduleTypeController@getAdmin'); //
            Route::get('humanResourcesScheduleType/listData', 'PayRoll\HumanResourcesScheduleTypeController@getListData'); //

            Route::post('humanResourcesPermissionType/save', 'PayRoll\HumanResourcesPermissionTypeController@saveData'); //
            Route::post('humanResourcesPermissionType/admin', 'PayRoll\HumanResourcesPermissionTypeController@getAdmin'); //
            Route::get('humanResourcesPermissionType/listData', 'PayRoll\HumanResourcesPermissionTypeController@getListData'); //

            Route::post('humanResourcesDepartmentByRestDay/save', 'PayRoll\HumanResourcesDepartmentByRestDayController@saveData'); //
            Route::post('humanResourcesDepartmentByRestDay/admin', 'PayRoll\HumanResourcesDepartmentByRestDayController@getAdmin'); //
            Route::get('humanResourcesDepartmentByRestDay/listData', 'PayRoll\HumanResourcesDepartmentByRestDayController@getListData'); //


            //BUSINESS-MANAGER-CRM-CUSTOMER-PRESENTATION-ROUTES
            Route::post('business/secretaryProcessesByCustomerPresentation/admin', 'ProsecutorOffice\SecretaryProcessesByCustomerPresentationController@getAdmin')->name('secretaryProcessesByCustomerPresentationAdmin');
            Route::post('business/secretaryProcessesByCustomerPresentation/save', 'ProsecutorOffice\SecretaryProcessesByCustomerPresentationController@saveData')->name('secretaryProcessesByCustomerPresentationSave');
            Route::get('business/customer/listS2Customer', 'Crm\CustomerController@getListS2Customer'); //--

//RantiApp

            Route::post('profile/user/accountGamificationByMovementAdmin', 'Gamification\AccountGamificationByMovementController@getAdmin')->name('accountGamificationByMovementAdmin'); //

        });
    }
}

