@include('cityBook.web.partials.businessDetails.topSlider')

@include('cityBook.web.partials.businessDetails.menuTop')

<section class="gray-section no-top-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="list-single-main-wrapper fl-wrap" id="details">
                    @include('cityBook.web.partials.businessDetails.breadCrumbs')
                    @include('cityBook.web.partials.businessDetails.aboutUs')
                    @include('cityBook.web.partials.businessDetails.descriptions')
                    @include('cityBook.web.partials.businessDetails.gallery')
                    @include('cityBook.web.partials.businessDetails.prices')
                    @include('cityBook.web.partials.businessDetails.events')
                    @include('cityBook.web.partials.businessDetails.adminReviews')
                    @if (env('allowProcessSuggestions'))

                    @include('cityBook.web.partials.businessDetails.addReviews')
                @endif

                </div>
            </div>
            <!--box-widget-wrap -->
            <div class="col-md-4">
                <div class="box-widget-wrap">
                    <!--box-widget-item -->
                    <div class="box-widget-item fl-wrap">
                        <div class="box-widget-item-header">
                            <h3>Event Will Begin : </h3>
                        </div>
                        <div class="box-widget counter-widget gradient-bg" data-countDate="{{env('lauching') }}">
                            <div class="countdown fl-wrap">
                                <div class="countdown-item">
                                    <span class="days rot">00</span>
                                    <p>days</p>
                                </div>
                                <div class="countdown-item">
                                    <span class="hours rot">00</span>
                                    <p>hours </p>
                                </div>
                                <div class="countdown-item no-dec">
                                    <span class="minutes rot2">00</span>
                                    <p>minutes </p>
                                </div>
                                <div class="countdown-item-seconds">
                                    <span class="seconds rot2">00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('cityBook.web.partials.businessDetails.workingHours')
                    @include('cityBook.web.partials.businessDetails.addManagerUser')
                    @include('cityBook.web.partials.businessDetails.contactUs')
                    @include('cityBook.web.partials.businessDetails.ourInstagram')
                    @include('cityBook.web.partials.businessDetails.employer')

                </div>
            </div>
            <!--box-widget-wrap end -->
        </div>
    </div>
</section>
<!-- section end-->
<div class="limit-box fl-wrap"></div>
