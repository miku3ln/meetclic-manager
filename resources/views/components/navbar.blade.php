
@php
    use Illuminate\Support\Facades\Route;
    $menu = $menu ?? [];
       function hasActiveChild($children)
    {
        foreach($children as $child){

            if(
                isset($child['route']) &&
                Route::has($child['route']) &&
                request()->routeIs($child['route'])
            ){
                return true;
            }

        }

        return false;
    }
@endphp


<nav class="navbar navbar-expand-lg navbar-app">


    <div class="container-fluid">


        <!-- MOBILE TOGGLE -->

        <button class="navbar-app__toggle"
                id="btnSidebarMobile">

            <i class="fa-solid fa-bars"></i>

        </button>


        <!-- BRAND -->

        <a class="navbar-app__brand"
           href="#">

            <div class="navbar-app__logo">

                <i class="fa-solid fa-layer-group"></i>

            </div>


            <div class="navbar-app__title">

                <span>
                    MeetClic
                </span>

                <small>
                    Administración
                </small>

            </div>


        </a>


        <!-- DESKTOP MENU -->

        <div class="navbar-app__menu-wrapper"
             id="navbarMenu">


            <ul class="navbar-app__menu">


                @foreach($menu as $item)

                    <li class="navbar-app__item">


                        @if(isset($item['children']))

                            <!-- MENU PADRE -->


                            <a class="navbar-app__link navbar-app__link--dropdown

{{
    hasActiveChild($item['children'])
    ? 'active-parent'
    : ''
}}">


                                <i class="{{ $item['icon'] }}"></i>


                                <span>
                                    {{ $item['name'] }}
                                </span>


                                <i class="fa-solid fa-chevron-down"></i>


                            </a>





                            <!-- SUBMENU -->


                            <ul class="navbar-app__submenu">


                                @foreach($item['children'] as $child)

                                    <li class="navbar-app__subitem">


                                        <a href="

                                        {{
                                            isset($child['route']) &&
                                            Route::has($child['route'])

                                            ? route($child['route'])

                                            : ($child['url'] ?? '#')
                                        }}

                                        "


                                           class="navbar-app__sublink


                                        {{
                                            isset($child['route']) &&
                                            Route::has($child['route']) &&
                                            request()->routeIs($child['route'])

                                            ? 'active'

                                            : ''

                                        }}">


                                            {{ $child['name'] }}


                                        </a>


                                    </li>

                                @endforeach


                            </ul>

                        @else

                            <!-- MENU SIMPLE -->


                            <a href="


                            {{
                                isset($item['route']) &&
                                Route::has($item['route'])

                                ? route($item['route'])

                                : ($item['url'] ?? '#')

                            }}


                            "


                               class="navbar-app__link


                            {{

                                isset($item['route']) &&
                                Route::has($item['route']) &&
                                request()->routeIs($item['route'])

                                ? 'active'

                                : ''

                            }}">


                                <i class="{{ $item['icon'] }}"></i>


                                <span>

                                    {{ $item['name'] }}

                                </span>


                            </a>

                        @endif


                    </li>

                @endforeach


            </ul>


        </div>


        <!-- ACTIONS -->


        <div class="navbar-app__actions">


            <button class="navbar-app__notification"
                    id="btnNotification">


                <i class="fa-solid fa-bell"></i>


                <span class="navbar-app__badge">

                    3

                </span>


            </button>


            <button class="navbar-app__user"
                    id="btnUserMenu">


                <img src="https://i.pravatar.cc/40"
                     alt="Usuario">


                <div>



                    <span>
                        Admin
                    </span>


                    <small>
                        Empresa
                    </small>


                </div>


                <i class="fa-solid fa-chevron-down"></i>


            </button>


        </div>


    </div>


</nav>


<!-- ===============================
     MOBILE MENU
================================ -->


<div class="navbar-mobile"
     id="navbarMobile">


    <ul class="navbar-mobile__menu">


        @foreach($menu as $item)

            <li class="navbar-mobile__item">


                @if(isset($item['children']))

                    <div class="navbar-mobile__title">


                        <i class="{{ $item['icon'] }}"></i>


                        <span>

                            {{ $item['name'] }}

                        </span>


                    </div>









                    @foreach($item['children'] as $child)

                        <a href="


                        {{
                            isset($child['route']) &&
                            Route::has($child['route'])

                            ? route($child['route'])

                            : ($child['url'] ?? '#')

                        }}



                        "


                           class="navbar-mobile__link



                        {{

                            isset($child['route']) &&
                            Route::has($child['route']) &&
                            request()->routeIs($child['route'])

                            ? 'active'

                            : ''

                        }}">


                            {{ $child['name'] }}


                        </a>

                    @endforeach

                @else

                    <a href="



                    {{
                        isset($item['route']) &&
                        Route::has($item['route'])

                        ? route($item['route'])

                        : ($item['url'] ?? '#')

                    }}




                    "


                       class="navbar-mobile__link





                    {{

                        isset($item['route']) &&
                        Route::has($item['route']) &&
                        request()->routeIs($item['route'])

                        ? 'active'

                        : ''

                    }}"

                    >


                        <i class="{{ $item['icon'] }}"></i>


                        <span>

                            {{ $item['name'] }}

                        </span>


                    </a>

                @endif


            </li>

        @endforeach


    </ul>


</div>
