<?php

declare(strict_types=1);

namespace App\Api\Domain\Entity;

use Ramsey\Uuid\Uuid;
use App\Api\Domain\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use App\Api\Domain\Dto\ContentDto;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Api\Infrastructure\Repository\Orm\ContentRepository;

#[ORM\Entity(repositoryClass: ContentRepository::class)]
#[ORM\Table(name: "content")]
class Content
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 40)]
    private string $uid;

    #[ORM\Column(type: "string", length: 255)]
    private string $title;

    #[ORM\Column(type: "text")]
    private string $description;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    #[ORM\OneToMany(
        mappedBy: "content",
        targetEntity: Media::class,
        orphanRemoval: true,
        cascade: ["persist", "remove"]
    )]
    private Collection $media;

    public function __construct()
    {
        $this->media = new ArrayCollection();
    }

    public static function createFromDto(ContentDto $dto): self
    {
        $content              = new self();
        $content->uid         = Uuid::uuid4()->toString();
        $content->title       = $dto->getTitle();
        $content->description = $dto->getDescription();
        $content->createdAt   = new \DateTimeImmutable();

        foreach ($dto->getMedia() as $mediaDto) {
            $media = Media::createFromDto($mediaDto);
            $content->addMedia($media);
        }

        return $content;
    }


    // Getters and setters...

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

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function getMedia(): array
    {
        return $this->media->toArray();
    }

    public function addMedia(Media $media): static
    {
        if (!$this->media->contains($media)) {
            $this->media->add($media);
            $media->setContent($this);
        }

        return $this;
    }

    public function removeAllMedia(): static
    {
        foreach ($this->media as $media) {
            $this->media->removeElement($media);
        }

        return $this;
    }
}
