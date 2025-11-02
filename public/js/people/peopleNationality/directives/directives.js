Vue.directive('view-data', {
    bind: function (el, binding, vnode, vm, arg) {
        $(el).removeClass("not-view");

    }
});
Vue.directive('focus-select', {

    inserted: function (el, binding, vnode, vm, arg) {

    },
    bind: function (el, binding, vnode, vm, arg) {
        $(el).focus(function () {
            $(this).select();
        });
    }
});
Vue.directive('init-tool-tip', {

    inserted: function (el, binding, vnode, vm, arg) {

    },
    bind: function (el, binding, vnode, vm, arg) {
        $(el).tooltip();
    }
});
