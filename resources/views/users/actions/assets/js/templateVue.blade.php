<?php
$resourcesJs = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"].".assets.js";
$wizards_route = $resourcesJs . ".templates.process.actions.actions";
$paramsWizard = [
    "model_entity" => $model_entity,
    "pathCurrent" => $pathCurrent,
    "configPartial" => $configPartial,

];
?>
@include($wizards_route,$paramsWizard)


<?php

$wizards_route = $resourcesJs . ".templates.toogle";
$paramsWizard = [
    "model_entity" => $model_entity,
    "pathCurrent" => $pathCurrent,
    "configPartial" => $configPartial
];
?>
@include($wizards_route,$paramsWizard)
