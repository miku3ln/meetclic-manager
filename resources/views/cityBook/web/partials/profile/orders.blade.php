
<div class="profile-edit-container">
    <div class="profile-edit-header fl-wrap" style="margin-top:30px">
        <h4> {{__('frontend.account.menu.records.manager.one')}}</h4>
    </div>


    <order-payments-manager-component
        ref='refOrderPaymentsManager'
        :params='configDataOrderPaymentsManager'
        v-on:_orderPaymentsManager-emit="_updateParentByChildren($event)"
    >

    </order-payments-manager-component>
</div>
