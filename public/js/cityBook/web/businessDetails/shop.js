var footerGrid =
    "<div id='data-pagination'  id=\"{{ctx.id}}\" class=\"{{css.footer}}\">\n\
            <div class='col-md-6'>\n\
                <div  class='pagination'>\n\
                    <p class=\"{{css.pagination}}\"></p>\n\
                </div>\n\
            </div>\n\
            <div class=\"col-md-6\">\n\
                <p class=\"{{css.infos}}\"></p>\n\
            </div>\n\
</div>";
function GridManager(params) {
    var gridNameSelector = params['gridNameSelector'];
    let gridInit = $(gridNameSelector);

    let method = params.hasOwnProperty("ajaxSettings").hasOwnProperty('method') ? params['ajaxSettings']['method'] : "POST";
    let urlCurrent = params['urlCurrent'];
    //labels
    let loadingHtml = params.hasOwnProperty("labels").hasOwnProperty('loading') ? params['labels']['loading'] : "Cargando...";
    let noResultsHtml = params.hasOwnProperty("labels").hasOwnProperty('noResults') ? params['labels']['noResults'] : "Sin Resultados!";
    let infosHtml = params.hasOwnProperty("labels").hasOwnProperty('infos') ? params['labels']['infos'] : 'Mostrando {{ctx.start}} - {{ctx.end}} de {{ctx.total}} resultados';
//css
    let headerCSS = params.hasOwnProperty("css").hasOwnProperty('header') ? params['css']['header'] : "bootgrid-header";
    let tableCSS = params.hasOwnProperty("css").hasOwnProperty('table') ? params['css']['table'] : "xywer-tbl-admin";
    let formattersCurrent = params.hasOwnProperty("formatters") ? params['formatters'] : {
        'default': function (column, row) {
            console.log(row);
        }
    };

    var templates = {
        footer: footerGrid
    };


    gridInit.bootgrid({
        ajaxSettings: {
            method: method
        },
        ajax: true,
        requestHandler: function (request) {
            request.filters = getFilters();
            return request;
        },
        url: urlCurrent,
        labels: {
            loading: loadingHtml,
            noResults: noResultsHtml,
            infos: infosHtml
        },
        css: {
            header: headerCSS,
            table: tableCSS,
            footer: 'pagination-wrapper'
        },
        templates: templates,
        formatters: formattersCurrent
    });

    return gridInit;


}
