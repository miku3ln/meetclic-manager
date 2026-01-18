<?php

namespace App\Models\MaritimeOperationsManagement;

use App\Models\Customer;
use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class MaritimeVesselResponsibles extends ModelManager
{
    protected $table = 'maritime_vessel_responsibles';
    protected $modelNameEntity = 'MaritimeVesselResponsibles';
    public $timestamps = false;

    const ROLE_CAPITAN = 'CAPITAN';
    const ROLE_OPERADOR = 'OPERADOR';
    const ROLE_RESPONSABLE = 'RESPONSABLE';

    protected $fillable = [
        'maritime_vessel_id',
        'customer_id',
        'role',
    ];

    public function vessel()
    {
        return $this->belongsTo(MaritimeVessels::class, 'maritime_vessel_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public static function getRulesModel()
    {
        return [
            'maritime_vessel_id' => 'required',
            'customer_id' => 'required',
            'role' => 'required',
        ];
    }

    private function saveOrUpdateVesselResponsible(array $data)
    {

        $vessel = (isset($data['id']) && $data['id'] != 'null' && $data['id'] != '-1')
            ? MaritimeVesselResponsibles::find($data['id'])
            : new MaritimeVesselResponsibles();
        $attributes = [
            'maritime_vessel_id' => $data['maritime_vessel_id'],
            'customer_id' => $data['customer_id'] ,
            'role' => $data['role'],

        ];

        return $this->validateAndSaveModel($vessel, $attributes, 'MaritimeVesselResponsibles');
    }
    private function validateAndSaveModel($model, $attributes, $entityName)
    {
        $id = $model->id ?? null; // si existe, es update

        $validation = $model::validateModel($attributes, $id);

        if (!$validation['success']) {
            return [
                "model" => null,
                'success' => false,
                'msj' => "Problemas al guardar $entityName.",
                'errors' => $validation['errors'],
                'data' => []
            ];
        }
        $model->fill($attributes);
        $model->save();
        $attributes['id'] = $model->id;

        return [
            "model" => $model,
            'success' => true,
            'msj' => '',
            'errors' => [],
            'data' => $attributes
        ];
    }
    public function saveMaritimeVesselResponsiblesApi($params)
    {
        DB::beginTransaction();

        try {

            $modelData = $params['MaritimeVesselResponsibles'] ;

            $modelSave = $this->saveOrUpdateVesselResponsible($modelData);
            $model = null;
            if ($modelSave["success"]) {
                DB::commit();
                $model = $modelSave["model"];


            } else {

            }

            return [
                'success' => true,
                'message' => 'Responsable Agregado con exito.',
                'data' => [
                    'model' => $model,

                ]
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => []
            ];
        }
    }
    public function getAdmin($params)
    {
        $sort = 'desc';
        $field = 'mvr.id';
        $maritime_vessel_id  = $params["filters"]['maritime_vessel_id'];

        $query = DB::table($this->table . ' as mvr')
            ->join('customer as c', 'c.id', '=', 'mvr.customer_id')
            ->join('people as p', 'p.id', '=', 'c.people_id')
        ->where('mvr.maritime_vessel_id', '=', $maritime_vessel_id);

        if (isset($params['sort']) && is_array($params['sort']) && count($params['sort']) > 0) {
            $col = array_keys($params['sort'])[0];
            $field = strpos($col, '.') === false ? 'v.' . $col : $col;
            $sort = strtolower($params['sort'][array_keys($params['sort'])[0]]) === 'asc' ? 'asc' : 'desc';
        }

        $query->selectRaw("
            mvr.id,
            mvr.maritime_vessel_id ,
            mvr.role ,

            mvr.customer_id  ,
            CONCAT(COALESCE(p.name,''),' ',COALESCE(p.last_name,'')) as owner_name,
            c.identification_document as owner_document,
            c.id as owner_id
        ");

        if (!empty($params['searchPhrase'])) {
            $like = trim($params['searchPhrase']);
            $query->where(function ($q) use ($like) {
                $q->orWhere('c.identification_document', 'like', "%$like%");
            });
        }

        $recordsTotal = (clone $query)->count();

        $page = isset($params['current']) ? (int)$params['current'] : 1;
        $perpage = isset($params['rowCount']) ? (int)$params['rowCount'] : 10;

        $query->orderBy($field, $sort);

        if ($perpage > 0) {
            $pages = (int)ceil($recordsTotal / $perpage);
            $page = max($page, 1);
            $page = min($page, $pages);
            $offset = ($page - 1) * $perpage;
            $query->offset((int)$offset)->limit((int)$perpage);
        }

        return [
            'total' => $recordsTotal,
            'rows' => $query->get()->toArray(),
            'current' => $page,
            'rowCount' => $perpage,
        ];
    }


}
