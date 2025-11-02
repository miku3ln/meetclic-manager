<!-- BEGIN: Subheader -->
<div class="m-subheader" style="padding: 30px 30px 30px 30px">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Gestion de Consultas
            </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
											<span class="m-nav__link-text">
												Agendamiento
											</span>
                    </a>
                </li>

                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
											<span class="m-nav__link-text">
												Consultas Médicas
											</span>
                    </a>
                </li>
            </ul>
        </div>
        <div>
            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                 data-dropdown-toggle="hover" aria-expanded="true">
                <a href="#"
                   class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                    <i class="la la-plus m--hide"></i>
                    <i class="la la-ellipsis-h"></i>
                </a>
                <div class="m-dropdown__wrapper">
                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                    <div class="m-dropdown__inner">
                        <div class="m-dropdown__body">
                            <div class="m-dropdown__content">
                                <ul class="m-nav">
                                    <li class="m-nav__item">
                                        <a href="" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-profile-1"></i>
                                            <span class="m-nav__link-text">
																	Nuevo Paciente
																</span>
                                        </a>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-users"></i>
                                            <span class="m-nav__link-text">
																	Administrar Pacientes
																</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Subheader -->
<div class="m-portlet m-portlet--full-height">
    <!--begin: Portlet Head-->
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                @if(isset($icon))
                    <span class="m-portlet__head-icon">  {!! $icon !!}</span>
                @endif
                <h3 class="m-portlet__head-text m--font-brand">
                    {{$title}} <span class="m-portlet__head-text-patient"></span>
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
        <div class="m-content container-fluid">
            <div class="m-wizard m-wizard--2 m-wizard--success m-wizard--step-first" id="m_wizard">
                <!--begin: Form Wizard Head -->
                <div class="m-wizard__head m-portlet__padding-x" style="margin: 25px auto 10px auto">
                    <!--begin: Form Wizard Progress -->
                    <div class="m-wizard__progress">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                 aria-valuemax="100" style="width: 0%;"></div>
                        </div>
                    </div>
                    <!--end: Form Wizard Progress -->
                    <!--begin: Form Wizard Nav -->
                    <div class="m-wizard__nav">
                        <div class="m-wizard__steps">
                            <div class="m-wizard__step m-wizard__step--current" m-wizard-target="m_wizard_form_step_1">
                                <a href="#" class="m-wizard__step-number">
                                    <span><i class="flaticon-profile-1"></i></span>
                                </a>
                                <div class="m-wizard__step-info">
                                    <div class="m-wizard__step-title">
                                        Paciente
                                    </div>
                                    <div class="m-wizard__step-desc">
                                        Datos Personales - Historia Clinica <br>
                                        -Antecedentes<br>
                                        -Examenes Clínicos
                                    </div>
                                </div>
                            </div>
                            <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
                                <a href="#" class="m-wizard__step-number">
                                    <span><i class="fa  flaticon-layers"></i></span>
                                </a>
                                <div class="m-wizard__step-info">
                                    <div class="m-wizard__step-title">
                                        Gestionar Consulta
                                    </div>
                                    <div class="m-wizard__step-desc">
                                        - Motivo <br>
                                        - Odontograma
                                        - Analisis

                                    </div>
                                </div>
                            </div>
                            <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_3">
                                <a href="#" class="m-wizard__step-number">
                                    <span><i class="fa  flaticon-layers"></i></span>
                                </a>
                                <div class="m-wizard__step-info">
                                    <div class="m-wizard__step-title">
                                        Gestion de Tratamiento
                                    </div>
                                    <div class="m-wizard__step-desc">
                                        Desgloce de pagos y citas de tratamientos <br>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Form Wizard Nav -->
                </div>
                <!--end: Form Wizard Head -->
                <!--begin: Form Wizard Form-->
                <div class="m-wizard__form">
                    <form class="m-form m-form--label-align-left- m-form--state-" id="m_form" novalidate="novalidate">
                        <!--begin: Form Body -->
                        <div class="m-portlet__body">
                            <!--begin: Form Wizard Step 1-->
                            <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
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
                        </div>
                        <!--end: Form Body -->
                        <!--begin: Form Actions -->
                        <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
                            <?php
                            $wizards_route = $model_entity . ".partials.wizards" . ".actions";
                            $paramsWizard = [
                                "model_entity" => $model_entity,
                            ];
                            ?>
                            @include($wizards_route,$paramsWizard)
                        </div>
                        <!--end: Form Actions -->
                    </form>
                </div>
                <!--end: Form Wizard Form-->
            </div>
        </div>
        <!--end: Form Wizard-->
    </div>
    <!--end: Portlet Body-->
</div>
