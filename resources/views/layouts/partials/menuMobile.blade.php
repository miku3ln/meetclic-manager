<?php

$pageSectionsConfigSet=[];
$dataManagerPageSet=[];

if(isset($pageSectionsConfig)){
    $pageSectionsConfigSet=$pageSectionsConfig;
}
?>
<div class="offcanvas-mobile-menu" id="offcanvas-mobile-menu">
    <a href="javascript:void(0)" class="offcanvas-menu-close" id="offcanvas-menu-close-trigger">
        <i class="pe-7s-close"></i>
    </a>

    <div class="offcanvas-wrapper">

        <div class="offcanvas-inner-content">
            <div class="offcanvas-mobile-search-area">
                <form action="#">
                    <input type="search" id="search-input-mobile--value" placeholder="Search ...">
                    <button type="submit"><i class="fa fa-search" id="search-icon-mobile-input"></i></button>
                </form>
            </div>
            <nav class="offcanvas-naviagtion">

                @include('layouts.partials.menu',
['activeHome'=>$activeHome,
'activePages'=>$activePages,
'activeAboutUs'=>$activeAboutUs,
'activeContactUs'=>$activeContactUs,
'activeServices'=>$activeServices,
'activeShop'=>$activeShop,
'typeMenu'=>0,
'pageSectionsConfig'=>$pageSectionsConfigSet
])
            </nav>

            <div class="offcanvas-widget-area">
                @if(!Auth::check())
                    <ul class="header-contact-info__list">
                        <li><a href="{{ route('login',app()->getLocale()) }}">{{ __('header.account-dropdown.sign-in') }} </a></li>

                    </ul>
            @endif
            @include('layouts.partials.contact-header',
[
'typeMenu'=>0,
'pageSectionsConfig'=>$pageSectionsConfigSet

])

            @if(isset($dataMenu))
                @if(isset($dataMenu['socialNetworkMenuMobile']))

                    @if($dataMenu['socialNetworkMenuMobile']!='')
                        {{$dataMenu['socialNetworkMenuMobile']}}
                    @else

                    @endif
                @else


                @endif
            @else

            @endif
            <!--Off Canvas Widget Social End-->
            </div>
        </div>
    </div>

</div>
