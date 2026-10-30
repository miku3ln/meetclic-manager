@extends('layouts.cityBook')

@section('additional-styles')
    <style>
        /* Mejoras aisladas: conserva los estilos y el timeline de CityBook */
        .yapita-how__eyebrow { display:inline-block; margin-bottom:15px; color:#f5b64b; font-size:13px; font-weight:700; letter-spacing:1.8px; text-transform:uppercase; }
        .yapita-how__hero-copy { max-width:740px; margin:18px auto 0; color:#fff; font-size:17px; line-height:1.7; }
        .yapita-how__hero-actions { display:flex; justify-content:center; gap:12px; flex-wrap:wrap; margin-top:24px; }
        .yapita-how__button { display:inline-flex; align-items:center; justify-content:center; gap:9px; min-height:46px; padding:12px 23px; border-radius:28px; background:#f6b73c; color:#232323 !important; font-size:14px; font-weight:700; text-decoration:none !important; transition:transform .2s ease,background .2s ease; }
        .yapita-how__button:hover { background:#ffd074; transform:translateY(-2px); }
        .yapita-how__button--outline { background:transparent; border:1px solid rgba(255,255,255,.8); color:#fff !important; }
        .yapita-how__button--outline:hover { background:rgba(255,255,255,.14); }
        .yapita-how__intro { max-width:850px; margin:0 auto 48px; text-align:center; }
        .yapita-how__intro h2 { font-size:30px; margin-bottom:18px; }
        .yapita-how__intro p { font-size:16px; line-height:1.85; }
        .yapita-how__section { padding-top:70px; padding-bottom:70px; }
        .yapita-how__step-text { line-height:1.85; }
        .yapita-how__step-note { display:block; margin-top:15px; font-size:13px; font-weight:700; color:#d18a17; }
        .yapita-how__image { max-width:100%; height:auto; }
        .yapita-how__values { padding:65px 0; background:#f7f8fa; }
        .yapita-how__values-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:22px; margin-top:30px; }
        .yapita-how__value { background:#fff; border-radius:14px; padding:30px 24px; box-shadow:0 8px 25px rgba(0,0,0,.045); text-align:center; }
        .yapita-how__value i { font-size:32px; color:#e5a12a; margin-bottom:18px; }
        .yapita-how__value h3 { font-size:19px; margin-bottom:13px; }
        .yapita-how__value p { font-size:14px; line-height:1.8; }
        .yapita-how__cta { padding:65px 0; text-align:center; background:#263d45; color:#fff; }
        .yapita-how__cta h2 { color:#fff; font-size:30px; margin-bottom:14px; }
        .yapita-how__cta p { color:#e9f0f2; max-width:690px; margin:0 auto 24px; line-height:1.8; }
        .yapita-how__faq .accordion-inner p { line-height:1.8; }
        @media(max-width:767px) {
            .yapita-how__section { padding-top:45px; padding-bottom:45px; }
            .yapita-how__hero-copy { font-size:14px; }
            .yapita-how__values-grid { grid-template-columns:1fr; }
            .yapita-how__intro h2,.yapita-how__cta h2 { font-size:25px; }
            .yapita-how__value { padding:25px 20px; }
        }
        @media(prefers-reduced-motion:reduce) { .yapita-how__button { transition:none; } }
        /* ================================================
   YAPITA - COMMUNITY VALUES
   ================================================ */

        #yapita-community {
            position: relative;
            display: block;
            width: 100%;
            padding: 80px 0;
            background: #f8fafc;
            overflow: hidden;
        }

        /* ================================================
           GRID
           ================================================ */

        #yapita-community .yapita-how__values-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
            width: 100%;
            margin-top: 45px;
            align-items: stretch;
        }

        /* ================================================
           CARD
           ================================================ */

        #yapita-community .yapita-how__value {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;

            min-width: 0;
            width: 100%;
            height: 100%;

            padding: 35px 25px;

            background: #ffffff;
            border: 1px solid #e8edf3;
            border-radius: 18px;

            text-align: center;

            box-shadow: 0 8px 28px rgba(15, 23, 42, 0.05);

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                border-color 0.25s ease;

            box-sizing: border-box;
        }

        #yapita-community .yapita-how__value:hover {
            transform: translateY(-6px);
            border-color: #f4c66a;
            box-shadow: 0 14px 35px rgba(15, 23, 42, 0.10);
        }

        /* ================================================
           ICON
           ================================================ */

        #yapita-community .yapita-how__value-icon {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 76px;
            height: 76px;

            margin: 0 auto 24px;

            background: #fff4dc;
            border-radius: 22px;

            flex-shrink: 0;
        }

        #yapita-community .yapita-how__value-icon i {
            display: block;
            font-size: 32px;
            line-height: 1;
            color: #e9a522;
        }

        /* ================================================
           CONTENT
           ================================================ */

        #yapita-community .yapita-how__value-content {
            display: flex;
            flex-direction: column;
            align-items: center;

            width: 100%;
            min-width: 0;
        }

        #yapita-community .yapita-how__value-content h3 {
            display: block;
            width: 100%;

            margin: 0 0 15px;
            padding: 0;

            font-size: 20px;
            font-weight: 700;
            line-height: 1.4;

            color: #1e293b;
            text-align: center;
        }

        #yapita-community .yapita-how__value-content p {
            display: block;
            width: 100%;

            margin: 0;
            padding: 0;

            font-size: 15px;
            font-weight: 400;
            line-height: 1.8;

            color: #64748b;
            text-align: center;
        }

        /* ================================================
           TABLET
           ================================================ */

        @media (max-width: 991px) {

            #yapita-community {
                padding: 65px 0;
            }

            #yapita-community .yapita-how__values-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 20px;
            }

            #yapita-community .yapita-how__value {
                padding: 30px 22px;
            }

        }

        /* ================================================
           MOBILE
           ================================================ */

        @media (max-width: 767px) {

            #yapita-community {
                padding: 50px 0;
            }

            #yapita-community .yapita-how__values-grid {
                grid-template-columns: minmax(0, 1fr);
                gap: 16px;
                margin-top: 30px;
            }

            #yapita-community .yapita-how__value {
                padding: 28px 22px;
                border-radius: 16px;
            }

            #yapita-community .yapita-how__value-icon {
                width: 68px;
                height: 68px;
                margin-bottom: 18px;
            }

            #yapita-community .yapita-how__value-icon i {
                font-size: 28px;
            }

            #yapita-community .yapita-how__value-content h3 {
                font-size: 19px;
            }

            #yapita-community .yapita-how__value-content p {
                font-size: 14px;
                line-height: 1.7;
            }

        }

        /* ================================================
           SMALL MOBILE
           ================================================ */

        @media (max-width: 375px) {

            #yapita-community .yapita-how__value {
                padding: 24px 18px;
            }

            #yapita-community .yapita-how__value-content h3 {
                font-size: 18px;
            }

        }
    </style>
