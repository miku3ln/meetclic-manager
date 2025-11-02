@if(isset($dataManagerPage['sliderMainManagerThree']))
<div class="row">
    <div class="col-md-12">
        <div class="list-single-main-media fl-wrap">
            <div class="single-slider-wrapper fl-wrap">
                <div class="single-slider fl-wrap">
                    @foreach ($dataManagerPage['sliderMainManagerThree']['data'] as $row)
                        <div class="slick-slide-item">

                            <div class="hero-section-wrap--slider-other fl-wrap--slider-other">
                                <div class="container--slider-other">
                                    <div class="intro-item--slider-other fl-wrap--slider-other">
                                        <h2 class="intro-item--slider-other__title"> {{$row['title']}}</h2>
                                        <h3 class="intro-item--slider-other__subtitle"> {{$row['subtitle']}}</h3>
                                    </div>


                                </div>
                            </div>
                            <img class="img-manager-home" src="{{$row['source']}}" alt="">
                        </div>
                    @endforeach
                </div>

                <div class="swiper-button-prev sw-btn"><i class="fa fa-chevron-left"></i></div>
                <div class="swiper-button-next sw-btn"><i class="fa fa-chevron-right"></i></div>
            </div>
        </div>
    </div>
</div>
@endif
