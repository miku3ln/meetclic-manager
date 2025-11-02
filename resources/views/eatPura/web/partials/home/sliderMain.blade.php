<div class="content full-height fs-slider-wrap" id="slider-main">
    <!--section -->
    <section
        class="hero-section no-dadding full-height {{count($dataManagerPage['sliderMainManager']['slider']['data'])>1?'hero-section--items':"hero-section--item" }}"
        id="sec1">
        <div class="slider-container-wrap full-height fs-slider fl-wrap">
            <div class="slider-container">
                @foreach ($dataManagerPage['sliderMainManager']['slider']['data'] as $row)

                    <div class="slider-item fl-wrap">
                        <div class="bg" data-bg="{{$row['source']}}"></div>
                        <div class="overlay"></div>
                        @if($row['type_multimedia']==1)
                            <div class="hero-section-wrap fl-wrap">
                                <div class="container">
                                    <div class="intro-item fl-wrap">
                                        <h3 class="intro-item__subtitle"> {{$row['subtitle']}} </h3>
                                        <h2 class="intro-item__title"> {{$row['title']}}</h2>
                                    </div>


                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            @if(count($dataManagerPage['sliderMainManager']['slider']['data'])>1)
                <div class="swiper-button-prev sw-btn"><i class="fa fa-chevron-left"></i></div>
                <div class="swiper-button-next sw-btn"><i class="fa fa-chevron-right"></i></div>
            @endif
        </div>
        <div class="header-sec-link not-view">
            <div class="container">
                @if(isset($dataManagerPage['categoriesBusiness']))
                    <a href="#{{Auth::check()?'sec2':'sec2'}}"
                       class="custom-scroll-link">{{__('frontend.menu.home.slider.button')}}
                    </a>
                @else
                    <a href="#{{Auth::check()?'sec2':'sect-popular-list'}}"
                       class="custom-scroll-link">{{__('frontend.menu.home.slider.button')}}
                    </a>
                @endif
            </div>
        </div>
    </section>
    <!-- section end -->
</div>

