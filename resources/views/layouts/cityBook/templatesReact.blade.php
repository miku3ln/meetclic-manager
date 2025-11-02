<script type="text/template" id="tmpl-no-results">
    <div class="no-results-search">
        <h2>No Results</h2>
        <p>There are no listings matching your search.</p>
        <p>Try changing your search filters or <a href="http://citybook.meetclic.com" class="reset-filter-link">Reset
                Filter</a></p>
    </div>
</script>
<script type="text/template" id="tmpl-map-info">
    <div class="map-popup-wrap">
        <div class="map-popup">
            <div class="infoBox-close"><i class="fa fa-times" aria-hidden="true"></i></div>
            <# if(data.cats){ #>
            <div class="map-popup-category"><?php  echo "{{{Object.keys(data.cats).join('-')}}}"?></div>
            <# } #>
            <a href="<?php  echo '{{data.url}}'?>" class="listing-img-content fl-wrap">
                <img src="<?php  echo '{{data.thumbnail}}'?>" alt="<?php  echo '{{data.title}}'?>">
                <# if(data.featured == '1'){ #>
                <div class="listing-featured">Featured</div>
                <#} #>
            </a>

            <div class="listing-content fl-wrap">
                <# if(data.rating){ #>
                <div class="card-popup-raining map-card-rainting" data-rating="<?php  echo '{{data.rating.rating}}'?>"
                     data-stars="5">
                    <span class="map-popup-reviews-count">( <?php  echo '{{{data.rating.count}}} '?>reviews )</span>
                </div>
                <# } #>
                <div class="listing-title fl-wrap">
                    <h4><a href="<?php  echo '{{data.url}}'?>"><?php  echo '{{{data.title}}}'?></a></h4>
                    <# if(data.address){ #>
                    <span class="map-popup-contact-infos infos-address">
                        <i class="fa fa-map-marker" aria-hidden="true"></i><?php  echo '{{{data.address}}}'?>
                    </span>
                    <# } #>
                    <# if(data.phone){ #>
                    <span class="map-popup-contact-infos infos-phone">
                        <i class="fa fa-phone" aria-hidden="true"></i><a
                            href="tel:<?php  echo '{{data.phone}}'?>"><?php  echo '{{{data.phone}}}'?></a>
                    </span>
                    <# } #>

                </div>

                <div class="geodir-category-location listing-item-footer">

                    <span
                        class="wkhour-status wkhour-<?php  echo '{{data.status}}'?>"><?php  echo '{{data.statusText}}'?></span>


                </div>


            </div>
        </div>
    </div>
</script>

<script type="text/template" id="tmpl-feature-search">
    <# _.each(data.features, function(fea){ #>
    <div class="listing-feature-wrap">
        <input id="features_<?php  echo '{{fea.value}}'?>" type="checkbox" value="<?php  echo '{{fea.value}}'?>"
               name="lfeas[]">
        <label for="features_<?php  echo '{{fea.value}}'?>"><?php  echo '{{fea.label}}'?></label>
    </div>
    <!-- end listing-feature-wrap -->
    <# }) #>
</script>
<script type="text/template" id="tmpl-filter-subcats">
    <# _.each(data.subcats, function(subcat){ #>
    <div class="listing-feature-wrap">
        <input id="filter_subcats_<?php  echo '{{subcat.id}}'?>" type="checkbox" value="<?php  echo '{{subcat.id}}'?>"
               name="filter_subcats[]">
        <label for="filter_subcats_<?php  echo '{{subcat.id}}'?>"><?php  echo '{{subcat.name}}'?></label>
    </div>
    <!-- end listing-feature-wrap -->
    <# }) #>
</script>
<div id="ol-popup" class="ol-popup">
    <a href="#" id="ol-popup-closer" class="ol-popup-closer"></a>
    <div id="ol-popup-content"></div>
</div>
<script type="text/javascript">
    var c = document.body.className;
    c = c.replace(/woocommerce-no-js/, 'woocommerce-js');
    document.body.className = c;
</script>





<script type="text/template" id="tmpl-elementor-templates-modal__header">
    <div class="elementor-templates-modal__header__logo-area"></div>
    <div class="elementor-templates-modal__header__menu-area"></div>
    <div class="elementor-templates-modal__header__items-area">
        <# if (closeType ) { #>
        <div
            class="elementor-templates-modal__header__close elementor-templates-modal__header__close--<?php  echo '{{{ closeType }}}'?> elementor-templates-modal__header__item">
            <# if ( 'skip' === closeType ) { #>
            <span>Skip</span>
            <# } #>
            <i class="eicon-close" aria-hidden="true" title="Close"></i>
            <span class="elementor-screen-only">Close</span>
        </div>
        <# } #>
        <div id="elementor-template-library-header-tools"></div>
    </div>
</script>


<script type="text/template" id="tmpl-elementor-templates-modal__header__logo">
    <span class="elementor-templates-modal__header__logo__icon-wrapper elementor-gradient-logo">
		<i class="eicon-elementor"></i>
	</span>
    <span class="elementor-templates-modal__header__logo__title"><?php  echo '{{{ title }}}'?></span>
</script>



<script type="text/template" id="tmpl-elementor-finder">
    <div id="elementor-finder__search">
        <i class="eicon-search"></i>
        <input id="elementor-finder__search__input" placeholder="Type to find anything in Elementor">
    </div>
    <div id="elementor-finder__content"></div>
</script>

<script type="text/template" id="tmpl-elementor-finder-results-container">
    <div id="elementor-finder__no-results">No Results Found</div>
    <div id="elementor-finder__results"></div>
</script>



<script type="text/template" id="tmpl-elementor-finder__results__category">
    <div class="elementor-finder__results__category__title"><?php  echo '{{{ title }}}'?></div>
    <div class="elementor-finder__results__category__items"></div>
