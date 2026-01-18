<?php

namespace App\Models\MaritimeOperationsManagement;

use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class MaritimeVesselTypeDocuments extends ModelManager
{
    protected $table = 'maritime_vessel_type_documents';
    protected $modelNameEntity = 'MaritimeVesselTypeDocuments';
    public $timestamps = false;

    protected $fillable = [
        'maritime_vessel_type_id',
        'maritime_document_type_id',
        'is_required',
    ];

    const REQUIRED_YES = 1;
    const REQUIRED_NO = 0;

    public function vesselType()
    {
        return $this->belongsTo(MaritimeVesselTypes::class, 'maritime_vessel_type_id');
    }

    public function documentType()
    {
        return $this->belongsTo(MaritimeDocumentTypes::class, 'maritime_document_type_id');
    }

    public static function getRulesModel()
    {
        return [
            'maritime_vessel_type_id' => 'required',
            'maritime_document_type_id' => 'required',
        ];
    }

    // ✅ helper: lista de docs requeridos/opcionales de un tipo
    public static function getDocumentsByVesselType(int $vesselTypeId): array
    {
        return DB::table('maritime_vessel_type_documents as vtd')
            ->join('maritime_document_types as dt', 'dt.id', '=', 'vtd.maritime_document_type_id')
            ->where('vtd.maritime_vessel_type_id', $vesselTypeId)
            ->orderBy('dt.id', 'asc')
            ->get([
                'dt.id',
                'dt.code',
                'dt.name',
                'dt.description',
                'vtd.is_required'
            ])->toArray();
    }
}
