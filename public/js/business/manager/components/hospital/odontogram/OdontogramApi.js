/*-----------METHODS of odontogram--*/
var dataSVG;
var elementContentDataInferior = "#content-all-data-odontogram-inferior";
var elementRenderDataInferior = "#content-render-data-odontogram-inferior";
var initSvgOdontogramInferior;
var elementContentDataSuperior = "#content-all-data-odontogram-superior";
var elementRenderDataSuperior = "#content-render-data-odontogram-superior";
var initSvgOdontogramSuperior;
var initOdontogram = false;
var contentElementFrm = ".content__form-dental_piece_by_odontogram";
var odontogram_by_patient_id;
/*---MANAGEMENT--*/
var managementDataOdontogram;
var initCara = false;
var typeDPBO = "PERMANENT";
/*--Content Parent ODONTOGRAM---*/
var contentParentMeasure = ".tab-content";

function renderOdontograms(params) {
    var $scope = params['scope'];
    this.itemsRows = [];
    var odontogramCurrentId;
    var odontogramCurrentType;
    var dataOndontogramPieceByOdontogram;
    var currentPieceObj;
    var functionsObjThis = {
        initOdontogramsSvg: function (callback = null) {
            /* if (!initOdontogram) {*/
            var result = [];
            var url_svg = $publicAsset + '/' + "svg/odontograma/odontograma_inferior.svg";
            initSvgOdontogramInferior = Snap(elementRenderDataInferior);
            Snap.load(url_svg, function (f) {
                dataSVG = f;
                var g_svg = f.select(elementContentDataInferior);
                setDimention(g_svg);
                initSvgOdontogramInferior.append(g_svg);
                var svgInitObj = initSvgOdontogramInferior;
                elementDataRender = elementContentDataInferior;
                viewBoxAttr = "0 0 1163 400";
                functionsObjThis.initEventsOdontogram(svgInitObj, elementDataRender, viewBoxAttr);
                functionsObjThis.initLoadPiecesOdontogram(svgInitObj);
                var url_svg = $publicAsset + '/' + "svg/odontograma/odontograma_superior.svg";
                initSvgOdontogramSuperior = Snap(elementRenderDataSuperior);
                Snap.load(url_svg, function (f) {
                    var g_svg = f.select(elementContentDataSuperior);
                    setDimention(g_svg);
                    initSvgOdontogramSuperior.append(g_svg);
                    var svgInitObj = initSvgOdontogramSuperior;
                    elementDataRender = elementContentDataSuperior;
                    viewBoxAttr = "0 0 1163 400";
                    functionsObjThis.initEventsOdontogram(svgInitObj, elementDataRender, viewBoxAttr);
                    functionsObjThis.initLoadPiecesOdontogram(svgInitObj);
                    if (callback) {
                        callback({
                            initSvgOdontogramInferior: initSvgOdontogramInferior,
                            initSvgOdontogramInferior: initSvgOdontogramInferior
                        });

                    }

                });
            });


            initOdontogram = true;
            /*}*/
        }, getDataDentalPieceByOdontogramId: function (id) {
            odontogramCurrentId = id;
            odontogram_by_patient_id = id;

            var action = $("#action_odontogram_dental_piece_by_odontogram").val();
            var blockElement = $(".conten__render-management");
            var loading_message = "Cargando...";
            ajaxRequest(action, {
                type: 'POST',
                blockElement: blockElement,
                loading_message: loading_message,
                error_message: 'Error al cargar Informacion',
                data: {odontogram_by_patient_id: odontogram_by_patient_id},
                beforeSend: function (jqXHR, settings) {
                    console.log("init");
                },
                success_callback: function (data) {
                    functionsObjThis.setValuesOdontogramsSvg(data);

                }
            });


        }, getObjectCurrentPiece: function () {
            return currentPieceObj;
        },
        clearOdontogramsSvg: function () {
            var caras = initSvgOdontogramInferior.select("#Caras");
            var polygons = caras.selectAll("polygon");
            $.each(polygons, function (key, item) {
                item.attr("fill", "#fff");
                item.attr("fill-opacity", "0");
                $(item.node).removeAttr("dental_piece_by_odontogram_id");
            });
            var caras = initSvgOdontogramSuperior.select("#Caras");
            var polygons = caras.selectAll("polygon");
            $.each(polygons, function (key, item) {
                item.attr("fill", "#fff");
                item.attr("fill-opacity", "0");
                $(item.node).removeAttr("dental_piece_by_odontogram_id");
            });

            functionsObjThis.initLoadPiecesOdontogram(initSvgOdontogramInferior);
            functionsObjThis.initLoadPiecesOdontogram(initSvgOdontogramSuperior);

        },
        setConfigPiece: function (item) {

            var elementSearch = functionsObjThis.getElementFormat(item);
            var objSvgSearch = functionsObjThis.searchAllPieceObjSvgByElement(elementSearch);
            var type = item.reference_piece_type;
            if (objSvgSearch) {
                objSvgSearch.attr("management-items", 1);
                var dental_piece_by_odontogram_id = null;
                if (item.hasOwnProperty('id')) {
                    dental_piece_by_odontogram_id = item.id;
                }

                var colorSet = item.reference_piece_color;
                objSvgSearch.attr("fill", colorSet);
                objSvgSearch.attr("stroke", colorSet);
                objSvgSearch.attr("fill-opacity", "0.3");
                if (type == "COMPLETE") {
                    objSvgSearch.removeClass("hide-element");
                    var elementModify = "#pieza_" + item.dental_piece_piece;
                    if (dental_piece_by_odontogram_id) {
                        $(elementModify).attr("dental_piece_by_odontogram_id", dental_piece_by_odontogram_id);
                    }
                    /*----RESIDUO RADICAL--- */
                    var rr = objSvgSearch.select()

                } else {

                    if (dental_piece_by_odontogram_id) {
                        $(elementModify).attr("dental_piece_by_odontogram_id", dental_piece_by_odontogram_id);
                    }
                }

            } else {
                console.log("no encontrado");
            }
        },
        resetCleanPiece:function(item){

            var elementSearch = functionsObjThis.getElementFormat(item);
            var objSvgSearch = functionsObjThis.searchAllPieceObjSvgByElement(elementSearch);
            var type = item.reference_piece_type;
            if (objSvgSearch) {
                $(objSvgSearch.node).removeAttr('management-items')
                var dental_piece_by_odontogram_id = null;
                if (item.hasOwnProperty('id')) {
                    dental_piece_by_odontogram_id = item.id;
                }

                var colorSet = item.reference_piece_color;
                objSvgSearch.attr("fill", colorSet);
                objSvgSearch.attr("stroke", colorSet);
                objSvgSearch.attr("fill-opacity", "0");
                if (type == "COMPLETE") {
                    objSvgSearch.addClass("hide-element");
                    var elementModify = "#pieza_" + item.dental_piece_piece;
                    if (dental_piece_by_odontogram_id) {
                        $(elementModify).removeAttr("dental_piece_by_odontogram_id");
                    }
                    /*----RESIDUO RADICAL--- */
                    var rr = objSvgSearch.select()

                } else {

                    if (dental_piece_by_odontogram_id) {
                        $(elementModify).removeAttr("dental_piece_by_odontogram_id");
                    }
                }

            } else {
                console.log("no encontrado");
            }
        },
        setValuesOdontogramsSvg: function (dataPieces) {
            $.each(dataPieces, function (key, item) {
                functionsObjThis.setConfigPiece(item);

            });
        }, getElementFormat: function (data) {
            var type = data.reference_piece_type;
            var result = "";
            if (type == "INDIVIDUAL") {//son poligonos y tiene cdaa poligono
                position = data.reference_piece_position_position;
                var positionSvg = getReferencePiecePositionByFormatData(position);
                var piece = data.dental_piece_piece;
                result = "#cara_" + piece + "_" + positionSvg;
            } else {
                var reference_piece_id = data.reference_piece_id;
                var dentalPieceId = data.dental_piece_piece;
                result = getIdPiecePart(parseInt(reference_piece_id), dentalPieceId)
            }

            return result;
        }, searchAllPieceObjSvgByElement: function (element) {
            var objSvg = null;
            objSvg = initSvgOdontogramInferior.select(element);
            if (objSvg) {
                return objSvg;
            }
            objSvg = initSvgOdontogramSuperior.select(element);
            if (objSvg) {
                return objSvg;
            }
        },
        resetIndividualByCurrent: function () {
            initCara = false;
            var objectSvgCurrent = this.getObjectCurrentPiece();
            if (objectSvgCurrent) {
                if (objectSvgCurrent.hasClass("piece-hover--management-complete")) {
                    objectSvgCurrent.removeClass("init-management-complete");
                    var id = objectSvgCurrent.node.id;
                    var individualData = id.split("_");
                    var elementModify = "#hover_" + individualData[1];
                    $(elementModify).removeClass("piece-hover--management");
                    var elementModify = "#pieza_" + individualData[1];
                    $(elementModify).removeClass("piece-hover--management-complete");

                }
                if (objectSvgCurrent.hasClass("init-management-cara")) {
                    objectSvgCurrent.removeClass("init-management-cara");
                    objectSvgCurrent.attr("fill", "#008ACA");
                    objectSvgCurrent.attr("fill-opacity", "0");
                }

            }


        }
        , resizeElementsSNAPSVG: function (params = null) {
            resizeElementsSNAPSVG(params);
        }, initLoadPiecesOdontogram: function (svgInitComponents) {
            initLoadPiecesOdontogram(svgInitComponents);
        }, initEventsOdontogram: function (svgInitObj, elementDataRender, viewBoxAttr) {
            initEventsOdontogram(svgInitObj, elementDataRender, viewBoxAttr);
        }, afterFullScreenOn: function () {
            OdontogramView.resizeElementsSNAPSVG();
            var g_svg = initSvgOdontogramSuperior.select(elementContentDataSuperior);
            g_svg.attr({viewBox: "0 0 985 287"});
            var g_svg = initSvgOdontogramInferior.select(elementContentDataInferior);
            g_svg.attr({viewBox: "0 -4 985 287"});
        }, afterFullScreenOff: function () {
            OdontogramView.resizeElementsSNAPSVG();
            var g_svg = initSvgOdontogramSuperior.select(elementContentDataSuperior);
            g_svg.attr({viewBox: "0 0 985 287"});
            var g_svg = initSvgOdontogramInferior.select(elementContentDataInferior);
            g_svg.attr({viewBox: "0 -4 985 287"});
        }


    };
    return functionsObjThis;

    function resizeElementsSNAPSVG(params = null) {
        elementId = (elementContentDataInferior);
        if (initSvgOdontogramInferior) {
            var g_svg = initSvgOdontogramInferior.select(elementContentDataInferior);
            setDimention(g_svg, params);
            initSvgOdontogramInferior.append(g_svg);
        }

        elementId = (elementContentDataSuperior);
        if (initSvgOdontogramSuperior) {
            var g_svg = initSvgOdontogramSuperior.select(elementContentDataSuperior);
            setDimention(g_svg, params);
            initSvgOdontogramSuperior.append(g_svg);
        }
    }


    function onClickPositionCara() {
        currentPieceObj = this;
        var initManagementCreateUpdate = true;//create =true,update=false
        if ($(currentPieceObj.node).attr("dental_piece_by_odontogram_id")) {
            initManagementCreateUpdate = false;
        }
        var id = this.node.id;
        reference_piece_position = "";
        var individualData = id.split("_");
        reference_piece_position = getReferencePiecePositionByFormatSvg(individualData[2]);
        var dentalPieceId = individualData[1];
        managementDataOdontogram = {};
        managementDataOdontogram = {
            reference_piece_position_id: reference_piece_position,
            type: "INDIVIDUAL",
            "typeDPBO": typeDPBO,
            dental_piece_id: dentalPieceId,
        };
        if (initManagementCreateUpdate) {
            var itemsClick = initSvgOdontogramInferior.selectAll(".init-management-cara").items;
            if (itemsClick) {
                $.each(itemsClick, function (key, item) {
                    if (item.node) {
                        item.removeClass(".init-management-cara");
                        if (!item.attr("management-items")) {
                            item.attr("fill", "#008ACA");
                            this.attr("fill-opacity", "0");
                        }

                    }
                });
            }

            var itemsClick = initSvgOdontogramSuperior.selectAll(".init-management-cara").items;
            if (itemsClick) {
                $.each(itemsClick, function (key, item) {
                    if (item.node) {


                        item.removeClass(".init-management-cara");
                        if (!item.attr("management-items")) {
                            item.attr("fill", "#008ACA");
                            this.attr("fill-opacity", "0");
                        }

                    }
                });
            }
            if (!this.hasClass("init-management-cara")) {
                this.addClass("init-management-cara");
                if (!this.attr('management-items')) {
                    this.attr("fill", "#008ACA");
                    this.attr("fill-opacity", "0.3");
                }
                initCara = true;
            } else {
                initCara = false;
                this.removeClass("init-management-cara");
                if (!this.attr('management-items')) {
                    this.attr("fill", "#008ACA");
                    this.attr("fill-opacity", "0");
                }
            }

        } else {
            console.log("DETAILS CARA");
        }

        var managementForm = {
            dentalPieceId: dentalPieceId,
            initElement: initCara,
            individualData: individualData,
            initManagementCreateUpdate: initManagementCreateUpdate,
            managementDataOdontogram: managementDataOdontogram,
            currentPieceObj: currentPieceObj

        };
        console.log('viewTwo');

        viewFrm(managementForm);
    }

    function viewFrm(params) {

        $scope._viewFrmManagement(params);

    }

    function getReferencePiecePositionByFormatSvg(number) {
        result = "";
        if (number == 3) {//DOWN
            result = "DOWN";

        } else if (number == 1) {//TOP
            result = "TOP";

        } else if (number == 2) {//RIGHT
            result = "RIGHT";

        } else if (number == 5) {//CENTER
            result = "CENTER";

        } else if (number == 4) {//LEFT
            result = "LEFT";
        }
        return result;
    }

    function getReferencePiecePositionByFormatData(position) {
        result = "";
        if (position == "DOWN") {//DOWN
            result = 3;

        } else if (position == "TOP") {//TOP
            result = 1;

        } else if (position == "RIGHT") {//RIGHT
            result = 2;

        } else if (position == "CENTER") {//CENTER
            result = 5;

        } else if (position == "LEFT") {//LEFT
            result = 4;
        }

        return result;
    }

    function setDimention(elementSNAPSVGChange, params = null) {
        var width = $(contentParentMeasure).width();
        var height = params ? params.height : 300;
        elementSNAPSVGChange.attr("width", width);
        elementSNAPSVGChange.attr("height", height);

    }

    function getIdPiecePart(dental_piece_id, pieceNumber) {
        var elementNameId = "";
        switch (dental_piece_id) {
            /*-----------LESIONES-------*/
            case 24://fractura
                elementNameId = "#f_" + pieceNumber;
                break;
            case 5:// "caries" aplica a toda la pieza individual(arriba,abajo,centro,izquierda,derecha) y completa
                elementNameId = "#c_" + pieceNumber;
                break;
            case 25://"indeccion pulpar"
                elementNameId = "#ip_" + pieceNumber;
                break;
            case 26://"movilidad"
                elementNameId = "#mov_" + pieceNumber;
                break;
            case 27://"residuo radicular" only piece complete
                elementNameId = "#rr_" + pieceNumber;
                break;
            case 28://"otro"only piece complete
                elementNameId = "#o_" + pieceNumber;
                break;
            /*-----------PREEXISTENCIAS-------*/
            case 19:// "corona"piece individual y pieza completa color verde
                elementNameId = "#cor_" + pieceNumber;
                break;
            case 20:// "corona a realizar "piece individual y pieza completa color verde
                elementNameId = "#cor_" + pieceNumber;
                break;
            case 21:// "corona  realizada "piece individual y pieza completa color verde
                elementNameId = "#cor_" + pieceNumber;
                break;
            case 29://"restauracion"piece individual y pieza completa color verde
                elementNameId = "#r_" + pieceNumber;
                break;
            case 16://"endodoncia"pieza completa color verde
                elementNameId = "#endo_" + pieceNumber;
                break;
            case 12://"implante"pieza completa color verde
                elementNameId = "#i_" + pieceNumber;
                break;
            case 30://"perno muñon"pieza completa color verde
                elementNameId = "#pm_" + pieceNumber;
                break;
            case 11://"protesis removible"pieza completa color verde
                elementNameId = "#protesis_removible_" + pieceNumber;
                break;
            case 3 ://"ausente" pieza completa opacity y ocultar pieza individual
                elementNameId = "#ausente_" + pieceNumber;
                break;

        }
        return elementNameId;

    }

    function initEventsOdontogram(svgInitObj, elementDataRender, viewBoxAttr) {
        var caras = svgInitObj.select("#Caras");
        if (caras) {
            carasPiezas = caras.selectAll("polygon");
            $.each(carasPiezas, function (key, cara) {
                if (cara.node) {
                    cara.click(onClickPositionCara);
                    cara.hover(viewInfoMouseOver, viewInfoUnMouseOver);
                    cara.addClass("pointer-mouse");
                }
            });
        }
        var pieces = svgInitObj.selectAll(".pieces__piece");
        $.each(pieces, function (key, piece) {
            piece.click(clickPieceCompleteManagement);
            piece.hover(pieceCompleteMouseOver, pieceCompleteUnMouseOver);
            piece.addClass("pointer-mouse");
        });
        var viewBoxMain = svgInitObj.select(elementDataRender);
        if (viewBoxMain) {
            viewBoxMain.attr({viewBox: viewBoxAttr});

        }

    }


    function initLoadPiecesOdontogram(svgInitComponents) {

        var pieces = svgInitComponents.select("#Piezas");
        var piecesElements = pieces.selectAll(".pieces__piece");

        $.each(piecesElements, function (key, item) {
            var elementId = $(item.node).attr("id");
            $(item.node).removeAttr("dental_piece_by_odontogram_id");
            var identificationArray = elementId.split("_");
            var pieceNumber = identificationArray[1];
            var elementModify = "#f_" + pieceNumber;
            var g_svg = item.select(elementModify);
            g_svg.addClass("hide-element");
            elementModify = "#c_" + pieceNumber;
            g_svg = item.select(elementModify);
            g_svg.addClass("hide-element");
            elementModify = "#ip_" + pieceNumber;
            g_svg = item.select(elementModify);
            g_svg.addClass("hide-element");
            elementModify = "#mov_" + pieceNumber;
            g_svg = item.select(elementModify);
            g_svg.addClass("hide-element");
            elementModify = "#rr_" + pieceNumber;
            g_svg = item.select(elementModify);
            g_svg.addClass("hide-element");
            elementModify = "#o_" + pieceNumber;
            g_svg = item.select(elementModify);
            g_svg.addClass("hide-element");
            elementModify = "#cor_" + pieceNumber;
            g_svg = item.select(elementModify);
            g_svg.addClass("hide-element");
            elementModify = "#r_" + pieceNumber;
            g_svg = item.select(elementModify);
            g_svg.addClass("hide-element");
            elementModify = "#endo_" + pieceNumber;
            g_svg = item.select(elementModify);
            g_svg.addClass("hide-element");
            elementModify = "#i_" + pieceNumber;
            g_svg = item.select(elementModify);
            g_svg.addClass("hide-element");
            elementModify = "#pm_" + pieceNumber;
            g_svg = item.select(elementModify);
            g_svg.addClass("hide-element");
            elementModify = "#protesis_removible_" + pieceNumber;
            g_svg = item.select(elementModify);
            g_svg.addClass("hide-element");
            elementModify = "#e_" + pieceNumber;
            g_svg = item.select(elementModify);
            g_svg.addClass("hide-element");
            elementModify = "#protesis_fija_" + pieceNumber;
            g_svg = item.select(elementModify);
            g_svg.addClass("hide-element");
            elementModify = "#rx_" + pieceNumber;
            g_svg = item.select(elementModify);
            g_svg.addClass("hide-element");
            elementModify = "#no_protesis_fija_" + pieceNumber;
            g_svg = item.select(elementModify);
            if (g_svg) {
                g_svg.addClass("hide-element");
            }

        });
        var pilares = svgInitComponents.selectAll(".pillar");
        $.each(pilares, function (key, item) {
            item.addClass("hide-element");
        });
        var piecehovers = svgInitComponents.selectAll(".piece-hover");
        $.each(piecehovers, function (key, item) {
            item.addClass("hide-element");

        });


    }

    /*--------EVENTS PIECES(INDIVIDUAL-COMPLETE)----*/
    function clickPieceCompleteManagement() {
        currentPieceObj = this;
        var type = "COMPLETE";
        var classModifyManagement = "piece-hover--management";
        var initManagementCreateUpdate = true;//create =true,update=false
        if ($(currentPieceObj.node).attr("dental_piece_by_odontogram_id")) {
            initManagementCreateUpdate = false;
        }
        var id = this.node.id;
        reference_piece_position = "";
        var individualData = id.split("_");
        reference_piece_position = type;
        var dentalPieceId = individualData[1];
        managementDataOdontogram = {};
        managementDataOdontogram = {
            reference_piece_position_id: reference_piece_position,
            type: type,
            dental_piece_id: dentalPieceId,
            "typeDPBO": typeDPBO,

        };
        if (initManagementCreateUpdate) {
            var itemsClick = initSvgOdontogramInferior.selectAll(classModifyManagement + "-complete").items;
            if (itemsClick) {
                $.each(itemsClick, function (key, item) {
                    if (item.node) {
                        item.removeClass(classModifyManagement + "-complete");
                    }
                });
            }

            var itemsClick = initSvgOdontogramSuperior.selectAll(classModifyManagement + "-complete").items;
            if (itemsClick) {
                $.each(itemsClick, function (key, item) {
                    if (item.node) {
                        item.removeClass(classModifyManagement + "-complete");
                    }
                });
            }
            $("." + classModifyManagement).removeClass(classModifyManagement);
            if (!this.hasClass(classModifyManagement + "-complete")) {
                this.addClass(classModifyManagement + "-complete");
                var elementModify = "#hover_" + dentalPieceId;
                $(elementModify).addClass(classModifyManagement);
                initCara = true;
            } else {
                initCara = false;
                this.removeClass(classModifyManagement + "-complete");
                var elementModify = "#hover_" + dentalPieceId;
                $(elementModify).removeClass(classModifyManagement);
            }


        } else {
            console.log("DETAILS PIEZA COMPLETE");
        }
        var managementForm = {
            dentalPieceId: dentalPieceId,
            initElement: initCara,
            individualData: individualData,
            initManagementCreateUpdate: initManagementCreateUpdate,
            managementDataOdontogram: managementDataOdontogram,
            currentPieceObj: currentPieceObj

        };
        console.log('viewOne');
        viewFrm(managementForm);
    }

    function viewInfoMouseOver() {
        this.attr("stroke", "#008ACA");
    }

    function viewInfoUnMouseOver() {
        this.attr("stroke", "#000000");
    }

    function pieceCompleteMouseOver() {

        var id = this.node.id;
        reference_piece_position = "";
        var individualData = id.split("_");
        var pieceNumber = individualData[1];
        elementModify = ("#hover_" + pieceNumber);
        $(elementModify).removeClass("hide-element");


    }

    function pieceCompleteUnMouseOver() {
        var id = this.node.id;
        reference_piece_position = "";
        var individualData = id.split("_");
        var pieceNumber = individualData[1];
        elementModify = ("#hover_" + pieceNumber);
        $(elementModify).addClass("hide-element");

    }
}

