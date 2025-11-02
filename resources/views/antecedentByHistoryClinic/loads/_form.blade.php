{!! Form::model($model, array('id' => $frmId.'_form','class' => 'm-form m-form--state m-form--fit m-form--label-align-right form-horizontal', 'method' => $method)) !!}
<div class="m-portlet__body">


    <input type="hidden" id="{{ $model_entity.'_id' }}" name="{{ $model_entity.'_id' }}" value="{{ $model->id }}">
    <input type="hidden" id="patient_id" name="patient_id" value="{{ $model->patient_id }}">

    <div class="form-group m-form__group row">
        {!! Form::label('country_id','* Antecedente:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            @if($model->antecedent_id)
                <input id="selected_antecedent_id" type="hidden" value="{{ $model->antecedent_id }}"/>
            @endif
                <select id="antecedent_id" name="antecedent_id" class="form-control m-select2">
                    <!-- Add options for the select here -->
                </select>

        </div>
    </div>
    <div class="form-group m-form__group row">

    </div>

</div>

{!! Form::close() !!}
