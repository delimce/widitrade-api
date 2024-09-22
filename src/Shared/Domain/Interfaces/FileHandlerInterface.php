<?php

declare(strict_types=1);

namespace App\Shared\Domain\Interfaces;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileHandlerInterface
{
    public function upload(UploadedFile $file, array $validations = []): string;
    public function storage(string $path, string $finalPath): string;
    public function remove(string $path): void;
}
