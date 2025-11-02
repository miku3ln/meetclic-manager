{{--BUSINESS-MANAGER-CRM-DELIVERY-CRUD--}}

@section('css')
    <style>
        .not-view{
            display: none !important;
        }
        .split-line {
            border-bottom: 1px solid #000000;
            width: 100%;
        }
        .numberBox{
          font-size: 35px;
        }
        .titleBodyThree{
            padding-left:1%;
        }
        .titleBodyThreeTh{
            width: 125px;
        }.numberBoxTh{
             width: 125px;
         }
        .row.manager-print {
            position: fixed;
            top: 24%;
            z-index: 1500;
        }
    </style>
@endsection
<script type='text/x-template' id='delivery-by-business-manager-template'>
    <div>

        <div class='content-component'>


            <b-modal
                hide-footer
                id="modal-delivery-by-business-manager"
                ref="refDeliveryByBusinessManagerModal"
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
                            <?php echo '{{labelsConfig.buttons.save}}' ?>    </button>

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

                <div class="content-form" v-if="showManager">
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="row manager-print">
                        <b-container >
                            <b-row v-if="$v.model.attributes.id.$model!=null">
                                <b-col md="4" class="manager-print__check">
                                    <input v-model="viewManagerPrint.print  "
                                           type="checkbox"
                                           id="print_view"
                                           name="print_view"
                                           @change="_setValueFormPrint('print_view', viewManagerPrint.print)"
                                    >
                                </b-col>
                                <div class="manager-print__content" v-if="viewManagerPrint.print" >
                                    <div class="col-md-4">
                                        <div class="inline-data"
                                             v-if="allowViewPrint()">
                                            <a data-toggle="tooltip" data-placement="top"
                                               v-on:click="_printLabelGenerate()"
                                               data-original-title="Imprimir" class="btn--xs content-manager-buttons-grid__a ">
                                                <i class="fas fa-print"></i></a>
                                        </div>
                                    </div>

                                </div>
                            </b-row>

                        </b-container>

                    </div>
                    <div class="manager-content-data-form-print" v-if="viewManagerPrint.print">

                        <div class="row">


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label
                                        class="form__label ">Numero Caja Impresion</label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="printLabelConfig.numberPrint"
                                            type="number"
                                            id="numberPrint"
                                            name="numberPrint"
                                            class="form-control m-input"
                                            @change="_setValueFormPrintValue('numberPrint', printLabelConfig.numberPrint)"
                                            v-focus-select
                                        >
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div id="print-data">
                            <div class="row-print" v-for="i in  getLimitIndex()" :key="i" style=" height:1706.01px;">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="advice" id="advice" v-html="printLabelConfig.advice">

                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <img class="img-business" id="img-business"
                                             v-bind:src="printLabelConfig.logoBusiness">


                                    </div>
                                </div>
                                <div class="split-line"></div>
                                <div class="row">
                                    <div class="col-12">
                                        <h3 id="titleOneInit"> <?php echo '{{printLabelConfig.title}}' ?></h3>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-8">
                                        <div class="business" id="business" v-html="printLabelConfig.business">

                                        </div>
                                        <div class="businessOne" id="businessOne" v-html="printLabelConfig.businessOne">

                                        </div>
                                        <div class="businessAddressOne" id="businessAddressOne"
                                             v-html="printLabelConfig.businessAddressOne">

                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <h4 id="titleInformationOne"> <?php echo '{{printLabelConfig.titleInformationOne}}' ?></h4>
                                        <div class="phoneOne" id="phoneOne" v-html=" printLabelConfig.phoneOne">

                                        </div>
                                        <div class="phoneTwo" id="phoneTwo" v-html="printLabelConfig.phoneTwo">

                                        </div>
                                        <h4 id="titleInformationTwo"> <?php echo '{{printLabelConfig.titleInformationTwo}}' ?></h4>
                                        <div class="pageOne" id="pageOne" v-html="printLabelConfig.pageOne">

                                        </div>
                                    </div>
                                </div>
                                <div class="split-line"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 id="titleBodyOne" v-html=" printLabelConfig.titleBodyOne">

                                        </h1>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="customerFullName" v-html="getDataHtmlBody('customerFullName')">

                                        </div>
                                        <div id="customerIdentificationDocument" class="not-view"
                                             v-html="getDataHtmlBody('customerIdentificationDocument')">

                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-md-12">
                                        <div id="customerAddressIdData"
                                             v-html="getDataHtmlBody('customerAddressIdData')">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="customerPhoneIdData" v-html="getDataHtmlBody('customerPhoneIdData')">

                                        </div>
                                    </div>
                                </div>
                                <div class="split-line"></div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 id="titleBodyTwo" v-html=" printLabelConfig.titleBodyTwo">

                                        </h1>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="description" v-html="getDataHtmlBody('description')">

                                        </div>
                                    </div>

                                </div>
                                <div class="split-line"></div>
                                <div class="row">
                                    <table class="tbl-number-box">
                                        <tbody>
                                            <tr>
                                                <th class="titleBodyThreeTh">
                                                    <h1 class="titleBodyThree" v-html=" printLabelConfig.titleBodyThree">

                                                    </h1>
                                                </th>
                                                <th class="numberBoxTh">
                                                    <span id="numberBox"   class="numberBox" style=" font-size: 75px;" v-html="getDataHtmlBody('numberBox',i)">

                                                    </span>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                                <div class="split-line"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 id="titleBodyFour" v-html=" printLabelConfig.titleBodyFour">

                                        </h1>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="numberInvoice" v-html="getDataHtmlBody('numberInvoice')">

                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-12 content-data">
                                        <div id="code-invoice"
                                             v-initCodeBar="{code: $v.model.attributes.number_invoice.$model,_method:_initCodeBar}">

                                        </div>
                                    </div>

                                </div>
                                <div class="split-line"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 id="titleBodyFive" v-html="printLabelConfig.titleBodyFive">

                                        </h1>
