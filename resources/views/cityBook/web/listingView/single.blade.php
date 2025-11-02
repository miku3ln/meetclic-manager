@include('cityBook.web.partials.businessDetails.topSlider')
@include('cityBook.web.partials.businessDetails.menuTop')

<section class="gray-section no-top-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <div class="list-single-main-wrapper fl-wrap" id="details">
                    @include('cityBook.web.partials.businessDetails.breadCrumbs')
                    <div class="list-single-header list-single-header-inside fl-wrap">
                        <div class="container">
                            <div class="list-single-header-item">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="list-single-header-item-opt fl-wrap">
                                            <div class="list-single-header-cat fl-wrap">
                                                <a
                                                    href="#">{{ $dataManagerPage['business']['information']->category }}</a>
                                            </div>
                                        </div>
                                        <h2>{{ $dataManagerPage['business']['information']->title }}
                                            <span> - Hosted By </span><a
                                                href="{{ $dataManagerPage['business']['information']->user->url }}">{{ $dataManagerPage['business']['information']->user->user_name }}</a>
                                        </h2>
                                        <span class="section-separator"></span>
                                        <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                            <span>(11 reviews)</span>
                                        </div>
                                        <div class="list-post-counter single-list-post-counter"><span>4</span><i
                                                class="fa fa-heart"></i></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="fl-wrap list-single-header-column">
                                            <span class="viewed-counter not-view"><i class="fa fa-eye">

                                                </i> Viewed - 156
                                            </span>
                                            <a class="custom-scroll-link not-view" href="#reviews">
                                                <i
                                                    class="fa fa-hand-o-right"></i>Add Review
                                            </a>
                                            <div class="share-holder hid-share">
                                                <div class="showshare"><span>Share </span><i class="fa fa-share"></i>
                                                </div>
                                                <div class="share-container  isShare">
                                                    <a v-for="network in networkShares" v-on:click="_shareType(network)"
                                                        v-bind:class="'pop pop--share share-icon '+network.icon">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('cityBook.web.partials.businessDetails.countersDashboard')

                    @include('cityBook.web.partials.businessDetails.aboutUs')
                    @include('cityBook.web.partials.businessDetails.video')
                    @include('cityBook.web.partials.businessDetails.descriptions')
                    @include('cityBook.web.partials.businessDetails.adminReviews')
                    @if (env('allowProcessSuggestions'))

                        @include('cityBook.web.partials.businessDetails.addReviews')
                    @endif

                </div>
            </div>

            <div class="col-md-4">
                <div class="box-widget-wrap">

                    @include('cityBook.web.partials.businessDetails.workingHours')
                    @include('cityBook.web.partials.businessDetails.addManagerUser')
                    @include('cityBook.web.partials.businessDetails.weather')
                    @include('cityBook.web.partials.businessDetails.contactUs')
                    @include('cityBook.web.partials.businessDetails.ourInstagram')
                    @include('cityBook.web.partials.businessDetails.hostedBy')
                    @include('cityBook.web.partials.businessDetails.employer')

                </div>
            </div>

        </div>
    </div>
</section>

<div class="limit-box fl-wrap"></div>
