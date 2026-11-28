<script id="shop-cart-utils">

    const ShopCartUtils = {

        toCents(value) {

            if (
                value == null ||
                String(value).trim() === ''
            ) {
                return null;
            }

            const amount = Number(value);

            if (!Number.isFinite(amount) || amount < 0) {
                return null;
            }

            return Math.round(amount * 100);

        },

        formatMoney(cents, currency = 'USD') {

            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: currency,
                minimumFractionDigits: 2
            }).format(cents / 100);

        },

        normalizePoints(value) {

            const points = Number(value);

            return Number.isFinite(points) && points > 0
                ? Math.floor(points)
                : 0;

        },

        calculateSummary(items = []) {

            const summary = items.reduce((result, item) => {

                const quantity = item.quantity;

                result.quantity += quantity;

                result.subtotalCents +=
                    item.originalPriceCents * quantity;

                result.totalCents +=
                    item.unitPriceCents * quantity;

                result.discountCents +=
                    (item.originalPriceCents - item.unitPriceCents) * quantity;

                result.points +=
                    item.points * quantity;

                return result;

            }, {

                quantity: 0,

                subtotalCents: 0,

                totalCents: 0,

                discountCents: 0,

                points: 0

            });

            return {

                ...summary,

                productCount: items.length,

                hasItems: items.length > 0,

                hasDiscount: summary.discountCents > 0,

                hasPoints: summary.points > 0

            };

        }

    };

</script>
<script id="shop-cart-computed">

    const ShopCartComputed = {

        cartItems() {

            return this.shopManager.cart.items;

        },

        cartSummary() {

            return ShopCartUtils.calculateSummary(
                this.cartItems
            );

        },

        cartQuantityText() {

            const quantity = this.cartSummary.quantity;

            const translations =
                this.shopManager.cart.translations;

            const label = quantity === 1
                ? translations.unit
                : translations.units;

            return `${quantity} ${label}`;

        },

        cartProductCountText() {

            const count = this.cartSummary.productCount;

            const translations =
                this.shopManager.cart.translations;

            const label = count === 1
                ? translations.item
                : translations.items;

            return `${count} ${label}`;

        },

        cartFooterVisible() {

            const config =
                this.shopManager.cart.config;

            return config.enabled && (
                this.cartSummary.hasItems ||
                config.showWhenEmpty
            );

        },

        orderWhatsAppNumber() {

            return this.getOrderWhatsAppNumber();

        },

        canSendShopOrder() {

            return this.cartSummary.hasItems &&
                Boolean(this.orderWhatsAppNumber);

        }

    };

