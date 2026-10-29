@extends('layouts.cityBook')

@section('data-modal')

@endsection
@section('additional-styles')
    <link href="{{ URL::asset($resourcePathServer.'libs/toast/jquery.toast.min.css') }}" rel="stylesheet"
          type="text/css">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""
    />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>
    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >
    <style>

        /* ==========================================
           YAPITA - KARAY / SPONSOR REWARDS
           Block: manager-reward
        ========================================== */

        .manager-reward {
            --reward-primary: #4f50f5;
            --reward-primary-hover: #3f40d9;
            --reward-text: #172345;
            --reward-muted: #71809a;
            --reward-border: #e6eaf2;
            --reward-surface: #ffffff;
            --reward-soft: #f3f5fc;

            width: 100%;
            min-height: 100vh;

            background: #fafbfe;
            color: var(--reward-text);

            font-family: inherit;
        }

        /* ==========================================
           HERO
        ========================================== */

        .manager-reward__hero {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;

            min-height: 200px;
            padding: 38px max(5%, 24px);

            overflow: hidden;

            background: linear-gradient(
                115deg,
                #3b54ed 0%,
                #5143e7 55%,
                #793cde 100%
            );

            color: #fff;
        }

        .manager-reward__hero::after {
            content: "";
            position: absolute;

            width: 340px;
            height: 340px;
            right: -70px;
            bottom: -220px;

            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
        }

        .manager-reward__hero-content {
            position: relative;
            z-index: 1;
            max-width: 750px;
        }

        .manager-reward__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            font-size: 12px;
            font-weight: 700;
            letter-spacing: .06em;
        }

        .manager-reward__heading {
            margin: 10px 0;
            font-size: clamp(26px, 3vw, 42px);
            font-weight: 800;
            line-height: 1.18;
            color: #fff;
        }

        .manager-reward__intro {
            max-width: 580px;
            margin: 0;

            font-size: 15px;
            line-height: 1.6;
            color: rgba(255, 255, 255, .9);
        }

        .manager-reward__hero-symbol {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 150px;
            height: 150px;

            font-size: 100px;
            color: #ffd44f;

            transform: rotate(-12deg);
            text-shadow: 0 12px 24px rgba(0, 0, 0, .15);
        }

        /* ==========================================
           MAIN CONTAINER
        ========================================== */

        .manager-reward__container {
            width: 100%;
            max-width: 1500px;

            margin: 0 auto;
            padding: 26px 24px 60px;
        }

        /* ==========================================
           FILTERS
        ========================================== */

        .manager-reward__filters {
            display: grid;
            grid-template-columns:
        minmax(220px, 2.2fr)
        minmax(170px, 1fr)
        minmax(160px, 1fr)
        minmax(160px, 1fr)
        auto;

            gap: 12px;
            align-items: center;

            margin: 0 0 28px;
        }

        .manager-reward__search,
        .manager-reward__filter-field {
            display: flex;
            align-items: center;
            gap: 10px;

            min-width: 0;
            height: 46px;

            padding: 0 14px;

            background: #fff;
            border: 1px solid var(--reward-border);
            border-radius: 10px;

            color: #465577;
        }

        .manager-reward__search:focus-within,
        .manager-reward__filter-field:focus-within {
            border-color: var(--reward-primary);
            box-shadow: 0 0 0 3px rgba(79, 80, 245, .1);
        }

        .manager-reward__search-input,
        .manager-reward__select {
            width: 100%;
            min-width: 0;
            height: 100%;

            border: 0;
            outline: 0;
            background: transparent;

            color: var(--reward-text);
            font-size: 13px;
        }

        .manager-reward__search-input::placeholder {
            color: #98a1b3;
        }

        .manager-reward__select {
            cursor: pointer;
        }

        .manager-reward__filter-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            height: 46px;
            padding: 0 20px;

            border: 0;
            border-radius: 10px;

            background: var(--reward-primary);
            color: #fff;

            font-size: 13px;
            font-weight: 700;

            cursor: pointer;
            transition: background .2s ease;
        }

        .manager-reward__filter-submit:hover {
            background: var(--reward-primary-hover);
        }

        /* ==========================================
           RESULTS HEADING
        ========================================== */

        .manager-reward__results {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;

            margin-bottom: 20px;
        }

        .manager-reward__section-title {
            margin: 0 0 5px;
            font-size: 21px;
            font-weight: 800;
            color: var(--reward-text);
        }

        .manager-reward__results-description {
            margin: 0;
            font-size: 13px;
            color: var(--reward-muted);
        }

        .manager-reward__results-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .manager-reward__total {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 9px 13px;

            border-radius: 30px;
            background: #edeeff;

            color: #4345c9;
            font-size: 12px;
            font-weight: 700;

            white-space: nowrap;
        }

        .manager-reward__clear {
            font-size: 12px;
            font-weight: 600;
            color: var(--reward-primary);
            text-decoration: none;
            white-space: nowrap;
        }

        /* ==========================================
           GRID
        ========================================== */

        .manager-reward__grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));

            gap: 22px;
            align-items: stretch;
        }

        /* ==========================================
           CARD
        ========================================== */

        .manager-reward__card {
            position: relative;

            display: flex;
            flex-direction: column;

            min-width: 0;

            background: var(--reward-surface);

            border: 1px solid var(--reward-border);
            border-radius: 15px;

            overflow: hidden;

            box-shadow: 0 3px 14px rgba(22, 35, 69, .04);

            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }

        .manager-reward__card:hover {
            transform: translateY(-4px);

            box-shadow: 0 10px 28px rgba(22, 35, 69, .1);
        }

        /* ==========================================
           CARD PHOTO
        ========================================== */

        .manager-reward__media {
            position: relative;
            height: 135px;

            background: var(--reward-accent, #435cf0);
            overflow: hidden;
        }

        .manager-reward__photo {
            display: block;
            width: 100%;
            height: 100%;

            object-fit: cover;
            transition: transform .3s ease;
        }

        .manager-reward__card:hover .manager-reward__photo {
            transform: scale(1.05);
        }

        .manager-reward__category {
            position: absolute;
            top: 12px;
            left: 12px;

            display: inline-flex;
            align-items: center;
            gap: 6px;

            max-width: calc(100% - 24px);
            padding: 6px 10px;

            border-radius: 30px;
            background: rgba(17, 24, 39, .45);

            backdrop-filter: blur(8px);

            color: #fff;
            font-size: 11px;
            font-weight: 600;
        }

        /* ==========================================
           SPONSOR LOGO
        ========================================== */

        .manager-reward__brand {
            position: relative;
            z-index: 2;

            width: 64px;
            height: 38px;

            margin-top: -28px;
            margin-left: 14px;
        }

        .manager-reward__brand-logo {
            width: 60px;
            height: 60px;

            object-fit: cover;

            background: #fff;
            border: 3px solid #fff;
            border-radius: 50%;

            box-shadow: 0 3px 10px rgba(0, 0, 0, .12);
        }

        /* ==========================================
           CARD BODY
        ========================================== */

        .manager-reward__card-body {
            display: flex;
            flex-direction: column;
            flex: 1;
            gap: 12px;

            min-height: 0;
            padding: 8px 14px 14px;
        }

        .manager-reward__sponsor {
            min-height: 68px;
        }

        .manager-reward__sponsor-name {
            margin: 0 0 4px;

            font-size: 15px;
            line-height: 1.3;
            font-weight: 800;

            color: var(--reward-text);
        }

        .manager-reward__sponsor-description {
            display: -webkit-box;

            margin: 0;
            overflow: hidden;

            font-size: 12px;
            line-height: 1.45;
            color: #697893;

            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        /* ==========================================
           PRIZE + EXPIRATION
        ========================================== */

        .manager-reward__details {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr);

            gap: 8px;
            margin-top: auto;
        }

        .manager-reward__prize,
        .manager-reward__expiration {
            display: flex;
            align-items: center;
            gap: 8px;

            min-width: 0;
            min-height: 56px;
            padding: 9px;

            background: #f1f3ff;
            border-radius: 9px;
        }

        .manager-reward__detail-icon {
            flex-shrink: 0;

            color: var(--reward-primary);
            font-size: 18px;
        }

        .manager-reward__detail-text {
            display: flex;
            flex-direction: column;
            gap: 2px;

            min-width: 0;
        }

        .manager-reward__detail-label {
            font-size: 10px;
            color: #667391;
        }

        .manager-reward__prize-title {
            display: -webkit-box;

            overflow: hidden;

            color: #252b77;
            font-size: 11px;
            line-height: 1.3;
            font-weight: 700;

            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        .manager-reward__expiration-date {
            font-size: 11px;
            font-weight: 700;
            color: #26375f;
            white-space: nowrap;
        }

        /* ==========================================
           ACTION BUTTON
        ========================================== */

        .manager-reward__action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

            width: 100%;
            min-height: 39px;

            border: 0;
            border-radius: 9px;

            background: var(--reward-primary);

            color: #fff;
            font-size: 12px;
            font-weight: 700;

            cursor: pointer;
            transition: background .2s ease;
        }

        .manager-reward__action:hover {
            background: var(--reward-primary-hover);
        }

        .manager-reward__action i {
            transition: transform .2s ease;
        }

        .manager-reward__action:hover i {
            transform: translateX(3px);
        }

        /* ==========================================
           EXPIRED STATE
        ========================================== */

        .manager-reward__card--expired .manager-reward__photo {
            filter: grayscale(.65);
        }

        .manager-reward__status {
            position: absolute;
            top: 12px;
            right: 12px;

            padding: 5px 9px;

            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        .manager-reward__status--expired {
            background: #fff2f0;
            color: #c53e32;
        }

        .manager-reward__card--expired .manager-reward__expiration {
            background: #fff1ef;
        }

        .manager-reward__card--expired .manager-reward__action {
            background: #7c8495;
        }

        /* ==========================================
           EMPTY STATE
        ========================================== */

        .manager-reward__empty {
            grid-column: 1 / -1;

            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;

            padding: 65px 20px;
            text-align: center;
        }

        .manager-reward__empty > i {
            font-size: 50px;
            color: #9b9df5;
        }

        .manager-reward__empty h3 {
            margin: 0;
            font-size: 20px;
        }

        .manager-reward__empty p {
            margin: 0;
            font-size: 14px;
            color: var(--reward-muted);
        }

        .manager-reward__empty-action {
            padding: 11px 17px;

            border-radius: 10px;
            background: var(--reward-primary);

            color: #fff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
        }

        /* ==========================================
           PAGINATION
        ========================================== */

        .manager-reward__pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 18px;

            margin-top: 35px;
        }

        .manager-reward__pagination-info {
            margin: 0;
            font-size: 13px;
            color: var(--reward-muted);
        }

        .manager-reward__pagination-nav .pagination {
            margin: 0;
            flex-wrap: wrap;
            gap: 5px;
        }

        .manager-reward__pagination-nav .page-link {
            display: flex;
            align-items: center;
            justify-content: center;

            min-width: 38px;
            min-height: 38px;

            padding: 7px 10px;

            border: 1px solid var(--reward-border);
            border-radius: 9px;

            background: #fff;
            color: #465577;

            font-size: 12px;
            box-shadow: none;
        }

        .manager-reward__pagination-nav .page-item.active .page-link {
            background: var(--reward-primary);
            border-color: var(--reward-primary);
            color: #fff;
        }

        .manager-reward__pagination-nav .page-item.disabled .page-link {
            opacity: .45;
        }

        /* ==========================================
           TABLET
        ========================================== */

        @media (max-width: 1199px) {

            .manager-reward__grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .manager-reward__filters {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .manager-reward__search {
                grid-column: 1 / -1;
            }

        }

        /* ==========================================
           SMALL TABLET
        ========================================== */

        @media (max-width: 800px) {

            .manager-reward__grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 16px;
            }

            .manager-reward__hero-symbol {
                width: 100px;
                font-size: 75px;
            }

            .manager-reward__container {
                padding: 22px 16px 40px;
            }

        }

        /* ==========================================
           MOBILE
        ========================================== */

        @media (max-width: 575px) {

            .manager-reward__hero {
                min-height: 175px;
                padding: 25px 18px;
            }

            .manager-reward__hero-symbol {
                display: none;
            }

            .manager-reward__heading {
                font-size: 26px;
            }

            .manager-reward__intro {
                font-size: 13px;
            }

            .manager-reward__container {
                padding: 18px 12px 35px;
            }

            .manager-reward__filters {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 9px;
            }

            .manager-reward__search {
                grid-column: 1 / -1;
            }

            .manager-reward__filter-field {
                padding: 0 10px;
            }

            .manager-reward__filter-field i {
                display: none;
            }

            .manager-reward__filter-submit {
                grid-column: 1 / -1;
            }

            .manager-reward__results {
                flex-direction: column;
                align-items: flex-start;
            }

            .manager-reward__results-actions {
                flex-wrap: wrap;
            }

            .manager-reward__grid {
                grid-template-columns: minmax(0, 1fr);
                gap: 15px;
            }

            .manager-reward__media {
                height: 165px;
            }

            .manager-reward__sponsor {
                min-height: 0;
            }

            .manager-reward__card-body {
                gap: 14px;
            }

            .manager-reward__pagination {
                justify-content: center;
                text-align: center;
            }

            .manager-reward__pagination-nav {
                width: 100%;
                display: flex;
                justify-content: center;
            }

        }

        @media (prefers-reduced-motion: reduce) {
            .manager-reward__card,
            .manager-reward__photo,
            .manager-reward__action,
            .manager-reward__action i {
                transition: none;
            }
        }

    </style>
@endsection
@section('additional-scripts')


    @php
        $maskanaTranslations = [
            'frontend.maskana.filter.title' => __('frontend.maskana.filter.title'),
            'frontend.maskana.filter.subtitle' => __('frontend.maskana.filter.subtitle'),
            'frontend.maskana.filter.businesses_found' => __('frontend.maskana.filter.businesses_found'),
            'frontend.maskana.filter.view_map_question' => __('frontend.maskana.filter.view_map_question'),
            'frontend.maskana.filter.view_map_description' => __('frontend.maskana.filter.view_map_description'),
            'frontend.maskana.filter.category_subcategory' => __('frontend.maskana.filter.category_subcategory'),
            'frontend.maskana.filter.search_business' => __('frontend.maskana.filter.search_business'),
            'frontend.maskana.filter.clear' => __('frontend.maskana.filter.clear'),
            'frontend.maskana.filter.businesses' => __('frontend.maskana.filter.businesses'),
            'frontend.maskana.filter.toggle' => __('frontend.maskana.filter.toggle'),
            'frontend.maskana.filter.apply' => __('frontend.maskana.filter.apply'),
            'frontend.maskana.business.loading' => __('frontend.maskana.business.loading'),
            'frontend.maskana.business.detail' => __('frontend.maskana.business.detail'),
            'frontend.maskana.business.close_detail' => __('frontend.maskana.business.close_detail'),
            'frontend.maskana.businesses.at_location' => __('frontend.maskana.businesses.at_location'),
            'frontend.maskana.businesses.close_list' => __('frontend.maskana.businesses.close_list'),



            'frontend.maskana.business.no_information' => __('frontend.maskana.business.no_information'),
            'frontend.maskana.business.try_changing_filters' => __('frontend.maskana.business.try_changing_filters'),
            'frontend.maskana.map.marker_unavailable' => __('frontend.maskana.map.marker_unavailable'),
            'frontend.maskana.filter.business_found' => __('frontend.maskana.filter.business_found'),


        ];
    @endphp

    <script>
        window.MaskanaTranslations = {{ Illuminate\Support\Js::from($maskanaTranslations) }};
    </script>



    <script>


    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ URL::asset($resourcePathServer.'libs/blockui/blockui.min.js') }}"></script>

    <script src="{{ URL::asset($resourcePathServer.'libs/toast/jquery.toast.min.js') }}"
            type='text/javascript'></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

