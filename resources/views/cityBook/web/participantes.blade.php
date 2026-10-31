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
        /* ============================================
           YAPITA - HALLOWEEN PARTICIPANTS
           ============================================ */

        #app-management.manager-participantes {
            --yp-blue: #1648e8;
            --yp-blue-light: #3676ff;
            --yp-yellow: #ffda22;
            --yp-orange: #ff8528;
            --yp-purple: #7437d4;
            --yp-dark: #10142b;
            --yp-card: #1b2344;
            --yp-white: #ffffff;

            min-height: 100vh;
            padding: 45px 15px 80px;

            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(54, 118, 255, .24),
                    transparent 35%
                ),
                radial-gradient(
                    circle at 90% 25%,
                    rgba(255, 133, 40, .13),
                    transparent 30%
                ),
                linear-gradient(
                    145deg,
                    #10142b,
                    #191235 65%,
                    #10142b
                );

            color: #ffffff;
            font-family: inherit;
        }

        .manager-participantes * {
            box-sizing: border-box;
        }

        .manager-participantes .yp-container {
            max-width: 1250px;
            margin: auto;
        }

        /* ============================================
           HERO
           ============================================ */

        .manager-participantes .yp-hero {
            position: relative;
            overflow: hidden;
            text-align: center;

            padding: 55px 25px;
            margin-bottom: 35px;

            border-radius: 28px;
            border: 2px solid rgba(255, 218, 34, .25);

            background:
                radial-gradient(
                    circle at 15% 50%,
                    rgba(255, 133, 40, .15),
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    #183fb2,
                    #25205c 65%,
                    #431d69
                );

            box-shadow: 0 20px 50px rgba(0, 0, 0, .2);
        }

        .manager-participantes .yp-hero::before {
            content: "🎃";
            position: absolute;
            top: 25px;
            left: 35px;
            font-size: 60px;
            opacity: .22;
            transform: rotate(-20deg);
        }

        .manager-participantes .yp-hero::after {
            content: "👻";
            position: absolute;
            bottom: 25px;
            right: 35px;
            font-size: 65px;
            opacity: .25;
            transform: rotate(15deg);
        }

        .manager-participantes .yp-edition {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 9px 20px;
            margin-bottom: 20px;

            border-radius: 50px;

            background: var(--yp-yellow);
            color: #182657;

            font-size: 13px;
            font-weight: 900;
            letter-spacing: .6px;
        }

        .manager-participantes .yp-title {
            margin: 0 0 15px;

            color: #ffffff;
            font-size: clamp(30px, 5vw, 56px);
            font-weight: 900;
            line-height: 1.15;
        }

        .manager-participantes .yp-title span {
            color: var(--yp-yellow);
        }

        .manager-participantes .yp-subtitle {
            max-width: 680px;
            margin: 0 auto;

            color: #e5e8ff;
            font-size: 15px;
            line-height: 1.8;
        }

        /* ============================================
           COUNTER
           ============================================ */

        .manager-participantes .yp-counter {
            display: inline-flex;
            align-items: center;
            gap: 15px;

            margin-top: 28px;
            padding: 16px 25px;

            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, .25);

            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(8px);
        }

        .manager-participantes .yp-counter-icon {
            width: 55px;
            height: 55px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 15px;

            background: var(--yp-yellow);
            color: var(--yp-blue);

            font-size: 27px;
        }

        .manager-participantes .yp-counter-number {
            font-size: 32px;
            font-weight: 900;
            line-height: 1;
            text-align: left;
            color: var(--yp-yellow);
        }

        .manager-participantes .yp-counter-label {
            margin-top: 5px;
            font-size: 12px;
            color: #ffffff;
            text-align: left;
        }

        /* ============================================
           TOOLBAR
           ============================================ */

        .manager-participantes .yp-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;

            margin-bottom: 25px;
        }

        .manager-participantes .yp-section-title {
            margin: 0 0 7px;

            font-size: 24px;
            font-weight: 900;
            color: var(--yp-yellow);
        }

        .manager-participantes .yp-section-description {
            margin: 0;
            color: #bfc8ee;
            font-size: 13px;
        }

        .manager-participantes .yp-search {
            position: relative;
            width: 100%;
            max-width: 350px;
        }

        .manager-participantes .yp-search i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);

            color: var(--yp-yellow);
            font-size: 18px;
        }

        .manager-participantes .yp-search input {
            display: block;
            width: 100%;
            height: 48px;

            padding: 0 15px 0 45px;

            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 14px;

            background: #222c52;
            color: #ffffff;

            outline: none;
            transition: .2s;
        }

        .manager-participantes .yp-search input::placeholder {
            color: #aab7df;
        }

        .manager-participantes .yp-search input:focus {
            border-color: var(--yp-yellow);
            box-shadow: 0 0 0 3px rgba(255, 218, 34, .12);
        }

        /* ============================================
           PARTICIPANTS GRID
           ============================================ */

        .manager-participantes .yp-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }

        .manager-participantes .yp-card {
            position: relative;

            display: flex;
            flex-direction: column;
            align-items: center;

            min-width: 0;
            padding: 30px 16px 25px;

            border-radius: 22px;
            border: 1px solid rgba(255, 255, 255, .12);

            background:
                linear-gradient(
                    155deg,
                    #263567,
                    #1b2344 75%
                );

            text-align: center;

            transition:
                transform .25s ease,
                border-color .25s ease,
                box-shadow .25s ease;
        }

        .manager-participantes .yp-card:hover {
            transform: translateY(-6px);

            border-color: var(--yp-yellow);

            box-shadow:
                0 15px 35px rgba(0, 0, 0, .3),
                0 0 20px rgba(255, 218, 34, .08);
        }

        .manager-participantes .yp-card-number {
            position: absolute;
            top: 15px;
            right: 15px;

            padding: 5px 9px;

            border-radius: 8px;
            background: rgba(255, 218, 34, .12);

            color: var(--yp-yellow);
            font-size: 11px;
            font-weight: 800;
        }

        /* ============================================
           AVATAR
           ============================================ */

        .manager-participantes .yp-avatar-wrapper {
            position: relative;

            width: 100px;
            height: 100px;

            padding: 4px;
            margin-bottom: 20px;

            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    var(--yp-yellow),
                    var(--yp-orange),
                    var(--yp-blue-light)
                );
        }

        .manager-participantes .yp-avatar,
        .manager-participantes .yp-avatar-fallback {
            width: 100%;
            height: 100%;

            border-radius: 50%;
            object-fit: cover;

            background: #263567;
        }

        .manager-participantes .yp-avatar-fallback {
            display: flex;
            align-items: center;
            justify-content: center;

            color: var(--yp-yellow);
            font-size: 34px;
            font-weight: 900;
        }

        .manager-participantes .yp-avatar-decoration {
            position: absolute;
            right: -9px;
            bottom: -6px;

            width: 36px;
            height: 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;
            border: 3px solid #263567;

            background: var(--yp-orange);
            font-size: 19px;
        }

        /* ============================================
           NAME AND BADGE
           ============================================ */

        .manager-participantes .yp-name {
            margin: 0 0 15px;

            min-height: 44px;

            color: #ffffff;
            font-size: 17px;
            font-weight: 800;
            line-height: 1.35;

            overflow-wrap: anywhere;
        }

        .manager-participantes .yp-participant-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;

            margin-top: auto;
            padding: 8px 12px;

            border-radius: 50px;

            background: rgba(255, 218, 34, .12);
            border: 1px solid rgba(255, 218, 34, .2);

            color: var(--yp-yellow);
            font-size: 11px;
            font-weight: 800;
        }

        /* ============================================
           EMPTY
           ============================================ */

        .manager-participantes .yp-empty {
            padding: 60px 20px;
            text-align: center;
            color: #c8d0f2;
        }

        .manager-participantes .yp-empty i {
            display: block;
            margin-bottom: 15px;
            font-size: 45px;
            color: var(--yp-yellow);
        }

        /* ============================================
           FOOTER
           ============================================ */

        .manager-participantes .yp-footer {
            margin-top: 55px;
            padding: 30px 15px;

            border-top: 1px solid rgba(255, 255, 255, .12);

            text-align: center;
            color: #bdc8ee;
        }

        .manager-participantes .yp-footer strong {
            color: var(--yp-yellow);
        }

        /* ============================================
           RESPONSIVE
           ============================================ */

        @media (max-width: 991px) {
            .manager-participantes .yp-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 767px) {
            #app-management.manager-participantes {
                padding: 20px 12px 60px;
            }

            .manager-participantes .yp-hero {
                padding: 45px 15px;
                border-radius: 20px;
            }

            .manager-participantes .yp-hero::before,
            .manager-participantes .yp-hero::after {
                font-size: 35px;
            }

            .manager-participantes .yp-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .manager-participantes .yp-toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .manager-participantes .yp-search {
                max-width: 100%;
            }

            .manager-participantes .yp-card {
                padding: 27px 10px 20px;
            }

            .manager-participantes .yp-avatar-wrapper {
                width: 78px;
                height: 78px;
            }

            .manager-participantes .yp-name {
                font-size: 14px;
            }

            .manager-participantes .yp-participant-badge {
                font-size: 10px;
            }
        }

        @media (max-width: 350px) {
            .manager-participantes .yp-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
@section('additional-scripts')


    <script>
        var $users = <?php echo json_encode($users) ?>;
        var $rewards = <?php echo json_encode($rewards) ?>;



    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ URL::asset($resourcePathServer.'libs/blockui/blockui.min.js') }}"></script>

    <script src="{{ URL::asset($resourcePathServer.'libs/toast/jquery.toast.min.js') }}"
            type='text/javascript'></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        /**
         * ==========================================================
         * YAPITA PARTICIPANTS
         * Halloween Otavalo - 7.ª Edición
         * ==========================================================
         */

        class YapitaParticipantsUtil {

            static config = {
                root: '.yapita-participants',

                selectors: {
                    searchInput: '.yapita-participants__search-input',
                    searchButton: '.yapita-participants__search-button',
                    resetButton: '.yapita-participants__search-reset',

                    grid: '.yapita-participants__grid',
                    card: '.yapita-participants__card',

                    resultsCount: '.yapita-participants__results-count',

                    empty: '.yapita-participants__empty',

                    avatar: '.yapita-participants__avatar',
                    avatarFallback: '.yapita-participants__avatar-fallback'
                },

                classes: {
                    hidden: 'yapita-participants__card--hidden',
                    emptyVisible: 'yapita-participants__empty--visible',
                    avatarHidden: 'yapita-participants__avatar--hidden',
                    fallbackHidden: 'yapita-participants__avatar-fallback--hidden'
                }
            };


            static instance = null;


            constructor(root) {

                this.root = root;

                this.searchInput = null;
                this.searchButton = null;
                this.resetButton = null;

                this.grid = null;
                this.cards = [];

                this.resultsCount = null;
                this.emptyState = null;

                this.initialized = false;

            }


            /**
             * ==========================================
             * INITIALIZE
             * ==========================================
             */

            static init() {

                const root = document.querySelector(
                    this.config.root
                );

                if (!root) {
                    return null;
                }

                if (
                    this.instance &&
                    this.instance.root === root &&
                    this.instance.initialized
                ) {
                    return this.instance;
                }

                this.instance = new YapitaParticipantsUtil(root);

                this.instance.initialize();

                return this.instance;

            }


            initialize() {

                if (this.initialized) {
                    return;
                }

                this.cacheElements();

                this.bindEvents();

                this.initializeAvatars();

                this.filterParticipants();

                this.initialized = true;

            }


            /**
             * ==========================================
             * CACHE DOM ELEMENTS
             * ==========================================
             */

            cacheElements() {

                const selectors =
                    YapitaParticipantsUtil.config.selectors;

                this.searchInput = this.root.querySelector(
                    selectors.searchInput
                );

                this.searchButton = this.root.querySelector(
                    selectors.searchButton
                );

                this.resetButton = this.root.querySelector(
                    selectors.resetButton
                );

                this.grid = this.root.querySelector(
                    selectors.grid
                );

                this.cards = Array.from(
                    this.root.querySelectorAll(
                        selectors.card
                    )
                );

                this.resultsCount = this.root.querySelector(
                    selectors.resultsCount
                );

                this.emptyState = this.root.querySelector(
                    selectors.empty
                );

            }


            /**
             * ==========================================
             * BIND EVENTS
             * ==========================================
             */

            bindEvents() {

                if (this.searchInput) {

                    this.searchInput.addEventListener(
                        'input',
                        () => {
                            this.filterParticipants();
                        }
                    );

                    this.searchInput.addEventListener(
                        'keydown',
                        (event) => {

                            if (event.key === 'Enter') {

                                event.preventDefault();

                                this.filterParticipants();

                            }

                        }
                    );

                }


                if (this.searchButton) {

                    this.searchButton.addEventListener(
                        'click',
                        (event) => {

                            event.preventDefault();

                            this.filterParticipants();

                        }
                    );

                }


                if (this.resetButton) {

                    this.resetButton.addEventListener(
                        'click',
                        (event) => {

                            event.preventDefault();

                            this.resetSearch();

                        }
                    );

                }

            }


            /**
             * ==========================================
             * NORMALIZE TEXT
             * ==========================================
             */

            normalizeText(value) {

                return String(value ?? '')
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .toLowerCase()
                    .trim();

            }


            /**
             * ==========================================
             * GET SEARCHABLE DATA
             * ==========================================
             */

            getCardSearchData(card) {

                const name = card.dataset.name || '';

                const code = card.dataset.code || '';

                const email = card.dataset.email || '';

                return this.normalizeText(
                    `${name} ${code} ${email}`
                );

            }


            /**
             * ==========================================
             * FILTER PARTICIPANTS
             * ==========================================
             */

            filterParticipants() {

                const query = this.normalizeText(
                    this.searchInput?.value || ''
                );

                const hiddenClass =
                    YapitaParticipantsUtil.config.classes.hidden;

                let visibleCount = 0;


                this.cards.forEach((card) => {

                    const searchableData =
                        this.getCardSearchData(card);

                    const matches =
                        query === '' ||
                        searchableData.includes(query);


                    card.classList.toggle(
                        hiddenClass,
                        !matches
                    );


                    if (matches) {
                        visibleCount++;
                    }

                });


                this.updateResults(
                    visibleCount,
                    query
                );


                this.updateEmptyState(
                    visibleCount
                );


                this.dispatchEvent(
                    'yapita:participants:filtered',
                    {
                        query,
                        visible: visibleCount,
                        total: this.cards.length
                    }
                );

            }


            /**
             * ==========================================
             * UPDATE RESULTS
             * ==========================================
             */

            updateResults(visibleCount, query) {

                if (!this.resultsCount) {
                    return;
                }

                const total = this.cards.length;

                if (query === '') {

                    this.resultsCount.textContent =
                        `${total} participante${total !== 1 ? 's' : ''}`;

                    return;
                }


                this.resultsCount.textContent =
                    `${visibleCount} de ${total} participantes`;

            }


            /**
             * ==========================================
             * EMPTY STATE
             * ==========================================
             */

            updateEmptyState(visibleCount) {

                if (!this.emptyState) {
                    return;
                }

                const visibleClass =
                    YapitaParticipantsUtil.config.classes.emptyVisible;

                const shouldShow =
                    visibleCount === 0 &&
                    this.cards.length > 0;


                this.emptyState.classList.toggle(
                    visibleClass,
                    shouldShow
                );

            }


            /**
             * ==========================================
             * RESET SEARCH
             * ==========================================
             */

            resetSearch() {

                if (this.searchInput) {

                    this.searchInput.value = '';

                    this.searchInput.focus();

                }

                this.filterParticipants();


                this.dispatchEvent(
                    'yapita:participants:reset',
                    {
                        total: this.cards.length
                    }
                );

            }


            /**
             * ==========================================
             * AVATAR MANAGEMENT
             * ==========================================
             */

            initializeAvatars() {

                const selectors =
                    YapitaParticipantsUtil.config.selectors;

                const avatars = this.root.querySelectorAll(
                    selectors.avatar
                );


                avatars.forEach((avatar) => {

                    avatar.addEventListener(
                        'error',
                        () => {
                            this.handleAvatarError(avatar);
                        }
                    );


                    if (
                        avatar.complete &&
                        avatar.naturalWidth === 0
                    ) {

                        this.handleAvatarError(avatar);

                    }

                });

            }


            /**
             * ==========================================
             * AVATAR ERROR
             * ==========================================
             */

            handleAvatarError(avatar) {

                const classes =
                    YapitaParticipantsUtil.config.classes;

                const selectors =
                    YapitaParticipantsUtil.config.selectors;


                avatar.classList.add(
                    classes.avatarHidden
                );


                const container = avatar.parentElement;

                if (!container) {
                    return;
                }


                const fallback = container.querySelector(
                    selectors.avatarFallback
                );


                if (fallback) {

                    fallback.classList.remove(
                        classes.fallbackHidden
                    );

                }

            }


            /**
             * ==========================================
             * CUSTOM EVENTS
             * ==========================================
             */

            dispatchEvent(eventName, detail = {}) {

                this.root.dispatchEvent(
                    new CustomEvent(
                        eventName,
                        {
                            bubbles: true,
                            detail
                        }
                    )
                );

            }


            /**
             * ==========================================
             * REFRESH PARTICIPANTS
             * ==========================================
             */

            refresh() {

                const selectors =
                    YapitaParticipantsUtil.config.selectors;

                this.cards = Array.from(
                    this.root.querySelectorAll(
                        selectors.card
                    )
                );

                this.initializeAvatars();

                this.filterParticipants();

            }


            /**
             * ==========================================
             * DESTROY
             * ==========================================
             */

            destroy() {

                this.initialized = false;

                if (
                    YapitaParticipantsUtil.instance === this
                ) {

                    YapitaParticipantsUtil.instance = null;

                }

            }

        }


        /**
         * ==========================================
         * INITIALIZE ON DOM READY
         * ==========================================
         */

        function initYapitaParticipants() {

            YapitaParticipantsUtil.init();

        }


        if (document.readyState === 'loading') {

            document.addEventListener(
                'DOMContentLoaded',
                initYapitaParticipants
            );

        } else {

            initYapitaParticipants();

        }


        /**
         * ==========================================
         * GLOBAL ACCESS
         * ==========================================
         */

        window.YapitaParticipantsUtil =
            YapitaParticipantsUtil;
    </script>
    <style>
        /* ==========================================================
   YAPITA PARTICIPANTS
   Halloween Otavalo - 7.ª Edición Dulce o Truco
   Metodología BEM
   ========================================================== */

        /* ==========================================================
           1. VARIABLES Y CONTENEDOR
           ========================================================== */

        .yapita-participants {
            --yp-primary: #2448f5;
            --yp-primary-dark: #1238c7;
            --yp-primary-light: #eaf0ff;

            --yp-yellow: #ffdc00;
            --yp-yellow-light: #fff7c2;
            --yp-orange: #ff922b;

            --yp-purple: #7534b8;

            --yp-text: #14245a;
            --yp-text-secondary: #627093;

            --yp-white: #ffffff;
            --yp-background: #f5f8ff;

            --yp-border: #dce5ff;
            --yp-success: #16874c;

            --yp-radius: 20px;

            --yp-shadow:
                0 8px 25px rgba(31, 65, 150, .09);

            --yp-shadow-hover:
                0 15px 35px rgba(31, 65, 150, .16);

            min-height: 100vh;

            padding: 0 0 70px;

            background: var(--yp-background);

            color: var(--yp-text);

            font-family: inherit;
        }

        .yapita-participants *,
        .yapita-participants *::before,
        .yapita-participants *::after {
            box-sizing: border-box;
        }

        .yapita-participants__container {
            width: 100%;
            max-width: 1320px;

            margin: 0 auto;
            padding: 0 20px;
        }

        /* ==========================================================
           2. HERO HALLOWEEN
           ========================================================== */

        .yapita-participants__hero {
            position: relative;

            overflow: hidden;

            min-height: 260px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 45px 25px 55px;

            text-align: center;

            background:
                radial-gradient(
                    circle at 15% 30%,
                    rgba(255, 220, 0, .25),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 85% 20%,
                    rgba(255, 255, 255, .25),
                    transparent 30%
                ),
                linear-gradient(
                    120deg,
                    #dceaff 0%,
                    #b9d5ff 45%,
                    #e4edff 100%
                );

            border-bottom: 7px solid var(--yp-yellow);
        }

        .yapita-participants__hero::before {
            content: "🎃";

            position: absolute;

            left: 7%;
            bottom: 20px;

            font-size: 90px;

            transform: rotate(-12deg);

            filter: drop-shadow(
                0 8px 8px rgba(0, 0, 0, .12)
            );
        }

        .yapita-participants__hero::after {
            content: "👻";

            position: absolute;

            right: 8%;
            top: 30px;

            font-size: 85px;

            transform: rotate(12deg);

            filter: drop-shadow(
                0 8px 8px rgba(0, 0, 0, .1)
            );
        }

        .yapita-participants__hero-content {
            position: relative;
            z-index: 2;

            max-width: 850px;
        }

        .yapita-participants__edition {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            padding: 9px 20px;

            margin-bottom: 20px;

            border-radius: 50px;

            background: var(--yp-purple);
            color: #ffffff;

            font-size: 13px;
            font-weight: 800;

            box-shadow:
                0 5px 15px rgba(117, 52, 184, .2);
        }

        .yapita-participants__title {
            margin: 0 0 12px;

            color: var(--yp-primary);

            font-size: clamp(34px, 5vw, 60px);
            font-weight: 900;

            line-height: 1.1;

            text-shadow:
                2px 3px 0 rgba(255, 255, 255, .9);
        }

        .yapita-participants__title-highlight {
            color: #e67b16;
        }

        .yapita-participants__subtitle {
            margin: 0 auto;

            max-width: 650px;

            color: var(--yp-text);

            font-size: 16px;
            font-weight: 600;

            line-height: 1.7;
        }

        /* ==========================================================
           3. SUMMARY
           ========================================================== */

        .yapita-participants__summary {
            position: relative;
            z-index: 3;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 25px;

            margin-top: 25px;
            margin-bottom: 25px;

            padding: 22px 28px;

            border-radius: var(--yp-radius);

            background: var(--yp-white);

            border: 1px solid var(--yp-border);

            box-shadow: var(--yp-shadow);
        }

        .yapita-participants__summary-info {
            display: flex;
            align-items: center;
            gap: 18px;

            min-width: 0;
        }

        .yapita-participants__summary-icon {
            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            width: 58px;
            height: 58px;

            border-radius: 16px;

            background: var(--yp-yellow-light);

            color: var(--yp-orange);

            font-size: 30px;
        }

        .yapita-participants__summary-title {
            margin: 0 0 5px;

            font-size: 23px;
            font-weight: 900;

            color: var(--yp-primary-dark);
        }

        .yapita-participants__summary-description {
            margin: 0;

            color: var(--yp-text-secondary);

            font-size: 13px;
            line-height: 1.5;
        }

        .yapita-participants__stats {
            display: flex;
            align-items: center;
            gap: 20px;

            flex-shrink: 0;

            padding: 12px 20px;

            border: 2px solid var(--yp-yellow);

            border-radius: 16px;

            background: #fffef5;
        }

        .yapita-participants__stat {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .yapita-participants__stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 45px;
            height: 45px;

            border-radius: 12px;

            background: var(--yp-yellow-light);

            color: var(--yp-primary);

            font-size: 23px;
        }

        .yapita-participants__stat-number {
            display: block;

            font-size: 30px;
            font-weight: 900;

            line-height: 1;

            color: var(--yp-primary);
        }

        .yapita-participants__stat-label {
            display: block;

            margin-top: 5px;

            color: var(--yp-text);

            font-size: 12px;
        }

        .yapita-participants__stat-divider {
            width: 1px;
            height: 45px;

            background: #c9d5ff;
        }

        .yapita-participants__stat-date {
            font-size: 14px;
            font-weight: 800;

            color: var(--yp-text);
        }

        /* ==========================================================
           4. SEARCH
           ========================================================== */

        .yapita-participants__search {
            display: flex;
            align-items: center;
            gap: 12px;

            margin-bottom: 25px;

            padding: 10px;

            border: 1px solid #c7d8ff;

            border-radius: 18px;

            background: var(--yp-white);

            box-shadow: var(--yp-shadow);
        }

        .yapita-participants__search-field {
            position: relative;

            display: flex;
            align-items: center;

            flex: 1;

            min-width: 0;
        }

        .yapita-participants__search-icon {
            position: absolute;

            left: 17px;

            color: var(--yp-primary);

            font-size: 20px;
        }

        .yapita-participants__search-input {
            width: 100%;
            height: 48px;

            padding: 0 15px 0 48px;

            border: none;
            outline: none;

            border-radius: 12px;

            background: #f3f6ff;

            color: var(--yp-text);

            font-size: 14px;

            transition: .2s;
        }

        .yapita-participants__search-input::placeholder {
            color: #7b87a5;
        }

        .yapita-participants__search-input:focus {
            background: #ffffff;

            box-shadow:
                0 0 0 2px var(--yp-primary);
        }

        .yapita-participants__search-button,
        .yapita-participants__search-reset {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            min-height: 46px;

            padding: 0 24px;

            border: none;
            border-radius: 12px;

            font-size: 14px;
            font-weight: 800;

            cursor: pointer;

            transition: .2s;
        }

        .yapita-participants__search-button {
            background:
                linear-gradient(
                    135deg,
                    #ffe600,
                    #ffc400
                );

            color: #17245d;
        }

        .yapita-participants__search-button:hover {
            background: #ffcf00;

            transform: translateY(-2px);
        }

        .yapita-participants__search-reset {
            background: #edf1ff;

            color: var(--yp-primary);
        }

        .yapita-participants__search-reset:hover {
            background: #dce5ff;
        }

        /* ==========================================================
           5. RESULTS
           ========================================================== */

        .yapita-participants__results {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 18px;
        }

        .yapita-participants__results-title {
            margin: 0;

            font-size: 18px;
            font-weight: 800;

            color: var(--yp-primary-dark);
        }

        .yapita-participants__results-count {
            font-size: 13px;

            color: var(--yp-text-secondary);
        }

        /* ==========================================================
           6. GRID
           ========================================================== */

        .yapita-participants__grid {
            display: grid;

            grid-template-columns:
        repeat(4, minmax(0, 1fr));

            gap: 18px;
        }

        /* ==========================================================
           7. PARTICIPANT CARD
           ========================================================== */

        .yapita-participants__card {
            position: relative;

            display: flex;
            flex-direction: column;

            min-width: 0;

            padding: 24px 18px 20px;

            overflow: hidden;

            border-radius: 20px;

            border: 1.5px solid #b7caff;

            background: #ffffff;

            box-shadow: var(--yp-shadow);

            transition:
                transform .25s ease,
                border-color .25s ease,
                box-shadow .25s ease;
        }

        .yapita-participants__card:hover {
            transform: translateY(-5px);

            border-color: var(--yp-primary);

            box-shadow: var(--yp-shadow-hover);
        }

        .yapita-participants__card::after {
            content: "";

            position: absolute;

            left: 0;
            right: 0;
            bottom: 0;

            height: 8px;

            background:
                linear-gradient(
                    90deg,
                    var(--yp-yellow),
                    var(--yp-orange)
                );
        }

        .yapita-participants__card-number {
            position: absolute;

            top: 12px;
            right: 12px;

            padding: 6px 10px;

            border-radius: 9px;

            background: var(--yp-yellow);

            color: #14245a;

            font-size: 12px;
            font-weight: 900;
        }

        /* ==========================================================
           8. AVATAR
           ========================================================== */

        .yapita-participants__avatar-container {
            position: relative;

            width: 95px;
            height: 95px;

            margin: 0 auto 20px;

            padding: 4px;

            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    var(--yp-yellow),
                    var(--yp-orange)
                );
        }

        .yapita-participants__avatar {
            display: block;

            width: 100%;
            height: 100%;

            border-radius: 50%;

            object-fit: cover;

            background: #eaf0ff;
        }

        .yapita-participants__avatar-fallback {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 100%;
            height: 100%;

            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    #2448f5,
                    #7139c8
                );

            color: #ffffff;

            font-size: 35px;
            font-weight: 900;
        }

        .yapita-participants__avatar-decoration {
            position: absolute;

            right: -7px;
            bottom: -5px;

            display: flex;
            align-items: center;
            justify-content: center;

            width: 35px;
            height: 35px;

            border-radius: 50%;

            border: 3px solid #ffffff;

            background: var(--yp-yellow);

            font-size: 18px;
        }

        /* ==========================================================
           9. PARTICIPANT INFORMATION
           ========================================================== */

        .yapita-participants__card-name {
            margin: 0 0 18px;

            min-height: 44px;

            color: var(--yp-text);

            text-align: center;

            font-size: 17px;
            font-weight: 900;

            line-height: 1.3;

            overflow-wrap: anywhere;
        }

        .yapita-participants__card-details {
            display: flex;
            flex-direction: column;

            gap: 12px;

            margin-bottom: 20px;
        }

        .yapita-participants__detail {
            display: flex;
            align-items: flex-start;

            gap: 10px;

            min-width: 0;

            color: var(--yp-text);

            font-size: 13px;
        }

        .yapita-participants__detail-icon {
            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            width: 22px;
            height: 22px;

            border-radius: 7px;

            background: var(--yp-primary-light);

            color: var(--yp-primary);

            font-size: 13px;
        }

        .yapita-participants__detail-label {
            font-weight: 800;
        }

        .yapita-participants__code {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-width: 45px;

            padding: 4px 12px;

            border-radius: 20px;

            background: var(--yp-primary);

            color: #ffffff;

            font-size: 13px;
            font-weight: 900;
        }

        .yapita-participants__email {
            display: block;

            min-width: 0;

            color: var(--yp-text);

            font-size: 12px;

            overflow-wrap: anywhere;
            word-break: break-word;
        }

        /* ==========================================================
           10. STATUS BADGE
           ========================================================== */

        .yapita-participants__badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            width: 100%;

            margin-top: auto;

            padding: 9px 10px;

            border-radius: 30px;

            background: #f1ffd7;

            color: #166c3a;

            border: 1px solid #d6ed9a;

            font-size: 11px;
            font-weight: 800;
        }

        .yapita-participants__badge-icon {
            color: var(--yp-success);

            font-size: 15px;
        }

        /* ==========================================================
           11. EMPTY STATE
           ========================================================== */

        .yapita-participants__empty {
            display: none;

            padding: 65px 20px;

            text-align: center;

            border-radius: 20px;

            background: #ffffff;

            border: 1px dashed #b7caff;
        }

        .yapita-participants__empty-icon {
            display: block;

            margin-bottom: 15px;

            color: var(--yp-primary);

            font-size: 45px;
        }

        .yapita-participants__empty-title {
            margin: 0 0 8px;

            color: var(--yp-primary-dark);

            font-size: 22px;
            font-weight: 900;
        }

        .yapita-participants__empty-description {
            margin: 0;

            color: var(--yp-text-secondary);

            font-size: 14px;
        }

        /* ==========================================================
           12. FOOTER
           ========================================================== */

        .yapita-participants__footer {
            position: relative;

            margin-top: 55px;

            padding: 45px 20px;

            overflow: hidden;

            text-align: center;

            background:
                linear-gradient(
                    135deg,
                    #2448f5,
                    #1742c9
                );

            color: #ffffff;
        }

        .yapita-participants__footer::before {
            content: "🦇";

            position: absolute;

            top: 20px;
            left: 8%;

            font-size: 45px;

            opacity: .45;
        }

        .yapita-participants__footer::after {
            content: "🎃";

            position: absolute;

            right: 8%;
            bottom: 15px;

            font-size: 50px;
        }

        .yapita-participants__footer-title {
            margin: 0 0 12px;

            color: var(--yp-yellow);

            font-size: 20px;
            font-weight: 900;
        }

        .yapita-participants__footer-description {
            max-width: 650px;

            margin: 0 auto 15px;

            color: #e4ebff;

            font-size: 13px;

            line-height: 1.7;
        }

        .yapita-participants__footer-brand {
            color: var(--yp-yellow);

            font-weight: 900;
        }

        /* ==========================================================
           13. UTILITIES / MODIFIERS
           ========================================================== */

        .yapita-participants__card--hidden {
            display: none !important;
        }

        .yapita-participants__empty--visible {
            display: block;
        }

        .yapita-participants__avatar--hidden {
            display: none;
        }

        .yapita-participants__avatar-fallback--hidden {
            display: none;
        }

        /* ==========================================================
           14. RESPONSIVE TABLET
           ========================================================== */

        @media (max-width: 1100px) {

            .yapita-participants__grid {
                grid-template-columns:
            repeat(3, minmax(0, 1fr));
            }

            .yapita-participants__summary {
                flex-wrap: wrap;
            }

            .yapita-participants__stats {
                margin-left: auto;
            }

        }

        /* ==========================================================
           15. RESPONSIVE MOBILE
           ========================================================== */

        @media (max-width: 767px) {

            .yapita-participants {
                padding-bottom: 40px;
            }

            .yapita-participants__container {
                padding: 0 12px;
            }

            .yapita-participants__hero {
                min-height: 230px;

                padding: 35px 18px 45px;
            }

            .yapita-participants__hero::before {
                left: 1%;
                bottom: 10px;

                font-size: 45px;
            }

            .yapita-participants__hero::after {
                right: 2%;
                top: 15px;

                font-size: 45px;
            }

            .yapita-participants__title {
                font-size: 34px;
            }

            .yapita-participants__subtitle {
                font-size: 13px;
            }

            .yapita-participants__summary {
                flex-direction: column;
                align-items: stretch;

                gap: 18px;

                padding: 20px 15px;
            }

            .yapita-participants__summary-title {
                font-size: 19px;
            }

            .yapita-participants__summary-icon {
                width: 45px;
                height: 45px;

                font-size: 23px;
            }

            .yapita-participants__stats {
                width: 100%;

                margin: 0;

                justify-content: space-around;

                padding: 12px;
            }

            .yapita-participants__stat-number {
                font-size: 25px;
            }

            .yapita-participants__stat-date {
                font-size: 12px;
            }

            .yapita-participants__search {
                flex-wrap: wrap;

                gap: 8px;
            }

            .yapita-participants__search-field {
                flex: 0 0 100%;
            }

            .yapita-participants__search-button,
            .yapita-participants__search-reset {
                flex: 1;

                padding: 0 12px;
            }

            .yapita-participants__grid {
                grid-template-columns:
            repeat(2, minmax(0, 1fr));

                gap: 12px;
            }

            .yapita-participants__card {
                padding: 20px 11px 18px;
            }

            .yapita-participants__avatar-container {
                width: 75px;
                height: 75px;
            }

            .yapita-participants__avatar-fallback {
                font-size: 27px;
            }

            .yapita-participants__card-name {
                font-size: 14px;

                min-height: 38px;
            }

            .yapita-participants__detail {
                font-size: 11px;

                gap: 6px;
            }

            .yapita-participants__email {
                font-size: 11px;
            }

            .yapita-participants__badge {
                font-size: 10px;
            }

            .yapita-participants__footer {
                padding: 40px 15px;
            }

        }

        /* ==========================================================
           16. SMALL MOBILE
           ========================================================== */

        @media (max-width: 380px) {

            .yapita-participants__grid {
                grid-template-columns: 1fr;
            }

            .yapita-participants__card {
                padding: 25px 20px;
            }

            .yapita-participants__avatar-container {
                width: 90px;
                height: 90px;
            }

            .yapita-participants__card-name {
                font-size: 17px;
            }

        }

        /* ==========================================================
           17. ACCESSIBILITY
           ========================================================== */

        @media (prefers-reduced-motion: reduce) {

            .yapita-participants *,
            .yapita-participants *::before,
            .yapita-participants *::after {
                transition: none !important;
                animation: none !important;
            }

        }
    </style>
