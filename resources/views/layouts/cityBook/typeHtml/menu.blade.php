<ul class="manager-ul" type-menu="{{$typeMenu}}">
    <li class="li-{{ $activeHome }}">
        <a class="{{ $activeHome }}  menu__a"
           href="{{ route('urlBase')}}">{{ __('frontend.menu.home') }}</a>
    </li>
    <li class="li-{{ $activeOurAllies }} ">
        <a class="{{ $activeOurAllies }}  menu__a"
           href="{{ route('shopBusiness', app()->getLocale()) }}/">{{ __('frontend.menu.shop-page') }}</a>
    </li>
    @if ($dataManagerPage['shopConfig']['allow'])

        <li class="li-{{ $activeShop }}">
            <a class="{{ $activeShop }}  menu__a"
               href="{{ route('shopBee', app()->getLocale()) }}">{{ __('frontend.menu.shop') }}</a>
        </li>
    @endif
    @if (env('allowSectionGamingActivities'))

        <li class="li-{{ $activeHowItWorks }}"><a class="{{ $activeHowItWorks }}  menu__a"
                                                  href="{{ route('howItWorks', app()->getLocale()) }}">{{ __('frontend.menu.gamification.activities') }}</a>
        </li>
    @endif
    <li class="li-{{ $activeAboutUs }} ">
        <a class="a-{{ $activeAboutUs }}  menu__a-children"
           href="{{ route('aboutUsBee', app()->getLocale()) }}">{{ __('frontend.menu.about-us') }}</a>
    </li>


    <li class="li-has-children-{{ $eventsManagerParent }} " >

        <a class="{{ $eventsManagerParent }}  menu__a" href="javascript:void(0)">{{ __('frontend.menu.project') }}
            <i
                class="fa fa-angle-down"></i></a>
        <ul>

            <li class="li-children-{{ $chaskishimi }}"><a
                    class="a-{{ $chaskishimi }}  menu__a-children"
                    href="{{route('ricksichishun', app()->getLocale())  }}">{{ __('frontend.menu.project.one') }}</a>
            </li>
            <li class="li-children-{{ $eventsManager }}"><a
                    class="a-{{ $eventsManager }}  menu__a-children"
                    href="{{route('events-manager', app()->getLocale())  }}">{{ __('frontend.menu.experiencesEvents') }}</a>
            </li>

        </ul>
    </li>
    <li class="li-{{ $activeContactUs }}"><a class="{{ $activeContactUs }}  menu__a"
                                             href="{{ route('contactUsBee', app()->getLocale()) }}">{{ __('frontend.menu.contact-us') }}</a>
    </li>

</ul>
