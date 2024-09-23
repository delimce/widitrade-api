<?php

declare(strict_types=1);

namespace App\Api\Domain\Entity;

use App\Api\Domain\Entity\User;
use App\Api\Domain\Entity\Content;
use App\Api\Infrastructure\Repository\Orm\UserContentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserContentRepository::class)]
class UserContentInteraction
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Content::class, inversedBy: "interactions")]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\JoinColumn(name: 'content_id', referencedColumnName: 'id')]
    private Content $content;


    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "interactions")]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;

    #[ORM\Column(type: "boolean", nullable: true)]
    private ?bool $isFavorite;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $ranked;

    public function __construct(Content $content, User $user, ?bool $isFavorite = null, ?int $ranked = null)
    {
        $this->content    = $content;
        $this->user       = $user;
        $this->isFavorite = $isFavorite;
        $this->ranked     = $ranked;
    }

    public function setRanked(int $ranked): void
    {
        $this->ranked = $ranked;
    }

    public function setIsFavorite(bool $isFavorite): void
    {
        $this->isFavorite = $isFavorite;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getIsFavorite(): ?bool
    {
        return $this->isFavorite;
    }

    public function getRanked(): ?int
    {
        return $this->ranked;
    }
}
