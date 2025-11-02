
{{--CPP-007--}}
<work-planning-header-component

        ref="reWorkPlanningHeader"
        :params="managerProcessBusiness.configDataWorkPlanningHeader"
        v-on:_workPlanningHeader-emit="_updateParentByChildren($event)"

></work-planning-header-component>
