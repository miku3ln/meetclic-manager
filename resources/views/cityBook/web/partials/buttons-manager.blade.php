<div class="profile-edit-page-header">
    <h2>{{__('frontend.account.breadcrumb.left')}}</h2>
    <div class="breadcrumbs">
        <a href="{{route('homePage',app()->getLocale())}}">{{__('frontend.menu.home')}}</a>
        <span>{{isset($dataManagerPage['breadcrumb']['active'])?$dataManagerPage['breadcrumb']['active']:''}}</span>
    </div>
</div>
<div class="row">
    @if($profileConfig['utilUser']->allowActionByUser(['actionCurrent'=>'dashboardManager','user'=>$profileConfig['user']]))
        <a href="{{route('dashboardManager',app()->getLocale())}}"
           class="log-out-btn"> {{__('frontend.buttons.manager-admin')}}</a>

    @endif
    <a href="{{route('logout',app()->getLocale())}}"
       class="log-out-btn"> {{__('frontend.buttons.logout')}}</a>


</div>
