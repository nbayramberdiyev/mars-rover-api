<?php

declare(strict_types=1);

namespace App\V1\Action\Rover;

use App\V1\Domain\Rover\Service\RoverService;
use App\V1\Responder\Responder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RoverFindAction
{
    public function __construct(
        private RoverService $roverService,
        private Responder $responder
    ) {}

    public function __invoke(Request $request, Response $response, int $id): Response
    {
        if ($rover = $this->roverService->find($id)) {
            return $this->responder->json($rover);
        }

        $error = [
            'message' => sprintf('Rover does not exist with the id of %d.', $id),
        ];

        return $this->responder->json($error, 404, $response);
    }
}
