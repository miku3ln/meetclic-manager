<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$allowModalPaymentez = false;
?>
@extends('layouts.varkala.app')
@section('additional-scripts')
    <!-- Main Theme files-->
    <script src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/js/sliders-init.d339d105.js"></script>
    <script src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/js/theme.4c87e97a.js"></script>
    <script src="{{asset($resourcePathServer)}}/js/compiled/AppInit/AppVarkale.js"></script>
    <script src="{{asset($resourcePathServer)}}/js/business/frontend/web/templates/varkala/listingOne.js"></script>

@endsection
@section('content')
    <div id="app-management" class="not-view">
        <div class="container-fluid container-fluid-px py-6">

            @if($dataManagerPage['viewPage'])
                <div class="row">

                    <!-- Grid -->
                    <div class="products-grid col-xl-9 col-lg-8 order-lg-2">
                        <!-- Hero Content-->
                        <div class="hero-content pb-5">
                            <h1>Product Card 1</h1>
                            <p class="lead text-muted">Product card focused on product photos. Additional information
                                appears on
                                hover.</p>
                        </div>
                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb undefined">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active">Shop</li>
                        </ol>
                        <header class="product-grid-header">
                            <div class="me-3 mb-3">
                                Showing <strong>1-12 </strong>of <strong>158 </strong>products
                            </div>
                            <div class="me-3 mb-3"><span class="me-2">Show</span><a
                                    class="product-grid-header-show active"
                                    href="#">12 </a><a
                                    class="product-grid-header-show " href="#">24 </a><a
                                    class="product-grid-header-show "
                                    href="#">All </a>
                            </div>
                            <div class="mb-3 d-flex align-items-center"><span class="d-inline-block me-2">Sort by</span>
                                <select class="selectpicker" name="sort" id="form_sort"
                                        data-style="btn-selectpicker border-0"
                                        title="">
                                    <option value="sortBy_0">Default</option>
                                    <option value="sortBy_1">Popularity</option>
                                    <option value="sortBy_2">Rating</option>
                                    <option value="sortBy_3">Newest first</option>
                                </select>
                            </div>
                        </header>
                        <div class="row">
                            <!-- product type 1-->
                            <div class="col-xxl-4 col-sm-6">
                                <div class="product product-type-1">
                                    <div class="product-image border-0">
                                        <div class="product-label bg-info">Fresh</div>
                                        <img class="img-fluid"
                                             src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0987188250_1_1_1.jpg"
                                             alt="product"/>
                                        <div class="product-hover-overlay"><a class="product-hover-overlay-link"
                                                                              href="detail-1.html"></a><a
                                                class="product-wishlist btn btn-link btn-lg text-dark p-0" href="#!">
                                                <svg class="svg-icon svg-icon-md svg-icon-heavy">
                                                    <use xlink:href="#heart-1"></use>
                                                </svg>
                                            </a>
                                            <div class="product-hover-overlay-buttons">
                                                <ul class="list-unstyled">
                                                    <li class="my-2"><a
                                                            class="btn btn-outline-dark product-btn-animated d-none d-sm-inline-block w-100 px-3 py-0"
                                                            href="#!" data-bs-toggle="modal"
                                                            data-bs-target="#quickView"><span
                                                                class="product-animated-text">Quick view</span><span
                                                                class="product-animated-icon">
                              <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                <use xlink:href="#expand-1"> </use>
                              </svg></span></a></li>
                                                    <li class="my-2"><a
                                                            class="btn btn-outline-dark product-btn-animated d-none d-sm-inline-block w-100 px-3 py-0"
                                                            href="#!"><span
                                                                class="product-animated-text">Quick shop </span><span
                                                                class="product-animated-icon">
                              <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                <use xlink:href="#cart-1"> </use>
                              </svg></span></a></li>
                                                </ul>
                                            </div>
                                            <div class="product-info p-3 position-absolute bottom-0 start-0">
                                                <h3 class="h6 mb-1"><a class="text-dark" href="detail-1.html">White
                                                        Tee</a>
                                                </h3>
                                                <p class="text-muted mb-2">
                                                    <s class="me-2 text-gray-500">$40.00</s><span>$20.00</span>
                                                </p>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item me-0">
                                                        <input class="product-color-input disabled d-none"
                                                               id="product1_color1"
                                                               type="radio" name="product1colors"/>
                                                        <label class="product-color" for="product1_color1"
                                                               data-id="product1_color1" style="background: #7067f2"
                                                               data-img="img/product/0987188250_1_1_1.jpg"></label>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <input class="product-color-input disabled d-none"
                                                               id="product1_color2"
                                                               type="radio" name="product1colors"/>
                                                        <label class="product-color" for="product1_color2"
                                                               data-id="product1_color2" style="background: #a0cfff"
                                                               data-img="img/product/0987188250_2_1_1.jpg"></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /product-->
                            <!-- product type 1-->
                            <div class="col-xxl-4 col-sm-6">
                                <div class="product product-type-1">
                                    <div class="product-image border-0"><img class="img-fluid"
                                                                             src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0950354513_1_1_1.jpg"
                                                                             alt="product"/>
                                        <div class="product-hover-overlay"><a class="product-hover-overlay-link"
                                                                              href="detail-1.html"></a><a
                                                class="product-wishlist btn btn-link btn-lg text-dark p-0" href="#!">
                                                <svg class="svg-icon svg-icon-md svg-icon-heavy">
                                                    <use xlink:href="#heart-1"></use>
                                                </svg>
                                            </a>
                                            <div class="product-hover-overlay-buttons">
                                                <ul class="list-unstyled">
                                                    <li class="my-2"><a
                                                            class="btn btn-outline-dark product-btn-animated d-none d-sm-inline-block w-100 px-3 py-0"
                                                            href="#!" data-bs-toggle="modal"
                                                            data-bs-target="#quickView"><span
                                                                class="product-animated-text">Quick view</span><span
                                                                class="product-animated-icon">
                              <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                <use xlink:href="#expand-1"> </use>
                              </svg></span></a></li>
                                                    <li class="my-2"><a
                                                            class="btn btn-outline-dark product-btn-animated d-none d-sm-inline-block w-100 px-3 py-0"
                                                            href="#!"><span
                                                                class="product-animated-text">Quick shop </span><span
                                                                class="product-animated-icon">
                              <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                <use xlink:href="#cart-1"> </use>
                              </svg></span></a></li>
                                                </ul>
                                            </div>
                                            <div class="product-info p-3 position-absolute bottom-0 start-0">
                                                <h3 class="h6 mb-1"><a class="text-dark" href="detail-1.html">Black
                                                        blouse</a>
                                                </h3>
                                                <p class="text-muted mb-2"><span>$40.00</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /product-->
                            <!-- product type 1-->
                            <div class="col-xxl-4 col-sm-6">
                                <div class="product product-type-1">
                                    <div class="product-image border-0">
                                        <div class="product-label bg-primary">Sale</div>
                                        <img class="img-fluid"
                                             src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/5161335400_1_1_1.jpg"
                                             alt="product"/>
                                        <div class="product-hover-overlay"><a class="product-hover-overlay-link"
                                                                              href="detail-1.html"></a><a
                                                class="product-wishlist btn btn-link btn-lg text-dark p-0" href="#!">
                                                <svg class="svg-icon svg-icon-md svg-icon-heavy">
                                                    <use xlink:href="#heart-1"></use>
                                                </svg>
                                            </a>
                                            <div class="product-hover-overlay-buttons">
                                                <ul class="list-unstyled">
                                                    <li class="my-2"><a
                                                            class="btn btn-outline-dark product-btn-animated d-none d-sm-inline-block w-100 px-3 py-0"
                                                            href="#!" data-bs-toggle="modal"
                                                            data-bs-target="#quickView"><span
                                                                class="product-animated-text">Quick view</span><span
                                                                class="product-animated-icon">
                              <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                <use xlink:href="#expand-1"> </use>
                              </svg></span></a></li>
                                                    <li class="my-2"><a
                                                            class="btn btn-outline-dark product-btn-animated d-none d-sm-inline-block w-100 px-3 py-0"
                                                            href="#!"><span
                                                                class="product-animated-text">Quick shop </span><span
                                                                class="product-animated-icon">
                              <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                <use xlink:href="#cart-1"> </use>
                              </svg></span></a></li>
                                                </ul>
                                            </div>
                                            <div class="product-info p-3 position-absolute bottom-0 start-0">
                                                <h3 class="h6 mb-1"><a class="text-dark" href="detail-1.html">College
                                                        jacket</a>
                                                </h3>
                                                <p class="text-muted mb-2">
                                                    <s class="me-2 text-gray-500">$30.00</s><span>$15.00</span>
                                                </p>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item me-0">
                                                        <input class="product-color-input disabled d-none"
                                                               id="product1_color3"
                                                               type="radio" name="product3colors"/>
                                                        <label class="product-color" for="product1_color3"
                                                               data-id="product1_color3" style="background: #72a6b6"
                                                               data-img="img/product/5161335400_1_1_1.jpg"></label>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <input class="product-color-input disabled d-none"
                                                               id="product1_color4"
                                                               type="radio" name="product3colors"/>
                                                        <label class="product-color" for="product1_color4"
                                                               data-id="product1_color4" style="background: #7ede9a"
                                                               data-img="img/product/5161335400_2_3_1.jpg"></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /product-->
                            <!-- product type 1-->
                            <div class="col-xxl-4 col-sm-6">
                                <div class="product product-type-1">
                                    <div class="product-image border-0"><img class="img-fluid"
                                                                             src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0027211800_1_2_1.jpg"
                                                                             alt="product"/>
                                        <div class="product-hover-overlay"><a class="product-hover-overlay-link"
                                                                              href="detail-1.html"></a><a
                                                class="product-wishlist btn btn-link btn-lg text-dark p-0" href="#!">
                                                <svg class="svg-icon svg-icon-md svg-icon-heavy">
                                                    <use xlink:href="#heart-1"></use>
                                                </svg>
                                            </a>
                                            <div class="product-hover-overlay-buttons">
                                                <ul class="list-unstyled">
                                                    <li class="my-2"><a
                                                            class="btn btn-outline-dark product-btn-animated d-none d-sm-inline-block w-100 px-3 py-0"
                                                            href="#!" data-bs-toggle="modal"
                                                            data-bs-target="#quickView"><span
                                                                class="product-animated-text">Quick view</span><span
                                                                class="product-animated-icon">
                              <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                <use xlink:href="#expand-1"> </use>
                              </svg></span></a></li>
                                                    <li class="my-2"><a
                                                            class="btn btn-outline-dark product-btn-animated d-none d-sm-inline-block w-100 px-3 py-0"
                                                            href="#!"><span
                                                                class="product-animated-text">Quick shop </span><span
                                                                class="product-animated-icon">
                              <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                <use xlink:href="#cart-1"> </use>
                              </svg></span></a></li>
                                                </ul>
                                            </div>
                                            <div class="product-info p-3 position-absolute bottom-0 start-0">
                                                <h3 class="h6 mb-1"><a class="text-dark" href="detail-1.html">Carrot-fit
                                                        jeans</a></h3>
                                                <p class="text-muted mb-2"><span>$60.00</span>
                                                </p>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item me-0">
                                                        <input class="product-color-input disabled d-none"
                                                               id="product1_color4"
                                                               type="radio" name="product4colors"/>
                                                        <label class="product-color" for="product1_color4"
                                                               data-id="product1_color4" style="background: #414c54"
                                                               data-img="img/product/0027211800_1_2_1.jpg"></label>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <input class="product-color-input disabled d-none"
                                                               id="product1_color5"
                                                               type="radio" name="product4colors"/>
                                                        <label class="product-color" for="product1_color5"
                                                               data-id="product1_color5" style="background: #85e4ec"
                                                               data-img="img/product/0027211800_2_1_1.jpg"></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /product-->
                            <!-- product type 1-->
                            <div class="col-xxl-4 col-sm-6">
                                <div class="product product-type-1">
                                    <div class="product-image border-0"><img class="img-fluid"
                                                                             src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0144074800_1_1_1.jpg"
                                                                             alt="product"/>
                                        <div class="product-hover-overlay"><a class="product-hover-overlay-link"
                                                                              href="detail-1.html"></a><a
                                                class="product-wishlist btn btn-link btn-lg text-dark p-0" href="#!">
                                                <svg class="svg-icon svg-icon-md svg-icon-heavy">
                                                    <use xlink:href="#heart-1"></use>
                                                </svg>
                                            </a>
                                            <div class="product-hover-overlay-buttons">
                                                <ul class="list-unstyled">
                                                    <li class="my-2"><a
                                                            class="btn btn-outline-dark product-btn-animated d-none d-sm-inline-block w-100 px-3 py-0"
                                                            href="#!" data-bs-toggle="modal"
                                                            data-bs-target="#quickView"><span
                                                                class="product-animated-text">Quick view</span><span
                                                                class="product-animated-icon">
                              <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                <use xlink:href="#expand-1"> </use>
                              </svg></span></a></li>
                                                    <li class="my-2"><a
                                                            class="btn btn-outline-dark product-btn-animated d-none d-sm-inline-block w-100 px-3 py-0"
                                                            href="#!"><span
                                                                class="product-animated-text">Quick shop </span><span
                                                                class="product-animated-icon">
                              <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                <use xlink:href="#cart-1"> </use>
                              </svg></span></a></li>
                                                </ul>
                                            </div>
                                            <div class="product-info p-3 position-absolute bottom-0 start-0">
                                                <h3 class="h6 mb-1"><a class="text-dark" href="detail-1.html">Striped
                                                        T-Shirt</a></h3>
                                                <p class="text-muted mb-2"><span>$30.99</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /product-->
                            <!-- product type 1-->
                            <div class="col-xxl-4 col-sm-6">
                                <div class="product product-type-1">
                                    <div class="product-image border-0">
                                        <div class="product-label bg-danger">Sold out</div>
                                        <img class="img-fluid"
                                             src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0693492802_1_1_1.jpg"
                                             alt="product"/>
                                        <div class="product-hover-overlay"><a class="product-hover-overlay-link"
                                                                              href="detail-1.html"></a><a
                                                class="product-wishlist btn btn-link btn-lg text-dark p-0" href="#!">
                                                <svg class="svg-icon svg-icon-md svg-icon-heavy">
                                                    <use xlink:href="#heart-1"></use>
                                                </svg>
                                            </a>
                                            <div class="product-hover-overlay-buttons">
                                                <ul class="list-unstyled">
                                                    <li class="my-2"><a
                                                            class="btn btn-outline-dark product-btn-animated d-none d-sm-inline-block w-100 px-3 py-0"
                                                            href="#!" data-bs-toggle="modal"
                                                            data-bs-target="#quickView"><span
                                                                class="product-animated-text">Quick view</span><span
                                                                class="product-animated-icon">
                              <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                <use xlink:href="#expand-1"> </use>
                              </svg></span></a></li>
                                                    <li class="my-2"><a
                                                            class="btn btn-outline-dark product-btn-animated d-none d-sm-inline-block w-100 px-3 py-0"
                                                            href="#!"><span
                                                                class="product-animated-text">Quick shop </span><span
                                                                class="product-animated-icon">
                              <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                <use xlink:href="#cart-1"> </use>
                              </svg></span></a></li>
                                                </ul>
                                            </div>
                                            <div class="product-info p-3 position-absolute bottom-0 start-0">
                                                <h3 class="h6 mb-1"><a class="text-dark" href="detail-1.html">Short
                                                        top</a>
                                                </h3>
                                                <p class="text-muted mb-2">
                                                    <s class="me-2 text-gray-500">$40.00</s><span>$16.00</span>
                                                </p>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item me-0">
                                                        <input class="product-color-input disabled d-none"
                                                               id="product1_color6"
                                                               type="radio" name="product6colors"/>
                                                        <label class="product-color" for="product1_color6"
                                                               data-id="product1_color6" style="background: #f394f3"
                                                               data-img="img/product/0693492802_1_1_1.jpg"></label>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <input class="product-color-input disabled d-none"
                                                               id="product1_color7"
                                                               type="radio" name="product6colors"/>
                                                        <label class="product-color" for="product1_color7"
                                                               data-id="product1_color7" style="background: #1cc768"
                                                               data-img="img/product/0693492802_2_1_1.jpg"></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /product-->
                            <!-- product type 1-->
                            <div class="col-xxl-4 col-sm-6">
                                <div class="product product-type-1">
                                    <div class="product-image border-0">
                                        <div class="product-label bg-danger">Sold out</div>
                                        <img class="img-fluid"
                                             src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0364326148_1_1_1.jpg"
                                             alt="product"/>
                                        <div class="product-hover-overlay"><a class="product-hover-overlay-link"
                                                                              href="detail-1.html"></a><a
                                                class="product-wishlist btn btn-link btn-lg text-dark p-0" href="#!">
                                                <svg class="svg-icon svg-icon-md svg-icon-heavy">
                                                    <use xlink:href="#heart-1"></use>
                                                </svg>
                                            </a>
                                            <div class="product-hover-overlay-buttons">
                                                <ul class="list-unstyled">
                                                    <li class="my-2"><a
                                                            class="btn btn-outline-dark product-btn-animated d-none d-sm-inline-block w-100 px-3 py-0"
                                                            href="#!" data-bs-toggle="modal"
                                                            data-bs-target="#quickView"><span
                                                                class="product-animated-text">Quick view</span><span
                                                                class="product-animated-icon">
                              <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                <use xlink:href="#expand-1"> </use>
                              </svg></span></a></li>
                                                    <li class="my-2"><a
                                                            class="btn btn-outline-dark product-btn-animated d-none d-sm-inline-block w-100 px-3 py-0"
                                                            href="#!"><span
                                                                class="product-animated-text">Quick shop </span><span
                                                                class="product-animated-icon">
                              <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                <use xlink:href="#cart-1"> </use>
                              </svg></span></a></li>
                                                </ul>
                                            </div>
                                            <div class="product-info p-3 position-absolute bottom-0 start-0">
                                                <h3 class="h6 mb-1"><a class="text-dark" href="detail-1.html">Ethnic
                                                        Sweater</a>
                                                </h3>
                                                <p class="text-muted mb-2">
                                                    <s class="me-2 text-gray-500">$40.00</s><span>$30.00</span>
                                                </p>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item me-0">
                                                        <input class="product-color-input disabled d-none"
                                                               id="product1_color7"
                                                               type="radio" name="product7colors"/>
                                                        <label class="product-color" for="product1_color7"
                                                               data-id="product1_color7" style="background: #d8e8e8"
                                                               data-img="img/product/0364326148_1_1_1.jpg"></label>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <input class="product-color-input disabled d-none"
                                                               id="product1_color8"
                                                               type="radio" name="product7colors"/>
                                                        <label class="product-color" for="product1_color8"
                                                               data-id="product1_color8" style="background: #7ede9a"
                                                               data-img="img/product/0364326148_2_1_1.jpg"></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /product-->
                            <!-- product type 1-->
                            <div class="col-xxl-4 col-sm-6">
                                <div class="product product-type-1">
                                    <div class="product-image border-0"><img class="img-fluid"
                                                                             src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/img/product/0931168712_1_1_1.jpg"
                                                                             alt="product"/>
                                        <div class="product-hover-overlay"><a class="product-hover-overlay-link"
                                                                              href="detail-1.html"></a><a
                                                class="product-wishlist btn btn-link btn-lg text-dark p-0" href="#!">
                                                <svg class="svg-icon svg-icon-md svg-icon-heavy">
                                                    <use xlink:href="#heart-1"></use>
                                                </svg>
                                            </a>
                                            <div class="product-hover-overlay-buttons">
                                                <ul class="list-unstyled">
                                                    <li class="my-2"><a
                                                            class="btn btn-outline-dark product-btn-animated d-none d-sm-inline-block w-100 px-3 py-0"
                                                            href="#!" data-bs-toggle="modal"
                                                            data-bs-target="#quickView"><span
                                                                class="product-animated-text">Quick view</span><span
                                                                class="product-animated-icon">
                              <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                <use xlink:href="#expand-1"> </use>
                              </svg></span></a></li>
                                                    <li class="my-2"><a
                                                            class="btn btn-outline-dark product-btn-animated d-none d-sm-inline-block w-100 px-3 py-0"
                                                            href="#!"><span
                                                                class="product-animated-text">Quick shop </span><span
                                                                class="product-animated-icon">
                              <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                <use xlink:href="#cart-1"> </use>
                              </svg></span></a></li>
                                                </ul>
                                            </div>
                                            <div class="product-info p-3 position-absolute bottom-0 start-0">
                                                <h3 class="h6 mb-1"><a class="text-dark" href="detail-1.html">Beige</a>
                                                </h3>
                                                <p class="text-muted mb-2"><span>$40.00</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /product-->
                        </div>
                        <nav class="d-flex justify-content-center mb-5 mt-3" aria-label="page navigation">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-arrow" href="#" aria-label="Previous"><span
                                            aria-hidden="true">
                    <svg class="svg-icon page-icon">
                      <use xlink:href="#angle-left-1"> </use>
                    </svg></span><span class="sr-only">Previous</span></a></li>
                                <li class="page-item active"><a class="page-link" href="#">1 </a></li>
                                <li class="page-item"><a class="page-link" href="#">2 </a></li>
                                <li class="page-item"><a class="page-link" href="#">3 </a></li>
                                <li class="page-item"><a class="page-link" href="#">4 </a></li>
                                <li class="page-item"><a class="page-link" href="#">5 </a></li>
                                <li class="page-item"><a class="page-arrow" href="#" aria-label="Next"><span
                                            aria-hidden="true">
                    <svg class="svg-icon page-icon">
                      <use xlink:href="#angle-right-1"> </use>
                    </svg></span><span class="sr-only">Next     </span></a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Sidebar-->
                    <div class="sidebar col-xl-3 col-lg-4 pe-xl-5 order-lg-1">


                        <div class="sidebar-block px-3 px-lg-0">
                            {!! $dataManagerPage["categoriesHtml"] !!}
                        </div>
                        <div class="sidebar-block px-3 px-lg-0"><a class="d-lg-none block-toggler"
                                                                   data-bs-toggle="collapse"
                                                                   href="#priceFilterMenu" aria-expanded="false"
                                                                   aria-controls="priceFilterMenu">Filter by price<span
                                    class="block-toggler-icon"></span></a>
                            <div class="expand-lg collapse" id="priceFilterMenu">
                                <h5 class="sidebar-heading d-none d-lg-block">Price </h5>
                                <div class="mt-4 mt-lg-0" id="slider-snap"></div>
                                <div class="nouislider-values">
                                    <div class="min">From $<span id="slider-snap-value-lower"></span></div>
                                    <div class="max">To $<span id="slider-snap-value-upper"></span></div>
                                    <input class="slider-snap-input" type="hidden" name="pricefrom"
                                           id="slider-snap-input-lower"
                                           value="40">
                                    <input class="slider-snap-input" type="hidden" name="priceto"
                                           id="slider-snap-input-upper"
                                           value="110">
                                </div>
                            </div>
                        </div>
                        <div class="sidebar-block px-3 px-lg-0"><a class="d-lg-none block-toggler"
                                                                   data-bs-toggle="collapse"
                                                                   href="#brandFilterMenu" aria-expanded="true"
                                                                   aria-controls="brandFilterMenu">Filter by brand<span
                                    class="block-toggler-icon"></span></a>
                            <!-- Brand filter menu - this menu has .show class, so is expanded by default-->
                            <div class="expand-lg collapse show" id="brandFilterMenu">
                                <h5 class="sidebar-heading d-none d-lg-block">Brands </h5>
                                <form class="mt-4 mt-lg-0" action="#">
                                    <div class="mb-3 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" id="brand0" type="checkbox"
                                                   name="clothes-brand"
                                                   checked>
                                            <label class="form-check-label" for="brand0">Calvin Klein
                                                <small>(18)</small></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" id="brand1" type="checkbox"
                                                   name="clothes-brand"
                                                   checked>
                                            <label class="form-check-label" for="brand1">Levi Strauss
                                                <small>(30)</small></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" id="brand2" type="checkbox"
                                                   name="clothes-brand">
                                            <label class="form-check-label" for="brand2">Hugo Boss
                                                <small>(120)</small></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" id="brand3" type="checkbox"
                                                   name="clothes-brand">
                                            <label class="form-check-label" for="brand3">Tomi Hilfiger
                                                <small>(70)</small></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" id="brand4" type="checkbox"
                                                   name="clothes-brand">
                                            <label class="form-check-label" for="brand4">Tom Ford
                                                <small>(110)</small></label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="sidebar-block px-3 px-lg-0"><a class="d-lg-none block-toggler"
                                                                   data-bs-toggle="collapse"
                                                                   href="#sizeFilterMenu" aria-expanded="false"
                                                                   aria-controls="sizeFilterMenu">Filter by size<span
                                    class="block-toggler-icon"></span></a>
                            <!-- Size filter menu-->
                            <div class="expand-lg collapse" id="sizeFilterMenu">
                                <h5 class="sidebar-heading d-none d-lg-block">Size </h5>
                                <form class="mt-4 mt-lg-0" action="#">
                                    <div class="mb-3 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" id="size0" type="radio" name="size" checked>
                                            <label class="form-check-label" for="size0">Small</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" id="size1" type="radio" name="size">
                                            <label class="form-check-label" for="size1">Medium</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" id="size2" type="radio" name="size">
                                            <label class="form-check-label" for="size2">Large</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" id="size3" type="radio" name="size">
                                            <label class="form-check-label" for="size3">X-Large</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="sidebar-block px-3 px-lg-0"><a class="d-lg-none block-toggler"
                                                                   data-bs-toggle="collapse"
                                                                   href="#colourFilterMenu" aria-expanded="false"
                                                                   aria-controls="colourFilterMenu">Filter by
                                colour<span
                                    class="block-toggler-icon"></span></a>
                            <!-- Size filter menu-->
                            <div class="expand-lg collapse" id="colourFilterMenu">
                                <h5 class="sidebar-heading d-none d-lg-block">Colour </h5>
                                <div class="mt-4 mt-lg-0">
                                    <ul class="list-inline mb-0 colours-wrapper">
                                        <li class="list-inline-item">
                                            <label class="btn-colour" for="colour_sidebar_Blue"
                                                   style="background-color: #668cb9" data-allow-multiple> </label>
                                            <input class="input-invisible" type="checkbox" name="colour"
                                                   value="value_sidebar_Blue" id="colour_sidebar_Blue">
                                        </li>
                                        <li class="list-inline-item">
                                            <label class="btn-colour" for="colour_sidebar_White"
                                                   style="background-color: #fff"
                                                   data-allow-multiple> </label>
                                            <input class="input-invisible" type="checkbox" name="colour"
                                                   value="value_sidebar_White" id="colour_sidebar_White">
                                        </li>
                                        <li class="list-inline-item">
                                            <label class="btn-colour" for="colour_sidebar_Violet"
                                                   style="background-color: #8b6ea4" data-allow-multiple> </label>
                                            <input class="input-invisible" type="checkbox" name="colour"
                                                   value="value_sidebar_Violet" id="colour_sidebar_Violet">
                                        </li>
                                        <li class="list-inline-item">
                                            <label class="btn-colour" for="colour_sidebar_Red"
                                                   style="background-color: #dd6265"
                                                   data-allow-multiple> </label>
                                            <input class="input-invisible" type="checkbox" name="colour"
                                                   value="value_sidebar_Red" id="colour_sidebar_Red">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Sidebar end-->
                </div>
            @else
                <h1 messagePage="{{$dataManagerPage["messagePage"]}}"> No existe Productos.</h1>
            @endif
        </div>

    </div>

@endsection
