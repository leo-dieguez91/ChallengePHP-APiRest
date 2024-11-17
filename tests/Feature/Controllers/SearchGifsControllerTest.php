<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchGifsControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        Passport::actingAs($this->user);
    }

    public function test_search_endpoint_returns_results()
    {
        // Act & Assert
        $response = $this->getJson('/api/gifs/search?query=cats');
        
        $response->assertStatus(200)
                ->assertJsonStructure(['data']);
    }

    public function test_search_endpoint_validates_required_query()
    {
        // Act & Assert
        $response = $this->getJson('/api/gifs/search');
        
        $response->assertStatus(422)
                ->assertJsonValidationErrors(['query']);
    }

    public function test_search_endpoint_validates_limit_range()
    {
        // Act & Assert
        $response = $this->getJson('/api/gifs/search?query=cats&limit=100');
        
        $response->assertStatus(422)
                ->assertJsonValidationErrors(['limit']);
    }
} 