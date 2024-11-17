<?php

namespace App\Interfaces\Services;

use App\DTOs\Giphy\SaveFavoriteGifDTO;
use App\DTOs\Giphy\DeleteFavoriteGifDTO;
use App\DTOs\Giphy\ListFavoriteGifsDTO;
use App\Http\Resources\FavoriteGifResource;
use App\Http\Resources\FavoriteGifCollection;

interface GiphyFavoriteInterfaceService
{
    /**
     * Save a GIF as favorite for a user
     *
     * @param SaveFavoriteGifDTO $dto Data transfer object containing favorite gif data
     * @return FavoriteGifResource
     */
    public function saveFavoriteGif(SaveFavoriteGifDTO $dto): FavoriteGifResource;

    /**
     * Delete a GIF from user's favorites
     *
     * @param DeleteFavoriteGifDTO $dto Data transfer object containing deletion parameters
     * @return array
     */
    public function deleteFavorite(DeleteFavoriteGifDTO $dto): array;

    /**
     * Get user's favorite GIFs
     *
     * @param ListFavoriteGifsDTO $dto Data transfer object containing list parameters
     * @return FavoriteGifCollection
     */
    public function getFavorites(ListFavoriteGifsDTO $dto): FavoriteGifCollection;
} 