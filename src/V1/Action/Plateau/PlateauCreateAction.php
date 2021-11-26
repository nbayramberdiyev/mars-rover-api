<?php

declare(strict_types=1);

namespace App\V1\Action\Plateau;

use App\V1\Domain\Plateau\Service\PlateauService;
use App\V1\Responder\Responder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PlateauCreateAction
{
    public function __construct(
        private PlateauService $plateauService,
        private Responder $responder,
    ) {}

    public function __invoke(Request $request, Response $response): Response
    {
        $plateau = $this->plateauService->create($request->getParsedBody());

        return $this->responder->json($plateau, 201, $response);
    }
}
