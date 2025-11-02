@extends('layouts.frontend.master-blank')

<?php
$modelUtil = new \App\Utils\UtilUser();
$redirectTo = $modelUtil->getDataEmployerBusiness();

?>
@section('content')
    <div class="breadcrumb-area section-space--breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <!--=======  breadcrumb wrapper  =======-->

                    <div class="breadcrumb-wrapper">
                        <h2 class="page-title">Forget</h2>
                        <ul class="breadcrumb-list">
                            <li><a href="{{$redirectTo}}">Inicio</a></li>
                            <li class="active"> Recuperar Contraseña</li>
                        </ul>
                    </div>
                    <!--=======  End of breadcrumb wrapper  =======-->
                </div>
            </div>
        </div>
    </div>
<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <a href="/">
                                <span><img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="22"></span>
                            </a>
                            <p class="text-muted mb-4 mt-3">@lang('auth.password.reset.message.1')</p>
                        </div>
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <form action="{{ route('password.email',app()->getLocale()) }}" method="post"  class="management--form">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="emailaddress">Email address</label>
                                <input class="form-control @if($errors->has('email')) is-invalid @endif" name="email" type="email" id="emailaddress" placeholder="Enter your email">
                                @if($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block" type="submit"> Reset Password </button>
                            </div>
                        </form>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-muted">Back to <a href="{{route('login', app()->getLocale())}}" class="text-muted font-weight-medium ml-1">Log in</a></p>
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
