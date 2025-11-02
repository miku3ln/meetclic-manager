<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class DailyBookSeat extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'daily_book_seat';

    protected $fillable = array(
        'value',//*
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        'register_manager_date',//*
        'entidad_data_id',//*
        'status'//*

    );
    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'deleted_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'register_manager_date', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'entidad_data_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = ["value" => "required|max:350",
            "register_manager_date" => "required",
            "entidad_data_id" => "required|numeric",
            "status" => "required"
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

        $selectString = "$this->table.id,$this->table.value,$this->table.description,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,$this->table.register_manager_date,$this->table.entidad_data_id,$this->table.status";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.updated_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.deleted_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.register_manager_date', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.entidad_data_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
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


    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $modelName = 'DailyBookSeat';
            $model = new DailyBookSeat();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = DailyBookSeat::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $dailyBookSeatData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $dailyBookSeatData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  DailyBookSeat.";
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
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.updated_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.deleted_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.register_manager_date', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.entidad_data_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function saveMultipleData($params)
    {
        $result = array();
        $haystack = $params["haystack"];
        $success = count($haystack) == 0 ? false : true;
        $msj = "Ningun Registro existente Asientos";

        $errors = array();
        foreach ($haystack as $keyAS => $row) {
            $modelDBS = new \App\Models\DailyBookSeat();
            $setPushDBS = $row["attributes"];

            $modelDBS->attributes = $setPushDBS;
            $dataLibroDiario = $row["data"];
            $validateManager = $modelDBS->validate();
            if ($validateManager['success']) {
                $modelDBS->fill($setPushDBS);
                $modelDBS->save();
                $asiento_libro_diario_id = $modelDBS->id;
                foreach ($dataLibroDiario as $keyBD => $bookDiary) {
                    $modelLD = new \App\Models\DiaryBook();
                    $attributesLD = $bookDiary["attributes"];
                    $modelLD->attributes = $attributesLD;
                    $validateManager = $modelLD->validate();
                    if ($validateManager['success']) {
                        $modelLD->fill($attributesLD);
                        $modelLD->save();
                        $libro_diario_id = $modelLD->id;
                        $dataHas = $bookDiary["relation"];
                        $modelEHL = new  \App\Models\BusinessByDailyBookSeat();
                        $dataHasPush['daily_book_seat_id'] = $asiento_libro_diario_id;
                        $dataHasPush['diary_book_id'] = $libro_diario_id;
                        $dataHasPush['business_id']=isset($dataHas['entidad_data_id'])?$dataHas['entidad_data_id']:$dataHas['business_id'];
                        $dataHasPush['entity']=isset($dataHas['entity'])?$dataHas['entity']:$dataHas['entidad'];
                        $dataHasPush['entity_id']=isset($dataHas['entity_id'])?$dataHas['entity_id']:$dataHas['entidad_id'];
                        $dataHasPush['level_4']=isset($dataHas['level_4'])?$dataHas['level_4']:(isset($dataHas['level_4'])?$dataHas['level_4']:'none');
                        $dataHasPush['user_id']=isset($dataHas['user_id'])?$dataHas['user_id']:(isset($dataHas['owner_id'])?$dataHas['owner_id']:null);


                        $modelEHL->attributes = $dataHasPush;
                        $validateManager = $modelEHL->validate();

                        if ($validateManager['success']) {
                            $modelEHL->fill($dataHasPush);
                            $modelEHL->save();

                        } else {
                            $success = false;
                            $msj = "Relacion libro diario y asiento.";

                            $errors = $validateManager['errors'];
                            break;
                        }
                    } else {
                        $success = false;
                        $msj = "Libro diario no guardado.";
                        $errors = $validateManager['errors'];
                        break;

                    }


                }
            } else {
                $success = false;
                $msj = "Asiento no guardado.";
                $errors = $validateManager['errors'];
                break;
            }
        }
        $result["msj"] = $msj;
        $result["success"] = $success;
        $result["errors"] = $errors;


        return $result;
    }

}
