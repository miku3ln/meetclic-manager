<?php

namespace App\Constants;

class MeasureType
{
    public const MASS = 1;
    public const LENGTH = 2;
    public const VOLUME = 3;
    public const AREA = 4;
    public const UNIT = 5;

    public const MAP = [
        'MASA' => self::MASS,
        'LONGITUD' => self::LENGTH,
        'VOLUMEN' => self::VOLUME,
        'AREA' => self::AREA,
        'UNIDAD' => self::UNIT,
    ];
}
