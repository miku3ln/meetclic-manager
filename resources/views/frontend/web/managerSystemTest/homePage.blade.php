{{--  CMS-TEMPLATE --}}
@extends('layouts.cityBook')
@section('additional-styles')
    <style>

        h1.title {
            float: left;
            width: 100%;
            text-align: center;
            color: #4db7fe;
            font-size: 34px;
            font-weight: 700;
        }

        .map-container {
            height: 500px;
            width: 100%;
        }

        @keyframes marker-bounce {
            0% { transform: scale(1); }         /* Tamaño inicial */
            30% { transform: scale(1.1); }      /* El marcador se agranda */
            50% { transform: scale(1); }        /* El marcador vuelve a su tamaño original */
            70% { transform: scale(1.1); }      /* El marcador se agranda otra vez */
            100% { transform: scale(1); }       /* El marcador vuelve a su tamaño original */
        }

        /* Modificador de ícono del marcador con el rebote */
        .leaflet-marker-icon--bouncing {

        }
    </style>
@endsection
@section('additional-scripts')
    <script type="text/x-template" id="map-manager-template">
        <div class="not-view">
            <section class="gradient-bg gradient-bg--home-contact-us">
                <button @click="initBounceMarker()">MARKER EFECTO</button>
                <div ref="map" class="map-container" id="map-container"></div>
            </section>
        </div>


    </script>
    <script>
        function simulateBounce(marker) {
            const originalLatLng = marker.getLatLng();  // Obtener las coordenadas originales del marcador

            // Número de saltos
            const bounceCount = 5;
            let bounceCounter = 0;

            // Función para mover el marcador hacia arriba y hacia abajo
            function bounceStep() {
                if (bounceCounter < bounceCount) {
                    // Mover el marcador hacia arriba
                    marker.setLatLng([originalLatLng.lat + 0.0005, originalLatLng.lng]);

                    // Esperar un poco antes de moverlo hacia abajo
                    setTimeout(function () {
                        // Moverlo hacia abajo
                        marker.setLatLng([originalLatLng.lat, originalLatLng.lng]);

                        // Incrementar el contador de saltos
                        bounceCounter++;

                        // Llamar a la siguiente etapa de rebote
                        bounceStep();
                    }, 200); // Tiempo de espera entre saltos (200ms)
                }
            }

            // Iniciar el proceso de rebote
            bounceStep();
        }
        Vue.component('map-manager-component', {
            template: '#map-manager-template',
            directives: {
                'init-grid-filters': {
                    inserted: function (el, binding, vnode, vm, arg) {
                        var paramsInput = binding.value;
                        paramsInput.initMethod({
                            objSelector: el
                        });


                    },
                },
                resetModel: {
                    inserted: function (el, binding, vnode, vm, arg) {
                        var paramsInput = binding.value;
                        paramsInput._resetModel(paramsInput.model);


                    },
                },

            },
            props: {
                params: {
                    type: Object,
                }
            },
            created: function () {


            },
            beforeMount: function () {

            },
            mounted: function () {
                this.initLeafletMap();
            },
            data: function () {
                var dataManager = {
//**Modal*
                    /*  ----MANAGER ENTITY---*/
                    configModelEntity: {
                        "buttonsManagements": []
                    },

                    businessCreate: false,
                    configDataBusiness: {data: 2},
                    dataMapConfiguration: {
                        data: [],
                        dataMarkers: [],
                    }

                };
                return dataManager;
            },
            methods: {
                ...$methodsFormValid,

                initLeafletMap: function (params) {
                    $scope = this;
                    const mapElement = $('#map-container');  // Seleccionar el contenedor con jQuery
                    $scope = this;
                    // Crear el mapa de Leaflet
                    const map = L.map(mapElement[0]).setView([51.505, -0.09], 13); // Establece la vista inicial

                    // Añadir la capa de OpenStreetMap
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    }).addTo(map);

                    // Crear un ícono personalizado para el marcador
                    const customIcon = L.icon({
                        iconUrl: 'http://localhost:6969/meetclickmanager/public/templates/cityBookHtml/images/marker.png', // URL de la imagen del ícono
                        iconSize: [32, 32],  // Tamaño del ícono
                        iconAnchor: [16, 32], // Punto de anclaje del ícono (donde se coloca en el mapa)
                        popupAnchor: [0, -32], // Ajusta la posición del popup respecto al ícono
                    });

                    // Crear el marcador con el ícono personalizado
                    const marker = L.marker([51.5, -0.09], {icon: customIcon,bouncing: true}).addTo(map)
                        .bindPopup(`
      <div class="map-popup-wrap">
        <div class="map-popup">
          <div class="infoBox-close">
            <i class="fa fa-times"></i>
          </div>
          <div class="map-popup-category">Oficios / Servicios</div>
          <a href="http://localhost:6969/meetclickmanager/es/businessDetails/Meetclic" class="listing-img-content fl-wrap">
            <img src="https://meetclic.com/public/uploads/business/information/1745413604_bomberos.jpg" alt="">
          </a>
          <div class="listing-content fl-wrap">
            <div class="card-popup-raining map-card-rainting" data-starrating="2">
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <span class="map-popup-reviews-count">( 1 reviews )</span>
            </div>
            <div class="listing-title fl-wrap">
              <h4>
                <a href="http://localhost:6969/meetclickmanager/es/businessDetails/Meetclic">Meetclic</a>
              </h4>
              <span class="map-popup-location-info">
                <i class="fa fa-map-marker"></i>Piedrahita y Buenos Aires, Buenos AIRE
              </span>
              <span class="map-popup-location-phone">
                <i class="fa fa-phone"></i>0985339457
              </span>
            </div>
          </div>
        </div>
      </div>
    `)
                        .openPopup();


                    this.dataMapConfiguration.dataMarkers.push(marker);
                    marker.on('mouseover', function (e) {

                        console.log(e);
                    });

                    // Capturar el evento de salir el mouse del marcador
                    marker.on('mouseout', function (e) {

                    });
                    map.scrollWheelZoom.disable(); // Desactiva el zoom con la rueda del ratón
                    map.dragging.disable(); // Desactiva el desplazamiento del mapa con el ratón
                    // Capturar clics en el mapa para agregar nuevos marcadores
                    let $sope = this;

                    map.on('click', function (event) {
                        //$sope.generateViewDataPosition({event:event,customIcon:customIcon,map:map});

                    });
                },
                initBounceMarker: function () {
                    // Quitar la clase 'bouncing' para detener el rebote
                    // e.target._icon.classList.remove('bouncing'); // Eliminar el rebote cuando el mouse sale
                    // Agregar la clase 'bouncing' al ícono del marcador
                    // e.target._icon.classList.add('bouncing'); // Aplicar el rebote al pasar el mouse
                    console.log(this.dataMapConfiguration.dataMarkers)
                    let marker = this.dataMapConfiguration.dataMarkers[0];

                    const icon = marker._icon; // Obtener el ícono del marcador
                    if (icon.classList.contains('leaflet-marker-icon--bouncing')) {
                        // Si tiene la clase 'bouncing', la eliminamos
                        icon.classList.remove('leaflet-marker-icon--bouncing');
                    } else {
                        // Si no tiene la clase 'bouncing', la añadimos
                        icon.classList.add('leaflet-marker__icon--bouncing');
                    }
                    if (!marker.options.bouncing) {

                        marker.options.bouncing = true;  // Marcamos que el rebote está activado
                    } else {

                        marker.options.bouncing = false;  // Marcamos que el rebote está detenido
                    }
                    simulateBounce(marker);
                },
                generateViewDataPosition: function (params) {
                    var {event, customIcon, map} = params;
                    const latlng = event.latlng; // Obtener las coordenadas del clic

                    // Crear un nuevo marcador con el ícono personalizado
                    const newMarker = L.marker(latlng, {icon: customIcon}).addTo(map);
                    console.log(newMarker);
                    // Agregar un popup al nuevo marcador con el HTML proporcionado
                    newMarker.bindPopup(`
      <div class="map-popup-wrap">
        <div class="map-popup">
          <div class="infoBox-close">
            <i class="fa fa-times"></i>
          </div>
          <div class="map-popup-category">Oficios / Servicios</div>
          <a href="http://localhost:6969/meetclickmanager/es/businessDetails/Meetclic" class="listing-img-content fl-wrap">
            <img src="https://meetclic.com/public/uploads/business/information/1745413604_bomberos.jpg" alt="">
          </a>
          <div class="listing-content fl-wrap">
            <div class="card-popup-raining map-card-rainting" data-starrating="2">
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <span class="map-popup-reviews-count">( 1 reviews )</span>
            </div>
            <div class="listing-title fl-wrap">
              <h4>
                <a href="http://localhost:6969/meetclickmanager/es/businessDetails/Meetclic">Meetclic</a>
              </h4>
              <span class="map-popup-location-info">
                <i class="fa fa-map-marker"></i>Piedrahita y Buenos Aires, Buenos AIRE
              </span>
              <span class="map-popup-location-phone">
                <i class="fa fa-phone"></i>0985339457
              </span>
            </div>
          </div>
        </div>
      </div>
    `).openPopup();
                }

            }
        });
        var appInitCurrent = new Vue(
            {

                mounted: function () {
                    this.initCurrentComponent();
                    appThis = this;
                },
                el: '#app-management',
                created: function () {

                },
                data: {
                    //MENU
                    menuCurrent: [],
                    configDataBusiness: {
                        title: "Registro de Habitaciones",
                        data: [],
                        titleEvent: "",
                        business_id: null
                    },
                    events: [
                        {
                            title: 'event1',
                            start: '2010-01-01',
                        },
                        {
                            title: 'event2',
                            start: '2010-01-05',
                            end: '2010-01-07',
                        },
                        {
                            title: 'event3',
                            start: '2010-01-09T12:30:00',
                            allDay: false,
                        },
                    ]
                },
                methods: {
                    ...$methodsFormValid,
                    /*FORM*/
                    _submitForm: function (e) {
                        console.log(e);
                    },
                    initCurrentComponent: function () {

                    }, initManagement: function () {
                        console.log("init app");
                    },
                    /*---EVENTS CHILDREN to Parent COMPONENTS----*/
                    _updateParentByChildren: function (params) {
                        console.log(params);
                    },

                }
            })
        ;
    </script>

    <script>


        $(function () {

            $('.header-search').show();
        })
        var $dataManagerPageView = <?php echo json_encode($dataManagerPage) ?>;

    </script>
