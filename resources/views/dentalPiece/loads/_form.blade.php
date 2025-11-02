<form id="{{ $frmId }}_form" class="m-form m-form--state m-form--fit m-form--label-align-right form-horizontal" method="{{ $method }}">
    <div class="m-portlet__body">
        <input type="hidden" name="{{ $model_entity }}_id" id="{{ $model_entity }}_id" value="{{ $model->id }}">

        <div class="form-group m-form__group row">
            <label for="name" class="col-form-label col-md-3">* Nombre:</label>
            <div class="col-md-9">
                <input type="text" name="name" id="name" class="form-control m-input" autocomplete="off" placeholder="ej. Tercer Molar Superior" maxlength="64" value="{{ $model->name }}">
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label for="piece" class="col-form-label col-md-3">* Piece:</label>
            <div class="col-md-9">
                <input type="text" name="piece" id="piece" class="form-control m-input" autocomplete="off" placeholder="ej. 18,17,16" maxlength="64" value="{{ $model->piece }}">
            </div>
        </div>

    </div>
</form>
