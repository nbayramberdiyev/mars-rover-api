<?php

declare(strict_types=1);

namespace Tests\V1\Action\Plateau;

use App\V1\Action\Plateau\PlateauCreateAction;
use App\V1\Domain\Plateau\Repository\PlateauRepository;
use App\V1\Domain\Plateau\Service\PlateauService;
use App\V1\Responder\Responder;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Tests\TestCase;

class PlateauCreateActionTest extends TestCase
{
    protected PlateauCreateAction $plateauCreateAction;

    protected function setUp(): void
    {
        $plateauService = new PlateauService(new PlateauRepository(self::$pdo));
        $responder = new Responder(new ResponseFactory());

        $this->plateauCreateAction = new PlateauCreateAction($plateauService, $responder);
    }

    /** @test */
    public function testPlateauCreated()
    {
        // arrange
        $request = ServerRequestFactory::createFromGlobals();
        $response = (new ResponseFactory())->createResponse();
        $body = [
            'x' => 5,
            'y' => 5,
        ];

        // act
        $response = $this->plateauCreateAction->__invoke($request->withParsedBody($body), $response);

        // assert
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }
}
