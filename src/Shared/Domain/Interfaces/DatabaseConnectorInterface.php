<?php

declare(strict_types=1);

namespace App\Shared\Domain\Interfaces;

interface DatabaseConnectorInterface
{

    public function isConnected(): bool;
    public function setConnection(string $connection): void;
}
