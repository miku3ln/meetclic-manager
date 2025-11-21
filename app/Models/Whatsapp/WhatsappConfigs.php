<?php
namespace App\Models\Whatsapp;

use App\Models\Exception;
use App\Models\ModelManager;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;

class WhatsappConfigs extends ModelManager
{
    protected $table = 'whatsapp_configs';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $modelName = 'WhatsappConfigs';
    protected $fillable = array(
        "id",
        "business_id",
        "country_id",
        "whatsapp_section_id",
        "phone_local",
        "is_primary",
        "status",
        "default_message",
        "created_at",
        "updated_at"
    );

    public $attributesData = array(
        "id",
        "business_id",
        "country_id",
        "whatsapp_section_id",
        "phone_local",
        "is_primary",
        "status",
        "default_message",
        "created_at",
        "updated_at"
    );

    public $fieldsCurrentSelect = '';

    public function __construct()
    {
        parent::__construct();
        $this->fieldsCurrentSelect = $this->getFieldsSelectModel();
    }

    /* =========================================================================
     * Relaciones
     * ========================================================================= */

    public function section()
    {
        return $this->belongsTo(WhatsappSections::class, 'whatsapp_section_id');
    }

    public function business()
    {
        // Ajusta el namespace según tu proyecto real
        return $this->belongsTo(\App\Models\Business\Business::class, 'business_id');
    }

    /* =========================================================================
     * Helpers de modelo
     * ========================================================================= */

    public function getFieldsSelectModel()
    {
        $fieldsArray = $this->fillable;

        return Util::getFieldsSelect(
            Util::getFieldsByAttributes($fieldsArray),
            $this->table
        );
    }

    public static function getRulesModel()
    {
        return [
            "business_id" => 'required|integer',
            "country_id" => 'required|integer',
            "whatsapp_section_id" => 'required|integer',
            "phone_local" => 'required',
            "is_primary" => 'required|in:0,1',
            "status" => 'required|in:ACTIVE,INACTIVE',
            "default_message" => 'nullable|string',
        ];
    }

    /* =========================================================================
     *  MÉTODOS SOLICITADOS (SIN JOIN CON COUNTRIES)
     * =========================================================================
     *
     * 1) getAllConfigsFull()
     * 2) getConfigsByBusiness($businessId)
     * 3) getConfigsByBusinessAndSection($businessId, $sectionId)
     *
     *  - Devuelven:
     *      - Campos de whatsapp_configs
     *      - Campos de whatsapp_sections
     *      - Campo calculado: number_current = phone_local
     * ========================================================================= */

    /**
     * 1) Obtener TODOS los números configurados (todas las empresas, todas las secciones).
     */
    public function getAllConfigsFull()
    {
        $query = DB::table($this->table)
            ->join('whatsapp_sections', 'whatsapp_sections.id', '=', $this->table . '.whatsapp_section_id');

        $selectString = $this->fieldsCurrentSelect;

        // Campos de whatsapp_sections
        $selectString .= ",
            whatsapp_sections.name        AS whatsapp_sections_name,
            whatsapp_sections.slug        AS whatsapp_sections_slug,
            whatsapp_sections.description AS whatsapp_sections_description,
            whatsapp_sections.status      AS whatsapp_sections_status";

        // Campo calculado: aquí tomamos tal cual el local
        $selectString .= ",
            " . $this->table . ".phone_local AS number_current";

        $select = DB::raw($selectString);

        $query->select($select);
        $query->where($this->table . '.status', '=', 'ACTIVE');

        $query->orderBy($this->table . '.business_id', 'asc')
            ->orderBy('whatsapp_sections.slug', 'asc');

        return $query->get()->toArray();
    }

