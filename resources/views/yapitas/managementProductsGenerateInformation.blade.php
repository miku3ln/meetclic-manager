@extends('layouts.managementProcess.index')

@section('content')

    <div class="upload-process">

        {{-- OVERLAY --}}
        <div
            class="upload-process__overlay not-view"
            id="processOverlay"
        >

            <div class="upload-process__loader-box">

                <div class="upload-process__spinner"></div>

                <div class="upload-process__message">
                    Procesando información...
                </div>

                <div class="upload-process__submessage">
                    Por favor espere un momento
                </div>

            </div>

        </div>

        <div class="container">

            <h2 class="upload-process__title">
                Subir Documentos Electrónicos
            </h2>

            <form method="POST" id="uploadForm">

                @csrf

                <div class="form-group">

                    <label for="products">
                        Archivo de Facturas Mensuales
                    </label>

                    <input
                        type="file"
                        class="form-control"
                        name="products-files"
                        id="products"
                        accept=".xlsx,.xls,.csv,.ods"
                        required
                    >

                </div>

                <button
                    type="button"
                    id="submitBtn"
                    class="btn btn-primary"
                    disabled
                >
                    Enviar
                </button>

            </form>

            <div class="view-result"></div>

        </div>

    </div>

    <style>

        /*
        |--------------------------------------------------------------------------
        | HELPERS
        |--------------------------------------------------------------------------
        */

        .not-view {
            display: none !important;
        }

        /*
        |--------------------------------------------------------------------------
        | BLOCK
        |--------------------------------------------------------------------------
        */

        .upload-process {

            position: relative;

            min-height: 500px;
        }

        /*
        |--------------------------------------------------------------------------
        | OVERLAY
        |--------------------------------------------------------------------------
        */

        .upload-process__overlay {

            position: absolute;

            inset: 0;

            z-index: 9999;

            display: flex;

            align-items: center;

            justify-content: center;

            background: rgba(255,255,255,0.85);

            backdrop-filter: blur(3px);
        }

        /*
        |--------------------------------------------------------------------------
        | LOADER BOX
        |--------------------------------------------------------------------------
        */

        .upload-process__loader-box {

            width: 320px;

            padding: 30px;

            border-radius: 18px;

            background: #ffffff;

            box-shadow:
                0 10px 40px rgba(0,0,0,0.12);

            text-align: center;
        }

        /*
        |--------------------------------------------------------------------------
        | SPINNER
        |--------------------------------------------------------------------------
        */

        .upload-process__spinner {

            width: 60px;

            height: 60px;

            margin: 0 auto 20px auto;

            border-radius: 50%;

            border: 5px solid #e5e5e5;

            border-top-color: #0d6efd;

            animation:
                upload-process-spin 1s linear infinite;
        }

        @keyframes upload-process-spin {

            to {

                transform: rotate(360deg);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | TEXTS
        |--------------------------------------------------------------------------
        */

        .upload-process__message {

            font-size: 18px;

            font-weight: 600;

            color: #222;

            margin-bottom: 8px;
        }

        .upload-process__submessage {

            font-size: 14px;

            color: #777;
        }

    </style>

    <script>

        /*
        |--------------------------------------------------------------------------
        | ELEMENTS
        |--------------------------------------------------------------------------
        */

        const productsInput =
            document.getElementById('products');

        const submitBtn =
            document.getElementById('submitBtn');

        const overlay =
            document.getElementById('processOverlay');

        /*
        |--------------------------------------------------------------------------
        | ENABLE BUTTON
        |--------------------------------------------------------------------------
        */

        function checkInputs() {

            const hasProducts =
                productsInput.files.length > 0;

            submitBtn.disabled = !hasProducts;
        }

        productsInput.addEventListener(
            'change',
            checkInputs
        );

        /*
        |--------------------------------------------------------------------------
        | AJAX SUBMIT
        |--------------------------------------------------------------------------
        */

        $('#submitBtn').on('click', function (e) {

            e.preventDefault();

            /*
            |--------------------------------------------------------------------------
            | SHOW LOADER
            |--------------------------------------------------------------------------
            */

            overlay.classList.remove('not-view');

            submitBtn.disabled = true;

            /*
            |--------------------------------------------------------------------------
            | FORM DATA
            |--------------------------------------------------------------------------
            */

            const form =
                $('#uploadForm')[0];

            const formData =
                new FormData(form);

            /*
            |--------------------------------------------------------------------------
            | AJAX
            |--------------------------------------------------------------------------
            */
            $(".view-result").html("");
            $.ajax({

                url: "{{ route('productsGenerateInformation', app()->getLocale()) }}",

                type: "POST",

                data: formData,

                processData: false,

                contentType: false,

                headers: {

                    'X-CSRF-TOKEN':
                        $('meta[name="csrf-token"]').attr('content')
                },

                success: function (response) {

                    console.log(
                        "✅ Archivos enviados correctamente:",
                        response
                    );

                    const html =
                        response.html;

                    $(".view-result").html(html);
                },

                error: function (xhr) {

                    console.error(
                        "❌ Error en el envío:",
                        xhr.responseJSON
                    );

                    alert(
                        xhr.responseJSON.message
                        || 'Error al subir archivos.'
                    );
                },

                complete: function () {

                    /*
                    |--------------------------------------------------------------------------
                    | HIDE LOADER
                    |--------------------------------------------------------------------------
                    */

                    overlay.classList.add('not-view');

                    checkInputs();
                }

            });

        });

    </script>

@endsection
