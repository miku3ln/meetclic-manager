<!-- BUSINESS-MANAGER-TEMPLATE-HEADER -->

<?php

$user = Auth::user();
?>
    <!-- Topbar Start -->
<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">
        @if(env('allowManagerSearchBackend'))
            <li class="d-none d-sm-block">
                <form class="app-search">
                    <div class="app-search-box">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search...">
                            <div class="input-group-append">
                                <button class="btn" type="submit">
                                    <i class="fe-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </li>
        @endif
        @if(env('allowManagerLanguageBackend'))
            <li class="dropdown d-none d-lg-block">
                <a class="nav-link dropdown-toggle mr-0 waves-effect waves-light" data-toggle="dropdown" href="#"
                   role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ URL::asset($resourcePathServer.'assets/images/flags/us.jpg') }}" alt="user-image"
                         class="mr-1" height="12"> <span class="align-middle">English <i
                            class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <img src="{{ URL::asset($resourcePathServer.'assets/images/flags/germany.jpg') }}"
                             alt="user-image"
                             class="mr-1" height="12"> <span class="align-middle">German</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <img src="{{ URL::asset($resourcePathServer.'assets/images/flags/italy.jpg') }}"
                             alt="user-image"
                             class="mr-1" height="12"> <span class="align-middle">Italian</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <img src="{{ URL::asset($resourcePathServer.'assets/images/flags/spain.jpg') }}"
                             alt="user-image"
                             class="mr-1" height="12"> <span class="align-middle">Spanish</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <img src="{{ URL::asset($resourcePathServer.'assets/images/flags/russia.jpg') }}"
                             alt="user-image"
                             class="mr-1" height="12"> <span class="align-middle">Russian</span>
                    </a>

                </div>
            </li>
        @endif
        @if(env('allowNotification'))
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle  waves-effect waves-light" data-toggle="dropdown" href="#"
                   role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <i class="fe-bell noti-icon"></i>
                    <span class="badge badge-danger rounded-circle noti-icon-badge">4</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5 class="m-0">
                           <span class="float-right">
                               <a href="" class="text-dark">
                                   <small>Clear All</small>
                               </a>
                           </span>Notification
                        </h5>
                    </div>

                    <div class="slimscroll noti-scroll">

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item active">
                            <div class="notify-icon bg-soft-primary text-primary">
                                <i class="mdi mdi-comment-account-outline"></i>
                            </div>
                            <p class="notify-details">Doug Dukes commented on Admin Dashboard
                                <small class="text-muted">1 min ago</small>
                            </p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon">
                                <img src="{{ URL::asset($resourcePathServer.'assets/images/users/avatar-2.jpg') }}"
                                     class="img-fluid rounded-circle" alt=""/></div>
                            <p class="notify-details">Mario Drummond</p>
                            <p class="text-muted mb-0 user-msg">
                                <small>Hi, How are you? What about our next meeting</small>
                            </p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon">
                                <img src="{{ URL::asset($resourcePathServer.'assets/images/users/avatar-4.jpg') }}"
                                     class="img-fluid rounded-circle" alt=""/></div>
                            <p class="notify-details">Karen Robinson</p>
                            <p class="text-muted mb-0 user-msg">
                                <small>Wow ! this admin looks good and awesome design</small>
                            </p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-soft-warning text-warning">
                                <i class="mdi mdi-account-plus"></i>
                            </div>
                            <p class="notify-details">New user registered.
                                <small class="text-muted">5 hours ago</small>
                            </p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-info">
                                <i class="mdi mdi-comment-account-outline"></i>
                            </div>
                            <p class="notify-details">Caleb Flakelar commented on Admin
                                <small class="text-muted">4 days ago</small>
                            </p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-secondary">
                                <i class="mdi mdi-heart"></i>
                            </div>
                            <p class="notify-details">Carlos Crouch liked
                                <b>Admin</b>
                                <small class="text-muted">13 days ago</small>
                            </p>
                        </a>
                    </div>

                    <!-- All-->
                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                        View all
                        <i class="fi-arrow-right"></i>
                    </a>

                </div>
            </li>

        @endif
        @if($user)
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown"
                   href="#"
                   role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ URL::asset($urlAvatar) }}" alt="user-image" class="rounded-circle">
                    <span class="pro-user-name ml-1">
                   {{ $user->name }} <i class="mdi mdi-chevron-down"></i>
                   </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    {!! $menuAccount !!}

                </div>
            </li>
        @endif

        <li class="dropdown notification-list">
            <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                <i class="fe-settings noti-icon"></i>
            </a>
        </li>


    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="{{route('business', app()->getLocale())}}" class="logo text-center">
               <span class="logo-lg">
                   @if(env('allowBusiness'))
                       @if(false)
                           <img src="{{ URL::asset($resourcePathServer.'assets/images/business/logo-light.png') }}"
                                alt=""
                                height="20">
                       @else
                           <div class="content-name-business ">{{env("backendNameFirst")}}<span
                                   class="content-name-business__second">{{env("backendNameSecond")}}</span></div>

                       @endif
                   @else
                       @if(false)
                           <img src="{{ URL::asset($resourcePathServer.'assets/images/logo-light.png') }}" alt=""
                                height="20">

                       @else
                           <div class="content-name-business ">{{env("backendNameFirst")}}<span
                                   class="content-name-business__second">{{env("backendNameSecond")}}</span></div>
                       @endif
                   @endif
                   <!-- <span class="logo-lg-text-light">Xeria</span> -->
               </span>
            <span class="logo-sm">
          @if(env('allowBusiness'))
                    <img src="{{ URL::asset($resourcePathServer.'assets/images/business/logo-sm-light.png') }}" alt=""
                         height="24">
                @else

                    <img src="{{ URL::asset($resourcePathServer.'assets/images/logo-sm.png') }}" alt="" height="24">
                @endif
               </span>
        </a>
    </div>

    @include('layouts.minton.headerTopMenus')

</div>
<!-- end Topbar -->
