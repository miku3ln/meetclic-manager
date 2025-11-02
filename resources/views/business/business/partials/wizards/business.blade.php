<business-component

        ref="refBusiness"
        :params="configDataBusiness"
        v-on:_actions-emit="_updateParentByChildren($event)"

></business-component>
