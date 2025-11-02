@if(isset($dataManagerPage['type']))
    @if($dataManagerPage['type']==2)
        @if( isset($dataManagerPage['business']['gallery'])  && count($dataManagerPage['business']['gallery'])>0 )
            <div class="list-single-main-item fl-wrap" id="gallery">
                <div class="list-single-main-item-title fl-wrap">
                    <h3>{{__('frontend.business-details.gallery')}}</h3>
                </div>
                <div class="gallery-items grid-small-pad  list-single-gallery three-coulms lightgallery">
                    @foreach ($dataManagerPage['business']['gallery'] as $gallery)
                        <div class="gallery-item">
                            <div class="grid-item-holder">
                                <div class="box-item">
                                    <img src="{{$gallery->src}}" alt="{{$gallery->text}}">
                                    <a href="{{$gallery->src}}" class="gal-link popup-image">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @elseif($dataManagerPage['type']==1)

    @elseif($dataManagerPage['type']==3)
        <div class="list-single-main-media fl-wrap" id="gallery">
            <div class="single-slider-wrapper fl-wrap">

                <div class="single-slider fl-wrap">
                    @foreach ($dataManagerPage['business']['gallery'] as $gallery)

                        <div class="slick-slide-item"><img
                                src="{{$gallery->src}}"
                                alt="{{$gallery->text}}"></div>

                    @endforeach
                </div>
                <div class="swiper-button-prev sw-btn"><i class="fa fa-long-arrow-left"></i></div>
                <div class="swiper-button-next sw-btn"><i class="fa fa-long-arrow-right"></i></div>
            </div>
        </div>
    @elseif($dataManagerPage['type']==4)

        <div class="list-single-main-item fl-wrap" id="gallery">
            <div class="list-single-main-item-title fl-wrap">
                <h3>{{__('frontend.business-details.gallery')}}</h3>
            </div>

            <!-- gallery-items   -->
            <div class="gallery-items grid-small-pad  list-single-gallery three-coulms lightgallery">
                @foreach ($dataManagerPage['business']['gallery'] as $gallery)

                    <div class="gallery-item">
                        <div class="grid-item-holder">
                            <div class="box-item">
                                <img src="{{$gallery->src}}" alt="{{$gallery->text}}">
                                <a href="{{$gallery->src}}"
                                   class="gal-link popup-image"><i
                                        class="fa fa-search"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    @endif
@endif
