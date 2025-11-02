<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>
@extends('layouts.frontend')
@section('additional-styles')
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">

    <link href="{{ URL::asset($resourcePathServer.'libs/jquery-select2/jquery-select2.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset($resourcePathServer.'css/frontend/web/ManagementFormEvent.css')}}">

@endsection
@section('additional-scripts')
    <script>
        var $currentPage = <?php echo json_encode(isset($dataManagerPage['currentPage']) ? $dataManagerPage['currentPage'] : 'not-defined')?>;
        var $resourcePathServer = '<?php echo $resourcePathServer?>';

    </script>
    <script src="{{ asset($resourcePathServer.'libs/vue-bootstrap/vue-bootstrap.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/uiv/uiv.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/Utils.js')}}" type='text/javascript'></script>

    <script src="{{ URL::asset($resourcePathServer.'libs/jquery-select2/jquery-select2.min.js') }}"></script>

    <script src="{{ asset($resourcePathServer.'js/frontend/web/ManagementFormEvent.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/frontend/web/CarouselEvents.js') }}" type="text/javascript"></script>

    @include('layouts.partials.managementFormEvent',array())


@endsection
@section('content')

    @include('layouts.frontend.slider',array('dataSliderHtml'=>$dataSliderHtml))
    @include('frontend.web.home.eventsCarousel',['resourcePathServer'=>$resourcePathServer])
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
@endsection
