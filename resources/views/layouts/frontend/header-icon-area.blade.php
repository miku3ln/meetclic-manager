<?php

$dataManagerPageSet=[];
if(isset($dataManagerPage)){
    $dataManagerPageSet= $dataManagerPage;
}
$rootUrlLogout=route("homePage")."/".app()->getLocale()."/logout";
$rootUrlLogin=route("homePage")."/".app()->getLocale()."/login";
$rootUrlRegister=route("homePage")."/".app()->getLocale()."/register";

?>
<div class="header-icon-area">
    <div class="account-dropdown">
        @if(Auth::check())
            <a href="javascript:void(0)">{{__('header.account-dropdown.sign-up')}} <i class="pe-7s-angle-down"></i></a>
        @else
            <a href="{{$rootUrlRegister}}">{{__('header.account-dropdown.sign-up-guest')}}  <i class="pe-7s-angle-down"></i></a>

        @endif
        <ul class="account-dropdown__list">
            @if(Auth::check())
                <li><a href="{{route('profileAccount',app()->getLocale())}}">{{__('header.account-dropdown.account')}} </a></li>
            @else
                <li><a href="{{$rootUrlLogin}}">{{__('header.account-dropdown.sign-in')}}</a></li>
            @endif

            @if(Auth::check())
                <li><a href="{{$rootUrlLogout}}">{{__('header.account-dropdown.logout')}}</a></li>

            @endif
        </ul>
    </div>

    <div class="header-icon d-flex align-items-center">
        <ul class="header-icon__list">
            <li><a href="javascript:void(0)" id="search-icon"><i class="fa fa-search"></i></a>
            </li>

            @if(isset($dataManagerPageSet['shopConfig']['allow']))
                @include('layouts.partials.shop.cart',['typeManagerButton'=>0])

            @endif
        </ul>
    </div>
</div>
