<script type='text/x-template' id='unit-measure-by-data-template'>
    <div>

        <div class='content-component'>
            <div v-if="configModalData.viewAllow">
                <language-template-business-history-by-data-component
                    ref="refLanguageBusinessHistoryByData"
                    :params="configModalData"
                >
                </language-template-business-history-by-data-component>
            </div>

            <b-modal
                hide-footer
                no-enforce-focus
                no-close-on-backdrop
                id="modal-unit-measure-data"
                ref="refUnitMeasureByDataModal"
                dialog-class="modal-unit-measure-data"
                size="xl"
                <?php echo '@show="_showModal"' ?><?php echo '@hidden="_hideModal"' ?><?php echo '@ok="_saveModal"' ?>>
                <template slot="modal-title">
                    <label v-html="labelsConfig.title"></label>
                </template>
                <b-container class="container-manager-buttons">

                    <div class="content-row-manager-buttons">
                        <button
                            v-if="!managerMenuConfig.view"
                            type="button"
                            class="btn "
                            :class="{'btn-success':!showManager,'btn-danger':showManager}"
                            v-on:click="_viewManager(showManager?2:1)">
                            <?php echo "{{showManager?'Regresar':'Nuevo'}}" ?>    </button>
                        <button v-if="showManager" type="button"
                                :disabled="!validateForm()"
                                class="btn btn-success "
                                v-on:click="_saveModel()">
                            <?php echo '{{managerType==1?labelsConfig.buttons.save:labelsConfig.buttons.update}}' ?>    </button>

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
                <div id="management-conversion">
                    <b-form
                        v-if="!showManager"
                        id="conversion"

                    >
                        <!-- =====================================================
                             TIPO DE CONVERSIÓN
                             ===================================================== -->
                        <b-form-group
                            label="Tipo de conversión"
                            label-for="conversion-type"
                        >
                            <b-row>

                                <b-col md="3">
                                    <b-form-select
                                        id="conversion-type"
                                        v-model="formConversion.type"
                                        :options="formConversion.typeData.map(function (item) {
                return {
                    value: item.id,
                    text: item.value
                };
            })"
                                    />
                                </b-col>
                                <template v-if="formConversion.type === 'string'">
                                    <b-col md="4">

                                        <b-form-group
                                            label="Desde"
                                            label-for="conversion-from"
                                        >
                                            <b-form-input
                                                id="conversion-from"
                                                v-model.trim="formConversion.from"
                                                type="text"
                                                placeholder="Ej: 10g, 1pollo"
                                            />

                                            <small class="text-muted">
                                                Ingrese cantidad y símbolo.
                                            </small>
                                        </b-form-group>

                                    </b-col>

                                    <b-col md="4">

                                        <b-form-group
                                            label="Hacia"
                                            label-for="conversion-to"
                                        >
                                            <b-form-input
                                                id="conversion-to"
                                                v-model.trim="formConversion.to"
                                                type="text"
                                                placeholder="Ej: kg, u, pollo"
                                            />

                                            <small class="text-muted">
                                                Ingrese únicamente el símbolo destino.
                                            </small>
                                        </b-form-group>

                                    </b-col>
                                </template>
                            </b-row>
                            <b-row v-if="managerResultConversion.success">
                                <div class="col-md-12">
                                    <div class="measure-conversion__formula"><i
                                            class="fas fa-check-circle measure-conversion__formula-icon"></i><span
                                            class="measure-conversion__formula-value"><?php echo "{{managerResultConversion.mapperResult.input}}"?> = <strong><?php echo "{{managerResultConversion.mapperResult.output}}"?> </strong></span>
                                    </div>
                                </div>
                            </b-row>
                        </b-form-group>


                        <template v-if="formConversion.type === 'data'">

                            <b-row>

                                <!-- CANTIDAD -->

                                <b-col md="4">

                                    <b-form-group
                                        label="Cantidad"
                                        label-for="conversion-amount"
                                    >
                                        <b-form-input
                                            id="conversion-amount"
                                            v-model.number="formConversion.amount"
                                            type="number"
                                            min="0"
                                            step="any"
                                            placeholder="Ej: 10"
                                        />
                                    </b-form-group>

                                </b-col>


                                <!-- FROM DATA -->

                                <b-col md="4">

                                    <b-form-group
                                        label="Unidad origen"
                                        label-for="conversion-from-data"
                                    >
                                        <select
                                            id="conversion_from_unit_measure_id_data"
                                            class="form-control m-select2"
                                            v-initConversionS2FromUnitMeasure="{

                        onInitS2:conversionS2FromUnitMeasure
                    }"
                                        >
                                        </select>
                                    </b-form-group>



                                </b-col>


                                <!-- TO DATA -->

                                <b-col md="4">

                                    <b-form-group
                                        label="Unidad destino"
                                        label-for="conversion-to-data"
                                    >
                                        <select
                                            id="conversion_to_unit_measure_id_data"
                                            class="form-control m-select2"
                                            v-initConversionS2ToUnitMeasure="{
                        onInitS2:conversionS2ToUnitMeasure
                    }"
                                        >
                                        </select>
                                    </b-form-group>

                                </b-col>

                            </b-row>

                        </template>


                        <!-- =====================================================
                             ACCIONES
                             ===================================================== -->

                        <div class="d-flex justify-content-end mt-3">

                            <b-button
                                type="button"
                                variant="primary"
                                v-on:click="onConversionData()"
                                :disabled="isFormConversionValid()"

                            >
                                Convertir
                            </b-button>

                        </div>

                    </b-form>
                </div>

                <div class="content-form" v-if="showManager">
                    <div class="d-block ">
                        <b-form id="MeasureConversionByDataForm" v-on:submit.prevent="_submitForm">

                            <b-container>
                                <!-- =====================================================
                                     CONFIGURACIÓN DE LA CONVERSIÓN
                                     ===================================================== -->
                                <b-row>

                                    <!-- TIPO DE CONVERSIÓN -->
                                    <b-col md="6">

                                        <div
                                            class="form-group"
                                            :class="getClassErrorForm(
                'conversion_type',
                $v.model.attributes.conversion_type
            )"
                                        >

                                            <label
                                                class="form__label"
                                                v-html='getLabelForm("conversion_type")'
                                            ></label>

                                            <div class="content-element-form">

                                                <select
                                                    v-model="$v.model.attributes.conversion_type.$model"
                                                    v-bind:id="getNameAttribute('conversion_type')"
                                                    v-bind:name="getNameAttribute('conversion_type')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm(
                        'conversion_type',
                        $v.model.attributes.conversion_type.$model
                    )"
                                                >

                                                    <option
                                                        v-for="(row,index) in model.structure.conversion_type.options"
                                                        v-bind:key="index"
                                                        v-bind:value="row.value"
                                                    >
                                                        <?php echo '{{row.text}}' ?>
                                                    </option>

                                                </select>

                                            </div>

                                            <div class="content-message-errors">

                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.conversion_type.$error"
                                                >
                    <span
                        v-if="!$v.model.attributes.conversion_type.required"
                    >
                        <?php echo "{{model.structure.conversion_type.required.msj}}" ?>
                    </span>

                                                    <span
                                                        v-if="!$v.model.attributes.conversion_type.maxLength"
                                                    >
                        <?php echo "{{model.structure.conversion_type.maxLength.msj}}" ?>
                    </span>
                                                </b-form-invalid-feedback>

                                            </div>

                                        </div>

                                    </b-col>

                                </b-row>


                                <!-- =====================================================
                                     CONVERSIÓN VISUAL
                                     ===================================================== -->

                                <div class="measure-conversion">

                                    <div class="measure-conversion__header">

                                        <div>
                                            <div class="measure-conversion__title">
                                                Conversión
                                            </div>

                                            <div class="measure-conversion__subtitle">
                                                Define a cuánto equivale 1 unidad de origen.
                                            </div>
                                        </div>

                                    </div>


                                    <div class="measure-conversion__body">

                                        <!-- =====================================================
                                             1
                                             ===================================================== -->

                                        <div class="measure-conversion__fixed">

                                            <label class="measure-conversion__small-label">
                                                Cantidad
                                            </label>

                                            <div class="measure-conversion__fixed-value">
                                                1
                                            </div>

                                        </div>


                                        <!-- =====================================================
                                             UNIDAD ORIGEN
                                             ===================================================== -->

                                        <div
                                            class="measure-conversion__unit"
                                            :class="getClassErrorForm(
                'from_unit_measure_id_data',
                $v.model.attributes.from_unit_measure_id_data
            )"
                                        >

                                            <label class="measure-conversion__small-label">
                                                Unidad origen
                                            </label>

                                            <div class="content-element-form content-element-form--select2">

                                                <input
                                                    v-model="$v.model.attributes.from_unit_measure_id_data.model"
                                                    type="hidden"
                                                    v-bind:id="getNameAttribute('from_unit_measure_id_data')"
                                                    v-bind:name="getNameAttribute('from_unit_measure_id_data')"
                                                    @change="_setValueForm(
                        'from_unit_measure_id_data',
                        $v.model.attributes.from_unit_measure_id_data.$model
                    )"
                                                >

                                                <select
                                                    id="from_unit_measure_id_data"
                                                    class="form-control m-select2"
                                                    v-initManagerS2FromUnitMeasure="{
                        rowId:model.attributes.id,
                        onInitS2:managerS2FromUnitMeasure
                    }"
                                                >
                                                </select>

                                            </div>

                                            <div class="content-message-errors">

                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.from_unit_measure_id_data.$error"
                                                >
                    <span
                        v-if="!$v.model.attributes.from_unit_measure_id_data.required"
                    >
                        <?php echo "{{model.structure.from_unit_measure_id_data.required.msj}}" ?>
                    </span>
                                                </b-form-invalid-feedback>

                                            </div>

                                        </div>


                                        <!-- =====================================================
                                             IGUAL
                                             ===================================================== -->

                                        <div class="measure-conversion__equal">
                                            =
                                        </div>


                                        <!-- =====================================================
                                             FACTOR
                                             ===================================================== -->

                                        <div
                                            class="measure-conversion__factor"
                                            :class="getClassErrorForm(
                'factor',
                $v.model.attributes.factor
            )"
                                        >

                                            <label class="measure-conversion__small-label">
                                                Cantidad
                                            </label>

                                            <div class="content-element-form">

                                                <input
                                                    v-model.number="$v.model.attributes.factor.$model"
                                                    type="number"
                                                    step="any"
                                                    min="0"
                                                    v-bind:id="getNameAttribute('factor')"
                                                    v-bind:name="getNameAttribute('factor')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm(
                        'factor',
                        $v.model.attributes.factor.$model
                    )"
                                                    v-focus-select
                                                >

                                            </div>

                                            <div class="content-message-errors">

                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.factor.$error"
                                                >
                    <span
                        v-if="!$v.model.attributes.factor.required"
                    >
                        <?php echo "{{model.structure.factor.required.msj}}" ?>
                    </span>
                                                </b-form-invalid-feedback>

                                            </div>

                                        </div>


                                        <!-- =====================================================
                                             UNIDAD DESTINO
                                             ===================================================== -->

                                        <div
                                            class="measure-conversion__unit"
                                            :class="getClassErrorForm(
                'to_unit_measure_id_data',
                $v.model.attributes.to_unit_measure_id_data
            )"
                                        >

                                            <label class="measure-conversion__small-label">
                                                Unidad destino
                                            </label>

                                            <div class="content-element-form content-element-form--select2">

                                                <input
                                                    v-model="$v.model.attributes.to_unit_measure_id_data.model"
                                                    type="hidden"
                                                    v-bind:id="getNameAttribute('to_unit_measure_id_data')"
                                                    v-bind:name="getNameAttribute('to_unit_measure_id_data')"
                                                    @change="_setValueForm(
                        'to_unit_measure_id_data',
                        $v.model.attributes.to_unit_measure_id_data.$model
                    )"
                                                >

                                                <select
                                                    id="to_unit_measure_id_data"
                                                    class="form-control m-select2"
                                                    v-initManagerS2ToUnitMeasure="{
                        rowId:model.attributes.id,
                        onInitS2:managerS2ToUnitMeasure
                    }"
                                                >
                                                </select>

                                            </div>

                                            <div class="content-message-errors">

                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.to_unit_measure_id_data.$error"
                                                >
                    <span
                        v-if="!$v.model.attributes.to_unit_measure_id_data.required"
                    >
                        <?php echo "{{model.structure.to_unit_measure_id_data.required.msj}}" ?>
                    </span>
                                                </b-form-invalid-feedback>

                                            </div>

                                        </div>

                                    </div>


                                    <!-- =====================================================
                                         RESULTADO VISUAL
                                         ===================================================== -->

                                    <div
                                        class="measure-conversion__result"
                                        v-if="
            $v.model.attributes.from_unit_measure_id_data.model &&
            $v.model.attributes.to_unit_measure_id_data.model &&
            $v.model.attributes.factor.$model
        "
                                    >

                                        <i class="fa fa-check-circle"></i>

                                        <span>
            1 unidad de origen equivale a
            <strong>
                <?php echo '{{ $v.model.attributes.factor.$model }}"' ?>
            </strong>
            unidad(es) de destino
        </span>

                                    </div>

                                </div>


                                <!-- =====================================================
                                     DESCRIPCIÓN
                                     ===================================================== -->

                                <b-row class="mt-4">

                                    <b-col md="12">

                                        <div
                                            class="form-group"
                                            :class="getClassErrorForm(
                'description',
                $v.model.attributes.description
            )"
                                        >

                                            <label
                                                class="form__label"
                                                v-html='getLabelForm("description")'
                                            ></label>

                                            <div class="content-element-form">

                <textarea
                    rows="3"
                    class="form-control"
                    v-model.trim="$v.model.attributes.description.$model"
                    v-bind:id="getNameAttribute('description')"
                    v-bind:name="getNameAttribute('description')"
                    @change="_setValueForm(
                        'description',
                        $v.model.attributes.description.$model
                    )"
                    v-focus-select
                    placeholder="Ej. 1 pollo entero = 9 presas"
                ></textarea>

                                            </div>

                                            <div class="content-message-errors">

                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.description.$error"
                                                >
                    <span
                        v-if="!$v.model.attributes.description.maxLength"
                    >
                        <?php echo "{{model.structure.description.maxLength.msj}}" ?>
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

                <div class="content-manager-grid">

                    <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                        <table id="unit-measure-by-data-grid"
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
            </b-modal>


        </div>
    </div>
</script>

