@include('cityBook.web.partials.businessDetails.topSlider')

@include('cityBook.web.partials.businessDetails.menuTop')

<section class="gray-section no-top-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="list-single-main-wrapper fl-wrap" id="details">
                    @include('cityBook.web.partials.businessDetails.breadCrumbs')
                    @include('cityBook.web.partials.businessDetails.trainers')
                    @include('cityBook.web.partials.businessDetails.countersDashboard')
                    @include('cityBook.web.partials.businessDetails.aboutUs')
                    @include('cityBook.web.partials.businessDetails.descriptions')
                    @include('cityBook.web.partials.businessDetails.gallery')
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
                    @include('cityBook.web.partials.businessDetails.workingHours')
                    @include('cityBook.web.partials.businessDetails.offer')
                    @include('cityBook.web.partials.businessDetails.addManagerUser')
                    @include('cityBook.web.partials.businessDetails.contactUs')
                    @include('cityBook.web.partials.businessDetails.hostedBy')
                    @include('cityBook.web.partials.businessDetails.employer')

                </div>
            </div>
            <!--box-widget-wrap end -->
        </div>
    </div>
</section>
<!--  section end -->
<div class="limit-box fl-wrap"></div>
