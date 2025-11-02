<?php
$modelAFI = $configPartial['modelsManager']['modelAFI'];
$user = $configPartial['user'];
?>
<script type='text/x-template' id='educational-institution-by-business-template'>


    <div>
        <div id="content-form-view" v-if="viewsManager.results">
            <div class="form-actions-askwer">
                <div class="row">
                    <div class="col-md-12 nsy_buttons">

                        <button v-on:click="_viewManager(2)" class="btn btn-danger mr-5 btn" id="btn-cancel"
                                type="button">
                            Regresar
                        </button>

                    </div>
                </div>
            </div>
            <div class="content-data-view-result ">
                <div class="manager-form">
                    <h1> Nombre Formulario- <span v-html="askwerManager.managerAskwer.askwer_form"></span></h1>
                    <h2> Tipo Formulario- <span
                            v-html="askwerManager.managerAskwer.educational_institution_askwer_type"></span></h2>

                </div>
                <div class="empty-askwers" v-if="askwerManager.resultsAnswers.length==0">
                    No existe formularios realizados.
                </div>
                <div v-for="(field_row, keyField)  in askwerManager.resultsAnswers">
                    <h1>Test # <?php echo '{{keyField+1}}' ?> </h1>
                    <div v-for="(section, keySection) in field_row.answers" class="content-form smart-form">
                        <div v-bind:id="'section-'+section.section_id"
                             class="text-center section-content__title-results ">
                            <?php echo '{{section.section_name}}'; ?>
                        </div>
                        <table class="tbl-result">
                            <th><strong>Pregunta del cuestionario </strong></th>
                            <th><strong>Respuestas </strong></th>
                            <tr v-for="(x, keyX)  in section.fields">
                                <td>
                                    <div class=" <?php echo "{{x.answer?'questions':'not-questions'}}" ?>">
                                        <strong><?php echo '{{x.name}}' ?></strong></div>
                                </td>
                                <td>

                                    <div v-html="getValuesByFieldType(x)"></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php ?>
                </div>

            </div>
        </div>
        <b-container class="container-manager-buttons" v-if="viewsManager.admin">

            <div class="content-row-manager-buttons">

                <button
                    v-if="!managerMenuConfig.view"
                    type="button"
                    class="btn btn-success "
                    v-on:click="_viewManager(1)">
                    <?php  echo "Crear " ?></button>

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


        <div id="content-form-view" resize v-if="viewsManager.managerForm">
            <div class="form-actions-askwer">
                <div class="row">
                    <div class="col-md-12 nsy_buttons">

                        <button
                            v-on:click="_saveAskwerSolution()"
                            class="btn btn-success btn"
                            :disabled="!validateFormAskwer()"
                            type="button">Realizar
                        </button>
                        <button v-on:click="_viewManager(2)" class="btn btn-danger mr-5 btn" id="btn-cancel"
                                type="button">
                            Regresar
                        </button>

                    </div>
                </div>
            </div>

            <form class="form-horizontal form-horizonta--view"
                  <?php echo 'v-bind:name=askwerManager.nameFormManager'?> novalidate>
                <fieldset>

                    <div v-for="(section, key) in askwerManager.sections" class="content-form smart-form">
                        <h3 v-bind:id="'section-'+section.id"
                            class="text-center askwer-section"> <?php echo '{{section.name}}'?></h3>


                        <div class="form-group form-group--question askwer-row"

                             :class="getClassErrorModel(section.id,field_row)"
                             v-for="(field_row, keyField)  in section.fields">
                            <b-row>

                                <label class="col-md-3 control-label  askwer-label form__label">

                                    <?php echo '{{field_row.label}}'?>
                                    <span v-if="field_row.validate" class='required'>*</span>
                                </label>
                                <b-col md="9">
                                    <div v-if="field_row.widget_type == 1">

                                        <input
                                            class="form-control"
                                            v-bind:name="field_row.name_parent"
                                            placeholder="Ingrese la Información."
                                            v-bind:type="field_row.type=='email'?'email':'text'"
                                            v-model="askwerManager.modelsSolutions[section.id][field_row.id + '_' + field_row.field_type]"
                                            required
                                            v-focus-select
                                            @change="_changeValues(section.id, field_row,askwerManager.modelsSolutions[section.id][field_row.id + '_' + field_row.field_type],1)"
                                        />

                                    </div>
                                    <div v-if="field_row.widget_type == 4">
                                        {{--BOOLEAN--}}

                                        <switch-button
                                            v-on:toggle="_changeValues(section.id, field_row,askwerManager.modelsSolutions[section.id][field_row.id + '_' + field_row.field_type],1)"
                                            v-model="askwerManager.modelsSolutions[section.id][field_row.id + '_' + field_row.field_type]"
                                            color="#34bfa3">
                                        </switch-button>

                                    </div>
                                    <div v-if="field_row.widget_type == 6">


                                        <star-rating
                                            inactive-color="#000"
                                            active-color="#cc1166"
                                            :increment="1"
                                            v-bind:name="field_row.name_parent"
                                            v-model="askwerManager.modelsSolutions[section.id][field_row.id + '_' + field_row.field_type]"
                                            :max-rating="getNumberStars(field_row.fieldOptions[0].label)"
                                            :show-rating="false"
                                            @rating-selected="rating=_changeValues(section.id, field_row,askwerManager.modelsSolutions[section.id][field_row.id + '_' + field_row.field_type],1)"
                                        >
                                        </star-rating>

                                    </div>
                                    <div v-if="field_row.widget_type == 5">
                                        <input

                                            v-focus-select
                                            type="date"
                                            class="form-control field-date"
                                            @change="_changeValues(section.id, field_row,askwerManager.modelsSolutions[section.id][field_row.id + '_' + field_row.field_type],1)"
                                            v-model="askwerManager.modelsSolutions[section.id][field_row.id + '_' + field_row.field_type]"
                                            v-bind:name="'input_'+field_row.id + '_' + field_row.field_type"
                                            placeholder="Seleccione la fecha."/>
                                    </div>
                                    <div v-if="field_row.widget_type == 7">
                                        <textarea

                                            cols="50" rows="3"
                                            class="form-control custom-scroll"
                                            v-bind:name="field_row.name_parent"
                                            placeholder="Ingrese la Información."
                                            v-model="askwerManager.modelsSolutions[section.id][field_row.id + '_' + field_row.field_type]"
                                            v-focus-select
                                            @change="_changeValues(section.id, field_row,askwerManager.modelsSolutions[section.id][field_row.id + '_' + field_row.field_type],1)"
                                        >
                                        </textarea>


                                    </div>
                                    <div v-if="field_row.widget_type == 2">
                                        <input

                                            v-show="false"
                                            v-bind:name="'input_'+field_row.id + '_' + field_row.field_type"
                                            placeholder="Ingrese la Información." type="text"
                                            v-model="askwerManager.modelsSolutions[section.id][field_row.id + '_' + field_row.field_type]"
                                            v-focus-select


                                        />

                                        <div v-if="field_row.comment_allow == 0">
                                            <div v-for="(option, keyOption)   in field_row.fieldOptions">
                                                <input
                                                    v-model="askwerManager.modelsSolutions[section.id][field_row.id + '_' + field_row.field_type]"
                                                    type="radio"
                                                    @change="_selectedRadio(section.id,option,field_row)"
                                                    v-bind:value="option.id"
                                                    v-bind:name="'field-radio-' + field_row.id"/>
                                                <label
                                                    v-bind:for="'field-radio-' + field_row.id"> <?php echo '{{option.label}}';?></label>

                                            </div>
                                        </div>
                                        <div class="comment_allow-if" v-if="field_row.comment_allow == '1'">

                                            <div v-for="(option, keyOption)   in field_row.fieldOptions">

                                                <input
                                                    v-model="askwerManager.modelsSolutions[section.id][field_row.id + '_' + field_row.field_type]"
                                                    type="radio"
                                                    @change="_selectedRadio(section.id,option,field_row)"
                                                    v-bind:value="option.id"
                                                    v-bind:name="'field-radio-' + field_row.id"/>
                                                <label
                                                    v-bind:for="'field-radio-' + field_row.id"> <?php echo '{{option.label}}';?></label>

                                                <input

                                                    v-bind:id="'comment_allow_'+section.id + '_' +  field_row.id+'_'+option.id"
                                                    v-model="askwerManager.radioButtonsValidations[section.id][field_row.id][option.id]['model']"
                                                    v-bind:name="'field-radio-comment-allow-' + field_row.id+'-'+option.id"

                                                />

                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="field_row.widget_type == 3">
                                        <input

                                            v-show="false"
                                            v-bind:name="'input_'+field_row.id + '_' + field_row.field_type"
                                            placeholder="Ingrese la Información." type="text"
                                            v-model="askwerManager.modelsSolutions[section.id][field_row.id + '_' + field_row.field_type]"

                                        />


                                        <div v-if="field_row.comment_allow == 0" v-bind:section="section.id"
                                             v-bind:field_row="field_row.id">

                                            <div v-for="(option, keyOption)   in field_row.fieldOptions"
                                                 v-bind:option="option.id">

                                                <input
                                                    v-model="askwerManager.checkbox[section.id]['checkbox' + '_' + field_row.id][option.id]"
                                                    type="checkbox"
                                                    @change="_selectedCheckbox(section.id,option,field_row)"
                                                    v-bind:value="option.id"
                                                    v-bind:name="'field-radio-' + field_row.id"
                                                    v-bind:class="'group-checklist-' + section.id+'-' + field_row.id"
                                                />
                                                <label
                                                    v-bind:for="'field-radio-' + field_row.id"> <?php echo '{{option.label}}';?></label>

                                            </div>
                                        </div>
                                        <div class="comment_allow-check" v-if="field_row.comment_allow == '1'"
                                             v-bind:section="section.id" v-bind:field_row="field_row.id">

                                            <div v-for="(option, keyOption)   in field_row.fieldOptions"
                                                 v-bind:option="option.id">

                                                <input
                                                    v-model="askwerManager.checkbox[section.id]['checkbox' + '_' + field_row.id][option.id]"
                                                    type="checkbox"
                                                    @input="_selectedCheckbox(section.id,option,field_row)"
                                                    v-bind:value="option.id"
                                                    v-bind:name="'field-radio-' + field_row.id"
                                                    v-bind:id="'field-radio-' + section.id+'-' + field_row.id+'-'+option.id"
                                                    v-bind:class="'group-checklist-' + section.id+'-' + field_row.id"
                                                    v-bind:option_id="option.id"

                                                />
                                                <label
                                                    v-bind:for="'field-radio-' + field_row.id"> <?php echo '{{option.label}}';?></label>

                                                <input
                                                    v-if="askwerManager.checkButtonsValidations[section.id][field_row.id][option.id]['required']"
                                                    v-bind:id="'comment_allow_'+section.id + '_' +  field_row.id+'_'+option.id"
                                                    v-model="askwerManager.checkButtonsValidations[section.id][field_row.id][option.id]['model']"

                                                    v-bind:name="'field-radio-comment-allow-' + field_row.id+'-'+option.id"/>
                                            </div>

                                        </div>

                                    </div>


                                    <span class="messages-errors">


                                </span>
                                </b-col>

                            </b-row>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>

        <div id="content-manager-admin" v-show="viewsManager.admin">
            <table id="educational-institution-by-business-grid"
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
        <form id="askwer-form-form">
            <div id="content-manager-form" v-show="viewsManager.form">

                <?php
                $optionsFields = array(

                    array("text" => "Texto", "value" => $modelAFI::FIELD_TYPE_TEXT),
                    array("text" => "Selección Simple", "value" => $modelAFI::FIELD_TYPE_SIMPLE),
                    array("text" => "Selección Multiple", "value" => $modelAFI::FIELD_TYPE_MULTIPLE),
                    array("text" => "Verdadero/Falso", "value" => $modelAFI::FIELD_TYPE_BOOLEAN),
                    array("text" => "Fecha", "value" => $modelAFI::FIELD_TYPE_DATE),
                    array("text" => "Rating", "value" => $modelAFI::FIELD_TYPE_RATING)


                );
                if ($user->id != 1) {
                    $optionsFields = array(
                        array("text" => "Selección Simple", "value" => $modelAFI::FIELD_TYPE_SIMPLE),
                        array("text" => "Selección Multiple", "value" => $modelAFI::FIELD_TYPE_MULTIPLE),

                    );
                }
                $viewAll = false;


                ?>

                <input data-bind="value:id" name="AskwerForm[id]" id="AskwerForm_id" type="hidden">
                <input data-bind="value:iha_id" name="AskwerForm[iha_id]" id="AskwerForm_iha_id" type="hidden">
                <input data-bind="value:business_id" name="AskwerForm[business_id]" id="AskwerForm_business_id"
                       type="hidden">

                <div id="msj-errors" class="alert alert-block alert-warning"
                     data-bind="css: {'not-view-msj' : view_msj() === 0,'view-msj':view_msj() === 1 }">
                    <h4 class="alert-heading" data-bind="text: infoTitle"></h4>
                    <span data-bind="text: myMessage"></span>
                </div>
                <fieldset>

                    <legend>Ingrese los datos del Formulario</legend>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label required">Tipo
                                    Formulario <span class="required">*</span></label>
                                <select
                                    required="required"
                                    id="AskwerForm_educational_institution_askwer_type_id_data"
                                    class="form-control m-select2"
                                    data-bind="value:educational_institution_askwer_type_id_data"
                                >
                                </select>
                                <input name="AskwerForm[educational_institution_askwer_type_id]"
                                       id="AskwerForm_educational_institution_askwer_type_id" type="hidden">

                                <div class="help-block error"
                                     for="AskwerForm_educational_institution_askwer_type_id_data"
                                     style="display:none">

                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label required">Nombre
                                    Formulario <span class="required">*</span></label>
                                <input
                                    required="required"
                                    data-bind="value:name"
                                    class="form-control"
                                    placeholder="Nombre Formulario"
                                    name="AskwerForm[name]"
                                    id="AskwerForm_name"
                                    type="text">
                                <div class="help-block error" for="AskwerForm_name" style="display:none">

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label required" for="AskwerForm_description">
                                    Descripcion <span class="required">*</span></label>

                                <textarea
                                    required="required"
                                    data-bind="value:description"
                                    rows="8" cols="50"
                                    class="form-control"
                                    placeholder="Descripción*"
                                    name="AskwerForm[description]"
                                    id="AskwerForm_description"
                                >

                    </textarea>
                                <div class="help-block error" id="AskwerForm_description_em_"
                                     style="display:none">

                                </div>
                            </div>

                        </div>
                    </div>
                </fieldset>

                <div class="nsy_field_editor">
                    <h3>Cuestionario Formulario</h3>

                    <div class="nsy_sections_container"
                         data-bind="sortable: {data: sections, allowDrop: false, connectClass:'nsy_sections_container', afterMove:updateSectionPosition, options:{handle:'.nsy_section_header',axis:'y'}}">
                        <div class="nsy_section">
                            <div class="nsy_section_header">
                                <span data-bind="editable: name"></span>
                                <a class="close" data-bind="click: $root.removeSection">&times;</a>
                            </div>

                            <div class="btn-group dropdown">
                                <a class="btn btn-mini dropdown-toggle nsy_add_field dropbtn"
                                   data-toggle="dropdown"
                                   href="#">
                                   AGREGAR CAMPO <span
                                        class="caret"></span>
                                </a>
                                <div class="dropdown-menu askwer-drop dropdown-content" id="">
                                <?php
                                foreach ($optionsFields as $key => $value) {
                                    $valueCurrent = "'" . $value["value"] . "'";
                                    $text = $value["text"];

                                    $optionsHtml = '     <a data-bind="click: addField.bind($data,' . $valueCurrent . ' )"> ' . $text . '</a>';
                                    echo $optionsHtml;
                                }
                                ?>
                                <!-- ko if: $root.createdFields().length!=0 -->
                                    <!--<li class="divider"></li>-->
                                <!--<li><a data-bind="click: $root.selectSection"><?php // echo Yii::t('askwerModule.app', 'Load Field')                                                                                                                                                              ?></a></li>-->
                                    <!-- /ko -->
                                </div>
                            </div>

                            <div class="nsy_field_container"
                                 data-bind="sortable: {data: fields, connectClass:'nsy_questions_container', afterMove:updateFieldPosition, as: 'field'}">
                                <div class="nsy_field">
                                    <div>
                                        <label class="nsy_label">LABEL</label>
                                        <textarea type="text" class="nsy_field_label required"
                                                  data-bind="value: label, uniqueName: true"></textarea>
                                        <!-- ko if: availableValidations().length > 0 -->
                                        <a class="btn btn-mini" data-bind="click: toggleValidations"><i
                                                class="icon-ok-circle"></i>Validations
                                        </a>
                                        <!-- /ko -->
                                        <span class="nsy_field_type not-view">
                                                (<?php echo 'Field Type' ?>:
                                                <span class="bold" data-bind="text: formated_type"></span>
                                                , <?php echo 'Widget Type' ?>:
                                                <span
                                                    data-bind="editable: widget_type, editableOptions: {type: 'select', mode: 'popup', options: availableWidgets, optionsText: 'text', optionsValue: 'value'}"></span>
                                                )

                                </span>

                                        <a class="close" data-bind="click: $parent.removeField">&times;</a>
                                        <a class="btn btn-mini" data-bind="click: toggleDescription"><i
                                                class="icon-info-sign"></i><?php echo 'Description' ?>
                                        </a>
                                        <div class="line" data-bind="visible: showDescription">
                                            <label class="nsy_label"><?php echo 'Description' ?></label>
                                            <textarea class="nsy_field_textarea required txtarea_description"
                                                      data-bind="value: description, uniqueName: true"></textarea>
                                        </div>

                                        <!-- ko if: allowOptions -->
                                        <ol class="nsy_options_container"
                                            data-bind="foreach:{ data: fieldOptions(), as: 'option' }">
                                            <li class="nsy_option">
                                                <div class="row" data-bind="ol:option.option_score">
                                                    <div class="col-sm-10">
                                                        <div data-bind="if: field.field_type==6">
                                                            <input min="0" placeholder="# Estrellas"
                                                                   type="number" class="required"
                                                                   data-bind="value: label, uniqueName: true"/>

                                                        </div>
                                                        <div data-bind="if: field.field_type !=6">
                                                            <input placeholder="Ingrese la opcion de Respuesta."
                                                                   type="text" class="required"
                                                                   data-bind="value: label, uniqueName: true"/>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input placeholder="Puntaje de la respuesta."
                                                               type="number" class="required puntaje"
                                                               data-bind="value: option_score, uniqueName: true"/>
                                                        <a class="close delete-option"
                                                           data-bind="click: $parent.removeOption">&times;</a>
                                                    </div>

                                                </div>
                                            </li>
                                        </ol>
                                        {{--Capital: <b data-bind="text: field.field_type"> </b>--}}
                                        <div data-bind="if: field.field_type ==2 ||field.field_type ==3">
                                            <a class="btn btn-success btn-mini nsy_add_option"
                                               data-bind="click: addOption"><?php echo 'Add Option' ?>
                                            </a>
                                        </div>

                                        <!-- /ko -->
                                        <div class="nsy_validations" data-bind="visible: showValidations">
                                            <label><?php echo 'Validations' ?></label>
                                            <ul data-bind="foreach: availableValidations()">
                                                <li>
                                                    <label>
                                                        <input type="checkbox"
                                                               data-bind="attr:{value: value}, checked: $parent.validations"/>
                                                        <span data-bind="text: text"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="nsy_empty_form" data-bind="visible: sections().length==0">
                        <?php echo 'Empty Form' ?>
                    </div>
                    <div class="manager-bind">
                        <input
                            id="AskwerForm_form_structure"
                            name="AskwerForm[form_structure]"
                            type="hidden"
                            data-bind="value:ko.toJSON($data)"
                        >
                        <input
                            id="AskwerForm_ko_data"
                            name="AskwerForm[ko_data]"
                            type="hidden"
                        >
                        <input type="hidden" value="" name="created_fields" id="created_fields">
                    </div>


                    <div class="form-actions-askwer">
                        <div class="row">
                            <div class="col-md-12 nsy_buttons">
                                <button class="btn btn-small btn-warning btn" data-bind="click: addSection"
                                        type="button">
                                    Add
                                    Section
                                </button>
                                <button class="btn btn-success btn" data-bind="click:doSubmit" type="button">Crear
                                </button>
                                <button v-on:click="_viewManager(2)" class="btn btn-danger mr-5 btn" id="btn-cancel"
                                        type="button">
                                    Cancelar
                                </button>

                            </div>
                        </div>
                    </div>


                </div> {{--END FIELDS MANAGER--}}


            </div>

        </form>
    </div>

</script>
