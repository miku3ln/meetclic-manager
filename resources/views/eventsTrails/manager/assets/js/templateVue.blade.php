<?php
$paramsWizard = [
    "pathCurrent" => $pathCurrent,
    "user" => $user,
    "modelDataManager" => $modelDataManager,
    "configPartial" => $configPartial
];
?>
@if($configPartial['typeManager']=='managerEventsTrailsTypeOfCategories' )


    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.eventsTrails.eventsTrailsTypeOfCategories";
    ?>
    @include($wizards_route,$paramsWizard)



@elseif($configPartial['typeManager']=='managerEventsTrailsDistances' )
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.eventsTrails.eventsTrailsDistances";
    ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerEventsTrailsTypeTeams')
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.eventsTrails.eventsTrailsTypeTeams";
    ?>
    @include($wizards_route,$paramsWizard)

@elseif ($configPartial['typeManager'] === 'managerEventsTrailsByKit')
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.eventsTrails.eventsTrailsByKit";
    ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerEventsTrailsRegistrationPoints')
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.eventsTrails.eventsTrailsRegistrationPoints";

    ?>
    @include($wizards_route,$paramsWizard)
@endif
