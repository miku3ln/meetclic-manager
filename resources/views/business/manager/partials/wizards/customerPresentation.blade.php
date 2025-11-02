{{--BUSINESS-MANAGER-CRM-CUSTOMER-PRESENTATION-COMPONENT--}}

<{{$configProcess['entity-process-down']}}-component

        ref="refCustomerPresentation"
        :params="managerProcessBusiness.configDataCustomerPresentation"
        v-on:_actions-emit="_updateParentByChildren($event)"

></{{$configProcess['entity-process-down']}}-component>
