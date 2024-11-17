<?php

namespace App\DTOs\Giphy;

class ShowGifDTO
{
    public function __construct(
        public readonly string $id
    ) {}

    public static function fromRequest(string $id): self
    {
        return new self(
            id: trim($id)
        );
    }
} 