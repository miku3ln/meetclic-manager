
<search-manager-component

        :params="configDataSearchManager"
        v-on:_data-components-children="_updateParentByChildren($event)"
        ref="_emitParentToSearchManager"
></search-manager-component>
