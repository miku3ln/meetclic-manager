<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>

<?php
$url_path_plugins = "libs/";
?>
@if(isset($bootgrid))
    <link href="{{ asset($resourcePathServer.$url_path_plugins."bootgrid1.3.1/bootgrid1.3.1.min.css") }}"
          rel="stylesheet"
          type="text/css">
@elseif(isset($croppie))
    <link href="{{ asset($resourcePathServer.$url_path_plugins."croppie/croppie.css") }}"
          rel="stylesheet"
          type="text/css">

@elseif(isset($select2))
    <link href="{{ URL::asset($resourcePathServer.'libs/jquery-select2/jquery-select2.min.css') }}" rel="stylesheet"/>
@elseif(isset($toast))
    <link href="{{ URL::asset($resourcePathServer.'libs/toast/jquery.toast.min.css') }}" rel="stylesheet"
          type="text/css">

@elseif(isset($bootstrap4))
    <link href="{{ asset($resourcePathServer."assets/css/bootstrap.min.css") }}"
          rel="stylesheet"
          type="text/css">
@elseif(isset($datepickerBootstrap))
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" rel="stylesheet"
          type="text/css">
@elseif(isset($dataGridVue))
    <link href="//cdn.rawgit.com/Sphinxxxx/vue-simple-datagrid/v1.0/src/vue-simple-datagrid.css" rel="stylesheet"/>

@elseif(isset($bootstrapColorpicker))
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/css/bootstrap-colorpicker.min.css" rel="stylesheet">

@elseif(isset($summerNote))

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href=" https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-lite.min.css" rel="stylesheet">



@endif

