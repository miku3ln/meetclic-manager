<form id="{{ $frmId }}_form" class="m-form m-form--state m-form--fit m-form--label-align-right form-horizontal" method="{{ $method }}">
    <div class="m-portlet__body">
        <input type="hidden" name="{{ $model_entity }}_id" id="{{ $model_entity }}_id" value="{{ $model->id }}">

        <div class="form-group m-form__group row">
            <label for="reference_type_id" class="col-form-label col-md-3">* Tipo Referencia:</label>
            <div class="col-md-9">
                <select name="reference_type_id" id="reference_type_id" class="form-control m-input">
                    @foreach ($reference_type_id_data as $key => $value)
                        <option  color-current="{{$value['color']}}" value="{{ $key }}" {{ $model->reference_type_id == $key ? 'selected' : '' }}>{{ $value['text'] }}</option>
                    @endforeach
                </select>
                <span class="manager-color"><span id="manager-color__text"> </span></span>
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label for="type" class="col-form-label col-md-3">* Tipo:</label>
            <div class="col-md-9">
                <select name="type" id="type" class="form-control m-input">
                    <option value="INDIVIDUAL" {{ $model->type == 'INDIVIDUAL' ? 'selected' : '' }}>Cara Individual</option>
                    <option value="COMPLETE" {{ $model->type == 'COMPLETE' ? 'selected' : '' }}>Pieza Completa</option>
                </select>
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label for="name" class="col-form-label col-md-3">* Nombre:</label>
            <div class="col-md-9">
                <input type="text" name="name" id="name" class="form-control m-input" autocomplete="off" placeholder="ej. Tercer Molar Superior" maxlength="64" value="{{ $model->name }}">
            </div>
        </div>

        <div class="form-group m-form__group row not-view">
            <label for="color" class="col-form-label col-md-3">Color:</label>
            <div class="col-md-9">
                <input color-current="{{ $model->color }}" name="color" id="color" class="form-control m-input" value="{{ $model->color }}">
            </div>
        </div>

        @if ($model->id)
            <div class="form-group m-form__group row">
                <label for="status" class="col-form-label col-md-3">* Estado:</label>
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
