<?php

declare(strict_types=1);

namespace App\Api\Domain\Dto;

use App\Shared\Infrastructure\BaseDto;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileDto extends BaseDto
{

    #[Assert\File(
        maxSize: '1024k',
        extensions: ['jpg', 'jpeg', 'png', 'gif', 'webP', 'mp4', '3gp', 'h264'],
        extensionsMessage: 'Please upload a valid (images, video) file, max size 1024k',
    )]
    protected UploadedFile $file;
}
