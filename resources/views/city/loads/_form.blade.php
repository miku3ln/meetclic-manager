<?php


?>

<form id="city_form" class="m-form m-form--state m-form--fit m-form--label-align-right form-horizontal" method="{{ $method }}">
    <div class="m-portlet__body">
        <input type="hidden" name="city_id" id="city_id" value="{{ $city->id }}">
        <input type="hidden" name="province_id" id="province_id" value="{{ $city->id }}">
        <div class="form-group m-form__group row">
            <label for="name" class="col-form-label col-md-3">* Nombre:</label>
            <div class="col-md-6">
                <input id="name" type="text" id="name" name="name" class="form-control m-input" autocomplete="off" onFocus="geolocate()" placeholder="ej. Quito" maxlength="64" value="{{ $city->name }}">
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label for="latitude" class="col-form-label col-md-3">Latitud:</label>
            <div class="col-md-6">
                <input type="text" id="latitude" name="latitude" class="form-control m-input" autocomplete="off" placeholder="ej. -79.9632541" maxlength="64" value="{{ $city->location ? $city->lat : null }}" readonly>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label for="longitude" class="col-form-label col-md-3">Longitud:</label>
            <div class="col-md-6">
                <input type="text"  id="longitude" name="longitude" class="form-control m-input" autocomplete="off" placeholder="ej. 56.9632541" maxlength="64" value="{{ $city->location ? $city->lng : null }}" readonly>
            </div>
        </div>
        @if ($city->id)
            <div class="form-group m-form__group row">
                <label for="status" class="col-form-label col-md-3">* Estado:</label>
                <div class="col-md-6">
                    <select name="status" class="form-control m-input" id="status">
                        <option value="ACTIVE" {{ $city->status == 'ACTIVE' ? 'selected' : '' }}>Activo</option>
                        <option value="INACTIVE" {{ $city->status == 'INACTIVE' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
            </div>
        @endif
        <div class="form-group m-form__group row">
            <div class="col-md-12">
                <div style="width:auto;height: 300px;" id="city_map"></div>
            </div>
        </div>
    </div>
</form>
