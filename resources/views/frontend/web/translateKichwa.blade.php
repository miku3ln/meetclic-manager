<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$urlCurrentImages = url($resourcePathServer . 'images/frontend/translate/');
$pathCurrent = 'frontend/web/translate/';

$semioticsSymbolicInterpretation = [

    [
        '01', 'p', $urlCurrentImages . '/img', 'Piernas,caminar', 'alt+59', 'semiotic', 'INACTIVE'
    ],
    [
        '02', 'k', $urlCurrentImages . '/dede-01.png', 'Brazos,vasija', 'alt+59', 'semiotic', 'ACTIVE'
    ], [
        '03', 'r', $urlCurrentImages . '/img', 'Corazon/piel de la boa', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '04', 's', $urlCurrentImages . '/img', 'Serpiente,rio', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '05', 'g', $urlCurrentImages . '/img', 'Llevar en brazos', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '06', 'ng', $urlCurrentImages . '/img', 'cola de mono', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '07', 'd', $urlCurrentImages . '/img', 'Hombre,papa', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '08', 't', $urlCurrentImages . '/img', 'mujer,mama', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '09', 'm', $urlCurrentImages . '/img', 'cara de jaguar', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '10', 'n', $urlCurrentImages . '/dede-06.png', 'gusano', 'alt+59', 'semiotic', 'ACTIVE'
    ], [
        '11', 'ñ', $urlCurrentImages . '/img', 'cosechar,garra', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '12', 'i/y', $urlCurrentImages . '/img', 'hoja,colmillo', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '13', 'e', $urlCurrentImages . '/img', 'techo,casa', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '14', 'o', $urlCurrentImages . '/img', 'sol,luna', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '15', 'a', $urlCurrentImages . '/dede-07.png', 'boca,piedra,ojo', 'alt+59', 'semiotic', 'ACTIVE'
    ], [
        '16', 'u', $urlCurrentImages . '/dede-08.png', 'bolso,cuenco', 'alt+59', 'semiotic', 'ACTIVE'
    ], [
        '17', 'l', $urlCurrentImages . '/img', 'arriba,montaña,casa', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '18', 'f', $urlCurrentImages . '/img', 'agua cayendo,cascada', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '19', 'w', $urlCurrentImages . '/img', 'gracias,abrazar', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '20', 'x', $urlCurrentImages . '/img', 'vasija con almiento', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '21', 'll', $urlCurrentImages . '/img', 'Centro ,fuego', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '22', 'ch', $urlCurrentImages . '/img', 'vasija con bebida,pareja', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '23', 'sh', $urlCurrentImages . '/img', 'culebra en arbol', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '24', 'ts', $urlCurrentImages . '/img', 'pajaro', 'alt+59', 'semiotic', 'INACTIVE'
    ], [
        '25', 'ku', $urlCurrentImages . '/dede-02.png', '', 'alt+59', 'case-02', 'ACTIVE'
    ]
    , [
        '26', 'na', $urlCurrentImages . '/dede-05.png', '', 'alt+59', 'case-02', 'ACTIVE'
    ], [
        '27', 'nan', $urlCurrentImages . '/dede-09.png', '', 'alt+59', 'case-03', 'ACTIVE'
    ]
    , [
        '28', 'kun', $urlCurrentImages . '/dede-03.png', '', 'alt+59', 'case-03', 'ACTIVE'
    ]
];
?>
@extends('layouts.translate.app')
@section('scriptsViews')
    <script>
        var $semioticsSymbolicInterpretation =  <?php echo json_encode($semioticsSymbolicInterpretation)?>;
    </script>

    <script src="{{ asset($resourcePathServer.'assets/libs/moment/moment.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/vue-bootstrap/vue-bootstrap.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/uiv/uiv.min.js')}}"></script>

    <script type="text/x-template" id="rucType-template">
        <div>

            <button type="button"
                    :disabled="!validateForm()"
                    class="btn btn-success " v-on:click="_saveModel()">
                <?php echo "{{lblBtnSave}}"?>
            </button>
            <div class="content-form">

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
                                    <label class="form__label "v-html='getLabelForm("name")' ></label>
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
                            <div class="col-md-6" v-if="writingResult.view">
                                <div class="content-writing">
                                    <img class="content-writing__img" v-for="rowImage in writingResult.images" v-bind:src="rowImage.img" alt="">
                                </div>

                            </div>
                        </b-row>

                    </b-container>

                </b-form>

            </div>


        </div>

    </script>
    <script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/kichwa.js') }}" type="text/javascript"></script>
    <script>
        $(function () {

        });

    </script>
@endsection
@section('stylesViews')
    <style>
        .hi {

        }

        .content-writing {
            display: inline-block;
            width: 100%;
        }

        .content-writing.content-writing__img {
            display: inline;
            margin: 0 5px;
        }
    </style>

@endsection
@section('content')
    <div id="app-management">
        <div id="tab-rucType">
            <ruc-type-component
                ref="refRucType"
                :params="configDataRucType"
                v-on:_actions-emit="_updateParentByChildren($event)"

            ></ruc-type-component>
        </div>
    </div>
@endsection
