<?php

declare(strict_types=1);

namespace App\V1\Domain\Rover\Service;

use App\V1\Domain\Rover\Entity\Rover;
use App\V1\Domain\Rover\Repository\RoverRepository;

class RoverService
{
    public function __construct(
        private RoverRepository $roverRepository
    ) {}

    /**
     * Find a rover by its primary key (id).
     *
     * @param  int $id
     * @return Rover|null
     */
    public function find(int $id): ?Rover
    {
        return $this->roverRepository->find($id);
    }

    /**
     * Create a new rover and return the instance.
     *
     * @param  array $attributes
     * @return Rover
     */
    public function create(array $attributes): Rover
    {
        // implement validation

        $rover = new Rover($attributes);

        $this->roverRepository->save($rover);

        // handle potential exceptions

        return $rover;
    }

    /**
     * Update the given rover in the database.
     *
     * @param  Rover $rover
     * @return bool
     */
    public function update(Rover $rover): bool
    {
        // handle potential exceptions

        return $this->roverRepository->update($rover);
    }
}