<span id="titleBodyFiveNumber">

    <?php echo '{{$v.model.attributes.id.$model}}'?></button>

</span>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-12 content-data">
                                        <div id="code-id" class="not-view"
                                             v-initCodeBar="{code: $v.model.attributes.id.$model,_method:_initCodeBar}">

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="manager-content-data-form"
                         :class="getClassViewFormPrint('manager-content-data-form',viewManagerPrint.print)">
                        <div class="d-block ">
                            <b-form id="deliveryByBusinessManagerForm" v-on:submit.prevent="_submitForm">
                                <b-container>
                                    <input v-model="model.attributes.id" type="hidden"
                                           v-bind:id="getNameAttribute('id')"
                                           v-bind:name="getNameAttribute('id')"
                                    >
                                    <b-row>
                                        <b-col md="4">
                                            <div class="form-group"
                                                 :class="getClassErrorForm('status',$v.model.attributes.status)">
                                                <label
                                                    class="form__label " v-html='getLabelForm("status")' ></label>
                                                <div class="content-element-form">
                                                    <select v-model.trim="$v.model.attributes.status.$model"
                                                            v-bind:id="getNameAttribute('status')"
                                                            v-bind:name="getNameAttribute('status')"
                                                            class="form-control m-input"
                                                            @change="_setValueForm('status', $v.model.attributes.status.$model)"
                                                    >
                                                        <option v-for="(row,index) in model.structure.status.options"
                                                                v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="content-message-errors">
                                                    <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.status.$error">
      <span v-if="!$v.model.attributes.status.required">
       <?php echo "{{model.structure.status.required.msj}}" ?>
      </span>
                                                    </b-form-invalid-feedback>
                                                </div>
                                            </div>

                                        </b-col>

                                    </b-row>
                                    <b-row>
                                        <b-col md="4">
                                            <div class="form-group"
                                                 :class="getClassErrorForm('address_id_data',$v.model.attributes.address_id_data)">
                                                <label
                                                    class="form__label " v-html='getLabelForm("address_id_data")' ></label>
                                                <div class="content-element-form">
                                                    <input v-model="$v.model.attributes.address_id_data.model"
                                                           type="hidden"
                                                           v-bind:id="getNameAttribute('address_id_data')"
                                                           v-bind:name="getNameAttribute('address_id_data')"
                                                           @change="_setValueForm('address_id_data', $v.model.attributes.address_id_data.$model)"
                                                    >
                                                    <select id="address_id_data"
                                                            class="form-control m-select2 "
                                                            v-initS2DeliveryByBusinessManagerAddress="{rowId:model.attributes.id,_method:_managerS2DeliveryByBusinessManagerAddress}"
                                                    >
                                                    </select>
                                                </div>
                                                <div class="content-message-errors">
                                                    <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.address_id_data.$error">
      <span v-if="!$v.model.attributes.address_id_data.required">
       <?php echo "{{model.structure.address_id_data.required.msj}}" ?>
      </span>
                                                    </b-form-invalid-feedback>
                                                </div>
                                            </div>
                                        </b-col>
                                        <b-col md="4">
                                            <div class="form-group"
                                                 :class="getClassErrorForm('phone_id_data',$v.model.attributes.phone_id_data)">
                                                <label
                                                    class="form__label " v-html='getLabelForm("phone_id_data")' ></label>
                                                <div class="content-element-form">
                                                    <input v-model="$v.model.attributes.phone_id_data.model"
                                                           type="hidden"
                                                           v-bind:id="getNameAttribute('phone_id_data')"
                                                           v-bind:name="getNameAttribute('phone_id_data')"
                                                           @change="_setValueForm('phone_id_data', $v.model.attributes.phone_id_data.$model)"
                                                    >
                                                    <select id="phone_id_data"
                                                            class="form-control m-select2 "
                                                            v-initS2DeliveryByBusinessManagerPhone="{rowId:model.attributes.id,_method:_managerS2DeliveryByBusinessManagerPhone}"
                                                    >
                                                    </select>
                                                </div>
                                                <div class="content-message-errors">
                                                    <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.phone_id_data.$error">
      <span v-if="!$v.model.attributes.phone_id_data.required">
       <?php echo "{{model.structure.phone_id_data.required.msj}}" ?>
      </span>
                                                    </b-form-invalid-feedback>
                                                </div>
                                            </div>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col md="4">
                                            <div class="form-group"
                                                 :class="getClassErrorForm('number_invoice',$v.model.attributes.number_invoice)">
                                                <label
                                                    class="form__label " v-html='getLabelForm("number_invoice")' ></label>
                                                <div class="content-element-form">
                                                    <input
                                                        v-model.trim="$v.model.attributes.number_invoice.$model"
                                                        type="text"
                                                        v-bind:id="getNameAttribute('number_invoice')"
                                                        v-bind:name="getNameAttribute('number_invoice')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('number_invoice', $v.model.attributes.number_invoice.$model)"
                                                        v-focus-select
                                                    >
                                                </div>
                                                <div class="content-message-errors">
                                                    <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.number_invoice.$error">
      <span v-if="!$v.model.attributes.number_invoice.required">
       <?php echo "{{model.structure.number_invoice.required.msj}}" ?>
      </span>
                                                        <span v-if="!$v.model.attributes.number_invoice.unique">
       <?php echo "{{model.structure.number_invoice.unique.msj}}" ?>
      </span>
                                                    </b-form-invalid-feedback>
                                                </div>
                                            </div>

                                        </b-col>

                                        <b-col md="4">
                                            <div class="form-group"
                                                 :class="getClassErrorForm('number_box',$v.model.attributes.number_box)">
                                                <label
                                                    class="form__label " v-html='getLabelForm("number_box")' ></label>
                                                <div class="content-element-form">
                                                    <input
                                                        v-model.trim="$v.model.attributes.number_box.$model"
                                                        type="number"
                                                        min="1"
                                                        v-bind:id="getNameAttribute('number_box')"
                                                        v-bind:name="getNameAttribute('number_box')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('number_box', $v.model.attributes.number_box.$model)"
                                                        v-focus-select
                                                    >
                                                </div>
                                                <div class="content-message-errors">
                                                    <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.number_box.$error">
      <span v-if="!$v.model.attributes.number_box.required">
       <?php echo "{{model.structure.number_box.required.msj}}" ?>
      </span>
                                                        <span v-if="!$v.model.attributes.number_box.minLength">
       <?php echo "{{model.structure.number_box.minLength.msj}}" ?>
      </span>
                                                    </b-form-invalid-feedback>
                                                </div>
                                            </div>

                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col md="12">
                                            <div class="form-group"
                                                 :class="getClassErrorForm('description',$v.model.attributes.description)">
                                                <label
                                                    class="form__label " v-html='getLabelForm("description")' ></label>
                                                <div class="content-element-form">
<textarea
    maxlength="147"
    rows="5" class="form-control"
    v-model.trim="$v.model.attributes.description.$model"
    v-bind:id="getNameAttribute('description')"
    v-bind:name="getNameAttribute('description')"
    @change="_setValueForm('description', $v.model.attributes.description.$model)"
    v-focus-select
></textarea>
                                                </div>
                                                <div class="content-message-errors">
                                                    <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.description.$error">
                                                    </b-form-invalid-feedback>
                                                </div>
                                            </div>

                                        </b-col>
                                    </b-row>
                                </b-container>


                            </b-form>
                        </div>
                    </div>
                </div>

                <div class="content-manager-grid">

                    <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                        <table id="delivery-by-business-manager-grid"
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

