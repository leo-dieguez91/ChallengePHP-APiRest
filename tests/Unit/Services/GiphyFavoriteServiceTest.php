<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\User;
use App\Models\FavoriteGif;
use App\DTOs\Giphy\SaveFavoriteGifDTO;
use App\Services\GiphyFavoriteService;
use App\Http\Resources\FavoriteGifResource;
use App\Interfaces\Repositories\GiphyDatabaseInterfaceRepository;
use Mockery;

class GiphyFavoriteServiceTest extends TestCase
{
    private $giphyDatabaseRepository;
    private $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->giphyDatabaseRepository = Mockery::mock(GiphyDatabaseInterfaceRepository::class);
        $this->service = new GiphyFavoriteService($this->giphyDatabaseRepository);
    }

    public function test_save_favorite_gif_creates_record()
    {
        $dto = new SaveFavoriteGifDTO(
            gifId: 'abc123',
            alias: 'Funny cat',
            userId: 1
        );

        $expectedFavorite = new FavoriteGif([
            'id' => 1,
            'gif_id' => 'abc123',
            'alias' => 'Funny cat',
            'user_id' => 1
        ]);

        $this->giphyDatabaseRepository
            ->shouldReceive('saveFavorite')
            ->once()
            ->with(Mockery::on(function ($arg) use ($dto) {
                return $arg instanceof SaveFavoriteGifDTO
                    && $arg->gifId === $dto->gifId
                    && $arg->alias === $dto->alias
                    && $arg->userId === $dto->userId;
            }))
            ->andReturn($expectedFavorite);

        $result = $this->service->saveFavoriteGif($dto);

        $this->assertInstanceOf(FavoriteGifResource::class, $result);
        $this->assertEquals($expectedFavorite->gif_id, $result->resource->gif_id);
        $this->assertEquals($expectedFavorite->alias, $result->resource->alias);
        $this->assertEquals($expectedFavorite->user_id, $result->resource->user_id);
    }
} 