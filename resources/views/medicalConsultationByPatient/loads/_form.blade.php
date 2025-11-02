
{!! Form::model($model, array('id' => $model_entity.'_form','class' => 'm-form m-form--state m-form--fit m-form--label-align-right form-horizontal', 'method' => $method)) !!}
<div class="m-portlet__body">
    {!! Form::hidden($model_entity.'_id', $model->id,['id'=>$model_entity.'_id']) !!}
    <div class="form-group m-form__group row">
        {!! Form::label('name','* Nombre:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!! Form::text('name', $model->name, array('class' => 'form-control m-input', 'autocomplete' =>
            'off', 'placeholder' => 'ej. Piel,Labios', 'maxlength' => '64')) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        {!! Form::label('description','Description:', array('class' => 'col-form-label col-md-3')) !!}
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