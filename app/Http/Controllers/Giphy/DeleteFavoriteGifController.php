<?php

namespace App\Http\Controllers\Giphy;

use App\Http\Controllers\Controller;
use App\DTOs\Giphy\DeleteFavoriteGifDTO;
use App\Interfaces\Services\GiphyFavoriteInterfaceService;
use App\Http\Responses\DeleteFavoriteGifResponse;

class DeleteFavoriteGifController extends Controller
{
    private $giphyFavoriteService;

    public function __construct(GiphyFavoriteInterfaceService $giphyFavoriteService)
    {
        $this->giphyFavoriteService = $giphyFavoriteService;
    }

    public function __invoke(string $gifId)
    {
        $dto = DeleteFavoriteGifDTO::fromRequest(auth()->id(), $gifId);
        $result = $this->giphyFavoriteService->deleteFavorite($dto);
        return new DeleteFavoriteGifResponse($result);
    }
} 