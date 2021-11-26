<?php

declare(strict_types=1);

namespace Tests\V1\Domain\Rover\Service;

use App\V1\Domain\Plateau\Entity\Plateau;
use App\V1\Domain\Plateau\Repository\PlateauRepository;
use App\V1\Domain\Rover\Entity\Rover;
use App\V1\Domain\Rover\Enum\Direction;
use App\V1\Domain\Rover\Repository\RoverRepository;
use App\V1\Domain\Rover\Service\RoverCommandsService;
use Tests\TestCase;

class RoverCommandsServiceTest extends TestCase
{
    protected RoverCommandsService $roverCommandsService;

    protected function setUp(): void
    {
        $this->roverCommandsService = new RoverCommandsService(new RoverRepository(self::$pdo), new PlateauRepository(self::$pdo));
    }

    /** @test */
    public function testHandleRoverCommands()
    {
        // arrange
        $plateauInDb = new Plateau(self::$pdo->query('select * from `plateaus` where `id` = 1 limit 1')->fetch());
        $roverInDb = new Rover(self::$pdo->query('select * from `rovers` where `id` = 1 limit 1')->fetch());

        // act
        $rover = $this->roverCommandsService->handle($roverInDb, 'LMLMLMLMM');

        // assert
        $this->assertSame($roverInDb, $rover);
        $this->assertEquals(1, $rover->x);
        $this->assertEquals(3, $rover->y);
        $this->assertEquals(Direction::NORTH, $rover->direction);
        $this->assertTrue($plateauInDb->x >= $rover->x, 'X: Rover is not out of bounds.');
        $this->assertTrue($plateauInDb->y >= $rover->y, 'Y: Rover is not out of bounds.');
    }
}
