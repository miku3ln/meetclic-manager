<entity-plans-component 
ref='refEntityPlans' 
:params='configDataEntityPlans' 
v-on:_entityPlans-emit="_updateParentByChildren($event)"
>

</entity-plans-component>
