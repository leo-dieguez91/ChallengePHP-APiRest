<?php

namespace App\DTOs\Giphy;

use Illuminate\Http\Request;

class SaveFavoriteGifDTO
{
    public function __construct(
        public readonly string $gifId,
        public readonly string $alias,
        public readonly int $userId
    ) {}

    public static function fromRequest(Request $request, int $userId): self
    {
        return new self(
            gifId: trim($request->get('gif_id')),
            alias: trim($request->get('alias')),
            userId: $userId
        );
    }
} 