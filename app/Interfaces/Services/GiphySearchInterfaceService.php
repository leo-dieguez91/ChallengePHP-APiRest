<?php

namespace App\Interfaces\Services;

use App\DTOs\Giphy\SearchGifDTO;

interface GiphySearchInterfaceService
{
    /**
     * Search for GIFs using the provided search criteria
     *
     * @param SearchGifDTO $searchDTO Data transfer object containing search parameters
     * @return array
     */
    public function searchGifs(SearchGifDTO $searchDTO);
} 