<?php

declare(strict_types=1);

namespace App\Api\Application\User;

use App\Api\Domain\Dto\UserDto;
use App\Api\Domain\Entity\User;
use App\Api\Domain\Exceptions\UserNotFoundException;
use App\Api\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Interfaces\PasswordHandlerInterface;

readonly class UserUpdateService
{

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordHandlerInterface $passwordHasher,
    ) {}

    public function execute(string $uid, UserDto $userDto): void
    {
        /** @var User $user */
        $user = $this->userRepository->findByUid($uid);

        if (!$user) {
            throw new UserNotFoundException($uid);
        }

        $user->setName($userDto->getName());
        $user->setUsername($userDto->getUsername());
        $user->setEmail($userDto->getEmail()); //@todo: verified new email does not exist in the database

        # hash password
        $passwordEncrypted = $this->passwordHasher->hash($userDto->getPassword());
        $user->setPassword($passwordEncrypted);
        
        $user->setUpdatedAt();

        $this->userRepository->persist($user);
        $this->userRepository->flush();
    }
}
