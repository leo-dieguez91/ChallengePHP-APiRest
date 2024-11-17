<?php

namespace Tests\Unit\DTOs\Giphy;

use App\DTOs\Giphy\ShowGifDTO;
use PHPUnit\Framework\TestCase;

class ShowGifDTOTest extends TestCase
{
    public function test_can_create_from_id()
    {
        // Arrange
        $id = 'abc123';

        // Act
        $dto = ShowGifDTO::fromRequest($id);

        // Assert
        $this->assertEquals('abc123', $dto->id);
    }

    public function test_trims_id_when_creating()
    {
        // Arrange
        $id = ' abc123 ';

        // Act
        $dto = ShowGifDTO::fromRequest($id);

        // Assert
        $this->assertEquals('abc123', $dto->id);
    }
} 