<?php

declare(strict_types=1);

namespace App\Api\Domain\Dto;

use App\Shared\Infrastructure\BaseDto;
use Symfony\Component\Validator\Constraints as Assert;

class LoginDto extends BaseDto
{
    #[Assert\NotBlank]
    #[Assert\Email]
    protected string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 6, max: 50)]
    protected string $password;

    protected string $ipAddress = '';
    protected string $client = '';

    public function getEmail(): string
    {
        return strtolower($this->email);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setIpAddress(string $ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    public function setClient(string $client): void
    {
        $this->client = $client;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function getClient(): string
    {
        return $this->client;
    }

}
