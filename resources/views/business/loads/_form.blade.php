{!! Form::model($model, array('id' => $frmId.'_form','class' => 'm-form m-form--state m-form--fit m-form--label-align-right form-horizontal', 'method' => $method)) !!}
<div class="m-portlet__body">
    {!! Form::hidden('business_id', $model->business_id,['id'=>'business_id']) !!}
    {!! Form::hidden('id', $model->business_id,['id'=>'id']) !!}

    {!! Form::hidden('street_lat', $model->street_lat,['id'=>$model_entity.'_street_lat']) !!}
    {!! Form::hidden('street_lng', $model->street_lng,['id'=>$model_entity.'_street_lng']) !!}
    <div class="form-group m-form__group row">
        {!! Form::label('business_subcategory_id','* Subcategoria:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!!
             Form::select('business_subcategory_id',$subcategories,$model->business_subcategory_id,array('class' => 'form-control m-input') ) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        {!! Form::label('title','* Titulo:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!! Form::text('title', $model->title, array('class' => 'form-control m-input', 'autocomplete' =>
            'off', 'placeholder' => 'Plaza Pallares', 'maxlength' => '64')) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        {!! Form::label('phone_value','*Telefono:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!! Form::text('phone_value', $model->phone_value, array('class' => 'form-control m-input', 'autocomplete' =>
         'off', 'placeholder' => '0985617541', "type"=>"phone")) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-md-12" >
            {!! Form::label('address','* Dirección:', array('class' => 'col-form-label')) !!}
            <form class="form-inline margin-bottom-10" action="#" id="content-search-google-maps">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm m-input"
                           id="input_address"
                           placeholder="ej. Bolivar y Pedro Moncayo, Ibarra">
                </div>
            </form>
            <div id="my_map_location" style="height:150px;"></div>

        </div>

    </div>
    <div class="form-group m-form__group row">
        {!! Form::label('street_1','*Calle Principal:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!! Form::text('street_1', $model->street_1, array('class' => 'form-control m-input', 'autocomplete' =>
         'off', 'placeholder' => 'Piedrahita', "type"=>"text")) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        {!! Form::label('street_2','Calle Secundaria:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!! Form::text('street_2', $model->street_2, array('class' => 'form-control m-input', 'autocomplete' =>
         'off', 'placeholder' => 'Buenos Aires', "type"=>"text")) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        {!! Form::label('page_url','Web:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!! Form::text('page_url', $model->page_url, array('class' => 'form-control m-input', 'autocomplete' =>
         'off', 'placeholder' => 'www.plaza-pallares.com', "type"=>"url")) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        {!! Form::label('description','Descripcion:', array('class' => 'col-form-label col-md-3')) !!}
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