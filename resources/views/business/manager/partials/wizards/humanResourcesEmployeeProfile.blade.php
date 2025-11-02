
<human-resources-employee-profile-component

        ref="reHumanResourcesEmployeeProfile"
        :params="managerProcessBusiness.configDataHumanResourcesEmployeeProfile"
        v-on:_humanResourcesEmployeeProfile-emit="_updateParentByChildren($event)"

></human-resources-employee-profile-component>
