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

    function findItemByField(array $haystack, string $field, $value)
    {
        foreach ($haystack as $key => $item) {
            if (isset($item[$field]) && $item[$field] == $value) {
                return [
                    'key' => $key,
                    'item' => $item,
                ];
            }
        }

        return null;
    }

    public function saveBusiness()
    {
        $success = false;
        $msj = '';

        DB::beginTransaction();

        try {
            $attributesPost = Request::all();

            // ==========================
            // 1. Preparar datos base
            // ==========================
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
            $pathSet = "/uploads/business/information/chasquiñanes";
            $change = $attributesPost["change"];
            $type_shortcut = $attributesPost["type_shortcut"];

            // Asegurar que items sea array
            $items = isset($attributesPost["items"]) ? $attributesPost["items"] : array();
            if (is_string($items)) {
                $decoded = json_decode($items, true);
                $items = is_array($decoded) ? $decoded : array();
            }

            $modelMultimedia = new Multimedia;
            $currentResource = '';
            $auxResource = "";

            // ==========================
            // 2. Determinar create / update
            //    RoutesMap + BusinessByRoutesMap
            // ==========================
            list($modelRM, $modelBusinessByRoute, $createUpdate, $auxResource) =
                $this->resolveRouteMapModels($attributesPost);

            // ==========================
            // 3. Manejar imagen principal
            // ==========================
            $srcRouteMap = $this->handleMainImage(
                $modelMultimedia,
                $file,
                $pathSet,
                $createUpdate,
                $change,
                $auxResource,
                $currentResource
            );

            // Si estamos en update y cambió la imagen, eliminar la anterior
            if (!$createUpdate && $auxResource !== "nothing" && $change === "true" && $auxResource !== $srcRouteMap) {
                $modelMultimedia->deleteResource(array("path" => $auxResource));
            }

            // ==========================
            // 4. Guardar RoutesMap
            // ==========================
            $attributesSetRM = array(
                "type" => $type,
                "name" => $name,
                "description" => $description,
                "status" => $status,
                "options_map" => $options_map,
                "src" => $srcRouteMap,
            );

            $modelRM->fill($attributesSetRM);
            if (!$modelRM->save()) {
                throw new Exception("Problemas al guardar Route Map.");
            }

            $routes_map_id = $modelRM->id;

            // ==========================
            // 5. Guardar BusinessByRoutesMap
            // ==========================
            $attributesSetBusiness = array(
                "business_id" => $business_id,
                "routes_map_id" => $routes_map_id,
                "status" => $status,
                "type_shortcut" => $type_shortcut,
            );

            $modelBusinessByRoute->fill($attributesSetBusiness);
            if (!$modelBusinessByRoute->save()) {
                throw new Exception("Problemas al guardar Route Map con su negocio.");
            }

            $business_by_routes_map_id = $modelBusinessByRoute->id;

            // ==========================
            // 6. Adventure types
            // ==========================
            $adventureTypeDataAux = ($attributesPost["adventure_type"] == null)
                ? array()
                : explode(",", $attributesPost["adventure_type"]);

            $this->syncAdventureTypes(
                $business_by_routes_map_id,
                $adventureTypeDataAux,
                $createUpdate
            );

            // ==========================
            // 7. RoutesDrawing + MapByRoutesDrawing
            // ==========================
            $this->syncRoutesDrawing(
                $routes_map_id,
                $routes_drawing_data,
                $items,
                $modelMultimedia,
                $pathSet,
                $currentResource
            );

            // ==========================
            // 8. Eliminar RoutesDrawing marcados
            // ==========================
            foreach ($deleteData as $deleteItem) {
                if (!isset($deleteItem["id"]) || !isset($deleteItem["rd_id"])) {
                    continue;
                }

                $modelMBRD = RoutesMapByRoutesDrawing::find($deleteItem["id"]);
                if ($modelMBRD) {
                    $modelMBRD->delete();
                }

                $modelRD = RoutesDrawing::find($deleteItem["rd_id"]);
                if ($modelRD) {
                    $modelRD->delete();
                }
            }

            // Si todo llega hasta aquí, OK
            DB::commit();
            $success = true;
            $msj = "Datos guardados correctamente.";

            return Response::json(array(
                "success" => $success,
                "msj" => $msj,
            ));

        } catch (Exception $e) {
            DB::rollBack();
            $success = false;
            $msj = $e->getMessage();

            return Response::json(array(
                "success" => $success,
                "msj" => $msj,
            ));
        }
    }

    /**
     * Determina si es create o update de RoutesMap / BusinessByRoutesMap
     */
    private function resolveRouteMapModels($attributesPost)
    {
        $modelRM = new RoutesMap();
        $modelBusinessByRoute = new BusinessByRoutesMap();
        $createUpdate = true;
        $auxResource = "nothing";

        if (isset($attributesPost["id"]) && $attributesPost["id"] !== "null") {
            $createUpdate = false;

            $modelBusinessByRoute = BusinessByRoutesMap::find($attributesPost['id']);
            if (!$modelBusinessByRoute) {
                throw new Exception("No se encontró el registro BusinessByRoutesMap.");
            }

            $modelRM = RoutesMap::find($modelBusinessByRoute->routes_map_id);
            if (!$modelRM) {
                throw new Exception("No se encontró el RoutesMap relacionado.");
            }

            $auxResource = $modelRM->src;
        }

        return array($modelRM, $modelBusinessByRoute, $createUpdate, $auxResource);
    }

    /**
     * Maneja la imagen principal, subiendo o usando la existente.
     */
    private function handleMainImage(
        Multimedia $modelMultimedia,
                   $file,
                   $pathSet,
                   $createUpdate,
                   $change,
                   $auxResource,
                   $currentResource = ''
    )
    {
        // CREATE
        if ($createUpdate) {
            $resultMultimedia = $modelMultimedia->managerUpload(array(
                "file" => $file,
                "pathSet" => $pathSet
            ));

            if (empty($resultMultimedia["success"])) {
                throw new Exception("Problemas al guardar la imagen.");
            }

            return $currentResource . $resultMultimedia["uploadedImageData"]["destinationPublic"];
        }

        // UPDATE con cambio de imagen
        if ($change !== "undefined" && $change === "true") {
            $resultMultimedia = $modelMultimedia->managerUpload(array(
                "file" => $file,
                "pathSet" => $pathSet
            ));

            if (empty($resultMultimedia["success"])) {
                throw new Exception("Problemas al guardar la nueva imagen.");
            }

            return $currentResource . $resultMultimedia["uploadedImageData"]["destinationPublic"];
        }

        // UPDATE sin cambio: mantener la existente
        if ($auxResource === null || $auxResource === "") {
            throw new Exception("No existe recurso previo de imagen para mantener.");
        }

        return $auxResource;
    }

    /**
     * Sincroniza AdventureTypes (RouteMapByAdventureTypes)
     */
    private function syncAdventureTypes(
        $business_by_routes_map_id,
        array $adventureTypeDataAux,
        $createUpdate
    )
    {
        $modelRMBAT = new RouteMapByAdventureTypes();

        // CREATE: insertar todos
        if ($createUpdate) {
            foreach ($adventureTypeDataAux as $adventure_type_id) {
                if ($adventure_type_id === "" || $adventure_type_id === null) {
                    continue;
                }

                $model = new RouteMapByAdventureTypes();
                $model->fill(array(
                    "adventure_type" => $adventure_type_id,
                    "business_by_routes_map_id" => $business_by_routes_map_id,
                ));

                if (!$model->save()) {
                    throw new Exception("Problemas al guardar Adventure type.");
                }
            }
            return;
        }

        // UPDATE: calcular diferencias
        $dataRMBAT = $modelRMBAT->getAdventureTypes(array(
            "business_by_routes_map_id" => $business_by_routes_map_id
        ));

        $dataDelete = array();
        $adventureTypeDataNews = array();

        // Nuevos
        foreach ($adventureTypeDataAux as $value) {
            $searchNeedle = $modelRMBAT->searchNeedleAdventureType(array(
                "haystack" => $dataRMBAT,
                "needle" => $value,
                "keySearch" => "adventure_type"
            ));

            if (empty($searchNeedle)) {
                $adventureTypeDataNews[] = $value;
            }
        }

        // Para borrar
        foreach ($dataRMBAT as $value) {
            $adventure_type = $value->adventure_type;
            $searchNeedle = $modelRMBAT->searchNeedleAdventureType(array(
                "haystack" => $adventureTypeDataAux,
                "needle" => $adventure_type,
                "keySearch" => "adventure_type",
                "type" => "delete"
            ));

            if (empty($searchNeedle)) {
                $dataDelete[] = $value->id;
            }
        }

        if (!empty($dataDelete)) {
            RouteMapByAdventureTypes::destroy($dataDelete);
        }

        // Insertar nuevos
        foreach ($adventureTypeDataNews as $adventure_type_id) {
            if ($adventure_type_id === "" || $adventure_type_id === null) {
                continue;
            }

            $model = new RouteMapByAdventureTypes();
            $model->fill(array(
                "adventure_type" => $adventure_type_id,
                "business_by_routes_map_id" => $business_by_routes_map_id,
            ));

            if (!$model->save()) {
                throw new Exception("Problemas al guardar Adventure type.");
            }
        }
    }

    /**
     * Sincroniza RoutesDrawing y RoutesMapByRoutesDrawing
     */
    private function syncRoutesDrawing(
        $routes_map_id,
        array $routes_drawing_data,
        array $items,
        Multimedia $modelMultimedia,
        $pathSet,
        $currentResource = ''
    )
    {
        foreach ($routes_drawing_data as $key => $attributes) {
            $modelRD = new RoutesDrawing();
            $src = "";
            $src_glb = "";
            $typeCurrent = $attributes["type"];

            // ====== Obtener modelo existente (update) o nuevo (create) ======
            if (isset($attributes["rd_id"])) {
                $modelRD = RoutesDrawing::find($attributes["rd_id"]);
                if (!$modelRD) {
                    throw new Exception("RoutesDrawing no encontrado para actualización.");
                }

                if ($typeCurrent === "marker") {
                    $rdIdBuscado = $attributes["rd_id"];
                    $resultSearch = $this->findItemByField($items, "rd_id", $rdIdBuscado);
                    list($src, $src_glb) = $this->handleMarkerFiles(
                        $resultSearch,
                        $modelMultimedia,
                        $pathSet,
                        $currentResource
                    );
                }
            } else {
                // Nuevo drawing
                if ($typeCurrent === "marker") {
                    $rdIdBuscado = $key;
                    $resultSearch = $this->findItemByField($items, "rd_id", $rdIdBuscado);
                    list($src, $src_glb) = $this->handleMarkerFiles(
                        $resultSearch,
                        $modelMultimedia,
                        $pathSet,
                        $currentResource
                    );
                }
            }

            // ====== Construir options_type según tipo ======
            $type = null;
            $options_type = array();
            $name = isset($attributes["title"]) ? $attributes["title"] : $attributes["type"];
            $subtitle = isset($attributes["subtitle"]) ? $attributes["subtitle"] : $attributes["type"];
            $totem_subcategory_id = isset($attributes["totem_subcategory_id"]) ? $attributes["totem_subcategory_id"] : 1;


            if ($attributes["type"] === "marker") {
                $type = RoutesDrawing::typeMarker;
                $options_type = array(
                    "position" => $attributes["position"],
                );
            } elseif ($attributes["type"] === "polygon") {
                $type = RoutesDrawing::typePolygon;
                $options_type = array(
                    "fillColor" => $attributes["fillColor"],
                    "fillOpacity" => $attributes["fillOpacity"],
                    "paths" => $attributes["paths"],
                    "strokeColor" => $attributes["strokeColor"],
                    "strokeOpacity" => $attributes["strokeOpacity"],
                    "strokeWeight" => $attributes["strokeWeight"],
                );
            } elseif ($attributes["type"] === "rectangle") {
                $type = RoutesDrawing::typeRectangle;
                $options_type = array(
                    "fillColor" => $attributes["fillColor"],
                    "fillOpacity" => $attributes["fillOpacity"],
                    "strokeColor" => $attributes["strokeColor"],
                    "strokeOpacity" => $attributes["strokeOpacity"],
                    "strokeWeight" => $attributes["strokeWeight"],
                    "bounds" => $attributes["bounds"],
                );
            } elseif ($attributes["type"] === "circle") {
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
            } elseif ($attributes["type"] === "polyline") {
                $type = RoutesDrawing::typePolyline;
                $options_type = array(
                    "strokeColor" => $attributes["strokeColor"],
                    "strokeOpacity" => $attributes["strokeOpacity"],
                    "strokeWeight" => $attributes["strokeWeight"],
                    "path" => $attributes["path"],
                );
            }

            $description = "not-description";
            if (isset($attributes["content"])) {
                if (!is_array($attributes["content"])) {
                    $description = $attributes["content"];
                } else {
                    $description = "is-polyline";
                }
            }

            $attributesSetRD = array(
                "type" => $type,
                "name" => $name,
                "subtitle" => $subtitle,
                "description" => $description,
                "options_type" => json_encode($options_type),
                "src" => $src,
                "src_glb" => $src_glb,
                "totem_subcategory_id" => $totem_subcategory_id,

            );

            $modelRD->fill($attributesSetRD);

            if (!$modelRD->save()) {
                throw new Exception("Problemas al guardar RoutesDrawing.");
            }

            $routes_drawing_id = $modelRD->id;

            // ====== Relación RoutesMapByRoutesDrawing ======
            $modelRMBRD = new RoutesMapByRoutesDrawing();

            if (isset($attributes["id"])) {
                $dataCurrent = DB::table("routes_map_by_routes_drawing")
                    ->where("routes_map_id", "=", $routes_map_id)
                    ->where("routes_drawing_id", "=", $routes_drawing_id)
                    ->first();

                if ($dataCurrent) {
                    $modelRMBRD = RoutesMapByRoutesDrawing::find($dataCurrent->id);
                } else {
                    throw new Exception("Problemas get Values en routes_map_by_routes_drawing.");
                }
            }

            $attributesSetRMBRD = array(
                "routes_map_id" => $routes_map_id,
                "routes_drawing_id" => $routes_drawing_id
            );

            if ($modelRMBRD) {
                $modelRMBRD->fill($attributesSetRMBRD);
                if (!$modelRMBRD->save()) {
                    throw new Exception("Problemas al guardar RoutesDrawing By.");
                }
            } else {
                throw new Exception("Problemas no fill Values para RoutesMapByRoutesDrawing.");
            }
        }
    }

    /**
     * Manejo de archivos (imagen + glb) para markers
     */
    private function handleMarkerFiles(
        $resultSearch,
        Multimedia $modelMultimedia,
        $pathSet,
        $currentResource = ''
    )
    {
        $src = "";
        $src_glb = "";

        if ($resultSearch === null) {
            return array($src, $src_glb);
        }

        $itemSearch = $resultSearch["item"];

        // GLB
        if (isset($itemSearch["file_glb"])) {
            $file_glb = $itemSearch["file_glb"];

            if (is_string($file_glb)) {
                $src_glb = $file_glb;
            } else {
                $resultMultimedia = $modelMultimedia->managerUpload(array(
                    "file" => $file_glb,
                    "pathSet" => $pathSet
                ));

                if (empty($resultMultimedia["success"])) {
                    throw new Exception("Problemas al guardar modelo 3D (glb).");
                }

                $src_glb = $currentResource . $resultMultimedia["uploadedImageData"]["destinationPublic"];
            }
        }

        // IMG
        if (isset($itemSearch["file_src"])) {
            $file_src = $itemSearch["file_src"];

            if (is_string($file_src)) {
                $src = $file_src;
            } else {
                $resultMultimedia = $modelMultimedia->managerUpload(array(
                    "file" => $file_src,
                    "pathSet" => $pathSet
                ));

                if (empty($resultMultimedia["success"])) {
                    throw new Exception("Problemas al guardar imagen de marker.");
                }

                $src = $currentResource . $resultMultimedia["uploadedImageData"]["destinationPublic"];
            }
        }

        return array($src, $src_glb);
    }

    public function saveBusiness2()
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
                        foreach ($routes_drawing_data as $key => $attributes) {

                            $modelRD = new RoutesDrawing();
                            $src = "";
                            $src_glb = "";
                            $typeCurrent = $attributes["type"];
                            if (isset($attributes["rd_id"])) {
                                $modelRD = RoutesDrawing::find($attributes["rd_id"]);
                                if ($typeCurrent == "marker") {
                                    $rdIdBuscado = $attributes["rd_id"];
                                    $resultSearch = $this->findItemByField($items, "rd_id", $rdIdBuscado);
                                    if ($resultSearch !== null) {
                                        $itemSearch = $resultSearch["item"];
                                        $file_glb = $itemSearch["file_glb"];
                                        if (is_string($file_glb)) {
                                            $src_glb = $file_glb;
                                        } else {
                                            $resultMultimedia = $modelMultimedia->managerUpload(array("file" => $file_glb, "pathSet" => $pathSet));
                                            $src_glb = $currentResource . $resultMultimedia["uploadedImageData"]["destinationPublic"];
                                            $successMultimedia = $resultMultimedia["success"];
                                        }
                                        $file_src = $itemSearch["file_src"];
                                        if (is_string($file_src)) {
                                            $src = $file_src;
                                        } else {
                                            $resultMultimedia = $modelMultimedia->managerUpload(array("file" => $file_src, "pathSet" => $pathSet));
                                            $src = $currentResource . $resultMultimedia["uploadedImageData"]["destinationPublic"];
                                            $successMultimedia = $resultMultimedia["success"];
                                        }
                                    }
                                }

                            } else {
                                if ($typeCurrent == "marker") {
                                    $rdIdBuscado = $key;
                                    $resultSearch = $this->findItemByField($items, "rd_id", $rdIdBuscado);
                                    if ($resultSearch !== null) {
                                        $itemSearch = $resultSearch["item"];
                                        $file_glb = $itemSearch["file_glb"];
                                        if (is_string($file_glb)) {
                                            $src_glb = $file_glb;
                                        } else {
                                            $resultMultimedia = $modelMultimedia->managerUpload(array("file" => $file_glb, "pathSet" => $pathSet));
                                            $src_glb = $currentResource . $resultMultimedia["uploadedImageData"]["destinationPublic"];
                                            $successMultimedia = $resultMultimedia["success"];
                                        }
                                        $file_src = $itemSearch["file_src"];
                                        if (is_string($file_src)) {
                                            $src = $file_src;
                                        } else {
                                            $resultMultimedia = $modelMultimedia->managerUpload(array("file" => $file_src, "pathSet" => $pathSet));
                                            $src = $currentResource . $resultMultimedia["uploadedImageData"]["destinationPublic"];
                                            $successMultimedia = $resultMultimedia["success"];
                                        }
                                    }

                                }

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
                                "options_type" => json_encode($options_type),
                                "src" => $src,
                                "src_glb" => $src_glb,

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
