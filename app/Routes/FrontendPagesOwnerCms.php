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

        });
    }
}

