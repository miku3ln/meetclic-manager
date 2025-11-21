@extends('layouts.cityBook')
@section('additional-styles')

@endsection
@section('additional-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.js"></script>

    <script>
        $(function () {

            $('.show-search-button').show();
            $('.main-footer').addClass('not-view');

            var finalDate = '2026/04/04 23:59:59';

            $('.countdown').countdown(finalDate, function(event) {
                $(this).find('.days').text(event.strftime('%D'));
                $(this).find('.hours').text(event.strftime('%H'));
                $(this).find('.minutes').text(event.strftime('%M'));
                $(this).find('.seconds').text(event.strftime('%S'));
            });
        })

    </script>
@endsection
@section('content')
    <div id="app-management" class="comming-soon">

        <!--wrapper -->
        <div class="fixed-bg">
            <div class="bg" data-bg="{{ URL::asset($themePath.'images/bg/27.jpg')}}"></div>
            <div class="overlay"></div>
            <div class="bubble-bg"></div>
        </div>
        <!-- cs-wrapper -->
        <div class="cs-wrapper fl-wrap">
            <!-- container  -->
            <div class="container small-container counter-widget" data-countDate="{{env('lauching') }}">
                <div class="cs-logo not-view"><img src="{{ URL::asset($themePath.'images/logo.png')}}" alt=""></div>
                <span class="section-separator"></span>
                <h3 class="soon-title not-view">Our website is coming soon!</h3>
                <!-- countdown -->
                <div class="countdown fl-wrap">
                    <div class="cs-countdown-item">
                        <span class="days rot">00</span>
                        <p>{{__('coming-soon.one')}}</p>
                    </div>
                    <div class="cs-countdown-item">
                        <span class="hours rot">00</span>
                        <p>{{__('coming-soon.two')}} </p>
                    </div>
                    <div class="cs-countdown-item no-dec">
                        <span class="minutes rot2">00</span>
                        <p>{{__('coming-soon.three')}} </p>
                    </div>
                    <div class="cs-countdown-item">
                        <span class="seconds rot2">00</span>
                        <p>{{__('coming-soon.four')}}</p>
                    </div>
                </div>
                <!-- countdown end -->
                <div class="subcribe-form fl-wrap not-view">
                    <p>Sign up now to our newsletter and you will be one of the first know
                        when our new website as ready
                    </p>
                    <form id="subscribe">
                        <input class="enteremail" name="email" id="subscribe-email" placeholder="Email"
                               spellcheck="false" type="text">
                        <button type="submit" id="subscribe-button" class="subscribe-button color-bg"><i
                                class="fa fa-rss"></i> Subscribe
                        </button>
                        <label for="subscribe-email" class="subscribe-message"></label>
                    </form>
                </div>
                <!-- cs-social -->
                <div class="cs-social fl-wrap not-view">
                    <ul>
                        <li><a href="#" target="_blank"><i class="fa fa-facebook-official"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-chrome"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-vk"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                    </ul>
                </div>
                <!-- cs-social end -->
            </div>
            <!-- container end -->
        </div>
    </div>

@endsection
