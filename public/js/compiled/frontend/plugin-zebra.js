(() => {
    var e, t, r = {
        978: (e, t) => {
            "use strict";
            Object.defineProperty(t, "__esModule", {value: !0}), t.API_URL = void 0, t.API_URL = "http://localhost:9100/"
        }, 56: function (e, t, r) {
            "use strict";

            function n(e) {
                return n = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
                    return typeof e
                } : function (e) {
                    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
                }, n(e)
            }

            var i = this && this.__awaiter || function (e, t, r, n) {
                return new (r || (r = Promise))((function (i, s) {
                    function a(e) {
                        try {
                            c(n.next(e))
                        } catch (e) {
                            s(e)
                        }
                    }

                    function o(e) {
                        try {
                            c(n.throw(e))
                        } catch (e) {
                            s(e)
                        }
                    }

                    function c(e) {
                        var t;
                        e.done ? i(e.value) : (t = e.value, t instanceof r ? t : new r((function (e) {
                            e(t)
                        }))).then(a, o)
                    }

                    c((n = n.apply(e, t || [])).next())
                }))
            }, s = this && this.__generator || function (e, t) {
                var r, n, i, s, a = {
                    label: 0, sent: function () {
                        if (1 & i[0]) throw i[1];
                        return i[1]
                    }, trys: [], ops: []
                };
                return s = {
                    next: o(0),
                    throw: o(1),
                    return: o(2)
                }, "function" == typeof Symbol && (s[Symbol.iterator] = function () {
                    return this
                }), s;

                function o(s) {
                    return function (o) {
                        return function (s) {
                            if (r) throw new TypeError("Generator is already executing.");
                            for (; a;) try {
                                if (r = 1, n && (i = 2 & s[0] ? n.return : s[0] ? n.throw || ((i = n.return) && i.call(n), 0) : n.next) && !(i = i.call(n, s[1])).done) return i;
                                switch (n = 0, i && (s = [2 & s[0], i.value]), s[0]) {
                                    case 0:
                                    case 1:
                                        i = s;
                                        break;
                                    case 4:
                                        return a.label++, {value: s[1], done: !1};
                                    case 5:
                                        a.label++, n = s[1], s = [0];
                                        continue;
                                    case 7:
                                        s = a.ops.pop(), a.trys.pop();
                                        continue;
                                    default:
                                        if (!(i = a.trys, (i = i.length > 0 && i[i.length - 1]) || 6 !== s[0] && 2 !== s[0])) {
                                            a = 0;
                                            continue
                                        }
                                        if (3 === s[0] && (!i || s[1] > i[0] && s[1] < i[3])) {
                                            a.label = s[1];
                                            break
                                        }
                                        if (6 === s[0] && a.label < i[1]) {
                                            a.label = i[1], i = s;
                                            break
                                        }
                                        if (i && a.label < i[2]) {
                                            a.label = i[2], a.ops.push(s);
                                            break
                                        }
                                        i[2] && a.ops.pop(), a.trys.pop();
                                        continue
                                }
                                s = t.call(e, a)
                            } catch (e) {
                                s = [6, e], n = 0
                            } finally {
                                r = i = 0
                            }
                            if (5 & s[0]) throw s[1];
                            return {value: s[0] ? s[1] : void 0, done: !0}
                        }([s, o])
                    }
                }
            };
            Object.defineProperty(t, "__esModule", {value: !0});
            var a = r(978), o = function () {
                var e = this;
                this.device = {}, this.getAvailablePrinters = function () {
                    return i(e, void 0, void 0, (function () {
                        var e, t, r, n;
                        return s(this, (function (i) {
                            switch (i.label) {
                                case 0:
                                    e = {
                                        method: "GET",
                                        headers: {"Content-Type": "text/plain;charset=UTF-8"}
                                    }, t = a.API_URL + "available", i.label = 1;
                                case 1:
                                    return i.trys.push([1, 4, , 5]), [4, fetch(t, e)];
                                case 2:
                                    return [4, i.sent().json()];
                                case 3:
                                    return (r = i.sent()) && void 0 !== r && r.printer && void 0 !== r.printer && r.printer.length > 0 ? [2, r.printer] : [2, new Error("No printers available")];
                                case 4:
                                    throw n = i.sent(), new Error(n);
                                case 5:
                                    return [2]
                            }
                        }))
                    }))
                }, this.getDefaultPrinter = function () {
                    return i(e, void 0, void 0, (function () {
                        var e, t, r, i, o, c, u, h, l, p, f;
                        return s(this, (function (s) {
                            switch (s.label) {
                                case 0:
                                    e = {
                                        method: "GET",
                                        headers: {"Content-Type": "text/plain;charset=UTF-8"}
                                    }, t = a.API_URL + "default", s.label = 1;
                                case 1:
                                    return s.trys.push([1, 4, , 5]), [4, fetch(t, e)];
                                case 2:
                                    return [4, s.sent().text()];
                                case 3:
                                    if ((r = s.sent()) && void 0 !== r && "object" !== n(r) && 7 === r.split("\n\t").length) return i = r.split("\n\t"), o = this.cleanUpString(i[1]), c = this.cleanUpString(i[2]), u = this.cleanUpString(i[3]), h = this.cleanUpString(i[4]), l = this.cleanUpString(i[5]), p = this.cleanUpString(i[6]), [2, {
                                        connection: u,
                                        deviceType: c,
                                        manufacturer: p,
                                        name: o,
                                        provider: l,
                                        uid: h,
                                        version: 0
                                    }];
                                    throw new Error("There's no default printer");
                                case 4:
                                    throw f = s.sent(), new Error(f);
                                case 5:
                                    return [2]
                            }
                        }))
                    }))
                }, this.setPrinter = function (t) {
                    e.device = t
                }, this.getPrinter = function () {
                    return e.device
                }, this.cleanUpString = function (e) {
                    return e.split(":")[1].trim()
                }, this.checkPrinterStatus = function () {
                    return i(e, void 0, void 0, (function () {
                        var e, t, r, n, i, a, o;
                        return s(this, (function (s) {
                            switch (s.label) {
                                case 0:
                                    return [4, this.write("~HQES")];
                                case 1:
                                    return s.sent(), [4, this.read()];
                                case 2:
                                    switch (e = s.sent(), t = [], n = e.charAt(70), i = e.charAt(88), a = e.charAt(87), o = e.charAt(84), r = "0" === n, i) {
                                        case"1":
                                            t.push("Paper out");
                                            break;
                                        case"2":
                                            t.push("Ribbon Out");
                                            break;
                                        case"4":
                                            t.push("Media Door Open");
                                            break;
                                        case"8":
                                            t.push("Cutter Fault")
                                    }
                                    switch (a) {
                                        case"1":
                                            t.push("Printhead Overheating");
                                            break;
                                        case"2":
                                            t.push("Motor Overheating");
                                            break;
                                        case"4":
                                            t.push("Printhead Fault");
                                            break;
                                        case"8":
                                            t.push("Incorrect Printhead")
                                    }
                                    return "1" === o && t.push("Printer Paused"), r || 0 !== t.length || t.push("Error: Unknown Error"), [2, {
                                        isReadyToPrint: r,
                                        errors: t.join()
                                    }]
                            }
                        }))
                    }))
                }, this.write = function (t) {
                    return i(e, void 0, void 0, (function () {
                        var e, r, n, i;
                        return s(this, (function (s) {
                            switch (s.label) {
                                case 0:
                                    return s.trys.push([0, 2, , 3]), e = a.API_URL + "write", r = {
                                        device: this.device,
                                        data: t
                                    }, n = {
                                        method: "POST",
                                        headers: {"Content-Type": "text/plain;charset=UTF-8"},
                                        body: JSON.stringify(r)
                                    }, [4, fetch(e, n)];
                                case 1:
                                    return s.sent(), [3, 3];
                                case 2:
                                    throw i = s.sent(), new Error(i);
                                case 3:
                                    return [2]
                            }
                        }))
                    }))
                }, this.read = function () {
                    return i(e, void 0, void 0, (function () {
                        var e, t, r, n;
                        return s(this, (function (i) {
                            switch (i.label) {
                                case 0:
                                    return i.trys.push([0, 3, , 4]), e = a.API_URL + "read", t = {device: this.device}, r = {
                                        method: "POST",
                                        headers: {"Content-Type": "text/plain;charset=UTF-8"},
                                        body: JSON.stringify(t)
                                    }, [4, fetch(e, r)];
                                case 1:
                                    return [4, i.sent().text()];
                                case 2:
                                    return [2, i.sent()];
                                case 3:
                                    throw n = i.sent(), new Error(n);
                                case 4:
                                    return [2]
                            }
                        }))
                    }))
                }, this.print = function (t) {
                    return i(e, void 0, void 0, (function () {
                        var e;
                        return s(this, (function (r) {
                            switch (r.label) {
                                case 0:
                                    return r.trys.push([0, 2, , 3]), [4, this.write(t)];
                                case 1:
                                    return r.sent(), [3, 3];
                                case 2:
                                    throw e = r.sent(), new Error(e);
                                case 3:
                                    return [2]
                            }
                        }))
                    }))
                }
            };
            t.default = o
        }
    }, n = {};

    function i(e) {
        var t = n[e];
        if (void 0 !== t) return t.exports;
        var s = n[e] = {exports: {}};
        return r[e].call(s.exports, s, s.exports, i), s.exports
    }

    e = i(56), t = new e, window.ZebraBrowserPrintWrapperManager = {ZebraBrowserPrintWrapper: e, browserPrint: t}
})();
