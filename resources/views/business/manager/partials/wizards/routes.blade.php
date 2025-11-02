
<routes-component

        ref="childRoutes"
        :params="managerProcessBusiness.configDataRoutes"
        v-on:_data-components-children="_updateParentByChildren($event)"

></routes-component>
