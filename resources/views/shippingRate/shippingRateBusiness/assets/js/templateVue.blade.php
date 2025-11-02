<?php
$resourcesJs = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"].".assets.js";
$wizards_route = $resourcesJs . ".templates.process.shippingRateServices";

$paramsWizard = [
    "pathCurrent" => $pathCurrent,
    "configPartial" => $configPartial
];
?>
@include($wizards_route,$paramsWizard)
<?php
$wizards_route = $resourcesJs . ".templates.process.shippingRateBusinessByConversionFactor";

?>
@include($wizards_route,$paramsWizard)

<?php
$wizards_route = $resourcesJs . ".templates.process.mainProcess";

?>
@include($wizards_route,$paramsWizard)


