<?php

declare(strict_types=1);

namespace App\V1\Action\Plateau;

use App\V1\Domain\Plateau\Service\PlateauService;
use App\V1\Responder\Responder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PlateauFindAction
{
    public function __construct(
        private PlateauService $plateauService,
        private Responder $responder,
    ) {}

    public function __invoke(Request $request, Response $response, int $id): Response
    {
        if ($plateau = $this->plateauService->find($id)) {
            return $this->responder->json($plateau);
        }

        $error = [
            'message' => sprintf('Plateau does not exist with the id of %d.', $id),
        ];

        return $this->responder->json($error, 404, $response);
    }
}
