<?php
$url_path_plugins = "metronic/plugins/";
?>


<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>

@section('additional-styles')
    <link href="{{ asset($resourcePathServer.'metronic/plugins/wizard/wizard.css') }}" rel="stylesheet"
          type="text/css">
    {{-----BOOTGRID PLUGIN--}}
    <link href="{{ asset($resourcePathServer.$url_path_plugins."bootgrid/css/jquery.bootgrid.css") }}" rel="stylesheet"
          type="text/css">
@endsection
@section('content')
    <div class="m-portlet m-portlet--full-height">
        <!--begin: Portlet Head-->
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    @if(isset($icon))
                        <span class="m-portlet__head-icon">  {!! $icon !!}</span>
                    @endif
                    <h3 class="m-portlet__head-text m--font-brand">
                        {{$title}}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="#" data-toggle="m-tooltip" class="m-portlet__nav-link m-portlet__nav-link--icon"
                           data-direction="left" data-width="auto" title=""
                           data-original-title="Get help with filling up this form">
                            <i class="flaticon-info m--icon-font-size-lg3"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!--end: Portlet Head-->
        <!--begin: Portlet Body-->
        <div class="m-portlet__body m-portlet__body--no-padding">
            <!--begin: Form Wizard-->
            <div class="m-wizard m-wizard--4 m-wizard--brand m-wizard--step-first" id="m_wizard">
                <div class="row m-row--no-padding">
                    <div class="col-xl-3 col-lg-12 m--padding-top-20 m--padding-bottom-15">
                        <!--begin: Form Wizard Head -->
                        <div class="m-wizard__head">
                            <!--begin: Form Wizard Nav -->
                            <div class="m-wizard__nav">
                                <div class="m-wizard__steps">
                                    <div class="m-wizard__step m-wizard__step--current"
                                         m-wizard-target="m_wizard_form_step_1">
                                        <div class="m-wizard__step-info">
                                            <a href="#" class="m-wizard__step-number ">
                                                <span><span> <i class="flaticon-profile-1"></i></span></span>
                                            </a>
                                            <div class="m-wizard__step-label">
                                                Paciente
                                            </div>
                                            <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                        </div>
                                    </div>
                                    <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
                                        <div class="m-wizard__step-info">
                                            <a href="#" class="m-wizard__step-number">
                                                <span><span>2</span></span>
                                            </a>
                                            <div class="m-wizard__step-label">
                                                Gestionar Consulta
                                            </div>
                                            <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                        </div>
                                    </div>
                                    <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_3">
                                        <div class="m-wizard__step-info">
                                            <a href="#" class="m-wizard__step-number">
                                                <span><span> <i class="fa  flaticon-layers"></i></span></span>
                                            </a>
                                            <div class="m-wizard__step-label">
                                                Plan de Tratamiento
                                            </div>
                                            <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                        </div>
                                    </div>
                                    <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_4">
                                        <div class="m-wizard__step-info">
                                            <a href="#" class="m-wizard__step-number">
                                                <span><span>4</span></span>
                                            </a>
                                            <div class="m-wizard__step-label">
                                                Confirmation
                                            </div>
                                            <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end: Form Wizard Nav -->
                        </div>
                        <!--end: Form Wizard Head -->
                    </div>
                    <div class="col-xl-9 col-lg-12">
                        <!--begin: Form Wizard Form-->
                        <div class="m-wizard__form">
                            <!--
                                1) Use m-form--label-align-left class to alight the form input lables to the right
                                2) Use m-form--state class to highlight input control borders on form validation
                            -->
                            <form class="m-form m-form--label-align-left- m-form--state-" id="m_form"
                                  novalidate="novalidate">
                                <!--begin: Form Body -->
                                <div class="m-portlet__body m-portlet__body--no-padding">
                                    <!--begin: Form Wizard Step 1-->
                                    <div class="m-wizard__form-step m-wizard__form-step--current"
                                         id="m_wizard_form_step_1">

                                        <?php
                                        $wizards_route = $model_entity . ".partials.wizards" . ".step1";
                                        $paramsWizard = [
                                            "model_entity" => $model_entity,
                                            "patient" => $patient
                                        ];
                                        ?>
                                        @include($wizards_route,$paramsWizard)
                                    </div>
                                    <!--end: Form Wizard Step 1-->

                                    <!--begin: Form Wizard Step 2-->
                                    <div class="m-wizard__form-step" id="m_wizard_form_step_2">
                                        <?php
                                        $wizards_route = $model_entity . ".partials.wizards" . ".step2";
                                        $paramsWizard = [
                                            "model_entity" => $model_entity,
                                            "dataAntecedents" => $dataAntecedents,
                                            "dataClinicalExams" => $dataClinicalExams];
                                        ?>
                                        @include($wizards_route,$paramsWizard)

                                    </div>
                                    <!--end: Form Wizard Step 2-->

                                    <!--begin: Form Wizard Step 3-->
                                    <div class="m-wizard__form-step" id="m_wizard_form_step_3">
                                        <?php
                                        $wizards_route = $model_entity . ".partials.wizards" . ".step3";
                                        $paramsWizard = [
                                            "model_entity" => $model_entity
                                        ];
                                        ?>
                                        @include($wizards_route,$paramsWizard)
                                    </div>
                                    <!--end: Form Wizard Step 3-->

                                    <!--begin: Form Wizard Step 4-->
                                    <div class="m-wizard__form-step" id="m_wizard_form_step_4">
                                        <div class="form-group m-form__group m-form__group--sm row">
                                            <div class="col-xl-12">
                                                <div class="m-checkbox-inline">
                                                    <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                        <input type="checkbox" name="accept2" value="1">
                                                        Click here to indicate that you have read and agree to the terms
                                                        presented in the Terms and Conditions agreement
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Form Wizard Step 4-->
                                </div>
                                <!--end: Form Body -->
                                <!--begin: Form Actions -->
                            <?php
                            $wizards_route = $model_entity . ".partials.wizards" . ".actions";
                            $paramsWizard = [
                                "model_entity" => $model_entity,
                            ];
                            ?>
                            @include($wizards_route,$paramsWizard)


                            <!--end: Form Actions -->
                            </form>
                        </div>
                        <!--end: Form Wizard Form-->
                    </div>
                </div>
            </div>
            <!--end: Form Wizard-->

        </div>
        <!--end: Portlet Body-->
    </div>
    <!-- Modal -->
    @include('partials.modal',[
    'title'=>'Nuevo Paciente',
    'id'=>'modal',
    'action_buttons'=>[
        [
        'form'=>'step1_patient_form',
        'id'=>'btn_save',
        'label'=>'Guardar',
        'color'=>'btn-primary',
        'handler_js' =>'savePatientStep1()'
        ],
     ]
    ])
    <!-- END : Modal -->

    <!--STEP1 ACTIONS -->
    <input id="action_validate_document_step1" type="hidden"
           value="{{ action("Hospital\PatientController@postIsDocumentValid") }}"/>
    <input id="action_get_patients_form_step1" type="hidden"
           value="{{ action("Hospital\PatientController@getFormPatientModal") }}"/>
    <input id="action_load_patients_select2_step1" type="hidden"
           value="{{ action("Hospital\PatientController@getListSelect2") }}"/>
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
        'handler_js' =>'saveRegisterByType("antecedent_by_history_clinic","antecedentByHistoryClinic_form")'
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
        'handler_js' =>'saveRegisterByType("clinical_by_history_clinic","clinicalByHistoryClinic_form")'
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
    <!-- END: STEP2 -->
@endsection
@section('script')
    {{----- PLUGINS--}}
    {{--BOOTGRID--}}
    <script src="{{ asset($resourcePathServer.$url_path_plugins."bootgrid/js/jquery.bootgrid.js") }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.$url_path_plugins."bootgrid/js/jquery.bootgrid.fa.js") }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.$url_path_plugins."tooltip/js/tooltip.min.js") }}" type="text/javascript"></script>


    {{--ALERTS--}}
    <script src="{{ asset($resourcePathServer.'plugins/sweetalert/sweetalert.min.js')}}"></script>

    {{--scripts GESTION--}}
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/Grids.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/_form.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/_formStep2.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/_wizard.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        var model_entity = "{{$model_entity}}";
        var name_manager = "{{$name_manager}}";
    </script>
    <!-- Maps -->
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyAy7FfEU_fOeVTrJKxENPLxAor4cL6_d88&libraries=places"></script>
    <!-- End :Maps -->

@endsection
