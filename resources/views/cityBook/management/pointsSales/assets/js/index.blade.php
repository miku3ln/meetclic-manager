<?php

$allowShop=0;

if($dataManagerPage['shopConfig']['allow']==true){
    $allowShop=1;
}
?>
@include('partials.mangerVueJS')
@include('partials.plugins.resourcesJs',['bootgrid'=>true])
<script type="text/javascript">var pathDevelopers = '{{asset($resourcePathServer.'wulpy/developers')}}/';</script>
<script type="text/javascript">var $resourcesCustom = '{{asset($resourcePathServer.'images')}}/';</script>
<script type="text/javascript">
    var $configPartial = <?php echo json_encode($configPartial)?>;
    var $allowAllInOne = '<?php echo env('allowAllInOne')?'1':'0'?>';
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

</script>

@include('cityBook.management.'.$managementNameProcess.'.assets.js.templateVue')
@include('partials.plugins.resourcesJs',['blockUi'=>true])


<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
@include('partials.plugins.resourcesJs',['toast'=>true])

<script src="{{ asset($resourcePathServer.'js/developers/UtilCustom.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/Utils.js')}}" type='text/javascript'></script>

<!--NEWS-->
@include('partials.plugins.resourcesJs',['croppie'=>true])

@include('partials.plugins.resourcesJs',['select2'=>true])

<script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/ManagementFormEventDetails.js') }}"
        type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/Main.js') }}"
        type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/App.js') }}" type="text/javascript"></script>
