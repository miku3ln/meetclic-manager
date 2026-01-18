<?php

namespace App\Models\MaritimeOperationsManagement;

use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class MaritimeDocumentTypes extends ModelManager
{
    protected $table = 'maritime_document_types';
    protected $modelNameEntity = 'MaritimeDocumentTypes';
    public $timestamps = true;

    protected $fillable = [
        'id', // ids fijos
        'code',
        'name',
        'description',
    ];

    // IDs fijos (según tu script)
    const DOC_PLANOS = 1;
    const DOC_LIBRETO_ESTABILIDAD = 2;
    const DOC_MANUAL_MOTO = 3;
    const DOC_MANUAL_LANCHA = 4;

    public function typeRules()
    {
        return $this->hasMany(MaritimeVesselTypeDocuments::class, 'maritime_document_type_id');
    }

    public function vesselDocuments()
    {
        return $this->hasMany(MaritimeVesselDocuments::class, 'maritime_document_type_id');
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
}
