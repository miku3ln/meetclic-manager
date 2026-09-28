<?php

namespace App\Models\Cash;

use App\Models\Exception;
use App\Models\ModelManager;
use Auth;
use Illuminate\Support\Facades\DB;


class CashByTransactionManagement extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'cash_by_transaction_management';

    protected $fillable = array(
        'created_at',//*
        'update_at',
        'state',//*
        'types_payments_id',//*
        'business_by_cash_id',//*
        'entidad_data_id'//*

    );
    protected $attributesData = [
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'update_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'types_payments_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'business_by_cash_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'entidad_data_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'created_at';

    public static function getRulesModel()
    {
        $rules = ["created_at" => "required",
            "state" => "required",
            "types_payments_id" => "required|numeric",
            "business_by_cash_id" => "required|numeric",
            "entidad_data_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.created_at,$this->table.update_at,$this->table.state,$this->table.types_payments_id,$this->table.business_by_cash_id,$this->table.entidad_data_id";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.update_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.types_payments_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.business_by_cash_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.entidad_data_id', 'like', '%' . $likeSet . '%');
            });;

        }

        $recordsTotal = $query->get()->count();
        $pages = 1;
        $total = $recordsTotal; // total items in array
// sort
        $query->orderBy($field, $sort);
// Pagination: $perpage 0; get all data
        if ($perpage > 0) {
            $pages = ceil($total / $perpage); // calculate total pages
            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            $query->offset((int)$offset);
            $query->limit((int)$perpage);
        }
        $current_page = isset($params['current']) ? (int)$params['current'] : 0;
        $data = $query->get()->toArray();

        $result['total'] = $total;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $limit = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $result['rowCount'] = $limit;

        return $result;
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
            $modelName = 'CashByTransactionManagement';
            $model = new CashByTransactionManagement();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = CashByTransactionManagement::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $cashByTransactionManagementData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $cashByTransactionManagementData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  CashByTransactionManagement.";
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
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.update_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.types_payments_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.business_by_cash_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.entidad_data_id', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }
    public function registerTransactionManagement($params)
    {
        $errors = [];

        try {

            $data = [
                'created_at' => now(),
                'state' => self::STATE_ACTIVE,
                'types_payments_id' => $params['types_payments_id'] ?? null,
                'business_by_cash_id' => $params['business_by_cash_id'] ?? null,
                'entidad_data_id' => $params['entidad_data_id'] ?? null,
            ];

            /*
             * =====================================================
             * VALIDAR
             * =====================================================
             */
            $paramsValidate = [
                'modelAttributes' => $data,
                'rules' => self::getRulesModel(),
            ];

            $validateResult =
                $this->validateModel($paramsValidate);

            if (!$validateResult['success']) {

                return [
                    'success' => false,
                    'message' =>
                        'Problemas al validar CashByTransactionManagement.',
                    'data' => [],
                    'errors' =>
                        $validateResult['errors']
                ];
            }

            /*
             * =====================================================
             * GUARDAR
             * =====================================================
             */
            $model =
                new CashByTransactionManagement();

            $model->fill($data);

            if (!$model->save()) {

                return [
                    'success' => false,
                    'message' =>
                        'Problemas al guardar CashByTransactionManagement.',
                    'data' => [],
                    'errors' => []
                ];
            }

            return [
                'success' => true,
                'message' =>
                    'CashByTransactionManagement registrado correctamente.',
                'data' => $model,
                'errors' => []
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
                'errors' => [
                    'exception' => $e->getMessage()
                ]
            ];
        }
    }
    /**
     * ============================================================
     * GET PAYMENT SUMMARY
     * ============================================================
     *
     * Retorna directamente:
     *
     * [
     *     'total' => 0,
     *     'cash_total' => 0,
     *     'items' => [...]
     * ]
     */
    public function getPaymentSummary(
        int $businessByCashId,
        int $cashSessionId
    ) {
        $payments = DB::table(
            'cash_by_transaction_management as cbtm'
        )
            ->join(
                'cash_by_movement as cbm',
                'cbm.id',
                '=',
                'cbtm.entidad_data_id'
            )
            ->join(
                'types_payments as tp',
                'tp.id',
                '=',
                'cbtm.types_payments_id'
            )
            ->where(
                'cbtm.business_by_cash_id',
                $businessByCashId
            )
            ->where(
                'cbtm.state',
                self::STATE_ACTIVE
            )
            ->where(
                'cbm.cash_session_id',
                $cashSessionId
            )
            ->select(
                'cbtm.types_payments_id',
                'tp.value',

                DB::raw(
                    'COUNT(cbtm.id) as payment_count'
                ),

                DB::raw(
                    'SUM(cbm.rode) as amount'
                )
            )
            ->groupBy(
                'cbtm.types_payments_id',
                'tp.value'
            )
            ->get();

        return $this->mapPaymentSummary(
            $payments
        );
    }


    /**
     * ============================================================
     * MAP PAYMENT SUMMARY
     * ============================================================
     *
     * Convierte la consulta al formato requerido por el cierre
     * de caja.
     */
    private function mapPaymentSummary(
        $payments
    ): array {

        $items = [];

        $total = 0.0;
        $cashTotal = 0.0;

        foreach ($payments as $payment) {

            /*
             * ========================================================
             * PAYMENT TYPE
             * ========================================================
             */
            $typesPaymentsId =
                (int)(
                    $payment->types_payments_id ?? 0
                );

            $name =
                trim(
                    (string)(
                        $payment->value ?? ''
                    )
                );

            $count =
                (int)(
                    $payment->payment_count ?? 0
                );

            /*
             * ========================================================
             * AMOUNT
             * ========================================================
             *
             * IMPORTANTE:
             *
             * Actualmente cash_by_transaction_management
             * no tiene amount.
             *
             * Cuando integremos entidad_data_id con la tabla
             * correspondiente, este valor vendrá desde la consulta.
             */
            $amount =
                (float)(
                    $payment->amount ?? 0
                );

            /*
             * ========================================================
             * AFFECTS CASH
             * ========================================================
             */
            $affectsCash =
                $typesPaymentsId==1;

            /*
             * ========================================================
             * ITEM
             * ========================================================
             */
            $items[] = [

                'types_payments_id' =>
                    $typesPaymentsId,

                'name' =>
                    $name,

                'count' =>
                    $count,

                'amount' =>
                    $amount,

                'affects_cash' =>
                    $affectsCash
            ];

            /*
             * ========================================================
             * TOTAL PAYMENTS
             * ========================================================
             */
            $total += $amount;

            /*
             * ========================================================
             * CASH TOTAL
             * ========================================================
             */
            if ($affectsCash) {
                $cashTotal += $amount;
            }
        }

        /*
         * ============================================================
         * RESULT
         * ============================================================
         */
        return [

            'total' =>
                (float)$total,

            'cash_total' =>
                (float)$cashTotal,

            'items' =>
                $items
        ];
    }
}
