<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utils\Util;

use DB;
use Auth;

class OdontogramByPatient extends ModelManager
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'odontogram_by_patient';
    protected $fillable = array(
        'created_at',
        'updated_at',
        'deleted_at',
        'status',
        'description',
        'date',
        'history_clinic_id'
    );
    protected $attributesData = [
        ['column' => 'created_at', 'type' => 'date', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'date', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'deleted_at', 'type' => 'date', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'date', 'type' => 'date', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'history_clinic_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = true;

    protected $field_main = 'date';

    public static function getRulesModel()
    {
        $rules = [
            "date" => "required",
            "history_clinic_id" => "required|numeric",
            "description" => "required"
        ];
        return $rules;
    }


    public $util_component;

    public function __construct()
    {

        $this->util_component = new Util();
    }

    public function getActionsManager()
    {
        $model_entity = $this->util_component->getUpperCaseTable($this->table);
        $action_get_form = $model_entity . "s" . "'\'" . $model_entity . "Controller" . "@getForm" . $model_entity;
        $action_get_form = str_replace("'", "", $action_get_form);
        $action_save = $model_entity . "s" . "'\'" . $model_entity . "Controller" . "@postSave";
        $action_save = str_replace("'", "", $action_save);
        $action_load = $model_entity . "s" . "'\'" . $model_entity . "Controller" . "@getList" . $model_entity . "s";
        $action_load = str_replace("'", "", $action_load);
        $model_entity = $this->util_component->getCamelCase($this->table);
        return [
            "action_get_form" => $action_get_form,
            "action_save_" . $model_entity => $action_save,
            "action_load_" . $model_entity . "s" => $action_load];
    }


    public function findAllByAttributes($attributes = array(), $values = array(), $columns = array('*'))
    {
        $response = DB::table($this->table)
            ->select($columns);
        if (!is_array($attributes) || !is_array($values)) {
            throw new Exception('$attributes and $values should be array.');
        }
        if (count($attributes) < 1 || count($values) < 1) {
            throw new Exception('$attributes and $values can not be empty.');
        }
        if (count($attributes) != count($values)) {
            throw new Exception('$attributes and $values must have the same length.');
        }
        foreach ($attributes as $key => $attribute) {
            $response->where($attribute, "=", $values[$key]);
        }
        return $response->get();
    }

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
        $history_clinic_id = $params['filters']['history_clinic_id'];
        $formatDate = '"%d/%m/%Y"';
        $formatDateManagement = '"%Y-%m-%d"';

        $selectString = "$this->table.id,$this->table.status,$this->table.description,DATE_FORMAT($this->table.date,$formatDate) date,DATE_FORMAT($this->table.date,$formatDateManagement) dateManagement,$this->table.history_clinic_id
";

        $select = DB::raw($selectString);
        $query->select($select);

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->where($this->table . '.description', 'like', '%' . $likeSet . '%');

                $query->orWhere($this->table . '.date', 'like', '%' . $likeSet . '%');
            });

        }
        $query->where($this->table . '.history_clinic_id', '=', $history_clinic_id);

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
        $user = Auth::user();
        $creation_date = Util::DateCurrent();

        try {
            $modelName = 'OdontogramByPatient';
            $model = new OdontogramByPatient();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = OdontogramByPatient::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }
            $treatmentByPatientData = $attributesPost[$modelName];
            $treatmentByPatientData['created_at'] = $creation_date;
            $treatmentByPatientData['user_id'] = $user->id;

            $attributesSet = $treatmentByPatientData;
            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => self::getRulesModel(),

            );

            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
                $odontogram_by_patient_id = $model->id;
                $items = $attributesPost[$modelName]['items'];
                $modelRPP = new \App\Models\ReferencePiecePosition();
                $modelRP = new \App\Models\ReferencePiece();
                $modelDP = new \App\Models\DentalPiece();
                foreach ($items as $key => $modelItemRow) {


                    $modelItem = new \App\Models\DentalPieceByOdontogram();
                    $setAttributes = $modelItemRow;
                    $reference_piece_id = $modelItemRow['reference_piece_id']['id'];
                    $description = $modelItemRow['description'];

                    $dataRPP = $modelRPP->findByAttribute("position", $modelItemRow["reference_piece_position_id"]);
                    $reference_piece_position_id = $dataRPP->id;
                    $dataDP = $modelDP->findByAttribute("piece", $modelItemRow["dental_piece_id"]);
                    $dental_piece_id = $dataDP->id;
                    $setAttributes['status'] = "ACTIVE";
                    $setAttributes['description'] = $description;
                    $setAttributes['type'] = "PERMANENT";
                    $setAttributes['dental_piece_id'] = $dental_piece_id;
                    $setAttributes['reference_piece_position_id'] = $reference_piece_position_id;
                    $setAttributes['reference_piece_id'] = $reference_piece_id;
                    $setAttributes['odontogram_by_patient_id'] = $odontogram_by_patient_id;


                    $paramsValidate = array(
                        'modelAttributes' => $setAttributes,
                        'rules' => $modelItem::getRulesModel(),
                    );

                    $validateResult = $modelItem->validateModel($paramsValidate);
                    $success = $validateResult["success"];
                    if ($success) {
                        $modelItem->fill($setAttributes);
                        $modelItem->description=$description;

                        $modelItem->save();
                    } else {
                        $msj = 'Error al guardar Odontograma items.';

                        throw new \Exception($msj);

                    }
                }


            } else {
                $success = false;
                $msj = "Problemas al guardar  OdontogramByPatient.";
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
            DB::rollBack();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );
            return ($result);
        }

    }

}
