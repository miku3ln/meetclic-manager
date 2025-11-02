@extends('layouts.cityBook')
@section('additional-styles')

@endsection
@section('additional-scripts')

    <script>
        $(function () {

            $('.show-search-button').show();
        })
    </script>
@endsection
@section('content')
    <div id="app-management" class="container">

        <!--section -->
        <section id="sec1">
            <!-- container -->

            <!-- profile-edit-wrap -->
            <div class="profile-edit-wrap">
                <div class="profile-edit-page-header">
                    <h2>Tienda</h2>
                    <div class="breadcrumbs"><a href="#">Inicio</a><span>Tienda</span></div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="fixed-bar fl-wrap">
                            <div class="user-profile-menu-wrap fl-wrap">
                                <div class="user-profile-menu">

                                    <ul class="menu-manager-categories">

                                        @foreach ($dataManagerPage['categories'] as $row)
                                            <li class="menu-manager-categories__li" id="category-{{$row->id}}">
                                                <a class="menu-manager-categories__a"><i class=""></i>{{$row->value}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        PRODUCTS/SERVICES
                    </div>


                </div>
            </div>
            <!--profile-edit-wrap end -->

            <!--container end -->
        </section>
        <!-- section end -->
        <div class="limit-box fl-wrap"></div>
        @if(!Auth::check())
            @include('layouts.partials.cityBook.join')
        @endif
    </div>



@endsection
