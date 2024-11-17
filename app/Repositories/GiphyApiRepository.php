<?php

namespace App\Repositories;

use App\Interfaces\Repositories\GiphyApiInterfaceRepository;
use Illuminate\Support\Facades\Http;
use App\DTOs\Giphy\SearchGifDTO;
use App\DTOs\Giphy\ShowGifDTO;

class GiphyApiRepository implements GiphyApiInterfaceRepository
{
    /**
     * Giphy API key
     *
     * @var string
     */
    private $apiKey;

    /**
     * Giphy API base URL
     *
     * @var string
     */
    private $baseUrl;

    /**
     * Initialize repository with API configuration
     */
    public function __construct()
    {
        $this->apiKey = config('services.giphy.api_key');
        $this->baseUrl = config('services.giphy.base_url');
    }

    /**
     * Search GIFs using Giphy API
     *
     * @param SearchGifDTO $searchDTO Data transfer object containing search parameters
     * @return array
     * @throws \Exception When API call fails
     */
    public function search(SearchGifDTO $searchDTO): array
    {
        $response = Http::get("https://{$this->baseUrl}/search", [
            'api_key' => $this->apiKey,
            'q' => $searchDTO->query,
            'limit' => $searchDTO->limit,
            'offset' => $searchDTO->offset
        ]);

        if (!$response->successful()) {
            throw new \Exception('Error calling Giphy API: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Find a specific GIF by ID using Giphy API
     *
     * @param ShowGifDTO $showDTO Data transfer object containing GIF ID
     * @return array
     * @throws \Exception When API call fails
     */
    public function findById(ShowGifDTO $showDTO): array
    {
        $response = Http::get("https://{$this->baseUrl}/{$showDTO->id}", [
            'api_key' => $this->apiKey
        ]);

        if (!$response->successful()) {
            throw new \Exception('Error calling Giphy API: ' . $response->body());
        }

        return $response->json();
    }
} 