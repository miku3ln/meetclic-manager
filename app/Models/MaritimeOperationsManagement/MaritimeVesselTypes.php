<?php

namespace App\Models\MaritimeOperationsManagement;

use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class MaritimeVesselTypes extends ModelManager
{
    protected $table = 'maritime_vessel_types';
    protected $modelNameEntity = 'MaritimeVesselTypes';
    public $timestamps = true;

    protected $fillable = [
        'id', // ids fijos
        'code',
        'name',
        'description',
    ];

    // IDs fijos (según tu script)
    const TYPE_LANCHA_PASAJEROS = 1;
    const TYPE_CRUCERO_TURISTICO = 2;
    const TYPE_LANCHA_DEPORTIVA = 3;
    const TYPE_MOTO_ACUATICA = 4;
    const TYPE_BOTE_ARTESANAL = 5;

    public function vessels()
    {
        return $this->hasMany(MaritimeVessels::class, 'maritime_vessel_type_id');
    }

    public function requiredDocuments()
    {
        return $this->hasMany(MaritimeVesselTypeDocuments::class, 'maritime_vessel_type_id');
    }

    public static function getRulesModel()
    {
        return [
            'code' => 'required',
            'name' => 'required',
        ];
    }

    public function getSelect2($params = [])
    {
        $q = trim($params['q'] ?? '');

        return DB::table($this->table)
            ->when($q !== '', function ($qr) use ($q) {
                $qr->where('name', 'like', "%$q%")
                    ->orWhere('code', 'like', "%$q%");
            })
            ->orderBy('name', 'asc')
            ->limit(30)
            ->get(['id', DB::raw("name as text")])
            ->toArray();
    }

    public function getDocumentsByVesselType($params = [])
    {
        $vesselTypeId = (int)($params['maritime_vessel_type_id'] ?? 0);

        if ($vesselTypeId <= 0) {
            return [];
        }

        return DB::table('maritime_vessel_type_documents as vtd')
            ->join('maritime_document_types as dt', 'dt.id', '=', 'vtd.maritime_document_type_id')
            ->where('vtd.maritime_vessel_type_id', $vesselTypeId)
            ->orderBy('dt.name', 'asc')
            ->get([
                'dt.id',
                'dt.code',
                'dt.name',
                'dt.description',
                DB::raw('vtd.is_required as is_required'),
            ])
            ->toArray();
    }

    public function getDataTypes($params)
    {
        $data = $this->getSelect2($params);

        foreach ($data as $key => $row) {
            $maritime_vessel_type_id=$row->id;
            $setPush = json_decode(json_encode($row), true);
            $data[$key]=$setPush;
            $data[$key]["documents"]=$this->getDocumentsByVesselType(["maritime_vessel_type_id"=>$maritime_vessel_type_id]);

        }
        return $data;
    }

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->table . '.id';

        $query = DB::table($this->table)
            ->select([
                $this->table . '.id',
                $this->table . '.code',
                $this->table . '.name',
                $this->table . '.description',
                $this->table . '.created_at',
            ]);

        if (!empty($params['searchPhrase'])) {
            $like = trim($params['searchPhrase']);
            $query->where(function ($q) use ($like) {
                $q->orWhere('id', 'like', "%$like%")
                    ->orWhere('name', 'like', "%$like%")
                    ->orWhere('code', 'like', "%$like%");
            });
        }

        if (isset($params['sort'])) {
            $column = array_keys($params['sort']);
            $field = $column[0];
            if (strpos($field, '.') === false) $field = $this->table . '.' . $field;
            $sort = strtolower($params['sort'][$column[0]]) === 'desc' ? 'desc' : 'asc';
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
