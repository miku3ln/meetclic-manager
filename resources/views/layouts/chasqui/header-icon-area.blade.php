
<div class="header-icon-area">
    <div class="account-dropdown">
        @if(Auth::check())
            <a href="javascript:void(0)">{{__('header.account-dropdown.sign-up')}} <i class="pe-7s-angle-down"></i></a>
        @else
            <a href="{{route('register',app()->getLocale())}}">{{__('header.account-dropdown.sign-up-guest')}}  <i class="pe-7s-angle-down"></i></a>

        @endif
        <ul class="account-dropdown__list">
            @if(Auth::check())
                <li><a href="{{url('customer/manager')}}">{{__('header.account-dropdown.account')}} </a></li>
            @else
                <li><a href="{{route('login',app()->getLocale())}}">{{__('header.account-dropdown.sign-in')}}</a></li>
            @endif

            @if(Auth::check())
                <li><a href="{{route('logout',app()->getLocale())}}">{{__('header.account-dropdown.logout')}}</a></li>

            @endif
        </ul>
    </div>

    <div class="header-icon d-flex align-items-center">
        <ul class="header-icon__list">
            <li><a href="javascript:void(0)" id="search-icon"><i class="fa fa-search"></i></a>
            </li>
            @if($dataManagerPage['shopConfig']['allow'])
                @include('layouts.partials.shop.cart',array('typeManagerButton'=>0))
            @endif
        </ul>
    </div>
</div>
