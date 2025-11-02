{{-- NONE CMS-TEMPLATE --}}
@extends('layouts.cityBook')
@section('additional-styles')
    <style>

        h1.title {
            float: left;
            width: 100%;
            text-align: center;
            color: #4db7fe;
            font-size: 34px;
            font-weight: 700;
        }
    </style>
@endsection
@section('additional-scripts')

    <script>
        $(function () {

            $('.header-search').show();
        })
    </script>
@endsection



@if(  $dataManagerPage['type']==1)
@section('content-manager')
    @if(isset($dataManagerPage['sliderMainManager']))
        @include('cityBook.web.partials.home.sliderMain')
    @endif
@endsection
@section('content')
    <div id="app-management">
        @if(isset($dataManagerPage['categoriesBusiness']))
            <section id="sec2" class="categories">
                <div class="container">
                    <div class="section-title">
                        <h2>{{__('frontend.menu.home.categories.title')}}</h2>
                        <div class="section-subtitle">{{__('frontend.menu.home.categories.subtitle')}}</div>
                        <span class="section-separator"></span>
                        <p>{{__('frontend.menu.home.categories.description')}}</p>
                    </div>
                    @include('layouts.partials.cityBook.categories')
                    <a href="{{route('search',app()->getLocale())}}"
                       class="btn  big-btn circle-btn dec-btn  btn--search-data"> {{__('frontend.menu.home.categories.button-search')}}
                        <i
                            class="fa fa-eye"></i></a>
                </div>
            </section>
        @endif

        @include('cityBook.web.partials.home.popularList')

        @if(!Auth::check())
            @include('layouts.partials.cityBook.join',['typeJoin'=>1,'class-content'=>'color-bg--join-home'])
        @endif

        <section>
            <div class="container">
                @include('layouts.partials.cityBook.work-it')
            </div>
        </section>
        <section class="parallax-section" data-scrollax-parent="true">
            <div class="bg bg--home" data-bg="{{URL::asset($themePath.'images/bg/40.png')}}"
            ></div>
            <div class="overlay co lor-overlay"></div>
            <!--container-->
            <div class="container">
                <div class="intro-item fl-wrap intro-item--home">
                    <h2>{{__('frontend.menu.home.background.one.title')}}</h2>
                    <h3>{{__('frontend.menu.home.background.one.subtitle')}}</h3>
                    <a class="trs-btn trs-btn--home"
                       href="{{route('search',app()->getLocale())}}">{{__('frontend.menu.home.background.one.button')}}
                        + </a>
                </div>
            </div>
        </section>

        @include('layouts.partials.cityBook.support')
        @include('layouts.partials.cityBook.counterViews')
        @if(env('allowTestimonials'))
            <section>
                <div class="container">
                    <div class="section-title">
                        <h2>{{__('frontend.menu.home.testimonials.title')}}</h2>
                        <div class="section-subtitle">{{__('frontend.menu.home.testimonials.subtitle')}}</div>
                        <span class="section-separator"></span>
                        <p>{{__('frontend.menu.home.testimonials.description')}}</p>
                    </div>
                </div>

                @include('layouts.partials.cityBook.testimonials')

            </section>
        @endif
        @if(env('allowCustomersBusiness'))
            @include('layouts.partials.cityBook.customers')
        @endif
        @if(env('allowBlog'))

            <section>
                <div class="container">
                    <div class="section-title">
                        <h2>{{__('frontend.menu.home.blog.title')}}</h2>
                        <div class="section-subtitle">{{__('frontend.menu.home.blog.subtitle')}}</div>
                        <span class="section-separator"></span>
                        <p>{{__('frontend.menu.home.blog.description')}}</p>
                    </div>
                    <div class="row home-posts">
                        <div class="col-md-4">
                            <article class="card-post">
                                <div class="card-post-img fl-wrap">
                                    <a href="blog-single.html"><img
                                            src="{{ URL::asset($themePath.'images/all/15.jpg')}}" alt=""></a>
                                </div>
                                <div class="card-post-content fl-wrap">
                                    <h3><a href="blog-single.html">Creacion de Empresas</a></h3>
                                    <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis
                                        cursus. Nulla eu mi magna. Etiam suscipit commodo gravida. </p>
                                    <div class="post-author"><a href="#"><img
                                                src="{{ URL::asset($themePath.'images/avatar/4.jpg')}}" alt=""><span>By , Alisa Noory</span></a>
                                    </div>
                                    <div class="post-opt">
                                        <ul>
                                            <li><i class="fa fa-calendar-check-o"></i> <span>25 April 2018</span></li>
                                            <li><i class="fa fa-eye"></i> <span>264</span></li>
                                            <li><i class="fa fa-tags"></i> <a href="#">Photography</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-md-4">
                            <article class="card-post">
                                <div class="card-post-img fl-wrap">
                                    <a href="blog-single.html"><img
                                            src="{{ URL::asset($themePath.'images/all/18.jpg')}}" alt=""></a>
                                </div>
                                <div class="card-post-content fl-wrap">
                                    <h3><a href="blog-single.html">Comparte y Gane</a></h3>
                                    <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis
                                        cursus. Nulla eu mi magna. Etiam suscipit commodo gravida. </p>
                                    <div class="post-author"><a href="#"><img
                                                src="{{ URL::asset($themePath.'images/avatar/5.jpg')}}" alt=""><span>By , Mery Lynn</span></a>
                                    </div>
                                    <div class="post-opt">
                                        <ul>
                                            <li><i class="fa fa-calendar-check-o"></i> <span>25 April 2018</span></li>
                                            <li><i class="fa fa-eye"></i> <span>264</span></li>
                                            <li><i class="fa fa-tags"></i> <a href="#">Design</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-md-4">
                            <article class="card-post">
                                <div class="card-post-img fl-wrap">
                                    <a href="blog-single.html"><img
                                            src="{{ URL::asset($themePath.'images/all/19.jpg')}}" alt=""></a>
                                </div>
                                <div class="card-post-content fl-wrap">
                                    <h3><a href="blog-single.html">Refiere y Gana</a></h3>
                                    <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis
                                        cursus. Nulla eu mi magna. Etiam suscipit commodo gravida. </p>
                                    <div class="post-author"><a href="#"><img
                                                src="{{ URL::asset($themePath.'images/avatar/6.jpg')}}" alt=""><span>By , Garry Dee</span></a>
                                    </div>
                                    <div class="post-opt">
                                        <ul>
                                            <li><i class="fa fa-calendar-check-o"></i> <span>25 April 2018</span></li>
                                            <li><i class="fa fa-eye"></i> <span>264</span></li>
                                            <li><i class="fa fa-tags"></i> <a href="#">Stories</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                    <a href="blog.html" class="btn  big-btn circle-btn  dec-btn color-bg flat-btn">Read All<i
                            class="fa fa-eye"></i></a>
                </div>
            </section>
        @endif
        <section class="gradient-bg gradient-bg--home-contact-us">
            <div class="cirle-bg">
                <div class="bg" data-bg="{{ URL::asset($themePath.'images/bg/circle.png')}}"></div>
            </div>
            <div class="container">
                <div class="join-wrap fl-wrap">
                    <div class="row">
                        <div class="col-md-8">
                            <h3>{{__('frontend.menu.home.do-you-have.title')}}</h3>
                            <p>{{__('frontend.menu.home.do-you-have.description')}}</p>
                        </div>
                        <div class="col-md-4"><a href="{{route('contactUsBee',app()->getLocale())}}"
                                                 class="join-wrap-btn">{{__('frontend.menu.home.do-you-have.button')}}
                                <i
                                    class="fa fa-envelope-o"></i></a></div>
                    </div>
                </div>
            </div>
        </section>


    </div>
