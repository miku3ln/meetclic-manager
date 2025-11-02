!function (e, t) {
    "object" == typeof module && "object" == typeof module.exports ? module.exports = e.document ? t(e, !0) : function (e) {
        if (!e.document) throw new Error("jQuery requires a window with a document");
        return t(e)
    } : t(e)
}("undefined" != typeof window ? window : this, function (e, t) {
    var n = [], i = e.document, o = n.slice, r = n.concat, s = n.push, a = n.indexOf, l = {}, c = l.toString,
        d = l.hasOwnProperty, u = {}, p = "2.2.0", f = function (e, t) {
            return new f.fn.init(e, t)
        }, h = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, m = /^-ms-/, v = /-([\da-z])/gi, g = function (e, t) {
            return t.toUpperCase()
        };

    function y(e) {
        var t = !!e && "length" in e && e.length, n = f.type(e);
        return "function" !== n && !f.isWindow(e) && ("array" === n || 0 === t || "number" == typeof t && t > 0 && t - 1 in e)
    }

    f.fn = f.prototype = {
        jquery: p, constructor: f, selector: "", length: 0, toArray: function () {
            return o.call(this)
        }, get: function (e) {
            return null != e ? 0 > e ? this[e + this.length] : this[e] : o.call(this)
        }, pushStack: function (e) {
            var t = f.merge(this.constructor(), e);
            return t.prevObject = this, t.context = this.context, t
        }, each: function (e) {
            return f.each(this, e)
        }, map: function (e) {
            return this.pushStack(f.map(this, function (t, n) {
                return e.call(t, n, t)
            }))
        }, slice: function () {
            return this.pushStack(o.apply(this, arguments))
        }, first: function () {
            return this.eq(0)
        }, last: function () {
            return this.eq(-1)
        }, eq: function (e) {
            var t = this.length, n = +e + (0 > e ? t : 0);
            return this.pushStack(n >= 0 && t > n ? [this[n]] : [])
        }, end: function () {
            return this.prevObject || this.constructor()
        }, push: s, sort: n.sort, splice: n.splice
    }, f.extend = f.fn.extend = function () {
        var e, t, n, i, o, r, s = arguments[0] || {}, a = 1, l = arguments.length, c = !1;
        for ("boolean" == typeof s && (c = s, s = arguments[a] || {}, a++), "object" == typeof s || f.isFunction(s) || (s = {}), a === l && (s = this, a--); l > a; a++) if (null != (e = arguments[a])) for (t in e) n = s[t], s !== (i = e[t]) && (c && i && (f.isPlainObject(i) || (o = f.isArray(i))) ? (o ? (o = !1, r = n && f.isArray(n) ? n : []) : r = n && f.isPlainObject(n) ? n : {}, s[t] = f.extend(c, r, i)) : void 0 !== i && (s[t] = i));
        return s
    }, f.extend({
        expando: "jQuery" + (p + Math.random()).replace(/\D/g, ""), isReady: !0, error: function (e) {
            throw new Error(e)
        }, noop: function () {
        }, isFunction: function (e) {
            return "function" === f.type(e)
        }, isArray: Array.isArray, isWindow: function (e) {
            return null != e && e === e.window
        }, isNumeric: function (e) {
            var t = e && e.toString();
            return !f.isArray(e) && t - parseFloat(t) + 1 >= 0
        }, isPlainObject: function (e) {
            return "object" === f.type(e) && !e.nodeType && !f.isWindow(e) && !(e.constructor && !d.call(e.constructor.prototype, "isPrototypeOf"))
        }, isEmptyObject: function (e) {
            var t;
            for (t in e) return !1;
            return !0
        }, type: function (e) {
            return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? l[c.call(e)] || "object" : typeof e
        }, globalEval: function (e) {
            var t, n = eval;
            (e = f.trim(e)) && (1 === e.indexOf("use strict") ? ((t = i.createElement("script")).text = e, i.head.appendChild(t).parentNode.removeChild(t)) : n(e))
        }, camelCase: function (e) {
            return e.replace(m, "ms-").replace(v, g)
        }, nodeName: function (e, t) {
            return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
        }, each: function (e, t) {
            var n, i = 0;
            if (y(e)) for (n = e.length; n > i && !1 !== t.call(e[i], i, e[i]); i++) ; else for (i in e) if (!1 === t.call(e[i], i, e[i])) break;
            return e
        }, trim: function (e) {
            return null == e ? "" : (e + "").replace(h, "")
        }, makeArray: function (e, t) {
            var n = t || [];
            return null != e && (y(Object(e)) ? f.merge(n, "string" == typeof e ? [e] : e) : s.call(n, e)), n
        }, inArray: function (e, t, n) {
            return null == t ? -1 : a.call(t, e, n)
        }, merge: function (e, t) {
            for (var n = +t.length, i = 0, o = e.length; n > i; i++) e[o++] = t[i];
            return e.length = o, e
        }, grep: function (e, t, n) {
            for (var i = [], o = 0, r = e.length, s = !n; r > o; o++) !t(e[o], o) !== s && i.push(e[o]);
            return i
        }, map: function (e, t, n) {
            var i, o, s = 0, a = [];
            if (y(e)) for (i = e.length; i > s; s++) null != (o = t(e[s], s, n)) && a.push(o); else for (s in e) null != (o = t(e[s], s, n)) && a.push(o);
            return r.apply([], a)
        }, guid: 1, proxy: function (e, t) {
            var n, i, r;
            return "string" == typeof t && (n = e[t], t = e, e = n), f.isFunction(e) ? (i = o.call(arguments, 2), (r = function () {
                return e.apply(t || this, i.concat(o.call(arguments)))
            }).guid = e.guid = e.guid || f.guid++, r) : void 0
        }, now: Date.now, support: u
    }), "function" == typeof Symbol && (f.fn[Symbol.iterator] = n[Symbol.iterator]), f.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function (e, t) {
        l["[object " + t + "]"] = t.toLowerCase()
    });
    var b = function (e) {
        var t, n, i, o, r, s, a, l, c, d, u, p, f, h, m, v, g, y, b, w = "sizzle" + 1 * new Date, x = e.document, k = 0,
            C = 0, T = re(), S = re(), $ = re(), _ = function (e, t) {
                return e === t && (u = !0), 0
            }, E = 1 << 31, A = {}.hasOwnProperty, O = [], j = O.pop, M = O.push, I = O.push, D = O.slice,
            L = function (e, t) {
                for (var n = 0, i = e.length; i > n; n++) if (e[n] === t) return n;
                return -1
            },
            P = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
            z = "[\\x20\\t\\r\\n\\f]", N = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",
            F = "\\[" + z + "*(" + N + ")(?:" + z + "*([*^$|!~]?=)" + z + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + N + "))|)" + z + "*\\]",
            H = ":(" + N + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + F + ")*)|.*)\\)|)",
            q = new RegExp(z + "+", "g"), R = new RegExp("^" + z + "+|((?:^|[^\\\\])(?:\\\\.)*)" + z + "+$", "g"),
            W = new RegExp("^" + z + "*," + z + "*"), B = new RegExp("^" + z + "*([>+~]|" + z + ")" + z + "*"),
            U = new RegExp("=" + z + "*([^\\]'\"]*?)" + z + "*\\]", "g"), Y = new RegExp(H),
            V = new RegExp("^" + N + "$"), X = {
                ID: new RegExp("^#(" + N + ")"),
                CLASS: new RegExp("^\\.(" + N + ")"),
                TAG: new RegExp("^(" + N + "|[*])"),
                ATTR: new RegExp("^" + F),
                PSEUDO: new RegExp("^" + H),
                CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + z + "*(even|odd|(([+-]|)(\\d*)n|)" + z + "*(?:([+-]|)" + z + "*(\\d+)|))" + z + "*\\)|)", "i"),
                bool: new RegExp("^(?:" + P + ")$", "i"),
                needsContext: new RegExp("^" + z + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + z + "*((?:-\\d)?\\d*)" + z + "*\\)|)(?=[^-]|$)", "i")
            }, J = /^(?:input|select|textarea|button)$/i, G = /^h\d$/i, Q = /^[^{]+\{\s*\[native \w/,
            K = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/, Z = /[+~]/, ee = /'|\\/g,
            te = new RegExp("\\\\([\\da-f]{1,6}" + z + "?|(" + z + ")|.)", "ig"), ne = function (e, t, n) {
                var i = "0x" + t - 65536;
                return i != i || n ? t : 0 > i ? String.fromCharCode(i + 65536) : String.fromCharCode(i >> 10 | 55296, 1023 & i | 56320)
            }, ie = function () {
                p()
            };
        try {
            I.apply(O = D.call(x.childNodes), x.childNodes), O[x.childNodes.length].nodeType
        } catch (e) {
            I = {
                apply: O.length ? function (e, t) {
                    M.apply(e, D.call(t))
                } : function (e, t) {
                    for (var n = e.length, i = 0; e[n++] = t[i++];) ;
                    e.length = n - 1
                }
            }
        }

        function oe(e, t, i, o) {
            var r, a, c, d, u, h, g, y, k = t && t.ownerDocument, C = t ? t.nodeType : 9;
            if (i = i || [], "string" != typeof e || !e || 1 !== C && 9 !== C && 11 !== C) return i;
            if (!o && ((t ? t.ownerDocument || t : x) !== f && p(t), t = t || f, m)) {
                if (11 !== C && (h = K.exec(e))) if (r = h[1]) {
                    if (9 === C) {
                        if (!(c = t.getElementById(r))) return i;
                        if (c.id === r) return i.push(c), i
                    } else if (k && (c = k.getElementById(r)) && b(t, c) && c.id === r) return i.push(c), i
                } else {
                    if (h[2]) return I.apply(i, t.getElementsByTagName(e)), i;
                    if ((r = h[3]) && n.getElementsByClassName && t.getElementsByClassName) return I.apply(i, t.getElementsByClassName(r)), i
                }
                if (n.qsa && !$[e + " "] && (!v || !v.test(e))) {
                    if (1 !== C) k = t, y = e; else if ("object" !== t.nodeName.toLowerCase()) {
                        for ((d = t.getAttribute("id")) ? d = d.replace(ee, "\\$&") : t.setAttribute("id", d = w), a = (g = s(e)).length, u = V.test(d) ? "#" + d : "[id='" + d + "']"; a--;) g[a] = u + " " + me(g[a]);
                        y = g.join(","), k = Z.test(e) && fe(t.parentNode) || t
                    }
                    if (y) try {
                        return I.apply(i, k.querySelectorAll(y)), i
                    } catch (e) {
                    } finally {
                        d === w && t.removeAttribute("id")
                    }
                }
            }
            return l(e.replace(R, "$1"), t, i, o)
        }

        function re() {
            var e = [];
            return function t(n, o) {
                return e.push(n + " ") > i.cacheLength && delete t[e.shift()], t[n + " "] = o
            }
        }

        function se(e) {
            return e[w] = !0, e
        }

        function ae(e) {
            var t = f.createElement("div");
            try {
                return !!e(t)
            } catch (e) {
                return !1
            } finally {
                t.parentNode && t.parentNode.removeChild(t), t = null
            }
        }

        function le(e, t) {
            for (var n = e.split("|"), o = n.length; o--;) i.attrHandle[n[o]] = t
        }

        function ce(e, t) {
            var n = t && e,
                i = n && 1 === e.nodeType && 1 === t.nodeType && (~t.sourceIndex || E) - (~e.sourceIndex || E);
            if (i) return i;
            if (n) for (; n = n.nextSibling;) if (n === t) return -1;
            return e ? 1 : -1
        }

        function de(e) {
            return function (t) {
                return "input" === t.nodeName.toLowerCase() && t.type === e
            }
        }

        function ue(e) {
            return function (t) {
                var n = t.nodeName.toLowerCase();
                return ("input" === n || "button" === n) && t.type === e
            }
        }

        function pe(e) {
            return se(function (t) {
                return t = +t, se(function (n, i) {
                    for (var o, r = e([], n.length, t), s = r.length; s--;) n[o = r[s]] && (n[o] = !(i[o] = n[o]))
                })
            })
        }

        function fe(e) {
            return e && void 0 !== e.getElementsByTagName && e
        }

        for (t in n = oe.support = {}, r = oe.isXML = function (e) {
            var t = e && (e.ownerDocument || e).documentElement;
            return !!t && "HTML" !== t.nodeName
        }, p = oe.setDocument = function (e) {
            var t, o, s = e ? e.ownerDocument || e : x;
            return s !== f && 9 === s.nodeType && s.documentElement ? (h = (f = s).documentElement, m = !r(f), (o = f.defaultView) && o.top !== o && (o.addEventListener ? o.addEventListener("unload", ie, !1) : o.attachEvent && o.attachEvent("onunload", ie)), n.attributes = ae(function (e) {
                return e.className = "i", !e.getAttribute("className")
            }), n.getElementsByTagName = ae(function (e) {
                return e.appendChild(f.createComment("")), !e.getElementsByTagName("*").length
            }), n.getElementsByClassName = Q.test(f.getElementsByClassName), n.getById = ae(function (e) {
                return h.appendChild(e).id = w, !f.getElementsByName || !f.getElementsByName(w).length
            }), n.getById ? (i.find.ID = function (e, t) {
                if (void 0 !== t.getElementById && m) {
                    var n = t.getElementById(e);
                    return n ? [n] : []
                }
            }, i.filter.ID = function (e) {
                var t = e.replace(te, ne);
                return function (e) {
                    return e.getAttribute("id") === t
                }
            }) : (delete i.find.ID, i.filter.ID = function (e) {
                var t = e.replace(te, ne);
                return function (e) {
                    var n = void 0 !== e.getAttributeNode && e.getAttributeNode("id");
                    return n && n.value === t
                }
            }), i.find.TAG = n.getElementsByTagName ? function (e, t) {
                return void 0 !== t.getElementsByTagName ? t.getElementsByTagName(e) : n.qsa ? t.querySelectorAll(e) : void 0
            } : function (e, t) {
                var n, i = [], o = 0, r = t.getElementsByTagName(e);
                if ("*" === e) {
                    for (; n = r[o++];) 1 === n.nodeType && i.push(n);
                    return i
                }
                return r
            }, i.find.CLASS = n.getElementsByClassName && function (e, t) {
                return void 0 !== t.getElementsByClassName && m ? t.getElementsByClassName(e) : void 0
            }, g = [], v = [], (n.qsa = Q.test(f.querySelectorAll)) && (ae(function (e) {
                h.appendChild(e).innerHTML = "<a id='" + w + "'></a><select id='" + w + "-\r\\' msallowcapture=''><option selected=''></option></select>", e.querySelectorAll("[msallowcapture^='']").length && v.push("[*^$]=" + z + "*(?:''|\"\")"), e.querySelectorAll("[selected]").length || v.push("\\[" + z + "*(?:value|" + P + ")"), e.querySelectorAll("[id~=" + w + "-]").length || v.push("~="), e.querySelectorAll(":checked").length || v.push(":checked"), e.querySelectorAll("a#" + w + "+*").length || v.push(".#.+[+~]")
            }), ae(function (e) {
                var t = f.createElement("input");
                t.setAttribute("type", "hidden"), e.appendChild(t).setAttribute("name", "D"), e.querySelectorAll("[name=d]").length && v.push("name" + z + "*[*^$|!~]?="), e.querySelectorAll(":enabled").length || v.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), v.push(",.*:")
            })), (n.matchesSelector = Q.test(y = h.matches || h.webkitMatchesSelector || h.mozMatchesSelector || h.oMatchesSelector || h.msMatchesSelector)) && ae(function (e) {
                n.disconnectedMatch = y.call(e, "div"), y.call(e, "[s!='']:x"), g.push("!=", H)
            }), v = v.length && new RegExp(v.join("|")), g = g.length && new RegExp(g.join("|")), t = Q.test(h.compareDocumentPosition), b = t || Q.test(h.contains) ? function (e, t) {
                var n = 9 === e.nodeType ? e.documentElement : e, i = t && t.parentNode;
                return e === i || !(!i || 1 !== i.nodeType || !(n.contains ? n.contains(i) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(i)))
            } : function (e, t) {
                if (t) for (; t = t.parentNode;) if (t === e) return !0;
                return !1
            }, _ = t ? function (e, t) {
                if (e === t) return u = !0, 0;
                var i = !e.compareDocumentPosition - !t.compareDocumentPosition;
                return i || (1 & (i = (e.ownerDocument || e) === (t.ownerDocument || t) ? e.compareDocumentPosition(t) : 1) || !n.sortDetached && t.compareDocumentPosition(e) === i ? e === f || e.ownerDocument === x && b(x, e) ? -1 : t === f || t.ownerDocument === x && b(x, t) ? 1 : d ? L(d, e) - L(d, t) : 0 : 4 & i ? -1 : 1)
            } : function (e, t) {
                if (e === t) return u = !0, 0;
                var n, i = 0, o = e.parentNode, r = t.parentNode, s = [e], a = [t];
                if (!o || !r) return e === f ? -1 : t === f ? 1 : o ? -1 : r ? 1 : d ? L(d, e) - L(d, t) : 0;
                if (o === r) return ce(e, t);
                for (n = e; n = n.parentNode;) s.unshift(n);
                for (n = t; n = n.parentNode;) a.unshift(n);
                for (; s[i] === a[i];) i++;
                return i ? ce(s[i], a[i]) : s[i] === x ? -1 : a[i] === x ? 1 : 0
            }, f) : f
        }, oe.matches = function (e, t) {
            return oe(e, null, null, t)
        }, oe.matchesSelector = function (e, t) {
            if ((e.ownerDocument || e) !== f && p(e), t = t.replace(U, "='$1']"), n.matchesSelector && m && !$[t + " "] && (!g || !g.test(t)) && (!v || !v.test(t))) try {
                var i = y.call(e, t);
                if (i || n.disconnectedMatch || e.document && 11 !== e.document.nodeType) return i
            } catch (e) {
            }
            return oe(t, f, null, [e]).length > 0
        }, oe.contains = function (e, t) {
            return (e.ownerDocument || e) !== f && p(e), b(e, t)
        }, oe.attr = function (e, t) {
            (e.ownerDocument || e) !== f && p(e);
            var o = i.attrHandle[t.toLowerCase()],
                r = o && A.call(i.attrHandle, t.toLowerCase()) ? o(e, t, !m) : void 0;
            return void 0 !== r ? r : n.attributes || !m ? e.getAttribute(t) : (r = e.getAttributeNode(t)) && r.specified ? r.value : null
        }, oe.error = function (e) {
            throw new Error("Syntax error, unrecognized expression: " + e)
        }, oe.uniqueSort = function (e) {
            var t, i = [], o = 0, r = 0;
            if (u = !n.detectDuplicates, d = !n.sortStable && e.slice(0), e.sort(_), u) {
                for (; t = e[r++];) t === e[r] && (o = i.push(r));
                for (; o--;) e.splice(i[o], 1)
            }
            return d = null, e
        }, o = oe.getText = function (e) {
            var t, n = "", i = 0, r = e.nodeType;
            if (r) {
                if (1 === r || 9 === r || 11 === r) {
                    if ("string" == typeof e.textContent) return e.textContent;
                    for (e = e.firstChild; e; e = e.nextSibling) n += o(e)
                } else if (3 === r || 4 === r) return e.nodeValue
            } else for (; t = e[i++];) n += o(t);
            return n
        }, (i = oe.selectors = {
            cacheLength: 50,
            createPseudo: se,
            match: X,
            attrHandle: {},
            find: {},
            relative: {
                ">": {dir: "parentNode", first: !0},
                " ": {dir: "parentNode"},
                "+": {dir: "previousSibling", first: !0},
                "~": {dir: "previousSibling"}
            },
            preFilter: {
                ATTR: function (e) {
                    return e[1] = e[1].replace(te, ne), e[3] = (e[3] || e[4] || e[5] || "").replace(te, ne), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
                }, CHILD: function (e) {
                    return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || oe.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && oe.error(e[0]), e
                }, PSEUDO: function (e) {
                    var t, n = !e[6] && e[2];
                    return X.CHILD.test(e[0]) ? null : (e[3] ? e[2] = e[4] || e[5] || "" : n && Y.test(n) && (t = s(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
                }
            },
            filter: {
                TAG: function (e) {
                    var t = e.replace(te, ne).toLowerCase();
                    return "*" === e ? function () {
                        return !0
                    } : function (e) {
                        return e.nodeName && e.nodeName.toLowerCase() === t
                    }
                }, CLASS: function (e) {
                    var t = T[e + " "];
                    return t || (t = new RegExp("(^|" + z + ")" + e + "(" + z + "|$)")) && T(e, function (e) {
                        return t.test("string" == typeof e.className && e.className || void 0 !== e.getAttribute && e.getAttribute("class") || "")
                    })
                }, ATTR: function (e, t, n) {
                    return function (i) {
                        var o = oe.attr(i, e);
                        return null == o ? "!=" === t : !t || (o += "", "=" === t ? o === n : "!=" === t ? o !== n : "^=" === t ? n && 0 === o.indexOf(n) : "*=" === t ? n && o.indexOf(n) > -1 : "$=" === t ? n && o.slice(-n.length) === n : "~=" === t ? (" " + o.replace(q, " ") + " ").indexOf(n) > -1 : "|=" === t && (o === n || o.slice(0, n.length + 1) === n + "-"))
                    }
                }, CHILD: function (e, t, n, i, o) {
                    var r = "nth" !== e.slice(0, 3), s = "last" !== e.slice(-4), a = "of-type" === t;
                    return 1 === i && 0 === o ? function (e) {
                        return !!e.parentNode
                    } : function (t, n, l) {
                        var c, d, u, p, f, h, m = r !== s ? "nextSibling" : "previousSibling", v = t.parentNode,
                            g = a && t.nodeName.toLowerCase(), y = !l && !a, b = !1;
                        if (v) {
                            if (r) {
                                for (; m;) {
                                    for (p = t; p = p[m];) if (a ? p.nodeName.toLowerCase() === g : 1 === p.nodeType) return !1;
                                    h = m = "only" === e && !h && "nextSibling"
                                }
                                return !0
                            }
                            if (h = [s ? v.firstChild : v.lastChild], s && y) {
                                for (b = (f = (c = (d = (u = (p = v)[w] || (p[w] = {}))[p.uniqueID] || (u[p.uniqueID] = {}))[e] || [])[0] === k && c[1]) && c[2], p = f && v.childNodes[f]; p = ++f && p && p[m] || (b = f = 0) || h.pop();) if (1 === p.nodeType && ++b && p === t) {
                                    d[e] = [k, f, b];
                                    break
                                }
                            } else if (y && (b = f = (c = (d = (u = (p = t)[w] || (p[w] = {}))[p.uniqueID] || (u[p.uniqueID] = {}))[e] || [])[0] === k && c[1]), !1 === b) for (; (p = ++f && p && p[m] || (b = f = 0) || h.pop()) && ((a ? p.nodeName.toLowerCase() !== g : 1 !== p.nodeType) || !++b || (y && ((d = (u = p[w] || (p[w] = {}))[p.uniqueID] || (u[p.uniqueID] = {}))[e] = [k, b]), p !== t));) ;
                            return (b -= o) === i || b % i == 0 && b / i >= 0
                        }
                    }
                }, PSEUDO: function (e, t) {
                    var n, o = i.pseudos[e] || i.setFilters[e.toLowerCase()] || oe.error("unsupported pseudo: " + e);
                    return o[w] ? o(t) : o.length > 1 ? (n = [e, e, "", t], i.setFilters.hasOwnProperty(e.toLowerCase()) ? se(function (e, n) {
                        for (var i, r = o(e, t), s = r.length; s--;) e[i = L(e, r[s])] = !(n[i] = r[s])
                    }) : function (e) {
                        return o(e, 0, n)
                    }) : o
                }
            },
            pseudos: {
                not: se(function (e) {
                    var t = [], n = [], i = a(e.replace(R, "$1"));
                    return i[w] ? se(function (e, t, n, o) {
                        for (var r, s = i(e, null, o, []), a = e.length; a--;) (r = s[a]) && (e[a] = !(t[a] = r))
                    }) : function (e, o, r) {
                        return t[0] = e, i(t, null, r, n), t[0] = null, !n.pop()
                    }
                }), has: se(function (e) {
                    return function (t) {
                        return oe(e, t).length > 0
                    }
                }), contains: se(function (e) {
                    return e = e.replace(te, ne), function (t) {
                        return (t.textContent || t.innerText || o(t)).indexOf(e) > -1
                    }
                }), lang: se(function (e) {
                    return V.test(e || "") || oe.error("unsupported lang: " + e), e = e.replace(te, ne).toLowerCase(), function (t) {
                        var n;
                        do {
                            if (n = m ? t.lang : t.getAttribute("xml:lang") || t.getAttribute("lang")) return (n = n.toLowerCase()) === e || 0 === n.indexOf(e + "-")
                        } while ((t = t.parentNode) && 1 === t.nodeType);
                        return !1
                    }
                }), target: function (t) {
                    var n = e.location && e.location.hash;
                    return n && n.slice(1) === t.id
                }, root: function (e) {
                    return e === h
                }, focus: function (e) {
                    return e === f.activeElement && (!f.hasFocus || f.hasFocus()) && !!(e.type || e.href || ~e.tabIndex)
                }, enabled: function (e) {
                    return !1 === e.disabled
                }, disabled: function (e) {
                    return !0 === e.disabled
                }, checked: function (e) {
                    var t = e.nodeName.toLowerCase();
                    return "input" === t && !!e.checked || "option" === t && !!e.selected
                }, selected: function (e) {
                    return e.parentNode && e.parentNode.selectedIndex, !0 === e.selected
                }, empty: function (e) {
                    for (e = e.firstChild; e; e = e.nextSibling) if (e.nodeType < 6) return !1;
                    return !0
                }, parent: function (e) {
                    return !i.pseudos.empty(e)
                }, header: function (e) {
                    return G.test(e.nodeName)
                }, input: function (e) {
                    return J.test(e.nodeName)
                }, button: function (e) {
                    var t = e.nodeName.toLowerCase();
                    return "input" === t && "button" === e.type || "button" === t
                }, text: function (e) {
                    var t;
                    return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (t = e.getAttribute("type")) || "text" === t.toLowerCase())
                }, first: pe(function () {
                    return [0]
                }), last: pe(function (e, t) {
                    return [t - 1]
                }), eq: pe(function (e, t, n) {
                    return [0 > n ? n + t : n]
                }), even: pe(function (e, t) {
                    for (var n = 0; t > n; n += 2) e.push(n);
                    return e
                }), odd: pe(function (e, t) {
                    for (var n = 1; t > n; n += 2) e.push(n);
                    return e
                }), lt: pe(function (e, t, n) {
                    for (var i = 0 > n ? n + t : n; --i >= 0;) e.push(i);
                    return e
                }), gt: pe(function (e, t, n) {
                    for (var i = 0 > n ? n + t : n; ++i < t;) e.push(i);
                    return e
                })
            }
        }).pseudos.nth = i.pseudos.eq, {
            radio: !0,
            checkbox: !0,
            file: !0,
            password: !0,
            image: !0
        }) i.pseudos[t] = de(t);
        for (t in {submit: !0, reset: !0}) i.pseudos[t] = ue(t);

        function he() {
        }

        function me(e) {
            for (var t = 0, n = e.length, i = ""; n > t; t++) i += e[t].value;
            return i
        }

        function ve(e, t, n) {
            var i = t.dir, o = n && "parentNode" === i, r = C++;
            return t.first ? function (t, n, r) {
                for (; t = t[i];) if (1 === t.nodeType || o) return e(t, n, r)
            } : function (t, n, s) {
                var a, l, c, d = [k, r];
                if (s) {
                    for (; t = t[i];) if ((1 === t.nodeType || o) && e(t, n, s)) return !0
                } else for (; t = t[i];) if (1 === t.nodeType || o) {
                    if ((a = (l = (c = t[w] || (t[w] = {}))[t.uniqueID] || (c[t.uniqueID] = {}))[i]) && a[0] === k && a[1] === r) return d[2] = a[2];
                    if (l[i] = d, d[2] = e(t, n, s)) return !0
                }
            }
        }

        function ge(e) {
            return e.length > 1 ? function (t, n, i) {
                for (var o = e.length; o--;) if (!e[o](t, n, i)) return !1;
                return !0
            } : e[0]
        }

        function ye(e, t, n, i, o) {
            for (var r, s = [], a = 0, l = e.length, c = null != t; l > a; a++) (r = e[a]) && (!n || n(r, i, o)) && (s.push(r), c && t.push(a));
            return s
        }

        function be(e, t, n, i, o, r) {
            return i && !i[w] && (i = be(i)), o && !o[w] && (o = be(o, r)), se(function (r, s, a, l) {
                var c, d, u, p = [], f = [], h = s.length, m = r || function (e, t, n) {
                        for (var i = 0, o = t.length; o > i; i++) oe(e, t[i], n);
                        return n
                    }(t || "*", a.nodeType ? [a] : a, []), v = !e || !r && t ? m : ye(m, p, e, a, l),
                    g = n ? o || (r ? e : h || i) ? [] : s : v;
                if (n && n(v, g, a, l), i) for (c = ye(g, f), i(c, [], a, l), d = c.length; d--;) (u = c[d]) && (g[f[d]] = !(v[f[d]] = u));
                if (r) {
                    if (o || e) {
                        if (o) {
                            for (c = [], d = g.length; d--;) (u = g[d]) && c.push(v[d] = u);
                            o(null, g = [], c, l)
                        }
                        for (d = g.length; d--;) (u = g[d]) && (c = o ? L(r, u) : p[d]) > -1 && (r[c] = !(s[c] = u))
                    }
                } else g = ye(g === s ? g.splice(h, g.length) : g), o ? o(null, s, g, l) : I.apply(s, g)
            })
        }

        function we(e) {
            for (var t, n, o, r = e.length, s = i.relative[e[0].type], a = s || i.relative[" "], l = s ? 1 : 0, d = ve(function (e) {
                return e === t
            }, a, !0), u = ve(function (e) {
                return L(t, e) > -1
            }, a, !0), p = [function (e, n, i) {
                var o = !s && (i || n !== c) || ((t = n).nodeType ? d(e, n, i) : u(e, n, i));
                return t = null, o
            }]; r > l; l++) if (n = i.relative[e[l].type]) p = [ve(ge(p), n)]; else {
                if ((n = i.filter[e[l].type].apply(null, e[l].matches))[w]) {
                    for (o = ++l; r > o && !i.relative[e[o].type]; o++) ;
                    return be(l > 1 && ge(p), l > 1 && me(e.slice(0, l - 1).concat({value: " " === e[l - 2].type ? "*" : ""})).replace(R, "$1"), n, o > l && we(e.slice(l, o)), r > o && we(e = e.slice(o)), r > o && me(e))
                }
                p.push(n)
            }
            return ge(p)
        }

        function xe(e, t) {
            var n = t.length > 0, o = e.length > 0, r = function (r, s, a, l, d) {
                var u, h, v, g = 0, y = "0", b = r && [], w = [], x = c, C = r || o && i.find.TAG("*", d),
                    T = k += null == x ? 1 : Math.random() || .1, S = C.length;
                for (d && (c = s === f || s || d); y !== S && null != (u = C[y]); y++) {
                    if (o && u) {
                        for (h = 0, s || u.ownerDocument === f || (p(u), a = !m); v = e[h++];) if (v(u, s || f, a)) {
                            l.push(u);
                            break
                        }
                        d && (k = T)
                    }
                    n && ((u = !v && u) && g--, r && b.push(u))
                }
                if (g += y, n && y !== g) {
                    for (h = 0; v = t[h++];) v(b, w, s, a);
                    if (r) {
                        if (g > 0) for (; y--;) b[y] || w[y] || (w[y] = j.call(l));
                        w = ye(w)
                    }
                    I.apply(l, w), d && !r && w.length > 0 && g + t.length > 1 && oe.uniqueSort(l)
                }
                return d && (k = T, c = x), b
            };
            return n ? se(r) : r
        }

        return he.prototype = i.filters = i.pseudos, i.setFilters = new he, s = oe.tokenize = function (e, t) {
            var n, o, r, s, a, l, c, d = S[e + " "];
            if (d) return t ? 0 : d.slice(0);
            for (a = e, l = [], c = i.preFilter; a;) {
                for (s in (!n || (o = W.exec(a))) && (o && (a = a.slice(o[0].length) || a), l.push(r = [])), n = !1, (o = B.exec(a)) && (n = o.shift(), r.push({
                    value: n,
                    type: o[0].replace(R, " ")
                }), a = a.slice(n.length)), i.filter) !(o = X[s].exec(a)) || c[s] && !(o = c[s](o)) || (n = o.shift(), r.push({
                    value: n,
                    type: s,
                    matches: o
                }), a = a.slice(n.length));
                if (!n) break
            }
            return t ? a.length : a ? oe.error(e) : S(e, l).slice(0)
        }, a = oe.compile = function (e, t) {
            var n, i = [], o = [], r = $[e + " "];
            if (!r) {
                for (t || (t = s(e)), n = t.length; n--;) (r = we(t[n]))[w] ? i.push(r) : o.push(r);
                (r = $(e, xe(o, i))).selector = e
            }
            return r
        }, l = oe.select = function (e, t, o, r) {
            var l, c, d, u, p, f = "function" == typeof e && e, h = !r && s(e = f.selector || e);
            if (o = o || [], 1 === h.length) {
                if ((c = h[0] = h[0].slice(0)).length > 2 && "ID" === (d = c[0]).type && n.getById && 9 === t.nodeType && m && i.relative[c[1].type]) {
                    if (!(t = (i.find.ID(d.matches[0].replace(te, ne), t) || [])[0])) return o;
                    f && (t = t.parentNode), e = e.slice(c.shift().value.length)
                }
                for (l = X.needsContext.test(e) ? 0 : c.length; l-- && (d = c[l], !i.relative[u = d.type]);) if ((p = i.find[u]) && (r = p(d.matches[0].replace(te, ne), Z.test(c[0].type) && fe(t.parentNode) || t))) {
                    if (c.splice(l, 1), !(e = r.length && me(c))) return I.apply(o, r), o;
                    break
                }
            }
            return (f || a(e, h))(r, t, !m, o, !t || Z.test(e) && fe(t.parentNode) || t), o
        }, n.sortStable = w.split("").sort(_).join("") === w, n.detectDuplicates = !!u, p(), n.sortDetached = ae(function (e) {
            return 1 & e.compareDocumentPosition(f.createElement("div"))
        }), ae(function (e) {
            return e.innerHTML = "<a href='#'></a>", "#" === e.firstChild.getAttribute("href")
        }) || le("type|href|height|width", function (e, t, n) {
            return n ? void 0 : e.getAttribute(t, "type" === t.toLowerCase() ? 1 : 2)
        }), n.attributes && ae(function (e) {
            return e.innerHTML = "<input/>", e.firstChild.setAttribute("value", ""), "" === e.firstChild.getAttribute("value")
        }) || le("value", function (e, t, n) {
            return n || "input" !== e.nodeName.toLowerCase() ? void 0 : e.defaultValue
        }), ae(function (e) {
            return null == e.getAttribute("disabled")
        }) || le(P, function (e, t, n) {
            var i;
            return n ? void 0 : !0 === e[t] ? t.toLowerCase() : (i = e.getAttributeNode(t)) && i.specified ? i.value : null
        }), oe
    }(e);
    f.find = b, f.expr = b.selectors, f.expr[":"] = f.expr.pseudos, f.uniqueSort = f.unique = b.uniqueSort, f.text = b.getText, f.isXMLDoc = b.isXML, f.contains = b.contains;
    var w = function (e, t, n) {
        for (var i = [], o = void 0 !== n; (e = e[t]) && 9 !== e.nodeType;) if (1 === e.nodeType) {
            if (o && f(e).is(n)) break;
            i.push(e)
        }
        return i
    }, x = function (e, t) {
        for (var n = []; e; e = e.nextSibling) 1 === e.nodeType && e !== t && n.push(e);
        return n
    }, k = f.expr.match.needsContext, C = /^<([\w-]+)\s*\/?>(?:<\/\1>|)$/, T = /^.[^:#\[\.,]*$/;

    function S(e, t, n) {
        if (f.isFunction(t)) return f.grep(e, function (e, i) {
            return !!t.call(e, i, e) !== n
        });
        if (t.nodeType) return f.grep(e, function (e) {
            return e === t !== n
        });
        if ("string" == typeof t) {
            if (T.test(t)) return f.filter(t, e, n);
            t = f.filter(t, e)
        }
        return f.grep(e, function (e) {
            return a.call(t, e) > -1 !== n
        })
    }

    f.filter = function (e, t, n) {
        var i = t[0];
        return n && (e = ":not(" + e + ")"), 1 === t.length && 1 === i.nodeType ? f.find.matchesSelector(i, e) ? [i] : [] : f.find.matches(e, f.grep(t, function (e) {
            return 1 === e.nodeType
        }))
    }, f.fn.extend({
        find: function (e) {
            var t, n = this.length, i = [], o = this;
            if ("string" != typeof e) return this.pushStack(f(e).filter(function () {
                for (t = 0; n > t; t++) if (f.contains(o[t], this)) return !0
            }));
            for (t = 0; n > t; t++) f.find(e, o[t], i);
            return (i = this.pushStack(n > 1 ? f.unique(i) : i)).selector = this.selector ? this.selector + " " + e : e, i
        }, filter: function (e) {
            return this.pushStack(S(this, e || [], !1))
        }, not: function (e) {
            return this.pushStack(S(this, e || [], !0))
        }, is: function (e) {
            return !!S(this, "string" == typeof e && k.test(e) ? f(e) : e || [], !1).length
        }
    });
    var $, _ = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/;
    (f.fn.init = function (e, t, n) {
        var o, r;
        if (!e) return this;
        if (n = n || $, "string" == typeof e) {
            if (!(o = "<" === e[0] && ">" === e[e.length - 1] && e.length >= 3 ? [null, e, null] : _.exec(e)) || !o[1] && t) return !t || t.jquery ? (t || n).find(e) : this.constructor(t).find(e);
            if (o[1]) {
                if (t = t instanceof f ? t[0] : t, f.merge(this, f.parseHTML(o[1], t && t.nodeType ? t.ownerDocument || t : i, !0)), C.test(o[1]) && f.isPlainObject(t)) for (o in t) f.isFunction(this[o]) ? this[o](t[o]) : this.attr(o, t[o]);
                return this
            }
            return (r = i.getElementById(o[2])) && r.parentNode && (this.length = 1, this[0] = r), this.context = i, this.selector = e, this
        }
        return e.nodeType ? (this.context = this[0] = e, this.length = 1, this) : f.isFunction(e) ? void 0 !== n.ready ? n.ready(e) : e(f) : (void 0 !== e.selector && (this.selector = e.selector, this.context = e.context), f.makeArray(e, this))
    }).prototype = f.fn, $ = f(i);
    var E = /^(?:parents|prev(?:Until|All))/, A = {children: !0, contents: !0, next: !0, prev: !0};

    function O(e, t) {
        for (; (e = e[t]) && 1 !== e.nodeType;) ;
        return e
    }

    f.fn.extend({
        has: function (e) {
            var t = f(e, this), n = t.length;
            return this.filter(function () {
                for (var e = 0; n > e; e++) if (f.contains(this, t[e])) return !0
            })
        }, closest: function (e, t) {
            for (var n, i = 0, o = this.length, r = [], s = k.test(e) || "string" != typeof e ? f(e, t || this.context) : 0; o > i; i++) for (n = this[i]; n && n !== t; n = n.parentNode) if (n.nodeType < 11 && (s ? s.index(n) > -1 : 1 === n.nodeType && f.find.matchesSelector(n, e))) {
                r.push(n);
                break
            }
            return this.pushStack(r.length > 1 ? f.uniqueSort(r) : r)
        }, index: function (e) {
            return e ? "string" == typeof e ? a.call(f(e), this[0]) : a.call(this, e.jquery ? e[0] : e) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        }, add: function (e, t) {
            return this.pushStack(f.uniqueSort(f.merge(this.get(), f(e, t))))
        }, addBack: function (e) {
            return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
        }
    }), f.each({
        parent: function (e) {
            var t = e.parentNode;
            return t && 11 !== t.nodeType ? t : null
        }, parents: function (e) {
            return w(e, "parentNode")
        }, parentsUntil: function (e, t, n) {
            return w(e, "parentNode", n)
        }, next: function (e) {
            return O(e, "nextSibling")
        }, prev: function (e) {
            return O(e, "previousSibling")
        }, nextAll: function (e) {
            return w(e, "nextSibling")
        }, prevAll: function (e) {
            return w(e, "previousSibling")
        }, nextUntil: function (e, t, n) {
            return w(e, "nextSibling", n)
        }, prevUntil: function (e, t, n) {
            return w(e, "previousSibling", n)
        }, siblings: function (e) {
            return x((e.parentNode || {}).firstChild, e)
        }, children: function (e) {
            return x(e.firstChild)
        }, contents: function (e) {
            return e.contentDocument || f.merge([], e.childNodes)
        }
    }, function (e, t) {
        f.fn[e] = function (n, i) {
            var o = f.map(this, t, n);
            return "Until" !== e.slice(-5) && (i = n), i && "string" == typeof i && (o = f.filter(i, o)), this.length > 1 && (A[e] || f.uniqueSort(o), E.test(e) && o.reverse()), this.pushStack(o)
        }
    });
    var j, M = /\S+/g;

    function I() {
        i.removeEventListener("DOMContentLoaded", I), e.removeEventListener("load", I), f.ready()
    }

    f.Callbacks = function (e) {
        e = "string" == typeof e ? function (e) {
            var t = {};
            return f.each(e.match(M) || [], function (e, n) {
                t[n] = !0
            }), t
        }(e) : f.extend({}, e);
        var t, n, i, o, r = [], s = [], a = -1, l = function () {
            for (o = e.once, i = t = !0; s.length; a = -1) for (n = s.shift(); ++a < r.length;) !1 === r[a].apply(n[0], n[1]) && e.stopOnFalse && (a = r.length, n = !1);
            e.memory || (n = !1), t = !1, o && (r = n ? [] : "")
        }, c = {
            add: function () {
                return r && (n && !t && (a = r.length - 1, s.push(n)), function t(n) {
                    f.each(n, function (n, i) {
                        f.isFunction(i) ? e.unique && c.has(i) || r.push(i) : i && i.length && "string" !== f.type(i) && t(i)
                    })
                }(arguments), n && !t && l()), this
            }, remove: function () {
                return f.each(arguments, function (e, t) {
                    for (var n; (n = f.inArray(t, r, n)) > -1;) r.splice(n, 1), a >= n && a--
                }), this
            }, has: function (e) {
                return e ? f.inArray(e, r) > -1 : r.length > 0
            }, empty: function () {
                return r && (r = []), this
            }, disable: function () {
                return o = s = [], r = n = "", this
            }, disabled: function () {
                return !r
            }, lock: function () {
                return o = s = [], n || (r = n = ""), this
            }, locked: function () {
                return !!o
            }, fireWith: function (e, n) {
                return o || (n = [e, (n = n || []).slice ? n.slice() : n], s.push(n), t || l()), this
            }, fire: function () {
                return c.fireWith(this, arguments), this
            }, fired: function () {
                return !!i
            }
        };
        return c
    }, f.extend({
        Deferred: function (e) {
            var t = [["resolve", "done", f.Callbacks("once memory"), "resolved"], ["reject", "fail", f.Callbacks("once memory"), "rejected"], ["notify", "progress", f.Callbacks("memory")]],
                n = "pending", i = {
                    state: function () {
                        return n
                    }, always: function () {
                        return o.done(arguments).fail(arguments), this
                    }, then: function () {
                        var e = arguments;
                        return f.Deferred(function (n) {
                            f.each(t, function (t, r) {
                                var s = f.isFunction(e[t]) && e[t];
                                o[r[1]](function () {
                                    var e = s && s.apply(this, arguments);
                                    e && f.isFunction(e.promise) ? e.promise().progress(n.notify).done(n.resolve).fail(n.reject) : n[r[0] + "With"](this === i ? n.promise() : this, s ? [e] : arguments)
                                })
                            }), e = null
                        }).promise()
                    }, promise: function (e) {
                        return null != e ? f.extend(e, i) : i
                    }
                }, o = {};
            return i.pipe = i.then, f.each(t, function (e, r) {
                var s = r[2], a = r[3];
                i[r[1]] = s.add, a && s.add(function () {
                    n = a
                }, t[1 ^ e][2].disable, t[2][2].lock), o[r[0]] = function () {
                    return o[r[0] + "With"](this === o ? i : this, arguments), this
                }, o[r[0] + "With"] = s.fireWith
            }), i.promise(o), e && e.call(o, o), o
        }, when: function (e) {
            var t, n, i, r = 0, s = o.call(arguments), a = s.length,
                l = 1 !== a || e && f.isFunction(e.promise) ? a : 0, c = 1 === l ? e : f.Deferred(),
                d = function (e, n, i) {
                    return function (r) {
                        n[e] = this, i[e] = arguments.length > 1 ? o.call(arguments) : r, i === t ? c.notifyWith(n, i) : --l || c.resolveWith(n, i)
                    }
                };
            if (a > 1) for (t = new Array(a), n = new Array(a), i = new Array(a); a > r; r++) s[r] && f.isFunction(s[r].promise) ? s[r].promise().progress(d(r, n, t)).done(d(r, i, s)).fail(c.reject) : --l;
            return l || c.resolveWith(i, s), c.promise()
        }
    }), f.fn.ready = function (e) {
        return f.ready.promise().done(e), this
    }, f.extend({
        isReady: !1, readyWait: 1, holdReady: function (e) {
            e ? f.readyWait++ : f.ready(!0)
        }, ready: function (e) {
            (!0 === e ? --f.readyWait : f.isReady) || (f.isReady = !0, !0 !== e && --f.readyWait > 0 || (j.resolveWith(i, [f]), f.fn.triggerHandler && (f(i).triggerHandler("ready"), f(i).off("ready"))))
        }
    }), f.ready.promise = function (t) {
        return j || (j = f.Deferred(), "complete" === i.readyState || "loading" !== i.readyState && !i.documentElement.doScroll ? e.setTimeout(f.ready) : (i.addEventListener("DOMContentLoaded", I), e.addEventListener("load", I))), j.promise(t)
    }, f.ready.promise();
    var D = function (e, t, n, i, o, r, s) {
        var a = 0, l = e.length, c = null == n;
        if ("object" === f.type(n)) for (a in o = !0, n) D(e, t, a, n[a], !0, r, s); else if (void 0 !== i && (o = !0, f.isFunction(i) || (s = !0), c && (s ? (t.call(e, i), t = null) : (c = t, t = function (e, t, n) {
            return c.call(f(e), n)
        })), t)) for (; l > a; a++) t(e[a], n, s ? i : i.call(e[a], a, t(e[a], n)));
        return o ? e : c ? t.call(e) : l ? t(e[0], n) : r
    }, L = function (e) {
        return 1 === e.nodeType || 9 === e.nodeType || !+e.nodeType
    };

    function P() {
        this.expando = f.expando + P.uid++
    }

    P.uid = 1, P.prototype = {
        register: function (e, t) {
            var n = t || {};
            return e.nodeType ? e[this.expando] = n : Object.defineProperty(e, this.expando, {
                value: n,
                writable: !0,
                configurable: !0
            }), e[this.expando]
        }, cache: function (e) {
            if (!L(e)) return {};
            var t = e[this.expando];
            return t || (t = {}, L(e) && (e.nodeType ? e[this.expando] = t : Object.defineProperty(e, this.expando, {
                value: t,
                configurable: !0
            }))), t
        }, set: function (e, t, n) {
            var i, o = this.cache(e);
            if ("string" == typeof t) o[t] = n; else for (i in t) o[i] = t[i];
            return o
        }, get: function (e, t) {
            return void 0 === t ? this.cache(e) : e[this.expando] && e[this.expando][t]
        }, access: function (e, t, n) {
            var i;
            return void 0 === t || t && "string" == typeof t && void 0 === n ? void 0 !== (i = this.get(e, t)) ? i : this.get(e, f.camelCase(t)) : (this.set(e, t, n), void 0 !== n ? n : t)
        }, remove: function (e, t) {
            var n, i, o, r = e[this.expando];
            if (void 0 !== r) {
                if (void 0 === t) this.register(e); else {
                    f.isArray(t) ? i = t.concat(t.map(f.camelCase)) : (o = f.camelCase(t), t in r ? i = [t, o] : i = (i = o) in r ? [i] : i.match(M) || []), n = i.length;
                    for (; n--;) delete r[i[n]]
                }
                (void 0 === t || f.isEmptyObject(r)) && (e.nodeType ? e[this.expando] = void 0 : delete e[this.expando])
            }
        }, hasData: function (e) {
            var t = e[this.expando];
            return void 0 !== t && !f.isEmptyObject(t)
        }
    };
    var z = new P, N = new P, F = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/, H = /[A-Z]/g;

    function q(e, t, n) {
        var i;
        if (void 0 === n && 1 === e.nodeType) if (i = "data-" + t.replace(H, "-$&").toLowerCase(), "string" == typeof (n = e.getAttribute(i))) {
            try {
                n = "true" === n || "false" !== n && ("null" === n ? null : +n + "" === n ? +n : F.test(n) ? f.parseJSON(n) : n)
            } catch (e) {
            }
            N.set(e, t, n)
        } else n = void 0;
        return n
    }

    f.extend({
        hasData: function (e) {
            return N.hasData(e) || z.hasData(e)
        }, data: function (e, t, n) {
            return N.access(e, t, n)
        }, removeData: function (e, t) {
            N.remove(e, t)
        }, _data: function (e, t, n) {
            return z.access(e, t, n)
        }, _removeData: function (e, t) {
            z.remove(e, t)
        }
    }), f.fn.extend({
        data: function (e, t) {
            var n, i, o, r = this[0], s = r && r.attributes;
            if (void 0 === e) {
                if (this.length && (o = N.get(r), 1 === r.nodeType && !z.get(r, "hasDataAttrs"))) {
                    for (n = s.length; n--;) s[n] && (0 === (i = s[n].name).indexOf("data-") && (i = f.camelCase(i.slice(5)), q(r, i, o[i])));
                    z.set(r, "hasDataAttrs", !0)
                }
                return o
            }
            return "object" == typeof e ? this.each(function () {
                N.set(this, e)
            }) : D(this, function (t) {
                var n, i;
                if (r && void 0 === t) {
                    if (void 0 !== (n = N.get(r, e) || N.get(r, e.replace(H, "-$&").toLowerCase()))) return n;
                    if (i = f.camelCase(e), void 0 !== (n = N.get(r, i))) return n;
                    if (void 0 !== (n = q(r, i, void 0))) return n
                } else i = f.camelCase(e), this.each(function () {
                    var n = N.get(this, i);
                    N.set(this, i, t), e.indexOf("-") > -1 && void 0 !== n && N.set(this, e, t)
                })
            }, null, t, arguments.length > 1, null, !0)
        }, removeData: function (e) {
            return this.each(function () {
                N.remove(this, e)
            })
        }
    }), f.extend({
        queue: function (e, t, n) {
            var i;
            return e ? (t = (t || "fx") + "queue", i = z.get(e, t), n && (!i || f.isArray(n) ? i = z.access(e, t, f.makeArray(n)) : i.push(n)), i || []) : void 0
        }, dequeue: function (e, t) {
            t = t || "fx";
            var n = f.queue(e, t), i = n.length, o = n.shift(), r = f._queueHooks(e, t);
            "inprogress" === o && (o = n.shift(), i--), o && ("fx" === t && n.unshift("inprogress"), delete r.stop, o.call(e, function () {
                f.dequeue(e, t)
            }, r)), !i && r && r.empty.fire()
        }, _queueHooks: function (e, t) {
            var n = t + "queueHooks";
            return z.get(e, n) || z.access(e, n, {
                empty: f.Callbacks("once memory").add(function () {
                    z.remove(e, [t + "queue", n])
                })
            })
        }
    }), f.fn.extend({
        queue: function (e, t) {
            var n = 2;
            return "string" != typeof e && (t = e, e = "fx", n--), arguments.length < n ? f.queue(this[0], e) : void 0 === t ? this : this.each(function () {
                var n = f.queue(this, e, t);
                f._queueHooks(this, e), "fx" === e && "inprogress" !== n[0] && f.dequeue(this, e)
            })
        }, dequeue: function (e) {
            return this.each(function () {
                f.dequeue(this, e)
            })
        }, clearQueue: function (e) {
            return this.queue(e || "fx", [])
        }, promise: function (e, t) {
            var n, i = 1, o = f.Deferred(), r = this, s = this.length, a = function () {
                --i || o.resolveWith(r, [r])
            };
            for ("string" != typeof e && (t = e, e = void 0), e = e || "fx"; s--;) (n = z.get(r[s], e + "queueHooks")) && n.empty && (i++, n.empty.add(a));
            return a(), o.promise(t)
        }
    });
    var R = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source, W = new RegExp("^(?:([+-])=|)(" + R + ")([a-z%]*)$", "i"),
        B = ["Top", "Right", "Bottom", "Left"], U = function (e, t) {
            return e = t || e, "none" === f.css(e, "display") || !f.contains(e.ownerDocument, e)
        };

    function Y(e, t, n, i) {
        var o, r = 1, s = 20, a = i ? function () {
                return i.cur()
            } : function () {
                return f.css(e, t, "")
            }, l = a(), c = n && n[3] || (f.cssNumber[t] ? "" : "px"),
            d = (f.cssNumber[t] || "px" !== c && +l) && W.exec(f.css(e, t));
        if (d && d[3] !== c) {
            c = c || d[3], n = n || [], d = +l || 1;
            do {
                d /= r = r || ".5", f.style(e, t, d + c)
            } while (r !== (r = a() / l) && 1 !== r && --s)
        }
        return n && (d = +d || +l || 0, o = n[1] ? d + (n[1] + 1) * n[2] : +n[2], i && (i.unit = c, i.start = d, i.end = o)), o
    }

    var V = /^(?:checkbox|radio)$/i, X = /<([\w:-]+)/, J = /^$|\/(?:java|ecma)script/i, G = {
        option: [1, "<select multiple='multiple'>", "</select>"],
        thead: [1, "<table>", "</table>"],
        col: [2, "<table><colgroup>", "</colgroup></table>"],
        tr: [2, "<table><tbody>", "</tbody></table>"],
        td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
        _default: [0, "", ""]
    };

    function Q(e, t) {
        var n = void 0 !== e.getElementsByTagName ? e.getElementsByTagName(t || "*") : void 0 !== e.querySelectorAll ? e.querySelectorAll(t || "*") : [];
        return void 0 === t || t && f.nodeName(e, t) ? f.merge([e], n) : n
    }

    function K(e, t) {
        for (var n = 0, i = e.length; i > n; n++) z.set(e[n], "globalEval", !t || z.get(t[n], "globalEval"))
    }

    G.optgroup = G.option, G.tbody = G.tfoot = G.colgroup = G.caption = G.thead, G.th = G.td;
    var Z = /<|&#?\w+;/;

    function ee(e, t, n, i, o) {
        for (var r, s, a, l, c, d, u = t.createDocumentFragment(), p = [], h = 0, m = e.length; m > h; h++) if ((r = e[h]) || 0 === r) if ("object" === f.type(r)) f.merge(p, r.nodeType ? [r] : r); else if (Z.test(r)) {
            for (s = s || u.appendChild(t.createElement("div")), a = (X.exec(r) || ["", ""])[1].toLowerCase(), l = G[a] || G._default, s.innerHTML = l[1] + f.htmlPrefilter(r) + l[2], d = l[0]; d--;) s = s.lastChild;
            f.merge(p, s.childNodes), (s = u.firstChild).textContent = ""
        } else p.push(t.createTextNode(r));
        for (u.textContent = "", h = 0; r = p[h++];) if (i && f.inArray(r, i) > -1) o && o.push(r); else if (c = f.contains(r.ownerDocument, r), s = Q(u.appendChild(r), "script"), c && K(s), n) for (d = 0; r = s[d++];) J.test(r.type || "") && n.push(r);
        return u
    }

    !function () {
        var e = i.createDocumentFragment().appendChild(i.createElement("div")), t = i.createElement("input");
        t.setAttribute("type", "radio"), t.setAttribute("checked", "checked"), t.setAttribute("name", "t"), e.appendChild(t), u.checkClone = e.cloneNode(!0).cloneNode(!0).lastChild.checked, e.innerHTML = "<textarea>x</textarea>", u.noCloneChecked = !!e.cloneNode(!0).lastChild.defaultValue
    }();
    var te = /^key/, ne = /^(?:mouse|pointer|contextmenu|drag|drop)|click/, ie = /^([^.]*)(?:\.(.+)|)/;

    function oe() {
        return !0
    }

    function re() {
        return !1
    }

    function se() {
        try {
            return i.activeElement
        } catch (e) {
        }
    }

    function ae(e, t, n, i, o, r) {
        var s, a;
        if ("object" == typeof t) {
            for (a in "string" != typeof n && (i = i || n, n = void 0), t) ae(e, a, n, i, t[a], r);
            return e
        }
        if (null == i && null == o ? (o = n, i = n = void 0) : null == o && ("string" == typeof n ? (o = i, i = void 0) : (o = i, i = n, n = void 0)), !1 === o) o = re; else if (!o) return this;
        return 1 === r && (s = o, (o = function (e) {
            return f().off(e), s.apply(this, arguments)
        }).guid = s.guid || (s.guid = f.guid++)), e.each(function () {
            f.event.add(this, t, o, i, n)
        })
    }

    f.event = {
        global: {},
        add: function (e, t, n, i, o) {
            var r, s, a, l, c, d, u, p, h, m, v, g = z.get(e);
            if (g) for (n.handler && (n = (r = n).handler, o = r.selector), n.guid || (n.guid = f.guid++), (l = g.events) || (l = g.events = {}), (s = g.handle) || (s = g.handle = function (t) {
                return void 0 !== f && f.event.triggered !== t.type ? f.event.dispatch.apply(e, arguments) : void 0
            }), c = (t = (t || "").match(M) || [""]).length; c--;) h = v = (a = ie.exec(t[c]) || [])[1], m = (a[2] || "").split(".").sort(), h && (u = f.event.special[h] || {}, h = (o ? u.delegateType : u.bindType) || h, u = f.event.special[h] || {}, d = f.extend({
                type: h,
                origType: v,
                data: i,
                handler: n,
                guid: n.guid,
                selector: o,
                needsContext: o && f.expr.match.needsContext.test(o),
                namespace: m.join(".")
            }, r), (p = l[h]) || ((p = l[h] = []).delegateCount = 0, u.setup && !1 !== u.setup.call(e, i, m, s) || e.addEventListener && e.addEventListener(h, s)), u.add && (u.add.call(e, d), d.handler.guid || (d.handler.guid = n.guid)), o ? p.splice(p.delegateCount++, 0, d) : p.push(d), f.event.global[h] = !0)
        },
        remove: function (e, t, n, i, o) {
            var r, s, a, l, c, d, u, p, h, m, v, g = z.hasData(e) && z.get(e);
            if (g && (l = g.events)) {
                for (c = (t = (t || "").match(M) || [""]).length; c--;) if (h = v = (a = ie.exec(t[c]) || [])[1], m = (a[2] || "").split(".").sort(), h) {
                    for (u = f.event.special[h] || {}, p = l[h = (i ? u.delegateType : u.bindType) || h] || [], a = a[2] && new RegExp("(^|\\.)" + m.join("\\.(?:.*\\.|)") + "(\\.|$)"), s = r = p.length; r--;) d = p[r], !o && v !== d.origType || n && n.guid !== d.guid || a && !a.test(d.namespace) || i && i !== d.selector && ("**" !== i || !d.selector) || (p.splice(r, 1), d.selector && p.delegateCount--, u.remove && u.remove.call(e, d));
                    s && !p.length && (u.teardown && !1 !== u.teardown.call(e, m, g.handle) || f.removeEvent(e, h, g.handle), delete l[h])
                } else for (h in l) f.event.remove(e, h + t[c], n, i, !0);
                f.isEmptyObject(l) && z.remove(e, "handle events")
            }
        },
        dispatch: function (e) {
            e = f.event.fix(e);
            var t, n, i, r, s, a = [], l = o.call(arguments), c = (z.get(this, "events") || {})[e.type] || [],
                d = f.event.special[e.type] || {};
            if (l[0] = e, e.delegateTarget = this, !d.preDispatch || !1 !== d.preDispatch.call(this, e)) {
                for (a = f.event.handlers.call(this, e, c), t = 0; (r = a[t++]) && !e.isPropagationStopped();) for (e.currentTarget = r.elem, n = 0; (s = r.handlers[n++]) && !e.isImmediatePropagationStopped();) (!e.rnamespace || e.rnamespace.test(s.namespace)) && (e.handleObj = s, e.data = s.data, void 0 !== (i = ((f.event.special[s.origType] || {}).handle || s.handler).apply(r.elem, l)) && !1 === (e.result = i) && (e.preventDefault(), e.stopPropagation()));
                return d.postDispatch && d.postDispatch.call(this, e), e.result
            }
        },
        handlers: function (e, t) {
            var n, i, o, r, s = [], a = t.delegateCount, l = e.target;
            if (a && l.nodeType && ("click" !== e.type || isNaN(e.button) || e.button < 1)) for (; l !== this; l = l.parentNode || this) if (1 === l.nodeType && (!0 !== l.disabled || "click" !== e.type)) {
                for (i = [], n = 0; a > n; n++) void 0 === i[o = (r = t[n]).selector + " "] && (i[o] = r.needsContext ? f(o, this).index(l) > -1 : f.find(o, this, null, [l]).length), i[o] && i.push(r);
                i.length && s.push({elem: l, handlers: i})
            }
            return a < t.length && s.push({elem: this, handlers: t.slice(a)}), s
        },
        props: "altKey bubbles cancelable ctrlKey currentTarget detail eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
        fixHooks: {},
        keyHooks: {
            props: "char charCode key keyCode".split(" "), filter: function (e, t) {
                return null == e.which && (e.which = null != t.charCode ? t.charCode : t.keyCode), e
            }
        },
        mouseHooks: {
            props: "button buttons clientX clientY offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
            filter: function (e, t) {
                var n, o, r, s = t.button;
                return null == e.pageX && null != t.clientX && (o = (n = e.target.ownerDocument || i).documentElement, r = n.body, e.pageX = t.clientX + (o && o.scrollLeft || r && r.scrollLeft || 0) - (o && o.clientLeft || r && r.clientLeft || 0), e.pageY = t.clientY + (o && o.scrollTop || r && r.scrollTop || 0) - (o && o.clientTop || r && r.clientTop || 0)), e.which || void 0 === s || (e.which = 1 & s ? 1 : 2 & s ? 3 : 4 & s ? 2 : 0), e
            }
        },
        fix: function (e) {
            if (e[f.expando]) return e;
            var t, n, o, r = e.type, s = e, a = this.fixHooks[r];
            for (a || (this.fixHooks[r] = a = ne.test(r) ? this.mouseHooks : te.test(r) ? this.keyHooks : {}), o = a.props ? this.props.concat(a.props) : this.props, e = new f.Event(s), t = o.length; t--;) e[n = o[t]] = s[n];
            return e.target || (e.target = i), 3 === e.target.nodeType && (e.target = e.target.parentNode), a.filter ? a.filter(e, s) : e
        },
        special: {
            load: {noBubble: !0}, focus: {
                trigger: function () {
                    return this !== se() && this.focus ? (this.focus(), !1) : void 0
                }, delegateType: "focusin"
            }, blur: {
                trigger: function () {
                    return this === se() && this.blur ? (this.blur(), !1) : void 0
                }, delegateType: "focusout"
            }, click: {
                trigger: function () {
                    return "checkbox" === this.type && this.click && f.nodeName(this, "input") ? (this.click(), !1) : void 0
                }, _default: function (e) {
                    return f.nodeName(e.target, "a")
                }
            }, beforeunload: {
                postDispatch: function (e) {
                    void 0 !== e.result && e.originalEvent && (e.originalEvent.returnValue = e.result)
                }
            }
        }
    }, f.removeEvent = function (e, t, n) {
        e.removeEventListener && e.removeEventListener(t, n)
    }, f.Event = function (e, t) {
        return this instanceof f.Event ? (e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || void 0 === e.defaultPrevented && !1 === e.returnValue ? oe : re) : this.type = e, t && f.extend(this, t), this.timeStamp = e && e.timeStamp || f.now(), void (this[f.expando] = !0)) : new f.Event(e, t)
    }, f.Event.prototype = {
        constructor: f.Event,
        isDefaultPrevented: re,
        isPropagationStopped: re,
        isImmediatePropagationStopped: re,
        preventDefault: function () {
            var e = this.originalEvent;
            this.isDefaultPrevented = oe, e && e.preventDefault()
        },
        stopPropagation: function () {
            var e = this.originalEvent;
            this.isPropagationStopped = oe, e && e.stopPropagation()
        },
        stopImmediatePropagation: function () {
            var e = this.originalEvent;
            this.isImmediatePropagationStopped = oe, e && e.stopImmediatePropagation(), this.stopPropagation()
        }
    }, f.each({
        mouseenter: "mouseover",
        mouseleave: "mouseout",
        pointerenter: "pointerover",
        pointerleave: "pointerout"
    }, function (e, t) {
        f.event.special[e] = {
            delegateType: t, bindType: t, handle: function (e) {
                var n, i = e.relatedTarget, o = e.handleObj;
                return (!i || i !== this && !f.contains(this, i)) && (e.type = o.origType, n = o.handler.apply(this, arguments), e.type = t), n
            }
        }
    }), f.fn.extend({
        on: function (e, t, n, i) {
            return ae(this, e, t, n, i)
        }, one: function (e, t, n, i) {
            return ae(this, e, t, n, i, 1)
        }, off: function (e, t, n) {
            var i, o;
            if (e && e.preventDefault && e.handleObj) return i = e.handleObj, f(e.delegateTarget).off(i.namespace ? i.origType + "." + i.namespace : i.origType, i.selector, i.handler), this;
            if ("object" == typeof e) {
                for (o in e) this.off(o, t, e[o]);
                return this
            }
            return (!1 === t || "function" == typeof t) && (n = t, t = void 0), !1 === n && (n = re), this.each(function () {
                f.event.remove(this, e, n, t)
            })
        }
    });
    var le = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:-]+)[^>]*)\/>/gi, ce = /<script|<style|<link/i,
        de = /checked\s*(?:[^=]|=\s*.checked.)/i, ue = /^true\/(.*)/, pe = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;

    function fe(e, t) {
        return f.nodeName(e, "table") && f.nodeName(11 !== t.nodeType ? t : t.firstChild, "tr") && e.getElementsByTagName("tbody")[0] || e
    }

    function he(e) {
        return e.type = (null !== e.getAttribute("type")) + "/" + e.type, e
    }

    function me(e) {
        var t = ue.exec(e.type);
        return t ? e.type = t[1] : e.removeAttribute("type"), e
    }

    function ve(e, t) {
        var n, i, o, r, s, a, l, c;
        if (1 === t.nodeType) {
            if (z.hasData(e) && (r = z.access(e), s = z.set(t, r), c = r.events)) for (o in delete s.handle, s.events = {}, c) for (n = 0, i = c[o].length; i > n; n++) f.event.add(t, o, c[o][n]);
            N.hasData(e) && (a = N.access(e), l = f.extend({}, a), N.set(t, l))
        }
    }

    function ge(e, t) {
        var n = t.nodeName.toLowerCase();
        "input" === n && V.test(e.type) ? t.checked = e.checked : ("input" === n || "textarea" === n) && (t.defaultValue = e.defaultValue)
    }

    function ye(e, t, n, i) {
        t = r.apply([], t);
        var o, s, a, l, c, d, p = 0, h = e.length, m = h - 1, v = t[0], g = f.isFunction(v);
        if (g || h > 1 && "string" == typeof v && !u.checkClone && de.test(v)) return e.each(function (o) {
            var r = e.eq(o);
            g && (t[0] = v.call(this, o, r.html())), ye(r, t, n, i)
        });
        if (h && (s = (o = ee(t, e[0].ownerDocument, !1, e, i)).firstChild, 1 === o.childNodes.length && (o = s), s || i)) {
            for (l = (a = f.map(Q(o, "script"), he)).length; h > p; p++) c = o, p !== m && (c = f.clone(c, !0, !0), l && f.merge(a, Q(c, "script"))), n.call(e[p], c, p);
            if (l) for (d = a[a.length - 1].ownerDocument, f.map(a, me), p = 0; l > p; p++) c = a[p], J.test(c.type || "") && !z.access(c, "globalEval") && f.contains(d, c) && (c.src ? f._evalUrl && f._evalUrl(c.src) : f.globalEval(c.textContent.replace(pe, "")))
        }
        return e
    }

    function be(e, t, n) {
        for (var i, o = t ? f.filter(t, e) : e, r = 0; null != (i = o[r]); r++) n || 1 !== i.nodeType || f.cleanData(Q(i)), i.parentNode && (n && f.contains(i.ownerDocument, i) && K(Q(i, "script")), i.parentNode.removeChild(i));
        return e
    }

    f.extend({
        htmlPrefilter: function (e) {
            return e.replace(le, "<$1></$2>")
        }, clone: function (e, t, n) {
            var i, o, r, s, a = e.cloneNode(!0), l = f.contains(e.ownerDocument, e);
            if (!(u.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || f.isXMLDoc(e))) for (s = Q(a), i = 0, o = (r = Q(e)).length; o > i; i++) ge(r[i], s[i]);
            if (t) if (n) for (r = r || Q(e), s = s || Q(a), i = 0, o = r.length; o > i; i++) ve(r[i], s[i]); else ve(e, a);
            return (s = Q(a, "script")).length > 0 && K(s, !l && Q(e, "script")), a
        }, cleanData: function (e) {
            for (var t, n, i, o = f.event.special, r = 0; void 0 !== (n = e[r]); r++) if (L(n)) {
                if (t = n[z.expando]) {
                    if (t.events) for (i in t.events) o[i] ? f.event.remove(n, i) : f.removeEvent(n, i, t.handle);
                    n[z.expando] = void 0
                }
                n[N.expando] && (n[N.expando] = void 0)
            }
        }
    }), f.fn.extend({
        domManip: ye, detach: function (e) {
            return be(this, e, !0)
        }, remove: function (e) {
            return be(this, e)
        }, text: function (e) {
            return D(this, function (e) {
                return void 0 === e ? f.text(this) : this.empty().each(function () {
                    (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) && (this.textContent = e)
                })
            }, null, e, arguments.length)
        }, append: function () {
            return ye(this, arguments, function (e) {
                1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || fe(this, e).appendChild(e)
            })
        }, prepend: function () {
            return ye(this, arguments, function (e) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    var t = fe(this, e);
                    t.insertBefore(e, t.firstChild)
                }
            })
        }, before: function () {
            return ye(this, arguments, function (e) {
                this.parentNode && this.parentNode.insertBefore(e, this)
            })
        }, after: function () {
            return ye(this, arguments, function (e) {
                this.parentNode && this.parentNode.insertBefore(e, this.nextSibling)
            })
        }, empty: function () {
            for (var e, t = 0; null != (e = this[t]); t++) 1 === e.nodeType && (f.cleanData(Q(e, !1)), e.textContent = "");
            return this
        }, clone: function (e, t) {
            return e = null != e && e, t = null == t ? e : t, this.map(function () {
                return f.clone(this, e, t)
            })
        }, html: function (e) {
            return D(this, function (e) {
                var t = this[0] || {}, n = 0, i = this.length;
                if (void 0 === e && 1 === t.nodeType) return t.innerHTML;
                if ("string" == typeof e && !ce.test(e) && !G[(X.exec(e) || ["", ""])[1].toLowerCase()]) {
                    e = f.htmlPrefilter(e);
                    try {
                        for (; i > n; n++) 1 === (t = this[n] || {}).nodeType && (f.cleanData(Q(t, !1)), t.innerHTML = e);
                        t = 0
                    } catch (e) {
                    }
                }
                t && this.empty().append(e)
            }, null, e, arguments.length)
        }, replaceWith: function () {
            var e = [];
            return ye(this, arguments, function (t) {
                var n = this.parentNode;
                f.inArray(this, e) < 0 && (f.cleanData(Q(this)), n && n.replaceChild(t, this))
            }, e)
        }
    }), f.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function (e, t) {
        f.fn[e] = function (e) {
            for (var n, i = [], o = f(e), r = o.length - 1, a = 0; r >= a; a++) n = a === r ? this : this.clone(!0), f(o[a])[t](n), s.apply(i, n.get());
            return this.pushStack(i)
        }
    });
    var we, xe = {HTML: "block", BODY: "block"};

    function ke(e, t) {
        var n = f(t.createElement(e)).appendTo(t.body), i = f.css(n[0], "display");
        return n.detach(), i
    }

    function Ce(e) {
        var t = i, n = xe[e];
        return n || ("none" !== (n = ke(e, t)) && n || ((t = (we = (we || f("<iframe frameborder='0' width='0' height='0'/>")).appendTo(t.documentElement))[0].contentDocument).write(), t.close(), n = ke(e, t), we.detach()), xe[e] = n), n
    }

    var Te = /^margin/, Se = new RegExp("^(" + R + ")(?!px)[a-z%]+$", "i"), $e = function (t) {
        var n = t.ownerDocument.defaultView;
        return n.opener || (n = e), n.getComputedStyle(t)
    }, _e = function (e, t, n, i) {
        var o, r, s = {};
        for (r in t) s[r] = e.style[r], e.style[r] = t[r];
        for (r in o = n.apply(e, i || []), t) e.style[r] = s[r];
        return o
    }, Ee = i.documentElement;

    function Ae(e, t, n) {
        var i, o, r, s, a = e.style;
        return (n = n || $e(e)) && ("" !== (s = n.getPropertyValue(t) || n[t]) || f.contains(e.ownerDocument, e) || (s = f.style(e, t)), !u.pixelMarginRight() && Se.test(s) && Te.test(t) && (i = a.width, o = a.minWidth, r = a.maxWidth, a.minWidth = a.maxWidth = a.width = s, s = n.width, a.width = i, a.minWidth = o, a.maxWidth = r)), void 0 !== s ? s + "" : s
    }

    function Oe(e, t) {
        return {
            get: function () {
                return e() ? void delete this.get : (this.get = t).apply(this, arguments)
            }
        }
    }

    !function () {
        var t, n, o, r, s = i.createElement("div"), a = i.createElement("div");
        if (a.style) {
            function l() {
                a.style.cssText = "-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:relative;display:block;margin:auto;border:1px;padding:1px;top:1%;width:50%", a.innerHTML = "", Ee.appendChild(s);
                var i = e.getComputedStyle(a);
                t = "1%" !== i.top, r = "2px" === i.marginLeft, n = "4px" === i.width, a.style.marginRight = "50%", o = "4px" === i.marginRight, Ee.removeChild(s)
            }

            a.style.backgroundClip = "content-box", a.cloneNode(!0).style.backgroundClip = "", u.clearCloneStyle = "content-box" === a.style.backgroundClip, s.style.cssText = "border:0;width:8px;height:0;top:0;left:-9999px;padding:0;margin-top:1px;position:absolute", s.appendChild(a), f.extend(u, {
                pixelPosition: function () {
                    return l(), t
                }, boxSizingReliable: function () {
                    return null == n && l(), n
                }, pixelMarginRight: function () {
                    return null == n && l(), o
                }, reliableMarginLeft: function () {
                    return null == n && l(), r
                }, reliableMarginRight: function () {
                    var t, n = a.appendChild(i.createElement("div"));
                    return n.style.cssText = a.style.cssText = "-webkit-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:0", n.style.marginRight = n.style.width = "0", a.style.width = "1px", Ee.appendChild(s), t = !parseFloat(e.getComputedStyle(n).marginRight), Ee.removeChild(s), a.removeChild(n), t
                }
            })
        }
    }();
    var je = /^(none|table(?!-c[ea]).+)/, Me = {position: "absolute", visibility: "hidden", display: "block"},
        Ie = {letterSpacing: "0", fontWeight: "400"}, De = ["Webkit", "O", "Moz", "ms"],
        Le = i.createElement("div").style;

    function Pe(e) {
        if (e in Le) return e;
        for (var t = e[0].toUpperCase() + e.slice(1), n = De.length; n--;) if ((e = De[n] + t) in Le) return e
    }

    function ze(e, t, n) {
        var i = W.exec(t);
        return i ? Math.max(0, i[2] - (n || 0)) + (i[3] || "px") : t
    }

    function Ne(e, t, n, i, o) {
        for (var r = n === (i ? "border" : "content") ? 4 : "width" === t ? 1 : 0, s = 0; 4 > r; r += 2) "margin" === n && (s += f.css(e, n + B[r], !0, o)), i ? ("content" === n && (s -= f.css(e, "padding" + B[r], !0, o)), "margin" !== n && (s -= f.css(e, "border" + B[r] + "Width", !0, o))) : (s += f.css(e, "padding" + B[r], !0, o), "padding" !== n && (s += f.css(e, "border" + B[r] + "Width", !0, o)));
        return s
    }

    function Fe(t, n, o) {
        var r = !0, s = "width" === n ? t.offsetWidth : t.offsetHeight, a = $e(t),
            l = "border-box" === f.css(t, "boxSizing", !1, a);
        if (i.msFullscreenElement && e.top !== e && t.getClientRects().length && (s = Math.round(100 * t.getBoundingClientRect()[n])), 0 >= s || null == s) {
            if ((0 > (s = Ae(t, n, a)) || null == s) && (s = t.style[n]), Se.test(s)) return s;
            r = l && (u.boxSizingReliable() || s === t.style[n]), s = parseFloat(s) || 0
        }
        return s + Ne(t, n, o || (l ? "border" : "content"), r, a) + "px"
    }

    function He(e, t) {
        for (var n, i, o, r = [], s = 0, a = e.length; a > s; s++) (i = e[s]).style && (r[s] = z.get(i, "olddisplay"), n = i.style.display, t ? (r[s] || "none" !== n || (i.style.display = ""), "" === i.style.display && U(i) && (r[s] = z.access(i, "olddisplay", Ce(i.nodeName)))) : (o = U(i), "none" === n && o || z.set(i, "olddisplay", o ? n : f.css(i, "display"))));
        for (s = 0; a > s; s++) (i = e[s]).style && (t && "none" !== i.style.display && "" !== i.style.display || (i.style.display = t ? r[s] || "" : "none"));
        return e
    }

    function qe(e, t, n, i, o) {
        return new qe.prototype.init(e, t, n, i, o)
    }

    f.extend({
        cssHooks: {
            opacity: {
                get: function (e, t) {
                    if (t) {
                        var n = Ae(e, "opacity");
                        return "" === n ? "1" : n
                    }
                }
            }
        },
        cssNumber: {
            animationIterationCount: !0,
            columnCount: !0,
            fillOpacity: !0,
            flexGrow: !0,
            flexShrink: !0,
            fontWeight: !0,
            lineHeight: !0,
            opacity: !0,
            order: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0
        },
        cssProps: {float: "cssFloat"},
        style: function (e, t, n, i) {
            if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
                var o, r, s, a = f.camelCase(t), l = e.style;
                return t = f.cssProps[a] || (f.cssProps[a] = Pe(a) || a), s = f.cssHooks[t] || f.cssHooks[a], void 0 === n ? s && "get" in s && void 0 !== (o = s.get(e, !1, i)) ? o : l[t] : ("string" === (r = typeof n) && (o = W.exec(n)) && o[1] && (n = Y(e, t, o), r = "number"), void (null != n && n == n && ("number" === r && (n += o && o[3] || (f.cssNumber[a] ? "" : "px")), u.clearCloneStyle || "" !== n || 0 !== t.indexOf("background") || (l[t] = "inherit"), s && "set" in s && void 0 === (n = s.set(e, n, i)) || (l[t] = n))))
            }
        },
        css: function (e, t, n, i) {
            var o, r, s, a = f.camelCase(t);
            return t = f.cssProps[a] || (f.cssProps[a] = Pe(a) || a), (s = f.cssHooks[t] || f.cssHooks[a]) && "get" in s && (o = s.get(e, !0, n)), void 0 === o && (o = Ae(e, t, i)), "normal" === o && t in Ie && (o = Ie[t]), "" === n || n ? (r = parseFloat(o), !0 === n || isFinite(r) ? r || 0 : o) : o
        }
    }), f.each(["height", "width"], function (e, t) {
        f.cssHooks[t] = {
            get: function (e, n, i) {
                return n ? je.test(f.css(e, "display")) && 0 === e.offsetWidth ? _e(e, Me, function () {
                    return Fe(e, t, i)
                }) : Fe(e, t, i) : void 0
            }, set: function (e, n, i) {
                var o, r = i && $e(e), s = i && Ne(e, t, i, "border-box" === f.css(e, "boxSizing", !1, r), r);
                return s && (o = W.exec(n)) && "px" !== (o[3] || "px") && (e.style[t] = n, n = f.css(e, t)), ze(0, n, s)
            }
        }
    }), f.cssHooks.marginLeft = Oe(u.reliableMarginLeft, function (e, t) {
        return t ? (parseFloat(Ae(e, "marginLeft")) || e.getBoundingClientRect().left - _e(e, {marginLeft: 0}, function () {
            return e.getBoundingClientRect().left
        })) + "px" : void 0
    }), f.cssHooks.marginRight = Oe(u.reliableMarginRight, function (e, t) {
        return t ? _e(e, {display: "inline-block"}, Ae, [e, "marginRight"]) : void 0
    }), f.each({margin: "", padding: "", border: "Width"}, function (e, t) {
        f.cssHooks[e + t] = {
            expand: function (n) {
                for (var i = 0, o = {}, r = "string" == typeof n ? n.split(" ") : [n]; 4 > i; i++) o[e + B[i] + t] = r[i] || r[i - 2] || r[0];
                return o
            }
        }, Te.test(e) || (f.cssHooks[e + t].set = ze)
    }), f.fn.extend({
        css: function (e, t) {
            return D(this, function (e, t, n) {
                var i, o, r = {}, s = 0;
                if (f.isArray(t)) {
                    for (i = $e(e), o = t.length; o > s; s++) r[t[s]] = f.css(e, t[s], !1, i);
                    return r
                }
                return void 0 !== n ? f.style(e, t, n) : f.css(e, t)
            }, e, t, arguments.length > 1)
        }, show: function () {
            return He(this, !0)
        }, hide: function () {
            return He(this)
        }, toggle: function (e) {
            return "boolean" == typeof e ? e ? this.show() : this.hide() : this.each(function () {
                U(this) ? f(this).show() : f(this).hide()
            })
        }
    }), f.Tween = qe, qe.prototype = {
        constructor: qe, init: function (e, t, n, i, o, r) {
            this.elem = e, this.prop = n, this.easing = o || f.easing._default, this.options = t, this.start = this.now = this.cur(), this.end = i, this.unit = r || (f.cssNumber[n] ? "" : "px")
        }, cur: function () {
            var e = qe.propHooks[this.prop];
            return e && e.get ? e.get(this) : qe.propHooks._default.get(this)
        }, run: function (e) {
            var t, n = qe.propHooks[this.prop];
            return this.options.duration ? this.pos = t = f.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : this.pos = t = e, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), n && n.set ? n.set(this) : qe.propHooks._default.set(this), this
        }
    }, qe.prototype.init.prototype = qe.prototype, qe.propHooks = {
        _default: {
            get: function (e) {
                var t;
                return 1 !== e.elem.nodeType || null != e.elem[e.prop] && null == e.elem.style[e.prop] ? e.elem[e.prop] : (t = f.css(e.elem, e.prop, "")) && "auto" !== t ? t : 0
            }, set: function (e) {
                f.fx.step[e.prop] ? f.fx.step[e.prop](e) : 1 !== e.elem.nodeType || null == e.elem.style[f.cssProps[e.prop]] && !f.cssHooks[e.prop] ? e.elem[e.prop] = e.now : f.style(e.elem, e.prop, e.now + e.unit)
            }
        }
    }, qe.propHooks.scrollTop = qe.propHooks.scrollLeft = {
        set: function (e) {
            e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now)
        }
    }, f.easing = {
        linear: function (e) {
            return e
        }, swing: function (e) {
            return .5 - Math.cos(e * Math.PI) / 2
        }, _default: "swing"
    }, f.fx = qe.prototype.init, f.fx.step = {};
    var Re, We, Be = /^(?:toggle|show|hide)$/, Ue = /queueHooks$/;

    function Ye() {
        return e.setTimeout(function () {
            Re = void 0
        }), Re = f.now()
    }

    function Ve(e, t) {
        var n, i = 0, o = {height: e};
        for (t = t ? 1 : 0; 4 > i; i += 2 - t) o["margin" + (n = B[i])] = o["padding" + n] = e;
        return t && (o.opacity = o.width = e), o
    }

    function Xe(e, t, n) {
        for (var i, o = (Je.tweeners[t] || []).concat(Je.tweeners["*"]), r = 0, s = o.length; s > r; r++) if (i = o[r].call(n, t, e)) return i
    }

    function Je(e, t, n) {
        var i, o, r = 0, s = Je.prefilters.length, a = f.Deferred().always(function () {
            delete l.elem
        }), l = function () {
            if (o) return !1;
            for (var t = Re || Ye(), n = Math.max(0, c.startTime + c.duration - t), i = 1 - (n / c.duration || 0), r = 0, s = c.tweens.length; s > r; r++) c.tweens[r].run(i);
            return a.notifyWith(e, [c, i, n]), 1 > i && s ? n : (a.resolveWith(e, [c]), !1)
        }, c = a.promise({
            elem: e,
            props: f.extend({}, t),
            opts: f.extend(!0, {specialEasing: {}, easing: f.easing._default}, n),
            originalProperties: t,
            originalOptions: n,
            startTime: Re || Ye(),
            duration: n.duration,
            tweens: [],
            createTween: function (t, n) {
                var i = f.Tween(e, c.opts, t, n, c.opts.specialEasing[t] || c.opts.easing);
                return c.tweens.push(i), i
            },
            stop: function (t) {
                var n = 0, i = t ? c.tweens.length : 0;
                if (o) return this;
                for (o = !0; i > n; n++) c.tweens[n].run(1);
                return t ? (a.notifyWith(e, [c, 1, 0]), a.resolveWith(e, [c, t])) : a.rejectWith(e, [c, t]), this
            }
        }), d = c.props;
        for (function (e, t) {
            var n, i, o, r, s;
            for (n in e) if (o = t[i = f.camelCase(n)], r = e[n], f.isArray(r) && (o = r[1], r = e[n] = r[0]), n !== i && (e[i] = r, delete e[n]), (s = f.cssHooks[i]) && "expand" in s) for (n in r = s.expand(r), delete e[i], r) n in e || (e[n] = r[n], t[n] = o); else t[i] = o
        }(d, c.opts.specialEasing); s > r; r++) if (i = Je.prefilters[r].call(c, e, d, c.opts)) return f.isFunction(i.stop) && (f._queueHooks(c.elem, c.opts.queue).stop = f.proxy(i.stop, i)), i;
        return f.map(d, Xe, c), f.isFunction(c.opts.start) && c.opts.start.call(e, c), f.fx.timer(f.extend(l, {
            elem: e,
            anim: c,
            queue: c.opts.queue
        })), c.progress(c.opts.progress).done(c.opts.done, c.opts.complete).fail(c.opts.fail).always(c.opts.always)
    }

    f.Animation = f.extend(Je, {
        tweeners: {
            "*": [function (e, t) {
                var n = this.createTween(e, t);
                return Y(n.elem, e, W.exec(t), n), n
            }]
        }, tweener: function (e, t) {
            f.isFunction(e) ? (t = e, e = ["*"]) : e = e.match(M);
            for (var n, i = 0, o = e.length; o > i; i++) n = e[i], Je.tweeners[n] = Je.tweeners[n] || [], Je.tweeners[n].unshift(t)
        }, prefilters: [function (e, t, n) {
            var i, o, r, s, a, l, c, d = this, u = {}, p = e.style, h = e.nodeType && U(e), m = z.get(e, "fxshow");
            for (i in n.queue || (null == (a = f._queueHooks(e, "fx")).unqueued && (a.unqueued = 0, l = a.empty.fire, a.empty.fire = function () {
                a.unqueued || l()
            }), a.unqueued++, d.always(function () {
                d.always(function () {
                    a.unqueued--, f.queue(e, "fx").length || a.empty.fire()
                })
            })), 1 === e.nodeType && ("height" in t || "width" in t) && (n.overflow = [p.overflow, p.overflowX, p.overflowY], "inline" === ("none" === (c = f.css(e, "display")) ? z.get(e, "olddisplay") || Ce(e.nodeName) : c) && "none" === f.css(e, "float") && (p.display = "inline-block")), n.overflow && (p.overflow = "hidden", d.always(function () {
                p.overflow = n.overflow[0], p.overflowX = n.overflow[1], p.overflowY = n.overflow[2]
            })), t) if (o = t[i], Be.exec(o)) {
                if (delete t[i], r = r || "toggle" === o, o === (h ? "hide" : "show")) {
                    if ("show" !== o || !m || void 0 === m[i]) continue;
                    h = !0
                }
                u[i] = m && m[i] || f.style(e, i)
            } else c = void 0;
            if (f.isEmptyObject(u)) "inline" === ("none" === c ? Ce(e.nodeName) : c) && (p.display = c); else for (i in m ? "hidden" in m && (h = m.hidden) : m = z.access(e, "fxshow", {}), r && (m.hidden = !h), h ? f(e).show() : d.done(function () {
                f(e).hide()
            }), d.done(function () {
                var t;
                for (t in z.remove(e, "fxshow"), u) f.style(e, t, u[t])
            }), u) s = Xe(h ? m[i] : 0, i, d), i in m || (m[i] = s.start, h && (s.end = s.start, s.start = "width" === i || "height" === i ? 1 : 0))
        }], prefilter: function (e, t) {
            t ? Je.prefilters.unshift(e) : Je.prefilters.push(e)
        }
    }), f.speed = function (e, t, n) {
        var i = e && "object" == typeof e ? f.extend({}, e) : {
            complete: n || !n && t || f.isFunction(e) && e,
            duration: e,
            easing: n && t || t && !f.isFunction(t) && t
        };
        return i.duration = f.fx.off ? 0 : "number" == typeof i.duration ? i.duration : i.duration in f.fx.speeds ? f.fx.speeds[i.duration] : f.fx.speeds._default, (null == i.queue || !0 === i.queue) && (i.queue = "fx"), i.old = i.complete, i.complete = function () {
            f.isFunction(i.old) && i.old.call(this), i.queue && f.dequeue(this, i.queue)
        }, i
    }, f.fn.extend({
        fadeTo: function (e, t, n, i) {
            return this.filter(U).css("opacity", 0).show().end().animate({opacity: t}, e, n, i)
        }, animate: function (e, t, n, i) {
            var o = f.isEmptyObject(e), r = f.speed(t, n, i), s = function () {
                var t = Je(this, f.extend({}, e), r);
                (o || z.get(this, "finish")) && t.stop(!0)
            };
            return s.finish = s, o || !1 === r.queue ? this.each(s) : this.queue(r.queue, s)
        }, stop: function (e, t, n) {
            var i = function (e) {
                var t = e.stop;
                delete e.stop, t(n)
            };
            return "string" != typeof e && (n = t, t = e, e = void 0), t && !1 !== e && this.queue(e || "fx", []), this.each(function () {
                var t = !0, o = null != e && e + "queueHooks", r = f.timers, s = z.get(this);
                if (o) s[o] && s[o].stop && i(s[o]); else for (o in s) s[o] && s[o].stop && Ue.test(o) && i(s[o]);
                for (o = r.length; o--;) r[o].elem !== this || null != e && r[o].queue !== e || (r[o].anim.stop(n), t = !1, r.splice(o, 1));
                (t || !n) && f.dequeue(this, e)
            })
        }, finish: function (e) {
            return !1 !== e && (e = e || "fx"), this.each(function () {
                var t, n = z.get(this), i = n[e + "queue"], o = n[e + "queueHooks"], r = f.timers, s = i ? i.length : 0;
                for (n.finish = !0, f.queue(this, e, []), o && o.stop && o.stop.call(this, !0), t = r.length; t--;) r[t].elem === this && r[t].queue === e && (r[t].anim.stop(!0), r.splice(t, 1));
                for (t = 0; s > t; t++) i[t] && i[t].finish && i[t].finish.call(this);
                delete n.finish
            })
        }
    }), f.each(["toggle", "show", "hide"], function (e, t) {
        var n = f.fn[t];
        f.fn[t] = function (e, i, o) {
            return null == e || "boolean" == typeof e ? n.apply(this, arguments) : this.animate(Ve(t, !0), e, i, o)
        }
    }), f.each({
        slideDown: Ve("show"),
        slideUp: Ve("hide"),
        slideToggle: Ve("toggle"),
        fadeIn: {opacity: "show"},
        fadeOut: {opacity: "hide"},
        fadeToggle: {opacity: "toggle"}
    }, function (e, t) {
        f.fn[e] = function (e, n, i) {
            return this.animate(t, e, n, i)
        }
    }), f.timers = [], f.fx.tick = function () {
        var e, t = 0, n = f.timers;
        for (Re = f.now(); t < n.length; t++) (e = n[t])() || n[t] !== e || n.splice(t--, 1);
        n.length || f.fx.stop(), Re = void 0
    }, f.fx.timer = function (e) {
        f.timers.push(e), e() ? f.fx.start() : f.timers.pop()
    }, f.fx.interval = 13, f.fx.start = function () {
        We || (We = e.setInterval(f.fx.tick, f.fx.interval))
    }, f.fx.stop = function () {
        e.clearInterval(We), We = null
    }, f.fx.speeds = {slow: 600, fast: 200, _default: 400}, f.fn.delay = function (t, n) {
        return t = f.fx && f.fx.speeds[t] || t, n = n || "fx", this.queue(n, function (n, i) {
            var o = e.setTimeout(n, t);
            i.stop = function () {
                e.clearTimeout(o)
            }
        })
    }, function () {
        var e = i.createElement("input"), t = i.createElement("select"), n = t.appendChild(i.createElement("option"));
        e.type = "checkbox", u.checkOn = "" !== e.value, u.optSelected = n.selected, t.disabled = !0, u.optDisabled = !n.disabled, (e = i.createElement("input")).value = "t", e.type = "radio", u.radioValue = "t" === e.value
    }();
    var Ge, Qe = f.expr.attrHandle;
    f.fn.extend({
        attr: function (e, t) {
            return D(this, f.attr, e, t, arguments.length > 1)
        }, removeAttr: function (e) {
            return this.each(function () {
                f.removeAttr(this, e)
            })
        }
    }), f.extend({
        attr: function (e, t, n) {
            var i, o, r = e.nodeType;
            if (3 !== r && 8 !== r && 2 !== r) return void 0 === e.getAttribute ? f.prop(e, t, n) : (1 === r && f.isXMLDoc(e) || (t = t.toLowerCase(), o = f.attrHooks[t] || (f.expr.match.bool.test(t) ? Ge : void 0)), void 0 !== n ? null === n ? void f.removeAttr(e, t) : o && "set" in o && void 0 !== (i = o.set(e, n, t)) ? i : (e.setAttribute(t, n + ""), n) : o && "get" in o && null !== (i = o.get(e, t)) ? i : null == (i = f.find.attr(e, t)) ? void 0 : i)
        }, attrHooks: {
            type: {
                set: function (e, t) {
                    if (!u.radioValue && "radio" === t && f.nodeName(e, "input")) {
                        var n = e.value;
                        return e.setAttribute("type", t), n && (e.value = n), t
                    }
                }
            }
        }, removeAttr: function (e, t) {
            var n, i, o = 0, r = t && t.match(M);
            if (r && 1 === e.nodeType) for (; n = r[o++];) i = f.propFix[n] || n, f.expr.match.bool.test(n) && (e[i] = !1), e.removeAttribute(n)
        }
    }), Ge = {
        set: function (e, t, n) {
            return !1 === t ? f.removeAttr(e, n) : e.setAttribute(n, n), n
        }
    }, f.each(f.expr.match.bool.source.match(/\w+/g), function (e, t) {
        var n = Qe[t] || f.find.attr;
        Qe[t] = function (e, t, i) {
            var o, r;
            return i || (r = Qe[t], Qe[t] = o, o = null != n(e, t, i) ? t.toLowerCase() : null, Qe[t] = r), o
        }
    });
    var Ke = /^(?:input|select|textarea|button)$/i, Ze = /^(?:a|area)$/i;
    f.fn.extend({
        prop: function (e, t) {
            return D(this, f.prop, e, t, arguments.length > 1)
        }, removeProp: function (e) {
            return this.each(function () {
                delete this[f.propFix[e] || e]
            })
        }
    }), f.extend({
        prop: function (e, t, n) {
            var i, o, r = e.nodeType;
            if (3 !== r && 8 !== r && 2 !== r) return 1 === r && f.isXMLDoc(e) || (t = f.propFix[t] || t, o = f.propHooks[t]), void 0 !== n ? o && "set" in o && void 0 !== (i = o.set(e, n, t)) ? i : e[t] = n : o && "get" in o && null !== (i = o.get(e, t)) ? i : e[t]
        }, propHooks: {
            tabIndex: {
                get: function (e) {
                    var t = f.find.attr(e, "tabindex");
                    return t ? parseInt(t, 10) : Ke.test(e.nodeName) || Ze.test(e.nodeName) && e.href ? 0 : -1
                }
            }
        }, propFix: {for: "htmlFor", class: "className"}
    }), u.optSelected || (f.propHooks.selected = {
        get: function (e) {
            var t = e.parentNode;
            return t && t.parentNode && t.parentNode.selectedIndex, null
        }
    }), f.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function () {
        f.propFix[this.toLowerCase()] = this
    });
    var et = /[\t\r\n\f]/g;

    function tt(e) {
        return e.getAttribute && e.getAttribute("class") || ""
    }

    f.fn.extend({
        addClass: function (e) {
            var t, n, i, o, r, s, a, l = 0;
            if (f.isFunction(e)) return this.each(function (t) {
                f(this).addClass(e.call(this, t, tt(this)))
            });
            if ("string" == typeof e && e) for (t = e.match(M) || []; n = this[l++];) if (o = tt(n), i = 1 === n.nodeType && (" " + o + " ").replace(et, " ")) {
                for (s = 0; r = t[s++];) i.indexOf(" " + r + " ") < 0 && (i += r + " ");
                o !== (a = f.trim(i)) && n.setAttribute("class", a)
            }
            return this
        }, removeClass: function (e) {
            var t, n, i, o, r, s, a, l = 0;
            if (f.isFunction(e)) return this.each(function (t) {
                f(this).removeClass(e.call(this, t, tt(this)))
            });
            if (!arguments.length) return this.attr("class", "");
            if ("string" == typeof e && e) for (t = e.match(M) || []; n = this[l++];) if (o = tt(n), i = 1 === n.nodeType && (" " + o + " ").replace(et, " ")) {
                for (s = 0; r = t[s++];) for (; i.indexOf(" " + r + " ") > -1;) i = i.replace(" " + r + " ", " ");
                o !== (a = f.trim(i)) && n.setAttribute("class", a)
            }
            return this
        }, toggleClass: function (e, t) {
            var n = typeof e;
            return "boolean" == typeof t && "string" === n ? t ? this.addClass(e) : this.removeClass(e) : f.isFunction(e) ? this.each(function (n) {
                f(this).toggleClass(e.call(this, n, tt(this), t), t)
            }) : this.each(function () {
                var t, i, o, r;
                if ("string" === n) for (i = 0, o = f(this), r = e.match(M) || []; t = r[i++];) o.hasClass(t) ? o.removeClass(t) : o.addClass(t); else (void 0 === e || "boolean" === n) && ((t = tt(this)) && z.set(this, "__className__", t), this.setAttribute && this.setAttribute("class", t || !1 === e ? "" : z.get(this, "__className__") || ""))
            })
        }, hasClass: function (e) {
            var t, n, i = 0;
            for (t = " " + e + " "; n = this[i++];) if (1 === n.nodeType && (" " + tt(n) + " ").replace(et, " ").indexOf(t) > -1) return !0;
            return !1
        }
    });
    var nt = /\r/g;
    f.fn.extend({
        val: function (e) {
            var t, n, i, o = this[0];
            return arguments.length ? (i = f.isFunction(e), this.each(function (n) {
                var o;
                1 === this.nodeType && (null == (o = i ? e.call(this, n, f(this).val()) : e) ? o = "" : "number" == typeof o ? o += "" : f.isArray(o) && (o = f.map(o, function (e) {
                    return null == e ? "" : e + ""
                })), (t = f.valHooks[this.type] || f.valHooks[this.nodeName.toLowerCase()]) && "set" in t && void 0 !== t.set(this, o, "value") || (this.value = o))
            })) : o ? (t = f.valHooks[o.type] || f.valHooks[o.nodeName.toLowerCase()]) && "get" in t && void 0 !== (n = t.get(o, "value")) ? n : "string" == typeof (n = o.value) ? n.replace(nt, "") : null == n ? "" : n : void 0
        }
    }), f.extend({
        valHooks: {
            option: {
                get: function (e) {
                    return f.trim(e.value)
                }
            }, select: {
                get: function (e) {
                    for (var t, n, i = e.options, o = e.selectedIndex, r = "select-one" === e.type || 0 > o, s = r ? null : [], a = r ? o + 1 : i.length, l = 0 > o ? a : r ? o : 0; a > l; l++) if (((n = i[l]).selected || l === o) && (u.optDisabled ? !n.disabled : null === n.getAttribute("disabled")) && (!n.parentNode.disabled || !f.nodeName(n.parentNode, "optgroup"))) {
                        if (t = f(n).val(), r) return t;
                        s.push(t)
                    }
                    return s
                }, set: function (e, t) {
                    for (var n, i, o = e.options, r = f.makeArray(t), s = o.length; s--;) ((i = o[s]).selected = f.inArray(f.valHooks.option.get(i), r) > -1) && (n = !0);
                    return n || (e.selectedIndex = -1), r
                }
            }
        }
    }), f.each(["radio", "checkbox"], function () {
        f.valHooks[this] = {
            set: function (e, t) {
                return f.isArray(t) ? e.checked = f.inArray(f(e).val(), t) > -1 : void 0
            }
        }, u.checkOn || (f.valHooks[this].get = function (e) {
            return null === e.getAttribute("value") ? "on" : e.value
        })
    });
    var it = /^(?:focusinfocus|focusoutblur)$/;
    f.extend(f.event, {
        trigger: function (t, n, o, r) {
            var s, a, l, c, u, p, h, m = [o || i], v = d.call(t, "type") ? t.type : t,
                g = d.call(t, "namespace") ? t.namespace.split(".") : [];
            if (a = l = o = o || i, 3 !== o.nodeType && 8 !== o.nodeType && !it.test(v + f.event.triggered) && (v.indexOf(".") > -1 && (g = v.split("."), v = g.shift(), g.sort()), u = v.indexOf(":") < 0 && "on" + v, (t = t[f.expando] ? t : new f.Event(v, "object" == typeof t && t)).isTrigger = r ? 2 : 3, t.namespace = g.join("."), t.rnamespace = t.namespace ? new RegExp("(^|\\.)" + g.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, t.result = void 0, t.target || (t.target = o), n = null == n ? [t] : f.makeArray(n, [t]), h = f.event.special[v] || {}, r || !h.trigger || !1 !== h.trigger.apply(o, n))) {
                if (!r && !h.noBubble && !f.isWindow(o)) {
                    for (c = h.delegateType || v, it.test(c + v) || (a = a.parentNode); a; a = a.parentNode) m.push(a), l = a;
                    l === (o.ownerDocument || i) && m.push(l.defaultView || l.parentWindow || e)
                }
                for (s = 0; (a = m[s++]) && !t.isPropagationStopped();) t.type = s > 1 ? c : h.bindType || v, (p = (z.get(a, "events") || {})[t.type] && z.get(a, "handle")) && p.apply(a, n), (p = u && a[u]) && p.apply && L(a) && (t.result = p.apply(a, n), !1 === t.result && t.preventDefault());
                return t.type = v, r || t.isDefaultPrevented() || h._default && !1 !== h._default.apply(m.pop(), n) || !L(o) || u && f.isFunction(o[v]) && !f.isWindow(o) && ((l = o[u]) && (o[u] = null), f.event.triggered = v, o[v](), f.event.triggered = void 0, l && (o[u] = l)), t.result
            }
        }, simulate: function (e, t, n) {
            var i = f.extend(new f.Event, n, {type: e, isSimulated: !0});
            f.event.trigger(i, null, t), i.isDefaultPrevented() && n.preventDefault()
        }
    }), f.fn.extend({
        trigger: function (e, t) {
            return this.each(function () {
                f.event.trigger(e, t, this)
            })
        }, triggerHandler: function (e, t) {
            var n = this[0];
            return n ? f.event.trigger(e, t, n, !0) : void 0
        }
    }), f.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function (e, t) {
        f.fn[t] = function (e, n) {
            return arguments.length > 0 ? this.on(t, null, e, n) : this.trigger(t)
        }
    }), f.fn.extend({
        hover: function (e, t) {
            return this.mouseenter(e).mouseleave(t || e)
        }
    }), u.focusin = "onfocusin" in e, u.focusin || f.each({focus: "focusin", blur: "focusout"}, function (e, t) {
        var n = function (e) {
            f.event.simulate(t, e.target, f.event.fix(e))
        };
        f.event.special[t] = {
            setup: function () {
                var i = this.ownerDocument || this, o = z.access(i, t);
                o || i.addEventListener(e, n, !0), z.access(i, t, (o || 0) + 1)
            }, teardown: function () {
                var i = this.ownerDocument || this, o = z.access(i, t) - 1;
                o ? z.access(i, t, o) : (i.removeEventListener(e, n, !0), z.remove(i, t))
            }
        }
    });
    var ot = e.location, rt = f.now(), st = /\?/;
    f.parseJSON = function (e) {
        return JSON.parse(e + "")
    }, f.parseXML = function (t) {
        var n;
        if (!t || "string" != typeof t) return null;
        try {
            n = (new e.DOMParser).parseFromString(t, "text/xml")
        } catch (e) {
            n = void 0
        }
        return (!n || n.getElementsByTagName("parsererror").length) && f.error("Invalid XML: " + t), n
    };
    var at = /#.*$/, lt = /([?&])_=[^&]*/, ct = /^(.*?):[ \t]*([^\r\n]*)$/gm, dt = /^(?:GET|HEAD)$/, ut = /^\/\//,
        pt = {}, ft = {}, ht = "*/".concat("*"), mt = i.createElement("a");

    function vt(e) {
        return function (t, n) {
            "string" != typeof t && (n = t, t = "*");
            var i, o = 0, r = t.toLowerCase().match(M) || [];
            if (f.isFunction(n)) for (; i = r[o++];) "+" === i[0] ? (i = i.slice(1) || "*", (e[i] = e[i] || []).unshift(n)) : (e[i] = e[i] || []).push(n)
        }
    }

    function gt(e, t, n, i) {
        var o = {}, r = e === ft;

        function s(a) {
            var l;
            return o[a] = !0, f.each(e[a] || [], function (e, a) {
                var c = a(t, n, i);
                return "string" != typeof c || r || o[c] ? r ? !(l = c) : void 0 : (t.dataTypes.unshift(c), s(c), !1)
            }), l
        }

        return s(t.dataTypes[0]) || !o["*"] && s("*")
    }

    function yt(e, t) {
        var n, i, o = f.ajaxSettings.flatOptions || {};
        for (n in t) void 0 !== t[n] && ((o[n] ? e : i || (i = {}))[n] = t[n]);
        return i && f.extend(!0, e, i), e
    }

    mt.href = ot.href, f.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: ot.href,
            type: "GET",
            isLocal: /^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(ot.protocol),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": ht,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {xml: /\bxml\b/, html: /\bhtml/, json: /\bjson\b/},
            responseFields: {xml: "responseXML", text: "responseText", json: "responseJSON"},
            converters: {"* text": String, "text html": !0, "text json": f.parseJSON, "text xml": f.parseXML},
            flatOptions: {url: !0, context: !0}
        },
        ajaxSetup: function (e, t) {
            return t ? yt(yt(e, f.ajaxSettings), t) : yt(f.ajaxSettings, e)
        },
        ajaxPrefilter: vt(pt),
        ajaxTransport: vt(ft),
        ajax: function (t, n) {
            "object" == typeof t && (n = t, t = void 0), n = n || {};
            var o, r, s, a, l, c, d, u, p = f.ajaxSetup({}, n), h = p.context || p,
                m = p.context && (h.nodeType || h.jquery) ? f(h) : f.event, v = f.Deferred(),
                g = f.Callbacks("once memory"), y = p.statusCode || {}, b = {}, w = {}, x = 0, k = "canceled", C = {
                    readyState: 0, getResponseHeader: function (e) {
                        var t;
                        if (2 === x) {
                            if (!a) for (a = {}; t = ct.exec(s);) a[t[1].toLowerCase()] = t[2];
                            t = a[e.toLowerCase()]
                        }
                        return null == t ? null : t
                    }, getAllResponseHeaders: function () {
                        return 2 === x ? s : null
                    }, setRequestHeader: function (e, t) {
                        var n = e.toLowerCase();
                        return x || (e = w[n] = w[n] || e, b[e] = t), this
                    }, overrideMimeType: function (e) {
                        return x || (p.mimeType = e), this
                    }, statusCode: function (e) {
                        var t;
                        if (e) if (2 > x) for (t in e) y[t] = [y[t], e[t]]; else C.always(e[C.status]);
                        return this
                    }, abort: function (e) {
                        var t = e || k;
                        return o && o.abort(t), T(0, t), this
                    }
                };
            if (v.promise(C).complete = g.add, C.success = C.done, C.error = C.fail, p.url = ((t || p.url || ot.href) + "").replace(at, "").replace(ut, ot.protocol + "//"), p.type = n.method || n.type || p.method || p.type, p.dataTypes = f.trim(p.dataType || "*").toLowerCase().match(M) || [""], null == p.crossDomain) {
                c = i.createElement("a");
                try {
                    c.href = p.url, c.href = c.href, p.crossDomain = mt.protocol + "//" + mt.host != c.protocol + "//" + c.host
                } catch (e) {
                    p.crossDomain = !0
                }
            }
            if (p.data && p.processData && "string" != typeof p.data && (p.data = f.param(p.data, p.traditional)), gt(pt, p, n, C), 2 === x) return C;
            for (u in (d = f.event && p.global) && 0 == f.active++ && f.event.trigger("ajaxStart"), p.type = p.type.toUpperCase(), p.hasContent = !dt.test(p.type), r = p.url, p.hasContent || (p.data && (r = p.url += (st.test(r) ? "&" : "?") + p.data, delete p.data), !1 === p.cache && (p.url = lt.test(r) ? r.replace(lt, "$1_=" + rt++) : r + (st.test(r) ? "&" : "?") + "_=" + rt++)), p.ifModified && (f.lastModified[r] && C.setRequestHeader("If-Modified-Since", f.lastModified[r]), f.etag[r] && C.setRequestHeader("If-None-Match", f.etag[r])), (p.data && p.hasContent && !1 !== p.contentType || n.contentType) && C.setRequestHeader("Content-Type", p.contentType), C.setRequestHeader("Accept", p.dataTypes[0] && p.accepts[p.dataTypes[0]] ? p.accepts[p.dataTypes[0]] + ("*" !== p.dataTypes[0] ? ", " + ht + "; q=0.01" : "") : p.accepts["*"]), p.headers) C.setRequestHeader(u, p.headers[u]);
            if (p.beforeSend && (!1 === p.beforeSend.call(h, C, p) || 2 === x)) return C.abort();
            for (u in k = "abort", {success: 1, error: 1, complete: 1}) C[u](p[u]);
            if (o = gt(ft, p, n, C)) {
                if (C.readyState = 1, d && m.trigger("ajaxSend", [C, p]), 2 === x) return C;
                p.async && p.timeout > 0 && (l = e.setTimeout(function () {
                    C.abort("timeout")
                }, p.timeout));
                try {
                    x = 1, o.send(b, T)
                } catch (e) {
                    if (!(2 > x)) throw e;
                    T(-1, e)
                }
            } else T(-1, "No Transport");

            function T(t, n, i, a) {
                var c, u, b, w, k, T = n;
                2 !== x && (x = 2, l && e.clearTimeout(l), o = void 0, s = a || "", C.readyState = t > 0 ? 4 : 0, c = t >= 200 && 300 > t || 304 === t, i && (w = function (e, t, n) {
                    for (var i, o, r, s, a = e.contents, l = e.dataTypes; "*" === l[0];) l.shift(), void 0 === i && (i = e.mimeType || t.getResponseHeader("Content-Type"));
                    if (i) for (o in a) if (a[o] && a[o].test(i)) {
                        l.unshift(o);
                        break
                    }
                    if (l[0] in n) r = l[0]; else {
                        for (o in n) {
                            if (!l[0] || e.converters[o + " " + l[0]]) {
                                r = o;
                                break
                            }
                            s || (s = o)
                        }
                        r = r || s
                    }
                    return r ? (r !== l[0] && l.unshift(r), n[r]) : void 0
                }(p, C, i)), w = function (e, t, n, i) {
                    var o, r, s, a, l, c = {}, d = e.dataTypes.slice();
                    if (d[1]) for (s in e.converters) c[s.toLowerCase()] = e.converters[s];
                    for (r = d.shift(); r;) if (e.responseFields[r] && (n[e.responseFields[r]] = t), !l && i && e.dataFilter && (t = e.dataFilter(t, e.dataType)), l = r, r = d.shift()) if ("*" === r) r = l; else if ("*" !== l && l !== r) {
                        if (!(s = c[l + " " + r] || c["* " + r])) for (o in c) if ((a = o.split(" "))[1] === r && (s = c[l + " " + a[0]] || c["* " + a[0]])) {
                            !0 === s ? s = c[o] : !0 !== c[o] && (r = a[0], d.unshift(a[1]));
                            break
                        }
                        if (!0 !== s) if (s && e.throws) t = s(t); else try {
                            t = s(t)
                        } catch (e) {
                            return {state: "parsererror", error: s ? e : "No conversion from " + l + " to " + r}
                        }
                    }
                    return {state: "success", data: t}
                }(p, w, C, c), c ? (p.ifModified && ((k = C.getResponseHeader("Last-Modified")) && (f.lastModified[r] = k), (k = C.getResponseHeader("etag")) && (f.etag[r] = k)), 204 === t || "HEAD" === p.type ? T = "nocontent" : 304 === t ? T = "notmodified" : (T = w.state, u = w.data, c = !(b = w.error))) : (b = T, (t || !T) && (T = "error", 0 > t && (t = 0))), C.status = t, C.statusText = (n || T) + "", c ? v.resolveWith(h, [u, T, C]) : v.rejectWith(h, [C, T, b]), C.statusCode(y), y = void 0, d && m.trigger(c ? "ajaxSuccess" : "ajaxError", [C, p, c ? u : b]), g.fireWith(h, [C, T]), d && (m.trigger("ajaxComplete", [C, p]), --f.active || f.event.trigger("ajaxStop")))
            }

            return C
        },
        getJSON: function (e, t, n) {
            return f.get(e, t, n, "json")
        },
        getScript: function (e, t) {
            return f.get(e, void 0, t, "script")
        }
    }), f.each(["get", "post"], function (e, t) {
        f[t] = function (e, n, i, o) {
            return f.isFunction(n) && (o = o || i, i = n, n = void 0), f.ajax(f.extend({
                url: e,
                type: t,
                dataType: o,
                data: n,
                success: i
            }, f.isPlainObject(e) && e))
        }
    }), f._evalUrl = function (e) {
        return f.ajax({url: e, type: "GET", dataType: "script", async: !1, global: !1, throws: !0})
    }, f.fn.extend({
        wrapAll: function (e) {
            var t;
            return f.isFunction(e) ? this.each(function (t) {
                f(this).wrapAll(e.call(this, t))
            }) : (this[0] && (t = f(e, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && t.insertBefore(this[0]), t.map(function () {
                for (var e = this; e.firstElementChild;) e = e.firstElementChild;
                return e
            }).append(this)), this)
        }, wrapInner: function (e) {
            return f.isFunction(e) ? this.each(function (t) {
                f(this).wrapInner(e.call(this, t))
            }) : this.each(function () {
                var t = f(this), n = t.contents();
                n.length ? n.wrapAll(e) : t.append(e)
            })
        }, wrap: function (e) {
            var t = f.isFunction(e);
            return this.each(function (n) {
                f(this).wrapAll(t ? e.call(this, n) : e)
            })
        }, unwrap: function () {
            return this.parent().each(function () {
                f.nodeName(this, "body") || f(this).replaceWith(this.childNodes)
            }).end()
        }
    }), f.expr.filters.hidden = function (e) {
        return !f.expr.filters.visible(e)
    }, f.expr.filters.visible = function (e) {
        return e.offsetWidth > 0 || e.offsetHeight > 0 || e.getClientRects().length > 0
    };
    var bt = /%20/g, wt = /\[\]$/, xt = /\r?\n/g, kt = /^(?:submit|button|image|reset|file)$/i,
        Ct = /^(?:input|select|textarea|keygen)/i;

    function Tt(e, t, n, i) {
        var o;
        if (f.isArray(t)) f.each(t, function (t, o) {
            n || wt.test(e) ? i(e, o) : Tt(e + "[" + ("object" == typeof o && null != o ? t : "") + "]", o, n, i)
        }); else if (n || "object" !== f.type(t)) i(e, t); else for (o in t) Tt(e + "[" + o + "]", t[o], n, i)
    }

    f.param = function (e, t) {
        var n, i = [], o = function (e, t) {
            t = f.isFunction(t) ? t() : null == t ? "" : t, i[i.length] = encodeURIComponent(e) + "=" + encodeURIComponent(t)
        };
        if (void 0 === t && (t = f.ajaxSettings && f.ajaxSettings.traditional), f.isArray(e) || e.jquery && !f.isPlainObject(e)) f.each(e, function () {
            o(this.name, this.value)
        }); else for (n in e) Tt(n, e[n], t, o);
        return i.join("&").replace(bt, "+")
    }, f.fn.extend({
        serialize: function () {
            return f.param(this.serializeArray())
        }, serializeArray: function () {
            return this.map(function () {
                var e = f.prop(this, "elements");
                return e ? f.makeArray(e) : this
            }).filter(function () {
                var e = this.type;
                return this.name && !f(this).is(":disabled") && Ct.test(this.nodeName) && !kt.test(e) && (this.checked || !V.test(e))
            }).map(function (e, t) {
                var n = f(this).val();
                return null == n ? null : f.isArray(n) ? f.map(n, function (e) {
                    return {name: t.name, value: e.replace(xt, "\r\n")}
                }) : {name: t.name, value: n.replace(xt, "\r\n")}
            }).get()
        }
    }), f.ajaxSettings.xhr = function () {
        try {
            return new e.XMLHttpRequest
        } catch (e) {
        }
    };
    var St = {0: 200, 1223: 204}, $t = f.ajaxSettings.xhr();
    u.cors = !!$t && "withCredentials" in $t, u.ajax = $t = !!$t, f.ajaxTransport(function (t) {
        var n, i;
        return u.cors || $t && !t.crossDomain ? {
            send: function (o, r) {
                var s, a = t.xhr();
                if (a.open(t.type, t.url, t.async, t.username, t.password), t.xhrFields) for (s in t.xhrFields) a[s] = t.xhrFields[s];
                for (s in t.mimeType && a.overrideMimeType && a.overrideMimeType(t.mimeType), t.crossDomain || o["X-Requested-With"] || (o["X-Requested-With"] = "XMLHttpRequest"), o) a.setRequestHeader(s, o[s]);
                n = function (e) {
                    return function () {
                        n && (n = i = a.onload = a.onerror = a.onabort = a.onreadystatechange = null, "abort" === e ? a.abort() : "error" === e ? "number" != typeof a.status ? r(0, "error") : r(a.status, a.statusText) : r(St[a.status] || a.status, a.statusText, "text" !== (a.responseType || "text") || "string" != typeof a.responseText ? {binary: a.response} : {text: a.responseText}, a.getAllResponseHeaders()))
                    }
                }, a.onload = n(), i = a.onerror = n("error"), void 0 !== a.onabort ? a.onabort = i : a.onreadystatechange = function () {
                    4 === a.readyState && e.setTimeout(function () {
                        n && i()
                    })
                }, n = n("abort");
                try {
                    a.send(t.hasContent && t.data || null)
                } catch (e) {
                    if (n) throw e
                }
            }, abort: function () {
                n && n()
            }
        } : void 0
    }), f.ajaxSetup({
        accepts: {script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},
        contents: {script: /\b(?:java|ecma)script\b/},
        converters: {
            "text script": function (e) {
                return f.globalEval(e), e
            }
        }
    }), f.ajaxPrefilter("script", function (e) {
        void 0 === e.cache && (e.cache = !1), e.crossDomain && (e.type = "GET")
    }), f.ajaxTransport("script", function (e) {
        var t, n;
        if (e.crossDomain) return {
            send: function (o, r) {
                t = f("<script>").prop({charset: e.scriptCharset, src: e.url}).on("load error", n = function (e) {
                    t.remove(), n = null, e && r("error" === e.type ? 404 : 200, e.type)
                }), i.head.appendChild(t[0])
            }, abort: function () {
                n && n()
            }
        }
    });
    var _t = [], Et = /(=)\?(?=&|$)|\?\?/;
    f.ajaxSetup({
        jsonp: "callback", jsonpCallback: function () {
            var e = _t.pop() || f.expando + "_" + rt++;
            return this[e] = !0, e
        }
    }), f.ajaxPrefilter("json jsonp", function (t, n, i) {
        var o, r, s,
            a = !1 !== t.jsonp && (Et.test(t.url) ? "url" : "string" == typeof t.data && 0 === (t.contentType || "").indexOf("application/x-www-form-urlencoded") && Et.test(t.data) && "data");
        return a || "jsonp" === t.dataTypes[0] ? (o = t.jsonpCallback = f.isFunction(t.jsonpCallback) ? t.jsonpCallback() : t.jsonpCallback, a ? t[a] = t[a].replace(Et, "$1" + o) : !1 !== t.jsonp && (t.url += (st.test(t.url) ? "&" : "?") + t.jsonp + "=" + o), t.converters["script json"] = function () {
            return s || f.error(o + " was not called"), s[0]
        }, t.dataTypes[0] = "json", r = e[o], e[o] = function () {
            s = arguments
        }, i.always(function () {
            void 0 === r ? f(e).removeProp(o) : e[o] = r, t[o] && (t.jsonpCallback = n.jsonpCallback, _t.push(o)), s && f.isFunction(r) && r(s[0]), s = r = void 0
        }), "script") : void 0
    }), u.createHTMLDocument = function () {
        var e = i.implementation.createHTMLDocument("").body;
        return e.innerHTML = "<form></form><form></form>", 2 === e.childNodes.length
    }(), f.parseHTML = function (e, t, n) {
        if (!e || "string" != typeof e) return null;
        "boolean" == typeof t && (n = t, t = !1), t = t || (u.createHTMLDocument ? i.implementation.createHTMLDocument("") : i);
        var o = C.exec(e), r = !n && [];
        return o ? [t.createElement(o[1])] : (o = ee([e], t, r), r && r.length && f(r).remove(), f.merge([], o.childNodes))
    };
    var At = f.fn.load;

    function Ot(e) {
        return f.isWindow(e) ? e : 9 === e.nodeType && e.defaultView
    }

    f.fn.load = function (e, t, n) {
        if ("string" != typeof e && At) return At.apply(this, arguments);
        var i, o, r, s = this, a = e.indexOf(" ");
        return a > -1 && (i = f.trim(e.slice(a)), e = e.slice(0, a)), f.isFunction(t) ? (n = t, t = void 0) : t && "object" == typeof t && (o = "POST"), s.length > 0 && f.ajax({
            url: e,
            type: o || "GET",
            dataType: "html",
            data: t
        }).done(function (e) {
            r = arguments, s.html(i ? f("<div>").append(f.parseHTML(e)).find(i) : e)
        }).always(n && function (e, t) {
            s.each(function () {
                n.apply(s, r || [e.responseText, t, e])
            })
        }), this
    }, f.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function (e, t) {
        f.fn[t] = function (e) {
            return this.on(t, e)
        }
    }), f.expr.filters.animated = function (e) {
        return f.grep(f.timers, function (t) {
            return e === t.elem
        }).length
    }, f.offset = {
        setOffset: function (e, t, n) {
            var i, o, r, s, a, l, c = f.css(e, "position"), d = f(e), u = {};
            "static" === c && (e.style.position = "relative"), a = d.offset(), r = f.css(e, "top"), l = f.css(e, "left"), ("absolute" === c || "fixed" === c) && (r + l).indexOf("auto") > -1 ? (s = (i = d.position()).top, o = i.left) : (s = parseFloat(r) || 0, o = parseFloat(l) || 0), f.isFunction(t) && (t = t.call(e, n, f.extend({}, a))), null != t.top && (u.top = t.top - a.top + s), null != t.left && (u.left = t.left - a.left + o), "using" in t ? t.using.call(e, u) : d.css(u)
        }
    }, f.fn.extend({
        offset: function (e) {
            if (arguments.length) return void 0 === e ? this : this.each(function (t) {
                f.offset.setOffset(this, e, t)
            });
            var t, n, i = this[0], o = {top: 0, left: 0}, r = i && i.ownerDocument;
            return r ? (t = r.documentElement, f.contains(t, i) ? (o = i.getBoundingClientRect(), n = Ot(r), {
                top: o.top + n.pageYOffset - t.clientTop,
                left: o.left + n.pageXOffset - t.clientLeft
            }) : o) : void 0
        }, position: function () {
            if (this[0]) {
                var e, t, n = this[0], i = {top: 0, left: 0};
                return "fixed" === f.css(n, "position") ? t = n.getBoundingClientRect() : (e = this.offsetParent(), t = this.offset(), f.nodeName(e[0], "html") || (i = e.offset()), i.top += f.css(e[0], "borderTopWidth", !0) - e.scrollTop(), i.left += f.css(e[0], "borderLeftWidth", !0) - e.scrollLeft()), {
                    top: t.top - i.top - f.css(n, "marginTop", !0),
                    left: t.left - i.left - f.css(n, "marginLeft", !0)
                }
            }
        }, offsetParent: function () {
            return this.map(function () {
                for (var e = this.offsetParent; e && "static" === f.css(e, "position");) e = e.offsetParent;
                return e || Ee
            })
        }
    }), f.each({scrollLeft: "pageXOffset", scrollTop: "pageYOffset"}, function (e, t) {
        var n = "pageYOffset" === t;
        f.fn[e] = function (i) {
            return D(this, function (e, i, o) {
                var r = Ot(e);
                return void 0 === o ? r ? r[t] : e[i] : void (r ? r.scrollTo(n ? r.pageXOffset : o, n ? o : r.pageYOffset) : e[i] = o)
            }, e, i, arguments.length)
        }
    }), f.each(["top", "left"], function (e, t) {
        f.cssHooks[t] = Oe(u.pixelPosition, function (e, n) {
            return n ? (n = Ae(e, t), Se.test(n) ? f(e).position()[t] + "px" : n) : void 0
        })
    }), f.each({Height: "height", Width: "width"}, function (e, t) {
        f.each({padding: "inner" + e, content: t, "": "outer" + e}, function (n, i) {
            f.fn[i] = function (i, o) {
                var r = arguments.length && (n || "boolean" != typeof i),
                    s = n || (!0 === i || !0 === o ? "margin" : "border");
                return D(this, function (t, n, i) {
                    var o;
                    return f.isWindow(t) ? t.document.documentElement["client" + e] : 9 === t.nodeType ? (o = t.documentElement, Math.max(t.body["scroll" + e], o["scroll" + e], t.body["offset" + e], o["offset" + e], o["client" + e])) : void 0 === i ? f.css(t, n, s) : f.style(t, n, i, s)
                }, t, r ? i : void 0, r, null)
            }
        })
    }), f.fn.extend({
        bind: function (e, t, n) {
            return this.on(e, null, t, n)
        }, unbind: function (e, t) {
            return this.off(e, null, t)
        }, delegate: function (e, t, n, i) {
            return this.on(t, e, n, i)
        }, undelegate: function (e, t, n) {
            return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n)
        }, size: function () {
            return this.length
        }
    }), f.fn.andSelf = f.fn.addBack, "function" == typeof define && define.amd && define("jquery", [], function () {
        return f
    });
    var jt = e.jQuery, Mt = e.$;
    return f.noConflict = function (t) {
        return e.$ === f && (e.$ = Mt), t && e.jQuery === f && (e.jQuery = jt), f
    }, t || (e.jQuery = e.$ = f), f
}), window.Modernizr = function (e, t, n) {
    function i(e) {
        h.cssText = e
    }

    function o(e, t) {
        return typeof e === t
    }

    function r(e, t) {
        return !!~("" + e).indexOf(t)
    }

    function s(e, t) {
        for (var i in e) {
            var o = e[i];
            if (!r(o, "-") && h[o] !== n) return "pfx" != t || o
        }
        return !1
    }

    function a(e, t, i) {
        for (var r in e) {
            var s = t[e[r]];
            if (s !== n) return !1 === i ? e[r] : o(s, "function") ? s.bind(i || t) : s
        }
        return !1
    }

    function l(e, t, n) {
        var i = e.charAt(0).toUpperCase() + e.slice(1), r = (e + " " + v.join(i + " ") + i).split(" ");
        return o(t, "string") || o(t, "undefined") ? s(r, t) : a(r = (e + " " + g.join(i + " ") + i).split(" "), t, n)
    }

    var c, d, u = {}, p = t.documentElement, f = t.createElement("modernizr"), h = f.style, m = "Webkit Moz O ms",
        v = m.split(" "), g = m.toLowerCase().split(" "), y = {}, b = [], w = b.slice, x = {}.hasOwnProperty;
    for (var k in d = o(x, "undefined") || o(x.call, "undefined") ? function (e, t) {
        return t in e && o(e.constructor.prototype[t], "undefined")
    } : function (e, t) {
        return x.call(e, t)
    }, Function.prototype.bind || (Function.prototype.bind = function (e) {
        var t = this;
        if ("function" != typeof t) throw new TypeError;
        var n = w.call(arguments, 1), i = function () {
            if (this instanceof i) {
                var o = function () {
                };
                o.prototype = t.prototype;
                var r = new o, s = t.apply(r, n.concat(w.call(arguments)));
                return Object(s) === s ? s : r
            }
            return t.apply(e, n.concat(w.call(arguments)))
        };
        return i
    }), y.csstransitions = function () {
        return l("transition")
    }, y) d(y, k) && (c = k.toLowerCase(), u[c] = y[k](), b.push((u[c] ? "" : "no-") + c));
    return u.addTest = function (e, t) {
        if ("object" == typeof e) for (var i in e) d(e, i) && u.addTest(i, e[i]); else {
            if (e = e.toLowerCase(), u[e] !== n) return u;
            t = "function" == typeof t ? t() : t, p.className += " " + (t ? "" : "no-") + e, u[e] = t
        }
        return u
    }, i(""), f = null, function (e, t) {
        function n() {
            var e = h.elements;
            return "string" == typeof e ? e.split(" ") : e
        }

        function i(e) {
            var t = f[e[u]];
            return t || (t = {}, p++, e[u] = p, f[p] = t), t
        }

        function o(e, n, o) {
            return n || (n = t), a ? n.createElement(e) : (o || (o = i(n)), (r = o.cache[e] ? o.cache[e].cloneNode() : d.test(e) ? (o.cache[e] = o.createElem(e)).cloneNode() : o.createElem(e)).canHaveChildren && !c.test(e) ? o.frag.appendChild(r) : r);
            var r
        }

        function r(e) {
            e || (e = t);
            var r = i(e);
            return h.shivCSS && !s && !r.hasCSS && (r.hasCSS = !!function (e, t) {
                var n = e.createElement("p"), i = e.getElementsByTagName("head")[0] || e.documentElement;
                return n.innerHTML = "x<style>" + t + "</style>", i.insertBefore(n.lastChild, i.firstChild)
            }(e, "article,aside,figcaption,figure,footer,header,hgroup,nav,section{display:block}mark{background:#FF0;color:#000}")), a || function (e, t) {
                t.cache || (t.cache = {}, t.createElem = e.createElement, t.createFrag = e.createDocumentFragment, t.frag = t.createFrag()), e.createElement = function (n) {
                    return h.shivMethods ? o(n, e, t) : t.createElem(n)
                }, e.createDocumentFragment = Function("h,f", "return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&(" + n().join().replace(/\w+/g, function (e) {
                    return t.createElem(e), t.frag.createElement(e), 'c("' + e + '")'
                }) + ");return n}")(h, t.frag)
            }(e, r), e
        }

        var s, a, l = e.html5 || {}, c = /^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,
            d = /^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,
            u = "_html5shiv", p = 0, f = {};
        !function () {
            try {
                var e = t.createElement("a");
                e.innerHTML = "<xyz></xyz>", s = "hidden" in e, a = 1 == e.childNodes.length || function () {
                    t.createElement("a");
                    var e = t.createDocumentFragment();
                    return void 0 === e.cloneNode || void 0 === e.createDocumentFragment || void 0 === e.createElement
                }()
            } catch (e) {
                s = !0, a = !0
            }
        }();
        var h = {
            elements: l.elements || "abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video",
            shivCSS: !1 !== l.shivCSS,
            supportsUnknownElements: a,
            shivMethods: !1 !== l.shivMethods,
            type: "default",
            shivDocument: r,
            createElement: o,
            createDocumentFragment: function (e, o) {
                if (e || (e = t), a) return e.createDocumentFragment();
                for (var r = (o = o || i(e)).frag.cloneNode(), s = 0, l = n(), c = l.length; s < c; s++) r.createElement(l[s]);
                return r
            }
        };
        e.html5 = h, r(t)
    }(this, t), u._version = "2.6.2", u._domPrefixes = g, u._cssomPrefixes = v, u.testProp = function (e) {
        return s([e])
    }, u.testAllProps = l, p.className = p.className.replace(/(^|\s)no-js(\s|$)/, "$1$2") + " js " + b.join(" "), u
}(0, this.document), function (e, t, n) {
    function i(e) {
        return "[object Function]" == v.call(e)
    }

    function o(e) {
        return "string" == typeof e
    }

    function r() {
    }

    function s(e) {
        return !e || "loaded" == e || "complete" == e || "uninitialized" == e
    }

    function a() {
        var e = g.shift();
        y = 1, e ? e.t ? h(function () {
            ("c" == e.t ? p.injectCss : p.injectJs)(e.s, 0, e.a, e.x, e.e, 1)
        }, 0) : (e(), a()) : y = 0
    }

    function l(e, n, i, o, r, l, c) {
        function d(t) {
            if (!f && s(u.readyState) && (b.r = f = 1, !y && a(), u.onload = u.onreadystatechange = null, t)) for (var i in "img" != e && h(function () {
                x.removeChild(u)
            }, 50), $[n]) $[n].hasOwnProperty(i) && $[n][i].onload()
        }

        c = c || p.errorTimeout;
        var u = t.createElement(e), f = 0, v = 0, b = {t: i, s: n, e: r, a: l, x: c};
        1 === $[n] && (v = 1, $[n] = []), "object" == e ? u.data = n : (u.src = n, u.type = e), u.width = u.height = "0", u.onerror = u.onload = u.onreadystatechange = function () {
            d.call(this, v)
        }, g.splice(o, 0, b), "img" != e && (v || 2 === $[n] ? (x.insertBefore(u, w ? null : m), h(d, c)) : $[n].push(u))
    }

    function c(e, t, n, i, r) {
        return y = 0, t = t || "j", o(e) ? l("c" == t ? C : k, e, t, this.i++, n, i, r) : (g.splice(this.i++, 0, e), 1 == g.length && a()), this
    }

    function d() {
        var e = p;
        return e.loader = {load: c, i: 0}, e
    }

    var u, p, f = t.documentElement, h = e.setTimeout, m = t.getElementsByTagName("script")[0], v = {}.toString, g = [],
        y = 0, b = "MozAppearance" in f.style, w = b && !!t.createRange().compareNode, x = w ? f : m.parentNode,
        k = (f = e.opera && "[object Opera]" == v.call(e.opera), f = !!t.attachEvent && !f, b ? "object" : f ? "script" : "img"),
        C = f ? "script" : k, T = Array.isArray || function (e) {
            return "[object Array]" == v.call(e)
        }, S = [], $ = {}, _ = {
            timeout: function (e, t) {
                return t.length && (e.timeout = t[0]), e
            }
        };
    (p = function (e) {
        function t(e, t, o, r, s) {
            var a = function (e) {
                e = e.split("!");
                var t, n, i, o = S.length, r = e.pop(), s = e.length;
                for (r = {
                    url: r,
                    origUrl: r,
                    prefixes: e
                }, n = 0; n < s; n++) i = e[n].split("="), (t = _[i.shift()]) && (r = t(r, i));
                for (n = 0; n < o; n++) r = S[n](r);
                return r
            }(e), l = a.autoCallback;
            a.url.split(".").pop().split("?").shift(), a.bypass || (t && (t = i(t) ? t : t[e] || t[r] || t[e.split("/").pop().split("?")[0]]), a.instead ? a.instead(e, t, o, r, s) : ($[a.url] ? a.noexec = !0 : $[a.url] = 1, o.load(a.url, a.forceCSS || !a.forceJS && "css" == a.url.split(".").pop().split("?").shift() ? "c" : n, a.noexec, a.attrs, a.timeout), (i(t) || i(l)) && o.load(function () {
                d(), t && t(a.origUrl, s, r), l && l(a.origUrl, s, r), $[a.url] = 2
            })))
        }

        function s(e, n) {
            function s(e, r) {
                if (e) {
                    if (o(e)) r || (u = function () {
                        var e = [].slice.call(arguments);
                        p.apply(this, e), f()
                    }), t(e, u, n, 0, c); else if (Object(e) === e) for (l in a = function () {
                        var t, n = 0;
                        for (t in e) e.hasOwnProperty(t) && n++;
                        return n
                    }(), e) e.hasOwnProperty(l) && (!r && !--a && (i(u) ? u = function () {
                        var e = [].slice.call(arguments);
                        p.apply(this, e), f()
                    } : u[l] = function (e) {
                        return function () {
                            var t = [].slice.call(arguments);
                            e && e.apply(this, t), f()
                        }
                    }(p[l])), t(e[l], u, n, l, c))
                } else !r && f()
            }

            var a, l, c = !!e.test, d = e.load || e.both, u = e.callback || r, p = u, f = e.complete || r;
            s(c ? e.yep : e.nope, !!d), d && s(d)
        }

        var a, l, c = this.yepnope.loader;
        if (o(e)) t(e, 0, c, 0); else if (T(e)) for (a = 0; a < e.length; a++) o(l = e[a]) ? t(l, 0, c, 0) : T(l) ? p(l) : Object(l) === l && s(l, c); else Object(e) === e && s(e, c)
    }).addPrefix = function (e, t) {
        _[e] = t
    }, p.addFilter = function (e) {
        S.push(e)
    }, p.errorTimeout = 1e4, null == t.readyState && t.addEventListener && (t.readyState = "loading", t.addEventListener("DOMContentLoaded", u = function () {
        t.removeEventListener("DOMContentLoaded", u, 0), t.readyState = "complete"
    }, 0)), e.yepnope = d(), e.yepnope.executeStack = a, e.yepnope.injectJs = function (e, n, i, o, l, c) {
        var d, u, f = t.createElement("script");
        o = o || p.errorTimeout;
        for (u in f.src = e, i) f.setAttribute(u, i[u]);
        n = c ? a : n || r, f.onreadystatechange = f.onload = function () {
            !d && s(f.readyState) && (d = 1, n(), f.onload = f.onreadystatechange = null)
        }, h(function () {
            d || (d = 1, n(1))
        }, o), l ? f.onload() : m.parentNode.insertBefore(f, m)
    }, e.yepnope.injectCss = function (e, n, i, o, s, l) {
        var c;
        o = t.createElement("link"), n = l ? a : n || r;
        for (c in o.href = e, o.rel = "stylesheet", o.type = "text/css", i) o.setAttribute(c, i[c]);
        s || (m.parentNode.insertBefore(o, m), h(n, 0))
    }
}(this, document), Modernizr.load = function () {
    yepnope.apply(window, [].slice.call(arguments, 0))
}, jQuery.easing.jswing = jQuery.easing.swing, jQuery.extend(jQuery.easing, {
    def: "easeOutQuad", swing: function (e, t, n, i, o) {
        return jQuery.easing[jQuery.easing.def](e, t, n, i, o)
    }, easeInQuad: function (e, t, n, i, o) {
        return i * (t /= o) * t + n
    }, easeOutQuad: function (e, t, n, i, o) {
        return -i * (t /= o) * (t - 2) + n
    }, easeInOutQuad: function (e, t, n, i, o) {
        return (t /= o / 2) < 1 ? i / 2 * t * t + n : -i / 2 * (--t * (t - 2) - 1) + n
    }, easeInCubic: function (e, t, n, i, o) {
        return i * (t /= o) * t * t + n
    }, easeOutCubic: function (e, t, n, i, o) {
        return i * ((t = t / o - 1) * t * t + 1) + n
    }, easeInOutCubic: function (e, t, n, i, o) {
        return (t /= o / 2) < 1 ? i / 2 * t * t * t + n : i / 2 * ((t -= 2) * t * t + 2) + n
    }, easeInQuart: function (e, t, n, i, o) {
        return i * (t /= o) * t * t * t + n
    }, easeOutQuart: function (e, t, n, i, o) {
        return -i * ((t = t / o - 1) * t * t * t - 1) + n
    }, easeInOutQuart: function (e, t, n, i, o) {
        return (t /= o / 2) < 1 ? i / 2 * t * t * t * t + n : -i / 2 * ((t -= 2) * t * t * t - 2) + n
    }, easeInQuint: function (e, t, n, i, o) {
        return i * (t /= o) * t * t * t * t + n
    }, easeOutQuint: function (e, t, n, i, o) {
        return i * ((t = t / o - 1) * t * t * t * t + 1) + n
    }, easeInOutQuint: function (e, t, n, i, o) {
        return (t /= o / 2) < 1 ? i / 2 * t * t * t * t * t + n : i / 2 * ((t -= 2) * t * t * t * t + 2) + n
    }, easeInSine: function (e, t, n, i, o) {
        return -i * Math.cos(t / o * (Math.PI / 2)) + i + n
    }, easeOutSine: function (e, t, n, i, o) {
        return i * Math.sin(t / o * (Math.PI / 2)) + n
    }, easeInOutSine: function (e, t, n, i, o) {
        return -i / 2 * (Math.cos(Math.PI * t / o) - 1) + n
    }, easeInExpo: function (e, t, n, i, o) {
        return 0 == t ? n : i * Math.pow(2, 10 * (t / o - 1)) + n
    }, easeOutExpo: function (e, t, n, i, o) {
        return t == o ? n + i : i * (1 - Math.pow(2, -10 * t / o)) + n
    }, easeInOutExpo: function (e, t, n, i, o) {
        return 0 == t ? n : t == o ? n + i : (t /= o / 2) < 1 ? i / 2 * Math.pow(2, 10 * (t - 1)) + n : i / 2 * (2 - Math.pow(2, -10 * --t)) + n
    }, easeInCirc: function (e, t, n, i, o) {
        return -i * (Math.sqrt(1 - (t /= o) * t) - 1) + n
    }, easeOutCirc: function (e, t, n, i, o) {
        return i * Math.sqrt(1 - (t = t / o - 1) * t) + n
    }, easeInOutCirc: function (e, t, n, i, o) {
        return (t /= o / 2) < 1 ? -i / 2 * (Math.sqrt(1 - t * t) - 1) + n : i / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + n
    }, easeInElastic: function (e, t, n, i, o) {
        var r = 1.70158, s = 0, a = i;
        if (0 == t) return n;
        if (1 == (t /= o)) return n + i;
        if (s || (s = .3 * o), a < Math.abs(i)) {
            a = i;
            r = s / 4
        } else r = s / (2 * Math.PI) * Math.asin(i / a);
        return -a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * o - r) * (2 * Math.PI) / s) + n
    }, easeOutElastic: function (e, t, n, i, o) {
        var r = 1.70158, s = 0, a = i;
        if (0 == t) return n;
        if (1 == (t /= o)) return n + i;
        if (s || (s = .3 * o), a < Math.abs(i)) {
            a = i;
            r = s / 4
        } else r = s / (2 * Math.PI) * Math.asin(i / a);
        return a * Math.pow(2, -10 * t) * Math.sin((t * o - r) * (2 * Math.PI) / s) + i + n
    }, easeInOutElastic: function (e, t, n, i, o) {
        var r = 1.70158, s = 0, a = i;
        if (0 == t) return n;
        if (2 == (t /= o / 2)) return n + i;
        if (s || (s = o * (.3 * 1.5)), a < Math.abs(i)) {
            a = i;
            r = s / 4
        } else r = s / (2 * Math.PI) * Math.asin(i / a);
        return t < 1 ? a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * o - r) * (2 * Math.PI) / s) * -.5 + n : a * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * o - r) * (2 * Math.PI) / s) * .5 + i + n
    }, easeInBack: function (e, t, n, i, o, r) {
        return null == r && (r = 1.70158), i * (t /= o) * t * ((r + 1) * t - r) + n
    }, easeOutBack: function (e, t, n, i, o, r) {
        return null == r && (r = 1.70158), i * ((t = t / o - 1) * t * ((r + 1) * t + r) + 1) + n
    }, easeInOutBack: function (e, t, n, i, o, r) {
        return null == r && (r = 1.70158), (t /= o / 2) < 1 ? i / 2 * (t * t * ((1 + (r *= 1.525)) * t - r)) + n : i / 2 * ((t -= 2) * t * ((1 + (r *= 1.525)) * t + r) + 2) + n
    }, easeInBounce: function (e, t, n, i, o) {
        return i - jQuery.easing.easeOutBounce(e, o - t, 0, i, o) + n
    }, easeOutBounce: function (e, t, n, i, o) {
        return (t /= o) < 1 / 2.75 ? i * (7.5625 * t * t) + n : t < 2 / 2.75 ? i * (7.5625 * (t -= 1.5 / 2.75) * t + .75) + n : t < 2.5 / 2.75 ? i * (7.5625 * (t -= 2.25 / 2.75) * t + .9375) + n : i * (7.5625 * (t -= 2.625 / 2.75) * t + .984375) + n
    }, easeInOutBounce: function (e, t, n, i, o) {
        return t < o / 2 ? .5 * jQuery.easing.easeInBounce(e, 2 * t, 0, i, o) + n : .5 * jQuery.easing.easeOutBounce(e, 2 * t - o, 0, i, o) + .5 * i + n
    }
}), function (e, t, n, i) {
    "use strict";

    function o(t, i) {
        if (this.el = t, this.$el = e(t), this.s = e.extend({}, r, i), this.s.dynamic && "undefined" !== this.s.dynamicEl && this.s.dynamicEl.constructor === Array && !this.s.dynamicEl.length) throw"When using dynamic mode, you must also define dynamicEl as an Array.";
        return this.modules = {}, this.lGalleryOn = !1, this.lgBusy = !1, this.hideBartimeout = !1, this.isTouch = "ontouchstart" in n.documentElement, this.s.slideEndAnimatoin && (this.s.hideControlOnEnd = !1), this.s.dynamic ? this.$items = this.s.dynamicEl : "this" === this.s.selector ? this.$items = this.$el : "" !== this.s.selector ? this.s.selectWithin ? this.$items = e(this.s.selectWithin).find(this.s.selector) : this.$items = this.$el.find(e(this.s.selector)) : this.$items = this.$el.children(), this.$slide = "", this.$outer = "", this.init(), this
    }

    var r = {
        mode: "lg-slide",
        cssEasing: "ease",
        easing: "linear",
        speed: 600,
        height: "100%",
        width: "100%",
        addClass: "",
        startClass: "lg-start-zoom",
        backdropDuration: 150,
        hideBarsDelay: 6e3,
        useLeft: !1,
        closable: !0,
        loop: !0,
        escKey: !0,
        keyPress: !0,
        controls: !0,
        slideEndAnimatoin: !0,
        hideControlOnEnd: !1,
        mousewheel: !0,
        getCaptionFromTitleOrAlt: !0,
        appendSubHtmlTo: ".lg-sub-html",
        subHtmlSelectorRelative: !1,
        preload: 1,
        showAfterLoad: !0,
        selector: "",
        selectWithin: "",
        nextHtml: "",
        prevHtml: "",
        index: !1,
        iframeMaxWidth: "100%",
        download: !0,
        counter: !0,
        appendCounterTo: ".lg-toolbar",
        swipeThreshold: 50,
        enableSwipe: !0,
        enableDrag: !0,
        dynamic: !1,
        dynamicEl: [],
        galleryId: 1
    };
    o.prototype.init = function () {
        var n = this;
        n.s.preload > n.$items.length && (n.s.preload = n.$items.length);
        var i = t.location.hash;
        i.indexOf("lg=" + this.s.galleryId) > 0 && (n.index = parseInt(i.split("&slide=")[1], 10), e("body").addClass("lg-from-hash"), e("body").hasClass("lg-on") || (setTimeout(function () {
            n.build(n.index)
        }), e("body").addClass("lg-on"))), n.s.dynamic ? (n.$el.trigger("onBeforeOpen.lg"), n.index = n.s.index || 0, e("body").hasClass("lg-on") || setTimeout(function () {
            n.build(n.index), e("body").addClass("lg-on")
        })) : n.$items.on("click.lgcustom", function (t) {
            try {
                t.preventDefault(), t.preventDefault()
            } catch (e) {
                t.returnValue = !1
            }
            n.$el.trigger("onBeforeOpen.lg"), n.index = n.s.index || n.$items.index(this), e("body").hasClass("lg-on") || (n.build(n.index), e("body").addClass("lg-on"))
        })
    }, o.prototype.build = function (t) {
        var n = this;
        n.structure(), e.each(e.fn.lightGallery.modules, function (t) {
            n.modules[t] = new e.fn.lightGallery.modules[t](n.el)
        }), n.slide(t, !1, !1), n.s.keyPress && n.keyPress(), n.$items.length > 1 && (n.arrow(), setTimeout(function () {
            n.enableDrag(), n.enableSwipe()
        }, 50), n.s.mousewheel && n.mousewheel()), n.counter(), n.closeGallery(), n.$el.trigger("onAfterOpen.lg"), n.$outer.on("mousemove.lg click.lg touchstart.lg", function () {
            n.$outer.removeClass("lg-hide-items"), clearTimeout(n.hideBartimeout), n.hideBartimeout = setTimeout(function () {
                n.$outer.addClass("lg-hide-items")
            }, n.s.hideBarsDelay)
        })
    }, o.prototype.structure = function () {
        var n, i = "", o = "", r = 0, s = "", a = this;
        for (e("body").append('<div class="lg-backdrop"></div>'), e(".lg-backdrop").css("transition-duration", this.s.backdropDuration + "ms"), r = 0; r < this.$items.length; r++) i += '<div class="lg-item"></div>';
        if (this.s.controls && this.$items.length > 1 && (o = '<div class="lg-actions"><div class="lg-prev lg-icon">' + this.s.prevHtml + '</div><div class="lg-next lg-icon">' + this.s.nextHtml + "</div></div>"), ".lg-sub-html" === this.s.appendSubHtmlTo && (s = '<div class="lg-sub-html"></div>'), n = '<div class="lg-outer ' + this.s.addClass + " " + this.s.startClass + '"><div class="lg" style="width:' + this.s.width + "; height:" + this.s.height + '"><div class="lg-inner">' + i + '</div><div class="lg-toolbar group"><span class="lg-close lg-icon"></span></div>' + o + s + "</div></div>", e("body").append(n), this.$outer = e(".lg-outer"), this.$slide = this.$outer.find(".lg-item"), this.s.useLeft ? (this.$outer.addClass("lg-use-left"), this.s.mode = "lg-slide") : this.$outer.addClass("lg-use-css3"), a.setTop(), e(t).on("resize.lg orientationchange.lg", function () {
            setTimeout(function () {
                a.setTop()
            }, 100)
        }), this.$slide.eq(this.index).addClass("lg-current"), this.doCss() ? this.$outer.addClass("lg-css3") : (this.$outer.addClass("lg-css"), this.s.speed = 0), this.$outer.addClass(this.s.mode), this.s.enableDrag && this.$items.length > 1 && this.$outer.addClass("lg-grab"), this.s.showAfterLoad && this.$outer.addClass("lg-show-after-load"), this.doCss()) {
            var l = this.$outer.find(".lg-inner");
            l.css("transition-timing-function", this.s.cssEasing), l.css("transition-duration", this.s.speed + "ms")
        }
        e(".lg-backdrop").addClass("in"), setTimeout(function () {
            a.$outer.addClass("lg-visible")
        }, this.s.backdropDuration), this.s.download && this.$outer.find(".lg-toolbar").append('<a id="lg-download" target="_blank" download class="lg-download lg-icon"></a>'), this.prevScrollTop = e(t).scrollTop()
    }, o.prototype.setTop = function () {
        if ("100%" !== this.s.height) {
            var n = e(t).height(), i = (n - parseInt(this.s.height, 10)) / 2, o = this.$outer.find(".lg");
            n >= parseInt(this.s.height, 10) ? o.css("top", i + "px") : o.css("top", "0px")
        }
    }, o.prototype.doCss = function () {
        return !!function () {
            var e = ["transition", "MozTransition", "WebkitTransition", "OTransition", "msTransition", "KhtmlTransition"],
                t = n.documentElement, i = 0;
            for (i = 0; i < e.length; i++) if (e[i] in t.style) return !0
        }()
    }, o.prototype.isVideo = function (e, t) {
        var n;
        if (n = this.s.dynamic ? this.s.dynamicEl[t].html : this.$items.eq(t).attr("data-html"), !e && n) return {html5: !0};
        var i = e.match(/\/\/(?:www\.)?youtu(?:\.be|be\.com)\/(?:watch\?v=|embed\/)?([a-z0-9\-\_\%]+)/i),
            o = e.match(/\/\/(?:www\.)?vimeo.com\/([0-9a-z\-_]+)/i),
            r = e.match(/\/\/(?:www\.)?dai.ly\/([0-9a-z\-_]+)/i),
            s = e.match(/\/\/(?:www\.)?(?:vk\.com|vkontakte\.ru)\/(?:video_ext\.php\?)(.*)/i);
        return i ? {youtube: i} : o ? {vimeo: o} : r ? {dailymotion: r} : s ? {vk: s} : void 0
    }, o.prototype.counter = function () {
        this.s.counter && e(this.s.appendCounterTo).append('<div id="lg-counter"><span id="lg-counter-current">' + (parseInt(this.index, 10) + 1) + '</span> / <span id="lg-counter-all">' + this.$items.length + "</span></div>")
    }, o.prototype.addHtml = function (t) {
        var n, i, o = null;
        if (this.s.dynamic ? this.s.dynamicEl[t].subHtmlUrl ? n = this.s.dynamicEl[t].subHtmlUrl : o = this.s.dynamicEl[t].subHtml : (i = this.$items.eq(t)).attr("data-sub-html-url") ? n = i.attr("data-sub-html-url") : (o = i.attr("data-sub-html"), this.s.getCaptionFromTitleOrAlt && !o && (o = i.attr("title") || i.find("img").first().attr("alt"))), !n) if (null != o) {
            var r = o.substring(0, 1);
            "." !== r && "#" !== r || (o = this.s.subHtmlSelectorRelative && !this.s.dynamic ? i.find(o).html() : e(o).html())
        } else o = "";
        ".lg-sub-html" === this.s.appendSubHtmlTo ? n ? this.$outer.find(this.s.appendSubHtmlTo).load(n) : this.$outer.find(this.s.appendSubHtmlTo).html(o) : n ? this.$slide.eq(t).load(n) : this.$slide.eq(t).append(o), null != o && ("" === o ? this.$outer.find(this.s.appendSubHtmlTo).addClass("lg-empty-html") : this.$outer.find(this.s.appendSubHtmlTo).removeClass("lg-empty-html")), this.$el.trigger("onAfterAppendSubHtml.lg", [t])
    }, o.prototype.preload = function (e) {
        var t = 1, n = 1;
        for (t = 1; t <= this.s.preload && !(t >= this.$items.length - e); t++) this.loadContent(e + t, !1, 0);
        for (n = 1; n <= this.s.preload && !(e - n < 0); n++) this.loadContent(e - n, !1, 0)
    }, o.prototype.loadContent = function (n, i, o) {
        var r, s, a, l, c, d, u = this, p = !1, f = function (n) {
            for (var i = [], o = [], r = 0; r < n.length; r++) {
                var a = n[r].split(" ");
                "" === a[0] && a.splice(0, 1), o.push(a[0]), i.push(a[1])
            }
            for (var l = e(t).width(), c = 0; c < i.length; c++) if (parseInt(i[c], 10) > l) {
                s = o[c];
                break
            }
        };
        if (u.s.dynamic) {
            if (u.s.dynamicEl[n].poster && (p = !0, a = u.s.dynamicEl[n].poster), d = u.s.dynamicEl[n].html, s = u.s.dynamicEl[n].src, u.s.dynamicEl[n].responsive) f(u.s.dynamicEl[n].responsive.split(","));
            l = u.s.dynamicEl[n].srcset, c = u.s.dynamicEl[n].sizes
        } else {
            if (u.$items.eq(n).attr("data-poster") && (p = !0, a = u.$items.eq(n).attr("data-poster")), d = u.$items.eq(n).attr("data-html"), s = u.$items.eq(n).attr("href") || u.$items.eq(n).attr("data-src"), u.$items.eq(n).attr("data-responsive")) f(u.$items.eq(n).attr("data-responsive").split(","));
            l = u.$items.eq(n).attr("data-srcset"), c = u.$items.eq(n).attr("data-sizes")
        }
        var h = !1;
        u.s.dynamic ? u.s.dynamicEl[n].iframe && (h = !0) : "true" === u.$items.eq(n).attr("data-iframe") && (h = !0);
        var m = u.isVideo(s, n);
        if (!u.$slide.eq(n).hasClass("lg-loaded")) {
            if (h) u.$slide.eq(n).prepend('<div class="lg-video-cont" style="max-width:' + u.s.iframeMaxWidth + '"><div class="lg-video"><iframe class="lg-object" frameborder="0" src="' + s + '"  allowfullscreen="true"></iframe></div></div>'); else if (p) {
                var v;
                v = m && m.youtube ? "lg-has-youtube" : m && m.vimeo ? "lg-has-vimeo" : "lg-has-html5", u.$slide.eq(n).prepend('<div class="lg-video-cont ' + v + ' "><div class="lg-video"><span class="lg-video-play"></span><img class="lg-object lg-has-poster" src="' + a + '" /></div></div>')
            } else m ? (u.$slide.eq(n).prepend('<div class="lg-video-cont "><div class="lg-video"></div></div>'), u.$el.trigger("hasVideo.lg", [n, s, d])) : u.$slide.eq(n).prepend('<div class="lg-img-wrap"><img class="lg-object lg-image" src="' + s + '" /></div>');
            if (u.$el.trigger("onAferAppendSlide.lg", [n]), r = u.$slide.eq(n).find(".lg-object"), c && r.attr("sizes", c), l) {
                r.attr("srcset", l);
                try {
                    picturefill({elements: [r[0]]})
                } catch (e) {
                    console.error("Make sure you have included Picturefill version 2")
                }
            }
            ".lg-sub-html" !== this.s.appendSubHtmlTo && u.addHtml(n), u.$slide.eq(n).addClass("lg-loaded")
        }
        u.$slide.eq(n).find(".lg-object").on("load.lg error.lg", function () {
            var t = 0;
            o && !e("body").hasClass("lg-from-hash") && (t = o), setTimeout(function () {
                u.$slide.eq(n).addClass("lg-complete"), u.$el.trigger("onSlideItemLoad.lg", [n, o || 0])
            }, t)
        }), m && m.html5 && !p && u.$slide.eq(n).addClass("lg-complete"), !0 === i && (u.$slide.eq(n).hasClass("lg-complete") ? u.preload(n) : u.$slide.eq(n).find(".lg-object").on("load.lg error.lg", function () {
            u.preload(n)
        }))
    }, o.prototype.slide = function (t, n, i) {
        var o = this.$outer.find(".lg-current").index(), r = this;
        if (!r.lGalleryOn || o !== t) {
            var s = this.$slide.length, a = r.lGalleryOn ? this.s.speed : 0, l = !1, c = !1;
            if (!r.lgBusy) {
                var d;
                if (this.s.download) (d = r.s.dynamic ? !1 !== r.s.dynamicEl[t].downloadUrl && (r.s.dynamicEl[t].downloadUrl || r.s.dynamicEl[t].src) : "false" !== r.$items.eq(t).attr("data-download-url") && (r.$items.eq(t).attr("data-download-url") || r.$items.eq(t).attr("href") || r.$items.eq(t).attr("data-src"))) ? (e("#lg-download").attr("href", d), r.$outer.removeClass("lg-hide-download")) : r.$outer.addClass("lg-hide-download");
                if (this.$el.trigger("onBeforeSlide.lg", [o, t, n, i]), r.lgBusy = !0, clearTimeout(r.hideBartimeout), ".lg-sub-html" === this.s.appendSubHtmlTo && setTimeout(function () {
                    r.addHtml(t)
                }, a), this.arrowDisable(t), n) {
                    var u = t - 1, p = t + 1;
                    0 === t && o === s - 1 ? (p = 0, u = s - 1) : t === s - 1 && 0 === o && (p = 0, u = s - 1), this.$slide.removeClass("lg-prev-slide lg-current lg-next-slide"), r.$slide.eq(u).addClass("lg-prev-slide"), r.$slide.eq(p).addClass("lg-next-slide"), r.$slide.eq(t).addClass("lg-current")
                } else r.$outer.addClass("lg-no-trans"), this.$slide.removeClass("lg-prev-slide lg-next-slide"), t < o ? (c = !0, 0 !== t || o !== s - 1 || i || (c = !1, l = !0)) : t > o && (l = !0, t !== s - 1 || 0 !== o || i || (c = !0, l = !1)), c ? (this.$slide.eq(t).addClass("lg-prev-slide"), this.$slide.eq(o).addClass("lg-next-slide")) : l && (this.$slide.eq(t).addClass("lg-next-slide"), this.$slide.eq(o).addClass("lg-prev-slide")), setTimeout(function () {
                    r.$slide.removeClass("lg-current"), r.$slide.eq(t).addClass("lg-current"), r.$outer.removeClass("lg-no-trans")
                }, 50);
                r.lGalleryOn ? (setTimeout(function () {
                    r.loadContent(t, !0, 0)
                }, this.s.speed + 50), setTimeout(function () {
                    r.lgBusy = !1, r.$el.trigger("onAfterSlide.lg", [o, t, n, i])
                }, this.s.speed)) : (r.loadContent(t, !0, r.s.backdropDuration), r.lgBusy = !1, r.$el.trigger("onAfterSlide.lg", [o, t, n, i])), r.lGalleryOn = !0, this.s.counter && e("#lg-counter-current").text(t + 1)
            }
        }
    }, o.prototype.goToNextSlide = function (e) {
        var t = this;
        t.lgBusy || (t.index + 1 < t.$slide.length ? (t.index++, t.$el.trigger("onBeforeNextSlide.lg", [t.index]), t.slide(t.index, e, !1)) : t.s.loop ? (t.index = 0, t.$el.trigger("onBeforeNextSlide.lg", [t.index]), t.slide(t.index, e, !1)) : t.s.slideEndAnimatoin && (t.$outer.addClass("lg-right-end"), setTimeout(function () {
            t.$outer.removeClass("lg-right-end")
        }, 400)))
    }, o.prototype.goToPrevSlide = function (e) {
        var t = this;
        t.lgBusy || (t.index > 0 ? (t.index--, t.$el.trigger("onBeforePrevSlide.lg", [t.index, e]), t.slide(t.index, e, !1)) : t.s.loop ? (t.index = t.$items.length - 1, t.$el.trigger("onBeforePrevSlide.lg", [t.index, e]), t.slide(t.index, e, !1)) : t.s.slideEndAnimatoin && (t.$outer.addClass("lg-left-end"), setTimeout(function () {
            t.$outer.removeClass("lg-left-end")
        }, 400)))
    }, o.prototype.keyPress = function () {
        var n = this;
        this.$items.length > 1 && e(t).on("keyup.lg", function (e) {
            n.$items.length > 1 && (37 === e.keyCode && (e.preventDefault(), n.goToPrevSlide()), 39 === e.keyCode && (e.preventDefault(), n.goToNextSlide()))
        }), e(t).on("keydown.lg", function (e) {
            !0 === n.s.escKey && 27 === e.keyCode && (e.preventDefault(), n.$outer.hasClass("lg-thumb-open") ? n.$outer.removeClass("lg-thumb-open") : n.destroy())
        })
    }, o.prototype.arrow = function () {
        var e = this;
        this.$outer.find(".lg-prev").on("click.lg", function () {
            e.goToPrevSlide()
        }), this.$outer.find(".lg-next").on("click.lg", function () {
            e.goToNextSlide()
        })
    }, o.prototype.arrowDisable = function (e) {
        !this.s.loop && this.s.hideControlOnEnd && (e + 1 < this.$slide.length ? this.$outer.find(".lg-next").removeAttr("disabled").removeClass("disabled") : this.$outer.find(".lg-next").attr("disabled", "disabled").addClass("disabled"), e > 0 ? this.$outer.find(".lg-prev").removeAttr("disabled").removeClass("disabled") : this.$outer.find(".lg-prev").attr("disabled", "disabled").addClass("disabled"))
    }, o.prototype.setTranslate = function (e, t, n) {
        this.s.useLeft ? e.css("left", t) : e.css({transform: "translate3d(" + t + "px, " + n + "px, 0px)"})
    }, o.prototype.touchMove = function (t, n) {
        var i = n - t;
        Math.abs(i) > 15 && (this.$outer.addClass("lg-dragging"), this.setTranslate(this.$slide.eq(this.index), i, 0), this.setTranslate(e(".lg-prev-slide"), -this.$slide.eq(this.index).width() + i, 0), this.setTranslate(e(".lg-next-slide"), this.$slide.eq(this.index).width() + i, 0))
    }, o.prototype.touchEnd = function (e) {
        var t = this;
        "lg-slide" !== t.s.mode && t.$outer.addClass("lg-slide"), this.$slide.not(".lg-current, .lg-prev-slide, .lg-next-slide").css("opacity", "0"), setTimeout(function () {
            t.$outer.removeClass("lg-dragging"), e < 0 && Math.abs(e) > t.s.swipeThreshold ? t.goToNextSlide(!0) : e > 0 && Math.abs(e) > t.s.swipeThreshold ? t.goToPrevSlide(!0) : Math.abs(e) < 5 && t.$el.trigger("onSlideClick.lg"), t.$slide.removeAttr("style")
        }), setTimeout(function () {
            t.$outer.hasClass("lg-dragging") || "lg-slide" === t.s.mode || t.$outer.removeClass("lg-slide")
        }, t.s.speed + 100)
    }, o.prototype.enableSwipe = function () {
        var e = this, t = 0, n = 0, i = !1;
        e.s.enableSwipe && e.isTouch && e.doCss() && (e.$slide.on("touchstart.lg", function (n) {
            e.$outer.hasClass("lg-zoomed") || e.lgBusy || (n.preventDefault(), e.manageSwipeClass(), t = n.originalEvent.targetTouches[0].pageX)
        }), e.$slide.on("touchmove.lg", function (o) {
            e.$outer.hasClass("lg-zoomed") || (o.preventDefault(), n = o.originalEvent.targetTouches[0].pageX, e.touchMove(t, n), i = !0)
        }), e.$slide.on("touchend.lg", function () {
            e.$outer.hasClass("lg-zoomed") || (i ? (i = !1, e.touchEnd(n - t)) : e.$el.trigger("onSlideClick.lg"))
        }))
    }, o.prototype.enableDrag = function () {
        var n = this, i = 0, o = 0, r = !1, s = !1;
        n.s.enableDrag && !n.isTouch && n.doCss() && (n.$slide.on("mousedown.lg", function (t) {
            n.$outer.hasClass("lg-zoomed") || (e(t.target).hasClass("lg-object") || e(t.target).hasClass("lg-video-play")) && (t.preventDefault(), n.lgBusy || (n.manageSwipeClass(), i = t.pageX, r = !0, n.$outer.scrollLeft += 1, n.$outer.scrollLeft -= 1, n.$outer.removeClass("lg-grab").addClass("lg-grabbing"), n.$el.trigger("onDragstart.lg")))
        }), e(t).on("mousemove.lg", function (e) {
            r && (s = !0, o = e.pageX, n.touchMove(i, o), n.$el.trigger("onDragmove.lg"))
        }), e(t).on("mouseup.lg", function (t) {
            s ? (s = !1, n.touchEnd(o - i), n.$el.trigger("onDragend.lg")) : (e(t.target).hasClass("lg-object") || e(t.target).hasClass("lg-video-play")) && n.$el.trigger("onSlideClick.lg"), r && (r = !1, n.$outer.removeClass("lg-grabbing").addClass("lg-grab"))
        }))
    }, o.prototype.manageSwipeClass = function () {
        var e = this.index + 1, t = this.index - 1, n = this.$slide.length;
        this.s.loop && (0 === this.index ? t = n - 1 : this.index === n - 1 && (e = 0)), this.$slide.removeClass("lg-next-slide lg-prev-slide"), t > -1 && this.$slide.eq(t).addClass("lg-prev-slide"), this.$slide.eq(e).addClass("lg-next-slide")
    }, o.prototype.mousewheel = function () {
        var e = this;
        e.$outer.on("mousewheel.lg", function (t) {
            t.deltaY && (t.deltaY > 0 ? e.goToPrevSlide() : e.goToNextSlide(), t.preventDefault())
        })
    }, o.prototype.closeGallery = function () {
        var t = this, n = !1;
        this.$outer.find(".lg-close").on("click.lg", function () {
            t.destroy()
        }), t.s.closable && (t.$outer.on("mousedown.lg", function (t) {
            n = !!(e(t.target).is(".lg-outer") || e(t.target).is(".lg-item ") || e(t.target).is(".lg-img-wrap"))
        }), t.$outer.on("mouseup.lg", function (i) {
            (e(i.target).is(".lg-outer") || e(i.target).is(".lg-item ") || e(i.target).is(".lg-img-wrap") && n) && (t.$outer.hasClass("lg-dragging") || t.destroy())
        }))
    }, o.prototype.destroy = function (n) {
        var i = this;
        n || i.$el.trigger("onBeforeClose.lg"), e(t).scrollTop(i.prevScrollTop), n && (i.s.dynamic || this.$items.off("click.lg click.lgcustom"), e.removeData(i.el, "lightGallery")), this.$el.off(".lg.tm"), e.each(e.fn.lightGallery.modules, function (e) {
            i.modules[e] && i.modules[e].destroy()
        }), this.lGalleryOn = !1, clearTimeout(i.hideBartimeout), this.hideBartimeout = !1, e(t).off(".lg"), e("body").removeClass("lg-on lg-from-hash"), i.$outer && i.$outer.removeClass("lg-visible"), e(".lg-backdrop").removeClass("in"), setTimeout(function () {
            i.$outer && i.$outer.remove(), e(".lg-backdrop").remove(), n || i.$el.trigger("onCloseAfter.lg")
        }, i.s.backdropDuration + 50)
    }, e.fn.lightGallery = function (t) {
        return this.each(function () {
            if (e.data(this, "lightGallery")) try {
                e(this).data("lightGallery").init()
            } catch (e) {
                console.error("lightGallery has not initiated properly")
            } else e.data(this, "lightGallery", new o(this, t))
        })
    }, e.fn.lightGallery.modules = {}
}(jQuery, window, document), function (e, t) {
    "function" == typeof define && define.amd ? define(["jquery"], function (e) {
        return t(e)
    }) : "object" == typeof exports ? module.exports = t(require("jquery")) : t(jQuery)
}(0, function (e) {
    !function () {
        "use strict";
        var t = {
            scale: 1, zoom: !0, actualSize: !0, enableZoomAfter: 300, useLeftForZoom: function () {
                var e = !1, t = navigator.userAgent.match(/Chrom(e|ium)\/([0-9]+)\./);
                return t && parseInt(t[2], 10) < 54 && (e = !0), e
            }()
        }, n = function (n) {
            return this.core = e(n).data("lightGallery"), this.core.s = e.extend({}, t, this.core.s), this.core.s.zoom && this.core.doCss() && (this.init(), this.zoomabletimeout = !1, this.pageX = e(window).width() / 2, this.pageY = e(window).height() / 2 + e(window).scrollTop()), this
        };
        n.prototype.init = function () {
            var t = this,
                n = '<span id="lg-zoom-in" class="lg-icon"></span><span id="lg-zoom-out" class="lg-icon"></span>';
            t.core.s.actualSize && (n += '<span id="lg-actual-size" class="lg-icon"></span>'), t.core.s.useLeftForZoom ? t.core.$outer.addClass("lg-use-left-for-zoom") : t.core.$outer.addClass("lg-use-transition-for-zoom"), this.core.$outer.find(".lg-toolbar").append(n), t.core.$el.on("onSlideItemLoad.lg.tm.zoom", function (n, i, o) {
                var r = t.core.s.enableZoomAfter + o;
                e("body").hasClass("lg-from-hash") && o ? r = 0 : e("body").removeClass("lg-from-hash"), t.zoomabletimeout = setTimeout(function () {
                    t.core.$slide.eq(i).addClass("lg-zoomable")
                }, r + 30)
            });
            var i = 1, o = function (n) {
                var i = t.core.$outer.find(".lg-current .lg-image"),
                    o = (e(window).width() - i.prop("offsetWidth")) / 2,
                    r = (e(window).height() - i.prop("offsetHeight")) / 2 + e(window).scrollTop(),
                    s = (n - 1) * (t.pageX - o), a = (n - 1) * (t.pageY - r);
                i.css("transform", "scale3d(" + n + ", " + n + ", 1)").attr("data-scale", n), t.core.s.useLeftForZoom ? i.parent().css({
                    left: -s + "px",
                    top: -a + "px"
                }).attr("data-x", s).attr("data-y", a) : i.parent().css("transform", "translate3d(-" + s + "px, -" + a + "px, 0)").attr("data-x", s).attr("data-y", a)
            }, r = function () {
                i > 1 ? t.core.$outer.addClass("lg-zoomed") : t.resetZoom(), i < 1 && (i = 1), o(i)
            }, s = function (n, o, s, a) {
                var l, c = o.prop("offsetWidth");
                l = t.core.s.dynamic ? t.core.s.dynamicEl[s].width || o[0].naturalWidth || c : t.core.$items.eq(s).attr("data-width") || o[0].naturalWidth || c, t.core.$outer.hasClass("lg-zoomed") ? i = 1 : l > c && (i = l / c || 2), a ? (t.pageX = e(window).width() / 2, t.pageY = e(window).height() / 2 + e(window).scrollTop()) : (t.pageX = n.pageX || n.originalEvent.targetTouches[0].pageX, t.pageY = n.pageY || n.originalEvent.targetTouches[0].pageY), r(), setTimeout(function () {
                    t.core.$outer.removeClass("lg-grabbing").addClass("lg-grab")
                }, 10)
            }, a = !1;
            t.core.$el.on("onAferAppendSlide.lg.tm.zoom", function (e, n) {
                var i = t.core.$slide.eq(n).find(".lg-image");
                i.on("dblclick", function (e) {
                    s(e, i, n)
                }), i.on("touchstart", function (e) {
                    a ? (clearTimeout(a), a = null, s(e, i, n)) : a = setTimeout(function () {
                        a = null
                    }, 300), e.preventDefault()
                })
            }), e(window).on("resize.lg.zoom scroll.lg.zoom orientationchange.lg.zoom", function () {
                t.pageX = e(window).width() / 2, t.pageY = e(window).height() / 2 + e(window).scrollTop(), o(i)
            }), e("#lg-zoom-out").on("click.lg", function () {
                t.core.$outer.find(".lg-current .lg-image").length && (i -= t.core.s.scale, r())
            }), e("#lg-zoom-in").on("click.lg", function () {
                t.core.$outer.find(".lg-current .lg-image").length && (i += t.core.s.scale, r())
            }), e("#lg-actual-size").on("click.lg", function (e) {
                s(e, t.core.$slide.eq(t.core.index).find(".lg-image"), t.core.index, !0)
            }), t.core.$el.on("onBeforeSlide.lg.tm", function () {
                i = 1, t.resetZoom()
            }), t.core.isTouch || t.zoomDrag(), t.core.isTouch && t.zoomSwipe()
        }, n.prototype.resetZoom = function () {
            this.core.$outer.removeClass("lg-zoomed"), this.core.$slide.find(".lg-img-wrap").removeAttr("style data-x data-y"), this.core.$slide.find(".lg-image").removeAttr("style data-scale"), this.pageX = e(window).width() / 2, this.pageY = e(window).height() / 2 + e(window).scrollTop()
        }, n.prototype.zoomSwipe = function () {
            var e = this, t = {}, n = {}, i = !1, o = !1, r = !1;
            e.core.$slide.on("touchstart.lg", function (n) {
                if (e.core.$outer.hasClass("lg-zoomed")) {
                    var i = e.core.$slide.eq(e.core.index).find(".lg-object");
                    r = i.prop("offsetHeight") * i.attr("data-scale") > e.core.$outer.find(".lg").height(), ((o = i.prop("offsetWidth") * i.attr("data-scale") > e.core.$outer.find(".lg").width()) || r) && (n.preventDefault(), t = {
                        x: n.originalEvent.targetTouches[0].pageX,
                        y: n.originalEvent.targetTouches[0].pageY
                    })
                }
            }), e.core.$slide.on("touchmove.lg", function (s) {
                if (e.core.$outer.hasClass("lg-zoomed")) {
                    var a, l, c = e.core.$slide.eq(e.core.index).find(".lg-img-wrap");
                    s.preventDefault(), i = !0, n = {
                        x: s.originalEvent.targetTouches[0].pageX,
                        y: s.originalEvent.targetTouches[0].pageY
                    }, e.core.$outer.addClass("lg-zoom-dragging"), l = r ? -Math.abs(c.attr("data-y")) + (n.y - t.y) : -Math.abs(c.attr("data-y")), a = o ? -Math.abs(c.attr("data-x")) + (n.x - t.x) : -Math.abs(c.attr("data-x")), (Math.abs(n.x - t.x) > 15 || Math.abs(n.y - t.y) > 15) && (e.core.s.useLeftForZoom ? c.css({
                        left: a + "px",
                        top: l + "px"
                    }) : c.css("transform", "translate3d(" + a + "px, " + l + "px, 0)"))
                }
            }), e.core.$slide.on("touchend.lg", function () {
                e.core.$outer.hasClass("lg-zoomed") && i && (i = !1, e.core.$outer.removeClass("lg-zoom-dragging"), e.touchendZoom(t, n, o, r))
            })
        }, n.prototype.zoomDrag = function () {
            var t = this, n = {}, i = {}, o = !1, r = !1, s = !1, a = !1;
            t.core.$slide.on("mousedown.lg.zoom", function (i) {
                var r = t.core.$slide.eq(t.core.index).find(".lg-object");
                a = r.prop("offsetHeight") * r.attr("data-scale") > t.core.$outer.find(".lg").height(), s = r.prop("offsetWidth") * r.attr("data-scale") > t.core.$outer.find(".lg").width(), t.core.$outer.hasClass("lg-zoomed") && e(i.target).hasClass("lg-object") && (s || a) && (i.preventDefault(), n = {
                    x: i.pageX,
                    y: i.pageY
                }, o = !0, t.core.$outer.scrollLeft += 1, t.core.$outer.scrollLeft -= 1, t.core.$outer.removeClass("lg-grab").addClass("lg-grabbing"))
            }), e(window).on("mousemove.lg.zoom", function (e) {
                if (o) {
                    var l, c, d = t.core.$slide.eq(t.core.index).find(".lg-img-wrap");
                    r = !0, i = {
                        x: e.pageX,
                        y: e.pageY
                    }, t.core.$outer.addClass("lg-zoom-dragging"), c = a ? -Math.abs(d.attr("data-y")) + (i.y - n.y) : -Math.abs(d.attr("data-y")), l = s ? -Math.abs(d.attr("data-x")) + (i.x - n.x) : -Math.abs(d.attr("data-x")), t.core.s.useLeftForZoom ? d.css({
                        left: l + "px",
                        top: c + "px"
                    }) : d.css("transform", "translate3d(" + l + "px, " + c + "px, 0)")
                }
            }), e(window).on("mouseup.lg.zoom", function (e) {
                o && (o = !1, t.core.$outer.removeClass("lg-zoom-dragging"), !r || n.x === i.x && n.y === i.y || (i = {
                    x: e.pageX,
                    y: e.pageY
                }, t.touchendZoom(n, i, s, a)), r = !1), t.core.$outer.removeClass("lg-grabbing").addClass("lg-grab")
            })
        }, n.prototype.touchendZoom = function (e, t, n, i) {
            var o = this, r = o.core.$slide.eq(o.core.index).find(".lg-img-wrap"),
                s = o.core.$slide.eq(o.core.index).find(".lg-object"), a = -Math.abs(r.attr("data-x")) + (t.x - e.x),
                l = -Math.abs(r.attr("data-y")) + (t.y - e.y),
                c = (o.core.$outer.find(".lg").height() - s.prop("offsetHeight")) / 2,
                d = Math.abs(s.prop("offsetHeight") * Math.abs(s.attr("data-scale")) - o.core.$outer.find(".lg").height() + c),
                u = (o.core.$outer.find(".lg").width() - s.prop("offsetWidth")) / 2,
                p = Math.abs(s.prop("offsetWidth") * Math.abs(s.attr("data-scale")) - o.core.$outer.find(".lg").width() + u);
            (Math.abs(t.x - e.x) > 15 || Math.abs(t.y - e.y) > 15) && (i && (l <= -d ? l = -d : l >= -c && (l = -c)), n && (a <= -p ? a = -p : a >= -u && (a = -u)), i ? r.attr("data-y", Math.abs(l)) : l = -Math.abs(r.attr("data-y")), n ? r.attr("data-x", Math.abs(a)) : a = -Math.abs(r.attr("data-x")), o.core.s.useLeftForZoom ? r.css({
                left: a + "px",
                top: l + "px"
            }) : r.css("transform", "translate3d(" + a + "px, " + l + "px, 0)"))
        }, n.prototype.destroy = function () {
            var t = this;
            t.core.$el.off(".lg.zoom"), e(window).off(".lg.zoom"), t.core.$slide.off(".lg.zoom"), t.core.$el.off(".lg.tm.zoom"), t.resetZoom(), clearTimeout(t.zoomabletimeout), t.zoomabletimeout = !1
        }, e.fn.lightGallery.modules.zoom = n
    }()
}), function (e, t, n, i) {
    "use strict";
    var o = {
        videoMaxWidth: "855px",
        youtubePlayerParams: !1,
        vimeoPlayerParams: !1,
        dailymotionPlayerParams: !1,
        videojs: !1
    }, r = function (t) {
        return this.core = e(t).data("lightGallery"), this.$el = e(t), this.core.s = e.extend({}, o, this.core.s), this.videoLoaded = !1, this.init(), this
    };
    r.prototype.init = function () {
        var t = this;
        t.core.$el.on("hasVideo.lg.tm", function (e, n, i, o) {
            if (t.core.$slide.eq(n).find(".lg-video").append(t.loadVideo(i, "lg-object", !0, n, o)), o) if (t.core.s.videojs) try {
                videojs(t.core.$slide.eq(n).find(".lg-html5").get(0), {}, function () {
                    t.videoLoaded || this.play()
                })
            } catch (e) {
                console.error("Make sure you have included videojs")
            } else t.core.$slide.eq(n).find(".lg-html5").get(0).play()
        }), t.core.$el.on("onAferAppendSlide.lg.tm", function (e, n) {
            t.core.$slide.eq(n).find(".lg-video-cont").css("max-width", t.core.s.videoMaxWidth), t.videoLoaded = !0
        });
        var n = function (e) {
            if (e.find(".lg-object").hasClass("lg-has-poster") && e.find(".lg-object").is(":visible")) if (e.hasClass("lg-has-video")) {
                var n = e.find(".lg-youtube").get(0), i = e.find(".lg-vimeo").get(0),
                    o = e.find(".lg-dailymotion").get(0), r = e.find(".lg-html5").get(0);
                if (n) n.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', "*"); else if (i) try {
                    $f(i).api("play")
                } catch (e) {
                    console.error("Make sure you have included froogaloop2 js")
                } else if (o) o.contentWindow.postMessage("play", "*"); else if (r) if (t.core.s.videojs) try {
                    videojs(r).play()
                } catch (e) {
                    console.error("Make sure you have included videojs")
                } else r.play();
                e.addClass("lg-video-palying")
            } else {
                e.addClass("lg-video-palying lg-has-video");
                var s = function (n, i) {
                    if (e.find(".lg-video").append(t.loadVideo(n, "", !1, t.core.index, i)), i) if (t.core.s.videojs) try {
                        videojs(t.core.$slide.eq(t.core.index).find(".lg-html5").get(0), {}, function () {
                            this.play()
                        })
                    } catch (e) {
                        console.error("Make sure you have included videojs")
                    } else t.core.$slide.eq(t.core.index).find(".lg-html5").get(0).play()
                };
                t.core.s.dynamic ? s(t.core.s.dynamicEl[t.core.index].src, t.core.s.dynamicEl[t.core.index].html) : s(t.core.$items.eq(t.core.index).attr("href") || t.core.$items.eq(t.core.index).attr("data-src"), t.core.$items.eq(t.core.index).attr("data-html"));
                var a = e.find(".lg-object");
                e.find(".lg-video").append(a), e.find(".lg-video-object").hasClass("lg-html5") || (e.removeClass("lg-complete"), e.find(".lg-video-object").on("load.lg error.lg", function () {
                    e.addClass("lg-complete")
                }))
            }
        };
        t.core.doCss() && t.core.$items.length > 1 && (t.core.s.enableSwipe && t.core.isTouch || t.core.s.enableDrag && !t.core.isTouch) ? t.core.$el.on("onSlideClick.lg.tm", function () {
            var e = t.core.$slide.eq(t.core.index);
            n(e)
        }) : t.core.$slide.on("click.lg", function () {
            n(e(this))
        }), t.core.$el.on("onBeforeSlide.lg.tm", function (e, n, i) {
            var o, r = t.core.$slide.eq(n), s = r.find(".lg-youtube").get(0), a = r.find(".lg-vimeo").get(0),
                l = r.find(".lg-dailymotion").get(0), c = r.find(".lg-html5").get(0);
            if (s) s.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', "*"); else if (a) try {
                $f(a).api("pause")
            } catch (e) {
                console.error("Make sure you have included froogaloop2 js")
            } else if (l) l.contentWindow.postMessage("pause", "*"); else if (c) if (t.core.s.videojs) try {
                videojs(c).pause()
            } catch (e) {
                console.error("Make sure you have included videojs")
            } else c.pause();
            o = t.core.s.dynamic ? t.core.s.dynamicEl[i].src : t.core.$items.eq(i).attr("href") || t.core.$items.eq(i).attr("data-src");
            var d = t.core.isVideo(o, i) || {};
            (d.youtube || d.vimeo || d.dailymotion) && t.core.$outer.addClass("lg-hide-download")
        }), t.core.$el.on("onAfterSlide.lg.tm", function (e, n) {
            t.core.$slide.eq(n).removeClass("lg-video-palying")
        })
    }, r.prototype.loadVideo = function (t, n, i, o, r) {
        var s = "", a = 1, l = "", c = this.core.isVideo(t, o) || {};
        if (i && (a = this.videoLoaded ? 0 : 1), c.youtube) l = "?wmode=opaque&autoplay=" + a + "&enablejsapi=1", this.core.s.youtubePlayerParams && (l = l + "&" + e.param(this.core.s.youtubePlayerParams)), s = '<iframe class="lg-video-object lg-youtube ' + n + '" width="560" height="315" src="//www.youtube.com/embed/' + c.youtube[1] + l + '" frameborder="0" allowfullscreen></iframe>'; else if (c.vimeo) l = "?autoplay=" + a + "&api=1", this.core.s.vimeoPlayerParams && (l = l + "&" + e.param(this.core.s.vimeoPlayerParams)), s = '<iframe class="lg-video-object lg-vimeo ' + n + '" width="560" height="315"  src="http://player.vimeo.com/video/' + c.vimeo[1] + l + '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'; else if (c.dailymotion) l = "?wmode=opaque&autoplay=" + a + "&api=postMessage", this.core.s.dailymotionPlayerParams && (l = l + "&" + e.param(this.core.s.dailymotionPlayerParams)), s = '<iframe class="lg-video-object lg-dailymotion ' + n + '" width="560" height="315" src="//www.dailymotion.com/embed/video/' + c.dailymotion[1] + l + '" frameborder="0" allowfullscreen></iframe>'; else if (c.html5) {
            var d = r.substring(0, 1);
            ("." === d || "#" === d) && (r = e(r).html()), s = r
        }
        return s
    }, r.prototype.destroy = function () {
        this.videoLoaded = !1
    }, e.fn.lightGallery.modules.video = r
}(jQuery, window, document), function (e) {
    function t() {
    }

    function n(e) {
        function n(t) {
            t.prototype.option || (t.prototype.option = function (t) {
                e.isPlainObject(t) && (this.options = e.extend(!0, this.options, t))
            })
        }

        function o(t, n) {
            e.fn[t] = function (o) {
                if ("string" == typeof o) {
                    for (var s = i.call(arguments, 1), a = 0, l = this.length; l > a; a++) {
                        var c = this[a], d = e.data(c, t);
                        if (d) if (e.isFunction(d[o]) && "_" !== o.charAt(0)) {
                            var u = d[o].apply(d, s);
                            if (void 0 !== u) return u
                        } else r("no such method '" + o + "' for " + t + " instance"); else r("cannot call methods on " + t + " prior to initialization; attempted to call '" + o + "'")
                    }
                    return this
                }
                return this.each(function () {
                    var i = e.data(this, t);
                    i ? (i.option(o), i._init()) : (i = new n(this, o), e.data(this, t, i))
                })
            }
        }

        if (e) {
            var r = "undefined" == typeof console ? t : function (e) {
                console.error(e)
            };
            return e.bridget = function (e, t) {
                n(t), o(e, t)
            }, e.bridget
        }
    }

    var i = Array.prototype.slice;
    "function" == typeof define && define.amd ? define("jquery-bridget/jquery.bridget", ["jquery"], n) : n("object" == typeof exports ? require("jquery") : e.jQuery)
}(window), function (e) {
    function t(t) {
        var n = e.event;
        return n.target = n.target || n.srcElement || t, n
    }

    var n = document.documentElement, i = function () {
    };
    n.addEventListener ? i = function (e, t, n) {
        e.addEventListener(t, n, !1)
    } : n.attachEvent && (i = function (e, n, i) {
        e[n + i] = i.handleEvent ? function () {
            var n = t(e);
            i.handleEvent.call(i, n)
        } : function () {
            var n = t(e);
            i.call(e, n)
        }, e.attachEvent("on" + n, e[n + i])
    });
    var o = function () {
    };
    n.removeEventListener ? o = function (e, t, n) {
        e.removeEventListener(t, n, !1)
    } : n.detachEvent && (o = function (e, t, n) {
        e.detachEvent("on" + t, e[t + n]);
        try {
            delete e[t + n]
        } catch (i) {
            e[t + n] = void 0
        }
    });
    var r = {bind: i, unbind: o};
    "function" == typeof define && define.amd ? define("eventie/eventie", r) : "object" == typeof exports ? module.exports = r : e.eventie = r
}(window), function () {
    "use strict";

    function e() {
    }

    function t(e, t) {
        for (var n = e.length; n--;) if (e[n].listener === t) return n;
        return -1
    }

    function n(e) {
        return function () {
            return this[e].apply(this, arguments)
        }
    }

    var i = e.prototype, o = this, r = o.EventEmitter;
    i.getListeners = function (e) {
        var t, n, i = this._getEvents();
        if (e instanceof RegExp) for (n in t = {}, i) i.hasOwnProperty(n) && e.test(n) && (t[n] = i[n]); else t = i[e] || (i[e] = []);
        return t
    }, i.flattenListeners = function (e) {
        var t, n = [];
        for (t = 0; t < e.length; t += 1) n.push(e[t].listener);
        return n
    }, i.getListenersAsObject = function (e) {
        var t, n = this.getListeners(e);
        return n instanceof Array && ((t = {})[e] = n), t || n
    }, i.addListener = function (e, n) {
        var i, o = this.getListenersAsObject(e), r = "object" == typeof n;
        for (i in o) o.hasOwnProperty(i) && -1 === t(o[i], n) && o[i].push(r ? n : {listener: n, once: !1});
        return this
    }, i.on = n("addListener"), i.addOnceListener = function (e, t) {
        return this.addListener(e, {listener: t, once: !0})
    }, i.once = n("addOnceListener"), i.defineEvent = function (e) {
        return this.getListeners(e), this
    }, i.defineEvents = function (e) {
        for (var t = 0; t < e.length; t += 1) this.defineEvent(e[t]);
        return this
    }, i.removeListener = function (e, n) {
        var i, o, r = this.getListenersAsObject(e);
        for (o in r) r.hasOwnProperty(o) && (-1 !== (i = t(r[o], n)) && r[o].splice(i, 1));
        return this
    }, i.off = n("removeListener"), i.addListeners = function (e, t) {
        return this.manipulateListeners(!1, e, t)
    }, i.removeListeners = function (e, t) {
        return this.manipulateListeners(!0, e, t)
    }, i.manipulateListeners = function (e, t, n) {
        var i, o, r = e ? this.removeListener : this.addListener, s = e ? this.removeListeners : this.addListeners;
        if ("object" != typeof t || t instanceof RegExp) for (i = n.length; i--;) r.call(this, t, n[i]); else for (i in t) t.hasOwnProperty(i) && (o = t[i]) && ("function" == typeof o ? r.call(this, i, o) : s.call(this, i, o));
        return this
    }, i.removeEvent = function (e) {
        var t, n = typeof e, i = this._getEvents();
        if ("string" === n) delete i[e]; else if (e instanceof RegExp) for (t in i) i.hasOwnProperty(t) && e.test(t) && delete i[t]; else delete this._events;
        return this
    }, i.removeAllListeners = n("removeEvent"), i.emitEvent = function (e, t) {
        var n, i, o, r = this.getListenersAsObject(e);
        for (o in r) if (r.hasOwnProperty(o)) for (i = r[o].length; i--;) !0 === (n = r[o][i]).once && this.removeListener(e, n.listener), n.listener.apply(this, t || []) === this._getOnceReturnValue() && this.removeListener(e, n.listener);
        return this
    }, i.trigger = n("emitEvent"), i.emit = function (e) {
        var t = Array.prototype.slice.call(arguments, 1);
        return this.emitEvent(e, t)
    }, i.setOnceReturnValue = function (e) {
        return this._onceReturnValue = e, this
    }, i._getOnceReturnValue = function () {
        return !this.hasOwnProperty("_onceReturnValue") || this._onceReturnValue
    }, i._getEvents = function () {
        return this._events || (this._events = {})
    }, e.noConflict = function () {
        return o.EventEmitter = r, e
    }, "function" == typeof define && define.amd ? define("eventEmitter/EventEmitter", [], function () {
        return e
    }) : "object" == typeof module && module.exports ? module.exports = e : o.EventEmitter = e
}.call(this), function (e) {
    function t(e) {
        if (e) {
            if ("string" == typeof i[e]) return e;
            e = e.charAt(0).toUpperCase() + e.slice(1);
            for (var t, o = 0, r = n.length; r > o; o++) if (t = n[o] + e, "string" == typeof i[t]) return t
        }
    }

    var n = "Webkit Moz ms Ms O".split(" "), i = document.documentElement.style;
    "function" == typeof define && define.amd ? define("get-style-property/get-style-property", [], function () {
        return t
    }) : "object" == typeof exports ? module.exports = t : e.getStyleProperty = t
}(window), function (e, t) {
    function n(e) {
        var t = parseFloat(e);
        return -1 === e.indexOf("%") && !isNaN(t) && t
    }

    function i(t) {
        function i() {
            if (!d) {
                d = !0;
                var i = e.getComputedStyle;
                if (a = function () {
                    var e = i ? function (e) {
                        return i(e, null)
                    } : function (e) {
                        return e.currentStyle
                    };
                    return function (t) {
                        var n = e(t);
                        return n || o("Style returned " + n + ". Are you running this code in a hidden iframe on Firefox? See http://bit.ly/getsizebug1"), n
                    }
                }(), l = t("boxSizing")) {
                    var r = document.createElement("div");
                    r.style.width = "200px", r.style.padding = "1px 2px 3px 4px", r.style.borderStyle = "solid", r.style.borderWidth = "1px 2px 3px 4px", r.style[l] = "border-box";
                    var s = document.body || document.documentElement;
                    s.appendChild(r);
                    var u = a(r);
                    c = 200 === n(u.width), s.removeChild(r)
                }
            }
        }

        function s(t, n) {
            if (e.getComputedStyle || -1 === n.indexOf("%")) return n;
            var i = t.style, o = i.left, r = t.runtimeStyle, s = r && r.left;
            return s && (r.left = t.currentStyle.left), i.left = n, n = i.pixelLeft, i.left = o, s && (r.left = s), n
        }

        var a, l, c, d = !1;
        return function (e) {
            if (i(), "string" == typeof e && (e = document.querySelector(e)), e && "object" == typeof e && e.nodeType) {
                var t = a(e);
                if ("none" === t.display) return function () {
                    for (var e = {
                        width: 0,
                        height: 0,
                        innerWidth: 0,
                        innerHeight: 0,
                        outerWidth: 0,
                        outerHeight: 0
                    }, t = 0, n = r.length; n > t; t++) e[r[t]] = 0;
                    return e
                }();
                var o = {};
                o.width = e.offsetWidth, o.height = e.offsetHeight;
                for (var d = o.isBorderBox = !(!l || !t[l] || "border-box" !== t[l]), u = 0, p = r.length; p > u; u++) {
                    var f = r[u], h = t[f];
                    h = s(e, h);
                    var m = parseFloat(h);
                    o[f] = isNaN(m) ? 0 : m
                }
                var v = o.paddingLeft + o.paddingRight, g = o.paddingTop + o.paddingBottom,
                    y = o.marginLeft + o.marginRight, b = o.marginTop + o.marginBottom,
                    w = o.borderLeftWidth + o.borderRightWidth, x = o.borderTopWidth + o.borderBottomWidth, k = d && c,
                    C = n(t.width);
                !1 !== C && (o.width = C + (k ? 0 : v + w));
                var T = n(t.height);
                return !1 !== T && (o.height = T + (k ? 0 : g + x)), o.innerWidth = o.width - (v + w), o.innerHeight = o.height - (g + x), o.outerWidth = o.width + y, o.outerHeight = o.height + b, o
            }
        }
    }

    var o = "undefined" == typeof console ? function () {
        } : function (e) {
            console.error(e)
        },
        r = ["paddingLeft", "paddingRight", "paddingTop", "paddingBottom", "marginLeft", "marginRight", "marginTop", "marginBottom", "borderLeftWidth", "borderRightWidth", "borderTopWidth", "borderBottomWidth"];
    "function" == typeof define && define.amd ? define("get-size/get-size", ["get-style-property/get-style-property"], i) : "object" == typeof exports ? module.exports = i(require("desandro-get-style-property")) : e.getSize = i(e.getStyleProperty)
}(window), function (e) {
    function t(e) {
        "function" == typeof e && (t.isReady ? e() : s.push(e))
    }

    function n(e) {
        var n = "readystatechange" === e.type && "complete" !== r.readyState;
        t.isReady || n || i()
    }

    function i() {
        t.isReady = !0;
        for (var e = 0, n = s.length; n > e; e++) {
            (0, s[e])()
        }
    }

    function o(o) {
        return "complete" === r.readyState ? i() : (o.bind(r, "DOMContentLoaded", n), o.bind(r, "readystatechange", n), o.bind(e, "load", n)), t
    }

    var r = e.document, s = [];
    t.isReady = !1, "function" == typeof define && define.amd ? define("doc-ready/doc-ready", ["eventie/eventie"], o) : "object" == typeof exports ? module.exports = o(require("eventie")) : e.docReady = o(e.eventie)
}(window), function (e) {
    "use strict";

    function t(e, t) {
        return e[o](t)
    }

    function n(e) {
        e.parentNode || document.createDocumentFragment().appendChild(e)
    }

    var i, o = function () {
        if (e.matches) return "matches";
        if (e.matchesSelector) return "matchesSelector";
        for (var t = ["webkit", "moz", "ms", "o"], n = 0, i = t.length; i > n; n++) {
            var o = t[n] + "MatchesSelector";
            if (e[o]) return o
        }
    }();
    if (o) {
        var r = t(document.createElement("div"), "div");
        i = r ? t : function (e, i) {
            return n(e), t(e, i)
        }
    } else i = function (e, t) {
        n(e);
        for (var i = e.parentNode.querySelectorAll(t), o = 0, r = i.length; r > o; o++) if (i[o] === e) return !0;
        return !1
    };
    "function" == typeof define && define.amd ? define("matches-selector/matches-selector", [], function () {
        return i
    }) : "object" == typeof exports ? module.exports = i : window.matchesSelector = i
}(Element.prototype), function (e, t) {
    "use strict";
    "function" == typeof define && define.amd ? define("fizzy-ui-utils/utils", ["doc-ready/doc-ready", "matches-selector/matches-selector"], function (n, i) {
        return t(e, n, i)
    }) : "object" == typeof exports ? module.exports = t(e, require("doc-ready"), require("desandro-matches-selector")) : e.fizzyUIUtils = t(e, e.docReady, e.matchesSelector)
}(window, function (e, t, n) {
    var i = {
        extend: function (e, t) {
            for (var n in t) e[n] = t[n];
            return e
        }, modulo: function (e, t) {
            return (e % t + t) % t
        }
    }, o = Object.prototype.toString;
    i.isArray = function (e) {
        return "[object Array]" == o.call(e)
    }, i.makeArray = function (e) {
        var t = [];
        if (i.isArray(e)) t = e; else if (e && "number" == typeof e.length) for (var n = 0, o = e.length; o > n; n++) t.push(e[n]); else t.push(e);
        return t
    }, i.indexOf = Array.prototype.indexOf ? function (e, t) {
        return e.indexOf(t)
    } : function (e, t) {
        for (var n = 0, i = e.length; i > n; n++) if (e[n] === t) return n;
        return -1
    }, i.removeFrom = function (e, t) {
        var n = i.indexOf(e, t);
        -1 != n && e.splice(n, 1)
    }, i.isElement = "function" == typeof HTMLElement || "object" == typeof HTMLElement ? function (e) {
        return e instanceof HTMLElement
    } : function (e) {
        return e && "object" == typeof e && 1 == e.nodeType && "string" == typeof e.nodeName
    }, i.setText = function () {
        var e;
        return function (t, n) {
            t[e = e || (void 0 !== document.documentElement.textContent ? "textContent" : "innerText")] = n
        }
    }(), i.getParent = function (e, t) {
        for (; e != document.body;) if (e = e.parentNode, n(e, t)) return e
    }, i.getQueryElement = function (e) {
        return "string" == typeof e ? document.querySelector(e) : e
    }, i.handleEvent = function (e) {
        var t = "on" + e.type;
        this[t] && this[t](e)
    }, i.filterFindElements = function (e, t) {
        for (var o = [], r = 0, s = (e = i.makeArray(e)).length; s > r; r++) {
            var a = e[r];
            if (i.isElement(a)) if (t) {
                n(a, t) && o.push(a);
                for (var l = a.querySelectorAll(t), c = 0, d = l.length; d > c; c++) o.push(l[c])
            } else o.push(a)
        }
        return o
    }, i.debounceMethod = function (e, t, n) {
        var i = e.prototype[t], o = t + "Timeout";
        e.prototype[t] = function () {
            var e = this[o];
            e && clearTimeout(e);
            var t = arguments, r = this;
            this[o] = setTimeout(function () {
                i.apply(r, t), delete r[o]
            }, n || 100)
        }
    }, i.toDashed = function (e) {
        return e.replace(/(.)([A-Z])/g, function (e, t, n) {
            return t + "-" + n
        }).toLowerCase()
    };
    var r = e.console;
    return i.htmlInit = function (n, o) {
        t(function () {
            for (var t = i.toDashed(o), s = document.querySelectorAll(".js-" + t), a = "data-" + t + "-options", l = 0, c = s.length; c > l; l++) {
                var d, u = s[l], p = u.getAttribute(a);
                try {
                    d = p && JSON.parse(p)
                } catch (e) {
                    r && r.error("Error parsing " + a + " on " + u.nodeName.toLowerCase() + (u.id ? "#" + u.id : "") + ": " + e);
                    continue
                }
                var f = new n(u, d), h = e.jQuery;
                h && h.data(u, o, f)
            }
        })
    }, i
}), function (e, t) {
    "use strict";
    "function" == typeof define && define.amd ? define("outlayer/item", ["eventEmitter/EventEmitter", "get-size/get-size", "get-style-property/get-style-property", "fizzy-ui-utils/utils"], function (n, i, o, r) {
        return t(e, n, i, o, r)
    }) : "object" == typeof exports ? module.exports = t(e, require("wolfy87-eventemitter"), require("get-size"), require("desandro-get-style-property"), require("fizzy-ui-utils")) : (e.Outlayer = {}, e.Outlayer.Item = t(e, e.EventEmitter, e.getSize, e.getStyleProperty, e.fizzyUIUtils))
}(window, function (e, t, n, i, o) {
    "use strict";

    function r(e, t) {
        e && (this.element = e, this.layout = t, this.position = {x: 0, y: 0}, this._create())
    }

    var s = e.getComputedStyle, a = s ? function (e) {
        return s(e, null)
    } : function (e) {
        return e.currentStyle
    }, l = i("transition"), c = i("transform"), d = l && c, u = !!i("perspective"), p = {
        WebkitTransition: "webkitTransitionEnd",
        MozTransition: "transitionend",
        OTransition: "otransitionend",
        transition: "transitionend"
    }[l], f = ["transform", "transition", "transitionDuration", "transitionProperty"], h = function () {
        for (var e = {}, t = 0, n = f.length; n > t; t++) {
            var o = f[t], r = i(o);
            r && r !== o && (e[o] = r)
        }
        return e
    }();
    o.extend(r.prototype, t.prototype), r.prototype._create = function () {
        this._transn = {ingProperties: {}, clean: {}, onEnd: {}}, this.css({position: "absolute"})
    }, r.prototype.handleEvent = function (e) {
        var t = "on" + e.type;
        this[t] && this[t](e)
    }, r.prototype.getSize = function () {
        this.size = n(this.element)
    }, r.prototype.css = function (e) {
        var t = this.element.style;
        for (var n in e) {
            t[h[n] || n] = e[n]
        }
    }, r.prototype.getPosition = function () {
        var e = a(this.element), t = this.layout.options, n = t.isOriginLeft, i = t.isOriginTop,
            o = e[n ? "left" : "right"], r = e[i ? "top" : "bottom"], s = this.layout.size,
            l = -1 != o.indexOf("%") ? parseFloat(o) / 100 * s.width : parseInt(o, 10),
            c = -1 != r.indexOf("%") ? parseFloat(r) / 100 * s.height : parseInt(r, 10);
        l = isNaN(l) ? 0 : l, c = isNaN(c) ? 0 : c, l -= n ? s.paddingLeft : s.paddingRight, c -= i ? s.paddingTop : s.paddingBottom, this.position.x = l, this.position.y = c
    }, r.prototype.layoutPosition = function () {
        var e = this.layout.size, t = this.layout.options, n = {}, i = t.isOriginLeft ? "paddingLeft" : "paddingRight",
            o = t.isOriginLeft ? "left" : "right", r = t.isOriginLeft ? "right" : "left", s = this.position.x + e[i];
        n[o] = this.getXValue(s), n[r] = "";
        var a = t.isOriginTop ? "paddingTop" : "paddingBottom", l = t.isOriginTop ? "top" : "bottom",
            c = t.isOriginTop ? "bottom" : "top", d = this.position.y + e[a];
        n[l] = this.getYValue(d), n[c] = "", this.css(n), this.emitEvent("layout", [this])
    }, r.prototype.getXValue = function (e) {
        var t = this.layout.options;
        return t.percentPosition && !t.isHorizontal ? e / this.layout.size.width * 100 + "%" : e + "px"
    }, r.prototype.getYValue = function (e) {
        var t = this.layout.options;
        return t.percentPosition && t.isHorizontal ? e / this.layout.size.height * 100 + "%" : e + "px"
    }, r.prototype._transitionTo = function (e, t) {
        this.getPosition();
        var n = this.position.x, i = this.position.y, o = parseInt(e, 10), r = parseInt(t, 10),
            s = o === this.position.x && r === this.position.y;
        if (this.setPosition(e, t), !s || this.isTransitioning) {
            var a = e - n, l = t - i, c = {};
            c.transform = this.getTranslate(a, l), this.transition({
                to: c,
                onTransitionEnd: {transform: this.layoutPosition},
                isCleaning: !0
            })
        } else this.layoutPosition()
    }, r.prototype.getTranslate = function (e, t) {
        var n = this.layout.options;
        return e = n.isOriginLeft ? e : -e, t = n.isOriginTop ? t : -t, u ? "translate3d(" + e + "px, " + t + "px, 0)" : "translate(" + e + "px, " + t + "px)"
    }, r.prototype.goTo = function (e, t) {
        this.setPosition(e, t), this.layoutPosition()
    }, r.prototype.moveTo = d ? r.prototype._transitionTo : r.prototype.goTo, r.prototype.setPosition = function (e, t) {
        this.position.x = parseInt(e, 10), this.position.y = parseInt(t, 10)
    }, r.prototype._nonTransition = function (e) {
        for (var t in this.css(e.to), e.isCleaning && this._removeStyles(e.to), e.onTransitionEnd) e.onTransitionEnd[t].call(this)
    }, r.prototype._transition = function (e) {
        if (parseFloat(this.layout.options.transitionDuration)) {
            var t = this._transn;
            for (var n in e.onTransitionEnd) t.onEnd[n] = e.onTransitionEnd[n];
            for (n in e.to) t.ingProperties[n] = !0, e.isCleaning && (t.clean[n] = !0);
            if (e.from) {
                this.css(e.from);
                this.element.offsetHeight;
                null
            }
            this.enableTransition(e.to), this.css(e.to), this.isTransitioning = !0
        } else this._nonTransition(e)
    };
    var m = "opacity," + function (e) {
        return e.replace(/([A-Z])/g, function (e) {
            return "-" + e.toLowerCase()
        })
    }(h.transform || "transform");
    r.prototype.enableTransition = function () {
        this.isTransitioning || (this.css({
            transitionProperty: m,
            transitionDuration: this.layout.options.transitionDuration
        }), this.element.addEventListener(p, this, !1))
    }, r.prototype.transition = r.prototype[l ? "_transition" : "_nonTransition"], r.prototype.onwebkitTransitionEnd = function (e) {
        this.ontransitionend(e)
    }, r.prototype.onotransitionend = function (e) {
        this.ontransitionend(e)
    };
    var v = {"-webkit-transform": "transform", "-moz-transform": "transform", "-o-transform": "transform"};
    r.prototype.ontransitionend = function (e) {
        if (e.target === this.element) {
            var t = this._transn, n = v[e.propertyName] || e.propertyName;
            if (delete t.ingProperties[n], function (e) {
                for (var t in e) return !1;
                return !0
            }(t.ingProperties) && this.disableTransition(), n in t.clean && (this.element.style[e.propertyName] = "", delete t.clean[n]), n in t.onEnd) t.onEnd[n].call(this), delete t.onEnd[n];
            this.emitEvent("transitionEnd", [this])
        }
    }, r.prototype.disableTransition = function () {
        this.removeTransitionStyles(), this.element.removeEventListener(p, this, !1), this.isTransitioning = !1
    }, r.prototype._removeStyles = function (e) {
        var t = {};
        for (var n in e) t[n] = "";
        this.css(t)
    };
    var g = {transitionProperty: "", transitionDuration: ""};
    return r.prototype.removeTransitionStyles = function () {
        this.css(g)
    }, r.prototype.removeElem = function () {
        this.element.parentNode.removeChild(this.element), this.css({display: ""}), this.emitEvent("remove", [this])
    }, r.prototype.remove = function () {
        if (l && parseFloat(this.layout.options.transitionDuration)) {
            var e = this;
            this.once("transitionEnd", function () {
                e.removeElem()
            }), this.hide()
        } else this.removeElem()
    }, r.prototype.reveal = function () {
        delete this.isHidden, this.css({display: ""});
        var e = this.layout.options, t = {};
        t[this.getHideRevealTransitionEndProperty("visibleStyle")] = this.onRevealTransitionEnd, this.transition({
            from: e.hiddenStyle,
            to: e.visibleStyle,
            isCleaning: !0,
            onTransitionEnd: t
        })
    }, r.prototype.onRevealTransitionEnd = function () {
        this.isHidden || this.emitEvent("reveal")
    }, r.prototype.getHideRevealTransitionEndProperty = function (e) {
        var t = this.layout.options[e];
        if (t.opacity) return "opacity";
        for (var n in t) return n
    }, r.prototype.hide = function () {
        this.isHidden = !0, this.css({display: ""});
        var e = this.layout.options, t = {};
        t[this.getHideRevealTransitionEndProperty("hiddenStyle")] = this.onHideTransitionEnd, this.transition({
            from: e.visibleStyle,
            to: e.hiddenStyle,
            isCleaning: !0,
            onTransitionEnd: t
        })
    }, r.prototype.onHideTransitionEnd = function () {
        this.isHidden && (this.css({display: "none"}), this.emitEvent("hide"))
    }, r.prototype.destroy = function () {
        this.css({position: "", left: "", right: "", top: "", bottom: "", transition: "", transform: ""})
    }, r
}), function (e, t) {
    "use strict";
    "function" == typeof define && define.amd ? define("outlayer/outlayer", ["eventie/eventie", "eventEmitter/EventEmitter", "get-size/get-size", "fizzy-ui-utils/utils", "./item"], function (n, i, o, r, s) {
        return t(e, n, i, o, r, s)
    }) : "object" == typeof exports ? module.exports = t(e, require("eventie"), require("wolfy87-eventemitter"), require("get-size"), require("fizzy-ui-utils"), require("./item")) : e.Outlayer = t(e, e.eventie, e.EventEmitter, e.getSize, e.fizzyUIUtils, e.Outlayer.Item)
}(window, function (e, t, n, i, o, r) {
    "use strict";

    function s(e, t) {
        var n = o.getQueryElement(e);
        if (n) {
            this.element = n, l && (this.$element = l(this.element)), this.options = o.extend({}, this.constructor.defaults), this.option(t);
            var i = ++d;
            this.element.outlayerGUID = i, u[i] = this, this._create(), this.options.isInitLayout && this.layout()
        } else a && a.error("Bad element for " + this.constructor.namespace + ": " + (n || e))
    }

    var a = e.console, l = e.jQuery, c = function () {
    }, d = 0, u = {};
    return s.namespace = "outlayer", s.Item = r, s.defaults = {
        containerStyle: {position: "relative"},
        isInitLayout: !0,
        isOriginLeft: !0,
        isOriginTop: !0,
        isResizeBound: !0,
        isResizingContainer: !0,
        transitionDuration: "0.4s",
        hiddenStyle: {opacity: 0, transform: "scale(0.001)"},
        visibleStyle: {opacity: 1, transform: "scale(1)"}
    }, o.extend(s.prototype, n.prototype), s.prototype.option = function (e) {
        o.extend(this.options, e)
    }, s.prototype._create = function () {
        this.reloadItems(), this.stamps = [], this.stamp(this.options.stamp), o.extend(this.element.style, this.options.containerStyle), this.options.isResizeBound && this.bindResize()
    }, s.prototype.reloadItems = function () {
        this.items = this._itemize(this.element.children)
    }, s.prototype._itemize = function (e) {
        for (var t = this._filterFindItemElements(e), n = this.constructor.Item, i = [], o = 0, r = t.length; r > o; o++) {
            var s = new n(t[o], this);
            i.push(s)
        }
        return i
    }, s.prototype._filterFindItemElements = function (e) {
        return o.filterFindElements(e, this.options.itemSelector)
    }, s.prototype.getItemElements = function () {
        for (var e = [], t = 0, n = this.items.length; n > t; t++) e.push(this.items[t].element);
        return e
    }, s.prototype.layout = function () {
        this._resetLayout(), this._manageStamps();
        var e = void 0 !== this.options.isLayoutInstant ? this.options.isLayoutInstant : !this._isLayoutInited;
        this.layoutItems(this.items, e), this._isLayoutInited = !0
    }, s.prototype._init = s.prototype.layout, s.prototype._resetLayout = function () {
        this.getSize()
    }, s.prototype.getSize = function () {
        this.size = i(this.element)
    }, s.prototype._getMeasurement = function (e, t) {
        var n, r = this.options[e];
        r ? ("string" == typeof r ? n = this.element.querySelector(r) : o.isElement(r) && (n = r), this[e] = n ? i(n)[t] : r) : this[e] = 0
    }, s.prototype.layoutItems = function (e, t) {
        e = this._getItemsForLayout(e), this._layoutItems(e, t), this._postLayout()
    }, s.prototype._getItemsForLayout = function (e) {
        for (var t = [], n = 0, i = e.length; i > n; n++) {
            var o = e[n];
            o.isIgnored || t.push(o)
        }
        return t
    }, s.prototype._layoutItems = function (e, t) {
        if (this._emitCompleteOnItems("layout", e), e && e.length) {
            for (var n = [], i = 0, o = e.length; o > i; i++) {
                var r = e[i], s = this._getItemLayoutPosition(r);
                s.item = r, s.isInstant = t || r.isLayoutInstant, n.push(s)
            }
            this._processLayoutQueue(n)
        }
    }, s.prototype._getItemLayoutPosition = function () {
        return {x: 0, y: 0}
    }, s.prototype._processLayoutQueue = function (e) {
        for (var t = 0, n = e.length; n > t; t++) {
            var i = e[t];
            this._positionItem(i.item, i.x, i.y, i.isInstant)
        }
    }, s.prototype._positionItem = function (e, t, n, i) {
        i ? e.goTo(t, n) : e.moveTo(t, n)
    }, s.prototype._postLayout = function () {
        this.resizeContainer()
    }, s.prototype.resizeContainer = function () {
        if (this.options.isResizingContainer) {
            var e = this._getContainerSize();
            e && (this._setContainerMeasure(e.width, !0), this._setContainerMeasure(e.height, !1))
        }
    }, s.prototype._getContainerSize = c, s.prototype._setContainerMeasure = function (e, t) {
        if (void 0 !== e) {
            var n = this.size;
            n.isBorderBox && (e += t ? n.paddingLeft + n.paddingRight + n.borderLeftWidth + n.borderRightWidth : n.paddingBottom + n.paddingTop + n.borderTopWidth + n.borderBottomWidth), e = Math.max(e, 0), this.element.style[t ? "width" : "height"] = e + "px"
        }
    }, s.prototype._emitCompleteOnItems = function (e, t) {
        function n() {
            o.dispatchEvent(e + "Complete", null, [t])
        }

        function i() {
            ++s === r && n()
        }

        var o = this, r = t.length;
        if (t && r) for (var s = 0, a = 0, l = t.length; l > a; a++) {
            t[a].once(e, i)
        } else n()
    }, s.prototype.dispatchEvent = function (e, t, n) {
        var i = t ? [t].concat(n) : n;
        if (this.emitEvent(e, i), l) if (this.$element = this.$element || l(this.element), t) {
            var o = l.Event(t);
            o.type = e, this.$element.trigger(o, n)
        } else this.$element.trigger(e, n)
    }, s.prototype.ignore = function (e) {
        var t = this.getItem(e);
        t && (t.isIgnored = !0)
    }, s.prototype.unignore = function (e) {
        var t = this.getItem(e);
        t && delete t.isIgnored
    }, s.prototype.stamp = function (e) {
        if (e = this._find(e)) {
            this.stamps = this.stamps.concat(e);
            for (var t = 0, n = e.length; n > t; t++) {
                var i = e[t];
                this.ignore(i)
            }
        }
    }, s.prototype.unstamp = function (e) {
        if (e = this._find(e)) for (var t = 0, n = e.length; n > t; t++) {
            var i = e[t];
            o.removeFrom(this.stamps, i), this.unignore(i)
        }
    }, s.prototype._find = function (e) {
        return e ? ("string" == typeof e && (e = this.element.querySelectorAll(e)), e = o.makeArray(e)) : void 0
    }, s.prototype._manageStamps = function () {
        if (this.stamps && this.stamps.length) {
            this._getBoundingRect();
            for (var e = 0, t = this.stamps.length; t > e; e++) {
                var n = this.stamps[e];
                this._manageStamp(n)
            }
        }
    }, s.prototype._getBoundingRect = function () {
        var e = this.element.getBoundingClientRect(), t = this.size;
        this._boundingRect = {
            left: e.left + t.paddingLeft + t.borderLeftWidth,
            top: e.top + t.paddingTop + t.borderTopWidth,
            right: e.right - (t.paddingRight + t.borderRightWidth),
            bottom: e.bottom - (t.paddingBottom + t.borderBottomWidth)
        }
    }, s.prototype._manageStamp = c, s.prototype._getElementOffset = function (e) {
        var t = e.getBoundingClientRect(), n = this._boundingRect, o = i(e);
        return {
            left: t.left - n.left - o.marginLeft,
            top: t.top - n.top - o.marginTop,
            right: n.right - t.right - o.marginRight,
            bottom: n.bottom - t.bottom - o.marginBottom
        }
    }, s.prototype.handleEvent = function (e) {
        var t = "on" + e.type;
        this[t] && this[t](e)
    }, s.prototype.bindResize = function () {
        this.isResizeBound || (t.bind(e, "resize", this), this.isResizeBound = !0)
    }, s.prototype.unbindResize = function () {
        this.isResizeBound && t.unbind(e, "resize", this), this.isResizeBound = !1
    }, s.prototype.onresize = function () {
        this.resizeTimeout && clearTimeout(this.resizeTimeout);
        var e = this;
        this.resizeTimeout = setTimeout(function () {
            e.resize(), delete e.resizeTimeout
        }, 100)
    }, s.prototype.resize = function () {
        this.isResizeBound && this.needsResizeLayout() && this.layout()
    }, s.prototype.needsResizeLayout = function () {
        var e = i(this.element);
        return this.size && e && e.innerWidth !== this.size.innerWidth
    }, s.prototype.addItems = function (e) {
        var t = this._itemize(e);
        return t.length && (this.items = this.items.concat(t)), t
    }, s.prototype.appended = function (e) {
        var t = this.addItems(e);
        t.length && (this.layoutItems(t, !0), this.reveal(t))
    }, s.prototype.prepended = function (e) {
        var t = this._itemize(e);
        if (t.length) {
            var n = this.items.slice(0);
            this.items = t.concat(n), this._resetLayout(), this._manageStamps(), this.layoutItems(t, !0), this.reveal(t), this.layoutItems(n)
        }
    }, s.prototype.reveal = function (e) {
        this._emitCompleteOnItems("reveal", e);
        for (var t = e && e.length, n = 0; t && t > n; n++) {
            e[n].reveal()
        }
    }, s.prototype.hide = function (e) {
        this._emitCompleteOnItems("hide", e);
        for (var t = e && e.length, n = 0; t && t > n; n++) {
            e[n].hide()
        }
    }, s.prototype.revealItemElements = function (e) {
        var t = this.getItems(e);
        this.reveal(t)
    }, s.prototype.hideItemElements = function (e) {
        var t = this.getItems(e);
        this.hide(t)
    }, s.prototype.getItem = function (e) {
        for (var t = 0, n = this.items.length; n > t; t++) {
            var i = this.items[t];
            if (i.element === e) return i
        }
    }, s.prototype.getItems = function (e) {
        for (var t = [], n = 0, i = (e = o.makeArray(e)).length; i > n; n++) {
            var r = e[n], s = this.getItem(r);
            s && t.push(s)
        }
        return t
    }, s.prototype.remove = function (e) {
        var t = this.getItems(e);
        if (this._emitCompleteOnItems("remove", t), t && t.length) for (var n = 0, i = t.length; i > n; n++) {
            var r = t[n];
            r.remove(), o.removeFrom(this.items, r)
        }
    }, s.prototype.destroy = function () {
        var e = this.element.style;
        e.height = "", e.position = "", e.width = "";
        for (var t = 0, n = this.items.length; n > t; t++) {
            this.items[t].destroy()
        }
        this.unbindResize();
        var i = this.element.outlayerGUID;
        delete u[i], delete this.element.outlayerGUID, l && l.removeData(this.element, this.constructor.namespace)
    }, s.data = function (e) {
        var t = (e = o.getQueryElement(e)) && e.outlayerGUID;
        return t && u[t]
    }, s.create = function (e, t) {
        function n() {
            s.apply(this, arguments)
        }

        return Object.create ? n.prototype = Object.create(s.prototype) : o.extend(n.prototype, s.prototype), n.prototype.constructor = n, n.defaults = o.extend({}, s.defaults), o.extend(n.defaults, t), n.prototype.settings = {}, n.namespace = e, n.data = s.data, n.Item = function () {
            r.apply(this, arguments)
        }, n.Item.prototype = new r, o.htmlInit(n, e), l && l.bridget && l.bridget(e, n), n
    }, s.Item = r, s
}), function (e, t) {
    "use strict";
    "function" == typeof define && define.amd ? define("isotope/js/item", ["outlayer/outlayer"], t) : "object" == typeof exports ? module.exports = t(require("outlayer")) : (e.Isotope = e.Isotope || {}, e.Isotope.Item = t(e.Outlayer))
}(window, function (e) {
    "use strict";

    function t() {
        e.Item.apply(this, arguments)
    }

    t.prototype = new e.Item, t.prototype._create = function () {
        this.id = this.layout.itemGUID++, e.Item.prototype._create.call(this), this.sortData = {}
    }, t.prototype.updateSortData = function () {
        if (!this.isIgnored) {
            this.sortData.id = this.id, this.sortData["original-order"] = this.id, this.sortData.random = Math.random();
            var e = this.layout.options.getSortData, t = this.layout._sorters;
            for (var n in e) {
                var i = t[n];
                this.sortData[n] = i(this.element, this)
            }
        }
    };
    var n = t.prototype.destroy;
    return t.prototype.destroy = function () {
        n.apply(this, arguments), this.css({display: ""})
    }, t
}), function (e, t) {
    "use strict";
    "function" == typeof define && define.amd ? define("isotope/js/layout-mode", ["get-size/get-size", "outlayer/outlayer"], t) : "object" == typeof exports ? module.exports = t(require("get-size"), require("outlayer")) : (e.Isotope = e.Isotope || {}, e.Isotope.LayoutMode = t(e.getSize, e.Outlayer))
}(window, function (e, t) {
    "use strict";

    function n(e) {
        this.isotope = e, e && (this.options = e.options[this.namespace], this.element = e.element, this.items = e.filteredItems, this.size = e.size)
    }

    return function () {
        function e(e) {
            return function () {
                return t.prototype[e].apply(this.isotope, arguments)
            }
        }

        for (var i = ["_resetLayout", "_getItemLayoutPosition", "_manageStamp", "_getContainerSize", "_getElementOffset", "needsResizeLayout"], o = 0, r = i.length; r > o; o++) {
            var s = i[o];
            n.prototype[s] = e(s)
        }
    }(), n.prototype.needsVerticalResizeLayout = function () {
        var t = e(this.isotope.element);
        return this.isotope.size && t && t.innerHeight != this.isotope.size.innerHeight
    }, n.prototype._getMeasurement = function () {
        this.isotope._getMeasurement.apply(this, arguments)
    }, n.prototype.getColumnWidth = function () {
        this.getSegmentSize("column", "Width")
    }, n.prototype.getRowHeight = function () {
        this.getSegmentSize("row", "Height")
    }, n.prototype.getSegmentSize = function (e, t) {
        var n = e + t, i = "outer" + t;
        if (this._getMeasurement(n, i), !this[n]) {
            var o = this.getFirstItemSize();
            this[n] = o && o[i] || this.isotope.size["inner" + t]
        }
    }, n.prototype.getFirstItemSize = function () {
        var t = this.isotope.filteredItems[0];
        return t && t.element && e(t.element)
    }, n.prototype.layout = function () {
        this.isotope.layout.apply(this.isotope, arguments)
    }, n.prototype.getSize = function () {
        this.isotope.getSize(), this.size = this.isotope.size
    }, n.modes = {}, n.create = function (e, t) {
        function i() {
            n.apply(this, arguments)
        }

        return i.prototype = new n, t && (i.options = t), i.prototype.namespace = e, n.modes[e] = i, i
    }, n
}), function (e, t) {
    "use strict";
    "function" == typeof define && define.amd ? define("masonry/masonry", ["outlayer/outlayer", "get-size/get-size", "fizzy-ui-utils/utils"], t) : "object" == typeof exports ? module.exports = t(require("outlayer"), require("get-size"), require("fizzy-ui-utils")) : e.Masonry = t(e.Outlayer, e.getSize, e.fizzyUIUtils)
}(window, function (e, t, n) {
    var i = e.create("masonry");
    return i.prototype._resetLayout = function () {
        this.getSize(), this._getMeasurement("columnWidth", "outerWidth"), this._getMeasurement("gutter", "outerWidth"), this.measureColumns();
        var e = this.cols;
        for (this.colYs = []; e--;) this.colYs.push(0);
        this.maxY = 0
    }, i.prototype.measureColumns = function () {
        if (this.getContainerWidth(), !this.columnWidth) {
            var e = this.items[0], n = e && e.element;
            this.columnWidth = n && t(n).outerWidth || this.containerWidth
        }
        var i = this.columnWidth += this.gutter, o = this.containerWidth + this.gutter, r = o / i, s = i - o % i;
        r = Math[s && 1 > s ? "round" : "floor"](r), this.cols = Math.max(r, 1)
    }, i.prototype.getContainerWidth = function () {
        var e = this.options.isFitWidth ? this.element.parentNode : this.element, n = t(e);
        this.containerWidth = n && n.innerWidth
    }, i.prototype._getItemLayoutPosition = function (e) {
        e.getSize();
        var t = e.size.outerWidth % this.columnWidth,
            i = Math[t && 1 > t ? "round" : "ceil"](e.size.outerWidth / this.columnWidth);
        i = Math.min(i, this.cols);
        for (var o = this._getColGroup(i), r = Math.min.apply(Math, o), s = n.indexOf(o, r), a = {
            x: this.columnWidth * s,
            y: r
        }, l = r + e.size.outerHeight, c = this.cols + 1 - o.length, d = 0; c > d; d++) this.colYs[s + d] = l;
        return a
    }, i.prototype._getColGroup = function (e) {
        if (2 > e) return this.colYs;
        for (var t = [], n = this.cols + 1 - e, i = 0; n > i; i++) {
            var o = this.colYs.slice(i, i + e);
            t[i] = Math.max.apply(Math, o)
        }
        return t
    }, i.prototype._manageStamp = function (e) {
        var n = t(e), i = this._getElementOffset(e), o = this.options.isOriginLeft ? i.left : i.right,
            r = o + n.outerWidth, s = Math.floor(o / this.columnWidth);
        s = Math.max(0, s);
        var a = Math.floor(r / this.columnWidth);
        a -= r % this.columnWidth ? 0 : 1, a = Math.min(this.cols - 1, a);
        for (var l = (this.options.isOriginTop ? i.top : i.bottom) + n.outerHeight, c = s; a >= c; c++) this.colYs[c] = Math.max(l, this.colYs[c])
    }, i.prototype._getContainerSize = function () {
        this.maxY = Math.max.apply(Math, this.colYs);
        var e = {height: this.maxY};
        return this.options.isFitWidth && (e.width = this._getContainerFitWidth()), e
    }, i.prototype._getContainerFitWidth = function () {
        for (var e = 0, t = this.cols; --t && 0 === this.colYs[t];) e++;
        return (this.cols - e) * this.columnWidth - this.gutter
    }, i.prototype.needsResizeLayout = function () {
        var e = this.containerWidth;
        return this.getContainerWidth(), e !== this.containerWidth
    }, i
}), function (e, t) {
    "use strict";
    "function" == typeof define && define.amd ? define("isotope/js/layout-modes/masonry", ["../layout-mode", "masonry/masonry"], t) : "object" == typeof exports ? module.exports = t(require("../layout-mode"), require("masonry-layout")) : t(e.Isotope.LayoutMode, e.Masonry)
}(window, function (e, t) {
    "use strict";
    var n = e.create("masonry"), i = n.prototype._getElementOffset, o = n.prototype.layout,
        r = n.prototype._getMeasurement;
    (function (e, t) {
        for (var n in t) e[n] = t[n]
    })(n.prototype, t.prototype), n.prototype._getElementOffset = i, n.prototype.layout = o, n.prototype._getMeasurement = r;
    var s = n.prototype.measureColumns;
    n.prototype.measureColumns = function () {
        this.items = this.isotope.filteredItems, s.call(this)
    };
    var a = n.prototype._manageStamp;
    return n.prototype._manageStamp = function () {
        this.options.isOriginLeft = this.isotope.options.isOriginLeft, this.options.isOriginTop = this.isotope.options.isOriginTop, a.apply(this, arguments)
    }, n
}), function (e, t) {
    "use strict";
    "function" == typeof define && define.amd ? define("isotope/js/layout-modes/fit-rows", ["../layout-mode"], t) : "object" == typeof exports ? module.exports = t(require("../layout-mode")) : t(e.Isotope.LayoutMode)
}(window, function (e) {
    "use strict";
    var t = e.create("fitRows");
    return t.prototype._resetLayout = function () {
        this.x = 0, this.y = 0, this.maxY = 0, this._getMeasurement("gutter", "outerWidth")
    }, t.prototype._getItemLayoutPosition = function (e) {
        e.getSize();
        var t = e.size.outerWidth + this.gutter, n = this.isotope.size.innerWidth + this.gutter;
        0 !== this.x && t + this.x > n && (this.x = 0, this.y = this.maxY);
        var i = {x: this.x, y: this.y};
        return this.maxY = Math.max(this.maxY, this.y + e.size.outerHeight), this.x += t, i
    }, t.prototype._getContainerSize = function () {
        return {height: this.maxY}
    }, t
}), function (e, t) {
    "use strict";
    "function" == typeof define && define.amd ? define("isotope/js/layout-modes/vertical", ["../layout-mode"], t) : "object" == typeof exports ? module.exports = t(require("../layout-mode")) : t(e.Isotope.LayoutMode)
}(window, function (e) {
    "use strict";
    var t = e.create("vertical", {horizontalAlignment: 0});
    return t.prototype._resetLayout = function () {
        this.y = 0
    }, t.prototype._getItemLayoutPosition = function (e) {
        e.getSize();
        var t = (this.isotope.size.innerWidth - e.size.outerWidth) * this.options.horizontalAlignment, n = this.y;
        return this.y += e.size.outerHeight, {x: t, y: n}
    }, t.prototype._getContainerSize = function () {
        return {height: this.y}
    }, t
}), function (e, t) {
    "use strict";
    "function" == typeof define && define.amd ? define(["outlayer/outlayer", "get-size/get-size", "matches-selector/matches-selector", "fizzy-ui-utils/utils", "isotope/js/item", "isotope/js/layout-mode", "isotope/js/layout-modes/masonry", "isotope/js/layout-modes/fit-rows", "isotope/js/layout-modes/vertical"], function (n, i, o, r, s, a) {
        return t(e, n, i, o, r, s, a)
    }) : "object" == typeof exports ? module.exports = t(e, require("outlayer"), require("get-size"), require("desandro-matches-selector"), require("fizzy-ui-utils"), require("./item"), require("./layout-mode"), require("./layout-modes/masonry"), require("./layout-modes/fit-rows"), require("./layout-modes/vertical")) : e.Isotope = t(e, e.Outlayer, e.getSize, e.matchesSelector, e.fizzyUIUtils, e.Isotope.Item, e.Isotope.LayoutMode)
}(window, function (e, t, n, i, o, r, s) {
    var a = e.jQuery, l = String.prototype.trim ? function (e) {
        return e.trim()
    } : function (e) {
        return e.replace(/^\s+|\s+$/g, "")
    }, c = document.documentElement.textContent ? function (e) {
        return e.textContent
    } : function (e) {
        return e.innerText
    }, d = t.create("isotope", {layoutMode: "masonry", isJQueryFiltering: !0, sortAscending: !0});
    d.Item = r, d.LayoutMode = s, d.prototype._create = function () {
        for (var e in this.itemGUID = 0, this._sorters = {}, this._getSorters(), t.prototype._create.call(this), this.modes = {}, this.filteredItems = this.items, this.sortHistory = ["original-order"], s.modes) this._initLayoutMode(e)
    }, d.prototype.reloadItems = function () {
        this.itemGUID = 0, t.prototype.reloadItems.call(this)
    }, d.prototype._itemize = function () {
        for (var e = t.prototype._itemize.apply(this, arguments), n = 0, i = e.length; i > n; n++) {
            e[n].id = this.itemGUID++
        }
        return this._updateItemsSortData(e), e
    }, d.prototype._initLayoutMode = function (e) {
        var t = s.modes[e], n = this.options[e] || {};
        this.options[e] = t.options ? o.extend(t.options, n) : n, this.modes[e] = new t(this)
    }, d.prototype.layout = function () {
        return !this._isLayoutInited && this.options.isInitLayout ? void this.arrange() : void this._layout()
    }, d.prototype._layout = function () {
        var e = this._getIsInstant();
        this._resetLayout(), this._manageStamps(), this.layoutItems(this.filteredItems, e), this._isLayoutInited = !0
    }, d.prototype.arrange = function (e) {
        function t() {
            i.reveal(n.needReveal), i.hide(n.needHide)
        }

        this.option(e), this._getIsInstant();
        var n = this._filter(this.items);
        this.filteredItems = n.matches;
        var i = this;
        this._bindArrangeComplete(), this._isInstant ? this._noTransition(t) : t(), this._sort(), this._layout()
    }, d.prototype._init = d.prototype.arrange, d.prototype._getIsInstant = function () {
        var e = void 0 !== this.options.isLayoutInstant ? this.options.isLayoutInstant : !this._isLayoutInited;
        return this._isInstant = e, e
    }, d.prototype._bindArrangeComplete = function () {
        function e() {
            t && n && i && o.dispatchEvent("arrangeComplete", null, [o.filteredItems])
        }

        var t, n, i, o = this;
        this.once("layoutComplete", function () {
            t = !0, e()
        }), this.once("hideComplete", function () {
            n = !0, e()
        }), this.once("revealComplete", function () {
            i = !0, e()
        })
    }, d.prototype._filter = function (e) {
        var t = this.options.filter;
        t = t || "*";
        for (var n = [], i = [], o = [], r = this._getFilterTest(t), s = 0, a = e.length; a > s; s++) {
            var l = e[s];
            if (!l.isIgnored) {
                var c = r(l);
                c && n.push(l), c && l.isHidden ? i.push(l) : c || l.isHidden || o.push(l)
            }
        }
        return {matches: n, needReveal: i, needHide: o}
    }, d.prototype._getFilterTest = function (e) {
        return a && this.options.isJQueryFiltering ? function (t) {
            return a(t.element).is(e)
        } : "function" == typeof e ? function (t) {
            return e(t.element)
        } : function (t) {
            return i(t.element, e)
        }
    }, d.prototype.updateSortData = function (e) {
        var t;
        e ? (e = o.makeArray(e), t = this.getItems(e)) : t = this.items, this._getSorters(), this._updateItemsSortData(t)
    }, d.prototype._getSorters = function () {
        var e = this.options.getSortData;
        for (var t in e) {
            var n = e[t];
            this._sorters[t] = u(n)
        }
    }, d.prototype._updateItemsSortData = function (e) {
        for (var t = e && e.length, n = 0; t && t > n; n++) {
            e[n].updateSortData()
        }
    };
    var u = function () {
        return function (e) {
            if ("string" != typeof e) return e;
            var t = l(e).split(" "), n = t[0], i = n.match(/^\[(.+)\]$/), o = function (e, t) {
                return e ? function (t) {
                    return t.getAttribute(e)
                } : function (e) {
                    var n = e.querySelector(t);
                    return n && c(n)
                }
            }(i && i[1], n), r = d.sortDataParsers[t[1]];
            return r ? function (e) {
                return e && r(o(e))
            } : function (e) {
                return e && o(e)
            }
        }
    }();
    d.sortDataParsers = {
        parseInt: function (e) {
            return parseInt(e, 10)
        }, parseFloat: function (e) {
            return parseFloat(e)
        }
    }, d.prototype._sort = function () {
        var e = this.options.sortBy;
        if (e) {
            var t = function (e, t) {
                return function (n, i) {
                    for (var o = 0, r = e.length; r > o; o++) {
                        var s = e[o], a = n.sortData[s], l = i.sortData[s];
                        if (a > l || l > a) return (a > l ? 1 : -1) * ((void 0 !== t[s] ? t[s] : t) ? 1 : -1)
                    }
                    return 0
                }
            }([].concat.apply(e, this.sortHistory), this.options.sortAscending);
            this.filteredItems.sort(t), e != this.sortHistory[0] && this.sortHistory.unshift(e)
        }
    }, d.prototype._mode = function () {
        var e = this.options.layoutMode, t = this.modes[e];
        if (!t) throw new Error("No layout mode: " + e);
        return t.options = this.options[e], t
    }, d.prototype._resetLayout = function () {
        t.prototype._resetLayout.call(this), this._mode()._resetLayout()
    }, d.prototype._getItemLayoutPosition = function (e) {
        return this._mode()._getItemLayoutPosition(e)
    }, d.prototype._manageStamp = function (e) {
        this._mode()._manageStamp(e)
    }, d.prototype._getContainerSize = function () {
        return this._mode()._getContainerSize()
    }, d.prototype.needsResizeLayout = function () {
        return this._mode().needsResizeLayout()
    }, d.prototype.appended = function (e) {
        var t = this.addItems(e);
        if (t.length) {
            var n = this._filterRevealAdded(t);
            this.filteredItems = this.filteredItems.concat(n)
        }
    }, d.prototype.prepended = function (e) {
        var t = this._itemize(e);
        if (t.length) {
            this._resetLayout(), this._manageStamps();
            var n = this._filterRevealAdded(t);
            this.layoutItems(this.filteredItems), this.filteredItems = n.concat(this.filteredItems), this.items = t.concat(this.items)
        }
    }, d.prototype._filterRevealAdded = function (e) {
        var t = this._filter(e);
        return this.hide(t.needHide), this.reveal(t.matches), this.layoutItems(t.matches, !0), t.matches
    }, d.prototype.insert = function (e) {
        var t = this.addItems(e);
        if (t.length) {
            var n, i, o = t.length;
            for (n = 0; o > n; n++) i = t[n], this.element.appendChild(i.element);
            var r = this._filter(t).matches;
            for (n = 0; o > n; n++) t[n].isLayoutInstant = !0;
            for (this.arrange(), n = 0; o > n; n++) delete t[n].isLayoutInstant;
            this.reveal(r)
        }
    };
    var p = d.prototype.remove;
    return d.prototype.remove = function (e) {
        e = o.makeArray(e);
        var t = this.getItems(e);
        p.call(this, e);
        var n = t && t.length;
        if (n) for (var i = 0; n > i; i++) {
            var r = t[i];
            o.removeFrom(this.filteredItems, r)
        }
    }, d.prototype.shuffle = function () {
        for (var e = 0, t = this.items.length; t > e; e++) {
            this.items[e].sortData.random = Math.random()
        }
        this.options.sortBy = "random", this._sort(), this._layout()
    }, d.prototype._noTransition = function (e) {
        var t = this.options.transitionDuration;
        this.options.transitionDuration = 0;
        var n = e.call(this);
        return this.options.transitionDuration = t, n
    }, d.prototype.getFilteredItemElements = function () {
        for (var e = [], t = 0, n = this.filteredItems.length; n > t; t++) e.push(this.filteredItems[t].element);
        return e
    }, d
}), function () {
    function e() {
    }

    function t(e, t) {
        for (var n = e.length; n--;) if (e[n].listener === t) return n;
        return -1
    }

    function n(e) {
        return function () {
            return this[e].apply(this, arguments)
        }
    }

    var i = e.prototype, o = this, r = o.EventEmitter;
    i.getListeners = function (e) {
        var t, n, i = this._getEvents();
        if ("object" == typeof e) for (n in t = {}, i) i.hasOwnProperty(n) && e.test(n) && (t[n] = i[n]); else t = i[e] || (i[e] = []);
        return t
    }, i.flattenListeners = function (e) {
        var t, n = [];
        for (t = 0; e.length > t; t += 1) n.push(e[t].listener);
        return n
    }, i.getListenersAsObject = function (e) {
        var t, n = this.getListeners(e);
        return n instanceof Array && ((t = {})[e] = n), t || n
    }, i.addListener = function (e, n) {
        var i, o = this.getListenersAsObject(e), r = "object" == typeof n;
        for (i in o) o.hasOwnProperty(i) && -1 === t(o[i], n) && o[i].push(r ? n : {listener: n, once: !1});
        return this
    }, i.on = n("addListener"), i.addOnceListener = function (e, t) {
        return this.addListener(e, {listener: t, once: !0})
    }, i.once = n("addOnceListener"), i.defineEvent = function (e) {
        return this.getListeners(e), this
    }, i.defineEvents = function (e) {
        for (var t = 0; e.length > t; t += 1) this.defineEvent(e[t]);
        return this
    }, i.removeListener = function (e, n) {
        var i, o, r = this.getListenersAsObject(e);
        for (o in r) r.hasOwnProperty(o) && (-1 !== (i = t(r[o], n)) && r[o].splice(i, 1));
        return this
    }, i.off = n("removeListener"), i.addListeners = function (e, t) {
        return this.manipulateListeners(!1, e, t)
    }, i.removeListeners = function (e, t) {
        return this.manipulateListeners(!0, e, t)
    }, i.manipulateListeners = function (e, t, n) {
        var i, o, r = e ? this.removeListener : this.addListener, s = e ? this.removeListeners : this.addListeners;
        if ("object" != typeof t || t instanceof RegExp) for (i = n.length; i--;) r.call(this, t, n[i]); else for (i in t) t.hasOwnProperty(i) && (o = t[i]) && ("function" == typeof o ? r.call(this, i, o) : s.call(this, i, o));
        return this
    }, i.removeEvent = function (e) {
        var t, n = typeof e, i = this._getEvents();
        if ("string" === n) delete i[e]; else if ("object" === n) for (t in i) i.hasOwnProperty(t) && e.test(t) && delete i[t]; else delete this._events;
        return this
    }, i.removeAllListeners = n("removeEvent"), i.emitEvent = function (e, t) {
        var n, i, o, r = this.getListenersAsObject(e);
        for (o in r) if (r.hasOwnProperty(o)) for (i = r[o].length; i--;) !0 === (n = r[o][i]).once && this.removeListener(e, n.listener), n.listener.apply(this, t || []) === this._getOnceReturnValue() && this.removeListener(e, n.listener);
        return this
    }, i.trigger = n("emitEvent"), i.emit = function (e) {
        var t = Array.prototype.slice.call(arguments, 1);
        return this.emitEvent(e, t)
    }, i.setOnceReturnValue = function (e) {
        return this._onceReturnValue = e, this
    }, i._getOnceReturnValue = function () {
        return !this.hasOwnProperty("_onceReturnValue") || this._onceReturnValue
    }, i._getEvents = function () {
        return this._events || (this._events = {})
    }, e.noConflict = function () {
        return o.EventEmitter = r, e
    }, "function" == typeof define && define.amd ? define("eventEmitter/EventEmitter", [], function () {
        return e
    }) : "object" == typeof module && module.exports ? module.exports = e : this.EventEmitter = e
}.call(this), function (e) {
    function t(t) {
        var n = e.event;
        return n.target = n.target || n.srcElement || t, n
    }

    var n = document.documentElement, i = function () {
    };
    n.addEventListener ? i = function (e, t, n) {
        e.addEventListener(t, n, !1)
    } : n.attachEvent && (i = function (e, n, i) {
        e[n + i] = i.handleEvent ? function () {
            var n = t(e);
            i.handleEvent.call(i, n)
        } : function () {
            var n = t(e);
            i.call(e, n)
        }, e.attachEvent("on" + n, e[n + i])
    });
    var o = function () {
    };
    n.removeEventListener ? o = function (e, t, n) {
        e.removeEventListener(t, n, !1)
    } : n.detachEvent && (o = function (e, t, n) {
        e.detachEvent("on" + t, e[t + n]);
        try {
            delete e[t + n]
        } catch (i) {
            e[t + n] = void 0
        }
    });
    var r = {bind: i, unbind: o};
    "function" == typeof define && define.amd ? define("eventie/eventie", r) : e.eventie = r
}(this), function (e, t) {
    "function" == typeof define && define.amd ? define(["eventEmitter/EventEmitter", "eventie/eventie"], function (n, i) {
        return t(e, n, i)
    }) : "object" == typeof exports ? module.exports = t(e, require("wolfy87-eventemitter"), require("eventie")) : e.imagesLoaded = t(e, e.EventEmitter, e.eventie)
}(window, function (e, t, n) {
    function i(e, t) {
        for (var n in t) e[n] = t[n];
        return e
    }

    function o(e) {
        var t = [];
        if (function (e) {
            return "[object Array]" === u.call(e)
        }(e)) t = e; else if ("number" == typeof e.length) for (var n = 0, i = e.length; i > n; n++) t.push(e[n]); else t.push(e);
        return t
    }

    function r(e, t, n) {
        if (!(this instanceof r)) return new r(e, t);
        "string" == typeof e && (e = document.querySelectorAll(e)), this.elements = o(e), this.options = i({}, this.options), "function" == typeof t ? n = t : i(this.options, t), n && this.on("always", n), this.getImages(), l && (this.jqDeferred = new l.Deferred);
        var s = this;
        setTimeout(function () {
            s.check()
        })
    }

    function s(e) {
        this.img = e
    }

    function a(e) {
        this.src = e, p[e] = this
    }

    var l = e.jQuery, c = e.console, d = void 0 !== c, u = Object.prototype.toString;
    r.prototype = new t, r.prototype.options = {}, r.prototype.getImages = function () {
        this.images = [];
        for (var e = 0, t = this.elements.length; t > e; e++) {
            var n = this.elements[e];
            "IMG" === n.nodeName && this.addImage(n);
            var i = n.nodeType;
            if (i && (1 === i || 9 === i || 11 === i)) for (var o = n.querySelectorAll("img"), r = 0, s = o.length; s > r; r++) {
                var a = o[r];
                this.addImage(a)
            }
        }
    }, r.prototype.addImage = function (e) {
        var t = new s(e);
        this.images.push(t)
    }, r.prototype.check = function () {
        function e(e, o) {
            return t.options.debug && d && c.log("confirm", e, o), t.progress(e), ++n === i && t.complete(), !0
        }

        var t = this, n = 0, i = this.images.length;
        if (this.hasAnyBroken = !1, i) for (var o = 0; i > o; o++) {
            var r = this.images[o];
            r.on("confirm", e), r.check()
        } else this.complete()
    }, r.prototype.progress = function (e) {
        this.hasAnyBroken = this.hasAnyBroken || !e.isLoaded;
        var t = this;
        setTimeout(function () {
            t.emit("progress", t, e), t.jqDeferred && t.jqDeferred.notify && t.jqDeferred.notify(t, e)
        })
    }, r.prototype.complete = function () {
        var e = this.hasAnyBroken ? "fail" : "done";
        this.isComplete = !0;
        var t = this;
        setTimeout(function () {
            if (t.emit(e, t), t.emit("always", t), t.jqDeferred) {
                var n = t.hasAnyBroken ? "reject" : "resolve";
                t.jqDeferred[n](t)
            }
        })
    }, l && (l.fn.imagesLoaded = function (e, t) {
        return new r(this, e, t).jqDeferred.promise(l(this))
    }), s.prototype = new t, s.prototype.check = function () {
        var e = p[this.img.src] || new a(this.img.src);
        if (e.isConfirmed) this.confirm(e.isLoaded, "cached was confirmed"); else if (this.img.complete && void 0 !== this.img.naturalWidth) this.confirm(0 !== this.img.naturalWidth, "naturalWidth"); else {
            var t = this;
            e.on("confirm", function (e, n) {
                return t.confirm(e.isLoaded, n), !0
            }), e.check()
        }
    }, s.prototype.confirm = function (e, t) {
        this.isLoaded = e, this.emit("confirm", this, t)
    };
    var p = {};
    return a.prototype = new t, a.prototype.check = function () {
        if (!this.isChecked) {
            var e = new Image;
            n.bind(e, "load", this), n.bind(e, "error", this), e.src = this.src, this.isChecked = !0
        }
    }, a.prototype.handleEvent = function (e) {
        var t = "on" + e.type;
        this[t] && this[t](e)
    }, a.prototype.onload = function (e) {
        this.confirm(!0, "onload"), this.unbindProxyEvents(e)
    }, a.prototype.onerror = function (e) {
        this.confirm(!1, "onerror"), this.unbindProxyEvents(e)
    }, a.prototype.confirm = function (e, t) {
        this.isConfirmed = !0, this.isLoaded = e, this.emit("confirm", this, t)
    }, a.prototype.unbindProxyEvents = function (e) {
        n.unbind(e.target, "load", this), n.unbind(e.target, "error", this)
    }, r
}), function (e) {
    function t(e) {
        return new RegExp("(^|\\s+)" + e + "(\\s+|$)")
    }

    function n(e, t) {
        (i(e, t) ? r : o)(e, t)
    }

    var i, o, r;
    "classList" in document.documentElement ? (i = function (e, t) {
        return e.classList.contains(t)
    }, o = function (e, t) {
        e.classList.add(t)
    }, r = function (e, t) {
        e.classList.remove(t)
    }) : (i = function (e, n) {
        return t(n).test(e.className)
    }, o = function (e, t) {
        i(e, t) || (e.className = e.className + " " + t)
    }, r = function (e, n) {
        e.className = e.className.replace(t(n), " ")
    });
    var s = {hasClass: i, addClass: o, removeClass: r, toggleClass: n, has: i, add: o, remove: r, toggle: n};
    "function" == typeof define && define.amd ? define("classie/classie", s) : "object" == typeof exports ? module.exports = s : e.classie = s
}(window), function (e, t) {
    "function" == typeof define && define.amd ? define("packery/js/rect", t) : "object" == typeof exports ? module.exports = t() : (e.Packery = e.Packery || {}, e.Packery.Rect = t())
}(window, function () {
    function e(t) {
        for (var n in e.defaults) this[n] = e.defaults[n];
        for (n in t) this[n] = t[n]
    }

    return (window.Packery = function () {
    }).Rect = e, e.defaults = {x: 0, y: 0, width: 0, height: 0}, e.prototype.contains = function (e) {
        var t = e.width || 0, n = e.height || 0;
        return this.x <= e.x && this.y <= e.y && this.x + this.width >= e.x + t && this.y + this.height >= e.y + n
    }, e.prototype.overlaps = function (e) {
        var t = this.x + this.width, n = this.y + this.height, i = e.x + e.width, o = e.y + e.height;
        return this.x < i && t > e.x && this.y < o && n > e.y
    }, e.prototype.getMaximalFreeRects = function (t) {
        if (!this.overlaps(t)) return !1;
        var n, i = [], o = this.x + this.width, r = this.y + this.height, s = t.x + t.width, a = t.y + t.height;
        return this.y < t.y && (n = new e({
            x: this.x,
            y: this.y,
            width: this.width,
            height: t.y - this.y
        }), i.push(n)), o > s && (n = new e({
            x: s,
            y: this.y,
            width: o - s,
            height: this.height
        }), i.push(n)), r > a && (n = new e({
            x: this.x,
            y: a,
            width: this.width,
            height: r - a
        }), i.push(n)), this.x < t.x && (n = new e({
            x: this.x,
            y: this.y,
            width: t.x - this.x,
            height: this.height
        }), i.push(n)), i
    }, e.prototype.canFit = function (e) {
        return this.width >= e.width && this.height >= e.height
    }, e
}), function (e, t) {
    if ("function" == typeof define && define.amd) define("packery/js/packer", ["./rect"], t); else if ("object" == typeof exports) module.exports = t(require("./rect")); else {
        var n = e.Packery = e.Packery || {};
        n.Packer = t(n.Rect)
    }
}(window, function (e) {
    function t(e, t, n) {
        this.width = e || 0, this.height = t || 0, this.sortDirection = n || "downwardLeftToRight", this.reset()
    }

    t.prototype.reset = function () {
        this.spaces = [], this.newSpaces = [];
        var t = new e({x: 0, y: 0, width: this.width, height: this.height});
        this.spaces.push(t), this.sorter = n[this.sortDirection] || n.downwardLeftToRight
    }, t.prototype.pack = function (e) {
        for (var t = 0, n = this.spaces.length; n > t; t++) {
            var i = this.spaces[t];
            if (i.canFit(e)) {
                this.placeInSpace(e, i);
                break
            }
        }
    }, t.prototype.placeInSpace = function (e, t) {
        e.x = t.x, e.y = t.y, this.placed(e)
    }, t.prototype.placed = function (e) {
        for (var t = [], n = 0, i = this.spaces.length; i > n; n++) {
            var o = this.spaces[n], r = o.getMaximalFreeRects(e);
            r ? t.push.apply(t, r) : t.push(o)
        }
        this.spaces = t, this.mergeSortSpaces()
    }, t.prototype.mergeSortSpaces = function () {
        t.mergeRects(this.spaces), this.spaces.sort(this.sorter)
    }, t.prototype.addSpace = function (e) {
        this.spaces.push(e), this.mergeSortSpaces()
    }, t.mergeRects = function (e) {
        for (var t = 0, n = e.length; n > t; t++) {
            var i = e[t];
            if (i) {
                var o = e.slice(0);
                o.splice(t, 1);
                for (var r = 0, s = 0, a = o.length; a > s; s++) {
                    var l = o[s], c = t > s ? 0 : 1;
                    i.contains(l) && (e.splice(s + c - r, 1), r++)
                }
            }
        }
        return e
    };
    var n = {
        downwardLeftToRight: function (e, t) {
            return e.y - t.y || e.x - t.x
        }, rightwardTopToBottom: function (e, t) {
            return e.x - t.x || e.y - t.y
        }
    };
    return t
}), function (e, t) {
    "function" == typeof define && define.amd ? define("packery/js/item", ["get-style-property/get-style-property", "outlayer/outlayer", "./rect"], t) : "object" == typeof exports ? module.exports = t(require("desandro-get-style-property"), require("outlayer"), require("./rect")) : e.Packery.Item = t(e.getStyleProperty, e.Outlayer, e.Packery.Rect)
}(window, function (e, t, n) {
    var i = e("transform"), o = function () {
        t.Item.apply(this, arguments)
    }, r = (o.prototype = new t.Item)._create;
    return o.prototype._create = function () {
        r.call(this), this.rect = new n, this.placeRect = new n
    }, o.prototype.dragStart = function () {
        this.getPosition(), this.removeTransitionStyles(), this.isTransitioning && i && (this.element.style[i] = "none"), this.getSize(), this.isPlacing = !0, this.needsPositioning = !1, this.positionPlaceRect(this.position.x, this.position.y), this.isTransitioning = !1, this.didDrag = !1
    }, o.prototype.dragMove = function (e, t) {
        this.didDrag = !0;
        var n = this.layout.size;
        e -= n.paddingLeft, t -= n.paddingTop, this.positionPlaceRect(e, t)
    }, o.prototype.dragStop = function () {
        this.getPosition();
        var e = this.position.x != this.placeRect.x, t = this.position.y != this.placeRect.y;
        this.needsPositioning = e || t, this.didDrag = !1
    }, o.prototype.positionPlaceRect = function (e, t, n) {
        this.placeRect.x = this.getPlaceRectCoord(e, !0), this.placeRect.y = this.getPlaceRectCoord(t, !1, n)
    }, o.prototype.getPlaceRectCoord = function (e, t, n) {
        var i, o = t ? "Width" : "Height", r = this.size["outer" + o], s = this.layout[t ? "columnWidth" : "rowHeight"],
            a = this.layout.size["inner" + o];
        if (t || (a = Math.max(a, this.layout.maxY), this.layout.rowHeight || (a -= this.layout.gutter)), s) {
            var l;
            s += this.layout.gutter, a += t ? this.layout.gutter : 0, e = Math.round(e / s), l = this.layout.options.isHorizontal ? t ? "ceil" : "floor" : t ? "floor" : "ceil";
            var c = Math[l](a / s);
            i = c -= Math.ceil(r / s)
        } else i = a - r;
        return e = n ? e : Math.min(e, i), e *= s || 1, Math.max(0, e)
    }, o.prototype.copyPlaceRectPosition = function () {
        this.rect.x = this.placeRect.x, this.rect.y = this.placeRect.y
    }, o.prototype.removeElem = function () {
        this.element.parentNode.removeChild(this.element), this.layout.packer.addSpace(this.rect), this.emitEvent("remove", [this])
    }, o
}), function (e, t) {
    "function" == typeof define && define.amd ? define("packery/js/packery", ["classie/classie", "get-size/get-size", "outlayer/outlayer", "./rect", "./packer", "./item"], t) : "object" == typeof exports ? module.exports = t(require("desandro-classie"), require("get-size"), require("outlayer"), require("./rect"), require("./packer"), require("./item")) : e.Packery = t(e.classie, e.getSize, e.Outlayer, e.Packery.Rect, e.Packery.Packer, e.Packery.Item)
}(window, function (e, t, n, i, o, r) {
    function s(e, t) {
        return e.position.y - t.position.y || e.position.x - t.position.x
    }

    function a(e, t) {
        return e.position.x - t.position.x || e.position.y - t.position.y
    }

    i.prototype.canFit = function (e) {
        return this.width >= e.width - 1 && this.height >= e.height - 1
    };
    var l = n.create("packery");
    return l.Item = r, l.prototype._create = function () {
        n.prototype._create.call(this), this.packer = new o, this.stamp(this.options.stamped);
        var e = this;
        this.handleDraggabilly = {
            dragStart: function () {
                e.itemDragStart(this.element)
            }, dragMove: function () {
                e.itemDragMove(this.element, this.position.x, this.position.y)
            }, dragEnd: function () {
                e.itemDragEnd(this.element)
            }
        }, this.handleUIDraggable = {
            start: function (t) {
                e.itemDragStart(t.currentTarget)
            }, drag: function (t, n) {
                e.itemDragMove(t.currentTarget, n.position.left, n.position.top)
            }, stop: function (t) {
                e.itemDragEnd(t.currentTarget)
            }
        }
    }, l.prototype._resetLayout = function () {
        this.getSize(), this._getMeasurements();
        var e = this.packer;
        this.options.isHorizontal ? (e.width = Number.POSITIVE_INFINITY, e.height = this.size.innerHeight + this.gutter, e.sortDirection = "rightwardTopToBottom") : (e.width = this.size.innerWidth + this.gutter, e.height = Number.POSITIVE_INFINITY, e.sortDirection = "downwardLeftToRight"), e.reset(), this.maxY = 0, this.maxX = 0
    }, l.prototype._getMeasurements = function () {
        this._getMeasurement("columnWidth", "width"), this._getMeasurement("rowHeight", "height"), this._getMeasurement("gutter", "width")
    }, l.prototype._getItemLayoutPosition = function (e) {
        return this._packItem(e), e.rect
    }, l.prototype._packItem = function (e) {
        this._setRectSize(e.element, e.rect), this.packer.pack(e.rect), this._setMaxXY(e.rect)
    }, l.prototype._setMaxXY = function (e) {
        this.maxX = Math.max(e.x + e.width, this.maxX), this.maxY = Math.max(e.y + e.height, this.maxY)
    }, l.prototype._setRectSize = function (e, n) {
        var i = t(e), o = i.outerWidth, r = i.outerHeight;
        (o || r) && (o = this._applyGridGutter(o, this.columnWidth), r = this._applyGridGutter(r, this.rowHeight)), n.width = Math.min(o, this.packer.width), n.height = Math.min(r, this.packer.height)
    }, l.prototype._applyGridGutter = function (e, t) {
        if (!t) return e + this.gutter;
        var n = e % (t += this.gutter);
        return Math[n && 1 > n ? "round" : "ceil"](e / t) * t
    }, l.prototype._getContainerSize = function () {
        return this.options.isHorizontal ? {width: this.maxX - this.gutter} : {height: this.maxY - this.gutter}
    }, l.prototype._manageStamp = function (e) {
        var t, n = this.getItem(e);
        if (n && n.isPlacing) t = n.placeRect; else {
            var o = this._getElementOffset(e);
            t = new i({x: this.options.isOriginLeft ? o.left : o.right, y: this.options.isOriginTop ? o.top : o.bottom})
        }
        this._setRectSize(e, t), this.packer.placed(t), this._setMaxXY(t)
    }, l.prototype.sortItemsByPosition = function () {
        var e = this.options.isHorizontal ? a : s;
        this.items.sort(e)
    }, l.prototype.fit = function (e, t, n) {
        var i = this.getItem(e);
        i && (this._getMeasurements(), this.stamp(i.element), i.getSize(), i.isPlacing = !0, t = void 0 === t ? i.rect.x : t, n = void 0 === n ? i.rect.y : n, i.positionPlaceRect(t, n, !0), this._bindFitEvents(i), i.moveTo(i.placeRect.x, i.placeRect.y), this.layout(), this.unstamp(i.element), this.sortItemsByPosition(), i.isPlacing = !1, i.copyPlaceRectPosition())
    }, l.prototype._bindFitEvents = function (e) {
        function t() {
            2 == ++i && n.emitEvent("fitComplete", [e])
        }

        var n = this, i = 0;
        e.on("layout", function () {
            return t(), !0
        }), this.on("layoutComplete", function () {
            return t(), !0
        })
    }, l.prototype.resize = function () {
        var e = t(this.element), n = this.size && e, i = this.options.isHorizontal ? "innerHeight" : "innerWidth";
        n && e[i] == this.size[i] || this.layout()
    }, l.prototype.itemDragStart = function (e) {
        this.stamp(e);
        var t = this.getItem(e);
        t && t.dragStart()
    }, l.prototype.itemDragMove = function (e, t, n) {
        var i = this.getItem(e);
        i && i.dragMove(t, n);
        var o = this;
        this.clearDragTimeout(), this.dragTimeout = setTimeout(function () {
            o.layout(), delete o.dragTimeout
        }, 40)
    }, l.prototype.clearDragTimeout = function () {
        this.dragTimeout && clearTimeout(this.dragTimeout)
    }, l.prototype.itemDragEnd = function (t) {
        var n, i = this.getItem(t);
        if (i && (n = i.didDrag, i.dragStop()), i && (n || i.needsPositioning)) {
            e.add(i.element, "is-positioning-post-drag");
            var o = this._getDragEndLayoutComplete(t, i);
            i.needsPositioning ? (i.on("layout", o), i.moveTo(i.placeRect.x, i.placeRect.y)) : i && i.copyPlaceRectPosition(), this.clearDragTimeout(), this.on("layoutComplete", o), this.layout()
        } else this.unstamp(t)
    }, l.prototype._getDragEndLayoutComplete = function (t, n) {
        var i = n && n.needsPositioning, o = 0, r = i ? 2 : 1, s = this;
        return function () {
            return ++o != r || (n && (e.remove(n.element, "is-positioning-post-drag"), n.isPlacing = !1, n.copyPlaceRectPosition()), s.unstamp(t), s.sortItemsByPosition(), i && s.emitEvent("dragItemPositioned", [n]), !0)
        }
    }, l.prototype.bindDraggabillyEvents = function (e) {
        e.on("dragStart", this.handleDraggabilly.dragStart), e.on("dragMove", this.handleDraggabilly.dragMove), e.on("dragEnd", this.handleDraggabilly.dragEnd)
    }, l.prototype.bindUIDraggableEvents = function (e) {
        e.on("dragstart", this.handleUIDraggable.start).on("drag", this.handleUIDraggable.drag).on("dragstop", this.handleUIDraggable.stop)
    }, l.Rect = i, l.Packer = o, l
}), function (e, t) {
    "function" == typeof define && define.amd ? define(["isotope/js/layout-mode", "packery/js/packery", "get-size/get-size"], t) : "object" == typeof exports ? module.exports = t(require("isotope-layout/js/layout-mode"), require("packery"), require("get-size")) : t(e.Isotope.LayoutMode, e.Packery, e.getSize)
}(window, function (e, t, n) {
    var i = e.create("packery"), o = i.prototype._getElementOffset, r = i.prototype._getMeasurement;
    (function (e, t) {
        for (var n in t) e[n] = t[n]
    })(i.prototype, t.prototype), i.prototype._getElementOffset = o, i.prototype._getMeasurement = r;
    var s = i.prototype._resetLayout;
    i.prototype._resetLayout = function () {
        this.packer = this.packer || new t.Packer, s.apply(this, arguments)
    };
    var a = i.prototype._getItemLayoutPosition;
    i.prototype._getItemLayoutPosition = function (e) {
        return e.rect = e.rect || new t.Rect, a.call(this, e)
    };
    var l = i.prototype._manageStamp;
    return i.prototype._manageStamp = function () {
        this.options.isOriginLeft = this.isotope.options.isOriginLeft, this.options.isOriginTop = this.isotope.options.isOriginTop, l.apply(this, arguments)
    }, i.prototype.needsResizeLayout = function () {
        var e = n(this.element), t = this.size && e, i = this.options.isHorizontal ? "innerHeight" : "innerWidth";
        return t && e[i] != this.size[i]
    }, i
}), function (e, t) {
    var n = t.document;
    e.fn.share = function (i) {
        var o = {
            init: function (i) {
                this.share.settings = e.extend({}, this.share.defaults, i);
                var o = (this.share.settings, this.share.settings.networks), s = this.share.settings.theme,
                    a = this.share.settings.orientation, l = this.share.settings.affix, c = this.share.settings.margin,
                    d = this.share.settings.title || e(n).attr("title"),
                    u = this.share.settings.urlToShare || e(location).attr("href"), p = "";
                return e.each(e(n).find('meta[name="description"]'), function (t, n) {
                    p = e(n).attr("content")
                }), this.each(function () {
                    var n, i = e(this), f = i.attr("id"), h = encodeURIComponent(u), m = d.replace("|", ""),
                        v = p.substring(0, 250);
                    o.forEach(function (t) {
                        n = (n = r.networkDefs[t].url).replace("|u|", h).replace("|t|", m).replace("|d|", v).replace("|140|", m.substring(0, 130)), e("<a href='" + n + "' title='Share this page on " + t + "' class='pop share-" + s + " share-" + s + "-" + t + "'></a>").appendTo(i)
                    }), e("#" + f + ".share-" + s).css("margin", c), "horizontal" != a ? e("#" + f + " a.share-" + s).css("display", "block") : e("#" + f + " a.share-" + s).css("display", "inline-block"), void 0 !== l && (i.addClass("share-affix"), -1 != l.indexOf("right") ? (i.css("left", "auto"), i.css("right", "0px"), -1 != l.indexOf("center") && i.css("top", "40%")) : -1 != l.indexOf("left center") && i.css("top", "40%"), -1 != l.indexOf("bottom") && (i.css("bottom", "0px"), i.css("top", "auto"), -1 != l.indexOf("center") && i.css("left", "40%"))), e(".pop").click(function () {
                        return t.open(e(this).attr("href"), "t", "toolbar=0,resizable=1,status=0,width=640,height=528"), !1
                    })
                })
            }
        }, r = {
            networkDefs: {
                facebook: {url: "http://www.facebook.com/share.php?u=|u|"},
                twitter: {url: "https://twitter.com/share?via=in1.com&text=|140|"},
                linkedin: {url: "http://www.linkedin.com/shareArticle?mini=true&url=|u|&title=|t|&summary=|d|&source=in1.com"},
                in1: {url: "http://www.in1.com/cast?u=|u|", w: "490", h: "529"},
                tumblr: {url: "http://www.tumblr.com/share?v=3&u=|u|"},
                digg: {url: "http://digg.com/submit?url=|u|&title=|t|"},
                googleplus: {url: "https://plusone.google.com/_/+1/confirm?hl=en&url=|u|"},
                reddit: {url: "http://reddit.com/submit?url=|u|"},
                pinterest: {url: "http://pinterest.com/pin/create/button/?url=|u|&media=&description=|d|"},
                posterous: {url: "http://posterous.com/share?linkto=|u|&title=|t|"},
                stumbleupon: {url: "http://www.stumbleupon.com/submit?url=|u|&title=|t|"},
                email: {url: "mailto:?subject=|t|"}
            }
        };
        return o[i] ? o[i].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof i && i ? void e.error('Method "' + i + '" does not exist in social plugin') : o.init.apply(this, arguments)
    }, e.fn.share.defaults = {
        networks: ["in1", "facebook", "twitter", "linkedin"],
        theme: "icon",
        autoShow: !0,
        margin: "3px",
        orientation: "horizontal",
        useIn1: !0
    }, e.fn.share.settings = {}
}(jQuery, window), "function" != typeof Object.create && (Object.create = function (e) {
    function t() {
    }

    return t.prototype = e, new t
}), function (e, t, n) {
    var i = function (e) {
        var t = n.createElement("script"), i = n.getElementsByTagName("head")[0];
        t.src = location.protocol + "//www.youtube.com/iframe_api", i.appendChild(t), i = null, t = null, o(e)
    }, o = function (n) {
        "undefined" == typeof YT && void 0 === t.loadingPlayer ? (t.loadingPlayer = !0, t.dfd = e.Deferred(), t.onYouTubeIframeAPIReady = function () {
            t.onYouTubeIframeAPIReady = null, t.dfd.resolve("John"), n()
        }) : t.dfd.done(function (e) {
            n()
        })
    };
    YTPlayer = {
        player: null,
        defaults: {
            ratio: 16 / 9,
            videoId: "LSmgKRx5pBo",
            mute: !0,
            repeat: !0,
            width: e(t).width(),
            playButtonClass: "YTPlayer-play",
            pauseButtonClass: "YTPlayer-pause",
            muteButtonClass: "YTPlayer-mute",
            volumeUpClass: "YTPlayer-volume-up",
            volumeDownClass: "YTPlayer-volume-down",
            start: 0,
            pauseOnScroll: !1,
            fitToBackground: !0,
            playerVars: {
                modestbranding: 1,
                autoplay: 1,
                controls: 0,
                showinfo: 0,
                wmode: "transparent",
                branding: 0,
                rel: 0,
                autohide: 0,
                origin: t.location.origin
            },
            events: null
        },
        init: function (n, o) {
            var r = this;
            return r.userOptions = o, r.$body = e("body"), r.$node = e(n), r.$window = e(t), r.defaults.events = {
                onReady: function (e) {
                    r.onPlayerReady(e), r.options.pauseOnScroll && r.pauseOnScroll(), "function" == typeof r.options.callback && r.options.callback.call(this)
                }, onStateChange: function (e) {
                    1 === e.data ? r.$node.addClass("loaded") : 0 === e.data && r.options.repeat && r.player.seekTo(r.options.start)
                }
            }, r.options = e.extend(!0, {}, r.defaults, r.userOptions), r.ID = (new Date).getTime(), r.holderID = "YTPlayer-ID-" + r.ID, r.options.fitToBackground ? r.createBackgroundVideo() : r.createContainerVideo(), r.$window.on("resize.YTplayer" + r.ID, function () {
                r.resize(r)
            }), i(r.onYouTubeIframeAPIReady.bind(r)), r.resize(r), r
        },
        pauseOnScroll: function () {
            var e = this;
            e.$window.on("scroll.YTplayer" + e.ID, function () {
                1 === e.player.getPlayerState() && e.player.pauseVideo()
            }), e.$window.scrollStopped(function () {
                2 === e.player.getPlayerState() && e.player.playVideo()
            })
        },
        createContainerVideo: function () {
            var t = this,
                n = e('<div id="ytplayer-container' + t.ID + '" >                                    <div id="' + t.holderID + '" class="ytplayer-player"></div>                                     </div>                                     <div id="ytplayer-shield"></div>');
            t.$node.append(n), t.$YTPlayerString = n, n = null
        },
        createBackgroundVideo: function () {
            var t = this,
                n = e('<div id="ytplayer-container' + t.ID + '" class="ytplayer-container background">                                    <div id="' + t.holderID + '" class="ytplayer-player"></div>                                    </div>                                    <div id="ytplayer-shield"></div>');
            t.$node.append(n), t.$YTPlayerString = n, n = null
        },
        resize: function (t) {
            var n = e(".media-container");
            t.options.fitToBackground || (n = t.$node);
            var i, o, r = n.width(), s = n.height(), a = e("#" + t.holderID);
            r / t.options.ratio < s ? (i = Math.ceil(s * t.options.ratio), a.width(i).height(s).css({
                left: (r - i) / 2,
                top: 0
            })) : (o = Math.ceil(r / t.options.ratio), a.width(r).height(o).css({left: 0, top: 0})), a = null, n = null
        },
        onYouTubeIframeAPIReady: function () {
            var e = this;
            e.player = new t.YT.Player(e.holderID, {
                width: e.options.width,
                height: Math.ceil(e.options.width / e.options.ratio),
                videoId: e.options.videoId,
                playerVars: e.options.playerVars,
                events: e.options.events
            })
        },
        onPlayerReady: function (e) {
            this.options.mute && e.target.mute(), e.target.playVideo()
        },
        getPlayer: function () {
            return this.player
        },
        destroy: function () {
            var n = this;
            n.$node.removeData("yt-init").removeData("ytPlayer").removeClass("loaded"), n.$YTPlayerString.remove(), e(t).off("resize.YTplayer" + n.ID), e(t).off("scroll.YTplayer" + n.ID), n.$body = null, n.$node = null, n.$YTPlayerString = null, n.player.destroy(), n.player = null
        }
    }, e.fn.scrollStopped = function (t) {
        var n = e(this), i = this;
        n.scroll(function () {
            n.data("scrollTimeout") && clearTimeout(n.data("scrollTimeout")), n.data("scrollTimeout", setTimeout(t, 250, i))
        })
    }, e.fn.YTPlayer = function (t) {
        return this.each(function () {
            var n = this;
            e(n).data("yt-init", !0);
            var i = Object.create(YTPlayer);
            i.init(n, t), e.data(n, "ytPlayer", i)
        })
    }
}(jQuery, window, document), function (e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : "undefined" != typeof exports ? module.exports = e(require("jquery")) : e(jQuery)
}(function (e) {
    function W(e) {
        if (!console || !console.warn) throw"Scrollax: " + e;
        console.warn("Scrollax: " + e)
    }

    function ka(e) {
        var t = !!("pageYOffset" in e);
        return {
            width: t ? window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth : e.offsetWidth,
            height: t ? window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight : e.offsetHeight,
            left: e[t ? "pageXOffset" : "scrollLeft"],
            top: e[t ? "pageYOffset" : "scrollTop"]
        }
    }

    function X(a) {
        return (a = a.data("scrollax")) && eval("({" + a + "})") || {}
    }

    function Y(e) {
        var t, n;
        return !!(e && "object" == typeof e && "object" == typeof e.window && e.window == e && e.setTimeout && e.alert && (t = e.document) && "object" == typeof t && (n = t.defaultView || t.parentWindow) && "object" == typeof n && n == e)
    }

    var v = Array.prototype, C = v.push, Z = v.splice, aa = Object.prototype.hasOwnProperty, la = /[-+]?\d+(\.\d+)?/g,
        ma = "translateX translateY rotate rotateX rotateY rotateZ skewX skewY scaleX scaleY".split(" "),
        ba = e(window), ca = e(document.body), da, ea, L, M, N, q = function (t, n, i) {
            function o() {
                return B = Q ? ca.find(U) : u.find(U), R.length = 0, x = !!H.horizontal, B.each(K), s(), H.performanceTrick && (g = Q ? ca : u), l("load"), d
            }

            function r() {
                h && (h = clearTimeout(h)), h = setTimeout(function () {
                    d.reload()
                })
            }

            function s() {
                var e = R.length;
                if (H.performanceTrick && g && (clearTimeout(y), b || (g.addClass("scrollax-performance"), b = !0), y = setTimeout(function () {
                    g.removeClass("scrollax-performance"), b = !1
                }, 100)), e) {
                    w = ka(t);
                    for (var n = 0; n < e; n++) S = R[n], 0 > (T = L(S.element, t))[x ? "right" : "bottom"] || T[x ? "left" : "top"] > w[x ? "width" : "height"] || ($ = S.options, k = $.offset || H.offset || 0, E = T[x ? "right" : "bottom"], A = T[x ? "width" : "height"], 0 > (_ = (A - E + k) / A) && (E = T[x ? "left" : "top"], A = w[x ? "width" : "height"], _ = (A - E + k) / A - 1), 1 < _ || -1 > _ || a(S, _));
                    l("scroll", w)
                }
            }

            function a(t, n) {
                var i = (O = t.parallaxElements).length;
                if (i) for (var o = 0; o < i; o++) {
                    j = O[o];
                    var r = j.element, s = n;
                    for (D in I = j.properties || (x ? {translateX: "100%"} : {translateY: "100%"}), z = "", I) {
                        if ("number" == typeof (P = I[D])) P *= s; else if ("string" == typeof P) for (F = P.match(la), m = 0, v = F.length; m < v; m++) P = P.replace(F[m], parseFloat(F[m] * s));
                        if (-1 !== e.inArray(D, ma)) z += D + "(" + P + ")"; else {
                            var a, l = r.style;
                            "opacity" === D ? a = 0 > (a = 0 > s ? 1 + P : 1 - P) ? 0 : 1 < a ? 1 : a : a = P, l[D] = a
                        }
                    }
                    z && (r.style[da] = ea + z)
                }
            }

            function l(e, t) {
                if (J[e]) {
                    for (v = J[e].length, m = G.length = 0; m < v; m++) C.call(G, J[e][m]);
                    for (m = 0; m < v; m++) G[m].call(d, e, t)
                }
            }

            function c(e, t) {
                for (var n = 0, i = J[e].length; n < i; n++) if (J[e][n] === t) return n;
                return -1
            }

            var d = this, u = t && e(t).eq(0) || ba, p = q.instances, f = null;
            if (t = u[0], e.each(p, function (e, n) {
                e && e.frame === t && (f = !0)
            }), !t || f) W(f ? "Scrollax: Scrollax has been initialized for this frame!" : "Scrollax: Frame is not available!"); else {
                var h, m, v, g, y, b, w, x, k, T, S, $, _, E, A, O, j, I, D, P, z, F, H = e.extend({}, q.defaults, n),
                    R = [], B = null, U = H.parentSelector || "[data-scrollax-parent]",
                    V = H.elementsSelector || "[data-scrollax]", J = {}, G = [], Q = Y(t);
                d.frame = t, d.options = H, d.parents = R, d.initialized = !1, d.reload = o;
                var K = function (t, n) {
                    var i = e(n), o = X(e(n)), r = {};
                    r.element = n, r.options = o, r.parallaxElements = [], i.find(V).each(function (t, n) {
                        var i = X(e(n));
                        i.element = n, C.call(r.parallaxElements, i)
                    }), C.call(R, r)
                };
                d.scroll = s, d.getIndex = function (e) {
                    return void 0 !== e ? "number" != typeof e && "string" != typeof e || "" === e || isNaN(e) ? B.index(e) : 0 <= e && e < R.length ? e : -1 : -1
                }, d.one = function (e, t) {
                    return d.on(e, function n() {
                        t.apply(d, arguments), d.off(e, n)
                    }), d
                }, d.on = function (e, t) {
                    if ("object" == typeof e) for (var n in e) aa.call(e, n) && d.on(n, e[n]); else if ("function" == typeof t) for (var i = 0, o = (n = e.split(" ")).length; i < o; i++) J[n[i]] = J[n[i]] || [], -1 === c(n[i], t) && C.call(J[n[i]], t); else if ("array" == typeof t) for (n = 0, i = t.length; n < i; n++) d.on(e, t[n]);
                    return d
                }, d.off = function (e, t) {
                    if (t instanceof Array) for (var n = 0, i = t.length; n < i; n++) d.off(e, t[n]); else {
                        i = 0;
                        for (var o = (n = e.split(" ")).length; i < o; i++) if (J[n[i]] = J[n[i]] || [], void 0 === t) J[n[i]].length = 0; else {
                            var r = c(n[i], t);
                            -1 !== r && Z.call(J[n[i]], r, 1)
                        }
                    }
                    return d
                }, d.set = function (t, n) {
                    return e.isPlainObject(t) ? e.extend(H, t) : aa.call(H, t) && (H[t] = n), o(), d
                }, d.destroy = function () {
                    return N(window, "resize", r), N(t, "scroll", s), e.each(p, function (e, n) {
                        e && e.frame === t && Z.call(q.instances, n, 1)
                    }), R.length = 0, d.initialized = !1, l("destroy"), d
                }, d.init = function () {
                    if (!d.initialized) return d.on(i), o(), M(window, "resize", r), M(t, "scroll", s), C.call(q.instances, d), d.initialized = !0, l("initialized"), d
                }
            }
        };
    q.instances = [], function () {
        var e, t, n, i, o, r, s, a;
        L = function (l, c) {
            if (t = l.ownerDocument || l, n = t.documentElement, i = Y(c) ? c : t.defaultView || window, c = c && c !== t ? c : n, o = (i.pageYOffset || n.scrollTop) - n.clientTop, r = (i.pageXOffset || n.scrollLeft) - n.clientLeft, s = {
                top: 0,
                left: 0
            }, !l || !l.getBoundingClientRect) return null;
            var d = {}, u = l.getBoundingClientRect();
            for (e in u) d[e] = u[e];
            return (s = d).width = s.right - s.left, s.height = s.bottom - s.top, c === i ? s : (s.top += o, s.left += r, s.right += r, s.bottom += o, c === n ? s : (a = L(c), s.left -= a.left, s.right -= a.left, s.top -= a.top, s.bottom -= a.top, s))
        }
    }(), function () {
        function e() {
            this.returnValue = !1
        }

        function t() {
            this.cancelBubble = !0
        }

        M = window.addEventListener ? function (e, t, n, i) {
            return e.addEventListener(t, n, i || !1), n
        } : function (n, i, o) {
            var r = i + o;
            return n[r] = n[r] || function () {
                var i = window.event;
                i.target = i.srcElement, i.preventDefault = e, i.stopPropagation = t, o.call(n, i)
            }, n.attachEvent("on" + i, n[r]), o
        }, N = window.removeEventListener ? function (e, t, n, i) {
            return e.removeEventListener(t, n, i || !1), n
        } : function (e, t, n) {
            var i = t + n;
            e.detachEvent("on" + t, e[i]);
            try {
                delete e[i]
            } catch (t) {
                e[i] = void 0
            }
            return n
        }
    }(), function () {
        function e(e) {
            for (var i = 0, o = t.length; i < o; i++) {
                var r = t[i] ? t[i] + e.charAt(0).toUpperCase() + e.slice(1) : e;
                if (null != n.style[r]) return r
            }
        }

        var t = ["", "webkit", "moz", "ms", "o"], n = document.createElement("div");
        da = e("transform"), ea = e("perspective") ? "translateZ(0) " : ""
    }(), q.defaults = {
        horizontal: !1,
        offset: 0,
        parentSelector: null,
        elementsSelector: null,
        performanceTrick: !1
    }, window.Scrollax = q, e.fn.Scrollax = function (t, n) {
        var i, o;
        return e.isPlainObject(t) || ("string" != typeof t && !1 !== t || (i = !1 === t ? "destroy" : t, o = slice.call(arguments, 1)), t = {}), this.each(function (r, s) {
            var a = e.data(s, "scrollax");
            a || i ? a && i && a[i] && a[i].apply(a, o) : e.data(s, "scrollax", new q(s, t, n).init())
        })
    }, e.Scrollax = function (e, t) {
        ba.Scrollax(e, t)
    };
    var v = document.head || document.getElementsByTagName("head")[0], w = document.createElement("style");
    return w.type = "text/css", w.styleSheet ? w.styleSheet.cssText = ".scrollax-performance, .scrollax-performance *, .scrollax-performance *:before, .scrollax-performance *:after { pointer-events: none !important; -webkit-animation-play-state: paused !important; animation-play-state: paused !important; };" : w.appendChild(document.createTextNode(".scrollax-performance, .scrollax-performance *, .scrollax-performance *:before, .scrollax-performance *:after { pointer-events: none !important; -webkit-animation-play-state: paused !important; animation-play-state: paused !important; };")), v.appendChild(w), q
}), function (e) {
    e.fn.appear = function (t, n) {
        var i = e.extend({one: !0}, n);
        return this.each(function () {
            var n = e(this);
            if (n.appeared = !1, t) {
                var o = e(window), r = function () {
                    if (n.is(":visible")) {
                        var e = o.scrollLeft(), t = o.scrollTop(), r = n.offset(), s = r.left, a = r.top;
                        a + n.height() >= t && a <= t + o.height() && s + n.width() >= e && s <= e + o.width() ? n.appeared || n.trigger("appear", i.data) : n.appeared = !1
                    } else n.appeared = !1
                }, s = function () {
                    if (n.appeared = !0, i.one) {
                        o.unbind("scroll", r);
                        var s = e.inArray(r, e.fn.appear.checks);
                        s >= 0 && e.fn.appear.checks.splice(s, 1)
                    }
                    t.apply(this, arguments)
                };
                i.one ? n.one("appear", i.data, s) : n.bind("appear", i.data, s), o.scroll(r), e.fn.appear.checks.push(r), r()
            } else n.trigger("appear", i.data)
        })
    }, e.extend(e.fn.appear, {
        checks: [], timeout: null, checkAll: function () {
            var t = e.fn.appear.checks.length;
            if (t > 0) for (; t--;) e.fn.appear.checks[t]()
        }, run: function () {
            e.fn.appear.timeout && clearTimeout(e.fn.appear.timeout), e.fn.appear.timeout = setTimeout(e.fn.appear.checkAll, 20)
        }
    }), e.each(["append", "prepend", "after", "before", "attr", "removeAttr", "addClass", "removeClass", "toggleClass", "remove", "css", "show", "hide"], function (t, n) {
        var i = e.fn[n];
        i && (e.fn[n] = function () {
            var t = i.apply(this, arguments);
            return e.fn.appear.run(), t
        })
    })
}(jQuery), "function" != typeof Object.create && (Object.create = function (e) {
    function t() {
    }

    return t.prototype = e, new t
}), function (e, t, n, i) {
    "use strict";
    var o = {
        init: function (n, i) {
            this.options = e.extend({}, e.fn.singlePageNav.defaults, n), this.container = i, this.$container = e(i), this.$links = this.$container.find("a"), "" !== this.options.filter && (this.$links = this.$links.filter(this.options.filter)), this.$window = e(t), this.$htmlbody = e("html, body"), this.$links.on("click.singlePageNav", e.proxy(this.handleClick, this)), this.didScroll = !1, this.checkPosition(), this.setTimer()
        }, handleClick: function (t) {
            var n = this, i = t.currentTarget, o = e(i.hash);
            t.preventDefault(), o.length && (n.clearTimer(), "function" == typeof n.options.beforeStart && n.options.beforeStart(), n.setActiveLink(i.hash), n.scrollTo(o, function () {
                n.options.updateHash && history.pushState && history.pushState(null, null, i.hash), n.setTimer(), "function" == typeof n.options.onComplete && n.options.onComplete()
            }))
        }, scrollTo: function (e, t) {
            var n = this.getCoords(e).top, i = !1;
            this.$htmlbody.stop().animate({scrollTop: n}, {
                duration: this.options.speed,
                easing: this.options.easing,
                complete: function () {
                    "function" != typeof t || i || t(), i = !0
                }
            })
        }, setTimer: function () {
            var e = this;
            e.$window.on("scroll.singlePageNav", function () {
                e.didScroll = !0
            }), e.timer = setInterval(function () {
                e.didScroll && (e.didScroll = !1, e.checkPosition())
            }, 250)
        }, clearTimer: function () {
            clearInterval(this.timer), this.$window.off("scroll.singlePageNav"), this.didScroll = !1
        }, checkPosition: function () {
            var e = this.$window.scrollTop(), t = this.getCurrentSection(e);
            null !== t && this.setActiveLink(t)
        }, getCoords: function (e) {
            return {top: Math.round(e.offset().top) - this.options.offset}
        }, setActiveLink: function (n) {
            var i = this.$container.find("a[href$='" + n + "']");
            i.hasClass(this.options.currentClass) || (this.$links.removeClass(this.options.currentClass), i.addClass(this.options.currentClass), e(".scroll-nav  a").hasClass("act-link") && e(".scroll-nav  a.act-link").each(function () {
                var n = e(this).data("bgscr"), i = e(this).data("bgtex");
                t.navigator.userAgent.indexOf("MSIE ") > 0 || navigator.userAgent.match(/Trident.*rv\:11\./) ? e(".bg-title span").html(i) : e(".bg-title span").html(i).shuffleLetters({}), e(".column-image").addClass("scrbg"), setTimeout(function () {
                    e(".bg-scroll").css("background-image", "url(" + n + ")"), e(".column-image").removeClass("scrbg")
                }, 700)
            }))
        }, getCurrentSection: function (t) {
            var n, i, o;
            for (n = 0; n < this.$links.length; n++) i = this.$links[n].hash, e(i).length && t >= this.getCoords(e(i)).top - this.options.threshold && (o = i);
            return o || (0 === this.$links.length ? null : this.$links[0].hash)
        }
    };
    e.fn.singlePageNav = function (e) {
        return this.each(function () {
            Object.create(o).init(e, this)
        })
    }, e.fn.singlePageNav.defaults = {
        offset: 0,
        threshold: 120,
        speed: 400,
        currentClass: "current",
        easing: "swing",
        updateHash: !1,
        filter: "",
        onComplete: !1,
        beforeStart: !1
    }
}(jQuery, window, document), function (e) {
    e.isScrollToFixed = function (t) {
        return !!e(t).data("ScrollToFixed")
    }, e.ScrollToFixed = function (t, n) {
        var i = this;
        i.$el = e(t), i.el = t, i.$el.data("ScrollToFixed", i);
        var o, r, s, a, l = !1, c = i.$el, d = 0, u = 0, p = -1, f = -1, h = null;

        function m() {
            var e = i.options.limit;
            return e ? "function" == typeof e ? e.apply(c) : e : 0
        }

        function v() {
            return "fixed" === o
        }

        function g() {
            return "absolute" === o
        }

        function y() {
            return !(v() || g())
        }

        function b() {
            v() || (h.css({
                display: c.css("display"),
                width: c.outerWidth(!0),
                height: c.outerHeight(!0),
                float: c.css("float")
            }), cssOptions = {
                "z-index": i.options.zIndex,
                position: "fixed",
                top: -1 == i.options.bottom ? C() : "",
                bottom: -1 == i.options.bottom ? "" : i.options.bottom,
                "margin-left": "0px"
            }, i.options.dontSetWidth || (cssOptions.width = c.width()), c.css(cssOptions), c.addClass(i.options.baseClassName), i.options.className && c.addClass(i.options.className), o = "fixed")
        }

        function w() {
            var e = m(), t = u;
            i.options.removeOffsets && (t = "", e -= d), cssOptions = {
                position: "absolute",
                top: e,
                left: t,
                "margin-left": "0px",
                bottom: ""
            }, i.options.dontSetWidth || (cssOptions.width = c.width()), c.css(cssOptions), o = "absolute"
        }

        function x() {
            y() || (f = -1, h.css("display", "none"), c.css({
                "z-index": a,
                width: "",
                position: r,
                left: "",
                top: s,
                "margin-left": ""
            }), c.removeClass("scroll-to-fixed-fixed"), i.options.className && c.removeClass(i.options.className), o = null)
        }

        function k(e) {
            e != f && (c.css("left", u - e), f = e)
        }

        function C() {
            var e = i.options.marginTop;
            return e ? "function" == typeof e ? e.apply(c) : e : 0
        }

        function T() {
            if (e.isScrollToFixed(c)) {
                var t = l;
                l ? y() && (d = c.offset().top, u = c.offset().left) : (c.trigger("preUnfixed.ScrollToFixed"), x(), c.trigger("unfixed.ScrollToFixed"), f = -1, d = c.offset().top, u = c.offset().left, i.options.offsets && (u += c.offset().left - c.position().left), -1 == p && (p = u), o = c.css("position"), l = !0, -1 != i.options.bottom && (c.trigger("preFixed.ScrollToFixed"), b(), c.trigger("fixed.ScrollToFixed")));
                var n = e(window).scrollLeft(), s = e(window).scrollTop(), a = m();
                i.options.minWidth && e(window).width() < i.options.minWidth ? y() && t || (S(), c.trigger("preUnfixed.ScrollToFixed"), x(), c.trigger("unfixed.ScrollToFixed")) : i.options.maxWidth && e(window).width() > i.options.maxWidth ? y() && t || (S(), c.trigger("preUnfixed.ScrollToFixed"), x(), c.trigger("unfixed.ScrollToFixed")) : -1 == i.options.bottom ? a > 0 && s >= a - C() ? g() && t || (S(), c.trigger("preAbsolute.ScrollToFixed"), w(), c.trigger("unfixed.ScrollToFixed")) : s >= d - C() ? (v() && t || (S(), c.trigger("preFixed.ScrollToFixed"), b(), f = -1, c.trigger("fixed.ScrollToFixed")), k(n)) : y() && t || (S(), c.trigger("preUnfixed.ScrollToFixed"), x(), c.trigger("unfixed.ScrollToFixed")) : a > 0 ? s + e(window).height() - c.outerHeight(!0) >= a - (C() || -function () {
                    if (!i.options.bottom) return 0;
                    return i.options.bottom
                }()) ? v() && (S(), c.trigger("preUnfixed.ScrollToFixed"), "absolute" === r ? w() : x(), c.trigger("unfixed.ScrollToFixed")) : (v() || (S(), c.trigger("preFixed.ScrollToFixed"), b()), k(n), c.trigger("fixed.ScrollToFixed")) : k(n)
            }
        }

        function S() {
            var e = c.css("position");
            "absolute" == e ? c.trigger("postAbsolute.ScrollToFixed") : "fixed" == e ? c.trigger("postFixed.ScrollToFixed") : c.trigger("postUnfixed.ScrollToFixed")
        }

        var $ = function (e) {
            c.is(":visible") && (l = !1, T())
        }, _ = function (e) {
            window.requestAnimationFrame ? requestAnimationFrame(T) : T()
        };
        i.init = function () {
            i.options = e.extend({}, e.ScrollToFixed.defaultOptions, n), a = c.css("z-index"), i.$el.css("z-index", i.options.zIndex), h = e("<div />"), o = c.css("position"), r = c.css("position"), s = c.css("top"), y() && i.$el.after(h), e(window).bind("resize.ScrollToFixed", $), e(window).bind("scroll.ScrollToFixed", _), "ontouchmove" in window && e(window).bind("touchmove.ScrollToFixed", T), i.options.preFixed && c.bind("preFixed.ScrollToFixed", i.options.preFixed), i.options.postFixed && c.bind("postFixed.ScrollToFixed", i.options.postFixed), i.options.preUnfixed && c.bind("preUnfixed.ScrollToFixed", i.options.preUnfixed), i.options.postUnfixed && c.bind("postUnfixed.ScrollToFixed", i.options.postUnfixed), i.options.preAbsolute && c.bind("preAbsolute.ScrollToFixed", i.options.preAbsolute), i.options.postAbsolute && c.bind("postAbsolute.ScrollToFixed", i.options.postAbsolute), i.options.fixed && c.bind("fixed.ScrollToFixed", i.options.fixed), i.options.unfixed && c.bind("unfixed.ScrollToFixed", i.options.unfixed), i.options.spacerClass && h.addClass(i.options.spacerClass), c.bind("resize.ScrollToFixed", function () {
                h.height(c.height())
            }), c.bind("scroll.ScrollToFixed", function () {
                c.trigger("preUnfixed.ScrollToFixed"), x(), c.trigger("unfixed.ScrollToFixed"), T()
            }), c.bind("detach.ScrollToFixed", function (t) {
                !function (e) {
                    (e = e || window.event).preventDefault && e.preventDefault(), e.returnValue = !1
                }(t), c.trigger("preUnfixed.ScrollToFixed"), x(), c.trigger("unfixed.ScrollToFixed"), e(window).unbind("resize.ScrollToFixed", $), e(window).unbind("scroll.ScrollToFixed", _), c.unbind(".ScrollToFixed"), h.remove(), i.$el.removeData("ScrollToFixed")
            }), $()
        }, i.init()
    }, e.ScrollToFixed.defaultOptions = {
        marginTop: 0,
        limit: 0,
        bottom: -1,
        zIndex: 1e3,
        baseClassName: "scroll-to-fixed-fixed"
    }, e.fn.scrollToFixed = function (t) {
        return this.each(function () {
            new e.ScrollToFixed(this, t)
        })
    }
}(jQuery), function (e) {
    e.fn.countTo = function (t) {
        return t = t || {}, e(this).each(function () {
            var n = e.extend({}, e.fn.countTo.defaults, {
                    from: e(this).data("from"),
                    to: e(this).data("num"),
                    speed: e(this).data("speed"),
                    refreshInterval: e(this).data("refresh-interval"),
                    decimals: e(this).data("decimals")
                }, t), i = Math.ceil(n.speed / n.refreshInterval), o = (n.to - n.from) / i, r = this, s = e(this), a = 0,
                l = n.from, c = s.data("countTo") || {};

            function d(e) {
                var t = n.formatter.call(r, e, n);
                s.text(t)
            }

            s.data("countTo", c), c.interval && clearInterval(c.interval), c.interval = setInterval(function () {
                a++, d(l += o), "function" == typeof n.onUpdate && n.onUpdate.call(r, l);
                a >= i && (s.removeData("countTo"), clearInterval(c.interval), l = n.to, "function" == typeof n.onComplete && n.onComplete.call(r, l))
            }, n.refreshInterval), d(l)
        })
    }, e.fn.countTo.defaults = {
        from: 0,
        to: 0,
        speed: 2500,
        refreshInterval: 100,
        decimals: 0,
        formatter: function (e, t) {
            return e.toFixed(t.decimals)
        },
        onUpdate: null,
        onComplete: null
    }
}(jQuery), function (e) {
    "use strict";
    e.ajaxChimp = {
        responses: {
            "We have sent you a confirmation email": 0,
            "Please enter a value": 1,
            "An email address must contain a single @": 2,
            "The domain portion of the email address is invalid (the portion after the @: )": 3,
            "The username portion of the email address is invalid (the portion before the @: )": 4,
            "This email address looks fake or invalid. Please enter a real email address": 5
        }, translations: {en: null}, init: function (t, n) {
            e(t).ajaxChimp(n)
        }
    }, e.fn.ajaxChimp = function (t) {
        return e(this).each(function (n, i) {
            var o = e(i), r = o.find("input[type=text]"), s = o.find("label[for=" + r.attr("id") + "]"),
                a = e.extend({url: o.attr("action"), language: "en"}, t),
                l = a.url.replace("/post?", "/post-json?").concat("&c=?");
            o.attr("novalidate", "true"), r.attr("name", "EMAIL"), o.submit(function () {
                var t;
                var n = {}, i = o.serializeArray();
                e.each(i, function (e, t) {
                    n[t.name] = t.value
                }), e.ajax({
                    url: l, data: n, success: function (n) {
                        if ("success" === n.result) t = "We have sent you a confirmation email", s.removeClass("error").addClass("valid"), r.removeClass("error").addClass("valid"); else {
                            r.removeClass("valid").addClass("error"), s.removeClass("valid").addClass("error");
                            try {
                                var i = n.msg.split(" - ", 2);
                                void 0 === i[1] ? t = n.msg : parseInt(i[0], 10).toString() === i[0] ? (i[0], t = i[1]) : t = n.msg
                            } catch (e) {
                                t = n.msg
                            }
                        }
                        "en" !== a.language && void 0 !== e.ajaxChimp.responses[t] && e.ajaxChimp.translations && e.ajaxChimp.translations[a.language] && e.ajaxChimp.translations[a.language][e.ajaxChimp.responses[t]] && (t = e.ajaxChimp.translations[a.language][e.ajaxChimp.responses[t]]), s.html(t), s.show(2e3), a.callback && a.callback(n)
                    }, dataType: "jsonp", error: function (e, t) {
                        console.log("mailchimp ajax submit error: " + t)
                    }
                });
                var c = "Submitting...";
                return "en" !== a.language && e.ajaxChimp.translations && e.ajaxChimp.translations[a.language] && e.ajaxChimp.translations[a.language].submit && (c = e.ajaxChimp.translations[a.language].submit), s.html(c).show(2e3), !1
            })
        }), this
    }
}(jQuery), function (e, t) {
    "function" == typeof define && define.amd ? define([], t) : "object" == typeof exports ? module.exports = t() : t()
}(0, function () {
    var e = "", t = 20, n = !0, i = [], o = !1, r = !0, s = !0, a = null, l = !0, c = !0, d = null, u = !0, p = !1,
        f = !1, h = !0, m = !0, v = !1, g = null;

    function y(e) {
        return e.replace(/<b[^>]*>(.*?)<\/b>/gi, function (e, t) {
            return t
        }).replace(/class="(?!(tco-hidden|tco-display|tco-ellipsis))+.*?"|data-query-source=".*?"|dir=".*?"|rel=".*?"/gi, "")
    }

    function b(e) {
        for (var t = e.getElementsByTagName("a"), n = t.length - 1; n >= 0; n--) t[n].setAttribute("target", "_blank")
    }

    function w(e, t) {
        for (var n = [], i = new RegExp("(^| )" + t + "( |$)"), o = e.getElementsByTagName("*"), r = 0, s = o.length; r < s; r++) i.test(o[r].className) && n.push(o[r]);
        return n
    }

    function x(e) {
        if (void 0 !== e && e.innerHTML.indexOf("data-image") >= 0) {
            var t = e.innerHTML.match(/data-image=\"([A-z0-9]+:\/\/[A-z0-9]+\.[A-z0-9]+\.[A-z0-9]+\/[A-z0-9]+\/[A-z0-9\-]+)/i)[1];
            return decodeURIComponent(t) + ".jpg"
        }
    }

    var k = {
        fetch: function (l) {
            if (void 0 === l.maxTweets && (l.maxTweets = 20), void 0 === l.enableLinks && (l.enableLinks = !0), void 0 === l.showUser && (l.showUser = !0), void 0 === l.showTime && (l.showTime = !0), void 0 === l.dateFunction && (l.dateFunction = "default"), void 0 === l.showRetweet && (l.showRetweet = !0), void 0 === l.customCallback && (l.customCallback = null), void 0 === l.showInteraction && (l.showInteraction = !0), void 0 === l.showImages && (l.showImages = !1), void 0 === l.useEmoji && (l.useEmoji = !1), void 0 === l.linksInNewWindow && (l.linksInNewWindow = !0), void 0 === l.showPermalinks && (l.showPermalinks = !0), void 0 === l.dataOnly && (l.dataOnly = !1), o) i.push(l); else {
                o = !0, e = l.domId, t = l.maxTweets, n = l.enableLinks, s = l.showUser, r = l.showTime, c = l.showRetweet, a = l.dateFunction, d = l.customCallback, u = l.showInteraction, p = l.showImages, f = l.useEmoji, h = l.linksInNewWindow, m = l.showPermalinks, v = l.dataOnly;
                var y = document.getElementsByTagName("head")[0];
                null !== g && y.removeChild(g), (g = document.createElement("script")).type = "text/javascript", void 0 !== l.list ? g.src = "https://syndication.twitter.com/timeline/list?callback=__twttrf.callback&dnt=false&list_slug=" + l.list.listSlug + "&screen_name=" + l.list.screenName + "&suppress_response_codes=true&lang=" + (l.lang || "en") + "&rnd=" + Math.random() : void 0 !== l.profile ? g.src = "https://syndication.twitter.com/timeline/profile?callback=__twttrf.callback&dnt=false&screen_name=" + l.profile.screenName + "&suppress_response_codes=true&lang=" + (l.lang || "en") + "&rnd=" + Math.random() : void 0 !== l.likes ? g.src = "https://syndication.twitter.com/timeline/likes?callback=__twttrf.callback&dnt=false&screen_name=" + l.likes.screenName + "&suppress_response_codes=true&lang=" + (l.lang || "en") + "&rnd=" + Math.random() : g.src = "https://cdn.syndication.twimg.com/widgets/timelines/" + l.id + "?&lang=" + (l.lang || "en") + "&callback=__twttrf.callback&suppress_response_codes=true&rnd=" + Math.random(), y.appendChild(g)
            }
        }, callback: function (g) {
            if (void 0 === g || void 0 === g.body) return o = !1, void (i.length > 0 && (k.fetch(i[0]), i.splice(0, 1)));
            f || (g.body = g.body.replace(/(<img[^c]*class="Emoji[^>]*>)|(<img[^c]*class="u-block[^>]*>)/g, "")), p || (g.body = g.body.replace(/(<img[^c]*class="NaturalImage-image[^>]*>|(<img[^c]*class="CroppedImage-image[^>]*>))/g, "")), s || (g.body = g.body.replace(/(<img[^c]*class="Avatar"[^>]*>)/g, ""));
            var C = document.createElement("div");

            function T(e) {
                return e
            }

            C.innerHTML = g.body, void 0 === C.getElementsByClassName && (l = !1);
            var S = [], $ = [], _ = [], E = [], A = [], O = [], j = [], M = 0;
            if (l) for (var I = C.getElementsByClassName("timeline-Tweet"); M < I.length;) I[M].getElementsByClassName("timeline-Tweet-retweetCredit").length > 0 ? A.push(!0) : A.push(!1), (!A[M] || A[M] && c) && (S.push(I[M].getElementsByClassName("timeline-Tweet-text")[0]), O.push(I[M].getAttribute("data-tweet-id")), s && $.push(T(I[M].getElementsByClassName("timeline-Tweet-author")[0])), _.push(I[M].getElementsByClassName("dt-updated")[0]), j.push(I[M].getElementsByClassName("timeline-Tweet-timestamp")[0]), void 0 !== I[M].getElementsByClassName("timeline-Tweet-media")[0] ? E.push(I[M].getElementsByClassName("timeline-Tweet-media")[0]) : E.push(void 0)), M++; else for (I = w(C, "timeline-Tweet"); M < I.length;) w(I[M], "timeline-Tweet-retweetCredit").length > 0 ? A.push(!0) : A.push(!1), (!A[M] || A[M] && c) && (S.push(w(I[M], "timeline-Tweet-text")[0]), O.push(I[M].getAttribute("data-tweet-id")), s && $.push(T(w(I[M], "timeline-Tweet-author")[0])), _.push(w(I[M], "dt-updated")[0]), j.push(w(I[M], "timeline-Tweet-timestamp")[0]), void 0 !== w(I[M], "timeline-Tweet-media")[0] ? E.push(w(I[M], "timeline-Tweet-media")[0]) : E.push(void 0)), M++;
            S.length > t && (S.splice(t, S.length - t), $.splice(t, $.length - t), _.splice(t, _.length - t), A.splice(t, A.length - t), E.splice(t, E.length - t), j.splice(t, j.length - t));
            var D = [], L = (M = S.length, 0);
            if (v) for (; L < M;) D.push({
                tweet: S[L].innerHTML,
                author: $[L] ? $[L].innerHTML : "Unknown Author",
                author_data: {
                    profile_url: $[L] ? $[L].querySelector('[data-scribe="element:user_link"]').href : null,
                    profile_image: $[L] ? $[L].querySelector('[data-scribe="element:avatar"]').getAttribute("data-src-1x") : null,
                    profile_image_2x: $[L] ? $[L].querySelector('[data-scribe="element:avatar"]').getAttribute("data-src-2x") : null,
                    screen_name: $[L] ? $[L].querySelector('[data-scribe="element:screen_name"]').title : null,
                    name: $[L] ? $[L].querySelector('[data-scribe="element:name"]').title : null
                },
                time: _[L].textContent,
                timestamp: _[L].getAttribute("datetime").replace("+0000", "Z").replace(/([\+\-])(\d\d)(\d\d)/, "$1$2:$3"),
                image: x(E[L]),
                rt: A[L],
                tid: O[L],
                permalinkURL: void 0 === j[L] ? "" : j[L].href
            }), L++; else for (; L < M;) {
                if ("string" != typeof a) {
                    var P = _[L].getAttribute("datetime"),
                        z = new Date(_[L].getAttribute("datetime").replace(/-/g, "/").replace("T", " ").split("+")[0]),
                        N = a(z, P);
                    if (_[L].setAttribute("aria-label", N), S[L].textContent) if (l) _[L].textContent = N; else {
                        var F = document.createElement("p"), H = document.createTextNode(N);
                        F.appendChild(H), F.setAttribute("aria-label", N), _[L] = F
                    } else _[L].textContent = N
                }
                var q = "";
                n ? (h && (b(S[L]), s && b($[L])), s && (q += '<div class="user">' + y($[L].innerHTML) + "</div>"), q += '<p class="tweet">' + y(S[L].innerHTML) + "</p>", r && (q += m ? '<p class="timePosted"><a href="' + j[L] + '">' + _[L].getAttribute("aria-label") + "</a></p>" : '<p class="timePosted">' + _[L].getAttribute("aria-label") + "</p>")) : (S[L].textContent, s && (q += '<p class="user">' + $[L].textContent + "</p>"), q += '<p class="tweet">' + S[L].textContent + "</p>", r && (q += '<p class="timePosted">' + _[L].textContent + "</p>")), u && (q += '<p class="interact"><a href="https://twitter.com/intent/tweet?in_reply_to=' + O[L] + '" class="twitter_reply_icon"' + (h ? ' target="_blank">' : ">") + 'Reply</a><a href="https://twitter.com/intent/retweet?tweet_id=' + O[L] + '" class="twitter_retweet_icon"' + (h ? ' target="_blank">' : ">") + 'Retweet</a><a href="https://twitter.com/intent/favorite?tweet_id=' + O[L] + '" class="twitter_fav_icon"' + (h ? ' target="_blank">' : ">") + "Favorite</a></p>"), p && void 0 !== E[L] && void 0 !== x(E[L]) && (q += '<div class="media"><img src="' + x(E[L]) + '" alt="Image from tweet" /></div>'), p ? D.push(q) : !p && S[L].textContent.length && D.push(q), L++
            }
            !function (t) {
                if (null === d) {
                    for (var n = t.length, i = 0, o = document.getElementById(e), r = "<ul>"; i < n;) r += "<li>" + t[i] + "</li>", i++;
                    r += "</ul>", o.innerHTML = r
                } else d(t)
            }(D), o = !1, i.length > 0 && (k.fetch(i[0]), i.splice(0, 1))
        }
    };
    return window.__twttrf = k, window.twitterFetcher = k, k
}), function (e) {
    e.fn.niceSelect = function (t) {
        if ("string" == typeof t) return "update" == t ? this.each(function () {
            var t = e(this), i = e(this).next(".nice-select"), o = i.hasClass("open");
            i.length && (i.remove(), n(t), o && t.next().trigger("click"))
        }) : "destroy" == t ? (this.each(function () {
            var t = e(this), n = e(this).next(".nice-select");
            n.length && (n.remove(), t.css("display", ""))
        }), 0 == e(".nice-select").length && e(document).off(".nice_select")) : console.log('Method "' + t + '" does not exist.'), this;

        function n(t) {
            t.after(e("<div></div>").addClass("nice-select").addClass(t.attr("class") || "").addClass(t.attr("disabled") ? "disabled" : "").addClass(t.attr("multiple") ? "has-multiple" : "").attr("tabindex", t.attr("disabled") ? null : "0").html(t.attr("multiple") ? '<span class="multiple-options"></span><div class="nice-select-search-box"><input type="text" class="nice-select-search" placeholder="Search..."/></div><ul class="list"></ul>' : '<span class="current"></span><div class="nice-select-search-box"><input type="text" class="nice-select-search" placeholder="Search..."/></div><ul class="list"></ul>'));
            var n = t.next(), i = t.find("option");
            if (t.attr("multiple")) {
                var o = t.find("option:selected"), r = "";
                o.each(function () {
                    $selected_option = e(this), $selected_text = $selected_option.data("display") || $selected_option.text(), r += '<span class="current">' + $selected_text + "</span>"
                }), $select_placeholder = t.data("placeholder") || t.attr("placeholder"), $select_placeholder = "" == $select_placeholder ? "Select" : $select_placeholder, r = "" == r ? $select_placeholder : r, n.find(".multiple-options").html(r)
            } else {
                o = t.find("option:selected");
                n.find(".current").html(o.data("display") || o.text())
            }
            i.each(function (t) {
                var i = e(this), o = i.data("display");
                n.find("ul").append(e("<li></li>").attr("data-value", i.val()).attr("data-display", o || null).addClass("option" + (i.is(":selected") ? " selected" : "") + (i.is(":disabled") ? " disabled" : "")).html(i.text()))
            })
        }

        this.hide(), this.each(function () {
            var t = e(this);
            t.next().hasClass("nice-select") || n(t)
        }), e(document).off(".nice_select"), e(document).on("click.nice_select", ".nice-select", function (t) {
            var n = e(this);
            e(".nice-select").not(n).removeClass("open"), n.toggleClass("open"), n.hasClass("open") ? (n.find(".option"), n.find(".nice-select-search").val(""), n.find(".nice-select-search").focus(), n.find(".focus").removeClass("focus"), n.find(".selected").addClass("focus"), n.find("ul li").show()) : n.focus()
        }), e(document).on("click", ".nice-select-search-box", function (e) {
            return e.stopPropagation(), !1
        }), e(document).on("click.nice_select", function (t) {
            0 === e(t.target).closest(".nice-select").length && e(".nice-select").removeClass("open").find(".option")
        }), e(document).on("click.nice_select", ".nice-select .option:not(.disabled)", function (t) {
            var n = e(this), i = n.closest(".nice-select");
            if (i.hasClass("has-multiple")) n.hasClass("selected") ? n.removeClass("selected") : n.addClass("selected"), $selected_html = "", $selected_values = [], i.find(".selected").each(function () {
                $selected_option = e(this);
                var t = $selected_option.data("display") || $selected_option.text();
                $selected_html += '<span class="current">' + t + "</span>", $selected_values.push($selected_option.data("value"))
            }), $select_placeholder = i.prev("select").data("placeholder") || i.prev("select").attr("placeholder"), $select_placeholder = "" == $select_placeholder ? "Select" : $select_placeholder, $selected_html = "" == $selected_html ? $select_placeholder : $selected_html, i.find(".multiple-options").html($selected_html), i.prev("select").val($selected_values).trigger("change"); else {
                i.find(".selected").removeClass("selected"), n.addClass("selected");
                var o = n.data("display") || n.text();
                i.find(".current").text(o), i.prev("select").val(n.data("value")).trigger("change")
            }
        }), e(document).on("keydown.nice_select", ".nice-select", function (t) {
            var n = e(this), i = e(n.find(".focus") || n.find(".list .option.selected"));
            if (32 == t.keyCode || 13 == t.keyCode) return n.hasClass("open") ? i.trigger("click") : n.trigger("click"), !1;
            if (40 == t.keyCode) {
                if (n.hasClass("open")) {
                    var o = i.nextAll(".option:not(.disabled)").first();
                    o.length > 0 && (n.find(".focus").removeClass("focus"), o.addClass("focus"))
                } else n.trigger("click");
                return !1
            }
            if (38 == t.keyCode) {
                if (n.hasClass("open")) {
                    var r = i.prevAll(".option:not(.disabled)").first();
                    r.length > 0 && (n.find(".focus").removeClass("focus"), r.addClass("focus"))
                } else n.trigger("click");
                return !1
            }
            if (27 == t.keyCode) n.hasClass("open") && n.trigger("click"); else if (9 == t.keyCode && n.hasClass("open")) return !1
        }), e(document).on("keydown.nice-select-search", ".nice-select", function () {
            var t = e(this), n = t.find(".nice-select-search").val(), i = t.find("ul li");
            if ("" == n) i.show(); else if (t.hasClass("open")) {
                n = n.toLowerCase();
                var o = new RegExp(n);
                0 < i.length ? i.each(function () {
                    var t = e(this), n = t.text().toLowerCase();
                    o.test(n) ? t.show() : t.hide()
                }) : i.show()
            }
        });
        var i = document.createElement("a").style;
        return i.cssText = "pointer-events:auto", "auto" !== i.pointerEvents && e("html").addClass("no-csspointerevents"), this
    }
}(jQuery), function (e) {
    "use strict";
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof exports ? module.exports = e(require("jquery")) : e(jQuery)
}(function (e) {
    "use strict";

    function t(e) {
        return e && (0 === e.offsetWidth || 0 === e.offsetHeight || !1 === e.open)
    }

    function n(e) {
        for (var n = [], i = e.parentNode; t(i);) n.push(i), i = i.parentNode;
        return n
    }

    function i(e, t) {
        function i(e) {
            void 0 !== e.open && (e.open = !e.open)
        }

        var o = n(e), r = o.length, s = [], a = e[t];
        if (r) {
            for (var l = 0; l < r; l++) s[l] = o[l].style.cssText, o[l].style.setProperty ? o[l].style.setProperty("display", "block", "important") : o[l].style.cssText += ";display: block !important", o[l].style.height = "0", o[l].style.overflow = "hidden", o[l].style.visibility = "hidden", i(o[l]);
            a = e[t];
            for (var c = 0; c < r; c++) o[c].style.cssText = s[c], i(o[c])
        }
        return a
    }

    function o(e, t) {
        var n = parseFloat(e);
        return Number.isNaN(n) ? t : n
    }

    function r(e) {
        return e.charAt(0).toUpperCase() + e.substr(1)
    }

    function s(t, n) {
        if (this.$window = e(window), this.$document = e(document), this.$element = e(t), this.options = e.extend({}, d, n), this.polyfill = this.options.polyfill, this.orientation = this.$element[0].getAttribute("data-orientation") || this.options.orientation, this.onInit = this.options.onInit, this.onSlide = this.options.onSlide, this.onSlideEnd = this.options.onSlideEnd, this.DIMENSION = u.orientation[this.orientation].dimension, this.DIRECTION = u.orientation[this.orientation].direction, this.DIRECTION_STYLE = u.orientation[this.orientation].directionStyle, this.COORDINATE = u.orientation[this.orientation].coordinate, this.polyfill && c) return !1;
        this.identifier = "js-" + a + "-" + l++, this.startEvent = this.options.startEvent.join("." + this.identifier + " ") + "." + this.identifier, this.moveEvent = this.options.moveEvent.join("." + this.identifier + " ") + "." + this.identifier, this.endEvent = this.options.endEvent.join("." + this.identifier + " ") + "." + this.identifier, this.toFixed = (this.step + "").replace(".", "").length - 1, this.$fill = e('<div class="' + this.options.fillClass + '" />'), this.$handle = e('<div class="' + this.options.handleClass + '" />'), this.$range = e('<div class="' + this.options.rangeClass + " " + this.options[this.orientation + "Class"] + '" id="' + this.identifier + '" />').insertAfter(this.$element).prepend(this.$fill, this.$handle), this.$element.css({
            position: "absolute",
            width: "1px",
            height: "1px",
            overflow: "hidden",
            opacity: "0"
        }), this.handleDown = e.proxy(this.handleDown, this), this.handleMove = e.proxy(this.handleMove, this), this.handleEnd = e.proxy(this.handleEnd, this), this.init();
        var i = this;
        this.$window.on("resize." + this.identifier, function (e, t) {
            return t = t || 100, function () {
                if (!e.debouncing) {
                    var n = Array.prototype.slice.apply(arguments);
                    e.lastReturnVal = e.apply(window, n), e.debouncing = !0
                }
                return clearTimeout(e.debounceTimeout), e.debounceTimeout = setTimeout(function () {
                    e.debouncing = !1
                }, t), e.lastReturnVal
            }
        }(function () {
            !function (e, t) {
                var n = Array.prototype.slice.call(arguments, 2);
                setTimeout(function () {
                    return e.apply(null, n)
                }, t)
            }(function () {
                i.update(!1, !1)
            }, 300)
        }, 20)), this.$document.on(this.startEvent, "#" + this.identifier + ":not(." + this.options.disabledClass + ")", this.handleDown), this.$element.on("change." + this.identifier, function (e, t) {
            if (!t || t.origin !== i.identifier) {
                var n = e.target.value, o = i.getPositionFromValue(n);
                i.setPosition(o)
            }
        })
    }

    Number.isNaN = Number.isNaN || function (e) {
        return "number" == typeof e && e != e
    };
    var a = "rangeslider", l = 0, c = function () {
        var e = document.createElement("input");
        return e.setAttribute("type", "range"), "text" !== e.type
    }(), d = {
        polyfill: !0,
        orientation: "horizontal",
        rangeClass: "rangeslider",
        disabledClass: "rangeslider--disabled",
        activeClass: "rangeslider--active",
        horizontalClass: "rangeslider--horizontal",
        verticalClass: "rangeslider--vertical",
        fillClass: "rangeslider__fill",
        handleClass: "rangeslider__handle",
        startEvent: ["mousedown", "touchstart", "pointerdown"],
        moveEvent: ["mousemove", "touchmove", "pointermove"],
        endEvent: ["mouseup", "touchend", "pointerup"]
    }, u = {
        orientation: {
            horizontal: {dimension: "width", direction: "left", directionStyle: "left", coordinate: "x"},
            vertical: {dimension: "height", direction: "top", directionStyle: "bottom", coordinate: "y"}
        }
    };
    return s.prototype.init = function () {
        this.update(!0, !1), this.onInit && "function" == typeof this.onInit && this.onInit()
    }, s.prototype.update = function (e, t) {
        (e = e || !1) && (this.min = o(this.$element[0].getAttribute("min"), 0), this.max = o(this.$element[0].getAttribute("max"), 100), this.value = o(this.$element[0].value, Math.round(this.min + (this.max - this.min) / 2)), this.step = o(this.$element[0].getAttribute("step"), 1)), this.handleDimension = i(this.$handle[0], "offset" + r(this.DIMENSION)), this.rangeDimension = i(this.$range[0], "offset" + r(this.DIMENSION)), this.maxHandlePos = this.rangeDimension - this.handleDimension, this.grabPos = this.handleDimension / 2, this.position = this.getPositionFromValue(this.value), this.$element[0].disabled ? this.$range.addClass(this.options.disabledClass) : this.$range.removeClass(this.options.disabledClass), this.setPosition(this.position, t)
    }, s.prototype.handleDown = function (e) {
        if (e.preventDefault(), this.$document.on(this.moveEvent, this.handleMove), this.$document.on(this.endEvent, this.handleEnd), this.$range.addClass(this.options.activeClass), !((" " + e.target.className + " ").replace(/[\n\t]/g, " ").indexOf(this.options.handleClass) > -1)) {
            var t = this.getRelativePosition(e), n = this.$range[0].getBoundingClientRect()[this.DIRECTION],
                i = this.getPositionFromNode(this.$handle[0]) - n,
                o = "vertical" === this.orientation ? this.maxHandlePos - (t - this.grabPos) : t - this.grabPos;
            this.setPosition(o), t >= i && t < i + this.handleDimension && (this.grabPos = t - i)
        }
    }, s.prototype.handleMove = function (e) {
        e.preventDefault();
        var t = this.getRelativePosition(e),
            n = "vertical" === this.orientation ? this.maxHandlePos - (t - this.grabPos) : t - this.grabPos;
        this.setPosition(n)
    }, s.prototype.handleEnd = function (e) {
        e.preventDefault(), this.$document.off(this.moveEvent, this.handleMove), this.$document.off(this.endEvent, this.handleEnd), this.$range.removeClass(this.options.activeClass), this.$element.trigger("change", {origin: this.identifier}), this.onSlideEnd && "function" == typeof this.onSlideEnd && this.onSlideEnd(this.position, this.value)
    }, s.prototype.cap = function (e, t, n) {
        return e < t ? t : e > n ? n : e
    }, s.prototype.setPosition = function (e, t) {
        var n, i;
        void 0 === t && (t = !0), n = this.getValueFromPosition(this.cap(e, 0, this.maxHandlePos)), i = this.getPositionFromValue(n), this.$fill[0].style[this.DIMENSION] = i + this.grabPos + "px", this.$handle[0].style[this.DIRECTION_STYLE] = i + "px", this.setValue(n), this.position = i, this.value = n, t && this.onSlide && "function" == typeof this.onSlide && this.onSlide(i, n)
    }, s.prototype.getPositionFromNode = function (e) {
        for (var t = 0; null !== e;) t += e.offsetLeft, e = e.offsetParent;
        return t
    }, s.prototype.getRelativePosition = function (e) {
        var t = r(this.COORDINATE), n = this.$range[0].getBoundingClientRect()[this.DIRECTION], i = 0;
        return void 0 !== e.originalEvent["client" + t] ? i = e.originalEvent["client" + t] : e.originalEvent.touches && e.originalEvent.touches[0] && void 0 !== e.originalEvent.touches[0]["client" + t] ? i = e.originalEvent.touches[0]["client" + t] : e.currentPoint && void 0 !== e.currentPoint[this.COORDINATE] && (i = e.currentPoint[this.COORDINATE]), i - n
    }, s.prototype.getPositionFromValue = function (e) {
        var t;
        return t = (e - this.min) / (this.max - this.min), Number.isNaN(t) ? 0 : t * this.maxHandlePos
    }, s.prototype.getValueFromPosition = function (e) {
        var t, n;
        return t = e / (this.maxHandlePos || 1), n = this.step * Math.round(t * (this.max - this.min) / this.step) + this.min, Number(n.toFixed(this.toFixed))
    }, s.prototype.setValue = function (e) {
        e === this.value && "" !== this.$element[0].value || this.$element.val(e).trigger("input", {origin: this.identifier})
    }, s.prototype.destroy = function () {
        this.$document.off("." + this.identifier), this.$window.off("." + this.identifier), this.$element.off("." + this.identifier).removeAttr("style").removeData("plugin_" + a), this.$range && this.$range.length && this.$range[0].parentNode.removeChild(this.$range[0])
    }, e.fn[a] = function (t) {
        var n = Array.prototype.slice.call(arguments, 1);
        return this.each(function () {
            var i = e(this), o = i.data("plugin_" + a);
            o || i.data("plugin_" + a, o = new s(this, t)), "string" == typeof t && o[t].apply(o, n)
        })
    }, "rangeslider.js is available in jQuery context e.g $(selector).rangeslider(options);"
}), function (e) {
    var t = "transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd",
        n = "webkitAnimationEnd mozAnimationEnd oAnimationEnd oanimationend animationend", r = {
            en: {
                name: "English",
                gregorian: !1,
                months: {
                    short: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
                    full: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
                },
                weekdays: {
                    short: ["S", "M", "T", "W", "T", "F", "S"],
                    full: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
                }
            },
            it: {
                name: "Italiano",
                gregorian: !0,
                months: {
                    short: ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"],
                    full: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"]
                },
                weekdays: {
                    short: ["D", "L", "M", "M", "G", "V", "S"],
                    full: ["Domenica", "Luned", "Marted", "Mercoled", "Gioved", "Venerd", "Sabato"]
                }
            },
            fr: {
                name: "Franais",
                gregorian: !0,
                months: {
                    short: ["Jan", "Fv", "Mar", "Avr", "Mai", "Jui", "Jui", "Ao", "Sep", "Oct", "Nov", "Dc"],
                    full: ["Janvier", "Fvrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aot", "Septembre", "Octobre", "Novembre", "Dcembre"]
                },
                weekdays: {
                    short: ["D", "L", "M", "M", "J", "V", "S"],
                    full: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"]
                }
            },
            zh: {
                name: "",
                gregorian: !0,
                months: {
                    short: ["", "", "", "", "", "", "", "", "", "", "", ""],
                    full: ["", "", "", "", "", "", "", "", "", "", "", ""]
                },
                weekdays: {short: ["", "", "", "", "", "", ""], full: ["", "", "", "", "", "", ""]}
            },
            ar: {
                name: "",
                gregorian: !1,
                months: {
                    short: ["", "", "", "", "", "", "", "", "", "", "", ""],
                    full: ["", "", "", "", "", "", "", "", "", "", "", ""]
                },
                weekdays: {short: ["S", "M", "T", "W", "T", "F", "S"], full: ["", "", "", "", "", "", ""]}
            },
            fa: {
                name: "",
                gregorian: !1,
                months: {
                    short: ["", "", "", "", "", "", "", "", "", "", "", ""],
                    full: ["", "", "", "", "", "", "", "", "", "", "", ""]
                },
                weekdays: {short: ["S", "M", "T", "W", "T", "F", "S"], full: ["", "", " ", "", " ", "", ""]}
            },
            hu: {
                name: "Hungarian",
                gregorian: !0,
                months: {
                    short: ["jan", "feb", "mr", "pr", "mj", "jn", "jl", "aug", "sze", "okt", "nov", "dec"],
                    full: ["janur", "februr", "mrcius", "prilis", "mjus", "jnius", "jlius", "augusztus", "szeptember", "oktber", "november", "december"]
                },
                weekdays: {
                    short: ["v", "h", "k", "s", "c", "p", "s"],
                    full: ["vasrnap", "htf", "kedd", "szerda", "cstrtk", "pntek", "szombat"]
                }
            },
            gr: {
                name: "",
                gregorian: !0,
                months: {
                    short: ["", "", "", "", "", "", "", "", "", "", "", ""],
                    full: ["", "", "", "", "", "", "", "", "", "", "", ""]
                },
                weekdays: {short: ["", "", "", "", "", "", ""], full: ["", "", "", "", "", "", ""]}
            },
            es: {
                name: "Espaol",
                gregorian: !0,
                months: {
                    short: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                    full: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
                },
                weekdays: {
                    short: ["D", "L", "M", "X", "J", "V", "S"],
                    full: ["Domingo", "Lunes", "Martes", "Mircoles", "Jueves", "Viernes", "Sbado"]
                }
            },
            da: {
                name: "Dansk",
                gregorian: !0,
                months: {
                    short: ["jan", "feb", "mar", "apr", "maj", "jun", "jul", "aug", "sep", "okt", "nov", "dec"],
                    full: ["januar", "februar", "marts", "april", "maj", "juni", "juli", "august", "september", "oktober", "november", "december"]
                },
                weekdays: {
                    short: ["s", "m", "t", "o", "t", "f", "l"],
                    full: ["sndag", "mandag", "tirsdag", "onsdag", "torsdag", "fredag", "lrdag"]
                }
            },
            de: {
                name: "Deutsch",
                gregorian: !0,
                months: {
                    short: ["Jan", "Feb", "Mr", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"],
                    full: ["Januar", "Februar", "Mrz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"]
                },
                weekdays: {
                    short: ["S", "M", "D", "M", "D", "F", "S"],
                    full: ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"]
                }
            },
            nl: {
                name: "Nederlands",
                gregorian: !0,
                months: {
                    short: ["jan", "feb", "maa", "apr", "mei", "jun", "jul", "aug", "sep", "okt", "nov", "dec"],
                    full: ["januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december"]
                },
                weekdays: {
                    short: ["z", "m", "d", "w", "d", "v", "z"],
                    full: ["zondag", "maandag", "dinsdag", "woensdag", "donderdag", "vrijdag", "zaterdag"]
                }
            },
            pl: {
                name: "jzyk polski",
                gregorian: !0,
                months: {
                    short: ["sty", "lut", "mar", "kwi", "maj", "cze", "lip", "sie", "wrz", "pa", "lis", "gru"],
                    full: ["stycze", "luty", "marzec", "kwiecie", "maj", "czerwiec", "lipiec", "sierpie", "wrzesie", "padziernik", "listopad", "grudzie"]
                },
                weekdays: {
                    short: ["n", "p", "w", "", "c", "p", "s"],
                    full: ["niedziela", "poniedziaek", "wtorek", "roda", "czwartek", "pitek", "sobota"]
                }
            },
            pt: {
                name: "Portugus",
                gregorian: !0,
                months: {
                    short: ["Janeiro", "Fevereiro", "Maro", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
                    full: ["Janeiro", "Fevereiro", "Maro", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"]
                },
                weekdays: {
                    short: ["D", "S", "T", "Q", "Q", "S", "S"],
                    full: ["Domingo", "Segunda", "Tera", "Quarta", "Quinta", "Sexta", "Sbado"]
                }
            },
            si: {
                name: "Slovenina",
                gregorian: !0,
                months: {
                    short: ["jan", "feb", "mar", "apr", "maj", "jun", "jul", "avg", "sep", "okt", "nov", "dec"],
                    full: ["januar", "februar", "marec", "april", "maj", "junij", "julij", "avgust", "september", "oktober", "november", "december"]
                },
                weekdays: {
                    short: ["n", "p", "t", "s", "", "p", "s"],
                    full: ["nedelja", "ponedeljek", "torek", "sreda", "etrtek", "petek", "sobota"]
                }
            },
            uk: {
                name: " ",
                gregorian: !0,
                months: {
                    short: ["", "", "", "", "", "", "", "", "", "", "", ""],
                    full: ["", "", "", "", "", "", "", "", "", "", "", ""]
                },
                weekdays: {short: ["", "", "", "", "", "", ""], full: ["", "", "", "", "", "'", ""]}
            },
            ru: {
                name: " ",
                gregorian: !0,
                months: {
                    short: ["", "", "", "", "", "", "", "", "", "", "", ""],
                    full: ["", "", "", "", "", "", "", "", "", "", "", ""]
                },
                weekdays: {short: ["", "", "", "", "", "", ""], full: ["", "", "", "", "", "", ""]}
            },
            tr: {
                name: "Trke",
                gregorian: !0,
                months: {
                    short: ["Oca", "ub", "Mar", "Nis", "May", "Haz", "Tem", "Au", "Eyl", "Eki", "Kas", "Ara"],
                    full: ["Ocak", "ubat", "Mart", "Nisan", "Mays", "Haziran", "Temmuz", "Austos", "Eyll", "Ekim", "Kasm", "Aralk"]
                },
                weekdays: {
                    short: ["P", "P", "S", "", "P", "C", "C"],
                    full: ["Pazar", "Pazartesi", "Sali", "aramba", "Perembe", "Cuma", "Cumartesi"]
                }
            },
            ko: {
                name: "",
                gregorian: !0,
                months: {
                    short: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
                    full: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"]
                },
                weekdays: {short: ["", "", "", "", "", "", ""], full: ["", "", "", "", "", "", ""]}
            },
            fi: {
                name: "suomen kieli",
                gregorian: !0,
                months: {
                    short: ["Tam", "Hel", "Maa", "Huh", "Tou", "Kes", "Hei", "Elo", "Syy", "Lok", "Mar", "Jou"],
                    full: ["Tammikuu", "Helmikuu", "Maaliskuu", "Huhtikuu", "Toukokuu", "Keskuu", "Heinkuu", "Elokuu", "Syyskuu", "Lokakuu", "Marraskuu", "Joulukuu"]
                },
                weekdays: {
                    short: ["S", "M", "T", "K", "T", "P", "L"],
                    full: ["Sunnuntai", "Maanantai", "Tiistai", "Keskiviikko", "Torstai", "Perjantai", "Lauantai"]
                }
            },
            vi: {
                name: "Ting vit",
                gregorian: !1,
                months: {
                    short: ["Th.01", "Th.02", "Th.03", "Th.04", "Th.05", "Th.06", "Th.07", "Th.08", "Th.09", "Th.10", "Th.11", "Th.12"],
                    full: ["Thng 01", "Thng 02", "Thng 03", "Thng 04", "Thng 05", "Thng 06", "Thng 07", "Thng 08", "Thng 09", "Thng 10", "Thng 11", "Thng 12"]
                },
                weekdays: {
                    short: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                    full: ["Ch nht", "Th hai", "Th ba", "Th t", "Th nm", "Th su", "Th by"]
                }
            }
        }, s = {}, a = null, l = !1, c = null, d = null, u = null, p = !1, f = function () {
            return !!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
        }, h = function () {
            a && s[a.id].fx && !s[a.id].fxmobile && (e(window).width() < 480 ? a.element.removeClass("picker-fxs") : a.element.addClass("picker-fxs"))
        }, m = function () {
            var e = E(x()), t = E(w());
            if (s[a.id].lock) {
                if ("from" == s[a.id].lock) return t > e ? (H(), a.element.addClass("picker-lkd"), !0) : (a.element.removeClass("picker-lkd"), !1);
                if ("to" == s[a.id].lock) return e > t ? (H(), a.element.addClass("picker-lkd"), !0) : (a.element.removeClass("picker-lkd"), !1)
            }
            return s[a.id].disabledays ? -1 != s[a.id].disabledays.indexOf(e) ? (H(), a.element.addClass("picker-lkd"), !0) : (a.element.removeClass("picker-lkd"), !1) : void 0
        }, v = function (e) {
            return e % 1 == 0
        }, g = function (e) {
            return /(^\d{1,4}[\.|\\/|-]\d{1,2}[\.|\\/|-]\d{1,4})(\s*(?:0?[1-9]:[0-5]|1(?=[012])\d:[0-5])\d\s*[ap]m)?$/.test(e)
        }, y = function (e) {
            return parseInt(s[a.id].key[e].current)
        }, b = function (e) {
            return parseInt(s[a.id].key[e].today)
        }, w = function () {
            return b("m") + "/" + b("d") + "/" + b("y")
        }, x = function () {
            return y("m") + "/" + y("d") + "/" + y("y")
        }, k = function (e, t) {
            for (var n = [], i = s[a.id].key[e], o = i.min; o <= i.max; o++) o % t == 0 && n.push(o);
            return n
        }, C = function (e, t) {
            var n = s[a.id].key[e];
            return t > n.max ? C(e, t - n.max + (n.min - 1)) : t < n.min ? C(e, t + 1 + (n.max - n.min)) : t
        }, T = function () {
            return r[s[a.id].lang].gregorian ? [1, 2, 3, 4, 5, 6, 0] : [0, 1, 2, 3, 4, 5, 6]
        }, S = function (e) {
            return _('ul.pick[data-k="' + e + '"]')
        }, $ = function (t, n) {
            ul = S(t);
            var i = [];
            return ul.find("li").each(function () {
                i.push(e(this).attr("value"))
            }), "last" == n ? i[i.length - 1] : i[0]
        }, _ = function (e) {
            return a ? a.element.find(e) : void 0
        }, E = function (e) {
            return Date.parse(e) / 1e3
        }, A = function () {
            s[a.id].large && (a.element.toggleClass("picker-lg"), L())
        }, O = function () {
            _("ul.pick.pick-l").toggleClass("visible")
        }, j = function () {
            if (!a.element.hasClass("picker-modal")) {
                var e = a.input, t = e.offset().left + e.outerWidth() / 2, n = e.offset().top + e.outerHeight();
                a.element.css({left: t, top: n})
            }
        }, M = function () {
            var t = T();
            _(".pick-lg .pick-lg-h li").each(function (n) {
                e(this).html(r[s[a.id].lang].weekdays.short[t[n]])
            }), _("ul.pick.pick-m li").each(function () {
                e(this).html(r[s[a.id].lang].months.short[e(this).attr("value") - 1])
            })
        }, I = function () {
            m() || (a.element.removeClass("picker-focus"), a.element.hasClass("picker-modal") && e(".picker-modal-overlay").addClass("tohide"), a = null), l = !1
        }, D = function (t) {
            var n = S(t), o = s[a.id].key[t];
            for (s[a.id].key[t].current = o.today < o.min && o.min || o.today, i = o.min; i <= o.max; i++) {
                var l = i;
                "m" == t && (l = r[s[a.id].lang].months.short[i - 1]), "l" == t && (l = r[Object.keys(r)[i]].name), l += "d" == t ? "<span></span>" : "", e("<li>", {
                    value: i,
                    html: l
                }).appendTo(n)
            }
            e("<div>", {
                class: "pick-arw pick-arw-s1 pick-arw-l",
                html: e("<i>", {class: "pick-i-l"})
            }).appendTo(n), e("<div>", {
                class: "pick-arw pick-arw-s1 pick-arw-r",
                html: e("<i>", {class: "pick-i-r"})
            }).appendTo(n), "y" == t && (e("<div>", {
                class: "pick-arw pick-arw-s2 pick-arw-l",
                html: e("<i>", {class: "pick-i-l"})
            }).appendTo(n), e("<div>", {
                class: "pick-arw pick-arw-s2 pick-arw-r",
                html: e("<i>", {class: "pick-i-r"})
            }).appendTo(n)), z(t, y(t))
        }, L = function () {
            var t = 0, n = _(".pick-lg-b");
            n.find("li").empty().removeClass("pick-n pick-b pick-a pick-v pick-lk pick-sl pick-h").attr("data-value", "");
            var i = (new Date(x()), new Date(x())), o = new Date(x()), l = function (e) {
                var t = e.getMonth(), n = e.getFullYear();
                return [31, n % 4 == 0 && (n % 100 != 0 || n % 400 == 0) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][t]
            };
            o.setMonth(o.getMonth() - 1), i.setDate(1);
            var c = i.getDay() - 1;
            0 > c && (c = 6), r[s[a.id].lang].gregorian && (0 > --c && (c = 6));
            for (var d = l(o) - c; d <= l(o); d++) n.find("li").eq(t).html(d).addClass("pick-b pick-n pick-h"), t++;
            for (d = 1; d <= l(i); d++) n.find("li").eq(t).html(d).addClass("pick-n pick-v").attr("data-value", d), t++;
            if (n.find("li.pick-n").length < 42) {
                var u = 42 - n.find("li.pick-n").length;
                for (d = 1; u >= d; d++) n.find("li").eq(t).html(d).addClass("pick-a pick-n pick-h"), t++
            }
            s[a.id].lock && ("from" === s[a.id].lock ? y("y") <= b("y") && (y("m") == b("m") ? _('.pick-lg .pick-lg-b li.pick-v[data-value="' + b("d") + '"]').prevAll("li").addClass("pick-lk") : y("m") < b("m") ? _(".pick-lg .pick-lg-b li").addClass("pick-lk") : y("m") > b("m") && y("y") < b("y") && _(".pick-lg .pick-lg-b li").addClass("pick-lk")) : y("y") >= b("y") && (y("m") == b("m") ? _('.pick-lg .pick-lg-b li.pick-v[data-value="' + b("d") + '"]').nextAll("li").addClass("pick-lk") : y("m") > b("m") ? _(".pick-lg .pick-lg-b li").addClass("pick-lk") : y("m") < b("m") && y("y") > b("y") && _(".pick-lg .pick-lg-b li").addClass("pick-lk"))), s[a.id].disabledays && e.each(s[a.id].disabledays, function (e, t) {
                if (t && g(t)) {
                    var n = new Date(1e3 * t);
                    n.getMonth() + 1 == y("m") && n.getFullYear() == y("y") && _('.pick-lg .pick-lg-b li.pick-v[data-value="' + n.getDate() + '"]').addClass("pick-lk")
                }
            }), _(".pick-lg-b li.pick-v[data-value=" + y("d") + "]").addClass("pick-sl")
        }, P = function () {
            var t, n, i;
            a.element.hasClass("picker-lg") && L(), t = y("m"), n = y("y"), i = n % 4 == 0 && (n % 100 != 0 || n % 400 == 0), s[a.id].key.d.max = [31, i ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][t - 1], y("d") > s[a.id].key.d.max && (s[a.id].key.d.current = s[a.id].key.d.max, z("d", y("d"))), _(".pick-d li").removeClass("pick-wke").each(function () {
                var i = new Date(t + "/" + e(this).attr("value") + "/" + n).getDay();
                e(this).find("span").html(r[s[a.id].lang].weekdays.full[i]), (0 == i || 6 == i) && e(this).addClass("pick-wke")
            }), a.element.hasClass("picker-lg") && (_(".pick-lg-b li").removeClass("pick-wke"), _(".pick-lg-b li.pick-v").each(function () {
                var i = new Date(t + "/" + e(this).attr("data-value") + "/" + n).getDay();
                (0 == i || 6 == i) && e(this).addClass("pick-wke")
            })), R()
        }, z = function (e, t) {
            var n, i = S(e);
            (i.find("li").removeClass("pick-sl pick-bfr pick-afr"), t == $(e, "last")) && ((n = i.find('li[value="' + $(e, "first") + '"]')).clone().insertAfter(i.find("li[value=" + t + "]")), n.remove());
            t == $(e, "first") && ((n = i.find('li[value="' + $(e, "last") + '"]')).clone().insertBefore(i.find("li[value=" + t + "]")), n.remove());
            i.find("li[value=" + t + "]").addClass("pick-sl"), i.find("li.pick-sl").nextAll("li").addClass("pick-afr"), i.find("li.pick-sl").prevAll("li").addClass("pick-bfr")
        }, N = function (e, t) {
            var n = s[a.id].key[e];
            t > n.max && ("d" == e && F("m", "right"), "m" == e && F("y", "right"), t = n.min), t < n.min && ("d" == e && F("m", "left"), "m" == e && F("y", "left"), t = n.max), s[a.id].key[e].current = t, z(e, t)
        }, F = function (e, t) {
            var n = y(e);
            "right" == t ? n++ : n--, N(e, n)
        }, H = function () {
            a.element.addClass("picker-rmbl")
        }, q = function (e) {
            return 10 > e ? "0" + e : e
        }, R = function () {
            if (!m() && l) {
                var e = y("d"), t = y("m"), n = y("y"), i = new Date(t + "/" + e + "/" + n).getDay(),
                    o = s[a.id].format.replace(/\b(d)\b/g, q(e)).replace(/\b(m)\b/g, q(t)).replace(/\b(S)\b/g, function (e) {
                        var t = ["th", "st", "nd", "rd"], n = e % 100;
                        return e + (t[(n - 20) % 10] || t[n] || t[0])
                    }(e)).replace(/\b(Y)\b/g, n).replace(/\b(U)\b/g, E(x())).replace(/\b(D)\b/g, r[s[a.id].lang].weekdays.short[i]).replace(/\b(l)\b/g, r[s[a.id].lang].weekdays.full[i]).replace(/\b(F)\b/g, r[s[a.id].lang].months.full[t - 1]).replace(/\b(M)\b/g, r[s[a.id].lang].months.short[t - 1]).replace(/\b(n)\b/g, t).replace(/\b(j)\b/g, e);
                a.input.val(o).change(), l = !1
            }
        };
    if (f()) var W = {i: "touchstart", m: "touchmove", e: "touchend"}; else W = {
        i: "mousedown",
        m: "mousemove",
        e: "mouseup"
    };
    var B = "div.datedropper.picker-focus";
    e(document).on("click", function (e) {
        a && (a.input.is(e.target) || a.element.is(e.target) || 0 !== a.element.has(e.target).length || (I(), c = null))
    }).on(n, B + ".picker-rmbl", function () {
        a.element.hasClass("picker-rmbl") && e(this).removeClass("picker-rmbl")
    }).on(t, ".picker-modal-overlay", function () {
        e(this).remove()
    }).on(W.i, B + " .pick-lg li.pick-v", function () {
        _(".pick-lg-b li").removeClass("pick-sl"), e(this).addClass("pick-sl"), s[a.id].key.d.current = e(this).attr("data-value"), z("d", e(this).attr("data-value")), l = !0
    }).on("click", B + " .pick-btn-sz", function () {
        A()
    }).on("click", B + " .pick-btn-lng", function () {
        O()
    }).on(W.i, B + " .pick-arw.pick-arw-s2", function (t) {
        t.preventDefault(), c = null;
        var n, i = (e(this).closest("ul").data("k"), s[a.id].jump);
        n = e(this).hasClass("pick-arw-r") ? y("y") + i : y("y") - i;
        var o = k("y", i);
        n > o[o.length - 1] && (n = o[0]), n < o[0] && (n = o[o.length - 1]), s[a.id].key.y.current = n, z("y", y("y")), l = !0
    }).on(W.i, B + " .pick-arw.pick-arw-s1", function (t) {
        t.preventDefault(), c = null;
        var n = e(this).closest("ul").data("k");
        e(this).hasClass("pick-arw-r") ? F(n, "right") : F(n, "left"), l = !0
    }).on(W.i, B + " ul.pick.pick-y li", function () {
        p = !0
    }).on(W.e, B + " ul.pick.pick-y li", function () {
        if (p && !(s[a.id].jump >= s[a.id].key.y.max - s[a.id].key.y.min)) {
            e(this).closest("ul").toggleClass("pick-jump");
            var t = function (e, t) {
                for (var n = t[0], i = Math.abs(e - n), o = 0; o < t.length; o++) {
                    var r = Math.abs(e - t[o]);
                    i > r && (i = r, n = t[o])
                }
                return n
            }(y("y"), k("y", s[a.id].jump));
            s[a.id].key.y.current = t, z("y", y("y")), p = !1
        }
    }).on(W.i, B + " ul.pick.pick-d li", function () {
        p = !0
    }).on(W.e, B + " ul.pick.pick-d li", function () {
        p && (A(), p = !1)
    }).on(W.i, B + " ul.pick.pick-l li", function () {
        p = !0
    }).on(W.e, B + " ul.pick.pick-l li", function () {
        p && (O(), function (e) {
            s[a.id].lang = Object.keys(r)[e], M(), P()
        }(e(this).val()), p = !1)
    }).on(W.i, B + " ul.pick", function (t) {
        if (c = e(this)) {
            var n = c.data("k");
            d = f() ? t.originalEvent.touches[0].pageY : t.pageY, u = y(n)
        }
    }).on(W.m, function (e) {
        if (p = !1, c) {
            e.preventDefault();
            var t = c.data("k");
            o = f() ? e.originalEvent.touches[0].pageY : e.pageY, o = d - o, o = Math.round(.026 * o), i = u + o;
            var n = C(t, i);
            n != s[a.id].key[t].current && N(t, n), l = !0
        }
    }).on(W.e, function () {
        c && (c = null, d = null, u = null), a && P()
    }).on(W.i, B + " .pick-submit", function () {
        I()
    }), e(window).resize(function () {
        a && (j(), h())
    }), e.fn.dateDropper = function () {
        return e(this).each(function () {
            if (e(this).is("input") && !e(this).hasClass("picker-input")) {
                var t = e(this), n = "datedropper-" + Object.keys(s).length;
                t.attr("data-id", n).addClass("picker-input").prop({type: "text", readonly: !0});
                var i = t.data("default-date") && g(t.data("default-date")) ? t.data("default-date") : null,
                    o = t.data("disabled-days") ? t.data("disabled-days").split(",") : null,
                    c = t.data("format") || "m/d/Y", d = !1 !== t.data("fx") || t.data("fx"),
                    u = !1 === t.data("fx") ? "" : "picker-fxs", p = !1 !== t.data("fx-mobile") || t.data("fx-mobile"),
                    f = !1 !== t.data("init-set"), h = t.data("lang") && t.data("lang") in r ? t.data("lang") : "en",
                    m = !0 === t.data("large-mode"), y = !0 === t.data("large-default") && !0 === m ? "picker-lg" : "",
                    b = ("from" == t.data("lock") || "to" == t.data("lock")) && t.data("lock"),
                    w = t.data("jump") && v(t.data("jump")) ? t.data("jump") : 10,
                    x = t.data("max-year") && v(t.data("max-year")) ? t.data("max-year") : (new Date).getFullYear(),
                    k = t.data("min-year") && v(t.data("min-year")) ? t.data("min-year") : 1970,
                    C = !0 === t.data("modal") ? "picker-modal" : "", S = t.data("theme") || "primary",
                    $ = !0 === t.data("translate-mode");
                if (o && e.each(o, function (e, t) {
                    t && g(t) && (o[e] = E(t))
                }), s[n] = {
                    disabledays: o,
                    format: c,
                    fx: d,
                    fxmobile: p,
                    lang: h,
                    large: m,
                    lock: b,
                    jump: w,
                    key: {
                        m: {min: 1, max: 12, current: 1, today: (new Date).getMonth() + 1},
                        d: {min: 1, max: 31, current: 1, today: (new Date).getDate()},
                        y: {min: k, max: x, current: k, today: (new Date).getFullYear()},
                        l: {min: 0, max: Object.keys(r).length - 1, current: 0, today: 0}
                    },
                    translate: $
                }, i) {
                    var A = i.match(/\d+/g);
                    e.each(A, function (e, t) {
                        A[e] = parseInt(t)
                    }), s[n].key.m.today = A[0] && A[0] <= 12 ? A[0] : s[n].key.m.today, s[n].key.d.today = A[1] && A[1] <= 31 ? A[1] : s[n].key.d.today, s[n].key.y.today = A[2] ? A[2] : s[n].key.y.today, s[n].key.y.today > s[n].key.y.max && (s[n].key.y.max = s[n].key.y.today), s[n].key.y.today < s[n].key.y.min && (s[n].key.y.min = s[n].key.y.today)
                }
                for (var O in e("<div>", {
                    class: "datedropper " + C + " " + S + " " + u + " " + y,
                    id: n,
                    html: e("<div>", {class: "picker"})
                }).appendTo("body"), a = {
                    id: n,
                    input: t,
                    element: e("#" + n)
                }, s[n].key) e("<ul>", {class: "pick pick-" + O, "data-k": O}).appendTo(_(".picker")), D(O);
                if (s[n].large) {
                    e("<div>", {class: "pick-lg"}).insertBefore(_(".pick-d")), e('<ul class="pick-lg-h"></ul><ul class="pick-lg-b"></ul>').appendTo(_(".pick-lg"));
                    for (var j = T(), M = 0; 7 > M; M++) e("<li>", {html: r[s[a.id].lang].weekdays.short[j[M]]}).appendTo(_(".pick-lg .pick-lg-h"));
                    for (M = 0; 42 > M; M++) e("<li>").appendTo(_(".pick-lg .pick-lg-b"))
                }
                e("<div>", {class: "pick-btns"}).appendTo(_(".picker")), e("<div>", {class: "pick-submit"}).appendTo(_(".pick-btns")), s[a.id].translate && e("<div>", {class: "pick-btn pick-btn-lng"}).appendTo(_(".pick-btns")), s[a.id].large && e("<div>", {class: "pick-btn pick-btn-sz"}).appendTo(_(".pick-btns")), ("Y" == c || "m" == c) && (_(".pick-d,.pick-btn-sz").hide(), a.element.addClass("picker-tiny"), "Y" == c && _(".pick-m,.pick-btn-lng").hide(), "m" == c && _(".pick-y").hide()), f && (l = !0, R()), a = null
            }
        }).focus(function (t) {
            t.preventDefault(), e(this).blur(), a && I(), a = {
                id: e(this).data("id"),
                input: e(this),
                element: e("#" + e(this).data("id"))
            }, h(), j(), P(), a.element.addClass("picker-focus"), a.element.hasClass("picker-modal") && e("body").append('<div class="picker-modal-overlay"></div>')
        })
    }
}(jQuery), function (e) {
    e.fn.timeDropper = function (t, n) {
        return e(this).each(function () {
            var n, i = e(this), o = !1, r = !1, s = function (e) {
                return 10 > e ? "0" + e : e
            }, a = e(".td-clock").length, l = null, c = e.extend({
                format: "h:mm a",
                autoswitch: !1,
                meridians: !1,
                mousewheel: !1,
                setCurrentTime: !0,
                init_animation: "fadein",
                primaryColor: "#1977CC",
                borderColor: "#1977CC",
                backgroundColor: "#FFF",
                textColor: "#555"
            }, t);
            i.prop({readonly: !0}).addClass("td-input"), e("body").append('<div class="td-wrap td-n2" id="td-clock-' + a + '"><div class="td-overlay"></div><div class="td-clock td-init"><div class="td-deg td-n"><div class="td-select"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 35.4" enable-background="new 0 0 100 35.4" xml:space="preserve"><g><path fill="none" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M98.1,33C85.4,21.5,68.5,14.5,50,14.5S14.6,21.5,1.9,33"/><line fill="none" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="1.9" y1="33" x2="1.9" y2="28.6"/><line fill="none" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="1.9" y1="33" x2="6.3" y2="33"/><line fill="none" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="98.1" y1="33" x2="93.7" y2="33"/><line fill="none" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="98.1" y1="33" x2="98.1" y2="28.6"/></g></svg></div></div><div class="td-medirian"><span class="td-icon-am td-n">AM</span><span class="td-icon-pm td-n">PM</span></div><div class="td-lancette"><div></div><div></div></div><div class="td-time"><span class="on"></span>:<span></span></div></div></div>'), e("head").append("<style>#td-clock-" + a + " .td-clock {color:" + c.textColor + ";background: " + c.backgroundColor + "; box-shadow: 0 0 0 1px " + c.borderColor + ",0 0 0 8px rgba(0, 0, 0, 0.05); } #td-clock-" + a + " .td-clock .td-time span.on { color:" + c.primaryColor + "} #td-clock-" + a + " .td-clock:before { border-color: " + c.borderColor + "} #td-clock-" + a + " .td-select:after { box-shadow: 0 0 0 1px " + c.borderColor + " } #td-clock-" + a + " .td-clock:before,#td-clock-" + a + " .td-select:after {background: " + c.backgroundColor + ";} #td-clock-" + a + " .td-lancette {border: 2px solid " + c.primaryColor + "; opacity:0.1}#td-clock-" + a + " .td-lancette div:after { background: " + c.primaryColor + ";} #td-clock-" + a + " .td-bulletpoint div:after { background:" + c.primaryColor + "; opacity:0.1}</style>");
            var d = e("#td-clock-" + a), u = d.find(".td-overlay"), p = d.find(".td-clock");
            p.find("svg").attr("style", "stroke:" + c.borderColor);
            var f = -1, h = 0, m = 0, v = function () {
                var e = p.find(".td-time span.on"), t = parseInt(e.attr("data-id"));
                0 == e.index() ? deg = Math.round(360 * t / 23) : deg = Math.round(360 * t / 59), f = -1, h = deg, m = deg
            }, g = function (e) {
                var t = p.find(".td-time span.on"), n = t.attr("data-id");
                n || (n = 0);
                var o = Math.round(23 * e / 360), r = Math.round(59 * e / 360);
                if (0 == t.index() ? (t.attr("data-id", s(o)), c.meridians && (o >= 12 && 24 > o ? (p.find(".td-icon-pm").addClass("td-on"), p.find(".td-icon-am").removeClass("td-on")) : (p.find(".td-icon-am").addClass("td-on"), p.find(".td-icon-pm").removeClass("td-on")), o > 12 && (o -= 12), 0 == o && (o = 12)), t.text(s(o))) : t.attr("data-id", s(r)).text(s(r)), m = e, p.find(".td-deg").css("transform", "rotate(" + e + "deg)"), 0 == t.index()) {
                    var a = Math.round(360 * o / 12);
                    p.find(".td-lancette div:last").css("transform", "rotate(" + a + "deg)")
                } else p.find(".td-lancette div:first").css("transform", "rotate(" + e + "deg)");
                var l = p.find(".td-time span:first").attr("data-id"), d = p.find(".td-time span:last").attr("data-id");
                if (Math.round(l) >= 12 && Math.round(l) < 24) {
                    o = Math.round(l) - 12;
                    var u = "pm", f = "PM"
                } else o = Math.round(l), u = "am", f = "AM";
                0 == o && (o = 12);
                var h = c.format.replace(/\b(H)\b/g, Math.round(l)).replace(/\b(h)\b/g, Math.round(o)).replace(/\b(m)\b/g, Math.round(d)).replace(/\b(HH)\b/g, s(Math.round(l))).replace(/\b(hh)\b/g, s(Math.round(o))).replace(/\b(mm)\b/g, s(Math.round(d))).replace(/\b(a)\b/g, u).replace(/\b(A)\b/g, f);
                i.val(h)
            };
            /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && (r = !0), p.find(".td-time span").on("click", function (t) {
                var n = e(this);
                p.find(".td-time span").removeClass("on"), n.addClass("on");
                var i = parseInt(n.attr("data-id"));
                0 == n.index() ? deg = Math.round(360 * i / 23) : deg = Math.round(360 * i / 59), f = -1, h = deg, m = deg, g(deg)
            }), p.find(".td-deg").on("touchstart mousedown", function (t) {
                v(), t.preventDefault(), clearInterval(n), p.find(".td-deg").removeClass("td-n"), p.find(".td-select").removeClass("td-rubber"), o = !0;
                var i, s, a, l, c = p.offset(), d = c.top + p.height() / 2, u = c.left + p.width() / 2,
                    m = 180 / Math.PI;
                p.removeClass("td-rubber"), e(window).on("touchmove mousemove", function (e) {
                    1 == o && (move = r ? e.originalEvent.touches[0] : e, i = d - move.pageY, s = u - move.pageX, 0 > (a = Math.atan2(i, s) * m) && (a = 360 + a), -1 == f && (f = a), 0 > (l = Math.floor(a - f + h)) ? l = 360 + l : l > 360 && (l %= 360), g(l))
                })
            }), c.mousewheel && p.on("mousewheel", function (e) {
                e.preventDefault(), p.find(".td-deg").removeClass("td-n"), e.originalEvent.wheelDelta > 0 ? 360 >= m && (e.originalEvent.wheelDelta <= 120 ? m++ : e.originalEvent.wheelDelta > 120 && (m += 20), m > 360 && (m = 0)) : m >= 0 && (e.originalEvent.wheelDelta >= -120 ? m-- : e.originalEvent.wheelDelta < -120 && (m -= 20), 0 > m && (m = 360)), f = -1, h = m, g(m)
            }), e(document).on("touchend mouseup", function () {
                o && (o = !1, c.autoswitch && (p.find(".td-time span").toggleClass("on"), p.find(".td-time span.on").click()), p.find(".td-deg").addClass("td-n"), p.find(".td-select").addClass("td-rubber"))
            });
            (function (e) {
                var t, n, o = new Date, r = p.find(".td-time span:first"), a = p.find(".td-time span:last");
                if (i.val().length && !c.setCurrentTime) {
                    var l = /\d+/g, d = i.val().split(":");
                    d ? (t = d[0].match(l), n = d[1].match(l), -1 != i.val().indexOf("am") || -1 != i.val().indexOf("AM") || -1 != i.val().indexOf("pm") || -1 != i.val().indexOf("PM") ? -1 != i.val().indexOf("am") || -1 != i.val().indexOf("AM") ? 12 == t && (t = 0) : 13 > t && 24 == (t = parseInt(t) + 12) && (t = 0) : 24 == t && (t = 0)) : (t = s(parseInt(r.text()) ? r.text() : o.getHours()), n = s(parseInt(a.text()) ? a.text() : o.getMinutes()))
                } else t = s(parseInt(r.text()) ? r.text() : o.getHours()), n = s(parseInt(a.text()) ? a.text() : o.getMinutes());
                r.attr("data-id", t).text(t), a.attr("data-id", n).text(n), h = Math.round(360 * t / 23), p.find(".td-lancette div:first").css("transform", "rotate(" + Math.round(360 * n / 59) + "deg)"), g(h), m = h, f = -1
            })(), i.focus(function (e) {
                e.preventDefault(), i.blur()
            }), i.click(function (e) {
                clearInterval(l), d.removeClass("td-fadeout"), d.addClass("td-show").addClass("td-" + c.init_animation), p.css({
                    top: i.offset().top + (i.outerHeight() - 8),
                    left: i.offset().left + i.outerWidth() / 2 - p.outerWidth() / 2
                }), p.hasClass("td-init") && (n = setInterval(function () {
                    p.find(".td-select").addClass("td-alert"), setTimeout(function () {
                        p.find(".td-select").removeClass("td-alert")
                    }, 1e3)
                }, 2e3), p.removeClass("td-init"))
            }), u.click(function () {
                d.addClass("td-fadeout").removeClass("td-" + c.init_animation), l = setTimeout(function () {
                    d.removeClass("td-show")
                }, 300)
            }), e(window).on("resize", function () {
                v(), p.css({
                    top: i.offset().top + (i.outerHeight() - 8),
                    left: i.offset().left + i.outerWidth() / 2 - p.outerWidth() / 2
                })
            })
        })
    }
}(jQuery), function (e) {
    e.fn.downCount = function (t, n) {
        var i = e.extend({date: null, offset: null}, t);
        i.date || e.error("Date is not defined."), Date.parse(i.date) || e.error("Incorrect date format, it should look like this, 12/24/2012 12:00:00.");
        var o = this, r = function () {
            var e = new Date, t = e.getTime() + 6e4 * e.getTimezoneOffset();
            return new Date(t + 36e5 * i.offset)
        };
        var s = setInterval(function () {
            var e = new Date(i.date) - r();
            if (e < 0) return clearInterval(s), void (n && "function" == typeof n && n());
            var t = Math.floor(e / 864e5), a = Math.floor(e % 864e5 / 36e5), l = Math.floor(e % 36e5 / 6e4),
                c = Math.floor(e % 6e4 / 1e3), d = 1 === (t = String(t).length >= 2 ? t : "0" + t) ? "day" : "days",
                u = 1 === (a = String(a).length >= 2 ? a : "0" + a) ? "hour" : "hours",
                p = 1 === (l = String(l).length >= 2 ? l : "0" + l) ? "minute" : "minutes",
                f = 1 === (c = String(c).length >= 2 ? c : "0" + c) ? "second" : "seconds";
            o.find(".days").text(t), o.find(".hours").text(a), o.find(".minutes").text(l), o.find(".seconds").text(c), o.find(".days_ref").text(d), o.find(".hours_ref").text(u), o.find(".minutes_ref").text(p), o.find(".seconds_ref").text(f)
        }, 1e3)
    }
}(jQuery), function (e) {
    var t = [];
    e.fn.menu = function (n) {
        this.selector;
        var i = e.extend({dataJSON: !1, backLabel: ""}, n);
        return this.each(function () {
            var t, n = e(this);
            if (!n.hasClass("sliding-menu")) {
                var r, s = n.width();
                t = i.dataJSON ? function t(n, i) {
                    var r = {id: "menu-panel-" + o(), children: [], root: !i}, s = [];
                    i && r.children.push({styleClass: "back", href: "#" + i.id});
                    e(n).each(function (e, n) {
                        if (r.children.push(n), n.children) {
                            var i = t(n.children, r);
                            n.href = "#" + i[0].id, n.styleClass = "nav", s = s.concat(i)
                        }
                    });
                    return [r].concat(s)
                }(i.dataJSON) : function (t) {
                    var n = e("ul", t), i = [];
                    return e(n).each(function (t, n) {
                        var r = e(n), s = r.prev(), a = o();
                        if (1 == s.length && s.addClass("nav").attr("href", "#menu-panel-" + a), r.attr("id", "menu-panel-" + a), 0 == t) r.addClass("menu-panel-root"); else {
                            r.addClass("menu-panel"), e("<li></li>");
                            var l = e("<a></a>").addClass("back").attr("href", "#menu-panel-back");
                            r.prepend(l)
                        }
                        i.push(n)
                    }), i
                }(n), n.empty().addClass("sliding-menu"), i.dataJSON ? e(t).each(function (t, i) {
                    var o = e("<ul></ul>");
                    i.root && (r = "#" + i.id), o.attr("id", i.id), o.addClass("menu-panel"), o.width(s), e(i.children).each(function (t, n) {
                        var i = e("<a></a>");
                        i.attr("class", n.styleClass), i.attr("href", n.href), i.text(n.label);
                        var r = e("<li></li>");
                        r.append(i), o.append(r)
                    }), n.append(o)
                }) : e(t).each(function (t, i) {
                    var o = e(i);
                    o.hasClass("menu-panel-root") && (r = "#" + o.attr("id")), o.width(s), n.append(i)
                }), (r = e(r)).addClass("menu-panel-root");
                var a = r;
                n.height(r.height());
                var l = e("<div></div>").addClass("sliding-menu-wrapper").width(t.length * s);
                return n.wrapInner(l), l = e(".sliding-menu-wrapper", n), e("a", this).on("click", function (t) {
                    var o = e(this).attr("href"), r = e(this).text();
                    if (l.is(":animated")) t.preventDefault(); else if ("#" == o) t.preventDefault(); else if (0 == o.indexOf("#menu-panel")) {
                        var c = e(o), d = e(this).hasClass("back"), u = parseInt(l.css("margin-left"));
                        d ? ("#menu-panel-back" == o && (c = a.prev()), l.stop(!0, !0).animate({marginLeft: u + s}, "fast")) : (c.insertAfter(a), !0 === i.backLabel ? e(".back", c).text(r) : e(".back", c).text(i.backLabel), l.stop(!0, !0).animate({marginLeft: u - s}, "fast")), a = c, n.stop(!0, !0).animate({height: c.height()}, "fast"), t.preventDefault()
                    }
                }), this
            }
        });

        function o() {
            var e;
            do {
                e = Math.random().toString(36).substring(3, 8)
            } while (t.indexOf(e) >= 0);
            return t.push(e), e
        }
    }
}(jQuery), function (e) {
    e.fn.countTo = function (t) {
        return t = t || {}, e(this).each(function () {
            var n = e.extend({}, e.fn.countTo.defaults, {
                    from: e(this).data("from"),
                    to: e(this).data("num"),
                    speed: e(this).data("speed"),
                    refreshInterval: e(this).data("refresh-interval"),
                    decimals: e(this).data("decimals")
                }, t), i = Math.ceil(n.speed / n.refreshInterval), o = (n.to - n.from) / i, r = this, s = e(this), a = 0,
                l = n.from, c = s.data("countTo") || {};

            function d(e) {
                var t = n.formatter.call(r, e, n);
                s.text(t)
            }

            s.data("countTo", c), c.interval && clearInterval(c.interval), c.interval = setInterval(function () {
                a++, d(l += o), "function" == typeof n.onUpdate && n.onUpdate.call(r, l);
                a >= i && (s.removeData("countTo"), clearInterval(c.interval), l = n.to, "function" == typeof n.onComplete && n.onComplete.call(r, l))
            }, n.refreshInterval), d(l)
        })
    }, e.fn.countTo.defaults = {
        from: 0,
        to: 0,
        speed: 2500,
        refreshInterval: 100,
        decimals: 0,
        formatter: function (e, t) {
            return e.toFixed(t.decimals)
        },
        onUpdate: null,
        onComplete: null
    }
}(jQuery), function (e) {
    "use strict";
    "function" == typeof define && define.amd ? define(["jquery"], e) : "undefined" != typeof exports ? module.exports = e(require("jquery")) : e(jQuery)
}(function (e) {
    "use strict";
    var t = window.Slick || {};
    (t = function () {
        var t = 0;
        return function (n, i) {
            var o, r = this;
            r.defaults = {
                accessibility: !0,
                adaptiveHeight: !1,
                appendArrows: e(n),
                appendDots: e(n),
                arrows: !0,
                asNavFor: null,
                prevArrow: '<button class="slick-prev" aria-label="Previous" type="button">Previous</button>',
                nextArrow: '<button class="slick-next" aria-label="Next" type="button">Next</button>',
                autoplay: !1,
                autoplaySpeed: 3e3,
                centerMode: !1,
                centerPadding: "50px",
                cssEase: "ease",
                customPaging: function (t, n) {
                    return e('<button type="button" />').text(n + 1)
                },
                dots: !1,
                dotsClass: "slick-dots",
                draggable: !0,
                easing: "linear",
                edgeFriction: .35,
                fade: !1,
                focusOnSelect: !1,
                focusOnChange: !1,
                infinite: !0,
                initialSlide: 0,
                lazyLoad: "ondemand",
                mobileFirst: !1,
                pauseOnHover: !0,
                pauseOnFocus: !0,
                pauseOnDotsHover: !1,
                respondTo: "window",
                responsive: null,
                rows: 1,
                rtl: !1,
                slide: "",
                slidesPerRow: 1,
                slidesToShow: 1,
                slidesToScroll: 1,
                speed: 500,
                swipe: !0,
                swipeToSlide: !1,
                touchMove: !0,
                touchThreshold: 5,
                useCSS: !0,
                useTransform: !0,
                variableWidth: !1,
                vertical: !1,
                verticalSwiping: !1,
                waitForAnimate: !0,
                zIndex: 1e3
            }, r.initials = {
                animating: !1,
                dragging: !1,
                autoPlayTimer: null,
                currentDirection: 0,
                currentLeft: null,
                currentSlide: 0,
                direction: 1,
                $dots: null,
                listWidth: null,
                listHeight: null,
                loadIndex: 0,
                $nextArrow: null,
                $prevArrow: null,
                scrolling: !1,
                slideCount: null,
                slideWidth: null,
                $slideTrack: null,
                $slides: null,
                sliding: !1,
                slideOffset: 0,
                swipeLeft: null,
                swiping: !1,
                $list: null,
                touchObject: {},
                transformsEnabled: !1,
                unslicked: !1
            }, e.extend(r, r.initials), r.activeBreakpoint = null, r.animType = null, r.animProp = null, r.breakpoints = [], r.breakpointSettings = [], r.cssTransitions = !1, r.focussed = !1, r.interrupted = !1, r.hidden = "hidden", r.paused = !0, r.positionProp = null, r.respondTo = null, r.rowCount = 1, r.shouldClick = !0, r.$slider = e(n), r.$slidesCache = null, r.transformType = null, r.transitionType = null, r.visibilityChange = "visibilitychange", r.windowWidth = 0, r.windowTimer = null, o = e(n).data("slick") || {}, r.options = e.extend({}, r.defaults, i, o), r.currentSlide = r.options.initialSlide, r.originalSettings = r.options, void 0 !== document.mozHidden ? (r.hidden = "mozHidden", r.visibilityChange = "mozvisibilitychange") : void 0 !== document.webkitHidden && (r.hidden = "webkitHidden", r.visibilityChange = "webkitvisibilitychange"), r.autoPlay = e.proxy(r.autoPlay, r), r.autoPlayClear = e.proxy(r.autoPlayClear, r), r.autoPlayIterator = e.proxy(r.autoPlayIterator, r), r.changeSlide = e.proxy(r.changeSlide, r), r.clickHandler = e.proxy(r.clickHandler, r), r.selectHandler = e.proxy(r.selectHandler, r), r.setPosition = e.proxy(r.setPosition, r), r.swipeHandler = e.proxy(r.swipeHandler, r), r.dragHandler = e.proxy(r.dragHandler, r), r.keyHandler = e.proxy(r.keyHandler, r), r.instanceUid = t++, r.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/, r.registerBreakpoints(), r.init(!0)
        }
    }()).prototype.activateADA = function () {
        this.$slideTrack.find(".slick-active").attr({"aria-hidden": "false"}).find("a, input, button, select").attr({tabindex: "0"})
    }, t.prototype.addSlide = t.prototype.slickAdd = function (t, n, i) {
        var o = this;
        if ("boolean" == typeof n) i = n, n = null; else if (n < 0 || n >= o.slideCount) return !1;
        o.unload(), "number" == typeof n ? 0 === n && 0 === o.$slides.length ? e(t).appendTo(o.$slideTrack) : i ? e(t).insertBefore(o.$slides.eq(n)) : e(t).insertAfter(o.$slides.eq(n)) : !0 === i ? e(t).prependTo(o.$slideTrack) : e(t).appendTo(o.$slideTrack), o.$slides = o.$slideTrack.children(this.options.slide), o.$slideTrack.children(this.options.slide).detach(), o.$slideTrack.append(o.$slides), o.$slides.each(function (t, n) {
            e(n).attr("data-slick-index", t)
        }), o.$slidesCache = o.$slides, o.reinit()
    }, t.prototype.animateHeight = function () {
        var e = this;
        if (1 === e.options.slidesToShow && !0 === e.options.adaptiveHeight && !1 === e.options.vertical) {
            var t = e.$slides.eq(e.currentSlide).outerHeight(!0);
            e.$list.animate({height: t}, e.options.speed)
        }
    }, t.prototype.animateSlide = function (t, n) {
        var i = {}, o = this;
        o.animateHeight(), !0 === o.options.rtl && !1 === o.options.vertical && (t = -t), !1 === o.transformsEnabled ? !1 === o.options.vertical ? o.$slideTrack.animate({left: t}, o.options.speed, o.options.easing, n) : o.$slideTrack.animate({top: t}, o.options.speed, o.options.easing, n) : !1 === o.cssTransitions ? (!0 === o.options.rtl && (o.currentLeft = -o.currentLeft), e({animStart: o.currentLeft}).animate({animStart: t}, {
            duration: o.options.speed,
            easing: o.options.easing,
            step: function (e) {
                e = Math.ceil(e), !1 === o.options.vertical ? (i[o.animType] = "translate(" + e + "px, 0px)", o.$slideTrack.css(i)) : (i[o.animType] = "translate(0px," + e + "px)", o.$slideTrack.css(i))
            },
            complete: function () {
                n && n.call()
            }
        })) : (o.applyTransition(), t = Math.ceil(t), !1 === o.options.vertical ? i[o.animType] = "translate3d(" + t + "px, 0px, 0px)" : i[o.animType] = "translate3d(0px," + t + "px, 0px)", o.$slideTrack.css(i), n && setTimeout(function () {
            o.disableTransition(), n.call()
        }, o.options.speed))
    }, t.prototype.getNavTarget = function () {
        var t = this.options.asNavFor;
        return t && null !== t && (t = e(t).not(this.$slider)), t
    }, t.prototype.asNavFor = function (t) {
        var n = this.getNavTarget();
        null !== n && "object" == typeof n && n.each(function () {
            var n = e(this).slick("getSlick");
            n.unslicked || n.slideHandler(t, !0)
        })
    }, t.prototype.applyTransition = function (e) {
        var t = this, n = {};
        !1 === t.options.fade ? n[t.transitionType] = t.transformType + " " + t.options.speed + "ms " + t.options.cssEase : n[t.transitionType] = "opacity " + t.options.speed + "ms " + t.options.cssEase, !1 === t.options.fade ? t.$slideTrack.css(n) : t.$slides.eq(e).css(n)
    }, t.prototype.autoPlay = function () {
        var e = this;
        e.autoPlayClear(), e.slideCount > e.options.slidesToShow && (e.autoPlayTimer = setInterval(e.autoPlayIterator, e.options.autoplaySpeed))
    }, t.prototype.autoPlayClear = function () {
        this.autoPlayTimer && clearInterval(this.autoPlayTimer)
    }, t.prototype.autoPlayIterator = function () {
        var e = this, t = e.currentSlide + e.options.slidesToScroll;
        e.paused || e.interrupted || e.focussed || (!1 === e.options.infinite && (1 === e.direction && e.currentSlide + 1 === e.slideCount - 1 ? e.direction = 0 : 0 === e.direction && (t = e.currentSlide - e.options.slidesToScroll, e.currentSlide - 1 == 0 && (e.direction = 1))), e.slideHandler(t))
    }, t.prototype.buildArrows = function () {
        var t = this;
        !0 === t.options.arrows && (t.$prevArrow = e(t.options.prevArrow).addClass("slick-arrow"), t.$nextArrow = e(t.options.nextArrow).addClass("slick-arrow"), t.slideCount > t.options.slidesToShow ? (t.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), t.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), t.htmlExpr.test(t.options.prevArrow) && t.$prevArrow.prependTo(t.options.appendArrows), t.htmlExpr.test(t.options.nextArrow) && t.$nextArrow.appendTo(t.options.appendArrows), !0 !== t.options.infinite && t.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true")) : t.$prevArrow.add(t.$nextArrow).addClass("slick-hidden").attr({
            "aria-disabled": "true",
            tabindex: "-1"
        }))
    }, t.prototype.buildDots = function () {
        var t, n, i = this;
        if (!0 === i.options.dots) {
            for (i.$slider.addClass("slick-dotted"), n = e("<ul />").addClass(i.options.dotsClass), t = 0; t <= i.getDotCount(); t += 1) n.append(e("<li />").append(i.options.customPaging.call(this, i, t)));
            i.$dots = n.appendTo(i.options.appendDots), i.$dots.find("li").first().addClass("slick-active")
        }
    }, t.prototype.buildOut = function () {
        var t = this;
        t.$slides = t.$slider.children(t.options.slide + ":not(.slick-cloned)").addClass("slick-slide"), t.slideCount = t.$slides.length, t.$slides.each(function (t, n) {
            e(n).attr("data-slick-index", t).data("originalStyling", e(n).attr("style") || "")
        }), t.$slider.addClass("slick-slider"), t.$slideTrack = 0 === t.slideCount ? e('<div class="slick-track"/>').appendTo(t.$slider) : t.$slides.wrapAll('<div class="slick-track"/>').parent(), t.$list = t.$slideTrack.wrap('<div class="slick-list"/>').parent(), t.$slideTrack.css("opacity", 0), !0 !== t.options.centerMode && !0 !== t.options.swipeToSlide || (t.options.slidesToScroll = 1), e("img[data-lazy]", t.$slider).not("[src]").addClass("slick-loading"), t.setupInfinite(), t.buildArrows(), t.buildDots(), t.updateDots(), t.setSlideClasses("number" == typeof t.currentSlide ? t.currentSlide : 0), !0 === t.options.draggable && t.$list.addClass("draggable")
    }, t.prototype.buildRows = function () {
        var e, t, n, i, o, r, s, a = this;
        if (i = document.createDocumentFragment(), r = a.$slider.children(), a.options.rows > 1) {
            for (s = a.options.slidesPerRow * a.options.rows, o = Math.ceil(r.length / s), e = 0; e < o; e++) {
                var l = document.createElement("div");
                for (t = 0; t < a.options.rows; t++) {
                    var c = document.createElement("div");
                    for (n = 0; n < a.options.slidesPerRow; n++) {
                        var d = e * s + (t * a.options.slidesPerRow + n);
                        r.get(d) && c.appendChild(r.get(d))
                    }
                    l.appendChild(c)
                }
                i.appendChild(l)
            }
            a.$slider.empty().append(i), a.$slider.children().children().children().css({
                width: 100 / a.options.slidesPerRow + "%",
                display: "inline-block"
            })
        }
    }, t.prototype.checkResponsive = function (t, n) {
        var i, o, r, s = this, a = !1, l = s.$slider.width(), c = window.innerWidth || e(window).width();
        if ("window" === s.respondTo ? r = c : "slider" === s.respondTo ? r = l : "min" === s.respondTo && (r = Math.min(c, l)), s.options.responsive && s.options.responsive.length && null !== s.options.responsive) {
            for (i in o = null, s.breakpoints) s.breakpoints.hasOwnProperty(i) && (!1 === s.originalSettings.mobileFirst ? r < s.breakpoints[i] && (o = s.breakpoints[i]) : r > s.breakpoints[i] && (o = s.breakpoints[i]));
            null !== o ? null !== s.activeBreakpoint ? (o !== s.activeBreakpoint || n) && (s.activeBreakpoint = o, "unslick" === s.breakpointSettings[o] ? s.unslick(o) : (s.options = e.extend({}, s.originalSettings, s.breakpointSettings[o]), !0 === t && (s.currentSlide = s.options.initialSlide), s.refresh(t)), a = o) : (s.activeBreakpoint = o, "unslick" === s.breakpointSettings[o] ? s.unslick(o) : (s.options = e.extend({}, s.originalSettings, s.breakpointSettings[o]), !0 === t && (s.currentSlide = s.options.initialSlide), s.refresh(t)), a = o) : null !== s.activeBreakpoint && (s.activeBreakpoint = null, s.options = s.originalSettings, !0 === t && (s.currentSlide = s.options.initialSlide), s.refresh(t), a = o), t || !1 === a || s.$slider.trigger("breakpoint", [s, a])
        }
    }, t.prototype.changeSlide = function (t, n) {
        var i, o, r = this, s = e(t.currentTarget);
        switch (s.is("a") && t.preventDefault(), s.is("li") || (s = s.closest("li")), i = r.slideCount % r.options.slidesToScroll != 0 ? 0 : (r.slideCount - r.currentSlide) % r.options.slidesToScroll, t.data.message) {
            case"previous":
                o = 0 === i ? r.options.slidesToScroll : r.options.slidesToShow - i, r.slideCount > r.options.slidesToShow && r.slideHandler(r.currentSlide - o, !1, n);
                break;
            case"next":
                o = 0 === i ? r.options.slidesToScroll : i, r.slideCount > r.options.slidesToShow && r.slideHandler(r.currentSlide + o, !1, n);
                break;
            case"index":
                var a = 0 === t.data.index ? 0 : t.data.index || s.index() * r.options.slidesToScroll;
                r.slideHandler(r.checkNavigable(a), !1, n), s.children().trigger("focus");
                break;
            default:
                return
        }
    }, t.prototype.checkNavigable = function (e) {
        var t, n;
        if (n = 0, e > (t = this.getNavigableIndexes())[t.length - 1]) e = t[t.length - 1]; else for (var i in t) {
            if (e < t[i]) {
                e = n;
                break
            }
            n = t[i]
        }
        return e
    }, t.prototype.cleanUpEvents = function () {
        var t = this;
        t.options.dots && null !== t.$dots && (e("li", t.$dots).off("click.slick", t.changeSlide).off("mouseenter.slick", e.proxy(t.interrupt, t, !0)).off("mouseleave.slick", e.proxy(t.interrupt, t, !1)), !0 === t.options.accessibility && t.$dots.off("keydown.slick", t.keyHandler)), t.$slider.off("focus.slick blur.slick"), !0 === t.options.arrows && t.slideCount > t.options.slidesToShow && (t.$prevArrow && t.$prevArrow.off("click.slick", t.changeSlide), t.$nextArrow && t.$nextArrow.off("click.slick", t.changeSlide), !0 === t.options.accessibility && (t.$prevArrow && t.$prevArrow.off("keydown.slick", t.keyHandler), t.$nextArrow && t.$nextArrow.off("keydown.slick", t.keyHandler))), t.$list.off("touchstart.slick mousedown.slick", t.swipeHandler), t.$list.off("touchmove.slick mousemove.slick", t.swipeHandler), t.$list.off("touchend.slick mouseup.slick", t.swipeHandler), t.$list.off("touchcancel.slick mouseleave.slick", t.swipeHandler), t.$list.off("click.slick", t.clickHandler), e(document).off(t.visibilityChange, t.visibility), t.cleanUpSlideEvents(), !0 === t.options.accessibility && t.$list.off("keydown.slick", t.keyHandler), !0 === t.options.focusOnSelect && e(t.$slideTrack).children().off("click.slick", t.selectHandler), e(window).off("orientationchange.slick.slick-" + t.instanceUid, t.orientationChange), e(window).off("resize.slick.slick-" + t.instanceUid, t.resize), e("[draggable!=true]", t.$slideTrack).off("dragstart", t.preventDefault), e(window).off("load.slick.slick-" + t.instanceUid, t.setPosition)
    }, t.prototype.cleanUpSlideEvents = function () {
        var t = this;
        t.$list.off("mouseenter.slick", e.proxy(t.interrupt, t, !0)), t.$list.off("mouseleave.slick", e.proxy(t.interrupt, t, !1))
    }, t.prototype.cleanUpRows = function () {
        var e, t = this;
        t.options.rows > 1 && ((e = t.$slides.children().children()).removeAttr("style"), t.$slider.empty().append(e))
    }, t.prototype.clickHandler = function (e) {
        !1 === this.shouldClick && (e.stopImmediatePropagation(), e.stopPropagation(), e.preventDefault())
    }, t.prototype.destroy = function (t) {
        var n = this;
        n.autoPlayClear(), n.touchObject = {}, n.cleanUpEvents(), e(".slick-cloned", n.$slider).detach(), n.$dots && n.$dots.remove(), n.$prevArrow && n.$prevArrow.length && (n.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), n.htmlExpr.test(n.options.prevArrow) && n.$prevArrow.remove()), n.$nextArrow && n.$nextArrow.length && (n.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), n.htmlExpr.test(n.options.nextArrow) && n.$nextArrow.remove()), n.$slides && (n.$slides.removeClass("slick-slide slick-active slick-center slick-visible slick-current").removeAttr("aria-hidden").removeAttr("data-slick-index").each(function () {
            e(this).attr("style", e(this).data("originalStyling"))
        }), n.$slideTrack.children(this.options.slide).detach(), n.$slideTrack.detach(), n.$list.detach(), n.$slider.append(n.$slides)), n.cleanUpRows(), n.$slider.removeClass("slick-slider"), n.$slider.removeClass("slick-initialized"), n.$slider.removeClass("slick-dotted"), n.unslicked = !0, t || n.$slider.trigger("destroy", [n])
    }, t.prototype.disableTransition = function (e) {
        var t = this, n = {};
        n[t.transitionType] = "", !1 === t.options.fade ? t.$slideTrack.css(n) : t.$slides.eq(e).css(n)
    }, t.prototype.fadeSlide = function (e, t) {
        var n = this;
        !1 === n.cssTransitions ? (n.$slides.eq(e).css({zIndex: n.options.zIndex}), n.$slides.eq(e).animate({opacity: 1}, n.options.speed, n.options.easing, t)) : (n.applyTransition(e), n.$slides.eq(e).css({
            opacity: 1,
            zIndex: n.options.zIndex
        }), t && setTimeout(function () {
            n.disableTransition(e), t.call()
        }, n.options.speed))
    }, t.prototype.fadeSlideOut = function (e) {
        var t = this;
        !1 === t.cssTransitions ? t.$slides.eq(e).animate({
            opacity: 0,
            zIndex: t.options.zIndex - 2
        }, t.options.speed, t.options.easing) : (t.applyTransition(e), t.$slides.eq(e).css({
            opacity: 0,
            zIndex: t.options.zIndex - 2
        }))
    }, t.prototype.filterSlides = t.prototype.slickFilter = function (e) {
        var t = this;
        null !== e && (t.$slidesCache = t.$slides, t.unload(), t.$slideTrack.children(this.options.slide).detach(), t.$slidesCache.filter(e).appendTo(t.$slideTrack), t.reinit())
    }, t.prototype.focusHandler = function () {
        var t = this;
        t.$slider.off("focus.slick blur.slick").on("focus.slick blur.slick", "*", function (n) {
            n.stopImmediatePropagation();
            var i = e(this);
            setTimeout(function () {
                t.options.pauseOnFocus && (t.focussed = i.is(":focus"), t.autoPlay())
            }, 0)
        })
    }, t.prototype.getCurrent = t.prototype.slickCurrentSlide = function () {
        return this.currentSlide
    }, t.prototype.getDotCount = function () {
        var e = this, t = 0, n = 0, i = 0;
        if (!0 === e.options.infinite) if (e.slideCount <= e.options.slidesToShow) ++i; else for (; t < e.slideCount;) ++i, t = n + e.options.slidesToScroll, n += e.options.slidesToScroll <= e.options.slidesToShow ? e.options.slidesToScroll : e.options.slidesToShow; else if (!0 === e.options.centerMode) i = e.slideCount; else if (e.options.asNavFor) for (; t < e.slideCount;) ++i, t = n + e.options.slidesToScroll, n += e.options.slidesToScroll <= e.options.slidesToShow ? e.options.slidesToScroll : e.options.slidesToShow; else i = 1 + Math.ceil((e.slideCount - e.options.slidesToShow) / e.options.slidesToScroll);
        return i - 1
    }, t.prototype.getLeft = function (e) {
        var t, n, i, o, r = this, s = 0;
        return r.slideOffset = 0, n = r.$slides.first().outerHeight(!0), !0 === r.options.infinite ? (r.slideCount > r.options.slidesToShow && (r.slideOffset = r.slideWidth * r.options.slidesToShow * -1, o = -1, !0 === r.options.vertical && !0 === r.options.centerMode && (2 === r.options.slidesToShow ? o = -1.5 : 1 === r.options.slidesToShow && (o = -2)), s = n * r.options.slidesToShow * o), r.slideCount % r.options.slidesToScroll != 0 && e + r.options.slidesToScroll > r.slideCount && r.slideCount > r.options.slidesToShow && (e > r.slideCount ? (r.slideOffset = (r.options.slidesToShow - (e - r.slideCount)) * r.slideWidth * -1, s = (r.options.slidesToShow - (e - r.slideCount)) * n * -1) : (r.slideOffset = r.slideCount % r.options.slidesToScroll * r.slideWidth * -1, s = r.slideCount % r.options.slidesToScroll * n * -1))) : e + r.options.slidesToShow > r.slideCount && (r.slideOffset = (e + r.options.slidesToShow - r.slideCount) * r.slideWidth, s = (e + r.options.slidesToShow - r.slideCount) * n), r.slideCount <= r.options.slidesToShow && (r.slideOffset = 0, s = 0), !0 === r.options.centerMode && r.slideCount <= r.options.slidesToShow ? r.slideOffset = r.slideWidth * Math.floor(r.options.slidesToShow) / 2 - r.slideWidth * r.slideCount / 2 : !0 === r.options.centerMode && !0 === r.options.infinite ? r.slideOffset += r.slideWidth * Math.floor(r.options.slidesToShow / 2) - r.slideWidth : !0 === r.options.centerMode && (r.slideOffset = 0, r.slideOffset += r.slideWidth * Math.floor(r.options.slidesToShow / 2)), t = !1 === r.options.vertical ? e * r.slideWidth * -1 + r.slideOffset : e * n * -1 + s, !0 === r.options.variableWidth && (i = r.slideCount <= r.options.slidesToShow || !1 === r.options.infinite ? r.$slideTrack.children(".slick-slide").eq(e) : r.$slideTrack.children(".slick-slide").eq(e + r.options.slidesToShow), t = !0 === r.options.rtl ? i[0] ? -1 * (r.$slideTrack.width() - i[0].offsetLeft - i.width()) : 0 : i[0] ? -1 * i[0].offsetLeft : 0, !0 === r.options.centerMode && (i = r.slideCount <= r.options.slidesToShow || !1 === r.options.infinite ? r.$slideTrack.children(".slick-slide").eq(e) : r.$slideTrack.children(".slick-slide").eq(e + r.options.slidesToShow + 1), t = !0 === r.options.rtl ? i[0] ? -1 * (r.$slideTrack.width() - i[0].offsetLeft - i.width()) : 0 : i[0] ? -1 * i[0].offsetLeft : 0, t += (r.$list.width() - i.outerWidth()) / 2)), t
    }, t.prototype.getOption = t.prototype.slickGetOption = function (e) {
        return this.options[e]
    }, t.prototype.getNavigableIndexes = function () {
        var e, t = this, n = 0, i = 0, o = [];
        for (!1 === t.options.infinite ? e = t.slideCount : (n = -1 * t.options.slidesToScroll, i = -1 * t.options.slidesToScroll, e = 2 * t.slideCount); n < e;) o.push(n), n = i + t.options.slidesToScroll, i += t.options.slidesToScroll <= t.options.slidesToShow ? t.options.slidesToScroll : t.options.slidesToShow;
        return o
    }, t.prototype.getSlick = function () {
        return this
    }, t.prototype.getSlideCount = function () {
        var t, n, i = this;
        return n = !0 === i.options.centerMode ? i.slideWidth * Math.floor(i.options.slidesToShow / 2) : 0, !0 === i.options.swipeToSlide ? (i.$slideTrack.find(".slick-slide").each(function (o, r) {
            if (r.offsetLeft - n + e(r).outerWidth() / 2 > -1 * i.swipeLeft) return t = r, !1
        }), Math.abs(e(t).attr("data-slick-index") - i.currentSlide) || 1) : i.options.slidesToScroll
    }, t.prototype.goTo = t.prototype.slickGoTo = function (e, t) {
        this.changeSlide({data: {message: "index", index: parseInt(e)}}, t)
    }, t.prototype.init = function (t) {
        var n = this;
        e(n.$slider).hasClass("slick-initialized") || (e(n.$slider).addClass("slick-initialized"), n.buildRows(), n.buildOut(), n.setProps(), n.startLoad(), n.loadSlider(), n.initializeEvents(), n.updateArrows(), n.updateDots(), n.checkResponsive(!0), n.focusHandler()), t && n.$slider.trigger("init", [n]), !0 === n.options.accessibility && n.initADA(), n.options.autoplay && (n.paused = !1, n.autoPlay())
    }, t.prototype.initADA = function () {
        var t = this, n = Math.ceil(t.slideCount / t.options.slidesToShow),
            i = t.getNavigableIndexes().filter(function (e) {
                return e >= 0 && e < t.slideCount
            });
        t.$slides.add(t.$slideTrack.find(".slick-cloned")).attr({
            "aria-hidden": "true",
            tabindex: "-1"
        }).find("a, input, button, select").attr({tabindex: "-1"}), null !== t.$dots && (t.$slides.not(t.$slideTrack.find(".slick-cloned")).each(function (n) {
            var o = i.indexOf(n);
            e(this).attr({
                role: "tabpanel",
                id: "slick-slide" + t.instanceUid + n,
                tabindex: -1
            }), -1 !== o && e(this).attr({"aria-describedby": "slick-slide-control" + t.instanceUid + o})
        }), t.$dots.attr("role", "tablist").find("li").each(function (o) {
            var r = i[o];
            e(this).attr({role: "presentation"}), e(this).find("button").first().attr({
                role: "tab",
                id: "slick-slide-control" + t.instanceUid + o,
                "aria-controls": "slick-slide" + t.instanceUid + r,
                "aria-label": o + 1 + " of " + n,
                "aria-selected": null,
                tabindex: "-1"
            })
        }).eq(t.currentSlide).find("button").attr({"aria-selected": "true", tabindex: "0"}).end());
        for (var o = t.currentSlide, r = o + t.options.slidesToShow; o < r; o++) t.$slides.eq(o).attr("tabindex", 0);
        t.activateADA()
    }, t.prototype.initArrowEvents = function () {
        var e = this;
        !0 === e.options.arrows && e.slideCount > e.options.slidesToShow && (e.$prevArrow.off("click.slick").on("click.slick", {message: "previous"}, e.changeSlide), e.$nextArrow.off("click.slick").on("click.slick", {message: "next"}, e.changeSlide), !0 === e.options.accessibility && (e.$prevArrow.on("keydown.slick", e.keyHandler), e.$nextArrow.on("keydown.slick", e.keyHandler)))
    }, t.prototype.initDotEvents = function () {
        var t = this;
        !0 === t.options.dots && (e("li", t.$dots).on("click.slick", {message: "index"}, t.changeSlide), !0 === t.options.accessibility && t.$dots.on("keydown.slick", t.keyHandler)), !0 === t.options.dots && !0 === t.options.pauseOnDotsHover && e("li", t.$dots).on("mouseenter.slick", e.proxy(t.interrupt, t, !0)).on("mouseleave.slick", e.proxy(t.interrupt, t, !1))
    }, t.prototype.initSlideEvents = function () {
        var t = this;
        t.options.pauseOnHover && (t.$list.on("mouseenter.slick", e.proxy(t.interrupt, t, !0)), t.$list.on("mouseleave.slick", e.proxy(t.interrupt, t, !1)))
    }, t.prototype.initializeEvents = function () {
        var t = this;
        t.initArrowEvents(), t.initDotEvents(), t.initSlideEvents(), t.$list.on("touchstart.slick mousedown.slick", {action: "start"}, t.swipeHandler), t.$list.on("touchmove.slick mousemove.slick", {action: "move"}, t.swipeHandler), t.$list.on("touchend.slick mouseup.slick", {action: "end"}, t.swipeHandler), t.$list.on("touchcancel.slick mouseleave.slick", {action: "end"}, t.swipeHandler), t.$list.on("click.slick", t.clickHandler), e(document).on(t.visibilityChange, e.proxy(t.visibility, t)), !0 === t.options.accessibility && t.$list.on("keydown.slick", t.keyHandler), !0 === t.options.focusOnSelect && e(t.$slideTrack).children().on("click.slick", t.selectHandler), e(window).on("orientationchange.slick.slick-" + t.instanceUid, e.proxy(t.orientationChange, t)), e(window).on("resize.slick.slick-" + t.instanceUid, e.proxy(t.resize, t)), e("[draggable!=true]", t.$slideTrack).on("dragstart", t.preventDefault), e(window).on("load.slick.slick-" + t.instanceUid, t.setPosition), e(t.setPosition)
    }, t.prototype.initUI = function () {
        var e = this;
        !0 === e.options.arrows && e.slideCount > e.options.slidesToShow && (e.$prevArrow.show(), e.$nextArrow.show()), !0 === e.options.dots && e.slideCount > e.options.slidesToShow && e.$dots.show()
    }, t.prototype.keyHandler = function (e) {
        var t = this;
        e.target.tagName.match("TEXTAREA|INPUT|SELECT") || (37 === e.keyCode && !0 === t.options.accessibility ? t.changeSlide({data: {message: !0 === t.options.rtl ? "next" : "previous"}}) : 39 === e.keyCode && !0 === t.options.accessibility && t.changeSlide({data: {message: !0 === t.options.rtl ? "previous" : "next"}}))
    }, t.prototype.lazyLoad = function () {
        function t(t) {
            e("img[data-lazy]", t).each(function () {
                var t = e(this), n = e(this).attr("data-lazy"), i = e(this).attr("data-srcset"),
                    o = e(this).attr("data-sizes") || r.$slider.attr("data-sizes"), s = document.createElement("img");
                s.onload = function () {
                    t.animate({opacity: 0}, 100, function () {
                        i && (t.attr("srcset", i), o && t.attr("sizes", o)), t.attr("src", n).animate({opacity: 1}, 200, function () {
                            t.removeAttr("data-lazy data-srcset data-sizes").removeClass("slick-loading")
                        }), r.$slider.trigger("lazyLoaded", [r, t, n])
                    })
                }, s.onerror = function () {
                    t.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), r.$slider.trigger("lazyLoadError", [r, t, n])
                }, s.src = n
            })
        }

        var n, i, o, r = this;
        if (!0 === r.options.centerMode ? !0 === r.options.infinite ? o = (i = r.currentSlide + (r.options.slidesToShow / 2 + 1)) + r.options.slidesToShow + 2 : (i = Math.max(0, r.currentSlide - (r.options.slidesToShow / 2 + 1)), o = r.options.slidesToShow / 2 + 1 + 2 + r.currentSlide) : (i = r.options.infinite ? r.options.slidesToShow + r.currentSlide : r.currentSlide, o = Math.ceil(i + r.options.slidesToShow), !0 === r.options.fade && (i > 0 && i--, o <= r.slideCount && o++)), n = r.$slider.find(".slick-slide").slice(i, o), "anticipated" === r.options.lazyLoad) for (var s = i - 1, a = o, l = r.$slider.find(".slick-slide"), c = 0; c < r.options.slidesToScroll; c++) s < 0 && (s = r.slideCount - 1), n = (n = n.add(l.eq(s))).add(l.eq(a)), s--, a++;
        t(n), r.slideCount <= r.options.slidesToShow ? t(r.$slider.find(".slick-slide")) : r.currentSlide >= r.slideCount - r.options.slidesToShow ? t(r.$slider.find(".slick-cloned").slice(0, r.options.slidesToShow)) : 0 === r.currentSlide && t(r.$slider.find(".slick-cloned").slice(-1 * r.options.slidesToShow))
    }, t.prototype.loadSlider = function () {
        var e = this;
        e.setPosition(), e.$slideTrack.css({opacity: 1}), e.$slider.removeClass("slick-loading"), e.initUI(), "progressive" === e.options.lazyLoad && e.progressiveLazyLoad()
    }, t.prototype.next = t.prototype.slickNext = function () {
        this.changeSlide({data: {message: "next"}})
    }, t.prototype.orientationChange = function () {
        this.checkResponsive(), this.setPosition()
    }, t.prototype.pause = t.prototype.slickPause = function () {
        this.autoPlayClear(), this.paused = !0
    }, t.prototype.play = t.prototype.slickPlay = function () {
        var e = this;
        e.autoPlay(), e.options.autoplay = !0, e.paused = !1, e.focussed = !1, e.interrupted = !1
    }, t.prototype.postSlide = function (t) {
        var n = this;
        n.unslicked || (n.$slider.trigger("afterChange", [n, t]), n.animating = !1, n.slideCount > n.options.slidesToShow && n.setPosition(), n.swipeLeft = null, n.options.autoplay && n.autoPlay(), !0 === n.options.accessibility && (n.initADA(), n.options.focusOnChange && e(n.$slides.get(n.currentSlide)).attr("tabindex", 0).focus()))
    }, t.prototype.prev = t.prototype.slickPrev = function () {
        this.changeSlide({data: {message: "previous"}})
    }, t.prototype.preventDefault = function (e) {
        e.preventDefault()
    }, t.prototype.progressiveLazyLoad = function (t) {
        t = t || 1;
        var n, i, o, r, s, a = this, l = e("img[data-lazy]", a.$slider);
        l.length ? (n = l.first(), i = n.attr("data-lazy"), o = n.attr("data-srcset"), r = n.attr("data-sizes") || a.$slider.attr("data-sizes"), (s = document.createElement("img")).onload = function () {
            o && (n.attr("srcset", o), r && n.attr("sizes", r)), n.attr("src", i).removeAttr("data-lazy data-srcset data-sizes").removeClass("slick-loading"), !0 === a.options.adaptiveHeight && a.setPosition(), a.$slider.trigger("lazyLoaded", [a, n, i]), a.progressiveLazyLoad()
        }, s.onerror = function () {
            t < 3 ? setTimeout(function () {
                a.progressiveLazyLoad(t + 1)
            }, 500) : (n.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), a.$slider.trigger("lazyLoadError", [a, n, i]), a.progressiveLazyLoad())
        }, s.src = i) : a.$slider.trigger("allImagesLoaded", [a])
    }, t.prototype.refresh = function (t) {
        var n, i, o = this;
        i = o.slideCount - o.options.slidesToShow, !o.options.infinite && o.currentSlide > i && (o.currentSlide = i), o.slideCount <= o.options.slidesToShow && (o.currentSlide = 0), n = o.currentSlide, o.destroy(!0), e.extend(o, o.initials, {currentSlide: n}), o.init(), t || o.changeSlide({
            data: {
                message: "index",
                index: n
            }
        }, !1)
    }, t.prototype.registerBreakpoints = function () {
        var t, n, i, o = this, r = o.options.responsive || null;
        if ("array" === e.type(r) && r.length) {
            for (t in o.respondTo = o.options.respondTo || "window", r) if (i = o.breakpoints.length - 1, r.hasOwnProperty(t)) {
                for (n = r[t].breakpoint; i >= 0;) o.breakpoints[i] && o.breakpoints[i] === n && o.breakpoints.splice(i, 1), i--;
                o.breakpoints.push(n), o.breakpointSettings[n] = r[t].settings
            }
            o.breakpoints.sort(function (e, t) {
                return o.options.mobileFirst ? e - t : t - e
            })
        }
    }, t.prototype.reinit = function () {
        var t = this;
        t.$slides = t.$slideTrack.children(t.options.slide).addClass("slick-slide"), t.slideCount = t.$slides.length, t.currentSlide >= t.slideCount && 0 !== t.currentSlide && (t.currentSlide = t.currentSlide - t.options.slidesToScroll), t.slideCount <= t.options.slidesToShow && (t.currentSlide = 0), t.registerBreakpoints(), t.setProps(), t.setupInfinite(), t.buildArrows(), t.updateArrows(), t.initArrowEvents(), t.buildDots(), t.updateDots(), t.initDotEvents(), t.cleanUpSlideEvents(), t.initSlideEvents(), t.checkResponsive(!1, !0), !0 === t.options.focusOnSelect && e(t.$slideTrack).children().on("click.slick", t.selectHandler), t.setSlideClasses("number" == typeof t.currentSlide ? t.currentSlide : 0), t.setPosition(), t.focusHandler(), t.paused = !t.options.autoplay, t.autoPlay(), t.$slider.trigger("reInit", [t])
    }, t.prototype.resize = function () {
        var t = this;
        e(window).width() !== t.windowWidth && (clearTimeout(t.windowDelay), t.windowDelay = window.setTimeout(function () {
            t.windowWidth = e(window).width(), t.checkResponsive(), t.unslicked || t.setPosition()
        }, 50))
    }, t.prototype.removeSlide = t.prototype.slickRemove = function (e, t, n) {
        var i = this;
        if (e = "boolean" == typeof e ? !0 === (t = e) ? 0 : i.slideCount - 1 : !0 === t ? --e : e, i.slideCount < 1 || e < 0 || e > i.slideCount - 1) return !1;
        i.unload(), !0 === n ? i.$slideTrack.children().remove() : i.$slideTrack.children(this.options.slide).eq(e).remove(), i.$slides = i.$slideTrack.children(this.options.slide), i.$slideTrack.children(this.options.slide).detach(), i.$slideTrack.append(i.$slides), i.$slidesCache = i.$slides, i.reinit()
    }, t.prototype.setCSS = function (e) {
        var t, n, i = this, o = {};
        !0 === i.options.rtl && (e = -e), t = "left" == i.positionProp ? Math.ceil(e) + "px" : "0px", n = "top" == i.positionProp ? Math.ceil(e) + "px" : "0px", o[i.positionProp] = e, !1 === i.transformsEnabled ? i.$slideTrack.css(o) : (o = {}, !1 === i.cssTransitions ? (o[i.animType] = "translate(" + t + ", " + n + ")", i.$slideTrack.css(o)) : (o[i.animType] = "translate3d(" + t + ", " + n + ", 0px)", i.$slideTrack.css(o)))
    }, t.prototype.setDimensions = function () {
        var e = this;
        !1 === e.options.vertical ? !0 === e.options.centerMode && e.$list.css({padding: "0px " + e.options.centerPadding}) : (e.$list.height(e.$slides.first().outerHeight(!0) * e.options.slidesToShow), !0 === e.options.centerMode && e.$list.css({padding: e.options.centerPadding + " 0px"})), e.listWidth = e.$list.width(), e.listHeight = e.$list.height(), !1 === e.options.vertical && !1 === e.options.variableWidth ? (e.slideWidth = Math.ceil(e.listWidth / e.options.slidesToShow), e.$slideTrack.width(Math.ceil(e.slideWidth * e.$slideTrack.children(".slick-slide").length))) : !0 === e.options.variableWidth ? e.$slideTrack.width(5e3 * e.slideCount) : (e.slideWidth = Math.ceil(e.listWidth), e.$slideTrack.height(Math.ceil(e.$slides.first().outerHeight(!0) * e.$slideTrack.children(".slick-slide").length)));
        var t = e.$slides.first().outerWidth(!0) - e.$slides.first().width();
        !1 === e.options.variableWidth && e.$slideTrack.children(".slick-slide").width(e.slideWidth - t)
    }, t.prototype.setFade = function () {
        var t, n = this;
        n.$slides.each(function (i, o) {
            t = n.slideWidth * i * -1, !0 === n.options.rtl ? e(o).css({
                position: "relative",
                right: t,
                top: 0,
                zIndex: n.options.zIndex - 2,
                opacity: 0
            }) : e(o).css({position: "relative", left: t, top: 0, zIndex: n.options.zIndex - 2, opacity: 0})
        }), n.$slides.eq(n.currentSlide).css({zIndex: n.options.zIndex - 1, opacity: 1})
    }, t.prototype.setHeight = function () {
        var e = this;
        if (1 === e.options.slidesToShow && !0 === e.options.adaptiveHeight && !1 === e.options.vertical) {
            var t = e.$slides.eq(e.currentSlide).outerHeight(!0);
            e.$list.css("height", t)
        }
    }, t.prototype.setOption = t.prototype.slickSetOption = function () {
        var t, n, i, o, r, s = this, a = !1;
        if ("object" === e.type(arguments[0]) ? (i = arguments[0], a = arguments[1], r = "multiple") : "string" === e.type(arguments[0]) && (i = arguments[0], o = arguments[1], a = arguments[2], "responsive" === arguments[0] && "array" === e.type(arguments[1]) ? r = "responsive" : void 0 !== arguments[1] && (r = "single")), "single" === r) s.options[i] = o; else if ("multiple" === r) e.each(i, function (e, t) {
            s.options[e] = t
        }); else if ("responsive" === r) for (n in o) if ("array" !== e.type(s.options.responsive)) s.options.responsive = [o[n]]; else {
            for (t = s.options.responsive.length - 1; t >= 0;) s.options.responsive[t].breakpoint === o[n].breakpoint && s.options.responsive.splice(t, 1), t--;
            s.options.responsive.push(o[n])
        }
        a && (s.unload(), s.reinit())
    }, t.prototype.setPosition = function () {
        var e = this;
        e.setDimensions(), e.setHeight(), !1 === e.options.fade ? e.setCSS(e.getLeft(e.currentSlide)) : e.setFade(), e.$slider.trigger("setPosition", [e])
    }, t.prototype.setProps = function () {
        var e = this, t = document.body.style;
        e.positionProp = !0 === e.options.vertical ? "top" : "left", "top" === e.positionProp ? e.$slider.addClass("slick-vertical") : e.$slider.removeClass("slick-vertical"), void 0 === t.WebkitTransition && void 0 === t.MozTransition && void 0 === t.msTransition || !0 === e.options.useCSS && (e.cssTransitions = !0), e.options.fade && ("number" == typeof e.options.zIndex ? e.options.zIndex < 3 && (e.options.zIndex = 3) : e.options.zIndex = e.defaults.zIndex), void 0 !== t.OTransform && (e.animType = "OTransform", e.transformType = "-o-transform", e.transitionType = "OTransition", void 0 === t.perspectiveProperty && void 0 === t.webkitPerspective && (e.animType = !1)), void 0 !== t.MozTransform && (e.animType = "MozTransform", e.transformType = "-moz-transform", e.transitionType = "MozTransition", void 0 === t.perspectiveProperty && void 0 === t.MozPerspective && (e.animType = !1)), void 0 !== t.webkitTransform && (e.animType = "webkitTransform", e.transformType = "-webkit-transform", e.transitionType = "webkitTransition", void 0 === t.perspectiveProperty && void 0 === t.webkitPerspective && (e.animType = !1)), void 0 !== t.msTransform && (e.animType = "msTransform", e.transformType = "-ms-transform", e.transitionType = "msTransition", void 0 === t.msTransform && (e.animType = !1)), void 0 !== t.transform && !1 !== e.animType && (e.animType = "transform", e.transformType = "transform", e.transitionType = "transition"), e.transformsEnabled = e.options.useTransform && null !== e.animType && !1 !== e.animType
    }, t.prototype.setSlideClasses = function (e) {
        var t, n, i, o, r = this;
        if (n = r.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden", "true"), r.$slides.eq(e).addClass("slick-current"), !0 === r.options.centerMode) {
            var s = r.options.slidesToShow % 2 == 0 ? 1 : 0;
            t = Math.floor(r.options.slidesToShow / 2), !0 === r.options.infinite && (e >= t && e <= r.slideCount - 1 - t ? r.$slides.slice(e - t + s, e + t + 1).addClass("slick-active").attr("aria-hidden", "false") : (i = r.options.slidesToShow + e, n.slice(i - t + 1 + s, i + t + 2).addClass("slick-active").attr("aria-hidden", "false")), 0 === e ? n.eq(n.length - 1 - r.options.slidesToShow).addClass("slick-center") : e === r.slideCount - 1 && n.eq(r.options.slidesToShow).addClass("slick-center")), r.$slides.eq(e).addClass("slick-center")
        } else e >= 0 && e <= r.slideCount - r.options.slidesToShow ? r.$slides.slice(e, e + r.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false") : n.length <= r.options.slidesToShow ? n.addClass("slick-active").attr("aria-hidden", "false") : (o = r.slideCount % r.options.slidesToShow, i = !0 === r.options.infinite ? r.options.slidesToShow + e : e, r.options.slidesToShow == r.options.slidesToScroll && r.slideCount - e < r.options.slidesToShow ? n.slice(i - (r.options.slidesToShow - o), i + o).addClass("slick-active").attr("aria-hidden", "false") : n.slice(i, i + r.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false"));
        "ondemand" !== r.options.lazyLoad && "anticipated" !== r.options.lazyLoad || r.lazyLoad()
    }, t.prototype.setupInfinite = function () {
        var t, n, i, o = this;
        if (!0 === o.options.fade && (o.options.centerMode = !1), !0 === o.options.infinite && !1 === o.options.fade && (n = null, o.slideCount > o.options.slidesToShow)) {
            for (i = !0 === o.options.centerMode ? o.options.slidesToShow + 1 : o.options.slidesToShow, t = o.slideCount; t > o.slideCount - i; t -= 1) n = t - 1, e(o.$slides[n]).clone(!0).attr("id", "").attr("data-slick-index", n - o.slideCount).prependTo(o.$slideTrack).addClass("slick-cloned");
            for (t = 0; t < i + o.slideCount; t += 1) n = t, e(o.$slides[n]).clone(!0).attr("id", "").attr("data-slick-index", n + o.slideCount).appendTo(o.$slideTrack).addClass("slick-cloned");
            o.$slideTrack.find(".slick-cloned").find("[id]").each(function () {
                e(this).attr("id", "")
            })
        }
    }, t.prototype.interrupt = function (e) {
        e || this.autoPlay(), this.interrupted = e
    }, t.prototype.selectHandler = function (t) {
        var n = this, i = e(t.target).is(".slick-slide") ? e(t.target) : e(t.target).parents(".slick-slide"),
            o = parseInt(i.attr("data-slick-index"));
        o || (o = 0), n.slideCount <= n.options.slidesToShow ? n.slideHandler(o, !1, !0) : n.slideHandler(o)
    }, t.prototype.slideHandler = function (e, t, n) {
        var i, o, r, s, a, l = null, c = this;
        if (t = t || !1, !(!0 === c.animating && !0 === c.options.waitForAnimate || !0 === c.options.fade && c.currentSlide === e)) if (!1 === t && c.asNavFor(e), i = e, l = c.getLeft(i), s = c.getLeft(c.currentSlide), c.currentLeft = null === c.swipeLeft ? s : c.swipeLeft, !1 === c.options.infinite && !1 === c.options.centerMode && (e < 0 || e > c.getDotCount() * c.options.slidesToScroll)) !1 === c.options.fade && (i = c.currentSlide, !0 !== n ? c.animateSlide(s, function () {
            c.postSlide(i)
        }) : c.postSlide(i)); else if (!1 === c.options.infinite && !0 === c.options.centerMode && (e < 0 || e > c.slideCount - c.options.slidesToScroll)) !1 === c.options.fade && (i = c.currentSlide, !0 !== n ? c.animateSlide(s, function () {
            c.postSlide(i)
        }) : c.postSlide(i)); else {
            if (c.options.autoplay && clearInterval(c.autoPlayTimer), o = i < 0 ? c.slideCount % c.options.slidesToScroll != 0 ? c.slideCount - c.slideCount % c.options.slidesToScroll : c.slideCount + i : i >= c.slideCount ? c.slideCount % c.options.slidesToScroll != 0 ? 0 : i - c.slideCount : i, c.animating = !0, c.$slider.trigger("beforeChange", [c, c.currentSlide, o]), r = c.currentSlide, c.currentSlide = o, c.setSlideClasses(c.currentSlide), c.options.asNavFor && (a = (a = c.getNavTarget()).slick("getSlick")).slideCount <= a.options.slidesToShow && a.setSlideClasses(c.currentSlide), c.updateDots(), c.updateArrows(), !0 === c.options.fade) return !0 !== n ? (c.fadeSlideOut(r), c.fadeSlide(o, function () {
                c.postSlide(o)
            })) : c.postSlide(o), void c.animateHeight();
            !0 !== n ? c.animateSlide(l, function () {
                c.postSlide(o)
            }) : c.postSlide(o)
        }
    }, t.prototype.startLoad = function () {
        var e = this;
        !0 === e.options.arrows && e.slideCount > e.options.slidesToShow && (e.$prevArrow.hide(), e.$nextArrow.hide()), !0 === e.options.dots && e.slideCount > e.options.slidesToShow && e.$dots.hide(), e.$slider.addClass("slick-loading")
    }, t.prototype.swipeDirection = function () {
        var e, t, n, i, o = this;
        return e = o.touchObject.startX - o.touchObject.curX, t = o.touchObject.startY - o.touchObject.curY, n = Math.atan2(t, e), (i = Math.round(180 * n / Math.PI)) < 0 && (i = 360 - Math.abs(i)), i <= 45 && i >= 0 ? !1 === o.options.rtl ? "left" : "right" : i <= 360 && i >= 315 ? !1 === o.options.rtl ? "left" : "right" : i >= 135 && i <= 225 ? !1 === o.options.rtl ? "right" : "left" : !0 === o.options.verticalSwiping ? i >= 35 && i <= 135 ? "down" : "up" : "vertical"
    }, t.prototype.swipeEnd = function (e) {
        var t, n, i = this;
        if (i.dragging = !1, i.swiping = !1, i.scrolling) return i.scrolling = !1, !1;
        if (i.interrupted = !1, i.shouldClick = !(i.touchObject.swipeLength > 10), void 0 === i.touchObject.curX) return !1;
        if (!0 === i.touchObject.edgeHit && i.$slider.trigger("edge", [i, i.swipeDirection()]), i.touchObject.swipeLength >= i.touchObject.minSwipe) {
            switch (n = i.swipeDirection()) {
                case"left":
                case"down":
                    t = i.options.swipeToSlide ? i.checkNavigable(i.currentSlide + i.getSlideCount()) : i.currentSlide + i.getSlideCount(), i.currentDirection = 0;
                    break;
                case"right":
                case"up":
                    t = i.options.swipeToSlide ? i.checkNavigable(i.currentSlide - i.getSlideCount()) : i.currentSlide - i.getSlideCount(), i.currentDirection = 1
            }
            "vertical" != n && (i.slideHandler(t), i.touchObject = {}, i.$slider.trigger("swipe", [i, n]))
        } else i.touchObject.startX !== i.touchObject.curX && (i.slideHandler(i.currentSlide), i.touchObject = {})
    }, t.prototype.swipeHandler = function (e) {
        var t = this;
        if (!(!1 === t.options.swipe || "ontouchend" in document && !1 === t.options.swipe || !1 === t.options.draggable && -1 !== e.type.indexOf("mouse"))) switch (t.touchObject.fingerCount = e.originalEvent && void 0 !== e.originalEvent.touches ? e.originalEvent.touches.length : 1, t.touchObject.minSwipe = t.listWidth / t.options.touchThreshold, !0 === t.options.verticalSwiping && (t.touchObject.minSwipe = t.listHeight / t.options.touchThreshold), e.data.action) {
            case"start":
                t.swipeStart(e);
                break;
            case"move":
                t.swipeMove(e);
                break;
            case"end":
                t.swipeEnd(e)
        }
    }, t.prototype.swipeMove = function (e) {
        var t, n, i, o, r, s, a = this;
        return r = void 0 !== e.originalEvent ? e.originalEvent.touches : null, !(!a.dragging || a.scrolling || r && 1 !== r.length) && (t = a.getLeft(a.currentSlide), a.touchObject.curX = void 0 !== r ? r[0].pageX : e.clientX, a.touchObject.curY = void 0 !== r ? r[0].pageY : e.clientY, a.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(a.touchObject.curX - a.touchObject.startX, 2))), s = Math.round(Math.sqrt(Math.pow(a.touchObject.curY - a.touchObject.startY, 2))), !a.options.verticalSwiping && !a.swiping && s > 4 ? (a.scrolling = !0, !1) : (!0 === a.options.verticalSwiping && (a.touchObject.swipeLength = s), n = a.swipeDirection(), void 0 !== e.originalEvent && a.touchObject.swipeLength > 4 && (a.swiping = !0, e.preventDefault()), o = (!1 === a.options.rtl ? 1 : -1) * (a.touchObject.curX > a.touchObject.startX ? 1 : -1), !0 === a.options.verticalSwiping && (o = a.touchObject.curY > a.touchObject.startY ? 1 : -1), i = a.touchObject.swipeLength, a.touchObject.edgeHit = !1, !1 === a.options.infinite && (0 === a.currentSlide && "right" === n || a.currentSlide >= a.getDotCount() && "left" === n) && (i = a.touchObject.swipeLength * a.options.edgeFriction, a.touchObject.edgeHit = !0), !1 === a.options.vertical ? a.swipeLeft = t + i * o : a.swipeLeft = t + i * (a.$list.height() / a.listWidth) * o, !0 === a.options.verticalSwiping && (a.swipeLeft = t + i * o), !0 !== a.options.fade && !1 !== a.options.touchMove && (!0 === a.animating ? (a.swipeLeft = null, !1) : void a.setCSS(a.swipeLeft))))
    }, t.prototype.swipeStart = function (e) {
        var t, n = this;
        if (n.interrupted = !0, 1 !== n.touchObject.fingerCount || n.slideCount <= n.options.slidesToShow) return n.touchObject = {}, !1;
        void 0 !== e.originalEvent && void 0 !== e.originalEvent.touches && (t = e.originalEvent.touches[0]), n.touchObject.startX = n.touchObject.curX = void 0 !== t ? t.pageX : e.clientX, n.touchObject.startY = n.touchObject.curY = void 0 !== t ? t.pageY : e.clientY, n.dragging = !0
    }, t.prototype.unfilterSlides = t.prototype.slickUnfilter = function () {
        var e = this;
        null !== e.$slidesCache && (e.unload(), e.$slideTrack.children(this.options.slide).detach(), e.$slidesCache.appendTo(e.$slideTrack), e.reinit())
    }, t.prototype.unload = function () {
        var t = this;
        e(".slick-cloned", t.$slider).remove(), t.$dots && t.$dots.remove(), t.$prevArrow && t.htmlExpr.test(t.options.prevArrow) && t.$prevArrow.remove(), t.$nextArrow && t.htmlExpr.test(t.options.nextArrow) && t.$nextArrow.remove(), t.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden", "true").css("width", "")
    }, t.prototype.unslick = function (e) {
        var t = this;
        t.$slider.trigger("unslick", [t, e]), t.destroy()
    }, t.prototype.updateArrows = function () {
        var e = this;
        Math.floor(e.options.slidesToShow / 2), !0 === e.options.arrows && e.slideCount > e.options.slidesToShow && !e.options.infinite && (e.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), e.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), 0 === e.currentSlide ? (e.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true"), e.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : e.currentSlide >= e.slideCount - e.options.slidesToShow && !1 === e.options.centerMode ? (e.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), e.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : e.currentSlide >= e.slideCount - 1 && !0 === e.options.centerMode && (e.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), e.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")))
    }, t.prototype.updateDots = function () {
        var e = this;
        null !== e.$dots && (e.$dots.find("li").removeClass("slick-active").end(), e.$dots.find("li").eq(Math.floor(e.currentSlide / e.options.slidesToScroll)).addClass("slick-active"))
    }, t.prototype.visibility = function () {
        var e = this;
        e.options.autoplay && (document[e.hidden] ? e.interrupted = !0 : e.interrupted = !1)
    }, e.fn.slick = function () {
        var e, n, i = this, o = arguments[0], r = Array.prototype.slice.call(arguments, 1), s = i.length;
        for (e = 0; e < s; e++) if ("object" == typeof o || void 0 === o ? i[e].slick = new t(i[e], o) : n = i[e].slick[o].apply(i[e].slick, r), void 0 !== n) return n;
        return i
    }
}), jQuery, $.fn.ideaboxWeather = function (e) {
    return e = $.extend({
        modulid: "ideaboxWeather",
        width: "100%",
        themecolor: "#069",
        todaytext: "Today",
        radius: !0,
        location: "Newyork",
        daycount: 7,
        imgpath: $resourceRoot + "images/wimg/",
        template: "vertical",
        lang: "en",
        metric: "C",
        days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        dayssmall: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
    }, e), this.each(function () {
        function t() {
            $(e.modulid).width() < 200 ? $(e.modulid).addClass("ow-small") : $(e.modulid).removeClass("ow-small")
        }

        function n(e) {
            return e.substring(0, 1).toUpperCase() + e.substring(1).toLowerCase()
        }

        e.modulid = "#" + $(this).attr("id"), $(e.modulid).css({
            width: e.width,
            background: e.themecolor
        }), e.radius && $(e.modulid).addClass("ow-border"), $.get("http://api.openweathermap.org/data/2.5/forecast/daily?q=" + e.location + "&mode=xml&units=metric&cnt=" + e.daycount + "&lang=" + e.lang + "&appid=0ac06341513ff205b3e3f3b6188588e3", function (t) {
            var i = $(t), o = "", r = i.find("name").text();
            i.find("time").each(function (t, i) {
                var s, a = $(this), l = new Date($(this).attr("day")).getDay();
                s = "F" == e.metric ? Math.round(1.8 * a.find("temperature").attr("day") + 32) + " &#x2109;" : Math.round(a.find("temperature").attr("day")) + " &#8451;", o = 0 == t ? (e.template, o + '<div class="ow-today"><span><img src="' + e.imgpath + a.find("symbol").attr("var") + '.png"/></span><h2>' + s + "<span>" + n(a.find("symbol").attr("name")) + "</span><b>" + r + " - " + e.todaytext + "</b></h2></div>") : "vertical" == e.template ? o + '<div class="ow-days"><span>' + e.days[l] + '</span><p><img src="' + e.imgpath + a.find("symbol").attr("var") + '.png" title="' + n(a.find("symbol").attr("name")) + '"> <b>' + s + "</b></p></div>" : o + '<div class="ow-dayssmall" style="width:' + 100 / (e.daycount - 1) + '%"><span title=' + e.days[l] + ">" + e.dayssmall[l] + '</span><p><img src="' + e.imgpath + a.find("symbol").attr("var") + '.png" title="' + n(a.find("symbol").attr("name")) + '"></p><b>' + s + "</b></div>"
            }), $(e.modulid).html(o)
        }), t(), $(window).on("resize", function () {
            t()
        })
    })
}, function (e, t) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define(t) : (e = e || self).Vue = t()
}(this, function () {
    "use strict";
    var e = Object.freeze({});

    function t(e) {
        return null == e
    }

    function n(e) {
        return null != e
    }

    function i(e) {
        return !0 === e
    }

    function o(e) {
        return "string" == typeof e || "number" == typeof e || "symbol" == typeof e || "boolean" == typeof e
    }

    function r(e) {
        return null !== e && "object" == typeof e
    }

    var s = Object.prototype.toString;

    function a(e) {
        return s.call(e).slice(8, -1)
    }

    function l(e) {
        return "[object Object]" === s.call(e)
    }

    function c(e) {
        return "[object RegExp]" === s.call(e)
    }

    function d(e) {
        var t = parseFloat(String(e));
        return t >= 0 && Math.floor(t) === t && isFinite(e)
    }

    function u(e) {
        return n(e) && "function" == typeof e.then && "function" == typeof e.catch
    }

    function p(e) {
        return null == e ? "" : Array.isArray(e) || l(e) && e.toString === s ? JSON.stringify(e, null, 2) : String(e)
    }

    function f(e) {
        var t = parseFloat(e);
        return isNaN(t) ? e : t
    }

    function h(e, t) {
        for (var n = Object.create(null), i = e.split(","), o = 0; o < i.length; o++) n[i[o]] = !0;
        return t ? function (e) {
            return n[e.toLowerCase()]
        } : function (e) {
            return n[e]
        }
    }

    var m = h("slot,component", !0), v = h("key,ref,slot,slot-scope,is");

    function g(e, t) {
        if (e.length) {
            var n = e.indexOf(t);
            if (n > -1) return e.splice(n, 1)
        }
    }

    var y = Object.prototype.hasOwnProperty;

    function b(e, t) {
        return y.call(e, t)
    }

    function w(e) {
        var t = Object.create(null);
        return function (n) {
            return t[n] || (t[n] = e(n))
        }
    }

    var x = /-(\w)/g, k = w(function (e) {
        return e.replace(x, function (e, t) {
            return t ? t.toUpperCase() : ""
        })
    }), C = w(function (e) {
        return e.charAt(0).toUpperCase() + e.slice(1)
    }), T = /\B([A-Z])/g, S = w(function (e) {
        return e.replace(T, "-$1").toLowerCase()
    });
    var $ = Function.prototype.bind ? function (e, t) {
        return e.bind(t)
    } : function (e, t) {
        function n(n) {
            var i = arguments.length;
            return i ? i > 1 ? e.apply(t, arguments) : e.call(t, n) : e.call(t)
        }

        return n._length = e.length, n
    };

    function _(e, t) {
        t = t || 0;
        for (var n = e.length - t, i = new Array(n); n--;) i[n] = e[n + t];
        return i
    }

    function E(e, t) {
        for (var n in t) e[n] = t[n];
        return e
    }

    function A(e) {
        for (var t = {}, n = 0; n < e.length; n++) e[n] && E(t, e[n]);
        return t
    }

    function O(e, t, n) {
    }

    var j = function (e, t, n) {
        return !1
    }, M = function (e) {
        return e
    };

    function I(e, t) {
        if (e === t) return !0;
        var n = r(e), i = r(t);
        if (!n || !i) return !n && !i && String(e) === String(t);
        try {
            var o = Array.isArray(e), s = Array.isArray(t);
            if (o && s) return e.length === t.length && e.every(function (e, n) {
                return I(e, t[n])
            });
            if (e instanceof Date && t instanceof Date) return e.getTime() === t.getTime();
            if (o || s) return !1;
            var a = Object.keys(e), l = Object.keys(t);
            return a.length === l.length && a.every(function (n) {
                return I(e[n], t[n])
            })
        } catch (e) {
            return !1
        }
    }

    function D(e, t) {
        for (var n = 0; n < e.length; n++) if (I(e[n], t)) return n;
        return -1
    }

    function L(e) {
        var t = !1;
        return function () {
            t || (t = !0, e.apply(this, arguments))
        }
    }

    var P = "data-server-rendered", z = ["component", "directive", "filter"],
        N = ["beforeCreate", "created", "beforeMount", "mounted", "beforeUpdate", "updated", "beforeDestroy", "destroyed", "activated", "deactivated", "errorCaptured", "serverPrefetch"],
        F = {
            optionMergeStrategies: Object.create(null),
            silent: !1,
            productionTip: !0,
            devtools: !0,
            performance: !1,
            errorHandler: null,
            warnHandler: null,
            ignoredElements: [],
            keyCodes: Object.create(null),
            isReservedTag: j,
            isReservedAttr: j,
            isUnknownElement: j,
            getTagNamespace: O,
            parsePlatformTagName: M,
            mustUseProp: j,
            async: !0,
            _lifecycleHooks: N
        },
        H = /a-zA-Z\u00B7\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u037D\u037F-\u1FFF\u200C-\u200D\u203F-\u2040\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD/;

    function q(e) {
        var t = (e + "").charCodeAt(0);
        return 36 === t || 95 === t
    }

    function R(e, t, n, i) {
        Object.defineProperty(e, t, {value: n, enumerable: !!i, writable: !0, configurable: !0})
    }

    var W = new RegExp("[^" + H.source + ".$_\\d]");
    var B, U = "__proto__" in {}, Y = "undefined" != typeof window,
        V = "undefined" != typeof WXEnvironment && !!WXEnvironment.platform,
        X = V && WXEnvironment.platform.toLowerCase(), J = Y && window.navigator.userAgent.toLowerCase(),
        G = J && /msie|trident/.test(J), Q = J && J.indexOf("msie 9.0") > 0, K = J && J.indexOf("edge/") > 0,
        Z = (J && J.indexOf("android"), J && /iphone|ipad|ipod|ios/.test(J) || "ios" === X),
        ee = (J && /chrome\/\d+/.test(J), J && /phantomjs/.test(J), J && J.match(/firefox\/(\d+)/)), te = {}.watch,
        ne = !1;
    if (Y) try {
        var ie = {};
        Object.defineProperty(ie, "passive", {
            get: function () {
                ne = !0
            }
        }), window.addEventListener("test-passive", null, ie)
    } catch (e) {
    }
    var oe = function () {
        return void 0 === B && (B = !Y && !V && "undefined" != typeof global && (global.process && "server" === global.process.env.VUE_ENV)), B
    }, re = Y && window.__VUE_DEVTOOLS_GLOBAL_HOOK__;

    function se(e) {
        return "function" == typeof e && /native code/.test(e.toString())
    }

    var ae, le = "undefined" != typeof Symbol && se(Symbol) && "undefined" != typeof Reflect && se(Reflect.ownKeys);
    ae = "undefined" != typeof Set && se(Set) ? Set : function () {
        function e() {
            this.set = Object.create(null)
        }

        return e.prototype.has = function (e) {
            return !0 === this.set[e]
        }, e.prototype.add = function (e) {
            this.set[e] = !0
        }, e.prototype.clear = function () {
            this.set = Object.create(null)
        }, e
    }();
    var ce = O, de = O, ue = O, pe = O, fe = "undefined" != typeof console, he = /(?:^|[-_])(\w)/g;
    ce = function (e, t) {
        var n = t ? ue(t) : "";
        F.warnHandler ? F.warnHandler.call(null, e, t, n) : fe && !F.silent && console.error("[Vue warn]: " + e + n)
    }, de = function (e, t) {
        fe && !F.silent && console.warn("[Vue tip]: " + e + (t ? ue(t) : ""))
    }, pe = function (e, t) {
        if (e.$root === e) return "<Root>";
        var n = "function" == typeof e && null != e.cid ? e.options : e._isVue ? e.$options || e.constructor.options : e,
            i = n.name || n._componentTag, o = n.__file;
        if (!i && o) {
            var r = o.match(/([^/\\]+)\.vue$/);
            i = r && r[1]
        }
        return (i ? "<" + i.replace(he, function (e) {
            return e.toUpperCase()
        }).replace(/[-_]/g, "") + ">" : "<Anonymous>") + (o && !1 !== t ? " at " + o : "")
    };
    ue = function (e) {
        if (e._isVue && e.$parent) {
            for (var t = [], n = 0; e;) {
                if (t.length > 0) {
                    var i = t[t.length - 1];
                    if (i.constructor === e.constructor) {
                        n++, e = e.$parent;
                        continue
                    }
                    n > 0 && (t[t.length - 1] = [i, n], n = 0)
                }
                t.push(e), e = e.$parent
            }
            return "\n\nfound in\n\n" + t.map(function (e, t) {
                return "" + (0 === t ? "---\x3e " : function (e, t) {
                    for (var n = ""; t;) t % 2 == 1 && (n += e), t > 1 && (e += e), t >>= 1;
                    return n
                }(" ", 5 + 2 * t)) + (Array.isArray(e) ? pe(e[0]) + "... (" + e[1] + " recursive calls)" : pe(e))
            }).join("\n")
        }
        return "\n\n(found in " + pe(e) + ")"
    };
    var me = 0, ve = function () {
        this.id = me++, this.subs = []
    };
    ve.prototype.addSub = function (e) {
        this.subs.push(e)
    }, ve.prototype.removeSub = function (e) {
        g(this.subs, e)
    }, ve.prototype.depend = function () {
        ve.target && ve.target.addDep(this)
    }, ve.prototype.notify = function () {
        var e = this.subs.slice();
        F.async || e.sort(function (e, t) {
            return e.id - t.id
        });
        for (var t = 0, n = e.length; t < n; t++) e[t].update()
    }, ve.target = null;
    var ge = [];

    function ye(e) {
        ge.push(e), ve.target = e
    }

    function be() {
        ge.pop(), ve.target = ge[ge.length - 1]
    }

    var we = function (e, t, n, i, o, r, s, a) {
        this.tag = e, this.data = t, this.children = n, this.text = i, this.elm = o, this.ns = void 0, this.context = r, this.fnContext = void 0, this.fnOptions = void 0, this.fnScopeId = void 0, this.key = t && t.key, this.componentOptions = s, this.componentInstance = void 0, this.parent = void 0, this.raw = !1, this.isStatic = !1, this.isRootInsert = !0, this.isComment = !1, this.isCloned = !1, this.isOnce = !1, this.asyncFactory = a, this.asyncMeta = void 0, this.isAsyncPlaceholder = !1
    }, xe = {child: {configurable: !0}};
    xe.child.get = function () {
        return this.componentInstance
    }, Object.defineProperties(we.prototype, xe);
    var ke = function (e) {
        void 0 === e && (e = "");
        var t = new we;
        return t.text = e, t.isComment = !0, t
    };

    function Ce(e) {
        return new we(void 0, void 0, void 0, String(e))
    }

    function Te(e) {
        var t = new we(e.tag, e.data, e.children && e.children.slice(), e.text, e.elm, e.context, e.componentOptions, e.asyncFactory);
        return t.ns = e.ns, t.isStatic = e.isStatic, t.key = e.key, t.isComment = e.isComment, t.fnContext = e.fnContext, t.fnOptions = e.fnOptions, t.fnScopeId = e.fnScopeId, t.asyncMeta = e.asyncMeta, t.isCloned = !0, t
    }

    var Se = Array.prototype, $e = Object.create(Se);
    ["push", "pop", "shift", "unshift", "splice", "sort", "reverse"].forEach(function (e) {
        var t = Se[e];
        R($e, e, function () {
            for (var n = [], i = arguments.length; i--;) n[i] = arguments[i];
            var o, r = t.apply(this, n), s = this.__ob__;
            switch (e) {
                case"push":
                case"unshift":
                    o = n;
                    break;
                case"splice":
                    o = n.slice(2)
            }
            return o && s.observeArray(o), s.dep.notify(), r
        })
    });
    var _e = Object.getOwnPropertyNames($e), Ee = !0;

    function Ae(e) {
        Ee = e
    }

    var Oe = function (e) {
        var t;
        this.value = e, this.dep = new ve, this.vmCount = 0, R(e, "__ob__", this), Array.isArray(e) ? (U ? (t = $e, e.__proto__ = t) : function (e, t, n) {
            for (var i = 0, o = n.length; i < o; i++) {
                var r = n[i];
                R(e, r, t[r])
            }
        }(e, $e, _e), this.observeArray(e)) : this.walk(e)
    };

    function je(e, t) {
        var n;
        if (r(e) && !(e instanceof we)) return b(e, "__ob__") && e.__ob__ instanceof Oe ? n = e.__ob__ : Ee && !oe() && (Array.isArray(e) || l(e)) && Object.isExtensible(e) && !e._isVue && (n = new Oe(e)), t && n && n.vmCount++, n
    }

    function Me(e, t, n, i, o) {
        var r = new ve, s = Object.getOwnPropertyDescriptor(e, t);
        if (!s || !1 !== s.configurable) {
            var a = s && s.get, l = s && s.set;
            a && !l || 2 !== arguments.length || (n = e[t]);
            var c = !o && je(n);
            Object.defineProperty(e, t, {
                enumerable: !0, configurable: !0, get: function () {
                    var t = a ? a.call(e) : n;
                    return ve.target && (r.depend(), c && (c.dep.depend(), Array.isArray(t) && function e(t) {
                        for (var n = void 0, i = 0, o = t.length; i < o; i++) (n = t[i]) && n.__ob__ && n.__ob__.dep.depend(), Array.isArray(n) && e(n)
                    }(t))), t
                }, set: function (t) {
                    var s = a ? a.call(e) : n;
                    t === s || t != t && s != s || (i && i(), a && !l || (l ? l.call(e, t) : n = t, c = !o && je(t), r.notify()))
                }
            })
        }
    }

    function Ie(e, n, i) {
        if ((t(e) || o(e)) && ce("Cannot set reactive property on undefined, null, or primitive value: " + e), Array.isArray(e) && d(n)) return e.length = Math.max(e.length, n), e.splice(n, 1, i), i;
        if (n in e && !(n in Object.prototype)) return e[n] = i, i;
        var r = e.__ob__;
        return e._isVue || r && r.vmCount ? (ce("Avoid adding reactive properties to a Vue instance or its root $data at runtime - declare it upfront in the data option."), i) : r ? (Me(r.value, n, i), r.dep.notify(), i) : (e[n] = i, i)
    }

    function De(e, n) {
        if ((t(e) || o(e)) && ce("Cannot delete reactive property on undefined, null, or primitive value: " + e), Array.isArray(e) && d(n)) e.splice(n, 1); else {
            var i = e.__ob__;
            e._isVue || i && i.vmCount ? ce("Avoid deleting properties on a Vue instance or its root $data - just set it to null.") : b(e, n) && (delete e[n], i && i.dep.notify())
        }
    }

    Oe.prototype.walk = function (e) {
        for (var t = Object.keys(e), n = 0; n < t.length; n++) Me(e, t[n])
    }, Oe.prototype.observeArray = function (e) {
        for (var t = 0, n = e.length; t < n; t++) je(e[t])
    };
    var Le = F.optionMergeStrategies;

    function Pe(e, t) {
        if (!t) return e;
        for (var n, i, o, r = le ? Reflect.ownKeys(t) : Object.keys(t), s = 0; s < r.length; s++) "__ob__" !== (n = r[s]) && (i = e[n], o = t[n], b(e, n) ? i !== o && l(i) && l(o) && Pe(i, o) : Ie(e, n, o));
        return e
    }

    function ze(e, t, n) {
        return n ? function () {
            var i = "function" == typeof t ? t.call(n, n) : t, o = "function" == typeof e ? e.call(n, n) : e;
            return i ? Pe(i, o) : o
        } : t ? e ? function () {
            return Pe("function" == typeof t ? t.call(this, this) : t, "function" == typeof e ? e.call(this, this) : e)
        } : t : e
    }

    function Ne(e, t) {
        var n = t ? e ? e.concat(t) : Array.isArray(t) ? t : [t] : e;
        return n ? function (e) {
            for (var t = [], n = 0; n < e.length; n++) -1 === t.indexOf(e[n]) && t.push(e[n]);
            return t
        }(n) : n
    }

    function Fe(e, t, n, i) {
        var o = Object.create(e || null);
        return t ? (Re(i, t, n), E(o, t)) : o
    }

    Le.el = Le.propsData = function (e, t, n, i) {
        return n || ce('option "' + i + '" can only be used during instance creation with the `new` keyword.'), He(e, t)
    }, Le.data = function (e, t, n) {
        return n ? ze(e, t, n) : t && "function" != typeof t ? (ce('The "data" option should be a function that returns a per-instance value in component definitions.', n), e) : ze(e, t)
    }, N.forEach(function (e) {
        Le[e] = Ne
    }), z.forEach(function (e) {
        Le[e + "s"] = Fe
    }), Le.watch = function (e, t, n, i) {
        if (e === te && (e = void 0), t === te && (t = void 0), !t) return Object.create(e || null);
        if (Re(i, t, n), !e) return t;
        var o = {};
        for (var r in E(o, e), t) {
            var s = o[r], a = t[r];
            s && !Array.isArray(s) && (s = [s]), o[r] = s ? s.concat(a) : Array.isArray(a) ? a : [a]
        }
        return o
    }, Le.props = Le.methods = Le.inject = Le.computed = function (e, t, n, i) {
        if (t && Re(i, t, n), !e) return t;
        var o = Object.create(null);
        return E(o, e), t && E(o, t), o
    }, Le.provide = ze;
    var He = function (e, t) {
        return void 0 === t ? e : t
    };

    function qe(e) {
        new RegExp("^[a-zA-Z][\\-\\.0-9_" + H.source + "]*$").test(e) || ce('Invalid component name: "' + e + '". Component names should conform to valid custom element name in html5 specification.'), (m(e) || F.isReservedTag(e)) && ce("Do not use built-in or reserved HTML elements as component id: " + e)
    }

    function Re(e, t, n) {
        l(t) || ce('Invalid value for option "' + e + '": expected an Object, but got ' + a(t) + ".", n)
    }

    function We(e, t, n) {
        if (function (e) {
            for (var t in e.components) qe(t)
        }(t), "function" == typeof t && (t = t.options), function (e, t) {
            var n = e.props;
            if (n) {
                var i, o, r = {};
                if (Array.isArray(n)) for (i = n.length; i--;) "string" == typeof (o = n[i]) ? r[k(o)] = {type: null} : ce("props must be strings when using array syntax."); else if (l(n)) for (var s in n) o = n[s], r[k(s)] = l(o) ? o : {type: o}; else ce('Invalid value for option "props": expected an Array or an Object, but got ' + a(n) + ".", t);
                e.props = r
            }
        }(t, n), function (e, t) {
            var n = e.inject;
            if (n) {
                var i = e.inject = {};
                if (Array.isArray(n)) for (var o = 0; o < n.length; o++) i[n[o]] = {from: n[o]}; else if (l(n)) for (var r in n) {
                    var s = n[r];
                    i[r] = l(s) ? E({from: r}, s) : {from: s}
                } else ce('Invalid value for option "inject": expected an Array or an Object, but got ' + a(n) + ".", t)
            }
        }(t, n), function (e) {
            var t = e.directives;
            if (t) for (var n in t) {
                var i = t[n];
                "function" == typeof i && (t[n] = {bind: i, update: i})
            }
        }(t), !t._base && (t.extends && (e = We(e, t.extends, n)), t.mixins)) for (var i = 0, o = t.mixins.length; i < o; i++) e = We(e, t.mixins[i], n);
        var r, s = {};
        for (r in e) c(r);
        for (r in t) b(e, r) || c(r);

        function c(i) {
            var o = Le[i] || He;
            s[i] = o(e[i], t[i], n, i)
        }

        return s
    }

    function Be(e, t, n, i) {
        if ("string" == typeof n) {
            var o = e[t];
            if (b(o, n)) return o[n];
            var r = k(n);
            if (b(o, r)) return o[r];
            var s = C(r);
            if (b(o, s)) return o[s];
            var a = o[n] || o[r] || o[s];
            return i && !a && ce("Failed to resolve " + t.slice(0, -1) + ": " + n, e), a
        }
    }

    function Ue(e, t, n, i) {
        var o = t[e], s = !b(n, e), l = n[e], c = Ge(Boolean, o.type);
        if (c > -1) if (s && !b(o, "default")) l = !1; else if ("" === l || l === S(e)) {
            var d = Ge(String, o.type);
            (d < 0 || c < d) && (l = !0)
        }
        if (void 0 === l) {
            l = function (e, t, n) {
                if (!b(t, "default")) return;
                var i = t.default;
                r(i) && ce('Invalid default value for prop "' + n + '": Props with type Object/Array must use a factory function to return the default value.', e);
                if (e && e.$options.propsData && void 0 === e.$options.propsData[n] && void 0 !== e._props[n]) return e._props[n];
                return "function" == typeof i && "Function" !== Xe(t.type) ? i.call(e) : i
            }(i, o, e);
            var u = Ee;
            Ae(!0), je(l), Ae(u)
        }
        return function (e, t, n, i, o) {
            if (e.required && o) return void ce('Missing required prop: "' + t + '"', i);
            if (null == n && !e.required) return;
            var r = e.type, s = !r || !0 === r, l = [];
            if (r) {
                Array.isArray(r) || (r = [r]);
                for (var c = 0; c < r.length && !s; c++) {
                    var d = Ve(n, r[c]);
                    l.push(d.expectedType || ""), s = d.valid
                }
            }
            if (!s) return void ce(function (e, t, n) {
                var i = 'Invalid prop: type check failed for prop "' + e + '". Expected ' + n.map(C).join(", "),
                    o = n[0], r = a(t), s = Qe(t, o), l = Qe(t, r);
                1 === n.length && Ke(o) && !function () {
                    var e = [], t = arguments.length;
                    for (; t--;) e[t] = arguments[t];
                    return e.some(function (e) {
                        return "boolean" === e.toLowerCase()
                    })
                }(o, r) && (i += " with value " + s);
                i += ", got " + r + " ", Ke(r) && (i += "with value " + l + ".");
                return i
            }(t, n, l), i);
            var u = e.validator;
            u && (u(n) || ce('Invalid prop: custom validator check failed for prop "' + t + '".', i))
        }(o, e, l, i, s), l
    }

    var Ye = /^(String|Number|Boolean|Function|Symbol)$/;

    function Ve(e, t) {
        var n, i = Xe(t);
        if (Ye.test(i)) {
            var o = typeof e;
            (n = o === i.toLowerCase()) || "object" !== o || (n = e instanceof t)
        } else n = "Object" === i ? l(e) : "Array" === i ? Array.isArray(e) : e instanceof t;
        return {valid: n, expectedType: i}
    }

    function Xe(e) {
        var t = e && e.toString().match(/^\s*function (\w+)/);
        return t ? t[1] : ""
    }

    function Je(e, t) {
        return Xe(e) === Xe(t)
    }

    function Ge(e, t) {
        if (!Array.isArray(t)) return Je(t, e) ? 0 : -1;
        for (var n = 0, i = t.length; n < i; n++) if (Je(t[n], e)) return n;
        return -1
    }

    function Qe(e, t) {
        return "String" === t ? '"' + e + '"' : "Number" === t ? "" + Number(e) : "" + e
    }

    function Ke(e) {
        return ["string", "number", "boolean"].some(function (t) {
            return e.toLowerCase() === t
        })
    }

    function Ze(e, t, n) {
        ye();
        try {
            if (t) for (var i = t; i = i.$parent;) {
                var o = i.$options.errorCaptured;
                if (o) for (var r = 0; r < o.length; r++) try {
                    if (!1 === o[r].call(i, e, t, n)) return
                } catch (e) {
                    tt(e, i, "errorCaptured hook")
                }
            }
            tt(e, t, n)
        } finally {
            be()
        }
    }

    function et(e, t, n, i, o) {
        var r;
        try {
            (r = n ? e.apply(t, n) : e.call(t)) && !r._isVue && u(r) && !r._handled && (r.catch(function (e) {
                return Ze(e, i, o + " (Promise/async)")
            }), r._handled = !0)
        } catch (e) {
            Ze(e, i, o)
        }
        return r
    }

    function tt(e, t, n) {
        if (F.errorHandler) try {
            return F.errorHandler.call(null, e, t, n)
        } catch (t) {
            t !== e && nt(t, null, "config.errorHandler")
        }
        nt(e, t, n)
    }

    function nt(e, t, n) {
        if (ce("Error in " + n + ': "' + e.toString() + '"', t), !Y && !V || "undefined" == typeof console) throw e;
        console.error(e)
    }

    var it, ot, rt, st = !1, at = [], lt = !1;

    function ct() {
        lt = !1;
        var e = at.slice(0);
        at.length = 0;
        for (var t = 0; t < e.length; t++) e[t]()
    }

    if ("undefined" != typeof Promise && se(Promise)) {
        var dt = Promise.resolve();
        it = function () {
            dt.then(ct), Z && setTimeout(O)
        }, st = !0
    } else if (G || "undefined" == typeof MutationObserver || !se(MutationObserver) && "[object MutationObserverConstructor]" !== MutationObserver.toString()) it = "undefined" != typeof setImmediate && se(setImmediate) ? function () {
        setImmediate(ct)
    } : function () {
        setTimeout(ct, 0)
    }; else {
        var ut = 1, pt = new MutationObserver(ct), ft = document.createTextNode(String(ut));
        pt.observe(ft, {characterData: !0}), it = function () {
            ut = (ut + 1) % 2, ft.data = String(ut)
        }, st = !0
    }

    function ht(e, t) {
        var n;
        if (at.push(function () {
            if (e) try {
                e.call(t)
            } catch (e) {
                Ze(e, t, "nextTick")
            } else n && n(t)
        }), lt || (lt = !0, it()), !e && "undefined" != typeof Promise) return new Promise(function (e) {
            n = e
        })
    }

    var mt, vt = Y && window.performance;
    vt && vt.mark && vt.measure && vt.clearMarks && vt.clearMeasures && (ot = function (e) {
        return vt.mark(e)
    }, rt = function (e, t, n) {
        vt.measure(e, t, n), vt.clearMarks(t), vt.clearMarks(n)
    });
    var gt = h("Infinity,undefined,NaN,isFinite,isNaN,parseFloat,parseInt,decodeURI,decodeURIComponent,encodeURI,encodeURIComponent,Math,Number,Date,Array,Object,Boolean,String,RegExp,Map,Set,JSON,Intl,require"),
        yt = function (e, t) {
            ce('Property or method "' + t + '" is not defined on the instance but referenced during render. Make sure that this property is reactive, either in the data option, or for class-based components, by initializing the property. See: https://vuejs.org/v2/guide/reactivity.html#Declaring-Reactive-Properties.', e)
        }, bt = function (e, t) {
            ce('Property "' + t + '" must be accessed with "$data.' + t + '" because properties starting with "$" or "_" are not proxied in the Vue instance to prevent conflicts with Vue internals. See: https://vuejs.org/v2/api/#data', e)
        }, wt = "undefined" != typeof Proxy && se(Proxy);
    if (wt) {
        var xt = h("stop,prevent,self,ctrl,shift,alt,meta,exact");
        F.keyCodes = new Proxy(F.keyCodes, {
            set: function (e, t, n) {
                return xt(t) ? (ce("Avoid overwriting built-in modifier in config.keyCodes: ." + t), !1) : (e[t] = n, !0)
            }
        })
    }
    var kt = {
        has: function (e, t) {
            var n = t in e, i = gt(t) || "string" == typeof t && "_" === t.charAt(0) && !(t in e.$data);
            return n || i || (t in e.$data ? bt(e, t) : yt(e, t)), n || !i
        }
    }, Ct = {
        get: function (e, t) {
            return "string" != typeof t || t in e || (t in e.$data ? bt(e, t) : yt(e, t)), e[t]
        }
    };
    mt = function (e) {
        if (wt) {
            var t = e.$options, n = t.render && t.render._withStripped ? Ct : kt;
            e._renderProxy = new Proxy(e, n)
        } else e._renderProxy = e
    };
    var Tt = new ae;

    function St(e) {
        !function e(t, n) {
            var i, o;
            var s = Array.isArray(t);
            if (!s && !r(t) || Object.isFrozen(t) || t instanceof we) return;
            if (t.__ob__) {
                var a = t.__ob__.dep.id;
                if (n.has(a)) return;
                n.add(a)
            }
            if (s) for (i = t.length; i--;) e(t[i], n); else for (o = Object.keys(t), i = o.length; i--;) e(t[o[i]], n)
        }(e, Tt), Tt.clear()
    }

    var $t = w(function (e) {
        var t = "&" === e.charAt(0), n = "~" === (e = t ? e.slice(1) : e).charAt(0),
            i = "!" === (e = n ? e.slice(1) : e).charAt(0);
        return {name: e = i ? e.slice(1) : e, once: n, capture: i, passive: t}
    });

    function _t(e, t) {
        function n() {
            var e = arguments, i = n.fns;
            if (!Array.isArray(i)) return et(i, null, arguments, t, "v-on handler");
            for (var o = i.slice(), r = 0; r < o.length; r++) et(o[r], null, e, t, "v-on handler")
        }

        return n.fns = e, n
    }

    function Et(e, n, o, r, s, a) {
        var l, c, d, u;
        for (l in e) c = e[l], d = n[l], u = $t(l), t(c) ? ce('Invalid handler for event "' + u.name + '": got ' + String(c), a) : t(d) ? (t(c.fns) && (c = e[l] = _t(c, a)), i(u.once) && (c = e[l] = s(u.name, c, u.capture)), o(u.name, c, u.capture, u.passive, u.params)) : c !== d && (d.fns = c, e[l] = d);
        for (l in n) t(e[l]) && r((u = $t(l)).name, n[l], u.capture)
    }

    function At(e, o, r) {
        var s;
        e instanceof we && (e = e.data.hook || (e.data.hook = {}));
        var a = e[o];

        function l() {
            r.apply(this, arguments), g(s.fns, l)
        }

        t(a) ? s = _t([l]) : n(a.fns) && i(a.merged) ? (s = a).fns.push(l) : s = _t([a, l]), s.merged = !0, e[o] = s
    }

    function Ot(e, t, i, o, r) {
        if (n(t)) {
            if (b(t, i)) return e[i] = t[i], r || delete t[i], !0;
            if (b(t, o)) return e[i] = t[o], r || delete t[o], !0
        }
        return !1
    }

    function jt(e) {
        return o(e) ? [Ce(e)] : Array.isArray(e) ? function e(r, s) {
            var a = [];
            var l, c, d, u;
            for (l = 0; l < r.length; l++) t(c = r[l]) || "boolean" == typeof c || (d = a.length - 1, u = a[d], Array.isArray(c) ? c.length > 0 && (Mt((c = e(c, (s || "") + "_" + l))[0]) && Mt(u) && (a[d] = Ce(u.text + c[0].text), c.shift()), a.push.apply(a, c)) : o(c) ? Mt(u) ? a[d] = Ce(u.text + c) : "" !== c && a.push(Ce(c)) : Mt(c) && Mt(u) ? a[d] = Ce(u.text + c.text) : (i(r._isVList) && n(c.tag) && t(c.key) && n(s) && (c.key = "__vlist" + s + "_" + l + "__"), a.push(c)));
            return a
        }(e) : void 0
    }

    function Mt(e) {
        return n(e) && n(e.text) && !1 === e.isComment
    }

    function It(e, t) {
        if (e) {
            for (var n = Object.create(null), i = le ? Reflect.ownKeys(e) : Object.keys(e), o = 0; o < i.length; o++) {
                var r = i[o];
                if ("__ob__" !== r) {
                    for (var s = e[r].from, a = t; a;) {
                        if (a._provided && b(a._provided, s)) {
                            n[r] = a._provided[s];
                            break
                        }
                        a = a.$parent
                    }
                    if (!a) if ("default" in e[r]) {
                        var l = e[r].default;
                        n[r] = "function" == typeof l ? l.call(t) : l
                    } else ce('Injection "' + r + '" not found', t)
                }
            }
            return n
        }
    }

    function Dt(e, t) {
        if (!e || !e.length) return {};
        for (var n = {}, i = 0, o = e.length; i < o; i++) {
            var r = e[i], s = r.data;
            if (s && s.attrs && s.attrs.slot && delete s.attrs.slot, r.context !== t && r.fnContext !== t || !s || null == s.slot) (n.default || (n.default = [])).push(r); else {
                var a = s.slot, l = n[a] || (n[a] = []);
                "template" === r.tag ? l.push.apply(l, r.children || []) : l.push(r)
            }
        }
        for (var c in n) n[c].every(Lt) && delete n[c];
        return n
    }

    function Lt(e) {
        return e.isComment && !e.asyncFactory || " " === e.text
    }

    function Pt(t, n, i) {
        var o, r = Object.keys(n).length > 0, s = t ? !!t.$stable : !r, a = t && t.$key;
        if (t) {
            if (t._normalized) return t._normalized;
            if (s && i && i !== e && a === i.$key && !r && !i.$hasNormal) return i;
            for (var l in o = {}, t) t[l] && "$" !== l[0] && (o[l] = zt(n, l, t[l]))
        } else o = {};
        for (var c in n) c in o || (o[c] = Nt(n, c));
        return t && Object.isExtensible(t) && (t._normalized = o), R(o, "$stable", s), R(o, "$key", a), R(o, "$hasNormal", r), o
    }

    function zt(e, t, n) {
        var i = function () {
            var e = arguments.length ? n.apply(null, arguments) : n({});
            return (e = e && "object" == typeof e && !Array.isArray(e) ? [e] : jt(e)) && (0 === e.length || 1 === e.length && e[0].isComment) ? void 0 : e
        };
        return n.proxy && Object.defineProperty(e, t, {get: i, enumerable: !0, configurable: !0}), i
    }

    function Nt(e, t) {
        return function () {
            return e[t]
        }
    }

    function Ft(e, t) {
        var i, o, s, a, l;
        if (Array.isArray(e) || "string" == typeof e) for (i = new Array(e.length), o = 0, s = e.length; o < s; o++) i[o] = t(e[o], o); else if ("number" == typeof e) for (i = new Array(e), o = 0; o < e; o++) i[o] = t(o + 1, o); else if (r(e)) if (le && e[Symbol.iterator]) {
            i = [];
            for (var c = e[Symbol.iterator](), d = c.next(); !d.done;) i.push(t(d.value, i.length)), d = c.next()
        } else for (a = Object.keys(e), i = new Array(a.length), o = 0, s = a.length; o < s; o++) l = a[o], i[o] = t(e[l], l, o);
        return n(i) || (i = []), i._isVList = !0, i
    }

    function Ht(e, t, n, i) {
        var o, s = this.$scopedSlots[e];
        s ? (n = n || {}, i && (r(i) || ce("slot v-bind without argument expects an Object", this), n = E(E({}, i), n)), o = s(n) || t) : o = this.$slots[e] || t;
        var a = n && n.slot;
        return a ? this.$createElement("template", {slot: a}, o) : o
    }

    function qt(e) {
        return Be(this.$options, "filters", e, !0) || M
    }

    function Rt(e, t) {
        return Array.isArray(e) ? -1 === e.indexOf(t) : e !== t
    }

    function Wt(e, t, n, i, o) {
        var r = F.keyCodes[t] || n;
        return o && i && !F.keyCodes[t] ? Rt(o, i) : r ? Rt(r, e) : i ? S(i) !== t : void 0
    }

    function Bt(e, t, n, i, o) {
        if (n) if (r(n)) {
            var s;
            Array.isArray(n) && (n = A(n));
            var a = function (r) {
                if ("class" === r || "style" === r || v(r)) s = e; else {
                    var a = e.attrs && e.attrs.type;
                    s = i || F.mustUseProp(t, a, r) ? e.domProps || (e.domProps = {}) : e.attrs || (e.attrs = {})
                }
                var l = k(r), c = S(r);
                l in s || c in s || (s[r] = n[r], o && ((e.on || (e.on = {}))["update:" + r] = function (e) {
                    n[r] = e
                }))
            };
            for (var l in n) a(l)
        } else ce("v-bind without argument expects an Object or Array value", this);
        return e
    }

    function Ut(e, t) {
        var n = this._staticTrees || (this._staticTrees = []), i = n[e];
        return i && !t ? i : (Vt(i = n[e] = this.$options.staticRenderFns[e].call(this._renderProxy, null, this), "__static__" + e, !1), i)
    }

    function Yt(e, t, n) {
        return Vt(e, "__once__" + t + (n ? "_" + n : ""), !0), e
    }

    function Vt(e, t, n) {
        if (Array.isArray(e)) for (var i = 0; i < e.length; i++) e[i] && "string" != typeof e[i] && Xt(e[i], t + "_" + i, n); else Xt(e, t, n)
    }

    function Xt(e, t, n) {
        e.isStatic = !0, e.key = t, e.isOnce = n
    }

    function Jt(e, t) {
        if (t) if (l(t)) {
            var n = e.on = e.on ? E({}, e.on) : {};
            for (var i in t) {
                var o = n[i], r = t[i];
                n[i] = o ? [].concat(o, r) : r
            }
        } else ce("v-on without argument expects an Object value", this);
        return e
    }

    function Gt(e, t, n, i) {
        t = t || {$stable: !n};
        for (var o = 0; o < e.length; o++) {
            var r = e[o];
            Array.isArray(r) ? Gt(r, t, n) : r && (r.proxy && (r.fn.proxy = !0), t[r.key] = r.fn)
        }
        return i && (t.$key = i), t
    }

    function Qt(e, t) {
        for (var n = 0; n < t.length; n += 2) {
            var i = t[n];
            "string" == typeof i && i ? e[t[n]] = t[n + 1] : "" !== i && null !== i && ce("Invalid value for dynamic directive argument (expected string or null): " + i, this)
        }
        return e
    }

    function Kt(e, t) {
        return "string" == typeof e ? t + e : e
    }

    function Zt(e) {
        e._o = Yt, e._n = f, e._s = p, e._l = Ft, e._t = Ht, e._q = I, e._i = D, e._m = Ut, e._f = qt, e._k = Wt, e._b = Bt, e._v = Ce, e._e = ke, e._u = Gt, e._g = Jt, e._d = Qt, e._p = Kt
    }

    function en(t, n, o, r, s) {
        var a, l = this, c = s.options;
        b(r, "_uid") ? (a = Object.create(r))._original = r : (a = r, r = r._original);
        var d = i(c._compiled), u = !d;
        this.data = t, this.props = n, this.children = o, this.parent = r, this.listeners = t.on || e, this.injections = It(c.inject, r), this.slots = function () {
            return l.$slots || Pt(t.scopedSlots, l.$slots = Dt(o, r)), l.$slots
        }, Object.defineProperty(this, "scopedSlots", {
            enumerable: !0, get: function () {
                return Pt(t.scopedSlots, this.slots())
            }
        }), d && (this.$options = c, this.$slots = this.slots(), this.$scopedSlots = Pt(t.scopedSlots, this.$slots)), c._scopeId ? this._c = function (e, t, n, i) {
            var o = dn(a, e, t, n, i, u);
            return o && !Array.isArray(o) && (o.fnScopeId = c._scopeId, o.fnContext = r), o
        } : this._c = function (e, t, n, i) {
            return dn(a, e, t, n, i, u)
        }
    }

    function tn(e, t, n, i, o) {
        var r = Te(e);
        return r.fnContext = n, r.fnOptions = i, (r.devtoolsMeta = r.devtoolsMeta || {}).renderContext = o, t.slot && ((r.data || (r.data = {})).slot = t.slot), r
    }

    function nn(e, t) {
        for (var n in t) e[k(n)] = t[n]
    }

    Zt(en.prototype);
    var on = {
        init: function (e, t) {
            if (e.componentInstance && !e.componentInstance._isDestroyed && e.data.keepAlive) {
                var i = e;
                on.prepatch(i, i)
            } else {
                (e.componentInstance = function (e, t) {
                    var i = {_isComponent: !0, _parentVnode: e, parent: t}, o = e.data.inlineTemplate;
                    n(o) && (i.render = o.render, i.staticRenderFns = o.staticRenderFns);
                    return new e.componentOptions.Ctor(i)
                }(e, wn)).$mount(t ? e.elm : void 0, t)
            }
        }, prepatch: function (t, n) {
            var i = n.componentOptions;
            !function (t, n, i, o, r) {
                xn = !0;
                var s = o.data.scopedSlots, a = t.$scopedSlots,
                    l = !!(s && !s.$stable || a !== e && !a.$stable || s && t.$scopedSlots.$key !== s.$key),
                    c = !!(r || t.$options._renderChildren || l);
                t.$options._parentVnode = o, t.$vnode = o, t._vnode && (t._vnode.parent = o);
                if (t.$options._renderChildren = r, t.$attrs = o.data.attrs || e, t.$listeners = i || e, n && t.$options.props) {
                    Ae(!1);
                    for (var d = t._props, u = t.$options._propKeys || [], p = 0; p < u.length; p++) {
                        var f = u[p], h = t.$options.props;
                        d[f] = Ue(f, h, n, t)
                    }
                    Ae(!0), t.$options.propsData = n
                }
                i = i || e;
                var m = t.$options._parentListeners;
                t.$options._parentListeners = i, bn(t, i, m), c && (t.$slots = Dt(r, o.context), t.$forceUpdate());
                xn = !1
            }(n.componentInstance = t.componentInstance, i.propsData, i.listeners, n, i.children)
        }, insert: function (e) {
            var t, n = e.context, i = e.componentInstance;
            i._isMounted || (i._isMounted = !0, Sn(i, "mounted")), e.data.keepAlive && (n._isMounted ? ((t = i)._inactive = !1, En.push(t)) : Tn(i, !0))
        }, destroy: function (e) {
            var t = e.componentInstance;
            t._isDestroyed || (e.data.keepAlive ? function e(t, n) {
                if (n && (t._directInactive = !0, Cn(t))) return;
                if (!t._inactive) {
                    t._inactive = !0;
                    for (var i = 0; i < t.$children.length; i++) e(t.$children[i]);
                    Sn(t, "deactivated")
                }
            }(t, !0) : t.$destroy())
        }
    }, rn = Object.keys(on);

    function sn(o, s, a, l, c) {
        if (!t(o)) {
            var d = a.$options._base;
            if (r(o) && (o = d.extend(o)), "function" == typeof o) {
                var p;
                if (t(o.cid) && void 0 === (o = function (e, o) {
                    if (i(e.error) && n(e.errorComp)) return e.errorComp;
                    if (n(e.resolved)) return e.resolved;
                    var s = pn;
                    s && n(e.owners) && -1 === e.owners.indexOf(s) && e.owners.push(s);
                    if (i(e.loading) && n(e.loadingComp)) return e.loadingComp;
                    if (s && !n(e.owners)) {
                        var a = e.owners = [s], l = !0, c = null, d = null;
                        s.$on("hook:destroyed", function () {
                            return g(a, s)
                        });
                        var p = function (e) {
                            for (var t = 0, n = a.length; t < n; t++) a[t].$forceUpdate();
                            e && (a.length = 0, null !== c && (clearTimeout(c), c = null), null !== d && (clearTimeout(d), d = null))
                        }, f = L(function (t) {
                            e.resolved = fn(t, o), l ? a.length = 0 : p(!0)
                        }), h = L(function (t) {
                            ce("Failed to resolve async component: " + String(e) + (t ? "\nReason: " + t : "")), n(e.errorComp) && (e.error = !0, p(!0))
                        }), m = e(f, h);
                        return r(m) && (u(m) ? t(e.resolved) && m.then(f, h) : u(m.component) && (m.component.then(f, h), n(m.error) && (e.errorComp = fn(m.error, o)), n(m.loading) && (e.loadingComp = fn(m.loading, o), 0 === m.delay ? e.loading = !0 : c = setTimeout(function () {
                            c = null, t(e.resolved) && t(e.error) && (e.loading = !0, p(!1))
                        }, m.delay || 200)), n(m.timeout) && (d = setTimeout(function () {
                            d = null, t(e.resolved) && h("timeout (" + m.timeout + "ms)")
                        }, m.timeout)))), l = !1, e.loading ? e.loadingComp : e.resolved
                    }
                }(p = o, d))) return function (e, t, n, i, o) {
                    var r = ke();
                    return r.asyncFactory = e, r.asyncMeta = {data: t, context: n, children: i, tag: o}, r
                }(p, s, a, l, c);
                s = s || {}, Jn(o), n(s.model) && function (e, t) {
                    var i = e.model && e.model.prop || "value", o = e.model && e.model.event || "input";
                    (t.attrs || (t.attrs = {}))[i] = t.model.value;
                    var r = t.on || (t.on = {}), s = r[o], a = t.model.callback;
                    n(s) ? (Array.isArray(s) ? -1 === s.indexOf(a) : s !== a) && (r[o] = [a].concat(s)) : r[o] = a
                }(o.options, s);
                var f = function (e, i, o) {
                    var r = i.options.props;
                    if (!t(r)) {
                        var s = {}, a = e.attrs, l = e.props;
                        if (n(a) || n(l)) for (var c in r) {
                            var d = S(c), u = c.toLowerCase();
                            c !== u && a && b(a, u) && de('Prop "' + u + '" is passed to component ' + pe(o || i) + ', but the declared prop name is "' + c + '". Note that HTML attributes are case-insensitive and camelCased props need to use their kebab-case equivalents when using in-DOM templates. You should probably use "' + d + '" instead of "' + c + '".'), Ot(s, l, c, d, !0) || Ot(s, a, c, d, !1)
                        }
                        return s
                    }
                }(s, o, c);
                if (i(o.options.functional)) return function (t, i, o, r, s) {
                    var a = t.options, l = {}, c = a.props;
                    if (n(c)) for (var d in c) l[d] = Ue(d, c, i || e); else n(o.attrs) && nn(l, o.attrs), n(o.props) && nn(l, o.props);
                    var u = new en(o, l, s, r, t), p = a.render.call(null, u._c, u);
                    if (p instanceof we) return tn(p, o, u.parent, a, u);
                    if (Array.isArray(p)) {
                        for (var f = jt(p) || [], h = new Array(f.length), m = 0; m < f.length; m++) h[m] = tn(f[m], o, u.parent, a, u);
                        return h
                    }
                }(o, f, s, a, l);
                var h = s.on;
                if (s.on = s.nativeOn, i(o.options.abstract)) {
                    var m = s.slot;
                    s = {}, m && (s.slot = m)
                }
                !function (e) {
                    for (var t = e.hook || (e.hook = {}), n = 0; n < rn.length; n++) {
                        var i = rn[n], o = t[i], r = on[i];
                        o === r || o && o._merged || (t[i] = o ? an(r, o) : r)
                    }
                }(s);
                var v = o.options.name || c;
                return new we("vue-component-" + o.cid + (v ? "-" + v : ""), s, void 0, void 0, void 0, a, {
                    Ctor: o,
                    propsData: f,
                    listeners: h,
                    tag: c,
                    children: l
                }, p)
            }
            ce("Invalid Component definition: " + String(o), a)
        }
    }

    function an(e, t) {
        var n = function (n, i) {
            e(n, i), t(n, i)
        };
        return n._merged = !0, n
    }

    var ln = 1, cn = 2;

    function dn(e, s, a, l, c, d) {
        return (Array.isArray(a) || o(a)) && (c = l, l = a, a = void 0), i(d) && (c = cn), function (e, s, a, l, c) {
            if (n(a) && n(a.__ob__)) return ce("Avoid using observed data object as vnode data: " + JSON.stringify(a) + "\nAlways create fresh vnode data objects in each render!", e), ke();
            n(a) && n(a.is) && (s = a.is);
            if (!s) return ke();
            n(a) && n(a.key) && !o(a.key) && ce("Avoid using non-primitive value as key, use string/number value instead.", e);
            Array.isArray(l) && "function" == typeof l[0] && ((a = a || {}).scopedSlots = {default: l[0]}, l.length = 0);
            c === cn ? l = jt(l) : c === ln && (l = function (e) {
                for (var t = 0; t < e.length; t++) if (Array.isArray(e[t])) return Array.prototype.concat.apply([], e);
                return e
            }(l));
            var d, u;
            if ("string" == typeof s) {
                var p;
                u = e.$vnode && e.$vnode.ns || F.getTagNamespace(s), F.isReservedTag(s) ? (n(a) && n(a.nativeOn) && ce("The .native modifier for v-on is only valid on components but it was used on <" + s + ">.", e), d = new we(F.parsePlatformTagName(s), a, l, void 0, void 0, e)) : d = a && a.pre || !n(p = Be(e.$options, "components", s)) ? new we(s, a, l, void 0, void 0, e) : sn(p, a, e, l, s)
            } else d = sn(s, a, e, l);
            return Array.isArray(d) ? d : n(d) ? (n(u) && function e(o, r, s) {
                o.ns = r;
                "foreignObject" === o.tag && (r = void 0, s = !0);
                if (n(o.children)) for (var a = 0, l = o.children.length; a < l; a++) {
                    var c = o.children[a];
                    n(c.tag) && (t(c.ns) || i(s) && "svg" !== c.tag) && e(c, r, s)
                }
            }(d, u), n(a) && function (e) {
                r(e.style) && St(e.style);
                r(e.class) && St(e.class)
            }(a), d) : ke()
        }(e, s, a, l, c)
    }

    var un, pn = null;

    function fn(e, t) {
        return (e.__esModule || le && "Module" === e[Symbol.toStringTag]) && (e = e.default), r(e) ? t.extend(e) : e
    }

    function hn(e) {
        return e.isComment && e.asyncFactory
    }

    function mn(e) {
        if (Array.isArray(e)) for (var t = 0; t < e.length; t++) {
            var i = e[t];
            if (n(i) && (n(i.componentOptions) || hn(i))) return i
        }
    }

    function vn(e, t) {
        un.$on(e, t)
    }

    function gn(e, t) {
        un.$off(e, t)
    }

    function yn(e, t) {
        var n = un;
        return function i() {
            null !== t.apply(null, arguments) && n.$off(e, i)
        }
    }

    function bn(e, t, n) {
        un = e, Et(t, n || {}, vn, gn, yn, e), un = void 0
    }

    var wn = null, xn = !1;

    function kn(e) {
        var t = wn;
        return wn = e, function () {
            wn = t
        }
    }

    function Cn(e) {
        for (; e && (e = e.$parent);) if (e._inactive) return !0;
        return !1
    }

    function Tn(e, t) {
        if (t) {
            if (e._directInactive = !1, Cn(e)) return
        } else if (e._directInactive) return;
        if (e._inactive || null === e._inactive) {
            e._inactive = !1;
            for (var n = 0; n < e.$children.length; n++) Tn(e.$children[n]);
            Sn(e, "activated")
        }
    }

    function Sn(e, t) {
        ye();
        var n = e.$options[t], i = t + " hook";
        if (n) for (var o = 0, r = n.length; o < r; o++) et(n[o], e, null, e, i);
        e._hasHookEvent && e.$emit("hook:" + t), be()
    }

    var $n = 100, _n = [], En = [], An = {}, On = {}, jn = !1, Mn = !1, In = 0;
    var Dn = 0, Ln = Date.now;
    if (Y && !G) {
        var Pn = window.performance;
        Pn && "function" == typeof Pn.now && Ln() > document.createEvent("Event").timeStamp && (Ln = function () {
            return Pn.now()
        })
    }

    function zn() {
        var e, t;
        for (Dn = Ln(), Mn = !0, _n.sort(function (e, t) {
            return e.id - t.id
        }), In = 0; In < _n.length; In++) if ((e = _n[In]).before && e.before(), t = e.id, An[t] = null, e.run(), null != An[t] && (On[t] = (On[t] || 0) + 1, On[t] > $n)) {
            ce("You may have an infinite update loop " + (e.user ? 'in watcher with expression "' + e.expression + '"' : "in a component render function."), e.vm);
            break
        }
        var n = En.slice(), i = _n.slice();
        In = _n.length = En.length = 0, An = {}, On = {}, jn = Mn = !1, function (e) {
            for (var t = 0; t < e.length; t++) e[t]._inactive = !0, Tn(e[t], !0)
        }(n), function (e) {
            var t = e.length;
            for (; t--;) {
                var n = e[t], i = n.vm;
                i._watcher === n && i._isMounted && !i._isDestroyed && Sn(i, "updated")
            }
        }(i), re && F.devtools && re.emit("flush")
    }

    var Nn = 0, Fn = function (e, t, n, i, o) {
        this.vm = e, o && (e._watcher = this), e._watchers.push(this), i ? (this.deep = !!i.deep, this.user = !!i.user, this.lazy = !!i.lazy, this.sync = !!i.sync, this.before = i.before) : this.deep = this.user = this.lazy = this.sync = !1, this.cb = n, this.id = ++Nn, this.active = !0, this.dirty = this.lazy, this.deps = [], this.newDeps = [], this.depIds = new ae, this.newDepIds = new ae, this.expression = t.toString(), "function" == typeof t ? this.getter = t : (this.getter = function (e) {
            if (!W.test(e)) {
                var t = e.split(".");
                return function (e) {
                    for (var n = 0; n < t.length; n++) {
                        if (!e) return;
                        e = e[t[n]]
                    }
                    return e
                }
            }
        }(t), this.getter || (this.getter = O, ce('Failed watching path: "' + t + '" Watcher only accepts simple dot-delimited paths. For full control, use a function instead.', e))), this.value = this.lazy ? void 0 : this.get()
    };
    Fn.prototype.get = function () {
        var e;
        ye(this);
        var t = this.vm;
        try {
            e = this.getter.call(t, t)
        } catch (e) {
            if (!this.user) throw e;
            Ze(e, t, 'getter for watcher "' + this.expression + '"')
        } finally {
            this.deep && St(e), be(), this.cleanupDeps()
        }
        return e
    }, Fn.prototype.addDep = function (e) {
        var t = e.id;
        this.newDepIds.has(t) || (this.newDepIds.add(t), this.newDeps.push(e), this.depIds.has(t) || e.addSub(this))
    }, Fn.prototype.cleanupDeps = function () {
        for (var e = this.deps.length; e--;) {
            var t = this.deps[e];
            this.newDepIds.has(t.id) || t.removeSub(this)
        }
        var n = this.depIds;
        this.depIds = this.newDepIds, this.newDepIds = n, this.newDepIds.clear(), n = this.deps, this.deps = this.newDeps, this.newDeps = n, this.newDeps.length = 0
    }, Fn.prototype.update = function () {
        this.lazy ? this.dirty = !0 : this.sync ? this.run() : function (e) {
            var t = e.id;
            if (null == An[t]) {
                if (An[t] = !0, Mn) {
                    for (var n = _n.length - 1; n > In && _n[n].id > e.id;) n--;
                    _n.splice(n + 1, 0, e)
                } else _n.push(e);
                if (!jn) {
                    if (jn = !0, !F.async) return void zn();
                    ht(zn)
                }
            }
        }(this)
    }, Fn.prototype.run = function () {
        if (this.active) {
            var e = this.get();
            if (e !== this.value || r(e) || this.deep) {
                var t = this.value;
                if (this.value = e, this.user) try {
                    this.cb.call(this.vm, e, t)
                } catch (e) {
                    Ze(e, this.vm, 'callback for watcher "' + this.expression + '"')
                } else this.cb.call(this.vm, e, t)
            }
        }
    }, Fn.prototype.evaluate = function () {
        this.value = this.get(), this.dirty = !1
    }, Fn.prototype.depend = function () {
        for (var e = this.deps.length; e--;) this.deps[e].depend()
    }, Fn.prototype.teardown = function () {
        if (this.active) {
            this.vm._isBeingDestroyed || g(this.vm._watchers, this);
            for (var e = this.deps.length; e--;) this.deps[e].removeSub(this);
            this.active = !1
        }
    };
    var Hn = {enumerable: !0, configurable: !0, get: O, set: O};

    function qn(e, t, n) {
        Hn.get = function () {
            return this[t][n]
        }, Hn.set = function (e) {
            this[t][n] = e
        }, Object.defineProperty(e, n, Hn)
    }

    function Rn(e) {
        e._watchers = [];
        var t = e.$options;
        t.props && function (e, t) {
            var n = e.$options.propsData || {}, i = e._props = {}, o = e.$options._propKeys = [], r = !e.$parent;
            r || Ae(!1);
            var s = function (s) {
                o.push(s);
                var a = Ue(s, t, n, e), l = S(s);
                (v(l) || F.isReservedAttr(l)) && ce('"' + l + '" is a reserved attribute and cannot be used as component prop.', e), Me(i, s, a, function () {
                    r || xn || ce("Avoid mutating a prop directly since the value will be overwritten whenever the parent component re-renders. Instead, use a data or computed property based on the prop's value. Prop being mutated: \"" + s + '"', e)
                }), s in e || qn(e, "_props", s)
            };
            for (var a in t) s(a);
            Ae(!0)
        }(e, t.props), t.methods && function (e, t) {
            var n = e.$options.props;
            for (var i in t) "function" != typeof t[i] && ce('Method "' + i + '" has type "' + typeof t[i] + '" in the component definition. Did you reference the function correctly?', e), n && b(n, i) && ce('Method "' + i + '" has already been defined as a prop.', e), i in e && q(i) && ce('Method "' + i + '" conflicts with an existing Vue instance method. Avoid defining component methods that start with _ or $.'), e[i] = "function" != typeof t[i] ? O : $(t[i], e)
        }(e, t.methods), t.data ? function (e) {
            var t = e.$options.data;
            l(t = e._data = "function" == typeof t ? function (e, t) {
                ye();
                try {
                    return e.call(t, t)
                } catch (e) {
                    return Ze(e, t, "data()"), {}
                } finally {
                    be()
                }
            }(t, e) : t || {}) || (t = {}, ce("data functions should return an object:\nhttps://vuejs.org/v2/guide/components.html#data-Must-Be-a-Function", e));
            var n = Object.keys(t), i = e.$options.props, o = e.$options.methods, r = n.length;
            for (; r--;) {
                var s = n[r];
                o && b(o, s) && ce('Method "' + s + '" has already been defined as a data property.', e), i && b(i, s) ? ce('The data property "' + s + '" is already declared as a prop. Use prop default value instead.', e) : q(s) || qn(e, "_data", s)
            }
            je(t, !0)
        }(e) : je(e._data = {}, !0), t.computed && function (e, t) {
            var n = e._computedWatchers = Object.create(null), i = oe();
            for (var o in t) {
                var r = t[o], s = "function" == typeof r ? r : r.get;
                null == s && ce('Getter is missing for computed property "' + o + '".', e), i || (n[o] = new Fn(e, s || O, O, Wn)), o in e ? o in e.$data ? ce('The computed property "' + o + '" is already defined in data.', e) : e.$options.props && o in e.$options.props && ce('The computed property "' + o + '" is already defined as a prop.', e) : Bn(e, o, r)
            }
        }(e, t.computed), t.watch && t.watch !== te && function (e, t) {
            for (var n in t) {
                var i = t[n];
                if (Array.isArray(i)) for (var o = 0; o < i.length; o++) Vn(e, n, i[o]); else Vn(e, n, i)
            }
        }(e, t.watch)
    }

    var Wn = {lazy: !0};

    function Bn(e, t, n) {
        var i = !oe();
        "function" == typeof n ? (Hn.get = i ? Un(t) : Yn(n), Hn.set = O) : (Hn.get = n.get ? i && !1 !== n.cache ? Un(t) : Yn(n.get) : O, Hn.set = n.set || O), Hn.set === O && (Hn.set = function () {
            ce('Computed property "' + t + '" was assigned to but it has no setter.', this)
        }), Object.defineProperty(e, t, Hn)
    }

    function Un(e) {
        return function () {
            var t = this._computedWatchers && this._computedWatchers[e];
            if (t) return t.dirty && t.evaluate(), ve.target && t.depend(), t.value
        }
    }

    function Yn(e) {
        return function () {
            return e.call(this, this)
        }
    }

    function Vn(e, t, n, i) {
        return l(n) && (i = n, n = n.handler), "string" == typeof n && (n = e[n]), e.$watch(t, n, i)
    }

    var Xn = 0;

    function Jn(e) {
        var t = e.options;
        if (e.super) {
            var n = Jn(e.super);
            if (n !== e.superOptions) {
                e.superOptions = n;
                var i = function (e) {
                    var t, n = e.options, i = e.sealedOptions;
                    for (var o in n) n[o] !== i[o] && (t || (t = {}), t[o] = n[o]);
                    return t
                }(e);
                i && E(e.extendOptions, i), (t = e.options = We(n, e.extendOptions)).name && (t.components[t.name] = e)
            }
        }
        return t
    }

    function Gn(e) {
        this instanceof Gn || ce("Vue is a constructor and should be called with the `new` keyword"), this._init(e)
    }

    function Qn(e) {
        e.cid = 0;
        var t = 1;
        e.extend = function (e) {
            e = e || {};
            var n = this, i = n.cid, o = e._Ctor || (e._Ctor = {});
            if (o[i]) return o[i];
            var r = e.name || n.options.name;
            r && qe(r);
            var s = function (e) {
                this._init(e)
            };
            return (s.prototype = Object.create(n.prototype)).constructor = s, s.cid = t++, s.options = We(n.options, e), s.super = n, s.options.props && function (e) {
                var t = e.options.props;
                for (var n in t) qn(e.prototype, "_props", n)
            }(s), s.options.computed && function (e) {
                var t = e.options.computed;
                for (var n in t) Bn(e.prototype, n, t[n])
            }(s), s.extend = n.extend, s.mixin = n.mixin, s.use = n.use, z.forEach(function (e) {
                s[e] = n[e]
            }), r && (s.options.components[r] = s), s.superOptions = n.options, s.extendOptions = e, s.sealedOptions = E({}, s.options), o[i] = s, s
        }
    }

    function Kn(e) {
        return e && (e.Ctor.options.name || e.tag)
    }

    function Zn(e, t) {
        return Array.isArray(e) ? e.indexOf(t) > -1 : "string" == typeof e ? e.split(",").indexOf(t) > -1 : !!c(e) && e.test(t)
    }

    function ei(e, t) {
        var n = e.cache, i = e.keys, o = e._vnode;
        for (var r in n) {
            var s = n[r];
            if (s) {
                var a = Kn(s.componentOptions);
                a && !t(a) && ti(n, r, i, o)
            }
        }
    }

    function ti(e, t, n, i) {
        var o = e[t];
        !o || i && o.tag === i.tag || o.componentInstance.$destroy(), e[t] = null, g(n, t)
    }

    !function (t) {
        t.prototype._init = function (t) {
            var n, i, o = this;
            o._uid = Xn++, F.performance && ot && (n = "vue-perf-start:" + o._uid, i = "vue-perf-end:" + o._uid, ot(n)), o._isVue = !0, t && t._isComponent ? function (e, t) {
                var n = e.$options = Object.create(e.constructor.options), i = t._parentVnode;
                n.parent = t.parent, n._parentVnode = i;
                var o = i.componentOptions;
                n.propsData = o.propsData, n._parentListeners = o.listeners, n._renderChildren = o.children, n._componentTag = o.tag, t.render && (n.render = t.render, n.staticRenderFns = t.staticRenderFns)
            }(o, t) : o.$options = We(Jn(o.constructor), t || {}, o), mt(o), o._self = o, function (e) {
                var t = e.$options, n = t.parent;
                if (n && !t.abstract) {
                    for (; n.$options.abstract && n.$parent;) n = n.$parent;
                    n.$children.push(e)
                }
                e.$parent = n, e.$root = n ? n.$root : e, e.$children = [], e.$refs = {}, e._watcher = null, e._inactive = null, e._directInactive = !1, e._isMounted = !1, e._isDestroyed = !1, e._isBeingDestroyed = !1
            }(o), function (e) {
                e._events = Object.create(null), e._hasHookEvent = !1;
                var t = e.$options._parentListeners;
                t && bn(e, t)
            }(o), function (t) {
                t._vnode = null, t._staticTrees = null;
                var n = t.$options, i = t.$vnode = n._parentVnode, o = i && i.context;
                t.$slots = Dt(n._renderChildren, o), t.$scopedSlots = e, t._c = function (e, n, i, o) {
                    return dn(t, e, n, i, o, !1)
                }, t.$createElement = function (e, n, i, o) {
                    return dn(t, e, n, i, o, !0)
                };
                var r = i && i.data;
                Me(t, "$attrs", r && r.attrs || e, function () {
                    !xn && ce("$attrs is readonly.", t)
                }, !0), Me(t, "$listeners", n._parentListeners || e, function () {
                    !xn && ce("$listeners is readonly.", t)
                }, !0)
            }(o), Sn(o, "beforeCreate"), function (e) {
                var t = It(e.$options.inject, e);
                t && (Ae(!1), Object.keys(t).forEach(function (n) {
                    Me(e, n, t[n], function () {
                        ce('Avoid mutating an injected value directly since the changes will be overwritten whenever the provided component re-renders. injection being mutated: "' + n + '"', e)
                    })
                }), Ae(!0))
            }(o), Rn(o), function (e) {
                var t = e.$options.provide;
                t && (e._provided = "function" == typeof t ? t.call(e) : t)
            }(o), Sn(o, "created"), F.performance && ot && (o._name = pe(o, !1), ot(i), rt("vue " + o._name + " init", n, i)), o.$options.el && o.$mount(o.$options.el)
        }
    }(Gn), function (e) {
        var t = {
            get: function () {
                return this._data
            }
        }, n = {
            get: function () {
                return this._props
            }
        };
        t.set = function () {
            ce("Avoid replacing instance root $data. Use nested data properties instead.", this)
        }, n.set = function () {
            ce("$props is readonly.", this)
        }, Object.defineProperty(e.prototype, "$data", t), Object.defineProperty(e.prototype, "$props", n), e.prototype.$set = Ie, e.prototype.$delete = De, e.prototype.$watch = function (e, t, n) {
            if (l(t)) return Vn(this, e, t, n);
            (n = n || {}).user = !0;
            var i = new Fn(this, e, t, n);
            if (n.immediate) try {
                t.call(this, i.value)
            } catch (e) {
                Ze(e, this, 'callback for immediate watcher "' + i.expression + '"')
            }
            return function () {
                i.teardown()
            }
        }
    }(Gn), function (e) {
        var t = /^hook:/;
        e.prototype.$on = function (e, n) {
            var i = this;
            if (Array.isArray(e)) for (var o = 0, r = e.length; o < r; o++) i.$on(e[o], n); else (i._events[e] || (i._events[e] = [])).push(n), t.test(e) && (i._hasHookEvent = !0);
            return i
        }, e.prototype.$once = function (e, t) {
            var n = this;

            function i() {
                n.$off(e, i), t.apply(n, arguments)
            }

            return i.fn = t, n.$on(e, i), n
        }, e.prototype.$off = function (e, t) {
            var n = this;
            if (!arguments.length) return n._events = Object.create(null), n;
            if (Array.isArray(e)) {
                for (var i = 0, o = e.length; i < o; i++) n.$off(e[i], t);
                return n
            }
            var r, s = n._events[e];
            if (!s) return n;
            if (!t) return n._events[e] = null, n;
            for (var a = s.length; a--;) if ((r = s[a]) === t || r.fn === t) {
                s.splice(a, 1);
                break
            }
            return n
        }, e.prototype.$emit = function (e) {
            var t = this, n = e.toLowerCase();
            n !== e && t._events[n] && de('Event "' + n + '" is emitted in component ' + pe(t) + ' but the handler is registered for "' + e + '". Note that HTML attributes are case-insensitive and you cannot use v-on to listen to camelCase events when using in-DOM templates. You should probably use "' + S(e) + '" instead of "' + e + '".');
            var i = t._events[e];
            if (i) {
                i = i.length > 1 ? _(i) : i;
                for (var o = _(arguments, 1), r = 'event handler for "' + e + '"', s = 0, a = i.length; s < a; s++) et(i[s], t, o, t, r)
            }
            return t
        }
    }(Gn), function (e) {
        e.prototype._update = function (e, t) {
            var n = this, i = n.$el, o = n._vnode, r = kn(n);
            n._vnode = e, n.$el = o ? n.__patch__(o, e) : n.__patch__(n.$el, e, t, !1), r(), i && (i.__vue__ = null), n.$el && (n.$el.__vue__ = n), n.$vnode && n.$parent && n.$vnode === n.$parent._vnode && (n.$parent.$el = n.$el)
        }, e.prototype.$forceUpdate = function () {
            this._watcher && this._watcher.update()
        }, e.prototype.$destroy = function () {
            var e = this;
            if (!e._isBeingDestroyed) {
                Sn(e, "beforeDestroy"), e._isBeingDestroyed = !0;
                var t = e.$parent;
                !t || t._isBeingDestroyed || e.$options.abstract || g(t.$children, e), e._watcher && e._watcher.teardown();
                for (var n = e._watchers.length; n--;) e._watchers[n].teardown();
                e._data.__ob__ && e._data.__ob__.vmCount--, e._isDestroyed = !0, e.__patch__(e._vnode, null), Sn(e, "destroyed"), e.$off(), e.$el && (e.$el.__vue__ = null), e.$vnode && (e.$vnode.parent = null)
            }
        }
    }(Gn), function (e) {
        Zt(e.prototype), e.prototype.$nextTick = function (e) {
            return ht(e, this)
        }, e.prototype._render = function () {
            var e, t = this, n = t.$options, i = n.render, o = n._parentVnode;
            o && (t.$scopedSlots = Pt(o.data.scopedSlots, t.$slots, t.$scopedSlots)), t.$vnode = o;
            try {
                pn = t, e = i.call(t._renderProxy, t.$createElement)
            } catch (n) {
                if (Ze(n, t, "render"), t.$options.renderError) try {
                    e = t.$options.renderError.call(t._renderProxy, t.$createElement, n)
                } catch (n) {
                    Ze(n, t, "renderError"), e = t._vnode
                } else e = t._vnode
            } finally {
                pn = null
            }
            return Array.isArray(e) && 1 === e.length && (e = e[0]), e instanceof we || (Array.isArray(e) && ce("Multiple root nodes returned from render function. Render function should return a single root node.", t), e = ke()), e.parent = o, e
        }
    }(Gn);
    var ni = [String, RegExp, Array], ii = {
        KeepAlive: {
            name: "keep-alive",
            abstract: !0,
            props: {include: ni, exclude: ni, max: [String, Number]},
            created: function () {
                this.cache = Object.create(null), this.keys = []
            },
            destroyed: function () {
                for (var e in this.cache) ti(this.cache, e, this.keys)
            },
            mounted: function () {
                var e = this;
                this.$watch("include", function (t) {
                    ei(e, function (e) {
                        return Zn(t, e)
                    })
                }), this.$watch("exclude", function (t) {
                    ei(e, function (e) {
                        return !Zn(t, e)
                    })
                })
            },
            render: function () {
                var e = this.$slots.default, t = mn(e), n = t && t.componentOptions;
                if (n) {
                    var i = Kn(n), o = this.include, r = this.exclude;
                    if (o && (!i || !Zn(o, i)) || r && i && Zn(r, i)) return t;
                    var s = this.cache, a = this.keys,
                        l = null == t.key ? n.Ctor.cid + (n.tag ? "::" + n.tag : "") : t.key;
                    s[l] ? (t.componentInstance = s[l].componentInstance, g(a, l), a.push(l)) : (s[l] = t, a.push(l), this.max && a.length > parseInt(this.max) && ti(s, a[0], a, this._vnode)), t.data.keepAlive = !0
                }
                return t || e && e[0]
            }
        }
    };
    !function (e) {
        var t = {
            get: function () {
                return F
            }, set: function () {
                ce("Do not replace the Vue.config object, set individual fields instead.")
            }
        };
        Object.defineProperty(e, "config", t), e.util = {
            warn: ce,
            extend: E,
            mergeOptions: We,
            defineReactive: Me
        }, e.set = Ie, e.delete = De, e.nextTick = ht, e.observable = function (e) {
            return je(e), e
        }, e.options = Object.create(null), z.forEach(function (t) {
            e.options[t + "s"] = Object.create(null)
        }), e.options._base = e, E(e.options.components, ii), function (e) {
            e.use = function (e) {
                var t = this._installedPlugins || (this._installedPlugins = []);
                if (t.indexOf(e) > -1) return this;
                var n = _(arguments, 1);
                return n.unshift(this), "function" == typeof e.install ? e.install.apply(e, n) : "function" == typeof e && e.apply(null, n), t.push(e), this
            }
        }(e), function (e) {
            e.mixin = function (e) {
                return this.options = We(this.options, e), this
            }
        }(e), Qn(e), function (e) {
            z.forEach(function (t) {
                e[t] = function (e, n) {
                    return n ? ("component" === t && qe(e), "component" === t && l(n) && (n.name = n.name || e, n = this.options._base.extend(n)), "directive" === t && "function" == typeof n && (n = {
                        bind: n,
                        update: n
                    }), this.options[t + "s"][e] = n, n) : this.options[t + "s"][e]
                }
            })
        }(e)
    }(Gn), Object.defineProperty(Gn.prototype, "$isServer", {get: oe}), Object.defineProperty(Gn.prototype, "$ssrContext", {
        get: function () {
            return this.$vnode && this.$vnode.ssrContext
        }
    }), Object.defineProperty(Gn, "FunctionalRenderContext", {value: en}), Gn.version = "2.6.11";
    var oi = h("style,class"), ri = h("input,textarea,option,select,progress"), si = function (e, t, n) {
            return "value" === n && ri(e) && "button" !== t || "selected" === n && "option" === e || "checked" === n && "input" === e || "muted" === n && "video" === e
        }, ai = h("contenteditable,draggable,spellcheck"), li = h("events,caret,typing,plaintext-only"),
        ci = function (e, t) {
            return hi(t) || "false" === t ? "false" : "contenteditable" === e && li(t) ? t : "true"
        },
        di = h("allowfullscreen,async,autofocus,autoplay,checked,compact,controls,declare,default,defaultchecked,defaultmuted,defaultselected,defer,disabled,enabled,formnovalidate,hidden,indeterminate,inert,ismap,itemscope,loop,multiple,muted,nohref,noresize,noshade,novalidate,nowrap,open,pauseonexit,readonly,required,reversed,scoped,seamless,selected,sortable,translate,truespeed,typemustmatch,visible"),
        ui = "http://www.w3.org/1999/xlink", pi = function (e) {
            return ":" === e.charAt(5) && "xlink" === e.slice(0, 5)
        }, fi = function (e) {
            return pi(e) ? e.slice(6, e.length) : ""
        }, hi = function (e) {
            return null == e || !1 === e
        };

    function mi(e) {
        for (var t = e.data, i = e, o = e; n(o.componentInstance);) (o = o.componentInstance._vnode) && o.data && (t = vi(o.data, t));
        for (; n(i = i.parent);) i && i.data && (t = vi(t, i.data));
        return function (e, t) {
            if (n(e) || n(t)) return gi(e, yi(t));
            return ""
        }(t.staticClass, t.class)
    }

    function vi(e, t) {
        return {staticClass: gi(e.staticClass, t.staticClass), class: n(e.class) ? [e.class, t.class] : t.class}
    }

    function gi(e, t) {
        return e ? t ? e + " " + t : e : t || ""
    }

    function yi(e) {
        return Array.isArray(e) ? function (e) {
            for (var t, i = "", o = 0, r = e.length; o < r; o++) n(t = yi(e[o])) && "" !== t && (i && (i += " "), i += t);
            return i
        }(e) : r(e) ? function (e) {
            var t = "";
            for (var n in e) e[n] && (t && (t += " "), t += n);
            return t
        }(e) : "string" == typeof e ? e : ""
    }

    var bi = {svg: "http://www.w3.org/2000/svg", math: "http://www.w3.org/1998/Math/MathML"},
        wi = h("html,body,base,head,link,meta,style,title,address,article,aside,footer,header,h1,h2,h3,h4,h5,h6,hgroup,nav,section,div,dd,dl,dt,figcaption,figure,picture,hr,img,li,main,ol,p,pre,ul,a,b,abbr,bdi,bdo,br,cite,code,data,dfn,em,i,kbd,mark,q,rp,rt,rtc,ruby,s,samp,small,span,strong,sub,sup,time,u,var,wbr,area,audio,map,track,video,embed,object,param,source,canvas,script,noscript,del,ins,caption,col,colgroup,table,thead,tbody,td,th,tr,button,datalist,fieldset,form,input,label,legend,meter,optgroup,option,output,progress,select,textarea,details,dialog,menu,menuitem,summary,content,element,shadow,template,blockquote,iframe,tfoot"),
        xi = h("svg,animate,circle,clippath,cursor,defs,desc,ellipse,filter,font-face,foreignObject,g,glyph,image,line,marker,mask,missing-glyph,path,pattern,polygon,polyline,rect,switch,symbol,text,textpath,tspan,use,view", !0),
        ki = function (e) {
            return wi(e) || xi(e)
        };

    function Ci(e) {
        return xi(e) ? "svg" : "math" === e ? "math" : void 0
    }

    var Ti = Object.create(null);
    var Si = h("text,number,password,search,email,tel,url");

    function $i(e) {
        if ("string" == typeof e) {
            var t = document.querySelector(e);
            return t || (ce("Cannot find element: " + e), document.createElement("div"))
        }
        return e
    }

    var _i = Object.freeze({
        createElement: function (e, t) {
            var n = document.createElement(e);
            return "select" !== e ? n : (t.data && t.data.attrs && void 0 !== t.data.attrs.multiple && n.setAttribute("multiple", "multiple"), n)
        }, createElementNS: function (e, t) {
            return document.createElementNS(bi[e], t)
        }, createTextNode: function (e) {
            return document.createTextNode(e)
        }, createComment: function (e) {
            return document.createComment(e)
        }, insertBefore: function (e, t, n) {
            e.insertBefore(t, n)
        }, removeChild: function (e, t) {
            e.removeChild(t)
        }, appendChild: function (e, t) {
            e.appendChild(t)
        }, parentNode: function (e) {
            return e.parentNode
        }, nextSibling: function (e) {
            return e.nextSibling
        }, tagName: function (e) {
            return e.tagName
        }, setTextContent: function (e, t) {
            e.textContent = t
        }, setStyleScope: function (e, t) {
            e.setAttribute(t, "")
        }
    }), Ei = {
        create: function (e, t) {
            Ai(t)
        }, update: function (e, t) {
            e.data.ref !== t.data.ref && (Ai(e, !0), Ai(t))
        }, destroy: function (e) {
            Ai(e, !0)
        }
    };

    function Ai(e, t) {
        var i = e.data.ref;
        if (n(i)) {
            var o = e.context, r = e.componentInstance || e.elm, s = o.$refs;
            t ? Array.isArray(s[i]) ? g(s[i], r) : s[i] === r && (s[i] = void 0) : e.data.refInFor ? Array.isArray(s[i]) ? s[i].indexOf(r) < 0 && s[i].push(r) : s[i] = [r] : s[i] = r
        }
    }

    var Oi = new we("", {}, []), ji = ["create", "activate", "update", "remove", "destroy"];

    function Mi(e, o) {
        return e.key === o.key && (e.tag === o.tag && e.isComment === o.isComment && n(e.data) === n(o.data) && function (e, t) {
            if ("input" !== e.tag) return !0;
            var i, o = n(i = e.data) && n(i = i.attrs) && i.type, r = n(i = t.data) && n(i = i.attrs) && i.type;
            return o === r || Si(o) && Si(r)
        }(e, o) || i(e.isAsyncPlaceholder) && e.asyncFactory === o.asyncFactory && t(o.asyncFactory.error))
    }

    function Ii(e, t, i) {
        var o, r, s = {};
        for (o = t; o <= i; ++o) n(r = e[o].key) && (s[r] = o);
        return s
    }

    var Di = {
        create: Li, update: Li, destroy: function (e) {
            Li(e, Oi)
        }
    };

    function Li(e, t) {
        (e.data.directives || t.data.directives) && function (e, t) {
            var n, i, o, r = e === Oi, s = t === Oi, a = zi(e.data.directives, e.context),
                l = zi(t.data.directives, t.context), c = [], d = [];
            for (n in l) i = a[n], o = l[n], i ? (o.oldValue = i.value, o.oldArg = i.arg, Fi(o, "update", t, e), o.def && o.def.componentUpdated && d.push(o)) : (Fi(o, "bind", t, e), o.def && o.def.inserted && c.push(o));
            if (c.length) {
                var u = function () {
                    for (var n = 0; n < c.length; n++) Fi(c[n], "inserted", t, e)
                };
                r ? At(t, "insert", u) : u()
            }
            d.length && At(t, "postpatch", function () {
                for (var n = 0; n < d.length; n++) Fi(d[n], "componentUpdated", t, e)
            });
            if (!r) for (n in a) l[n] || Fi(a[n], "unbind", e, e, s)
        }(e, t)
    }

    var Pi = Object.create(null);

    function zi(e, t) {
        var n, i, o = Object.create(null);
        if (!e) return o;
        for (n = 0; n < e.length; n++) (i = e[n]).modifiers || (i.modifiers = Pi), o[Ni(i)] = i, i.def = Be(t.$options, "directives", i.name, !0);
        return o
    }

    function Ni(e) {
        return e.rawName || e.name + "." + Object.keys(e.modifiers || {}).join(".")
    }

    function Fi(e, t, n, i, o) {
        var r = e.def && e.def[t];
        if (r) try {
            r(n.elm, e, n, i, o)
        } catch (i) {
            Ze(i, n.context, "directive " + e.name + " " + t + " hook")
        }
    }

    var Hi = [Ei, Di];

    function qi(e, i) {
        var o = i.componentOptions;
        if (!(n(o) && !1 === o.Ctor.options.inheritAttrs || t(e.data.attrs) && t(i.data.attrs))) {
            var r, s, a = i.elm, l = e.data.attrs || {}, c = i.data.attrs || {};
            for (r in n(c.__ob__) && (c = i.data.attrs = E({}, c)), c) s = c[r], l[r] !== s && Ri(a, r, s);
            for (r in (G || K) && c.value !== l.value && Ri(a, "value", c.value), l) t(c[r]) && (pi(r) ? a.removeAttributeNS(ui, fi(r)) : ai(r) || a.removeAttribute(r))
        }
    }

    function Ri(e, t, n) {
        e.tagName.indexOf("-") > -1 ? Wi(e, t, n) : di(t) ? hi(n) ? e.removeAttribute(t) : (n = "allowfullscreen" === t && "EMBED" === e.tagName ? "true" : t, e.setAttribute(t, n)) : ai(t) ? e.setAttribute(t, ci(t, n)) : pi(t) ? hi(n) ? e.removeAttributeNS(ui, fi(t)) : e.setAttributeNS(ui, t, n) : Wi(e, t, n)
    }

    function Wi(e, t, n) {
        if (hi(n)) e.removeAttribute(t); else {
            if (G && !Q && "TEXTAREA" === e.tagName && "placeholder" === t && "" !== n && !e.__ieph) {
                var i = function (t) {
                    t.stopImmediatePropagation(), e.removeEventListener("input", i)
                };
                e.addEventListener("input", i), e.__ieph = !0
            }
            e.setAttribute(t, n)
        }
    }

    var Bi = {create: qi, update: qi};

    function Ui(e, i) {
        var o = i.elm, r = i.data, s = e.data;
        if (!(t(r.staticClass) && t(r.class) && (t(s) || t(s.staticClass) && t(s.class)))) {
            var a = mi(i), l = o._transitionClasses;
            n(l) && (a = gi(a, yi(l))), a !== o._prevClass && (o.setAttribute("class", a), o._prevClass = a)
        }
    }

    var Yi, Vi, Xi, Ji, Gi, Qi, Ki, Zi = {create: Ui, update: Ui}, eo = /[\w).+\-_$\]]/;

    function to(e) {
        var t, n, i, o, r, s = !1, a = !1, l = !1, c = !1, d = 0, u = 0, p = 0, f = 0;
        for (i = 0; i < e.length; i++) if (n = t, t = e.charCodeAt(i), s) 39 === t && 92 !== n && (s = !1); else if (a) 34 === t && 92 !== n && (a = !1); else if (l) 96 === t && 92 !== n && (l = !1); else if (c) 47 === t && 92 !== n && (c = !1); else if (124 !== t || 124 === e.charCodeAt(i + 1) || 124 === e.charCodeAt(i - 1) || d || u || p) {
            switch (t) {
                case 34:
                    a = !0;
                    break;
                case 39:
                    s = !0;
                    break;
                case 96:
                    l = !0;
                    break;
                case 40:
                    p++;
                    break;
                case 41:
                    p--;
                    break;
                case 91:
                    u++;
                    break;
                case 93:
                    u--;
                    break;
                case 123:
                    d++;
                    break;
                case 125:
                    d--
            }
            if (47 === t) {
                for (var h = i - 1, m = void 0; h >= 0 && " " === (m = e.charAt(h)); h--) ;
                m && eo.test(m) || (c = !0)
            }
        } else void 0 === o ? (f = i + 1, o = e.slice(0, i).trim()) : v();

        function v() {
            (r || (r = [])).push(e.slice(f, i).trim()), f = i + 1
        }

        if (void 0 === o ? o = e.slice(0, i).trim() : 0 !== f && v(), r) for (i = 0; i < r.length; i++) o = no(o, r[i]);
        return o
    }

    function no(e, t) {
        var n = t.indexOf("(");
        if (n < 0) return '_f("' + t + '")(' + e + ")";
        var i = t.slice(0, n), o = t.slice(n + 1);
        return '_f("' + i + '")(' + e + (")" !== o ? "," + o : o)
    }

    function io(e, t) {
        console.error("[Vue compiler]: " + e)
    }

    function oo(e, t) {
        return e ? e.map(function (e) {
            return e[t]
        }).filter(function (e) {
            return e
        }) : []
    }

    function ro(e, t, n, i, o) {
        (e.props || (e.props = [])).push(vo({name: t, value: n, dynamic: o}, i)), e.plain = !1
    }

    function so(e, t, n, i, o) {
        (o ? e.dynamicAttrs || (e.dynamicAttrs = []) : e.attrs || (e.attrs = [])).push(vo({
            name: t,
            value: n,
            dynamic: o
        }, i)), e.plain = !1
    }

    function ao(e, t, n, i) {
        e.attrsMap[t] = n, e.attrsList.push(vo({name: t, value: n}, i))
    }

    function lo(e, t, n, i, o, r, s, a) {
        (e.directives || (e.directives = [])).push(vo({
            name: t,
            rawName: n,
            value: i,
            arg: o,
            isDynamicArg: r,
            modifiers: s
        }, a)), e.plain = !1
    }

    function co(e, t, n) {
        return n ? "_p(" + t + ',"' + e + '")' : e + t
    }

    function uo(t, n, i, o, r, s, a, l) {
        var c;
        o = o || e, s && o.prevent && o.passive && s("passive and prevent can't be used together. Passive handler can't prevent default event.", a), o.right ? l ? n = "(" + n + ")==='click'?'contextmenu':(" + n + ")" : "click" === n && (n = "contextmenu", delete o.right) : o.middle && (l ? n = "(" + n + ")==='click'?'mouseup':(" + n + ")" : "click" === n && (n = "mouseup")), o.capture && (delete o.capture, n = co("!", n, l)), o.once && (delete o.once, n = co("~", n, l)), o.passive && (delete o.passive, n = co("&", n, l)), o.native ? (delete o.native, c = t.nativeEvents || (t.nativeEvents = {})) : c = t.events || (t.events = {});
        var d = vo({value: i.trim(), dynamic: l}, a);
        o !== e && (d.modifiers = o);
        var u = c[n];
        Array.isArray(u) ? r ? u.unshift(d) : u.push(d) : c[n] = u ? r ? [d, u] : [u, d] : d, t.plain = !1
    }

    function po(e, t) {
        return e.rawAttrsMap[":" + t] || e.rawAttrsMap["v-bind:" + t] || e.rawAttrsMap[t]
    }

    function fo(e, t, n) {
        var i = ho(e, ":" + t) || ho(e, "v-bind:" + t);
        if (null != i) return to(i);
        if (!1 !== n) {
            var o = ho(e, t);
            if (null != o) return JSON.stringify(o)
        }
    }

    function ho(e, t, n) {
        var i;
        if (null != (i = e.attrsMap[t])) for (var o = e.attrsList, r = 0, s = o.length; r < s; r++) if (o[r].name === t) {
            o.splice(r, 1);
            break
        }
        return n && delete e.attrsMap[t], i
    }

    function mo(e, t) {
        for (var n = e.attrsList, i = 0, o = n.length; i < o; i++) {
            var r = n[i];
            if (t.test(r.name)) return n.splice(i, 1), r
        }
    }

    function vo(e, t) {
        return t && (null != t.start && (e.start = t.start), null != t.end && (e.end = t.end)), e
    }

    function go(e, t, n) {
        var i = n || {}, o = i.number, r = "$$v";
        i.trim && (r = "(typeof $$v === 'string'? $$v.trim(): $$v)"), o && (r = "_n(" + r + ")");
        var s = yo(t, r);
        e.model = {value: "(" + t + ")", expression: JSON.stringify(t), callback: "function ($$v) {" + s + "}"}
    }

    function yo(e, t) {
        var n = function (e) {
            if (e = e.trim(), Yi = e.length, e.indexOf("[") < 0 || e.lastIndexOf("]") < Yi - 1) return (Ji = e.lastIndexOf(".")) > -1 ? {
                exp: e.slice(0, Ji),
                key: '"' + e.slice(Ji + 1) + '"'
            } : {exp: e, key: null};
            Vi = e, Ji = Gi = Qi = 0;
            for (; !wo();) xo(Xi = bo()) ? Co(Xi) : 91 === Xi && ko(Xi);
            return {exp: e.slice(0, Gi), key: e.slice(Gi + 1, Qi)}
        }(e);
        return null === n.key ? e + "=" + t : "$set(" + n.exp + ", " + n.key + ", " + t + ")"
    }

    function bo() {
        return Vi.charCodeAt(++Ji)
    }

    function wo() {
        return Ji >= Yi
    }

    function xo(e) {
        return 34 === e || 39 === e
    }

    function ko(e) {
        var t = 1;
        for (Gi = Ji; !wo();) if (xo(e = bo())) Co(e); else if (91 === e && t++, 93 === e && t--, 0 === t) {
            Qi = Ji;
            break
        }
    }

    function Co(e) {
        for (var t = e; !wo() && (e = bo()) !== t;) ;
    }

    var To, So = "__r", $o = "__c";

    function _o(e, t, n) {
        var i = To;
        return function o() {
            null !== t.apply(null, arguments) && Oo(e, o, n, i)
        }
    }

    var Eo = st && !(ee && Number(ee[1]) <= 53);

    function Ao(e, t, n, i) {
        if (Eo) {
            var o = Dn, r = t;
            t = r._wrapper = function (e) {
                if (e.target === e.currentTarget || e.timeStamp >= o || e.timeStamp <= 0 || e.target.ownerDocument !== document) return r.apply(this, arguments)
            }
        }
        To.addEventListener(e, t, ne ? {capture: n, passive: i} : n)
    }

    function Oo(e, t, n, i) {
        (i || To).removeEventListener(e, t._wrapper || t, n)
    }

    function jo(e, i) {
        if (!t(e.data.on) || !t(i.data.on)) {
            var o = i.data.on || {}, r = e.data.on || {};
            To = i.elm, function (e) {
                if (n(e[So])) {
                    var t = G ? "change" : "input";
                    e[t] = [].concat(e[So], e[t] || []), delete e[So]
                }
                n(e[$o]) && (e.change = [].concat(e[$o], e.change || []), delete e[$o])
            }(o), Et(o, r, Ao, Oo, _o, i.context), To = void 0
        }
    }

    var Mo, Io = {create: jo, update: jo};

    function Do(e, i) {
        if (!t(e.data.domProps) || !t(i.data.domProps)) {
            var o, r, s = i.elm, a = e.data.domProps || {}, l = i.data.domProps || {};
            for (o in n(l.__ob__) && (l = i.data.domProps = E({}, l)), a) o in l || (s[o] = "");
            for (o in l) {
                if (r = l[o], "textContent" === o || "innerHTML" === o) {
                    if (i.children && (i.children.length = 0), r === a[o]) continue;
                    1 === s.childNodes.length && s.removeChild(s.childNodes[0])
                }
                if ("value" === o && "PROGRESS" !== s.tagName) {
                    s._value = r;
                    var c = t(r) ? "" : String(r);
                    Lo(s, c) && (s.value = c)
                } else if ("innerHTML" === o && xi(s.tagName) && t(s.innerHTML)) {
                    (Mo = Mo || document.createElement("div")).innerHTML = "<svg>" + r + "</svg>";
                    for (var d = Mo.firstChild; s.firstChild;) s.removeChild(s.firstChild);
                    for (; d.firstChild;) s.appendChild(d.firstChild)
                } else if (r !== a[o]) try {
                    s[o] = r
                } catch (e) {
                }
            }
        }
    }

    function Lo(e, t) {
        return !e.composing && ("OPTION" === e.tagName || function (e, t) {
            var n = !0;
            try {
                n = document.activeElement !== e
            } catch (e) {
            }
            return n && e.value !== t
        }(e, t) || function (e, t) {
            var i = e.value, o = e._vModifiers;
            if (n(o)) {
                if (o.number) return f(i) !== f(t);
                if (o.trim) return i.trim() !== t.trim()
            }
            return i !== t
        }(e, t))
    }

    var Po = {create: Do, update: Do}, zo = w(function (e) {
        var t = {}, n = /:(.+)/;
        return e.split(/;(?![^(]*\))/g).forEach(function (e) {
            if (e) {
                var i = e.split(n);
                i.length > 1 && (t[i[0].trim()] = i[1].trim())
            }
        }), t
    });

    function No(e) {
        var t = Fo(e.style);
        return e.staticStyle ? E(e.staticStyle, t) : t
    }

    function Fo(e) {
        return Array.isArray(e) ? A(e) : "string" == typeof e ? zo(e) : e
    }

    var Ho, qo = /^--/, Ro = /\s*!important$/, Wo = function (e, t, n) {
        if (qo.test(t)) e.style.setProperty(t, n); else if (Ro.test(n)) e.style.setProperty(S(t), n.replace(Ro, ""), "important"); else {
            var i = Uo(t);
            if (Array.isArray(n)) for (var o = 0, r = n.length; o < r; o++) e.style[i] = n[o]; else e.style[i] = n
        }
    }, Bo = ["Webkit", "Moz", "ms"], Uo = w(function (e) {
        if (Ho = Ho || document.createElement("div").style, "filter" !== (e = k(e)) && e in Ho) return e;
        for (var t = e.charAt(0).toUpperCase() + e.slice(1), n = 0; n < Bo.length; n++) {
            var i = Bo[n] + t;
            if (i in Ho) return i
        }
    });

    function Yo(e, i) {
        var o = i.data, r = e.data;
        if (!(t(o.staticStyle) && t(o.style) && t(r.staticStyle) && t(r.style))) {
            var s, a, l = i.elm, c = r.staticStyle, d = r.normalizedStyle || r.style || {}, u = c || d,
                p = Fo(i.data.style) || {};
            i.data.normalizedStyle = n(p.__ob__) ? E({}, p) : p;
            var f = function (e, t) {
                var n, i = {};
                if (t) for (var o = e; o.componentInstance;) (o = o.componentInstance._vnode) && o.data && (n = No(o.data)) && E(i, n);
                (n = No(e.data)) && E(i, n);
                for (var r = e; r = r.parent;) r.data && (n = No(r.data)) && E(i, n);
                return i
            }(i, !0);
            for (a in u) t(f[a]) && Wo(l, a, "");
            for (a in f) (s = f[a]) !== u[a] && Wo(l, a, null == s ? "" : s)
        }
    }

    var Vo = {create: Yo, update: Yo}, Xo = /\s+/;

    function Jo(e, t) {
        if (t && (t = t.trim())) if (e.classList) t.indexOf(" ") > -1 ? t.split(Xo).forEach(function (t) {
            return e.classList.add(t)
        }) : e.classList.add(t); else {
            var n = " " + (e.getAttribute("class") || "") + " ";
            n.indexOf(" " + t + " ") < 0 && e.setAttribute("class", (n + t).trim())
        }
    }

    function Go(e, t) {
        if (t && (t = t.trim())) if (e.classList) t.indexOf(" ") > -1 ? t.split(Xo).forEach(function (t) {
            return e.classList.remove(t)
        }) : e.classList.remove(t), e.classList.length || e.removeAttribute("class"); else {
            for (var n = " " + (e.getAttribute("class") || "") + " ", i = " " + t + " "; n.indexOf(i) >= 0;) n = n.replace(i, " ");
            (n = n.trim()) ? e.setAttribute("class", n) : e.removeAttribute("class")
        }
    }

    function Qo(e) {
        if (e) {
            if ("object" == typeof e) {
                var t = {};
                return !1 !== e.css && E(t, Ko(e.name || "v")), E(t, e), t
            }
            return "string" == typeof e ? Ko(e) : void 0
        }
    }

    var Ko = w(function (e) {
            return {
                enterClass: e + "-enter",
                enterToClass: e + "-enter-to",
                enterActiveClass: e + "-enter-active",
                leaveClass: e + "-leave",
                leaveToClass: e + "-leave-to",
                leaveActiveClass: e + "-leave-active"
            }
        }), Zo = Y && !Q, er = "transition", tr = "animation", nr = "transition", ir = "transitionend", or = "animation",
        rr = "animationend";
    Zo && (void 0 === window.ontransitionend && void 0 !== window.onwebkittransitionend && (nr = "WebkitTransition", ir = "webkitTransitionEnd"), void 0 === window.onanimationend && void 0 !== window.onwebkitanimationend && (or = "WebkitAnimation", rr = "webkitAnimationEnd"));
    var sr = Y ? window.requestAnimationFrame ? window.requestAnimationFrame.bind(window) : setTimeout : function (e) {
        return e()
    };

    function ar(e) {
        sr(function () {
            sr(e)
        })
    }

    function lr(e, t) {
        var n = e._transitionClasses || (e._transitionClasses = []);
        n.indexOf(t) < 0 && (n.push(t), Jo(e, t))
    }

    function cr(e, t) {
        e._transitionClasses && g(e._transitionClasses, t), Go(e, t)
    }

    function dr(e, t, n) {
        var i = pr(e, t), o = i.type, r = i.timeout, s = i.propCount;
        if (!o) return n();
        var a = o === er ? ir : rr, l = 0, c = function () {
            e.removeEventListener(a, d), n()
        }, d = function (t) {
            t.target === e && ++l >= s && c()
        };
        setTimeout(function () {
            l < s && c()
        }, r + 1), e.addEventListener(a, d)
    }

    var ur = /\b(transform|all)(,|$)/;

    function pr(e, t) {
        var n, i = window.getComputedStyle(e), o = (i[nr + "Delay"] || "").split(", "),
            r = (i[nr + "Duration"] || "").split(", "), s = fr(o, r), a = (i[or + "Delay"] || "").split(", "),
            l = (i[or + "Duration"] || "").split(", "), c = fr(a, l), d = 0, u = 0;
        return t === er ? s > 0 && (n = er, d = s, u = r.length) : t === tr ? c > 0 && (n = tr, d = c, u = l.length) : u = (n = (d = Math.max(s, c)) > 0 ? s > c ? er : tr : null) ? n === er ? r.length : l.length : 0, {
            type: n,
            timeout: d,
            propCount: u,
            hasTransform: n === er && ur.test(i[nr + "Property"])
        }
    }

    function fr(e, t) {
        for (; e.length < t.length;) e = e.concat(e);
        return Math.max.apply(null, t.map(function (t, n) {
            return hr(t) + hr(e[n])
        }))
    }

    function hr(e) {
        return 1e3 * Number(e.slice(0, -1).replace(",", "."))
    }

    function mr(e, i) {
        var o = e.elm;
        n(o._leaveCb) && (o._leaveCb.cancelled = !0, o._leaveCb());
        var s = Qo(e.data.transition);
        if (!t(s) && !n(o._enterCb) && 1 === o.nodeType) {
            for (var a = s.css, l = s.type, c = s.enterClass, d = s.enterToClass, u = s.enterActiveClass, p = s.appearClass, h = s.appearToClass, m = s.appearActiveClass, v = s.beforeEnter, g = s.enter, y = s.afterEnter, b = s.enterCancelled, w = s.beforeAppear, x = s.appear, k = s.afterAppear, C = s.appearCancelled, T = s.duration, S = wn, $ = wn.$vnode; $ && $.parent;) S = $.context, $ = $.parent;
            var _ = !S._isMounted || !e.isRootInsert;
            if (!_ || x || "" === x) {
                var E = _ && p ? p : c, A = _ && m ? m : u, O = _ && h ? h : d, j = _ && w || v,
                    M = _ && "function" == typeof x ? x : g, I = _ && k || y, D = _ && C || b,
                    P = f(r(T) ? T.enter : T);
                null != P && gr(P, "enter", e);
                var z = !1 !== a && !Q, N = br(M), F = o._enterCb = L(function () {
                    z && (cr(o, O), cr(o, A)), F.cancelled ? (z && cr(o, E), D && D(o)) : I && I(o), o._enterCb = null
                });
                e.data.show || At(e, "insert", function () {
                    var t = o.parentNode, n = t && t._pending && t._pending[e.key];
                    n && n.tag === e.tag && n.elm._leaveCb && n.elm._leaveCb(), M && M(o, F)
                }), j && j(o), z && (lr(o, E), lr(o, A), ar(function () {
                    cr(o, E), F.cancelled || (lr(o, O), N || (yr(P) ? setTimeout(F, P) : dr(o, l, F)))
                })), e.data.show && (i && i(), M && M(o, F)), z || N || F()
            }
        }
    }

    function vr(e, i) {
        var o = e.elm;
        n(o._enterCb) && (o._enterCb.cancelled = !0, o._enterCb());
        var s = Qo(e.data.transition);
        if (t(s) || 1 !== o.nodeType) return i();
        if (!n(o._leaveCb)) {
            var a = s.css, l = s.type, c = s.leaveClass, d = s.leaveToClass, u = s.leaveActiveClass, p = s.beforeLeave,
                h = s.leave, m = s.afterLeave, v = s.leaveCancelled, g = s.delayLeave, y = s.duration,
                b = !1 !== a && !Q, w = br(h), x = f(r(y) ? y.leave : y);
            n(x) && gr(x, "leave", e);
            var k = o._leaveCb = L(function () {
                o.parentNode && o.parentNode._pending && (o.parentNode._pending[e.key] = null), b && (cr(o, d), cr(o, u)), k.cancelled ? (b && cr(o, c), v && v(o)) : (i(), m && m(o)), o._leaveCb = null
            });
            g ? g(C) : C()
        }

        function C() {
            k.cancelled || (!e.data.show && o.parentNode && ((o.parentNode._pending || (o.parentNode._pending = {}))[e.key] = e), p && p(o), b && (lr(o, c), lr(o, u), ar(function () {
                cr(o, c), k.cancelled || (lr(o, d), w || (yr(x) ? setTimeout(k, x) : dr(o, l, k)))
            })), h && h(o, k), b || w || k())
        }
    }

    function gr(e, t, n) {
        "number" != typeof e ? ce("<transition> explicit " + t + " duration is not a valid number - got " + JSON.stringify(e) + ".", n.context) : isNaN(e) && ce("<transition> explicit " + t + " duration is NaN - the duration expression might be incorrect.", n.context)
    }

    function yr(e) {
        return "number" == typeof e && !isNaN(e)
    }

    function br(e) {
        if (t(e)) return !1;
        var i = e.fns;
        return n(i) ? br(Array.isArray(i) ? i[0] : i) : (e._length || e.length) > 1
    }

    function wr(e, t) {
        !0 !== t.data.show && mr(t)
    }

    var xr = function (e) {
        var r, s, a = {}, l = e.modules, d = e.nodeOps;
        for (r = 0; r < ji.length; ++r) for (a[ji[r]] = [], s = 0; s < l.length; ++s) n(l[s][ji[r]]) && a[ji[r]].push(l[s][ji[r]]);

        function u(e) {
            var t = d.parentNode(e);
            n(t) && d.removeChild(t, e)
        }

        function p(e, t) {
            return !t && !e.ns && !(F.ignoredElements.length && F.ignoredElements.some(function (t) {
                return c(t) ? t.test(e.tag) : t === e.tag
            })) && F.isUnknownElement(e.tag)
        }

        var f = 0;

        function m(e, t, o, r, s, l, c) {
            if (n(e.elm) && n(l) && (e = l[c] = Te(e)), e.isRootInsert = !s, !function (e, t, o, r) {
                var s = e.data;
                if (n(s)) {
                    var l = n(e.componentInstance) && s.keepAlive;
                    if (n(s = s.hook) && n(s = s.init) && s(e, !1), n(e.componentInstance)) return v(e, t), g(o, e.elm, r), i(l) && function (e, t, i, o) {
                        for (var r, s = e; s.componentInstance;) if (s = s.componentInstance._vnode, n(r = s.data) && n(r = r.transition)) {
                            for (r = 0; r < a.activate.length; ++r) a.activate[r](Oi, s);
                            t.push(s);
                            break
                        }
                        g(i, e.elm, o)
                    }(e, t, o, r), !0
                }
            }(e, t, o, r)) {
                var u = e.data, h = e.children, m = e.tag;
                n(m) ? (u && u.pre && f++, p(e, f) && ce("Unknown custom element: <" + m + '> - did you register the component correctly? For recursive components, make sure to provide the "name" option.', e.context), e.elm = e.ns ? d.createElementNS(e.ns, m) : d.createElement(m, e), x(e), y(e, h, t), n(u) && w(e, t), g(o, e.elm, r), u && u.pre && f--) : i(e.isComment) ? (e.elm = d.createComment(e.text), g(o, e.elm, r)) : (e.elm = d.createTextNode(e.text), g(o, e.elm, r))
            }
        }

        function v(e, t) {
            n(e.data.pendingInsert) && (t.push.apply(t, e.data.pendingInsert), e.data.pendingInsert = null), e.elm = e.componentInstance.$el, b(e) ? (w(e, t), x(e)) : (Ai(e), t.push(e))
        }

        function g(e, t, i) {
            n(e) && (n(i) ? d.parentNode(i) === e && d.insertBefore(e, t, i) : d.appendChild(e, t))
        }

        function y(e, t, n) {
            if (Array.isArray(t)) {
                $(t);
                for (var i = 0; i < t.length; ++i) m(t[i], n, e.elm, null, !0, t, i)
            } else o(e.text) && d.appendChild(e.elm, d.createTextNode(String(e.text)))
        }

        function b(e) {
            for (; e.componentInstance;) e = e.componentInstance._vnode;
            return n(e.tag)
        }

        function w(e, t) {
            for (var i = 0; i < a.create.length; ++i) a.create[i](Oi, e);
            n(r = e.data.hook) && (n(r.create) && r.create(Oi, e), n(r.insert) && t.push(e))
        }

        function x(e) {
            var t;
            if (n(t = e.fnScopeId)) d.setStyleScope(e.elm, t); else for (var i = e; i;) n(t = i.context) && n(t = t.$options._scopeId) && d.setStyleScope(e.elm, t), i = i.parent;
            n(t = wn) && t !== e.context && t !== e.fnContext && n(t = t.$options._scopeId) && d.setStyleScope(e.elm, t)
        }

        function k(e, t, n, i, o, r) {
            for (; i <= o; ++i) m(n[i], r, e, t, !1, n, i)
        }

        function C(e) {
            var t, i, o = e.data;
            if (n(o)) for (n(t = o.hook) && n(t = t.destroy) && t(e), t = 0; t < a.destroy.length; ++t) a.destroy[t](e);
            if (n(t = e.children)) for (i = 0; i < e.children.length; ++i) C(e.children[i])
        }

        function T(e, t, i) {
            for (; t <= i; ++t) {
                var o = e[t];
                n(o) && (n(o.tag) ? (S(o), C(o)) : u(o.elm))
            }
        }

        function S(e, t) {
            if (n(t) || n(e.data)) {
                var i, o = a.remove.length + 1;
                for (n(t) ? t.listeners += o : t = function (e, t) {
                    function n() {
                        0 == --n.listeners && u(e)
                    }

                    return n.listeners = t, n
                }(e.elm, o), n(i = e.componentInstance) && n(i = i._vnode) && n(i.data) && S(i, t), i = 0; i < a.remove.length; ++i) a.remove[i](e, t);
                n(i = e.data.hook) && n(i = i.remove) ? i(e, t) : t()
            } else u(e.elm)
        }

        function $(e) {
            for (var t = {}, i = 0; i < e.length; i++) {
                var o = e[i], r = o.key;
                n(r) && (t[r] ? ce("Duplicate keys detected: '" + r + "'. This may cause an update error.", o.context) : t[r] = !0)
            }
        }

        function _(e, t, i, o) {
            for (var r = i; r < o; r++) {
                var s = t[r];
                if (n(s) && Mi(e, s)) return r
            }
        }

        function E(e, o, r, s, l, c) {
            if (e !== o) {
                n(o.elm) && n(s) && (o = s[l] = Te(o));
                var u = o.elm = e.elm;
                if (i(e.isAsyncPlaceholder)) n(o.asyncFactory.resolved) ? M(e.elm, o, r) : o.isAsyncPlaceholder = !0; else if (i(o.isStatic) && i(e.isStatic) && o.key === e.key && (i(o.isCloned) || i(o.isOnce))) o.componentInstance = e.componentInstance; else {
                    var p, f = o.data;
                    n(f) && n(p = f.hook) && n(p = p.prepatch) && p(e, o);
                    var h = e.children, v = o.children;
                    if (n(f) && b(o)) {
                        for (p = 0; p < a.update.length; ++p) a.update[p](e, o);
                        n(p = f.hook) && n(p = p.update) && p(e, o)
                    }
                    t(o.text) ? n(h) && n(v) ? h !== v && function (e, i, o, r, s) {
                        var a, l, c, u = 0, p = 0, f = i.length - 1, h = i[0], v = i[f], g = o.length - 1, y = o[0],
                            b = o[g], w = !s;
                        for ($(o); u <= f && p <= g;) t(h) ? h = i[++u] : t(v) ? v = i[--f] : Mi(h, y) ? (E(h, y, r, o, p), h = i[++u], y = o[++p]) : Mi(v, b) ? (E(v, b, r, o, g), v = i[--f], b = o[--g]) : Mi(h, b) ? (E(h, b, r, o, g), w && d.insertBefore(e, h.elm, d.nextSibling(v.elm)), h = i[++u], b = o[--g]) : Mi(v, y) ? (E(v, y, r, o, p), w && d.insertBefore(e, v.elm, h.elm), v = i[--f], y = o[++p]) : (t(a) && (a = Ii(i, u, f)), t(l = n(y.key) ? a[y.key] : _(y, i, u, f)) ? m(y, r, e, h.elm, !1, o, p) : Mi(c = i[l], y) ? (E(c, y, r, o, p), i[l] = void 0, w && d.insertBefore(e, c.elm, h.elm)) : m(y, r, e, h.elm, !1, o, p), y = o[++p]);
                        u > f ? k(e, t(o[g + 1]) ? null : o[g + 1].elm, o, p, g, r) : p > g && T(i, u, f)
                    }(u, h, v, r, c) : n(v) ? ($(v), n(e.text) && d.setTextContent(u, ""), k(u, null, v, 0, v.length - 1, r)) : n(h) ? T(h, 0, h.length - 1) : n(e.text) && d.setTextContent(u, "") : e.text !== o.text && d.setTextContent(u, o.text), n(f) && n(p = f.hook) && n(p = p.postpatch) && p(e, o)
                }
            }
        }

        function A(e, t, o) {
            if (i(o) && n(e.parent)) e.parent.data.pendingInsert = t; else for (var r = 0; r < t.length; ++r) t[r].data.hook.insert(t[r])
        }

        var O = !1, j = h("attrs,class,staticClass,staticStyle,key");

        function M(e, t, o, r) {
            var s, a = t.tag, l = t.data, c = t.children;
            if (r = r || l && l.pre, t.elm = e, i(t.isComment) && n(t.asyncFactory)) return t.isAsyncPlaceholder = !0, !0;
            if (!function (e, t, i) {
                return n(t.tag) ? 0 === t.tag.indexOf("vue-component") || !p(t, i) && t.tag.toLowerCase() === (e.tagName && e.tagName.toLowerCase()) : e.nodeType === (t.isComment ? 8 : 3)
            }(e, t, r)) return !1;
            if (n(l) && (n(s = l.hook) && n(s = s.init) && s(t, !0), n(s = t.componentInstance))) return v(t, o), !0;
            if (n(a)) {
                if (n(c)) if (e.hasChildNodes()) if (n(s = l) && n(s = s.domProps) && n(s = s.innerHTML)) {
                    if (s !== e.innerHTML) return "undefined" == typeof console || O || (O = !0, console.warn("Parent: ", e), console.warn("server innerHTML: ", s), console.warn("client innerHTML: ", e.innerHTML)), !1
                } else {
                    for (var d = !0, u = e.firstChild, f = 0; f < c.length; f++) {
                        if (!u || !M(u, c[f], o, r)) {
                            d = !1;
                            break
                        }
                        u = u.nextSibling
                    }
                    if (!d || u) return "undefined" == typeof console || O || (O = !0, console.warn("Parent: ", e), console.warn("Mismatching childNodes vs. VNodes: ", e.childNodes, c)), !1
                } else y(t, c, o);
                if (n(l)) {
                    var h = !1;
                    for (var m in l) if (!j(m)) {
                        h = !0, w(t, o);
                        break
                    }
                    !h && l.class && St(l.class)
                }
            } else e.data !== t.text && (e.data = t.text);
            return !0
        }

        return function (e, o, r, s) {
            if (!t(o)) {
                var l, c = !1, u = [];
                if (t(e)) c = !0, m(o, u); else {
                    var p = n(e.nodeType);
                    if (!p && Mi(e, o)) E(e, o, u, null, null, s); else {
                        if (p) {
                            if (1 === e.nodeType && e.hasAttribute(P) && (e.removeAttribute(P), r = !0), i(r)) {
                                if (M(e, o, u)) return A(o, u, !0), e;
                                ce("The client-side rendered virtual DOM tree is not matching server-rendered content. This is likely caused by incorrect HTML markup, for example nesting block-level elements inside <p>, or missing <tbody>. Bailing hydration and performing full client-side render.")
                            }
                            l = e, e = new we(d.tagName(l).toLowerCase(), {}, [], void 0, l)
                        }
                        var f = e.elm, h = d.parentNode(f);
                        if (m(o, u, f._leaveCb ? null : h, d.nextSibling(f)), n(o.parent)) for (var v = o.parent, g = b(o); v;) {
                            for (var y = 0; y < a.destroy.length; ++y) a.destroy[y](v);
                            if (v.elm = o.elm, g) {
                                for (var w = 0; w < a.create.length; ++w) a.create[w](Oi, v);
                                var x = v.data.hook.insert;
                                if (x.merged) for (var k = 1; k < x.fns.length; k++) x.fns[k]()
                            } else Ai(v);
                            v = v.parent
                        }
                        n(h) ? T([e], 0, 0) : n(e.tag) && C(e)
                    }
                }
                return A(o, u, c), o.elm
            }
            n(e) && C(e)
        }
    }({
        nodeOps: _i, modules: [Bi, Zi, Io, Po, Vo, Y ? {
            create: wr, activate: wr, remove: function (e, t) {
                !0 !== e.data.show ? vr(e, t) : t()
            }
        } : {}].concat(Hi)
    });
    Q && document.addEventListener("selectionchange", function () {
        var e = document.activeElement;
        e && e.vmodel && Ar(e, "input")
    });
    var kr = {
        inserted: function (e, t, n, i) {
            "select" === n.tag ? (i.elm && !i.elm._vOptions ? At(n, "postpatch", function () {
                kr.componentUpdated(e, t, n)
            }) : Cr(e, t, n.context), e._vOptions = [].map.call(e.options, $r)) : ("textarea" === n.tag || Si(e.type)) && (e._vModifiers = t.modifiers, t.modifiers.lazy || (e.addEventListener("compositionstart", _r), e.addEventListener("compositionend", Er), e.addEventListener("change", Er), Q && (e.vmodel = !0)))
        }, componentUpdated: function (e, t, n) {
            if ("select" === n.tag) {
                Cr(e, t, n.context);
                var i = e._vOptions, o = e._vOptions = [].map.call(e.options, $r);
                if (o.some(function (e, t) {
                    return !I(e, i[t])
                })) (e.multiple ? t.value.some(function (e) {
                    return Sr(e, o)
                }) : t.value !== t.oldValue && Sr(t.value, o)) && Ar(e, "change")
            }
        }
    };

    function Cr(e, t, n) {
        Tr(e, t, n), (G || K) && setTimeout(function () {
            Tr(e, t, n)
        }, 0)
    }

    function Tr(e, t, n) {
        var i = t.value, o = e.multiple;
        if (!o || Array.isArray(i)) {
            for (var r, s, a = 0, l = e.options.length; a < l; a++) if (s = e.options[a], o) r = D(i, $r(s)) > -1, s.selected !== r && (s.selected = r); else if (I($r(s), i)) return void (e.selectedIndex !== a && (e.selectedIndex = a));
            o || (e.selectedIndex = -1)
        } else ce('<select multiple v-model="' + t.expression + '"> expects an Array value for its binding, but got ' + Object.prototype.toString.call(i).slice(8, -1), n)
    }

    function Sr(e, t) {
        return t.every(function (t) {
            return !I(t, e)
        })
    }

    function $r(e) {
        return "_value" in e ? e._value : e.value
    }

    function _r(e) {
        e.target.composing = !0
    }

    function Er(e) {
        e.target.composing && (e.target.composing = !1, Ar(e.target, "input"))
    }

    function Ar(e, t) {
        var n = document.createEvent("HTMLEvents");
        n.initEvent(t, !0, !0), e.dispatchEvent(n)
    }

    function Or(e) {
        return !e.componentInstance || e.data && e.data.transition ? e : Or(e.componentInstance._vnode)
    }

    var jr = {
        model: kr, show: {
            bind: function (e, t, n) {
                var i = t.value, o = (n = Or(n)).data && n.data.transition,
                    r = e.__vOriginalDisplay = "none" === e.style.display ? "" : e.style.display;
                i && o ? (n.data.show = !0, mr(n, function () {
                    e.style.display = r
                })) : e.style.display = i ? r : "none"
            }, update: function (e, t, n) {
                var i = t.value;
                !i != !t.oldValue && ((n = Or(n)).data && n.data.transition ? (n.data.show = !0, i ? mr(n, function () {
                    e.style.display = e.__vOriginalDisplay
                }) : vr(n, function () {
                    e.style.display = "none"
                })) : e.style.display = i ? e.__vOriginalDisplay : "none")
            }, unbind: function (e, t, n, i, o) {
                o || (e.style.display = e.__vOriginalDisplay)
            }
        }
    }, Mr = {
        name: String,
        appear: Boolean,
        css: Boolean,
        mode: String,
        type: String,
        enterClass: String,
        leaveClass: String,
        enterToClass: String,
        leaveToClass: String,
        enterActiveClass: String,
        leaveActiveClass: String,
        appearClass: String,
        appearActiveClass: String,
        appearToClass: String,
        duration: [Number, String, Object]
    };

    function Ir(e) {
        var t = e && e.componentOptions;
        return t && t.Ctor.options.abstract ? Ir(mn(t.children)) : e
    }

    function Dr(e) {
        var t = {}, n = e.$options;
        for (var i in n.propsData) t[i] = e[i];
        var o = n._parentListeners;
        for (var r in o) t[k(r)] = o[r];
        return t
    }

    function Lr(e, t) {
        if (/\d-keep-alive$/.test(t.tag)) return e("keep-alive", {props: t.componentOptions.propsData})
    }

    var Pr = function (e) {
        return e.tag || hn(e)
    }, zr = function (e) {
        return "show" === e.name
    }, Nr = {
        name: "transition", props: Mr, abstract: !0, render: function (e) {
            var t = this, n = this.$slots.default;
            if (n && (n = n.filter(Pr)).length) {
                n.length > 1 && ce("<transition> can only be used on a single element. Use <transition-group> for lists.", this.$parent);
                var i = this.mode;
                i && "in-out" !== i && "out-in" !== i && ce("invalid <transition> mode: " + i, this.$parent);
                var r = n[0];
                if (function (e) {
                    for (; e = e.parent;) if (e.data.transition) return !0
                }(this.$vnode)) return r;
                var s = Ir(r);
                if (!s) return r;
                if (this._leaving) return Lr(e, r);
                var a = "__transition-" + this._uid + "-";
                s.key = null == s.key ? s.isComment ? a + "comment" : a + s.tag : o(s.key) ? 0 === String(s.key).indexOf(a) ? s.key : a + s.key : s.key;
                var l = (s.data || (s.data = {})).transition = Dr(this), c = this._vnode, d = Ir(c);
                if (s.data.directives && s.data.directives.some(zr) && (s.data.show = !0), d && d.data && !function (e, t) {
                    return t.key === e.key && t.tag === e.tag
                }(s, d) && !hn(d) && (!d.componentInstance || !d.componentInstance._vnode.isComment)) {
                    var u = d.data.transition = E({}, l);
                    if ("out-in" === i) return this._leaving = !0, At(u, "afterLeave", function () {
                        t._leaving = !1, t.$forceUpdate()
                    }), Lr(e, r);
                    if ("in-out" === i) {
                        if (hn(s)) return c;
                        var p, f = function () {
                            p()
                        };
                        At(l, "afterEnter", f), At(l, "enterCancelled", f), At(u, "delayLeave", function (e) {
                            p = e
                        })
                    }
                }
                return r
            }
        }
    }, Fr = E({tag: String, moveClass: String}, Mr);

    function Hr(e) {
        e.elm._moveCb && e.elm._moveCb(), e.elm._enterCb && e.elm._enterCb()
    }

    function qr(e) {
        e.data.newPos = e.elm.getBoundingClientRect()
    }

    function Rr(e) {
        var t = e.data.pos, n = e.data.newPos, i = t.left - n.left, o = t.top - n.top;
        if (i || o) {
            e.data.moved = !0;
            var r = e.elm.style;
            r.transform = r.WebkitTransform = "translate(" + i + "px," + o + "px)", r.transitionDuration = "0s"
        }
    }

    delete Fr.mode;
    var Wr = {
        Transition: Nr, TransitionGroup: {
            props: Fr, beforeMount: function () {
                var e = this, t = this._update;
                this._update = function (n, i) {
                    var o = kn(e);
                    e.__patch__(e._vnode, e.kept, !1, !0), e._vnode = e.kept, o(), t.call(e, n, i)
                }
            }, render: function (e) {
                for (var t = this.tag || this.$vnode.data.tag || "span", n = Object.create(null), i = this.prevChildren = this.children, o = this.$slots.default || [], r = this.children = [], s = Dr(this), a = 0; a < o.length; a++) {
                    var l = o[a];
                    if (l.tag) if (null != l.key && 0 !== String(l.key).indexOf("__vlist")) r.push(l), n[l.key] = l, (l.data || (l.data = {})).transition = s; else {
                        var c = l.componentOptions, d = c ? c.Ctor.options.name || c.tag || "" : l.tag;
                        ce("<transition-group> children must be keyed: <" + d + ">")
                    }
                }
                if (i) {
                    for (var u = [], p = [], f = 0; f < i.length; f++) {
                        var h = i[f];
                        h.data.transition = s, h.data.pos = h.elm.getBoundingClientRect(), n[h.key] ? u.push(h) : p.push(h)
                    }
                    this.kept = e(t, null, u), this.removed = p
                }
                return e(t, null, r)
            }, updated: function () {
                var e = this.prevChildren, t = this.moveClass || (this.name || "v") + "-move";
                e.length && this.hasMove(e[0].elm, t) && (e.forEach(Hr), e.forEach(qr), e.forEach(Rr), this._reflow = document.body.offsetHeight, e.forEach(function (e) {
                    if (e.data.moved) {
                        var n = e.elm, i = n.style;
                        lr(n, t), i.transform = i.WebkitTransform = i.transitionDuration = "", n.addEventListener(ir, n._moveCb = function e(i) {
                            i && i.target !== n || i && !/transform$/.test(i.propertyName) || (n.removeEventListener(ir, e), n._moveCb = null, cr(n, t))
                        })
                    }
                }))
            }, methods: {
                hasMove: function (e, t) {
                    if (!Zo) return !1;
                    if (this._hasMove) return this._hasMove;
                    var n = e.cloneNode();
                    e._transitionClasses && e._transitionClasses.forEach(function (e) {
                        Go(n, e)
                    }), Jo(n, t), n.style.display = "none", this.$el.appendChild(n);
                    var i = pr(n);
                    return this.$el.removeChild(n), this._hasMove = i.hasTransform
                }
            }
        }
    };
    Gn.config.mustUseProp = si, Gn.config.isReservedTag = ki, Gn.config.isReservedAttr = oi, Gn.config.getTagNamespace = Ci, Gn.config.isUnknownElement = function (e) {
        if (!Y) return !0;
        if (ki(e)) return !1;
        if (e = e.toLowerCase(), null != Ti[e]) return Ti[e];
        var t = document.createElement(e);
        return e.indexOf("-") > -1 ? Ti[e] = t.constructor === window.HTMLUnknownElement || t.constructor === window.HTMLElement : Ti[e] = /HTMLUnknownElement/.test(t.toString())
    }, E(Gn.options.directives, jr), E(Gn.options.components, Wr), Gn.prototype.__patch__ = Y ? xr : O, Gn.prototype.$mount = function (e, t) {
        return function (e, t, n) {
            var i;
            return e.$el = t, e.$options.render || (e.$options.render = ke, e.$options.template && "#" !== e.$options.template.charAt(0) || e.$options.el || t ? ce("You are using the runtime-only build of Vue where the template compiler is not available. Either pre-compile the templates into render functions, or use the compiler-included build.", e) : ce("Failed to mount component: template or render function not defined.", e)), Sn(e, "beforeMount"), i = F.performance && ot ? function () {
                var t = e._name, i = e._uid, o = "vue-perf-start:" + i, r = "vue-perf-end:" + i;
                ot(o);
                var s = e._render();
                ot(r), rt("vue " + t + " render", o, r), ot(o), e._update(s, n), ot(r), rt("vue " + t + " patch", o, r)
            } : function () {
                e._update(e._render(), n)
            }, new Fn(e, i, O, {
                before: function () {
                    e._isMounted && !e._isDestroyed && Sn(e, "beforeUpdate")
                }
            }, !0), n = !1, null == e.$vnode && (e._isMounted = !0, Sn(e, "mounted")), e
        }(this, e = e && Y ? $i(e) : void 0, t)
    }, Y && setTimeout(function () {
        F.devtools && (re ? re.emit("init", Gn) : console[console.info ? "info" : "log"]("Download the Vue Devtools extension for a better development experience:\nhttps://github.com/vuejs/vue-devtools")), !1 !== F.productionTip && "undefined" != typeof console && console[console.info ? "info" : "log"]("You are running Vue in development mode.\nMake sure to turn on production mode when deploying for production.\nSee more tips at https://vuejs.org/guide/deployment.html")
    }, 0);
    var Br = /\{\{((?:.|\r?\n)+?)\}\}/g, Ur = /[-.*+?^${}()|[\]\/\\]/g, Yr = w(function (e) {
        var t = e[0].replace(Ur, "\\$&"), n = e[1].replace(Ur, "\\$&");
        return new RegExp(t + "((?:.|\\n)+?)" + n, "g")
    });

    function Vr(e, t) {
        var n = t ? Yr(t) : Br;
        if (n.test(e)) {
            for (var i, o, r, s = [], a = [], l = n.lastIndex = 0; i = n.exec(e);) {
                (o = i.index) > l && (a.push(r = e.slice(l, o)), s.push(JSON.stringify(r)));
                var c = to(i[1].trim());
                s.push("_s(" + c + ")"), a.push({"@binding": c}), l = o + i[0].length
            }
            return l < e.length && (a.push(r = e.slice(l)), s.push(JSON.stringify(r))), {
                expression: s.join("+"),
                tokens: a
            }
        }
    }

    var Xr = {
        staticKeys: ["staticClass"], transformNode: function (e, t) {
            var n = t.warn || io, i = ho(e, "class");
            i && Vr(i, t.delimiters) && n('class="' + i + '": Interpolation inside attributes has been removed. Use v-bind or the colon shorthand instead. For example, instead of <div class="{{ val }}">, use <div :class="val">.', e.rawAttrsMap.class), i && (e.staticClass = JSON.stringify(i));
            var o = fo(e, "class", !1);
            o && (e.classBinding = o)
        }, genData: function (e) {
            var t = "";
            return e.staticClass && (t += "staticClass:" + e.staticClass + ","), e.classBinding && (t += "class:" + e.classBinding + ","), t
        }
    };
    var Jr, Gr = {
            staticKeys: ["staticStyle"], transformNode: function (e, t) {
                var n = t.warn || io, i = ho(e, "style");
                i && (Vr(i, t.delimiters) && n('style="' + i + '": Interpolation inside attributes has been removed. Use v-bind or the colon shorthand instead. For example, instead of <div style="{{ val }}">, use <div :style="val">.', e.rawAttrsMap.style), e.staticStyle = JSON.stringify(zo(i)));
                var o = fo(e, "style", !1);
                o && (e.styleBinding = o)
            }, genData: function (e) {
                var t = "";
                return e.staticStyle && (t += "staticStyle:" + e.staticStyle + ","), e.styleBinding && (t += "style:(" + e.styleBinding + "),"), t
            }
        }, Qr = function (e) {
            return (Jr = Jr || document.createElement("div")).innerHTML = e, Jr.textContent
        }, Kr = h("area,base,br,col,embed,frame,hr,img,input,isindex,keygen,link,meta,param,source,track,wbr"),
        Zr = h("colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr,source"),
        es = h("address,article,aside,base,blockquote,body,caption,col,colgroup,dd,details,dialog,div,dl,dt,fieldset,figcaption,figure,footer,form,h1,h2,h3,h4,h5,h6,head,header,hgroup,hr,html,legend,li,menuitem,meta,optgroup,option,param,rp,rt,source,style,summary,tbody,td,tfoot,th,thead,title,tr,track"),
        ts = /^\s*([^\s"'<>\/=]+)(?:\s*(=)\s*(?:"([^"]*)"+|'([^']*)'+|([^\s"'=<>`]+)))?/,
        ns = /^\s*((?:v-[\w-]+:|@|:|#)\[[^=]+\][^\s"'<>\/=]*)(?:\s*(=)\s*(?:"([^"]*)"+|'([^']*)'+|([^\s"'=<>`]+)))?/,
        is = "[a-zA-Z_][\\-\\.0-9_a-zA-Z" + H.source + "]*", os = "((?:" + is + "\\:)?" + is + ")",
        rs = new RegExp("^<" + os), ss = /^\s*(\/?)>/, as = new RegExp("^<\\/" + os + "[^>]*>"),
        ls = /^<!DOCTYPE [^>]+>/i, cs = /^<!\--/, ds = /^<!\[/, us = h("script,style,textarea", !0), ps = {},
        fs = {"&lt;": "<", "&gt;": ">", "&quot;": '"', "&amp;": "&", "&#10;": "\n", "&#9;": "\t", "&#39;": "'"},
        hs = /&(?:lt|gt|quot|amp|#39);/g, ms = /&(?:lt|gt|quot|amp|#39|#10|#9);/g, vs = h("pre,textarea", !0),
        gs = function (e, t) {
            return e && vs(e) && "\n" === t[0]
        };

    function ys(e, t) {
        var n = t ? ms : hs;
        return e.replace(n, function (e) {
            return fs[e]
        })
    }

    var bs, ws, xs, ks, Cs, Ts, Ss, $s, _s, Es = /^@|^v-on:/, As = /^v-|^@|^:|^#/,
        Os = /([\s\S]*?)\s+(?:in|of)\s+([\s\S]*)/, js = /,([^,\}\]]*)(?:,([^,\}\]]*))?$/, Ms = /^\(|\)$/g,
        Is = /^\[.*\]$/, Ds = /:(.*)$/, Ls = /^:|^\.|^v-bind:/, Ps = /\.[^.\]]+(?=[^\]]*$)/g, zs = /^v-slot(:|$)|^#/,
        Ns = /[\r\n]/, Fs = /\s+/g, Hs = /[\s"'<>\/=]/, qs = w(Qr), Rs = "_empty_";

    function Ws(e, t, n) {
        return {type: 1, tag: e, attrsList: t, attrsMap: Gs(t), rawAttrsMap: {}, parent: n, children: []}
    }

    function Bs(e, t) {
        bs = t.warn || io, Ts = t.isPreTag || j, Ss = t.mustUseProp || j, $s = t.getTagNamespace || j;
        var n = t.isReservedTag || j;
        _s = function (e) {
            return !!e.component || !n(e.tag)
        }, xs = oo(t.modules, "transformNode"), ks = oo(t.modules, "preTransformNode"), Cs = oo(t.modules, "postTransformNode"), ws = t.delimiters;
        var i, o, r = [], s = !1 !== t.preserveWhitespace, a = t.whitespace, l = !1, c = !1, d = !1;

        function u(e, t) {
            d || (d = !0, bs(e, t))
        }

        function p(e) {
            if (f(e), l || e.processed || (e = Us(e, t)), r.length || e === i || (i.if && (e.elseif || e.else) ? (h(e), Vs(i, {
                exp: e.elseif,
                block: e
            })) : u("Component template should contain exactly one root element. If you are using v-if on multiple elements, use v-else-if to chain them instead.", {start: e.start})), o && !e.forbidden) if (e.elseif || e.else) s = e, (a = function (e) {
                var t = e.length;
                for (; t--;) {
                    if (1 === e[t].type) return e[t];
                    " " !== e[t].text && bs('text "' + e[t].text.trim() + '" between v-if and v-else(-if) will be ignored.', e[t]), e.pop()
                }
            }(o.children)) && a.if ? Vs(a, {
                exp: s.elseif,
                block: s
            }) : bs("v-" + (s.elseif ? 'else-if="' + s.elseif + '"' : "else") + " used on element <" + s.tag + "> without corresponding v-if.", s.rawAttrsMap[s.elseif ? "v-else-if" : "v-else"]); else {
                if (e.slotScope) {
                    var n = e.slotTarget || '"default"';
                    (o.scopedSlots || (o.scopedSlots = {}))[n] = e
                }
                o.children.push(e), e.parent = o
            }
            var s, a;
            e.children = e.children.filter(function (e) {
                return !e.slotScope
            }), f(e), e.pre && (l = !1), Ts(e.tag) && (c = !1);
            for (var d = 0; d < Cs.length; d++) Cs[d](e, t)
        }

        function f(e) {
            if (!c) for (var t; (t = e.children[e.children.length - 1]) && 3 === t.type && " " === t.text;) e.children.pop()
        }

        function h(e) {
            "slot" !== e.tag && "template" !== e.tag || u("Cannot use <" + e.tag + "> as component root element because it may contain multiple nodes.", {start: e.start}), e.attrsMap.hasOwnProperty("v-for") && u("Cannot use v-for on stateful component root element because it renders multiple elements.", e.rawAttrsMap["v-for"])
        }

        return function (e, t) {
            for (var n, i, o = [], r = t.expectHTML, s = t.isUnaryTag || j, a = t.canBeLeftOpenTag || j, l = 0; e;) {
                if (n = e, i && us(i)) {
                    var c = 0, d = i.toLowerCase(),
                        u = ps[d] || (ps[d] = new RegExp("([\\s\\S]*?)(</" + d + "[^>]*>)", "i")),
                        p = e.replace(u, function (e, n, i) {
                            return c = i.length, us(d) || "noscript" === d || (n = n.replace(/<!\--([\s\S]*?)-->/g, "$1").replace(/<!\[CDATA\[([\s\S]*?)]]>/g, "$1")), gs(d, n) && (n = n.slice(1)), t.chars && t.chars(n), ""
                        });
                    l += e.length - p.length, e = p, $(d, l - c, l)
                } else {
                    var f = e.indexOf("<");
                    if (0 === f) {
                        if (cs.test(e)) {
                            var h = e.indexOf("--\x3e");
                            if (h >= 0) {
                                t.shouldKeepComment && t.comment(e.substring(4, h), l, l + h + 3), C(h + 3);
                                continue
                            }
                        }
                        if (ds.test(e)) {
                            var m = e.indexOf("]>");
                            if (m >= 0) {
                                C(m + 2);
                                continue
                            }
                        }
                        var v = e.match(ls);
                        if (v) {
                            C(v[0].length);
                            continue
                        }
                        var g = e.match(as);
                        if (g) {
                            var y = l;
                            C(g[0].length), $(g[1], y, l);
                            continue
                        }
                        var b = T();
                        if (b) {
                            S(b), gs(b.tagName, e) && C(1);
                            continue
                        }
                    }
                    var w = void 0, x = void 0, k = void 0;
                    if (f >= 0) {
                        for (x = e.slice(f); !(as.test(x) || rs.test(x) || cs.test(x) || ds.test(x) || (k = x.indexOf("<", 1)) < 0);) f += k, x = e.slice(f);
                        w = e.substring(0, f)
                    }
                    f < 0 && (w = e), w && C(w.length), t.chars && w && t.chars(w, l - w.length, l)
                }
                if (e === n) {
                    t.chars && t.chars(e), !o.length && t.warn && t.warn('Mal-formatted tag at end of template: "' + e + '"', {start: l + e.length});
                    break
                }
            }

            function C(t) {
                l += t, e = e.substring(t)
            }

            function T() {
                var t = e.match(rs);
                if (t) {
                    var n, i, o = {tagName: t[1], attrs: [], start: l};
                    for (C(t[0].length); !(n = e.match(ss)) && (i = e.match(ns) || e.match(ts));) i.start = l, C(i[0].length), i.end = l, o.attrs.push(i);
                    if (n) return o.unarySlash = n[1], C(n[0].length), o.end = l, o
                }
            }

            function S(e) {
                var n = e.tagName, l = e.unarySlash;
                r && ("p" === i && es(n) && $(i), a(n) && i === n && $(n));
                for (var c = s(n) || !!l, d = e.attrs.length, u = new Array(d), p = 0; p < d; p++) {
                    var f = e.attrs[p], h = f[3] || f[4] || f[5] || "",
                        m = "a" === n && "href" === f[1] ? t.shouldDecodeNewlinesForHref : t.shouldDecodeNewlines;
                    u[p] = {
                        name: f[1],
                        value: ys(h, m)
                    }, t.outputSourceRange && (u[p].start = f.start + f[0].match(/^\s*/).length, u[p].end = f.end)
                }
                c || (o.push({
                    tag: n,
                    lowerCasedTag: n.toLowerCase(),
                    attrs: u,
                    start: e.start,
                    end: e.end
                }), i = n), t.start && t.start(n, u, c, e.start, e.end)
            }

            function $(e, n, r) {
                var s, a;
                if (null == n && (n = l), null == r && (r = l), e) for (a = e.toLowerCase(), s = o.length - 1; s >= 0 && o[s].lowerCasedTag !== a; s--) ; else s = 0;
                if (s >= 0) {
                    for (var c = o.length - 1; c >= s; c--) (c > s || !e && t.warn) && t.warn("tag <" + o[c].tag + "> has no matching end tag.", {
                        start: o[c].start,
                        end: o[c].end
                    }), t.end && t.end(o[c].tag, n, r);
                    o.length = s, i = s && o[s - 1].tag
                } else "br" === a ? t.start && t.start(e, [], !0, n, r) : "p" === a && (t.start && t.start(e, [], !1, n, r), t.end && t.end(e, n, r))
            }

            $()
        }(e, {
            warn: bs,
            expectHTML: t.expectHTML,
            isUnaryTag: t.isUnaryTag,
            canBeLeftOpenTag: t.canBeLeftOpenTag,
            shouldDecodeNewlines: t.shouldDecodeNewlines,
            shouldDecodeNewlinesForHref: t.shouldDecodeNewlinesForHref,
            shouldKeepComment: t.comments,
            outputSourceRange: t.outputSourceRange,
            start: function (e, n, s, a, d) {
                var u = o && o.ns || $s(e);
                G && "svg" === u && (n = function (e) {
                    for (var t = [], n = 0; n < e.length; n++) {
                        var i = e[n];
                        Qs.test(i.name) || (i.name = i.name.replace(Ks, ""), t.push(i))
                    }
                    return t
                }(n));
                var f, m = Ws(e, n, o);
                u && (m.ns = u), t.outputSourceRange && (m.start = a, m.end = d, m.rawAttrsMap = m.attrsList.reduce(function (e, t) {
                    return e[t.name] = t, e
                }, {})), n.forEach(function (e) {
                    Hs.test(e.name) && bs("Invalid dynamic argument expression: attribute names cannot contain spaces, quotes, <, >, / or =.", {
                        start: e.start + e.name.indexOf("["),
                        end: e.start + e.name.length
                    })
                }), "style" !== (f = m).tag && ("script" !== f.tag || f.attrsMap.type && "text/javascript" !== f.attrsMap.type) || oe() || (m.forbidden = !0, bs("Templates should only be responsible for mapping the state to the UI. Avoid placing tags with side-effects in your templates, such as <" + e + ">, as they will not be parsed.", {start: m.start}));
                for (var v = 0; v < ks.length; v++) m = ks[v](m, t) || m;
                l || (!function (e) {
                    null != ho(e, "v-pre") && (e.pre = !0)
                }(m), m.pre && (l = !0)), Ts(m.tag) && (c = !0), l ? function (e) {
                    var t = e.attrsList, n = t.length;
                    if (n) for (var i = e.attrs = new Array(n), o = 0; o < n; o++) i[o] = {
                        name: t[o].name,
                        value: JSON.stringify(t[o].value)
                    }, null != t[o].start && (i[o].start = t[o].start, i[o].end = t[o].end); else e.pre || (e.plain = !0)
                }(m) : m.processed || (Ys(m), function (e) {
                    var t = ho(e, "v-if");
                    if (t) e.if = t, Vs(e, {exp: t, block: e}); else {
                        null != ho(e, "v-else") && (e.else = !0);
                        var n = ho(e, "v-else-if");
                        n && (e.elseif = n)
                    }
                }(m), function (e) {
                    null != ho(e, "v-once") && (e.once = !0)
                }(m)), i || h(i = m), s ? p(m) : (o = m, r.push(m))
            },
            end: function (e, n, i) {
                var s = r[r.length - 1];
                r.length -= 1, o = r[r.length - 1], t.outputSourceRange && (s.end = i), p(s)
            },
            chars: function (n, i, r) {
                if (o) {
                    if (!G || "textarea" !== o.tag || o.attrsMap.placeholder !== n) {
                        var d, p, f, h = o.children;
                        if (n = c || n.trim() ? "script" === (d = o).tag || "style" === d.tag ? n : qs(n) : h.length ? a ? "condense" === a && Ns.test(n) ? "" : " " : s ? " " : "" : "") c || "condense" !== a || (n = n.replace(Fs, " ")), !l && " " !== n && (p = Vr(n, ws)) ? f = {
                            type: 2,
                            expression: p.expression,
                            tokens: p.tokens,
                            text: n
                        } : " " === n && h.length && " " === h[h.length - 1].text || (f = {
                            type: 3,
                            text: n
                        }), f && (t.outputSourceRange && (f.start = i, f.end = r), h.push(f))
                    }
                } else n === e ? u("Component template requires a root element, rather than just text.", {start: i}) : (n = n.trim()) && u('text "' + n + '" outside root element will be ignored.', {start: i})
            },
            comment: function (e, n, i) {
                if (o) {
                    var r = {type: 3, text: e, isComment: !0};
                    t.outputSourceRange && (r.start = n, r.end = i), o.children.push(r)
                }
            }
        }), i
    }

    function Us(e, t) {
        var n, i;
        !function (e) {
            var t = fo(e, "key");
            if (t) {
                if ("template" === e.tag && bs("<template> cannot be keyed. Place the key on real elements instead.", po(e, "key")), e.for) {
                    var n = e.iterator2 || e.iterator1, i = e.parent;
                    n && n === t && i && "transition-group" === i.tag && bs("Do not use v-for index as key on <transition-group> children, this is the same as not using keys.", po(e, "key"), !0)
                }
                e.key = t
            }
        }(e), e.plain = !e.key && !e.scopedSlots && !e.attrsList.length, (i = fo(n = e, "ref")) && (n.ref = i, n.refInFor = function (e) {
            for (var t = e; t;) {
                if (void 0 !== t.for) return !0;
                t = t.parent
            }
            return !1
        }(n)), function (e) {
            var t;
            "template" === e.tag ? ((t = ho(e, "scope")) && bs('the "scope" attribute for scoped slots have been deprecated and replaced by "slot-scope" since 2.5. The new "slot-scope" attribute can also be used on plain elements in addition to <template> to denote scoped slots.', e.rawAttrsMap.scope, !0), e.slotScope = t || ho(e, "slot-scope")) : (t = ho(e, "slot-scope")) && (e.attrsMap["v-for"] && bs("Ambiguous combined usage of slot-scope and v-for on <" + e.tag + "> (v-for takes higher priority). Use a wrapper <template> for the scoped slot to make it clearer.", e.rawAttrsMap["slot-scope"], !0), e.slotScope = t);
            var n = fo(e, "slot");
            n && (e.slotTarget = '""' === n ? '"default"' : n, e.slotTargetDynamic = !(!e.attrsMap[":slot"] && !e.attrsMap["v-bind:slot"]), "template" === e.tag || e.slotScope || so(e, "slot", n, po(e, "slot")));
            if ("template" === e.tag) {
                var i = mo(e, zs);
                if (i) {
                    (e.slotTarget || e.slotScope) && bs("Unexpected mixed usage of different slot syntaxes.", e), e.parent && !_s(e.parent) && bs("<template v-slot> can only appear at the root level inside the receiving component", e);
                    var o = Xs(i), r = o.name, s = o.dynamic;
                    e.slotTarget = r, e.slotTargetDynamic = s, e.slotScope = i.value || Rs
                }
            } else {
                var a = mo(e, zs);
                if (a) {
                    _s(e) || bs("v-slot can only be used on components or <template>.", a), (e.slotScope || e.slotTarget) && bs("Unexpected mixed usage of different slot syntaxes.", e), e.scopedSlots && bs("To avoid scope ambiguity, the default slot should also use <template> syntax when there are other named slots.", a);
                    var l = e.scopedSlots || (e.scopedSlots = {}), c = Xs(a), d = c.name, u = c.dynamic,
                        p = l[d] = Ws("template", [], e);
                    p.slotTarget = d, p.slotTargetDynamic = u, p.children = e.children.filter(function (e) {
                        if (!e.slotScope) return e.parent = p, !0
                    }), p.slotScope = a.value || Rs, e.children = [], e.plain = !1
                }
            }
        }(e), function (e) {
            "slot" === e.tag && (e.slotName = fo(e, "name"), e.key && bs("`key` does not work on <slot> because slots are abstract outlets and can possibly expand into multiple elements. Use the key on a wrapping element instead.", po(e, "key")))
        }(e), function (e) {
            var t;
            (t = fo(e, "is")) && (e.component = t);
            null != ho(e, "inline-template") && (e.inlineTemplate = !0)
        }(e);
        for (var o = 0; o < xs.length; o++) e = xs[o](e, t) || e;
        return function (e) {
            var t, n, i, o, r, s, a, l, c = e.attrsList;
            for (t = 0, n = c.length; t < n; t++) if (i = o = c[t].name, r = c[t].value, As.test(i)) if (e.hasBindings = !0, (s = Js(i.replace(As, ""))) && (i = i.replace(Ps, "")), Ls.test(i)) i = i.replace(Ls, ""), r = to(r), (l = Is.test(i)) && (i = i.slice(1, -1)), 0 === r.trim().length && bs('The value for a v-bind expression cannot be empty. Found in "v-bind:' + i + '"'), s && (s.prop && !l && "innerHtml" === (i = k(i)) && (i = "innerHTML"), s.camel && !l && (i = k(i)), s.sync && (a = yo(r, "$event"), l ? uo(e, '"update:"+(' + i + ")", a, null, !1, bs, c[t], !0) : (uo(e, "update:" + k(i), a, null, !1, bs, c[t]), S(i) !== k(i) && uo(e, "update:" + S(i), a, null, !1, bs, c[t])))), s && s.prop || !e.component && Ss(e.tag, e.attrsMap.type, i) ? ro(e, i, r, c[t], l) : so(e, i, r, c[t], l); else if (Es.test(i)) i = i.replace(Es, ""), (l = Is.test(i)) && (i = i.slice(1, -1)), uo(e, i, r, s, !1, bs, c[t], l); else {
                var d = (i = i.replace(As, "")).match(Ds), u = d && d[1];
                l = !1, u && (i = i.slice(0, -(u.length + 1)), Is.test(u) && (u = u.slice(1, -1), l = !0)), lo(e, i, o, r, u, l, s, c[t]), "model" === i && Zs(e, r)
            } else {
                var p = Vr(r, ws);
                p && bs(i + '="' + r + '": Interpolation inside attributes has been removed. Use v-bind or the colon shorthand instead. For example, instead of <div id="{{ val }}">, use <div :id="val">.', c[t]), so(e, i, JSON.stringify(r), c[t]), !e.component && "muted" === i && Ss(e.tag, e.attrsMap.type, i) && ro(e, i, "true", c[t])
            }
        }(e), e
    }

    function Ys(e) {
        var t;
        if (t = ho(e, "v-for")) {
            var n = function (e) {
                var t = e.match(Os);
                if (!t) return;
                var n = {};
                n.for = t[2].trim();
                var i = t[1].trim().replace(Ms, ""), o = i.match(js);
                o ? (n.alias = i.replace(js, "").trim(), n.iterator1 = o[1].trim(), o[2] && (n.iterator2 = o[2].trim())) : n.alias = i;
                return n
            }(t);
            n ? E(e, n) : bs("Invalid v-for expression: " + t, e.rawAttrsMap["v-for"])
        }
    }

    function Vs(e, t) {
        e.ifConditions || (e.ifConditions = []), e.ifConditions.push(t)
    }

    function Xs(e) {
        var t = e.name.replace(zs, "");
        return t || ("#" !== e.name[0] ? t = "default" : bs("v-slot shorthand syntax requires a slot name.", e)), Is.test(t) ? {
            name: t.slice(1, -1),
            dynamic: !0
        } : {name: '"' + t + '"', dynamic: !1}
    }

    function Js(e) {
        var t = e.match(Ps);
        if (t) {
            var n = {};
            return t.forEach(function (e) {
                n[e.slice(1)] = !0
            }), n
        }
    }

    function Gs(e) {
        for (var t = {}, n = 0, i = e.length; n < i; n++) !t[e[n].name] || G || K || bs("duplicate attribute: " + e[n].name, e[n]), t[e[n].name] = e[n].value;
        return t
    }

    var Qs = /^xmlns:NS\d+/, Ks = /^NS\d+:/;

    function Zs(e, t) {
        for (var n = e; n;) n.for && n.alias === t && bs("<" + e.tag + ' v-model="' + t + '">: You are binding v-model directly to a v-for iteration alias. This will not be able to modify the v-for source array because writing to the alias is like modifying a function local variable. Consider using an array of objects and use v-model on an object property instead.', e.rawAttrsMap["v-model"]), n = n.parent
    }

    function ea(e) {
        return Ws(e.tag, e.attrsList.slice(), e.parent)
    }

    var ta = [Xr, Gr, {
        preTransformNode: function (e, t) {
            if ("input" === e.tag) {
                var n, i = e.attrsMap;
                if (!i["v-model"]) return;
                if ((i[":type"] || i["v-bind:type"]) && (n = fo(e, "type")), i.type || n || !i["v-bind"] || (n = "(" + i["v-bind"] + ").type"), n) {
                    var o = ho(e, "v-if", !0), r = o ? "&&(" + o + ")" : "", s = null != ho(e, "v-else", !0),
                        a = ho(e, "v-else-if", !0), l = ea(e);
                    Ys(l), ao(l, "type", "checkbox"), Us(l, t), l.processed = !0, l.if = "(" + n + ")==='checkbox'" + r, Vs(l, {
                        exp: l.if,
                        block: l
                    });
                    var c = ea(e);
                    ho(c, "v-for", !0), ao(c, "type", "radio"), Us(c, t), Vs(l, {
                        exp: "(" + n + ")==='radio'" + r,
                        block: c
                    });
                    var d = ea(e);
                    return ho(d, "v-for", !0), ao(d, ":type", n), Us(d, t), Vs(l, {
                        exp: o,
                        block: d
                    }), s ? l.else = !0 : a && (l.elseif = a), l
                }
            }
        }
    }];
    var na, ia, oa = {
        expectHTML: !0,
        modules: ta,
        directives: {
            model: function (e, t, n) {
                Ki = n;
                var i = t.value, o = t.modifiers, r = e.tag, s = e.attrsMap.type;
                if ("input" === r && "file" === s && Ki("<" + e.tag + ' v-model="' + i + '" type="file">:\nFile inputs are read only. Use a v-on:change listener instead.', e.rawAttrsMap["v-model"]), e.component) return go(e, i, o), !1;
                if ("select" === r) !function (e, t, n) {
                    var i = 'var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return ' + (n && n.number ? "_n(val)" : "val") + "});";
                    i = i + " " + yo(t, "$event.target.multiple ? $$selectedVal : $$selectedVal[0]"), uo(e, "change", i, null, !0)
                }(e, i, o); else if ("input" === r && "checkbox" === s) !function (e, t, n) {
                    var i = n && n.number, o = fo(e, "value") || "null", r = fo(e, "true-value") || "true",
                        s = fo(e, "false-value") || "false";
                    ro(e, "checked", "Array.isArray(" + t + ")?_i(" + t + "," + o + ")>-1" + ("true" === r ? ":(" + t + ")" : ":_q(" + t + "," + r + ")")), uo(e, "change", "var $$a=" + t + ",$$el=$event.target,$$c=$$el.checked?(" + r + "):(" + s + ");if(Array.isArray($$a)){var $$v=" + (i ? "_n(" + o + ")" : o) + ",$$i=_i($$a,$$v);if($$el.checked){$$i<0&&(" + yo(t, "$$a.concat([$$v])") + ")}else{$$i>-1&&(" + yo(t, "$$a.slice(0,$$i).concat($$a.slice($$i+1))") + ")}}else{" + yo(t, "$$c") + "}", null, !0)
                }(e, i, o); else if ("input" === r && "radio" === s) !function (e, t, n) {
                    var i = n && n.number, o = fo(e, "value") || "null";
                    ro(e, "checked", "_q(" + t + "," + (o = i ? "_n(" + o + ")" : o) + ")"), uo(e, "change", yo(t, o), null, !0)
                }(e, i, o); else if ("input" === r || "textarea" === r) !function (e, t, n) {
                    var i = e.attrsMap.type, o = e.attrsMap["v-bind:value"] || e.attrsMap[":value"],
                        r = e.attrsMap["v-bind:type"] || e.attrsMap[":type"];
                    if (o && !r) {
                        var s = e.attrsMap["v-bind:value"] ? "v-bind:value" : ":value";
                        Ki(s + '="' + o + '" conflicts with v-model on the same element because the latter already expands to a value binding internally', e.rawAttrsMap[s])
                    }
                    var a = n || {}, l = a.lazy, c = a.number, d = a.trim, u = !l && "range" !== i,
                        p = l ? "change" : "range" === i ? So : "input", f = "$event.target.value";
                    d && (f = "$event.target.value.trim()"), c && (f = "_n(" + f + ")");
                    var h = yo(t, f);
                    u && (h = "if($event.target.composing)return;" + h), ro(e, "value", "(" + t + ")"), uo(e, p, h, null, !0), (d || c) && uo(e, "blur", "$forceUpdate()")
                }(e, i, o); else {
                    if (!F.isReservedTag(r)) return go(e, i, o), !1;
                    Ki("<" + e.tag + ' v-model="' + i + "\">: v-model is not supported on this element type. If you are working with contenteditable, it's recommended to wrap a library dedicated for that purpose inside a custom component.", e.rawAttrsMap["v-model"])
                }
                return !0
            }, text: function (e, t) {
                t.value && ro(e, "textContent", "_s(" + t.value + ")", t)
            }, html: function (e, t) {
                t.value && ro(e, "innerHTML", "_s(" + t.value + ")", t)
            }
        },
        isPreTag: function (e) {
            return "pre" === e
        },
        isUnaryTag: Kr,
        mustUseProp: si,
        canBeLeftOpenTag: Zr,
        isReservedTag: ki,
        getTagNamespace: Ci,
        staticKeys: function (e) {
            return e.reduce(function (e, t) {
                return e.concat(t.staticKeys || [])
            }, []).join(",")
        }(ta)
    }, ra = w(function (e) {
        return h("type,tag,attrsList,attrsMap,plain,parent,children,attrs,start,end,rawAttrsMap" + (e ? "," + e : ""))
    });

    function sa(e, t) {
        e && (na = ra(t.staticKeys || ""), ia = t.isReservedTag || j, function e(t) {
            t.static = function (e) {
                if (2 === e.type) return !1;
                if (3 === e.type) return !0;
                return !(!e.pre && (e.hasBindings || e.if || e.for || m(e.tag) || !ia(e.tag) || function (e) {
                    for (; e.parent;) {
                        if ("template" !== (e = e.parent).tag) return !1;
                        if (e.for) return !0
                    }
                    return !1
                }(e) || !Object.keys(e).every(na)))
            }(t);
            if (1 === t.type) {
                if (!ia(t.tag) && "slot" !== t.tag && null == t.attrsMap["inline-template"]) return;
                for (var n = 0, i = t.children.length; n < i; n++) {
                    var o = t.children[n];
                    e(o), o.static || (t.static = !1)
                }
                if (t.ifConditions) for (var r = 1, s = t.ifConditions.length; r < s; r++) {
                    var a = t.ifConditions[r].block;
                    e(a), a.static || (t.static = !1)
                }
            }
        }(e), function e(t, n) {
            if (1 === t.type) {
                if ((t.static || t.once) && (t.staticInFor = n), t.static && t.children.length && (1 !== t.children.length || 3 !== t.children[0].type)) return void (t.staticRoot = !0);
                if (t.staticRoot = !1, t.children) for (var i = 0, o = t.children.length; i < o; i++) e(t.children[i], n || !!t.for);
                if (t.ifConditions) for (var r = 1, s = t.ifConditions.length; r < s; r++) e(t.ifConditions[r].block, n)
            }
        }(e, !1))
    }

    var aa = /^([\w$_]+|\([^)]*?\))\s*=>|^function(?:\s+[\w$]+)?\s*\(/, la = /\([^)]*?\);*$/,
        ca = /^[A-Za-z_$][\w$]*(?:\.[A-Za-z_$][\w$]*|\['[^']*?']|\["[^"]*?"]|\[\d+]|\[[A-Za-z_$][\w$]*])*$/,
        da = {esc: 27, tab: 9, enter: 13, space: 32, up: 38, left: 37, right: 39, down: 40, delete: [8, 46]}, ua = {
            esc: ["Esc", "Escape"],
            tab: "Tab",
            enter: "Enter",
            space: [" ", "Spacebar"],
            up: ["Up", "ArrowUp"],
            left: ["Left", "ArrowLeft"],
            right: ["Right", "ArrowRight"],
            down: ["Down", "ArrowDown"],
            delete: ["Backspace", "Delete", "Del"]
        }, pa = function (e) {
            return "if(" + e + ")return null;"
        }, fa = {
            stop: "$event.stopPropagation();",
            prevent: "$event.preventDefault();",
            self: pa("$event.target !== $event.currentTarget"),
            ctrl: pa("!$event.ctrlKey"),
            shift: pa("!$event.shiftKey"),
            alt: pa("!$event.altKey"),
            meta: pa("!$event.metaKey"),
            left: pa("'button' in $event && $event.button !== 0"),
            middle: pa("'button' in $event && $event.button !== 1"),
            right: pa("'button' in $event && $event.button !== 2")
        };

    function ha(e, t) {
        var n = t ? "nativeOn:" : "on:", i = "", o = "";
        for (var r in e) {
            var s = ma(e[r]);
            e[r] && e[r].dynamic ? o += r + "," + s + "," : i += '"' + r + '":' + s + ","
        }
        return i = "{" + i.slice(0, -1) + "}", o ? n + "_d(" + i + ",[" + o.slice(0, -1) + "])" : n + i
    }

    function ma(e) {
        if (!e) return "function(){}";
        if (Array.isArray(e)) return "[" + e.map(function (e) {
            return ma(e)
        }).join(",") + "]";
        var t = ca.test(e.value), n = aa.test(e.value), i = ca.test(e.value.replace(la, ""));
        if (e.modifiers) {
            var o = "", r = "", s = [];
            for (var a in e.modifiers) if (fa[a]) r += fa[a], da[a] && s.push(a); else if ("exact" === a) {
                var l = e.modifiers;
                r += pa(["ctrl", "shift", "alt", "meta"].filter(function (e) {
                    return !l[e]
                }).map(function (e) {
                    return "$event." + e + "Key"
                }).join("||"))
            } else s.push(a);
            return s.length && (o += function (e) {
                return "if(!$event.type.indexOf('key')&&" + e.map(va).join("&&") + ")return null;"
            }(s)), r && (o += r), "function($event){" + o + (t ? "return " + e.value + "($event)" : n ? "return (" + e.value + ")($event)" : i ? "return " + e.value : e.value) + "}"
        }
        return t || n ? e.value : "function($event){" + (i ? "return " + e.value : e.value) + "}"
    }

    function va(e) {
        var t = parseInt(e, 10);
        if (t) return "$event.keyCode!==" + t;
        var n = da[e], i = ua[e];
        return "_k($event.keyCode," + JSON.stringify(e) + "," + JSON.stringify(n) + ",$event.key," + JSON.stringify(i) + ")"
    }

    var ga = {
        on: function (e, t) {
            t.modifiers && ce("v-on without argument does not support modifiers."), e.wrapListeners = function (e) {
                return "_g(" + e + "," + t.value + ")"
            }
        }, bind: function (e, t) {
            e.wrapData = function (n) {
                return "_b(" + n + ",'" + e.tag + "'," + t.value + "," + (t.modifiers && t.modifiers.prop ? "true" : "false") + (t.modifiers && t.modifiers.sync ? ",true" : "") + ")"
            }
        }, cloak: O
    }, ya = function (e) {
        this.options = e, this.warn = e.warn || io, this.transforms = oo(e.modules, "transformCode"), this.dataGenFns = oo(e.modules, "genData"), this.directives = E(E({}, ga), e.directives);
        var t = e.isReservedTag || j;
        this.maybeComponent = function (e) {
            return !!e.component || !t(e.tag)
        }, this.onceId = 0, this.staticRenderFns = [], this.pre = !1
    };

    function ba(e, t) {
        var n = new ya(t);
        return {render: "with(this){return " + (e ? wa(e, n) : '_c("div")') + "}", staticRenderFns: n.staticRenderFns}
    }

    function wa(e, t) {
        if (e.parent && (e.pre = e.pre || e.parent.pre), e.staticRoot && !e.staticProcessed) return xa(e, t);
        if (e.once && !e.onceProcessed) return ka(e, t);
        if (e.for && !e.forProcessed) return Ta(e, t);
        if (e.if && !e.ifProcessed) return Ca(e, t);
        if ("template" !== e.tag || e.slotTarget || t.pre) {
            if ("slot" === e.tag) return function (e, t) {
                var n = e.slotName || '"default"', i = Ea(e, t), o = "_t(" + n + (i ? "," + i : ""),
                    r = e.attrs || e.dynamicAttrs ? ja((e.attrs || []).concat(e.dynamicAttrs || []).map(function (e) {
                        return {name: k(e.name), value: e.value, dynamic: e.dynamic}
                    })) : null, s = e.attrsMap["v-bind"];
                !r && !s || i || (o += ",null");
                r && (o += "," + r);
                s && (o += (r ? "" : ",null") + "," + s);
                return o + ")"
            }(e, t);
            var n;
            if (e.component) n = function (e, t, n) {
                var i = t.inlineTemplate ? null : Ea(t, n, !0);
                return "_c(" + e + "," + Sa(t, n) + (i ? "," + i : "") + ")"
            }(e.component, e, t); else {
                var i;
                (!e.plain || e.pre && t.maybeComponent(e)) && (i = Sa(e, t));
                var o = e.inlineTemplate ? null : Ea(e, t, !0);
                n = "_c('" + e.tag + "'" + (i ? "," + i : "") + (o ? "," + o : "") + ")"
            }
            for (var r = 0; r < t.transforms.length; r++) n = t.transforms[r](e, n);
            return n
        }
        return Ea(e, t) || "void 0"
    }

    function xa(e, t) {
        e.staticProcessed = !0;
        var n = t.pre;
        return e.pre && (t.pre = e.pre), t.staticRenderFns.push("with(this){return " + wa(e, t) + "}"), t.pre = n, "_m(" + (t.staticRenderFns.length - 1) + (e.staticInFor ? ",true" : "") + ")"
    }

    function ka(e, t) {
        if (e.onceProcessed = !0, e.if && !e.ifProcessed) return Ca(e, t);
        if (e.staticInFor) {
            for (var n = "", i = e.parent; i;) {
                if (i.for) {
                    n = i.key;
                    break
                }
                i = i.parent
            }
            return n ? "_o(" + wa(e, t) + "," + t.onceId++ + "," + n + ")" : (t.warn("v-once can only be used inside v-for that is keyed. ", e.rawAttrsMap["v-once"]), wa(e, t))
        }
        return xa(e, t)
    }

    function Ca(e, t, n, i) {
        return e.ifProcessed = !0, function e(t, n, i, o) {
            if (!t.length) return o || "_e()";
            var r = t.shift();
            return r.exp ? "(" + r.exp + ")?" + s(r.block) + ":" + e(t, n, i, o) : "" + s(r.block);

            function s(e) {
                return i ? i(e, n) : e.once ? ka(e, n) : wa(e, n)
            }
        }(e.ifConditions.slice(), t, n, i)
    }

    function Ta(e, t, n, i) {
        var o = e.for, r = e.alias, s = e.iterator1 ? "," + e.iterator1 : "", a = e.iterator2 ? "," + e.iterator2 : "";
        return t.maybeComponent(e) && "slot" !== e.tag && "template" !== e.tag && !e.key && t.warn("<" + e.tag + ' v-for="' + r + " in " + o + '">: component lists rendered with v-for should have explicit keys. See https://vuejs.org/guide/list.html#key for more info.', e.rawAttrsMap["v-for"], !0), e.forProcessed = !0, (i || "_l") + "((" + o + "),function(" + r + s + a + "){return " + (n || wa)(e, t) + "})"
    }

    function Sa(e, t) {
        var n = "{", i = function (e, t) {
            var n = e.directives;
            if (!n) return;
            var i, o, r, s, a = "directives:[", l = !1;
            for (i = 0, o = n.length; i < o; i++) {
                r = n[i], s = !0;
                var c = t.directives[r.name];
                c && (s = !!c(e, r, t.warn)), s && (l = !0, a += '{name:"' + r.name + '",rawName:"' + r.rawName + '"' + (r.value ? ",value:(" + r.value + "),expression:" + JSON.stringify(r.value) : "") + (r.arg ? ",arg:" + (r.isDynamicArg ? r.arg : '"' + r.arg + '"') : "") + (r.modifiers ? ",modifiers:" + JSON.stringify(r.modifiers) : "") + "},")
            }
            if (l) return a.slice(0, -1) + "]"
        }(e, t);
        i && (n += i + ","), e.key && (n += "key:" + e.key + ","), e.ref && (n += "ref:" + e.ref + ","), e.refInFor && (n += "refInFor:true,"), e.pre && (n += "pre:true,"), e.component && (n += 'tag:"' + e.tag + '",');
        for (var o = 0; o < t.dataGenFns.length; o++) n += t.dataGenFns[o](e);
        if (e.attrs && (n += "attrs:" + ja(e.attrs) + ","), e.props && (n += "domProps:" + ja(e.props) + ","), e.events && (n += ha(e.events, !1) + ","), e.nativeEvents && (n += ha(e.nativeEvents, !0) + ","), e.slotTarget && !e.slotScope && (n += "slot:" + e.slotTarget + ","), e.scopedSlots && (n += function (e, t, n) {
            var i = e.for || Object.keys(t).some(function (e) {
                var n = t[e];
                return n.slotTargetDynamic || n.if || n.for || $a(n)
            }), o = !!e.if;
            if (!i) for (var r = e.parent; r;) {
                if (r.slotScope && r.slotScope !== Rs || r.for) {
                    i = !0;
                    break
                }
                r.if && (o = !0), r = r.parent
            }
            var s = Object.keys(t).map(function (e) {
                return _a(t[e], n)
            }).join(",");
            return "scopedSlots:_u([" + s + "]" + (i ? ",null,true" : "") + (!i && o ? ",null,false," + function (e) {
                var t = 5381, n = e.length;
                for (; n;) t = 33 * t ^ e.charCodeAt(--n);
                return t >>> 0
            }(s) : "") + ")"
        }(e, e.scopedSlots, t) + ","), e.model && (n += "model:{value:" + e.model.value + ",callback:" + e.model.callback + ",expression:" + e.model.expression + "},"), e.inlineTemplate) {
            var r = function (e, t) {
                var n = e.children[0];
                1 === e.children.length && 1 === n.type || t.warn("Inline-template components must have exactly one child element.", {start: e.start});
                if (n && 1 === n.type) {
                    var i = ba(n, t.options);
                    return "inlineTemplate:{render:function(){" + i.render + "},staticRenderFns:[" + i.staticRenderFns.map(function (e) {
                        return "function(){" + e + "}"
                    }).join(",") + "]}"
                }
            }(e, t);
            r && (n += r + ",")
        }
        return n = n.replace(/,$/, "") + "}", e.dynamicAttrs && (n = "_b(" + n + ',"' + e.tag + '",' + ja(e.dynamicAttrs) + ")"), e.wrapData && (n = e.wrapData(n)), e.wrapListeners && (n = e.wrapListeners(n)), n
    }

    function $a(e) {
        return 1 === e.type && ("slot" === e.tag || e.children.some($a))
    }

    function _a(e, t) {
        var n = e.attrsMap["slot-scope"];
        if (e.if && !e.ifProcessed && !n) return Ca(e, t, _a, "null");
        if (e.for && !e.forProcessed) return Ta(e, t, _a);
        var i = e.slotScope === Rs ? "" : String(e.slotScope),
            o = "function(" + i + "){return " + ("template" === e.tag ? e.if && n ? "(" + e.if + ")?" + (Ea(e, t) || "undefined") + ":undefined" : Ea(e, t) || "undefined" : wa(e, t)) + "}",
            r = i ? "" : ",proxy:true";
        return "{key:" + (e.slotTarget || '"default"') + ",fn:" + o + r + "}"
    }

    function Ea(e, t, n, i, o) {
        var r = e.children;
        if (r.length) {
            var s = r[0];
            if (1 === r.length && s.for && "template" !== s.tag && "slot" !== s.tag) {
                var a = n ? t.maybeComponent(s) ? ",1" : ",0" : "";
                return "" + (i || wa)(s, t) + a
            }
            var l = n ? function (e, t) {
                for (var n = 0, i = 0; i < e.length; i++) {
                    var o = e[i];
                    if (1 === o.type) {
                        if (Aa(o) || o.ifConditions && o.ifConditions.some(function (e) {
                            return Aa(e.block)
                        })) {
                            n = 2;
                            break
                        }
                        (t(o) || o.ifConditions && o.ifConditions.some(function (e) {
                            return t(e.block)
                        })) && (n = 1)
                    }
                }
                return n
            }(r, t.maybeComponent) : 0, c = o || Oa;
            return "[" + r.map(function (e) {
                return c(e, t)
            }).join(",") + "]" + (l ? "," + l : "")
        }
    }

    function Aa(e) {
        return void 0 !== e.for || "template" === e.tag || "slot" === e.tag
    }

    function Oa(e, t) {
        return 1 === e.type ? wa(e, t) : 3 === e.type && e.isComment ? (i = e, "_e(" + JSON.stringify(i.text) + ")") : "_v(" + (2 === (n = e).type ? n.expression : Ma(JSON.stringify(n.text))) + ")";
        var n, i
    }

    function ja(e) {
        for (var t = "", n = "", i = 0; i < e.length; i++) {
            var o = e[i], r = Ma(o.value);
            o.dynamic ? n += o.name + "," + r + "," : t += '"' + o.name + '":' + r + ","
        }
        return t = "{" + t.slice(0, -1) + "}", n ? "_d(" + t + ",[" + n.slice(0, -1) + "])" : t
    }

    function Ma(e) {
        return e.replace(/\u2028/g, "\\u2028").replace(/\u2029/g, "\\u2029")
    }

    var Ia = new RegExp("\\b" + "do,if,for,let,new,try,var,case,else,with,await,break,catch,class,const,super,throw,while,yield,delete,export,import,return,switch,default,extends,finally,continue,debugger,function,arguments".split(",").join("\\b|\\b") + "\\b"),
        Da = new RegExp("\\b" + "delete,typeof,void".split(",").join("\\s*\\([^\\)]*\\)|\\b") + "\\s*\\([^\\)]*\\)"),
        La = /'(?:[^'\\]|\\.)*'|"(?:[^"\\]|\\.)*"|`(?:[^`\\]|\\.)*\$\{|\}(?:[^`\\]|\\.)*`|`(?:[^`\\]|\\.)*`/g;

    function Pa(e, t) {
        e && function e(t, n) {
            if (1 === t.type) {
                for (var i in t.attrsMap) if (As.test(i)) {
                    var o = t.attrsMap[i];
                    if (o) {
                        var r = t.rawAttrsMap[i];
                        "v-for" === i ? Na(t, 'v-for="' + o + '"', n, r) : "v-slot" === i || "#" === i[0] ? qa(o, i + '="' + o + '"', n, r) : Es.test(i) ? za(o, i + '="' + o + '"', n, r) : Ha(o, i + '="' + o + '"', n, r)
                    }
                }
                if (t.children) for (var s = 0; s < t.children.length; s++) e(t.children[s], n)
            } else 2 === t.type && Ha(t.expression, t.text, n, t)
        }(e, t)
    }

    function za(e, t, n, i) {
        var o = e.replace(La, ""), r = o.match(Da);
        r && "$" !== o.charAt(r.index - 1) && n('avoid using JavaScript unary operator as property name: "' + r[0] + '" in expression ' + t.trim(), i), Ha(e, t, n, i)
    }

    function Na(e, t, n, i) {
        Ha(e.for || "", t, n, i), Fa(e.alias, "v-for alias", t, n, i), Fa(e.iterator1, "v-for iterator", t, n, i), Fa(e.iterator2, "v-for iterator", t, n, i)
    }

    function Fa(e, t, n, i, o) {
        if ("string" == typeof e) try {
            new Function("var " + e + "=_")
        } catch (r) {
            i("invalid " + t + ' "' + e + '" in expression: ' + n.trim(), o)
        }
    }

    function Ha(e, t, n, i) {
        try {
            new Function("return " + e)
        } catch (r) {
            var o = e.replace(La, "").match(Ia);
            n(o ? 'avoid using JavaScript keyword as property name: "' + o[0] + '"\n  Raw expression: ' + t.trim() : "invalid expression: " + r.message + " in\n\n    " + e + "\n\n  Raw expression: " + t.trim() + "\n", i)
        }
    }

    function qa(e, t, n, i) {
        try {
            new Function(e, "")
        } catch (o) {
            n("invalid function parameter expression: " + o.message + " in\n\n    " + e + "\n\n  Raw expression: " + t.trim() + "\n", i)
        }
    }

    var Ra = 2;

    function Wa(e, t) {
        var n = "";
        if (t > 0) for (; 1 & t && (n += e), !((t >>>= 1) <= 0);) e += e;
        return n
    }

    function Ba(e, t) {
        try {
            return new Function(e)
        } catch (n) {
            return t.push({err: n, code: e}), O
        }
    }

    function Ua(e) {
        var t = Object.create(null);
        return function (n, i, o) {
            var r = (i = E({}, i)).warn || ce;
            delete i.warn;
            try {
                new Function("return 1")
            } catch (e) {
                e.toString().match(/unsafe-eval|CSP/) && r("It seems you are using the standalone build of Vue.js in an environment with Content Security Policy that prohibits unsafe-eval. The template compiler cannot work in this environment. Consider relaxing the policy to allow unsafe-eval or pre-compiling your templates into render functions.")
            }
            var s = i.delimiters ? String(i.delimiters) + n : n;
            if (t[s]) return t[s];
            var a = e(n, i);
            a.errors && a.errors.length && (i.outputSourceRange ? a.errors.forEach(function (e) {
                r("Error compiling template:\n\n" + e.msg + "\n\n" + function (e, t, n) {
                    void 0 === t && (t = 0), void 0 === n && (n = e.length);
                    for (var i = e.split(/\r?\n/), o = 0, r = [], s = 0; s < i.length; s++) if ((o += i[s].length + 1) >= t) {
                        for (var a = s - Ra; a <= s + Ra || n > o; a++) if (!(a < 0 || a >= i.length)) {
                            r.push("" + (a + 1) + Wa(" ", 3 - String(a + 1).length) + "|  " + i[a]);
                            var l = i[a].length;
                            if (a === s) {
                                var c = t - (o - l) + 1, d = n > o ? l - c : n - t;
                                r.push("   |  " + Wa(" ", c) + Wa("^", d))
                            } else if (a > s) {
                                if (n > o) {
                                    var u = Math.min(n - o, l);
                                    r.push("   |  " + Wa("^", u))
                                }
                                o += l + 1
                            }
                        }
                        break
                    }
                    return r.join("\n")
                }(n, e.start, e.end), o)
            }) : r("Error compiling template:\n\n" + n + "\n\n" + a.errors.map(function (e) {
                return "- " + e
            }).join("\n") + "\n", o)), a.tips && a.tips.length && (i.outputSourceRange ? a.tips.forEach(function (e) {
                return de(e.msg, o)
            }) : a.tips.forEach(function (e) {
                return de(e, o)
            }));
            var l = {}, c = [];
            return l.render = Ba(a.render, c), l.staticRenderFns = a.staticRenderFns.map(function (e) {
                return Ba(e, c)
            }), a.errors && a.errors.length || !c.length || r("Failed to generate render function:\n\n" + c.map(function (e) {
                var t = e.err, n = e.code;
                return t.toString() + " in\n\n" + n + "\n"
            }).join("\n"), o), t[s] = l
        }
    }

    var Ya, Va, Xa = (Ya = function (e, t) {
        var n = Bs(e.trim(), t);
        !1 !== t.optimize && sa(n, t);
        var i = ba(n, t);
        return {ast: n, render: i.render, staticRenderFns: i.staticRenderFns}
    }, function (e) {
        function t(t, n) {
            var i = Object.create(e), o = [], r = [], s = function (e, t, n) {
                (n ? r : o).push(e)
            };
            if (n) {
                if (n.outputSourceRange) {
                    var a = t.match(/^\s*/)[0].length;
                    s = function (e, t, n) {
                        var i = {msg: e};
                        t && (null != t.start && (i.start = t.start + a), null != t.end && (i.end = t.end + a)), (n ? r : o).push(i)
                    }
                }
                for (var l in n.modules && (i.modules = (e.modules || []).concat(n.modules)), n.directives && (i.directives = E(Object.create(e.directives || null), n.directives)), n) "modules" !== l && "directives" !== l && (i[l] = n[l])
            }
            i.warn = s;
            var c = Ya(t.trim(), i);
            return Pa(c.ast, s), c.errors = o, c.tips = r, c
        }

        return {compile: t, compileToFunctions: Ua(t)}
    })(oa), Ja = (Xa.compile, Xa.compileToFunctions);

    function Ga(e) {
        return (Va = Va || document.createElement("div")).innerHTML = e ? '<a href="\n"/>' : '<div a="\n"/>', Va.innerHTML.indexOf("&#10;") > 0
    }

    var Qa = !!Y && Ga(!1), Ka = !!Y && Ga(!0), Za = w(function (e) {
        var t = $i(e);
        return t && t.innerHTML
    }), el = Gn.prototype.$mount;
    return Gn.prototype.$mount = function (e, t) {
        if ((e = e && $i(e)) === document.body || e === document.documentElement) return ce("Do not mount Vue to <html> or <body> - mount to normal elements instead."), this;
        var n = this.$options;
        if (!n.render) {
            var i = n.template;
            if (i) if ("string" == typeof i) "#" === i.charAt(0) && ((i = Za(i)) || ce("Template element not found or is empty: " + n.template, this)); else {
                if (!i.nodeType) return ce("invalid template option:" + i, this), this;
                i = i.innerHTML
            } else e && (i = function (e) {
                if (e.outerHTML) return e.outerHTML;
                var t = document.createElement("div");
                return t.appendChild(e.cloneNode(!0)), t.innerHTML
            }(e));
            if (i) {
                F.performance && ot && ot("compile");
                var o = Ja(i, {
                    outputSourceRange: !0,
                    shouldDecodeNewlines: Qa,
                    shouldDecodeNewlinesForHref: Ka,
                    delimiters: n.delimiters,
                    comments: n.comments
                }, this), r = o.render, s = o.staticRenderFns;
                n.render = r, n.staticRenderFns = s, F.performance && ot && (ot("compile end"), rt("vue " + this._name + " compile", "compile", "compile end"))
            }
        }
        return el.call(this, e, t)
    }, Gn.compile = Ja, Gn
});
