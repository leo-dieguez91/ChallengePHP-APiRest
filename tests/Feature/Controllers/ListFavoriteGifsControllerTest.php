<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\FavoriteGif;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListFavoriteGifsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        Passport::actingAs($this->user);
    }

    public function test_can_list_favorite_gifs()
    {
        // Arrange
        FavoriteGif::factory()->count(3)->create([
            'user_id' => $this->user->id
        ]);

        // Act
        $response = $this->getJson('/api/user/favorites');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(3, 'data');
    }

    public function test_returns_empty_array_when_no_favorites()
    {
        // Act
        $response = $this->getJson('/api/user/favorites');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(0, 'data');
    }

    public function test_requires_authentication()
    {
        // Arrange
        $this->app['auth']->guard('api')->forgetUser();

        // Act
        $response = $this->getJson('/api/user/favorites');

        // Assert
        $response->assertUnauthorized();
    }
} 