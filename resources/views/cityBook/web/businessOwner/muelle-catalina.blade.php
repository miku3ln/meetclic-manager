@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
    $sourcesRoot = $resourcePathServer . 'frontend/businessOwner/mikuy-yachak';
 $leftRightMove   = URL::asset( $resourcePathServer."simi-rura/ui-totems/left-right.png");
    $upDownMove   = URL::asset( $resourcePathServer."simi-rura/ui-totems/up-down.png");
@endphp
@extends('layouts.bootstrap5')
@section('additional-styles')
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
    $hrefCurrent = "https://meetclic.com/es/businessDetails/Muelle%20Catalina";
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
        $hrefCurrent = "https://meetclic.com/es/businessDetails/" . $dataManager["business"]["business"][0]["business_name"];
        foreach ($dataManager["dataRoute"]["adventure_type_data"] as $name => $value) {
            $tags[] = $value->adventure_adventure_type_text;

        }
        if (!empty($tags)) {
            $companyTagline = implode(' · ', $tags);
        }
    }

    ?>
        <!-- Mapa -->
    @include('cityBook.web.businessOwner.chasqui-manager.partials.html.map')

    <canvas id="snap-canvas" class="snap-canvas d-none"></canvas>
    @include('cityBook.web.businessOwner.chasqui-manager.partials.html.route-details')


@endsection
