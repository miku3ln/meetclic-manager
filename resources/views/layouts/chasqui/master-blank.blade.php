<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <title>{{env('APP_NAME_FRONTEND')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{env('APP_NAME_FRONTEND_CONTENT')}}" name="description" />
    <meta content="{{env('APP_NAME_FRONTEND_AUTHOR')}}" name="author" />


    @include('layouts.frontend.head')
</head>

<body>

<!-- end of scroll to top -->
@yield('content')
@include('layouts.frontend.scripts')
</body>

</html>
