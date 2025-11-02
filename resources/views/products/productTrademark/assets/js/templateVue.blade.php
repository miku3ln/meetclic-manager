
<?php
$resourcesJs = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"].".assets.js";
$wizards_route = $resourcesJs . ".templates.process.mainProcess";
$paramsWizard = [
    "pathCurrent" => $pathCurrent,
    "configPartial" => $configPartial
];
?>
@include($wizards_route,$paramsWizard)
@include($wizards_route,$paramsWizard)
@php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.language.languageProductTrademark";

@endphp
@include($wizards_route,$paramsWizard)
