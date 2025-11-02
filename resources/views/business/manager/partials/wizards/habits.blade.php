<habits-component
ref='refHabits'
:params='managerProcessBusiness.configDataHabits'
v-on:_habits-emit="_updateParentByChildren($event)"
>

</habits-component>
