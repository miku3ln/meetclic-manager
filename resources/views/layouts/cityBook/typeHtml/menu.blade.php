{{-- CMS-TEMPLATE-MENU-VIEW--}}
@if ($typeMenu == 1)
    {{-- main MENU FRONTEND MFINI--}}
    @if (env('allowAllInOne'))

        @if (!env('allowCustomerMenuTop'))
            <ul type-menu="{{$typeMenu}}">
                <li class="li-{{ $activeHome }}">
                    <a class="{{ $activeHome }}  menu__a"
                       href="{{ route('urlBase') }}/">{{ __('frontend.menu.home') }}</a>
                </li>
                <li class="li-{{ $activeAboutUs }}">
                    <a class="{{ $activeAboutUs }}  menu__a"
                       href="{{ route('aboutUsBee', app()->getLocale()) }}">{{ __('frontend.menu.about-us') }}</a>
                </li>
                <li class="li-has-children-{{ $activeProducts }}">
                    <a class="{{ $activeProducts }} menu__a"
                       href="javascript:void(0)">{{ __('frontend.menu.businessProducts') }} <i
                            class="fa fa-angle-down"></i></a>
                    <ul>

                        <li class="li-children-{{ $activeProductFlowers }}">
                            <a class="a-{{ $activeProductFlowers }}  menu__a-children"
                               href="{{ route('productFlowers', app()->getLocale()) }}">{{ __('frontend.menu.productFlowers') }}</a>
                        </li>
                        <li class="li-children-{{ $activeProductProducts }}">
                            <a class="a-{{ $activeProductProducts }}  menu__a-children"
                               href="{{ route('productProducts', app()->getLocale()) }}">{{ __('frontend.menu.productProducts') }}</a>
                        </li>
                        <li class="li-children-{{ $activeProductFrozen }}   not-view">
                            <a class="a-{{ $activeProductFrozen }}  menu__a-children"
                               href="{{ route('productFrozen', app()->getLocale()) }}">{{ __('frontend.menu.productFrozen') }}</a>
                        </li>
                        <li class=" li-children-{{ $activeProductFruits }} ">
                            <a class="a-{{ $activeProductFruits }}  menu__a-children"
                               href="{{ route('productFruits', app()->getLocale()) }}">{{ __('frontend.menu.productFruits') }}</a>
                        </li>
                        <li class="li-children-{{ $activeProductBox }}">
                            <a class="a-{{ $activeProductBox }}  menu__a-children"
                               href="{{ route('productBox', app()->getLocale()) }}">{{ __('frontend.menu.productBox') }}</a>
                        </li>
                    </ul>
                </li>


                <li class="li-{{ $activeContactUs }}"><a class="{{ $activeContactUs }}  menu__a"
                                                         href="{{ route('contactUsBee', app()->getLocale()) }}">{{ __('frontend.menu.contact-us') }}</a>
                </li>
                <li class="li-{{ $activeFAQ }} not-view"><a class="{{ $activeFAQ}}  menu__a "
                                                            href="{{ route('FAQ', app()->getLocale()) }}">{{ __('frontend.menu.FAQ') }}</a>
                </li>

            </ul>
        @else
            @if (env('allowCustomerMenuTop'))
                <ul class="manager-ul" type-menu="{{$typeMenu}}">
                    <li class="li-{{ $activeHome }}">
                        <a class="{{ $activeHome }}  menu__a"
                           href="{{ route('urlBase')}}">{{ __('frontend.menu.home') }}</a>
                    </li>

                    @if ($dataManagerPage['shopConfig']['allow'])

                        <li class="li-{{ $activeShop }}">
                            <a class="{{ $activeShop }}  menu__a"
                               href="{{ route('shopBee', app()->getLocale()) }}">{{ __('frontend.menu.shop') }}</a>
                        </li>
                    @endif
                    @if (env('allowSectionGamingActivities'))

                        <li class="li-{{ $activeActivities }}"><a class="{{ $activeActivities }}  menu__a"
                                                                  href="{{ route('activities', app()->getLocale()) }}">{{ __('frontend.menu.gamification.activities') }}</a>
                        </li>
                    @endif
                    <li class="li-has-children-{{ $activePages }}">
                        <a class="{{ $activePages }}  menu__a" href="javascript:void(0)">{{ __('frontend.menu.pages') }}
                            <i
                                class="fa fa-angle-down"></i></a>
                        <ul>
                            <li class="li-children-{{ $activeAboutUs }}">
                                <a class="a-{{ $activeAboutUs }}  menu__a-children"
                                   href="{{ route('aboutUsBee', app()->getLocale()) }}">{{ __('frontend.menu.about-us') }}</a>
                            </li>


                            <li class="li-children-{{ $activeHowItWorks }}"><a
                                    class="a-{{ $activeHowItWorks }}  menu__a-children"
                                    href="{{ route('howItWorks', app()->getLocale()) }}">{{ __('frontend.menu.howItWorks') }}</a>
                            </li>
                            <li class="li-children-{{ $activeBackLine }}"><a
                                    class="a-{{ $activeBackLine }}  menu__a-children"
                                    href="{{ route('homeBackLine', app()->getLocale()) }}">{{ __('frontend.menu.backLine') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="li-has-children-{{ $activeDictionary }}">

                        {{-- CMS-TEMPLATE-MENU-VIEW--KICHWA-CASTILIAN--}}
                        <a class="{{ $activeDictionary }}  menu__a" href="javascript:void(0)">{{ __('frontend.menu.project') }}
                            <i
                                class="fa fa-angle-down"></i></a>
                        <ul>
                            <li class="li-children-{{ $chaskishimi }}"><a
                                    class="a-{{ $chaskishimi }}  menu__a-children"
                                    href="{{route('homeChaski', app()->getLocale())  }}">{{ __('frontend.menu.project.one') }}</a>
                            </li>
                            <li class="li-children-{{ $dictionaryKichwaToCastilian }} not-view"><a
                                    class="a-{{ $dictionaryKichwaToCastilian }}  menu__a-children"
                                    href="{{ route('dictionaryType', [app()->getLocale(),'type'=>1]) }}">{{ __('frontend.menu.dictionaryKichwaToCastellano') }}</a>
                            </li>
                            <li class="li-children-{{ $dictionaryCastilianToKichwa }} not-view"><a
                                    class="a-{{ $dictionaryCastilianToKichwa }}  menu__a-children"
                                    href="{{ route('dictionaryType', [app()->getLocale(),'type'=>2]) }}">{{ __('frontend.menu.dictionaryCastilianToKichwa') }}</a>
                            </li>
                        </ul>
                    </li>



                    <li class="li-{{ $activeSearch }}"><a class="{{ $activeSearch }}  menu__a"
                                                              href="{{ route('search', app()->getLocale()) }}">{{ __('frontend.menu.search')}}</a>
                    </li>
                    <li class="li-{{ $activeContactUs }}"><a class="{{ $activeContactUs }}  menu__a"
                                                             href="{{ route('contactUsBee', app()->getLocale()) }}">{{ __('frontend.menu.contact-us') }}</a>
                    </li>

                </ul>
            @endif
        @endif

    @endif
@elseif($typeMenu==0)
    <!--mobile-->



@endif
