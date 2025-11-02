

<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>

<div class="footer-area">
    <div class="footer-navigation-area">
        <div class="container wide">
            <div class="row">
                <div class="col-xl-4 col-custom-xl-6 col-lg-6">
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


                <div class="col-xl-8 col-custom-xl-6 col-lg-6">
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
                    @if(isset($dataFooter) )
                        @if(isset($dataFooter['socialNetwork']))
                            @if($dataFooter['socialNetwork']!='')
                                {{$dataFooter['socialNetwork']}}
                            @else
                                <div class="error-manager error-manager--warning">
                                    <h1 class="error-manager__title"> {{__('messages.empty')}}.<span
                                            class="error-manager__type-error">  {{__('messages.errors.warning')}}!.</span>
                                    </h1>
                                </div>
                            @endif
                        @else
                            <div class="error-manager error-manager--warning">
                                <h1 class="error-manager__title"> {{__('messages.manager-params.error')}}<span
                                        class="error-manager__type-error"> {{__('messages.errors.warning')}}!.</span>
                                </h1>
                            </div>
                        @endif
                    @else
                        <div class="error-manager error-manager--warning">
                            <h1 class="error-manager__title">{{__('messages.manager-params.error')}}.<span
                                    class="error-manager__type-error"> {{__('messages.errors.warning')}}!.</span></h1>
                        </div>
                    @endif

                    <div class="footer-payment-logo">
                        <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/icons/payments.png')}}" class="img-fluid"
                             alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-copyright-area">
        <div class="container wide">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright-text text-center">
                        {{env('APP_COPYRIGHT_FRONTEND_LEFT')}} {{date("Y")}} <a href='https://www.facebook.com/miGu3ln'>Meetclic</a>{{env('APP_COPYRIGHT_FRONTEND_RIGHT')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
