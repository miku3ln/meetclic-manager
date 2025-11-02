<?php


namespace App\Models\Tracking;

use Illuminate\Support\Facades\DB;
use App\Models\ModelManager;
use Auth;
use App\Utils\Util;

class TrackingEvents extends ModelManager
{
    protected $table = 'tracking_events';
    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'click_type_id',
        'action_name',
        'manager_click_id',
        'manager_click_type',
        'count',
        'url',
        'section',
        'created_at',
    ];

    protected $attributesData = [
        ['column' => 'session_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'click_type_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'action_name', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
        ['column' => 'manager_click_id', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
        ['column' => 'manager_click_type', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
        ['column' => 'count', 'type' => 'integer', 'defaultValue' => 0, 'required' => 'false'],
        ['column' => 'url', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
        ['column' => 'section', 'type' => 'string', 'defaultValue' => 'default', 'required' => 'false'],
        ['column' => 'created_at', 'type' => 'datetime', 'defaultValue' => null, 'required' => 'false'],
    ];

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        return [
            'session_id' => 'required|integer|exists:tracking_sessions,id',
            'click_type_id' => 'required|integer|exists:tracking_click_types,id',
            'count' => 'nullable|integer|min:0',
            'section' => 'nullable|string|max:100',
            'url' => 'nullable|string',
            'action_name' => 'nullable|string',
            'manager_click_id' => 'nullable|string',
            'manager_click_type' => 'nullable|string|max:45',
        ];
    }

    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = [];
        $errors = [];

        DB::beginTransaction();

        try {
            $modelName = 'TrackingEvent';
            $data = $params['attributesPost'][$modelName];
            $createUpdate = true;
            $model = new TrackingEvent();

            if (!empty($data['id']) && $data['id'] !== "null" && $data['id'] !== "-1") {
                $model = TrackingEvent::find($data['id']);
                $createUpdate = false;
            }

            $attributesSet = $this->getValuesModel([
                'fillAble' => $this->fillable,
                'haystack' => $data,
                'attributesData' => $this->attributesData
            ]);

            $validateResult = $this->validateModel([
                'modelAttributes' => $attributesSet,
                'rules' => self::getRulesModel()
            ]);

            if ($validateResult['success']) {
                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Error al guardar TrackingEvent.";
                $errors = $validateResult['errors'];
            }

            if ($success) {
                DB::commit();
            } else {
                DB::rollBack();
            }

            return [
                'success' => $success,
                'msj' => $msj,
                'errors' => $errors
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'msj' => $e->getMessage(),
                'errors' => $errors
            ];
        }
    }

    public function getListSelect2($params)
    {
        $query = DB::table($this->table);
        $query->select(DB::raw("{$this->table}.id, {$this->table}.action_name as text"));

        if (!empty($params['filters']['search_value']['term'])) {
            $term = $params['filters']['search_value']['term'];
            $query->where(function ($query) use ($term) {
                $query->orWhere('action_name', 'like', '%' . $term . '%');
                $query->orWhere('manager_click_id', 'like', '%' . $term . '%');
                $query->orWhere('section', 'like', '%' . $term . '%');
            });
        }

        $query->limit(10)->orderBy('created_at', 'desc');
        return $query->get()->toArray();
    }

    public function getCountersBusiness($params)
    {
        $limitDays = Util::getDatesInitWeek();
        $query = "";
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;
        $actionName = isset($params['filters']['actionName']) ? $params['filters']['actionName'] : 'businessDetails';
        $getData = isset($params['filters']['allData']) ? $params['filters']['allData'] : false;
        $allVisit = isset($params['filters']['allVisit']) ? $params['filters']['allVisit'] : false;

        if ($allVisit) {
            $subquery = DB::table('tracking_sessions')
                ->select([
                    DB::raw("DATE(created_at) as fecha"),
                    DB::raw("CASE WHEN user_id IS NULL OR user_id = 0 THEN token ELSE CAST(user_id AS CHAR) END AS visitante"),
                    'id',
                    'user_id',
                    'token',
                    'created_at'
                ])
                ->whereBetween('created_at', [$limitDays['from'], $limitDays['to']]);
            $query = DB::table(DB::raw("({$subquery->toSql()}) as sesiones"))
                ->mergeBindings($subquery)
                ->select([
                    'fecha',
                    'visitante',
                    DB::raw('MIN(id) as id'),
                    DB::raw('MIN(user_id) as user_id'),
                    DB::raw('MIN(token) as token'),
                    DB::raw('MIN(created_at) as primer_ingreso')
                ])
                ->groupBy('fecha', 'visitante')
                ->orderBy('fecha');


        }else{
            $query = DB::table($this->table);
            $tableMain = "tracking_sessions";
            $selectString = "tracking_sessions.token,$this->table.id,tracking_sessions.is_guest,tracking_sessions.user_id,$this->table.action_name,tracking_sessions.business_id";
            $select = DB::raw($selectString);
            $query->select($select);
            $query->join('tracking_sessions', $this->table . '.session_id', '=', 'tracking_sessions.id');
            if ($business_id) {
                $query->where('tracking_sessions.business_id', '=', $business_id);
            }
            if (isset($params["filters"]['isWeek'])) {
                $field = 'tracking_sessions.created_at';
                $query->where($field, '>=', $limitDays['from']);
                $query->where($field, '<=', $limitDays['to']);
            }
            if ($actionName) {
                $query->where($this->table . '.action_name', '=', $actionName);
            } else {

            }
        }


        if ($getData) {
            $result = $query->get()->toArray();
        } else {
            $result = $query->get()->count();
        }



        return $result;
    }
}
