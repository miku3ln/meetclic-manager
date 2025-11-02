<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>

@extends('layouts.masterMinton')

@section('css')
    <link href="{{ asset($resourcePathServer."libs/fullcalendar/fullcalendar.min.css") }}" rel="stylesheet"
          type="text/css">
@endsection
@section('breadcrumb')
    @include('partials.breadcrumb',[
      'pageTitle'=>'Inicio',
           'menuName'=>'Inicio',

      ])
@endsection
@section('content')
    <div class="container" id="app-management">

        <div class="row">
            <div class="col">
                <div class="card-box">
                    <?php
                    if ($user->id == 1) { ?>
                    <scheduling-component

                    >
                    </scheduling-component>
                    <?php }
                    else {
                        $managerHtml = "";
                        $managerHtml .= '   <div class="content-manager">';
                        $managerHtml .= '<a href="' .url( $urlManager ). '">Empresa  Gestionable.</a>';
                        $managerHtml .= '</div>';
                        echo $managerHtml;
                    }
                    ?>
                </div>
            </div><!-- end col -->

        </div>
    </div>
@endsection

@section('script')
    <script>
        var managerActions = {

            calendarViewData: "{{action("Products\ProductController@getAdminProductsBusiness")}}"

        }
    </script>
    <script type="text/x-template" id="scheduling-template">
        <div>
            <div id='calendar' v-initCalendar="{init:initCalendar}"></div>
        </div>

    </script>
    <!-- init js -->
    <script src="{{ asset($resourcePathServer.'libs/fullcalendar/fullcalendar.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'js/home/home/components/Scheduling.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'js/home/home/App.js')}}"></script>
@endsection

@section('script-bottom')

@endsection
