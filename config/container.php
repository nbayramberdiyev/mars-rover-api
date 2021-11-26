<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseFactoryInterface;
use Slim\App;
use Slim\Psr7\Factory\ResponseFactory;

/*
|----------------------------------------------------------------------
| Register shared bindings in the DI container.
|----------------------------------------------------------------------
*/

return function (App $app): void {
    $container = $app->getContainer();

    $container->set(ResponseFactoryInterface::class, fn () => new ResponseFactory());

    $container->set(PDO::class, function () {
        return new PDO(dsn: 'sqlite:'.dirname(__DIR__).'/db.sqlite', options: [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        ]);
    });
};
