<?php
$counterReviews = 0;
$counterViews = 0;
$counterViewsResult = '';

$counterRating = 1;
$counterHearth = 0;

$counterReviewsResult = '';
$counterHeartResult = '';

$counterRatingResult = '';

if (isset($dataManagerPage['business']['counters']['reviews']['count'])) {
    $counterReviews = $dataManagerPage['business']['counters']['reviews']['count'];

}


if ($counterReviews > 1 || $counterReviews == 0) {

    $counterReviewsResult = $counterReviews . ' ' . __('frontend.actions.review') . 's';

} else {
    $counterReviewsResult = $counterReviews . ' ' . __('frontend.actions.review');

}

if (isset($dataManagerPage['business']['counters']['reviews']['count'])) {
    $counterReviews = $dataManagerPage['business']['counters']['reviews']['count'];

}

if (isset($dataManagerPage['business']['counters']['views']['count'])) {
    $counterViews = $dataManagerPage['business']['counters']['views']['count'];

}
if ($counterViews > 1 || $counterViews == 0) {

    $counterViewsResult = $counterViews . ' ' . __('frontend.actions.view') . 's';

} else {
    $counterViewsResult = $counterViews . ' ' . __('frontend.actions.view');

}



if (isset($dataManagerPage['business']['counters']['rating']['count'])) {
    $counterRating = $dataManagerPage['business']['counters']['rating']['count'] == 0 ? 1 : $dataManagerPage['business']['counters']['rating']['count'];

}
if ($counterRating > 1) {


}


if (isset($dataManagerPage['business']['counters']['hearth']['count'])) {
    $counterHeart = $dataManagerPage['business']['counters']['hearth']['count'];

}
if ($counterHearth > 1) {


} else {


}
$urlCurrentSearch = route('search', app()->getLocale());
$htmlLinkRate = "";

if (isset($dataManagerPage["dataConfigGamificationBusiness"])&&$dataManagerPage["dataConfigGamificationBusiness"]["VIEW_RATE_WEB_MC"]["success"]) {
    $htmlLinkRate = $dataManagerPage["dataConfigGamificationBusiness"]["VIEW_RATE_WEB_MC"]["data"]->url_manager;

} else {
    $htmlLinkRate = $dataManagerPage["dataConfigGamificationBusiness"]["VIEW_RATE_WEB_MC"]["urlDefault"];

}

?>

<section class="parallax-section single-par list-single-section" data-scrollax-parent="true" id="slider">
    <div class="bg par-elem " data-bg="{{ $dataManagerPage['business']['information']->srcMain}}"

         data-scrollax="properties: { translateY: '30%' }"
         style="
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center center;
     "
    ></div>
    <div class="overlay"></div>
    <div class="bubble-bg"></div>
    <div class="list-single-header absolute-header fl-wrap">
        <div class="container">
            <div class="list-single-header-item">
                <div class="list-single-header-item-opt fl-wrap">
                    <div class="list-single-header-cat fl-wrap">
                        <a href="{{$urlCurrentSearch.'?category='.$dataManagerPage['business']['information']->category_id}}">{{ $dataManagerPage['business']['information']->category.' - '.$dataManagerPage['business']['information']->subcategory}}</a>
                        <span
                            class="{{$dataManagerPage['business']['information']->statusOpen?'business-information-status-open':'business-information-status-close'}}">
                                    {{__('frontend.business-details.now')}} {{$dataManagerPage['business']['information']->statusOpen?__('frontend.actions.opened') :__('frontend.actions.closed')}}

                                    <i class="{{$dataManagerPage['business']['information']->statusOpen?'fa fa-check':'fa fa-window-close-o'}}"></i>
                                </span>
                    </div>
                </div>
                <h2>{{ $dataManagerPage['business']['information']->title}}
                    <span> -  {{__('frontend.actions.host')}}</span><a
                        href="  {{$dataManagerPage['business']['information']->user->url}}">  {{$dataManagerPage['business']['information']->user->user_name}}</a>
                </h2>
                <span class="section-separator"></span>
                <div class="listing-rating card-popup-rainingvis" data-starrating2="{{$counterRating}}">

                    <span><a href="{{$htmlLinkRate}}" target="_blank">{{$counterReviewsResult}} </a></span>
                </div>

                <div class="list-post-counter single-list-post-counter"><span>{{$counterHearth}}</span><i
                        class="fa fa-heart"></i>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="list-single-header-contacts fl-wrap">
                            <ul>
                                <li><i class="fa fa-phone"></i><a
                                        href="tel:{{ $dataManagerPage['business']['contactUs']->email }}">{{ $dataManagerPage['business']['contactUs']->phone}}</a>
                                </li>
                                <li><i class="fa fa-map-marker"></i><a
                                    >{{ $dataManagerPage['business']['contactUs']->address}}</a>
                                </li>
                                <li><i class="fa fa-envelope-o"></i><a
                                        href="mailto:{{ $dataManagerPage['business']['contactUs']->email }}">{{ $dataManagerPage['business']['contactUs']->email}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="fl-wrap list-single-header-column">
                            @include('cityBook.web.partials.businessDetails.shareOptions')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
