<?php

namespace App\Routes;

use Route;
class EducationCms
{
    public function __construct(array $attributes = [])
    {

        $this->initRoutes([]);
    }

    public function initRoutes($params)
    {
        Route::group(['prefix' => '{language}', 'middleware' => ['educationMiddleware']], function () {
            Route::get('/arrayanes', 'Frontend\EducationMainController@arrayanes')->name('arrayanes');
            Route::get('/aboutUsArrayanes', 'Frontend\EducationMainController@aboutUsArrayanes')->name('aboutUsArrayanes');
            Route::get('/academicOfferingArrayanes', 'Frontend\EducationMainController@academicOfferingArrayanes')->name('academicOfferingArrayanes');
            Route::get('/contactUsArrayanes', 'Frontend\EducationMainController@contactUsArrayanes')->name('contactUsArrayanes');
            Route::get('/newArrayanes/{id?}', 'Frontend\EducationMainController@newArrayanes')->name('newArrayanes');
            Route::get('/profileArrayanes/{id?}', 'Frontend\EducationMainController@profileArrayanes')->name('profileArrayanes');
            Route::get('/historyArrayanes/{id?}', 'Frontend\EducationMainController@historyArrayanes')->name('historyArrayanes');
            Route::get('/frequentQuestionArrayanes', 'Frontend\EducationMainController@frequentQuestionArrayanes')->name('frequentQuestionArrayanes');
            Route::get('/requirementsArrayanes', 'Frontend\EducationMainController@requirementsArrayanes')->name('requirementsArrayanes');

            Route::get('/alamos', 'Frontend\EducationMainController@alamos')->name('alamos');
            Route::get('/academicOfferingAlamos', 'Frontend\EducationMainController@academicOfferingAlamos')->name('academicOfferingAlamos');

            Route::get('/aboutUsAlamos', 'Frontend\EducationMainController@aboutUsAlamos')->name('aboutUsAlamos');
            Route::get('/contactUsAlamos', 'Frontend\EducationMainController@contactUsAlamos')->name('contactUsAlamos');
            Route::get('/newAlamos/{id?}', 'Frontend\EducationMainController@newAlamos')->name('newAlamos');
            Route::get('/profileAlamos/{id?}', 'Frontend\EducationMainController@profileAlamos')->name('profileAlamos');
            Route::get('/historyAlamos/{id?}', 'Frontend\EducationMainController@historyAlamos')->name('historyAlamos');
            Route::get('/frequentQuestionAlamos', 'Frontend\EducationMainController@frequentQuestionAlamos')->name('frequentQuestionAlamos');
            Route::get('/requirementsAlamos', 'Frontend\EducationMainController@requirementsAlamos')->name('requirementsAlamos');

            Route::get('/preescolar', 'Frontend\EducationMainController@preescolar')->name('preescolar');
            Route::get('/academicOfferingPreescolar', 'Frontend\EducationMainController@academicOfferingPreescolar')->name('academicOfferingPreescolar');

            Route::get('/aboutUsPreescolar', 'Frontend\EducationMainController@aboutUsPreescolar')->name('aboutUsPreescolar');
            Route::get('/contactUsPreescolar', 'Frontend\EducationMainController@contactUsPreescolar')->name('contactUsPreescolar');
            Route::get('/newPreescolar/{id?}', 'Frontend\EducationMainController@newPreescolar')->name('newPreescolar');
            Route::get('/profilePreescolar/{id?}', 'Frontend\EducationMainController@profilePreescolar')->name('profilePreescolar');
            Route::get('/historyPreescolar/{id?}', 'Frontend\EducationMainController@historyPreescolar')->name('historyPreescolar');
            Route::get('/frequentQuestionPreescolar', 'Frontend\EducationMainController@frequentQuestionPreescolar')->name('frequentQuestionPreescolar');
            Route::get('/requirementsPreescolar', 'Frontend\EducationMainController@requirementsPreescolar')->name('requirementsPreescolar');

        });

    }
}

