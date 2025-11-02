<?php


namespace App\Models\Tracking;

use Illuminate\Support\Facades\DB;
use App\Models\ModelManager;
use Auth;

class TrackingClickTypes extends ModelManager
{
    protected $table = 'tracking_click_types';
    public $timestamps = false;

    protected $fillable = [
        'uid',
        'code',
        'description',
        'icon_type',
        'icon_class',
        'icon_url',
        'is_default'
    ];

    protected $attributesData = [
        ['column' => 'uid',         'type' => 'string',  'defaultValue' => '',     'required' => 'true'],
        ['column' => 'code',        'type' => 'string',  'defaultValue' => '',     'required' => 'true'],
        ['column' => 'description', 'type' => 'string',  'defaultValue' => '',     'required' => 'true'],
        ['column' => 'icon_type',   'type' => 'string',  'defaultValue' => 'icon', 'required' => 'false'],
        ['column' => 'icon_class',  'type' => 'string',  'defaultValue' => '',     'required' => 'false'],
        ['column' => 'icon_url',    'type' => 'string',  'defaultValue' => '',     'required' => 'false'],
        ['column' => 'is_default',  'type' => 'boolean', 'defaultValue' => false,  'required' => 'false'],
    ];

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        return [
            'uid'         => 'required|string|max:32|unique:tracking_click_types,uid',
            'code'        => 'required|string|max:32|unique:tracking_click_types,code',
            'description' => 'required|string',
            'icon_type'   => 'nullable|string|in:icon,image',
            'icon_class'  => 'nullable|string|max:100',
            'icon_url'    => 'nullable|string',
            'is_default'  => 'boolean'
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
            $modelName = 'TrackingClickType';
            $data = $params['attributesPost'][$modelName];
            $createUpdate = true;
            $model = new TrackingClickType();

            if (!empty($data['id']) && $data['id'] !== "null" && $data['id'] !== "-1") {
                $model = TrackingClickType::find($data['id']);
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
                $msj = "Error al guardar TrackingClickType.";
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
        $selectString = "$this->table.id, $this->table.description as text";
        $query->select(DB::raw($selectString));

        if (!empty($params['filters']['search_value']['term'])) {
            $term = $params['filters']['search_value']['term'];
            $query->where(function ($query) use ($term) {
                $query->orWhere('uid', 'like', '%' . $term . '%');
                $query->orWhere('code', 'like', '%' . $term . '%');
                $query->orWhere('description', 'like', '%' . $term . '%');
            });
        }

        $query->limit(10)->orderBy('description', 'asc');
        return $query->get()->toArray();
    }

}
