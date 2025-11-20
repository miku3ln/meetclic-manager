<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Response;
use Validator;
use Illuminate\Support\Facades\Storage;

class Multimedia extends Model
{
    public function getUploadImageManager($file, $directory, $nameImage = null)
    {
        $result = [];
        try {
            $successMultimedia = false;

            $unix_timestamp = time();
            $destinationPath = public_path($directory);
            $fileOriginalName = $file->getClientOriginalName();
            $fileName = $unix_timestamp . '_' . $fileOriginalName;
            if ($nameImage) {
                $extension = pathinfo($fileOriginalName, PATHINFO_EXTENSION);

                $fileName = $nameImage . '.' . $extension;
            }
            $typeMine = $file->getClientMimeType();
            $success = false;
            if ($file->move($destinationPath, $fileName)) {
                $success = true;
            }
            $destinationPublic = $directory . "/" . $fileName;
            $getInformationByFile = $this->getInformationByFile($file);
            $result = array(
                "success" => $success,
                "getInformationByFile" => $getInformationByFile,
                "fileName" => $fileName,
                "fileOriginalName" => $fileOriginalName,
                "destinationPath" => $destinationPath,
                "destinationPublic" => $destinationPublic,
                'typeMine' => $typeMine
            );
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $result = array(
                "success" => false,
                "message" => $message,

            );
        }

        return $result;
    }

    public function getValuesSizes($paramsBytes)
    {
        return [
            'bytes' => $paramsBytes,
            'Kilobyte' => $paramsBytes / 1024,
            'Megabyte ' => $paramsBytes / (1024 * 2),
            'Gigabyte' => $paramsBytes / (1024 * 3),

        ];
    }

    public function getInformationByFile($file)
    {

        $size = 0;
        $getValuesSizes = [];
        $typeMine = $file->getClientMimeType();
        $name = $file->getClientOriginalName();

        try {
            $size = $file->getSize();
            $getValuesSizes = $this->getValuesSizes($size);
        } catch (\Exception $e) {
        }
        $result = array(
            "name" => $name,
            "size" => $size,
            "getValuesSizes" => $getValuesSizes,
            "typeMine" => $typeMine,
        );
        return $result;
    }

    public function getUploadDataManager($file, $directory, $nameImage = null)
    {

        $unix_timestamp = time();
        $destinationPath = public_path($directory);
        /*        $extention=pathinfo();*/
        $fileOriginalName = $file->getClientOriginalName();

        $fileName = $unix_timestamp . '_' . $fileOriginalName;
        $typeMine = $file->getClientMimeType();
        $success = true;
        $destinationPublic = $directory . "/" . $fileName;
        $file->storeAs($directory, $fileName);

        $result = array(
            "success" => $success,
            "information" => self::getInformationByFile($file),
            "fileName" => $fileName,
            "fileOriginalName" => $fileOriginalName,
            "destinationPath" => $destinationPath,
            "destinationPublic" => $destinationPublic,
            'typeMine' => $typeMine
        );

        return $result;
    }

    public function deleteResource($params)
    {
        $path = $params["path"];
        $deleteAllow = false;
        $msj = '';
        $public = public_path();
        $publicAll = public_path($path);
        $existResource = file_exists(public_path($path));

        if ($existResource) {
            $deleteAllow = unlink(public_path($path));

            $existResource = true;
        } else {
            $msj = 'No existe el recurso a eliminar.';

        }

        return array(
            "success" => $deleteAllow,
            "deleteAllow" => $deleteAllow,
            "existResource" => $existResource,
            'msj' => $msj
        );

    }

    public function managerUpload($params)
    {
        $file = $params["file"];
        $success = false;
        $type = isset($params["type"]) ? $params["type"] : "image";
        $mines = "";
        if (isset($params["mines"])) {

            $mines = $params["mines"];
        } else {
            if ($type == "image") {
                $mines = "jpeg,jpg,png,gif,ico,svg";
            } else if ($type == "docs") {
                $mines = "pdf,doc,docx,xls,xlsx";

            }
        }

        $folder = isset($params["pathSet"]) ? $params["pathSet"] : "/uploads/img";
        $fileArray = array('file' => $file);
        $max = isset($params["max"]) ? $params["max"] : '100000';
        $result = array();
        $message = "";
        $uploadedImageData = array();
        $className = "";
        $errors = array();

        $rules = [
            'file' => 'mimes:' . $mines . '|required|max:' . $max
        ];
        if ($file->getMimeType() == 'image/x-icon') {
            $rules = [
                'file' => 'required|max:' . $max
            ];
        }
        if ($file->getMimeType() == 'image/jpeg') {

        }
        if ($file->getMimeType() == 'application/x-empty' || $file->getMimeType() == 'application/octet-stream') {
            $rules = [

            ];
        }
        if ($file->getMimeType() == 'model/gltf-binary') {
            $rules = [
                'file' => 'required|max:' . $max
            ];
        }

        $validation = Validator::make($fileArray, $rules);
        $nameImage = null;
        if (isset($params['nameImage'])) {
            $nameImage = $params['nameImage'];
        }
        if ($validation->passes()) {
            $message = "Resource Upload";

            if ($file->getMimeType() == 'application/x-empty') {

                $uploadedImageData = $this->getUploadDataManager($file, $folder, $nameImage);

            } else {

                $uploadedImageData = $this->getUploadImageManager($file, $folder, $nameImage);
            }

            $className = "alert-success";
            $success = $uploadedImageData["success"];
        } else {
            $message = "Resource Not Upload ";
            $errors = $validation->errors()->all();

            foreach ($errors as $key => $value) {
                $message .= "" . $value;
            }

            $className = "alert-danger";
            $success = false;

        }
        return array(
            "message" => $message,
            "uploadedImageData" => $uploadedImageData,
            "className" => $className,
            "errors" => $errors,
            "success" => $success
        );
    }

