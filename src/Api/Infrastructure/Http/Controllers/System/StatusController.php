<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Http\Controllers\System;

use Psr\Log\LoggerInterface;

use App\Shared\Infrastructure\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Api\Application\System\SystemService;


final class StatusController extends BaseController
{

    public function __construct(
        private readonly SystemService $systemService,
        protected readonly LoggerInterface $logger
    ) {
    }

    #[Route('/status', name: 'service_status', methods: ['GET'])]
    public function __invoke(): Response
    {
        try {
            $this->systemService->execute();
            $result = $this->okResponse(['status' => 'ok']);
        } catch (\DomainException $e) {
            $result = $this->errorResponse($e->getMessage());
        } catch (\Throwable $e) {
            $this->logger->critical($e->getMessage());
            $result = $this->criticalResponse($e->getMessage());
        } finally {
            return $result;
        }
    }
}
