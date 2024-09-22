<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Http\Controllers\System;

use Psr\Log\LoggerInterface;
use App\Api\Domain\Dto\FileDto;
use App\Shared\Infrastructure\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Api\Application\System\UploadFileService;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UploadFileController extends BaseController
{
    public function __construct(
        private readonly UploadFileService $uploadFileService,
        protected readonly LoggerInterface $logger,
        private readonly ValidatorInterface  $validator,
    ) {}

    #[Route(
        '/upload',
        name: 'upload_file',
        methods: ['POST']
    )]
    public function __invoke(Request $req): Response
    {
        try {
            $file = $req->files->get('file');
            $fileDto = new FileDto(['file' => $file]);
            if ($this->isValidRequestDto($fileDto, $this->validator)) {
                $result = $this->okResponse(['filepath' => $this->uploadFileService->execute($file)]);
            }
        } catch (\DomainException $e) {
            $result = $this->errorResponse($e->getMessage());
        } catch (\Throwable $e) {
            $this->logger->critical($e->getMessage());
            $result = $this->criticalResponse($e->getMessage());
        } finally {
            return $result;
        }
    }

}
