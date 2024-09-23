<?php

declare(strict_types=1);

namespace App\Api\Domain\Repository;

use App\Api\Domain\Entity\Content;
use App\Api\Domain\Entity\User;
use App\Api\Domain\Entity\UserContentInteraction;

interface UserContentRepositoryInterface
{

    public function persist(UserContentInteraction $userContentInteraction): void;
    public function flush(): void;
    public function getByContentAndUser(Content $content, User $user): ?UserContentInteraction;
}
