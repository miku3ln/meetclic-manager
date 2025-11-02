
<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@php
    $managerOptions=[
    'pageTitle'=>'Administracion',
             'menuParentName'=>'Administracion',
           'menuName'=>'Pacientes',
                      'menuName'=>'Pacientes',
'title'=>'Pacientes',
 'icon'=>'<i class="flaticon-cogwheel-2"></i>',
    'id_table'=>'patient_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newPatient()',
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
    <?php

    $model_entity = "patient";
    $url_path_plugins = "libs/";
    ?>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" rel="stylesheet"
          type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"
          type="text/css">
    <link href="{{ asset($resourcePathServer."css/patient/managementElements.css") }}" rel="stylesheet"
          type="text/css">
    <link href="{{ asset($resourcePathServer.'css/'.$model_entity.'/managementOdontogram.css') }}" rel="stylesheet"
          type="text/css">
    {{--PLUGINS--}}
    <link href="{{ asset($resourcePathServer.$url_path_plugins."bootgrid1.3.1/bootgrid1.3.1.min.css") }}" rel="stylesheet"
          type="text/css">
@endsection
@section('content')
    <div id="container_patients">
        @include('partials.admin_view',[
    'title'=>'Administración de Pacientes',
    'icon'=>'<i class="flaticon-users"></i>',
    'id_table'=>'patient_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newPatient()',
        'color'=>'btn-primary'
        ],
      ]
    ])

    </div>
    <div id="container_patient_form"></div>
    <div id="container-management"></div>
    @include('partials.modal',[
    'title'=>'Crear paciente',
    'id'=>'modal',
    'size'=>'modal-lg',
    'action_buttons'=>[
        [
        'type'=>'submit',
        'form'=>'patient_form',
        'id'=>'btn_save',
        'label'=>'Guardar',
        'color'=>'btn-primary'
        ],
     ]
    ])
    <?php
    $model_entity = "patient";
    $wizards_route = $model_entity . ".partials.actions";
    $params = [
        "model_entity" => $model_entity,
    ];

    ?>
    @include($wizards_route,$params)

@endsection
@include('partials.mangerMDataTablesJs')
@include('partials.mangerMDataTablesCss')
@section('script')

    <script src="{{ asset($resourcePathServer.'plugins/bootstrap/bootstrap332.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartist/0.11.4/chartist.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js" type="text/javascript"></script>

    <script src="{{ asset($resourcePathServer.'js/patient/index.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/patient/dashboard.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/patient/managementFormsRulesValidations.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/patient/managementGrids.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/patient/managementMenu.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/patient/managementOdontogramOptionSvg.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/patient/managementOdontogramManagement.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/patient/management.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/patient/managementClinicalDocuments.js') }}" type="text/javascript"></script>
    {{--PLUGINS--}}
    {{--ALERTS--}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{----- PLUGINS--}}
    <script src="{{ asset($resourcePathServer.$url_path_plugins."tooltip/tooltip.min.js") }}" type="text/javascript"></script>
    {{--BOOTGRID--}}
    <script src="{{ asset($resourcePathServer.'libs/bootgrid1.3.1/bootgrid1.3.1.min.js')}}"></script>
    {{-- SNAP SVG--}}
    <script src="{{ asset($resourcePathServer.$url_path_plugins."snap-svg/snap-svg.js") }}" type="text/javascript"></script>
 {{--   <link href="{{ asset($resourcePathServer.'metronic/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" >--}}




    <script src="https://maps.google.com/maps/api/js?key=AIzaSyAy7FfEU_fOeVTrJKxENPLxAor4cL6_d88&libraries=places"></script>
    {{--  ----TREATMENT PLAN BY PATIENT----}}
    <script src="{{ asset($resourcePathServer.'js/patient/managementTreatmentPlanByPatientManagement.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/patient/managementTreatmentPlanByPatientForm.js') }}" type="text/javascript"></script>

@endsection

