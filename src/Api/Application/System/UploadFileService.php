<?php

declare(strict_types=1);

namespace App\Api\Application\System;

use App\Shared\Domain\Interfaces\FileHandlerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileService
{

    public function __construct(
        private FileHandlerInterface $fileHandler
    ) {}

    public function execute(UploadedFile $file): string
    {
        return $this->fileHandler->upload($file);
    }
}
