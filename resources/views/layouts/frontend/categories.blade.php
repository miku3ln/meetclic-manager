
<div class="category-area section-space--small">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="section-title-area text-center">
                    <h2 class="section-title"> {{__('sections.titles.categories')}}</h2>
                </div>
            </div>
        </div>

    </div>
</div>

<!--====================  End of category grid   ====================-->
<!--====================  banner grid area ====================-->

<div class="banner-area section-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                @if($dataCategoriesHtml !='')
                    <div class="banner-grid-wrapper">
                        {{$dataCategoriesHtml}}
                    </div>
                @else
                    <div class="empty-container">
                        <h3>{{__('messages.empty')}}</h3>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
