<?php

namespace App\Interfaces\Services;

use App\DTOs\Giphy\ShowGifDTO;

interface GiphyShowInterfaceService
{
    /**
     * Get a GIF by its ID
     *
     * @param ShowGifDTO $showDTO Data Transfer Object containing the GIF ID
     * @return array
     */
    public function getGifById(ShowGifDTO $showDTO);
} 