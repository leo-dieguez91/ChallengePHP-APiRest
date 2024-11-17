<?php

namespace App\Services;

use App\DTOs\Giphy\SaveFavoriteGifDTO;
use App\DTOs\Giphy\DeleteFavoriteGifDTO;
use App\DTOs\Giphy\ListFavoriteGifsDTO;
use App\Interfaces\Services\GiphyFavoriteInterfaceService;
use App\Interfaces\Repositories\GiphyDatabaseInterfaceRepository;
use App\Http\Resources\FavoriteGifResource;
use App\Http\Resources\FavoriteGifCollection;

class GiphyFavoriteService implements GiphyFavoriteInterfaceService
{
    /**
     * The database repository for GIF operations
     *
     * @var GiphyDatabaseInterfaceRepository
     */
    private $giphyDatabaseRepository;

    /**
     * Initialize service with database repository
     *
     * @param GiphyDatabaseInterfaceRepository $giphyDatabaseRepository
     */
    public function __construct(GiphyDatabaseInterfaceRepository $giphyDatabaseRepository)
    {
        $this->giphyDatabaseRepository = $giphyDatabaseRepository;
    }

    /**
     * Save a GIF as favorite for a user
     *
     * @param SaveFavoriteGifDTO $dto Data transfer object containing favorite gif data
     * @return FavoriteGifResource
     * @throws GifAlreadyInFavoritesException
     */
    public function saveFavoriteGif(SaveFavoriteGifDTO $dto): FavoriteGifResource
    {
        $favorite = $this->giphyDatabaseRepository->saveFavorite($dto);
        return new FavoriteGifResource($favorite);
    }

    /**
     * Delete a GIF from user's favorites
     *
     * @param DeleteFavoriteGifDTO $dto Data transfer object containing deletion parameters
     * @return array
     * @throws GifNotInFavoritesException
     */
    public function deleteFavorite(DeleteFavoriteGifDTO $dto): array
    {
        $this->giphyDatabaseRepository->deleteFavorite($dto);
        return ['success' => true, 'message' => 'GIF removed from favorites', 'status' => 204];
    }

    /**
     * Get user's favorite GIFs
     *
     * @param ListFavoriteGifsDTO $dto Data transfer object containing list parameters
     * @return FavoriteGifCollection
     */
    public function getFavorites(ListFavoriteGifsDTO $dto): FavoriteGifCollection
    {
        $favorites = $this->giphyDatabaseRepository->getFavoritesByUser($dto);
        return new FavoriteGifCollection($favorites);
    }
} 