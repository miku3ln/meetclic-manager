<div class="scroll-nav-wrapper fl-wrap business__menu-top">
    <div class="container">
        <nav class="scroll-nav scroll-init">
            <ul>
                <li><a class="act-scrlink" href="#slider">{{__('frontend.business-details.menu-top.one.title')}}</a>
                </li>
                @if(count($dataManagerPage['categories'])>0)
                    <li>
                        @if($dataManagerPage['typeShopView']==1)
                            <a href="#business__categories">{{__('frontend.business-details.menu-top.four.title')}}</a>
                        @else
                            <a href="#business__shop">{{__('frontend.business-details.menu-top.four.title')}}</a>
                        @endif
                    </li>
                @endif
                <li><a href="#details">{{__('frontend.business-details.menu-top.five.title')}}</a></li>
                @if(isset($dataManagerPage['business']['gallery'])  && count($dataManagerPage['business']['gallery'])>0  && $dataManagerPage['type']!=1)
                    <li><a href="#gallery">{{__('frontend.business-details.menu-top.two.title')}}</a></li>
                @endif
                @if(false)
                    <li><a href="#video">Video </a></li>
                @endif
                @if (env('allowProcessSuggestions'))


                    <li><a href="#reviews">{{__('frontend.business-details.menu-top.three.title')}}</a></li>
                @endif

            </ul>
        </nav>
        @if (env('allowProcessAddListing'))
            <a href="#" class="save-btn"> <i class="fa fa-heart"></i> Save </a>
        @endif
    </div>
</div>
