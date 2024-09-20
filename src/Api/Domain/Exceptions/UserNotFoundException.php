<?php

declare(strict_types=1);

namespace App\Api\Domain\Exceptions;

class UserNotFoundException extends \DomainException
{
    public function __construct(string $uid, int $code = 404)
    {
        parent::__construct("User with uid: $uid not found", $code);
    }
}
