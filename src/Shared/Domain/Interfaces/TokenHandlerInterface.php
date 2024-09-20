<?php

declare(strict_types=1);

namespace App\Shared\Domain\Interfaces;

interface TokenHandlerInterface
{
    public function encode(array $data): string;
    public function decode(string $token): array;
}
