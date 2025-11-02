<?php

namespace App\Models;
use Auth;
use Route;


class LanguageConfigManager extends ModelManager
{
    const BUSINESS_ID = 1;
    public $resourcePathServer = '';
    public $languageData = [
        'en', 'es', 'ki'

    ];
    public function managerLanguagePage($languagePost){

        $language=$this->getLanguageValid($languagePost);
        $this->setLanguage($language);
       return [
            'language'=>$language
        ];
    }

    public function getLanguageValid($languagePost)
    {
        $languageCurrent = $languagePost;
        $language = 'es';
        if ($languageCurrent == '' || $languageCurrent == null || in_array($language, $this->languageData) == false) {
            $language = 'es';
        } else {
            $language = $languageCurrent;
        }
        return $language;
    }

    function __construct()
    {
        $this->resourcePathServer = env('APP_IS_SERVER') ? "public" : '';
    }

    public function setLanguage($languagePost)
    {

        $language = $this->getLanguageValid($languagePost);

       $resultSet= \App::setLocale($language);

       return $resultSet;
    }

    public function getLanguageMenu($params)
    {

        $nameRoute = Route::currentRouteName();
        $language = $params['paramsRequest']['language'];
        $dataLanguages = $params['dataLanguages'];

        $menuCurrent = '  <div class="header-top-dropdown">' . "\n";
        $menuLanguage = [];
        $languageCurrent = null;
        foreach ($dataLanguages as $key => $row) {
            if ($row->initials != $language) {

                $menuLanguage[] = $row;
            } else {
                $languageCurrent = $row;
            }
        }
        if($languageCurrent==null){
            $languageCurrent=$dataLanguages[2];
        }

        $menuCurrent .= '   <a >' . $languageCurrent->text . ' <i class="pe-7s-angle-down"></i></a>' . "\n";
        $menuCurrent .= '    <ul class="header-top-dropdown__list">' . "\n";

        foreach ($menuLanguage as $key => $row) {
            $urlSetLanguage = '';
            if ($nameRoute == 'home') {
                $urlSetLanguage = url($row->initials);

            }  else if ($nameRoute == 'root') {
                $urlSetLanguage = url($row->initials);
            } else if ($nameRoute == 'aboutUs') {
                $urlSetLanguage = url($row->initials . '/aboutUs');

            } elseif ($nameRoute == 'contactUs') {
                $urlSetLanguage = url($row->initials . '/contactUs');

            } elseif ($nameRoute == 'services') {
                $urlSetLanguage = url($row->initials . '/services');
            } elseif ($nameRoute == 'shop' || $nameRoute == 'productDetails' || $nameRoute == 'checkout' || $nameRoute == 'cart') {

                $urlCurrentSetLanguage = '';
                if ($nameRoute == 'shop') {
                    $urlCurrentSetLanguage = 'shop/';
                } else if ($nameRoute == 'productDetails') {
                    $urlCurrentSetLanguage = 'productDetails/' . $params['paramsRequest']['id'] . '/';
                } else if ($nameRoute == 'checkout') {
                    $urlCurrentSetLanguage = 'checkout/';
                } else if ($nameRoute == 'cart') {
                    $urlCurrentSetLanguage = 'cart/';
                }
                $urlSetLanguage = url($row->initials . '/' . $urlCurrentSetLanguage);

            } else if ($nameRoute == 'activities') {
                $urlSetLanguage = url($row->initials . '/activitiesGame');

            }
            else if ($nameRoute == 'rewards') {
                $urlSetLanguage = url($row->initials . '/rewardsGame');

            }
            $menuCurrent .= '           <li><a href="' . $urlSetLanguage . '">' . $row->text . '</a></li>' . "\n";

        }
        $menuCurrent .= '    </ul>';
        $menuCurrent .= '    </div>' . "\n";

        $result['menuLanguage'] = $menuCurrent;
        $result['language'] = $language;
        return $result;
    }


}
