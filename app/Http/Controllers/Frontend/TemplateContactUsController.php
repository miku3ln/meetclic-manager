<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\MyBaseController;
use App\Models\TemplateContactUs;
use App\Models\Multimedia;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class TemplateContactUsController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost =Request::all();
        $model = new TemplateContactUs();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new TemplateContactUs();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  TemplateContactUs();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }

    public function getContactUsData()
    {

        $attributesPost = Request::all();
        $model = new  TemplateContactUs();
        $result = $model->getContactUsData($attributesPost);
        return Response::json($result);
    }

    public function uploadImage()
    {
        $modelMultimedia = new Multimedia();
        $model = new TemplateContactUs();
        $inputData = Request::all();
        $data = [];
        $success = false;
        $errors = '';
        $msj = '';
        DB::beginTransaction();
        try {
            $file = $inputData["file"];
            $pathSet = $inputData["sourceSet"];
            $id = $inputData["id"];
            $business_id = $inputData["business_id"];

            $auxResource = '';
            if ($id && $id != "null" && $id != "-1") {
                $model = TemplateContactUs::find($id);
                $createUpdate = false;
                $auxResource = $model->source;

            } else {
                $createUpdate = true;

            }

            $template_information_id = $inputData["template_information_id"];

            $resultUpload = $modelMultimedia->managerUpload(array("file" => $file, "pathSet" => $pathSet));
            $result = [];
            $success = $resultUpload['success'];
            if ($success) {
                $currentResource = '';

                $source = $currentResource . $resultUpload['uploadedImageData']['destinationPublic'];
                $templateContactUsData = [
                    'source' => $source,
                    'template_information_id' => $template_information_id,
                    'allow_routes' => 0,

                ];
                $attributesSet = $templateContactUsData;
                $paramsValidate = array(
                    'inputs' => $attributesSet,
                    'rules' => $model->getRulesModel(),

                );

                $validateResult = $model->validateModel($paramsValidate);
                $success = $validateResult["success"];
                if ($success) {
                    if (!$createUpdate) {
                        $modelMultimedia->deleteResource(array("path" => $auxResource));
                    }
                    $model->fill($attributesSet);
                    $success = $model->save();

                    $data = $model->getContactUsData([
                        'filters' => [
                            'business_id' => $business_id,
                            'template_information_id' => $template_information_id,

                        ]

                    ]);
                    $data['business_id'] = $business_id;
                    $data['model_id'] = $template_information_id;
                } else {
                    $success = false;
                    $msj = "Problemas al guardar  Imagen.";
                    $errors = $validateResult["errors"];
                }
                if (!$success) {

                    DB::rollBack();

                } else {


                    DB::commit();
                }
            } else {
                $success = false;
                $errors = $resultUpload['errors'];
                $msj = $resultUpload['message'];

            }
        } catch (Exception $e) {
            $msj = $e->getMessage();

        }
        $result = array(
            "success" => $success,
            "msj" => $msj,
            'data' => $data,
            "errors" => $errors
        );
        return Response::json($result);
    }
}
