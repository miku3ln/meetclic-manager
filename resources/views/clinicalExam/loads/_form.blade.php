<form id="{{ $frmId }}_form" class="m-form m-form--state m-form--fit m-form--label-align-right form-horizontal" method="{{ $method }}">
    <div class="m-portlet__body">
        <input type="hidden" name="{{ $model_entity }}_id" id="{{ $model_entity }}_id" value="{{ $model->id }}">

        <div class="form-group m-form__group row">
            <label for="name" id="name_label" class="col-form-label col-md-3">* Nombre:</label>
            <div class="col-md-9">
                <input type="text" name="name" id="name" class="form-control m-input" autocomplete="off" placeholder="ej. Piel,Labios" maxlength="64" value="{{ $model->name }}">
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label for="description" id="description_label" class="col-form-label col-md-3">Description:</label>
            <div class="col-md-9">
                <textarea name="description" id="description" class="form-control" rows="2" cols="40">{{ $model->description }}</textarea>
            </div>
        </div>

        @if ($model->id)
            <div class="form-group m-form__group row">
                <label for="status" id="status_label" class="col-form-label col-md-3">* Estado:</label>
                <div class="col-md-9">
                    <select name="status" id="status" class="form-control m-input">
                        <option value="ACTIVE" {{ $model->status == 'ACTIVE' ? 'selected' : '' }}>Activo</option>
                        <option value="INACTIVE" {{ $model->status == 'INACTIVE' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
            </div>
        @endif
    </div>
</form>
