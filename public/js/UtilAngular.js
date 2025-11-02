app.filter("formatDateTime", function ($filter) {
    return function (date, format) {
        if (date) {
            return moment(Number(date)).format(format || "DD/MM/YYYY h:mm A");
        } else return "";
    };
})
    .directive("initTooltip", function ($window) {
        return {
            scope: false,
            link: function (scope, element, attrs, controller, transcludeFn) {
                if ($(element).data("ui-tooltip")) {
                    $(element).tooltip("hide");
                }

                $(element).tooltip();
            }
        };
    })
    .directive("selectValueElement", function ($window) {
        return {
            scope: false,
            link: function (scope, element, attrs, controller, transcludeFn) {
                $(element).on("click", function () {
                    $(this).select();
                });
            }
        };
    })
    .directive("eventsDatehotkey", function ($window) {
        return {
            scope: false,
            link: function (scope, element, attrs, controller, transcludeFn) {
                //            scope.generateDate(element);
                var w = angular.element($window);
                scope.getWindowDimensions = function () {
                    return {
                        h: w.height(),
                        w: w.width()
                    };
                };
                scope.$watch(
                    scope.getWindowDimensions,
                    function (newValue, oldValue) {
                        scope.windowHeight = newValue.h;
                        scope.windowWidth = newValue.w;
                        scope.class_data = "x";
                        scope.style = function () {
                            return {
                                height: newValue.h - 100 + "px",
                                width: newValue.w - 100 + "px"
                            };
                        };
                    },
                    true
                );

                w.bind("resize", function () {
                    var element = $(".hidden-menu-mobile-lock");
                    var element = $(".hidden-menu-mobile-lock");
                    var width_content = $("#content-form-view").width();
                    if (width_content > 997) {
                        scope.class_data = "inline-group";
                    } else {
                        scope.class_data = "pedro";
                    }
                    scope.$apply();
                });
                w.bind("keypress", function (event) {
                    var keyCode = event.keyCode;
                });

                var dataKeyHots = getHotKey();

                angular.forEach(dataKeyHots, function (value, key) {
                    var keyCurrent = value.keyDown;
                    $.key(keyCurrent, function () {
                        scope.$$childHead._configHotKey(value);
                    });
                });
                /*  w.on('keydown', null, hotKeySelector, function (objEvent) {


          });*/
            }
        };
    })
    .directive("slideConfig", function ($compile) {
        return {
            scope: false,

            link: function (scope, element, attrs) {
                console.log(element);

                var htmlSlide = scope.getSlideHtml();
                $(element).append($compile(htmlSlide)(scope));
                var slider = $(element).slideReveal({
                    // width: 100,
                    push: false,
                    position: "right",
                    // speed: 600,
                    trigger: $(".handle"),
                    // autoEscape: false,
                    shown: function (obj) {
                        obj.find(".handle").html(
                            '<span class="fa fa-question-circle"></span>'
                        );
                        obj.addClass("left-shadow-overlay");
                    },
                    hidden: function (obj) {
                        obj.find(".handle").html(
                            '<span class="fa fa-question"></span>'
                        );
                        obj.removeClass("left-shadow-overlay");
                    }
                });
            }
        };
    });
