
{{--CPP-007--}}
<project-header-component

        ref="reProjectHeader"
        :params="managerProcessBusiness.configDataProjectHeader"
        v-on:_ProjectHeader-emit="_updateParentByChildren($event)"

></project-header-component>
