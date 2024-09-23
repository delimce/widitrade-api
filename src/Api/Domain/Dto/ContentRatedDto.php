<?php

declare(strict_types=1);

namespace App\Api\Domain\Dto;

use App\Shared\Infrastructure\BaseDto;
use Symfony\Component\Validator\Constraints as Assert;

class ContentRatedDto extends BaseDto
{
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    #[Assert\Range(min: 1, max: 5)]
    protected mixed $rate;

    #[Assert\Uuid]
    protected string $contentUid;

    #[Assert\Uuid]
    protected string $userUid;

    public function getRate(): int
    {
        return $this->rate;
    }

    public function getContentUid(): string
    {
        return $this->contentUid;
    }

    public function getUserUid(): string
    {
        return $this->userUid;
    }
}
