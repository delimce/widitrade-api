<?php

declare(strict_types=1);

namespace App\Api\Domain\Entity;

use Ramsey\Uuid\Uuid;
use App\Api\Domain\Dto\UserDto;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Api\Domain\Entity\UserContentInteraction;
use App\Api\Infrastructure\Repository\Orm\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "user")]

class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private string $uid;

    #[ORM\Column(length: 100)]
    private string $name;

    #[ORM\Column(length: 100)]
    private string $username;

    #[ORM\Column(length: 140)]
    private string $email;

    #[ORM\Column(length: 255)]
    private string $password;


    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: Content::class)]
    #[ORM\JoinTable(name: "user_content_owner")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    #[ORM\InverseJoinColumn(name: "content_id", referencedColumnName: "id")]
    private $contents;

    #[ORM\OneToMany(
        mappedBy: "user",
        targetEntity: UserContentInteraction::class,
        orphanRemoval: true,
        cascade: ["persist", "remove"]
    )]
    private Collection $interactions;

    public static function createFromDto(UserDto $userDto): self
    {
        $user = new self();
        $user->uid       =      Uuid::uuid4()->toString();
        $user->name      =      $userDto->getName();
        $user->username  =      $userDto->getUsername();
        $user->email     =      $userDto->getEmail();
        $user->password  =      $userDto->getPassword();
        $user->createdAt = new \DateTimeImmutable();
        return $user;
    }

    public function __construct()
    {
        $this->contents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUid(): string
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

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    # on update
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    #[PreUpdate]
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function getContents()
    {
        return $this->contents;
    }

    public function addContent(Content $content): void
    {
        $this->contents[] = $content;
    }


}
