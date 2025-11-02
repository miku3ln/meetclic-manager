@if($typeMenu==1) {{-- main--}}
<div class="header-contact-info-wrapper d-none d-lg-block">
    @if(isset($pageSectionsConfig['business']['view']))
        <ul class="header-contact-info__list">
            <li><i class="fa fa-envelope-o"></i> <a
                    href="mailto:{{$pageSectionsConfig['business']['data']->email}}">{{$pageSectionsConfig['business']['data']->email}}</a>
            </li>
        </ul>
    @else
        <ul class="header-contact-info__list">
            <li><i class="pe-7s-phone"></i> <a href="tel://12452456012">(1245) 2456 012</a></li>
            <li><i class="fa fa-envelope-o"></i> <a href="mailto:info@yourdomain.com">info@yourdomain.com</a>
            </li>
        </ul>
    @endif
</div>
@else <!--mobile-->

<div class="off-canvas-contact-widget">
    <div class="header-contact-info">
        @if(isset($pageSectionsConfig['business']['view']))
            <ul class="header-contact-info__list">
                <li><i class="fa fa-whatsapp"></i> <a href="tel://{{$pageSectionsConfig['business']['data']->phone_value}}">{{$pageSectionsConfig['business']['data']->phone_value}} </a></li>
                <li><i class="fa fa-envelope-o"></i> <a
                        href="mailto:{{$pageSectionsConfig['business']['data']->email}}">{{$pageSectionsConfig['business']['data']->email}}</a></li>
            </ul>
        @else
            <ul class="header-contact-info__list">
                <li><i class="pe-7s-phone"></i> <a href="tel://12452456012">(1245) 2456 012 </a></li>
                <li><i class="fa fa-envelope-o"></i> <a
                        href="mailto:info@yourdomain.com">info@yourdomain.com</a></li>
            </ul>
        @endif
    </div>
</div>
@endif
