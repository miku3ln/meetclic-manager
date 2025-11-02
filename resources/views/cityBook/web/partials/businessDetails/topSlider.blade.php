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


if ($counterReviews > 1 ||$counterReviews ==0) {

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
if ($counterViews > 1 ||$counterViews ==0) {

    $counterViewsResult = $counterViews . ' ' . __('frontend.actions.view') . 's';

} else {
    $counterViewsResult = $counterViews . ' ' . __('frontend.actions.view');

}



if (isset($dataManagerPage['business']['counters']['rating']['count'])) {
    $counterRating = $dataManagerPage['business']['counters']['rating']['count']==0?1: $dataManagerPage['business']['counters']['rating']['count'];

}
if ($counterRating > 1) {


}


if (isset($dataManagerPage['business']['counters']['hearth']['count'])) {
    $counterHeart = $dataManagerPage['business']['counters']['hearth']['count'];

}
if ($counterHearth > 1) {


} else {


}
$urlCurrentSearch=route('search',app()->getLocale());
?>

@if(isset($dataManagerPage['type']))
    @if($dataManagerPage['type']==2)
        <section class="parallax-section single-par list-single-section" data-scrollax-parent="true" id="slider">
            <div class="bg par-elem " data-bg="{{ $dataManagerPage['business']['information']->srcMain}}"
                 data-scrollax="properties: { translateY: '30%' }"></div>
            <div class="overlay"></div>
            <div class="bubble-bg"></div>
            <div class="list-single-header absolute-header fl-wrap">
                <div class="container">
                    <div class="list-single-header-item">
                        <div class="list-single-header-item-opt fl-wrap">
                            <div class="list-single-header-cat fl-wrap">
                                <a href="{{$urlCurrentSearch.'?category='.$dataManagerPage['business']['information']->category_id}}">{{ $dataManagerPage['business']['information']->category.' - '.$dataManagerPage['business']['information']->subcategory}}</a>
                                <span class="{{$dataManagerPage['business']['information']->statusOpen?'business-information-status-open':'business-information-status-close'}}">
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

                            <span>({{$counterReviewsResult}})</span>
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
                                                href="tel:{{ $dataManagerPage['business']['contactUs']->email }}">{{ $dataManagerPage['business']['contactUs']->phone}}</a></li>
                                        <li><i class="fa fa-map-marker"></i><a
                                               >{{ $dataManagerPage['business']['contactUs']->address}}</a>
                                        </li>
                                        <li><i class="fa fa-envelope-o"></i><a
                                                href="mailto:{{ $dataManagerPage['business']['contactUs']->email }}">{{ $dataManagerPage['business']['contactUs']->email}}</a></li>
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
    @elseif($dataManagerPage['type']==1)
        <!--  carousel-->
        <div class="list-single-carousel-wrap fl-wrap" id="slider">
            <div class="fw-carousel fl-wrap full-height lightgallery">
                <!-- slick-slide-item -->
                <div class="slick-slide-item">
                    <div class="box-item">
                        <img src="{{ $dataManagerPage['business']['information']->srcMain}}" alt="">
                        <a href="{{ $dataManagerPage['business']['information']->srcMain}}"
                           class="gal-link popup-image">
                            <i class="fa fa-search"></i>
                        </a>
                    </div>

                </div>
                @if( isset($dataManagerPage['business']['gallery']) )
                    @foreach ($dataManagerPage['business']['gallery'] as $gallery)
                        <div class="slick-slide-item">
                            <div class="box-item">
                                <img src="{{$gallery->src}}" alt="{{$gallery->text}}">
                                <a href="{{$gallery->src}}" class="gal-link popup-image">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>

                        </div>
                    @endforeach
                @endif
            </div>
            <div class="swiper-button-prev sw-btn"><i class="fa fa-long-arrow-left"></i></div>
            <div class="swiper-button-next sw-btn"><i class="fa fa-long-arrow-right"></i></div>
        </div>
    @elseif($dataManagerPage['type']==3)
        <section class="parallax-section single-par list-single-section" id="slider">
            <div class="media-container video-parallax">
                <div class="bg mob-bg"
                     style="background-image: url({{ URL::asset($themePath.'images/bg/12.jpg')}})"></div>
                <div class="video-container">
                    <video autoplay loop muted class="bgvid">
                        <source src="{{ URL::asset($themePath.'video/3.mp4')}}" type="video/mp4">
                    </video>
                </div>
            </div>
            <div class="overlay"></div>
            <div class="bubble-bg"></div>
            <div class="list-single-header absolute-header fl-wrap">
                <div class="container">
                    <div class="list-single-header-item">
                        <div class="list-single-header-item-opt fl-wrap">
                            <div class="list-single-header-cat fl-wrap">
                                <a href="#">{{ $dataManagerPage['business']['information']->category}}</a>
                                <span>      {{__('frontend.business-details.now')}} {{$dataManagerPage['business']['information']->statusOpen?__('frontend.actions.opened') :__('frontend.actions.closed')}}

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

                            <span>({{$counterReviewsResult}})</span>
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
                                                href="tel://{{ $dataManagerPage['business']['contactUs']->phone}}">{{ $dataManagerPage['business']['contactUs']->phone}}</a></li>
                                        <li><i class="fa fa-map-marker"></i><a
                                                >{{ $dataManagerPage['business']['contactUs']->address}}</a>
                                        </li>
                                        <li><i class="fa fa-envelope-o"></i><a
                                                href="#">{{ $dataManagerPage['business']['contactUs']->email}}</a></li>
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
    @elseif($dataManagerPage['type']==4)

        <section class="parallax-section single-par list-single-section" data-scrollax-parent="true" id="slider">
            <div class="slideshow-container" data-scrollax="properties: { translateY: '200px' }">

                <div class="slideshow-item">
                    <div class="bg" data-bg="{{ $dataManagerPage['business']['information']->srcMain}}"></div>
                </div>

            </div>
            <div class="overlay"></div>
            <div class="bubble-bg"></div>
            <div class="list-single-header absolute-header fl-wrap">
                <div class="container">
                    <div class="list-single-header-item">
                        <div class="list-single-header-item-opt fl-wrap">
                            <div class="list-single-header-cat fl-wrap">
                                <a href="#">{{ $dataManagerPage['business']['information']->title}}</a>
                                <span>
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

                            <span>({{$counterReviewsResult}})</span>
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
                                                href="#">{{ $dataManagerPage['business']['contactUs']->phone}}</a></li>
                                        <li><i class="fa fa-map-marker"></i><a
                                                href="#">{{ $dataManagerPage['business']['contactUs']->address}}</a>
                                        </li>
                                        <li><i class="fa fa-envelope-o"></i><a
                                                href="#">{{ $dataManagerPage['business']['contactUs']->email}}</a></li>
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
    @endif
@endif
