var select_dealer = null;
var dataTableProducts = null;
var dataTableAssignedProducts = null;
var selectedProducts = [];
var selectedAssigned = [];
$(function () {

    dataTableAssignedProducts = initDatableAjax($('#assigned_products'), {
        ajax: {
            url: $('#action_load_products').val(),
            method: 'GET',
            params: {
                assigned: 1,
                dealer_id: 0
            }
        },
        pageSize: 10,
        columns: [{
            field: "id",
            title: "#",
            sortable: false,
            width: 40,
            selector: {class: 'm-checkbox--solid m-checkbox--brand'}
        }, {
            field: 'name',
            title: 'Nombre',
            sortable: 'asc',
            filterable: false,
            width: 150
        }, {
            field: 'category',
            title: 'Categoria',
            sortable: 'asc',
            filterable: false,
            width: 150
        }]
    });

    dataTableProducts = initDatableAjax($('#products'), {
        ajax: {
            url: $('#action_load_products').val(),
            method: 'GET',
            params: {
                assigned: 0,
                dealer_id: 0
            }
        },
        pageSize: 10,
        columns: [{
            field: "id",
            title: "#",
            sortable: false,
            width: 40,
            selector: {class: 'm-checkbox--solid m-checkbox--brand'}
        }, {
            field: 'name',
            title: 'Nombre',
            sortable: 'asc',
            filterable: false,
            width: 150
        }, {
            field: 'category',
            title: 'Categoria',
            sortable: 'asc',
            filterable: false,
            width: 150
        }]
    });

    select_dealer = initSelect2($('#select_dealer'), {
        ajax: {
            url: $('#action_load_dealers_select2').val(),
            dataType: 'json',
        },
    });

    select_dealer.on('change', function () {
        if (select_dealer.val() != null) {
            selectedProducts = [];
            selectedAssigned = [];

            var query = dataTableProducts.getDataSourceQuery();
            query.dealer_id = $(this).val();
            dataTableProducts.setDataSourceQuery(query);
            dataTableProducts.reload();

            var queryAssigned = dataTableAssignedProducts.getDataSourceQuery();
            queryAssigned.dealer_id = $(this).val();
            dataTableAssignedProducts.setDataSourceQuery(queryAssigned);
            dataTableAssignedProducts.reload();
            $('#products_list').show();
        }
        else {
            $('#products_list').hide();
        }
    });

    dataTableProducts.on('m-datatable--on-check', function (event, args) {
        selectedProducts = $.merge(selectedProducts, args);
        $.unique(selectedProducts);
    }).on('m-datatable--on-uncheck', function (event, args) {
        $.each(args, function (element, val) {
            selectedProducts = $.grep(selectedProducts, function (value) {
                return value != val;
            })
        })
    }).on('m-datatable--on-layout-updated', function (event, args) {
        $.each(selectedProducts, function (element, val) {
            dataTableProducts.setActive(val);
        })
    });

    dataTableAssignedProducts.on('m-datatable--on-check', function (event, args) {
        selectedAssigned = $.merge(selectedAssigned, args);
        $.unique(selectedAssigned);
    }).on('m-datatable--on-uncheck', function (event, args) {
        $.each(args, function (element, val) {
            selectedAssigned = $.grep(selectedAssigned, function (value) {
                return value != val;
            })
        })
    }).on('m-datatable--on-layout-updated', function (event, args) {
        $.each(selectedAssigned, function (element, val) {
            dataTableAssignedProducts.setActive(val);
        })
    });
});

function saveProductsByDealer(assign) {
    ajaxRequest($('#action_save_productsByDealer').val(), {
        type: 'POST',
        data: {
            assign: assign,
            dealer_id: select_dealer.val(),
            selected: (assign ? selectedProducts : selectedAssigned)
        },
        blockElement: 'body',//opcional: es para bloquear el elemento
        loading_message: 'Guardando...',
        error_message: 'Ha ocurrido un error',
        success_message: 'Productos asignados correctamente',
        success_callback: function (data) {
            if (data.success) {
                selectedAssigned = [];
                selectedProducts = [];
                dataTableAssignedProducts.reload();
                dataTableProducts.reload();
            }
        }
    });
}
