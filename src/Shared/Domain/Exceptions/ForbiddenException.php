<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exceptions;

class ForbiddenException extends \DomainException
{
    public function __construct(
        $message = "Forbidden",
        $code = 403
    ) {
        parent::__construct($message, $code);
    }
}
