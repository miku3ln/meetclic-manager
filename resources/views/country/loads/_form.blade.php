<form id="country_form" class="m-form m-form--state m-form--fit m-form--label-align-right form-horizontal" method="POST">
    <div class="m-portlet__body">
        <input type="hidden" name="country_id" id="country_id" value="{{ $country->id }}" />

        <div class="form-group m-form__group row">
            <label for="iso_codes" class="col-form-label col-md-3">* Codigo Pais:</label>
            <div class="col-md-9">
                <input  id="iso_codes" type="text" name="iso_codes" value="{{ $country->iso_codes }}" class="form-control m-input" autocomplete="off" placeholder="ej. AF / AFG" maxlength="8" />
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label for="phone_code" class="col-form-label col-md-3">* Codigo Llamada:</label>
            <div class="col-md-9">
                <input id="phone_code" type="text" name="phone_code" value="{{ $country->phone_code }}" class="form-control m-input" autocomplete="off" placeholder="ej. 355" maxlength="15" />
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label for="name" class="col-form-label col-md-3">* Nombre:</label>
            <div class="col-md-9">
                <input id="name" type="text" name="name" value="{{ $country->name }}" class="form-control m-input" autocomplete="off" placeholder="ej. Ecuador" maxlength="64" />
            </div>
        </div>

        @if ($country->id)
            <div class="form-group m-form__group row">
                <label for="status" class="col-form-label col-md-3">* Estado:</label>
                <div class="col-md-9">
                    <select name="status" class="form-control m-input" id="status">
                        <option value="ACTIVE" {{ $country->status == 'ACTIVE' ? 'selected' : '' }}>Activo</option>
                        <option value="INACTIVE" {{ $country->status == 'INACTIVE' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
            </div>
        @endif
    </div>
</form>
