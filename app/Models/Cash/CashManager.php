<?php

namespace App\Models\Cash;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CashManager
{
    public function registerPosSaleCashMovement(
        $context,
        $userId,
        $invoiceSaleId,
        $total,
        $paymentMethodId
    ) {
        $errors = [];
        $message = '';

        try {

            /*
             * =====================================================
             * 1. VALIDAR CONTEXTO
             * =====================================================
             */

            if (
                empty($context) ||
                !isset($context['data']['cash'])
            ) {
                $message = 'El contexto de caja no es válido.';

                $errors['cash_context'][] =
                    'No se encontró información de la caja.';

                throw new \Exception($message);
            }



            /*
             * =====================================================
             * 3. DATOS DEL CONTEXTO
             * =====================================================
             */

            $cashData =
                $context['data']['cash'];


            /*
             * =====================================================
             * 4. OBTENER SESIÓN ABIERTA
             * =====================================================
             */

            $cashSessionModel =
                new CashSession();

            $cashSession =
                $cashSessionModel->getAnyOpenByCashUser(
                    $cashData->cash_by_user_id
                );


            /*
             * =====================================================
             * 5. VALIDAR SESIÓN ABIERTA
             * =====================================================
             */

            if (!$cashSession) {

                $message =
                    'No existe una sesión de caja abierta para registrar la venta.';

                $errors['cash_session'][] =
                    'El usuario no tiene una sesión de caja abierta.';

                throw new \Exception($message);
            }


            /*
             * =====================================================
             * 6. PREPARAR CASH MOVEMENT
             * =====================================================
             */

            $movementParams = [
                'user_id' => $userId,
                'cash_session_id' => $cashSession->id,
                'cash_id' => $cashData->cash_id,
                'movement_type' => CashReason::MOVEMENT_INPUT,
                'cash_reason_id' => CashReason::REASON_CASH_SALE,
                'accounting_account_id' => 1,
                'details' => 'Venta POS - Ticket #' . $invoiceSaleId,
                'rode' => (float)$total,
                'transaction_type' => CashMovement::TRANSACTION_TYPE_DIRECT,
            ];


            /*
             * =====================================================
             * 7. REGISTRAR CASH MOVEMENT
             * =====================================================
             */

            $cashMovement =
                new CashMovement();

            $movementResult =
                $cashMovement->registerMovement(
                    $movementParams
                );


            /*
             * =====================================================
             * 8. VALIDAR CASH MOVEMENT
             * =====================================================
             */

            if (
                !isset($movementResult['success']) ||
                !$movementResult['success']
            ) {

                $message =
                    $movementResult['message']
                    ?? 'No fue posible registrar el movimiento de caja.';

                $errors =
                    $movementResult['errors']
                    ?? [];

                throw new \Exception($message);
            }


            /*
             * =====================================================
             * 9. VALIDAR ID DEL MOVIMIENTO
             * =====================================================
             */

            if (
                !isset($movementResult['data']) ||
                !$movementResult['data'] ||
                empty($movementResult['data']->id)
            ) {

                $message =
                    'El movimiento de caja fue registrado sin un identificador válido.';

                $errors['cash_movement'][] =
                    'No se pudo obtener el identificador del movimiento de caja.';

                throw new \Exception($message);
            }


            /*
             * =====================================================
             * 10. PREPARAR CASH BY TRANSACTION MANAGEMENT
             * =====================================================
             */

            $transactionParams = [
                'types_payments_id' =>
                    (int)$paymentMethodId,
                'business_by_cash_id' =>
                    (int)$cashData->business_by_cash_id,
                'entidad_data_id' =>
                    (int)$movementResult['data']->id
            ];


            /*
             * =====================================================
             * 11. REGISTRAR TRANSACTION MANAGEMENT
             * =====================================================
             */

            $transactionManager =
                new CashByTransactionManagement();

            $transactionResult =
                $transactionManager
                    ->registerTransactionManagement(
                        $transactionParams
                    );


            /*
             * =====================================================
             * 12. VALIDAR TRANSACTION MANAGEMENT
             * =====================================================
             */

            if (
                !isset($transactionResult['success']) ||
                !$transactionResult['success']
            ) {

                $message =
                    $transactionResult['message']
                    ?? 'No fue posible registrar la transacción de caja.';

                $errors =
                    $transactionResult['errors']
                    ?? [];

                throw new \Exception($message);
            }


            /*
             * =====================================================
             * 13. SUCCESS
             * =====================================================
             */

            return [
                'success' => true,

                'message' =>
                    'Venta registrada correctamente en el turno de caja.',

                'data' => [

                    'cash_session_id' =>
                        (int)$cashSession->id,

                    'cash_movement' =>
                        $movementResult['data'],

                    'transaction_management' =>
                        $transactionResult['data']
                ],

                'errors' => []
            ];


        } catch (\Throwable $e) {

            return [
                'success' => false,

                'message' =>
                    !empty($message)
                        ? $message
                        : 'Ocurrió un error al registrar la venta en el turno de caja.',

                'data' => [],

                'errors' =>
                    !empty($errors)
                        ? $errors
                        : [
                        'exception' => [
                            $e->getMessage()
                        ]
                    ]
            ];
        }
    }

