<?php

namespace App\Repositories;

use App\Models\FavoriteGif;
use App\DTOs\Giphy\SaveFavoriteGifDTO;
use App\DTOs\Giphy\ListFavoriteGifsDTO;
use App\DTOs\Giphy\DeleteFavoriteGifDTO;
use App\Interfaces\Repositories\GiphyDatabaseInterfaceRepository;
use App\Exceptions\GifAlreadyInFavoritesException;
use App\Exceptions\GifNotInFavoritesException;
use Illuminate\Database\Eloquent\Collection;

class GiphyDatabaseRepository implements GiphyDatabaseInterfaceRepository
{
    /**
     * Save a GIF to user's favorites
     *
     * @param SaveFavoriteGifDTO $dto Data transfer object containing favorite gif data
     * @return FavoriteGif
     * @throws GifAlreadyInFavoritesException
     */
    public function saveFavorite(SaveFavoriteGifDTO $dto): FavoriteGif
    {
        if ($this->exists($dto->gifId, $dto->userId)) {
            throw new GifAlreadyInFavoritesException();
        }

        return FavoriteGif::create([
            'gif_id' => $dto->gifId,
            'alias' => $dto->alias,
            'user_id' => $dto->userId
        ]);
    }

    /**
     * Get all favorite GIFs for a user
     *
     * @param ListFavoriteGifsDTO $dto Data transfer object containing list parameters
     * @return Collection
     */
    public function getFavoritesByUser(ListFavoriteGifsDTO $dto): Collection
    {
        return FavoriteGif::where('user_id', $dto->userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Delete a GIF from user's favorites
     *
     * @param DeleteFavoriteGifDTO $dto Data transfer object containing deletion parameters
     * @return void
     * @throws GifNotInFavoritesException
     */
    public function deleteFavorite(DeleteFavoriteGifDTO $dto): void
    {
        if (!$this->exists($dto->gifId, $dto->userId)) {
            throw new GifNotInFavoritesException();
        }

        FavoriteGif::where('user_id', $dto->userId)
            ->where('gif_id', $dto->gifId)
            ->delete();
    }

    /**
     * Check if a GIF exists in user's favorites
     *
     * @param string $gifId The GIF ID to check
     * @param int $userId The user ID to check against
     * @return bool
     */
    private function exists(string $gifId, int $userId): bool
    {
        return FavoriteGif::where('gif_id', $gifId)
            ->where('user_id', $userId)
            ->exists();
    }
} 