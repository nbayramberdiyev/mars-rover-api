<?php

declare(strict_types=1);

namespace App\V1\Domain\Plateau\Entity;

use JsonSerializable;

class Plateau implements JsonSerializable
{
    public ?int $id;

    public int $x;

    public int $y;

    public function __construct(array $attributes)
    {
        $this->id = isset($attributes['id']) ? (int) $attributes['id'] : null;
        $this->x = (int) $attributes['x'];
        $this->y = (int) $attributes['y'];
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
            'id' => $this->id,
            'x'  => $this->x,
            'y'  => $this->y,
        ];
    }
}
