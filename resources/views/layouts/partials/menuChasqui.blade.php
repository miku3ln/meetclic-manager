@if($typeMenu==1) {{-- main--}}
<ul>
    <li class="{{$activeHome}}">
        <a href="{{URL('chasqui/'.app()->getLocale().'/nianes')}}">{{__('frontend.menu.home')}}</a>
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
            <li class="{{$activeServices}}"><a
                    href="{{URL(app()->getLocale().'/'.'services')}}">{{__('frontend.menu.services')}}</a>
            </li>

        </ul>
    </li>

</ul>
@elseif($typeMenu==0) <!--mobile-->
<ul>

    <li class="{{$activeHome}}" id="page-home">
        <a href="{{URL('chasqui/'.app()->getLocale().'/nianes')}}">{{__('frontend.menu.home')}}</a>
    </li>
    <li class="{{$activeAboutUs}}" id="page-aboutUs"><a
            href="{{route('aboutUs',app()->getLocale())}}">{{__('frontend.menu.about-us')}}</a>
    </li>
    <li class="{{$activeContactUs}}" id="page-contactUs"><a
            href="{{route('contactUs',app()->getLocale())}}">{{__('frontend.menu.contact-us')}}</a>
    </li>
    <li class="{{$activeServices}}" id="page-services"><a
            href="{{route('services',app()->getLocale())}}">{{__('frontend.menu.services')}}</a>
    </li>

</ul>
@else  {{--footer menu--}}
<div class="row">

    <div class="col-6 col-sm-12 col-md-6">
        <div class="footer-widget">
            <h4 class="footer-widget__title">{{__('frontend.menu.pages')}}</h4>
            <nav class="footer-widget__navigation">
                <ul>

                    <li>
                        <a href="{{URL('chasqui/'.app()->getLocale().'/nianes')}}">{{__('frontend.menu.home')}}</a>
                    </li>
                    <li>
                        <a href="{{route('aboutUs',app()->getLocale())}}">{{__('frontend.menu.about-us')}}</a>
                    </li>
                    <li>
                        <a href="{{route('contactUs',app()->getLocale())}}">{{__('frontend.menu.contact-us')}}</a>
                    </li>
                    <li>
                        <a href="{{route('services',app()->getLocale())}}">{{__('frontend.menu.services')}}</a>
                    </li>
                    <li>
                        <a href="{{route('shop',app()->getLocale())}}">{{__('frontend.menu.shop')}}</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    @if($pageSectionsConfig['use-full-link']['view'])
        <div class="col-6 col-sm-12 col-md-6">
            <div class="footer-widget">
                <h4 class="footer-widget__title">{{__('frontend.menu.other-pages')}}</h4>
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
</div>
@endif
