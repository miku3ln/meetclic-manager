<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$allowModalPaymentez = false;
?>
@extends('layouts.varkala.app')
@section('additional-scripts')
    <!-- Main Theme files-->
    <script src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/js/sliders-init.d339d105.js"></script>
    <script src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/js/theme.4c87e97a.js"></script>

@endsection
@section('content')
    <!-- Slider main container-->
    <div class="swiper swiper-container home-slider" style="height: 95vh; min-height: 600px;">
        <!-- Additional required wrapper-->
        <div class="swiper-wrapper">
            <!-- Slides-->
            <div class="swiper-slide bg-cover bg-cover-right"
                 style="background-image: url('{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/photo/home-1-plain.jpg');">
                <div class="container-fluid px-lg-6 px-xl-7 h-100">
                    <div class="row h-100 align-items-center" data-swiper-parallax="-500">
                        <div class="col-lg-6">
                            <p class="subtitle letter-spacing-3 mb-3 text-dark font-weight-light">Our all-time
                                favourites</p>
                            <h2 class="display-1 mb-3" style="line-height: 1">Blouses &amp; Tops</h2>
                            <p class="text-muted mb-5">The bedding was hardly able to cover it and seemed ready to slide
                                off any moment. His many legs, pit</p><a class="btn btn-dark" href="#">Discover more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide bg-cover"
                 style="background-image: url('{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/photo/home-2-plain.jpg');">
                <div class="container-fluid px-lg-6 px-xl-7 h-100">
                    <div class="row h-100 justify-content-center align-items-center text-center"
                         data-swiper-parallax="-500">
                        <div class="col-lg-6">
                            <p class="subtitle letter-spacing-3 mb-3 text-dark font-weight-light">Blue &amp; White</p>
                            <h2 class="display-1 mb-3" style="line-height: 1">Linen and denim</h2><a
                                class="btn btn-dark" href="#">Start shopping</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide bg-cover"
                 style="background-image: url('{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/photo/home-3-plain.jpg');">
                <div class="container-fluid px-lg-6 px-xl-7 h-100">
                    <div class="row h-100 align-items-center" data-swiper-parallax="-500">
                        <div class="col-lg-6 offset-lg-6">
                            <p class="subtitle letter-spacing-3 mb-3 text-primary font-weight-light mb-4">Sneakers</p>
                            <h2 class="display-1 mb-5" style="line-height: 1">For every occassion</h2><a
                                class="btn btn-dark" href="#">Start shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-nav d-none d-lg-block">
            <div class="swiper-button-prev" id="homePrev"></div>
            <div class="swiper-button-next" id="homeNext"></div>
        </div>
    </div>
    <!-- Categories big-->
    <div class="bg-gray-100 position-relative">
        <div class="container py-6">
            <div class="row">
                <div class="col-sm-6 mb-5 mb-sm-0">
                    <div
                        class="card card-scale shadow-0 border-0 text-white text-hover-gray-900 overlay-hover-light text-center">
                        <img class="card-img img-scale"
                             src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/category-women.jpg"
                             alt="Card image">
                        <div class="card-img-overlay d-flex align-items-center">
                            <div class="w-100 py-3">
                                <h2 class="display-3 fw-bold mb-0">Women</h2><a class="stretched-link"
                                                                                href="category-full.html"><span
                                        class="sr-only">See </span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 mb-5 mb-sm-0">
                    <div
                        class="card card-scale shadow-0 border-0 text-white text-hover-gray-900 overlay-hover-light text-center">
                        <img class="card-img img-scale"
                             src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/category-men.jpg"
                             alt="Card image">
                        <div class="card-img-overlay d-flex align-items-center">
                            <div class="w-100 py-3">
                                <h2 class="display-3 fw-bold mb-0">Men</h2><a class="stretched-link"
                                                                              href="category-full.html"><span
                                        class="sr-only">See </span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid container-fluid-px py-6">
        <div class="row">
            <div class="col-lg-10 col-xl-8 text-center mx-auto">
                <h2 class="display-3 mb-5">New Arrivals</h2>
                <p class="lead text-muted mb-6">One morning, when Gregor Samsa woke from troubled dreams, he found
                    himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he
                    lifted his head a little he could see his brown belly, slightly domed and divided by arches into
                    stiff sections</p>
            </div>
        </div>
        <div class="row justify-content-between align-items-center mb-4">
            <div class="col-12 col-sm">
                <ul class="list-inline text-center text-sm-start mb-3 mb-sm-0">
                    <li class="list-inline-item"><a class="text-dark" href="#">All Products </a></li>
                    <li class="list-inline-item"><a class="text-muted text-dark-hover" href="#">Clothing </a></li>
                    <li class="list-inline-item"><a class="text-muted text-dark-hover" href="#">Bags</a></li>
                    <li class="list-inline-item"><a class="text-muted text-dark-hover" href="#">Shoes</a></li>
                    <li class="list-inline-item"><a class="text-muted text-dark-hover" href="#">Accessories</a></li>
                </ul>
            </div>
            <div class="col-12 col-sm-auto text-center"><a class="btn btn-link px-0" href="#">All products</a></div>
        </div>
        <div class="row">
            <!-- product-->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="product product-type-0" data-aos="zoom-in" data-aos-delay="0">
                    <div class="product-image mb-md-3">
                        <div class="product-badge badge bg-secondary">Fresh</div>
                        <a href="detail-1.html">
                            <div class="product-swap-image"><img class="img-fluid product-swap-image-front"
                                                                 src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0987188250_1_1_1.jpg"
                                                                 alt="product"/><img class="img-fluid"
                                                                                     src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0987188250_2_1_1.jpg"
                                                                                     alt="product"/></div>
                        </a>
                        <div class="product-hover-overlay"><a class="text-dark text-sm" href="#!">
                                <svg class="svg-icon text-primary-hover svg-icon-heavy d-sm-none">
                                    <use xlink:href="#retail-bag-1"></use>
                                </svg>
                                <span class="d-none d-sm-inline">Add to cart</span></a>
                            <div><a class="text-dark text-primary-hover me-2" href="#!">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#heart-1"></use>
                                    </svg>
                                </a><a class="text-dark text-primary-hover text-decoration-none" href="#!"
                                       data-bs-toggle="modal" data-bs-target="#quickView">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#expand-1"></use>
                                    </svg>
                                </a></div>
                        </div>
                    </div>
                    <div class="position-relative">
                        <h3 class="text-base mb-1"><a class="text-dark" href="detail-1.html">White Tee</a></h3>
                        <p class="text-gray-600 text-sm">
                            <s class="me-2 text-gray-500">$40.00</s><span>$20.00</span>
                        </p>
                        <div class="product-stars text-xs"><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-muted"></i><i class="fa fa-star text-muted"></i></div>
                    </div>
                </div>
            </div>
            <!-- /product   -->
            <!-- product-->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="product product-type-0" data-aos="zoom-in" data-aos-delay="0">
                    <div class="product-image mb-md-3"><a href="detail-1.html">
                            <div class="product-swap-image"><img class="img-fluid product-swap-image-front"
                                                                 src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0950354513_1_1_1.jpg"
                                                                 alt="product"/><img class="img-fluid"
                                                                                     src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0950354513_2_1_1.jpg"
                                                                                     alt="product"/></div>
                        </a>
                        <div class="product-hover-overlay"><a class="text-dark text-sm" href="#!">
                                <svg class="svg-icon text-primary-hover svg-icon-heavy d-sm-none">
                                    <use xlink:href="#retail-bag-1"></use>
                                </svg>
                                <span class="d-none d-sm-inline">Add to cart</span></a>
                            <div><a class="text-dark text-primary-hover me-2" href="#!">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#heart-1"></use>
                                    </svg>
                                </a><a class="text-dark text-primary-hover text-decoration-none" href="#!"
                                       data-bs-toggle="modal" data-bs-target="#quickView">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#expand-1"></use>
                                    </svg>
                                </a></div>
                        </div>
                    </div>
                    <div class="position-relative">
                        <h3 class="text-base mb-1"><a class="text-dark" href="detail-1.html">Black blouse</a></h3>
                        <p class="text-gray-600 text-sm"><span>$40.00                </span>
                        </p>
                        <div class="product-stars text-xs"><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-muted"></i><i class="fa fa-star text-muted"></i></div>
                    </div>
                </div>
            </div>
            <!-- /product   -->
            <!-- product-->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="product product-type-0" data-aos="zoom-in" data-aos-delay="0">
                    <div class="product-image mb-md-3">
                        <div class="product-badge badge bg-primary">Sale</div>
                        <a href="detail-1.html">
                            <div class="product-swap-image"><img class="img-fluid product-swap-image-front"
                                                                 src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/5161335400_1_1_1.jpg"
                                                                 alt="product"/><img class="img-fluid"
                                                                                     src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/5161335400_2_3_1.jpg"
                                                                                     alt="product"/></div>
                        </a>
                        <div class="product-hover-overlay"><a class="text-dark text-sm" href="#!">
                                <svg class="svg-icon text-primary-hover svg-icon-heavy d-sm-none">
                                    <use xlink:href="#retail-bag-1"></use>
                                </svg>
                                <span class="d-none d-sm-inline">Add to cart</span></a>
                            <div><a class="text-dark text-primary-hover me-2" href="#!">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#heart-1"></use>
                                    </svg>
                                </a><a class="text-dark text-primary-hover text-decoration-none" href="#!"
                                       data-bs-toggle="modal" data-bs-target="#quickView">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#expand-1"></use>
                                    </svg>
                                </a></div>
                        </div>
                    </div>
                    <div class="position-relative">
                        <h3 class="text-base mb-1"><a class="text-dark" href="detail-1.html">College jacket</a></h3>
                        <p class="text-gray-600 text-sm">
                            <s class="me-2 text-gray-500">$30.00</s><span>$15.00</span>
                        </p>
                        <div class="product-stars text-xs"><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-muted"></i><i class="fa fa-star text-muted"></i></div>
                    </div>
                </div>
            </div>
            <!-- /product   -->
            <!-- product-->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="product product-type-0" data-aos="zoom-in" data-aos-delay="0">
                    <div class="product-image mb-md-3"><a href="detail-1.html">
                            <div class="product-swap-image"><img class="img-fluid product-swap-image-front"
                                                                 src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0027211800_1_2_1.jpg"
                                                                 alt="product"/><img class="img-fluid"
                                                                                     src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0027211800_2_1_1.jpg"
                                                                                     alt="product"/></div>
                        </a>
                        <div class="product-hover-overlay"><a class="text-dark text-sm" href="#!">
                                <svg class="svg-icon text-primary-hover svg-icon-heavy d-sm-none">
                                    <use xlink:href="#retail-bag-1"></use>
                                </svg>
                                <span class="d-none d-sm-inline">Add to cart</span></a>
                            <div><a class="text-dark text-primary-hover me-2" href="#!">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#heart-1"></use>
                                    </svg>
                                </a><a class="text-dark text-primary-hover text-decoration-none" href="#!"
                                       data-bs-toggle="modal" data-bs-target="#quickView">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#expand-1"></use>
                                    </svg>
                                </a></div>
                        </div>
                    </div>
                    <div class="position-relative">
                        <h3 class="text-base mb-1"><a class="text-dark" href="detail-1.html">Carrot-fit jeans</a></h3>
                        <p class="text-gray-600 text-sm"><span>$60.00                </span>
                        </p>
                        <div class="product-stars text-xs"><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-muted"></i><i class="fa fa-star text-muted"></i></div>
                    </div>
                </div>
            </div>
            <!-- /product   -->
            <!-- product-->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="product product-type-0" data-aos="zoom-in" data-aos-delay="0">
                    <div class="product-image mb-md-3"><a href="detail-1.html">
                            <div class="product-swap-image"><img class="img-fluid product-swap-image-front"
                                                                 src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0144074800_1_1_1.jpg"
                                                                 alt="product"/><img class="img-fluid"
                                                                                     src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0144074800_2_1_1.jpg"
                                                                                     alt="product"/></div>
                        </a>
                        <div class="product-hover-overlay"><a class="text-dark text-sm" href="#!">
                                <svg class="svg-icon text-primary-hover svg-icon-heavy d-sm-none">
                                    <use xlink:href="#retail-bag-1"></use>
                                </svg>
                                <span class="d-none d-sm-inline">Add to cart</span></a>
                            <div><a class="text-dark text-primary-hover me-2" href="#!">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#heart-1"></use>
                                    </svg>
                                </a><a class="text-dark text-primary-hover text-decoration-none" href="#!"
                                       data-bs-toggle="modal" data-bs-target="#quickView">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#expand-1"></use>
                                    </svg>
                                </a></div>
                        </div>
                    </div>
                    <div class="position-relative">
                        <h3 class="text-base mb-1"><a class="text-dark" href="detail-1.html">Striped T-Shirt</a></h3>
                        <p class="text-gray-600 text-sm"><span>$30.99                </span>
                        </p>
                        <div class="product-stars text-xs"><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-muted"></i><i class="fa fa-star text-muted"></i></div>
                    </div>
                </div>
            </div>
            <!-- /product   -->
            <!-- product-->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="product product-type-0" data-aos="zoom-in" data-aos-delay="0">
                    <div class="product-image mb-md-3">
                        <div class="product-badge badge bg-dark">Sold out</div>
                        <a href="detail-1.html">
                            <div class="product-swap-image"><img class="img-fluid product-swap-image-front"
                                                                 src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0693492802_1_1_1.jpg"
                                                                 alt="product"/><img class="img-fluid"
                                                                                     src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0693492802_2_1_1.jpg"
                                                                                     alt="product"/></div>
                        </a>
                        <div class="product-hover-overlay"><a class="text-dark text-sm" href="#!">
                                <svg class="svg-icon text-primary-hover svg-icon-heavy d-sm-none">
                                    <use xlink:href="#retail-bag-1"></use>
                                </svg>
                                <span class="d-none d-sm-inline">Add to cart</span></a>
                            <div><a class="text-dark text-primary-hover me-2" href="#!">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#heart-1"></use>
                                    </svg>
                                </a><a class="text-dark text-primary-hover text-decoration-none" href="#!"
                                       data-bs-toggle="modal" data-bs-target="#quickView">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#expand-1"></use>
                                    </svg>
                                </a></div>
                        </div>
                    </div>
                    <div class="position-relative">
                        <h3 class="text-base mb-1"><a class="text-dark" href="detail-1.html">Short top</a></h3>
                        <p class="text-gray-600 text-sm">
                            <s class="me-2 text-gray-500">$40.00</s><span>$16.00</span>
                        </p>
                        <div class="product-stars text-xs"><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-muted"></i><i class="fa fa-star text-muted"></i></div>
                    </div>
                </div>
            </div>
            <!-- /product   -->
            <!-- product-->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="product product-type-0" data-aos="zoom-in" data-aos-delay="0">
                    <div class="product-image mb-md-3">
                        <div class="product-badge badge bg-dark">Sold out</div>
                        <a href="detail-1.html">
                            <div class="product-swap-image"><img class="img-fluid product-swap-image-front"
                                                                 src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0364326148_1_1_1.jpg"
                                                                 alt="product"/><img class="img-fluid"
                                                                                     src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0364326148_2_1_1.jpg"
                                                                                     alt="product"/></div>
                        </a>
                        <div class="product-hover-overlay"><a class="text-dark text-sm" href="#!">
                                <svg class="svg-icon text-primary-hover svg-icon-heavy d-sm-none">
                                    <use xlink:href="#retail-bag-1"></use>
                                </svg>
                                <span class="d-none d-sm-inline">Add to cart</span></a>
                            <div><a class="text-dark text-primary-hover me-2" href="#!">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#heart-1"></use>
                                    </svg>
                                </a><a class="text-dark text-primary-hover text-decoration-none" href="#!"
                                       data-bs-toggle="modal" data-bs-target="#quickView">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#expand-1"></use>
                                    </svg>
                                </a></div>
                        </div>
                    </div>
                    <div class="position-relative">
                        <h3 class="text-base mb-1"><a class="text-dark" href="detail-1.html">Ethnic Sweater</a></h3>
                        <p class="text-gray-600 text-sm">
                            <s class="me-2 text-gray-500">$40.00</s><span>$30.00</span>
                        </p>
                        <div class="product-stars text-xs"><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-muted"></i><i class="fa fa-star text-muted"></i></div>
                    </div>
                </div>
            </div>
            <!-- /product   -->
            <!-- product-->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="product product-type-0" data-aos="zoom-in" data-aos-delay="0">
                    <div class="product-image mb-md-3"><a href="detail-1.html">
                            <div class="product-swap-image"><img class="img-fluid product-swap-image-front"
                                                                 src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0931168712_1_1_1.jpg"
                                                                 alt="product"/><img class="img-fluid"
                                                                                     src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0931168712_2_1_1.jpg"
                                                                                     alt="product"/></div>
                        </a>
                        <div class="product-hover-overlay"><a class="text-dark text-sm" href="#!">
                                <svg class="svg-icon text-primary-hover svg-icon-heavy d-sm-none">
                                    <use xlink:href="#retail-bag-1"></use>
                                </svg>
                                <span class="d-none d-sm-inline">Add to cart</span></a>
                            <div><a class="text-dark text-primary-hover me-2" href="#!">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#heart-1"></use>
                                    </svg>
                                </a><a class="text-dark text-primary-hover text-decoration-none" href="#!"
                                       data-bs-toggle="modal" data-bs-target="#quickView">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#expand-1"></use>
                                    </svg>
                                </a></div>
                        </div>
                    </div>
                    <div class="position-relative">
                        <h3 class="text-base mb-1"><a class="text-dark" href="detail-1.html">Beige</a></h3>
                        <p class="text-gray-600 text-sm"><span>$40.00                </span>
                        </p>
                        <div class="product-stars text-xs"><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-muted"></i><i class="fa fa-star text-muted"></i></div>
                    </div>
                </div>
            </div>
            <!-- /product   -->
            <!-- product-->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="product product-type-0" data-aos="zoom-in" data-aos-delay="0">
                    <div class="product-image mb-md-3"><a href="detail-1.html">
                            <div class="product-swap-image"><img class="img-fluid product-swap-image-front"
                                                                 src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/1000962306_1_1_1.jpg"
                                                                 alt="product"/><img class="img-fluid"
                                                                                     src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/1000962306_2_1_1.jpg"
                                                                                     alt="product"/></div>
                        </a>
                        <div class="product-hover-overlay"><a class="text-dark text-sm" href="#!">
                                <svg class="svg-icon text-primary-hover svg-icon-heavy d-sm-none">
                                    <use xlink:href="#retail-bag-1"></use>
                                </svg>
                                <span class="d-none d-sm-inline">Add to cart</span></a>
                            <div><a class="text-dark text-primary-hover me-2" href="#!">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#heart-1"></use>
                                    </svg>
                                </a><a class="text-dark text-primary-hover text-decoration-none" href="#!"
                                       data-bs-toggle="modal" data-bs-target="#quickView">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#expand-1"></use>
                                    </svg>
                                </a></div>
                        </div>
                    </div>
                    <div class="position-relative">
                        <h3 class="text-base mb-1"><a class="text-dark" href="detail-1.html">Skull Tee</a></h3>
                        <p class="text-gray-600 text-sm">
                            <s class="me-2 text-gray-500">$40.00</s><span>$20.00</span>
                        </p>
                        <div class="product-stars text-xs"><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-muted"></i><i class="fa fa-star text-muted"></i></div>
                    </div>
                </div>
            </div>
            <!-- /product   -->
            <!-- product-->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="product product-type-0" data-aos="zoom-in" data-aos-delay="0">
                    <div class="product-image mb-md-3"><a href="detail-1.html">
                            <div class="product-swap-image"><img class="img-fluid product-swap-image-front"
                                                                 src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0915494643_1_1_1.jpg"
                                                                 alt="product"/><img class="img-fluid"
                                                                                     src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0915494643_2_1_1.jpg"
                                                                                     alt="product"/></div>
                        </a>
                        <div class="product-hover-overlay"><a class="text-dark text-sm" href="#!">
                                <svg class="svg-icon text-primary-hover svg-icon-heavy d-sm-none">
                                    <use xlink:href="#retail-bag-1"></use>
                                </svg>
                                <span class="d-none d-sm-inline">Add to cart</span></a>
                            <div><a class="text-dark text-primary-hover me-2" href="#!">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#heart-1"></use>
                                    </svg>
                                </a><a class="text-dark text-primary-hover text-decoration-none" href="#!"
                                       data-bs-toggle="modal" data-bs-target="#quickView">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#expand-1"></use>
                                    </svg>
                                </a></div>
                        </div>
                    </div>
                    <div class="position-relative">
                        <h3 class="text-base mb-1"><a class="text-dark" href="detail-1.html">Trucker jacket</a></h3>
                        <p class="text-gray-600 text-sm"><span>$40.00                </span>
                        </p>
                        <div class="product-stars text-xs"><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-muted"></i><i class="fa fa-star text-muted"></i></div>
                    </div>
                </div>
            </div>
            <!-- /product   -->
            <!-- product-->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="product product-type-0" data-aos="zoom-in" data-aos-delay="0">
                    <div class="product-image mb-md-3"><a href="detail-1.html">
                            <div class="product-swap-image"><img class="img-fluid product-swap-image-front"
                                                                 src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0907168607_1_1_1.jpg"
                                                                 alt="product"/><img class="img-fluid"
                                                                                     src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0907168607_2_1_1.jpg"
                                                                                     alt="product"/></div>
                        </a>
                        <div class="product-hover-overlay"><a class="text-dark text-sm" href="#!">
                                <svg class="svg-icon text-primary-hover svg-icon-heavy d-sm-none">
                                    <use xlink:href="#retail-bag-1"></use>
                                </svg>
                                <span class="d-none d-sm-inline">Add to cart</span></a>
                            <div><a class="text-dark text-primary-hover me-2" href="#!">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#heart-1"></use>
                                    </svg>
                                </a><a class="text-dark text-primary-hover text-decoration-none" href="#!"
                                       data-bs-toggle="modal" data-bs-target="#quickView">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#expand-1"></use>
                                    </svg>
                                </a></div>
                        </div>
                    </div>
                    <div class="position-relative">
                        <h3 class="text-base mb-1"><a class="text-dark" href="detail-1.html">Blouse</a></h3>
                        <p class="text-gray-600 text-sm"><span>$40.00                </span>
                        </p>
                        <div class="product-stars text-xs"><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-muted"></i><i class="fa fa-star text-muted"></i></div>
                    </div>
                </div>
            </div>
            <!-- /product   -->
            <!-- product-->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="product product-type-0" data-aos="zoom-in" data-aos-delay="0">
                    <div class="product-image mb-md-3"><a href="detail-1.html">
                            <div class="product-swap-image"><img class="img-fluid product-swap-image-front"
                                                                 src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/5806513505_1_2_1.jpg"
                                                                 alt="product"/><img class="img-fluid"
                                                                                     src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/5806513505_2_1_1.jpg"
                                                                                     alt="product"/></div>
                        </a>
                        <div class="product-hover-overlay"><a class="text-dark text-sm" href="#!">
                                <svg class="svg-icon text-primary-hover svg-icon-heavy d-sm-none">
                                    <use xlink:href="#retail-bag-1"></use>
                                </svg>
                                <span class="d-none d-sm-inline">Add to cart</span></a>
                            <div><a class="text-dark text-primary-hover me-2" href="#!">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#heart-1"></use>
                                    </svg>
                                </a><a class="text-dark text-primary-hover text-decoration-none" href="#!"
                                       data-bs-toggle="modal" data-bs-target="#quickView">
                                    <svg class="svg-icon svg-icon-heavy">
                                        <use xlink:href="#expand-1"></use>
                                    </svg>
                                </a></div>
                        </div>
                    </div>
                    <div class="position-relative">
                        <h3 class="text-base mb-1"><a class="text-dark" href="detail-1.html">Shirt</a></h3>
                        <p class="text-gray-600 text-sm"><span>$40.00                </span>
                        </p>
                        <div class="product-stars text-xs"><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i
                                class="fa fa-star text-muted"></i><i class="fa fa-star text-muted"></i></div>
                    </div>
                </div>
            </div>
            <!-- /product   -->
        </div>
        <!-- Quickview Modal    -->
        <div class="modal fade quickview" id="quickView" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <button class="btn-close btn-close-absolute btn-close-lg btn-close-rotate" type="button"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body quickview-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="detail-carousel">
                                    <div class="product-badge badge bg-primary">Fresh</div>
                                    <div class="product-badge badge bg-dark">Sale</div>
                                    <div class="swiper swiper-container quickview-slider" id="quickViewSlider">
                                        <!-- Additional required wrapper-->
                                        <div class="swiper-wrapper">
                                            <!-- Slides-->
                                            <div class="swiper-slide"><img class="img-fluid"
                                                                           src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/detail-1-gray.jpg"
                                                                           alt="Modern Jacket 1"></div>
                                            <div class="swiper-slide"><img class="img-fluid"
                                                                           src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/detail-2-gray.jpg"
                                                                           alt="Modern Jacket 2"></div>
                                            <div class="swiper-slide"><img class="img-fluid"
                                                                           src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/detail-3-gray.jpg"
                                                                           alt="Modern Jacket 3"></div>
                                            <div class="swiper-slide"><img class="img-fluid"
                                                                           src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/detail-4-gray.jpg"
                                                                           alt="Modern Jacket 4"></div>
                                            <div class="swiper-slide"><img class="img-fluid"
                                                                           src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/detail-5-gray.jpg"
                                                                           alt="Modern Jacket 5"></div>
                                        </div>
                                    </div>
                                    <div class="swiper-thumbs" data-swiper="#quickViewSlider">
                                        <button class="swiper-thumb-item detail-thumb-item mb-3 active"><img
                                                class="img-fluid"
                                                src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/detail-1-gray.jpg"
                                                alt="Modern Jacket 0"></button>
                                        <button class="swiper-thumb-item detail-thumb-item mb-3"><img class="img-fluid"
                                                                                                      src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/detail-2-gray.jpg"
                                                                                                      alt="Modern Jacket 1">
                                        </button>
                                        <button class="swiper-thumb-item detail-thumb-item mb-3"><img class="img-fluid"
                                                                                                      src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/detail-3-gray.jpg"
                                                                                                      alt="Modern Jacket 2">
                                        </button>
                                        <button class="swiper-thumb-item detail-thumb-item mb-3"><img class="img-fluid"
                                                                                                      src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/detail-4-gray.jpg"
                                                                                                      alt="Modern Jacket 3">
                                        </button>
                                        <button class="swiper-thumb-item detail-thumb-item mb-3"><img class="img-fluid"
                                                                                                      src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/detail-5-gray.jpg"
                                                                                                      alt="Modern Jacket 4">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 p-lg-5">
                                <h2 class="mb-4 mt-4 mt-lg-1">Push-up Jeans</h2>
                                <div
                                    class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-sm-between mb-4">
                                    <ul class="list-inline mb-2 mb-sm-0">
                                        <li class="list-inline-item h4 fw-light mb-0">$65.00</li>
                                        <li class="list-inline-item text-muted fw-light">
                                            <del>$90.00</del>
                                        </li>
                                    </ul>
                                    <div class="d-flex align-items-center text-sm">
                                        <ul class="list-inline me-2 mb-0">
                                            <li class="list-inline-item me-0"><i class="fa fa-star text-primary"></i>
                                            </li>
                                            <li class="list-inline-item me-0"><i class="fa fa-star text-primary"></i>
                                            </li>
                                            <li class="list-inline-item me-0"><i class="fa fa-star text-primary"></i>
                                            </li>
                                            <li class="list-inline-item me-0"><i class="fa fa-star text-primary"></i>
                                            </li>
                                            <li class="list-inline-item me-0"><i class="fa fa-star text-gray-300"></i>
                                            </li>
                                        </ul>
                                        <span class="text-muted text-uppercase">25 reviews</span>
                                    </div>
                                </div>
                                <p class="mb-4 text-muted">Samsa was a travelling salesman - and above it there hung a
                                    picture that he had recently cut out of an illustrated magazine and housed in a
                                    nice, gilded frame.</p>
                                <form id="buyForm_modal" action="#">
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-12 detail-option mb-4">
                                            <h6 class="detail-option-heading">Size <span>(required)</span></h6>
                                            <select class="selectpicker" name="size" data-style="btn-selectpicker">
                                                <option value="value_0">Small</option>
                                                <option value="value_1">Medium</option>
                                                <option value="value_2">Large</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-lg-12 detail-option mb-5">
                                            <h6 class="detail-option-heading">Type <span>(required)</span></h6>
                                            <label class="btn btn-sm btn-outline-primary detail-option-btn-label"
                                                   for="material_0_modal"> Hoodie
                                                <input class="input-invisible" type="radio" name="material"
                                                       value="value_0" id="material_0_modal" required>
                                            </label>
                                            <label class="btn btn-sm btn-outline-primary detail-option-btn-label"
                                                   for="material_1_modal"> College
                                                <input class="input-invisible" type="radio" name="material"
                                                       value="value_1" id="material_1_modal" required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="input-group w-100 mb-4">
                                        <input class="form-control form-control-lg detail-quantity" name="items"
                                               type="number" value="1">
                                        <div class="flex-grow-1">
                                            <div class="d-grid h-100">
                                                <button class="btn btn-dark" type="submit"><i
                                                        class="fa fa-shopping-cart me-2"></i>Add to Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-6"><a href="#"> <i class="far fa-heart me-2"></i>Add to wishlist
                                            </a></div>
                                        <div class="col-6 text-end">
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item me-2"><a
                                                        class="text-dark text-primary-hover" href="#"><i
                                                            class="fab fa-facebook-f"> </i></a></li>
                                                <li class="list-inline-item"><a class="text-dark text-primary-hover"
                                                                                href="#"><i class="fab fa-twitter"> </i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <ul class="list-unstyled">
                                        <li><strong>Category:</strong> <a class="text-muted" href="#">Jeans</a></li>
                                        <li><strong>Tags:</strong> <a class="text-muted" href="#">Leisure</a>, <a
                                                class="text-muted" href="#">Elegant</a></li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-6 bg-cover bg-cover-right"
         style="background-image: url({{asset($resourcePathServer.$resourcesTemplateInit)}}/img/photo/deal-plain.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-6">
                    <p class="subtitle mb-3 text-danger">Deal of the week</p>
                    <h3 class="h1">Oversized denim jacket</h3>
                    <p class="text-muted">
                        <del class="me-3">$129.00</del>
                        <span>$79.00</span>
                    </p>
                    <p class="mb-4"><span class="badge bg-danger p-3">$50 off</span></p>
                    <div class="bg-white px-5 py-4 shadow mb-4" id="countdown">
                        <div class="row justify-content-between">
                            <div class="col-6 col-sm-3 text-center mb-4 mb-sm-0">
                                <h6 class="h4 mb-2 days">&nbsp;</h6><span class="text-muted">days</span>
                            </div>
                            <div class="col-6 col-sm-3 text-center mb-4 mb-sm-0">
                                <h6 class="h4 mb-2 hours">&nbsp;</h6><span class="text-muted">hours</span>
                            </div>
                            <div class="col-6 col-sm-3 text-center">
                                <h6 class="h4 mb-2 minutes">&nbsp;</h6><span class="text-muted">minutes</span>
                            </div>
                            <div class="col-6 col-sm-3 text-center">
                                <h6 class="h4 mb-2 seconds">&nbsp;</h6><span class="text-muted">seconds</span>
                            </div>
                        </div>
                    </div>
                    <p><a class="btn btn-outline-dark" href="#">Shop now</a></p>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-6">
        <h5 class="text-uppercase text-primary letter-spacing-3 mb-3">Our History</h5>
        <p class="lead text-muted mb-4">One morning, when Gregor Samsa woke from troubled dreams, he found himself
            transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a
            little he could see his brown belly, slightly domed and divided by arches into stiff sections </p>
        <p class="lead text-muted mb-5">He must have tried it a hundred times, shut his eyes so that he wouldn't have to
            look at the floundering legs, and only stopped when he began to feel a mild, dull pain there that he had
            never felt before. </p>
    </div>
    <!-- Brands Section-->

    <section class="pb-6">
        <div class="container">
            <!-- Brands Slider-->
            <div class="swiper swiper-container brands-slider">
                <div class="swiper-wrapper pb-5">
                    <!-- item-->
                    <div class="swiper-slide h-auto d-flex align-items-center justify-content-center"><img
                            class="img-fluid w-6rem opacity-7"
                            src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/brand/brand-1.svg" alt="Brand 1">
                    </div>
                    <!-- item-->
                    <div class="swiper-slide h-auto d-flex align-items-center justify-content-center"><img
                            class="img-fluid w-6rem opacity-7"
                            src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/brand/brand-2.svg" alt="Brand 2">
                    </div>
                    <!-- item-->
                    <div class="swiper-slide h-auto d-flex align-items-center justify-content-center"><img
                            class="img-fluid w-6rem opacity-7"
                            src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/brand/brand-3.svg" alt="Brand 3">
                    </div>
                    <!-- item-->
                    <div class="swiper-slide h-auto d-flex align-items-center justify-content-center"><img
                            class="img-fluid w-6rem opacity-7"
                            src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/brand/brand-4.svg" alt="Brand 4">
                    </div>
                    <!-- item-->
                    <div class="swiper-slide h-auto d-flex align-items-center justify-content-center"><img
                            class="img-fluid w-6rem opacity-7"
                            src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/brand/brand-5.svg" alt="Brand 5">
                    </div>
                    <!-- item-->
                    <div class="swiper-slide h-auto d-flex align-items-center justify-content-center"><img
                            class="img-fluid w-6rem opacity-7"
                            src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/brand/brand-6.svg" alt="Brand 6">
                    </div>
                    <!-- item-->
                    <div class="swiper-slide h-auto d-flex align-items-center justify-content-center"><img
                            class="img-fluid w-6rem opacity-7"
                            src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/brand/brand-1.svg" alt="Brand 1">
                    </div>
                    <!-- item-->
                    <div class="swiper-slide h-auto d-flex align-items-center justify-content-center"><img
                            class="img-fluid w-6rem opacity-7"
                            src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/brand/brand-2.svg" alt="Brand 2">
                    </div>
                    <!-- item-->
                    <div class="swiper-slide h-auto d-flex align-items-center justify-content-center"><img
                            class="img-fluid w-6rem opacity-7"
                            src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/brand/brand-3.svg" alt="Brand 3">
                    </div>
                    <!-- item-->
                    <div class="swiper-slide h-auto d-flex align-items-center justify-content-center"><img
                            class="img-fluid w-6rem opacity-7"
                            src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/brand/brand-4.svg" alt="Brand 4">
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

@endsection
