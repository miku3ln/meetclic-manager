{{-- CONFIG GET TEMPLATE  VM-004 --}}
<!--BUSINESS-MANAGER-TEMPLATES-->


<script type="text/x-template" id="item-template">
    <li>
        <div
            :class="{bold: isFolder}"
            @click="toggle"
            @dblclick="makeFolder">
            <?php echo '{{ item.name }}' ?>
            <span v-if="isFolder"> <?php echo '[{{ isOpen ? "-" : "+" }}]' ?></span>
        </div>
        <ul v-show="isOpen" v-if="isFolder">
            <tree-item
                class="item"
                v-for="(child, index) in item.children"
                :key="index"
                :item="child"
                @make-folder="$emit('make-folder', $event)"
                @add-item="$emit('add-item', $event)"
            ></tree-item>
            {{--<li class="add" @click="$emit('add-item', item)">+</li>--}}
        </ul>
    </li>
</script>

<?php

$paramsWizard = [
    "model_entity" => $model_entity,
    "pathCurrent" => $pathCurrent,
    "user" => $user,
    "modelDataManager" => $modelDataManager,
    "configPartial" => $configPartial,
    "configProcess"=>$configProcess

];
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.business.businessByGallery";

?>
@include($wizards_route,$paramsWizard)
<?php
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.business.businessBySchedule";

?>
@include($wizards_route,$paramsWizard)
<script type="text/x-template" id="template-form">
    <div>
        <div class="layout-form">
            <div class="form-group" :class="{error: validation.hasError('form.name')}">
                <div class="label">* Name</div>
                <div class="content"><input type="text" class="form-control" v-model="form.name"
                                            placeholder="only accepts alphabetic characters"/></div>
                <div class="message"> <?php echo "{{ validation.firstError('form.name') }} " ?> </div>
            </div>
            <div class="form-group" :class="{error: validation.hasError('gender')}">
                <div class="label">* Gender</div>
                <div class="content">
                    <label>
                        <input type="radio" class="form-control" name="gender" value="mail" v-model="gender"/>
                        Male
                    </label>
                    <label>
                        <input type="radio" class="form-control" name="gender" value="female" v-model="gender"/>
                        Female
                    </label>
                </div>
                <div class="message"><?php echo "  {{ validation.firstError('gender') }}" ?></div>
            </div>
            <div class="form-group" :class="{error: validation.hasError('phone')}">
                <div class="label">Phone</div>
                <div class="content"><input type="text" class="form-control" v-model="phone"/></div>
                <div class="message"><?php echo " {{ validation.firstError('phone') }}" ?></div>
            </div>
            <div class="form-group" :class="{error: validation.hasError('age')}">
                <div class="label">Age</div>
                <div class="content"><input type="text" class="form-control" v-model="age"/></div>
                <div class="message"><?php echo "{{ validation.firstError('age') }}" ?> </div>
            </div>
            <div class="form-group">
                <div class="actions">
                    <button type="button" class="btn btn-default" @click="reset">Reset</button>
                    <button type="button" class="btn btn-primary" @click="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</script>

<!--BUSINESS-MANAGER-ACTIONS-CRUD--PRODUCT-MANAGER-->
@if ($configPartial['typeManager'] === 'managerProducts')




@elseif ($configPartial['typeManager'] === 'managerRoutes')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.routes.businessByRoutesMap";
        ?>
    @include($wizards_route,$paramsWizard)

@elseif ($configPartial['typeManager'] === 'managerPanorama')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.panorama.businessByPanorama";

        ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerLodging' || $configPartial['typeManager'] ==null)

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.housing.lodgingByTypeOfRoom";

        ?>
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.housing.lodgingRoomsState";

        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.housing.lodging";

        ?>
    @include($wizards_route,$paramsWizard)

@elseif ($configPartial['typeManager'] === 'managerLodgingTypeOfRoom')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.housing.lodgingTypeOfRoom";

        ?>
    @include($wizards_route,$paramsWizard)

@elseif ($configPartial['typeManager'] === 'managerLodgingRoomLevels')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.housing.lodgingRoomLevels";

        ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerLodgingRoomFeatures')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.housing.lodgingRoomFeatures";

        ?>
    @include($wizards_route,$paramsWizard)

@elseif ($configPartial['typeManager'] === 'managerLodgingStatisticalData')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.housing.lodgingStatisticalData";

        ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerLodgingTypeOfRoomByPrice')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.housing.lodgingTypeOfRoomByPrice";

        ?>
    @include($wizards_route,$paramsWizard)

