<?php

declare(strict_types=1);

namespace Tests\V1;

use PDO;

class Fixture
{
    public static function create(PDO $pdo): void
    {
        // Plateaus
        $pdo->exec('
            create table `plateaus` (
                `id` integer primary key autoincrement,
                `x` integer not null,
                `y` integer not null
            )
        ');

        $pdo->exec('insert into `plateaus` (`x`, `y`) values (5, 5)');

        // Rovers
        $pdo->exec('
            create table `rovers` (
                `id` integer primary key autoincrement,
                `plateau_id` integer not null references `plateaus` on update cascade on delete cascade,
                `x` integer not null,
                `y` integer not null,
                `direction` text not null
            )
        ');

        $pdo->exec('insert into `rovers` (`plateau_id`, `x`, `y`, `direction`) values (1, 1, 2, "N")');
    }

    public static function destroy(PDO $pdo): void
    {
        $pdo->exec('drop table if exists `rovers`');
        $pdo->exec('drop table if exists `plateaus`');
    }
}
