<?php

declare(strict_types=1);

namespace App\V1\Domain\Rover\Repository;

use App\V1\Domain\Rover\Entity\Rover;
use PDO;

class RoverRepository
{
    public function __construct(
        private PDO $pdo
    ) {}

    /**
     * Find a rover by its primary key (id).
     *
     * @param  int $id
     * @return Rover|null
     */
    public function find(int $id): ?Rover
    {
        $stmt = $this->pdo->prepare('select * from `rovers` where `id` = ? limit 1');
        $stmt->execute([$id]);

        if ($rover = $stmt->fetch()) {
            return new Rover($rover);
        }

        return null;
    }

    /**
     * Store a newly created rover in the database.
     *
     * @param  Rover $rover
     * @return bool
     */
    public function create(Rover $rover): bool
    {
        $stmt = $this->pdo->prepare('insert into `rovers` (`plateau_id`, `x`, `y`, `direction`) values (?, ?, ?, ?)');
        $stmt->execute([$rover->plateau_id, $rover->x, $rover->y, $rover->direction]);

        if ($stmt->rowCount()) {
            $rover->id = (int) $this->pdo->lastInsertId();
        }

        return (bool) $stmt->rowCount();
    }

    /**
     * Update the given rover in the database.
     *
     * @param  Rover $rover
     * @return bool
     */
    public function update(Rover $rover): bool
    {
        $stmt = $this->pdo->prepare('update `rovers` set `plateau_id` = ?, `x` = ?, `y` = ?, `direction` = ? where `id` = ?');
        $stmt->execute([$rover->plateau_id, $rover->x, $rover->y, $rover->direction, $rover->id]);

        return (bool) $stmt->rowCount();
    }

    /**
     * Save the given rover to the database.
     *
     * @param  Rover $rover
     * @return bool
     */
    public function save(Rover $rover): bool
    {
        return $rover->exists()
            ? $this->update($rover)
            : $this->create($rover);
    }
}
