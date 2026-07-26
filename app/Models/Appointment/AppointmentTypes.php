<?php

namespace App\Models\Appointment;

use App\Models\Exception;
use App\Models\ModelManager;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;

class AppointmentTypes extends ModelManager
{

    protected $table = 'appointment_types';

    protected $primaryKey = 'id';

    public $timestamps = true;

    public $modelName = 'AppointmentTypes';


    protected $fillable = array(

        "id",
        "business_id",
        "code",
        "title",
        "description",
        "background_color",
        "border_color",
        "text_color",
        "status",
        "created_at",
        "updated_at"

    );


    public $attributesData = array(

        "id",
        "business_id",
        "code",
        "title",
        "description",
        "background_color",
        "border_color",
        "text_color",
        "status",
        "created_at",
        "updated_at"

    );


    public $fieldsCurrentSelect = '';


    public static function getRulesModel()
    {
        return [

            "business_id" => 'required|integer',

            "code" => 'required|string|max:30',

            "title" => 'required|string|max:150',

            "description" => 'nullable|string',

            "background_color" => 'nullable|string|max:20',

            "border_color" => 'nullable|string|max:20',

            "text_color" => 'nullable|string|max:20',

            "status" => 'required|in:0,1'

        ];
    }




    /* =========================================================================
     * Relaciones
     * ========================================================================= */

    public static function getByBusiness(int $businessId)
    {
        return self::select(

            'id',

            'business_id',

            'code',

            'title',

            'description',

            'background_color',

            'border_color',

            'text_color',

            'status'

        )
            ->where(
                'business_id',
                $businessId
            )
            ->where(
                'status',
                1
            )
            ->orderBy(
                'title',
                'asc'
            )
            ->get();
    }
}
