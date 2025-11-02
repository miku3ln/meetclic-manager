@extends('layouts.managementProcess.index') {{-- o el layout que uses --}}
@section('content')
    <div class="container">
        <h2>Subir Documentos Electrónicos</h2>

        <form method="POST" id="uploadForm">
            @csrf

            <div class="form-group">
                <label for="facturas">Archivo de Facturas Mensuales (.txt):</label>
                <input type="file" class="form-control" name="facturas" id="facturas"  accept=".txt"  required>
            </div>


            <div class="form-group">
                <label for="retenciones">Archivo de Retenciones Mensuales (.xml):</label>
                <input type="file" class="form-control" name="retenciones[]" id="retenciones" accept=".xml" multiple required>
            </div>
            <button type="button" id="submitBtn" class="btn btn-primary" disabled>Enviar</button>
        </form>

        <div class="view-result">

        </div>
    </div>

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

    </style>
    <script>
        const facturasInput = document.getElementById('facturas');
        const retencionesInput = document.getElementById('retenciones');
        const submitBtn = document.getElementById('submitBtn');

        function checkInputs() {
            const hasFactura = facturasInput.files.length > 0;
            const hasRetenciones = retencionesInput.files.length > 0;

            submitBtn.disabled = !(hasFactura && hasRetenciones);
        }

        facturasInput.addEventListener('change', checkInputs);
        retencionesInput.addEventListener('change', checkInputs);
    </script>

    <script>
        $('#submitBtn').on('click', function (e) {
            e.preventDefault();

            const form = $('#uploadForm')[0];
            const formData = new FormData(form);

            $.ajax({
                url: "{{ route('generateInformationElectronic',app()->getLocale()) }}",
                type: "POST",
                data: formData,
                processData: false, // evita que jQuery procese el FormData
                contentType: false, // evita que jQuery configure el content-type incorrectamente
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log("✅ Archivos enviados correctamente:", response);


                    if (response.success) {
                        var dataCurrent = response.data;
                        var html = dataCurrent.html;
                        $(".view-result").html(html.join(""))
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr) {
                    console.error("❌ Error en el envío:", xhr.responseJSON);
                    alert(xhr.responseJSON.message || 'Error al subir archivos.');
                }
            });
        });
    </script>
@endsection
