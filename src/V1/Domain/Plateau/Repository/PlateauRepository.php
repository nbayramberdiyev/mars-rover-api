<?php

declare(strict_types=1);

namespace App\V1\Domain\Plateau\Repository;

use App\V1\Domain\Plateau\Entity\Plateau;
use PDO;

class PlateauRepository
{
    public function __construct(
        private PDO $pdo
    ) {}

    /**
     * Find a plateau by its primary key (id).
     *
     * @param  int $id
     * @return Plateau|null
     */
    public function find(int $id): ?Plateau
    {
        $stmt = $this->pdo->prepare('select * from `plateaus` where `id` = ? limit 1');
        $stmt->execute([$id]);

        if ($plateau = $stmt->fetch()) {
            return new Plateau($plateau);
        }

        return null;
    }

    /**
     * Store a newly created plateau in the database.
     *
     * @param  Plateau $plateau
     * @return bool
     */
    public function create(Plateau $plateau): bool
    {
        $stmt = $this->pdo->prepare('insert into `plateaus` (`x`, `y`) values (?, ?)');
        $stmt->execute([$plateau->x, $plateau->y]);

        if ($stmt->rowCount()) {
            $plateau->id = (int) $this->pdo->lastInsertId();
        }

        return (bool) $stmt->rowCount();
    }

    /**
     * Update the given plateau in the database.
     *
     * @param  Plateau $plateau
     * @return bool
     */
    public function update(Plateau $plateau): bool
    {
        $stmt = $this->pdo->prepare('update `plateaus` set `x` = ?, `y` = ? where `id` = ?');
        $stmt->execute([$plateau->x, $plateau->y, $plateau->id]);

        return (bool) $stmt->rowCount();
    }

    /**
     * Save the given plateau to the database.
     *
     * @param  Plateau $plateau
     * @return bool
     */
    public function save(Plateau $plateau): bool
    {
        return $plateau->exists()
            ? $this->update($plateau)
            : $this->create($plateau);
    }
}
