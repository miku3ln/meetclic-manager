{{-- CMS-TEMPLATE-MENU-VIEW--}}
@if ($typeMenu == 1)
    {{-- main MENU FRONTEND MFINI--}}
    @if (env('allowAllInOne'))

        <ul class="manager-ul">
            <li class="li-{{ $activePachamama }}">
                <a class="{{ $activePachamama }}  menu__a menu__a--local menu__pachamama"
                   href="{{ route('homeChaski', app()->getLocale()) }}">{{ __('frontend.menu.project.one.home') }}</a>
            </li>
            <li class="li-{{ $activeKichwa }}">
                <a class="{{ $activeKichwa }}  menu__a menu__a--local menu__kichwa"
                   href="#kichwa">{{ __('frontend.menu.project.one.kichwa') }}</a>
            </li>
            <li class="li-{{ $activeElements }}">
                <a class="{{ $activeElements }}  menu__a menu__a--local menu__elements"
                   href="#elements">{{ __('frontend.menu.project.one.elements') }}</a>
            </li>
            <li class="li-{{ $activeArawi }} ">
                <a class="{{ $activeArawi }}  menu__a menu__a--local menu__arawi"
                   href="#arawi">{{ __('frontend.menu.project.one.arawi') }}</a>
            </li>

            <li class="li-{{ $activeYachaSun }}"><a class="{{ $activeYachaSun }}  menu__a"
                                                     href="{{ route('yachaSun', app()->getLocale()) }}">{{ __('frontend.menu.project.one.learn') }}</a>
            </li>
            <li class="li-{{ $activeApuntes }}"><a class="{{ $activeApuntes}}  menu__a "
                                                        href="{{ route('apuntes', app()->getLocale()) }}">{{ __('frontend.menu.project.one.notes') }}</a>
            </li>
            <li class="li-{{ $activeDiccionario }} "><a class="{{ $activeDiccionario}}  menu__a "
                                                        href="{{ route('diccionario', app()->getLocale()) }}">{{ __('frontend.menu.project.one.dictionary') }}</a>
            </li>
            <li class="li-{{ $activeTraductor }} "><a class="{{ $activeTraductor}}  menu__a "
                                                        href="{{ route('traductor', app()->getLocale()) }}">{{ __('frontend.menu.project.one.translate') }}</a>
            </li>
        </ul>

    @endif
@elseif($typeMenu==0)
    <!--mobile-->



@endif
