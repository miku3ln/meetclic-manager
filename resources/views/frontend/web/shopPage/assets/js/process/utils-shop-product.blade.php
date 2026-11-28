<script id="shop-product-methods">

    const ShopProductMethods = {
        syncShopAsideScrollLock() {

            const manager = this.shopManager;

            const isLocked = Boolean(

                manager.businessAside.visible ||

                manager.orderAside.visible ||

                manager.productAside.visible

            );

            this.setShopScrollLock(isLocked);

        },
        destroyShopProductAsideEvents() {
            this.clearShopProductFeedback();
            $(document).off('.shopProductAside');

            const element =
                this.getShopProductAsideElement();

            if (!element) {
                return;
            }

            const instance =
                bootstrap.Offcanvas.getInstance(element);

            $(element).off('.shopProductAside');

            $(element).off('.shopProductBusiness');

            if (!instance) {

                element.remove();

                return;

            }

            if (element.classList.contains('show')) {

                element.addEventListener(

                    'hidden.bs.offcanvas',

                    function () {

                        vm.shopManager.productAside.visible = false;

                        vm.clearShopProductFeedback();

                        vm.syncShopAsideScrollLock();

                        vm.emitShopProductAction(
                            'product:closed'
                        );

                    },

                    {
                        once: true
                    }

                );

                instance.hide();

            } else {

                instance.dispose();

                element.remove();

            }

        },
        initShopProductAsideEvents() {

            const vm = this;

            const namespace = '.shopProductAside';

            const events = {

                // ==========================================
                // OPEN PRODUCT FROM CATALOG
                // ==========================================

                'shop:catalog:product:click': function (payload) {

                    vm.openShopProductAside(
                        payload.product
                    );

                },

                // ==========================================
                // ADD PRODUCT TO CART
                // ==========================================

                'shop:product:cart:quantity:change': function (payload) {

                    vm.handleShopProductCartQuantityChange(
                        payload
                    );

                },

                // ==========================================
                // SHARE PRODUCT
                // ==========================================

                'shop:product:share:whatsapp': function (payload) {

                    if (!payload.whatsappUrl) {
                        return;
                    }

                    window.open(

                        payload.whatsappUrl,

                        '_blank',

                        'noopener,noreferrer'

                    );

                },

                // ==========================================
                // OPEN BUSINESS
                // ==========================================

                'shop:product:business:click': function () {

                    vm.openBusinessFromProductAside();

                },

                // ==========================================
                // PROMOTION
                // ==========================================

                'shop:product:promotion:click': function (payload) {

                    console.log(

                        'ShopProduct: promotion selected',

                        payload

                    );

                    // TODO: CONNECT PROMOTION DETAIL

                }

            };

            $(document).off(namespace);

            Object.entries(events).forEach(

                ([eventName, handler]) => {

                    $(document).on(

                        eventName + namespace,

                        function (event) {

                            const payload =
                                event.originalEvent?.detail || {};

                            handler(payload);

                        }

                    );

                }

            );

            // ==============================================
            // BOOTSTRAP OFFCANVAS EVENTS
            // ==============================================

            const element =
                this.getShopProductAsideElement();

            if (!element) {
                return;
            }

            const $aside = $(element);

            $aside.off(namespace);


            // BEFORE OPEN

            $aside.on(

                'show.bs.offcanvas' + namespace,

                function () {

                    vm.shopManager.productAside.visible = true;

                    vm.setShopScrollLock(true);

                }

            );


            // AFTER OPEN

            $aside.on(

                'shown.bs.offcanvas' + namespace,

                function () {

                    vm.emitShopProductAction(
                        'product:opened'
                    );

                }

            );


            // AFTER CLOSE

            $aside.on(

                'hidden.bs.offcanvas' + namespace,

                function () {

                    vm.shopManager.productAside.visible = false;

                    vm.syncShopAsideScrollLock();

                    vm.emitShopProductAction(
                        'product:closed'
                    );

                }

            );

        },
        onShopProductBusinessClick() {

            this.emitShopProductAction(
                'product:business:click'
            );

        },

        openBusinessFromProductAside() {

            const element =
                this.getShopProductAsideElement();

            if (

                element &&
                this.shopManager.productAside.visible

            ) {

                $(element).one(

                    'hidden.bs.offcanvas.shopProductBusiness',

                    () => {

                        this.openShopBusinessAside(
                            this.getShopBusinessAsideData()
                        );

                    }

                );

                this.closeShopProductAside();

                return;

            }

            this.openShopBusinessAside(
                this.getShopBusinessAsideData()
            );

        },
        toggleShopProductPromotions() {

            this.productAsideState.promotionsExpanded =
                !this.productAsideState.promotionsExpanded;

            this.emitShopProductAction(

                'product:promotions:toggle',

                {
                    expanded:
                    this.productAsideState.promotionsExpanded
                }

            );

        },

        onShopProductPromotionClick(promotion) {

            if (!promotion) {
                return;
            }

            this.emitShopProductAction(

                'product:promotion:click',

                {
                    promotion
                }

            );

        },
        getProductFavoriteKey(productId) {

            const businessId =
                this.businessInformation.information.id;

            return `${businessId}:${productId}`;

        },

        toggleShopProductFavorite() {

            const product = this.productAsideData;

            if (!product) {
                return;
            }

            const key = this.getProductFavoriteKey(
                product.id
            );

            const favorites =
                this.shopManager.productAside.favorites;

            const index = favorites.indexOf(key);

            const isFavorite = index === -1;

            if (isFavorite) {

                favorites.push(key);

            } else {

                favorites.splice(index, 1);

            }

            this.emitShopProductAction(

                'product:favorite:changed',

                {
                    isFavorite
                }

            );

        },
        getShopProductShareData() {

            const product = this.productAsideData;

            if (!product) {
                return null;
            }

            return {

                productId: product.id,

                title: `Descubre ${product.name} en Yapita`,

                description: product.description,

                business: product.business.name,

                price: product.price.hasPrice

                    ? this.formatCartMoney(
                        product.price.currentCents
                    )

                    : '',

                points: product.points,

                url: window.location.href

            };

        },

        buildShopProductShareMessage(share) {

            const lines = [

                `🛍️ *${share.title}*`,

                '',

                `Encuéntralo en ${share.business}.`

            ];

            if (share.description) {

                lines.push('', share.description);

            }

            if (share.price) {

                lines.push('', `Precio: ${share.price}`);

            }

            if (share.points > 0) {

                lines.push(

                    `🪙 Puedes ganar ${share.points} Yapitas por unidad.`

                );

            }

            lines.push(

                '',

                'Descubre más en Yapita:',

                share.url

            );

            return lines.join('\n');

        },

        onShareShopProductClick() {

            const share = this.getShopProductShareData();

            if (!share) {
                return;
            }

            const message =
                this.buildShopProductShareMessage(share);

            const whatsappUrl =
                `https://wa.me/?text=${encodeURIComponent(message)}`;

            this.emitShopProductAction(

                'product:share:whatsapp',

                {

                    share,

                    message,

                    whatsappUrl

                }

            );

        },
        emitShopProductAction(eventName, extra = {}) {

            const product = this.productAsideData;

            if (!product) {
                return;
            }

            const payload = {

                component: 'productAside',

                action: eventName,

                productId: product.id,

                businessId: product.business.id,

                business: this.businessInformation,

                product: product.raw,

                detail: product,

                quantity: this.productAsideQuantity,

                ...extra

            };

            this.emitShopEvent(

                eventName,

                payload,

                this.getShopProductAsideElement() || this.$el

            );

        },



        setShopProductQuantity(quantity) {

            const product = this.productAsideData;

            if (!product) {
                return false;
            }

            const nextQuantity = Number(quantity);

            const currentQuantity = this.productAsideCartQuantity;

            const maxQuantity =
                this.shopManager.cart.config.maxQuantity;

            if (

                !Number.isSafeInteger(nextQuantity) ||

                nextQuantity < 0 ||

                nextQuantity > maxQuantity

            ) {

                return false;

            }

            if (currentQuantity === nextQuantity) {
                return true;
            }

            const payload = {

                previousQuantity: currentQuantity,

                nextQuantity: nextQuantity,

                difference: nextQuantity - currentQuantity

            };

            this.emitShopProductAction(

                'product:cart:quantity:change',

                payload

            );

            return true;

        },

        increaseShopProductQuantity() {

            if (!this.canAddProductAsideToCart) {
                return;
            }

            this.setShopProductQuantity(

                this.productAsideCartQuantity + 1

            );

        },
        decreaseShopProductQuantity() {

            if (!this.canRemoveProductAsideFromCart) {
                return;
            }

            this.setShopProductQuantity(

                this.productAsideCartQuantity - 1

            );

        },
        handleShopProductCartQuantityChange(payload) {

            const product = this.productAsideData;

            if (!product || !payload?.product) {
                return false;
            }

            if (String(payload.productId) !== String(product.id)) {
                return false;
            }

            const currentQuantity = this.getCartQuantity(product.id);

            const nextQuantity = Number(payload.nextQuantity);

            const maxQuantity = this.shopManager.cart.config.maxQuantity;

            // VALIDATE QUANTITY

            if (
                !Number.isSafeInteger(nextQuantity) ||
                nextQuantity < 0 ||
                nextQuantity > maxQuantity
            ) {
                return false;
            }

            if (currentQuantity === nextQuantity) {
                return true;
            }

            // VALIDATE ADDITION

            if (
                nextQuantity > currentQuantity &&
                !this.canAddProductAsideToCart
            ) {

                this.productAsideState.error =
                    this.productAsideTranslations.unavailable;

                return false;

            }

            let success = false;

            let action = '';

            // REMOVE PRODUCT

            if (nextQuantity === 0) {

                success = this.removeProductFromCart(product.id);

                action = 'remove';

            }

            // ADD PRODUCT

            else if (currentQuantity === 0) {

                success = this.addProductToCart(
                    product.raw,
                    nextQuantity
                );

                action = 'add';

            }

            // UPDATE PRODUCT

            else {

                success = this.setCartItemQuantity(
                    product.id,
                    nextQuantity
                );

                action = 'update';

            }

            // VALIDATE RESULT

            if (!success) {

                this.productAsideState.error =
                    this.productAsideTranslations.unavailable;

                return false;

            }

            this.productAsideState.error = '';

            this.showShopProductCartFeedback(action);

            return true;

        },
        showShopProductCartFeedback(action) {

            this.clearShopProductFeedback();

            const translations =
                this.productAsideTranslations;

            const messages = {

                add: translations.cartAdded,

                update: translations.cartUpdated,

                remove: translations.cartRemoved

            };

            this.productAsideState.feedback = {

                visible: true,

                type: action === 'remove'
                    ? 'info'
                    : 'success',

                message: messages[action] ||
                    translations.cartUpdated

            };

            this._shopProductFeedbackTimer = setTimeout(() => {

                this.productAsideState.feedback.visible = false;

                this._shopProductFeedbackTimer = null;

            }, 2000);

        },
        setShopProductImage(index) {

            const gallery =
                this.productAsideData?.gallery || [];

            if (

                !Number.isInteger(index) ||

                index < 0 ||

                index >= gallery.length

            ) {

                return;

            }

            this.productAsideState.activeImageIndex = index;

            this.emitShopProductAction(

                'product:gallery:change',

                {
                    index,

                    image: gallery[index]
                }

            );

        },

        nextShopProductImage() {

            const gallery =
                this.productAsideData?.gallery || [];

            if (gallery.length <= 1) {
                return;
            }

            const index = (

                this.productAsideState.activeImageIndex + 1

            ) % gallery.length;

            this.setShopProductImage(index);

        },

        previousShopProductImage() {

            const gallery =
                this.productAsideData?.gallery || [];

            if (gallery.length <= 1) {
                return;
            }

            const index = (

                this.productAsideState.activeImageIndex -
                1 +
                gallery.length

            ) % gallery.length;

            this.setShopProductImage(index);

        },
        getShopProductAsideElement() {

            return document.getElementById(
                'shop-product-aside'
            );

        },

        mountShopProductAside() {

            const element =
                this.getShopProductAsideElement();

            if (!element) {
                return;
            }

            if (element.parentElement !== document.body) {

                document.body.appendChild(element);

            }

        },
        clearShopProductFeedback() {

            if (this._shopProductFeedbackTimer) {

                clearTimeout(
                    this._shopProductFeedbackTimer
                );

                this._shopProductFeedbackTimer = null;

            }

            if (this.productAsideState.feedback) {

                this.productAsideState.feedback.visible = false;

            }

        },
        resetShopProductAsideState() {

            this.clearShopProductFeedback();

            this.shopManager.productAside.state = {

                activeImageIndex: 0,

                promotionsExpanded: false,

                feedback: {

                    visible: false,

                    type: 'success',

                    message: ''

                },

                error: ''

            };

        },

        openShopProductAside(row) {

            if (!this.productAsideConfig.enabled) {
                return;
            }

            const product = this.getShopProductAsideData(row);

            if (!product) {
                return;
            }

            this.resetShopProductAsideState();

            this.shopManager.productAside.data = product;


            this.$nextTick(() => {

                this.mountShopProductAside();

                const element =
                    this.getShopProductAsideElement();

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
                        'shop-product-aside-backdrop'
                    );

                }

            });

        },

        closeShopProductAside() {

            const element =
                this.getShopProductAsideElement();

            if (!element) {
                return;
            }

            const instance =
                bootstrap.Offcanvas.getInstance(element);

            if (instance) {

                instance.hide();

            }

        },
        getShopProductAsideData(row) {

            if (!row || row.id == null || row.id === '') {
                return null;
            }

            const config = this.productAsideConfig;

            const price = this.getProductPriceInformation(
                row.price
            );

            const tax = this.getProductTaxInformation(
                row.tax
            );

            const currentCents = price.hasPrice

                ? ShopCartUtils.toCents(price.current)

                : null;

            const oldCents = price.hasDiscount

                ? ShopCartUtils.toCents(price.old)

                : currentCents;

            const fallbackImage =
                this.shopManager.catalog.card.fallbackImage;

            const image = this.getProductImage(
                row.source,
                fallbackImage
            );

            const gallery = ShopProductUtils.normalizeGallery(

                image,

                row.gallery || row.images || [],

                source => this.getProductImage(
                    source,
                    fallbackImage
                )

            );

            let promotions =
                ShopProductUtils.normalizePromotions(
                    row.promotions || []
                );

            // ==========================================
            // OPTIONAL DEMONSTRATION DATA
            // ==========================================

            if (config.useMockData && !promotions.length) {

                promotions = [

                    {
                        id: 'mock-promotion-1',

                        name: 'Promoción especial',

                        description:
                            'Ejemplo de una promoción asociada al producto.',

                        image: image,

                        priceCents: null,

                        discount: 0,

                        url: null,

                        isMock: true

                    }

                ];

            }

            // ==========================================
            // NORMALIZED PRODUCT
            // ==========================================

            return {

                id: String(row.id),

                name: row.name ||
                    this.shopManager.catalog.translations.noName,

                description: row.description || '',

                code: row.code || '',

                image: image,

                category: row.category || '',

                subcategory: row.subcategory || '',

                gallery: gallery,

                stock: {

                    quantity: row.stock?.quantity ?? null,

                    unit: row.stock?.unit || ''

                },

                price: {

                    ...price,

                    currentCents: currentCents,

                    oldCents: oldCents,

                    discountCents:
                        ShopProductUtils.getDiscountCents(
                            currentCents,
                            oldCents
                        )

                },

                tax: tax,

                points: ShopCartUtils.normalizePoints(
                    row.points
                ),

                promotions: promotions,

                business: {

                    id: this.businessInformation.information.id,

                    name: this.businessInformation.information.title,

                    logo: this.businessInformation.information.source,

                    category: this.businessInformation.category.title,

                    subcategory:
                    this.businessInformation.subcategory.title,

                    url: this.businessInformation.information.url

                },

                raw: row

            };

        }

        // ADD THE FOLLOWING METHODS HERE

    };

