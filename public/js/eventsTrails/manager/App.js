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
            var modelData = Object.keys($modelDataManager["model"]).length > 0 ? $modelDataManager["model"] : null;
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
            /*---CONFIG TABS----*/
            /*---   6.1)Config Menu  App Main----*/
            configModulesAllow: {
                eventsTrailsProject:
                    {
                        title: "Información",
                        allow: true,
                        active: false,
                    },
                eventsTrailsTypeOfCategories:
                    {
                        title: "Información",
                        allow:
                            true, active:
                            false,
                    },


                eventsTrailsDistances:
                    {
                        title: "Información",
                        allow:
                            true, active:
                            false,
                    },
                eventsTrailsTypeTeams:
                    {
                        title: "Información",
                        allow:
                            true, active:
                            false,
                    },
                eventsTrailsByKit:
                    {
                        title: "Información",
                        allow:
                            true, active:
                            false,
                    },
                dashboard:
                    {
                        title: "Información",
                        allow:
                            true, active:
                            false,
                    },
                eventsTrailsRegistrationPoints:
                    {
                        title: "Información",
                        allow: true,
                        active: false,
                    }
            },
            businessCreate: true,
            /*PARAMS SEND COMPONENTS*/
            configDataEventsTrailsProject: {
                title: "EventsTrailsProject",
                data: [],
                titleEvent: "",
                model_id: null
            },
            configDataEventsTrailsTypeOfCategories: {
                title: "Categorias",
                data: [],
                titleEvent: "",
                events_trails_project_id: null
            },
            configDataEventsTrailsDistances: {
                title: "EventsTrailsDistances",
                data: [],
                titleEvent: "",
                events_trails_project_id: null
            },
            configDataEventsTrailsTypeTeams: {
                title: "EventsTrailsTypeTeams",
                data: [],
                titleEvent: "",
                events_trails_project_id: null
            },

            configDataEventsTrailsByKit: {
                title: "EventsTrailsByKit",
                data: [],
                titleEvent: "",
                events_trails_project_id: null
            },
            configDataDashboard: {
                title: "Dashboard",
                data: [],
                titleEvent: "",
                events_trails_project_id: null
            },
            configDataEventsTrailsRegistrationPoints: {
                title: "EventsTrailsRegistrationPoints",
                data: [],
                titleEvent: "",
                events_trails_project_id: null
            }

        },
        methods: {
            ...$methodsFormValid,
            initCurrentComponent: function () {

            },
            setValuesModel: function (params) {

                var modelData = params.modelData;
                this.configDataEventsTrailsProject.events_trails_project_id = modelData.id;
                this.configDataEventsTrailsTypeOfCategories.events_trails_project_id = modelData.id;

                this.configDataEventsTrailsDistances.events_trails_project_id = modelData.id;
                this.configDataEventsTrailsTypeTeams.events_trails_project_id = modelData.id;

                this.configDataEventsTrailsByKit.events_trails_project_id = modelData.id;
                this.configDataDashboard.events_trails_project_id = modelData.id;
                this.configDataEventsTrailsRegistrationPoints.events_trails_project_id = modelData.id;


            },
            //menu
            initMenuCurrent: function () {
                var vm = this;
                var menuProcess = $configPartial['menuCurrent']['menu'];
                var processName;
                if ($configPartial['menuCurrent']['configModulesAllow']['allow']) {
                    if ($configPartial['menuCurrent']['configModulesAllow']['isParent']) {
                        processName = $configPartial['menuCurrent']['configModulesAllow']['config']['keyParent'];
                        vm.configModulesAllow[processName].active = true;
                    } else {
                        processName = $configPartial['menuCurrent']['configModulesAllow']['config']['keyChildren'];
                        vm.configModulesAllow[processName].active = true;
                    }
                } else {
                    processName = $configPartial['menuCurrent']['managerViewMain']['isParent'] ? $configPartial['menuCurrent']['managerViewMain']['keyChildren'] : $configPartial['menuCurrent']['managerViewMain']['keyParent'];
                    vm.configModulesAllow[processName].active = true;
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
                this.modelCreate = (Object.keys($modelDataManager["model"]).length > 0);
                if (this.modelCreate) {
                    var model = $modelDataManager["model"];
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

function UtilMenu(componentCurrent) {
    this.componentCurrent = componentCurrent;
    this._menuCurrent = function (typeManager, menu, indexParent, menuChildren, indexChildren) {
        var vm = this.componentCurrent;
        var processNameIndex;
        this.resetMenuActives();
        if (typeManager) {//only menu
            processNameIndex = menu.type;
            $.each(this.componentCurrent.configModulesAllow, function (key, value) {
                if (key == processNameIndex) {
                    vm.configModulesAllow[key].active = true;
                } else {
                    vm.configModulesAllow[key].active = false;

                }
            });
            $.each(this.componentCurrent.menuCurrent, function (key, value) {
                if (key == indexParent) {
                    vm.menuCurrent[key].active = true;

                }
            });
        } else if (typeManager == false) {//childrens
            processNameIndex = menuChildren.type;
            $.each(this.componentCurrent.configModulesAllow, function (key, value) {
                if (key == processNameIndex) {
                    vm.configModulesAllow[key].active = true;
                } else {
                    vm.configModulesAllow[key].active = false;

                }
            });
            $.each(this.componentCurrent.menuCurrent, function (key, value) {
                if (key == indexParent) {
                    vm.menuCurrent[key].active = true;
                    if (value.isParent) {
                        $.each(value.parentData, function (keyChildren, valueChildren) {
                            if (keyChildren == indexChildren) {
                                vm.menuCurrent[key]["parentData"][keyChildren].active = true;
                            }
                        });
                    }
                }


            });
        }
    };
    this.getMenuCurrent = function (haystack) {
        var result = [];
        $.each(haystack, function (key, value) {
            var setPush;
            if (value.isParent) {

                var parentDataAux = value.parentData;
                var setPushDataParent = [];
                $.each(parentDataAux, function (keyChildren, valueChildren) {
                    if (value.allow) {
                        setPush = {
                            title: valueChildren.title,
                            allow: valueChildren.allow,
                            type: keyChildren,
                            active: valueChildren.active,
                            isParent: false,
                            urlCurrent: valueChildren.urlCurrent,
                        };

                        setPushDataParent.push(setPush);
                    }

                });

                setPush = {
                    title: value.title,
                    allow: value.allow,
                    type: key,
                    active: value.active,
                    isParent: value.isParent,
                    icon: value.icon,
                    parentData: setPushDataParent
                };
                result.push(setPush);
            } else {
                if (value.allow) {
                    setPush = {
                        title: value.title,
                        allow: value.allow,
                        type: key,
                        active: value.active,
                        isParent: value.isParent,
                        icon: value.icon,
                        urlCurrent: value.urlCurrent,

                    };

                    result.push(setPush);
                }
            }
        });
        return result;
    };

}
