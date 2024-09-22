<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Repository\Orm;

use App\Api\Domain\Entity\Content;
use Doctrine\Persistence\ManagerRegistry;
use App\Api\Domain\Repository\ContentRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ContentRepository extends ServiceEntityRepository implements ContentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Content::class);
    }

    public function persist(Content $content): void
    {
        $this->getEntityManager()->persist($content);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function findByCriteria(array $criteria, ?array $orderBy = null): array
    {
        return parent::findBy($criteria, $orderBy);
    }

    public function findByUid(string $uid): ?Content
    {
        return $this->findOneBy(['uid' => $uid]);
    }

    public function remove(Content $content): void
    {
        $this->getEntityManager()->remove($content);
    }
}
