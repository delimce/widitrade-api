<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Http\Controllers\User;

use Psr\Log\LoggerInterface;

use App\Api\Domain\Dto\UserDto;
use App\Shared\Infrastructure\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Api\Application\User\UserRegisterService;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class UserRegisterController extends BaseController
{
    public function __construct(
        private readonly ValidatorInterface  $validator,
        private readonly UserRegisterService $userRegisterService,
        private readonly LoggerInterface $logger
    ) {}

    #[Route('/register', name: 'user_register', methods: ['POST'])]
    public function __invoke(Request $req): Response
    {
        try {
            $userDto = new UserDto($req->toArray());
            if ($this->isValidRequestDto($userDto, $this->validator)) {
                $result  = $this->createdResponse($this->userRegisterService->execute($userDto));
            }
        } catch (\DomainException $e) {
            $result = $this->errorResponse($e->getMessage());
        } catch (\Throwable $e) {
            $this->logger->critical($e->getMessage());
            $result = $this->criticalResponse();
        } finally {
            return $result;
        }
    }
}
