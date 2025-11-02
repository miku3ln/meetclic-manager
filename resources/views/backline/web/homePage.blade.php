{{-- NONE CMS-TEMPLATE --}}
@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

        $assetsRoot = $resourcePathServer . 'assets/backline/';

@endphp
@extends('layouts.backline')
@section('additional-styles')
    <style>
        .section--full-img {
            padding: 0 0;
        }

        h1.title {
            float: left;
            width: 100%;
            text-align: center;
            color: #4db7fe;
            font-size: 34px;
            font-weight: 700;
        }

        .section--full-img {
            width: 100vw; /* Ancho completo de la ventana */
            height: 100vh; /* Altura completa de la ventana */
            /*display: flex;*/
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        img.img-svg-full {
            width: 100%;
            height: 100%;
            object-fit: cover; /* La imagen se recorta o ajusta para cubrir el contenedor */
            position: absolute;
            top: 0;
            left: 0;
        }

        .hero-section .intro-item h2 {
            font-size: 55px;
            color: #aacbe0;
        }

        @media screen and (min-width: 300px) and (max-width: 768px) {
            img.img-svg-full {
                width: 100%;
            }

            .intro-item h3 {

                font-size: 17px !important;

            }

            .hero-section .intro-item h2 {
                padding-top: 14%;
                font-size: 29px;

            }

            .slider-container-wrap.fs-slider .hero-section-wrap {
                top: 23% !important;
            }

            #wrapper {
                padding-top: 0;
            }

        }

        .row.row-manager-process-all {
            width: 100%;
        }

        .row-manager-process-all__col-one {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        img.row-manager-process-all__img {
            width: 40%;
        }

        .col-md-6.row-manager-process-all__col-two {
            margin-top: 2.2%;

        }

        p.row-manager-process-all__two-p {
            margin-left: 16%;
            text-align: left;
        }

        .row-manager-process-all__two-p span {
            color: #eff5f5;
            font-size: 20px;
            display: inline-block;
            width: 100%;
            margin-bottom: 20px;
        }

        .row-manager-process-all-container {
            padding-top: 15%;
        }

        .row.row-manager-process-all-information {
            margin-top: 10%;
        }

        p.row-manager-process-all-information__two-p span {
            letter-spacing: 6px;
            color: #eff5f5;
            font-size: 19px;
            display: inline-block;
            width: 100%;
            margin-bottom: 10px;
            font-weight: lighter;
            text-align: left;
            padding-left: 21%;
        }

        .row-manager-process-kloster-container {
            padding-top: 16%;
        }

        .row-manager-process-seven-container {
            padding-top: 16%;
        }

        p.row-manager-process-seven-information__two-p span {
            letter-spacing: 6px;
            color: #eff5f5;
            font-size: 19px;
            display: inline-block;
            width: 100%;
            margin-bottom: 10px;
            font-weight: lighter;
            text-align: left;
            padding-left: 21%;
        }


        .row-manager-ilustrate-one-one__col-one {
            width: 100vw; /* Ancho completo de la ventana */
            height: 100vh; /* Altura completa de la ventana */
            /*display: flex;*/
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .row-manager--ilustrate-one-one__img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* La imagen se recorta o ajusta para cubrir el contenedor */
            position: absolute;
            top: 0;
            left: 0;
        }

        .section-ilustrate {
            padding-left: 9%;
            padding-right: 9%;
            padding-top: 4.2% !important;
            padding-bottom: 4.2% !important;
        }

        .container-manager-img {
            width: 100vw; /* Ancho completo de la ventana */
            height: 100vh; /* Altura completa de la ventana */
            /*display: flex;*/
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .container-manager-img__resource {
            width: 100%;
            height: 100%;
            object-fit: cover; /* La imagen se recorta o ajusta para cubrir el contenedor */
            position: absolute;
            top: 0;
            left: 0;
        }


        /*---DESIGN BOOTSTRAP CUSTOMER-PAGE WEB --*/

        /*---Smartphones VERTICAL--*/
        @media (max-width: 768px) and (orientation: portrait) {
            img.row-manager-process-all__img {
                width: 63%;
            }

            img.row-manager-process-kloster-one__img {
                width: 100%;
            }

            img.row-manager-process-seven-one__img {
                width: 100%;
            }

            p.row-manager-process-all-information__two-p span {
                padding-left: 4%;
                letter-spacing: 3px;
            }

            p.row-manager-process-seven-information__two-p span {
                padding-left: 6%;
                margin-bottom: 5px;
                font-size: 12px;
            }

            .row-manager--ilustrate-one-one__img {

                object-fit: contain;

            }

            .container-manager-img {

                height: 48vh;
            }
        }

        /*---Smartphones HORIZONTAL--*/
        @media (max-width: 768px) and (orientation: landscape) {

        }

        /*---Tablets pequeñas VERTICAL--*/
        @media (min-width: 769px) and (max-width: 1024px) and (orientation: portrait) {

        }

        /*---Tablets pequeñas HORIZONTAL--*/
        @media (min-width: 769px) and (max-width: 1024px) and (orientation: landscape) {

        }

        /*---Tablets grandes ,Laptops y desktops VERTICAL--*/
        @media (min-width: 1025px) and (orientation: portrait) {

        }

        /*---Tablets grandes ,Laptops y desktops  HORIZONTAL--*/
        @media (min-width: 1025px) and (orientation: landscape) {


        }


        /* General styles */
        .section-ilustrate--row {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
        }

        /* Styles for larger devices (tablets and desktops) */
        @media (min-width: 768px) {
            .section-ilustrate__col-left, .section-ilustrate__col-right {
                width: 50%;
            }

            .col-image-left, .col-image-right {
                width: 100%;
                height: auto;
            }
        }

        /* Styles for mobile devices */
        @media (max-width: 767px) {
            .section-ilustrate__col-left, .section-ilustrate__col-right {
                width: 100%;
            }

            .col-image-left, .col-image-right {
                width: 100%;
                height: auto;
            }
        }

        #tics, #kloster, #seven {
            cursor: pointer;
        }
    </style>
@endsection
@section('additional-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.3/jquery.scrollTo.min.js"></script>

    <script>
        $(function () {
            $("#tics").click(function () {
                $('html, body').animate({
                    scrollTop: $('#ilustrate-sixteen').offset().top
                }, 1000);
            });

            $("#kloster").click(function () {
                $('html, body').animate({
                    scrollTop: $('#ilustrate-one').offset().top
                }, 1000);
            });
            $("#seven").click(function () {
                $('html, body').animate({
                    scrollTop: $('#ilustrate-one-seven').offset().top
                }, 1000);
            });

            $('.header-search').show();
        })
    </script>
@endsection
@section('content-manager')

    <section class="section--full-img" id="manager-process-all">
        <img class="img-svg-full" src="{{ URL::asset($assetsRoot.'home/b1.png')}}" alt="">
        <div class="row-manager-process-all-container">
            <div class="row row-manager-process-all">
                <div class="col-md-6 row-manager-process-all__col-one">
                    <img class="row-manager-process-all__img" src="{{ URL::asset($assetsRoot.'home/l1.png')}}" alt="">
                </div>
                <div class="col-md-6 row-manager-process-all__col-two">
                    <p class="row-manager-process-all__two-p">
                        <span>TICS Innovation</span>
                        <span>Gestion de Marca</span>
                        <span>Project Manager</span>

                    </p>
                </div>
            </div>
            <div class="row row-manager-process-all-information">

                <div class="col-md-6 row-manager-process-all-information__col-one">
                    <p class="row-manager-process-all-information__two-p">
                        <span>   Es un hub corporativo, que se encarga de la</span>
                        <span> creación de soluciones en TIC, Gestión de Marca</span>
                        <span> y Project Manager.</span>
                    </p>
                </div>
            </div>

        </div>
    </section>

    <section class="section--full-img" id="tics">
        <img class="img-svg-full" src="{{ URL::asset($assetsRoot.'home/b2.png')}}" alt="">
        <div class="row-manager-process-all-container">
            <div class="row row-manager-process-all">
                <div class="col-md-6 row-manager-process-all__col-one">
                    <img class="row-manager-process-all__img" src="{{ URL::asset($assetsRoot.'home/l2.png')}}" alt="">
                </div>
                <div class="col-md-6 row-manager-process-all__col-two">
                    <p class="row-manager-process-all__two-p">
                        <span>Optimización de Procesos</span>
                        <span>Desarrollo de Soluciones Inteligentes</span>
                        <span>Análisis Avanzado de Datos</span>
                        <span>Automatización y Confort Inteligente</span>

                    </p>
                </div>
            </div>
            <div class="row row-manager-process-all-information">

                <div class="col-md-6 row-manager-process-all-information__col-one">
                    <p class="row-manager-process-all-information__two-p">
                        <span> Hacemos que las empresas sean más eficientes al simplificar procesos,</span>
                        <span> automatizar tareas, desarrollar soluciones inteligentes</span>
                        <span> y analizar datos para una gestión ágil.</span>
                    </p>
                </div>
            </div>

        </div>
    </section>

    <section class="section--full-img" id="kloster">
        <img class="img-svg-full" src="{{ URL::asset($assetsRoot.'home/b3.png')}}" alt="">
        <div class="row-manager-process-kloster-container">
            <div class="row row-manager-process-kloster-one">
                <div class="col-md-12 row-manager-process-kloster-one__col-one">
                    <img class="row-manager-process-kloster-one__img" src="{{ URL::asset($assetsRoot.'home/l4.png')}}"
                         alt="">
                </div>

            </div>
            <div class="row row-manager-process-kloster-two not-view">
                <div class="col-md-12 row-manager-process-kloster-two__col-one">
                    <img class="row-manager-process-kloster-two__img" src="{{ URL::asset($assetsRoot.'home/l4.png')}}"
                         alt="">
                </div>

            </div>

        </div>
    </section>

    <section class="section--full-img section-ilustrate" id="seven">
        <img class="img-svg-full" src="{{ URL::asset($assetsRoot.'home/b4.png')}}" alt="">
        <div class="row-manager-process-seven-container">
            <div class="row row-manager-process-seven-one">
                <div class="col-md-12 row-manager-process-seven-one__col-one">
                    <img class="row-manager-process-seven-one__img" src="{{ URL::asset($assetsRoot.'home/l3.png')}}"
                         alt="">
                </div>

            </div>


        </div>
        <div class="row row-manager-process-seven-information">

            <div class="col-md-6 row-manager-process-seven-information__col-one">
                <p class="row-manager-process-seven-information__two-p">
                    <span> Representación de Artistas</span>
                    <span> Product Manager de Espectaculos</span>
                    <span>Seguridad de Espectaculos</span>
                    <span>Logistica para Grandes Espectaculo</span>
                    <span>Mercadeo</span>
                    <span>Planning</span>
                    <span>logistica de espectáculos</span>
                    <span>Consultoría de Espectáculos</span>

                </p>
            </div>
        </div>
    </section>

    <section class="section--ilustrate-one section-ilustrate-unify" id="ilustrate-one-seven">

        <div class="row-manager-ilustrate-one-container">
            <div class="row row-manager-ilustrate-one-one">
                <div class="col-md-12 row-manager-ilustrate-one-one__col-one">
                    <img class="row-manager--ilustrate-one-one__img" src="{{ URL::asset($assetsRoot.'home/r1.png')}}"
                         alt="">
                </div>
            </div>


        </div>

    </section>
    <section class="section--ilustrate-one section-ilustrate" id="ilustrate-one">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/1.png')}}" alt="">

                </div>
                <div class="section-ilustrate__col-right">

                    <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/1.1.png')}}" alt="">
                </div>
            </div>


        </div>

    </section>
    <section class="section--ilustrate-two section-ilustrate" id="ilustrate-two">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/2.png')}}" alt="">

                </div>
                <div class="section-ilustrate__col-right">

                    <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/2.1.png')}}" alt="">
                </div>
            </div>


        </div>

    </section>
    <section class="section--ilustrate-three section-ilustrate" id="ilustrate-three">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/3.png')}}" alt="">

                </div>
                <div class="section-ilustrate__col-right">

                    <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/3.1.png')}}" alt="">
                </div>
            </div>


        </div>

    </section>
    <section class="section--ilustrate-four section-ilustrate" id="ilustrate-four">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/4.png')}}" alt="">

                </div>
                <div class="section-ilustrate__col-right">

                    <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/4.1.png')}}" alt="">
                </div>
            </div>


        </div>

    </section>
    <section class="section--ilustrate-five section-ilustrate" id="ilustrate-five">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/5.png')}}" alt="">

                </div>
                <div class="section-ilustrate__col-right">

                    <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/5.1.png')}}" alt="">
                </div>
            </div>


        </div>

    </section>


    <section class="section--ilustrate-seven section-ilustrate" id="ilustrate-seven">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/7.png')}}" alt="">

                </div>
                <div class="section-ilustrate__col-right">

                    <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/7.1.png')}}" alt="">
                </div>
            </div>


        </div>

    </section>
    <section class="section--ilustrate-eight section-ilustrate" id="ilustrate-eight">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/8.png')}}" alt="">

                </div>
                <div class="section-ilustrate__col-right">

                    <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/8.1.png')}}" alt="">
                </div>
            </div>


        </div>

    </section>
    <section class="section--ilustrate-nine section-ilustrate" id="ilustrate-nine">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/9.png')}}" alt="">

                </div>
                <div class="section-ilustrate__col-right">

                    <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/9.1.png')}}" alt="">
                </div>
            </div>


        </div>

    </section>
    <section class="section--ilustrate-ten section-ilustrate" id="ilustrate-ten">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/10.png')}}" alt="">

                </div>
                <div class="section-ilustrate__col-right">

                    <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/10.1.png')}}" alt="">
                </div>
            </div>


        </div>

    </section>
    <section class="section--ilustrate-eleven section-ilustrate" id="ilustrate-eleven">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/11.png')}}" alt="">

                </div>
                <div class="section-ilustrate__col-right">

                    <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/11.1.png')}}" alt="">
                </div>
            </div>


        </div>

    </section>
    <section class="section--ilustrate-twelve section-ilustrate" id="ilustrate-twelve">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/12.png')}}" alt="">

                </div>
                <div class="section-ilustrate__col-right">

                    <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/12.1.png')}}" alt="">
                </div>
            </div>


        </div>

    </section>
    <section class="section--ilustrate-thirteen section-ilustrate" id="ilustrate-thirteen">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/13.png')}}" alt="">

                </div>
                <div class="section-ilustrate__col-right">

                    <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/13.1.png')}}" alt="">
                </div>
            </div>


        </div>

    </section>
    <section class="section--ilustrate-fourteen section-ilustrate" id="ilustrate-fourteen">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/14.png')}}" alt="">

                </div>
                <div class="section-ilustrate__col-right">

                    <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/14.1.png')}}" alt="">
                </div>
            </div>


        </div>

    </section>
    <section class="section--ilustrate-fifteen section-ilustrate" id="ilustrate-fifteen">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/15.png')}}" alt="">

                </div>
                <div class="section-ilustrate__col-right">

                    <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/15.1.png')}}" alt="">
                </div>
            </div>


        </div>

    </section>
    <section class="section--ilustrate-sixteen section-ilustrate" id="ilustrate-sixteen">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <a href="http://meetclic.com" target="_blank">
                        <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/16.png')}}" alt="">
                    </a>
                </div>
                <div class="section-ilustrate__col-right">
                    <a href="http://meetclic.com" target="_blank">
                        <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/16.1.png')}}" alt="">
                    </a>
                </div>
            </div>


        </div>

    </section>
    <section class="section--ilustrate-seventeen section-ilustrate" id="ilustrate-seventeen">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <a href="https://point-of-sale.xywer.net/cruge/ui/login" target="_blank">

                        <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/17.png')}}" alt="">
                    </a>

                </div>
                <div class="section-ilustrate__col-right">
                    <a href="https://point-of-sale.xywer.net/cruge/ui/login" target="_blank">
                        <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/17.1.png')}}" alt="">
                    </a>
                </div>
            </div>


        </div>

    </section>
    <section class="section--ilustrate-eigthteen section-ilustrate" id="ilustrate-eigthteen">

        <div class="section-ilustrate__container-row">
            <div class="row section-ilustrate--row">
                <div class=" section-ilustrate__col-left">
                    <a href="http://meetclic.com/es/chasquinian" target="_blank">
                        <img class="col-image-left" src="{{ URL::asset($assetsRoot.'home/projects/18.png')}}" alt="">
                    </a>
                </div>
                <div class="section-ilustrate__col-right">
                    <a href="http://meetclic.com/es/chasquinian" target="_blank">
                        <img class="col-image-right" src="{{ URL::asset($assetsRoot.'home/projects/18.1.png')}}" alt="">
                    </a>
                </div>
            </div>


        </div>

    </section>
@endsection

