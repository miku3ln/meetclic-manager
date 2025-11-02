<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Multimedia;
use App\Models\GamificationByPoints;

class GamificationByProcess extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'gamification_by_process';

    protected $fillable = array(
        'source',//*
        'title',//*
        'subtitle',
        'description',//*
        'state',//*
        'has_source',//*
        'entity',//*
        'entity_id',//*
        'url_manager',//*
        'gamification_id',//*
        'gamification_type_activity_id',//*
        'is_url',//*
        'type_manager',//*
        'user_id',//*
        'unique_code',//*
        'allow_golden',//*
        'icon_class',//*



    );
    protected $attributesData = [
        ['column' => 'source', 'type' => 'string', 'defaultValue' => 'nothing', 'required' => 'true'],
        ['column' => 'title', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'subtitle', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'has_source', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'entity', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'entity_id', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'url_manager', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'gamification_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'gamification_type_activity_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'is_url', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'type_manager', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'user_id' => '0', 'required' => 'true'],
        ['column' => 'unique_code', 'type' => 'string', 'unique_code' => '0', 'required' => 'true'],
        ['column' => 'allow_golden', 'type' => 'integer', 'allow_golden' => '1', 'required' => 'true'],
        ['column' => 'icon_class', 'type' => 'integer', 'icon_class' => 'fa fa', 'required' => 'true'],

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
            "entity" => "required|max:200",
            "entity_id" => "required|max:200",
            "url_manager" => "required",
            "gamification_id" => "required|numeric",
            "gamification_type_activity_id" => "required|numeric",
            "is_url" => "required|numeric",
            "type_manager" => "required|numeric",
            "user_id" => "required|numeric",
            "unique_code" => "required",
            "allow_golden" => "required",
            "icon_class" => "required",

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

        $selectString = "$this->table.id,$this->table.source,$this->table.title,$this->table.subtitle,$this->table.description,$this->table.state,$this->table.has_source,$this->table.entity,$this->table.entity_id,$this->table.url_manager,gamification.value as gamification,
gamification.id as gamification_id,
gamification_type_activity.title as gamification_type_activity,
gamification_type_activity.id as gamification_type_activity_id,
gamification_by_points.points,gamification_by_points.id gamification_by_points_id,
$this->table.is_url,$this->table.type_manager
,product.id product_id,product.name product_name";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('gamification', 'gamification.id', '=', $this->table . '.gamification_id');
        $query->join('gamification_type_activity', 'gamification_type_activity.id', '=', $this->table . '.gamification_type_activity_id');
        $query->join('gamification_by_points', $this->table . '.id', '=', 'gamification_by_points.gamification_by_process_id');
        $gamification_id = ($params['filters']['gamification_id']);
        $query->where($this->table . '.gamification_id', '=', $gamification_id);

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where(function ($query) use (
                $likeSet
            ) {

                $query->where($this->table . '.title', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.url_manager', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.unique_code', 'like', '%' . $likeSet . '%');

                $query->orWhere("gamification.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("gamification_by_points.points", 'like', '%' . $likeSet . '%');


            });
        }
        $tableRelation = 'product';
        $tableRelationMain = 'gamification_by_process';
        $paramsCurrent = [
            'tableRelation' => $tableRelation,
            'tableRelationMain' => $tableRelationMain
        ];
        $query->leftJoin($tableRelation, function ($query)
        use (
            $paramsCurrent
        ) {
            $tableRelation = $paramsCurrent['tableRelation'];
            $tableRelationMain = $paramsCurrent['tableRelationMain'];
            $query->on($tableRelation . '.id', '=', $tableRelationMain . '.entity_id');
        });

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
            $modelName = 'GamificationByProcess';
            $model = new GamificationByProcess();
            $modelChildren = null;
            $createUpdate = true;

            $modelMultimedia = new Multimedia;
            $auxResource = "";
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = GamificationByProcess::find($attributesPost['id']);
                $createUpdate = false;
                $modelChildren = GamificationByPoints::find($attributesPost['gamification_by_points_id']);
                $auxResource = $model->source;
            } else {
                $modelChildren = new GamificationByPoints();

                $createUpdate = true;
            }

            $gamificationByProcessData = $attributesPost;
            $gamificationByProcessData["allow_golden"] = 1;
            $gamificationByProcessData["icon_class"] = "fa fa-data";

            $source = $gamificationByProcessData["source"];
            $pathSet = "/uploads/gamification/gamificationByProcess";
            $change = $gamificationByProcessData["change"];
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
                $gamificationByProcessData['source'] = $source;

                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $gamificationByProcessData, 'attributesData' => $this->attributesData));
                $user = Auth::user();
                $user_id = $user->id;
                $attributesSet['user_id'] = $user_id;

                $paramsValidate = array(
                    'modelAttributes' => $attributesSet,
                    'rules' => self::getRulesModel(),

                );

                $validateResult = $this->validateModel($paramsValidate);
                $success = $validateResult["success"];
                if ($success) {


                    $model->fill($attributesSet);
                    $success = $model->save();

                    $gamification_by_process_id = $model->id;
                    $attributesSet = [
                        'gamification_by_process_id' => $gamification_by_process_id,
                        'points' => $attributesPost['points'],

                    ];
                    $paramsValidate = array(
                        'modelAttributes' => $attributesSet,
                        'rules' => GamificationByPoints::getRulesModel(),
                    );

                    $validateResult = GamificationByPoints::validateModel($paramsValidate);
                    $success = $validateResult["success"];
                    if ($success) {
                        $modelChildren->fill($attributesSet);
                        $success = $modelChildren->save();
                    } else {
                        $success = false;
                        $msj = "Problemas al guardar  Points.";
                        $errors = $validateResult["errors"];
                    }


                } else {
                    $success = false;
                    $msj = "Problemas al guardar  GamificationByProcess.";
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
        $query->join('gamification_type_activity', 'gamification_type_activity.id', '=', $this->table . '.gamification_type_activity_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.source', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.title', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.has_source', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.entity', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.entity_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.url_manager', 'like', '%' . $likeSet . '%');
            $query->orWhere("gamification.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("gamification_type_activity.source", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.is_url', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type_manager', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getActivitiesGamificationFrontend($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);

        $selectString = "$this->table.id,$this->table.source,$this->table.title,$this->table.subtitle,$this->table.description,$this->table.state,$this->table.has_source,$this->table.entity,$this->table.entity_id,$this->table.url_manager,gamification.value as gamification,
gamification.id as gamification_id,
gamification_type_activity.title as gamification_type_activity,
gamification_type_activity.id as gamification_type_activity_id,
gamification_by_points.points,gamification_by_points.id gamification_by_points_id,
$this->table.is_url,$this->table.type_manager";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('gamification', 'gamification.id', '=', $this->table . '.gamification_id');
        $query->join('gamification_type_activity', 'gamification_type_activity.id', '=', $this->table . '.gamification_type_activity_id');
        $query->join('gamification_by_points', $this->table . '.id', '=', 'gamification_by_points.gamification_by_process_id');
        $gamification_id = ($params['filters']['gamification_id']);
        $query->where($this->table . '.gamification_id', '=', $gamification_id);

// sort
        $query->orderBy($field, $sort);

        $result = $query->get()->toArray();

        return $result;
    }

}
