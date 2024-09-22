<?php

declare(strict_types=1);

namespace App\Api\Domain\Entity;

use App\Api\Domain\Dto\MediaDto;
use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "media")]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 40)]
    private string $uid;

    #[ORM\Column(type: "string", length: 255)]
    private string $title;

    #[ORM\Column(type: "string", length: 255)]
    private string $filepath;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(targetEntity: Content::class, inversedBy: "media")]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\JoinColumn(name: 'content_id', referencedColumnName: 'id')]
    private Content $content;

    // Getters and setters...

    public static function createFromDto(MediaDto $dto): self
    {
        $media            = new self();
        $media->uid       = Uuid::uuid4()->toString();
        $media->title     = $dto->getTitle();
        $media->filepath  = $dto->getFilepath();
        $media->createdAt = new \DateTimeImmutable();
        return $media;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getFilepath(): string
    {
        return $this->filepath;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function setContent(Content $content): static
    {
        $this->content = $content;

        return $this;
    }
}
