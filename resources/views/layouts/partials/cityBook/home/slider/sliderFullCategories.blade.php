<div class="content full-height fs-slider-wrap">
    <!--section -->
    <section class="hero-section no-dadding full-height" id="sec1">
        <div class="slider-container-wrap full-height fs-slider fl-wrap">


            <div class="slider-container">
                <!-- slideshow-item -->
                <div class="slider-item fl-wrap">
                    <div class="bg" data-bg="{{ URL::asset($themePath.'images/bg/32.jpg')}}"></div>
                    <div class="overlay"></div>
                    <div class="hero-section-wrap fl-wrap">
                        <div class="container">
                            <div class="intro-item fl-wrap">
                                <h2> {{__('frontend.menu.home.slider.title')}}</h2>
                                <h3>{{__('frontend.menu.home.slider.subtitle')}}</h3>
                            </div>
                            <form role="search" method="get" action="{{route('search',app()->getLocale())}}">
                                <div class="main-search-input-wrap">
                                    <div class="main-search-input fl-wrap">
                                        <div class="main-search-input-item">
                                            <input name="keywords" type="text"
                                                   placeholder="{{__('frontend.menu.home.filters.keywords')}}"
                                                   value=""/>
                                        </div>
                                        <div class="main-search-input-item location" id="autocomplete-container">
                                            <input name="location" type="text"
                                                   placeholder="{{__('frontend.menu.home.filters.location')}}"
                                                   id="autocomplete-input" value=""/>
                                            <a href="#"><i class="fa fa-dot-circle-o"></i></a>
                                        </div>
                                        <div class="main-search-input-item">

                                            <select name="category"
                                                    data-placeholder="{{__('frontend.menu.home.filters.category')}}"
                                                    class="chosen-select">
                                                <option val="0">{{__('frontend.menu.home.filters.category')}}</option>
                                                @foreach ($dataManagerPage['categoriesBusiness'] as $row)
                                                    <option val="{{$row->id}}">{{$row->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button class="main-search-button" type="submit">
                                            {{__('frontend.menu.home.filters.button')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--  slideshow-item end  -->
                <!-- slideshow-item -->
                <div class="slider-item fl-wrap">
                    <div class="bg bg-ser" data-bg="{{ URL::asset($themePath.'images/bg/slider/17.jpg')}}"></div>
                    <div class="overlay"></div>
                    <div class="hero-section-wrap fl-wrap">
                        <div class="container">
                            <div class="intro-item fl-wrap">
                                <h2>{{__('frontend.menu.home.slider.categories.title')}}</h2>
                                <h3>{{__('frontend.menu.home.slider.categories.subtitle')}}</h3>
                            </div>
                            <span class="section-separator"></span>
                            <div class="box-cat-container">
                                @foreach ($dataManagerPage['categoriesBusiness'] as $row)
                                    <a href="{{route('search',app()->getLocale())}}" class="box-cat color-bg"
                                       data-bgscr="{{$row->src}}">
                                        <i class="{{$row->icon_class}}"></i>
                                        <h4>{{$row->name}}</h4>
                                    </a>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
                <!--  slideshow-item end  -->
            </div>
            <div class="swiper-button-prev sw-btn"><i class="fa fa-long-arrow-left"></i></div>
            <div class="swiper-button-next sw-btn"><i class="fa fa-long-arrow-right"></i></div>
        </div>

    </section>
    <!-- section end -->
</div>

