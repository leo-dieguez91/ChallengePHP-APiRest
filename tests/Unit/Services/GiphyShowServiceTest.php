<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\DTOs\Giphy\ShowGifDTO;
use App\Services\GiphyShowService;
use App\Exceptions\GifNotFoundException;
use App\Interfaces\Repositories\GiphyApiInterfaceRepository;
use App\Interfaces\Services\GiphyShowInterfaceService;
use Mockery;

class GiphyShowServiceTest extends TestCase
{
    private $giphyApiRepository;
    private $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->giphyApiRepository = Mockery::mock(GiphyApiInterfaceRepository::class);
        $this->service = new GiphyShowService($this->giphyApiRepository);
    }

    public function test_get_gif_by_id_returns_gif_data()
    {
        $showDTO = new ShowGifDTO('test123');
        
        $this->giphyApiRepository
            ->shouldReceive('findById')
            ->once()
            ->with(Mockery::on(function ($arg) use ($showDTO) {
                return $arg instanceof ShowGifDTO
                    && $arg->id === $showDTO->id;
            }))
            ->andReturn(['data' => ['id' => 'test123']]);

        $result = $this->service->getGifById($showDTO);
        
        $this->assertEquals(['data' => ['id' => 'test123']], $result);
    }

    public function test_get_gif_by_id_throws_exception_when_not_found()
    {
        $showDTO = new ShowGifDTO('nonexistent');
        
        $this->giphyApiRepository
            ->shouldReceive('findById')
            ->once()
            ->with(Mockery::on(function ($arg) use ($showDTO) {
                return $arg instanceof ShowGifDTO
                    && $arg->id === $showDTO->id;
            }))
            ->andThrow(new \Exception('API Error'));

        $this->expectException(GifNotFoundException::class);
        
        $this->service->getGifById($showDTO);
    }
} 