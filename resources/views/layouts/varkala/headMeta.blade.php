
<meta charset="utf-8">

@if (isset($pageSectionsConfig['head']) && $pageSectionsConfig['head']['metaData']['view'])
    {!! $pageSectionsConfig['head']['metaData']['html'] !!}
@else

    <meta class="meta-not-customer__view-port" name="viewport" content="width=device-width, initial-scale=1">
    <meta class="meta-not-customer__fb-app--id" name="fb:app_id" content="{{ env('facebook_client_id') }}">
    <meta class="meta-not-customer__article" name="og:type" content="article">
    @if (isset($pageSectionsConfig['head_custom']['business']))
        <title class="meta-customer__title-page">{{ $pageSectionsConfig['head_custom']['business']['data']->title }}</title>
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
            <meta class="meta-customer__image-width" property='og:image:width' content='400' />
            <meta class="meta-customer__image-height" property='og:image:height' content='400' />

        @else
            <meta class="meta-not-customer__image" name="Meetclic"
                content="https://pbs.twimg.com/profile_images/871923732322955265/ShymgkzC.jpg">
            <meta class="meta-not-customer__image-2" property='og:image'
                content='https://pbs.twimg.com/profile_images/871923732322955265/ShymgkzC.jpg'>
            <meta class="meta-not-customer__image-width" property='og:image:width' content='400'>
            <meta class="meta-not-customer__image-height" property='og:image:height' content='400'>
        @endif

        <meta class="meta-customer__image-alt" property='og:image:alt'
            content='{{ $pageSectionsConfig['head_custom']['business']['data']->title }}' />
        <meta class="meta-customer__site-name" name="og:site_name"
            content="{{ $pageSectionsConfig['head_custom']['business']['data']->title }}">


    @elseif(isset($pageSectionsConfig['head']['business'])&&$pageSectionsConfig['head']['business']['view'] )
        <title class="meta-customer__title-page">{{ $pageSectionsConfig['head']['business']['data']->title }}</title>
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
            <meta class="meta-customer__image-width" property='og:image:width' content='400' />
            <meta class="meta-customer__image-height" property='og:image:height' content='400' />

        @else
            <meta class="meta-not-customer__image" name="Meetclic"
                content="https://pbs.twimg.com/profile_images/871923732322955265/ShymgkzC.jpg">
            <meta class="meta-not-customer__image-2" property='og:image'
                content='https://pbs.twimg.com/profile_images/871923732322955265/ShymgkzC.jpg'>
            <meta class="meta-not-customer__image-width" property='og:image:width' content='400'>
            <meta class="meta-not-customer__image-height" property='og:image:height' content='400'>

        @endif

        <meta class="meta-customer__image-alt" property='og:image:alt'
            content='{{ $pageSectionsConfig['head']['business']['data']->title }}' />
        <meta class="meta-customer__site-name" name="og:site_name"
            content="{{ $pageSectionsConfig['head']['business']['data']->title }}">

    @else
        <meta class="meta-not-customer__site-name" name="og:site_name" content="{{ env('APP_NAME_FRONTEND') }}">
        <meta class="meta-not-customer__title" name='title' content='{{ env('APP_NAME_FRONTEND') }}'>
        <title class="meta-not-customer__title-page">{{ env('APP_NAME_FRONTEND') }}</title>

    @endif


@endif
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta content="{{ env('APP_NAME_FRONTEND_AUTHOR') }}" name="author">
