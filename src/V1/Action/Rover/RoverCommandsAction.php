<?php

declare(strict_types=1);

namespace App\V1\Action\Rover;

use App\V1\Domain\Rover\Entity\Rover;
use App\V1\Domain\Rover\Enum\Direction;
use App\V1\Domain\Rover\Service\RoverCommandsService;
use App\V1\Domain\Rover\Service\RoverService;
use App\V1\Responder\Responder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RoverCommandsAction
{
    public function __construct(
        private RoverService $roverService,
        private RoverCommandsService $roverCommandsService,
        private Responder $responder
    ) {}

    public function __invoke(Request $request, Response $response, int $id): Response
    {
        $rover = $this->roverService->find($id);

        if (is_null($rover)) {
            $message = [
                'message' => sprintf('Rover does not exist with the id of %d.', $id),
            ];

            return $this->responder->json($message, 404, $response);
        }

        $commands = $request->getParsedBody()['commands'] ?? '';

        $rover = $this->roverCommandsService->handle($rover, $commands);

        return $this->responder->json($rover);
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
