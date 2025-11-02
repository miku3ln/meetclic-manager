<?php

use App\Routes\BusinessManager;
use App\Routes\FrontendCms;
use App\Routes\FrontendCmsCityBook;
use App\Routes\EducationCms;
use App\Models\UsersHasRoles;
use App\Routes\FrontendCmsEatpura;
use App\Routes\FrontendPagesOwnerCms;

Route::get('/api/img/{path}', 'Products\ImageController@show')->where('path', '.*');
$routeBusiness = new BusinessManager();//BUSINESS-MANAGER-TEMPLATE-ROUTES
Route::post('web/sendMail', 'Frontend\FrontendController@sendMail')->name('sendMail'); //
Route::post('web/sendMailEducation', 'Frontend\EducationMainController@sendMailEducation')->name('sendMailEducation'); //
Route::get('chaski', 'Wulpy\WulpyController@index');
Route::get('chaskiView/{id?}', 'WulpyView\WulpyViewController@index');
Route::get('routeView/{id?}', 'WulpyView\WulpyViewController@routeView');//CMS-TEMPLATE-ROUTES-VIEW
Route::get('tary', 'Wulpy\WulpyController@tary');
Auth::routes(['verify' => true]);
Route::get('login/facebook', 'Auth\FacebookController@redirectToFacebook')->name('fblogin');
Route::get('login/facebook/callback', 'Auth\FacebookController@handleFacebookCallback')->name('fblogincallback');
Route::get('login/google', 'Auth\FacebookController@redirectToGoogle')->name('googleLogin');
Route::get('login/google/callback', 'Auth\FacebookController@handleGoogleCallback')->name('googleCallback');
Route::get('auth/callback/{provider}', 'Auth\SocialAuthController@callback');
Route::get('auth/redirect/{provider}', 'Auth\SocialAuthController@redirect');
Route::post('wulpy/wulpymesAdmin', 'Business\BusinessController@getBusinessAdmin');
Route::post('wulpy/adminRoutes', 'Routes\BusinessByRoutesMapController@getAdminRoutes');


$routeFCMS = new FrontendCms();
$routeFCMSEatPura = new FrontendCmsEatpura();
$routeFPOC = new FrontendPagesOwnerCms();
Route::post("executePaymentBank", "Payment\PaymentController@executePaymentBank");
Route::post("executePaymentCreditCards", "Payment\PaymentController@executePaymentCreditCards");
Route::post("executePaymentBankEvents", "Payment\PaymentController@executePaymentBankEvents");
Route::post("executePaymentCreditCardsEvents", "Payment\PaymentController@executePaymentCreditCardsEvents");
Route::get("login/redirect", "Auth\FacebookController@redirectTest");
Route::group(['prefix' => 'chasqui', 'as' => 'chasqui.', 'middleware' => ['chasqui']], function () {
    Route::get('{language?}/nianes', 'Frontend\ChasquiController@chasqui')->name('nianesChasqui');
    Route::get('{language?}/routeView/{id?}', 'Frontend\ChasquiController@routeView', ['as' => 'routeView'])->name('routeViewChasqui');
    Route::get('{language?}/', 'Frontend\ChasquiController@chasqui')->where('language', '.*');
});
$middlewareConfig = 'frontendCityBook';
$controllerConfigHomeOne = 'Frontend\FrontendController';
$controllerConfigHomeTwo = 'Frontend\FrontendCityBookController';
if (env('templateConfig') == 1) {
    $middlewareConfig = 'educationMiddleware';
    $controllerConfigHomeOne = 'Frontend\EducationMainController';
    $controllerConfigHomeTwo = 'Frontend\EducationMainController';
}



//HOME INIT MANAGER
if (env('managerBusinessFrontendType') == 2) {

    Route::get('/', function () {

        $lang = App::getLocale();
        return redirect()->route('homeEatPura', ['language' => $lang]);
    })->name('urlBase');
    Route::get('/', function () {

        $lang = App::getLocale();
        return redirect()->route('homeEatPura', ['language' => $lang]);
    })->name('urlBase');


} else {

    Route::post('/', 'HomeController@index')->name('urlBase');
    Route::get('/', 'Frontend\FrontendController@index')->name('homeIndexFrontend');
    Route::get('/web', 'Frontend\FrontendController@index')->name('homeIndexFrontendWeb');//CMS-TEMPLATE-home
    Route::get('/', $controllerConfigHomeOne . '@index')->name('urlBase')->middleware($middlewareConfig);
}

$routeFECMS = new EducationCms();
$routeFCMSCBook = new FrontendCmsCityBook();

use App\Models\PeopleGender;

Route::group(['prefix' => '{language}', 'middleware' => ['course']], function () {

    Route::get('homeDatas', function () {
        $attributesPost = Inputs::all();
        $user = Auth::user();
        $roles = [];
        if ($user) {
            $userId = $user->id;
            $hasRolesUser = new UsersHasRoles();

            $roles = $hasRolesUser->getRolesUser($user->id);

        }
        $userManager = [
            "user" => $user,
            "roles" => $roles
        ];

        $attributesPost = $attributesPost;
        $modelSavePeople = new PeopleGender();
        $resultSaveModel = $modelSavePeople->saveDataWeb($attributesPost);
        $dataSend = [
            "userManager" => $userManager,
            "resultSaveModel" => $resultSaveModel

        ];

        return view('homeDatas', $dataSend);

    })->name("homeData");
});




