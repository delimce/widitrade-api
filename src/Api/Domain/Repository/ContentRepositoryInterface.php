<?php

declare(strict_types=1);

namespace App\Api\Domain\Repository;

use App\Api\Domain\Entity\Content;

interface ContentRepositoryInterface
{
    public function persist(Content $content): void;

    public function flush(): void;

    public function listAll(string $filter = null): array;

    public function findByUid(string $uid): ?Content;

    public function remove(Content $content): void;
}
