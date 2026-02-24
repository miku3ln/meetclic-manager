<?php

namespace App\Http\Controllers\Dictionary;

use App\Http\Controllers\MyBaseController;
use App\Models\Dictionary\DictionaryGrammaticalClass;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class DictionaryGrammaticalClassController extends MyBaseController
{



    public function grammaticalClassList()
    {
        $dataPost =Request::all();
        $model = new DictionaryGrammaticalClass();
        $result = $model->grammaticalClassList($dataPost);
        return Response::json(
            $result
        );
    }

}
