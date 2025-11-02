<!-- MANAGER-EMPRESAS(CMS)-BUSINESS-->
@extends('layouts.cityBook')
@section('additional-styles')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>

    <style>
        #listing-submission-form #listing_cats, #nearby-checkbox:checked + #use-nearby-label, .accordion a.toggle.act-accordion, .add-list, .addfield, .author-social a, .available-cal-months .cal-date-checked, .available_counter, .back-to-filters, .back-to-filters span, .box-item a.gal-link, .box-widget-item .list-single-tags a, .btn-unlock-month, .btn.flat-btn, .btn.transparent-btn:hover, .card-btn, .card-btn:hover, .cart-count, .chat-counter, .chat-error-message, .chat-item:after, .chat-replies-lmore span, .chat-replies-loading span, .cluster div, .color-bg, .color-overlay, .count-select-ser, .cs-countdown-item:before, .cs-social li a, .ctb-modal-close, .cth-dropdown-options input[type=checkbox]:checked + label, .custom-form .log-submit-btn, .custom-form .nice-select, .custom-form .nice-select .list li.selected, .custom-form .nice-select .list li:hover, .custom-form .quantity input.qty, .custom-form .selectbox, .dashboard-listing-table-opt li a.del-btn, .del-btn, .error-wrap form .search-submit, .folio-counter, .footer-menu li:before, .footer-widget #subscribe-button, .fs-map-btn, .header-search-button, .header-search-select-item .nice-select .list li.selected, .header-search-select-item .nice-select .list li:hover, .header-sec-link a, .header-social li a:hover, .hs-nav .navslide-wrap.next-slide-wrap a, .infoBox-close, .irs-bar, .irs-bar-edge, .irs-slider, .jspDrag, .lfilter-submit, .lg-actions .lg-next, .lg-actions .lg-prev, .list-author-widget-socials a, .list-single-main-wrapper .breadcrumbs, .list-widget-social li a, .listing-carousel-wrap .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active, .listing-counter, .listing-verified, .listing-view-layout li a, .listsearch-input-item .nice-select, .listsearch-input-item .nice-select .list li.selected, .listsearch-input-item .nice-select .list li.selected.focus, .listsearch-input-item .nice-select .list li:hover, .listsearch-input-item .selectbox, .load-more-button, .loading-indicator span, .log-out-btn:hover, .main-search-button, .main-search-input-item .nice-select .list li.selected, .main-search-input-item .nice-select .list li:hover, .map-popup-category, .mapnavigation a:hover, .mapzoom-in, .mapzoom-out, .mb-btns-wrap, .mb-open-filter, .message-input button, .more-filter-option span, .more-photos-button, .nav-holder nav li.current-menu-ancestor > a:before, .nav-holder nav li.current-menu-item > a:before, .nav-holder nav li.current-menu-parent > a:before, .navslide-wrap, .ol-control button, .pac-item:hover, .pagination .nav-links > span.current, .pagination a.current-page, .pagination a:hover, .parallax-section .section-separator:before, .photoUpload, .pin, .price-head, .price-link, .profile-edit-page-header .breadcrumbs a:before, .protected-wrap input[type=submit], .rangeslider__fill, .remove-date-time:hover, .reply-time span:before, .reviews-comments-item-text .new-dashboard-item:hover, .scroll-nav-wrapper .scroll-nav li a:before, .section-separator:before, .section-title .breadcrumbs a:before, .section-title .woocommerce-breadcrumb a:before, .selectbox li:hover, .showshare, .slick-dots li.slick-active button, .slide-progress, .sp-cont:hover, .step-item, .submit-field-wkhour .addfieldssss, .submit-field-wkhour .chosen-tz, .submit-field-wkhour .tabs-menu .active, .subscribe-form .subscribe-button, .sw-btn, .sw-btn.swiper-button-next, .sw-btn.swiper-button-prev, .tabs-menu li.current a, .tabs-menu li a:hover, .tagcloud a, .testi-counter, .testimonials-carousel .slick-current .testimonilas-text, .time-line-container:before, .to-top, .tooltipwrap .tooltiptext, .trs-btn, .typing-indicator, .typing-indicator:after, .typing-indicator:before, .user-profile-menu li a span, .video-box-btn, .widget-posts-link span, .widget_search .search-submit, .your-reply .reply-text, nav li a.act-link:before {
            background: #4db7fe;
        }

        .to-top--bee {

            display: none !important;
        }

        .card-listing .geodir-category-location a.map-item:before {
            content: "Ver";
            left: 0px !important;
            top: 21px !important;
            right: 0px;
        }

        .select2-container {
            text-align: left;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            font-size: 26px;
        }
        .card-listing .geodir-category-img img {


            width: 100%;
            height: 194px !important;

        }
    </style>
