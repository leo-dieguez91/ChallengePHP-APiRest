<?php

namespace Tests\Unit\DTOs\Giphy;

use App\DTOs\Giphy\SaveFavoriteGifDTO;
use PHPUnit\Framework\TestCase;
use Illuminate\Http\Request;

class SaveFavoriteGifDTOTest extends TestCase
{
    public function test_can_create_from_request()
    {
        // Arrange
        $request = new Request();
        $request->merge([
            'gif_id' => 'abc123',
            'alias' => 'Funny cat'
        ]);
        $userId = 1;

        // Act
        $dto = SaveFavoriteGifDTO::fromRequest($request, $userId);

        // Assert
        $this->assertEquals('abc123', $dto->gifId);
        $this->assertEquals('Funny cat', $dto->alias);
        $this->assertEquals(1, $dto->userId);
    }

    public function test_trims_gif_id_and_alias()
    {
        // Arrange
        $request = new Request();
        $request->merge([
            'gif_id' => ' abc123 ',
            'alias' => ' Funny Cat '
        ]);
        $userId = 1;

        // Act
        $dto = SaveFavoriteGifDTO::fromRequest($request, $userId);

        // Assert
        $this->assertEquals('abc123', $dto->gifId);
        $this->assertEquals('Funny Cat', $dto->alias);
    }
} 