{!! Form::model($patient, array('id' => 'patient_form','class' => 'm-form m-form--state m-form--fit m-form--label-align-right form-horizontal', 'method' => $method)) !!}
<div class="m-scrollable" data-scrollable="true" data-max-height="200">
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
                {!! Form::label('address','* Dirección:', array('class' => 'col-form-label')) !!}
                <form class="form-inline margin-bottom-10" action="#">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm m-input"
                               id="input_address"
                               placeholder="ej. Bolivar y Pedro Moncayo, Ibarra">
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
</div>
{!! Form::close() !!}