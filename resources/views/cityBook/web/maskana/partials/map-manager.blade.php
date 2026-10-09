<script>


    class BusinessMapHtmlUtil {


        static renderSchedules(schedules = []) {
            const weekdays = [
                'Lunes',
                'Martes',
                'Miércoles',
                'Jueves',
                'Viernes',
                'Sábado',
                'Domingo'
            ];
            const normalizeDay = value =>
                String(value || '')
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .toLowerCase();

            const formatTime = value => {
                const time = typeof value === 'object'
                    ? value?.modelBreakdown
                    : value;

                return typeof time === 'string' &&
                /^\d{2}:\d{2}/.test(time)
                    ? time.slice(0, 5)
                    : null;
            };

            if (!Array.isArray(schedules) || !schedules.length) {
                return `
            <p class="business-detail__empty">
                Horarios no registrados.
            </p>
        `;
            }

            const byDay = new Map(
                schedules.map(schedule => [
                    normalizeDay(schedule.text),
                    schedule
                ])
            );

            return `
        <div class="business-detail__schedules">

            ${weekdays.map(day => {

                const schedule = byDay.get(
                    normalizeDay(day)
                );

                if (!schedule) {
                    return `
                        <div class="business-detail__schedule">
                            <span class="business-detail__schedule-day">
                                ${day}
                            </span>

                            <span class="business-detail__schedule-time business-detail__schedule-time--empty">
                                Sin información
                            </span>
                        </div>
                    `;
                }

                const periods = Array.isArray(
                    schedule.configTypeSchedule?.data
                )
                    ? schedule.configTypeSchedule.data
                    : [];

                const ranges = periods
                    .map(period => {

                        const from = formatTime(
                            period.start_time
                        );

                        const to = formatTime(
                            period.end_time
                        );

                        return from && to
                            ? `${from} – ${to}`
                            : null;
                    })
                    .filter(Boolean);

                const label = ranges.length
                    ? ranges.join(' / ')
                    : 'Horario no especificado';

                return `
                    <div class="business-detail__schedule">

                        <span class="business-detail__schedule-day">
                            ${day}
                        </span>

                        <span class="business-detail__schedule-time ${!ranges.length ? 'business-detail__schedule-time--empty' : ''}">
                            ${escapeHtml(label)}
                        </span>

                    </div>
                `;

            }).join('')}

        </div>
    `;
        }


        static renderGroup(businesses = [], options = {}) {

            if (!Array.isArray(businesses) || !businesses.length) {
                return `
            <div class="business-group__empty">
                No hay empresas disponibles.
            </div>
        `;
            }

            const fallbackImage = safeUrl(
                options.fallbackImage
            );

            const renderCard = business => {

                const image =
                    safeUrl(business.source) ||
                    fallbackImage;

                const name =
                    business.business_name ||
                    business.title ||
                    'Empresa';

                const category =
                    business.subcategory_name ||
                    'Empresa';

                const address = [
                    business.street_1,
                    business.street_2
                ]
                    .filter(value =>
                        value &&
                        value !== 'null'
                    )
                    .join(' y ');

                const rating =
                    business.getRatingSummaryForClientData;

                const stars = Number(
                    rating?.average_stars
                );

                const totalRatings = Number(
                    rating?.total_ratings || 0
                );

                const ratingText =
                    Number.isFinite(stars) &&
                    totalRatings > 0
                        ? `${stars.toFixed(2)} / 5 (${totalRatings})`
                        : 'Sin calificaciones';

                return `
            <button
                type="button"
                class="business-group__card"
                data-business-select="${escapeHtml(business.id)}"
            >

                <div class="business-group__card-image">

                    ${image
                    ? `
                            <img
                                src="${escapeHtml(image)}"
                                alt="${escapeHtml(name)}"
                                loading="lazy"
                                onerror="this.hidden=true;this.nextElementSibling.hidden=false;"
                            >

                            <span
                                class="business-group__card-fallback"
                                hidden
                            >
                                🏪
                            </span>
                        `
                    : `
                            <span class="business-group__card-fallback">
                                🏪
                            </span>
                        `
                }

                </div>

                <div class="business-group__card-content">

                    <span class="business-group__card-category">
                        ${escapeHtml(category)}
                    </span>

                    <h3 class="business-group__card-title">
                        ${escapeHtml(name)}
                    </h3>

                    <p class="business-group__card-address">
                        ${escapeHtml(
                    address || 'Dirección no registrada'
                )}
                    </p>

                    <span class="business-group__card-rating">
                        ★ ${escapeHtml(ratingText)}
                    </span>

                </div>

                <span
                    class="business-group__card-arrow"
                    aria-hidden="true"
                >
                    ›
                </span>

            </button>
        `;
            };

            return `
        <div class="business-group">

            <header class="business-group__header">

                <h2 class="business-group__title">
                    Empresas en esta ubicación
                </h2>

                <p class="business-group__subtitle">
                    ${businesses.length}
                    ${businesses.length === 1
                ? 'empresa encontrada'
                : 'empresas encontradas'
            }
                </p>

            </header>

            <div class="business-group__list">
                ${businesses.map(renderCard).join('')}
            </div>

        </div>
    `;
        }


        static renderDetails(business, options = {}) {

            if (!business) {
                return `
            <div class="business-detail__empty">
                No se encontró información de la empresa.
            </div>
        `;
            }

            const image =
                safeUrl(business.source) ||
                safeUrl(options.fallbackImage);

            const name =
                business.business_name ||
                business.title ||
                'Empresa';

            const category =
                business.subcategory_name ||
                'Empresa';

            const address = [
                business.street_1,
                business.street_2
            ]
                .filter(value =>
                    value &&
                    value !== 'null'
                )
                .join(' y ');

            const description =
                business.description ||
                'Sin descripción disponible.';

            const rating =
                business.getRatingSummaryForClientData;

            const stars = Number(
                rating?.average_stars
            );

            const totalRatings = Number(
                rating?.total_ratings || 0
            );

            const ratingText =
                Number.isFinite(stars) &&
                totalRatings > 0
                    ? `${stars.toFixed(2)} / 5 (${totalRatings} calificaciones)`
                    : 'Sin calificaciones';

            const website = safeUrl(
                business.page_url
            );

            const phone = String(
                business.phone_value || ''
            ).replace(/[^+\d]/g, '');

            const email = String(
                business.email || ''
            ).trim();

            const lat = Number(
                business.street_lat
            );

            const lng = Number(
                business.street_lng
            );

            const hasCoordinates =
                business.street_lat != null &&
                business.street_lat !== '' &&
                business.street_lng != null &&
                business.street_lng !== '' &&
                Number.isFinite(lat) &&
                Number.isFinite(lng) &&
                Math.abs(lat) <= 90 &&
                Math.abs(lng) <= 180;

            const mapsLink = hasCoordinates
                ? `https://www.openstreetmap.org/?mlat=${encodeURIComponent(lat)}&mlon=${encodeURIComponent(lng)}#map=17/${encodeURIComponent(lat)}/${encodeURIComponent(lng)}`
                : '';

            const socials = Object.entries(
                business.socialNetworksData || {}
            ).filter(([, url]) => safeUrl(url));

            const yapitas =
                business.summary?.yapitas?.currentBalance ?? 0;

            const visits =
                business.summary?.visits?.total ?? 0;

            const trophies =
                business.summary?.trophies?.total ?? 0;

            return `
        <article class="business-detail">

            <div class="business-detail__hero">

                ${image
                ? `
                        <img
                            class="business-detail__hero-image"
                            src="${escapeHtml(image)}"
                            alt="${escapeHtml(name)}"
                            onerror="this.hidden=true;this.nextElementSibling.hidden=false;"
                        >

                        <div
                            class="business-detail__hero-fallback"
                            hidden
                        >
                            🏪
                        </div>
                    `
                : `
                        <div class="business-detail__hero-fallback">
                            🏪
                        </div>
                    `
            }

            </div>

            <div class="business-detail__body">

                <header class="business-detail__header">

                    <span class="business-detail__category">
                        ${escapeHtml(category)}
                    </span>

                    <h2 class="business-detail__title">
                        ${escapeHtml(name)}
                    </h2>

                    <p class="business-detail__rating">
                        ★ ${escapeHtml(ratingText)}
                    </p>

                </header>

                <section class="business-detail__section">

                    <h3 class="business-detail__section-title">
                        Descripción
                    </h3>

                    <p class="business-detail__description">
                        ${escapeHtml(description)}
                    </p>

                </section>

                <section class="business-detail__section">

                    <h3 class="business-detail__section-title">
                        Dirección
                    </h3>

                    <p class="business-detail__address">
                        ${escapeHtml(
                address || 'Dirección no registrada'
            )}
                    </p>

                    <div class="business-detail__actions">

                        <button
                            type="button"
                            class="business-detail__button business-detail__button--primary"
                            data-business-action="center"
                        >
                            Ver en el mapa
                        </button>

                        ${mapsLink
                ? `
                                <a
                                    class="business-detail__button business-detail__button--outline"
                                    href="${escapeHtml(mapsLink)}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    Abrir en OSM
                                </a>
                            `
                : ''
            }

                    </div>

                </section>

                <section class="business-detail__section">

                    <h3 class="business-detail__section-title">
                        Contacto
                    </h3>

                    <div class="business-detail__contact">

                        ${phone
                ? `
                                <a
                                    class="business-detail__contact-link"
                                    href="tel:${escapeHtml(phone)}"
                                >
                                    ☎ ${escapeHtml(business.phone_value)}
                                </a>
                            `
                : ''
            }

                        ${email && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
                ? `
                                <a
                                    class="business-detail__contact-link"
                                    href="mailto:${escapeHtml(email)}"
                                >
                                    ✉ ${escapeHtml(email)}
                                </a>
                            `
                : ''
            }

                        ${website
                ? `
                                <a
                                    class="business-detail__contact-link"
                                    href="${escapeHtml(website)}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    🌐 Sitio web
                                </a>
                            `
                : ''
            }

                        ${!phone && !email && !website
                ? `
                                <p class="business-detail__empty">
                                    Contacto no registrado.
                                </p>
                            `
                : ''
            }

                    </div>

                </section>

                ${socials.length
                ? `
                        <section class="business-detail__section">

                            <h3 class="business-detail__section-title">
                                Redes sociales
                            </h3>

                            <div class="business-detail__socials">

                                ${socials.map(([socialName, url]) => `
                                    <a
                                        class="business-detail__social-link"
                                        href="${escapeHtml(safeUrl(url))}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        ${escapeHtml(socialName)}
                                    </a>
                                `).join('')}

                            </div>

                        </section>
                    `
                : ''
            }

                <section class="business-detail__section">

                    <h3 class="business-detail__section-title">
                        Horarios de atención
                    </h3>

                    ${this.renderSchedules(
                business.schedules
            )}

                </section>

                <section class="business-detail__section">

                    <h3 class="business-detail__section-title">
                        Comunidad
                    </h3>

                    <div class="business-detail__community">

                        <div class="business-detail__community-item">
                            <strong class="business-detail__community-value">
                                ${escapeHtml(yapitas)}
                            </strong>

                            <span class="business-detail__community-label">
                                Yapitas
                            </span>
                        </div>

                        <div class="business-detail__community-item">
                            <strong class="business-detail__community-value">
                                ${escapeHtml(visits)}
                            </strong>

                            <span class="business-detail__community-label">
                                Visitas
                            </span>
                        </div>

                        <div class="business-detail__community-item">
                            <strong class="business-detail__community-value">
                                ${escapeHtml(trophies)}
                            </strong>

                            <span class="business-detail__community-label">
                                Trofeos
                            </span>
                        </div>

                    </div>

                </section>

            </div>

        </article>
    `;
        }

        static getIconBusinessHtml(business, count = 1) {
            const url = safeUrl(business.source);
            const isGrouped = count > 1;
            const photo = url
                ? `
                <img
                    class="business-map-marker__image"
                    src="${escapeHtml(url)}"
                    alt=""
                    loading="lazy"
                    draggable="false"
                    onerror="this.hidden=true;this.nextElementSibling.hidden=false;"
                >
                <span
                    class="business-map-marker__fallback"
                    hidden
                    aria-hidden="true"
                >
                    🏪
                </span>
              `
                : `
                <span
                    class="business-map-marker__fallback"
                    aria-hidden="true"
                >
                    🏪
                </span>
              `;

            return `
            <div
                class="business-map-marker ${isGrouped ? 'business-map-marker--grouped' : ''}"
            >
                ${photo}

                ${isGrouped ? `
                    <span class="business-map-marker__count">
                        ${count}
                    </span>
                ` : ''}
            </div>
        `;
        }
    }
    window.BusinessMapHtmlUtil = BusinessMapHtmlUtil;
    const escapeHtml = (value) =>
        String(value ?? '').replace(/[&<>"']/g, c => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        }[c]));
    const safeUrl = (value) => {
        if (!value || value === 'null') return '';

        try {
            const url = new URL(String(value), document.baseURI);
            return ['http:', 'https:'].includes(url.protocol)
                ? url.href
                : '';
        } catch (_) {
            return '';
        }
    };

    /**
     * BusinessMapController
     * Leaflet 1.9.x + Bootstrap 5
     *
     * Muestra empresas de la API Laravel en un mapa.
     * No utiliza popups de Leaflet.
     */

    function getIconBusiness(business, count = 1) {

        const size = 56;

        const html = BusinessMapHtmlUtil.getIconBusinessHtml(
            business,
            count
        );

        return L.divIcon({
            html: html,

            className: 'business-map-marker-container',

            iconSize: [size, size],

            // Centro inferior del marcador
            iconAnchor: [size / 2, size]
        });
    }



    (function (global) {
        'use strict';

        const numberOrNull = value => {
            if (value === '' || value == null) {
                return null;
            }

            const number = Number(value);

            return Number.isFinite(number)
                ? number
                : null;
        };

        class BusinessMapController {

            constructor(config = {}) {

                this.config = {
                    containerId: 'business-map',

                    detailAsideId: 'businessDetailAside',
                    groupAsideId: 'businessGroupAside',

                    position: [0.2343, -78.2625],
                    zoom: 13,
                    focusZoom: 17,
                    maxZoom: 19,

                    tileUrl:
                        'https://tile.openstreetmap.org/{z}/{x}/{y}.png',

                    tileAttribution:
                        '&copy; OpenStreetMap contributors',

                    fitOnRender: true,
                    openDetailsOnClick: true,
                    fallbackImage: '',
                    markerSize: 56,

                    ...config
                };

                this.map = null;
                this.markerLayer = null;

                this.businesses = new Map();
                this.markers = new Map();
                this.groups = new Map();

                this.detailAside = null;
                this.groupAside = null;

                this.selectedBusiness = null;

                this.listeners = new Map();

                this._asideClickHandler = event => {
                    this._onAsideClick(event);
                };

                this._mapMoveHandler = () => {
                    if (!this.map) return;

                    this.emit('map:moveend', {
                        center: this.map.getCenter(),
                        zoom: this.map.getZoom(),
                        bounds: this.map.getBounds()
                    });
                };

                this._mapZoomHandler = () => {
                    if (!this.map) return;

                    this.emit('map:zoomend', {
                        zoom: this.map.getZoom()
                    });
                };
            }

            // ============================================
            // EVENT MANAGEMENT
            // ============================================

            on(event, callback) {

                if (typeof callback !== 'function') {
                    return () => {};
                }

                if (!this.listeners.has(event)) {
                    this.listeners.set(event, new Set());
                }

                this.listeners.get(event).add(callback);

                return () => this.off(event, callback);
            }

            off(event, callback) {
                this.listeners.get(event)?.delete(callback);
            }

            emit(event, detail = {}) {

                this.listeners.get(event)?.forEach(callback => {
                    try {
                        callback(detail);
                    } catch (error) {
                        console.error(error);
                    }
                });

                this.listeners.get('*')?.forEach(callback => {
                    try {
                        callback({
                            event,
                            ...detail
                        });
                    } catch (error) {
                        console.error(error);
                    }
                });

                document.dispatchEvent(
                    new CustomEvent(`business-map:${event}`, {
                        detail
                    })
                );
            }

            // ============================================
            // MAP INITIALIZATION
            // ============================================

            init(data = []) {

                if (!global.L) {
                    throw new Error(
                        'Leaflet no está cargado.'
                    );
                }

                if (!global.BusinessMapHtmlUtil) {
                    throw new Error(
                        'BusinessMapHtmlUtil no está cargado.'
                    );
                }

                if (this.map) {
                    throw new Error(
                        'El mapa ya fue inicializado. Usa setBusinesses().'
                    );
                }

                const mapElement = document.getElementById(
                    this.config.containerId
                );

                const detailAside = document.getElementById(
                    this.config.detailAsideId
                );

                const groupAside = document.getElementById(
                    this.config.groupAsideId
                );

                if (!mapElement) {
                    throw new Error(
                        'No se encontró el contenedor del mapa.'
                    );
                }

                if (!detailAside || !groupAside) {
                    throw new Error(
                        'No se encontraron los dos paneles aside.'
                    );
                }

                if (
                    !detailAside.querySelector(
                        '[data-business-detail-content]'
                    ) ||
                    !groupAside.querySelector(
                        '[data-business-group-content]'
                    )
                ) {
                    throw new Error(
                        'Faltan los contenedores de contenido de los asides.'
                    );
                }

                this.detailAside = detailAside;
                this.groupAside = groupAside;

                [this.detailAside, this.groupAside].forEach(aside => {

                    aside.classList.remove(
                        'business-map-aside--open'
                    );

                    aside.setAttribute(
                        'aria-hidden',
                        'true'
                    );

                    aside.inert = true;

                    aside.addEventListener(
                        'click',
                        this._asideClickHandler
                    );
                });

                this.map = L.map(mapElement, {
                    zoomControl: true
                }).setView(
                    this.config.position,
                    this.config.zoom
                );

                L.tileLayer(this.config.tileUrl, {
                    maxZoom: this.config.maxZoom,
                    attribution: this.config.tileAttribution
                }).addTo(this.map);

                this.markerLayer = L.layerGroup()
                    .addTo(this.map);

                this.map.on(
                    'moveend',
                    this._mapMoveHandler
                );

                this.map.on(
                    'zoomend',
                    this._mapZoomHandler
                );

                this.setBusinesses(data);

                this.emit('map:init', {
                    map: this.map,
                    count: this.businesses.size
                });

                requestAnimationFrame(() => {
                    this.map?.invalidateSize();
                });

                return this;
            }

            // ============================================
            // BUSINESS MARKERS
            // ============================================

            setBusinesses(input = []) {

                const list = Array.isArray(input)
                    ? input
                    : (
                        Array.isArray(input?.data)
                            ? input.data
                            : []
                    );

                this.closeAsides();

                this.businesses.clear();
                this.groups.clear();
                this.markers.clear();

                this.markerLayer?.clearLayers();

                for (const business of list) {

                    if (!business || business.id == null) {
                        continue;
                    }

                    this.businesses.set(
                        String(business.id),
                        business
                    );

                    const lat = numberOrNull(
                        business.street_lat
                    );

                    const lng = numberOrNull(
                        business.street_lng
                    );

                    if (
                        lat === null ||
                        lng === null ||
                        Math.abs(lat) > 90 ||
                        Math.abs(lng) > 180
                    ) {
                        continue;
                    }

                    const key =
                        `${lat.toFixed(6)},${lng.toFixed(6)}`;

                    if (!this.groups.has(key)) {
                        this.groups.set(key, {
                            lat,
                            lng,
                            businesses: []
                        });
                    }

                    this.groups.get(key)
                        .businesses.push(business);
                }

                const bounds = [];

                for (const group of this.groups.values()) {

                    const business = group.businesses[0];

                    const count = group.businesses.length;

                    const marker = L.marker(
                        [group.lat, group.lng],
                        {
                            icon: this._icon(
                                business,
                                count
                            ),

                            title: count > 1
                                ? `${count} empresas`
                                : (
                                    business.business_name ||
                                    business.title ||
                                    'Empresa'
                                )
                        }
                    );

                    marker.on('click', () => {

                        this.emit('marker:click', {
                            marker,
                            businesses: group.businesses,
                            business: count === 1
                                ? business
                                : null
                        });

                        if (count === 1) {

                            this.selectBusiness(
                                business.id,
                                {
                                    openDetails:
                                    this.config.openDetailsOnClick,
                                    fly: false
                                }
                            );

                        } else {

                            this.openGroup(
                                group.businesses
                            );
                        }
                    });

                    marker.addTo(this.markerLayer);

                    group.businesses.forEach(item => {
                        this.markers.set(
                            String(item.id),
                            marker
                        );
                    });

                    bounds.push([
                        group.lat,
                        group.lng
                    ]);
                }

                if (
                    this.map &&
                    bounds.length &&
                    this.config.fitOnRender
                ) {

                    if (bounds.length === 1) {

                        this.map.setView(
                            bounds[0],
                            this.config.zoom
                        );

                    } else {

                        this.map.fitBounds(bounds, {
                            padding: [35, 35],
                            maxZoom: this.config.focusZoom
                        });
                    }
                }

                this.emit('businesses:rendered', {
                    total: this.businesses.size,
                    locations: this.groups.size
                });

                return this;
            }

            // ============================================
            // MARKER ICON
            // ============================================

            _icon(business, count = 1) {

                const size = this.config.markerSize;

                const html =
                    BusinessMapHtmlUtil.getIconBusinessHtml(
                        business,
                        count,
                        {
                            fallbackImage:
                            this.config.fallbackImage
                        }
                    );

                return L.divIcon({
                    html,
                    className:
                        'business-map-marker-container',

                    iconSize: [
                        size,
                        size
                    ],

                    iconAnchor: [
                        size / 2,
                        size
                    ]
                });
            }

            // ============================================
            // BUSINESS SELECTION
            // ============================================

            getBusiness(id) {

                return this.businesses.get(
                    String(id)
                ) || null;
            }

            selectBusiness(
                id,
                {
                    openDetails = true,
                    fly = true,
                    zoom = this.config.focusZoom
                } = {}
            ) {

                const business = this.getBusiness(id);

                if (!business) {
                    return false;
                }

                const marker = this.markers.get(
                    String(id)
                );

                this.selectedBusiness = business;

                if (fly && marker && this.map) {

                    this.map.flyTo(
                        marker.getLatLng(),

                        Math.min(
                            zoom,
                            this.config.maxZoom
                        ),

                        {
                            duration: 0.6
                        }
                    );
                }

                this.emit('business:selected', {
                    business,
                    marker
                });

                if (openDetails) {
                    return this.openDetails(id);
                }

                return true;
            }

            flyTo(
                id,
                zoom = this.config.focusZoom
            ) {

                return this.selectBusiness(id, {
                    openDetails: false,
                    fly: true,
                    zoom
                });
            }

            // ============================================
            // ASIDE MANAGEMENT
            // ============================================

            _setAsideState(aside, isOpen) {

                if (!aside) {
                    return;
                }

                aside.classList.toggle(
                    'business-map-aside--open',
                    isOpen
                );

                aside.setAttribute(
                    'aria-hidden',
                    String(!isOpen)
                );

                aside.inert = !isOpen;
            }

            openDetails(id) {

                const business = this.getBusiness(id);

                if (!business || !this.detailAside) {
                    return false;
                }

                const content = this.detailAside.querySelector(
                    '[data-business-detail-content]'
                );

                if (!content) {
                    return false;
                }

                if (
                    typeof BusinessMapHtmlUtil.renderDetails !==
                    'function'
                ) {
                    throw new Error(
                        'Falta BusinessMapHtmlUtil.renderDetails().'
                    );
                }

                content.innerHTML =
                    BusinessMapHtmlUtil.renderDetails(
                        business,
                        {
                            fallbackImage:
                            this.config.fallbackImage
                        }
                    );

                this.selectedBusiness = business;

                this._setAsideState(
                    this.groupAside,
                    false
                );

                this._setAsideState(
                    this.detailAside,
                    true
                );

                content.scrollTop = 0;

                this.emit('business:details:open', {
                    business
                });

                return true;
            }

            openGroup(businesses) {

                if (
                    !this.groupAside ||
                    !Array.isArray(businesses) ||
                    businesses.length === 0
                ) {
                    return false;
                }

                const content = this.groupAside.querySelector(
                    '[data-business-group-content]'
                );

                if (!content) {
                    return false;
                }

                if (
                    typeof BusinessMapHtmlUtil.renderGroup !==
                    'function'
                ) {
                    throw new Error(
                        'Falta BusinessMapHtmlUtil.renderGroup().'
                    );
                }

                content.innerHTML =
                    BusinessMapHtmlUtil.renderGroup(
                        businesses,
                        {
                            fallbackImage:
                            this.config.fallbackImage
                        }
                    );

                const previousBusiness =
                    this.selectedBusiness;

                this.selectedBusiness = null;

                this._setAsideState(
                    this.detailAside,
                    false
                );

                this._setAsideState(
                    this.groupAside,
                    true
                );

                content.scrollTop = 0;

                if (previousBusiness) {
                    this.emit('business:details:close', {
                        business: previousBusiness
                    });
                }

                this.emit('marker:group', {
                    businesses
                });

                return true;
            }

            closeAsides() {

                const previousBusiness =
                    this.selectedBusiness;

                const wasDetailOpen =
                    this.detailAside?.classList.contains(
                        'business-map-aside--open'
                    ) || false;

                this._setAsideState(
                    this.detailAside,
                    false
                );

                this._setAsideState(
                    this.groupAside,
                    false
                );

                this.selectedBusiness = null;

                if (wasDetailOpen) {

                    this.emit('business:details:close', {
                        business: previousBusiness
                    });
                }

                return this;
            }

            // ============================================
            // ASIDE EVENTS
            // ============================================

            _onAsideClick(event) {

                const target = event.target;

                if (!(target instanceof Element)) {
                    return;
                }

                const closeButton = target.closest(
                    '[data-business-aside-close]'
                );

                if (closeButton) {

                    this.closeAsides();

                    return;
                }

                const selected = target.closest(
                    '[data-business-select]'
                );

                if (selected) {

                    const businessId =
                        selected.dataset.businessSelect;

                    this.selectBusiness(
                        businessId,
                        {
                            openDetails: true,
                            fly: false
                        }
                    );

                    return;
                }

                const action = target.closest(
                    '[data-business-action]'
                );

                if (!action) {
                    return;
                }

                const business =
                    this.selectedBusiness;

                if (!business) {
                    return;
                }

                const actionName =
                    action.dataset.businessAction;

                this.emit(
                    `business:action:${actionName}`,
                    {
                        business
                    }
                );

                if (actionName === 'center') {

                    const businessId = business.id;

                    this.closeAsides();

                    this.flyTo(businessId);
                }
            }

            // ============================================
            // HTML UTIL COMPATIBILITY
            // ============================================

            _schedulesHtml(schedules) {

                return BusinessMapHtmlUtil.renderSchedules(
                    schedules
                );
            }

            _detailsHtml(business) {

                return BusinessMapHtmlUtil.renderDetails(
                    business,
                    {
                        fallbackImage:
                        this.config.fallbackImage
                    }
                );
            }

            // ============================================
            // MAP UTILITIES
            // ============================================

            invalidateSize() {

                this.map?.invalidateSize();

                return this;
            }

            // ============================================
            // DESTROY
            // ============================================

            destroy() {

                this.closeAsides();

                [this.detailAside, this.groupAside].forEach(
                    aside => {

                        if (!aside) {
                            return;
                        }

                        aside.removeEventListener(
                            'click',
                            this._asideClickHandler
                        );

                        aside.classList.remove(
                            'business-map-aside--open'
                        );

                        aside.setAttribute(
                            'aria-hidden',
                            'true'
                        );

                        aside.inert = true;
                    }
                );

                if (this.map) {

                    this.map.off(
                        'moveend',
                        this._mapMoveHandler
                    );

                    this.map.off(
                        'zoomend',
                        this._mapZoomHandler
                    );

                    this.map.remove();
                }

                this.map = null;
                this.markerLayer = null;

                this.detailAside = null;
                this.groupAside = null;

                this.selectedBusiness = null;

                this.businesses.clear();
                this.groups.clear();
                this.markers.clear();
                this.listeners.clear();

                return this;
            }
        }

        global.BusinessMapController =
            BusinessMapController;

    })(window);


</script>
