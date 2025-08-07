<?php

namespace App\DTO\Response;

class ApiResponse
{
    private string $message;

    private string $statusCode;

    private mixed $data;

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): ApiResponse
    {
        $this->message = $message;

        return $this;
    }

    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    public function setStatusCode(string $statusCode): ApiResponse
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function setData(mixed $data): ApiResponse
    {
        $this->data = $data;

        return $this;
    }
}
