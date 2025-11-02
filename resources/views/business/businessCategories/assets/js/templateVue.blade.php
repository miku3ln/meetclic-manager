
<?php
$resourcesJs = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"].".assets.js";
$wizards_route = $resourcesJs . ".templates.process.mainProcess";
$paramsWizard = [
    "pathCurrent" => $pathCurrent,
    "configPartial" => $configPartial
];
?>
@include($wizards_route,$paramsWizard)
<?php
$resourcesJs = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"].".assets.js";
$wizards_route = $resourcesJs . ".templates.process.businessSubcategories";
$paramsWizard = [
    "pathCurrent" => $pathCurrent,
    "configPartial" => $configPartial
];
?>
@include($wizards_route,$paramsWizard)