</script>

<script type="text/template" id="tmpl-elementor-finder__results__item">
    <a href="<?php  echo '{{ url }}'?>" class="elementor-finder__results__item__link">
        <div class="elementor-finder__results__item__icon">
            <i class="eicon-<?php  echo '{{{ icon }}}"'?>></i>
        </div>
        <div class="elementor-finder__results__item__title"><?php  echo '{{{ title }}}'?></div>
        <# if ( description ) { #>
        <div class="elementor-finder__results__item__description">- <?php  echo '{{{ description }}}'?></div>
        <# } #>
    </a>
    <# if ( actions.length ) { #>
    <div class="elementor-finder__results__item__actions">
        <# jQuery.each( actions, function() { #>
        <a class="elementor-finder__results__item__action elementor-finder__results__item__action--<?php  echo '{{ this.name }}'?>"
           href="<?php  echo '{{ this.url }}'?>" target="_blank">
            <i class="eicon-<?php  echo '{{{ this.icon }}}'?>"></i>
        </a>
        <# } ); #>
    </div>
    <# } #>
</script>

<!--register form -->
<div class="main-register-wrap ctb-modal" id="ctb-logreg-modal">
    <div class="main-overlay"></div>
    <div class="main-register-holder">
        <div class="main-register fl-wrap">
            <div class="ctb-modal-close"><i class="fa fa-times"></i></div>
            <h3>Sign In <span>Bee</span></h3>
            <div class="prelog-message"></div>
            <div class="soc-log fl-wrap">
                <p>For faster login or register use your social account.</p></div>
            <div class="log-separator fl-wrap"><span>or</span></div>
            <div class="tabs-wrapper">

                <ul class="tabs-menu">
                    <li class="tab-menu current"><a href="#tab-login">Login</a></li>
                    <li class="tab-menu"><a href="#tab-register">Register</a></li>
                </ul>
                <div class="tabs-content">

                    <div id="tab-login" class="tab-content current">
                        <div class="custom-form clearfix">
                            <form method="post" id="citybook-login">
                                <div class="log-message"></div>
                                <label for="user_login">Username or Email Address * </label>
                                <input id="user_login" name="log" type="text" onclick="this.select()" value=""
                                       required="">

                                <label for="user_pass">Password * </label>
                                <input id="user_pass" name="pwd" type="password" onclick="this.select()" value=""
                                       required="">


                                <button type="submit" id="log-submit" class="log-submit-btn"><span>Log In<i
                                            class="fa fa-spinner fa-pulse"></i></span></button>

                                <div class="clearfix"></div>
                                <div class="filter-tags">
                                    <input name="rememberme" id="rememberme" value="true" type="checkbox">
                                    <label for="rememberme">Remember me</label>
                                </div>
                                <input type="hidden" id="_loginnonce" name="_loginnonce" value="0db1b5009f"><input
                                    type="hidden" name="_wp_http_referer" value="/"> <input type="hidden"
                                                                                            name="redirection"
                                                                                            value="http://citybook.meetclic.com">
                            </form>
                            <div class="lost_password">
                                <a class="lost-password"
                                   href="http://citybook.meetclic.com/wp-login.php?action=lostpassword&amp;redirect_to=http%3A%2F%2Fcitybook.meetclic.com">Lost
                                    Your Password?</a>
                            </div>
                        </div>
                    </div>
                    <!-- end tab-content -->
                    <div id="tab-register" class="tab-content">
                        <div class="custom-form">
                            <form method="post" class="main-register-form" id="citybook-register">
                                <div class="reg-message"></div>

                                <p>Account details will be confirmed via email.</p>

                                <label for="reg_username">Username *</label>
                                <input id="reg_username" name="username" type="text" onclick="this.select()" value=""
                                       required="">

                                <label for="reg_email">Email Address *</label>
                                <input id="reg_email" name="email" type="email" onclick="this.select()" value=""
                                       required="">
                                <div class="terms_wrap">
                                    <div class="filter-tags">
                                        <input id="accept_term" name="accept_term" value="1" type="checkbox"
                                               required="required">
                                        <label for="accept_term">By using the website, you accept the terms and
                                            conditions</label>
                                    </div>
                                    <div class="filter-tags">
                                        <input id="consent_data" name="consent_data" value="1" type="checkbox"
                                               required="required">
                                        <label for="consent_data">Consent to processing of personal data</label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>


                                <button type="submit" id="reg-submit" class="log-submit-btn"><span>Register<i
                                            class="fa fa-spinner fa-pulse"></i></span></button>

                                <input type="hidden" id="_regnonce" name="_regnonce" value="c0ea3e45bb"><input
                                    type="hidden" name="_wp_http_referer" value="/">
                                <input type="hidden" name="redirection" value="http://citybook.meetclic.com">

                            </form>
                        </div>
                    </div>
                    <!-- end tab-content -->
                </div>
                <!-- end tabs-content -->
            </div>
            <!-- end tabs-wrapper -->

        </div>
    </div>
</div>

<div class="ctb-modal-wrap ctb-modal" id="ctb-resetpsw-modal">
    <div class="ctb-modal-holder">
        <div class="ctb-modal-inner">
            <div class="ctb-modal-close"><i class="fa fa-times"></i></div>
            <h3>Reset <span>Your Password</span></h3>
            <div class="ctb-modal-content">

                <form class="reset-password-form custom-form" action="#" method="post">

                    <fieldset>
                        <label for="user_reset">Username or Email Address *</label>
                        <input id="user_reset" name="user_login" type="text" value="" required="">
                    </fieldset>
                    <input class="btn color-bg" type="submit" value="Get New Password">

                </form>
            </div>
            <!-- end modal-content -->
        </div>
    </div>
</div>
