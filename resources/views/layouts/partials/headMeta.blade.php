<!--CMS-TEMPLATE-META-DATA-TEMPLATE -->

<meta charset="utf-8" id="manager-meta" class="manager-header" current-action="{{$dataManagerPage['currentPage']}}">

@php

        $dataPagesSections=[
            'homePage','shopBee','aboutUs','howItWorks','contactUs','ourServicesBee','pricesBee','listingsQueen','reviewsTo' ,'business','bee','password','suggestionsMailBox' ,'myProfile','account','businessDetails','search','authorSingle'
            , 'productDetails','checkout','cart','checkoutDetails','rewards','activities','productProducts','productFlowers' , 'productFrozen','productFruits','productBox'
            , 'FAQ','dictionaryType'
        ]
@endphp



@if (isset($pageSectionsConfig['head']) && $pageSectionsConfig['head']['metaData']['view'])
    {!! $pageSectionsConfig['head']['metaData']['html'] !!}

@else

    <meta id='condition-section' name="viewport" content="width=device-width, initial-scale=1">
    @if(isset($dataManagerPage))
        @if(in_array($dataManagerPage['currentPage'],$dataPagesSections))

        @endif

        @if($dataManagerPage['currentPage']=='home')

            <meta class="meta-not-customer__fb-app--id" name="fb:app_id" content="{{ env('facebook_client_id') }}">
            <meta class="meta-not-customer__article" name="og:type" content="article">
            @if (isset($pageSectionsConfig['head_custom']['business']))
                <title
                    class="meta-customer__title-page">{{ $pageSectionsConfig['head_custom']['business']['data']->title }}</title>
                <meta class="meta-customer__title" name='title'
                      content='{{ $pageSectionsConfig['head_custom']['business']['data']->title }}'>
                @if ($pageSectionsConfig['head_custom']['business']['data']->description != '')
                    <meta class="meta-customer__description" name='description'
                          content='{{ $pageSectionsConfig['head_custom']['business']['data']->description }}'>
                @else
                    <meta class="meta-not-customer__description" content="{{ env('APP_NAME_FRONTEND_CONTENT') }}"
                          name="description">
                @endif
                @if ($pageSectionsConfig['head_custom']['business']['data']->source != '')
                        <?php
                        $urlCurrentRoot = env('APP_IS_SERVER') ? 'public' : '';
                        $urlCurrentImage = asset($urlCurrentRoot . $pageSectionsConfig['head_custom']['business']['data']->source);
                        ?>
                    <meta class="meta-customer__image" property='og:image' content="{{ $urlCurrentImage }}">
                    <meta class="meta-customer__image-width" property='og:image:width' content='400'/>
                    <meta class="meta-customer__image-height" property='og:image:height' content='400'/>

                @else
                    <meta class="meta-not-customer__image" name="Meetclic"
                          content="https://pbs.twimg.com/profile_images/871923732322955265/ShymgkzC.jpg">
                    <meta class="meta-not-customer__image-2" property='og:image'
                          content='https://pbs.twimg.com/profile_images/871923732322955265/ShymgkzC.jpg'>
                    <meta class="meta-not-customer__image-width" property='og:image:width' content='400'>
                    <meta class="meta-not-customer__image-height" property='og:image:height' content='400'>

                @endif
                <meta class="meta-customer__image-alt" property='og:image:alt'
                      content='{{ $pageSectionsConfig['head_custom']['business']['data']->title }}'/>
                <meta class="meta-customer__site-name" name="og:site_name"
                      content="{{ $pageSectionsConfig['head_custom']['business']['data']->title }}">

            @elseif(isset($pageSectionsConfig['head']['business'])&&$pageSectionsConfig['head']['business']['view'] )
                <title
                    class="meta-customer__title-page">{{ $pageSectionsConfig['head']['business']['data']->title }}</title>
                <meta class="meta-customer__title" name='title'
                      content='{{ $pageSectionsConfig['head']['business']['data']->title }}'>
                @if ($pageSectionsConfig['head']['business']['data']->description != '')
                    <meta class="meta-customer__description" name='description'
                          content='{{ $pageSectionsConfig['head']['business']['data']->description }}'>
                @else
                    <meta class="meta-not-customer__description" content="{{ env('APP_NAME_FRONTEND_CONTENT') }}"
                          name="description">
                @endif
                @if ($pageSectionsConfig['head']['business']['data']->source != '')
                        <?php
                        $urlCurrentRoot = env('APP_IS_SERVER') ? 'public' : '';
                        $urlCurrentImage = asset($urlCurrentRoot . $pageSectionsConfig['head']['business']['data']->source);
                        ?>
                    <meta class="meta-customer__image" property='og:image' content="{{ $urlCurrentImage }}">
                    <meta class="meta-customer__image-width" property='og:image:width' content='400'/>
                    <meta class="meta-customer__image-height" property='og:image:height' content='400'/>

                @else
                    <meta class="meta-not-customer__image" name="Meetclic"
                          content="https://pbs.twimg.com/profile_images/871923732322955265/ShymgkzC.jpg">
                    <meta class="meta-not-customer__image-2" property='og:image'
                          content='https://pbs.twimg.com/profile_images/871923732322955265/ShymgkzC.jpg'>
                    <meta class="meta-not-customer__image-width" property='og:image:width' content='400'>
                    <meta class="meta-not-customer__image-height" property='og:image:height' content='400'>

                @endif
                <meta class="meta-customer__image-alt" property='og:image:alt'
                      content='{{ $pageSectionsConfig['head']['business']['data']->title }}'/>
                <meta class="meta-customer__site-name" name="og:site_name"
                      content="{{ $pageSectionsConfig['head']['business']['data']->title }}">

            @else
                <meta class="meta-not-customer__site-name" name="og:site_name" content="{{ env('APP_NAME_FRONTEND') }}">
                <meta class="meta-not-customer__title" name='title' content='{{ env('APP_NAME_FRONTEND') }}'>
                <title class="meta-not-customer__title-page">{{ env('APP_NAME_FRONTEND') }}</title>

            @endif

        @elseif($dataManagerPage['currentPage'] == 'authorSingle')
            <title>{{ $dataManagerPage['authorSingleData']['information']['title'] }}</title>
            <meta name='description' content='Tarjeta de Presentacion-Meetclic'>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta property='og:url'
                  content='{{ $dataManagerPage['authorSingleData']['information']['urlManagerRoot']}}'>
            <meta class="meta-customer__image" property='og:image'
                  content="{{ $dataManagerPage['authorSingleData']['information']['source'] }}">
            <meta class="meta-customer__image-width" property='og:image:width' content='400'/>
            <meta class="meta-customer__image-height" property='og:image:height' content='400'/>
            <meta class="meta-customer__image-alt" property='og:image:alt'
                  content='{{ $dataManagerPage['authorSingleData']['information']['title'] }}'/>
            <meta content='{{ $dataManagerPage['authorSingleData']['information']['descriptionData'] }}'/>

            <meta name="twitter:card" content="summary_large_image">
            <meta property="twitter:domain"
                  content="{{ $dataManagerPage['authorSingleData']['information']['urlManagerRoot']}}">
            <meta property="twitter:url"
                  content="{{ $dataManagerPage['authorSingleData']['information']['urlManager']}}">
            <meta name="twitter:title" content="{{ $dataManagerPage['authorSingleData']['information']['title'] }}">
            <meta name="twitter:description"
                  content="{{ $dataManagerPage['authorSingleData']['information']['descriptionData'] }}">
            <meta name="twitter:image" content="{{ $dataManagerPage['authorSingleData']['information']['source'] }}">
            <meta name="fb:app_id" content="{{ env('facebook_client_id') }}">
            <meta name="og:type" content="article">

        @elseif($dataManagerPage['currentPage'] == 'dictionaryType')
            <title>{{ $dataManagerPage['dictionaryTypeData']['information']['title'] }}</title>
            <meta name='description' content='Diccionarios'>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta property='og:url'
                  content='{{ $dataManagerPage['dictionaryTypeData']['information']['urlManagerRoot']}}'>
            <meta class="meta-customer__image" property='og:image'
                  content="{{ $dataManagerPage['dictionaryTypeData']['information']['source'] }}">
            <meta class="meta-customer__image-width" property='og:image:width' content='400'/>
            <meta class="meta-customer__image-height" property='og:image:height' content='400'/>
            <meta class="meta-customer__image-alt" property='og:image:alt'
                  content='{{ $dataManagerPage['dictionaryTypeData']['information']['title'] }}'/>
            <meta content='{{ $dataManagerPage['dictionaryTypeData']['information']['descriptionData'] }}'/>
            <meta name="twitter:card" content="summary_large_image">
            <meta property="twitter:domain"
                  content="{{ $dataManagerPage['dictionaryTypeData']['information']['urlManagerRoot']}}">
            <meta property="twitter:url"
                  content="{{ $dataManagerPage['dictionaryTypeData']['information']['urlManager']}}">
            <meta name="twitter:title" content="{{ $dataManagerPage['dictionaryTypeData']['information']['title'] }}">
            <meta name="twitter:description"
                  content="{{ $dataManagerPage['dictionaryTypeData']['information']['descriptionData'] }}">
            <meta name="twitter:image" content="{{ $dataManagerPage['dictionaryTypeData']['information']['source'] }}">
            <meta name="fb:app_id" content="{{ env('facebook_client_id') }}">
            <meta name="og:type" content="article">

        @elseif($dataManagerPage['currentPage'] == 'traductorPage'||$dataManagerPage['currentPage'] == 'diccionarioPage'||$dataManagerPage['currentPage'] == 'yachasunPage'||$dataManagerPage['currentPage'] == 'apuntesPage'||$dataManagerPage['currentPage'] == 'ricksichishun')
            <title>{{ $dataManagerPage['dictionaryTypeData']['information']['title'] }}</title>
            <meta name='description' content='Diccionarios'>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta property='og:url'
                  content='{{ $dataManagerPage['dictionaryTypeData']['information']['urlManagerRoot']}}'>
            <meta class="meta-customer__image" property='og:image'
                  content="{{ $dataManagerPage['dictionaryTypeData']['information']['source'] }}">
            <meta class="meta-customer__image-width" property='og:image:width' content='400'/>
            <meta class="meta-customer__image-height" property='og:image:height' content='400'/>
            <meta class="meta-customer__image-alt" property='og:image:alt'
                  content='{{ $dataManagerPage['dictionaryTypeData']['information']['title'] }}'/>
            <meta content='{{ $dataManagerPage['dictionaryTypeData']['information']['descriptionData'] }}'/>
            <meta name="twitter:card" content="summary_large_image">
            <meta property="twitter:domain"
                  content="{{ $dataManagerPage['dictionaryTypeData']['information']['urlManagerRoot']}}">
            <meta property="twitter:url"
                  content="{{ $dataManagerPage['dictionaryTypeData']['information']['urlManager']}}">
            <meta name="twitter:title" content="{{ $dataManagerPage['dictionaryTypeData']['information']['title'] }}">
            <meta name="twitter:description"
                  content="{{ $dataManagerPage['dictionaryTypeData']['information']['descriptionData'] }}">
            <meta name="twitter:image" content="{{ $dataManagerPage['dictionaryTypeData']['information']['source'] }}">
            <meta name="fb:app_id" content="{{ env('facebook_client_id') }}">
            <meta name="og:type" content="article">

        @elseif($dataManagerPage['currentPage'] == 'homeBackLinePage')
            <title>{{ $dataManagerPage['dictionaryTypeData']['information']['title'] }} </title>
            <meta name='description'
                  content='{{ $dataManagerPage['dictionaryTypeData']['information']['descriptionData'] }}'>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta property='og:url'
                  content='{{ $dataManagerPage['dictionaryTypeData']['information']['urlManagerRoot']}}'>
            <meta class="meta-customer__image" property='og:image'
                  content="{{ $dataManagerPage['dictionaryTypeData']['information']['source'] }}">
            <meta class="meta-customer__image-width" property='og:image:width' content='400'/>
            <meta class="meta-customer__image-height" property='og:image:height' content='400'/>
            <meta class="meta-customer__image-alt" property='og:image:alt'
                  content='{{ $dataManagerPage['dictionaryTypeData']['information']['title'] }}'/>
            <meta content='{{ $dataManagerPage['dictionaryTypeData']['information']['descriptionData'] }}'/>
            <meta name="twitter:card" content="summary_large_image">
            <meta property="twitter:domain"
                  content="{{ $dataManagerPage['dictionaryTypeData']['information']['urlManagerRoot']}}">
            <meta property="twitter:url"
                  content="{{ $dataManagerPage['dictionaryTypeData']['information']['urlManager']}}">
            <meta name="twitter:title" content="{{ $dataManagerPage['dictionaryTypeData']['information']['title'] }}">
            <meta name="twitter:description"
                  content="{{ $dataManagerPage['dictionaryTypeData']['information']['descriptionData'] }}">
            <meta name="twitter:image" content="{{ $dataManagerPage['dictionaryTypeData']['information']['source'] }}">
            <meta name="fb:app_id" content="{{ env('facebook_client_id') }}">
            <meta name="og:type" content="article">

        @elseif($dataManagerPage['currentPage'] == 'shopPage')
            @php

                $dataBusinessInformation = $dataManagerPage["dataBusinessInformation"]["business"];

                $businessInformation = count($dataBusinessInformation) > 0
                    ? $dataBusinessInformation[0]
                    : null;

                $businessTitle = $businessInformation["title"] ?? "MeetClic";

                $businessDescription = $businessInformation["description"] ?? "Menú digital";



                $businessUrl = url('/es/shop/business/' . $businessInformation["id"]);
                $urlCurrentRoot = env('APP_IS_SERVER') ? 'public' : '';
                        $businessImage = asset($urlCurrentRoot . $businessInformation["source"]);
            @endphp


                <!-- ========================================================= -->
            <!-- BASIC SEO -->
            <!-- ========================================================= -->

            <title>
                {{$businessTitle}} | Menú Digital y Delivery
            </title>

            <meta charset="utf-8">

            <meta
                name="viewport"
                content="width=device-width, initial-scale=1"
            >

            <meta
                name="description"
                content="{{$businessDescription}}"
            >

            <meta
                name="keywords"
                content="
    {{$businessTitle}},
    MeetClic,
    menú digital,
    menú online,
    delivery,
    pedidos online,
    restaurante,
    ecommerce gastronómico,
    comida rápida,
    promociones,
    Yapitas,
    gamificación,
    recompensas,
    cashback,
    menú QR,
    pedidos a domicilio,
    delivery gamificado
    "
            >

            <meta
                name="robots"
                content="index, follow"
            >

            <meta
                name="author"
                content="{{$businessTitle}}"
            >

            <meta
                name="theme-color"
                content="#445EF2"
            >

            <link
                rel="canonical"
                href="{{$businessUrl}}"
            >


            <!-- ========================================================= -->
            <!-- OPEN GRAPH / FACEBOOK / WHATSAPP -->
            <!-- ========================================================= -->

            <meta
                property="og:type"
                content="website"
            >

            <meta
                property="og:site_name"
                content="MeetClic"
            >

            <meta
                property="og:title"
                content="{{$businessTitle}} | Menú Digital"
            >

            <meta
                property="og:description"
                content="{{$businessDescription}}"
            >

            <meta
                property="og:url"
                content="{{$businessUrl}}"
            >

            <meta
                property="og:image"
                content="{{$businessImage}}"
            >

            <meta
                property="og:image:width"
                content="1200"
            >

            <meta
                property="og:image:height"
                content="630"
            >

            <meta
                property="og:image:alt"
                content="{{$businessTitle}} menú digital"
            >

            <meta
                property="og:locale"
                content="es_EC"
            >

            <meta
                property="fb:app_id"
                content="{{ env('facebook_client_id') }}"
            >


            <!-- ========================================================= -->
            <!-- TWITTER / X -->
            <!-- ========================================================= -->

            <meta
                name="twitter:card"
                content="summary_large_image"
            >

            <meta
                name="twitter:title"
                content="{{$businessTitle}} | Menú Digital"
            >

            <meta
                name="twitter:description"
                content="{{$businessDescription}}"
            >

            <meta
                name="twitter:image"
                content="{{$businessImage}}"
            >

            <meta
                name="twitter:url"
                content="{{$businessUrl}}"
            >


            <!-- ========================================================= -->
            <!-- MOBILE / PWA -->
            <!-- ========================================================= -->

            <meta
                name="apple-mobile-web-app-capable"
                content="yes"
            >

            <meta
                name="apple-mobile-web-app-status-bar-style"
                content="black-translucent"
            >

            <meta
                name="apple-mobile-web-app-title"
                content="{{$businessTitle}}"
            >

            <meta
                name="mobile-web-app-capable"
                content="yes"
            >


            <!-- ========================================================= -->
            <!-- ICON -->
            <!-- ========================================================= -->

            <link
                rel="icon"
                type="image/png"
                href="{{$businessImage}}"
            >


        @endif
    @endif
@endif
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta content="{{ env('APP_NAME_FRONTEND_AUTHOR') }}" name="author">
