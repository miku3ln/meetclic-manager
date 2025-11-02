<form id="antecedent_form" class="m-form m-form--state m-form--fit m-form--label-align-right form-horizontal" method="{{$method}}">
<div class="m-portlet__body">
    @csrf
    <input type="hidden" id="{{ $model_entity.'_id' }}" name="{{ $model_entity.'_id' }}" value="{{ $model->id }}">
    <div class="form-group m-form__group row">
        <label class="col-form-label col-md-3" for="name">* Nombre:</label>
        <div class="col-md-9">
            <input id="name" type="text" name="name" value="{{$model->name}}" class="form-control m-input"
                   autocomplete="off" placeholder="ej. Pichincha" maxlength="64">
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label class="col-form-label col-md-3" for="description">* Descripcion:</label>
        <div class="col-md-9">

            <textarea id="description" name="description" value="{{$model->description}}" class="form-control m-input">
            </textarea>
        </div>
    </div>
    @if ($model->id)
        <div class="form-group m-form__group row">
            <label class="col-form-label col-md-3" for="status">* Estado:</label>

            <div class="col-md-9">

            </div>


        </div>
    @endif
</div>


</form>
