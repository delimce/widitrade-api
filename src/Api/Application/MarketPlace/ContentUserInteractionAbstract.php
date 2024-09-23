<?php

declare(strict_types=1);

namespace App\Api\Application\MarketPlace;

use App\Api\Domain\Entity\User;
use App\Api\Domain\Entity\Content;
use App\Api\Domain\Dto\ContentRatedDto;
use App\Api\Domain\Dto\ContentFavoriteDto;
use App\Api\Domain\Entity\UserContentInteraction;
use App\Api\Domain\Repository\UserRepositoryInterface;
use App\Api\Domain\Repository\ContentRepositoryInterface;
use App\Api\Infrastructure\Repository\Orm\UserContentRepository;

abstract class ContentUserInteractionAbstract
{

    public function __construct(
        protected readonly ContentRepositoryInterface $contentRepository,
        protected readonly UserRepositoryInterface $userRepository,
        protected readonly UserContentRepository $userContentRepository
    ) {}

    protected function getContentUserInteraction(ContentRatedDto| ContentFavoriteDto $dto): UserContentInteraction
    {
        /** @var Content $content */
        $content = $this->contentRepository->findByUid($dto->getContentUid());

        /** @var User $user */
        $user = $this->userRepository->findByUid($dto->getUserUid());

        if ($content === null) {
            throw new \DomainException('Content not found', 404);
        }

        if ($user === null) {
            throw new \DomainException('User not found', 404);
        }

        # current interaction if exists
        $interaction = $this->userContentRepository->getByContentAndUser($content, $user);

        if (is_null($interaction)) {
            # new interaction
            $interaction = new UserContentInteraction(
                content: $content,
                user: $user
            );
        }

        return $interaction;
    }
}
