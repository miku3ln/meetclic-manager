@if($typeMenu==1) {{-- main--}}



<ul>
    @if(env('allowBusinessOwner'))
        @if(isset($dataCategoriesMenuTop) && count ($dataCategoriesMenuTop)>0)
            @php
                $urlCurrentShop=URL(app()->getLocale().'/'.'shop');
            @endphp
            <li class="has-children">
                <a href="{{URL(app()->getLocale().'/'.'shop')}}" class="has-children--uppercase">Productos</a>
                <ul class="submenu submenu--column-1">
                    @foreach($dataCategoriesMenuTop as $key =>$row)
                        <li class="has-children">
                            <a href="javascript:void(0)">{{$row['value']}}</a>
                            @foreach($row['data'] as $keyData =>$rowData)
                                <ul class="submenu submenu--column-1 submenu--left">
                                    <li>
                                        <a href="{{$urlCurrentShop.'?category='.$row[
    'id'].'&subcategory='.$rowData[
    'id'] }}">{{$rowData['value']}}</a>
                                    </li>

                                </ul>
                            @endforeach
                        </li>
                    @endforeach

                </ul>
            </li>
            <li class="management-search">
                <a href="javascript:void(0)" id="search-input"> <input type="text"
                                                                       placeholder="Ingrese y Presione Enter para buscar "
                                                                       id="search-input--value"><i class="fa fa-search"
                                                                                                   id="search-icon-input"></i></a>
            </li>
        @endif



    @else
        <li class="{{$activeHome}}">
            <a href="{{URL(app()->getLocale().'/')}}">{{__('frontend.menu.home')}}</a>
        </li>
        <li class="has-children {{$activePages}}">
            <a href="javascript:void(0)">{{__('frontend.menu.pages')}}</a>
            <ul class="submenu submenu--column-1">
                <li class="{{$activeAboutUs}}"><a
                        href="{{URL(app()->getLocale().'/'.'aboutUs')}}">{{__('frontend.menu.about-us')}}</a>
                </li>
                <li class="{{$activeContactUs}}"><a
                        href="{{URL(app()->getLocale().'/'.'contactUs')}}">{{__('frontend.menu.contact-us')}}</a>
                </li>
                @if(env('allowSectionServices'))

                    <li class="{{$activeServices}}"><a
                            href="{{URL(app()->getLocale().'/'.'services')}}">{{__('frontend.menu.services')}}</a>
                    </li>
                @endif
            </ul>
        </li>

        @if(isset($dataManagerPage['shopConfig']['allow']))
            <li class="{{$activeShop}}"><a
                    href="{{URL(app()->getLocale().'/'.'shop')}}">{{__('frontend.menu.shop')}}</a>

            </li>

        @endif

        @if(env('allowSectionGamingActivities'))
            <li class="{{$activeActivities}}"><a
                    href="{{route('activities',app()->getLocale())}}">{{__('frontend.menu.gamification.activities')}}</a>
            </li>
        @endif
        @if(env('allowSectionGamingRewards'))
            <li class="{{$activeRewards}}"><a
                    href="{{route('rewards',app()->getLocale())}}">{{__('frontend.menu.gamification.rewards')}}</a>
            </li>
        @endif
    @endif

</ul>
@elseif($typeMenu==0) <!--mobile-->
<ul>
    @if(env('allowBusinessOwner'))

        @if(isset($dataCategoriesMenuTop) && count ($dataCategoriesMenuTop)>0)
            @php
                $urlCurrentShop=URL(app()->getLocale().'/'.'shop');
            @endphp

            <li class="menu-item-has-children">

                <a href="{{URL(app()->getLocale().'/'.'shop')}}" class="has-children--uppercase">Productos</a>
                <ul class="sub-menu">
                    @php
                        $urlCurrentShop=URL(app()->getLocale().'/'.'shop');
                    @endphp
                    @foreach($dataCategoriesMenuTop as $key =>$row)
                        <li class="menu-item-has-children"><a>{{$row['value']}}</a>
                            <ul class="sub-menu">
                                @foreach($row['data'] as $keyData =>$rowData)

                                    <li><a href="{{$urlCurrentShop.'?category='.$row[
    'id'].'&subcategory='.$rowData[
    'id']}}">{{$rowData['value']}}</a></li>

                                @endforeach
                            </ul>
                        </li>
                    @endforeach

                </ul>
            </li>
        @endif


    @else


        <li class="{{$activeHome}}" id="page-home">
            <a href="{{URL(app()->getLocale().'/')}}">{{__('frontend.menu.home')}}</a>
        </li>
        <li class="{{$activeAboutUs}}" id="page-aboutUs"><a
                href="{{route('aboutUs',app()->getLocale())}}">{{__('frontend.menu.about-us')}}</a>
        </li>
        <li class="{{$activeContactUs}}" id="page-contactUs"><a
                href="{{route('contactUs',app()->getLocale())}}">{{__('frontend.menu.contact-us')}}</a>
        </li>
        @if(env('allowSectionServices'))

            <li class="{{$activeServices}}" id="page-services"><a
                    href="{{route('services',app()->getLocale())}}">{{__('frontend.menu.services')}}</a>
            </li>
        @endif
        @if(isset($dataManagerPage['shopConfig']['allow']))
            <li class="{{$activeShop}}" id="page-shop"><a
                    href="{{route('shop',app()->getLocale())}}">{{__('frontend.menu.shop')}}</a>

            </li>
        @endif
        @if(env('allowSectionGamingActivities'))
            <li class="{{$activeActivities}}"><a
                    href="{{route('activities',app()->getLocale())}}">{{__('frontend.menu.gamification.activities')}}</a>
            </li>
            <li class="{{$activeRewards}}"><a
                    href="{{route('rewards',app()->getLocale())}}">{{__('frontend.menu.gamification.rewards')}}</a>
            </li>
        @endif
    @endif

