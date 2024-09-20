<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Domain\Interfaces\PasswordHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;


class PasswordHasherHandler implements PasswordHandlerInterface
{
    private PasswordHasherFactory $passwordHasherFactory;
    public function __construct()
    {
        $this->passwordHasherFactory = new PasswordHasherFactory([
            'common'      => ['algorithm' => 'pbkdf2'],
            'memory-hard' => ['algorithm' => 'sodium'],
        ]);
    }

    public function hash(string $password): string
    {
        return $this->passwordHasherFactory->getPasswordHasher('common')->hash($password);
    }

    public function verify(string $password, string $hashedPassword): bool
    {
        return $this->passwordHasherFactory->getPasswordHasher('common')->verify($hashedPassword, $password);
    }
}
