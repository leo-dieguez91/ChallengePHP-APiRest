<?php

namespace App\Http\Responses;

use App\Http\Resources\FavoriteGifCollection;
use Illuminate\Contracts\Support\Responsable;

class ListFavoriteGifsResponse implements Responsable
{
    public function __construct(
        private readonly FavoriteGifCollection $data
    ) {}

    public function toResponse($request)
    {
        return $this->data->response()->setStatusCode(200);
    }
} 