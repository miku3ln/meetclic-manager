<script id="owl-manager">
    function generateCategoriesCarousel(params = {}) {

        const categories = params.categories || [];
        var $scope = params.$scope;

        /*
        |--------------------------------------------------------------------------
        | SELECTORS
        |--------------------------------------------------------------------------
        */

        const $categoriesCarousel = $('.category-carousel');
        const $subCategoriesCarousel = $('.sub-categories-carousel');

        /*
        |--------------------------------------------------------------------------
        | RESET
        |--------------------------------------------------------------------------
        */

        destroyOwlCarousel($categoriesCarousel);
        destroyOwlCarousel($subCategoriesCarousel);

        $categoriesCarousel.html('');
        $subCategoriesCarousel.html('');

        /*
        |--------------------------------------------------------------------------
        | GENERATE CATEGORIES
        |--------------------------------------------------------------------------
        */

        let categoriesHtml = '';

        categories.forEach(category => {

            categoriesHtml += `
            <div class="item">

                <div
                    class="mc-category-card"

                    data-id="${category.id}"
                    data-title="${category.title}"
                    data-description="${category.description || ''}"
                >

                    <div class="mc-category-card__icon">
                        <i class="fa ${category.icon}"></i>
                    </div>

                    <div class="mc-category-card__content">

                        <div class="mc-category-card__title">
                            ${category.title}
                        </div>

                    </div>

                </div>

            </div>
        `;
        });

        $categoriesCarousel.html(categoriesHtml);

        /*
        |--------------------------------------------------------------------------
        | INIT CATEGORYS
        |--------------------------------------------------------------------------
        */

        initOwlCarousel($categoriesCarousel);

        /*
        |--------------------------------------------------------------------------
        | INIT SUBCATEGORYS
        |--------------------------------------------------------------------------
        */

        initOwlCarousel($subCategoriesCarousel);

        /*
        |--------------------------------------------------------------------------
        | CATEGORY CLICK
        |--------------------------------------------------------------------------
        */

        $categoriesCarousel.off('click');

        $categoriesCarousel.on('click', '.mc-category-card', function () {

            /*
            |--------------------------------------------------------------------------
            | ACTIVE
            |--------------------------------------------------------------------------
            */

            $('.mc-category-card')
                .removeClass('mc-category-card--active');

            $(this)
                .addClass('mc-category-card--active');

            /*
            |--------------------------------------------------------------------------
            | DATA
            |--------------------------------------------------------------------------
            */

            const categoryId = $(this).data('id');

            const category = categories.find(
                item => item.id == categoryId
            );

            console.log('CATEGORY', category);
            $scope.onCategorySelect(category);
            /*
            |--------------------------------------------------------------------------
            | RENDER SUBCATEGORYS
            |--------------------------------------------------------------------------
            */

            renderSubCategories({
                category,
                $carousel: $subCategoriesCarousel,
                $scope: $scope
            });

        });

        /*
        |--------------------------------------------------------------------------
        | AUTO SELECT FIRST CATEGORY
        |--------------------------------------------------------------------------
        */

        if (categories.length > 0) {

            setTimeout(() => {

                $categoriesCarousel
                    .find('.mc-category-card')
                    .first()
                    .trigger('click');

            }, 100);

        }

    }


    /*
    |--------------------------------------------------------------------------
    | SUBCATEGORYS
    |--------------------------------------------------------------------------
    */

    function renderSubCategories(params = {}) {

        const category = params.category || {};
        const $carousel = params.$carousel;

        const subcategories = category.subcategories || [];
        var $scope = params.$scope;

        /*
        |--------------------------------------------------------------------------
        | RESET
        |--------------------------------------------------------------------------
        */

        destroyOwlCarousel($carousel);

        $carousel.html('');

        /*
        |--------------------------------------------------------------------------
        | HTML
        |--------------------------------------------------------------------------
        */

        let html = '';

        subcategories.forEach(subcategory => {

            html += `
            <div class="item">

                <div
                    class="mc-subcategory-card"

                    data-id="${subcategory.id}"
                    data-category-id="${category.id}"
                    data-title="${subcategory.title}"
                    data-description="${subcategory.description || ''}"
                >

                    <div class="mc-subcategory-card__icon">
                        <i class="fa ${subcategory.icon}"></i>
                    </div>

                    <div class="mc-subcategory-card__content">

                        <div class="mc-subcategory-card__title">
                            ${subcategory.title}
                        </div>

                    </div>

                </div>

            </div>
        `;
        });

        $carousel.html(html);

        /*
        |--------------------------------------------------------------------------
        | INIT
        |--------------------------------------------------------------------------
        */

        initOwlCarousel($carousel);

        /*
        |--------------------------------------------------------------------------
        | CLICK
        |--------------------------------------------------------------------------
        */

        $carousel.off('click');

        $carousel.on('click', '.mc-subcategory-card', function () {

            $('.mc-subcategory-card')
                .removeClass('mc-subcategory-card--active');

            $(this)
                .addClass('mc-subcategory-card--active');
            var subCategoryData = {
                id: $(this).data('id'),
                categoryId: $(this).data('category-id'),
                title: $(this).data('title')
            };
            console.log('SUBCATEGORY', subCategoryData);
            $scope.onSubCategorySelect({category: category, subCategory: subCategoryData});


        });

        /*
        |--------------------------------------------------------------------------
        | AUTO SELECT FIRST SUBCATEGORY
        |--------------------------------------------------------------------------
        */

        if (subcategories.length > 0) {

            setTimeout(() => {

                $carousel
                    .find('.mc-subcategory-card')
                    .first()
                    .trigger('click');

            }, 100);

        }

    }


    /*
    |--------------------------------------------------------------------------
    | OWL INIT
    |--------------------------------------------------------------------------
    */

    function initOwlCarousel($carousel, options = {}) {
        const config = {
            loop: false,
            nav: true,
            dots: false,
            margin: 10,
            autoWidth: true,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 4
                },
                960: {
                    items: 6
                }
            },

            ...options
        };

        $carousel.owlCarousel(config);
        /*
        |--------------------------------------------------------------------------
        | MOUSE WHEEL
        |--------------------------------------------------------------------------
        */

        $carousel.off('mousewheel');

        $carousel.on('mousewheel', '.owl-stage', function (e) {

            if (e.originalEvent.deltaY > 0) {
                $carousel.trigger('next.owl');
            } else {
                $carousel.trigger('prev.owl');
            }

            e.preventDefault();
        });

    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY OWL
    |--------------------------------------------------------------------------
    */

    function destroyOwlCarousel($carousel) {

        if ($carousel.hasClass('owl-loaded')) {
            $carousel.trigger('destroy.owl.carousel');
        }

    }
</script>
