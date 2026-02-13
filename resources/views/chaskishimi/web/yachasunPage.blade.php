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

]

];



$url_path_plugins = "libs/";
@endphp
@extends('layouts.chaskishimi')
@section('additional-styles')
    @include('chaskishimi.web.yacha-sun.assets.css.course-test-management')
    @include('chaskishimi.web.yacha-sun.assets.css.menu-top-sections')
    @include('chaskishimi.web.yacha-sun.assets.css.menu-top-gamification')

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
    @include('partials.bootstrap-05',["allowCss"=>true])

@endsection
@section('additional-scripts')
    @include('partials.bootstrap-05',["allowJs"=>true])
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    @include('chaskishimi.web.yacha-sun.assets.js.process.course-management')
    @include('chaskishimi.web.yacha-sun.assets.js.process.menu-top-sections')

    <script src="{{ asset($resourcePathServer.$url_path_plugins."snap-svg/0-5-1/snap.svg-min.js") }}"
            type="text/javascript"></script>

    @include('chaskishimi.web.yacha-sun.assets.js.process.course-test-init')
    @include('chaskishimi.web.yacha-sun.assets.js.process.init-modal')

    <script>
        var $dataManagerPage = <?php echo json_encode($dataManagerPage) ?>;
        var $resources = <?php echo json_encode($resources) ?>;
        var appThis = null;
        var appInit = new Vue(
            {

                mounted: function () {
                    this.initCurrentComponent();
                    appThis = this;
                    //this.initSVGManager();
                    $(function () {
                        $(render);
                    });
                },
                el: '#app-management',
                created: function () {

                },
                beforeMount: function () {
                    this.configParams = this.params;
                    var $scope = this;
                    $(window).resize(function () {
                        //     $scope.resizeSVG();
                    });

                },
                data: {
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
                    ]

                },
                methods: {
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
                                console.warn("Action no definida:", item);
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
                    }

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
    </script>
@endsection
@section('content')
    <div id="app-management">
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
    <div class="toast-container position-fixed p-3 mc-toast__container" >
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
                        aria-label="Close"></button>
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
