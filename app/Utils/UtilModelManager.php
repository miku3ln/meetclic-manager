<?php

namespace App\Utils;


use App\Models\ModelManager;

trait UtilModelManager
{
    public function validateModel($params)
    {
        return ModelManager::validateModel($params);

    }



}
