(function (e) {
    e.fn.block = function () {

    },
        e.fn.mDatatable = function (t) {
            if (!e(this).hasClass("m-datatable--loaded")) {
                if (0 === e(this).length) throw new Error("No mDatatable element exist.");
                if ("" === e(this).attr("id")) throw new Error("ID is required.");
                var a = this;
                a.debug = !1;
                var n = {
                    offset: 110, stateId: "m-meta", init: function (t) {
                        return n.setupBaseDOM.call(), n.setupDOM(a.table), o.setDataSourceQuery(o.getOption("data.source.read.params.query")), e(a).on("m-datatable--on-layout-updated", n.afterRender), a.debug && n.stateRemove(n.stateId), "remote" !== t.data.type && "local" !== t.data.type || ((!1 === t.data.saveState || !1 === t.data.saveState.cookie && !1 === t.data.saveState.webstorage) && n.stateRemove(n.stateId), "local" === t.data.type && "object" == typeof t.data.source && (null === t.data.source && n.extractTable(), a.dataSet = a.originalDataSet = n.dataMapCallback(t.data.source)), n.dataRender()), n.setHeadTitle.call(), n.setHeadTitle.call(this, a.tableFoot), null === t.data.type && (n.setupCellField.call(), n.setupTemplateCell.call(), n.setupSystemColumn.call()), void 0 !== t.layout.header && !1 === t.layout.header && e(a.table).find("thead").remove(), void 0 !== t.layout.footer && !1 === t.layout.footer && e(a.table).find("tfoot").remove(), null !== t.data.type && "local" !== t.data.type || n.layoutUpdate(), e(window).resize(n.fullRender), e(a).height(""), e(o.getOption("search.input")).on("keyup", function (t) {
                            o.search(e(this).val().toLowerCase())
                        }), a
                    }, extractTable: function () {
                        var n = [], o = e(a).find("tr:first-child th").get().map(function (a, o) {
                            var i = e(a).data("field");
                            void 0 === i && (i = e(a).text());
                            var l = {field: i, title: i};
                            for (var r in t.columns) t.columns[r].field === i && (l = e.extend(!0, {}, t.columns[r], l));
                            return n.push(l), i
                        });
                        t.columns = n;
                        var i = e(a).find("tr").get().map(function (t) {
                            return e(t).find("td").get().map(function (t, a) {
                                return e(t).html()
                            })
                        }), l = [];
                        e.each(i, function (t, a) {
                            if (0 !== a.length) {
                                var n = {};
                                e.each(a, function (e, t) {
                                    n[o[e]] = t
                                }), l.push(n)
                            }
                        }), t.data.source = l
                    }, layoutUpdate: function () {
                        n.setupSubDatatable.call(), n.setupSystemColumn.call(), n.columnHide.call(), n.sorting.call(), n.setupHover.call(), void 0 === t.detail && 1 === n.getDepth() && n.lockTable.call(), e(a).trigger("m-datatable--on-layout-updated", {table: e(a.table).attr("id")})
                    }, lockTable: function () {
                        var o = {
                            lockEnabled: !1, init: function () {
                                o.lockEnabled = e.grep(t.columns, function (e, t) {
                                    return void 0 !== e.locked && !1 !== e.locked
                                }), 0 !== o.lockEnabled.length && (n.isLocked() || (a.oriTable = e(a.table).clone()), o.enable())
                            }, enable: function () {
                                e(a.table).find("thead,tbody,tfoot").each(function () {
                                    var t = this;
                                    0 === e(this).find(".m-datatable__lock").length && e(this).ready(function () {
                                        !function (t) {
                                            var i = o.lockEnabledColumns();
                                            if (0 !== i.left.length || 0 !== i.right.length) if (e(t).find(".m-datatable__lock").length > 0) n.log("Locked container already exist in: ", t); else if (0 !== e(t).find(".m-datatable__row").length) {
                                                var l = e("<div/>").addClass("m-datatable__lock m-datatable__lock--left"),
                                                    r = e("<div/>").addClass("m-datatable__lock m-datatable__lock--scroll"),
                                                    s = e("<div/>").addClass("m-datatable__lock m-datatable__lock--right");
                                                e(t).find(".m-datatable__row").each(function () {
                                                    var t = e("<tr/>").addClass("m-datatable__row").appendTo(l),
                                                        a = e("<tr/>").addClass("m-datatable__row").appendTo(r),
                                                        n = e("<tr/>").addClass("m-datatable__row").appendTo(s);
                                                    e(this).find(".m-datatable__cell").each(function () {
                                                        var o = e(this).data("locked");
                                                        void 0 !== o ? (void 0 === o.left && !0 !== o || e(this).appendTo(t), void 0 !== o.right && e(this).appendTo(n)) : e(this).appendTo(a)
                                                    }), e(this).remove()
                                                }), i.left.length > 0 && (e(a.wrap).addClass("m-datatable--lock"), e(l).appendTo(t)), (i.left.length > 0 || i.right.length > 0) && e(r).appendTo(t), i.right.length > 0 && (e(a.wrap).addClass("m-datatable--lock"), e(s).appendTo(t))
                                            } else n.log("No row exist in: ", t)
                                        }(t)
                                    })
                                })
                            }, lockEnabledColumns: function () {
                                var a = e(window).width(), n = t.columns, o = {left: [], right: []};
                                return e.each(n, function (e, t) {
                                    void 0 !== t.locked && (void 0 !== t.locked.left && mUtil.getBreakpoint(t.locked.left) <= a && o.left.push(t.locked.left), void 0 !== t.locked.right && mUtil.getBreakpoint(t.locked.right) <= a && o.right.push(t.locked.right))
                                }), o
                            }
                        };
                        return o.init(), o
                    }, fullRender: function () {
                        if (n.spinnerCallback(!0), e(a.wrap).removeClass("m-datatable--loaded"), n.isLocked()) {
                            var t = e(a.oriTable).children();
                            t.length > 0 && (e(a.wrap).removeClass("m-datatable--lock"), e(a.table).empty().html(t), a.oriTable = null, n.setupCellField.call(), o.redraw()), n.updateTableComponents.call()
                        }
                        n.insertData()
                    }, afterRender: function (t, i) {
                        i.table === e(a.table).attr("id") && (n.isLocked() || o.redraw(), e(a).ready(function () {
                            e(a.tableBody).find(".m-datatable__row:even").addClass("m-datatable__row--even"), n.isLocked() && o.redraw(), e(a.tableBody).css("visibility", ""), e(a.wrap).addClass("m-datatable--loaded"), n.scrollbar.call(), n.spinnerCallback(!1)
                        }))
                    }, setupHover: function () {
                        e(a.tableBody).find(".m-datatable__cell").off("mouseenter", "mouseleave").on("mouseenter", function () {
                            var t = e(this).closest(".m-datatable__row").addClass("m-datatable__row--hover"),
                                a = e(t).index() + 1;
                            e(t).closest(".m-datatable__lock").parent().find(".m-datatable__row:nth-child(" + a + ")").addClass("m-datatable__row--hover")
                        }).on("mouseleave", function () {
                            var t = e(this).closest(".m-datatable__row").removeClass("m-datatable__row--hover"),
                                a = e(t).index() + 1;
                            e(t).closest(".m-datatable__lock").parent().find(".m-datatable__row:nth-child(" + a + ")").removeClass("m-datatable__row--hover")
                        })
                    }, adjustLockContainer: function () {
                        if (!n.isLocked()) return 0;
                        var t = e(a.tableHead).width(), o = e(a.tableHead).find(".m-datatable__lock--left").width(),
                            i = e(a.tableHead).find(".m-datatable__lock--right").width();
                        void 0 === o && (o = 0), void 0 === i && (i = 0);
                        var l = Math.floor(t - o - i);
                        return e(a.table).find(".m-datatable__lock--scroll").css("width", l), l
                    }, dragResize: function () {
                        var t, n, o = !1, i = void 0;
                        e(a.tableHead).find(".m-datatable__cell").mousedown(function (a) {
                            i = e(this), o = !0, t = a.pageX, n = e(this).width(), e(i).addClass("m-datatable__cell--resizing")
                        }).mousemove(function (l) {
                            if (o) {
                                var r = e(i).index(), s = e(a.tableBody), d = e(i).closest(".m-datatable__lock");
                                if (d) {
                                    var c = e(d).index();
                                    s = e(a.tableBody).find(".m-datatable__lock").eq(c)
                                }
                                e(s).find(".m-datatable__row").each(function (a, o) {
                                    e(o).find(".m-datatable__cell").eq(r).width(n + (l.pageX - t)).children().width(n + (l.pageX - t))
                                }), e(i).children().width(n + (l.pageX - t))
                            }
                        }).mouseup(function () {
                            e(i).removeClass("m-datatable__cell--resizing"), o = !1
                        }), e(document).mouseup(function () {
                            e(i).removeClass("m-datatable__cell--resizing"), o = !1
                        })
                    }, initHeight: function () {
                        if (t.layout.height && t.layout.scroll) {
                            var n = e(a.tableHead).find(".m-datatable__row").height(),
                                o = e(a.tableFoot).find(".m-datatable__row").height(), i = t.layout.height;
                            void 0 !== n && (i -= n), void 0 !== o && (i -= o), e(a.tableBody).css("max-height", i)
                        }
                    }, setupBaseDOM: function () {
                        a.old = e(a).clone(), "TABLE" === e(a).prop("tagName") ? (a.table = e(a).removeClass("m-datatable").addClass("m-datatable__table"), 0 === e(a.table).parents(".m-datatable").length && (a.table.wrap(e("<div/>").addClass("m-datatable").addClass("m-datatable--" + t.layout.theme)), a.wrap = e(a.table).parent())) : (a.wrap = e(a).addClass("m-datatable").addClass("m-datatable--" + t.layout.theme), a.table = e("<table/>").addClass("m-datatable__table").appendTo(a)), void 0 !== t.layout.class && e(a.wrap).addClass(t.layout.class), e(a.table).removeClass("m-datatable--destroyed").css("display", "block").attr("id", mUtil.getUniqueID("m-datatable--")), o.getOption("layout.height") && e(a.table).css("max-height", o.getOption("layout.height")), null === t.data.type && e(a.table).css("width", "").css("display", ""), a.tableHead = e(a.table).find("thead"), 0 === e(a.tableHead).length && (a.tableHead = e("<thead/>").prependTo(a.table)), a.tableBody = e(a.table).find("tbody"), 0 === e(a.tableBody).length && (a.tableBody = e("<tbody/>").appendTo(a.table)), void 0 !== t.layout.footer && t.layout.footer && (a.tableFoot = e(a.table).find("tfoot"), 0 === e(a.tableFoot).length && (a.tableFoot = e("<tfoot/>").appendTo(a.table)))
                    }, setupCellField: function (n) {
                        void 0 === n && (n = e(a.table).children());
                        var o = t.columns;
                        e.each(n, function (t, a) {
                            e(a).find(".m-datatable__row").each(function (t, a) {
                                e(a).find(".m-datatable__cell").each(function (t, a) {
                                    void 0 !== o[t] && e(a).data(o[t])
                                })
                            })
                        })
                    }, setupTemplateCell: function (i) {
                        void 0 === i && (i = a.tableBody);
                        var l = t.columns;
                        e(i).find(".m-datatable__row").each(function (t, i) {
                            var r = e(i).data("obj") || {}, s = o.getOption("rows.callback");
                            "function" == typeof s && s(i, r, t), r.getIndex = function () {
                                return t
                            }, r.getDatatable = function () {
                                return a
                            }, void 0 === r && (r = {}, e(i).find(".m-datatable__cell").each(function (t, a) {
                                var n = e.grep(l, function (t, n) {
                                    return e(a).data("field") === t.field
                                })[0];
                                void 0 !== n && (r[n.field] = e(a).text())
                            })), e(i).find(".m-datatable__cell").each(function (t, a) {
                                var o = e.grep(l, function (t, n) {
                                    return e(a).data("field") === t.field
                                })[0];
                                if (void 0 !== o && void 0 !== o.template) {
                                    var i = "";
                                    "string" == typeof o.template && (i = n.dataPlaceholder(o.template, r)), "function" == typeof o.template && (i = o.template(r));
                                    var s = e("<span/>").append(i);
                                    e(a).html(s), void 0 !== o.overflow && e(s).css("overflow", o.overflow)
                                }
                            })
                        })
                    }, setupSystemColumn: function () {
                        if (a.dataSet = a.dataSet || [], 0 !== a.dataSet.length) {
                            var n = t.columns;
                            e(a.tableBody).find(".m-datatable__row").each(function (t, a) {
                                e(a).find(".m-datatable__cell").each(function (t, a) {
                                    var i = e.grep(n, function (t, n) {
                                        return e(a).data("field") === t.field
                                    })[0];
                                    if (void 0 !== i) {
                                        var l = e(a).text();
                                        if (void 0 !== i.selector && !1 !== i.selector) {
                                            if (e(a).find('.m-checkbox [type="checkbox"]').length > 0) return;
                                            e(a).addClass("m-datatable__cell--check");
                                            var r = e("<label/>").addClass("m-checkbox m-checkbox--single").append(e("<input/>").attr("type", "checkbox").attr("value", l).on("click", function () {
                                                e(this).is(":checked") ? o.setActive(this) : o.setInactive(this)
                                            })).append(e("<span/>"));
                                            void 0 !== i.selector.class && e(r).addClass(i.selector.class), e(a).children().html(r)
                                        }
                                        if (void 0 !== i.subtable && i.subtable) {
                                            if (e(a).find(".m-datatable__toggle-subtable").length > 0) return;
                                            e(a).children().html(e("<a/>").addClass("m-datatable__toggle-subtable").attr("href", "#").attr("data-value", l).append(e("<i/>").addClass(o.getOption("layout.icons.rowDetail.collapse"))))
                                        }
                                    }
                                })
                            });
                            var i = function (t) {
                                var a = e.grep(n, function (e, t) {
                                    return void 0 !== e.selector && !1 !== e.selector
                                })[0];
                                if (void 0 !== a && void 0 !== a.selector && !1 !== a.selector) {
                                    var i = e(t).find('[data-field="' + a.field + '"]');
                                    if (e(i).find('.m-checkbox [type="checkbox"]').length > 0) return;
                                    e(i).addClass("m-datatable__cell--check");
                                    var l = e("<label/>").addClass("m-checkbox m-checkbox--single m-checkbox--all").append(e("<input/>").attr("type", "checkbox").on("click", function () {
                                        e(this).is(":checked") ? o.setActiveAll(!0) : o.setActiveAll(!1)
                                    })).append(e("<span/>"));
                                    void 0 !== a.selector.class && e(l).addClass(a.selector.class), e(i).children().html(l)
                                }
                            };
                            void 0 !== t.layout.header && !0 === t.layout.header && i(e(a.tableHead).find(".m-datatable__row").first()), void 0 !== t.layout.footer && !0 === t.layout.footer && i(e(a.tableFoot).find(".m-datatable__row").first())
                        }
                    }, adjustCellsWidth: function () {
                        var t = e(a.tableHead).width(), o = n.getOneRow(a.tableHead, 1).length;
                        if (o > 0) {
                            t -= 20 * o;
                            var i = Math.floor(t / o);
                            i <= n.offset && (i = n.offset), e(a.table).find(".m-datatable__row").find(".m-datatable__cell").each(function (t, a) {
                                var n = i, o = e(a).data("width");
                                void 0 !== o && (n = o), e(a).children().css("width", n)
                            })
                        }
                    }, adjustCellsHeight: function () {
                        e(a.table).find(".m-datatable__row"), e.each(e(a.table).children(), function (t, a) {
                            for (var o = 1; o <= n.getTotalRows(a); o++) {
                                var i = n.getOneRow(a, o, !1);
                                if (e(i).length > 0) {
                                    var l = Math.max.apply(null, e(i).map(function () {
                                        return e(this).height()
                                    }).get());
                                    e(i).css("height", Math.ceil(l))
                                }
                            }
                        })
                    }, setupDOM: function (t) {
                        e(t).find("> thead").addClass("m-datatable__head"), e(t).find("> tbody").addClass("m-datatable__body"), e(t).find("> tfoot").addClass("m-datatable__foot"), e(t).find("tr").addClass("m-datatable__row"), e(t).find("tr > th, tr > td").addClass("m-datatable__cell"), e(t).find("tr > th, tr > td").each(function (t, a) {
                            0 === e(a).find("span").length && e(a).wrapInner(e("<span/>").width(n.offset))
                        })
                    }, scrollbar: function () {
                        var i = {
                            tableLocked: null,
                            mcsOptions: {
                                scrollInertia: 0,
                                autoDraggerLength: !0,
                                autoHideScrollbar: !0,
                                autoExpandScrollbar: !1,
                                alwaysShowScrollbar: 0,
                                mouseWheel: {scrollAmount: 120, preventDefault: !1},
                                advanced: {updateOnContentResize: !0, autoExpandHorizontalScroll: !0},
                                theme: "minimal-dark"
                            },
                            init: function () {
                                var n = mUtil.getViewPort().width;
                                if (t.layout.scroll) {
                                    e(a.wrap).addClass("m-datatable--scroll");
                                    var o = e(a.tableBody).find(".m-datatable__lock--scroll");
                                    e(o).length > 0 ? (i.scrollHead = e(a.tableHead).find("> .m-datatable__lock--scroll > .m-datatable__row"), i.scrollFoot = e(a.tableFoot).find("> .m-datatable__lock--scroll > .m-datatable__row"), i.tableLocked = e(a.tableBody).find(".m-datatable__lock:not(.m-datatable__lock--scroll)"), n > mUtil.getBreakpoint("lg") ? i.mCustomScrollbar(o) : i.defaultScrollbar(o)) : (i.scrollHead = e(a.tableHead).find("> .m-datatable__row"), i.scrollFoot = e(a.tableFoot).find("> .m-datatable__row"), n > mUtil.getBreakpoint("lg") ? i.mCustomScrollbar(a.tableBody) : i.defaultScrollbar(a.tableBody))
                                } else e(a.table).css("height", "auto").css("overflow-x", "auto")
                            },
                            defaultScrollbar: function (t) {
                                e(t).css("overflow", "auto").css("max-height", o.getOption("layout.height")).on("scroll", i.onScrolling)
                            },
                            onScrolling: function (t) {
                                var a = e(this).scrollLeft(), n = e(this).scrollTop();
                                e(i.scrollHead).css("left", -a), e(i.scrollFoot).css("left", -a), e(i.tableLocked).each(function (t, a) {
                                    e(a).css("top", -n)
                                })
                            },
                            mCustomScrollbar: function (t) {
                                var l = "xy";
                                null === o.getOption("layout.height") && (l = "x");
                                var r = e.extend({}, i.mcsOptions, {
                                    axis: l,
                                    setHeight: e(a.tableBody).height(),
                                    callbacks: {
                                        whileScrolling: function () {
                                            var t = this.mcs;
                                            e(i.scrollHead).css("left", t.left), e(i.scrollFoot).css("left", t.left), e(i.tableLocked).each(function (a, n) {
                                                e(n).css("top", t.top)
                                            })
                                        }
                                    }
                                });
                                !0 === o.getOption("layout.smoothScroll.scrollbarShown") && e(t).attr("data-scrollbar-shown", "true"),
                                    n.mCustomScrollbar(t, r),
                                    e(t).mCustomScrollbar("scrollTo", "top")
                            }
                        };
                        return i.init(), i
                    }, mCustomScrollbar: function (t, n) {

                        console.log('ready customscroll');
                        /* e(a.tableBody).css("overflow", ""), 0 === e(t).find(".mCustomScrollbar").length && (e(a.tableBody).hasClass("mCustomScrollbar") && e(a.tableBody).mCustomScrollbar("destroy"), e(t).mCustomScrollbar(n))*/
                    }, setHeadTitle: function (o) {
                        void 0 === o && (o = a.tableHead);
                        var i = t.columns, l = e(o).find(".m-datatable__row"), r = e(o).find(".m-datatable__cell");
                        0 === e(l).length && (l = e("<tr/>").appendTo(o)), e.each(i, function (t, n) {
                            var o = e(r).eq(t);
                            if (0 === e(o).length && (o = e("<th/>").appendTo(l)), void 0 !== n.title && e(o).html(n.title).attr("data-field", n.field).data(n), void 0 !== n.textAlign) {
                                var i = void 0 !== a.textAlign[n.textAlign] ? a.textAlign[n.textAlign] : "";
                                e(o).addClass(i)
                            }
                        }), n.setupDOM(o)
                    }, dataRender: function (i) {
                        e(a.table).siblings(".m-datatable__pager").removeClass("m-datatable--paging-loaded");
                        var l = function (i) {
                            e(a.wrap).removeClass("m-datatable--error"), t.pagination ? t.data.serverPaging && "local" !== t.data.type ? n.paging(n.getObject("meta", i || null)) : n.paging(function () {
                                a.dataSet = a.dataSet || [], n.localDataUpdate();
                                var i = o.getDataSourceParam("pagination");
                                0 === i.perpage && (i.perpage = t.data.pageSize || 10), i.total = a.dataSet.length;
                                var l = Math.max(i.perpage * (i.page - 1), 0), r = Math.min(l + i.perpage, i.total);
                                return a.dataSet = e(a.dataSet).slice(l, r), i
                            }(), function (t, o) {
                                e(t.pager).hasClass("m-datatable--paging-loaded") || (e(t.pager).remove(), t.init(o)), e(t.pager).off().on("m-datatable--on-goto-page", function (a) {
                                    e(t.pager).remove(), t.init(o)
                                });
                                var i = Math.max(o.perpage * (o.page - 1), 0), l = Math.min(i + o.perpage, o.total);
                                n.localDataUpdate(), a.dataSet = e(a.dataSet).slice(i, l), n.insertData()
                            }) : n.localDataUpdate(), n.insertData()
                        };
                        "local" === t.data.type || void 0 === t.data.source.read && null !== a.dataSet || !1 === t.data.serverSorting && "sort" === i ? l() : n.getData().done(l)
                    }, insertData: function () {
                        a.dataSet = a.dataSet || [];
                        var i = o.getDataSourceParam(),
                            l = e("<tbody/>").addClass("m-datatable__body").css("visibility", "hidden");
                        e.each(a.dataSet, function (n, o) {
                            for (var r = e("<tr/>").attr("data-row", n).data("obj", o), s = 0, d = [], c = t.columns.length, u = 0; u < c; u += 1) {
                                var m = t.columns[u], p = [];
                                if (i.sort.field === m.field && p.push("m-datatable__cell--sorted"), void 0 !== m.textAlign) {
                                    var f = void 0 !== a.textAlign[m.textAlign] ? a.textAlign[m.textAlign] : "";
                                    p.push(f)
                                }
                                d[s++] = '<td data-field="' + m.field + '"', d[s++] = ' class="' + p.join(" ") + '"', d[s++] = ">", d[s++] = o[m.field], d[s++] = "</td>"
                            }
                            e(r).append(d.join("")), e(l).append(r)
                        }), 0 === a.dataSet.length && (e("<span/>").addClass("m-datatable--error").width("100%").html(o.getOption("translate.records.noRecords")).appendTo(l), e(a.wrap).addClass("m-datatable--error")), e(a.tableBody).replaceWith(l), a.tableBody = l, n.setupDOM(a.table), n.setupCellField([a.tableBody]), n.setupTemplateCell(a.tableBody), n.layoutUpdate()
                    }, updateTableComponents: function () {
                        a.tableHead = e(a.table).children("thead"), a.tableBody = e(a.table).children("tbody"), a.tableFoot = e(a.table).children("tfoot")
                    }, getData: function () {
                        var i = {dataType: "json", method: "GET", data: {}, timeout: 3e4};
                        return "local" === t.data.type && (i.url = t.data.source), "remote" === t.data.type && (i.url = o.getOption("data.source.read.url"), "string" != typeof i.url && (i.url = o.getOption("data.source.read")), "string" != typeof i.url && (i.url = o.getOption("data.source")), i.headers = o.getOption("data.source.read.headers"), i.data.datatable = o.getDataSourceParam(), i.method = o.getOption("data.source.read.method") || "POST", o.getOption("data.serverPaging") || delete i.data.datatable.pagination, o.getOption("data.serverSorting") || delete i.data.datatable.sort), e.ajax(i).done(function (t, o, i) {
                            a.dataSet = a.originalDataSet = n.dataMapCallback(t), e(a).trigger("m-datatable--on-ajax-done", [a.dataSet])
                        }).fail(function (t, n, i) {
                            e(a).trigger("m-datatable--on-ajax-fail", [t]), e("<span/>").addClass("m-datatable--error").width("100%").html(o.getOption("translate.records.noRecords")).appendTo(a.tableBody), e(a).addClass("m-datatable--error")
                        }).always(function () {
                        })
                    }, paging: function (t, i) {
                        var l = {
                            meta: null,
                            pager: null,
                            paginateEvent: null,
                            pagerLayout: {pagination: null, info: null},
                            callback: null,
                            init: function (t) {
                                l.meta = t, l.meta.pages = Math.max(Math.ceil(l.meta.total / l.meta.perpage), 1), l.meta.page > l.meta.pages && (l.meta.page = l.meta.pages), l.paginateEvent = n.getTablePrefix(), l.pager = e(a.table).siblings(".m-datatable__pager"), e(l.pager).hasClass("m-datatable--paging-loaded") || (e(l.pager).remove(), 0 !== l.meta.pages && (o.setDataSourceParam("pagination", l.meta), l.callback = l.serverCallback, "function" == typeof i && (l.callback = i), l.addPaginateEvent(), l.populate(), l.meta.page = Math.max(l.meta.page || 1, l.meta.page), e(a).trigger(l.paginateEvent, l.meta), l.pagingBreakpoint.call(), e(window).resize(l.pagingBreakpoint)))
                            },
                            serverCallback: function (e, t) {
                                n.dataRender()
                            },
                            populate: function () {
                                var t = o.getOption("layout.icons.pagination"),
                                    n = o.getOption("translate.toolbar.pagination.items.default");
                                l.pager = e("<div/>").addClass("m-datatable__pager m-datatable--paging-loaded clearfix");
                                var i = e("<ul/>").addClass("m-datatable__pager-nav");
                                l.pagerLayout.pagination = i, e("<li/>").append(e("<a/>").attr("title", n.first).addClass("m-datatable__pager-link m-datatable__pager-link--first").append(e("<i/>").addClass(t.first)).on("click", l.gotoMorePage).attr("data-page", 1)).appendTo(i), e("<li/>").append(e("<a/>").attr("title", n.prev).addClass("m-datatable__pager-link m-datatable__pager-link--prev").append(e("<i/>").addClass(t.prev)).on("click", l.gotoMorePage)).appendTo(i), e("<li/>").append(e("<a/>").attr("title", n.more).addClass("m-datatable__pager-link m-datatable__pager-link--more-prev").html(e("<i/>").addClass(t.more)).on("click", l.gotoMorePage)).appendTo(i), e("<li/>").append(e("<input/>").attr("type", "text").addClass("m-pager-input form-control").attr("title", n.input).on("keyup", function () {
                                    e(this).attr("data-page", Math.abs(e(this).val()))
                                }).on("keypress", function (e) {
                                    13 === e.which && l.gotoMorePage(e)
                                })).appendTo(i);
                                var r = o.getOption("toolbar.items.pagination.pages.desktop.pagesNumber"),
                                    s = Math.ceil(l.meta.page / r) * r, d = s - r;
                                s > l.meta.pages && (s = l.meta.pages);
                                for (var c = d; c < s; c++) {
                                    var u = c + 1;
                                    e("<li/>").append(e("<a/>").addClass("m-datatable__pager-link m-datatable__pager-link-number").text(u).attr("data-page", u).attr("title", u).on("click", l.gotoPage)).appendTo(i)
                                }
                                e("<li/>").append(e("<a/>").attr("title", n.more).addClass("m-datatable__pager-link m-datatable__pager-link--more-next").html(e("<i/>").addClass(t.more)).on("click", l.gotoMorePage)).appendTo(i), e("<li/>").append(e("<a/>").attr("title", n.next).addClass("m-datatable__pager-link m-datatable__pager-link--next").append(e("<i/>").addClass(t.next)).on("click", l.gotoMorePage)).appendTo(i), e("<li/>").append(e("<a/>").attr("title", n.last).addClass("m-datatable__pager-link m-datatable__pager-link--last").append(e("<i/>").addClass(t.last)).on("click", l.gotoMorePage).attr("data-page", l.meta.pages)).appendTo(i), o.getOption("toolbar.items.info") && (l.pagerLayout.info = e("<div/>").addClass("m-datatable__pager-info").append(e("<span/>").addClass("m-datatable__pager-detail"))), e.each(o.getOption("toolbar.layout"), function (t, a) {
                                    e(l.pagerLayout[a]).appendTo(l.pager)
                                });
                                var m = e("<select/>").addClass("selectpicker m-datatable__pager-size").attr("title", o.getOption("translate.toolbar.pagination.items.default.select")).attr("data-width", "70px").val(l.meta.perpage).on("change", l.updatePerpage).prependTo(l.pagerLayout.info);
                                e.each(o.getOption("toolbar.items.pagination.pageSizeSelect"), function (t, a) {
                                    var n = a;
                                    -1 === a && (n = "All"), e("<option/>").attr("value", a).html(n).appendTo(m)
                                }), e(a).ready(function () {

                                    e(".selectpicker").selectpicker().siblings(".dropdown-toggle").attr("title", o.getOption("translate.toolbar.pagination.items.default.select"))
                                }), l.paste()
                            },
                            paste: function () {
                                e.each(e.unique(o.getOption("toolbar.placement")), function (t, n) {
                                    "bottom" === n && e(l.pager).clone(!0).insertAfter(a.table), "top" === n && e(l.pager).clone(!0).addClass("m-datatable__pager--top").insertBefore(a.table)
                                })
                            },
                            gotoMorePage: function (t) {
                                if (t.preventDefault(), "disabled" === e(this).attr("disabled")) return !1;
                                var a = e(this).attr("data-page");
                                return void 0 === a && (a = e(t.target).attr("data-page")), l.openPage(parseInt(a)), !1
                            },
                            gotoPage: function (t) {
                                t.preventDefault(), e(this).hasClass("m-datatable__pager-link--active") || l.openPage(parseInt(e(this).data("page")))
                            },
                            openPage: function (t) {
                                l.meta.page = parseInt(t), e(a).trigger(l.paginateEvent, l.meta), l.callback(l, l.meta), e(l.pager).trigger("m-datatable--on-goto-page", l.meta)
                            },
                            updatePerpage: function (t) {
                                t.preventDefault(), null === o.getOption("layout.height") && e("html, body").animate({scrollTop: e(a).position().top}), l.pager = e(a.table).siblings(".m-datatable__pager").removeClass("m-datatable--paging-loaded"), t.originalEvent && (l.meta.perpage = parseInt(e(this).val())), e(l.pager).find("select.m-datatable__pager-size").val(l.meta.perpage).attr("data-selected", l.meta.perpage), o.setDataSourceParam("pagination", l.meta), e(l.pager).trigger("m-datatable--on-update-perpage", l.meta), e(a).trigger(l.paginateEvent, l.meta), l.callback(l, l.meta), l.updateInfo.call()
                            },
                            addPaginateEvent: function (t) {
                                e(a).off(l.paginateEvent).on(l.paginateEvent, function (t, i) {
                                    n.spinnerCallback(!0), l.pager = e(a.table).siblings(".m-datatable__pager");
                                    var r = e(l.pager).find(".m-datatable__pager-nav");
                                    e(r).find(".m-datatable__pager-link--active").removeClass("m-datatable__pager-link--active"), e(r).find('.m-datatable__pager-link-number[data-page="' + i.page + '"]').addClass("m-datatable__pager-link--active"), e(r).find(".m-datatable__pager-link--prev").attr("data-page", Math.max(i.page - 1, 1)), e(r).find(".m-datatable__pager-link--next").attr("data-page", Math.min(i.page + 1, i.pages)), e(l.pager).each(function () {
                                        e(this).find('.m-pager-input[type="text"]').prop("value", i.page)
                                    }), e(l.pager).find(".m-datatable__pager-nav").show(), i.pages <= 1 && e(l.pager).find(".m-datatable__pager-nav").hide(), o.setDataSourceParam("pagination", l.meta), e(l.pager).find("select.m-datatable__pager-size").val(i.perpage).attr("data-selected", i.perpage), e(a.table).find('.m-checkbox > [type="checkbox"]').prop("checked", !1), e(a.table).find(".m-datatable__row--active").removeClass("m-datatable__row--active"), l.updateInfo.call(), l.pagingBreakpoint.call()
                                })
                            },
                            updateInfo: function () {
                                var t = Math.max(l.meta.perpage * (l.meta.page - 1) + 1, 1),
                                    a = Math.min(t + l.meta.perpage - 1, l.meta.total);
                                e(l.pager).find(".m-datatable__pager-info").find(".m-datatable__pager-detail").html(n.dataPlaceholder(o.getOption("translate.toolbar.pagination.items.info"), {
                                    start: t,
                                    end: -1 === l.meta.perpage ? l.meta.total : a,
                                    pageSize: -1 === l.meta.perpage || l.meta.perpage >= l.meta.total ? l.meta.total : l.meta.perpage,
                                    total: l.meta.total
                                }))
                            },
                            pagingBreakpoint: function () {
                                var t = e(a.table).siblings(".m-datatable__pager").find(".m-datatable__pager-nav");
                                if (0 !== e(t).length) {
                                    var n = o.getCurrentPage(), i = e(t).find(".m-pager-input").closest("li");
                                    e(t).find("li").show(), e.each(o.getOption("toolbar.items.pagination.pages"), function (a, r) {
                                        if (mUtil.isInResponsiveRange(a)) {
                                            switch (a) {
                                                case"desktop":
                                                case"tablet":
                                                    Math.ceil(n / r.pagesNumber), r.pagesNumber, r.pagesNumber;
                                                    e(i).hide(), l.meta = o.getDataSourceParam("pagination"), l.paginationUpdate();
                                                    break;
                                                case"mobile":
                                                    e(i).show(), e(t).find(".m-datatable__pager-link--more-prev").closest("li").hide(), e(t).find(".m-datatable__pager-link--more-next").closest("li").hide(), e(t).find(".m-datatable__pager-link-number").closest("li").hide()
                                            }
                                            return !1
                                        }
                                    })
                                }
                            },
                            paginationUpdate: function () {
                                var t = e(a.table).siblings(".m-datatable__pager").find(".m-datatable__pager-nav"),
                                    n = e(t).find(".m-datatable__pager-link--more-prev"),
                                    i = e(t).find(".m-datatable__pager-link--more-next"),
                                    r = e(t).find(".m-datatable__pager-link--first"),
                                    s = e(t).find(".m-datatable__pager-link--prev"),
                                    d = e(t).find(".m-datatable__pager-link--next"),
                                    c = e(t).find(".m-datatable__pager-link--last"),
                                    u = e(t).find(".m-datatable__pager-link-number"),
                                    m = Math.max(e(u).first().data("page") - 1, 1);
                                e(n).each(function (t, a) {
                                    e(a).attr("data-page", m)
                                }), 1 === m ? e(n).parent().hide() : e(n).parent().show();
                                var p = Math.min(e(u).last().data("page") + 1, l.meta.pages);
                                e(i).each(function (t, a) {
                                    e(i).attr("data-page", p).show()
                                }), p === l.meta.pages && p === e(u).last().data("page") ? e(i).parent().hide() : e(i).parent().show(), 1 === l.meta.page ? (e(r).attr("disabled", !0).addClass("m-datatable__pager-link--disabled"), e(s).attr("disabled", !0).addClass("m-datatable__pager-link--disabled")) : (e(r).removeAttr("disabled").removeClass("m-datatable__pager-link--disabled"), e(s).removeAttr("disabled").removeClass("m-datatable__pager-link--disabled")), l.meta.page === l.meta.pages ? (e(d).attr("disabled", !0).addClass("m-datatable__pager-link--disabled"), e(c).attr("disabled", !0).addClass("m-datatable__pager-link--disabled")) : (e(d).removeAttr("disabled").removeClass("m-datatable__pager-link--disabled"), e(c).removeAttr("disabled").removeClass("m-datatable__pager-link--disabled"));
                                var f = o.getOption("toolbar.items.pagination.navigation");
                                f.first || e(r).remove(), f.prev || e(s).remove(), f.next || e(d).remove(), f.last || e(c).remove()
                            }
                        };
                        return l.init(t), l
                    }, columnHide: function () {
                        var n = mUtil.getViewPort().width;
                        e.each(t.columns, function (t, o) {
                            if (void 0 !== o.responsive) {
                                var i = o.field, l = e.grep(e(a.table).find(".m-datatable__cell"), function (t, a) {
                                    return i === e(t).data("field")
                                });
                                mUtil.getBreakpoint(o.responsive.hidden) >= n ? e(l).hide() : e(l).show(), mUtil.getBreakpoint(o.responsive.visible) <= n ? e(l).show() : e(l).hide()
                            }
                        })
                    }, setupSubDatatable: function () {
                        var i = o.getOption("detail.content");
                        if ("function" == typeof i) {
                            if (e(a.table).find(".m-datatable__detail").length > 0) return;
                            e(a.wrap).addClass("m-datatable--subtable"), t.columns[0].subtable = !0;
                            var l = function (n) {
                                n.preventDefault();
                                var l = e(this).closest(".m-datatable__row"), r = e(l).next().toggle(),
                                    s = e(this).closest("[data-field]:first-child").find(".m-datatable__toggle-subtable").data("value"),
                                    d = e(this).find("i").removeAttr("class");
                                e(r).is(":hidden") ? (e(d).addClass(o.getOption("layout.icons.rowDetail.collapse")), e(l).removeClass("m-datatable__row--detail-expanded"), e(a).trigger("m-datatable--on-collapse-detail", [l])) : (e(d).addClass(o.getOption("layout.icons.rowDetail.expand")), e(l).addClass("m-datatable__row--detail-expanded"), e(a).trigger("m-datatable--on-expand-detail", [l]), e.map(a.dataSet, function (e, a) {
                                    return s === e[t.columns[0].field] && (n.data = e, !0)
                                }), n.detailCell = e(r).find(".m-datatable__detail"), 0 === e(n.detailCell).find(".m-datatable").length && i(n))
                            }, r = t.columns;
                            e(a.tableBody).find(".m-datatable__row").each(function (t, a) {
                                e(a).find(".m-datatable__cell").each(function (t, a) {
                                    var n = e.grep(r, function (t, n) {
                                        return e(a).data("field") === t.field
                                    })[0];
                                    if (void 0 !== n) {
                                        var i = e(a).text();
                                        if (void 0 !== n.subtable && n.subtable) {
                                            if (e(a).find(".m-datatable__toggle-subtable").length > 0) return;
                                            e(a).children().html(e("<a/>").addClass("m-datatable__toggle-subtable").attr("href", "#").attr("data-value", i).attr("title", o.getOption("detail.title")).on("click", l).append(e("<i/>").addClass(o.getOption("layout.icons.rowDetail.collapse"))))
                                        }
                                    }
                                })
                            }), e(a.tableBody).find(".m-datatable__row").each(function () {
                                var t = e("<tr/>").addClass("m-datatable__row-detail").hide().append(e("<td/>").addClass("m-datatable__detail").attr("colspan", n.getTotalColumns()));
                                e(this).after(t), e(this).hasClass("m-datatable__row--even") && e(t).addClass("m-datatable__row-detail--even")
                            })
                        }
                    }, dataMapCallback: function (e) {
                        var t = e;
                        return "function" == typeof o.getOption("data.source.read.map") ? o.getOption("data.source.read.map")(e) : (void 0 !== e.data && (t = e.data), t)
                    }, isSpinning: !1, spinnerCallback: function (e) {
                        if (e) {
                            if (!n.isSpinning) {
                                var t = o.getOption("layout.spinner");
                                !0 === t.message && (t.message = o.getOption("translate.records.processing")), n.isSpinning = !0, void 0 !== mApp && mApp.block(a, t)
                            }
                        } else n.isSpinning = !1, void 0 !== mApp && mApp.unblock(a)
                    }, sortCallback: function (t, a, n) {
                        var o = n.type || "string", i = n.format || "", l = n.field;
                        if ("date" === o && "undefined" == typeof moment) throw new Error("Moment.js is required.");
                        return e(t).sort(function (e, t) {
                            var n = e[l], r = t[l];
                            switch (o) {
                                case"date":
                                    var s = moment(n, i).diff(moment(r, i));
                                    return "asc" === a ? s > 0 ? 1 : s < 0 ? -1 : 0 : s < 0 ? 1 : s > 0 ? -1 : 0;
                                case"number":
                                    return isNaN(parseFloat(n)) && null != n && (n = Number(n.replace(/[^0-9\.-]+/g, ""))), isNaN(parseFloat(r)) && null != r && (r = Number(r.replace(/[^0-9\.-]+/g, ""))), n = parseFloat(n), r = parseFloat(r), "asc" === a ? n > r ? 1 : n < r ? -1 : 0 : n < r ? 1 : n > r ? -1 : 0;
                                case"string":
                                default:
                                    return "asc" === a ? n > r ? 1 : n < r ? -1 : 0 : n < r ? 1 : n > r ? -1 : 0
                            }
                        })
                    }, log: function (e, t) {
                        void 0 === t && (t = ""), a.debug && console.log(e, t)
                    }, isLocked: function () {
                        return e(a.wrap).hasClass("m-datatable--lock") || !1
                    }, replaceTableContent: function (t, n) {
                        void 0 === n && (n = a.tableBody), e(n).hasClass("mCustomScrollbar") ? e(n).find(".mCSB_container").html(t) : e(n).html(t)
                    }, getExtraSpace: function (t) {
                        return parseInt(e(t).css("paddingRight")) + parseInt(e(t).css("paddingLeft")) + (parseInt(e(t).css("marginRight")) + parseInt(e(t).css("marginLeft"))) + Math.ceil(e(t).css("border-right-width").replace("px", ""))
                    }, dataPlaceholder: function (t, a) {
                        var n = t;
                        return e.each(a, function (e, t) {
                            n = n.replace("{{" + e + "}}", t)
                        }), n
                    }, getTableId: function (t) {
                        return void 0 === t && (t = ""), e(a).attr("id") + t
                    }, getTablePrefix: function (e) {
                        return void 0 !== e && (e = "-" + e), "m-datatable__" + n.getTableId() + "-" + n.getDepth() + e
                    }, getDepth: function () {
                        var t = 0, n = a.table;
                        do {
                            n = e(n).parents(".m-datatable__table"), t++
                        } while (e(n).length > 0);
                        return t
                    }, stateKeep: function (e, t) {
                        e = n.getTablePrefix(e), !1 !== o.getOption("data.saveState") && (o.getOption("data.saveState.webstorage") && localStorage && localStorage.setItem(e, JSON.stringify(t)), o.getOption("data.saveState.cookie") && Cookies.set(e, JSON.stringify(t)))
                    }, stateGet: function (e, t) {
                        if (e = n.getTablePrefix(e), !1 !== o.getOption("data.saveState")) {
                            var a = null;
                            return void 0 !== (a = o.getOption("data.saveState.webstorage") && localStorage ? localStorage.getItem(e) : Cookies.get(e)) && null !== a ? JSON.parse(a) : void 0
                        }
                    }, stateUpdate: function (t, a) {
                        var o = n.stateGet(t);
                        void 0 !== o && null !== o || (o = {}), n.stateKeep(t, e.extend({}, o, a))
                    }, stateRemove: function (e) {
                        e = n.getTablePrefix(e), localStorage && localStorage.removeItem(e), Cookies.remove(e)
                    }, getTotalColumns: function (t) {
                        return void 0 === t && (t = a.tableBody), e(t).find(".m-datatable__row").first().find(".m-datatable__cell").length
                    }, getTotalRows: function (t) {
                        return void 0 === t && (t = a.tableBody), e(t).find(".m-datatable__row").first().parent().find(".m-datatable__row").length
                    }, getOneRow: function (t, a, n) {
                        void 0 === n && (n = !0);
                        var o = e(t).find(".m-datatable__row:not(.m-datatable__row-detail):nth-child(" + a + ")");
                        return n && (o = o.find(".m-datatable__cell")), o
                    }, hasOverflowCells: function (t) {
                        var a = e(t).find("tr:first-child").find(".m-datatable__cell"), n = 0;
                        return a.length > 0 && (e(a).each(function (t, a) {
                            n += Math.ceil(e(a).innerWidth())
                        }), n >= e(t).outerWidth())
                    }, hasOverflowX: function (t) {
                        var a = e(t).find("*");
                        if (a.length > 0) {
                            return Math.max.apply(null, e(a).map(function () {
                                return e(this).outerWidth(!0)
                            }).get()) > e(t).width()
                        }
                        return !1
                    }, hasOverflowY: function (t) {
                        var a = e(t).find(".m-datatable__row"), n = 0;
                        return a.length > 0 && (e(a).each(function (t, a) {
                            n += Math.floor(e(a).innerHeight())
                        }), n > e(t).innerHeight())
                    }, sortColumn: function (t, n, o) {
                        void 0 === n && (n = "asc"), void 0 === o && (o = !1);
                        var i = e(t).index(), l = e(a.tableBody).find(".m-datatable__row"),
                            r = e(t).closest(".m-datatable__lock").index();
                        -1 !== r && (l = e(a.tableBody).find(".m-datatable__lock:nth-child(" + (r + 1) + ")").find(".m-datatable__row"));
                        var s = e(l).parent();
                        e(l).sort(function (t, a) {
                            var l = e(t).find("td:nth-child(" + i + ")").text(),
                                r = e(a).find("td:nth-child(" + i + ")").text();
                            return o && (l = parseInt(l), r = parseInt(r)), "asc" === n ? l > r ? 1 : l < r ? -1 : 0 : l < r ? 1 : l > r ? -1 : 0
                        }).appendTo(s)
                    }, sorting: function () {
                        var i = {
                            init: function () {
                                t.sortable && (e(a.tableHead).find(".m-datatable__cell:not(.m-datatable__cell--check)").addClass("m-datatable__cell--sort").off("click").on("click", i.sortClick), i.setIcon())
                            }, setIcon: function () {
                                var t = o.getDataSourceParam("sort"),
                                    n = e(a.tableHead).find('.m-datatable__cell[data-field="' + t.field + '"]').attr("data-sort", t.sort),
                                    i = e(n).find("span"), l = e(i).find("i"), r = o.getOption("layout.icons.sort");
                                e(l).length > 0 ? e(l).removeAttr("class").addClass(r[t.sort]) : e(i).append(e("<i/>").addClass(r[t.sort]))
                            }, sortClick: function (l) {
                                var r = o.getDataSourceParam("sort"), s = e(this).data("field"),
                                    d = n.getColumnByField(s);
                                if ((void 0 === d.sortable || !1 !== d.sortable) && (e(a.tableHead).find(".m-datatable__cell > span > i").remove(), t.sortable)) {
                                    n.spinnerCallback(!0);
                                    var c = "desc";
                                    r.field === s && (c = r.sort), r = {
                                        field: s,
                                        sort: c = void 0 === c || "desc" === c ? "asc" : "desc"
                                    }, o.setDataSourceParam("sort", r), i.setIcon(), setTimeout(function () {
                                        n.dataRender("sort"), e(a).trigger("m-datatable--on-sort", r)
                                    }, 300)
                                }
                            }
                        };
                        i.init()
                    }, localDataUpdate: function () {
                        var t = o.getDataSourceParam();
                        void 0 === a.originalDataSet && (a.originalDataSet = a.dataSet);
                        var i = t.sort.field, l = t.sort.sort, r = n.getColumnByField(i);
                        if (void 0 !== r ? "function" == typeof r.sortCallback ? a.dataSet = r.sortCallback(a.originalDataSet, l, r) : a.dataSet = n.sortCallback(a.originalDataSet, l, r) : a.dataSet = a.originalDataSet, "object" == typeof t.query) {
                            t.query = t.query || {};
                            var s = e(o.getOption("search.input")).val();
                            void 0 !== s && "" !== s && (s = s.toLowerCase(), a.dataSet = e.grep(a.dataSet, function (e) {
                                for (var t in e) if (e.hasOwnProperty(t) && "string" == typeof e[t] && e[t].toLowerCase().indexOf(s) > -1) return !0;
                                return !1
                            }), delete t.query[n.getGeneralSearchKey()]), e.each(t.query, function (e, a) {
                                "" === a && delete t.query[e]
                            }), a.dataSet = n.filterArray(a.dataSet, t.query), a.dataSet = a.dataSet.filter(function () {
                                return !0
                            })
                        }
                        return a.dataSet
                    }, filterArray: function (t, a, n) {
                        if ("object" != typeof t) return [];
                        if (void 0 === n && (n = "AND"), "object" != typeof a) return t;
                        if (n = n.toUpperCase(), -1 === e.inArray(n, ["AND", "OR", "NOT"])) return [];
                        var o = Object.keys(a).length, i = [];
                        return e.each(t, function (t, l) {
                            var r = l, s = 0;
                            e.each(a, function (e, t) {
                                r.hasOwnProperty(e) && t == r[e] && s++
                            }), ("AND" == n && s == o || "OR" == n && s > 0 || "NOT" == n && 0 == s) && (i[t] = l)
                        }), t = i
                    }, resetScroll: function () {
                        void 0 === t.detail && 1 === n.getDepth() && (e(a.table).find(".m-datatable__row").css("left", 0), e(a.table).find(".m-datatable__lock").css("top", 0), e(a.tableBody).scrollTop(0))
                    }, getColumnByField: function (a) {
                        var n;
                        return e.each(t.columns, function (e, t) {
                            if (a === t.field) return n = t, !1
                        }), n
                    }, getDefaultSortColumn: function () {
                        var a = {sort: "", field: ""};
                        return e.each(t.columns, function (t, n) {
                            if (void 0 !== n.sortable && -1 !== e.inArray(n.sortable, ["asc", "desc"])) return a = {
                                sort: n.sortable,
                                field: n.field
                            }, !1
                        }), a
                    }, getHiddenDimensions: function (t, a) {
                        var n = {position: "absolute", visibility: "hidden", display: "block"},
                            o = {width: 0, height: 0, innerWidth: 0, innerHeight: 0, outerWidth: 0, outerHeight: 0},
                            i = e(t).parents().addBack().not(":visible");
                        a = "boolean" == typeof a && a;
                        var l = [];
                        return i.each(function () {
                            var e = {};
                            for (var t in n) e[t] = this.style[t], this.style[t] = n[t];
                            l.push(e)
                        }), o.width = e(t).width(), o.outerWidth = e(t).outerWidth(a), o.innerWidth = e(t).innerWidth(), o.height = e(t).height(), o.innerHeight = e(t).innerHeight(), o.outerHeight = e(t).outerHeight(a), i.each(function (e) {
                            var t = l[e];
                            for (var a in n) this.style[a] = t[a]
                        }), o
                    }, getGeneralSearchKey: function () {
                        var t = e(o.getOption("search.input"));
                        return e(t).prop("name") || e(t).prop("id")
                    }, getObject: function (e, t) {
                        return e.split(".").reduce(function (e, t) {
                            return null !== e && void 0 !== e[t] ? e[t] : null
                        }, t)
                    }, extendObj: function (e, t, a) {
                        function n(e) {
                            var t = o[i++];
                            void 0 !== e[t] && null !== e[t] ? "object" != typeof e[t] && "function" != typeof e[t] && (e[t] = {}) : e[t] = {}, i === o.length ? e[t] = a : n(e[t])
                        }

                        var o = t.split("."), i = 0;
                        return n(e), e
                    }
                };
                this.API = {row: null, record: null, column: null, value: null, params: null};
                var o = {
                    timer: 0, redraw: function () {
                        return n.adjustCellsWidth.call(), n.adjustCellsHeight.call(), n.adjustLockContainer.call(), n.initHeight.call(), a
                    }, load: function () {
                        return o.reload(), a
                    }, reload: function () {
                        return function (e, t) {
                            clearTimeout(o.timer), o.timer = setTimeout(e, t)
                        }(function () {
                            !1 === t.data.serverFiltering && n.localDataUpdate(), n.dataRender(), e(a).trigger("m-datatable--on-reloaded")
                        }, o.getOption("search.delay")), a
                    }, getRecord: function (t) {
                        return void 0 === a.tableBody && (a.tableBody = e(a.table).children("tbody")), e(a.tableBody).find(".m-datatable__cell:first-child").each(function (o, i) {
                            if (t == e(i).text()) {
                                a.API.row = e(i).closest(".m-datatable__row");
                                var l = a.API.row.index() + 1;
                                return a.API.record = a.API.value = n.getOneRow(a.tableBody, l), a
                            }
                        }), a
                    }, getColumn: function (t) {
                        return a.API.column = a.API.value = e(a.API.record).find('[data-field="' + t + '"]'), a
                    }, destroy: function () {
                        return e(a).parent().find(".m-datatable__pager").remove(), e(a).replaceWith(e(a.old).addClass("m-datatable--destroyed").show()), e(a).trigger("m-datatable--on-destroy"), a
                    }, sort: function (t, n) {
                        return void 0 === n && (n = "asc"), e(a.tableHead).find('.m-datatable__cell[data-field="' + t + '"]').trigger("click"), a
                    }, getValue: function () {
                        return e(a.API.value).text()
                    }, setActive: function (t) {
                        "string" == typeof t && (t = e(a.tableBody).find('.m-checkbox--single > [type="checkbox"][value="' + t + '"]')), e(t).prop("checked", !0);
                        var n = e(t).closest(".m-datatable__row").addClass("m-datatable__row--active"),
                            o = e(n).index() + 1;
                        e(n).closest(".m-datatable__lock").parent().find(".m-datatable__row:nth-child(" + o + ")").addClass("m-datatable__row--active");
                        var i = [];
                        e(n).each(function (t, a) {
                            var n = e(a).find('.m-checkbox--single:not(.m-checkbox--all) > [type="checkbox"]').val();
                            void 0 !== n && i.push(n)
                        }), e(a).trigger("m-datatable--on-check", [i])
                    }, setInactive: function (t) {
                        "string" == typeof t && (t = e(a.tableBody).find('.m-checkbox--single > [type="checkbox"][value="' + t + '"]')), e(t).prop("checked", !1);
                        var n = e(t).closest(".m-datatable__row").removeClass("m-datatable__row--active"),
                            o = e(n).index() + 1;
                        e(n).closest(".m-datatable__lock").parent().find(".m-datatable__row:nth-child(" + o + ")").removeClass("m-datatable__row--active");
                        var i = [];
                        e(n).each(function (t, a) {
                            var n = e(a).find('.m-checkbox--single:not(.m-checkbox--all) > [type="checkbox"]').val();
                            void 0 !== n && i.push(n)
                        }), e(a).trigger("m-datatable--on-uncheck", [i])
                    }, setActiveAll: function (t) {
                        t ? o.setActive(e(a.table).find(".m-datatable__body .m-datatable__row").find(".m-datatable__cell")) : o.setInactive(e(a.table).find(".m-datatable__body .m-datatable__row").find(".m-datatable__cell")), e(a.table).find(".m-datatable__body .m-datatable__row").find('.m-checkbox [type="checkbox"]').prop("checked", t || !1)
                    }, setSelectedRecords: function () {
                        return a.API.record = e(a.tableBody).find(".m-datatable__row--active"), a
                    }, getSelectedRecords: function () {
                        return o.setSelectedRecords(), a.API.record
                    }, getOption: function (e) {
                        return n.getObject(e, t)
                    }, setOption: function (e, a) {
                        t = n.extendObj(t, e, a)
                    }, search: function (a, i) {
                        void 0 !== i && (i = e.makeArray(i));
                        (function (e, t) {
                            clearTimeout(o.timer), o.timer = setTimeout(e, t)
                        })(function () {
                            var l = o.getDataSourceQuery();
                            if (void 0 === i && void 0 !== a) {
                                var r = n.getGeneralSearchKey();
                                l[r] = a
                            }
                            "object" == typeof i && (e.each(i, function (e, t) {
                                l[t] = a
                            }), e.each(l, function (e, t) {
                                "" === t && delete l[e]
                            })), o.setDataSourceQuery(l), !1 === t.data.serverFiltering && n.localDataUpdate(), n.dataRender()
                        }, o.getOption("search.delay"))
                    }, setDataSourceParam: function (t, i) {
                        var l = n.getDefaultSortColumn();
                        a.API.params = e.extend({}, {
                            pagination: {page: 1, perpage: o.getOption("data.pageSize")},
                            sort: {sort: l.sort, field: l.field},
                            query: {}
                        }, a.API.params, n.stateGet(n.stateId)), a.API.params = n.extendObj(a.API.params, t, i), n.stateKeep(n.stateId, a.API.params)
                    }, getDataSourceParam: function (t) {
                        var i = n.getDefaultSortColumn();
                        return a.API.params = e.extend({}, {
                            pagination: {page: 1, perpage: o.getOption("data.pageSize")},
                            sort: {sort: i.sort, field: i.field},
                            query: {}
                        }, a.API.params, n.stateGet(n.stateId)), "string" == typeof t ? n.getObject(t, a.API.params) : a.API.params
                    }, getDataSourceQuery: function () {
                        return o.getDataSourceParam("query") || {}
                    }, setDataSourceQuery: function (e) {
                        o.setDataSourceParam("query", e)
                    }, getCurrentPage: function () {
                        return e(a.table).siblings(".m-datatable__pager").last().find(".m-datatable__pager-nav").find(".m-datatable__pager-link.m-datatable__pager-link--active").data("page") || 1
                    }, getPageSize: function () {
                        return e(a.table).siblings(".m-datatable__pager").last().find(".m-datatable__pager-size").val() || 10
                    }, getTotalRows: function () {
                        return a.API.params.pagination.total
                    }, getDataSet: function () {
                        return a.originalDataSet
                    }, hideColumn: function (n) {
                        e.map(t.columns, function (e) {
                            return n === e.field && (e.responsive = {hidden: "xl"}), e
                        });
                        var o = e.grep(e(a.table).find(".m-datatable__cell"), function (t, a) {
                            return n === e(t).data("field")
                        });
                        e(o).hide()
                    }, showColumn: function (n) {
                        e.map(t.columns, function (e) {
                            return n === e.field && delete e.responsive, e
                        });
                        var o = e.grep(e(a.table).find(".m-datatable__cell"), function (t, a) {
                            return n === e(t).data("field")
                        });
                        e(o).show()
                    }
                };
                return e.each(o, function (e, t) {
                    a[e] = t
                }), "string" == typeof t ? o[t].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof t && t ? e.error("Method " + t + " does not exist") : (a.textAlign = {
                    left: "m-datatable__cell--left",
                    center: "m-datatable__cell--center",
                    right: "m-datatable__cell--right"
                }, a.dataSet = null, t = e.extend(!0, {}, e.fn.mDatatable.defaults, t), e(a).data("options", t), e(a).trigger("m-datatable--on-init", t), n.init.apply(this, [t])), a
            }
        }, e.fn.mDatatable.defaults = {
        data: {
            type: "local",
            source: null,
            pageSize: 10,
            saveState: {cookie: !0, webstorage: !0},
            serverPaging: !1,
            serverFiltering: !1,
            serverSorting: !1
        },
        layout: {
            theme: "default",
            class: "m-datatable--brand",
            scroll: !1,
            height: null,
            footer: !1,
            header: !0,
            smoothScroll: {scrollbarShown: !0},
            spinner: {overlayColor: "#000000", opacity: 0, type: "loader", state: "brand", message: !0},
            icons: {
                sort: {asc: "la la-arrow-up", desc: "la la-arrow-down"},
                pagination: {
                    next: "la la-angle-right",
                    prev: "la la-angle-left",
                    first: "la la-angle-double-left",
                    last: "la la-angle-double-right",
                    more: "la la-ellipsis-h"
                },
                rowDetail: {expand: "fa fa-caret-down", collapse: "fa fa-caret-right"}
            }
        },
        sortable: !0,
        resizable: !1,
        filterable: !1,
        pagination: !0,
        editable: !1,
        columns: [],
        search: {input: null, delay: 400},
        rows: {},
        toolbar: {
            layout: ["pagination", "info"],
            placement: ["bottom"],
            items: {
                pagination: {
                    type: "default",
                    pages: {
                        desktop: {layout: "default", pagesNumber: 6},
                        tablet: {layout: "default", pagesNumber: 3},
                        mobile: {layout: "compact"}
                    },
                    navigation: {prev: !0, next: !0, first: !0, last: !0},
                    pageSizeSelect: [10, 20, 30, 50, 100]
                }, info: !0
            }
        },
        translate: {
            records: {processing: "Please wait...", noRecords: "No records found"},
            toolbar: {
                pagination: {
                    items: {
                        default: {
                            first: "First",
                            prev: "Previous",
                            next: "Next",
                            last: "Last",
                            more: "More pages",
                            input: "Page number",
                            select: "Select page size"
                        }, info: "Displaying {{start}} - {{end}} of {{total}} records"
                    }
                }
            }
        }
    }

}(jQuery));
