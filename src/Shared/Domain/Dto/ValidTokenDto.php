<?php

declare(strict_types=1);

namespace App\Shared\Domain\Dto;

use App\Shared\Infrastructure\BaseDto;

class ValidTokenDto extends BaseDto
{
    protected string $uid;
    protected string $email;
    protected int $created;

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCreated(): int
    {
        return $this->created;
    }
}
