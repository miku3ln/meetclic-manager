/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function initGridEntidad(params, scope) {
//    CONFIGURACION DEL BOOTGRID
//http://www.jquery-bootgrid.com/
    var params_init = params;
    var element = params_init.element;//puede ser id/clase
    var gridId = $(element);//elemento cual vamos a inicializar el grid

    //DEPENDE D LA FUNCION Q REALIZAMOS EN L SERVER...
    var method = issetMeet(params_init, "method") ? params_init.method : "POST";
    var init_ajax = issetMeet(params_init, "init_ajax") ? params_init.init_ajax : false;//para obtener valores desde alguna accion
    var filters = issetMeet(params_init, "filters") ? params_init.filters : {};
    var url_get_data = issetMeet(params_init, "url_get_data") ? params_init.url_get_data : "";
//    ----labels--
    var loading = issetMeet(params_init, "loading") ? params_init.loading : "<div id='div-loading'>Cargando...</div>";
    var noResults = issetMeet(params_init, "noResults") ? params_init.noResults : "<div class='empty-data'>Sin Resultados!</div>";
    var infos = issetMeet(params_init, "infos") ? params_init.infos : "Mostrando {{ctx.start}} - {{ctx.end}} de {{ctx.total}} resultados";
//  ----------- css
    var header = issetMeet(params_init, "header") ? params_init.header : "bootgrid-header";
    var table = issetMeet(params_init, "table") ? params_init.table : "xywer-tbl-admin";

//        ----INICIALIZAR EMPTY DATA--
    var params_empty = issetMeet(params, "empty") ? params : {
        title: "Información",
        subtitle: "No existe resultados",
        icon: "fa fa-info"
    };

    var function_init = issetMeet(params, "function") ? params.function : null;
    var labels_objeto = {
        loading: loading,
        noResults: noResults,
        infos: infos
        ,
        search: "Buscar",
    };
    var css_objecto = {
        header: header,
        table: table
    };
//    ---FORMATTER--
    var btn_personalizado_object_data = issetMeet(params_init, "btn_personalizado_object_data") ? params_init.btn_personalizado_object_data : {};
//---------------------------LOS COMANDS X DEFECTO YA DEBEN O COMO NO DEBEN EXISTIR PARA LA GESTION----------
    var commands_default = {
        'commands': function (column, row) {
            $commands_btns = "";
            var $entidad_row_id = row.id;
            var entidad_grid = "";
            $.each(btn_personalizado_object_data, function (key_a, value_a_options) {
                var entidad_gestion = key_a;
                var entidad_tipo = "";
                var $class_a = "";
                var $datatoogle_a = "";
                var $dataplacement_a = "";
                var $title_a = "";
                var $btn_class = "";
                var $i_class = "";
                var $url = "#";
                var $url_action = "";
                var $ng_click = "";
                var $ng_model = "";
                var $gestion = "";
                var $url_action_active = false;
                var $modal_type = "lg";
                $.each(value_a_options, function (key_a_option, value_a) {
                    switch (key_a_option) {
                        case "command-class":
                            $class_a = value_a;
                            break;
                        case "action":
                            $url_action_active = value_a;
                            break;
                        case "data-toggle":
                            $datatoogle_a = value_a;
                            break;
                        case "data-placement":
                            $dataplacement_a = value_a;
                            break;
                        case "title":
                            $title_a = value_a;
                            break;
                        case "button-class":
                            $btn_class = value_a;
                            break;
                        case "i-class":
                            $i_class = value_a;
                            break;
                        case "url":
                            $url = value_a;
                            break;
                        case "entidad_tipo":
                            $entidad_tipo = value_a;
                            break;
                        case "modal_type":
                            $modal_type = value_a;
                            break;
                        case "ng-click":
                            $ng_click = value_a;
                            break;
                        case "ng-model":
                            $ng_model = value_a;
                            break;
                        case "gestion":
                            $gestion = value_a;
                            break;


                    }

                });
                //para redirigir a otra pagina
                var $href = "";
                if ($url_action_active == "true") {
                    $href = "href='" + baseUrl + $url + "/entidad_id/" + row.id + "'";
                }
                $commands_btns += ' <a  gestion="' + $gestion + '"   ng-model="' + $ng_model + '"  ng-click="' + $ng_click + '" row-id="' + $entidad_row_id + ' "  modal_type =' + $modal_type + '  ' + $href + ' entidad_tipo="' + $entidad_tipo + '" url="' + $url + '"  entidad="' + entidad_grid + '"  class="' + $class_a + '"  data-toggle="' + $datatoogle_a + '"  data-placement="' + $dataplacement_a + '" title="' + $title_a + '" data-row-id="' + $entidad_row_id + '"><i class="' + $i_class + '"></i></a>';
            });
            return $commands_btns;
        }
    };

    var formatters = {};
    formatters = commands_default;
//    ---esto es para poder realizar manipulacion de cada row por cada columna darle estilos y diseños
    var object_formater_columns = issetMeet(params_init, "object_formater") ? params_init.object_formater : {};
//    ----Solo si existe por lo menos uno agregar----
    if (Object.keys(object_formater_columns).length > 0) {
        formatters = $.extend(commands_default, object_formater_columns);
    }
    var footer_bst2 =
        "<div id='data-pagination' alex='ada' id=\"{{ctx.id}}\" class=\"{{css.footer}}\">\n\
                    <div>\n\
                        <div class='col-sm-6'>\n\
                            <div  class='pagination'>\n\
                                <p class=\"{{css.pagination}}\"></p>\n\
                            </div>\n\
                        </div>\n\
                        <div class=\"col-sm-6\">\n\
                            <p class=\"{{css.infos}}\"></p>\n\
                        </div>\n\
                    </div>\n\
                </div>";
    var templates_objeto = {
        footer: footer_bst2
    };
    //    -----Options----
//permite para la seleccion de los objetos d cada fila---
    var selection = issetMeet(params_init, "selection") ? params_init.selection : false;
    var multiSelect = issetMeet(params_init, "multiSelect") ? params_init.multiSelect : false;
    var keepSelection = issetMeet(params_init, "keepSelection") ? params_init.keepSelection : false;
    var rowSelect = issetMeet(params_init, "rowSelect") ? params_init.rowSelect : false;
    var rowCount = issetMeet(params_init, "rowCount") ? params_init.rowCount : 10;
    var init_gestion = {
//        rowCount: rowCount,
        selection: selection,
        multiSelect: multiSelect,
        keepSelection: keepSelection,
        rowSelect: rowSelect,
        labels: labels_objeto,
        css: css_objecto,
        templates: templates_objeto,
        formatters: formatters,
    };
    $search_params = {
        grid_id: element,
        filters: filters
    };
    if (init_ajax) {//si envian parametros para inicializar desde ajax agregamos las posiciones
        init_gestion["url"] = baseUrl + url_get_data;
        init_gestion["post"] = function () {
            return $search_params;
        };
        init_gestion["ajaxSettings"] = {
            method: method

        };
        init_gestion["ajax"] = true;

    } else {
        templates_objeto["footer"] = "";
    }
//    -------INICIA EL BOOTGRID---
    gridId.bootgrid(init_gestion).on("loaded.rs.jquery.bootgrid", function () {//AQUI CAPTURAMOS LOS EVENTOS DEL BOOTGRID
        $('[data-column-id="commands"]').css('width', '350px');
        scope.verificar_eventos = "loaded.rs.jquery.bootgrid";
        var params_empty_add = {
            title: params_empty.title,
            subtitle: params_empty.subtitle,
            icon: params_empty.icon,
            element: params.element
        };
        addRowEmpty(params_empty_add);
        setIconsPagination();//ico
        $('[data-toggle="tooltip"]').tooltip();
        gridId.find(".manager-invoice").on("click", function (event) {//cuando son columnas personalizadas
            event.stopPropagation();
            self = $(this);
            var instance_data_rows = getDataInstanciaBootgrid(gridId);
            var data_row_id = self.attr("row-id");
            var $row_data_info = searchElementJson(instance_data_rows.currentRows, 'id', data_row_id);//asi s obtiene los valores del registro en funcion d su id
            scope._managerInvoice({
                row: $row_data_info[0],
                id: data_row_id
            });
        }).end().find("tbody tr").on("click", function (e) {

            self = $(this);
            data_row_id = $(self[0]).attr("data-row-id");
            $("#check-" + data_row_id).click();

        })

        ;//aqi s aplica jquery
//      --------------PODEMOS AGREGAR VARIOS EVENTOS O VARIAS CLASES PARA PODER UTILIZARLES LUEGO ---

        if (function_init) {//estos metodos s ocacionan cuando s envia ejecutarse luego de inicializar
            var perrins_params = {id: "perro", gato: "adad", grid_obj: gridId};
            function_init.call(perrins_params);
        }
    }).on("selected.rs.jquery.bootgrid", function (e, rows) {
        var rowIds = [];
        for (var i = 0; i < rows.length; i++) {
            rowIds.push(rows[i].id);
        }
        console.log("selected");

    }).on("deselected.rs.jquery.bootgrid", function (e, rows) {

        var rowIds = [];
        for (var i = 0; i < rows.length; i++) {
            rowIds.push(rows[i].id);
        }
    });


}

//---METODO EN L CUAL VERIFICA SI EXISTE UNA POSICION DENTRO DE UN ARRAY
function issetMeet(array_objeto, key_objeto) {

    var isset_result = false;//no existe posicion
    if (key_objeto in array_objeto) {
        isset_result = true;
        return isset_result;
    }
    return isset_result;
}