@endsection
@section('additional-scripts')

    <script type="text/javascript" src="{{URL::asset($resourcePathServer.'libs/vue/pagination/index.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="{{URL::asset($resourcePathServer.'libs/geoxml3/geoxml3.js')}}"></script>

    <script>

        var $paramsRequest = <?php echo json_encode($paramsRequest)?>;
        var markerIcon = {
            anchor: new google.maps.Point(22, 16),
            url: $resourceRoot + 'images/marker.png',
        };
        var $rootPageSingle = '{{route('listingSingle',app()->getLocale())}}';
        var $dataManagerPage =<?php echo json_encode($dataManagerPage)?>;
        var $boundsCurrent = null;
        var $configManagerMap = {
            markers: [],
            managerCluster: null,
        };
    </script>
    <script>
        var initMarkerIndex = null;
        Vue.component('paginate', VuejsPaginate);
        var $currentApp;
        const app = new Vue(
            {
                directives: {
                    'init-listing-items': {
                        inserted: function (el, binding, vnode, vm, arg) {

                            var paramsInput = binding.value;
                            var initMethod = paramsInput['initMethod'];
                            initMethod({
                                elementInit: el,
                                params: paramsInput
                            });
                        }
                    },
                    'init-select': {
                        inserted: function (el, binding, vnode, vm, arg) {
                            var paramsInput = binding.value;
                            var initMethod = paramsInput['initMethod'];
                            initMethod({
                                elementInit: el,
                                params: paramsInput
                            });
                        }
                    }


                },
                el: '#app-management',
                created: function () {
                    $currentApp = this;
                    var $scope = this;
                    this.model.attributes.keywords = $dataManagerPage.paramsRequestCurrent.searchPhrase;
                    this.model.attributes.category = $dataManagerPage.paramsRequestCurrent.hasOwnProperty('categoryData') && $dataManagerPage.paramsRequestCurrent.categoryData.hasOwnProperty('id') ? $dataManagerPage.paramsRequestCurrent.categoryData : null;
                    $(function () {

                        if ($scope.model.attributes.category) {

                            $('.more-filter-option').click();
                        }
                        $scope.initManagement();

                    });
                },
                data: function () {
                    return {
                        managerLoading: {
                            map: {
                                view: true
                            },
                            data: {
                                view: true
                            },
                            page: {
                                view: true
                            }
                        },
                        businessData: [],
                        configGridAdmin: {
                            html: '',
                            isEmpty: false,
                            msj: {
                                empty: '<h1>No existe Datos</h1>',
                            }
                        },
                        configPagination: {
                            items: [],
                            itemActive: 0,
                            totalData: 0,
                            rowCountPerPage: 0,
                            currentPage: 0,
                            html: '',
                            view: {
                                init: 0,
                                to: 0,

                            }
                        },
                        model: {
                            attributes: {
                                'keywords': null,
                                'address-google': null,
                                'country': null,
                                'category': null,
                                'distance': 0,
                                'check': false,
                                currentPage: 0
                            }
                        }
                    };
                },
                methods: {
                    onListenElementsForm:onListenElementsForm,
                    initManagement: function () {

                        this._managerGrid($dataManagerPage.items);
                        this._eventsMapCurrent();
                        this.initMapCurrent();

                    },
                    getDataBusiness: function () {
                        var current = this.model.attributes.currentPage;
                        var searchPhrase = this.model.attributes.keywords;
                        var distance = this.model.attributes.distance;
                        var check = this.model.attributes.check;
                        var country_id = this.model.attributes.country;
                        var category_id = this.model.attributes.category;
                        var addressGoogleCountry = this.model.attributes['address-google'];
                        var dataSend = {
                            searchPhrase: searchPhrase,
                            current: current,
                            filters: {
                                check: check,
                                distance: distance,
                                country_id: country_id,
                                category_id: category_id,
                                addressGoogleCountry: addressGoogleCountry
                            }
                        };
                        $scope = this;
                        var url = $('#action-business-searchBusinessBee').val();
                        /*  $configManagerMap.markers*/
                        getAjaxRequest({
                            type: 'POST',
                            'url': url,
                            data: dataSend,
                            successCallback: function (response) {
                                $scope._managerGrid(response.items);
                                $scope.managerLoading.data.view = false;
                                $scope._resetManagerMaps(response.items);
                            },
                            beforeSend: function () {
                                $scope.managerLoading.data.view = true;

                            },

                        });
                    },
                    _resetManagerMaps: function (items) {
                        this._resetValuesMaps();
                        var locations = items.locationsItems;
                        var map = this.map;
                        managerMarkers({
                            map: map,
                            locations: locations,

                        });
                    },
                    _element: function (e) {
                        console.log(e);
                    },
                    getManagerPagination: function (listingManager) {
                        var totalData = listingManager.total;
                        var rowCountPerPage = listingManager.rowCount;
                        var currentPage = listingManager.current + 1;
                        var initialPage = listingManager.current == 0 ? listingManager.current : listingManager.current - 1;
                        var totalPages = totalData / rowCountPerPage;
                        var isMultiple = totalPages % 2;
                        if (isMultiple != 0) {
                            var resultPage = Math.floor(totalData / rowCountPerPage);
                            var resultCurrentData = resultPage * rowCountPerPage;
                            if (totalData > resultCurrentData) {
                                totalPages = resultPage + 1;

                            }
                        }

                        var configPagination = {
                            items: [],
                            itemActive: currentPage,
                            totalData: totalData,
                            rowCountPerPage: rowCountPerPage,
                            currentPage: currentPage,
                            totalPages: totalPages,
                            initialPage: initialPage
                        }

                        var viewPage = {
                            to: this.getViewDataTo(configPagination),
                            init: this.getViewDataInit(configPagination),
                        };
                        configPagination.view = viewPage;
                        return configPagination;
                    },
                    getViewDataInit: function (configPagination) {
                        var result = 1;
                        if (parseFloat(configPagination.initialPage) > 0) {
                            result = parseFloat(configPagination.initialPage) * parseFloat(configPagination.rowCountPerPage);
                        }

                        return result;
                    },
                    getViewDataTo: function (configPagination) {
                        var result = parseFloat(configPagination.rowCountPerPage);
                        if (parseFloat(configPagination.initialPage) > 0) {
                            result = parseFloat(configPagination.initialPage) * parseFloat(configPagination.rowCountPerPage);
                        }

                        return result;
                    },
                    _managerGrid: function (items) {
                        this.configGridAdmin.isEmpty = items['allow-data'] ? false : true;
                        this.configGridAdmin.html = '';
                        this.configPagination = this.getManagerPagination(items.listing);
                        this.configGridAdmin.html = items.listingHtml;

                    },
                    initMapCurrent: function () {
                        $scope = this;
                        $boundsCurrent = new google.maps.LatLngBounds();

                        function mainMap(params) {
                            var locations = params['dataCurrent']
                            var map = new google.maps.Map(document.getElementById('map-main'), {
                                zoom: 9,
                                scrollwheel: false,
                                center: new google.maps.LatLng(40.7, -73.87),
                                mapTypeId: google.maps.MapTypeId.ROADMAP,
                                zoomControl: false,
                                mapTypeControl: false,
                                scaleControl: true,//
                                streetViewControl: false,
                                overviewMapControl: false,
                                panControl: false,
                                fullscreenControl: true,
                                navigationControl: false,
                                streetViewControl: false,
                                animation: google.maps.Animation.BOUNCE,
                                gestureHandling: 'cooperative',
                                styles: [{
                                    "featureType": "administrative",
                                    "elementType": "labels.text.fill",
                                    "stylers": [{
                                        "color": "#444444"
                                    }]
                                }]
                            });
                            var greyStyleMap = new google.maps.StyledMapType($greyscale_style, {
                                name: "Greyscale"
                            });
                            map.mapTypes.set('greyscale_style', greyStyleMap);
                            map.setMapTypeId('greyscale_style');
                            managerMarkers({
                                map: map,
                                locations: locations,

                            });

                            var scrollEnabling = $('.scrollContorl');

                            $(scrollEnabling).click(function (e) {
                                e.preventDefault();
                                $(this).toggleClass("enabledsroll");

                                if ($(this).is(".enabledsroll")) {
                                    map.setOptions({'scrollwheel': true});
                                } else {
                                    map.setOptions({'scrollwheel': false});
                                }
                            });
                            var zoomControlDiv = document.createElement('div');
                            var zoomControl = new ZoomControl(zoomControlDiv, map);

                            function ZoomControl(controlDiv, map) {
                                zoomControlDiv.index = 1;
                                map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(zoomControlDiv);
                                controlDiv.style.padding = '5px';
                                var controlWrapper = document.createElement('div');
                                controlDiv.appendChild(controlWrapper);
                                var zoomInButton = document.createElement('div');
                                zoomInButton.className = "mapzoom-in";
                                controlWrapper.appendChild(zoomInButton);
                                var zoomOutButton = document.createElement('div');
                                zoomOutButton.className = "mapzoom-out";
                                controlWrapper.appendChild(zoomOutButton);
                                google.maps.event.addDomListener(zoomInButton, 'click', function () {
                                    map.setZoom(map.getZoom() + 1);
                                });
                                google.maps.event.addDomListener(zoomOutButton, 'click', function () {
                                    map.setZoom(map.getZoom() - 1);
                                });
                            }

                            var m = map;
                            window.listingsMap = m;
                            var y = new CustomEvent("listingsMapInit", {detail: "mapInit"});
                            window.dispatchEvent(y)
                        }

                        var map = document.getElementById('map-main');
                        if (typeof (map) != 'undefined' && map != null) {
                            var locations = $dataManagerPage.items.locationsItems;

                            google.maps.event.addDomListener(window, 'load', mainMap({dataCurrent: locations}));

                        }
                    },
                    _resetValuesMaps: function () {

                        if ($configManagerMap.markers.length) {
                            $configManagerMap.markers.map(function (value, key) {
                                value.setMap(null);
                            });
                            $configManagerMap.managerCluster.clearMarkers();
                            $configManagerMap.markers = [];
                            $configManagerMap.managerCluster = [];
                        }
                    },
                    _eventsMapCurrent: function () {
                        $scope = this;
                        $scope.managerLoading.page.view = false;
                        $('.manager-page__data-page').show();
                        window.addEventListener('listingsMapInit', function (e) {
                            console.log('init listingsMapInit');
                            var scrollEnabling = $('.scrollContorl');
                            $(scrollEnabling).click();
                            $('.manager-page_map').show();
                            $scope.map = window.listingsMap;
                            $scope.map.fitBounds($boundsCurrent);
                            var configParamsDrawing = {
                                map: $scope.map,
                                'kmlGetType': 1,
                                source: "{{URL::asset($resourcePathServer.'assets/maps/ecuador/imbabura_province.kml')}}",
                                '_eventManager': $scope._initDrawingKmlGoogleMaps,
                                _hoverLay: $scope._hoverLayMap,
                                _clickLay: $scope._clickLayMap,

                            };

                            $scope.initDrawingKmlGoogleMaps(configParamsDrawing);

                            $scope.managerLoading.map.view = false;
                            $scope.managerLoading.data.view = false;
                        });
                    },
                    _initEventsMapSearch: function (params) {
                        console.log(params);
                    },
                    _initAutoCompleteGoogleMaps: function (params) {
                        console.log(params);
                    },
                    _codeAddressGoogleMaps: function (params) {
                        console.log(params);

                    },
                    _initDrawingKmlGoogleMaps: function (params) {
                        console.log(params);
                        this.map.fitBounds(params.bounds);

                    },
                    _hoverLayMap: function (params) {
                        console.log(params);
                    /*    overlay.title + '</h3>' + overlay.content +
                        var content =
                            '<div id="' + mapContainerId + '_dirContainer" style="bottom:0;padding-top:3px; font-size:13px;font-family:arial">'
                            + '<div  style="border-top:1px dotted #999;">'
                            + '<style>.BlitzMap_Menu:hover{text-decoration:underline; }</style>'
                            + '<span class="BlitzMap_Menu" style="color:#ff0000; cursor:pointer;padding:0 5px;" onclick="BlitzMap.getDirections()">Directions</span>'
                            + '<span class="BlitzMap_Menu" style="color:#ff0000; cursor:pointer;padding:0 5px;">Search nearby</span>'
                            + '<span class="BlitzMap_Menu" style="color:#ff0000; cursor:pointer;padding:0 5px;">Save to map</span>'
                            + '</div></div>';
                        return "";*/
                    },
                    _clickLayMap: function (params) {
                        console.log(params);

                    },
                    initDrawingKmlGoogleMaps: initDrawingKmlGoogleMaps,
                    initAutoCompleteGoogleMaps: initAutoCompleteGoogleMaps,
                    codeAddressGoogleMaps: codeAddressGoogleMaps,
                    _managerDataItemsMap: function (params) {
                        var cr2 = $(".card-popup-rainingvis");
                        cr2.each(function (cr) {
                            var starcount2 = $(this).attr("data-starrating2");
                            $("<i class='fa fa-star'></i>").duplicate(starcount2).prependTo(this);
                        });
                        var map = this.map;
                        $('.map-item').click(function (e) {
                            e.preventDefault();
                            map.setZoom(15);
                            var marker_index = parseInt($(this).attr('href').split('#')[1], 10);
                            google.maps.event.trigger($configManagerMap.markers[marker_index], "click");
                            if ($(this).hasClass("scroll-top-map")) {
                                $('html, body').animate({
                                    scrollTop: $(".map-container").offset().top + "-80px"
                                }, 500)
                            } else if ($(window).width() < 1064) {
                                $('html, body').animate({
                                    scrollTop: $(".map-container").offset().top + "-80px"
                                }, 500)
                            }
                        });

                        var markers = $configManagerMap.markers;
                        var r = markers;
                        $('#listing-items').on("mouseover", ".listing-item", function (e) {

                            var marker_index = parseInt($(this).attr('key-manager').split('#')[1], 10);
                            var t = marker_index;
                            initMarkerIndex = t;
                            r[t].setAnimation(google.maps.Animation.BOUNCE);
                        }).on("mouseout", ".listing-item", function (e) {
                            var marker_index = parseInt($(this).attr('key-manager').split('#')[1], 10);
                            var t = marker_index;
                            r[t].setAnimation();
                        });


                    },
                    _pageCurrent: function (pageNum) {
                        this.model.attributes.currentPage = pageNum;
                        this.getDataBusiness();
                        $("html,body").animate({
                            scrollTop: 0
                        }, {
                            queue: false,
                            duration: 1200,
                            easing: "easeInOutExpo"
                        });
                    },
                    initCategories: function (params) {
                        var el = params.elementInit
                        var dataCurrent = [];

                        if (this.model.attributes.category) {
                            dataCurrent = [
                                {
                                    'id': this.model.attributes.category.id,
                                    'text': this.model.attributes.category.text

                                }
                            ];


                        }
                        var $scope = this
                        var elementInit = $(el).select2({
                            allow: true,
                            placeholder: "Seleccione",
                            data: dataCurrent,
                            ajax: {
                                url: $("#action-business-categoriesSearchBee").val(),
                                type: 'get',
                                dataType: 'json',
                                data: function (term, page) {

                                    var paramsFilters = {
                                        filters: {
                                            search_value: term,
                                        }
                                    };
                                    return paramsFilters;
                                },
                                processResults: function (data, page) {
                                    return {results: data};
                                }
                            },
                            allowClear: true,
                            multiple: false,
                            width: '100%'
                        });

                        elementInit.on('select2:select', function (e) {
                            var data = e.params.data;
                            $scope.model.attributes.category = data.id;
                        }).on("select2:unselecting", function (e) {
                            $scope.model.attributes.category = null;


                        });
                    }
                }
            })
        ;

        function managerMarkers(params) {

            var markerCluster, marker, i;
            var map = params.map;
            var locations = params.locations;

            var clusterStyles = [{
                textColor: 'white',
                url: '',
                height: 50,
                width: 50
            }];

            function locationData(data) {
                locationURL = data.url, locationCategory = data.category, locationImg = data.img, locationTitle = data.title, locationAddress = data.address, locationPhone = data.phone, locationStarRating = data.rating, locationRevievsCounter = data.reviewCount;
                return ('<div class="map-popup-wrap"><div class="map-popup"><div class="infoBox-close"><i class="fa fa-times"></i></div><div class="map-popup-category">' + locationCategory + '</div><a href="' + locationURL + '" class="listing-img-content fl-wrap"><img src="' + locationImg + '" alt=""></a> <div class="listing-content fl-wrap"><div class="card-popup-raining map-card-rainting" data-staRrating="' + locationStarRating + '"><span class="map-popup-reviews-count">( ' + locationRevievsCounter + ' reviews )</span></div><div class="listing-title fl-wrap"><h4><a href=' + locationURL + '>' + locationTitle + '</a></h4><span class="map-popup-location-info"><i class="fa fa-map-marker"></i>' + locationAddress + '</span><span class="map-popup-location-phone"><i class="fa fa-phone"></i>' + locationPhone + '</span></div></div></div></div>')
            }

            for (i = 0; i < locations.length; i++) {
                var positionCurrent = locations[i].location;
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(positionCurrent.lat, positionCurrent.lng),
                    icon: markerIcon,
                    id: i
                });
                $boundsCurrent.extend(marker.position);
                $configManagerMap.markers.push(marker);
                var ib = new InfoBox();
                google.maps.event.addListener(ib, "domready", function () {
                    cardRaining();
                });
                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        var positionCurrentMarker = locations[i].location;
                        ib.setOptions(boxOptions);
                        boxText.innerHTML = locationData(locations[i]);
                        ib.close();
                        ib.open(map, marker);
                        currentInfobox = marker.id;
                        var latLng = new google.maps.LatLng(positionCurrentMarker.lat, positionCurrentMarker.lng);
                        map.panTo(latLng);
                        map.panBy(0, -180);
                        google.maps.event.addListener(ib, 'domready', function () {
                            $('.infoBox-close').click(function (e) {
                                e.preventDefault();
                                ib.close();
                            });
                        });
                    }
                })(marker, i));
            }
            var options = {
                imagePath: $resourceRoot + "images/cluster",
                styles: clusterStyles,
                minClusterSize: 2
            };


            var mcOptions = {

                //imagePath: pathDevelopers + "assets/images/cluster/",
                styles: [{
                    height: 53,
                    url: $resourceRoot + "images/cluster/1.png",
                    width: 53,
                    fontFamily: "comic sans ms",
                    textSize: 15,
                    textColor: "red",
                    //color: #00FF00,
                },
                    {
                        height: 56,
                        url: $resourceRoot + "images/cluster/2.png",
                        width: 56,
                        fontFamily: "comic sans ms",
                        textSize: 15,
                        textColor: "red",
                        color: "#00FF00",
                    },
                    {
                        height: 66,
                        url: $resourceRoot + "images/cluster/3.png",
                        width: 66
                    },
                    {
                        height: 78,
                        url: $resourceRoot + "images/cluster/4.png",
                        width: 78
                    },
                    {
                        height: 90,
                        url: $resourceRoot + "images/cluster/5.png",
                        width: 90
                    }]

            }

            markerCluster = new MarkerClusterer(map, $configManagerMap.markers, options);
            $configManagerMap.managerCluster = markerCluster;
            google.maps.event.addDomListener(window, "resize", function () {
                var center = map.getCenter();
                google.maps.event.trigger(map, "resize");
                map.setCenter(center);
            });
            var boxText = document.createElement("div");
            boxText.className = 'map-box'
            var currentInfobox;
            var boxOptions = {
                content: boxText,
                disableAutoPan: true,
                alignBottom: true,
                maxWidth: 0,
                pixelOffset: new google.maps.Size(-145, -45),
                zIndex: null,
                boxStyle: {
                    width: "260px"
                },
                closeBoxMargin: "0",
                closeBoxURL: "",
                infoBoxClearance: new google.maps.Size(1, 1),
                isHidden: false,
                pane: "floatPane",
                enableEventPropagation: false,
            };

            $('.nextmap-nav').click(function (e) {
                e.preventDefault();
                map.setZoom(15);
                var index = currentInfobox;
                if (index + 1 < $configManagerMap.markers.length) {
                    google.maps.event.trigger($configManagerMap.markers[index + 1], 'click');
                } else {
                    google.maps.event.trigger($configManagerMap.markers[0], 'click');
                }
            });
            $('.prevmap-nav').click(function (e) {
                e.preventDefault();
                map.setZoom(15);
                if (typeof (currentInfobox) == "undefined") {
                    google.maps.event.trigger($configManagerMap.markers[$configManagerMap.markers.length - 1], 'click');
                } else {
                    var index = currentInfobox;
                    if (index - 1 < 0) {
                        google.maps.event.trigger($configManagerMap.markers[$configManagerMap.markers.length - 1], 'click');
                    } else {
                        google.maps.event.trigger($configManagerMap.markers[index - 1], 'click');
                    }
                }
            });

            // Scroll enabling button
        }
    </script>


