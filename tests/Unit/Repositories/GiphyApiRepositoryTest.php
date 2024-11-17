<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Repositories\GiphyApiRepository;
use Illuminate\Support\Facades\Http;
use App\DTOs\Giphy\SearchGifDTO;
use App\DTOs\Giphy\ShowGifDTO;

class GiphyApiRepositoryTest extends TestCase
{
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new GiphyApiRepository();
    }

    public function test_search_returns_gifs()
    {
        $searchDTO = new SearchGifDTO(
            query: 'cats',
            limit: 10,
            offset: 0
        );

        $result = $this->repository->search($searchDTO);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('data', $result);
    }

    public function test_find_by_id_returns_gif()
    {
        // Arrange
        $gifId = 'abc123';
        $showDTO = new ShowGifDTO($gifId);

        Http::fake([
            'api.giphy.com/v1/gifs/*' => Http::response([
                'data' => ['id' => $gifId, 'title' => 'Funny Cat']
            ], 200)
        ]);

        // Act
        $result = $this->repository->findById($showDTO);

        // Assert
        $this->assertEquals($gifId, $result['data']['id']);
    }
} 