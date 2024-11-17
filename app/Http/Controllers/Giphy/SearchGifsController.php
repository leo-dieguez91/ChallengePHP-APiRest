<?php

namespace App\Http\Controllers\Giphy;

use App\Http\Controllers\Controller;
use App\DTOs\Giphy\SearchGifDTO;
use App\Http\Requests\Giphy\SearchGifsRequest;
use App\Interfaces\Services\GiphySearchInterfaceService;

class SearchGifsController extends Controller
{
    public function __construct(
        private GiphySearchInterfaceService $giphySearchService
    ) {}

    public function __invoke(SearchGifsRequest $request)
    {
        $searchDTO = SearchGifDTO::fromRequest($request);
        return $this->giphySearchService->searchGifs($searchDTO);
    }
} 