    /**
     * 2) Obtener números configurados por business_id.
     *
     * @param int $businessId
     * @return array
     */
    public function getConfigsByBusiness($businessId)
    {
        $query = DB::table($this->table)
            ->join('whatsapp_sections', 'whatsapp_sections.id', '=', $this->table . '.whatsapp_section_id');

        $selectString = $this->fieldsCurrentSelect;

        $selectString .= ",
            whatsapp_sections.name        AS whatsapp_sections_name,
            whatsapp_sections.slug        AS whatsapp_sections_slug,
            whatsapp_sections.description AS whatsapp_sections_description,
            whatsapp_sections.status      AS whatsapp_sections_status";

        $selectString .= ",
            " . $this->table . ".phone_local AS number_current";

        $select = DB::raw($selectString);

        $query->select($select);
        $query->where($this->table . '.status', '=', 'ACTIVE');
        $query->where($this->table . '.business_id', '=', $businessId);

        $query->orderBy('whatsapp_sections.slug', 'asc');

        return $query->get()->toArray();
    }

    /**
     * 3) Obtener números configurados por business_id y whatsapp_section_id.
     *
     * @param int $businessId
     * @param int $sectionId
     * @return array
     */
    public function getConfigsByBusinessAndSection($businessId, $sectionId)
    {
        $query = DB::table($this->table)
            ->join('whatsapp_sections', 'whatsapp_sections.id', '=', $this->table . '.whatsapp_section_id');

        $selectString = $this->fieldsCurrentSelect;

        $selectString .= ",
            whatsapp_sections.name        AS whatsapp_sections_name,
            whatsapp_sections.slug        AS whatsapp_sections_slug,
            whatsapp_sections.description AS whatsapp_sections_description,
            whatsapp_sections.status      AS whatsapp_sections_status";

        $selectString .= ",
            " . $this->table . ".phone_local AS number_current";

        $select = DB::raw($selectString);

        $query->select($select);
        $query->where($this->table . '.status', '=', 'ACTIVE');
        $query->where($this->table . '.business_id', '=', $businessId);
        $query->where($this->table . '.whatsapp_section_id', '=', $sectionId);

        $query->orderBy($this->table . '.id', 'asc');

        return $query->get()->toArray();
    }

    /* =========================================================================
     *  Métodos estándar tipo Admin (opcional)
     * ========================================================================= */

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = 'id';
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $select = DB::raw($this->fieldsCurrentSelect);
        $query->select($select);

        if (!empty($params['searchPhrase'])) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where(function ($q) use ($likeSet) {
                $q->where($this->table . '.phone_local', 'like', $likeSet)
                    ->orWhere($this->table . '.default_message', 'like', $likeSet);
            });
        }

        $resultManager = $this->setFilterQueryAdmin($query, $field, $sort, $params);
        $total = $resultManager['total'];

        return [
            'total' => $total,
            'rows' => $resultManager['data'],
            'current' => $resultManager['current_page'],
            'rowCount' => isset($params['rowCount']) ? $params['rowCount'] : 10,
        ];
    }

    public function getAdminData($params)
    {
        return $this->getAdmin($params);
    }

    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();

        DB::beginTransaction();
        try {
            $model = new WhatsappConfigs();
            $createUpdate = true;

            if (isset($attributesPost[$this->modelName]["id"])
                && $attributesPost[$this->modelName]["id"] != "null"
                && $attributesPost[$this->modelName]["id"] != "-1") {

                $model = WhatsappConfigs::find($attributesPost[$this->modelName]['id']);
                $createUpdate = false;
            }

            $postData = $attributesPost[$this->modelName];
            $attributes = $model->getValuesByPost($postData, $createUpdate);
            $model->attributes = $attributes;

            $validateResult = $model->validate();
            $success = $validateResult["success"];

            if ($success) {
                $model->fill($attributes);
                $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar.";
                $errors = $validateResult["errors"];
            }

            if (!$success) {
                DB::rollBack();
            } else {
                DB::commit();
            }

            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
            ];

            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            $msj = $e->getMessage();
            return [
                "success" => false,
                "msj" => $msj,
                "errors" => $errors
            ];
        }
    }
}
