<?php
$model = $step1["model"];
$subcategories = $step1["subcategories"];
$countries = $step1["countries"];
?>
<div class="content-row-manager-buttons">

    <button type="button"
            class="btn btn-success" v-on:click="_saveBusiness()">
        Guardar
    </button>
</div>
<div class="content-form">
    <p v-if="errors.length">
        <b>Please correct the following error(s):</b>
    <ul>
        <li v-for="error in errors">  <?php echo "{{ error }}"?></li>
    </ul>
    </p>

    {!! Form::model($model, array('id' => $frmId.'-form','class' => '', 'v-on:submit.prevent="_submitForm"' ,"enctype"=>"multipart")) !!}

    @if ($model->id)
        <div class="form-group m-form__group row">
            {!! Form::label('status',' Estado', array('class' => 'col-md-12')) !!}
            <div class="col-md-12">
                {!! Form::select('status', array( 'ACTIVE' => 'Activo', 'INACTIVE' => 'Inactivo'),$model->status,array('class' => 'form-control m-input') ) !!}
            </div>
        </div>
    @endif
    {!! Form::hidden('id', $model->id,['id'=>'id','v-model'=>"modelBusiness.id" ]) !!}
    {!! Form::hidden('street_lat', $model->street_lat,['id'=>$model_entity.'_street_lat']) !!}
    {!! Form::hidden('street_lng', $model->street_lng,['id'=>$model_entity.'_street_lng']) !!}

    <div class="row">

        <div class="col col-lg-6 col-md-6 col-sm-12 col-xs-12" id="col-content-manager-url_img">
            <div class="content-box-image content-box-preview" id="container_selector_image" @click="_uploadData">
                <img class="content-box-image__preview" v-load-img="{source:modelBusiness.source}">
                <div class="content-box-image__manager">
                    <button @click="_uploadData" class="btn-upload-resources "
                            id="btn-add-url_img">
                        <i class="icon icon-plus"></i>
                        <?php echo "{{lblUploadName}}" ?>
                    </button>
                    <input
                        v-_upload-resource="{_initEventsUpload:_initEventsUpload}"
                        type="file"
                        id="file_upload_img"
                        class="hidden"
                        name="Information[file_upload_img]"
                    >
                </div>
            </div>
            <div class="progress-business not-view">
                <div class="progress__bar"></div>
                <div class="progress__percent">0%</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group m-form__group ">

                {!! Form::label('title',' Titulo*', array('class' => 'form__label ')) !!}

                {!! Form::text('title', $model->title, array('class' => 'form-control m-input ', 'autocomplete' =>
                'off', 'placeholder' => 'Plaza Pallares', 'maxlength' => '64' , 'v-model'=>"modelBusiness.title" ,"v-focus-select"

                )) !!}

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group m-form__group ">

                {!! Form::label('countries_id',' Pais*', array('class' => 'form__label ')) !!}
                {!!
                 Form::select('countries_id',$countries,$model->countries_id,array('class' => 'form-control m-input ', 'v-model'=>"modelBusiness.countries_id") ) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group m-form__group ">
                {!! Form::label('business_subcategories_id',' Tipo*', array('class' => 'form__label ')) !!}

                {!!
                 Form::select('business_subcategories_id',$subcategories,$model->business_subcategories_id,array('class' => 'form-control m-input ', 'v-model'=>"modelBusiness.business_subcategories_id") ) !!}

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="floating-panel-manager">
                <input id="search-map-current"
                       class="floating-panel-manager__search"
                       type="textbox"
                       value="Ecuador"
                       v-focus-select
                >

            </div>
            <div id="map" class="map-information"
                 v-init-map="{initMapCurrent:initMapCurrent,modelBusiness:modelBusiness}">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group m-form__group ">

                {!! Form::label('phone_value','Telefono*', array('class' => 'form__label ')) !!}

                {!! Form::text('phone_value', $model->phone_value, array('class' => 'form-control m-input',' v-on:change="_setChat()"', 'autocomplete' =>
             'off', 'placeholder' => '0985617541', "type"=>"phone" ,  'v-model'=>"modelBusiness.phone_value","v-focus-select")) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group m-form__group ">
                {!! Form::label('email','Email*', array('class' => 'form__label ')) !!}

                {!! Form::text('email', $model->email, array('class' => 'form-control m-input', 'autocomplete' =>
             'off', 'placeholder' => 'email@gmail.com', "type"=>"email" ,  'v-model'=>"modelBusiness.email","v-focus-select")) !!}

            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group m-form__group ">

                {!! Form::label('street_1','Calle Principal*', array('class' => 'form__label ')) !!}

                {!! Form::text('street_1', $model->street_1, array('class' => 'form-control m-input', 'autocomplete' =>
             'off', 'placeholder' => 'Piedrahita', "type"=>"text" ,  'v-model'=>"modelBusiness.street_1" ,"v-focus-select")) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group m-form__group ">
                {!! Form::label('street_2','Calle Secundaria*', array('class' => 'form__label ')) !!}

                {!! Form::text('street_2', $model->street_2, array('class' => 'form-control m-input', 'autocomplete' =>
             'off', 'placeholder' => 'Buenos Aires', "type"=>"text"  ,  'v-model'=>"modelBusiness.street_2","v-focus-select")) !!}

            </div>

        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group m-form__group ">
                {!! Form::label('description','Descripcion*', array('class' => 'form__label ')) !!}
                {!!Form::textarea('description',$model->description,['class'=>'form-control  ', 'rows' => 2, 'cols' => 40 ,' v-on:change="_setChat()"',  'v-model'=>"modelBusiness.description","v-focus-select"])!!}

            </div>
        </div>
        <div class="col-md-6">

            <div class="form-group m-form__group ">
                {!! Form::label('page_url','Web', array('class' => 'form__label ')) !!}

                {!! Form::text('page_url', $model->page_url, array('class' => 'form-control m-input ', 'autocomplete' =>
             'off', 'placeholder' => 'www.plaza-pallares.com', "type"=>"url"  ,  'v-model'=>"modelBusiness.page_url","v-focus-select")) !!}

            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<div class="manager-contact-msg">
    <a v-for="(chat, index) in managerChat"
       target="blank"
       v-bind:href="chat.url"
       id="manager-contact-msg__wapp"
    >
        <img v-bind:src="chat.img">
        <p><?php echo '{{chat.span}}'?></p>
    </a>
</div>

