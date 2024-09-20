<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exceptions;

class InvalidTokenException extends \DomainException
{
    public function __construct(
        $message = "Invalid token",
        $code = 401
    ) {
        parent::__construct($message, $code);
    }
}
