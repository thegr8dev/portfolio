<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InquiryReply>
 */
class InquiryReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'inquiry_id' => \App\Models\Inquiry::factory(),
            'user_id' => \App\Models\User::factory(),
            'message' => $this->faker->paragraphs(2, true),
            'is_sent' => $this->faker->boolean(80), // 80% chance of being sent
            'sent_at' => $this->faker->optional(0.8)->dateTimeBetween('-1 week', 'now'),
        ];
    }
}
