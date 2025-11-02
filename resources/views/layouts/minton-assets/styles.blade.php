<!-- BUSINESS-MANAGER-TEMPLATE-STYLES -->
<?php

$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$urlSource = $resourcePathServer;
?>
<style>
    :root {
        --url-source: '{{ URL::asset($urlSource)}}';
    }
</style>
<link rel="shortcut icon" href="{{ URL::asset($resourcePathServer.'assets/images/favicon.ico') }}">

@yield('css')
@yield('additional-styles')
@if($type==0)

    <!-- App css -->
    <link href="{{ URL::asset($resourcePathServer.'css/developers.css') }}" rel="stylesheet" type="text/css"/>
    <link
        href="{{ URL::asset($resourcePathServer.(env('APP_IS_SERVER')?'assets/css/root/icons.min.css':'assets/css/not-root/icons.min.css')) }}"
        rel="stylesheet" type="text/css"/>
@elseif($type==1)
    <!-- App css -->
    <link
        href="{{ URL::asset($resourcePathServer.(env('APP_IS_SERVER')?'assets/css/root/icons.min.css':'assets/css/not-root/icons.min.css')) }}"
        rel="stylesheet" type="text/css"/>

    <link href="{{ asset($resourcePathServer.'fonts/font-awesome-5.11.2/css/all.css') }}" rel="stylesheet"
          type="text/css"/>
@elseif($type==2)

    <!-- App css -->
    <link
        href="{{ URL::asset($resourcePathServer.(env('APP_IS_SERVER')?'assets/css/root/icons.min.css':'assets/css/not-root/icons.min.css')) }}"
        rel="stylesheet" type="text/css"/>

    <link href="{{ asset($resourcePathServer.'fonts/font-awesome-5.11.2/css/all.css') }}" rel="stylesheet"
          type="text/css"/>
@endif
@if(isset($allowPlugins) && isset($allowPlugins['bootstrap5']) && $allowPlugins['bootstrap5'])
    <link href="{{ URL::asset($resourcePathServer.'templates/minton/assets/css/bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::asset($resourcePathServer.'templates/minton/assets/css/app.min.css') }}" rel="stylesheet"
          type="text/css"/>
@else
    <link href="{{ URL::asset($resourcePathServer.'assets/css/not-root/bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
@endif


<link
    href="{{ URL::asset($resourcePathServer.(env('APP_IS_SERVER')?'assets/css/root/app.min.css':'assets/css/not-root/app.min.css')) }}"
    rel="stylesheet" type="text/css"/>

<link href="{{ URL::asset($resourcePathServer."assets/libs/jquery-toast/jquery-toast.min.css") }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ URL::asset($resourcePathServer.'libs/customscrollbar/customscrollbar.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ URL::asset($resourcePathServer.'libs/jquery-select2/jquery-select2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset($resourcePathServer.'css/custom.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset($resourcePathServer.'css/forms.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset($resourcePathServer.'css/frontend/backend/Custom.css') }}" rel="stylesheet" type="text/css"/>

<style>


    .content-name-business {
        font-size: 30px;
        font-weight: 500;
        color: #fff;
    }

    .not-view {
        display: none;
    }
</style>

@yield('additional-libs-styles')
