<?php

declare(strict_types=1);

namespace App\Api\Application\MarketPlace;

use App\Api\Domain\Dto\ContentRatedDto;

class ContentRatedByUserService extends ContentUserInteractionAbstract
{
    public function execute(ContentRatedDto $dto): array
    {
        $interaction = $this->getContentUserInteraction($dto);
        
        $interaction->setRanked($dto->getRate());

        $this->userContentRepository->persist($interaction);
        $this->userContentRepository->flush();

        return [
            'content_uid' => $interaction->getContent()->getUid(),
            'user_uid'    => $interaction->getUser()->getUid(),
            'ranked'      => $interaction->getRanked(),
            'ts'          => time(),
        ];
    }
}
