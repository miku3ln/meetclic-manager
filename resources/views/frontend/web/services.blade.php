<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>
@extends('layouts.frontend')
@section('additional-styles')
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">
@endsection
@section('additional-scripts')
    <!-- Map JS -->
    <script>
        var $currentPage = <?php echo json_encode(isset($dataManagerPage['currentPage']) ? $dataManagerPage['currentPage'] : 'not-defined')?>;


        var formNameSelector = "#contact-form";
        var customerPage = 'Servicios.';
        $(formNameSelector).submit(function (event) {
            var dataSend = $(formNameSelector).serializeArray().reduce(function (obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});
            dataSend['customerPage'] = customerPage;
            var typePage = 1;
            var business_id = 1;
            dataSend['typePage'] = typePage;
            dataSend['business_id'] = business_id;
            $routeUrl = '{{route('sendMail')}}';
            ajaxRequest($routeUrl, {
                type: 'POST',
                data: dataSend,
                blockElement: '.contact-form-wrapper',//opcional: es para bloquear el elemento
                loading_message: "{{__('services.form.message.loading')}}",
                error_message: "{{__('services.form.message.error')}}",
                success_message: "{{__('services.form.message.success')}}",
                success_callback: function (response) {

                    $.NotificationApp.send(options = {
                        heading: "{{__('services.form.message.notification.title')}}",
                        text: response.msj,
                        position: 'top-right',
                        loaderBg: response.success ? '#53BF82' : "#FFB907",
                        icon: response.success ? 'success' : 'warning',
                        hideAfter: 5000
                    });
                    $('#contact-form').trigger("reset");
                }
            });
            event.preventDefault();
        });
        $(function () {

            $('.show-search-button').show();
        })
    </script>

@endsection
@section('content')


    <div class="breadcrumb-area section-space--breadcrumb section-space--manager-sisdep">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <!--=======  breadcrumb wrapper  =======-->
                    <div class="breadcrumb-wrapper">
                        <h2 class="page-title">{{$dataManagerPage['header']['title']}}</h2>
                        <ul class="breadcrumb-list">
                            {!! $dataManagerPage['header']['breadCrumb']['inactive'] !!}

                            <li class="active">{{$dataManagerPage['header']['breadCrumb']['active']}}</li>
                        </ul>
                    </div>

                    <!--=======  End of breadcrumb wrapper  =======-->
                </div>
            </div>
        </div>
    </div>

    <!--====================  End of breadcrumb area  ====================-->

    <!--====================  page content wrapper ====================-->

    <div class="page-content-wrapper">


        <div class="service-text-area section-space">
            <div class="container">
                <!--=======  about us brief wrapper  =======-->
                @if($dataManagerPage['sectionPage']['parentHtml']!='')
                    {{$dataManagerPage['sectionPage']['parentHtml']}}
                @else
                    <div class="manager-empty"> {{__('messages.not-manager')}}</div>
                @endif

                @if($dataManagerPage['sectionPage']['childrenHtml']!='')
                    {{$dataManagerPage['sectionPage']['childrenHtml']}}
                @else
                    <div class="manager-empty">{{__('messages.not-manager')}}</div>
                @endif
            </div>
        </div>

        <!--=======  End of service text area  =======-->


        <!--=======  contact form area  =======-->
        @if($dataManagerPage['sectionPage']['formContactUs']['viewFormSection'])

            <div class="contact-form-area section-space--inner--contact-form bg--dark-grey">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title-area text-center">
                                <h2 class="section-title">{{$dataManagerPage['sectionPage']['formContactUs']['title']}}</h2>
                                <p class="section-subtitle">{{$dataManagerPage['sectionPage']['formContactUs']['subtitle']}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <!--=======  contact form wrapper  =======-->

                            <div class="contact-form-wrapper">
                                <form id="contact-form" method="post">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-6">
                                            <input type="text"
                                                   placeholder="{{$dataManagerPage['sectionPage']['formContactUs']['field1']}}"
                                                   name="customerName" id="customername" required>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <input type="email"
                                                   placeholder="{{$dataManagerPage['sectionPage']['formContactUs']['field2']}}"
                                                   name="customerEmail" id="customerEmail" required>
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text"
                                                   placeholder="{{$dataManagerPage['sectionPage']['formContactUs']['field3']}}"
                                                   name="contactSubject" id="contactSubject">
                                        </div>
                                        <div class="col-lg-12">
                                        <textarea cols="30" rows="10"
                                                  placeholder="{{$dataManagerPage['sectionPage']['formContactUs']['field4']}}"
                                                  name="contactMessage" id="contactMessage" required></textarea>
                                        </div>
                                        <div class="col-lg-12">
                                            <button type="submit" id="submit"
                                                    class="theme-button"> {{$dataManagerPage['sectionPage']['formContactUs']['buttonSend']}}</button>
                                        </div>
                                    </div>
                                </form>
                                <p class="form-messege"></p>
                            </div>


                            <!--=======  End of contact form wrapper  =======-->
                        </div>
                    </div>
                </div>
            </div>

            <!--=======  End of contact form area  =======-->
        @endif

    </div>

@endsection
