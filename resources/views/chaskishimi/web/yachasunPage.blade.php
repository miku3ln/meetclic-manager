{{-- NONE CMS-TEMPLATE --}}
@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$assetsRoot = $resourcePathServer . 'assets/chaskishimi/';
$assetsYapitasRoot = $resourcePathServer . 'yapitas/';

$resources=[
    'header'=>URL::asset($assetsRoot.'yachasun/header.svg'),
   'wayra'=>URL::asset($assetsRoot.'sections/wayra-ready.png'),
   'nina'=>URL::asset($assetsRoot.'sections/nina-ready.png'),
   'yaku'=>URL::asset($assetsRoot.'sections/yaku-ready.png'),
   'allpa'=>URL::asset($assetsRoot.'sections/allpa-ready.png'),

   "gamification"=>[
       "yapitas"=>URL::asset($assetsYapitasRoot.'assets/gamification/yapitas-premium.png'),
       "trophy"=>URL::asset($assetsYapitasRoot.'assets/gamification/trophy.png'),
       "reputation"=>URL::asset($assetsYapitasRoot.'assets/gamification/reputation.png'),
       "configuration"=>URL::asset($assetsYapitasRoot.'assets/gamification/configuration.png'),
],
"top-waka"=>[
       "nina"=>URL::asset($assetsRoot.'sections/subsection/nina/waka.png'),

],
"icons"=>[
       "vocabulary"=>URL::asset($assetsYapitasRoot.'assets/gamification/yapitas-premium.png'),
       "idioms"=>URL::asset($assetsYapitasRoot.'assets/gamification/trophy.png'),
       "wordOfDay"=>URL::asset($assetsYapitasRoot.'assets/gamification/reputation.png'),
       "favorites"=>URL::asset($assetsYapitasRoot.'assets/gamification/configuration.png'),
       "history"=>URL::asset($assetsYapitasRoot.'assets/gamification/reputation.png'),
       "random"=>URL::asset($assetsYapitasRoot.'assets/gamification/reputation.png'),
       "chaski-idioma"=>URL::asset($assetsRoot.'themes-tools/chaski-idioma.png'),
       "chaski-cosmovision"=>URL::asset($assetsRoot.'themes-tools/chaski-cosmovision.png'),
       "chaski-apuntes"=>URL::asset($assetsRoot.'themes-tools/chaski-apuntes.png'),
       "chaski-diccionario"=>URL::asset($assetsRoot.'themes-tools/chaski-diccionario.png'),
       "chaski-trabalenguas"=>URL::asset($assetsRoot.'themes-tools/chaski-trabalenguas.png'),
       "chaski-canciones"=>URL::asset($assetsRoot.'themes-tools/chaski-canciones.png'),



]

];



$url_path_plugins = "libs/";
@endphp
@extends('layouts.chaskishimi')
@section('additional-styles')
    @include('chaskishimi.web.yacha-sun.assets.css.course-test-management')
    @include('chaskishimi.web.yacha-sun.assets.css.menu-top-sections')
    @include('chaskishimi.web.yacha-sun.assets.css.menu-top-gamification')
    @include('utils.conjugation-ki.assets.css.conjugation-kichwa')

    <style>

        :root {
            --mc-nav-h: 64px; /* ajusta al alto real de tu navbar */
        }

        a.to-top--contact-whatsapp.chat-widget-button-content {
            display: none;
        }

        a.to-top.to-top--bee {
            display: none !important;
        }
    </style>
    @include('chaskishimi.web.yacha-sun.assets.css.course-management')


    <style id="not-allow-styles">
        a {

            text-decoration: none !important;
        }

        @media screen and (min-width: 300px) and (max-width: 768px) {
            .nav-button-wrap {

            }

            .main-menu {
                top: 95px !important;

            }
        }
    </style>
    <style id="canva">

        /* 1) Fullscreen real + encima de todo */
        #mcPanel.mc-offcanvas-full {
            position: fixed !important;
            inset: 0 !important; /* top:0 right:0 bottom:0 left:0 */
            width: 100vw !important;
            height: 100vh !important;
            max-height: 100vh !important;
            transform: none !important; /* por si algún parent mete transform */
            z-index: 15000 !important;
        }

        /* 2) Layout interno: header fijo + canvas scrolleable */
        #mcPanel.mc-offcanvas-full {
            display: flex !important;
            flex-direction: column !important;
        }

        /* header no crece */
        #mcPanel .mc-offcanvas-header {
            flex: 0 0 auto;
        }

        /* ✅ SOLO AQUÍ SCROLL */
        #mcPanel .mc-offcanvas-canvas {
            flex: 1 1 auto;
            overflow-y: auto;
            overflow-x: hidden;
            min-height: 0; /* CLAVE en flex para que overflow funcione */
        }

        /* 3) Backdrop (si lo usas) debajo del panel pero encima del sitio */
        .offcanvas-backdrop {
            z-index: 1990 !important;
        }

    </style>
    <link href="{{ asset($resourcePathServer."plugins/bootgrid-2024/jquery.bootgrid.min.css") }}" rel="stylesheet"
          type="text/css">
    @include('partials.bootstrap-05',["allowCss"=>true])