</script>
<script id="shop-cart-methods">

    const ShopCartMethods = {
        onSendShopOrderClick(event) {

            if (!this.canSendShopOrder) {
                return;
            }

            const order = this.getShopOrderData();

            const message = this.buildShopOrderMessage(
                order
            );

            const whatsappUrl =
                `https://wa.me/${order.business.whatsapp}` +
                `?text=${encodeURIComponent(message)}`;

            const payload = {

                component: 'orderAside',

                action: 'send-whatsapp',

                order: order,

                message: message,

                whatsappUrl: whatsappUrl

            };

            this.emitShopEvent(

                'order:whatsapp:click',

                payload,

                event.currentTarget

            );

        },
        getShopOrderData() {

            const business =
                this.businessInformation.information;

            return {

                component: 'order',

                business: {

                    id: business.id,

                    name: business.title,

                    logo: business.source,

                    whatsapp: this.orderWhatsAppNumber

                },

                items: this.cartItems.map(item => ({

                    productId: item.id,

                    name: item.name,

                    code: item.code,

                    quantity: item.quantity,

                    unitPriceCents: item.unitPriceCents,

                    originalPriceCents:
                    item.originalPriceCents,

                    discountPercentage:
                    item.discountPercentage,

                    discountCents:
                        this.getCartItemDiscount(item),

                    totalCents:
                        this.getCartItemTotal(item),

                    pointsPerUnit: item.points,

                    totalPoints:
                        this.getCartItemPoints(item),

                    tax: item.tax

                })),

                summary: {

                    ...this.cartSummary

                },

                notes: this.shopManager.orderAside.notes,

                source: 'WEB_SHOP',

                channel: 'WHATSAPP',

                pageUrl: window.location.href,

                currency:
                this.shopManager.cart.config.currency

            };

        },

        getOrderWhatsAppNumber() {

            const businessData =
                $dataManagerPage.dataBusinessInformation.businessData || {};

            const phoneCode = String(
                businessData.phone_code || ''
            ).replace(/\D/g, '');

            const rawPhone = String(
                businessData.phone_value || ''
            ).trim();

            let phone = rawPhone.replace(/\D/g, '');

            if (!phone) {
                return null;
            }

            // INTERNATIONAL NUMBER

            if (rawPhone.startsWith('+')) {

                return /^[1-9]\d{6,14}$/.test(phone)
                    ? phone
                    : null;

            }

            // INTERNATIONAL PREFIX 00

            if (phone.startsWith('00')) {

                phone = phone.substring(2);

                return /^[1-9]\d{6,14}$/.test(phone)
                    ? phone
                    : null;

            }

            // COUNTRY CODE

            if (!phoneCode) {
                return null;
            }

            if (!phone.startsWith(phoneCode)) {

                phone = phoneCode +
                    phone.replace(/^0+/, '');

            }

            return /^[1-9]\d{6,14}$/.test(phone)
                ? phone
                : null;

        },
        getShopOrderAsideElement() {

            return document.getElementById(
                'shop-order-aside'
            );

        },

        mountShopOrderAside() {

            const element =
                this.getShopOrderAsideElement();

            if (!element) {
                return;
            }

            if (element.parentElement !== document.body) {

                document.body.appendChild(element);

            }

        },

        openShopOrderAside() {

            if (!this.cartSummary.hasItems) {
                return;
            }

            this.$nextTick(() => {

                this.mountShopOrderAside();

                const element =
                    this.getShopOrderAsideElement();

                if (!element) {
                    return;
                }

                const instance =
                    bootstrap.Offcanvas.getOrCreateInstance(
                        element,
                        {
                            backdrop: true,
                            keyboard: true,
                            scroll: false
                        }
                    );

                instance.show();

                const backdrops = document.querySelectorAll(
                    '.offcanvas-backdrop'
                );

                const backdrop =
                    backdrops[backdrops.length - 1];

                if (backdrop) {

                    backdrop.classList.add(
                        'shop-order-aside-backdrop'
                    );

                }

            });

        },

        closeShopOrderAside() {

            const element =
                this.getShopOrderAsideElement();

            if (!element) {
                return;
            }

            const instance =
                bootstrap.Offcanvas.getInstance(element);

            if (instance) {

                instance.hide();

            }

        },

        initShopOrderAsideEvents() {

            const vm = this;

            const element =
                this.getShopOrderAsideElement();

            if (!element) {
                return;
            }

            const namespace = '.shopOrderAside';

            const $aside = $(element);

            $aside.off(namespace);

            // BEFORE OPEN

            $aside.on(

                'show.bs.offcanvas' + namespace,

                function () {

                    vm.shopManager.orderAside.visible = true;

                    vm.setShopScrollLock(true);

                }

            );

            // AFTER OPEN

            $aside.on(

                'shown.bs.offcanvas' + namespace,

                function () {

                    vm.emitShopEvent(

                        'order:opened',

                        vm.getShopOrderData(),

                        element

                    );

                }

            );

            // AFTER CLOSE

            $aside.on(

                'hidden.bs.offcanvas' + namespace,

                function () {

                    vm.shopManager.orderAside.visible = false;

                    if (!vm.shopManager.businessAside.visible) {

                        vm.setShopScrollLock(false);

                    }

                    vm.emitShopEvent(

                        'order:closed',

                        vm.getShopOrderData(),

                        element

                    );

                }

            );

        },

        destroyShopOrderAsideEvents() {

            const element =
                this.getShopOrderAsideElement();

            if (!element) {
                return;
            }

            const instance =
                bootstrap.Offcanvas.getInstance(element);

            $(element).off('.shopOrderAside');

            if (instance) {

                if (element.classList.contains('show')) {

                    element.addEventListener(
                        'hidden.bs.offcanvas',
                        function () {

                            instance.dispose();

                            element.remove();

                        },
                        { once: true }
                    );

                    instance.hide();

                } else {

                    instance.dispose();

                    element.remove();

                }

            } else {

                element.remove();

            }

        },
        onShopCartFooterClick(event) {

            if (!this.cartSummary.hasItems) {
                return;
            }

            const payload = {

                component: 'cartFooter',

                action: 'open-order',

                businessId:
                this.businessInformation.information.id,

                items: this.cartItems.map(
                    item => ({ ...item })
                ),

                summary: {
                    ...this.cartSummary
                }

            };

            this.emitShopEvent(

                'cart:open',

                payload,

                event.currentTarget

            );

        },
        initShopCartEvents() {

            const vm = this;

            const namespace = '.shopCart';

            const events = {
                'shop:order:whatsapp:click': function (payload) {

                    if (!payload.whatsappUrl) {
                        return;
                    }

                    window.open(

                        payload.whatsappUrl,

                        '_blank',

                        'noopener,noreferrer'

                    );

                },
                'shop:catalog:product:add': function (payload) {

                    vm.addProductToCart(
                        payload.product
                    );

                },

                'shop:catalog:product:increase': function (payload) {

                    vm.increaseCartQuantity(
                        payload.productId
                    );

                },

                'shop:catalog:product:decrease': function (payload) {

                    vm.decreaseCartQuantity(
                        payload.productId
                    );

                },

                'shop:cart:open': function () {

                    vm.openShopOrderAside();

                }

            };

            $(document).off(namespace);

            Object.entries(events).forEach(([eventName, handler]) => {

                $(document).on(

                    eventName + namespace,

                    function (event) {

                        const payload =
                            event.originalEvent?.detail || {};

                        handler(payload);

                    }

                );

            });

        },

        destroyShopCartEvents() {

            $(document).off('.shopCart');

        },
        syncCatalogCartControls(productId = null) {

            const vm = this;

            const gridInit = $(
                this.gridConfig.selectorCurrent
            );

            if (!gridInit.length) {
                return;
            }

            let $cards = gridInit.find(
                '.shop-product-card'
            );

            if (productId !== null) {

                $cards = $cards.filter(function () {

                    return String(
                        $(this).attr('data-product-id')
                    ) === String(productId);

                });

            }

            $cards.each(function () {

                const $card = $(this);

                const currentId =
                    $card.attr('data-product-id');

                const productName = $card
                    .find('.shop-product-card__name-action')
                    .text()
                    .trim();

                const quantity =
                    vm.getCartQuantity(currentId);

                $card.toggleClass(
                    'shop-product-card--in-cart',
                    quantity > 0
                );

                $card.find(
                    '.shop-product-card__actions'
                ).html(

                    vm.renderCartProductControl(
                        currentId,
                        productName
                    )

                );

            });

            // Los botones anteriores fueron reemplazados.
            // Debemos registrar nuevamente sus eventos.

            this.bindProductCardEvents(gridInit);

        },
        renderCartProductControl(productId, productName = '') {

            const quantity = this.getCartQuantity(productId);

            const escape = value =>
                this.escapeProductHtml(value);

            const translations =
                this.shopManager.cart.translations;

            if (quantity === 0) {

                return `

            <button
                type="button"
                class="shop-product-card__add"
                data-action="add"
                aria-label="${escape(
                    translations.add + ' ' + productName
                )}"
                title="${escape(translations.add)}"
            >

                <i
                    class="bi bi-plus-circle"
                    aria-hidden="true"
                ></i>

            </button>

        `;

            }

            return `

        <div class="shop-product-card__quantity">

            <button
                type="button"
                class="
                    shop-product-card__quantity-button
                    shop-product-card__quantity-button--decrease
                "
                data-action="decrease"
                aria-label="${escape(translations.decrease)}"
            >

                <i class="bi bi-dash-lg"></i>

            </button>

            <span
                class="shop-product-card__quantity-value"
                aria-live="polite"
            >
                ${quantity}
            </span>

            <button
                type="button"
                class="
                    shop-product-card__quantity-button
                    shop-product-card__quantity-button--increase
                "
                data-action="increase"
                aria-label="${escape(translations.increase)}"
                ${quantity >= this.shopManager.cart.config.maxQuantity
                ? 'disabled'
                : ''}
            >

                <i class="bi bi-plus-lg"></i>

            </button>

        </div>

    `;

        },

        formatCartMoney(cents) {

            return ShopCartUtils.formatMoney(
                cents,
                this.shopManager.cart.config.currency
            );

        },

        normalizeCartProduct(product) {

            if (
                !product ||
                product.id == null ||
                product.id === ''
            ) {
                return null;
            }

            const price = this.getProductPriceInformation(
                product.price
            );

            if (!price.hasPrice) {
                return null;
            }

            const unitPriceCents =
                ShopCartUtils.toCents(price.current);

            if (unitPriceCents === null) {
                return null;
            }

            const oldPriceCents = price.hasDiscount
                ? ShopCartUtils.toCents(price.old)
                : unitPriceCents;

            const originalPriceCents = Math.max(
                unitPriceCents,
                oldPriceCents ?? unitPriceCents
            );

            return {

                id: String(product.id),

                businessId: this.businessInformation.information.id,

                name: product.name ||
                    this.shopManager.catalog.translations.noName,

                code: product.code || '',

                category: product.category || '',

                subcategory: product.subcategory || '',

                image: this.getProductImage(
                    product.source,
                    this.shopManager.catalog.card.fallbackImage
                ),

                quantity: 1,

                unitPriceCents: unitPriceCents,

                originalPriceCents: originalPriceCents,

                discountPercentage: price.discount,

                hasDiscount: price.hasDiscount,

                points: ShopCartUtils.normalizePoints(
                    product.points
                ),

                tax: this.getProductTaxInformation(
                    product.tax
                ),

                raw: product

            };

        },

        getCartItem(productId) {

            return this.cartItems.find(
                item => item.id === String(productId)
            ) || null;

        },

        getCartQuantity(productId) {

            const item = this.getCartItem(productId);

            return item ? item.quantity : 0;

        },

        addProductToCart(product) {

            if (!this.shopManager.cart.config.enabled) {
                return false;
            }

            const normalized = this.normalizeCartProduct(
                product
            );

            if (!normalized) {

                console.warn(
                    'ShopCart: invalid product or price',
                    product
                );

                return false;

            }

            const existing = this.getCartItem(
                normalized.id
            );

            if (existing) {

                return this.setCartItemQuantity(
                    existing.id,
                    existing.quantity + 1
                );

            }

            this.shopManager.cart.items.push(normalized);

            this.notifyCartChanged(
                'add',
                normalized
            );

            return true;

        },

        setCartItemQuantity(productId, quantity) {

            const item = this.getCartItem(productId);

            if (!item) {
                return false;
            }

            const value = Number(quantity);

            if (!Number.isSafeInteger(value)) {
                return false;
            }

            if (value <= 0) {

                return this.removeProductFromCart(
                    productId
                );

            }

            const maxQuantity =
                this.shopManager.cart.config.maxQuantity;

            if (value > maxQuantity) {
                return false;
            }

            item.quantity = value;

            this.notifyCartChanged(
                'update',
                item
            );

            return true;

        },

        increaseCartQuantity(productId) {

            const quantity = this.getCartQuantity(
                productId
            );

            return this.setCartItemQuantity(
                productId,
                quantity + 1
            );

        },

        decreaseCartQuantity(productId) {

            const quantity = this.getCartQuantity(
                productId
            );

            return this.setCartItemQuantity(
                productId,
                quantity - 1
            );

        },

        removeProductFromCart(productId) {

            const index = this.cartItems.findIndex(
                item => item.id === String(productId)
            );

            if (index === -1) {
                return false;
            }

            const removedItem =
                this.shopManager.cart.items.splice(index, 1)[0];

            this.notifyCartChanged(
                'remove',
                removedItem
            );

            return true;

        },

        clearShopCart() {

            this.shopManager.cart.items = [];

            this.shopManager.orderAside.notes = '';

            this.notifyCartChanged(
                'clear'
            );

        },

        getCartItemTotal(item) {

            return item.unitPriceCents * item.quantity;

        },

        getCartItemPoints(item) {

            return item.points * item.quantity;

        },

        getCartItemDiscount(item) {

            return (
                item.originalPriceCents -
                item.unitPriceCents
            ) * item.quantity;

        },

        notifyCartChanged(action, item = null) {

            this.shopManager.orderAside.error = '';

            // Actualizar las tarjetas de Bootgrid.
            this.syncCatalogCartControls(
                item ? item.id : null
            );

            this.emitShopEvent(

                'cart:changed',

                {
                    component: 'cart',

                    action: action,

                    item: item ? { ...item } : null,

                    items: this.cartItems.map(
                        item => ({ ...item })
                    ),

                    summary: {
                        ...this.cartSummary
                    }

                },

                this.$el

            );

        },
        buildShopOrderMessage(order) {

            const money = cents => this.formatCartMoney(cents);

            const { business, items, summary, notes, pageUrl } = order;

            const lines = [
                `🛒 *NUEVO PEDIDO - ${business.name}*`,
                '',
                '¡Hola! Deseo realizar el siguiente pedido:',
                '',
                '📋 *DETALLE DEL PEDIDO*',
                ''
            ];

            items.forEach((item, index) => {

                lines.push(
                    `*${index + 1}. ${item.name}*`,
                    `Cantidad: ${item.quantity}`,
                    `Precio unitario: ${money(item.unitPriceCents)}`
                );

                if (item.discountCents > 0) {

                    lines.push(
                        `Precio anterior: ${money(item.originalPriceCents)}`,
                        `Descuento: ${item.discountPercentage}%`,
                        `Ahorro: ${money(item.discountCents)}`
                    );

                }

                lines.push(
                    `Subtotal: ${money(item.totalCents)}`
                );

                if (item.totalPoints > 0) {

                    lines.push(
                        `🪙 Yapitas estimadas: +${item.totalPoints}`
                    );

                }

                lines.push('');

            });

            // ==========================================
            // ORDER SUMMARY
            // ==========================================

            lines.push(
                '━━━━━━━━━━━━━━━━━━',
                '*RESUMEN DEL PEDIDO*',
                '',
                `Productos diferentes: ${summary.productCount}`,
                `Total de unidades: ${summary.quantity}`,
                `Subtotal original: ${money(summary.subtotalCents)}`
            );

            if (summary.hasDiscount) {

                lines.push(
                    `Descuentos: -${money(summary.discountCents)}`
                );

            }

            lines.push(
                '',
                `💰 *TOTAL ESTIMADO: ${money(summary.totalCents)}*`
            );

            if (summary.hasPoints) {

                lines.push(
                    `🪙 *Yapitas estimadas: +${summary.points}*`
                );

            }

            // ==========================================
            // ORDER NOTES
            // ==========================================

            if (notes && notes.trim()) {

                lines.push(
                    '',
                    '📝 *OBSERVACIONES*',
                    notes.trim()
                );

            }

            // ==========================================
            // CONFIRMATION
            // ==========================================

            lines.push(
                '',
                '━━━━━━━━━━━━━━━━━━',
                '',
                'Por favor, confirmar disponibilidad, precio final y forma de pago.',
                '',
                '💙 Pedido generado desde *Yapita*.'
            );

            if (pageUrl) {

                lines.push('', pageUrl);

            }

            return lines.join('\n');

        },

    };

</script>
