<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\MyBaseController;
use App\Models\BusinessByGallery;
use App\Models\Multimedia;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BusinessByGalleryController extends MyBaseController
{


    public function getAdminBusiness()
    {
        $dataPost = Request::all();
        $model = new BusinessByGallery;
        $result = $model->getAdminBusinessData($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveBusiness()
    {
        $create_update = true;

        $success = false;
        $msj = "";
        $result = array();
        DB::beginTransaction();
        try {

            $model = new BusinessByGallery();
            $attributesPost = Request::all();
            $description = isset($attributesPost["description"]) ? $attributesPost["description"] : "";
            $business_id = $attributesPost["business_id"];
            $position = $attributesPost["position"];
            $config = json_decode($attributesPost["config"], true);
            $type = $attributesPost["type"];
            $title = $attributesPost["title"];
            $subtitle = $attributesPost["subtitle"];
            $status = $attributesPost["status"];
            /* IMAGE*/
            $file = $attributesPost["src"];
            $pathSet = "/uploads/business/gallery";
            $change = $attributesPost["change"];
            $createUpdate = true;
            $modelMultimedia = new Multimedia;
            $resultMultimedia = array();
            $auxResource = "";
            $source = "";

            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null") {
                $allowNextProcess = true;
                $model = BusinessByGallery::find($attributesPost['id']);
                $auxResource = $model->src;
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $successMultimedia = false;
            if ($createUpdate) {
                $resultMultimedia = $modelMultimedia->managerUpload(array("file" => $file, "pathSet" => $pathSet));
                $source = $resultMultimedia["uploadedImageData"]["destinationPublic"];
                $successMultimedia = $resultMultimedia["success"];

            } else {

                if ($change != "undefined" && $change == "true") {
                    $resultMultimedia = $modelMultimedia->managerUpload(array("file" => $file, "pathSet" => $pathSet));
                    $source = $resultMultimedia["uploadedImageData"]["destinationPublic"];
                    $successMultimedia = $resultMultimedia["success"];

                } else {
                    $source = $auxResource;
                    $successMultimedia = true;
                }

            }


            if ($successMultimedia) {
                if (!$createUpdate) {
                    if ($auxResource != "nothing" && $change == "true") {
                        $modelMultimedia->deleteResource(array("path" => $auxResource));
                    }
                }
                $attributesSet = array(
                    "description" => $description,
                    "subtitle"=>$subtitle,
                    "src" => $source,
                    "position" => $position,
                    "type" => $type,
                    "config" => $config,
                    "business_id"=>$business_id,
                    "status"=>$status,
                    "title"=>$title,

                );

                $model->fill($attributesSet);
                $success = $model->save();
                if ($success) {
                    $routes_map_id = $model->id;

                } else {
                    $msj = "Problemas al guardar Imagen a Galeria.";
                    throw new \Exception($msj);
                }

            } else {
                $success = false;
                $msj = "Problemas al guardar la imagen.";
                DB::rollBack();
                throw new \Exception($msj);
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
