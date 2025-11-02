<form action="{{$method}}" id="user_form"
      class="m-form m-form--state m-form--fit m-form--label-align-right form-horizontal">
    <div class="m-portlet__body">


        <input type="hidden" name="user_id" value="{{$user->id}}" id="user_id">
        <input type="hidden" name="roles_id" value="" id="roles_id">

        <div class="form-group m-form__group row">

            <label for="name" class="col-form-label col-md-4">Nombre</label>
            <div class="col-md-8">

                <input id="name" type="text" name="name" class="form-control m-input" placeholder="ej. Nombre Apellido"
                       value="{{$user->name}}"  maxlength="64" />
            </div>
        </div>
        <div class="form-group m-form__group row">

            <label for="email" class="col-form-label col-md-4">* Email</label>
            <div class="col-md-8">

                <input id="email" type="text" name="email" class="form-control m-input" placeholder="ej. usuario@mail.com"
                       value="{{$user->email}}"/>
            </div>
        </div>
        <div class="form-group m-form__group row">

            <label for="username" class="col-form-label col-md-4">* Nombre Usuario:</label>
            <div class="col-md-8">

                <input id="username" type="text" name="username" class="form-control m-input" placeholder="ej. usuario1"
                       value="{{$user->username}}"/>

            </div>
        </div>
        <div class="form-group m-form__group row">

            <label for="roles" class="col-form-label col-md-4">* Roles:</label>

            <div class="col-md-8">
                @if($roles)
                    <input id="selected_roles" type="hidden" value="{{$roles}}"/>

                @endif

                <select class="form-control m-select2 select2-hidden-accessible" id="roles" name="roles" data-select2-id="roles">

                </select>
            </div>
        </div>
        @if($user->id)
            <div class="form-group m-form__group row">

                <label for="password_change" class="col-form-label col-md-4">Cambiar contraseña?</label>

                <div class="col-md-8">
                    <input type="checkbox" id="password-change" name="password_change">
                </div>
            </div>
        @endif
        <div id="container-password" style="{{$user->id ?'display: none;' :''}}">
            @if ($user->id)
                <div class="form-group m-form__group row">

                    <label for="password_old" class="col-form-label col-md-4">* Contraseña actual:</label>
                    <div class="col-md-8">

                        <input id="password_old" type="password" name="password_old" value=""/>

                    </div>
                </div>
            @endif
            <div class="form-group m-form__group row">

                <label for="password" class="col-form-label col-md-4">{{$user->id ?'* Nueva Contraseña:':'* Contraseña:'}}</label>

                <div class="col-md-8">

                    <input type="password" id="password" name="password" class="form-control m-input">

                </div>
            </div>
            <div class="form-group m-form__group row">


                <label for="password_confirm" class="col-form-label col-md-4">{{'* Confirmar Contraseña:'}}</label>

                <div class="col-md-8">

                    <input type="password" id="password_confirm" name="password_confirm" class="form-control m-input">

                </div>
            </div>
        </div>
        @if ($user->id)
            <div class="form-group m-form__group row">

                <div class="col-md-8">


                    <select name="status" class="form-control m-input">
                        <option value="ACTIVE">Activo</option>
                        <option value="INACTIVE">Inactivo</option>

                    </select>
                </div>
            </div>
        @endif
    </div>
</form>


