<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\FavoriteGif;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteFavoriteGifControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        Passport::actingAs($this->user);
    }

    public function test_can_delete_favorite_gif()
    {
        // Arrange
        $favorite = FavoriteGif::factory()->create([
            'user_id' => $this->user->id
        ]);

        // Act
        $response = $this->deleteJson("/api/user/favorites/{$favorite->gif_id}");

        // Assert
        $response->assertNoContent();
        $this->assertDatabaseMissing('favorite_gifs', [
            'id' => $favorite->id
        ]);
    }

    public function test_returns_404_when_gif_not_in_favorites()
    {
        // Act
        $response = $this->deleteJson('/api/user/favorites/nonexistent');

        // Assert
        $response->assertNotFound()
            ->assertJson(['message' => 'GIF not found in favorites']);
    }

    public function test_requires_authentication()
    {
        // Arrange
        $this->app['auth']->guard('api')->forgetUser();

        // Act
        $response = $this->deleteJson('/api/user/favorites/any-id');

        // Assert
        $response->assertUnauthorized();
    }
} 