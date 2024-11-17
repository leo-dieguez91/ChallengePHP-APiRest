<?php

namespace App\Http\Controllers\Giphy;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\GiphyFavoriteInterfaceService;
use App\DTOs\Giphy\ListFavoriteGifsDTO;
use App\Http\Responses\ListFavoriteGifsResponse;

class ListFavoriteGifsController extends Controller
{
    private $giphyFavoriteService;

    public function __construct(GiphyFavoriteInterfaceService $giphyFavoriteService)
    {
        $this->giphyFavoriteService = $giphyFavoriteService;
    }

    public function __invoke()
    {
        $dto = ListFavoriteGifsDTO::fromRequest(auth()->id());
        $result = $this->giphyFavoriteService->getFavorites($dto);
        return new ListFavoriteGifsResponse($result);
    }
} 