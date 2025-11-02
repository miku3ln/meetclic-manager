<section id="sec2">
    <div class="container">
        <div class="section-title">
            <h2> {{__('frontend.menu.home.prices.title')}}</h2>
            <div class="section-subtitle">{{__('frontend.menu.home.prices.subtitle')}}</div>
            <span class="section-separator"></span>
            <p>{{__('frontend.menu.home.prices.description')}}</p>
        </div>
        <div class="pricing-wrap fl-wrap">
            <!-- price-item-->
            <div class="price-item">
                <div class="price-head op1">
                    <h3>{{__('frontend.menu.home.prices.bee.title')}}</h3>
                </div>
                <div class="price-content fl-wrap">
                    <div class="price-num fl-wrap">

                        <span class="price-num-item">{{__('frontend.menu.home.prices.bee.subtitle')}}</span>
                        <div class="price-num-desc">{{__('frontend.menu.home.prices.bee.timer')}}</div>
                    </div>
                    <div class="price-desc fl-wrap">
                        <ul>
                            <li>{{__('frontend.menu.home.prices.bee.options.one')}}</li>
                            <li>{{__('frontend.menu.home.prices.bee.options.two')}}</li>
                            <li>{{__('frontend.menu.home.prices.bee.options.three')}}</li>
                            <li>{{__('frontend.menu.home.prices.bee.options.four')}}</li>
                        </ul>
                        <a href="#"
                           class="price-link">{{__('frontend.menu.home.prices.button') }} {{__('frontend.menu.home.prices.bee.title')}}</a>
                    </div>
                </div>
            </div>
            <!-- price-item end-->
            <!-- price-item-->
            <div class="price-item best-price">
                <div class="price-head op2">
                    <h3>{{__('frontend.menu.home.prices.worker.title')}}</h3>
                </div>
                <div class="price-content fl-wrap">
                    <div class="price-num fl-wrap">
                        <span class="curen">$</span>
                        <span class="price-num-item">{{__('frontend.menu.home.prices.worker.subtitle')}}</span>
                        <div class="price-num-desc">{{__('frontend.menu.home.prices.worker.timer')}}</div>
                    </div>
                    <div class="price-desc fl-wrap">
                        <ul>
                            <li>{{__('frontend.menu.home.prices.worker.options.one')}}</li>
                            <li>{{__('frontend.menu.home.prices.worker.options.two')}}</li>
                            <li>{{__('frontend.menu.home.prices.worker.options.three')}}</li>
                            <li>{{__('frontend.menu.home.prices.worker.options.four')}}</li>
                            <li>{{__('frontend.menu.home.prices.worker.options.five')}}</li>
                            <li>{{__('frontend.menu.home.prices.worker.options.six')}}</li>
                            <li>{{__('frontend.menu.home.prices.worker.options.seven')}}</li>
                            <li>{{__('frontend.menu.home.prices.worker.options.eight')}}</li>

                        </ul>
                        <a href="#"
                           class="price-link">{{__('frontend.menu.home.prices.button') }} {{__('frontend.menu.home.prices.worker.title')}}</a>

                        <div class="recomm-price">
                            <i class="fa fa-check"></i>
                            <span class="clearfix"></span>
                            {{__('frontend.menu.home.prices.title.recommended') }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- price-item end-->
            <!-- price-item-->
            <div class="price-item">
                <div class="price-head">
                    <h3>{{__('frontend.menu.home.prices.queen.title')}}</h3>
                </div>
                <div class="price-content fl-wrap">
                    <div class="price-num fl-wrap">
                        <span class="curen">$</span>
                        <span class="price-num-item">{{__('frontend.menu.home.prices.queen.subtitle')}}</span>
                        <div class="price-num-desc">{{__('frontend.menu.home.prices.queen.timer')}}</div>
                    </div>
                    <div class="price-desc fl-wrap">
                        <ul>
                            <li>{{__('frontend.menu.home.prices.queen.options.one')}}</li>
                            <li>{{__('frontend.menu.home.prices.queen.options.two')}}</li>
                            <li>{{__('frontend.menu.home.prices.queen.options.three')}}</li>
                            <li>{{__('frontend.menu.home.prices.queen.options.four')}}</li>
                            <li>{{__('frontend.menu.home.prices.queen.options.five')}}</li>
                            <li>{{__('frontend.menu.home.prices.queen.options.six')}}</li>
                            <li>{{__('frontend.menu.home.prices.queen.options.seven')}}</li>
                            <li>{{__('frontend.menu.home.prices.queen.options.eight')}}</li>
                            <li>{{__('frontend.menu.home.prices.queen.options.nine')}}</li>
                            <li>{{__('frontend.menu.home.prices.queen.options.ten')}}</li>

                        </ul>
                        <a href="#"
                           class="price-link">{{__('frontend.menu.home.prices.button') }} {{__('frontend.menu.home.prices.queen.title')}}</a>
                    </div>
                </div>
            </div>
            <!-- price-item end-->
        </div>
        <!-- about-wrap end  -->
        <span class="fw-separator"></span>
        <!-- features-box-container -->
    @include('layouts.partials.cityBook.support')
    <!-- features-box-container end  -->
    </div>
</section>
