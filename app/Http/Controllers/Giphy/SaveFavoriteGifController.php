<?php

namespace App\Http\Controllers\Giphy;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\GiphyFavoriteInterfaceService;
use App\Http\Requests\Giphy\SaveFavoriteGifRequest;
use App\DTOs\Giphy\SaveFavoriteGifDTO;

class SaveFavoriteGifController extends Controller
{
    private $giphyFavoriteService;

    public function __construct(GiphyFavoriteInterfaceService $giphyFavoriteService)
    {
        $this->giphyFavoriteService = $giphyFavoriteService;
    }

    public function __invoke(SaveFavoriteGifRequest $request)
    {
        $favoriteDTO = SaveFavoriteGifDTO::fromRequest($request, auth()->id());
        return $this->giphyFavoriteService->saveFavoriteGif($favoriteDTO);
    }
} 