<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Http\Controllers\MarketPlace;

use Psr\Log\LoggerInterface;
use App\Shared\Infrastructure\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Shared\Infrastructure\TokenValidationHandler;
use App\Api\Application\MarketPlace\ContentFavoriteListByUserService;

class ContentFavoriteListByUserController extends BaseController
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly TokenValidationHandler $tokenValidator,
        private readonly ContentFavoriteListByUserService $contentFavoriteListByUserService
    ) {}

    #[Route(
        '/content/favorite',
        name: 'content_favorite_list_by_user',
        methods: ['GET']
    )]
    public function __invoke(Request $req): Response
    {
        try {
            $tokenDto = $this->tokenValidator->getUserSessionData($req);
            $result  = $this->okResponse(
                $this->contentFavoriteListByUserService->execute($tokenDto->getUid())
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
