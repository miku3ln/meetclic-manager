<?php

namespace App\Models\MaritimeOperationsManagement;

use App\Models\Business;
use App\Models\Customer;
use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class MaritimeVessels extends ModelManager
{
    protected $table = 'maritime_vessels';
    protected $modelNameEntity = 'MaritimeVessels';
    public $timestamps = true;

    const TECH_INFO_MEMORIA_TECNICA = 'MEMORIA_TECNICA';
    const TECH_INFO_NA = 'N_A';

    protected $fillable = [
        'business_id',
        'maritime_vessel_type_id',
        'name',
        'length',              // eslora
        'beam',                // manga
        'draft',               // puntal (en tu script)
        'passenger_capacity',
        'owner_customer_id',
        'technical_info_type',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function vesselType()
    {
        return $this->belongsTo(MaritimeVesselTypes::class, 'maritime_vessel_type_id');
    }

    public function owner()
    {
        return $this->belongsTo(Customer::class, 'owner_customer_id');
    }

    public function responsibles()
    {
        return $this->hasMany(MaritimeVesselResponsibles::class, 'maritime_vessel_id');
    }

    public function documents()
    {
        return $this->hasMany(MaritimeVesselDocuments::class, 'maritime_vessel_id');
    }

    public static function getRulesModel()
    {
        return [
            'business_id' => 'required',
            'maritime_vessel_type_id' => 'required',
            'name' => 'required',
            'passenger_capacity' => 'required',
            'owner_customer_id' => 'required',
        ];
    }

    public function getSelect2($params = [])
    {
        $businessId = (int)($params['business_id'] ?? 0);
        $q = trim($params['q'] ?? '');

        return DB::table($this->table . ' as v')
            ->when($businessId > 0, fn($qr) => $qr->where('v.business_id', $businessId))
            ->when($q !== '', fn($qr) => $qr->where('v.name', 'like', "%$q%"))
            ->orderBy('v.name', 'asc')
            ->limit(30)
            ->get(['v.id', DB::raw("v.name as text")])
            ->toArray();
    }

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = 'v.id';
       // $businessId = (int)($params['filters']['business_id'] ?? 0);

        $query = DB::table($this->table . ' as v')
            ->join('business as b', 'b.id', '=', 'v.business_id')
            ->join('maritime_vessel_types as vt', 'vt.id', '=', 'v.maritime_vessel_type_id')
            ->leftJoin('customer as c', 'c.id', '=', 'v.owner_customer_id')
            ->leftJoin('people as p', 'p.id', '=', 'c.people_id');
// ->when($businessId > 0, fn($qr) => $qr->where('v.business_id', $businessId))
        if (isset($params['sort']) && is_array($params['sort']) && count($params['sort']) > 0) {
            $col = array_keys($params['sort'])[0];
            $field = strpos($col, '.') === false ? 'v.' . $col : $col;
            $sort = strtolower($params['sort'][array_keys($params['sort'])[0]]) === 'asc' ? 'asc' : 'desc';
        }

        $query->selectRaw("
            v.id,
            v.business_id,
            v.maritime_vessel_type_id,
            b.title as business_title,
            v.name,
            vt.name as vessel_type,
            v.passenger_capacity,
            v.length,
            v.beam,
            v.draft,
            v.technical_info_type,
            CONCAT(COALESCE(p.name,''),' ',COALESCE(p.last_name,'')) as owner_name,
            c.identification_document as owner_document,
            c.id as owner_id,

            v.created_at
        ");

        if (!empty($params['searchPhrase'])) {
            $like = trim($params['searchPhrase']);

            $likeRaw = trim((string) $like);
            $likeNorm = mb_strtolower($likeRaw, 'UTF-8');
            $needle   = "%{$likeNorm}%";
            $query->where(function ($q) use ($like,$needle) {
                $q->orWhereRaw('LOWER(v.name) LIKE ?', [$needle])
                    ->orWhereRaw('LOWER(vt.name) LIKE ?', [$needle])
                    ->orWhereRaw('LOWER(b.title) LIKE ?', [$needle])
                    ->orWhere('c.identification_document', 'like', "%$like%");
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



    public function saveMaritimeVesselApi($params)
    {
        DB::beginTransaction();

        try {

            $vesselData = $params['MaritimeVessels'] ;

            $vesselSave = $this->saveOrUpdateVessel($vesselData);
            $vessel = null;
            if ($vesselSave["success"]) {
                DB::commit();
                $vessel = $vesselSave["model"];
                // 4) Retornar todo con relaciones
                $vessel = MaritimeVessels::query()
                    ->with([
                        'business',
                        'vesselType',
                        'owner' => function ($q) {
                            $q->with(['people', 'information', 'addresses', 'phones']);
                        },
                        'responsibles' => function ($q) {
                            $q->with([
                                'customer' => function ($q2) {
                                    $q2->with(['people', 'information', 'addresses', 'phones']);
                                }
                            ]);
                        },
                        'documents',
                    ])
                    ->find($vessel->id);

            } else {

            }

            return [
                'success' => true,
                'message' => 'Embarcación registrada con éxito.',
                'data' => [
                    'vessel' => $vessel,
                    'owner' => $vessel->owner ?? null,
                    'responsibles' => $vessel->responsibles ?? [],
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

    /**
     * ✅ Crea el registro principal de la embarcación
     */
    private function saveOrUpdateVessel(array $vesselData)
    {

        $vessel = (isset($vesselData['id']) && $vesselData['id'] != 'null' && $vesselData['id'] != '-1')
            ? MaritimeVessels::find($vesselData['id'])
            : new MaritimeVessels();
        $attributes = [
            'business_id' => $vesselData['business_id'],
            'maritime_vessel_type_id' => $vesselData['maritime_vessel_type_id'] ,
            'name' => $vesselData['name'],
            'length' => $vesselData['length'],
            'beam' => $vesselData['beam'],
            'draft' => $vesselData['draft'],
            'passenger_capacity' => (int)($vesselData['passenger_capacity'] ?? 0),
            'owner_customer_id' => $vesselData['owner_customer_id'],
            'technical_info_type' => $vesselData['technical_info_type'] ,
        ];

        return $this->validateAndSaveModel($vessel, $attributes, 'Embarcación');
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
}
