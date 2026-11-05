<script>
    /* Yapita Task Cards | Bootstrap 5.0.2 | jQuery | Vue v-html */
    (function (window, $) {
        'use strict';

        const DEFAULTS = {
            publicAsset: '',
            selector: '#listing-items',
            labels: {
                digital: 'Digital', physical: 'Física', points: 'Yapitas',
                details: 'Ver detalles', hideDetails: 'Ocultar detalles',
                howTo: 'Cómo participar', explore: 'Realizar tarea', map: 'Cómo llegar',
                steps: 'Pasos para participar', tips: 'Consejos', rules: 'Reglas',
                validation: 'Validación', business: 'Empresa participante',
                once: 'Una sola vez', unlimited: 'Sin límite', day: 'vez al día',
                week: 'veces por semana', month: 'veces al mes', total: 'veces en total',
                always: 'Siempre disponible', unavailable: 'Acción no disponible',
                noLocation: 'Ubicación pendiente', missingAction: 'Consulta los pasos para participar',
                more: 'Información de la tarea'
            }
        };
        let config = {...DEFAULTS, labels: {...DEFAULTS.labels}};

        function escapeHtml(value) {
            return String(value == null ? '' : value)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;')
                .replace(/>/g, '&gt;').replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function parseDescription(value) {
            if (value && typeof value === 'object') return value;
            if (typeof value !== 'string') return {};
            try {
                const parsed = JSON.parse(value);
                return parsed && typeof parsed === 'object' ? parsed : {summary: value};
            } catch (_) {
                return {summary: value};
            }
        }

        function normalizedUrl(value) {
            const url = String(value || '').trim();
            if (!url || url === 'not-url') return '';
            if (url.startsWith('/') && !url.startsWith('//')) return url;
            try {
                const parsed = new URL(url, window.location.href);
                if (['http:', 'https:'].includes(parsed.protocol)) return parsed.href;
            } catch (_) { /* invalid URL */
            }
            return '';
        }

        function assetUrl(path) {
            const value = String(path || '').trim();
            if (!value) return '';
            if (/^https?:\/\//i.test(value)) return normalizedUrl(value);
            if (value.startsWith('//')) return '';
            const base = String(config.publicAsset || '').replace(/\/+$/, '');
            return base ? base + '/' + value.replace(/^\/+/, '') : '/' + value.replace(/^\/+/, '');
        }

        function hasCoords(lat, lng) {
            if (lat === '' || lat == null || lng === '' || lng == null) return false;
            const a = Number(lat), b = Number(lng);
            return Number.isFinite(a) && Number.isFinite(b) &&
                a >= -90 && a <= 90 && b >= -180 && b <= 180 &&
                !(a === 0 && b === 0);
        }

        function mapUrl(task) {
            if (hasCoords(task.lat, task.lng)) {
                return 'https://www.google.com/maps/dir/?api=1&destination=' +
                    encodeURIComponent(task.lat + ',' + task.lng) + '&travelmode=driving';
            }
            // Do not route to a guessed address; many test records have fictitious addresses.
            return '';
        }

        function taskChannel(row) {
            const channel = String(row.execution_channel || '').toUpperCase();
            const tracking = String(row.tracking_type_code_view || '').toLowerCase();
            const source = String(row.tracking_source_code_view || '').toLowerCase();
            // QR validation requires a physical visit even if a legacy row says DIGITAL.
            if (channel === 'PHYSICAL' || channel === 'FISICO' || tracking === 'qr_scan' || source === 'qr_ticket') return 'PHYSICAL';
            return 'DIGITAL';
        }

        function frequency(row) {
            const kind = String(row.frequency_limit_type || '').toUpperCase();
            const n = Math.max(1, Number(row.frequency_limit_value) || 1);
            const x = config.labels;
            if (kind === 'ONCE') return x.once;
            if (kind === 'UNLIMITED') return x.unlimited;
            if (kind === 'DAILY') return n + ' ' + (n === 1 ? 'vez' : 'veces') + ' al día';
            if (kind === 'WEEKLY') return n + ' ' + (n === 1 ? 'vez' : 'veces') + ' por semana';
            if (kind === 'MONTHLY') return n + ' ' + (n === 1 ? 'vez' : 'veces') + ' al mes';
            if (kind === 'TOTAL_LIMIT') return n + ' ' + (n === 1 ? 'vez' : 'veces') + ' en total';
            return '';
        }

        function stripEmoji(value) {
            return String(value || '').replace(/^[\s\p{Extended_Pictographic}\uFE0F\u200D]+/gu, '')
                .replace(/^\(QR\)\s*/i, '').trim();
        }

        function plainStep(value) {
            return stripEmoji(value).replace(/^[\s•-]+/, '').trim();
        }

        function normalize(row) {
            const desc = parseDescription(row.description);
            const steps = Array.isArray(desc.steps) ? desc.steps.map(plainStep).filter(Boolean) : [];
            const helpers = Array.isArray(desc.helpers) ? desc.helpers.map(plainStep).filter(Boolean) : [];
            const rules = Array.isArray(desc.rules) ? desc.rules.map(plainStep).filter(Boolean) : [];
            const channel = taskChannel(row);
            const id = String(row.id == null ? '' : row.id);
            const businessId = String(row.business_id == null ? '' : row.business_id);
            const summary = desc.summary || steps.slice(0, 2).join(' ');
            return {
                id,
                businessId,
                domId: 'yapita-task-' + id.replace(/[^\w-]/g, '') + '-' + businessId.replace(/[^\w-]/g, ''),
                title: stripEmoji(row.title),
                businessName: row.business_name || 'Negocio aliado',
                businessCategory: row.business_subcategories_name || '',
                points: Number(row.points) || 0,
                channel,
                summary,
                steps,
                helpers,
                rules,
                validation: desc.validation || '',
                frequency: frequency(row),
                active: row.state === 'ACTIVE',
                image: assetUrl(row.source),
                actionUrl: normalizedUrl(row.url_manager),
                lat: row.business_lat,
                lng: row.business_lng,
                mapUrl: '',
                validFrom: row.valid_from,
                validUntil: row.valid_until
            };
        }

        function renderHeader(t) {
            const physical = t.channel === 'PHYSICAL';
            return `<header class="yapita-task__header">
            <span class="yapita-task__channel yapita-task__channel--${physical ? 'physical' : 'digital'}">
                <i class="bi bi-${physical ? 'geo-alt-fill' : 'phone'}" aria-hidden="true"></i>
                ${escapeHtml(physical ? config.labels.physical : config.labels.digital)}
            </span>
            <span class="yapita-task__points" aria-label="${escapeHtml(t.points + ' ' + config.labels.points)}">
                <i class="bi bi-coin" aria-hidden="true"></i>
                <strong>+${escapeHtml(t.points)}</strong> <span>${escapeHtml(config.labels.points)}</span>
            </span>
        </header>`;
        }


        function renderContent(t) {

            return `
        <div class="yapita-task__content">

            ${t.image ? `
                <div class="yapita-task__media">
                    <img
                        loading="lazy"
                        src="${escapeHtml(t.image)}"
                        alt="${escapeHtml(t.title)}"
                        onerror="this.parentElement.style.display='none'"
                    >
                </div>
            ` : ''}

            <div class="yapita-task__information">

                <h3 class="yapita-task__title">
                    ${escapeHtml(t.title)}
                </h3>

                <div class="yapita-task__business">

                    <i class="bi bi-shop" aria-hidden="true"></i>

                    <span>
                        <strong>${escapeHtml(t.businessName)}</strong>

                        ${t.businessCategory ? `
                            <small>
                                ${escapeHtml(t.businessCategory)}
                            </small>
                        ` : ''}
                    </span>

                </div>

                <p class="yapita-task__description">
                    ${escapeHtml(
                t.summary || config.labels.missingAction
            )}
                </p>

            </div>

            <!-- BOTÓN DE DETALLES -->
            <button
                type="button"
                class="yapita-task__view-details"
                data-yapita-action="details"
                data-task-id="${escapeHtml(t.id)}"
                data-business-id="${escapeHtml(t.businessId)}"
                aria-label="Ver detalles de ${escapeHtml(t.title)}"
                title="Ver detalles"
            >
                <i class="bi bi-chevron-right" aria-hidden="true"></i>
            </button>

        </div>
    `;
        }


        function list(items, modifier) {
            if (!items || !items.length) return '';
            return `<ol class="yapita-task__list yapita-task__list--${modifier}">` +
                items.map(s => `<li>${escapeHtml(s)}</li>`).join('') + '</ol>';
        }

        function renderDetails(t) {
            const blocks = [
                t.steps.length ? `<section class="yapita-task__detail-section"><h4>${escapeHtml(config.labels.steps)}</h4>${list(t.steps, 'steps')}</section>` : '',
                t.helpers.length ? `<section class="yapita-task__detail-section"><h4>${escapeHtml(config.labels.tips)}</h4>${list(t.helpers, 'tips')}</section>` : '',
                t.validation ? `<section class="yapita-task__detail-section"><h4>${escapeHtml(config.labels.validation)}</h4><p>${escapeHtml(t.validation)}</p></section>` : '',
                t.rules.length ? `<section class="yapita-task__detail-section"><h4>${escapeHtml(config.labels.rules)}</h4>${list(t.rules, 'rules')}</section>` : ''
            ].filter(Boolean).join('');
            return `<div class="yapita-task__details" id="${escapeHtml(t.domId)}-details" hidden>${blocks}</div>`;
        }

        function renderActions(t) {
            if (t.channel === 'PHYSICAL') {
                if (!t.mapUrl) return `<button type="button" class="yapita-task__button yapita-task__button--disabled" disabled>
                <i class="bi bi-geo-alt" aria-hidden="true"></i> ${escapeHtml(config.labels.noLocation)}</button>`;
                return `<a class="yapita-task__button yapita-task__button--primary" href="${escapeHtml(t.mapUrl)}" target="_blank" rel="noopener noreferrer" aria-label="Cómo llegar a ${escapeHtml(t.businessName)} en Google Maps">
                <i class="bi bi-geo-alt-fill" aria-hidden="true"></i> ${escapeHtml(config.labels.map)}</a>`;
            }
            if (t.actionUrl) {
                return `<a class="yapita-task__button yapita-task__button--primary" href="${escapeHtml(t.actionUrl)}" target="_blank" rel="noopener noreferrer">
                <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i> ${escapeHtml(config.labels.explore)}</a>`;
            }
            return `<button type="button"   data-url="${escapeHtml(t.actionUrl)}"  class="yapita-task__button yapita-task__button--secondary" data-yapita-details="${escapeHtml(t.domId)}" aria-controls="${escapeHtml(t.domId)}-details" aria-expanded="false">
            <i class="bi bi-info-circle" aria-hidden="true"></i> ${escapeHtml(config.labels.howTo)}</button>`;
        }



        /* ==========================================
           YAPITA - LIMITATIONS CONFIG
           Laravel + Bootstrap 5.0.2
        ========================================== */

        const YapitaLimitationsConfig = {

            labels: {
                unlimited: @json(__('gamification.unlimited')),
                once: @json(__('gamification.only_once')),
                daily: @json(__('gamification.per_day')),
                weekly: @json(__('gamification.per_week')),
                monthly: @json(__('gamification.per_month')),
                total: @json(__('gamification.total_limit')),
                undefined: @json(__('gamification.not_defined')),

                always: @json(__('gamification.always_available')),
                from: @json(__('gamification.available_from')),
                until: @json(__('gamification.available_until')),
                between: @json(__('gamification.available_between')),

                available: 'Disponible',
                upcoming: 'Próximamente',
                expiring: 'Por vencer',
                expired: 'Finalizada',
                inactive: 'No disponible'
            },

            warningDays: 3
        };


        /* ==========================================
           1. OBTENER LIMITACIONES NORMALIZADAS
        ========================================== */

        function getTaskLimitations(params = {}) {

            const labels = YapitaLimitationsConfig.labels;

            const type = String(
                params.frequency_limit_type ||
                params.frequencyType ||
                'NONE'
            ).toUpperCase();

            const rawValue =
                params.frequency_limit_value ??
                params.frequencyValue;

            const parsedValue = Number(rawValue);

            const value = Number.isInteger(parsedValue) &&
            parsedValue > 0
                ? parsedValue
                : 1;

            const validFrom =
                params.valid_from ?? params.validFrom ?? null;

            const validUntil =
                params.valid_until ?? params.validUntil ?? null;

            // ======================================
            // UTILIDADES
            // ======================================

            function applyValue(template, number) {

                const text = String(template || '');

                if (/:value|\{value\}/.test(text)) {
                    return text
                        .replace(/:value/g, String(number))
                        .replace(/\{value\}/g, String(number));
                }

                return `${number} ${text}`.trim();
            }

            function parseDate(input, endOfDay = false) {

                if (!input) return null;

                const match = String(input).trim().match(
                    /^(\d{4})-(\d{2})-(\d{2})(?:[ T](\d{2}):(\d{2})(?::(\d{2}))?)?$/
                );

                if (!match) return null;

                const year = Number(match[1]);
                const month = Number(match[2]);
                const day = Number(match[3]);

                const hasTime = match[4] !== undefined;

                const hour = hasTime
                    ? Number(match[4])
                    : endOfDay ? 23 : 0;

                const minute = hasTime
                    ? Number(match[5])
                    : endOfDay ? 59 : 0;

                const second = hasTime
                    ? Number(match[6] || 0)
                    : endOfDay ? 59 : 0;

                const date = new Date(
                    year,
                    month - 1,
                    day,
                    hour,
                    minute,
                    second,
                    endOfDay && !hasTime ? 999 : 0
                );

                if (
                    date.getFullYear() !== year ||
                    date.getMonth() !== month - 1 ||
                    date.getDate() !== day ||
                    date.getHours() !== hour ||
                    date.getMinutes() !== minute ||
                    date.getSeconds() !== second
                ) {
                    return null;
                }

                return date;
            }

            function formatDate(date) {

                if (!date) return '';

                return new Intl.DateTimeFormat('es-EC', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                }).format(date);
            }

            // ======================================
            // 2. FRECUENCIA
            // ======================================

            const frequency = {
                type,
                value,
                text: labels.undefined,
                icon: 'bi-question-circle',
                modifier: 'info'
            };

            switch (type) {

                case 'NONE':
                case 'UNLIMITED':
                    frequency.text = labels.unlimited;
                    frequency.icon = 'bi-infinity';
                    frequency.modifier = 'ok';
                    break;

                case 'ONCE':
                    frequency.text = labels.once;
                    frequency.icon = 'bi-lock';
                    frequency.modifier = 'danger';
                    break;

                case 'DAILY':
                    frequency.text = applyValue(labels.daily, value);
                    frequency.icon = 'bi-arrow-repeat';
                    break;

                case 'WEEKLY':
                    frequency.text = applyValue(labels.weekly, value);
                    frequency.icon = 'bi-calendar-week';
                    break;

                case 'MONTHLY':
                    frequency.text = applyValue(labels.monthly, value);
                    frequency.icon = 'bi-calendar-month';
                    break;

                case 'TOTAL_LIMIT':
                    frequency.text = applyValue(labels.total, value);
                    frequency.icon = 'bi-layers';
                    frequency.modifier = 'warn';
                    break;
            }

            // ======================================
            // 3. VIGENCIA
            // ======================================

            const start = parseDate(validFrom);
            const end = parseDate(validUntil, true);

            const validity = {
                from: start,
                until: end,
                text: labels.always,
                icon: 'bi-calendar3',
                modifier: 'ok'
            };

            if (start && end) {

                validity.text =
                    `${labels.between} ${formatDate(start)} al ${formatDate(end)}`;

                validity.modifier = 'info';

            } else if (start) {

                validity.text =
                    `${labels.from} ${formatDate(start)}`;

                validity.modifier = 'info';

            } else if (end) {

                validity.text =
                    `${labels.until} ${formatDate(end)}`;

                validity.modifier = 'warn';
            }

            // ======================================
            // 4. ESTADO
            // ======================================

            const active = typeof params.active === 'boolean'
                ? params.active
                : String(params.state || 'ACTIVE').toUpperCase() === 'ACTIVE';

            const now = new Date();

            const status = {
                code: 'ACTIVE',
                text: labels.available,
                modifier: 'active',
                canExecute: true
            };

            if (!active) {

                status.code = 'INACTIVE';
                status.text = labels.inactive;
                status.modifier = 'inactive';
                status.canExecute = false;

            } else if (start && now < start) {

                status.code = 'UPCOMING';
                status.text = labels.upcoming;
                status.modifier = 'upcoming';
                status.canExecute = false;

            } else if (end && now > end) {

                status.code = 'EXPIRED';
                status.text = labels.expired;
                status.modifier = 'expired';
                status.canExecute = false;

            } else if (end) {

                const remainingDays =
                    (end.getTime() - now.getTime()) / 86400000;

                if (remainingDays <= YapitaLimitationsConfig.warningDays) {

                    status.code = 'EXPIRING';
                    status.text = labels.expiring;
                    status.modifier = 'warning';
                }
            }

            return {
                frequency,
                validity,
                status
            };
        }


        function renderFooterNew(t) {

            const limits = getTaskLimitations(t);

            const frequency = limits.frequency;
            const validity = limits.validity;
            const status = limits.status;

            return `
        <footer class="yapita-task__footer">

            <!-- FRECUENCIA Y VIGENCIA -->
            <div class="yapita-task__meta">

                <div class="yapita-task__meta-item">

                    <i
                        class="bi ${escapeHtml(frequency.icon)}"
                        aria-hidden="true"
                    ></i>

                    <span class="yapita-task__meta-content">

                        <small>Frecuencia</small>

                        <strong>
                            ${escapeHtml(frequency.text)}
                        </strong>

                    </span>

                </div>

                <div class="yapita-task__meta-item">

                    <i
                        class="bi ${escapeHtml(validity.icon)}"
                        aria-hidden="true"
                    ></i>

                    <span class="yapita-task__meta-content">

                        <small>Vigencia</small>

                        <strong>
                            ${escapeHtml(validity.text)}
                        </strong>

                    </span>

                </div>

            </div>

            <!-- ESTADO -->
            <div class="yapita-task__status-row">

                <span class="
                    yapita-task__status
                    yapita-task__status--${status.modifier}
                ">
                    ${escapeHtml(status.text)}
                </span>

            </div>

            <!-- ACCIÓN PRINCIPAL -->
            <div class="yapita-task__actions">
                ${renderActions(t)}
            </div>

        </footer>
    `;
        }

        function renderFooter(t) {

            const frequencyHtml = t.frequency
                ? `
            <span class="yapita-task__frequency">
                <i class="bi bi-arrow-repeat"></i>
Frecuencia
                ${escapeHtml(t.frequency)}
            </span>
        `
                : '';

            const validityText = t.validUntil
                ? `Hasta: ${formatTaskDate(t.validUntil)}`
                : '';

            const validityHtml = validityText===''?"":`
        <span class="yapita-task__validity">
            <i class="bi bi-calendar3"></i>
            ${escapeHtml(validityText)}
        </span>
    `;

            return `
        <footer class="yapita-task__footer">

            <div class="yapita-task__meta">

                ${frequencyHtml}

                ${validityHtml}

            </div>

            <div class="yapita-task__actions">
                ${renderActions(t)}
            </div>

        </footer>
    `;
        }

        function formatTaskDate(value) {

            if (!value) return '';

            const date = String(value).slice(0, 10);
            const parts = date.split('-');

            if (parts.length !== 3) return String(value);

            const year = Number(parts[0]);
            const month = Number(parts[1]);
            const day = Number(parts[2]);

            const valid = year >= 2000 &&
                month >= 1 && month <= 12 &&
                day >= 1 && day <= 31 &&
                new Date(Date.UTC(year, month - 1, day))
                    .toISOString().slice(0, 10) === date;

            if (!valid) return String(value);

            const months = [
                'Ene', 'Feb', 'Mar', 'Abr',
                'May', 'Jun', 'Jul', 'Ago',
                'Sep', 'Oct', 'Nov', 'Dic'
            ];

            return `${day} ${months[month - 1]} ${year}`;
        }

        function render(row) {
            const t = normalize(row);
            t.mapUrl = mapUrl(t);
            return `<article class="yapita-task yapita-task--${t.channel.toLowerCase()}" id="${escapeHtml(t.domId)}" data-task-id="${escapeHtml(t.id)}" data-business-id="${escapeHtml(t.businessId)}" data-channel="${escapeHtml(t.channel)}">
            ${renderHeader(t)}
            ${renderContent(t)}
            ${renderDetails(t)}
            ${renderFooter(t)}
        </article>`;
        }

        function init(options) {
            options = options || {};
            config = {...DEFAULTS, ...options, labels: {...DEFAULTS.labels, ...(options.labels || {})}};
            if (!$ || !$.fn) return;
            const root = config.selector;
            $(document)
                .off('click.yapitaTaskDetails', root + ' .yapita-task__content')
                .on(
                    'click.yapitaTaskDetails',
                    root + ' .yapita-task__content',
                    function (event) {

                        // Evitar acciones sobre enlaces u otros controles.
                        if ($(event.target).closest('a, button').length &&
                            !$(event.target).closest('.yapita-task__view-details').length) {
                            return;
                        }

                        event.preventDefault();

                        const $card = $(this).closest('.yapita-task');

                        const taskId = String($card.attr('data-task-id') || '');
                        const businessId = String($card.attr('data-business-id') || '');

                        if (!taskId || !businessId) return;

                        // Emitir evento para abrir el modal.
                        $(document).trigger('yapita:task:details', [{
                            taskId,
                            businessId,
                            source: $(event.target).closest(
                                '.yapita-task__view-details'
                            ).length ? 'button' : 'content'
                        }]);
                        console.log("click manager view task")
                    }
                );

        }

        window.YapitaTaskCard = {
            init, normalize, render, renderHeader, renderContent, renderDetails, renderFooter, renderActions,
            mapUrl, frequency, parseDescription, escapeHtml
        };
    })(window, window.jQuery);

</script>
<script>
    window.YapitaTaskCard.init({
        publicAsset: @json(asset('public')),
        selector: '#listing-items',
        labels: {
            digital: @json(__('gamification.digital')),
            physical: @json(__('gamification.physical')),
            points: 'Yapitas',
            map: 'Cómo llegar',
            explore: 'Realizar tarea',
            details: 'Ver detalles',
            hideDetails: 'Ocultar detalles'
        }
    });
</script>
