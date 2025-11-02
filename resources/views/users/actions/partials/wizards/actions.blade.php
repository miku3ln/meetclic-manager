<actions-component

        ref="refActions"
        :params="configDataActions"
        v-on:_actions-emit="_updateParentByChildren($event)"

></actions-component>
