

<div class="footer bg-white shadow mt-auto border-top">
    @if(isset($dataManagerPage['isUserMenu']) && !$dataManagerPage['isUserMenu'])
        <div
            class="d-flex align-items-center justify-content-between py-1 menu-mobile-content menu-mobile-content--user-menu">
            <a href="{{$urlManagerPage}}" class="link-dark text-center col py-2 p-1">
                <i class="bi bi-house h3 m-0"></i>
                <p class="small m-0 pt-1">{{__('frontend.web.eatPura.frontend.menu.one')}}</p>
            </a>
            <a href="{{$urlShopPage}}" class="text-muted text-center col py-2 p-1">
                <i class="bi bi-shop h3 m-0"></i>
                <p class="small m-0 pt-1">{{__('frontend.web.eatPura.frontend.menu.four')}}</p>
            </a>
            <a href="store-list.html" class="text-muted text-center col py-2 p-1 not-view">
                <i class="bi bi-geo-alt h3 m-0"></i>
                <p class="small m-0 pt-1">Stores</p>
            </a>
            <a @click="viewShop()" class="text-muted text-center col py-2 p-1">
                <i class="bi bi-basket h3 m-0"></i>
                <p class="small m-0 pt-1">{{__('frontend.web.eatPura.frontend.menu.third')}}</p>
            </a>
            @if(Auth::check())
                <a href="{{route('userAccount', app()->getLocale())}}"
                   class="text-muted text-center col py-2 p-1">
                    <i class="bi bi-person h3 m-0"></i>
                    <p class="small m-0 pt-1">{{__('frontend.web.eatPura.frontend.menu.fourth')}}</p>
                </a>
            @else
                <a href="{{route('login', app()->getLocale())}}" class="text-muted text-center col py-2 p-1">
                    <i class="bi bi-person h3 m-0"></i>
                    <p class="small m-0 pt-1">{{__('frontend.web.eatPura.frontend.menu.eleven')}}</p>
                </a>
            @endif
        </div>
    @else

    @endif
</div>
