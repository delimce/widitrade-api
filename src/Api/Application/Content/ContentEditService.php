<?php

declare(strict_types=1);

namespace App\Api\Application\Content;

use App\Api\Domain\Dto\MediaDto;
use App\Api\Domain\Entity\Media;
use App\Api\Domain\Dto\ContentDto;
use App\Api\Domain\Repository\UserRepositoryInterface;
use App\Api\Domain\Repository\ContentRepositoryInterface;

class ContentEditService
{
    public function __construct(
        private ContentRepositoryInterface $contentRepository,
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(string $contentUid, ContentDto $contentDto): array
    {

        $content = $this->contentRepository->findByUid($contentUid);

        if ($content === null) {
            throw new \DomainException('Content not found', 404);
        }

        $content->setTitle($contentDto->getTitle());
        $content->setDescription($contentDto->getDescription());
        $content->setUpdatedAt();

        #remove all media
        $content->removeAllMedia();

        #add new media
        foreach ($contentDto->getMedia() as $mediaDto) {
            $media = Media::createFromDto($mediaDto);
            $content->addMedia($media);
        }

        $this->contentRepository->persist($content);
        $this->contentRepository->flush();

        return [
            'uid'         => $content->getUid(),
            'title'       => $content->getTitle(),
            'description' => $content->getDescription(),
            'media'       => MediaDto::showDetail($content->getMedia()),
            'ts'          => time(),
        ];
    }
}
