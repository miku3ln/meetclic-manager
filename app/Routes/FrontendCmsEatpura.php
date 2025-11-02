<?php
//FRONTEND-ROUTES
namespace App\Routes;

use Route;

class FrontendCmsEatpura
{
    public function __construct(array $attributes = [])
    {

        $this->initRoutes([]);
    }

    public function initRoutes($params)
    {
        Route::group(['prefix' => '{language}', 'middleware' => ['frontendCityBook']], function () {
            Route::get('/homeEatPura', 'Frontend\EatPuraController@index')->name('homeEatPura');
            Route::get('/userAccount', 'Frontend\EatPuraController@userAccount')->name('userAccount');
            Route::get('/shopPage', 'Frontend\EatPuraController@shopPage')->name('shopPage');
            Route::get('/checkoutPage', 'Frontend\EatPuraController@checkoutPage')->name('checkoutPage');
            Route::post("/shopPage/product/productShopAdmin", "Frontend\EatPuraController@getProductShopAdmin")->name('getProductShopAdmin');
            Route::post('/user/equals/emailUniqueCheckout', 'Frontend\EatPuraController@validateEmailCheckout')->name('validateEmailCheckout');//TODO VERIFY


        });
        Route::group(['prefix' => '{language}', 'middleware' => ['auth.business']], function () {
            Route::get('/managerProductsBusiness',
                'Frontend\EatPuraController@managerProductsBusiness'
            )->name('managerProductsBusiness');
        });

        Route::post('/data/sendDataViewFrontendWeb', 'ServerBusiness\ConsolidadoDataController@sendDataViewFrontendWeb')->name('sendDataViewFrontendWeb');
        Route::get('/data/viewCodeBarProducts', 'ServerBusiness\ConsolidadoDataController@viewCodeBarProducts')->name('viewCodeBarProducts');
        Route::post('/businessSystemOwner/productsManager', 'ServerBusiness\ConsolidadoDataController@getProductsManager')->name('productsManager');
        Route::post('/data/getDataViewAdminRegisters', 'ServerBusiness\ConsolidadoDataController@getDataViewAdminRegisters')->name('getDataViewAdminRegisters');
        Route::post('/data/updateComentarioProducto', 'ServerBusiness\ConsolidadoDataController@updateComentarioProducto')->name('updateComentarioProducto');
        Route::get('/template/Bootstrap5/index', 'TestDataController@index')->name('testIndex');

        Route::get('/data/managementProductsBusiness', 'Frontend\EatPuraController@managerProductsBusiness')->name('managementProductsBusiness');
        Route::get('/data/searchProductBusiness',
            'Frontend\EatPuraController@searchProductBusiness'
        )->name('searchProductBusiness');

        Route::post('/data/businessSystemOwner/productManager', 'ServerBusiness\ConsolidadoDataController@getProductManager')->name('productManager');

    }
}

