<?php

declare(strict_types=1);

use App\V1\Action\Plateau\PlateauCreateAction;
use App\V1\Action\Plateau\PlateauFindAction;
use App\V1\Action\Rover\RoverCommandsAction;
use App\V1\Action\Rover\RoverCreateAction;
use App\V1\Action\Rover\RoverFindAction;
use App\V1\Middleware\JsonBodyParserMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

/*
|----------------------------------------------------------------------
| Register routes.
|----------------------------------------------------------------------
*/

return function (App $app): void {
    // V1 routes
    $app->group('/v1', function (RouteCollectorProxy $group) {
        $group->post('/plateaus', PlateauCreateAction::class);
        $group->get('/plateaus/{id:[0-9]+}', PlateauFindAction::class);

        $group->post('/rovers', RoverCreateAction::class);
        $group->get('/rovers/{id:[0-9]+}', RoverFindAction::class);
        $group->post('/rovers/{id:[0-9]+}/commands', RoverCommandsAction::class);
    })->add(JsonBodyParserMiddleware::class);
};
