<section id="shop">
    <div class="shop-manager-wrap">
        <div class="page-content-wrapper">

            <div class="shop-page-area">
                <div class="container__full-page ">
                    <div class="row " id="init-loading">
                        <div class="loading-data" id="loading-data">
                            {{ __('messages.loading') }}
                        </div>
                    </div>

                    <div class="row not-view" id="content-manager-products-services">

                        <div class="col-md-12">

                            <div class="shop-content-wrapper-loading">
                                {{ __('messages.loading') }}
                            </div>


                            <div class="shop-product-wrap shop-product-wrap--with-sidebar row grid">
                                <div class="col-lg-12 col-md-12 not-view" id="content-products">
                                    <div class=" custom-scroll-admin-grid table-responsive list-main-wrap fl-wrap card-listing">
                                        <input type="hidden" id="category" value="">
                                        <input type="hidden" id="subcategory" value="">
                                        <table id="product-grid" v-init-bootgrid="{initMethod:initGridShop}"
                                               class="listing-items"
                                           >
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