@endsection


@if(isset($dataManagerPage['type']))
    @if(  $dataManagerPage['type']==1)
        @section('content-manager')
            @if(isset($dataManagerPage['sliderMainManager']))
                @include('cityBook.web.partials.home.sliderMain')
            @endif
        @endsection

    @endif

    @section('content')

        <div id="app-management" class="page-home-init" dataManagerPageType="{{$dataManagerPage['type']}}">
            @if(isset($dataManagerPage['categoriesBusiness']))
                <section id="sec2" class="categories">
                    <div class="container">
                        <div class="section-title">
                            <h2>{{__('frontend.menu.home.categories.title')}}</h2>
                            <div class="section-subtitle">{{__('frontend.menu.home.categories.subtitle')}}</div>
                            <span class="section-separator"></span>
                            <p>{{__('frontend.menu.home.categories.description')}}</p>
                        </div>
                        @include('layouts.partials.cityBook.categories')
                        <a href="{{route('search',app()->getLocale())}}"
                           class="btn  big-btn circle-btn dec-btn  btn--search-data"> {{__('frontend.menu.home.categories.button-search')}}
                            <i
                                class="fa fa-eye"></i></a>
                    </div>
                </section>
            @endif

            @include('cityBook.web.partials.home.popularList')

            @if(!Auth::check())
                @include('layouts.partials.cityBook.join',['typeJoin'=>1,'class-content'=>'color-bg--join-home'])
            @endif

            <section>
                <div class="container">
                    @include('layouts.partials.cityBook.work-it')
                </div>
            </section>
            <section class="parallax-section" data-scrollax-parent="true">
                <div class="bg bg--home" data-bg="{{URL::asset($themePath.'images/bg/40.png')}}"
                ></div>
                <div class="overlay co lor-overlay"></div>
                <!--container-->
                <div class="container">
                    <div class="intro-item fl-wrap intro-item--home">
                        <h2>{{__('frontend.menu.home.background.one.title')}}</h2>
                        <h3>{{__('frontend.menu.home.background.one.subtitle')}}</h3>
                        <a class="trs-btn trs-btn--home"
                           href="{{route('search',app()->getLocale())}}">{{__('frontend.menu.home.background.one.button')}}
                            + </a>
                    </div>
                </div>
            </section>

            @include('layouts.partials.cityBook.support')
            @include('layouts.partials.cityBook.counterViews')
            @if(env('allowTestimonials'))
                <section>
                    <div class="container">
                        <div class="section-title">
                            <h2>{{__('frontend.menu.home.testimonials.title')}}</h2>
                            <div class="section-subtitle">{{__('frontend.menu.home.testimonials.subtitle')}}</div>
                            <span class="section-separator"></span>
                            <p>{{__('frontend.menu.home.testimonials.description')}}</p>
                        </div>
                    </div>

                    @include('layouts.partials.cityBook.testimonials')

                </section>
            @endif
            @if(env('allowCustomersBusiness'))
                @include('layouts.partials.cityBook.customers')
            @endif
            @if(env('allowBlog'))

                <section>
                    <div class="container">
                        <div class="section-title">
                            <h2>{{__('frontend.menu.home.blog.title')}}</h2>
                            <div class="section-subtitle">{{__('frontend.menu.home.blog.subtitle')}}</div>
                            <span class="section-separator"></span>
                            <p>{{__('frontend.menu.home.blog.description')}}</p>
                        </div>
                        <div class="row home-posts">
                            <div class="col-md-4">
                                <article class="card-post">
                                    <div class="card-post-img fl-wrap">
                                        <a href="blog-single.html"><img
                                                src="{{ URL::asset($themePath.'images/all/15.jpg')}}" alt=""></a>
                                    </div>
                                    <div class="card-post-content fl-wrap">
                                        <h3><a href="blog-single.html">Creacion de Empresas</a></h3>
                                        <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis
                                            cursus. Nulla eu mi magna. Etiam suscipit commodo gravida. </p>
                                        <div class="post-author"><a href="#"><img
                                                    src="{{ URL::asset($themePath.'images/avatar/4.jpg')}}"
                                                    alt=""><span>By , Alisa Noory</span></a>
                                        </div>
                                        <div class="post-opt">
                                            <ul>
                                                <li><i class="fa fa-calendar-check-o"></i> <span>25 April 2018</span>
                                                </li>
                                                <li><i class="fa fa-eye"></i> <span>264</span></li>
                                                <li><i class="fa fa-tags"></i> <a href="#">Photography</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-md-4">
                                <article class="card-post">
                                    <div class="card-post-img fl-wrap">
                                        <a href="blog-single.html"><img
                                                src="{{ URL::asset($themePath.'images/all/18.jpg')}}" alt=""></a>
                                    </div>
                                    <div class="card-post-content fl-wrap">
                                        <h3><a href="blog-single.html">Comparte y Gane</a></h3>
                                        <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis
                                            cursus. Nulla eu mi magna. Etiam suscipit commodo gravida. </p>
                                        <div class="post-author"><a href="#"><img
                                                    src="{{ URL::asset($themePath.'images/avatar/5.jpg')}}"
                                                    alt=""><span>By , Mery Lynn</span></a>
                                        </div>
                                        <div class="post-opt">
                                            <ul>
                                                <li><i class="fa fa-calendar-check-o"></i> <span>25 April 2018</span>
                                                </li>
                                                <li><i class="fa fa-eye"></i> <span>264</span></li>
                                                <li><i class="fa fa-tags"></i> <a href="#">Design</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-md-4">
                                <article class="card-post">
                                    <div class="card-post-img fl-wrap">
                                        <a href="blog-single.html"><img
                                                src="{{ URL::asset($themePath.'images/all/19.jpg')}}" alt=""></a>
                                    </div>
                                    <div class="card-post-content fl-wrap">
                                        <h3><a href="blog-single.html">Refiere y Gana</a></h3>
                                        <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis
                                            cursus. Nulla eu mi magna. Etiam suscipit commodo gravida. </p>
                                        <div class="post-author"><a href="#"><img
                                                    src="{{ URL::asset($themePath.'images/avatar/6.jpg')}}"
                                                    alt=""><span>By , Garry Dee</span></a>
                                        </div>
                                        <div class="post-opt">
                                            <ul>
                                                <li><i class="fa fa-calendar-check-o"></i> <span>25 April 2018</span>
                                                </li>
                                                <li><i class="fa fa-eye"></i> <span>264</span></li>
                                                <li><i class="fa fa-tags"></i> <a href="#">Stories</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <a href="blog.html" class="btn  big-btn circle-btn  dec-btn color-bg flat-btn">Read All<i
                                class="fa fa-eye"></i></a>
                    </div>
                </section>
            @endif
            <section class="gradient-bg gradient-bg--home-contact-us">
                <div class="cirle-bg">
                    <div class="bg" data-bg="{{ URL::asset($themePath.'images/bg/circle.png')}}"></div>
                </div>
                <div class="container">
                    <div class="join-wrap fl-wrap">
                        <div class="row">
                            <div class="col-md-8">
                                <h3>{{__('frontend.menu.home.do-you-have.title')}}</h3>
                                <p>{{__('frontend.menu.home.do-you-have.description')}}</p>
                            </div>
                            <div class="col-md-4"><a href="{{route('contactUsBee',app()->getLocale())}}"
                                                     class="join-wrap-btn">{{__('frontend.menu.home.do-you-have.button')}}
                                    <i
                                        class="fa fa-envelope-o"></i></a></div>
                        </div>
                    </div>
                </div>
            </section>

            <map-manager-component

                ref="refBusiness"
                :params="configDataBusiness"
                v-on:_actions-emit="_updateParentByChildren($event)"

            ></map-manager-component>
        </div>
    @endsection
