@extends('layouts.managementProcess.index') {{-- o el layout que uses --}}
@section('content')
    <div class="container">
        <h1 class="mb-4">{{isset($business["COMP_NOMBRE"])?$business["COMP_NOMBRE"]:"No hay"}}
            /{{isset($business["COMP_RNC"])?$business["COMP_RNC"]:"NO AY"}}</h1>
        <h2 class="mb-4">Listado de Productos</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Código</th>
                    <th>Acciones</th>

                </tr>
                </thead>
                <tbody>
                @forelse ($dataProducts as $item)
                    <tr>
                        <td>{{ $item["PROD_ID"] }}</td>
                        <td>{{ $item['PROD_NOMBRE'] }}</td>
                        <td>${{ number_format($item['PROD_PRECIO'], 2) }}</td>
                        <td>{{ $item["PRBA_CODIGO"] }}</td>

                        <td class="text-center">
                            <button data-producto='@json($item)' id="{{ $item["PROD_ID"] }}-send"
                                    class="btn btn-sm btn-outline-primary me-1 row-manager-send"
                                    title="Enviar Servidor">
                                <i class="bi bi-send-exclamation-fill"></i>
                            </button>
                            <button id="{{ $item["PROD_ID"] }}-edit"
                                    class="btn btn-sm btn-outline-warning row-manager-edit" title="Editar">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No hay productos disponibles.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>


        <div class="table-responsive">
            <table id="grid-products-manager" class="table table-bordered table-hover">
                <thead class="table-dark">
                <tr>
                    <th data-column-id="description" data-formatter="description">Descripcion</th>
                    <th data-column-id="commands" data-formatter="commands" data-sortable="false">Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="table-responsive">
            <table id="grid-products-add" class="table table-bordered table-hover">
                <thead class="table-dark">
                <tr>
                    <th data-column-id="PROD_ID" data-type="numeric" data-identifier="true">#</th>
                    <th data-column-id="COMP_NOMBRE">Empresa</th>
                    <th data-column-id="description" data-formatter="description">Descripcion</th>
                    <th data-column-id="PROD_PRECIO" data-formatter="price">Precio</th>
                    <th data-column-id="PRBA_CODIGO">Código</th>
                    <th data-column-id="commands" data-formatter="commands" data-sortable="false">Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <style>

        /* Wrapper scroll vertical */
        .c-table-wrapper {
            max-height: 400px; /* puedes ajustar */
            overflow-y: auto;
            overflow-x: auto;
            position: relative;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }

        /* Tabla general */
        .c-table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Cabecera fija */
        .c-table thead th {
            position: sticky;
            top: 0;
            z-index: 20;
            background-color: #f8f9fa; /* coherente con Bootstrap .table-light */
            color: #212529;
            font-weight: 600;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
            box-shadow: inset 0 -1px 0 #dee2e6;
        }

        /* Filas alternadas para UX */
        .c-table tbody tr:nth-child(odd) {
            background-color: #fcfcfc;
        }

        .c-table tbody tr:nth-child(even) {
            background-color: #f3f3f3;
        }

        /* Hover UX */
        .c-table tbody tr:hover {
            background-color: #e2e6ea;
            transition: background-color 0.2s ease-in-out;
        }

        th {
            background-color: #f2f2f2;
        }

        tr.equals-values-mayor {
            background: #c4760d;
        }

        .product-data__section {
            margin-bottom: 1.5rem;
        }

        .product-data__section-title {
            font-size: 16px;
            font-weight: bold;
            color: #243aab;
            margin-bottom: 0.75rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 0.3rem;
        }

        .product-data {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: #fff;
            max-width: 100%;
        }

        .product-data__row {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
        }

        .product-data__label {
            width: 150px;
            font-weight: bold;
            color: #333;
        }

        .product-data__value {
            flex: 1;
            color: #555;
        }

    </style>


    @section('additional-scripts')
        <script>

            function openEditProductModal(productData) {
                $("#formProductEdit__prod-id").val(productData.PROD_ID);
                $("#formProductEdit__prod-nombre").val(productData.PROD_NOMBRE);
                $("#formProductEdit__prod-precio").val(productData.PROD_PRECIO);
                $("#formProductEdit__prod-codigo").val(productData.PRBA_CODIGO);
                $("#modalProductEdit").modal("show");
            }

            function getEditProductFormData() {
                return {
                    id: $("#formProductEdit__prod-id").val(),
                    nombre: $("#formProductEdit__prod-nombre").val(),
                    precio: $("#formProductEdit__prod-precio").val(),
                    codigo: $("#formProductEdit__prod-codigo").val(),
                    comentario: $("#formProductEdit__prod-comentario").val(),

                };
            }

            function submitEditProductForm(data) {
                console.log("📦 Datos a enviar:", data);

                // Aquí puedes hacer el POST si deseas
                /*
                $.post('/ruta/actualizar-producto', data)
                  .done(function(response) {
                    alert('✅ Producto actualizado correctamente');
                    $("#modalProductEdit").modal("hide");
                  })
                  .fail(function(error) {
                    console.error('❌ Error:', error);
                  });
                */

                updateComentarioProducto({
                    product: data
                })
                $("#modalProductEdit").modal("hide");
            }

            /**
             * Inicializa los eventos del modal de edición
             */
            function initEditProductModalEvents() {
                // Botón guardar
                $("#btnProductEditSave").on("click", function () {
                    const data = getEditProductFormData();
                    submitEditProductForm(data);
                });

                // Botón editar en cada fila
                $(".row-manager-edit").on("click", function () {
                    const rowData = $(this).siblings(".row-manager-send").data("producto");
                    openEditProductModal(rowData);
                });
            }

            function initDataGrid() {
                $('#grid-products-manager').bootgrid({
                    ajax: true,
                    url: '{{ route("productsManager") }}',
                    method: 'POST',
                    post: function () {
                        return {
                            _token: '{{ csrf_token() }}'
                        };
                    },
                    formatters: {
                        'description': function (column, row) {
                            let productInformation = ['  <div class="product-data__section">',
                                '     <div class="product-data__section-title">General</div>',
                                '     <div class="product-data__row">',
                                '          <div class="product-data__label"> Nombre Producto:',
                                '           </div>',
                                '          <div class="product-data__value"> ' + row.PROD_NOMBRE,
                                '          </div>',
                                '     </div>',
                                '     <div class="product-data__row">',
                                '       <div class="product-data__label"> Comentario:',
                                '        </div>',
                                '        <div class="product-data__value"> ' + row.PROD_COMENTARIO,
                                '        </div>',
                                '     </div>',
                                '    <div class="product-data__row">',
                                '       <div class="product-data__label"> Precio:',
                                '        </div>',
                                '        <div class="product-data__value"> ' + row.PROD_PRECIO,
                                '        </div>',
                                '   </div>',
                                '   <div class="product-data__row">',
                                '       <div class="product-data__label"> Código:',
                                '       </div>',
                                '        <div class="product-data__value"> ' + row.PROD_ID,
                                '        </div>',
                                '    </div>',
                                '  </div>'];

                            let productExistencia = ['  <div class="product-data__section">',
                                '     <div class="product-data__section-title">Existencia</div>',
                                '     <div class="product-data__row">',
                                '          <div class="product-data__label"> Existencia:',
                                '           </div>',
                                '          <div class="product-data__value"> ' + row.PROD_EXISTENCIA,
                                '          </div>',
                                '     </div>',


                                '  </div>'];

                            let codecsBody = [];
                            $.each(row.codecs, function (key, value) {
                                let setPush = [
                                    '     <div class="product-data__row">',
                                    '          <div class="product-data__label"> Código:',
                                    '           </div>',
                                    '          <div class="product-data__value"> ' + value.PRBA_CODIGO,
                                    '          </div>',
                                    '     </div>',
                                ];
                                codecsBody.push(setPush.join(""));
                            });
                            let codecsHtml = codecsBody.length > 0 ? [
                                '  <div class="product-data__section">',
                                '     <div class="product-data__section-title">Códigos Alternos</div>',
                                codecsBody.join(""),
                                '  </div>',

                            ] : [];

                            let historicBody = [];
                            $.each(row.historic, function (key, value) {
                                let setPush = [
                                    '     <div class="product-data__row">',
                                    '          <div class="product-data__label"> Fecha:',
                                    '           </div>',
                                    '          <div class="product-data__value"> ' + value.HIST_FECHA,
                                    '          </div>',
                                    '     </div>',
                                    '     <div class="product-data__row">',
                                    '          <div class="product-data__label"> Lista Precio:',
                                    '           </div>',
                                    '          <div class="product-data__value"> ' + value.LIST_PRECIO,
                                    '          </div>',
                                    '     </div>',
                                    '     <div class="product-data__row">',
                                    '          <div class="product-data__label">Precio:',
                                    '           </div>',
                                    '          <div class="product-data__value"> ' + value.PROD_PRECIO,
                                    '          </div>',
                                    '     </div>',
                                ];
                                historicBody.push(setPush.join(""));
                            });
                            let historicHtml = historicBody.length > 0 ? [
                                '  <div class="product-data__section">',
                                '     <div class="product-data__section-title">Historico de Precios</div>',
                                historicBody.join(""),
                                '  </div>',

                            ] : [];
                            let result = [
                                '<div class="product-data">',
                                productInformation.join(""),
                                productExistencia.join(""),
                                codecsHtml.join(""),
                                historicHtml.join(""),

                                '</div>',

                            ];
                            return result.join("");
                        }

                    }
                });
                $('#grid-products-add').bootgrid({
                    ajax: true,
                    url: '{{ route("getDataViewAdminRegisters") }}',
                    method: 'POST',
                    post: function () {
                        return {
                            _token: '{{ csrf_token() }}'
                        };
                    },
                    formatters: {
                        // Opcional: si necesitas columnas con botones
                    }
                });
                initEditProductModalEvents();
            }

            const $business = @json($business); // $productos debe ser un array de PHP

            function sendData(params) {
                let {product} = params;
                let dataSend = {
                    "product": product,
                    "business": $business,
                    _token: '{{ csrf_token() }}'
                };
                $.ajax({
                    url: "https://meetclic.com/data/sendDataViewFrontendWeb",
                    type: "POST",
                    data: JSON.stringify(dataSend), // 👈 convertir a JSON string
                    contentType: "application/json", // 👈 importante para que Laravel lo reciba como JSON
                    success: function (response) {

                        console.log(response);
                    },
                    error: function (xhr) {
                        console.error("❌ Error en el envío:", xhr.responseJSON);

                    }
                });
            }

            function updateComentarioProducto(params) {
                let {product} = params;
                let dataSend = {
                    "product": product,
                    "business": $business,
                    _token: '{{ csrf_token() }}'
                };
                $.ajax({
                    url: '{{ route("updateComentarioProducto") }}',
                    type: "POST",
                    data: JSON.stringify(dataSend), // 👈 convertir a JSON string
                    contentType: "application/json", // 👈 importante para que Laravel lo reciba como JSON
                    success: function (response) {

                        console.log(response);
                    },
                    error: function (xhr) {
                        console.error("❌ Error en el envío:", xhr.responseJSON);

                    }
                });
            }

            $(function () {
                $(".row-manager-send").on("click", function () {
                    let rowCurrent = $(this).attr("data-producto");
                    const product = JSON.parse(rowCurrent);
                    console.log("data-producto", product)
                    sendData({product: rowCurrent});
                });
                initDataGrid();
            });
        </script>
    @endsection
