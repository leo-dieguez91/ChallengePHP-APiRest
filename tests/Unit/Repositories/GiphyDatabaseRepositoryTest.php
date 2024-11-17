<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\User;
use App\Models\FavoriteGif;
use App\DTOs\Giphy\SaveFavoriteGifDTO;
use App\Repositories\GiphyDatabaseRepository;
use App\Exceptions\GifAlreadyInFavoritesException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GiphyDatabaseRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private GiphyDatabaseRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new GiphyDatabaseRepository();
    }

    public function test_save_favorite_creates_record()
    {
        $user = User::factory()->create();
        
        $dto = new SaveFavoriteGifDTO(
            gifId: 'test123',
            alias: 'Test GIF',
            userId: $user->id
        );

        $this->repository->saveFavorite($dto);

        $this->assertDatabaseHas('favorite_gifs', [
            'gif_id' => 'test123',
            'alias' => 'Test GIF',
            'user_id' => $user->id
        ]);
    }

    public function test_save_favorite_prevents_duplicates()
    {
        $user = User::factory()->create();
        
        $dto = new SaveFavoriteGifDTO(
            gifId: 'test123',
            alias: 'Test GIF',
            userId: $user->id
        );

        $this->repository->saveFavorite($dto);
        
        $this->expectException(GifAlreadyInFavoritesException::class);
        $this->repository->saveFavorite($dto);
    }
} 