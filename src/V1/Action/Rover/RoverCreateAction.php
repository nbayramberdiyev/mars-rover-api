<?php

declare(strict_types=1);

namespace App\V1\Action\Rover;

use App\V1\Domain\Rover\Service\RoverService;
use App\V1\Responder\Responder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RoverCreateAction
{
    public function __construct(
        private RoverService $roverService,
        private Responder $responder
    ) {}

    public function __invoke(Request $request, Response $response): Response
    {
        $rover = $this->roverService->create($request->getParsedBody());

        return $this->responder->json($rover, 201, $response);
    }
}
