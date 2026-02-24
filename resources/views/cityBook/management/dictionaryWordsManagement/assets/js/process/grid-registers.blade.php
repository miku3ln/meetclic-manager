<script>
    var configIcons = null;

    function toReadingNatural(text) {
        if (text == null) return text;
        let s = String(text).trim();
        if (!s) return s;

        // Normaliza ligaduras IPA: t͡ʃ / t͜ʃ / tʃ
        s = s.replace(/t[͜͡]?ʃ/g, "ch");
        s = s.replace(/d[͜͡]?ʒ/g, "zh");
        s = s.replace(/t[͜͡]?s/g, "ts");

        // Consonantes IPA -> lectura
        s = s.replace(/ʃ/g, "sh")
            .replace(/ʒ/g, "zh")
            .replace(/ɲ/g, "ñ")
            .replace(/ʎ/g, "ll")
            .replace(/j/g, "y")
            .replace(/w/g, "w");

        // ŋ contextual:
        // - antes de k/g/q => "ng"
        // - antes de d/t => "n" (para que taŋda => tanda)
        // - caso general => "n"
        s = s.replace(/ŋ(?=[kgq])/g, "ng");
        s = s.replace(/ŋ(?=[dt])/g, "n");
        s = s.replace(/ŋ/g, "n");

        // Vocales raras IPA -> vocal simple
        s = s.replace(/ɐ/g, "a")
            .replace(/ə/g, "a");

        // Quitar diacríticos combinantes y marcas IPA
        s = s.replace(/[\u0300-\u036f]/g, "");
        s = s.replace(/[ˈˌːʰˑʲ]/g, "");
        s = s.replace(/[\[\]]/g, "");
        s = s.replace(/\s+/g, " ").trim();

        return s;
    }

    function getValueConvert(params) {
        const r1 = serviceConverLanguage.generate(params);
        r1.reading_natural = toReadingNatural(r1.ipa_contextual);
        return r1;
    }

    var ICON_CONFIG = {
        "bs5": {
            ICON_BASE: "bi ",
            ICON_AUDIO_PLAY: " bi-volume-up",
            ICON_DROPDOWN_OPEN: "bi-chevron-down",
            ICON_DROPDOWN_CLOSE: "bi-chevron-up",
            ICON_CONTENT_BOOK: "bi-book",
            ICON_INFO: "bi-info-circle",
            ICON_COMMENT: "bi-chat-dots",
            ICON_CHEVRON_UP: "bi-chevron-up",
            ICON_CHEVRON_DOWN: "bi-chevron-down",

        },
        "bs": {
            ICON_BASE: "glyphicon ",
            ICON_AUDIO_PLAY: "  glyphicon-volume-up",
            ICON_DROPDOWN_OPEN: "glyphicon-volume-up",
            ICON_DROPDOWN_CLOSE: "glyphicon-volume-down",
            ICON_CONTENT_BOOK: "glyphicon-book",
            ICON_INFO: "glyphicon-info-sign",
            ICON_COMMENT: "glyphicon-comment",
            ICON_CHEVRON_UP: "glyphicon-chevron-up",
            ICON_CHEVRON_DOWN: "glyphicon-chevron-down",

        }


    };

    function formattersGridDictionary(params) {
        var {$scope, typeBS} = params;

        configIcons = null;
        if (typeBS == "bs5") {
            configIcons = ICON_CONFIG.bs5;
        } else {
            configIcons = ICON_CONFIG.bs;

        }

        return {
            'description': function (column, row) {
                var classStatus = "badge-success";
                if (row.status == "INACTIVE") {
                    classStatus = "badge-warning"
                }
                var photosData = [];
                if (row.photos) {
                    photosData.push("<div class='content-description__photos'>");
                    $.each(row.photos, function (i, v) {
                        var sourceCurrent = $publicAsset + v.source;
                        var photoCurrent = [

                            '<img  class=" content-description__photos--img" src="' + sourceCurrent + '" alt="">'

                        ];
                        photosData.push(photoCurrent.join(""));
                    });

                    photosData.push("</div>");

                }

                var audioData = [];
                var allowPlayMain = false;
                var idPlayMain = false;
                var playStructure = [];
                var allowListen = false;
                console.log("row.audios", row.audios);
                var dataAudio = null;
                if (row.audios) {
                    audioData.push("<div class='content-description__audios'>");
                    var countMain = 0;
                    $.each(row.audios, function (i, v) {
                        if (countMain == 0) {

                            allowPlayMain = true;
                            playStructure = [
                                '  <a  class="btn btn-default btn-sm btn--manager-sound " audio-player="' + v.id + '">',
                                ' <span class="' + configIcons.ICON_BASE + "" + configIcons.ICON_AUDIO_PLAY + '"></span>',
                                'Play ', '</a>'
                            ];
                            allowListen = true;
                            dataAudio = {
                                id: v.id,
                                data: v,

                            };
                        }
                        var sourceCurrent = $publicAsset + v.source;
                        console.log(sourceCurrent)
                        var setCurrent = [

                            '<audio id="audioPlayer' + v.id + '" controls  class="not-view">',
                            '<source src="' + sourceCurrent + '" type="audio/mpeg">',
                            '</audio>',


                        ];
                        audioData.push(setCurrent.join(""));
                        countMain++;
                    });

                    audioData.push("</div>");

                }

                let itemsExamples = [];
                let languageRoot = "";
                let languageTo = "";
                const resultado = $scope.configParams.filters.dataTypeDictionary.find(item => item.id === $scope.configParams.filters.modelFilters.typeDictionary);
                const languages = resultado["text"].split("-");
                languageRoot = languages[0];
                languageTo = languages[1];


                var word = row.value;
                //  var resultData = getValueConvert(word);
                //   console.log("getValueConvert", resultData)
                // var pronunciations = buildPronunciationsFromResult(resultData);
                var pronunciations = row.pronunciations;
                $.each(row.examples, function (i, v) {
                    var value = v.value;
                    var description = v.description;
                    var setValue = [

                        '      <li class="word-card__item ">',
                        '        <strong>' + languageRoot + ':</strong> ' + value + '.<br/>',
                        '        <strong>' + languageTo + ':</strong> ' + description,
                        '      </li>',
                    ];
                    itemsExamples.push(setValue.join(""));
                });
                let exampleData = itemsExamples.length > 0 ? [
                    '  <div class="word-card__section word-card__section--examples">',
                    '    <h3 class="word-card__subtitle"><i class="' + configIcons.ICON_BASE + "" + configIcons.ICON_COMMENT + '"></i> Ejemplos</h3>',
                    '    <ul class="word-card__list">',
                    itemsExamples.join(""),
                    '    </ul>',
                    '  </div>'

                ] : [];

                let itemsPhonetic = [];
                var mainPronunciation = null;
                if (pronunciations && pronunciations.length > 0) {
                    mainPronunciation = pronunciations[0];
                }
                $.each(pronunciations, function (i, v) {
                    var phoneticValue = v.phonetic_value;
                    var notationType = v.notation_type;
                    var clasWord = v.isMain ? "word-card__phonetic--main" : "";
                    if (!v.isMain) {
                        var setValue = [

                            '      <li class="word-card__item not-view word-card-list-li-' + row.id + '"" >',
                            '        <span class="word-card__phonetic ' + clasWord + '">' + phoneticValue + '</span>',
                            '        <span class="word-card__notation">(' + notationType + ')</span>',
                            '      </li>',
                        ];
                        itemsPhonetic.push(setValue.join(""));
                    }

                });
                let itemsGrammaticalClass = [];
                itemsGrammaticalClass.push([
                    '      <li class="word-card__item">' + row.dictionary_grammatical_class_name + '</li>',
                ]);
                var clasWord = mainPronunciation ? (mainPronunciation.isMain ? "word-card__phonetic--main" : "") : "";

                var htmlPlaying = allowListen ? [
                    '    <h3 class="word-card__subtitle"> Pronuciacion',
                    playStructure.join(""),
                    ' </h3>',

                ].join("") : '';
                let phoneticData = itemsPhonetic.length > 0 ? [
                    '  <div class="word-card__section word-card__section--pronunciations">',
                    '    <h4 class="word-card__subtitle">Variantes </h4>',
                    '    <ul class="word-card__list" id="word-card-list-' + row.id + '">',
                    '      <li class="word-card__item word-card__item--main " id="word-card-list-li-' + row.id + '">',
                    '        <span class="word-card__phonetic ' + clasWord + '">' + mainPronunciation.phonetic_value + '</span>',
                    '        <span class="word-card__notation">(' + mainPronunciation.notation_type + ')</span>',
                    '<i class="' + configIcons.ICON_BASE + "" + configIcons.ICON_CHEVRON_DOWN + '  word-card__expand-ico"></i>',
                    '      </li>',
                    itemsPhonetic.join(""),
                    '    </ul>',
                    '  </div>'

                ] : [];


                let grammaticalData = itemsGrammaticalClass.length > 0 ? [
                    '  <div class="word-card__section word-card__section--grammar">',
                    '    <h3 class="word-card__subtitle"><i class="' + configIcons.ICON_BASE + "" + configIcons.ICON_CONTENT_BOOK + '"></i>Clases Gramaticales</h3>',
                    '    <ul class="word-card__list">',
                    itemsGrammaticalClass.join(""),
                    '    </ul>',
                    '  </div>'

                ] : [];

                var result = [
                    '<div class="word-card">',
                    ' <div class="content-manager-buttons-grid ready">',
                    '    <div class="inline-data">',
                    '       <a id="a-menu-' + row.id + '" data-toggle="tooltip" data-placement="top" data-original-title="Editar" class="btn--xs content-manager-buttons-grid__a edit-data" ><i class="fa fa-pencil"></i>',
                    '      </a>',
                    '  </div>',

                    '  <div class="word-card__header">',
                    '    <h2 class="word-card__base">' + row.value + '</h2>',
                    '    <span class="word-card__translation">' + row.translation_value + '</span>',
                    '  </div>',
                    htmlPlaying,
                    phoneticData.join(""),
                    grammaticalData.join(""),
                    exampleData.join(""),
                    '  <div class="word-card__section word-card__section--detail">',
                    '    <h3 class="word-card__subtitle"><i class="' + configIcons.ICON_BASE + "" + configIcons.ICON_INFO + '"></i>Detalles Adicionales</h3>',
                    '    <p class="word-card__text">',
                    row.description, " <br>" + row.usage_context,
                    '    </p>',
                    '  </div>',
                    audioData.join(""),
                    '</div>'
                ];


                return result.join("");
            }
        };
    }
