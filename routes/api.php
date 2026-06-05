<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {

    return $request->user();
});


Route::middleware(ApiAuthenticate::class)->get('/userData', function (Request $request) {
    $user = ['user' => $request->user()];
    return $user;
});
Route::post("/executePaymentPayPal", "Payment\PaymentController@executePaymentPayPal")->middleware('auth.body');
Route::post("/createPaymentPayPal", "Payment\PaymentController@createPaymentPayPal")->middleware('auth.body');
Route::get("/createPaymentPaymentez", "Payment\PaymentController@createPaymentPaymentez")->middleware('auth.body');
Route::get("/", "Payment\PaymentController@hi");


Route::post("/login", "Auth\ApiLoginController@loginRest");

Route::middleware('publicApi')->group(function () {
    Route::post('/auth/with/meetclic/login', 'Auth\MeetclicController@login')->name('loginMeetclic');
    Route::post('/auth/with/meetclic/register', 'Auth\MeetclicController@register')->name('registerMeetclic');
    Route::post('/business/searchNearbyBusinesses', 'Api\BusinessAppController@searchNearbyBusinesses')->name('searchNearbyBusinesses');
    Route::post('/auth/with/resendVerificationByEmail', 'Auth\MeetclicController@resendVerificationByEmail')->name('resendVerificationByEmail');
    Route::post('/business/businessDetails', 'Api\BusinessAppController@businessDetails')->name('searchNearbyBusinesses');
    Route::get('/api-information/consultar-cedula-legal', 'Api\CustomerAppController@consultarCedula')->name('consultarCedula');
    Route::post('/saveCustomer', 'Api\CustomerAppController@saveCustomerApi')->name('saveCustomerApi');
    Route::post('/saveMaritimeDepartureApi', 'Api\CustomerAppController@saveMaritimeDepartureApi')->name('saveMaritimeDepartureApi');
    Route::get('/getDeparturesWithCustomers', 'Api\BusinessAppController@getDeparturesWithCustomers')->name('getDeparturesWithCustomers');
    Route::get('/setKichwaText', 'MintonPages\MintonPagesController@setKichwaText')->name('setKichwaText');
    Route::get('/setTxtDataCastellano', 'MintonPages\MintonPagesController@setTxtDataCastellano')->name('setCastellanoText');
    Route::post('/traductor/getDictionaryByLanguage', 'Api\CustomerAppController@getDictionaryByLanguage')->name('getDictionaryByLanguage');
    Route::post("/gamification/GamificationByProcess/getAdminGamificationFrontend", "Gamification\GamificationByProcessController@getAdminGamificationFrontend")->name('getAdminGamificationFrontend');
    Route::post("/gamification/GamificationByProcess/getAdminGamificationFrontendHome", "Gamification\GamificationByProcessController@getAdminGamificationFrontendHome")->name('getAdminGamificationFrontendHome');

    Route::post("/frontend/shop-page/get-admin", "Gamification\GamificationByProcessController@getAdminShopPageByBusiness")->name('getAdminShopPageByBusiness');

    Route::get('/test/json', function (Request $request) {
        return response()->json([
            'success' => true,
            'method' => 'GET',
            'message' => 'API funcionando correctamente',
            'ip' => $request->ip(),
            'time' => now()->toDateTimeString(),
        ]);
    });
    Route::post('/test/json', function (Request $request) {
        return response()->json([
            'success' => true,
            'method' => 'POST',
            'message' => 'API funcionando correctamente',
            'data' => $request->all(), // lo que mandes en el body te lo devuelve
            'ip' => $request->ip(),
            'time' => now()->toDateTimeString(),
        ]);
    });


});

Route::get('/auth/loginWith/google/redirect', 'Auth\AuthGoogleController@redirectToGoogle')->name('redirectGoogle');
Route::get('/auth/loginWith/google/callback', 'Auth\AuthGoogleController@handleGoogleCallback')->name('callbackGoogle');


Route::post("/register", "Auth\ApiLoginController@registerRest");
Route::group(['middleware' => 'auth:api'], function () {
    Route::get("/viewDataAdmin", "Auth\ApiLoginController@viewDataRest");
    Route::get("/viewData", "Auth\ApiLoginController@viewDataRest");

    Route::get("/user", function (Request $request) {
        return $request->user();
    });

});

Route::post("/executePaymentPayPalEvents", "Payment\PaymentController@executePaymentPayPalEvents")->middleware('auth.body');
Route::post("/createPaymentPayPalEvents", "Payment\PaymentController@createPaymentPayPalEvents")->middleware('auth.body');


Route::prefix('api')->group(function () {
    // tus rutas...
});


Route::prefix('pointsales')->group(function () {

    // 🔓 LOGIN (sin token)
    Route::post('/login', 'Auth\MeetclicController@loginPointSales');

    // 🔒 TODO lo demás protegido
    Route::middleware(['pointsales.auth'])->group(function () {
        Route::get('/products-sales', 'PointSales\ProductController@getProductsSales');
        Route::post('/generate-ticket', 'PointSales\ProductController@generateTicket');
        Route::get('/tickets-sales', 'PointSales\TicketManagerController@getTicketsSales');

        Route::get('/catalog-measure', 'PointSales\ProductController@getCatalogMeasure');
        Route::get('/catalog-tax', 'PointSales\ProductController@getCatalogTax');



    });

});
