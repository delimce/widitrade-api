<?php

declare(strict_types=1);

namespace App\Api\Application\Content;

use App\Api\Domain\Dto\ContentDto;
use App\Api\Domain\Entity\Content;
use App\Api\Domain\Repository\ContentRepositoryInterface;
use App\Api\Domain\Repository\UserRepositoryInterface;

class ContentCreateService
{
    public function __construct(
        private ContentRepositoryInterface $contentRepository,
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(ContentDto $dto, string $userUid): array
    {
        $user = $this->userRepository->findByUid($userUid);

        $content = Content::createFromDto($dto);
        $this->contentRepository->persist($content);

        $user->addContent($content);
        $this->userRepository->persist($user);

        $this->contentRepository->flush();

        return [
            'uid'         => $content->getUid(),
            'title'       => $content->getTitle(),
            'description' => $content->getDescription(),
            'media'       => $content->getMedia(),
            'ts'          => time(),
        ];
    }
}
