<?php

namespace Tests\Unit\Services;

use App\Services\GiphySearchService;
use App\DTOs\Giphy\SearchGifDTO;
use App\Interfaces\Repositories\GiphyApiInterfaceRepository;
use App\Interfaces\Services\GiphySearchInterfaceService;
use Mockery;
use Tests\TestCase;

class GiphySearchServiceTest extends TestCase
{
    private $mockRepository;
    private $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockRepository = Mockery::mock(GiphyApiInterfaceRepository::class);
        $this->service = new GiphySearchService($this->mockRepository);
    }

    public function test_search_gifs_calls_repository_with_correct_parameters()
    {
        $searchDTO = new SearchGifDTO(
            query: 'cats',
            limit: 10,
            offset: 0
        );

        $this->mockRepository
            ->shouldReceive('search')
            ->once()
            ->with(Mockery::on(function ($arg) use ($searchDTO) {
                return $arg instanceof SearchGifDTO
                    && $arg->query === $searchDTO->query
                    && $arg->limit === $searchDTO->limit
                    && $arg->offset === $searchDTO->offset;
            }))
            ->andReturn(['data' => []]);

        $result = $this->service->searchGifs($searchDTO);

        $this->assertEquals(['data' => []], $result);
    }
} 