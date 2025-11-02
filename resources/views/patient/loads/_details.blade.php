{{--<!-- BEGIN: Subheader -->--}}
{{--<div class="m-subheader ">--}}
    {{--<div class="d-flex align-items-center">--}}
        {{--<div class="mr-auto">--}}
            {{--<h3 class="m-subheader__title m-subheader__title--separator">--}}
                {{--{!!  $patient->id ? 'Editar' :  'Nuevo' !!} Paciente--}}
            {{--</h3>--}}
            {{--<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">--}}
                {{--<li class="m-nav__item m-nav__item--home">--}}
                    {{--<a href="#" class="m-nav__link m-nav__link--icon">--}}
                        {{--<i class="m-nav__link-icon la la-home"></i>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="m-nav__separator">--}}
                    {{-----}}
                {{--</li>--}}
                {{--<li class="m-nav__item">--}}
                    {{--<a href="" class="m-nav__link">--}}
											{{--<span class="m-nav__link-text">--}}
												{{--Dentalsys--}}
											{{--</span>--}}
                    {{--</a>--}}
                {{--</li>--}}

                {{--<li class="m-nav__separator">--}}
                    {{-----}}
                {{--</li>--}}
                {{--<li class="m-nav__item">--}}
                    {{--<a href="" class="m-nav__link">--}}
											{{--<span class="m-nav__link-text">--}}
												{{--Pacientes--}}
											{{--</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</div>--}}
        {{--<div>--}}
            {{--<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"--}}
                 {{--data-dropdown-toggle="hover" aria-expanded="true">--}}
                {{--<a href="#"--}}
                   {{--class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">--}}
                    {{--<i class="la la-plus m--hide"></i>--}}
                    {{--<i class="la la-ellipsis-h"></i>--}}
                {{--</a>--}}
                {{--<div class="m-dropdown__wrapper">--}}
                    {{--<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>--}}
                    {{--<div class="m-dropdown__inner">--}}
                        {{--<div class="m-dropdown__body">--}}
                            {{--<div class="m-dropdown__content">--}}
                                {{--<ul class="m-nav">--}}
                                    {{--<li class="m-nav__item">--}}
                                        {{--<a href="" class="m-nav__link">--}}
                                            {{--<i class="m-nav__link-icon flaticon-profile-1"></i>--}}
                                            {{--<span class="m-nav__link-text">--}}
																	{{--Nuevo Paciente--}}
																{{--</span>--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                    {{--<li class="m-nav__item">--}}
                                        {{--<a href="" class="m-nav__link">--}}
                                            {{--<i class="m-nav__link-icon flaticon-users"></i>--}}
                                            {{--<span class="m-nav__link-text">--}}
																	{{--Administrar Pacientes--}}
																{{--</span>--}}
                                        {{--</a>--}}
                                    {{--</li>--}}

                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
{{--<!-- END: Subheader -->--}}
<div class="">
    <div class="">
        <div class="m-portlet m-portlet--head-sm" data-portlet="true" id="m_portlet_tools_5">
            <div class="m-portlet__head">
                {{--Tittle--}}
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-profile-1"></i>
												</span>
                        <h3 class="m-portlet__head-text">
                            Paciente : {!! $patient->name !!}
                        </h3>
                    </div>
                </div>
                {{--Tool Portlet--}}
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <div id="edit_patient_portlet">
                                <a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-edit"></i><span>
                                        Editar
                                    </span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
            <!--begin::Form-->
            <form class="m-form m-form--fit m-form--label-align-right">
                <div class="m-portlet__body">
                    <div style="padding-left: 15px; padding-right: 15px;">
                        <div>
                            <table class="table">
                                {{--<thead>--}}
                                {{--<tr style="color: white; background-color: #8781d2;">--}}
                                    {{--<th colspan="2">--}}
                                        {{--<h3>{!! $patient->name !!}</h3>--}}
                                    {{--</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                                <tbody>
                                <tr>
                                    <th scope="row">
                                        Teléfono :
                                    </th>
                                    <td>
                                        {!! $patient->phone ? $patient->phone : 'Sin asignar' !!}
                                    </td>
                                    <th scope="row">
                                        Celular :
                                    </th>
                                    <td>
                                        {!! $patient->movil ? $patient->movil : 'Sin asignar' !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        Fecha Nacimiento :
                                    </th>
                                    <td>
                                        {!! $patient->birthday_date ? $patient->birthday_date : 'Sin asignar'  !!}
                                    </td>
                                    <th scope="row">
                                        Género :
                                    </th>
                                    <td>
                                        {!! $patient->gender ? $patient->gender : 'Sin asignar' !!}

                                    </td>

                                </tr>

                                <tr>
                                    <th scope="row">
                                        Email :
                                    </th>
                                    <td colspan="3">
                                        {!! $patient->email ? $patient->email : 'Sin asignar' !!}
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">
                                        Dirección :
                                    </th>
                                    <td colspan="3">
                                        {!! $patient->address ? $patient->address : 'Sin asignar' !!}
                                    </td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>