@php
    $resourcePathServer = env('APP_IS_SERVER') ? 'public/' : '';
    $dataManagerPage=[
        'public-root'=>URL::asset($resourcePathServer),
];
$themePath = $resourcePathServer . 'templates/cityBookHtml/';


@endphp
@php
    $mcGamification =$gamificationDataTask;


    // Garantiza estructura para que NUNCA sea undefined
    $mcGamification = $mcGamification ;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link type="text/css" rel="stylesheet" href="{{ URL::asset($themePath.'css/plugins.css')}}">
    <!-- jQuery (necesario si usas Bootgrid u otros plugins) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/jquery-bootgrid@1.3.1/dist/jquery.bootgrid.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet"/>

    @yield('additional-styles')
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-bootgrid@1.3.1/dist/jquery.bootgrid.min.js"></script>

    <!-- Select2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <script src="https://malsup.github.io/jquery.blockUI.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.3.3/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.3.3/fonts/Roboto.min.js"
            referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.3.3/standard-fonts/Courier.min.js"
            referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.3.3/standard-fonts/Helvetica.min.js"
            referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.3.3/standard-fonts/Symbol.min.js"
            referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.3.3/standard-fonts/Times.min.js"
            referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.3.3/standard-fonts/ZapfDingbats.min.js"
            referrerpolicy="no-referrer"></script>
    @include('partials.toast-meetclic',["allowCss"=>true])
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: #e3e9ef !important;
        }

        .main-header {
            padding-top: 15px;
            padding-left: 2%;
            z-index: 15000;
            position: absolute;

        }

        img#main-header__logo {
            width: 117px;
        }

        .not-view {
            display: none;
        }
    </style>
    <script>
        var $gamification_result =@json($mcGamification);
        var $TASK_TOAST =@json($TASK_TOAST);


        window.GAMIFICATION_RESULT = $gamification_result;
        var $dataManagerPage = <?php echo json_encode($dataManagerPage) ?>;
    </script>

    @include('partials.toast-meetclic',["allowJs"=>true])
    <script>
        function showToast(message, type = "info", selector = null, position = 'right') {
            const toast = $("#appToast");
            const container = $("#toastContainer");
            const title = $("#toastTitle");
            const icon = $("#toastIcon");
            const body = $("#toastMessage");

            //-------------------------------------------------------
            // POSICIÓN
            //-------------------------------------------------------

            if (selector) {

                const target = $(selector);

                if (target.length) {

                    const offset = target.offset();

                    container.removeClass(
                        "position-fixed top-0 end-0 start-0 bottom-0"
                    );

                    container.css({
                        position: "absolute",
                        top: offset.top,
                        left: offset.left,
                        right: "auto",
                        bottom: "auto"
                    });

                }

            } else {

                container.attr(
                    "class",
                    "toast-container position-fixed top-0 end-0 p-3"
                );

                container.removeAttr("style");

                container.css({
                    zIndex: 99999
                });

            }

            //-------------------------------------------------------
            // COLORES
            //-------------------------------------------------------

            toast.removeClass(
                "text-bg-success text-bg-danger text-bg-warning text-bg-info"
            );

            icon.removeClass();

            switch (type) {

                case "success":

                    toast.addClass("text-bg-success");

                    title.text("Correcto");

                    icon.addClass("fa-solid fa-circle-check me-2");

                    break;

                case "error":

                    toast.addClass("text-bg-danger");

                    title.text("Error");

                    icon.addClass("fa-solid fa-circle-xmark me-2");

                    break;

                case "warning":

                    toast.addClass("text-bg-warning");

                    title.text("Advertencia");

                    icon.addClass("fa-solid fa-triangle-exclamation me-2");

                    break;

                default:

                    toast.addClass("text-bg-info");

                    title.text("Información");

                    icon.addClass("fa-solid fa-circle-info me-2");

            }

            body.text(message);

            bootstrap.Toast
                .getOrCreateInstance(
                    document.getElementById("appToast"),
                    {
                        delay: 14000
                    }
                )
                .show();
        }

        $(function () {
            if (false) {

                initToastLoad();
            }

        });
    </script>
    <meta property="og:title" content="Chasqui- Ñan by Meetclic">
    <meta property="og:description"
          content="Explora rutas dinámicas, tótems vivos y turismo aumentado en AR con MeetClic.">
    <meta property="og:image" content="{{ $dataManagerPage['public-root'] }}/simi-rura/header/meta.png" id="meta-image">
    <meta property="og:image:type" content="image/png">
    <meta property='og:image:width' content='400'/>
    <meta property='og:image:height' content='400'/>
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Chasqui- Ñan by Meetclic">
    <meta name="twitter:description"
          content="Explora rutas dinámicas, tótems vivos y turismo aumentado en AR con MeetClic.">
    <meta name="twitter:image" content="{{ $dataManagerPage['public-root'] }}/simi-rura/header/meta.png">
    @yield('additional-scripts')

</head>


<body id="app-manager">
@yield('content-navbar')
<main class="layout-content" id="app">
    <div class="container-fluid">
        @yield('content')

    </div>
</main>
@yield('content-modals')

<div id="toastContainer"
     class="toast-container position-fixed top-0 end-0 p-3"
     style="z-index:99999;">

    <div id="appToast"
         class="toast border-0"
         role="alert">

        <div class="toast-header">

            <i id="toastIcon"
               class="fa-solid fa-circle-info me-2"></i>

            <strong id="toastTitle" class="me-auto">
                Información
            </strong>

            <button class="btn-close"
                    data-bs-dismiss="toast">
            </button>

        </div>

        <div id="toastMessage"
             class="toast-body">
        </div>

    </div>

</div>
</body>
</html>
