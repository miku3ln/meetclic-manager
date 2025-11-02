@if($typeManagerButton==0)
    @if($dataManagerPage['shopConfig']['allow'])
        <li>
            <a id="a-cart-basket" href="javascript:void(0)" class="administration-cart">
                <i id="a-cart-basket__item-count" class="fa fa-shopping-basket"></i>
                <span
                    id="item-count"
                    class="item-count item-count--shopping-basket">0</span></a>
            <div class="minicart-wrapper not-view" id="minicart-wrapper">
                <p class="minicart-wrapper__title">{{__('header.shopping.title')}}</p>

                <div class="minicart-wrapper__items ps-scroll">
                    <div class="empty-items" id="empty-items">
                        {{__('header.shopping.empty')}}
                    </div>
                </div>

                <p class="minicart-wrapper__subtotal">{{__('header.shopping.subtotal')}}: <span class="subtotal"
                                                                                                id="subtotal">$0</span>
                </p>

                <div class="minicart-wrapper__buttons">
                    <a id="btn-view-cart" href="{{route('cart',app()->getLocale())}}"
                       class="theme-button theme-button--minicart-button">{{__('header.shopping.view-cart')}}</a>

                    <a id="btn-view-checkout" href="{{route('checkout',app()->getLocale())}}"
                       class="theme-button theme-button--alt theme-button--minicart-button theme-button--minicart-button--alt mb-0">{{__('header.shopping.checkout')}}</a>

                </div>

            </div>
        </li>
    @endif
@elseif($typeManagerButton==2){{-- menu movil--}}
@if($dataManagerPage['shopConfig']['allow'])
    <li>
        <a class="administration-cart cart-link btn--link">
            <i id="a-cart-basket__item-count" class="fa fa-shopping-basket"></i>
            <span class="item-count item-count--shopping-basket">0</span></a>
    </li>
@endif
@else
    <div class="management-overlay"></div>
    <div class="management-orders animated">
        <div class="management-orders__head">
            <a class="management-orders__close btn--link administration-cart"><i class="fa fa-times"
                                                                                 aria-hidden="true"></i></a>
            <span class="management-orders__title">{{__('header.shopping.title')}}</span>
            <a class="management-orders__results btn--link fa--icon-custom ">
                <div class="portal-totalizers-ref">
                    <div class="management-orders__amount-items">
                        <div class="management-orders__information">

                            <ul class="management-orders__information-data">
                                <li class="management-orders__information-data-amount"><em
                                        class="management-orders__information-data-amount-em">0</em>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

            </a>
        </div>
        <div class="management-orders__body">
            <div class="management-orders__manager-items">
                <div class="management-orders__manager-list">
                    <div class="empty-items" id="empty-items">
                        {{__('header.shopping.empty')}}
                    </div>

                </div>
                <div class="management-orders__manager-results">
                    <div class="management-orders__manager-results-total"><span class="mr-lbl">{{__('header.shopping.subtotal')}}:</span><span
                            class="management-orders__manager-results-total-val">0</span></div>

                    <a id="btn-view-cart" href="{{route('cart',app()->getLocale())}}"
                       class="theme-button theme-button--minicart-button">{{__('header.shopping.view-cart')}}</a>

                    <a id="btn-view-checkout" href="{{route('checkout',app()->getLocale())}}"
                       class="theme-button theme-button--alt theme-button--minicart-button theme-button--minicart-button--alt mb-0">{{__('header.shopping.checkout')}}</a>

                </div>
            </div>
        </div>
    </div>
@endif
