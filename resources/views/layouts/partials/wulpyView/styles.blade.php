
<head>

    <?php
    $resourcePathServer=env('APP_IS_SERVER')?"public/":'';

    $description = "";
    $routeId = null;
    $title = "No existe informacion.";
    $imageCurrent = asset('logo.png');
    $keywords='Turismo,Rutas,Atractivos Turisticos,Geo Rutas.';
    if ($method == "routeView") {

        if (isset($data["information"]) && !empty($data["information"])) {

            $title = env('APP_NAME').' - '.$data["information"]["name"];
            $description = $data["information"]["description"];
            $routeId = $parameters["id"];
            $imageCurrent = asset( $data["information"]["src"]);


        }


    }
    $urlSet = url('/routeView') . "/" . $routeId;

    ?>
    <meta charset="utf-8"/>
    <title>  {{$title}}</title>
    <meta name="keywords" content="{{$keywords}}"/>
    <meta name="Author" content="Migu3ln [https://www.facebook.com/miGu3ln]"/>
    <meta name="department" content="tourism"/>
    <meta name="audience" content="all"/>
    <meta name="doc_status" content="draft"/>

    <meta property="og:url" content="{{$urlSet}}"/>
    <meta property="og:type" content="noticias"/>
    <meta property="og:title" content="{{$title}}"/>
    <meta property="og:description" content="{{$description}}"/>
    <meta property="og:image" content="{{ $imageCurrent}}"/>
    <meta property="og:image:width" content="400"/>
    <meta property="og:image:height" content="300"/>
    <meta property="og:image:alt" content="Busca ,Encuentra y Sigue tu ñan.!"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- mobile settings -->
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0"/>
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

    <!-- WEB FONTS : use %7C instead of | (pipe) -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400%7CRaleway:300,400,500,600,700%7CLato:300,400,400italic,600,700"
          rel="stylesheet" type="text/css"/>

    <!-- Add Bootstrap and Bootstrap-Vue CSS to the <head> section -->
    <link type="text/css" rel="stylesheet" href="{{ asset($resourcePathServer.'plugins/vue-bootstrap/bootstrap.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset($resourcePathServer.'plugins/vue-bootstrap/bootstrap-vue.min.css')}}"/>
    {{--BOOTGRID--}}
    <link type="text/css" rel="stylesheet" href="{{ asset($resourcePathServer.'plugins/bootgrid1.3.1/jquery.bootgrid.css')}}"/>
    <!-- CORE CSS -->
    <link href="{{ asset($resourcePathServer.'wulpy/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- REVOLUTION SLIDER -->
    <link href="{{ asset($resourcePathServer.'wulpy/assets/plugins/slider.revolution/css/extralayers.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset($resourcePathServer.'wulpy/assets/plugins/slider.revolution/css/settings.css')}}" rel="stylesheet"
          type="text/css"/>

    <!-- THEME CSS -->
    <link href="{{ asset($resourcePathServer.'wulpy/assets/css/essentials.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset($resourcePathServer.'wulpy/assets/css/layout.css')}}" rel="stylesheet" type="text/css"/>

    <!-- PAGE LEVEL SCRIPTS -->
    <link href="{{ asset($resourcePathServer.'wulpy/assets/css/header-1.css')}}" rel="stylesheet" type="text/css"/>
    <!-------FIREBAS-------------->
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <!--begin::Page Vendors -->
    <!--end::Page Vendors -->
    <link href="{{ asset($resourcePathServer.'metronic/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset($resourcePathServer.'metronic/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset($resourcePathServer.'css/custom.css') }}" rel="stylesheet" type="text/css"/>
    <!--end::Base Styles -->
    @yield('styles')
</head>
