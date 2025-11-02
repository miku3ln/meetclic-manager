{!! Form::model($model, array('id' => $frmId.'_form','class' => 'm-form m-form--state m-form--fit m-form--label-align-right form-horizontal', 'method' => $method)) !!}
<div class="m-portlet__body">
    {!! Form::hidden($model_entity.'_id', $model->id,['id'=>$model_entity.'_id']) !!}
    {!! Form::hidden('patient_id', $model->patient_id,['id'=>'patient_id']) !!}
    <div class="form-group m-form__group row">
        {!! Form::label('date','* Fecha:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!!Form::text('date',$model->date,['class'=>'form-control','placeholder' => 'ej.18/09/1998'])!!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        {!! Form::label('description','* Description:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!!Form::textarea('description',$model->description,['class'=>'form-control', 'rows' => 2, 'cols' => 40])!!}
        </div>
    </div>
    @if ($model->id)
        <div class="form-group m-form__group row">
            {!! Form::label('status','* Estado:', array('class' => 'col-form-label col-md-3')) !!}
            <div class="col-md-9">
                {!! Form::select('status', array( 'ACTIVE' => 'Activo', 'INACTIVE' => 'Inactivo'),$model->status,array('class' => 'form-control m-input') ) !!}
            </div>
        </div>
    @endif

</div>

{!! Form::close() !!}