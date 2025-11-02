
<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>

@php
    $managerOptions=[
    'pageTitle'=>'Administracion',
             'menuParentName'=>'Administracion',
           'menuName'=>'Usuarios',
                      'menuName'=>'Usuarios',
'title'=>'Usuarios',
 'icon'=>'<i class="flaticon-cogwheel-2"></i>',
    'id_table'=>'user_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newUser()',
        'color'=>'btn-primary'
        ],
      ],
      'modal'=>[
    'title'=>'Crear Usuario',
    'id'=>'modal',
    'size'=>'modal-lg',
    'action_buttons'=>[
        [
        'id'=>'btn_save',
        'label'=>'Guardar',
        'handler_js'=>'saveUser()',
        'color'=>'btn-primary'
        ],
     ]
    ]
   ];
@endphp
@extends('layouts.masterMinton')

@section('breadcrumb')
    @include('partials.breadcrumb',$managerOptions)
@endsection

@section('headerMenuManagerLeft')
    <li class="dropdown d-none d-lg-block">
        <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button"
           aria-haspopup="false" aria-expanded="false">
            Gestion
            <i class="mdi mdi-chevron-down"></i>
        </a>
        <div class="dropdown-menu">
            <!-- item-->
            <a href="javascript:{{$managerOptions['action_buttons'][0]['handler_js']}}" class="dropdown-item">
                <i class="fas fa-pen-alt"></i>
                <span>Creacion</span>
            </a>

        </div>
    </li>
@endsection
@include('partials.mangerMDataTablesJs')
@include('partials.mangerMDataTablesCss')
@section('css')

    <link href="{{ asset($resourcePathServer."libs/switch-bootstrap/switch-bootstrap.min.css") }}" rel="stylesheet"
          type="text/css">
@endsection
@section('content')
    @include('partials.admin_view',$managerOptions)
    @include('partials.modal',$managerOptions['modal'])
    <input id="action_get_form" type="hidden" value="{{ action("Users\UserController@getFormUser") }}"/>
    <input id="action_unique_email" type="hidden" value="{{ action("Users\UserController@postIsEmailUnique") }}"/>
    <input id="action_unique_username" type="hidden" value="{{ action("Users\UserController@postIsUsernameUnique") }}"/>
    <input id="action_save_user" type="hidden" value="{{ action("Users\UserController@postSave") }}"/>
    <input id="action_load_users" type="hidden" value="{{ action("Users\UserController@getListUsers") }}"/>
    <input id="action_load_roles_select2" type="hidden" value="{{ action("Users\RoleController@getListSelect2") }}"/>
    <input id="action_check_password_old" type="hidden"
           value="{{ action("Users\UserController@postCheckPasswordOld") }}"/>

@endsection
@section('after-additional-scripts')
    <script src="{{ asset($resourcePathServer."libs/switch-bootstrap/switch-bootstrap.min.js") }}"></script>
    <script src="{{ asset($resourcePathServer.'js/user/index.js') }}" type="text/javascript"></script>
@endsection
