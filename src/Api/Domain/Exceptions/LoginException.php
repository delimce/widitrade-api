<?php

declare(strict_types=1);

namespace App\Api\Domain\Exceptions;

class LoginException extends \DomainException
{
    public function __construct(
        $message = "Invalid credentials",
        $code = 401
    ) {
        parent::__construct($message, $code);
    }

}
