
<lodging-component

        ref="reLodging"
        :params="managerProcessBusiness.configDataLodging"
        v-on:_lodging-emit="_updateParentByChildren($event)"

></lodging-component>
