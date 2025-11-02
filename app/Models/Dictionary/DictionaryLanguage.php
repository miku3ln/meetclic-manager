<?php

namespace App\Models\Dictionary;

use App\Models\ModelManager;

use Illuminate\Support\Facades\DB;

class DictionaryLanguage extends ModelManager
{


    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dictionary_language';
    protected $modelNameEntity = 'DictionaryLanguage';

    protected $fillable = array('name', "description", 'status', 'diccionary_language_id', 'letters_of_the_alphabet');

    public $timestamps = true;

    public static function getRulesModel()
    {
        $rules = [
            "value" => "required",
            "status" => "required",
            "from_language_id" => "required|numeric",
            "to_language_id" => "required"

        ];
        return $rules;
    }

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = 'value';
        $query = DB::table($this->table);
        $entity_manager_id = isset($params['filters']['entity_manager_id']) ? $params['filters']['entity_manager_id'] : null;

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.value,$this->table.description,$this->table.status,$this->table.diccionary_language_id,$this->table.letters_of_the_alphabet";
        if ($entity_manager_id != null) {
            $query->where(
                $this->table . '.diccionary_language_id', '=', $entity_manager_id
            );

        }
        $select = DB::raw($selectString);
        $query->select($select);

        $query->join('dictionary_language', 'dictionary_language.id', '=', $this->table . '.diccionary_language_id');


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
        $data = null;
        DB::beginTransaction();
        try {
            $modelName = $this->modelNameEntity;
            $model = new DictionaryLanguage();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = DictionaryLanguage::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $modelData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $modelData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {


                if (!$createUpdate) {


                }
                $model->fill($attributesSet);
                $success = $model->save();

            } else {
                $success = false;
                $msj = "Problemas al guardar  DictionaryLanguage.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                $data = $model;
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "data" => $data,

                "success" => $success
            ];

            return ($result);
        } catch (\Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "data" => $data,
                "errors" => $errors
            );
            return ($result);
        }
    }


}
