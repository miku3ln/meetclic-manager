<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\ChasquiBaseController;
use App\Models\ChasquiManager;
use App;
use Auth;

class ChasquiController extends ChasquiBaseController
{
    const LAYOUT_MAIN = 'chasqui';
    public $modelInit = null;

    public function __construct()
    {
        $this->modelInit = new ChasquiManager();
    }

    public function routeView($language = 'es', $id = null)
    {

        $language = $this->modelInit->getLanguageValid($language);

        if ($id == null) {

            $renderView = "errors.modelsView.404";
            return view($renderView, ['error' => 'Parametros mal enviados.!']);

        } else {

            $renderView = self::LAYOUT_MAIN . '.routeView.manager';
            $modelPage =  $this->modelInit;
            $paramsRequest = [];
            $paramsRequest['language'] = $language;
            $paramsRequest['id'] = $id;

            $paramsSend = $modelPage->getParamsPage([
                'page' => 'routeView',
                'id' => $id,
                'paramsRequest' => $paramsRequest

            ]);
            return view($renderView, $paramsSend);
        }

    }

    public function chasqui($language = 'es')
    {

        $language = $this->modelInit->getLanguageValid($language);
        $renderView = self::LAYOUT_MAIN . '.nianes.manager';
        $modelPage =  $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'chasqui',
            'paramsRequest' => $paramsRequest

        ]);
        return view($renderView, $paramsSend);


    }
}
