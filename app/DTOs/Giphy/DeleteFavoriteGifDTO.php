<?php

namespace App\DTOs\Giphy;

class DeleteFavoriteGifDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly string $gifId
    ) {}

    public static function fromRequest(int $userId,string $gifId): self
    {
        return new self(
            userId: $userId,
            gifId: trim($gifId)
        );
    }
} 