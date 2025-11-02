@section('additional-styles')

    <?php
    $wizards_route = $model_entity . ".partials.assets.css.info";
    $paramsWizard = [
        "model_entity" => $model_entity,

    ];
    ?>
    @include($wizards_route,$paramsWizard)
@endsection
@section('content')
    <div id="app-management">


    </div>

@endsection



@section('script')
    <?php
    $wizards_route = $model_entity . ".partials.assets.js.info";
    $paramsWizard = [
        "model_entity" => $model_entity,
        "pathCurrent" => $pathCurrent
    ];
    ?>
    @include($wizards_route,$paramsWizard)
@endsection
