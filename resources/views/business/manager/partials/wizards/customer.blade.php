{{--BUSINESS-MANAGER-CRM-COMPONENT--}}

<customer-component

        ref="refCustomer"
        :params="managerProcessBusiness.configDataCustomer"
        v-on:_actions-emit="_updateParentByChildren($event)"

></customer-component>
