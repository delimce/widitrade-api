<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Http\Controllers\Content;

use Psr\Log\LoggerInterface;
use App\Shared\Infrastructure\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Api\Application\Content\ContentDetailService;
use App\Shared\Infrastructure\TokenValidationHandler;

class ContentDetailController extends BaseController
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly TokenValidationHandler $tokenValidator,
        private readonly ContentDetailService $contentDetailService
    ) {}

    #[Route(
        '/content/{uid}',
        name: 'content_by_uid',
        methods: ['GET'],
        requirements: ['uid' => '^[\w]{8}-[\w]{4}-[\w]{4}-[\w]{4}-[\w]{12}$']
    )]
    public function __invoke(Request $req, string $uid): Response
    {
        try {
            $tokenDto = $this->tokenValidator->getUserSessionData($req);
            $result  = $this->okResponse(
                $this->contentDetailService->execute($uid, $tokenDto->getUid())
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
