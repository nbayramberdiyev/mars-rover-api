<?php

declare(strict_types=1);

namespace App\V1\Responder;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;

/**
 * Generic Responder
 */
class Responder
{
    public function __construct(
        private ResponseFactory $responseFactory
    ) {}

    /**
     * Create a JSON response.
     *
     * @param  mixed         $data
     * @param  int           $status
     * @param  Response|null $response
     * @return Response
     */
    public function json(mixed $data, int $status = 200, ?Response $response = null): Response
    {
        $response ??= $this->responseFactory->createResponse();

        $response->getBody()->write(json_encode($data));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }

    /**
     * Create a redirect response.
     *
     * @param  string        $location
     * @param  int           $status
     * @param  Response|null $response
     * @return Response
     */
    public function redirect(string $location, int $status = 301, ?Response $response = null): Response
    {
        $response ??= $this->responseFactory->createResponse();

        return $response
            ->withHeader('Location', $location)
            ->withStatus($status);
    }
}
