<?php

declare(strict_types=1);

namespace Tests\V1\Action\Rover;

use App\V1\Action\Rover\RoverCreateAction;
use App\V1\Domain\Rover\Enum\Direction;
use App\V1\Domain\Rover\Repository\RoverRepository;
use App\V1\Domain\Rover\Service\RoverService;
use App\V1\Responder\Responder;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Tests\TestCase;

class RoverCreateActionTest extends TestCase
{
    protected RoverCreateAction $roverCreateAction;

    protected function setUp(): void
    {
        $roverService = new RoverService(new RoverRepository(self::$pdo));
        $responder = new Responder(new ResponseFactory());

        $this->roverCreateAction = new RoverCreateAction($roverService, $responder);
    }

    /** @test */
    public function testPlateauCreated()
    {
        // arrange
        $request = ServerRequestFactory::createFromGlobals();
        $response = (new ResponseFactory())->createResponse();
        $body = [
            'plateau_id' => 1,
            'x'          => 0,
            'y'          => 0,
            'direction'  => Direction::NORTH,
        ];

        // act
        $response = $this->roverCreateAction->__invoke($request->withParsedBody($body), $response);

        // assert
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }
}
