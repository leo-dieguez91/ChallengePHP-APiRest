<?php

namespace App\Services;

use App\DTOs\Giphy\SearchGifDTO;
use App\Interfaces\Repositories\GiphyApiInterfaceRepository;
use App\Interfaces\Services\GiphySearchInterfaceService;

class GiphySearchService implements GiphySearchInterfaceService
{
    /**
     * The API repository for GIF operations
     *
     * @var GiphyApiInterfaceRepository
     */
    private $giphyApiRepository;

    /**
     * Initialize service with API repository
     *
     * @param GiphyApiInterfaceRepository $giphyApiRepository
     */
    public function __construct(GiphyApiInterfaceRepository $giphyApiRepository)
    {
        $this->giphyApiRepository = $giphyApiRepository;
    }

    /**
     * Search GIFs using Giphy API
     *
     * @param SearchGifDTO $searchDTO Data transfer object containing search parameters
     * @return array
     * @throws \Exception When API call fails
     */
    public function searchGifs(SearchGifDTO $searchDTO): array
    {
        return $this->giphyApiRepository->search($searchDTO);
    }
} 