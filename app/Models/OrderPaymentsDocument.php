<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Multimedia;

class OrderPaymentsDocument extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'order_payments_document';

    protected $fillable = array(
        'order_payments_manager_id',//*
        'source',//*
        'account_bank',//*
        'number_bank'//*

    );
    protected $attributesData = [
        ['column' => 'order_payments_manager_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'source', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'account_bank', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'number_bank', 'type' => 'string', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'source';

    public static function getRulesModel()
    {
        $rules = ["order_payments_manager_id" => "required|numeric",
            "source" => "required|max:250",
            "account_bank" => "required|max:150",
            "number_bank" => "required|max:150"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,order_payments_manager.start as order_payments_manager,
order_payments_manager.id as order_payments_manager_id,
$this->table.source,$this->table.account_bank,$this->table.number_bank";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('order_payments_manager', 'order_payments_manager.id', '=', $this->table . '.order_payments_manager_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere("order_payments_manager.start", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.source', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.account_bank', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.number_bank', 'like', '%' . $likeSet . '%');;

        }

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


    public function saveDataShipping($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params;
        $errors = array();
        $modelName = 'OrderPaymentsDocument';
        $model = new OrderPaymentsDocument();
        $createUpdate = true;
        $modelMultimedia = new Multimedia;
        $auxResource = "";
        $orderPaymentsDocumentData = $attributesPost;

        $source = $orderPaymentsDocumentData["source"];
        $pathSet = "/uploads/frontend/orderPaymentsDocument";
        $change = false;
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

            $source =$currentResource. $successMultimediaModel['source'];
            $orderPaymentsDocumentData['source'] = $source;

            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $orderPaymentsDocumentData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  OrderPaymentsDocument.";
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


    }
    public function saveDataShippingEvents($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params;
        $errors = array();
        $modelName = 'OrderPaymentsDocument';
        $model = new OrderPaymentsDocument();
        $createUpdate = true;
        $modelMultimedia = new Multimedia;
        $auxResource = "";
        $orderPaymentsDocumentData = $attributesPost;

        $source = $orderPaymentsDocumentData["source"];
        $pathSet = "/uploads/frontend/orderPaymentsDocument";
        $change = $orderPaymentsDocumentData["change"];
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

            $source =$currentResource. $successMultimediaModel['source'];
            $orderPaymentsDocumentData['source'] = $source;

            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $orderPaymentsDocumentData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  OrderPaymentsDocument.";
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


    }
    public function getListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('order_payments_manager', 'order_payments_manager.id', '=', $this->table . '.order_payments_manager_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere("order_payments_manager.start", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.source', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.account_bank', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.number_bank', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
