@extends('layouts.frontend.master-blank')
<?php
$modelUtil = new \App\Utils\UtilUser();
$redirectTo = $modelUtil->getDataEmployerBusiness();

?>
@section('additional-styles')
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

    <div class="breadcrumb-area section-space--breadcrumb">
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


                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div><br>@endif
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div><br>@endif

                            <form action="{{ route('login',app()->getLocale()) }}" method="post"
                                  class="management--form">
                                @csrf

                                <div class="form-group mb-3">
                                    <label for="emailaddress">{{__("frontend.web.customer.login.form.email")}}</label>
                                    <input class="form-control @if($errors->has('email')) is-invalid @endif"
                                           type="email" id="emailaddress" name="email" value="{{ old('email') }}"
                                           placeholder="{{__("frontend.web.customer.login.form.emailHelp")}}" autofocus/>
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
                                            @if(env('allow_login_google'))

                                                <li class="list-inline-item">
                                                    <a href="javascript: void(0);"
                                                       class="social-list-item border-danger text-danger"><i
                                                            class="mdi mdi-google"></i></a>
                                                </li>
                                            @endif
                                            @if(env('allow_login_twitter'))

                                                <li class="list-inline-item">
                                                    <a href="javascript: void(0);"
                                                       class="social-list-item border-info text-info"><i
                                                            class="mdi mdi-twitter"></i></a>
                                                </li>
                                            @endif
                                            @if(env('allow_login_pinterest'))

                                                <li class="list-inline-item">
                                                    <a href="javascript: void(0);"
                                                       class="social-list-item border-secondary text-secondary"><i
                                                            class="mdi mdi-github-circle"></i></a>
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
                                       href="{{ route('password.request',app()->getLocale()) }}">

                                        {{__('frontend.web.customer.login.footer.forgetPassword')}}
                                    </a>
                                @endif
                            </p>
                            <p class="text-muted">
                                {{__('frontend.web.customer.login.footer.registerOne')}}
                                  <a href="{{ route('register',app()->getLocale()) }}"
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
