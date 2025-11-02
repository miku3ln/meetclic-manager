<business-categories-component 
ref='refBusinessCategories' 
:params='configDataBusinessCategories' 
v-on:_businessCategories-emit="_updateParentByChildren($event)"
>

</business-categories-component>
