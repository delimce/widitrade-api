<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Http\Controllers\User;

use Psr\Log\LoggerInterface;

use App\Api\Domain\Dto\LoginDto;
use App\Shared\Infrastructure\BaseController;
use Symfony\Component\HttpFoundation\Request;
use App\Api\Application\User\UserLoginService;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserLoginController extends BaseController
{
    public function __construct(
        private readonly ValidatorInterface  $validator,
        private readonly UserLoginService    $userLoginService,
        private readonly LoggerInterface $logger
    ) {}

    #[Route('/login', name: 'user_login', methods: ['POST'])]
    public function __invoke(Request $req): Response
    {
        try {
            $loginDto = new LoginDto($req->toArray());
            // get ip address and client from request
            $loginDto->setIpAddress($req->getClientIp());
            $loginDto->setClient($req->headers->get('User-Agent'));
            if ($this->isValidRequestDto($loginDto, $this->validator)) {
                $result  = $this->okResponse($this->userLoginService->execute($loginDto));
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
