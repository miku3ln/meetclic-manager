<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8"/>
    <title>{{env('APP_NAME_FRONTEND')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{env('APP_NAME_FRONTEND_CONTENT')}}" name="description"/>
    <meta content="{{env('APP_NAME_FRONTEND_AUTHOR')}}" name="author"/>
    <style>
        .management--form button {

            background: #FACC39 !important;

            background-color: #FACC39;
            border-color: #FACC39;

        }

        .management--form button:hover {

            background: #445EF2 !important;

            background-color: #445EF2 !important;
            border-color:#445EF2 !important;

        }
    </style>

    @include('layouts.frontend.styles')
</head>

<body>

<!-- end of scroll to top -->
@yield('content')
@include('layouts.frontend.scripts')
</body>

</html>
