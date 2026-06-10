<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Feedback>
 */
class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['issue','improvement','contact_author']);
        return [
            //
            'user_id' => User::factory(),
            'target_user_id' => $type == 'contact_author' ? User::factory() : null,
            'type' => $type,
            'subject' => $this->faker->sentence(),
            'message' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['open','reviewed','closed']),

        ];
    }
}