@endsection

@section('additional-scripts')
    <script>
        $(function () {
            $('.show-search-button').show();
        });
    </script>
@endsection

@section('content-manager')
    <div class="content full-height fs-slider-wrap">
        <section class="hero-section no-dadding full-height hero-section--item" id="sec1">
            <div class="slider-container-wrap full-height fs-slider fl-wrap">
                <div class="slider-container">
                    <div class="slider-item fl-wrap">
                        <div class="bg" data-bg="{{ URL::asset($themePath.'images/bg/41.png') }}"></div>
                        <div class="overlay"></div>
                        <div class="hero-section-wrap fl-wrap">
                            <div class="container">
                                <div class="intro-item fl-wrap">
                                    <span class="yapita-how__eyebrow">{{ __('frontend.how-it-works.hero.eyebrow') }}</span>
                                    <h1 class="intro-item__title">{{ __('frontend.how-it-works.hero.title') }}</h1>
                                    <p class="yapita-how__hero-copy">{{ __('frontend.how-it-works.hero.description') }}</p>
                                    <div class="yapita-how__hero-actions">
                                        <a class="yapita-how__button custom-scroll-link" href="#section-customers"><i class="fa fa-map-signs" aria-hidden="true"></i> {{ __('frontend.how-it-works.hero.explore') }}</a>
                                        <a class="yapita-how__button yapita-how__button--outline custom-scroll-link" href="#sec2">{{ __('frontend.how-it-works.hero.business') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-sec-link">
                <div class="container"><a href="#yapita-intro" class="custom-scroll-link">{{ __('frontend.how-it-works.hero.discover') }} <i class="fa fa-angle-down" aria-hidden="true"></i></a></div>
            </div>
        </section>
    </div>
@endsection

@section('content')
    <div id="app-management" class="yapita-how">
        <section id="yapita-intro" class="yapita-how__section">
            <div class="container">
                <div class="yapita-how__intro">
                    <span class="yapita-how__eyebrow">{{ __('frontend.how-it-works.intro.eyebrow') }}</span>
                    <h2>{{ __('frontend.how-it-works.intro.title') }}</h2>
                    <p>{{ __('frontend.how-it-works.intro.paragraph1') }}</p>
                    <p>{{ __('frontend.how-it-works.intro.paragraph2') }}</p>
                </div>
            </div>
        </section>

        <section id="section-customers" class="yapita-how__section">
            <div class="container">
                <div class="section-title">
                    <h2>{{ __('frontend.how-it-works.customers.title') }}</h2>
                    <div class="section-subtitle">{{ __('frontend.how-it-works.customers.subtitle') }}</div>
                    <span class="section-separator"></span>
                    <p>{{ __('frontend.how-it-works.customers.description') }}</p>
                </div>
                <div class="time-line-wrap fl-wrap">
                    <div class="time-line-container">
                        <div class="step-item">{{ __('frontend.how-it-works.common.step') }} 1</div>
                        <div class="time-line-box tl-text tl-left">
                            <span class="process-count">01 .</span>
                            <div class="time-line-icon"><i class="fa fa-map-o" aria-hidden="true"></i></div>
                            <h3 class="tl-text--title">{{ __('frontend.how-it-works.customers.steps.explore.title') }}</h3>
                            <p class="yapita-how__step-text">{{ __('frontend.how-it-works.customers.steps.explore.description') }}</p>
                            <span class="yapita-how__step-note">{{ __('frontend.how-it-works.customers.steps.explore.note') }}</span>
                        </div>
                        <div class="time-line-box tl-media tl-right"><img class="yapita-how__image" src="{{ URL::asset($themePath.'images/bg/45.png') }}" alt="{{ __('frontend.how-it-works.customers.steps.explore.alt') }}" loading="lazy"></div>
                    </div>
                    <div class="time-line-container lf-im">
                        <div class="step-item">{{ __('frontend.how-it-works.common.step') }} 2</div>
                        <div class="time-line-box tl-text tl-right">
                            <span class="process-count">02 .</span>
                            <div class="time-line-icon"><i class="fa fa-handshake-o" aria-hidden="true"></i></div>
                            <h3 class="tl-text--title">{{ __('frontend.how-it-works.customers.steps.participate.title') }}</h3>
                            <p class="yapita-how__step-text">{{ __('frontend.how-it-works.customers.steps.participate.description') }}</p>
                            <span class="yapita-how__step-note">{{ __('frontend.how-it-works.customers.steps.participate.note') }}</span>
                        </div>
                        <div class="time-line-box tl-media tl-left"><img class="yapita-how__image" src="{{ URL::asset($themePath.'images/bg/46.png') }}" alt="{{ __('frontend.how-it-works.customers.steps.participate.alt') }}" loading="lazy"></div>
                    </div>
                    <div class="time-line-container">
                        <div class="step-item">{{ __('frontend.how-it-works.common.step') }} 3</div>
                        <div class="time-line-box tl-text tl-left">
                            <span class="process-count">03 .</span>
                            <div class="time-line-icon"><i class="fa fa-trophy" aria-hidden="true"></i></div>
                            <h3 class="tl-text--title">{{ __('frontend.how-it-works.customers.steps.earn.title') }}</h3>
                            <p class="yapita-how__step-text">{{ __('frontend.how-it-works.customers.steps.earn.description') }}</p>
                            <span class="yapita-how__step-note">{{ __('frontend.how-it-works.customers.steps.earn.note') }}</span>
                        </div>
                        <div class="time-line-box tl-media tl-right"><img class="yapita-how__image" src="{{ URL::asset($themePath.'images/bg/47.png') }}" alt="{{ __('frontend.how-it-works.customers.steps.earn.alt') }}" loading="lazy"></div>
                    </div>
                    <div class="time-line-container lf-im">
                        <div class="step-item">{{ __('frontend.how-it-works.common.step') }} 4</div>
                        <div class="time-line-box tl-text tl-right">
                            <span class="process-count">04 .</span>
                            <div class="time-line-icon"><i class="fa fa-gift" aria-hidden="true"></i></div>
                            <h3 class="tl-text--title">{{ __('frontend.how-it-works.customers.steps.redeem.title') }}</h3>
                            <p class="yapita-how__step-text">{{ __('frontend.how-it-works.customers.steps.redeem.description') }}</p>
                            <span class="yapita-how__step-note">{{ __('frontend.how-it-works.customers.steps.redeem.note') }}</span>
                        </div>
                        <div class="time-line-box tl-media tl-left"><img class="yapita-how__image" src="{{ URL::asset($themePath.'images/bg/47.png') }}" alt="{{ __('frontend.how-it-works.customers.steps.redeem.alt') }}" loading="lazy"></div>
                    </div>
                    <div class="timeline-end"><i class="fa fa-check" aria-hidden="true"></i></div>
                </div>
            </div>
        </section>

        <section id="sec2" class="yapita-how__section gray-bg">
            <div class="container">
                <div class="section-title">
                    <h2>{{ __('frontend.how-it-works.business.title') }}</h2>
                    <div class="section-subtitle">{{ __('frontend.how-it-works.business.subtitle') }}</div>
                    <span class="section-separator"></span>
                    <p>{{ __('frontend.how-it-works.business.description') }}</p>
                </div>
                <div class="time-line-wrap fl-wrap">
                    <div class="time-line-container">
                        <div class="step-item">{{ __('frontend.how-it-works.common.step') }} 1</div>
                        <div class="time-line-box tl-text tl-left">
                            <span class="process-count">01 .</span>
                            <div class="time-line-icon"><i class="fa fa-building-o" aria-hidden="true"></i></div>
                            <h3 class="tl-text--title">{{ __('frontend.how-it-works.business.steps.join.title') }}</h3>
                            <p class="yapita-how__step-text">{{ __('frontend.how-it-works.business.steps.join.description') }}</p>
                        </div>
                        <div class="time-line-box tl-media tl-right"><img class="yapita-how__image" src="{{ URL::asset($themePath.'images/bg/42.png') }}" alt="{{ __('frontend.how-it-works.business.steps.join.alt') }}" loading="lazy"></div>
                    </div>
                    <div class="time-line-container lf-im">
                        <div class="step-item">{{ __('frontend.how-it-works.common.step') }} 2</div>
                        <div class="time-line-box tl-text tl-right">
                            <span class="process-count">02 .</span>
                            <div class="time-line-icon"><i class="fa fa-gears" aria-hidden="true"></i></div>
                            <h3 class="tl-text--title">{{ __('frontend.how-it-works.business.steps.tools.title') }}</h3>
                            <p class="yapita-how__step-text">{{ __('frontend.how-it-works.business.steps.tools.description') }}</p>
                        </div>
                        <div class="time-line-box tl-media tl-left"><img class="yapita-how__image" src="{{ URL::asset($themePath.'images/bg/43.png') }}" alt="{{ __('frontend.how-it-works.business.steps.tools.alt') }}" loading="lazy"></div>
                    </div>
                    <div class="time-line-container">
                        <div class="step-item">{{ __('frontend.how-it-works.common.step') }} 3</div>
                        <div class="time-line-box tl-text tl-left">
                            <span class="process-count">03 .</span>
                            <div class="time-line-icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                            <h3 class="tl-text--title">{{ __('frontend.how-it-works.business.steps.grow.title') }}</h3>
                            <p class="yapita-how__step-text">{{ __('frontend.how-it-works.business.steps.grow.description') }}</p>
                        </div>
                        <div class="time-line-box tl-media tl-right"><img class="yapita-how__image" src="{{ URL::asset($themePath.'images/bg/44.png') }}" alt="{{ __('frontend.how-it-works.business.steps.grow.alt') }}" loading="lazy"></div>
                    </div>
                    <div class="timeline-end"><i class="fa fa-check" aria-hidden="true"></i></div>
                </div>
                <div class="yapita-how__hero-actions"><a href="{{ route('business', app()->getLocale()) }}" class="yapita-how__button">{{ __('frontend.how-it-works.business.button') }}</a></div>
            </div>
        </section>

        <section id="yapita-community" class="yapita-how__values">
            <div class="container">

                <div class="section-title">
                    <h2>{{ __('frontend.how-it-works.community.title') }}</h2>

                    <div class="section-subtitle">
                        {{ __('frontend.how-it-works.community.subtitle') }}
                    </div>

                    <span class="section-separator"></span>

                    <p>
                        {{ __('frontend.how-it-works.community.description') }}
                    </p>
                </div>

                <div class="yapita-how__values-grid">

                    <!-- EMPRESAS -->
                    <div class="yapita-how__value">

                        <div class="yapita-how__value-icon">
                            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                        </div>

                        <div class="yapita-how__value-content">
                            <h3>{{ __('frontend.how-it-works.community.business.title') }}</h3>

                            <p>
                                {{ __('frontend.how-it-works.community.business.description') }}
                            </p>
                        </div>

                    </div>

                    <!-- CHASKIS -->
                    <div class="yapita-how__value">

                        <div class="yapita-how__value-icon">
                            <i class="fa fa-map-signs" aria-hidden="true"></i>
                        </div>

                        <div class="yapita-how__value-content">
                            <h3>{{ __('frontend.how-it-works.community.chaskis.title') }}</h3>

                            <p>
                                {{ __('frontend.how-it-works.community.chaskis.description') }}
                            </p>
                        </div>

                    </div>

                    <!-- COMUNIDAD -->
                    <div class="yapita-how__value">

                        <div class="yapita-how__value-icon">
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        </div>

                        <div class="yapita-how__value-content">
                            <h3>{{ __('frontend.how-it-works.community.growth.title') }}</h3>

                            <p>
                                {{ __('frontend.how-it-works.community.growth.description') }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>
        </section>

        <section id="sec4" class="gray-bg yapita-how__section yapita-how__faq">
            <div class="container">
                <div class="section-title"><h2>{{ __('frontend.how-it-works.faq.title') }}</h2><div class="section-subtitle">{{ __('frontend.how-it-works.faq.subtitle') }}</div><span class="section-separator"></span><p>{{ __('frontend.how-it-works.faq.description') }}</p></div>
                @php
                    $yapitaFaqKeys = ['what', 'chaski', 'coins', 'earn', 'redeem', 'promotions', 'businesses', 'help', 'marketplace', 'join'];
                    $yapitaFaqs = array_map(function ($key) {
                        return [
                            __('frontend.how-it-works.faq.items.' . $key . '.question'),
                            __('frontend.how-it-works.faq.items.' . $key . '.answer'),
                        ];
                    }, $yapitaFaqKeys);
                @endphp
                <div class="row">
                    @foreach(array_chunk($yapitaFaqs, 5) as $columnIndex => $questions)
                        <div class="col-md-6">
                            <div class="accordion">
                                @foreach($questions as $index => $faq)
                                    <a class="toggle {{ $index === 0 ? 'act-accordion' : '' }}" href="#">{{ $faq[0] }} <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                    <div class="accordion-inner {{ $index === 0 ? 'visible' : '' }}"><p>{{ $faq[1] }}</p></div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="yapita-how__cta" id="yapita-start">
            <div class="container">
                <h2>{{ __('frontend.how-it-works.cta.title') }}</h2>
                <p>{{ __('frontend.how-it-works.cta.description') }}</p>
                <a href="#section-customers" class="yapita-how__button custom-scroll-link"><i class="fa fa-compass" aria-hidden="true"></i> {{ __('frontend.how-it-works.cta.button') }}</a>
            </div>
        </section>

        @if(!Auth::check())
            @include('layouts.partials.cityBook.join')
        @endif
        <div class="limit-box"></div>
    </div>
@endsection

