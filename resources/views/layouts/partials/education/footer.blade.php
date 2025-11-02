@section('footer')

    <footer class="page-footer">
        <div class="hr bg-gray-light"></div>
        <div class="container section-xs block-after-divider">
            <div class="row row-50 justify-content-xl-between justify-content-sm-center">
                <div class="col-lg-3 col-xl-2">
                    <!--Footer brand-->
                    <a class="d-inline-block" href="{{ $dataManagerPage['rootPageCurrent'] }}">
                        @if (isset($dataManagerPage['logoMain']))
                            {{ $dataManagerPage['logoMain'] }}
                        @else
                            <div class="wrap">
                                <img width='170' height='172'
                                    src='{{ asset($resourcePathServer . 'templates/education') }}/images/logo-170x172.png'
                                    alt='' />
                            </div>
                        @endif
                        <div>
                            <p class="brand-slogan text-gray font-italic font-accent"> {{ $business['title'] }}</p>
                        </div>
                    </a>
                </div>
                @if (isset($dataManagerPage['dataSocialNetworkFooterHtml']) || (isset($dataBusiness) && $dataBusiness))
                    <div class="col-sm-10 col-lg-5 col-xl-4 text-xl-left">
                        <h6 class="font-weight-bold text-white">{{ __('frontend.menu.contact-us') }}</h6>
                        <div class="text-subline text-sublime--footer"></div>
                        @if (isset($dataBusiness) && $dataBusiness)
                            <div class="offset-top-30">
                                <ul class="list-unstyled contact-info list">
                                    <li>
                                        <div class="unit flex-row align-items-center unit-spacing-xs">
                                            <div class="unit-left">
                                                <span class="icon mdi mdi-phone text-middle icon-xs text-white"></span>
                                            </div>
                                            <div class="unit-body">
                                                <a class="text-dark text-white" href="tel:+{{$dataBusiness->phone_code }}{{ $dataBusiness->phone_value }}">+{{$dataBusiness->phone_code }}{{ $dataBusiness->phone_value }}</a>

                                            </div>
                                        </div>
                                    </li>
                                    <li class="offset-top-15">
                                        <div class="unit flex-row align-items-center unit-spacing-xs">
                                            <div class="unit-left"><span
                                                    class="icon mdi mdi-map-marker text-middle icon-xs text-white"></span>
                                            </div>
                                            <div class="unit-body text-left"><a class="text-dark text-white" >{{ $dataBusiness->street_1 }} y {{ $dataBusiness->street_2 }}</a></div>
                                        </div>
                                    </li>
                                    <li class="offset-top-15">
                                        <div class="unit flex-row align-items-center unit-spacing-xs">
                                            <div class="unit-left"><span
                                                    class="icon mdi mdi-email-open text-middle icon-xs text-white"></span>
                                            </div>
                                            <div class="unit-body"><a class="text-white" href="mailto:{{ $dataBusiness->email }}">{{ $dataBusiness->email }}</a></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        @endif
                        @if (isset($dataManagerPage['dataSocialNetworkFooterHtml']))
                            {!! $dataManagerPage['dataSocialNetworkFooterHtml'] !!}
                        @endif

                    </div>
                @endif

                <div class="col-sm-10 col-lg-8 col-xl-4 text-xl-left">

                </div>
            </div>
        </div>
        <div class="bg-madison context-dark">
            <div class="container text-lg-left section-5">
                <p class="rights">
                    <span>&copy;&nbsp;&nbsp;</span>
                    <span>{{ env('footerRightOne') }}</span>
                   {{ env('footerRightTwo') }}
                    {{ date('Y') }}
                   </p>
            </div>
        </div>
    </footer>


@endSection