    public function managerUploadModel($params)
    {

        $createUpdate = $params['createUpdate'];
        $source = $params["source"];
        $file = $params["source"];
        $pathSet = $params['pathSet'];
        $change = $params["change"];
        $auxResource = $params["auxResource"];
        $message = "";
        $resultMultimedia = array();
        $changeImage = false;
        $currentRootResource = '';
        $data = [];
        $sourceServer = '';

        $configUpload = array("file" => $file, "pathSet" => $pathSet);
        if (isset($params['nameImage'])) {
            $configUpload['nameImage'] = $params['nameImage'];
        }
        try {
            if (isset($params['type'])) {
                $type = $params['type'];
                $configUpload = array("file" => $file, "pathSet" => $pathSet, 'type' => $type);
                if (isset($params['nameImage'])) {
                    $configUpload['nameImage'] = $params['nameImage'];
                }
            }

            if ($change != "undefined") {//update or create

                if ($createUpdate) {//CREATE

                    $resultMultimedia = self::managerUpload($configUpload);
                    $data['uploadedImageData'] = $resultMultimedia['uploadedImageData'];
                    if ($resultMultimedia["success"]) {

                        $source = $resultMultimedia["uploadedImageData"]["destinationPublic"];
                        $sourceServer = $currentRootResource . $source;
                    } else {
                        $message = $resultMultimedia["message"];
                    }

                } else {//UPDATE


                    if ($change == "true") {

                        $resultMultimedia = self::managerUpload($configUpload);
                        $data['uploadedImageData'] = $resultMultimedia['uploadedImageData'];

                        $source = $resultMultimedia["uploadedImageData"]["destinationPublic"];
                        $sourceServer = $currentRootResource . $source;

                    } else {

                        $changeImage = true;
                        $sourceServer = $currentRootResource . $source;
                        $source = $sourceServer;

                    }


                }


            } else {
                $changeImage = true;
            }

            $successMultimedia = isset($resultMultimedia["success"]) ? $resultMultimedia["success"] : $changeImage;
            if ($successMultimedia) {
                if (!$createUpdate) {

                    if ($auxResource != "nothing" && $change == "true") {
                        $data['delete'] = self::deleteResource(array("path" => $auxResource));
                    }

                }
            }
        } catch (\Exception $e) {
            $successMultimedia = false;
            $message = $e->getMessage();
        }

        $result = array(
            'success' => $successMultimedia,
            'source' => $source,
            'sourceServer' => $sourceServer,
            'data' => $data,
            "message" => $message
        );

        return $result;
    }

    public function deleteUploadModel($params)
    {

        $createUpdate = $params['createUpdate'];
        $source = $params["source"];
        $file = $params["source"];
        $pathSet = $params['pathSet'];
        $change = $params["change"];
        $auxResource = $params["auxResource"];
        $message = "";
        $resultMultimedia = array();
        $changeImage = false;

        /*  $currentRootResource = $createUpdate ? (env('APP_IS_SERVER') ? "/public" : '') : $change == 'true' ? (env('APP_IS_SERVER') ? "/public" : '') : '';*/
        $currentRootResource = '';
        $data = [];
        $sourceServer = '';
        $configUpload = array("file" => $file, "pathSet" => $pathSet);
        try {
            if (isset($params['type'])) {
                $type = $params['type'];
                $configUpload = array("file" => $file, "pathSet" => $pathSet, 'type' => $type);
            }
            if ($change != "undefined") {//update or create

                if ($createUpdate) {//CREATE

                    $resultMultimedia = self::managerUpload($configUpload);
                    if ($resultMultimedia["success"]) {

                        $source = $resultMultimedia["uploadedImageData"]["destinationPublic"];
                        $sourceServer = $currentRootResource . $source;
                    } else {
                        $message = $resultMultimedia["message"];
                    }

                } else {//UPDATE


                    if ($change == "true") {

                        $resultMultimedia = self::managerUpload($configUpload);
                        $source = $resultMultimedia["uploadedImageData"]["destinationPublic"];
                        $sourceServer = $currentRootResource . $source;

                    } else {

                        $changeImage = true;
                        $sourceServer = $currentRootResource . $source;
                        $source = $sourceServer;

                    }


                }


            } else {
                $changeImage = true;
            }

            $successMultimedia = isset($resultMultimedia["success"]) ? $resultMultimedia["success"] : $changeImage;
            if ($successMultimedia) {
                if (!$createUpdate) {

                    if ($auxResource != "nothing" && $change == "true") {
                        $data['delete'] = self::deleteResource(array("path" => $auxResource));
                    }

                }
            }
        } catch (\Exception $e) {
            $successMultimedia = false;
            $message = $e->getMessage();
        }

        $result = array(
            'success' => $successMultimedia,
            'source' => $source,
            'sourceServer' => $sourceServer,
            'data' => $data,
            "message" => $message
        );

        return $result;
    }
}
