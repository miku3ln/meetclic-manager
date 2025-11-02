var mApp = function () {
    var e = function (e) {
        var t = e.data("skin") ? "m-tooltip--skin-" + e.data("skin") : "";
        e.tooltip({
            trigger: "hover",
            template: '<div class="m-tooltip ' + t + ' tooltip" role="tooltip">                <div class="arrow"></div>                <div class="tooltip-inner"></div>            </div>'
        })
    }, t = function () {
        $('[data-toggle="m-tooltip"]').each(function () {
            e($(this))
        })
    }, a = function (e) {
        var t = e.data("skin") ? "m-popover--skin-" + e.data("skin") : "";
        e.popover({
            trigger: "hover",
            template: '            <div class="m-popover ' + t + ' popover" role="tooltip">                <div class="arrow"></div>                <h3 class="popover-header"></h3>                <div class="popover-body"></div>            </div>'
        })
    }, n = function () {
        $('[data-toggle="m-popover"]').each(function () {
            a($(this))
        })
    }, o = function (e, t) {
        e.mPortlet(t)
    }, i = function () {
        $('[data-portlet="true"]').each(function () {
            var e = $(this);
            !0 !== e.data("portlet-initialized") && (o(e, {}), e.data("portlet-initialized", !0))
        })
    };
    return {
        init: function () {
            mApp.initComponents()
        }, initComponents: function () {
            $('[data-scrollable="true"]').each(function () {
                var e, t, a = $(this);
                mUtil.isInResponsiveRange("tablet-and-mobile") ? (e = a.data("mobile-max-height") ? a.data("mobile-max-height") : a.data("max-height"), t = a.data("mobile-height") ? a.data("mobile-height") : a.data("height")) : (e = a.data("max-height"), t = a.data("max-height")), e && a.css("max-height", e), t && a.css("height", t), mApp.initScroller(a, {})
            }), t(), n(), $("body").on("click", "[data-close=alert]", function () {
                $(this).closest(".alert").hide()
            }), i()
        }, initTooltips: function () {
            t()
        }, initTooltip: function (t) {
            e(t)
        }, initPopovers: function () {
            n()
        }, initPopover: function (e) {
            a(e)
        }, initPortlet: function (e, t) {
            o(e, t)
        }, initPortlets: function () {
            i()
        }, scrollTo: function (e, t) {
            var a = e && e.length > 0 ? e.offset().top : 0;
            a += t || 0, jQuery("html,body").animate({scrollTop: a}, "slow")
        }, scrollToViewport: function (e) {
            var t = e.offset().top, a = e.height(), n = t - (mUtil.getViewPort().height / 2 - a / 2);
            jQuery("html,body").animate({scrollTop: n}, "slow")
        }, scrollTop: function () {
            mApp.scrollTo()
        }, initScroller: function (e, t) {
            mUtil.isMobileDevice() ? e.css("overflow", "auto") : (e.mCustomScrollbar("destroy"), e.mCustomScrollbar({
                scrollInertia: 0,
                autoDraggerLength: !0,
                autoHideScrollbar: !0,
                autoExpandScrollbar: !1,
                alwaysShowScrollbar: 0,
                axis: e.data("axis") ? e.data("axis") : "y",
                mouseWheel: {scrollAmount: 120, preventDefault: !0},
                setHeight: t.height ? t.height : "",
                theme: "minimal-dark"
            }))
        }, destroyScroller: function (e) {
            e.mCustomScrollbar("destroy")
        }, alert: function (e) {
            e = $.extend(!0, {
                container: "",
                place: "append",
                type: "success",
                message: "",
                close: !0,
                reset: !0,
                focus: !0,
                closeInSeconds: 0,
                icon: ""
            }, e);
            var t = mUtil.getUniqueID("App_alert"),
                a = '<div id="' + t + '" class="custom-alerts alert alert-' + e.type + ' fade in">' + (e.close ? '<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>' : "") + ("" !== e.icon ? '<i class="fa-lg fa fa-' + e.icon + '"></i>  ' : "") + e.message + "</div>";
            return e.reset && $(".custom-alerts").remove(), e.container ? "append" == e.place ? $(e.container).append(a) : $(e.container).prepend(a) : 1 === $(".page-fixed-main-content").size() ? $(".page-fixed-main-content").prepend(a) : ($("body").hasClass("page-container-bg-solid") || $("body").hasClass("page-content-white")) && 0 === $(".page-head").size() ? $(".page-title").after(a) : $(".page-bar").size() > 0 ? $(".page-bar").after(a) : $(".page-breadcrumb, .breadcrumbs").after(a), e.focus && mApp.scrollTo($("#" + t)), e.closeInSeconds > 0 && setTimeout(function () {
                $("#" + t).remove()
            }, 1e3 * e.closeInSeconds), t
        }, block: function (e, t) {
            var a, n, o, i = $(e);
            if ("spinner" == (t = $.extend(!0, {
                opacity: .1,
                overlayColor: "",
                state: "brand",
                type: "spinner",
                centerX: !0,
                centerY: !0,
                message: "",
                shadow: !0,
                width: "auto"
            }, t)).type ? o = '<div class="m-spinner ' + (a = t.skin ? "m-spinner--skin-" + t.skin : "") + " " + (n = t.state ? "m-spinner--" + t.state : "") + '"></div' : (a = t.skin ? "m-loader--skin-" + t.skin : "", n = t.state ? "m-loader--" + t.state : "", size = t.size ? "m-loader--" + t.size : "", o = '<div class="m-loader ' + a + " " + n + " " + size + '"></div'), t.message && t.message.length > 0) {
                var l = "m-blockui " + (!1 === t.shadow ? "m-blockui-no-shadow" : "");
                html = '<div class="' + l + '"><span>' + t.message + "</span><span>" + o + "</span></div>", t.width = mUtil.realWidth(html) + 10, "body" == e && (html = '<div class="' + l + '" style="margin-left:-' + t.width / 2 + 'px;"><span>' + t.message + "</span><span>" + o + "</span></div>")
            } else html = o;
            var r = {
                message: html,
                centerY: t.centerY,
                centerX: t.centerX,
                css: {top: "30%", left: "50%", border: "0", padding: "0", backgroundColor: "none", width: t.width},
                overlayCSS: {backgroundColor: t.overlayColor, opacity: t.opacity, cursor: "wait"},
                onUnblock: function () {
                    i && (i.css("position", ""), i.css("zoom", ""))
                }
            };
            if ("body" == e) r.css.top = "50%", $.blockUI(r); else {
                (i = $(e)).block(r)
            }
        }, unblock: function (e) {
            e && "body" != e ? $(e).unblock() : $.unblockUI()
        }, blockPage: function (e) {
            return mApp.block("body", e)
        }, unblockPage: function () {
            return mApp.unblock("body")
        }, progress: function (t, e) {
            var a = "m-loader m-loader--" + (e && e.skin ? e.skin : "light") + " m-loader--" + (e && e.alignment ? e.alignment : "right") + " m-loader--" + (e && e.size ? "m-spinner--" + e.size : "");
            mApp.unprogress(t), $(t).addClass(a), $(t).data("progress-classes", a)
        }, unprogress: function (t) {
            $(t).removeClass($(t).data("progress-classes"))
        }, getColor: function (e) {
            return t[e]
        }
    }
}();
$(document).ready(function () {
    mApp.init()
});
window.mUtilElementDataStore = {}, window.mUtilElementDataStoreID = 0, window.mUtilDelegatedEventHandlers = {};
var mUtil = function () {
    var e = [], t = {sm: 544, md: 768, lg: 992, xl: 1200}, a = {
        brand: "#716aca",
        metal: "#c4c5d6",
        light: "#ffffff",
        accent: "#00c5dc",
        primary: "#5867dd",
        success: "#34bfa3",
        info: "#36a3f7",
        warning: "#ffb822",
        danger: "#f4516c"
    }, n = function () {
        var t;
        jQuery(window).resize(function () {
            t && clearTimeout(t), t = setTimeout(function () {
                !function () {
                    for (var t = 0; t < e.length; t++) e[t].call()
                }()
            }, 250)
        })
    };
    return {
        init: function (e) {
            e && e.breakpoints && (t = e.breakpoints), e && e.colors && (a = e.colors), n()
        }, addResizeHandler: function (t) {
            e.push(t)
        }, runResizeHandlers: function () {
            _runResizeHandlers()
        }, getURLParam: function (e) {
            var t, a, n = window.location.search.substring(1).split("&");
            for (t = 0; t < n.length; t++) if ((a = n[t].split("="))[0] == e) return unescape(a[1]);
            return null
        }, isMobileDevice: function () {
            return this.getViewPort().width < this.getBreakpoint("lg")
        }, isDesktopDevice: function () {
            return !mUtil.isMobileDevice()
        }, getViewPort: function () {
            var e = window, t = "inner";
            return "innerWidth" in window || (t = "client", e = document.documentElement || document.body), {
                width: e[t + "Width"],
                height: e[t + "Height"]
            }
        }, isInResponsiveRange: function (e) {
            var t = this.getViewPort().width;
            return "general" == e || ("desktop" == e && t >= this.getBreakpoint("lg") + 1 || ("tablet" == e && t >= this.getBreakpoint("md") + 1 && t < this.getBreakpoint("lg") || ("mobile" == e && t <= this.getBreakpoint("md") || ("desktop-and-tablet" == e && t >= this.getBreakpoint("md") + 1 || "tablet-and-mobile" == e && t <= this.getBreakpoint("lg")))))
        }, getUniqueID: function (e) {
            return e + Math.floor(Math.random() * (new Date).getTime())
        }, getBreakpoint: function (e) {
            if ($.inArray(e, t)) return t[e]
        }, isset: function (e, t) {
            var a;
            if (-1 !== (t = t || "").indexOf("[")) throw new Error("Unsupported object path notation.");
            t = t.split(".");
            do {
                if (void 0 === e) return !1;
                if (a = t.shift(), !e.hasOwnProperty(a)) return !1;
                e = e[a]
            } while (t.length);
            return !0
        }, getHighestZindex: function (e) {
            for (var t, a, n = $(e); n.length && n[0] !== document;) {
                if (("absolute" === (t = n.css("position")) || "relative" === t || "fixed" === t) && (a = parseInt(n.css("zIndex"), 10), !isNaN(a) && 0 !== a)) return a;
                n = n.parent()
            }
        }, hasClasses: function (e, t) {
            for (var a = t.split(" "), n = 0; n < a.length; n++) if (0 == e.hasClass(a[n])) return !1;
            return !0
        }, realWidth: function (e) {
            var t = $(e).clone();
            t.css("visibility", "hidden"), t.css("overflow", "hidden"), t.css("height", "0"), $("body").append(t);
            var a = t.outerWidth();
            return t.remove(), a
        }, hasFixedPositionedParent: function (e) {
            var t = !1;
            return e.parents().each(function () {
                "fixed" != $(this).css("position") || (t = !0)
            }), t
        }, sleep: function (e) {
            for (var t = (new Date).getTime(), a = 0; a < 1e7 && !((new Date).getTime() - t > e); a++) ;
        }, getRandomInt: function (e, t) {
            return Math.floor(Math.random() * (t - e + 1)) + e
        }, getColor: function (e) {
            return a[e]
        }, isAngularVersion: function () {
            return void 0 !== window.Zone
        }, deepExtend: function (t) {
            t = t || {};
            for (var e = 1; e < arguments.length; e++) {
                var a = arguments[e];
                if (a) for (var n in a) a.hasOwnProperty(n) && ("object" == typeof a[n] ? t[n] = mUtil.deepExtend(t[n], a[n]) : t[n] = a[n])
            }
            return t
        }, extend: function (t) {
            t = t || {};
            for (var e = 1; e < arguments.length; e++) if (arguments[e]) for (var a in arguments[e]) arguments[e].hasOwnProperty(a) && (t[a] = arguments[e][a]);
            return t
        }, get: function (t) {
            var e;
            return t === document ? document : t && 1 === t.nodeType ? t : (e = document.getElementById(t)) ? e : (e = document.getElementsByTagName(t)) ? e[0] : (e = document.getElementsByClassName(t)) ? e[0] : null
        }, getByClass: function (t) {
            var e;
            return (e = document.getElementsByClassName(t)) ? e[0] : null
        }, hasClasses: function (t, e) {
            if (t) {
                for (var a = e.split(" "), n = 0; n < a.length; n++) if (0 == mUtil.hasClass(t, mUtil.trim(a[n]))) return !1;
                return !0
            }
        }, hasClass: function (t, e) {
            if (t) return t.classList ? t.classList.contains(e) : new RegExp("\\b" + e + "\\b").test(t.className)
        }, addClass: function (t, e) {
            if (t && void 0 !== e) {
                var a = e.split(" ");
                if (t.classList) for (var n = 0; n < a.length; n++) a[n] && a[n].length > 0 && t.classList.add(mUtil.trim(a[n])); else if (!mUtil.hasClass(t, e)) for (n = 0; n < a.length; n++) t.className += " " + mUtil.trim(a[n])
            }
        }, removeClass: function (t, e) {
            if (t) {
                var a = e.split(" ");
                if (t.classList) for (var n = 0; n < a.length; n++) t.classList.remove(mUtil.trim(a[n])); else if (mUtil.hasClass(t, e)) for (n = 0; n < a.length; n++) t.className = t.className.replace(new RegExp("\\b" + mUtil.trim(a[n]) + "\\b", "g"), "")
            }
        }, triggerCustomEvent: function (t, e, a) {
            if (window.CustomEvent) var n = new CustomEvent(e, {detail: a}); else (n = document.createEvent("CustomEvent")).initCustomEvent(e, !0, !0, a);
            t.dispatchEvent(n)
        }, trim: function (t) {
            return t.trim()
        }, eventTriggered: function (t) {
            return !!t.currentTarget.dataset.triggered || (t.currentTarget.dataset.triggered = !0, !1)
        }, remove: function (t) {
            t && t.parentNode && t.parentNode.removeChild(t)
        }, find: function (t, e) {
            return t.querySelector(e)
        }, findAll: function (t, e) {
            return t.querySelectorAll(e)
        }, insertAfter: function (t, e) {
            return e.parentNode.insertBefore(t, e.nextSibling)
        }, parents: function (t, e) {
            function a(t, e) {
                for (var a = 0, n = t.length; a < n; a++) if (t[a] == e) return !0;
                return !1
            }

            return function (t, e) {
                for (var n = document.querySelectorAll(e), o = t.parentNode; o && !a(n, o);) o = o.parentNode;
                return o
            }(t, e)
        }, children: function (t, e, a) {
            if (t && t.childNodes) {
                for (var n = [], o = 0, i = t.childNodes.length; o < i; ++o) 1 == t.childNodes[o].nodeType && mUtil.matches(t.childNodes[o], e, a) && n.push(t.childNodes[o]);
                return n
            }
        }, child: function (t, e, a) {
            var n = mUtil.children(t, e, a);
            return n ? n[0] : null
        }, matches: function (t, e, a) {
            var n = Element.prototype,
                o = n.matches || n.webkitMatchesSelector || n.mozMatchesSelector || n.msMatchesSelector || function (t) {
                    return -1 !== [].indexOf.call(document.querySelectorAll(t), this)
                };
            return !(!t || !t.tagName) && o.call(t, e)
        }, data: function (t) {
            return t = mUtil.get(t), {
                set: function (e, a) {
                    void 0 === t.customDataTag && (mUtilElementDataStoreID++, t.customDataTag = mUtilElementDataStoreID), void 0 === mUtilElementDataStore[t.customDataTag] && (mUtilElementDataStore[t.customDataTag] = {}), mUtilElementDataStore[t.customDataTag][e] = a
                }, get: function (e) {
                    return this.has(e) ? mUtilElementDataStore[t.customDataTag][e] : null
                }, has: function (e) {
                    return !(!mUtilElementDataStore[t.customDataTag] || !mUtilElementDataStore[t.customDataTag][e])
                }, remove: function (e) {
                    this.has(e) && delete mUtilElementDataStore[t.customDataTag][e]
                }
            }
        }, outerWidth: function (t, e) {
            if (!0 === e) {
                var a = parseFloat(t.offsetWidth);
                return a += parseFloat(mUtil.css(t, "margin-left")) + parseFloat(mUtil.css(t, "margin-right")), parseFloat(a)
            }
            return a = parseFloat(t.offsetWidth)
        }, offset: function (t) {
            var e, a;
            if (t = mUtil.get(t)) return t.getClientRects().length ? (e = t.getBoundingClientRect(), a = t.ownerDocument.defaultView, {
                top: e.top + a.pageYOffset,
                left: e.left + a.pageXOffset
            }) : {top: 0, left: 0}
        }, height: function (t) {
            return mUtil.css(t, "height")
        }, visible: function (t) {
            return !(0 === t.offsetWidth && 0 === t.offsetHeight)
        }, attr: function (t, e, a) {
            if (null != (t = mUtil.get(t))) return void 0 === a ? t.getAttribute(e) : void t.setAttribute(e, a)
        }, hasAttr: function (t, e) {
            if (null != (t = mUtil.get(t))) return !!t.getAttribute(e)
        }, removeAttr: function (t, e) {
            null != (t = mUtil.get(t)) && t.removeAttribute(e)
        }, animate: function (t, e, a, n, o, i) {
            var l = {};
            if (l.linear = function (t, e, a, n) {
                return a * t / n + e
            }, o = l.linear, "number" == typeof t && "number" == typeof e && "number" == typeof a && "function" == typeof n) {
                "function" != typeof i && (i = function () {
                });
                var r = window.requestAnimationFrame || function (t) {
                    window.setTimeout(t, 20)
                }, s = e - t;
                n(t);
                var d = window.performance && window.performance.now ? window.performance.now() : +new Date;
                r(function l(c) {
                    var m = (c || +new Date) - d;
                    m >= 0 && n(o(m, t, s, a)), m >= 0 && m >= a ? (n(e), i()) : r(l)
                })
            }
        }, actualCss: function (t, e, a) {
            var n;
            if (t instanceof HTMLElement != !1) return t.getAttribute("m-hidden-" + e) && !1 !== a ? parseFloat(t.getAttribute("m-hidden-" + e)) : (t.style.cssText = "position: absolute; visibility: hidden; display: block;", "width" == e ? n = t.offsetWidth : "height" == e && (n = t.offsetHeight), t.style.cssText = "", t.setAttribute("m-hidden-" + e, n), parseFloat(n))
        }, actualHeight: function (t, e) {
            return mUtil.actualCss(t, "height", e)
        }, actualWidth: function (t, e) {
            return mUtil.actualCss(t, "width", e)
        }, getScroll: function (t, e) {
            return e = "scroll" + e, t == window || t == document ? self["scrollTop" == e ? "pageYOffset" : "pageXOffset"] || browserSupportsBoxModel && document.documentElement[e] || document.body[e] : t[e]
        }, css: function (t, e, a) {
            if (t = mUtil.get(t)) if (void 0 !== a) t.style[e] = a; else {
                var n = (t.ownerDocument || document).defaultView;
                if (n && n.getComputedStyle) return e = e.replace(/([A-Z])/g, "-$1").toLowerCase(), n.getComputedStyle(t, null).getPropertyValue(e);
                if (t.currentStyle) return e = e.replace(/\-(\w)/g, function (t, e) {
                    return e.toUpperCase()
                }), a = t.currentStyle[e], /^\d+(em|pt|%|ex)?$/i.test(a) ? function (e) {
                    var a = t.style.left, n = t.runtimeStyle.left;
                    return t.runtimeStyle.left = t.currentStyle.left, t.style.left = e || 0, e = t.style.pixelLeft + "px", t.style.left = a, t.runtimeStyle.left = n, e
                }(a) : a
            }
        }, slide: function (t, e, a, n, o) {
            if (!(!t || "up" == e && !1 === mUtil.visible(t) || "down" == e && !0 === mUtil.visible(t))) {
                a = a || 600;
                var i = mUtil.actualHeight(t), l = !1, r = !1;
                mUtil.css(t, "padding-top") && !0 !== mUtil.data(t).has("slide-padding-top") && mUtil.data(t).set("slide-padding-top", mUtil.css(t, "padding-top")), mUtil.css(t, "padding-bottom") && !0 !== mUtil.data(t).has("slide-padding-bottom") && mUtil.data(t).set("slide-padding-bottom", mUtil.css(t, "padding-bottom")), mUtil.data(t).has("slide-padding-top") && (l = parseInt(mUtil.data(t).get("slide-padding-top"))), mUtil.data(t).has("slide-padding-bottom") && (r = parseInt(mUtil.data(t).get("slide-padding-bottom"))), "up" == e ? (t.style.cssText = "display: block; overflow: hidden;", l && mUtil.animate(0, l, a, function (e) {
                    t.style.paddingTop = l - e + "px"
                }, "linear"), r && mUtil.animate(0, r, a, function (e) {
                    t.style.paddingBottom = r - e + "px"
                }, "linear"), mUtil.animate(0, i, a, function (e) {
                    t.style.height = i - e + "px"
                }, "linear", function () {
                    n(), t.style.height = "", t.style.display = "none"
                })) : "down" == e && (t.style.cssText = "display: block; overflow: hidden;", l && mUtil.animate(0, l, a, function (e) {
                    t.style.paddingTop = e + "px"
                }, "linear", function () {
                    t.style.paddingTop = ""
                }), r && mUtil.animate(0, r, a, function (e) {
                    t.style.paddingBottom = e + "px"
                }, "linear", function () {
                    t.style.paddingBottom = ""
                }), mUtil.animate(0, i, a, function (e) {
                    t.style.height = e + "px"
                }, "linear", function () {
                    n(), t.style.height = "", t.style.display = "", t.style.overflow = ""
                }))
            }
        }, slideUp: function (t, e, a) {
            mUtil.slide(t, "up", e, a)
        }, slideDown: function (t, e, a) {
            mUtil.slide(t, "down", e, a)
        }, show: function (t, e) {
            t.style.display = e || "block"
        }, hide: function (t) {
            t.style.display = "none"
        }, addEvent: function (t, e, a, n) {
            void 0 !== (t = mUtil.get(t)) && t.addEventListener(e, a)
        }, removeEvent: function (t, e, a) {
            (t = mUtil.get(t)).removeEventListener(e, a)
        }, on: function (t, e, a, n) {
            if (e) {
                var o = mUtil.getUniqueID("event");
                return mUtilDelegatedEventHandlers[o] = function (a) {
                    for (var o = t.querySelectorAll(e), i = a.target; i && i !== t;) {
                        for (var l = 0, r = o.length; l < r; l++) i === o[l] && n.call(i, a);
                        i = i.parentNode
                    }
                }, mUtil.addEvent(t, a, mUtilDelegatedEventHandlers[o]), o
            }
        }, off: function (t, e, a) {
            t && mUtilDelegatedEventHandlers[a] && (mUtil.removeEvent(t, e, mUtilDelegatedEventHandlers[a]), delete mUtilDelegatedEventHandlers[a])
        }, one: function (t, e, a) {
            (t = mUtil.get(t)).addEventListener(e, function (t) {
                return t.target.removeEventListener(t.type, arguments.callee), a(t)
            })
        }, hash: function (t) {
            var e, a = 0;
            if (0 === t.length) return a;
            for (e = 0; e < t.length; e++) a = (a << 5) - a + t.charCodeAt(e), a |= 0;
            return a
        }, animateClass: function (t, e, a) {
            mUtil.addClass(t, "animated " + e), mUtil.one(t, "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function () {
                mUtil.removeClass(t, "animated " + e)
            }), a && mUtil.one(t.animationEnd, a)
        }, animateDelay: function (t, e) {
            for (var a = ["webkit-", "moz-", "ms-", "o-", ""], n = 0; n < a.length; n++) mUtil.css(t, a[n] + "animation-delay", e)
        }, animateDuration: function (t, e) {
            for (var a = ["webkit-", "moz-", "ms-", "o-", ""], n = 0; n < a.length; n++) mUtil.css(t, a[n] + "animation-duration", e)
        }, scrollTo: function (t, e, a) {
            a = a || 500;
            var n, o, i = (t = mUtil.get(t)) ? mUtil.offset(t).top : 0,
                l = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
            i > l ? (n = i, o = l) : (n = l, o = i), e && (o += e), mUtil.animate(n, o, a, function (t) {
                document.documentElement.scrollTop = t, document.body.parentNode.scrollTop = t, document.body.scrollTop = t
            })
        }, scrollTop: function (t, e) {
            mUtil.scrollTo(null, t, e)
        }, isArray: function (t) {
            return t && Array.isArray(t)
        }, ready: function (t) {
            (document.attachEvent ? "complete" === document.readyState : "loading" !== document.readyState) ? t() : document.addEventListener("DOMContentLoaded", t)
        }, isEmpty: function (t) {
            for (var e in t) if (t.hasOwnProperty(e)) return !1;
            return !0
        }, numberString: function (t) {
            for (var e = (t += "").split("."), a = e[0], n = e.length > 1 ? "." + e[1] : "", o = /(\d+)(\d{3})/; o.test(a);) a = a.replace(o, "$1,$2");
            return a + n
        }, detectIE: function () {
            var t = window.navigator.userAgent, e = t.indexOf("MSIE ");
            if (e > 0) return parseInt(t.substring(e + 5, t.indexOf(".", e)), 10);
            if (t.indexOf("Trident/") > 0) {
                var a = t.indexOf("rv:");
                return parseInt(t.substring(a + 3, t.indexOf(".", a)), 10)
            }
            var n = t.indexOf("Edge/");
            return n > 0 && parseInt(t.substring(n + 5, t.indexOf(".", n)), 10)
        }, isRTL: function () {
            return "rtl" == mUtil.attr(mUtil.get("html"), "direction")
        }, scrollerInit: function (t, e) {
            function a() {
                var a, n;
                n = e.height instanceof Function ? parseInt(e.height.call()) : parseInt(e.height), e.disableForMobile && mUtil.isInResponsiveRange("tablet-and-mobile") ? (a = mUtil.data(t).get("ps")) ? (e.resetHeightOnDestroy ? mUtil.css(t, "height", "auto") : (mUtil.css(t, "overflow", "auto"), n > 0 && mUtil.css(t, "height", n + "px")), a.destroy(), a = mUtil.data(t).remove("ps")) : n > 0 && (mUtil.css(t, "overflow", "auto"), mUtil.css(t, "height", n + "px")) : (n > 0 && mUtil.css(t, "height", n + "px"), mUtil.css(t, "overflow", "hidden"), (a = mUtil.data(t).get("ps")) ? a.update() : (mUtil.addClass(t, "m-scroller"), a = new PerfectScrollbar(t, {
                    wheelSpeed: .5,
                    swipeEasing: !0,
                    wheelPropagation: !1,
                    minScrollbarLength: 40,
                    suppressScrollX: !0
                }), mUtil.data(t).set("ps", a)))
            }

            a(), e.handleWindowResize && mUtil.addResizeHandler(function () {
                a()
            })
        }, scrollerUpdate: function (t) {
            var e;
            (e = mUtil.data(t).get("ps")) && e.update()
        }, scrollersUpdate: function (t) {
            for (var e = mUtil.findAll(t, ".ps"), a = 0, n = e.length; a < n; a++) mUtil.scrollerUpdate(e[a])
        }, scrollerTop: function (t) {
            mUtil.data(t).get("ps") && (t.scrollTop = 0)
        }, scrollerDestroy: function (t) {
            var e;
            (e = mUtil.data(t).get("ps")) && (e.destroy(), e = mUtil.data(t).remove("ps"))
        }
    }
}();
mPortlet = function (t, e) {
    var a = this, n = mUtil.get(t), o = mUtil.get("body");
    if (n) {
        var l = {
            bodyToggleSpeed: 400,
            tooltips: !0,
            tools: {
                toggle: {collapse: "Collapse", expand: "Expand"},
                reload: "Reload",
                remove: "Remove",
                fullscreen: {on: "Fullscreen", off: "Exit Fullscreen"},
                addRegister:"Agregar"
            },
            sticky: {offset: 300, zIndex: 98}
        }, r = {
            construct: function (t) {
                return mUtil.data(n).has("portlet") ? a = mUtil.data(n).get("portlet") : (r.init(t), r.build(), mUtil.data(n).set("portlet", a)), a
            }, init: function (t) {
                a.element = n, a.events = [], a.options = mUtil.deepExtend({}, l, t), a.head = mUtil.child(n, ".m-portlet__head"), a.foot = mUtil.child(n, ".m-portlet__foot"), mUtil.child(n, ".m-portlet__body") ? a.body = mUtil.child(n, ".m-portlet__body") : 0 !== mUtil.child(n, ".m-form").length && (a.body = mUtil.child(n, ".m-form"))
            }, build: function () {
                var t = mUtil.find(a.head, "[m-portlet-tool=remove]");
                t && mUtil.addEvent(t, "click", function (t) {
                    t.preventDefault(), r.remove()
                });
                var e = mUtil.find(a.head, "[m-portlet-tool=reload]");
                e && mUtil.addEvent(e, "click", function (t) {
                    t.preventDefault(), r.reload()
                });
                var n = mUtil.find(a.head, "[m-portlet-tool=toggle]");
                n && mUtil.addEvent(n, "click", function (t) {
                    t.preventDefault(), r.toggle()
                });
                var o = mUtil.find(a.head, "[m-portlet-tool=fullscreen]");
                o && mUtil.addEvent(o, "click", function (t) {
                    t.preventDefault(), r.fullscreen()
                }), r.setupTooltips()
            }, onScrollSticky: function () {
                window.pageYOffset > a.options.sticky.offset ? !1 === mUtil.hasClass(o, "m-portlet--sticky") && (r.eventTrigger("stickyOn"), mUtil.addClass(o, "m-portlet--sticky"), mUtil.addClass(n, "m-portlet--sticky"), r.updateSticky()) : mUtil.hasClass(o, "m-portlet--sticky") && (r.eventTrigger("stickyOff"), mUtil.removeClass(o, "m-portlet--sticky"), mUtil.removeClass(n, "m-portlet--sticky"), r.resetSticky())
            }, initSticky: function () {
                a.head && window.addEventListener("scroll", r.onScrollSticky)
            }, updateSticky: function () {
                var t, e, n;
                a.head && (mUtil.hasClass(o, "m-portlet--sticky") && (t = a.options.sticky.position.top instanceof Function ? parseInt(a.options.sticky.position.top.call()) : parseInt(a.options.sticky.position.top), e = a.options.sticky.position.left instanceof Function ? parseInt(a.options.sticky.position.left.call()) : parseInt(a.options.sticky.position.left), n = a.options.sticky.position.right instanceof Function ? parseInt(a.options.sticky.position.right.call()) : parseInt(a.options.sticky.position.right), mUtil.css(a.head, "z-index", a.options.sticky.zIndex), mUtil.css(a.head, "top", t + "px"), mUtil.isRTL() ? (mUtil.css(a.head, "left", n + "px"), mUtil.css(a.head, "right", e + "px")) : (mUtil.css(a.head, "left", e + "px"), mUtil.css(a.head, "right", n + "px"))))
            }, resetSticky: function () {
                a.head && !1 === mUtil.hasClass(o, "m-portlet--sticky") && (mUtil.css(a.head, "z-index", ""), mUtil.css(a.head, "top", ""), mUtil.css(a.head, "left", ""), mUtil.css(a.head, "right", ""))
            }, destroySticky: function () {
                a.head && (r.resetSticky(), window.removeEventListener("scroll", r.onScrollSticky))
            }, remove: function () {
                !1 !== r.eventTrigger("beforeRemove") && (mUtil.hasClass(o, "m-portlet--fullscreen") && mUtil.hasClass(n, "m-portlet--fullscreen") && r.fullscreen("off"), r.removeTooltips(), mUtil.remove(n), r.eventTrigger("afterRemove"))
            }, setContent: function (t) {
                t && (a.body.innerHTML = t)
            }, getBody: function () {
                return a.body
            }, getSelf: function () {
                return n
            }, setupTooltips: function () {
                if (a.options.tooltips) {
                    var t = mUtil.hasClass(n, "m-portlet--collapse") || mUtil.hasClass(n, "m-portlet--collapsed"),
                        e = mUtil.hasClass(o, "m-portlet--fullscreen") && mUtil.hasClass(n, "m-portlet--fullscreen"),
                        i = mUtil.find(a.head, "[m-portlet-tool=remove]");
                    if (i) {
                        var l = e ? "bottom" : "top", r = new Tooltip(i, {
                            title: a.options.tools.remove,
                            placement: l,
                            offset: e ? "0,10px,0,0" : "0,5px",
                            trigger: "hover",
                            template: '<div class="m-tooltip m-tooltip--portlet tooltip bs-tooltip-' + l + '" role="tooltip">                            <div class="tooltip-arrow arrow"></div>                            <div class="tooltip-inner"></div>                        </div>'
                        });
                        mUtil.data(i).set("tooltip", r)
                    }
                    var s = mUtil.find(a.head, "[m-portlet-tool=reload]");
                    if (s) {
                        l = e ? "bottom" : "top", r = new Tooltip(s, {
                            title: a.options.tools.reload,
                            placement: l,
                            offset: e ? "0,10px,0,0" : "0,5px",
                            trigger: "hover",
                            template: '<div class="m-tooltip m-tooltip--portlet tooltip bs-tooltip-' + l + '" role="tooltip">                            <div class="tooltip-arrow arrow"></div>                            <div class="tooltip-inner"></div>                        </div>'
                        });
                        mUtil.data(s).set("tooltip", r)
                    }
                    var d = mUtil.find(a.head, "[m-portlet-tool=toggle]");
                    if (d) {
                        l = e ? "bottom" : "top", r = new Tooltip(d, {
                            title: t ? a.options.tools.toggle.expand : a.options.tools.toggle.collapse,
                            placement: l,
                            offset: e ? "0,10px,0,0" : "0,5px",
                            trigger: "hover",
                            template: '<div class="m-tooltip m-tooltip--portlet tooltip bs-tooltip-' + l + '" role="tooltip">                            <div class="tooltip-arrow arrow"></div>                            <div class="tooltip-inner"></div>                        </div>'
                        });
                        mUtil.data(d).set("tooltip", r)
                    }
                    var c = mUtil.find(a.head, "[m-portlet-tool=fullscreen]");
                    if (c) {
                        l = e ? "bottom" : "top", r = new Tooltip(c, {
                            title: e ? a.options.tools.fullscreen.off : a.options.tools.fullscreen.on,
                            placement: l,
                            offset: e ? "0,10px,0,0" : "0,5px",
                            trigger: "hover",
                            template: '<div class="m-tooltip m-tooltip--portlet tooltip bs-tooltip-' + l + '" role="tooltip">                            <div class="tooltip-arrow arrow"></div>                            <div class="tooltip-inner"></div>                        </div>'
                        });
                        mUtil.data(c).set("tooltip", r)
                    }
                }
            }, removeTooltips: function () {
                if (a.options.tooltips) {
                    var t = mUtil.find(a.head, "[m-portlet-tool=remove]");
                    t && mUtil.data(t).has("tooltip") && mUtil.data(t).get("tooltip").dispose();
                    var e = mUtil.find(a.head, "[m-portlet-tool=reload]");
                    e && mUtil.data(e).has("tooltip") && mUtil.data(e).get("tooltip").dispose();
                    var n = mUtil.find(a.head, "[m-portlet-tool=toggle]");
                    n && mUtil.data(n).has("tooltip") && mUtil.data(n).get("tooltip").dispose();
                    var o = mUtil.find(a.head, "[m-portlet-tool=fullscreen]");
                    o && mUtil.data(o).has("tooltip") && mUtil.data(o).get("tooltip").dispose()
                }
            }, reload: function () {
                r.eventTrigger("reload")
            }, toggle: function () {
                mUtil.hasClass(n, "m-portlet--collapse") || mUtil.hasClass(n, "m-portlet--collapsed") ? r.expand() : r.collapse()
            }, collapse: function () {
                if (!1 !== r.eventTrigger("beforeCollapse")) {
                    mUtil.slideUp(a.body, a.options.bodyToggleSpeed, function () {
                        r.eventTrigger("afterCollapse")
                    }), mUtil.addClass(n, "m-portlet--collapse");
                    var t = mUtil.find(a.head, "[m-portlet-tool=toggle]");
                    t && mUtil.data(t).has("tooltip") && mUtil.data(t).get("tooltip").updateTitleContent(a.options.tools.toggle.expand)
                }
            }, expand: function () {
                if (!1 !== r.eventTrigger("beforeExpand")) {
                    mUtil.slideDown(a.body, a.options.bodyToggleSpeed, function () {
                        r.eventTrigger("afterExpand")
                    }), mUtil.removeClass(n, "m-portlet--collapse"), mUtil.removeClass(n, "m-portlet--collapsed");
                    var t = mUtil.find(a.head, "[m-portlet-tool=toggle]");
                    t && mUtil.data(t).has("tooltip") && mUtil.data(t).get("tooltip").updateTitleContent(a.options.tools.toggle.collapse)
                }
            }, fullscreen: function (t) {
                if ("off" === t || mUtil.hasClass(o, "m-portlet--fullscreen") && mUtil.hasClass(n, "m-portlet--fullscreen")) r.eventTrigger("beforeFullscreenOff"), mUtil.removeClass(o, "m-portlet--fullscreen"), mUtil.removeClass(n, "m-portlet--fullscreen"), r.removeTooltips(), r.setupTooltips(), a.foot && (mUtil.css(a.body, "margin-bottom", ""), mUtil.css(a.foot, "margin-top", "")), r.eventTrigger("afterFullscreenOff"); else {
                    if (r.eventTrigger("beforeFullscreenOn"), mUtil.addClass(n, "m-portlet--fullscreen"), mUtil.addClass(o, "m-portlet--fullscreen"), r.removeTooltips(), r.setupTooltips(), a.foot) {
                        var e = parseInt(mUtil.css(a.foot, "height")),
                            i = parseInt(mUtil.css(a.foot, "height")) + parseInt(mUtil.css(a.head, "height"));
                        mUtil.css(a.body, "margin-bottom", e + "px"), mUtil.css(a.foot, "margin-top", "-" + i + "px")
                    }
                    r.eventTrigger("afterFullscreenOn")
                }
            }, eventTrigger: function (t) {
                for (i = 0; i < a.events.length; i++) {
                    var e = a.events[i];
                    e.name == t && (1 == e.one ? 0 == e.fired && (a.events[i].fired = !0, e.handler.call(this, a)) : e.handler.call(this, a))
                }
            }, addEvent: function (t, e, n) {
                return a.events.push({name: t, handler: e, one: n, fired: !1}), a
            }
        };
        return a.setDefaults = function (t) {
            l = t
        }, a.remove = function () {
            return r.remove(html)
        }, a.initSticky = function () {
            return r.initSticky()
        }, a.updateSticky = function () {
            return r.updateSticky()
        }, a.resetSticky = function () {
            return r.resetSticky()
        }, a.destroySticky = function () {
            return r.destroySticky()
        }, a.reload = function () {
            return r.reload()
        }, a.setContent = function (t) {
            return r.setContent(t)
        }, a.toggle = function () {
            return r.toggle()
        }, a.collapse = function () {
            return r.collapse()
        }, a.expand = function () {
            return r.expand()
        }, a.fullscreen = function () {
            return r.fullscreen("on")
        }, a.unFullscreen = function () {
            return r.fullscreen("off")
        }, a.getBody = function () {
            return r.getBody()
        }, a.getSelf = function () {
            return r.getSelf()
        }, a.on = function (t, e) {
            return r.addEvent(t, e)
        }, a.one = function (t, e) {
            return r.addEvent(t, e, !0)
        }, r.construct.apply(a, [e]), a
    }
};
var mWizard = function (t, e) {
    var a = this, n = mUtil.get(t);
    mUtil.get("body");
    if (n) {
        var o = {startStep: 1, manualStepForward: !1}, l = {
            construct: function (t) {
                return mUtil.data(n).has("wizard") ? a = mUtil.data(n).get("wizard") : (l.init(t), l.build(), mUtil.data(n).set("wizard", a)), a
            }, init: function (t) {
                a.element = n, a.events = [], a.options = mUtil.deepExtend({}, o, t), a.steps = mUtil.findAll(n, ".m-wizard__step"), a.progress = mUtil.find(n, ".m-wizard__progress .progress-bar"), a.btnSubmit = mUtil.find(n, '[data-wizard-action="submit"]'), a.btnNext = mUtil.find(n, '[data-wizard-action="next"]'), a.btnPrev = mUtil.find(n, '[data-wizard-action="prev"]'), a.btnLast = mUtil.find(n, '[data-wizard-action="last"]'), a.btnFirst = mUtil.find(n, '[data-wizard-action="first"]'), a.events = [], a.currentStep = 1, a.stopped = !1, a.totalSteps = a.steps.length, a.options.startStep > 1 && l.goTo(a.options.startStep), l.updateUI()
            }, build: function () {
                mUtil.addEvent(a.btnNext, "click", function (t) {
                    t.preventDefault(), l.goNext()
                }), mUtil.addEvent(a.btnPrev, "click", function (t) {
                    t.preventDefault(), l.goPrev()
                }), mUtil.addEvent(a.btnFirst, "click", function (t) {
                    t.preventDefault(), l.goFirst()
                }), mUtil.addEvent(a.btnLast, "click", function (t) {
                    t.preventDefault(), l.goLast()
                }), mUtil.on(n, ".m-wizard__step a.m-wizard__step-number", "click", function () {
                    for (var t, e = this.closest(".m-wizard__step"), n = mUtil.parents(this, ".m-wizard__steps"), o = mUtil.findAll(n, ".m-wizard__step"), i = 0, r = o.length; i < r; i++) if (e === o[i]) {
                        t = i + 1;
                        break
                    }
                    t && (!1 === a.options.manualStepForward ? t < a.currentStep && l.goTo(t) : l.goTo(t))
                })
            }, goTo: function (t) {
                if (!(t === a.currentStep || t > a.totalSteps || t < 0)) {
                    var e;
                    if (e = (t = t ? parseInt(t) : l.getNextStep()) > a.currentStep ? l.eventTrigger("beforeNext") : l.eventTrigger("beforePrev"), !0 !== a.stopped) return !1 !== e && (l.eventTrigger("beforeChange"), a.currentStep = t, l.updateUI(), l.eventTrigger("change")), t > a.startStep ? l.eventTrigger("afterNext") : l.eventTrigger("afterPrev"), a;
                    a.stopped = !1
                }
            }, setStepClass: function () {
                l.isLastStep() ? mUtil.addClass(n, "m-wizard--step-last") : mUtil.removeClass(n, "m-wizard--step-last"), l.isFirstStep() ? mUtil.addClass(n, "m-wizard--step-first") : mUtil.removeClass(n, "m-wizard--step-first"), l.isBetweenStep() ? mUtil.addClass(n, "m-wizard--step-between") : mUtil.removeClass(n, "m-wizard--step-between")
            }, updateUI: function (t) {
                l.updateProgress(), l.handleTarget(), l.setStepClass();
                for (var e = 0, n = a.steps.length; e < n; e++) mUtil.removeClass(a.steps[e], "m-wizard__step--current m-wizard__step--done");
                for (e = 1; e < a.currentStep; e++) mUtil.addClass(a.steps[e - 1], "m-wizard__step--done");
                mUtil.addClass(a.steps[a.currentStep - 1], "m-wizard__step--current")
            }, stop: function () {
                a.stopped = !0
            }, start: function () {
                a.stopped = !1
            }, isLastStep: function () {
                return a.currentStep === a.totalSteps
            }, isFirstStep: function () {
                return 1 === a.currentStep
            }, isBetweenStep: function () {
                return !1 === l.isLastStep() && !1 === l.isFirstStep()
            }, goNext: function () {
                return l.goTo(l.getNextStep())
            }, goPrev: function () {
                return l.goTo(l.getPrevStep())
            }, goLast: function () {
                return l.goTo(a.totalSteps)
            }, goFirst: function () {
                return l.goTo(1)
            }, updateProgress: function () {
                if (a.progress) if (mUtil.hasClass(n, "m-wizard--1")) {
                    var t = a.currentStep / a.totalSteps * 100, e = mUtil.find(n, ".m-wizard__step-number"),
                        o = parseInt(mUtil.css(e, "width"));
                    mUtil.css(a.progress, "width", "calc(" + t + "% + " + o / 2 + "px)")
                } else if (mUtil.hasClass(n, "m-wizard--2")) {
                    a.currentStep;
                    var i = (a.currentStep - 1) * (1 / (a.totalSteps - 1) * 100);
                    mUtil.isInResponsiveRange("minimal-desktop-and-below") ? mUtil.css(a.progress, "height", i + "%") : mUtil.css(a.progress, "width", i + "%")
                } else {
                    t = a.currentStep / a.totalSteps * 100;
                    mUtil.css(a.progress, "width", t + "%")
                }
            }, handleTarget: function () {
                var t = a.steps[a.currentStep - 1], e = mUtil.get(mUtil.attr(t, "m-wizard-target")),
                    o = mUtil.find(n, ".m-wizard__form-step--current");
                mUtil.removeClass(o, "m-wizard__form-step--current"), mUtil.addClass(e, "m-wizard__form-step--current")
            }, getNextStep: function () {
                return a.totalSteps >= a.currentStep + 1 ? a.currentStep + 1 : a.totalSteps
            }, getPrevStep: function () {
                return a.currentStep - 1 >= 1 ? a.currentStep - 1 : 1
            }, eventTrigger: function (t) {
                for (i = 0; i < a.events.length; i++) {
                    var e = a.events[i];
                    e.name == t && (1 == e.one ? 0 == e.fired && (a.events[i].fired = !0, e.handler.call(this, a)) : e.handler.call(this, a))
                }
            }, addEvent: function (t, e, n) {
                return a.events.push({name: t, handler: e, one: n, fired: !1}), a
            }
        };
        return a.setDefaults = function (t) {
            o = t
        }, a.goNext = function () {
            return l.goNext()
        }, a.goPrev = function () {
            return l.goPrev()
        }, a.goLast = function () {
            return l.goLast()
        }, a.stop = function () {
            return l.stop()
        }, a.start = function () {
            return l.start()
        }, a.goFirst = function () {
            return l.goFirst()
        }, a.goTo = function (t) {
            return l.goTo(t)
        }, a.getStep = function () {
            return a.currentStep
        }, a.isLastStep = function () {
            return l.isLastStep()
        }, a.isFirstStep = function () {
            return l.isFirstStep()
        }, a.on = function (t, e) {
            return l.addEvent(t, e)
        }, a.one = function (t, e) {
            return l.addEvent(t, e, !0)
        }, l.construct.apply(a, [e]), a
    }
};