@endsection
@elseif(  $dataManagerPage['type']==0)
@section('content')
    <div id="app-management">

        @include('layouts.partials.cityBook.home.slider.slider')

        <section id="sec2">
            <div class="container">
                <div class="section-title">
                    <h2>{{__('frontend.menu.home.categories.title')}}</h2>
                    <div class="section-subtitle">{{__('frontend.menu.home.categories.subtitle')}}</div>
                    <span class="section-separator"></span>
                    <p>{{__('frontend.menu.home.categories.description')}}</p>
                </div>

                @include('layouts.partials.cityBook.categories')

                <a href="{{route('search',app()->getLocale())}}"
                   class="btn  big-btn circle-btn dec-btn  color-bg flat-btn">View
                    All<i
                        class="fa fa-eye"></i></a>
            </div>
        </section>

        <section class="gray-section">
            <div class="container">
                <div class="section-title">
                    <h2>{{__('frontend.menu.home.listing.title')}}</h2>
                    <div class="section-subtitle">{{__('frontend.menu.home.listing.subtitle')}}</div>
                    <span class="section-separator"></span>
                    <p>{{__('frontend.menu.home.listing.description')}}</p>
                </div>
            </div>

            <div class="list-carousel fl-wrap card-listing ">

                <div class="listing-carousel  fl-wrap ">

                    <div class="slick-slide-item">

                        <div class="listing-item">
                            <article class="geodir-category-listing fl-wrap">
                                <div class="geodir-category-img">
                                    <img src="{{ URL::asset($themePath.'images/all/1.jpg')}}" alt="">
                                    <div class="overlay"></div>
                                    <div class="list-post-counter"><span>4</span><i class="fa fa-heart"></i></div>
                                </div>
                                <div class="geodir-category-content fl-wrap">
                                    <a class="listing-geodir-category" href="listing.html">Retail</a>
                                    <div class="listing-avatar"><a href="author-single.html"><img
                                                src="{{ URL::asset($themePath.'images/avatar/5.jpg')}}" alt=""></a>
                                        <span class="avatar-tooltip">Added By  <strong>Lisa Smith</strong></span>
                                    </div>
                                    <h3><a href="listing-single.html">Event in City Mol</a></h3>
                                    <p>Sed interdum metus at nisi tempor laoreet. </p>
                                    <div class="geodir-category-options fl-wrap">
                                        <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                            <span>(7 reviews)</span>
                                        </div>
                                        <div class="geodir-category-location"><a href="#"><i
                                                    class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn
                                                New York, NY 10065</a></div>
                                    </div>
                                </div>
                            </article>
                        </div>

                    </div>

                    <div class="slick-slide-item">

                        <div class="listing-item">
                            <article class="geodir-category-listing fl-wrap">
                                <div class="geodir-category-img">
                                    <img src="{{ URL::asset($themePath.'images/all/2.jpg')}}" alt="">
                                    <div class="overlay"></div>
                                    <div class="list-post-counter"><span>15</span><i class="fa fa-heart"></i></div>
                                </div>
                                <div class="geodir-category-content fl-wrap">
                                    <a class="listing-geodir-category" href="listing.html">Event</a>
                                    <div class="listing-avatar"><a href="author-single.html"><img
                                                src="{{ URL::asset($themePath.'images/avatar/2.jpg')}}" alt=""></a>
                                        <span class="avatar-tooltip">Added By  <strong>Mark Rose</strong></span>
                                    </div>
                                    <h3><a href="listing-single.html">Cafe "Lollipop"</a></h3>
                                    <p>Morbi suscipit erat in diam bibendum rutrum in nisl.</p>
                                    <div class="geodir-category-options fl-wrap">
                                        <div class="listing-rating card-popup-rainingvis" data-starrating2="4">
                                            <span>(17 reviews)</span>
                                        </div>
                                        <div class="geodir-category-location"><a href="#"><i
                                                    class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn
                                                New York, NY 10065</a></div>
                                    </div>
                                </div>
                            </article>
                        </div>

                    </div>

                    <div class="slick-slide-item">

                        <div class="listing-item">
                            <article class="geodir-category-listing fl-wrap">
                                <div class="geodir-category-img">
                                    <img src="{{ URL::asset($themePath.'images/all/20.jpg')}}" alt="">
                                    <div class="overlay"></div>
                                    <div class="list-post-counter"><span>13</span><i class="fa fa-heart"></i></div>
                                </div>
                                <div class="geodir-category-content fl-wrap">
                                    <a class="listing-geodir-category" href="listing.html">Gym </a>
                                    <div class="listing-avatar"><a href="author-single.html"><img
                                                src="{{ URL::asset($themePath.'images/avatar/4.jpg')}}" alt=""></a>
                                        <span class="avatar-tooltip">Added By  <strong>Nasty Wood</strong></span>
                                    </div>
                                    <h3><a href="listing-single.html">Gym In Brooklyn</a></h3>
                                    <p>Morbiaccumsan ipsum velit tincidunt . </p>
                                    <div class="geodir-category-options fl-wrap">
                                        <div class="listing-rating card-popup-rainingvis" data-starrating2="3">
                                            <span>(16 reviews)</span>
                                        </div>
                                        <div class="geodir-category-location"><a href="#"><i
                                                    class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn
                                                New York, NY 10065</a></div>
                                    </div>
                                </div>
                            </article>
                        </div>

                    </div>

                    <div class="slick-slide-item">

                        <div class="listing-item">
                            <article class="geodir-category-listing fl-wrap">
                                <div class="geodir-category-img">
                                    <img src="{{ URL::asset($themePath.'images/all/5.jpg')}}" alt="">
                                    <div class="overlay"></div>
                                    <div class="list-post-counter"><span>3</span><i class="fa fa-heart"></i></div>
                                </div>
                                <div class="geodir-category-content fl-wrap">
                                    <a class="listing-geodir-category" href="listing.html">Shops</a>
                                    <div class="listing-avatar"><a href="author-single.html"><img
                                                src="{{ URL::asset($themePath.'images/avatar/1.jpg')}}" alt=""></a>
                                        <span class="avatar-tooltip">Added By  <strong>Nasty Wood</strong></span>
                                    </div>
                                    <h3><a href="listing-single.html">Shop in Boutique Zone</a></h3>
                                    <p>Morbiaccumsan ipsum velit tincidunt . </p>
                                    <div class="geodir-category-options fl-wrap">
                                        <div class="listing-rating card-popup-rainingvis" data-starrating2="4">
                                            <span>(6 reviews)</span>
                                        </div>
                                        <div class="geodir-category-location"><a href="#"><i
                                                    class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn
                                                New York, NY 10065</a></div>
                                    </div>
                                </div>
                            </article>
                        </div>

                    </div>

                    <div class="slick-slide-item">

                        <div class="listing-item">
                            <article class="geodir-category-listing fl-wrap">
                                <div class="geodir-category-img">
                                    <img src="{{ URL::asset($themePath.'images/all/6.jpg')}}" alt="">
                                    <div class="overlay"></div>
                                    <div class="list-post-counter"><span>35</span><i class="fa fa-heart"></i></div>
                                </div>
                                <div class="geodir-category-content fl-wrap">
                                    <a class="listing-geodir-category" href="listing.html">Cars</a>
                                    <div class="listing-avatar"><a href="author-single.html"><img
                                                src="{{ URL::asset($themePath.'images/avatar/6.jpg')}}" alt=""></a>
                                        <span class="avatar-tooltip">Added By  <strong>Kliff Antony</strong></span>
                                    </div>
                                    <h3><a href="listing-single.html">Best deal For the Cars</a></h3>
                                    <p>Lorem ipsum gravida nibh vel velit.</p>
                                    <div class="geodir-category-options fl-wrap">
                                        <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                            <span>(11 reviews)</span>
                                        </div>
                                        <div class="geodir-category-location"><a href="#"><i
                                                    class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn
                                                New York, NY 10065</a></div>
                                    </div>
                                </div>
                            </article>
                        </div>

                    </div>

                    <div class="slick-slide-item">

                        <div class="listing-item">
                            <article class="geodir-category-listing fl-wrap">
                                <div class="geodir-category-img">
                                    <img src="{{ URL::asset($themePath.'images/all/4.jpg')}}" alt="">
                                    <div class="overlay"></div>
                                    <div class="list-post-counter"><span>553</span><i class="fa fa-heart"></i></div>
                                </div>
                                <div class="geodir-category-content fl-wrap">
                                    <a class="listing-geodir-category" href="listing.html">Restourants</a>
                                    <div class="listing-avatar"><a href="author-single.html"><img
                                                src="{{ URL::asset($themePath.'images/avatar/3.jpg')}}" alt=""></a>
                                        <span class="avatar-tooltip">Added By  <strong>Adam Koncy</strong></span>
                                    </div>
                                    <h3><a href="listing-single.html">Luxury Restourant</a></h3>
                                    <p>Sed non neque elit. Sed ut imperdie.</p>
                                    <div class="geodir-category-options fl-wrap">
                                        <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                            <span>(7 reviews)</span>
                                        </div>
                                        <div class="geodir-category-location"><a href="#"><i
                                                    class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn
                                                New York, NY 10065</a></div>
                                    </div>
                                </div>
                            </article>
                        </div>

                    </div>

                </div>

                <div class="swiper-button-prev sw-btn"><i class="fa fa-long-arrow-left"></i></div>
                <div class="swiper-button-next sw-btn"><i class="fa fa-long-arrow-right"></i></div>
            </div>

        </section>

        @if(!Auth::check())
            @include('layouts.partials.cityBook.join',['typeJoin'=>1])
        @endif

        <section>
            <div class="container">
                @include('layouts.partials.cityBook.work-it')
            </div>
        </section>
        <section class="parallax-section" data-scrollax-parent="true">
            <div class="bg" data-bg="{{URL::asset($themePath.'images/bg/8.jpg')}}"
                 data-scrollax="properties: { translateY: '100px' }"></div>
            <div class="overlay co lor-overlay"></div>
            <!--container-->
            <div class="container">
                <div class="intro-item fl-wrap">
                    <h2>{{__('frontend.menu.home.background.one.title')}}</h2>
                    <h3>{{__('frontend.menu.home.background.one.subtitle')}}</h3>
                    <a class="trs-btn"
                       href="{{route('search',app()->getLocale())}}">{{__('frontend.menu.home.background.one.button')}}
                        + </a>
                </div>
            </div>
        </section>

        @include('layouts.partials.cityBook.plans')

        @include('layouts.partials.cityBook.counterViews')

        <section>
            <div class="container">
                <div class="section-title">
                    <h2>{{__('frontend.menu.home.testimonials.title')}}</h2>
                    <div class="section-subtitle">{{__('frontend.menu.home.testimonials.subtitle')}}</div>
                    <span class="section-separator"></span>
                    <p>{{__('frontend.menu.home.testimonials.description')}}</p>
                </div>
            </div>

            @include('layouts.partials.cityBook.testimonials')

        </section>
        @if(false)
            @include('layouts.partials.cityBook.customers')
        @endif
        <section>
            <div class="container">
                <div class="section-title">
                    <h2>{{__('frontend.menu.home.blog.title')}}</h2>
                    <div class="section-subtitle">{{__('frontend.menu.home.blog.subtitle')}}</div>
                    <span class="section-separator"></span>
                    <p>{{__('frontend.menu.home.blog.description')}}</p>
                </div>
                <div class="row home-posts">
                    <div class="col-md-4">
                        <article class="card-post">
                            <div class="card-post-img fl-wrap">
                                <a href="blog-single.html"><img
                                        src="{{ URL::asset($themePath.'images/all/15.jpg')}}" alt=""></a>
                            </div>
                            <div class="card-post-content fl-wrap">
                                <h3><a href="blog-single.html">Gallery Post</a></h3>
                                <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis
                                    cursus. Nulla eu mi magna. Etiam suscipit commodo gravida. </p>
                                <div class="post-author"><a href="#"><img
                                            src="{{ URL::asset($themePath.'images/avatar/4.jpg')}}" alt=""><span>By , Alisa Noory</span></a>
                                </div>
                                <div class="post-opt">
                                    <ul>
                                        <li><i class="fa fa-calendar-check-o"></i> <span>25 April 2018</span></li>
                                        <li><i class="fa fa-eye"></i> <span>264</span></li>
                                        <li><i class="fa fa-tags"></i> <a href="#">Photography</a></li>
                                    </ul>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-4">
                        <article class="card-post">
                            <div class="card-post-img fl-wrap">
                                <a href="blog-single.html"><img
                                        src="{{ URL::asset($themePath.'images/all/18.jpg')}}" alt=""></a>
                            </div>
                            <div class="card-post-content fl-wrap">
                                <h3><a href="blog-single.html">Video and gallery post</a></h3>
                                <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis
                                    cursus. Nulla eu mi magna. Etiam suscipit commodo gravida. </p>
                                <div class="post-author"><a href="#"><img
                                            src="{{ URL::asset($themePath.'images/avatar/5.jpg')}}" alt=""><span>By , Mery Lynn</span></a>
                                </div>
                                <div class="post-opt">
                                    <ul>
                                        <li><i class="fa fa-calendar-check-o"></i> <span>25 April 2018</span></li>
                                        <li><i class="fa fa-eye"></i> <span>264</span></li>
                                        <li><i class="fa fa-tags"></i> <a href="#">Design</a></li>
                                    </ul>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-4">
                        <article class="card-post">
                            <div class="card-post-img fl-wrap">
                                <a href="blog-single.html"><img
                                        src="{{ URL::asset($themePath.'images/all/19.jpg')}}" alt=""></a>
                            </div>
                            <div class="card-post-content fl-wrap">
                                <h3><a href="blog-single.html">Post Article</a></h3>
                                <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis
                                    cursus. Nulla eu mi magna. Etiam suscipit commodo gravida. </p>
                                <div class="post-author"><a href="#"><img
                                            src="{{ URL::asset($themePath.'images/avatar/6.jpg')}}" alt=""><span>By , Garry Dee</span></a>
                                </div>
                                <div class="post-opt">
                                    <ul>
                                        <li><i class="fa fa-calendar-check-o"></i> <span>25 April 2018</span></li>
                                        <li><i class="fa fa-eye"></i> <span>264</span></li>
                                        <li><i class="fa fa-tags"></i> <a href="#">Stories</a></li>
                                    </ul>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
                <a href="blog.html"
                   class="btn  big-btn circle-btn  dec-btn color-bg flat-btn">{{__('frontend.menu.home.blog.button')}}<i
                        class="fa fa-eye"></i></a>
            </div>
        </section>

        <section class="gradient-bg gradient-bg--home-contact-us">
            <div class="cirle-bg">
                <div class="bg" data-bg="{{ URL::asset($themePath.'images/bg/circle.png')}}"></div>
            </div>
            <div class="container">
                <div class="join-wrap fl-wrap">
                    <div class="row">
                        <div class="col-md-8">
                            <h3>{{__('frontend.menu.home.do-you-have.title')}}</h3>
                            <p>{{__('frontend.menu.home.do-you-have.description')}}</p>
                        </div>
                        <div class="col-md-4"><a href="{{route('contactUsBee',app()->getLocale())}}"
                                                 class="join-wrap-btn">{{__('frontend.menu.home.do-you-have.button')}}
                                <i
                                    class="fa fa-envelope-o"></i></a></div>
                    </div>
                </div>
            </div>
        </section>


    </div>
@endsection
@endif

