function initManagementEvents(params) {
    var sliderFinalWidth = 400,
        maxQuickWidth = 900;
    var typeEvent = params['type'];
    if (typeEvent == 'home') {

        $('.cd-trigger--manager-quick-view-home').on('click', function (event) {
            var selectorId = $(this).attr('id');
            var result = $(this).attr('data');
            var rowData = JSON.parse(result);

            updateViewQuick({
                data: rowData,
                typeEvent: typeEvent
            });

            event.preventDefault();
            var selectedImage = $(this).closest('.single-grid-product, .single-list-product').find('.single-grid-product__image .image-wrap, .single-list-product__image .image-wrap').children('img').eq(0),
                id = $(this).attr('href'),
                slectedImageUrl = selectedImage.attr('src');
            $('body').addClass('overlay-layer');
            animateQuickViewManager(id, selectedImage, sliderFinalWidth, maxQuickWidth, 'open');
        });
    } else if (typeEvent == 'shopEvents') {
        $('.cd-trigger--manager-quick-view').on('click', function (event) {
            var selectorId = $(this).attr('id').split('-')[1];
            var rowData = getValueCurrentRow({
                currentId: selectorId
            });
            updateViewQuick({
                data: rowData ? rowData[0] : null,
                typeEvent: typeEvent
            });

            event.preventDefault();
            var selectedImage = $(this).closest('.single-grid-product, .single-list-product').find('.single-grid-product__image .image-wrap, .single-list-product__image .image-wrap').children('img').eq(0),
                id = $(this).attr('href'),
                slectedImageUrl = selectedImage.attr('src');

            $('body').addClass('overlay-layer');
            animateQuickViewManager(id, selectedImage, sliderFinalWidth, maxQuickWidth, 'open');

        });
    }
}

/*Open Quick View*/
function animateQuickViewManager(id, image, finalWidth, maxQuickWidth, animationType) {
    //store some image data (width, top position, ...)
    //store window data to calculate quick view panel position
    var parentListItem = image.parent('.image-wrap'),
        topSelected = image.offset().top - $(window).scrollTop(),
        leftSelected = image.offset().left,
        widthSelected = image.width(),
        heightSelected = image.height(),
        windowWidth = $(window).width(),
        windowHeight = $(window).height(),
        finalLeft = (windowWidth - finalWidth) / 2,
        finalHeight = finalWidth * heightSelected / widthSelected,
        finalTop = (windowHeight - finalHeight) / 2,
        quickViewWidth = (windowWidth * .8 < maxQuickWidth) ? windowWidth * .8 : maxQuickWidth,
        quickViewLeft = (windowWidth - quickViewWidth) / 2;

    if (animationType == 'open') {
        //hide the image in the gallery
        parentListItem.addClass('empty-box');
        //place the quick view over the image gallery and give it the dimension of the gallery image
        $(id).css({
            "top": topSelected,
            "left": leftSelected,
            "width": widthSelected,
        }).velocity({
            //animate the quick view: animate its width and center it in the viewport
            //during this animation, only the slider image is visible
            'top': finalTop + 'px',
            'left': finalLeft + 'px',
            'width': finalWidth + 'px',
        }, 1000, [400, 20], function () {
            //animate the quick view: animate its width to the final value
            $(id).addClass('animate-width').velocity({
                'left': quickViewLeft + 'px',
                'width': quickViewWidth + 'px',
            }, 300, 'ease', function () {
                //show quick view content
                $(id).addClass('add-content');
            });
        }).addClass('is-visible');
    } else {
        //close the quick view reverting the animation
        $(id).removeClass('add-content').velocity({
            'top': finalTop + 'px',
            'left': finalLeft + 'px',
            'width': finalWidth + 'px',
        }, 300, 'ease', function () {
            $('body').removeClass('overlay-layer');
            $(id).removeClass('animate-width').velocity({
                "top": topSelected,
                "left": leftSelected,
                "width": widthSelected,
            }, 500, 'ease', function () {
                $(id).removeClass('is-visible');
                parentListItem.removeClass('empty-box');
            });
        });
    }
}

