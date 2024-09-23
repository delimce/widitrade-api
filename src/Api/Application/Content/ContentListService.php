<?php

declare(strict_types=1);

namespace App\Api\Application\Content;

use App\Api\Domain\Dto\MediaDto;
use App\Api\Domain\Repository\ContentRepositoryInterface;

class ContentListService
{

    public function __construct(
        private ContentRepositoryInterface $contentRepository
    ) {}

    public function execute(?string $filter = null): array
    {
        $contents = $this->contentRepository->listAll($filter);

        return array_map(function ($content) {
            return [
                'uid'         => $content->getUid(),
                'title'       => $content->getTitle(),
                'description' => $content->getDescription(),
                'media'       => MediaDto::showDetail($content->getMedia()),
                'ranked'      => $content->getRanked(),
                'created'     => $content->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated'     => $content->getUpdatedAt()?->format('Y-m-d H:i:s'),
            ];
        }, $contents);
    }
}
