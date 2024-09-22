<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Http\Controllers\Content;

use Psr\Log\LoggerInterface;
use App\Shared\Infrastructure\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Api\Application\Content\ContentDeleteService;
use App\Shared\Infrastructure\TokenValidationHandler;

class ContentDeleteController extends BaseController
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly TokenValidationHandler $tokenValidator,
        private readonly ContentDeleteService $contentDeleteService
    ) {}

    #[Route(
        '/content/{uid}',
        name: 'content_delete_by_uid',
        methods: ['DELETE'],
        requirements: ['uid' => '^[\w]{8}-[\w]{4}-[\w]{4}-[\w]{4}-[\w]{12}$']
    )]

    public function __invoke(Request $req, string $uid): Response
    {
        try {
            $this->tokenValidator->getUserSessionData($req);
            $this->contentDeleteService->execute($uid);
            $result = $this->okResponse(
                [
                    'message' => 'Content deleted successfully'
                ]
            );
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