@endsection
@section('additional-scripts')
    @include('partials.bootstrap-05',["allowJs"=>true])
    <script>
        var $dataManagerPage = <?php echo json_encode($dataManagerPage) ?>;
        var $resources = <?php echo json_encode($resources) ?>;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    @include('chaskishimi.web.yacha-sun.assets.js.process.course-management')
    @include('chaskishimi.web.yacha-sun.assets.js.process.menu-top-sections')
    @include('utils.conjugation-ki.assets.js.conjugation-kichwa')

    <script src="{{ asset($resourcePathServer."plugins/bootgrid-2024/jquery.bootgrid.min.js") }}"
            type="text/javascript"></script>

    <script src="{{ asset($resourcePathServer.$url_path_plugins."snap-svg/0-5-1/snap.svg-min.js") }}"
            type="text/javascript"></script>

    @include('chaskishimi.web.yacha-sun.assets.js.process.course-test-init')
    @include('chaskishimi.web.yacha-sun.assets.js.process.init-modal')
    @include('chaskishimi.web.yacha-sun.assets.js.process.course-management-tools')

    <script>

        var appThis = null;
        var appInit = new Vue(
            {
                el: '#app-management',
                directives: {
                    'init-bootgrid': {
                        mounted: function () {
                            console.log("init-bootgrid")
                        },
                        inserted: function (el, binding, vnode, vm, arg) {
                            var $this = vnode.context;
                            var paramsInput = binding.value;
                            console.log("init-bootgrid inserted")
                            $this.initCurrentGridApuntesComponent({
                                elementInit: el,
                                params: paramsInput
                            });
                        }
                    },
                    'init-plugin-study': {
                        mounted: function () {
                            console.log("init-plugin-study")
                        },
                        inserted: function (el, binding, vnode, vm, arg) {
                            var $this = vnode.context;
                            var paramsInput = binding.value;
                            console.log("init-plugin-study inserted", paramsInput)

                        }
                    },

                },
                created: function () {
                    this.$set(this.hub, "filteredCards", []);
                },
                computed: {
                    // filtra por tab + búsqueda
                    hubFilteredCards: function () {

                        const q = (this.hub.search || "").trim().toLowerCase();
                        if (!q) return this.hub.cards;

                        return this.hub.cards.filter(c =>
                            (c.title + " " + c.subtitle).toLowerCase().includes(q)
                        );

                    }
                },
                mounted: function () {
                    this.initCurrentComponent();
                    appThis = this;
                    //this.initSVGManager();
                    $(function () {
                        $(render);
                        appThis.canvasManager.init = initCanvas();
                        appThis.initEventsCanvas(appThis.canvasManager.init);
                    });
                    this.refreshHubGrid();
                },
                beforeMount: function () {
                    this.configParams = this.params;
                    var $scope = this;
                    $(window).resize(function () {
                        //     $scope.resizeSVG();
                    });

                },
                data: {
                    canvasManager: {
                        init: null,
                        data: {
                            title: "Hola"
                        }
                    },
                    managerHeader: {
                        data: null,
                        'selector': '#svg-full-width',
                        'manager-selector-container': '#section--full-img',
                        'source': $resources.header,

                    },
                    // ✅ items del iconbar
                    iconItems: [
                        {
                            id: "ic-yapitas",
                            image: ($resources["gamification"]["yapitas"]),
                            number: 0,
                            action: "yapitas",
                            payload: {tab: "yapitas"}
                        },
                        {
                            id: "ic-trophy",
                            image: $resources["gamification"]["trophy"],
                            number: 0,
                            action: "trophy"
                        },
                        {
                            id: "ic-reputation",
                            image: ($resources["gamification"]["reputation"]),
                            number: 0,
                            action: "reputation"
                        },
                        {
                            id: "ic-configuration",
                            image: ($resources["gamification"]["configuration"]),
                            action: "configuration"
                        }
                    ],
                    ...$courseManagementData,
                    ...$configApuntesData,

                },
                methods: {


                    initEventsCanvas: function (params) {
                        const el = params.el;

                        el.addEventListener("show.bs.offcanvas", function () {


                            }
                        );
                        el.addEventListener("shown.bs.offcanvas", function () {

                                lockOuterScroll();

                                // ✅ asegúrate que el canvas siga con scroll
                                $(this).find(".mc-offcanvas-canvas").css({
                                    overflowY: "auto",
                                    overflowX: "hidden"
                                });
                            }
                        );
                        el.addEventListener("hide.bs.offcanvas", () => console.log("va a cerrar"));
                        el.addEventListener("hidden.bs.offcanvas", function () {

                                unlockOuterScroll();
                            }
                        );
                        el.addEventListener("hidePrevented.bs.offcanvas", () => console.log("cierre prevenido"));
                    },
                    initCurrentComponent: function () {

                    }, initManagement: function () {
                        console.log("init app");
                    },

                    initSVGManager: function () {

                        var elementCurrent = this.managerHeader.selector;
                        var selectorMain = Snap(elementCurrent);
                        var _this = this;
                        Snap.load(_this.managerHeader.source, function (f) {
                            selectorMain.append(f);
                        });
                    },
                    resizeSVG: function (params) {
                        adjustment();
                    },


                    // ---------- ICON BAR ----------
                    hasNumber: function (item) {
                        return item.number !== undefined && item.number !== null && item.number !== "";
                    },

                    handleIconClick: function (item) {
                        // Si el item trae callback propio (opcional), lo ejecuta:
                        // (pero recomendado: usar action)
                        if (typeof item.onClick === "function") {
                            try {
                                item.onClick(item, this);
                            } catch (e) {
                                console.error(e);
                            }
                            return;
                        }

                        // Router simple por action
                        switch (item.action) {
                            case "yapitas":
                                this.goHome(item.payload);
                                break;
                            case "trophy":
                                this.share(item.payload);
                                break;

                            case "reputation":
                                this.reload(item.payload);
                                break;
                            case "configuration":
                                this.canvasManager.init.canvasOptions.show()
                                break;
                            default:
                                console.warn("Action no definida:", item.action, item);
                        }
                    },

                    // ---------- ACCIONES ----------
                    goHome: function (payload) {
                        console.log("goHome", payload);
                    },

                    share: function (payload) {
                        console.log("share", payload);
                    },

                    reload: function () {
                        console.log("reload");
                        // ejemplo: recargar header svg
                        // this.initSVGManager();
                    },
                    // ✅ update dinámico del número (reactivo)
                    setIconNumber: function (id, numberOrNull) {
                        var idx = this.iconItems.findIndex(x => x.id === id);
                        if (idx === -1) return;

                        // Vue2: asegura reactividad si cambias props
                        var updated = Object.assign({}, this.iconItems[idx], {number: numberOrNull});
                        this.$set(this.iconItems, idx, updated);
                    },
                    ...$courseManagementToolsMethods,
                    ...$configApuntesMethods

                }
            });
        appInit.initManagement();
    </script>

    <script>
        $(function () {
            var widthManager = $('#app-management').width() - 80;
            var contenedorAncho = document.getElementById("app-management").offsetWidth; // Obtener el ancho del contenedor
            var nuevoAncho = contenedorAncho * 0.96; // Reducir el ancho al 96% del ancho del contenedor
            var nuevoAlto = (nuevoAncho / 1840) * 750; // Calcular el nuevo alto manteniendo la proporción original
            $('#svg-full-width').attr('width', widthManager);
            $('#svg-full-width').attr('height', nuevoAlto);

            $('.header-search').show();

            modalEl.querySelector('.modal-dialog')
                .classList.add('modal-fullscreen')
        });

        function mcToastShow(opts = {}) {


            const type = (opts.type ?? "success").toLowerCase(); // success | warning | danger
            const icon = opts.icon ?? (type === "success" ? "🏆" : type === "warning" ? "⚠️" : "⛔");
            const title = opts.title ?? (type === "success" ? "¡Lo lograste!" : type === "warning" ? "Ojo" : "Ups");
            const msg = opts.msg ?? "Mensaje...";

            $("#mcToastIcon").text(icon);
            $("#mcToastTitle").text(title);
            $("#mcToastMsg").text(msg);
            const $toast = $("#mcToast");


            const $parent = $toast.parent();
            var prevZ = "1500";
            $parent.css("z-index", prevZ);
            // limpiar modificadores previos
            $toast.removeClass("mc-toast--success mc-toast--warning mc-toast--danger");
            // aplicar el actual
            if (type === "warning") $toast.addClass("mc-toast--warning");
            else if (type === "danger") $toast.addClass("mc-toast--danger");
            else $toast.addClass("mc-toast--success");
            const toastEl = $toast.get(0);
            const toast = bootstrap.Toast.getOrCreateInstance(toastEl, {
                delay: opts.delay ?? 3000,
                autohide: opts.autohide ?? true
            });


            toastEl.addEventListener("hidden.bs.toast", () => {
                console.log("Toast ya se ocultó (hidden)");
                $parent.css("z-index", "15");
            });

// cuando EMPIEZA a ocultarse
            toastEl.addEventListener("hide.bs.toast", () => {
                console.log("Toast empezando a ocultarse (hide)");
            });
            toast.show();
        }

        function generateMorphemeGlossary(paramns) {
            return new MorphemeGlossaryPlugin({}).initPayload(paramns.data);
        }

        function generateData(params) {
            var mg = generateMorphemeGlossary(params);
            const data = mg.generateData(params.word);
            const html = mg.generateHtml(data);
            return {
                data: data,
                html: html,

            };
        }

    </script>
    <script>
        function lockOuterScroll() {
            const $html = $("html");
            const $body = $("body");

            $html.data("mc_prev_overflow", $html.css("overflow"));
            $body.data("mc_prev_overflow", $body.css("overflow"));

            $html.css("overflow", "hidden");  // ✅ oculta scrollbar externo
            $body.css("overflow", "hidden");  // (por si acaso)
        }

        function unlockOuterScroll() {
            const $html = $("html");
            const $body = $("body");

            $html.css("overflow", $html.data("mc_prev_overflow") ?? "");
            $body.css("overflow", $body.data("mc_prev_overflow") ?? "");
        }

        function initCanvas() {
            const el = document.getElementById('mcPanel');
            const canvasOptions = new bootstrap.Offcanvas(el, {
                backdrop: true,
                keyboard: false,
                scroll: false
            });
            return {el: el, canvasOptions: canvasOptions};
        }
    </script>
