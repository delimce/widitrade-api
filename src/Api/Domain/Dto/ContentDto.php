<?php

declare(strict_types=1);

namespace App\Api\Domain\Dto;

use App\Shared\Infrastructure\BaseDto;
use Symfony\Component\Validator\Constraints as Assert;

class ContentDto extends BaseDto
{
    #[Assert\Uuid]
    protected ?string $uid = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 120)]
    protected string $title;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    protected string $description;

    protected array $media;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->media = [];

        $rawMedia = $data['media'] ?? [];
        foreach ($rawMedia as $media) {
            $this->media[] = new MediaDto($media);
        }
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getMedia(): array
    {
        return $this->media;
    }
}
