<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';


?>
@extends('layouts.frontend')
@section('additional-styles')
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">
    @include('partials.plugins.resourcesCss',['toast'=>true])
    <link href="{{ URL::asset($resourcePathServer.'libs/jquery-select2/jquery-select2.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset($resourcePathServer.'css/frontend/web/ManagementFormEvent.css')}}">
@endsection

@section('additional-scripts')
    {{-- BOOTGRID--}}
    <script>
        var $currentPage = <?php echo json_encode(isset($dataManagerPage['currentPage']) ? $dataManagerPage['currentPage'] : 'not-defined')?>;
        var $eventDetails = {};
            @if(isset($dataManagerPage['eventDetails']))

        var $eventDetails = <?php
            $dataManagerPage['eventData']['url'] = route('eventDetails', app()->getLocale()) . "/" . $dataManagerPage['eventData']['data']->id;
            echo json_encode($dataManagerPage['eventData'])?>;
            @else
        var $eventDetails = {};
        @endif
    </script>

    <script src="{{ asset($resourcePathServer.'libs/vue-bootstrap/vue-bootstrap.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/uiv/uiv.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/Utils.js')}}" type='text/javascript'></script>

    <script src="{{ URL::asset($resourcePathServer.'libs/jquery-select2/jquery-select2.min.js') }}"></script>

    <script src="{{ asset($resourcePathServer.'js/frontend/web/ManagementFormEvent.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/frontend/web/EventDetails.js')}}"></script>

    @include('layouts.partials.managementFormEvent',array())

@endsection
@section('content')
    <div id="app-management">

        <input id="action-users-listAllRoutes" type="hidden"
               value="{{route('listUsersRoutes',app()->getLocale())}}"/>
        <div id="management-take-part">
            <div v-if="configModalManagementFormEvent.viewAllow">

                <management-form-event-component
                    ref="refManagementFormEvent"
                    :params="configModalManagementFormEvent"

                ></management-form-event-component>
            </div>
        </div>

        <div class="breadcrumb-area section-space--breadcrumb section-space--manager-sisdep">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <!--=======  breadcrumb wrapper  =======-->

                        <div class="breadcrumb-wrapper">
                            <h2 class="page-title">
                                @if(isset( $dataManagerPage['header']['title']))
                                    {{ $dataManagerPage['header']['title']}}

                                @endif
                            </h2>
                            <ul class="breadcrumb-list">
                                {!! $dataManagerPage['header']['breadCrumb']['inactive'] !!}

                                <li class="active">
                                    @if(isset( $dataManagerPage['header']['breadCrumb']['active']))
                                        {{$dataManagerPage['header']['breadCrumb']['active']}}

                                    @endif
                                </li>
                            </ul>
                        </div>

                        <!--=======  End of breadcrumb wrapper  =======-->
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content-wrapper">
            <!--=======  shop page area  =======-->
            @if(isset($dataManagerPage['eventDetails']))
                {{$dataManagerPage['eventDetails']}}

            @else
                <div class="container">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="empty-data warning">
                                <h1><span>  {{__('messages.errors.warning')}}</span> {{__('messages.not-manager')}}</h1>
                            </div>
                        </div>
                    </div>

                </div>

            @endif
        </div>
    </div>

@endsection
