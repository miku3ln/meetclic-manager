<patient-component
ref='refPatient'
:params='managerProcessBusiness.configDataPatient'
v-on:_patient-emit="_updateParentByChildren($event)"
>

</patient-component>
