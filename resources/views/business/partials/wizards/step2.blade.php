<div class="row">
    <div class="col-xl-12 offset-xl-2">
        <div class="m-form__section m-form__section--first">
            <div class="m-form__heading">
                <h3 class="m-form__heading-title">Consulta</h3>
            </div>
            <div class="form-group m-form__group row">
                <div class="col-lg-12">
                    <label class="form-control-label">* Motivo:</label>
                    <input type="text" name="reason_consultation" class="form-control m-input"
                           placeholder="">
                    <span class="m-form__help">Please enter information</span>
                </div>
            </div>
        </div>
        <div class="m-separator m-separator--dashed m-separator--lg"></div>
        <div class="m-form__section">
            <div class="m-form__heading">
                <h3 class="m-form__heading-title">Antecedentes</h3>
            </div>

            <div class="form-group m-form__group row m-grids-management">
                <div class="col-lg-12">
                    <div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm"
                         m-portlet="true" id="m_portlet_antecedent_by_history_clinic">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-placeholder-2"></i>
						</span>
                                    <h3 class="m-portlet__head-text">
                                        Gestion Antecedentes
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">
                                        <a m-portlet-tool="toggle"
                                           class="m-portlet__nav-link m-portlet__nav-link--icon"
                                           aria-describedby="tooltip_ges3mb4ofe"><i class="la la-angle-down"></i></a>
                                        <div class="m-tooltip m-tooltip--portlet tooltip bs-tooltip-top" role="tooltip"
                                             id="tooltip_ges3mb4ofe" aria-hidden="true" x-placement="top"
                                             style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(261px, -32px, 0px); display: none;">
                                            <div class="tooltip-arrow arrow" style="left: 44px;"></div>
                                            <div class="tooltip-inner">Collapse</div>
                                        </div>
                                    </li>
                                    <li class="m-portlet__nav-item">
                                        <a m-portlet-tool="reload"
                                           class="m-portlet__nav-link m-portlet__nav-link--icon"
                                           aria-describedby="tooltip_heb1f8nkc3"><i class="la la-refresh"></i></a>
                                        <div class="m-tooltip m-tooltip--portlet tooltip bs-tooltip-top" role="tooltip"
                                             id="tooltip_heb1f8nkc3" aria-hidden="true" x-placement="top"
                                             style="position: absolute; transform: translate3d(299px, -33px, 0px); top: 0px; left: 0px; will-change: transform; display: none;">
                                            <div class="tooltip-arrow arrow" style="left: 37px;"></div>
                                            <div class="tooltip-inner">Reload</div>
                                        </div>
                                    </li>
                                    <li class="m-portlet__nav-item">
                                        <a m-portlet-tool="fullscreen"
                                           class="m-portlet__nav-link m-portlet__nav-link--icon"
                                           aria-describedby="tooltip_cr4rw063iy"><i class="la la-expand"></i></a>
                                        <div class="m-tooltip m-tooltip--portlet tooltip bs-tooltip-top" role="tooltip"
                                             id="tooltip_cr4rw063iy" aria-hidden="true" x-placement="top"
                                             style="position: absolute; transform: translate3d(321px, -33px, 0px); top: 0px; left: 0px; will-change: transform; display: none;">
                                            <div class="tooltip-arrow arrow" style="left: 48px;"></div>
                                            <div class="tooltip-inner">Fullscreen</div>
                                        </div>
                                    </li>
                                    <li class="m-portlet__nav-item">
                                        <a m-portlet-tool="add-register"
                                           class="m-portlet__nav-link m-portlet__nav-link--icon"
                                           aria-describedby="tooltip_cr4rw063iy"><i class="la la-pencil"></i></a>
                                        <div class="m-tooltip m-tooltip--portlet tooltip bs-tooltip-top" role="tooltip"
                                             id="tooltip_cr4rw063iy" aria-hidden="true" x-placement="top"
                                             style="position: absolute; transform: translate3d(321px, -33px, 0px); top: 0px; left: 0px; will-change: transform; display: none;">
                                            <div class="tooltip-arrow arrow" style="left: 48px;"></div>
                                            <div class="tooltip-inner">Agregar</div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body" m-hidden-height="344" style="">
                            <div class="m-scrollable m-scroller ps ps--active-y" data-scrollbar-shown="true"
                                 data-scrollable="true" data-height="300" style="overflow:hidden; height: 300px">
                                <?php
                                $wizards_route = $model_entity . ".partials.wizards" . ".step2GridAntecedents";
                                $paramsWizard = [
                                    "id_table" => "admin_antecedent_by_history_clinic",
                                    "model_entity" => $model_entity,

                                ];
                                ?>
                                @include($wizards_route,$paramsWizard)
                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps__rail-y" style="top: 0px; height: 300px; right: 4px;">
                                    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 40px;"></div>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm"
                         m-portlet="true" id="m_portlet_clinical_by_history_clinic">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-placeholder-2"></i>
						</span>
                                    <h3 class="m-portlet__head-text">
                                        Gestion Examenes Clinicos
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">
                                        <a href="#" m-portlet-tool="toggle"
                                           class="m-portlet__nav-link m-portlet__nav-link--icon"
                                           aria-describedby="tooltip_ges3mb4ofe"><i class="la la-angle-down"></i></a>
                                        <div class="m-tooltip m-tooltip--portlet tooltip bs-tooltip-top" role="tooltip"
                                             id="tooltip_ges3mb4ofe" aria-hidden="true" x-placement="top"
                                             style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(261px, -32px, 0px); display: none;">
                                            <div class="tooltip-arrow arrow" style="left: 44px;"></div>
                                            <div class="tooltip-inner">Collapse</div>
                                        </div>
                                    </li>
                                    <li class="m-portlet__nav-item">
                                        <a href="#" m-portlet-tool="reload"
                                           class="m-portlet__nav-link m-portlet__nav-link--icon"
                                           aria-describedby="tooltip_heb1f8nkc3"><i class="la la-refresh"></i></a>
                                        <div class="m-tooltip m-tooltip--portlet tooltip bs-tooltip-top" role="tooltip"
                                             id="tooltip_heb1f8nkc3" aria-hidden="true" x-placement="top"
                                             style="position: absolute; transform: translate3d(299px, -33px, 0px); top: 0px; left: 0px; will-change: transform; display: none;">
                                            <div class="tooltip-arrow arrow" style="left: 37px;"></div>
                                            <div class="tooltip-inner">Reload</div>
                                        </div>
                                    </li>
                                    <li class="m-portlet__nav-item">
                                        <a href="#" m-portlet-tool="fullscreen"
                                           class="m-portlet__nav-link m-portlet__nav-link--icon"
                                           aria-describedby="tooltip_cr4rw063iy"><i class="la la-expand"></i></a>
                                        <div class="m-tooltip m-tooltip--portlet tooltip bs-tooltip-top" role="tooltip"
                                             id="tooltip_cr4rw063iy" aria-hidden="true" x-placement="top"
                                             style="position: absolute; transform: translate3d(321px, -33px, 0px); top: 0px; left: 0px; will-change: transform; display: none;">
                                            <div class="tooltip-arrow arrow" style="left: 48px;"></div>
                                            <div class="tooltip-inner">Fullscreen</div>
                                        </div>
                                    </li>
                                    <li class="m-portlet__nav-item">
                                        <a m-portlet-tool="add-register"
                                           class="m-portlet__nav-link m-portlet__nav-link--icon"
                                           aria-describedby="tooltip_cr4rw063iy"><i class="la la-pencil"></i></a>
                                        <div class="m-tooltip m-tooltip--portlet tooltip bs-tooltip-top" role="tooltip"
                                             id="tooltip_cr4rw063iy" aria-hidden="true" x-placement="top"
                                             style="position: absolute; transform: translate3d(321px, -33px, 0px); top: 0px; left: 0px; will-change: transform; display: none;">
                                            <div class="tooltip-arrow arrow" style="left: 48px;"></div>
                                            <div class="tooltip-inner">Agregar</div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body" m-hidden-height="344" style="">
                            <div class="m-scrollable m-scroller ps ps--active-y" data-scrollbar-shown="true"
                                 data-scrollable="true" data-height="300" style="overflow:hidden; height: 300px">
                                <?php
                                $wizards_route = $model_entity . ".partials.wizards" . ".step2GridClinicalExams";
                                $paramsWizard = [
                                    "id_table" => "admin_clinical_by_history_clinic",
                                    "model_entity" => $model_entity,

                                ];
                                ?>
                                @include($wizards_route,$paramsWizard)
                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps__rail-y" style="top: 0px; height: 300px; right: 4px;">
                                    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 40px;"></div>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>


            </div>

        </div>

    </div>
</div>