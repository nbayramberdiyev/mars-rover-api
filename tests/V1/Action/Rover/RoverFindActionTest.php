<?php

declare(strict_types=1);

namespace Tests\V1\Action\Rover;

use App\V1\Action\Rover\RoverFindAction;
use App\V1\Domain\Rover\Repository\RoverRepository;
use App\V1\Domain\Rover\Service\RoverService;
use App\V1\Responder\Responder;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Tests\TestCase;

class RoverFindActionTest extends TestCase
{
    protected RoverFindAction $roverFindAction;

    protected function setUp(): void
    {
        $roverService = new RoverService(new RoverRepository(self::$pdo));
        $responder = new Responder(new ResponseFactory());

        $this->roverFindAction = new RoverFindAction($roverService, $responder);
    }

    /** @test */
    public function testRoverFound()
    {
        // arrange
        $request = ServerRequestFactory::createFromGlobals();
        $response = (new ResponseFactory())->createResponse();

        // act
        $response = $this->roverFindAction->__invoke($request, $response, 1);

        // assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }

    /** @test */
    public function testRoverNotFound()
    {
        // arrange
        $request = ServerRequestFactory::createFromGlobals();
        $response = (new ResponseFactory())->createResponse();

        // act
        $response = $this->roverFindAction->__invoke($request, $response, 99);

        // assert
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }
}
