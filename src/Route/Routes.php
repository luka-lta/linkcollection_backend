<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Route;

use LinkCollectionBackend\Action\Page\CreatePageAction;
use LinkCollectionBackend\Action\User\AuthAction;
use LinkCollectionBackend\Action\User\RegisterAction;
use LinkCollectionBackend\Middleware\AuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

class Routes
{
    public static function getRoutes(App $app): void
    {
        $app->group('/api/v1', function (RouteCollectorProxy $group) {
           $group->group('/auth', function (RouteCollectorProxy $group) {
               $group->post('/login', [AuthAction::class, 'handleAuthAction']);
               $group->post('/register', [RegisterAction::class, 'handleRegisterAction']);
           });

              $group->group('/page', function (RouteCollectorProxy $group) {
                $group->post('/create', [CreatePageAction::class, 'handleCreatePageAction'])
                    ->add(AuthMiddleware::class);
              });
        });
    }
}