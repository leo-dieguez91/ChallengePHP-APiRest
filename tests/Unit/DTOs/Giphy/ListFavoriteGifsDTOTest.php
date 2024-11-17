<?php

namespace Tests\Unit\DTOs\Giphy;

use App\DTOs\Giphy\ListFavoriteGifsDTO;
use PHPUnit\Framework\TestCase;
use Illuminate\Http\Request;

class ListFavoriteGifsDTOTest extends TestCase
{
    public function test_can_create_from_request()
    {
        // Arrange
        $request = new Request();
        $userId = 1;

        // Act
        $dto = ListFavoriteGifsDTO::fromRequest($userId);

        // Assert
        $this->assertEquals(1, $dto->userId);
    }
} 