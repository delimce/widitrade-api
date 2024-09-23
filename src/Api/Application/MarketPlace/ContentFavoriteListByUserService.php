<?php

declare(strict_types=1);

namespace App\Api\Application\MarketPlace;

use App\Api\Domain\Dto\MediaDto;
use App\Api\Domain\Entity\User;
use App\Api\Domain\Entity\UserContentInteraction;
use App\Api\Domain\Repository\UserRepositoryInterface;
use App\Api\Domain\Repository\ContentRepositoryInterface;
use App\Api\Infrastructure\Repository\Orm\UserContentRepository;

class ContentFavoriteListByUserService
{
    public function __construct(
        protected readonly ContentRepositoryInterface $contentRepository,
        protected readonly UserRepositoryInterface $userRepository,
        protected readonly UserContentRepository $userContentRepository
    ) {}

    public function execute(string $userUid): array
    {
        /** @var User $user */
        $user = $this->userRepository->findByUid($userUid);

        if ($user === null) {
            throw new \DomainException('User not found', 404);
        }

        $favorites = array_filter($user->getInteractions()->toArray(), function (UserContentInteraction $interaction) {
            return $interaction->getIsFavorite() === true;
        });

        $result = [];

        
        foreach ($favorites as $fav) {
            $content = $fav->getContent();
            $media = $content->getMedia();
            $result[] = [
                'uid'         => $content->getUid(),
                'title'       => $content->getTitle(),
                'description' => $content->getDescription(),
                'ranked'      => $content->getRanked(),
                'media'       => MediaDto::showDetail($content->getMedia()),
            ];
        }

        return $result;
    }
}
