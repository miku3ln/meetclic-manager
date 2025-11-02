<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$pathCurrent = 'mikrotik/managerEvents';
?>
@section('additional-scripts')

    <script>
        var $managerViewData =  <?php echo json_encode($managerViewData)?>;
    </script>
    <script src="{{ asset($resourcePathServer.'assets/libs/moment/moment.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/vue-bootstrap/vue-bootstrap.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/uiv/uiv.min.js')}}"></script>

    <script type="text/x-template" id="mikrotik-manager-events-template">
        <div>

            <button type="button"
                    :disabled="!validateForm()"
                    class="btn btn-success " v-on:click="_saveModel()">
                <?php echo "{{lblBtnSave}}"?>
            </button>
            <div class="content-form">

                <b-form id="rucTypeForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"
                                     :class="getClassErrorForm('mikrotik',$v.model.attributes.mikrotik)">
                                    <label class="form__label " v-html='getLabelForm("mikrotik")' ></label>
                                    <div class="content">
                                        <select class="form-control"
                                                v-model.trim="$v.model.attributes.mikrotik.$model"
                                                v-bind:id="getNameAttribute('mikrotik')"
                                                v-bind:name="getNameAttribute('mikrotik')"
                                                @change="__select($event,'mikrotik')"
                                        >
                                            <option v-for="row in model.structure.mikrotik.data" :value="row.id"
                                                    :key="row.id"><?php echo "{{ row.name+'-' +row.ip}}" ?></option>
                                        </select>

                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.mikrotik.$error">
                                            <span v-if="!$v.model.attributes.mikrotik.required">
                                <?php  echo "{{model.structure.mikrotik.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"
                                     :class="getClassErrorForm('type_event',$v.model.attributes.type_event)">
                                    <label class="form__label " v-html='getLabelForm("type_event")' ></label>
                                    <div class="content">
                                        <select class="form-control"
                                                v-model.trim="$v.model.attributes.type_event.$model"
                                                v-bind:id="getNameAttribute('type_event')"
                                                v-bind:name="getNameAttribute('type_event')"
                                                @change="__select($event,'type_event')"
                                        >
                                            <option v-for="row in model.structure.type_event.data" :value="row.id"
                                                    :key="row.id"><?php echo "{{ row.name+'-'+row.command}}" ?></option>
                                        </select>

                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.type_event.$error">
                                            <span v-if="!$v.model.attributes.type_event.required">
                                <?php  echo "{{model.structure.type_event.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="$v.model.attributes.type_event.$model==4 || $v.model.attributes.type_event.$model==5">
                            <div class="col-md-12">

                                <div class="form-group"
                                     :class="getClassErrorForm('mikrotik_code',$v.model.attributes.mikrotik_code)">
                                    <label
                                        class="form__label " v-html='getLabelForm("mikrotik_code")' ></label>
                                    <div class="content">
                                        <textarea
                                            class="form-control"
                                            v-model.trim="$v.model.attributes.mikrotik_code.$model"
                                            v-bind:id="getNameAttribute('mikrotik_code')"
                                            v-bind:name="getNameAttribute('mikrotik_code')"
                                            @change="_setValueForm('mikrotik_code',$v.model.attributes.mikrotik_code.$model)"
                                             rows="10">
                                        </textarea>
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.mikrotik_code.$error">
                                            <span v-if="!$v.model.attributes.mikrotik_code.required">
                                <?php  echo "{{model.structure.mikrotik_code.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </b-container>

                    <div class="row">
                        <div class="col-md-12 manager-results" v-if="writingResult.viewSuccess">
                            <div class="other-results" v-if="writingResult.others" v-html="writingResult.html">

                            </div>
                            <div class="results" v-if="writingResult.view" v-html="writingResult.html">

                            </div>
                        </div>
                    </div>
                </b-form>

            </div>


        </div>

    </script>
    <script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/App.js') }}" type="text/javascript"></script>

@endsection
@section('additional-styles')


@endsection
@extends('layouts.masterMinton')

@section('content')
    <input id="action-mikrotik-manager-events-managerEventResultsMikrotik" type="hidden"
           value="{{ route("managerEventResultsMikrotik") }}"/>


    <div id="app-management">
        <div id="tab-mikrotik-manager-events-">
            <mikrotik-manager-events-component
                ref="refMikrotikManagerEvents"
                :params="configDataMikrotikManagerEvents"
                v-on:_actions-emit="_updateParentByChildren($event)"

            ></mikrotik-manager-events-component>
        </div>
    </div>

@endsection

