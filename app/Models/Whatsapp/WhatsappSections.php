<?php
// CPP-0XX
namespace App\Models\Whatsapp;

use App\Models\Exception;
use App\Models\ModelManager;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;

class WhatsappSections extends ModelManager
{
    protected $table = 'whatsapp_sections';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $modelName = 'WhatsappSections';

    protected $fillable = array(
        "id",
        "code",
        "name",
        "slug",
        "description",
        "status",
        "created_at",
        "updated_at"
    );

    public $attributesData = array(
        "id",
        "code",
        "name",
        "slug",
        "description",
        "status",
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

    public function configs()
    {
        return $this->hasMany(WhatsappConfigs::class, 'whatsapp_section_id');
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
            "code"        => 'required|string|max:50',
            "name"        => 'required|string|max:100',
            "slug"        => 'required|string|max:120',
            "description" => 'nullable|string',
            "status"      => 'required|in:ACTIVE,INACTIVE',
        ];
    }

    /* =========================================================================
     *  ADMIN (listado paginado estilo bootgrid)
     * ========================================================================= */

    public function getAdmin($params)
    {
        $sort  = 'asc';
        $field = 'name';
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field  = $column = array_keys($params['sort']);
            $field  = $field[0];
            $sort   = $params['sort'][$column[0]];
        }

        $select = DB::raw($this->fieldsCurrentSelect);
        $query->select($select);

        if (!empty($params['searchPhrase'])) {
            $searchValue = $params['searchPhrase'];
            $likeSet     = "%" . $searchValue . "%";

            $query->where(function ($q) use ($likeSet) {
                $q->where($this->table . '.name', 'like', $likeSet)
                    ->orWhere($this->table . '.slug', 'like', $likeSet)
                    ->orWhere($this->table . '.code', 'like', $likeSet)
                    ->orWhere($this->table . '.description', 'like', $likeSet);
            });
        }

        $resultManager = $this->setFilterQueryAdmin($query, $field, $sort, $params);
        $total         = $resultManager['total'];

        return [
            'total'    => $total,
            'rows'     => $resultManager['data'],
            'current'  => $resultManager['current_page'],
            'rowCount' => isset($params['rowCount']) ? $params['rowCount'] : 10,
        ];
    }

    public function getAdminData($params)
    {
        return $this->getAdmin($params);
    }

    /* =========================================================================
     *  LISTA PARA SELECT2 / COMBOS
     * ========================================================================= */

    public function getListData($params)
    {
        $query = DB::table($this->table);

        // texto que verá el usuario en el combo
        $conditionText = "$this->table.name text";

        $selectString = "$this->table.id, $conditionText";

        $select = DB::raw($selectString);
        $query->select($select);

        if (isset($params['filters']["search_value"]["term"])) {
            $like = $params['filters']["search_value"]["term"];
            $query->where($this->table . '.name', 'like', '%' . $like . '%')
                ->orWhere($this->table . '.slug', 'like', '%' . $like . '%');
        }

        $query->where($this->table . '.status', '=', 'ACTIVE');

        $query->limit(10)->orderBy($this->table . '.name', 'asc');
        $result = $query->get()->toArray();

        return $result;
    }

    /* =========================================================================
     *  SAVE (create/update genérico estilo Manager)
     * ========================================================================= */

    public function saveData($params)
    {
        $success        = false;
        $msj            = "";
        $result         = array();
        $attributesPost = $params["attributesPost"];
        $errors         = array();

        DB::beginTransaction();
        try {
            $model       = new WhatsappSections();
            $createUpdate = true;

            if (isset($attributesPost[$this->modelName]["id"])
                && $attributesPost[$this->modelName]["id"] != "null"
                && $attributesPost[$this->modelName]["id"] != "-1") {

                $model       = WhatsappSections::find($attributesPost[$this->modelName]['id']);
                $createUpdate = false;
            }

            $postData   = $attributesPost[$this->modelName];
            $attributes = $model->getValuesByPost($postData, $createUpdate);
            $model->attributes = $attributes;

            $validateResult = $model->validate();
            $success        = $validateResult["success"];

            if ($success) {
                $model->fill($attributes);
                $model->save();
            } else {
                $success = false;
                $msj     = "Problemas al guardar.";
                $errors  = $validateResult["errors"];
            }

            if (!$success) {
                DB::rollBack();
            } else {
                DB::commit();
            }

            $result = [
                "errors"  => $errors,
                "msj"     => $msj,
                "success" => $success,
            ];

            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            $msj = $e->getMessage();
            return [
                "success" => false,
                "msj"     => $msj,
                "errors"  => $errors
            ];
        }
    }
}
