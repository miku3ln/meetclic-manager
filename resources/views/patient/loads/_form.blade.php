<div id="form_portlet">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    {!!  $patient->id ? 'Editar' :  'Nuevo' !!} Paciente
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
    <div class="m-content container-fluid">
        <div class="row">
            <div class="col-lg-6">
                {!! Form::model($patient, array('id' => 'patient_form','class' => 'm-form m-form--state m-form--fit m-form--label-align-right form-horizontal', 'method' => 'POST')) !!}
                <div class="m-portlet m-portlet--head-sm" data-portlet="true" id="m_portlet_tools_5">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-profile-1"></i>
												</span>
                                <h3 class="m-portlet__head-text">
                                    Información Personal
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="m-form m-form--fit m-form--label-align-right">
                        <div class="m-portlet__body">
                            {!! Form::hidden('patient_id', $patient->id,['id'=>'patient_id']) !!}
                            <div class="form-group m-form__group row">
                                <div class="col-md-4">
                                    {!! Form::label('document','* Documento:', array('class' => 'col-form-label')) !!}
                                    {!! Form::text('document', $patient->document, array('class' => 'form-control form-control-sm m-input', 'autocomplete' =>
                                    'off', 'placeholder' => 'ej. 1003496245', 'maxlength' => '64')) !!}
                                </div>
                                <div class="col-md-8">
                                    {!! Form::label('name','* Nombre:', array('class' => 'col-form-label')) !!}
                                    {!! Form::text('name', $patient->name, array('class' => 'form-control form-control-sm m-input', 'autocomplete' =>
                                    'off', 'placeholder' => 'ej. Patricio Esteban Arcos Mena', 'maxlength' => '64')) !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-md-6">
                                    {!! Form::label('birthday_date','Fecha de nacimiento:', array('class' => 'col-form-label')) !!}
                                    {!! Form::text('birthday_date', $patient->birthday_date ? $patient->birthday_date : null,
                                    array('id'=>'birthday_date', 'placeholder' => 'ej.18/09/1998', 'class' => 'form-control form-control-sm m-input','maxlength' =>"45",
                                    'autocomplete'=>'off')) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('gender','Genero:', array('class' => 'col-form-label')) !!}
                                    {!! Form::select('gender', array( '0'=> '- Seleccione -','M' => 'Masculino', 'F' => 'Femenino'),$patient->gender,array('class' => 'form-control form-control-sm m-input') ) !!}

                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-md-6">
                                    {!! Form::label('phone','* Teléfono:', array('class' => 'col-form-label')) !!}
                                    {!! Form::text('phone', $patient->phone ? $patient->phone : null,
                                    array('id'=>'phone', 'placeholder' => 'ej.062651635', 'class' => 'form-control form-control-sm m-input','maxlength' =>"45",
                                    'autocomplete'=>'off')) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('movil','* Celular:', array('class' => 'col-form-label')) !!}
                                    {!! Form::text('movil', $patient->movil ? $patient->movil : null,
                                    array('id'=>'movil', 'placeholder' => 'ej.0960292927', 'class' => 'form-control form-control-sm m-input','maxlength' =>"45",
                                    'autocomplete'=>'off')) !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-md-6">
                                    {!! Form::label('email','Email:', array('class' => 'col-form-label')) !!}
                                    {!! Form::text('email', $patient->email ? $patient->email : null,
                                    array('id'=>'email', 'placeholder' => 'ej.dentalsys@mymail.com', 'class' => 'form-control form-control-sm m-input','maxlength' =>"45",
                                    'autocomplete'=>'off')) !!}
                                </div>
                                @if ($patient->id)
                                    <div class="col-md-6">
                                        {!! Form::label('status','* Estado:', array('class' => 'col-form-label')) !!}
                                        {!! Form::select('status', array( 'ACTIVE' => 'Activo', 'INACTIVE' => 'Inactivo'),$patient->status,array('class' => 'form-control form-control-sm m-input') ) !!}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-md-12">
                                    {!! Form::label('address','Dirección:', array('class' => 'col-form-label')) !!}
                                    <form class="form-inline margin-bottom-10" action="#">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm m-input"
                                                   id="input_address"
                                                   placeholder="ej. Bolivar y Pedro Moncayo, Ibarra">
                                            <span class="input-group-btn">
													<button class="btn btn-primary" id="search_btn_map">
														<i class="fa fa-search"></i>
													</button>
												</span>
                                        </div>
                                    </form>
                                    <div id="my_map_location" style="height:150px;"></div>
                                </div>
                            </div>
                            {{--Inputs HIDDEN--}}
                            {!! Form::hidden('latitude', $patient->latitude, array('id'=>'input_latitude','class' => 'form-control input-sm', )) !!}
                            {!! Form::hidden('longitude', $patient->longitude, array('id'=>'input_longitude','class' => 'form-control input-sm')) !!}
                            {!! Form::hidden('address', $patient->address, array('id'=>'address_location','class' => 'form-control input-sm')) !!}
                            {{--END Inputs HIDDEN--}}
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit" style="padding: 0px">
                            <div class="m-form__actions">
                                <button type="button" id="cancel" class="btn btn-default">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                    Cancelar
                                </button>
                                <button type="button" class="btn btn-primary" id="send">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    {{$patient->id ? 'Actualizar' : 'Guardar'}}
                                </button>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>