<!DOCTYPE html>

<html lang="en">
<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <title>
        {{env('APP_NAME')}}
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('errors.assets.css.errors')

</head>
<?php
$rootPage = route('homePage');
$loginRoute = $rootPage . "/" . app()->getLocale() . "/register";
$homeRoute = $rootPage;
?>

<body class="m">

<div class="mc-page mc-401">
    <div class="mc-401__wrap">
        <div class="mc-card mc-401__card">

            <!-- Header -->
            <div class="mc-card__header">
                <div class="mc-brand">
                    <div class="mc-brand__logo">M</div>
                    <div class="mc-brand__text">
                        <div class="mc-brand__name">MeetClic</div>
                        <div class="mc-brand__tag">Seguridad & Acceso</div>
                    </div>
                </div>

                <div class="mc-badge">Error 401</div>
            </div>

            <!-- Content -->
            <div class="mc-card__content">
                <div class="mc-401__code">401</div>

                <h2 class="mc-401__title">Acceso no autorizado</h2>

                <p class="mc-401__message">
                    {{ $message ? $message : 'No tienes permisos o tu sesión no es válida. Por favor inicia sesión nuevamente o regresa al inicio.' }}
                </p>

                <div class="mc-actions">
                    <a href="{{ $homeRoute }}" class="mc-btn mc-btn--outline">
                        <span class="mc-btn__icon">←</span>
                        Regresar al inicio
                    </a>

                    <a href="{{ $loginRoute }}" class="mc-btn mc-btn--primary">
                        <span class="mc-btn__icon">↪</span>
                        {{ __("frontend.menu.home.join.button") }}
                    </a>
                </div>

                @if(!empty($type) || !empty($reason))
                    <div class="mc-tech">
                        <div class="mc-tech__title">Detalle técnico</div>
                        @if(!empty($type))
                            <div class="mc-tech__row"><b>type:</b> {{ $type }}</div>
                        @endif
                        @if(!empty($reason))
                            <div class="mc-tech__row"><b>reason:</b> {{ $reason }}</div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="mc-card__footer">
                © {{ date('Y') }} MeetClic • Si crees que esto es un error, vuelve a iniciar sesión o contacta al administrador.
            </div>

        </div>
    </div>
</div>

</body>

</html>
