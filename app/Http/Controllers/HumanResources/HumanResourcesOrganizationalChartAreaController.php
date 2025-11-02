<?php
//CPP-011
namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\BusinessBaseController;

use App\Models\HumanResources\HumanResourcesOrganizationalChartArea;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class HumanResourcesOrganizationalChartAreaController extends BusinessBaseController
{


    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new HumanResourcesOrganizationalChartArea();
        $resultData = $model->getAdmin($dataPost);
        $result = [
            'total' => 0,
            'rows' => [],
            'current' => 0,
            'rowCount' => 0,

        ];
        if ($resultData['total'] > 0) {
            $result['total'] = $resultData['total'];

            $result['current'] = $resultData['current'];
            $result['rowCount'] = $resultData['rowCount'];
            $rows = [];
            foreach ($resultData['rows'] as $key => $value) {
                $parent_id = $value->parent_id;
                $allowDataParent = false;
                if ($parent_id == null) {

                } else {
                    $modelParent = $model->findByAttribute("id", $parent_id);
                    $allowDataParent = true;
                }
                $arrayData = (array)($value);
                if ($allowDataParent) {
                    $arrayData ['parentData'] = (array)($modelParent);
                }

                array_push($rows, $arrayData);
            }
            $result['rows'] = $rows;
        } else {

        }

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new HumanResourcesOrganizationalChartArea();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getListActionsParent()
    {

        $attributesPost = Request::all();
        $model = new HumanResourcesOrganizationalChartArea();
        $result = $model->getListActionsParent($attributesPost);
        return Response::json($result);
    }

    public function getListData()
    {

        $attributesPost = Request::all();
        $model = new HumanResourcesOrganizationalChartArea();
        $result = $model->getListData($attributesPost);
        return Response::json($result);
    }
}
