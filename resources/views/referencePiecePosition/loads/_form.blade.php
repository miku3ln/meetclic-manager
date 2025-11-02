<form id="{{ $frmId }}_form" class="m-form m-form--state m-form--fit m-form--label-align-right form-horizontal" method="{{ $method }}">
    <div class="m-portlet__body">
        <input type="hidden" name="{{ $model_entity }}_id" id="{{ $model_entity }}_id" value="{{ $model->id }}">

        <div class="form-group m-form__group row">
            <label for="status" class="col-form-label col-md-3">* Posicion:</label>
            <div class="col-md-9">
                <select name="position" id="position" class="form-control m-input">
                    <option value="TOP" {{ $model->position == 'TOP' ? 'selected' : '' }}>Arriba</option>
                    <option value="DOWN" {{ $model->position == 'DOWN' ? 'selected' : '' }}>Abajo</option>
                    <option value="RIGHT" {{ $model->position == 'RIGHT' ? 'selected' : '' }}>Derecha</option>
                    <option value="LEFT" {{ $model->position == 'LEFT' ? 'selected' : '' }}>Izquierda</option>
                    <option value="CENTER" {{ $model->position == 'CENTER' ? 'selected' : '' }}>Centro</option>
                    <option value="COMPLETE" {{ $model->position == 'COMPLETE' ? 'selected' : '' }}>Pieza Total</option>
                </select>
            </div>
        </div>

    </div>
</form>
