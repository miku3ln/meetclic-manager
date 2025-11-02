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
