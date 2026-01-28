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
    <div id="app-management">

        <section id="sec2">
            <div class="container">
                COMMING SOON
            </div>
        </section>

        <!-- section end -->
        <!--section -->
        @if(!Auth::check())
            @include('layouts.partials.cityBook.join')
        @endif
        <div class="limit-box"></div>

    </div>
@endsection
