<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Domain\Interfaces\TokenHandlerInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtTokenHandler implements TokenHandlerInterface
{

    public function __construct(
        private string $secret,
    ) {
    }

    public function encode(array $payload): string
    {
        return JWT::encode($payload, $this->secret, 'HS256');
    }

    public function decode(string $token): array
    {
        return (array) JWT::decode($token, new Key($this->secret, 'HS256'));
    }
}
