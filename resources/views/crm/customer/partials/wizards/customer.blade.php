<customer-component

        ref="refCustomer"
        :params="configDataCustomer"
        v-on:_actions-emit="_updateParentByChildren($event)"

></customer-component>
