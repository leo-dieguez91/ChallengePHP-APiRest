<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteGifResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'gif_id' => $this->gif_id,
            'alias' => $this->alias,
            'user_id' => $this->user_id
        ];
    }
} 