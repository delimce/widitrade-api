<?php

declare(strict_types=1);

namespace App\Shared\Domain\Interfaces;

interface PasswordHandlerInterface
{

    public function hash(string $password): string;

    public function verify(string $password, string $hashedPassword): bool;
}
