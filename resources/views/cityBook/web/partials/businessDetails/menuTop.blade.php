<?php
$urlGamification=route('businessPullkay', app()->getLocale())."/".$dataManagerPage['business']['information']->title;
$urlShop=route('shop-business')."/".$dataManagerPage['business']['information']->title;

?>

<div class="scroll-nav-wrapper fl-wrap business__menu-top">
    <div class="container">
        <nav class="scroll-nav scroll-init">
            <ul>
                <li class="ul-list__li"><a class="act-scrlink" href="#slider">{{__('frontend.business-details.menu-top.one.title')}}</a>
                </li>
                @if(($dataManagerPage['gamification']['allow']))
                    <li class="ul-list__li" id="menu-gamification-li">
                        <a href="{{$urlGamification}}"><i class="fa  fa-trophy"></i> {{__('frontend.business-details.menu-top.six.title')}}</a>
                    </li>
                @endif
                @if(count($dataManagerPage['categories'])>0)
                    <li class="ul-list__li" id="menu-shop-li">
                        @if($dataManagerPage['typeShopView']==1)
                            <a href="#business__categories">{{__('frontend.business-details.menu-top.four.title')}}</a>
                        @else
                            <a href="{{$urlShop}}">{{__('frontend.business-details.menu-top.four.title')}}</a>
                        @endif
                    </li>
                @endif
                <li class="ul-list__li"><a href="#details">{{__('frontend.business-details.menu-top.five.title')}}</a></li>
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
