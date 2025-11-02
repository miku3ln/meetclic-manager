@php
    $resourcePathServer = env('APP_IS_SERVER') ? 'public/' : '';
    $dataManagerPage=[
        'public-root'=>URL::asset($resourcePathServer),
];
@endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel 12') }}</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <!-- jQuery (necesario si usas Bootgrid u otros plugins) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/jquery-bootgrid@1.3.1/dist/jquery.bootgrid.min.css" rel="stylesheet">
    @yield('additional-styles')

    <!-- Bootstrap JS Bundle (incluye Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-bootgrid@1.3.1/dist/jquery.bootgrid.min.js"></script>

    <script>

        var $dataManagerPage = <?php echo json_encode($dataManagerPage) ?>;
    </script>
    @yield('additional-scripts')

</head>
<body id="app-manager">
<div id="app">
    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
