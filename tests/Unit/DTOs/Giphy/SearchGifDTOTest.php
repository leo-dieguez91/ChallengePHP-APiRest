<?php

namespace Tests\Unit\DTOs\Giphy;

use App\DTOs\Giphy\SearchGifDTO;
use PHPUnit\Framework\TestCase;
use Illuminate\Http\Request;

class SearchGifDTOTest extends TestCase
{
    public function test_can_create_from_request()
    {
        // Arrange
        $request = new Request();
        $request->merge([
            'query' => 'cats',
            'limit' => 10,
            'offset' => 5
        ]);

        // Act
        $dto = SearchGifDTO::fromRequest($request);

        // Assert
        $this->assertEquals('cats', $dto->query);
        $this->assertEquals(10, $dto->limit);
        $this->assertEquals(5, $dto->offset);
    }

    public function test_uses_default_values_when_not_provided()
    {
        // Arrange
        $request = new Request();
        $request->merge(['query' => 'dogs']);

        // Act
        $dto = SearchGifDTO::fromRequest($request);

        // Assert
        $this->assertEquals('dogs', $dto->query);
        $this->assertEquals(25, $dto->limit);
        $this->assertEquals(0, $dto->offset);
    }
} 