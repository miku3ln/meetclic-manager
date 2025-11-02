<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OdontogramByPatient;
use App\Models\DentalPieceByOdontogram;
class Patient extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'patient';

    protected $fillable = array(
        'name',
        'document_type',
        'document',
        'gender',
        'birthday_date',
        'address',
        'latitude',
        'longitude',
        'phone',
        'movil',
        'status');

    public $timestamps = true;


    public function scopeActive($query)
    {
        return $query->where('status', $this::STATUS_ACTIVE);
    }

    public function getDataOdontogram($patient_id)
    {
        $dataOdontogram = array(
            "OdontogramByPatient" => array(),
            "DentalPieceByOdontogram" => array(),
            "allowData" => false
        );
        $odontogram_by_patient_id = null;
        $modelOBP = OdontogramByPatient::where('patient_id', '=', $patient_id)->where("status", "=", "ACTIVE")->first();
        if ($modelOBP) {
            $modelDPBO = new DentalPieceByOdontogram();
            $odontogram_by_patient_id = $modelOBP->id;
            $params = array("odontogram_by_patient_id" => $odontogram_by_patient_id);
            $dataDentalPiece = $modelDPBO->getDataDentalPieceByOdontogramId($params);
            $dataOdontogram["DentalPieceByOdontogram"] = $dataDentalPiece;
            $dataOdontogram["OdontogramByPatient"] = $modelOBP;
            $dataOdontogram["allowData"] = true;

        }
        return $dataOdontogram;
    }
}
