<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FavoriteGifCollection extends ResourceCollection
{
    public $collects = FavoriteGifResource::class;
} 