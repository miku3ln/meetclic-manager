@extends('layouts.frontend.master-blank')

@section('data-modal')
    @include('partials.auth.modals.reward-modal')


@endsection
<?php
$modelUtil = new \App\Utils\UtilUser();
$redirectTo = $modelUtil->getDataEmployerBusiness();
$rootUrlRegister = route("homePage") . "/" . app()->getLocale() . "/register";
$rootUrlLogin = route("homePage") . "/" . app()->getLocale() . "/login";
$rootUrlResetPassword = route("homePage") . "/" . app()->getLocale() . "/password/reset";

?>
@section('additional-scripts')
    @include('partials.auth.social-network.reward-modal-util')
    @include('partials.auth.social-network.social-network')

    <script src="https://accounts.google.com/gsi/client"
            async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ==========================================
        // YAPITA - SOCIAL NETWORK CONFIGURATION
        // ==========================================

        window.SocialNetworkConfig = {
            google: {
                enabled: true,
                clientId: @json(config('services.google_modal_register.client_id')),
                endpoint: @json(url('/auth/google/modal'))
            },

            facebook: {
                enabled: false,
                appId: null,
                apiVersion: null,
                endpoint: null
            },

            server: {
                enabled: false,
                endpoint: null
            }
        };

        // ==========================================
        // GOOGLE LOGIN INITIALIZATION
        // ==========================================

        async function initGoogleLoginButton() {

            const container = document.getElementById(
                'yapita-google-login'
            );

            if (!container) {
                console.error(
                    '[Google Login] Contenedor no encontrado'
                );
                return;
            }

            const config = window.SocialNetworkConfig.google;

            if (!config.clientId) {
                console.error(
                    '[Google Login] Client ID no configurado'
                );
                return;
            }

            try {

                await SocialNetworkLoginUtil.renderGoogleButton(
                    '#yapita-google-login',
                    {
                        type: 'standard',
                        theme: 'outline',
                        size: 'large',
                        text: 'continue_with',
                        shape: 'pill',
                        logo_alignment: 'left'
                    }
                );

                console.log(
                    '[Google Login] Botón renderizado'
                );

            } catch (error) {

                console.error(
                    '[Google Login] Error:',
                    error
                );

            }
        }

        // ==========================================
        // SOCIAL AUTH EVENTS
        // ==========================================

        function initSocialLoginEvents() {
            YapitaRewardModalUtil.init();
            // ==========================================
            // AUTH SUCCESS
            // ==========================================
// ==========================================
// YAPITA - SOCIAL AUTH SUCCESS
// ==========================================

            $(document)
                .off('social:auth:success.maskana')
                .on('social:auth:success.maskana', function (event, detail) {

                    const { provider, response } = detail || {};

                    // ==========================================
                    // 1. VALIDAR AUTENTICACIÓN
                    // ==========================================

                    if (response?.success !== true) {
                        return;
                    }

                    console.log(
                        '[Social Login] Autenticación correcta:',
                        provider,
                        response
                    );

                    // ==========================================
                    // 2. OBTENER INFORMACIÓN
                    // ==========================================

                    const user = response?.data?.user;

                    const gamification = response?.data?.gamification;

                    const isCreate = user?.isCreate === true;

                    const rewardSuccess =
                        gamification?.success === true &&
                        gamification?.data?.reward?.success === true;

                    // ==========================================
                    // 3. USUARIO EXISTENTE
                    // ==========================================

                    if (!isCreate || !rewardSuccess) {

                        window.location.reload();
                        return;
                    }
                    YapitaRewardModalUtil.show(response);


                });


            // ==========================================
            // AUTH ERROR
            // ==========================================
            $(document)
                .off('social:auth:error.maskana')
                .on('social:auth:error.maskana', function (event, detail) {

                    console.error('[Social Login] Error:', detail);

                    alert(
                        detail.message ||
                        'No se pudo iniciar sesión. Inténtalo nuevamente.'
                    );
                });
        }

        // ==========================================
        // DOCUMENT READY
        // ==========================================

        $(document).ready(async function () {

            try {

                SocialNetworkLoginUtil.init(
                    window.SocialNetworkConfig
                );

                initSocialLoginEvents();

                await initGoogleLoginButton();

            } catch (error) {

                console.error(
                    '[Social Login] Error de inicialización:',
                    error
                );

            }

        });
    </script>