</script>
<script id="grid-registers-script">


    function buildDocumentsRequireTable(rows) {
        if (!Array.isArray(rows) || rows.length === 0) {
            return '<p class="text-muted">Sin registros</p>';
        }

        var tbody = rows.map(r => `
<span class="badge badge--size-large badge--bee-points">(${r.code})${r.name}</span>`).join('');

        return `${tbody}
  `;
    }

    Vue.component('grid-registers-component', {
        components: {},
        template: '#grid-registers-template',
        directives: {
            'init-grid-filters': {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    paramsInput.initMethod({
                        objSelector: el
                    });


                },
            },
        },
        props: {
            params: {
                type: Object,
            }
        },
        created: function () {
            var vmCurrent = this;
            this.configParams = this.params;
            this.$root.$on("grid-registers", function (emitValue) {
                console.log("grid-registers", emitValue)
                vmCurrent._managerTypes(emitValue);
            });
            this.sendDataParent({action: 'created', child: this.nameComponent});


        },
        beforeMount: function () {
            this.configParams = this.params;
            console.log("beforeMount", this.configParams)
            this.sendDataParent({action: 'beforeMount', child: this.nameComponent});

        },
        mounted: function () {
            componentThisEventsTrailsProject = this;
            this.initCurrentComponent();

            this.sendDataParent({action: 'mounted', child: this.nameComponent});
        },
        computed: {},

        data: function () {

            var dataManager = {

                business_id: null,
                /*  ----MANAGER ENTITY---*/
                configModelEntity: {
                    "buttonsManagements": [


                        {
                            "title": "Editar Embarcacion",
                            "data-placement": "top",
                            "i-class": "fa fa-pencil",
                            "managerType": "managementUpdateVessel",
                            "isUrl": false,

                        },
                        {
                            "title": "Agregar Responsables",
                            "data-placement": "top",
                            "i-class": "fa fa-anchor",
                            "managerType": "maritimeVesselResponsibles",
                            "isUrl": false,

                        },
                    ]
                },
                managerMenuConfig: {
                    view: false,
                    menuCurrent: [],
                    rowId: null
                },
                configParams: {},
                labelsConfig: {buttons: {'create': 'Crear', 'update': 'Actualizar'}},
                processName: "Registro Acción.",
//Grid config
                gridConfig: {
                    selectorCurrent: "#grid-registers-grid",
                    url: $("#action-management-admin").val()
                },
                submitStatus: "no",
                showManager: false,
                managerType: null,
                search: {
                    needle: ''
                },
                loadPage: false,
                configModalManagementFormEvent: {
                    viewAllow: false
                }, configModalManagementFormEventDetails: {
                    viewAllow: false
                },
                configMaritimeVesselResponsibles: {
                    viewAllow: false
                },
                managerCurrentBusiness: null,
                nameComponent: 'grid-registers',

            };


            return dataManager;
        },
        methods: {
            ...$methodsFormValid,
            initCurrentComponent: function () {

                this.initGridManager(this);
            },

//EVENTS OF CHILDREN
            _managerTypes: function (emitValues) {
                if (emitValues.type == "rebootGrid") {
                    $(this.gridConfig.selectorCurrent).bootgrid("reload");

                }
                if (emitValues.type == "resetComponent") {
                    this.configModalManagementFormEvent.viewAllow = false;
                    this.configModalManagementFormEventDetails.viewAllow = false;


                }
            },
            /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
            makeToast: makeToast,
//MANAGER PROCESS
            /*---------GRID--------*/
            _destroyTooltip: _destroyTooltip,
            _resetManagerGrid: _resetManagerGrid,
            _managerMenuGrid: _managerMenuGrid,
            getMenuConfig: function (params) {
                var result = [];
                $.each(this.configModelEntity["buttonsManagements"], function (key, value) {
                    var setPush = {
                        title: value["title"],
                        isUrl: value["isUrl"],
                        url: value["url"],
                        "data-placement": value["data-placement"],
                        icon: value["i-class"],
                        data: value, rowId: params.rowId,
                        managerType: value["managerType"],
                        params: params
                    }
                    result.push(setPush);
                });
                return result;
            },
            _gridManager: _gridManager,
            _managerRowGrid: function (params) {
                var $scope = this;
                var rowCurrent = params.row;

                if (params.managerType == "managementUpdate") {
                    this.configModalManagementFormEvent.data = rowCurrent;
                    this.configModalManagementFormEvent.viewAllow = true;
                    this.sendDataParent({
                        action: 'managementUpdate',
                        child: this.nameComponent,
                        data: rowCurrent
                    });

                }

            },
            initGridManager: function (vmCurrent) {
                console.log(vmCurrent.configParams)
                var gridName = this.gridConfig.selectorCurrent;
                var urlCurrent = this.gridConfig.url;
                var business_id = -1;
                var paramsFilters = {};
                var $scope = this;
                var overWritePost = function (request) {
                    var paramsFilters = $scope.getTypeDictionary();
                    var result = {filters: paramsFilters};
                    return result;
                };
                var formattersCurrent = formattersGridDictionary({$scope: $scope, typeBS: "bs"});

                let gridInit = $(gridName);
                gridInit.bootgrid({
                    ajaxSettings: {
                        method: "POST"
                    },
                    ajax: true,
                    post: overWritePost,
                    url: urlCurrent,
                    labels: $labelsGridConfigDefault,
                    css: getCSSCurrentBootGrid(),
                    formatters: formattersCurrent
                }).on("loaded.rs.jquery.bootgrid", function () {
                    vmCurrent._resetManagerGrid();
                    $(".edit-data").on("click", function () {
                        var dataRowId = $(this).attr("id").split("-")[2];
                        var instance_data_rows = $(gridName).bootgrid("getCurrentRows");
                        var rowData = searchElementJson(instance_data_rows, 'id', dataRowId);
                        vmCurrent._managerRowGrid({
                            row: rowData[0],
                            id: dataRowId,
                            managerType: "managementUpdate"
                        });


                    });
                    $('.btn--manager-sound').off('click');

                    $('.btn--manager-sound').on('click', function () {
                        console.log('--------------------------------------');
                        var audioPlayerId = $(this).attr('audio-player');
                        var selectorCurrent = 'audioPlayer' + audioPlayerId;
                        var audio = document.getElementById(selectorCurrent);
                        managerAudio({audio: audio});
                    });
                    $(".word-card__item--main").on("click", function () {
                        var id = $(this).attr("id");
                        console.log(this, id);
                        var setIcon = configIcons.ICON_CHEVRON_DOWN;
                        var selectorItemsSetClass = "not-view";
                        var selectorItems = "." + id;
                        if ($(this).find("i").hasClass(configIcons.ICON_CHEVRON_DOWN)) {
                            setIcon = configIcons.ICON_CHEVRON_UP;
                            $(selectorItems).removeClass("not-view");
                            $(this).find("i").removeClass(configIcons.ICON_CHEVRON_DOWN);
                            selectorItemsSetClass = "";
                        } else {
                            $(this).find("i").removeClass(configIcons.ICON_CHEVRON_UP);

                        }
                        console.log("aadad");
                        $(this).find("i").addClass(setIcon);
                        $(selectorItems).addClass(selectorItemsSetClass);

                    });

                });
            },
            /*Manager FORMS-AND VIEWS*/
            _viewManager: _viewManager,
//FORM CONFIG
            getViewErrorForm: getViewErrorForm,
            _submitForm: function (e) {
                console.log(e);
            },

            sendDataParent: function (params) {
                this.$emit('_actions-emit', params);
            },
            getTypeDictionary: function () {
                var entity_manager_id = this.configParams.filters.modelFilters.typeDictionary;
                return {
                    entity_manager_id: entity_manager_id
                };
            },
        }
    })
</script>
