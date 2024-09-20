<?php

declare(strict_types=1);

namespace App\Api\Domain\Exceptions;

use Throwable;


class SystemException extends \DomainException
{
    public function __construct(
        $message = "system error occurred",
        $code = 400
    ) {
        parent::__construct($message, $code);
    }
}
