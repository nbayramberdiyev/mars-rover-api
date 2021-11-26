<?php

declare(strict_types=1);

namespace Tests\V1\Domain\Rover\Service;

use App\V1\Domain\Rover\Entity\Rover;
use App\V1\Domain\Rover\Enum\Direction;
use App\V1\Domain\Rover\Repository\RoverRepository;
use App\V1\Domain\Rover\Service\RoverService;
use Tests\TestCase;

class RoverServiceTest extends TestCase
{
    protected RoverService $roverService;

    protected function setUp(): void
    {
        $this->roverService = new RoverService(new RoverRepository(self::$pdo));
    }

    /** @test */
    public function testFindRover()
    {
        // arrange
        $idExists = 1;
        $idDoesntExist = 99;

        // act
        $roverExists = $this->roverService->find($idExists);
        $roverDoesntExist = $this->roverService->find($idDoesntExist);

        // assert
        $this->assertInstanceOf(Rover::class, $roverExists);
        $this->assertEquals($idExists, $roverExists->id);
        $this->assertNotInstanceOf(Rover::class, $roverDoesntExist);
        $this->assertNull($roverDoesntExist);
    }

    /** @test */
    public function testCreateRover()
    {
        // arrange
        $attributes = [
            'plateau_id' => 1,
            'x'          => 2,
            'y'          => 3,
            'direction'  => Direction::NORTH,
        ];

        // act
        $rover = $this->roverService->create($attributes);

        // assert
        $this->assertInstanceOf(Rover::class, $rover);
        $this->assertTrue($rover->exists());
        $this->assertIsInt($rover->id);
        $this->assertEquals($attributes['x'], $rover->x);
        $this->assertEquals($attributes['y'], $rover->y);
        $this->assertEquals($attributes['direction'], $rover->direction);
    }
}
