<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Factory;

use DI\Container;
use DI\ContainerBuilder;
use Exception;
use LinkCollectionBackend\ApplicationConfig;

class ContainerFactory
{
    /**
     * @throws Exception
     */
    public static function buildContainer(): Container
    {
        $container = new ContainerBuilder();
        $container->useAutowiring(true);
        $container->addDefinitions(new ApplicationConfig());
        return $container->build();
    }
}