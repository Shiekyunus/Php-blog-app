<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'body' => $this->faker->paragraph(10, true),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'is_published' => $this->faker->boolean(),
        ];
    }
}
