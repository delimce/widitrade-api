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

    public function listAll(string $filter = null): array
    {
        $qb = $this->createQueryBuilder('c');
        if (null !== $filter) {
            $qb->where('c.title LIKE :filter')->orWhere('c.description LIKE :filter')
            ->setParameter('filter', "%$filter%");
        }
        return $qb->getQuery()->getResult();
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
