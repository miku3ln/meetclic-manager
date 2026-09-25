<?php

namespace App\Models\Cash;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CashManager
{
    private function getPointOfSaleCashContext(
        $userId,
        $businessId
    ) {
        $errors = [];

        /*
         * =====================================================
         * VALIDAR PARÁMETROS BASE
         * =====================================================
         */

        if (empty($userId)) {
            $errors['user_id'][] =
                'El usuario es requerido.';
        }

        if (empty($businessId)) {
            $errors['business_id'][] =
                'La empresa es requerida.';
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'msj' =>
                    'Existen problemas con los datos de la caja.',
                'data' => null,
                'errors' => $errors
            ];
        }

        $userId =
            (int)$userId;

        $businessId =
            (int)$businessId;


        /*
         * =====================================================
         * BUSCAR CAJA POINT_OF_SALE
         * =====================================================
         */

        $cashByUserModel =
            new CashByUser();

        $cashData =
            $cashByUserModel->getPointOfSaleCashByUser(
                $userId,
                $businessId
            );


        /*
         * =====================================================
         * VALIDAR CAJA POS
         * =====================================================
         */

        if (!$cashData) {
            return [
                'success' => false,
                'msj' =>
                    'La empresa no tiene una caja de punto de venta activa.',
                'data' => null,
                'errors' => []
            ];
        }


        /*
         * =====================================================
         * VALIDAR ASIGNACIÓN
         * =====================================================
         */

        if (empty($cashData->cash_by_user_id)) {
            return [
                'success' => false,
                'msj' =>
                    'El usuario no está asignado a la caja de punto de venta.',
                'data' => null,
                'errors' => []
            ];
        }


        /*
         * =====================================================
         * CONTEXTO VÁLIDO
         * =====================================================
         */

