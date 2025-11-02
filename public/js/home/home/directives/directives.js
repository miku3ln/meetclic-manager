Vue.directive('bgrid', {
    bind: function (el, binding, vnode) {
        /*      var configBootrid = binding.value.paramsConfigTable;*/
        /* dataTable = initDatableAjax($(el),configBootrid);*/
    }
});
Vue.directive('view-data', {
    bind: function (el, binding, vnode, vm, arg) {
        $(el).removeClass("not-view");

    }
});

Vue.directive('init-map', {

    inserted: function (el, binding, vnode, vm, arg) {
        var paramsInput = binding.value;
        paramsInput.initMapCurrent();
    },
    bind: function (el, binding, vnode, vm, arg) {
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
