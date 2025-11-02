<?php

namespace App\Routes;
use Route;
class FrontendCms
{
    public function __construct(array $attributes = [])
    {

        $this->initRoutes([]);
    }

    public function initRoutes($params)
    {

        Route::group(['prefix' => '{language?}', 'middleware' => ['frontend']], function () {

            Route::get('/login/{error?}', 'Auth\LoginController@showLoginFormCustomer')->name('login');

            Route::post('/login/{error?}', 'Auth\LoginController@loginCustomer');



            Route::get('/register', 'Auth\RegisterController@showRegistrationFormCustomer')->name('register');
            Route::post('/register', 'Auth\RegisterController@registerCustomer');


            Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestCustomerForm')->name('password.request');
            Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
            Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
            Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


            Route::get('/loginBusiness', 'Auth\LoginController@showLoginFormBusiness')->name('loginBusiness');
            Route::post('/loginBusiness', 'Auth\LoginController@loginBusiness');
            Route::get('/registerBusiness', 'Auth\RegisterController@showRegistrationFormBusiness')->name('registerBusiness');
            Route::post('/registerBusiness', 'Auth\RegisterController@registerBusiness');
            Route::get('/logout', 'DashboardController@logout')->name('logout');


            Route::get('/', 'Frontend\FrontendController@index')->name('homeIndexFrontend');
            Route::get('/web', 'Frontend\FrontendController@index')->name('homeIndexFrontendWeb');//CMS-TEMPLATE-home
            Route::get('/aboutUs', 'Frontend\FrontendController@aboutUs')->name('aboutUs');
            Route::get('/contactUs', 'Frontend\FrontendController@contactUs')->name('contactUs');
            Route::get('/services', 'Frontend\FrontendController@services')->name('services');
            Route::get('/shop', 'Frontend\FrontendController@shop')->name('shop');
            Route::get('/shopOutlets', 'Frontend\FrontendController@shopOutlets')->name('shopOutlets');
            Route::get('/shopBalances', 'Frontend\FrontendController@shopBalances')->name('shopBalances');
            Route::get('/ourStores', 'Frontend\FrontendController@ourStores')->name('ourStores');
            Route::get('/orderService', 'Frontend\FrontendController@orderService')->name('orderService');

            if (env('allowAllInOne')) {

                Route::get('/productDetails/{id?}', 'Frontend\FrontendCityBookController@productDetails')->name('productDetails');
            } else {
                Route::get('/productDetails/{id?}', 'Frontend\FrontendController@productDetails')->name('productDetails');

            }


            Route::get('/wishList', 'Frontend\FrontendController@wishList')->name('wishList');
            Route::get('/cart', 'Frontend\FrontendController@cart')->name('cart');
            if (env('allowAllInOne')) {

                Route::get('/cart', 'Frontend\FrontendCityBookController@cart')->name('cart');

            } else {
                Route::get('/cart', 'Frontend\FrontendController@cart')->name('cart');


            }


            Route::get('/paymentSend', 'Payment\PaymentController@paymentSend')->name('paymentSend');
            Route::post("/product/adminFrontend", "Products\FrontendDataController@getAdminFrontend")->name('managerProductBusiness');
            Route::post("/product/adminOutletsFrontend", "Products\ProductController@getAdminOutletsFrontend")->name('managerProductOutletsBusiness');
            Route::post("/product/adminBalancesFrontend", "Products\ProductController@getAdminBalancesFrontend")->name('managerProductBalancesBusiness');



            if (env('allowAllInOne')) {
                Route::get('/checkout', 'Frontend\FrontendCityBookController@checkout')->name('checkout');
            } else {
                Route::get('/checkout', 'Frontend\FrontendController@checkout')->name('checkout');

            }


            Route::get('/payment', 'Frontend\FrontendController@checkout')->name('payment');

            Route::get('/policies', 'Frontend\FrontendController@policies')->name('policies');
            Route::get('/terms', 'Frontend\FrontendController@terms')->name('terms');



            if (env('allowAllInOne')) {

                Route::get('/checkoutDetails/{id?}/{checkout?}', 'Frontend\FrontendCityBookController@checkoutDetails')->name('checkoutDetails');

            } else {
                Route::get('/checkoutDetails/{id?}/{checkout?}', 'Frontend\FrontendController@checkoutDetails')->name('checkoutDetails');


            }


            Route::get('/activitiesGame', 'Frontend\FrontendController@activitiesGame')->name('activities');
            Route::get('/rewardsGame', 'Frontend\FrontendController@rewardsGame')->name('rewards');


            Route::get("/refundCreditCard", "Frontend\FrontendController@refundCreditCard");
            Route::post("/refundCreditCardSave", "Payment\PaymentController@refundPaymentCreditCards")->name('refundCreditCardSave');


            Route::get('/eventDetails/{id?}', 'Frontend\FrontendController@eventDetails')->name('eventDetails');

            Route::post("/eventsTrailsProject/adminFrontend", "EventsTrails\EventsTrailsProjectController@getAdminFrontend")->name('managerEventsTrailsProjectBusiness');

            Route::get('/users/listUsersRoutes', 'Users\UserController@getlistUsersRoutes')->name('listUsersRoutes'); //
            Route::post("eventsTrailsRegistrationPoints/adminBusiness", "EventsTrails\EventsTrailsRegistrationPointsController@adminBusiness")->name('adminPointsSales');


            Route::get('/indexOne', 'Frontend\FrontendController@indexOne')->name('indexOne');
            Route::get('/listingOne', 'Frontend\FrontendController@listingOne')->name('listingOne');


            Route::get('/signPdf', 'Frontend\ManagerDocumentController@signPdf')->name('signPdf');
            Route::get('/signPdfLocal', 'Frontend\ManagerDocumentController@signPdfLocal')->name('signPdfLocal');

            Route::get('/signPdfF', 'Frontend\FrontendController@signPdf')->name('signPdfF');
            Route::get('/signPdfLocalF', 'Frontend\FrontendController@signPdfLocal')->name('signPdfLocalF');


        });
    }
}

