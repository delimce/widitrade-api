<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Http\Controllers\User;

use Psr\Log\LoggerInterface;
use App\Shared\Infrastructure\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Api\Application\User\UserDetailService;
use Symfony\Component\Routing\Annotation\Route;
use App\Shared\Infrastructure\TokenValidationHandler;

class UserDataController extends BaseController
{
    public function __construct(
        private readonly UserDetailService $userDetailService,
        private readonly LoggerInterface $logger,
        private readonly TokenValidationHandler $tokenValidator
    ) {}

    #[Route(
        '/user',
        name: 'user_data_by_token',
        methods: ['GET']
    )]
    public function __invoke(Request $req): Response
    {
        try {
            $tokenDto = $this->tokenValidator->getUserSessionData($req, true);
            $result  = $this->okResponse($this->userDetailService->execute($tokenDto->getUid()));
        } catch (\DomainException $e) {
            $result = $this->errorResponse($e->getMessage(), $e->getCode());
        } catch (\Throwable $e) {
            $this->logger->critical($e->getMessage());
            $result = $this->criticalResponse();
        } finally {
            return $result;
        }
    }
}