@endsection
@section('content')
    <div id="app-management">


        <div class="offcanvas offcanvas-start mc-offcanvas-full  w-100"
             tabindex="-1"
             id="mcPanel">

            <div class="offcanvas-header mc-offcanvas-header">
                <div class="mc-hub__search input-group mb-2">
                    <h1 class="mc-offcanvas-header__title">
                        <?php echo "   {{canvasManager.data.title}} " ?>
                    </h1>
                    <div class="not-view">
                         <span class="input-group-text bg-white border-end-0 mc-pill-left">
      <i class="bi bi-search"></i>
    </span>

                        <input
                            type="text"
                            class="form-control border-start-0 border-end-0 mc-pill-mid "
                            placeholder="Search..."
                            v-model="hub.search"
                            @input="hub.onSearchInput"
                        />

                        <button class="btn btn-outline-secondary bg-white border-start-0 mc-pill-right"
                                type="button"
                                @click="openFilters()">
                            <i class="bi bi-sliders"></i>
                        </button>
                    </div>

                </div>
                <button type="button" class="btn-close btn-close--canvas" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body mc-offcanvas-canvas">
                <div id="content-body-canvas">
                    <div class="mc-hub p-3" id="content-all-process">
                        <ul class="nav nav-underline mc-hub__tabs mb-3 not-view">
                            <li class="nav-item" v-for="t in hub.tabs" :key="t.id">
                                <button
                                    class="nav-link"
                                    :class="{active: hub.activeTab === t.id}"
                                    type="button"
                                    @click="setHubTab(t.id)"
                                >
                                    <i :class="t.icon" class="me-1"></i>
                                    <?php echo "{{ t.label }}" ?>
                                </button>
                            </li>
                        </ul>
                        <div class="row g-3" v-if="hub.active_process.key==null">
                            <div class="col-6 col-6" v-for="card in hub.filteredCards" :key="card.id">
                                <button type="button" class="mc-card card w-100 text-start" @click="openCard(card)">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-end not-view">
                                            <!-- bookmark corner -->
                                            <span class="mc-bookmark" :class="{'mc-bookmark--on': card.bookmarked}">
              <i class="bi" :class="card.bookmarked ? 'bi-bookmark-fill' : 'bi-bookmark'"></i>
            </span>
                                        </div>

                                        <div class="mc-card__icon mb-2">
                                            <img :src="card.icon" alt=""/>
                                        </div>

                                        <div class="mc-card__title"><?php echo "{{ card.title }}" ?></div>
                                        <div class="mc-card__sub text-muted"><?php echo "{{ card.subtitle }}" ?></div>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="row g-3" v-if="hub.active_process.key">
                            <button class="btn btn-primary" @click="returnMainProcess()" id="btn-return-process">
                                <i class="bi bi-arrow-left"></i>
                            </button>
                            <div v-if="hub.active_process.key=='chaski-apuntes'">

                                @include('utils.sections.apuntes.template-main')

                            </div>

                        </div>

                    </div>

                    <div id="other-data">
                        <h1 style="color:rgb(24 179 26 / 0%)">HOLA SOY </h1>
                    </div>
                </div>

            </div>

        </div>


        <div class="mc-icbar">
            <button
                v-for="item in iconItems"
                :key="item.id"
                type="button"
                class="mc-icbar__item"
                @click="handleIconClick(item)"
                :title="item.id"
            >
                <img class="mc-icbar__img" :src="item.image" :alt="item.id"/>

                <!-- number opcional -->
                <span v-if="hasNumber(item)" class="mc-icbar__badge">
       <?php echo "{{ item.number }}" ?>
      </span>
            </button>
        </div>
        <div class="mc-fixedCard not-view" id="mcFixedCard" role="region" aria-label="Section header">
            <div class="mc-fixedCard__inner">
                <button class="mc-fixedCard__col mc-fixedCard__col--left" id="mcFixedCardLeft" type="button">
                    <div class="mc-fixedCard__meta" id="mcFixedCardMeta"></div>
                    <div class="mc-fixedCard__title" id="mcFixedCardTitle"></div>
                </button>

                <button class="mc-fixedCard__col mc-fixedCard__col--right" id="mcFixedCardRight" type="button"
                        aria-label="Open actions">
      <span class="mc-fixedCard__iconBox" id="mcFixedCardIconBox">
        <img class="mc-fixedCard__icon" id="mcFixedCardIcon" alt="icon"/>
      </span>
                </button>
            </div>
        </div>

        <div class="mc-elements" id="app"></div>

    </div>
@endsection
@section('data-modal')
    <!-- Toasts -->
    <div class="toast-container position-fixed p-3 mc-toast__container">
        <div id="mcToast" class="toast mc-toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex mc-toast__row">
                <div class="toast-body mc-toast__body">
                    <span class="mc-toast__icon" id="mcToastIcon">✅</span>

                    <div class="mc-toast__content">
                        <div class="mc-toast__title" id="mcToastTitle">¡Lo lograste!</div>
                        <div class="mc-toast__message" id="mcToastMsg">Felicidades, sigue al siguiente ejercicio.</div>
                    </div>
                </div>

                <button type="button" class="btn-close me-2 m-auto mc-toast__close" data-bs-dismiss="toast"
                        aria-label="Close">


                </button>
            </div>
        </div>
    </div>
    <div
        class="modal fade"
        id="dynamicModal"
        tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>
@endsection
