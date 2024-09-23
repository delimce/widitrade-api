<?php

declare(strict_types=1);

namespace App\Api\Domain\Repository;

use App\Api\Domain\Entity\UserContentInteraction;

interface UserContentRepositoryInterface
{

    public function persist(UserContentInteraction $userContentInteraction): void;
    public function flush(): void;
}
