<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@php
    $managerOptions=[
    'pageTitle'=>'Administracion',
             'menuParentName'=>'Administracion',
           'menuName'=>'Consulta Medica',
                      'menuName'=>'Consulta Medica',
'title'=>'Consulta Medica',
 'icon'=>'<i class="flaticon-cogwheel-2"></i>',
    'id_table'=>'medicalConsultationByPatient_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newRegister()',
        'color'=>'btn-primary'
        ],
      ],
      'modal'=>[
    'title'=>'Crear Cliente',
    'id'=>'modal',
    'size'=>'modal-lg',
    'action_buttons'=>[
        [
        'id'=>'btn_save',
        'label'=>'Guardar',
        'handler_js'=>'savePatientStep1()',
        'color'=>'btn-primary'
        ],
     ]
    ]
   ];
@endphp
@extends('layouts.masterMinton')

@section('breadcrumb')
    @include('partials.breadcrumb',$managerOptions)
@endsection

@section('headerMenuManagerLeft')
    <li class="dropdown d-none d-lg-block">
        <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button"
           aria-haspopup="false" aria-expanded="false">
            Gestion
            <i class="mdi mdi-chevron-down"></i>
        </a>
        <div class="dropdown-menu">
            <!-- item-->
            <a href="javascript:{{$managerOptions['action_buttons'][0]['handler_js']}}" class="dropdown-item">
                <i class="fas fa-pen-alt"></i>
                <span>Creacion</span>
            </a>

        </div>
    </li>
@endsection
<?php
$url_path_plugins = "libs/";
//    dd($model_entity);
?>
@section('additional-styles')
    @include('partials.plugins.resourcesCss',['datepickerBootstrap'=>true])

    <link href="{{ asset($resourcePathServer."css/style.min.css") }}" rel="stylesheet"
          type="text/css">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <link href="{{ asset($resourcePathServer."libs/mdatatables/mdatatables.min.css") }}" rel="stylesheet"
          type="text/css">

    <link href="{{ asset($resourcePathServer.$url_path_plugins.'wizard/wizard.min.css') }}" rel="stylesheet"
          type="text/css">
    <link href="{{ asset($resourcePathServer.'css/'.$model_entity.'/odontogram.css') }}" rel="stylesheet"
          type="text/css">
    {{-----bootgrid1.3.1 PLUGIN--}}
    <link href="{{ asset($resourcePathServer.$url_path_plugins."bootgrid1.3.1/bootgrid1.3.1.min.css") }}" rel="stylesheet"
          type="text/css">
@endsection
@section('content')

    <div id="container_admin">
        @include('partials.admin_view',$managerOptions)
    </div>

    <div id="container_wizard_form"></div>

    @include('partials.modal',$managerOptions['modal'])

    @foreach ($actions as $key => $action)

        <input id="{{$key}}" type="hidden" value="{{action($action)}}"/>

    @endforeach

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
    <div class="content-frm content__form-{{$tbl_name_management}}" id="modal_{{$tbl_name_management}}">
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

@endsection
@section('additional-scripts')
    <script type="text/javascript">
        var model_entity = "{{$model_entity}}";
        var name_manager = "{{$name_manager}}";
    </script>
    @include('partials.plugins.resourcesJs',['datepickerBootstrap'=>true])
    @include('partials.plugins.resourcesJs',['jqueryValidation'=>true])

    <script src="https://cdn.jsdelivr.net/npm/js-cookie@beta/dist/js.cookie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    {{--scripts GESTION--}}
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/formsRulesValidations.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/Grids.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/index.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/_step1.js') }}" type="text/javascript"></script>
    <!-- Maps -->
    <script src="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}"></script>

    <!-- End :Maps -->
    {{--ALERTS--}}
    <script src="{{ asset($resourcePathServer.$url_path_plugins."sweetalert/sweetalert.min.js") }}"></script>
    {{----- PLUGINS--}}
    <script src="{{ asset($resourcePathServer.$url_path_plugins."tooltip/tooltip.min.js") }}" type="text/javascript"></script>
    {{--bootgrid1.3.1--}}
    <script src="{{ asset($resourcePathServer.$url_path_plugins."bootgrid1.3.1/bootgrid1.3.1.min.js") }}" type="text/javascript"></script>
    {{-- SNAP SVG--}}
    <script src="{{ asset($resourcePathServer.$url_path_plugins."snap-svg/snap-svg.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/_form.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/_formStep2.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/_wizard.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/odontogramOptionSvg.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/odontogramManagement.js') }}" type="text/javascript"></script>


@endsection
