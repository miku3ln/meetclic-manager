<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>

<div class="footer-area">
    <div class="footer-navigation-area">
        <div class="container wide">
            <div class="row">
                <div class="col-xl-8 col-custom-xl-8 col-lg-8">

                    @include('layouts.partials.menu',['activeHome'=>$activeHome,
'activePages'=>$activePages,
'activeAboutUs'=>$activeAboutUs,
'activeContactUs'=>$activeContactUs,
'activeServices'=>$activeServices,
'activeShop'=>$activeShop,
'typeMenu'=>2,
'pageSectionsConfig'=>$pageSectionsConfig
])
                </div>
                <div class="col-xl-4 col-custom-xl-4 col-lg-4">

                    @if(env('allowBusinessOwner'))

                        <div class="row">
                            <div class="col-md-12">
                                @if(isset($dataFooter) )
                                    @if(isset($dataFooter['socialNetwork']))
                                        @if($dataFooter['socialNetwork']!='')
                                            {{$dataFooter['socialNetwork']}}
                                        @else

                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                @if(isset($dataManagerPage['shopConfig']['allow']))
                                    <h4 class="footer-widget__title">ACEPTAMOS ESTAS FORMAS DE PAGO-------</h4>
                                    <img src="{{ $dataManagerPage['shopConfig']['source']}}"
                                         class="img-fluid"
                                         alt="">
                                @else
                                    <div class="not-methods-payment">

                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        @if(env('allowSectionSubscribe'))
                            <div class="footer-widget footer-widget--two">
                                @if(isset($dataManagerPage['allowMessageDiscount']))
                                    <h4 class="footer-widget__title">10% OFF YOUR FIRST ORDER</h4>
                                @endif
                                <p class="footer-widget__text">{{__('messages.subscribe.join')}}</p>

                                <div class="newsletter-form-area">
                                    <form id="mc-form" class="mc-form">
                                        <div class="footer-widget__newsletter-form">
                                            <input type="email" placeholder="{{__('messages.subscribe.place-holder')}}"
                                                   required>
                                            <button type="submit">{{__('messages.subscribe.button')}}</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- mailchimp-alerts Start -->

                                <div class="mailchimp-alerts">
                                    <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                                    <div class="mailchimp-success"></div><!-- mailchimp-success end -->
                                    <div class="mailchimp-error"></div><!-- mailchimp-error end -->
                                </div><!-- mailchimp-alerts end -->

                            </div>
                        @endif
                        @if(isset($dataFooter) )
                            @if(isset($dataFooter['socialNetwork']))
                                @if($dataFooter['socialNetwork']!='')
                                    {{$dataFooter['socialNetwork']}}
                                @else

                                @endif
                            @endif
                        @endif
                        <div class="footer-payment-logo">
                            @if(isset($dataManagerPage['shopConfig']['allow']))

                                <img src="{{ $dataManagerPage['shopConfig']['source']}}"
                                     class="img-fluid"
                                     alt="">
                            @else
                                <div class="not-methods-payment">

                                </div>
                            @endif
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>

    <div class="footer-copyright-area">
        <div class="container wide">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright-text text-center">
                        {{env('APP_COPYRIGHT_FRONTEND_LEFT')}} {{date("Y")}}
                        <a target="_blank"  href='{{env('APP_COPYRIGHT_FRONTEND_LINK')}}'>{{env('APP_COPYRIGHT_FRONTEND_BUSINESS')}}</a>{{env('APP_COPYRIGHT_FRONTEND_RIGHT')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
