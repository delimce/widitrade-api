<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Http\Controllers\MarketPlace;

use Psr\Log\LoggerInterface;
use App\Api\Domain\Dto\ContentFavoriteDto;
use App\Shared\Infrastructure\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Shared\Infrastructure\TokenValidationHandler;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Api\Application\MarketPlace\ContentSetFavoriteByUserService;

class ContentSetFavoriteByUserController extends BaseController
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly TokenValidationHandler $tokenValidator,
        private readonly ValidatorInterface  $validator,
        private readonly ContentSetFavoriteByUserService $contentSetFavoriteByUserService
    ) {}

    #[Route(
        '/content/{uid}/favorite',
        name: 'content_set_favorite_by_user',
        methods: ['POST'],
        requirements: ['uid' => '^[\w]{8}-[\w]{4}-[\w]{4}-[\w]{4}-[\w]{12}$']
    )]
    public function __invoke(Request $req, string $uid): Response
    {
        try {
            $tokenDto = $this->tokenValidator->getUserSessionData($req);
            $contentSetFavoriteDto = new ContentFavoriteDto([
                'contentUid' => $uid,
                'userUid'    => $tokenDto->getUid()
            ]);

            if ($this->isValidRequestDto($contentSetFavoriteDto, $this->validator)) {
                $result  = $this->createdResponse(
                    $this->contentSetFavoriteByUserService->execute($contentSetFavoriteDto)
                );
            }
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
