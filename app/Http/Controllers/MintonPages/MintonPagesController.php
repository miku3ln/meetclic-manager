<?php

namespace App\Http\Controllers\MintonPages;

use App\Models\Dictionary\DictionaryByWords;
use App\Models\Dictionary\DictionaryLanguage;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\MyBaseController;
use App\Models\Allergies;
use App\Utils\Util;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class MintonPagesController extends MyBaseController
{


    public function getEccomerceProducts()
    {
        $paramsSend = [];
        $renderView = 'mintonPages.eccomerceProducts';
        $modelDictionary = new DictionaryByWords();
        $resultSet = $modelDictionary->setManagerScript([]);//LANGUAGE-WORDS-SET

        $resultSet = $modelDictionary->setManagerScriptCastellano([]);//LANGUAGE-WORDS-SET


        $this->layout->content = view($renderView)->with($paramsSend);;

    }


}
