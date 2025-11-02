<input id="action_get_form" type="hidden" value="{{ action("Hospital\PatientController@getFormPatient") }}"/>
<input id="action_save_patient" type="hidden" value="{{ action("Hospital\PatientController@postSave") }}"/>
<input id="action_load_patients" type="hidden" value="{{ action("Hospital\PatientController@getListPatients") }}"/>
<input id="action_load_details" type="hidden" value="{{ action("Hospital\PatientController@getDetailsPatient") }}"/>
<input id="action_validate_document" type="hidden" value="{{ action("Hospital\PatientController@postIsDocumentValid") }}"/>
<input id="action_get_management" type="hidden" value="{{ action("Hospital\PatientController@getManagament") }}"/>
{{--
ACTIONS MANAGEMENT--}}
<input id="action_get_wizard" type="hidden"
       value="{{ action("Hospital\MedicalConsultationByPatientController@getFormWizard") }}"/>
<!--STEP1 ACTIONS -->
<input id="action_validate_document_step1" type="hidden"
       value="{{ action("Hospital\PatientController@postIsDocumentValid") }}"/>
<input id="action_get_patients_form_step1" type="hidden"
       value="{{ action("Hospital\PatientController@getFormPatientModal") }}"/>
<input id="action_load_patients_select2_step1" type="hidden"
       value="{{ action("Hospital\PatientController@getListSelect2") }}"/>
<input id="action_load_mConsultation_admin" type="hidden"
       value="{{ action("Hospital\MedicalConsultationByPatientController@getListMedicalConsultationByPatientsAdmin") }}"/>
<input id="action_load_mConsultation_step1" type="hidden"
       value="{{ action("Hospital\MedicalConsultationByPatientController@getListMedicalConsultationByPatients") }}"/>
<input id="action_load_details_step1" type="hidden"
       value="{{ action("Hospital\PatientController@getDetailsPatientStep1") }}"/>
<input id="action_save_patient_step1" type="hidden"
       value="{{ action("Hospital\PatientController@postSave") }}"/>
<!--END : STEP1 ACTIONS -->
<!-- INIT: STEP2 -->

<!-- INIT: ANTECEDENTS -->
@include('partials.modal',[
'title'=>'Nuevo Antecedente',
'id'=>'modal_antecedent_by_history_clinic',
'action_buttons'=>[
    [
    'form'=>'antecedentByHistoryClinic_form',//debe ir igual q la en l controlador
    'id'=>'btn_save_antecedent_by_history_clinic',
    'label'=>'Guardar',
    'color'=>'btn-primary',
    "type"=>"submit"
    ],
 ]
])

<!-- INIT: STEP2 ACTIONS ANTECEDENTS -->
<input id="action_new-register_antecedent_by_history_clinic" type="hidden"
       value="{{ action("Hospital\AntecedentByHistoryClinicController@getFormAntecedentByHistoryClinic") }}"/>
<input id="action_save_antecedent_by_history_clinic" type="hidden"
       value="{{ action("Hospital\AntecedentByHistoryClinicController@postSaveByConsultation") }}"/>
<input id="action_loadS2_antecedents" type="hidden"
       value="{{ action("Hospital\AntecedentController@getListSelect2") }}"/>
<input id="action_admin_antecedents" type="hidden"
       value="{{ action("Hospital\AntecedentByHistoryClinicController@getListAntecedentByHistoryClinics") }}"/>
<!-- END: STEP2 ACTIONS ANTECEDENTS -->


<!-- INIT: CLINICAL EXAMS -->
@include('partials.modal',[
'title'=>'Nuevo Examen Clinico',
'id'=>'modal_clinical_by_history_clinic',
'action_buttons'=>[
    [
    'form'=>'clinicalByHistoryClinic_form',//debe ir igual q la en l controlador
    'id'=>'btn_save_clinical_by_history_clinic',
    'label'=>'Guardar',
    'color'=>'btn-primary',
    "type"=>"submit"
    ],
 ]
])

<!-- INIT: STEP2 ACTIONS CLINICAL EXAMS -->
<input id="action_new-register_clinical_by_history_clinic" type="hidden"
       value="{{ action("Hospital\ClinicalByHistoryClinicController@getFormClinicalByHistoryClinic") }}"/>
<input id="action_save_clinical_by_history_clinic" type="hidden"
       value="{{ action("Hospital\ClinicalByHistoryClinicController@postSaveByConsultation") }}"/>
<input id="action_loadS2_clinical_exams" type="hidden"
       value="{{ action("Hospital\ClinicalExamController@getListSelect2") }}"/>
<input id="action_admin_clinical_exams" type="hidden"
       value="{{ action("Hospital\ClinicalByHistoryClinicController@getListClinicalByHistoryClinics") }}"/>
<!-- END: STEP2 ACTIONS CLINICAL EXAMS -->

