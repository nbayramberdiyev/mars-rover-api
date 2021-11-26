<?php

declare(strict_types=1);

namespace Tests\V1\Domain\Plateau\Service;

use App\V1\Domain\Plateau\Entity\Plateau;
use App\V1\Domain\Plateau\Repository\PlateauRepository;
use App\V1\Domain\Plateau\Service\PlateauService;
use Tests\TestCase;

class PlateauServiceTest extends TestCase
{
    protected PlateauService $plateauService;

    protected function setUp(): void
    {
        $this->plateauService = new PlateauService(new PlateauRepository(self::$pdo));
    }

    /** @test */
    public function testFindPlateau()
    {
        // arrange
        $idExists = 1;
        $idDoesntExist = 99;

        // act
        $plateauExists = $this->plateauService->find($idExists);
        $plateauDoesntExist = $this->plateauService->find($idDoesntExist);

        // assert
        $this->assertInstanceOf(Plateau::class, $plateauExists);
        $this->assertEquals($idExists, $plateauExists->id);
        $this->assertNotInstanceOf( Plateau::class, $plateauDoesntExist);
        $this->assertNull($plateauDoesntExist);
    }

    /** @test */
    public function testCreatePlateau()
    {
        // arrange
        $attributes = [
            'x' => 6,
            'y' => 6,
        ];

        // act
        $plateau = $this->plateauService->create($attributes);

        // assert
        $this->assertInstanceOf(Plateau::class, $plateau);
        $this->assertTrue($plateau->exists());
        $this->assertIsInt($plateau->id);
        $this->assertEquals($attributes['x'], $plateau->x);
        $this->assertEquals($attributes['y'], $plateau->y);
    }
}
