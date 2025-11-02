<product-service-component
ref='refProductService'
:params='managerProcessBusiness.configDataProductService'
v-on:_product-service-emit="_updateParentByChildren($event)"
>

</product-service-component>
