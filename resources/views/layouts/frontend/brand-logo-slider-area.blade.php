

<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>

<div class="instagram-area section-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area text-center">
                    <h2 class="section-title">Marcas Aliadas</h2>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="brand-logo-slider-area bg--light-grey">
    <div class="container wide">

        <div class="row">
            <div class="col-lg-12">
                <!--=======  brand logo slider wrapper  =======-->
                @if(is_array($dataSlider)&& count($dataSlider)>0 )
                    <div class="brand-logo-slider-wrapper theme-slick-slider" data-slick-setting='{
                        "slidesToShow": 6,
                        "arrows": true,
                        "autoplay": false,
                        "autoplaySpeed": 5000,
                        "speed": 500,
                        "prevArrow": {"buttonClass": "slick-prev", "iconClass": "fa fa-angle-left" },
                        "nextArrow": {"buttonClass": "slick-next", "iconClass": "fa fa-angle-right" }
                    }' data-slick-responsive='[
                        {"breakpoint":1501, "settings": {"slidesToShow": 5} },
                        {"breakpoint":1199, "settings": {"slidesToShow": 4} },
                        {"breakpoint":991, "settings": {"slidesToShow": 3} },
                        {"breakpoint":767, "settings": {"slidesToShow": 2} },
                        {"breakpoint":575, "settings": {"slidesToShow": 2} },
                        {"breakpoint":479, "settings": {"slidesToShow": 1} }
                    ]'>

                        @foreach($dataSlider as $value)
                            @php
                                @endphp
                            <div class="single-brand-logo">
                                <a href="{{url('business/'.$value['id'])}}">
                                    <img src="{{ URL::asset($resourcePathServer.$value['source'])}}"
                                         class="img-fluid"
                                         alt="{{$value['alt']}}">
                                </a>
                            </div>
                        @endforeach

                    </div>

                @else
                    <div class="empty-manager">
                        <div class="section-title-area-empty text-center">
                            <h2 class="section-title-empty">No existe marcas aliadas registradas.</h2>
                        </div>
                    </div>

                    <!--=======  End of brand logo slider wrapper  =======-->
                @endif
            </div>
        </div>
    </div>
</div>
