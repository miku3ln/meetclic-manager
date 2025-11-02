@extends('layouts.cityBook')
@section('additional-styles')

    @include('partials.mangerVueCss')
    <style>
        .map-guests {
            height: 350px;
        }

        .floating-panel-manager {
            left: 3%;
        }
    </style>
    <link href="{{ asset($resourcePathServer."css/bootgridManager.css") }}" rel="stylesheet"
          type="text/css">
    <link href="{{ URL::asset($resourcePathServer.'css/bootstrapManager.css') }}" rel="stylesheet"
          type="text/css">
    @if($nameRoute == 'myProfile' )

        @include('cityBook.web.partials.profile.assets.css.myProfile')
    @elseif($nameRoute == 'password' )
        @include('cityBook.web.partials.profile.assets.css.password')
    @elseif($nameRoute == 'orders' )
        @include('cityBook.web.partials.profile.assets.css.orders')
        <style>
            .preview-management__people {
                border-top: 1px solid #dee2e6;
                border-bottom: 1px solid #dee2e6;
                padding-top: 2%;
                padding-bottom: 2%;
            }

            .management-data {
                height: 244px;
                overflow-y: scroll;
                overflow-x: hidden;
            }
        </style>
    @else
        @include('partials.plugins.resourcesCss',['bootgrid'=>true])
        @include('partials.plugins.resourcesCss',['select2'=>true])
    @endif
@endsection
@section('additional-scripts')

    @if($nameRoute == 'myProfile' )
        @include('partials.plugins.resourcesJs',['croppie'=>true])
        @include('partials.mangerVueJS',[])
    @elseif($nameRoute == 'password' )
        @include('partials.mangerVueJS',[])
    @elseif($nameRoute == 'orders' )
        @include('partials.mangerVueJS',[])
    @endif
    <script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>


    <script type="text/javascript">var pathDevelopers = '{{asset($resourcePathServer.'wulpy/developers')}}/';</script>
    <script type="text/javascript">var $resourcesCustom = '{{asset($resourcePathServer.'images')}}/';</script>
    <script>
        var $configPartial = <?php echo json_encode($configPartial) ?>;
        var $allowRoutes = '<?php echo env('allowRoutes') ?>';

        @if(env('allowAllInOne'))
        $(function () {
            $('.show-search-button').show();
        });
        @endif
    </script>


    @if($nameRoute == 'account' )
    @elseif($nameRoute == 'myProfile' )
        @include('cityBook.web.partials.profile.assets.js.myProfile')
    @elseif($nameRoute == 'suggestionsMailBox' )

    @elseif($nameRoute == 'password' )
        @include('cityBook.web.partials.profile.assets.js.password')
    @elseif($nameRoute == 'orders' )
        @include('cityBook.web.partials.profile.assets.js.orders')

    @elseif($nameRoute == 'bee' )


    @elseif($nameRoute == 'reviewsTo' )

    @elseif($nameRoute == 'listingsQueen' )

    @endif

@endsection
@section('content')
    @if($nameRoute == 'myProfile' )
        @include('cityBook.web.partials.profile.actions.myProfile')
    @elseif($nameRoute == 'password' )
        @include('cityBook.web.partials.profile.actions.password')
    @elseif($nameRoute == 'orders' )
        @include('cityBook.web.partials.profile.actions.orders')

    @endif
    <div id="app-management" class="container root-render-process-frontend">


        <section id="sec1">
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
                    <div class="col-md-9">
                        <b-form id="customerForm" v-on:submit.prevent="_submitForm">


                            @if($nameRoute == 'profileAccount' )
                                @include('cityBook.web.partials.profile.dashboard')
                            @elseif($nameRoute == 'myProfile' )
                                @include('cityBook.web.partials.profile.myProfile')
                            @elseif($nameRoute == 'suggestionsMailBox' )
                                @include('cityBook.web.partials.profile.suggestionsMailBox')
                            @elseif($nameRoute == 'password' )
                                @include('cityBook.web.partials.profile.password')
                            @elseif($nameRoute == 'bee' )
                                @include('cityBook.web.partials.profile.bee')
                            @elseif($nameRoute == 'reviewsTo' )
                                @include('cityBook.web.partials.profile.reviewsTo')
                            @elseif($nameRoute == 'listingsQueen' )
                                @include('cityBook.web.partials.profile.listings')

                            @elseif($nameRoute == 'orders' )
                                @include('cityBook.web.partials.profile.orders')
                            @endif
                        </b-form>
                    </div>
                </div>
            </div>
        </section>

        <div class="limit-box fl-wrap"></div>
        @if(!Auth::check())
            @include('layouts.partials.cityBook.join')
        @endif
    </div>

@endsection
