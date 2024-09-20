<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Domain\Dto\ValidTokenDto;
use Symfony\Component\HttpFoundation\Request;
use App\Shared\Domain\Exceptions\ForbiddenException;
use App\Api\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Exceptions\InvalidTokenException;
use App\Shared\Domain\Interfaces\TokenHandlerInterface;

class TokenValidationHandler
{
    public function __construct(
        private TokenHandlerInterface $tokenHandler,
        private UserRepositoryInterface $userRepository
    ) {}

    /**
     * @throws InvalidTokenException
     * @throws ForbiddenException
     */
    public function getUserSessionData(
        Request $request
    ): ValidTokenDto {

        if (!$request->headers->has('Authorization')) {
            throw new InvalidTokenException('empty Authorization token');
        }

        $token = $request->headers->get('Authorization');
        $token = $this->sanitizeToken($token);

        if (!$this->validateToken($token)) {
            throw new InvalidTokenException('Invalid authorization token');
        }

        return  new ValidTokenDto($this->decodeUserToken($token));
    }

    protected function sanitizeToken(string $token): string
    {
        return str_replace('Bearer ', '', trim($token));
    }

    public function decodeUserToken(
        string $encodedToken
    ): array {
        try {
            return $this->tokenHandler->decode($encodedToken);
        } catch (\Exception $e) {
            throw new InvalidTokenException('invalid token Signature verification');
        }
    }

    protected function validateToken(string $token): bool
    {
        $token = explode('.', $token);
        if (count($token) !== 3) {
            return false;
        }
        return true;
    }
}
