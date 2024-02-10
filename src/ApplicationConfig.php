<?php
declare(strict_types=1);

namespace LinkCollectionBackend;

use DI\Definition\Source\Autowiring;
use DI\Definition\Source\DefinitionArray;
use Exception;
use LinkCollectionBackend\Factory\LoggerFactory;
use LinkCollectionBackend\Factory\PdoFactory;
use Monolog\Logger;
use PDO;
use function DI\factory;

class ApplicationConfig extends DefinitionArray
{
    /**
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct($this->getConfig());
    }

    public function getConfig(): array
    {
        return [
            PDO::class => factory(PdoFactory::class),
        ];
    }
}