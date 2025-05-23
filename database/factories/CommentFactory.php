<?php

namespace Database\Factories;

use App\Models\{
    Post,
    User
};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all('id')->random()->id,
            'post_id' => Post::all('id')->random()->id,
            'comment' => fake()->sentence(20)
        ];
    }
}
