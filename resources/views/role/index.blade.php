<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@php
    $managerOptions=[
    'pageTitle'=>'Administracion',
             'menuParentName'=>'Administracion',
           'menuName'=>'Roles',
                      'menuName'=>'Roles',
'title'=>'Roles',
 'icon'=>'<i class="flaticon-cogwheel-2"></i>',
    'id_table'=>'role_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newRole()',
        'color'=>'btn-primary'
        ],
      ],
      'modal'=>[
    'title'=>'Crear Usuario',
    'id'=>'modal',
    'size'=>'modal-xl',
    'action_buttons'=>[
        [
        'id'=>'btn_save',
        'label'=>'Guardar',
        'handler_js'=>'saveRole()',
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
@section('content')
    @include('partials.admin_view',$managerOptions)
    @include('partials.modal',$managerOptions['modal'])
    <input id="action_get_form" type="hidden" value="{{ action("Users\RoleController@getFormRole") }}"/>
    <input id="action_unique_name" type="hidden" value="{{ action("Users\RoleController@postIsNameUnique") }}"/>
    <input id="action_save_role" type="hidden" value="{{ action("Users\RoleController@postSave") }}"/>
    <input id="action_load_roles" type="hidden" value="{{ action("Users\RoleController@getListRoles") }}"/>
@endsection
@include('partials.mangerMDataTablesJs')
@section('after-additional-scripts')
    <script src="{{ asset($resourcePathServer.'js/role/index.js') }}" type="text/javascript"></script>
@endsection
