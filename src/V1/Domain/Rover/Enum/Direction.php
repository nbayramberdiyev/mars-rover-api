<?php

namespace App\V1\Domain\Rover\Enum;

final class Direction
{
    public const NORTH = 'N';
    public const EAST  = 'E';
    public const SOUTH = 'S';
    public const WEST  = 'W';

    public static function toArray(): array
    {
        return [
            'NORTH' => self::NORTH,
            'EAST'  => self::EAST,
            'SOUTH' => self::SOUTH,
            'WEST'  => self::WEST,
        ];
    }
}
