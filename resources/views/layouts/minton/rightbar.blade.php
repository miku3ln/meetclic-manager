<!--BUSINESS-MANAGER-MENU-LEFT-TEMPLATE-->
<!-- BUSINESS-MANAGER-TEMPLATE-MENU-LEFT -->

<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$utilManagerUser = new \App\Utils\UtilUser;
$user = Auth::user();
?>

    <!-- Right Sidebar -->
<div class="right-bar">
    <div class="rightbar-title">
        <a href="javascript:void(0);" class="right-bar-toggle float-right">
            <i class="fe-x noti-icon"></i>
        </a>
        <h4 class="m-0 text-white">Configuracion</h4>
    </div>
    <div class="slimscroll-menu">
        @if($user)
            <!-- User box -->
            <div class="user-box">
                <div class="user-img">
                    <img src="{{ URL::asset($resourcePathServer.'assets/images/users/avatar-1.jpg') }}" alt="user-img"
                         title="{{$user->name}}"
                         class="rounded-circle img-fluid">

                    @if($utilManagerUser->allowActionByUser(['actionCurrent'=>'myProfile','user'=>$user]))
                        <a href="{{route('myProfile', 'es')}}" class="user-edit"><i class="mdi mdi-pencil"></i></a>
                    @endif
                </div>

                <h5><a>{{ $user->name }}</a></h5>
                <p class="text-muted mb-0">
                    <small>{{$user->email }}</small>
                </p>
            </div>
        @endif
    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
