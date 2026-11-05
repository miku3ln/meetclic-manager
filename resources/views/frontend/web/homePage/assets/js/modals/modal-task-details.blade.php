<script>

    /* ==========================================
       YAPITA TASK MODAL UTIL
       Bootstrap 5.0.2 + jQuery
    ========================================== */

    (function (window, $) {
        'use strict';

        class YapitaTaskModalUtil {
            static eventsInitialized = false;
            static config = {
                selector: '#yapita-task-modal',
                warningDays: 3,
                getTask: null,
                businessUrl: null
            };

            static currentTask = null;
            static currentRaw = null;
            static modalInstance = null;


            static bindEvents() {

                // ==========================================
                // EVITAR REGISTRAR EVENTOS DOS VECES
                // ==========================================

                if (this.eventsInitialized) {
                    return;
                }

                const selector = this.config.selector;

                // ==========================================
                // 1. BOTONES DEL MODAL
                // ==========================================

                $(document)
                    .off(
                        'click.yapitaModalAction',
                        selector + ' [data-yapita-modal-action]'
                    )
                    .on(
                        'click.yapitaModalAction',
                        selector + ' [data-yapita-modal-action]',
                        (event) => {

                            event.preventDefault();
                            event.stopPropagation();

                            const action = event.currentTarget
                                .getAttribute('data-yapita-modal-action');

                            if (!action) return;

                            this.handleAction(action);
                        }
                    );

                // ==========================================
                // 2. BOTÓN PRINCIPAL
                // ==========================================

                $(document)
                    .off(
                        'click.yapitaModalPrimary',
                        selector + ' #yapita-task-modal-primary'
                    )
                    .on(
                        'click.yapitaModalPrimary',
                        selector + ' #yapita-task-modal-primary',
                        (event) => {

                            event.preventDefault();
                            event.stopPropagation();

                            const action = event.currentTarget.dataset.action;

                            if (!action) return;

                            this.handleAction(action);
                        }
                    );

                // ==========================================
                // 3. EVENTO AL CERRAR EL MODAL
                // ==========================================

                $(selector)
                    .off('hidden.bs.modal.yapitaModal')
                    .on('hidden.bs.modal.yapitaModal', () => {

                        this.currentTask = null;
                        this.currentRaw = null;

                    });

                this.eventsInitialized = true;
            }

            // ======================================
            // INIT
            // ======================================

            static init(options = {}) {

                this.config = {
                    ...this.config,
                    ...options
                };

                const element = document.querySelector(
                    this.config.selector
                );

                if (!element) {
                    console.warn('YapitaTaskModalUtil: modal no encontrado.');
                    return;
                }

                if (!window.bootstrap || !bootstrap.Modal) {
                    console.warn('Bootstrap 5 Modal no disponible.');
                    return;
                }

                this.modalInstance =
                    bootstrap.Modal.getOrCreateInstance(element);

                // Recibir evento emitido por YapitaTaskCard.
                $(document)
                    .off('yapita:task:details.yapitaModal')
                    .on(
                        'yapita:task:details.yapitaModal',
                        (event, data) => {

                            if (!data) return;

                            if (typeof this.config.getTask !== 'function') {
                                return;
                            }

                            const raw = this.config.getTask(
                                data.taskId,
                                data.businessId
                            );

                            if (raw) {
                                this.open(raw);
                            }
                        }
                    );

                // Eventos de los botones del modal.
                $(document)
                    .off(
                        'click.yapitaModalAction',
                        this.config.selector +
                        ' [data-yapita-modal-action]'
                    )
                    .on(
                        'click.yapitaModalAction',
                        this.config.selector +
                        ' [data-yapita-modal-action]',
                        (event) => {

                            event.preventDefault();

                            const action = event.currentTarget
                                .getAttribute('data-yapita-modal-action');

                            this.handleAction(action);
                        }
                    );

                // Botón principal.
                $(document)
                    .off(
                        'click.yapitaModalPrimary',
                        '#yapita-task-modal-primary'
                    )
                    .on(
                        'click.yapitaModalPrimary',
                        '#yapita-task-modal-primary',
                        (event) => {

                            event.preventDefault();

                            const action = event.currentTarget
                                .dataset.action;

                            this.handleAction(action);
                        }
                    );

                $(element)
                    .off('hidden.bs.modal.yapitaModal')
                    .on('hidden.bs.modal.yapitaModal', () => {
                        this.currentTask = null;
                        this.currentRaw = null;
                    });
            }

            // ======================================
            // HELPERS
            // ======================================

            static escapeHtml(value) {
                return String(value == null ? '' : value)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#39;');
            }

            static setText(id, value) {
                const element = document.getElementById(id);

                if (element) {
                    element.textContent = value == null
                        ? ''
                        : String(value);
                }
            }

            static parseDescription(value) {
                if (value && typeof value === 'object') {
                    return value;
                }

                try {
                    return JSON.parse(value || '{}') || {};
                } catch (_) {
                    return {
                        summary: String(value || '')
                    };
                }
            }

            static normalize(raw) {

                if (!window.YapitaTaskCard) {
                    throw new Error(
                        'YapitaTaskCard debe cargarse antes del modal.'
                    );
                }

                const t = YapitaTaskCard.normalize(raw);

                t.mapUrl = YapitaTaskCard.mapUrl(t);

                t.completed =
                    raw.is_completed === true ||
                    raw.is_completed === 1 ||
                    raw.task_completed === true;

                return t;
            }

            static getLocalDate(value, endOfDay = false) {

                if (!value) return null;

                const text = String(value).trim();

                const match = text.match(
                    /^(\d{4})-(\d{2})-(\d{2})(?:[ T](\d{2}):(\d{2})(?::(\d{2}))?)?/
                );

                if (!match) return null;

                const year = Number(match[1]);
                const month = Number(match[2]);
                const day = Number(match[3]);

                const hour = match[4] != null
                    ? Number(match[4])
                    : (endOfDay ? 23 : 0);

                const minute = match[5] != null
                    ? Number(match[5])
                    : (endOfDay ? 59 : 0);

                const second = match[6] != null
                    ? Number(match[6])
                    : (endOfDay ? 59 : 0);

                const date = new Date(
                    year,
                    month - 1,
                    day,
                    hour,
                    minute,
                    second
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

            static formatDate(value) {

                const date = this.getLocalDate(value);

                if (!date) return 'Sin fecha final';

                return new Intl.DateTimeFormat('es-EC', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                }).format(date);
            }

            // ======================================
            // VALIDITY
            // ======================================

            static getValidity(t) {

                const now = new Date();

                const start = this.getLocalDate(t.validFrom);

                const end = this.getLocalDate(
                    t.validUntil,
                    true
                );

                if (!t.active) {
                    return {
                        code: 'INACTIVE',
                        label: 'No disponible',
                        className: 'inactive',
                        canExecute: false
                    };
                }

                if (start && now < start) {
                    return {
                        code: 'UPCOMING',
                        label: 'Próximamente',
                        className: 'inactive',
                        canExecute: false
                    };
                }

                if (end && now > end) {
                    return {
                        code: 'EXPIRED',
                        label: 'Finalizada',
                        className: 'inactive',
                        canExecute: false
                    };
                }

                if (end) {

                    const daysLeft =
                        (end.getTime() - now.getTime()) /
                        86400000;

                    if (daysLeft <= this.config.warningDays) {
                        return {
                            code: 'EXPIRING',
                            label: 'Por vencer',
                            className: 'warning',
                            canExecute: true
                        };
                    }
                }

                return {
                    code: 'ACTIVE',
                    label: 'Disponible',
                    className: 'active',
                    canExecute: true
                };
            }

            // ======================================
            // OPEN / CLOSE
            // ======================================



            static open(raw) {

                if (!raw) return;

                // ==========================================
                // 1. BUSCAR MODAL EN DOM
                // ==========================================

                const element = document.querySelector(
                    this.config.selector
                );

                if (!element) {
                    console.error(
                        'YapitaTaskModalUtil: modal no encontrado.'
                    );
                    return;
                }

                if (!window.bootstrap?.Modal) {
                    console.error(
                        'Bootstrap 5 Modal no disponible.'
                    );
                    return;
                }

                // ==========================================
                // 2. CREAR INSTANCIA SOLO LA PRIMERA VEZ
                // ==========================================

                if (!this.modalInstance) {

                    this.modalInstance =
                        bootstrap.Modal.getOrCreateInstance(element);

                }

                // ==========================================
                // 3. REGISTRAR EVENTOS SOLO UNA VEZ
                // ==========================================

                this.bindEvents();

                // ==========================================
                // 4. CARGAR INFORMACIÓN DE LA TAREA
                // ==========================================

                this.currentRaw = raw;

                this.currentTask = this.normalize(raw);

                this.render(this.currentTask);

                // ==========================================
                // 5. MOSTRAR MODAL
                // ==========================================

                this.modalInstance.show();
            }



            static close() {
                if (this.modalInstance) {
                    this.modalInstance.hide();
                }
            }

            // ======================================
            // RENDER
            // ======================================

            static render(t) {

                const physical = t.channel === 'PHYSICAL';

                const channel = document.getElementById(
                    'yapita-task-modal-channel'
                );

                if (channel) {
                    channel.className =
                        'yapita-task-modal__channel ' +
                        (physical
                            ? 'yapita-task-modal__channel--physical'
                            : 'yapita-task-modal__channel--digital');

                    channel.innerHTML = physical
                        ? '<i class="bi bi-geo-alt-fill"></i> FÍSICO'
                        : '<i class="bi bi-phone"></i> DIGITAL';
                }

                const points = document.getElementById(
                    'yapita-task-modal-points'
                );

                if (points) {
                    points.innerHTML =
                        '<i class="bi bi-coin"></i> +' +
                        this.escapeHtml(t.points) +
                        ' Yapitas';
                }

                this.setText(
                    'yapita-task-modal-title',
                    t.title
                );

                this.setText(
                    'yapita-task-modal-business-name',
                    t.businessName
                );

                this.setText(
                    'yapita-task-modal-business-category',
                    t.businessCategory
                );

                const image = document.getElementById(
                    'yapita-task-modal-image'
                );

                if (image) {

                    const media = image.parentElement;

                    if (t.image) {
                        image.src = t.image;
                        image.alt = t.title;
                        image.hidden = false;
                        media.classList.remove(
                            'yapita-task-modal__media--empty'
                        );
                    } else {
                        image.removeAttribute('src');
                        image.hidden = true;
                        media.classList.add(
                            'yapita-task-modal__media--empty'
                        );
                    }
                }

                this.setText(
                    'yapita-task-modal-description',
                    t.summary || (
                        physical
                            ? 'Visita el establecimiento y sigue los pasos indicados para participar.'
                            : 'Sigue los pasos indicados para completar esta actividad.'
                    )
                );

                this.renderSteps(t);
                this.renderExtra(t);
                this.renderMetadata(t);
                this.renderActions(t);

                // Reiniciar detalle expandido.
                const extra = document.getElementById(
                    'yapita-task-modal-extra'
                );

                if (extra) extra.hidden = true;
            }

            // ======================================
            // STEPS
            // ======================================

            static renderSteps(t) {

                const container = document.getElementById(
                    'yapita-task-modal-steps'
                );

                if (!container) return;

                const steps = Array.isArray(t.steps)
                    ? t.steps
                    : [];

                container.innerHTML = (
                    steps.length
                        ? steps
                        : ['Consulta las condiciones de esta tarea.']
                ).map((step, index) => `
                <li>
                    <span class="yapita-task-modal__step-number">
                        ${index + 1}
                    </span>

                    <span>
                        ${this.escapeHtml(step)}
                    </span>
                </li>
            `).join('');
            }

            // ======================================
            // EXTRA DETAILS
            // ======================================

            static renderExtra(t) {

                const sections = [
                    {
                        section: 'yapita-task-modal-tips-section',
                        content: 'yapita-task-modal-tips',
                        list: t.helpers
                    },
                    {
                        section: 'yapita-task-modal-rules-section',
                        content: 'yapita-task-modal-rules',
                        list: t.rules
                    }
                ];

                sections.forEach(item => {

                    const section = document.getElementById(
                        item.section
                    );

                    const content = document.getElementById(
                        item.content
                    );

                    const values = Array.isArray(item.list)
                        ? item.list
                        : [];

                    if (section) {
                        section.hidden = values.length === 0;
                    }

                    if (content) {
                        content.innerHTML = values.map(value =>
                            `<li>${this.escapeHtml(value)}</li>`
                        ).join('');
                    }
                });

                const validationSection = document.getElementById(
                    'yapita-task-modal-validation-section'
                );

                if (validationSection) {
                    validationSection.hidden = !t.validation;
                }

                this.setText(
                    'yapita-task-modal-validation',
                    t.validation
                );
            }

            // ======================================
            // METADATA
            // ======================================

            static renderMetadata(t) {

                this.setText(
                    'yapita-task-modal-frequency',
                    t.frequency || 'No definida'
                );

                this.setText(
                    'yapita-task-modal-validity',
                    t.validUntil
                        ? 'Hasta ' + this.formatDate(t.validUntil)
                        : (
                            t.validFrom
                                ? 'Desde ' + this.formatDate(t.validFrom)
                                : 'Sin fecha final'
                        )
                );

                const validity = this.getValidity(t);

                const status = document.getElementById(
                    'yapita-task-modal-status'
                );

                if (status) {
                    status.textContent = validity.label;

                    status.className =
                        'yapita-task-modal__status ' +
                        'yapita-task-modal__status--' +
                        validity.className;
                }

                this.setText(
                    'yapita-task-modal-status-label',
                    t.completed ? 'Tarea ejecutada' : 'Ver estado'
                );
            }

            // ======================================
            // ACTION BUTTONS
            // ======================================

            static renderActions(t) {

                const validity = this.getValidity(t);

                const physical = t.channel === 'PHYSICAL';

                const primary = document.getElementById(
                    'yapita-task-modal-primary'
                );

                const secondary = document.getElementById(
                    'yapita-task-modal-secondary'
                );

                const mapShortcut = document.getElementById(
                    'yapita-task-modal-map-shortcut'
                );

                if (primary) {

                    const action = physical
                        ? 'map'
                        : (t.actionUrl ? 'execute' : 'participate');

                    primary.dataset.action = action;

                    primary.innerHTML = physical
                        ? '<i class="bi bi-geo-alt-fill"></i> Cómo llegar'
                        : (
                            action === 'execute'
                                ? '<i class="bi bi-box-arrow-up-right"></i> Realizar tarea'
                                : '<i class="bi bi-info-circle"></i> Cómo participar'
                        );

                    primary.disabled =
                        !validity.canExecute ||
                        (action === 'map' && !t.mapUrl);
                }

                if (secondary) {

                    secondary.hidden =
                        !physical && !t.actionUrl;

                    secondary.disabled = false;
                }

                if (mapShortcut) {
                    mapShortcut.disabled = !t.mapUrl;
                }
            }

            // ======================================
            // EVENT EMITTER
            // ======================================

            static emitAction(action, url = '') {

                const t = this.currentTask;

                if (!t) return false;

                const customEvent = $.Event(
                    'yapita:task:action'
                );

                $(document).trigger(customEvent, [{
                    action,
                    taskId: t.id,
                    businessId: t.businessId,
                    channel: t.channel,
                    source: 'modal',
                    url,
                    task: this.currentRaw,
                    normalizedTask: t
                }]);

                return !customEvent.isDefaultPrevented();
            }

            // ======================================
            // HANDLE ACTION
            // ======================================

            static handleAction(action) {

                const t = this.currentTask;

                if (!t || !action) return;

                const validity = this.getValidity(t);

                // Abrir consejos, validación y reglas.
                if (action === 'details' || action === 'participate') {

                    const extra = document.getElementById(
                        'yapita-task-modal-extra'
                    );

                    if (extra) {

                        const hasContent = [
                            t.helpers && t.helpers.length,
                            t.rules && t.rules.length,
                            t.validation
                        ].some(Boolean);

                        extra.hidden = !hasContent ? true : false;

                        if (hasContent) {
                            extra.scrollIntoView({
                                behavior: 'smooth',
                                block: 'nearest'
                            });
                        }
                    }

                    this.emitAction(action);
                    return;
                }

                // Consultar estado. No acredita puntos.
                if (action === 'status') {
                    this.emitAction('status');
                    return;
                }

                // Abrir perfil de la empresa.
                if (action === 'business') {

                    const url = typeof this.config.businessUrl === 'function'
                        ? this.config.businessUrl(t.businessId)
                        : '';

                    if (!this.emitAction('business', url)) return;

                    if (url) {
                        window.open(url, '_blank', 'noopener,noreferrer');
                    }

                    return;
                }

                // No permitir ejecución fuera de vigencia.
                if (!validity.canExecute) return;

                // Navegación física.
                if (action === 'map') {

                    if (!t.mapUrl) return;

                    if (!this.emitAction('map', t.mapUrl)) return;

                    window.open(
                        t.mapUrl,
                        '_blank',
                        'noopener,noreferrer'
                    );

                    return;
                }

                // Navegación digital.
                if (action === 'execute') {

                    if (!t.actionUrl) return;

                    if (!this.emitAction('execute', t.actionUrl)) return;

                    window.open(
                        t.actionUrl,
                        '_blank',
                        'noopener,noreferrer'
                    );
                }
            }
        }

        window.YapitaTaskModalUtil = YapitaTaskModalUtil;

    })(window, window.jQuery);

</script>