@elseif ($configPartial['typeManager'] === 'managerHumanResourcesDepartment')

    {{--
    HUMAN RESOURCES--}}

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.humanResources.humanResourcesDepartment";

        ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerHumanResourcesOrganizationalChartArea')

    {{--
    HUMAN RESOURCES--}}

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.humanResources.humanResourcesOrganizationalChartArea";

        ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerHumanResourcesEmployeeProfile')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.information.informationMail";

        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.information.informationSocialNetwork";

        ?>
    @include($wizards_route,$paramsWizard)

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.information.informationPhone";

        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.information.informationAddress";

        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.humanResources.humanResourcesEmployeeProfile";

        ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerCustomer')
    {{--BUSINESS-MANAGER-CRM-DELIVERY-TEMPLATE--}}
    {{--
 CRM--}}
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.crm.MailingByDataSend";

        ?>
    @include($wizards_route,$paramsWizard)

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.crm.customer";

        ?>
    @include($wizards_route,$paramsWizard)

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.information.informationMail";

        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.information.informationSocialNetwork";

        ?>
    @include($wizards_route,$paramsWizard)

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.information.informationPhone";

        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.information.informationAddress";

        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.deliveryByBusinessManager.deliveryByBusinessManager";

        ?>
    @include($wizards_route,$paramsWizard)

@elseif ($configPartial['typeManager'] === 'managerCustomerPresentation')
    {{--BUSINESS-MANAGER-CRM-CUSTOMER-PRESENTATION RENDER--}}


    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.prosecutorOffice.customerPresentation";

    ?>
    @include($wizards_route,$paramsWizard)


@elseif ($configPartial['typeManager'] === 'managerCustomerData')
    {{--
CRM--}}
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.crmData.MailingByDataSend";

        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.crmData.eventByAssistance";

        ?>
    @include($wizards_route,$paramsWizard)

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.crmData.customer";

        ?>
    @include($wizards_route,$paramsWizard)

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.information.informationMail";

        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.information.informationSocialNetwork";

        ?>
    @include($wizards_route,$paramsWizard)

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.information.informationPhone";

        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.information.informationAddress";

        ?>
    @include($wizards_route,$paramsWizard)
@endif


@if($configPartial['typeManager']=='managerEducationalInstitutionAskwerType')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.educationalInstitution.educationalInstitutionAskwerType";
        ?>
    @include($wizards_route,$paramsWizard)

@elseif($configPartial['typeManager']=='managerEducationalInstitutionByBusiness')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.educationalInstitution.educationalInstitutionByBusiness";

        ?>
    @include($wizards_route,$paramsWizard)
@elseif($configPartial['typeManager']=='managerEventsTrailsProject')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.eventsTrails.eventsTrailsProject";

        ?>
    @include($wizards_route,$paramsWizard)

@elseif($configPartial['typeManager']=='managerTemplateInformation')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.frontend.templateInformation";


        ?>
    @include($wizards_route,$paramsWizard)

@elseif($configPartial['typeManager']=='managerTaxByBusiness')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.tax.taxByBusiness";
        ?>
    @include($wizards_route,$paramsWizard)
@elseif($configPartial['typeManager']=='managerBusinessByLanguage')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.language.businessByLanguage";
        ?>
    @include($wizards_route,$paramsWizard)
@elseif($configPartial['typeManager']=='managerBusinessByHistory')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.business.BusinessByHistory.businessHistoryByData";
        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.business.BusinessByHistory.businessByHistory";
        ?>
    @include($wizards_route,$paramsWizard)

@elseif($configPartial['typeManager']=='managerBusinessByAcademicOfferings')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.business.BusinessByAcademicOfferings.businessAcademicOfferingsByData";
        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.business.BusinessByAcademicOfferings.businessAcademicOfferingsDataByInformation";
        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.business.BusinessByAcademicOfferings.businessByAcademicOfferings";
        ?>

    @include($wizards_route,$paramsWizard)

@elseif($configPartial['typeManager']=='managerBusinessByAcademicOfferingsInstitution')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.business.BusinessByAcademicOfferingsInstitution.businessByAcademicOfferingsInstitution";
        ?>

    @include($wizards_route,$paramsWizard)
@elseif($configPartial['typeManager']=='managerBusinessByMenuManagementFrontend')
    @include($wizards_route,$paramsWizard)

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.business.businessByMenuManagementFrontend";
        ?>

    @include($wizards_route,$paramsWizard)
@elseif($configPartial['typeManager']=='managerBusinessCounterCustom')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.business.BusinessCounterCustom.businessCounterCustomByData";
        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.business.BusinessCounterCustom.businessCounterCustom";
        ?>
    @include($wizards_route,$paramsWizard)
@elseif($configPartial['typeManager']=='managerBusinessByFrequentQuestion')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.business.businessByFrequentQuestion";
        ?>
    @include($wizards_route,$paramsWizard)
