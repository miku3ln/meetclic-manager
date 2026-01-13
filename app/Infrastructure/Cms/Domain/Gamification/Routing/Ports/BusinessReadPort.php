<?php

namespace App\Infrastructure\Cms\Domain\Gamification\Routing\Ports;

interface BusinessReadPort
{
    /**
     * Retorna un array mínimo con los campos que necesitas, o null si no existe.
     * Ej: ['id'=>1,'title'=>'MEETCLIC']
     */
    public function findById(string|int $value,string $fieldComparate): ?array;
}
