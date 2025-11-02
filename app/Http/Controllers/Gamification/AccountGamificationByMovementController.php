<?php

namespace App\Http\Controllers\Gamification;

use App\Http\Controllers\MyBaseController;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

use App\Models\AccountGamificationByMovement;

class AccountGamificationByMovementController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new AccountGamificationByMovement();
        $result = $model->getAdminData($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {
        $attributesPost = Request::all();
        $model = new AccountGamificationByMovement();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


}
