@if ($dataManagerPage['inventory-config']['type'] == 0)
    <div class="">
        <section id="busines__shop">
            <div class="shop-manager-wrap">
                <div class="page-content-wrapper">

                    <div class="shop-page-area">
                        <div class="container">


                            <div class="row " id="init-loading">
                                <div class="loading-data" id="loading-data">
                                    {{ __('messages.loading') }}
                                </div>
                            </div>

                            <div class="row not-view" id="content-manager-products-services">


                                <aside class="col-md-3">
                                    <h2 class="single-sidebar-widget__title">{{ __('shop.filters.categories') }}<span
                                            class="content-filter not-view"><i id="icon-filters"><span
                                                    aria-hidden="true">×</span></i></span></h2>
                                    <nav class="fixed-bar-shop__menu sidebar-nav">
                                        <ul id="metismenu" v-init-menu-shop="{initMethod:initMenuShop}">
                                            @foreach ($dataManagerPage['categories'] as $key => $row)
                                                <li class="menu-manager-categories__li" id="category-{{ $row['id'] }}">
                                                    <a class="has-arrow menu-manager-categories__a"
                                                        aria-expanded="false"><i class=""></i>{{ $row['value'] }}</a>

                                                    <ul>
                                                        @foreach ($row['data'] as $keySub => $rowSub)
                                                            <li class="li-subcategory" subcategory="{{ $rowSub['id'] }}"
                                                                category="{{ $row['id'] }}"><a
                                                                    subcategory="{{ $rowSub['id'] }}"
                                                                    category="{{ $row['id'] }}"
                                                                    href="javascript:void(0)"
                                                                    class="a-subcategory">{{$rowSub['value'] }}</a>
                                                            </li>

                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </nav>

                                </aside>


                                <div class="col-md-9">

                                    <div class="shop-content-wrapper-loading">
                                        {{ __('messages.loading') }}
                                    </div>
                                    <div class="shop-content-wrapper" style="display: none">


                                        <div class="shop-header">
                                            <div class="row custom-form--opacity-placeholder-50">

                                                <div class="manager-input-data">
                                                    <input type="text" placeholder="Buscar ....."
                                                        v-on:keyup="_searchData(model.search.needle)"
                                                        v-model="model.search.needle" />
                                                    <div
                                                        class="header-search-select-item header-search-select-item--shop">
                                                        <select name="sort-by" id="sort-by" class="chosen-select">
                                                            <option value="-1" id="allSort" order="asc">
                                                                {{ __('shop.filters.field-0') }}
                                                            </option>
                                                            <option value="0" id="nameSort" order="asc">
                                                                {{ __('shop.filters.field-1') }}
                                                            </option>
                                                            <option value="1" id="codeSort" order="asc">
                                                                {{ __('shop.filters.field-2') }}
                                                            </option>
                                                            <option value="2" id="categorySort" order="asc">
                                                                {{ __('shop.filters.field-3') }}
                                                            </option>
                                                            <option value="3" id="subcategorySort" order="asc">
                                                                {{ __('shop.filters.field-4') }}
                                                            </option>

                                                        </select>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                    <div class="shop-product-wrap shop-product-wrap--with-sidebar row grid">
                                        <div class="col-lg-12 col-md-12 not-view" id="content-products">
                                            <div class=" custom-scroll-admin-grid table-responsive">
                                                <input type="hidden" id="category" value="">
                                                <input type="hidden" id="subcategory" value="">
                                                <table id="product-grid" v-init-bootgrid="{initMethod:initGridShop}"
                                                    id="product-grid">
                                                    <thead>
                                                        <tr>
                                                            <th data-visible="false" data-column-id="id"
                                                                data-identifier="true">
                                                                {{ __('shop.grid.field-1') }}
                                                            </th>
                                                            <th data-column-id="description"
                                                                data-formatter="description">
                                                                {{ __('shop.grid.field-2') }}
                                                            </th>

                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>


                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </section>

    </div>

@else
    @php

    $backgroundCurrent=$dataManagerPage['inventory-config']['config_management_inventory']['header_subcategories']['content']['styles']['background_color'];
    @endphp

    <section class="shop-content-wrapper management-categories-type-one"   id="business__categories" style="background:{{$backgroundCurrent}} !important;
">

        <div class="container" id="container-categories">

            <div class="row" id="row-categories">
                <div class="col-md-1">

                </div>
                <div class="col-md-10">
                    {!! $dataManagerPage['categoriesHtml'] !!}

                </div>

                <div class="col-md-1">

                </div>
            </div>
        </div>
    </section>

    <section id="business__shop">
        <div class="shop-manager-wrap">
            <div class="page-content-wrapper">

                <div class="shop-page-area">
                    <div class="container">


                        <div class="row " id="init-loading">
                            <div class="loading-data" id="loading-data">
                                {{ __('messages.loading') }}
                            </div>
                        </div>

                        <div class="row not-view" id="content-manager-products-services">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="shop-content-wrapper-loading">
                                        {{ __('messages.loading') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="content-manager-products-services__title-subcategory"><?php echo '{{ configFilters.subcatetory.title }}'; ?> </h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="shop-content-wrapper" style="display: none">
                                        <div class="shop-header">
                                            <div
                                                class="custom-form--opacity-placeholder-50 custom-form-search-shop-type-one">

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="text" placeholder="Buscar ....."
                                                               v-on:keyup="_searchData(model.search.needle)"
                                                            v-model="model.search.needle" />
                                                    </div>
                                                    <div class="col-md-4" v-if="niceConfigAllow.subcategories">

                                                        <div
                                                            class="header-search-select-item header-search-select-item--shop">
                                                            <select v-nice-select={initMethod:initNice}
                                                                name="subcategories" id="sort-by-subcategories"
                                                                class="chosen-select-data select2-full">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="shop-products-wrap row">
                                        <div id="content-products" class="not-view">

                                            <div
                                                v-bind:class="{ 'col-md-7 col-lg-7': niceConfigAllow.subcategoryImage,'col-md-12 col-lg-12': !niceConfigAllow.subcategoryImage}">
                                                <div
                                                    class=" custom-scroll-admin-grid table-responsive shop-products-wrap__grid">
                                                    <input type="hidden" id="category" value="">
                                                    <input type="hidden" id="subcategory" value="">
                                                    <table id="product-grid" v-init-bootgrid="{initMethod:initGridShop}"
                                                        id="product-grid">
                                                        <thead>
                                                            <tr>
                                                                <th data-visible="false" data-column-id="id"
                                                                    data-identifier="true">
                                                                    {{ __('shop.grid.field-1') }}
                                                                </th>
                                                                <th data-column-id="description"
                                                                    data-formatter="description">
                                                                    {{ __('shop.grid.field-2') }}
                                                                </th>

                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="shop-products-wrap__image-content"
                                                v-if="niceConfigAllow.subcategoryImage"
                                                v-bind:class="{'col-md-5 col-lg-5': niceConfigAllow.subcategoryImage}">
                                                <img class="shop-products-wrap__image"
                                                    v-bind:src="configFilters.subcatetory.img" alt="">
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>


    </section>


@endif
