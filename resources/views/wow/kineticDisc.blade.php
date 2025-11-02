@extends('layouts.managementProcess.index') {{-- o el layout que uses --}}
@section('content')
    <div class="container">
        <main class="cinetic">
            <section class="cinetic__header text-center">
                <h1 class="cinetic__title">🌀 Disco Cinético Interactivo</h1>
            </section>

            <section class="cinetic__controls container">
                <div class="row justify-content-center">
                    <div class="col-md-6">

                        <div class="form-group cinetic__form-group mb-3">
                            <label for="upload" class="form-label cinetic__label">Sube tu imagen (mandala):</label>
                            <input class="form-control cinetic__input" type="file" id="upload" accept="image/*">
                        </div>

                        <div class="form-group cinetic__form-group mb-3">
                            <label for="speed" class="form-label cinetic__label">Velocidad de rotación:</label>
                            <input type="range" class="form-range cinetic__range" min="0" max="100" step="0.1" value="0.01" id="speed">
                            <small class="text-muted cinetic__speed-value">Actual: <span id="speedValue">1.0</span></small>
                        </div>

                        <div class="form-group cinetic__form-group mb-3">
                            <label for="direction" class="form-label cinetic__label">Dirección:</label>
                            <select class="form-select cinetic__select" id="direction">
                                <option value="normal">Derecha (horaria)</option>
                                <option value="reverse">Izquierda (antihoraria)</option>
                            </select>
                        </div>

                        <div class="d-grid cinetic__button-group">
                            <button id="toggle" class="btn btn-primary cinetic__button">Iniciar rotación</button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="cinetic__display">
                <div class="cinetic__canvas">
                    <img id="mandala" class="cinetic__image" src="" alt="Mandala" style="display: none;">
                </div>
            </section>
        </main>

        <main class="zoetrope">
            <section class="zoetrope__controls container text-center">
                <h1 class="zoetrope__title my-4">🎞️ Fenakistiscopio Digital</h1>

                <div class="mb-3">
                    <label for="zoetropeUpload" class="form-label">Sube tu disco animado (imagen circular):</label>
                    <input type="file" class="form-control" id="zoetropeUpload" accept="image/*" />
                </div>

                <div class="mb-3">
                    <label for="zoetropeSpeed" class="form-label">Velocidad de rotación:</label>
                    <input type="range" class="form-range" min="0" max="10" step="0.1" value="2" id="zoetropeSpeed" />
                    <div>Actual: <span id="zoetropeSpeedValue">2.0</span></div>
                </div>

                <button class="btn btn-primary" id="zoetropeToggle">Iniciar Rotación</button>
            </section>

            <section class="zoetrope__display mt-5">
                <div class="zoetrope__canvas mx-auto position-relative">
                    <img id="zoetropeImage" class="zoetrope__image" src="" alt="Disco" style="display: none;" />
                    <div class="zoetrope__mask" id="maskLayer"></div>
                </div>
            </section>
        </main>
    </div>

    <style>
        .page {
            background-color: #f8f9fa;
            min-height: 100vh;
            padding-top: 2rem;
        }

        .cinetic__title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .cinetic__form-group {
            margin-bottom: 1.5rem;
        }

        .cinetic__label {
            font-weight: 500;
        }

        .cinetic__canvas {
            width: 100%;
            max-width: 400px;
            height: 400px;
            margin: 30px auto;
            position: relative;
            border-radius: 50%;
            overflow: hidden;
        }

        .cinetic__image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            transition: transform 0.1s linear;
            position: absolute;
            top: 0;
            left: 0;
        }

        .cinetic__speed-value {
            font-size: 0.85rem;
            display: block;
            margin-top: 0.3rem;
            text-align: right;
        }

        .cinetic__button-group {
            margin-top: 1.5rem;
        }



        .page {
            background: #f9f9f9;
            padding-top: 2rem;
        }

        .zoetrope__title {
            font-weight: 600;
        }

        .zoetrope__canvas {
            width: 400px;
            height: 400px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            border: 4px solid #ddd;
            background: #fff;
        }

        .zoetrope__image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            position: absolute;
            top: 0;
            left: 0;
            transition: transform 0.05s linear;
        }

        .zoetrope__mask {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
            mix-blend-mode: multiply;
            opacity: 0.65;

            background: repeating-conic-gradient(
                black 0deg 10deg,
                transparent 10deg 30deg
            );
        }
    </style>
    <script>
       function initZootro(){
           let angle = 0;
           let rotating = false;
           let interval;
           let speed = parseFloat($('#zoetropeSpeed').val());

           const $img = $('#zoetropeImage');
           const $toggle = $('#zoetropeToggle');

           function startRotation() {
               interval = setInterval(() => {
                   angle += speed;
                   $img.css('transform', `rotate(${angle}deg)`);
               }, 20);
           }

           $('#zoetropeSpeed').on('input', function () {
               speed = parseFloat(this.value);
               $('#zoetropeSpeedValue').text(speed.toFixed(1));
           });

           $toggle.on('click', function () {
               if (!rotating) {
                   startRotation();
                   rotating = true;
                   $(this).text('Detener Rotación').removeClass('btn-primary').addClass('btn-danger');
               } else {
                   clearInterval(interval);
                   rotating = false;
                   $(this).text('Iniciar Rotación').removeClass('btn-danger').addClass('btn-primary');
               }
           });

           $('#zoetropeUpload').on('change', function (e) {
               const file = e.target.files[0];
               if (file) {
                   const reader = new FileReader();
                   reader.onload = function (event) {
                       $img.attr('src', event.target.result).show();
                   };
                   reader.readAsDataURL(file);
               }
           });
        }
        $(document).ready(function () {
            let angle = 0;
            let speed = parseFloat($('#speed').val());
            let direction = 1;
            let rotating = false;
            let interval;

            const $img = $('#mandala');
            const $toggle = $('#toggle');

            function startRotation() {
                interval = setInterval(() => {
                    angle += direction * speed;
                    $img.css('transform', `rotate(${angle}deg)`);
                }, 20);
            }

            $('#speed').on('input', function () {
                speed = parseFloat(this.value);
                $('#speedValue').text(speed.toFixed(1));
            });

            $('#direction').on('change', function () {
                direction = $(this).val() === 'normal' ? 1 : -1;
            });

            $toggle.on('click', function () {
                if (!rotating) {
                    startRotation();
                    rotating = true;
                    $(this).text('Detener rotación').removeClass('btn-primary').addClass('btn-danger');
                } else {
                    clearInterval(interval);
                    rotating = false;
                    $(this).text('Iniciar rotación').removeClass('btn-danger').addClass('btn-primary');
                }
            });

            $('#upload').on('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $img.attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

    </script>

    <script>

    </script>
@endsection