function updateViewQuick(params) {
    var typeEvent = params.hasOwnProperty('typeEvent') ? params['typeEvent'] : null;
    var selectorsConfig = {
        'title': '#item-title',
        'date-init': '#item-title-date-init',
        'date-end': '#item-title-date-end',

        'price': {
            'main': '#main-price',
            'discount': '#discounted-price',
            'discount-wrapper': '#product-badge-wrapper',
            'discount-percentage': '#product-badge-wrapper__percentage',
            'discount-percentage-hot': '#product-badge-wrapper__wrapper__hot',

        },
        variants: {
            'color-content': '.product-color',
            'color-items': '.product-color__items',
            'size-content': '.product-size',
            'size-items': '.product-size__items',

        },
        'description': '#description',
        'codec': '#quickview-value-codec',
        'type': '#quickview-value-type',
        'teams': '#quickview-value-teams',
        'categories': '#quickview-value-categories',
        'kit': '#quickview-value-kit',
        'distances': '#quickview-value-distances',

        multimedia:
            {
                'data': '.cd-slider',
                slider: '.cd-slider-pagination'
            }

        , buttons: {
            'add-cart': '#add-cart-preview',
            'wish-list': '.add-wish-list--view-quick'
        },
        'business': {
            'title': '#onsale'
        }
    };
    var data = params.data;
    if (data) {
        $(selectorsConfig.business['title']).html('');
        $(selectorsConfig.business['title']).html(data.business);

        $(selectorsConfig['date-init']).html('');
        var dateSet='Inicio de Inscripciones : '+data.date_init_project;
        $(selectorsConfig['date-init']).html(dateSet);
        $(selectorsConfig['date-end']).html('');
         dateSet='Fecha maxima de inscripcion : '+data.date_end_project;
        $(selectorsConfig['date-end']).html(dateSet);

        $languageCurrent = $language == 'es' ? null : $language;

        var nameProduct = $languageCurrent == null ? data['name'] : (data.hasOwnProperty('name_lang') && data['name_lang'] ? data['name_lang'] : data['name']);
        nameProduct = nameProduct + (' - ' + data.id);
        var descriptionProduct = $languageCurrent == null ? data['description'] : (data.hasOwnProperty('description_lang') && data['description_lang'] ? data['description_lang'] : data['description']);

        //price
        var allowDiscount = false;
        var price_before = null;
        var price_discount = null;
        var allow_discount = 0;
        var promotion_id = null;
        var priceCurrent = 0;
        var measure_id = -1;
        var measure = "";
        var product = data;
        var valueCurrent = data.hasOwnProperty('sale') ? data['price'] : (data.hasOwnProperty('sale_price') ? parseFloat(data['sale_price']) : 0);
        if (product.business_by_discount_id) {

        } else {
            priceCurrent = data.hasOwnProperty('sale') ? data['price'] : (data.hasOwnProperty('sale_price') ? parseFloat(data['sale_price']) : 0)
        }

        var price = valueCurrent;
        $(selectorsConfig.price.main).removeClass('discounted');
        $(selectorsConfig.price.main).html('$' + price);
        if (allowDiscount) {
            $(selectorsConfig.price.main).addClass('discounted');
            $(selectorsConfig.price.discount).removeClass('not-view');

            $(selectorsConfig.price['discount-wrapper']).removeClass('not-view');

            $(selectorsConfig.price.discount).html('$' + priceCurrent);
            var business_by_discount_value = "-" + parseFloat(product.business_by_discount_value) + ' %';
            $(selectorsConfig.price['discount-percentage']).html(business_by_discount_value);


        } else {
            $(selectorsConfig.price['discount-wrapper']).addClass('not-view');
            $(selectorsConfig.price.discount).addClass('not-view');
        }


        $(selectorsConfig.buttons['add-cart']).attr("product-id", data.id);
        $(selectorsConfig.buttons['wish-list']).attr("product-id", data.id);
        var wishListClass = data.product_id_whishlist ? 'favorite-icon-active' : '';
        if (!$(selectorsConfig.buttons['wish-list']).hasClass(wishListClass)) {

            $(selectorsConfig.buttons['wish-list']).addClass(wishListClass);
        }
        if ($(selectorsConfig.buttons['wish-list']).attr('change') == 'true') {
            $(selectorsConfig.buttons['wish-list']).removeClass('favorite-icon-active');
        } else if ($(selectorsConfig.buttons['wish-list']).attr('change') == 'false') {
            $(selectorsConfig.buttons['wish-list']).addClass('favorite-icon-active');
        }
        $(selectorsConfig.title).html("");

        $(selectorsConfig.title).html(nameProduct);

        $(selectorsConfig.description).html("");
        $(selectorsConfig.description).html(descriptionProduct);


        $(selectorsConfig.type).html("");
        $(selectorsConfig.type).html(data.events_trails_types);

        $(selectorsConfig.codec).html("");

        $(selectorsConfig['codec']).html(data.business);
        var multimedia = data.hasOwnProperty('multimedia') ? data.multimedia : [];

        var multimediaHtmlData = [];
        var multimediaHtmlSlider = [];

        multimediaHtmlSlider.push(
            '<li class="active"><a href="#0">1</a></li>'
        );


        multimediaHtmlData.push(
            ' <li class="selected">'
        );
        multimediaHtmlData.push(
            '<img src="' + $resourceRoot + data.source + '" alt="' + data.name + '">'
        );
        multimediaHtmlData.push(
            '</li>'
        );
        $(selectorsConfig.multimedia.data).html("");
        /*$(selectorsConfig.multimedia.slider).html("");*/
        var count = 1;
        if (multimedia.length > 0) {
            $.each(multimedia, function (index, value) {

                multimediaHtmlData.push(
                    '<li>'
                );
                multimediaHtmlData.push(
                    '<img src="' + $resourceRoot + value.source + '" alt="' + value.title + '">'
                );

                multimediaHtmlData.push(
                    '</li>'
                );
                multimediaHtmlSlider.push(
                    '<li><a href="#' + count + '">' + (count + 1) + '</a></li>'
                );
                count++;
            });
        }
        multimediaHtmlData = multimediaHtmlData.join('');
        multimediaHtmlSlider = multimediaHtmlSlider.join('');

        $(selectorsConfig.multimedia.data).html(multimediaHtmlData);
        $(selectorsConfig.multimedia.slider).html(multimediaHtmlSlider);

        //VARIANTS ROUTES
        var resultManagementTakePart = managementTakePart({
            selectorsConfig: selectorsConfig,
            data: data,
            typeEvent: typeEvent
        });
        console.log(resultManagementTakePart);
    }

}