</script>
<script id="shop-product-utils">

    const ShopProductUtils = {

        normalizeGallery(source, gallery = [], resolveImage) {

            const images = [];

            const addImage = (item) => {

                const imageSource = typeof item === 'string'
                    ? item
                    : item?.source || item?.url || item?.image;

                if (!imageSource) {
                    return;
                }

                const image = resolveImage(imageSource);

                if (image && !images.includes(image)) {
                    images.push(image);
                }

            };

            addImage(source);

            if (Array.isArray(gallery)) {

                gallery.forEach(addImage);

            }

            return images.map((image, index) => ({

                id: index + 1,

                source: image

            }));

        },

        normalizePromotions(promotions = []) {

            if (!Array.isArray(promotions)) {
                return [];
            }

            return promotions

                .filter(item => item && typeof item === 'object')

                .map((item, index) => ({

                    id: item.id ?? index + 1,

                    name: item.name || item.title || '',

                    description: item.description || '',

                    image: item.source || item.image || '',

                    priceCents: ShopCartUtils.toCents(
                        item.price?.pv ?? item.price
                    ),

                    discount: Number(item.discount) || 0,

                    url: item.url || null,

                    isMock: item.isMock === true,

                    raw: item

                }))

                .filter(item => item.name);

        },

        getDiscountCents(current, old) {

            if (current === null || old === null) {
                return 0;
            }

            return Math.max(0, old - current);

        }

    };

