<?php

use DI\Bridge\Slim\Bridge;
use LinkCollectionBackend\Factory\ContainerFactory;
use LinkCollectionBackend\Middleware\PreflightMiddleware;
use LinkCollectionBackend\Route\Routes;

require __DIR__ . '/../vendor/autoload.php';

try {
    $container = ContainerFactory::buildContainer();
    $app = Bridge::create($container);

    if (getenv('APP_ENV') === 'development') {
        $app->addErrorMiddleware(true, true, true);
    }
    $app->addBodyParsingMiddleware();
    $app->add(new PreflightMiddleware());
    Routes::getRoutes($app);

    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
