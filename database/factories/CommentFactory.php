<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
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
            'body' => $this->faker->paragraph(10, true),
            'article_id' => Article::factory(),
            'user_id' => User::factory(),
            'status' => $this->faker->randomElement(['pending','approved']),//'pending'|'approved',
            //
        ];
    }
}
