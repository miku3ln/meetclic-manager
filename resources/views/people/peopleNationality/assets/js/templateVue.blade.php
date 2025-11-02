<?php
$resourcesJs = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"].".assets.js";
$wizards_route = $resourcesJs . ".templates.process.mainProcess";
$paramsWizard = [
    "model_entity" => $model_entity,
    "pathCurrent" => $pathCurrent,
    "configPartial" => $configPartial
];

?>
@include($wizards_route,$paramsWizard)
