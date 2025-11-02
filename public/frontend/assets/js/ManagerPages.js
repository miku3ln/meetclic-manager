/*SHOP*/



$(function () {

    //TODO VERIFY $('.nice-select-quick-view').niceSelect();

});


function initSlickManager(params) {

    var $slickItemCurrent = $(params['element']);
    var slickSetting = $slickItemCurrent.data('slick-setting');

    var responsive = {
        breakpointO: parseInt(slickSetting['data-items']) || 1,
        breakpoint480: parseInt(slickSetting['data-xs-items']) || 1,
        breakpoint768: parseInt(slickSetting['data-sm-items']) || 1,
        breakpoint992: parseInt(slickSetting['data-md-items']) || 1,
        breakpoint1200: parseInt(slickSetting['data-lg-items']) || 1,


    };
    var configSlick = {
        slidesToScroll: parseInt(slickSetting['data-slide-to-scroll']) || 1,
        asNavFor: slickSetting['data-for'] || false,
        adaptiveHeight: slickSetting["data-adaptiveheight"] == "true",
        dots: slickSetting["data-dots"] == "true",
        infinite: slickSetting["data-loop"] == "true",
        focusOnSelect: true,
        arrows: slickSetting["data-arrows"] == "true",
        swipe: slickSetting["data-swipe"] == "true",
        autoplay: slickSetting["data-autoplay"] == "true",
        vertical: slickSetting["data-vertical"] == "true",
        centerMode: slickSetting["data-center-mode"] == "true",
        centerPadding: slickSetting["data-center-padding"] ? slickSetting["data-center-padding"] : '0.50',
        mobileFirst: true,
        fade: slickSetting["data-fade"] ? slickSetting["data-fade"] : false,
        responsive: [
            {
                breakpoint: 0,
                settings: {
                    slidesToShow: responsive.breakpoint0,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: responsive.breakpoint480,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: responsive.breakpoint768,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: responsive.breakpoint992,
                }
            },
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: responsive.breakpoint1200,
                }
            }
        ]
    };

    $slickItemCurrent.slick(configSlick)
        .on('afterChange', function (event, slick, currentSlide, nextSlide) {


        });
}
