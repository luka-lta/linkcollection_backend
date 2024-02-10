<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Route;

use LinkCollectionBackend\Action\Link\CreateLinkAction;
use LinkCollectionBackend\Action\Page\CreatePageAction;
use LinkCollectionBackend\Action\Page\GetPagesFromUserAction;
use LinkCollectionBackend\Action\User\AuthAction;
use LinkCollectionBackend\Action\User\RefreshTokenAction;
use LinkCollectionBackend\Action\User\RegisterAction;
use LinkCollectionBackend\Middleware\AuthMiddleware;
use LinkCollectionBackend\Middleware\PreflightMiddleware;
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
                $group->post('/refreshToken', [RefreshTokenAction::class, 'handleRefreshTokenAction']);
            });

            $group->group('/page', function (RouteCollectorProxy $group) {
                $group->post('/create', [CreatePageAction::class, 'handleCreatePageAction'])
                    ->add(AuthMiddleware::class);
                $group->get('/get', [GetPagesFromUserAction::class, 'handleGetPagesFromUser'])
                    ->add(AuthMiddleware::class);
            });

            $group->group('/link', function (RouteCollectorProxy $group) {
                $group->post('/create', [CreateLinkAction::class, 'handleCreateLinkAction'])
                    ->add(AuthMiddleware::class);
            });
        });
    }
}