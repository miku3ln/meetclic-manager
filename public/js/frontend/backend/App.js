var appThis = null;
/*https://codepen.io/laylajune/pen/OXzBWg*/
var utilMenu;

var appInit = new Vue(
    {
        beforeMount: function () {
            utilMenu = new UtilMenu(this);
        },
        mounted: function () {
            this.initCurrentComponent();
            appThis = this;
            this.initMenuCurrent();
            removeClassNotView();
        },
        el: '#app-management',
        created: function () {
            var modelData = Object.keys($modelDataManager).length > 0 ? $modelDataManager : null;
            if (modelData) {
                if (Object.keys(modelData).length > 0) {
                    this.setValuesModel({
                        modelData: modelData
                    });
                }

            }
        },
        data: {
            //MENU

            menuCurrent: [],
            modelCreate: false,
            btnRegisterLabel: 'Registrarse',
            msj: {
                value: "",
                view: false
            },
            model: [],
            initLoadData: false,
            initDataRows: {
                count: 0,
            },
            titleModal: "Creación de Empresa",
            businessCreate: true,
            /*---CONFIG TABS----*/
            /*---   6.1)Config Menu  App Main----*/
            ...$configModulesAllow,
            /*PARAMS SEND COMPONENTS*/
            configDataTemplateSlider: {
                title: "EventsTrailsProject",
                data: [],
                titleEvent: "",
                model_id: null
            },
            configDataActivitiesGamification: {
                title: "Actividades Gamificacion",
                data: [],
                titleEvent: "",
                model_id: null
            },
            configDataRewardsGamification: {
                title: "Rewards Gamificacion",
                data: [],
                titleEvent: "",
                model_id: null
            },
            configDataTemplateAboutUs: {
                title: "TemplateAboutUs",
                data: [],
                titleEvent: "",
                model_id: null
            },
            configDataTemplateServices: {
                title: "TemplateServices",
                data: [],
                titleEvent: "",
                model_id: null
            },
            configDataTemplateNews: {
                title: "TemplateNews",
                data: [],
                titleEvent: "",
                model_id: null
            },
            configDataTemplateContactUs: {
                title: "TemplateContactUs",
                data: [],
                titleEvent: "",
                model_id: null
            },
            configDataTemplateBySource: {
                title: "TemplateBySource",
                data: [],
                titleEvent: "",
                model_id: null
            },
            configDataTemplatePolicies: {
                title: "TemplatePolicies",
                data: [],
                titleEvent: "",
                model_id: null
            },
            configDataTemplatePayments: {
                title: "TemplatePayments",
                data: [],
                titleEvent: "",
                model_id: null
            }
        },
        methods: {
            ...$methodsFormValid,
            initCurrentComponent: function () {

            },
            setValuesModel: function (params) {

                var modelData = params.modelData;
                this.configDataTemplateSlider.model_id = modelData.id;
                this.configDataTemplateAboutUs.model_id = modelData.id;
                this.configDataTemplatePolicies.model_id = modelData.id;
                this.configDataTemplatePayments.model_id = modelData.id;
                this.configDataTemplateServices.model_id = modelData.id;
                this.configDataTemplateContactUs.model_id = modelData.id;
                this.configDataTemplateBySource.model_id = modelData.id;
                this.configDataRewardsGamification.model_id = modelData.id;
                this.configDataActivitiesGamification.model_id = modelData.id;
                this.configDataTemplateNews.model_id = modelData.id;

            },
            managerProcessActive: function (processName) {
                var vm = this;
                if (vm.configModulesAllow.hasOwnProperty(processName)) {
                    vm.configModulesAllow[processName].active = true;
                } else {
                    console.log("no s ha configurado ");
                }
            },
            //menu
            initMenuCurrent: function () {
                var vm = this;
                var menuProcess = $configPartial['menuCurrent']['menu'];
                var processName;
                if ($configPartial['menuCurrent']['configModulesAllow']['allow']) {
                    if (!$configPartial['menuCurrent']['configModulesAllow']['isParent']) {
                        processName = $configPartial['menuCurrent']['configModulesAllow']['config']['keyChildren'];
                        vm.managerProcessActive(processName);
                    } else {
                        processName = $configPartial['menuCurrent']['configModulesAllow']['config']['keyParent'];
                        vm.managerProcessActive(processName);
                    }
                } else {
                    processName = $configPartial['menuCurrent']['managerViewMain']['isParent'] ? $configPartial['menuCurrent']['managerViewMain']['keyChildren'] : $configPartial['menuCurrent']['managerViewMain']['keyParent'];
                    vm.managerProcessActive(processName);
                }

                this.menuCurrent = this.getMenuCurrent(menuProcess);
            },
            resetMenuActives: function () {
                var _this = this;
                $.each(this.menuCurrent, function (key, value) {
                    var isParent = value.isParent;
                    _this.menuCurrent[key]['active'] = false;
                    if (isParent) {
                        $.each(value.parentData, function (keyChildren, valueChildren) {
                            _this.menuCurrent[key]['parentData'][keyChildren]['active'] = false;
                        });
                    }
                });

            },
            _menuItem: function (typeMenu, url) {
                if ($('body').hasClass('m-aside-left--minimize')) {
                    var managerUrl = url;
                    window.location.href = managerUrl;
                }
            },
            _menuCurrent: function (typeManager, menu, indexParent, menuChildren, indexChildren) {
                utilMenu._menuCurrent(typeManager, menu, indexParent, menuChildren, indexChildren);
            },
            getIconClassMenu: function (menu, indexParent, indexChildren) {
                var ovrOptions = new Object();
                ovrOptions[menu.icon] = menu.icon ? true : false;
                var result = menu.icon;
                return result;
            },
            menuInitSaveFirst: function () {
                this.initMenuCurrent();

            },
            getMenuCurrent: function (haystack) {
                return utilMenu.getMenuCurrent(haystack);
            },

            getModel: function () {
                var resultData = null;
                this.modelDataManager = $modelDataManager;
                this.modelCreate = (Object.keys($modelDataManager).length > 0);
                if (this.modelCreate) {
                    var model = $modelDataManager;
                    resultData = model;
                }
                return resultData;
            },

            initManagement: function () {
                var dataMarker = this.getModel();

            },
            initDataManager: function (data) {
                this.titleModal = data.title;
            },


        }
    })
;
appInit.initManagement();


function errors(snap) {
    console.log(snap);
}

function closeModal() {
    appInit.$refs.myModalRef.hide();
}

function removeClassNotView() {
    $(".manager-process.not-view").removeClass('not-view');
}
