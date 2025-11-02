<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Historia Clinica
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
												Dentalsys
											</span>
                    </a>
                </li>

                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
											<span class="m-nav__link-text">
												Pacientes
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
<br>
<?php
$model_entity = "patient";
$wizards_route = $model_entity . ".partials.management" . ".stadistics";
$paramsWizard = [
    "model_entity" => $model_entity,
    "model" => $model
];
?>
@include($wizards_route,$paramsWizard)
<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet__management-content">
            <div class="m-portlet__body">
                <!--begin::Section-->
                <div class="m-section m-section--last">
                    <div class="m-section__content">
                        <!--begin::Preview-->
                        <div class="row">
                            <div class="col-lg-4 m-section__management-options">
                                <?php
                                $model_entity = "patient";
                                $wizards_route = $model_entity . ".partials.management" . ".menu";
                                $paramsWizard = [
                                    "model_entity" => $model_entity,
                                    "model" => $model,
                                    "params"=>$params
                                ];
                                ?>
                                @include($wizards_route,$paramsWizard)
                            </div>
                            <div class="col-lg-8">
                                <div id="container_patient_form"></div>
                                <div id="details_portlet">
                                    <?php
                                    $model_entity = "patient";
                                    $details_pacient = $model_entity . ".loads._details";
                                    $params_view = [
                                        "model_entity" => $model_entity,
                                        "patient" => $model
                                    ];
                                    ?>
                                    @include($details_pacient,$params_view)
                                </div>
                                <div id="data-render" class="m-section__management-data-render"></div>
                            </div>

                        </div>
                        <!--end::Preview-->
                    </div>
                </div>
                <!--end::Section-->
            </div>
        </div>
    </div>
</div>