@elseif($configPartial['typeManager']=='managerBusinessByRequirements')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.business.businessByRequirements";
        ?>
    @include($wizards_route,$paramsWizard)
@elseif($configPartial['typeManager']=='managerBusinessByPartnerCompanies')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.business.businessByPartnerCompanies";
        ?>
    @include($wizards_route,$paramsWizard)
@elseif($configPartial['typeManager']=='managerBusinessByInformationCustom')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.business.businessByInformationCustom";
        ?>
    @include($wizards_route,$paramsWizard)
@elseif($configPartial['typeManager']=='managerProduct')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.products.productByMultimedia";
        ?>
    @include($wizards_route,$paramsWizard)

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.products.productByRouteMap";
        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.products.productSaveDataInputOutput";
        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.language.languageProduct";
        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.products.product";
        ?>
    @include($wizards_route,$paramsWizard)

        <!--BUSINESS-MANAGER-TEMPLATES-PRODUCTS-MANAGER--->
@elseif ($configPartial['typeManager'] === 'managerProductManager')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.productManager.productByMultimedia";
        ?>
    @include($wizards_route,$paramsWizard)

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.productManager.productByRouteMap";
        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.productManager.productSaveDataInputOutput";
        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.language.languageProduct";
        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.productManager.product";
        ?>
    @include($wizards_route,$paramsWizard)

@elseif($configPartial['typeManager']=='managerProductService')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.products.productService";
        ?>
    @include($wizards_route,$paramsWizard)
@elseif($configPartial['typeManager']=='managerOrderPaymentsManager')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.orders.businessByInventoryManagement";

        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.orders.businessByInventoryManagementSubcategory";

        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.orders.deliverOrder";

        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.orders.viewOrder";

        ?>
    @include($wizards_route,$paramsWizard)

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.orders.bankReviewOrder";

        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.orders.orderPaymentsManager";

        ?>
    @include($wizards_route,$paramsWizard)

@elseif ($configPartial['typeManager'] === 'managerRepairProductByBusiness')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.fix.repairProductByBusiness";
        ?>
    @include($wizards_route,$paramsWizard)
@elseif($configPartial['typeManager']=='managerBusinessByDiscount')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.discounts.businessByDiscount.discountByProducts";
        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.discounts.businessByDiscount";
        ?>
    @include($wizards_route,$paramsWizard)

@elseif($configPartial['typeManager']=='managerBusinessByShippingRate')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.shippingRate.businessByShippingRate";

        ?>
    @include($wizards_route,$paramsWizard)

@elseif($configPartial['typeManager']=='managerBusinessByGamification')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.gamification.gamificationByRewards";
        ?>
    @include($wizards_route,$paramsWizard)

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.gamification.gamificationByProcess";
        ?>
    @include($wizards_route,$paramsWizard)
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.gamification.businessByGamification";
        ?>
    @include($wizards_route,$paramsWizard)
@elseif($configPartial['typeManager']=='managerGamificationTypeActivity')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.gamification.gamificationTypeActivity";
        ?>
    @include($wizards_route,$paramsWizard)

    {{--  hospital--}}
@elseif ($configPartial['typeManager'] === 'managerAllergies')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.hospital.allergies";
        ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerHabits')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.hospital.habits";

        ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerPatient')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.hospital.patient";
        ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerMailingTemplate')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.mailing.mailingTemplate";

        ?>
    @include($wizards_route,$paramsWizard)

@elseif ($configPartial['typeManager'] === 'managerMikrotikRateLimit')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.mikrotik.mikrotikRateLimit";

        ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerMikrotikTypeConection')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.mikrotik.mikrotikTypeConection";

        ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerMikrotikDhcpServer')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.mikrotik.mikrotikDhcpServer";

        ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerMikrotikByCustomerEngagement')

        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.mikrotik.mikrotikByCustomerEngagement";
        ?>
    @include($wizards_route,$paramsWizard)

@elseif ($configPartial['typeManager'] === 'managerWorkPlanningHeader')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.workPlanning.workPlanningHeader";
        ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerProjectHeader')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.projects.projectHeader";
        ?>
    @include($wizards_route,$paramsWizard)

@elseif ($configPartial['typeManager'] === 'managerHumanResourcesScheduleType')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.payRoll.humanResourcesScheduleType";
        ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerHumanResourcesPermissionType')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.payRoll.humanResourcesPermissionType";
        ?>
    @include($wizards_route,$paramsWizard)
@elseif ($configPartial['typeManager'] === 'managerDashboard')
        <?php
        $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.dashboard.dashboard";
        ?>
    @include($wizards_route,$paramsWizard)
@endif

