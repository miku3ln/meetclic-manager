var panoramaComponent = null;
var structurePanorama;
Vue.component('panorama-component', {
    directives: {
        routesPointsS2: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.routesPointsS2({
                    objSelector: el, model: paramsInput.model

                });


            }
        },
        initEventUploadSource: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                var paramsInit = paramsInput['paramsInit'];
                var initMethod = paramsInput['initMethod'];
                initMethod(paramsInit);
            }
        }
    },
    template: '#panorama-template',
    props: {
        parentData: {
            type: String,
        },
        title: {
            type: String
        },
        messageParent: {
            type: String
        },
        configparams: {
            type: Object,
        }

    },
    beforeMount: function () {
        this.configparams = this.configparams;
        // this.businessId = this.configParams.business_id;
        this.businessId = $businessManager.id;

    },
    mounted: function () {
        this.initCurrentComponent();
        removeClassNotView();
    },
    validations: {
        modelPanorama: {
            attributes: {
                routes_map_by_routes_drawing_id_data: {required},
                title: {required},
                subtitle: {},
                description: {},
                type_panorama: {},
                points_allow: {},
                src: {required},
                type_breakdown: {},
                change: {},
                panoramaPoints: {required},
                status: {},

            }
        },

    },
    data: function () {
        var dataManager = {
            message: 'hello!',
            formAllow: false,
            paramsGrid: {},
            gridProductsObj: null,
            business_id: null,
            showManager: false,
            managerOptions: {
                grid: {
                    selector: "#panorama-grid",
                    action: $("#action_panorama_admin").val()
                }
            },
            modelPanorama: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            processName: "Panorama",
            formConfig: {
                nameSelector: "#business-by-panorama-form",
                url: $('#action_panorama_save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ' + this.processName,
                successMessage: 'La ruta  se guardo correctamente.',
                tabCurrentSelector: "#" + "tab-panorama"
            },
            lblBtnSave: "Guardar",
            lblBtnClose: "Cerrar",
            //uploads
            uploadConfig: {
                uploadElementsSelectors: {
                    panorama: "#file_upload_panorama"
                },
                labelsButtons: {
                    panorama: "Subir Imagen.",
                },
                viewUpload: {
                    panorama: "#preview-panorama-src"
                }
            },

            select2Options: {
                routes_map_by_routes_drawing_id_data: {
                    url: $('#actionListMarker').val(),
                    options: [],
                    placeholder: {id: null, text: "Seleccione Punto."},
                    msj: {
                        empty: "No existe resultados."
                    }
                }
            },
            /*    ----GRID ----*/
            gridSelectorCurrent: "#panorama-grid",
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null,
                rowData: []
            },
            managerType: null,
            businessId:$businessManager.id
        };

        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        onListenElementsForm:onListenElementsForm,

        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        initCurrentComponent: function () {

            this.initGridManager(this);
            this._initEventsUpload();
        },
        _valuesForm: function (event) {
            this.modelPanorama.init = false;
            this.validateForm();
        },
        validateForm: function () {
            var currentAllow = this.getValidateForm({model:this.$v.modelPanorama});
            return currentAllow.success;

        },
        _managerEventsUpload: function (params) {
            var selectorUpload = params['selectorUpload'];
            var selectorPreview = params['selectorPreview'];
            var modelCurrent = params['modelCurrent'];
            $.UploadUtil.managerUploadModel(params);
        },
        getAttributesManagerUpload: function (params) {
            var nameField = params['nameField'];
            var modelCurrent = params['modelCurrent'];
            var result = {};
            if (nameField == 'src') {
                result = {
                    'selectorUpload': '#file-' + nameField,
                    'selectorPreview': '#preview-' + nameField,
                    'modelCurrent': modelCurrent,
                    'modelAttributeName': nameField,
                };
            }
            return result;
        },
        getValidateForm:getValidateForm,
        getDataForm: function () {
            var result = {
                id: this.modelPanorama.attributes.id ? this.modelPanorama.attributes.id : null,
                business_id: this.business_id,
                change: this.modelPanorama.attributes.change,
                title: this.modelPanorama.attributes.title,
                subtitle: this.modelPanorama.attributes.subtitle,
                description: this.modelPanorama.attributes.description,
                type_panorama: this.modelPanorama.attributes.type_panorama,
                points_allow: this.modelPanorama.attributes.points_allow,
                src: this.modelPanorama.attributes.src,
                type_breakdown: this.modelPanorama.attributes.type_breakdown,
                routes_map_by_routes_drawing_id: this.modelPanorama.attributes.routes_map_by_routes_drawing_id_data["id"],
                panoramaPoints: this.modelPanorama.attributes.panoramaPoints,
                status: this.modelPanorama.attributes.status ? "ACTIVE" : "INACTIVE",
            };
            return result;
        },
        _savePanorama: function () {
            var dataSend = this.getDataForm();
            var _this = this;
            _this.$v.$touch();
            if (this.$v.$invalid) {
                _this.submitStatus = 'error';

            } else {

                ajaxRequest(this.formConfig.url, {
                    type: 'POST',
                    data: dataSend,
                    blockElement: _this.formConfig.tabCurrentSelector,//opcional: es para bloquear el elemento
                    loading_message: _this.formConfig.loadingMessage,
                    error_message: _this.formConfig.errorMessage,
                    success_message: _this.formConfig.successMessage,
                    success_callback: function (response) {

                        if (response.success) {
                            _this.resetForm(true);
                            $(_this.managerOptions.grid.selector).bootgrid("reload");
                            _this._viewManager(2);
                        }
                    }
                }, true);
            }
        },
        /*FORM*/
        /* validations*/
        getLabelForm: function (nameId) {

            return viewGetLabelForm(nameId,this.modelPanorama);

        },

        _setValueFormS2: function (value) {

            this._setValueForm("routes_map_by_routes_drawing_id_data", value);
        },
        _setValueForm: function (name, value) {
            this.modelPanorama.attributes[name] = value;
            this.modelPanorama.attributes["panoramaPoints"] = "not-points";
            this.$v["modelPanorama"]["attributes"]["panoramaPoints"] = "not-points";
            this.$v["modelPanorama"]["attributes"][name].$touch();
            this._valuesForm();
        },
        getClassErrorForm: function (nameElement, objValidate) {
            var result = {};
            if (objValidate) {
                result = {
                    "form-group--error": objValidate.$error,
                    'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
                };
            }

            return result;
        },
        _submitForm: function (e) {
            console.log(e);
        },
        getAttributesForm: function () {
            var result = {
                status: true,
                routes_map_by_routes_drawing_id_data: null,
                title: null,//*
                subtitle: null,
                description: null,
                type_panorama: 0,//0=NORMAL,1=IMAGE RESUMEN MAP
                points_allow: 0,//0=not breakdown,1= breakdown
                src: null,
                type_breakdown: 0,//0=PARENT,1=CHILDREN
                change: false,
                panoramaPoints: 'not-points',

            };

            return result;
        },
        getStructureForm: function () {
            var result = {
                routes_map_by_routes_drawing_id_data:
                    {
                        id: "routes_map_by_routes_drawing_id_data",
                        name: "routes_map_by_routes_drawing_id_data",
                        label: "Marker",
                        required:
                            {
                                allow: true,
                                msj: "Campo requerido.",
                                error: false
                            }
                    },
                status: {
                    name: "status",
                    label: "Estado",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                title: {
                    name: "title",
                    label: "Titulo",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                subtitle: {
                    name: "subtitle",
                    label: "Subtitulo",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                description: {
                    name: "description",
                    label: "Descripción",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                type_panorama: {
                    name: "type_panorama",
                    label: "Tipo Panorama",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                points_allow: {
                    name: "points_allow",
                    label: "Puntos",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                src: {
                    name: "src",
                    label: "Imagen",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                type_breakdown: {
                    name: "type_breakdown",
                    label: "Parent/Children",
                    required:
                        {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                panoramaPoints: {
                    name: "panoramaPoints",
                    label: "Puntos",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
            };

            return result;
        }, _viewManager: function (typeView) {
            var selectorGrid = this.managerOptions.grid.selector;
            this.resetForm();
            if (typeView == 1) {//create-update
                this.showManager = true;
                $(selectorGrid + "-header").hide();
                $(selectorGrid + "-footer").hide();
                this.managerType = 1;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            } else if (typeView == 2) {//admin
                this.showManager = false;
                $(selectorGrid + "-footer").show();
                $(selectorGrid + "-header").show();

                if (this.managerType == 1) {
                    this.managerMenuConfig.view = false;
                    this.managerType = null;

                } else {
                    this.managerMenuConfig.view = true;
                }

            } else if (typeView == 3) {//update
                this.showManager = true;
                $(selectorGrid + "-footer").hide();
                $(selectorGrid + "-header").hide();
                this.managerMenuConfig.view = false;
                this.managerType = 3;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            }
        }, resetForm: function (save) {
            this.modelPanorama = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm()
            };
            $(this.uploadConfig.uploadElementsSelectors.panorama).val("");
            var srcImage = $notImageUrl;
            $(this.uploadConfig.viewUpload.panorama).attr("src", srcImage);
            this.select2Options.routes_map_by_routes_drawing_id_data.model = null;
            $("#container-data canvas").remove();
            this.$v.$reset();
            if (save) {
                this._resetManagerGrid();
            }
        },
        /*---------GRID--------*/
        //MANAGER PROCESS
        _managerRowGrid: function (params) {
            this._viewManager(3);
            var rowCurrent = params.row;
            var rowId = params.id;
            this.modelPanorama.attributes.id = rowId;
            this.modelPanorama.attributes["change"] = false;
            this.modelPanorama.attributes["title"] = rowCurrent["p_title"];
            this.modelPanorama.attributes["subtitle"] = rowCurrent["p_subtitle"];
            this.modelPanorama.attributes["description"] = rowCurrent["p_description"];
            this.modelPanorama.attributes["type_panorama"] = rowCurrent["p_type_panorama"];
            this.modelPanorama.attributes["points_allow"] = rowCurrent["p_points_allow"];
            this.modelPanorama.attributes["src"] = rowCurrent["p_src"];
            this.modelPanorama.attributes["type_breakdown"] = rowCurrent["p_type_breakdown"];
            this.modelPanorama.attributes.status = rowCurrent.status == "ACTIVE" ? true : false;

            this.$v.modelPanorama.attributes.id = rowId;
            this.$v.modelPanorama.attributes["title"] = rowCurrent["p_title"];
            this.$v.modelPanorama.attributes["subtitle"] = rowCurrent["p_subtitle"];
            this.$v.modelPanorama.attributes["description"] = rowCurrent["p_description"];
            this.$v.modelPanorama.attributes["type_panorama"] = rowCurrent["p_type_panorama"];
            this.$v.modelPanorama.attributes["points_allow"] = rowCurrent["p_points_allow"];
            this.$v.modelPanorama.attributes["src"] = rowCurrent["p_src"];
            this.$v.modelPanorama.attributes["type_breakdown"] = rowCurrent["p_type_breakdown"];
            this.$v.modelPanorama.attributes.status = rowCurrent.status == "ACTIVE" ? true : false;

            this.$v.modelPanorama.attributes.routes_map_by_routes_drawing_id_data = drawing;
var drawing={
    id: rowCurrent["routes_map_by_routes_drawing_id"],
    text: rowCurrent["rd_name"] + " " + rowCurrent["rd_description"],
    name: rowCurrent["rd_name"] + " " + rowCurrent["rd_description"],
};

            this.select2Options.routes_map_by_routes_drawing_id_data.model = drawing;

            var srcSource = $resourceRoot + rowCurrent["p_src"];
            if (this.modelPanorama.attributes["type_panorama"]==1) {
                this.initPanorama(srcSource);
            }

            $(this.uploadConfig.viewUpload.panorama).attr("src", srcSource);



        }, initGridManager: function (vmCurrent) {

            var gridName = this.managerOptions.grid.selector;
            var urlCurrent = this.managerOptions.grid.action;
            var business_id = this.business_id;
            var paramsFilters = {
                business_id: business_id
            };
            let gridId = $(gridName);
            gridId.bootgrid({
                ajaxSettings: {
                    method: "POST"
                },
                ajax: true,
                post: function () {
                    return {
                        grid_id: gridName,
                        filters: paramsFilters
                    };
                },
                url: urlCurrent,
                labels: {
                    loading: "Cargando...",
                    noResults: "Sin Resultados!",
                    infos: "Mostrando {{ctx.start}} - {{ctx.end}} de {{ctx.total}} resultados"
                },
                css: getCSSCurrentBootGrid(),
                formatters: {
                    'commands': function (column, row) {
                        return ' <a  class="btn btn--manager btn-xs manager-process" type-manager="update" data-toggle="tooltip" data-placement="top" title="Actualizar" data-row-id="' + row.id + '"><i class=" fas fa-pencil-alt"></i></a>';
                    },
                    'description': function (column, row) {

                        var result = [
                            "<div    class='content-description'>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Estado:</span><span class='content-description__value'>" + (row.status == "ACTIVE" ? "ACTIVO" : "INACTIVO") + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Nombre Chakiñan && Atractivo Turisitico :</span><span class='content-description__value'>" + (row.rm_name) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Marker(Punto):</span><span class='content-description__value'>" + (row.rd_name + " - " + row.rd_description) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Titulo:</span><span class='content-description__value'>" + (row.p_title) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Subtitulo:</span><span class='content-description__value'>" + (row.p_subtitle) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Descripción:</span><span class='content-description__value'>" + (row.p_description) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <img class='content-description__image' src='" + $resourceRoot + row.p_src + "'>",
                            "</div>",
                            "</div>"
                        ];
                        return result.join("");
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function () {
                vmCurrent._resetManagerGrid();

                vmCurrent._gridManager(gridId, vmCurrent);

            });
        },
        getMenuConfigGridRow: function (params) {
            $configModelEntityPanorama = {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        "manager-type": "update"
                    }
                ]
            };
            var buttonsManagements = $configModelEntityPanorama["buttonsManagements"];
            var result = [];
            $.each(buttonsManagements, function (key, value) {
                var setPush = {
                    title: value["title"],
                    "data-placement": value["data-placement"],
                    icon: value["i-class"],
                    data: value,
                    rowId: params.rowId,
                    managerType: value["manager-type"],
                    params: params
                };
                result.push(setPush);
            });
            return result;
        },
        /*---------GRID--------*/
        _managerMenuGrid: function (key, menu) {
            if (menu.managerType == "update") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);

                this._managerRowGrid({
                    row: menu.params["rowData"],
                    id: menu.rowId
                });


            }

        },
        _resetManagerGrid: function () {
            this.managerMenuConfig = {
                view: false,
                menuCurrent: [],
                rowId: null,
                rowData: []
            };
        },
        _destroyTooltip: function (selector) {
            $(selector).tooltip('hide');
        },
        _gridManager: function (elementSelect, vmCurrent) {
            var paramsGrid = {
                gridCurrentSelector: vmCurrent.gridSelectorCurrent
            };

            var selectorIdGrid = $(elementSelect).attr("id");
            var selectorCurrentTrManager = "#" + selectorIdGrid + " tbody tr";
            elementSelect.find("tbody tr").on("click", function (e) {
                var self = $(this);
                var dataRowId = $(self[0]).attr("data-row-id");
                var rowId = dataRowId;
                var currentRowSelector;
                if (dataRowId) {
                    var instance_data_rows = $(paramsGrid.gridCurrentSelector).bootgrid("getCurrentRows");
                    var rowData = searchElementJson(instance_data_rows, 'id', dataRowId);//asi s obtiene los valores del registro en funcion d su id
                    currentRowSelector = selectorCurrentTrManager + "[data-row-id='" + rowId + "']";
                    $(currentRowSelector).removeClass("selected");
                    var newEventRow = false;
                    rowData = rowData[0];
                    if (vmCurrent.managerMenuConfig.rowId) {//ready selected
                        var removeRowId = vmCurrent.managerMenuConfig.rowId;
                        if (dataRowId == removeRowId) {
                            currentRowSelector = selectorCurrentTrManager + "[data-row-id='" + removeRowId + "']";
                            $(currentRowSelector).removeClass("selected");
                            vmCurrent._resetManagerGrid();
                        } else {
                            currentRowSelector = selectorCurrentTrManager + "[data-row-id='" + removeRowId + "']";
                            $(currentRowSelector).removeClass("selected");
                            newEventRow = true;
                        }
                    } else {
                        newEventRow = true;
                    }
                    if (newEventRow) {

                        currentRowSelector = selectorCurrentTrManager + "[data-row-id='" + rowId + "']";
                        $(currentRowSelector).addClass("selected");
                        vmCurrent.managerMenuConfig = {
                            view: true,
                            menuCurrent: vmCurrent.getMenuConfigGridRow({rowData: rowData, rowId: dataRowId}),
                            rowId: dataRowId
                        };


                    }

                }

            });
        },
        _closeModal: function () {
            closeModal();
        },
        getSelectorManager: function () {

            return 'container-data';
        },
        getSelectElement: function () {
            var elementSelector = this.getSelectorManager();
            return document.getElementById(elementSelector);
        },
        getPanoramic: function () {
            var result = $dataPanorama[0].src;
            return result;
        },
        initPanorama: function (urlManager) {
            var _this = this;
            var elementConfig = $("#container-data");
            $("#container-data canvas").remove();
            initPanoramic(urlManager);

            function initPanoramic(urlManager) {
                var container = _this.getSelectElement();
                var manualControl = false;
                var longitude = 0;
                var latitude = 0;
                var savedX;
                var savedY;
                var savedLongitude;
                var savedLatitude;

                // setting up the renderer
                renderer = new THREE.WebGLRenderer();
                renderer.setSize(window.innerWidth, window.innerHeight);
                container.appendChild(renderer.domElement);

                // creating a new scenegetSelectElement
                var scene = new THREE.Scene();

                // adding a camera
                var camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 1, 1000);
                camera.target = new THREE.Vector3(0, 0, 0);

                // creation of a big sphere geometry
                var sphere = new THREE.SphereGeometry(100, 100, 40);
                sphere.applyMatrix(new THREE.Matrix4().makeScale(-1, 1, 1));

                // creation of the sphere material
                var sphereMaterial = new THREE.MeshBasicMaterial();
                sphereMaterial.map = THREE.ImageUtils.loadTexture(urlManager)
                sphereMaterial.side = THREE.DoubleSide;
                sphereMaterial.transparent = true;

                // geometry + material = mesh (actual object)
                var sphereMesh = new THREE.Mesh(sphere, sphereMaterial);
                scene.add(sphereMesh);
                var rayCaster = new THREE.Raycaster();
                // listeners
                container.addEventListener("mousedown", onDocumentMouseDown, false);
                container.addEventListener("mousemove", onDocumentMouseMove, false);
                container.addEventListener("mouseup", onDocumentMouseUp, false);
                container.addEventListener("click", _panorama, false);

                render();

                // listeners functions
                function _panorama(event) {
                    event.preventDefault();
                    eventType(event, "clickPanorama");

                }

                function getMeasurementDivContent() {

                    var height = $("#" + _this.getSelectorManager()).height();
                    var width = $("#" + _this.getSelectorManager()).width();
                    return {
                        height: height,
                        width: width
                    };
                }

                function getValuesPosition(event) {


                    var windowMeasure = getMeasurementDivContent();
                    if (event == "clickPanorama") {
                    }
                    let x = (event.clientX / windowMeasure.width) * 2 - 1;

                    let y = -(event.clientY / windowMeasure.height) * 2 + 1;

                    return {
                        x: x, y: y
                    };
                }

                function eventType(event, type) {//other
                    var position = getValuesPosition(event);
                    let mouse = new THREE.Vector2(position.x, position.y);
                    rayCaster.setFromCamera(mouse, camera);
                    let intersects = getListChildrenScene();
                    intersects.forEach(function (intersect) {
                        if (intersect.object.type == "Sprite") {

                            if (type == "mouseMove") {

                            } else {
                                console.log("-click---", intersect.point);
                            }
                        } else {
                            if (type == "clickPanorama") {
                                console.log("no esta en l tag", intersect.point);
                            }
                        }
                    });
                }

                function getListChildrenScene() {

                    let nodesChildren = scene.children;
                    let intersects = rayCaster.intersectObjects(nodesChildren);
                    return intersects;
                }

                function render() {

                    requestAnimationFrame(render);

                    if (!manualControl) {
                        longitude += 0.1;
                    }


                    // limiting latitude from -85 to 85 (cannot point to the sky or under your feet)
                    latitude = Math.max(-85, Math.min(85, latitude));

                    // moving the camera according to current latitude (vertical movement) and longitude (horizontal movement)
                    camera.target.x = 500 * Math.sin(THREE.Math.degToRad(90 - latitude)) * Math.cos(THREE.Math.degToRad(longitude));
                    camera.target.y = 500 * Math.cos(THREE.Math.degToRad(90 - latitude));
                    camera.target.z = 500 * Math.sin(THREE.Math.degToRad(90 - latitude)) * Math.sin(THREE.Math.degToRad(longitude));


                    camera.lookAt(camera.target);
                    // calling again render function
                    renderer.render(scene, camera);

                }

                // when the mouse is pressed, we switch to manual control and save current coordinates
                function onDocumentMouseDown(event) {

                    event.preventDefault();

                    manualControl = true;

                    savedX = event.clientX;
                    savedY = event.clientY;

                    savedLongitude = longitude;
                    savedLatitude = latitude;

                }

                // when the mouse moves, if in manual contro we adjust coordinates
                function onDocumentMouseMove(event) {

                    if (manualControl) {
                        longitude = (savedX - event.clientX) * 0.1 + savedLongitude;
                        latitude = (event.clientY - savedY) * 0.1 + savedLatitude;
                    }

                }

                // when the mouse is released, we turn manual control off
                function onDocumentMouseUp(event) {

                    manualControl = false;

                }

                // pressing a key (actually releasing it) changes the texture map
                container.onkeyup = function (event) {

                    panoramaNumber = (panoramaNumber + 1) % panoramasArray.length
                    sphereMaterial.map = THREE.ImageUtils.loadTexture(panoramasArray[panoramaNumber])

                };
                structurePanorama = {
                    sphereMaterial: sphereMaterial,
                    renderer: renderer,
                    scene: scene,
                    camera: camera,
                    sphere: sphere,
                    sphereMesh: sphereMesh,
                    rayCaster: rayCaster
                };
            }
        },
        /* UPLOADS*/
        _uploadDataPanorama: function (event) {
            $(this.uploadConfig.uploadElementsSelectors.panorama).click();
            event.stopPropagation();
        },
        _initEventsUpload: function () {
            var _this = this;
            $(this.uploadConfig.uploadElementsSelectors.panorama).change(function () {
                var file = $(this)[0].files[0];
                if (file) {
                    if (file.type == "image/png" || file.type == "image/jpeg") {//format
                        var srcSource = window.URL.createObjectURL(file);
                        $(_this.uploadConfig.viewUpload.panorama).attr("src", srcSource);
                        if (_this.modelPanorama.attributes["type_panorama"]==1) {
                            _this.initPanorama(srcSource);
                        }
                        _this.modelPanorama.attributes.src = file;
                        if (_this.modelPanorama.attributes.id) {
                            _this.modelPanorama.attributes.change = true;

                        }

                    } else {
                        alert("No es una imagen.");
                    }
                }
                return false;
            });

            function _addListenerReaderUpload(reader) {
                reader.addEventListener('loadstart', _readerUpload);
                reader.addEventListener('load', _readerUpload);
                reader.addEventListener('loadend', _readerUpload);
                reader.addEventListener('progress', _readerUpload);
                reader.addEventListener('error', _readerUpload);
                reader.addEventListener('abort', _readerUpload);
            }

            function _readerUpload(event) {

                if (event.type === "load") {

                } else if (event.type === "loadend") {

                } else if (event.type === "abort") {

                } else if (event.type === "loadstart") {
                    document.getElementById('progress_bar').className = 'loading';

                } else if (event.type === "error") {
                    switch (event.target.error.code) {
                        case event.target.error.NOT_FOUND_ERR:
                            alert('File Not Found!');
                            break;
                        case event.target.error.NOT_READABLE_ERR:
                            alert('File is not readable');
                            break;
                        case event.target.error.ABORT_ERR:
                            break; // noop
                        default:
                            alert('An error occurred reading this file.');
                    }
                    ;
                } else if (event.type === "progress") {
                    if (event.lengthComputable) {
                        var percentLoaded = Math.round((event.loaded / event.total) * 100);
                        // Increase the progress bar length.
                        if (percentLoaded < 100) {

                        }
                    }
                }
            }

        },
        _routesPointsS2: function (params) {
            var business_id = this.business_id;

            var el = params.objSelector;
            var valueCurrent = this.modelPanorama.attributes.id;
            var dataCurrent = [];
            if (valueCurrent) {

                this.modelPanorama.attributes.routes_map_by_routes_drawing_id_data=this.select2Options.routes_map_by_routes_drawing_id_data.model;
                dataCurrent = [this.select2Options.routes_map_by_routes_drawing_id_data.model];
            }
            var url = this.select2Options.routes_map_by_routes_drawing_id_data.url;
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione Menu Principal",
                data: dataCurrent,
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: url,
                    type: "get",
                    dataType: 'json',
                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: business_id
                            }
                        };
                        return paramsFilters;
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    }
                },
                allowClear: true,
                multiple: false,
                width: '100%'
            });
            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.modelPanorama.attributes.routes_map_by_routes_drawing_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.modelPanorama.attributes.routes_map_by_routes_drawing_id_data = null;
                _this._setValueForm('routes_map_by_routes_drawing_id_data', null);
            });

        }
    },


});
