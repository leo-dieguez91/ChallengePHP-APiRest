<?php

namespace App\Interfaces\Repositories;

use App\DTOs\Giphy\SaveFavoriteGifDTO;
use App\DTOs\Giphy\ListFavoriteGifsDTO;
use App\DTOs\Giphy\DeleteFavoriteGifDTO;
use Illuminate\Database\Eloquent\Collection;
use App\Models\FavoriteGif;

interface GiphyDatabaseInterfaceRepository
{
    /**
     * Save a GIF to user's favorites
     *
     * @param SaveFavoriteGifDTO $dto Data transfer object containing favorite gif data
     * @return FavoriteGif
     * @throws GifAlreadyInFavoritesException
     */
    public function saveFavorite(SaveFavoriteGifDTO $dto): FavoriteGif;

    /**
     * Get all favorite GIFs for a user
     *
     * @param ListFavoriteGifsDTO $dto Data transfer object containing list parameters
     * @return Collection
     */
    public function getFavoritesByUser(ListFavoriteGifsDTO $dto): Collection;

    /**
     * Delete a GIF from user's favorites
     *
     * @param DeleteFavoriteGifDTO $dto Data transfer object containing deletion parameters
     * @return void
     * @throws GifNotInFavoritesException
     */
    public function deleteFavorite(DeleteFavoriteGifDTO $dto): void;
} 