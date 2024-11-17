<?php

namespace Database\Factories;

use App\Models\FavoriteGif;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteGifFactory extends Factory
{
    protected $model = FavoriteGif::class;

    /**
     * Define the model's default state.
     * 
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'gif_id' => $this->faker->uuid(),
            'alias' => $this->faker->word()
        ];
    }
} 