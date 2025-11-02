

<form id="province_form" class="m-form m-form--state m-form--fit m-form--label-align-right form-horizontal" method="{{$method}}">
    @csrf
    <div class="m-portlet__body">
        <input type="hidden" name="province_id" value="{{$province->province_id}}" id="province_id">
        <div class="form-group m-form__group row">
            <label class="col-form-label col-md-3" for="name">* Nombre:</label>
            <div class="col-md-9">
                <input id="name" type="text" name="name" value="{{$province->name}}" class="form-control m-input" autocomplete="off" placeholder="ej. Pichincha" maxlength="64">
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-form-label col-md-3" for="country_id">* País:</label>
            <div class="col-md-9">
                @if($province->country_id)
                    <input id="selected_country" type="hidden" value="{{ $province->country_id }}">
                @endif
                <select name="country_id" class="form-control m-select2" id="country_id">

                </select>
            </div>
        </div>
        @if ($province->id)
            <div class="form-group m-form__group row">
                <label class="col-form-label col-md-3" for="status">* Estado:</label>
                <div class="col-md-9">
                    <select name="status" class="form-control m-input" id="status">
                        <option value="ACTIVE">Activo</option>
                        <option value="INACTIVE" >Inactivo</option>
                    </select>
                </div>
            </div>
        @endif
    </div>
</form>


