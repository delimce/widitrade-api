<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Http\Controllers\Content;

use Psr\Log\LoggerInterface;
use App\Api\Domain\Dto\ContentDto;
use App\Shared\Infrastructure\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Api\Application\Content\ContentEditService;
use App\Shared\Infrastructure\TokenValidationHandler;

class ContentEditController extends BaseController
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly TokenValidationHandler $tokenValidator,
        private readonly ContentEditService $contentEditService
    ) {}

    #[Route(
        '/content/{uid}',
        name: 'content_edit_by_user',
        methods: ['PUT'],
        requirements: ['uid' => '^[\w]{8}-[\w]{4}-[\w]{4}-[\w]{4}-[\w]{12}$']
    )]
    public function __invoke(Request $req, string $uid): Response
    {
        try {
            $this->tokenValidator->getUserSessionData($req);
            $contentDto = new ContentDto($req->toArray());
            $result  = $this->createdResponse($this->contentEditService->execute($uid,$contentDto));
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
