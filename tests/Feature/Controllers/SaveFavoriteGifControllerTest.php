<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Interfaces\Services\GiphyFavoriteInterfaceService;
use Mockery;
use App\DTOs\Giphy\SaveFavoriteGifDTO;
use App\Models\FavoriteGif;
use App\Http\Resources\FavoriteGifResource;

class SaveFavoriteGifControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $mockService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        Passport::actingAs($this->user);

        $this->mockService = Mockery::mock(GiphyFavoriteInterfaceService::class);
        $this->app->instance(GiphyFavoriteInterfaceService::class, $this->mockService);
    }

    public function test_can_save_favorite_gif()
    {
        $gifData = [
            'gif_id' => 'abc123',
            'alias' => 'Funny cat'
        ];

        $expectedFavorite = new FavoriteGif([
            'gif_id' => $gifData['gif_id'],
            'alias' => $gifData['alias'],
            'user_id' => $this->user->id
        ]);

        $this->mockService
            ->shouldReceive('saveFavoriteGif')
            ->once()
            ->withArgs(function ($dto) use ($gifData) {
                return $dto instanceof SaveFavoriteGifDTO
                    && $dto->gifId === $gifData['gif_id']
                    && $dto->alias === $gifData['alias']
                    && $dto->userId === $this->user->id;
            })
            ->andReturn(new FavoriteGifResource($expectedFavorite));

        $response = $this->postJson('/api/gifs/favorite', $gifData);
        
        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'gif_id',
                        'alias',
                        'user_id'
                    ]
                ])
                ->assertJson([
                    'data' => [
                        'gif_id' => $gifData['gif_id'],
                        'alias' => $gifData['alias'],
                        'user_id' => $this->user->id
                    ]
                ]);
    }

    public function test_validates_required_fields()
    {
        // Act & Assert
        $response = $this->postJson('/api/gifs/favorite', []);
        
        $response->assertStatus(422)
                ->assertJsonValidationErrors(['gif_id', 'alias']);
    }

    public function test_validates_gif_id_is_string()
    {
        // Act
        $response = $this->postJson('/api/gifs/favorite', [
            'gif_id' => 123,
            'alias' => 'Test'
        ]);
        
        // Assert
        $response->assertStatus(422)
                ->assertJsonValidationErrors(['gif_id']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
} 