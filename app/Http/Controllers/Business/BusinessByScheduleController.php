<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\MyBaseController;
use App\Models\BusinessBySchedule;
use App\Models\BusinessScheduleByBreakdown;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class BusinessByScheduleController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public $table = "business_by_schedule";

    public function saveSchedules()
    {
        $create_update = true;
        $dataSchedules = array();
        $success = false;
        $msj = "Horarios Guardados.";
        $result = array();
        DB::beginTransaction();
        try {

            $model = new BusinessBySchedule;
            $attributesPost =Request::all();
            $dataSchedules = $attributesPost["dataSchedules"];
            $business_id = $attributesPost["business_id"];
            $user = Auth::user();

            foreach ($dataSchedules as $key => $attributes) {

                $id = $attributes["id"];
                $type = 0;//0=24,1=schedules breakdown
                $open = 0;
                $valueOpen = $attributes["modelDay"];
                $configTypeSchedule = $attributes["configTypeSchedule"];
                $valueType = $configTypeSchedule["type"];

                $open = $valueOpen == "true" ? 1 : 0;
                $type = $valueType == "true" ? 1 : 0;
                $modelSave = new BusinessBySchedule();
                $modelCurrent = $model->getModelScheduleById(array("id" => $id));

                if (count($modelCurrent) > 0) {//update
                    $modelSave = BusinessBySchedule::find($id);
                }

                $modelSave->type = $type;
                $modelSave->open = $open;
                $modelSave->business_id = $business_id;

                $success = $modelSave->save();
                if ($success) {
                    $business_by_schedule_id = $modelSave->id;
                    if ($type == 1 && $open == 1) {

                        $dataBreakdown = $configTypeSchedule["data"];
                        foreach ($dataBreakdown as $keyBD => $attributesbsbb) {
                            $attributesCurrent = array();
                            $modelBSBB = new BusinessScheduleByBreakdown();

                            if (isset($attributesbsbb["end_time"]["id"])) {
                                $modelBSBB = BusinessScheduleByBreakdown::find($attributesbsbb["end_time"]["id"]);
                            }
                            $attributesCurrent["end_time"] = $attributesbsbb["end_time"]["modelBreakdown"];
                            $attributesCurrent["start_time"] = $attributesbsbb["end_time"]["modelBreakdown"];
                            $attributesCurrent["business_by_schedule_id"] = $business_by_schedule_id;

                            $modelBSBB->end_time = $attributesbsbb["end_time"]["modelBreakdown"];
                            $modelBSBB->start_time = $attributesbsbb["start_time"]["modelBreakdown"];
                            $modelBSBB->business_by_schedule_id = $business_by_schedule_id;
                            $success = $modelBSBB->save();
                            if ($success) {
                                $dataSchedules[$key]["configTypeSchedule"]["data"][$keyBD]["id"] = $modelBSBB->id;
                                $dataSchedules[$key]["configTypeSchedule"]["data"][$keyBD]["business_by_schedule_id"] = $business_by_schedule_id;

                            } else {
                                $msj = "Problemas al guardar breakdown";
                                throw new \Exception($msj);
                            }
                        }
                    } else if ($type == 0 && $open == 0) {

                        if (isset($configTypeSchedule["data"])) {
                            $dataBreakdown = $configTypeSchedule["data"];

                            foreach ($dataBreakdown as $keyBD => $attributesbsbb) {
                                $modelBSBB = null;
                                if (isset($attributesbsbb["end_time"]["id"])) {
                                    $modelBSBB = BusinessScheduleByBreakdown::find($attributesbsbb["end_time"]["id"]);
                                }
                                if ($modelBSBB) {

                                    $success = $modelBSBB->delete();
                                    if ($success) {

                                    } else {
                                        $msj = "Problemas al eliminar breakdown";
                                        throw new \Exception($msj);
                                    }
                                }
                            }
                        } else {

                        }

                    }
                    $dataSchedules[$key]["id"] = $business_by_schedule_id;


                } else {
                    $msj = "Problemas al guardar Negocio Horario";
                    throw new \Exception($msj);
                }
            }
            if (!$success) {

                $msj = "Problemas al guardar  schedule";

                throw new \Exception($msj);
            } else {

            }


            if (!$success) {
                $msj = "Problemas al guardar";
                DB::rollBack();
                throw new \Exception($msj);
            } else {
                // Else commit the queries
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
                $success = true;
            } else {
                $success = false;
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
