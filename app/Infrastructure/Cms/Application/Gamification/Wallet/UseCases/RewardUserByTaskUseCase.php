<?php

namespace App\Infrastructure\Cms\Application\Gamification\Wallet\UseCases;

use App\Infrastructure\Cms\Application\Gamification\Wallet\DTOs\TaskRewardInputDTO;
use App\Infrastructure\Cms\Domains\Gamification\Movement\Repositories\MovementRepositoryInterface;
use App\Infrastructure\Cms\Domains\Gamification\Wallet\Repositories\WalletRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RewardUserByTaskUseCase
{
    public function __construct(
        private WalletRepositoryInterface $walletRepository,
        private MovementRepositoryInterface $movementRepository
    ) {}

    public function execute(TaskRewardInputDTO $dto): array
    {

        $processId = (int) ($dto->process['id'] ?? 0);
        $businessContextId = ($dto->business_id);
        if ($processId <= 0) {
            return ['success' => false, 'msj' => 'Proceso inválido', 'data' => null];
        }
        // ✅ Para tareas, el business contexto normalmente es el negocio del proceso
        // En tu dump: business está en entity_id, o en URL; por ahora tú dijiste MEETCLIC=1
        // Ajusta aquí tu regla real.
        return DB::transaction(function () use ($dto, $businessContextId, $processId) {

            // 1) Get or Create wallet destino (subcuenta del usuario)
            // Si quieres que la subcuenta sea por empresa: usa $businessContextId
            // Si quieres wallet global del usuario: usa null
            $walletDestinationId = $this->walletRepository->getOrCreate(
                $dto->userId,
                $businessContextId,
                $dto->typeMoney
            );

            // 2) Armar movimiento (IN)
            $movementTypeId = $this->resolveMovementTypeIdFromProcess($dto->process);

            $movementId = $this->movementRepository->create([
                'created_at' => now(),
                'updated_at' => now(),

                'wallet_destination_id' => $walletDestinationId,
                'wallet_origin_id' => null, // ✅ para TASK

                'performed_by' => 'BUSINESS',      // o SYSTEM si es automático
                'performed_by_id' => $dto->performedById, // si lo tienes, sino null

                'reference_code' => $dto->referenceCode,

                'direction' => 'IN',
                'business_context_id' => $businessContextId,

                'created_source' => 'TASK',
                'amount' => (int)$dto->amount,

                'movement_type_id' => $movementTypeId,

                'description' => $this->buildTaskDescription($dto->process, (int)$dto->amount),

                'expire_at' => null, // si luego pones expiración por campaña/proceso
                'type_money' => (int)$dto->typeMoney,

                'gamification_by_process_id' => $processId,
            ]);

            return [
                'success' => true,
                'msj' => '',
                'data' => [
                    'wallet_destination_id' => $walletDestinationId,
                    'movement_id' => $movementId,
                ]
            ];
        });
    }

    private function resolveMovementTypeIdFromProcess(array $process): int
    {
        // Regla simple: si el click_type es QR => TASK_QR (13), si share => TASK_SHARE (15), etc.
        $clickTypeId = (int)($process['tracking_click_type_id'] ?? 0);

        // ids según tu tabla tracking_click_types
        // 6 = qr_scan
        // 4 = share
        // 2 = click
        // 3 = view (si usas)
        return match ($clickTypeId) {
            6 => 13, // TASK_QR
            4 => 15, // TASK_SHARE
            3 => 14, // TASK_VIEW (explorar)
            default => 12, // TASK_REWARD (general)
        };
    }

    private function buildTaskDescription(array $process, int $amount): string
    {
        $title = (string)($process['title'] ?? 'Tarea');
        $unique = (string)($process['unique_code'] ?? '');
        return "🎯 $title | +$amount YAPITAS | $unique";
    }
}
