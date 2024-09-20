<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Http\Controllers\User;

use Psr\Log\LoggerInterface;

use App\Api\Domain\Dto\UserDto;
use App\Shared\Infrastructure\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Api\Application\User\UserUpdateService;
use Symfony\Component\Routing\Annotation\Route;
use App\Shared\Infrastructure\TokenValidationHandler;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserUpdateController extends BaseController
{
    public function __construct(
        private readonly ValidatorInterface  $validator,
        private readonly UserUpdateService $userUpdateService,
        private readonly TokenValidationHandler $tokenValidator,
        private readonly LoggerInterface $logger
    ) {}

    #[Route('/user', name: 'user_update_data', methods: ['PUT'])]
    public function __invoke(Request $req): Response
    {
        try {
            $tokenDto = $this->tokenValidator->getUserSessionData($req, true);
            $userDto = new UserDto($req->toArray());
            if ($this->isValidRequestDto($userDto, $this->validator)) {
                $this->userUpdateService->execute($tokenDto->getUid(), $userDto);
                $result  = $this->noContentResponse();
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
