<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$themePath = $resourcePathServer . 'templates/cityBookHtml/';
$isUser = Auth::check();

$languageCurrent = app()->getLocale();
$selectEs = '';
$selectKi = '';
$selectEn = '';
$languageCurrentText='Español';
$languageCurrentImg=URL::asset($resourcePathServer.'images/frontend/translator/spanish.svg');
switch ($languageCurrent) {
    case 'es':
        $selectEs = 'selected';
        $languageCurrentText='Español';
        $languageCurrentImg=URL::asset($resourcePathServer.'images/frontend/translator/spanish.svg');

        break;

    case 'en':
        $selectEn = 'selected';
        $languageCurrentText='Ingles';
        $languageCurrentImg=URL::asset($resourcePathServer.'images/frontend/translator/english.svg');

        break;
    case 'ki':
        $selectKi = 'selected';
        $languageCurrentText='Kichwa';
        $languageCurrentImg=URL::asset($resourcePathServer.'images/frontend/translator/kichwa.svg');

        break;
}

?>

@if($type=='managerUserTop')

    <div class="attr-nav header-icon d-flex align-items-center">
        <ul class="header-icon__list">
            @include('layouts.partials.shop.cart',array('typeManagerButton'=>2))

        </ul>
    </div>
    @if( isset($dataManagerPage['allowListing'])&&$isUser)

        <a href="{{url('/usuarios/')}}" class="add-list">Add Listing
            <span><i class="fa fa-plus"></i></span>
        </a>
    @endif
    <div class="manager-language dropdown-translator ">
        <button class="dropdown-translator not-view" id="languageDropdown" aria-haspopup="true" aria-expanded="false">
        {{$languageCurrentText}}

            <img src="{{$languageCurrentImg}}"
                 alt="{{$languageCurrentText}}"
                 class="dropdown-translator__img"
                 title="{{$languageCurrentText}}"
            >
        </button>
        <ul class="manager-language__ul dropdown-menu-translator list" aria-labelledby="languageDropdown">


            <li class="option">
                <a href="{{url('/urlBase/es')}}" class="manager-language__item {{$selectEs}}">
                    <img src="{{URL::asset($resourcePathServer.'images/frontend/translator/spanish.svg')}}"
                         alt="Spanish" class="manager-language__img" title="Spanish"
                    >
                </a>
            </li>
            <li>
                <a href="{{url('/urlBase/ki')}}" class="manager-language__item {{$selectKi}}">
                    <img src="{{URL::asset($resourcePathServer.'images/frontend/translator/kichwa.svg')}}"
                         alt="Kichwa" class="manager-language__img" title="Kichwa"

                    >
                </a>
            </li>
            <li>
                <a href="{{url('/urlBase/en')}}" class="manager-language__item {{$selectEn}}">
                    <img src="{{URL::asset($resourcePathServer.'images/frontend/translator/english.svg')}}"
                         alt="Spanish" class="manager-language__img" title="English">
                </a>
            </li>

        </ul>

    </div>

    @if(!$isUser)
        <div class="show-reg-form "><a href="{{route('login',app()->getLocale())}}"><i
                    class="fa fa-sign-in"></i>Sign In</a>
        </div>
    @else
        <div class="">

            {!! $dataManagerPage['profileConfig']['menu'] !!}
        </div>
    @endif

    <!-- nav-button-wrap-->
    <div class="nav-button-wrap color-bg">
        <div class="nav-button">
            <span></span><span></span><span></span>
        </div>
    </div>
    <!-- nav-button-wrap end-->
@elseif($type=='deskManagerUserTop')


@endif
