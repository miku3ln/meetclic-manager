<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{env('APP_NAME_BACKEND')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{env('APP_NAME_BACKEND_CONTENT')}}" name="description" />
    <meta content="{{env('APP_NAME_BACKEND_AUTHOR')}}" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    @include('layouts.minton.head')
    <style>
        .danger {
            color: red;
        }
    </style>
</head>

<body>
    @yield('content')
    @include('layouts.minton.scripts')
</body>

</html>
