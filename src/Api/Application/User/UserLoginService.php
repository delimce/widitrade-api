<?php

declare(strict_types=1);

namespace App\Api\Application\User;

use App\Api\Domain\Dto\LoginDto;
use App\Shared\Domain\Dto\ValidTokenDto;
use App\Api\Domain\Exceptions\LoginException;
use App\Api\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Interfaces\TokenHandlerInterface;
use App\Shared\Domain\Interfaces\PasswordHandlerInterface;

class UserLoginService
{

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordHandlerInterface $passwordHasher,
        private TokenHandlerInterface $tokenHandler
    ) {}

    public function execute(LoginDto $loginDto): array
    {
        $user = $this->userRepository->findOneBy([
            'email'  => $loginDto->getEmail()
        ]);

        if (!$user) {
            throw new LoginException('Invalid email');
        }

        if (!$this->passwordHasher->verify($loginDto->getPassword(), $user->getPassword())) {
            throw new LoginException('Invalid password');
        }

        $data = [
            'uid'      => $user->getUid(),
            'name'     => $user->getName(),
            'email'    => $user->getEmail(),
            'username' => $user->getUsername(),
            'created'  => time(),
        ];

        $token = $this->tokenHandler->encode(
            (new ValidTokenDto($data))->toArray()
        );

        return [
            'token' => $token,
            'ts'    => time(),
        ];
    }
}
