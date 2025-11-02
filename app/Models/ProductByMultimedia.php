<?php

namespace App\Models;

use App\Models\Multimedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class ProductByMultimedia extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'product_by_multimedia';
    const TYPE_IMAGE_LOCAL = 1;
    const TYPE_AUDIO_LOCAL = 2;
    const TYPE_DOCUMENT_LOCAL = 3;
    const VIEW_ON = 1;
    const VIEW_OFF = 0;


    protected $fillable = array(
        'title',//*
        'subtitle',
        'description',
        'type',//*
        'priority',//*
        'view',//*
        'product_id',//*
        'source'//*

    );
    protected $attributesData = [
        ['column' => 'title', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'subtitle', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'type', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'priority', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'view', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'product_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'source', 'type' => 'string', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'title';

    public static function getRulesModel()
    {
        $rules = ["title" => "required|max:45",
            "subtitle" => "max:45",
            "type" => "required|numeric",
            "priority" => "required|numeric",
            "view" => "required|numeric",
            "product_id" => "required|numeric",
            "source" => "required|max:250"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $product_id = $params['filters']['product_id'];
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.title,$this->table.subtitle,$this->table.description,$this->table.type,$this->table.priority,$this->table.view,product.code as product,
product.id as product_id,
$this->table.source";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product', 'product.id', '=', $this->table . '.product_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->orWhere($this->table . '.title', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.priority', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.view', 'like', '%' . $likeSet . '%');
            $query->orWhere("product.code", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.source', 'like', '%' . $likeSet . '%');;

        }
        $query->where($this->table . '.product_id', '=', $product_id);


        $recordsTotal = $query->get()->count();
        $pages = 1;
        $total = $recordsTotal; // total items in array
// sort
        $query->orderBy($field, $sort);
// Pagination: $perpage 0; get all data
        if ($perpage > 0) {
            $pages = ceil($total / $perpage); // calculate total pages
            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            $query->offset((int)$offset);
            $query->limit((int)$perpage);
        }
        $current_page = isset($params['current']) ? (int)$params['current'] : 0;
        $data = $query->get()->toArray();

        $result['total'] = $total;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $limit = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $result['rowCount'] = $limit;

        return $result;
    }


    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $modelName = 'ProductByMultimedia';
            $model = new ProductByMultimedia();
            $createUpdate = true;

            $modelMultimedia = new Multimedia;
            $auxResource = "";
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = ProductByMultimedia::find($attributesPost['id']);
                $createUpdate = false;

                $auxResource = $model->source;
            } else {
                $createUpdate = true;
            }


            $productByMultimediaData = $attributesPost;
            $source = $productByMultimediaData["source"];
            $pathSet = "/uploads/products/productByMultimedia";
            $change = $productByMultimediaData["change"];
            $successMultimediaModel = $modelMultimedia->managerUploadModel(
                array(
                    'createUpdate' => $createUpdate,
                    'source' => $source,
                    'pathSet' => $pathSet,
                    'change' => $change,
                    'auxResource' => $auxResource
                )
            );
            $successMultimedia = $successMultimediaModel['success'];

            if ($successMultimedia) {


                $currentResource = '';

                $source = $currentResource . $successMultimediaModel['source'];
                $productByMultimediaData['source'] = $source;

                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $productByMultimediaData, 'attributesData' => $this->attributesData));
                $paramsValidate = array(
                    'inputs' => $attributesSet,
                    'rules' => self::getRulesModel(),

                );
                $validateResult = $this->validateModel($paramsValidate);
                $success = $validateResult["success"];
                if ($success) {
                    $model->fill($attributesSet);
                    $success = $model->save();
                } else {
                    $success = false;
                    $msj = "Problemas al guardar  ProductByMultimedia.";
                    $errors = $validateResult["errors"];
                }
                if (!$success) {
                    DB::rollBack();

                } else {
                    DB::commit();
                }
                $result = [
                    "errors" => $errors,
                    "msj" => $msj,
                    "success" => $success
                ];


            } else {
                $msj = "Problemas al guardar la imagen.";
                DB::rollBack();
                throw new \Exception($msj);
            }


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );
            return ($result);
        }

    }

    public function getListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product', 'product.id', '=', $this->table . '.product_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.title', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.priority', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.view', 'like', '%' . $likeSet . '%');
            $query->orWhere("product.code", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.source', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getDataProduct($params)
    {
        $product_id = $params['filters']['product_id'];
        $textValue = $this->table . '.priority';
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->table.title,$this->table.subtitle,$this->table.description,$this->table.type,$this->table.priority,$this->table.view,
$this->table.source";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where($this->table . '.product_id', '=', $product_id);
        $query->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function addMultimedia($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params;
        $product_id = $params['idParent'];
        $errors = array();
        $data = [];
        DB::beginTransaction();
        try {
            $modelMultimedia = new Multimedia;

            $sourceManager = $params["attributesPost"]['file'];

            $pathSet = "/uploads/products/productChildren/" . $product_id;

            $createUpdate = true;
            $change = 'false';
            $auxResource = "";
            $result = [
                'data' => $attributesPost
            ];

            $resultMultimedoi = $modelMultimedia->getInformationByFile($sourceManager);

            $successMultimediaModel = $modelMultimedia->managerUploadModel(
                array(

                    'createUpdate' => $createUpdate,
                    'source' => $sourceManager,
                    'pathSet' => $pathSet,
                    'change' => $change,
                    'auxResource' => $auxResource
                )
            );
            $successMultimedia = $successMultimediaModel['success'];

            if ($successMultimedia) {
                $msj = "Guardado Correctamente.";
                $source = $successMultimediaModel['sourceServer'];

                $nameImage=$successMultimediaModel['data']['uploadedImageData']['fileName'];
                $model = new ProductByMultimedia();
                $dataCurrent = $model->getDataProduct(['filters' => ['product_id' => $product_id]]);
                $priority = 1;
                $countAll = count($dataCurrent);
                if ($countAll == 0) {
                    $priority = 1;
                } else {

                    $priority = $countAll + 1;
                }
                $attributesSet = [
                    'title' => $nameImage,
                    'subtitle' => $nameImage,
                    'description' => $nameImage,
                    'type' => self::TYPE_IMAGE_LOCAL,
                    'priority' => $priority,
                    'view' => self::VIEW_ON,
                    'product_id' => $product_id,
                    'source' => $source,
                ];

                $model->fill($attributesSet);
                $success = $model->save();
                $data['ProductByMultimedia'] = $model->attributes;
                $data['Multimedia'] = $successMultimediaModel;

            } else {
                $msj = "Problemas al guardar la imagen.";
                $success = false;

                throw new \Exception($msj);
            }

            if ($success) {
                DB::commit();

            } else {
                DB::rollBack();
            }
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                'data' => $data
            );
            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );

            DB::rollBack();

            return ($result);
        }

    }

    public function removeMultimedia($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params['attributesPost'];

        $product_by_multimedia_id = $attributesPost['product_by_multimedia_id'];
        $errors = array();
        $data = [];
        DB::beginTransaction();
        try {
            $modelMultimedia = new Multimedia;
            $model = ProductByMultimedia::find($product_by_multimedia_id);
            $source = $model->source;
            if ($model) {
                $model->delete();

                $model = ProductByMultimedia::find($product_by_multimedia_id);
                if (!$model) {

                    $successMultimediaModel = $modelMultimedia->deleteResource(
                        array(
                            'path' => $source,

                        )
                    );
                    $successMultimedia = $successMultimediaModel['success'];

                    if ($successMultimedia) {
                        $msj = "Eliminado Recurso.";
                        $success = true;
                    } else {
                        $msj = "Problemas al borrar el recurso.";
                        $success = false;

                        throw new \Exception($msj);
                    }
                } else {
                    $msj = "Problemas eliminar registro.!";
                    $success = false;

                    throw new \Exception($msj);
                }


            } else {
                $msj = "No existe datos de la imagen";
                $success = false;

                throw new \Exception($msj);
            }

            if ($success) {
                DB::commit();

            } else {
                DB::rollBack();
            }
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                'data' => $data
            );
            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );

            DB::rollBack();

            return ($result);
        }

    }
}
