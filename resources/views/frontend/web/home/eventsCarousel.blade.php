<!--====================  End of breadcrumb area  ====================-->

<!--====================  page content wrapper ====================-->

<div class="page-content-wrapper">
    <!--=======  product carousel area  =======-->

    <div class="product-carousel-area section-space">
        <!--====================  product slider area ====================-->

        <div class="product-slider-area">
            <div class="container">
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
                            @if(count($dataManagerPage['eventsCarouse'])==0)
                                <div class="col">

                                    <div class="single-grid-product">
                                        <div class="single-grid-product__image">

                                            <a href="product-details-basic.html" class="image-wrap">
                                                <img
                                                    src="<?php echo $resourcePathServer ?>frontend/assets/img/products/product-16-1-600x800.jpg"
                                                    class="img-fluid" alt="">
                                                <img
                                                    src="<?php echo $resourcePathServer ?>frontend/assets/img/products/product-16-2-600x800.jpg"
                                                    class="img-fluid" alt="">
                                            </a>
                                            <div class="product-hover-icon-wrapper">
                                                <span class="single-icon single-icon--quick-view"><a class="cd-trigger"
                                                                                                     href="#qv-1"
                                                                                                     data-tippy="Ver"
                                                                                                     data-tippy-inertia="true"
                                                                                                     data-tippy-animation="shift-away"
                                                                                                     data-tippy-delay="50"
                                                                                                     data-tippy-arrow="true"
                                                                                                     data-tippy-theme="sharpborder"><i
                                                            class="fa fa-search"></i></a></span>
                                                <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                      data-tippy="VER"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                            class="fa fa-shopping-basket"></i> <span>VER</span></a></span>

                                            </div>
                                        </div>
                                        <div class="single-grid-product__content">
                                            <h3 class="title"><a href="product-details-basic.html">Olivia Shayn Cover
                                                    Chair</a></h3>
                                            <div class="price not-view"><span class="main-price">$98</span></div>
                                            <div class="description">
                                                Lore is very data information why is beatifull ,and to description to
                                                do.
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="col">

                                    <div class="single-grid-product">
                                        <div class="single-grid-product__image">

                                            <a href="product-details-basic.html" class="image-wrap">
                                                <img
                                                    src="<?php echo $resourcePathServer ?>frontend/assets/img/products/product-16-1-600x800.jpg"
                                                    class="img-fluid" alt="">
                                                <img
                                                    src="<?php echo $resourcePathServer ?>frontend/assets/img/products/product-16-2-600x800.jpg"
                                                    class="img-fluid" alt="">
                                            </a>
                                            <div class="product-hover-icon-wrapper">
                                                <span class="single-icon single-icon--quick-view"><a class="cd-trigger"
                                                                                                     href="#qv-1"
                                                                                                     data-tippy="Ver"
                                                                                                     data-tippy-inertia="true"
                                                                                                     data-tippy-animation="shift-away"
                                                                                                     data-tippy-delay="50"
                                                                                                     data-tippy-arrow="true"
                                                                                                     data-tippy-theme="sharpborder"><i
                                                            class="fa fa-search"></i></a></span>
                                                <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                      data-tippy="VER"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                            class="fa fa-shopping-basket"></i> <span>VER</span></a></span>

                                            </div>
                                        </div>
                                        <div class="single-grid-product__content">
                                            <h3 class="title"><a href="product-details-basic.html">Olivia Shayn Cover
                                                    Chair</a></h3>
                                            <div class="price not-view"><span class="main-price">$98</span></div>
                                            <div class="description">
                                                Lore is very data information why is beatifull ,and to description to
                                                do.
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="col">

                                    <div class="single-grid-product">
                                        <div class="single-grid-product__image">

                                            <a href="product-details-basic.html" class="image-wrap">
                                                <img
                                                    src="<?php echo $resourcePathServer ?>frontend/assets/img/products/product-16-1-600x800.jpg"
                                                    class="img-fluid" alt="">
                                                <img
                                                    src="<?php echo $resourcePathServer ?>frontend/assets/img/products/product-16-2-600x800.jpg"
                                                    class="img-fluid" alt="">
                                            </a>
                                            <div class="product-hover-icon-wrapper">
                                                <span class="single-icon single-icon--quick-view"><a class="cd-trigger"
                                                                                                     href="#qv-1"
                                                                                                     data-tippy="Ver"
                                                                                                     data-tippy-inertia="true"
                                                                                                     data-tippy-animation="shift-away"
                                                                                                     data-tippy-delay="50"
                                                                                                     data-tippy-arrow="true"
                                                                                                     data-tippy-theme="sharpborder"><i
                                                            class="fa fa-search"></i></a></span>
                                                <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                      data-tippy="VER"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                            class="fa fa-shopping-basket"></i> <span>VER</span></a></span>

                                            </div>
                                        </div>
                                        <div class="single-grid-product__content">
                                            <h3 class="title"><a href="product-details-basic.html">Olivia Shayn Cover
                                                    Chair</a></h3>
                                            <div class="price not-view"><span class="main-price">$98</span></div>
                                            <div class="description">
                                                Lore is very data information why is beatifull ,and to description to
                                                do.
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="col">

                                    <div class="single-grid-product">
                                        <div class="single-grid-product__image">

                                            <a href="product-details-basic.html" class="image-wrap">
                                                <img
                                                    src="<?php echo $resourcePathServer ?>frontend/assets/img/products/product-16-1-600x800.jpg"
                                                    class="img-fluid" alt="">
                                                <img
                                                    src="<?php echo $resourcePathServer ?>frontend/assets/img/products/product-16-2-600x800.jpg"
                                                    class="img-fluid" alt="">
                                            </a>
                                            <div class="product-hover-icon-wrapper">
                                                <span class="single-icon single-icon--quick-view"><a class="cd-trigger"
                                                                                                     href="#qv-1"
                                                                                                     data-tippy="Ver"
                                                                                                     data-tippy-inertia="true"
                                                                                                     data-tippy-animation="shift-away"
                                                                                                     data-tippy-delay="50"
                                                                                                     data-tippy-arrow="true"
                                                                                                     data-tippy-theme="sharpborder"><i
                                                            class="fa fa-search"></i></a></span>
                                                <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                      data-tippy="VER"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                            class="fa fa-shopping-basket"></i> <span>VER</span></a></span>

                                            </div>
                                        </div>
                                        <div class="single-grid-product__content">
                                            <h3 class="title"><a href="product-details-basic.html">Olivia Shayn Cover
                                                    Chair</a></h3>
                                            <div class="price not-view"><span class="main-price">$98</span></div>
                                            <div class="description">
                                                Lore is very data information why is beatifull ,and to description to
                                                do.
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <div class="col">

                                    <div class="single-grid-product">
                                        <div class="single-grid-product__image">

                                            <a href="product-details-basic.html" class="image-wrap">
                                                <img
                                                    src="<?php echo $resourcePathServer ?>frontend/assets/img/products/product-16-1-600x800.jpg"
                                                    class="img-fluid" alt="">
                                                <img
                                                    src="<?php echo $resourcePathServer ?>frontend/assets/img/products/product-16-2-600x800.jpg"
                                                    class="img-fluid" alt="">
                                            </a>
                                            <div class="product-hover-icon-wrapper">
                                                <span class="single-icon single-icon--quick-view"><a class="cd-trigger"
                                                                                                     href="#qv-1"
                                                                                                     data-tippy="Ver"
                                                                                                     data-tippy-inertia="true"
                                                                                                     data-tippy-animation="shift-away"
                                                                                                     data-tippy-delay="50"
                                                                                                     data-tippy-arrow="true"
                                                                                                     data-tippy-theme="sharpborder"><i
                                                            class="fa fa-search"></i></a></span>
                                                <span class="single-icon single-icon--add-to-cart"><a href="#"
                                                                                                      data-tippy="VER"
                                                                                                      data-tippy-inertia="true"
                                                                                                      data-tippy-animation="shift-away"
                                                                                                      data-tippy-delay="50"
                                                                                                      data-tippy-arrow="true"
                                                                                                      data-tippy-theme="sharpborder"><i
                                                            class="fa fa-shopping-basket"></i> <span>VER</span></a></span>

                                            </div>
                                        </div>
                                        <div class="single-grid-product__content">
                                            <h3 class="title"><a href="product-details-basic.html">Olivia Shayn Cover
                                                    Chair</a></h3>
                                            <div class="price not-view"><span class="main-price">$98</span></div>
                                            <div class="description">
                                                Lore is very data information why is beatifull ,and to description to
                                                do.
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            @else
                                @foreach ($dataManagerPage['eventsCarouse'] as $key =>$row)

                                    <?php
                                    $urlCurrent = route('eventDetails', app()->getLocale()) . "/" . $row['id'];

                                    ?>
                                    <div class="col">

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper ">
                                                    <span class="onsale onsale--business">{{$row['business']}}</span>
                                                </div>
                                                <a href="{{$urlCurrent}}" class="image-wrap">
                                                    <img
                                                        src="<?php echo $resourcePathServer . '' . $row['source']?>"
                                                        class="img-fluid" alt="">

                                                </a>
                                                <div class="product-hover-icon-wrapper">
                                                <span class="single-icon single-icon--quick-view">
                                                    <a
                                                        data="{{json_encode($row)}}"
                                                        id="row-{{$row['id']}}"
                                                        class="cd-trigger--manager-quick-view-home"
                                                        href="#qv-1"
                                                        data-tippy="{{__('config.buttons.two')}}"
                                                        data-tippy-inertia="true"
                                                        data-tippy-animation="shift-away"
                                                        data-tippy-delay="50"
                                                        data-tippy-arrow="true"
                                                        data-tippy-theme="sharpborder"><i
                                                            class="fa fa-search"></i></a></span>
                                                    @if($dataManagerPage['shopConfig']['allow'])
                                                        <span class="single-icon single-icon--add-to-cart">
                                                            <a
                                                                class="management-take-part"
                                                                id="row-management-{{$row['id']}}"
                                                                data-tippy="{{__('config.buttons.three')}}"
                                                                data-tippy-inertia="true"
                                                                data-tippy-animation="shift-away"
                                                                data-tippy-delay="50"
                                                                data-tippy-arrow="true"
                                                                data-tippy-theme="sharpborder"><i
                                                                    class="fa fa-shopping-basket"></i> <span>{{__('config.buttons.three')}}</span></a></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h1 class="title"><a href="{{$urlCurrent}}">
                                                        {{$row['value']}}


                                                    </a>

                                                </h1>

                                                <h6 class="subtitle">Fecha maxima
                                                    inscripcion: {{$row['date_end_project']}}</h6>
                                                <div class="price not-view"><span class="main-price">$98</span></div>
                                                @if($row['description']!='' && $row['description']!='null')
                                                    <div class="description">
                                                        {{$row['description']}}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!--=======  End of product slider wrapper  =======-->
                    </div>


                </div>
            </div>
        </div>

        <!--====================  End of product slider area  ====================-->
    </div>

    <!--=======  End of product carousel area  =======-->


</div>
