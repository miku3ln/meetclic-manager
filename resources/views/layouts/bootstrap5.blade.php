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

    <meta property="og:title" content="Chasqui- Ñan by Meetclic">
    <meta property="og:description" content="Explora rutas dinámicas, tótems vivos y turismo aumentado en AR con MeetClic.">
    <meta property="og:image" content="{{ $dataManagerPage['public-root'] }}/simi-rura/header/meta.png">
    <meta property="og:image:type" content="image/png">
    <meta property='og:image:width' content='400'/>
    <meta property='og:image:height' content='400'/>
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Chasqui- Ñan by Meetclic">
    <meta name="twitter:description" content="Explora rutas dinámicas, tótems vivos y turismo aumentado en AR con MeetClic.">
    <meta name="twitter:image" content="{{ $dataManagerPage['public-root'] }}/simi-rura/header/meta.png">
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