function allowManagementTakePart(params) {
    var data = params.data;
    var allowProcess = [];

    var haystack = data.teams;
    var success = true;
    if (haystack.length > 0) {
        allowProcess.push('teams');

    } else {
        success = false;
    }


    if (haystack.length > 0) {
        allowProcess.push('categories');

    } else {

        success = false;

    }


    var haystack = data.kits;

    if (haystack.length > 0) {
        allowProcess.push('kits');
    } else {

        success = false;

    }


    var haystack = data.distances;

    if (haystack.length > 0) {
        allowProcess.push('distances');
    } else {

        success = false;

    }


    var result = {
        success: success,
        allowProcess: allowProcess,

    };
    return result;
}

function managementTakePart(params) {
    var data = params.data;
    var selectorsConfig = params.selectorsConfig;
    var typeEvent = params.typeEvent;


    var allowProcess = [];
    //VARIANTS ROUTES
    var result = allowManagementTakePart(params);
    allowProcess = result.allowProcess;
    var allowCurrent = $.inArray('teams', allowProcess);
    var managementTakePart = result.success;
    var setHtmlCurrent = [];
    $(selectorsConfig.teams).html('');
    var haystack = data.teams;
    var selectorCurrentProcess = '.single-info--teams';
    if (allowCurrent != -1) {
        $.each(haystack, function (k, v) {
            var setPush = '<a>' + v.value + '</a> <br>';
            setHtmlCurrent.push(setPush)
        });
        setHtmlCurrent = setHtmlCurrent.join('');
        $(selectorsConfig.teams).html(setHtmlCurrent);
        $(selectorCurrentProcess).removeClass('not-view');
    } else {
        if (!$(selectorCurrentProcess).hasClass('not-view')) {

            $(selectorCurrentProcess).addClass('not-view');
        }

    }

    $(selectorsConfig.categories).html('');
    setHtmlCurrent = [];
    var haystack = data.categories;
    var selectorCurrentProcess = '.single-info--categories';
    allowCurrent = $.inArray('categories', allowProcess);

    if (allowCurrent != -1) {
        $(selectorCurrentProcess).removeClass('not-view');
        $.each(haystack, function (k, v) {
            var setPush = '<a>' + v.value + ' Limite ' + v.init_limit + ' a ' + v.end_limit + '</a> <br>';
            setHtmlCurrent.push(setPush)
        });
        setHtmlCurrent = setHtmlCurrent.join('');
        $(selectorsConfig.categories).html(setHtmlCurrent);
    } else {
        if (!$(selectorCurrentProcess).hasClass('not-view')) {

            $(selectorCurrentProcess).addClass('not-view');
        }


    }
    $(selectorsConfig.kit).html('');
    setHtmlCurrent = [];
    var haystack = data.kits;
    var selectorCurrentProcess = '.single-info--kit';
    allowCurrent = $.inArray('kits', allowProcess);

    if (allowCurrent != -1) {
        $(selectorCurrentProcess).removeClass('not-view');
        $.each(haystack, function (k, v) {
            var currentLink = $rootUrl + '/productDetails/' + v.id;
            var setPush = '<a target="_blank" class="management-view-link" href="'+currentLink+'">' + v.name + ' </a> <br>';

            var sizesCurrent = v.sizes;
            var sizesManager = '';
            if (sizesCurrent.length > 0) {
                var sizesManagerAux = [];
                $.each(sizesCurrent, function (ks, vs) {
                    var setPushChildren = '<span>' + vs.value + '</span> ';
                    sizesManagerAux.push(setPushChildren);

                });

                sizesManager = '<div class="sizes__content">Tallas:' + sizesManagerAux.join(',') + '</div>';
            }
            setPush = setPush + '' + sizesManager;
            setHtmlCurrent.push(setPush)
        });
        setHtmlCurrent = setHtmlCurrent.join('');
        $(selectorsConfig.kit).html(setHtmlCurrent);
    } else {
        if (!$(selectorCurrentProcess).hasClass('not-view')) {

            $(selectorCurrentProcess).addClass('not-view');
        }

    }


    $(selectorsConfig.distances).html('');
    setHtmlCurrent = [];
    var haystack = data.distances;
    var selectorCurrentProcess = '.single-info--distances';
    allowCurrent = $.inArray('distances', allowProcess);
    if (allowCurrent != -1) {
        $(selectorCurrentProcess).removeClass('not-view');
        $.each(haystack, function (k, v) {
            var setPush = '<a>' + v.value + ' - ' + v.events_trails_type_teams + ' - <span class="price-event">' + v.price + '</span></a> <br>';
            setHtmlCurrent.push(setPush)
        });
        setHtmlCurrent = setHtmlCurrent.join('');
        $(selectorsConfig.distances).html(setHtmlCurrent);
    } else {
        if (!$(selectorCurrentProcess).hasClass('not-view')) {

            $(selectorCurrentProcess).addClass('not-view');
        }


    }

    var selectorButtonCurrent = '';
    if (typeEvent == 'home') {
        selectorButtonCurrent = '#add-cart-preview';

    } else {
        selectorButtonCurrent = '#add-cart-preview';
    }

    if (managementTakePart) {
        $(selectorButtonCurrent).removeClass('not-view')
    } else {
        if (!$(selectorButtonCurrent).hasClass('not-view')) {
            $(selectorButtonCurrent).addClass('not-view');

        }
    }

    return result;
}
