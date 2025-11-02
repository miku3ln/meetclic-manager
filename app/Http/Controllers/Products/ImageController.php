<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\MyBaseController;
use App\Models\Image as ImageModel;
use Auth;
use DB;
use Form;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Input;
use Intervention\Image\Facades\Image;
use Lang;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;
use Redirect;
use Request;
use Response;
use Validator;
use View;

class ImageController extends MyBaseController
{

    public function postSaveImage($data)
    {
        $file = $data['image'];
        $image = new ImageModel();
        $image->position = isset($data['position']) ? $data['position'] : 0;
        $image->product_id = isset($data['product_id']) && $data['product_id'] ? $data['product_id'] : null;
        $img = Image::make($file->getRealPath());
        $height = round($img->height() * 0.1);
        $width = round($img->width() * 0.1);
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        });

        $image->base64 = $img->encode('data-url');;
        $folder = "/uploads/";
        switch (true) {
            case isset($data['product_id']) && $data['product_id']:
                $folder = $folder . 'products';
                break;
        }
        $image->filename = $this->saveImage($file, $folder);
        $image->save();
        return $image;
    }


    public function saveImage($file, $directory)
    {
        $unix_timestamp = time();
        $destinationPath = public_path() . $directory;
        $fileOriginalName = $file->getClientOriginalName();
        $fileName = $unix_timestamp . '_' . $fileOriginalName;
        if ($file->move($destinationPath, $fileName)) {
            return $fileName;
        }
        return '';
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
}