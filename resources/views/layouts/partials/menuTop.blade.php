<?php
$pageSectionsConfigSet=[];
$dataManagerPageSet=[];

if(isset($pageSectionsConfig)){
    $pageSectionsConfigSet=$pageSectionsConfig;
}
if(isset($dataManagerPage)){
    $dataManagerPageSet=$dataManagerPage;
}
?>

<div class="{{$classTop}}">

    <!--=======  header navigation wrapper  =======-->
    <div class="header-navigation-top">
        <div class="container wide">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-12">

                    <div class="header-top-content-wrapper justify-content-center justify-content-lg-start">
                        @if(isset($pageSectionsConfigSet['contactTop']['language']['view']))
                            {!!$dataManagerPageSet['languageHeader']['menuLanguage']!!}
                        @endif
                        @include('layouts.partials.contact-header',
[
'typeMenu'=>1,
'pageSectionsConfig'=>$pageSectionsConfigSet
])
                    </div>

                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="header-top-content-wrapper justify-content-end">
                        @if(env('allowSectionOutlets'))

                            <div class="header-contact-info-wrapper ">
                                <ul class="header-contact-info__list">
                                    <li class="header-contact-info__outlets-content">
                                        <a id="header-contact-info__outlets-link"
                                           href="{{  route('shopOutlets', app()->getLocale()) }}">
                                            <img
                                                src="{{ URL::asset($resourcePathServer.'templates/business/arquitechos/images/button-one.png')}}"

                                            >

                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                        @if(isset($pageSectionsConfigSet['business']['view']))
                            <div class="header-top-dropdown border-left-0">
                                <a class="header-top__phone"
                                   href="tel://+{{$pageSectionsConfigSet['business']['data']->phone_code.$pageSectionsConfigSet['business']['data']->phone_value}}">Compra por <i
                                        class="fa fa-whatsapp"></i> +{{$pageSectionsConfigSet['business']['data']->phone_code.$pageSectionsConfigSet['business']['data']->phone_value}}
                                </a>

                            </div>

                        @endif

                    </div>
                </div>
                <div class="col-lg-2 d-none d-lg-block d-how-buy-content">
                    <div class="header-top-content-wrapper justify-content-end">
                        <div class="header-contact-info-wrapper ">
                            <ul class="header-contact-info__list">
                                <li class="header-contact-info__how-buy"><a id="how-buy-link"
                                                                            class="text-data-how-buy ">¿Como
                                        Comprar?</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-navigation-area header-navigation-area--extra-space d-none d-lg-block">
        <div class="container wide">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-info-wrapper header-info-wrapper--alt-style">

                        <div class="header-logo">
                            <a href="{{URL(app()->getLocale().'/')}}">
                                @if(isset($dataManagerPageSet['logoMain']))
                                    {{$dataManagerPageSet['logoMain']}}
                                @else
                                    @if($nameRoute=='home')
                                        @if(env('allowBusinessOwner'))
                                            <img id="img-first-empty"
                                                 src="{{ URL::asset($resourcePathServer.'templates/business/arquitechos/images/logo.png')}}"
                                                 class="img-fluid"
                                                 alt="">
                                            <img id="img-second-empty"
                                                 src="{{ URL::asset($resourcePathServer.'templates/business/arquitechos/images/logo.png')}}"
                                                 class="img-fluid"
                                                 alt="">
                                        @else
                                            <img id="img-first-empty"
                                                 src="{{ URL::asset($resourcePathServer.'frontend/assets/img/logo.png')}}"
                                                 class="img-fluid"
                                                 alt="">
                                            <img id="img-second-empty"
                                                 src="{{ URL::asset($resourcePathServer.'frontend/assets/img/logo.png')}}"
                                                 class="img-fluid"
                                                 alt="">
                                        @endif
                                    @else

                                        @if(env('allowBusinessOwner'))

                                            <img id="img-first-empty"
                                                 src="{{ URL::asset($resourcePathServer.'templates/business/arquitechos/images/logo.png')}}"
                                                 class="img-fluid"
                                                 alt="">
                                        @else

                                            <img id="img-first-empty"
                                                 src="{{ URL::asset($resourcePathServer.'frontend/assets/img/logo.png')}}"
                                                 class="img-fluid"
                                                 alt="">
                                        @endif

                                    @endif
                                @endif
                            </a>
                        </div>

                        <div class="header-navigation-wrapper">
                            <nav>
                                @include('layouts.partials.menu',
['activeHome'=>$activeHome,
'activePages'=>$activePages,
'activeAboutUs'=>$activeAboutUs,
'activeContactUs'=>$activeContactUs,
'activeServices'=>$activeServices,
'activeShop'=>$activeShop,
'activeActivities'=>$activeActivities,
'activeRewards'=>$activeRewards,

'typeMenu'=>1,
'pageSectionsConfig'=>$pageSectionsConfigSet
])

                            </nav>
                        </div>
                        @include('layouts.frontend.header-icon-area',['dataManagerPage'=>$dataManagerPageSet,
'pageSectionsConfig'=>$pageSectionsConfigSet])
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-mobile-navigation d-block d-lg-none">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6 col-md-6">
                    <div class="header-logo">
                        <a href="{{URL(app()->getLocale().'/')}}">
                            @if(isset($dataManagerPageSet['logoMainMobile']))
                                {{$dataManagerPageSet['logoMainMobile']}}
                            @else

                                @if(env('allowBusinessOwner'))
                                    <img
                                        src="{{ URL::asset($resourcePathServer.'templates/business/arquitechos/images/logo.png')}}"
                                        class="img-fluid" alt="">
                                @else

                                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/logo.png')}}"
                                         class="img-fluid" alt="">
                                @endif

                            @endif
                        </a>
                    </div>
                </div>


                <div class="col-6 col-md-6">
                    <div class="mobile-navigation text-right">
                        <ul class="header-icon__list header-icon__list">

                            @if(isset($dataManagerPageSet['shopConfig']['allow']))
                                @include('layouts.partials.shop.cart',array('typeManagerButton'=>2))

                            @endif
                            <li><a href="javascript:void(0)" class="mobile-menu-icon"
                                   id="mobile-menu-trigger"><i
                                        class="fa fa-bars"></i></a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--=======  End of mobile navigation area  =======-->
</div>
