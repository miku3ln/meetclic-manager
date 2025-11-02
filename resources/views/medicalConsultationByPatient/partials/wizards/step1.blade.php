<div class="container-fluid">
    {!! Form::model($patient, array('id' => 'step1_patient_form','class' => 'm-form m-form--state m-form--fit m-form--label-align-right form-horizontal', 'method' => 'POST')) !!}

    <div class="m-form__section m-form__section--first">
        <div class="row col-lg-12">
            <div class="col-lg-8 ">
                <div class="form-group m-form__group row">
                    {!! Form::label('patient_id','* Paciente:', array('class' => 'col-form-label col-lg-3' , 'style'=>"text-align: right")) !!}
                    <div class="col-lg-9" style="font-size: 12px">
                        @if($patient->id)
                            <input id="selected_patient" type="hidden" value="{{ $patient->id }}"/>
                        @endif
                        {!! Form::select('patient_id',array(), $patient->id, array('class' => 'form-control m-select2')) !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 ">
                <a id="btn_new_patient" href="#" onclick="newPatientStep1()"
                   class="btn btn-success m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                    <i class="flaticon-user-add"></i>
                </a>
            </div>

        </div>
    {{--SECTIONS LOCATION--}}
    <!--begin::Section-->
        <div id="details_portlet" style="padding: 10px; margin-top: 25px; min-height: 250px">
            <div class='alert alert-info alert-message-center ' role='alert'><strong> Bienvenido! </strong> Selecciona o
                Registra un paciente para comenzar.
            </div>
        </div>
        <!--end::Section-->
        <!--begin::Section-->
        <div id="medicalConsultation_portlet" style="padding: 10px; margin-top: 25px; display: none">
            @include(
            'partials._dataTable',[
                'id'=>'mConsultation_table',
                'title' => 'Historial de Citas',
                'icon' => 'flaticon-calendar',
                'columns' => [
                ['name' => 'Razon', 'db_column' => 'reason_consultation'],
                ['name' => 'Estado', 'db_column' => 'status'],
                ['name' => 'Fecha Creación', 'db_column' => 'created_at'],
                ]
            ])


        </div>
        <!--end::Section-->
        {{--END:SECTIONS LOCATION--}}

    </div>
    {!! Form::close() !!}
</div>