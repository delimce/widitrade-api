<?php

declare(strict_types=1);

namespace App\Api\Application\User;

use App\Api\Domain\Exceptions\UserNotFoundException;
use App\Api\Domain\Repository\UserRepositoryInterface;


class UserDetailService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(string $uid): array
    {
        $user = $this->userRepository->findByUid($uid);

        if (!$user) {
            throw new UserNotFoundException($uid);
        }

        return [
            'uid'      => $user->getUid(),
            'name'     => $user->getName(),
            'username' => $user->getUsername(),
            'email'    => $user->getEmail(),
            'created'  => $user->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated'  => $user->getUpdatedAt()?->format('Y-m-d H:i:s'),
            'ts'       => time(),
        ];
    }
}
