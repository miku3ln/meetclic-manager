{!! Form::model($tax, array('id' => 'tax_form','class' => 'm-form m-form--state m-form--fit m-form--label-align-right form-horizontal', 'method' => $method)) !!}
<div class="m-portlet__body">
    {!! Form::hidden('tax_id', $tax->id,['id'=>'tax_id']) !!}
    {!! Form::hidden('cities_id', null,['id'=>'cities_id']) !!}
    <div class="form-group m-form__group row">
        {!! Form::label('name','* Nombre:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!! Form::text('name', $tax->name, array('class' => 'form-control m-input', 'autocomplete' =>
            'off', 'placeholder' => 'ej. IVA 12%', 'maxlength' => '64')) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        {!! Form::label('value','* Valor:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!! Form::text('value', $tax->value, array('class' => 'form-control m-input', 'autocomplete' =>
            'off', 'placeholder' => 'ej. 12', 'maxlength' => '64')) !!}
        </div>
    </div>
    <div id="wrapper_country" class="form-group m-form__group row">
        {!! Form::label(null,'* Pais:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            @if($country_id)
                <input id="selected_country" type="hidden" value="{{ $country_id }}"/>
            @endif
            {!! Form::select('country_id',[], null, array('id' => 'select_country','class' => 'form-control m-select2')) !!}
        </div>
    </div>
    <div id="wrapper_province" class="form-group m-form__group row">
        {!! Form::label(null,'* Provincia:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            @if($province_id)
                <input id="selected_province" type="hidden" value="{{ $province_id }}"/>
            @endif
            {!! Form::select('province',[], null, array('id' => 'select_province','class' => 'form-control m-select2')) !!}
        </div>
    </div>
    <div  id="wrapper_cities"  class="form-group m-form__group row">
        {!! Form::label(null,'* Ciudad:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            @if($cities!='[]')
                <input id="selected_cities" type="hidden" value="{{ $cities }}"/>
            @endif
            {!! Form::select('citiesModel',[], null, array('id' => 'select_cities','class' => 'form-control m-select2')) !!}
        </div>
    </div>
    @if ($tax->id)
        <div class="form-group m-form__group row">
            {!! Form::label('status','* Estado:', array('class' => 'col-form-label col-md-3')) !!}
            <div class="col-md-9">
                {!! Form::select('status', array( 'ACTIVE' => 'Activo', 'INACTIVE' => 'Inactivo'),$tax->status,array('class' => 'form-control m-input') ) !!}
            </div>
        </div>
    @endif
</div>

{!! Form::close() !!}
