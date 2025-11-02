@if(env('allowRoutes'))
    <div id="qv-1" class="cd-quick-view">
        <div class="cd-slider-wrapper">
            <div class="product-badge-wrapper">
                <span class="onsale" id="onsale">-17%</span>

            </div>
            <ul class="cd-slider">

            </ul>

            <ul class="cd-slider-pagination">

            </ul>

            <ul class="cd-slider-navigation">

            </ul>
        </div>

        <div class="quickview-item-info cd-item-info ps-scroll product-details-description-wrapper ">

            <h2 id="item-title" class="item-title">Atelier Ottoman Takumi Series</h2>
            <h4 id="item-title-date-init" class="item-title-date-init"></h4>
            <h4 id="item-title-date-end" class="item-title-date-end"></h4>

            <p class="price not-view">
                <span id="main-price" class="main-price discounted">$360.00</span>

            </p>

            <p id="description" class="description">


            </p>

            <div class="add-to-cart-btn d-inline-block manager-basket-inputs">
                <button class="theme-button theme-button--alt  add-cart add-cart--shop   " product-id="null"
                        id="add-cart-preview">
                    {{__('config.buttons.three')}}
                </button>
            </div>

            <div class="quick-view-other-info">

                <table>
                    <tr class="single-info">
                        <td class="quickview-title">{{__('config.routes.titles.one')}}:</td>
                        <td class="quickview-value quickview-value-codec" id="quickview-value-codec">12345</td>
                    </tr>
                    <tr class="single-info">
                        <td class="quickview-title">{{__('config.routes.titles.six')}}:</td>
                        <td class="quickview-value quickview-value-type" id="quickview-value-type">
                        </td>
                    </tr>
                    <tr class="single-info single-info--teams not-view">
                        <td class="quickview-title">{{__('config.routes.titles.two')}}:</td>
                        <td class="quickview-value quickview-value-teams" id="quickview-value-teams">
                        </td>
                    </tr>
                    <tr class="single-info single-info--categories not-view">
                        <td class="quickview-title">{{__('config.routes.titles.three')}}:</td>
                        <td class="quickview-value quickview-value-categories" id="quickview-value-categories">
                        </td>
                    </tr>
                    <tr class="single-info single-info--kit not-view">
                        <td class="quickview-title">{{__('config.routes.titles.four')}}:</td>
                        <td class="quickview-value quickview-value-kit" id="quickview-value-kit">
                        </td>
                    </tr>
                    <tr class="single-info single-info--distances not-view">
                        <td class="quickview-title">{{__('config.routes.titles.five')}}:</td>
                        <td class="quickview-value quickview-value-distances" id="quickview-value-distances">
                        </td>
                    </tr>
                    @if(isset($dataMenu))
                        @if(isset($dataMenu['socialNetworkShop']))

                            @if($dataMenu['socialNetworkShop']!='')
                                {{$dataMenu['socialNetworkShop']}}

                            @endif
                        @endif

                    @endif
                </table>
            </div>


        </div> <!-- cd-item-info -->

        <a href="#0" class="cd-close">Close</a>
    </div>
@else
    <div id="qv-1" class="cd-quick-view">
        <div class="cd-slider-wrapper">
            <div id="product-badge-wrapper" class="product-badge-wrapper">
                <span class="onsale" id="product-badge-wrapper__percentage">-17%</span>
                <span class="hot  not-view" id="product-badge-wrapper__hot">Hot</span>
            </div>
            <ul class="cd-slider">

            </ul> <!-- cd-slider -->

            <ul class="cd-slider-pagination">

            </ul> <!-- cd-slider-pagination -->

            <ul class="cd-slider-navigation">

            </ul> <!-- cd-slider-navigation -->
        </div> <!-- cd-slider-wrapper -->

        <div class="quickview-item-info cd-item-info ps-scroll product-details-description-wrapper ">

            <h2 id="item-title" class="item-title">Atelier Ottoman Takumi Series</h2>
            <p class="price">
                <span id="main-price" class="main-price discounted">$360.00</span>
                <span id="discounted-price" class="discounted-price">$300.00</span>
            </p>

            <p id="description" class="description">


            </p>
            <div class="product-color" style="display: none">
                <span class="product-details-title">COLOR: </span>
                <ul class="product-color__items">
                </ul>
            </div>

            <div class="product-size" style="display: none">
                <span class="product-details-title">SIZE: </span>
                <select class="nice-select-quick-view product-size__items">

                </select>

            </div>
            <div class="pro-qty d-inline-block manager-basket-inputs">
                <input type="text" value="1" id="product-amount-preview">
            </div>

            <div class="add-to-cart-btn d-inline-block manager-basket-inputs">
                <button class="theme-button theme-button--alt  add-cart add-cart--shop  " product-id="null"
                        id="add-cart-preview">
                    {{__('config.buttons.one')}}
                </button>
            </div>

            <div class="quick-view-other-info">
                <div class="other-info-links">
                    <a class="add-wish-list add-wish-list--view-quick" href="javascript:void(0)"><i
                            class="fa fa-heart-o "></i> {{__('buttons.add-wish-list')}}</a>
                </div>
                <table>
                    <tr class="single-info">
                        <td class="quickview-title">Codigo:</td>
                        <td class="quickview-value quickview-value-codec" id="quickview-value-codec">12345</td>
                    </tr>
                    <tr class="single-info">
                        <td class="quickview-title">Categories:</td>
                        <td class="quickview-value quickview-value-category" id="quickview-value-category">
                            <a href="#">Decor</a>,
                            <a href="#">Living Room</a>,
                            <a href="#">Furniture</a>
                        </td>
                    </tr>

                    @if(isset($dataMenu))
                        @if(isset($dataMenu['socialNetworkShop']))

                            @if($dataMenu['socialNetworkShop']!='')
                                {{$dataMenu['socialNetworkShop']}}

                            @endif

                        @endif

                    @endif
                </table>
            </div>


        </div> <!-- cd-item-info -->

        <a href="#0" class="cd-close">Close</a>
    </div>
@endif