    public function getPointOfSaleCashContext(
        $userId,
        $businessId
    )
    {
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
    )
    {
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
    )
    {
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
    )
    {
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

    public function generateMovementCash($params)
    {
        $errors = [];

        /*
         * =====================================================
         * INICIAR TRANSACCIÓN GENERAL
         * =====================================================
         *
         * CashByTransactionManagement
         * +
         * CashMovement
         *
         * deben guardarse juntos.
         * =====================================================
         */

        DB::beginTransaction();


        try {

            /*
             * =====================================================
             * 1. PARAMS BASE
             * =====================================================
             */

            $userId =
                isset($params['user_id'])
                    ? (int)$params['user_id']
                    : 0;


            $businessId =
                isset($params['business_id'])
                    ? (int)$params['business_id']
                    : 0;


            /*
             * =====================================================
             * 2. CONTEXTO DE CAJA POS
             * =====================================================
             */

            $context =
                $this->getPointOfSaleCashContext(
                    $userId,
                    $businessId
                );


            if (!$context['success']) {

                DB::rollBack();

                return [
                    'success' => false,

                    'message' =>
                        $context['msj']
                        ?? $context['message']
                            ?? 'No fue posible obtener el contexto de caja.',

                    'data' =>
                        $context['data'] ?? [],

                    'errors' =>
                        $context['errors'] ?? []
                ];
            }


            /*
             * =====================================================
             * DATOS DEL CONTEXTO
             * =====================================================
             */

            $cashData =
                $context['data']['cash'];


            $cashSessionModel =
                new CashSession();

            $cashSession =
                $cashSessionModel->getAnyOpenByCashUser(
                    $cashData->cash_by_user_id
                );

            /*
             * =====================================================
             * 3. MAPEAR PARAMS DEL MOVIMIENTO
             * =====================================================
             */

            $movementType =
                isset($params['movement_type'])
                    ? (int)$params['movement_type']
                    : null;


            $cashReasonId =
                isset($params['cash_reason_id'])
                    ? (int)$params['cash_reason_id']
                    : null;


            $accountingAccountId =
                isset($params['accounting_account_id'])
                    ? (int)$params['accounting_account_id']
                    : null;


            $rode =
                isset($params['rode'])
                    ? (float)$params['rode']
                    : null;


            $transactionType =
                isset($params['transaction_type'])
                    ? (int)$params['transaction_type']
                    : null;


            $typesPaymentsId =
                isset($params['types_payments_id'])
                    ? (int)$params['types_payments_id']
                    : null;


            $details =
                trim(
                    $params['details'] ?? ''
                );


            /*
             * =====================================================
             * 4. VALIDAR MOVEMENT TYPE
             *
             * 0 = INGRESO
             * 1 = EGRESO
             * =====================================================
             */

            if (
                $movementType === null ||
                (
                    $movementType !==
                    CashMovement::MOVEMENT_INPUT &&

                    $movementType !==
                    CashMovement::MOVEMENT_OUTPUT
                )
            ) {

                $errors['movement_type'][] =
                    'El tipo de movimiento debe ser 0 (INGRESO) o 1 (EGRESO).';
            }


            /*
             * =====================================================
             * 5. VALIDAR TRANSACTION TYPE
             *
             * 0 = INDIRECTO
             * 1 = DIRECTO
             * =====================================================
             */

            if (
                $transactionType === null ||
                (
                    $transactionType !==
                    CashMovement::TRANSACTION_TYPE_INDIRECT &&

                    $transactionType !==
                    CashMovement::TRANSACTION_TYPE_DIRECT
                )
            ) {

                $errors['transaction_type'][] =
                    'El tipo de transacción debe ser 0 (INDIRECTO) o 1 (DIRECTO).';
            }


            /*
             * =====================================================
             * 6. VALIDAR CASH REASON
             * =====================================================
             */

            if (empty($cashReasonId)) {

                $errors['cash_reason_id'][] =
                    'El motivo del movimiento es requerido.';

            } else {


                /*
                 * Verificar que exista y esté activo.
                 */
                $reasonExists =
                    CashReason::where(
                        'id',
                        $cashReasonId
                    )
                        ->where(
                            'state',
                            CashReason::STATE_ACTIVE
                        )
                        ->exists();


                if (!$reasonExists) {

                    $errors['cash_reason_id'][] =
                        'El motivo seleccionado no existe o está inactivo.';
                }
            }


            /*
             * =====================================================
             * 7. ACCOUNTING ACCOUNT
             * =====================================================
             */

            if (empty($accountingAccountId)) {

                $errors['accounting_account_id'][] =
                    'La cuenta contable es requerida.';
            }


            /*
             * =====================================================
             * 8. AMOUNT
             * =====================================================
             */

            if (
                $rode === null ||
                $rode <= 0
            ) {

                $errors['rode'][] =
                    'El valor del movimiento debe ser mayor a cero.';
            }


            /*
             * =====================================================
             * 9. PAYMENT TYPE
             * =====================================================
             */

            if (empty($typesPaymentsId)) {

                $errors['types_payments_id'][] =
                    'El tipo de pago es requerido.';
            }


            /*
             * =====================================================
             * 10. DETENER SI EXISTEN ERRORES
             * =====================================================
             */

            if (!empty($errors)) {

                DB::rollBack();

                return [
                    'success' => false,

                    'message' =>
                        'Existen problemas con los datos del movimiento de caja.',

                    'data' => [],

                    'errors' =>
                        $errors
                ];
            }


            /*
             * =====================================================
             * 12. CASH MOVEMENT
             * =====================================================
             */

            $movementParams = [

                'user_id' =>
                    $userId,
                'cash_session_id' =>
                    $cashSession->id,
                'cash_id' =>
                    $cashData->cash_id,

                /*
                 * 0 = INGRESO
                 * 1 = EGRESO
                 */
                'movement_type' =>
                    $movementType,

                'cash_reason_id' =>
                    $cashReasonId,

                'accounting_account_id' =>
                    $accountingAccountId,

                'details' =>
                    $details,

                'rode' =>
                    $rode,

                /*
                 * 0 = INDIRECTO
                 * 1 = DIRECTO
                 */
                'transaction_type' =>
                    $transactionType
            ];


            $cashMovement =
                new CashMovement();


            $movementResult =
                $cashMovement
                    ->registerMovement(
                        $movementParams
                    );


            /*
             * =====================================================
             * ERROR CASH MOVEMENT
             * =====================================================
             *
             * IMPORTANTE:
             *
             * Si CashByTransactionManagement se guardó
             * pero CashMovement falla,
             * rollback elimina también el primer INSERT.
             * =====================================================
             */

            if (!$movementResult['success']) {

                DB::rollBack();

                return [
                    'success' => false,

                    'message' =>
                        $movementResult['message']
                        ?? 'No fue posible registrar el movimiento de caja.',

                    'data' => [],

                    'errors' =>
                        $movementResult['errors'] ?? []
                ];
            }


            /*
             * =====================================================
             * 11. CASH BY TRANSACTION MANAGEMENT
             * =====================================================
             */

            $transactionParams = [

                'types_payments_id' =>
                    $typesPaymentsId,

                'business_by_cash_id' =>
                    $cashData->business_by_cash_id,

                'entidad_data_id' => $movementResult['data']->id
            ];


            $transactionManager =
                new CashByTransactionManagement();


            $transactionResult =
                $transactionManager
                    ->registerTransactionManagement(
                        $transactionParams
                    );


            /*
             * =====================================================
             * ERROR CASH BY TRANSACTION MANAGEMENT
             * =====================================================
             */

            if (!$transactionResult['success']) {

                DB::rollBack();

                return [
                    'success' => false,

                    'message' =>
                        $transactionResult['message']
                        ?? 'No fue posible registrar la transacción de caja.',

                    'data' => [],

                    'errors' =>
                        $transactionResult['errors'] ?? []
                ];
            }

            /*
             * =====================================================
             * 13. COMMIT
             * =====================================================
             *
             * SOLO LLEGAMOS AQUÍ SI:
             *
             * CashByTransactionManagement = OK
             * CashMovement                = OK
             *
             * =====================================================
             */

            DB::commit();


            /*
             * =====================================================
             * SUCCESS
             * =====================================================
             */

            return [
                'success' => true,

                'message' =>
                    'Movimiento de caja registrado correctamente.',

                'data' => [

                    'transaction_management' =>
                        $transactionResult['data'],

                    'cash_movement' =>
                        $movementResult['data']
                ],

                'errors' => []
            ];


        } catch (\Throwable $e) {

            /*
             * =====================================================
             * ERROR GENERAL
             * =====================================================
             */

            DB::rollBack();


            return [
                'success' => false,

                'message' =>
                    'Ocurrió un error al registrar el movimiento de caja.',

                'data' => [],

                'errors' => [
                    'exception' =>
                        $e->getMessage()
                ]
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
    )
    {
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
             * THEORETICAL CASH BALANCE
             * =====================================================
             *
             * Saldo teórico general de la caja.
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
             * Obtiene las formas de pago asociadas
             * a los movimientos de esta sesión.
             *
             * Ejemplo:
             *
             * - Efectivo
             * - Tarjeta
             * - Transferencia
             * - Otros
             *
             */

            $cashByTransactionManagementModel =
                new CashByTransactionManagement();

            $paymentSummary =
                $cashByTransactionManagementModel
                    ->getPaymentSummary(
                        (int)$cashData->business_by_cash_id,
                        (int)$cashSession->id
                    );

            /*
             * =====================================================
             * EXPECTED PHYSICAL CASH
             * =====================================================
             *
             * Este valor representa únicamente el dinero
             * físico que debería existir en la caja.
             *
             * Opening
             * + Cash payments net amount
             *
             * IMPORTANTE:
             *
             * paymentSummary['cash_total'] debe representar:
             *
             * CASH INPUTS
             * -
             * CASH OUTPUTS
             *
             * Es decir, debe ser un valor NETO.
             *
             */

            $cashPaymentTotal =
                (float)(
                    $paymentSummary['cash_total'] ?? 0
                );

            $expectedCashAmount =
                $openingAmount
                + $cashPaymentTotal;

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

                    /*
                     * ---------------------------------------------
                     * OPENING AMOUNT
                     * ---------------------------------------------
                     */

                    'opening_amount' =>
                        $openingAmount,

                    /*
                     * ---------------------------------------------
                     * GENERAL MOVEMENTS
                     * ---------------------------------------------
                     */

                    'total_input' =>
                        $totalInput,

                    'total_output' =>
                        $totalOutput,

                    /*
                     * ---------------------------------------------
                     * THEORETICAL BALANCE
                     * ---------------------------------------------
                     *
                     * Apertura
                     * + todos los ingresos
                     * - todos los egresos
                     *
                     */

                    'expected_amount' =>
                        $expectedAmount,

                    /*
                     * ---------------------------------------------
                     * CASH PAYMENT NET TOTAL
                     * ---------------------------------------------
                     *
                     * Solamente movimientos cuya forma
                     * de pago afecta al efectivo.
                     *
                     */

                    'cash_payment_total' =>
                        $cashPaymentTotal,

                    /*
                     * ---------------------------------------------
                     * EXPECTED PHYSICAL CASH
                     * ---------------------------------------------
                     *
                     * Dinero físico que debería entregar
                     * el empleado al cerrar la caja.
                     *
                     * Apertura
                     * + efectivo neto
                     *
                     */

                    'expected_cash_amount' =>
                        $expectedCashAmount
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