@elseif(  $dataManagerPage['type']==0)
    @section('content')
        <div id="app-management" dataManagerPageType="{{$dataManagerPage['type']}}">

            @include('layouts.partials.cityBook.home.slider.slider')

            <section id="sec2">
                <div class="container">
                    <div class="section-title">
                        <h2>{{__('frontend.menu.home.categories.title')}}</h2>
                        <div class="section-subtitle">{{__('frontend.menu.home.categories.subtitle')}}</div>
                        <span class="section-separator"></span>
                        <p>{{__('frontend.menu.home.categories.description')}}</p>
                    </div>

                    @include('layouts.partials.cityBook.categories')

                    <a href="{{route('search',app()->getLocale())}}"
                       class="btn  big-btn circle-btn dec-btn  color-bg flat-btn">View
                        All<i
                            class="fa fa-eye"></i></a>
                </div>
            </section>

            <section class="gray-section">
                <div class="container">
                    <div class="section-title">
                        <h2>{{__('frontend.menu.home.listing.title')}}</h2>
                        <div class="section-subtitle">{{__('frontend.menu.home.listing.subtitle')}}</div>
                        <span class="section-separator"></span>
                        <p>{{__('frontend.menu.home.listing.description')}}</p>
                    </div>
                </div>

                <div class="list-carousel fl-wrap card-listing ">

                    <div class="listing-carousel  fl-wrap ">

                        <div class="slick-slide-item">

                            <div class="listing-item">
                                <article class="geodir-category-listing fl-wrap">
                                    <div class="geodir-category-img">
                                        <img src="{{ URL::asset($themePath.'images/all/1.jpg')}}" alt="">
                                        <div class="overlay"></div>
                                        <div class="list-post-counter"><span>4</span><i class="fa fa-heart"></i></div>
                                    </div>
                                    <div class="geodir-category-content fl-wrap">
                                        <a class="listing-geodir-category" href="listing.html">Retail</a>
                                        <div class="listing-avatar"><a href="author-single.html"><img
                                                    src="{{ URL::asset($themePath.'images/avatar/5.jpg')}}" alt=""></a>
                                            <span class="avatar-tooltip">Added By  <strong>Lisa Smith</strong></span>
                                        </div>
                                        <h3><a href="listing-single.html">Event in City Mol</a></h3>
                                        <p>Sed interdum metus at nisi tempor laoreet. </p>
                                        <div class="geodir-category-options fl-wrap">
                                            <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                                <span>(7 reviews)</span>
                                            </div>
                                            <div class="geodir-category-location"><a href="#"><i
                                                        class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn
                                                    New York, NY 10065</a></div>
                                        </div>
                                    </div>
                                </article>
                            </div>

                        </div>

                        <div class="slick-slide-item">

                            <div class="listing-item">
                                <article class="geodir-category-listing fl-wrap">
                                    <div class="geodir-category-img">
                                        <img src="{{ URL::asset($themePath.'images/all/2.jpg')}}" alt="">
                                        <div class="overlay"></div>
                                        <div class="list-post-counter"><span>15</span><i class="fa fa-heart"></i></div>
                                    </div>
                                    <div class="geodir-category-content fl-wrap">
                                        <a class="listing-geodir-category" href="listing.html">Event</a>
                                        <div class="listing-avatar"><a href="author-single.html"><img
                                                    src="{{ URL::asset($themePath.'images/avatar/2.jpg')}}" alt=""></a>
                                            <span class="avatar-tooltip">Added By  <strong>Mark Rose</strong></span>
                                        </div>
                                        <h3><a href="listing-single.html">Cafe "Lollipop"</a></h3>
                                        <p>Morbi suscipit erat in diam bibendum rutrum in nisl.</p>
                                        <div class="geodir-category-options fl-wrap">
                                            <div class="listing-rating card-popup-rainingvis" data-starrating2="4">
                                                <span>(17 reviews)</span>
                                            </div>
                                            <div class="geodir-category-location"><a href="#"><i
                                                        class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn
                                                    New York, NY 10065</a></div>
                                        </div>
                                    </div>
                                </article>
                            </div>

                        </div>

                        <div class="slick-slide-item">

                            <div class="listing-item">
                                <article class="geodir-category-listing fl-wrap">
                                    <div class="geodir-category-img">
                                        <img src="{{ URL::asset($themePath.'images/all/20.jpg')}}" alt="">
                                        <div class="overlay"></div>
                                        <div class="list-post-counter"><span>13</span><i class="fa fa-heart"></i></div>
                                    </div>
                                    <div class="geodir-category-content fl-wrap">
                                        <a class="listing-geodir-category" href="listing.html">Gym </a>
                                        <div class="listing-avatar"><a href="author-single.html"><img
                                                    src="{{ URL::asset($themePath.'images/avatar/4.jpg')}}" alt=""></a>
                                            <span class="avatar-tooltip">Added By  <strong>Nasty Wood</strong></span>
                                        </div>
                                        <h3><a href="listing-single.html">Gym In Brooklyn</a></h3>
                                        <p>Morbiaccumsan ipsum velit tincidunt . </p>
                                        <div class="geodir-category-options fl-wrap">
                                            <div class="listing-rating card-popup-rainingvis" data-starrating2="3">
                                                <span>(16 reviews)</span>
                                            </div>
                                            <div class="geodir-category-location"><a href="#"><i
                                                        class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn
                                                    New York, NY 10065</a></div>
                                        </div>
                                    </div>
                                </article>
                            </div>

                        </div>

                        <div class="slick-slide-item">

                            <div class="listing-item">
                                <article class="geodir-category-listing fl-wrap">
                                    <div class="geodir-category-img">
                                        <img src="{{ URL::asset($themePath.'images/all/5.jpg')}}" alt="">
                                        <div class="overlay"></div>
                                        <div class="list-post-counter"><span>3</span><i class="fa fa-heart"></i></div>
                                    </div>
                                    <div class="geodir-category-content fl-wrap">
                                        <a class="listing-geodir-category" href="listing.html">Shops</a>
                                        <div class="listing-avatar"><a href="author-single.html"><img
                                                    src="{{ URL::asset($themePath.'images/avatar/1.jpg')}}" alt=""></a>
                                            <span class="avatar-tooltip">Added By  <strong>Nasty Wood</strong></span>
                                        </div>
                                        <h3><a href="listing-single.html">Shop in Boutique Zone</a></h3>
                                        <p>Morbiaccumsan ipsum velit tincidunt . </p>
                                        <div class="geodir-category-options fl-wrap">
                                            <div class="listing-rating card-popup-rainingvis" data-starrating2="4">
                                                <span>(6 reviews)</span>
                                            </div>
                                            <div class="geodir-category-location"><a href="#"><i
                                                        class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn
                                                    New York, NY 10065</a></div>
                                        </div>
                                    </div>
                                </article>
                            </div>

                        </div>

                        <div class="slick-slide-item">

                            <div class="listing-item">
                                <article class="geodir-category-listing fl-wrap">
                                    <div class="geodir-category-img">
                                        <img src="{{ URL::asset($themePath.'images/all/6.jpg')}}" alt="">
                                        <div class="overlay"></div>
                                        <div class="list-post-counter"><span>35</span><i class="fa fa-heart"></i></div>
                                    </div>
                                    <div class="geodir-category-content fl-wrap">
                                        <a class="listing-geodir-category" href="listing.html">Cars</a>
                                        <div class="listing-avatar"><a href="author-single.html"><img
                                                    src="{{ URL::asset($themePath.'images/avatar/6.jpg')}}" alt=""></a>
                                            <span class="avatar-tooltip">Added By  <strong>Kliff Antony</strong></span>
                                        </div>
                                        <h3><a href="listing-single.html">Best deal For the Cars</a></h3>
                                        <p>Lorem ipsum gravida nibh vel velit.</p>
                                        <div class="geodir-category-options fl-wrap">
                                            <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                                <span>(11 reviews)</span>
                                            </div>
                                            <div class="geodir-category-location"><a href="#"><i
                                                        class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn
                                                    New York, NY 10065</a></div>
                                        </div>
                                    </div>
                                </article>
                            </div>

                        </div>

                        <div class="slick-slide-item">

                            <div class="listing-item">
                                <article class="geodir-category-listing fl-wrap">
                                    <div class="geodir-category-img">
                                        <img src="{{ URL::asset($themePath.'images/all/4.jpg')}}" alt="">
                                        <div class="overlay"></div>
                                        <div class="list-post-counter"><span>553</span><i class="fa fa-heart"></i></div>
                                    </div>
                                    <div class="geodir-category-content fl-wrap">
                                        <a class="listing-geodir-category" href="listing.html">Restourants</a>
                                        <div class="listing-avatar"><a href="author-single.html"><img
                                                    src="{{ URL::asset($themePath.'images/avatar/3.jpg')}}" alt=""></a>
                                            <span class="avatar-tooltip">Added By  <strong>Adam Koncy</strong></span>
                                        </div>
                                        <h3><a href="listing-single.html">Luxury Restourant</a></h3>
                                        <p>Sed non neque elit. Sed ut imperdie.</p>
                                        <div class="geodir-category-options fl-wrap">
                                            <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                                <span>(7 reviews)</span>
                                            </div>
                                            <div class="geodir-category-location"><a href="#"><i
                                                        class="fa fa-map-marker" aria-hidden="true"></i> 27th Brooklyn
                                                    New York, NY 10065</a></div>
                                        </div>
                                    </div>
                                </article>
                            </div>

                        </div>

                    </div>

                    <div class="swiper-button-prev sw-btn"><i class="fa fa-long-arrow-left"></i></div>
                    <div class="swiper-button-next sw-btn"><i class="fa fa-long-arrow-right"></i></div>
                </div>

            </section>

            @if(!Auth::check())
                @include('layouts.partials.cityBook.join',['typeJoin'=>1])
            @endif

            <section>
                <div class="container">
                    @include('layouts.partials.cityBook.work-it')
                </div>
            </section>
            <section class="parallax-section" data-scrollax-parent="true">
                <div class="bg" data-bg="{{URL::asset($themePath.'images/bg/8.jpg')}}"
                     data-scrollax="properties: { translateY: '100px' }"></div>
                <div class="overlay co lor-overlay"></div>
                <!--container-->
                <div class="container">
                    <div class="intro-item fl-wrap">
                        <h2>{{__('frontend.menu.home.background.one.title')}}</h2>
                        <h3>{{__('frontend.menu.home.background.one.subtitle')}}</h3>
                        <a class="trs-btn"
                           href="{{route('search',app()->getLocale())}}">{{__('frontend.menu.home.background.one.button')}}
                            + </a>
                    </div>
                </div>
            </section>

            @include('layouts.partials.cityBook.plans')

            @include('layouts.partials.cityBook.counterViews')

            <section>
                <div class="container">
                    <div class="section-title">
                        <h2>{{__('frontend.menu.home.testimonials.title')}}</h2>
                        <div class="section-subtitle">{{__('frontend.menu.home.testimonials.subtitle')}}</div>
                        <span class="section-separator"></span>
                        <p>{{__('frontend.menu.home.testimonials.description')}}</p>
                    </div>
                </div>

                @include('layouts.partials.cityBook.testimonials')

            </section>
            @if(false)
                @include('layouts.partials.cityBook.customers')
            @endif
            <section>
                <div class="container">
                    <div class="section-title">
                        <h2>{{__('frontend.menu.home.blog.title')}}</h2>
                        <div class="section-subtitle">{{__('frontend.menu.home.blog.subtitle')}}</div>
                        <span class="section-separator"></span>
                        <p>{{__('frontend.menu.home.blog.description')}}</p>
                    </div>
                    <div class="row home-posts">
                        <div class="col-md-4">
                            <article class="card-post">
                                <div class="card-post-img fl-wrap">
                                    <a href="blog-single.html"><img
                                            src="{{ URL::asset($themePath.'images/all/15.jpg')}}" alt=""></a>
                                </div>
                                <div class="card-post-content fl-wrap">
                                    <h3><a href="blog-single.html">Gallery Post</a></h3>
                                    <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis
                                        cursus. Nulla eu mi magna. Etiam suscipit commodo gravida. </p>
                                    <div class="post-author"><a href="#"><img
                                                src="{{ URL::asset($themePath.'images/avatar/4.jpg')}}" alt=""><span>By , Alisa Noory</span></a>
                                    </div>
                                    <div class="post-opt">
                                        <ul>
                                            <li><i class="fa fa-calendar-check-o"></i> <span>25 April 2018</span></li>
                                            <li><i class="fa fa-eye"></i> <span>264</span></li>
                                            <li><i class="fa fa-tags"></i> <a href="#">Photography</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-md-4">
                            <article class="card-post">
                                <div class="card-post-img fl-wrap">
                                    <a href="blog-single.html"><img
                                            src="{{ URL::asset($themePath.'images/all/18.jpg')}}" alt=""></a>
                                </div>
                                <div class="card-post-content fl-wrap">
                                    <h3><a href="blog-single.html">Video and gallery post</a></h3>
                                    <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis
                                        cursus. Nulla eu mi magna. Etiam suscipit commodo gravida. </p>
                                    <div class="post-author"><a href="#"><img
                                                src="{{ URL::asset($themePath.'images/avatar/5.jpg')}}" alt=""><span>By , Mery Lynn</span></a>
                                    </div>
                                    <div class="post-opt">
                                        <ul>
                                            <li><i class="fa fa-calendar-check-o"></i> <span>25 April 2018</span></li>
                                            <li><i class="fa fa-eye"></i> <span>264</span></li>
                                            <li><i class="fa fa-tags"></i> <a href="#">Design</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-md-4">
                            <article class="card-post">
                                <div class="card-post-img fl-wrap">
                                    <a href="blog-single.html"><img
                                            src="{{ URL::asset($themePath.'images/all/19.jpg')}}" alt=""></a>
                                </div>
                                <div class="card-post-content fl-wrap">
                                    <h3><a href="blog-single.html">Post Article</a></h3>
                                    <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis
                                        cursus. Nulla eu mi magna. Etiam suscipit commodo gravida. </p>
                                    <div class="post-author"><a href="#"><img
                                                src="{{ URL::asset($themePath.'images/avatar/6.jpg')}}" alt=""><span>By , Garry Dee</span></a>
                                    </div>
                                    <div class="post-opt">
                                        <ul>
                                            <li><i class="fa fa-calendar-check-o"></i> <span>25 April 2018</span></li>
                                            <li><i class="fa fa-eye"></i> <span>264</span></li>
                                            <li><i class="fa fa-tags"></i> <a href="#">Stories</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                    <a href="blog.html"
                       class="btn  big-btn circle-btn  dec-btn color-bg flat-btn">{{__('frontend.menu.home.blog.button')}}
                        <i
                            class="fa fa-eye"></i></a>
                </div>
            </section>

            <section class="gradient-bg gradient-bg--home-contact-us">
                <div class="cirle-bg">
                    <div class="bg" data-bg="{{ URL::asset($themePath.'images/bg/circle.png')}}"></div>
                </div>
                <div class="container">
                    <div class="join-wrap fl-wrap">
                        <div class="row">
                            <div class="col-md-8">
                                <h3>{{__('frontend.menu.home.do-you-have.title')}}</h3>
                                <p>{{__('frontend.menu.home.do-you-have.description')}}</p>
                            </div>
                            <div class="col-md-4"><a href="{{route('contactUsBee',app()->getLocale())}}"
                                                     class="join-wrap-btn">{{__('frontend.menu.home.do-you-have.button')}}
                                    <i
                                        class="fa fa-envelope-o"></i></a></div>
                        </div>
                    </div>
                </div>
            </section>


        </div>
    @endsection
@endif

