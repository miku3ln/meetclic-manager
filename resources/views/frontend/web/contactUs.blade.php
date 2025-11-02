<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>

@extends('layouts.frontend')
@section('additional-styles')
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">
@endsection
@section('script')

    <script
        src="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}"></script>
    <!-- Map JS -->
    <script>
        var $currentPage = <?php echo json_encode(isset($dataManagerPage['currentPage']) ? $dataManagerPage['currentPage'] : 'not-defined')?>;

        var $dataBusiness = <?php echo json_encode($dataContactUs['dataBusiness'])?>;
        var $contactUsMap = <?php echo json_encode($dataContactUs['contactUsMap'])?>;


        // When the window has finished loading create our google map below
        google.maps.event.addDomListener(window, 'load', init3);

        function init3() {
            // Basic options for a simple Google Map
            // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
            var center = new google.maps.LatLng(40.7590615, -73.969231);
            var title = "{{__('contact-us.map.title')}}";

            var urlIcon = $resourceRoot + "frontend/assets/img/icons/map_marker.png";
            var position = new google.maps.LatLng(40.7590615, -73.969231);
            var zoom = 12;
            if (Object.keys($dataBusiness).length > 0) {
                title = $dataBusiness.alt;
                position = new google.maps.LatLng($dataBusiness.street_lat, $dataBusiness.street_lng);
                center = new google.maps.LatLng($dataBusiness.street_lat, $dataBusiness.street_lng);
                if ($dataBusiness.options_map != '' && $dataBusiness.options_map != null) {
                    var options_map = jQuery.parseJSON($dataBusiness.options_map);
                    center = new google.maps.LatLng(options_map.center.lat, options_map.center.lng);
                    zoom = options_map.zoom;

                }
            }
            if ($contactUsMap != null && Object.keys($contactUsMap).length > 0) {
                urlIcon = $resourceRoot+$contactUsMap['source'];
            }
            var mapOptions = {
                // How zoomed in you want the map to start at (always required)
                zoom: zoom,

                scrollwheel: false,

                // The latitude and longitude to center the map (always required)
                center: center, // New York

                // How you would like to style the map.
                // This is where you would paste any style found on

                styles: [{
                    "featureType": "all",
                    "elementType": "all",
                    "stylers": [{
                        "saturation": -100
                    },
                        {
                            "gamma": 0.5
                        }
                    ]
                }]
            };

            // Get the HTML DOM element that will contain your map
            // We are using a div with id="map" seen below in the <body>
            var mapElement = document.getElementById('google-map-three');

            // Create the Google Map using our element and options defined above
            var map = new google.maps.Map(mapElement, mapOptions);

            // Let's also add a marker while we're at it


            var width = 30, height = 40;
            var iconCurrent = {
                url: urlIcon,
                scaledSize: new google.maps.Size(width, height), // scaled size
                origin: new google.maps.Point(0, 0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
            console.log(iconCurrent);
            var marker = new google.maps.Marker({
                position: position,
                map: map,
                title: title,
                icon: iconCurrent
            });
        }

        var formNameSelector = "#contact-form";
        var customerPage = 'Contáctanos.';
        $(formNameSelector).submit(function (event) {
            var dataSend = $(formNameSelector).serializeArray().reduce(function (obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});
            dataSend['customerPage'] = customerPage;
            var typePage = 0;
            var business_id = 1;
            dataSend['typePage'] = typePage;
            dataSend['business_id'] = business_id;
            $routeUrl = '{{route('sendMail')}}';
            ajaxRequest($routeUrl, {
                type: 'POST',
                data: dataSend,
                blockElement: '.contact-form-wrapper',//opcional: es para bloquear el elemento
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
                    $('#contact-form').trigger("reset");
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

        <!--=======  map area  =======-->

        <div class="box-layout-map-area section-space">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!--=======  box layout map container  =======-->

                        <div class="box-layout-map-container">
                            <div class="google-map" id="google-map-three"></div>
                        </div>

                        <!--=======  End of box layout map container  =======-->
                    </div>
                </div>
            </div>
        </div>

        <!--=======  End of map area  =======-->

        <!--=======  contact icon text  =======-->

        <div class="contact-icon-text-area section-space">
            <div class="container">
                @if($dataContactUs['informationContactUs']!='')
                    {{$dataContactUs['informationContactUs']}}
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="manager-notification">{{__('messages.not-manager')}} <span
                                    class="manager-notification-type">{{__('messages.errors.warning')}} </span></h1>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!--=======  End of contact icon text  =======-->

        <!--=======  contact form with content  =======-->
        @if($dataManagerPage['sectionPage']['formContactUs']['viewFormSection'])
            <div class="contact-form-content-area section-space--contact-form">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!--=======  contact form content wrapper  =======-->

                            <div class="contact-form-content-wrapper">
                                <div class="row">
                                    <div class="col-md-8">
                                        <!--=======  contact form wrapper  =======-->

                                        <div class="contact-form-wrapper">
                                            <form id="contact-form" method="post">
                                                <div class="row">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <input type="text"
                                                               placeholder="{{$dataManagerPage['sectionPage']['formContactUs']['field1']}}"
                                                               name="customerName"
                                                               id="customername" required>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6">
                                                        <input type="email"
                                                               placeholder="{{$dataManagerPage['sectionPage']['formContactUs']['field2']}}"
                                                               name="customerEmail"
                                                               id="customerEmail" required>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="text"
                                                               placeholder="{{$dataManagerPage['sectionPage']['formContactUs']['field3']}}"
                                                               name="contactSubject"
                                                               id="contactSubject">
                                                    </div>
                                                    <div class="col-lg-12">
                                                    <textarea cols="30" rows="10"
                                                              placeholder="{{$dataManagerPage['sectionPage']['formContactUs']['field4']}}"
                                                              name="contactMessage" id="contactMessage"
                                                              required></textarea>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <button type="submit" id="submit"
                                                                class="theme-button"> {{$dataManagerPage['sectionPage']['formContactUs']['buttonSend']}}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <p class="form-messege"></p>
                                        </div>


                                        <!--=======  End of contact form wrapper  =======-->
                                    </div>

                                    <div class="col-md-4">
                                        <!--=======  contact form content  =======-->

                                        @if(isset($dataContactUs))
                                            @if(isset($dataContactUs['socialNetworkContactUs']))
                                                @if($dataContactUs['socialNetworkContactUs']!='')
                                                    {{$dataContactUs['socialNetworkContactUs']}}
                                                @else

                                                @endif
                                            @else

                                            @endif

                                        @else

                                    @endif

                                    <!--=======  End of contact form content  =======-->
                                    </div>
                                </div>
                            </div>

                            <!--=======  End of contact form content wrapper  =======-->
                        </div>
                    </div>
                </div>
            </div>
    @endif
    <!--=======  End of contact form with content  =======-->

    </div>

    <!--====================  End of page content wrapper  ====================-->


@endsection
