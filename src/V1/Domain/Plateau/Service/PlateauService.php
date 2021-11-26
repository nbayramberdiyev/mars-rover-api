<?php

declare(strict_types=1);

namespace App\V1\Domain\Plateau\Service;

use App\V1\Domain\Plateau\Entity\Plateau;
use App\V1\Domain\Plateau\Repository\PlateauRepository;

class PlateauService
{
    public function __construct(
        private PlateauRepository $plateauRepository
    ) {}

    /**
     * Find a plateau by its primary key (id).
     *
     * @param  int $id
     * @return Plateau|null
     */
    public function find(int $id): ?Plateau
    {
        return $this->plateauRepository->find($id);
    }

    /**
     * Create a new plateau and return the instance.
     *
     * @param  array $attributes
     * @return Plateau
     */
    public function create(array $attributes): Plateau
    {
        // implement validation

        $plateau = new Plateau($attributes);

        $this->plateauRepository->save($plateau);

        // handle potential exceptions

        return $plateau;
    }
}
