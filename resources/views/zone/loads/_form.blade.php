<form id="zone_form" class="m-form m-form--state m-form--fit m-form--label-align-right form-horizontal" method="POST">
    <div class="m-portlet__body">
        <input type="hidden" name="zone_id" id="zone_id" value="{{ $zone->id }}" />
        <input type="hidden" name="city_id" id="city_id" value="{{ $zone->city_id }}" />

        <div class="form-group m-form__group row">
            <label for="name" class="col-form-label col-md-3">* Nombre:</label>
            <div class="col-md-6">
                <input id="name" type="text" name="name" value="{{ $zone->name }}" class="form-control m-input" autocomplete="off" placeholder="ej. Centro" maxlength="64" />
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label for="zip_code" class="col-form-label col-md-3">Código Zip:</label>
            <div class="col-md-6">
                <input id="zip_code" type="text" name="zip_code" value="{{ $zone->latitude }}" class="form-control m-input" autocomplete="off" placeholder="ej. 100200" maxlength="64" />
            </div>
        </div>

        @if ($zone->id)
            <div class="form-group m-form__group row">
                <label for="status" class="col-form-label col-md-3">* Estado:</label>
                <div class="col-md-6">
                    <select name="status" class="form-control m-input" id="status">
                        <option value="ACTIVE" {{ $zone->status == 'ACTIVE' ? 'selected' : '' }}>Activo</option>
                        <option value="INACTIVE" {{ $zone->status == 'INACTIVE' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
            </div>
        @endif
    </div>
</form>
