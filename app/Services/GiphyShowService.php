<?php

namespace App\Services;

use App\DTOs\Giphy\ShowGifDTO;
use App\Interfaces\Services\GiphyShowInterfaceService;
use App\Interfaces\Repositories\GiphyApiInterfaceRepository;
use App\Exceptions\GifNotFoundException;

class GiphyShowService implements GiphyShowInterfaceService
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
     * Get a specific GIF by its ID
     *
     * @param ShowGifDTO $showDTO Data transfer object containing GIF ID
     * @return array
     * @throws GifNotFoundException When GIF is not found or API call fails
     */
    public function getGifById(ShowGifDTO $showDTO): array
    {
        try {
            return $this->giphyApiRepository->findById($showDTO);
        } catch (\Exception $e) {
            throw new GifNotFoundException();
        }
    }
} 