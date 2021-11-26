<?php

declare(strict_types=1);

namespace Tests;

use PDO;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Tests\V1\Fixture as FixtureV1;

abstract class TestCase extends BaseTestCase
{
    protected static ?PDO $pdo;

    public static function setUpBeforeClass(): void
    {
        self::$pdo = new PDO(dsn: 'sqlite::memory:', options: [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        ]);

        FixtureV1::create(self::$pdo);
    }

    public static function tearDownAfterClass(): void
    {
        FixtureV1::destroy(self::$pdo);

        self::$pdo = null;
    }
}
