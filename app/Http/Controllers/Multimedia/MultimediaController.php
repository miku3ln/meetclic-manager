<?php

namespace App\Http\Controllers\Multimedia;

use App\Http\Controllers\MyBaseController;
use App\Models\Image as ImageModel;
use Auth;
use DB;
use Form;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\Facades\Image;
use Lang;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;
use Redirect;
use Request;
use Response;
use Validator;
use View;


/*https://laravel.com/api/5.6/Illuminate/Http/UploadedFile.html*/

class MultimediaController extends MyBaseController
{

    public function postSaveImage($data)
    {
        $file = $data['image'];
        if ($file) {

        }

        $imgResource = Image::make($file->getRealPath());
        $folder = "/uploads/img";
        $resultUploadImage = $this->getUploadImageManager($file, $folder);

        return $resultUploadImage;
    }

    public function uploadMultimedia()
    {

        $inputData = Request::all();
        $file = $inputData["file"];

        $result = array();
        $fileNameWithExt = "";
        $fileNameToStore = "";
        $fileName = "";
        $extension = "";
        $pathUpload = "";
        $structure = array();
        $size = 0;
        try {


            $fileNameWithExt = $file->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $fileName . "_" . time() . "." . $extension;
            $destinationPath = "public/tmp";
            $pathUpload = $file->storeAs($destinationPath, $fileNameToStore);


            $typesAllowImage = ($extension == "jpg") ? true : false;
            $size = $file->getSize();
            if ($typesAllowImage) {
                $structureOptions = Image::make($file->getRealPath());
                $height = $structureOptions->height();
                $width = $structureOptions->width();
                $structure["width"] = $width;
                $structure["height"] = $height;

            } else {

            }
            $result = array(
                "file" => array(
                    "nameClientExt" => $fileNameWithExt,
                    "nameExt" => $fileNameToStore,
                    "nameClient" => $fileName,
                    "extension" => $extension,
                    "path" => $pathUpload,
                    "structure" => $structure,
                    "size" => $size

                ),
                "success" => true,
            );

            return Response::json($result);

        } catch (Exception $e) {
            $result = array(
                "file" => array(
                    "nameClientExt" => $fileNameWithExt,
                    "nameExt" => $fileNameToStore,
                    "nameClient" => $fileName,
                    "extension" => $extension,
                    "path" => $pathUpload,
                    "structure" => $structure,
                    "size" => $size
                ),
                "success" => false,
                "error" => $e->getMessage()
            );

            return Response::json($result);
        }

    }

    public function getUploadImageManager($file, $directory)
    {
        $unix_timestamp = time();
        $destinationPath = public_path($directory) ;
        $fileOriginalName = $file->getClientOriginalName();
        $fileName = $unix_timestamp . '_' . $fileOriginalName;
        $success = false;
        if ($file->move($destinationPath, $fileName)) {
            $success = true;
        }
        $destinationPublic = $directory . "/" . $fileName;
        $result = array(
            "success" => $success,
            "fileName" => $fileName,
            "fileOriginalName" => $fileOriginalName,
            "destinationPath" => $destinationPath,
            "destinationPublic" => $destinationPublic
        );
        return $result;
    }

    public function deleteImage($id)
    {
        if (Request::ajax()) {
            try {
                DB::beginTransaction();
                $image = ImageModel::find($id);
                $folder = "/uploads/";
                switch (true) {
                    case ($image->product_id != null):
                        $folder = $folder . 'products/';
                        break;
                }
                $path = $folder . $image->filename;
                if (Storage::exists($path)) {
                    Storage::delete($path);
                }
                if ($image->delete()) {
                    DB::commit();
                    return Response::json(true);
                }
            } catch (Exception $e) {
                DB::rollback();

                return Response::json(false);
            }
        }
    }

    public function show(Filesystem $filesystem, $path)
    {
        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            'source' => $filesystem->getDriver(),
            'cache' => $filesystem->getDriver(),
            'cache_path_prefix' => '.cache',
            'base_url' => 'img',
        ]);
        return $server->getImageResponse($path, request()->all());
    }

    public function uploadResourceBusiness()
    {
        $inputData = Request::all();
        $file = $inputData["file"];
        $pathSet = "/uploads/business/information";
        $result = $this->managerUpload(array("file" => $file, "pathSet" => $pathSet));
        return Response::json($result);
    }

    public function managerUpload($params)
    {
        $file = $params["file"];
        $type = isset($params["type"]) ? $params["type"] : "image";
        $mines = isset($params["mines"]) ? ($params["mines"]) : $type == "image" ? "jpeg,jpg,png,gif" : "";
        $folder = isset($params["pathSet"]) ? $params["pathSet"] : "/uploads/img";
        $fileArray = array('file' => $file);
        $max = isset($params["max"]) ? $params["max"] : '10000';
        $result = array();
        $message = "";
        $uploadedImageData = array();
        $className = "";
        $errors = array();
        $rules = [
            'file' => 'mimes:' . $mines . '|required|max:' . $max
        ];
        $validation = Validator::make($fileArray, $rules);

        if ($validation->passes()) {
            $message = "Resource Upload";

            $uploadedImageData = $this->getUploadImageManager($file, $folder);
            $className = "alert-success";
            $success = $uploadedImageData["success"];
        } else {
            $message = "Resource Not Upload";
            $errors = $validation->errors()->all();
            $className = "alert-danger";
            $success = false;

        }
        $result = array(
            "message" => $message,
            "uploadedImageData" => $uploadedImageData,
            "className" => $className,
            "errors" => $errors,
            "success" => $success
        );
        return $result;
    }
    public function uploadImage()
    {
        $inputData = Request::all();
        $file = $inputData["file"];
        $pathSet = $inputData["sourceSet"];
        $result = $this->managerUpload(array("file" => $file, "pathSet" => $pathSet));
        return Response::json($result);
    }
}
