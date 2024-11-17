<?php

namespace App\Http\Controllers\Giphy;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\GiphyShowInterfaceService;
use App\Http\Requests\Giphy\ShowGifRequest;
use App\DTOs\Giphy\ShowGifDTO;

class ShowGifController extends Controller
{
    private $giphyShowService;

    public function __construct(GiphyShowInterfaceService $giphyShowService)
    {
        $this->giphyShowService = $giphyShowService;
    }

    public function __invoke(ShowGifRequest $request, string $id)
    {
        $showDTO = ShowGifDTO::fromRequest($id);
        return $this->giphyShowService->getGifById($showDTO);
    }
} 