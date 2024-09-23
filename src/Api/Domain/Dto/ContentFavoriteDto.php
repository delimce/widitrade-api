<?php

declare(strict_types=1);

namespace App\Api\Domain\Dto;

use App\Shared\Infrastructure\BaseDto;
use Symfony\Component\Validator\Constraints as Assert;

class ContentFavoriteDto extends BaseDto
{
    #[Assert\Uuid]
    protected string $contentUid;

    #[Assert\Uuid]
    protected string $userUid;

    public function getContentUid(): string
    {
        return $this->contentUid;
    }

    public function getUserUid(): string
    {
        return $this->userUid;
    }
}
