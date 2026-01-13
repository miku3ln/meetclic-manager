<?php

final class DepositTaskRewardCommand
{
    public function __construct(
        public readonly int    $userId,
        public readonly int    $amount,
        public readonly int    $typeMoney, // 0=BEE, 1=QUEEN
        public readonly int    $gamificationByProcessId,
        public readonly array  $processArray, // el registro completo (ya validado)
        public readonly string $performedBy = 'BUSINESS', // o SYSTEM
        public readonly ?int   $performedById = null
    )
    {
    }
}

?>
