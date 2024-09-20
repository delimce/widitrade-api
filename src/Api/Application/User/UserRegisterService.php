<?php

declare(strict_types=1);

namespace App\Api\Application\User;

use App\Api\Domain\Dto\UserDto;
use App\Api\Domain\Entity\User;
use App\Api\Domain\Repository\UserRepositoryInterface;

use App\Shared\Domain\Interfaces\TokenHandlerInterface;
use App\Shared\Domain\Interfaces\PasswordHandlerInterface;
use App\Api\Domain\Exceptions\UserAlreadyExistException;

class UserRegisterService
{

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordHandlerInterface $passwordHasher,
        private TokenHandlerInterface $tokenHandler
    ) {}


    /**
     * @param UserDto $user
     * @return array
     * @throws UserAlreadyExistException
     */
    public function execute(UserDto $user): array
    {
        $userEntity = User::createFromDto($user);

        # validate email does not exist
        $userExist = $this->userRepository->findOneBy(['email' => $userEntity->getEmail()]);
        if ($userExist) {
            throw new UserAlreadyExistException($userEntity->getEmail());
        }

        # hash password
        $passwordEncrypted = $this->passwordHasher->hash($userEntity->getPassword());
        $userEntity->setPassword($passwordEncrypted);


        $this->userRepository->persist($userEntity);
        $this->userRepository->flush();

        return [
            'uid'      => $userEntity->getUid(),
            'email'    => $userEntity->getEmail(),
            'username' => $userEntity->getUsername(),
            'ts'       => time(),
        ];
    }
}
