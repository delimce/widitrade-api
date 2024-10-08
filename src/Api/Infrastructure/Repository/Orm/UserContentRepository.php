<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Repository\Orm;

use App\Api\Domain\Entity\User;
use App\Api\Domain\Entity\Content;
use Doctrine\Persistence\ManagerRegistry;
use App\Api\Domain\Entity\UserContentInteraction;
use App\Api\Domain\Repository\UserContentRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UserContentRepository extends ServiceEntityRepository implements UserContentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserContentInteraction::class);
    }

    public function persist(UserContentInteraction $userContentInteraction): void
    {
        $this->getEntityManager()->persist($userContentInteraction);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function getByContentAndUser(Content $content, User $user): ?UserContentInteraction
    {
        return $this->findOneBy([
            'content' => $content,
            'user'    => $user
        ]);
    }
}
