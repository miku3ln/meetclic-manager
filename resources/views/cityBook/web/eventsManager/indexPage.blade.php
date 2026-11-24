
@extends('layouts.cityBook')

@section('additional-styles')
    <style>
        /* ==============================================
           YAPITA - CULTURAL EVENTS
           BEM: yapita-events
           ============================================== */

        .yapita-events {
            --ye-primary: #3558df;
            --ye-text: #20283b;
            --ye-muted: #667085;
            --ye-border: #e7eaf1;

            padding: 64px 0 85px;
            background: #f7f9fd;
            color: var(--ye-text);
        }

        .yapita-events__header {
            max-width: 780px;
            margin: 0 auto 42px;
            text-align: center;
        }

        .yapita-events__eyebrow {
            display: inline-block;
            margin-bottom: 12px;
            color: var(--ye-primary);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .yapita-events__title {
            margin-bottom: 16px;
            font-size: clamp(30px, 4vw, 44px);
            font-weight: 800;
            line-height: 1.2;
        }

        .yapita-events__intro {
            color: var(--ye-muted);
            font-size: 16px;
            line-height: 1.8;
        }

        .yapita-events__card {
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--ye-border);
            border-radius: 20px;
            box-shadow: 0 12px 35px rgba(24, 39, 75, .06);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .yapita-events__card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 45px rgba(24, 39, 75, .11);
        }

        .yapita-events__media {
            position: relative;
            aspect-ratio: 16 / 9;
            overflow: hidden;
            background: #e9edf5;
        }

        .yapita-events__image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .35s ease;
        }

        .yapita-events__card:hover .yapita-events__image {
            transform: scale(1.04);
        }

        .yapita-events__status {
            position: absolute;
            top: 16px;
            left: 16px;
            padding: 7px 13px;
            background: #fff;
            border-radius: 50px;
            color: #168b56;
            font-size: 12px;
            font-weight: 700;
        }

        .yapita-events__body {
            display: flex;
            flex-direction: column;
            flex: 1;
            padding: 28px;
        }

        .yapita-events__category {
            margin-bottom: 8px;
            color: var(--ye-primary);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        .yapita-events__event-title {
            margin-bottom: 14px;
            font-size: 25px;
            font-weight: 800;
            line-height: 1.3;
        }

        .yapita-events__description {
            margin-bottom: 24px;
            color: var(--ye-muted);
            font-size: 15px;
            line-height: 1.8;
        }

        .yapita-events__dates {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            margin-top: auto;
            padding: 18px 0;
            border-top: 1px solid var(--ye-border);
        }

        .yapita-events__date {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .yapita-events__date-label {
            color: var(--ye-muted);
            font-size: 12px;
            font-weight: 600;
        }

        .yapita-events__date-value {
            font-size: 14px;
            font-weight: 700;
        }

        .yapita-events__footer {
            padding-top: 8px;
        }

        .yapita-events__button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 13px 22px;
            border-radius: 11px;
            background: var(--ye-primary);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: background .2s ease;
        }

        .yapita-events__button:hover,
        .yapita-events__button:focus {
            background: #2944b9;
            color: #fff;
        }

        @media (max-width: 767.98px) {
            .yapita-events {
                padding: 42px 0 60px;
            }

            .yapita-events__header {
                margin-bottom: 30px;
            }

            .yapita-events__body {
                padding: 20px;
            }

            .yapita-events__event-title {
                font-size: 22px;
            }

            .yapita-events__button {
                width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .yapita-events__card,
            .yapita-events__image,
            .yapita-events__button {
                transition: none;
            }
        }
    </style>
@endsection


@section('additional-scripts')
    @include('partials.bootstrap-05', ["allowCss" => true])

    <script>
        (function ($) {
            'use strict';

            $(function () {
                // Espacio para próximas mejoras con jQuery.
                // Ejemplo: filtros, paginación y scroll infinito.
            });

        })(jQuery);
    </script>
@endsection


@section('content')

    <section class="yapita-events" id="yapita-events">

        <div class="container">

            <!-- =====================================
                 INTRODUCCIÓN
                 ===================================== -->
            <header class="yapita-events__header">

            <span class="yapita-events__eyebrow">
                Cultura, comunidad y experiencias
            </span>

                <h1 class="yapita-events__title">
                    Experiencias y eventos
                </h1>

                <p class="yapita-events__intro">
                    Creemos en las experiencias que reúnen
                    a las personas y fortalecen los lazos
                    de nuestra comunidad.

                    Desde Yapita acompañamos iniciativas
                    culturales y comunitarias, aportando
                    herramientas digitales que ayudan a
                    conectar emprendimientos, visitantes
                    y nuevas experiencias.

                    Aquí compartimos los proyectos
                    en los que hemos participado.
                </p>

            </header>


            <!-- =====================================
                 LISTADO DE EVENTOS
                 ===================================== -->
            <div class="row justify-content-center g-4"
                 id="yapita-events-list">

                <div class="col-12 col-md-9 col-lg-7">

                    <article class="yapita-events__card"
                             data-event="halloween-otavalo-2026">

                        <!-- IMAGEN -->
                        <div class="yapita-events__media">

                            <img
                                class="yapita-events__image"
                                src="{{ asset('public/assets/events/Mapa1.jpg') }}"
                                alt="Halloween Otavalo, séptima edición 2026"
                                loading="lazy"
                            >

                            <span class="yapita-events__status">
                            Evento realizado
                        </span>

                        </div>


                        <!-- INFORMACIÓN -->
                        <div class="yapita-events__body">

                        <span class="yapita-events__category">
                            Cultura y comunidad
                        </span>

                            <h2 class="yapita-events__event-title">
                                Halloween Otavalo — 7.ª edición
                            </h2>

                            <p class="yapita-events__description">
                                Halloween Otavalo es una experiencia
                                que reúne a personas, emprendimientos
                                y negocios de la comunidad.

                                En su séptima edición, realizada en 2026,
                                desde Yapita contribuimos con herramientas
                                digitales para facilitar el descubrimiento
                                de establecimientos, la exploración de
                                rutas y la participación de visitantes.

                                Una iniciativa que demuestra cómo
                                la creatividad, la cultura y la tecnología
                                pueden encontrarse para fortalecer
                                nuestra comunidad.
                            </p>


                            <!-- FECHAS -->
                            <div class="yapita-events__dates">

                                <div class="yapita-events__date">

                                <span class="yapita-events__date-label">
                                    Fecha de inicio
                                </span>

                                    <time
                                        class="yapita-events__date-value"
                                        datetime="2026-10-31"
                                    >
                                        31 de octubre de 2026
                                    </time>

                                </div>

                                <div class="yapita-events__date">

                                <span class="yapita-events__date-label">
                                    Fecha de finalización
                                </span>

                                    <time
                                        class="yapita-events__date-value"
                                        datetime="2026-10-31"
                                    >
                                        31 de octubre de 2026
                                    </time>

                                </div>

                            </div>


                            <!-- BOTÓN -->
                            <div class="yapita-events__footer">

                                <a
                                    href="{{ url('/es/maskana?type=1') }}"
                                    class="yapita-events__button"
                                    aria-label="Conocer el proyecto Halloween Otavalo 2026"
                                >
                                    Conoce el proyecto
                                    <span aria-hidden="true">→</span>
                                </a>

                            </div>

                        </div>

                    </article>

                </div>

            </div>

        </div>

    </section>

@endsection
