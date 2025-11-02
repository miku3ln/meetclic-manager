<script type="text/x-template" id="business-by-menu-management-frontend-template">
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
                    <div class="content-manager-buttons-grid ready" ng-if="managerMenuConfig.view">

                        <a
                            v-init-tool-tip
                            v-for="(menu, key) in managerMenuConfig.menuCurrent"
                            v-bind:id="'a-menu-'+menu.rowId"
                            v-on:click="_managerMenuGrid(key, menu)"
                            class="content-manager-buttons-grid__a " data-toggle="tooltip"
                            data-placement="top" v-bind:data-original-title="<?php echo 'menu.title' ?>">
                            <i v-bind:class="<?php echo 'menu.icon' ?>"></i>
                        </a>
                    </div>
                </div>

            </div>
        </b-container>

        <div class="content-manager-grid">

            <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                <table id="business-by-menu-management-frontend-grid"
                       class=""

                >
                    <thead>
                    <tr>
                        <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                        <th data-column-id="description" data-formatter="description">Descripción</th>

                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="content-form" v-if="showManager">

            <b-form id="LodgingForm" v-on:submit.prevent="_submitForm">

                <input v-model="model.attributes.id" type="hidden"

                       v-bind:id="getNameAttribute('id')"
                       v-bind:name="getNameAttribute('id')"
                >
                <input v-model="model.attributes.business_id" type="hidden"
                       v-bind:id="getNameAttribute('business_id')"
                       v-bind:name="getNameAttribute('business_id')">
                <b-container>
                    <b-row>

                        <b-col md="2">
                            <div class="form-group"
                                 :class="getClassErrorForm('type_item',$v.model.attributes.type_item)">
                                <label class="form__label " v-html='getLabelForm("type_item")' ></label>
                                <div class="content">
                                    <switch-button
                                        v-bind:id="getNameAttribute('type_item')"
                                        v-bind:name="getNameAttribute('type_item')"
                                        v-on:toggle="_typeItem"
                                        v-model="$v.model.attributes.type_item.$model"
                                        color="#34bfa3">
                                    </switch-button>
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.type_item.$error">
                                            <span v-if="!$v.model.attributes.type_item.required">
                                <?php  echo "{{model.structure.type_item.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>


                    </b-row>
                    <b-row>
                        <b-col md="2">
                            <div class="form-group"
                                 :class="getClassErrorForm('type',$v.model.attributes.type)">
                                <label class="form__label " v-html='getLabelForm("type")' ></label>
                                <div class="content">
                                    <select v-model.trim="$v.model.attributes.type.$model"
                                            type="number"
                                            v-bind:id="getNameAttribute('type')"
                                            v-bind:name="getNameAttribute('type')"
                                            class="form-control m-input"
                                            @change="_setValueForm('type', $event.target.value)"

                                    >
                                        <option v-for="(typeRow,index) in dataType"
                                                v-bind:value="typeRow.id"><?php echo '{{typeRow.text}}' ?></option>
                                    </select>
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.type.$error">
                                            <span v-if="!$v.model.attributes.type.required">
                                <?php  echo "{{model.structure.type.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="5"
                               v-if="$v.model.attributes.type_item.$model==true && ($v.model.attributes.type.$model ==2 ||$v.model.attributes.type.$model ==3) ">
                            <div class="form-group"
                                 :class="getClassErrorForm('parent_id_data',$v.model.attributes.parent_id_data)">
                                <label class="form__label " v-html='getLabelForm("parent_id_data")' ></label>
                                <div class="content">
                                    <input type="hidden"
                                           v-model.trim="$v.model.attributes.parent_id_data.$model"
                                           v-bind:id="getNameAttribute('parent_id_data')"
                                           v-bind:name="getNameAttribute('parent_id_data')"
                                           @change="_setValueForm('parent_id_data', $event.target.value)"
                                    >
                                    <select
                                        id="parent_id_data"
                                        class="form-control m-select2 parent_id_data"
                                        v-initS2="{model:model.attributes.id,_managerS2Action:_managerS2Action}"
                                    >
                                    </select>


                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.parent_id_data.$error">
                                            <span v-if="!$v.model.attributes.parent_id_data.required">
                                <?php  echo "{{model.structure.parent_id_data.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>

                    </b-row>
                    <b-row>
                        <b-col md="2">
                            <div class="form-group"
                                 :class="getClassErrorForm('weight',$v.model.attributes.weight)">
                                <label class="form__label " v-html='getLabelForm("weight")' ></label>
                                <div class="content">
                                    <input
                                        v-model.trim="$v.model.attributes.weight.$model"
                                        type="number"
                                        v-bind:id="getNameAttribute('weight')"
                                        v-bind:name="getNameAttribute('weight')"
                                        class="form-control m-input"
                                        @change="_setValueForm('weight', $event.target.value)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.weight.$error">
                                            <span v-if="!$v.model.attributes.weight.required">
                                <?php  echo "{{model.structure.weight.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>

                        <b-col md="4" >
                            <div class="form-group"
                                 :class="getClassErrorForm('icon',$v.model.attributes.icon)">
                                <label class="form__label " v-html='getLabelForm("icon")' ></label>
                                <div class="content">
                                    <input
                                        v-model.trim="$v.model.attributes.icon.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('icon')"
                                        v-bind:name="getNameAttribute('icon')"
                                        class="form-control m-input"
                                        @change="_setValueForm('icon', $event.target.value)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.icon.$error">
                                            <span v-if="!$v.model.attributes.icon.required">
                                <?php  echo "{{model.structure.icon.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>
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

                        <b-col md="6"  v-if="$v.model.attributes.type.$model==2 ||$v.model.attributes.type.$model==3  ||$v.model.attributes.type.$model==0">
                            <div class="form-group"
                                 :class="getClassErrorForm('link',$v.model.attributes.link)">
                                <label class="form__label " v-html='getLabelForm("link")' ></label>
                                <div class="content">
                                    <input
                                        v-model.trim="$v.model.attributes.link.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('link')"
                                        v-bind:name="getNameAttribute('link')"
                                        class="form-control m-input"
                                        @change="_setValueForm('link', $event.target.value)"
                                        v-focus-select

                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.link.$error">
                                            <span v-if="!$v.model.attributes.link.required">
                                <?php  echo "{{model.structure.link.required.msj}}"?>
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
                                            name="Lodging[description]"
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
