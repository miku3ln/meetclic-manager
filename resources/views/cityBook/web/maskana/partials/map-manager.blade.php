<script>


    class BusinessMapHtmlUtil {
        static getBusinessNewsBadge(business) {

            const newsTypes = {
                discount: {
                    icon: 'bi-percent',
                    color: '#e11d48',
                    title: 'Descuento disponible'
                },
                promotion: {
                    icon: 'bi-gift-fill',
                    color: '#8b24dc',
                    title: 'Promoción disponible'
                },
                event: {
                    icon: 'bi-stars',
                    color: '#f59e0b',
                    title: 'Evento disponible'
                }
            };

            const news = newsTypes[business.demoNewsType];

            if (!news) return '';

            return `
        <span
            class="business-map-marker__news"
            title="${news.title}"
            style="
                position:absolute;
                top:-9px;
                right:-9px;
                width:28px;
                height:28px;
                border-radius:50%;
                background:${news.color};
                border:3px solid #fff;
                display:flex;
                align-items:center;
                justify-content:center;
                color:#fff;
                font-size:13px;
                box-shadow:0 3px 10px rgba(0,0,0,.3);
                z-index:10;
                pointer-events:none;
                box-sizing:border-box;
            "
        >
            <i class="bi ${news.icon}"></i>
        </span>
    `;
        }
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

        static renderPromotionCard(promotion, index = 0) {
            const name = promotion.name || 'Promoción';
            const description = promotion.description || '';
            const image = safeUrl(promotion.source);

            const status = String(promotion.status || '').toUpperCase();
            const isActive = status === 'ACTIVE';

            const statusText = isActive ? 'Vigente' : 'No vigente';

            const formatDate = (value) => {
                if (!value) return '';

                const date = new Date(
                    String(value).replace(' ', 'T')
                );

                if (Number.isNaN(date.getTime())) {
                    return '';
                }

                return date.toLocaleDateString('es-EC', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            };

            const startDate = formatDate(promotion.start_time);
            const endDate = formatDate(promotion.en_time);

            const dateText = startDate && endDate
                ? `${startDate} - ${endDate}`
                : startDate || endDate;

            return `
        <article class="business-detail__promotion">

            <button
                type="button"
                class="business-detail__promotion-action"
                data-promotion-open
                data-promotion-image="${escapeHtml(image || '')}"
                data-promotion-name="${escapeHtml(name)}"
                data-promotion-description="${escapeHtml(description)}"
                aria-label="Ver promoción ${escapeHtml(name)}"
            >
                <span class="business-detail__promotion-image-wrap">
                    ${image ? `
                        <img
                            class="business-detail__promotion-image"
                            src="${escapeHtml(image)}"
                            alt="${escapeHtml(name)}"
                            loading="lazy"
                        >
                    ` : `
                        <span class="business-detail__promotion-placeholder">
                            <i class="bi bi-image"></i>
                        </span>
                    `}
                </span>

                <span class="business-detail__promotion-content">
                    <strong class="business-detail__promotion-name">
                        ${escapeHtml(name)}
                    </strong>

                    ${description ? `
                        <span class="business-detail__promotion-description">
                            ${escapeHtml(description)}
                        </span>
                    ` : ''}

                    <span class="business-detail__promotion-status
                        ${isActive
                ? 'business-detail__promotion-status--active'
                : 'business-detail__promotion-status--inactive'
            }"
                    >
                        <i class="bi bi-circle-fill"></i>
                        ${statusText}
                    </span>

                    ${dateText ? `
                        <span class="business-detail__promotion-date">
                            <i class="bi bi-calendar3"></i>
                            ${escapeHtml(dateText)}
                        </span>
                    ` : ''}
                </span>

                <span class="business-detail__promotion-arrow">
                    <i class="bi bi-chevron-right"></i>
                </span>
            </button>

        </article>
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

            const image = safeUrl(business.source)
                || safeUrl(options.fallbackImage);

            const name = business.business_name
                || business.title
                || 'Empresa';

            const category = business.subcategory_name || 'Empresa';
            const description = business.description || 'Sin descripción disponible.';

            const rating = business.getRatingSummaryForClientData;
            const stars = Number(rating?.average_stars);
            const totalRatings = Number(rating?.total_ratings || 0);

            const ratingText = Number.isFinite(stars) && totalRatings > 0
                ? `${stars.toFixed(2)} / 5 (${totalRatings} calificaciones)`
                : 'Sin calificaciones';

            const phone = String(business.phone_value || '')
                .replace(/[^+\d]/g, '');

            const email = String(business.email || '').trim();
            const validEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            const website = safeUrl(business.page_url);

            const whatsappNumber = phone.replace(/\D/g, '');

            const address = [business.street_1, business.street_2]
                .filter(value => value && value !== 'null')
                .join(' y ');

            const lat = Number(business.street_lat);
            const lng = Number(business.street_lng);

            const hasCoordinates =
                business.street_lat != null &&
                business.street_lat !== '' &&
                business.street_lng != null &&
                business.street_lng !== '' &&
                Number.isFinite(lat) &&
                Number.isFinite(lng) &&
                Math.abs(lat) <= 90 &&
                Math.abs(lng) <= 180;

            const promotions = Array.isArray(business.promotions)
                ? business.promotions.filter(item => item && typeof item === 'object')
                : [];

            // Preparado para cuando el backend incorpore publicidad.
            const advertisements = Array.isArray(business.advertisements)
                ? business.advertisements.filter(item => item && typeof item === 'object')
                : [];

            const yapitas = business.summary?.yapitas?.currentBalance ?? 0;
            const visits = business.summary?.visits?.total ?? 0;
            const trophies = business.summary?.trophies?.total ?? 0;

            const socials = Object.entries(business.socialNetworksData || {})
                .filter(([, url]) => safeUrl(url));

            const contactItem = (url, icon, label, modifier, external = false) => {
                if (!url) return '';

                return `
            <a
                class="business-detail__contact-item business-detail__contact-item--${modifier}"
                href="${escapeHtml(url)}"
                ${external ? 'target="_blank" rel="noopener noreferrer"' : ''}
                aria-label="${escapeHtml(label)}"
            >
                <span class="business-detail__contact-icon">
                    <i class="bi ${icon}" aria-hidden="true"></i>
                </span>
                <span class="business-detail__contact-label">
                    ${escapeHtml(label)}
                </span>
            </a>
        `;
            };

            const tabButton = (key, label, icon, active = false) => `
        <button
            type="button"
            class="business-detail__tab ${active ? 'business-detail__tab--active' : ''}"
            data-business-tab="${key}"
            role="tab"
            aria-selected="${active}"
        >
            <i class="bi ${icon}" aria-hidden="true"></i>
            <span>${label}</span>
        </button>
    `;

            return `
        <article
            class="business-detail"
            data-business-id="${escapeHtml(business.id ?? '')}"
        >
            <!-- HERO -->
            <div class="business-detail__hero">
                ${image ? `
                    <img
                        class="business-detail__hero-image"
                        src="${escapeHtml(image)}"
                        alt="${escapeHtml(name)}"
                        loading="lazy"
                        onerror="this.hidden=true;this.nextElementSibling.hidden=false;"
                    >
                    <div class="business-detail__hero-fallback" hidden>
                        <i class="bi bi-shop"></i>
                    </div>
                ` : `
                    <div class="business-detail__hero-fallback">
                        <i class="bi bi-shop"></i>
                    </div>
                `}
            </div>

            <div class="business-detail__body">

                <!-- IDENTIDAD -->
                <header class="business-detail__header">
                    <span class="business-detail__category">
                        ${escapeHtml(category)}
                    </span>

                    <h2 class="business-detail__title">
                        ${escapeHtml(name)}
                    </h2>

                    <p class="business-detail__rating">
                        <i class="bi bi-star-fill"></i>
                        ${escapeHtml(ratingText)}
                    </p>
                </header>

                <!-- CONTACTOS -->
                <nav
                    class="business-detail__contacts"
                    aria-label="Contactar a la empresa"
                >
                    ${contactItem(
                whatsappNumber ? `https://wa.me/${whatsappNumber}` : '',
                'bi-whatsapp',
                'WhatsApp',
                'whatsapp',
                true
            )}

                    ${contactItem(
                phone ? `tel:${phone}` : '',
                'bi-telephone-fill',
                'Llamar',
                'phone'
            )}

                    ${contactItem(
                validEmail ? `mailto:${email}` : '',
                'bi-envelope',
                'Email',
                'email'
            )}

                    ${contactItem(
                website || '',
                'bi-globe',
                'Sitio web',
                'website',
                true
            )}
                </nav>

                <!-- DIRECCIÓN -->
                <section class="business-detail__location">
                    <div class="business-detail__location-info">
                        <i class="bi bi-geo-alt-fill business-detail__location-icon"></i>

                        <div class="business-detail__location-text">
                            <h3>Dirección</h3>
                            <p>
                                ${escapeHtml(address || 'Dirección no registrada')}
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        class="business-detail__map-button"
                        data-business-action="center"
                        ${!hasCoordinates ? 'disabled' : ''}
                    >
                        <i class="bi bi-map"></i>
                        <span>Ver en el mapa</span>
                    </button>
                </section>

                <!-- PESTAÑAS -->
                <nav
                    class="business-detail__tabs"
                    role="tablist"
                    aria-label="Secciones de la empresa"
                >
                    ${tabButton(
                'information',
                'Información',
                'bi-file-text',
                true
            )}

                    ${promotions.length > 0
                ? tabButton(
                    'promotions',
                    'Promociones',
                    'bi-tag'
                )
                : ''
            }

                    ${advertisements.length > 0
                ? tabButton(
                    'advertisements',
                    'Publicidad',
                    'bi-megaphone'
                )
                : ''
            }

                    ${tabButton(
                'schedules',
                'Horarios',
                'bi-clock'
            )}
                </nav>

                <!-- PANEL INFORMACIÓN -->
                <div
                    class="business-detail__panel business-detail__panel--active"
                    data-business-panel="information"
                    role="tabpanel"
                >
                    <section class="business-detail__card">
                        <div class="business-detail__card-icon">
                            <i class="bi bi-file-text"></i>
                        </div>

                        <div class="business-detail__card-content">
                            <h3>Descripción</h3>
                            <p>${escapeHtml(description)}</p>
                        </div>
                    </section>

                    ${socials.length ? `
                        <section class="business-detail__card">
                            <div class="business-detail__card-icon">
                                <i class="bi bi-share"></i>
                            </div>
                            <div class="business-detail__card-content">
                                <h3>Redes sociales</h3>

                                <div class="business-detail__socials">
                                    ${socials.map(([socialName, url]) => `
                                        <a
                                            class="business-detail__social-link"
                                            href="${escapeHtml(safeUrl(url))}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            ${escapeHtml(socialName)}
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    `).join('')}
                                </div>
                            </div>
                        </section>
                    ` : ''}

                    <!-- COMUNIDAD -->
                    <section class="business-detail__community-card">
                        <h3 class="business-detail__community-title">
                            <i class="bi bi-people-fill"></i>
                            Comunidad
                        </h3>

                        <div class="business-detail__community">
                            <div class="business-detail__community-item">
                                <i class="bi bi-heart business-detail__community-icon--heart"></i>
                                <div>
                                    <strong>${escapeHtml(yapitas)}</strong>
                                    <span>Yapitas</span>
                                </div>
                            </div>

                            <div class="business-detail__community-item">
                                <i class="bi bi-eye-fill business-detail__community-icon--eye"></i>
                                <div>
                                    <strong>${escapeHtml(visits)}</strong>
                                    <span>Visitas</span>
                                </div>
                            </div>

                            <div class="business-detail__community-item">
                                <i class="bi bi-trophy-fill business-detail__community-icon--trophy"></i>
                                <div>
                                    <strong>${escapeHtml(trophies)}</strong>
                                    <span>Trofeos</span>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- PANEL PROMOCIONES -->
                ${promotions.length > 0 ? `
                    <div
                        class="business-detail__panel"
                        data-business-panel="promotions"
                        role="tabpanel"
                        hidden
                    >
                        <header class="business-detail__panel-header">
                            <h3>Promociones de la empresa</h3>
                            <p>Descuentos y beneficios disponibles</p>
                        </header>

                        <div class="business-detail__promotions">
                            ${promotions.map((promotion, index) =>
                this.renderPromotionCard(promotion, index)
            ).join('')}
                        </div>
                    </div>
                ` : ''}

                <!-- PANEL PUBLICIDAD -->
                ${advertisements.length > 0 ? `
                    <div
                        class="business-detail__panel"
                        data-business-panel="advertisements"
                        role="tabpanel"
                        hidden
                    >
                        <header class="business-detail__panel-header">
                            <h3>Publicidad de la empresa</h3>
                            <p>Novedades, campañas y anuncios</p>
                        </header>

                        <div class="business-detail__promotions">
                            ${advertisements.map((ad, index) =>
                this.renderPromotionCard(ad, index)
            ).join('')}
                        </div>
                    </div>
                ` : ''}

                <!-- PANEL HORARIOS -->
                <div
                    class="business-detail__panel"
                    data-business-panel="schedules"
                    role="tabpanel"
                    hidden
                >
                    <section class="business-detail__card">
                        <div class="business-detail__card-icon">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div class="business-detail__card-content">
                            <h3>Horarios de atención</h3>
                            ${this.renderSchedules(business.schedules)}
                        </div>
                    </section>
                </div>

            </div>
        </article>
    `;
        }

        static initDetailInteractions() {
            if (this._detailInteractionsInitialized) return;

            this._detailInteractionsInitialized = true;

            document.addEventListener('click', (event) => {

                // ==========================
                // CAMBIAR PESTAÑAS
                // ==========================
                const tab = event.target.closest('[data-business-tab]');

                if (tab) {
                    const detail = tab.closest('.business-detail');
                    if (!detail) return;

                    const selectedTab = tab.dataset.businessTab;

                    detail.querySelectorAll('[data-business-tab]').forEach(button => {
                        const active = button.dataset.businessTab === selectedTab;

                        button.classList.toggle(
                            'business-detail__tab--active',
                            active
                        );

                        button.setAttribute(
                            'aria-selected',
                            String(active)
                        );
                    });

                    detail.querySelectorAll('[data-business-panel]').forEach(panel => {
                        const active = panel.dataset.businessPanel === selectedTab;

                        panel.classList.toggle(
                            'business-detail__panel--active',
                            active
                        );

                        panel.hidden = !active;
                    });

                    return;
                }

                // ==========================
                // ABRIR PROMOCIÓN
                // ==========================
                const promotionButton = event.target.closest('[data-promotion-open]');

                if (promotionButton) {
                    const image = promotionButton.dataset.promotionImage;
                    const name = promotionButton.dataset.promotionName || 'Promoción';
                    const description = promotionButton.dataset.promotionDescription || '';

                    this.openPromotionViewer({
                        image,
                        name,
                        description
                    });

                    return;
                }

                // ==========================
                // CERRAR VISOR
                // ==========================
                if (
                    event.target.closest('[data-promotion-close]') ||
                    event.target.matches('[data-promotion-overlay]')
                ) {
                    this.closePromotionViewer();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    this.closePromotionViewer();
                }
            });
        }

        static openPromotionViewer({ image, name, description }) {
            this.closePromotionViewer();

            const viewer = document.createElement('div');

            viewer.className = 'business-detail__viewer';
            viewer.setAttribute('data-promotion-overlay', '');
            viewer.setAttribute('role', 'dialog');
            viewer.setAttribute('aria-modal', 'true');
            viewer.setAttribute('aria-label', 'Detalle de promoción');

            // Se construyen nodos DOM para no interpretar texto externo como HTML.
            const container = document.createElement('div');
            container.className = 'business-detail__viewer-container';

            const closeButton = document.createElement('button');
            closeButton.type = 'button';
            closeButton.className = 'business-detail__viewer-close';
            closeButton.setAttribute('data-promotion-close', '');
            closeButton.setAttribute('aria-label', 'Cerrar promoción');

            const closeIcon = document.createElement('i');
            closeIcon.className = 'bi bi-x-lg';
            closeButton.appendChild(closeIcon);

            const content = document.createElement('div');
            content.className = 'business-detail__viewer-content';

            if (image && safeUrl(image)) {
                const img = document.createElement('img');
                img.src = safeUrl(image);
                img.alt = name;
                img.className = 'business-detail__viewer-image';

                content.appendChild(img);
            }

            const information = document.createElement('div');
            information.className = 'business-detail__viewer-information';

            const title = document.createElement('h3');
            title.textContent = name;
            information.appendChild(title);

            if (description) {
                const paragraph = document.createElement('p');
                paragraph.textContent = description;
                information.appendChild(paragraph);
            }

            container.append(closeButton, content, information);
            viewer.appendChild(container);

            document.body.appendChild(viewer);
            closeButton.focus();
        }

        static closePromotionViewer() {
            document.querySelectorAll('[data-promotion-overlay]')
                .forEach(viewer => viewer.remove());
        }


        static getIconBusinessHtml(business, count = 1) {

            // ============================================
            // 1. INFORMACIÓN DEL MARCADOR
            // ============================================

            const url = safeUrl(business.source);
            const isGrouped = count > 1;

            // ============================================
            // 2. PROMOCIONES REALES DEL BACKEND
            // ============================================

            const promotions = Array.isArray(business.promotions)
                ? business.promotions
                : [];

            const hasPromotions = promotions.some(promotion =>
                promotion &&
                String(promotion.status || '').toUpperCase() === 'ACTIVE'
            );

            // Independiente de is_route.
            // No animar marcadores agrupados.
            const shouldAnimate = hasPromotions && !isGrouped;

            // ============================================
            // 3. IMAGEN O FALLBACK
            // ============================================

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

            // ============================================
            // 4. CLASES BEM DEL MARCADOR
            // ============================================

            const markerClasses = [
                'business-map-marker',

                isGrouped
                    ? 'business-map-marker--grouped'
                    : '',

                shouldAnimate
                    ? 'business-map-marker--pumpkin-bounce'
                    : ''

            ].filter(Boolean).join(' ');

            // ============================================
            // 5. GENERAR HTML
            // ============================================

            return `
        <div class="${markerClasses}">

            <!-- CONTENIDO QUE REBOTA -->
            <div class="business-map-marker__bounce-content">

                <!-- ONDAS DE PULSO -->
                ${shouldAnimate ? `
                    <span
                        class="business-map-marker__pulse-wave"
                        aria-hidden="true"
                    ></span>

                    <span
                        class="
                            business-map-marker__pulse-wave
                            business-map-marker__pulse-wave--delayed
                        "
                        aria-hidden="true"
                    ></span>
                ` : ''}

                <!-- IMAGEN -->
                ${photo}

                <!-- INDICADOR DE PROMOCIONES -->
                ${this.getBusinessNewsBadge(business)}

                <!-- CONTADOR DE EMPRESAS -->
                ${isGrouped ? `
                    <span class="business-map-marker__count">
                        ${count}
                    </span>
                ` : ''}

            </div>

        </div>
    `;
        }


        static getIconBusinessHtml2(business, count = 1) {

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

        ${this.getBusinessNewsBadge(business)}

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
                    singleBusinessZoom: 16,
                    fitMaxZoom: 16,
                    fitPadding: [70, 70],
                    detailAsideId: 'businessDetailAside',
                    groupAsideId: 'businessGroupAside',
                    // Centro de Otavalo, Imbabura
                    position: [0.2343, -78.2625],
                    zoom: 15,
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

            assignDemoNews(input = []) {
                const businesses = Array.isArray(input) ? input : [];

                businesses.forEach(business => {

                    // ============================================
                    // 1. TIPO DE EMPRESA
                    // ============================================

                    business.is_route = (
                        business.is_route === true ||
                        business.is_route === 1 ||
                        business.is_route === '1'
                    );

                    // ============================================
                    // 2. INFORMACIÓN REAL DEL BACKEND
                    // ============================================

                    const promotions = Array.isArray(business.promotions)
                        ? business.promotions
                        : [];

                    const events = Array.isArray(business.events)
                        ? business.events
                        : [];

                    const advertisements = Array.isArray(business.advertisements)
                        ? business.advertisements
                        : [];

                    // ============================================
                    // 3. VALIDAR ESTADO ACTIVO
                    // ============================================

                    const hasActiveItems = (items) => {
                        return items.some(item =>
                            item &&
                            String(item.status || '').toUpperCase() === 'ACTIVE'
                        );
                    };

                    // ============================================
                    // 4. DETERMINAR TIPOS DE NOVEDADES
                    // ============================================

                    business.newsTypes = [];

                    if (hasActiveItems(promotions)) {
                        business.newsTypes.push('promotion');
                    }

                    if (hasActiveItems(events)) {
                        business.newsTypes.push('event');
                    }

                    if (hasActiveItems(advertisements)) {
                        business.newsTypes.push('advertisement');
                    }

                    // ============================================
                    // 5. INDICAR SI TIENE NOVEDADES
                    // ============================================

                    business.hasNews = business.newsTypes.length > 0;

                    // ============================================
                    // 6. COMPATIBILIDAD TEMPORAL
                    // ============================================

                    // Se conserva la propiedad si otro componente
                    // todavía la utiliza para pintar un icono.
                    business.demoNewsType = business.newsTypes[0] ?? null;
                });

                return businesses;
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
                this.assignDemoNews(list);
                this.closeAsides();

                this.businesses.clear();
                this.groups.clear();
                this.markers.clear();

                this.markerLayer?.clearLayers();

                // ============================================
                // PROCESAR EMPRESAS
                // ============================================

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

                    // Agrupar empresas con la misma ubicación
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

                // ============================================
                // CREAR MARCADORES
                // ============================================

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

                    // ========================================
                    // EVENTO CLICK DEL MARCADOR
                    // ========================================

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

                    // Agregar marcador al mapa
                    marker.addTo(this.markerLayer);

                    // Registrar marcador por empresa
                    group.businesses.forEach(item => {

                        this.markers.set(
                            String(item.id),
                            marker
                        );
                    });

                    // Registrar coordenadas para el encuadre
                    bounds.push([
                        group.lat,
                        group.lng
                    ]);
                }

                // ============================================
                // CENTRAR MAPA AUTOMÁTICAMENTE
                // ============================================

                if (
                    this.map &&
                    bounds.length > 0 &&
                    this.config.fitOnRender
                ) {

                    const singleBusinessZoom =
                        this.config.singleBusinessZoom ?? 16;

                    const fitMaxZoom =
                        this.config.fitMaxZoom ?? 16;

                    const fitPadding =
                        this.config.fitPadding ?? [70, 70];

                    // ========================================
                    // UNA SOLA UBICACIÓN
                    // ========================================

                    if (bounds.length === 1) {

                        this.map.setView(
                            bounds[0],
                            Math.min(
                                singleBusinessZoom,
                                this.config.maxZoom
                            ),
                            {
                                animate: false
                            }
                        );

                    } else {

                        // ====================================
                        // VARIAS UBICACIONES
                        // ====================================

                        const businessBounds =
                            L.latLngBounds(bounds);

                        this.map.fitBounds(
                            businessBounds,
                            {
                                padding: fitPadding,

                                maxZoom: Math.min(
                                    fitMaxZoom,
                                    this.config.maxZoom
                                ),

                                animate: false
                            }
                        );
                    }

                    // ========================================
                    // INFORMACIÓN DE DEPURACIÓN
                    // ========================================

                    const center = this.map.getCenter();

                    console.log(
                        '[BusinessMapController] Mapa ajustado',
                        {
                            totalBusinesses: this.businesses.size,

                            totalLocations: this.groups.size,

                            center: {
                                latitude: center.lat,
                                longitude: center.lng
                            },

                            zoom: this.map.getZoom()
                        }
                    );
                }

                // ============================================
                // EVENTO DE RENDERIZACIÓN
                // ============================================

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
