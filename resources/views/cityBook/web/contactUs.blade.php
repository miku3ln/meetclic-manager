
@extends('layouts.cityBook')
@section('additional-styles')
    <link href="{{ URL::asset($resourcePathServer.'libs/toast/jquery.toast.min.css') }}" rel="stylesheet"
          type="text/css">
@endsection
@section('additional-scripts')

    <script src="{{ URL::asset($resourcePathServer.'libs/blockui/blockui.min.js') }}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
            integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
            crossorigin="anonymous"></script>
    <script src="{{ URL::asset($resourcePathServer.'libs/toast/jquery.toast.min.js') }}"
            type='text/javascript'></script>


    <script>
        $(function () {
            $('.show-search-button').show();
            var formNameSelector = "#contact-form";
            var customerPage = 'Contáctanos.';
            $(formNameSelector).submit(function (event) {
                var dataSend = $(formNameSelector).serializeArray().reduce(function (obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {});
                console.log(dataSend);
                dataSend['customerPage'] = customerPage;
                var typePage = 0;
                var business_id = 1;
                dataSend['typePage'] = typePage;
                dataSend['business_id'] = business_id;
                $routeUrl = '{{route('sendMail')}}';
                ajaxRequestManager($routeUrl, {
                    type: 'POST',
                    data: dataSend,
                    blockElement: '.contact-form-wrapper',//opcional: es para bloquear el elemento
                    loading_message: "{{__('contact-us.form.message.loading')}}",
                    error_message: "{{__('contact-us.form.message.error')}}",
                    success_message: "{{__('contact-us.form.message.success')}}",
                    success_callback: function (response) {

                        options = {
                            heading: "{{__('contact-us.form.message.notification.title')}}",
                            text: response.msj,
                            position: 'top-right',
                            loaderBg: response.success ? '#53BF82' : "#FFB907",
                            icon: response.success ? 'success' : 'warning'
                        }
                        showAlertManager({type: response.success ? 'success' : 'warning', message: response.msj});
console.log(options);
                        $('#contact-form').trigger("reset");
                    }
                });
                event.preventDefault();
                return false;
            });
        });
    </script>

@endsection
@if(isset($dataManagerPage['dataPage']))

@section('content-manager')

    <div class="content full-height fs-slider-wrap">
        <!--section -->
        <section class="hero-section no-dadding full-height {{"hero-section--item" }}" id="sec1">
            <div class="slider-container-wrap full-height fs-slider fl-wrap">
                <div class="slider-container">


                    <div class="slider-item fl-wrap">
                        <div class="bg"
                             data-bg="{{ URL::asset($themePath.'images/bg/2.jpg')}}"></div>
                        <div class="overlay"></div>
                        <div class="hero-section-wrap fl-wrap">
                            <div class="container">
                                <div class="intro-item fl-wrap">
                                    <h2 class="intro-item__title"> {{__('labels.twenty-eight')}} </h2>
                                    <h3 class="intro-item__subtitle"> {{__('labels.twenty-nine')}} </h3>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
                @if(false)
                    <div class="swiper-button-prev sw-btn"><i class="fa fa-long-arrow-left"></i></div>
                    <div class="swiper-button-next sw-btn"><i class="fa fa-long-arrow-right"></i></div>
                @endif
            </div>
            <div class="header-sec-link">
                <div class="container">
                    <a href="#sec2" class="custom-scroll-link">{{__('page.initSection.button')}}</a>
                </div>
            </div>
        </section>

    </div>

@endsection
@endif
@section('content')
    @if(isset($dataManagerPage['dataPage']))
        <div id="app-management">

            <!-- section end -->
            <!--section -->
            <section id="sec2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="list-single-main-item fl-wrap">
                                <div class="list-single-main-item-title fl-wrap">
                                    <h3>{{__('page.contactUs.variant.background.title')}}
                                        <span>{{__('page.contactUs.variant.background.subtitle')}} </span></h3>
                                </div>
                                <div class="list-single-main-media fl-wrap">
                                    <img src="{{ URL::asset($themePath.'images/all/12.jpg')}}" class="respimg" alt="">
                                </div>
                                <p>{{__('page.contactUs.variant.background.description')}}</p>
                                <div class="list-author-widget-contacts">
                                    <ul>
                                        <li><span><i class="fa fa-map-marker"></i>
                                             {{__('labels.twenty-four')}} :</span> <a
                                                >{{$dataManagerPage['dataPage']['information']['address']['primary'].' '.$dataManagerPage['dataPage']['information']['address']['secondary']}}</a>
                                        </li>
                                        <li><span><i class="fa fa-phone"></i>  {{__('labels.twenty-five')}} :</span> <a
                                                href="tel://+593{{$dataManagerPage['dataPage']['information']['phone']}}">{{$dataManagerPage['dataPage']['information']['phone']}}</a>
                                        </li>
                                        <li><span><i class="fa fa-envelope-o"></i>   {{__('labels.twenty-six')}}  :</span> <a
                                                href="mailto://{{$dataManagerPage['dataPage']['information']['mail']}}">{{$dataManagerPage['dataPage']['information']['mail']}}</a>
                                        </li>
                                        @if(isset($dataManagerPage['dataPage']['information']['web']))
                                            <li><span><i class="fa fa-globe"></i> {{__('labels.twenty-seven')}}  :</span> <a
                                                    href="{{$dataManagerPage['dataPage']['information']['web']}}">{{$dataManagerPage['dataPage']['information']['web']}}</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                @if($dataManagerPage['dataPage']['socialNetwork'])
                                    <div class="list-widget-social">
                                        <ul>
                                            @foreach( $dataManagerPage['dataPage']['socialNetwork'] as $key =>$row)
                                                <li><a href="{{$row->value}}" target="_blank"><i
                                                            class="{{$row->social_network_icon}}"></i></a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="list-single-main-wrapper fl-wrap">
                                <div class="list-single-main-item-title fl-wrap">
                                    <h3>{{__('page.contactUs.variant.map')}}</h3>
                                </div>
                                <div class="map-container">
                                    <div id="singleMap"
                                         data-title="{{$dataManagerPage['dataPage']['information']['name']}}"
                                         data-latitude="{{$dataManagerPage['dataPage']['information']['location']['lat']}}"
                                         data-longitude="{{$dataManagerPage['dataPage']['information']['location']['lng']}}"></div>
                                </div>

                                @if(isset($dataManagerPage['dataPage']['configFormContactUs']['viewFormSection']))

                                    <div class="list-single-main-item-title fl-wrap">
                                        <h3>{{$dataManagerPage['dataPage']['configFormContactUs']['title']}}</h3>
                                    </div>
                                    <div>
                                        <div id="message"></div>
                                        <form class="custom-form" name="contactform"
                                              id="contact-form">
                                            <fieldset>

                                                <label><i class="fa fa-user-o"></i></label>
                                                <input type="text"
                                                       placeholder="{{$dataManagerPage['dataPage']['configFormContactUs']['field1']}}"
                                                       name="customerName"
                                                       id="customername" required>
                                                <label><i class="fa fa-envelope-o"></i> </label>
                                                <input type="email"
                                                       placeholder="{{$dataManagerPage['dataPage']['configFormContactUs']['field2']}}"
                                                       name="customerEmail"
                                                       id="customerEmail" required>
                                                <label><i class="fa fa-file"></i> </label>

                                                <input type="text"
                                                       placeholder="{{$dataManagerPage['dataPage']['configFormContactUs']['field3']}}"
                                                       name="contactSubject"
                                                       id="contactSubject">

                                                <textarea cols="30" rows="10"
                                                          placeholder="{{$dataManagerPage['dataPage']['configFormContactUs']['field4']}}"
                                                          name="contactMessage" id="contactMessage"
                                                          required></textarea>


                                            </fieldset>
                                            <button type="submit" class="btn  big-btn  color-bg btn--custom"
                                                    id="submit">{{$dataManagerPage['dataPage']['configFormContactUs']['buttonSend']}}
                                               </button>
                                        </form>
                                    </div>
                            @endif

                            <!-- contact form  end-->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- section end -->
            <div class="limit-box fl-wrap"></div>
        @if(!Auth::check())
            @include('layouts.partials.cityBook.join')
        @endif
        <!-- section end -->
            <!-- contentend -->

        </div>
    @endif
@endsection
