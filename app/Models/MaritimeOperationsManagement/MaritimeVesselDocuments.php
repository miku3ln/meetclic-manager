<?php

namespace App\Models\MaritimeOperationsManagement;

use App\Models\ModelManager;

class MaritimeVesselDocuments extends ModelManager
{
    protected $table = 'maritime_vessel_documents';
    protected $modelNameEntity = 'MaritimeVesselDocuments';
    public $timestamps = false;

    const STATUS_PENDING = 'PENDING';
    const STATUS_APPROVED = 'APPROVED';
    const STATUS_REJECTED = 'REJECTED';

    protected $fillable = [
        'maritime_vessel_id',
        'maritime_document_type_id',
        'file_path',
        'status',
        'uploaded_at',
    ];

    public function vessel()
    {
        return $this->belongsTo(MaritimeVessels::class, 'maritime_vessel_id');
    }

    public function documentType()
    {
        return $this->belongsTo(MaritimeDocumentTypes::class, 'maritime_document_type_id');
    }

    public static function getRulesModel()
    {
        return [
            'maritime_vessel_id' => 'required',
            'maritime_document_type_id' => 'required',
            'file_path' => 'required',
            'status' => 'required',
        ];
    }
}
