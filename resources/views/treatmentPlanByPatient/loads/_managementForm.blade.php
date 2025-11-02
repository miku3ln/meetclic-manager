{!! Form::model($formConfiguration["model"], array('id' => $formConfiguration["frmId"],'class' => 'm-form m-form--state m-form--fit m-form--label-align-right form-horizontal', 'method' => $formConfiguration["method"])) !!}
{{--treatment_plan_by_patient--}}
{!! Form::hidden($formConfiguration["model_entity"].'_id', $formConfiguration["model"]->id,['id'=>$formConfiguration["model_entity"].'_id']) !!}

<input id="patient_id" type="hidden" name="patient_id" value="{{$formConfiguration["model"]->patient_id}}"/>
<input id="total_price" type="hidden" name="total_price" value="{{$formConfiguration["model"]->total_price}}"/>
<input id="tax" type="hidden" name="tax" value="{{$formConfiguration["model"]->tax}}"/>
<input id="subtotal" type="hidden" name="subtotal" value="{{$formConfiguration["model"]->subtotal}}"/>
<input id="discount" type="hidden" name="discount" value="{{$formConfiguration["model"]->discount}}"/>
{{--treatment_plan--}}
<input id="treatment_plan_id" type="hidden" name="treatment_plan_id"
       value="{{$formConfiguration["model"]->treatment_plan_id}}"/>
{{--treatment_detail_by_treatment--}}
<input id="treatment_detail_by_treatment_data" type="hidden" name="treatment_detail_by_treatment_data"
       value="{{$formConfiguration["model"]->treatment_detail_by_treatment_data}}"/>
<input id="treatment_detail_by_treatment_data_aux" type="hidden" name="treatment_detail_by_treatment_data_aux"
       value="{{$formConfiguration["model"]->treatment_detail_by_treatment_data}}"/>

<div class="m-form__heading">
    <h3 class="m-form__heading-title">Informacion</h3>
</div>
@if ($formConfiguration["model"]->id)
    <div class="form-group m-form__group row">
        {!! Form::label('status','* Estado:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!! Form::select('status', array( 'ACTIVE' => 'Activo', 'INACTIVE' => 'Inactivo'),$formConfiguration["model"]->status,array('class' => 'form-control m-input') ) !!}
        </div>
    </div>
@endif
<div class="form-group m-form__group row">
    {!! Form::label('doctor_id','* Doctor:', array('class' => 'col-form-label col-md-3')) !!}
    <div class="col-md-9">
        {!!
        Form::select('doctor_id',$formConfiguration["doctorsData"],$formConfiguration["model"]->doctor_id,array('class' => 'form-control m-input') ) !!}
    </div>
</div>

<div class="form-group m-form__group row">
    <div class="col-lg-6">
        {!! Form::label('date','* Nombre del Plan:', array('class' => '')) !!}
        {!!Form::text('treatment_plan_name',$formConfiguration["model"]->treatment_plan_name,['class'=>'form-control m-input','placeholder' => 'eje . Ortodoncia Completa'])!!}
    </div>
    <div class="col-lg-6">
        {!! Form::label('treatment_plan_description','Descripcion:', array('class' => '')) !!}
        {!!Form::textarea('treatment_plan_description',$formConfiguration["model"]->treatment_plan_description,['class'=>'form-control m-input', 'rows' => 2, 'cols' => 40])!!}

    </div>

</div>


<div class="m-form__heading">
    <h3 class="m-form__heading-title">Tratamientos</h3>
</div>
<div class="form-group m-form__group row">

    <div class="col-lg-6">
        {!! Form::label('treatment_number','* N° Tratamientos:', array('class' => '')) !!}
        {!!Form::text('treatment_number',$formConfiguration["model"]->treatment_number,['readonly' => 'false','class'=>'form-control m-input','placeholder' => 'Agrege Tratamientos al Plan'])!!}

    </div>

</div>
<div class="form-group m-form__group row">
    <div class="col-lg-6">
        {!! Form::label('treatment_id_add','* Tratamiento:', array('class' => '')) !!}
        {!!
        Form::select('treatment_id_add',$formConfiguration["treatmentsData"],$formConfiguration["model"]->treatment_id_add,array('class' => 'form-control m-input') ) !!}

    </div>
    <div class="col-lg-5">
        {!! Form::label('treatment_price_add','* Precio:', array('class' => '')) !!}
        {!!Form::text('treatment_price_add',$formConfiguration["model"]->treatment_price_add,['class'=>'form-control m-input','placeholder' => '0.50, 150',"type"=>"number"])!!}


    </div>
    <div class="col-lg-1">
        <a class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill m-btn--air btn-add-treatment__feature">
            <i class="la la-plus-circle"></i>
        </a>
    </div>
</div>
<div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded m-datatable--scroll">
    <table id="grid-{{$tableConfig["id"]}}"
           class="">
        <thead class="m-datatable__head">
        <tr class="m-datatable__row">

            @foreach ($tableConfig["thead"]["columns"] as $column)
                <th
                @if (@isset($column["data-column-id"]))
                    {{
                    " data-column-id=".$column["data-column-id"].""}}
                        @endif
                @if (@isset($column["data-identifier"]))
                    {{
                    " data-identifier=".$column["data-identifier"].""}}
                        @endif
                @if (@isset($column["data-type"]))
                    {{" data-type=".$column["data-type"].""}}
                        @endif
                @if (@isset($column["data-visible"]))
                    {{" data-visible=".$column["data-visible"].""}}
                        @endif
                @if (@isset($column["data-formatter"]))
                    {{" data-formatter=".$column["data-formatter"].""}}
                        @endif
                >
                    {{$column["text"]}}
                </th>
            @endforeach
        </tr>
        </thead>

    </table>

    <button type="button" class="btn btn-danger btn-cancel-treatment"
            action="{{action("Hospital\TreatmentPlanByPatientController@getManagementByPatient")}}"
            entidad="treatmentPlanByPatient">Cancelar
    </button>
    <button type="submit" form="{{$formConfiguration["frmId"]}}" class="btn btn-primary">Guardar</button>
</div>
{!! Form::close() !!}
