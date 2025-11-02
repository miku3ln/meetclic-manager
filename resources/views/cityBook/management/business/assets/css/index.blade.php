@include('partials.mangerVueCss')
@include('partials.plugins.resourcesCss',['bootgrid'=>true])
@include('partials.plugins.resourcesCss',['select2'=>true])

<link href="{{ asset($resourcePathServer."css/bootgridManager.css") }}" rel="stylesheet"
      type="text/css">
<link href="{{ URL::asset($resourcePathServer.'css/bootstrapManager.css') }}" rel="stylesheet"
      type="text/css">
@include('partials.plugins.resourcesCss',['toast'=>true])
@include('partials.plugins.resourcesCss',['croppie'=>true])

