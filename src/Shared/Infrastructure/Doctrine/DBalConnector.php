<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use Doctrine\DBAL\Connection;
use App\Shared\Domain\Interfaces\DatabaseConnectorInterface;
use Doctrine\Persistence\ManagerRegistry;

class DBalConnector implements DatabaseConnectorInterface
{

    public function __construct(
        private ManagerRegistry $managerRegistry,
        private Connection $connection
    ) {
        $defaultConnection = $managerRegistry->getDefaultConnectionName();
        $this->connection = $managerRegistry->getConnection($defaultConnection);
    }


    public function isConnected(): bool
    {
        $this->connection->executeQuery('SELECT 1');
        return $this->connection->isConnected();
    }

    public function setConnection(string $connection): void
    {
        $this->connection = $this->managerRegistry->getConnection($connection);
    }
}
