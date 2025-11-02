/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function initBootgridEntidad($scope) {
    gestionBotonesGrid($scope);
    var grid_inicializar = "#" + formatModel.gridName;
    $scope.bootgrid_main = grid_inicializar;
//    ---formateo de valores d columnas
    var formatter_items_result = getDataBtnsMultiple($btn_custom_object_grid);
    var formatter_items =
        {
            'value': function (column, row) {
                var spanish1 = row.value;
                var english1 = row.name_english;
                var $html = "";
                $html+="<span class='spanish'>"+spanish1+"</span><br>"+"<span class='english'>"+english1+"</span>";
                return $html;
            }
        };

    $scope.params_bootgrid_admin =
        {
            init_ajax: true, //permite inicializar o obtener datos via ajax
            filters: {
                entidad_data_id: entidad_id, //id de la empresa
                tipo_detalle: 0//id de la empresa
            },
            url_get_data: $EntityInfoData.entidad_info.actions.admin.url,
            element: grid_inicializar,
//                btn_personalizado_object_data: $btn_custom_object_grid, //botones horizontale unidos :),
//                ---para personalizar los campos de la tabla--
        object_formater: formatter_items,
        function: function () {
            console.log("init grid proyectos");
        }
    };
//   -----CREAR MULTIPLES GESTIONES BOTONES en l mismo format---

    formatter_items = $.extend(formatter_items, formatter_items_result);
    $scope.verificar_eventos = "NADA DE EVENTOS";
//    --reinicia los valores de los parametros--
    $scope.rebootData = function () {
        var grid_inicializar = $scope.params_bootgrid_admin.element;
        $(grid_inicializar).bootgrid("destroy");
        $scope.params_bootgrid_admin =
            {
                init_ajax: true, //permite inicializar o obtener datos via ajax
                filters: {
                    entidad_data_id: entidad_id, //id de la empresa
                },
                url_get_data: $EntityInfoData.entidad_info.actions.admin.url,
//                    url_get_data: "contabilidad/movimientoCajaGeneralHasEntidad/adminEntidad",
            element: grid_inicializar,
//                    btn_personalizado_object_data: $btn_custom_object_grid, //botones horizontale unidos :),
//                ---para personalizar los campos de la tabla--
            object_formater: formatter_items
        };
        initGridEntidad($scope.params_bootgrid_admin, $scope);

    }
    $scope.resetDataBootgrid = function (element) {
        var grid_inicializar = element;
        $(grid_inicializar).bootgrid("reload");
    }
    initGridEntidad($scope.params_bootgrid_admin, $scope);
    $scope.span_perrin = function (data) {
        alert(data);
    }
    $scope.initGridsProyectos = function () {

    };
    $scope.initDataProyectos = function () {
        $scope.title_left = "Gestión";
        $scope.title_rigth = "del Proyecto " + $scope.data_entidad_view.value;
//            $scope.data_entidad_view 
        $scope.data_factura_encabezado.cliente_data = {
            id: $scope.data_entidad_view.c_id,
            text: $scope.data_entidad_view.cliente
        };
//     ---punto_ventaGrids
        $scope.initGridVentasFacturas();
    };

}


//---GESTIONES DE BOTONES-
//command-gestion-entidad
function gestionBotonesGrid($scope) {
//    command-gestion-entidad
    $scope.commandGestionEntidad = function (entidad_gestion) {
        var gestion_type = $(entidad_gestion).attr("gestion_type");
        switch (gestion_type) {
            case "update_entidad"://bton actualizar proyectos
                var instance_data_rows = getDataInstanciaBootgrid($($scope.bootgrid_main));
                var data_row_id = $(entidad_gestion).data("row-id");//
                $scope.gestion_data = {};
                $scope.title_left = "Actualizar";
                var $row_data_info = searchElementJson(instance_data_rows.currentRows, 'id', data_row_id);//asi s obtiene los valores del registro en funcion d su id
                $scope.gestion_data = $row_data_info[0];
                var key_data_name = "change_url";
                $scope.gestion_data[key_data_name] = "false"
                $scope.gestion_data["url_imagen_categoria"] = $scope.gestion_data["url_imagen_categoria"];
                if (!$scope.initUpload) {
                    $scope.initLoadEventsUpload();
                    $scope.initUpload = true;
                }
                $scope.setImagePreview($scope.gestion_data["url_imagen_categoria"]);


                $scope.viewData(2);
                break;
            case "view_entidad"://bton actualizar proyectos
                var instance_data_rows = getDataInstanciaBootgrid($($scope.bootgrid_main));
                var data_row_id = $(entidad_gestion).data("row-id");//
                var $row_data_info = searchElementJson(instance_data_rows.currentRows, 'id', data_row_id);//asi s obtiene los valores del registro en funcion d su id
                $scope.data_entidad_view = $row_data_info[0];
                /*  $scope.initDataProyectos();*/
                $scope.viewData(3);
                break;
        }
    }
}