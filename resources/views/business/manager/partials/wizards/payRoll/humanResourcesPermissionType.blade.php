
<human-resources-permission-type-component

        ref="reHumanResourcesPermissionType"
        :params="managerProcessBusiness.configDataHumanResourcesPermissionType "
        v-on:_HumanResourcesPermissionType-emit="_updateParentByChildren($event)"

></human-resources-permission-type-component>
