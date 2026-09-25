<?php

namespace App\Models\Cash;

use App\Core\Traits\RepositoryTrait;
use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class CashMovement extends ModelManager
{
    use RepositoryTrait;
    const MOVEMENT_INPUT = 0;
    const MOVEMENT_OUTPUT = 1;

    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';

    protected $table = 'cash_by_movement';

    protected $fillable = [
        'user_id',
        'state',
        'cash_id',
        'movement_type',
        'cash_reason_id',
        'accounting_account_id',
        'details',
        'rode',
        'date_current',
        'transaction_type',
        'entity_type',
        'entity_id',
        'created_at',
        'update_at',
        'available_balance'
    ];

    public $timestamps = false;

    /**
     * Obtener movimientos producidos durante una sesión.
     */
    public function getBySession(
        $cashId,
        $userId,
        $openingDate,
        $closingDate = null
    ) {
        $query = self::where('cash_id', $cashId)
            ->where('user_id', $userId)
            ->where('state', self::STATE_ACTIVE)
            ->where('date_current', '>=', $openingDate);

        if ($closingDate) {
            $query->where(
                'date_current',
                '<=',
                $closingDate
            );
        }

        return $query
            ->orderBy('date_current')
            ->get();
    }

    /**
     * Totales de ingresos y egresos.
     */
    public function getTotalsBySession(
        $cashId,
        $userId,
        $openingDate,
        $closingDate = null
    ) {
        $query = DB::table($this->table)
            ->where('cash_id', $cashId)
            ->where('user_id', $userId)
            ->where('state', self::STATE_ACTIVE)
            ->where('date_current', '>=', $openingDate);

        if ($closingDate) {
            $query->where(
                'date_current',
                '<=',
                $closingDate
            );
        }

        return $query
            ->selectRaw(
                '
                COALESCE(SUM(
                    CASE
                        WHEN movement_type = 0
                        THEN rode
                        ELSE 0
                    END
                ), 0) as total_input,

                COALESCE(SUM(
                    CASE
                        WHEN movement_type = 1
                        THEN rode
                        ELSE 0
                    END
                ), 0) as total_output
                '
            )
            ->first();
    }
    public function getSessionMovementSummary(
        $cashSessionId
    ) {
        return DB::table($this->table)
            ->where(
                'cash_session_id',
                $cashSessionId
            )
            ->where(
                'state',
                self::STATE_ACTIVE
            )
            ->selectRaw('
            COALESCE(
                SUM(
                    CASE
                        WHEN movement_type = ?
                        THEN rode
                        ELSE 0
                    END
                ),
                0
            ) AS total_input,

            COALESCE(
                SUM(
                    CASE
                        WHEN movement_type = ?
                        THEN rode
                        ELSE 0
                    END
                ),
                0
            ) AS total_output,

            COUNT(
                CASE
                    WHEN movement_type = ?
                    THEN 1
                END
            ) AS count_input,

            COUNT(
                CASE
                    WHEN movement_type = ?
                    THEN 1
                END
            ) AS count_output
        ', [
                self::MOVEMENT_INPUT,
                self::MOVEMENT_OUTPUT,
                self::MOVEMENT_INPUT,
                self::MOVEMENT_OUTPUT
            ])
            ->first();
    }

    public function getAdmin($params)
    {
        $tblCashMovement = $this->table;

        /*
         * =====================================================
         * TABLES
         * =====================================================
         */

        $tblCash = 'cash as c';
        $tblCashReason = 'cash_reason as cr';
        $tblCashSession = 'cash_session as cs';
        $tblCashByUser = 'cash_by_user as cbu';
        $tblBusinessByCash = 'business_by_cash as bbc';
        $tblCashByType = 'cash_by_type as cbt';
        $tblCashType = 'cash_type as ct';


        /*
         * =====================================================
         * QUERY
         * =====================================================
         */

        $query = DB::table($tblCashMovement);


        /*
         * =====================================================
         * SELECT
         * =====================================================
         */

        $query->select([

            /*
             * MOVEMENT
             */
            $tblCashMovement . '.id',
            $tblCashMovement . '.user_id',
            $tblCashMovement . '.cash_id',
            $tblCashMovement . '.cash_session_id',
            $tblCashMovement . '.movement_type',
            $tblCashMovement . '.cash_reason_id',
            $tblCashMovement . '.accounting_account_id',
            $tblCashMovement . '.details',
            $tblCashMovement . '.rode',
            $tblCashMovement . '.date_current',
            $tblCashMovement . '.transaction_type',
            $tblCashMovement . '.entity_type',
            $tblCashMovement . '.entity_id',
            $tblCashMovement . '.available_balance',
            $tblCashMovement . '.state',
            $tblCashMovement . '.created_at',
            $tblCashMovement . '.update_at',

            /*
             * CASH
             */
            'c.name as cash_name',
            'c.details as cash_details',

            /*
             * REASON
             */
            'cr.value as cash_reason',
            'cr.description as cash_reason_description',

            /*
             * SESSION
             */
            'cs.id as session_id',
            'cs.cash_by_user_id',
            'cs.opening_amount',
            'cs.opening_date',
            'cs.opening_details',
            'cs.expected_amount',
            'cs.closing_amount',
            'cs.difference_amount',
            'cs.closing_date',
            'cs.closing_details',
            'cs.state as session_state',

            /*
             * ASSIGNMENT
             */
            'cbu.user_id as assigned_user_id',
            'bbc.id as business_by_cash_id',
            'bbc.business_id',

            /*
             * CASH TYPE
             */
            'ct.id as cash_type_id',
            'ct.code as cash_type_code',
            'ct.value as cash_type'
        ]);


        /*
         * =====================================================
         * JOINS
         * =====================================================
         */

        $query->leftJoin(
            'cash as c',
            $tblCashMovement . '.cash_id',
            '=',
            'c.id'
        );

        $query->leftJoin(
            'cash_reason as cr',
            $tblCashMovement . '.cash_reason_id',
            '=',
            'cr.id'
        );

        $query->leftJoin(
            'cash_session as cs',
            $tblCashMovement . '.cash_session_id',
            '=',
            'cs.id'
        );

        /*
         * La sesión conoce exactamente qué asignación
         * cash_by_user generó el movimiento.
         */
        $query->leftJoin(
            'cash_by_user as cbu',
            'cs.cash_by_user_id',
            '=',
            'cbu.id'
        );

        /*
         * Desde la asignación conocemos business_by_cash.
         */
        $query->leftJoin(
            'business_by_cash as bbc',
            'cbu.business_by_cash_id',
            '=',
            'bbc.id'
        );

        /*
         * Tipo de caja.
         */
        $query->leftJoin(
            'cash_by_type as cbt',
            $tblCashMovement . '.cash_id',
            '=',
            'cbt.cash_id'
        );

        $query->leftJoin(
            'cash_type as ct',
            'cbt.cash_type_id',
            '=',
            'ct.id'
        );


        /*
         * =====================================================
         * FILTER: USER
         * =====================================================
         */

        if (
            isset($params['filters']['user_id']) &&
            $params['filters']['user_id'] !== ''
        ) {
            $query->where(
                $tblCashMovement . '.user_id',
                '=',
                $params['filters']['user_id']
            );
        }


        /*
         * =====================================================
         * FILTER: BUSINESS
         * =====================================================
         */

        if (
            isset($params['filters']['business_id']) &&
            $params['filters']['business_id'] !== ''
        ) {
            $query->where(
                'bbc.business_id',
                '=',
                $params['filters']['business_id']
            );
        }


        /*
         * =====================================================
         * FILTER: CASH
         * =====================================================
         */

        if (
            isset($params['filters']['cash_id']) &&
            $params['filters']['cash_id'] !== ''
        ) {
            $query->where(
                $tblCashMovement . '.cash_id',
                '=',
                $params['filters']['cash_id']
            );
        }


        /*
         * =====================================================
         * FILTER: SESSION
         * =====================================================
         */

        if (
            isset($params['filters']['cash_session_id']) &&
            $params['filters']['cash_session_id'] !== ''
        ) {
            $query->where(
                $tblCashMovement . '.cash_session_id',
                '=',
                $params['filters']['cash_session_id']
            );
        }


        /*
         * =====================================================
         * FILTER: MOVEMENT TYPE
         *
         * 0 = INPUT
         * 1 = OUTPUT
         *
         * No usar empty() porque 0 es válido.
         * =====================================================
         */

        if (
            isset($params['filters']['movement_type']) &&
            $params['filters']['movement_type'] !== ''
        ) {
            $query->where(
                $tblCashMovement . '.movement_type',
                '=',
                $params['filters']['movement_type']
            );
        }


        /*
         * =====================================================
         * FILTER: CASH REASON
         * =====================================================
         */

        if (
            isset($params['filters']['cash_reason_id']) &&
            $params['filters']['cash_reason_id'] !== ''
        ) {
            $query->where(
                $tblCashMovement . '.cash_reason_id',
                '=',
                $params['filters']['cash_reason_id']
            );
        }


        /*
         * =====================================================
         * FILTER: STATE
         * =====================================================
         */

        if (
            isset($params['filters']['state']) &&
            $params['filters']['state'] !== ''
        ) {
            $query->where(
                $tblCashMovement . '.state',
                '=',
                $params['filters']['state']
            );
        }


        /*
         * =====================================================
         * FILTER: DATE FROM
         * =====================================================
         */

        if (
            isset($params['filters']['date_from']) &&
            $params['filters']['date_from'] !== ''
        ) {
            $query->where(
                $tblCashMovement . '.date_current',
                '>=',
                $params['filters']['date_from']
            );
        }


        /*
         * =====================================================
         * FILTER: DATE TO
         * =====================================================
         */

        if (
            isset($params['filters']['date_to']) &&
            $params['filters']['date_to'] !== ''
        ) {
            $query->where(
                $tblCashMovement . '.date_current',
                '<=',
                $params['filters']['date_to']
            );
        }


        /*
         * =====================================================
         * ORDER
         * =====================================================
         */

        $params['sortType'] = 'desc';


        /*
         * =====================================================
         * SEARCH
         * =====================================================
         */

        $search =
            $params['searchPhrase'] ?? null;

        $this->applySearch(
            $query,
            $search,
            [
                $tblCashMovement . '.details',
                'cr.value',
                'cr.description',
                'c.name',
                'ct.value',
                'ct.code'
            ]
        );


        /*
         * =====================================================
         * PAGINATION
         * =====================================================
         */

        return $this->paginateQuery(
            $query,
            $params,
            $tblCashMovement . '.id'
        );
    }
    /**
     * Obtener movimientos de una sesión
     * consolidados por tipo y motivo.
     */
    public function getSessionMovementSummaryByReason(
        $cashSessionId
    ) {
        return DB::table($this->table . ' as cbm')

            ->join(
                'cash_reason as cr',
                'cr.id',
                '=',
                'cbm.cash_reason_id'
            )

            ->where(
                'cbm.cash_session_id',
                $cashSessionId
            )

            ->where(
                'cbm.state',
                self::STATE_ACTIVE
            )

            ->groupBy(
                'cbm.movement_type',
                'cbm.cash_reason_id',
                'cr.value'
            )

            ->select([
                'cbm.movement_type',
                'cbm.cash_reason_id',
                'cr.value as cash_reason',

                DB::raw(
                    'COUNT(cbm.id) AS movement_count'
                ),

                DB::raw(
                    'COALESCE(SUM(cbm.rode), 0) AS total'
                )
            ])

            ->orderBy(
                'cbm.movement_type',
                'asc'
            )

            ->orderBy(
                'cbm.cash_reason_id',
                'asc'
            )

            ->get();
    }
    /**
     * Obtener detalle de movimientos de una sesión
     * para un motivo específico.
     */
    public function getSessionMovementsByReason(
        $cashSessionId,
        $cashReasonId
    ) {
        return DB::table($this->table . ' as cbm')

            ->leftJoin(
                'cash_reason as cr',
                'cr.id',
                '=',
                'cbm.cash_reason_id'
            )

            ->where(
                'cbm.cash_session_id',
                $cashSessionId
            )

            ->where(
                'cbm.cash_reason_id',
                $cashReasonId
            )

            ->where(
                'cbm.state',
                self::STATE_ACTIVE
            )

            ->select([
                'cbm.id',
                'cbm.cash_session_id',
                'cbm.movement_type',
                'cbm.cash_reason_id',

                'cr.value as cash_reason',

                'cbm.rode',
                'cbm.details',
                'cbm.date_current',

                'cbm.transaction_type',
                'cbm.entity_type',
                'cbm.entity_id',

                'cbm.available_balance'
            ])

            ->orderBy(
                'cbm.date_current',
                'desc'
            )

            ->get();
    }
    /**
     * Obtener detalle de movimientos por motivo.
     */
    public function getReportMovementsByReason(
        $cashByUserId,
        $cashReasonId,
        $dateFrom,
        $dateTo
    ) {
        return DB::table($this->table . ' as cbm')

            ->join(
                'cash_session as cs',
                'cs.id',
                '=',
                'cbm.cash_session_id'
            )

            ->leftJoin(
                'cash_reason as cr',
                'cr.id',
                '=',
                'cbm.cash_reason_id'
            )

            ->where(
                'cs.cash_by_user_id',
                $cashByUserId
            )

            ->where(
                'cbm.cash_reason_id',
                $cashReasonId
            )

            ->where(
                'cbm.state',
                self::STATE_ACTIVE
            )

            ->whereBetween(
                'cbm.date_current',
                [
                    $dateFrom,
                    $dateTo
                ]
            )

            ->select([
                'cbm.id',
                'cbm.cash_session_id',
                'cbm.movement_type',
                'cbm.cash_reason_id',
                'cr.value as cash_reason',
                'cbm.rode',
                'cbm.details',
                'cbm.date_current',
                'cbm.transaction_type',
                'cbm.entity_type',
                'cbm.entity_id',
                'cbm.available_balance'
            ])

            ->orderBy(
                'cbm.date_current',
                'desc'
            )

            ->get();
    }
}
