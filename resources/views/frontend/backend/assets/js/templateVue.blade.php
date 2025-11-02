<?php
$paramsWizard = [
    "pathCurrent" => $pathCurrent,
    "user" => $user,
    "modelDataManager" => $modelDataManager,
    "configPartial" => $configPartial
];
?>
@if($configPartial['typeManager']=='managerTemplateSlider'   ||$configPartial['typeManager']=='managerActivitiesGamification' ||$configPartial['typeManager']=='managerRewardsGamification')

    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.language.languageSliderByImages";
    ?>
    @include($wizards_route,$paramsWizard)
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.frontend.TemplateSlider.templateSlider";
    ?>
    @include($wizards_route,$paramsWizard)

    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.frontend.TemplateSlider.templateSliderByImages";
    ?>
    @include($wizards_route,$paramsWizard)

@elseif($configPartial['typeManager']=='managerTemplateAboutUs' )
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.frontend.TemplateAboutUs.templateAboutUsByData";
    ?>
    @include($wizards_route,$paramsWizard)
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.language.languageAboutUs";
    ?>
    @include($wizards_route,$paramsWizard)

    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.language.languageAboutUsByData";
    ?>
    @include($wizards_route,$paramsWizard)


    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.frontend.TemplateAboutUs.templateAboutUs";
    ?>
    @include($wizards_route,$paramsWizard)

@elseif($configPartial['typeManager']=='managerTemplatePolicies' )
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.language.languagePolicies";
    ?>
    @include($wizards_route,$paramsWizard)
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.frontend.templatePolicies";
    ?>
    @include($wizards_route,$paramsWizard)


@elseif($configPartial['typeManager']=='managerTemplateServices' )
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.frontend.TemplateServices.templateServices";

    ?>
    @include($wizards_route,$paramsWizard)
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.language.languageServices";
    ?>
    @include($wizards_route,$paramsWizard)

    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.language.languageServicesByData";
    ?>
    @include($wizards_route,$paramsWizard)

    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.frontend.TemplateServices.templateServicesByData";

    ?>
    @include($wizards_route,$paramsWizard)
@elseif($configPartial['typeManager']=='managerTemplateNews' )
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.frontend.TemplateNews.templateNews";

    ?>
    @include($wizards_route,$paramsWizard)

    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.frontend.TemplateNews.templateNewsByData";

    ?>
    @include($wizards_route,$paramsWizard)

@elseif($configPartial['typeManager']=='managerTemplateConfigMailing' )

    <?php

    ?>
    {{--  @include($wizards_route,$paramsWizard)--}}

@elseif($configPartial['typeManager']=='managerTemplateContactUs' )
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.frontend.map";

    ?>
    @include($wizards_route,$paramsWizard)
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.frontend.TemplateContactUs.templateContactUs";

    ?>
    @include($wizards_route,$paramsWizard)
@elseif($configPartial['typeManager']=='managerTemplateBySource' )
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.frontend.templateBySource";

    ?>
    @include($wizards_route,$paramsWizard)

@elseif($configPartial['typeManager']=='managerTemplatePayments' )
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.frontend.templatePayments";

    ?>
    @include($wizards_route,$paramsWizard)

@endif
