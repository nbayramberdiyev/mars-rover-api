<?php

declare(strict_types=1);

namespace App\V1\Domain\Rover\Service;

use App\V1\Domain\Plateau\Repository\PlateauRepository;
use App\V1\Domain\Rover\Entity\Rover;
use App\V1\Domain\Rover\Enum\Direction;
use App\V1\Domain\Rover\Repository\RoverRepository;

class RoverCommandsService
{
    public function __construct(
        private RoverRepository $roverRepository,
        private PlateauRepository $plateauRepository
    ) {}

    /**
     * Handle the commands sent to the given rover.
     *
     * @param  Rover $rover
     * @param  string $commands
     * @return Rover
     */
    public function handle(Rover $rover, string $commands): Rover
    {
        // implement validation

        $plateau = $this->plateauRepository->find($rover->plateau_id);

        foreach (str_split($commands) as $command) {
            if ($command === 'L' || $command === 'R') {
                $rover->direction = $this->turn($rover, $command);
            } elseif ($command === 'M') {
                ['x' => $x, 'y' => $y] = $this->move($rover);
                $rover->x = $this->outOfBounds($x, $plateau->x) ? $rover->x : $x;
                $rover->y = $this->outOfBounds($y, $plateau->y) ? $rover->y : $y;
            }
        }

        $this->roverRepository->save($rover);

        // handle potential exceptions

        return $rover;
    }

    /**
     * Turn left or right and return new direction of the given rover.
     *
     * @param  Rover  $rover
     * @param  string $command
     * @return string
     */
    private function turn(Rover $rover, string $command): string
    {
        if ($command === 'L') {
            // Turn left
            return match ($rover->direction) {
                Direction::NORTH => Direction::WEST,
                Direction::EAST  => Direction::NORTH,
                Direction::SOUTH => Direction::EAST,
                Direction::WEST  => Direction::SOUTH,
            };
        }

        // Turn right
        return match ($rover->direction) {
            Direction::NORTH => Direction::EAST,
            Direction::EAST  => Direction::SOUTH,
            Direction::SOUTH => Direction::WEST,
            Direction::WEST  => Direction::NORTH,
        };
    }

    /**
     * Move forward one grid and return new location (x, y) of the given rover.
     *
     * @param  Rover $rover
     * @return array
     */
    private function move(Rover $rover): array
    {
        return match ($rover->direction) {
            Direction::NORTH => ['x' => $rover->x, 'y' => $rover->y + 1],
            Direction::EAST  => ['x' => $rover->x + 1, 'y' => $rover->y],
            Direction::SOUTH => ['x' => $rover->x, 'y' => $rover->y - 1],
            Direction::WEST  => ['x' => $rover->x - 1, 'y' => $rover->y],
        };
    }

    /**
     * Determine if the rover coordinate (x, y) is out of the grid.
     *
     * @param  int $roverCoordinate
     * @param  int $plateauCoordinate
     * @return bool
     */
    private function outOfBounds(int $roverCoordinate, int $plateauCoordinate): bool
    {
        if ($roverCoordinate < 0) {
            return true;
        }

        return $roverCoordinate > $plateauCoordinate;
    }
}
