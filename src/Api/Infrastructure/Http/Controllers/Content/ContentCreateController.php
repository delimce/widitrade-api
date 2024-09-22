<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Http\Controllers\Content;

use Psr\Log\LoggerInterface;
use App\Api\Domain\Dto\ContentDto;
use App\Shared\Infrastructure\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Api\Application\Content\ContentCreateService;
use App\Shared\Infrastructure\TokenValidationHandler;

class ContentCreateController extends BaseController
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly TokenValidationHandler $tokenValidator,
        private readonly ContentCreateService $contentCreateService
    ) {}

    #[Route(
        '/content',
        name: 'content_create_by_user',
        methods: ['POST']
    )]
    public function __invoke(Request $req): Response
    {
        try {
            $tokenDto = $this->tokenValidator->getUserSessionData($req);
            $contentDto = new ContentDto($req->toArray());
            $result  = $this->createdResponse($this->contentCreateService->execute($contentDto, $tokenDto->getUid()));
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