<!-- INIT: STEP2 ODONTOGRAM BY PATIENT -->
<!-- INIT: Odontogram Modal -->
<?php
$tbl_name_management = "odontogram_by_patient";
$modelEntidad = "OdontogramByPatient";
$postSave = "Hospital\OdontogramByPatientController@postSaveByConsultation";
$getForm = "Hospital\OdontogramByPatientController@getFormOdontogramByPatient";
$getList = "Hospital\OdontogramByPatientController@getListOdontogramByPatients";
?>
@include('partials.modal',[
'title'=>'Nuevo Odontograma',
'id'=>'modal_odontogram_by_patient',
'action_buttons'=>[
    [
    'form'=>'odontogramByPatient_form',//debe ir igual q la en l controlador
    'id'=>'btn_save_odontogram_by_patient',
    'label'=>'Guardar',
    'color'=>'btn-primary',
    "type"=>"submit"
    ],
 ]
])

<input id="action_new-register_{{$tbl_name_management}}" type="hidden"
       value="{{ action($getForm) }}"/>
<input id="action_save_{{$tbl_name_management}}" type="hidden"
       value="{{ action($postSave) }}"/>
<input id="action_admin_{{$tbl_name_management}}" type="hidden"
       value="{{ action($getList) }}"/>
<!-- END: STEP2 ACTIONS  ODONTOGRAM BY PATIENT -->
<!-- INIT: STEP2 ACTIONS  REFERENCE PIECE -->
<?php
$tbl_name_management = "reference_piece";
$modelEntidad = "ReferencePiece";
$getListS2 = "Odontogram\ReferencePieceController@getListSelect2";
?>
<input id="action_ListS2_{{$tbl_name_management}}" type="hidden"
       value="{{ action($getListS2) }}"/>
<!-- END: STEP2 ACTIONS  REFERENCE PIECE -->
<!-- INIT: STEP2 ACTIONS  dental piece by odontogram -->
<?php
$tbl_name_management = "dental_piece_by_odontogram";
$modelEntidad = "DentalPieceByOdontogram";
$postSave = "Odontogram\DentalPieceByOdontogramController@postSaveByConsultation";
$getForm = "Odontogram\DentalPieceByOdontogramController@getFormDentalPieceByOdontogram";
$getList = "Odontogram\DentalPieceByOdontogramController@getListDentalPieceByOdontograms";
$getListByOdontogramId = "Odontogram\DentalPieceByOdontogramController@getDataDentalPieceByOdontogramId";

$frmId = "dentalPieceByOdontogram_form";
$btnId = "btn_save_" . $tbl_name_management;
?>
<div class="content-frm col-lg-3 col-md-3 col-sm-12 content__form-{{$tbl_name_management}}" id="modal_{{$tbl_name_management}}">
    <form  class="m-form m-form--fit m-form--label-align-right" name="{{ $frmId}}" id="{{ $frmId}}">
        <input type="hidden" name="{{$tbl_name_management}}_id" id="{{$tbl_name_management}}_id">
        <input type="hidden" name="dental_piece_id" id="dental_piece_id">
        <input type="hidden" name="reference_piece_position_id" id="reference_piece_position_id" >
        <input type="hidden" name="type" id="type">
        <input type="hidden" name="typeDPBO" id="typeDPBO">
        <input type="hidden" name="odontogram_by_patient_id" id="odontogram_by_patient_id" class="odontogram_by_patient_id">
        <div class="form-group m-form__group">
            <label for="reference_piece_id" id="reference_piece_id_lbl">Referencia</label>
            <select class="form-control m-select2" name="reference_piece_id" id="reference_piece_id">
            </select>
        </div>
        <div class="form-group m-form__group">
            <label for="description">Descripcion</label>
            <textarea class="form-control m-input" id="description" rows="3" name="description"></textarea>
        </div>
        <div class="m-form__actions">
            <button type="button" id="{{$btnId}}-cancel" class="btn btn-danger">Cancelar</button>
            <button type="submit" form="{{$frmId}}" id="{{$btnId}}" class="btn btn-primary" >Guardar</button>
        </div>
    </form>
</div>
<input id="action_new-register_{{$tbl_name_management}}" type="hidden"
       value="{{ action($getForm) }}"/>
<input id="action_save_{{$tbl_name_management}}" type="hidden"
       value="{{ action($postSave) }}"/>
<input id="action_admin_{{$tbl_name_management}}" type="hidden"
       value="{{ action($getList) }}"/>
<input id="action_odontogram_{{$tbl_name_management}}" type="hidden"
       value="{{ action($getListByOdontogramId) }}"/>
<!-- END: STEP2 ACTIONS  dental piece by odontogram-->
<!-- END: STEP2 -->


{{-------------MANAGEMENT TreatmentPlanByPatient------------}}
<?php
$tbl_name_management = "treatment_plan_by_patient";
$modelEntidad = "TreatmentPlanByPatient";
$postSave = "Hospital\TreatmentPlanByPatientController@postSaveByConsultation";
$getForm = "Hospital\TreatmentPlanByPatientController@getForm".$modelEntidad;
$getList = "Hospital\TreatmentPlanByPatientController@getList".$modelEntidad."s";
$btnId = "btn_save_" . $tbl_name_management;
?>
<input id="action_new-register_{{$tbl_name_management}}" type="hidden"
       value="{{ action($getForm) }}"/>
<input id="action_save_{{$tbl_name_management}}" type="hidden"
       value="{{ action($postSave) }}"/>
<input id="action_admin_{{$tbl_name_management}}" type="hidden"
       value="{{ action($getList) }}"/>
