@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
    $sourcesRoot = $resourcePathServer . 'frontend/businessOwner/mikuy-yachak';
@endphp
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
    <div class="container--custom">

        <img src="{{URL::asset($sourcesRoot."/infogram.png")}}" class="img-fluid" alt="...">


    </div>
@endsection
