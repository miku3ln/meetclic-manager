


@include($templateRoot.'.web.partials.businessDetails.topSlider',['templateRoot'=>$templateRoot])
@include($templateRoot.'.web.partials.businessDetails.menuTop',['templateRoot'=>$templateRoot])
<section class="gray-section no-top-padding">
    <div class="container">




        <div class="row" id="management-options-business">
            <div class="col-md-8">
                <div class="list-single-main-wrapper fl-wrap" id="details">
                @include($templateRoot.'.web.partials.businessDetails.breadCrumbs')
                @include($templateRoot.'.web.partials.businessDetails.countersDashboard')
                @include($templateRoot.'.web.partials.businessDetails.video')
                @include($templateRoot.'.web.partials.businessDetails.aboutUs')
                @include($templateRoot.'.web.partials.businessDetails.descriptions')
                @include($templateRoot.'.web.partials.businessDetails.gallery')


                <!-- list-single-main-item end -->
                    <!-- list-single-main-item -->
                    @if( isset($dataManagerPage['business']['reviews']))

                        <div class="list-single-main-item fl-wrap" id="sec4">
                            <div class="list-single-main-item-title fl-wrap">
                                <h3>Item Reviews - <span> 3 </span></h3>
                            </div>
                            <div class="reviews-comments-wrap">
                                <!-- reviews-comments-item -->
                                <div class="reviews-comments-item">
                                    <div class="review-comments-avatar">
                                        <img src="{{ URL::asset($themePath.'images/avatar/1.jpg')}}" alt="">
                                    </div>
                                    <div class="reviews-comments-item-text">
                                        <h4><a href="#">Jessie Manrty</a></h4>
                                        <div class="listing-rating card-popup-rainingvis"
                                             data-starrating2="5"></div>
                                        <div class="clearfix"></div>
                                        <p>" Commodo est luctus eget. Proin in nunc laoreet justo volutpat blandit
                                            enim. Sem felis, ullamcorper vel aliquam non, varius eget justo. Duis
                                            quis nunc tellus sollicitudin mauris. "</p>
                                        <span class="reviews-comments-item-date"><i
                                                class="fa fa-calendar-check-o"></i>27 May 2018</span>
                                    </div>
                                </div>
                                <!--reviews-comments-item end-->
                                <!-- reviews-comments-item -->
                                <div class="reviews-comments-item">
                                    <div class="review-comments-avatar">
                                        <img src="{{ URL::asset($themePath.'images/avatar/2.jpg')}}" alt="">
                                    </div>
                                    <div class="reviews-comments-item-text">
                                        <h4><a href="#">Mark Rose</a></h4>
                                        <div class="listing-rating card-popup-rainingvis"
                                             data-starrating2="4"></div>
                                        <div class="clearfix"></div>
                                        <p>" Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
                                            Nulla consequat massa quis enim. Donec pede justo, fringilla vel,
                                            aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet
                                            a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.
                                            "</p>
                                        <span class="reviews-comments-item-date"><i
                                                class="fa fa-calendar-check-o"></i>12 April 2018</span>
                                    </div>
                                </div>
                                <!--reviews-comments-item end-->
                                <!-- reviews-comments-item -->
                                <div class="reviews-comments-item">
                                    <div class="review-comments-avatar">
                                        <img src="{{ URL::asset($themePath.'images/avatar/3.jpg')}}" alt="">
                                    </div>
                                    <div class="reviews-comments-item-text">
                                        <h4><a href="#">Adam Koncy</a></h4>
                                        <div class="listing-rating card-popup-rainingvis"
                                             data-starrating2="5"></div>
                                        <div class="clearfix"></div>
                                        <p>" Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc posuere
                                            convallis purus non cursus. Cras metus neque, gravida sodales massa ut.
                                            "</p>
                                        <span class="reviews-comments-item-date"><i
                                                class="fa fa-calendar-check-o"></i>03 December 2017</span>
                                    </div>
                                </div>
                                <!--reviews-comments-item end-->
                            </div>
                        </div>
                    @endif
                    @if (env('allowProcessSuggestions'))

                    @include($templateRoot.'.web.partials.businessDetails.addReviews')
                @endif

                </div>
            </div>
            <!--box-widget-wrap -->
            <div class="col-md-4">

                <div class="box-widget-wrap">
                @include($templateRoot.'.web.partials.businessDetails.workingHours')
                <!--box-widget-item end -->
                    <!--box-widget-item -->
                    @if( isset($dataManagerPage['business']['booking']))

                        <div class="box-widget-item fl-wrap">
                            <div class="box-widget-item-header">
                                <h3>Book a Table Online : </h3>
                            </div>
                            <div class="box-widget opening-hours">
                                <div class="box-widget-content">
                                    <form class="add-comment custom-form">
                                        <fieldset>
                                            <label><i class="fa fa-user-o"></i></label>
                                            <input type="text" placeholder="Your Name *" value=""/>
                                            <div class="clearfix"></div>
                                            <label><i class="fa fa-envelope-o"></i> </label>
                                            <input type="text" placeholder="Email Address*" value=""/>
                                            <div class="quantity fl-wrap">
                                                <span><i class="fa fa-user-plus"></i>Persons : </span>
                                                <div class="quantity-item">
                                                    <input type="button" value="-" class="minus">
                                                    <input type="text" name="quantity" title="Qty" class="qty"
                                                           min="1" max="3" step="1" value="1">
                                                    <input type="button" value="+" class="plus">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label><i class="fa fa-calendar-check-o"></i> </label>
                                                    <input type="text" placeholder="Date" class="datepicker"
                                                           data-large-mode="true" data-large-default="true"
                                                           value=""/>
                                                </div>
                                                <div class="col-md-6">
                                                    <label><i class="fa fa-clock-o"></i> </label>
                                                    <input type="text" placeholder="Time" class="timepicker"
                                                           value="12:00 am"/>
                                                </div>
                                            </div>
                                            <textarea cols="40" rows="3"
                                                      placeholder="Additional Information:"></textarea>
                                        </fieldset>
                                        <button class="btn  big-btn  color-bg flat-btn book-btn">Book Now<i
                                                class="fa fa-angle-right"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    @include($templateRoot.'.web.partials.businessDetails.contactUs')
                    @include($templateRoot.'.web.partials.businessDetails.ourInstagram')
                    @include($templateRoot.'.web.partials.businessDetails.hostedBy')
                    @include($templateRoot.'.web.partials.businessDetails.employer')

                </div>
            </div>
            <!--box-widget-wrap end -->
        </div>


            <div class="limit-box fl-wrap"></div>

    </div>
</section>
<!--  section end -->
<div class="limit-box fl-wrap"></div>

