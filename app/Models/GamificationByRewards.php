<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


use App\Models\Multimedia;

class GamificationByRewards extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'gamification_by_rewards';

    protected $fillable = array(
        'source',//*
        'title',//*
        'subtitle',
        'description',//*
        'state',//*
        'has_source',//*
        'gamification_id',//*
        'points',//*
        'entity',//*
        'entity_id',
        'percentage',//*
        'amount',//*
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id',//*
        'specific'//*

    );
    protected $attributesData = [
        ['column' => 'source', 'type' => 'string', 'defaultValue' => 'nothing', 'required' => 'true'],
        ['column' => 'title', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'subtitle', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'has_source', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'gamification_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'points', 'type' => 'double', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'entity', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'entity_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'percentage', 'type' => 'double', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'amount', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'deleted_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'specific', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'source';

    public static function getRulesModel()
    {
        $rules = ["source" => "required|max:350",
            "title" => "required",
            "description" => "required",
            "state" => "required",
            "has_source" => "required|numeric",
            "gamification_id" => "required|numeric",
            "points" => "required|numeric",
            "entity" => "required|numeric",
            "entity_id" => "numeric",
            "percentage" => "required|numeric",
            "amount" => "required|numeric",
            "user_id" => "required|numeric",
            "specific" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/
    public function getAdminData($params)
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
        $gamification_id = isset($params['filters']['gamification_id']) ?$params['filters']['gamification_id']: null;

        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.source,$this->table.title,$this->table.subtitle,$this->table.description,$this->table.state,$this->table.has_source,gamification.value as gamification,
gamification.id as gamification_id,
$this->table.points,$this->table.entity,$this->table.entity_id,$this->table.percentage,$this->table.amount,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,$this->table.user_id,$this->table.specific
,product.name entity_name";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('gamification', 'gamification.id', '=', $this->table . '.gamification_id');

        $type = 0;

        $query->leftJoin('product', function ($query)
        use (
            $type

        ) {
            $query->on("$this->table.entity_id", '=', 'product.id');

        });
        $query->where($this->table . '.gamification_id', '=', $gamification_id );

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->where($this->table . '.title', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.points', 'like', '%' . $likeSet . '%');
            });;

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

    public function getAdmin($params)
    {
        $result = $this->getAdminData($params);

        /*if (row.specific == 0 && row.entity == 0 && row.entity_id == -1) {
        detailsEntity = [];
    }
    //type specific product -discount
    else if (row.specific == 1 && row.entity == 0 && row.entity_id != -1) {

    }
    //type all services -discount
    else if (row.specific == 2 && row.entity == 0 && row.entity_id == -1) {

    }
    //type specific service -discount
    else if (row.specific == 3 && row.entity == 0 && row.entity_id != -1) {

    }*/
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
            $modelName = 'GamificationByRewards';
            $model = new GamificationByRewards();
            $createUpdate = true;

            $modelMultimedia = new Multimedia;
            $auxResource = "";
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = GamificationByRewards::find($attributesPost['id']);
                $createUpdate = false;

                $auxResource = $model->source;
            } else {
                $createUpdate = true;
            }

            $user = Auth::user();

            $gamificationByRewardsData = $attributesPost;
            $source = $gamificationByRewardsData["source"];
            $pathSet = "/uploads/gamification/gamificationByRewards";
            $change = $gamificationByRewardsData["change"];
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


                $source = $successMultimediaModel['source'];
                $gamificationByRewardsData['source'] = $source;

                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $gamificationByRewardsData, 'attributesData' => $this->attributesData));
                $attributesSet['user_id'] = $user->id;
                $paramsValidate = array(
                    'modelAttributes' => $attributesSet,
                    'rules' => self::getRulesModel(),

                );
                $validateResult = $this->validateModel($paramsValidate);
                $success = $validateResult["success"];
                if ($success) {
                    $model->fill($attributesSet);
                    $success = $model->save();
                } else {
                    $success = false;
                    $msj = "Problemas al guardar  GamificationByRewards.";
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
        $query->join('gamification', 'gamification.id', '=', $this->table . '.gamification_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {


                $query->where($this->table . '.title', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');

                $query->orWhere($this->table . '.points', 'like', '%' . $likeSet . '%');

            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getRewardsGamificationFrontend($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);

        $selectString = "$this->table.id,$this->table.source,$this->table.title,$this->table.subtitle,$this->table.description,$this->table.state,$this->table.has_source,gamification.value as gamification,
gamification.id as gamification_id,
$this->table.points,$this->table.entity,$this->table.entity_id,$this->table.percentage,$this->table.amount,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,$this->table.user_id,$this->table.specific
,product.name entity_name";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('gamification', 'gamification.id', '=', $this->table . '.gamification_id');
        $type = 0;
        $query->leftJoin('product', function ($query)
        use (
            $type
        ) {
            $query->on("$this->table.entity_id", '=', 'product.id');

        });
        $gamification_id=$params['filters']['gamification_id'];
        $query->where($this->table . '.gamification_id', '=', $gamification_id);
// sort
        $query->orderBy($field, $sort);
// Pagination: $perpage 0; get all data

        $result = $query->get()->toArray();


        return $result;

    }
}
