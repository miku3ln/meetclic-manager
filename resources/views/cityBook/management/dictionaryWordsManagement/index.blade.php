@extends('layouts.cityBook')
<?php
$managementNameProcess = $configPartial['moduleCamel'];

?>
@section('content')
    <div id="app-management" class="container">


        <!--section -->
        <section id="sec1">
            <!-- container -->
            <div class="profile-edit-wrap">

                @include('cityBook.web.partials.buttons-manager')

                <div class="row">
                    <div class="col-md-3">
                        <div class="fixed-bar fl-wrap">
                            <div class="user-profile-menu-wrap fl-wrap">
                                @include('cityBook.menu.account')
                            </div>
                        </div>

                    </div>
                    <div id="tab-business" class="col-md-9">

                        @include('cityBook.management.'.$managementNameProcess.'.partials.wizards.index',['managementNameProcess'=>$managementNameProcess])

                    </div>

                </div>

            </div>


        </section>
        <div class="limit-box fl-wrap"></div>
    </div>
    @include(  'cityBook.management.'.$managementNameProcess.'.partials.actions',['managementNameProcess'=>$managementNameProcess])
@endsection
@section('script')
    <script>
        var $frontend = true;
        var $cropObject = null;
        var $configPartialCurrentProcess = <?php echo json_encode($configPartial)?>;

    </script>
    <script src="{{ asset($resourcePathServer.'libs/vue-bootstrap/vue-bootstrap.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/uiv/uiv.min.js')}}"></script>



    @include( 'cityBook.management.'.$managementNameProcess.'.assets.js.index',['managementNameProcess'=>$managementNameProcess])
@endsection
@section('additional-styles')
    @include('cityBook.web.partials.businessPullkay.assets.css.grid-style',array())
    <style>
        .tab-content>.active {
            display: block !important;
        }
        .tab-content{
            display: block !important;

        }
    </style>
    <link href="{{ URL::asset($resourcePathServer.'assets/css/not-root/bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    @include('cityBook.management.'.$managementNameProcess.'.assets.css.index',['managementNameProcess'=>$managementNameProcess])


@endsection
