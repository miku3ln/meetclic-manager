

<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>

<div class="category-area section-space--small">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="section-title-area text-center">
                    <h2 class="section-title">Trending Categories</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <!--=======  ctaegory grid wrapper  =======-->

                <div class="category-grid-wrapper">
                    <div class="row">
                        <div class="col-md-4">
                            <!--=======  single-category  =======-->

                            <div class="single-category single-category--type-one text-center">
                                <div class="single-category--type-one__image">
                                    <a href="shop-left-sidebar.html"><img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/categories/category-1.jpg')}}" class="img-fluid" alt=""></a>
                                </div>
                                <div class="single-category--type-one__content">
                                    <h2 class="title mb-0">Living Room</h2>
                                    <a href="shop-left-sidebar.html" class="category-button category-button--shop-now">SHOP NOW <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <!--=======  End of single-category  =======-->
                        </div>
                        <div class="col-md-4">
                            <!--=======  single-category  =======-->

                            <div class="single-category single-category--type-one text-center">
                                <div class="single-category--type-one__image">
                                    <a href="shop-left-sidebar.html"><img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/categories/category-2.jpg')}}" class="img-fluid" alt=""></a>
                                </div>
                                <div class="single-category--type-one__content">
                                    <h2 class="title mb-0">Outdoor</h2>
                                    <a href="shop-left-sidebar.html" class="category-button category-button--shop-now">SHOP NOW <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <!--=======  End of single-category  =======-->
                        </div>
                        <div class="col-md-4">
                            <!--=======  single-category  =======-->

                            <div class="single-category single-category--type-one text-center">
                                <div class="single-category--type-one__image">
                                    <a href="shop-left-sidebar.html"><img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/categories/category-3.jpg')}}" class="img-fluid" alt=""></a>
                                </div>
                                <div class="single-category--type-one__content">
                                    <h2 class="title mb-0">Bedroom Lighting</h2>
                                    <a href="shop-left-sidebar.html" class="category-button category-button--shop-now">SHOP NOW <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <!--=======  End of single-category  =======-->
                        </div>
                    </div>
                </div>

                <!--=======  End of ctaegory grid wrapper  =======-->
            </div>
        </div>
    </div>
</div>

<!--====================  End of category grid   ====================-->
<!--====================  banner grid area ====================-->

<div class="banner-area section-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!--=======  banner grid wrapper  =======-->

                <div class="banner-grid-wrapper">
                    <div class="row">
                        <div class="col-md-4">
                            <!--=======  single banner  =======-->

                            <div class="single-banner">
                                <div class="single-banner__image">
                                    <a href="shop-left-sidebar.html">
                                        <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/banners/simple-banner-1.jpg')}}" class="img-fluid" alt="">
                                    </a>
                                </div>

                                <div class="single-banner__content single-banner__content--overlay">
                                    <p class="banner-small-text">OUTDOOR ENTERTAINING</p>
                                    <p class="banner-big-text">Decorative Lighting</p>
                                    <p class="banner-small-text banner-small-text--end">50% Off For Limited Time</p>
                                    <a href="shop-left-sidebar.html" class="theme-button theme-button--alt theme-button--banner">SHOP NOW</a>
                                </div>
                            </div>

                            <!--=======  End of single banner  =======-->
                        </div>
                        <div class="col-md-4">
                            <!--=======  single banner  =======-->

                            <div class="single-banner">
                                <div class="single-banner__image">
                                    <a href="shop-left-sidebar.html">
                                        <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/banners/simple-banner-2.jpg')}}" class="img-fluid" alt="">
                                    </a>
                                </div>

                                <div class="single-banner__content single-banner__content--overlay">
                                    <p class="banner-small-text">BROWSE OUR CURATED COLLECTIONS</p>
                                    <p class="banner-big-text">New In</p>
                                    <p class="banner-small-text banner-small-text--end">Liang & Eimil</p>
                                    <a href="shop-left-sidebar.html" class="theme-button theme-button--alt theme-button--banner">SHOP NOW</a>
                                </div>
                            </div>

                            <!--=======  End of single banner  =======-->
                        </div>
                        <div class="col-md-4">
                            <!--=======  single banner  =======-->

                            <div class="single-banner">
                                <div class="single-banner__image">
                                    <a href="shop-left-sidebar.html">
                                        <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/banners/simple-banner-3.jpg')}}" class="img-fluid" alt="">
                                    </a>
                                </div>

                                <div class="single-banner__content single-banner__content--overlay">
                                    <p class="banner-small-text">STYLING SAVINGS</p>
                                    <p class="banner-big-text">Designer Furniture</p>
                                    <p class="banner-small-text banner-small-text--end">30% Off Armchairs</p>
                                    <a href="shop-left-sidebar.html" class="theme-button theme-button--alt theme-button--banner">SHOP NOW</a>
                                </div>
                            </div>

                            <!--=======  End of single banner  =======-->
                        </div>
                    </div>
                </div>

                <!--=======  End of banner grid wrapper  =======-->
            </div>
        </div>
    </div>
</div>
