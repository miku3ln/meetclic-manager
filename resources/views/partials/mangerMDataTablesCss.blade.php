

<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>

@section('additional-styles')
    <style>
        .manager-actions {
            /* width: 300px; */
            height: 450px;
            overflow: auto;
        }
    </style>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <link href="{{ asset($resourcePathServer."libs/mdatatables/mdatatables.min.css") }}" rel="stylesheet"
          type="text/css">

@endsection
