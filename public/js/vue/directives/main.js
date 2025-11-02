Vue.directive('bgrid', {
    bind: function (el, binding, vnode) {
        /*      var configBootrid = binding.value.paramsConfigTable;*/
        /* dataTable = initDatableAjax($(el),configBootrid);*/
    }
});

Vue.directive('initGrid', {
    inserted: function (el, binding, vnode, vm, arg) {
        var paramsInput = binding.value;
        paramsInput.initMethod({
            objSelector: el, model: paramsInput.model
        });
    },
});


Vue.directive('initMapPlugin', {

    inserted: function (el, binding, vnode, vm, arg) {
        var paramsInput = binding.value;
        var methodInit=paramsInput['methodInit'];
        var elementSelector=paramsInput['elementSelector'];

        methodInit({
            elementSelector: elementSelector,
            objSelector: $(el)[0],
            data: paramsInput
        });

    }
});
Vue.directive('initS2Plugin', {

    inserted: function (el, binding, vnode, vm, arg) {
        var paramsInput = binding.value;
        var nameMethod = paramsInput.nameMethod;
        var rowId = paramsInput.rowId;
        nameMethod({
            objSelector: el, rowId: paramsInput.rowId, modelId: rowId
        });


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
Vue.directive('reset-field', {

    inserted: function (el, binding, vnode, vm, arg) {
        var paramsInput = binding.value
        var fieldName = paramsInput['fieldName'];
        var form = paramsInput['form'];
        form[fieldName].$model = null;
        form[fieldName].$reset();


    }
});
Vue.directive('upload-data', {

    inserted: function (el, binding, vnode, vm, arg) {
        var paramsInput = binding.value
        var paramsInit = paramsInput['paramsInit'];
        var initMethod = paramsInput['initMethod'];
        initMethod(paramsInit);
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
});

Vue.directive('init-tool-tip', {

    bind: function (el, binding, vnode, vm, arg) {
        $(el).tooltip();
        $(el).hover( function(){
           console.log('22');
        }, function(){
            console.log('21');

        });
    }
});


Vue.directive('load-img', {
    inserted: function (el, binding, vnode, vm, arg) {
        var paramsInput = binding.value;
        var source = paramsInput.source;
        source = source == null || source == '' ? $notImageUrl : getValueValidSource(source);
        $(el).attr('src', source);
    }
});

function getValueValidSource(source) {
    return $resourceRoot + source;
}
