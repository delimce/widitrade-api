<?php

declare(strict_types=1);

namespace App\Api\Domain\Repository;

use App\Api\Domain\Entity\User;

interface UserRepositoryInterface
{

    public function persist(User $user): void;

    public function flush(): void;

    public function findOneBy(array $criteria, array $orderBy = null): ?User;

    public function findByUid(string $uid): ?User;
}
