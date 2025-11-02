<?php

namespace App\Http\Controllers\Scheduling;

use App\Http\Controllers\MyBaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Services\FirebaseService;

use Auth;

class DiaryController extends MyBaseController
{


    public function getExampleDiaryData()
    {

        $result = array(

            [
                "title" => 'Business Lunch',
                "start" => '2019-08-03T13:00:00',
                "constraint" => 'businessHours'
            ],
            [
                "title" => 'Meeting',
                "start" => '2019-08-13T11:00:00',
                "constraint" => 'availableForMeeting', // defined below
                "color" => '#257e4a'
            ],
            [
                "title" => 'Conference',
                "start" => '2019-08-18',
                "end" => '2019-08-20'
            ],
            [
                "title" => 'Party',
                "start" => '2019-08-29T20:00:00'
            ],

            // areas where "Meeting" must be dropped
            [
                "groupId" => 'availableForMeeting',
                "start" => '2019-08-11T10:00:00',
                "end" => '2019-08-11T16:00:00',
                "rendering" => 'background'
            ],
            [
                "groupId" => 'availableForMeeting',
                "start" => '2019-08-13T10:00:00',
                "end" => '2019-08-13T16:00:00',
                "rendering" => 'background'
            ],

            // red areas where no events can be dropped
            [
                "start" => '2019-08-24',
                "end" => '2019-08-28',
                "overlap" => false,
                "rendering" => 'background',
                "color" => '#ff9f89'
            ],
            [
                "start" => '2019-08-06',
                "end" => '2019-08-08',
                "overlap" => false,
                "rendering" => 'background',
                "color" => '#ff9f89'
            ],

            [
                "start" => '2019-08-01',
                "title" => 'All Day Event',

            ],
            [
                "title" => 'Long Event',
                "start" => '2019-08-01',

            ],

            [
                "title" => 'Long Event',
                "start" => '2019-08-07',
                "end" => '2019-08-10'
            ],
            [
                "groupId" => 999,
                "title" => 'Repeating Event',
                "start" => '2019-08-09T16:00:00'
            ],
            [
                "groupId" => 999,
                "title" => 'Repeating Event',
                "start" => '2019-08-16T16:00:00'
            ],
            [
                "title" => 'Conference',
                "start" => '2019-08-11',
                "end" => '2019-08-13'
            ],
            [
                "title" => 'Meeting',
                "start" => '2019-08-12T10:30:00',
                "end" => '2019-08-12T12:30:00'
            ],
            [
                "title" => 'Lunch',
                "start" => '2019-08-12T12:00:00'
            ],
            [
                "title" => 'Meeting',
                "start" => '2019-08-12T14:30:00'
            ],
            [
                "title" => 'Happy Hour',
                "start" => '2019-08-12T17:30:00'
            ],
            [
                "title" => 'Dinner',
                "start" => '2019-08-12T20:00:00'
            ],
            [
                "title" => 'Birthday Party',
                "start" => '2019-08-13T07:00:00'
            ],
            [
                "title" => 'Click for Google',
                "url" => 'http://google.com/',
                "start" => '2019-08-28'
            ]

        );
        return Response::json(
            $result
        );
    }

}