</ul>
@else  {{--footer menu--}}

@if(env('allowBusinessOwner'))
    <div class="row row--menu">

        <div class="col-md-6">
            <div class="footer-widget">
                <h4 class="footer-widget__title">Información Corporativa</h4>
                <nav class="footer-widget__navigation">
                    <ul>
                        <li>
                            <a href="{{route('aboutUs',app()->getLocale())}}">{{__('frontend.menu.about-us')}}</a>
                        </li>
                        <li>
                            <a href="{{route('services',app()->getLocale())}}">{{__('frontend.menu.services')}}</a>
                        </li>
                        <li>
                            <a href="{{route('ourStores',app()->getLocale())}}">Nuestros Locales</a>
                        </li>


                    </ul>
                </nav>
            </div>
        </div>
        <div class="col-md-6">
            <div class="footer-widget">
                <h4 class="footer-widget__title">Contáctanos</h4>
                <nav class="footer-widget__navigation">
                    <ul>

                        <li>
                            <a href="{{route('contactUs',app()->getLocale())}}">Escribenos</a>
                        </li>
                        <li>
                            <a href="{{route('orderService',app()->getLocale())}}">Agenda tu Cita</a>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="row  row--menu">

        @if(isset($pageSectionsConfig['use-full-link']['view']))
            <div class="col-md-6">
                <div class="footer-widget">
                    <h4 class="footer-widget__title">Servicios y Garantías</h4>
                    <nav class="footer-widget__navigation">
                        <ul>
                            @if($pageSectionsConfig['policies']['view'])
                                <li>
                                    <a href="{{route('policies',app()->getLocale())}}">{{__('frontend.menu.policies')}}</a>
                                </li>
                            @endif
                            @if($pageSectionsConfig['terms']['view'])
                                <li>
                                    <a href="{{route('terms',app()->getLocale())}}">{{__('frontend.menu.terms')}}</a>
                                </li>
                            @endif


                        </ul>
                    </nav>
                </div>
            </div>
        @endif
        <div class="col-md-6">
            <div class="footer-widget">
                <h4 class="footer-widget__title"> Tienda</h4>
                <nav class="footer-widget__navigation">
                    <ul>
                        <li>
                            <a href="{{route('shop',app()->getLocale())}}">{{__('frontend.menu.shop')}}</a>
                        </li>
                        <li>
                            <a href="{{route('shopOutlets',app()->getLocale())}}">Descuentos</a>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>


    </div>
@else
    <div class="row row--menu">

        <div class="col-md-6">
            <div class="footer-widget">
                <h4 class="footer-widget__title">Información Corporativa</h4>
                <nav class="footer-widget__navigation">
                    <ul>
                        <li>
                            <a href="{{route('aboutUs',app()->getLocale())}}">{{__('frontend.menu.about-us')}}</a>
                        </li>
                        <li>
                            <a href="{{route('services',app()->getLocale())}}">{{__('frontend.menu.services')}}</a>
                        </li>
                        <li>
                            <a href="{{route('ourStores',app()->getLocale())}}">Nuestros Locales</a>
                        </li>


                    </ul>
                </nav>
            </div>
        </div>
        <div class="col-md-6">
            <div class="footer-widget">
                <h4 class="footer-widget__title">Contáctanos</h4>
                <nav class="footer-widget__navigation">
                    <ul>

                        <li>
                            <a href="{{route('contactUs',app()->getLocale())}}">Escribenos</a>
                        </li>


                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="row  row--menu">

        @if(isset($pageSectionsConfig['use-full-link']['view']))
            <div class="col-md-6">
                <div class="footer-widget">
                    <h4 class="footer-widget__title">Servicios y Garantías</h4>
                    <nav class="footer-widget__navigation">
                        <ul>
                            @if($pageSectionsConfig['policies']['view'])
                                <li>
                                    <a href="{{route('policies',app()->getLocale())}}">{{__('frontend.menu.policies')}}</a>
                                </li>
                            @endif
                            @if($pageSectionsConfig['terms']['view'])
                                <li>
                                    <a href="{{route('terms',app()->getLocale())}}">{{__('frontend.menu.terms')}}</a>
                                </li>
                            @endif


                        </ul>
                    </nav>
                </div>
            </div>
        @endif
        <div class="col-md-6">
            <div class="footer-widget">
                <h4 class="footer-widget__title"> Tienda</h4>
                <nav class="footer-widget__navigation">
                    <ul>
                        <li>
                            <a href="{{route('shop',app()->getLocale())}}">{{__('frontend.menu.shop')}}</a>
                        </li>
                        <li>
                            <a href="{{route('shopOutlets',app()->getLocale())}}">Descuentos</a>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>


    </div>
@endif

@endif
