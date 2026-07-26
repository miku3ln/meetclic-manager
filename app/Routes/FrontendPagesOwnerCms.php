<?php
//FRONTEND-ROUTES
namespace App\Routes;

use Route;

class FrontendPagesOwnerCms
{
    public function __construct(array $attributes = [])
    {

        $this->initRoutes([]);
    }

    public function initRoutes($params)
    {
        Route::group(['middleware' => ['frontend']], function () {
            Route::get('/business/{slug}/{section}', 'Frontend\FrontendPagesOwnerCmsController@businessOwner')->name('pages-owner');
            Route::get('/simi-rura/chasqui/mundo-virtual/{id?}', 'Frontend\FrontendPagesOwnerCmsController@chasqui')->name('chasqui-routes');
            Route::get('/rimay/business/{id?}', 'Frontend\FrontendPagesOwnerCmsController@rimayByBusiness')->name('rimay-business');
            Route::get('/rimay/registers/business/{id?}', 'Frontend\FrontendPagesOwnerCmsController@rimayRegistersByBusiness')->name('rimay-registers-business');

            Route::get('/suggestions-mail/business/{id?}', 'Frontend\FrontendPagesOwnerCmsController@suggestionsMailBoxByBusiness')->name('suggestion-mail-business');
           // Route::get('/shop/business/{id?}', 'Frontend\FrontendPagesOwnerCmsController@shopByBusiness')->name('shop-business');
            Route::get('/rewards/business/{id?}', 'Frontend\FrontendPagesOwnerCmsController@rewardsRegistersByBusiness')->name('rewards-business');
            Route::get('/rates/registers/business/{id?}', 'Frontend\FrontendPagesOwnerCmsController@ratesRegistersByBusiness')->name('rates-registers-business');
            Route::get('/rate/register/business/{id?}', 'Frontend\FrontendPagesOwnerCmsController@rateRegisterByBusiness')->name('rate-register-business');


            Route::get('/business-process/business-by-appointment-list/{id}', 'Frontend\FrontendPagesOwnerCmsController@businessByAppointmentList')->name('business-by-appointment-list');
            Route::get('/business-process/business-by-appointment-list-data', 'Frontend\FrontendPagesOwnerCmsController@businessByAppointmentListData')->name('business-by-appointment-list-data');
            Route::post('/business-process/business-by-appointment-save', 'Frontend\FrontendPagesOwnerCmsController@businessByAppointmentSave')->name('business-by-appointment-save');
            Route::post('/business-process/check-availability-by-business', 'Frontend\FrontendPagesOwnerCmsController@checkAvailabilityByBusiness')->name('check-availability-by-business');
            Route::get('/business-process/customer/list', 'Frontend\FrontendPagesOwnerCmsController@getListCustomer')->name('getListCustomer');


            Route::post('/business-process/business-by-appointment-information', 'Frontend\FrontendPagesOwnerCmsController@getAvailabilityByDate')->name('business-by-appointment-information');

        });
    }
}

