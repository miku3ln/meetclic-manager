
<{{$configProcess['entity-process']}}-component
    ref='ref{{$configProcess['model']}}'
    :params='managerProcessBusiness.configData{{$configProcess['model']}}'
    v-on:_{{$configProcess['entityCamel']}}-emit="_updateParentByChildren($event)"
>

</{{$configProcess['entity-process']}}-component>
