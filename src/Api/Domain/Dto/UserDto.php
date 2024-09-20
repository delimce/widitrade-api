<?php

declare(strict_types=1);

namespace App\Api\Domain\Dto;

use App\Shared\Infrastructure\BaseDto;
use Symfony\Component\Validator\Constraints as Assert;


class UserDto extends BaseDto
{
    #[Assert\Uuid]
    protected ?string $uid = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 100)]
    protected string $name;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    protected string $username;

    #[Assert\NotBlank]
    #[Assert\Email]
    protected string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 6, max: 50)]
    protected string $password;


    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return strtolower($this->email);
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