@endsection
<!-- Modal de Edición -->
<!-- Modal para editar producto -->
<div class="modal fade modal-product-edit" id="modalProductEdit" tabindex="-1" role="dialog"
     aria-labelledby="modalProductEdit__title">
    <div class="modal-dialog modal-product-edit__dialog" role="document">
        <div class="modal-content modal-product-edit__content">
            <div class="modal-header modal-product-edit__header">
                <button type="button" class="close modal-product-edit__close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title modal-product-edit__title" id="modalProductEdit__title">Editar Producto</h4>
            </div>

            <div class="modal-body modal-product-edit__body">
                <form id="formProductEdit" class="modal-product-edit__form">
                    <input type="hidden" id="formProductEdit__prod-id">

                    <div class="form-group modal-product-edit__field">
                        <label for="formProductEdit__prod-nombre" class="modal-product-edit__label">Nombre</label>
                        <input type="text" class="form-control modal-product-edit__input"
                               id="formProductEdit__prod-nombre">
                    </div>

                    <div class="form-group modal-product-edit__field">
                        <label for="formProductEdit__prod-precio" class="modal-product-edit__label">Precio</label>
                        <input type="number" step="0.01" class="form-control modal-product-edit__input"
                               id="formProductEdit__prod-precio">
                    </div>

                    <div class="form-group modal-product-edit__field">
                        <label for="formProductEdit__prod-codigo" class="modal-product-edit__label">Código</label>
                        <input type="text" class="form-control modal-product-edit__input"
                               id="formProductEdit__prod-codigo">
                    </div>
                    <div class="form-group modal-product-edit__field">
                        <label for="formProductEdit__prod-comentario"
                               class="modal-product-edit__label">Comentario</label>
                        <textarea
                            id="formProductEdit__prod-comentario"
                            class="form-control modal-product-edit__textarea modal-product-edit__input"
                            rows="3"
                            placeholder="Ingrese un comentario..."></textarea>
                    </div>
                </form>
            </div>

            <div class="modal-footer modal-product-edit__footer">
                <button type="button" class="btn btn-default modal-product-edit__cancel" data-dismiss="modal">Cancelar
                </button>
                <button type="button" class="btn btn-primary modal-product-edit__save" id="btnProductEditSave">Guardar
                </button>
            </div>
        </div>
    </div>
</div>

