<?php

declare(strict_types=1);

namespace App\Api\Application\Content;

use App\Api\Domain\Dto\MediaDto;
use App\Api\Domain\Dto\ContentDto;
use App\Api\Domain\Entity\Content;
use App\Api\Domain\Repository\UserRepositoryInterface;
use App\Api\Domain\Repository\ContentRepositoryInterface;

class ContentCreateService
{
    public function __construct(
        private ContentRepositoryInterface $contentRepository,
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(ContentDto $dto, string $userUid): array
    {
        $user = $this->userRepository->findByUid($userUid);

        if ($user === null) {
            throw new \DomainException('User not found or wrong user token', 404);
        }

        $content = Content::createFromDto($dto);
        $this->contentRepository->persist($content);

        $user->addContent($content);
        $this->userRepository->persist($user);

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
