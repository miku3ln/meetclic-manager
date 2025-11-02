<?php

namespace App\Providers;

use App\Models\BusinessByEmployeeProfile;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

use App\Models\Business;
use App\Models\EventsTrailsTypes;

use App\Models\Action;
use Blade;
use Request;
use Auth;
use Ekko;
use URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\HtmlString;
use App\Utils\Util;

class ChasquiProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */

    public function boot()
    {

        view()->composer('layouts.frontend', function ($view) {

        });
    }

    public static function getMenuCurrent()
    {

    }

    public static function getHtmlCategories($params)
    {
        $dataCategories = $params['dataCategories'];
        $typeCategory = $params['typeCategory'];
        $language = $params['language'] == 'es' ? null : $params['language'];

        $resultRows = Util::getRowsByDataBS3(array("haystack" => $dataCategories));

        $htmlRow = "";
        $htmlCols = "";

        $resourcePathServer = $params['resourcePathServer'];


        foreach ($resultRows as $key => $row) {

            $elementAttributes = '';
            $htmlRow .= '<div class="row " ' . $elementAttributes . '>';
            $dataColumns = $row["data"];
            $classColumn = "col col-md-" . (12 / count($dataColumns));
            foreach ($dataColumns as $keyColumn => $column) {
                $urlImg = '';

                if ($typeCategory) {
                    $urlImg = $resourcePathServer . (isset($column["url_img"]) ? $column["url_img"] : 'frontend/assets/img/banners/simple-banner-' . ($keyColumn + 1) . '.jpg');

                } else {
                    $urlImg = $resourcePathServer . (isset($column["source"]) ? $column["source"] : 'frontend/assets/img/banners/simple-banner-' . ($keyColumn + 1) . '.jpg');

                }


                $title = $language == null ? $column['value'] : ((isset($column['value_lang']) && $column['value_lang']) ? $column['value_lang'] : $column['value']);

                $content = $column["description"];
                $htmlCols .= '<div class="' . $classColumn . '">';
                $htmlCols .= ' <div class="single-banner"> ';
                $routeUrl = route('shop', app()->getLocale());
                $htmlCols .= '   <div class="single-banner__image"> ';
                $htmlCols .= '    <a class="thumbnail"  href="' . $routeUrl . '">';
                $htmlCols .= '       <img class="img-fluid" src="' . URL::asset($urlImg) . '" />';
                $htmlCols .= '    </a>';
                $htmlCols .= '   </div>';
                $htmlCols .= '  <div class="single-banner__content single-banner__content--overlay">';
                $htmlCols .= '    <p class="banner-big-text">' . $title . '</p>';
                $htmlCols .= '    <a class="theme-button theme-button--alt theme-button--banner"  href="' . $routeUrl . '">';
                $htmlCols .= '      IR';
                $htmlCols .= '    </a>';
                $htmlCols .= '  </div>';
                $htmlCols .= '</div>';
                $htmlCols .= '</div>';
            }
            $htmlRow .= $htmlCols . '</div>';
            $htmlCols = '';

        }
        $htmlRow = new HtmlString($htmlRow);
        return $htmlRow;
    }

    public static function getHtmlSlider($params)
    {
        $sliderInformation = $params['slider'];
        $sliderData = $sliderInformation['data'];
        $language = $sliderInformation['language'] == 'es' ? null : $sliderInformation['language'];

        $htmlRow = "";
        $htmlCols = "";
        foreach ($sliderData as $key => $row) {

            $id = 'rs-' . $row['id'];
            $src = $row['source'];
            $type_button = $row['type_button'];
            $options_all = $row['options_all'];
            $title = $language == null ? $row['title'] : (isset($row['title_lang']) && $row['title_lang'] ? $row['title_lang'] : $row['title']);
            $subtitle = $language == null ? $row['subtitle'] : (isset($row['subtitle_lang']) && $row['subtitle_lang'] ? $row['subtitle_lang'] : $row['subtitle']);

            $options_source = $row['options_source'];
            $options_button = $row['options_button'];
            $options_subtitle = $row['options_subtitle'];
            $button_name = $row['button_name'];

            $options_title = $row['options_title'];

            $htmlRow .= ' <li data-index="' . $id . '"  ' . $options_all . '   > ' . "\n";
            $htmlRow .= '       <img      width="1920"
                         height="1080" src="' . $src . '"    ' . $options_source . '>' . "\n";
            $htmlRow .= '       <div id="slide-subtitle-' . $row['id'] . '"  ' . $options_subtitle . ' >' . "\n";
            $htmlRow .= '        ' . $subtitle . "\n";

            $htmlRow .= '        </div>' . "\n";
            $htmlRow .= '       <div id="slide-title-' . $row['id'] . '"  ' . $options_title . ' >' . "\n";
            $htmlRow .= '        ' . $title . "\n";
            $htmlRow .= '        </div>' . "\n";
            if ($type_button == 1) {

                $htmlRow .= '       <a id="slide-button-' . $row['id'] . '"  ' . $options_button . ' >' . "\n";
                $htmlRow .= '        ' . $button_name . "\n";
                $htmlRow .= '        </a>' . "\n";
            }
            $htmlRow .= ' </li>' . "\n";


        }
        $htmlRow = new HtmlString($htmlRow);
        return $htmlRow;
    }

    public static function getHtmlSocialNetwork($params)
    {
        $data = $params['data'];
        $type = $params['type'];
        $title = $params['title'];

        $htmlRow = "";


        if ($type == 'footer') {
            $htmlRow .= '<div class="footer-widget footer-widget--two">';
            $htmlRow .= '    <span class="footer-widget__text footer-widget__text--two">' . $title . '</span>';
            $htmlRow .= '    <ul class="footer-widget__social-links">';

        } else if ($type == 'contact-us') {
            $htmlRow .= '<div class="contact-form-content">';
            $htmlRow .= '    <p>' . $title . '</p>';
            $htmlRow .= '    <ul class="social-links">';
        } else if ($type == 'menu-shop') {
            $htmlRow .= '<tr class="single-info">';
            $htmlRow .= '    <td class="quickview-title">' . $title . '</td>';
            $htmlRow .= '    <td class="quickview-value">';
            $htmlRow .= '    <ul class="quickview-social-icons">';

        } else if ($type == 'menu-mobile') {
            $htmlRow .= '<div class="off-canvas-widget-social">';


        }
        foreach ($data as $key => $row) {
            $value = $row->value;
            $information_social_network_type = $row->information_social_network_type;
            $icon = $row->icon;
            if ($type == 'footer') {
                $htmlRow .= '   <li><a target="_blank" href="' . $value . '" title="' . $information_social_network_type . '"><i class="' . $icon . '"></i></a></li>' . "\n";

            } else if ($type == 'menu-mobile') {
                $htmlRow .= '   <a target="_blank" href="' . $value . '" title="' . $information_social_network_type . '"><i class="' . $icon . '"></i></a>' . "\n";

            } else {
                $htmlRow .= '   <li><a target="_blank" href="' . $value . '" title="' . $information_social_network_type . '"><i class="' . $icon . '"></i></a></li>' . "\n";

            }


        }
        if ($type == 'menu-shop') {
            $htmlRow .= '      </ul>';
            $htmlRow .= '</td>';
            $htmlRow .= '</tr>';

        } else if ($type == 'menu-mobile') {
            $htmlRow .= '</div>';

        } else {
            $htmlRow .= '      </ul>';
            $htmlRow .= '</div>';
        }


        $htmlRow = new HtmlString($htmlRow);
        return $htmlRow;
    }

    public static function getHtmlInformationBusiness($params)
    {
        $data = $params['data'];
        $type = $params['type'];


        $htmlRow = "";

        $email = $data->email;
        $phone_value = $data->phone_value;
        $street_1 = $data->street_1;
        $street_2 = $data->street_2;

        if ($type == 'contact-us') {
            $htmlRow .= '<div class="row">';
            $htmlRow .= '    <div class="col-lg-12">';
            $htmlRow .= '         <div class="contact-icon-text-wrapper">';
            $htmlRow .= '             <div class="row">';

            $htmlRow .= '                    <div class="col-sm-4"> ';
            $htmlRow .= '                       <div class="single-contact-icon-text"> ';
            $htmlRow .= '                              <div class="single-contact-icon-text__icon">';
            $htmlRow .= '                                  <i class="fa fa-map-marker"></i>';
            $htmlRow .= '                               </div>';
            $htmlRow .= '                               <h3 class="single-contact-icon-text__title">DIRECCIÓN</h3>';
            $htmlRow .= '                               <p class="single-contact-icon-text__value">' . $street_1 . ',' . $street_2 . '</p>';
            $htmlRow .= '                       </div>';
            $htmlRow .= '                    </div>';

            $htmlRow .= '                    <div class="col-sm-4"> ';
            $htmlRow .= '                       <div class="single-contact-icon-text"> ';
            $htmlRow .= '                              <div class="single-contact-icon-text__icon">';
            $htmlRow .= '                                  <i class="fa fa-phone"></i>';
            $htmlRow .= '                               </div>';
            $htmlRow .= '                               <h3 class="single-contact-icon-text__title">TELÉFONO</h3>';
            $htmlRow .= '                               <p class="single-contact-icon-text__value">' . $phone_value . '</p>';
            $htmlRow .= '                       </div>';
            $htmlRow .= '                    </div>';

            $htmlRow .= '                    <div class="col-sm-4"> ';
            $htmlRow .= '                       <div class="single-contact-icon-text"> ';
            $htmlRow .= '                              <div class="single-contact-icon-text__icon">';
            $htmlRow .= '                                  <i class="fa fa-envelope"></i>';
            $htmlRow .= '                               </div>';
            $htmlRow .= '                               <h3 class="single-contact-icon-text__title">MAIL</h3>';
            $htmlRow .= '                               <p class="single-contact-icon-text__value">' . $email . '</p>';
            $htmlRow .= '                       </div>';
            $htmlRow .= '                    </div>';

            $htmlRow .= '             </div>';//ROW
            $htmlRow .= '          </div>';//CONTACT ICON
            $htmlRow .= '     </div>';//COL
            $htmlRow .= '</div>';//ROW

        }


        $htmlRow = new HtmlString($htmlRow);
        return $htmlRow;
    }

    public static function getHtmlAboutUsParent($params)
    {
        $data = $params['data'];
        $language = $params['language'] == 'es' ? null : $params['language'];

        $title = $language == null ? $data->value : ((isset($data->value_lang) && $data->value_lang) ? $data->value_lang : $data->value);
        $description = $language == null ? $data->description : ((isset($data->description_lang) && $data->description_lang) ? $data->description_lang : $data->description);
        $allow_source = $data->allow_source;
        $resourcePathServer = $params['resourcePathServer'];

        $source = URL($resourcePathServer.$data->source);

        $htmlRow = '';
        $htmlRow .= ' <div class="about-us-brief-wrapper section-space--small">';
        $htmlRow .= '    <div class="container">';
        $htmlRow .= '      <div class="row align-items-center">';
        $htmlRow .= '        <div class="col-xl-4 col-lg-5">';
        $htmlRow .= '               <h2 class="about-us-brief-title">' . $title . '</h2>';
        $htmlRow .= '        </div>';
        $htmlRow .= '        <div class="col-xl-8 col-lg-7">';
        $htmlRow .= '               <div class="about-us-brief-desc">';
        $htmlRow .= $description;
        $htmlRow .= '              </div>';
        $htmlRow .= '        </div>';
        $htmlRow .= '      </div>';
        $htmlRow .= '    </div>';
        $htmlRow .= ' </div>';

        if ($allow_source == 1) {

            $htmlRow .= '<div class="about-us-slider-wrapper section-space--small">';
            $htmlRow .= '   <div class="container">';
            $htmlRow .= '       <div class="row">';
            $htmlRow .= '           <div class="col-lg-12">';
            $htmlRow .= '               <div class="about-us-slider theme-slick-slider" data-slick-setting=\'{';
            $htmlRow .= '                   "slidesToShow": 1,';
            $htmlRow .= '                   "slidesToScroll": 1,';
            $htmlRow .= '                   "arrows": false,';
            $htmlRow .= '                       "dots": true,';
            $htmlRow .= '                    "autoplay": false,';
            $htmlRow .= '                   "autoplaySpeed": 5000,';
            $htmlRow .= '                   "speed": 500,';
            $htmlRow .= '                   "prevArrow": {"buttonClass": "slick-prev", "iconClass": "fa fa-angle-left" },';
            $htmlRow .= '                   "nextArrow": {"buttonClass": "slick-next", "iconClass": "fa fa-angle-right" }';
            $htmlRow .= '                  }\' data-slick-responsive=\'[';
            $htmlRow .= '                    {"breakpoint":1501, "settings": {"slidesToShow": 1, "arrows": false} },';
            $htmlRow .= '                   {"breakpoint":1199, "settings": {"slidesToShow": 1, "arrows": false} },';
            $htmlRow .= '                   {"breakpoint":991, "settings": {"slidesToShow": 1, "arrows": false, "slidesToScroll": 1} },';
            $htmlRow .= '                   {"breakpoint":767, "settings": {"slidesToShow": 1, "arrows": false, "slidesToScroll": 1} },';
            $htmlRow .= '                   {"breakpoint":575, "settings": {"slidesToShow": 1, "arrows": false, "slidesToScroll": 1} },';
            $htmlRow .= '                   {"breakpoint":479, "settings": {"slidesToShow": 1, "arrows": false, "slidesToScroll": 1} }';
            $htmlRow .= '                   ]\'>';
            $htmlRow .= '           <div class="single-image">';
            $htmlRow .= '                <img src="' . $source . '" class="img-fluid" alt="">';
            $htmlRow .= '            </div>';
            $htmlRow .= '               </div>';
            $htmlRow .= '            </div>';
            $htmlRow .= '        </div>';
            $htmlRow .= '    </div>';
            $htmlRow .= '</div>';
        }

        $htmlRow = new HtmlString($htmlRow);
        return $htmlRow;
    }

    public static function getHtmlAboutUsChildren($params)
    {
        $htmlRow = '';
        $data = $params['data'];
        $language = $params['language'] == 'es' ? null : $params['language'];

        $htmlRow = '<div class="about-us-process-wrapper">';
        $htmlRow .= '    <div class="container">';
        $resourcePathServer = $params['resourcePathServer'];


        foreach ($data as $key => $valueRow) {
            $columns = $valueRow['data'];
            $htmlRow .= '     <div class="row">';
            $countCurrent = count($columns);
            $classColumn = 12 / $countCurrent;
            foreach ($columns as $keyCol => $column) {

                $title = $language == null ? $column['title'] : ((isset($column['title_lang']) && $column['title_lang']) ? $column['title_lang'] : $column['title']);
                $description = $language == null ? $column['description'] : ((isset($column['description_lang']) && $column['description_lang']) ? $column['description_lang'] : $column['description']);

                $allow_source = $column['allow_source'];

                $source = URL($resourcePathServer.$column['source']);

                $htmlRow .= '        <div class="col-md-' . $classColumn . '  col-lg-' . $classColumn . '  col-sm-12">';
                $htmlRow .= '          <div class="single-process">';
                $htmlRow .= '           <h3 class="title">' . $title . '</h3> ';
                $htmlRow .= '            <p class="description" >' . $description;
                $htmlRow .= '             </p>';
                $htmlRow .= '          </div>';
                $htmlRow .= '        </div>';

            }
            $htmlRow .= '    </div>';

        }
        $htmlRow .= '    </div>';

        $htmlRow .= '</div>';

        $htmlRow = new HtmlString($htmlRow);
        return $htmlRow;
    }

    public static function getHtmlServiceParent($params)
    {
        $data = $params['data'];

        $language = $params['language'] == 'es' ? null : $params['language'];
        $title = $language == null ? $data->value : ((isset($data->value_lang) && $data->value_lang) ? $data->value_lang : $data->value);
        $description = $language == null ? $data->description : ((isset($data->description_lang) && $data->description_lang) ? $data->description_lang : $data->description);
        $allow_source = $data->allow_source;
        $source = $data->source;

        $htmlRow = '';
        $htmlRow .= '      <div class="row">';
        $htmlRow .= '        <div class="col-lg-12">';
        $htmlRow .= '          <div class="section-title-area ">';
        $htmlRow .= '               <h2 class="section-title">' . $title . '</h2>';
        $htmlRow .= '               <div class="section-description">' . $description . '</div>';
        $htmlRow .= '         </div>';
        $htmlRow .= '        </div>';
        $htmlRow .= '      </div>';


        if ($allow_source == 1) {


        }

        $htmlRow = new HtmlString($htmlRow);
        return $htmlRow;
    }

    public static function getHtmlServiceChildren($params)
    {
        $htmlRow = '';
        $data = $params['data'];

        $language = $params['language'] == 'es' ? null : $params['language'];
        $htmlRow = '<div class="row">';
        $htmlRow .= '    <div class="col-lg-12">';
        $htmlRow .= '     <div class="service-text-area-wrapper">';

        foreach ($data as $key => $valueRow) {
            $columns = $valueRow['data'];
            $htmlRow .= '     <div class="row">';
            $countCurrent = count($columns);
            $classColumn = 12 / $countCurrent;
            foreach ($columns as $keyCol => $column) {
                $title = $language == null ? $column['title'] : ((isset($column['title_lang']) && $column['title_lang']) ? $column['title_lang'] : $column['title']);
                $description = $language == null ? $column['description'] : ((isset($column['description_lang']) && $column['description_lang']) ? $column['description_lang'] : $column['description']);
                $allow_source = $column['allow_source'];
                $source = $column['source'];
                $htmlRow .= '        <div class="col-md-' . $classColumn . '  col-lg-' . $classColumn . '  col-sm-12">';
                $htmlRow .= '          <div class="single-service-text">';
                $htmlRow .= '           <h2 class="title">' . $title . '</h2> ';
                $htmlRow .= '            <p class="short-desc"" >' . $description;
                $htmlRow .= '             </p>';
                $htmlRow .= '          </div>';
                $htmlRow .= '        </div>';

            }
            $htmlRow .= '    </div>';

        }
        $htmlRow .= '    </div>';
        $htmlRow .= '    </div>';
        $htmlRow .= '</div>';


        $htmlRow = new HtmlString($htmlRow);
        return $htmlRow;
    }

    /* SHOP*/
    public static function getHtmlCategoriesShop($params)
    {
        $htmlRow = '';
        $data = $params['data'];
        $language = $params['language'] == 'es' ? null : $params['language'];

        $titleCategories = __('shop.filters.categories');

        $htmlRow = '<h2 class="single-sidebar-widget__title">' . $titleCategories . ' <span class="content-filter not-view"><i id="icon-filters"><span aria-hidden="true">×</span></i></span> </h2>';
        $htmlRow .= '     <ul class="single-sidebar-widget__dropdown" id="single-sidebar-widget__dropdown">';


        foreach ($data as $key => $valueRow) {

            $title = $language == null ? $valueRow['value'] : ((isset($valueRow['value_lang']) && $valueRow['value_lang']) ? $valueRow['value_lang'] : $valueRow['value']);
            $id = $valueRow['id'];
            $htmlRow .= '     <li class="has-children li-category"       category="' . $id . '" >';
            $htmlRow .= '         <a  href="javascript:void(0)"  class="a-category">' . $title . '</a>';
            $htmlRow .= '           <ul class="sub-menu">';
            $dataSubcategories = $valueRow['data'];
            foreach ($dataSubcategories as $key => $valueSubcategory) {
                $titleSubcategory = $language == null ? $valueSubcategory->value : ((isset($valueSubcategory->value_lang) && $valueSubcategory->value_lang) ? $valueSubcategory->value_lang : $valueSubcategory->value);
                $idSubcategory = $valueSubcategory->id;
                $htmlRow .= '             <li class="li-subcategory" subcategory="' . $idSubcategory . '" category="' . $id . '" ><a class="a-subcategory"  href="javascript:void(0)" subcategory="' . $idSubcategory . '" category="' . $id . '" >' . $titleSubcategory . '</a></li> ';
            }
            $htmlRow .= '           </ul>';
            $htmlRow .= '     </li>';

        }

        $htmlRow .= '   </ul>';
        $htmlRow = new HtmlString($htmlRow);
        return $htmlRow;
    }

    public static function getHtmlChat($params)
    {
        $htmlRow = '';
        $data = $params['data'];
        $options = json_decode($data->options);

        /*  <!-- Your customer chat code XYWER 653960618397569-->*/
        $htmlRow .= '<div class="fb-customerchat"';
        $htmlRow .= '   attribution=' . $options->attribution;
        $htmlRow .= '   logged_in_greeting="' . $options->logged_in_greeting . '"';
        $htmlRow .= '   theme_color="' . $options->theme_color . '"';
        $htmlRow .= '   logged_out_greeting="' . $options->logged_out_greeting . '"';
        $htmlRow .= '   page_id="' . $data->page_id . '"';
        $htmlRow .= '   >';
        $htmlRow .= '</div> ';
        /* <!-- Load Facebook SDK for JavaScript -->*/
        $htmlRow .= '<div id="fb-root"></div> ';
        $htmlRow = new HtmlString($htmlRow);
        return $htmlRow;
    }

    public static function getHtmlLogoHeader($params)
    {
        $htmlRow = '';
        $data = $params['data'];
        $page = $params['page'];
        $resourcePathServer = $params["resourcePathServer"];

        $htmlRow .= '<img src="' . URL($resourcePathServer . $data->source) . '" class="img-fluid" alt="">';
        if ($page == 'home') {
            $htmlRow .= '<img src="' . URL($resourcePathServer . $data->source ). '" class="img-fluid" alt=""> ';
        }

        $htmlRow = new HtmlString($htmlRow);
        return $htmlRow;
    }

    public static function getHtmlLogoHeaderMobile($params)
    {
        $htmlRow = '';
        $data = $params['data'];
        $resourcePathServer = $params["resourcePathServer"];

        $htmlRow .= '<img src="' .URL($resourcePathServer . $data->source) . '" class="img-fluid" alt="">';
        $htmlRow = new HtmlString($htmlRow);
        return $htmlRow;
    }

    public static function getHtmlProductDetails($params)
    {
        $htmlRow = '';
        $product = $params['product'];
        $multimedia = $params['multimedia'];
        $allowShop = $params['allowShop'];
        $language = $params['language'] == 'es' ? null : $params['language'];
        $resourcePathServer = $params["resourcePathServer"];

        $discount = isset($params['discount']) ? true : false;
        $hot = isset($params['hot']) ? true : false;
        $color = isset($params['color']) ? true : false;
        $product_id_whishlist = isset($product->product_id_whishlist) ? $product->product_id_whishlist : null;
        $imagesString = '';
        $imagesString .= '<div class="single-image">';
        $imagesString .= '  <img src="' .  URL($resourcePathServer.$product->source ). '" class="img-fluid" alt="' . $product->name . '">';
        $imagesString .= '</div>';

        $productName = $language == null ? $product->name : (isset($product->name_lang) && $product->name_lang ? $product->name_lang : $product->name);
        $productDescription = $language == null ? $product->description : (isset($product->description_lang) && $product->description_lang ? $product->description_lang : $product->description);

        if (count($multimedia) > 0) {
            foreach ($multimedia as $key => $valueRow) {

                $imagesString .= '<div class="single-image">';
                $imagesString .= '  <img src="' . URL($resourcePathServer.$valueRow->source ). '" class="img-fluid" alt="' . $valueRow->title . '">';
                $imagesString .= '</div>';

            }
        }

        $htmlRow .= ' <div class="single-product-slider-details-area">';
        $htmlRow .= '    <div class="container">';
        $htmlRow .= '         <div class="row">';
        $htmlRow .= '            <div class="col-lg-6">';
        $htmlRow .= '                 <div class="product-details-slider-area product-details-slider-area--side-move">';

        if ($hot) {
            $htmlRow .= '                <div class="product-badge-wrapper">';
            $htmlRow .= '                    <span class="hot">Hot</span>';
            $htmlRow .= '            </div>';

        }
        $htmlRow .= '                    <div class="row row-5">';
        $htmlRow .= '                       <div class="col-md-9 order-1 order-md-2">';
        $htmlRow .= '                            <div class="big-image-wrapper">';
        $htmlRow .= '                                 <div class="enlarge-icon">';
        $htmlRow .= '                                         <a class="btn-zoom-popup" href="javascript:void(0)"';
        $htmlRow .= '                                             data-tippy="Click to enlarge" data-tippy-placement="left"';
        $htmlRow .= '                                             data-tippy-inertia="true" data-tippy-animation="shift-away"';
        $htmlRow .= '                                             data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">';
        $htmlRow .= '                                             <i class="pe-7s-expand1"></i>';
        $htmlRow .= '                                          </a>';
        $htmlRow .= '                               </div>';//enlarge-icon
        $htmlRow .= '                                   <div class="product-details-big-image-slider-wrapper product-details-big-image-slider-wrapper--side-space theme-slick-slider"';
        $htmlRow .= '                                       data-slick-setting=\'{';
        $htmlRow .= '                                       "slidesToShow": 1,';
        $htmlRow .= '                                       "slidesToScroll": 1,';
        $htmlRow .= '                                       "arrows": false,';
        $htmlRow .= '                                       "autoplay": false,';
        $htmlRow .= '                                       "autoplaySpeed": 5000,';
        $htmlRow .= '                                       "fade": true,';
        $htmlRow .= '                                       "speed": 500,';
        $htmlRow .= '                                       "prevArrow": {"buttonClass": "slick-prev", "iconClass": "fa fa-angle-left" },';
        $htmlRow .= '                                        "nextArrow": {"buttonClass": "slick-next", "iconClass": "fa fa-angle-right" }';
        $htmlRow .= '                                         }\' data-slick-responsive=\'[';
        $htmlRow .= '                                          {"breakpoint":1501, "settings": {"slidesToShow": 1, "arrows": false} },';
        $htmlRow .= '                                           {"breakpoint":1199, "settings": {"slidesToShow": 1, "arrows": false} },';
        $htmlRow .= '                                            {"breakpoint":767, "settings": {"slidesToShow": 1, "arrows": false, "slidesToScroll": 1} },';
        $htmlRow .= '                                            {"breakpoint":575, "settings": {"slidesToShow": 1, "arrows": false, "slidesToScroll": 1} },';
        $htmlRow .= '                                             {"breakpoint":479, "settings": {"slidesToShow": 1, "arrows": false, "slidesToScroll": 1} }';
        $htmlRow .= '                                        ]\'>';
        $htmlRow .= '                                        ' . $imagesString;
        $htmlRow .= '                                  </div>';//product-details-big-image-slider-wrapper
        $htmlRow .= '                            </div>';//big-image-wrapper
        $htmlRow .= '                      </div>';//col-md-9 order-1 order-md-2
        $htmlRow .= '                          <div class="col-md-3 order-2 order-md-1">';
        $htmlRow .= '                               <div class="product-details-small-image-slider-wrapper product-details-small-image-slider-wrapper--vertical-space theme-slick-slider"';
        $htmlRow .= '                                       data-slick-setting=\'{';
        $htmlRow .= '                                       "slidesToShow": 3,';
        $htmlRow .= '                                         "slidesToScroll": 1,  ';
        $htmlRow .= '                                           "centerMode": false,';
        $htmlRow .= '                                           "arrows": true,';
        $htmlRow .= '                                           "vertical": true,';
        $htmlRow .= '                                           "autoplay": false,';
        $htmlRow .= '                                            "autoplaySpeed": 5000,';
        $htmlRow .= '                                           "speed": 500, ';
        $htmlRow .= '                                             "asNavFor": ".product-details-big-image-slider-wrapper",';
        $htmlRow .= '                                            "focusOnSelect": true,';
        $htmlRow .= '                                           "prevArrow": {"buttonClass": "slick-prev", "iconClass": "fa fa-angle-up" },';
        $htmlRow .= '                                            "nextArrow": {"buttonClass": "slick-next", "iconClass": "fa fa-angle-down" }';
        $htmlRow .= '                                            }\' data-slick-responsive=\'[';
        $htmlRow .= '                                            {"breakpoint":1501, "settings": {"slidesToShow": 3, "arrows": true} },';
        $htmlRow .= '                                             {"breakpoint":1199, "settings": {"slidesToShow": 3, "arrows": true} },';
        $htmlRow .= '                                            {"breakpoint":991, "settings": {"slidesToShow": 3, "arrows": true, "slidesToScroll": 1} },';
        $htmlRow .= '                                            {"breakpoint":767, "settings": {"slidesToShow": 3, "arrows": false, "slidesToScroll": 1, "vertical": false, "centerMode": true} },';
        $htmlRow .= '                                          {"breakpoint":575, "settings": {"slidesToShow": 3, "arrows": false, "slidesToScroll": 1, "vertical": false, "centerMode": true} }, ';
        $htmlRow .= '                                           {"breakpoint":479, "settings": {"slidesToShow": 2, "arrows": false, "slidesToScroll": 1, "vertical": false, "centerMode": true} }';
        $htmlRow .= '                                         ]\'>';
        $htmlRow .= '                                       ' . $imagesString;
        $htmlRow .= '                                </div>';//product-details-small-image-slider-wrapper
        $htmlRow .= '                         </div>';//col-md-3 order-2 order-md-1
        $htmlRow .= '                     </div>';//row row-5
        $htmlRow .= '                      </div>';//product-details-slider-area
        $htmlRow .= '                 </div>';//col-lg-6
        $salePrice = number_format($product->sale_price, 2, ',', '');
        $htmlRow .= '                 <div class="col-lg-6">';
        $htmlRow .= '                      <div class="product-details-description-wrapper">';
        $htmlRow .= '                            <h2 class="item-title">' . $productName . '</h2>';
        $htmlRow .= '                            <p class="price">';
        $htmlRow .= '                               <span class="main-price ' . ($discount ? 'discounted' : '') . '">$' . $salePrice . '</span>';
        if ($discount) {
            $htmlRow .= '                                <span class="discounted-price">$300.00</span>';
        }
        $htmlRow .= '                             </p> ';
        $htmlRow .= '                            <p class="description"> ';
        $htmlRow .= '                           ' . $productDescription;
        $htmlRow .= '                            </p>';
        if ($color) {
            $htmlRow .= '                         <div class="product-color">';
            $htmlRow .= '                            <span class="product-details-title">COLOR: </span>';
            $htmlRow .= '                               <ul>';
            $htmlRow .= '                                   <li>';
            $htmlRow .= '                                       <a class="active" href="#" data-tippy="Black" data-tippy-inertia="true"';
            $htmlRow .= '                                           data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"';
            $htmlRow .= '                                           data-tippy-theme="roundborder">';
            $htmlRow .= '                                            <span class="color-picker black"></span>';
            $htmlRow .= '                                        </a>';
            $htmlRow .= '                                   </li>';
            $htmlRow .= '                                   <li>';
            $htmlRow .= '                                       <a class="active" href="#" data-tippy="Blue" data-tippy-inertia="true"';
            $htmlRow .= '                                           data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"';
            $htmlRow .= '                                           data-tippy-theme="roundborder">';
            $htmlRow .= '                                            <span class="color-picker blue"></span>';
            $htmlRow .= '                                        </a>';
            $htmlRow .= '                                   </li>';
            $htmlRow .= '                                   <li>';
            $htmlRow .= '                                       <a class="active" href="#" data-tippy="Brown" data-tippy-inertia="true"';
            $htmlRow .= '                                           data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"';
            $htmlRow .= '                                           data-tippy-theme="roundborder">';
            $htmlRow .= '                                            <span class="color-picker brown"></span>';
            $htmlRow .= '                                        </a>';
            $htmlRow .= '                                   </li>';
            $htmlRow .= '                                </ul>';
            $htmlRow .= '                            </div>';
        }

        if ($allowShop) {

            $htmlRow .= '                                <div class="pro-qty d-inline-block">';
            $htmlRow .= '                                     <input type="text" value="1" id="product-amount">';
            $htmlRow .= '                                </div>   ';
            $htmlRow .= '                               <div class="add-to-cart-btn d-inline-block">';
            $htmlRow .= '                                    <button class="theme-button theme-button--alt add-cart add-cart--product-details">'.__('config.buttons.one').'</button> ';
            $htmlRow .= '                               </div>';

        }
        $htmlRow .= '                                <div class="quick-view-other-info">';
        $htmlRow .= '                                     <div class="other-info-links">';
        $htmlRow .= '                                         <a product-id="' . $product->id . '" class="add-wish-list add-wish-list-view-details ' . ($product_id_whishlist ? "favorite-icon-active" : "") . '" href="javascript:void(0)" product-id="' . $product->id . '"><i class="fa fa-heart-o"></i> ADD TO WISHLIST</a>';
        $htmlRow .= '                                     </div>';
        $htmlRow .= '                                     <table>';
        $htmlRow .= '                                         <tr class="single-info">';
        $htmlRow .= '                                             <td class="quickview-title">Codigo:</td>';
        $htmlRow .= '                                             <td class="quickview-value">' . $product->code . '</td> ';
        $htmlRow .= '                                         </tr>';
        $htmlRow .= '                                         <tr class="single-info">';
        $htmlRow .= '                                             <td class="quickview-title">Categoria:</td>';
        $htmlRow .= '                                             <td class="quickview-value">' . $product->product_category . '</td> ';
        $htmlRow .= '                                         </tr>';
        $htmlRow .= '                                         <tr class="single-info">';
        $htmlRow .= '                                             <td class="quickview-title">Compartir:</td>';
        $htmlRow .= '                                             <td class="quickview-value">';
        $htmlRow .= '                                                 <ul class="quickview-social-icons">';
        $htmlRow .= '                                                     <li><a href="#"><i class="fa fa-facebook"></i></a></li>';
        $htmlRow .= '                                                     <li><a href="#"><i class="fa fa-twitter"></i></a></li>';
        $htmlRow .= '                                                     <li><a href="#"><i class="fa fa-google-plus"></i></a></li>';
        $htmlRow .= '                                                     <li><a href="#"><i class="fa fa-pinterest"></i></a></li>';
        $htmlRow .= '                                                 </ul>';
        $htmlRow .= '                                         </tr>';
        $htmlRow .= '                                       </table>';
        $htmlRow .= '                                   </div>';//quick-view-other-info
        $htmlRow .= '                                </div>';//product-details-description-wrapper
        $htmlRow .= '                            </div>';//col-lg-6
        $htmlRow .= '                         </div>';//row
        $htmlRow .= '                     </div>';//container

        $htmlRow .= '              </div>';//single-product-slider-details-area


        $htmlRow .= '        <div class="single-product-description-tab-area section-space">         ';

        $htmlRow .= '          <div class="description-tab-navigation"> ';
        $htmlRow .= '                      <div class="nav nav-tabs justify-content-center" id="nav-tab2" role="tablist"> ';
        $htmlRow .= '                           <a class="nav-item nav-link active" id="description-tab" data-toggle="tab"';
        $htmlRow .= '                               href="#product-description"';
        $htmlRow .= '                               role="tab" aria-selected="true">DESCRIPTION';
        $htmlRow .= '                            </a>';
        if (false) {

            $htmlRow .= '                           <a class="nav-item nav-link" id="review-tab" data-toggle="tab"';
            $htmlRow .= '                               href="#product-review"';
            $htmlRow .= '                               role="tab" aria-selected="true">REVIEWS (3)';
            $htmlRow .= '                            </a>';
        }

        $htmlRow .= '                   </div>';//nav nav-tabs
        $htmlRow .= '          </div>';//description-tab-navigation

        $htmlRow .= '          <div class="single-product-description-tab-content">';
        $htmlRow .= '           <div class="tab-content">';
        $htmlRow .= '            <div class="tab-pane fade show active" id="product-description" role="tabpanel"';
        $htmlRow .= '                           aria-labelledby="description-tab">';
        $htmlRow .= '                 <div class="container">';
        $htmlRow .= '                     <div class="row">';
        $htmlRow .= '                     <div class="col-lg-12">';
        $htmlRow .= '                        <div class="description-content">';
        $htmlRow .= '                            ' . $productDescription;
        $htmlRow .= '                     </div>';//description-content
        $htmlRow .= '                 </div>';//col-lg-12
        $htmlRow .= '                </div>';//row
        $htmlRow .= '               </div>';//container
        $htmlRow .= '              </div>';//tab-pane product-description

        $htmlRow .= '              <div class="tab-pane fade" id="product-review" role="tabpanel"';
        $htmlRow .= '                           aria-labelledby="review-tab">';
        $htmlRow .= '                    <div class="container">';
        $htmlRow .= '                        <div class="row">';
        $htmlRow .= '                             <div class="col-lg-12">';


        $htmlRow .= '                                    <div class="review-content-wrapper">';
        $htmlRow .= '                                       <div class="review-comments">';
        $htmlRow .= '                                             <h4 class="review-comment-title">6 REVIEWS FOR OLIVIA SHAYN COVER CHAIR</h4>';
        $htmlRow .= '                                             <div class="single-review-comment"> ';
        $htmlRow .= '                                                   <div class="single-review-comment__image"> ';
        $htmlRow .= '                                                        <img src="'.URL($resourcePathServer ).'/frontend/assets/img/review/one.png" class="img-fluid" alt="">';
        $htmlRow .= '                                                   </div> ';
        $htmlRow .= '                                                  <div class="single-review-comment__content">';
        $htmlRow .= '                                                      <div class="review-time"><i class="fa fa-calendar"></i> June 7, 2019';
        $htmlRow .= '                                                      </div> ';
        $htmlRow .= '                                                      <div class="rating"> ';
        $htmlRow .= '                                                         <i class="fa fa-star active"></i> ';
        $htmlRow .= '                                                        <i class="fa fa-star active"></i> ';
        $htmlRow .= '                                                         <i class="fa fa-star active"></i> ';
        $htmlRow .= '                                                          <i class="fa fa-star active"></i> ';
        $htmlRow .= '                                                           <i class="fa fa-star active"></i> ';
        $htmlRow .= '                                                      </div> ';
        $htmlRow .= '                                                      <p class="review-text">Lorem, ipsum dolor sit amet consectetur';
        $htmlRow .= '                                                        adipisicing elit. Fuga, in.';
        $htmlRow .= '                                                      </p>';
        $htmlRow .= '                                                 </div>';//single-review-comment__content
        $htmlRow .= '                                             </div>';//single-review-comment
        $htmlRow .= '                                      </div>';//review-comments


        $htmlRow .= '                                     <div class="review-comment-form">';
        $htmlRow .= '                                                   <h4 class="review-comment-title">Add a review</h4>';
        $htmlRow .= '                                                   <p class="review-comment-subtitle">Your email address will not be published.';
        $htmlRow .= '                                                     Required fields are marked *</p>';
        $htmlRow .= '                                                   <form action="#">';
        $htmlRow .= '                                                      <div class="form-group">';
        $htmlRow .= '                                                          <label for="reviewerName">Name <span>*</span> </label>';
        $htmlRow .= '                                                           <input type="text" id="reviewerName" required>';
        $htmlRow .= '                                                      </div>';
        $htmlRow .= '                                                      <div class="form-group">';
        $htmlRow .= '                                                          <label for="reviewerEmail">Email <span>*</span> </label>';
        $htmlRow .= '                                                           <input type="email" id="reviewerEmail" required>';
        $htmlRow .= '                                                      </div>';
        $htmlRow .= '                                                      <div class="form-group">';
        $htmlRow .= '                                                          <label for="reviewRating" class="d-inline-block mb-0">Your rating </label>';
        $htmlRow .= '                                                           <div class="rating d-inline-block" id="reviewRating">';
        $htmlRow .= '                                                              <i class="fa fa-star active"></i>';
        $htmlRow .= '                                                              <i class="fa fa-star active"></i>';
        $htmlRow .= '                                                              <i class="fa fa-star active"></i>';
        $htmlRow .= '                                                              <i class="fa fa-star active"></i>';
        $htmlRow .= '                                                              <i class="fa fa-star active"></i>';
        $htmlRow .= '                                                            </div>';
        $htmlRow .= '                                                      </div>';
        $htmlRow .= '                                                      <div class="form-group">';
        $htmlRow .= '                                                           <label for="reviewComment">Your review <span>*</span></label>';
        $htmlRow .= '                                                           <textarea name="reviewComment" id="reviewComment" cols="30"';
        $htmlRow .= '                                                              rows="10">';
        $htmlRow .= '                                                           </textarea>';
        $htmlRow .= '                                                      </div>';
        $htmlRow .= '                                                      <button type="submit" class="theme-button">SUBMIT</button>';
        $htmlRow .= '                                              </form>';
        $htmlRow .= '                                       </div>';//review-comment-form
        $htmlRow .= '                                 </div>';//review-content-wrapper
        $htmlRow .= '                          </div>';//col-lg-12
        $htmlRow .= '                    </div>';//row
        $htmlRow .= '                </div>';//container
        $htmlRow .= '         </div>';//product-review
        $htmlRow .= '      </div>';//tab-content
        $htmlRow .= '  </div>';//single-product-description-tab-area section-space


        $htmlRow = new HtmlString($htmlRow);
        return $htmlRow;
    }

    public static function getHtmlMetaDataProduct($params)
    {
        $htmlRow = '';
        $product = $params['product'];
        $multimedia = $params['multimedia'];
        $resourcePathServer = $params["resourcePathServer"];

        $discount = isset($params['discount']) ? true : false;
        $hot = isset($params['hot']) ? true : false;
        $color = isset($params['color']) ? true : false;
        $url = URL('productDetails/' . $product->id);
        $htmlRow .= "<meta property='og:type' content='shop'/>";
        $htmlRow .= "<meta property='og:url' content='" . $url . "'/>";
        $htmlRow .= "<meta property='og:title' content='" . $product->name . "'/>";
        $htmlRow .= "<meta property='og:description' content='" . $product->description . "'/>";
        $htmlRow .= "<meta property='og:image' content='" . URL($resourcePathServer.$product->source) . "'/>";
        $htmlRow .= "<meta property='og:image:width' content='400'/>";
        $htmlRow .= "<meta property='og:image:height' content='400'/>";
        $htmlRow .= "<meta property='og:image:alt' content='" . $product->name . "'/>";
        $htmlRow .= "<meta content='" . env('APP_NAME_FRONTEND_CONTENT') . "' name='description' />";
        $htmlRow .= "<meta content='" . env('APP_NAME_FRONTEND_AUTHOR') . "' name='author' />";

        $htmlRow = ($htmlRow);
        return $htmlRow;
    }

    public static function getHtmlCountriesSelect($params)
    {
        $htmlRow = '';
        $data = $params['data'];
        $name = $params['name'];
        $id = $params['id'];
        $required = isset($params['required']) ? $params['required'] : false;

        $currentClass = $params['class'];
        $htmlRow .= ' <select      v-model.trim="$v.model.attributes.' . $id . ' .$model"
                     @change="_managerCountry(\'' . $id . '\', $v.model.attributes.' . $id . '.$model)" class="' . $currentClass . '" name="' . $name . '"  id="' . $id . '"  ' . ($required ? 'required' : '') . ' >';

        foreach ($data as $key => $valueRow) {
            $htmlRow .= '  <option value="' . $valueRow->id . '">' . $valueRow->name . '</option> ';

        }
        $htmlRow .= ' </select>';

        $htmlRow = new HtmlString($htmlRow);
        return $htmlRow;
    }

    public static function getHtmlFaviconHeader($params)
    {
        $htmlRow = '';

        $htmlRow = '';
        $data = $params['data'];
        $htmlRow .= '<link rel="icon" href="' . $data->source . '">';


        $htmlRow = new HtmlString($htmlRow);

        return $htmlRow;
    }

    public static function getHtmlPaymentsTypes($params)
    {
        $htmlRow = '';
        $data = $params['data'];

        foreach ($data as $key => $valueRow) {

            $allowSet = false;
            $structure = '';
            if ($valueRow != null) {
                $allowSet = true;
            }
            if ($key == 'pay-pal') {
                if ($valueRow) {
                    $title = __('payments.type.payPal.title');
                    $intro = __('payments.type.payPal.intro');

                    $structure = '<input       @change="_setValueForm(\'payment_paypal\', $v.model.attributes.payment_paypal.$model)"  v-model.trim="$v.model.attributes.payment_paypal.$model" type="radio" id="payment_paypal" name="payment-method" value="pay-pal" >';
                    $structure .= '<label for="payment_paypal">' . $title . '</label>';
                    $msgPayment = $intro;
                    $structure .= '<div class="payments-information" data-method="payment_paypal">';
                    $structure .= $msgPayment;
                    if ($valueRow->msj_to_customer) {
                        $structure .= '<div class="manager-msj-to-customer">' . $valueRow->msj_to_customer . '</div>';
                    }

                    $structure .= '</div>';
                }

            } elseif ($key == 'api-credit-cards') {
                if ($valueRow) {
                    $title = __('payments.type.creditCards.title');
                    $intro = __('payments.type.creditCards.intro');
                    $structure = '<input @change="_setValueForm(\'payment_payoneer\', $v.model.attributes.payment_payoneer.$model)"  v-model.trim="$v.model.attributes.payment_payoneer.$model" type="radio" id="payment_payoneer" name="payment-method"  value="api-credit-cards">';
                    $structure .= '<label for="payment_payoneer">' . $title . '</label>';
                    $msgPayment = $intro;

                    $structure .= '<div class="payments-information"  data-method="payment_payoneer">';
                    $structure .= $msgPayment;
                    if ($valueRow->msj_to_customer) {
                        $structure .= '<div class="manager-msj-to-customer">' . $valueRow->msj_to_customer . '</div>';
                    }
                    $structure .= '</div>';
                }
            } elseif ($key == 'bank-deposit') {

                if ($valueRow) {
                    $title = __('payments.type.bankDeposit.title');
                    $structure = '<input @change="_setValueForm(\'payment_bank\', $v.model.attributes.payment_bank.$model)" v-model.trim="$v.model.attributes.payment_bank.$model" type="radio" id="payment_bank" name="payment-method" value="bank-deposit">';
                    $structure .= '<label for="payment_bank">' . $title . '</label>';
                    $intro = __('payments.type.bankDeposit.intro', ['accountNumber' => $valueRow->password]) . ', ' . $valueRow->user . '.';
                    $msgPayment = $intro;

                    $structure .= '<div class="payments-information"  data-method="payment_bank">';
                    $structure .= $msgPayment;
                    if ($valueRow->msj_to_customer) {
                        $structure .= '<div class="manager-msj-to-customer">' . $valueRow->msj_to_customer . '</div>';
                    }
                    $structure .= '</div>';
                }
            }
            if ($allowSet) {
                $htmlRow .= '<div class="single-method" >' . $structure . '</div>';
            }


        }


        $htmlRow = new HtmlString($htmlRow);
        return $htmlRow;
    }

    /* ---SHOP---*/
    /*  CHECKOUT*/

    public static function getHtmlCheckoutDetails($params)
    {

        $data = $params->details;
        $same_billing_address = $params->same_billing_address;
        $user = '';
        $email = '';
        $isCheckoutEnd = $params->filtersPage->checkout == null ? false : true;

        if ($same_billing_address == 0) {
            $email = $params->delivery->payer_email;
            $user = $params->delivery->name . ' ' . $params->delivery->last_name;
        } else {
            $user = ($params->invoiceHeader->name . ' ' . $params->invoiceHeader->last_name);
            $email = $params->invoiceHeader->payer_email;

        }
        $state = '';
        $stateClass = '';

        if ($params->checkout->manager_state == 0) {
            $state = __('page.checkoutDetails.status.created');
            $stateClass = ' badge-info';

        } else if ($params->checkout->manager_state == 3) {
            $state = __('page.checkoutDetails.status.reject');
            $stateClass = ' badge-danger';

        } else if ($params->checkout->manager_state == 1) {
            $state = __('page.checkoutDetails.status.executed');
            $stateClass = ' badge-warning';


        } else if ($params->checkout->manager_state == 2) {
            $state = __('page.checkoutDetails.status.delivered');
            $stateClass = ' badge-success';

        }


        $htmlRow = ' <div class="container">';
        $checkoutDetails = '';
        $titlePayment = '';

        if ($params->checkout->type_payment_customer == 2) {
            $titlePayment = __('page.checkoutDetails.type-payments.deposit-bank');


        } else if ($params->checkout->type_payment_customer == 0) {//paypal
            $titlePayment = __('page.checkoutDetails.type-payments.pay-pal');


        } else if ($params->checkout->type_payment_customer == 1) {//credit

            $titlePayment = __('page.checkoutDetails.type-payments.credit-card');

        }else if ($params->checkout->type_payment_customer == 3) {//credit

            $titlePayment = "Pay Phone";

        }
        if ($isCheckoutEnd) {
            $msgTypePayment = '';
            if ($params->checkout->type_payment_customer == 2) {
                $msgTypePayment = __('page.checkoutDetails.notes.bank');

            } else if ($params->checkout->type_payment_customer == 0) {//paypal

                $msgTypePayment = __('page.checkoutDetails.notes.pay-pal');

            } else if ($params->checkout->type_payment_customer == 1) {//credit
                $msgTypePayment = __('page.checkoutDetails.notes.credit-cards');

            }else if ($params->checkout->type_payment_customer == 3) {//credit
                $msgTypePayment = "PayPhone ahora ya tienes";

            }
            $checkoutDetails .= '    <div class="row">';
            $checkoutDetails .= '         <div class="col-md-12">';
            $checkoutDetails .= '<div class="alert alert-success alert-dismissible bg-light border-success text-success fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h1> ' . __('page.checkoutDetails.checkout.title') . '</h1> <br>
                                        <div class="information">
                                        <span class="information__msj-send">' . __('page.checkoutDetails.checkout.msg', ['email' => $email]) . '</span> <br>
                                        <span class="information__msj-send-type-payment">' . $msgTypePayment . '</span>
                                         </div>
                                    </div>';
            $checkoutDetails .= '         </div >';
            $checkoutDetails .= '   </div >';

        }


        $checkoutDetails .= '    <div class="row">';
        $checkoutDetails .= '         <div class="col-md-12">';
        $checkoutDetails .= '<div class="alert alert-info alert-dismissible bg-light border-info text-info fade show" role="alert">

                                        <h1> ' . __('page.checkoutDetails.typePayment.title') . '</h1> <br>
                                        <div class="information">
                                        <span class="information__msj-send"> ' . $titlePayment . '</span> <br>

                                         </div>
                                    </div>';
        $checkoutDetails .= '         </div >';
        $checkoutDetails .= '   </div >';
        $htmlRow .= $checkoutDetails;
        $htmlRow .= '    <div class="row">';
        $htmlRow .= '         <div class="col-md-12">';
        $htmlRow .= '            <div class="card-box">';
        if (false) {
            $htmlRow .= '                <div class="clearfix">';
            $htmlRow .= '                     <div class="float-left">';
            $htmlRow .= '                          <img src="assets/images/logo-light.png" alt="" height="20">';
            $htmlRow .= '                      </div>';
            $htmlRow .= '                 </div>';
        }
        $htmlRow .= '                 <div class="row">';
        $htmlRow .= '                     <div class="col-md-6">';
        $htmlRow .= '                         <div class="mt-3">';
        $htmlRow .= '                             <p><b>' . __('page.checkoutDetails.invoice.header.user', ['user' => $user]) . '</b></p>';
        $htmlRow .= '                             <p class="text-muted"><b>' . __('page.checkoutDetails.invoice.header.user.msg') . '</b></p>';
        $htmlRow .= '                         </div>';
        $htmlRow .= '                     </div>';
        $htmlRow .= '                     <div class="col-md-4 offset-md-2">';
        $htmlRow .= '                         <div class="mt-3 float-right">';

        $htmlRow .= '                             <p class="m-b-10"><strong>' . __('page.checkoutDetails.invoice.header.order-date') . '</strong><span class="float-right">' . $params->checkout->start . '</span></p>';
        $htmlRow .= '                             <p class="m-b-10"><strong>' . __('page.checkoutDetails.invoice.header.order-status') . '</strong><span class="float-right"> <span class="badge ' . $stateClass . '">' . $state . '</span></span></p>';
        $htmlRow .= '                             <p class="m-b-10"><strong>' . __('page.checkoutDetails.invoice.header.order-no') . '</strong><span class="float-right">' . str_pad($params->checkout->id, 20, "0", STR_PAD_LEFT) . '</span></p>';
        $htmlRow .= '                         </div>';
        $htmlRow .= '                     </div>';
        $htmlRow .= '                 </div>';
        $htmlRow .= '                 <div class="row mt-3">';
        $htmlRow .= '                     <div class="col-sm-6">';
        $htmlRow .= '                        <h5>' . __('page.checkoutDetails.title.invoice') . '</h5>';
        $htmlRow .= '                         <address>';
        $htmlRow .= '                         ' . ($params->invoiceHeader->name . ' ' . $params->invoiceHeader->last_name) . ('-' . $params->invoiceHeader->document) . '<br>';
        $htmlRow .= '                         ' . ($params->invoiceHeader->address_main) . '<br>';
        $htmlRow .= '                         ' . ($params->invoiceHeader->address_secondary) . '<br>';
        $htmlRow .= '                         ' . ($params->invoiceHeader->state_province) . ',' . ($params->invoiceHeader->country . '-' . $params->invoiceHeader->zipcode) . '<br>';
        $htmlRow .= '                         <abbr title="' . __('page.checkoutDetails.title.phone') . '">' . __('page.checkoutDetails.title.phone.suffix') . ':</abbr>' . $params->invoiceHeader->phone . '<br>';
        $htmlRow .= '                         <abbr title="' . __('page.checkoutDetails.title.email') . '">' . __('page.checkoutDetails.title.email.suffix') . ':</abbr>' . $params->invoiceHeader->payer_email . '<br>';
        $htmlRow .= '                        </address>';
        $htmlRow .= '                    </div>';
        $htmlRow .= '                     <div class="col-sm-6">';
        $htmlRow .= '                        <h5>' . __('page.checkoutDetails.title.delivery') . '</h5>';
        $htmlRow .= '                         <address>';
        $htmlRow .= '                         ' . ($params->delivery->name . ' ' . $params->delivery->last_name) . ('-' . $params->delivery->document) . '<br>';
        $htmlRow .= '                         ' . ($params->delivery->address_main) . '<br>';
        $htmlRow .= '                         ' . ($params->delivery->address_secondary) . '<br>';
        $htmlRow .= '                         ' . ($params->delivery->state_province) . ',' . ($params->delivery->country . '-' . $params->delivery->zipcode) . '<br>';
        $htmlRow .= '                         <abbr title="' . __('page.checkoutDetails.title.phone') . '">' . __('page.checkoutDetails.title.phone.suffix') . ':</abbr>' . $params->delivery->phone . '<br>';
        $htmlRow .= '                         <abbr title="' . __('page.checkoutDetails.title.email') . '">' . __('page.checkoutDetails.title.email.suffix') . ':</abbr>' . $params->delivery->payer_email . '<br>';
        $htmlRow .= '                        </address>';
        $htmlRow .= '                    </div>';
        $htmlRow .= '                 </div>';


        $details = '                <div class="row">';
        $details .= '                     <div class="col-12">';
        $details .= '                            <div class="table-responsive">';
        $details .= '                                  <table class="table mt-4 table-centered">';
        $details .= '                                        <thead>';
        $details .= '                                                 <tr>';
        $details .= '                                                      <th>' . __('page.checkoutDetails.table.header.col2') . '</th> ';
        $details .= '                                                    <th style="width: 10%">' . __('page.checkoutDetails.table.header.col1') . '</th> ';
        $details .= '                                                     <th style="width: 10%">' . __('page.checkoutDetails.table.header.col3') . '</th> ';
        $details .= '                                                    <th style="width: 10%">' . __('page.checkoutDetails.table.header.col4') . '</th> ';
        $details .= '                                                 </tr>';
        $details .= '                                         </thead>';
        $details .= '                                        <tbody>';
        foreach ($data as $key => $valueRow) {
            $routeUrl = route('productDetails', app()->getLocale()) . "/" . $valueRow->product_id;
            $price = (($valueRow->allow_discount == 1 ? $valueRow->price_discount : $valueRow->price));
            $total = $valueRow->quantity * $price;

            $details .= '                                         <tr>';
            $details .= '                                              <th> <a href="' . $routeUrl . '">' . $valueRow->name . '</a></th>';
            $details .= '                                             <th>' . $valueRow->quantity . '</th>';
            $details .= '                                            <th>' . $price . '</th>';
            $details .= '                                            <th>' . $total . '</th>';

            $details .= '                                          </tr>';


        }
        $details .= '                                       </tbody>';
        $details .= '                                 </table>';
        $details .= '                             </div>';
        $details .= '                      </div>';
        $details .= '                </div>';

        $detailsTotal = '                <div class="row">';
        $detailsTotal .= '                     <div class="col-sm-6">';
        $detailsTotal .= '                        <div class="clearfix pt-5">';
        $detailsTotal .= '                            <h6 class="text-muted">' . __('page.checkoutDetails.notes.title') . '</h6>';
        $detailsTotal .= '                             <small class="text-muted">';
        if ($params->checkout->type_payment_customer == 2) {
            $detailsTotal .= '                               ' . __('page.checkoutDetails.notes.bank');
        } else if ($params->checkout->type_payment_customer == 0) {//paypal

            $detailsTotal .= '                               ' . __('page.checkoutDetails.notes.pay-pal');
        } else if ($params->checkout->type_payment_customer == 1) {//credit

            $detailsTotal .= '                               ' . __('page.checkoutDetails.notes.credit-cards');
        }
        else if ($params->checkout->type_payment_customer == 3) {//credit

            $detailsTotal .= '                               ' . __('page.checkoutDetails.notes.credit-cards');
        }
        $detailsTotal .= '                             </small>';
        $detailsTotal .= '                        </div>';
        $detailsTotal .= '                     </div>';
        $detailsTotal .= '                     <div class="col-sm-6">';
        $detailsTotal .= '                        <div class="float-right">';
        $detailsTotal .= '                           <p><b>' . __('page.checkoutDetails.totalManager.subtotal') . '</b> <span class="float-right">' . $params->checkout->subtotal . '</span></p>';
        if (true) {
            $discount = 15;
            $detailsTotal .= '                           <p><b>' . __('page.checkoutDetails.totalManager.discount', ['discount' => 10]) . '</b> <span class="float-right">' . $discount . '</span></p>';
        }
        $detailsTotal .= '                             <h3>' . $params->checkout->subtotal . '</h3>';

        $detailsTotal .= '                        </div>';
        $detailsTotal .= '                        <div class="clearfix"></div>';

        $detailsTotal .= '                    </div>';
        $detailsTotal .= '               </div>';


        $htmlRow .= $details . $detailsTotal;


        $htmlRow .= ' </div>';
        $htmlRow .= ' </div>';
        $htmlRow .= ' </div>';
        $htmlRow .= ' </div> <br>';


        return $htmlRow;
    }
    /*DETAILS*/
}
