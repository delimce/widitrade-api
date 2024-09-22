<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Domain\Interfaces\FileHandlerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileLocalStorageHandler implements FileHandlerInterface
{
    public function __construct(private string $storagePath) {}

    public function upload(UploadedFile $file, array $validations = []): string
    {
        $fileName = $this->getMediaName($file);
        $subFolder = $this->getFolderName($file);
        $file->move($this->storagePath . '/' . $subFolder, $fileName);
        return $subFolder . '/' . $fileName;
    }

    public function storage(string $path, string $finalPath): string
    {
        $finalPath = $this->storagePath . $finalPath;
        if (!is_dir($finalPath)) {
            mkdir($finalPath, 0777, true);
        }
        $fileName = basename($path);
        $newPath = $finalPath . $fileName;
        rename($path, $newPath);
        return $newPath;
    }

    public function remove(string $path): void
    {
        unlink($path);
    }

    protected function getMediaName(UploadedFile $file): string
    {
        return sprintf('%s.%s',  md5(uniqid()), $file->getClientOriginalExtension());
    }

    protected function getFolderName(UploadedFile $file): string
    {
        return $file->getMimeType() ? explode('/', $file->getMimeType())[0] : 'unknown';
    }
}
