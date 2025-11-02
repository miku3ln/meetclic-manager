<header id="masthead" class="citybook-header main-header dark-header fs-header sticky">

    <div class="header-inner">
        <div class="logo-holder">
            <a class="custom-logo-link logo-text" href="http://citybook.meetclic.com/"><h2>Bee</h2></a></div>


        <div class="header-search vis-header-search">
            <form role="search" method="get" action="{{route('search',app()->getLocale())}}" class="list-search-header-form">

                <div
                    class="azp_element azp-element-jsl7tywc5 azp_row_section azp_row_section-default azp_row_section-0-gap">

                    <div class="azp_container">
                        <div class="azp_row azp_row-wrap">
                            <div class="azp_element azp-element-jsl7tywcm azp_col azp-col-33">
                                <div class="azp_element azp_filter_destination azp-element-jsl7u3ler">
                                    <div class="header-search-input-item">
                                        <input name="keywords" id="hero_search_loc" type="text" class="search"
                                               placeholder="{{__('frontend.menu.home.filters.keywords')}}" value="">

                                    </div>
                                </div>
                            </div>
                            <div class="azp_element azp-element-jsl7tzwlv azp_col azp-col-33">
                                <div class="azp_element azp_filter_category azp-element-jsl7u7q5m">
                                    <div class="header-search-select-item">

                                        <div class="nice-select search_lcats chosen-select" tabindex="0"><span
                                                class="current">All Categories</span>
                                            <div class="nice-select-search-box"><input type="text"
                                                                                       class="nice-select-search"
                                                                                       placeholder="Search...">
                                            </div>
                                            <ul class="list">
                                                <li data-value="0" class="option selected">All Categories</li>
                                                <li data-value="36" class="option">Cars</li>
                                                <li data-value="47" class="option">Events</li>
                                                <li data-value="48" class="option">Fitness</li>
                                                <li data-value="60" class="option">Hotels</li>
                                                <li data-value="81" class="option">Restaurants</li>
                                                <li data-value="89" class="option">Shops</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="azp_element azp-element-jsl7u08hw azp_col azp-col-33">
                                <div class="azp_element azp_filter_button azp-element-jsl7uhlsn">
                                    <button class="header-search-button" type="submit">Search</button>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- <input type="hidden" name="post_type" value="listing"> -->
            </form>
        </div>
        <div class="show-search-button"><i class="fa fa-search"></i> <span>Search</span></div>


        <a href="#" class="add-list logreg-modal-open" data-message="You must be logged in to add listings.">Add
            Listing <span><i class="fa fa-plus"></i></span></a>
        <div class="show-reg-form logreg-modal-open"><i class="fa fa-sign-in"></i>Sign In</div>
        <!-- nav-button-wrap-->
        <div class="nav-button-wrap color-bg">
            <div class="nav-button">
                <span></span><span></span><span></span>
            </div>
        </div>
        <!-- nav-button-wrap end-->
        <div class="attr-nav">
            <ul>
                <li>
                    <a href="#" class="cart-link">
                        <i class="fa fa-shopping-bag"></i>
                        <span class="cart-count">0</span>
                    </a>
                    <ul class="cart-list">
                        <li>
                            <div class="widget_shopping_cart_content">

                                <p class="woocommerce-mini-cart__empty-message">No products in the cart.</p>


                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</header>
