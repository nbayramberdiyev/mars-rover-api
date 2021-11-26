<?php

declare(strict_types=1);

namespace Tests\V1\Action\Rover;

use App\V1\Action\Rover\RoverCommandsAction;
use App\V1\Domain\Plateau\Repository\PlateauRepository;
use App\V1\Domain\Rover\Repository\RoverRepository;
use App\V1\Domain\Rover\Service\RoverCommandsService;
use App\V1\Domain\Rover\Service\RoverService;
use App\V1\Responder\Responder;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Tests\TestCase;

class RoverCommandsActionTest extends TestCase
{
    protected RoverCommandsAction $roverCommandsAction;

    protected function setUp(): void
    {
        $roverRepository = new RoverRepository(self::$pdo);
        $plateauRepository = new PlateauRepository(self::$pdo);
        $roverService = new RoverService($roverRepository);
        $roverCommandsService = new RoverCommandsService($roverRepository, $plateauRepository);
        $responder = new Responder(new ResponseFactory());

        $this->roverCommandsAction = new RoverCommandsAction($roverService, $roverCommandsService, $responder);
    }

    /** @test */
    public function testPlateauCreated()
    {
        // arrange
        $request = ServerRequestFactory::createFromGlobals();
        $response = (new ResponseFactory())->createResponse();
        $body = [
            'commands' => 'LMLMLMLMM',
        ];

        // act
        $response = $this->roverCommandsAction->__invoke($request->withParsedBody($body), $response, 1);

        // assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }
}
