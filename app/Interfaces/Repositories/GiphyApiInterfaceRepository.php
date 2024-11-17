<?php

namespace App\Interfaces\Repositories;

use App\DTOs\Giphy\SearchGifDTO;
use App\DTOs\Giphy\ShowGifDTO;

interface GiphyApiInterfaceRepository
{
    /**
     * Search for GIFs using the Giphy API
     *
     * @param SearchGifDTO $searchDTO Data transfer object containing search parameters
     * @return array
     * @throws \Exception When API call fails
     */
    public function search(SearchGifDTO $searchDTO): array;

    /**
     * Find a specific GIF by ID using Giphy API
     * 
     * @param ShowGifDTO $showDTO Data transfer object containing GIF ID
     * @return array
     * @throws \Exception When API call fails
     */
    public function findById(ShowGifDTO $showDTO): array;
} 