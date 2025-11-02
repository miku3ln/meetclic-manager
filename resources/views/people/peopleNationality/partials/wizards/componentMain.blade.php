<{{$configPartial["modelNameAction"]}}-component
ref='ref{{$configPartial["modelName"]}}'
:params='configData{{$configPartial["modelName"]}}'
v-on:_{{$configPartial["moduleFolder"]}}-emit="_updateParentByChildren($event)"
>
</{{$configPartial["modelNameAction"]}}-component>

