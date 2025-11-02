<?php


namespace App\Models\Tracking;

use Illuminate\Support\Facades\DB;
use App\Models\ModelManager;
use Auth;

class TrackingSessions extends ModelManager
{
    protected $table = 'tracking_sessions';
    public $timestamps = false;

    protected $fillable = [
        'token',
        'user_id',
        'business_id',
        'business_by_counter_id',
        'is_guest',
        'source_id',
        'referer_url',
        'campaign_code',
        'device_agent',
        'ip_address',
        'country',
        'region',
        'city',
        'latitude',
        'longitude',
        'created_at',
    ];

    protected $attributesData = [
        ['column' => 'token',                  'type' => 'string',  'defaultValue' => '',               'required' => 'true'],
        ['column' => 'user_id',                'type' => 'integer', 'defaultValue' => null,            'required' => 'false'],
        ['column' => 'business_id',            'type' => 'integer', 'defaultValue' => '',              'required' => 'true'],
        ['column' => 'business_by_counter_id', 'type' => 'integer', 'defaultValue' => null,            'required' => 'false'],
        ['column' => 'is_guest',               'type' => 'boolean', 'defaultValue' => false,           'required' => 'true'],
        ['column' => 'source_id',              'type' => 'integer', 'defaultValue' => '',              'required' => 'true'],
        ['column' => 'referer_url',            'type' => 'string',  'defaultValue' => 'internal',      'required' => 'false'],
        ['column' => 'campaign_code',          'type' => 'string',  'defaultValue' => null,            'required' => 'false'],
        ['column' => 'device_agent',           'type' => 'string',  'defaultValue' => 'default-agent', 'required' => 'false'],
        ['column' => 'ip_address',             'type' => 'string',  'defaultValue' => '0.0.0.0',        'required' => 'false'],
        ['column' => 'country',                'type' => 'string',  'defaultValue' => null,            'required' => 'false'],
        ['column' => 'region',                 'type' => 'string',  'defaultValue' => null,            'required' => 'false'],
        ['column' => 'city',                   'type' => 'string',  'defaultValue' => null,            'required' => 'false'],
        ['column' => 'latitude',               'type' => 'decimal', 'defaultValue' => null,            'required' => 'false'],
        ['column' => 'longitude',              'type' => 'decimal', 'defaultValue' => null,            'required' => 'false'],
        ['column' => 'created_at',             'type' => 'datetime','defaultValue' => null,            'required' => 'false'],
    ];

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        return [
            'token'       => 'required|string|max:250',
            'business_id' => 'required|integer',
            'source_id'   => 'required|integer|exists:tracking_sources,id',
            'is_guest'    => 'required|boolean',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'ip_address'  => 'nullable|string|max:45',
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
            $modelName = 'TrackingSession';
            $data = $params['attributesPost'][$modelName];
            $createUpdate = true;
            $model = new TrackingSession();

            if (!empty($data['id']) && $data['id'] !== "null" && $data['id'] !== "-1") {
                $model = TrackingSession::find($data['id']);
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
                $msj = "Error al guardar TrackingSession.";
                $errors = $validateResult['errors'];
            }

            if ($success) {
                DB::commit();
            } else {
                DB::rollBack();
            }

            return [
                'success' => $success,
                'msj'     => $msj,
                'errors'  => $errors
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'msj'     => $e->getMessage(),
                'errors'  => $errors
            ];
        }
    }

    public function getListSelect2($params)
    {
        $field = $this->table . '.' . $this->field_main;
        $query = DB::table($this->table);
        $selectString = "$this->table.id, $this->table.token as text";
        $query->select(DB::raw($selectString));

        if (!empty($params['filters']['search_value']['term'])) {
            $term = $params['filters']['search_value']['term'];
            $query->where('token', 'like', '%' . $term . '%');
        }

        $query->limit(10)->orderBy('created_at', 'desc');
        return $query->get()->toArray();
    }

}
