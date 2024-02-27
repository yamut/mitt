<?php

namespace App\Dto;

readonly class Setting implements \JsonSerializable
{
    public function __construct(
        private string $endpoint,
        private int $code,
        private string $body,
    ) {
        //
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    #[\Override] public function jsonSerialize(): array
    {
        return [
            'endpoint' => route('catch', [$this->getEndpoint()]),
            'code' => $this->getCode(),
            'body' => $this->getBody(),
        ];
    }
}
