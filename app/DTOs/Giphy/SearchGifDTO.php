<?php

namespace App\DTOs\Giphy;

class SearchGifDTO
{
    public function __construct(
        public readonly string $query,
        public readonly ?int $limit = 25,
        public readonly ?int $offset = 0
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            query: $request->query('query'),
            limit: $request->query('limit', 25),
            offset: $request->query('offset', 0)
        );
    }
} 