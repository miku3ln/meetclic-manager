$window = $(window);

isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
isNoviBuilder = window.xMode;

function isScrolledIntoView(elem) {
    if (isNoviBuilder) return true;
    return elem.offset().top + elem.outerHeight() >= $window.scrollTop() && elem.offset().top <= $window.scrollTop() + $window.height();
}

$(function () {

    var plugins = {
        circleProgress: $(".progress-bar-circle-institution"),
    };
    if (plugins.circleProgress.length) {
        for (var i = 0; i < plugins.circleProgress.length; i++) {
            var circle = $(plugins.circleProgress[i]);

            circle.circleProgress({
                value: circle.attr('data-value'),
                size: circle.attr('data-size') ? circle.attr('data-size') : 175,
                fill: {
                    gradient: circle.attr('data-gradient').split(","),
                    gradientAngle: Math.PI / 4
                },
                startAngle: -Math.PI / 4 * 2,
                emptyFill: circle.attr('data-empty-fill') ? circle.attr('data-empty-fill') : "rgb(245,245,245)"
            }).on('circle-animation-progress', function (event, progress, stepValue) {
                $(this).find('span').text(String(stepValue.toFixed(2)).replace('0.', '').replace('1.', '1'));

            }).on('circle-animation-end', function (event) {
                $('.counter__span-management').html('');

            }).on('circle-animation-start', function (event) {

            });

            if (isScrolledIntoView(circle)) circle.addClass('animated-first');

            $window.on('scroll', $.proxy(function () {
                var circle = $(this);
                if (!circle.hasClass("animated-first") && isScrolledIntoView(circle)) {
                    circle.circleProgress('redraw');
                    circle.addClass('animated-first');
                }
            }, circle));
        }
    }
});
