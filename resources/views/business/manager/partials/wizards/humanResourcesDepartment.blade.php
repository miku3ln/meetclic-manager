
<human-resources-department-component

        ref="reHumanResourcesDepartment"
        :params="managerProcessBusiness.configDataHumanResourcesDepartment"
        v-on:_humanResourcesDepartment-emit="_updateParentByChildren($event)"

></human-resources-department-component>
