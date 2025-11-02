<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>


@extends('layouts.frontend')
@section('additional-styles')
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">
    <style>
        .page-content-wrapper.page-content-wrapper--height {
            height: 175px;
        }

        .nice-select.nice-select-quick-view {
            width: 100%;
        }

        .nice-select.open .list {

            width: 100%;
        }
        h2.page-title {
            color: #E13510;
            text-transform: uppercase;
        }
        .nice-select {
            color: #fff;

            background-color: #001B2A;

            border: 1px solid #001B2A;
        }
        .form-control{
            background: #001B2A!important;
            color: #fff !important;

        }
        .nice-select .option {

            color: #E13510;
        }
        .title-service{
            color: #E13510;
            text-transform: uppercase;

        }
        .title-service:after {
            bottom: 25px;
            background-color: #E74E1C;
        }
        div#services {
            margin-top: 4%;
        }
    </style>
    @include('partials.plugins.resourcesCss',['toast'=>true])
    @include('partials.pluginsVue.resourcesCss',['dateTimePicker'=>true])
@endsection
@section('script-bootgrid-init')


@endsection

@section('additional-scripts')
    <script src="{{ asset($resourcePathServer.'assets/libs/moment/moment.min.js')}}"></script>

    @include('partials.pluginsVue.resourcesJs',['dateTimePicker'=>true])

    <script>
        $(function () {
            console.log(69)
            $('#hour-service').datetimepicker({
                format: 'LT'
            });
            $('#date-service').datetimepicker({

                format: 'DD/MM/YYYY'
            });
            $('#btn-date-service').on('click', function () {
                $('#date-service').focus();
                $('#date-service').focus();

            });
            $('#btn-hour-service').on('click', function () {
                $('#hour-service').focus();
                $('#hour-service').focus();

            })
        });
    </script>
    <script>


        var formNameSelector = "#contact-form";
        var customerPage = 'Contáctanos Rerservas.';
        $(formNameSelector).submit(function (event) {
            var dataSend = $(formNameSelector).serializeArray().reduce(function (obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});
            dataSend['customerPage'] = customerPage;
            var typePage = 3;
            var business_id = 1;
            dataSend['typePage'] = typePage;
            dataSend['business_id'] = business_id;
            $routeUrl = '{{route('sendMail')}}';
            ajaxRequest($routeUrl, {
                type: 'POST',
                data: dataSend,
                blockElement: '.page-content-wrapper',//opcional: es para bloquear el elemento
                loading_message: "{{__('contact-us.form.message.loading')}}",
                error_message: "{{__('contact-us.form.message.error')}}",
                success_message: "{{__('contact-us.form.message.success')}}",
                success_callback: function (response) {

                    $.NotificationApp.send(options = {
                        heading: "{{__('contact-us.form.message.notification.title')}}",
                        text: response.msj,
                        position: 'top-right',
                        loaderBg: response.success ? '#53BF82' : "#FFB907",
                        icon: response.success ? 'success' : 'warning',
                        hideAfter: 5000
                    });
                    $(formNameSelector).trigger("reset");
                }
            });
            event.preventDefault();
        });
    </script>
@endsection
@section('content')

    <div class="breadcrumb-area section-space--breadcrumb section-space--manager-sisdep">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">

                    <h2 class="page-title">{{$dataManagerPage['header']['title'] }}</h2>

                </div>
            </div>
        </div>
    </div>
    <div class="page-content-wrapper">
        <!--=======  shop page area  =======-->

        <div class="shop-page-area">
            <div class="contact-form-wrapper">

                <form id="contact-form" method="post">
                    <div class="container">
                        <div class="row">
                            <div class='col-md-3'>
                                <div class="form-group">
                                    <label for="store-service">Locales <span>*</span></label>
                                    <div class="content-element-form">
                                        <select id="store-service"
                                                name="stores-service"
                                                required
                                                class="nice-select-quick-view"
                                        >

                                            <option val="1">Matriz</option>
                                            <option val="2">Sucursal</option>

                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class='col-md-3'>
                                <div class="form-group">
                                    <label for="date-service">Fecha <span>*</span></label>
                                    <div class="content-element-form">
                                        <div class="content-element-form input-group">
                                            <input
                                                required
                                                name="date-service"
                                                placeholder="Elige la fecha"
                                                class='form-control' id="date-service">
                                            <div class="input-group-append">
                                                <button class="input-group-text" id="btn-date-service" type="button"
                                                        data-toggle="datetimepicker"><i
                                                        class="fa fa-calendar"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class='col-md-2'>
                                <div class="form-group">
                                    <label for="hour-service">Hora <span>*</span></label>
                                    <div class="content-element-form">
                                        <div class="input-group">
                                            <input
                                                required
                                                placeholder="Elige una hora"
                                                name="hour-service"
                                                class='form-control' id="hour-service">
                                            <div class="input-group-append">
                                                <button class="input-group-text" id="btn-hour-service" type="button"
                                                        data-toggle="datetimepicker"><i
                                                        class="glyphicon glyphicon-time"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label for="full-name-service">Nombre Contacto <span>*</span></label>
                                    <div class="content-element-form">

                                        <input
                                            required
                                            placeholder="Ingresar nombres,apellidos"
                                            name="full-name-service"
                                            class='form-control' id="phone-service">

                                    </div>
                                </div>

                            </div>
                            <div class='col-md-2'>
                                <div class="form-group">
                                    <label for="phone-service">Telf Contacto <span>*</span></label>
                                    <div class="content-element-form">

                                        <input
                                            required
                                            placeholder="Ingresar Nro Telf"
                                            name="phone-service"
                                            class='form-control' id="phone-service">

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" id="submit-contact"
                                        class="theme-button"> Agendar                                </button>
                            </div>
                        </div>
                        <div class="row" id="services">
                            <h2 class="title-service">
                                Servicios de Diseño
                            </h2>
                            <p class="description-service">
                                El Centro de Diseño Arquitechos es un espacio creado especialmente para todos los clientes
                                que requieran una asesoría especializada en acabados de construcción y remodelación de su
                                hogar. Ofrecemos servicio especializado de nuestras diseñadoras de interiores sin costo,
                                ambientación de sus espacios en 3D, Bocetos de sus ambientes y detalles de los montajes.
                            </p>
                            <h2 class="title-service">
                                Mano de Obra Calificada
                            </h2>
                            <p class="description-service">
                                El Centro de Diseño Boyacá es un espacio creado especialmente para todos los clientes que
                                requieran una asesoría especializada en acabados de construcción y remodelación de su hogar.
                                Ofrecemos servicio especializado de nuestras diseñadoras de interiores sin costo,
                                ambientación de sus espacios en 3D, Bocetos de sus ambientes y detalles de los montajes.
                            </p>
                            <h2 class="title-service">
                                Transporte
                            </h2>
                            <p class="description-service">
                                El Centro de Diseño Boyacá es un espacio creado especialmente para todos los clientes que
                                requieran una asesoría especializada en acabados de construcción y remodelación de su hogar.
                                Ofrecemos servicio especializado de nuestras diseñadoras de interiores sin costo,
                                ambientación de sus espacios en 3D, Bocetos de sus ambientes y detalles de los montajes.
                            </p>
                        </div>
                    </div>


                </form>
            </div>
        </div>

    </div>

@endsection