        return [
            'success' => true,
            'msj' => '',
            'data' => [
                'user_id' =>
                    $userId,

                'business_id' =>
                    $businessId,

                'cash' =>
                    $cashData
            ],
            'errors' => []
        ];
    }
    /**
     * Obtener la caja POS asignada a un usuario dentro de una empresa.
     */
    public function getUserPointOfSaleCash(
        $userId,
        $businessId
    ) {
        try {

            /*
             * =====================================================
             * 1. OBTENER Y VALIDAR CONTEXTO DE CAJA POS
             * =====================================================
             */

            $context =
                $this->getPointOfSaleCashContext(
                    $userId,
                    $businessId
                );

            if (!$context['success']) {
                return $context;
            }

            $userId =
                $context['data']['user_id'];

            $businessId =
                $context['data']['business_id'];

            $cashData =
                $context['data']['cash'];


            /*
             * =====================================================
             * 2. BUSCAR SESIÓN ABIERTA
             * =====================================================
             */

            $cashSessionModel =
                new CashSession();

            $cashSession =
                $cashSessionModel->getAnyOpenByCashUser(
                    $cashData->cash_by_user_id
                );

            $isOpen =
                $cashSession !== null;


            /*
             * =====================================================
             * 3. CONSTRUIR INFORMACIÓN DE SESIÓN
             * =====================================================
             */

            $sessionData = [
                'is_open' =>
                    $isOpen,

                'id' =>
                    $cashSession
                        ? (int)$cashSession->id
                        : null,

                'state' =>
                    $cashSession
                        ? $cashSession->state
                        : null,

                'opening_amount' =>
                    $cashSession
                        ? (float)$cashSession->opening_amount
                        : null,

                'opening_date' =>
                    $cashSession
                        ? $cashSession->opening_date
                        : null,

                'opening_details' =>
                    $cashSession
                        ? $cashSession->opening_details
                        : null
            ];


            /*
             * =====================================================
             * 4. VALORES INICIALES DE MOVIMIENTOS
             * =====================================================
             */

            $movementData = [
                'total_input' =>
                    0.00,

                'total_output' =>
                    0.00,

                'balance' =>
                    $cashSession
                        ? (float)$cashSession->opening_amount
                        : 0.00,

                'count_input' =>
                    0,

                'count_output' =>
                    0
            ];


            /*
             * =====================================================
             * 5. CALCULAR MOVIMIENTOS DE LA SESIÓN
             * =====================================================
             */

            if ($isOpen) {

                $movementModel =
                    new CashMovement();

                $movementSummary =
                    $movementModel->getSessionMovementSummary(
                        $cashSession->id
                    );

                $totalInput =
                    (float)(
                        $movementSummary->total_input ?? 0
                    );

                $totalOutput =
                    (float)(
                        $movementSummary->total_output ?? 0
                    );

                $countInput =
                    (int)(
                        $movementSummary->count_input ?? 0
                    );

                $countOutput =
                    (int)(
                        $movementSummary->count_output ?? 0
                    );

                $openingAmount =
                    (float)$cashSession->opening_amount;


                /*
                 * =====================================================
                 * SALDO ESPERADO
                 *
                 * apertura + ingresos - egresos
                 * =====================================================
                 */

                $balance =
                    $openingAmount
                    + $totalInput
                    - $totalOutput;


                $movementData = [
                    'total_input' =>
                        $totalInput,

                    'total_output' =>
                        $totalOutput,

                    'balance' =>
                        $balance,

                    'count_input' =>
                        $countInput,

                    'count_output' =>
                        $countOutput
                ];
            }


            /*
             * =====================================================
             * 6. CONSTRUIR RESPUESTA
             * =====================================================
             */

            $data = [

                'cash' => [
                    'id' =>
                        (int)$cashData->cash_id,

                    'name' =>
                        $cashData->cash_name,

                    'details' =>
                        $cashData->cash_details,

                    'amount_current' =>
                        (float)$cashData->amount_current,

                    'accounting_account_id' =>
                        (int)$cashData->accounting_account_id
                ],

                'cash_type' => [
                    'id' =>
                        (int)$cashData->cash_type_id,

                    'code' =>
                        $cashData->cash_type_code,

                    'value' =>
                        $cashData->cash_type,

                    'requires_opening' =>
                        (bool)$cashData->requires_opening,

                    'requires_closing' =>
                        (bool)$cashData->requires_closing
                ],

                'assignment' => [
                    'cash_by_user_id' =>
                        (int)$cashData->cash_by_user_id,

                    'business_by_cash_id' =>
                        (int)$cashData->business_by_cash_id,

                    'business_id' =>
                        $businessId,

                    'user_id' =>
                        $userId
                ],

                'session' =>
                    $sessionData,

                'movement_summary' =>
                    $movementData
            ];


            /*
             * =====================================================
             * 7. RESPUESTA
             * =====================================================
             */

            return [
                'success' =>
                    true,

                'msj' =>
                    $isOpen
                        ? 'Existe una sesión de caja abierta para el usuario.'
                        : 'No existe una sesión de caja abierta para el usuario.',

                'data' =>
                    $data,

                'errors' =>
                    []
            ];

        } catch (\Exception $e) {

            return [
                'success' =>
                    false,

                'msj' =>
                    $e->getMessage(),

                'data' =>
                    [],

                'errors' =>
                    []
            ];
        }
    }
    public function openPointOfSaleCash(
        $userId,
        $businessId,
        $openingAmount,
        $openingDetails = null
    ) {
        $errors = [];

        DB::beginTransaction();

        try {

            /*
             * =====================================================
             * 1. OBTENER Y VALIDAR CONTEXTO DE CAJA POS
             * =====================================================
             */

            $context =
                $this->getPointOfSaleCashContext(
                    $userId,
                    $businessId
                );

            if (!$context['success']) {
                return $context;
            }

            $userId =
                $context['data']['user_id'];

            $businessId =
                $context['data']['business_id'];

            $cashData =
                $context['data']['cash'];


            /*
             * =====================================================
             * 2. VALIDAR DATOS DE APERTURA
             * =====================================================
             */

            if (
                $openingAmount === null ||
                !is_numeric($openingAmount)
            ) {
                $errors['opening_amount'][] =
                    'El monto de apertura es requerido.';
            } elseif ((float)$openingAmount < 0) {
                $errors['opening_amount'][] =
                    'El monto de apertura no puede ser negativo.';
            }

            if (!empty($errors)) {


                return [
                    'success' => false,
                    'msj' =>
                        'Existen problemas con los datos de apertura.',
                    'data' => [],
                    'errors' => $errors
                ];
            }

            $openingAmount =
                (float)$openingAmount;
            /*
             * =====================================================
             * 3. VALIDAR SI YA EXISTE UNA SESIÓN ABIERTA
             * =====================================================
             *
             * No se utiliza rango de fechas.
             *
             * Si existe cualquier sesión OPEN, incluso de un
             * día anterior, debe cerrarse antes de realizar
             * una nueva apertura.
             * =====================================================
             */

            $cashSessionModel =
                new CashSession();

            $openSession =
                $cashSessionModel->getAnyOpenByCashUser(
                    $cashData->cash_by_user_id
                );

            if ($openSession) {
                return [
                    'success' => false,
                    'msj' =>
                        'El usuario ya tiene una sesión de caja abierta. Debe cerrar la sesión actual antes de realizar una nueva apertura.',
                    'data' => [
                        'session' => [
                            'id' =>
                                (int)$openSession->id,

                            'is_open' =>
                                true,

                            'state' =>
                                $openSession->state,

                            'opening_amount' =>
                                (float)$openSession->opening_amount,

                            'opening_date' =>
                                $openSession->opening_date,

                            'opening_details' =>
                                $openSession->opening_details
                        ]
                    ],
                    'errors' => []
                ];
            }


            /*
             * =====================================================
             * 4. FECHA DE APERTURA
             * =====================================================
             */

            $currentDate =
                Carbon::now();


            /*
             * =====================================================
             * 5. CREAR SESIÓN DE APERTURA
             * =====================================================
             */

            $cashSession =
                $cashSessionModel->createOpeningSession(
                    $cashData->cash_by_user_id,
                    $openingAmount,
                    $openingDetails,
                    $currentDate
                );

            if (!$cashSession) {
                throw new \Exception(
                    'No se pudo realizar la apertura de caja.'
                );
            }


            /*
             * =====================================================
             * 6. CONFIRMAR TRANSACCIÓN
             * =====================================================
             */

            DB::commit();


            /*
             * =====================================================
             * 7. RESPUESTA
             * =====================================================
             */

            return [
                'success' => true,

                'msj' =>
                    'La caja de punto de venta fue abierta correctamente.',

                'data' => [

                    'cash' => [
                        'id' =>
                            (int)$cashData->cash_id,

                        'name' =>
                            $cashData->cash_name
                    ],

                    'assignment' => [
                        'cash_by_user_id' =>
                            (int)$cashData->cash_by_user_id,

                        'business_by_cash_id' =>
                            (int)$cashData->business_by_cash_id,

                        'business_id' =>
                            $businessId,

                        'user_id' =>
                            $userId
                    ],

                    'session' => [
                        'id' =>
                            (int)$cashSession->id,

                        'is_open' =>
                            true,

                        'state' =>
                            $cashSession->state,

                        'opening_amount' =>
                            (float)$cashSession->opening_amount,

                        'opening_date' =>
                            $cashSession->opening_date,

                        'opening_details' =>
                            $cashSession->opening_details
                    ]
                ],

                'errors' => []
            ];

        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'success' => false,
                'msj' =>
                    $e->getMessage(),
                'data' => [],
                'errors' =>
                    $errors
            ];
        }
    }
    public function closePointOfSaleCash(
        $userId,
        $businessId,
        $closingAmount,
        $closingDetails = null
    ) {
        $errors = [];

        DB::beginTransaction();

        try {

            /*
             * =====================================================
             * 1. OBTENER Y VALIDAR CONTEXTO DE CAJA POS
             * =====================================================
             */

            $context =
                $this->getPointOfSaleCashContext(
                    $userId,
                    $businessId
                );

            if (!$context['success']) {

                DB::rollBack();

                return $context;
            }

            $userId =
                $context['data']['user_id'];

            $businessId =
                $context['data']['business_id'];

            $cashData =
                $context['data']['cash'];


            /*
             * =====================================================
             * 2. VALIDAR DATOS DE CIERRE
             * =====================================================
             */

            if (
                $closingAmount === null ||
                !is_numeric($closingAmount)
            ) {
                $errors['closing_amount'][] =
                    'El monto de cierre es requerido.';
            } elseif ((float)$closingAmount < 0) {
                $errors['closing_amount'][] =
                    'El monto de cierre no puede ser negativo.';
            }

            if (!empty($errors)) {

                DB::rollBack();

                return [
                    'success' => false,
                    'msj' =>
                        'Existen problemas con los datos de cierre.',
                    'data' => [],
                    'errors' => $errors
                ];
            }

            $closingAmount =
                (float)$closingAmount;


            /*
             * =====================================================
             * 3. BUSCAR SESIÓN ABIERTA
             * =====================================================
             */

            $cashSessionModel =
                new CashSession();

            $openSession =
                $cashSessionModel->getAnyOpenByCashUser(
                    $cashData->cash_by_user_id
                );

            if (!$openSession) {

                DB::rollBack();

                return [
                    'success' => false,
                    'msj' =>
                        'El usuario no tiene una sesión de caja abierta para cerrar.',
                    'data' => [],
                    'errors' => []
                ];
            }


            /*
             * =====================================================
             * 4. OBTENER MOVIMIENTOS DE LA SESIÓN
             * =====================================================
             */

            $cashMovementModel =
                new CashMovement();

            $movementSummary =
                $cashMovementModel->getSessionMovementSummary(
                    $openSession->id
                );

            $totalInput =
                (float)($movementSummary->total_input ?? 0);

            $totalOutput =
                (float)($movementSummary->total_output ?? 0);

            $countInput =
                (int)($movementSummary->count_input ?? 0);

            $countOutput =
                (int)($movementSummary->count_output ?? 0);


            /*
             * =====================================================
             * 5. CALCULAR SALDO ESPERADO
             *
             * apertura + ingresos - egresos
             * =====================================================
             */

            $openingAmount =
                (float)$openSession->opening_amount;

            $expectedAmount =
                $openingAmount
                + $totalInput
                - $totalOutput;


            /*
             * =====================================================
             * 6. CALCULAR DIFERENCIA
             *
             * positivo = sobrante
             * negativo = faltante
             * cero     = cierre exacto
             * =====================================================
             */

            $differenceAmount =
                $closingAmount
                - $expectedAmount;


            /*
             * =====================================================
             * 7. CERRAR SESIÓN
             * =====================================================
             */

            $currentDate =
                Carbon::now();

            $closedSession =
                $cashSessionModel->closeSession(
                    $openSession->id,
                    $expectedAmount,
                    $closingAmount,
                    $differenceAmount,
                    $closingDetails,
                    $currentDate
                );

            if (!$closedSession) {
                throw new \Exception(
                    'No se pudo realizar el cierre de caja.'
                );
            }


            /*
             * =====================================================
             * 8. CONFIRMAR TRANSACCIÓN
             * =====================================================
             */

            DB::commit();


            /*
             * =====================================================
             * 9. RESPUESTA
             * =====================================================
             */

            return [
                'success' => true,

                'msj' =>
                    'La caja de punto de venta fue cerrada correctamente.',

                'data' => [

                    'cash' => [
                        'id' =>
                            (int)$cashData->cash_id,

                        'name' =>
                            $cashData->cash_name
                    ],

                    'assignment' => [
                        'cash_by_user_id' =>
                            (int)$cashData->cash_by_user_id,

                        'business_by_cash_id' =>
                            (int)$cashData->business_by_cash_id,

                        'business_id' =>
                            $businessId,

                        'user_id' =>
                            $userId
                    ],

                    'session' => [
                        'id' =>
                            (int)$closedSession->id,

                        'is_open' =>
                            false,

                        'state' =>
                            $closedSession->state,

                        'opening_amount' =>
                            (float)$closedSession->opening_amount,

                        'opening_date' =>
                            $closedSession->opening_date,

                        'expected_amount' =>
                            (float)$closedSession->expected_amount,

                        'closing_amount' =>
                            (float)$closedSession->closing_amount,

                        'difference_amount' =>
                            (float)$closedSession->difference_amount,

                        'closing_date' =>
                            $closedSession->closing_date,

                        'closing_details' =>
                            $closedSession->closing_details
                    ],

                    'movement_summary' => [
                        'total_input' =>
                            $totalInput,

                        'total_output' =>
                            $totalOutput,

                        'balance' =>
                            $expectedAmount,

                        'count_input' =>
                            $countInput,

                        'count_output' =>
                            $countOutput
                    ]
                ],

                'errors' => []
            ];

        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'success' => false,
                'msj' =>
                    $e->getMessage(),
                'data' => [],
                'errors' =>
                    $errors
            ];
        }
    }
    /**
     * ============================================================
     * POINT OF SALE - CASH CLOSE SUMMARY
     * ============================================================
     *
     * Obtiene el resumen de la sesión de caja actualmente abierta
     * para un usuario dentro de una empresa.
     *
     * El resumen incluye:
     *
     * - Información de la caja.
     * - Información de la asignación.
     * - Información de la sesión abierta.
     * - Movimientos de entrada consolidados por motivo.
     * - Movimientos de salida consolidados por motivo.
     * - Totales de entradas y salidas.
     * - Cantidad de movimientos.
     * - Valor esperado en caja.
     *
     * Las formas de pago se incorporarán cuando se consulte
     * CashByTransactionManagement.
     *
     * @param int $userId
     * @param int $businessId
     *
     * @return array
     */
    public function getPointOfSaleCashCloseSummary(
        $userId,
        $businessId
    ) {
        try {

            /*
             * =====================================================
             * VALIDATE / GET POS CASH CONTEXT
             * =====================================================
             */

            $context = $this->getPointOfSaleCashContext(
                $userId,
                $businessId
            );

            if (!$context['success']) {
                return $context;
            }

            /*
             * =====================================================
             * CASH CONTEXT
             * =====================================================
             */

            $cashData = $context['data']['cash'];

            $cashId =
                (int)$cashData->cash_id;

            $cashByUserId =
                (int)$cashData->cash_by_user_id;

            /*
             * =====================================================
             * VALIDATE CASH ASSIGNMENT
             * =====================================================
             */

            if ($cashByUserId <= 0) {
                return [
                    'success' => false,
                    'msj' =>
                        'El usuario no tiene una caja POS asignada.',
                    'errors' => [],
                    'data' => null
                ];
            }

            /*
             * =====================================================
             * GET OPEN CASH SESSION
             * =====================================================
             */

            $cashSessionModel =
                new CashSession();

            $cashSession =
                $cashSessionModel
                    ->getAnyOpenByCashUser(
                        $cashByUserId
                    );

            /*
             * =====================================================
             * VALIDATE OPEN SESSION
             * =====================================================
             */

            if (!$cashSession) {
                return [
                    'success' => false,
                    'msj' =>
                        'No existe una sesión de caja abierta para el usuario.',
                    'errors' => [],
                    'data' => null
                ];
            }

            /*
             * =====================================================
             * CASH MOVEMENT MODEL
             * =====================================================
             */

            $cashMovementModel =
                new CashMovement();

            /*
             * =====================================================
             * GET GENERAL MOVEMENT SUMMARY
             * =====================================================
             *
             * Result:
             *
             * total_input
             * total_output
             * count_input
             * count_output
             *
             */

            $movementSummary =
                $cashMovementModel
                    ->getSessionMovementSummary(
                        $cashSession->id
                    );

            /*
             * =====================================================
             * NORMALIZE MOVEMENT SUMMARY
             * =====================================================
             */

            $totalInput =
                (float)(
                    $movementSummary->total_input ?? 0
                );

            $totalOutput =
                (float)(
                    $movementSummary->total_output ?? 0
                );

            $countInput =
                (int)(
                    $movementSummary->count_input ?? 0
                );

            $countOutput =
                (int)(
                    $movementSummary->count_output ?? 0
                );

            /*
             * =====================================================
             * GET MOVEMENTS GROUPED BY REASON
             * =====================================================
             */

            $movementByReason =
                $cashMovementModel
                    ->getSessionMovementSummaryByReason(
                        $cashSession->id
                    );

            /*
             * =====================================================
             * BUILD INPUT / OUTPUT COLLECTIONS
             * =====================================================
             */

            $inputs = [];
            $outputs = [];

            foreach ($movementByReason as $movement) {

                $movementType =
                    (int)$movement->movement_type;

                $item = [
                    'cash_reason_id' =>
                        (int)$movement->cash_reason_id,

                    'name' =>
                        $movement->cash_reason,

                    'count' =>
                        (int)$movement->movement_count,

                    'amount' =>
                        (float)$movement->total
                ];

                /*
                 * =================================================
                 * INPUT
                 * =================================================
                 */

                if (
                    $movementType ===
                    CashMovement::MOVEMENT_INPUT
                ) {
                    $inputs[] = $item;
                    continue;
                }

                /*
                 * =================================================
                 * OUTPUT
                 * =================================================
                 */

                if (
                    $movementType ===
                    CashMovement::MOVEMENT_OUTPUT
                ) {
                    $outputs[] = $item;
                }
            }

            /*
             * =====================================================
             * OPENING AMOUNT
             * =====================================================
             */

            $openingAmount =
                (float)$cashSession->opening_amount;

            /*
             * =====================================================
             * EXPECTED CASH
             * =====================================================
             *
             * Opening
             * + Inputs
             * - Outputs
             *
             */

            $expectedAmount =
                $openingAmount
                + $totalInput
                - $totalOutput;

            /*
             * =====================================================
             * PAYMENT SUMMARY
             * =====================================================
             *
             * Se deja preparada la estructura.
             *
             * Cuando integremos:
             *
             * CashByTransactionManagement
             *
             * aquí se obtendrán:
             *
             * - Efectivo
             * - Tarjeta
             * - Transferencia
             * - Otros
             *
             */

            $paymentSummary = [
                'total' => 0,
                'items' => []
            ];

            /*
             * =====================================================
             * BUILD RESPONSE
             * =====================================================
             */

            $data = [

                /*
                 * =================================================
                 * CASH
                 * =================================================
                 */

                'cash' => [

                    'id' =>
                        $cashId,

                    'name' =>
                        $cashData->cash_name,

                    'details' =>
                        $cashData->cash_details ?? null,

                    'cash_type_id' =>
                        isset($cashData->cash_type_id)
                            ? (int)$cashData->cash_type_id
                            : null,

                    'cash_type_code' =>
                        $cashData->cash_type_code ?? null,

                    'cash_type' =>
                        $cashData->cash_type ?? null
                ],

                /*
                 * =================================================
                 * ASSIGNMENT
                 * =================================================
                 */

                'assignment' => [

                    'user_id' =>
                        (int)$userId,

                    'business_id' =>
                        (int)$businessId,

                    'cash_by_user_id' =>
                        $cashByUserId,

                    'business_by_cash_id' =>
                        isset(
                            $cashData->business_by_cash_id
                        )
                            ? (int)$cashData
                            ->business_by_cash_id
                            : null
                ],

                /*
                 * =================================================
                 * SESSION
                 * =================================================
                 */

                'session' => [

                    'id' =>
                        (int)$cashSession->id,

                    'state' =>
                        $cashSession->state,

                    'opening_amount' =>
                        $openingAmount,

                    'opening_date' =>
                        $cashSession->opening_date,

                    'opening_details' =>
                        $cashSession->opening_details
                ],

                /*
                 * =================================================
                 * MOVEMENTS
                 * =================================================
                 */

                'movements' => [

                    /*
                     * ---------------------------------------------
                     * INPUTS
                     * ---------------------------------------------
                     */

                    'inputs' =>
                        $inputs,

                    /*
                     * ---------------------------------------------
                     * OUTPUTS
                     * ---------------------------------------------
                     */

                    'outputs' =>
                        $outputs,

                    /*
                     * ---------------------------------------------
                     * TOTALS
                     * ---------------------------------------------
                     */

                    'total_input' =>
                        $totalInput,

                    'total_output' =>
                        $totalOutput,

                    /*
                     * ---------------------------------------------
                     * COUNTS
                     * ---------------------------------------------
                     */

                    'count_input' =>
                        $countInput,

                    'count_output' =>
                        $countOutput
                ],

                /*
                 * =================================================
                 * PAYMENTS
                 * =================================================
                 */

                'payments' =>
                    $paymentSummary,

                /*
                 * =================================================
                 * CLOSING SUMMARY
                 * =================================================
                 */

                'closing' => [

                    'opening_amount' =>
                        $openingAmount,

                    'total_input' =>
                        $totalInput,

                    'total_output' =>
                        $totalOutput,

                    'expected_amount' =>
                        $expectedAmount
                ]
            ];

            /*
             * =====================================================
             * SUCCESS RESPONSE
             * =====================================================
             */

            return [
                'success' => true,
                'msj' => '',
                'errors' => [],
                'data' => $data
            ];

        } catch (\Exception $e) {

            /*
             * =====================================================
             * ERROR RESPONSE
             * =====================================================
             */

            return [
                'success' => false,
                'msj' => $e->getMessage(),
                'errors' => [],
                'data' => null
            ];
        }
    }

}
