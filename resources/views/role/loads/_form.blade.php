<form id="role_form" class="m-form m-form--state m-form--fit m-form--label-align-right form-horizontal"
      method="{{ $method }}">
    <div class="m-portlet__body">
        <input type="hidden" name="role_id" id="role_id" value="{{ $role->id }}">
        <div class="form-group m-form__group row">
            <label for="name" class="col-form-label col-md-3">* Nombre:</label>
            <div class="col-md-9">
                <input id="name" type="text" name="name" value="{{ $role->name }}" class="form-control m-input"
                       autocomplete="off" placeholder="ej. Usuario" maxlength="64">
            </div>
        </div>
        @if ($role->id)
            <div class="form-group m-form__group row">
                <label for="status" class="col-form-label col-md-3">* Estado:</label>
                <div class="col-md-9">
                    <select id="status" name="status" class="form-control">
                        <option value="ACTIVE" {{ $role->status == 'ACTIVE' ? 'selected' : '' }}>Activo</option>
                        <option value="INACTIVE" {{ $role->status == 'INACTIVE' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
            </div>
        @endif

        <h1>Total Asignados: <span>{{$totalAdd}}</span></h1>
        <div class="m-form__group form-group row">
            <label for="functions" class="col-3 col-form-label">* Funciones:</label>
            <input type="hidden" name="functions" id="functions">
            <div class="col-9">
                <div class="manager-actions">


                    {!! $actions !!}
                </div>
            </div>
        </div>



    </div>
</form>
