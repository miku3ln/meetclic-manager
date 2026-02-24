<?php

$allowShop = 0;

if ($dataManagerPage['shopConfig']['allow'] == true) {
    $allowShop = 1;
}
?>
@include('partials.mangerVueJS')
@include('partials.plugins.resourcesJs',['bootgrid'=>true])
<script type="text/javascript">var pathDevelopers = '{{asset($resourcePathServer.'wulpy/developers')}}/';</script>
<script type="text/javascript">var $resourcesCustom = '{{asset($resourcePathServer.'images')}}/';</script>


<script
    src="{{ asset($resourcePathServer.'plugins/higcharts-2024/highcharts.js') }}"
    type="text/javascript"></script>
<script
    src="{{ asset($resourcePathServer.'plugins/higcharts-2024/modules/data.js') }}"
    type="text/javascript"></script>
<script
    src="{{ asset($resourcePathServer.'plugins/higcharts-2024/modules/annotations.js') }}"
    type="text/javascript"></script>
<script
    src="{{ asset($resourcePathServer.'plugins/higcharts-2024/modules/exporting.js') }}"
    type="text/javascript"></script>
<script
    src="{{ asset($resourcePathServer.'plugins/higcharts-2024/modules/export-data.js') }}"
    type="text/javascript"></script>
<script
    src="{{ asset($resourcePathServer.'plugins/higcharts-2024/modules/accessibility.js') }}"
    type="text/javascript"></script>

<script type="text/javascript">
    function formatDateTimeDMY(datetimeStr) {
        if (!datetimeStr) return '';

        var parts = datetimeStr.split(' ');
        var datePart = parts[0]; // 2025-08-06
        var timePart = parts[1] || '';

        var d = datePart.split('-'); // [2025, 08, 06]

        return d[2] + '/' + d[1] + '/' + d[0] + (timePart ? ' ' + timePart : '');
    }

    var $configPartial = <?php echo json_encode($configPartial) ?>;
    var $allowAllInOne = '<?php echo env('allowAllInOne') ? '1' : '0' ?>';
    var $buttonsConfig = {
        "names": {
            "one": "{{__('config.buttons.one')}}",
            "two": "{{__('config.buttons.two')}}",
            "three": "{{__('config.buttons.three')}}",
            "four": "{{__('config.buttons.four')}}",
            "five": "{{__('config.buttons.five')}}",

        },
    };
    var $allowShop = '{{$allowShop}}';

    function formatDateTimeForDB(dateObj) {
        var d = dateObj instanceof Date ? dateObj : new Date(dateObj);

        var yyyy = d.getFullYear();
        var mm = String(d.getMonth() + 1).padStart(2, '0');
        var dd = String(d.getDate()).padStart(2, '0');

        var HH = String(d.getHours()).padStart(2, '0');
        var ii = String(d.getMinutes()).padStart(2, '0');
        var ss = String(d.getSeconds()).padStart(2, '0');

        return yyyy + "-" + mm + "-" + dd + " " + HH + ":" + ii + ":" + ss;
    }
</script>

@include('cityBook.management.'.$managementNameProcess.'.assets.js.templateVue')
@include('partials.plugins.resourcesJs',['blockUi'=>true])


<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
        integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
        crossorigin="anonymous"></script>
@include('partials.plugins.resourcesJs',['toast'=>true])

<script src="{{ asset($resourcePathServer.'js/developers/UtilCustom.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/Utils.js')}}" type='text/javascript'></script>

<!--NEWS-->
@include('partials.plugins.resourcesJs',['croppie'=>true])

@include('partials.plugins.resourcesJs',['select2'=>true])

<script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>

<script>

    var $methodsProcessCurrent = {
        managerSaveBoarding: function (e) {
            console.log(e);
        }
    };
</script>
@include('partials.vue-directives.directives')
@include('cityBook.management.'.$managementNameProcess.'.assets.js.process.grid-registers')
@include('cityBook.management.'.$managementNameProcess.'.assets.js.process.register-form')
@include('cityBook.management.'.$managementNameProcess.'.assets.js.process.main')





<script id="reports">
    var reportData = {
        success: false, data: []
    };


</script>



