<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use DomainException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    protected function okResponse(array $data = []): Response
    {
        $result = ["data" => $data,];
        return (new Response())->setStatusCode(Response::HTTP_OK)->setContent(json_encode($result));
    }

    protected function createdResponse(array $data = []): Response
    {
        $result = ["data" => $data,];
        return (new Response())->setStatusCode(Response::HTTP_CREATED)->setContent(json_encode($result));
    }

    protected function noContentResponse(): Response
    {
        return (new Response())->setStatusCode(Response::HTTP_NO_CONTENT)->setContent("NO CONTENT");
    }

    protected function errorResponse(string $message = "error", int $code = Response::HTTP_BAD_REQUEST): Response
    {
        $detail = json_encode(["detail" => $message,]);
        return (new Response())->setStatusCode($code)->setContent($detail);
    }

    protected function notFoundResponse(): Response
    {
        return (new Response())->setStatusCode(Response::HTTP_NOT_FOUND)->setContent("NOT FOUND");
    }


    protected function unauthorizedResponse(): Response
    {
        return (new Response())->setStatusCode(Response::HTTP_UNAUTHORIZED)->setContent("UNAUTHORIZED");
    }

    protected function criticalResponse(string $message = "something went wrong"): Response
    {
        return (new Response())->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->setContent($message);
    }

    /**
     * @param BaseDto $dto
     * @param ValidatorInterface $validator
     * @return bool
     * @throws DomainException
     */
    protected function isValidRequestDto(BaseDto $dto, ValidatorInterface $validator): bool
    {
        $errors = $validator->validate($dto);
        if (count($errors) > 0) {
            $firstError = $errors[0];
            $field = $firstError->getPropertyPath();
            $message = $firstError->getMessage();
            $finalMessage = sprintf("Field: %s, Message: %s", $field, $message);
            throw new \DomainException($finalMessage, Response::HTTP_BAD_REQUEST);
        }
        return true;
    }
}
