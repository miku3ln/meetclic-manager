var structurePanorama;
Vue.component('panorama-component', {
    template: '#panorama-template',
    mounted: function () {

    },

    data: function () {

        var dataManager = {
                dataPanorama: {data: $dataResourcesPanorama["data"], title: "hola"},
                dataResourcesPanorama: $dataResourcesPanorama
            }
        ;

        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        _updateChildrenByParent: function (params) {

            if (params.nameComponent == "App") {

                if (params.nameEvent == "_initPanorama") {
                    var currentMarkerId = params["data"]["marker"]["rd_id"];

                    var resultMarkers = $dataBusiness["dataPanorama"].filter(function (index) {
                        return index.routes_drawing_id == currentMarkerId;
                    });
                    if (getObjectLength(resultMarkers) > 0) {
                        this.initPanorama(resultMarkers);

                    }
                }
            }
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
        getImgUrl: function (index) {
            var result = this.dataPanorama.data[index];
            return result;
        },
        getPanoramaInfoUrl: function () {
            var result = this.dataResourcesPanorama["map"]["info"][0];
            return result;
        },
        getPanoramaPoints: function (index) {
            var result = this.dataPanorama.data[index]["dataPoints"];
            return result;
        },
        initPanorama: function (dataPanorama) {
            console.log(69696969);
            $("#container-data canvas").remove();
            var _this = this;
            var urlManager = $resourceRoot + dataPanorama[0]["p_src"];
            var urlInfo = this.getPanoramaInfoUrl(0);
            var dataPoints = [];
            var tooltipElement = $(".tooltip-view");
            var scenesData = [];
            initPanoramic(
                {
                    urlImgParent: urlManager,
                    container: _this.getSelectElement(),
                    elementSelector: ("#" + _this.getSelectorManager()),
                    urlInfo: urlInfo,
                    dataPoints: dataPoints,
                    tooltipElement: tooltipElement
                }
            );

            function initPanoramic(params) {
                var tooltipElementCurrent = params.tooltipElement;
                let spriteActive = false;
                var elementSelector = params.elementSelector;
                var urlInfo = params.urlInfo;
                var dataPointsCurrent = params.dataPoints;
                urlManagerCurrent = params.urlImgParent;


                var measurement = getMeasurementDivContent();
                var widthContent = measurement.width;
                var heightContent = measurement.height;

                function getMeasurementDivContent() {

                    var height = $(window).height();
                    var width = $(window).width();
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
                renderer.setSize(widthContent, heightContent);
                container.appendChild(renderer.domElement);

                // creating a new scenegetSelectElement
                var scene = new THREE.Scene();

                // adding a camera
                var camera = new THREE.PerspectiveCamera(75, widthContent / heightContent, 1, 1000);
                camera.target = new THREE.Vector3(0, 0, 0);


                let s = new Scene(urlManagerCurrent, urlInfo, camera);
                scenesData.push(s);
                urlManagerCurrent2 = params.urlImgParent;
                var allowPoints = false;
                if (getObjectLength(dataPanorama) > 1) {
                    urlManagerCurrent2 = $resourceRoot + dataPanorama[1]["p_src"];
                    allowPoints = true;
                }
                let s2 = new Scene(urlManagerCurrent2, urlInfo, camera);
                scenesData.push(s2);

                function initRotatePanorama(params) {
                    if (params.type == "controls") {

                        var controls = new THREE.OrbitControls(camera);
                        controls.rotateSpeed = 0.2;
                        controls.enableZoom = false;
                        controls.autoRotate = true;
                        camera.position.set(-1, 0, 0);
                        controls.update();
                    } else if (params.type == "custom") {

                        var currentManualControl = params.manualControl;
                        var currentLatitude = params.latitude;

                        if (!currentManualControl) {
                            longitude += 0.1;
                        }
                        currentLatitude = Math.max(-85, Math.min(85, currentLatitude));
                        camera.target.x = 500 * Math.sin(THREE.Math.degToRad(90 - currentLatitude)) * Math.cos(THREE.Math.degToRad(currentLatitude));
                        camera.target.y = 500 * Math.cos(THREE.Math.degToRad(90 - currentLatitude));
                        camera.target.z = 500 * Math.sin(THREE.Math.degToRad(90 - currentLatitude)) * Math.sin(THREE.Math.degToRad(currentLatitude));
                        camera.lookAt(camera.target);

                    }
                }

                initRotatePanorama({type: "controls"});
                // creation of a big sphere geometry
                var sphere = new THREE.SphereGeometry(100, 100, 40);
                sphere.applyMatrix(new THREE.Matrix4().makeScale(-1, 1, 1));


                var rayCaster = new THREE.Raycaster();
                initRotatePanorama(params);


                function getListChildrenScene() {

                    let nodesChildren = scene.children;
                    let intersects = rayCaster.intersectObjects(nodesChildren);
                    return intersects;
                }


                function setPropertiesToolTip(params) {
                    var type = params.type;
                    var foundSprite = params.foundSprite;
                    var spriteActive = params.spriteActive;


                    if (type == "clickPanorama") {

                    } else {

                        if (foundSprite == false && spriteActive) {
                            tooltipElementCurrent.removeClass("is-active");
                            /*      TweenLite.to(
                                      spriteActive.scale, 0.3,
                                      {
                                          x: 2,
                                          y: 2,
                                          z: 2
                                      }
                                  );*/
                        } else {
                            if (spriteActive !== null) {

                                /*  TweenLite.to(
                                      spriteActive.scale, 0.3,
                                      {
                                          x: 3,
                                          y: 3,
                                          z: 3
                                      }
                                  );*/
                            }
                        }
                    }
                }

                function setPropertiesTag(params) {
                    heightContent = params.heightContent;
                    widthContent = params.widthContent;
                    var name = params.name;

                    let p = params.p;
                    let topCurrent = ((-1 * p.y + 1) * heightContent) - (63);
                    let leftCurrent = ((p.x + 1) * widthContent) - 197;
                    tooltipElementCurrent.css({top: topCurrent + "px", left: leftCurrent + "px"});
                    tooltipElementCurrent.addClass("is-active");
                    tooltipElementCurrent.html(name);
                }

                function eventType(event, type) {//other


                    if (type != "mouseMove") {
                        console.log(type);
                    }
                    measurement = getMeasurementDivContent();
                    widthContent = measurement.width;
                    heightContent = measurement.height;
                    var position = getValuesPosition(event);
                    let mouse = new THREE.Vector2(position.x, position.y);
                    rayCaster.setFromCamera(mouse, camera);
                    let intersects = getListChildrenScene();
                    let foundSprite = false;
                    spriteActive = null;
                    intersects.forEach(function (intersect) {
                        if (intersect.object.type == "Sprite") {
                            console.log(intersect.object.name);
                            let p = intersect.object.position.clone().project(camera);
                            spriteActive = intersect.object;
                            foundSprite = true;
                            if (type == "mouseMove") {
                                setPropertiesTag(
                                    {
                                        p: p,
                                        heightContent: heightContent,
                                        widthContent: widthContent
                                    }
                                );
                                setPropertiesToolTip({
                                    spriteActive: spriteActive,
                                    foundSprite: foundSprite,
                                    type: type
                                });
                            } else {
                                intersect.object.onClick();
                            }
                        } else {
                            if (type == "clickPanorama") {
                                console.log("no esta en l tag", intersect.point);
                            }
                        }
                    });
                    if (type == "mouseMove") {

                        setPropertiesToolTip({
                            spriteActive: spriteActive,
                            foundSprite: foundSprite,
                            type: type
                        });
                    }

                }

                // listeners functions
                function _panorama(event) {
                    event.preventDefault();
                    eventType(event, "clickPanorama");

                }

                // when the mouse is pressed, we switch to manual control and save current coordinates
                function _panoramaMouseDown(event) {

                    event.preventDefault();
                    manualControl = true;
                    savedX = event.clientX;
                    savedY = event.clientY;
                    savedLongitude = longitude;
                    savedLatitude = latitude;
                }

                // when the mouse moves, if in manual contro we adjust coordinates
                function _panoramaMouseMove(event) {
                    event.preventDefault();
                    if (manualControl) {
                        longitude = (savedX - event.clientX) * 0.1 + savedLongitude;
                        latitude = (event.clientY - savedY) * 0.1 + savedLatitude;
                    }
                    eventType(event, "mouseMove");
                }

                // when the mouse is released, we turn manual control off
                function _panoramaMouseUp(event) {
                    event.preventDefault();
                    manualControl = false;
                }

                function _resize() {
                    var measurementCurrent = getMeasurementDivContent();
                    widthContent = measurementCurrent.width;
                    heightContent = measurementCurrent.height;
                    renderer.setSize(widthContent, heightContent);
                    camera.aspect = widthContent / heightContent;
                    camera.updateProjectionMatrix();
                }

                render();
                var currentAnimate;

                function render() {

                    currentAnimate = requestAnimationFrame(render);

                    if (!manualControl) {
                        longitude += 0.1;
                    }
                    if (false) {
                        initRotatePanorama({type: "custom", latitude: latitude, manualControl: manualControl});

                    }
                    // calling again render function
                    renderer.render(scene, camera);

                }

                var namePoint = "";
                if (allowPoints) {

//tv
                    xCurrent = (12.59833975665938);
                    yCurrent = (30.936738954499187);
                    zCurrent = 94.2351768184257;

                    pointCurrent = new THREE.Vector3(xCurrent, yCurrent, zCurrent);
                    var namePoint = "TV";

                    s.addPoints({position: pointCurrent, name: namePoint, scene: s2});
                    // pressing a key (actually releasing it) changes the texture map
                    xCurrent = (90.85716428243984);
                    yCurrent = (-0.42364928312604316);
                    zCurrent = 41.670711517142;

                    pointCurrent = new THREE.Vector3(xCurrent, yCurrent, zCurrent);
                }
                /* addToolTip(pointCurrent, 'Puerta Aldaba');*/
                // listeners events
                container.addEventListener("mousedown", _panoramaMouseDown, false);
                container.addEventListener("mousemove", _panoramaMouseMove, false);
                container.addEventListener("mouseup", _panoramaMouseUp, false);
                container.addEventListener("click", _panorama, false);
                window.addEventListener("resize", _resize, false);
//lampara
                xCurrent = (-92.72014891162326);
                yCurrent = (35.72340440012801);
                zCurrent = -10.329867780384534;

                pointCurrent = new THREE.Vector3(xCurrent, yCurrent, zCurrent);
                namePoint = "AUDIO";
                s2.addPoints({position: pointCurrent, name: namePoint, scene: s});

                // creation of the sphere material
                s.createScene(
                    scene
                );

                structurePanorama = {
                    renderer: renderer,
                    scene: scene,
                    camera: camera,
                    sphere: sphere,
                    rayCaster: rayCaster,
                    scenesData: scenesData
                };


            }

        }
    },

    props: {
        parentData: {
            type: String,
            default
                () {
                return ''
            }
        }
        ,
        title: {
            type: String
        }
        ,
        messageParent: {
            type: String
        }
        ,
        configparams: {
            type: Object,
        }

    }
    ,
    beforeMount() {
        /*  this.configparams = this.configparams;
          _this = this;*/


    }
});

class Scene {
    constructor(image, urlInfo, camera) {
        this.image = image;
        this.points = [];
        this.urlInfo = urlInfo;
        this.sprites = [];
        this.scene = null;
        this.camera = camera;
    }

    createScene(scene) {

        this.scene = scene;
        // creation of a big sphere geometry
        var sphere = new THREE.SphereGeometry(50, 32, 32);
        sphere.applyMatrix(new THREE.Matrix4().makeScale(-1, 1, 1));

        // creation of the sphere material
        var sphereMaterial = new THREE.MeshBasicMaterial();
        sphereMaterial.map = THREE.ImageUtils.loadTexture(
            this.image,   // onLoad callback
            function (texture) {
                console.log("onLoad main ", texture);
            },

            // onProgress callback currently not supported
            function (response) {
                console.log("cargando main .....", response);
            },
            // onError callback
            function (err) {
                console.log('An error happened main.', err);
            });
        sphereMaterial.transparent = true;
        sphereMaterial.side = THREE.DoubleSide;

        // geometry + material = mesh (actual object)
        this.sphereMesh = new THREE.Mesh(sphere, sphereMaterial);
        this.scene.add(this.sphereMesh);
        this.initPoints();
    }

    addToolTip(point) {
        let textureInfoLoader = new THREE.TextureLoader();
        let textureInfoLoad = textureInfoLoader.load(
            // resource URL
            this.urlInfo,
            // onLoad callback
            function (texture) {
                console.log("onLoad info", texture);
            },

            // onProgress callback currently not supported
            function (response) {
                console.log("cargando info .....", response);
            },
            // onError callback
            function (err) {
                console.log('An error happened info.', err);
            }
        );

        let spriteMap = textureInfoLoad;
        let spriteMaterial = new THREE.SpriteMaterial(
            {
                map: spriteMap
            }
        );
        let sprite = new THREE.Sprite(
            spriteMaterial
        );
        sprite.name = point.name;
        sprite.position.copy(point.position.clone().normalize().multiplyScalar(10));
        this.scene.add(sprite);
        this.sprites.push(sprite);
        sprite.onClick = () => {
            this.destroy();

            point.scene.createScene(this.scene);
            point.scene.appear();
        };
    }

    addPoints(points) {
        this.points.push(points);
    }

    initPoints() {
        this.points.forEach(this.addToolTip.bind(this));
    }

    destroy() {
        if (this.camera) {

            /* TweenLite.to(this.camera, 0.5, {
                 zoom: 2,
                 onUpdate: function () {
                     this.camera.updateProjectionMatrix();
                 }
             });*/

        }
        TweenLite.to(this.sphereMesh.material, 1, {
            opacity: 0,
            onComplete: () => {
                this.scene.remove(this.sphereMesh);
            }
        });
        this.sprites.forEach((sprite) => {
            TweenLite.to(sprite.scale, 1, {
                x: 0,
                y: 0,
                z: 0,
                onComplete: () => {
                    this.scene.remove(sprite);
                }
            });
        });
    }

    appear() {

        if (this.camera) {
            /*
                        TweenLite.to(this.camera, 0.5, {
                            zoom: 1,
                            onUpdate: function () {
                                this.camera.updateProjectionMatrix();
                            }
                        }).delay(0.5);*/
        }
        TweenLite.to(this.sphereMesh.material, 1, {
            opacity: 1
        });

        this.sprites.forEach((sprite) => {
            sprite.scale.set(0, 0, 0);
            TweenLite.to(sprite.scale, 1, {
                x: 2,
                y: 2,
                z: 2
            });
        });
    }
}
