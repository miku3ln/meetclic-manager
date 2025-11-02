<?php
//FRONTEND-ROUTES
namespace App\Routes;
use Route;
class FrontendCmsCityBook
{
    public function __construct(array $attributes = [])
    {

        $this->initRoutes([]);
    }

    public function initRoutes($params)
    {/*
        Route::group(['prefix' => 'api-rest/cms', 'middleware' => ['frontendCityBook']], function () {
            //
            Route::get('/CMS/getDataListBusinessGet', 'Api\CmsController@getDataListBusiness')->name('getDataListBusinessGet');
            Route::post('/CMS/getDataListBusiness', 'Api\CmsController@getDataListBusiness')->name('getDataListBusiness');


        });
*/
        Route::get('/', function () {

            $lang = App::getLocale();
            return redirect()->route('homeEatPura', ['language' => $lang]);
        })->name('homePage');
        Route::group(['prefix' => '{language}', 'middleware' => ['frontendCityBook']], function () {
            Route::get('/search', 'Frontend\FrontendCityBookController@search')->name('search');
            Route::get('/listing5', 'Frontend\FrontendCityBookController@listing5')->name('listing5');
            Route::get('/listingSingle/{id?}', 'Frontend\FrontendCityBookController@listingSingle')->name('listingSingle');
            Route::get('/listingSingle2', 'Frontend\FrontendCityBookController@listingSingle2')->name('listingSingle2');
            Route::get('/listingSingle3', 'Frontend\FrontendCityBookController@listingSingle3')->name('listingSingle3');
            Route::get('/listingSingle4', 'Frontend\FrontendCityBookController@listingSingle4')->name('listingSingle4');
            Route::get('/blog', 'Frontend\FrontendCityBookController@blog')->name('blog');
            Route::get('/howItWorks', 'Frontend\FrontendCityBookController@howItWorks')->name('authorSingle');
            Route::get('/dashboardMyProfile', 'Frontend\FrontendCityBookController@dashboardMyProfile')->name('dashboardMyProfile');
            Route::get('/blogSingle', 'Frontend\FrontendCityBookController@blogSingle')->name('blogSingle');
            Route::get('/dashboardMyProfileAddListing', 'Frontend\FrontendCityBookController@dashboardMyProfileAddListing')->name('dashboardMyProfileAddListing');
            Route::get('/header2', 'Frontend\FrontendCityBookController@header2')->name('header2');
            Route::get('/footerFixed', 'Frontend\FrontendCityBookController@footerFixed')->name('footerFixed');
//CMS-TEMPLATE-MENU-ACTION
            Route::get('/comingSoon', 'Frontend\FrontendCityBookController@comingSoon')->name('comingSoon');
            Route::get('/contactUsBee', 'Frontend\FrontendCityBookController@contactUsBee')->name('contactUsBee');
            Route::get('/aboutUsBee', 'Frontend\FrontendCityBookController@aboutUsBee')->name('aboutUsBee');
            Route::get('/ourServicesBee', 'Frontend\FrontendCityBookController@ourServicesBee')->name('ourServicesBee');
            Route::get('/shopBee', 'Frontend\FrontendCityBookController@shopBee')->name('shopBee');
            Route::get('/dictionary/{type}', 'Frontend\FrontendCityBookController@getDictionaryType')->name('dictionaryType');//CMS-TEMPLATE-MENU-ACTION---KICHWA-CASTILIAN
            Route::post("/dictionary/dictionaryKichwaToCastilian/admin", "Frontend\FrontendCityBookController@getDictionaryKichwaToCastilianAdmin")->name('getDictionaryKichwaToCastilianAdmin');
            Route::post("/apuntes/admin", "Frontend\FrontendCityBookController@getApuntesAdmin")->name('getApuntesAdmin');



            Route::get('/contactUs', 'Frontend\FrontendCityBookController@contactUs')->name('contactUs');
            Route::get('/productFlowers', 'Frontend\FrontendCityBookController@productFlowers')->name('productFlowers');
            Route::get('/productFrozen', 'Frontend\FrontendCityBookController@productFrozen')->name('productFrozen');
            Route::get('/productFruits', 'Frontend\FrontendCityBookController@productFruits')->name('productFruits');
            Route::get('/productBox', 'Frontend\FrontendCityBookController@productBox')->name('productBox');
            Route::get('/productProducts', 'Frontend\FrontendCityBookController@productProducts')->name('productProducts');

            Route::get('/FAQ', 'Frontend\FrontendCityBookController@FAQ')->name('FAQ');

            Route::get('/aboutUs', 'Frontend\FrontendCityBookController@aboutUs')->name('aboutUs');




            Route::get('/activities', 'Frontend\FrontendCityBookController@activities')->name('activities');
            Route::get('/rewards', 'Frontend\FrontendCityBookController@rewards')->name('rewards');
            Route::get('/pricing', 'Frontend\FrontendCityBookController@pricing')->name('pricing');

            Route::post("/business/adminBee", "Business\BusinessController@getAdminBee");
            Route::get('/businessDetails/{id?}/{type?}', 'Frontend\FrontendCityBookController@businessDetails')->name('businessDetails');
            Route::get('/authorSingle/{id?}', 'Frontend\FrontendCityBookController@authorSingle')->name('authorSingle');


            Route::get('/categoriesSearchBee', 'Frontend\FrontendCityBookController@categoriesSearchBee')->name('categoriesSearchBee');
            Route::post('/searchBusinessBee', 'Frontend\FrontendCityBookController@searchBusinessBee')->name('searchBusinessBee');
            Route::get('/howItWorks', 'Frontend\FrontendCityBookController@howItWorks')->name('howItWorks');
            Route::get('/prices', 'Frontend\FrontendCityBookController@prices')->name('prices');

            Route::get('/account/', 'Frontend\FrontendCityBookController@account')->name('profileAccount');
            Route::get('/orders/', 'Frontend\FrontendCityBookController@orders')->name('orders');

            Route::get('/myProfile', 'Frontend\FrontendCityBookController@myProfile')->name('myProfile');//CMS-TEMPLATE-MY-PROFILE-ROUTES
            Route::get('/suggestionsMailBox', 'Frontend\FrontendCityBookController@suggestionsMailBox')->name('suggestionsMailBox');
            Route::get('/password', 'Frontend\FrontendCityBookController@password')->name('password');
            Route::get('/business', 'Frontend\FrontendCityBookController@business')->name('business');
            Route::get('/businessEmployer', 'Frontend\FrontendCityBookController@businessEmployer')->name('businessEmployer');

            Route::get('/bee', 'Frontend\FrontendCityBookController@bee')->name('bee');
            Route::get('/reviewsTo', 'Frontend\FrontendCityBookController@reviewsTo')->name('reviewsTo');
            Route::get('/listingsQueen', 'Frontend\FrontendCityBookController@listingsQueen')->name('listingsQueen');

            Route::get('/pointsSales/', 'Frontend\FrontendCityBookController@pointsSales')->name('pointsSales');


            Route::get('/presentationCard/{id?}/{type?}', 'Frontend\FrontendCityBookController@presentationCard')->name('presentationCard');

            Route::get('/homeChaski', 'Frontend\ChaskishimiController@index')->name('homeChaski');
            Route::get('/yachaSun', 'Frontend\ChaskishimiController@yachaSun')->name('yachaSun');
            Route::get('/apuntes', 'Frontend\ChaskishimiController@apuntes')->name('apuntes');
            Route::get('/diccionario', 'Frontend\ChaskishimiController@diccionario')->name('diccionario');
            Route::get('/traductor', 'Frontend\ChaskishimiController@traductor')->name('traductor');


            Route::get('/homeBackLine', 'Frontend\BackLineController@index')->name('homeBackLine');



            Route::get('/homeEatPura', 'Frontend\EatPuraController@index')->name('homeEatPura');
            Route::get('/userAccount', 'Frontend\EatPuraController@userAccount')->name('userAccount');
            Route::get('/shopPage', 'Frontend\EatPuraController@shopPage')->name('shopPage');

            Route::get('/checkoutPage', 'Frontend\EatPuraController@checkoutPage')->name('checkoutPage');

            Route::post("/shopPage/product/productShopAdmin", "Frontend\EatPuraController@getProductShopAdmin")->name('getProductShopAdmin');

            Route::post("/shopPage/product/productShopAdmin", "Frontend\EatPuraController@getProductShopAdmin")->name('getProductShopAdmin');

            Route::post('/user/equals/emailUniqueCheckout', 'Frontend\EatPuraController@validateEmailCheckout')->name('validateEmailCheckout');//TODO VERIFY

            Route::post('customerUserShop/saveCustomerAddressInformationShop', 'Frontend\CustomerUserShopController@saveCustomerAddressInformationShop')->name('saveCustomerAddressInformationShop');; //




            Route::get('/generateElectronicReceiptsGenerateInformation', 'Frontend\ManagerDocumentController@generateElectronicReceiptsGenerateInformation')->name('generateElectronicReceiptsGenerateInformation');
            Route::get('/managementElectronicReceiptsGenerateInformation', 'Frontend\ManagerDocumentController@managementElectronicReceiptsGenerateInformation')->name('managementElectronicReceiptsGenerateInformation');
            Route::post('/generateInformationElectronic', 'Frontend\ManagerDocumentController@generateInformationElectronic')->name('generateInformationElectronic');


            Route::get('/getDataInteraction', 'Frontend\ManagerDocumentController@getDataInteraction')->name('getDataInteraction');

            Route::get('/kineticDisc', 'Frontend\ManagerDocumentController@kineticDisc')->name('kineticDisc');




        });
 }
}

