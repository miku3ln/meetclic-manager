<?php

$urlShop="";


$htmlLinkRate = "";

if (isset($dataManagerPage["dataConfigGamificationBusiness"]["AYNI_YACHAY_SHOP_WEB_MC"])&&$dataManagerPage["dataConfigGamificationBusiness"]["AYNI_YACHAY_SHOP_WEB_MC"]["success"]) {
    $urlShop = $dataManagerPage["dataConfigGamificationBusiness"]["AYNI_YACHAY_SHOP_WEB_MC"]["data"]->url_manager;

} else {
    $urlShop = $dataManagerPage["dataConfigGamificationBusiness"]["AYNI_YACHAY_SHOP_WEB_MC"]["urlDefault"];

}
$urlGamification = "";

if (isset($dataManagerPage["dataConfigGamificationBusiness"]["VIEW_TASK_WEB_MC"])&&$dataManagerPage["dataConfigGamificationBusiness"]["VIEW_TASK_WEB_MC"]["success"]) {
    $urlGamification = $dataManagerPage["dataConfigGamificationBusiness"]["VIEW_TASK_WEB_MC"]["data"]->url_manager;

} else {
    $urlGamification = $dataManagerPage["dataConfigGamificationBusiness"]["VIEW_TASK_WEB_MC"]["urlDefault"];

}

$urlRewards = "";

if (isset($dataManagerPage["dataConfigGamificationBusiness"]["VIEW_REWARDS_WEB_MC"])&&$dataManagerPage["dataConfigGamificationBusiness"]["VIEW_REWARDS_WEB_MC"]["success"]) {
    $urlRewards = $dataManagerPage["dataConfigGamificationBusiness"]["VIEW_REWARDS_WEB_MC"]["data"]->url_manager;

} else {
    $urlRewards = $dataManagerPage["dataConfigGamificationBusiness"]["VIEW_REWARDS_WEB_MC"]["urlDefault"];

}

$urlSuggestion = "";

if (isset($dataManagerPage["dataConfigGamificationBusiness"]["VIEW_REGISTERS_SUGGESTION_WEB_MC"])&&$dataManagerPage["dataConfigGamificationBusiness"]["VIEW_REGISTERS_SUGGESTION_WEB_MC"]["success"]) {
    $urlSuggestion = $dataManagerPage["dataConfigGamificationBusiness"]["VIEW_REGISTERS_SUGGESTION_WEB_MC"]["data"]->url_manager;

} else {
    $urlSuggestion = $dataManagerPage["dataConfigGamificationBusiness"]["VIEW_REGISTERS_SUGGESTION_WEB_MC"]["urlDefault"];

}
?>

<div class="scroll-nav-wrapper fl-wrap business__menu-top">
    <div class="container">
        <nav class="scroll-nav scroll-init">
            <ul>
                <li class="ul-list__li"><a class="act-scrlink" href="#slider"><i class="fa fa-home"></i> {{__('frontend.business-details.menu-top.one.title')}}</a>
                </li>
                @if(($dataManagerPage['gamification']['allow']))
                    <li class="ul-list__li ul-list--link-custom" id="menu-gamification-li">
                        <a href="{{$urlGamification}}"><i class="fa fa-gamepad"></i> {{__('frontend.business-details.menu-top.six.title')}}</a>
                    </li>
                @endif

                @if(($dataManagerPage['gamification']['allow']))
                    <li class="ul-list__li ul-list--link-custom" id="menu-rewards-li">
                        <a href="{{$urlRewards}}"><i class="fa fa-gift"></i> {{__('frontend.business-details.menu-top.seven.title')}}</a>
                    </li>
                @endif
                @if(($dataManagerPage['gamification']['allow']))
                    <li class="ul-list__li ul-list--link-custom" id="menu-suggestion-li">
                        <a href="{{$urlSuggestion}}"><i class="fa fa-commenting"></i> {{__('frontend.business-details.menu-top.eight.title')}}</a>
                    </li>
                @endif
                @if(count($dataManagerPage['categories'])>0)
                    <li class="ul-list__li ul-list--link-custom" id="menu-shop-li">
                        @if($dataManagerPage['typeShopView']==1)
                            <a href="#business__categories"> {{__('frontend.business-details.menu-top.four.title')}}</a>
                        @else
                            <a href="{{$urlShop}}"><i class="fa fa-shopping-bag"></i> {{__('frontend.business-details.menu-top.four.title')}}</a>
                        @endif
                    </li>
                @endif
                <li class="ul-list__li"><a href="#details"><i class="fa fa-info-circle"></i> {{__('frontend.business-details.menu-top.five.title')}}</a></li>
                @if(isset($dataManagerPage['business']['gallery'])  && count($dataManagerPage['business']['gallery'])>0  && $dataManagerPage['type']!=1)
                    <li class="ul-list__li"><a href="#gallery">{{__('frontend.business-details.menu-top.two.title')}}</a></li>
                @endif
                @if (env('allowProcessSuggestions'))
                    <li class="ul-list__li"><a href="#reviews">{{__('frontend.business-details.menu-top.three.title')}}</a></li>
                @endif

            </ul>
        </nav>
        @if (env('allowProcessAddListing'))
            <a href="#" class="save-btn"> <i class="fa fa-heart"></i> Save </a>
        @endif
    </div>
</div>
