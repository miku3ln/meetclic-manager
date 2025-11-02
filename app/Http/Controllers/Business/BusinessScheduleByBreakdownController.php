<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\MyBaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class BusinessScheduleByBreakdownController extends MyBaseController
{


    public function deleteSchedule()
    {
        $create_update = true;
        $dataSchedules = array();
        $success = false;
        $msj = "Horario eliminado.";
        $result = array();
        DB::beginTransaction();
        try {
            $model = new BusinessScheduleByBreakdown();
            $attributesPost = Request::all();
            $id = $attributesPost["id"];
            $business_id = $attributesPost["business_id"];

            $modelBSBB = BusinessScheduleByBreakdown::find($id);
            if ($modelBSBB) {
                $success=true;
            }else{
                $success=false;
                $msj = "No existe horario en los registros..";
                throw new \Exception($msj);
            }


            if (!$success) {
                $msj = "Problemas al eliminar horario.";
                DB::rollBack();
                throw new \Exception($msj);
            } else {
                // Else commit the queries
                $modelBSBB->delete();
                DB::commit();
                $success = true;
            }

            $modelData = $attributesPost;
            $modelData["id"] = $model->id;
            $modelBBS = new BusinessBySchedule();
            $dataSchedules = $modelBBS->getStructureSchedulesBusiness(array("business_id" => $business_id));
            $result = [
                "data" => $dataSchedules,
                "success" => $success
            ];
            return Response::json($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "message" => $msj
            );
            return Response::json($result);
        }
    }
}