@endsection
@section('additional-styles')
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    @include('partials.auth.modals.modal-manager-reward')

    <style>
        div#yapita-google-login {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            min-height: 44px;
            margin: 0 auto;
        }
    </style>
    <style>
        .list-inline {
            padding-left: 0;
            list-style: none;
        }

        .quickview-social-icons li {
            display: inline-block;
            margin-right: 20px;
        }

        span.page-title__one-span {
            color: #445EF2;
        }

        span.page-title__two-span {
            color: #FACC39;
        }

        .account-pages--business {

        }

        .breadcrumb-list__link a {
            color: #FACC39 !important;;

        }

        .breadcrumb-list__active {
            color: #445EF2 !important;

        }
    </style>
@endsection
@section('content')

    <div class="breadcrumb-area section-space--breadcrumb" id="manager-customer-login">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <!--=======  breadcrumb wrapper  =======-->

                    <div class="breadcrumb-wrapper">
                        <h2 class="page-title page-title--business">
                            <span class="page-title__one-span">{{env('titleLoginOne')}}</span> <span
                                class="page-title__two-span">{{env('titleLoginTwo')}}</span>
                        </h2>
                        <ul class="breadcrumb-list breadcrumb-list--business">
                            <li class="breadcrumb-list__link"><a href="{{$redirectTo}}">{{__('labels.ten')}}</a></li>
                            <li class="breadcrumb-list__active active">{{__("frontend.web.customer.login.topTitleBreadcrumb")}}</li>
                        </ul>
                    </div>
                    <!--=======  End of breadcrumb wrapper  =======-->
                </div>
            </div>
        </div>
    </div>

    <div class="account-pages account-pages--business">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-body p-4">
                            @if(session('status'))
                                <div class="alert alert-info">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div><br>
                            @endif
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div><br>
                            @endif

                            <form action="{{$rootUrlLogin}}" method="post"
                                  class="management--form">
                                @csrf

                                <div class="form-group mb-3">
                                    <label for="emailaddress">{{__("frontend.web.customer.login.form.email")}}</label>
                                    <input class="form-control @if($errors->has('email')) is-invalid @endif"
                                           type="email" id="emailaddress" name="email" value="{{ old('email') }}"
                                           placeholder="{{__("frontend.web.customer.login.form.emailHelp")}}"
                                           autofocus/>
                                    @if($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">{{__("frontend.web.customer.login.form.password")}}</label>
                                    <input class="form-control @if($errors->has('password')) is-invalid @endif"
                                           type="password" name="password" id="password"
                                           placeholder="{{__('frontend.web.customer.login.form.passwordHelp')}}">
                                    @if($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                    @endif
                                </div>

                                <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input"
                                               id="checkbox-signin" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label"
                                               for="checkbox-signin">{{__("frontend.web.customer.login.form.remember")}}</label>
                                    </div>
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary btn-block"
                                            type="submit">{{__("frontend.web.customer.login.topTitleBreadcrumb")}}</button>
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <div class="col-xs-12">
                                        <div
                                            id="yapita-google-login"
                                            class="yapita-register-social__google"
                                            data-social-loading-target="google"
                                        ></div>
                                    </div>
                                </div>
                                @if($allowManagementLoginNetworkSocial)
                                    <div class="text-center">
                                        <h5 class="mt-3 text-muted">
                                            {{__('labels.eleven')}}
                                        </h5>

                                        <ul class="quickview-social-icons">
                                            @if(env('allow_login_facebook'))
                                                <li><a href="{{route('fblogin')}}"><i class="fa fa-facebook"></i></a>
                                                </li>
                                            @endif
                                            @if(env('allow_login_twitter'))
                                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            @endif
                                            @if(env('allow_login_google'))
                                                <li><a href="{{route('googleLogin')}}"><i class="fa fa-google-plus"></i></a>
                                                </li>
                                            @endif
                                            @if(env('allow_login_pinterest'))
                                                <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                            @endif
                                        </ul>
                                        <ul class="social-list list-inline mt-3 mb-0">
                                            @if(env('allow_login_facebook'))
                                                <li class="list-inline-item">
                                                    <a href="javascript: void(0);"
                                                       class="social-list-item border-primary text-primary"><i
                                                            class="mdi mdi-facebook"></i></a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                            </form>


                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p>
                                @if (Route::has('password.request'))
                                    <a class="text-muted ml-1"
                                       href="{{$rootUrlResetPassword}}">

                                        {{__('frontend.web.customer.login.footer.forgetPassword')}}
                                    </a>
                                @endif
                            </p>
                            <p class="text-muted">
                                {{__('frontend.web.customer.login.footer.registerOne')}}
                                <a href="{{$rootUrlRegister }}"
                                   class="text-primary font-weight-medium ml-1">

                                    {{__('frontend.web.customer.login.footer.registerTwo')}}

                                </a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

@endsection
