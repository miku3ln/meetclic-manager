<div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
    <div class="m-demo__preview">
        <ul class="m-nav m-nav--active-bg m-nav-management-menu" id="m_nav" role="tablist">
            <li class="m-nav__item m-nav__item--active" view-management="true">
                <a href="#" class="m-nav__link" action="{{action("Hospital\PatientController@getDetailsPatient")}}"
                   type-a="parent" entidad="patient">
                    <i class="m-nav__link-icon flaticon-information"></i>
                    <span class="m-nav__link-text">Datos Personales</span>
                </a>
            </li>
            <li class="m-nav__item" view-management="false">
                <a href="#" class="m-nav__link" action="" type-a="parent" entidad="resourcesByPatient">
                    <i class="m-nav__link-icon flaticon-graphic"></i>
                    <span class="m-nav__link-text">Imagenes /Archivos</span>
                </a>
            </li>
            <li class="m-nav__item" view-management="false">
                <a href="#" class="m-nav__link" action="" type-a="parent" entidad="medicalAppointmentsByPatient">
                    <i class="m-nav__link-icon flaticon-time-3"></i>
                    <span class="m-nav__link-text">Citas</span>
                </a>
            </li>
            <li class="m-nav__item" view-management="false">
                <a href="#" class="m-nav__link" action="" type-a="parent" entidad="mailsByPatient">
                    <i class="m-nav__link-icon fa fa-envelope-o"></i>
                    <span class="m-nav__link-text">Mails</span>
                </a>
            </li>
            <li class="m-nav__item m-nav__item-clinic-parent">
                <a class="m-nav__link" role="tab" id="m_nav_link_1"
                   data-toggle="collapse" href="#m_nav_sub_1" aria-expanded="true">
                    <i class="m-nav__link-icon flaticon-clipboard"></i>
                    <span class="m-nav__link-title">
                                                        <span class="m-nav__link-wrap">
                                                            <span class="m-nav__link-text">Clinico</span>
                                                        </span>
                                                    </span>
                    <span class="m-nav__link-arrow"></span>
                </a>
                <ul class="m-nav__sub collapse show" id="m_nav_sub_1" role="tabpanel"
                    aria-labelledby="m_nav_link_1" data-parent="#m_nav" style="" parent-a="m-nav__item-clinic-parent">
                    <li view-management="true" class="m-nav__item">
                        <a href="#" class="m-nav__link"
                           action="{{action("Hospital\OdontogramByPatientController@getManagementByPatient")}}"
                           type-a="children" entidad="odontogramByPatient">
                            <span class="m-nav__link-bullet m-nav__link-bullet--line"><span></span></span>
                            <span class="m-nav__link-text">Odontograma Actual</span>
                            <span class="m-nav__link-badge m-nav__item-odontogram-by-patient">
                                                                <span class="m-badge
                                                                 @if($params["dataOdontogram"]["allowData"])
                                                                        m-badge--success
                                                                   @else
                                                                        m-badge--danger
                                                                 @endif
                                                                        m-badge--wide m-badge--rounded">
                                                                @if($params["dataOdontogram"]["allowData"])
                                                                        A
                                                                    @else
                                                                    I
                                                                    @endif
                                                                </span>
                                                            </span>
                        </a>
                    </li>
                    <li view-management="true" class="m-nav__item">
                        <a href="#" class="m-nav__link"
                           action="{{action("Hospital\PatientController@getClinicalDocuments")}}"
                           type-a="children" entidad="clinicDocumentByPatient">
                            <span class="m-nav__link-bullet m-nav__link-bullet--line"><span></span></span>
                            <span class="m-nav__link-text">Documentos Clinicos</span>
                        </a>
                    </li>
                    <li view-management="false" class="m-nav__item">
                        <a href="#" class="m-nav__link" action="" type-a="children" entidad="alertByPatient">
                            <span class="m-nav__link-bullet m-nav__link-bullet--line"><span></span></span>
                            <span class="m-nav__link-text">Alertas</span>
                        </a>
                    </li>
                    <li view-management="true" class="m-nav__item">
                        <a href="#" class="m-nav__link"
                           action="{{action("Hospital\TreatmentPlanByPatientController@getManagementByPatient")}}"
                           type-a="children" entidad="treatmentPlanByPatient">
                            <span class="m-nav__link-bullet m-nav__link-bullet--line"><span></span></span>
                            <span class="m-nav__link-text">Planes de Tratamiento</span>
                        </a>
                    </li>
                    <li view-management="false" class="m-nav__item">
                        <a href="#" class="m-nav__link" action="" type-a="children" entidad="evolutionByTreatment">
                            <span class="m-nav__link-bullet m-nav__link-bullet--line"><span></span></span>
                            <span class="m-nav__link-title">
                                                                <span class="m-nav__link-wrap">
                                                                    <span class="m-nav__link-text">Evoluciones</span>
                                                                    <span class="m-nav__link-badge">
                                                                        <span class="m-badge m-badge--warning">3</span>
                                                                    </span>
                                                                </span>
                                                            </span>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="m-nav__item " view-management="false">
                <a class="m-nav__link  collapsed" role="tab" id="m_nav_link_2"
                   data-toggle="collapse" href="#m_nav_sub_2" aria-expanded="true">
                    <i class="m-nav__link-icon flaticon-info"></i>
                    <span class="m-nav__link-title">
                                                        <span class="m-nav__link-wrap">
                                                            <span class="m-nav__link-text">Reportes</span>
                                                            <span class="m-nav__link-badge">
                                                                <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">new</span>
                                                            </span>
                                                        </span>
                                                    </span>
                    <span class="m-nav__link-arrow"></span>
                </a>
                <ul class="m-nav__sub collapse" id="m_nav_sub_2" role="tabpanel"
                    aria-labelledby="m_nav_link_2" data-parent="#m_nav">
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-bullet m-nav__link-bullet--line"><span></span></span>
                            <span class="m-nav__link-text">New</span>
                        </a>
                    </li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-bullet m-nav__link-bullet--line"><span></span></span>
                            <span class="m-nav__link-title">
                                                                <span class="m-nav__link-wrap">
                                                                    <span class="m-nav__link-text">Pending</span>
                                                                    <span class="m-nav__link-badge">
                                                                        <span class="m-badge m-badge--warning">3</span>
                                                                    </span>
                                                                </span>
                                                            </span>
                        </a>
                    </li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-bullet m-nav__link-bullet--line"><span></span></span>
                            <span class="m-nav__link-text">Replied</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="m-nav__item" view-management="false">
                <a href="" class="m-nav__link">
                    <i class="m-nav__link-icon flaticon-cogwheel-2"></i>
                    <span class="m-nav__link-text">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</div>
