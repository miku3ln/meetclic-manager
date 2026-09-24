<?php

namespace App\Models\Cash;

use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class CashSession extends ModelManager
{
    const STATE_OPEN = 'OPEN';
    const STATE_CLOSED = 'CLOSED';

    protected $table = 'cash_session';

    protected $fillable = [
        'cash_by_user_id',
        'opening_amount',
        'opening_date',
        'opening_details',
        'expected_amount',
        'closing_amount',
        'difference_amount',
        'closing_date',
        'closing_details',
        'state',
        'created_at',
        'update_at'
    ];

    protected $attributesData = [
        [
            'column' => 'cash_by_user_id',
            'type' => 'integer',
            'defaultValue' => 0,
            'required' => 'true'
        ],
        [
            'column' => 'opening_amount',
            'type' => 'double',
            'defaultValue' => 0,
            'required' => 'true'
        ],
        [
            'column' => 'opening_details',
            'type' => 'string',
            'defaultValue' => '',
            'required' => 'false'
        ]
    ];

    public $timestamps = false;

    public static function getOpenRules()
    {
        return [
            'cash_by_user_id' => 'required|numeric',
            'opening_amount' => 'required|numeric|min:0',
            'opening_details' => 'nullable|string'
        ];
    }

    public static function getCloseRules()
    {
        return [
            'closing_amount' => 'required|numeric|min:0',
            'closing_details' => 'nullable|string'
        ];
    }
    public function getOpenByCashUser(
        $cashByUserId,
        $startDate,
        $endDate
    ) {
        return self::where(
            'cash_by_user_id',
            $cashByUserId
        )
            ->where(
                'state',
                self::STATE_OPEN
            )
            ->whereBetween(
                'opening_date',
                [
                    $startDate,
                    $endDate
                ]
            )
            ->orderBy(
                'opening_date',
                'desc'
            )
            ->first();
    }


    /**
     * Busca cualquier sesión abierta del usuario,
     * independientemente de la fecha de apertura.
     */
    public function getAnyOpenByCashUser(
        $cashByUserId
    ) {
        return self::where(
            'cash_by_user_id',
            $cashByUserId
        )
            ->where(
                'state',
                self::STATE_OPEN
            )
            ->orderBy(
                'opening_date',
                'desc'
            )
            ->first();
    }
    public function hasOpenSession($cashByUserId)
    {
        return self::where(
            'cash_by_user_id',
            $cashByUserId
        )
            ->where(
                'state',
                self::STATE_OPEN
            )
            ->exists();
    }

    /**
     * Abrir caja.
     */
    public function openSession($params)
    {
        DB::beginTransaction();

        try {

            $cashByUserId = $params['cash_by_user_id'];
            $openingAmount = $params['opening_amount'];
            $openingDetails =
                $params['opening_details'] ?? null;

            /*
             * No permitir dos sesiones abiertas.
             */
            if ($this->hasOpenSession($cashByUserId)) {
                throw new \Exception(
                    'El usuario ya tiene una caja abierta.'
                );
            }

            /*
             * Verificar asignación.
             */
            $cashByUser = CashByUser::find($cashByUserId);

            if (!$cashByUser) {
                throw new \Exception(
                    'La asignación del usuario a la caja no existe.'
                );
            }

            /*
             * Verificar que sea una caja que requiere apertura.
             */
            $cashConfig = DB::table('cash_by_user as cbu')
                ->join(
                    'business_by_cash as bbc',
                    'bbc.id',
                    '=',
                    'cbu.business_by_cash_id'
                )
                ->join(
                    'cash_by_type as cbt',
                    'cbt.cash_id',
                    '=',
                    'bbc.cash_id'
                )
                ->join(
                    'cash_type as ct',
                    'ct.id',
                    '=',
                    'cbt.cash_type_id'
                )
                ->where('cbu.id', $cashByUserId)
                ->select([
                    'bbc.cash_id',
                    'ct.code',
                    'ct.requires_opening',
                    'ct.requires_closing'
                ])
                ->first();

            if (!$cashConfig) {
                throw new \Exception(
                    'No se encontró la configuración de la caja.'
                );
            }

            if (!(int)$cashConfig->requires_opening) {
                throw new \Exception(
                    'Este tipo de caja no requiere apertura.'
                );
            }

            $model = new self();

            $model->cash_by_user_id = $cashByUserId;
            $model->opening_amount = $openingAmount;
            $model->opening_date = now();
            $model->opening_details = $openingDetails;

            $model->expected_amount = null;
            $model->closing_amount = null;
            $model->difference_amount = null;
            $model->closing_date = null;
            $model->closing_details = null;

            $model->state = self::STATE_OPEN;

            $model->created_at = now();
            $model->update_at = now();

            if (!$model->save()) {
                throw new \Exception(
                    'Problemas al realizar la apertura de caja.'
                );
            }

            DB::commit();

            return [
                'success' => true,
                'msj' => '',
                'errors' => [],
                'data' => $model
            ];

        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'success' => false,
                'msj' => $e->getMessage(),
                'errors' => [],
                'data' => null
            ];
        }
    }

    public function createOpeningSession(
        $cashByUserId,
        $openingAmount,
        $openingDetails = null,
        $openingDate = null
    ) {
        $currentDate = $openingDate ?? now();

        $model = new self();

        $model->cash_by_user_id = $cashByUserId;

        $model->opening_amount = $openingAmount;
        $model->opening_date = $currentDate;
        $model->opening_details = $openingDetails;

        $model->expected_amount = null;
        $model->closing_amount = null;
        $model->difference_amount = null;

        $model->closing_date = null;
        $model->closing_details = null;

        $model->state = self::STATE_OPEN;

        $model->created_at = $currentDate;
        $model->update_at = null;

        if (!$model->save()) {
            return null;
        }

        return $model;
    }
    public function closeSession(
        $cashSessionId,
        $expectedAmount,
        $closingAmount,
        $differenceAmount,
        $closingDetails = null,
        $closingDate = null
    ) {
        $currentDate = $closingDate ?? now();

        $session = self::where(
            'id',
            $cashSessionId
        )
            ->where(
                'state',
                self::STATE_OPEN
            )
            ->first();

        if (!$session) {
            return null;
        }

        $session->expected_amount =
            $expectedAmount;

        $session->closing_amount =
            $closingAmount;

        $session->difference_amount =
            $differenceAmount;

        $session->closing_date =
            $currentDate;

        $session->closing_details =
            $closingDetails;

        $session->state =
            self::STATE_CLOSED;

        $session->update_at =
            $currentDate;

        if (!$session->save()) {
            return null;
        }

        return $session;
    }
}
