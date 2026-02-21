<input id="action-dictionary_by_words-getAdmin" type="hidden"
       value="{{route('getDictionaryKichwaToCastilianAdmin',app()->getLocale())}}"/>
<section id="sec2" v-show="managerRow.view" class="section-grid">
    <div class="container--manager-dictionary">
        <div class="row">
            <div class="col-md-4">
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
        <div class="row">
            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive">

                    <table
                        v-init-bootgrid="{id:'dictionary_by_words-grid',type:'dictionary'}"
                        id="dictionary_by_words-grid"
                    >
                        <thead>
                        <tr>
                            <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                            <th data-column-id="value" data-formatter="value">Palabras</th>

                        </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
</section>
