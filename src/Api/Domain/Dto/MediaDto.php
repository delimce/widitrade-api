<?php

declare(strict_types=1);

namespace App\Api\Domain\Dto;

use App\Shared\Infrastructure\BaseDto;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class MediaDto extends BaseDto
{
    #[Assert\Uuid]
    protected ?string $uid = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 120)]
    protected string $title;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    protected string $filepath;


    public function getTitle(): string
    {
        return $this->title;
    }

    public function getFilepath(): string
    {
        return $this->filepath;
    }

    static public function showDetail(array $medias): array
    {
        $result = [];
        foreach ($medias as $media) {
            $result[] = [
                'title'    => $media->getTitle(),
                'filepath' => $media->getFilepath(),
            ];
        }
        return $result;
    }
}
