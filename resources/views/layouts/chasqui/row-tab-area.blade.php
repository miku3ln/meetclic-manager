

<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>

<!--====================  product double row tab area ====================-->

<div class="product-double-row-tab-area section-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="product-double-row-tab-wrapper">
                    <!--=======  tab product navigation  =======-->

                    <div class="tab-product-navigation">
                        <div class="nav nav-tabs justify-content-center" id="nav-tab2" role="tablist">
                            <a class="nav-item nav-link active" id="product-tab-1" data-toggle="tab"
                               href="#product-series-1" role="tab" aria-selected="true">New Arrivals</a>
                            <a class="nav-item nav-link" id="product-tab-2" data-toggle="tab" href="#product-series-2"
                               role="tab" aria-selected="false">Featured</a>
                            <a class="nav-item nav-link" id="product-tab-3" data-toggle="tab" href="#product-series-3"
                               role="tab" aria-selected="false">On Sale</a>
                        </div>
                    </div>

                    <!--=======  End of tab product navigation  =======-->

                    <!--=======  tab product content  =======-->

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="product-series-1" role="tabpanel"
                             aria-labelledby="product-tab-1">
                            <!--=======  product row wrapper  =======-->

                            <div class="product-row-wrapper">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="onsale">-17%</span>
                                                    <span class="hot">Hot</span>
                                                </div>
                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-9-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-9-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Lighting Lamp</a>
                                                </h3>
                                                <div class="price"><span class="main-price discounted">$145</span> <span
                                                        class="discounted-price">$110</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="color">
                                                    <ul>
                                                        <li><a class="active" href="#" data-tippy="Black"
                                                               data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker black"></span></a></li>
                                                        <li><a href="#" data-tippy="Blue" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker blue"></span></a></li>
                                                        <li><a href="#" data-tippy="Brown" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker brown"></span></a></li>
                                                    </ul>
                                                </div>
                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">

                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-10-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Jane Lauren
                                                        Design Chair</a></h3>
                                                <div class="price"><span class="main-price">$98</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>

                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="hot">Hot</span>
                                                </div>
                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-11-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-11-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Jane Lauren
                                                        Gregory Chair</a></h3>
                                                <div class="price"><span class="main-price discounted">$125</span> <span
                                                        class="discounted-price">$90</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>

                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="onsale">-10%</span>
                                                </div>
                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-12-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-12-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Candice Desk
                                                        Lamp</a></h3>
                                                <div class="price"><span class="main-price">$100</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>

                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">

                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-13-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-13-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Ovora Step
                                                        stool</a></h3>
                                                <div class="price"><span class="main-price discounted">$185</span> <span
                                                        class="discounted-price">$140</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="color">
                                                    <ul>
                                                        <li><a class="active" href="#" data-tippy="Black"
                                                               data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker black"></span></a></li>
                                                        <li><a href="#" data-tippy="Blue" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker blue"></span></a></li>
                                                        <li><a href="#" data-tippy="Brown" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker brown"></span></a></li>
                                                    </ul>
                                                </div>
                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="onsale">-17%</span>
                                                    <span class="hot">Hot</span>
                                                </div>
                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-14-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-14-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Jane Lauren
                                                        Carson Chair</a></h3>
                                                <div class="price"><span class="main-price">$145</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>

                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="onsale">-17%</span>
                                                    <span class="hot">Hot</span>
                                                </div>
                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-15-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-15-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Alexa Classic
                                                        Towels</a></h3>
                                                <div class="price"><span class="main-price discounted">$14</span> <span
                                                        class="discounted-price">$11</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="color">
                                                    <ul>
                                                        <li><a class="active" href="#" data-tippy="Black"
                                                               data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker black"></span></a></li>
                                                        <li><a href="#" data-tippy="Blue" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker blue"></span></a></li>
                                                        <li><a href="#" data-tippy="Brown" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker brown"></span></a></li>
                                                    </ul>
                                                </div>
                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">

                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-16-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-16-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Olivia Shayn
                                                        Cover Chair</a></h3>
                                                <div class="price"><span class="main-price">$98</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>

                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>

                                </div>
                            </div>

                            <!--=======  End of product row wrapper  =======-->
                        </div>

                        <div class="tab-pane fade" id="product-series-2" role="tabpanel"
                             aria-labelledby="product-tab-2">

                            <!--=======  product row wrapper  =======-->

                            <div class="product-row-wrapper">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">

                                                <div class="product-badge-wrapper">
                                                    <span class="hot">Hot</span>
                                                </div>

                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-13-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-13-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Ovora Step
                                                        stool</a></h3>
                                                <div class="price"><span class="main-price discounted">$185</span> <span
                                                        class="discounted-price">$140</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="color">
                                                    <ul>
                                                        <li><a class="active" href="#" data-tippy="Black"
                                                               data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker black"></span></a></li>
                                                        <li><a href="#" data-tippy="Blue" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker blue"></span></a></li>
                                                        <li><a href="#" data-tippy="Brown" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker brown"></span></a></li>
                                                    </ul>
                                                </div>
                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="hot">Hot</span>
                                                </div>
                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-14-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-14-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Jane Lauren
                                                        Carson Chair</a></h3>
                                                <div class="price"><span class="main-price">$145</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>

                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="hot">Hot</span>
                                                </div>
                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-15-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-15-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Alexa Classic
                                                        Towels</a></h3>
                                                <div class="price"><span class="main-price discounted">$14</span> <span
                                                        class="discounted-price">$11</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="color">
                                                    <ul>
                                                        <li><a class="active" href="#" data-tippy="Black"
                                                               data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker black"></span></a></li>
                                                        <li><a href="#" data-tippy="Blue" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker blue"></span></a></li>
                                                        <li><a href="#" data-tippy="Brown" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker brown"></span></a></li>
                                                    </ul>
                                                </div>
                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">

                                                <div class="product-badge-wrapper">
                                                    <span class="hot">Hot</span>
                                                </div>

                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-16-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-16-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Olivia Shayn
                                                        Cover Chair</a></h3>
                                                <div class="price"><span class="main-price">$98</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>

                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="hot">Hot</span>
                                                </div>
                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-9-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-9-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Lighting Lamp</a>
                                                </h3>
                                                <div class="price"><span class="main-price discounted">$145</span> <span
                                                        class="discounted-price">$110</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="color">
                                                    <ul>
                                                        <li><a class="active" href="#" data-tippy="Black"
                                                               data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker black"></span></a></li>
                                                        <li><a href="#" data-tippy="Blue" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker blue"></span></a></li>
                                                        <li><a href="#" data-tippy="Brown" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker brown"></span></a></li>
                                                    </ul>
                                                </div>
                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">

                                                <div class="product-badge-wrapper">
                                                    <span class="hot">Hot</span>
                                                </div>

                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-10-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Jane Lauren
                                                        Design Chair</a></h3>
                                                <div class="price"><span class="main-price">$98</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>

                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="hot">Hot</span>
                                                </div>
                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-11-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-11-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Jane Lauren
                                                        Gregory Chair</a></h3>
                                                <div class="price"><span class="main-price discounted">$125</span> <span
                                                        class="discounted-price">$90</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>

                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="hot">Hot</span>
                                                </div>
                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-12-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-12-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Candice Desk
                                                        Lamp</a></h3>
                                                <div class="price"><span class="main-price">$100</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>

                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                </div>
                            </div>

                            <!--=======  End of product row wrapper  =======-->

                        </div>

                        <div class="tab-pane fade" id="product-series-3" role="tabpanel"
                             aria-labelledby="product-tab-3">
                            <!--=======  product row wrapper  =======-->

                            <div class="product-row-wrapper">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="onsale">-15%</span>
                                                </div>

                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-16-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-16-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Olivia Shayn
                                                        Cover Chair</a></h3>
                                                <div class="price"><span class="main-price">$98</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>

                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="onsale">-20%</span>
                                                </div>
                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{URL::asset($resourcePathServer.'frontend/assets/img/products/product-9-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-9-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Lighting Lamp</a>
                                                </h3>
                                                <div class="price"><span class="main-price discounted">$145</span> <span
                                                        class="discounted-price">$110</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="color">
                                                    <ul>
                                                        <li><a class="active" href="#" data-tippy="Black"
                                                               data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker black"></span></a></li>
                                                        <li><a href="#" data-tippy="Blue" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker blue"></span></a></li>
                                                        <li><a href="#" data-tippy="Brown" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker brown"></span></a></li>
                                                    </ul>
                                                </div>
                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">

                                                <div class="product-badge-wrapper">
                                                    <span class="onsale">-30%</span>
                                                </div>

                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-10-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Jane Lauren
                                                        Design Chair</a></h3>
                                                <div class="price"><span class="main-price">$98</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>

                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="onsale">-10%</span>
                                                </div>
                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-13-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-13-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Ovora Step
                                                        stool</a></h3>
                                                <div class="price"><span class="main-price discounted">$185</span> <span
                                                        class="discounted-price">$140</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="color">
                                                    <ul>
                                                        <li><a class="active" href="#" data-tippy="Black"
                                                               data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker black"></span></a></li>
                                                        <li><a href="#" data-tippy="Blue" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker blue"></span></a></li>
                                                        <li><a href="#" data-tippy="Brown" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker brown"></span></a></li>
                                                    </ul>
                                                </div>
                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="onsale">-20%</span>
                                                </div>
                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-14-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-14-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Jane Lauren
                                                        Carson Chair</a></h3>
                                                <div class="price"><span class="main-price">$145</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>

                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="onsale">-20%</span>
                                                </div>
                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-15-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-15-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Alexa Classic
                                                        Towels</a></h3>
                                                <div class="price"><span class="main-price discounted">$14</span> <span
                                                        class="discounted-price">$11</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="color">
                                                    <ul>
                                                        <li><a class="active" href="#" data-tippy="Black"
                                                               data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker black"></span></a></li>
                                                        <li><a href="#" data-tippy="Blue" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker blue"></span></a></li>
                                                        <li><a href="#" data-tippy="Brown" data-tippy-inertia="true"
                                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                                               data-tippy-arrow="true"
                                                               data-tippy-theme="roundborder"><span
                                                                    class="color-picker brown"></span></a></li>
                                                    </ul>
                                                </div>
                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="onsale">-5%</span>
                                                </div>

                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-11-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-11-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Jane Lauren
                                                        Gregory Chair</a></h3>
                                                <div class="price"><span class="main-price discounted">$125</span> <span
                                                        class="discounted-price">$90</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>

                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-custom-sm-6">
                                        <!--=======  single short view product  =======-->

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper">
                                                    <span class="onsale">-10%</span>
                                                </div>
                                                <a href="product-details-basic.html" class="image-wrap">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-12-1-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                    <img
                                                        src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-12-2-270x360.jpg')}}"
                                                        class="img-fluid" alt="">
                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                    <span class="single-icon single-icon--quick-view"><a
                                                            class="cd-trigger" href="#qv-1" data-tippy="Quick View"
                                                            data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                            data-tippy-delay="50" data-tippy-arrow="true"
                                                            data-tippy-theme="sharpborder"><i class="fa fa-search"></i></a></span>
                                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                          data-tippy="Add to cart"
                                                                                                          data-tippy-inertia="true"
                                                                                                          data-tippy-animation="shift-away"
                                                                                                          data-tippy-delay="50"
                                                                                                          data-tippy-arrow="true"
                                                                                                          data-tippy-theme="sharpborder"><i
                                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                                    <span class="single-icon single-icon--compare"><a href="#"
                                                                                                      data-tippy="Compare"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                                class="fa fa-exchange"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title"><a href="product-details-basic.html">Candice Desk
                                                        Lamp</a></h3>
                                                <div class="price"><span class="main-price">$100</span></div>
                                                <div class="rating">
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>

                                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist"
                                                   data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                   data-tippy-delay="50" data-tippy-arrow="true"
                                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!--=======  End of single short view product  =======-->
                                    </div>
                                </div>
                            </div>

                            <!--=======  End of product row wrapper  =======-->
                        </div>

                    </div>

                    <!--=======  End of tab product content  =======-->
                </div>
            </div>
        </div>
    </div>
</div>

<!--====================  End of product double row tab area  ====================-->


<!--====================  product slider area ====================-->

<div class="product-slider-area section-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="section-title-area text-center">
                    <h2 class="section-title">Top Interiors</h2>
                    <p class="section-subtitle">Complete your home with Robin’s top Interiors collection. Whether you
                        need to decorate a new space or are ready to replace the family’s well-loved couch</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!--=======  product slider wrapper  =======-->

                <div class="product-slider-wrapper theme-slick-slider" data-slick-setting='{
                        "slidesToShow": 4,
                        "slidesToScroll": 4,
                        "arrows": true,
                        "dots": true,
                        "autoplay": false,
                        "speed": 500,
                        "prevArrow": {"buttonClass": "slick-prev", "iconClass": "fa fa-angle-left" },
                        "nextArrow": {"buttonClass": "slick-next", "iconClass": "fa fa-angle-right" }
                    }' data-slick-responsive='[
                        {"breakpoint":1501, "settings": {"slidesToShow": 4, "slidesToScroll": 4, "arrows": false} },
                        {"breakpoint":1199, "settings": {"slidesToShow": 3, "slidesToScroll": 3, "arrows": false} },
                        {"breakpoint":991, "settings": {"slidesToShow": 2,"slidesToScroll": 2, "arrows": true, "dots": false} },
                        {"breakpoint":767, "settings": {"slidesToShow": 2,"slidesToScroll": 2,  "arrows": true, "dots": false} },
                        {"breakpoint":575, "settings": {"slidesToShow": 2, "slidesToScroll": 2,"arrows": false, "dots": true} },
                        {"breakpoint":479, "settings": {"slidesToShow": 1,"slidesToScroll": 1, "arrows": true, "dots": false} }
                    ]'>

                    <div class="col">
                        <!--=======  single short view product  =======-->

                        <div class="single-grid-product">
                            <div class="single-grid-product__image">
                                <div class="product-badge-wrapper">
                                    <span class="onsale">-17%</span>
                                    <span class="hot">Hot</span>
                                </div>
                                <a href="product-details-basic.html" class="image-wrap">
                                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-9-1-600x800.jpg')}}"
                                         class="img-fluid" alt="">
                                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-9-2-600x800.jpg')}}"
                                         class="img-fluid" alt="">
                                </a>
                                <div class="product-hover-icon-wrapper">
                                    <span class="single-icon single-icon--quick-view"><a class="cd-trigger" href="#qv-1"
                                                                                         data-tippy="Quick View"
                                                                                         data-tippy-inertia="true"
                                                                                         data-tippy-animation="shift-away"
                                                                                         data-tippy-delay="50"
                                                                                         data-tippy-arrow="true"
                                                                                         data-tippy-theme="sharpborder"><i
                                                class="fa fa-search"></i></a></span>
                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                          data-tippy="Add to cart"
                                                                                          data-tippy-inertia="true"
                                                                                          data-tippy-animation="shift-away"
                                                                                          data-tippy-delay="50"
                                                                                          data-tippy-arrow="true"
                                                                                          data-tippy-theme="sharpborder"><i
                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                    <span class="single-icon single-icon--compare"><a href="#" data-tippy="Compare"
                                                                                      data-tippy-inertia="true"
                                                                                      data-tippy-animation="shift-away"
                                                                                      data-tippy-delay="50"
                                                                                      data-tippy-arrow="true"
                                                                                      data-tippy-theme="sharpborder"><i
                                                class="fa fa-exchange"></i></a></span>
                                </div>
                            </div>
                            <div class="single-grid-product__content">
                                <h3 class="title"><a href="product-details-basic.html">Lighting Lamp</a></h3>
                                <div class="price"><span class="main-price discounted">$145</span> <span
                                        class="discounted-price">$110</span></div>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="color">
                                    <ul>
                                        <li><a class="active" href="#" data-tippy="Black" data-tippy-inertia="true"
                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                               data-tippy-arrow="true" data-tippy-theme="roundborder"><span
                                                    class="color-picker black"></span></a></li>
                                        <li><a href="#" data-tippy="Blue" data-tippy-inertia="true"
                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                               data-tippy-arrow="true" data-tippy-theme="roundborder"><span
                                                    class="color-picker blue"></span></a></li>
                                        <li><a href="#" data-tippy="Brown" data-tippy-inertia="true"
                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                               data-tippy-arrow="true" data-tippy-theme="roundborder"><span
                                                    class="color-picker brown"></span></a></li>
                                    </ul>
                                </div>
                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist" data-tippy-inertia="true"
                                   data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"
                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                    <i class="fa fa-heart-o"></i>
                                    <i class="fa fa-heart"></i>
                                </a>
                            </div>
                        </div>

                        <!--=======  End of single short view product  =======-->
                    </div>

                    <div class="col">
                        <!--=======  single short view product  =======-->

                        <div class="single-grid-product">
                            <div class="single-grid-product__image">

                                <a href="product-details-basic.html" class="image-wrap">
                                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-10-1-600x800.jpg')}}"
                                         class="img-fluid" alt="">
                                </a>
                                <div class="product-hover-icon-wrapper">
                                    <span class="single-icon single-icon--quick-view"><a class="cd-trigger" href="#qv-1"
                                                                                         data-tippy="Quick View"
                                                                                         data-tippy-inertia="true"
                                                                                         data-tippy-animation="shift-away"
                                                                                         data-tippy-delay="50"
                                                                                         data-tippy-arrow="true"
                                                                                         data-tippy-theme="sharpborder"><i
                                                class="fa fa-search"></i></a></span>
                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                          data-tippy="Add to cart"
                                                                                          data-tippy-inertia="true"
                                                                                          data-tippy-animation="shift-away"
                                                                                          data-tippy-delay="50"
                                                                                          data-tippy-arrow="true"
                                                                                          data-tippy-theme="sharpborder"><i
                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                    <span class="single-icon single-icon--compare"><a href="#" data-tippy="Compare"
                                                                                      data-tippy-inertia="true"
                                                                                      data-tippy-animation="shift-away"
                                                                                      data-tippy-delay="50"
                                                                                      data-tippy-arrow="true"
                                                                                      data-tippy-theme="sharpborder"><i
                                                class="fa fa-exchange"></i></a></span>
                                </div>
                            </div>
                            <div class="single-grid-product__content">
                                <h3 class="title"><a href="product-details-basic.html">Jane Lauren Design Chair</a></h3>
                                <div class="price"><span class="main-price">$98</span></div>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                </div>

                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist" data-tippy-inertia="true"
                                   data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"
                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                    <i class="fa fa-heart-o"></i>
                                    <i class="fa fa-heart"></i>
                                </a>
                            </div>
                        </div>

                        <!--=======  End of single short view product  =======-->
                    </div>

                    <div class="col">
                        <!--=======  single short view product  =======-->

                        <div class="single-grid-product">
                            <div class="single-grid-product__image">
                                <div class="product-badge-wrapper">
                                    <span class="hot">Hot</span>
                                </div>
                                <a href="product-details-basic.html" class="image-wrap">
                                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-11-1-600x800.jpg')}}"
                                         class="img-fluid" alt="">
                                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-11-2-600x800.jpg')}}"
                                         class="img-fluid" alt="">
                                </a>
                                <div class="product-hover-icon-wrapper">
                                    <span class="single-icon single-icon--quick-view"><a class="cd-trigger" href="#qv-1"
                                                                                         data-tippy="Quick View"
                                                                                         data-tippy-inertia="true"
                                                                                         data-tippy-animation="shift-away"
                                                                                         data-tippy-delay="50"
                                                                                         data-tippy-arrow="true"
                                                                                         data-tippy-theme="sharpborder"><i
                                                class="fa fa-search"></i></a></span>
                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                          data-tippy="Add to cart"
                                                                                          data-tippy-inertia="true"
                                                                                          data-tippy-animation="shift-away"
                                                                                          data-tippy-delay="50"
                                                                                          data-tippy-arrow="true"
                                                                                          data-tippy-theme="sharpborder"><i
                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                    <span class="single-icon single-icon--compare"><a href="#" data-tippy="Compare"
                                                                                      data-tippy-inertia="true"
                                                                                      data-tippy-animation="shift-away"
                                                                                      data-tippy-delay="50"
                                                                                      data-tippy-arrow="true"
                                                                                      data-tippy-theme="sharpborder"><i
                                                class="fa fa-exchange"></i></a></span>
                                </div>
                            </div>
                            <div class="single-grid-product__content">
                                <h3 class="title"><a href="product-details-basic.html">Jane Lauren Gregory Chair</a>
                                </h3>
                                <div class="price"><span class="main-price discounted">$125</span> <span
                                        class="discounted-price">$90</span></div>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                </div>

                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist" data-tippy-inertia="true"
                                   data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"
                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                    <i class="fa fa-heart-o"></i>
                                    <i class="fa fa-heart"></i>
                                </a>
                            </div>
                        </div>

                        <!--=======  End of single short view product  =======-->
                    </div>

                    <div class="col">
                        <!--=======  single short view product  =======-->

                        <div class="single-grid-product">
                            <div class="single-grid-product__image">
                                <div class="product-badge-wrapper">
                                    <span class="onsale">-10%</span>
                                </div>
                                <a href="product-details-basic.html" class="image-wrap">
                                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-12-1-600x800.jpg')}}"
                                         class="img-fluid" alt="">
                                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-12-2-600x800.jpg')}}"
                                         class="img-fluid" alt="">
                                </a>
                                <div class="product-hover-icon-wrapper">
                                    <span class="single-icon single-icon--quick-view"><a class="cd-trigger" href="#qv-1"
                                                                                         data-tippy="Quick View"
                                                                                         data-tippy-inertia="true"
                                                                                         data-tippy-animation="shift-away"
                                                                                         data-tippy-delay="50"
                                                                                         data-tippy-arrow="true"
                                                                                         data-tippy-theme="sharpborder"><i
                                                class="fa fa-search"></i></a></span>
                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                          data-tippy="Add to cart"
                                                                                          data-tippy-inertia="true"
                                                                                          data-tippy-animation="shift-away"
                                                                                          data-tippy-delay="50"
                                                                                          data-tippy-arrow="true"
                                                                                          data-tippy-theme="sharpborder"><i
                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                    <span class="single-icon single-icon--compare"><a href="#" data-tippy="Compare"
                                                                                      data-tippy-inertia="true"
                                                                                      data-tippy-animation="shift-away"
                                                                                      data-tippy-delay="50"
                                                                                      data-tippy-arrow="true"
                                                                                      data-tippy-theme="sharpborder"><i
                                                class="fa fa-exchange"></i></a></span>
                                </div>
                            </div>
                            <div class="single-grid-product__content">
                                <h3 class="title"><a href="product-details-basic.html">Candice Desk Lamp</a></h3>
                                <div class="price"><span class="main-price">$100</span></div>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                </div>

                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist" data-tippy-inertia="true"
                                   data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"
                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                    <i class="fa fa-heart-o"></i>
                                    <i class="fa fa-heart"></i>
                                </a>
                            </div>
                        </div>

                        <!--=======  End of single short view product  =======-->
                    </div>

                    <div class="col">
                        <!--=======  single short view product  =======-->

                        <div class="single-grid-product">
                            <div class="single-grid-product__image">

                                <a href="product-details-basic.html" class="image-wrap">
                                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-13-1-600x800.jpg')}}"
                                         class="img-fluid" alt="">
                                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-13-2-600x800.jpg')}}"
                                         class="img-fluid" alt="">
                                </a>
                                <div class="product-hover-icon-wrapper">
                                    <span class="single-icon single-icon--quick-view"><a class="cd-trigger" href="#qv-1"
                                                                                         data-tippy="Quick View"
                                                                                         data-tippy-inertia="true"
                                                                                         data-tippy-animation="shift-away"
                                                                                         data-tippy-delay="50"
                                                                                         data-tippy-arrow="true"
                                                                                         data-tippy-theme="sharpborder"><i
                                                class="fa fa-search"></i></a></span>
                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                          data-tippy="Add to cart"
                                                                                          data-tippy-inertia="true"
                                                                                          data-tippy-animation="shift-away"
                                                                                          data-tippy-delay="50"
                                                                                          data-tippy-arrow="true"
                                                                                          data-tippy-theme="sharpborder"><i
                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                    <span class="single-icon single-icon--compare"><a href="#" data-tippy="Compare"
                                                                                      data-tippy-inertia="true"
                                                                                      data-tippy-animation="shift-away"
                                                                                      data-tippy-delay="50"
                                                                                      data-tippy-arrow="true"
                                                                                      data-tippy-theme="sharpborder"><i
                                                class="fa fa-exchange"></i></a></span>
                                </div>
                            </div>
                            <div class="single-grid-product__content">
                                <h3 class="title"><a href="product-details-basic.html">Ovora Step stool</a></h3>
                                <div class="price"><span class="main-price discounted">$185</span> <span
                                        class="discounted-price">$140</span></div>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="color">
                                    <ul>
                                        <li><a class="active" href="#" data-tippy="Black" data-tippy-inertia="true"
                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                               data-tippy-arrow="true" data-tippy-theme="roundborder"><span
                                                    class="color-picker black"></span></a></li>
                                        <li><a href="#" data-tippy="Blue" data-tippy-inertia="true"
                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                               data-tippy-arrow="true" data-tippy-theme="roundborder"><span
                                                    class="color-picker blue"></span></a></li>
                                        <li><a href="#" data-tippy="Brown" data-tippy-inertia="true"
                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                               data-tippy-arrow="true" data-tippy-theme="roundborder"><span
                                                    class="color-picker brown"></span></a></li>
                                    </ul>
                                </div>
                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist" data-tippy-inertia="true"
                                   data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"
                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                    <i class="fa fa-heart-o"></i>
                                    <i class="fa fa-heart"></i>
                                </a>
                            </div>
                        </div>

                        <!--=======  End of single short view product  =======-->
                    </div>

                    <div class="col">
                        <!--=======  single short view product  =======-->

                        <div class="single-grid-product">
                            <div class="single-grid-product__image">
                                <div class="product-badge-wrapper">
                                    <span class="onsale">-17%</span>
                                    <span class="hot">Hot</span>
                                </div>
                                <a href="product-details-basic.html" class="image-wrap">
                                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-14-1-600x800.jpg')}}"
                                         class="img-fluid" alt="">
                                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-14-2-600x800.jpg')}}
                                        " class="img-fluid" alt="">
                                </a>
                                <div class="product-hover-icon-wrapper">
                                    <span class="single-icon single-icon--quick-view"><a class="cd-trigger" href="#qv-1"
                                                                                         data-tippy="Quick View"
                                                                                         data-tippy-inertia="true"
                                                                                         data-tippy-animation="shift-away"
                                                                                         data-tippy-delay="50"
                                                                                         data-tippy-arrow="true"
                                                                                         data-tippy-theme="sharpborder"><i
                                                class="fa fa-search"></i></a></span>
                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                          data-tippy="Add to cart"
                                                                                          data-tippy-inertia="true"
                                                                                          data-tippy-animation="shift-away"
                                                                                          data-tippy-delay="50"
                                                                                          data-tippy-arrow="true"
                                                                                          data-tippy-theme="sharpborder"><i
                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                    <span class="single-icon single-icon--compare"><a href="#" data-tippy="Compare"
                                                                                      data-tippy-inertia="true"
                                                                                      data-tippy-animation="shift-away"
                                                                                      data-tippy-delay="50"
                                                                                      data-tippy-arrow="true"
                                                                                      data-tippy-theme="sharpborder"><i
                                                class="fa fa-exchange"></i></a></span>
                                </div>
                            </div>
                            <div class="single-grid-product__content">
                                <h3 class="title"><a href="product-details-basic.html">Jane Lauren Carson Chair</a></h3>
                                <div class="price"><span class="main-price">$145</span></div>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                </div>

                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist" data-tippy-inertia="true"
                                   data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"
                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                    <i class="fa fa-heart-o"></i>
                                    <i class="fa fa-heart"></i>
                                </a>
                            </div>
                        </div>

                        <!--=======  End of single short view product  =======-->
                    </div>

                    <div class="col">
                        <!--=======  single short view product  =======-->

                        <div class="single-grid-product">
                            <div class="single-grid-product__image">
                                <div class="product-badge-wrapper">
                                    <span class="onsale">-17%</span>
                                    <span class="hot">Hot</span>
                                </div>
                                <a href="product-details-basic.html" class="image-wrap">
                                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-15-1-600x800.jpg')}}"
                                         class="img-fluid" alt="">
                                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-15-2-600x800.jpg')}}"
                                         class="img-fluid" alt="">
                                </a>
                                <div class="product-hover-icon-wrapper">
                                    <span class="single-icon single-icon--quick-view"><a class="cd-trigger" href="#qv-1"
                                                                                         data-tippy="Quick View"
                                                                                         data-tippy-inertia="true"
                                                                                         data-tippy-animation="shift-away"
                                                                                         data-tippy-delay="50"
                                                                                         data-tippy-arrow="true"
                                                                                         data-tippy-theme="sharpborder"><i
                                                class="fa fa-search"></i></a></span>
                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                          data-tippy="Add to cart"
                                                                                          data-tippy-inertia="true"
                                                                                          data-tippy-animation="shift-away"
                                                                                          data-tippy-delay="50"
                                                                                          data-tippy-arrow="true"
                                                                                          data-tippy-theme="sharpborder"><i
                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                    <span class="single-icon single-icon--compare"><a href="#" data-tippy="Compare"
                                                                                      data-tippy-inertia="true"
                                                                                      data-tippy-animation="shift-away"
                                                                                      data-tippy-delay="50"
                                                                                      data-tippy-arrow="true"
                                                                                      data-tippy-theme="sharpborder"><i
                                                class="fa fa-exchange"></i></a></span>
                                </div>
                            </div>
                            <div class="single-grid-product__content">
                                <h3 class="title"><a href="product-details-basic.html">Alexa Classic Towels</a></h3>
                                <div class="price"><span class="main-price discounted">$14</span> <span
                                        class="discounted-price">$11</span></div>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="color">
                                    <ul>
                                        <li><a class="active" href="#" data-tippy="Black" data-tippy-inertia="true"
                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                               data-tippy-arrow="true" data-tippy-theme="roundborder"><span
                                                    class="color-picker black"></span></a></li>
                                        <li><a href="#" data-tippy="Blue" data-tippy-inertia="true"
                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                               data-tippy-arrow="true" data-tippy-theme="roundborder"><span
                                                    class="color-picker blue"></span></a></li>
                                        <li><a href="#" data-tippy="Brown" data-tippy-inertia="true"
                                               data-tippy-animation="shift-away" data-tippy-delay="50"
                                               data-tippy-arrow="true" data-tippy-theme="roundborder"><span
                                                    class="color-picker brown"></span></a></li>
                                    </ul>
                                </div>
                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist" data-tippy-inertia="true"
                                   data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"
                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                    <i class="fa fa-heart-o"></i>
                                    <i class="fa fa-heart"></i>
                                </a>
                            </div>
                        </div>

                        <!--=======  End of single short view product  =======-->
                    </div>

                    <div class="col">
                        <!--=======  single short view product  =======-->

                        <div class="single-grid-product">
                            <div class="single-grid-product__image">

                                <a href="product-details-basic.html" class="image-wrap">
                                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-16-1-600x800.jpg')}}"
                                         class="img-fluid" alt="">
                                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/products/product-16-2-600x800.jpg')}}"
                                         class="img-fluid" alt="">
                                </a>
                                <div class="product-hover-icon-wrapper">
                                    <span class="single-icon single-icon--quick-view"><a class="cd-trigger" href="#qv-1"
                                                                                         data-tippy="Quick View"
                                                                                         data-tippy-inertia="true"
                                                                                         data-tippy-animation="shift-away"
                                                                                         data-tippy-delay="50"
                                                                                         data-tippy-arrow="true"
                                                                                         data-tippy-theme="sharpborder"><i
                                                class="fa fa-search"></i></a></span>
                                    <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                          data-tippy="Add to cart"
                                                                                          data-tippy-inertia="true"
                                                                                          data-tippy-animation="shift-away"
                                                                                          data-tippy-delay="50"
                                                                                          data-tippy-arrow="true"
                                                                                          data-tippy-theme="sharpborder"><i
                                                class="fa fa-shopping-basket"></i> <span>ADD TO CART</span></a></span>
                                    <span class="single-icon single-icon--compare"><a href="#" data-tippy="Compare"
                                                                                      data-tippy-inertia="true"
                                                                                      data-tippy-animation="shift-away"
                                                                                      data-tippy-delay="50"
                                                                                      data-tippy-arrow="true"
                                                                                      data-tippy-theme="sharpborder"><i
                                                class="fa fa-exchange"></i></a></span>
                                </div>
                            </div>
                            <div class="single-grid-product__content">
                                <h3 class="title"><a href="product-details-basic.html">Olivia Shayn Cover Chair</a></h3>
                                <div class="price"><span class="main-price">$98</span></div>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                </div>

                                <a href="#" class="favorite-icon" data-tippy="Add to Wishlist" data-tippy-inertia="true"
                                   data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"
                                   data-tippy-theme="sharpborder" data-tippy-placement="left">
                                    <i class="fa fa-heart-o"></i>
                                    <i class="fa fa-heart"></i>
                                </a>
                            </div>
                        </div>

                        <!--=======  End of single short view product  =======-->
                    </div>

                </div>

                <!--=======  End of product slider wrapper  =======-->
            </div>
        </div>
    </div>
</div>

<!--====================  call to action area ====================-->

<div class="cta-area--two cta-bg cta-bg--two">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <!--=======  cta content wrapper  =======-->

                <div class="cta-content-wrapper--two">
                    <div class="cta-content--two">
                        <h1 class="title"><span>Queenwood</span> Collection</h1>
                        <p class="subtitle">Robin stands for beauty & style in your house. We have an impressive
                            selection of furniture that you'll love</p>
                        <a href="shop-left-sidebar.html" class="theme-button theme-button--cta-two">SHOP NOW!</a>
                    </div>
                </div>

                <!--=======  End of cta content wrapper  =======-->
            </div>
        </div>
    </div>
</div>

<!--====================  End of call to action area  ====================-->

<!--====================  End of product slider area  ====================-->

