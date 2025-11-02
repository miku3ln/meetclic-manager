@if( isset($dataManagerPage['business']['adminReviews']))
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
                    <div class="listing-rating card-popup-rainingvis" data-starrating2="5"></div>
                    <div class="clearfix"></div>
                    <p>" Commodo est luctus eget. Proin in nunc laoreet justo volutpat blandit enim.
                        Sem felis, ullamcorper vel aliquam non, varius eget justo. Duis quis nunc
                        tellus sollicitudin mauris. "</p>
                    <span class="reviews-comments-item-date"><i class="fa fa-calendar-check-o"></i>27 May 2018</span>
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
                    <div class="listing-rating card-popup-rainingvis" data-starrating2="4"></div>
                    <div class="clearfix"></div>
                    <p>" Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla
                        consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec,
                        vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis
                        vitae, justo. Nullam dictum felis eu pede mollis pretium. "</p>
                    <span class="reviews-comments-item-date"><i class="fa fa-calendar-check-o"></i>12 April 2018</span>
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
                    <div class="listing-rating card-popup-rainingvis" data-starrating2="5"></div>
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
