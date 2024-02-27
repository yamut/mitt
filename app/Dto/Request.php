<?php

namespace App\Dto;

readonly class Request implements \JsonSerializable
{
    public function __construct(
        public string $path,
        public mixed $body, // because resource
        public array $headers,
    ) {
        //
    }

    #[\Override] public function jsonSerialize(): array
    {
        return [
            'path' => $this->path,
            'body' => $this->body,
            'headers' => $this->headers,
        ];
    }
}
