<?php

declare(strict_types=1);

namespace App\Api\Application\MarketPlace;

use App\Api\Domain\Dto\ContentFavoriteDto;
use App\Api\Domain\Entity\UserContentInteraction;

class ContentSetFavoriteByUserService  extends ContentUserInteractionAbstract
{

    public function execute(ContentFavoriteDto $dto): array
    {
        /** @var UserContentInteraction $interaction */
        $interaction = $this->getContentUserInteraction($dto);

        $isFavorite = ($interaction->getIsFavorite()) ? false : true;

        $interaction->setIsFavorite($isFavorite);
        $this->userContentRepository->persist($interaction);
        $this->userContentRepository->flush();

        return [
            'content_uid' => $interaction->getContent()->getUid(),
            'user_uid'    => $interaction->getUser()->getUid(),
            'favorite'    => $interaction->getIsFavorite(),
            'ts'          => time(),
        ];
    }
}
