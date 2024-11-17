<?php

namespace App\DTOs\Giphy;

class ListFavoriteGifsDTO
{
    public function __construct(
        public readonly int $userId
    ) {}

    public static function fromRequest(int $userId): self
    {
        return new self(
            userId: $userId
        );
    }
} 