@endsection

@section('content')

    @php
        // ==========================================
        // NORMALIZAR PARTICIPANTES
        // ==========================================

        $participants = collect($users ?? [])
            ->map(function ($user) {
                return (array) $user;
            })
            ->values();

        $totalParticipants = $participants->count();
    @endphp


    <div id="app-management" class="yapita-participants">

        {{-- ==========================================
             1. HERO - HALLOWEEN OTAVALO
             ========================================== --}}

        <header class="yapita-participants__hero">

            <div class="yapita-participants__hero-content">

                <div class="yapita-participants__edition">
                    <i class="bi bi-stars"></i>
                    7.ª EDICIÓN · HALLOWEEN OTAVALO
                </div>

                <h1 class="yapita-participants__title">
                    🎃 Dulce o Truco
                    <br>
                    <span class="yapita-participants__title-highlight">
                        Halloween Otavalo
                    </span>
                </h1>

                <p class="yapita-participants__subtitle">
                    ¡La magia de Halloween la hacemos juntos!
                    Conoce a las personas que se registraron para participar
                    en la séptima edición de Dulce o Truco Otavalo.
                </p>

            </div>

        </header>


        {{-- ==========================================
             2. MAIN CONTAINER
             ========================================== --}}

        <main class="yapita-participants__container">

            {{-- ======================================
                 3. SUMMARY
                 ====================================== --}}

            <section
                class="yapita-participants__summary"
                aria-label="Resumen de participantes"
            >

                <div class="yapita-participants__summary-info">

                    <div class="yapita-participants__summary-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <div>

                        <h2 class="yapita-participants__summary-title">
                            Nuestra comunidad Halloween
                        </h2>

                        <p class="yapita-participants__summary-description">
                            Personas registradas para participar en la
                            7.ª Edición Dulce o Truco Otavalo.
                        </p>

                    </div>

                </div>


                {{-- ESTADÍSTICAS --}}

                <div class="yapita-participants__stats">

                    <div class="yapita-participants__stat">

                        <div class="yapita-participants__stat-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>

                        <div>

                            <span class="yapita-participants__stat-number">
                                {{ $totalParticipants }}
                            </span>

                            <span class="yapita-participants__stat-label">
                                Participantes registrados
                            </span>

                        </div>

                    </div>


                    <div class="yapita-participants__stat-divider"></div>


                    <div class="yapita-participants__stat">

                        <div class="yapita-participants__stat-icon">
                            <i class="bi bi-calendar-event-fill"></i>
                        </div>

                        <div>

                            <span class="yapita-participants__stat-label">
                                Registros desde el
                            </span>

                            <span class="yapita-participants__stat-date">
                                28 de octubre de 2026
                            </span>

                        </div>

                    </div>

                </div>

            </section>


            {{-- ======================================
                 4. SEARCH
                 ====================================== --}}

            <section
                class="yapita-participants__search"
                role="search"
                aria-label="Buscar participantes"
            >

                <div class="yapita-participants__search-field">

                    <label
                        for="yapita-participants-search"
                        class="visually-hidden"
                    >
                        Buscar participante
                    </label>

                    <i
                        class="bi bi-search yapita-participants__search-icon"
                        aria-hidden="true"
                    ></i>

                    <input
                        type="search"
                        id="yapita-participants-search"
                        class="yapita-participants__search-input"
                        placeholder="Buscar por nombre, código o correo electrónico..."
                        autocomplete="off"
                    >

                </div>


                <button
                    type="button"
                    class="yapita-participants__search-button"
                >

                    <i class="bi bi-search"></i>

                    <span>Buscar</span>

                </button>


                <button
                    type="button"
                    class="yapita-participants__search-reset"
                >

                    <i class="bi bi-arrow-clockwise"></i>

                    <span>Limpiar</span>

                </button>

            </section>


            {{-- ======================================
                 5. PARTICIPANTS
                 ====================================== --}}

            <section
                class="yapita-participants__list"
                aria-labelledby="yapita-participants-list-title"
            >

                {{-- RESULTS HEADER --}}

                <div class="yapita-participants__results">

                    <h2
                        id="yapita-participants-list-title"
                        class="yapita-participants__results-title"
                    >
                        <i class="bi bi-person-check-fill"></i>
                        Participantes registrados
                    </h2>

                    <span
                        class="yapita-participants__results-count"
                        aria-live="polite"
                    >
                        {{ $totalParticipants }}
                        participantes
                    </span>

                </div>


                {{-- ==================================
                     PARTICIPANTS GRID
                     ================================== --}}

                <div class="yapita-participants__grid">

                    @forelse($participants as $index => $user)

                        @php
                            // ==================================
                            // USER INFORMATION
                            // ==================================

                            $code = (int) ($user['code'] ?? 0);

                            $name = trim($user['name'] ?? '');

                            $email = trim($user['email'] ?? '');

                            $avatar = trim($user['avatar'] ?? '');

                            // ==================================
                            // INITIAL
                            // ==================================

                            $initial = mb_strtoupper(
                                mb_substr(
                                    $name !== '' ? $name : '?',
                                    0,
                                    1
                                )
                            );

                            // ==================================
                            // VALIDATE AVATAR
                            // ==================================

                            $hasAvatar = filter_var(
                                $avatar,
                                FILTER_VALIDATE_URL
                            ) !== false;

                            // Evitar URL de carpeta uploads.
                            $avatarPath = parse_url(
                                $avatar,
                                PHP_URL_PATH
                            ) ?? '';

                            if (
                                $hasAvatar &&
                                preg_match('~/uploads/?$~i', $avatarPath)
                            ) {
                                $hasAvatar = false;
                            }

                            // ==================================
                            // DISPLAY NUMBER
                            // ==================================

                            $displayNumber = str_pad(
                                $index + 1,
                                3,
                                '0',
                                STR_PAD_LEFT
                            );
                        @endphp


                        <article
                            class="yapita-participants__card"
                            data-name="{{ $name }}"
                            data-code="{{ $code }}"
                            data-email="{{ $email }}"
                        >

                            {{-- ==============================
                                 CARD NUMBER
                                 ============================== --}}

                            <span class="yapita-participants__card-number">
                                #{{ $displayNumber }}
                            </span>


                            {{-- ==============================
                                 AVATAR
                                 ============================== --}}

                            <div class="yapita-participants__avatar-container">

                                @if($hasAvatar)

                                    <img
                                        class="yapita-participants__avatar"
                                        src="{{ $avatar }}"
                                        alt="Fotografía de {{ $name }}"
                                        loading="lazy"
                                        referrerpolicy="no-referrer"
                                    >

                                    <div
                                        class="yapita-participants__avatar-fallback yapita-participants__avatar-fallback--hidden"
                                    >
                                        {{ $initial }}
                                    </div>

                                @else

                                    <div class="yapita-participants__avatar-fallback">
                                        {{ $initial }}
                                    </div>

                                @endif


                                <span
                                    class="yapita-participants__avatar-decoration"
                                    aria-hidden="true"
                                >
                                    🎃
                                </span>

                            </div>


                            {{-- ==============================
                                 PARTICIPANT NAME
                                 ============================== --}}

                            <h3 class="yapita-participants__card-name">
                                {{ $name !== '' ? $name : 'Participante' }}
                            </h3>


                            {{-- ==============================
                                 PARTICIPANT DETAILS
                                 ============================== --}}

                            <div class="yapita-participants__card-details">

                                {{-- CODE --}}

                                <div class="yapita-participants__detail">

                                    <span class="yapita-participants__detail-icon">
                                        <i class="bi bi-ticket-perforated-fill"></i>
                                    </span>

                                    <span class="yapita-participants__detail-label">
                                        Código:
                                    </span>

                                    <span
                                        class="yapita-participants__code"
                                        title="Código del participante"
                                    >
                                        {{ $code }}
                                    </span>

                                </div>


                                {{-- EMAIL --}}

                                <div class="yapita-participants__detail">

                                    <span class="yapita-participants__detail-icon">
                                        <i class="bi bi-envelope-fill"></i>
                                    </span>

                                    <span
                                        class="yapita-participants__email"
                                        title="{{ $email }}"
                                    >
                                        {{ $email !== '' ? $email : 'Sin correo registrado' }}
                                    </span>

                                </div>

                            </div>


                            {{-- ==============================
                                 STATUS
                                 ============================== --}}

                            <span class="yapita-participants__badge">

                                <i
                                    class="bi bi-check-circle-fill yapita-participants__badge-icon"
                                ></i>

                                Registrado en Halloween

                            </span>

                        </article>

                    @empty

                        {{-- ==============================
                             NO PARTICIPANTS
                             ============================== --}}

                        <div
                            class="yapita-participants__empty yapita-participants__empty--visible"
                            style="grid-column: 1 / -1;"
                        >

                            <i
                                class="bi bi-people yapita-participants__empty-icon"
                            ></i>

                            <h3 class="yapita-participants__empty-title">
                                Todavía no existen participantes
                            </h3>

                            <p class="yapita-participants__empty-description">
                                Los participantes registrados aparecerán aquí.
                            </p>

                        </div>

                    @endforelse

                </div>


                {{-- ==================================
                     SEARCH EMPTY STATE
                     ================================== --}}

                @if($totalParticipants > 0)

                    <div class="yapita-participants__empty">

                        <i
                            class="bi bi-search-heart yapita-participants__empty-icon"
                        ></i>

                        <h3 class="yapita-participants__empty-title">
                            No encontramos participantes
                        </h3>

                        <p class="yapita-participants__empty-description">
                            Intenta buscar utilizando otro nombre,
                            código o correo electrónico.
                        </p>

                    </div>

                @endif

            </section>

        </main>


        {{-- ==========================================
             6. FOOTER
             ========================================== --}}

        <footer class="yapita-participants__footer">

            <div class="yapita-participants__container">

                <h2 class="yapita-participants__footer-title">
                    🎃 7.ª Edición Dulce o Truco Otavalo
                </h2>

                <p class="yapita-participants__footer-description">
                    Celebramos la unión de nuestra comunidad,
                    la alegría de compartir y el espíritu
                    de descubrir nuestros negocios locales.
                </p>

                <p class="yapita-participants__footer-description">
                    Impulsado por
                    <strong class="yapita-participants__footer-brand">
                        Yapita
                    </strong>
                    💛💙
                </p>

            </div>

        </footer>

    </div>

@endsection