</script>
<script id="shop-product-computed">

    const ShopProductComputed = {

        productAsideData() {

            return this.shopManager.productAside.data;

        },

        productAsideConfig() {

            return this.shopManager.productAside.config;

        },

        productAsideState() {

            return this.shopManager.productAside.state;

        },

        productAsideTranslations() {

            return this.shopManager.productAside.translations;

        },

        productAsideQuantity() {

            return this.productAsideCartQuantity;

        },
        productAsideActiveImage() {

            const product = this.productAsideData;

            if (!product || !product.gallery.length) {

                return this.shopManager.catalog.card.fallbackImage;

            }

            const index =
                this.productAsideState.activeImageIndex;

            return product.gallery[index]?.source ||
                product.gallery[0].source;

        },
        productAsideCartItem() {

            if (!this.productAsideData) {
                return null;
            }

            return this.getCartItem(
                this.productAsideData.id
            );

        },
        productAsideCartQuantity() {

            if (!this.productAsideData) {
                return 0;
            }

            return this.getCartQuantity(
                this.productAsideData.id
            );

        },

        productAsideRemainingQuantity() {

            return Math.max(

                0,

                this.shopManager.cart.config.maxQuantity -
                this.productAsideCartQuantity

            );

        },

        productAsideTotalCents() {

            const item = this.productAsideCartItem;

            return item
                ? this.getCartItemTotal(item)
                : 0;

        },
        productAsideDiscountCents() {

            const item = this.productAsideCartItem;

            return item
                ? this.getCartItemDiscount(item)
                : 0;

        },
        productAsideTotalPoints() {

            const item = this.productAsideCartItem;

            return item
                ? this.getCartItemPoints(item)
                : 0;

        },

        productAsideIsFavorite() {

            if (!this.productAsideData) {
                return false;
            }

            const key = this.getProductFavoriteKey(
                this.productAsideData.id
            );

            return this.shopManager.productAside.favorites.includes(
                key
            );

        },

        canAddProductAsideToCart() {

            const product = this.productAsideData;

            return Boolean(

                product &&

                product.price.hasPrice &&

                product.price.currentCents !== null &&

                this.shopManager.cart.config.enabled &&

                this.productAsideRemainingQuantity > 0

            );

        },
        canRemoveProductAsideFromCart() {

            return this.productAsideCartQuantity > 0;

        },
    };

</script>
