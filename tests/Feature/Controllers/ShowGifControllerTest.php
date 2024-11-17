<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use Mockery;
use App\DTOs\Giphy\ShowGifDTO;
use App\Interfaces\Services\GiphyShowInterfaceService;
use App\Exceptions\GifNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;

class ShowGifControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_show_endpoint_returns_gif()
    {
        // Arrange
        $this->mock(GiphyShowInterfaceService::class)
            ->shouldReceive('getGifById')
            ->once()
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof ShowGifDTO
                    && $arg->id === 'abc123';
            }))
            ->andReturn(['data' => ['id' => 'abc123']]);

        // Act & Assert
        $response = $this->getJson('/api/gifs/abc123');
        
        $response->assertStatus(200)
                ->assertJsonStructure(['data']);
    }

    public function test_show_endpoint_handles_not_found()
    {
        // Arrange
        $this->mock(GiphyShowInterfaceService::class)
            ->shouldReceive('getGifById')
            ->once()
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof ShowGifDTO
                    && $arg->id === 'nonexistent';
            }))
            ->andThrow(new GifNotFoundException());

        // Act & Assert
        $response = $this->getJson('/api/gifs/nonexistent');
        
        $response->assertStatus(404)
                ->assertJson(['message' => 'GIF not found']);
    }
} 