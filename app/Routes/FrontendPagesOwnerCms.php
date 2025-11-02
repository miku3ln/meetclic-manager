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

      Route::get('/business/{slug}/{section}', 'Frontend\FrontendPagesOwnerCmsController@businessOwner')->name('pages-owner');
        Route::get('/simi-rura/muelle-catalina/mundo-virtual', 'Frontend\FrontendPagesOwnerCmsController@muelleCatalina')->name('muelle-catalina');


    }
}

