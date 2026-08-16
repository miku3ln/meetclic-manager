@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
    $sourcesRoot = $resourcePathServer . 'frontend/businessOwner/mikuy-yachak';
 $leftRightMove   = URL::asset( $resourcePathServer."simi-rura/ui-totems/left-right.png");
    $upDownMove   = URL::asset( $resourcePathServer."simi-rura/ui-totems/up-down.png");
@endphp
@extends('layouts.bootstrap5')
@section('additional-styles')
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    @include('cityBook.web.businessOwner.chasqui-manager.partials.css.source')
@endsection
@section('additional-scripts')
    @include('cityBook.web.businessOwner.chasqui-manager.partials.js.source')
@endsection
@section('content')

    @include('cityBook.web.businessOwner.chasqui-manager.partials.html.joystick-zone')

    <!-- Mensajes de estado -->
    <div id="hint" class="hint">Estado: listo</div>
    <!-- Controles principales -->
    <button id="btn-back-map" class="btn d-none">← Volver al mapa</button>
    <button id="btn-capture" class="btn d-none">📸</button>
    <!-- Contenedor de AR/Fallback -->
    <div class="container--custom not-view">
        <!-- Loading transparente con % -->
        <div id="ar-loading" class="loading d-none">
            <div class="loading__center">
                <div class="spinner"></div>
                <div class="loading__text">
                    <strong id="ar-loading-label">Cargando…</strong>
                    <span id="ar-loading-percent">0%</span>
                </div>
            </div>
        </div>

        <!-- Fallback: <model-viewer> -->
        <div id="fallback" class="d-none">
            <model-viewer id="mv"
                          ar ar-modes="scene-viewer quick-look webxr"
                          camera-controls
                          environment-image="neutral"
                          style="width:100%;height:60vh;background:#000">
            </model-viewer>
        </div>
    </div>

    <!-- Retícula (tap aquí para colocar) -->
    <div id="reticle-overlay" class="reticle hidden" aria-hidden="true">
        <div class="reticle__ring"></div>
        <div class="reticle__dot"></div>
        <div class="reticle__hint">Toca la retícula para colocar</div>
    </div>
    <?php
    $companyTagline = "Turismo · Deportes · Geología";

    $hrefCurrent = route('businessDetails', 'es') . '/' . 1;


    $titleChaquiñan = "Vive la Vida";
    $descriptinoChaquiñan = "La Ruta Sagrada del Muelle Catalina es un recorrido temático, turístico y cultural que conecta los puntos más emblemáticos del territorio de Imbabura. En esta travesía, viajeros y familias se acercan a los espíritus protectores de la laguna y las montañas, descubriendo paisajes ancestrales, actividades deportivas, historias vivas y experiencias de contacto con la naturaleza.\r\n\r\nLa ruta integra montañismo, senderismo, fotografía, historia, espiritualidad andina y observación paisajística, guiando a los visitantes desde la serenidad del Muelle Catalina hasta la grandeza de Taita Imbabura, la magia de las lagunas y la fuerza ceremonial del Lechero.\r\n\r\nEs una experiencia diseñada para educar, inspirar y conectar, ideal para turistas, deportistas, familias y estudiantes.";
    $companyName = "Meetclic";
    $sourceChaquiñan = 'https://meetclic.com/public/uploads/frontend/templateBySource/1750454099_logo-one.png';



    $phone_value = "0985339457";

    // Asegúrate de que el número esté en formato internacional sin "+"
    $phone = preg_replace('/\D+/', '', $phone_value);

    // Mensaje por defecto
    $whatsappMessage = 'Hola, me interesa obtener más información sobre su empresa ,esta informacion es desde la ruta ';
    if ($dataManager["allow"]) {
        $sourceChaquiñanBusiness = URL::asset($resourcePathServer . $dataManager["business"]["business"][0]["source"]);
        $sourceChaquiñan = URL::asset($resourcePathServer . $dataManager["dataRoute"]["information"]["src"]);

        $companyName = $dataManager["business"]["business"][0]["business_name"];
        $phone_value = $dataManager["business"]["business"][0]["phone_value"];
        $whatsappMessage = "Hola, vi {$companyName} en MeetClic y me gustaría más información 🙌";

        $titleChaquiñan = $dataManager["dataRoute"]["information"]["name"];
        $descriptinoChaquiñan = $dataManager["dataRoute"]["information"]["description"];

        $companyTagline = "";
        $tags = [];
        $hrefCurrent = route('businessDetails', 'es') . '/' . $dataManager["business"]["business"][0]['id'];

        foreach ($dataManager["dataRoute"]["adventure_type_data"] as $name => $value) {
            $tags[] = $value->adventure_adventure_type_text;

        }
        if (!empty($tags)) {
            $companyTagline = implode(' · ', $tags);
        }

        $adventureStyles = [

            0 => [
                'icon' => 'bi-water',
                'pastel' => '#B3E5FC',
                'dark' => '#0277BD',
            ],

            1 => [
                'icon' => 'bi-bicycle',
                'pastel' => '#C8E6C9',
                'dark' => '#2E7D32',
            ],

            2 => [
                'icon' => 'bi-arrow-down-circle',
                'pastel' => '#FFCDD2',
                'dark' => '#C62828',
            ],

            3 => [
                'icon' => 'bi-water',
                'pastel' => '#B2EBF2',
                'dark' => '#00838F',
            ],

            4 => [
                'icon' => 'bi-person-walking',
                'pastel' => '#D7CCC8',
                'dark' => '#6D4C41',
            ],

            5 => [
                'icon' => 'bi-triangle',
                'pastel' => '#CFD8DC',
                'dark' => '#455A64',
            ],

            6 => [
                'icon' => 'bi-person-walking',
                'pastel' => '#DCEDC8',
                'dark' => '#558B2F',
            ],

            7 => [
                'icon' => 'bi-bicycle',
                'pastel' => '#DCE775',
                'dark' => '#827717',
            ],

            8 => [
                'icon' => 'bi-person-up',
                'pastel' => '#FFE0B2',
                'dark' => '#EF6C00',
            ],

            9 => [
                'icon' => 'bi-person-arms-up',
                'pastel' => '#FFF9C4',
                'dark' => '#F9A825',
            ],

            10 => [
                'icon' => 'bi-tree',
                'pastel' => '#C5E1A5',
                'dark' => '#689F38',
            ],

            11 => [
                'icon' => 'bi-car-front-fill',
                'pastel' => '#EFEBE9',
                'dark' => '#5D4037',
            ],

            12 => [
                'icon' => 'bi-person-down',
                'pastel' => '#FFCCBC',
                'dark' => '#D84315',
            ],

            13 => [
                'icon' => 'bi-signpost',
                'pastel' => '#B0BEC5',
                'dark' => '#546E7A',
            ],

            14 => [
                'icon' => 'bi-water',
                'pastel' => '#B2DFDB',
                'dark' => '#00796B',
            ],

            15 => [
                'icon' => 'bi-wind',
                'pastel' => '#D1C4E9',
                'dark' => '#5E35B1',
            ],
        ];

        $adventureHtml = '   <div class="company-panel__section-title">
                 <div class="stats__header">
            <i class="bi bi-map"></i>
            <span class="stats__title">Que existe en la ruta</span>
        </div>';

        $adventureHtml .= '
<div id="adventureCarousel" class="carousel slide adventure-carousel">
    <div class="carousel-inner">
';

        $itemsPerSlide = 3;
        $items = $dataManager["dataRoute"]["adventure_type_data"];

        foreach (array_chunk($items, $itemsPerSlide) as $index => $group) {

            $active = $index === 0 ? 'active' : '';

            $adventureHtml .= '
        <div class="carousel-item '.$active.'">
            <div class="adventure-carousel__slide">
    ';

            foreach ($group as $value) {

                $type = (int) $value->adventure_type;

                $style = $adventureStyles[$type] ?? [
                    'icon'   => 'bi-compass',
                    'pastel' => '#F1F3F5',
                    'dark'   => '#495057',
                ];

                $name = htmlspecialchars(
                    $value->adventure_adventure_type_text,
                    ENT_QUOTES,
                    'UTF-8'
                );

                $adventureHtml .= '
            <span
                class="adventure-tag"
                style="
                    background: '.$style['pastel'].';
                    color: '.$style['dark'].';
                "
            >
                <i class="bi '.$style['icon'].' adventure-tag__icon"></i>

                <span class="adventure-tag__label">
                    '.$name.'
                </span>
            </span>
        ';
            }

            $adventureHtml .= '
            </div>
        </div>
    ';
        }

        $adventureHtml .= '
    </div>

    <button
        class="carousel-control-prev adventure-carousel__control"
        type="button"
        data-bs-target="#adventureCarousel"
        data-bs-slide="prev"
    >
        <i class="bi bi-chevron-left"></i>
    </button>

    <button
        class="carousel-control-next adventure-carousel__control"
        type="button"
        data-bs-target="#adventureCarousel"
        data-bs-slide="next"
    >
        <i class="bi bi-chevron-right"></i>
    </button>
</div>
';
    }


    ?>
        <!-- Mapa -->
    @include('cityBook.web.businessOwner.chasqui-manager.partials.html.map')

    <canvas id="snap-canvas" class="snap-canvas d-none"></canvas>
    @include('cityBook.web.businessOwner.chasqui-manager.partials.html.route-details')


@endsection
