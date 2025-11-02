@if( isset($dataManagerPage['business']['offer']))
    <div class="box-widget-item fl-wrap">
        <div class="box-widget-item-header">
            <h3>Super Offer : </h3>
        </div>
        <div class="box-widget">

            <div class="banner-wdget fl-wrap">
                <div class="overlay"></div>
                <div class="bg" data-bg="{{ URL::asset($themePath.'images/bg/39.jpg')}}"></div>
                <div class="banner-wdget-content fl-wrap">
                    <h4>Get two months free when you purchase a subscription.</h4>
                    <a href="#" class="color-bg">Book Now</a>
                </div>
            </div>

        </div>
    </div>
@endif
