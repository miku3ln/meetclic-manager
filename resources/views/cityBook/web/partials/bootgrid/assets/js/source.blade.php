
<script id="manager-bootgrid">

    function getFilters() {
        $paramsRequest.hasOwnProperty('categoryId')
        var result = {
            business_id: 1,
            category: $('#category').val() ? $('#category').val() : -1,
            subcategory: $('#subcategory').val() ? $('#subcategory').val() : -1,
            'language': $language
        };

        return result;
    }
    function initFilters(){
        var allowFilters = false;
        if ($paramsRequest.hasOwnProperty('categoryId') && $paramsRequest.categoryId != '-1') {
            $('#category').val($paramsRequest.categoryId);
            allowFilters = true;

        }
        if ($paramsRequest.hasOwnProperty('subCategoryId') && $paramsRequest.subCategoryId != '-1') {
            allowFilters = true;
            $('#subcategory').val($paramsRequest.subCategoryId);
        }
        if (allowFilters) {

            if ($('.content-filter').hasClass('not-view')) {

                $('.content-filter').removeClass('not-view');
            }
        }
    }
    function GridManager(params) {
        initFilters();
        var gridNameSelector = params['gridNameSelector'];
        let gridInit = $(gridNameSelector);

        let method = params.hasOwnProperty("ajaxSettings").hasOwnProperty('method') ? params['ajaxSettings']['method'] : "POST";
        let urlCurrent = params['urlCurrent'];
        //labels
        let loadingHtml = params.hasOwnProperty("labels").hasOwnProperty('loading') ? params['labels']['loading'] : "{{__('gamification.loading')}}...";
        let noResultsHtml = params.hasOwnProperty("labels").hasOwnProperty('noResults') ? params['labels']['noResults'] : "{{__('gamification.no_results')}}!";
        let infosHtml =
            (params.labels && params.labels.infos)
                ? params.labels.infos
                : "{{__('gamification.showing')}} <?php ' {{ctx.start}} - {{ctx.end}} de {{ctx.total}} '?> {{__('gamification.results')}}";//css
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
                footer: 'bootgrid-footer container-fluid'
            },
            templates: templates,
            formatters: formattersCurrent
        });

        return gridInit;


    }
</script>
