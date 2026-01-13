<?php

namespace App\Models\AccountGamification;

use App\Models\Exception;
use App\Models\ModelManager;

use Auth;
use Illuminate\Support\Facades\DB;
class AccountGamificationMovementSourceCatalog
{
    const SOURCE_TASK       = 'TASK';
    const SOURCE_TRANSFER   = 'TRANSFER';
    const SOURCE_DEPOSIT    = 'DEPOSIT';
    const SOURCE_REDEEM     = 'REDEEM';
    const SOURCE_ADJUSTMENT = 'ADJUSTMENT';
}
class AccountGamificationPerformedByCatalog
{
    const PERFORMED_BY_USER    = 'USER';
    const PERFORMED_BY_BUSINESS= 'BUSINESS';
    const PERFORMED_BY_SYSTEM  = 'SYSTEM';
    const PERFORMED_BY_BEEHIVE = 'BEEHIVE';
}
class AccountGamificationMovementType extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';

    public $timestamps = false;

    protected $table = 'account_gamification_movement_type';
    protected $field_main = 'title';

    /* =========================
       CATEGORY
    ========================= */
    const CATEGORY_BANK = 'BANK';
    const CATEGORY_MEETCLIC = 'MEETCLIC';

    /* =========================
       DIRECTION DEFAULT
    ========================= */
    const DIRECTION_IN = 'IN';
    const DIRECTION_OUT = 'OUT';
    const DIRECTION_NA = 'NA';

    /* =========================
       MOVEMENT TYPE IDS (DB IDs)
       (IDs sugeridos según el insert que te pasé)
    ========================= */
    // Default / fallback
    const TYPE_DEFAULT_ID = 1;
    const TYPE_DEFAULT_CODE = 'DEFAULT';

    /* ---------- BANK (Banco / contable) ---------- */
    const TYPE_DEPOSIT_ID = 2;           // DE
    const TYPE_DEPOSIT_CODE = 'DE';

    const TYPE_WITHDRAWAL_ID = 3;        // EX
    const TYPE_WITHDRAWAL_CODE = 'EX';

    const TYPE_FEE_ID = 4;               // GB
    const TYPE_FEE_CODE = 'GB';

    const TYPE_COUPON_CREDIT_ID = 5;     // CC
    const TYPE_COUPON_CREDIT_CODE = 'CC';

    const TYPE_ACCREDITATION_ID = 6;     // NE
    const TYPE_ACCREDITATION_CODE = 'NE';

    const TYPE_TRANSFER_IN_ID = 7;       // TRF_IN
    const TYPE_TRANSFER_IN_CODE = 'TRF_IN';

    const TYPE_TRANSFER_OUT_ID = 8;      // TRF_OUT
    const TYPE_TRANSFER_OUT_CODE = 'TRF_OUT';

    const TYPE_ADJUSTMENT_IN_ID = 9;     // ADJ_IN
    const TYPE_ADJUSTMENT_IN_CODE = 'ADJ_IN';

    const TYPE_ADJUSTMENT_OUT_ID = 10;   // ADJ_OUT
    const TYPE_ADJUSTMENT_OUT_CODE = 'ADJ_OUT';

    const TYPE_REVERSAL_ID = 11;         // REVERSAL
    const TYPE_REVERSAL_CODE = 'REVERSAL';

    /* ---------- MEETCLIC (Genéricos para tareas) ---------- */
    const TYPE_TASK_REWARD_ID = 12;     // TASK_REWARD
    const TYPE_TASK_REWARD_CODE = 'TASK_REWARD';

    const TYPE_TASK_QR_ID = 13;         // TASK_QR
    const TYPE_TASK_QR_CODE = 'TASK_QR';

    const TYPE_TASK_VIEW_ID = 14;       // TASK_VIEW
    const TYPE_TASK_VIEW_CODE = 'TASK_VIEW';

    const TYPE_TASK_SHARE_ID = 15;      // TASK_SHARE
    const TYPE_TASK_SHARE_CODE = 'TASK_SHARE';

    const TYPE_TASK_REVIEW_ID = 16;     // TASK_REVIEW
    const TYPE_TASK_REVIEW_CODE = 'TASK_REVIEW';

    const TYPE_TASK_SHOP_ID = 17;       // TASK_SHOP
    const TYPE_TASK_SHOP_CODE = 'TASK_SHOP';

    const TYPE_REDEEM_ID = 18;          // REDEEM
    const TYPE_REDEEM_CODE = 'REDEEM';
    protected $fillable = array(
        'code',             //*
        'category',         //*
        'direction_default',//*
        'title',            //*
        'description',      //*
        'icon_class',
        'label_class',
        'badge_class',
        'state',            //*
        'sort_order'
    );

    protected $attributesData = [
        ['column' => 'code', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'category', 'type' => 'string', 'defaultValue' => 'BANK', 'required' => 'true'],
        ['column' => 'direction_default', 'type' => 'string', 'defaultValue' => 'NA', 'required' => 'true'],

        ['column' => 'title', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],

        ['column' => 'icon_class', 'type' => 'string', 'defaultValue' => 'fa fa-exchange', 'required' => 'false'],
        ['column' => 'label_class', 'type' => 'string', 'defaultValue' => 'label label-default', 'required' => 'true'],
        ['column' => 'badge_class', 'type' => 'string', 'defaultValue' => 'badge', 'required' => 'true'],

        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'sort_order', 'type' => 'integer', 'defaultValue' => 0, 'required' => 'true'],
    ];
    public static function resolveTypeIdByProcess(array $processRow): int
    {
        // $processRow: gamification_by_process row (tracking_click_type_id, gamification_type_activity_id, execution_channel, unique_code...)
        $unique = strtoupper($processRow['unique_code'] ?? '');

        // 1) Por unique_code (lo más estable si lo controlas)
        if (str_contains($unique, 'QR')) {
            return self::TYPE_TASK_QR_ID;
        }
        if (str_contains($unique, 'SHARE')) {
            return self::TYPE_TASK_SHARE_ID;
        }
        if (str_contains($unique, 'SHOP')) {
            return self::TYPE_TASK_SHOP_ID;
        }
        if (str_contains($unique, 'RATE') || str_contains($unique, 'SUGGESTION') || str_contains($unique, 'REVIEW')) {
            return self::TYPE_TASK_REVIEW_ID;
        }
        if (str_contains($unique, 'VIEW') || str_contains($unique, 'CLICK')) {
            return self::TYPE_TASK_VIEW_ID;
        }
        if (str_contains($unique, 'REDEEM')) {
            return self::TYPE_REDEEM_ID;
        }

        // 2) Fallback por tracking_click_type_id (si tienes consistencia)
        $trackingType = (int)($processRow['tracking_click_type_id'] ?? 0);
        // 6 = qr_scan
        if ($trackingType === 6) return self::TYPE_TASK_QR_ID;
        // 13 = whatsapp_click (share)
        if ($trackingType === 13) return self::TYPE_TASK_SHARE_ID;
        // 2 = click / 3 = view
        if ($trackingType === 2 || $trackingType === 3) return self::TYPE_TASK_VIEW_ID;

        // 3) fallback final
        return self::TYPE_TASK_REWARD_ID;
    }

    public static function getRulesModel()
    {
        return [
            "code" => "required|max:20",
            "category" => "required|in:BANK,MEETCLIC",
            "direction_default" => "required|in:IN,OUT,NA",

            "title" => "required|max:80",
            "description" => "required|max:255",

            "icon_class" => "max:120",
            "label_class" => "required|max:40",
            "badge_class" => "required|max:40",

            "state" => "required|in:ACTIVE,INACTIVE",
            "sort_order" => "required|numeric"
        ];
    }

    /* =========================
       ADMIN GRID
    ========================= */

    public function getAdminData($params)
    {
        $sort = 'asc';
        $field = $this->field_main;

        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $fieldKeys = array_keys($params['sort']);
            $field = $fieldKeys[0];
            $sort = $params['sort'][$field];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 1;
        $perpage = isset($params['rowCount']) ? (int)$params['rowCount'] : 10;

        $selectString = "$this->table.id,
            $this->table.code,
            $this->table.category,
            $this->table.direction_default,
            $this->table.title,
            $this->table.description,
            $this->table.icon_class,
            $this->table.label_class,
            $this->table.badge_class,
            $this->table.state,
            $this->table.sort_order";

        $query->select(DB::raw($selectString));

        // Filters
        if (isset($params['filters']['category']) && $params['filters']['category'] != null && $params['filters']['category'] != '') {
            $query->where($this->table . '.category', '=', $params['filters']['category']);
        }
        if (isset($params['filters']['state']) && $params['filters']['state'] != null && $params['filters']['state'] != '') {
            $query->where($this->table . '.state', '=', $params['filters']['state']);
        }

        // Search
        if (isset($params['searchPhrase']) && $params['searchPhrase'] != null) {
            $likeSet = $params['searchPhrase'];
            $query->where(function ($q) use ($likeSet) {
                $q->where($this->table . '.code', 'like', '%' . $likeSet . '%')
                    ->orWhere($this->table . '.title', 'like', '%' . $likeSet . '%')
                    ->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%')
                    ->orWhere($this->table . '.category', 'like', '%' . $likeSet . '%');
            });
        }

        $recordsTotal = $query->count();
        $total = $recordsTotal;

        $query->orderBy($field, $sort);

        if ($perpage > 0) {
            $pages = (int)ceil($total / $perpage);
            $page = max($page, 1);
            $page = min($page, max($pages, 1));
            $offset = ($page - 1) * $perpage;
            $query->offset((int)$offset)->limit((int)$perpage);
        }

        $data = $query->get()->toArray();

        return [
            'total' => $total,
            'rows' => $data,
            'current' => $page,
            'rowCount' => $perpage
        ];
    }

    public function getAdmin($params)
    {
        $result = $this->getAdminData($params);

        foreach ($result['rows'] as $key => $row) {
            $result['rows'][$key] = (array)$row;
        }
        return $result;
    }

    /* =========================
       SAVE (CREATE/UPDATE)
    ========================= */

    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $errors = array();

        DB::beginTransaction();
        try {
            $attributesPost = $params["attributesPost"];

            $createUpdate = true;
            $model = new AccountGamificationMovementType();

            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = AccountGamificationMovementType::find($attributesPost['id']);
                $createUpdate = false;
                if (!$model) {
                    throw new \Exception("Registro no encontrado.");
                }
            }

            $attributesSet = $this->getValuesModel([
                'fillAble' => $this->fillable,
                'haystack' => $attributesPost,
                'attributesData' => $this->attributesData
            ]);

            $validateResult = $this->validateModel([
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),
            ]);

            $success = $validateResult["success"];
            if (!$success) {
                $errors = $validateResult["errors"];
                $msj = "Problemas al guardar el tipo de movimiento.";
                DB::rollBack();
                return ["errors" => $errors, "msj" => $msj, "success" => false];
            }

            // Normalizaciones mínimas
            $attributesSet['code'] = strtoupper(trim($attributesSet['code']));
            $attributesSet['category'] = strtoupper(trim($attributesSet['category']));
            $attributesSet['direction_default'] = strtoupper(trim($attributesSet['direction_default']));
            $attributesSet['state'] = strtoupper(trim($attributesSet['state']));

            $model->fill($attributesSet);
            $success = $model->save();

            if (!$success) {
                DB::rollBack();
                return ["errors" => [], "msj" => "No se pudo guardar.", "success" => false];
            }

            DB::commit();
            return ["errors" => [], "msj" => "", "success" => true];

        } catch (Exception $e) {
            DB::rollBack();
            return ["success" => false, "msj" => $e->getMessage(), "errors" => $errors];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["success" => false, "msj" => $e->getMessage(), "errors" => $errors];
        }
    }

    /* =========================
       SELECT2 LIST
    ========================= */

    public function getListSelect2($params)
    {
        $field = $this->table . '.' . $this->field_main;
        $query = DB::table($this->table);

        $textValue = $this->table . '.' . $this->field_main;
        $selectString = "$this->table.id, $textValue as text";
        $query->select(DB::raw($selectString));

        // filtros opcionales
        if (isset($params["filters"]['category']) && $params["filters"]['category'] != null && $params["filters"]['category'] != '') {
            $query->where($this->table . '.category', '=', $params["filters"]['category']);
        }
        if (isset($params["filters"]['state']) && $params["filters"]['state'] != null && $params["filters"]['state'] != '') {
            $query->where($this->table . '.state', '=', $params["filters"]['state']);
        } else {
            $query->where($this->table . '.state', '=', self::STATE_ACTIVE);
        }

        if (isset($params["filters"]['search_value']["term"])) {
            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($q) use ($likeSet) {
                $q->where($this->table . '.code', 'like', '%' . $likeSet . '%')
                    ->orWhere($this->table . '.title', 'like', '%' . $likeSet . '%')
                    ->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            });
        }

        $query->limit(10)->orderBy($field, 'asc');
        return $query->get()->toArray();
    }
}
