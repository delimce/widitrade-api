<?php

declare(strict_types=1);

namespace App\Api\Application\Content;

use App\Api\Domain\Repository\ContentRepositoryInterface;

class ContentDeleteService
{
    public function __construct(
        private ContentRepositoryInterface $contentRepository
    ) {}

    public function execute(string $uid): void
    {
        $content = $this->contentRepository->findByUid($uid);
        if (null === $content) {
            throw new \DomainException('Content not found', 404);
        }
        $this->contentRepository->remove($content);
        $this->contentRepository->flush();
    }
}