@endsection


@section('content')

    @php
        /*
        |--------------------------------------------------------------------------
        | KARAY - DEMO DATA
        |--------------------------------------------------------------------------
        | 100 premios generados en PHP.
        | Reemplazar posteriormente por datos de MySQL.
        */

        $sponsors = [
            [
                'name' => 'Mercado Andino',
                'category' => 'Alimentos',
                'description' => 'Productos de calidad para compartir en familia.',
                'color' => '#e53935',
                'logo' => 'MA',
            ],
            [
                'name' => 'Cine Killa',
                'category' => 'Entretenimiento',
                'description' => 'Experiencias inolvidables para disfrutar del cine.',
                'color' => '#39358e',
                'logo' => 'CK',
            ],
            [
                'name' => 'Conecta Móvil',
                'category' => 'Tecnología',
                'description' => 'Tecnología y conectividad para tu día a día.',
                'color' => '#009be5',
                'logo' => 'CM',
            ],
            [
                'name' => 'Sabores de Otavalo',
                'category' => 'Restaurantes',
                'description' => 'Sabores y experiencias para compartir.',
                'color' => '#e95722',
                'logo' => 'SO',
            ],
            [
                'name' => 'Cooperativa Inti',
                'category' => 'Finanzas',
                'description' => 'Beneficios para impulsar tus proyectos.',
                'color' => '#e9ad08',
                'logo' => 'CI',
            ],
            [
                'name' => 'Moda Imbabura',
                'category' => 'Moda',
                'description' => 'Encuentra tu estilo con nuevas tendencias.',
                'color' => '#c85d88',
                'logo' => 'MI',
            ],
            [
                'name' => 'Envíos Express',
                'category' => 'Servicios',
                'description' => 'Soluciones de entrega para tu comodidad.',
                'color' => '#ff7043',
                'logo' => 'EE',
            ],
            [
                'name' => 'Tecno Mundo',
                'category' => 'Tecnología',
                'description' => 'Accesorios y productos tecnológicos.',
                'color' => '#ab278b',
                'logo' => 'TM',
            ],
            [
                'name' => 'Naturaleza Viva',
                'category' => 'Bienestar',
                'description' => 'Cuidamos de ti con productos naturales.',
                'color' => '#299c70',
                'logo' => 'NV',
            ],
            [
                'name' => 'Artesanías del Sol',
                'category' => 'Artesanías',
                'description' => 'Arte, tradición y creatividad de nuestra tierra.',
                'color' => '#d48a36',
                'logo' => 'AS',
            ],
        ];

        $prizeTemplates = [
            [
                'title' => 'Canasta de productos especiales',
                'description' => 'Una selección de productos para disfrutar en familia.',
                'image' => 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=800&h=440&fit=crop',
            ],
            [
                'title' => 'Dos entradas para una experiencia especial',
                'description' => 'Disfruta de una experiencia acompañado.',
                'image' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=800&h=440&fit=crop',
            ],
            [
                'title' => 'Audífonos inalámbricos',
                'description' => 'Escucha tu música favorita con comodidad.',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&h=440&fit=crop',
            ],
            [
                'title' => 'Combo especial de comida',
                'description' => 'Un delicioso combo para disfrutar.',
                'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=800&h=440&fit=crop',
            ],
            [
                'title' => 'Tarjeta de regalo',
                'description' => 'Un beneficio especial para tu próxima compra.',
                'image' => 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=800&h=440&fit=crop',
            ],
            [
                'title' => 'Accesorios de moda',
                'description' => 'Renueva tu estilo con accesorios seleccionados.',
                'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=800&h=440&fit=crop',
            ],
            [
                'title' => 'Vale de servicios',
                'description' => 'Aprovecha un servicio seleccionado del auspiciante.',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&h=440&fit=crop',
            ],
            [
                'title' => 'Accesorio tecnológico',
                'description' => 'Un accesorio práctico para tus dispositivos.',
                'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=800&h=440&fit=crop',
            ],
            [
                'title' => 'Kit de bienestar',
                'description' => 'Productos seleccionados para tu cuidado personal.',
                'image' => 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=800&h=440&fit=crop',
            ],
            [
                'title' => 'Obsequio artesanal',
                'description' => 'Un recuerdo especial inspirado en nuestra cultura.',
                'image' => 'https://images.unsplash.com/photo-1490312278390-ab64016e0aa9?w=800&h=440&fit=crop',
            ],
        ];

        // Generar 100 premios de prueba.
        $allRewards = [];

        for ($i = 1; $i <= 100; $i++) {

            $sponsor = $sponsors[($i - 1) % count($sponsors)];
            $template = $prizeTemplates[($i - 1) % count($prizeTemplates)];

            // 80% vigentes y 20% vencidos, aproximadamente.
            $days = ($i % 5 === 0)
                ? -($i % 15 + 1)
                : ($i % 90 + 1);

            $expiration = now('America/Guayaquil')
                ->startOfDay()
                ->addDays($days);

            $allRewards[] = [
                'id' => $i,
                'title' => $template['title'],
                'description' => $template['description'],
                'image' => $template['image'],
                'sponsor_name' => $sponsor['name'],
                'sponsor_description' => $sponsor['description'],
                'sponsor_logo' => 'https://ui-avatars.com/api/?name='
                    . urlencode($sponsor['logo'])
                    . '&background=' . ltrim($sponsor['color'], '#')
                    . '&color=ffffff&size=128&bold=true',
                'category' => $sponsor['category'],
                'color' => $sponsor['color'],
                'expires_at' => $expiration,
                'is_expired' => $expiration->isPast(),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | FILTERS
        |--------------------------------------------------------------------------
        */

        $search = trim((string) request()->query('search', ''));
        $category = (string) request()->query('category', '');
        $status = (string) request()->query('status', 'all');
        $sort = (string) request()->query('sort', 'recent');

        $categories = collect($sponsors)
            ->pluck('category')
            ->unique()
            ->sort()
            ->values()
            ->all();

        $filteredRewards = collect($allRewards)
            ->filter(function ($reward) use ($search, $category, $status) {

                if ($search !== '') {
                    $term = mb_strtolower($search);

                    $content = mb_strtolower(implode(' ', [
                        $reward['title'],
                        $reward['description'],
                        $reward['sponsor_name'],
                        $reward['sponsor_description'],
                    ]));

                    if (!str_contains($content, $term)) {
                        return false;
                    }
                }

                if ($category !== '' && $reward['category'] !== $category) {
                    return false;
                }

                if ($status === 'active' && $reward['is_expired']) {
                    return false;
                }

                if ($status === 'expired' && !$reward['is_expired']) {
                    return false;
                }

                return true;
            });

        // Ordenar los resultados.
        $filteredRewards = match ($sort) {
            'expiring' => $filteredRewards->sortBy(
                fn ($reward) => $reward['expires_at']->timestamp
            ),
            'name' => $filteredRewards->sortBy('sponsor_name'),
            'oldest' => $filteredRewards->sortBy('id'),
            default => $filteredRewards->sortByDesc('id'),
        };

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $perPage = 12;
        $totalRewards = $filteredRewards->count();

        $currentPage = max(
            1,
            \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage()
        );

        $lastPage = max(1, (int) ceil($totalRewards / $perPage));
        $currentPage = min($currentPage, $lastPage);

        $pageItems = $filteredRewards
            ->values()
            ->forPage($currentPage, $perPage)
            ->values();

        $rewards = new \Illuminate\Pagination\LengthAwarePaginator(
            $pageItems,
            $totalRewards,
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    @endphp

    <div id="app-management" class="manager-reward">

        <!-- ==========================================
             HERO / HEADER
        =========================================== -->
        <section class="manager-reward__hero">

            <div class="manager-reward__hero-content">

            <span class="manager-reward__eyebrow">
                <i class="bi bi-gift-fill" aria-hidden="true"></i>
                KARAY · PREMIOS DE AUSPICIANTES
            </span>

                <h1 class="manager-reward__heading">
                    Descubre premios increíbles
                </h1>

                <p class="manager-reward__intro">
                    Conoce los premios que nuestros auspiciantes
                    tienen para ti. Participa, gana Yapitas y
                    descubre nuevas oportunidades.
                </p>

            </div>

            <div class="manager-reward__hero-symbol" aria-hidden="true">
                <i class="bi bi-gift-fill"></i>
            </div>

        </section>

        <div class="manager-reward__container">

            <!-- ==========================================
                 FILTERS
            =========================================== -->
            <form
                class="manager-reward__filters"
                method="GET"
                action="{{ request()->url() }}"
                role="search"
            >

                <div class="manager-reward__search">
                    <i class="bi bi-search" aria-hidden="true"></i>

                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        class="manager-reward__search-input"
                        placeholder="Buscar auspiciantes o premios..."
                        aria-label="Buscar auspiciantes o premios"
                    >
                </div>

                <div class="manager-reward__filter-field">
                    <i class="bi bi-grid" aria-hidden="true"></i>

                    <select
                        name="category"
                        class="manager-reward__select"
                        aria-label="Filtrar por categoría"
                    >
                        <option value="">Todas las categorías</option>

                        @foreach($categories as $item)
                            <option
                                value="{{ $item }}"
                                @selected($category === $item)
                            >
                                {{ $item }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="manager-reward__filter-field">
                    <i class="bi bi-gift" aria-hidden="true"></i>

                    <select
                        name="status"
                        class="manager-reward__select"
                        aria-label="Filtrar por vigencia"
                    >
                        <option value="all" @selected($status === 'all')>
                            Todos los premios
                        </option>

                        <option value="active" @selected($status === 'active')>
                            Premios vigentes
                        </option>

                        <option value="expired" @selected($status === 'expired')>
                            Premios vencidos
                        </option>
                    </select>
                </div>

                <div class="manager-reward__filter-field">
                    <i class="bi bi-sort-down" aria-hidden="true"></i>

                    <select
                        name="sort"
                        class="manager-reward__select"
                        aria-label="Ordenar premios"
                    >
                        <option value="recent" @selected($sort === 'recent')>
                            Más recientes
                        </option>

                        <option value="oldest" @selected($sort === 'oldest')>
                            Más antiguos
                        </option>

                        <option value="expiring" @selected($sort === 'expiring')>
                            Próximos a vencer
                        </option>

                        <option value="name" @selected($sort === 'name')>
                            Auspiciante A-Z
                        </option>
                    </select>
                </div>

                <button
                    type="submit"
                    class="manager-reward__filter-submit"
                >
                    <i class="bi bi-funnel" aria-hidden="true"></i>
                    <span>Filtrar</span>
                </button>

            </form>

            <!-- ==========================================
                 RESULTS BAR
            =========================================== -->
            <div class="manager-reward__results">

                <div class="manager-reward__results-information">

                    <h2 class="manager-reward__section-title">
                        Premios disponibles
                    </h2>

                    <p class="manager-reward__results-description">
                        Explora los beneficios de nuestros auspiciantes.
                    </p>

                </div>

                <div class="manager-reward__results-actions">

                <span class="manager-reward__total">
                    <i class="bi bi-gift" aria-hidden="true"></i>
                    {{ $rewards->total() }}
                    {{ $rewards->total() === 1 ? 'premio' : 'premios' }}
                </span>

                    @if($search !== '' || $category !== '' || $status !== 'all' || $sort !== 'recent')
                        <a
                            href="{{ request()->url() }}"
                            class="manager-reward__clear"
                        >
                            <i class="bi bi-x-circle" aria-hidden="true"></i>
                            Limpiar filtros
                        </a>
                    @endif

                </div>

            </div>

            <!-- ==========================================
                 REWARD CARDS
            =========================================== -->
            <div class="manager-reward__grid">

                @forelse($rewards as $reward)

                    <article
                        class="manager-reward__card {{ $reward['is_expired'] ? 'manager-reward__card--expired' : '' }}"
                        style="--reward-accent: {{ $reward['color'] }};"
                        data-reward-id="{{ $reward['id'] }}"
                    >

                        <!-- IMAGE -->
                        <div class="manager-reward__media">

                            <img
                                class="manager-reward__photo"
                                src="{{ $reward['image'] }}"
                                alt="Fotografía de {{ $reward['title'] }}"
                                loading="lazy"
                            >

                            <span class="manager-reward__category">
                            <i class="bi bi-tag-fill" aria-hidden="true"></i>
                            {{ $reward['category'] }}
                        </span>

                            @if($reward['is_expired'])
                                <span class="manager-reward__status manager-reward__status--expired">
                                Vencido
                            </span>
                            @endif

                        </div>

                        <!-- SPONSOR LOGO -->
                        <div class="manager-reward__brand">

                            <img
                                class="manager-reward__brand-logo"
                                src="{{ $reward['sponsor_logo'] }}"
                                alt="Logo de {{ $reward['sponsor_name'] }}"
                                loading="lazy"
                            >

                        </div>

                        <!-- CARD BODY -->
                        <div class="manager-reward__card-body">

                            <div class="manager-reward__sponsor">

                                <h3 class="manager-reward__sponsor-name">
                                    {{ $reward['sponsor_name'] }}
                                </h3>

                                <p class="manager-reward__sponsor-description">
                                    {{ $reward['sponsor_description'] }}
                                </p>

                            </div>

                            <!-- PRIZE + EXPIRATION -->
                            <div class="manager-reward__details">

                                <div class="manager-reward__prize">

                                <span class="manager-reward__detail-icon">
                                    <i class="bi bi-gift-fill" aria-hidden="true"></i>
                                </span>

                                    <div class="manager-reward__detail-text">

                                    <span class="manager-reward__detail-label">
                                        Premio
                                    </span>

                                        <strong class="manager-reward__prize-title">
                                            {{ $reward['title'] }}
                                        </strong>

                                    </div>

                                </div>

                                <div class="manager-reward__expiration">

                                <span class="manager-reward__detail-icon">
                                    <i class="bi bi-calendar-event" aria-hidden="true"></i>
                                </span>

                                    <div class="manager-reward__detail-text">

                                    <span class="manager-reward__detail-label">
                                        {{ $reward['is_expired'] ? 'Venció el' : 'Vence el' }}
                                    </span>

                                        <strong class="manager-reward__expiration-date">
                                            {{ $reward['expires_at']->format('d/m/Y') }}
                                        </strong>

                                    </div>

                                </div>

                            </div>

                            <!-- ACTION -->
                            <button
                                type="button"
                                class="manager-reward__action"
                                data-reward-detail="{{ $reward['id'] }}"
                                aria-label="Ver detalles de {{ $reward['title'] }}"
                            >
                                <span>Ver detalles</span>
                                <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </button>

                        </div>

                    </article>

                @empty

                    <div class="manager-reward__empty">

                        <i class="bi bi-gift" aria-hidden="true"></i>

                        <h3>
                            No encontramos premios
                        </h3>

                        <p>
                            Prueba cambiando los filtros de búsqueda.
                        </p>

                        <a
                            href="{{ request()->url() }}"
                            class="manager-reward__empty-action"
                        >
                            Mostrar todos los premios
                        </a>

                    </div>

                @endforelse

            </div>



        </div>

    </div>

@endsection

