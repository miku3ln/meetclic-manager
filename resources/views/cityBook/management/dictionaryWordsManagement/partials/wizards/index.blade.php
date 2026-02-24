<div class="administration-data">
    <div class="row">
        <div class="col-md-12">
            <div class="row" id="actions-process" v-if="[-1].includes(configDataRegisterForm.view_type)">
                <div class="col-md-6">
                    <button @click="createRegisterForm()" class="btn btn-success btn--manager-process" v-form-text="'actions.create'">
                    </button>

                </div>

            </div>
            <div class="row" v-if="[-1].includes(configDataRegisterForm.view_type)">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form__label "
                        >
                            Diccionario
                        </label>

                        <div class="content-element-form">
                            <select
                                v-model.trim="modelFilters.typeDictionary"
                                id="typeDictionary"
                                name="typeDictionary"
                                class="form-control m-input form-select"
                                @change="onSetValuesForm('typeDictionary', modelFilters.typeDictionary)"
                            >
                                <option
                                    v-for="(row,index) in dataTypeDictionary"
                                    v-bind:value="row.id"><?php echo '{{row.text}}' ?>
                                </option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>
            <div class="manager-process" v-if="[0,1].includes(configDataRegisterForm.view_type)">
                <register-form-component
                    ref="refRegisterForm"
                    :params="configDataRegisterForm"
                    v-on:_actions-emit="_updateParentByChildren($event)"

                ></register-form-component>

            </div>

            <grid-registers-component v-if="[-1].includes(configDataRegisterForm.view_type)"
                                      ref="refPointsSales"
                                      :params="configDataRegisterForm"
                                      v-on:_actions-emit="_updateParentByChildren($event)"

            ></grid-registers-component>
        </div>
    </div>
</div>



