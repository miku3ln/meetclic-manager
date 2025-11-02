@extends('layouts.frontend.master-blank')

<?php
$modelUtil = new \App\Utils\UtilUser();
$redirectTo = $modelUtil->getDataEmployerBusiness();

?>
@section('additional-scripts')
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            let passwordField = document.getElementById('password');
            let icon = this.querySelector('i');

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    </script>@endsection

@section('content')
    <div class="breadcrumb-area section-space--breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <!--=======  breadcrumb wrapper  =======-->

                    <div class="breadcrumb-wrapper">
                        <h2 class="page-title">{{__("frontend.web.customer.top.topTitle")}} </h2>
                        <ul class="breadcrumb-list">
                            <li><a href="{{$redirectTo}}">{{__("frontend.web.customer.top.topTitleBreadcrumbOne")}}</a></li>
                            <li class="active"> {{__("frontend.web.customer.top.topTitleBreadcrumbTwo")}}</li>
                        </ul>
                    </div>
                    <!--=======  End of breadcrumb wrapper  =======-->
                </div>
            </div>
        </div>
    </div>
    <div class="account-pages mt-7 mb-7">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-7 col-xl-6">
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">

                                <p class="text-muted mb-4 mt-3">{{__("frontend.web.customer.register.title")}}</p>
                            </div>

                            <div class="error">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            @if(session('error'))
                                @if(session('success'))
                                    <div class="alert alert-danger">{{ session('error') }}</div><br>@endif
                                <div class="alert alert-success">{{ session('success') }}</div><br>@endif

                            <form method="POST" action="{{ route('register',app()->getLocale()) }}"
                                  class="management--form">
                                @csrf
                                <div class="row">
                                    <div class="col col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="fullname">{{__("frontend.web.customer.register.form.name")}} <span class="required">*</span></label>
                                            <input class="form-control @if($errors->has('name')) is-invalid @endif"
                                                   type="text"
                                                   name="name" id="name" value="{{ old('name') }}"
                                                   placeholder="{{__("frontend.web.customer.register.form.nameHelp")}}"/>
                                            @if($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('name') }}</strong></span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="last_name">{{__("frontend.web.customer.register.form.lastName")}}  <span class="required">*</span></label>
                                            <input class="form-control @if($errors->has('last_name')) is-invalid @endif"
                                                   type="text"
                                                   name="last_name" id="last_name" value="{{ old('last_name') }}"
                                                   placeholder="{{__("frontend.web.customer.register.form.lastNameHelp")}}"/>
                                            @if($errors->has('last_name'))
                                                <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('last_name') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="people_type_identification_id">{{__("frontend.web.customer.register.form.typeDocument")}}<span
                                                    class="required">*</span></label>
                                            @php
                                                $classCurrent='form-control'.( $errors->has('people_type_identification_id')? 'is-invalid':'' );
                                            @endphp
                                            <select name="people_type_identification_id" class="{{$classCurrent}}">


                                                    @php
                                                        foreach ($configPartial['identificationData'] as $key => $value) {
            echo '  <option value="'.$key.'"> '.$value.' </option>';
        }
                                                    @endphp
                                            </select>

                                            @if($errors->has('people_type_identification_id'))
                                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('people_type_identification_id') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="identification_document"># {{__("frontend.web.customer.register.form.document")}} <span
                                                    class="required">*</span></label>
                                            <input
                                                class="form-control @if($errors->has('identification_document')) is-invalid @endif"
                                                type="text"
                                                name="identification_document" id="last_name"
                                                value="{{ old('identification_document') }}"
                                                placeholder="{{__("frontend.web.customer.register.form.documentHelp")}}"/>
                                            @if($errors->has('identification_document'))
                                                <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('identification_document') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="gender">{{__("frontend.web.customer.register.form.gender")}}  <span class="required">*</span></label>
                                            @php
                                                $classCurrent='form-control'.( $errors->has('gender')? 'is-invalid':'' );
                                            @endphp
                                            <select name="gender" class="{{$classCurrent}}">
                                                @php
                                                    foreach ($configPartial['genderData'] as $key => $value) {
        echo '  <option value="'.$key.'"> '.$value.' </option>';
    }
                                                @endphp


                                            </select>
                                            @if($errors->has('gender'))
                                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('gender') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="birthdate">{{__("frontend.web.customer.register.form.dateBorn")}}   <span
                                                    class="required">*</span></label>
                                            <input class="form-control @if($errors->has('birthdate')) is-invalid @endif"
                                                   type="date"
                                                   name="birthdate" id="birthdate" value="{{ old('birthdate') }}"
                                                   placeholder="{{__("frontend.web.customer.register.form.dateBornHelp")}}"/>
                                            @if($errors->has('birthdate'))
                                                <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('birthdate') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="mobile">{{__("frontend.web.customer.register.form.mobilNumber")}}  <span class="required">*</span></label>
                                            <input class="form-control @if($errors->has('mobile')) is-invalid @endif"
                                                   type="text"
                                                   name="mobile" id="mobile" value="{{ old('mobile') }}"
                                                   placeholder="{{__("frontend.web.customer.register.form.mobilNumberHelp")}}"/>
                                            @if($errors->has('mobile'))
                                                <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('mobile') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="emailaddress">{{__("frontend.web.customer.register.form.email")}} <span
                                                    class="required">*</span></label>
                                            <input class="form-control @if($errors->has('email')) is-invalid @endif"
                                                   type="email" id="emailaddress" name="email"
                                                   value="{{ old('email') }}"
                                                   placeholder="{{__("frontend.web.customer.register.form.emailHelp")}}"/>
                                            @if($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col col-md-12 col-xs-12">
                                        <div class="form-group position-relative">
                                            <label for="password">{{__("frontend.web.customer.register.form.password")}} <span class="required">*</span></label>
                                            <div class="input-group">
                                                <input class="form-control @if($errors->has('password')) is-invalid @endif"
                                                       type="password" name="password" id="password"
                                                       placeholder="{{__("frontend.web.customer.register.form.passwordHelp")}}"/>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @if($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group mt-3 mb-0 text-center">
                                    <button class="btn btn-primary btn-block" type="submit"> {{__("frontend.web.customer.register.form.register")}}</button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">{{__("frontend.web.customer.register.footer.registerOne")}}<a href="login" class="font-weight-medium ml-1">
                                    {{__("frontend.web.customer.register.footer.registerTwo")}}
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
    <!-- end page -->

@endsection
