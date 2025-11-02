<script  type="text/javascript">
    var $routesManager={
        "businessDetails":"{{route('businessDetails', app()->getLocale())}}",
        "authorSingle":"{{route('authorSingle', app()->getLocale())}}",

    }


</script>
<?php
$pathCurrent="frontend/account";
?>
@include('partials.mangerVueJS')
@include('partials.plugins.resourcesJs',['bootgrid'=>true])
<script type="text/javascript">var pathDevelopers = '{{asset($resourcePathServer.'wulpy/developers')}}/';</script>
<script type="text/javascript">var $resourcesCustom = '{{asset($resourcePathServer.'images')}}/';</script>
<script type="text/javascript">
    var $configPartial = <?php echo json_encode($configPartial) ?>;
    var $allowAllInOne = '<?php echo env('allowAllInOne') ? '1' : '0' ?>';
</script>

@include('cityBook.web.partials.profile.assets.js.templates.templateVueAccount')
@include('partials.plugins.resourcesJs',['blockUi'=>true])
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
        integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
        crossorigin="anonymous"></script>
@include('partials.plugins.resourcesJs',['toast'=>true])
<script src="{{ asset($resourcePathServer.'js/developers/UtilCustom.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/Utils.js')}}" type='text/javascript'></script>
@include('partials.plugins.resourcesJs',['select2'=>true])
<script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/process/GridManagement.js') }}"
        type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/App.js') }}" type="text/javascript"></script>
