
{{--CPP-007--}}
<human-resources-organizational-chart-area-component

        ref="reHumanResourcesOrganizationalChartArea"
        :params="managerProcessBusiness.configDataHumanResourcesOrganizationalChartArea"
        v-on:_humanResourcesOrganizationalChartArea-emit="_updateParentByChildren($event)"

></human-resources-organizational-chart-area-component>
