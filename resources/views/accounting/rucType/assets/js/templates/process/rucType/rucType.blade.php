<script type="text/x-template" id="rucType-template">
    <div>


        <b-container class="bv-example-row">
            <div class="content-row-manager-buttons">

                <button
                        v-if="!managerMenuConfig.view"
                        type="button"
                        class="btn "
                        :class="{'btn-success':!showManager,'btn-danger':showManager}"
                        v-on:click="_viewManager(showManager?2:1)">
                    <?php echo "{{showManager?'Regresar':'Nuevo'}}"?>
                </button>


                <button v-if="showManager" type="button"
                        :disabled="!validateForm()"
                        class="btn btn-success " v-on:click="_saveModel()">
                    <?php echo "{{lblBtnSave}}"?>
                </button>
                <div v-if="!showManager">
                    <div class="content-manager-buttons-grid ready" v-if="managerMenuConfig.view">
                        <menu-admin-grid
                            @input="_managerRowGrid($event)"
                            :manager-menu-config="managerMenuConfig" >

                        </menu-admin-grid>


                    </div>
                </div>

            </div>
        </b-container>

        @include( 'partials.adminViewVue',['title'=>'Ruc Tipos','grid_name'=>'rucType-grid'])

        <div class="content-form" v-if="showManager">

            <b-form id="rucTypeForm" v-on:submit.prevent="_submitForm">

                <input v-model="model.attributes.id" type="hidden"

                       v-bind:id="getNameAttribute('id')"
                       v-bind:name="getNameAttribute('id')"
                >

                <b-container>
                    <b-row>

                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('name',$v.model.attributes.name)">
                                <label class="form__label " v-html='getLabelForm("name")' ></label>
                                <div class="content">
                                    <input
                                            v-model.trim="$v.model.attributes.name.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('name')"
                                            v-bind:name="getNameAttribute('name')"
                                            class="form-control m-input"
                                           @change="_setValueForm('name', $event.target.value)"
                                            v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.name.$error">
                                            <span v-if="!$v.model.attributes.name.required">
                                <?php  echo "{{model.structure.name.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col lg="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('description',$v.model.attributes.description)"
                            >

                                <label class="form__label " v-html='getLabelForm("description")' ></label>

                                <div class="content ">

                                        <textarea
                                                rows="10" cols="50"
                                                v-model.trim="$v.model.attributes.description.$model"
                                                v-bind:id="getNameAttribute('name')"
                                                v-bind:name="getNameAttribute('name')"
                                                class="form-control m-input"
                                               @change="_setValueForm('description', $event.target.value)"
                                                v-focus-select

                                        ></textarea>
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.description.$error">
                                            <span v-if="!$v.model.attributes.description.required">
                                <?php  echo "{{model.structure.description.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                    </b-row>
                </b-container>

            </b-form>

        </div>


    </div>

</script>
