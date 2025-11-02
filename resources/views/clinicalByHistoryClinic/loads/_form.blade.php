{!! Form::model($model, array('id' => $frmId.'_form','class' => 'm-form m-form--state m-form--fit m-form--label-align-right form-horizontal', 'method' => $method)) !!}
<div class="m-portlet__body">
    {!! Form::hidden($model_entity.'_id', $model->id,['id'=>$model_entity.'_id']) !!}
    {!! Form::hidden('patient_id', $model->patient_id,['id'=>'patient_id']) !!}
    <div class="form-group m-form__group row">
        {!! Form::label('country_id','* Examen Clinico:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            @if($model->clinical_exam_id)
                <input id="selected_clinical_exam_id" type="hidden" value="{{ $model->clinical_exam_id }}"/>
            @endif
            {!! Form::select('clinical_exam_id',array(), $model->clinical_exam_id, array('class' => 'form-control m-select2',"id"=>"clinical_exam_id")) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        {!! Form::label('pathology_description','Description:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!!Form::textarea('pathology_description',$model->pathology_description,['class'=>'form-control', 'rows' => 2, 'cols' => 40])!!}
        </div>
    </div>

</div>

{!! Form::close() !!}