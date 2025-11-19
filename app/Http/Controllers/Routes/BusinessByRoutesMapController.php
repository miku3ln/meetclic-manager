<?php

namespace App\Http\Controllers\Routes;

use App\Http\Controllers\MyBaseController;
use App\Models\BusinessByRoutesMap;
use App\Models\RoutesMap;
use App\Models\RoutesMapByRoutesDrawing;
use App\Models\RoutesDrawing;
use App\Models\RouteMapByAdventureTypes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Models\Multimedia;

class BusinessByRoutesMapController extends MyBaseController
{


    public function getAdminBusiness()
    {
        $dataPost = Request::all();
        $model = new BusinessByRoutesMap;
        $result = $model->getAdminBusinessData($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveBusiness()
    {
        $create_update = true;
        $dataSchedules = array();
        $success = false;
        $msj = "";
        $result = array();
        DB::beginTransaction();
        try {

            $model = new BusinessByRoutesMap();
            $modelRM = new RoutesMap();


            $allowNextProcess = false;
            $attributesPost = Request::all();
            $business_id = $attributesPost["business_id"];
            $type = $attributesPost["type"];
            $description = isset($attributesPost["description"]) ? $attributesPost["description"] : "";
            $options_map = isset($attributesPost["options_map"]) ? $attributesPost["options_map"] : "";
            $deleteData = isset($attributesPost["deleteData"]) ? json_decode($attributesPost["deleteData"], true) : array();
            $name = $attributesPost["name"];
            $status = $attributesPost["status"];
            $kml_structure = $attributesPost["kml_structure"];
            $kml_structure_data = json_decode($kml_structure, true);
            $routes_drawing_data = $kml_structure_data["routes_drawing_data"];
            $file = $attributesPost["src"];
            $pathSet = "/uploads/business/information";
            $change = $attributesPost["change"];
            $createUpdate = true;
            $modelMultimedia = new Multimedia;
            $resultMultimedia = array();
            $auxResource = "";
            $source = "";

            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null") {
                $allowNextProcess = true;
                $model = BusinessByRoutesMap::find($attributesPost['id']);
                $modelRM = RoutesMap::find($model->routes_map_id);
                $auxResource = $modelRM->src;
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $successMultimedia = false;
            $currentResource = '';

            if ($createUpdate) {

                $resultMultimedia = $modelMultimedia->managerUpload(array("file" => $file, "pathSet" => $pathSet));
                $source = $currentResource . $resultMultimedia["uploadedImageData"]["destinationPublic"];
                $successMultimedia = $resultMultimedia["success"];

            } else {

                if ($change != "undefined" && $change == "true") {
                    $resultMultimedia = $modelMultimedia->managerUpload(array("file" => $file, "pathSet" => $pathSet));
                    $source = $currentResource . $resultMultimedia["uploadedImageData"]["destinationPublic"];
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
                    "type" => $type,
                    "name" => $name,
                    "description" => $description,
                    "status" => $status,
                    "options_map" => $options_map,
                    "src" => $source
                );

                $modelRM->fill($attributesSet);
                $success = $modelRM->save();
                if ($success) {
                    $routes_map_id = $modelRM->id;
                    $type_shortcut = $attributesPost["type_shortcut"];
                    $attributes = array(
                        "business_id" => $business_id,
                        "routes_map_id" => $routes_map_id,
                        "status" => $status,
                        "type_shortcut" => $type_shortcut
                    );

                    $model->fill($attributes);
                    $success = $model->save();
                    if ($success) {
                        $business_by_routes_map_id = $model->id;
                        $modelRMBAT = new RouteMapByAdventureTypes();
                        $dataRMBAT = array();
                        $adventureTypeDataAux = ($attributesPost["adventure_type"] == null) ? array() : explode(",", $attributesPost["adventure_type"]);

                        $adventureTypeData = $adventureTypeDataAux;
                        if (!$createUpdate) {
                            $dataRMBAT = $modelRMBAT->getAdventureTypes(array("business_by_routes_map_id" => $business_by_routes_map_id));
                            $dataDelete = array();
                            $adventureTypeDataNews = array();

                            foreach ($adventureTypeDataAux as $key => $value) {
                                $adventure_type = $value;
                                $searchNeedle = $modelRMBAT->searchNeedleAdventureType(array("haystack" => $dataRMBAT, "needle" => $value, "keySearch" => "adventure_type"));
                                if (empty($searchNeedle)) {//new
                                    array_push($adventureTypeDataNews, $adventure_type);
                                }
                            }

                            foreach ($dataRMBAT as $key => $value) {
                                $adventure_type = $value->adventure_type;
                                $searchNeedle = $modelRMBAT->searchNeedleAdventureType(array("haystack" => $adventureTypeDataAux, "needle" => $adventure_type, "keySearch" => "adventure_type", "type" => "delete"));
                                if (empty($searchNeedle)) {
                                    array_push($dataDelete, $value->id);
                                }
                            }
                            if (!empty($dataDelete)) {
                                $deleteSuccess = RouteMapByAdventureTypes::destroy($dataDelete);
                            }
                            $adventureTypeData = $adventureTypeDataNews;

                        }
                        foreach ($adventureTypeData as $key => $adventure_type_id) {
                            $modelRMBAT = new RouteMapByAdventureTypes();
                            $setAttributesCurrent = array("adventure_type" => $adventure_type_id, "business_by_routes_map_id" => $business_by_routes_map_id);
                            $modelRMBAT->fill($setAttributesCurrent);
                            $success = $modelRMBAT->save();
                            if (!$success) {
                                $msj = "Problemas al guardar Adventure type.";
                                throw new Exception($msj);
                            }
                        }
                        //drawing
                        $items = $attributesPost["items"];

                        foreach ($items as $index => $item) {
                          //  var_dump($item);
                        }

                        foreach ($routes_drawing_data as $key => $attributes) {
                            $modelRD = new RoutesDrawing();
                            if (isset($attributes["rd_id"])) {
                                $modelRD = RoutesDrawing::find($attributes["rd_id"]);

                            }else{

                            }
                            $type = null;
                            $options_type = "";


                            $name = isset($attributes["title"]) ? $attributes["title"] : $attributes["type"];
                            $subtitle = isset($attributes["subtitle"]) ? $attributes["subtitle"] : $attributes["type"];

                            if ($attributes["type"] == "marker") {
                                $type = RoutesDrawing::typeMarker;
                                $options_type = array(
                                    "position" => $attributes["position"],
                                );

                            } else if ($attributes["type"] == "polygon") {
                                $type = RoutesDrawing::typePolygon;
                                $options_type = array(
                                    "fillColor" => $attributes["fillColor"],
                                    "fillOpacity" => $attributes["fillOpacity"],
                                    "paths" => $attributes["paths"],
                                    "strokeColor" => $attributes["strokeColor"],
                                    "strokeOpacity" => $attributes["strokeOpacity"],
                                    "strokeWeight" => $attributes["strokeWeight"],
                                );

                            } else if ($attributes["type"] == "rectangle") {
                                $type = RoutesDrawing::typeRectangle;
                                $options_type = array(
                                    "fillColor" => $attributes["fillColor"],
                                    "fillOpacity" => $attributes["fillOpacity"],
                                    "strokeColor" => $attributes["strokeColor"],
                                    "strokeOpacity" => $attributes["strokeOpacity"],
                                    "strokeWeight" => $attributes["strokeWeight"],
                                    "bounds" => $attributes["bounds"],
                                );

                            } else if ($attributes["type"] == "circle") {
                                $type = RoutesDrawing::typeCircle;
                                $options_type = array(
                                    "fillColor" => $attributes["fillColor"],
                                    "fillOpacity" => $attributes["fillOpacity"],
                                    "radius" => $attributes["radius"],
                                    "strokeColor" => $attributes["strokeColor"],
                                    "strokeOpacity" => $attributes["strokeOpacity"],
                                    "strokeWeight" => $attributes["strokeWeight"],
                                    "center" => $attributes["center"],
                                );
                            } else if ($attributes["type"] == "polyline") {

                                $options_type = array(
                                    "strokeColor" => $attributes["strokeColor"],
                                    "strokeOpacity" => $attributes["strokeOpacity"],
                                    "strokeWeight" => $attributes["strokeWeight"],
                                    "path" => $attributes["path"],


                                );
                                $type = RoutesDrawing::typePolyline;

                            }
                            $description = isset($attributes["content"]) ? (!is_array($attributes["content"]) ? $attributes["content"] : "is-polyline") : "not-description";


                            $attributesSet = array(
                                "type" => $type,
                                "name" => $name,
                                "subtitle" => $subtitle,
                                "description" => ($description),
                                "options_type" => json_encode($options_type)
                            );

                            $modelRD->fill($attributesSet);
                            $success = $modelRD->save();
                            if ($success) {
                                $routes_drawing_id = $modelRD->id;
                                $modelRMBRD = new RoutesMapByRoutesDrawing();
                                if (isset($attributes["id"])) {
                                    $query = DB::table("routes_map_by_routes_drawing")
                                        ->select("*");
                                    $query->where("routes_map_id", "=", $routes_map_id);
                                    $query->where("routes_drawing_id", "=", $routes_drawing_id);
                                    $dataCurrent = $query->get()->first();
                                    $modelRMBRD = null;
                                    if ($dataCurrent) {

                                        $modelRMBRD = RoutesMapByRoutesDrawing::find($dataCurrent->id);
                                    } else {
                                        $msj = "Problemas get Values";
                                        throw new Exception($msj);
                                    }

                                }
                                $attributesSet = array(

                                    "routes_map_id" => $routes_map_id,
                                    "routes_drawing_id" => $routes_drawing_id
                                );
                                if ($modelRMBRD) {

                                    $modelRMBRD->fill($attributesSet);
                                    $modelRMBRD->save();
                                } else {
                                    $msj = "Problemas no fill Values";
                                    throw new \Exception($msj);
                                }
                                if (!$success) {
                                    $msj = "Problemas al guardar RoutesDrawing By.";
                                    throw new \Exception($msj);
                                }

                            } else {
                                $msj = "Problemas al guardar RoutesDrawing.";
                                throw new Exception($msj);
                            }
                        }
                        foreach ($deleteData as $key => $attributes) {

                            $modelMBRD = RoutesMapByRoutesDrawing::find($attributes["id"]);
                            $modelMBRD->delete();
                            $modelRD = RoutesDrawing::find($attributes["rd_id"]);
                            $modelRD->delete();
                        }
                    } else {
                        $msj = "Problemas al guardar Route Map con su negocio.";
                        throw new Exception($msj);
                    }


                } else {
                    $msj = "Problemas al guardar Route Map.";
                    throw new Exception($msj);
                }

            } else {
                $success = false;
                $msj = "Problemas al guardar la imagen.";
                DB::rollBack();
                throw new Exception($msj);
            }
            if (!$success) {
                $msj = "Problemas al guardar";
                DB::rollBack();
                throw new Exception($msj);
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

    public function getAdminRoutes()
    {
        $dataPost = Request::all();
        $model = new BusinessByRoutesMap;
        $result = $model->getAdminRoutesData($dataPost);

        return Response::json(
            $result
        );
    }

    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  BusinessByRoutesMap();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
