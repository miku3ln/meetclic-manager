@extends('layouts.bootstrap5')
@section('additional-scripts')
    <script>

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
        }
    </script>
@endsection
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">

                <table id="grid-products-manager" class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th data-column-id="description" data-formatter="description">Descripcion</th>
                        <th data-column-id="commands" data-formatter="commands" data-sortable="false">Acciones</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <h2 class="mb-4">Ejemplos Completos de Bootstrap 5</h2>

        <!-- Botón -->
        <h4>Botón</h4>
        <button type="button" class="btn btn-primary mb-3">Botón Primario</button>

        <!-- Alerta -->
        <h4>Alerta</h4>
        <div class="alert alert-success mb-3" role="alert">
            ¡Operación exitosa!
        </div>

        <!-- Tabla -->
        <h4>Tabla</h4>
        <table class="table table-bordered table-striped mb-3">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Alex</td>
                <td>alex@example.com</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Maria</td>
                <td>maria@example.com</td>
            </tr>
            </tbody>
        </table>

        <!-- Formulario -->
        <h4>Formulario</h4>
        <form>
            <div class="mb-3">
                <label for="exampleInputEmail" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="exampleInputEmail" placeholder="correo@ejemplo.com">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="exampleInputPassword" placeholder="Contraseña">
            </div>
            <button type="submit" class="btn btn-success">Enviar</button>
        </form>

        <!-- Tarjeta -->
        <h4 class="mt-5">Tarjeta</h4>
        <div class="card mb-3" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Título de la tarjeta</h5>
                <p class="card-text">Este es un ejemplo simple de tarjeta usando Bootstrap 5.</p>
                <a href="#" class="btn btn-primary">Ir a algún lugar</a>
            </div>
        </div>

        <!-- Modal -->
        <h4 class="mt-5">Modal</h4>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Abrir Modal
        </button>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Título del Modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        Este es el cuerpo del modal.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
