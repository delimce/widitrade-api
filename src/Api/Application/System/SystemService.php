<?php

declare(strict_types=1);

namespace App\Api\Application\System;


use App\Api\Domain\Exceptions\SystemException;
use App\Shared\Domain\Interfaces\DatabaseConnectorInterface;

class SystemService
{
    public function __construct(
        private DatabaseConnectorInterface $databaseConnector
    ) {}

    public function execute(): void
    {

        // check database connection
        if (!$this->databaseConnector->isConnected()) {
            throw new SystemException("database connection failed");
        }
    }

    public function getDatetime(): string
    {
        return date('Y-m-d H:i:s');
    }
}
