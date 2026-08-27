<script type='text/x-template' id='unit-measure-template'>
    <div>
        <div v-if="configModalUnitMeasureByData.viewAllow">
            <unit-measure-by-data-component
                ref="refTUnitMeasureByData"
                :params="configModalUnitMeasureByData"
            >
            </unit-measure-by-data-component>
        </div>

        <div class='content-component'>


            <b-container class="container-manager-buttons">

                <div class="content-row-manager-buttons">
                    <button
                        v-if="!managerMenuConfig.view"
                        type="button"
                        class="btn "
                        :class="{'btn-success':!showManager,'btn-danger':showManager}"
                        v-on:click="_viewManager(showManager?2:1)">
                        <?php  echo "{{showManager?'Regresar':'Nuevo'}}" ?>
                    </button>
                    <button
                        v-if="!managerMenuConfig.view"
                        type="button"
                        class="btn btn-info"
                        title="Conversiones"
                        v-on:click="managerConversion([])"
                    >
                        <i class="fas fa-ruler"></i> Conversiones
                    </button>
                    <button v-if="showManager" type="button"
                            :disabled="!validateForm()"
                            class="btn btn-success "
                            v-on:click="_saveModel()">
                        <?php echo '{{managerType==1?labelsConfig.buttons.create:labelsConfig.buttons.update}}'?></button>


                    <div v-if="!showManager">
                        <div class="content-manager-buttons-grid ready" v-if="managerMenuConfig.view">
                            <menu-admin-grid
                                @input="_managerRowGrid($event)"
                                :manager-menu-config="managerMenuConfig">

                            </menu-admin-grid>

                        </div>
                    </div>
                </div>
            </b-container>

            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                    <table id="unit-measure-grid"
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
                <b-form id="unitMeasureForm" v-on:submit.prevent="_submitForm">

                    <b-container>

                        <!-- ID -->
                        <input
                            v-model="model.attributes.id"
                            type="hidden"
                            v-bind:id="getNameAttribute('id')"
                            v-bind:name="getNameAttribute('id')"
                        >


                        <!-- =====================================================
                             TIPO DE MEDIDA
                             ===================================================== -->
                        <b-row>

                            <!-- =====================================================
                                 ESTADO
                                 ===================================================== -->

                            <b-col md="4">

                                <div
                                    class="form-group"
                                    :class="getClassErrorForm(
                        'state',
                        $v.model.attributes.state
                    )"
                                >

                                    <label
                                        class="form__label"
                                        v-html='getLabelForm("state")'
                                    ></label>

                                    <div class="content-element-form">

                                        <select
                                            v-model.trim="$v.model.attributes.state.$model"
                                            v-bind:id="getNameAttribute('state')"
                                            v-bind:name="getNameAttribute('state')"
                                            class="form-control m-input"
                                            @change="_setValueForm(
                                'state',
                                $v.model.attributes.state.$model
                            )"
                                        >

                                            <option
                                                v-for="(row,index) in model.structure.state.options"
                                                v-bind:key="index"
                                                v-bind:value="row.value"
                                            >
                                                <?php echo '{{row.text}}' ?>
                                            </option>

                                        </select>

                                    </div>

                                    <div class="content-message-errors">

                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.state.$error"
                                        >

                            <span
                                v-if="!$v.model.attributes.state.required"
                            >
                                <?php echo "{{model.structure.state.required.msj}}" ?>
                            </span>

                                        </b-form-invalid-feedback>

                                    </div>

                                </div>

                            </b-col>
                            <b-col md="4">

                                <div
                                    class="form-group"
                                    :class="getClassErrorForm(
                        'product_measure_type_id_data',
                        $v.model.attributes.product_measure_type_id_data
                    )"
                                >

                                    <label
                                        class="form__label"
                                        v-html='getLabelForm("product_measure_type_id_data")'
                                    ></label>

                                    <div class="content-element-form">

                                        <select
                                            v-model="$v.model.attributes.product_measure_type_id_data.$model"
                                            v-bind:id="getNameAttribute('product_measure_type_id_data')"
                                            v-bind:name="getNameAttribute('product_measure_type_id_data')"
                                            class="form-control m-input"
                                            @change="_setValueForm(
                                'product_measure_type_id_data',
                                $v.model.attributes.product_measure_type_id_data.$model
                            )"
                                        >
                                            <option
                                                v-for="(row,index) in model.structure.product_measure_type_id_data.options"
                                                v-bind:key="index"
                                                v-bind:value="row"
                                            >
                                                <?php echo '{{row.text}}' ?>
                                            </option>

                                        </select>

                                    </div>

                                    <div class="content-message-errors">

                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.product_measure_type_id_data.$error"
                                        >

                            <span
                                v-if="!$v.model.attributes.product_measure_type_id_data.required"
                            >
                                <?php echo "{{model.structure.product_measure_type_id_data.required.msj}}" ?>
                            </span>

                                        </b-form-invalid-feedback>

                                    </div>

                                </div>

                            </b-col>


                            <!-- UNIDAD BASE -->
                            <b-col md="4">

                                <div
                                    class="form-group"
                                    :class="getClassErrorForm(
                        'is_base',
                        $v.model.attributes.is_base
                    )"
                                >

                                    <label
                                        class="form__label"
                                        v-html='getLabelForm("is_base")'
                                    ></label>

                                    <div class="content-element-form">

                                        <select
                                            v-model.number="$v.model.attributes.is_base.$model"
                                            v-bind:id="getNameAttribute('is_base')"
                                            v-bind:name="getNameAttribute('is_base')"
                                            class="form-control m-input"
                                            @change="_setValueForm(
                                'is_base',
                                $v.model.attributes.is_base.$model
                            )"
                                        >

                                            <option
                                                v-for="(row,index) in model.structure.is_base.options"
                                                v-bind:key="index"
                                                v-bind:value="row.value"
                                            >
                                                <?php echo '{{row.text}}' ?>
                                            </option>

                                        </select>

                                    </div>

                                    <div class="content-message-errors">

                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.is_base.$error"
                                        ></b-form-invalid-feedback>

                                    </div>

                                </div>

                            </b-col>


                        </b-row>


                        <!-- =====================================================
                             NOMBRE / SÍMBOLO
                             ===================================================== -->

                        <b-row>

                            <b-col md="8">

                                <div
                                    class="form-group"
                                    :class="getClassErrorForm(
                        'name',
                        $v.model.attributes.name
                    )"
                                >

                                    <label
                                        class="form__label"
                                        v-html='getLabelForm("name")'
                                    ></label>

                                    <div class="content-element-form">

                                        <input
                                            v-model.trim="$v.model.attributes.name.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('name')"
                                            v-bind:name="getNameAttribute('name')"
                                            class="form-control m-input"
                                            @change="_setValueForm(
                                'name',
                                $v.model.attributes.name.$model
                            )"
                                            v-focus-select
                                        >

                                    </div>

                                    <div class="content-message-errors">

                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.name.$error"
                                        >

                            <span
                                v-if="!$v.model.attributes.name.required"
                            >
                                <?php echo "{{model.structure.name.required.msj}}" ?>
                            </span>

                                            <span
                                                v-if="!$v.model.attributes.name.maxLength"
                                            >
                                <?php echo "{{model.structure.name.maxLength.msj}}" ?>
                            </span>

                                        </b-form-invalid-feedback>

                                    </div>

                                </div>

                            </b-col>


                            <b-col md="4">

                                <div
                                    class="form-group"
                                    :class="getClassErrorForm(
                        'symbol',
                        $v.model.attributes.symbol
                    )"
                                >

                                    <label
                                        class="form__label"
                                        v-html='getLabelForm("symbol")'
                                    ></label>

                                    <div class="content-element-form">

                                        <input
                                            v-model.trim="$v.model.attributes.symbol.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('symbol')"
                                            v-bind:name="getNameAttribute('symbol')"
                                            class="form-control m-input"
                                            @change="_setValueForm(
                                'symbol',
                                $v.model.attributes.symbol.$model
                            )"
                                            v-focus-select
                                        >

                                    </div>

                                    <div class="content-message-errors">

                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.symbol.$error"
                                        >

                            <span
                                v-if="!$v.model.attributes.symbol.required"
                            >
                                <?php echo "{{model.structure.symbol.required.msj}}" ?>
                            </span>

                                            <span
                                                v-if="!$v.model.attributes.symbol.maxLength"
                                            >
                                <?php echo "{{model.structure.symbol.maxLength.msj}}" ?>
                            </span>

                                        </b-form-invalid-feedback>

                                    </div>

                                </div>

                            </b-col>

                        </b-row>


                        <!-- =====================================================
                             FACTOR / PRECISIÓN / UNIDAD BASE
                             ===================================================== -->

                        <b-row>

                            <!-- FACTOR -->
                            <b-col md="4">

                                <div
                                    class="form-group"
                                    :class="getClassErrorForm(
                        'factor_to_base',
                        $v.model.attributes.factor_to_base
                    )"
                                >

                                    <label
                                        class="form__label"
                                        v-html='getLabelForm("factor_to_base")'
                                    ></label>

                                    <div class="content-element-form">

                                        <input
                                            v-model.number="$v.model.attributes.factor_to_base.$model"
                                            type="number"
                                            step="any"
                                            v-bind:id="getNameAttribute('factor_to_base')"
                                            v-bind:name="getNameAttribute('factor_to_base')"
                                            class="form-control m-input"
                                            @change="_setValueForm(
                                'factor_to_base',
                                $v.model.attributes.factor_to_base.$model
                            )"
                                            v-focus-select
                                        >

                                    </div>

                                    <div class="content-message-errors">

                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.factor_to_base.$error"
                                        >

                            <span
                                v-if="!$v.model.attributes.factor_to_base.required"
                            >
                                <?php echo "{{model.structure.factor_to_base.required.msj}}" ?>
                            </span>

                                        </b-form-invalid-feedback>

                                    </div>

                                </div>

                            </b-col>


                            <!-- PRECISIÓN DECIMAL -->
                            <b-col md="4">

                                <div
                                    class="form-group"
                                    :class="getClassErrorForm(
                        'decimal_precision',
                        $v.model.attributes.decimal_precision
                    )"
                                >

                                    <label
                                        class="form__label"
                                        v-html='getLabelForm("decimal_precision")'
                                    ></label>

                                    <div class="content-element-form">

                                        <input
                                            v-model.number="$v.model.attributes.decimal_precision.$model"
                                            type="number"
                                            min="0"
                                            v-bind:id="getNameAttribute('decimal_precision')"
                                            v-bind:name="getNameAttribute('decimal_precision')"
                                            class="form-control m-input"
                                            @change="_setValueForm(
                                'decimal_precision',
                                $v.model.attributes.decimal_precision.$model
                            )"
                                            v-focus-select
                                        >

                                    </div>

                                    <div class="content-message-errors">

                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.decimal_precision.$error"
                                        ></b-form-invalid-feedback>

                                    </div>

                                </div>

                            </b-col>



                        </b-row>

                    </b-container>

                </b-form>

            </div>


        </div>
    </div>
</script>

