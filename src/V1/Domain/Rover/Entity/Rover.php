<?php

declare(strict_types=1);

namespace App\V1\Domain\Rover\Entity;

use App\V1\Domain\Plateau\Entity\Plateau;
use JsonSerializable;

class Rover implements JsonSerializable
{
    public ?int $id;

    public int $plateau_id;

    public int $x;

    public int $y;

    public string $direction;

    public ?Plateau $plateau;

    public function __construct(array $attributes)
    {
        $this->id = isset($attributes['id']) ? (int) $attributes['id'] : null;
        $this->plateau_id = (int) $attributes['plateau_id'];
        $this->plateau = $attributes['plateau'] ?? null;
        $this->x = (int) $attributes['x'];
        $this->y = (int) $attributes['y'];
        $this->direction = $attributes['direction'];
    }

    /**
     * Check if the entity exists in the database.
     *
     * @return bool
     */
    public function exists(): bool
    {
        return ! is_null($this->id);
    }

    /**
     * Customize JSON representation of the entity.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id'         => $this->id,
            'plateau_id' => $this->plateau_id,
            'x'          => $this->x,
            'y'          => $this->y,
            'direction'  => $this->direction,
        ];
    }
}
