<?php

namespace Tests\Unit\DTOs\Giphy;

use App\DTOs\Giphy\DeleteFavoriteGifDTO;
use PHPUnit\Framework\TestCase;

class DeleteFavoriteGifDTOTest extends TestCase
{
    public function test_can_create_from_parameters()
    {
        // Arrange
        $gifId = 'abc123';
        $userId = 1;

        // Act
        $dto = DeleteFavoriteGifDTO::fromRequest($userId, $gifId);

        // Assert
        $this->assertEquals('abc123', $dto->gifId);
        $this->assertEquals(1, $dto->userId);
    }

    public function test_trims_gif_id()
    {
        // Arrange
        $gifId = ' abc123 ';
        $userId = 1;

        // Act
        $dto = DeleteFavoriteGifDTO::fromRequest($userId, $gifId);

        // Assert
        $this->assertEquals('abc123', $dto->gifId);
    }
} 