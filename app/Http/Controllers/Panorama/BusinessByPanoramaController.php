<?php

namespace App\Http\Controllers\Panorama;

use App\Http\Controllers\MyBaseController;
use App\Models\BusinessByPanorama;
use App\Models\Panorama;
use App\Models\BusinessPanoramaByPoints;
use App\Models\PanoramaPoints;
use App\Models\Multimedia;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BusinessByPanoramaController extends MyBaseController
{


    public function getAdminBusiness()
    {
        $dataPost = Request::all();
        $model = new BusinessByPanorama;
        $result = $model->getAdminPanoramaData($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveToBusiness()
    {

        $success = true;
        $msj = "";
        $result = array();
        DB::beginTransaction();
        try {

            $model = new BusinessByPanorama();
            $modelP = new Panorama();
            $modelBPBP = new BusinessPanoramaByPoints();
            $modelPP = new PanoramaPoints();

            $attributesPost = Request::all();

            $file = $attributesPost["src"];
            $pathSet = "/uploads/panorama/markers";
            $change = $attributesPost["change"];
            $createUpdate = true;
            $modelMultimedia = new Multimedia;
            $resultMultimedia = array();
            $auxResource = "";
            $source = "";
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null") {
                $model = BusinessByPanorama::find($attributesPost['id']);
                $modelP = Panorama::find($model->panorama_id);
                $auxResource = $modelP->src;
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $currentResource = '';

            if ($createUpdate) {//create
                $resultMultimedia = $modelMultimedia->managerUpload(array("file" => $file, "pathSet" => $pathSet));
                $source = $currentResource.$resultMultimedia["uploadedImageData"]["destinationPublic"];
                $successMultimedia = $resultMultimedia["success"];
            } else {//update
                if ($change != "undefined" && $change == "true") {//update change image
                    $resultMultimedia = $modelMultimedia->managerUpload(array("file" => $file, "pathSet" => $pathSet));
                    $source = $currentResource.$resultMultimedia["uploadedImageData"]["destinationPublic"];
                    $successMultimedia = $resultMultimedia["success"];

                } else {
                    $source = $auxResource;
                    $successMultimedia = true;
                }

            }

            //panorama
            $title = $attributesPost["title"];
            $subtitle = isset($attributesPost["subtitle"]) ? ($attributesPost["subtitle"]=="null"?"":$attributesPost["subtitle"]) : "";
            $description = isset($attributesPost["description"]) ? ($attributesPost["description"]=="null"?"":$attributesPost["description"] ): "";
            $type_panorama = isset($attributesPost["type_panorama"]) ? $attributesPost["type_panorama"] : ($modelP::typePanoramaNormal);
            $points_allow = isset($attributesPost["points_allow"]) ? $attributesPost["points_allow"] : ($modelP::pointsAllowNotBreakDown);
            $type_breakdown = isset($attributesPost["type_breakdown"]) ? $attributesPost["type_breakdown"] : ($modelP::typeBreakdownParent);
            $business_id = $attributesPost["business_id"];

            if ($successMultimedia) {
                if (!$createUpdate) {
                    if ($auxResource != "nothing" && $change == "true") {
                        $modelMultimedia->deleteResource(array("path" => $auxResource));
                    }
                }


                $attributesSet = array(
                    "title" => $title,
                    "subtitle" => $subtitle,
                    "description" => $description,
                    "type_panorama" => $type_panorama,
                    "points_allow" => $points_allow,
                    "src" => $source,
                    "type_breakdown" => $type_breakdown,

                );

                $modelP->fill($attributesSet);

                $success = $modelP->save();
                if ($success) {
                    $panorama_id = $modelP->id;
                    //business by panorama
                    $status = $attributesPost["status"];
                    $routes_map_by_routes_drawing_id = $attributesPost["routes_map_by_routes_drawing_id"];
                    $setAttributes = array(
                        "business_id" => $business_id,
                        "status" => $status,
                        "panorama_id" => $panorama_id,
                        "routes_map_by_routes_drawing_id" => $routes_map_by_routes_drawing_id
                    );

                    $model->fill($setAttributes);
                    $success = $model->save();
                    if ($success) {


                    } else {
                        $msj = "Problemas al guardar Panorama to business.";
                        throw new \Exception($msj);
                    }


                } else {
                    $msj = "Problemas al guardar Panorama.";
                    throw new \Exception($msj);
                }

            } else {
                $success = false;
                $msj = "Problemas al guardar la imagen.";
                DB::rollBack();
                throw new \Exception($msj);
            }
            if (!$success) {
                $msj = "Problemas al guardar all.";
                DB::rollBack();
                throw new \Exception($msj);
            } else {
                // Else commit the queries
                DB::commit();
                $success = true;
            }

            $result = [
                "msj" => $msj,
                "success" => $success,
            ];

            return Response::json($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj
            );
            return Response::json($result);
        }
    }


}
