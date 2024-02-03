<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Factory;

use PDO;

class PdoFactory
{
    public function __invoke(): PDO
    {
        $host = 'backend-linkcollection';
        $port = 3306;
        $database = 'linkcollection_backend';
        $username = 'testing';
        $password = '1234';

        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s', $host, $port, $database);
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $pdo;
    }
}