@endsection
@section('content')
    <div id="app-management">


        <div class="loading-page" v-if="managerLoading.page.view">
            <div class="listings-loader"><i class="fa fa-spinner fa-pulse fa-3x"></i></div>

        </div>
        <div class="data-page not-view manager-page__data-page">
            <!-- Map -->
            <div class="map-container column-map right-pos-map">
                <div class="loading-page manager-page__loading-map" v-if="managerLoading.map.view">
                    <div class="listings-loader"><i class="fa fa-spinner fa-pulse fa-3x"></i></div>

                </div>
                <div class="not-view manager-page_map">

                    <div id="map-main"></div>
                    <ul class="mapnavigation">
                        <li><a href="#" class="prevmap-nav">{{__('frontend.menu.search.pagination.prev')}}</a></li>
                        <li><a href="#" class="nextmap-nav">{{__('frontend.menu.search.pagination.next')}}</a></li>
                    </ul>
                    <div class="scrollContorl mapnavbtn" title="Enable Scrolling"><span><i
                                class="fa fa-lock"></i></span>
                    </div>
                </div>
            </div>
            <!-- Map end -->
            <!--col-list-wrap -->
            <div class="col-list-wrap left-list">
                <div class="listsearch-options fl-wrap" id="lisfw">
                    <div class="container">
                        <div class="listsearch-header fl-wrap">
                            <h3>{{__('frontend.menu.search.filters.title')}} <span> Tu busqueda</span></h3>
                            <div class="listing-view-layout">
                                <ul>
                                    <li><a class="grid active" href="#"><i class="fa fa-th-large"></i></a></li>
                                    <li><a class="list" href="#"><i class="fa fa-list-ul"></i></a></li>
                                    <li><a href="#" class="expand-listing-view"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- listsearch-input-wrap  -->
                        <div class="listsearch-input-wrap fl-wrap">
                            <div class="listsearch-input-text">
                                <label><i class="mbri-map-pin"></i> {{__('frontend.menu.search.filters.keywords')}}
                                </label>
                                <i class="mbri-key single-i"></i>
                                <input type="text" id="keywords"
                                       placeholder="{{__('frontend.menu.home.filters.keywords')}}"
                                       name="keywords"
                                       v-model.trim="model.attributes.keywords"/>
                            </div>

                            <div class="listsearch-input-text not-view" id="autocomplete-container">
                                <label><i class="mbri-map-pin"></i> {{__('frontend.menu.search.filters.location')}}
                                </label>
                                <input type="text"
                                       placeholder="{{__('frontend.menu.search.filters.location')}}  , Area , Street"
                                       id="autocomplete-input"
                                       class="qodef-archive-places-search" name="address-google"
                                       v-model.trim="model.attributes['address-google']" value=""/>
                                <a href="#" class="loc-act qodef-archive-current-location"><i
                                        class="fa fa-dot-circle-o"></i></a>
                            </div>
                            <!-- hidden-listing-filter -->
                            <div class="hidden-listing-filter fl-wrap">
                                <div class="row">
                                    <div class="col-md-12">
                                        <select
                                            v-init-select="{initMethod:initCategories}"
                                            id="initCategories"
                                            name="category"
                                            v-model.trim="model.attributes.category"
                                            data-placeholder="{{__('frontend.menu.search.filters.category')}} "
                                            class="">
                                        </select>
                                    </div>
                                </div>


                                <div class="distance-input fl-wrap not-view">
                                    <div class="distance-title"> Radius around selected destination <span></span> km
                                    </div>
                                    <div class="distance-radius-wrap fl-wrap">
                                        <input name="distance"
                                               v-model.trim="model.attributes.distance"
                                               class="distance-radius rangeslider--horizontal" type="range" min="1"
                                               max="100" step="1" value="1"
                                               v-on:change="_element"
                                               data-title="Radius around selected destination">
                                    </div>
                                </div>
                                <!-- Checkboxes -->
                                <div class=" fl-wrap filter-tags not-view">
                                    <h4>Filter by Tags</h4>
                                    <input v-on:change="_element" id="check-aa" type="checkbox" name="check"
                                           v-model.trim="model.attributes.check">
                                    <label for="check-aa">Elevator in building</label>
                                    <input v-on:change="_element" id="check-b" type="checkbox" name="check"
                                           v-model.trim="model.attributes.check">
                                    <label for="check-b">Friendly workspace</label>
                                    <input v-on:change="_element" id="check-c" type="checkbox" name="check"
                                           v-model.trim="model.attributes.check">
                                    <label for="check-c">Instant Book</label>
                                    <input v-on:change="_element" id="check-d" type="checkbox" name="check"
                                           v-model.trim="model.attributes.check">
                                    <label for="check-d">Wireless Internet</label>
                                </div>
                            </div>
                            <!-- hidden-listing-filter end -->
                            <button class="button fs-map-btn"
                                    v-on:click="getDataBusiness">{{__('frontend.menu.search.filters.button')}}</button>
                            <div class="more-filter-option">{{__('frontend.menu.search.filters.more-filters')}}
                                <span>

                                </span>
                            </div>
                        </div>
                        <!-- listsearch-input-wrap end -->
                    </div>
                </div>
                <!-- list-main-wrap-->
                <div class="list-main-wrap fl-wrap card-listing">
                    <a class="custom-scroll-link back-to-filters btf-l" href="#lisfw"><i
                            class="fa fa-angle-double-up"></i><span>{{__('frontend.menu.search.filters.button.back')}}</span></a>

                    <!-- end col-md-8 -->
                    <div class="listings-loader" v-if="managerLoading.data.view"><i
                            class="fa fa-spinner fa-pulse fa-3x"></i></div>

                    <div class="container" id="listing-items"
                         v-if="!managerLoading.data.view && !configGridAdmin.isEmpty"
                         v-init-listing-items="{initMethod:_managerDataItemsMap}"
                         v-html="configGridAdmin.html"
                    >
                    </div>
                    <div class="class" v-if="!managerLoading.data.view && configGridAdmin.isEmpty"
                         v-html="configGridAdmin.msj.empty">

                    </div>
                    <div class="listings-pagination-wrap" v-if="!managerLoading.data.view && !configGridAdmin.isEmpty">
                        <span class="section-separator"></span>
                        <div class="row">
                            <div class="col-sm-6">
                                <paginate
                                    :page-count="configPagination.totalPages"
                                    :page-range="3"
                                    :initial-page="configPagination.initialPage"
                                    :margin-pages="2"
                                    :click-handler="_pageCurrent"
                                    :prev-text="'Prev'"
                                    :next-text="'Next'"
                                    :container-class="'pagination pagination--custom'"
                                    :page-class="'page-item'">
                                </paginate>
                            </div>
                            <div class="col-sm-6 infoBar">

                                <div class="infos">Mostrando <?php echo '{{configPagination.view.init}}'?>
                                    - <?php echo '{{configPagination.view.to}}'?>
                                    de <?php echo '{{configPagination.totalData}}'?> </div>
                            </div>
                        </div>


                    </div>

                </div>
                <!-- list-main-wrap end-->

            </div>
            <!--col-list-wrap -->
            <div class="limit-box fl-wrap"></div>
            <!--section -->
            @if(!Auth::check())
                @include('layouts.partials.cityBook.join')

            @endif
        </div>
    </div>
    <input id="action-business-searchBusinessBee" type="hidden"
           value="{{ route("searchBusinessBee",app()->getLocale()) }}"/>
@endsection
