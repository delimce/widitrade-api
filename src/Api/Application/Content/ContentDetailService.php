<?php

declare(strict_types=1);

namespace App\Api\Application\Content;

use App\Api\Domain\Repository\ContentRepositoryInterface;

class ContentDetailService
{
    public function __construct(
        private ContentRepositoryInterface $contentRepository
    ) {}

    public function execute(string $uid): array
    {
        $content = $this->contentRepository->findByUid($uid);

        if ($content === null) {
            throw new \DomainException('Content not found', 404);
        }

        return [
            'uid'         => $content->getUid(),
            'title'       => $content->getTitle(),
            'description' => $content->getDescription(),
            'media'       => $content->getMedia(),
            'ranked'      => $content->getRanked(),
            'created'     => $content->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated'     => $content->getUpdatedAt()?->format('Y-m-d H:i:s'),
        ];
    }
}
