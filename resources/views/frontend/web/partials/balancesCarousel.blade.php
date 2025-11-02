@if(count($dataBalances)==0)

@else
    <div class="page-content-wrapper">
        <!--=======  product carousel area  =======-->

        <div class="product-carousel-area section-space">
            <!--====================  product slider area ====================-->

            <div class="product-slider-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="section-title-area text-left">
                                <h2 class="section-title section-title--not-after section-title--custom">
                                    <a class="section-title__link" href="{{  route('shopBalances', app()->getLocale()) }}" target="_blank">
                                        {{__('labels.thirty-one')}}
                                    </a>
                                  </h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-12">
                            <!--=======  product slider wrapper  =======-->

                            <div class="product-balances-slider-wrapper " data-slick-setting='{
                        "slidesToShow": 4,
                        "data-lg-items":4,
                        "slidesToScroll": 4,
                        "arrows": true,
                        "dots": true,
                        "autoplay": true,
                        "speed": 500,
                        "prevArrow": {"buttonClass": "slick-prev", "iconClass": "fa fa-angle-left" },
                        "nextArrow": {"buttonClass": "slick-next", "iconClass": "fa fa-angle-right" }
                    }'>

                                @foreach ($dataBalances as $key =>$row)

                                    <?php
                                    $urlCurrent = route('productDetails', app()->getLocale()) . "/" . $row['id'];
                                    $valueCurrent = $row['sale_price'];
                                    if ($row['business_by_discount_id']) {
                                        $business_by_discount_value = ($row['business_by_discount_value']);
                                        $valueWithoutDiscount = $valueCurrent;
                                        $valueWithDiscount = $valueCurrent - ($valueCurrent * $business_by_discount_value) / 100;
                                        $price_before = $valueWithoutDiscount;
                                        $price_discount = $valueWithDiscount;
                                        $allow_discount = 1;
                                        $promotion_id = $row['business_by_discount_id'];
                                        $priceCurrent = $price_discount;
                                    } else {

                                        $priceCurrent = $valueCurrent;
                                    }


                                    ?>

                                    <div class="col">

                                        <div class="single-grid-product">
                                            <div class="single-grid-product__image">
                                                <div class="product-badge-wrapper ">
                                                    @if($row['business_by_discount_id'])
                                                        <span
                                                            class="onsale ">-{{$row['business_by_discount_value']}}%</span>
                                                        <span class="hot not-view"
                                                              id="product-badge-wrapper__hot">Hot</span>
                                                    @endif
                                                </div>
                                                <a href="{{$urlCurrent}}" class="image-wrap">
                                                    <img
                                                        src="<?php echo $resourcePathServer . '' . $row['source']?>"
                                                        class="img-fluid" alt="">

                                                </a>
                                                <div class="product-hover-icon-wrapper " id="row-balance-{{$row['id']}}">
                                                        <span class="single-icon single-icon--quick-view">
                                                    <a
                                                        data="{{json_encode($row)}}"
                                                        id="row-{{$row['id']}}"
                                                        class="cd-trigger--manager-quick-view-home"
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
                                                                class="management-balances add-cart"
                                                                id="row-management-{{$row['id']}}"
                                                                data-tippy="{{__('config.buttons.one')}}"
                                                                data-tippy-inertia="true"
                                                                data-tippy-animation="shift-away"
                                                                data-tippy-delay="50"
                                                                data-tippy-arrow="true"
                                                                data-tippy-theme="sharpborder"><i
                                                                    class="fa fa-shopping-basket"></i> <span>{{__('config.buttons.one')}}</span></a></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="single-grid-product__content">
                                                <h3 class="title">
                                                    <a href="{{$urlCurrent}}">
                                                    <a href="{{$urlCurrent}}">
                                                        {{$row['name']}}
                                                    </a>
                                                </h3>
                                                @if($row['business_by_discount_id'])

                                                    <div class="price">
                                                        <span class="main-price discounted">${{$valueCurrent}}</span>
                                                        <span
                                                            class="main-price">${{$priceCurrent}}</span></div>
                                                @else
                                                    <div class="price"><span
                                                            class="main-price">${{$priceCurrent}}</span></div>

                                                @endif
                                                <a  class="favorite-icon" data-tippy="{{__('labels.forty-seven') }}" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder" data-tippy-placement="left">
                                                    <i class="fa fa-heart-o"></i>
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>

                                    </div>

                                @endforeach

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

@endif
