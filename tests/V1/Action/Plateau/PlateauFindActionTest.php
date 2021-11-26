<?php

declare(strict_types=1);

namespace Tests\V1\Action\Plateau;

use App\V1\Action\Plateau\PlateauFindAction;
use App\V1\Domain\Plateau\Repository\PlateauRepository;
use App\V1\Domain\Plateau\Service\PlateauService;
use App\V1\Responder\Responder;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Tests\TestCase;

class PlateauFindActionTest extends TestCase
{
    protected PlateauFindAction $plateauFindAction;

    protected function setUp(): void
    {
        $plateauService = new PlateauService(new PlateauRepository(self::$pdo));
        $responder = new Responder(new ResponseFactory());


        $this->plateauFindAction = new PlateauFindAction($plateauService, $responder);
    }

    /** @test */
    public function testPlateauFound()
    {
        // arrange
        $request = ServerRequestFactory::createFromGlobals();
        $response = (new ResponseFactory())->createResponse();

        // act
        $response = $this->plateauFindAction->__invoke($request, $response, 1);

        // assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }

    /** @test */
    public function testPlateauNotFound()
    {
        // arrange
        $request = ServerRequestFactory::createFromGlobals();
        $response = (new ResponseFactory())->createResponse();

        // act
        $response = $this->plateauFindAction->__invoke($request, $response, 99);

        // assert
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }
}
