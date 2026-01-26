<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Database\Query\Builder;

class AccountGamificationByMovement extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'account_gamification_by_movement';

    const AMOUNT_BEE_REGISTER = 1500;
    const AMOUNT_QUEEN_REGISTER = 150;
    const BUSINESS_MAIN_ID = 1;
    const USER_ID_MAIN = 1;
    const TYPE_MONEY_BEE = 0;
    const TYPE_MONEY_QUEEN = 1;
    const DESCRIPTION_REGISTER = 'Unirse a la comunidad Tukuykuna.';
    const REGISTER_INPUT = 1;
    const TYPE_CASH_CHECK_DEPOSIT = 0;
    const TYPE_COLLECTION_OF_CARD_COUPONS = 1;
    const TYPE_NEGOTIATED_CHECKS = 1;

    const REGISTER_OUTPUT = 0;
    const TYPE_CASH_WITHDRAWAL = 1;
    const TYPE_BANKING_EXPENSES = 1;
    protected $fillable = array(
        'created_at',
        'updated_at',
        'deleted_at',
        'account_gamification_id',//*
        'amount',//*
        'type',//*
        'input_movement',//*
        'description',//*
        'user_transaction_id',//*
        'type_money',//*
        'gamification_by_process_id'//*

    );
    protected $attributesData = [
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'deleted_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'account_gamification_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'amount', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'input_movement', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'user_transaction_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_money', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'gamification_by_process_id', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],

    ];
    public $timestamps = false;

    protected $field_main = 'description';

    public static function getRulesModel()
    {
        $rules = ["account_gamification_id" => "required|numeric",
            "amount" => "required|numeric",
            "type" => "required|numeric",
            "input_movement" => "required|numeric",
            "description" => "required",
            "user_transaction_id" => "required|numeric",
            "type_money" => "required|numeric",
            "gamification_by_process_id" => "required|numeric",

        ];
        return $rules;
    }


    /*MANAGER MAINS*/
    public function accountGamificationByMovementAdmin($params)
    {
        $resultData = $this->getAdmin($params);

        return $resultData;
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
            $modelName = 'AccountGamificationByMovement';
            $model = new AccountGamificationByMovement();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = AccountGamificationByMovement::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $accountGamificationByMovementData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $accountGamificationByMovementData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  AccountGamificationByMovement.";
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
                "success" => $success
            ];


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );
            return ($result);
        }

    }

    public function getListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('account_gamification', 'account_gamification.id', '=', $this->table . '.account_gamification_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.updated_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.deleted_at', 'like', '%' . $likeSet . '%');
                $query->orWhere("account_gamification.created_at", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.amount', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.input_movement', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_transaction_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_money', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }


    public function getAdmin(array $params): array
    {
        $userId = (int)Auth::id();

        [$page, $perPage] = $this->resolvePagination($params);
        [$sortField, $sortDir] = $this->resolveSort($params); // default: m.created_at desc

        $baseQuery = $this->buildMovementQuery($userId, $params);

        // Total rows (sin paginación)
        $totalRows = (clone $baseQuery)->count('m.id');

        // Total balance (IN - OUT) aplicando los mismos filtros
       // $totalBalance = $this->calculateBalance($userId, $params);

        // Data paginada
        $rows = $this->applySortAndPagination($baseQuery, $sortField, $sortDir, $page, $perPage)
            ->get()
            ->toArray();

        return [
            'total' => $totalRows,
            'rows' => $rows,
            'current' => $page,
            'rowCount' => $perPage,
           // 'totalBalance' => (float)$totalBalance,
        ];
    }

    /**
     * Query base del log: account_gamification_by_movement (m)
     * filtrado por wallet (w.user_id obligatorio y w.business_id opcional)
     */
    private function buildMovementQuery(int $userId, array $params): Builder
    {
        $query = DB::table('account_gamification_by_movement as m')
            ->join('account_gamification as w', 'w.id', '=', 'm.wallet_destination_id')
            ->join('account_gamification_movement_type as mt', 'mt.id', '=', 'm.movement_type_id')
            ->leftJoin('gamification_by_process as gp', 'gp.id', '=', 'm.gamification_by_process_id')
            ->join('account_gamification as ag', 'ag.id', '=', 'gp.gamification_id')
            ->join('business as b', 'b.id', '=', 'ag.business_id')

            ->whereNull('m.deleted_at')
            ->where('w.user_id', '=', $userId);

        // filtro opcional por business_id (en la wallet)
        if (!empty($params['business_id'])) {
            $query->where('w.business_id', '=', (int)$params['business_id']);
        }

        // filtro opcional por type_money
        if (!empty($params['type_money'])) {
            $query->where('w.type_money', '=', (int)$params['type_money']);
        }

        // filtro opcional por movement_type_id
        if (!empty($params['movement_type_id'])) {
            $query->where('m.movement_type_id', '=', (int)$params['movement_type_id']);
        }

        // validar direction_default vs direction
        $query->where('mt.state', '=', 'ACTIVE')
            ->where(function (Builder $q) {
                $q->where('mt.direction_default', 'NA')
                    ->orWhereColumn('mt.direction_default', 'm.direction');
            });

        // search
        $this->applySearch($query, $params);

        // select (limpio)
        $query->select([
            'm.id',
            'm.created_at',
            'm.updated_at',
            'm.deleted_at',

            'm.wallet_destination_id',
            'm.wallet_origin_id',

            'm.performed_by',
            'm.performed_by_id',
            'm.reference_code',
            'm.movement_group_id',

            'm.direction',
            'm.business_context_id',
            'm.created_source',

            'm.amount',
            'm.movement_type_id',
            'mt.code as movement_type_code',
            'mt.title as movement_type_title',
            'mt.direction_default',
            'mt.icon_class',


            'm.description',
            'm.expire_at',
            'm.type_money',
            'm.gamification_by_process_id',
            'w.id as wallet_id',
            'w.user_id',
            'w.business_id',
            'w.state as wallet_state',
            'b.title as business_name',

        ]);

        return $query;
    }

    private function applySearch(Builder $query, array $params): void
    {
        $phrase = $params['searchPhrase'] ?? null;
        if ($phrase === null || trim((string)$phrase) === '') return;

        $like = '%' . trim((string)$phrase) . '%';

        $query->where(function (Builder $q) use ($like) {
            $q->orWhere('m.description', 'like', $like);
        });
    }

    /**
     * Balance total del usuario (y opcionalmente por business_id) sumando IN y restando OUT.
     * Usa las MISMAS reglas de validación del catálogo.
     */
    private function calculateBalance(int $userId, array $params): float
    {
        $query = DB::table('account_gamification_by_movement as m')
            ->join('account_gamification as w', 'w.id', '=', 'm.wallet_destination_id')
            ->join('account_gamification_movement_type as mt', 'mt.id', '=', 'm.movement_type_id')
            ->whereNull('m.deleted_at')
            ->where('w.user_id', '=', $userId)
            ->where('mt.state', '=', 'ACTIVE')
            ->where(function (Builder $q) {
                $q->where('mt.direction_default', 'NA')
                    ->orWhereColumn('mt.direction_default', 'm.direction');
            });

        if (!empty($params['business_id'])) {
            $query->where('w.business_id', '=', (int)$params['business_id']);
        }
        if (!empty($params['type_money'])) {
            $query->where('w.type_money', '=', (int)$params['type_money']);
        }
        if (!empty($params['movement_type_id'])) {
            $query->where('m.movement_type_id', '=', (int)$params['movement_type_id']);
        }

        $balance = $query->selectRaw("
        COALESCE(SUM(
            CASE
                WHEN m.direction = 'IN'  THEN m.amount
                WHEN m.direction = 'OUT' THEN -m.amount
                ELSE 0
            END
        ), 0) as balance
    ")->value('balance');

        return (float)$balance;
    }

    private function resolvePagination(array $params): array
    {
        $page = isset($params['current']) ? (int)$params['current'] : 1;
        $perPage = isset($params['rowCount']) ? (int)$params['rowCount'] : 10;

        return [$page, $perPage];
    }

    private function resolveSort(array $params): array
    {
        // default: creación del movimiento
        $defaultField = 'm.created_at';
        $defaultDir = 'desc';

        if (empty($params['sort']) || !is_array($params['sort'])) {
            return [$defaultField, $defaultDir];
        }

        $requestedField = array_key_first($params['sort']);
        $requestedDir = strtolower((string)($params['sort'][$requestedField] ?? $defaultDir));
        $dir = $requestedDir === 'asc' ? 'asc' : 'desc';

        // whitelist para evitar ordenar por columnas no permitidas
        $allowed = [
            'm.created_at' => 'm.created_at',
            'm.amount' => 'm.amount',
            'm.id' => 'm.id',
            'm.direction' => 'm.direction',
            'mt.code' => 'mt.code',
            'w.business_id' => 'w.business_id',
        ];

        return [$allowed[$requestedField] ?? $defaultField, $dir];
    }

    private function applySortAndPagination(
        Builder $query,
        string  $sortField,
        string  $sortDir,
        int     $page,
        int     $perPage
    ): Builder
    {
        $query->orderBy($sortField, $sortDir);

        if ($perPage <= 0) return $query;

        $page = max($page, 1);
        $offset = ($page - 1) * $perPage;

        return $query->offset($offset)->limit($perPage);
    }
}
