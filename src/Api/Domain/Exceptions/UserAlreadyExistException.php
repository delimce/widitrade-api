<?php

declare(strict_types=1);

namespace App\Api\Domain\Exceptions;

class UserAlreadyExistException extends \DomainException
{
    public function __construct(string $email, int $code = 400)
    {
        parent::__construct("User with email: $email already exist", $code);
    }
}
