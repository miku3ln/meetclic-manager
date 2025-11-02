<!--CMS-TEMPLATE-META-DATA-TEMPLATE -->

<meta charset="utf-8" id="manager-meta" class="manager-header">

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

        @elseif($dataManagerPage['currentPage'] == 'traductorPage'||$dataManagerPage['currentPage'] == 'diccionarioPage'||$dataManagerPage['currentPage'] == 'yachasunPage'||$dataManagerPage['currentPage'] == 'apuntesPage'||$dataManagerPage['currentPage'] == 'homeChaskiPage')
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
        @endif
    @endif
@endif
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta content="{{ env('APP_NAME_FRONTEND_AUTHOR') }}" name="author">
