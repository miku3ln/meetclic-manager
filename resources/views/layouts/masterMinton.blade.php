
<!-- BUSINESS-MANAGER-TEMPLATE-INDEX -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>{{env('APP_NAME_BACKEND')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{env('APP_NAME_BACKEND_CONTENT')}}" name="description"/>
    <meta content="{{env('APP_NAME_BACKEND_AUTHOR')}}" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.minton.styles')

</head>

<body>


<div id="preloader">
    <div id="status">
        <div class="bouncingLoader">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>


<div id="wrapper">

    @include('layouts.minton.header')
    @include('layouts.minton.sidebar')

    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">

                @yield('breadcrumb')
                @yield('content')
            </div>
        </div>

        @include('layouts.minton.footer')
    </div>
</div>

@include('layouts.minton.rightbar')

@include('layouts.minton.scripts')


</body>

</html>
